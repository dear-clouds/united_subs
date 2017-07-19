<?php
/*
Plugin Name: Organized - Visual Composer UI
Plugin URI: http://momizat.com/
Description: Make Visual composer more elegant and modern with <strong>Organized</strong>
Version: 0.6
Author: momizat
Author URI: http://momizat.com
License: GPLv2 or later
*/

// don't load directly
if (!defined('ABSPATH')) die('-1');

if ( !defined('WPB_VC_VERSION') ) { add_action('admin_notices', 'mom_org_vc_notice'); return; }
if (! function_exists('mom_org_vc_notice')) {
function mom_org_vc_notice() {
  $plugin_data = get_plugin_data(__FILE__);
  echo '
  <div class="updated">
    <p>'.sprintf(__('<strong>%s</strong> requires <strong><a href="http://goo.gl/baWnFt" target="_blank">Visual Composer</a></strong> plugin to be installed and activated on your site.', 'js_composer'), $plugin_data['Name']).'</p>
  </div>';
}
}

if (class_exists('WPBakeryVisualComposerAbstract')) {
// add own css
add_action('admin_print_scripts-post.php', 'mom_org_vc_admin_css');
add_action('admin_print_scripts-post-new.php', 'mom_org_vc_admin_css');
if (! function_exists('mom_org_vc_admin_css')) {
function mom_org_vc_admin_css() {
  wp_register_style( 'mom_vc_admin_css', MOM_URI . '/framework/organized/css/vc_admin.css' , array('js_composer') );
  wp_register_script( 'mom_vc_admin_js', MOM_URI . '/framework/organized/js/vc_admin.js' );

if ( 'vc_grid_item' != get_post_type() ) {
    wp_enqueue_style( 'mom_vc_admin_css' );
    wp_enqueue_script( 'mom_vc_admin_js' );
}

  // Translate VC Scripts
        wp_localize_script( 'wpb_js_composer_js_view', 'i18nLocale', array(
            'add_remove_picture' => __( 'Add/remove picture', 'js_composer' ),
            'finish_adding_text' => __( 'Finish Adding Images', 'js_composer' ),
            'add_image' => __( 'Add Image', 'js_composer' ),
            'add_images' => __( 'Add Images', 'js_composer' ),
            'main_button_title' => __( 'Page Builder', 'js_composer' ),
            'main_button_title_backend_editor' => __( 'Page Builder', 'js_composer' ),
            'main_button_title_frontend_editor' => __( 'FRONTEND EDITOR', 'js_composer' ),
            'main_button_title_revert' => __( 'Classic Editor', 'js_composer' ),
            'please_enter_templates_name' => __('Please enter template name', 'js_composer'),
            'confirm_deleting_template' => __('Confirm deleting "{template_name}" template, press Cancel to leave. This action cannot be undone.', 'js_composer'),
            'press_ok_to_delete_section' => __('Press OK to delete section, Cancel to leave', 'js_composer'),
            'drag_drop_me_in_column' => __('Drag and drop me in the column', 'js_composer'),
            'press_ok_to_delete_tab' => __('Press OK to delete "{tab_name}" tab, Cancel to leave', 'js_composer'),
            'slide' => __('Slide', 'js_composer'),
            'tab' => __('Tab', 'js_composer'),
            'section' => __('Section', 'js_composer'),
            'please_enter_new_tab_title' => __('Please enter new tab title', 'js_composer'),
            'press_ok_delete_section' => __('Press OK to delete "{tab_name}" section, Cancel to leave', 'js_composer'),
            'section_default_title' => __('Section', 'js_composer'),
            'please_enter_section_title' => __('Please enter new section title', 'js_composer'),
            'error_please_try_again' => __('Error. Please try again.', 'js_composer'),
            'if_close_data_lost' => __('If you close this window all shortcode settings will be lost. Close this window?', 'js_composer'),
            'header_select_element_type' => __('Select element type', 'js_composer'),
            'header_media_gallery' => __('Media gallery', 'js_composer'),
            'header_element_settings' => __('Element settings', 'js_composer'),
            'add_tab' => __('Add tab', 'js_composer'),
            'are_you_sure_convert_to_new_version' => __('Are you sure you want to convert to new version?', 'js_composer'),
            'loading' => __('Loading...', 'js_composer'),
            // Media editor
            'set_image' => __('Set Image', 'js_composer'),
            'are_you_sure_reset_css_classes' => __('Are you sure taht you want to remove all your data?', 'js_composer'),
            'loop_frame_title' => __('Loop settings', 'js_composer'),
            'enter_custom_layout' => __('Enter custom layout for your row:', 'js_composer'),
            'wrong_cells_layout' => __('Wrong row layout format! Example: 1/2 + 1/2 or span6 + span6.', 'js_composer'),
            'row_background_color' => __('Row background color', 'js_composer'),
            'row_background_image' => __('Row background image', 'js_composer'),
            'guides_on' => __('Guides ON', 'js_composer'),
            'guides_off' => __('Guides OFF', 'js_composer'),
            'template_save' => __('New template successfully saved!', 'js_composer'),
            'template_added' => __('Template added to the page.', 'js_composer'),
            'template_is_empty' => __('Nothing to save. Template is empty.', 'js_composer'),
            'css_updated' => __('Page settings updated!', 'js_composer'),
            'update_all' => __('Update all', 'js_composer'),
            'confirm_to_leave' => __('The changes you made will be lost if you navigate away from this page.', 'js_composer'),
            'inline_element_saved' => __('%s saved!', 'js_composer'),
            'inline_element_deleted' => __('%s deleted!', 'js_composer'),
            'inline_element_cloned' => __('%s cloned. <a href="#" class="vc-edit-cloned" data-model-id="%s">Edit now?</a>', 'js_composer')
        ) );


}

}
} // end if vc exists
