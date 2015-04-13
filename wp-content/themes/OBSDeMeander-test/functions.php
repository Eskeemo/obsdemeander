<?php

/*
ESKEEMO FRAMEWORK // functions.php
====================================
This file is a standard WordPress file, which can be used to change the
default behaviors of WordPress. All functionality added through this file
is theme-specific (whereas plugins cover all themes) and will be lost if
another theme is loaded in the WordPress backend.

The Eskeemo Framework is developed by combining and customizing several
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
/********** LAUNCH THE ESKEEMO FRAMEWORK **********/
/**************************************************/

// First let's run various clean up functions
require_once('library/core/cleanup.php');

// Then make all Foundation references work properly
require_once('library/core/foundation.php');

// We also want to register all navigation menus
require_once('library/core/navigation.php');

// And even add a menu walker
require_once('library/core/menu-walker.php');

// Here you go, some nice widget areas in sidebar and footer
require_once('library/core/widget-areas.php');

// Return entry meta information for posts
require_once('library/core/entry-meta.php');

// And it's good pracice to enqueue your scripts
require_once('library/core/enqueue-scripts.php');

// And finally we want this theme to offer some nice WP3 functions
require_once('library/core/theme-support.php');

?>