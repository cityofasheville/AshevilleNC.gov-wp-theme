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
<!-- Output of language_attributes is lang="[language]" -->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<!-- Above always outputs UTF-8 -->
	<!-- <meta http-equiv="X-UA-Compatible" content="IE=edge"> -->
	<!-- Performance hit, but makes IE browsers render using Edge engine -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- <link rel="profile" href="https://gmpg.org/xfn/11"> -->
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
					// https://developer.wordpress.org/reference/functions/wp_nav_menu/
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
			<!-- TODO: REMOVE AFTER DECOMMISSION OLD SITE -->
			<div class="mr-2 col-sm-12 text-center text-avl-blue" id="sub-nav-beta-msg"><span class="icon icon-self-timer2 icon-1x icon-avl-green mr-2"></span>This website is under construction.  Please <a href="#feedback-button">tell us what's missing</a>!  You can still <a href="#addsearch-input">search</a> or <a href="http://legacy.ashevillenc.gov" target="_blank" rel="noopener noreferrer">visit</a> the old site.</div>
			<!-- TODO: BETTER TRANSLATION WITH AWS -->
			<div id="translate-parent" class="d-flex">
				<div id="google-translate" class="p-0 ml-auto"></div>
			</div>
		</div>

		<?php
			if ( is_front_page() && is_home() ) {
			// Display search with background image if it's the home page
		?>
		<div id="splash" class="site-branding jumbotron jumbotron-fluid bg-transparent mb-0">
			<?php
			// JESSE @ PRC ADDED 6/2019
				$jumbotron_image = get_field('hero_banner', 'options');

				if(get_field('hero_banner', 'options')):
					$jumbotron_id = $jumbotron_image['ID'];
				else:
					$jumbotron_id = 198;
				endif;

				$hero_srcset = wp_get_attachment_image_srcset($jumbotron_image['ID'], array(2000, 1000, 1500, 750, 1000, 500, 750, 375), wp_get_attachment_metadata($jumbotron_image['ID']));
				// var_dump($jumbotron_image['sizes']);
			?>
			<div class="background">
				<img
					srcset="<?php echo $hero_srcset; ?>"
					src="<?php echo $jumbotron_image['sizes']['banner-large']; ?>"
					alt="<?php echo $jumbotron_image['alt']; ?>"
				/>
			</div>

			<div class="container">
			<?php
				$avl_description = get_bloginfo( 'description', 'display' );
				if ( $avl_description || is_customize_preview() ) {
			?>
				<!-- <h1 class="site-description display-1 text-center mt-4"><?php echo $avl_description; ?></h1> -->
				<?php
					get_search_form();
				?>
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
				$ancestors = $post->ancestors;
				$parent_id = end( $ancestors );
			}

			// PRC MODIFIED 6.2019 TO ALLOW SINGLE OVERRIDE
			if(has_post_thumbnail()):
				$thumbnail_id = get_post_thumbnail_id();
				$image_data = wp_get_attachment_image_src( $thumbnail_id, 'full' );
				$style = "background-image: url('". $image_data[0] ."');";
			else:
				if ($thumbnail_id = get_post_thumbnail_id( $parent_id )) {
					$image_data = wp_get_attachment_image_src( $thumbnail_id, 'full' );
					$style = "background-image: url('". $image_data[0] ."');";
				} else {
					$style = '';
				}
			endif;
		?>
		<div id="splash" class="d-flex flex-column mb-3">
			<div class="header-background-image" style="<?= $style; ?>"></div>
		</div>
		<div class="container">
			<h1 class="department-title">
				<?php echo apply_filters( 'the_title', get_the_title( $parent_id ) ) ?>
			</h1>
		</div>
		<?php
			$child_pages = get_children( array(
				'post_parent' => $parent_id,
				'post_type' => 'avl_department_page',
				'post_status' => 'publish',
				'orderby' => 'menu_order',
				'order' => 'ASC'
			) );
		?>
		<nav class="navbar-expand-lg" aria-label="Department page navigation" id="department-navbar">
			<div class="container">
			<?php
				if (! empty( $child_pages )) {
			?>
			<div class="row">
				<button
					class="navbar-toggler"
					type="button"
					data-toggle="collapse"
					data-target="#child-pages-nav"
					aria-controls="child-pages-nav"
					aria-expanded="false"
					aria-label="Toggle navigation"
				>
					<span class="navbar-toggler-icon float-right text-white"></span>
				</button>
				<div class="collapse navbar-collapse" id="child-pages-nav">
					<ul class="navbar-nav first-layer-nav">
						<?php
							echo '<li class="nav-item ' . (($post->ID == $parent_id)?'active':'') .'"><a class="nav-link" href="'. get_permalink( $parent_id ) .'">Home</a></li>';

							foreach ($child_pages as $page) {
          			$grandchild_pages = get_children( array(
          				'post_parent' => $page->ID,
          				'post_type' => 'avl_department_page',
          				'post_status' => 'publish',
          				'orderby' => 'title',
          				'order' => 'ASC'
          			));
                if (empty( $grandchild_pages )) {
  								echo '<li class="nav-item '. (($post->ID == $page->ID)?'active':'') .'" ><a class="nav-link" href="'. get_permalink( $page ) .'">'. $page->post_title .'</a></li>';
                } else {
  								echo '<li class="nav-item dropdown-col-md-6 dropdown nav-item '. (($post->ID == $page->ID)?'active':'') .'" >';
                  echo '<a href="#" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle nav-link" id="dept-menu-item-dropdown-' . $page->ID . '">' . $page->post_title . '</a>';

                  $grandchild_count = count($grandchild_pages);
                  $post_class = '';
                  if ($grandchild_count > 7) {
                    $post_class = 'many-children';
                  }

                  echo '<ul class="dropdown-menu dropdown-menu-right ' . $post_class . '" role="menu" aria-labelledby="dept-menu-item-dropdown-' . $page->ID . '">';

  								echo '<li class="menu-item nav-item '. (($post->ID == $page->ID)?'active':'') .'" ><a class="dropdown-item" href="'. get_permalink( $page ) .'">'. $page->post_title .' Home</a></li>';
    							foreach ($grandchild_pages as $grandchild_page) {
    								echo '<li class="menu-item nav-item '. (($post->ID == $grandchild_page->ID)?'active':'') .'" ><a class="dropdown-item" href="'. get_permalink( $grandchild_page ) .'">'. $grandchild_page->post_title .'</a></li>';
                  }
                  echo '</ul>';
                  echo '</li>';
                }
							}
							?>
					<ul>
				</div>
			<?php } ?>
		</div>
		</nav>
		<?php } // end if singular department page
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
