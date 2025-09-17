<?php
/**
 * Class I18nTest
 *
 * Test the I18n class for internationalization functionality.
 *
 * @package    WordPress_Plugin_Boilerplate
 * @subpackage WordPress_Plugin_Boilerplate/tests
 * @since      1.0.0
 */

namespace WordPress_Plugin_Boilerplate\Tests;

use WordPress_Plugin_Boilerplate\Includes\I18n;
use PHPUnit\Framework\TestCase;

/**
 * Test I18n class functionality.
 *
 * @since 1.0.0
 */
class I18nTest extends TestCase {

	/**
	 * I18n instance
	 *
	 * @var I18n
	 */
	private $i18n;

	/**
	 * Set up test environment before each test.
	 *
	 * @return void
	 */
	protected function setUp(): void {
		parent::setUp();

		// Define WordPress constants for testing
		if ( ! defined( 'ABSPATH' ) ) {
			define( 'ABSPATH', '/tmp/' );
		}

		if ( ! defined( 'WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_FILE' ) ) {
			define( 'WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_FILE', __DIR__ . '/../wordpress-plugin-boilerplate.php' );
		}

		// Mock WordPress functions if not available
		if ( ! function_exists( 'load_plugin_textdomain' ) ) {
			/**
			 * Mock load_plugin_textdomain function for testing.
			 *
			 * @param string $domain Text domain.
			 * @param string $deprecated Deprecated parameter.
			 * @param string $plugin_rel_path Plugin relative path.
			 * @return bool
			 */
			function load_plugin_textdomain( $domain, $deprecated, $plugin_rel_path ) {
				return true;
			}
		}

		if ( ! function_exists( 'plugin_basename' ) ) {
			/**
			 * Mock plugin_basename function for testing.
			 *
			 * @param string $file Plugin file path.
			 * @return string
			 */
			function plugin_basename( $file ) {
				return basename( dirname( $file ) ) . '/' . basename( $file );
			}
		}

		$this->i18n = new I18n();
	}

	/**
	 * Test that the I18n class can be instantiated.
	 *
	 * @return void
	 */
	public function test_i18n_can_be_instantiated() {
		$this->assertInstanceOf( I18n::class, $this->i18n );
	}

	/**
	 * Test that do_load_textdomain method exists and is callable.
	 *
	 * @return void
	 */
	public function test_do_load_textdomain_method_exists() {
		$this->assertTrue( method_exists( $this->i18n, 'do_load_textdomain' ) );
		$this->assertTrue( is_callable( array( $this->i18n, 'do_load_textdomain' ) ) );
	}

	/**
	 * Test that do_load_textdomain calls load_plugin_textdomain.
	 *
	 * This test verifies that the method executes without errors.
	 * In a real WordPress environment, this would load the translation files.
	 *
	 * @return void
	 */
	public function test_do_load_textdomain_executes() {
		// Capture any potential output or errors
		ob_start();
		$result = $this->i18n->do_load_textdomain();
		$output = ob_get_clean();

		// The method should not produce output and should not throw exceptions
		$this->assertEmpty( $output );

		// The method doesn't return anything, so we just verify it ran
		$this->assertNull( $result );
	}

	/**
	 * Test that the class follows WordPress coding standards.
	 *
	 * @return void
	 */
	public function test_class_follows_wordpress_standards() {
		$reflection = new \ReflectionClass( I18n::class );

		// Test class is in correct namespace
		$this->assertEquals( 'WordPress_Plugin_Boilerplate\Includes\I18n', $reflection->getName() );

		// Test class has proper documentation
		$this->assertNotEmpty( $reflection->getDocComment() );

		// Test method has proper documentation
		$method = $reflection->getMethod( 'do_load_textdomain' );
		$this->assertNotEmpty( $method->getDocComment() );
	}

	/**
	 * Test that the method is public.
	 *
	 * @return void
	 */
	public function test_do_load_textdomain_is_public() {
		$reflection = new \ReflectionClass( I18n::class );
		$method     = $reflection->getMethod( 'do_load_textdomain' );

		$this->assertTrue( $method->isPublic() );
	}

	/**
	 * Clean up after each test.
	 *
	 * @return void
	 */
	protected function tearDown(): void {
		$this->i18n = null;
		parent::tearDown();
	}
}
