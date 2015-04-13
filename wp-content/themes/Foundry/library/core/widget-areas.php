<?php

/*
FOUNDRY FRAMEWORK // widget-areas.php
======================================
This file handles all widget areas in the sidebar and footer of the theme.
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
/********** REGISTER WORDPRESS SIDEBARS ***********/
/**************************************************/

function eskeemo_sidebar_widgets() {
  register_sidebar(array(
      'id' => 'home',
      'name' => 'Sidebar voor homepage',
      'description' => 'Hier kan je widgets plaatsen voor op de homepage.',
      'before_widget' => '<article id="%1$s" class="row widget %2$s">',
      'after_widget' => '</article>',
      'before_title' => '<h4 class="widget-title">',
      'after_title' => '</h4>'
  ));
  register_sidebar(array(
      'id' => 'groep-12a',
      'name' => 'Sidebar voor groep 1/2a',
      'description' => 'Hier kan je widgets plaatsen voor de pagina van groep 1/2a, zoals leuke links voor deze groep en relevante agenda activiteiten voor deze groep. De docenten van de groep worden automatisch getoond, dat kan je dus niet hier instellen.',
      'before_widget' => '<article id="%1$s" class="row widget %2$s">',
      'after_widget' => '</article>',
      'before_title' => '<h4 class="widget-title">',
      'after_title' => '</h4>'
  ));
  register_sidebar(array(
      'id' => 'groep-12b',
      'name' => 'Sidebar voor groep 1/2b',
      'description' => 'Hier kan je widgets plaatsen voor de pagina van groep 1/2b, zoals leuke links voor deze groep en relevante agenda activiteiten voor deze groep. De docenten van de groep worden automatisch getoond, dat kan je dus niet hier instellen.',
      'before_widget' => '<article id="%1$s" class="row widget %2$s">',
      'after_widget' => '</article>',
      'before_title' => '<h4 class="widget-title">',
      'after_title' => '</h4>'
  ));
  register_sidebar(array(
      'id' => 'groep-3',
      'name' => 'Sidebar voor groep 3',
      'description' => 'Hier kan je widgets plaatsen voor de pagina van groep 1/2a, zoals leuke links voor deze groep en relevante agenda activiteiten voor deze groep. De docenten van de groep worden automatisch getoond, dat kan je dus niet hier instellen.',
      'before_widget' => '<article id="%1$s" class="row widget %2$s">',
      'after_widget' => '</article>',
      'before_title' => '<h4 class="widget-title">',
      'after_title' => '</h4>'
  ));
  register_sidebar(array(
      'id' => 'groep-4',
      'name' => 'Sidebar voor groep 4',
      'description' => 'Hier kan je widgets plaatsen voor de pagina van groep 1/2a, zoals leuke links voor deze groep en relevante agenda activiteiten voor deze groep. De docenten van de groep worden automatisch getoond, dat kan je dus niet hier instellen.',
      'before_widget' => '<article id="%1$s" class="row widget %2$s">',
      'after_widget' => '</article>',
      'before_title' => '<h4 class="widget-title">',
      'after_title' => '</h4>'
  ));
  register_sidebar(array(
      'id' => 'groep-5',
      'name' => 'Sidebar voor groep 5',
      'description' => 'Hier kan je widgets plaatsen voor de pagina van groep 1/2a, zoals leuke links voor deze groep en relevante agenda activiteiten voor deze groep. De docenten van de groep worden automatisch getoond, dat kan je dus niet hier instellen.',
      'before_widget' => '<article id="%1$s" class="row widget %2$s">',
      'after_widget' => '</article>',
      'before_title' => '<h4 class="widget-title">',
      'after_title' => '</h4>'
  ));
  register_sidebar(array(
      'id' => 'groep-6',
      'name' => 'Sidebar voor groep 6',
      'description' => 'Hier kan je widgets plaatsen voor de pagina van groep 1/2a, zoals leuke links voor deze groep en relevante agenda activiteiten voor deze groep. De docenten van de groep worden automatisch getoond, dat kan je dus niet hier instellen.',
      'before_widget' => '<article id="%1$s" class="row widget %2$s">',
      'after_widget' => '</article>',
      'before_title' => '<h4 class="widget-title">',
      'after_title' => '</h4>'
  ));
  register_sidebar(array(
      'id' => 'groep-7',
      'name' => 'Sidebar voor groep 7',
      'description' => 'Hier kan je widgets plaatsen voor de pagina van groep 1/2a, zoals leuke links voor deze groep en relevante agenda activiteiten voor deze groep. De docenten van de groep worden automatisch getoond, dat kan je dus niet hier instellen.',
      'before_widget' => '<article id="%1$s" class="row widget %2$s">',
      'after_widget' => '</article>',
      'before_title' => '<h4 class="widget-title">',
      'after_title' => '</h4>'
  ));
  register_sidebar(array(
      'id' => 'groep-8',
      'name' => 'Sidebar voor groep 8',
      'description' => 'Hier kan je widgets plaatsen voor de pagina van groep 1/2a, zoals leuke links voor deze groep en relevante agenda activiteiten voor deze groep. De docenten van de groep worden automatisch getoond, dat kan je dus niet hier instellen.',
      'before_widget' => '<article id="%1$s" class="row widget %2$s">',
      'after_widget' => '</article>',
      'before_title' => '<h4 class="widget-title">',
      'after_title' => '</h4>'
  ));
  register_sidebar(array(
      'id' => 'ouderraad',
      'name' => 'Sidebar Ouderraad',
      'description' => 'Hier kan je widgets plaatsen voor de pagina van de ouderraad. Deze verschijnen onder de linker subnavigatie op de pagina en zijn niet zichtbaar op een mobiel.',
      'before_widget' => '<div class="outerbox"><div class="innerbox"><article id="%1$s" class="row widget %2$s">',
      'after_widget' => '</article></div></div>',
      'before_title' => '<h4 class="widget-title">',
      'after_title' => '</h4>'
  ));
}

add_action( 'widgets_init', 'eskeemo_sidebar_widgets' );

?>