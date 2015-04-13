<?php

/*
FOUNDRY FRAMEWORK // cleanup.php
=================================
WordPress can get quite messy sometimes, especially in the head. So let's 
start by removing all the junk and other stuff that we really don't need. 
This file should be included in the "library/core" folder and imported 
by the standard functions.php file wordpress uses.

The Foundry Framework is developed by combining and customizing several
great frameworks and starterkits, such as the bones framework by Eddie
Machado (htp://themble.com/bones) and the FoundationPress starter-theme
by Ole Fredrik (http://foundationpress.olefredrik.com).

Author      : Emiel Nawijn
URL         : http://www.eskeemo.com
Version     : 1.0
License     : WTFPL
License URI : http://sam.zoy.org/wtfpl/
Are you serious? Yes.
*/



/**************************************************/
/************ LAUNCH OPERATION CLEANUP ************/
/**************************************************/

add_action('after_setup_theme','eskeemo_cleanup');

function eskeemo_cleanup() {

    // start by cleaning up the head
    add_action('init', 'eskeemo_head_cleanup');

    // remove WP version from RSS
    add_filter('the_generator', 'remove_rss_version');

    // remove pesky injected css for recent comments widget
    add_filter('wp_head', 'remove_wp_widget_recent_comments_style', 1);

    // clean up comment styles in the head
    add_action('wp_head', 'remove_recent_comments_style', 1);

    // clean up gallery output in wp
    add_filter('gallery_style', 'gallery_style');

    // additional post related cleaning
    add_filter('get_image_tag_class', 'image_tag_class', 0, 4);
    add_filter('get_image_tag', 'image_editor', 0, 4);

} 


/**************************************************/
/**************** CLEAN UP THE HEAD ***************/
/**************************************************/

function eskeemo_head_cleanup() {

    // EditURI link
    remove_action( 'wp_head', 'rsd_link' );

    // Category feed links (some people use these!)
    // remove_action( 'wp_head', 'feed_links_extra', 3 );

    // Post and comment feed links (and these too!)
    // remove_action( 'wp_head', 'feed_links', 2 );

    // Windows Live Writer
    remove_action( 'wp_head', 'wlwmanifest_link' );

    // Index link
    remove_action( 'wp_head', 'index_rel_link' );

    // Previous link
    remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );

    // Start link
    remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );

    // Shortlink
    remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );

    // Links for adjacent posts
    remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

    // WP version
    remove_action( 'wp_head', 'wp_generator' );

    // Remove WP version from css
    add_filter( 'style_loader_src', 'remove_wp_ver_css_js', 9999 );

    // Remove WP version from scripts
    add_filter( 'script_loader_src', 'remove_wp_ver_css_js', 9999 );

    // Prevent unneccecary info from being displayed
    add_filter('login_errors',create_function('$a', "return null;"));

} 

// remove WP version from RSS
function remove_rss_version() { return ''; }

// remove WP version from scripts
function remove_wp_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}

// remove injected CSS for recent comments widget
function remove_wp_widget_recent_comments_style() {
   if ( has_filter('wp_head', 'wp_widget_recent_comments_style') ) {
      remove_filter('wp_head', 'wp_widget_recent_comments_style' );
   }
}

// remove injected CSS from recent comments widget
function remove_recent_comments_style() {
  global $wp_widget_factory;
  if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
  }
}

// remove injected CSS from gallery
function gallery_style($css) {
  return preg_replace("!<style type='text/css'>(.*?)</style>!s", '', $css);
}


/**************************************************/
/*************** CLEAN UP IMAGE TAGS **************/
/**************************************************/

// Remove default inline style of wp-caption
add_shortcode('wp_caption', 'fixed_img_caption_shortcode');
add_shortcode('caption', 'fixed_img_caption_shortcode');
function fixed_img_caption_shortcode($attr, $content = null) {
    if ( ! isset( $attr['caption'] ) ) {
        if ( preg_match( '#((?:<a [^>]+>\s*)?<img [^>]+>(?:\s*</a>)?)(.*)#is', $content, $matches ) ) {
            $content = $matches[1];
            $attr['caption'] = trim( $matches[2] );
        }
    }
    $output = apply_filters('img_caption_shortcode', '', $attr, $content);
    if ( $output != '' )
        return $output;
    extract(shortcode_atts(array(
        'id'    => '',
        'align' => 'alignnone',
        'width' => '',
        'caption' => '',
        'class'   => ''
    ), $attr));
    if ( 1 > (int) $width || empty($caption) )
        return $content;

    $markup = '<figure';
    if ($id) $markup .= ' id="' . esc_attr($id) . '"';
    if ($class) $markup .= ' class="' . esc_attr($class) . '"';
    $markup .= '>';
    $markup .= do_shortcode( $content ) . '<figcaption>' . $caption . '</figcaption></figure>';
    return $markup;
}

// Clean the output of attributes of images in editor
function image_tag_class($class, $id, $align, $size) {
    $align = 'align' . esc_attr($align);
    return $align;
} 

// Remove width and height in editor, for a better responsive world.
function image_editor($html, $id, $alt, $title) {
    return preg_replace(array(
            '/\s+width="\d+"/i',
            '/\s+height="\d+"/i',
            '/alt=""/i'
        ),
        array(
            '',
            '',
            '',
            'alt="' . $title . '"'
        ),
        $html);
} 

// remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
function bones_filter_ptags_on_images($content){
    return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}


/**************************************************/
/********** ADDITIONAL CLEAN UP ACTIONS ***********/
/**************************************************/

// This removes the annoying […] to a Read More link
function eskeemo_excerpt_more($more) {
    global $post;
    // edit here if you like
    return ' ...';
}

// remove annoying #more page-jump after clicking the 'read-more' link
function eskeemo_remove_more($link) {
    $offset = strpos($link, '#more-'); 
    if ($offset) { 
        $end = strpos($link, '"', $offset);
    }
    if ($end) {
        $link = substr_replace($link, '', $offset, $end-$offset);
    }
    return $link;
}

?>
