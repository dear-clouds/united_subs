<?php
$output = $color = $size = $position = $icon = $target = $href = $el_class = $title = $font_size = $font_weight = $uppercase
	= $special = $border = $border_width = $custom_bg_hover = $custom_text_hover = $custom_border = $custom_border_hover = $letter_spacing = '';
extract(shortcode_atts(array(
    'style' => 'default',
    'custom_background' => '',
	'custom_bg_hover' => '',
    'custom_text' => '',
    'custom_text_hover' => '',
    'custom_border' => '',
    'custom_border_hover' => '',
    'icon_custom_background' => '',
    'icon_custom_text' => '',
	'font_size' => '',
	'font_weight' => '',
	'uppercase' => '',
    'size' => '',
	'position' => '',
    'type' => '',
    'icon' => 'none',
    'target' => '_self',
    'href' => '',
    'el_class' => '',
    'title' => 'Text on the button',
    'title_alt' => "",
    'special' => '',
    'border' => '',
	'border_width' => '',
    'tooltip' => '',
    'tooltip_position' => '',
    'tooltip_title' => '',
    'tooltip_text' => '',
    'tooltip_action' => 'hover',
    'box_shadow_x' => '0',
    'box_shadow_y' => '0',
    'box_shadow_blur' => '0',
    'box_shadow_spread' => '0',
    'box_shadow_color' => '#000000',
	'letter_spacing' => '',

), $atts));

$before_button = '';
$after_button = '';
$before_title = '';
$after_title = '';
$before_title_alt = '';
$after_title_alt = '';

$el_class = ( $el_class != '' ) ? ' ' . trim( $el_class ) : '';
$css_class = $el_class;

if($type == 'text-animated') {
	
	$before_title = '<span>';
	$after_title = '</span>';
	$before_title_alt = '<span>';
	$after_title_alt = '</span>';
} elseif($type == 'subtext') {
	
	$title_alt = '<small>'.$title_alt.'</small>';
} elseif( $type == 'app' ) {
	
	$title = '<small>'.$title.'</small>';
	$before_title_alt = '<span>';
	$after_title_alt = '</span>';
}

$inline_css = '';
$icon_inline_css = '';


/* Custom button text & background */
if ( 'custom' == $style ) {
    if ( $custom_background != '' ) {
        $inline_css .= 'background-color: ' . $custom_background . ';';
    }
    if ( $custom_text != '' ) {
        $inline_css .= 'color: ' . $custom_text . ';';
    }
	if ( $custom_border != '' ) {
		$inline_css .= 'border-color: ' . $custom_border . ';';
	}
	if ( $border_width != '' ) {
		$inline_css .= 'border-width: ' . $border_width . ';';
	}
}

/* Custom icon text & background */
if ( 'boxed-icon' == $type ) {
	if ( $icon_custom_background != '' ) {
		$icon_inline_css .= 'background-color: ' . $icon_custom_background . ';';
	}
	if ( $icon_custom_text != '' ) {
		$icon_inline_css .= 'color: ' . $icon_custom_text . ';';
	}
}
if ($icon_inline_css != '') {
	$icon_inline_css = 'style="' . $icon_inline_css . '"';
}

if( $box_shadow_x != 0 || $box_shadow_y != 0 || $box_shadow_blur != 0 || $box_shadow_spread != 0) {
	$inline_css .= ' box-shadow: '. (int)$box_shadow_x . 'px ' . (int)$box_shadow_y . 'px '
	               . (int)$box_shadow_blur . 'px ' . (int)$box_shadow_spread . 'px ' .$box_shadow_color . ';';
}

if ($font_size != '') {
	$inline_css .= 'font-size: ' . $font_size. ';';
}
if ($font_weight != '') {
	$inline_css .= 'font-weight: ' . $font_weight. ';';
}

/* hover logic */
$output_css = '';
$button_id = '';
if ( 'custom' == $style && ( $custom_bg_hover != '' || $custom_text_hover != '' || $custom_border_hover != '' ) ) {

	$btn_id = uniqid('btn_');
	$button_id = 'id="' . $btn_id . '"';

	$output_css .= '<style>';
	$output_css .= "#{$btn_id}:hover {";
	if ($custom_bg_hover != '') {
		$output_css .= "background-color: {$custom_bg_hover} !important;";
	}
	if ($custom_text_hover != '') {
		$output_css .= "color: {$custom_text_hover} !important;";
	}
	if ($custom_border_hover != '') {
		$output_css .= "border-color: {$custom_border_hover} !important;";
	}
	$output_css .= "}";
	$output_css .= '</style>';
}

if ($letter_spacing != '') {
	$css_class .= ' letter-spacing-' . $letter_spacing;
}

if ( $position != 'inline' && $position != '' ) {
	$before_button = '<div class="text-' . $position . '">';
	$after_button = '</div>';
}


if ( $target == 'same' || $target == '_self' ) { $target = ''; }
$target = ( $target != '' ) ? ' target="'.$target.'"' : '';

$style = ( $style != '' ) ? ' btn-'.$style : '';
$size = ( $size != '' ) ? ' btn-'.$size : '';
$icon = str_replace( 'icon-', '', $icon );

if (  $icon != '' && $icon != 'none' && $icon != '0'  ) {
	$icon = '<i class="icon-' . $icon . '" ' . $icon_inline_css . '></i> ';
	$css_class .= ' with-icon';
} else {
	$icon = '';
}

$type = $type != '' ? ' btn-' . $type : "";

/* Border radius */
if ( $special != '' && $special != 'no' ) {
	$css_class .= ' btn-special';
}
if ( $special == 'no_border' ) {
	$inline_css .= 'border: none !important; box-shadow: none;';
}

if ( $special == 'no' ) {
	$css_class .= ' no-border-radius';
}

/* Border */
if ( $border != '') {
	$inline_css .= 'border: none !important;';
}


$css_class .= $style . $size . $type;

$title_alt = $title_alt != '' ? $title_alt : "";
$title_alt = $before_title_alt.$title_alt.$after_title_alt ;

if ( $uppercase != '' ) {
	$css_class .= ' text-uppercase';
}


$tooltip_class = '';
$tooltip_data = '';
if( $tooltip != '' ) {
	if ($tooltip == 'popover') {
		$tooltip_class = ' '.$tooltip_action . '-pop';
        $tooltip_data .= ' data-toggle="popover" data-container="body" data-title="' . $tooltip_title . '" data-content="' . $tooltip_text . '" data-placement="'.$tooltip_position.'"';
	} else {
		$tooltip_class .= ' ' . $tooltip_action . '-tip';
        $tooltip_data .= ' data-toggle="tooltip" data-original-title="' . $tooltip_title . '" data-placement="' . $tooltip_position . '"';
	}
}
$css_class .= $tooltip_class;

if ( $inline_css != '' ) {
	$inline_css = ' style="' . $inline_css . '"';
}

// hook for Buddypress profile link
if ( function_exists( 'bp_is_active' ) && function_exists( 'kleo_bp_replace_placeholders' ) ) {
    $href = kleo_bp_replace_placeholders( $href );
}

$output .= $before_title . $icon . $title . $after_title . $title_alt;
$output = $output_css
          . $before_button
          . '<a class="btn' . $css_class . '" href="' . $href . '"' . $target . $tooltip_data . $inline_css. $button_id . '>' . $output . '</a>'
          . $after_button;