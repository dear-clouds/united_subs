<?php
/**
 * GAP Shortcode
 * 
 * 
 * @package WordPress
 * @subpackage K Elements
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since K Elements 1.0
 */


$output = $class = $style = $size = '';
extract( shortcode_atts( array(
	'id'    => '',
	'class' => '',
	'style' => '',
	'size'  => '10px',
	'visibility' => '',
), $atts ) );

$id    = ( $id    != '' ) ? 'id="' . esc_attr( $id ) . '"' : '';
$class = ( $class != '' ) ? 'kleo-gap ' . esc_attr( $class ) : 'kleo-gap';
$style = ( $style != '' ) ? $style : '';
$size  = ( $size  != '' ) ? "height:{$size};line-height:{$size};" : 'height:0;line-height:0;';

if ( $visibility != '' ) {
	$class .= ' ' . str_replace( ',', ' ', $visibility );
}

$output .= "<div {$id} class=\"{$class}\" style=\"{$size}{$style}\"></div>";