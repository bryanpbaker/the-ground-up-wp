<!-- Safeway Code on the left, Copy on the right -->
<section class="anchor-location" id="<?php the_sub_field('content_block_id'); ?>"></section>
<div class="code_left_copy_right container-fluid content-block">
	<div class="container">
		<div class="col-xs-12 col-sm-5 code_left_copy_right__left">
			<div class="col-xs-12">
				<span small="safeway-code">
					<h6>#<?php the_sub_field('safeway_code'); ?></h6>
				</span>
				<img class="col-xs-8 col-xs-offset-2" src="<?php bloginfo('template_directory'); ?>/assets/img/safeway-code.png" alt=""/>
			</div>
			<a href="<?php the_sub_field('button_url'); ?>" target="_blank"><button class="button"><?php the_sub_field('button_text'); ?></button></a>
		</div>
		<div class="col-xs-12 col-sm-7 code_left_copy_right__right">
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
		</div>
	</div>
</div>