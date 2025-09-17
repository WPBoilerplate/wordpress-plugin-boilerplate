<?php
/**
 * Class DeactivatorTest
 *
 * Test the Deactivator class for plugin deactivation functionality.
 *
 * @package    WordPress_Plugin_Boilerplate
 * @subpackage WordPress_Plugin_Boilerplate/tests
 * @since      1.0.0
 */

namespace WordPress_Plugin_Boilerplate\Tests;

use WordPress_Plugin_Boilerplate\Includes\Deactivator;
use PHPUnit\Framework\TestCase;

/**
 * Test Deactivator class functionality.
 *
 * @since 1.0.0
 */
class DeactivatorTest extends TestCase {

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
	 * Test that the Deactivator class exists.
	 *
	 * @return void
	 */
	public function test_deactivator_class_exists() {
		$this->assertTrue( class_exists( Deactivator::class ) );
	}

	/**
	 * Test that deactivate method exists and is static.
	 *
	 * @return void
	 */
	public function test_deactivate_method_exists_and_is_static() {
		$this->assertTrue( method_exists( Deactivator::class, 'deactivate' ) );

		$reflection = new \ReflectionClass( Deactivator::class );
		$method     = $reflection->getMethod( 'deactivate' );

		$this->assertTrue( $method->isStatic() );
		$this->assertTrue( $method->isPublic() );
	}

	/**
	 * Test that deactivate method can be called.
	 *
	 * @return void
	 */
	public function test_deactivate_method_can_be_called() {
		// The method should not throw any exceptions.
		$this->expectNotToPerformAssertions();

		Deactivator::deactivate();
	}

	/**
	 * Test that the class follows WordPress coding standards.
	 *
	 * @return void
	 */
	public function test_class_follows_wordpress_standards() {
		$reflection = new \ReflectionClass( Deactivator::class );

		// Test class is in correct namespace.
		$this->assertEquals( 'WordPress_Plugin_Boilerplate\Includes\Deactivator', $reflection->getName() );

		// Test class has proper documentation.
		$this->assertNotEmpty( $reflection->getDocComment() );

		// Test method has proper documentation.
		$method = $reflection->getMethod( 'deactivate' );
		$this->assertNotEmpty( $method->getDocComment() );
	}

	/**
	 * Test that deactivate method returns void.
	 *
	 * @return void
	 */
	public function test_deactivate_method_returns_void() {
		$reflection = new \ReflectionClass( Deactivator::class );
		$method     = $reflection->getMethod( 'deactivate' );

		// The method should not return anything.
		$result = Deactivator::deactivate();
		$this->assertNull( $result );
	}
}
