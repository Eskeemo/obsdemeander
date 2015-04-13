<?php
/*
 * Plugin Name: Eskeemo's Wordpress Customizations
 * Description: A single plugin to handle most of the wordpress customizations for the OBS-De-Meander website, such as some dashboard widget adjustments and additional dashicons.
 * Version: 1.0
 * Author: Emiel Nawijn
 * Author URI: http://www.eskeemo.com
 * License: GPL3
 */



/**************************************************/
/********** GENERAL ADMIN CUSTOMIZATIONS **********/
/**************************************************/

// remove widgets for any role besides "administrator"
function eskeemo_remove_dashboard_widgets() {
	$user = wp_get_current_user();
	if ( ! $user->has_cap( 'manage_options' ) ) {
		remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );
	}
}
add_action( 'wp_dashboard_setup', 'eskeemo_remove_dashboard_widgets' );

// customize the admin footer text
 function eskeemo_edit_admin_footer () {
	echo '&copy; 2014 Eskeemo. Developed by <a href="http://www.eskeemo.com" target="_blank">Emiel Nawijn</a>.';
}
add_filter('admin_footer_text', 'eskeemo_edit_admin_footer');

// add specific thumbnail-size for use in admin screens
add_image_size('admin-thumb', 50, 50, false);

//re-anable the old wordpress link-manager
add_filter( 'pre_option_link_manager_enabled', '__return_true' );

//add ability to use shortcodes in the sidebar
add_filter('widget_text', 'do_shortcode');

// hide sub-statusses and zero-count items of the "Glance That" plugin
define( GT_SHOW_ALL_STATUS, FALSE );
define( GT_SHOW_ZERO_COUNT, TRUE );

// add page exerpts to the cms ui
// see also (http://www.wpbeginner.com/plugins/add-excerpts-to-your-pages-in-wordpress/)
add_post_type_support( 'page', 'excerpt' );



/**************************************************/
/**** ADD CUSTOM ACTIVITY WIDGET TO DASHBOARD *****/
/**************************************************/

// unregister the default activity widget
function remove_dashboard_widgets() {
	global $wp_meta_boxes;
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
}
add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );

// register your custom activity widget
function add_custom_dashboard_activity() {
	wp_add_dashboard_widget('custom_dashboard_activity', 'Activiteit', 'custom_wp_dashboard_site_activity');
}
add_action('wp_dashboard_setup', 'add_custom_dashboard_activity' );

function custom_wp_dashboard_site_activity() {
	echo '<div id="activity-widget">';
	$future_posts = wp_dashboard_recent_posts( array(
		'display' => 2,
		'max'     => 5,
		'status'  => 'future',
		'order'   => 'ASC',
		'title'   => __( 'Publishing Soon' ),
		'id'      => 'future-posts',
	) );
	$recent_posts = wp_dashboard_recent_posts( array(
		'display' => 2,
		'max'     => 5,
		'status'  => 'publish',
		'order'   => 'DESC',
		'title'   => __( 'Recently Published' ),
		'id'      => 'published-posts',
	) );
	$recent_comments = wp_dashboard_recent_comments( 10 );
	if ( !$future_posts && !$recent_posts && !$recent_comments ) {
		echo '<div class="no-activity">';
		echo '<p class="smiley"></p>';
		echo '<p>' . __( 'No activity yet!' ) . '</p>';
		echo '</div>';
	}
	echo '</div>';
}