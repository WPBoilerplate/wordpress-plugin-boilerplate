<?php
namespace WordPress_Plugin_Boilerplate\Includes;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/WPBoilerplate/wordpress-plugin-boilerplate
 * @since      1.0.0
 *
 * @package    WordPress_Plugin_Boilerplate
 * @subpackage WordPress_Plugin_Boilerplate/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    WordPress_Plugin_Boilerplate
 * @subpackage WordPress_Plugin_Boilerplate/includes
 * @author     WPBoilerplate <contact@wpboilerplate.com>
 */
final class Main {

	/**
	 * The single instance of the class.
	 *
	 * @var WordPress_Plugin_Boilerplate
	 * @since 1.0.0
	 */
	protected static $_instance = null;

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      WordPress_Plugin_Boilerplate_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The plugin dir path
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_path    The string for plugin dir path
	 */
	protected $plugin_path;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Plugin directory path.
	 *
	 * @var string
	 */
	protected $plugin_dir;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'wordpress-plugin-boilerplate';

		$this->define_constants();

		if ( defined( 'WORDPRESS_PLUGIN_BOILERPLATE_VERSION' ) ) {
			$this->version = WORDPRESS_PLUGIN_BOILERPLATE_VERSION;
		} else {
			$this->version = '1.0.0';
		}

		$this->register_autoloader();

		$this->load_composer_dependencies();

		$this->load_dependencies();

		$this->set_locale();

		$this->load_hooks();
	}

	/**
	 * Main WordPress_Plugin_Boilerplate Instance.
	 *
	 * Ensures only one instance of WooCommerce is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see WordPress_Plugin_Boilerplate()
	 * @return WordPress_Plugin_Boilerplate - Main instance.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Define WCE Constants
	 */
	private function define_constants() {

		$this->define( 'WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_FILE', \WORDPRESS_PLUGIN_BOILERPLATE_FILES );

		$this->define( 'WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_BASENAME', plugin_basename( \WORDPRESS_PLUGIN_BOILERPLATE_FILES ) );
		$this->define( 'WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_PATH', plugin_dir_path( \WORDPRESS_PLUGIN_BOILERPLATE_FILES ) );
		$this->define( 'WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_URL', plugin_dir_url( \WORDPRESS_PLUGIN_BOILERPLATE_FILES ) );
		$this->define( 'WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_NAME_SLUG', $this->plugin_name );
		$this->define( 'WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_NAME', 'WordPress Plugin Boilerplate' );

		if ( ! function_exists( 'get_plugin_data' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		$plugin_file = defined( 'WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_FILE' )
			? \WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_FILE
			: \WORDPRESS_PLUGIN_BOILERPLATE_FILES;
		$plugin_data = get_plugin_data( $plugin_file );
		$version     = $plugin_data['Version'];
		$this->define( 'WORDPRESS_PLUGIN_BOILERPLATE_VERSION', $version );

		$this->define( 'WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_URL', $version );

		$this->plugin_dir = defined( 'WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_PATH' )
			? \WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_PATH
			: plugin_dir_path( \WORDPRESS_PLUGIN_BOILERPLATE_FILES );
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

	/**
	 * Register the plugin's PSR-4 autoloader.
	 *
	 * This autoloader will automatically load classes from the plugin's namespace
	 * when they are instantiated.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function register_autoloader() {
		spl_autoload_register( array( $this, 'autoload_class' ) );
	}

	/**
	 * Autoload class files based on PSR-4 naming convention.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @param    string $class_name The name of the class to load.
	 */
	private function autoload_class( $class_name ) {
		// Base namespace for this plugin
		$base_namespace = 'WordPress_Plugin_Boilerplate\\';

		// Check if this class belongs to our plugin namespace
		if ( strpos( $class_name, $base_namespace ) !== 0 ) {
			return;
		}

		// Remove the base namespace from the class name
		$relative_class = substr( $class_name, strlen( $base_namespace ) );

		// Define namespace to directory mapping
		$namespace_map = array(
			'Includes\\' => 'includes/',
			'Admin\\'    => 'admin/',
			'Public\\'   => 'public/',
		);

		// Get the plugin path (use constant from global namespace)
		$plugin_path = defined( 'WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_PATH' )
			? \WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_PATH
			: plugin_dir_path( \WORDPRESS_PLUGIN_BOILERPLATE_FILES );

		// Find the appropriate directory for this namespace
		$file_path = '';
		foreach ( $namespace_map as $namespace => $directory ) {
			if ( strpos( $relative_class, $namespace ) === 0 ) {
				// Remove the namespace prefix and convert to file path
				$class_file = substr( $relative_class, strlen( $namespace ) );
				$class_file = str_replace( '\\', '/', $class_file );

				// Build the full file path
				$file_path = $plugin_path . $directory . $class_file . '.php';
				break;
			}
		}

		// If no namespace mapping found, try the default includes directory
		if ( empty( $file_path ) ) {
			$class_file = str_replace( '\\', '/', $relative_class );
			$file_path  = $plugin_path . 'includes/' . $class_file . '.php';
		}

		// Load the file if it exists
		if ( file_exists( $file_path ) ) {
			require_once $file_path;
		}
	}

	/**
	 * Register all the hook once all the active plugins are loaded
	 *
	 * Uses the plugins_loaded to load all the hooks and filters
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	public function load_hooks() {

		/**
		 * Check if plugin can be loaded safely or not
		 *
		 * @since    1.0.0
		 */
		if ( apply_filters( 'wordpress-plugin-boilerplate-load', true ) ) {
			$this->define_admin_hooks();
			$this->define_public_hooks();
		}
	}

	/**
	 * Load the required composer dependencies for this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_composer_dependencies() {

		/**
		 * Add composer file
		 */
		$plugin_path = defined( 'WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_PATH' )
			? \WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_PATH
			: plugin_dir_path( \WORDPRESS_PLUGIN_BOILERPLATE_FILES );

		if ( file_exists( $plugin_path . 'vendor/autoload.php' ) ) {
			require_once $plugin_path . 'vendor/autoload.php';
		}
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - WordPress_Plugin_Boilerplate\Admin\Loader. Orchestrates the hooks of the plugin.
	 * - WordPress_Plugin_Boilerplate\Admin\I18n. Defines internationalization functionality.
	 * - WordPress_Plugin_Boilerplate\Admin\Main. Defines all hooks for the admin area.
	 * - WordPress_Plugin_Boilerplate_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		$this->loader = Loader::instance();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the WordPress_Plugin_Boilerplate_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {
		$i18n = new I18n();

		// Now attach it to `init`, not `plugins_loaded`
		$this->loader->add_action( 'init', $i18n, 'do_load_textdomain' );
	}


	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new \WordPress_Plugin_Boilerplate\Admin\Main( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		/**
		 * Add the Plugin Main Menu - delay until after init to avoid translation warnings
		 */
		$this->loader->add_action( 'init', $this, 'register_admin_menu' );
	}

	/**
	 * Register admin menu after init to avoid translation loading warnings.
	 *
	 * @since    1.0.0
	 */
	public function register_admin_menu() {
		$main_menu = new \WordPress_Plugin_Boilerplate\Admin\Partials\Menu( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'admin_menu', $main_menu, 'main_menu' );
		$this->loader->add_action( 'plugin_action_links', $main_menu, 'plugin_action_links', 1000, 2 );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new \WordPress_Plugin_Boilerplate\Public\Main( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    WordPress_Plugin_Boilerplate_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
}
