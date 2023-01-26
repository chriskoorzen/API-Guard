<?php

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

    api_guard_menu_css();

    // HTML
    echo '
    <div class="api_guard page_body">
        <h1 class="api_guard">API Guard Dashboard</h1>
        <div class="api_guard sub_menu">
            <h2 class="api_guard sub_menu">Quick Settings</h2>
            <form class="api_guard">
                <div class="api_guard menu_item">
                    <div class="api_guard boolean_option">
                        <input class="api_guard" type="checkbox" id="disable_public_rest" name="disable_public_rest">
                        <label class="api_guard" for="disable_public_rest">Disable Public REST API access</label>
                    </div>
                    <p class="api_guard menu_item_description">Prevents unauthorized anonymous access to your public API in case an attacker or malicious actor scrapes the content of your site for their own gain and use against your wishes</p>
                </div>
                <div class="api_guard menu_item">
                    <div class="api_guard boolean_option">
                        <input class="api_guard" type="checkbox" id="disable_public_xmlrpc" name="disable_public_xmlrpc">
                        <label class="api_guard" for="disable_public_xmlrpc">Disable Public XML-RPC access</label>
                    </div>
                    <p class="api_guard menu_item_description">Setting Description and setting <a href="">info</a></p>
                </div>
                <input class="api_guard confirm_button" type="submit" value="Save Changes">
            </form>
        </div>
    </div>';
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
