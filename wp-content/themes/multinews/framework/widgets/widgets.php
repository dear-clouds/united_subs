<?php
/*
  Forked from : https://wordpress.org/extend/plugins/widget-title-links/
  Many Thanks to plugin author : ragulka

*/
class mom_Widget_custom_fields {

  public function __construct() {
    load_plugin_textdomain( 'widget-title-links', false, basename( dirname( __FILE__ ) ) . '/languages' );

    add_action( 'in_widget_form', array( $this, 'add_custom_fields_to_widget_form' ), 1, 3 );

    add_filter( 'widget_form_callback', array( $this, 'register_widget_custom_field'), 10, 2 );
    add_filter( 'widget_update_callback', array( $this, 'widget_update_extend'), 10, 2 );
    add_filter( 'dynamic_sidebar_params', array( $this, 'widget_custom_field_output'), 99, 2 );
    add_action( 'admin_footer-widgets.php', array( $this, 'print_scripts' ), 9999 );
  }

  /**
   * Add Momizat custom fields to widget form
   *
   * @since 1.0
   * @uses add_action() 'in_widget_form'
   */
  public function add_custom_fields_to_widget_form( $widget, $args, $instance ) {
  ?>
  <div class="momizat_widget_custom_fields">
    <h4 class="custom_colors_title"><?php _e('Widget custom style','framework'); ?></h4>
    <fieldset>
      <p><label for="<?php echo $widget->get_field_id('header_background'); ?>"><?php _e('Widget title background', 'framework'); ?></label>
      <input type="text" name="<?php echo $widget->get_field_name('header_background'); ?>" id="<?php echo $widget->get_field_id('header_background'); ?>"" class="widefat mom-color-field" value="<?php echo $instance['header_background']; ?>"" /></p>
      <p><label for="<?php echo $widget->get_field_id('header_text_color'); ?>"><?php _e('Widget title text color', 'framework'); ?></label>
      <input type="text" name="<?php echo $widget->get_field_name('header_text_color'); ?>" id="<?php echo $widget->get_field_id('header_text_color'); ?>"" class="widefat mom-color-field" value="<?php echo $instance['header_text_color']; ?>"" /></p>
      <p><label for="<?php echo $widget->get_field_id('bg_color'); ?>"><?php _e('Widget background color', 'framework'); ?></label>
      <input type="text" name="<?php echo $widget->get_field_name('bg_color'); ?>" id="<?php echo $widget->get_field_id('bg_color'); ?>"" class="widefat mom-color-field" value="<?php echo $instance['bg_color']; ?>"" /></p>
      <p><label for="<?php echo $widget->get_field_id('bg_image'); ?>"><?php _e('Widget background image', 'framework'); ?></label></p>
      <input type="text" name="<?php echo $widget->get_field_name('bg_image'); ?>" id="<?php echo $widget->get_field_id('bg_image'); ?>"" value="<?php echo $instance['bg_image']; ?>"" />
      <input class="upload_image_button button button-primary" type="button" value="Upload Image" />
      <p></p>
    </fieldset>
  </div>
  <?php
  wp_enqueue_script( 'underscore' );
  wp_enqueue_script('media-upload');
  wp_enqueue_script('thickbox');
  wp_enqueue_style('thickbox');
  }


/**
 * Print scripts.
 *
 * @since 1.0
 */
public function print_scripts() {
    ?>
    <script>
            ( function( $ ){
                    function initColorPicker( widget ) {
                            widget.find( '.mom-color-field' ).wpColorPicker( {
                                    change: _.throttle( function() { // For Customizer
                                            $(this).trigger( 'change' );
                                    }, 3000 )
                            });
                    }

                    function onFormUpdate( event, widget ) {
                            initColorPicker( widget );
                    }

                    $( document ).on( 'widget-added widget-updated', onFormUpdate );

                    $( document ).ready( function() {
                            $( '#widgets-right .widget:has(.mom-color-field)' ).each( function () {
                                    initColorPicker( $( this ) );
                            } );
                    } );
            }( jQuery ) );

            jQuery(document).ready(function($) {
              $(document).on("click", ".upload_image_button", function() {

                  jQuery.data(document.body, 'prevElement', $(this).prev());

                  window.send_to_editor = function(html) {
                      var imgurl = jQuery('img',html).attr('src');
                      var inputText = jQuery.data(document.body, 'prevElement');

                      if(inputText != undefined && inputText != '')
                      {
                          inputText.val(imgurl);
                      }

                      tb_remove();
                  };

                  tb_show('', 'media-upload.php?type=image&TB_iframe=true');
                  return false;
              });
          });
    </script>
    <?php
}


  /**
   * Register the additional widget field
   *
   * @since 1.0
   * @uses add_filter() 'widget_form_callback'
   */
  public function register_widget_custom_field ( $instance, $widget ) {
    if ( !isset($instance['header_background']) )
      $instance['header_background'] = null;
    if ( !isset($instance['header_text_color']) )
      $instance['header_text_color'] = null;
    if ( !isset($instance['bg_color']) )
      $instance['bg_color'] = null;
    if ( !isset($instance['bg_image']) )
      $instance['bg_image'] = null;
        return $instance;
  }

  /**
   * Add the additional field to widget update callback
   *
   * @since 1.0
   * @uses add_filter() 'widget_update_callback'
   */
  public function widget_update_extend ( $instance, $new_instance ) {
    $instance['header_background'] =  $new_instance['header_background'];
    $instance['header_text_color'] =  $new_instance['header_text_color'];
    $instance['bg_color'] =  $new_instance['bg_color'];
    $instance['bg_image'] =  $new_instance['bg_image'];
    return $instance;
  }

  /**
   * Momizat custom fields output
   *
   * Title link should be set by editors
   * in widget settings in Appearance->Widgets
   *
   * @since 1.o
   * @uses add_filter() 'dynamic_sidebar_params'
   */
  public function widget_custom_field_output( $params ) {
    if (is_admin())
      return $params;

    global $wp_registered_widgets;
    $id = $params[0]['widget_id'];

    if (isset($wp_registered_widgets[$id]['callback'][0]) && is_object($wp_registered_widgets[$id]['callback'][0])) {
      // Get settings for all widgets of this type
      $settings = $wp_registered_widgets[$id]['callback'][0]->get_settings();

      // Get settings for this instance of the widget
      $instance = $settings[substr( $id, strrpos( $id, '-' ) + 1 )];

      // Allow overriding the title link programmatically via filters
      $hbg = isset($instance['header_background']) ? $instance['header_background'] : null;
      $htx = isset($instance['header_text_color']) ? $instance['header_text_color'] : null;
      $wbgc = isset($instance['bg_color']) ? $instance['bg_color'] : null;
      $wbi = isset($instance['bg_image']) ? $instance['bg_image'] : null;

      $hbg_hex = isset($instance['header_background']) ? $instance['header_background'] : null;


      if($wbgc != ''){
        $wbgc = 'background-color:'.$wbgc.';';
      }
      if($wbi != ''){
        $wbi = 'background-image: url('.$wbi.');background-position:center;background-size: cover;';
      }
      if ($hbg != '') {
        $hbg = 'background:'.$hbg.';border-color:'.$hbg.';';
      }
      if ($htx != '') {
        $htx_out = 'color:'.$htx.';';
      } else {
        $htx_out = '';
      }
      //echo '<pre>'; print_r($params[0]); echo '</pre>';
      if ($params[0]['name'] != 'Tabbed Widget' && strpos($params[0]['name'],'tabbed') === false && strpos($params[0]['name'],'Tabbed') === false ) {
          if(isset($params[0]['id']) && strpos($params[0]['id'],'footer') === false){
            if ($hbg != '' || $htx != '') {
              $params[0]['before_title'] = '<div class="widget-title"><h4 style="'.$hbg.''.$htx_out.'">';
            }
            if ($wbgc != '' || $wbi != '') {
            $params[0]['before_widget'] = '<div class="widget %2$s" style="'.$wbgc.''.$wbi.'">';
            }
          }
      } else {
          if(isset($params[0]['id']) && strpos($params[0]['id'],'footer') === false){
            if ($hbg != '' || $htx != '') {
              $params[0]['before_title'] = '<a href="#" class="mom-tw-title" style="'.$hbg.''.$htx_out.'"><span class="before" style="border-top-color:'.$hbg_hex.';"></span><span class="after" style="border-top-color:'.$hbg_hex.';"></span>';
            }
            if ($wbgc != '' || $wbi != '') {
            $params[0]['before_widget'] = '<div class="widget-tab" style="'.$wbgc.''.$wbi.'">';
            }
          }
      }

    }

    return $params;
  }
}

new mom_Widget_custom_fields();
