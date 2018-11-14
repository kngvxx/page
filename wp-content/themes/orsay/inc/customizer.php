<?php
/**
 * orsay theme Customizer
 *
 * @package Orsay
 */

function orsay_theme_options( $wp_customize ) {
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}

add_action( 'customize_register' , 'orsay_theme_options' );

/**
 * Options for WordPress Theme Customizer.
 */
function orsay_customizer( $wp_customize ) {

	global $orsay_site_layout, $orsay_thumbs_layout;

	/**
	 * Section: Post Settings
	 */

	// Change accent color
	$wp_customize->add_setting( 'orsay_links_color', array(
		'default'        => '#5bbfbb',
		'sanitize_callback' => 'orsay_sanitize_hexcolor',
		'transport'  =>  'refresh',
	));

	$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'orsay_links_color', array(
		'label'     => __('Links color','orsay'),
		'section'   => 'colors',
		'priority'  => 2,
	)));

	// Change hover color
	$wp_customize->add_setting( 'orsay_hover_color', array(
		'default'        => '#5bbfbb',
		'sanitize_callback' => 'orsay_sanitize_hexcolor',
		'transport'  =>  'refresh',
	));

	$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'orsay_hover_color', array(
		'label'     => __('Links hover color','orsay'),
		'section'   => 'colors',
		'priority'  => 4,
	)));

	/**
	 * Section: Post Settings
	 */

	$wp_customize->add_section('orsay_post_section', 
		array(
			'priority' => 31,
			'title' => __('Post Settings', 'orsay'),
			'description' => __('change post settings', 'orsay'),
			)
		);

		// Show Excerpt
		$wp_customize->add_setting('orsay_excerpt', array(
			'default' => '',
			'sanitize_callback' => 'orsay_sanitize_checkbox'
		));

		$wp_customize->add_control('orsay_excerpt', array(
			'priority'  => 1,
			'label' => __('Display the excerpt instead of the content.', 'orsay'),
			'type'    => 'checkbox',
			'section' => 'orsay_post_section',
		));	

		// Hide author on first page
		$wp_customize->add_setting('orsay_hide_author', array(
			'default' => false,
			'sanitize_callback' => 'orsay_sanitize_checkbox'
		));

		$wp_customize->add_control('orsay_hide_author', array(
			'priority'  => 2,
			'label' => __('Hide author name on first page.', 'orsay'),
			'type'    => 'checkbox',
			'section' => 'orsay_post_section',
		));	

		// Hide author on first page
		$wp_customize->add_setting('orsay_hide_comments', array(
			'default' => false,
			'sanitize_callback' => 'orsay_sanitize_checkbox'
		));

		$wp_customize->add_control('orsay_hide_comments', array(
			'priority'  => 2,
			'label' => __('Hide comments on first page.', 'orsay'),
			'type'    => 'checkbox',
			'section' => 'orsay_post_section',
		));	

		// Post Thumbnail Layout
		$wp_customize->add_setting('orsay_thumbs_layout', array(
			'default' => 'landscape',
			'sanitize_callback' => 'orsay_sanitize_thumbs'
		));

		$wp_customize->add_control('orsay_thumbs_layout', array(
			'priority'  => 2,
			'label' => __('Thumbnail Layout', 'orsay'),
			'section' => 'orsay_post_section',
			'type'    => 'select',
			'description' => __('Choose post thumbnail layout', 'orsay'),
			'choices'    => $orsay_thumbs_layout
		));

	/**
	 * Section: Theme layout options
	 */

	$wp_customize->add_section('orsay_layout_section', 
		array(
			'priority' => 32,
			'title' => __('Layout options', 'orsay'),
			'description' => __('Choose website layout', 'orsay'),
			)
		);

		// Sidebar position
		$wp_customize->add_setting('orsay_sidebar_position', array(
			'default' => 'mz-sidebar-right',
			'sanitize_callback' => 'orsay_sanitize_layout'
		));

		$wp_customize->add_control('orsay_sidebar_position', array(
			'priority'  => 1,
			'label' => __('Website Layout Options', 'orsay'),
			'section' => 'orsay_layout_section',
			'type'    => 'select',
			'description' => __('Choose between different layout options to be used as default', 'orsay'),
			'choices'    => $orsay_site_layout
		));

		// checkbox center menu
		$wp_customize->add_setting( 'orsay_menu_center', array(
			'default'        => false,
			'transport'  =>  'refresh',
			'sanitize_callback' => 'orsay_sanitize_checkbox'
		) );

		$wp_customize->add_control( 'orsay_menu_center', array(
			'priority'  => 2,
			'label'     => __('Center Menu?','orsay'),
			'section'   => 'orsay_layout_section',
			'type'      => 'checkbox',
		) );

	/**
	 * Section: Change footer text
	 */

	// Change footer copyright text
	$wp_customize->add_setting( 'orsay_footer_text', array(
		'default'        => '',
		'sanitize_callback' => 'orsay_sanitize_input',
		'transport'  =>  'refresh',
	));

	$wp_customize->add_control( 'orsay_footer_text', array(
		'label'     => __('Footer Copyright Text','orsay'),
		'section'   => 'title_tagline',
		'priority'    => 31,
	));

	/**
	 * Section: Slider settings
	 */

	$wp_customize->add_section( 
		'orsay_slider_options', 
		array(
			'priority'    => 33,
			'title'       => __( 'Slider Settings', 'orsay' ),
			'capability'  => 'edit_theme_options',
			'description' => __('Change slider settings here.', 'orsay'), 
		) 
	);

		// chose category for slider
		$wp_customize->add_setting( 'orsay_slider_cat', array(
			'default' => 0,
			'transport'   => 'refresh',
			'sanitize_callback' => 'orsay_sanitize_slidercat'
		) );	

		$wp_customize->add_control( 'orsay_slider_cat', array(
			'priority'  => 1,
			'type' => 'select',
			'label' => __('Choose a category.', 'orsay'),
			'choices' => orsay_cats(),
			'section' => 'orsay_slider_options',
		) );

		// checkbox show/hide slider
		$wp_customize->add_setting( 'show_orsay_slider', array(
			'default'        => false,
			'transport'  =>  'refresh',
			'sanitize_callback' => 'orsay_sanitize_checkbox'
		) );

		$wp_customize->add_control( 'show_orsay_slider', array(
			'priority'  => 2,
			'label'     => __('Show Slider?','orsay'),
			'section'   => 'orsay_slider_options',
			'type'      => 'checkbox',
		) );

}

add_action( 'customize_register', 'orsay_customizer' );

/**
 * Adds sanitization for text inputs
 */
function orsay_sanitize_input($input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}

/**
 * Adds sanitization callback function: Slider Category
 */
function orsay_sanitize_slidercat( $input ) {
	if ( array_key_exists( $input, orsay_cats()) ) {
		return $input;
	} else {
		return '';
	}
}

/**
 * Sanitze checkbox for WordPress customizer
 */
function orsay_sanitize_checkbox( $input ) {
	if ( $input == 1 ) {
		return 1;
	} else {
		return '';
	}
}

/**
 * Sanitze number for WordPress customizer
 */
function orsay_sanitize_number($input) {
	if ( isset( $input ) && is_numeric( $input ) ) {
		return $input;
	}
}

/**
 * Sanitze blog layout
 */
function orsay_sanitize_layout( $input ) {
	global $orsay_site_layout;
	if ( array_key_exists( $input, $orsay_site_layout ) ) {
		return $input;
	} else {
		return '';
	}
}

/**
 * Sanitze thumbs layout
 */
function orsay_sanitize_thumbs( $input ) {
	global $orsay_thumbs_layout;
	if ( array_key_exists( $input, $orsay_thumbs_layout ) ) {
		return $input;
	} else {
		return '';
	}
}

/**
 * Sanitze colors
 */
function orsay_sanitize_hexcolor($color)
{
	if ($unhashed = sanitize_hex_color_no_hash($color)) {
		return '#'.$unhashed;
	}

	return $color;
}