<?php
/**
 * The template for displaying Services by Type
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Asheville
 */

get_header();
/*
echo get_query_var( 'term' );
echo get_query_var( 'taxonomy' );
echo single_cat_title( '', false );
echo single_term_title();

*/

$term_parent = get_queried_object();

$term_children = get_terms( array(
	'taxonomy' => $term_parent->taxonomy,
	'parent' => $term_parent->term_id,
	'hide_empty' => false,
) );
?>
<div class="container">
	<div class="row">
	<div id="primary" class="content-area col-sm-12">
		<main id="main" class="site-main">
		<?php if ( have_posts() ) { ?>
			<header class="page-header">
				<?php
				echo '<h1 class="page-title">'. single_term_title( '', false ) .'</h1>';
				the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header>
			<div class="row">
			<?php
			
			// Loop through child Service Types
			if (! empty($term_children)) {
				foreach ($term_children as $term) {
					echo '<div class="col-sm-6 col-md-4 col-xl-3 pb-4">';
					include( locate_template( 'template-parts/content-avl_service_type.php') );
					echo '</div>';
				}
			}
			
			// Loop through Services
			while ( have_posts() ) {
				the_post();
				echo '<div class="col-sm-6 col-md-4 col-xl-3 pb-4">';
				get_template_part( 'template-parts/content', get_post_type() );
				echo '</div>';
			}
			?>
			</div>
			
			<?php
			//the_posts_navigation();
		} else {
			get_template_part( 'template-parts/content', 'none' );
		}
		?>
		</main>
	</div>
<?php
//get_sidebar();
?>
	</div>
</div>
<?php
get_footer();
?>