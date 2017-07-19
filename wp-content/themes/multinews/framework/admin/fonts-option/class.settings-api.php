<?php

/**
 * weDevs Settings API wrapper class
 *
 * @version 1.1
 *
 * @author Tareq Hasan <tareq@weDevs.com>
 * @link http://tareq.weDevs.com Tareq's Planet
 * @example src/settings-api.php How to use the class
 */
if ( !class_exists( 'mom_multinews_Settings_API' ) ):
class mom_multinews_Settings_API {

    /**
     * settings sections array
     *
     * @var array
     */
    private $settings_sections = array();

    /**
     * Settings fields array
     *
     * @var array
     */
    private $settings_fields = array();

    /**
     * Singleton instance
     *
     * @var object
     */
    private static $_instance;

    public function __construct() {
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
    }

    /**
     * Enqueue scripts and styles
     */
    function admin_enqueue_scripts() {
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_media();
        wp_enqueue_script( 'wp-color-picker' );
        wp_enqueue_script( 'jquery' );

    }

    /**
     * Set settings sections
     *
     * @param array   $sections setting sections array
     */
    function set_sections( $sections ) {
        $this->settings_sections = $sections;

        return $this;
    }

    /**
     * Add a single section
     *
     * @param array   $section
     */
    function add_section( $section ) {
        $this->settings_sections[] = $section;

        return $this;
    }

    /**
     * Set settings fields
     *
     * @param array   $fields settings fields array
     */
    function set_fields( $fields ) {
        $this->settings_fields = $fields;

        return $this;
    }

    function add_field( $section, $field ) {
        $defaults = array(
            'name' => '',
            'label' => '',
            'desc' => '',
            'type' => 'text'
        );

        $arg = wp_parse_args( $field, $defaults );
        $this->settings_fields[$section][] = $arg;

        return $this;
    }

    /**
     * Initialize and registers the settings sections and fileds to WordPress
     *
     * Usually this should be called at `admin_init` hook.
     *
     * This function gets the initiated settings sections and fields. Then
     * registers them to WordPress and ready for use.
     */
    function admin_init() {
        //register settings sections
        foreach ( $this->settings_sections as $section ) {
            if ( false == get_option( $section['id'] ) ) {
                add_option( $section['id'] );
            }

            if ( isset($section['desc']) && !empty($section['desc']) ) {
                $section['desc'] = '<div class="inside">'.$section['desc'].'</div>';
                $callback = create_function('', 'echo "'.str_replace('"', '\"', $section['desc']).'";');
            } else if ( isset( $section['callback'] ) ) {
                $callback = $section['callback'];
            } else {
                $callback = null;
            }

            add_settings_section( $section['id'], '', $callback, $section['id'] );
        }

        //register settings fields
        foreach ( $this->settings_fields as $section => $field ) {
            foreach ( $field as $option ) {

                $type = isset( $option['type'] ) ? $option['type'] : 'text';

                $args = array(
                    'id' => $option['name'],
                    'label_for' => $args['label_for'] = "{$section}[{$option['name']}]",
                    'desc' => isset( $option['desc'] ) ? $option['desc'] : '',
                    'name' => $option['label'],
                    'section' => $section,
                    'size' => isset( $option['size'] ) ? $option['size'] : null,
                    'options' => isset( $option['options'] ) ? $option['options'] : '',
                    'std' => isset( $option['default'] ) ? $option['default'] : '',
                    'sanitize_callback' => isset( $option['sanitize_callback'] ) ? $option['sanitize_callback'] : '',
                    'type' => $type,
                );

               add_settings_field( $section . '[' . $option['name'] . ']', $option['label'], array( $this, 'callback_' . $type ), $section, $section, $args );
            }
        }

        // creates our settings in the options table
        foreach ( $this->settings_sections as $section ) {
            register_setting( $section['id'], $section['id'], array( $this, 'sanitize_options' ) );
        }
    }

    /**
     * Get field description for display
     *
     * @param array   $args settings field args
     */
    public function get_field_description( $args ) {
        if ( ! empty( $args['desc'] ) ) {
            $desc = sprintf( '<p class="description">%s</p>', $args['desc'] );
        } else {
            $desc = '';
        }

        return $desc;
    }

    /**
     * Displays a text field for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_text( $args ) {

        $value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
        $size = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';
        $type = isset( $args['type'] ) ? $args['type'] : 'text';

        $html = sprintf( '<input type="%1$s" class="%2$s-text" id="%3$s[%4$s]" name="%3$s[%4$s]" value="%5$s"/>', $type, $size, $args['section'], $args['id'], $value );
        $html .= $this->get_field_description( $args );

        echo $html;
    }

    /**
     * Displays a url field for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_url( $args ) {
        $this->callback_text( $args );
    }

    /**
     * Displays a number field for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_number( $args ) {
        $this->callback_text( $args );
    }

    /**
     * Displays a checkbox for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_checkbox( $args ) {

        $value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );

        $html = '<fieldset>';
        $html .= sprintf( '<label for="wpuf-%1$s[%2$s]">', $args['section'], $args['id'] );
        $html .= sprintf( '<input type="hidden" name="%1$s[%2$s]" value="off" />', $args['section'], $args['id'] );
        $html .= sprintf( '<input type="checkbox" class="checkbox" id="wpuf-%1$s[%2$s]" name="%1$s[%2$s]" value="on" %3$s />', $args['section'], $args['id'], checked( $value, 'on', false ) );
        $html .= sprintf( '%1$s</label>', $args['desc'] );
        $html .= '</fieldset>';

        echo $html;
    }

    /**
     * Displays a multicheckbox a settings field
     *
     * @param array   $args settings field args
     */
    function callback_multicheck( $args ) {

        $value = $this->get_option( $args['id'], $args['section'], $args['std'] );

        $html = '<fieldset>';
        foreach ( $args['options'] as $key => $label ) {
            $checked = isset( $value[$key] ) ? $value[$key] : '0';
            $html .= sprintf( '<label for="wpuf-%1$s[%2$s][%3$s]">', $args['section'], $args['id'], $key );
            $html .= sprintf( '<input type="checkbox" class="checkbox" id="wpuf-%1$s[%2$s][%3$s]" name="%1$s[%2$s][%3$s]" value="%3$s" %4$s />', $args['section'], $args['id'], $key, checked( $checked, $key, false ) );
            $html .= sprintf( '%1$s</label><br>',  $label );
        }
        $html .= $this->get_field_description( $args );
        $html .= '</fieldset>';

        echo $html;
    }

    function callback_repeater( $args ) {

        $value = $this->get_option( $args['id'], $args['section'], $args['std'] );
        $counter = 0;
        $html = '<div class="option-repeater-wrap">';
        if( is_array( $value ) ) {
            foreach ( $value as $v ) {
                $html .= sprintf( '<div class="option-repeater"><input type="text" class="repeater-input" id="wpuf-%1$s[%2$s][%4$s]" name="%1$s[%2$s][%4$s]" value="%3$s"/><a class="remove-this" href="#"><i class="dashicons-trash dashicons"></i></a></div>', $args['section'], $args['id'], $v, $counter);
                $counter++;
            }
        } else {
                $html .= sprintf( '<div class="option-repeater"><input type="text" class="repeater-input" id="wpuf-%1$s[%2$s][%4$s]" name="%1$s[%2$s][%4$s]" value="%3$s"/><a class="remove-this" href="#"><i class="dashicons-trash dashicons"></i></a></div>', $args['section'], $args['id'], $value, $counter);

        }
        $html .= '<a class="button add-new button-large" href="#" data-counter="'.$counter.'">'.__('Add New', 'theme').'</a>';
        $html .= $this->get_field_description( $args );
        $html .= '</div>';

        echo $html;
    }

        function callback_font_repeater( $args ) {

        $value = $this->get_option( $args['id'], $args['section'], $args['std'] );
        $size = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';
        $counter = 0;
        $label = isset( $args['options']['button_label'] ) ?
                        $args['options']['button_label'] :
                        __( 'Choose File' );

        $html = '<div class="option-repeater-wrap">';
        if( is_array( $value ) ) {
            foreach ( $value as $v ) {
        $html   .= '<div class="option-repeater fonts-repeater">';

        $html .= sprintf( '<input type="text" class="font-name" id="wpuf-%1$s[%2$s][%4$s][font_name]" name="%1$s[%2$s][%4$s][font_name]" value="%3$s" placeholder="'.__('Font Name', 'theme').'" />', $args['section'], $args['id'], $v['font_name'], $counter);

        $html  .='<div class="font-files-box"><span>'.__('Upload Font Files', 'theme').'</span>';
        $html  .= sprintf( '<input type="hidden" class="%1$s-text wpsa-url font-file-url" id="%2$s[%3$s][%5$s][ff]" name="%2$s[%3$s][%5$s][ff]" value="%4$s"/>', $size, $args['section'], $args['id'], $v['ff'], $counter );
        $html  .= '<button class="button wpsa-browse font-upload-button" data-type="ff"><i class="fa-icon-check"></i>TTF/OTF</button>';

        $html  .= sprintf( '<input type="hidden" class="%1$s-text wpsa-url font-file-url" id="%2$s[%3$s][%5$s][woff]" name="%2$s[%3$s][%5$s][woff]" value="%4$s"/>', $size, $args['section'], $args['id'], $v['woff'], $counter );
        $html  .= '<button class="button wpsa-browse font-upload-button" data-type="woff"><i class="fa-icon-check"></i>WOFF</button>';

        $html  .= sprintf( '<input type="hidden" class="%1$s-text wpsa-url font-file-url" id="%2$s[%3$s][%5$s][svg]" name="%2$s[%3$s][%5$s][svg]" value="%4$s"/>', $size, $args['section'], $args['id'], $v['svg'], $counter );
        $html  .= '<button class="button wpsa-browse font-upload-button" data-type="svg"><i class="fa-icon-check"></i>SVG</button>';

        $html  .= sprintf( '<input type="hidden" class="%1$s-text wpsa-url font-file-url" id="%2$s[%3$s][%5$s][eot]" name="%2$s[%3$s][%5$s][eot]" value="%4$s"/>', $size, $args['section'], $args['id'], $v['eot'], $counter );
        $html  .= '<button class="button wpsa-browse font-upload-button" data-type="eot"><i class="fa-icon-check"></i>EOT</button>';
        $html  .='</div>';

        $html .= '<a class="remove-this text" href="#">'.__('Delete font', 'theme').'</a>';
        $html  .= '</div>';

                $counter++;
            }
        } else {
          $html   .= '<div class="option-repeater fonts-repeater">';

        $html .= sprintf( '<input type="text" class="font-name" id="wpuf-%1$s[%2$s][%4$s][font_name]" name="%1$s[%2$s][%4$s][font_name]" value="%3$s" placeholder="'.__('Font Name', 'theme').'" />', $args['section'], $args['id'], '', $counter);

        $html  .='<div class="font-files-box"><span>'.__('Upload Font Files', 'theme').'</span>';
        $html  .= sprintf( '<input type="hidden" class="%1$s-text wpsa-url font-file-url" id="%2$s[%3$s][%5$s][ff]" name="%2$s[%3$s][%5$s][ff]" value="%4$s"/>', $size, $args['section'], $args['id'], '', $counter );
        $html  .= '<button class="button wpsa-browse font-upload-button" data-type="ff"><i class="fa-icon-check"></i>TTF/OTF</button>';

        $html  .= sprintf( '<input type="hidden" class="%1$s-text wpsa-url font-file-url" id="%2$s[%3$s][%5$s][woff]" name="%2$s[%3$s][%5$s][woff]" value="%4$s"/>', $size, $args['section'], $args['id'], '', $counter );
        $html  .= '<button class="button wpsa-browse font-upload-button" data-type="woff"><i class="fa-icon-check"></i>WOFF</button>';

        $html  .= sprintf( '<input type="hidden" class="%1$s-text wpsa-url font-file-url" id="%2$s[%3$s][%5$s][svg]" name="%2$s[%3$s][%5$s][svg]" value="%4$s"/>', $size, $args['section'], $args['id'], '', $counter );
        $html  .= '<button class="button wpsa-browse font-upload-button" data-type="svg"><i class="fa-icon-check"></i>SVG</button>';

        $html  .= sprintf( '<input type="hidden" class="%1$s-text wpsa-url font-file-url" id="%2$s[%3$s][%5$s][eot]" name="%2$s[%3$s][%5$s][eot]" value="%4$s"/>', $size, $args['section'], $args['id'], '', $counter );
        $html  .= '<button class="button wpsa-browse font-upload-button" data-type="eot"><i class="fa-icon-check"></i>EOT</button>';
        $html  .='</div>';

        $html .= '<a class="remove-this text" href="#">'.__('Delete font', 'theme').'</a>';
        $html  .= '</div>';
        }
        $html .= $this->get_field_description( $args );
        $html .= '</div>';
        $html .= '<a class="button add-new button-large" href="#" data-counter="'.$counter.'">'.__('Add New Font', 'theme').'</a>';

        echo $html;
    }
    /**
     * Displays a multicheckbox a settings field
     *
     * @param array   $args settings field args
     */
    function callback_radio( $args ) {

        $value = $this->get_option( $args['id'], $args['section'], $args['std'] );

        $html = '<fieldset>';
        foreach ( $args['options'] as $key => $label ) {
            $html .= sprintf( '<label for="wpuf-%1$s[%2$s][%3$s]">',  $args['section'], $args['id'], $key );
            $html .= sprintf( '<input type="radio" class="radio" id="wpuf-%1$s[%2$s][%3$s]" name="%1$s[%2$s]" value="%3$s" %4$s />', $args['section'], $args['id'], $key, checked( $value, $key, false ) );
            $html .= sprintf( '%1$s</label><br>', $label );
        }
        $html .= $this->get_field_description( $args );
        $html .= '</fieldset>';

        echo $html;
    }

    /**
     * Displays a selectbox for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_select( $args ) {

        $value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
        $size = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';

        $html = sprintf( '<select class="%1$s" name="%2$s[%3$s]" id="%2$s[%3$s]">', $size, $args['section'], $args['id'] );
        foreach ( $args['options'] as $key => $label ) {
            $html .= sprintf( '<option value="%s"%s>%s</option>', $key, selected( $value, $key, false ), $label );
        }
        $html .= sprintf( '</select>' );
        $html .= $this->get_field_description( $args );

        echo $html;
    }

    /**
     * Displays a textarea for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_textarea( $args ) {

        $value = esc_textarea( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
        $size = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';

        $html = sprintf( '<textarea rows="5" cols="55" class="%1$s-text" id="%2$s[%3$s]" name="%2$s[%3$s]">%4$s</textarea>', $size, $args['section'], $args['id'], $value );
        $html .= $this->get_field_description( $args );

        echo $html;
    }

    /**
     * Displays a textarea for a settings field
     *
     * @param array   $args settings field args
     * @return string
     */
    function callback_html( $args ) {
        echo $this->get_field_description( $args );
    }

    /**
     * Displays a rich text textarea for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_wysiwyg( $args ) {

        $value = $this->get_option( $args['id'], $args['section'], $args['std'] );
        $size = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : '500px';

        echo '<div style="max-width: ' . $size . ';">';

        $editor_settings = array(
            'teeny' => true,
            'textarea_name' => $args['section'] . '[' . $args['id'] . ']',
            'textarea_rows' => 10
        );
        if ( isset( $args['options'] ) && is_array( $args['options'] ) ) {
            $editor_settings = array_merge( $editor_settings, $args['options'] );
        }

        wp_editor( $value, $args['section'] . '-' . $args['id'], $editor_settings );

        echo '</div>';

        echo $this->get_field_description( $args );
    }



    /**
     * Displays a file upload field for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_file( $args ) {

        $value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
        $size = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';
        $id = $args['section']  . '[' . $args['id'] . ']';
        $label = isset( $args['options']['button_label'] ) ?
                        $args['options']['button_label'] :
                        __( 'Choose File' );

        $html  = sprintf( '<input type="text" class="%1$s-text wpsa-url" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s"/>', $size, $args['section'], $args['id'], $value );
        $html .= '<input type="button" class="button wpsa-browse" value="' . $label . '" />';
        $html .= $this->get_field_description( $args );

        echo $html;
    }

    /**
     * Displays a password field for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_password( $args ) {

        $value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
        $size = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';

        $html = sprintf( '<input type="password" class="%1$s-text" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s"/>', $size, $args['section'], $args['id'], $value );
        $html .= $this->get_field_description( $args );

        echo $html;
    }

    /**
     * Displays a color picker field for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_color( $args ) {

        $value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
        $size = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';

        $html = sprintf( '<input type="text" class="%1$s-text wp-color-picker-field" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s" data-default-color="%5$s" />', $size, $args['section'], $args['id'], $value, $args['std'] );
        $html .= $this->get_field_description( $args );

        echo $html;
    }

    /**
     * Sanitize callback for Settings API
     */
    function sanitize_options( $options ) {
        foreach( $options as $option_slug => $option_value ) {
            $sanitize_callback = $this->get_sanitize_callback( $option_slug );

            // If callback is set, call it
            if ( $sanitize_callback ) {
                $options[ $option_slug ] = call_user_func( $sanitize_callback, $option_value );
                continue;
            }
        }

        return $options;
    }

    /**
     * Get sanitization callback for given option slug
     *
     * @param string $slug option slug
     *
     * @return mixed string or bool false
     */
    function get_sanitize_callback( $slug = '' ) {
        if ( empty( $slug ) ) {
            return false;
        }

        // Iterate over registered fields and see if we can find proper callback
        foreach( $this->settings_fields as $section => $options ) {
            foreach ( $options as $option ) {
                if ( $option['name'] != $slug ) {
                    continue;
                }

                // Return the callback name
                return isset( $option['sanitize_callback'] ) && is_callable( $option['sanitize_callback'] ) ? $option['sanitize_callback'] : false;
            }
        }

        return false;
    }

    /**
     * Get the value of a settings field
     *
     * @param string  $option  settings field name
     * @param string  $section the section name this field belongs to
     * @param string  $default default text if it's not found
     * @return string
     */
    function get_option( $option, $section, $default = '' ) {

        $options = get_option( $section );

        if ( isset( $options[$option] ) ) {
            return $options[$option];
        }

        return $default;
    }

    /**
     * Show navigations as tab
     *
     * Shows all the settings section labels as tab
     */
    function show_navigation() {
        $html = '<h2 class="nav-tab-wrapper">';

        foreach ( $this->settings_sections as $tab ) {
            $html .= sprintf( '<a href="#%1$s" class="nav-tab" id="%1$s-tab">%2$s</a>', $tab['id'], $tab['title'] );
        }

        $html .= '</h2>';

        echo $html;
    }

    /**
     * Show the section settings forms
     *
     * This function displays every sections in a different form
     */
    function show_forms() {
        ?>
        <div class="metabox-holder">
			<?php foreach ( $this->settings_sections as $form ) { ?>
				<div id="<?php echo $form['id']; ?>" class="group" style="display: none;">
					<form method="post" action="options.php">
						<?php
						do_action( 'wsa_form_top_' . $form['id'], $form );
						settings_fields( $form['id'] );
						do_settings_sections( $form['id'] );
						do_action( 'wsa_form_bottom_' . $form['id'], $form );
						?>
						<div style="padding-left: 10px">
							<?php submit_button(); ?>
						</div>
					</form>
				</div>
			<?php } ?>
        </div>
        <?php
        $this->script();
    }

    /**
     * Tabbable JavaScript codes & Initiate Color Picker
     *
     * This code uses localstorage for displaying active tabs
     */
    function script() {
        ?>
        <script>
            jQuery(document).ready(function($) {
                //Initiate Color Picker
                $('.wp-color-picker-field').wpColorPicker();

                // Switches option sections
                $('.group').hide();
                var activetab = '';
                if (typeof(localStorage) != 'undefined' ) {
                    activetab = localStorage.getItem("activetab");
                }
                if (activetab != '' && $(activetab).length ) {
                    $(activetab).fadeIn();
                } else {
                    $('.group:first').fadeIn();
                }
                $('.group .collapsed').each(function(){
                    $(this).find('input:checked').parent().parent().parent().nextAll().each(
                    function(){
                        if ($(this).hasClass('last')) {
                            $(this).removeClass('hidden');
                            return false;
                        }
                        $(this).filter('.hidden').removeClass('hidden');
                    });
                });

                if (activetab != '' && $(activetab + '-tab').length ) {
                    $(activetab + '-tab').addClass('nav-tab-active');
                }
                else {
                    $('.nav-tab-wrapper a:first').addClass('nav-tab-active');
                }
                $('.nav-tab-wrapper a').click(function(evt) {
                    $('.nav-tab-wrapper a').removeClass('nav-tab-active');
                    $(this).addClass('nav-tab-active').blur();
                    var clicked_group = $(this).attr('href');
                    if (typeof(localStorage) != 'undefined' ) {
                        localStorage.setItem("activetab", $(this).attr('href'));
                    }
                    $('.group').hide();
                    $(clicked_group).fadeIn();
                    evt.preventDefault();
                });

                $('body').on('click', '.wpsa-browse', function (event) {
                    event.preventDefault();

                    var self = $(this);

                    // Create the media frame.
                    var file_frame = wp.media.frames.file_frame = wp.media({
                        title: self.data('uploader_title'),
                        button: {
                            text: self.data('uploader_button_text'),
                        },
                        multiple: false
                    });

                    file_frame.on('select', function () {
                        attachment = file_frame.state().get('selection').first().toJSON();

                        self.prev('.wpsa-url').val(attachment.url);

                        if (self.hasClass('font-upload-button')) {
                            type = self.data('type');
                            str = attachment.url;
                            if (type !== 'ff') { 
                                if (str.match(type+"$")) {
                                    self.find('i').removeClass('fa-icon-remove').addClass('active fa-icon-check');
                                } else {
                            self.find('i').removeClass('fa-icon-check').addClass('active fa-icon-remove');
                        }
                            } else {
                                if (str.match("ttf$") || str.match("otf$")) {
                                    self.find('i').removeClass('fa-icon-remove').addClass('active fa-icon-check');
                                } else {
                            self.find('i').removeClass('fa-icon-check').addClass('active fa-icon-remove');
                        }
                            }
                        }
                    });

                    // Finally, open the modal
                    file_frame.open();
                });

            // Font repeater
                $('.font-upload-button').each(function() {
                    self = $(this);
                    type = self.data('type');
                    str = $(this).prev().val();
                if (str !== '') {
                    if (type !== 'ff') { 
                        if (str.match(type+"$")) {
                            self.find('i').removeClass('fa-icon-remove').addClass('active fa-icon-check');
                        } else {
                            self.find('i').removeClass('fa-icon-check').addClass('active fa-icon-remove');
                        }
                    } else {
                        if (str.match("ttf$") || str.match("otf$")) {
                            self.find('i').removeClass('fa-icon-remove').addClass('active fa-icon-check');
                        } else {
                            self.find('i').removeClass('fa-icon-check').addClass('active fa-icon-remove');
                        }
                    }
                }

                });
            var counter =  $(".add-new").data('counter');
            $(".add-new").on("click", function(e){
                e.preventDefault();
                var t = $(this);

                // the loop object
                $loop = $(this).prev();

                $loop.find('.option-repeater:first-child').clone().addClass('new_one').appendTo($loop);
                $('.new_one').find('.active').removeClass('active');
                $loop.find('.new_one input').each(function(i) {
                    $(this).val('');
                    $(this).attr('name', $(this).attr('name').replace(/[0-9]+/, counter));
                    $(this).attr('id', $(this).attr('id').replace(/[0-9]+/, counter));
                });
                $loop.find('.new_one').removeClass('new_one');
               
                counter += 1;
            }); 
            $("body").on("click", '.remove-this', function(e){
                e.preventDefault();
                var yes = confirm("Are you sure you want delete this?");
                if (yes === true) {
                    if ($(this).parent().parent().find('.option-repeater').length > 1) {
                        $(this).parent().remove();
                    } else {
                        alert('You need at least one item.');
                    }
                }
            });

        });

        </script>
        <style>
                    /** WordPress 3.8 Fix **/
            .form-table th { padding: 20px 10px; }
            #wpbody-content .metabox-holder { padding-top: 5px; }
            #wpbody-content .metabox-holder input[type="text"] {
                width: 25em;
                padding:7px 10px;
                margin-bottom: 10px; 
            }
            a.remove-this:not(.text) {
                margin-left: 5px;
                padding: 7px 0;
                text-decoration: none;
                color: red;

            }
            a.remove-this {
                color: red;
            }
            a.remove-this i{
                line-height: 33px;

            }
            .button.add-new {
                background: #85be0a;
                border-color: #85be0a;
                color: #fff;
                box-shadow: none;
                -webkit-box-shadow: none;

            }

.option-repeater-wrap {
    overflow: hidden;
}
.option-repeater.fonts-repeater {
    background: #fff;
    clear: both;
    float: left;
    margin-bottom: 20px;
    padding: 20px;
}


.font-files-box {
    border: 1px solid #e5e5e5;
    margin-bottom: 10px;
    margin-top: 10px;
    padding: 20px 10px 10px;
    position: relative;
}

.font-files-box span {
    background: #fff none repeat scroll 0 0;
    left: 10px;
    padding: 0 10px;
    position: absolute;
    top: -10px;
}

.font-files-box .font-upload-button {
    margin-right: 5px;
        -webkit-transition: all 0.3s linear;
-moz-transition: all 0.3s linear;
-ms-transition: all 0.3s linear;
-o-transition: all 0.3s linear;
transition: all 0.3s linear;
}
.font-upload-button i {
    color: #85be0a;
    float: left;
    margin-right: 5px;
    -webkit-transition: all 0.3s linear;
-moz-transition: all 0.3s linear;
-ms-transition: all 0.3s linear;
-o-transition: all 0.3s linear;
transition: all 0.3s linear;
display: none;

-moz-transform: scale(0);
-webkit-transform: scale(0);
-o-transform: scale(0);
-ms-transform: scale(0);
transform: scale(0);
}

.font-upload-button i.active {
    display: block;
-moz-transform: scale(1);
-webkit-transform: scale(1);
-o-transform: scale(1);
-ms-transform: scale(1);
transform: scale(1);
}
.font-upload-button i.fa-icon-remove {
    color: red;
}
</style>

        <?php
    }

}
endif;