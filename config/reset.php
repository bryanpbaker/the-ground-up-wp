<?php

// // Globally hide top admin bar
// function remove_admin_bar() {

// 	// Hide admin bar on front end
// 	add_filter( 'show_admin_bar', '__return_false' );

// 	// Hide admin bar via CSS on back end
// 	function hide_admin_bar() {
// 		echo '<style type="text/css">
// 			#wpadminbar {
// 				display: none !important;
// 			}
// 			html {
// 				padding-top: 0 !important;
// 			}
// 			@media screen and (max-width: 782px) {
// 				#wpadminbar {
// 					display: block !important;
// 				}
// 				html {
// 					padding-top: 46px !important;
// 				}
// 			}
// 			@media screen and (max-width: 600px) {
// 				#wpadminbar {
// 					display: block !important;
// 				}
// 				html {
// 					padding-top: 0 !important;
// 				}
// 			}
// 		</style>';
// 	}
// 	add_action( 'admin_head', 'hide_admin_bar' );

// }

// // Remove items from admin bar navigation
// function remove_admin_bar_links() {

// 	function link_config() {
// 	    global $wp_admin_bar;
// 	    $wp_admin_bar->remove_menu('wp-logo');
// 	    // $wp_admin_bar->remove_menu('about');
// 	    // $wp_admin_bar->remove_menu('wporg');
// 	    // $wp_admin_bar->remove_menu('documentation');
// 	    // $wp_admin_bar->remove_menu('support-forums');
// 	    // $wp_admin_bar->remove_menu('feedback');
// 	    $wp_admin_bar->remove_menu('site-name');
// 	    // $wp_admin_bar->remove_menu('view-site');
// 	    // $wp_admin_bar->remove_menu('updates');
// 	    $wp_admin_bar->remove_menu('comments');
// 	    $wp_admin_bar->remove_menu('new-content');
// 	    // $wp_admin_bar->remove_menu('w3tc');
// 	    $wp_admin_bar->remove_menu('my-account');
// 	}
// 	add_action('wp_before_admin_bar_render', 'link_config');

// }

// // Globally disable posts
// function globally_disable_posts() {

// 	// Disable support for posts in post types
// 	function disable_posts_post_types_support() {
// 		$post_types = get_post_types();
// 		foreach ($post_types as $post_type) {
// 			if(post_type_supports($post_type, 'post')) {
// 				remove_post_type_support($post_type, 'post');
// 			}
// 		}
// 	}
// 	add_action('admin_init', 'disable_posts_post_types_support');

// 	// Remove posts page in menu
// 	function disable_posts_admin_menu() {
// 		remove_menu_page('edit.php');
// 	}
// 	add_action('admin_menu', 'disable_posts_admin_menu');

// }

// // Globally disable comments
// function globally_disable_comments() {

// 	// Disable support for comments and trackbacks in post types
// 	function disable_comments_post_types_support() {
// 		$post_types = get_post_types();
// 		foreach ($post_types as $post_type) {
// 			if(post_type_supports($post_type, 'comments')) {
// 				remove_post_type_support($post_type, 'comments');
// 				remove_post_type_support($post_type, 'trackbacks');
// 			}
// 		}
// 	}
// 	add_action('admin_init', 'disable_comments_post_types_support');

// 	// Remove comments page in menu
// 	function disable_comments_admin_menu() {
// 		remove_menu_page('edit-comments.php');
// 	}
// 	add_action('admin_menu', 'disable_comments_admin_menu');

// 	// Redirect any user trying to access comments page
// 	function disable_comments_admin_menu_redirect() {
// 		global $pagenow;
// 		if ($pagenow === 'edit-comments.php') {
// 			wp_redirect(admin_url()); exit;
// 		}
// 	}
// 	add_action('admin_init', 'disable_comments_admin_menu_redirect');

// }

// Remove dashboard items
function remove_dashboard_widgets() {

	// Removes welcome panel
	remove_action('welcome_panel', 'wp_welcome_panel');

	// Remove default widgets
	function dashboard_widgets() {
		remove_meta_box('dashboard_quick_press', 'dashboard', 'normal');
		remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
		remove_meta_box('dashboard_primary', 'dashboard', 'normal');
		// remove_meta_box('dashboard_activity', 'dashboard', 'normal');
		// remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
	}
	add_action('admin_menu', 'dashboard_widgets');

}

?>
