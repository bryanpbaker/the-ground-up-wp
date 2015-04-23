<?php

// Check if user is on the Login Page
function is_login_page() {
  return in_array($GLOBALS['pagenow'], array(
    'wp-login.php',
    'wp-register.php'
  ));
}

// Current slug
function get_slug() {
  $url = $_SERVER["REQUEST_URI"];
  $explode_url = explode("/", $url);
  $slug = $explode_url[count($explode_url) - 2];
  return $slug;
}

?>
