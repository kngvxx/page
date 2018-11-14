<?php
/**
 *
 * @package Orsay
 */
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>

		<!-- Navigation -->
		<nav class="navbar" role="navigation">
			<div class="container">
			<!-- Brand and toggle get grouped for better mobile display --> 
			<div class="navbar-header"> 
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"> 
					<span class="sr-only"><?php esc_html_e( 'Toggle navigation', 'orsay' ); ?></span> 
					<span class="icon-bar"></span> 
					<span class="icon-bar"></span> 
					<span class="icon-bar"></span> 
				</button> 
			</div> 
			<?php orsay_header_menu(); // main navigation ?>
			</div>
		</nav>
		<!-- End: Navigation -->


			<div class="container">
				<header class="header">
					<div class="container">
						<?php orsay_the_custom_logo(); ?>
					</div>
				</header>
			</div>

			<div class="container-fluid">
				<?php orsay_slider(); ?>
			</div>

			<!-- BEGIN .container -->
			<div class="container">

				<?php
					global $post;
					if( is_singular() && get_post_meta($post->ID, 'site_layout', true) ){
						$layout_class = get_post_meta($post->ID, 'site_layout', true);
					}
					else{
						$layout_class = get_theme_mod( 'orsay_sidebar_position' );
					}
					if ((isset($layout_class)) && ($layout_class == '')) $layout_class = "mz-sidebar-right";
				?>

			<div id="content">
				<div class="row">
					<div class="<?php echo esc_attr(orsay_content_bootstrap_classes()); ?> <?php echo esc_attr($layout_class); ?>">
