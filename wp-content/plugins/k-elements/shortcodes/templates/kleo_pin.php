<?php
/**
 * PIN Shortcode
 * 
 * 
 * @package WordPress
 * @subpackage K Elements
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since K Elements 1.0
 */


$output = '';
extract(shortcode_atts(array(
		'type' => 'icon',
		'icon' => '', //only for icon type
		'top' => '',
		'bottom' => '',
		'left' => '',
		'right' => '',
		'tooltip' => '',
		'tooltip_position' => '',
		'tooltip_title' => '',
		'tooltip_text' => '',
		'tooltip_action' => 'hover',
		'animation' => '',
		'css_animation' => '',
		'el_class' => ''
), $atts));

$inners_span = '';
$data_attr = '';

$class = esc_attr( $el_class );
$class .= ' kleo-pin-' . $type;

if($type == 'icon' && $icon != '') {
	$inners_span = '<i class="icon-'.$icon.'"></i>';
}


$tooltip_class = '';
$tooltip_data = '';
if($tooltip != '') {
	if ($tooltip == 'popover') {
		$tooltip_class = ' '.$tooltip_action.'-pop';
			$tooltip_data .= ' data-toggle="popover" data-container="body" data-title="'.$tooltip_title.'" data-content="'.$tooltip_text.'" data-placement="'.$tooltip_position.'"';
	} else {
		$tooltip_class .= ' '.$tooltip_action.'-tip';
			$tooltip_data .= ' data-toggle="tooltip" data-original-title="'.$tooltip_title.'" data-placement="'.$tooltip_position.'"';
	}
}
$data_attr .= $tooltip_data;

$data_attr .= $top != '' ? ' data-top="'.esc_attr($top).'"' : ""; 
$data_attr .= $bottom != '' ? ' data-bottom="'.esc_attr($bottom).'"' : ""; 
$data_attr .= $left != '' ? ' data-left="'.esc_attr($left).'"' : ""; 
$data_attr .= $right != '' ? ' data-right="'.esc_attr($right).'"' : ""; 

$class .= $tooltip_class;

if ( $animation != '' ) {
	wp_enqueue_script( 'waypoints' );
	$class .= " animated {$animation} {$css_animation}";
}

$output = '<span class="'.$class.'"'.$data_attr.'><span>'.$inners_span.'</span></span>';