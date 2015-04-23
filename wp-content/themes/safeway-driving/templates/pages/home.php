
	
<div class="home__hero container">
	<img href="<?php bloginfo('url')?>"><img src="<?php bloginfo('template_directory'); ?>/assets/img/home/car.png" alt="#" class="col-xs-12 col-md-9 col-centered"/>
	<h1 class="col-xs-12 home__headline"><span>Serious Driver Training.<small>&#8480</small></h1>
	<h6 class="col-xs-12 home__sub-headline">Convenient. Local. Professional.</h6>
</div>
<?php get_template_part('partials/audiences'); ?>

<div class="home__getting-started container-fluid">
	<div class="container">
		<div class="home__getting-started__headline col-xs-12 col-sm-5">
			<h3 class="col-sm-12">Get started in three easy steps.</h3>
			<p class="col-sm-10">In just a few steps, you'll be on the road to safe driving success.</p>
			<a class="col-sm-8 link-yellow" href="/contact-us#audience">GET STARTED NOW >></a>
		</div>

		<div class="home__getting-started__steps col-sm-7">
			<ul>
				<li class="col-xs-12 col-sm-4">
					<h5>Step 1</h5>
					<h3 class="col-xs-12">Choose<br><span>A Package</span></h3>
				</li>
				<li class="col-xs-12 col-sm-4">
					<h5>Step 2</h5>
					<h3 class="col-xs-12">Select<br><span>Drive Site</span></h3>
				</li>
				<li class="col-xs-12 col-sm-4">
					<h5>Step 3</h5>
					<h3 class="col-xs-12">Enter<br><span>Driver Details</span></h3>
				</li>
			</ul>
		</div>
	</div>
</div>

<div class="home__learn-more container">
	<section class="home__learn-more__about-us col-xs-12 col-sm-8">
		<div class="container-fluid">
			<h3><span>Learn about</span><br>The SafeWay Difference</h3>
			<p class="col-xs-12 col-sm-9 col-md-10">Forget everything you know about “Drivers Ed” because we are revolutionizing the industry. Fresh, modern, convenient and professional training all delivered in your local community <br>
			We have developed our expertise through 42 years of training over 250,000 in-car drivers while adding significant investments in technology, new cars and the top professionals in the business to bring you The Best Driver Training in Texas.
			</p>
			<img src="<?php bloginfo('template_directory'); ?>/assets/img/home/safeseal.png" alt="#" class="certified hidden-xs">
	    	
	    	<div class="container-fluid">
	    		<!-- Video Modal -->
				<a id="videoLink" data-youtube="<?php the_field('about_us_video'); ?>"><img class="home__learn-more__video col-xs-12 col-sm-5" src="<?php the_field('about_us_video_thumbnail'); ?>" alt=""></a>
				<div class="home__learn-more__panel col-xs-12 col-sm-6">
					<ul class="list">
						<li><p>&nbsp  We are driven to Prevent “The Phone Call” Nobody Wants</p></li>
						<li><p>&nbsp  We believe Driver Training is a matter of life and death</p></li>
						<li><p>&nbsp  We take Driver Training seriously, and so should you</p></li>
						<li><p>&nbsp  We hire and train the best instructors in Texas</p></li>
					</ul>
				</div>
				<a class="link-red col-xs-12" href="/thesafewaydifference">Learn more about Safeway Driving >></a>
			</div>

		</div>
	</section>
	<section class="home__learn-more__franchise col-xs-12 col-sm-4">
		<div class="container-fluid">
			<h3><span>Franchise Opportunities</span><br>Save Lives. Make Money.</h3>
			<p>Make a difference in the safety of your community while building a business on the annual flow of people needing to take driver training programs. We train teens, adults and corporate drivers alike. It’s an opportunity to be part of a business that matters.<br>
			SafeWay Driving has modernized its entire operations and packaged them into a solid franchise system providing anyone interested in saving lives and making money the opportunity to succeed.</p>
			<a class="link-red" href="/franchise-opportunities">Learn More Today >></a>
		</div>
	</section>
</div>


<div class="home__locate container-fluid">
	<div class="container">
		<div class="container">
			<h3 class="col-sm-4 col-sm-offset-2"><span>In your neighborhood</span><br>Find the Drive Site Closest to you</h3>
			<div class="home__locate__cta col-sm-6">
				<a href="locations"><button class="button button--alt button--icon"><i class="fa fa-map-marker"> Locate Drive Sites >></i></button></a>
			</div>
		</div>
	</div>
</div>
