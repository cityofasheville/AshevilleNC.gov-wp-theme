<?php
/**
 * The sidebar containing the services widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Asheville
 */

if ( ! is_active_sidebar( 'sidebar-services' ) ) {
	return;
}
?>
	<aside id="secondary" class="widget-area col-md-4">
		<?php dynamic_sidebar( 'sidebar-services' ); ?>
	</aside>