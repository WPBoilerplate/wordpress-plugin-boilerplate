<?php
/**
 * BuddyBoss Compatibility Integration Class.
 *
 * @since BuddyBoss 1.1.5
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Setup the bp compatibility class.
 *
 * @since BuddyBoss 1.1.5
 */
class Wordpress_Plugin_Boilerplate_BuddyBoss_Integration extends BP_Integration {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	public function __construct( $plugin_name ) {

		$this->plugin_name = $plugin_name;

		$this->start(
			$this->plugin_name,
			__( 'Add-on', 'buddyboss-platform-addon' ),
			$this->plugin_name,
			array(
				'required_plugin' => array(),
			)
		);
	}

	/**
	 * Register admin integration tab
	 */
	public function setup_admin_integration_tab() {

		/**
		 * The class responsible for loading the dependency main class
		 * core plugin.
		 */
		require_once WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_PATH . 'admin/integration/buddyboss-addon-integration-tab.php';

		var_dump( WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_PATH . 'admin/integration/buddyboss-addon-integration-tab.php' );

		new Wordpress_Plugin_Boilerplate_Admin_Integration_Tab(
			"bp-{$this->plugin_name}",
			$this->plugin_name,
			array(
				'root_path'       => WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_PATH . 'admin/integration',
				'root_url'        => WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_URL . 'admin/integration',
				'required_plugin' => $this->required_plugin,
			)
		);
	}
}
