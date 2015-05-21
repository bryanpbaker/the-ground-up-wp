<!-- Two columns, each with an image copy and cta -->
<section class="anchor-location" id="<?php the_sub_field('content_block_id'); ?>"></section>
<div class="two_column_img_copy_cta content-block container-fluid">
	<div class="container">
		<div class="left col-xs-12 col-sm-6">
			<img class="col-xs-12 col-sm-12" src="<?php the_sub_field('image'); ?>" alt=""/>
			<h2><span><?php the_sub_field('small_headline'); ?></span></h2>
			<h2><?php the_sub_field('large_headline'); ?></h2>
			<p><?php the_sub_field('body_copy'); ?></p>
			<?php if(get_sub_field('button_text')) : ?>
				<a href="<?php the_sub_field('button_url'); ?>"><button class="button"><?php the_sub_field('button_text'); ?></button></a>
			<?php endif; ?>
		</div>
		<div class="right col-xs-12 col-sm-6">
			<img class="col-xs-12 col-sm-12" src="<?php the_sub_field('image_two'); ?>" alt=""/>
			<h2><span><?php the_sub_field('small_headline_two'); ?></span></h2>
			<h2><?php the_sub_field('large_headline_two'); ?></h2>
			<p><?php the_sub_field('body_copy_two'); ?></p>
			<?php if(get_sub_field('button_two_text')) : ?>
				<a  href="<?php the_sub_field('button_two_url'); ?>"><button class="button"><?php the_sub_field('button_two_text'); ?></button></a>
			<?php endif; ?>
		</div>
	</div>
</div>