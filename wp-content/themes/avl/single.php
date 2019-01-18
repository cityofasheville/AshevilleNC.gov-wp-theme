<?php
/**
 * The template for displaying single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Asheville
 */
get_header();
?>
<div class="container">
	<div class="row">
	<div id="primary" class="content-area col-sm-12 col-lg-8">
		<div class="site-main">
		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content-single', get_post_type() );

			//the_post_navigation();

			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile;
		?>
	</div>
	</div>
<?php
	get_sidebar('post');
?>
	</div>
</div>
<?php
get_footer();
?>
