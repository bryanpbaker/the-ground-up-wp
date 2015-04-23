<!-- Adding Advisors to the "Our Advisory Board" page -->

<?php if( have_rows('advisors') ): ?>
	<div class="our-advisory-board__advisors">
	<?php while ( have_rows('advisors')): the_row();
		$image = get_sub_field('advisor_photo');
		$name = get_sub_field('name');
		$shortIntro = get_sub_field('short_intro');
		$bio = get_sub_field('bio');
		?>
		<div class="our-advisory-board__advisors__advisor-single col-xs-12 col-sm-6 col-md-4">
			<img src="<?php echo $image; ?>" alt="#">
			<h6><?php echo $name; ?></h6>
			<h6><span><?php echo $shortIntro; ?></span></h6><br>
			<p><?php echo $bio; ?></p>
		</div>
	<?php endwhile; ?>
	</div>
<?php endif; ?>

