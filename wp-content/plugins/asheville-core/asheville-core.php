<?php
/*
Plugin Name: Asheville Core Functionality
Plugin URI: http://www.ashevillenc.gov
Description: This plugin contains the core logic for Asheville and is independent of theme.
Version: 0.1
Author: Kyle Kirkpatrick
Author URI: http://avlbeta.site
License: GPL2
*/

function avl_register_post_types() {
	register_post_type('avl_service',
		array(
			'labels' => array(
				'name' => 'Services',
				'singular_name' => 'Service',
				'add_new_item' => 'Add New Service',
				'edit_item' => 'Edit Service',
			),
			'public' => true,
			'has_archive' => true,
			'menu_icon' => get_template_directory_uri() .'/img/avl-service.png',
			'taxonomies' => array( 'avl_service_type' ),
			'supports' => array(
				'title',
				'editor',
				'author',
				'thumbnail',
				'excerpt',
				'custom-fields',
				'revisions'
			),
			'rewrite' => array(
				'slug' => 'service',
				'with_front' => false,
			),
			'description' => 'Services the City of Asheville provides'
		)
	);

	register_post_type('avl_department_page',
		array(
			'labels' => array(
				'name' => 'Department Pages',
				'singular_name' => 'Department Page',
				'add_new_item' => 'Add New Department Page',
				'edit_item' => 'Edit Department Page',
			),
			'public' => true,
			'has_archive' => true,
			'hierarchical' => true,
			'menu_icon' => 'dashicons-building',
			'taxonomies' => array( 'avl_department' ),
			'capability_type' => 'avl_department_page',
			'map_meta_cap' => true,
			'supports' => array(
				'title',
				'editor',
				'author',
				'thumbnail',
				'excerpt',
				'page-attributes',
				'custom-fields',
				'revisions'
			),
			'rewrite' => array(
				'slug' => 'department',
				'with_front' => false,
			),
			'description' => 'Department pages for the City of Asheville'
		)
	);
}
add_action( 'init', 'avl_register_post_types' );

function avl_register_taxonomies() {
	register_taxonomy('avl_service_type', 'avl_service',
		array(
			'labels' => array(
				'name' => 'Service Types',
				'singular_name' => 'Service Type',
			),
			'hierarchical' => true,
			'show_admin_column' => true,
			'update_count_callback' => '_update_post_term_count',
			'rewrite' => array(
				'slug' => 'services',
				'hierarchical' => true,
				'with_front' => false,
			)
		)
	);

	register_taxonomy('avl_department', array( 'post', 'avl_department_page', 'avl_service' ),
		array(
			'labels' => array(
				'name' => 'Departments',
				'singular_name' => 'Department',
			),
			'hierarchical' => true,
			'show_admin_column' => true,
			'update_count_callback' => '_update_post_term_count',
			'rewrite' => array(
				'slug' => 'departments',
				'hierarchical' => true,
				'with_front' => false,
			)
		)
	);
}
add_action( 'init', 'avl_register_taxonomies' );

function avl_custom_rewrite_rules() {
	// News archive, must add category_name=news to make wordpress use archive-post.php
	add_rewrite_rule('^news/?$', 'index.php?post_type=post&category_name=news', 'top');
	add_rewrite_rule('^news/page/([0-9]+)/?$', 'index.php?post_type=post&category_name=news&paged=$matches[1]', 'top');

	add_rewrite_rule('^news/category/([a-z0-9-]+)/?$', 'index.php?post_type=post&category_name=$matches[1]', 'top');
	add_rewrite_rule('^news/category/([a-z0-9-]+)/page/([0-9]+)/?$', 'index.php?post_type=post&category_name=$matches[1]&paged=$matches[2]', 'top');

	add_rewrite_rule('^news/tag/([a-z0-9-]+)/?$', 'index.php?post_type=post&category_name=news&tag=$matches[1]', 'top');
	add_rewrite_rule('^news/tag/([a-z0-9-]+)/page/([0-9]+)/?$', 'index.php?post_type=post&category_name=news&tag=$matches[1]&paged=$matches[2]', 'top');

	add_rewrite_rule('^news/department/([a-z0-9-]+)/?$', 'index.php?post_type=post&category_name=news&avl_department=$matches[1]', 'top');
	add_rewrite_rule('^news/department/([a-z0-9-]+)/page/([0-9]+)/?$', 'index.php?post_type=post&category_name=news&avl_department=$matches[1]&paged=$matches[2]', 'top');

	add_rewrite_rule('^news/([0-9]{4})/page/([0-9]+)/?$', 'index.php?post_type=post&category_name=news&year=$matches[1]&paged=$matches[2]', 'top');
	add_rewrite_rule('^news/([0-9]{4})/?$', 'index.php?post_type=post&category_name=news&year=$matches[1]', 'top');

	add_rewrite_rule('^news/([0-9]{4})/([0-9]{2})/page/([0-9]+)/?$', 'index.php?post_type=post&category_name=news&year=$matches[1]&monthnum=$matches[2]&paged=$matches[3]', 'top');
	add_rewrite_rule('^news/([0-9]{4})/([0-9]{2})/?$', 'index.php?post_type=post&category_name=news&year=$matches[1]&monthnum=$matches[2]', 'top');

	// Services archive
	add_rewrite_rule("^services/?$", "index.php?post_type=avl_service", "top");
	add_rewrite_rule('^services/department/([a-z0-9-]+)/?$', 'index.php?post_type=avl_service&avl_department=$matches[1]', 'top');

	//add_rewrite_rule('^services/([a-z0-9-]+)/service/([a-z0-9-]+)/?$', 'index.php?avl_service=$matches[2]', 'top');
	//add_rewrite_rule('^services/([a-z0-9-]+)/([a-z0-9-]+)/service/([a-z0-9-]+)/?$', 'index.php?avl_service=$matches[3]', 'top');
}
add_action( 'init', 'avl_custom_rewrite_rules' );

// KRK: prepend taxonomy terms to service link, removed for now

function avl_service_link( $url, $post ) {
	if (( $post->post_type == 'avl_service' ) && ( $post->post_status != 'draft' )) {
		if ( $terms = get_the_terms( $post, 'avl_service_type' ) ) {
			//$url = str_replace( '%avl_service_type%', $terms[0]->slug, $url );
			$url = get_term_link($terms[0]) .'service/'. $post->post_name .'/';
		} else {
			//$url = str_replace( '%avl_service_type%', 'uncategorized', $url );
			$url = get_home_url() .'/services/uncategorized/service/'. $post->post_name .'/';
		}
	}

	return $url;
}
//add_filter( 'post_type_link', 'avl_service_link', 10, 2 );

function avl_post_archive_link( $link, $post_type ) {
	if ( $post_type == 'post' ) {
		$link = site_url( '/news/' );
	}

	return $link;
}
add_filter( 'post_type_archive_link', 'avl_post_archive_link', 10, 2 );

function avl_service_archive_link( $link, $post_type ) {
	if ( $post_type == 'avl_service' ) {
		$link = site_url( '/services/' );
	}

	return $link;
}
add_filter( 'post_type_archive_link', 'avl_service_archive_link', 10, 2 );

function avl_category_link( $link, $term, $taxonomy ) {
	if ( $taxonomy == 'category' ) {
		if ( $term->slug == 'news' )
			$link = site_url( '/news/' );
		else
			$link = site_url( '/news/category/'. $term->slug .'/' );
	}

	return $link;
}
add_filter('term_link', 'avl_category_link', 10, 3);

function avl_department_link( $link, $term, $taxonomy ) {
	if ( $taxonomy == 'avl_department' ) {
		$link = site_url( '/news/department/'. $term->slug .'/' );
	}

	return $link;
}
add_filter('term_link', 'avl_department_link', 10, 3);

function avl_tag_link( $link, $term, $taxonomy ) {
	if ( $taxonomy == 'post_tag' ) {
		$link = site_url( '/news/tag/'. $term->slug .'/' );
	}

	return $link;
}
add_filter('term_link', 'avl_tag_link', 10, 3);

function avl_get_archives_link( $link_html, $url, $text, $format, $before, $after ) {
	if ($format == 'custom') {
		$active = false;

		if ( get_query_var( 'year' ) && get_query_var( 'monthnum' ) ) {
			if ( avl_month_link('', get_query_var( 'year' ), get_query_var( 'monthnum' )) == $url )
				$active = true;
		} else if ( get_query_var( 'year' ) ) {
			if ( avl_year_link('', get_query_var( 'year' )) == $url )
				$active = true;
		}

		$link_html = '<a href="'. $url .'" class="list-group-item list-group-item-action'. (($active)?' active':'') .'">'. $text .'</a>';
	}

	return $link_html;
}
add_filter( 'get_archives_link', 'avl_get_archives_link', 10, 6 );

function avl_month_link( $monthlink, $year, $month ) {
	$monthlink = site_url( 'news/'. $year .'/'. zeroise($month, 2) .'/' );
	return $monthlink;
}
add_filter( 'month_link', 'avl_month_link', 10, 3 );

function avl_year_link( $yearlink, $year ) {
	$yearlink = site_url( 'news/'. $year .'/' );
	return $yearlink;
}
add_filter( 'year_link', 'avl_year_link', 10, 2 );

function avl_pre_get_posts( $query ) {
	if ( (! $query->is_main_query()) || $query->is_admin )
		return;

	if ( is_front_page() && is_home() ) {
		$query->set( 'posts_per_page', 3 );
		return;
	}

	if ( is_category('news') ) {
		// $query->set( 'category_name', 'featured' );
		$query->set( 'posts_per_page', 17 );
		return;
	}

	if ( is_post_type_archive('avl_service') ) {
		$query->set( 'order', 'ASC' );
		$query->set( 'orderby', 'title' );
		$query->set( 'posts_per_page', -1 );
		return;
	}

	if ( is_tax('avl_service_type') ) {
		$query->set( 'order', 'ASC' );
		$query->set( 'orderby', 'title' );
		$query->set( 'posts_per_page', -1 );

		$tax_query = $query->tax_query->queries;
		$tax_query[0]['include_children'] = false;
		$query->set( 'tax_query', $tax_query );
		return;
	}
}
add_action( 'pre_get_posts', 'avl_pre_get_posts' );

function avl_static_breadcrumb_adder($trail) {
	// $trail->add(new bcn_breadcrumb('STATIC_TITLE', NULL, array('home'), 'STATIC_URL'));
	// https://github.com/mtekk/Breadcrumb-NavXT/blob/master/class.bcn_breadcrumb.php

	if ( is_category( 'news' ) && get_query_var( 'avl_department' ) ) {
		$term = get_term_by( 'slug', get_query_var( 'avl_department' ), 'avl_department' );

		array_shift($trail->breadcrumbs);
		array_unshift($trail->breadcrumbs, new bcn_breadcrumb('News', NULL, array( ), get_post_type_archive_link( 'post' )));
		array_unshift($trail->breadcrumbs, new bcn_breadcrumb($term->name, NULL, array( ), ''));
	} else if ( is_category() && ! is_category('news') ) {
		$term = get_queried_object();

		array_shift($trail->breadcrumbs);
		array_unshift($trail->breadcrumbs, new bcn_breadcrumb('News', NULL, array( ), get_post_type_archive_link( 'post' )));
		array_unshift($trail->breadcrumbs, new bcn_breadcrumb($term->name, NULL, array( ), ''));
	}
}
add_action('bcn_after_fill', 'avl_static_breadcrumb_adder');

function avl_bcn_pick_post_term( $term, $id, $type, $taxonomy ) {

	if (($type == 'post') && ($taxonomy == 'category')) {
		if ( $primary_category = get_post_meta($id, '_yoast_wpseo_primary_category', true) ) {
			$term = get_term_by( 'id', $primary_category, 'category' );
		} else if ( has_category( 'news', $id ) ) {
			$term = get_term_by( 'slug', 'news', 'category' );
		}
	}

	/*
	if (($type == 'post') && ($taxonomy == 'category')) {
		if ( has_category( 'news', $id ) ) {
			$term = get_term_by( 'slug', 'news', 'category' );
		}
	}
	*/

	return $term;
};
add_filter( 'bcn_pick_post_term', 'avl_bcn_pick_post_term', 10, 4 );
?>
