<?php get_header(); ?>

 	<?php if (locate_template('templates/pages/' . $post->post_name . '.php')): ?>
      <?php get_template_part('templates/pages/' . $post->post_name); ?>
    <?php elseif (get_field('custom_template')): ?>
      <?php get_template_part('templates/pages/' . get_field('custom_template')); ?>
    <?php else: ?>
      <?php the_content(); ?>
    <?php endif; ?>

    

<?php get_footer(); ?>
