<?php
/**
 * Events List Widget Template
 * This is the template for the output of the events list widget.
 * All the items are turned on and off through the widget admin.
 * There is currently no default styling, which is needed.
 *
 * This view contains the filters required to create an effective events list widget view.
 *
 * You can recreate an ENTIRELY new events list widget view by doing a template override,
 * and placing a list-widget.php file in a tribe-events/widgets/ directory
 * within your theme directory, which will override the /views/widgets/list-widget.php.
 *
 * You can use any or all filters included in this file or create your own filters in
 * your functions.php. In order to modify or extend a single filter, please see our
 * readme on templates hooks and filters (TO-DO)
 *
 * @version 4.5.13
 * @return string
 *
 * @package TribeEventsCalendar
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$events_label_plural = tribe_get_event_label_plural();
$events_label_plural_lowercase = tribe_get_event_label_plural_lowercase();

$posts = tribe_get_list_widget_events();

// Check if any event posts are found.
if ( $posts ) : ?>
	<div class="card-columns mb-3">
		<?php
		// Setup the post data for each event.
		foreach ( $posts as $post ) :
			setup_postdata( $post );
			?>
			<div class="card <?php tribe_events_event_classes() ?>">
				<?php
				if (
					tribe( 'tec.featured_events' )->is_featured( get_the_ID() )
					&& get_post_thumbnail_id( $post )
				) {
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
			</div>
		<?php
		endforeach;
		?>
	</div><!-- .tribe-list-widget -->

	<div class="d-flex justify-content-end">
		<a href="<?php echo esc_url( tribe_get_events_link() ); ?>" role="button" class="btn btn-outline-info"><?php printf( esc_html__( 'View All %s', 'the-events-calendar' ), $events_label_plural ); ?> <span class="icon icon-chevron-right"></span></a>
	</div>

<?php
// No events were found.
else : ?>
	<p><?php printf( esc_html__( 'There are no upcoming %s at this time.', 'the-events-calendar' ), $events_label_plural_lowercase ); ?></p>
<?php
endif;
?>
