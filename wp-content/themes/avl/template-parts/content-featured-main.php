<?php
/**
 * Template part for displaying main featured posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Asheville
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('card h-100'); ?>>
	<?php
	if ( has_post_thumbnail() ) {
	?>
	<a class="post-thumbnail flex-shrink-0" href="<?php the_permalink(); ?>">
		<?php the_post_thumbnail('large', array('class' => 'card-img-top h-auto')); ?>
	</a>
	<?php
	}
	?>
	<div class="card-body">
		<?php the_title( '<span class="card-title entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></span>' ); ?>
		<div class="card-subtitle mb-2 accessible-text-muted small entry-meta">
			<?php
			avl_posted_on();
			avl_posted_by();
			?>
		</div>
		<p class="card-text entry-content"><?php echo get_the_excerpt(); ?></p>
	</div>
</article>
