<!-- Template for adding content blocks to pages via the repeater field -->

<?php if( have_rows('content_block') ): ?>
	<div>
		<?php while( have_rows('content_block') ): the_row(); ?>
			
			<!-- Two columns. Image, copy and cta on each side. -->
			<?php if (get_sub_field('content_block_format') == 'two_column_img_copy_cta') : ?>
				<?php get_template_part('partials/content-block-format/two_column_img_copy_cta'); ?>
			
			<!--One single column of copy. -->
			<?php elseif (get_sub_field('content_block_format') == 'single_column_copy') : ?>
				<?php get_template_part('partials/content-block-format/single_column_copy'); ?>
			
			<!-- Copy, list and CTA on the left, image on the right. -->
			<?php elseif (get_sub_field('content_block_format') == 'copy_list_cta_left_img_right') : ?>
				<?php get_template_part('partials/content-block-format/copy_list_cta_left_img_right'); ?>			
			
			<!-- Image on the left, Copy, list and CTA on the right. -->
			<?php elseif (get_sub_field('content_block_format') == 'img_left_copy_list_cta_right') : ?>
				<?php get_template_part('partials/content-block-format/img_left_copy_list_cta_right'); ?>
			
			<!-- Copy on left, Form on the right -->	
			<?php elseif (get_sub_field('content_block_format') == 'copy_left_form_right') : ?>
				<?php get_template_part('partials/content-block-format/copy_left_form_right'); ?>
			
			<!-- Code on Left, Copy on Right -->	
			<?php elseif (get_sub_field('content_block_format') == 'code_left_copy_right') : ?>
				<?php get_template_part('partials/content-block-format/code_left_copy_right'); ?>

			<!-- Code on Left, Copy on Right -->	
			<?php elseif (get_sub_field('content_block_format') == 'copy_list_cta_left_video_right') : ?>
				<?php get_template_part('partials/content-block-format/copy_list_cta_left_video_right'); ?>	

			<!-- 3 Columns- copy, cta -->
			<?php elseif (get_sub_field('content_block_format') == 'three_column_copy') : ?>
				<?php get_template_part('partials/content-block-format/three_column_copy'); ?>

			<!-- 3 Step Headline -->
			<?php elseif (get_sub_field('content_block_format') == 'three_step_process') : ?>
				<?php get_template_part('partials/content-block-format/three_step_process'); ?>	

			<?php endif; ?>
		<?php endwhile; ?>
	</div>
<?php endif; ?>


			