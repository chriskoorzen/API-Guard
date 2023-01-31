<?php
/**
 * The plugin bootstrap file
 *
 * @link              https://github.com/chriskoorzen/API-Guard
 * @since             0.1.0
 * @package           API_Guard
 *
 * @wordpress-plugin
 * Plugin Name:       API Guard Community Edition
 * Plugin URI:        https://github.com/chriskoorzen/API-Guard
 * Description:       Manage REST API Security
 * Version:           0.1.0
 * Author:            Chris Koorzen
 * Author URI:        chriskoorzen.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) die;

/**
 * Load constants used throughout program
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-api-guard-constants.php';

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-api-guard.php';

/**
 * Plugin Base Directory
 */
define( 'API_GUARD_BASE_DIR', __DIR__ );

/**
 * Plugin activation.
 */
function activate_API_Guard() { API_Guard::activation(); }

/**
 * Plugin deactivation.
 */
function deactivate_API_Guard() { API_Guard::deactivation(); }

register_activation_hook( __FILE__, 'activate_API_Guard' );
register_deactivation_hook( __FILE__, 'deactivate_API_Guard' );


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.1.0
 */
function run_API_Guard() {

	$plugin = new API_Guard( API_Guard_Constants::PLUGIN_NAME, API_Guard_Constants::PLUGIN_VERSION );
	$plugin->run();

}

run_API_Guard();
