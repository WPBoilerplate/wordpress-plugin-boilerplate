<?php
/**
 * BuddyBoss Compatibility Integration Class.
 *
 * @since BuddyBoss 1.1.5
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Check if the class does not exits then only allow the file to add
 */
if( ! class_exists( 'WPBoilerplate_Plugins_Info' ) ) {
	/**
	 * Fired during plugin licences.
	 *
	 * This class defines all code necessary to run during the plugin's licences and update.
	 *
	 * @since      0.0.1
	 * @package    WPBoilerplate_Plugins_Info
	 * @subpackage WPBoilerplate_Plugins_Info/includes
	 * @author     WPBoilerplate <contact@acrosswp.com>
	 */
	class WPBoilerplate_Plugins_Info {

		/**
		 * The single instance of the class.
		 *
		 * @var WPBoilerplate_Plugins_Info
		 * @since 0.0.1
		 */
		protected static $_instance = null;

		/**
		 * Main WPBoilerplate_Plugins_Info Instance.
		 *
		 * Ensures only one instance of WooCommerce is loaded or can be loaded.
		 *
		 * @since 0.0.1
		 * @static
		 * @see WPBoilerplate_Plugins_Info()
		 * @return WPBoilerplate_Plugins_Info - Main instance.
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * Get the vendor path of composer
		 * 
		 * @return string Path of the vendor dir
		 */
		public function get_vendor_path() {
			return \SzepeViktor\Composer\PackagePath::getVendorPath();	
		}

		/**
		 * Get the plugin path
		 * 
		 * @return string Path of the plugins
		 */
		public function get_plugin_path() {
			return dirname( $this->get_vendor_path() );
		}

		/**
		 * Get the plugin path
		 * 
		 * @return string Path of the plugins
		 */
		public function get_full_plugin_path() {
			return $this->get_plugin_path() . '/' . $this->get_plugin_file_name() . '.php';
		}

		/**
		 * Get the plugin path
		 * 
		 * @return string Path of the plugins
		 */
		public function get_plugin_file_name() {
			return basename( $this->get_plugin_path() );
		}

		/**
		 * Get the plugin path
		 * 
		 * @return string Path of the plugins
		 */
		public function get_block_path() {
			return $this->get_plugin_path() . '/build';
		}
	}

	WPBoilerplate_Plugins_Info::instance();
}