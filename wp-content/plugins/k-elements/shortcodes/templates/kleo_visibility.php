<?php
/**
 * Visibility Shortcode
 * 
 * 
 * @package WordPress
 * @subpackage K Elements
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since K Elements 1.0
 */


$output = '';
extract( shortcode_atts( array(
	'el_class'  => '',
	'type'   => '',
	'inline' => ''
), $atts ) );

$class = ( $el_class != '' ) ? 'kleo-visibility ' . esc_attr( $el_class ) : 'kleo-visibility';
$class .= ( $type  != '' ) ? " ".str_replace(',', ' ', $type) : '';

$output = "<div class=\"{$class}\">" . do_shortcode( $content ) . "</div>";
