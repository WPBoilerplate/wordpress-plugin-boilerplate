<?php
/**
 * Class IntegrationTest
 *
 * Integration tests for the WordPress Plugin Boilerplate.
 *
 * @package    WordPress_Plugin_Boilerplate
 * @subpackage WordPress_Plugin_Boilerplate/tests
 * @since      1.0.0
 */

namespace WordPress_Plugin_Boilerplate\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Test plugin integration functionality.
 *
 * @since 1.0.0
 */
class IntegrationTest extends TestCase {

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

		if ( ! defined( 'WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_FILE' ) ) {
			define( 'WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_FILE', __DIR__ . '/../wordpress-plugin-boilerplate.php' );
		}
	}

	/**
	 * Test that the main plugin file exists and is readable.
	 *
	 * @return void
	 */
	public function test_main_plugin_file_exists() {
		$plugin_file = dirname( __DIR__ ) . '/wordpress-plugin-boilerplate.php';
		$this->assertTrue( file_exists( $plugin_file ) );
		$this->assertTrue( is_readable( $plugin_file ) );
	}

	/**
	 * Test that the display partial exists and is readable.
	 *
	 * @return void
	 */
	public function test_display_partial_exists() {
		$display_file = dirname( __DIR__ ) . '/public/partials/display.php';
		$this->assertTrue( file_exists( $display_file ) );
		$this->assertTrue( is_readable( $display_file ) );
	}

	/**
	 * Test that the display partial contains valid PHP.
	 *
	 * @return void
	 */
	public function test_display_partial_syntax() {
		$display_file = dirname( __DIR__ ) . '/public/partials/display.php';
		$content      = file_get_contents( $display_file );

		// Test that it starts with PHP opening tag.
		$this->assertStringStartsWith( '<?php', $content );

		// Test that it contains the security check.
		$this->assertStringContainsString( "defined( 'ABSPATH' ) || exit;", $content );
	}

	/**
	 * Test that plugin includes directory structure exists.
	 *
	 * @return void
	 */
	public function test_plugin_directory_structure() {
		$base_dir = dirname( __DIR__ );

		$required_dirs = array(
			'/includes',
			'/admin',
			'/public',
			'/languages',
			'/tests',
		);

		foreach ( $required_dirs as $dir ) {
			$this->assertTrue(
				is_dir( $base_dir . $dir ),
				"Directory {$dir} should exist"
			);
		}
	}

	/**
	 * Test that all main class files exist.
	 *
	 * @return void
	 */
	public function test_main_class_files_exist() {
		$base_dir = dirname( __DIR__ );

		$required_files = array(
			'/includes/main.php',
			'/includes/loader.php',
			'/includes/i18n.php',
			'/includes/activator.php',
			'/includes/deactivator.php',
			'/admin/Main.php',
			'/public/Main.php',
		);

		foreach ( $required_files as $file ) {
			$this->assertTrue(
				file_exists( $base_dir . $file ),
				"File {$file} should exist"
			);
		}
	}

	/**
	 * Test that composer.json contains correct configuration.
	 *
	 * @return void
	 */
	public function test_composer_json_configuration() {
		$composer_file = dirname( __DIR__ ) . '/composer.json';
		$this->assertTrue( file_exists( $composer_file ) );

		$composer_data = json_decode( file_get_contents( $composer_file ), true );

		// Test basic structure.
		$this->assertArrayHasKey( 'name', $composer_data );
		$this->assertArrayHasKey( 'autoload', $composer_data );
		$this->assertArrayHasKey( 'require-dev', $composer_data );

		// Test dev dependencies for testing.
		$this->assertArrayHasKey( 'phpunit/phpunit', $composer_data['require-dev'] );
		$this->assertArrayHasKey( 'squizlabs/php_codesniffer', $composer_data['require-dev'] );
		$this->assertArrayHasKey( 'phpstan/phpstan', $composer_data['require-dev'] );
	}

	/**
	 * Test that package.json contains correct scripts.
	 *
	 * @return void
	 */
	public function test_package_json_scripts() {
		$package_file = dirname( __DIR__ ) . '/package.json';
		$this->assertTrue( file_exists( $package_file ) );

		$package_data = json_decode( file_get_contents( $package_file ), true );

		// Test testing scripts exist.
		$this->assertArrayHasKey( 'scripts', $package_data );
		$this->assertArrayHasKey( 'test:php', $package_data['scripts'] );
		$this->assertArrayHasKey( 'lint:php', $package_data['scripts'] );
		$this->assertArrayHasKey( 'analyze:php', $package_data['scripts'] );
	}

	/**
	 * Test that phpunit.xml.dist configuration exists.
	 *
	 * @return void
	 */
	public function test_phpunit_configuration_exists() {
		$phpunit_file = dirname( __DIR__ ) . '/phpunit.xml.dist';
		$this->assertTrue( file_exists( $phpunit_file ) );

		$config_content = file_get_contents( $phpunit_file );

		// Test basic PHPUnit configuration elements.
		$this->assertStringContainsString( '<phpunit', $config_content );
		$this->assertStringContainsString( '<testsuites>', $config_content );
		$this->assertStringContainsString( 'bootstrap="tests/bootstrap.php"', $config_content );
	}

	/**
	 * Test that all test configuration files exist.
	 *
	 * @return void
	 */
	public function test_testing_configuration_files_exist() {
		$base_dir = dirname( __DIR__ );

		$config_files = array(
			'/phpunit.xml.dist',
			'/phpstan.neon.dist',
			'/phpcs.xml.dist',
			'/.wp-env.json',
			'/tests/bootstrap.php',
		);

		foreach ( $config_files as $file ) {
			$this->assertTrue(
				file_exists( $base_dir . $file ),
				"Configuration file {$file} should exist"
			);
		}
	}
}
