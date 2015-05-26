<?php get_header(); ?>

 	<?php if (locate_template('templates/pages/' . $post->post_name . '.php')): ?>
      <?php get_template_part('templates/pages/' . $post->post_name); ?>
    <?php else: ?>
      <?php the_content(); ?>
    <?php endif; ?>

    

<?php get_footer(); ?>
