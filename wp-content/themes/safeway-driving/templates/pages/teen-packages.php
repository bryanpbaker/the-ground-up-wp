<div class="container-fluid teen-packages">
	<?php get_template_part('partials/content-block-format/three_step_process'); ?>

	<div class="container-fluid teen-packages__callout-section" id="#calloutSection">
		<h3>Seattime Hours</h3>
		<div class="col-sm-10 col-sm-offset-1 teen-packages__callout-section__hours-scale col-xs-12">
			<a class="hours-scale-section" href="#" data-show="#hours37" data-arrow="point-to-37"><div class="hours h37 col-xs-2 arrow-left"><img src="<?php bloginfo('template_directory'); ?>/assets/img/teen-packages/37-icon.png" alt=""></div></a>
			<a class="hours-scale-section" href="#" data-show="#hours27" data-arrow="point-to-27"><div class="hours h27 col-xs-2 arrow-left"><img src="<?php bloginfo('template_directory'); ?>/assets/img/teen-packages/27-icon.png" alt=""></div></a>
			<a class="hours-scale-section" href="#" data-show="#hours17" data-arrow="point-to-17"><div class="hours h17 col-xs-2 arrow-left"><img src="<?php bloginfo('template_directory'); ?>/assets/img/teen-packages/17-icon.png" alt=""></div></a>
			<a class="hours-scale-section" href="#" data-show="#hours10" data-arrow="point-to-10"><div class="hours h10 col-xs-2 arrow-left"><img src="<?php bloginfo('template_directory'); ?>/assets/img/teen-packages/10-icon.png" alt=""></div></a>
			<a class="hours-scale-section" href="#" data-show="#hours7" data-arrow="point-to-7"><div class="hours h7 col-xs-2"><img src="<?php bloginfo('template_directory'); ?>/assets/img/teen-packages/7-icon.png" alt=""></div></a>
			<hr class="hours-scale-line">
			<h5 class="skilled-driver">Skilled Driver</h5>
			<h5 class="the-minimum">The Minimum</h5>
		</div>

		<div class="teen-packages__callout-section__dynamic-callout col-xs-12">
			<div id="hours37" class="teen-packages__callout-section__dynamic-callout__content active">
				<h2>Best Package!</h2>
				<h6>SafeWay Advanced Pro</h6>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing. Lorem ipsum.</p>
			</div>
			<div id="hours27" class="teen-packages__callout-section__dynamic-callout__content">
				<h2>Great Value!</h2>
				<h6>SafeWay Advanced Plus</h6>
				<p>Lorem ipsum dolor sit amet, consectetur. Lorem ipsum.</p>
			</div>
			<div id="hours17" class="teen-packages__callout-section__dynamic-callout__content">
				<h2>SafeWay Minimum</h2>
				<h6>SafeWay Advanced</h6>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing. Lorem ipsum.</p>
			</div>
			<div id="hours10" class="teen-packages__callout-section__dynamic-callout__content">
				<h2>National Minimum</h2>
				<h6>SafeWay Basic</h6>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing. Lorem ipsum.</p>
			</div>
			<div id="hours7" class="teen-packages__callout-section__dynamic-callout__content">
				<h2>State Minimum Required</h2>
				<h6>State Minimum</h6>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing. Lorem ipsum.</p>
			</div>
		<div class="arrow-up point-to-37"></div>
	</div>

	<ul class="teen-packages__packages container">
		<?php get_template_part('partials/package-categories/teen-package-single'); ?>
	</ul>

	<div class="container teen-packages__state-minimum">
		<div class="left col-md-9">
			<h5>State Minimum</h5>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis minima, repellat! Suscipit doloribus, voluptate quisquam cum necessitatibus. Neque veniam similique facere, a consequuntur doloribus tempore.</p>
		</div>
		<div class="right col-md-3">
			<button class="button">Learn More</button>
		</div>
	</div>
	
	<div class="container teen-packages__all-packages-include">
		<h6>All Packages Include</h6>
		<div class="col-xs-12 col-sm-6">
			<div class="col-sm-10 col-sm-offset-1">
				<p class="lead"><i class="fa fa-bell-o"></i>&nbsp&nbsp State Minimum License Requirement</p>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore animi iusto quam laudantium sapiente, alias!</p>
			</div>
		</div>
		<div class="col-xs-12 col-sm-6">
			<div class="col-sm-10 col-sm-offset-1">
				<p class="lead"><i class="fa fa-bookmark-o"></i>&nbsp&nbsp 32 Hour Online Course</p>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore animi iusto quam laudantium sapiente, alias!</p>
			</div>
		</div>
		<div class="col-xs-12 col-sm-6">
			<div class="col-sm-10 col-sm-offset-1">
				<p class="lead"><i class="fa fa-bell-o"></i>&nbsp&nbsp Online Permit Test</p>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore animi iusto quam laudantium sapiente, alias!</p>
			</div>
		</div>
		<div class="col-xs-12 col-sm-6">
			<div class="col-sm-10 col-sm-offset-1">
				<p class="lead"><i class="fa fa-bookmark-o"></i>&nbsp&nbsp 7 Hours Driving/7 Hours Observation</p>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore animi iusto quam laudantium sapiente, alias!</p>
			</div>
		</div>
		<div class="col-xs-12 col-sm-6">
			<div class="col-sm-10 col-sm-offset-1">
				<p class="lead"><i class="fa fa-bell-o"></i>&nbsp&nbsp 27/7/365 Online Scheduling</p>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore animi iusto quam laudantium sapiente, alias!</p>
			</div>
		</div>
		<div class="col-xs-12 col-sm-6">
			<div class="col-sm-10 col-sm-offset-1">
				<p class="lead"><i class="fa fa-bookmark-o"></i>&nbsp&nbsp State Alcohol Course Credit</p>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore animi iusto quam laudantium sapiente, alias!</p>
			</div>
		</div>
	</div>

	<?php get_template_part('partials/content-block'); ?>
</div>