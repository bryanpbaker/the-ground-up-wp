<!-- Three columns of copy -->
<section class="anchor-location" id="<?php the_sub_field('content_block_id'); ?>"></section>
<div class="three_column_copy content-block container-fluid">
	<div class="container">
		<h2 class="content_block_heading"><?php the_sub_field('content_block_heading'); ?></h2>
		<div class="left col-xs-12 col-sm-4">
			<h2><span><?php the_sub_field('small_headline'); ?></span></h2>
			<h2><?php the_sub_field('large_headline'); ?></h2>
			<p><?php the_sub_field('body_copy'); ?></p>
		</div>
		<div class="middle col-xs-12 col-sm-4">
			<h2><span><?php the_sub_field('small_headline_two'); ?></span></h2>
			<h2><?php the_sub_field('large_headline_two'); ?></h2>
			<p><?php the_sub_field('body_copy_two'); ?></p>
		</div>
		<div class="right col-xs-12 col-sm-4">
			<h2><span><?php the_sub_field('small_headline_three'); ?></span></h2>
			<h2><?php the_sub_field('large_headline_three'); ?></h2>
			<p><?php the_sub_field('body_copy_three'); ?></p>
		</div>
		<div class="col-xs-12">
			<?php if(get_sub_field('button_text')) : ?>
				<a href="<?php the_sub_field('button_url'); ?>"><button class="button" ><?php the_sub_field('button_text'); ?></button></a>
			<?php endif; ?>
		</div>
	</div>
</div>