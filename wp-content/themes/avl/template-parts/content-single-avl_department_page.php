<?php
/**
 * Template part for displaying content of single department pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Asheville
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('mb-5'); ?>>
	<header class="entry-header mb-3">
		<?php
			the_title( '<h2 class="entry-title">', '</h2>' );
		?>
		<div class="entry-meta">

		</div>
	</header>
	<div class="entry-content">
		<?php
		$content = get_the_content();
		if (strlen($content) == 0 || is_null($content)) {
			echo '<p>We\'re still working on the content for this page.  In the meantime, please <a href="#old-search-button">search</a> or <a href="https://ashevillenc.gov" target="_blank" rel="noopener noreferrer">visit</a> the old site.</p>';
		}

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
	<footer class="entry-footer">
		<?php avl_entry_footer(); ?>
	</footer>
</article>
