<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           API_Guard
 *
 * @wordpress-plugin
 * Plugin Name:       API Guard Community Edition
 * Plugin URI:        http://example.com/api-guard-uri/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Your Name or Your Company
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       api-guard
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) die;

/**
 * Current plugin version.
 */
define( 'API_GUARD_VERSION', '1.0.0' );

/**
 * Plugin Base Directory
 */
define( 'API_GUARD_BASE_DIR', __DIR__ );

/**
 * Plugin activation.
 * This action is documented in includes/class-api-guard-activator.php
 */
function activate_API_Guard() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-api-guard-activator.php';
	API_Guard_Activator::activate();
}

/**
 * Plugin deactivation.
 * This action is documented in includes/class-api-guard-deactivator.php
 */
function deactivate_API_Guard() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-api-guard-deactivator.php';
	API_Guard_Deactivator::deactivate();
}

// register_activation_hook( __FILE__, 'activate_API_Guard' );
// register_deactivation_hook( __FILE__, 'deactivate_API_Guard' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-api-guard.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_API_Guard() {

	$plugin = new API_Guard();
	$plugin->run();

}
run_API_Guard();
