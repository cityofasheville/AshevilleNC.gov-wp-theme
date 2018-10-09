<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Asheville
 */

get_header();
?>
<div class="container">
	<div class="row">
	<section id="primary" class="content-area col-sm-12">
		<main id="main" class="site-main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header mb-3">
				<h1 class="page-title">
					<?php
					printf( esc_html__( 'Search Results for: %s', 'avl' ), '<span>' . get_search_query() . '</span>' );
					?>
				</h1>
				<?php avl_content_pagination_place(); ?>
			</header>
			
			<div class="card-columns">
			<?php
			
			while ( have_posts() ) {
				the_post();
				get_template_part( 'template-parts/content', get_post_type() );
			}
			?>
			</div>
			
			<?php
			//the_posts_navigation();
			avl_content_pagination();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

		</main>
	</section>
<?php
//get_sidebar();
?>
	</div>
</div>
<?php
get_footer();
?>