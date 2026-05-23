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

### Track B: Layouts & Design
- [x] Creation of Design-3 (Hover Overlay Grid) - HIGH PRIORITY.
- [ ] Porting existing designs to GG cubic-bezier transition standards.

### Track C: Ajax Infrastructure
- [x] Expanding Masonry "Load More" logic to Grid views.
- [ ] Category-specific filtering without page reload.

### Track D: Ecosystem Integration
- [ ] Surgical removal of Freemius SDK telemetry.
- [ ] Registration with `GG_Module_Registry`.

## Documentation
Technical findings and security audits are maintained in the `.memory/agent_journal/` directory for assistant reference.