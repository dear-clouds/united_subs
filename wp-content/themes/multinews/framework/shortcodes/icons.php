<?php
// Icons
function mom_icons($atts, $content) {
	extract(shortcode_atts(array(
		'column'=>'',
		'title' => '',
		'title_align' => '',
		'title_link' => '',
		'content_align' => '',
		'layout' => '',
		'bg' => '',
		'border' => '',
		'title_color' => '',
		'content_color' => '',
		'align' => 'left',
		'icon_align_to' => '',
		'type' => '',
		'icon' => '',
		'size' => '32',
		'icon_color' => '',
		'icon_color_hover' => '',
		'icon_bg' => '',
		'icon_bg_color' => '',
		'icon_bg_hover' => '',
		'square_bg_radius' => '',
		'icon_bd_color' => '',
		'icon_bd_hover' => '',
		'icon_bd_width' => '',
		'icon_link' => '',
		'icon_animation' => '',
		'icon_animation_duration' => '',
		'icon_animation_delay' => '',
		'icon_animation_iteration' => '',
		'hover_animation' => 'border_increase', // border_increase, border_decrease, icon_move
	), $atts));

	$hover_animation = $hover_animation .'_effect';

	if ($column == 2) {
		$class ="one_half";
	} elseif ($column == 3) {
		$class ="one_third";
	} elseif ($column == 4) {
		$class ="one_fourth";
	} elseif ($column == 5) {
		$class ="one_fifth";
	} else {
            $class='';
        }

	$ani_class = '';
   if (!empty($icon_animation)) {
	$ani_class = ' animated';
	
   }
   if (!empty($icon_animation_duration)) {
      $icon_animation_duration = '-webkit-animation-duration: '.$icon_animation_duration.'s;-moz-animation-duration: '.$icon_animation_duration.'s;-o-animation-duration: '.$icon_animation_duration.'s;animation-duration: '.$icon_animation_duration.'s;';
   }
   if (!empty($icon_animation_delay)) {
      $icon_animation_delay = '-webkit-animation-delay: '.$icon_animation_delay.'s;-moz-animation-delay: '.$icon_animation_delay.'s;-o-animation-delay: '.$icon_animation_delay.'s;animation-delay: '.$icon_animation_delay.'s;';
   }
   $iteration_count = '';
   if (!empty($icon_animation_iteration)) {
      if ($icon_animation_iteration == -1 ) {$icon_animation_iteration = 'infinite';}
      $iteration_count = '-webkit-animation-iteration-count: '.$icon_animation_iteration.';-moz-animation-iteration-count: '.$icon_animation_iteration.';-o-animation-iteration-count: '.$icon_animation_iteration.';animation-iteration-count: '.$icon_animation_iteration.';';
   }
   
   if($align == 'left' || $align == 'middle_left') {
			if($icon_bg != '') {
		$padding = 'style="padding-left:'.($size+35).'px;"';
			if ($icon_bd_color != '') {
				$padding = 'style="padding-left:'.($size+46).'px;"';
			}
			} else {
		$padding = 'style="padding-left:'.($size+15).'px;"';
			}
		} elseif ($align == 'right' || $align == 'middle_right') {
		$padding = 'style="padding-right:'.($size+15).'px;"';
			if($icon_bg != '') {
		$padding = 'style="padding-right:'.($size+30).'px;"';
			if ($icon_bd_color != '') {
				$padding = 'style="padding-left:'.($size+41).'px;"';
			}
		}
		} else {
		$padding = '';
		}
	
	if($align == 'middle_left' || $align == 'middle_right') {
		$margin = 'margin-top:-'.($size/2).'px;';
	} else {
		$margin = '';
	}
	
	if ($icon_align_to == 'title') {
		$padding = 'style="padding-left:0;"';
		if ($icon_bg != '') {
		$padd = (($size+20)-22)/2;
		$title_style = 'margin-bottom:10px; padding-top:'.$padd.'px; padding-bottom:'.$padd.'px; padding-left:'.(($size+20)+10).'px;';
		} else {
		if ($size <= 22) {
			$padd = 0;
		} else {
		$padd = (($size)-22)/2;
		}
		$title_style = 'margin-bottom:10px; padding-top:'.$padd.'px; padding-bottom:'.$padd.'px; padding-left:'.($size+10).'px;';
		}
	} else {
		$icon_align_to = '';
		$title_style = '';
	}
	$align = 'iconb_'.$align;
	if ($layout == 'boxed') {
		if ($bg != '') {
		$bg = 'background:'.$bg.';';
		}
		if ($border != '') {
		$border = 'border-color:'.$border.';';
		}		
		$ibwrap_start = '<div class="iconbox_wrap mom_column mom_columns'.$column.' '.$class.'" style="'.$bg.$border.'">';
		$ibwrap_end = '</div>';
		$column_class = '';
	} else {
		$ibwrap_start = '';
		$ibwrap_end = '';
		$column_class = 'mom_column mom_columns'.$column.' '.$class.'';
	}
	if ($title_color != '') {
	$title_color = 'color:'.$title_color.';';
	}		
	if ($content_color != '') {
	$content_color = 'color:'.$content_color.';';
	}		

	if ($title != '') {
		$title_link_start = '';
		$title_link_end = '';
		if ($title_link != '') {
			$title_link_start = '<a href="'.$title_link.'">';
			$title_link_end = '</a>';
		}
	$title = '<h3 style="text-align:'.$title_align.'; '.$title_style.$title_color.'">'.$title_link_start.$title.$title_link_end.'</h3>';
	}

	
	if($icon_bg != '') {
		$icon_bg = 'mom_iconbox_'.$icon_bg;
		if ($icon_bd_width != '') {
			$icon_bg .= ' mom_icon_has_border';
		}
			$icon_bg .= ' '.$hover_animation.'_wrap';
		$vsize = $size+20;
		$imgpadd = 'padding:15px;';
		if ($size > 32) {
		$isize = $size-14;
		} elseif ($size > 28) {
		$isize = $size-6;
		} else {
			$isize = $size;
		}
		if ($icon_bd_color != '') {
			if ($icon_bd_width == '') {
				$icon_bd_width = 1;
			}
			$bd = 'border: '.$icon_bd_width.'px solid '.$icon_bd_color.';';
		} else {
			$bd = '';
		}
		$hac = '';
		if ($icon_bg_color != '') {
			$hac = 'border-color:'.$icon_bg_color.';';
		}
		if ($icon_bd_color != '') {
			$hac = 'border-color:'.$icon_bd_color.'; border-width:'.($icon_bd_width-1).'px;';
		}
		if($square_bg_radius != '') {
			$hac .= ' border-radius:'.$square_bg_radius.'px; -webkit-border-radius:'.$square_bg_radius.'px;';
		}
                if ($size < 32) {
                       $hac .= ' border-width:2px;';
                }
		$hover_animation_el = '<span class="mom_icon_hover_effect '.$hover_animation.'" style="'.$hac.'"></span>';
		
		
	} else {
		$icon_bg = '';
		$vsize = $size;
		$isize = $size;
		$bd = '';
		$imgpadd = '';
		$hover_animation_el = '';
	}
	if($square_bg_radius != '') {
		$square_bg_radius= 'border-radius:'.$square_bg_radius.'px; -webkit-border-radius:'.$square_bg_radius.'px;';
	} else {
		$square_bg_radius = '';
	}
	if($icon_bg_hover != '') {
		$icon_bg_hover = 'data-color="'.$icon_bg_color.'" data-hover="'.$icon_bg_hover.'" ';
	} else {
		$icon_bg_hover = '';
	}
	if($icon_bd_hover != '') {
		$icon_bd_hover = 'data-border_color="'.$icon_bd_color.'" data-border_hover="'.$icon_bd_hover.'" ';
	} else {
		$icon_bd_hover = '';
	}

	if($icon_bg_color != '') {
		$icon_bg_color = 'background-color:'.$icon_bg_color.';';
	} else {
		$icon_bg_color = '';
	}
	if($type == 'vector') {
		if ($icon_color_hover != '') {
			$data_attr = 'data-color="'.$icon_color.'" data-hover="'.$icon_color_hover.'"';
		} else {
			$data_attr = '';
		}
		$the_icon = '<span class="iconb_wrap '.$icon_bg.$ani_class.'" data-animate="'.$icon_animation.'" '.$icon_bg_hover.$icon_bd_hover.'style="width:'.$vsize.'px; height:'.$vsize.'px;'.$icon_bg_color.$margin.$square_bg_radius.' line-height:'.$vsize.'px; '.$bd.$icon_animation_duration.$icon_animation_delay.$iteration_count.'"><i class="'.$icon.' mom_icon" style="font-size:'.$isize.'px; color:'.$icon_color.';"'.$data_attr.'></i>'.$hover_animation_el.'</span>';
	} elseif ($type == 'image') {
		$the_icon = '<span class="iconb_wrap '.$icon_bg.$ani_class.'" data-animate="'.$icon_animation.'" '.$icon_bg_hover.$icon_bd_hover.' style="width:'.$size.'px; height:'.$size.'px;'.$icon_bg_color.$margin.$square_bg_radius.$bd.$imgpadd.$icon_animation_duration.$icon_animation_delay.$iteration_count.'"><i class="momizat-imgIcons_'.$icon.'_'.$size.' mom_icon"></i></span>';
	} elseif ($type == 'custom') {
		$the_icon = '<span class="iconb_wrap '.$icon_bg.$ani_class.'" data-animate="'.$icon_animation.'" '.$icon_bg_hover.$icon_bd_hover.' style="width:'.$size.'px; height:'.$size.'px;'.$icon_bg_color.$margin.$square_bg_radius.$bd.$imgpadd.$icon_animation_duration.$icon_animation_delay.$iteration_count.'"><i class="mom_icon" style="background:url('.$icon.') no-repeat center; width:'.$size.'px; height:'.$size.'px;'.$margin.'"></i></span>';
	}
		$icon_link_start = '';
		$icon_link_end = '';
		if ($icon_link != '') {
			$icon_link_start = '<a href="'.$icon_link.'">';
			$icon_link_end = '</a>';
		}

    return ''.$ibwrap_start.'<div class="'.$column_class.'"><div class="mom_iconbox '.$align.'" '.$padding.'>'.$icon_link_start.$the_icon.$icon_link_end.$title.'<div style="'.$content_color.' text-align:'.$content_align.';">'.do_shortcode($content).'</div></div></div>'.$ibwrap_end.'';
	
	}

add_shortcode('iconbox', 'mom_icons');

// Icons
function mom_icona($atts, $content) {
	extract(shortcode_atts(array(
		'align' => '',
		'type' => '',
		'icon' => '',
		'size' => '32',
		'icon_color' => '',
		'icon_color_hover' => '',
		'icon_bg' => '',
		'icon_bg_color' => '',
		'icon_bg_hover' => '',
		'square_bg_radius' => '',
		'icon_bd_color' => '',
		'icon_bd_hover' => '',
		'icon_bd_width' => '',
		'hover_animation' => 'border_increase', // border_increase, border_decrease, icon_move
	), $atts));
	$hover_animation = $hover_animation .'_effect';
	if ($align == 'right') {
		$align = 'float:right; margin-left:10px; margin-right:0;';
	} elseif ($align == 'center') {
		$align = 'float:none; display:block; margin:auto; margin-bottom:15px; text-align:center;';
	}
	if($icon_bg != '') {
		$icon_bg = 'mom_iconbox_'.$icon_bg;
		if ($icon_bd_width != '') {
			$icon_bg .= ' mom_icon_has_border';
		}
			$icon_bg .= ' '.$hover_animation.'_wrap';
		$bgplus = 20;
		$style = 'width:'.($size+$bgplus).'px; height:'.($size+$bgplus).'px; line-height:'.($size+$bgplus-$icon_bd_width*2+1).'px;';
		$imgstyle = 'padding:10px; line-height:1;';
		if ($size > 32) {
		$isize = $size-14;
		} elseif ($size > 28) {
		$isize = $size-6;
		} else {
			$isize = $size;
		}
		if ($icon_bd_color != '') {
			if ($icon_bd_width == '') {
				$icon_bd_width = 1;
			}
			$bd = 'border: '.$icon_bd_width.'px solid '.$icon_bd_color.';';
		} else {
			$bd = '';
		}
		
		$hac = '';
		if ($icon_bg_color != '') {
			$hac = 'border-color:'.$icon_bg_color.';';
		}
		if ($icon_bd_color != '') {
			$hac = 'border-color:'.$icon_bd_color.'; border-width:'.($icon_bd_width-1).'px;';
		}
		if($square_bg_radius != '') {
			$hac .= ' border-radius:'.$square_bg_radius.'px; -webkit-border-radius:'.$square_bg_radius.'px;';
		}
		$hover_animation_el = '<span class="mom_icon_hover_effect '.$hover_animation.'" style="'.$hac.'"></span>';
		
	} else {
		$icon_bg = '';
		$bgplus = '';
		$style = '';
		$imgstyle = '';
		$isize = $size;
		$bd = '';
		$hover_animation_el = '';
	}
	if($square_bg_radius != '') {
		$square_bg_radius= 'border-radius:'.$square_bg_radius.'px; -webkit-border-radius:'.$square_bg_radius.'px;';
	} else {
		$square_bg_radius = '';
	}
	if($icon_bg_hover != '') {
		$icon_bg_hover = 'data-color="'.$icon_bg_color.'" data-hover="'.$icon_bg_hover.'" ';
	} else {
		$icon_bg_hover = '';
	}
	if($icon_bd_hover != '') {
		$icon_bd_hover = 'data-border_color="'.$icon_bd_color.'" data-border_hover="'.$icon_bd_hover.'" ';
	} else {
		$icon_bd_hover = '';
	}

	if($icon_bg_color != '') {
		$icon_bg_color = 'background-color:'.$icon_bg_color.';';
	} else {
		$icon_bg_color = '';
	}
	
	if($type == 'vector') {
		if ($icon_color_hover != '') {
			$data_attr = 'data-color="'.$icon_color.'" data-hover="'.$icon_color_hover.'"';
		} else {
			$data_attr = '';
		}
		$the_icon = '<span class="mom_icona iconb_wrap '.$icon_bg.'"'.$icon_bg_hover.$icon_bd_hover.'style="'.$style.$icon_bg_color.$square_bg_radius.$align.$bd.'"><i class="'.$icon.' mom_icon" style="font-size:'.$isize.'px; color:'.$icon_color.';"'.$data_attr.'></i>'.$hover_animation_el.'</span>';
	} elseif ($type == 'image') {
		$the_icon = '<span class="mom_icona iconb_wrap '.$icon_bg.'" '.$icon_bg_hover.$icon_bd_hover.'style="'.$imgstyle.$icon_bg_color.$square_bg_radius.$align.$bd.'"><i class="momizat-imgIcons_'.$icon.'_'.$size.' mom_icon"></i></span>';
	} elseif ($type == 'custom') {
		$the_icon = '<span class="mom_icona iconb_wrap '.$icon_bg.'" '.$icon_bg_hover.$icon_bd_hover.'style="'.$imgstyle.$icon_bg_color.$square_bg_radius.$align.$bd.'"><i class="mom_icon" style="background:url('.$icon.') no-repeat center; width:'.$size.'px; height:'.$size.'px;"></i></span>';
	} 
    return $the_icon;
	
	}

add_shortcode('icon', 'mom_icona');

// Icons
function mom_social_icon($atts, $content) {
	extract(shortcode_atts(array(
		'align' => '',
		'icon' => '',
		'size' => '32',
		'icon_color' => '',
		'icon_color_hover' => '',
		'icon_bg' => '',
		'icon_bg_color' => '',
		'icon_bg_hover' => '',
		'square_bg_radius' => '',
		'icon_bd_color' => '',
		'icon_bd_hover' => '',
		'icon_bd_width' => '',
		'link' => '#',
		'tooltip' => ''
	), $atts));
	$icon_class = $icon;
	if ($align == 'right') {
		$align = 'float:right; margin-left:10px; margin-right:0;';
	} elseif ($align == 'center') {
		$align = 'float:none; display:block; margin-bottom:15px; text-align:center;';
	}
	if($icon_bg != '') {
		$icon_bg = 'mom_iconbox_'.$icon_bg;
		$bgplus = 20;
		$style = 'width:'.($size+$bgplus).'px; height:'.($size+$bgplus).'px; line-height:'.($size+$bgplus).'px;';
		$wrap_size = $size+20;
		$margin = 'margin-right:9px; margin-bottom:6px;';
		if ($icon_bd_color != '') {
			if ($icon_bd_width == '') {
				$icon_bd_width = 1;
			}
			$bd = 'border: '.$icon_bd_width.'px solid '.$icon_bd_color.';';
		} else {
			$bd = '';
		}

		
	} else {
		$icon_bg = '';
		$bgplus = '';
		$style = '';
		$wrap_size = $size;
		$margin = '';
		$bd = '';
	}
	if($square_bg_radius != '') {
		$square_bg_radius= 'border-radius:'.$square_bg_radius.'px; -webkit-border-radius:'.$square_bg_radius.'px;';
	} else {
		$square_bg_radius = '';
	}
		if ($icon_color_hover != '') {
			$data_attr = 'data-color="'.$icon_color.'" data-hover="'.$icon_color_hover.'"';
		} else {
			$data_attr = '';
		}

	if($icon_bg_hover != '') {
		$icon_bg_hover = 'data-color="'.$icon_bg_color.'" data-hover="'.$icon_bg_hover.'" ';
	} else {
		$icon_bg_hover = '';
	}
	if($icon_bd_hover != '') {
		$icon_bd_hover = 'data-border_color="'.$icon_bd_color.'" data-border_hover="'.$icon_bd_hover.'" ';
	} else {
		$icon_bd_hover = '';
	}

	if($icon_bg_color != '') {
		$icon_bg_color = 'background-color:'.$icon_bg_color.';';
	} else {
		$icon_bg_color = '';
	}
	if ($tooltip != '') {
	$tooltip = 'data-tooltip="'.$tooltip.'"';
	}
	
		$the_icon = '<a class="social_icons_wrap simptip-position-top simptip-movable" '.$tooltip.'" href="'.$link.'" style="width:'.$wrap_size.'px;'.$margin.'"><span class="mom_social_icon mom_icona iconb_wrap '.$icon_bg.'" '.$icon_bg_hover.$icon_bd_hover.'style="'.$style.$icon_bg_color.$square_bg_radius.$align.$bd.'"><i class="'.$icon_class.' mom_icon" style="font-size:'.$size.'px; color:'.$icon_color.'; "'.$data_attr.'></i></span></a>';

    return $the_icon;

	}

add_shortcode('social', 'mom_social_icon');