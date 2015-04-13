<?php

/*
FOUNDRY FRAMEWORK // theme-mods.php
====================================
This file is the place to put all your modifications which are specific
for the theme you're creating. By placing all modifications in a single
file, we seperate the core framework from the theme-specific features.
This file should be included in the "library/core" folder and imported
by the standard functions.php file wordpress uses.

The Foundry Framework is developed by combining and customizing several
great frameworks and starterkits, such as the bones framework by Eddie
Machado (htp://themble.com/bones) and the FoundationPress starter-theme
by Ole Fredrik (http://foundationpress.olefredrik.com).

Author 		: Emiel Nawijn
URL 		: http://www.eskeemo.com
Version 	: 1.0
License		: WTFPL
License URI : http://sam.zoy.org/wtfpl/
Are you serious? Yes.
*/



/**************************************************/
/*********** ADD SOME SPECIAL FUNCTIONS ***********/
/**************************************************/


// add some specific image sizes
// add_image_size( 'thumbnail', 100, 100, true );		handled by Wordpress Media Settings
// add_image_size( 'medium', 640, 640, false );			handled by Wordpress Media Settings
// add_image_size( 'large', 1024, 1024, false );		handled by Wordpress Media Settings
add_image_size( 'xtra-large', 1440, 1440, false );


// define entry-meta once, use it everywhere you like
// thank you FoundationPress (http://foundationpress.olefredrik.com)
if(!function_exists('eskeemo_entry_meta')) :
	function eskeemo_entry_meta() {
		echo '<time class="updated" datetime="' . get_the_time('c') . '">' . sprintf(__('Posted on %s at %s.', 'Eskeemo Framework'), get_the_time('l, F jS, Y'), get_the_time()) . '</time>';
		echo '<p class="byline author">' . __('Written by', 'Eskeemo Framework') . ' <a href="'. get_author_posts_url(get_the_author_meta('ID')) . '" rel="author" class="fn">' . get_the_author() . '</a></p>';
	}
endif;


// define subnavigation once, use it everywhere you like
// thank you Cole Geissinger (http://www.colegeissinger.com/blog/2012/03/28/build-a-dynamic-sub-nav-for-child-pages/)
if(!function_exists('eskeemo_sub_nav')) :
	function eskeemo_sub_nav() {
		global $post; 
		if($post->post_parent) {
			$parent_id = get_post_ancestors($post->ID);
			$id = end($parent_id);
		} else {
			$id = $post->ID;
		}
		wp_list_pages('title_li=&child_of=' . $id);
	}
endif;


// create a function to load the correct thumbnail based on screensize, using foundation's interchange
// thank you Myk Klemme (http://wordpress.stackexchange.com/questions/102686/implementing-zurbs-interchange-into-wordpress)
if(!function_exists('eskeemo_responsive_thumbnails')) :
	function eskeemo_responsive_thumbnails() {
		$small = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium' );
		$medium = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large' );
		$large = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'xtra-large' );
		$xlarge = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
		echo '<img data-interchange="['. $small[0] .', (small)], ['. $medium[0] .', (medium)], ['. $large[0] .', (large)], ['. $xlarge[0] .', (xlarge)]">';
	}
endif;


// Create a function to publish an image's title, caption or description
// thank you luke Misna (https://wordpress.org/ideas/topic/functions-to-get-an-attachments-caption-title-alt-description)
function eskeemo_image_caption () {
	global $post;
	$thumbnail_id    = get_post_thumbnail_id($post->ID);
	$thumbnail_image = get_posts(array('p' => $thumbnail_id, 'post_type' => 'attachment'));
	if ($thumbnail_image && isset($thumbnail_image[0])) {
		echo '<h6 class="caption">'.$thumbnail_image[0]->post_excerpt.'</h6>';
	}
}


// add the excerpt of the parent page to the subnav of the child pages
// thank you who-ever I copied this from, can't remember :-(
if(!function_exists('eskeemo_sub_nav_excerpt')) :
	function eskeemo_sub_nav_excerpt() {
		global $post;
		if ( is_page() && $post->post_parent ) { // If this is a subpage
			$ppage = get_pages( 'include='.$post->post_parent ); // Only grab the parent
			echo '<p>' . wp_trim_excerpt( $ppage[0]->post_excerpt ) . '</p>'; // Run excerpt filter on the only item in the array
			unset($ppage); // Unset all the data in $ppage because it's no longer needed
		} else { // This is a parent page
			echo the_excerpt();
		}
	}
endif;


// determine the length of the excerpt ourselves
function eskeemo_excerpt_length( $length ) {
	return 30;
}
add_filter( 'excerpt_length', 'eskeemo_excerpt_length', 999 );


// Create a function to find the slug of the current page/post
// thank you WPRecipes (http://www.wprecipes.com/wordpress-function-to-get-postpage-slug)
function the_slug() {
    $post_data = get_post($post->ID, ARRAY_A);
    $slug = $post_data['post_name'];
    return $slug; 
}


//add shortcodes to the sidebar
add_filter('widget_text', 'do_shortcode');


// Both Foundation and Wordpress use a ".sticky" class, which might lead to unexpected behaviour.
// thank you Gareth Cooper (http://garethcooper.com/2014/01/zurb-foundation-5-and-wordpress-menus/)
function remove_sticky_class($classes) {
  $classes = array_diff($classes, array("sticky"));
  $classes[] = 'wordpress-sticky';
  return $classes;
}
add_filter('post_class','remove_sticky_class');


?>