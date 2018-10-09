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
			'rewrite' => array('slug' => 'service'),
			'description' => 'Services The City of Asheville provides'
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
			'rewrite' => array('slug' => 'department'),
			'description' => 'Departmental pages for The City of Asheville'
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
				'hierarchical' => true
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
			)
		)
	);
}
add_action( 'init', 'avl_register_taxonomies' );

function avl_custom_rewrite_rules() {
	add_rewrite_rule("^services/?$", "index.php?post_type=avl_service", "top");
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

function avl_service_archive_link( $link, $post_type ) {
	if ( $post_type == 'avl_service' ) {
		$link = get_home_url() .'/services/';
	}
	
	return $link;
}
add_filter( 'post_type_archive_link', 'avl_service_archive_link', 10, 2 );

function avl_pre_get_posts( $query ) {
	if ( $query->is_admin || !$query->is_main_query() )
		return;
		
	if ( is_archive('avl_service') ) {
		$query->set( 'order', 'ASC' );
		$query->set( 'orderby', 'title' );
		$query->set( 'posts_per_page', -1 );
	}

	if ( is_tax('avl_service_type') ) {
		
		$query->set( 'order', 'ASC' );
		$query->set( 'orderby', 'title' );
		$query->set( 'posts_per_page', -1 );
		
		$tax_query = $query->tax_query->queries;
		$tax_query[0]['include_children'] = false;
		$query->set( 'tax_query', $tax_query );
	}
}
add_action( 'pre_get_posts', 'avl_pre_get_posts' );
?>