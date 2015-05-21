
<!-- Adult Package Partial -->

<?php $args=array(
	'taxonomy' => 'package_categories',
	'term' => 'adult-spec-custom-driving-instruction',
	'post_type' => 'package',
	'posts_per_page' => 10
	);
	$comments = new WP_Query($args);
    if($comments->have_posts()) : while($comments->have_posts()) :
	$comments->the_post(); ?>

	<div class="package col-xs-12 col-sm-5 col-md-4">
		<h5><?php the_title(); ?></h5>
		<h4><?php the_field('package_level'); ?></h4>
		<ul class="list">
			<li>Lorem Ipsum Dolor Vix</li>
			<li>Lorem Ipsum Dolor Vix</li>
			<li>Lorem Ipsum Dolor Vix</li>
			<li>Lorem Ipsum Dolor Vix</li>
			<p><?php the_field('price'); ?></p>
			<a href="<?php the_permalink(); ?>"><button class="button"><?php the_field('button_text'); ?></button></a>
		</ul>
		<a href="#" class="link-yellow">Learn More</a>
	</div>

  <?php endwhile; endif; ?>
  <?php wp_reset_query(); // end Fan Cooments loop. ?>