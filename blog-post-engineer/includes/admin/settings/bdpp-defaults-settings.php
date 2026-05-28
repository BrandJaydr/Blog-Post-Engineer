<?php
/**
 * Defaults Settings Page
 * 
 * @package Blog Designer Pack
 * @since 4.0.11
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function bdp_render_defaults_settings() {

	$default_grid_cols = bdp_get_option( 'default_grid_cols', 3 );
	$default_design    = bdp_get_option( 'default_design', 'design-1' );
	$default_post_limit = bdp_get_option( 'default_post_limit', 10 );
	
	// Get available designs
	$designs = bdp_post_designs();
?>
<div id="bdpp-defaults-sett-wrp" class="post-box-container bdpp-defaults-sett-wrp">
	<div class="metabox-holder">
		<div id="bdpp-defaults-sett" class="postbox bdpp-postbox">

			<div class="postbox-header">
				<h2 class="hndle">
					<span><?php esc_html_e( 'Plugin-wide Defaults', 'blog-designer-pack' ); ?></span>
				</h2>
			</div>

			<div class="inside">
				<table class="form-table bdpp-defaults-sett-tbl">
					<tbody>
						<tr>
							<th scope="row"><label for="bdpp-default-grid-cols"><?php esc_html_e( 'Default Grid Columns', 'blog-designer-pack' ); ?></label></th>
							<td>
								<select name="bdpp_opts[default_grid_cols]" class="bdpp-select" id="bdpp-default-grid-cols">
									<option value="1" <?php selected( $default_grid_cols, 1 ); ?>><?php esc_html_e( '1 Column', 'blog-designer-pack' ); ?></option>
									<option value="2" <?php selected( $default_grid_cols, 2 ); ?>><?php esc_html_e( '2 Columns', 'blog-designer-pack' ); ?></option>
									<option value="3" <?php selected( $default_grid_cols, 3 ); ?>><?php esc_html_e( '3 Columns', 'blog-designer-pack' ); ?></option>
									<option value="4" <?php selected( $default_grid_cols, 4 ); ?>><?php esc_html_e( '4 Columns', 'blog-designer-pack' ); ?></option>
								</select>
								<p class="description"><?php esc_html_e( 'Default number of columns for grid layouts. Can be overridden in individual shortcodes.', 'blog-designer-pack' ); ?></p>
							</td>
						</tr>

						<tr>
							<th scope="row"><label for="bdpp-default-design"><?php esc_html_e( 'Default Design', 'blog-designer-pack' ); ?></label></th>
							<td>
								<select name="bdpp_opts[default_design]" class="bdpp-select" id="bdpp-default-design">
									<?php foreach ( $designs as $design_key => $design_label ) : ?>
										<option value="<?php echo esc_attr( $design_key ); ?>" <?php selected( $default_design, $design_key ); ?>><?php echo esc_html( $design_label ); ?></option>
									<?php endforeach; ?>
								</select>
								<p class="description"><?php esc_html_e( 'Default design template for grid layouts. Can be overridden in individual shortcodes.', 'blog-designer-pack' ); ?></p>
							</td>
						</tr>

						<tr>
							<th scope="row"><label for="bdpp-default-post-limit"><?php esc_html_e( 'Default Post Limit', 'blog-designer-pack' ); ?></label></th>
							<td>
								<input type="number" name="bdpp_opts[default_post_limit]" value="<?php echo esc_attr( $default_post_limit ); ?>" class="regular-text" id="bdpp-default-post-limit" min="1" max="100" step="1" />
								<p class="description"><?php esc_html_e( 'Default number of posts to display. Can be overridden in individual shortcodes.', 'blog-designer-pack' ); ?></p>
							</td>
						</tr>

						<tr>
							<td colspan="2">
								<?php submit_button( __( 'Save Settings', 'blog-designer-pack' ), 'button-primary right', 'bdpp_sett_submit', false ); ?>
							</td>
						</tr>
					</tbody>
				</table><!-- .bdpp-defaults-sett-tbl -->
			</div><!-- .inside -->
		</div><!-- .postbox -->
	</div><!-- .metabox-holder -->
</div><!-- #bdpp-defaults-sett-wrp -->

<?php }

// Action to add defaults settings
add_action( 'bdp_settings_tab_defaults', 'bdp_render_defaults_settings' );
