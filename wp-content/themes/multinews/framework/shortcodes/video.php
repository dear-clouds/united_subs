<?php
function mom_video($atts, $content) {
	extract(shortcode_atts(array(
		'width' => '600',
		'height' => '400',
		'id' => '',
		'type' => ''
			), $atts));
		if ($type=='youtube') {
			$type="//www.youtube.com/embed/";
			} elseif($type == 'vimeo') {
				$type= "//player.vimeo.com/video/";
			} elseif($type == 'dailymotion') {
				$type= "//www.dailymotion.com/embed/video/";
			} elseif($type == 'screenr') {
				$type= "//screenr.com/embed/";
			}				
		return '<div class="video_wrap"><iframe width="'.$width.'" height="'.$height.'" src="'.$type.$id.'"></iframe></div>';
	
	}

add_shortcode('mom_video', 'mom_video');

?>