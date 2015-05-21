<?php

/*
 * Config
 * -------------------------------------------------------------------------- */

// Load functions in '/config'
require_once('config/loader.php');

// Admin bar resets
add_action('init', 'remove_admin_bar');
add_action('init', 'remove_admin_bar_links');

// Post type resets
add_action('init', 'globally_disable_posts');
add_action('init', 'globally_disable_comments');

// Admin dashboard resets
add_action('init', 'remove_dashboard_widgets');

// Admin menu customization
add_action('init', 'admin_menu_order');

// Post type additions
add_action('init', 'post_type_products');
add_action('init', 'post_type_recipes');
add_action('init', 'post_type_videos');
add_action('init', 'post_type_promotions');

// Custom taxonomies
add_action('init', 'taxonomy_product_category');
add_action('init', 'taxonomy_recipe_category');
add_action('init', 'taxonomy_video_tags');


// ACF Video Description Excerpt
function video_description_excerpt() {
	global $post;
	$text = get_field('video_description'); //Replace 'your_field_name'
	if ( '' != $text ) {
		$text = strip_shortcodes( $text );
		$text = apply_filters('the_content', $text);
		$text = str_replace(']]&gt;', ']]&gt;', $text);
		$excerpt_length = 20; // 20 words
		$excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
		$text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
	}
	return apply_filters('the_excerpt', $text);
}


?>
