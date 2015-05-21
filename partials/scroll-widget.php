<nav class="navbar-fixed-top scroll-widget nav" id="scroll-widget">
  <div class="container">
    
    <?php if (have_rows('content_block') ): ?>
      <ul class="scroll-widget__list">
      <?php while (have_rows('content_block') ): the_row(); ?>
        <li><a href="#<?php the_sub_field('content_block_id'); ?>" data-toggle="tooltipScrollWidget" title="<?php the_sub_field('scroll_widget_title'); ?>">o</a></li>
      <?php endwhile; ?>
      </ul>
    <?php endif; ?>

  </div>
</nav>