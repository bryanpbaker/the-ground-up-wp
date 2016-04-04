<?php

/*
 * Config
 * -------------------------------------------------------------------------- */

// Load functions in '/config'
require_once('config/loader.php');

// Admin bar resets- Remove top admin bar by default
// add_action('init', 'remove_admin_bar');
// add_action('init', 'remove_admin_bar_links');

// // Post type resets- Disable Posts/Comments
// // add_action('init', 'globally_disable_posts');
// add_action('init', 'globally_disable_comments');

// // Admin dashboard resets
// add_action('init', 'remove_dashboard_widgets');

// // Admin menu customization
// add_action('init', 'admin_menu_order');


?>
