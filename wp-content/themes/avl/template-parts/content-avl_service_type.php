<?php
/**
 * Template part for displaying Services Types in the loop
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Asheville
 */
?>
<div id="term-<?= $term->term_id; ?>" class="card h-100">
	<?= '<a href="'. get_term_link($term) .'" class="card-header entry-title text-primary h5"><i class="icon icon-folder text-secondary mr-2"></i>'. $term->name .'</a>'; ?>
	<div class="card-body">
		<p class="card-text entry-content"><?= $term->description; ?></p>
		<h6 class="card-subtitle entry-meta accessible-text-muted"><?= $term->count; ?> Services</h6>
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
</div>
