<?php
/**
 * PHPUnit bootstrap file for WordPress Plugin Boilerplate
 *
 * @package WordPress_Plugin_Boilerplate
 */

// Define WordPress constants for testing
define( 'ABSPATH', __DIR__ . '/../' );
define( 'WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_FILE', __DIR__ . '/../wordpress-plugin-boilerplate.php' );
define( 'WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_URL', 'http://localhost/wp-content/plugins/wordpress-plugin-boilerplate/' );

// Mock WordPress functions that are commonly used
if ( ! function_exists( 'wp_enqueue_script' ) ) {
	/**
	 * Mock wp_enqueue_script for testing
	 *
	 * @param string $handle Script handle.
	 * @param string $src Script source.
	 * @param array  $deps Dependencies.
	 * @param string $ver Version.
	 * @param bool   $in_footer In footer.
	 */
	function wp_enqueue_script( $handle, $src = '', $deps = array(), $ver = false, $in_footer = false ) {
		// Mock implementation
	}
}

if ( ! function_exists( 'wp_enqueue_style' ) ) {
	/**
	 * Mock wp_enqueue_style for testing
	 *
	 * @param string $handle Style handle.
	 * @param string $src Style source.
	 * @param array  $deps Dependencies.
	 * @param string $ver Version.
	 * @param string $media Media.
	 */
	function wp_enqueue_style( $handle, $src = '', $deps = array(), $ver = false, $media = 'all' ) {
		// Mock implementation
	}
}

if ( ! function_exists( 'plugin_dir_url' ) ) {
	/**
	 * Mock plugin_dir_url for testing
	 *
	 * @param string $file Plugin file.
	 * @return string
	 */
	function plugin_dir_url( $file ) {
		return 'http://localhost/wp-content/plugins/wordpress-plugin-boilerplate/';
	}
}

if ( ! function_exists( 'plugin_dir_path' ) ) {
	/**
	 * Mock plugin_dir_path for testing
	 *
	 * @param string $file Plugin file.
	 * @return string
	 */
	function plugin_dir_path( $file ) {
		return __DIR__ . '/../';
	}
}

if ( ! function_exists( 'add_action' ) ) {
	/**
	 * Mock add_action for testing
	 *
	 * @param string   $hook Hook name.
	 * @param callable $callback Callback.
	 * @param int      $priority Priority.
	 * @param int      $accepted_args Accepted args.
	 */
	function add_action( $hook, $callback, $priority = 10, $accepted_args = 1 ) {
		// Mock implementation
	}
}

if ( ! function_exists( 'add_filter' ) ) {
	/**
	 * Mock add_filter for testing
	 *
	 * @param string   $hook Hook name.
	 * @param callable $callback Callback.
	 * @param int      $priority Priority.
	 * @param int      $accepted_args Accepted args.
	 */
	function add_filter( $hook, $callback, $priority = 10, $accepted_args = 1 ) {
		// Mock implementation
	}
}

if ( ! function_exists( 'apply_filters' ) ) {
	/**
	 * Mock apply_filters for testing
	 *
	 * @param string $hook Hook name.
	 * @param mixed  $value Value to filter.
	 * @param mixed  ...$args Additional arguments.
	 * @return mixed
	 */
	function apply_filters( $hook, $value, ...$args ) {
		return $value;
	}
}

if ( ! function_exists( 'load_plugin_textdomain' ) ) {
	/**
	 * Mock load_plugin_textdomain for testing
	 *
	 * @param string $domain Text domain.
	 * @param string $deprecated Deprecated.
	 * @param string $plugin_rel_path Plugin relative path.
	 * @return bool
	 */
	function load_plugin_textdomain( $domain, $deprecated, $plugin_rel_path ) {
		return true;
	}
}

if ( ! function_exists( 'plugin_basename' ) ) {
	/**
	 * Mock plugin_basename for testing
	 *
	 * @param string $file Plugin file.
	 * @return string
	 */
	function plugin_basename( $file ) {
		return basename( dirname( $file ) ) . '/' . basename( $file );
	}
}

if ( ! function_exists( 'get_plugin_data' ) ) {
	/**
	 * Mock get_plugin_data for testing
	 *
	 * @param string $plugin_file Plugin file.
	 * @param bool   $markup Markup.
	 * @param bool   $translate Translate.
	 * @return array
	 */
	function get_plugin_data( $plugin_file, $markup = true, $translate = true ) {
		return array(
			'Name'        => 'WordPress Plugin Boilerplate',
			'Version'     => '1.0.0',
			'Description' => 'A standardized, organized foundation for building high-quality WordPress Plugins.',
			'Author'      => 'WPBoilerplate',
			'AuthorURI'   => 'https://github.com/WPBoilerplate/wordpress-plugin-boilerplate',
			'PluginURI'   => 'https://github.com/WPBoilerplate/wordpress-plugin-boilerplate',
			'TextDomain'  => 'wordpress-plugin-boilerplate',
			'DomainPath'  => '/languages/',
			'Network'     => false,
			'RequiresWP'  => '5.0',
			'RequiresPHP' => '7.4',
		);
	}
}

if ( ! function_exists( 'is_admin' ) ) {
	/**
	 * Mock is_admin for testing
	 *
	 * @return bool
	 */
	function is_admin() {
		return false;
	}
}

if ( ! function_exists( 'untrailingslashit' ) ) {
	/**
	 * Mock untrailingslashit for testing
	 *
	 * @param string $string String to remove trailing slash from.
	 * @return string
	 */
	function untrailingslashit( $string ) {
		return rtrim( $string, '/\\' );
	}
}

// Load composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Load plugin main file for classes
require_once __DIR__ . '/../includes/main.php';
require_once __DIR__ . '/../includes/loader.php';
require_once __DIR__ . '/../includes/i18n.php';
require_once __DIR__ . '/../includes/activator.php';
require_once __DIR__ . '/../includes/deactivator.php';
require_once __DIR__ . '/../admin/Main.php';
require_once __DIR__ . '/../public/Main.php';
