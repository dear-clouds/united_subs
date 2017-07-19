<?php
/**
 * DIVIDER Shortcode
 * [kleo_divider type="full|long|double|short" double="yes|no" position="center|left|right" text="" class="" id=""]
 * 
 * @package WordPress
 * @subpackage K Elements
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since K Elements 1.0
 */

$output = $icon_el = '';
extract( shortcode_atts( array(
		'id'    => '',
		'class' => '',
		'style' => '',
		'type'  => 'full',
		'double' => false,
		'icon_type' => 'fontello',
		'icon_fontawesome' => '',
		'icon_openiconic' => '',
		'icon_typicons' => '',
		'icon_entypo' => '',
		'icon_linecons' => '',
		'icon_pixelicons' => '',
		'icon' => '',
		'icon_size' => '',
		'position' => 'center',
		'text' => '',
		
), $atts ) );

$id    = ( $id    != '' ) ? 'id="' . esc_attr( $id ) . '"' : '';
$class = ( $class != '' ) ? 'hr-title ' . esc_attr( $class ) : 'hr-title';
$style = ( $style != '' ) ? $style : '';

if ($type) {
	$class .= ' hr-' . $type;
}
if ($position) {
	$class .= ' hr-' . $position;
}
if ($double) {
	$class .= ' hr-double';
}

$text_inside = $iconClass = '';

if( $icon != '' && $icon != '0'  ) {
	$iconClass = 'icon-' . str_replace( "icon-", "", $icon );
	if ( $icon_size != '' ) {
		$iconClass .= ' icon-' . $icon_size;
	}
} elseif( $icon_type != 'fontello' ) {
	$iconClass = isset( ${"icon_" . $icon_type} ) ? ${"icon_" . $icon_type} : '';
}
$icon_el = '<i class="' . $iconClass . '"></i> ';

$text = ( $text != '' ) ? $text : '';

$text_inside = '<abbr>' . $icon_el . $text . '</abbr>';

// Enqueue needed font for icon element
if ( function_exists('vc_icon_element_fonts_enqueue') && 'pixelicons' !== $icon_type && 'fontello' != $icon_type ) {
	vc_icon_element_fonts_enqueue( $icon_type );
}

$output .= "\n\t"."<div {$id} class=\"{$class}\" style=\"{$style}\">{$text_inside}</div>";