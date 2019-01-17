<?php
/**
 * Template part for displaying Services in the loop
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Asheville
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('card bg-light border-secondary h-100'); ?>>
<?php
	if ( has_post_thumbnail() ) {
?>
	<a class="post-thumbnail" href="<?php the_permalink(); ?>">
		<?php the_post_thumbnail('medium', array('class' => 'card-img-top h-auto')); ?>
	</a>
<?php
	}
?>
	<div class="card-body">
		<?php the_title( '<span class="card-title entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></span>' ); ?>
		<p class="card-text entry-content"><?php echo get_the_excerpt(); ?></p>
	</div>
<?php
	if ( is_search() ) {
?>
	<div class="card-footer entry-footer">
		<?php avl_entry_footer(); ?>
	</div>
<?php
	}
?>
</article>
