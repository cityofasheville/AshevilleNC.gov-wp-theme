<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Asheville
 */
?>
<div id="search-results-0"></div>
<div id="search-results-1"></div>
</main>
	<footer id="colophon" class="site-footer bg-avl-blue-75">
		<div class="footer-toggle-bar">
			<div class="bg-avl-blue">
				<div class="container feedback-container">
          <div class="ml-2">
  					<button
  						id="feedback-button"
  						class="navbar-toggler text-white mr-auto footer-toggle-button"
  						type="button"
  						data-toggle="collapse"
  						data-target="#toggle-feedback"
  						aria-controls="toggle-feedback"
  						aria-expanded="false"
  						aria-label="Open feedback form"
						>
  						<span class="icon icon-lamp-bright"></span> Feedback
  					</button>
  					<span class="text-white ml-2 mr-auto">
  						We're still working on this page's design and content. How can we make it better?
  					</span>
          </div>
				</div>
			</div>
			<div class="collapse" id="toggle-feedback">
				<div class="text-white bg-secondary py-3">
					<div class="container">
						<?= do_shortcode('[ninja_form id=1]'); ?>
					</div>
				</div>
			</div>
		</div>

		<div class="footer-toggle-bar" id="old-search">
			<div class="bg-avl-blue">
				<div class="container feedback-container">
					<div class="text-white row ml-2 mr-2">
						<div class="input-group input-group-md">
							<div class="input-group-prepend">
								<label class="input-group-text text-white bg-avl-blue"><span class="icomoon icomoon-search mr-3"></span> Search the old site</label>
							</div>
							<input type="text" class="addsearch form-control" disabled="disabled" id="addsearch-input" />
						</div>
						<div id="old-search-results"></div>
					</div>
				</div>
				<script>
					window.addsearch_settings = {
						link_target: '_blank',
						results_box_css_classname: 'addsearch-results',
					}
					jQuery('#addsearch-input').on('blur', function() {
						history.replaceState({}, '', window.location.href.replace(window.location.hash, ''));
					})
					jQuery('#addsearch-input').on('keyup', function() {
						var results = jQuery('#addsearch-results');
						jQuery('#old-search-results').append(results);
					})
				</script>
				<script id="old-civica-search" src="https://addsearch.com/js/?key=6a1fe1ca3441a659c41360b0529a8baa&amp;categories=0xwww.ashevillenc.gov"></script>
			</div>
		</div>

		<div class="container mt-5">
			<div class="row">
				<div class="col-3 col-sm-2 col-md-2 col-lg-1 pb-4">
					<a href="<?= home_url( '/' ); ?>">
						<?= wp_get_attachment_image( 109, 'full', false, array('class' => 'img-fluid footer-city-logo') ); ?>
					</a>
				</div>
				<div class="col-12 col-sm-5 col-md-6 col-lg-4 col-xl-3 pb-4">
					<div class="text-white site-info">
						<address>
						<strong class="span d-block card-title">The City of Asheville</strong>
						70 Court Plaza<br>
						P.O. Box 7148<br>
						Asheville, NC 28802
						</address>
						<span class="icon icon-telephone"></span> <a href="tel:8282511122" class="text-white">828-251-1122</a><br>
						<span class="icon icon-envelope"></span> <a href="mailto:webmaster@ashevillenc.gov" class="text-white">Webmaster</a>
					</div>
				</div>
				<div class="col-sm-5 col-md-4 col-lg-3 col-xl-4 pb-4">
					<span class="text-white card-title">Follow Us</span>
					<?php
					wp_nav_menu(array(
						'depth'			=> 2,
						'menu'			=> 'footer-social',
						'menu_class'		=> 'nav',
						'menu_id'			=> 'footer-social',
						'fallback_cb'		=> 'WP_Bootstrap_Navwalker::fallback',
						'walker'			=> new WP_Bootstrap_Navwalker(),
					));
					?>
				</div>
				<div class="offset-sm-2 col-lg-4 offset-lg-0 pb-4">
					<span class="text-white card-title">Stay in the loop</span>
					<p class="text-white">Sign up for our newsletter!</p>
					<form action="https://app.e2ma.net/app2/audience/signup/1890202/1778805/?r=signup" id="signup" method="post" name="signup">
						<input id="id_source" name="source" type="hidden">
						<input id="id_group_2578549" name="group_2578549" type="hidden" value="2578549">
						<input name="prev_member_email" type="hidden" value="">
						<input id="id_prev_member_email" name="prev_member_email" type="hidden">
						<div class="input-group mb-3">
							<input id="id_email" name="email" type="email" class="form-control" placeholder="Email address" aria-label="Email address" aria-describedby="button-newsletter" required>
							<div class="input-group-append">
								<button class="btn btn-outline-light" type="submit" name="Submit" value="Submit" id="button-newsletter">Subscribe</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<nav class="navbar navbar-expand-sm navbar-dark bg-dark mt-3">
			<div class="container">
				<?php
				wp_nav_menu(array(
					'depth'			=> 2,
					'menu'			=> 'footer-menu',
					'menu_class'		=> 'navbar-nav',
					'menu_id'			=> 'footer-menu',
					'fallback_cb'		=> 'WP_Bootstrap_Navwalker::fallback',
					'walker'			=> new WP_Bootstrap_Navwalker(),
				));
				?>
			</div>
		</nav>
	</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>
