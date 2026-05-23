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
