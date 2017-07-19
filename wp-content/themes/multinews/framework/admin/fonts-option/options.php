<?php
/**
 * WordPress settings API demo class
 *
 * @author Tareq Hasan
 */
if ( !class_exists('mom_multinews_Settings_API_Test' ) ):
class mom_multinews_Settings_API_Test {

    private $settings_api;

    function __construct() {
        $this->settings_api = new mom_multinews_Settings_API;

        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'admin_menu', array($this, 'admin_menu') );
    }

    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    function admin_menu() {
        add_submenu_page( 'momizat_options', __('Custom Fonts', 'theme'), __('Custom Fonts', 'theme'), 'manage_options', 'momizat_custom_fonts', array($this, 'plugin_page') );
    }

    function get_settings_sections() {
        $sections = array(
            array(
                'id' => 'mom_custom_fonts',
                'title' => __( 'Custom fonts', 'theme' ),
                'desc' => __('Add your custom fonts then use it directly from theme options')
            ),
        );
        return $sections;
    }

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    function get_settings_fields() {
        $settings_fields = array(

            'mom_custom_fonts' => array(
                array(
                    'name'              => 'custom_fonts',
                    'label'             => __( 'Fonts', 'theme' ),
                    'type'              => 'font_repeater',
                ),

            )
        );
      
        return $settings_fields;
    }

    function plugin_page() {
        echo '<div class="wrap">';

        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();

        echo '</div>';
    }

    /**
     * Get all the pages
     *
     * @return array page names with key value pairs
     */
    function get_pages() {
        $pages = get_pages();
        $pages_options = array();
        if ( $pages ) {
            foreach ($pages as $page) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }

        return $pages_options;
    }

}
endif;

new mom_multinews_Settings_API_Test;