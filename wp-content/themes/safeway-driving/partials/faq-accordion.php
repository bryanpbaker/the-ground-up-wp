

<div id="accordion" class="accordion">

  <!-- Teen FAQs -->
  <h3 class="accordion__header top">Teen Driving <span>| &nbsp<i class="fa fa-angle-right rotate"></i></span></h3>
  <div class="accordion__body">

    
    <div id="tabs">
	  <!-- Side sub-nav for teen driving -->
	  <div class="hidden-xs col-sm-3 accordion__body__side-tabs">
		  <ul>
		    <li><a href="#online"><h6>Online</h6></a></li>
		    <li><a href="#in-car"><h6>In-Car</h6></a></li>
		    <li><a href="#insurance"><h6>Insurance</h6></a></li>
		    <li><a href="#state-laws"><h6>State Laws</h6></a></li>
		    <li><a href="#dps"><h6>DPS</h6></a></li>
		  </ul>
	  </div>
	  <!-- Content -->
	  <div class="accordion__body__tab-panel col-sm-9">
		  
		  <!-- Pulls in only FAQs under "Online" category -->
		  <div id="online" class="accordion__body__tab-panel__content col-xs-12">
		  	<h3>Online</h3>	
		  	<?php if (have_rows('teen_faq')) : ?>
		  		<?php while (have_rows('teen_faq')) : the_row(); ?>
				    <?php if (get_sub_field('question_category') == 'online' ) : ?>
					    <div class="faq">
					    	<p class="faq-question"><?php the_sub_field('question'); ?></p>
					    	<p class="faq-answer"><?php the_sub_field('answer'); ?></p>
					    </div>
				    <?php endif; ?>
				<?php endwhile; ?>
			<?php endif; ?>
		  </div>
		  <!-- Pulls in only FAQs under "In-Car" category -->
		  <div id="in-car" class="accordion__body__tab-panel__content">
		  	<h3>In-Car</h3>
		    <?php if (have_rows('teen_faq')) : ?>
		  		<?php while (have_rows('teen_faq')) : the_row(); ?>
				    <?php if (get_sub_field('question_category') == 'in_car' ) : ?>
					    <div class="faq">
					    	<p class="faq-question"><?php the_sub_field('question'); ?></p>
					    	<p class="faq-answer"><?php the_sub_field('answer'); ?></p>
					    </div>
				    <?php endif; ?>
				<?php endwhile; ?>
			<?php endif; ?>
		  </div>
		  <!-- Pulls in only FAQs under "Insurance" category -->
		  <div id="insurance" class="accordion__body__tab-panel__content">
		  	<h3>Insurance</h3>
		    <?php if (have_rows('teen_faq')) : ?>
		  		<?php while (have_rows('teen_faq')) : the_row(); ?>
				    <?php if (get_sub_field('question_category') == 'insurance' ) : ?>
					    <div class="faq">
					    	<p class="faq-question"><?php the_sub_field('question'); ?></p>
					    	<p class="faq-answer"><?php the_sub_field('answer'); ?></p>
					    </div>
				    <?php endif; ?>
				<?php endwhile; ?>
			<?php endif; ?>
		  </div>
		  <!-- Pulls in only FAQs under "State Laws" category -->
		  <div id="state-laws" class="accordion__body__tab-panel__content">
		  	<h3>State Laws</h3>
		    <?php if (have_rows('teen_faq')) : ?>
		  		<?php while (have_rows('teen_faq')) : the_row(); ?>
				    <?php if (get_sub_field('question_category') == 'state_laws' ) : ?>
					    <div class="faq">
					    	<p class="faq-question"><?php the_sub_field('question'); ?></p>
					    	<p class="faq-answer"><?php the_sub_field('answer'); ?></p>
					    </div>
				    <?php endif; ?>
				<?php endwhile; ?>
			<?php endif; ?>
		  </div>
		  <!-- Pulls in only FAQs under "DPS" category -->
		  <div id="dps" class="accordion__body__tab-panel__content">
		  	<h3>DPS</h3>
		    <?php if (have_rows('teen_faq')) : ?>
		  		<?php while (have_rows('teen_faq')) : the_row(); ?>
				    <?php if (get_sub_field('question_category') == 'dps' ) : ?>
					    <div class="faq">
					    	<p class="faq-question"><?php the_sub_field('question'); ?></p>
					    	<p class="faq-answer"><?php the_sub_field('answer'); ?></p>
					    </div>
				    <?php endif; ?>
				<?php endwhile; ?>
			<?php endif; ?>
		  </div>

	  </div>
	</div>
  </div>


  <!-- Adult FAQs -->
  <h3 class="accordion__header">Adult Driving <span>| &nbsp<i class="fa fa-angle-right rotate"></i></span></h3>
  <div class="accordion__body">
  
  <!-- Seniors FAQs -->  
  </div>
  <h3 class="accordion__header">Seniors Driving <span>| &nbsp<i class="fa fa-angle-right rotate"></i></span></h3>
  <div class="accordion__body">
  </div>

  <!-- Corporate FAQs -->
  <h3 class="accordion__header">Corporate Driving <span>| &nbsp<i class="fa fa-angle-right rotate"></i></span></h3>
  <div class="accordion__body">
   
  </div>
  <h3 class="accordion__header">Defensive Driving <span>| &nbsp<i class="fa fa-angle-right rotate"></i></span></h3>
  <div class="accordion__body">
    
  </div>
</div>