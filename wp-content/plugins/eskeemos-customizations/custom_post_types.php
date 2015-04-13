<?php
/*
 * Plugin Name: Eskeemo's Custom Post Types
 * Description: A plugin to handle all the custom post types for the OBS-De-Meander website, including teamleden, ouderpraat, ouderraad, medezeggenschapsraad & verkeerscommissie. Also some custom taxanomies to use with these post-types.
 * Version: 1.0
 * Author: Emiel Nawijn
 * Author URI: http://www.eskeemo.com
 * License: GPL3
 */



/**************************************************/
/************ CREATE CUSTOM POST TYPES ************/
/**************************************************/

function eskeemo_custom_post_type() {

	// create the custom-post-type "medewerkers"
	$labels = array(
		'name'					=>	'Medewerkers',
		'singular_name'			=>	'Medewerker',
		'menu_name'				=>	'Team',
		'all_items'				=>	'Alle medewerkers',
		'view_item' 			=>	'Bekijk medewerker',
		'add_new' 				=>	'medewerker toevoegen',
		'add_new_item' 			=>	'Nieuwe medewerker',
		'edit_item' 			=>	'Wijzig medewerker',
		'update_item' 			=>	'Medewerker bijwerken',
		'search_items' 			=>	'Zoek medewerkers',
		'not_found' 			=>	'Geen medewerkers gevonden',
		'not_found_in_trash'	=>	'Geen medewerkers gevonden in de prullenbak',
		);
	$rewrite = array (
		'slug' 					=>	'medewerker',
		'with_front' 			=>	true,
		'pages' 				=>	true,
		'feeds' 				=>	true,
		);
	$supports = array (
		//'title',
		//'editor',
		//'author',
		'thumbnail',
		//'excerpt',
		//'trackbacks',
		//'custom-fields',
		//'comments',
		//'revisions',
		//'page-attributes',
		//'post-formats',
		);
	$args = array (
		'label' 				=>	'medewerkers',
		'description' 			=>	'Gegevens van medewerkers',
		'public' 				=>	true,
		'has_archive'			=>	true,
		'can_export'			=>	true,
		'exclude_from_search'	=>	false,
		'publicly_queryable'	=>	true,
		'show_ui'				=>	true,
		'show_in_menu'			=>	true,
		'show_in_nav_menus'		=>	true,
		'show_in_admin_bar'		=>	true,
		'menu_position'			=>	5,
		'menu_icon'				=>	'dashicons-id',
		'map_meta_cap'			=>	true,
		'capability_type'		=>	'team',
		'rewrite'				=>	$rewrite,
		'labels'				=>	$labels,
		'supports'				=>	$supports,
		);
	register_post_type( 'medewerkers', $args );

	// create the custom-post-type "medezeggenschapsraad"
	$labels = array(
		'name'					=>	'Medezeggenschapsraad',
		'singular_name'			=>	'Medezeggenschapsraad',
		'menu_name'				=>	'MR',
		'all_items'				=>	'Alle berichten van de MR',
		'view_item' 			=>	'Bekijk bericht',
		'add_new' 				=>	'bericht toevoegen',
		'add_new_item' 			=>	'Nieuw bericht van de MR',
		'edit_item' 			=>	'Wijzig bericht',
		'update_item' 			=>	'Bericht bijwerken',
		'search_items' 			=>	'Zoek bericht van de MR',
		'not_found' 			=>	'Geen bericht van de MR gevonden',
		'not_found_in_trash'	=>	'Geen bericht van de MR gevonden in de prullenbak',
		);
	$rewrite = array (
		'slug' 					=>	'medezeggenschapsraad',
		'with_front' 			=>	true,
		'pages' 				=>	true,
		'feeds' 				=>	true,
		);
	$supports = array (
		'title',
		'editor',
		'author',
		'thumbnail',
		'excerpt',
		//'trackbacks',
		//'custom-fields',
		//'comments',
		//'revisions',
		//'page-attributes',
		'post-formats',
		);
	$args = array (
		'label' 				=>	'medezeggenschapsraad',
		'description' 			=>	'Berichten van de medezeggenschapsraad.',
		'public' 				=>	true,
		'has_archive'			=>	true,
		'can_export'			=>	true,
		'exclude_from_search'	=>	false,
		'publicly_queryable'	=>	true,
		'show_ui'				=>	true,
		'show_in_menu'			=>	true,
		'show_in_nav_menus'		=>	true,
		'show_in_admin_bar'		=>	true,
		'menu_position'			=>	6,
		'menu_icon'				=>	'dashicons-businessman',
		'map_meta_cap'			=>	true,
		'capability_type'		=>	'MR',
		'rewrite'				=>	$rewrite,
		'labels'				=>	$labels,
		'supports'				=>	$supports,
		);
	register_post_type( 'medezeggenschapsraad', $args );

	// create the custom-post-type "ouderraad"
	$labels = array(
		'name'					=>	'Ouderraad',
		'singular_name'			=>	'Ouderraad',
		'menu_name'				=>	'OR',
		'all_items'				=>	'Alle berichten van de ouderraad',
		'view_item' 			=>	'Bekijk bericht',
		'add_new' 				=>	'bericht toevoegen',
		'add_new_item' 			=>	'Nieuw bericht van de ouderraad',
		'edit_item' 			=>	'Wijzig bericht',
		'update_item' 			=>	'Bericht bijwerken',
		'search_items' 			=>	'Zoek bericht van ouderraad',
		'not_found' 			=>	'Geen bericht van ouderraad gevonden',
		'not_found_in_trash'	=>	'Geen bericht van ouderraad gevonden in de prullenbak',
		);
	$rewrite = array (
		'slug' 					=>	'ouderraad',
		'with_front' 			=>	true,
		'pages' 				=>	true,
		'feeds' 				=>	true,
		);
	$supports = array (
		'title',
		'editor',
		'author',
		'thumbnail',
		'excerpt',
		//'trackbacks',
		//'custom-fields',
		//'comments',
		//'revisions',
		//'page-attributes',
		//'post-formats',
		);
	$args = array (
		'label' 				=>	'ouderraad',
		'description' 			=>	'Berichten van de ouderraad.',
		'public' 				=>	true,
		'has_archive'			=>	true,
		'can_export'			=>	true,
		'exclude_from_search'	=>	false,
		'publicly_queryable'	=>	true,
		'show_ui'				=>	true,
		'show_in_menu'			=>	true,
		'show_in_nav_menus'		=>	true,
		'show_in_admin_bar'		=>	true,
		'menu_position'			=>	7,
		'menu_icon'				=>	'dashicons-groups',
		'map_meta_cap'			=>	true,
		'capability_type'		=>	'OR',
		'rewrite'				=>	$rewrite,
		'labels'				=>	$labels,
		'supports'				=>	$supports,
		);
	register_post_type( 'ouderraad', $args );

	// create the custom-post-type "ouderpraat"
	$labels = array(
		'name'					=>	'Ouderpraat',
		'singular_name'			=>	'Ouderpraat',
		'menu_name'				=>	'Ouderpraat',
		'all_items'				=>	'Alle ouderpraat artikelen',
		'view_item' 			=>	'Bekijk ouderpraat artikel',
		'add_new' 				=>	'artikel toevoegen',
		'add_new_item' 			=>	'Nieuw ouderpraat artikel',
		'edit_item' 			=>	'Wijzig ouderpraat artikel',
		'update_item' 			=>	'Ouderpraat artikel bijwerken',
		'search_items' 			=>	'Zoek ouderpraat artikel',
		'not_found' 			=>	'Geen ouderpraat artikelen gevonden',
		'not_found_in_trash'	=>	'Geen ouderpraat artikelen gevonden in de prullenbak',
		);
	$rewrite = array (
		'slug' 					=>	'ouderpraat',
		'with_front' 			=>	true,
		'pages' 				=>	true,
		'feeds' 				=>	true,
		);
	$supports = array (
		'title',
		'editor',
		'author',
		'thumbnail',
		'excerpt',
		//'trackbacks',
		//'custom-fields',
		//'comments',
		//'revisions',
		//'page-attributes',
		//'post-formats',
		);
	$args = array (
		'label' 				=>	'ouderpraat',
		'description' 			=>	'Ouderpraat artikelen',
		'public' 				=>	true,
		'has_archive'			=>	true,
		'can_export'			=>	true,
		'exclude_from_search'	=>	false,
		'publicly_queryable'	=>	true,
		'show_ui'				=>	true,
		'show_in_menu'			=>	true,
		'show_in_nav_menus'		=>	true,
		'show_in_admin_bar'		=>	true,
		'menu_position'			=>	8,
		'menu_icon'				=>	'dashicons-format-chat',
		'map_meta_cap'			=>	true,
		'capability_type'		=>	'ouderpraat',
		'rewrite'				=>	$rewrite,
		'labels'				=>	$labels,
		'supports'				=>	$supports,
		);
	register_post_type( 'ouderpraat', $args );


}
add_action( 'init', 'eskeemo_custom_post_type', 0 );



/**************************************************/
/****** CUSTOMIZE MEDEWERKERS OVERVIEW TABLE ******/
/**************************************************/

// Change the columns for the "medewerkers" overview table
function eskeemo_change_team_columns( $cols ) {
	$cols = array(
		'cb'		=> '<input type="checkbox" />',
		'thumbs'	=> 'Foto',
		'firstname'	=> 'Voornaam',
		'lastname'	=> 'Achternaam',
		'email'		=> 'E-mailadres',
		'role'		=> 'Functie',
		'date'		=> 'Datum',
	);
	return $cols;
}
add_filter( "manage_edit-medewerkers_columns", "eskeemo_change_team_columns" );

// Fill the "medewerkers" overview table with content
function eskeemo_custom_team_columns( $column, $post_id ) {
	switch ( $column ) {
		case "thumbs":
			echo the_post_thumbnail( 'admin-thumb' );
		break;
		case "firstname":
			$firstname = get_post_meta( $post_id, 'firstname', true);
			echo '<a href="post.php?post=' . $post_id . '&action=edit">' . $firstname. '</a>';
			break;
		case "lastname":
			$lastname = get_post_meta( $post_id, 'lastname', true);
			echo $lastname;
			break;
		case "email":
			$email = get_post_meta( $post_id, 'email', true);
			echo $email;
			break;
		// role is entered through checkboxes, so we have to collect array data
		case "role":
			$role = get_post_meta( $post_id, 'role', true);
			echo implode ($role, ', ');
			break;
	}
}
add_action( "manage_medewerkers_posts_custom_column", "eskeemo_custom_team_columns", 10, 2 );

// Change the default width of the new custom columns
function eskeemo_admin_column_width() {
    echo '<style type="text/css">
        .column-thumbs { text-align: left; width:8% !important; overflow:hidden }
        .column-firstname { text-align: left; width:11% !important; overflow:hidden }
        .column-lastname { text-align: left; width:11% !important; overflow:hidden }
        .column-email { text-align: left; width:25% !important; overflow:hidden }
        .column-role { text-align: left; width:15% !important; overflow:hidden }
        .column-date { text-align: left; width:15% !important; overflow:hidden }
    	</style>';
}
add_action('admin_head', 'eskeemo_admin_column_width');



/**************************************************/
/************ CREATE CUSTOM TAXONOMIES ************/
/**************************************************/

function eskeemo_custom_taxonomy() {
}
