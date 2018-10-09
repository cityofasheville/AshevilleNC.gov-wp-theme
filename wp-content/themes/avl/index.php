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
				<h2 class="mb-4"><i class="icon icon-settings-icons icon-3x icon-avl-blue"></i> Popular Services &amp; Information</h2>
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
				<h2 class="mb-4"><i class="icon icon-traffic-lights icon-3x icon-avl-green"></i> Service Updates</h2>
				<div class="list-group mb-4">
					<a href="#" class="list-group-item list-group-item-action list-group-item-warning flex-column align-items-start">
						<div class="d-flex w-100 justify-content-between">
							<h3 class="mb-1"><i class="icon icon-bus2 icon-2x"></i> Transit</h3>
							<small>Last updated 3 days ago</small>
						</div>
						<p class="mb-1">The buses are running behind schedule due to inclimant weather.</p>
					</a>
					<a href="#" class="list-group-item list-group-item-action list-group-item-success flex-column align-items-start">
						<div class="d-flex w-100 justify-content-between">
							<h3 class="mb-1"><i class="icon icon-city icon-2x"></i> City</h3>
							<small>Last updated 4 days ago</small>
						</div>
						<p class="mb-1">City buildings are open for regular business hours..</p>
					</a>
					<a href="#" class="list-group-item list-group-item-action list-group-item-success flex-column align-items-start">
						<div class="d-flex w-100 justify-content-between">
							<h3 class="mb-1"><i class="icon icon-trash icon-2x"></i> Trash</h3>
							<small>Last updated 5 days ago</small>
						</div>
						<p class="mb-1">Trash and recycling is being picked up on a normal schedule.</p>
					</a>
				</div>
				<div class="row">
					<div class="col-auto ml-auto">
						<a href="#" role="button" class="btn btn-outline-dark">View Service Updates <i class="icon icon-chevron-right"></i></a>
					</div>
				</div>
			</div>
		</section>
		
		<section class="bg-white py-5">
			<div class="container">
				<div class="row">
					<div class="col-sm-12 col-lg-5">
						<h2><i class="icon icon-warning icon-3x icon-avl-blue"></i> Receive Alerts</h2>
						<p>If you live, work, travel through or have family/friends in the City of Asheville, sign up to receive up-to-date information on emergency and non-emergency events. Receive alerts via email, phone calls, voice or text messages. Decide what types of information you would like to receive, and unsubscribe at any time!</p>
						<a href="https://member.everbridge.net/index/453003085611892#/login" target="_blank" role="button" class="btn btn-outline-info float-right mb-4">Learn More at AVL Alert <i class="icon icon-chevron-right"></i></a>
					</div>
					<div class="col-sm-12 col-lg-7">
						<h2><i class="icon icon-smartphone-warning icon-3x icon-avl-blue"></i> Report Issues</h2>
						<p>Use The Asheville App to let us know about common issues such as:</p>
						<ul>
							<li>Abandoned Vehicles, injured or deceased animals, hazardous waste</li>
							<li>Overgrown lots, brush collection requests, graffiti</li>
							<li>Fire hydrant leaks, water leaks, stormwater/draining issues</li>
							<li>Potholes, sidewalk hazards or accessibility issues, street lights, street sign damage, street sign requests</li>
							<li>Planning &amp; zoning, code, or short term rental violations</li>
							<li>Trash collection, litter, trees and right of way</li>
						</ul>
						<a href="https://iframe.publicstuff.com/#?client_id=819" target="_blank" role="button" class="btn btn-outline-info float-right mb-4">Use The Asheville App <i class="icon icon-chevron-right"></i></a>
					</div>
				</div>
			</div>
		</section>
		
		<main id="main" class="site-main bg-light py-5">
			<div class="container">
				<h2 class="page-title mb-4"><i class="icon icon-news icon-3x icon-avl-blue"></i> Latest News</h2>
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
						<a href="#" role="button" class="btn btn-outline-primary">Read More Stories <i class="icon icon-chevron-right"></i></a>
					</div>
				</div>
				<?php
				else :
					get_template_part( 'template-parts/content', 'none' );
				endif;
				?>
			</div>
		</main>
		
		<section class="bg-white py-5">
			<div class="container">
				<h2 class="mb-4"><i class="icon icon-self-timer2 icon-3x icon-avl-green-75"></i> Redesign Process</h2>
				<div class="row">
					<div class="col-sm-12 col-lg-6">
						<h3>About the redesign</h3>
						<p>We're in the process of creating a new website for Asheville from the ground-up with simple, mobile-friendly designs, more intuitive organization, and clear content.</p>
						<p>Throughout the redesign process, we've been collaborating with people like you to inform the direction and usability of the site. Please continue to send us your thoughts.</p>
						<div class="alert alert-info" role="alert"><i class="icon icon-lamp-bright icon-2x float-left mr-2"></i> Use the site's feedback links to alert us to content errors and design feedback.</div>
					</div>
					<div class="col-sm-12 col-lg-6">
						<h3>Where are we in the process?</h3>
						<p>For the past few months, we've been working closely with content creators, City colleagues, and the public to rewrite service information and to design features that better meet your needs.</p>
						<div class="progress" style="height: 40px;">
							<div class="progress-bar bg-avl-blue-35" role="progressbar" style="width: 15%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">Alpha<i class="icon icon-check"></i></div>
							<div class="progress-bar bg-avl-blue-75" role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100">Beta<i class="icon icon-game"></i></div>
							<div class="progress-bar bg-secondary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">Launch</div>
							<div class="progress-bar bg-dark" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">Migration</div>
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