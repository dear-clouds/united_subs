<?php
/**
 * Redux Framework is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Redux Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Redux Framework. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package     ReduxFramework
 * @subpackage  Field_sicons
 * @author      Luciano "WebCaos" Ubertini
 * @author      Daniel J Griffiths (Ghost1227)
 * @author      Dovy Paukstys
 * @version     3.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// Don't duplicate me!
if (!class_exists('ReduxFramework_sicons')) {

    /**
     * Main ReduxFramework_sicons class
     *
     * @since       1.0.0
     */
    class ReduxFramework_sicons extends ReduxFramework{

        /**
         * Field Constructor.
         *
         * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        function __construct( $field = array(), $value ='', $parent ) {
        
            //parent::__construct( $parent->sections, $parent->args );
            $this->parent = $parent;
            $this->field = $field;
            $this->value = $value;
        }

        /**
         * Field Render Function.
         *
         * Takes the vars and outputs the HTML for the field in the settings
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function render() {

            //print_r($this->value);

            echo '<div class="redux-sicons-accordion">';

            $x = 0;

            $multi = (isset($this->field['multi']) && $this->field['multi']) ? ' multiple="multiple"' : "";

            if (isset($this->value) && is_array($this->value)) {

                $sicons = $this->value;

                foreach ($sicons as $icon) {
                    
                    if ( empty( $icon ) ) {
                        continue;
                    }

                    $defaults = array(
                        'title' => '',
                        'description' => '',
                        'sort' => '',
                        'url' => '',
                        'image' => '',
                        'thumb' => '',
                        'attachment_id' => '',
                        'height' => '',
                        'width' => '',
                        'select' => array(),
                    );
                    $icon = wp_parse_args( $icon, $defaults );

                    if ( empty( $icon['thumb'] ) && !empty( $icon['attachment_id'] ) ) {
                        $img = wp_get_attachment_image_src($icon['attachment_id'], 'full');
                        $icon['image'] = $img[0];
                        $icon['width'] = $img[1];
                        $icon['height'] = $img[2];
                    }

                    echo '<div class="redux-sicons-accordion-group"><fieldset class="redux-field" data-id="'.$this->field['id'].'"><h3><span class="redux-sicons-header">' . $icon['title'] . '</span></h3><div>';

                    $hide = '';
                    if ( empty( $icon['image'] ) ) {
                        $hide = ' hide';
                    }


                    echo '<div class="screenshot sicon-screenshot screenshot-'. $x . $hide . '">';
                    echo '<a class="of-uploaded-image" href="' . $icon['image'] . '">';
                    echo '<img class="redux-sicons-image redux-option-image" id="image_image_id_' . $x . '" src="' . $icon['thumb'] . '" alt="" target="_blank" rel="external" />';
                    echo '</a>';
                    echo '</div>';

                echo '<div class="mom_icons_selector">';
                echo '<span class="icon_prv" id="icon_prv_'.$x.'" data-id="'.$x.'"><a href="#" class="remove_icon enotype-icon-cross2" title="Remove Icon"></a></span><div class="clear"></div>';
                    echo '<div class="redux_sicons_add_remove">';
                echo '</li>';
                
                echo '<a class="button select_icon mom_select_icon_sicon" data-id="' . $this->field['id'] . '" data-x="'. $x . '" title="Select Icon">' . __('Select Icon', 'redux-framework') . '</a><span class="bt-sep">OR</span> ';
                echo '<input type="hidden" class="mom_icon_holder selected_icon" data-id="'.$x.'" id="selected-icon-'.$x.'" name="' . $this->field['name'] . '[' . $x . '][icon]" id="' . $this->field['id'] . '-selected_icon_' . $x . '" value="' . $icon['icon'] . '" /><span class="button upload_custom_sicon" id="add_' . $x . '" data-x="'. $x . '">' . __('Upload Icon', 'redux-framework') . '</span>';
                echo '</div>';

                    $hide = '';
                    if ( empty( $icon['image'] ) || $icon['image'] == '' ) {
                        $hide = ' hide';
                    }

                    echo '<span class="button remove-image' . $hide . '" id="reset_' . $x . '" rel="' . $icon['attachment_id'] . '">' . __('Remove', 'redux-framework') . '</span>';

                    echo '</div>' . "\n";

                    echo '<ul id="' . $this->field['id'] . '-ul" class="redux-sicons-list">';
                    $placeholder = (isset($this->field['placeholder']['title'])) ? esc_attr($this->field['placeholder']['title']) : __( 'Title', 'redux-framework' );
                    echo '<li><input type="text" id="' . $this->field['id'] . '-title_' . $x . '" name="' . $this->field['name'] . '[' . $x . '][title]" value="' . esc_attr($icon['title']) . '" placeholder="'.$placeholder.'" class="full-text icon-title" /></li>';
                    $placeholder = (isset($this->field['placeholder']['url'])) ? esc_attr($this->field['placeholder']['url']) : __( 'URL', 'redux-framework' );
                    echo '<li><input type="text" id="' . $this->field['id'] . '-url_' . $x . '" name="' . $this->field['name'] . '[' . $x . '][url]" value="' . esc_attr($icon['url']) . '" class="full-text" placeholder="'.$placeholder.'" /></li>';
                    echo '<li class="color_field_container"><label>Background Color on hover: </label><br><div class="sicon-color-wrap"><input type="text" id="' . $this->field['id'] . '-bgcolorh_' . $x . '" name="' . $this->field['name'] . '[' . $x . '][bgcolorh]" value="' . esc_attr($icon['bgcolorh']) . '" class="redux-color redux-color-init  wp-color-picker mom-color-field" placeholder="'.__('color', 'redux-framework').'" /></div></li>';
                    echo '<li><input type="hidden" class="icon-sort" name="' . $this->field['name'] . '[' . $x . '][sort]" id="' . $this->field['id'] . '-sort_' . $x . '" value="' . $icon['sort'] . '" />';
                    echo '<li><input type="hidden" class="upload-id icon_img_id" data-x="'.$x.'" name="' . $this->field['name'] . '[' . $x . '][attachment_id]" id="' . $this->field['id'] . '-image_id_' . $x . '" value="' . $icon['attachment_id'] . '" />';
                    echo '<input type="hidden" class="upload-thumbnail" name="' . $this->field['name'] . '[' . $x . '][thumb]" id="' . $this->field['id'] . '-thumb_url_' . $x . '" value="' . $icon['thumb'] . '" readonly="readonly" />';
                    echo '<input type="hidden" class="upload" name="' . $this->field['name'] . '[' . $x . '][image]" id="' . $this->field['id'] . '-image_url_' . $x . '" value="' . $icon['image'] . '" readonly="readonly" />';
                    echo '<input type="hidden" class="upload-height" name="' . $this->field['name'] . '[' . $x . '][height]" id="' . $this->field['id'] . '-image_height_' . $x . '" value="' . $icon['height'] . '" />';
                    echo '<input type="hidden" class="upload-width" name="' . $this->field['name'] . '[' . $x . '][width]" id="' . $this->field['id'] . '-image_width_' . $x . '" value="' . $icon['width'] . '" /></li>';
                    echo '<li><a href="javascript:void(0);" class="button deletion redux-sicons-remove">' . __('Delete', 'redux-framework') . '</a></li>';
                    echo '</ul></div></fieldset></div>';
                    $x++;
                
                }
            }

            if ($x == 0) {
                         echo '<div class="redux-sicons-accordion-group"><fieldset class="redux-field" data-id="'.$this->field['id'].'"><h3><span class="redux-sicons-header">' . $icon['title'] . '</span></h3><div>';

                    $hide = '';
                    if ( empty( $icon['image'] ) ) {
                        $hide = ' hide';
                    }


                    echo '<div class="screenshot sicon-screenshot screenshot-'. $x . $hide . '">';
                    echo '<a class="of-uploaded-image" href="' . $icon['image'] . '">';
                    echo '<img class="redux-sicons-image redux-option-image" id="image_image_id_' . $x . '" src="' . $icon['thumb'] . '" alt="" target="_blank" rel="external" />';
                    echo '</a>';
                    echo '</div>';

                echo '<div class="mom_icons_selector">';
                echo '<span class="icon_prv" id="icon_prv_'.$x.'" data-id="'.$x.'"><a href="#" class="remove_icon enotype-icon-cross2" title="Remove Icon"></a></span><div class="clear"></div>';
                    echo '<div class="redux_sicons_add_remove">';
                echo '</li>';
                
                echo '<a class="button select_icon mom_select_icon_sicon" data-id="' . $this->field['id'] . '" data-x="'. $x . '" title="Select Icon">' . __('Select Icon', 'redux-framework') . '</a><span class="bt-sep">OR</span> ';
                echo '<input type="hidden" class="mom_icon_holder selected_icon" data-id="'.$x.'" id="selected-icon-'.$x.'" name="' . $this->field['name'] . '[' . $x . '][icon]" id="' . $this->field['id'] . '-selected_icon_' . $x . '" value="' . $icon['icon'] . '" /><span class="button upload_custom_sicon" id="add_' . $x . '" data-x="'. $x . '">' . __('Upload Icon', 'redux-framework') . '</span>';
                echo '</div>';

                    $hide = '';
                    if ( empty( $icon['image'] ) || $icon['image'] == '' ) {
                        $hide = ' hide';
                    }

                    echo '<span class="button remove-image' . $hide . '" id="reset_' . $x . '" rel="' . $icon['attachment_id'] . '">' . __('Remove', 'redux-framework') . '</span>';

                    echo '</div>' . "\n";

                    echo '<ul id="' . $this->field['id'] . '-ul" class="redux-sicons-list">';
                    $placeholder = (isset($this->field['placeholder']['title'])) ? esc_attr($this->field['placeholder']['title']) : __( 'Title', 'redux-framework' );
                    echo '<li><input type="text" id="' . $this->field['id'] . '-title_' . $x . '" name="' . $this->field['name'] . '[' . $x . '][title]" value="' . esc_attr($icon['title']) . '" placeholder="'.$placeholder.'" class="full-text icon-title" /></li>';
                    $placeholder = (isset($this->field['placeholder']['url'])) ? esc_attr($this->field['placeholder']['url']) : __( 'URL', 'redux-framework' );
                    echo '<li><input type="text" id="' . $this->field['id'] . '-url_' . $x . '" name="' . $this->field['name'] . '[' . $x . '][url]" value="' . esc_attr($icon['url']) . '" class="full-text" placeholder="'.$placeholder.'" /></li>';
                    echo '<li class="color_field_container"><label>Background Color on hover: </label><br><div class="sicon-color-wrap"><input type="text" id="' . $this->field['id'] . '-bgcolorh_' . $x . '" name="' . $this->field['name'] . '[' . $x . '][bgcolorh]" value="' . esc_attr($icon['bgcolorh']) . '" class="redux-color redux-color-init  wp-color-picker mom-color-field" placeholder="'.__('color', 'redux-framework').'" /></div></li>';
                    echo '<li><input type="hidden" class="icon-sort" name="' . $this->field['name'] . '[' . $x . '][sort]" id="' . $this->field['id'] . '-sort_' . $x . '" value="' . $icon['sort'] . '" />';
                    echo '<li><input type="hidden" class="upload-id icon_img_id" data-x="'.$x.'" name="' . $this->field['name'] . '[' . $x . '][attachment_id]" id="' . $this->field['id'] . '-image_id_' . $x . '" value="' . $icon['attachment_id'] . '" />';
                    echo '<input type="hidden" class="upload-thumbnail" name="' . $this->field['name'] . '[' . $x . '][thumb]" id="' . $this->field['id'] . '-thumb_url_' . $x . '" value="' . $icon['thumb'] . '" readonly="readonly" />';
                    echo '<input type="hidden" class="upload" name="' . $this->field['name'] . '[' . $x . '][image]" id="' . $this->field['id'] . '-image_url_' . $x . '" value="' . $icon['image'] . '" readonly="readonly" />';
                    echo '<input type="hidden" class="upload-height" name="' . $this->field['name'] . '[' . $x . '][height]" id="' . $this->field['id'] . '-image_height_' . $x . '" value="' . $icon['height'] . '" />';
                    echo '<input type="hidden" class="upload-width" name="' . $this->field['name'] . '[' . $x . '][width]" id="' . $this->field['id'] . '-image_width_' . $x . '" value="' . $icon['width'] . '" /></li>';
                    echo '<li><a href="javascript:void(0);" class="button deletion redux-sicons-remove">' . __('Delete', 'redux-framework') . '</a></li>';
                    echo '</ul></div></fieldset></div>';
            }
            echo '</div><a href="javascript:void(0);" class="button redux-sicons-add button-primary" rel-id="' . $this->field['id'] . '-ul" rel-name="' . $this->field['name'] . '[title][]">' . __('Add icon', 'redux-framework') . '</a><br/>';
            
        }         

        /**
         * Enqueue Function.
         *
         * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */

        public function enqueue() {


            wp_enqueue_script(
                'redux-field-media-js',
                ReduxFramework::$_url . 'inc/fields/media/field_media.js',
                array( 'jquery', 'wp-color-picker' ),
                time(),
                true
            );

            wp_enqueue_style(
                'redux-field-media-css',
                ReduxFramework::$_url . 'inc/fields/media/field_media.css',
                time(),
                true
            );            

            wp_enqueue_script(
                'redux-field-sicons-js',
                ReduxFramework::$_url . 'inc/fields/sicons/field_sicons.js',
                array('jquery', 'jquery-ui-core', 'jquery-ui-accordion', 'wp-color-picker'),
                time(),
                true
            );

            wp_enqueue_style(
                'redux-field-sicons-css',
                ReduxFramework::$_url . 'inc/fields/sicons/field_sicons.css',
                time(),
                true
            );
            wp_enqueue_style(  'thickbox'); 
            wp_enqueue_script(  'thickbox');
            

        }

    }
}