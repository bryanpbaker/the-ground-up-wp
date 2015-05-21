
<div class="container-fluid testimonials">
<?php get_template_part('partials/content-block'); ?>
	<div class="container-fluid">

		<!-- Parent Testimonial Section -->
		<div class="container-fluid testimonials__parent">
			<div class="container testimonials__intro"> 
				<h6>Parent Testimonials lorem ipsum</h6>
				<p class="col-xs-12 col-sm-9">Lorem ipsum dolor sit amet, his te quodsi singulis volutpat. Ludus tritani eos ne, ea aeque nihil impetus qui. An solum graece dolores his. Ad quas nominavi expetendis mel, eu mea dicat molestiae.</p>
			</div>
			<div class="container testimonials__grid">
				<?php if( have_rows('parent_testimonial') ): ?>
					<?php while( have_rows('parent_testimonial') ): the_row(); ?>

						<div class="testimonials__grid__single col-sm-6">
							<blockquote><?php the_sub_field('quote'); ?></blockquote>
							<h5><?php the_sub_field('author'); ?></h5>
						</div>

					<?php endwhile; ?>
				<?php endif; ?>
			</div>
			<br>
			<div class="container">
				<button class="button button--alt testimonials__cta">Teen Packages</button>
			</div>
		</div>

		<!-- Driver Testimonial Section -->
		<div class="container-fluid testimonials__driver">
			<div class="container testimonials__intro">
				<h6>Driver Testimonials lorem ipsum</h6>
				<p class="col-xs-12 col-sm-9">Lorem ipsum dolor sit amet, his te quodsi singulis volutpat. Ludus tritani eos ne, ea aeque nihil impetus qui. An solum graece dolores his. Ad quas nominavi expetendis mel, eu mea dicat molestiae.</p>
			</div>
			<div class=" container testimonials__grid">
				<?php if( have_rows('driver_testimonial') ): ?>
					<?php while( have_rows('driver_testimonial') ): the_row(); ?>

						<div class="testimonials__grid__single col-sm-6">
							<blockquote><?php the_sub_field('quote'); ?></blockquote>
							<h5><?php the_sub_field('author'); ?></h5>
						</div>

					<?php endwhile; ?>
				<?php endif; ?>
			</div>
			<div class="container">
				<button class="button testimonials__cta">Adult Packages</button>
			</div>
		</div>

		<!-- Corporate Testimonial Section -->
		<div class="container-fluid testimonials__corporate">
			<div class="container testimonials__intro">
				<h6>Corporate Testimonials lorem ipsum</h6>
				<p class="col-xs-12 col-sm-9">Lorem ipsum dolor sit amet, his te quodsi singulis volutpat. Ludus tritani eos ne, ea aeque nihil impetus qui. An solum graece dolores his. Ad quas nominavi expetendis mel, eu mea dicat molestiae.</p>
			</div>
			<div class=" container testimonials__grid">
				<?php if( have_rows('franchisee_testimonial') ): ?>
					<?php while( have_rows('corporate_testimonial') ): the_row(); ?>

						<div class="testimonials__grid__single col-sm-6">
							<blockquote><?php the_sub_field('quote'); ?></blockquote>
							<h5><?php the_sub_field('author'); ?></h5>
						</div>

					<?php endwhile; ?>
				<?php endif; ?>
			</div>
			<div class="container">
				<button class="button button--alt testimonials__cta">Franchisee Packages</button>
			</div>
		</div>

		<!-- Franchisee Testimonial Section -->
		<div class="container-fluid testimonials__franchisee">
			<div class="container testimonials__intro">
				<h6>Franchisee Testimonials lorem ipsum</h6>
				<p class="col-xs-12 col-sm-9">Lorem ipsum dolor sit amet, his te quodsi singulis volutpat. Ludus tritani eos ne, ea aeque nihil impetus qui. An solum graece dolores his. Ad quas nominavi expetendis mel, eu mea dicat molestiae.</p>
			</div>
			<div class=" container testimonials__grid">
				<?php if( have_rows('franchisee_testimonial') ): ?>
					<?php while( have_rows('franchisee_testimonial') ): the_row(); ?>

						<div class="testimonials__grid__single col-sm-6">
							<blockquote><?php the_sub_field('quote'); ?></blockquote>
							<h5><?php the_sub_field('author'); ?></h5>
						</div>

					<?php endwhile; ?>
				<?php endif; ?>
			</div>
			<div class="container">
				<button class="button button--alt testimonials__cta">Franchisee Packages</button>
			</div>
		</div>
	</div>
</div>