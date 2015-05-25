<?php

// Set admin menu order
function admin_menu_order() {
  function order($menu_ord) {
    if (!$menu_ord) return true;
    return array(
      'index.php', // Dashboard
      'separator1', // First separator
      'edit.php', // Posts
      'edit-comments.php', // Posts
      'edit.php?post_type=page', // Pages
      'edit.php?post_type=products', // Products
      'edit.php?post_type=recipes', // Recipes
      'edit.php?post_type=videos', // Videos
      'edit.php?post_type=promotions', // Promos
      'separator2', // Second separator
      'upload.php', // Media
      'themes.php', // Appearance
      'plugins.php', // Plugins
      'users.php', // Users
      'tools.php', // Tools
      'options-general.php', // Settings
      'edit.php?post_type=acf', // Advanced Custom Fields
      'separator-last', // Last separator
    );
  }
  add_filter('custom_menu_order', 'order');
  add_filter('menu_order', 'order');
}

function register_theme_menus() {

  register_nav_menus(
      array(
          'top-nav' => __('Top Nav'),
          'main-nav' => __('Main Nav')
        )
    );
  }
  add_action( 'init' , 'register_theme_menus' );

?>
