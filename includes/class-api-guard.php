<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    API_Guard
 * @subpackage API_Guard/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    API_Guard
 * @subpackage API_Guard/includes
 * @author     Your Name <email@example.com>
 */
class API_Guard {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      API_Guard_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

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

	/**
	 * 
	 * 
	 */
	protected const registered_modules = [ 
		API_Guard_REST::class => './modules/rest-api/class-api-guard-rest.php',
		API_Guard_XMLRPC::class => './modules/xml-rpc/class-api-guard-xmlrpc.php',
	];


	/** */
	protected $admin;


	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct($name, $version) {
		
		$this->API_Guard = $name;
		$this->version = $version;

		// $this->registered_modules = [ 
		// 	API_Guard_REST::class => plugin_dir_path(dirname( __FILE__ )) . 'includes/modules/rest-api/class-api-guard-rest.php',
		// 	API_Guard_XMLRPC::class => plugin_dir_path(dirname( __FILE__ )) . 'includes/modules/xml-rpc/class-api-guard-xmlrpc.php',
		// ];
	
		
		$this->load_dependencies();
		// $this->set_locale();
		$this->define_admin_hooks();
		// $this->define_public_hooks();
		$this->load_active_modules();

	}

	private function load_active_modules() {

		$active_modules = $this->get_active_modules();

		foreach ( $active_modules as $name => $path) {

			new $name(
				$this->API_Guard,
				$this->version,
				$this->loader,
				$this->admin::menu_name,
			);
		}
	}


	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - API_Guard_Loader. Orchestrates the hooks of the plugin.
	 * - API_Guard_i18n. Defines internationalization functionality.
	 * - API_Guard_Admin. Defines all hooks for the admin area.
	 * - API_Guard_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-api-guard-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		// require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-api-guard-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-api-guard-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		// require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-api-guard-public.php';
		
		foreach ( self::registered_modules as $path ) { require( plugin_dir_path( __FILE__ ) . $path  ); }


		$this->loader = new API_Guard_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the API_Guard_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	// private function set_locale() {

	// 	$plugin_i18n = new API_Guard_i18n();

	// 	$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	// }

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$this->admin = new API_Guard_Admin( 
			$this->get_API_Guard(), 
			$this->get_version(),
			$this->get_registered_modules()
		);

		$this->loader->add_action( 'admin_menu', $this->admin, 'define_admin_link' );
		$this->loader->add_action( 'admin_enqueue_scripts', $this->admin, 'define_admin_style' );
		// $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}


	private function get_active_modules () {

		// Retrieve admin module settings
		$module_settings = get_option(API_Guard_Constants::PLUGIN_MAIN_OPTIONS);
		

		// Filter out disabled modules
		$cb = function ( $module_name ) use ( $module_settings ) {
			

			return $module_settings[$module_name];   // boolean

		};

		$result = array_filter( self::registered_modules, $cb, ARRAY_FILTER_USE_KEY );

		return $result;

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_API_Guard() {
		return $this->API_Guard;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    API_Guard_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	private function get_registered_modules() {
		$fresh_array = self::registered_modules;
		return $fresh_array;
	}

	public static function activation() {

		// Setup own dependencies
		$default_enable = array_fill_keys( array_keys( self::registered_modules ) , true );
		add_option( API_Guard_Constants::PLUGIN_MAIN_OPTIONS, $default_enable );

		// Setup module dependencies
		foreach ( self::registered_modules as $mod_name => $mod_path ) {

			$mod_name::activation();

		}
	}

	public static function deactivation() {

		// Remove module dependencies
		foreach ( self::registered_modules as $mod_name => $mod_path ) {

			$mod_name::deactivation();

		}

		// Remove own dependencies
		delete_option( API_Guard_Constants::PLUGIN_MAIN_OPTIONS );
	}

}
