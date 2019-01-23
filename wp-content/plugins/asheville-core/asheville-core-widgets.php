<?php
/*
Plugin Name: Asheville Core Widgets
Plugin URI: http://www.ashevillenc.gov
Description: This plugin contains the core widgets for Asheville.
Version: 0.1
Author: Kyle Kirkpatrick
Author URI: http://avlbeta.site
*/

function avl_register_widgets() {
	register_widget('AVL_Filter_Post_Taxonomy_Widget');
	register_widget('AVL_Post_Services_Widget');
	register_widget('AVL_Archives_Widget');
}
add_action('widgets_init', 'avl_register_widgets');

class AVL_Filter_Post_Taxonomy_Widget extends WP_Widget {

	public function __construct() {
		$widget_ops = array(
			'classname' => 'widget_avl_filter_post',
			'description' => 'Contextually filter Posts or Custom Post Types, depending on which archive the widget is added to, by City Department, Service Type or Category.'
		);

		parent::__construct('avl_filter_post_widget', 'Asheville Filter', $widget_ops);
	}

	public function form($instance) {
		$defaults = array(
			'title' => 'Departments',
			'taxonomy' => 'avl_department'
		);

		$instance = wp_parse_args((array) $instance, $defaults);
		$title = $instance['title'];
		$taxonomy = $instance['taxonomy'];

		?>
			<p>
				<label for="<?= $this->get_field_id('title'); ?>">Title:</label>
				<input class="widefat" id="<?= $this->get_field_id('title'); ?>" name="<?= $this->get_field_name( 'title' ); ?>" type="text" value="<?= esc_attr( $title ); ?>">
			</p>
			<p>
				<label for="<?= $this->get_field_id('taxonomy'); ?>">Taxonomy:</label>
				<select class="form-control" class="widefat" id="<?= $this->get_field_id('taxonomy'); ?>" name="<?= $this->get_field_name('taxonomy'); ?>">
					<option <?php selected( $taxonomy, 'avl_department'); ?> value="avl_department">Department</option>
					<option <?php selected( $taxonomy, 'avl_service_type'); ?> value="avl_service_type">Service Type</option>
					<option <?php selected( $taxonomy, 'category'); ?> value="category">Category</option>
				</select>
			</p>
		<?php
	}

	public function update($new_instance, $old_instance) {
		$instance = $old_instance;

		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['taxonomy'] = sanitize_text_field( $new_instance['taxonomy'] );

		return $instance;
	}

	public function widget($args, $instance) {
		extract($args);

		$tax_slug = array(
			'avl_department'	=> 'department',
			'avl_service_type'	=> 'service-type',
			'category'		=> 'category',
		);

		if ( empty( $tax_slug[$instance['taxonomy']] ) )
			return;

		$query_args = array(
			'taxonomy'	=> $instance['taxonomy'],
			'hide_empty'	=> false,
			'parent'		=> 0,
			'exclude'		=> '1',
		);

		if ( $terms = get_terms( $query_args ) ) {
			echo $before_widget;
			echo $before_title . $instance['title'] . $after_title;

			if ($instance['taxonomy'] == 'category')
				$term_active = get_query_var( 'category_name' );
			else
				$term_active = get_query_var( $instance['taxonomy'] );

			if ( get_query_var('post_type') ) {
				$archive_link = get_post_type_archive_link( get_query_var('post_type') );
			}
			else {
				$archive_link =  site_url( '/' );
			}

			$dropdown_id = $instance['title'] . '-dropdown-widget';

			echo '<label class="screen-reader-text visually-hidden" for="' . esc_attr( $dropdown_id ) . '">' . $instance['title'] . '</label>';
			echo '<select class="form-control" id="' . esc_attr( $dropdown_id ) . '" name="post-taxonomy-widget" onchange="document.location.href=this.options[this.selectedIndex].value;">';
			echo '<option value>Filter by ' . $instance['title'] . '</option>';

			foreach ($terms as $term) {
				$args = array(
					// Get all of them
					'posts_per_page'   => -1,
					// Services, news, etc
			    'post_type' => get_query_var('post_type'),
			    'tax_query' => array(
		        array(
	            'taxonomy' => $instance['taxonomy'],
	            'terms'    => $term->slug,
							'field'    => 'slug',
		        ),
			    ),
				);
				$query = new WP_Query( $args );
				$post_count = $query->post_count;
				$link = $archive_link . $tax_slug[$instance['taxonomy']] .'/'. $term->slug .'/';
				echo '<option ' . (($term->slug == $term_active)?'selected ':'') . '" value="'. $link .'" class="list-group-item list-group-item-action'. (($term->slug == $term_active)?' active':'') .'">'. $term->name . '  (' . $post_count . ')' .'</option>';
			}

			echo '</select>';

			echo $after_widget;
		}
	}
}

class AVL_Post_Services_Widget extends WP_Widget {
	public function __construct() {
		$widget_ops = array(
			'classname' => 'widget_avl_post_services',
			'description' => 'Displays any related Services to the Post'
		);

		parent::__construct('avl_post_services_widget', 'Asheville Post to Services', $widget_ops);
	}

	public function widget($args, $instance) {
		extract($args);
		$services = get_field('services');

		if ( $services ) {
			global $post;
			echo $before_widget;
			echo $before_title .'Related Services'. $after_title;

			foreach ($services as $post) {
				// override the global $post object
				setup_postdata($post);

				echo '<div class="mb-3">';
				get_template_part( 'template-parts/content', get_post_type() );
				echo '</div>';
			}

			echo $after_widget;

			wp_reset_postdata();
		}
	}
}

class AVL_Archives_Widget extends WP_Widget {

	/**
	 * Copy of default WP_Widget_Archives
	 *
	 * @since 2.8.0
	 */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'widget_archive',
			'description' => __( 'An archive of Asheville&#8217;s Posts.' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct('avl_archives', __('Asheville Archives'), $widget_ops);
	}

	public function widget( $args, $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Archives' );

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$c = ! empty( $instance['count'] ) ? '1' : '0';
		$d = ! empty( $instance['dropdown'] ) ? '1' : '0';

		echo $args['before_widget'];

		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		if ( true ) {
			$dropdown_id = "{$this->id_base}-dropdown-{$this->number}";
			?>
		<label class="screen-reader-text visually-hidden" for="<?php echo esc_attr( $dropdown_id ); ?>"><?php echo $title; ?></label>
		<select
			class="form-control"
			id="<?php echo esc_attr( $dropdown_id ); ?>"
			name="archive-dropdown"
			onchange='document.location.href=this.options[this.selectedIndex].value;'
		>
			<?php
			$dropdown_args = apply_filters( 'widget_archives_dropdown_args', array(
				'type'            => 'monthly',
				'format'          => 'option',
				'show_post_count' => $c
			), $instance );

			switch ( $dropdown_args['type'] ) {
				case 'yearly':
					$label = __( 'Filter by Year' );
					break;
				case 'monthly':
					$label = __( 'Filter by Month' );
					break;
				case 'daily':
					$label = __( 'Filter by Day' );
					break;
				case 'weekly':
					$label = __( 'Filter by Week' );
					break;
				default:
					$label = __( 'Filter by Post' );
					break;
			}
			?>

			<option value=""><?php echo esc_attr( $label ); ?></option>
			<?php wp_get_archives( $dropdown_args ); ?>

		</select>
		<?php } else { ?>
		<ul class="list-group">
		<?php
		wp_get_archives(array(
			'type' => 'monthly',
			'limit' => 12,
			'format' => 'custom',
			'show_post_count' => $c
		));

		wp_get_archives(array(
			'type' => 'yearly',
			'format' => 'custom',
			'show_post_count' => $c
		));
		?>
		</ul>
		<?php
		}

		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$new_instance = wp_parse_args( (array) $new_instance, array( 'title' => '', 'count' => 0, 'dropdown' => '') );
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['count'] = $new_instance['count'] ? 1 : 0;
		$instance['dropdown'] = $new_instance['dropdown'] ? 1 : 0;

		return $instance;
	}

	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'count' => 0, 'dropdown' => '') );
		$title = sanitize_text_field( $instance['title'] );
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
		<p>
			<input class="checkbox" type="checkbox"<?php checked( $instance['dropdown'] ); ?> id="<?php echo $this->get_field_id('dropdown'); ?>" name="<?php echo $this->get_field_name('dropdown'); ?>" /> <label for="<?php echo $this->get_field_id('dropdown'); ?>"><?php _e('Display as dropdown'); ?></label>
			<br/>
			<input class="checkbox" type="checkbox"<?php checked( $instance['count'] ); ?> id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" /> <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Show post counts'); ?></label>
		</p>
		<?php
	}
}
?>
