<?php
/**
 * Template part for displaying content of single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Asheville
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('mb-5'); ?>>
	<header class="entry-header mb-3 text-center">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta accessible-text-muted">
				<?php
				avl_posted_on();
				avl_posted_by();
				?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php avl_post_thumbnail(); ?>

  <div class="row">
		<?php
    if ( 'avl_service' === get_post_type() ) :
      echo '<div class="entry-content col-md-9">';
    else :
      echo '<div class="entry-content">';
    endif;

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

    <?php
    if ( 'avl_service' === get_post_type() ) :
    	?>
      <div class="col-md-3">
        <div class="card entry-meta mb-3">
          <div class="h3 card-header">Questions?</div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item">
              <div class="h6">General Support</div>
              828-251-1122
            </li>
          </ul>
        </div>
      </div>
    <?php endif; ?>

  </div>

	<footer class="entry-footer"><?php avl_entry_footer(); ?></footer>
</article>
