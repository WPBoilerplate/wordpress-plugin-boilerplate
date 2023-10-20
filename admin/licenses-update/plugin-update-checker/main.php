<?php
// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Add Github Plugin update checker into the AcrossWP Github Plugin Update Checker
 */
function wordpress_plugin_boilerplate_plugins_update_checker_github( $packages ) {

    $packages[1000] = array(
        'repo' 		        => 'https://github.com/acrosswp/wordpress-plugin-boilerplate',
        'file_path' 		=> WORDPRESS_PLUGIN_BOILERPLATE_FILES,
        'plugin_name_slug'	=> WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_NAME_SLUG,
        'release_branch' 	=> 'main'
    );

    return $packages;
}
add_filter( 'acrosswp_plugins_update_checker_github', 'wordpress_plugin_boilerplate_plugins_update_checker_github', 100, 1 );
