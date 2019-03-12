<?php
/**
 * The sidebar containing the search widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Asheville
 */

if ( ! is_active_sidebar( 'sidebar-search' ) ) {
	return;
}
?>
	<!-- <aside id="secondary" class="widget-area"> -->
		<?php dynamic_sidebar( 'sidebar-search' ); ?>
	<!-- </aside> -->
