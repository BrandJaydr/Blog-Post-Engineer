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

## 🔴 TRACK A — Unlock Existing Parameters — COMPLETE

- [X] **A1 — Custom Post Type (CPT) Support**
- [X] **A2 — Custom Taxonomy & Tag Support**
- [X] **A3 — Link Behaviour (Open in New Tab)**
- [X] **A4 — Custom Read More Text** — Already existed in codebase
- [X] **A5 — CSS Class Passthrough** — Already existed in codebase

---

## 🟠 TRACK B — New Layouts & Designs — COMPLETE

> **Owner:** Other team members  
> **Est. Total:** 14–19 hrs

- [X] **B1 — Grid Design-3 (Hover Overlay Grid)**
- [X] **B2 — Grid Design-4 (Minimal Text-Only Card)**
- [X] **B3 — Grid Design-5 (Horizontal Split Card)**
- [X] **B4 — Grid-Box Design-2 Unlock**
- [X] **B5 — Timeline Layout (New Shortcode: `[gg_post_timeline]`)**
- [X] **B6 — Featured Post Hero Layout**
- [X] **B7 — Port existing designs to GG cubic-bezier transition standards**

---

## 🟡 TRACK C — Ajax Pagination — COMPLETE

> **Owner:** Me (track-c-ajax-pagination branch, merged to main pending PR)

- [X] **C1 — Load More for Post Grid**
- [X] **C2 — Load More for Post List**
  - Added `bdp_post_list` to load-more conditional in `templates/pagination.php`
  - Extended `class-bdpp-public.php` template dir mapping to handle `bdp_post_list` → `'list'` directory
  - Zero JS changes — existing `bdpp_load_more_pagi()` handler works generically
- [X] **C3 — Infinite Scroll**
  - New `infinite_scroll='false'` param on `bdp_post`, `bdp_post_list`, `bdp_masonry`
  - Renders `.bdpp-infinite-sentinel` div with IntersectionObserver
  - Reuses existing `bdp_load_more_posts` Ajax endpoint
  - Supports grid, list, and masonry layouts
  - Sentinel self-removes on last page
  - Spinning loader CSS with GG brand colors

---

## 🔵 TRACK D — GG Ecosystem Integration — COMPLETE

> **Est. Total:** 2–3 hrs

- [X] **D1 — GG Module Registration Hook** — Implemented in `blog-post-engineer.php` via `gg_register_module()` in `bdp_plugins_loaded()`
- [X] **D2 — Strip Freemius Admin Notices**
- [X] **D3 — GG Admin Menu Integration** | 1 hr | 🟢 LOW
  - If `gg_register_admin_menu()` exists (GG core present): register BDP settings as a GG submenu
  - Fallback: retain existing standalone BDP admin menu unchanged
- [X] **D4 — CSS Variable Alignment** | 1 hr | 🟢 LOW
  - Replace hardcoded colour values in `bdpp-public.css` with CSS custom properties:
    - Primary/Navy `#1b2a4a` → `var(--gg-primary, #1b2a4a)`
    - Accent/Cerise `#de3163` → `var(--gg-accent, #de3163)`
    - Surface/BG → `var(--gg-surface, #f9f9f9)`
- [X] **D5 — Plugin Rename & Rebrand**

  **Future Breaking Changes (Deferred):**
  - Class rename: `Blog_Designer_Pack_Lite` → `Blog_Post_Engine` (breaking)
  - Function rename: `BDP_Lite()` → `BPE()` (breaking)
  - Constants rename: `BDP_*` → `BPE_*` or `GG_*` (breaking)
  - Version bump: `4.0.11` → `1.0.0` to indicate fork (breaking)

---

## ⚪ TRACK E — Admin & UX Improvements — COMPLETE

> **Est. Total:** 4–6 hrs | Remaining: ~~5 hrs~~

- [X] **E1 — Shortcode Generator: Add Filter Params**
- [X] **E2 — Live Preview in Shortcode Builder** | 3 hrs | 🟢 LOW
  - Add an iframe preview panel in the shortcode generator UI
  - Panel re-renders via Ajax on parameter change
- [X] **E3 — Settings Page: Plugin-wide Defaults** | 2 hrs | 🟢 LOW
  - WordPress Settings API page for: default grid columns, default design, default post limit
  - Reduces the verbosity needed in individual shortcode attributes

---

## 🔴 Post-Security Audit Items

- [ ] **Issue 2 — Nonce semantics on public Ajax endpoint** — `bdpp_filter_posts` is registered for both auth'd and un-auth'd users; public nonce provides no real protection. Consider removing nonce or adding rate-limiting.
- [ ] **Issue 3 — Post type whitelist in Ajax handler** — The filter Ajax handler accepts `post_type` from user-supplied JSON with only `sanitize_text_field()`. Whitelist against `bdp_get_post_types()`.

---

## 📦 Existing Free Shortcodes — No Changes Needed

| Shortcode               | Status  | Notes                                                 |
| ----------------------- | ------- | ----------------------------------------------------- |
| `[bdp_post]`          | ✅ FREE | 5 designs (design-1 through design-5). Category filter. Infinite scroll. |
| `[bdp_post_list]`     | ✅ FREE | 2 designs. Load More Ajax now works.                  |
| `[bdp_masonry]`       | ✅ FREE | 2 designs. Load More + Infinite Scroll.               |
| `[bdp_post_slider]`   | ✅ FREE | 2 designs. Owl Carousel powered.                      |
| `[bdp_post_carousel]` | ✅ FREE | 2 designs. Owl Carousel powered.                      |
| `[bdp_post_gridbox]`  | ✅ FREE | 2 designs (design-1, design-2 now unlocked).         |
| `[bdp_ticker]`        | ✅ FREE | Horizontal and vertical ticker.                       |
| `[gg_post_grid]`      | ✅ FREE | Alias shortcode registered for GG ecosystem compat.   |
| `[gg_post_timeline]`  | ✅ NEW  | Timeline layout shortcode.                            |

---

## 🚫 Features Confirmed NOT in Free Codebase (Build from Scratch)

| Feature                   | Plan                                                  |
| ------------------------- | ----------------------------------------------------- |
| 90+ Pro Grid Designs      | Build new design-N.php files (Track B — in progress) |
| Category Grid / Slider    | Future track — not in Phase 2                        |
| Social Sharing            | Freemius-gated, strip upsell only (D2 complete)      |
| Style Manager             | Admin UI present, save/load not free — deprioritised |

---

## ⏱ Effort Summary

| Track                         | Est. Hours    | Priority  | Status                |
| ----------------------------- | ------------- | --------- | --------------------- |
| ✅ Phase 1 — Category Filter | ~~2 hrs~~    | DONE      | ✅ Complete           |
| ✅ Track A — Unlock Params   | ~~1–2 hrs~~  | DONE      | ✅ Complete           |
| ✅ Track B — New Layouts     | ~~14–19 hrs~~| 🟡 MEDIUM | ✅ Complete           |
| 🟡 Track C — Ajax Pagination | ~~3–5 hrs~~  | 🟡 MEDIUM | ✅ Complete           |
| ✅ Track D — GG Integration  | ~~2–3 hrs~~  | 🔵 LOW    | ✅ Complete           |
| ✅ Track E — Admin UX        | ~~4–6 hrs~~  | ⚪ LOW    | ✅ Complete           |