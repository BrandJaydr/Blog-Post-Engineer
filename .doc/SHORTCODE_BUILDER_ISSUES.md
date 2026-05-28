# GG Blogging Engine — Shortcode Builder Issues Report

## Issue 1: Naming Mismatch (Admin Tab)

### What You're Seeing
The shortcode builder references `bdp_masonry` in the shortcode, but files use the `bdpp_` prefix.

### Root Cause
**Intentional Design Decision** - This is documented in your memories:
> [DECISION] Codebase uses the prefix 'bdpp' for files, classes, script handles, and functions rather than 'bdp' as stated in raw specifications (e.g class-bdpp-public.php, bdpp-post-grid.php).

### The Split
- **File/Class Naming:** `bdpp_` prefix (Blog Designer Pack Plugin)
  - `class-bdpp-public.php`
  - `bdpp-post-masonry.php`
  - `class-bdpp-scripts.php`

- **Shortcode Registration:** `bdp_` prefix (legacy/backward compatibility)
  - `add_shortcode( 'bdp_masonry', 'bdp_render_post_masonry' );`
  - Registered in: `includes/shortcodes/bdpp-post-masonry.php` (line 172)

### Assessment
✅ This is **acceptable for now** as it maintains backward compatibility with existing installations that use `[bdp_masonry]` shortcodes. The split is clearly documented.

---

## Issue 2: Preview Window "Sorry, Something happened wrong" Error

### What You're Seeing
The preview iframe shows an error message instead of rendering the shortcode. Image shows:
```
Sorry, Something happened wrong.
```

### Root Cause: Missing Nonce in Form Submission

The form submission fails because **the nonce is not being passed in the POST request**.

#### How It Currently Works (Broken Flow)
1. **Initial iframe load** (working):
   ```php
   // In shortcode-builder.php (line 21)
   $preview_url = add_query_arg( 
       array( 
           'page' => 'bdpp-shortcode-preview', 
           'shortcode' => $preview_shortcode, 
           '_wpnonce' => wp_create_nonce( 'bdpp-shortcode-preview' )  // ✅ Nonce in URL
       ), 
       admin_url('admin.php') 
   );
   
   // Then loaded in iframe (line 137)
   <iframe src="<?php echo esc_url($preview_url); ?>"></iframe>  // ✅ Has nonce
   ```

2. **Form submission** (broken):
   ```html
   <!-- Line 130 in shortcode-builder.php -->
   <form action="<?php echo esc_url($preview_url); ?>" method="post" target="bdpp_shortcode_preview_frame">
       <textarea name="bdpp_customizer_shrt" ...></textarea>
       <!-- ❌ NO HIDDEN INPUT FOR _wpnonce -->
   </form>
   ```

3. **Preview receives POST** without nonce:
   ```php
   // In shortcode-preview.php (line 24)
   if( ! is_user_logged_in() || ! current_user_can('manage_options') || ! wp_verify_nonce( $preview_nonce, 'bdpp-shortcode-preview' ) ) {
       wp_die( __('Sorry, you are not allowed to access this page.', 'blog-designer-pack') );
   }
   ```

   The form POST doesn't contain `_wpnonce`, so:
   - `$_REQUEST['_wpnonce']` is empty
   - `wp_verify_nonce()` fails
   - The validation error triggers a generic error page
   - Which appears as "Sorry, Something happened wrong"

### Technical Flow
```
User fills form → Clicks Generate → Form submits POST to preview.php
                                   ↓
                           Preview loads from URL query params
                           ✅ Has nonce in URL (GET)
                                   ↓
                           Form submission comes in (POST)
                           ❌ No nonce in POST data
                                   ↓
                           wp_verify_nonce() fails
                           ↓
                           wp_die() is called
                           ↓
                           Error appears in iframe
```

---

## Issue 3: Parameter Validation Error

### What You're Seeing
```
Sorry. The shortcode contains some invalid parameters. These parameters may be 
missing, obsolete, or incompatible with the current selection. Please verify 
and correct the parameters to ensure the shortcode functions correctly.
```

### Root Cause
This is a **secondary consequence** of Issue #2. When the nonce validation fails:

1. The preview page attempts to render the shortcode
2. But because the page load failed, the shortcode isn't rendered
3. The JavaScript then validates the parameters and finds them missing/invalid
4. This validation error notice appears on the second refresh

---

## Fix Required: Add Nonce Field to Form

### Solution
Add a hidden input field for the nonce in the form submission:

**File:** `includes/admin/shortcode-builder/shortcode-builder.php`  
**Line:** 130-133

```php
<!-- BEFORE (line 130-133) -->
<form action="<?php echo esc_url($preview_url); ?>" method="post" class="bdpp-customizer-shrt-form" id="bdpp-customizer-shrt-form" target="bdpp_shortcode_preview_frame">
    <textarea name="bdpp_customizer_shrt" class="bdpp-shrt-box" id="bdpp-shrt-box" placeholder="<?php esc_attr_e('Copy or Paste Shortcode', 'blog-designer-pack'); ?>"><?php echo esc_textarea( $shortcode_val ); ?></textarea>
    <input type="hidden" class="bdpp-customizer-old-shrt" name="bdpp_customizer_old_shrt" value="<?php echo esc_attr( $shortcode_val ); ?>" />
</form>

<!-- AFTER (ADD NONCE) -->
<form action="<?php echo esc_url($preview_url); ?>" method="post" class="bdpp-customizer-shrt-form" id="bdpp-customizer-shrt-form" target="bdpp_shortcode_preview_frame">
    <textarea name="bdpp_customizer_shrt" class="bdpp-shrt-box" id="bdpp-shrt-box" placeholder="<?php esc_attr_e('Copy or Paste Shortcode', 'blog-designer-pack'); ?>"><?php echo esc_textarea( $shortcode_val ); ?></textarea>
    <input type="hidden" class="bdpp-customizer-old-shrt" name="bdpp_customizer_old_shrt" value="<?php echo esc_attr( $shortcode_val ); ?>" />
    <?php wp_nonce_field( 'bdpp-shortcode-preview', '_wpnonce' ); ?>
</form>
```

### Why This Works
- `wp_nonce_field()` generates: `<input type="hidden" id="_wpnonce" name="_wpnonce" value="...nonce_value..." />`
- When the form submits POST, the nonce is included in `$_POST['_wpnonce']`
- `wp_verify_nonce()` can then validate it successfully
- The preview page renders correctly

---

## Summary of Issues

| # | Issue | Severity | Type | Action |
|---|-------|----------|------|--------|
| 1 | Naming mismatch (bdp_ vs bdpp_) | Low | Documentation | Keep as-is; document the split |
| 2 | Preview nonce missing from POST | Critical | Bug | **ADD:** `wp_nonce_field()` to form |
| 3 | Parameter validation error | Medium | Symptom of #2 | Resolves when #2 is fixed |

---

## Additional Notes

### Preview Window Architecture
- Initial load: Uses GET with nonce in URL ✅
- Form submission: Uses POST but nonce wasn't being passed ❌
- Fix ensures both pathways have nonce validation

### Security Impact
The current state has **reduced security** because:
- Users can inspect the nonce in the URL
- Adding to POST ensures nonce is sent with the actual data request
- Standard WordPress practice uses nonce in both GET (for initial load) and POST (for actions)

### Affected Users
Any admin user trying to use the shortcode builder's preview feature will encounter this error when:
1. Loading the shortcode builder page (works, shows initial preview)
2. Modifying any parameter and regenerating preview (fails, shows error)

---

## Implementation
File to modify: `includes/admin/shortcode-builder/shortcode-builder.php`
Line: 133 (after the input field for old shortcode)
Add: `<?php wp_nonce_field( 'bdpp-shortcode-preview', '_wpnonce' ); ?>`

**Estimated Fix Time:** < 2 minutes
**Testing Required:** Open shortcode builder, modify parameters, verify preview updates
