<?php

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
	 * @since    0.1.0
	 * @access   protected
	 * @var      string    $API_Guard    The string used to uniquely identify this plugin.
	 */
	protected $API_Guard;

	protected $version;

	protected const registered_modules = [ 
		API_Guard_REST::class => './modules/rest-api/class-api-guard-rest.php'
	];

	protected $admin;

	public function __construct($name, $version) {
		
		$this->API_Guard = $name;
		$this->version = $version;
	
		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->load_active_modules();

	}

	private function load_active_modules() {

		$active_modules = $this->get_active_modules();

		foreach ( $active_modules as $name => $path) {

			new $name(
				$this->API_Guard,
				$this->version,
				$this->loader,
			);
		}
	}

	private function load_dependencies() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-api-guard-loader.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-api-guard-admin.php';
		foreach ( self::registered_modules as $path ) { require_once( plugin_dir_path( __FILE__ ) . $path  ); }

		$this->loader = new API_Guard_Loader();

	}

	private function define_admin_hooks() {

		$this->admin = new API_Guard_Admin( 
			$this->get_API_Guard(), 
			$this->get_version(),
			$this->get_registered_modules()
		);

		$this->loader->add_action( 'admin_menu', $this->admin, 'define_admin_link' );
		$this->loader->add_action( 'admin_enqueue_scripts', $this->admin, 'define_admin_style' );

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

	public function run() {
		$this->loader->run();
	}

	public function get_API_Guard() {
		return $this->API_Guard;
	}

	public function get_loader() {
		return $this->loader;
	}

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

			require_once( plugin_dir_path( __FILE__ ) . $mod_path  );
			
			$mod_name::activation();

		}
	}

	public static function deactivation() {

		// Remove module dependencies
		foreach ( self::registered_modules as $mod_name => $mod_path ) {
			
			require_once( plugin_dir_path( __FILE__ ) . $mod_path  );

			$mod_name::deactivation();

		}

		// Remove own dependencies
		delete_option( API_Guard_Constants::PLUGIN_MAIN_OPTIONS );
	}

}
