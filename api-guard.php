<?php
/**
 * Plugin Name
 *
 * @package           PluginPackage
 * @author            Your Name
 * @copyright         2019 Your Name or Company Name
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:           API Guard Community Edition
 * Plugin URI:            # The home page of the plugin, which should be a unique URL, preferably on your own website
 * Description:           # A short description of the plugin, as displayed in the Plugins section in the WordPress Admin. Keep this description to fewer than 140 characters.
 * Version:               # The current version number of the plugin, such as 1.0 or 1.0.3. 
 * Requires at least:     # The lowest WordPress version that the plugin will work on.
 * Requires PHP:          # The minimum required PHP version.
 * Author:                # The name of the plugin author. Multiple authors may be listed using commas.
 * Author URI:            # The author’s website or profile on another website, such as WordPress.org.
 * License:               # The short name (slug) of the plugin’s license (e.g. GPLv2). More information about licensing
 * License URI:           # A link to the full text of the license (e.g. https://www.gnu.org/licenses/gpl-2.0.html).
 * Text Domain:           # The gettext text domain of the plugin. More information can be found in the Text Domain section of the How to Internationalize your Plugin page
 * Domain Path:           # The domain path lets WordPress know where to find the translations. More information can be found in the Domain Path section of the How to Internationalize your Plugin page.
 * Network:               # Whether the plugin can only be activated network-wide. Can only be set to true, and should be left out when not needed.
 * Update URI:            # Allows third-party plugins to avoid accidentally being overwritten with an update of a plugin of a similar name from the WordPress.org Plugin Directory. For more info read related dev note.
*/

// namespace api_guard;

if (!defined('ABSPATH')) die();


$plugin_api_guard = plugin_basename(__FILE__);

define('API_GUARD_FILE', __FILE__);

include_once(dirname(__FILE__).'/user-menu.php');


add_filter( 'rest_authentication_errors', 'api_guard_block_public_rest_requests' );
    
function api_guard_block_public_rest_requests ($result){

    // Return an error if user is not logged in.
    if ( ! is_user_logged_in() ) {
        $code = 'rest_not_logged_in';
        $message = __( 'You are not currently logged in.' );
        $data = array( 'status' => 401 );
        return new WP_Error( $code, $message, $data );
    }

    return $result;

}

function api_guard_block_public_xml_rpc_requests ($result){
    // TODO XML_RPC blocking code
}
