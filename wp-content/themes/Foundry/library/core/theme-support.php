<?php

/*
FOUNDRY FRAMEWORK // theme-support.php
=======================================
This file handles the wordpress options that are supported by this theme.
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
/************ SETUP WP3+ THEME SUPPORT ************/
/**************************************************/

function eskeemo_theme_support() {

    // No language support for now, fist let's get this thing working
    //load_theme_textdomain('Eskeemo Framework', get_template_directory() . '/library/lang');

	// Add custom background support (thx to @bransonwerner for update)
	// disabled for now, in favor of hardcoded but responsively loaded backgrounds
	// add_theme_support( 'custom-background',
	//     array(
	//     'default-image' => '',    // background image default
	//     'default-color' => '',    // background color default (don't add the #)
	//     'wp-head-callback' => '_custom_background_cb',
	//     'admin-head-callback' => '',
	//     'admin-preview-callback' => ''
	//     )
	// );

    // Add menu support
    add_theme_support('menus');

    // Add post thumbnail support: http://codex.wordpress.org/Post_Thumbnails
    add_theme_support('post-thumbnails');

    // rss thingy
    add_theme_support('automatic-feed-links');

    // Add post formarts support: http://codex.wordpress.org/Post_Formats
    add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));

    // Add symantic HTML5 support: http://codex.wordpress.org/Semantic_Markup
	add_theme_support( 'html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ));

}

add_action('after_setup_theme', 'eskeemo_theme_support'); 
?>