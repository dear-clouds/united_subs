<?php
// Drop Cap
function dropcaps($atts, $content) {
	extract(shortcode_atts(array(
		'style' => '',
		'color' => '',
		'bgcolor' => '',
		'sradius'=> '',
		'font' => '',
		'fontsize' => ''

	), $atts));
	if ($style == 'circle' || $style == 'square') {
		if ($bgcolor != '') {
		$bgcolor = 'background:'.$bgcolor.';';
		}
	}
	if ($style == 'square') {
		$sradius = '-webkit-border-radius: '.$sradius.'px; border-radius: '.$sradius.'px;';
	} else {
		$sradius = '';
	}
	$style = $style . '_dc';
	
	if ($color != '') {
	$color = 'color:'.$color.';';
	}
	if($font != '') {
	$font = 'font-family:'.$font.';';
	}
	if($fontsize != '') {
	$fontsize = 'font-size:'.$fontsize.'px;';
	}

	
    return '<span class="dropcap '.$style.'" style="'.$bgcolor.$color.$font.$fontsize.$sradius.'">'.$content.'</span>';
	
	}

add_shortcode('dropcap', 'dropcaps');

//incor
function mom_incor($atts, $content) {
	extract(shortcode_atts(array(
		'name' => ''
	), $atts));
	
	return '<a name="'.$name.'"></a>';
}
add_shortcode('incor', 'mom_incor');

// Quote
function quote($atts, $content) {
	extract(shortcode_atts(array(
		'align' => '',
		'bgcolor' => '',
		'color' => '',
		'bcolor' => '',
		'arrow' => '',
		'font' => '',
		'font_size' => '',
		'font_style' => ''
		
	), $atts));
	

if( $font_size != '' ) {
    $font_size = 'font-size:'.$font_size.'px;';
} else {
    $font_size = '';    
}
if( $font_style != '' ) {
    $font_style = 'font-style:'.$font_style.';';
} else {
    $font_style = '';    
}
	
	if($arrow == 'yes') {
		$arrow = '<span class="quote-arrow" style="border-left-color:'.$bcolor.';"></span>';
	} else {
		$arrow = '';
	}
	if($bcolor != '') {
		$bcolor = 'border-left-color:'.$bcolor.'; ';
	} else {
		$bcolor = '';
	}
	if($bgcolor != '') {
		$bgcolor = 'background-color:'.$bgcolor.'; ';
	} else {
		$bgcolor = '';
	}
	if($color != '') {
		$color = 'color:'.$color.'; ';
	} else {
		$color = '';
	}
	if($align == 'right') {
		$align ='quote_right';
	} elseif ($align == 'left') {
		$align = 'quote_left';
	} else {
		$align = '';
	}
    return '<blockquote class="mom_quote '.$align.'" style="font-family:'.$font.';'.$font_size.$font_style.$bcolor.$color.$bgcolor.'">'.$arrow.do_shortcode($content).'</blockquote>';
	
	}

add_shortcode('quote', 'quote');

// Highlight
function highlight($atts, $content, $code) {
	extract(shortcode_atts(array(
		'bgcolor' => '',
		'txtcolor' => ''
		
	), $atts));
	
	
	if($bgcolor != '' ) {
		$bgcolor = 'background-color:'.$bgcolor.';' ;
	}
	if($txtcolor != '' ) {
		$txtcolor = 'color:'.$txtcolor.';' ;
	}
	

    return '<span class="'.$code.'" style="'.$bgcolor.$txtcolor.'">'.do_shortcode($content).'</span>';
	
	}

add_shortcode('highlight', 'highlight');

//devider
function divide($atts, $content=null) {
	extract(shortcode_atts(array(
	'style' => '',
	'icon' => '',
	'icon_position' => '',
	'margin_bottom' => '',
	'margin_top' => '',
	'width' => '',
	'color' => ''
	), $atts));
	if ($style != '') {
		$style = ' mom_hr_'.$style;
	}

	if ($color != '') {
		$color = 'border-color:'. $color . ';';
	}
	if ($margin_bottom != '') {
		$margin_bottom = 'margin-bottom:'. $margin_bottom . 'px;';
	}
	if ($margin_top != '') {
		$margin_top = 'margin-top:'. $margin_top . 'px;';
	}
	$i = '';
	if ($icon != '') {
		$icon = ' mom_hr_'.$icon;
		$i = '<i style="'.$color.'"></i>';
	}
	
	if($icon_position != '') {
		$icon_position = ' hr_icon_'.$icon_position;
	}
	if($width != '') {
		$width = ' mom_hr_'.$width;
	}

	if($width != '') {
		$width = ' mom_hr_'.$width;
	}
    return '<div class="mom_hr'.$icon.$width.$icon_position.$style.'" style="'.$margin_top.$margin_bottom.'"><span class="mom_inner_hr" style="'.$color.'">'.$i.'</span></div>';
	
	}

add_shortcode('divide', 'divide');

//Clear
function celar_any($atts, $content=null) {
	extract(shortcode_atts(array(

	), $atts));

    return '<div class="clear" style="margin-bottom:25px;"></div>';
	
	}

add_shortcode('clear', 'celar_any');

//lists
function mom_lists ($atts, $content=null) {
	extract(shortcode_atts(array(
	'icon' => '',
	'icon_color' => '',
	'icon_color_hover' => '',
	'icon_bg' => '',
	'icon_size' => '',
	'icon_bg_color' => '',
	'icon_bg_hover' => '',
	'square_bg_radius' => '',
	'list_items' => '',
	'margin_top' => '',
	'margin_bottom' => '',
	), $atts));
	$data_color = $icon_color;
	$data_color_hover = $icon_color_hover;
	$data_icon_bg = $icon_bg_color;
	$data_icon_bghover = $icon_bg_hover;
	if ($icon_size != '') {$icon_size = 'font-size:'.$icon_size.'px;';}
	if ($icon_bg) {$icon_bg = 'mom_list_'.$icon_bg.'_bg';}
	if ($icon_bg_color) {$icon_bg_color = 'background:'.$icon_bg_color.';';}
	if ($icon_color) {$icon_color = 'color:'.$icon_color.';';}
	if ($square_bg_radius) {$square_bg_radius = 'border-radius:'.$square_bg_radius.'px; -webkit-border-radius:'.$square_bg_radius.'px;';}
	if ($margin_top != '') { $margin_top = 'margin-top:'.$margin_top.'px;'; }
	if ($margin_bottom != '') { $margin_bottom = 'margin-bottom:'.$margin_bottom.'px;'; }
	if ($list_items == '') {
		$list_items = $content;
	}
	$list_items = explode(',', $list_items);
	$output = '<div class="mom_list '.$icon_bg.'" style="'.$margin_top.$margin_bottom.'"><ul>';
		foreach($list_items as $li) {
			$output .= '<li><i class="'.$icon.'" style="'.$icon_bg_color.$icon_color.$square_bg_radius.$icon_size.'" data-color="'.$data_color.'" data-color_hover="'.$data_color_hover.'" data-bg="'.$data_icon_bg.'" data-bg_hover="'.$data_icon_bghover.'"></i>'.$li.'</li>';
		}
	$output .='</ul></div>';
	return $output;
	}

add_shortcode('list', 'mom_lists');

//tooltip
function tooltip_sc($atts, $content=null) {
	extract(shortcode_atts(array(
	'direction' => 's',
	'text' => ''
	), $atts));
	$text = 'title="'.$text.'"';

     return <<<HTML
    <span class="tip_text tip_{$direction}" {$text}>{$content}</span>
HTML;
	}
add_shortcode('tip', 'tooltip_sc');

// Testimonials
function mom_testim($atts, $content) {
	extract(shortcode_atts(array(
		'name' => '',
		'title' => '',
		'image' => '',
		'background' => '',
		'border' => '',
		'img_border' => '',
		'color' => '',
		'name_color' => '',
		'title_color' => '',
		'font' => '',
		'font_size' => '',
		'font_style' => '',
	), $atts));
 
if( $font_size != '' ) {
    $font_size = 'font-size:'.$font_size.'px;';
} else {
    $font_size = '';    
}
if( $font_style != '' ) {
    $font_style = 'font-style:'.$font_style.';';
} else {
    $font_style = '';    
}
	$bordercl = $border;
	$backgroundcl = $background;
	if($border != '') {
		$border = 'border-color:'.$border.'; ';
	} else {
		$border = '';
	}

	if($img_border != '') {
		$img_border = 'border-color:'.$img_border.'; ';
	} else {
		$img_border = '';
	}

	if($background != '') {
		$background = 'background-color:'.$background.'; ';
	} else {
		$background = '';
	}

	if($color != '') {
		$color = 'color:'.$color.'; ';
	} else {
		$color = '';
	}

	if($name_color != '') {
		$name_color = 'color:'.$name_color.'; ';
	} else {
		$name_color = '';
	}

	if($title_color != '') {
		$title_color = 'color:'.$title_color.'; ';
	} else {
		$title_color = '';
	}


	if ($image != '') {
		$img = '<img style="'.$img_border.'" src="'.$image.'" alt="">';
	} else {
		$img = '';
	}
    return '<div class="mom_testimonial_wrap"><blockquote class="mom_testimonial" style="font-family:'.$font.';'.$border.$background.$color.$font_size.$font_style.'"><span style="border-top-color:'.$bordercl.';" class="tesim_arrow_bot"></span><span style="border-top-color:'.$backgroundcl.';" class="tesim_arrow"></span><span class="leftquote" style="'.$color.'">"</span>'.do_shortcode($content).'</blockquote><div class="testim_person">'.$img.'<h3 style="'.$name_color.'">'.$name.'</h3><h4 style="'.$title_color.'">'.$title.'</h4></div></div>';
	
	}

add_shortcode('testimonial', 'mom_testim');
// Testimonials Slider
function mom_testim_slider($atts, $content) {
	extract(shortcode_atts(array(
		'title' => 'What Clients Say',
		'auto_duration' => '1000',
		'effect' => 'fade'
	), $atts));
	wp_enqueue_script('cycle');
	$rndn = rand(0,500);

	$script = '<script type="text/javascript">
		jQuery(document).ready( function($) {
				$(".testimslider'.$rndn.'").cycle({
				fx: "'.$effect.'",
				speed: "'.$auto_duration.'",
				next:  ".tes-slider-next'.$rndn.'", 
				prev:  ".tes-slider-prev'.$rndn.'"
				});
		});
	</script>';

    return $script.'<div class="mom_carousel testim_slider"><h3 class="carousel_title">'.$title.'</h3><div class="carouse_arrows"><a class="tes-slider-prev'.$rndn.'" href="#"><span class="enotype-icon-arrow-left7"></span></a><a class="tes-slider-next'.$rndn.'" href="#"><span class="enotype-icon-uniE6D8"></span></a></div><div class="testim_slider_wrap testimslider'.$rndn.'">'.do_shortcode($content).'</div><div class="clear" style="float:none;"></div></div>';
	
	}

add_shortcode('testimonial_slider', 'mom_testim_slider');


// wider
function mom_custom_background($atts, $content) {
	extract(shortcode_atts(array(
	'color' => '',
	'headings' => '',
	'links_color' => '',
	'bg' => '',
	'bgimg' => '',
	'bgrepeat' => 'repeat',
	'bgposy' => 'top',
	'bgposx' => 'left',
	'bgattach' => 'scroll',
	'fullbg' => '',
	'border_top' => '',
	'border_bottom' => '',
	'padding_top' => '',
	'padding_bottom' => '',
	'margin_top' => '',
	'margin_bottom' => '',
	'content_width' => ''
	), $atts));
	$rndn = rand(1,100);
	if ($color != '') {
		$color = 'color:'.$color.';';
	}
	$links = '';
	if ($links_color != '') {
	$links = '<style type="text/css">
	.mom_custom_background_'.$rndn.' a {
		color:'.$links_color.';
	}
	</style>';
	}
	
	$hcolors = '';
	if ($headings != '') {
	$hcolors = '<style type="text/css">
	.mom_custom_background_'.$rndn.' h1, .mom_custom_background_'.$rndn.' h2, .mom_custom_background_'.$rndn.' h3, .mom_custom_background_'.$rndn.' h4, .mom_custom_background_'.$rndn.' h5, .mom_custom_background_'.$rndn.' h6 {
		color:'.$headings.';
	}
	</style>';
	}
	if ($bg != '') {
		$bg = 'background-color:'.$bg.';';
	}
	
	if ($bgimg != '') {
		$bgimg = 'background-image:url('.$bgimg.'); background-repeat:'.$bgrepeat.'; background-position:'.$bgposy.$bgposx.'; background-attachment:'.$bgattach.';';
		
		if ($fullbg == 'yes') {
			$bgimg .= 'background-size:cover; -webkit-background-size:100%;';
		}
	}

	if ($border_top != '') {
		$border_top = 'border-top:1px solid '.$border_top.';';
	}
	
	if ($border_bottom != '') {
		$border_bottom = 'border-bottom:1px solid '.$border_bottom.';';
	}
	
	if ($padding_top != '') {
		$padding_top = 'padding-top:'.$padding_top.'px;';
	}
	if ($padding_bottom != '') {
		$padding_bottom = 'padding-bottom:'.$padding_bottom.'px;';
	}
	
	if ($margin_top != '') {
		$margin_top = 'margin-top:'.$margin_top.'px;';
	}

	if ($margin_bottom != '') {
		$margin_bottom = 'margin-bottom:'.$margin_bottom.'px;';
	}
	if ($content_width != '') {
		$content_class = "full_width_block";
	} else {
		$content_class = 'inner';
	}

    return $hcolors.$links.'</div><div class="mom_custom_background mom_custom_background_'.$rndn.'" style="'.$color.$bg.$bgimg.$border_top.$border_bottom.$padding_top.$padding_bottom.$margin_top.$margin_bottom.'"><div class="'.$content_class.'">'.do_shortcode($content).'</div></div><div class="inner">';
	
	}

add_shortcode('custom_background', 'mom_custom_background');

function mom_clients($atts, $content) {
	extract(shortcode_atts(array(
	'type' => '',
	'auto_slide' => '',
	'auto_duration' => '4000',
	'cols' => 'three',
	'lightbox' => ''
	), $atts));
		switch ($cols) {
			case 'three':
				$carou_items = 3;
			break;
			case 'four':
				$carou_items = 4;
			break;
			case 'five':
				$carou_items = 5;
			break;
			case 'six':
				$carou_items = 6;
			break;
		}
		$rndn = rand(1,1000);
	if ($lightbox == 'true') {
		$rel = '';
		$overlay ='<span class="plus_overlay"><i></i></span>';

	} else {
		$rel = '';
		$overlay ='';
	}
	wp_enqueue_script('owl');
	$script = '';
	?>
	
	<?php if($type == 'carousel') {
	if ($auto_slide == 'true') {
		$auto_slide = true;
	} else {
		$auto_slide = false;
	}
	if (is_rtl()) {
		$rtl = 'true';
	} else {
		$rtl = 'false';
	}

	$script = '<script>
		jQuery(document).ready(function($){
			 $(".mom_images_grid_'.$rndn.' ul").owlCarousel({
				items:'.$carou_items.',
				baseClass: "mom-carousel",
				autoplay: "'.$auto_slide.'",
				autoplayTimeout: '.$auto_duration.',
				autoplayHoverPause: true,
				rtl: '.$rtl.'
			});
		});
	</script>';

	$igc_start = '<div class="mom_carousel mom_images_grid_'.$rndn.'">';
	$igc_end = '</div>';
	} else {
		$igc_start = '';
		$igc_end = '';
	}
$output = '';
if (!preg_match_all("/(.?)\[(image)\b(.*?)(?:(\/))?\](?:(.+?)\[\/image\])?(.?)/s", $content, $matches)) {
		return do_shortcode($content);
	} else {
		for($i = 0; $i < count($matches[0]); $i++) {
			$matches[3][$i] = shortcode_parse_atts($matches[3][$i]);
		}
		for($i = 0; $i < count($matches[0]); $i++) {
			$thumb = $matches[3][$i]['image'];
			$link = $matches[3][$i]['link'];
			if ($link == $thumb ) {
				$link = wp_get_attachment_image_src($thumb, 'full');
				$link = $link[0];
			}
			$thumb = wp_get_attachment_image_src($thumb, 'nb1-thumb');
			$thumb = $thumb[0];

                        $output .= '<li><a href="'.$link.'" '.$rel.'><img src="'.$thumb.'" alt="">'.$overlay.'</a></li>';
		}

	} 
	return $igc_start.'<div class="mom_images_grid mom_images_'.$cols.'_cols">'.$script.'<ul>'.$output.'</ul></div>'.$igc_end;
}

add_shortcode('images', 'mom_clients');

function mom_img_grid($atts, $content) {
	extract(shortcode_atts(array(
	'type' => '',
	'auto_slide' => '',
	'auto_duration' => '4000',
	'cols' => 'three',
	'lightbox' => '',
	'source'  => 'none',
	'limit'   => 1000,
	'gallery' => null, // Dep. 4.4.0
	'link'    => 'none',
	'width' => '420',
	'height' => '300'
	), $atts));
		switch ($cols) {
			case 'three':
				$carou_items = 3;
			break;
			case 'four':
				$carou_items = 4;
			break;
			case 'five':
				$carou_items = 5;
			break;
			case 'six':
				$carou_items = 6;
			break;
		}
		$rndn = rand(1,1000);
		$rel = '';
	if ($lightbox == 'yes') {
		$overlay ='<span class="plus_overlay"><i></i></span>';

	} else {
		$overlay ='';
	}
	wp_enqueue_script('owl');
	$script = '';
	?>
	
	<?php if($type == 'carousel') {
	if ($auto_slide == 'yes') {
		$auto_slide = true;
	} else {
		$auto_slide = false;
	}
	if (is_rtl()) {
		$rtl = 'true';
	} else {
		$rtl = 'false';
	}

	$script = '<script>
		jQuery(document).ready(function($){
			 $(".mom_images_grid_'.$rndn.' ul").owlCarousel({
				items:'.$carou_items.',
				baseClass: "mom-carousel",
				autoplay: "'.$auto_slide.'",
				autoplayTimeout: '.$auto_duration.',
				autoplayHoverPause: true,
				rtl: '.$rtl.'
			});
		});
	</script>';

	$igc_start = '<div class="mom_carousel mom_images_grid_'.$rndn.'">';
	$igc_end = '</div>';
	} else {
		$igc_start = '';
		$igc_end = '';
	}
$output = '';
		$slides = (array) mom_su_Tools::get_slides( $atts );
		foreach ( $slides as $slide ) {
			$image = vt_resize( '',$slide['image'], '400', '280', true );
            $output .= '<li><a href="'.$slide['image'].'"><img src="'.$image['url'].'" alt="'.esc_attr( $slide['title'] ).'">'.$overlay.'</a></li>';
		}

	return $igc_start.'<div class="mom_images_grid mom_images_'.$cols.'_cols">'.$script.'<ul>'.$output.'</ul></div>'.$igc_end;
}

add_shortcode('images_grid', 'mom_img_grid');
?>