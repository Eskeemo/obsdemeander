<?php

/*
FOUNDRY FRAMEWORK // menu-walker-offcanvas.php
===============================================
This file handles all customizations of Foundations' off-canvas menu. 
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
/******* CREATE THE OFF-CANVAS MENU WALKER ********/
/**************************************************/

class FoundationNavWalker extends Walker_Nav_Menu {

  //Start the menu rendering by indenting
  public function start_lvl( &$output, $depth = 0, $args = array() ) {
    $indent = str_repeat( "\t", $depth);
    $output .= "\n$indent\n";
  }

  //Loop for each individual element
  public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
    $indent = ( $depth ) ? str_repeat( "\t", $depth) : '';

    //Get classes
    $class_names = $value = '';

    $classes = empty( $item->classes ) ? array() : (array) $item->classes;
    $classes[] = 'menu-item-' . $item->ID;
    $classes[] = ($item->current) ? 'active' : '';

    $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );

    $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

    //Get id
    $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
    $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

    if ( $depth === 0 ) {
      $output .= '<li' . $id . $value . $class_names . '><label>' . esc_attr( $item->title ) . '</label>';
    }

    if ( $depth === 1) {
      $output .= '<li' . $id . $value . $class_names .'>';

      if (!empty($item->url)) {
        $output .= '<a href="' . $item->url . '">' . $item->title . '</a>';
      }

    }
  }

  //End the menu rendering by indenting
  public function end_lvl( &$output, $depth = 0, $args = array() ) {
    $indent = str_repeat( "\t", $depth);
    $output .= "\n$indent\n";
  }
}

?>