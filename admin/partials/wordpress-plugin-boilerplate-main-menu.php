<?php
/**
 * Wordpress_Plugin_Boilerplate_Main_Menu Main Menu Class.
 *
 * @since Wordpress_Plugin_Boilerplate_Main_Menu 1.0.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


/**
 * Fired during plugin licences.
 *
 * This class defines all code necessary to run during the plugin's licences and update.
 *
 * @since      1.0.0
 * @package    Wordpress_Plugin_Boilerplate_Main_Menu
 * @subpackage Wordpress_Plugin_Boilerplate_Main_Menu/includes
 */
class Wordpress_Plugin_Boilerplate_Main_Menu {

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
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Adds the plugin license page to the admin menu.
	 *
	 * @return void
	 */
	public function main_menu() {
		add_menu_page(
			__( 'WordPress Plugin Boilerplate', 'wordpress-plugin-boilerplate' ),
			__( 'WordPress Plugin Boilerplate', 'wordpress-plugin-boilerplate' ),
			'manage_options',
			'wordpress-plugin-boilerplate',
			array( $this, 'about' )
		);
	}

	/**
	 * About us for the plugins
	 */
	public function about() {
		?>
		<style>
			.wordpress-plugin-boilerplate-container {
				display: flex;
				flex-direction: column;
				align-items: center;
				justify-content: center;
				height: 100vh;
				background-color: #f7f7f7;
			}
	
			.wordpress-plugin-boilerplate-logo img {
				max-width: 200px;
				height: auto;
			}
	
			.wordpress-plugin-boilerplate-content {
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
	
		<div class="wordpress-plugin-boilerplate-container">
	
			<div class="wordpress-plugin-boilerplate-content">
				<h2>WordPress Plugin Boilerplate</h2>
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
	 * Add Settings link to plugins area.
	 *
	 * @since    1.0.0
	 *
	 * @param array  $links Links array in which we would prepend our link.
	 * @param string $file  Current plugin basename.
	 * @return array Processed links.
	 */
	public function plugin_action_links( $links, $file ) {

		// Return normal links if not BuddyPress.
		if ( WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_BASENAME !== $file ) {
			return $links;
		}

		// Add a few links to the existing links array.
		return array_merge(
			$links,
			array(
				'about'	=> sprintf( '<a href="%sadmin.php?page=%s">%s</a>', admin_url(), 'wordpress-plugin-boilerplate', esc_html__( 'About', 'wordpress-plugin-boilerplate' ) ),
			)
		);
	}
}