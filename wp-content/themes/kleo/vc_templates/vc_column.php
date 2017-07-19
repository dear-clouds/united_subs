<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $width
 * @var $css
 * @var $offset
 * @var $content - shortcode content
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Column
 */
$el_class = $width = $css = $offset = '';
$output = '';

/* KLEO ADDED */
$bg_gradient = $z_index = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

//$width = wpb_translateColumnWidthToSpan( $width );
$width = kleo_translateColumnWidth( $width );
$width = vc_column_offset_class_merge( $offset, $width );

$extra_inner_class= '';
if ($bg_gradient != '') {
	$extra_inner_class = ' kleo-gradient';
}

$css_classes = array(
    $this->getExtraClass( $el_class ),
    'wpb_column',
    //'column_container',
	'vc_column_container',
    $width,
);

if (vc_shortcode_custom_css_has_property( $css, array('border', 'background') )) {
	$css_classes[]='vc_col-has-fill';
}

$wrapper_attributes = array();

/* KLEO ADDED */
if ( $z_index != '' ) {
	$wrapper_attributes[] = 'style="z-index: ' . $z_index . ';"';
}

$css_class = preg_replace( '/vc_span(\d{1,2})/', 'col-sm-$1', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $css_classes ) ), $this->settings['base'], $atts ) );
$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

$output .= '<div ' . implode( ' ', $wrapper_attributes ) . '>';
$output .= '<div class="vc_column-inner ' . esc_attr( trim( vc_shortcode_custom_css_class( $css ) ) ) . $extra_inner_class . '">';
$output .= '<div class="wpb_wrapper">';
$output .= wpb_js_remove_wpautop( $content );
$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

echo $output;