<?php
function mom_graph($atts, $content) {
	extract(shortcode_atts(array(
		'height' => '',
		'strips' => ''
		), $atts));
	if ($strips == 'true') {
		$strips = '<div class="mom_graph_strips"></div>';
	}
	$line_height = '';
	if ($height != '') {
		$line_height = 'line-height:'.($height + 2).'px;';
		$height = 'height:'.$height.'px;';
	}
	if (!preg_match_all("/(.?)\[(graph)\b(.*?)(?:(\/))?\](?:(.+?)\[\/graph\])?(.?)/s", $content, $matches)) {
		return do_shortcode($content);
	} else {
		for($i = 0; $i < count($matches[0]); $i++) {
			$matches[3][$i] = shortcode_parse_atts($matches[3][$i]);
		}
		$output = '';
		for($i = 0; $i < count($matches[0]); $i++) {
			$color = '';
			$text_color = '';
			if (isset($matches[3][$i]['color'])) {
				$color = $matches[3][$i]['color'];
			}
			if (isset($matches[3][$i]['text_color'])) {
				$text_color = 'color:'.$matches[3][$i]['text_color'].';';
			}
                        $output .= '<div class="progress_bar"><span style="'.$text_color.$height.$line_height.'">'.$matches[3][$i]['title'].' '.$matches[3][$i]['score'].'%</span><div class="progress_wrap"><div class="parograss_text" style="'.$height.'"></div><div class="parograss_inner" style="width:'.$matches[3][$i]['score'].'%; background-color:'.$color.';'.$height.'">'.$strips.'</div>
                     </div>
                </div>';
		}

		return '<div class="progress_outer">' . $output . '</div>';
	}		
}

add_shortcode('graphs', 'mom_graph');