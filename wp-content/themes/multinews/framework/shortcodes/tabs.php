<?php

function mom_tabs($atts, $content) {
	extract(shortcode_atts(array(
		'style' => '',
		'icon_color' => '',
		'icon_current_color' => ''
		), $atts));
		wp_enqueue_script('tabs');
		
if (!preg_match_all("/(.?)\[(tab)\b(.*?)(?:(\/))?\](?:(.+?)\[\/tab\])?(.?)/s", $content, $matches)) {
		return do_shortcode($content);
	} else {
		for($i = 0; $i < count($matches[0]); $i++) {
			$matches[3][$i] = shortcode_parse_atts($matches[3][$i]);
		}

		$icon_colors = '';
		if ($icon_color != '') {
			$icon_colors = 'color:'.$icon_color.'; ';
		}
		if ($icon_current_color != '') {
			$icon_current_color = 'data-color="'.$icon_color.'" data-current="'.$icon_current_color.'"';
		}
		$output = '<ul class="tabs">';
		
		for($i = 0; $i < count($matches[0]); $i++) {
			$icona = '';
			$icon_style = '';
			if(isset($matches[3][$i]['icon'])){
				if($matches[3][$i]['icon'] != '') {
					if ($icona.$matches[3][$i]['title'] == '') {
						$icon_style = 'margin-right:0; margin-left:0;';
					}
					if (strpos($matches[3][$i]['icon'],'http') !== false) {
						$icona = '<i class="tab_ico" style="'.$icon_style.'"><img src="'.$matches[3][$i]['icon'].'"></i>';
					} else {
						$icona = '<i class="'.$matches[3][$i]['icon'].'" style="'.$icon_colors.$icon_style.'"'.$icon_current_color.'></i>';
					}
					}
			}
			$output .= '<li><a href="#">'.$icona.$matches[3][$i]['title'] . '</a></li>';
		}
		$output .= '</ul>';

		$output .= '<div class="tabs-content-wrap">';
		for($i = 0; $i < count($matches[0]); $i++) {
			$output .= '<div class="tab-content">' . do_shortcode($matches[5][$i]) . '</div>';
		}
		$output .= '</div>';

		$style = 'tabs_'.$style;
		return '<div class="main_tabs base-box '.$style.'">' . $output . '<div class="clear"></div></div>';
	}			
}

add_shortcode('tabs', 'mom_tabs');


function mom_accordion($atts, $content) {
	extract(shortcode_atts(array(
		'type' => '',
		'handle' => '',
		'space' => '',
		'direction' => '',
		'height' => '230',
		'icon_color' => '',
		'icon_current_color' => ''
		), $atts));

		if($space == 'yes') {
			$space = 'acc_space ';
		} else {
			$space = '';
		}
		if ($type == 'toggle') {
			$toggle = 'toggle_acc ';
		} else {
			$toggle = '';
		}
		$icon_colors = '';
		if ($icon_color != '') {
			$icon_colors = 'style="color:'.$icon_color.';" ';
		}
		if ($icon_current_color != '') {
			$icon_current_color = 'data-color="'.$icon_color.'" data-current="'.$icon_current_color.'"';
		}
		if ($handle != '') {
		if ($handle == 'numbers') {
			$handle = 'acch_numbers';
		} elseif ($handle == 'pm') {
			$handle = 'acch_pm';
		} else {
			$handle = 'acch_arrows';
		}
		}
		
	$direction = 'acc_vertical ';

	if (!preg_match_all("/(.?)\[(accordion)\b(.*?)(?:(\/))?\](?:(.+?)\[\/accordion\])?(.?)/s", $content, $matches)) {
		return do_shortcode($content);
	} else {
		for($i = 0; $i < count($matches[0]); $i++) {
			$matches[3][$i] = shortcode_parse_atts($matches[3][$i]);
		}
		$output = '';
		for($i = 0; $i < count($matches[0]); $i++) {
				$icona = '';
				if(isset($matches[3][$i]['icon'])){
					if($matches[3][$i]['icon'] != '') {
					if (strpos($matches[3][$i]['icon'],'http') !== false) {
						$icona = '<i class="acc_ico"><img src="'.$matches[3][$i]['icon'].'"></i>';
					} else {
						$icona = '<i class="'.$matches[3][$i]['icon'].'" '.$icon_colors.$icon_current_color.'></i>';
					}
				
					}
				}
				$state = '';
				if ($type == 'toggle') {
					if(isset($matches[3][$i]['state'])){
					$state = $matches[3][$i]['state'];
					$state = 'acc_toggle_'.$state;
					}
				} 
			$output .= '<li><h2 class="acc_title '.$state.'"><span>'. $icona . $matches[3][$i]['title'] . '<i class="acc_handle '.$handle.'"></i></span></h2>';
			$output .= '<div class="acc_content"><div>' . do_shortcode($matches[5][$i]) . '</div></div><div class="clear"></div></li>';
		}

		return '<div class="accordion mom_accordion  '.$space.$direction.$toggle.'"><ol>' . $output . '</ol></div>';
	}		
}

add_shortcode('accordions', 'mom_accordion');

?>