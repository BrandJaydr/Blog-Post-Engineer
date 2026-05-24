# GG Blogging Engine — Master Todo

> **Implementation Rule (from source docs):** All changes are additive. Existing shortcodes, templates, and CSS classes are not modified — new files and new parameters only. This guarantees zero regression on any live usage.

---

## ✅ PHASE 1 — Category Filter Sprint — COMPLETE

- [X] Add `filter_cats` param to `bdp_post` shortcode_atts()
- [X] Add `show_filter` param (toggle filter UI on/off)
- [X] Add Ajax action `bdpp_filter_posts` / `wp_ajax_nopriv_bdpp_filter_posts`
- [X] Render filter buttons in `bdpp-post-grid.php` with `data-cat` and `data-conf`
- [X] Write filter JS click handler in `bdpp-public.js`
- [X] Add `filter_nonce` to `wp_localize_script` in `class-bdpp-scripts.php`
- [X] Add filter bar + button CSS to `bdpp-public.css`
- [X] "All" button passes empty category — shows all posts, active state toggles

---

## 🔴 TRACK A — Unlock Existing Parameters

> **Total Est: 1–2 hrs | Blocks: CPT support for custom content types**
> Each task is 1–2 line change per shortcode file. Low risk, high value.

**Shortcode files to touch for each A-task:**

- `blog-designer-pack/includes/shortcodes/bdpp-post-grid.php`
- `blog-designer-pack/includes/shortcodes/bdpp-post-list.php`
- `blog-designer-pack/includes/shortcodes/bdpp-post-masonry.php`
- `blog-designer-pack/includes/shortcodes/bdpp-post-slider.php`
- `blog-designer-pack/includes/shortcodes/bdpp-post-carousel.php`
- `blog-designer-pack/includes/shortcodes/bdpp-post-gridbox.php`

---

- [X] **A1 — Custom Post Type (CPT) Support** | ✅ DONE

  - Added `'post_type' => 'post'` to all 6 shortcode files
  - Replaced hardcoded `BDP_POST_TYPE` with `$atts['post_type']` in all `WP_Query` `$args`
  - Result: `[bdp_post post_type="portfolio"]` now works
  - **Files:** All 6 shortcode files updated
- [X] **A2 — Custom Taxonomy & Tag Support** | ✅ DONE

  - Added `'taxonomy' => 'category'` and `'tag' => ''` to all 6 shortcode files
  - Updated all `tax_query` blocks to use `$atts['taxonomy']` instead of hardcoded `BDP_CAT`
  - Added tag `tax_query` entry for `post_tag` taxonomy when `$atts['tag']` is non-empty
  - Updated `bdp_get_post_terms()` calls to use `$atts['taxonomy']` dynamically
  - **Files:** All 6 shortcode files updated
- [X] **A3 — Link Behaviour (Open in New Tab)** | ✅ DONE

  - Added `'link_behaviour' => 'self'` to all 6 shortcode files
  - Added `$link_target` variable to all 11 template design files
  - All `<a>` tags (image, title, read more, link overlay) now conditionally include `target="_blank" rel="noopener"`
  - **Files:** `templates/grid/design-1.php`, `design-2.php`, `templates/list/design-1.php`, `design-2.php`, `templates/masonry/design-1.php`, `design-2.php`, `templates/slider/design-1.php`, `design-2.php`, `templates/carousel/design-1.php`, `design-2.php`, `templates/gridbox/design-1.php`
- [X] **A4 — Custom Read More Text** | ✅ Already existed in codebase

  - `'read_more_text' => ''` was already present in all 6 shortcode files
  - Template files already use `$atts['read_more_text']` for the read more link text
  - **Status:** Already implemented, no changes needed
- [X] **A5 — CSS Class Passthrough** | ✅ Already existed in codebase

  - `'css_class' => ''` was already present in all 6 shortcode files
  - Template files already use `$atts['css_class']` via `bdp_sanitize_html_classes()`
  - **Status:** Already implemented, no changes needed

---

## 🟠 TRACK B — New Layouts & Designs

> **Total Est: 14–19 hrs | Blocks: Design expansion**
> Each design = one self-contained PHP template file. Register by adding one entry to design registry in `bdpp-functions.php`. No other files change.

---

- [X] **B1 — Grid Design-3 (Image Card with Hover Overlay)** | ✅ DONE

  - Created `blog-designer-pack/templates/grid/design-3.php`
  - Full-height background image with dark semi-transparent overlay on hover
  - Overlay shows post title, date, category, excerpt, and read more
  - GG color scheme integration (accent #de3163, white text)
  - Cubic-bezier transitions for smooth hover effects
  - Registered in `bdpp_post_designs()` inside `bdpp-functions.php`
  - CSS styling added to `bdpp-public.css`
  - **Source:** Objectives doc — B1
- [ ] **B2 — Grid Design-4 (Minimal Text-Only Card)** | 2 hrs | 🟡 MEDIUM

  - Create `blog-designer-pack/templates/grid/design-4.php`
  - No featured image. Typography-driven: Title, category badge, date, excerpt only
  - Good for news-heavy or link-list content
  - Register in `bdpp_post_designs()` inside `bdpp-functions.php`
  - **Source:** Objectives doc — B2
- [ ] **B3 — Grid Design-5 (Horizontal Split Card)** | 3 hrs | 🟡 MEDIUM

  - Create `blog-designer-pack/templates/grid/design-5.php`
  - Image left (50%), title/meta/excerpt right (50%) in a flex row
  - Responsive: stacks vertically below 640px viewport
  - Register in `bdpp_post_designs()` inside `bdpp-functions.php`
  - **Source:** Objectives doc — B3
- [ ] **B4 — Grid-Box Design-2 Unlock** | 1 hr | 🟢 LOW

  - Create `blog-designer-pack/templates/grid-box/design-2.php`
  - BDP Pro has this but it's absent from the free codebase. Build from `design-1.php` as base
  - Register in the gridbox design registry function in `bdpp-functions.php`
  - **Source:** Objectives doc — B4
- [ ] **B5 — Timeline Layout (New Shortcode)** | 6 hrs | 🟢 LOW

  - Create new shortcode file: `blog-designer-pack/includes/shortcodes/bdpp-post-timeline.php`
  - Register shortcode as `[gg_post_timeline]`
  - Create new template directory: `blog-designer-pack/templates/timeline/`
  - Vertical timeline with alternating left/right post cards connected to a spine
  - **Source:** Objectives doc — B5, Situation Assessment — `Timeline Layout: PRO LOCKED — Not in codebase`
- [ ] **B6 — Featured Post Hero Layout** | 4 hrs | 🟡 MEDIUM

  - Create `blog-designer-pack/templates/grid/design-hero.php`
  - First post in query = large full-width hero card
  - Subsequent posts = standard compact grid cards
  - No new shortcode needed — single template file handles both zones
  - **Source:** Objectives doc — B6, Situation Assessment — `Featured / Trending Posts: PRO LOCKED`

---

## 🟡 TRACK C — Ajax Pagination

> **Total Est: 3–5 hrs | Blocks: UX improvement**
> Masonry `bdp_load_more_posts` Ajax handler already works. Same pattern needs wiring into Grid, List, and Carousel.

---

- [X] **C1 — Load More for Post Grid** | ✅ DONE

  - Modified `pagination.php` to include `bdp_post` shortcode in load more condition
  - Reused existing `bdp_load_more_posts` Ajax action and JS handler in `bdpp-public.js`
  - Verified wrapper classes match JS expectations (`bdpp-post-data-wrap`, `bdpp-post-data-inr-wrap`)
  - Grid now uses same load more button as masonry
  - **Source:** Objectives doc — C1
- [ ] **C2 — Load More for Post List** | 1 hr | 🟡 MEDIUM

  - Same pattern as C1, applied to `bdpp-post-list.php`
  - List template needs the correct wrapper class structure
  - **Source:** Objectives doc — C2
- [ ] **C3 — Infinite Scroll** | 3 hrs | 🟢 LOW

  - Add an `IntersectionObserver` in `bdpp-public.js` watching a sentinel `div.bdpp-infinite-sentinel` rendered below the grid
  - When sentinel enters viewport, fire the same `bdp_load_more_posts` Ajax action automatically
  - Page param increments on each fire
  - **Source:** Objectives doc — C3, Situation Assessment — `Infinite Scroll: PRO LOCKED — Not in codebase`

---

## 🔵 TRACK D — GG Ecosystem Integration

> **Total Est: 2–3 hrs | Blocks: Ecosystem alignment**
> Transforms the standalone plugin into a recognised GG module. All hooks no-op safely if GG core is absent.

---

- [ ] **D1 — GG Module Registration Hook** | 30 min | 🟢 LOW

  - In `blog-designer-pack.php`, on `plugins_loaded`:
    ```php
    if ( function_exists('gg_register_module') ) {
        gg_register_module('bdp-blogging', array(
            'version'      => BDP_VERSION,
            'capabilities' => array('post_grid','post_slider','category_filter'),
            'label'        => 'BDP Blogging Engine',
        ));
    }
    ```
  - Silently no-ops if GG core is absent — zero risk
  - **Source:** Objectives doc — D1, Situation Assessment § 04 GG Ecosystem Compatibility
- [X] **D2 — Strip Freemius Admin Notices** | ✅ DONE

  - Removed `bdp_premium_admin_messages()` action hook call from class-bdpp-admin.php
  - Removed Freemius pricing page menu registration (`bdpp-layouts-pricing`) from blog-designer-pack.php and class-bdpp-scripts.php
  - Kept `freemius/` directory in place (inert) to avoid breaking the include chain
  - Replaced "Upgrade to Pro" string in bdpp-admin.css with "View Details"
  - Removed transient handling for premium notice dismissal
  - **Source:** Objectives doc — D2, Situation Assessment — `sharing` and `style_id` params return `'Upgrade to pro'`
- [ ] **D3 — GG Admin Menu Integration** | 1 hr | 🟢 LOW

  - If `gg_register_admin_menu()` exists (GG core present): register BDP settings as a GG submenu
  - Fallback: retain existing standalone BDP admin menu unchanged
  - **Source:** Objectives doc — D3
- [ ] **D4 — CSS Variable Alignment** | 1 hr | 🟢 LOW

  - Replace hardcoded colour values in `bdpp-public.css` with CSS custom properties:
    - Primary/Navy `#1b2a4a` → `var(--gg-primary, #1b2a4a)`
    - Accent/Cerise `#de3163` → `var(--gg-accent, #de3163)`
    - Surface/BG → `var(--gg-surface, #f9f9f9)`
  - **Source:** Objectives doc — D4, Situation Assessment — Branding Considerations
- [ ] **D5 — Plugin Rename & Rebrand** | 30 min | 🟢 LOW

  - Update Plugin Name header: `Blog Designer Pack` → `GG Blogging Engine`
  - Update Text Domain: `blog-designer-pack` → `gg-blogging` (or `gg-post-layouts`)
  - Replace `InfornWeb` author references in plugin header
  - Register `gg_post_grid` as an alias shortcode pointing to existing handler (keep `bdp_post` alive for backward compat)
  - **Source:** Objectives doc — D5, Situation Assessment — Branding Considerations

---

## ⚪ TRACK E — Admin & UX Improvements

> **Total Est: 4–6 hrs | Blocks: Developer experience**

---

- [X] **E1 — Shortcode Generator: Add Filter Params** | ✅ DONE

  - Added `filter_cats` and `show_filter` input fields to query section in shortcode-fields.php
  - Removed `premium => true` flag from Social Sharing section
  - Removed `premium => true` flag from Style Manager section
  - **Source:** Objectives doc — E1
- [ ] **E2 — Live Preview in Shortcode Builder** | 3 hrs | 🟢 LOW

  - Add an iframe preview panel in the shortcode generator UI
  - Panel re-renders via Ajax on parameter change
  - **Source:** Objectives doc — E2
- [ ] **E3 — Settings Page: Plugin-wide Defaults** | 2 hrs | 🟢 LOW

  - WordPress Settings API page for: default grid columns, default design, default post limit
  - Reduces the verbosity needed in individual shortcode attributes
  - **File:** `blog-designer-pack/includes/admin/settings/bdpp-general-settings.php`
  - **Source:** Objectives doc — E3

---

## 📦 Existing Free Shortcodes (Inventory — no changes needed)

| Shortcode               | Status  | Notes                                                 |
| ----------------------- | ------- | ----------------------------------------------------- |
| `[bdp_post]`          | ✅ FREE | 2 designs, pagination. Category filter added Phase 1. |
| `[bdp_post_list]`     | ✅ FREE | 2 designs, standard list view.                        |
| `[bdp_masonry]`       | ✅ FREE | 2 designs. Load More Ajax already works.              |
| `[bdp_post_slider]`   | ✅ FREE | 2 designs. Owl Carousel powered.                      |
| `[bdp_post_carousel]` | ✅ FREE | 2 designs. Owl Carousel powered.                      |
| `[bdp_post_gridbox]`  | ✅ FREE | 1 design. 2nd design is Pro → Build task B4.         |
| `[bdp_ticker]`        | ✅ FREE | Horizontal and vertical ticker.                       |

---

## 🚫 Features Confirmed NOT in Free Codebase (Build from Scratch)

| Feature                   | Plan                                                  |
| ------------------------- | ----------------------------------------------------- |
| 90+ Pro Grid Designs      | Build new design-N.php files (Track B)                |
| Timeline Layout           | Build `[gg_post_timeline]` shortcode (B5)           |
| Category Grid / Slider    | Future track — not in Phase 2                        |
| Featured / Trending Posts | Hero layout template (B6)                             |
| Infinite Scroll           | IntersectionObserver implementation (C3)              |
| Social Sharing            | Freemius-gated, strip upsell only (D2)                |
| Style Manager             | Admin UI present, save/load not free — deprioritised |

---

## ⏱ Effort Summary

| Track                         | Est. Hours    | Priority  | Blocks                |
| ----------------------------- | ------------- | --------- | --------------------- |
| ✅ Phase 1 — Category Filter | ~~2 hrs~~    | DONE      | Page design work      |
| Track A — Unlock Params      | 1–2 hrs      | 🔴 HIGH   | CPT, taxonomy support |
| Track B — New Layouts        | 2–8 hrs each | 🟡 MEDIUM | Design expansion      |
| Track C — Ajax Pagination    | 3–5 hrs      | 🟡 MEDIUM | UX improvement        |
| Track D — GG Integration     | 2–3 hrs      | 🔵 LOW    | Ecosystem alignment   |
| Track E — Admin UX           | 4–6 hrs      | ⚪ LOW    | DX improvement        |







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

### ✅ FIXED — Optimization / Missing Piece

**`class-bdpp-public.php` — `bdpp_filter_posts()` handler uses dynamic taxonomy**

**Status**: Already correctly implemented. Line 163 extracts `$taxonomy` from `$atts`, and line 208 uses it in `bdp_get_post_terms()` call. No fix needed.

---

### Resolved - JavaScript Error Handling Gap

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

Resolution: The filter Ajax handler now restores the loading state on failed requests and shows visible error feedback.

```javascript
}).fail(function() {
    gridInner.css('opacity', '1');
    gridWrap.removeClass('bdpp-filter-loading');
});
```

The `res.success === false` path now displays an error message in the grid area.

---

### 🟢 LOW — Code Quality / Consistency

| File                   | Line | Issue                                                                                                                                                                                                                                 |
| ---------------------- | ---- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `bdpp-post-grid.php` | 183  | `$atts['cate_name']` indentation is inconsistent (uses tabs vs spaces mismatch with neighboring lines)                                                                                                                              |
| `bdpp-post-grid.php` | 156  | `$atts['link_behaviour']` is a string value in `data-conf`; this is acceptable, but slightly stylistically different from the boolean-style show flags. |

---

## Fresh Triage From Latest Review

- [x] Refresh or replace the public minified assets so production loads the same filter behavior and CSS as the unminified files.
- [x] Add a nonce to the load-more Ajax payload and verify it in `bdp_load_more_posts()`.
- [x] Make the shortcode preview endpoint require capability-based access plus a nonce instead of trusting `HTTP_REFERER`.
- [x] Add `filter_nonce` to the preview page's localized `Bdpp` object so filter mode works in preview.
- [x] Decide whether to keep the current public asset strategy on unminified files temporarily or regenerate the `.min` artifacts properly.
- [x] Review whether the load-more path should support grid layouts directly or be limited to masonry until the Ajax renderer is generalized.
- [ ] Audit admin shortcode builder and settings screens for stale Pro-only items that remain visible in the free fork.

### Immediate fixes completed in this pass

- [x] Switched public frontend enqueues to the checked-in unminified assets so the current filter UI ships without waiting on a minified build refresh.
- [x] Added a load-more nonce to the markup, JS payload, and server-side Ajax handler.
- [x] Added the filter nonce to the shortcode preview page's localized `Bdpp` object.
- [x] Harden preview authentication beyond referer checks.
- [x] Generalize load-more rendering for grid layouts if that feature is meant to stay available there.

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
