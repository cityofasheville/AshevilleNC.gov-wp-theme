<?php
/**
 * Template part for displaying content of single home department pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Asheville
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('mb-5'); ?>>
<div class="row">
	<div class="col-md-8">
		<header class="entry-header">
			<h2 class="entry-title mb-3">What we do</h2>
		</header>
		<div class="entry-content">
			<?php
			the_content( sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'avl' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'avl' ),
				'after'  => '</div>',
			) );
			?>
		</div>
	</div>

	<div class="col-md-4">
		<?php
		if ( have_rows('connect_info') || have_rows('connect_social') ) {
			echo '<div class="card entry-meta mb-3">';
			echo '<h3 class="card-header">Connect</h3>';

			if ( have_rows('connect_info') ) {
				echo '<ul class="list-group list-group-flush">';

				while ( have_rows('connect_info') ) {
					the_row();

					echo '<li class="list-group-item">';
					echo '<h6>'. get_sub_field('title') .'</h6>';
					the_sub_field('details');
					echo '</li>';
				}

				echo '</ul>';
			}

			if ( have_rows('connect_social') ) {
				echo '<div class="card-body">';

				while ( have_rows('connect_social') ) {
					the_row();

					echo '<a href="'. get_sub_field('link') .'" target="_blank" class="card-link"><span class="icomoon icomoon-'. get_sub_field('network') .' icon-2x"></span></a>';
				}

				echo '</div>';
			}

			echo '</div>';
		}
		?>
	</div>
</div>
	<?php
		global $post;

		if ( $terms = get_the_terms($post, 'avl_department') )
			$term_ids = wp_list_pluck($terms, 'term_id');
		else
			$term_ids = array();

		$args = array(
			'post_type' => 'avl_service',
			'tax_query' => array(
				array(
					'taxonomy'	=> 'avl_department',
					'field'		=> 'term_id',
					'terms'		=> $term_ids,
				)
			),
			'posts_per_page' => 12,
		);

		$services = new WP_Query($args);

		if ( $services->have_posts() ) {
			echo '<section>';
			echo '<h2 class="mb-3">Related Services</h2>';
			echo '<div class="row">';

			while ( $services->have_posts() ) {
				$services->the_post();

				echo '<div class="col-sm-6 col-md-4 col-xl-3 pb-4">';
				get_template_part( 'template-parts/content', get_post_type() );
				echo '</div>';
			}

			echo '</div>';

			wp_reset_postdata();

			$archive_link = get_post_type_archive_link( 'avl_service' ) .'department/'. $post->post_name .'/';

			echo '<div class="d-flex justify-content-end mb-3">';
			echo '<a href="'. $archive_link .'" role="button" class="btn btn-outline-info">More Related Services <span class="icon icon-chevron-right"></span></a>';
			echo '</div>';

			echo '</section>';
		}

		$args = array(
			'post_type' => 'post',
			'tax_query' => array(
				array(
					'taxonomy'	=> 'avl_department',
					'field'		=> 'term_id',
					'terms'		=> $term_ids,
				)
			),
			'posts_per_page' => 3,
		);

		$news = new WP_Query($args);

		if ( $news->have_posts() ) {
			echo '<section>';
			echo '<h2 class="mb-3">' . $post->post_title . ' News</h2>';
			echo '<div class="row">';

			while ( $news->have_posts() ) {
				$news->the_post();

				echo '<div class="col-sm-6 col-md-4 pb-4">';
				get_template_part( 'template-parts/content', get_post_type() );
				echo '</div>';
			}

			echo '</div>';

			wp_reset_postdata();

			$archive_link = get_post_type_archive_link( 'post' ) .'department/'. $post->post_name .'/';

			echo '<div class="d-flex justify-content-end mb-3">';
			echo '<a href="'. $archive_link .'" role="button" class="btn btn-outline-info">More '. $post->post_title .' News <span class="icon icon-chevron-right"></span></a>';
			echo '</div>';

			echo '</section>';
		}
	?>

	<!-- <footer class="entry-footer">
		<?php
		avl_entry_footer();
		?>
	</footer> -->
</article>
