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
if( ! class_exists( 'AcrossWP_Register_Blocks' ) ) {
	/**
	 * Fired during plugin licences.
	 *
	 * This class defines all code necessary to run during the plugin's licences and update.
	 *
	 * @since      0.0.1
	 * @package    AcrossWP_Register_Blocks
	 * @subpackage AcrossWP_Register_Blocks/includes
	 * @author     AcrossWP <contact@acrosswp.com>
	 */
	class AcrossWP_Register_Blocks {

		/**
		 * The single instance of the class.
		 *
		 * @var AcrossWP_Register_Blocks
		 * @since 0.0.1
		 */
		protected static $_instance = null;

		/**
		 * Initialize the collections used to maintain the actions and filters.
		 *
		 * @since    0.0.1
		 */
		public function __construct() {

            add_action( 'init', array( $this, 'register_blocks' ) );
		}

		/**
		 * Main AcrossWP_Register_Blocks Instance.
		 *
		 * Ensures only one instance of WooCommerce is loaded or can be loaded.
		 *
		 * @since 0.0.1
		 * @static
		 * @see AcrossWP_Register_Blocks()
		 * @return AcrossWP_Register_Blocks - Main instance.
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * Adds the plugin license page to the admin menu.
		 *
		 * @return void
		 */
		function register_blocks() {

			$blocks_dir = $this->get_block_path();

			$block_directories = glob( $blocks_dir . "/*", GLOB_ONLYDIR );
			foreach ( $block_directories as $block) {
				register_block_type( $block );
			}
		}

		/**
		 * Get the vendor path of composer
		 * 
		 * @return string Path of the vendor dir
		 */
		function get_vendor_path() {
			return \SzepeViktor\Composer\PackagePath::getVendorPath();	
		}

		/**
		 * Get the plugin path
		 * 
		 * @return string Path of the plugins
		 */
		function get_plugin_path() {
			return dirname( $this->get_vendor_path() );
		}

		/**
		 * Get the plugin path
		 * 
		 * @return string Path of the plugins
		 */
		function get_block_path() {
			return $this->get_plugin_path() . '/build';
		}
	}

	AcrossWP_Register_Blocks::instance();
}