<?php
// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Add EDD licences into the AcrossWP EDD licences menu
 */
function wordpress_plugin_boilerplate_edd_plugins_licenses( $licenses ) {

    $licenses[1000] = array(
        'id' 		=> 705,
        'key' 		=> WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_NAME_SLUG,
        'version'	=> WORDPRESS_PLUGIN_BOILERPLATE_VERSION,
        'name' 		=> WORDPRESS_PLUGIN_BOILERPLATE_PLUGIN_NAME
    );

    return $licenses;
}
add_filter( 'acrosswp_edd_plugins_licenses', 'wordpress_plugin_boilerplate_edd_plugins_licenses', 100, 1 );