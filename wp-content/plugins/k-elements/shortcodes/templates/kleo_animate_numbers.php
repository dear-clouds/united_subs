<?php
/**
 * Animated numbers shortcode Shortcode
 * [kleo_animate_numbers timer=9000 animation="animate-when-almost-visible"]1000[/kleo_animate_numbers]
 * 
 * @package WordPress
 * @subpackage K Elements
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since K Elements 1.0
 */

$output = $timer = $element = $el_class = '';
wp_enqueue_script( 'waypoints' );

extract(shortcode_atts(array(
	'timer' => '',
	'element' => 'span',
	'font_size' => '',
	'font_weight' => '',
	'animation' => 'animate-when-almost-visible',
	'el_class' => ''
), $atts));

$data_attr = '';
$style = array();
$class = esc_attr($el_class);

if ( $animation != '' ) {
	$class .= " kleo-animate-number {$animation}";
}

if ($timer != '') {
	$data_attr .= ' data-timer="'. (int)$timer .'"';
}

if ($font_size != '') {
	$style[] ='font-size: ' . kleo_set_default_unit( $font_size );
}

if ($font_weight != '') {
	$style[] ='font-weight: ' . $font_weight;
}

if (! empty( $style )) {
	$data_attr .= ' style="' . implode( ';', $style ) . '"';
}

$inner_content = do_shortcode( $content );

$output = '<' . $element . ' data-number="'.(int)$inner_content.'" class="'.$class.'"'.$data_attr.'>' . (int)$inner_content . '</' . $element . '>';