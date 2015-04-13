<?php

/*
ESKEEMO FRAMEWORK // widget-areas.php
======================================
This file handles all widget areas in the sidebar en footer of the theme.
This file should be included in the "library/core" folder and imported by 
the standard functions.php file wordpress uses.

The Eskeemo Framework is developed by combining and customizing several
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


function eskeemo_sidebar_widgets() {
  register_sidebar(array(
      'id' => 'sidebar-widgets',
      'name' => __('Sidebar widgets', 'Eskeemo Framework'),
      'description' => __('Drag widgets to this sidebar container.', 'Eskeemo Framework'),
      'before_widget' => '<article id="%1$s" class="row widget %2$s"><div class="small-12 columns">',
      'after_widget' => '</div></article>',
      'before_title' => '<h6>',
      'after_title' => '</h6>'
  ));

  register_sidebar(array(
      'id' => 'footer-widgets',
      'name' => __('Footer widgets', 'Eskeemo Framework'),
      'description' => __('Drag widgets to this footer container', 'Eskeemo Framework'),
      'before_widget' => '<article id="%1$s" class="large-4 columns widget %2$s">',
      'after_widget' => '</article>',
      'before_title' => '<h6>',
      'after_title' => '</h6>'      
  ));
}

add_action( 'widgets_init', 'eskeemo_sidebar_widgets' );

?>