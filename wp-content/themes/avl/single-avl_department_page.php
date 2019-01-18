<?php
/**
 * The template for displaying single department pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Asheville
 */
get_header();
global $post;
?>
<div class="container">
	<div class="row">
	<div id="primary" class="content-area col-sm-12">
		<div class="site-main">
		<?php
		while ( have_posts() ) {
			the_post();

			if ( $post->post_parent == 0 )
				get_template_part( 'template-parts/content-single-home', get_post_type() );
			else
				get_template_part( 'template-parts/content-single', get_post_type() );

			//the_post_navigation();

			if ( comments_open() || get_comments_number() )
				comments_template();
		}
		?>
	</div>
	</div>
<?php
	//get_sidebar();
?>
	</div>
</div>
<?php
get_footer();
?>
