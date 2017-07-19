<?php

function mom_buttons_sc($atts, $content) {
	extract(shortcode_atts(array(
		'link' => '#',
		'target' => '',
		'color' => '',
		'style' => '',
		'align' => '',
		'width' => '',
		'size' => '',
		'font' => '',
		'font_weight'=> '',
		'font_style' => '',
		'textcolor' => '',
		'texthcolor' => '',
		'bgcolor' => '',
		'hoverbg' => '',
		'bordercolor' => '',
		'hoverborder' => '',
		'radius' => '',
		'outer_border' => '',
		'outer_border_color' => '',
		'icon' => '',
		'icon_color' => '',
		'rel' => ''
		), $atts));

		if ($size != '') {
			$size = $size.'_bt ';
		}
		if ($color != '') {
		$color = $color . '_bt ';
		}
		if($target=='') {
			$target='';
		}else {
		$target = 'target="'. $target .'" ';
		}
		if ($rel != '') {
			$rel = 'rel="'.$rel.'"';
		}
		
		if($link=='') {
			$link='';
		}else {
		$link = 'href="'. $link . '" ';
		}
		$bgcolorS = $bgcolor;
		$textcolorS = $textcolor;
		if($bgcolor != '') {
		$bgcolor = 'background:'. $bgcolor . ' !important;';
		}
		if($textcolor != '') {
		$textcolor = 'color:'. $textcolor . ' !important;';
		}
		if ($bordercolor != '') {
			$dborder = 'data-border="'.$bordercolor.'" ';
			$bordercolor = 'border-color:'.$bordercolor.';';
		} else {
			$dborder = '';
		}
		if ($hoverborder != '') {
			$hoverborder = 'data-borderhover="'.$hoverborder.'" ';
		}
		$font = 'font-family:'.$font.';';
		if ($radius != '') {
		$ob_radiusn = $radius + 5; 
		$radius = '-webkit-border-radius: '.$radius.'px; border-radius: '.$radius.'px;';
		$ob_radius = '-webkit-border-radius: '.$ob_radiusn.'px; border-radius: '.$ob_radiusn.'px;';
		}
		if ($font_weight != '') { 
		$font_weight = 'font-weight:'.$font_weight.';';
		}
		if ($font_style != '') { 
		$font_style = 'font-style:'.$font_style.';';
		}
		if ($icon != '') {
			if ($icon_color != '') {
				$icon_color = 'style="color:'.$icon_color.';"';
			}
			$icon = '<i class="'.$icon.' bt_icon" '.$icon_color.'></i>';	
		}

		if ($align == 'center') {
			$wstyle = 'style="display:block; text-align:center;"';
			$center_button = 'margin-right:0;';
		} else {
			$wstyle = '';
			$center_button = '';
		}

		if ($style != '') {
			$style = $style.'_bt ';
		}
		if($outer_border != '') {
			if($outer_border_color != '') {
				$outer_border_color = 'border-color:'.$outer_border_color.';';
			}
			$ob_start = '<span class="mom_button_ob ob_'.$color.'" style="'.$ob_radius.$center_button.$outer_border_color.'">';
			$ob_end = '</span>';
		} else {
			$ob_start = '';
			$ob_end = '';
		}
		if($width == 'full') {
			$width = 'display:block; margin-right:0;';
		} else {
			$width = '';
		}
		
		return '<span class="mom_button_wrap" '.$wstyle.'>'.$ob_start.'<a class="button mom_button '.$color.$size.$style.'" '. $link.$target.$rel.' style="'.$bgcolor.$textcolor.$font.$font_weight.$font_style.$radius.$textcolor.$bordercolor.$width.$center_button.'" data-bg="'.$bgcolorS.'" data-hoverbg="'.$hoverbg.'" data-text="'.$textcolorS.'" data-texthover="'.$texthcolor.'"'.$dborder.$hoverborder.'>'.$icon.do_shortcode($content). '</a>'.$ob_end.'</span>';
	
	}

add_shortcode('button', 'mom_buttons_sc');


?>