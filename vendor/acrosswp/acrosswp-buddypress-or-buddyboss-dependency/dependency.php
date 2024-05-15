<?php
// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Check if the class does not exits then only allow the file to add
 */
if( ! class_exists( 'AcrossWP_BuddyPress_BuddyBoss_Platform_Dependency' ) ) {
    class AcrossWP_BuddyPress_BuddyBoss_Platform_Dependency extends AcrossWP_Plugins_Dependency {

        /**
         * Load this function on plugin load hook
         * Example: _e('<strong>BuddyBoss Sorting Option In Network Search</strong></a> requires the BuddyBoss Platform plugin to work. Please <a href="https://buddyboss.com/platform/" target="_blank">install BuddyBoss Platform</a> first.', 'sorting-option-in-network-search-for-buddyboss');
         */
        function constant_not_define_text(){
            printf( 
                __( 
                    '<strong>%s</strong></a> requires the BuddyPress or BuddyBoss Platform plugin to work. Please <a href="https://wordpress.org/plugins/buddypress/" target="_blank">install BuddyPress</a> or <a href="https://buddyboss.com/platform/" target="_blank">install BuddyBoss Platform</a> first.',
                    'acrosswp'
                ),
                $this->get_plugin_name()
            );
        }

        /**
         * Load this function on plugin load hook
         * Example: printf( __('<strong>BuddyBoss Sorting Option In Network Search</strong></a> requires BuddyBoss Platform plugin version %s or higher to work. Please update BuddyBoss Platform.', 'sorting-option-in-network-search-for-buddyboss'), $this->mini_version() );
         */
        function constant_mini_version_text() {
            printf( 
                __( 
                    '<strong>%s</strong></a> requires BuddyBoss Platform plugin version %s or higher to work. Please update BuddyBoss Platform.',
                    'acrosswp'
                ),
                $this->get_plugin_name(),
                $this->mini_version()
            );
        }

        /**
         * Load this function on plugin load hook
         * Example: printf( __('<strong>BuddyBoss Sorting Option In Network Search</strong></a> requires BuddyBoss Platform plugin version %s or higher to work. Please update BuddyBoss Platform.', 'sorting-option-in-network-search-for-buddyboss'), $this->mini_version() );
         */
        function component_required_text() {

            $bb_components = bp_core_get_components();
            $component_required = $this->component_required();
            $active_components = apply_filters( 'bp_active_components', bp_get_option( 'bp-active-components' ) );
            $component_required_label = array();

            foreach( $bb_components as $key => $bb_component ) {
                if( in_array( $key, $component_required ) ) {
                    $component_required_label[] = '<strong>' . $bb_component['title'] . '</strong>';
                }
            }

            if( count( $component_required_label ) > 1 ) {
                $last = array_pop( $component_required_label );
                $component_required_label = implode( ', ', $component_required_label ) . ' and ' . $last;
            } else {
                $component_required_label = $component_required_label[0];
            }

            printf( 
                __( 
                    '<strong>%s</strong></a> requires BuddyBoss Platform %s Component to work. Please Active the mentions Component.',
                    'acrosswp'
                ),
                $this->get_plugin_name(),
                $component_required_label
            );
        }


        /**
         * Load this function on plugin load hook
         */
        function constant_name(){
            return array( 'BP_VERSION', 'BP_PLATFORM_VERSION' );
        }

        /**
         * Load this function on plugin load hook
         */
        function mini_version() {

            if ( defined( 'BP_PLATFORM_VERSION' ) ) {
                return '2.3.0';
            }

            return '11.3.1';
        }

        /**
         * Load this function on plugin load hook
         */
        public function component_required() {
            return array();
        }

        /**
         * Load this function on plugin load hook
         * This was done to support BuddyPress and BuddyBoss Platform
         */
        public function constant_define(){

            $return = false;
            $constants = $this->constant_name();
            foreach( $constants as $constant ) {
                $constant = (string) $constant;
                if ( defined( $constant ) ) {
                    $return = true;
                }
            }

            return $return;
        }

        /**
         * Load this function on plugin load hook
         */
        public function constant_mini_version(){

            $return = false;
    
            $constant_versions = $this->constant_name();
            foreach( $constant_versions as $constant_version ) {

                $constant = $this->constant_version( $constant_version );
                if ( ! empty( $constant ) && version_compare( $constant, $this->mini_version() , '>=' ) ) {
                    $return = true;
                }
            }
            return $return;
        }
    }
}