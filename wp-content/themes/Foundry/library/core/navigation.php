<?php

/*
FOUNDRY FRAMEWORK // navigation.php
====================================
This file handles all the menu's and positions provided in this theme.
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
/************ REGISTER MENU POSITIONS *************/
/**************************************************/

register_nav_menus(array(
    'top-bar-l' => 'Left Top Bar',
    'top-bar-r' => 'Right Top Bar',
    'mobile-off-canvas' => 'Mobile'
));



/**************************************************/
/*********** DEFINE MENU SPECIFICATIONS ***********/
/**************************************************/

// left top bar
if ( ! function_exists( 'eskeemo_top_bar_l' ) ) {
	function eskeemo_top_bar_l() {
		wp_nav_menu(array( 
			'container' => false,                           // remove nav container
			'container_class' => '',                        // class of container
			'menu' => '',                                   // menu name
			'menu_class' => 'top-bar-menu left',            // adding custom nav class
			'theme_location' => 'top-bar-l',                // where it's located in the theme
			'before' => '',                                 // before each link <a> 
			'after' => '',                                  // after each link </a>
			'link_before' => '',                            // before each link text
			'link_after' => '',                             // after each link text
			'depth' => 5,                                   // limit the depth of the nav
			'fallback_cb' => false,                         // fallback function (see below)
			'walker' => new top_bar_walker()
		));
	}
}

// right top bar
if ( ! function_exists( 'eskeemo_top_bar_r' ) ) {
	function eskeemo_top_bar_r() {
		wp_nav_menu(array( 
			'container' => false,                           // remove nav container
			'container_class' => '',                        // class of container
			'menu' => '',                                   // menu name
			'menu_class' => 'top-bar-menu right',           // adding custom nav class
			'theme_location' => 'top-bar-r',                // where it's located in the theme
			'before' => '',                                 // before each link <a> 
			'after' => '',                                  // after each link </a>
			'link_before' => '',                            // before each link text
			'link_after' => '',                             // after each link text
			'depth' => 5,                                   // limit the depth of the nav
			'fallback_cb' => false,                         // fallback function (see below)
			'walker' => new top_bar_walker()
		));
	}
}

// mobile off-canvas menu
if ( ! function_exists( 'eskeemo_mobile_off_canvas' ) ) {
	function eskeemo_mobile_off_canvas() {
		wp_nav_menu(array( 
			'container' => false,                           // remove nav container
			'container_class' => '',                        // class of container
			'menu' => '',                                   // menu name
			'menu_class' => 'off-canvas-list',              // adding custom nav class
			'theme_location' => 'mobile-off-canvas',        // where it's located in the theme
			'before' => '',                                 // before each link <a> 
			'after' => '',                                  // after each link </a>
			'link_before' => '',                            // before each link text
			'link_after' => '',                             // after each link text
			'depth' => 5,                                   // limit the depth of the nav
			'fallback_cb' => false,                         // fallback function (see below)
			'walker' => new FoundationNavWalker()
		));
	}
}


/** 
 * Add support for buttons in the top-bar menu: 
 * 1) In WordPress admin, go to Apperance -> Menus. 
 * 2) Click 'Screen Options' from the top panel and enable 'CSS CLasses' and 'Link Relationship (XFN)'
 * 3) On your menu item, type 'has-form' in the CSS-classes field. Type 'button' in the XFN field
 * 4) Save Menu. Your menu item will now appear as a button in your top-menu
*/
if ( ! function_exists( 'add_menuclass') ) {
	function add_menuclass($ulclass) {
		$find = array('/<a rel="button"/', '/<a title=".*?" rel="button"/');
		$replace = array('<a rel="button" class="button"', '<a rel="button" class="button"');

		return preg_replace($find, $replace, $ulclass, 1);
	}
	add_filter('wp_nav_menu','add_menuclass');
}

?>
