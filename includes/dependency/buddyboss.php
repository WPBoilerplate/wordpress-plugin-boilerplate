<?php

class BuddyBoss_Platform_Dependency extends WordPress_Plugins_Dependency {
    /**
     * Load this function on plugin load hook
     * Example: _e('<strong>BuddyBoss Sorting Option In Network Search</strong></a> requires the BuddyBoss Platform plugin to work. Please <a href="https://buddyboss.com/platform/" target="_blank">install BuddyBoss Platform</a> first.', 'wordpress-plugin-boilerplate');
     */
    function constact_not_define_text(){
        _e( 
            sprintf( 
                '<strong>%s</strong></a> requires the BuddyBoss Platform plugin to work. Please <a href="https://buddyboss.com/platform/" target="_blank">install BuddyBoss Platform</a> first.',
                $this->get_plugin_name()
            ),
            'wordpress-plugin-boilerplate'
        );
    }

    /**
     * Load this function on plugin load hook
     * Example: printf( __('<strong>BuddyBoss Sorting Option In Network Search</strong></a> requires BuddyBoss Platform plugin version %s or higher to work. Please update BuddyBoss Platform.', 'wordpress-plugin-boilerplate'), $this->mini_version() );
     */
    function constact_mini_version_text() {
        _e( 
            sprintf( 
                '<strong>%s</strong></a> requires BuddyBoss Platform plugin version %s or higher to work. Please update BuddyBoss Platform.',
                $this->get_plugin_name(),
                $this->mini_version()
            ),
            'wordpress-plugin-boilerplate'
        );
    }

    /**
     * Load this function on plugin load hook
     */
    function constact_name(){
        return 'BP_PLATFORM_VERSION';
    }

    /**
     * Load this function on plugin load hook
     */
    function mini_version(){
        return '2.3.0';
    }
}

new BuddyBoss_Platform_Dependency();