<?php
/**
 * GRID Shortcode
 * [kleo_grid]Text[/kleo_grid]
 * 
 * @package WordPress
 * @subpackage K Elements
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since K Elements 1.0
 */

$style = $el_class = $colored_icons = $bordered_icons = '';

extract( shortcode_atts( array(
		'el_class' => '',
		'type' => '1',
		'colored_icons' => '',
		'bordered_icons' => '',
		'style' => '',
		'animation' => ''
), $atts ) );


$class = ( $el_class != '' ) ? ' row multi-columns-row ' . esc_attr( $el_class ) : 'row multi-columns-row';

if ($colored_icons == 'yes') {
	$class .= ' colored-icons';
}
if ($bordered_icons == 'yes') {
	$class .= ' bordered-icons';
}

if ( $style != '' ) {
	$class .= ' ' . $style . '-style';
}


$col = floor(12/$type);

//Find items
$innersh = '';
$sh = preg_match_all('~\[(\[?)(kleo_feature_item)(?![\w-])([^\]\/]*(?:\/(?!\])[^\]\/]*)*?)(?:(\/)\]|\](?:([^\[]*+(?:\[(?!\/\2\])[^\[]*+)*+)\[\/\2\])?)(\]?)~s', $content, $childs);

if( $sh && isset( $childs[0] ) && ! empty( $childs[0] )) {

	foreach ($childs[0] as $child) {
		$innersh .= '<div class="col-xs-12 ' . ( $type > 1 ? "col-sm-6 " : " " ) . 'col-md-' . $col . '">';
		$innersh .= do_shortcode( $child );
		$innersh .= '</div>';
	}
}

$output .= "<div class=\"{$class}\">"; 
if ($animation == 'yes') {
	$output .='<div class="one-by-one-animated animate-when-almost-visible">';
}

$output .= $innersh;

if ($animation == 'yes') {
	$output .= "</div>";
}

$output .= "</div>";