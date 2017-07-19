<?php
/**
 * ICON Shortcode
 * 
 * 
 * @package WordPress
 * @subpackage K Elements
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since K Elements 1.0
 */


$output = $icon = $icon_size = $icon_color = $padding = $position = $scroll_to = $text = $text_position = $font_size = $el_class = '';
extract(shortcode_atts(array(
    'icon' => '',
    'icon_size' => '',
    'icon_color' => '',
	'padding' => '',
    'tooltip' => '',
    'tooltip_position' => '',
    'tooltip_title' => '',
    'tooltip_text' => '',
    'tooltip_action' => 'hover',
    'el_class' => '',
	'position' => 'inline',
	'text' => '',
	'text_position' => 'left',
	'font_size' => '',
    'href' => '',
    'target' => '_self',
	'scroll_to' => ''
), $atts));

$styles = $wrapper_style = array();
$before_icon = $after_icon = '';

if ( $icon != '' && $icon != '0') {

    $icon = str_replace( 'icon-', '', $icon );

	$tooltip_class = '';
	$tooltip_data = '';
	if( $tooltip != '' ) {
		if ( $tooltip == 'popover' ) {
			$tooltip_class = ' '.$tooltip_action.'-pop';
            $tooltip_data .= ' data-toggle="popover" data-container="body" data-title="'.$tooltip_title.'" data-content="'.$tooltip_text.'" data-placement="'.$tooltip_position.'"';
		} else {
			$tooltip_class .= ' '.$tooltip_action.'-tip';
            $tooltip_data .= ' data-toggle="tooltip" data-original-title="'.$tooltip_title.'" data-placement="'.$tooltip_position.'"';
		}
	}
	$class = esc_attr( $el_class );
	$class .= ' icon-' . esc_attr( $icon );
	$class .= $icon_size != '' ? ' icon-' . esc_attr($icon_size) : '';
	$class .= $tooltip_class;

	if ($icon_color != '') {
		$styles[] = 'color: ' . $icon_color;
	}

	if( $padding != '' ) {
		if ( $position != 'inline' ) {
			$wrapper_style[] = 'padding: 0 ' . kleo_set_default_unit( $padding );
		} else {
			$styles[] = 'padding: 0 ' . kleo_set_default_unit( $padding );
		}
	}

	if ($font_size != '') {
		$wrapper_style[] = 'font-size: ' . kleo_set_default_unit( $font_size );
	}

	if ( ! empty( $wrapper_style ) ) {
		$wrapper_style = 'style="' . join( ';', $wrapper_style ) . '"';
	} else {
		$wrapper_style = '';
	}

	if ( $position != 'inline' ) {
		$before_icon = '<div class="text-' . $position . '" ' . $wrapper_style . '>';
		$after_icon = '</div>';
	}

	if ( ! empty( $styles ) ) {
		$style = 'style="' . join( ';', $styles ) . '"';
	} else {
		$style = '';
	}

	$output = '<i class="' . trim( $class ) . '"' . $tooltip_data . $style .'></i> ';

	if ( $text != '' ) {
		if ( $text_position == 'left' ) {
			$output = '<span class="kleo-icon-text">' . $text . '</span> ' . $output;
		} else {
			$output .= ' <span class="kleo-icon-text">' . $text . '</span>';
		}

		$output = '<span class="flexbox-container flexbox-center flexbox-justify-' . $position . '">' . $output . '</span>';
	}


    if ( $href != '' ) {
	    $anchor_class = 'kleo-icon-anchor';

	    if ( $scroll_to == 'yes' ) {
		    $anchor_class .= ' kleo-scroll-to';
	    }
        $output = '<a class="' . $anchor_class . '" href="' . $href . '" target="' . $target . '">' . trim( $output ) . '</a>';
    }

	$output = $before_icon . $output . $after_icon;

}
