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
	</div>
	<footer id="colophon" class="site-footer bg-avl-blue-75 pt-5">
		<div class="container">
			<div class="row">
				<div class="col-3 col-sm-2 col-md-2 col-lg-1 pb-4">
					<a href="<?= home_url( '/' ); ?>">
						<img src="http://avlbeta.site/wp-content/uploads/2018/09/city-of-asheville-dome-white.svg" class="img-fluid" alt="The City of Asheville Dome">
					</a>
				</div>
				<div class="col-12 col-sm-5 col-md-6 col-lg-4 col-xl-3 pb-4">
					<div class="text-white site-info">
						<address>
						<strong class="h5 d-block">The City of Asheville</strong>
						70 Court Plaza<br>
						P.O. Box 7148<br>
						Asheville, NC 28802
						</address>
						<i class="icon icon-telephone"></i> <a href="tel:8282511122" class="text-white">828-251-1122</a><br>
						<i class="icon icon-envelope"></i> <a href="mailto:webmaster@ashevillenc.gov" class="text-white">Webmaster</a>
					</div>
				</div>
				<div class="col-sm-5 col-md-4 col-lg-3 col-xl-4 pb-4">
					<h5 class="text-white">Follow Us</h5>
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
					<h5 class="text-white">Stay in the loop</h5>
					<p class="text-white">Sign up for our weekly newsletter!</p>
					<div class="input-group mb-3">
						<input type="email" class="form-control" placeholder="Email address" aria-label="Email address" aria-describedby="button-newsletter">
						<div class="input-group-append">
							<button class="btn btn-secondary" type="button" id="button-newsletter">Subscribe</button>
						</div>
					</div>
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