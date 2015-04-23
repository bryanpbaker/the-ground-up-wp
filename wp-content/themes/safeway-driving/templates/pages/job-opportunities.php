
<div class="container-fluid join-our-team">
	<?php get_template_part('partials/content-block'); ?>

	<div class="join-our-team__safeway-university container">
		<div class="container">
			<h2><span>SafeWay University</span></h2>
			<h2>Lorem Ipsum Headline</h2>
			<p>Lorem ipsum dolor sit amet, ut vel quas illud phaedrum. Ut tota eloquentiam eam, has probo audiam adolescens at, in insolens delicata hendrerit vix. Dicant recusabo constituto duo ut, primis probatus consectetuer eam te, in quo dico nostrud molestiae.</p>
		</div>
		<div class="container">
			<div class="left col-xs-12 col-md-6">
				<a id="videoLink" data-youtube="<?php the_field('video_left_id'); ?>"><img class="col-xs-12" src="<?php the_field('video_left_thumbnail'); ?>" alt=""></a>
				<p class="lead">Online instructor training video.</p class="lead">
			</div>
			<div class="right col-xs-12 col-md-6">
				<a id="videoLink" data-youtube="<?php the_field('video_right_id'); ?>"><img class="col-xs-12" src="<?php the_field('video_right_thumbnail'); ?>" alt=""></a>
				<p class="lead">In-car training video.</p class="lead">
			</div>
			<button class="button">Begin Application CTA</button>
		</div>
	</div>
</div>

<?php get_template_part('partials/video-modal'); ?>