<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Asheville
 */

get_header();
?>
<div class="container">
	<header class="page-header">
		<h1 class="page-title">City Source</h1>
		<?php
		if ( get_query_var( 'avl_department' ) ) {
			$term = get_term_by( 'slug', get_query_var( 'avl_department' ), 'avl_department' );
			echo '<h2>Department: '. $term->name .'</h2>';
		} else if ( is_category('news') ) {
			the_archive_description( '<div class="archive-description">', '</div>' );
		} else {
			the_archive_title( '<h2>', '</h2>' );
			the_archive_description( '<div class="archive-description">', '</div>' );
		}
		?>
	</header>

	<?php
	function avl_featured_post() {
		global $exhausted, $featured_ids;

		if ( $exhausted ) {
			avl_the_post();
			return;
		}

		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();

				if ( has_category('featured') ) {
					$featured_ids[] = get_the_ID();
					return;
				}
			}
		}

		// Exhausted: no more featured post found
		$exhausted = true;
		rewind_posts();
		avl_the_post();
	}

	function avl_the_post() {
		global $featured_ids;

		while ( have_posts() ) {
			the_post();

			if (! in_array(get_the_ID(), $featured_ids) ) {
				return;
			}
		}
	}

	global $wp_query;
	$exhausted = false;
	$featured_ids = array();

	if ( (! is_paged() ) && ( $wp_query->post_count > 5 ) ) {
	?>
	<div id="fbox-wrap" class="row featured-news">
		<div class="col-lg-6 pb-4 fbox-main">
			<?php
			avl_featured_post();
			get_template_part( 'template-parts/content-featured-main', get_post_type() );
			?>
		</div>
		<div class="col-lg-6 fbox-sub">
			<div class="row">
				<div class="col-sm-6 pb-4">
					<?php
					avl_featured_post();
					get_template_part( 'template-parts/content-featured', get_post_type() );
					?>
				</div>
				<div class="col-sm-6 pb-4">
					<?php
					avl_featured_post();
					get_template_part( 'template-parts/content-featured', get_post_type() );
					?>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6 pb-4">
					<?php
					avl_featured_post();
					get_template_part( 'template-parts/content-featured', get_post_type() );
					?>
				</div>
				<div class="col-sm-6 pb-4">
					<?php
					avl_featured_post();
					get_template_part( 'template-parts/content-featured', get_post_type() );
					?>
				</div>
			</div>
		</div>
	</div>
	<?php
	}
	?>
	<div class="row">
	<div id="primary" class="content-area col-md-8">
		<div class="site-main">
			<?php
			$news_count = 0;

			if (! $exhausted ) {
				rewind_posts();
			}

			while ( have_posts() ) {
				the_post();

				if ( in_array(get_the_ID(), $featured_ids) )
					continue;

				$news_count++;

				if ($news_count == 1) {
					echo '<h3>Latest News</h3>';
					echo '<div class="row">';
				}

				echo '<div class="col-lg-6 pb-4">';
				get_template_part( 'template-parts/content', get_post_type() );
				echo '</div>';
			}

			if ($news_count > 0)
				echo '</div>';
			else
				echo 'No news found.';

			avl_content_pagination();

			if ( is_paged() ) {
				avl_content_pagination_place();
			}
			?>
		</div>
	</div>
<?php
get_sidebar('news');
?>
	</div>
</div>
<?php
get_footer();
?>
