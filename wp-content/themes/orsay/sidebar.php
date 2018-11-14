<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Orsay
 */
?>
				</div>

				<?php
				/* read layout options */

				$orsay_sidebar_position = get_theme_mod( 'orsay_sidebar_position' );
				$orsay_sidebar_position = isset($orsay_sidebar_position) ? $orsay_sidebar_position : '';

				$site_layout = get_post_meta($post->ID, 'site_layout', true);

				$show_sidebar = true;
				if( is_singular() && ( isset($site_layout) ) ){
					if( $site_layout == 'no-sidebar' || $site_layout == 'mz-full-width' ) {
						$show_sidebar = false;               
					}
				} elseif( $orsay_sidebar_position == "no-sidebar" ||  $orsay_sidebar_position == "mz-full-width" ) {
					$show_sidebar = false;
				}
				?>

			<?php if( $show_sidebar ): ?>            

				<div class="col-md-4">
					<div id="sidebar" class="sidebar">

						<?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>
							<!-- sidebar-widget -->

							<div id="search" class="widget widget_search">
								<?php get_search_form(); ?>
							</div>

							<div id="archives" class="widget">
								<div class="widget-title"><span><?php esc_html_e( 'Archives', 'orsay' ); ?></span></div>
								<ul>
									<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
								</ul>
							</div>

						<?php endif; /* dinamic_sidebar */ ?>
					</div>
				</div>
				
			<?php endif;