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

## 2. Verified Resolved Issues (Audit Confirmed)

All previous fixes were verified during the 2026-05-28 code audit. Each confirmed operational:

| # | Issue | File | Status | Verified |
|---|-------|------|--------|----------|
| 1 | Ajax handler used hardcoded `BDP_POST_TYPE`/`BDP_CAT` instead of dynamic atts | `class-bdpp-public.php` | ✅ FIXED | ✅ Confirmed |
| 2 | Filter buttons used hardcoded `'category'` taxonomy | `bdpp-post-grid.php` | ✅ FIXED | ✅ Confirmed |
| 3 | Ajax filter had no `.fail()` handler or error feedback | `bdpp-public.js` | ✅ FIXED | ✅ Confirmed |
| 4 | Production `.min` assets stale — filter UI silently broken in production | `class-bdpp-scripts.php` | ✅ FIXED (use unminified) | ✅ Confirmed |
| 5 | Load-more Ajax endpoint lacked nonce | `class-bdpp-public.php` | ✅ FIXED | ✅ Confirmed (`check_ajax_referer` present) |
| 6 | Shortcode preview auth trusted `HTTP_REFERER` | `shortcode-preview.php` | ✅ FIXED | ✅ Confirmed |
| 7 | Grid Load More rendered masonry templates | `class-bdpp-public.php` | ✅ FIXED | ✅ Confirmed |
| 8 | Preview screen missing `filter_nonce` in localized `Bdpp` | `shortcode-preview.php` | ✅ FIXED | ✅ Confirmed |

---

## 3. New Issues Found (2026-05-28 Code Audit)

### [2026-05-28 14:30] - 🔴 BUG - Timeline Shortcode: Undefined array key `show_tags`

*   **Description**: `shortcode_atts()` for `[gg_post_timeline]` defined `show_author`, `show_date`, `show_category`, `show_content`, and `show_read_more` but omitted `show_tags`. Line 98 called `$atts['show_tags']` causing an `Undefined array key "show_tags"` PHP warning on every timeline render. Tags could never display.
*   **Trace/Log**: `PHP Warning: Undefined array key "show_tags" in .../bdpp-post-timeline.php on line 98`
*   **Root Cause**: Timeline shortcode was written after the Track A parameter unlock and did not include the full set of boolean toggles present in the 6 original shortcodes.
*   **Resolution**: Added `'show_tags' => 'true'` to `shortcode_atts()` default array. Commit `c8677b8`.

### [2026-05-28 14:30] - 🔴 BUG - Timeline Shortcode: Hardcoded `'post_type' => 'post'`

*   **Description**: The WP_Query args array used `'post_type' => 'post'` instead of reading from shortcode parameters. This contradicted Track A (CPT Support) which added dynamic post_type to all 6 existing shortcodes so users could do `[bdp_post post_type="portfolio"]`. The timeline silently ignored the post_type parameter.
*   **Trace/Log**: `[gg_post_timeline post_type="portfolio"]` would still query standard posts.
*   **Root Cause**: Timeline was built after Track A but did not follow the established pattern of extracting post_type from shortcode_atts.
*   **Resolution**: Added `'post_type' => 'post'` to `shortcode_atts()` and replaced hardcoded `'post'` with `$atts['post_type']` in the WP_Query args. Commit `c8677b8`.

### [2026-05-28 14:30] - 🟡 MISSING - Timeline Shortcode: No `tag` filter parameter

*   **Description**: Every other shortcode in the plugin supports tag-based filtering via a `tag=""` parameter. The timeline shortcode did not implement this, making it inconsistent with the rest of the plugin.
*   **Trace/Log**: `[gg_post_timeline tag="recipes"]` would silently ignore the tag.
*   **Root Cause**: Omission during initial timeline implementation.
*   **Resolution**: Added `'tag' => ''` to `shortcode_atts()` and appended a `tax_query` block for `post_tag` when the parameter is non-empty. Commit `c8677b8`.

### [2026-05-28 14:30] - 🟡 INCONSISTENCY - Defaults settings only consumed by grid shortcode

*   **Description**: The E3 Settings page saves `default_grid_cols`, `default_design`, and `default_post_limit` via the options framework. However, only `bdpp-post-grid.php` calls `bdp_get_default_param()` to read these values. The other 5 shortcodes (list, masonry, slider, carousel, gridbox) all use hardcoded fallbacks (`20` for limit, `design-1` for design, `3`/`2` for grid).
*   **Trace/Log**: Changing defaults in Settings → General → Plugin-wide Defaults has no effect on `[bdp_post_list]`, `[bdp_masonry]`, etc.
*   **Root Cause**: The defaults settings UI was implemented but only wired into one of six shortcode handlers.
*   **Resolution**: Documented — no fix applied as these files belong to other team members.

### [2026-05-28 14:30] - 🟢 CSS - Design-5 `.bdpp-post-img-bg` override is overly broad

*   **Description**: The Design-5 CSS selector `.bdpp-post-grid-design5 .bdpp-post-img-bg` sets `height: 100%` and `min-height: 200px`. The `.bdpp-post-img-bg` class is used globally, and future design templates could unintentionally inherit these values if placed after Design-5 in the CSS cascade.
*   **Trace/Log**: N/A — static analysis finding.
*   **Root Cause**: CSS architecture — using a generic layout class name inside a scoped selector still creates specificity coupling.
*   **Resolution**: Documented — low priority. Future designs should use their own unique class names for inner elements.

---

## 4. Known Security Debt

### [2026-05-28] - INFO - Filter nonce is public

The `bdpp_filter_posts` Ajax action is registered with both `wp_ajax_` and `wp_ajax_nopriv_` hooks. The nonce is exposed to all visitors via the global `Bdpp` JS object, making the endpoint effectively public. Acceptable for a read-only post filter. See `.doc/security_posture.md` §4A.

### [2026-05-28] - ✅ FIXED - Post type whitelist in Ajax handlers

Both `bdp_load_more_posts()` and `bdpp_filter_posts()` now validate `post_type` against registered public post types via `bdp_get_post_types()`. Non-public/private post types fall back to `BDP_POST_TYPE`. Commit `297ee21`.

---

## 5. Reference Troubleshooting Common Patterns

### Nonce Validation Failures

* **Symptom**: Ajax request returns `403 Forbidden` or `0` body response.
* **Check**: Verify `Bdpp.filter_nonce` is correctly localized by visiting the window object in developer devtools. Confirm `wp_create_nonce` matches `check_ajax_referer` action keys exactly.

### CSS Asset Loading Overrides

* **Symptom**: Button styles or colors reverting to default theme appearances.
* **Check**: Confirm specificity overrides are correct. Prepend target elements with `.bdpp-wrap` layout qualifiers to prevent theme collisions.

### Undefined Array Key Warnings

* **Symptom**: PHP warning in debug log: `Undefined array key "show_tags"` or similar.
* **Check**: Verify `shortcode_atts()` default array includes all boolean toggles referenced in the template loop. Cross-reference against an existing shortcode like `bdpp-post-grid.php` for the canonical parameter set.