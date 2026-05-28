# GG Blogging Engine — Persisted Agent Memories

[ARCHITECTURE] The plugin is structured as a class-driven, modular WordPress freemium plugin with a clean separation between database controller query layers and visual design templates.
- Tags: stack, architecture, modularity
- Source: blog-designer-pack.php

[DECISION] Added show_filter and filter_cats parameters to bdp_post shortcode attributes and handled button rendering in the grid engine to ensure 100% backward compatibility for existing live pages.
- Tags: shortcode, attributes, backwards_compat
- Source: includes/shortcodes/bdpp-post-grid.php

[PATTERN] Code separation model: Shortcode handlers process arguments, execute queries, load wrappers (loop-start.php / loop-end.php), and loop individual post records, loading design card templates dynamically.
- Tags: template, patterns, rendering_loop
- Source: includes/shortcodes/bdpp-post-grid.php

[DECISION] Codebase uses the prefix 'bdpp' for files, classes, script handles, and functions rather than 'bdp' as stated in raw specifications (e.g. class-bdpp-public.php, bdpp-post-grid.php).
- Tags: prefix, namespace, file_structure
- Source: blog-designer-pack.php, includes/class-bdpp-public.php

[API] The public Ajax action 'bdpp_filter_posts' processes category filtering securely, validating request referrers against a localized 'bdpp_filter_nonce' token.
- Tags: api, endpoints, ajax, security
- Source: includes/class-bdpp-public.php

[CONFIG] Client-side localized parameters are gathered in a single global object 'Bdpp', mapping 'ajax_url', 'is_mobile', 'is_rtl', and the newly added 'filter_nonce' to the public context.
- Tags: script_enqueue, configurations, localization
- Source: includes/class-bdpp-scripts.php

[PATTERN] Frontend Category Filter JS binds a click delegate to '.bdpp-filter-btn', reducing the target container opacity to 0.5 to show loading, and hiding standard pagination when filtering.
- Tags: javascript, interactions, micro_animation, pagination
- Source: assets/js/bdpp-public.js

[PATTERN] Filter buttons are designed with 30px pill borders, cubic-bezier ease transitions, and soft shadow glows matching the Gorgeous Gizmos visual scheme (cerise active highlight #de3163).
- Tags: design_aesthetics, css, shadow_glow, transition
- Source: assets/css/bdpp-public.css

[PATTERN] Inputs are explicitly sanitized using sanitize_text_field() or intval(), and all HTML output variables are parsed through esc_html(), esc_attr(), or esc_js() to eliminate XSS surfaces.
- Tags: code_security, sanitization, output_escaping
- Source: includes/shortcodes/bdpp-post-grid.php, includes/class-bdpp-public.php

[DECISION] Added Load More for Post List by extending the shortcode conditional in pagination.php and the template directory mapping in class-bdpp-public.php. The existing bdpp_load_more_pagi() JS handler required zero changes because it targets generic .bdpp-post-data-wrap / .bdpp-post-data-inr-wrap classes that the list template already uses.
- Tags: track_c, ajax, pagination, list, load_more
- Source: includes/class-bdpp-public.php, templates/pagination.php

[DECISION] Infinite Scroll implemented via IntersectionObserver on a .bdpp-infinite-sentinel sentinel div. Reuses the existing bdp_load_more_posts Ajax endpoint. The sentinel carries data-paged, data-max, data-conf, and data-nonce attributes. Self-removes on reaching the last page. Supports grid, list, and masonry layouts.
- Tags: track_c, infinite_scroll, javascript, IntersectionObserver, ajax
- Source: assets/js/bdpp-public.js, templates/pagination.php

[PATTERN] Track C changes are strictly additive: new shortcode parameters (infinite_scroll), new JS handler function, new CSS block at the bottom of bdpp-public.css. No existing templates or JS functions were modified — only extended. Guarantees zero regression for live users.
- Tags: track_c, additive_patterns, backwards_compat
- Source: includes/shortcodes/bdpp-post-grid.php, assets/js/bdpp-public.js

[CONFIG] The `infinite_scroll` parameter is available on `bdp_post`, `bdp_post_list`, and `bdp_masonry` shortcodes. Default is 'false'. Usage: `[bdp_post infinite_scroll="true"]`. When enabled, the load-more button is replaced by a sentinel div.
- Tags: track_c, shortcode_parameters, configuration
- Source: includes/shortcodes/bdpp-post-grid.php, includes/shortcodes/bdpp-post-list.php, includes/shortcodes/bdpp-post-masonry.php

[COMPLETION] Track B Layouts & Design completed - Created Grid Design-5 (Horizontal Split Card), Grid-Box Design-2, Timeline Layout shortcode ([gg_post_timeline]), Featured Post Hero Layout, and ported all CSS transitions to GG cubic-bezier standard (cubic-bezier(0.4, 0, 0.2, 1)).
- Tags: track_b, completion, design, css_transitions
- Source: templates/grid/design-5.php, templates/gridbox/design-2.php, includes/shortcodes/bdpp-post-timeline.php, templates/timeline/design-1.php, templates/grid/design-hero.php, assets/css/bdpp-public.css

[DECISION] GG Admin Menu Integration - Added graceful degradation pattern in class-bdpp-admin.php. When GG core is present (gg_register_admin_menu function exists), BDP settings register as GG submenu. When GG core is absent, retains standalone BDP admin menu unchanged. Uses function_exists() check for seamless operation in both environments.
- Tags: track_d, gg_integration, admin_menu, graceful_degradation
- Source: includes/admin/class-bdpp-admin.php

[DECISION] CSS Variable Alignment - Replaced hardcoded color values in bdpp-public.css with CSS custom properties for GG theme integration. Primary/Navy #1b2a4a → var(--gg-primary, #1b2a4a), Accent/Cerise #de3163 → var(--gg-accent, #de3163), Surface/BG #f9f9f9 → var(--gg-surface, #f9f9f9). Maintains fallback values for standalone operation when GG theme variables absent.
- Tags: track_d, css_variables, gg_integration, theme_integration
- Source: assets/css/bdpp-public.css

[DECISION] Plugin-wide Defaults System - Added WordPress Settings API page for default grid columns, default design, and default post limit. Created bdpp-defaults-settings.php, added 'defaults' tab to settings, added validation function, updated bdp_default_settings() with new defaults, added bdp_get_default_param() helper function, and modified bdpp-post-grid.php shortcode to use plugin-wide defaults when parameters not provided. Reduces shortcode verbosity while maintaining backward compatibility with fallback values.
- Tags: track_e, settings_api, defaults, shortcode_parameters, user_experience
- Source: includes/admin/settings/bdpp-defaults-settings.php, includes/admin/settings/bdpp-register-settings.php, includes/bdpp-functions.php, includes/shortcodes/bdpp-post-grid.php
