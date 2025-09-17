<?php
/**
 * Class ActivatorTest
 *
 * Test the Activator class for plugin activation functionality.
 *
 * @package    WordPress_Plugin_Boilerplate
 * @subpackage WordPress_Plugin_Boilerplate/tests
 * @since      1.0.0
 */

namespace WordPress_Plugin_Boilerplate\Tests;

use WordPress_Plugin_Boilerplate\Includes\Activator;
use PHPUnit\Framework\TestCase;

/**
 * Test Activator class functionality.
 *
 * @since 1.0.0
 */
class ActivatorTest extends TestCase {

	/**
	 * Set up test environment before each test.
	 *
	 * @return void
	 */
	protected function setUp(): void {
		parent::setUp();

		// Define WordPress constants for testing.
		if ( ! defined( 'ABSPATH' ) ) {
			define( 'ABSPATH', '/tmp/' );
		}
	}

	/**
	 * Test that the Activator class exists.
	 *
	 * @return void
	 */
	public function test_activator_class_exists() {
		$this->assertTrue( class_exists( Activator::class ) );
	}

	/**
	 * Test that activate method exists and is static.
	 *
	 * @return void
	 */
	public function test_activate_method_exists_and_is_static() {
		$this->assertTrue( method_exists( Activator::class, 'activate' ) );

		$reflection = new \ReflectionClass( Activator::class );
		$method     = $reflection->getMethod( 'activate' );

		$this->assertTrue( $method->isStatic() );
		$this->assertTrue( $method->isPublic() );
	}

	/**
	 * Test that activate method can be called.
	 *
	 * @return void
	 */
	public function test_activate_method_can_be_called() {
		// The method should not throw any exceptions.
		$this->expectNotToPerformAssertions();

		Activator::activate();
	}

	/**
	 * Test that the class follows WordPress coding standards.
	 *
	 * @return void
	 */
	public function test_class_follows_wordpress_standards() {
		$reflection = new \ReflectionClass( Activator::class );

		// Test class is in correct namespace.
		$this->assertEquals( 'WordPress_Plugin_Boilerplate\Includes\Activator', $reflection->getName() );

		// Test class has proper documentation.
		$this->assertNotEmpty( $reflection->getDocComment() );

		// Test method has proper documentation.
		$method = $reflection->getMethod( 'activate' );
		$this->assertNotEmpty( $method->getDocComment() );
	}

	/**
	 * Test that activate method returns void.
	 *
	 * @return void
	 */
	public function test_activate_method_returns_void() {
		$reflection = new \ReflectionClass( Activator::class );
		$method     = $reflection->getMethod( 'activate' );

		// The method should not return anything.
		$result = Activator::activate();
		$this->assertNull( $result );
	}
}
