<?php
class API_Guard_REST {

    /**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $API_Guard    The string used to uniquely identify this plugin.
	 */
	protected $API_Guard;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

    protected $loader;

    protected $admin_menu;

    private const auth_load_menu = 'activate_plugins';

	private const auth_change_options = 'manage_options';


    public function __construct( $API_Guard, $version, $loader, $admin_menu ) {

        $this->API_Guard = $API_Guard;
		$this->version = $version;
        $this->loader = $loader;
        $this->admin_menu = $admin_menu;

        $this-> register_hooks();

    }

    /**
	 * Register all of the hooks that defines this module's functionality
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function register_hooks() {

		$this->loader->add_filter( 'rest_authentication_errors', $this, 'block_public_rest_requests' );
        $this->loader->add_action( 'admin_menu', $this, 'load_admin_menu' );
        
	}

    /**
     * Blocks all requests of the JSON REST API, unless the caller is logged in, then do nothing
     * 
     * @since    1.0.0
     * @param    array      $result         REST authentication object
     */
    public function block_public_rest_requests( $result ) {

        // Return an error if user is not logged in.
        if ( ! is_user_logged_in() ) {
            
            $code = 'rest_not_logged_in';
            $message = __( 'You are not currently logged in.' );
            $data = array( 'status' => 401 );
            
            return new WP_Error( $code, $message, $data );
        }

        return $result;
    }

    public function load_admin_menu() {
        
        // REST API settings page
		add_submenu_page(
			$this->admin_menu,                  // Parent slug-name
			__('REST-API Settings', $API_Guard),   // Browser Title Tag
			__('REST-API Settings', $API_Guard),          // Menu Title Display
			self::auth_load_menu,               // User capabilities required to access this menu
			'rest-api-settings',                // Unique slug-name to refer to this menu
			array($this, 'get_admin_settings_page')       // Callback for loading page
		);
    }

    public function get_admin_settings_page() {

        if ( ! current_user_can( self::auth_change_options ) ) {
			wp_die( 'Admin permissions required to change settings.', 403 );
		}

	    include( plugin_dir_path(__FILE__) . '/admin/rest-admin-display.php' );
        
    }

	public static function pretty_name() { return "REST-API Security"; }

	public static function description() {

		return "Control access over your REST-API endpoints for anonymous and logged-in users alike. Set granular access policies 
		for each user role, service and plugin.";

	}

	public static function activation() {}

	public static function deactivation() {}
	
}