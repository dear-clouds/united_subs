<?php
/**
 * List Shortcode
 * [kleo_list][kleo_list_item]Lorem ipsum[/kleo_list_item][kleo_list_item]Lorem ipsum[/kleo_list_item][/kleo_list]
 * 
 * @package WordPress
 * @subpackage K Elements
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since K Elements 1.0
 */

$output = '';
extract( shortcode_atts( array(
		'el_class' => '',
		'type' => 'standard',
		'icon_color' => '',
		'icon_shadow' => '',
		'icon_large' => '',
		'divider' => '',
		'inline' => '',
		'align' => ''
), $atts ) );

$kleo_list_container = 'ul';
$kleo_list_item_tag = 'li';

$class = ( $el_class != '' ) ? esc_attr( $el_class ) : '';

if ( $type == 'icons' ) {
	$class .= ' fontelo-list';
	
	if( $inline != '' ) {
		$class .= ' list-inline';
	}
	
	if( $icon_color != '' ) {
		$class .= ' colored-icons';
	}
	
	if( $icon_shadow != '' ) {
		$class .= ' shadow-icons';
	}
	
	if( $icon_large != '' ) {
		$class .= ' list-icon-large';
	}
}

if ( $type == 'standard' ) {
	$class .= ' standard-list';
	
	if($icon_color != '') {
		$class .= ' colored-icons';
	}
}

if ( $type == 'ordered' ) {
	$class .= ' ordered-list';
	if($icon_color != '') {
		$class .= ' colored-icons';
	}
}

if ( $type == 'ordered-roman' ) {
	$class .= ' ordered-list upper-roman';
	if($icon_color != '') {
		$class .= ' colored-icons';
	}
}

if ( $type == 'unstyled' ) {
	$class .= ' list-unstyled';
}


if( $divider != '' ) {
	$class .= ' list-divider';
	
	if( $divider == 'dashed' ) {
		$class .= ' dashed';
	}
}

$style = '';

if ($align != '') {
	$align_vals = array( 'left', 'right', 'center' );
		if ( in_array( $align, $align_vals ) ) {
			$style .= 'float:' . $align. ';';
	}
}

if ($style != '') {
	$style = ' style="' . $style . '"';
}

$output .= '<' . $kleo_list_container . ' class="' . trim( $class ) . '"' . $style . '>' . do_shortcode($content) . '</' . $kleo_list_container . '>';