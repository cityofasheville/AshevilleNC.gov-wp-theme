<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php the_header_image_tag(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Asheville
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses avl_header_style()
 */
function avl_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'avl_custom_header_args', array(
		'default-image'		=> '',
		'default-text-color'	=> '000000',
		'width'				=> 2400,
		'height'				=> 1008,
		'flex-height'			=> true,
		'flex-width'			=> true,
		//'wp-head-callback'	=> 'avl_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'avl_custom_header_setup' );

function avl_header_style() {
	$style = '';

	// KRK: Add support for header background image.
	if ( has_header_image() ) {
		$style .= '#site-branding-background-image { min-height: 30em; background-image: url("'. get_header_image() .'"); }';
	}

	if ( display_header_text() )
		$style .= '.site-title a, .site-description { color: #'. esc_attr( get_header_textcolor() ) .'; }';
	else
		$style .= '.site-title, .site-description { display: none; }';

	echo $style;
}

// KRK: Dynamically generate css to load from stylesheet link
// instead of inline. This is cleaner and works when cached.
function get_header_style() {
	header('Content-Type: text/css; charset=utf-8');
	avl_header_style();
	exit;
}
add_action( 'wp_ajax_get_header_style', 'get_header_style' );
add_action( 'wp_ajax_nopriv_get_header_style', 'get_header_style' );
?>
