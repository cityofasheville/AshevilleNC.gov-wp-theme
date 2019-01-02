<?php
/**
 * The sidebar containing the Post widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Asheville
 */

if ( ! is_active_sidebar( 'sidebar-post' ) ) {
	return;
}
?>
	<aside id="secondary" class="widget-area col-sm-12 col-lg-4">
		<?php dynamic_sidebar( 'sidebar-post' ); ?>
	</aside>