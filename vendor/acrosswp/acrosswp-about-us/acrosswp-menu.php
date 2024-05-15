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
if( ! class_exists( 'AcrossWP_Main_Menu' ) ) {
	/**
	 * Fired during plugin licences.
	 *
	 * This class defines all code necessary to run during the plugin's licences and update.
	 *
	 * @since      0.0.1
	 * @package    AcrossWP_Main_Menu
	 * @subpackage AcrossWP_Main_Menu/includes
	 * @author     AcrossWP <contact@acrosswp.com>
	 */
	class AcrossWP_Main_Menu {

		/**
		 * The single instance of the class.
		 *
		 * @var AcrossWP_Main_Menu
		 * @since 0.0.1
		 */
		protected static $_instance = null;

		/**
		 * Initialize the collections used to maintain the actions and filters.
		 *
		 * @since    0.0.1
		 */
		public function __construct() {

			$this->define( 'ACROSSWP_MAIN_MENU', 'acrosswp' );

			/**
			 * Add the parent menu into the Admin Dashboard
			 */
			add_action( 'admin_menu', array( $this, 'main_menu' ) );
		}

		/**
		 * Main Post_Anonymously_Loader Instance.
		 *
		 * Ensures only one instance of WooCommerce is loaded or can be loaded.
		 *
		 * @since 0.0.1
		 * @static
		 * @see Post_Anonymously_Loader()
		 * @return Post_Anonymously_Loader - Main instance.
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
				__( 'AcrossWP', 'acrosswp' ),
				__( 'AcrossWP', 'acrosswp' ),
				'manage_options',
				ACROSSWP_MAIN_MENU,
				array( $this, 'about_acrosswp' )
			);
		}

		function about_acrosswp() {
			?>
			<style>
				.acrosswp-container {
					display: flex;
					flex-direction: column;
					align-items: center;
					justify-content: center;
					height: 100vh;
					background-color: #f7f7f7;
				}
		
				.acrosswp-logo img {
					max-width: 200px;
					height: auto;
				}
		
				.acrosswp-content {
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
		
			<div class="acrosswp-container">
				<div class="acrosswp-logo">
					<img src="https://acrosswp.com/wp-content/uploads/2023/10/awp-logo.png" alt="AcrossWP Logo">
				</div>
		
				<div class="acrosswp-content">
					<h2>At AcrossWP</h2>
					<p style="text-align: left;">We understand the importance of customizing and creating plugins for WordPress to meet our clients’ unique needs.</p>
					<p style="text-align: left;">Our team of skilled developers has extensive experience in customizing and creating WordPress plugins that are tailored to our clients’ requirements.</p>
		
					<h3>Our Specializations:</h3>
					<ul>
						<li><strong>E-commerce Development:</strong> We specialize in developing e-commerce sites using WooCommerce, the most popular and widely used e-commerce platform in the world. Our team is proficient in building custom online stores that are visually appealing, user-friendly, and highly functional.</li>
		
						<li><strong>Social Networking:</strong> We also specialize in building social networking sites using AcrossWP. Whether you’re looking to build a community for your brand, an online marketplace, or a social network for a particular niche, our team has the expertise to deliver a social networking site that meets your needs.</li>
		
						<li><strong>Learning Management Systems (LMS):</strong> Furthermore, we have extensive experience in integrating Learning Management Systems (LMS) using LearnDash plugins. We believe that e-learning is the future, and we work tirelessly to develop online learning platforms that are engaging, interactive, and easy to use.</li>
					</ul>
		
					<h3>Why Choose Us?</h3>
					<ul>
						<li>Experienced and dedicated developers</li>
						<li>Custom solutions tailored to your unique requirements</li>
						<li>Stunning and user-friendly website designs</li>
						<li>Timely project delivery</li>
						<li>Exceptional customer support</li>
					</ul>
		
					<p>We are committed to delivering high-quality web development services that help our clients achieve their business goals.</p>
		
					<p>Contact us today to learn more about how we can help you with customizing and creating plugins for WordPress, building e-commerce sites, developing social networking sites, or integrating LMS using LearnDash plugins.</p>
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

	AcrossWP_Main_Menu::instance();
}