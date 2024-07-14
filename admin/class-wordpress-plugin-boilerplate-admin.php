<?php
// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://acrosswp.com
 * @since      1.0.0
 *
 * @package    Wordpress_Plugin_Boilerplate
 * @subpackage Wordpress_Plugin_Boilerplate/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wordpress_Plugin_Boilerplate
 * @subpackage Wordpress_Plugin_Boilerplate/admin
 * @author     WPBoilerplate <contact@acrosswp.com>
 */
class Wordpress_Plugin_Boilerplate_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The js_asset_file of the backend
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $js_asset_file;

	/**
	 * The css_asset_file of the backend
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $css_asset_file;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->js_asset_file = include( WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_PATH . 'build/js/backend.asset.php' );
		$this->css_asset_file = include( WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_PATH . 'build/css/backend.asset.php' );
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wordpress_Plugin_Boilerplate_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wordpress_Plugin_Boilerplate_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_URL . 'build/css/backend.css', $this->css_asset_file['dependencies'], $this->css_asset_file['version'], 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wordpress_Plugin_Boilerplate_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wordpress_Plugin_Boilerplate_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_URL . 'build/js/backend.js', $this->js_asset_file['dependencies'], $this->js_asset_file['version'], false );

	}

	/**
	 * Add Settings link to plugins area.
	 *
	 * @since    1.0.0
	 *
	 * @param array  $links Links array in which we would prepend our link.
	 * @param string $file  Current plugin basename.
	 * @return array Processed links.
	 */
	public function modify_plugin_action_links( $links, $file ) {

		// Return normal links if not BuddyPress.
		if ( WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_BASENAME !== $file ) {
			return $links;
		}

		// Add a few links to the existing links array.
		return array_merge(
			$links,
			array(
				'settings'      => '<a href="' . esc_url( admin_url( 'admin.php?page=bp-settings' ) ) . '">' . esc_html__( 'Settings', 'wordpress-plugin-boilerplate' ) . '</a>',
				'about'         => '<a href="' . esc_url( admin_url( 'admin.php?page=acrosswp' ) ) . '">' . esc_html__( 'About', 'wordpress-plugin-boilerplate' ) . '</a>',
			)
		);
	}

}
