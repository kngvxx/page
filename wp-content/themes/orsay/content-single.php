<?php
/**
 * The template used for displaying content single
 *
 * @package Orsay
 */
?>
						<article  id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

							<div class="post-header">
								<span class="cat"><?php the_category( ' | ' ); ?></span>
								<h1><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

								<?php if ( 'post' == get_post_type() ) : ?>
									<span class="date"><?php the_date(); ?></span>
									<span class="date"><?php the_author_posts_link(); ?></span>
									<?php
										edit_post_link(
											sprintf(
												/* translators: %s: Name of current post */
												esc_html__( 'Edit %s', 'orsay' ),
												the_title( '<span class="screen-reader-text">"', '"</span>', false )
											),
											'<span class="edit-link">',
											'</span>'
										);
								endif; ?>

							</div>

							<div class="post-image">
								<?php if ( has_post_thumbnail() ) : 

										$orsay_thumb_size = get_theme_mod( 'orsay_sidebar_position' );
										if ((isset($orsay_thumb_size)) && ($orsay_thumb_size == 'mz-full-width')) $orsay_thumbnail = 'orsay-large-thumbnail';
										else $orsay_thumbnail = 'orsay-middle-thumbnail';

									?>
									<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
									<?php echo get_the_post_thumbnail( get_the_ID(), $orsay_thumbnail ); ?>
									</a>
								<?php endif; ?>
							</div>

							<div class="post-entry">
								<?php the_content(); ?>
								<?php			
								wp_link_pages( array(
									'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'orsay' ) . '</span>',
									'after'       => '</div>',
									'link_before' => '<span>',
									'link_after'  => '</span>',
									'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'orsay' ) . ' </span>%',
									'separator'   => '<span class="screen-reader-text">, </span>',
								) );
								?>
							</div>

							<div class="post-meta">
								<div class="post-share">
									<?php if(has_tag()) : ?>
									<!-- tags -->
									<div class="entry-tags">
										<span>
											<i class="fa fa-tags"></i>
										</span>
										<?php
											$tags = get_the_tags(get_the_ID());
											foreach($tags as $tag){
												echo '<a href="'.esc_url(get_tag_link($tag->term_id)).'">'.esc_html($tag->name).'</a> ';
											}
										?>

									</div>
									<!-- end tags -->
									<?php endif; ?>
								</div>
								<div class="meta-info">
									<?php
									$orsay_hide_comments = get_theme_mod( 'orsay_hide_comments' );
									if ($orsay_hide_comments == false) {
										if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
										<span><?php comments_popup_link( esc_html__( 'Leave a comment', 'orsay' ), esc_html__( '1 Comment', 'orsay' ), esc_html__( '% Comments', 'orsay' ) ); ?></span>
									<?php else: ?>
										<span class="post-comments-off"><?php esc_html_e( 'Comments Off', 'orsay' ); ?></span>
									<?php endif;
									} // endif hide comments
									?>
								</div>
							</div>
							
						</article>