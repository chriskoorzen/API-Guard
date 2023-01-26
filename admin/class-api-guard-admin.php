<?php

class API_Guard_Admin {

	private const auth_load_menu = 'activate_plugins';
	private const auth_change_options = 'manage_options';

	private $API_Guard;

	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param      string    $API_Guard       The name of this plugin.
	 * @param      string    $version         The version of this plugin.
	 */
	public function __construct( $API_Guard, $version ) {

		$this->API_Guard = $API_Guard;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 */
	public function define_admin_style() {

		wp_enqueue_style( 
			$this->API_Guard, 
			plugin_dir_url( __FILE__ ) . 'css/api-guard-admin.css', 
			array(), $this->version, 
			'all' 
		);

	}

	/**
	 * Register the JavaScript for the admin area.
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( 
			$this->API_Guard, 
			plugin_dir_url( __FILE__ ) . 'js/api-guard-admin.js', 
			array( 'jquery' ), $this->version, 
			false 
		);

	}

	/**
	 * Register the HTML Markup for the admin area
	 */
	public function define_admin_link() {
	    
	    // Main Page
        add_menu_page(
            __('API Guard Dashboard', $API_Guard),
            __('API Guard Options', $API_Guard),
            self::auth_load_menu,
            'api-guard-main-menu',
            array(&$this, 'load_main_ui')
        );
		
		// Credit and Info page
		add_submenu_page(
			'api-guard-main-menu',              // Parent slug-name
			__('API Guard Info', $API_Guard),   // Browser Title Tag
			__('Credits', $API_Guard),          // Menu Title Display
			self::auth_load_menu,               // User capabilities required to access this menu
			'api-guard-credits',                // Unique slug-name to refer to this menu
			'api_guard_load_credits_page'       // Callback for loading page
		);
	}
	
	/**
	 * Load the HTML for the admin area when requested
	 */
	public function load_main_ui() {

		if ( ! current_user_can( self::auth_change_options ) ) {
			wp_die( 'Admin permissions required to change settings.', 403 );
		}

	    include( plugin_dir_path(__FILE__) . '/partials/api-guard-admin-display.php' );

	}

}
