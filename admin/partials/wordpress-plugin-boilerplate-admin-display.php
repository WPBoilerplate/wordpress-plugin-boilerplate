<?php
// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://acrosswp.com
 * @since      1.0.0
 *
 * @package    Wordpress_Plugin_Boilerplate
 * @subpackage Wordpress_Plugin_Boilerplate/admin/partials
 */

/**
 * Setup Compatibility integration admin tab class.
 *
 * @since BuddyBoss 1.0.0
 */
class Wordpress_Plugin_Boilerplate_Admin_Integration_Tab extends BP_Admin_Integration_tab {
	public function initialize() {
		$this->tab_order       = 60;
	}

	public function is_active() {
		return true;
	}

	function is_addon_field_enabled( $default = 1 ) {
		return (bool) get_option( 'wordpress_plugin_boilerplate_field', $default );
	}

	function settings_callback_field() {
		?>
        <input name="wordpress_plugin_boilerplate_field"
               id="wordpress_plugin_boilerplate_field"
               type="checkbox"
               value="1"
			<?php checked( $this->is_addon_field_enabled() ); ?>
        />
        <label for="wordpress_plugin_boilerplate_field">
			<?php _e( 'Enable this option', 'buddyboss-platform-addon' ); ?>
        </label>
		<?php
	}

	public function get_settings_fields() {
		$fields = array();

		$fields['wordpress_plugin_boilerplate_settings_section'] = array(

			'wordpress_plugin_boilerplate_field' => array(
				'title'             => __( 'Add-on Field', 'wordpress-plugin-boilerplate' ),
				'callback'          => array( $this, 'settings_callback_field' ),
				'sanitize_callback' => 'absint',
				'args'              => array(),
			),

		);

		return $fields;
	}

    /**
     * Add the setting fields for the add-on
     */
    public function get_settings_fields_for_section() {
        // Bail if section is empty
		if ( empty( $section_id ) ) {
			return false;
		}

		$fields = $this->get_settings_fields();
		return isset( $fields[ $section_id ] ) ? $fields[ $section_id ] : false;
    }

    /**
     * Add the setting fields for the add-on
     */
    public function get_settings_sections() {
        return array(
			'wordpress_plugin_boilerplate_settings_section' => array(
				'page'  => 'addon',
				'title' => __( 'Add-on Settings', 'wordpress-plugin-boilerplate' ),
			),
		);
    }

	/**
	 * Register setting fields
	 */
	public function register_fields() {

		$sections = $this->get_settings_sections();

		foreach ( (array) $sections as $section_id => $section ) {

			// Only add section and fields if section has fields
			$fields = $this->get_settings_fields_for_section( $section_id );

			if ( empty( $fields ) ) {
				continue;
			}

			$section_title    = ! empty( $section['title'] ) ? $section['title'] : '';
			$section_callback = ! empty( $section['callback'] ) ? $section['callback'] : false;

			// Add the section
			$this->add_section( $section_id, $section_title, $section_callback );

			// Loop through fields for this section
			foreach ( (array) $fields as $field_id => $field ) {

				$field['args'] = isset( $field['args'] ) ? $field['args'] : array();

				if ( ! empty( $field['callback'] ) && ! empty( $field['title'] ) ) {
					$sanitize_callback = isset( $field['sanitize_callback'] ) ? $field['sanitize_callback'] : [];
					$this->add_field( $field_id, $field['title'], $field['callback'], $sanitize_callback, $field['args'] );
				}
			}
		}
	}
}