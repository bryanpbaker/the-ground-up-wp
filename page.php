<?php get_header(); ?>
<!-- This is NOT the traditional wordpress page.php template. It automatically looks in the templates/pages directory
	 for [page-name].php, and uses that template for your newly created page automatically. All you have to do is:
	 create your new page in the wp dashboard > create a template in templates/pages with a file name that matches the page name. -->

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

    <?php if (locate_template('templates/pages/' . $post->post_name . '.php')): ?>
      <?php get_template_part('templates/pages/' . $post->post_name); ?>
    <?php elseif (get_field('custom_template')): ?>
      <?php get_template_part('templates/pages/' . get_field('custom_template')); ?>
    <?php else: ?>
      <?php the_content(); ?>
    <?php endif; ?>

 
<?php endwhile; wp_reset_query(); ?>

<?php get_footer(); ?>
