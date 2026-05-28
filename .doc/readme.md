# GG Blogging Engine - Project Overview

## Core Objective
This project is a high-fidelity fork of the **Blog Designer Pack** WordPress plugin, refactored to serve as a standalone, stylized module for the **Gorgeous Gizmos (GG) ecosystem**.

## Technical Foundation
- **Base Version:** 4.0.11
- **License:** GPLv2 or later
- **Visual Standard:** Adheres to GG HSL-based color palettes and `--gg-` CSS variable conventions.

## Phase 2 Roadmap

### Track A: Query Parameters (Complete)
- [x] Implementation of dynamic `post_type` and `taxonomy` shortcode attributes.
- [x] **CRITICAL:** Refactored Ajax handlers in `class-bdpp-public.php` to remove hardcoded 'post' strings.
- [x] Fixed filter button taxonomy hardcoding in `bdpp-post-grid.php`.
- [x] Added error feedback for failed Ajax in `bdpp-public.js`.
- [x] Unlock query parameter UI fields (Taxonomy, Cat Taxonomy, Tag Taxonomy, Category Operator, Display Child Category Posts, Exclude By Category, Include Post, Exclude Post, Include By Author, Exclude By Author, Display Sticky Posts, Display Type, Query Offset).

### Track B: Layouts & Design
- [x] Creation of Design-3 (Hover Overlay Grid) - HIGH PRIORITY.
- [ ] Porting existing designs to GG cubic-bezier transition standards.

### Track C: Ajax Infrastructure
- [x] Expanding Masonry "Load More" logic to Grid views.
- [x] Category-specific filtering without page reload (bdp_filter_posts Ajax handler implemented).

### Track D: Ecosystem Integration
- [x] Surgical removal of Freemius SDK telemetry.
- [x] Plugin rename and rebrand (Blog Post Engineer).
- [x] Registration with `GG_Module_Registry` (added gg_register_module hook in bdp_plugins_loaded).

### Track E: Admin & UX Improvements
- [x] Shortcode Generator filter params
- [x] Unlock Meta & Content premium fields (Show Sub Title, Post Link Target)
- [x] Unlock Paginations premium fields (Previous/Next Button Text)
- [x] Unlock Filter section
- [x] Unlock Slider premium fields (Previous/Next Button Text)
- [x] Live preview in shortcode builder (fixed nonce verification in shortcode-preview.php)
- [ ] Settings page defaults

## Documentation
Technical findings and security audits are maintained in the `.memory/agent_journal/` directory for assistant reference.

---

## Security & Architecture Improvements (Verified)

### Shortcode Preview Authentication
- **File:** `includes/admin/shortcode-builder/shortcode-preview.php`
- **Change:** Authentication is no longer referer-based
- **Implementation:** Now requires `manage_options` capability plus `bdpp-shortcode-preview` nonce
- **Benefit:** More secure preview access control

### Grid Load More Generalization
- **File:** `includes/class-bdpp-public.php`
- **Change:** Load more handler generalized to support both grid and masonry shortcodes
- **Implementation:** Switches template directory and design registry based on shortcode type
  - `bdp_post` uses grid templates
  - `bdp_masonry` keeps its own path
- **Benefit:** Unified Ajax handler reduces code duplication

### Public Script Localization
- **File:** `includes/bdpp-functions.php`
- **Function:** `bdp_get_public_script_data()`
- **Implementation:** Centralized script data localization
- **Consumers:** Both public enqueue and preview contexts
- **Benefit:** Consistent script data across all contexts

### Load More Security Hardening
- **File:** `includes/class-bdpp-public.php`
- **Change:** Load more path hardened with nonce and explicit field parsing
- **Implementation:**
  - Added `check_ajax_referer( 'bdp_load_more_nonce', 'nonce' )`
  - Replaced `extract()` with explicit field parsing
  - Added nonce to load more button in `pagination.php`
- **Benefit:** CSRF protection and more predictable input handling