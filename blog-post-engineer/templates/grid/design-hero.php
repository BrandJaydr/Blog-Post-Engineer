<?php
/**
 * Grid Template Hero - Featured Post Hero Layout
 * 
 * @package Blog Designer Pack
 * @since 4.0.11
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;

// Post Meta Data
$meta_data = array(
				'author'	=> $atts['show_author'],
				'post_date'	=> $atts['show_date'],
				'comments' 	=> $atts['show_comments'],
			);
$link_target = ( $atts['link_behaviour'] === 'new' ) ? ' target="_blank" rel="noopener"' : '';

// Check if this is the first post (hero)
$is_hero = ( $atts['count'] == 1 );
?>
<div class="bdpp-post-grid bdpp-post-grid-<?php echo $is_hero ? 'hero' : 'compact'; ?> <?php echo esc_attr( $atts['wrp_cls'] ); ?>">
	<?php if ( $atts['feat_img'] ) { ?>
	<div class="bdpp-post-img-bg <?php echo $is_hero ? 'bdpp-post-img-bg-hero' : ''; ?>" style="background-image: url('<?php echo esc_url( $atts['feat_img'] ); ?>');">
		<a href="<?php echo esc_url( $atts['post_link'] ); ?>"<?php echo $link_target; ?> class="bdpp-post-linkoverlay"></a>
		
		<?php if( $is_hero ) { ?>
		<div class="bdpp-post-overlay bdpp-post-overlay-hero">
			<div class="bdpp-post-overlay-content">
				<?php if( $atts['show_category'] && $atts['cate_name'] ) { ?>
				<div class="bdpp-post-cats"><?php echo wp_kses_post( $atts['cate_name'] ); ?></div>
				<?php } ?>

				<h2 class="bdpp-post-title">
					<a href="<?php echo esc_url( $atts['post_link'] ); ?>"<?php echo $link_target; ?>><?php the_title(); ?></a>
				</h2>

				<?php if( $atts['show_date'] ) { ?>
				<div class="bdpp-post-meta bdpp-post-meta-up">
					<?php echo bdp_post_meta_data( array('post_date' => true) ); ?>
				</div>
				<?php }
				
				if( $atts['show_content'] ) { ?>
				<div class="bdpp-post-content">
					<div class="bdpp-post-desc"><?php echo bdp_get_post_excerpt( $post->ID, get_the_content(), $atts['content_words_limit'] ); ?></div>
					<?php if( $atts['show_read_more'] ) { ?>
						<a href="<?php echo esc_url( $atts['post_link'] ); ?>" class="bdpp-rdmr-btn"<?php echo $link_target; ?>><?php echo wp_kses_post( $atts['read_more_text'] ); ?></a>
					<?php } ?>
				</div>
				<?php } ?>
			</div>
		</div>
		<?php } ?>
	</div>
	<?php } else { ?>
	<div class="bdpp-post-grid-content bdpp-post-grid-content-compact">
		<?php if( $atts['show_category'] && $atts['cate_name'] ) { ?>
		<div class="bdpp-post-cats"><?php echo wp_kses_post( $atts['cate_name'] ); ?></div>
		<?php } ?>

		<h2 class="bdpp-post-title">
			<a href="<?php echo esc_url( $atts['post_link'] ); ?>"<?php echo $link_target; ?>><?php the_title(); ?></a>
		</h2>

		<?php if( $atts['show_date'] || $atts['show_author'] || $atts['show_comments'] ) { ?>
		<div class="bdpp-post-meta bdpp-post-meta-up">
			<?php echo bdp_post_meta_data( $meta_data ); ?>
		</div>
		<?php }

		if( $atts['show_content'] ) { ?>
		<div class="bdpp-post-content">
			<div class="bdpp-post-desc"><?php echo bdp_get_post_excerpt( $post->ID, get_the_content(), $atts['content_words_limit'] ); ?></div>
			<?php if( $atts['show_read_more'] ) { ?>
			<a href="<?php echo esc_url( $atts['post_link'] ); ?>" class="bdpp-rdmr-btn"<?php echo $link_target; ?>><?php echo wp_kses_post( $atts['read_more_text'] ); ?></a>
			<?php } ?>
		</div>
		<?php }

		if( $atts['show_tags'] && $atts['tags'] ) { ?>
		<div class="bdpp-post-meta bdpp-post-meta-down"><?php echo wp_kses_post( $atts['tags'] ); ?></div>
		<?php } ?>
	</div>
	<?php } ?>
</div>
