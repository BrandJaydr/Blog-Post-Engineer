<?php
/**
 * Timeline Shortcode
 * 
 * @package Blog Designer Pack
 * @since 4.0.11
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Timeline Shortcode Handler
 * 
 * @param array $atts Shortcode attributes
 * @return string HTML output
 */
function bdp_render_timeline( $atts ) {
	
	$atts = shortcode_atts( array(
		'design'            => 'design-1',
		'limit'             => 10,
		'category'          => '',
		'taxonomy'          => 'category',
		'orderby'           => 'date',
		'order'             => 'DESC',
		'post_type'         => 'post',
		'tag'               => '',
		'show_author'       => true,
		'show_date'         => true,
		'show_category'     => true,
		'show_content'      => true,
		'show_tags'         => 'true',
		'show_read_more'    => true,
		'read_more_text'    => __( 'Read More', 'blog-designer-pack' ),
		'content_words_limit'=> 20,
		'link_behaviour'    => 'self',
		'css_class'         => '',
	), $atts, 'gg_post_timeline' );

	// Sanitize inputs
	$atts['limit']              = intval( $atts['limit'] );
	$atts['design']             = sanitize_text_field( $atts['design'] );
	$atts['category']           = sanitize_text_field( $atts['category'] );
	$atts['taxonomy']           = sanitize_text_field( $atts['taxonomy'] );
	$atts['orderby']            = sanitize_text_field( $atts['orderby'] );
	$atts['order']              = sanitize_text_field( $atts['order'] );
	$atts['read_more_text']     = sanitize_text_field( $atts['read_more_text'] );
	$atts['content_words_limit']= intval( $atts['content_words_limit'] );
	$atts['css_class']          = bdp_sanitize_html_classes( $atts['css_class'] );
	$atts['show_author']        = bdp_string_to_bool( $atts['show_author'] );
	$atts['show_date']          = bdp_string_to_bool( $atts['show_date'] );
	$atts['show_category']      = bdp_string_to_bool( $atts['show_category'] );
	$atts['show_content']       = bdp_string_to_bool( $atts['show_content'] );
	$atts['show_read_more']     = bdp_string_to_bool( $atts['show_read_more'] );
	$atts['show_tags']         = bdp_string_to_bool( $atts['show_tags'] );
	$atts['link_behaviour']     = in_array( $atts['link_behaviour'], array( 'self', 'new' ) ) ? $atts['link_behaviour'] : 'self';

	// WP Query Parameters
	$args = array(
		'post_type'           => $atts['post_type'],
		'post_status'         => array('publish'),
		'orderby'             => $atts['orderby'],
		'order'               => $atts['order'],
		'posts_per_page'      => $atts['limit'],
		'ignore_sticky_posts' => true,
	);

	// Category Parameter
	if ( ! empty( $atts['category'] ) ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => $atts['taxonomy'],
				'terms'    => $atts['category'],
				'field'    => is_numeric( $atts['category'] ) ? 'term_id' : 'slug',
			)
		);
	}

	// Tag Parameter
	if ( $atts['tag'] ) {
		$args['tax_query'][] = array(
			'taxonomy' => 'post_tag',
			'terms'    => array( $atts['tag'] ),
			'field'    => ( is_numeric( $atts['tag'] ) ) ? 'term_id' : 'slug',
		);
	}

	$args = apply_filters( 'bdpp_timeline_query_args', $args, $atts );

	// WP Query
	$query = new WP_Query( $args );

	ob_start();

	if ( $query->have_posts() ) {
		$count = 0;
		?>
		<div class="bdpp-timeline-wrap <?php echo esc_attr( $atts['css_class'] ); ?>">
			<div class="bdpp-timeline-spine"></div>
			<?php
			while ( $query->have_posts() ) : $query->the_post();
				$count++;
				$position = ( $count % 2 == 0 ) ? 'right' : 'left';
				$atts['count'] = $count;
				$atts['format'] = bdp_get_post_format();
				$atts['feat_img'] = bdp_get_post_feat_image( get_the_ID(), 'medium' );
				$atts['post_link'] = bdp_get_post_link( get_the_ID() );
				$atts['cate_name'] = ( $atts['show_category'] ) ? bdp_get_post_terms( get_the_ID(), $atts['taxonomy'] ) : '';
				$atts['tags'] = bdp_post_meta_data( array('tag' => $atts['show_tags']), array('tag_taxonomy' => 'post_tag') );
				$atts['wrp_cls'] = "bdpp-timeline-item bdpp-timeline-{$position}";
				
				// Include Design File
				include( BDP_DIR . "/templates/timeline/{$atts['design']}.php" );
			endwhile;
			?>
		</div>
		<?php
	} else {
		echo '<div class="bdpp-no-posts">' . esc_html__( 'No posts found.', 'blog-designer-pack' ) . '</div>';
	}

	wp_reset_postdata();

	return ob_get_clean();
}
add_shortcode( 'gg_post_timeline', 'bdp_render_timeline' );
