<?php
/**
 * Shortcode attributes
 *
 * @todo add $icon_... defaults
 * @todo add $icon_typicons and etc
 *
 * @var $atts
 * @var $el_class
 * @var $message_box_style
 * @var $style
 * @var $color
 * @var $message_box_color
 * @var $css_animation
 * @var $icon_type
 * @var $icon_fontawesome
 * @var $content - shortcode content
 * @var $css
 *
 * KLEO ADDED
 * @var $animation
 *
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Message
 */

$atts = $this->convertAttributesToMessageBox2( $atts );
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

/* backward compatibility */
if ( empty( $css ) ) {
    $css = '';
}


$css_anim_class = '';
if ( $animation != '' ) {
    wp_enqueue_script( 'waypoints' );
    $css_anim_class .= " animated {$animation} {$css_animation}";
}

$elementClass = array(
    'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_message_box', $this->settings['base'], $atts ),
    'style' => 'vc_message_box-' . $message_box_style,
    'shape' => 'vc_message_box-' . $style,
    'color' => ( strlen( $color ) > 0 && strpos( 'alert', $color ) === false ) ? 'vc_color-' . $color : 'vc_color-' . $message_box_color,
    'css_animation' => $css_anim_class,

);

$class_to_filter = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

// Pick up icons
$iconClass = isset( ${"icon_" . $icon_type} ) ? ${"icon_" . $icon_type} : $defaultIconClass;
switch ( $color ) {
    case 'info':
        $icon_type = 'fontawesome';
        $iconClass = 'fa fa-info-circle';
        break;
    case 'alert-info':
        $icon_type = 'pixelicons';
        $iconClass = 'vc_pixel_icon vc_pixel_icon-info';
        break;
    case 'success':
        $icon_type = 'fontawesome';
        $iconClass = 'fa fa-check';
        break;
    case 'alert-success':
        $icon_type = 'pixelicons';
        $iconClass = 'vc_pixel_icon vc_pixel_icon-tick';
        break;
    case 'warning':
        $icon_type = 'fontawesome';
        $iconClass = 'fa fa-exclamation-triangle';
        break;
    case 'alert-warning':
        $icon_type = 'pixelicons';
        $iconClass = 'vc_pixel_icon vc_pixel_icon-alert';
        break;
    case 'danger':
        $icon_type = 'fontawesome';
        $iconClass = 'fa fa-times';
        break;
    case 'alert-danger':
        $icon_type = 'pixelicons';
        $iconClass = 'vc_pixel_icon vc_pixel_icon-explanation';
        break;
    case 'alert-custom':
    default:
        break;
}

if( $icon_type == 'fontello' ) {
    $iconClass = 'icon-' . $iconClass;
}

// Enqueue needed font for icon element
if ( 'pixelicons' !== $icon_type ) {
    vc_icon_element_fonts_enqueue( $icon_type );
}
?>
<div class="<?php echo esc_attr( $css_class ); ?>">
    <div class="vc_message_box-icon"><i class="<?php echo esc_attr( $iconClass ); ?>"></i>
    </div><?php echo wpb_js_remove_wpautop( $content, true );
    ?></div>