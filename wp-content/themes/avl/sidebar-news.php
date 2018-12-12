<?php
/**
 * The sidebar containing the News widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Asheville
 */

if ( ! is_active_sidebar( 'sidebar-news' ) ) {
	return;
}
?>
	<aside id="secondary" class="widget-area col-md-4">
		<?php dynamic_sidebar( 'sidebar-news' ); ?>
	</aside>