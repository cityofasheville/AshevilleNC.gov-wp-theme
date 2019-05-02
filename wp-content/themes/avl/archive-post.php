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
			echo '<div class="h3">Department: '. $term->name .'</div>';
		} else if ( is_category('news') ) {
			the_archive_description( '<div class="archive-description">', '</div>' );
		} else {
			the_archive_title( '<div class="h3">', '</div>' );
			the_archive_description( '<div class="archive-description">', '</div>' );
		}
		echo get_sidebar('news');
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

	$featured_news_showing = (! is_paged() ) && ( $wp_query->post_count > 5 ) && $wp->request === 'news';
	// If it's not the second/etc page, there are more than 5 posts, and it's at /news

	if ( $featured_news_showing ) {
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
	// End of featured news showing section
	?>
	<div class="row">
	<div id="primary" class="content-area col-md-12">
		<div class="site-main">
			<?php
			$news_count = 0;

			if (! $exhausted ) {
				rewind_posts();
			}

			while ( have_posts() ) {
				the_post();

				if ( in_array(get_the_ID(), $featured_ids) ) {
					continue;
				}

				$news_count++;

				// If it's the first "more news" item, then show the title of the section
				if ($news_count == 1) {
					echo '<div class="d-flex news-title-sidebar mt-5">';
					// TODO: ADD COLUMN TO DEAL WITH WEIRD SPACING ON SMALLER SCREENS
					if ( $featured_news_showing ) {
						echo '<h2 class="mr-auto">More News</h2>';
					}
					echo '</div>';
					echo '<div class="row">';
				}

				echo '<div class="col-lg-4 pb-4">';
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
	</div>
</div>
<?php
get_footer();
?>
