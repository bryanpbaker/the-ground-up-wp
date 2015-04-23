
<!-- Teen Packages Partial -->

<?php $loop = new WP_Query( array( 'post_type' => 'package', 'posts_per_page' => 10 , 'taxonomy' => 'package_categories' , 'term' => 'teen-packages') ); ?>
<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

	<li class="col-xs-12 col-sm-6 col-md-3">
		<div class="col-xs-12 teen-package-single">
			<img class="safeway-seal" src="<?php bloginfo('template_directory'); ?>/assets/img/safeway-seal.png" alt="">
			<h5><?php the_title(); ?></h5>
			<h5><?php the_field('sub-title'); ?></h5>
			<p><?php the_field('package_description'); ?></p>
			<h5><?php the_field('price'); ?></h5>
			<a href="<?php the_permalink(); ?>"><button class="button"><?php the_field('button_text'); ?></button></a>
			
			<section class="hours-indicator" data-toggle="tooltipTeenPackage" title="<?php the_field('tooltip_text'); ?>">
				<?php if( get_field('course_hours') == 'thirty_seven' ) : ?>
					<img src="<?php bloginfo('template_directory'); ?>/assets/img/teen-packages/hours-indicator-37-0.png" alt="">
				<?php elseif( get_field('course_hours') == 'twenty_seven' ) : ?>
					<img src="<?php bloginfo('template_directory'); ?>/assets/img/teen-packages/hours-indicator-27-10.png" alt="">
				<?php elseif( get_field('course_hours') == 'seventeen' ) : ?>
					<img src="<?php bloginfo('template_directory'); ?>/assets/img/teen-packages/hours-indicator-17-20.png" alt="">
				<?php elseif( get_field('course_hours') == 'ten' ) : ?>
					<img src="<?php bloginfo('template_directory'); ?>/assets/img/teen-packages/hours-indicator-10-27.png" alt="">			
				
				<?php endif; ?>

				<p>Total SeatTime Hours</p>
				<p>Credit Hours Remaining</p>
			</section>

			<ul class="list">
				<?php while(have_rows('features')) : the_row(); ?>
					<li class="list-item"><?php the_sub_field('feature_list_item'); ?></li>	
				<?php endwhile; ?>
			</ul>
			<a href="<?php the_permalink(); ?>" class="link-yellow">Learn More</a>
		</div>
	</li>

  <?php endwhile; wp_reset_query(); ?>