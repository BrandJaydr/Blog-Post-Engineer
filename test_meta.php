<?php
function bdp_post_lite_shortcode_fields( $shortcode = '' ) {
	$fields = array(
			// General Settings
			'general' => array(
					'title'		=> __('General & Designs', 'blog-designer-pack'),
					'params'	=>  array(
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Design', 'blog-designer-pack' ),
											'name' 		=> 'design',
											'value' 	=> bdp_post_designs(),
											'desc' 		=> __( 'Choose layout design.', 'blog-designer-pack' ),
										),
										array(
											'type' 			=> 'dropdown',
											'heading' 		=> __( 'Grid', 'blog-designer-pack' ),
											'name' 			=> 'grid',
											'value' 		=> array(
																	'1'	 => __( 'Grid 1', 'blog-designer-pack' ),
																	'2'	 => __( 'Grid 2', 'blog-designer-pack' ),
																	'3'	 => __( 'Grid 3', 'blog-designer-pack' ),
																	'4'	 => __( 'Grid 4', 'blog-designer-pack' ),
																	'5'	 => __( 'Grid 5', 'blog-designer-pack' ),
																	'6'	 => __( 'Grid 6', 'blog-designer-pack' ),
																	'7'	 => __( 'Grid 7', 'blog-designer-pack' ),
																	'8'	 => __( 'Grid 8', 'blog-designer-pack' ),
																	'9'	 => __( 'Grid 9', 'blog-designer-pack' ),
																	'10' => __( 'Grid 10', 'blog-designer-pack' ),
																	'11' => __( 'Grid 11', 'blog-designer-pack' ),
																	'12' => __( 'Grid 12', 'blog-designer-pack' ),
																),
											'default'		=> 3,
											'desc' 			=> __( 'Choose number of column to be displayed.', 'blog-designer-pack' ),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Image Size', 'blog-designer-pack' ),
											'name' 			=> 'media_size',
											'value' 		=> 'large',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Choose WordPress registered image size. e.g.', 'blog-designer-pack' ).' bdpp-medium, thumbnail, medium, large, full.',
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'CSS Class', 'blog-designer-pack' ),
											'name' 			=> 'css_class',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter an extra CSS class for design customization.', 'blog-designer-pack' ) . '<label title="'.esc_attr__('Extra class will be added at top most parent so using extra class you customize your design.', 'blog-designer-pack').'"> [?]</label>',
										),
									)
			),

			// Meta Fields
// 			'meta' => array(
// 					'title'     => __('Meta & Content', 'blog-designer-pack'),
// 					'params'   	=>  array(
// 										array(
// 											'type' 			=> 'dropdown',
// 											'heading' 		=> __( 'Show Post Date', 'blog-designer-pack' ),
// 											'name' 			=> 'show_date',
// 											'value' 		=> array( 
// 																	'true'	=> __( 'True', 'blog-designer-pack' ),
// 																	'false'	=> __( 'False', 'blog-designer-pack' ),
// 																),
// 											'desc' 			=> __( 'Display post date.', 'blog-designer-pack' ),
// 										),
// 										array(
// 											'type' 			=> 'dropdown',
// 											'heading' 		=> __( 'Show Author', 'blog-designer-pack' ),
// 											'name' 			=> 'show_author',
// 											'value' 		=> array( 
// 																	'true'	=> __( 'True', 'blog-designer-pack' ),
// 																	'false'	=> __( 'False', 'blog-designer-pack' ),
// 																),
// 											'desc' 			=> __( 'Display post author.', 'blog-designer-pack' ),
// 										),
// 										array(
// 											'type' 			=> 'dropdown',
// 											'heading' 		=> __( 'Show Tags', 'blog-designer-pack' ),
// 											'name' 			=> 'show_tags',
// 											'value' 		=> array( 
// 																	'true'		=> __( 'True', 'blog-designer-pack' ),
// 																	'false'		=> __( 'False', 'blog-designer-pack' ),
// 																),
// 											'desc' 			=> __( 'Display post tags.', 'blog-designer-pack' ),
// 										),
// 										array(
// 											'type' 			=> 'dropdown',
// 											'heading' 		=> __( 'Show Comments Count', 'blog-designer-pack' ),
// 											'name' 			=> 'show_comments',
// 											'value' 		=> array(
// 																	'true'		=> __( 'True', 'blog-designer-pack' ),
// 																	'false'		=> __( 'False', 'blog-designer-pack' ),
// 																),
// 											'desc' 			=> __( 'Display post comment count.', 'blog-designer-pack' ),
// 										),
// 										array(
// 											'type' 			=> 'dropdown',
// 											'heading' 		=> __( 'Show Category', 'blog-designer-pack' ),
// 											'name' 			=> 'show_category',
// 											'value' 		=> array( 
// 																	'true'		=> __( 'True', 'blog-designer-pack' ),
// 																	'false'		=> __( 'False', 'blog-designer-pack' ),
// 																),
// 											'desc' 			=> __( 'Display post category.', 'blog-designer-pack' ),
// 										),
// 										array(
// 											'type' 			=> 'dropdown',
// 											'heading' 		=> __( 'Show Content', 'blog-designer-pack' ),
// 											'name' 			=> 'show_content',
// 											'value' 		=> array( 
// 																	'true'	=> __( 'True', 'blog-designer-pack' ),
// 																	'false'	=> __( 'False', 'blog-designer-pack' ),
// 																),
// 											'desc' 			=> __( 'Display post content.', 'blog-designer-pack' ),
// 										),
// 										array(
// 											'type' 			=> 'number',
// 											'heading' 		=> __( 'Content Word Limit', 'blog-designer-pack' ),
// 											'name' 			=> 'content_words_limit',
// 											'value' 		=> 20,
// 											'desc' 			=> __( 'Enter content word limit.', 'blog-designer-pack' ),
// 											'dependency' 	=> array(
// 																	'element' 	=> 'show_content',
// 																	'value' 	=> array( 'true' ),
// 																),
// 										),
// 										array(
// 											'type' 			=> 'dropdown',
// 											'heading' 		=> __( 'Show Read More', 'blog-designer-pack' ),
// 											'name' 			=> 'show_read_more',
// 											'value' 		=> array(
// 																	'true'	=> __( 'True', 'blog-designer-pack' ),
// 																	'false'	=> __( 'False', 'blog-designer-pack' ),
// 																),
// 											'desc' 			=> __( 'Show read more.', 'blog-designer-pack' ),
// 											'dependency' 	=> array(
// 																	'element' 	=> 'show_content',
// 																	'value' 	=> array( 'true' ),
// 																),
// 										),
// 										array(
// 											'type' 			=> 'text',
// 											'heading' 		=> __( 'Read More Text', 'blog-designer-pack' ),
// 											'name' 			=> 'read_more_text',
// 											'value' 		=> __( 'Read More', 'blog-designer-pack' ),
// 											'desc' 			=> __( 'Enter read more text.', 'blog-designer-pack' ),
// 											'refresh_time'	=> 1000,
// 											'dependency' 	=> array(
// 																	'element' 	=> 'show_read_more',
// 																	'value' 	=> array( 'true' ),
// 																),
// 										),
// 										array(
// 										array(
// 											'type' 			=> 'dropdown',
// 											'heading' 		=> __( 'Show Sub Title', 'blog-designer-pack' ),
// 											'name' 			=> 'show_sub_title',
// 											'value' 		=> array( 
// 																	'true'	=> __( 'True', 'blog-designer-pack' ),
// 																	'false'	=> __( 'False', 'blog-designer-pack' ),
// 																),
// 											'desc' 			=> __( 'Display sub title or not.', 'blog-designer-pack' ) . '<label title="'.esc_attr__("Sub title can be added via 'Blog Designer Pack Pro - Settings' metabox from Post add / edit screen.", 'blog-designer-pack').'"> [?]</label>',
// 										),
// 										array(
// 											'type' 		=> 'dropdown',
// 											'heading' 	=> __( 'Post Link Target', 'blog-designer-pack' ),
// 											'name'		=> 'link_behaviour',
// 											'value' 	=> array(
// 																'self'	=> __( 'Same Tab', 'blog-designer-pack' ),
// 																'new'	=> __( 'New Tab', 'blog-designer-pack' ),
// 															),
// 											'desc'		=> __( 'Choose post link behaviour.', 'blog-designer-pack' ),
// 										),
// 									)
// 			),
			
			// Data Fields
			'query' => array(
					'title'		=> __('Query', 'blog-designer-pack'),
					'params'	=> array(
										array(
											'type' 			=> 'dropdown',
											'heading' 		=> __( 'Post Type', 'blog-designer-pack' ),
											'name' 			=> 'post_type',
											'class'			=> 'bdpp-post-type-sel',
											'value' 		=> bdp_get_supported_post_types(),
											'ajax'			=> true,
											'desc' 			=> sprintf( __( 'Choose registered post type. You can enable it from plugin %ssetting%s page.', 'blog-designer-pack' ), '<a href="'.esc_url( BDP_SETTING_PAGE_URL ).'" target="_blank">', '</a>' ),
										),
										array(
											'type' 			=> 'dropdown',
											'heading' 		=> __( 'Include By Category', 'blog-designer-pack' ),
											'name' 			=> 'category',
											'value' 		=> '',
											'class'			=> 'bdpp-ajax-select2 bdpp-category-sel',
											'multi'			=> true,
											'ajax'			=> true,
											'ajax_action'	=> 'bdpp_category_sugg',
											'search_msg'	=> __( 'Search category by its name, slug or ID', 'blog-designer-pack' ),
											'desc' 			=> __( 'Choose categories to display category wise posts.', 'blog-designer-pack' ),
										),
										array(
											'type' 			=> 'dropdown',
											'heading' 		=> __( 'Show Filter', 'blog-designer-pack' ),
											'name' 			=> 'show_filter',
											'value' 		=> array(
																	'true'	=> __( 'True', 'blog-designer-pack' ),
																	'false'	=> __( 'False', 'blog-designer-pack' ),
																),
											'desc' 			=> __( 'Display category filter bar above posts.', 'blog-designer-pack' ),
										),
										array(
											'type' 			=> 'dropdown',
											'heading' 		=> __( 'Filter Categories', 'blog-designer-pack' ),
											'name' 			=> 'filter_cats',
											'value' 		=> '',
											'class'			=> 'bdpp-ajax-select2 bdpp-filter-cats-sel',
											'multi'			=> true,
											'ajax'			=> true,
											'ajax_action'	=> 'bdpp_category_sugg',
											'search_msg'	=> __( 'Search category by its name, slug or ID', 'blog-designer-pack' ),
											'desc' 			=> __( 'Choose categories to display in filter bar.', 'blog-designer-pack' ),
											'dependency' 	=> array(
																	'element' 	=> 'show_filter',
																	'value' 	=> array( 'true' ),
																),
										),
										array(
											'type' 			=> 'dropdown',
											'heading' 		=> __( 'Post Order By', 'blog-designer-pack' ),
											'name' 			=> 'orderby',
											'value' 		=>  array(
																	'date' 			=> __( 'Post Date', 'blog-designer-pack' ),
																	'ID' 			=> __( 'Post ID', 'blog-designer-pack' ),
																	'author' 		=> __( 'Post Author', 'blog-designer-pack' ),
																	'title' 		=> __( 'Post Title', 'blog-designer-pack' ),
																	'name' 			=> __( 'Post Slug', 'blog-designer-pack' ),
																	'modified' 		=> __( 'Post Modified Date', 'blog-designer-pack' ),
																	'menu_order'	=> __( 'Menu Order', 'blog-designer-pack' ),
																	'parent'		=> __( 'Parent ID', 'blog-designer-pack' ),
																	'rand' 			=> __( 'Random', 'blog-designer-pack' ),
																	'comment_count'	=> __( 'Number of Comments', 'blog-designer-pack' ),
																	'relevance'		=> __( 'Relevance', 'blog-designer-pack' ),
																),
											'desc' 			=> __( 'Select order type.', 'blog-designer-pack' ),
										),
										array(
											'type' 			=> 'dropdown',
											'heading' 		=> __( 'Post Order', 'blog-designer-pack' ),
											'name' 			=> 'order',
											'value' 		=> array(
																	'desc'	=> __( 'Descending', 'blog-designer-pack' ),
																	'asc'	=> __( 'Ascending', 'blog-designer-pack' ),
																),
											'desc' 			=> __( 'Select sorting order.', 'blog-designer-pack' ),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Custom Parameter 1', 'blog-designer-pack' ),
											'name' 			=> 'custom_param_1',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Give your Query a custom unique parameter to allow server side filtering.', 'blog-designer-pack' ) . '<label title="'.esc_attr__('Note: You can customize the plugin query via Hooks and Filters with the help of this parameter.', 'blog-designer-pack').'"> [?]</label>',
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Custom Parameter 2', 'blog-designer-pack' ),
											'name' 			=> 'custom_param_2',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Give your Query a custom unique parameter to allow server side filtering.', 'blog-designer-pack' ) . '<label title="'.esc_attr__('Note: You can customize the plugin query via Hooks and Filters with the help of this parameter.', 'blog-designer-pack').'"> [?]</label>',
										),
										array(
										array(
											'type' 			=> 'dropdown',
											'heading' 		=> __( 'Taxonomy', 'blog-designer-pack' ),
											'name' 			=> 'taxonomy',
											'value' 		=> bdp_get_post_type_taxonomy( BDP_POST_TYPE ),
											'class'			=> 'bdpp-taxonomy-sel',
											'desc' 			=> __( 'Choose registered taxonomy if you want to display category wise post.', 'blog-designer-pack' ),
										),
										array(
											'type' 			=> 'dropdown',
											'heading' 		=> __( 'Cat Taxonomy', 'blog-designer-pack' ),
											'name' 			=> 'cat_taxonomy',
											'class'			=> 'bdpp-cat-taxonomy-sel',
											'value' 		=> array( '' => __('Select Taxonomy', 'blog-designer-pack') ),
											'desc' 			=> __( 'Choose a category taxonomy just to display categories as meta information.', 'blog-designer-pack' ),
										),
										array(
											'type' 			=> 'dropdown',
											'heading' 		=> __( 'Tag Taxonomy', 'blog-designer-pack' ),
											'name' 			=> 'tag_taxonomy',
											'class'			=> 'bdpp-tag-taxonomy-sel',
											'value' 		=> array( '' => __('Select Taxonomy', 'blog-designer-pack') ),
											'desc' 			=> __( 'Choose a tag taxonomy just to display tags as meta information.', 'blog-designer-pack' ),
										),
										array(
											'type'			=> 'dropdown',
											'class'			=> '',
											'heading'		=> __( 'Category Operator', 'blog-designer-pack'),
											'name'			=> 'category_operator',
											'value'			=> array( 
																	'IN'	=> __( 'IN', 'blog-designer-pack' ),
																	'AND'	=> __( 'AND', 'blog-designer-pack' ),
																),
											'desc'			=> __( 'Select category operator. Default value is IN', 'blog-designer-pack' ),
										),
										array(
											'type'			=> 'dropdown',
											'class'			=> '',
											'heading'		=> __( 'Display Child Category Posts', 'blog-designer-pack'),
											'name'			=> 'include_cat_child',
											'value'			=> array( 
																	'true'	=> __( 'True', 'blog-designer-pack' ),
																	'false'	=> __( 'False', 'blog-designer-pack' ),
																),
											'desc'			=> __( 'Whether or not to include children category posts if parent category is there.', 'blog-designer-pack' ),
										),
										array(
											'type' 			=> 'dropdown',
											'heading' 		=> __( 'Exclude By Category', 'blog-designer-pack' ),
											'name' 			=> 'exclude_cat',
											'value' 		=> array('' => __('Select Data', 'blog-designer-pack') ),
											'search_msg'	=> __( 'Search category by its name, slug or ID', 'blog-designer-pack' ),
											'desc' 			=> __( 'Choose categories to exclude posts of it. Works only if `Category` field is empty.', 'blog-designer-pack' ),
										),
										array(
											'type' 			=> 'dropdown',
											'heading' 		=> __( 'Include Post', 'blog-designer-pack' ),
											'name' 			=> 'posts',
											'value' 		=> array('' => __('Select Data', 'blog-designer-pack') ),
											'search_msg'	=> __( 'Search posts by its name, slug or ID', 'blog-designer-pack' ),
											'desc' 			=> __('Choose posts which you want to display.', 'blog-designer-pack'),
										),
										array(
											'type' 			=> 'dropdown',
											'heading' 		=> __( 'Exclude Post', 'blog-designer-pack' ),
											'name' 			=> 'hide_post',
											'value' 		=> array('' => __('Select Data', 'blog-designer-pack') ),
											'search_msg'	=> __( 'Search posts by its name, slug or ID', 'blog-designer-pack' ),
											'desc' 			=> __('Choose posts which you do not want to display.', 'blog-designer-pack'),
										),
										array(
											'type' 			=> 'dropdown',
											'heading' 		=> __( 'Include By Author', 'blog-designer-pack' ),
											'name' 			=> 'author',
											'value' 		=> array('' => __('Select Data', 'blog-designer-pack') ),
											'search_msg'	=> __( 'Search authors by its name, email or ID', 'blog-designer-pack' ),
											'desc' 			=> __( 'Choose authors to show posts associated with that.', 'blog-designer-pack' ),
										),
										array(
											'type' 			=> 'dropdown',
											'heading' 		=> __( 'Exclude By Author', 'blog-designer-pack' ),
											'name' 			=> 'exclude_author',
											'value' 		=> array('' => __('Select Data', 'blog-designer-pack') ),
											'search_msg'	=> __( 'Search authors by its name, email or ID', 'blog-designer-pack' ),
											'desc' 			=> __( 'Choose authors to hide posts associated with that. Works only if `Include Author` field is empty.', 'blog-designer-pack' ),
										),
										array(
											'type' 			=> 'dropdown',
											'heading' 		=> __( 'Show Sticky Posts', 'blog-designer-pack' ),
											'name' 			=> 'sticky_posts',
											'value' 		=> array(
																	'false'	=> __( 'False', 'blog-designer-pack' ),
																	'true'	=> __( 'True', 'blog-designer-pack' ),
																),
											'desc' 			=> __( 'Display sticky posts. This only effects the frontend.', 'blog-designer-pack' ) . '<label title="'.esc_attr__("Note: Sticky post only be displayed at front side. In preview mode sticky post will not be displayed.", 'blog-designer-pack').'"> [?]</label>',
										),
										array(
											'type' 			=> 'dropdown',
											'heading' 		=> __( 'Display Type', 'blog-designer-pack' ),
											'name' 			=> 'type',
											'value' 		=> array(
																	'' 			=> __( 'Select Type', 'blog-designer-pack' ),
																	'featured'	=> __( 'Featured', 'blog-designer-pack' ),
																	'trending'	=> __( 'Trending', 'blog-designer-pack'),
																),
											'desc' 			=> __( 'Select display type of post. Is it Featured or Trending?', 'blog-designer-pack' ) . '<label title="'.esc_attr__('Note: For trending post type make sure you have enabled the post type from Plugin Settings > Trending Post.', 'blog-designer-pack').'"> [?]</label>',
										),
										array(
											'type' 			=> 'number',
											'heading' 		=> __( 'Query Offset', 'blog-designer-pack' ),
											'name' 			=> 'query_offset',
											'value' 		=> '',
											'desc' 			=> __( 'Skip number of posts from starting.', 'blog-designer-pack' ) . '<label title="'.esc_attr__('e.g. 5 to skip over 5 posts. Note: Do not use limit=-1 and pagination=true with this.', 'blog-designer-pack').'"> [?]</label>',
										),
									)
			),

			// Data Fields
			'pagination' => array(
					'title'		=> __('Pagination', 'blog-designer-pack'),
					'params'	=> array(
										array(
											'type' 			=> 'number',
											'heading' 		=> __( 'Total Number of Post', 'blog-designer-pack' ),
											'name' 			=> 'limit',
											'value' 		=> 20,
											'min'			=> -1,
											'desc' 			=> __( 'Enter total number of post to be displayed. Enter -1 to display all.', 'blog-designer-pack' ),
										),
										array(
											'type' 			=> 'dropdown',
											'heading' 		=> __( 'Pagination', 'blog-designer-pack' ),
											'name' 			=> 'pagination',
											'value' 		=> array( 
																'true'	=> __( 'True', 'blog-designer-pack' ),
																'false'	=> __( 'False', 'blog-designer-pack' ),
															),
											'dependency' 	=> array(
																		'element' 				=> 'limit',
																		'value_not_equal_to' 	=> '-1',
																	),
											'desc' 			=> __( 'Display Pagination.', 'blog-designer-pack' ),
										),
										array(
											'type' 			=> 'dropdown',
											'heading' 		=> __( 'Pagination Type', 'blog-designer-pack' ),
											'name' 			=> 'pagination_type',
											'value' 		=> array(
																	'numeric'					=> __( 'Numeric', 'blog-designer-pack' ),
																	'numeric-ajax|disabled'		=> __( 'Numeric Ajax', 'blog-designer-pack' ),
																	'prev-next|disabled'		=> __( 'Next - Prev', 'blog-designer-pack' ),
																	'prev-next-ajax|disabled'	=> __( 'Next - Prev Ajax', 'blog-designer-pack' ),
																	'load-more|disabled'		=> __( 'Load More', 'blog-designer-pack' ),
																	'infinite|disabled'			=> __( 'Infinite Scroll', 'blog-designer-pack' ),
																),
											'desc' 			=> __( 'Choose pagination type.', 'blog-designer-pack' ),											
											'dependency' 	=> array(
																'element' 				=> 'pagination',
																'value_not_equal_to' 	=> array( 'false' ),
															),
										),
										array(
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Previous Button Text', 'blog-designer-pack' ),
											'name' 			=> 'prev_text',
											'value' 		=> '',
											'desc' 			=> __( 'Pagination previous button text. Leave it empty for default.', 'blog-designer-pack' ),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Next Button Text', 'blog-designer-pack' ),
											'name' 			=> 'next_text',
											'value' 		=> '',
											'desc' 			=> __( 'Pagination next button text. Leave it empty for default.', 'blog-designer-pack' ),
										)
									)
					)
					)
			),
			
			// Social Sharing
			'social_sharing' => array(
					'title'		=> __('Social Sharing', 'blog-designer-pack'),
					'params'	=> array(
										array(
											'type'	=> 'dropdown',
											'name'	=> 'sharing',
											'value'	=> array('' => __('No Social Sharing', 'blog-designer-pack') ),
											'desc'	=> __( 'Enable social sharing. You can enable it from plugin setting page.', 'blog-designer-pack' ) . '<label> [?]</label>',
										),
									)
			),

			// Filter Settings
			'filter' => array(
					'title'		=> __('Filter', 'blog-designer-pack'),
					'params'	=>  array(
										array(
											'type' 			=> 'dropdown',
											'heading' 		=> __( 'Enable Filter', 'blog-designer-pack' ),
											'name' 			=> 'filter',
											'value' 		=> array( 
																	'true'	=> __( 'True', 'blog-designer-pack' ),
																	'false'	=> __( 'False', 'blog-designer-pack' ),
																),
											'desc' 			=> __( 'Enable category filter.', 'blog-designer-pack' ),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Filter Design', 'blog-designer-pack' ),
											'name' 		=> 'filter_design',
											'value' 	=> array( 
																	'design-1'	=> __( 'Design 1', 'blog-designer-pack' ),
															),
											'desc' 		=> __( 'Choose filter design.', 'blog-designer-pack' ),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Filter All Text', 'blog-designer-pack' ),
											'name' 			=> 'filter_all_text',
											'value' 		=> __( 'All', 'blog-designer-pack' ),
											'desc' 			=> __( 'Enter `ALL` field text. Leave it empty to remove it.', 'blog-designer-pack' ),
											'allow_empty'	=> true,
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Filter More Text', 'blog-designer-pack' ),
											'name' 			=> 'filter_more_text',
											'value' 		=> __( 'More', 'blog-designer-pack' ),
											'desc' 			=> __( 'Enter filter `More` field text. This will be displayed when the category filter is wider than screen.', 'blog-designer-pack' ),
											'allow_empty'	=> true,
										),
										array(
											'type' 			=> 'dropdown',
											'heading' 		=> __( 'Filter Position', 'blog-designer-pack' ),
											'name' 			=> 'filter_position',
											'value' 		=> array( 
																	'top'		=> __( 'Top', 'blog-designer-pack' ),
																	'left'		=> __( 'Left', 'blog-designer-pack' ),
																	'right'		=> __( 'Right', 'blog-designer-pack' ),
																),
											'desc' 			=> __( 'Choose filter position.', 'blog-designer-pack' ),
										),
										array(
											'type' 			=> 'dropdown',
											'heading' 		=> __( 'Filter Alignment', 'blog-designer-pack' ),
											'name' 			=> 'filter_align',
											'value' 		=> array( 
																	'right'		=> __( 'Right', 'blog-designer-pack' ),
																	'left'		=> __( 'Left', 'blog-designer-pack' ),
																	'center'	=> __( 'Center', 'blog-designer-pack' ),
																),
											'desc' 			=> __( 'Choose filter alignment.', 'blog-designer-pack' ),
										),
										array(
											'type' 			=> 'number',
											'heading' 		=> __( 'Filter Responsive Screen', 'blog-designer-pack' ),
											'name' 			=> 'filter_res_screen',
											'value' 		=> 768,
											'desc' 			=> __( 'Enter filter responsive screen. Filter will be on top position below this screen resolution.', 'blog-designer-pack' ),
										),
										array(
											'type' 			=> 'number',
											'heading' 		=> __( 'Total Number of Categories', 'blog-designer-pack' ),
											'name' 			=> 'filter_cat_limit',
											'value' 		=> 10,
											'desc' 			=> __( 'Enter number of categories to display at a time. Enter 0 to display all.', 'blog-designer-pack' ),
										),
										array(
											'type' 			=> 'dropdown',
											'heading' 		=> __( 'Filter Categories Order By', 'blog-designer-pack' ),
											'name' 			=> 'filter_cat_orderby',
											'value' 		=>  array(
																	'name' 			=> __( 'Category Name', 'blog-designer-pack' ),
																	'slug' 			=> __( 'Category Slug', 'blog-designer-pack' ),
																	'term_group' 	=> __( 'Category Group', 'blog-designer-pack' ),
																	'term_id' 		=> __( 'Category ID', 'blog-designer-pack' ),
																	'id' 			=> __( 'ID', 'blog-designer-pack' ),
																	'description' 	=> __( 'Category Description', 'blog-designer-pack' ),
																	'parent'		=> __( 'Category Parent', 'blog-designer-pack' ),
																	'term_order'	=> __( 'Category Order', 'blog-designer-pack' ),
																),
											'desc' 			=> __( 'Select filter category order type.', 'blog-designer-pack' ),
										),
										array(
											'type' 			=> 'dropdown',
											'heading' 		=> __( 'Filter Categories Order', 'blog-designer-pack' ),
											'name' 			=> 'filter_cat_order',
											'value' 		=> array(
																	'asc'	=> __( 'Ascending', 'blog-designer-pack' ),
																	'desc'	=> __( 'Descending', 'blog-designer-pack' ),
																),
											'desc' 			=> __( 'Select filter category sorting order.', 'blog-designer-pack' ),
										),
										array(
											'type' 			=> 'dropdown',
											'heading' 		=> __( 'Display Child of Category', 'blog-designer-pack' ),
											'name' 			=> 'filter_cat_child_of',
											'value' 		=> array(
																	'' => __('Select Category', 'blog-designer-pack')
																),
											'search_msg'	=> __( 'Search category by its name, slug or ID', 'blog-designer-pack' ),
											'desc' 			=> __( 'Select term id to retrieve child terms of.', 'blog-designer-pack' ),
										),
										array(
											'type' 			=> 'dropdown',
											'heading' 		=> __( 'Display Parent Categories', 'blog-designer-pack' ),
											'name' 			=> 'filter_cat_parent',
											'value' 		=> array(
																	'' => __('Select Category', 'blog-designer-pack')
																),
											'search_msg'	=> __( 'Search category by its name, slug or ID', 'blog-designer-pack' ),
											'desc' 			=> __( 'Select parent term id to retrieve direct child terms of. Add 0 to display only parent categories.', 'blog-designer-pack' ),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Active Filter Category', 'blog-designer-pack' ),
											'name' 			=> 'filter_active',
											'value' 		=> '',
											'desc' 			=> __( 'Choose active category. Enter number starting form 1 OR category ID like cat-ID. Default first will be active.', 'blog-designer-pack' ),
										),
										array(
											'type' 			=> 'dropdown',
											'heading' 		=> __( 'Allow Multiple Filter Categories', 'blog-designer-pack' ),
											'name' 			=> 'filter_allow_multiple',
											'value' 		=> array( 
																	'false'	=> __( 'False', 'blog-designer-pack' ),
																	'true'	=> __( 'True', 'blog-designer-pack' ),
																),
											'desc' 			=> __( 'Allow multiple filter category selection at a time.', 'blog-designer-pack' ),
										),
										array(
											'type' 			=> 'dropdown',
											'heading' 		=> __( 'Reload Filter', 'blog-designer-pack' ),
											'name' 			=> 'filter_reload',
											'value' 		=> array( 
																	'false'	=> __( 'False', 'blog-designer-pack' ),
																	'true'	=> __( 'True', 'blog-designer-pack' ),
																),
											'desc' 			=> __( 'Reload page on filter category selection.', 'blog-designer-pack' ),
										),
									)
			),

			// Style Manager
			'style_manager' => array(
					'title'		=> __('Style Manager', 'blog-designer-pack'),
					'params'	=> array(
										array(
											'type'		=> 'dropdown',
											'name'		=> 'style_id',
											'value'		=> array('' => __('Choose Style', 'blog-designer-pack')),
											'desc'		=> __( 'Choose your created style from style manager or create a new one.', 'blog-designer-pack' ),
										)
									)
			)
		);
	return $fields;
}
