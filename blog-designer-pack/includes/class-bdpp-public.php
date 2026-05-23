<?php
/**
 * Public Class
 *
 * Handles the public side functionality of plugin
 *
 * @package Blog Designer Pack
 * @since 4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class BDP_Public {

	function __construct() {

		// Load More Post via Ajax
		add_action( 'wp_ajax_bdp_load_more_posts', array($this, 'bdp_load_more_posts') );
		add_action( 'wp_ajax_nopriv_bdp_load_more_posts', array($this, 'bdp_load_more_posts') );

		// Category filtering via Ajax
		add_action( 'wp_ajax_bdpp_filter_posts', array($this, 'bdpp_filter_posts') );
		add_action( 'wp_ajax_nopriv_bdpp_filter_posts', array($this, 'bdpp_filter_posts') );
	}

	/**
	 * Load More Posts via Ajax
	 * 
	 * @since 1.0
	 */
	function bdp_load_more_posts() {

		// Taking the shortocde parameters
		$atts = json_decode( wp_unslash($_POST['shrt_param']), true );
		extract( $atts );

		// Extract post_type and taxonomy with fallbacks to constants
		$post_type = isset( $atts['post_type'] ) ? sanitize_text_field( $atts['post_type'] ) : BDP_POST_TYPE;
		$taxonomy  = isset( $atts['taxonomy'] ) ? sanitize_text_field( $atts['taxonomy'] ) : BDP_CAT;

		$result = array(
					'status'	=> 0,
					'msg'		=> esc_html__( 'Sorry, Something happened wrong.', 'blog-designer-pack' ),
				);
		$paged				= isset( $_POST['paged'] )				? bdp_clean_number( $_POST['paged'] )	: 1;
		$href				= isset( $_POST['href'] )				? bdp_clean_url( $_POST['href'] )		: '';
		$count				= isset( $count )						? $count					: 0;
		$count				= isset( $_POST['count'] )				? $_POST['count']			: $count;
		$pagination_type	= isset( $atts['pagination_type'] )		? $atts['pagination_type']	: '';
		$query_shrt			= str_replace('bdp_', 'bdpp_', $shortcode);
		$shortcode_designs 	= bdp_post_masonry_designs();
		$atts['design'] 	= ( $atts['design'] && (array_key_exists(trim($atts['design']), $shortcode_designs)) ) ? trim( $atts['design'] ) : 'design-1';
		$atts['loop_count'] = 0;

		// If valid data found
		if( ! empty( $atts ) ) {

			// Taking some globals
			global $post;

			// WP Query Parameters
			$args = array(
				'post_type'      		=> $post_type,
				'post_status' 			=> array('publish'),
				'order'					=> $order,
				'orderby'		 		=> $orderby,
				'posts_per_page' 		=> $limit,
				'paged'					=> $paged,
				'ignore_sticky_posts'	=> true,
			);

		    // Category Parameter
			if( $category ) {

				$args['tax_query'] = array(
										array( 
											'taxonomy' 	=> $taxonomy,
											'terms' 	=> $category,
											'field' 	=> ( isset($category[0]) && is_numeric($category[0]) ) ? 'term_id' : 'slug',
										));
			}

			$args = apply_filters( $query_shrt.'_query_args', $args, $atts );

			// WP Query
			$query 					= new WP_Query( $args );
			$atts['post_count']		= $query->post_count;
			$atts['max_num_pages'] 	= $query->max_num_pages;
			$atts['paged']			= $paged;

			ob_start();

			// If post is there
			if ( $query->have_posts() ) {

				while ( $query->have_posts() ) : $query->the_post();

					$count++;
					$atts['count'] 		= $count;
					$atts['loop_count']++;

					$atts['format']		= bdp_get_post_format();
					$atts['feat_img'] 	= bdp_get_post_feat_image( $post->ID, $media_size );
					$atts['post_link'] 	= bdp_get_post_link( $post->ID );
					$atts['cate_name'] 	= bdp_get_post_terms( $post->ID, $taxonomy );
					$atts['tags']  		= isset( $show_tags ) ? bdp_post_meta_data( array('tag' => $show_tags), array('tag_taxonomy' => 'post_tag') ) : '';

					$atts['wrp_cls']	= "bdpp-post-{$post->ID} bdpp-post-{$atts['format']}";
					$atts['wrp_cls']	.= ( is_sticky( $post->ID ) ) 	? ' bdpp-sticky'	: '';
					$atts['wrp_cls'] 	.= empty( $atts['feat_img'] )	? ' bdpp-no-thumb'	: ' bdpp-has-thumb';
					$atts['wrp_cls']	.= " bdpp-col-{$grid} bdpp-columns";

					// Include Dsign File
					include( BDP_DIR . "/templates/masonry/{$atts['design']}.php" );

				endwhile;

			} // end of have_post()

			wp_reset_postdata(); // Reset WP Query

			$content = ob_get_clean();

			$result['status']			= 1;
			$result['shortcode']		= $shortcode;
			$result['count']			= $count;
			$result['data']				= $content;
			$result['last_page']		= ( $paged >= $atts['max_num_pages'] ) ? 1 : 0;
			$result['msg']				= esc_html__('Success', 'blog-designer-pack');
		}

		wp_send_json( $result );
	}

	/**
	 * Category filtering via Ajax callback
	 * 
	 * @since 4.0.11
	 */
	function bdpp_filter_posts() {
		check_ajax_referer( 'bdpp_filter_nonce', 'nonce' );

		// Decode the attributes
		$atts = ! empty( $_POST['conf'] ) ? $_POST['conf'] : array();
		$cat_slug = isset( $_POST['cat'] ) ? sanitize_text_field( $_POST['cat'] ) : '';

		$design              = isset( $atts['design'] ) ? sanitize_text_field( $atts['design'] ) : 'design-1';
		$grid                = isset( $atts['grid'] ) ? intval( $atts['grid'] ) : 3;
		$media_size          = isset( $atts['media_size'] ) ? sanitize_text_field( $atts['media_size'] ) : '';
		$limit               = isset( $atts['limit'] ) ? intval( $atts['limit'] ) : 20;
		$content_words_limit = isset( $atts['content_words_limit'] ) ? intval( $atts['content_words_limit'] ) : 20;
		$show_author         = isset( $atts['show_author'] ) ? bdp_string_to_bool( $atts['show_author'] ) : true;
		$show_date           = isset( $atts['show_date'] ) ? bdp_string_to_bool( $atts['show_date'] ) : true;
		$show_category       = isset( $atts['show_category'] ) ? bdp_string_to_bool( $atts['show_category'] ) : true;
		$show_content        = isset( $atts['show_content'] ) ? bdp_string_to_bool( $atts['show_content'] ) : true;
		$show_tags           = isset( $atts['show_tags'] ) ? bdp_string_to_bool( $atts['show_tags'] ) : true;
		$show_comments       = isset( $atts['show_comments'] ) ? bdp_string_to_bool( $atts['show_comments'] ) : true;
		$show_read_more      = isset( $atts['show_read_more'] ) ? bdp_string_to_bool( $atts['show_read_more'] ) : true;
		$read_more_text      = isset( $atts['read_more_text'] ) ? sanitize_text_field( $atts['read_more_text'] ) : __( 'Read More', 'blog-designer-pack' );
		$post_type           = isset( $atts['post_type'] ) ? sanitize_text_field( $atts['post_type'] ) : BDP_POST_TYPE;
		$taxonomy            = isset( $atts['taxonomy'] ) ? sanitize_text_field( $atts['taxonomy'] ) : BDP_CAT;
		$link_behaviour      = isset( $atts['link_behaviour'] ) && $atts['link_behaviour'] === 'new' ? 'new' : 'self';
		$order               = isset( $atts['order'] ) && strtolower( $atts['order'] ) === 'asc' ? 'ASC' : 'DESC';
		$orderby             = isset( $atts['orderby'] ) ? sanitize_text_field( $atts['orderby'] ) : 'date';

		// Taking some globals
		global $post;

		// WP Query Parameters
		$args = array(
			'post_type'           => $post_type,
			'post_status'         => array('publish'),
			'order'               => $order,
			'orderby'             => $orderby,
			'posts_per_page'      => $limit,
			'ignore_sticky_posts' => true,
		);

		// Category Parameter
		if ( ! empty( $cat_slug ) ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => $taxonomy,
					'terms'    => $cat_slug,
					'field'    => is_numeric( $cat_slug ) ? 'term_id' : 'slug',
				)
			);
		}

		$args = apply_filters( 'bdpp_post_query_args', $args, $atts );

		// WP Query
		$query = new WP_Query( $args );

		ob_start();

		// If post is there
		if ( $query->have_posts() ) {
			$count = 0;
			while ( $query->have_posts() ) : $query->the_post();
				$count++;
				$atts['count']      = $count;
				$atts['format']     = bdp_get_post_format();
				$atts['feat_img']   = bdp_get_post_feat_image( $post->ID, $media_size );
				$atts['post_link']  = bdp_get_post_link( $post->ID );
				$atts['cate_name']  = ( $show_category ) ? bdp_get_post_terms( $post->ID, $taxonomy ) : '';
				$atts['tags']       = ( $show_tags ) ? bdp_post_meta_data( array('tag' => $show_tags), array('tag_taxonomy' => 'post_tag') ) : '';

				$atts['wrp_cls'] = "bdpp-col-{$grid} bdpp-columns bdpp-post-{$post->ID} bdpp-post-{$atts['format']}";
				$atts['wrp_cls'] .= ( $count % $grid == 1 ) ? ' bdpp-first' : '';
				$atts['wrp_cls'] .= empty( $atts['feat_img'] ) ? ' bdpp-no-thumb' : ' bdpp-has-thumb';

				// Set attributes needed in template
				$atts['show_author']        = $show_author;
				$atts['show_date']          = $show_date;
				$atts['show_category']      = $show_category;
				$atts['show_content']       = $show_content;
				$atts['show_tags']          = $show_tags;
				$atts['show_comments']      = $show_comments;
				$atts['show_read_more']     = $show_read_more;
				$atts['read_more_text']     = $read_more_text;
				$atts['link_behaviour']     = $link_behaviour;
				$atts['content_words_limit']= $content_words_limit;

				// Include Design File
				include( BDP_DIR . "/templates/grid/{$design}.php" );
			endwhile;
		} else {
			echo '<div class="bdpp-no-posts">' . esc_html__( 'No posts found.', 'blog-designer-pack' ) . '</div>';
		}

		wp_reset_postdata(); // Reset WP Query

		$html = ob_get_clean();

		wp_send_json_success( array( 'html' => $html ) );
	}
}

$bdp_public = new BDP_Public();