<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $css
 * @var $el_id
 * @var $content - shortcode content
 *
 * KLEO ADDED
 * $inner_container - default to no
 *
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Row_Inner
 */

/* KLEO ADDED */
$inner_container = '';

$el_class = $equal_height = $content_placement = $css = $el_id = '';
$output = $after_output = $bg_pos_h = $bg_pos_v = $fixed_height = $min_height = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$el_class = $this->getExtraClass( $el_class );
$css_classes = array(
	'vc_row',
	'wpb_row', //deprecated
	'vc_inner',
	'vc_row-fluid',
	$el_class,
	vc_shortcode_custom_css_class( $css ),
);

if (vc_shortcode_custom_css_has_property( $css, array('border', 'background') )) {
	$css_classes[]='vc_row-has-fill';
}

if (!empty($atts['gap'])) {
	$css_classes[] = 'vc_column-gap-'.$atts['gap'];
}

if ( ! empty( $equal_height ) ) {
	$flex_row = true;
	$css_classes[] = ' vc_row-o-equal-height';
}

if ( ! empty( $content_placement ) ) {
	$flex_row = true;
	$css_classes[] = ' vc_row-o-content-' . $content_placement;
}

if ( ! empty( $flex_row ) ) {
	$css_classes[] = ' vc_row-flex';
}

$wrapper_attributes = array();
// build attributes for wrapper
if ( ! empty( $el_id ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}

$css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $css_classes ) ), $this->settings['base'], $atts ) );
$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

/* KLEO ADDED */
$my_style = array();
$position = array();
if ( $bg_pos_v != '' || $bg_pos_h != '' ) {
	$position[] = $bg_pos_h;
	$position[] = $bg_pos_v;
}
if ( ! empty( $position ) ) {
	$my_style[] = 'background-position: ' . join( ' ', $position ) . ' !important';
}

if ( $fixed_height != '' && $fixed_height != 0 ) {
	$my_style[] = 'height: ' . kleo_set_default_unit( $fixed_height );
}
if ( $min_height != '' && $min_height != 0 ) {
	$my_style[] = 'min-height: ' . kleo_set_default_unit( $min_height );
}
if ( ! empty( $my_style ) ) {
	$my_style = implode( ';', $my_style );
	$my_style = wp_kses( $my_style, array() );
	$my_style = ' style="' . esc_attr( $my_style ) . '"';
	$wrapper_attributes[] = $my_style;
} else {
	$my_style = '';
}

/* KLEO ADDED */
$container_start = '';
$container_end   = '';
if ( $inner_container == 'yes' ) {
	$container_start = '<div class="section-container container">';
	$container_end   = '</div>';
}

$output .= '<div ' . implode( ' ', $wrapper_attributes ) . '>' . $container_start;
$output .= wpb_js_remove_wpautop( $content );
$output .= $container_end . '</div>';
$output .= $after_output;

echo $output;
