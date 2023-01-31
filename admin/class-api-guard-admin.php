<?php

class API_Guard_Admin {

	private const auth_load_menu = 'activate_plugins';
	private const auth_change_options = 'manage_options';
	private const admin_form_nonce = 'APIG-admin-main-menu-nonce';

	const menu_name = 'api-guard-main-menu';

	private $API_Guard;

	private $version;

	private $registered_modules;

	public function __construct( $API_Guard, $version, $registered_modules ) {

		$this->API_Guard = $API_Guard;
		$this->version = $version;
		$this->registered_modules = $registered_modules;

	}

	public function define_admin_style() {

		wp_enqueue_style( 
			$this->API_Guard, 
			plugin_dir_url( __FILE__ ) . 'css/api-guard-admin.css', 
			array(), $this->version, 
			'all' 
		);

	}

	public function enqueue_scripts() {

		wp_enqueue_script( 
			$this->API_Guard, 
			plugin_dir_url( __FILE__ ) . 'js/api-guard-admin.js', 
			array( 'jquery' ), $this->version, 
			false 
		);

	}

	public function define_admin_link() {
	    
	    // Main Page
        add_menu_page(
            __('API Guard Dashboard', $API_Guard),
            __('API Guard Options', $API_Guard),
            self::auth_load_menu,
            self::menu_name,
            array($this, 'load_main_ui')
        );
		
	}

	public function load_main_ui() {

		if ( ! current_user_can( self::auth_change_options ) ) {
			wp_die( 'Admin permissions required to change settings.', 403 );
		}

		if ( $_SERVER["REQUEST_METHOD"] == 'POST' ) { 
			
			// Verify user intent and nonce
			if ( ! check_admin_referer( $this->admin_form_nonce ) ) {
				wp_die('Invalid Request Received', 403);
			}

			$this->process_form_data(); 
		
		}

	    include( plugin_dir_path(__FILE__) . '/partials/api-guard-admin-display.php' );

	}

	private function process_form_data() {
		
		$current_options = get_option(API_Guard_Constants::PLUGIN_MAIN_OPTIONS);

		// If an HTML checkbox is unchecked, it will not appear in the $_POST data. If checked, it will have the value 'on'
		foreach ( $current_options as $key => $value ) {

			if ( ! array_key_exists( $key, $_POST ) ) {
				$current_options[$key] = false;
				continue;
			}
			if ( $_POST[$key] == 'on' ) { $current_options[$key] = true; }
		
		}

		update_option(API_Guard_Constants::PLUGIN_MAIN_OPTIONS, $current_options);

	}
}
