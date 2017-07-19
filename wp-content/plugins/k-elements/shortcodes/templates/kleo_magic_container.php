<?php
/**
 * Magic Container Shortcode
 * 
 * 
 * @package WordPress
 * @subpackage K Elements
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since K Elements 4.0
 */


$output = $content_position = $text_center = $div_center = $full_height = $position = $float = $height = $min_height = $width = $min_width = $top = $right = $bottom = $left
	= $border_radius = $box_shadow_x = $box_shadow_y = $box_shadow_blur = $box_shadow_spread = $box_shadow_color = $vertical_separator
	= $z_index = $css = $bg_pos_h = $bg_pos_v = $el_class = '';

extract(shortcode_atts(array(
	'css' => '',
	'bg_pos_h' => '',
	'bg_pos_v' => '',
	'content_position' => '',
	'text_center' => '',
	'div_center' => '',
	'full_height' => '',
	'position' => '',
	'float' => '',
	'height' => '',
	'min_height' => '',
	'width' => '',
	'min_width' => '',
	'top' => '',
	'right' => '',
	'bottom' => '',
	'left' => '',
	'border_radius' => '',
	'z_index' => '',
	'box_shadow_x' => '0',
	'box_shadow_y' => '0',
	'box_shadow_blur' => '0',
	'box_shadow_spread' => '0',
	'box_shadow_color' => '#000000',
	'vertical_separator' => '',
    'el_class' => '',

), $atts));

$el_attributes = $styles = $inner_attributes = array();
$classes = array( 'magic-container' );
$inner_classes = array( 'magic-inner sq-full-width' );

if ( $el_class != '' ) {
	$classes[] = $el_class;
}

if ( $css != '' ) {
	if (preg_match( '/\{((\s*?.*?)*?)\}/',  $css, $matches ) && isset( $matches[0] ) ) {
		$styles[] = rtrim( str_replace( array( '{', '}' ), '', esc_attr( trim( $matches[0] ) ) ), ';' );
	} else {
		$styles[] = esc_attr( trim( $css ) );
	}

}

if ( $content_position != '' ) {
	$classes[] = 'flexbox-container flexbox-' . $content_position;
}
if ( $text_center != '' ) {
	$classes[] = 'text-center';
}
if ( $div_center != '' ) {
	$classes[] = 'div-center';
}

if ( $position != '' ) {
	$styles[] = 'position: ' . $position;
}
if ( $float != '' ) {
	$styles[] = 'float: ' . $float;
}

$style_elements = array( 'height', 'min_height', 'width', 'min_width', 'top', 'right', 'bottom', 'left', 'border_radius' );

foreach ( $style_elements as $style_element ) {
	if ( ${$style_element} != '' ) {
		$styles[] = str_replace( '_', '-', $style_element ) . ':' . kleo_set_default_unit( ${$style_element} );
	}
}


if( $box_shadow_x != 0 || $box_shadow_y != 0 || $box_shadow_blur != 0 || $box_shadow_spread != 0) {
	$styles[] = 'box-shadow: '. (int)$box_shadow_x . 'px ' . (int)$box_shadow_y . 'px '
	          . (int)$box_shadow_blur . 'px ' . (int)$box_shadow_spread . 'px ' .$box_shadow_color;
}

if ($vertical_separator != '') {
	$classes[] = 'vertical-separator';
	if ($vertical_separator == 'dark') {
		$classes[] = 'vertical-dark';
	}
}


$position = array();
if ( $bg_pos_v != '' || $bg_pos_h != '' ) {
	$position[] = $bg_pos_h;
	$position[] = $bg_pos_v;
}
if ( ! empty( $position ) ) {
	$styles[] = 'background-position: ' . join( ' ', $position ) . ' !important';
}

if ( ! empty( $z_index ) ) {
	$styles[] = 'z-index: ' . (int)$z_index;
}

$el_attributes[] = 'class="' . implode( ' ', $classes ) . '"';
$el_attributes[] = 'style="' . implode( ';', $styles ) . '"';
$inner_attributes[] = 'class="' . implode( ' ', $inner_classes ) . '"';


$output .= '<div ' . implode( ' ', $el_attributes ) . '>';
$output .= '<div ' . implode( ' ', $inner_attributes ) . '>';
$output .= kleo_remove_wpautop( $content, true );
$output .= '</div>';
$output .= '</div>';