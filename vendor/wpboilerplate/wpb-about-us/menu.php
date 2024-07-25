<?php
/**
 * WPBoilerplate Main Menu Class.
 *
 * @since BuddyBoss 0.0.1
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Check if the class does not exits then only allow the file to add
 */
if ( ! class_exists( 'WPBoilerplate_Main_Menu' ) ) {

	/**
	 * Fired during plugin licences.
	 *
	 * This class defines all code necessary to run during the plugin's licences and update.
	 *
	 * @since      0.0.1
	 * @package    WPBoilerplate_Main_Menu
	 * @subpackage WPBoilerplate_Main_Menu/includes
	 */
	class WPBoilerplate_Main_Menu {

		/**
		 * The single instance of the class.
		 *
		 * @var WPBoilerplate_Main_Menu
		 * @since 0.0.1
		 */
		protected static $_instance = null;

		/**
		 * Initialize the collections used to maintain the actions and filters.
		 *
		 * @since    0.0.1
		 */
		public function __construct() {

			$this->define( 'WPBOILERPLATE_MAIN_MENU', 'wpboilerplate' );

			/**
			 * Add the parent menu into the Admin Dashboard
			 */
			add_action( 'admin_menu', array( $this, 'main_menu' ) );
		}

		/**
		 * Main WPBoilerplate_Main_Menu Instance.
		 *
		 * @since 0.0.1
		 * @static
		 * @see WPBoilerplate_Main_Menu()
		 * @return WPBoilerplate_Main_Menu - Main instance.
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
				__( 'WPBoilerplate', 'wpboilerplate' ),
				__( 'WPBoilerplate', 'wpboilerplate' ),
				'manage_options',
				WPBOILERPLATE_MAIN_MENU,
				array( $this, 'about' )
			);
		}

		function about() {
			?>
			<style>
				.wpboilerplate-container {
					display: flex;
					flex-direction: column;
					align-items: center;
					justify-content: center;
					height: 100vh;
					background-color: #f7f7f7;
				}
		
				.wpboilerplate-logo img {
					max-width: 200px;
					height: auto;
				}
		
				.wpboilerplate-content {
					text-align: center;
					max-width: 600px;
					margin-top: 20px;
					padding: 20px;
					background-color: #fff;
					border-radius: 10px;
					box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
				}
		
				h2 {
					color: #0073e6;
					font-size: 24px;
				}
		
				h3 {
					color: #333;
					font-size: 20px;
				}
		
				ul {
					list-style-type: disc;
					padding-left: 20px;
					text-align: left;
				}
		
				p {
					font-size: 18px;
				}
			</style>
		
			<div class="wpboilerplate-container">
		
				<div class="wpboilerplate-content">
					<h2>WPBoilerplate</h2>
					<p style="text-align: left;">Welcome to WPBoilerplate, your comprehensive starting point for developing WordPress plugins with modern development practices. This boilerplate offers a structured and efficient setup, streamlining the process of creating robust and maintainable WordPress plugins.</p>
		
					<h3>Key Features:</h3>
					<ul>
						<li><strong>Modular Structure:</strong> Organized codebase that promotes clean, readable, and maintainable project architecture.</li>
		
						<li><strong>Modern Development Tools:</strong> Integrates wp-script to enhance your workflow and automate tasks.</li>
		
						<li><strong>Best Practices:</strong> Follows WordPress coding standards and best practices to ensure high-quality code.</li>

                        <li><strong>Customization Ready:</strong> Easily customizable to fit the specific needs of your plugin development projects.</li>

                        <li><strong>Plugin Update Checker:</strong> Built-in functionality to manage and check for plugin updates, ensuring your plugins stay current.</li>
					</ul>
		
					<h3>Documentation</h3>
					<p>Comprehensive documentation is available to guide you through the setup process, customization options, and deployment procedures. Whether you're a seasoned developer or new to WordPress plugin development, our documentation is designed to make your development experience as smooth as possible.</p>
		
                    <h3>Contributions</h3>
					<p>We welcome contributions from the community. Feel free to fork the repository, create issues, or submit pull requests to help us improve WPBoilerplate.</p>
				</div>
			</div>
			<?php
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

	WPBoilerplate_Main_Menu::instance();
}