<?php

// Register and Enqueue Scripts
function init_js() {

  // Set Site Scripts
  if (!is_admin() && !is_login_page()) {

  
    // Redfine jQuery
    wp_deregister_script('jquery');
    wp_register_script(
      $handle = 'site-jquery',
      $src = "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://code.jquery.com/jquery-1.11.2.min.js",
      $deps = array(),
      $ver = null,
      $in_footer = true
    );
    wp_enqueue_script('site-jquery');

    // Define Modernizr
    wp_register_script(
      $handle = 'site-modernizr',
      $src = "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.aspnetcdn.com/ajax/modernizr/modernizr-2.7.1.min.js",
      $deps = array(),
      $ver = null,
      $in_footer = false
    );
    wp_enqueue_script('site-modernizr');

    // Vendor Concatenated Scripts
    wp_register_script(
      $handle = 'vendor-scripts',
      $src = get_bloginfo('template_directory') . '/assets/js/vendors.min.js',
      $deps = array('site-jquery'),
      $ver = null,
      $in_footer = true
    );
    wp_enqueue_script('vendor-scripts');

    // Main Concatenated Scripts
    wp_register_script(
      $handle = 'main-scripts',
      $src = get_bloginfo('template_directory') . '/assets/js/main.min.js',
      $deps = array('site-jquery'),
      $ver = null,
      $in_footer = true
    );
    wp_enqueue_script('main-scripts');

  }

}

// Initialize Scripts
add_action('init', 'init_js');
  
?>
