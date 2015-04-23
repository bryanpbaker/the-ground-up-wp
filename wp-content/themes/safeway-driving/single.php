<?php get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
  <div class="content__block content__block--has-header <?php echo $post->post_type . '-single'; ?>">

    <?php if (locate_template('templates/singles/' . $post->post_type . '.php')): ?>
      <?php get_template_part('templates/singles/' . $post->post_type); ?>
    <?php else: ?>
      <h1><?php the_title(); ?></h1>
      <?php the_content(); ?>
    <?php endif; ?>

  </div>
<?php endwhile; wp_reset_query(); ?>

<?php get_footer(); ?>
