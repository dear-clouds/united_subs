<?php
/**
 * LIST ITEM
 * [kleo_list_item icon=""]Text[/kleo_list_item]
 * 
 * @package WordPress
 * @subpackage K Elements
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since K Elements 1.0
 */


$output = $icon = '';
extract( shortcode_atts( array(
	'icon' => '',
), $atts ) );

$icon = str_replace( 'icon-', '', $icon );
if ($icon != '') {
	$icon = '<i class="icon-'.$icon.'"></i> ';
}

$output .= '<li>' . $icon . kleo_remove_wpautop( $content, true ) . '</li>';

