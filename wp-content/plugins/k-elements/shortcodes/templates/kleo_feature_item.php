<?php
/**
 * FEATURE ITEM
 * [kleo_feature_item]Text[/kleo_feature_item]
 * 
 * @package WordPress
 * @subpackage K Elements
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since K Elements 1.0
 */


$output = $icon = $icon_size = $icon_position = $class = '';
extract( shortcode_atts( array(
		'title' => '',
		'href' => '',
		'icon' => '',
		'icon_size' => 'default',
		'icon_position' => 'left',
		'icon_color' => '',
		'class' => ''
), $atts ) );

$class = ( $class != '' ) ? 'kleo-block feature-item list-el-animated ' . esc_attr( $class ) : 'kleo-block feature-item list-el-animated';

$icon = str_replace( 'icon-', '', $icon );
$icon = ( $icon !='' ) ? ' icon-' . $icon : '';

$class .= ($icon_size !='') ? " " . $icon_size . '-icons-size' : '';
$class .= ($icon_position == 'center') ? " center-icons" : '';

if( $href != '' ){
	$class .= ' kleo-open-href';
}

$output .= '<div class="' . $class . '"'.( $href != '' ? 'data-href="'.esc_attr(esc_url($href)) . '"' : '' ).'>';
$output .= '<span class="feature-icon el-appear' . $icon . '"'.( $icon_color != '' ? 'style="color:'.$icon_color.'"' : '' ).'></span>';
$output .= '<h3 class="feature-title">' . $title . '</h3>';
$output .= '<div class="feature-text">' . do_shortcode( $content ) . '</div>';
$output .= '</div>';

