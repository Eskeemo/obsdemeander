<?php

/*
FOUNDRY FRAMEWORK // functions.php
====================================
This file is a standard WordPress file, which can be used to change the
default behaviors of WordPress. All functionality added through this file
is theme-specific (whereas plugins cover all themes) and will be lost if
another theme is loaded in the WordPress backend.

The Foundry Framework is developed by combining and customizing several
great frameworks and starterkits, such as the bones framework by Eddie
Machado (htp://themble.com/bones) and the FoundationPress starter-theme
by Ole Fredrik (http://foundationpress.olefredrik.com).

Author		: Emiel Nawijn
URL 		: http://www.eskeemo.com
Version 	: 1.0
License		: WTFPL
License URI : http://sam.zoy.org/wtfpl/
Are you serious? Yes.
*/


/**************************************************/
/********** LAUNCH THE FOUNDRY FRAMEWORK **********/
/**************************************************/

// First let's perform some cleaning
require_once('library/core/cleanup.php');

// Then register all navigation menus
require_once('library/core/navigation.php');

// Add a menu walker for the topbar
require_once('library/core/menu-walker-topbar.php');

// And a menu walker for the off-canvas menu
require_once('library/core/menu-walker-offcanvas.php');

// Create some nice widget areas in sidebar and footer
require_once('library/core/widget-areas.php');

// And it's good pracice to enqueue your scripts
require_once('library/core/enqueue-scripts.php');

// Obviously we want some nice WP3 functions
require_once('library/core/theme-support.php');

// And finally we load the theme modifications
require_once('library/core/theme-mods.php');

?>