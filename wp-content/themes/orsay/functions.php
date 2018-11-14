<?php
/**
 *
 * @package Orsay
 */

global $orsay_site_layout;
$orsay_site_layout = array(
					'mz-sidebar-left' =>  esc_html__('Left Sidebar','orsay'),
					'mz-sidebar-right' => esc_html__('Right Sidebar','orsay'),
					'no-sidebar' => esc_html__('No Sidebar','orsay'),
					'mz-full-width' => esc_html__('Full Width', 'orsay')
					);
$orsay_thumbs_layout = array(
					'landscape' =>  esc_html__('Landscape','orsay'),
					'portrait' => esc_html__('Portrait','orsay')
					);

if ( ! function_exists( 'orsay_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function orsay_setup() {

	/*
	* Make theme available for translation.
	* Translations can be filed in the /languages/ directory.
	*/
	load_theme_textdomain( 'orsay', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/**
	* Enable support for Post Thumbnails on posts and pages.
	*
	* @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	*/
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'orsay-slider-thumbnail', 900, 515, true );
	add_image_size( 'orsay-large-thumbnail', 1140, 640, true );
	add_image_size( 'orsay-landscape-thumbnail', 735, 490, true );
	add_image_size( 'orsay-portrait-thumbnail', 735, 1100, true );
	add_image_size( 'orsay-author-thumbnail', 170, 170, true );
	add_image_size( 'orsay-small-thumbnail', 100, 80, true );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'main-menu' => esc_html__( 'Main Menu', 'orsay' ),
	) );

	// Set the content width based on the theme's design and stylesheet.
	global $content_width;
	if ( ! isset( $content_width ) ) {
	$content_width = 1140; /* pixels */
	} 

	/*
	* Switch default core markup for search form, comment form, and comments
	* to output valid HTML5.
	*/
	add_theme_support( 'html5', array(
		'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'orsay_custom_background_args', array(
		'default-color' => 'FFFFFF',
		'default-image' => '',
	) ) );

	/*
	* Let WordPress manage the document title.
	* By adding theme support, we declare that this theme does not use a
	* hard-coded <title> tag in the document head, and expect WordPress to
	* provide it for us.
	*/
	add_theme_support( 'title-tag' );

	add_theme_support( 'custom-logo', array(
		'height'      => 140,
		'width'       => 500,
		'flex-height' => true,
	) );

}
endif; // orsay_setup
add_action( 'after_setup_theme', 'orsay_setup' );


/**
 * Displays the optional custom logo.
 *
 * Does nothing if the custom logo is not available.
 *
 */
if ( ! function_exists( 'orsay_the_custom_logo' ) ) :
function orsay_the_custom_logo() {
	// Try to retrieve the Custom Logo
	$output = '';
	if ((function_exists('get_custom_logo'))&&(has_custom_logo()))
		$output = get_custom_logo();

		// Nothing in the output: Custom Logo is not supported, or there is no selected logo
		// In both cases we display the site's name
	if (empty($output))
		$output = '<hgroup><h1><a href="' . esc_url(home_url('/')) . '" rel="home">' . esc_attr(get_bloginfo('name')) . '</a></h1><div class="description">'.esc_attr(get_bloginfo('description')).'</div></hgroup>';

	echo $output;
}
endif; // sanremo_custom_logo


/*
 * Add Bootstrap classes to the main-content-area wrapper.
 */
if ( ! function_exists( 'orsay_content_bootstrap_classes' ) ) :
function orsay_content_bootstrap_classes() {
	if ( is_page_template( 'template-fullwidth.php' ) ) {
		return 'col-md-12';
	}
	return 'col-md-8';
}
endif; // orsay_content_bootstrap_classes


/*
 * Generate categories for slider customizer
 */
function orsay_cats() {
	$cats = array();
	$cats[0] = esc_html__("All", "orsay");
	
	foreach ( get_categories() as $categories => $category ) {
		$cats[$category->term_id] = $category->name;
	}

	return $cats;
}

/*
 * generate navigation from default bootstrap classes
 */
include( get_template_directory() . '/inc/wp_bootstrap_navwalker.php');

if ( ! function_exists( 'orsay_header_menu' ) ) :
/*
 * Header menu (should you choose to use one)
 */
function orsay_header_menu() {

	$orsay_menu_center = get_theme_mod( 'orsay_menu_center' );

	/* display the WordPress Custom Menu if available */
	$orsay_add_center_class = "";
	if ( true == $orsay_menu_center ) {
		$orsay_add_center_class = " navbar-center";
	}

	wp_nav_menu(array(
		'menu'              => 'main-menu',
		'theme_location'    => 'main-menu',
		'depth'             => 2,
		'container'         => 'div',
		'container_class'   => 'collapse navbar-collapse navbar-ex1-collapse'.$orsay_add_center_class,
		'menu_class'        => 'nav navbar-nav',
		'fallback_cb'       => 'orsay_bootstrap_navwalker::fallback',
		'walker'            => new orsay_bootstrap_navwalker()
	));
} /* end header menu */
endif;

/*
 * Register Google fonts for theme.
 */
if ( ! function_exists( 'orsay_fonts_url' ) ) :
/**
 * Create your own orsay_fonts_url() function to override in a child theme.
 *
 * @since Orsay 1.0
 *
 * @return string Google fonts URL for the theme.
 */
function orsay_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/* translators: If there are characters in your language that are not supported by Dancing Script, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Dancing Script: on or off', 'orsay' ) ) {
		$fonts[] = 'Dancing Script:400';
	}

	/* translators: If there are characters in your language that are not supported by Crimson Text, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Crimson Text font: on or off', 'orsay' ) ) {
		$fonts[] = 'Crimson Text:400,700';
	}

	/* translators: If there are characters in your language that are not supported by Open Sans, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'orsay' ) ) {
		$fonts[] = 'Open Sans:400,700';
	}

	/* translators: If there are characters in your language that are not supported by Noto Sans, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Noto Sans font: on or off', 'orsay' ) ) {
		$fonts[] = 'Noto Sans:500';
	}

	/* translators: If there are characters in your language that are not supported by Playfair Display, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Playfair Display font: on or off', 'orsay' ) ) {
		$fonts[] = 'Playfair Display:400,400italic,700,700italic';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), '//fonts.googleapis.com/css' );
	}

	return $fonts_url;
}
endif;

/*
 * load css/js
 */
function orsay_scripts() {

	// Add Google Fonts
	wp_enqueue_style( 'orsay-webfonts', orsay_fonts_url(), array(), null, null );

	// Add Bootstrap default CSS
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css' );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri().'/css/font-awesome.min.css' );

	// Add main theme stylesheet
	wp_enqueue_style( 'orsay-style', get_stylesheet_uri() );

	// Add JS Files
	wp_enqueue_script( 'bootstrap', get_template_directory_uri().'/js/bootstrap.min.js', array('jquery') );
	wp_enqueue_script( 'slick-slider', get_template_directory_uri() . '/js/slick.min.js', array('jquery') );
	wp_enqueue_script( 'orsay-js', get_template_directory_uri().'/js/orsay.js', array('jquery') );

	// Threaded comments
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
	wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'orsay_scripts' );

/*
 * Add custom colors css to header
 */
if (!function_exists('orsay_custom_css_output'))  {
	function orsay_custom_css_output() {

		$orsay_options = get_theme_mods();
		$orsay_links_color = array_key_exists('orsay_links_color', $orsay_options) ? $orsay_options['orsay_links_color'] : '';
		$orsay_hover_color = array_key_exists('orsay_hover_color', $orsay_options) ? $orsay_options['orsay_hover_color'] : '';

		echo '<style type="text/css" id="orsay-custom-theme-css">';

		if ( $orsay_links_color != "") {
			echo 'a, .page-title { color: ' . esc_attr($orsay_links_color) . '; }' .
			'::selection { background-color: ' . esc_attr($orsay_links_color) . '; }' .
			'.section-title h2:after { background-color: ' . esc_attr($orsay_links_color) . '; }' .
			'button, input[type="button"], input[type="reset"], input[type="submit"] { color: ' . esc_attr($orsay_links_color) . '; }' .
			'.page-numbers .current, .widget_search button { background-color: ' . esc_attr($orsay_links_color) . '; border-color: ' . esc_attr($orsay_links_color) . '; }';
		}
		if ( $orsay_hover_color != "" ) {
			echo '#back-top a:hover { background-color: ' . esc_attr($orsay_hover_color) . '; }' .
			'.nav>li>a:focus, .nav>li>a:hover, .dropdown-menu>li>a:focus, .dropdown-menu>li>a:hover { background-color: ' . esc_attr($orsay_hover_color) . '; }' .
			'.read-more a:hover { background-color: ' . esc_attr($orsay_hover_color) . '; border-color: ' . esc_attr($orsay_hover_color) . '; }' .
			'button:hover, input[type="button"]:hover, input[type="reset"]:hover, input[type="submit"]:hover, .null-instagram-feed p a:hover { background-color: ' . esc_attr($orsay_hover_color) . '; border-color: ' . esc_attr($orsay_hover_color) . '; }' .
			'.comment-reply-link:hover, .comment-reply-login:hover, .page-numbers li a:hover { background-color: ' . esc_attr($orsay_hover_color) . '; border-color: ' . esc_attr($orsay_hover_color) . '; }' .
			'.post-share a:hover, .post-header span a:hover, .post-meta .meta-info a:hover { border-color: ' . esc_attr($orsay_hover_color) . '; }' .
			'a:hover, a:focus, a:active, a.active, .mz-social-widget a:hover { color: ' . esc_attr($orsay_hover_color) . '; }';
		}

		echo '</style>';

	}
}
add_action( 'wp_head', 'orsay_custom_css_output');

/*
 * Customizer additions.
 */
require get_template_directory() . '/inc/extras.php';
require get_template_directory() . '/inc/customizer.php';

/*
 * Register widget areas.
 */

// if no title then add widget content wrapper to before widget
add_filter( 'dynamic_sidebar_params', 'orsay_check_sidebar_params' );
function orsay_check_sidebar_params( $params ) {
	global $wp_registered_widgets;

	$settings_getter = $wp_registered_widgets[ $params[0]['widget_id'] ]['callback'][0];
	$settings = $settings_getter->get_settings();
	$settings = $settings[ $params[1]['number'] ];

	if ( $params[0][ 'after_widget' ] == '</div></div>' && isset( $settings[ 'title' ] ) && empty( $settings[ 'title' ] ) )
		$params[0][ 'before_widget' ] .= '<div class="content">';

	return $params;
}

function orsay_widgets_init() {

	register_sidebar( array(
		'name'          => __( 'Primary Sidebar', 'orsay' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Main sidebar that appears on the left.', 'orsay' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget-title"><span>',
		'after_title'   => '</span></div>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Widget 1', 'orsay' ),
		'id'            => 'footer-widget-1',
		'description'   => __( 'Appears in the footer section of the site.', 'orsay' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget-title"><span>',
		'after_title'   => '</span></div>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Widget 2', 'orsay' ),
		'id'            => 'footer-widget-2',
		'description'   => __( 'Appears in the footer section of the site.', 'orsay' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget-title"><span>',
		'after_title'   => '</span></div>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Widget 3', 'orsay' ),
		'id'            => 'footer-widget-3',
		'description'   => __( 'Appears in the footer section of the site.', 'orsay' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget-title"><span>',
		'after_title'   => '</span></div>',
	) );
	register_sidebar( array(
		'name'          => __( 'Full Width Footer', 'orsay' ),
		'id'            => 'footer-wide-widget',
		'description'   => __( 'Full width footer area for Instagram, etc. Appears in the footer section after widgets.', 'orsay' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget-title"><span>',
		'after_title'   => '</span></div>',
	) );

}
add_action( 'widgets_init', 'orsay_widgets_init' );

/*
 * Misc. functions
 */

/**
 * Footer credits
 */
function orsay_footer_credits() {
	$orsay_footer_text = get_theme_mod( 'orsay_footer_text' );
	?>
	<div class="site-info">
	<?php if ($orsay_footer_text == '') { ?>
	&copy; <?php echo date_i18n( __( 'Y', 'orsay' ) ); ?> <?php bloginfo( 'name' ); ?><?php esc_html_e('. All rights reserved.', 'orsay'); ?>
	<?php } else { echo esc_html( $orsay_footer_text ); } ?>
	</div><!-- .site-info -->

	<?php
	$nofollow="";
	if (!is_home()) { $nofollow="rel=\"nofollow\""; }
	printf( esc_html__( 'Theme by %1$s Powered by %2$s', 'orsay' ) , '<a href="http://moozthemes.com/" target="_blank" '.$nofollow.'>MOOZ Themes</a>', '<a href="http://wordpress.org/" target="_blank">WordPress</a>');
}
add_action( 'orsay_footer', 'orsay_footer_credits' );

/* Wrap Post count in a span */
add_filter('wp_list_categories', 'orsay_cat_count_span');
function orsay_cat_count_span($links) {
	$links = str_replace('</a> (', '</a> <span>', $links);
	$links = str_replace(')', '</span>', $links);
	return $links;
}

require_once(get_template_directory() . '/inc/class-tgm-plugin-activation.php');
add_action( 'tgmpa_register', 'orsay_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function orsay_register_required_plugins() {

/**
 * Array of plugin arrays. Required keys are name and slug.
 * If the source is NOT from the .org repo, then source is also required.
 */

$plugins = array(
	// This is an example of how to include a plugin pre-packaged with a theme
	array(
		'name'         => 'Orange Themes Custom Widgets', // The plugin name
		'slug'         => 'orange-themes-custom-widgets', // The plugin slug (typically the folder name)
		'required'     => true, // If false, the plugin is only 'recommended' instead of required
		'version'     => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
		'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
		'force_deactivation'  => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
		'external_url'    => '', // If set, overrides default API URL and points to an external URL
	),  
);

 /**
  * Array of configuration settings. Amend each line as needed.
  * If you want the default strings to be available under your own theme domain,
  * leave the strings uncommented.
  * Some of the strings are added into a sprintf, so see the comments at the
  * end of each line for what each argument will be.
  */
	$config = array(
		'domain'         => 'orsay',          // Text domain - likely want to be the same as your theme.
		'default_path'   => '',                          // Default absolute path to pre-packaged plugins
		'menu'           => 'install-required-plugins',  // Menu slug
		'has_notices'       => true,                        // Show admin notices or not
		'is_automatic'     => false,         // Automatically activate plugins after installation or not
		'message'    => '',       // Message to output right before the plugins table
		'strings'        => array(
		'page_title'                          => __('Install Required Plugins','orsay'),
		'menu_title'                          => __('Install Plugins','orsay'),
		'installing'                          => __('Installing Plugin: %s','orsay'), // %1$s = plugin name
		'oops'                                => __('Something went wrong with the plugin API.','orsay'),
		'notice_can_install_required'        => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.','orsay' ), // %1$s = plugin name(s)
		'notice_can_install_recommended'   => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.','orsay' ), // %1$s = plugin name(s)
		'notice_cannot_install'       => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.','orsay' ), // %1$s = plugin name(s)
		'notice_can_activate_required'       => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.','orsay' ), // %1$s = plugin name(s)
		'notice_can_activate_recommended'   => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.','orsay' ), // %1$s = plugin name(s)
		'notice_cannot_activate'      => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.','orsay' ), // %1$s = plugin name(s)
		'notice_ask_to_update'       => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.','orsay' ), // %1$s = plugin name(s)
		'notice_cannot_update'       => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.','orsay' ), // %1$s = plugin name(s)
		'install_link'           => _n_noop( 'Begin installing plugin', 'Begin installing plugins','orsay' ),
		'activate_link'          => _n_noop( 'Activate installed plugin', 'Activate installed plugins','orsay' ),
		'return'                              => __('Return to Required Plugins Installer','orsay'),
		'plugin_activated'                    => __('Plugin activated successfully.','orsay'),
		'complete'          => __('All plugins installed and activated successfully. %s','orsay'), // %1$s = dashboard link
		'nag_type'         => 'updated' // Determines admin notice type - can only be 'updated' or 'error'
		)
	);

	tgmpa( $plugins, $config );
}