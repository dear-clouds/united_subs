<?php 
function mom_lightbox($atts, $content = null) {
	extract(shortcode_atts(array(
	'thumb' => '',
	'type' => '',
	'link' => '',
	), $atts));
	if ($link == '') {
		$link = $thumb;
	}
	
	$overlay = '';
	$video_class = '';
	if ($type == 'video') {
		$overlay ='<span class="plus_overlay"><i class="plus_ov_video"></i></span>';
		$video_class = 'mfp-iframe';
	} else {
		$overlay ='<span class="plus_overlay"><i></i></span>';
	}

	return '<div class="mom_lightbox"><a href="'.$link.'" class="lightbox-img '.$video_class.'"><img src="'.$thumb.'" alt="'.$type.'">'.$overlay.'</a></div>';
}
add_shortcode("lightbox", "mom_lightbox");

?>