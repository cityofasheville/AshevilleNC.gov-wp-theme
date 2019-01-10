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
	<footer id="colophon" class="site-footer bg-avl-blue-75">
		<div class="collapse" id="toggle-feedback">
			<div class="text-white bg-secondary py-3">
				<div class="container">
					<?= do_shortcode('[ninja_form id=1]'); ?>
				</div>
			</div>
		</div>
		<div class="bg-avl-blue mb-5">
			<div class="container feedback-container">
				<button id="feedback-button" class="navbar-toggler text-white" type="button" data-toggle="collapse" data-target="#toggle-feedback" aria-controls="toggle-feedback" aria-expanded="false" aria-label="Toggle Feedback">
					<i class="icon icon-lamp-bright"></i> Feedback
				</button>
				<span class="navbar-text text-white ml-2 mr-auto">
					We're still working on this page's design and content. How can we make it better?
				</span>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-3 col-sm-2 col-md-2 col-lg-1 pb-4">
					<a href="<?= home_url( '/' ); ?>">
						<?= wp_get_attachment_image( 109, 'full', false, array('class' => 'img-fluid') ); ?>
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