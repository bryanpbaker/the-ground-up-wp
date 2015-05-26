<?php

// Register and Enqueue Styles
function init_css() {

  // Set Site Styles
  if (!is_admin() && !is_login_page()) {

    // // Define vendor styles
    // wp_register_style(
    //   $handle = 'site-vendors',
    //   $src = get_bloginfo('template_directory') . '/assets/css/vendors.min.css',
    //   $deps = array(),
    //   $ver = null,
    //   $media = 'all'
    // );
    // wp_enqueue_style('site-vendors');

    // // Define main styles
    // wp_register_style(
    //   $handle = 'site-styles',
    //   $src = get_bloginfo('template_directory') . '/assets/css/styles.min.css',
    //   $deps = array('site-vendors'),
    //   $ver = null,
    //   $media = 'all'
    // );
    // wp_enqueue_style('site-styles');

    // Define Styles
    wp_register_style(
      $handle = 'main-styles',
      $src = get_bloginfo('template_directory') . '/assets/css/main.min.css',
      $deps = '',
      $ver = null,
      $media = 'all'
    );
    wp_enqueue_style('main-styles');
<<<<<<< HEAD
=======


>>>>>>> 57c9c00a422c2fabd0ae320b09f31f63a163a12a
  }

  // Use this if you want to link to a web font
  // // Define Site Fonts
  //   wp_register_style(
  //     $handle = 'site-fonts',
  //     $src = "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://cloud.webtype.com/css/35607e05-895e-4ee9-ba34-2b056d043449.css",
  //     $deps = array(),
  //     $ver = null,
  //     $media = 'all'
  //   );
  //   wp_enqueue_style('site-fonts');

  // Set Admin Styles
  if (is_admin() || is_login_page()) {

    // Define main admin styles
    wp_register_style(
      $handle = 'admin-styles',
      $src = get_bloginfo('template_directory') . '/assets/css/admin.css',
      $deps = array(),
      $ver = null,
      $media = 'all'
    );
    wp_enqueue_style('admin-styles');

  }
}

// Initialize Styles
add_action('init', 'init_css');

?>
