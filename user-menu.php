<?php

define('API_GUARD_DIR', dirname(API_GUARD_FILE));


add_action('admin_menu', 'api_guard_admin_menu');

function api_guard_admin_menu(){
    // Main Page
    add_menu_page(
        __('API Guard Dashboard'),          // Browser Title Tag
        __('API Guard Control HQ'),         // Menu Title Display
        'activate_plugins',                 // User capabilities required to access this menu
        'api-guard-main-menu',              // Unique slug-name to refer to this menu
        'api_guard_load_admin_dashboard'    // Callback for loading page
    );
    
    // Credit and Info page
    add_submenu_page(
        'api-guard-main-menu',              // Parent slug-name
        __('API Guard Info'),               // Browser Title Tag
        __('Credits'),                      // Menu Title Display
        'activate_plugins',                 // User capabilities required to access this menu
        'api-guard-credits',                // Unique slug-name to refer to this menu
        'api_guard_load_credits_page'       // Callback for loading page
    );
}

// API Guard Admin Control Page
function api_guard_load_admin_dashboard(){
	
    // Do not load anything if user is not authorized
	if( ! current_user_can('manage_options') ){
		wp_die( 'Admin permissions required to change settings.' );
	}
}

// API Guard Credits Page
function api_guard_load_credits_page(){
	 
	// Do not load anything if user is not authorized
	if( ! current_user_can('manage_options') ){
		wp_die( 'Admin permissions required to change settings.' );
	}

	// FIXME Make sure post was from this page
	// if(count($_POST) > 0){
	// 	check_admin_referer();
	// }
}
