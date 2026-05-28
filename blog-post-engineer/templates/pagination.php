<?php
/**
 * Pagination Template
 * 
 * @package Blog Designer Pack
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if( $atts['pagination'] && $atts['max_num_pages'] > 1 ) { ?>
	<div class="bdpp-paging bdpp-clearfix">
		<?php if( $atts['shortcode'] == 'bdp_masonry' || $atts['shortcode'] == 'bdp_post' || $atts['shortcode'] == 'bdp_post_list' ) {
			if( $atts['paged'] < $atts['max_num_pages'] ) {

				// Infinite Scroll — sentinel-based auto-load
				if ( ! empty( $atts['infinite_scroll'] ) && $atts['infinite_scroll'] ) { ?>
					<div class="bdpp-infinite-sentinel"
						data-paged="<?php echo esc_attr( $atts['paged'] ); ?>"
						data-max="<?php echo esc_attr( $atts['max_num_pages'] ); ?>"
						data-conf="<?php echo htmlspecialchars( bdp_shortcode_conf( $atts ) ); ?>"
						data-nonce="<?php echo esc_attr( wp_create_nonce( 'bdp_load_more_nonce' ) ); ?>">
						<span class="bdpp-infinite-loader"></span>
					</div>
				<?php } else { ?>

			<div class="bdpp-load-more bdpp-post-load-more bdpp-ajax-btn-style" data-conf="<?php echo htmlspecialchars( bdp_shortcode_conf( $atts ) ); ?>" data-nonce="<?php echo esc_attr( wp_create_nonce( 'bdp_load_more_nonce' ) ); ?>" data-paged="<?php echo esc_attr( $atts['paged'] ); ?>"><?php esc_html_e( 'Load More', 'blog-designer-pack' ); ?> <i class="bdpp-fa fa-solid fa-chevron-down bdpp-load-more-icon"></i> <span class="bdpp-loader"></span></div>

				<?php }
			}
		} else {

			echo bdp_pagination( array( 'paged' => $atts['paged'], 'total' => $atts['max_num_pages'], 'multi_page' => $atts['multi_page'] ), $atts );

		} ?>
	</div>
<?php } ?>