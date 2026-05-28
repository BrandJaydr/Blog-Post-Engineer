<?php
/**
 * 'bdp_post' Post Grid Shortcode
 * 
 * @package Blog Designer Pack
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Function to handle the `bdp_post` shortcode
 * 
 * @since 1.0
 */
function bdp_render_post_grid( $atts, $content = null ) {

	// Taking some globals
	global $post, $multipage, $bdpp_layout_id;

	// Shortcode Parameters
	$atts = shortcode_atts(array(
		'limit' 				=> bdp_get_default_param( 'default_post_limit', 20 ),
		'category' 				=> array(),
		'grid' 					=> bdp_get_default_param( 'default_grid_cols', 3 ),
		'design' 				=> bdp_get_default_param( 'default_design', 'design-1' ),
		'show_author' 			=> 'true',
		'show_tags'				=> 'true',
		'show_comments'			=> 'true',
		'show_category' 		=> 'true',
		'show_content' 			=> 'true',
		'show_date' 			=> 'true',
		'pagination' 			=> 'true',
		'media_size' 			=> '',
		'content_words_limit' 	=> 20,
		'show_read_more' 		=> 'true',
		'read_more_text'		=> '',
		'order'					=> 'DESC',
		'orderby'				=> 'date',
		'css_class'				=> '',
		'show_filter'           => 'false',
		'filter_cats'           => '',
		'post_type'				=> 'post',
		'taxonomy'				=> 'category',
		'tag'					=> '',
		'link_behaviour'		=> 'self',
		'infinite_scroll'		=> 'false',
		'custom_param_1'		=> '',	// Custom Param Passed Just for Developer
		'custom_param_2'		=> '',
	), $atts, 'bdp_post');

	$shortcode_designs 				= bdp_post_designs();
	$atts['shortcode']				= 'bdp_post';
	$atts['layout_id']				= $bdpp_layout_id;
	$atts['limit'] 					= bdp_clean_number( $atts['limit'], 20, 'number' );
	$atts['grid']					= bdp_clean_number( $atts['grid'], 1 );
	$atts['grid']					= ( $atts['grid'] <= 12 ) ? $atts['grid'] : 3;
	$atts['show_author'] 			= bdp_string_to_bool( $atts['show_author']  );
	$atts['show_tags'] 				= bdp_string_to_bool( $atts['show_tags'] );
	$atts['show_comments'] 			= bdp_string_to_bool( $atts['show_comments'] );
	$atts['show_date'] 				= bdp_string_to_bool( $atts['show_date'] );
	$atts['show_category'] 			= bdp_string_to_bool( $atts['show_category'] );
	$atts['show_content'] 			= bdp_string_to_bool( $atts['show_content'] );
	$atts['pagination'] 			= bdp_string_to_bool( $atts['pagination'] );
	$atts['show_read_more'] 		= bdp_string_to_bool( $atts['show_read_more'] );
	$atts['category'] 				= bdp_maybe_explode( $atts['category'] );
	$atts['media_size'] 			= ! empty( $atts['media_size'] )			? $atts['media_size'] 						: '';
	$atts['media_size']				= ( $atts['grid'] > 1 && empty($atts['media_size']) ) ? 'bdpp-medium' 					: $atts['media_size'];
	$atts['content_words_limit'] 	= ! empty( $atts['content_words_limit'] ) 	? $atts['content_words_limit'] 				: 20;
	$atts['read_more_text']			= ! empty( $atts['read_more_text'] )		? $atts['read_more_text']					: __( 'Read More', 'blog-designer-pack' );
	$atts['order'] 					= ( strtolower($atts['order']) == 'asc' ) 	? 'ASC' 									: 'DESC';
	$atts['orderby'] 				= ! empty( $atts['orderby'] )				? $atts['orderby'] 							: 'date';
	$atts['design'] 				= ($atts['design'] && (array_key_exists(trim($atts['design']), $shortcode_designs)))	? trim($atts['design'])		: 'design-1';
	$atts['multi_page']				= ( $multipage || is_single() ) ? 1 : 0;
	$atts['unique'] 				= bdp_get_unique();
	$atts['css_class']				.= ( $atts['layout_id'] ) ? " bdpp-layout-{$atts['layout_id']}"	: '';
	$atts['css_class']				= bdp_sanitize_html_classes( $atts['css_class'] );
	$atts['show_filter'] 			= bdp_string_to_bool( $atts['show_filter'] );
	$atts['post_type'] 				= ! empty( $atts['post_type'] ) ? sanitize_text_field( $atts['post_type'] ) : 'post';
	$atts['taxonomy'] 				= ! empty( $atts['taxonomy'] ) ? sanitize_text_field( $atts['taxonomy'] ) : 'category';
	$atts['tag'] 					= ! empty( $atts['tag'] ) ? sanitize_text_field( $atts['tag'] ) : '';
	$atts['link_behaviour']			= ( $atts['link_behaviour'] === 'new' ) ? 'new' : 'self';
	$atts['filter_cats'] 			= ! empty( $atts['filter_cats'] ) ? array_map('trim', explode(',', $atts['filter_cats'])) : array();
	$atts['infinite_scroll'] 		= bdp_string_to_bool( $atts['infinite_scroll'] );
	// Pagination parameter
	if( isset( $_GET['bdpp_page'] ) || $atts['multi_page'] ) {
		$atts['paged'] = isset( $_GET['bdpp_page'] ) ? $_GET['bdpp_page'] : 1;
	} elseif ( get_query_var( 'paged' ) ) {
		$atts['paged'] = get_query_var('paged');
	} elseif ( get_query_var( 'page' ) ) {
		$atts['paged'] = get_query_var( 'page' );
	} else {
		$atts['paged'] = 1;
	}

	// Taking some variables
	$count = 0;

	// WP Query Parameters
	$args = array(
		'post_type'				=> $atts['post_type'],
		'post_status'			=> array('publish'),
		'order'					=> $atts['order'],
		'orderby'				=> $atts['orderby'],
		'posts_per_page'		=> $atts['limit'],
		'paged'					=> ( $atts['pagination'] ) ? $atts['paged'] : 1,
		'no_found_rows'			=> ( ! $atts['pagination'] ) ? true : false,
		'ignore_sticky_posts'	=> true,
	);

	// Category Parameter
	if( $atts['category'] ) {

		$args['tax_query'] = array(
								array(
									'taxonomy' 	=> $atts['taxonomy'],
									'terms' 	=> $atts['category'],
									'field' 	=> ( isset($atts['category'][0]) && is_numeric($atts['category'][0]) ) ? 'term_id' : 'slug',
								));
	}

	// Tag Parameter
	if( $atts['tag'] ) {
		$args['tax_query'][] = array(
			'taxonomy'	=> 'post_tag',
			'terms'		=> array( $atts['tag'] ),
			'field'		=> ( is_numeric( $atts['tag'] ) ) ? 'term_id' : 'slug',
		);
	}

	$args = apply_filters( 'bdpp_post_query_args', $args, $atts );

	// WP Query
	$query 					= new WP_Query( $args );
	$atts['max_num_pages'] 	= $query->max_num_pages;

	ob_start();

	// Render Category Filter Bar
	if ( $atts['show_filter'] && ! empty( $atts['filter_cats'] ) ) {
		$conf = json_encode( array(
			'design'              => $atts['design'],
			'grid'                => $atts['grid'],
			'media_size'          => $atts['media_size'],
			'limit'               => $atts['limit'],
			'content_words_limit' => $atts['content_words_limit'],
			'show_author'         => $atts['show_author'] ? 'true' : 'false',
			'show_date'           => $atts['show_date'] ? 'true' : 'false',
			'show_category'       => $atts['show_category'] ? 'true' : 'false',
			'show_content'        => $atts['show_content'] ? 'true' : 'false',
			'show_tags'           => $atts['show_tags'] ? 'true' : 'false',
			'show_comments'       => $atts['show_comments'] ? 'true' : 'false',
			'show_read_more'      => $atts['show_read_more'] ? 'true' : 'false',
			'read_more_text'      => $atts['read_more_text'],
			'post_type'           => $atts['post_type'],
			'taxonomy'            => $atts['taxonomy'],
			'link_behaviour'      => $atts['link_behaviour'],
			'order'               => $atts['order'],
			'orderby'             => $atts['orderby'],
		) );
		echo '<div class="bdpp-filter-bar" data-conf="' . esc_attr( $conf ) . '" data-unique="' . esc_attr( $atts['unique'] ) . '">';
		echo '<button class="bdpp-filter-btn active" data-cat="">' . esc_html__( 'All', 'blog-designer-pack' ) . '</button>';
		foreach ( $atts['filter_cats'] as $cat_ref ) {
			$term = is_numeric( $cat_ref ) ? get_term( (int)$cat_ref, $atts['taxonomy'] ) : get_term_by( 'slug', $cat_ref, $atts['taxonomy'] );
			if ( $term && ! is_wp_error( $term ) ) {
				echo '<button class="bdpp-filter-btn" data-cat="' . esc_attr( $term->slug ) . '">' . esc_html( $term->name ) . '</button>';
			}
		}
		echo '</div>';
	}

	// If post is there
	if ( $query->have_posts() ) {

		include( BDP_DIR . "/templates/grid/loop-start.php" );

		while ( $query->have_posts() ) : $query->the_post();

			$count++;
			$atts['count'] 		= $count;
			$atts['format']		= bdp_get_post_format();
			$atts['feat_img'] 	= bdp_get_post_feat_image( $post->ID, $atts['media_size'] );
			$atts['post_link'] 	= bdp_get_post_link( $post->ID );
		$atts['cate_name'] 	= ( $atts['show_category'] )	? bdp_get_post_terms( $post->ID, $atts['taxonomy'] ) : '';
			$atts['tags']  		= ( $atts['show_tags'] ) 		? bdp_post_meta_data( array('tag' => $atts['show_tags']), array('tag_taxonomy' => 'post_tag') ) : '';

			$atts['wrp_cls'] = "bdpp-col-{$atts['grid']} bdpp-columns bdpp-post-{$post->ID} bdpp-post-{$atts['format']}";
			$atts['wrp_cls'] .= ( $count % $atts['grid']  == 1 )	? ' bdpp-first'		: '';
			$atts['wrp_cls'] .= empty( $atts['feat_img'] )			? ' bdpp-no-thumb'	: ' bdpp-has-thumb';

			// Include Design File
			include( BDP_DIR . "/templates/grid/{$atts['design']}.php" );

		endwhile;

		include( BDP_DIR . "/templates/grid/loop-end.php" );
	}

	wp_reset_postdata(); // Reset WP Query

	$content .= ob_get_clean();
	return $content;
}

// Post Grid Shortcode
add_shortcode( 'bdp_post', 'bdp_render_post_grid' );