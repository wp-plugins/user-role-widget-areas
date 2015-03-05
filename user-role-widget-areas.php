<?php

/*
Plugin Name: User Role Widget Area
Description: This plugin allows you to selectively display content in your themes active widget areas based on the user roles (Administrator, Editor, Author, Contributor or Subscriber) of logged in users. It also comes with two user status based widget areas for displaying content to all logged in users or all logged out users. All user role and status based widget areas can be displayed in any existing sidebar or widget area within your theme.
Version: 1.1
Requires at least: 3.9
Tested up to: 4.1
Stable Tag: 1.0
Author: Rob Smelik
Author URI: http://www.robsmelik.com
License: GPLv2
Copyright: Rob Smelik
*/
 
// SECURITY: This line exists for security reasons to keep things locked down.
 
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


// DOCUMENTATION / USAGE MENU: This adds a link to the URWA Documentation and Usage page

function set_plugin_meta($links, $file) {
	
	$plugin = plugin_basename(__FILE__);

	// create link
	if ($file == $plugin) {
		return array_merge(
			$links,
			array( sprintf( '<a href="options-general.php?page=urwa-documentation">Plugin Documentation</a>' )) ); }
	return $links; }

add_filter( 'plugin_row_meta', 'set_plugin_meta', 10, 2 );


// DOCUMENTATION PAGE: Loads up the URWA Documentation page under the Settings menu

function urwa_plugin_menu() {
	add_options_page(__('URWA Documents', 'urwa-documentation'), __('URWA Documents', 'urwa-documentation'), 'manage_options', 'urwa-documentation', 'documentationContent'); }
	
add_action('admin_menu', 'urwa_plugin_menu');

function documentationContent() {
	?>
    
		<!-- Top Summary Content pulled from includes/documentation/docs-summary.php -->
		<?php include( plugin_dir_path( __FILE__ ) . 'includes/documentation/intro.php'); ?>
        
		<!-- Load up the Tabs pulled from includes/documentation/docs-tabs.php --> 
		<?php include( plugin_dir_path( __FILE__ ) . 'includes/documentation/tabs.php'); ?>
        
		<!-- Tab 1 Content pulled from includes/documentation/docs-tutorial.php --> 
		<?php if($active_tab == 'tab_1') { ?> 
		<?php include( plugin_dir_path( __FILE__ ) . 'includes/documentation/tab-1-tutorial.php'); ?>
        
		<!-- Tab 2 Content pulled from includes/documentation/docs-additional-usage.php -->    
		<?php } if($active_tab == 'tab_2') { ?>
		<?php include( plugin_dir_path( __FILE__ ) . 'includes/documentation/tab-2-additional-usage.php'); ?>
        
		<!-- Tab 3 Content pulled from includes/documentation/docs-advanced-styling.php -->    
		<?php } if($active_tab == 'tab_3') { ?>	
		<?php include( plugin_dir_path( __FILE__ ) . 'includes/documentation/tab-3-advanced-styling.php'); ?>
        
		<!-- Tab 4 Content pulled from includes/documentation/docs-changelog.php -->    
		<?php } if($active_tab == 'tab_4') { ?>
		<?php include( plugin_dir_path( __FILE__ ) . 'includes/documentation/tab-4-changelog.php'); ?>
        
		<!-- Tab 5 Content pulled from includes/documentation/docs-support.php -->  
		<?php } if($active_tab == 'tab_5') { ?>
		<?php include( plugin_dir_path( __FILE__ ) . 'includes/documentation/tab-5-support.php'); ?>
           
		<?php } ?>
	</div>	

<?php
}


 
// REGISTER SIDEBARS (AKA Widget Areas)
 
function register_user_sidebar(){
	
		// Register Subscriber sidebar

		register_sidebar(array(
			'name' => 'Users - Subscribers',
			'id'   => 'urwa-subscriber-widgets',
			'description'   => __( 'Widgets placed here are only visible to Subscribers.' ),
			'before_widget' => '<div id="urwa-subscriber" class="widget">',
			'after_widget'  => '</div>',
			'before_title' => '<h3 class="widgettitle">', 
			'after_title' => '</h3>', 
		));
		
		// Register Contributor sidebar

		register_sidebar(array(
			'name' => 'Users - Contributors',
			'id'   => 'urwa-contributor-widgets',
			'description'   => __( 'Widgets placed here are only visible to Contributors.' ),
			'before_widget' => '<div id="urwa-contributor" class="widget">',
			'after_widget'  => '</div>',
			'before_title' => '<h3 class="widgettitle">', 
			'after_title' => '</h3>', 
		));
		
		// Register Author sidebar

		register_sidebar(array(
			'name' => 'Users - Authors',
			'id'   => 'urwa-author-widgets',
			'description'   => __( 'Widgets placed here are only visible to Authors.' ),
			'before_widget' => '<div id="urwa-author" class="widget">',
			'after_widget'  => '</div>',
			'before_title' => '<h3 class="widgettitle">', 
			'after_title' => '</h3>', 
		));
		
		// Register Editor sidebar

		register_sidebar(array(
			'name' => 'Users - Editors',
			'id'   => 'urwa-editor-widgets',
			'description'   => __( 'Widgets placed here are only visible to Editors.' ),
			'before_widget' => '<div id="urwa-editor" class="widget">',
			'after_widget'  => '</div>',
			'before_title' => '<h3 class="widgettitle">', 
			'after_title' => '</h3>', 
		));
		
		// Register Administrator sidebar 

		register_sidebar(array(
			'name' => 'Users - Administrators',
			'id'   => 'urwa-administrator-widgets',
			'description'   => __( 'Widgets placed here are only visible to Administrators.' ),
			'before_widget' => '<div id="urwa-administrator" class="widget">',
			'after_widget'  => '</div>',
			'before_title' => '<h3 class="widgettitle">', 
			'after_title' => '</h3>', 
		));
		
		// Register All Logged In sidebar

		register_sidebar(array(
			'name' => 'Users - Logged In',
			'id'   => 'urwa-logged-in-widgets',
			'description'   => __( 'Widgets placed here are visible to logged in users.' ),
			'before_widget' => '<div id="urwa-logged-in" class="widget">',
			'after_widget'  => '</div>',
			'before_title' => '<h3 class="widgettitle">', 
			'after_title' => '</h3>', 
		));
		
		// Register All Logged Out sidebar 

		register_sidebar(array(
			'name' => 'Users - Logged Out',
			'id'   => 'urwa-logged-out-widgets',
			'description'   => __( 'Widgets placed here are visible to logged out users.' ),
			'before_widget' => '<div id="urwa-logged-out" class="widget">',
			'after_widget'  => '</div>',
			'before_title' => '<h3 class="widgettitle">', 
			'after_title' => '</h3>', 
		));

}

add_action( 'widgets_init', 'register_user_sidebar' );


// REGISTER SHORTCODES

// Shortcode 1: Display sidebars based on Specific user roles

add_shortcode('user-role-widget-areas', 'shortcode_user_role_widget_areas');

// Creates the front-end display of the User Role Widget Areas
// This is where the magic happens

function shortcode_user_role_widget_areas() {
	if ( current_user_can( 'update_core' ) ) { //only admins and editors can see this
	echo ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Users - Administrators') ) ; } 
	elseif ( current_user_can( 'publish_pages' ) )  { //only editors an see this
	echo ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Users - Editors') ) ; } 
	elseif ( current_user_can( 'publish_posts' ) )  { //only authors an see this
	echo ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Users - Authors') ) ; } 
	elseif ( current_user_can( 'edit_posts' ) )  { //only contributors an see this
	echo ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Users - Contributors') ) ; } 
	elseif ( current_user_can( 'read' ) )  { //only subscribers an see this
	echo ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Users - Subscribers') ) ; } 
	else {  //returns no widget content if none of the contitions above are met
	echo ''; }	
    }	
		
add_filter('widget_text', 'do_shortcode');


// Shortcode 2: Display sidebars based on Logged In Users

add_shortcode('user-status-widget-areas', 'shortcode_user_status_widget_areas');

// Creates the front-end display of the User Status Widget Areas
// This is where the magic happens

function shortcode_user_status_widget_areas() {
	if ( is_user_logged_in() ) {
	echo ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Users - Logged In') ) ; } 
	else {
	echo ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Users - Logged Out') ) ; }
}
		
add_filter('widget_text', 'do_shortcode');


// REGISTER WIDGETS

// Widget 1: Display sidebars based on Specific user roles

class urwa_widget extends WP_Widget {
	
function __construct() {
parent::__construct(
// Base ID of the widget
'urwa_widget', 

// Widget name as it appears in the UI
__('URWA - Users by Role', 'urwa_widget_domain'), 

// Widget description
array( 'description' => __( 'Place in any existing NON-USER widget area where you want to display specific widgets based on user roles.', 'urwa_widget_domain' ), ) 
);
}

// Creates the front-end display of the User Role Widget Areas
// This is where the magic happens

public function widget(  ) {
	if ( current_user_can( 'update_core' ) ) { //only admins and editors can see this
	echo ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Users - Administrators') ) ; } 
	elseif ( current_user_can( 'publish_pages' ) )  { //only editors an see this
	echo ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Users - Editors') ) ; } 
	elseif ( current_user_can( 'publish_posts' ) )  { //only authors an see this
	echo ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Users - Authors') ) ; } 
	elseif ( current_user_can( 'edit_posts' ) )  { //only contributors an see this
	echo ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Users - Contributors') ) ; } 
	elseif ( current_user_can( 'read' ) )  { //only subscribers an see this
	echo ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Users - Subscribers') ) ; } 
	else {  //returns no widget content if none of the contitions above are met
	echo ''; }	
}
		
} // Class urwa_widget ends here

// Register and load the widget

function urwa_load_widget() {
	register_widget( 'urwa_widget' );
}
add_action( 'widgets_init', 'urwa_load_widget' );


// Widget 2: Display sidebars based on user logged in status 

class urwa_widget_logged_in extends WP_Widget {
	
function __construct() {
parent::__construct(
// Base ID of the widget
'urwa_widget_logged_in', 

// Widget name as it appears in the UI
__('URWA - All Logged In Users', 'urwa_widget_logged_in_domain'), 

// Widget description
array( 'description' => __( 'Place in any existing NON-USER widget area where you want to display specific widgets to ALL logged in users.', 'urwa_widget_logged_in_domain' ), ) 
);
}

// Creates the front-end display of the User Status Widget Areas
// This is where the magic happens

public function widget(  ) {
	if ( is_user_logged_in() ) {
	echo ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Users - Logged In') ) ; } 
	else {
	echo ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Users - Logged Out') ) ; }
}
		
} // Class urwa_widget_logged_in ends here

// Register and load the widget

function urwa_load_widget_logged_in() {
	register_widget( 'urwa_widget_logged_in' );
}
add_action( 'widgets_init', 'urwa_load_widget_logged_in' );





	









