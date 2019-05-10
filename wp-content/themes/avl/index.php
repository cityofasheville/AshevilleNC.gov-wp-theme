<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Asheville
 */

get_header();
?>
	<div id="primary" class="content-area">
		<section class="bg-white py-5">
			<div class="container">
				<h2 class="mb-4"><span class="icon icon-settings-icons icon-3x icon-avl-blue"></span> Popular Services &amp; Information</h2>
				<?php
					wp_nav_menu( array(
						'menu'		=> 'popular',
						'depth'		=> 2,
						'items_wrap'	=> '<div id="%1$s" class="%2$s">%3$s</div>',
						'menu_class'	=> 'row',
						'walker'		=> new WP_Bootstrap_Cardwalker(),
					) );
				?>
			</div>
		</section>

		<section class="bg-light py-5">
			<div class="container">
				<div class="row">
					<div class="col-sm-12 col-lg-5">
						<h2><span class="icon icon-warning icon-3x icon-avl-blue"></span> Receive Alerts</h2>
						<p>Sign up to receive up-to-date information on emergency and non-emergency events via email, phone calls, voice or text messages. Decide what types of information you would like to receive, and unsubscribe at any time.</p>
						<a href="https://member.everbridge.net/index/453003085611892#/login" target="_blank" role="button" class="btn btn-outline-info float-right mb-4">Learn More at AVL Alert <span class="icon icon-chevron-right"></span></a>
					</div>
					<div class="col-sm-12 col-lg-7">
						<h2><span class="icon icon-smartphone-warning icon-3x icon-avl-blue"></span> Report Issues</h2>
						<p>Use The Asheville App to let city workers know about common issues such as:</p>
						<ul>
              <li>Potholes, sidewalk hazards or accessibility issues, street lights, street sign damage, street sign requests</li>
							<li>Abandoned vehicles, injured or deceased animals, hazardous waste</li>
							<li>Overgrown lots, brush collection requests, graffiti</li>
							<li>Fire hydrant leaks, water leaks, stormwater or draining issues</li>
							<li>Planning and zoning, code, or short term rental violations</li>
							<li>Trash collection, litter, trees and right of way</li>
						</ul>
						<a href="https://iframe.publicstuff.com/#?client_id=819" target="_blank" role="button" class="btn btn-outline-info float-right mb-4">Use The Asheville App <span class="icon icon-chevron-right"></span></a>
					</div>
				</div>
			</div>
		</section>

		<section class="bg-white py-5">
			<div class="container">
				<h2 class="page-title mb-4"><span class="icon icon-news icon-3x icon-avl-blue"></span> Latest News</h2>
				<?php
				if ( have_posts() ) :
				?>
				<div class="row">
				<?php
					while ( have_posts() ) {
						the_post();
						echo '<div class="col-sm-12 col-md-6 col-lg-4 pb-4">';
						get_template_part( 'template-parts/content', get_post_type() );
						echo '</div>';
					}
				?>
				</div>
				<div class="row">
					<div class="col-auto ml-auto">
						<a href="<?= get_post_type_archive_link( 'post' ); ?>" role="button" class="btn btn-outline-primary">Read More Stories <span class="icon icon-chevron-right"></span></a>
					</div>
				</div>
				<?php
				else :
					get_template_part( 'template-parts/content', 'none' );
				endif;
				?>
			</div>
		</section>

    <section class="bg-light py-5" id="projects-initiatives">
      <div class="container">
        <a href="/department/communication-public-engagement/projects-and-initiatives/">
          <span class="icon icon-hammer icon-3x text-avl-green-75 mr-2"></span><h2>City projects and initiatives &rarr;</h2></a>
        <p>Learn more about changes to city-owned infrastructure like parks as well as programs and studies</p>
      </div>
    </section>

		<section class="bg-white py-5">
			<div class="container">
				<h2 class="mb-4"><span class="icon icon-calendar icon-3x icon-avl-green-75"></span> Upcoming Events</h2>
				<?php
					if ( is_active_sidebar( 'block-events' ) ) {
						dynamic_sidebar( 'block-events' );
					}
				?>
			</div>
		</section>

		<section class="bg-light py-5">
			<div class="container">
				<h2 class="mb-4"><span class="icon icon-bubbles2 icon-3x icon-avl-blue"></span> Engage</h2>
				<div class="row">
					<div class="col-sm-12 col-md-4">
						<a href="https://www.opentownhall.com/portals/239/forum_home?noembed=1" target="_blank" rel="noopener noreferrer" class="open-city-hall d-block bg-avl-green-75 rounded shadow">
							<div class="row h-100">
								<span class="text-white text-center h3 my-auto mx-auto w-100">Open City Hall</span>
								<?= wp_get_attachment_image( 109, 'full', false, array('class' => 'mx-auto my-auto w-28') ); ?>
								<span class="text-white text-center h4 mx-auto my-auto w-100">Join the discussion</span>
							</div>
						</a>
					</div>
					<div class="col-sm-12 col-md-4">
						<div class="row">
							<div class="col-6"><a href="https://www.facebook.com/CityofAsheville/" target="_blank" class="social-network shadow rounded"><span class="icomoon icomoon-facebook icon-5x"></span></a></div>
							<div class="col-6"><a href="https://twitter.com/CityofAsheville" target="_blank" class="social-network shadow rounded"><span class="icomoon icomoon-twitter icon-5x"></span></a></div>
							<div class="col-6"><a href="https://www.instagram.com/explore/locations/1017488608/city-of-asheville/" target="_blank" class="social-network shadow rounded"><span class="icomoon icomoon-instagram icon-5x"></span></a></div>
							<div class="col-6"><a href="https://www.youtube.com/user/CityofAsheville" target="_blank" class="social-network shadow rounded"><span class="icomoon icomoon-youtube icon-5x"></span></a></div>
						</div>
					</div>
					<div class="col-sm-12 col-md-4" id="twitter-container">
						<a class="twitter-timeline" data-tweet-limit="4" href="https://twitter.com/CityofAsheville">Latest from CityofAsheville</a>
					</div>
				</div>
			</div>
		</section>

		<section class="bg-white py-5">
			<div class="container">
				<h2 class="mb-4"><span class="icon icon-self-timer2 icon-3x icon-avl-green-75"></span> Redesign Process</h2>
				<div class="row">
					<div class="col-sm-12 col-lg-6">
						<h3>About the redesign</h3>
						<p>We're in the process of creating a new website for Asheville from the ground-up with simple, mobile-friendly designs, more intuitive organization, and clear content.</p>
						<p>Throughout the redesign process, we've been collaborating with people like you to inform the direction and usability of the site. Please continue to send us your thoughts.</p>
						<div class="alert alert-info"><span class="icon icon-lamp-bright icon-2x float-left mr-2"></span> Use the site's feedback button to alert us to content errors and design feedback.</div>
					</div>
					<div class="col-sm-12 col-lg-6">
						<h3>Where are we in the process?</h3>
						<p>For the past few months, we've been working closely with content creators, City colleagues, and the public to rewrite service information and to design features that better meet your needs.</p>
						<div class="progress" style="height: 40px;">
							<div class="progress-bar bg-avl-blue-35" role="progressbar" style="width: 15%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">Alpha<span class="icon icon-check"></span></div>
							<div class="progress-bar bg-avl-blue-75" role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100">Beta<span class="icon icon-check"></span></div>
							<div class="progress-bar bg-secondary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">Launch<span class="icon icon-game"></span></div>
							<div class="progress-bar bg-dark" role="progressbar" style="width: 25%; white-space: normal;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">Content Migration</div>
						</div>
					</div>
				</div>
			</div>
		</section>

	</div>
<?php
//get_sidebar();
get_footer();
?>
