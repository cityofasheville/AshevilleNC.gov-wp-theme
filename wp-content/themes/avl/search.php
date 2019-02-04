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
		<div class="site-main">

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


	</div>
	</section>
	</div>
	<div class="row mt-5 mb-5">
		<div class="col-md-12">
			<div class="h4">Didn't find what you were looking for?</div>
			<label>Use the box below to search the old website.</label>
		</div>
		<div class="input-group-prepend">
				<span class="input-group-text">Search:</span>
		</div>
		<script src="https://addsearch.com/js/?key=6a1fe1ca3441a659c41360b0529a8baa&amp;categories=0xwww.ashevillenc.gov"></script>
	</div>
</div>
<?php
get_footer();
?>
