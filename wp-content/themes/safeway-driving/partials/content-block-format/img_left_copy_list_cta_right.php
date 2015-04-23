<!-- Image on the left, copy list and cta on the right -->
<section class="anchor-location" id="<?php the_sub_field('content_block_id'); ?>"></section>
<div class="img_left_copy_list_cta_right container-fluid content-block">
	<div class="container">
		<div class="col-xs-12 col-sm-6">
			<img class="col-xs-12" src="<?php the_sub_field('image'); ?>" alt=""/>
		</div>
		<div class="col-xs-12 col-sm-6">
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
			<?php if (get_sub_field('button_text')) : ?>
				<a href="<?php the_sub_field('button_url'); ?>"><button class="button"><?php the_sub_field('button_text'); ?></button></a>
			<?php endif; ?>
		</div>
	</div>
</div>
