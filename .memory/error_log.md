# GG Blogging Engine — Error Log

Use this file to record runtime failures, debugging anomalies, and system exceptions during the building process.

---

## 1. Logging Standard Format

For every encountered system anomaly, use the following layout to record details:

```markdown
### [YYYY-MM-DD HH:MM:SS] - [SEVERITY] - [COMPONENT/MODULE]
*   **Description**: Detailed symptom of the failure.
*   **Trace/Log**: Stack trace, WP_DEBUG log snippet, or Console capture.
*   **Root Cause**: What triggered the failure.
*   **Resolution**: Description of the committed fix.
```

---

## 2. Active Logs

*No active logs recorded yet. Codebase is clean and validated.*

---

## 3. Reference Troubleshooting Common Patterns

### Nonce Validation Failures

* **Symptom**: Ajax request returns `403 Forbidden` or `0` body response.
* **Check**: Verify `Bdpp.filter_nonce` is correctly localized by visiting the window object in developer devtools. Confirm `wp_create_nonce` matches `check_ajax_referer` action keys exactly.

### CSS Asset Loading Overrides

* **Symptom**: Button styles or colors reverting to default theme appearances.
* **Check**: Confirm specificity overrides are correct. Prepend target elements with `.bdpp-wrap` layout qualifiers to prevent theme collisions.

---





## Double-Pass Audit Results -

### ✅ FIXED — Logic Discrepancy in Ajax Handler

**File: `class-bdpp-public.php` — `bdpp_load_more_posts()` method**

**Issue**: The Ajax handler used hardcoded `BDP_POST_TYPE` and `BDP_CAT` constants instead of dynamic values from shortcode attributes.

**Fix Applied**:
- Added extraction of `post_type` and `taxonomy` from `$atts` with fallbacks to constants (lines 39-41)
- Replaced `BDP_POST_TYPE` with dynamic `$post_type` in WP_Query args (line 65)
- Replaced `BDP_CAT` with dynamic `$taxonomy` in tax_query (line 79)
- Replaced `BDP_CAT` with dynamic `$taxonomy` in `bdp_get_post_terms()` call (line 107)

**Note**: `bdpp_filter_posts()` was already correctly implemented with dynamic values.

---

### ✅ FIXED — Filter Button Taxonomy Hardcoding

**File: `bdpp-post-grid.php` — filter button rendering (line 165)**

**Issue**: Filter buttons used hardcoded `'category'` taxonomy when retrieving term data.

**Fix Applied**: Changed to use dynamic `$atts['taxonomy']` for both `get_term()` and `get_term_by()` calls.

---

### ✅ FIXED — JavaScript Error Handling Gap

**File: `bdpp-public.js` — filter Ajax handler (lines 57-69)**

**Issue**: No user feedback when `res.success` is false.

**Fix Applied**:
- Added `else` block to display error message when Ajax succeeds but returns failure
- Enhanced `.fail()` handler to show error message in the grid area

---

### FIXED - Filter Ajax category names use dynamic taxonomy

**`class-bdpp-public.php` — `bdpp_filter_posts()` handler still uses `BDP_CAT` for category names** (line 201)

```php
$atts['cate_name'] = ( $show_category ) ? bdp_get_post_terms( $post->ID, BDP_CAT ) : '';
```

Resolution: The filter Ajax response now passes the extracted `$taxonomy` value into `bdp_get_post_terms()`, so custom taxonomy labels render correctly.

---

### FIXED - JavaScript Error Handling Gap

**File: `bdpp-public.js` — Lines 57-63**

```javascript
$.post(Bdpp.ajax_url, data, function(res) {
    if (res.success) {
        gridInner.html(res.data.html);
    }
    gridInner.css('opacity', '1');
    gridWrap.removeClass('bdpp-filter-loading');
});
```

Resolution: The filter Ajax handler now has failure handling and restores the grid loading state when the request fails.

```javascript
}).fail(function() {
    gridInner.css('opacity', '1');
    gridWrap.removeClass('bdpp-filter-loading');
});
```

Also, if `res.success` is false, the opacity still gets restored but no visible feedback is shown to the user that filtering failed.

---

### 🟢 LOW — Code Quality / Consistency

| File                   | Line | Issue                                                                                                                                                                                                                                 |
| ---------------------- | ---- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `bdpp-post-grid.php` | 183  | `$atts['cate_name']` indentation is inconsistent (uses tabs vs spaces mismatch with neighboring lines)                                                                                                                              |
| `bdpp-post-grid.php` | 156  | `$atts['link_behaviour']` is a string value in `data-conf`; this is acceptable, but slightly stylistically different from the boolean-style show flags. |

---

## 4. Fresh Assessment - New Issues Found in Repo Review

### FIXED - Production assets were stale

Files: `includes/class-bdpp-scripts.php`, `assets/js/bdpp-public.min.js`, `assets/css/bdpp-public.min.css`

Description: Production mode prefers `.min` assets, but the checked-in minified public JS/CSS do not include the new filter UI behavior or styles. The unminified files have the newer logic, so the feature set is currently split between debug and production.

Risk: High. The filter UI can silently fail on normal site loads.

Resolution: Public frontend enqueues now use the checked-in unminified `bdpp-public.css` and `bdpp-public.js`, so production loads the same filter UI behavior and CSS as the current source. A future asset build can regenerate the `.min` files if the project wants to return to minified public enqueues.

### FIXED - Public load more Ajax lacked a nonce

File: `includes/class-bdpp-public.php`

Description: `bdp_load_more_posts()` accepts `shrt_param` from `$_POST`, decodes JSON, and calls `extract()` without a nonce gate. That makes the endpoint easier to hit with malformed requests and is weaker than the newer filter endpoint.

Risk: Medium. The endpoint is public, broad, and can be spammed or malformed more easily than necessary.

Resolution: Load-more markup now emits a `bdp_load_more_nonce`, the public JS sends it with the Ajax request, and `bdp_load_more_posts()` verifies it with `check_ajax_referer()`. The handler also sanitizes the decoded shortcode configuration before use.

### FIXED - Shortcode preview auth was referer-based

File: `includes/admin/shortcode-builder/shortcode-preview.php`

Description: Preview access is granted when `HTTP_REFERER` contains an expected admin page query string. That is a weak trust signal and can be spoofed.

Risk: Medium. The surface is admin-only, but the gate should still rely on capability checks and a nonce.

Resolution: Preview URLs generated by the shortcode builder and layout editor now include a dedicated `bdpp-shortcode-preview` nonce. The preview endpoint now requires a logged-in user with `manage_options` plus a valid nonce, and no longer trusts `HTTP_REFERER`.

### FIXED - Grid Load More rendered masonry templates

File: `includes/class-bdpp-public.php`

Description: The load-more Ajax handler was reused for grid pagination, but still validated designs against the masonry registry and included `templates/masonry/{design}.php` for every request.

Risk: Medium. Grid Load More could render the wrong markup, especially for grid-only designs such as Design-3.

Resolution: The handler now selects the template directory and design registry based on the incoming shortcode. `bdp_post` requests use grid designs/templates and grid wrapper classes; masonry requests keep the existing masonry behavior.

### FIXED - Preview screen localized an incomplete `Bdpp` object

File: `includes/admin/shortcode-builder/shortcode-preview.php`

Description: The preview page does not include `filter_nonce` in the localized `Bdpp` object, so the new filter UI cannot work inside shortcode preview mode.

Risk: Medium. The preview experience will diverge from public rendering.

Resolution: The preview page now includes `filter_nonce` in the localized `Bdpp` object, matching the public enqueue behavior.

---

### 🟢 LOW — Feature Improvement Notes (Future)

1. **Filter bar "All" button locale**: The "All" text is already properly internationalized with `esc_html__()` ✅
2. **Ticker template `link_behaviour`**: The ticker `design-1.php` doesn't use `link_behaviour` on its anchor. Since tickers are purely navigational headlines this is acceptable, but could be added for consistency.
3. **Load More handler dynamic query support**: Resolved. `bdp_load_more_posts()` now reads `post_type` and `taxonomy` from shortcode config and selects grid or masonry templates based on the shortcode.

---

### Summary Action Items

| Priority    | Item                                                                                                            | File(s)                   |
| ----------- | --------------------------------------------------------------------------------------------------------------- | ------------------------- |
| Resolved | Extract `post_type` & `taxonomy` from Ajax `$atts` config | `class-bdpp-public.php` |
| Resolved | Add `post_type` & `taxonomy` to `data-conf` JSON | `bdpp-post-grid.php` |
| Resolved | Add JS `.fail()` handler for filter Ajax | `bdpp-public.js` |
| Resolved | Fix category-name taxonomy usage in filter Ajax | `class-bdpp-public.php` |
| Resolved | Apply the same dynamic query pattern to `bdp_load_more_posts()` | `class-bdpp-public.php` |
| Low | Fix indentation on line 183 | `bdpp-post-grid.php` |
