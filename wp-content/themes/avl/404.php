<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Asheville
 */

get_header();
?>

	<div id="primary" class="content-area">
		<div class="container">
			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'avl' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php esc_html_e( 'It looks like nothing was found at this URL.', 'avl' ); ?></p>

					<div class="mb-4">
						<?php
						get_search_form();
						?>
					</div>

				<p class="mx-auto col-lg-10"><span class="icon icon-self-timer2 icon-1x icon-avl-green mr-2"></span>This website is under construction.  If you can't find something or you have run into a bug, please <a href="#feedback-button">tell us</a> so we can fix it!  In the meantime, you can still <a href="#old-search">search</a> or <a href="https://ashevillenc.gov" target="_blank" rel="noopener noreferrer">visit</a> the old site.</p>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</div><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
