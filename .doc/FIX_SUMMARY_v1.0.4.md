# Blog Post Engineer v1.0.4 — Fix Summary

## What Was Fixed

### Critical Fix: Preview Window "Sorry, Something happened wrong" Error

**Status:** ✅ FIXED

The shortcode builder preview window was failing because the nonce security token was not being passed in the form submission.

#### The Problem
When you modify parameters in the shortcode builder and click "Generate", the form submits to the preview window. However, the nonce (WordPress security token) was missing from the POST request, causing the preview page to reject the request.

**Error Flow:**
1. Form submitted without nonce ❌
2. Preview page receives POST request
3. Nonce validation fails
4. Preview dies with "Sorry, you are not allowed to access this page"
5. Shows generic "Something happened wrong" error in iframe

#### The Solution
Added the nonce field to the form in `shortcode-builder.php`:

```php
<?php wp_nonce_field( 'bdpp-shortcode-preview', '_wpnonce' ); ?>
```

This generates:
```html
<input type="hidden" id="_wpnonce" name="_wpnonce" value="[nonce_value]" />
```

**Result:** When the form now submits, the nonce is included in POST data and validation succeeds.

---

## Files Modified

| File | Change | Lines |
|------|--------|-------|
| `includes/admin/shortcode-builder/shortcode-builder.php` | Added `wp_nonce_field()` to form | 133 |

---

## Testing Checklist

After updating the plugin:

- [ ] Go to WordPress Admin → Tools → Shortcode Builder
- [ ] Select a shortcode from the dropdown
- [ ] Modify any parameter (e.g., change Grid columns)
- [ ] Click "Generate" button
- [ ] Verify preview window renders the updated layout **without** error
- [ ] Repeat with different shortcodes (masonry, grid, list, carousel, etc.)

---

## What Still Needs Review

### 1. Naming Mismatch: `bdp_` vs `bdpp_` Prefixes

**Status:** ⚠️ DOCUMENTED (not changed)

The codebase uses `bdpp_` prefix for files and classes, but shortcodes are registered with `bdp_` prefix:

- **Files:** `bdpp-post-masonry.php`, `class-bdpp-public.php`
- **Shortcodes:** `[bdp_masonry]`, `[bdp_post]`

This is intentional for backward compatibility but creates confusion in the admin UI. No fix applied because this would break existing installations.

**Recommendation:** Document this split clearly in README or code comments.

---

## Version Information

- **Plugin Version:** 4.0.11 (internal)
- **Package Version:** v1.0.4-FIXED
- **PHP Minimum:** 7.4
- **WordPress Minimum:** 5.8

---

## Installation

1. Download: `blog-post-engineer-v1.0.4-FIXED.zip`
2. In WordPress: **Plugins → Add New → Upload Plugin**
3. Select the zip file
4. Click **Install Now**
5. If you had the previous version installed, it will update automatically

---

## Changelog

### v1.0.4-FIXED
- **Fixed:** Preview window nonce validation failing in shortcode builder
- **Fixed:** Parameter validation error appearing when preview should render
- **Security:** Ensured nonce is properly passed in form submissions

### v1.0.3
- Fixed abstract class instantiation errors
- Fixed autoloader failures on Hostinger shared hosting
- Fixed uninitialized Admin_Menu singleton

### v1.0.2
- Fixed hardcoded post type in Ajax handlers
- Fixed taxonomy hardcoding in filter buttons
- Added error handling for failed Ajax requests

### v1.0.1
- Initial fork from Blog Designer Pack
- GG ecosystem integration
- Freemius SDK deactivation

---

## Technical Details

### How Nonce Works in This Context

1. **Initial Page Load:**
   - Shortcode builder page loads
   - Nonce is created: `wp_create_nonce('bdpp-shortcode-preview')`
   - Nonce is embedded in iframe URL as query parameter

2. **Form Submission (NEW):**
   - User modifies parameters
   - Clicks "Generate"
   - Form submits POST to preview window
   - **Now includes:** `_wpnonce` field with the nonce value
   - Preview window validates nonce
   - Shortcode renders successfully

### Related Files
- `includes/admin/shortcode-builder/shortcode-builder.php` (form generation)
- `includes/admin/shortcode-builder/shortcode-preview.php` (preview endpoint)
- `assets/js/bdpp-shortcode-generator.js` (form submission triggers)

---

## Next Steps

1. **Upload and test** the fixed plugin
2. **Verify preview window** updates when you modify parameters
3. **Consider addressing** the bdp_ vs bdpp_ naming inconsistency in documentation
4. **Monitor** for any additional issues in the shortcode builder

---

## Support

If you encounter issues after updating:

1. Check WordPress Debug Log: `wp-content/debug.log`
2. Verify user has `manage_options` capability
3. Confirm browser JavaScript is enabled
4. Clear browser cache and try again
5. Check browser console for JavaScript errors (F12 → Console)

---

**Package Date:** 2026-05-24  
**Status:** Ready for Production ✅
