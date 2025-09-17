<?php
/**
 * Unit tests for WordPress Plugin Boilerplate Main class.
 *
 * @package WordPress_Plugin_Boilerplate
 */

use WordPress_Plugin_Boilerplate\Includes\Main;
use WordPress_Plugin_Boilerplate\Includes\Loader;
use WordPress_Plugin_Boilerplate\Admin\Main as AdminMain;
use WordPress_Plugin_Boilerplate\Public\Main as PublicMain;

/**
 * Test case for Main plugin class.
 *
 * @group main
 */
class MainClassTest extends PHPUnit\Framework\TestCase {

	/**
	 * The Main plugin instance.
	 *
	 * @var Main
	 */
	protected $main_instance;

	/**
	 * Set up test environment before each test.
	 */
	public function setUp(): void {
		parent::setUp();

		// Reset singleton instance before each test.
		$reflection        = new ReflectionClass( Main::class );
		$instance_property = $reflection->getProperty( '_instance' );
		$instance_property->setAccessible( true );
		$instance_property->setValue( null );

		// Create fresh instance for testing.
		$this->main_instance = Main::instance();
	}

	/**
	 * Clean up after each test.
	 */
	public function tearDown(): void {
		parent::tearDown();

		// Reset singleton instance.
		$reflection        = new ReflectionClass( Main::class );
		$instance_property = $reflection->getProperty( '_instance' );
		$instance_property->setAccessible( true );
		$instance_property->setValue( null );
	}

	/**
	 * Test singleton instance creation.
	 */
	public function test_instance_returns_singleton() {
		$instance1 = Main::instance();
		$instance2 = Main::instance();

		$this->assertInstanceOf( Main::class, $instance1 );
		$this->assertSame( $instance1, $instance2 );
	}

	/**
	 * Test plugin name getter.
	 */
	public function test_get_plugin_name() {
		$plugin_name = $this->main_instance->get_plugin_name();

		$this->assertIsString( $plugin_name );
		$this->assertEquals( 'wordpress-plugin-boilerplate', $plugin_name );
	}

	/**
	 * Test plugin version getter.
	 */
	public function test_get_version() {
		$version = $this->main_instance->get_version();

		$this->assertIsString( $version );
		$this->assertNotEmpty( $version );

		// Version should be in semantic version format (x.y.z).
		$this->assertMatchesRegularExpression( '/^\d+\.\d+\.\d+/', $version );
	}

	/**
	 * Test loader instance getter.
	 */
	public function test_get_loader() {
		$loader = $this->main_instance->get_loader();

		$this->assertInstanceOf( Loader::class, $loader );
	}

	/**
	 * Test autoloader instance getter.
	 */
	public function test_get_autoloader() {
		$autoloader = $this->main_instance->get_autoloader();

		$this->assertNotNull( $autoloader );
		$this->assertIsObject( $autoloader );
	}

	/**
	 * Test that required constants are defined.
	 */
	public function test_constants_are_defined() {
		// Test core constants.
		$this->assertTrue( defined( 'WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_BASENAME' ) );
		$this->assertTrue( defined( 'WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_PATH' ) );
		$this->assertTrue( defined( 'WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_URL' ) );
		$this->assertTrue( defined( 'WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_NAME_SLUG' ) );
		$this->assertTrue( defined( 'WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_NAME' ) );
		$this->assertTrue( defined( 'WORDPRESS_PLUGIN_BOILERPLATE_VERSION' ) );

		// Test constant values.
		$this->assertEquals( 'wordpress-plugin-boilerplate', WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_NAME_SLUG );
		$this->assertEquals( 'WordPress Plugin Boilerplate', WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_NAME );
		$this->assertNotEmpty( WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_PATH );
		$this->assertNotEmpty( WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_URL );
	}

	/**
	 * Test plugin initialization process.
	 */
	public function test_plugin_initialization() {
		// Test that loader is initialized.
		$this->assertInstanceOf( Loader::class, $this->main_instance->get_loader() );

		// Test that autoloader is registered.
		$this->assertNotNull( $this->main_instance->get_autoloader() );

		// Test that plugin name and version are set.
		$this->assertEquals( 'wordpress-plugin-boilerplate', $this->main_instance->get_plugin_name() );
		$this->assertNotEmpty( $this->main_instance->get_version() );
	}

	/**
	 * Test loader run method integration.
	 */
	public function test_loader_run_integration() {
		$loader = $this->main_instance->get_loader();

		// Should not throw any errors.
		$this->assertNull( $this->main_instance->run() );

		// Test that hooks are properly registered after run.
		global $wp_filter;
		$this->assertArrayHasKey( 'admin_enqueue_scripts', $wp_filter );
		$this->assertArrayHasKey( 'wp_enqueue_scripts', $wp_filter );
	}

	/**
	 * Test filter application for plugin loading.
	 */
	public function test_plugin_load_filter() {
		// Test default behavior (should load).
		$should_load = apply_filters( 'wordpress-plugin-boilerplate-load', true );
		$this->assertTrue( $should_load );

		// Test filter can prevent loading.
		add_filter( 'wordpress-plugin-boilerplate-load', '__return_false' );
		$should_not_load = apply_filters( 'wordpress-plugin-boilerplate-load', true );
		$this->assertFalse( $should_not_load );

		// Clean up.
		remove_filter( 'wordpress-plugin-boilerplate-load', '__return_false' );
	}
}

/**
 * Test case for Admin Main class.
 *
 * @group admin
 */
class AdminMainTest extends PHPUnit\Framework\TestCase {

	/**
	 * The Admin Main instance.
	 *
	 * @var AdminMain
	 */
	protected $admin_main;

	/**
	 * Set up test environment before each test.
	 */
	public function setUp(): void {
		parent::setUp();

		$this->admin_main = new AdminMain( 'test-plugin', '1.0.0' );
	}

	/**
	 * Test admin class initialization.
	 */
	public function test_admin_main_initialization() {
		$this->assertInstanceOf( AdminMain::class, $this->admin_main );

		// Test private properties via reflection.
		$reflection = new ReflectionClass( $this->admin_main );

		$plugin_name_prop = $reflection->getProperty( 'plugin_name' );
		$plugin_name_prop->setAccessible( true );
		$this->assertEquals( 'test-plugin', $plugin_name_prop->getValue( $this->admin_main ) );

		$version_prop = $reflection->getProperty( 'version' );
		$version_prop->setAccessible( true );
		$this->assertEquals( '1.0.0', $version_prop->getValue( $this->admin_main ) );
	}

	/**
	 * Test admin styles enqueuing.
	 */
	public function test_enqueue_styles() {
		global $wp_styles;
		$wp_styles = new WP_Styles();

		// Set admin context.
		set_current_screen( 'dashboard' );

		$this->admin_main->enqueue_styles();

		// Check if style is registered.
		$this->assertTrue( wp_style_is( 'test-plugin', 'registered' ) );

		// Clean up.
		wp_dequeue_style( 'test-plugin' );
	}

	/**
	 * Test admin scripts enqueuing.
	 */
	public function test_enqueue_scripts() {
		global $wp_scripts;
		$wp_scripts = new WP_Scripts();

		// Set admin context.
		set_current_screen( 'dashboard' );

		$this->admin_main->enqueue_scripts();

		// Check if script is registered.
		$this->assertTrue( wp_script_is( 'test-plugin', 'registered' ) );

		// Clean up.
		wp_dequeue_script( 'test-plugin' );
	}
}

/**
 * Test case for Public Main class.
 *
 * @group public
 */
class PublicMainTest extends PHPUnit\Framework\TestCase {

	/**
	 * The Public Main instance.
	 *
	 * @var PublicMain
	 */
	protected $public_main;

	/**
	 * Set up test environment before each test.
	 */
	public function setUp(): void {
		parent::setUp();

		$this->public_main = new PublicMain( 'test-plugin', '1.0.0' );
	}

	/**
	 * Test public class initialization.
	 */
	public function test_public_main_initialization() {
		$this->assertInstanceOf( PublicMain::class, $this->public_main );

		// Test private properties via reflection.
		$reflection = new ReflectionClass( $this->public_main );

		$plugin_name_prop = $reflection->getProperty( 'plugin_name' );
		$plugin_name_prop->setAccessible( true );
		$this->assertEquals( 'test-plugin', $plugin_name_prop->getValue( $this->public_main ) );

		$version_prop = $reflection->getProperty( 'version' );
		$version_prop->setAccessible( true );
		$this->assertEquals( '1.0.0', $version_prop->getValue( $this->public_main ) );
	}

	/**
	 * Test frontend styles enqueuing.
	 */
	public function test_enqueue_styles() {
		global $wp_styles;
		$wp_styles = new WP_Styles();

		$this->public_main->enqueue_styles();

		// Check if style is registered.
		$this->assertTrue( wp_style_is( 'test-plugin', 'registered' ) );

		// Clean up.
		wp_dequeue_style( 'test-plugin' );
	}

	/**
	 * Test frontend scripts enqueuing.
	 */
	public function test_enqueue_scripts() {
		global $wp_scripts;
		$wp_scripts = new WP_Scripts();

		$this->public_main->enqueue_scripts();

		// Check if script is registered.
		$this->assertTrue( wp_script_is( 'test-plugin', 'registered' ) );

		// Clean up.
		wp_dequeue_script( 'test-plugin' );
	}
}

/**
 * Test case for Loader class.
 *
 * @group loader
 */
class LoaderTest extends PHPUnit\Framework\TestCase {

	/**
	 * The Loader instance.
	 *
	 * @var Loader
	 */
	protected $loader;

	/**
	 * Set up test environment before each test.
	 */
	public function setUp(): void {
		parent::setUp();

		// Reset singleton.
		$reflection        = new ReflectionClass( Loader::class );
		$instance_property = $reflection->getProperty( '_instance' );
		$instance_property->setAccessible( true );
		$instance_property->setValue( null );

		$this->loader = Loader::instance();
	}

	/**
	 * Test loader singleton instance.
	 */
	public function test_loader_singleton() {
		$instance1 = Loader::instance();
		$instance2 = Loader::instance();

		$this->assertInstanceOf( Loader::class, $instance1 );
		$this->assertSame( $instance1, $instance2 );
	}

	/**
	 * Test adding actions.
	 */
	public function test_add_action() {
		$mock_component = new stdClass();

		$this->loader->add_action( 'init', $mock_component, 'test_callback', 20, 2 );

		// Use reflection to access private actions array.
		$reflection   = new ReflectionClass( $this->loader );
		$actions_prop = $reflection->getProperty( 'actions' );
		$actions_prop->setAccessible( true );
		$actions = $actions_prop->getValue( $this->loader );

		$this->assertCount( 1, $actions );
		$this->assertEquals( 'init', $actions[0]['hook'] );
		$this->assertEquals( $mock_component, $actions[0]['component'] );
		$this->assertEquals( 'test_callback', $actions[0]['callback'] );
		$this->assertEquals( 20, $actions[0]['priority'] );
		$this->assertEquals( 2, $actions[0]['accepted_args'] );
	}

	/**
	 * Test adding filters.
	 */
	public function test_add_filter() {
		$mock_component = new stdClass();

		$this->loader->add_filter( 'the_content', $mock_component, 'filter_callback', 15, 3 );

		// Use reflection to access private filters array.
		$reflection   = new ReflectionClass( $this->loader );
		$filters_prop = $reflection->getProperty( 'filters' );
		$filters_prop->setAccessible( true );
		$filters = $filters_prop->getValue( $this->loader );

		$this->assertCount( 1, $filters );
		$this->assertEquals( 'the_content', $filters[0]['hook'] );
		$this->assertEquals( $mock_component, $filters[0]['component'] );
		$this->assertEquals( 'filter_callback', $filters[0]['callback'] );
		$this->assertEquals( 15, $filters[0]['priority'] );
		$this->assertEquals( 3, $filters[0]['accepted_args'] );
	}

	/**
	 * Test running the loader.
	 */
	public function test_run() {
		// Create a test class with callback methods.
		$test_component = new class() {
			/**
			 * Flag to track if action was called.
			 *
			 * @var bool
			 */
			public $action_called = false;

			/**
			 * Flag to track if filter was called.
			 *
			 * @var bool
			 */
			public $filter_called = false;

			/**
			 * Test action callback.
			 */
			public function test_action() {
				$this->action_called = true;
			}

			/**
			 * Test filter callback.
			 *
			 * @param string $content The content to filter.
			 * @return string
			 */
			public function test_filter( $content ) {
				$this->filter_called = true;
				return $content;
			}
		};

		// Add hooks.
		$this->loader->add_action( 'wp_loaded', $test_component, 'test_action' );
		$this->loader->add_filter( 'the_title', $test_component, 'test_filter' );

		// Run the loader.
		$this->loader->run();

		// Trigger the hooks to test they're registered.
		do_action( 'wp_loaded' );
		apply_filters( 'the_title', 'Test Title' );

		$this->assertTrue( $test_component->action_called );
		$this->assertTrue( $test_component->filter_called );
	}

	/**
	 * Test multiple actions and filters.
	 */
	public function test_multiple_hooks() {
		$mock_component1 = new stdClass();
		$mock_component2 = new stdClass();

		// Add multiple actions and filters.
		$this->loader->add_action( 'init', $mock_component1, 'callback1' );
		$this->loader->add_action( 'wp_loaded', $mock_component2, 'callback2' );
		$this->loader->add_filter( 'the_content', $mock_component1, 'filter1' );
		$this->loader->add_filter( 'the_title', $mock_component2, 'filter2' );

		// Check counts using reflection.
		$reflection = new ReflectionClass( $this->loader );

		$actions_prop = $reflection->getProperty( 'actions' );
		$actions_prop->setAccessible( true );
		$actions = $actions_prop->getValue( $this->loader );

		$filters_prop = $reflection->getProperty( 'filters' );
		$filters_prop->setAccessible( true );
		$filters = $filters_prop->getValue( $this->loader );

		$this->assertCount( 2, $actions );
		$this->assertCount( 2, $filters );
	}
}
