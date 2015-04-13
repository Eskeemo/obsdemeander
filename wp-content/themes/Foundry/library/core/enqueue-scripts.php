<?php

/*
FOUNDRY FRAMEWORK // enqueue-scripts.php
=========================================
This file is used to enqueue all javascript scripts nicely together and in
the right order. This way they all get loaded correctly in the footer
(except modernizr, which is loaded in the header, hence the last "false").
This file should be included in the "library/core" folder and imported 
by the standard functions.php file wordpress uses.

The Foundry Framework is developed by combining and customizing several
great frameworks and starterkits, such as the bones framework by Eddie
Machado (htp://themble.com/bones) and the FoundationPress starter-theme
by Ole Fredrik (http://foundationpress.olefredrik.com).

Author		: Emiel Nawijn
URL			: http://www.eskeemo.com
Version 	: 1.0
License		: WTFPL
License URI : http://sam.zoy.org/wtfpl/
Are you serious? Yes.
*/



/**************************************************/
/*********** REGISTER & ENQUEUE SCRIPTS ***********/
/**************************************************/

if (!function_exists('eskeemo_scripts')) :
	function eskeemo_scripts() {

	// deregister the jquery version bundled with wordpress
	wp_deregister_script( 'jquery' );

	// register our own scripts
	wp_register_script( 'modernizr', get_template_directory_uri() . '/library/js/modernizr.min.js', array(), false, false );
	wp_register_script( 'jquery', get_template_directory_uri() . '/library/js/jquery.min.js', array(), false, false );
	wp_register_script( 'fastclick', get_template_directory_uri() . '/library/js/fastclick.min.js', array(), false, true );
	wp_register_script( 'foundation', get_template_directory_uri() . '/library/js/foundation.custom.min.js', array(), false, true );
	wp_register_script( 'waypoints', get_template_directory_uri() . '/library/js/waypoints.min.js', array(), false, true );
	wp_register_script( 'app', get_template_directory_uri() . '/library/js/app.js', array(), false, true );

	// enqueue the scripts
	wp_enqueue_script('modernizr');
	wp_enqueue_script('jquery');
	wp_enqueue_script('fastclick');
	wp_enqueue_script('foundation');
	wp_enqueue_script('waypoints');
	wp_enqueue_script('app');
	}

	add_action( 'wp_enqueue_scripts', 'eskeemo_scripts' );
endif;

?>