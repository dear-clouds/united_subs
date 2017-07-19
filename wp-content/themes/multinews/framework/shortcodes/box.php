<?php

/* Box */
function box_sc($atts, $content) {
	extract(shortcode_atts(array(
		'type' => '',
		'color' => '',
		'bg' => '',
		'bgimg' => '',
		'fontsize' => '',
		'radius' => '',
		'border' => '',
		'float' => ''
		), $atts));

		if($color == '') {
			$color = '';
		} else {
		$color = 'color:'.$color.';';
		}
		if($bg == '') {
			$bg = '';
		}else {
		$bg = 'background-color:'.$bg.';';
		}
		if($bgimg == '') {
			$bgimg = '';
		}else {
			$bgimg = 'background-image:url('.$bgimg.');';
		}
		if($radius == '') {
			$radius = '';	
		} else {
		$radius = '-moz-border-radius: '.$radius.'px; border-radius: '.$radius.'px;';
		}
		
		if ($fontsize == '') {
			$fontsize = '';
		} else {
			$fontsizel = $fontsize + 10;
			$fontsize = 'font-size:'.$fontsize.'px; line-height:'.$fontsizel.'px;';
			

		}
		if($border == '') {
			$border = '';
		} else {
			$border = 'border-color:'.$border.';';
		}
		if ($float == '') {
			$float = 'clear';
		} elseif ($float == 'left') {
			$float='box_left';
		} elseif ($float == 'left') {
			$float='box_right';
		}

		return '<div class="base-box mom_box_sc_'. $type .' mom_box_sc '.$float.'" style="'.$fontsize.$radius.$bg.$bgimg.$color.$border.'">
		'.do_shortcode($content).'</div>';
	
	}

add_shortcode('box', 'box_sc');


// Callout
function callout_sc($atts, $content) {
	extract(shortcode_atts(array(
                                'bgimg' => '',
                                'bg' => '',
                                'color' => '',
                                'border' => '',
                                'radius' => '',
                                'font' => '',
                                'fontsize' => '',
                                'bt_pos'  => '',
                                'bt_content'  => '',
                                'bt_style' => '',
                                'bt_color' =>  '',
                                'bt_link' =>  '#',
                                'bt_size' => '',
                                'bt_target' =>  '',
                                'bt_font' => '',
                                'bt_font_style' =>  '',
                                'bt_font_weight' =>  '',
                                'bt_textcolor' => '',
                                'bt_texthcolor' => '',
                                'bt_bgcolor' => '',
                                'bt_hoverbg' => '',
                                'bt_bordercolor' =>  '',
                                'bt_hoverborder' =>  '',
                                'bt_radius' => '',
				'bt_outer_border' => '',
				'bt_outer_border_color' => '',
				'bt_icon' => '',
				'bt_icon_color' => '',

		), $atts));

		if($color != '') {
			$color = 'color:'.$color.';';
		}
		if($bg != '') {
			$bg = 'background-color:'.$bg.';';
		}
		if($bgimg != '') {
			$bgimg = 'background-image:url('.$bgimg.');';
		}
		if($font != '') {
			$font = 'font-family:'.$font.';';
		}
		if($radius != '') {
			$radius = '-moz-border-radius: '.$radius.'px; border-radius: '.$radius.'px;';
		}
		
	
		if ($fontsize != '') {
			$fontsizel = $fontsize + 10;
			$fontsize = 'font-size:'.$fontsize.'px; line-height:'.$fontsizel.'px;';
		}
		if($border != '') {
			$border = 'border-color:'.$border.';';
		}

// button

		if ($bt_size != '') {
			$bt_size = $bt_size.'_bt ';
		}
		if ($bt_color != '') {
		$bt_color = $bt_color . '_bt ';
		}
		if($bt_target=='') {
			$bt_target='';
		}else {
		$bt_target = 'target="'. $bt_target .'" ';
		}
		
		if($bt_link=='') {
			$bt_link='';
		}else {
		$bt_link = 'href="'. $bt_link . '" ';
		}
		$bgcolorS = $bt_bgcolor;
		$textcolorS = $bt_textcolor;
		if($bt_bgcolor != '') {
		$bt_bgcolor = 'background:'. $bt_bgcolor . ';';
		}
		if($bt_textcolor != '') {
		$bt_textcolor = 'color:'. $bt_textcolor . ';';
		}
		if ($bt_bordercolor != '') {
			$dborder = 'data-border="'.$bt_bordercolor.'" ';
			$bt_bordercolor = 'border-color:'.$bt_bordercolor.';';
		} else {
			$dborder = '';
		}
		if ($bt_hoverborder != '') {
			$bt_hoverborder = 'data-borderhover="'.$bt_hoverborder.'" ';
		}
		$bt_font = 'font-family:'.$bt_font.';';
		$ob_radius = '';
		if ($bt_radius != '') {
		$ob_radiusn = $bt_radius + 5; 
		$bt_radius = '-webkit-border-radius: '.$bt_radius.'px; border-radius: '.$bt_radius.'px;';
		$ob_radius = '-webkit-border-radius: '.$ob_radiusn.'px; border-radius: '.$ob_radiusn.'px;';
		}
		if ($bt_font_weight != '') { 
		$bt_font_weight = 'font-weight:'.$bt_font_weight.';';
		}
		if ($bt_font_style != '') { 
		$bt_font_style = 'font-style:'.$bt_font_style.';';
		}
		if ($bt_icon != '') {
			if ($bt_icon_color != '') {
				$bt_icon_color = 'style="color:'.$bt_icon_color.';"';
			}
			$bt_icon = '<i class="'.$bt_icon.' bt_icon" '.$bt_icon_color.'></i>';	
		}

		if ($bt_style != '') {
			$bt_style = $bt_style.'_bt ';
		}
		if($bt_outer_border != '') {
			if($bt_outer_border_color != '') {
				$bt_outer_border_color = 'border-color:'.$bt_outer_border_color.';';
			}
			$ob_start = '<span class="mom_button_ob ob_'.$bt_color.'" style="'.$ob_radius.$bt_outer_border_color.'">';
			$ob_end = '</span>';
		} else {
			$ob_start = '';
			$ob_end = '';
		}
		
		$comargin = '';
		if ($bt_content != '') {
		if ($bt_pos == 'right') {
			$comargin = 'style="margin-right:170px"';
			$btrstyle = 'style="position: absolute; right:30px; top:50%;"';
		$btr = '<div class="callout_button cobtr"'.$btrstyle.'>'.$ob_start.'<a class="button mom_button '.$bt_color.$bt_size.$bt_style.'" '. $bt_link.$bt_target.' style="'.$bt_bgcolor.$bt_textcolor.$bt_font.$bt_font_weight.$bt_font_style.$bt_radius.$bt_textcolor.$bt_bordercolor.'" data-bg="'.$bgcolorS.'" data-hoverbg="'.$bt_hoverbg.'" data-text="'.$textcolorS.'" data-texthover="'.$bt_texthcolor.'"'.$dborder.$bt_hoverborder.'>'.$bt_icon.$bt_content. '</a>'.$ob_end.'</div>';
		$bt= '';
		} elseif ($bt_pos == 'left') {
			$comargin = 'style="margin-left:170px"';
			$btrstyle = 'style="position: absolute; left:30px; top:50%;"';
		$btr = '<div class="callout_button cobtl"'.$btrstyle.'>'.$ob_start.'<a class="button mom_button '.$bt_color.$bt_size.$bt_style.'" '. $bt_link.$bt_target.' style="'.$bt_bgcolor.$bt_textcolor.$bt_font.$bt_font_weight.$bt_font_style.$bt_radius.$bt_textcolor.$bt_bordercolor.'" data-bg="'.$bgcolorS.'" data-hoverbg="'.$bt_hoverbg.'" data-text="'.$textcolorS.'" data-texthover="'.$bt_texthcolor.'"'.$dborder.$bt_hoverborder.'>'.$bt_icon.$bt_content. '</a>'.$ob_end.'</div>';
		$bt= '';
		} else {
			$btr = '';
			if ($bt_pos == 'bottomRight') {
			$bt= '<div class="callout_button" style="margin-top:18px; text-align:right;">'.$ob_start.'<a class="button mom_button '.$bt_color.$bt_size.$bt_style.'" '. $bt_link.$bt_target.' style="'.$bt_bgcolor.$bt_textcolor.$bt_font.$bt_font_weight.$bt_font_style.$bt_radius.$bt_textcolor.$bt_bordercolor.'" data-bg="'.$bgcolorS.'" data-hoverbg="'.$bt_hoverbg.'" data-text="'.$textcolorS.'" data-texthover="'.$bt_texthcolor.'"'.$dborder.$bt_hoverborder.'>'.$bt_icon.$bt_content. '</a>'.$ob_end.'</div>';
			} elseif ($bt_pos == 'bottomCenter') {
			$bt= '<div class="callout_button" style="margin-top:18px; text-align:center;">'.$ob_start.'<a class="button mom_button '.$bt_color.$bt_size.$bt_style.'" '. $bt_link.$bt_target.' style="'.$bt_bgcolor.$bt_textcolor.$bt_font.$bt_font_weight.$bt_font_style.$bt_radius.$bt_textcolor.$bt_bordercolor.'" data-bg="'.$bgcolorS.'" data-hoverbg="'.$bt_hoverbg.'" data-text="'.$textcolorS.'" data-texthover="'.$bt_texthcolor.'"'.$dborder.$bt_hoverborder.'>'.$bt_icon.$bt_content. '</a>'.$ob_end.'</div>';
			} else {
			$bt= '<div class="callout_button" style="margin-top:18px; text-align:left;">'.$ob_start.'<a class="button mom_button '.$bt_color.$bt_size.$bt_style.'" '. $bt_link.$bt_target.' style="'.$bt_bgcolor.$bt_textcolor.$bt_font.$bt_font_weight.$bt_font_style.$bt_radius.$bt_textcolor.$bt_bordercolor.'" data-bg="'.$bgcolorS.'" data-hoverbg="'.$bt_hoverbg.'" data-text="'.$textcolorS.'" data-texthover="'.$bt_texthcolor.'"'.$dborder.$bt_hoverborder.'>'.$bt_icon.$bt_content. '</a>'.$ob_end.'</div>';
			}
		}
		} else {
			$bt = '';
			$btr = '';
		}

		return '<div class="base-box mom_box_sc mom_callout" style="'.$font.$fontsize.$radius.$bg.$bgimg.$color.$border.'"><div class="callout_content"'.$comargin.'>
		'.do_shortcode($content).'</div>'.$btr.$bt.'</div>';
	
	}

add_shortcode('callout', 'callout_sc');

?>