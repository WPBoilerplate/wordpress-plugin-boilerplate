<?php
/**
 * Instantiates the WordPress Plugin Boilerplate plugin
 *
 * @package WordPress_Plugin_Boilerplate
 */

namespace WordPress_Plugin_Boilerplate;

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/WPBoilerplate/wordpress-plugin-boilerplate
 * @since             0.0.1
 * @package           WordPress_Plugin_Boilerplate
 *
 * @wordpress-plugin
 * Plugin Name:       WordPress Plugin Boilerplate
 * Plugin URI:        https://github.com/WPBoilerplate/wordpress-plugin-boilerplate
 * Description:       WordPress Plugin Boilerplate by WPBoilerplate
 * Version:           0.0.1
 * Requires at least: 6.9
 * Requires PHP:	  8.0
 * Author:            WPBoilerplate
 * Author URI:        https://github.com/WPBoilerplate/wordpress-plugin-boilerplate
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wordpress-plugin-boilerplate
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 0.0.1 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_FILE', __FILE__ );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/activator.php
 */
function wordpress_plugin_boilerplate_activate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/Activator.php';
	Includes\Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/deactivator.php
 */
function wordpress_plugin_boilerplate_deactivate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/Deactivator.php';
	Includes\Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'WordPress_Plugin_Boilerplate\wordpress_plugin_boilerplate_activate' );
register_deactivation_hook( __FILE__, 'WordPress_Plugin_Boilerplate\wordpress_plugin_boilerplate_deactivate' );

require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload_packages.php';

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/Main.php';

use WordPress_Plugin_Boilerplate\Includes\Main;

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.0.1
 */
function wordpress_plugin_boilerplate_run() {

	$plugin = Main::instance();

	/**
	 * Run this plugin on the plugins_loaded functions
	 */
	add_action( 'plugins_loaded', array( $plugin, 'run' ), 0 );
}
wordpress_plugin_boilerplate_run();
