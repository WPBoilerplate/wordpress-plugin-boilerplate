<?php
/**
 * Unit tests for WordPress Plugin Boilerplate I18n class.
 *
 * @package WordPress_Plugin_Boilerplate
 */

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
	 */
	protected function setUp(): void {
		parent::setUp();

		// Define WordPress constants for testing.
		if ( ! defined( 'ABSPATH' ) ) {
			define( 'ABSPATH', '/tmp/' );
		}

		if ( ! defined( 'WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_FILE' ) ) {
			define( 'WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_FILE', __DIR__ . '/../wordpress-plugin-boilerplate.php' );
		}

		$this->i18n = new I18n();
	}

	/**
	 * Test that the I18n class can be instantiated.
	 */
	public function test_i18n_can_be_instantiated() {
		$this->assertInstanceOf( I18n::class, $this->i18n );
	}

	/**
	 * Test that do_load_textdomain method exists and is callable.
	 */
	public function test_do_load_textdomain_method_exists() {
		$this->assertTrue( method_exists( $this->i18n, 'do_load_textdomain' ) );
		$this->assertTrue( is_callable( array( $this->i18n, 'do_load_textdomain' ) ) );
	}

	/**
	 * Test that do_load_textdomain executes without errors.
	 */
	public function test_do_load_textdomain_executes() {
		// The method should not throw exceptions.
		$this->expectNotToPerformAssertions();
		$this->i18n->do_load_textdomain();
	}

	/**
	 * Test that the class follows WordPress coding standards.
	 */
	public function test_class_follows_wordpress_standards() {
		$reflection = new \ReflectionClass( I18n::class );

		// Test class is in correct namespace.
		$this->assertEquals( 'WordPress_Plugin_Boilerplate\Includes\I18n', $reflection->getName() );

		// Test class has proper documentation.
		$this->assertNotEmpty( $reflection->getDocComment() );

		// Test method has proper documentation.
		$method = $reflection->getMethod( 'do_load_textdomain' );
		$this->assertNotEmpty( $method->getDocComment() );
	}
}
