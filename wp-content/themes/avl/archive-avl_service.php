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
	<div id="primary" class="content-area">
		<div class="site-main">

		<?php if ( have_posts() ) : ?>

			<div class="row">
				<header class="page-header col-md-8">
					<h1 class="page-title"><span class="icon icon-drawer-full"></span> Services Directory</h1>
					<?php
					if ( get_query_var( 'avl_department' ) ) {
						$term = get_queried_object();

						echo '<h2>Department: '. $term->name .'</h2>';
					} else {
						//the_archive_title( '<h1 class="page-title">', '</h1>' );
						the_archive_description( '<div class="archive-description">', '</div>' );
					}
					?>
				</header>
				<?php
				get_sidebar('services');
				?>
			</div>


			<?php
			$az = array();
			$index = '';

			while ( have_posts() ) {
				the_post();

				$current = strtoupper(substr(get_the_title(), 0, 1));

				if ( $current != $index ) {
					// End previous card
					if ($index != '') {
						echo '</ul></div>';
					}

					// Start new card
					echo '<div class="card mb-4"><h2 class="card-header">'. $current .'</h2><ul class="list-group list-group-flush">';
					$index = $current;
				}

				echo '<li class="list-group-item">';
				the_title( '<h5><a href="' . get_permalink() . '">', '</a></h5>' );
				echo get_the_excerpt();
				echo '</li>';

				//get_template_part( 'template-parts/content', get_post_type() );
			}

			// End last card
			echo '</ul></div>';

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

		</div><!-- #main -->
	</div><!-- #primary -->
</div>
<?php
get_footer();
?>
