<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress or ClassicPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.upwork.com/freelancers/~01db8f676aa2d4d8de
 * @since             1.0.0
 * @package           Cwt_Integrations
 *
 * @wordpress-plugin
 * Plugin Name:       Car Wash Trade - Integration
 * Plugin URI:        https://www.anushka.pro/wpplugins/Cwt_Integrations
 * Description:       Plugin provides additional features to the cwt website
 * Version:           1.0.0
 * Author:            Anushka K R
 * Requires at least: 5.7
 * Requires PHP:      7.0
 * Tested up to:      7.0
 * Author URI:        https://www.anushka.pro/
 * License:           GPL-2.0+
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cwt-integrations
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Current plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CWTINT_VERSION', '1.0.0' );

/**
 * Define the Plugin basename
 */
define( 'CWTINT_BASE_NAME', plugin_basename( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 *
 * This action is documented in includes/class-cwt-integrations-activator.php
 * Full security checks are performed inside the class.
 */
function cwti_activate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cwt-integrations-activator.php';
	Cwt_Integrations_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 *
 * This action is documented in includes/class-cwt-integrations-deactivator.php
 * Full security checks are performed inside the class.
 */
function cwti_deactivate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cwt-integrations-deactivator.php';
	Cwt_Integrations_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'cwti_activate' );
register_deactivation_hook( __FILE__, 'cwti_deactivate' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-cwt-integrations.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * Generally you will want to hook this function, instead of callign it globally.
 * However since the purpose of your plugin is not known until you write it, we include the function globally.
 *
 * @since    1.0.0
 */
function cwti_run() {

	$plugin = new Cwt_Integrations();
	$plugin->run();

}
cwti_run();
