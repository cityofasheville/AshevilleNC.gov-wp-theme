<div class="card <?php tribe_events_event_classes() ?>">
	<?php
	if (	tribe( 'tec.featured_events' )->is_featured( get_the_ID() )	&& get_post_thumbnail_id( $post ) ) {
		/**
		 * Fire an action before the list widget featured image
		 */
		do_action( 'tribe_events_list_widget_before_the_event_image' );

		/**
		 * Allow the default post thumbnail size to be filtered
		 *
		 * @param $size
		 */
		$thumbnail_size = apply_filters( 'tribe_events_list_widget_thumbnail_size', 'post-thumbnail' );

		/**
		 * Filters whether the featured image link should be added to the Events List Widget
		 *
		 * @since 4.5.13
		 *
		 * @param bool $featured_image_link Whether the featured image link should be added or not
		 */
		$featured_image_link = apply_filters( 'tribe_events_list_widget_featured_image_link', true );
		$post_thumbnail      = get_the_post_thumbnail( null, $thumbnail_size, array( 'class' => 'card-img-top h-auto' ) );

		if ( $featured_image_link ) {
			$post_thumbnail = '<a href="' . esc_url( tribe_get_event_link() ) . '">' . $post_thumbnail . '</a>';
		}

		// not escaped because it contains markup
		echo $post_thumbnail;

		/**
		 * Fire an action after the list widget featured image
		 */
		do_action( 'tribe_events_list_widget_after_the_event_image' );
	}
	?>

	<div class="card-body">
		<!-- Event Title -->
		<?php do_action( 'tribe_events_list_widget_before_the_event_title' ); ?>
		<span class="card-title">
			<a href="<?php echo esc_url( tribe_get_event_link() ); ?>" rel="bookmark"><?php the_title(); ?></a>
		</span>
		<?php do_action( 'tribe_events_list_widget_after_the_event_title' ); ?>

		<!-- Event Time -->
		<?php do_action( 'tribe_events_list_widget_before_the_meta' ) ?>
		<div class="card-subtitle mb-2 accessible-text-muted small">
			<?php echo tribe_events_event_schedule_details(); ?>
		</div>
		<?php do_action( 'tribe_events_list_widget_after_the_meta' ) ?>
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
