<div class="container-fluid video-archive">
	<ul class="container">
		<?php
		//Videos post_type loop
		 $my_query = new WP_Query('post_type=video&posts_per_page=-10');
		      while ($my_query->have_posts()) : $my_query->the_post(); ?>
				<li class="col-xs-12 col-sm-6 col-md-4 video-archive__video">
					<a id="videoLink" data-youtube="<?php the_field('youtube_id'); ?>"><img src="<?php the_field('video_thumbnail'); ?>" alt="" class="col-xs-12" width="275"></a>
					<p class="lead"><?php the_title(); ?></p class="lead">
					<p class="col-xs-12"><?php echo video_description_excerpt(); ?></p>
				</li>
		<?php endwhile;  wp_reset_query(); ?>
	</div>
</div>
<?php get_template_part('partials/video-modal'); ?>