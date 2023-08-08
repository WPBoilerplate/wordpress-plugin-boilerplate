<?php
/**
 * BuddyBoss Compatibility Integration Class.
 *
 * @since BuddyBoss 1.1.5
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Fired during plugin licences.
 *
 * This class defines all code necessary to run during the plugin's licences and update.
 *
 * @since      1.0.0
 * @package    AcrossWP_Main_Menu
 * @subpackage AcrossWP_Main_Menu/includes
 * @author     AcrossWP <contact@acrosswp.com>
 */
class AcrossWP_Main_Menu {

    /**
	 * The single instance of the class.
	 *
	 * @var AcrossWP_Main_Menu
	 * @since 1.0.0
	 */
	protected static $_instance = null;

	/**
	 * Initialize the collections used to maintain the actions and filters.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

        $this->define( 'ACROSSWP_MAIN_MENU', 'acrosswp' );

		/**
		 * Add the parent menu into the Admin Dashboard
		 */
		add_action( 'admin_menu', array( $this, 'main_menu' ) );
	}

	/**
	 * Main Wordpress_Plugin_Boilerplate_Loader Instance.
	 *
	 * Ensures only one instance of WooCommerce is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see Wordpress_Plugin_Boilerplate_Loader()
	 * @return Wordpress_Plugin_Boilerplate_Loader - Main instance.
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
    function main_menu() {
        add_menu_page(
            __( 'AcrossWP', 'wordpress-plugin-boilerplate' ),
            __( 'AcrossWP', 'wordpress-plugin-boilerplate' ),
            'manage_options',
            ACROSSWP_MAIN_MENU,
            array( $this, 'about_acrosswp' )
        );
    }

	public function about_acrosswp() {
		echo "show text about about_acrosswp";
	}

    /**
	 * Define constant if not already set
	 * @param  string $name
	 * @param  string|bool $value
	 */
	private function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}
}
