<?php
/**
 * Asheville functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Asheville
 */

// Disable the admin bar
// show_admin_bar(false);

// Hide Pantheon update nag
remove_action( 'admin_init', '_pantheon_register_upstream_update_notice' );

// Disable annoying Yoast SEO admin notifications
add_action( 'admin_init', function() {
	if ( class_exists( 'Yoast_Notification_Center' ) ) {
		$yoast_nc = Yoast_Notification_Center::get();
		remove_action( 'admin_notices', array( $yoast_nc, 'display_notifications' ) );
		remove_action( 'all_admin_notices', array( $yoast_nc, 'display_notifications' ) );
	}
});

// Remove bloat
function avl_remove_bloat() {
	// emoji
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'emoji_svg_url', '__return_false' );
	// header
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'wp_generator' );
	// https://orbitingweb.com/blog/remove-unnecessary-tags-wp-head/
	remove_action('wp_head', 'feed_links_extra', 3 );  //removes comments feed.
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
}
add_action( 'init', 'avl_remove_bloat' );

function avl_custom_upload_mimes($mimes) {
	// Add a key and value for the CSV file type
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_action('upload_mimes', 'avl_custom_upload_mimes');

if ( ! function_exists( 'avl_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
 	 */
	function avl_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Asheville, use a find and replace
		 * to change 'avl' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'avl', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// Add small image size for images from old city source blog
		add_image_size( 'small', 300, 300 );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary', 'avl' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'avl_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'avl_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function avl_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'avl_content_width', 730 );
}
add_action( 'after_setup_theme', 'avl_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function avl_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'avl' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'avl' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s mb-3">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget-title">',
		'after_title'   => '</div>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Services Sidebar', 'avl' ),
		'id'            => 'sidebar-services',
		'description'   => esc_html__( 'Add widgets here.', 'avl' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s mb-3">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget-title">',
		'after_title'   => '</div>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'News Sidebar', 'avl' ),
		'id'            => 'sidebar-news',
		'description'   => esc_html__( 'Add widgets here.', 'avl' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s mb-3 news-widget">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget-title">',
		'after_title'   => '</div>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Post Sidebar', 'avl' ),
		'id'            => 'sidebar-post',
		'description'   => esc_html__( 'Add widgets here.', 'avl' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s mb-3">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget-title">',
		'after_title'   => '</div>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Events Block', 'avl' ),
		'id'            => 'block-events',
		'description'   => esc_html__( 'Add widgets here.', 'avl' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s mb-3">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget-title">',
		'after_title'   => '</div>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Search Sidebar', 'avl' ),
		'id'            => 'sidebar-search',
		'description'   => esc_html__( 'Add widgets here.', 'avl' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s mb-3">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget-title">',
		'after_title'   => '</div>',
	) );

}
add_action( 'widgets_init', 'avl_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function add_js_async_attr($tag){
  $scripts_to_include = array('pdfmake', 'google-translate', 'annotatedtimeline');
  foreach($scripts_to_include as $include_script){
    if(true == strpos($tag, $include_script )) {
      return str_replace( ' src', ' async="async" src', $tag );
    }
  }
  return $tag;
}
add_filter( 'script_loader_tag', 'add_js_async_attr', 10 );

// add_filter( 'style_loader_tag', function ($html, $handle, $href) {
//     // if (is_admin()) {
//     //     return $html;
//     // }
//     $dom = new \DOMDocument();
//     $dom->loadHTML($html);
//     $tag = $dom->getElementById($handle . '-css');
//     $tag->setAttribute('rel', 'preload');
//     $tag->setAttribute('as', 'style');
//     $tag->setAttribute('onload', "this.onload=null;this.rel='stylesheet'");
//     $tag->removeAttribute('type');
//     $html = $dom->saveHTML($tag);
//
//     return $html;
// }, 999, 3);

function avl_scripts() {
	// JavaScript
	wp_enqueue_script( 'popper-js', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js', array('jquery'), null, true );
	wp_enqueue_script( 'bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js', array('jquery', 'popper-js'), null, true );
	wp_enqueue_script( 'custom-algolia-js', get_template_directory_uri() . '/js/custom-algolia.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'moment-js', get_template_directory_uri() . '/js/moment.js', array('jquery'), null, true );

    // PRC - 06.2019
    // Load the datatabes date plugin, which works with moment JS to parse dates on inlined Google Sheets
	wp_enqueue_script( 'datatable-dates','//cdn.datatables.net/plug-ins/1.10.19/sorting/datetime-moment.js', array(),  null, true );

	wp_enqueue_script( 'custom-js', get_template_directory_uri() . '/js/custom.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'google-translate-js', 'https://translate.google.com/translate_a/element.js?cb=initGoogleTranslateElement', array('custom-js'), null, true );

	if ( is_front_page() && is_home() ) {
		wp_enqueue_script( 'twitter-widget-js', 'https://platform.twitter.com/widgets.js', array('jquery'), null, true );
		// wp_enqueue_script( 'custom-home-js', get_template_directory_uri() . '/js/custom-home.js', array('jquery'), '1.0', true );
		wp_enqueue_style( 'header-style', admin_url('admin-ajax.php') .'?action=get_header_style', array('avl-style'), null );
	}

	// CSS
	wp_enqueue_style( 'lindua-style', get_template_directory_uri() . '/css/lindua.css', array(), null );
	wp_enqueue_style( 'icomoon-style', get_template_directory_uri() . '/css/icomoon.css', array(), null );
	wp_enqueue_style( 'bootstrap-style', 'https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css', array(), null );

	wp_enqueue_style( 'avl-style', get_stylesheet_uri() . '', array( 'bootstrap-style', 'lindua-style', 'icomoon-style', 'algolia-autocomplete' ), filemtime( get_stylesheet_directory() . '/style.css') );

	//wp_enqueue_script( 'avl-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );
	//wp_enqueue_script( 'avl-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	// if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
	// 	wp_enqueue_script( 'comment-reply' );
	// }

	// Prevent wp-embed.min.js from loading
	wp_deregister_script( 'wp-embed' );

  // IS THIS A TYPO THAT IS CAUSING PROBLEMS?
  wp_enqueue_script('algolio-search', plugins_url('search-by-algolia-instant-relevant-results/js/algoliasearch/algoliasearch.jquery.js', 'search_by_algolia_instant_relevant_results'), array(), null, true);
  wp_enqueue_script('algolia-instantsearch', plugins_url('search-by-algolia-instant-relevant-results/js/instantsearch/instantsearch.js', 'search_by_algolia_instant_relevant_results'), array(), null, true);
  wp_enqueue_script('algolia-autocomplete', plugins_url('search-by-algolia-instant-relevant-results/js/autocomplete/autocomplete.js', 'search_by_algolia_instant_relevant_results'), array(), null, true);
  wp_enqueue_script('algolia-autocomplete-noconflict', plugins_url( 'search-by-algolia-instant-relevant-results/js/autocomplete-noconflict.js', 'search_by_algolia_instant_relevant_results'), array(), null, true);
  // if ( is_front_page() && is_home() ) {
  //     wp_deregister_script('jquery-datatables');
  //     wp_deregister_script('datatables-buttons');
  //     wp_deregister_script('datatables-select');
  //     wp_deregister_script('datatables-fixedheader');
  //     wp_deregister_script('datatables-fixedcolumns');
  //     wp_deregister_script('datatables-responsive');
  // }
}
add_action( 'wp_enqueue_scripts', 'avl_scripts' );



/**
 * Implement the Custom Header feature.
 */
require get_template_directory() .'/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() .'/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() .'/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() .'/inc/customizer.php';

/**
 * Load navigation walker class.
 */
require get_template_directory() .'/inc/class-wp-bootstrap-navwalker.php';

/**
 * Load card walker class.
 */
require get_template_directory() .'/inc/class-wp-bootstrap-cardwalker.php';


/*
  Make link and link_title column into one
*/
function titled_links ($html) {
  // Find all values in bla_link column, all values in bla_link_title column
  // Return column that has bla for title, values are <a href="bla_link">bla_link_title</a>
  $dom = new DOMDocument;
  $dom->loadHTML($html);
  $ths = $dom->getElementsByTagName('th');

  $replace_these = array();

  foreach ($ths as $index => $th) {
    $th_val = strtolower($th->nodeValue);

    if (strpos($th_val, '_link_title') !== false) {
      $title_key = strstr($th_val, '_link_title', true);

      if (!array_key_exists($title_key, $replace_these)) {
        $replace_these[$title_key] = array();
      }
      $replace_these[$title_key]['title_index'] = $index;
      // Set the column header to be the part that comes before _Link_Title
      $th->nodeValue = ucwords(str_replace('_', ' ', $title_key));

    } elseif (strpos($th_val, '_link') !== false) {
      $title_key = strstr($th_val, '_link', true);
      if (!array_key_exists($title_key, $replace_these)) {
        $replace_these[$title_key] = array();
      }
      $replace_these[$title_key]['link_index'] = $index;
      $th->setAttribute('class', 'display-none');
    }
  }

  $tbody = $dom->getElementsByTagName('tbody')->item(0);
  $trs = $tbody->childNodes;
  // For each row in the table body
  foreach ($trs as $index => $tr) {
    $tds = $tr->childNodes;
    // For each set of "replace these" items for which there is either a title or link value
    foreach ($replace_these as $title_key => $replacement_values) {
      $link_value = $tds[$replacement_values['link_index']]->nodeValue;
      $title_value = $tds[$replacement_values['title_index']]->nodeValue;

      // Set the link column to not display at all
      $tds[$replacement_values['link_index']]->setAttribute('class', 'display-none');
      $newLinkNode = $dom->createElement('a');
      $newLinkNode->setAttribute('href', $link_value);
      $newLinkNode->setAttribute('target', '_blank');
      $newLinkNode->setAttribute('rel', 'noopener noreferrer');
      $newLinkNode->nodeValue = $title_value;

      if (strlen($title_value) === 0) {
        // If there isn't a title
        $newLinkNode->nodeValue = $link_value;
      }

    $tds[$replacement_values['title_index']]->nodeValue = '';
    $tds[$replacement_values['title_index']]->appendChild($newLinkNode);
    }
  }

  $html = $dom->saveHTML();
  return $html;
}
add_filter('gdoc_table_html', 'titled_links');


// Algolia filters
// See also:  https://community.algolia.com/wordpress/filters.html

// add medium image sizes so that they aren't goofy and small
add_filter('algolia_post_images_sizes', function($sizes) {
    $sizes[] = 'medium';
    return $sizes;
});

// filter out tribe events
function mb_algolia_searchable_post_types(array $post_types) {
    $pos = array_search('tribe_events', $post_types);

    if ($pos !== false) {
        unset($post_types[$pos]);
    }

    return $post_types;
}
add_filter( 'algolia_searchable_post_types', 'mb_algolia_searchable_post_types' );

remove_filter('get_the_excerpt', 'wp_trim_excerpt');
function wp_trim_excerpt_except_links($text) { // Fakes an excerpt if needed
    global $post;
    if ( '' == $text ) {
        $text = get_the_content('');
        $text = apply_filters('the_content', $text);
        $text = str_replace('\]\]\>', ']]&gt;', $text);
        $text = strip_tags($text, '<a>');
        $excerpt_length = 55;
        $words = explode(' ', $text, $excerpt_length + 1);
        if (count($words)> $excerpt_length) {
            array_pop($words);
            array_push($words, '[...]');
            $text = implode(' ', $words);
        }
    }
    return $text;
}
add_filter('get_the_excerpt', 'wp_trim_excerpt_except_links');


// from https://gist.github.com/cliffordp/a473ccda4308acb9ac66499de5407c9b
// PRC ADDED LIST SEARCH LOGIC 6/2019

function custom_calendar_js(){
	// If tribe-events.js hasn't been setup, do nothing
	if ( ! wp_script_is( 'tribe-events-calendar-script' ) ) {
		return;
	}
	print "
		<script type='text/javascript'>
			jQuery( document ).ready( function( $ ) {
 				PRC.calendarFunctionality();
			});
		</script>
	";
}

add_action('wp_footer', 'custom_calendar_js', 100);
// END PRC ADDED LIST SEARCH LOGIC 6/2019

// PRC ADDED ACF OPTIONS PAGE 6/2019
if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
		'page_title' => 'Theme General Settings',
		'menu_title'	=> 'Theme Settings',
	));

}

add_image_size( 'banner-large', 2000, 1000);
add_image_size( 'banner-medium', 1500, 750);
add_image_size( 'banner-small', 1000, 500);
add_image_size( 'banner-xsmall', 750, 375);

/**
 * Load Jetpack compatibility file.
 */
/*
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}
*/


// Jesse (PRC) - Added this
// function remove_taxonomies_metaboxes() {
//     // remove_meta_box( 'categorydiv', 'post', 'side' );
//     remove_meta_box('tagsdiv-post_tag', 'post', 'side');
//     remove_meta_box( 'avl_departmentdiv', 'post', 'side' );
//     remove_meta_box('acf-group_5bd22c583c555', 'post', 'normal');
// }

// add_action( 'add_meta_boxes' , 'remove_taxonomies_metaboxes' );

// function filterCats($listCats){
// 	global $typenow;
// 	if($typenow == 'post'){
// 	    foreach ($listCats as $k => $oCat) {
// 	    	unset($listCats[$k]);
// 	        if( $oCat->term_id == 153){//Sports Category id
// 	            $listCats[$k] = $oCat;
// 	        }
// 	    }
// 	}
//  	return $listCats;
// }
// add_filter('get_terms','filterCats');
