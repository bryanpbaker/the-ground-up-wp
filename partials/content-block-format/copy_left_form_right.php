<!-- Copy on the left, Form on the right -->
<section class="anchor-location" id="<?php the_sub_field('content_block_id'); ?>"></section>
<div class="faqs__question-form container-fluid form-container">
	<div class="copy_left_form_right container content-block">
		<div class="copy_left_form_right__left col-sm-5">
			<h3><span><?php the_sub_field('small_headline'); ?></span></h3>
			<h3><?php the_sub_field('large_headline'); ?></h3>
			<p><?php the_sub_field('body_copy'); ?></p>
		</div>
		<div class="copy_left_form_right__right form__right col-sm-7">
			<?php the_sub_field('form_short_code'); ?> 	
		</div>
	</div>
</div>