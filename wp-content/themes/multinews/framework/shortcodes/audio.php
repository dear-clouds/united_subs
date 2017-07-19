<?php
function mom_soundcloud($atts, $content) {
	extract(shortcode_atts(array(
		'width' => '590',
		'height' => '375',
		'id' => '',
			), $atts));
			$type="https://w.soundcloud.com/player/?url=";
		return '<div class="video_wrap">
              	<iframe width="'.$width.'" height="'.$height.'" src="'.$type.$id.'"></iframe>
              </div>';
	
	}

add_shortcode('soundcloud', 'mom_soundcloud');

function mom_mixcloud($atts, $content) {
	extract(shortcode_atts(array(
		'width' => '590',
		'height' => '375',
		'id' => '',
			), $atts));
			$type="//www.mixcloud.com/widget/iframe/?feed=";
		return '<div class="video_wrap">
              	<iframe width="'.$width.'" height="'.$height.'" src="'.$type.$id.'" frameborder="0"></iframe>
              </div>';
	
	}

add_shortcode('mixcloud', 'mom_mixcloud');
?>