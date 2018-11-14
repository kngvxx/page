<?php
/**
 * The template for displaying your Portfolio Category custom taxonomy archives.
 *
 * @package     Elegant WordPress theme
 * @subpackage  Templates
 * @author      Alexander Clarke
 * @link        http://www.wpexplorer.com
 * @since       1.0.0
 */

get_header(); ?>

	<div id="primary" class="content-area clr">

		<main id="content" class="site-content" role="main">

			<?php get_template_part( 'partials/archive-header' ); ?>

			<?php if ( have_posts( ) ) : ?>

				<div id="portfolio-wrap" class="wpex-row clr">

					<?php $wpex_count=0; ?>

					<?php
					$columns = get_theme_mod( 'wpex_portfolio_columns' );
					$columns = $columns ? absint( $columns ) : 4; ?>

					<?php while ( have_posts() ) : the_post(); ?>

						<?php $wpex_count++; ?>

							<?php get_template_part( 'partials/portfolio/entry' ); ?>

						<?php if ( $wpex_count == $columns ) {
							$wpex_count = 0;
						} ?>
						
					<?php endwhile; ?>

				</div><!-- #portfolio-wrap -->

				<?php wpex_pagination(); ?>

			<?php else : ?>

				<?php get_template_part( 'content', 'none' ); ?>

			<?php endif; ?>

		</main><!-- #content -->

	</div><!-- #primary -->

<?php get_footer(); ?>