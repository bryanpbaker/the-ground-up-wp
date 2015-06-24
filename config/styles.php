<?php

// Register and Enqueue Styles
function init_css() {

  // Set Site Styles
  if (!is_admin() && !is_login_page()) {

    // Bootstrap Styles
    wp_register_style(
      $handle = 'bootstrap-styles',
      $src = get_bloginfo('template_directory') . '/assets/css/bootstrap.min.css',
      $deps = '',
      $ver = null,
      $media = 'all'
    );
    wp_enqueue_style('bootstrap-styles');

    // Define Styles
    wp_register_style(
      $handle = 'main-styles',
      $src = get_bloginfo('template_directory') . '/assets/css/main.min.css',
      $deps = '',
      $ver = null,
      $media = 'all'
    );
    wp_enqueue_style('main-styles');

    // Font Awesome
    wp_register_style(
      $handle = 'font-awesome',
      $src = "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css",
      $deps = '',
      $ver = null,
      $media = 'all'
    );
    wp_enqueue_style('font-awesome');
    
  }


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
