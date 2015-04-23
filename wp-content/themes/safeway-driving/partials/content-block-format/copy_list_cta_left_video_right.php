<!-- Copy, list and cta on left, image on the right -->
<section class="anchor-location" id="<?php the_sub_field('content_block_id'); ?>"></section>
<div class="copy_list_cta_left_video_right container-fluid content-block">
	<div class="container">
		<div class="col-xs-12 col-sm-6 col-sm-push-6">
			<a id="videoLink" data-youtube="<?php the_sub_field('youtube_id'); ?>"><img class="col-xs-12 col-sm-10 col-sm-offset-1" src="<?php the_sub_field('video_thumbnail'); ?>" alt=""></a>
		</div>
		<div class="col-xs-12 col-sm-6 col-sm-pull-6">
			<h2><span><?php the_sub_field('small_headline'); ?></span></h2>
			<h2><?php the_sub_field('large_headline'); ?></h2>
			<p><?php the_sub_field('body_copy'); ?></p>
			<?php if (have_rows('list')) : ?>
				<ul class="list">
					<?php while(have_rows('list')) : the_row(); ?>
					<li class="list-item"><?php the_sub_field('list_item'); ?></li>	
					<?php endwhile; ?>
				</ul>
			<?php endif; ?>
			<?php if(get_sub_field('button_text')) : ?>
				<a href="<?php the_sub_field('button_url'); ?>"><button class="button"><?php the_sub_field('button_text'); ?></button></a>
			<?php endif; ?>
		</div>
		
	</div>
</div>
