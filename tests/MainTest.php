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
use PHPUnit\Framework\TestCase;

/**
 * Test case for Main plugin class.
 *
 * @group main
 */
class MainTest extends TestCase {

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

		// Define WordPress constants if not already defined.
		if ( ! defined( 'ABSPATH' ) ) {
			define( 'ABSPATH', '/tmp/' );
		}

		// Get singleton instance.
		$this->main_instance = Main::instance();
	}

	/**
	 * Test that Main class can be instantiated as singleton.
	 */
	public function test_main_singleton_instance() {
		$instance1 = Main::instance();
		$instance2 = Main::instance();

		$this->assertInstanceOf( Main::class, $instance1 );
		$this->assertSame( $instance1, $instance2, 'Multiple calls should return same instance' );
	}

	/**
	 * Test that Main class has required constants defined.
	 */
	public function test_main_constants_defined() {
		$this->assertNotEmpty( $this->main_instance->get_plugin_name() );
		$this->assertNotEmpty( $this->main_instance->get_version() );
	}

	/**
	 * Test that get_plugin_name returns correct value.
	 */
	public function test_get_plugin_name() {
		$plugin_name = $this->main_instance->get_plugin_name();
		$this->assertEquals( 'wordpress-plugin-boilerplate', $plugin_name );
	}

	/**
	 * Test that get_version returns a version string.
	 */
	public function test_get_version() {
		$version = $this->main_instance->get_version();
		$this->assertNotEmpty( $version );
		$this->assertIsString( $version );
	}

	/**
	 * Test that get_loader returns Loader instance.
	 */
	public function test_get_loader() {
		$loader = $this->main_instance->get_loader();
		$this->assertInstanceOf( Loader::class, $loader );
	}

	/**
	 * Test that run method initializes the plugin.
	 */
	public function test_run_method() {
		// Test that run method exists and is callable.
		$this->assertTrue( method_exists( $this->main_instance, 'run' ) );

		// Run should not throw exceptions.
		$this->expectNotToPerformAssertions();
		$this->main_instance->run();
	}

	/**
	 * Test class structure and methods.
	 */
	public function test_class_structure() {
		$reflection = new \ReflectionClass( Main::class );

		// Test that it's in the correct namespace.
		$this->assertEquals( 'WordPress_Plugin_Boilerplate\Includes\Main', $reflection->getName() );

		// Test that required methods exist.
		$required_methods = array(
			'instance',
			'get_plugin_name',
			'get_version',
			'get_loader',
			'get_autoloader',
			'run',
			'load_hooks',
		);

		foreach ( $required_methods as $method ) {
			$this->assertTrue(
				$reflection->hasMethod( $method ),
				"Method {$method} should exist"
			);
		}
	}

	/**
	 * Clean up after tests.
	 */
	public function tearDown(): void {
		parent::tearDown();
	}
}
