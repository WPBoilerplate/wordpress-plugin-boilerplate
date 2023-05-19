<?php
// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

abstract class Wordpress_Plugin_Boilerplate_Plugins_Dependency {

    function __construct() {

        add_filter( 'wordpress-plugin-boilerplate-load', array( $this, 'boilerplate_load' ) );

    }

    /**
     * Get the currnet plugin paths
     */
    public function get_plugin_name() {

        $plugin_data = get_plugin_data( WORDPRESS_PLUGIN_BOILERPLATE_FILES );
		return $plugin_data['Name'];
    }

    /**
     * Load this function on plugin load hook
     */
    public function boilerplate_load( $load ){

        if( empty( $this->constant_define() ) ) {
            $load = false;

            $this->constant_not_define_hook();

        } elseif ( $this->constant_define() && empty( $this->constant_mini_version() ) ) {
            $load = false;

            $this->constant_mini_version_hook();

        } elseif ( 
            ! empty( $this->component_required() ) 
            && $this->constant_define() 
            && ! empty( $this->constant_mini_version() ) 
            && empty( $this->required_component_is_active() ) 
        ) {
            $load = false;

            $this->component_required_hook();
        }

        return $load;
    }

    /**
     * Check if the Required Component is Active
     */
    public function required_component_is_active() {
        $is_active = false;
    }

    /**
     * Load this function on plugin load hook
     * Example:
     array(
        'members',
        'xprofile',
        'settings',
        'notifications',
        'groups',
        'forums',
        'activity',
        'media',
        'document',
        'video',
        'messages',
        'friends',
        'invites',
        'moderation',
        'search',
        'blogs',
     );
     */
    public function component_required() {
        return array();
    }

    /**
     * Load this function on plugin load hook
     */
    public function constant_define(){
        $string = (string) $this->constant_name();
        if ( defined( $string ) ) {
            return true;
        }
        return false;
    }

    /**
     * Load this function on plugin load hook
     */
    function constant_version(){
        return constant( $this->constant_name() );
    }

    /**
     * Load this function on plugin load hook
     */
    public function constant_mini_version(){

        if ( version_compare( $this->constant_version(), $this->mini_version() , '>=' ) ) {
            return true;
        }
        return false;
    }

    /**
     * Load this function on plugin load hook
     */
    public function error_message_hooks( $call ){
        if ( defined( 'WP_CLI' ) ) {
            WP_CLI::warning( $this->$call() );
        } else {
            add_action( 'admin_notices', array( $this, $call ) );
            add_action( 'network_admin_notices', array( $this, $call ) );
        }
    }

    /**
     * Load this function on plugin load hook
     */
    public function component_required_hook(){
        $this->error_message_hooks( 'component_required_message' );
    }

    /**
     * Load this function on plugin load hook
     */
    public function constant_not_define_hook(){
        $this->error_message_hooks( 'constant_not_define_message' );
    }

    /**
     * Load this function on plugin load hook
     */
    public function constant_mini_version_hook(){
        $this->error_message_hooks( 'constant_mini_version_message' );
    }

    /**
     * Load this function on plugin load hook
     */
    public function error_message( $call ){
        echo '<div class="error fade"><p>';
            $this->$call();
        echo '</p></div>';
    }

    /**
     * Load this function on plugin load hook
     */
    public function constant_not_define_message(){
        $this->error_message( 'constant_not_define_text' );
    }

    /**
     * Load this function on plugin load hook
     */
    public function component_required_message(){
        $this->error_message( 'component_required_text' );
    }

    /**
     * Load this function on plugin load hook
     */
    public function constant_mini_version_message(){
        $this->error_message( 'constant_mini_version_text' );
    }

    /**
     * Load this function on plugin load hook
     * Example: _e('<strong>BuddyBoss Sorting Option In Network Search</strong></a> requires the BuddyBoss Platform plugin to work. Please <a href="https://buddyboss.com/platform/" target="_blank">install BuddyBoss Platform</a> first.', 'buddyboss-sorting-option-in-network-search');
     */
    abstract function component_required_text();

    /**
     * Load this function on plugin load hook
     * Example: _e('<strong>BuddyBoss Sorting Option In Network Search</strong></a> requires the BuddyBoss Platform plugin to work. Please <a href="https://buddyboss.com/platform/" target="_blank">install BuddyBoss Platform</a> first.', 'buddyboss-sorting-option-in-network-search');
     */
    abstract function constant_not_define_text();

    /**
     * Load this function on plugin load hook
     * Example: printf( __('<strong>BuddyBoss Sorting Option In Network Search</strong></a> requires BuddyBoss Platform plugin version %s or higher to work. Please update BuddyBoss Platform.', 'buddyboss-sorting-option-in-network-search'), BP_PLATFORM_VERSION_MINI_VERSION );
     */
    abstract function constant_mini_version_text();

    /**
     * Load this function on plugin load hook
     */
    abstract function constant_name();

    /**
     * Load this function on plugin load hook
     */
    abstract function mini_version();
}