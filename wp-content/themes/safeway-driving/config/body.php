<?php

// Add User Role class to body for Admin
function user_role_class($classes) {
  global $current_user;
  $user_role = array_shift($current_user->roles);
  $classes .= 'role-'. $user_role;
  return $classes;
}
add_filter('admin_body_class', 'user_role_class');

?>
