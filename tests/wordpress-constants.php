<?php
/**
 * WordPress constants for PHPStan analysis.
 *
 * @package WordPress_Plugin_Boilerplate
 */

// WordPress core constants.
define( 'ABSPATH', '/tmp/wordpress/' );
define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );
define( 'WP_PLUGIN_URL', 'http://localhost/wp-content/plugins' );
define( 'WPINC', 'wp-includes' );
define( 'WP_LANG_DIR', WP_CONTENT_DIR . '/languages' );
define( 'COOKIEHASH', md5( 'localhost' ) );
define( 'WP_USE_THEMES', true );
define( 'WP_DEBUG', false );
define( 'WP_DEBUG_LOG', false );
define( 'WP_DEBUG_DISPLAY', false );
define( 'SCRIPT_DEBUG', false );
define( 'WP_CACHE', false );
