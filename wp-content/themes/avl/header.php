<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Asheville
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-16340971-17"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', 'UA-16340971-17');
	</script>
</head>
<body <?php body_class(); ?>>
<div id="page" class="site">
	<header id="masthead" class="site-header">
		<nav class="primary-navbar navbar navbar-expand-lg navbar-dark bg-avl-blue shadow-sm">
			<div class="container-fluid">
				<a class="navbar-brand align-self-end" href="<?= home_url( '/' ) ?>">
				<?php
					if ( $custom_logo_id = get_theme_mod( 'custom_logo' ) ) {
						$custom_logo_attr = array(
							'class' => 'custom-logo',
						);

						echo wp_get_attachment_image( $custom_logo_id, 'full', false, $custom_logo_attr );
					} else {
						bloginfo( 'name' );
					}
				?>
				</a>
				<button
					type="button"
					class="navbar-toggler"
					data-toggle="collapse"
					data-target="#toggle-container"
					aria-controls="toggle-container"
					aria-expanded="false"
					aria-label="Toggle navigation"
				>
					<span class="navbar-toggler-icon"></span>
				</button>
				<div id="toggle-container" class="collapse navbar-collapse justify-content-end">
					<?php
					wp_nav_menu(array(
						'depth'			=> 2,
						'theme_location'	=> 'primary',
						'container'		=> 'div',
						'container_id'		=> 'site-navigation',
						'container_class'	=> 'main-navigation',
						'menu_class'		=> 'navbar-nav',
						'menu_id'			=> 'primary-menu',
						'fallback_cb'		=> 'WP_Bootstrap_Navwalker::fallback',
						'walker'			=> new WP_Bootstrap_Navwalker(),
					));
					?>
					<?php
					if (! ( is_front_page() && is_home() ) ) {
						get_template_part( 'searchform-header' );
					}
					?>
				</div>
			</div>
		</nav>

		<div class="content">

			<div class="mr-2 col-sm-12 text-center text-avl-blue" id="sub-nav-beta-msg">This website is new and still needs work.  Please <a href="#feedback-button">tell us what's missing</a>!  In the meantime you can still <a href="#old-search-button">search</a> or <a href="https://ashevillenc.gov" target="_blank" rel="noopener noreferrer">visit</a> the old site.</div>

			<div id="translate-parent" class="d-flex">
				<div id="google-translate" class="p-0 ml-auto"></div>
			</div>
		</div>

		<?php
			if ( is_front_page() && is_home() ) {
		?>
		<div id="splash" class="site-branding jumbotron jumbotron-fluid bg-transparent mb-0">
			<div class="container">
			<?php
				$avl_description = get_bloginfo( 'description', 'display' );
				if ( $avl_description || is_customize_preview() ) {
			?>
				<h1 class="site-description display-1 text-center mt-4"><?php echo $avl_description; ?></h1>
				<div class="row">
					<div class="col-12 col-lg-10 offset-lg-1 col-xl-8 offset-xl-2">
						<div class="my-5">
						<?php
							get_search_form();
						?>
						</div>
					</div>
				</div>
			<?php
				}
			?>
			</div>
		</div>
		<?php
		}

		if ( is_singular('avl_department_page') ) {
			$post = get_queried_object();

			if ( $post->post_parent == 0 ) {
				$parent_id = $post->ID;
			} else {
				//$parents = get_post_ancestors( $post->ID );
				//$parent_id = end($parents);
				$ancestors = $post->ancestors;
				$parent_id = end( $ancestors );
			}

			if ($thumbnail_id = get_post_thumbnail_id( $parent_id )) {
				$image_data = wp_get_attachment_image_src( $thumbnail_id, 'full' );
				$style = "background-image: url('". $image_data[0] ."');";
			} else {
				$style = '';
			}
		?>
		<div id="splash" class="d-flex flex-column mb-3">
			<div class="header-background-image" style="<?= $style; ?>"></div>
			<div class="my-auto mx-auto entry-title-container">
			</div>
			<?php
				$child_pages = get_children( array(
					'post_parent' => $parent_id,
					'post_type' => 'avl_department_page',
					'post_status' => 'publish',
					'orderby' => 'menu_order',
					'order' => 'ASC'
				) );

				echo '<nav class="nav navbar-expand-lg" aria-label="Department page navigation"><div class="container"><div class="row">';
				echo '<h1 class="department-title">' . apply_filters( 'the_title', get_the_title( $parent_id ) ) .'</h1>';

				if (! empty( $child_pages )) {

					echo '<button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#child-pages-nav" aria-controls="child-pages-nav" aria-expanded="false" aria-label="Toggle navigation">';
						echo '<span class="dropdown-toggle"></span>';
					echo '</button>';

					echo '<div class="collapse navbar-collapse" id="child-pages-nav"><ul class="navbar-nav ml-auto">';
					echo '<li class="nav-item ' . (($post->ID == $parent_id)?'active':'') .'"><a class="nav-link" href="'. get_permalink( $parent_id ) .'">Home</a></li>';

					foreach ($child_pages as $page) {
						echo '<li class="nav-item '. (($post->ID == $page->ID)?'active':'') .'" ><a class="nav-link" href="'. get_permalink( $page ) .'">'. $page->post_title .'</a></li>';
					}

					echo '<ul></div>';
				}
				echo '</div></nav>';

			?>
		</div>
		<?php
		}
		?>
	</header>

	<?php
		if ( function_exists('bcn_display') && (! ( is_front_page() && is_home() ) ) ) {
	?>
	<div id="breadcrumbs-container" class="my-4">
		<div class="container">
			<div class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">
			<?php
				bcn_display();
			?>
			</div>
		</div>
	</div>
	<?php
		}
		/*
		KRK: yoast breadcrumbs... disabled for now
		if ( function_exists('yoast_breadcrumb') && (! ( is_front_page() && is_home() ) ) ) {
			yoast_breadcrumb( '<div id="breadcrumbs-container" class="my-3"><div class="container">','</div></div>' );
		}
		*/
	?>

	<main id="content" class="site-content">
