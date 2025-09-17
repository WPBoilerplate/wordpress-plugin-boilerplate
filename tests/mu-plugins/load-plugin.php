<?php
/**
 * WordPress Plugin Boilerplate Test Environment MU Plugin.
 *
 * @package WordPress_Plugin_Boilerplate
 */

// Ensure our plugin is loaded for testing.
add_action(
	'plugins_loaded',
	function () {
		if ( ! function_exists( 'is_plugin_active' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		// Auto-activate our plugin in test environment.
		if ( ! is_plugin_active( 'wordpress-plugin-boilerplate/wordpress-plugin-boilerplate.php' ) ) {
			activate_plugin( 'wordpress-plugin-boilerplate/wordpress-plugin-boilerplate.php' );
		}
	}
);
