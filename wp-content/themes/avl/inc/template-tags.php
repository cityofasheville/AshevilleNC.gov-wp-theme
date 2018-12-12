<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Asheville
 */

function avl_content_pagination() {
	global $wp_query;
	$big = 999999999;
	$ppp = get_query_var('posts_per_page');
	$current = get_query_var('paged') ? get_query_var('paged') : 1;
	
	$args = array(
		'base'		=> str_replace( $big, '%#%', get_pagenum_link( $big ) ),
		'format'		=> '?paged=%#%',
		'current'		=> $current,
		'total'		=> $wp_query->max_num_pages,
		'prev_text'	=> '<i class="icon icon-chevron-left"></i>&nbsp;Previous',
		'next_text'	=> 'Next&nbsp;<i class="icon icon-chevron-right"></i>',
		'type'		=> 'list'
	);
	
	if ($links = paginate_links( $args )) {
		$links = str_replace("<ul class='page-numbers'>", "<ul class='pagination'>", $links);
		$links = str_replace("<li><span aria-current='page' class='page-numbers current'>", "<li class='page-item active'><span class='page-link'>", $links);
		$links = str_replace("<li>", "<li class='page-item'>", $links);
		$links = str_replace("page-numbers", "page-link", $links);
	}
	
	echo '<nav class="mb-4">'. $links .'</nav>';
}

function avl_content_pagination_place() {
	global $wp_query;
	$ppp = get_query_var('posts_per_page');
	$current = get_query_var('paged') ? get_query_var('paged') : 1;
	
	echo '<h6>Showing '. ($ppp*($current - 1) + 1) .'-'. ($ppp*($current - 1) + $wp_query->post_count) .' of '. $wp_query->found_posts .' results</h6>';
}

if ( ! function_exists( 'avl_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function avl_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated d-none" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'avl' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'avl_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function avl_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'avl' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'avl_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function avl_entry_footer() {
		
		// Post Type name badge
		$post_type = get_post_type_object( get_post_type() );
		echo '<a href="'. get_post_type_archive_link( get_post_type() ) .'" class="badge badge-primary bg-avl-blue">'. $post_type->labels->singular_name .'</a>';
		
		// Hide category and tag text for pages.
		if ( 'post' == get_post_type() ) {
			/*
			$categories_list = get_the_category_list( esc_html__( ', ', 'avl' ) );
			if ( $categories_list ) {
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'avl' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}
			
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'avl' ) );
			if ( $tags_list ) {
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'avl' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
			*/
			
			// KRK: Use bootstrap badges for categories
			$cats = get_the_category();
		
			if ( ! empty($cats) ) {
				foreach ($cats as $cat) {
					echo '<a href="'. get_category_link($cat->term_id) .'" rel="category tag" class="badge badge-info bg-avl-blue-75">'. $cat->name .'</a>';
				}
			}
			
			// KRK: Use bootstrap badges for department terms
			$terms = get_the_terms(get_the_ID(), 'avl_department');
			
			if ( ! empty($terms) ) {
				foreach ($terms as $term) {
					echo '<a href="'. get_term_link($term) .'" rel="category tag" class="badge badge-info bg-avl-green-75">'. $term->name .'</a>';
				}
			}
			
			// KRK: Use bootstrap badges for tags
			// Only show on single post
			
			if ( is_single() ) {
				$tags = get_the_tags();
				
				if ( ! empty($tags) ) {
					foreach ($tags as $tag) {
						echo '<a href="'. get_tag_link($tag) .'" rel="category tag" class="badge badge-secondary">'. $tag->name .'</a>';
					}
				}
			}
			
		} else if ( 'avl_service' == get_post_type() ) {
			// KRK: Use bootstrap badges for terms
			$terms = get_the_terms(get_the_ID(), 'avl_service_type');
			
			if ( ! empty($terms) ) {
				foreach ($terms as $term) {
					echo '<a href="'. get_term_link($term) .'" rel="category tag" class="badge badge-info bg-avl-blue-75">'. $term->name .'</a>';
				}
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			comments_popup_link(
				'',
				'1 <i class="icon icon-bubble-text"></i>',
				'% <i class="icon icon-bubbles"></i>',
				'badge badge-info'
			);
		}
		
		if ( is_single() ) {
		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit<span class="sr-only"> %s</span>', 'avl' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'',
			'',
			0,
			'badge badge-dark'
		);
		}
	}
endif;

if ( ! function_exists( 'avl_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function avl_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) {
		?>
			<figure class="post-thumbnail d-inline-block mb-3">
			<?php
				$featured_image = get_post( get_post_thumbnail_id() );
				the_post_thumbnail('medium_large', array('id' => 'featured-image', 'class' => 'img-fluid'));
				
				if ($featured_image->post_excerpt) {
					echo '<figcaption>';
					echo $featured_image->post_excerpt;
					echo '</figcaption>';
				}
			?>
			</figure>
		<?php
		} else {
		?>
			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail( 'post-thumbnail', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
				) ),
			) );
			?>
			</a>
		<?php
		}
	}
endif;
?>