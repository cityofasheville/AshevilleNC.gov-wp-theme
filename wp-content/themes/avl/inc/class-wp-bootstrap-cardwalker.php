<?php
class WP_Bootstrap_Cardwalker extends Walker_Nav_Menu {
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'card';
		$classes[] = 'text-center';
		$classes[] = 'mb-3';

		$icon_classes = array();

		foreach ($classes as $key => $value) {
			if (strpos($value, 'icon') !== false) {
				$icon_classes[] = $value;
				unset($classes[$key]);
			}
		}

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		if ( $depth == 0 ) {
			$output .= '<div class="col-sm-6 col-lg-4">';
			$output .= '<div' . $id . $class_names . '>';
		}

		$attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
		$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr($item->target) . '"' : '';
		$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
		$attributes .= ! empty( $item->url ) ? ' href="' . esc_attr($item->url) . '"' : '';

		if ( $args->walker->has_children ) {
			$attributes .= ' class="card-header h3"';
		} else {
			if ( $depth > 0 ) {
				$attributes .= ' class="list-group-item list-group-item-action'. (empty($item->classes)?'':' '. trim(implode(' ', $item->classes))) .'"';
			} else {
				$attributes .= ' class="card-link"';
			}
		}

		if (! empty($icon_classes)) {
			$icon_html = '<span class="'. implode(' ', $icon_classes) .'"></span>';
		} else {
			$icon_html = '';
		}

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . $icon_html . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters ( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	public function end_el( &$output, $item, $depth = 0, $args = array() ) {
		if ( $depth == 0 ) {
			// end card
			$output .= '</div>';
			// end col
			$output .= '</div>';
		}
	}

	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$output .= '<div class="list-group list-group-flush">';
	}

	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		$output .= '</div>';
	}
}
?>
