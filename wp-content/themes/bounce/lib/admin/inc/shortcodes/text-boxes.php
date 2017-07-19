<?php

if ( ! function_exists( 'gp_text' ) ) {
	function gp_text($atts, $content = null) {
		extract(shortcode_atts(array(
			'size' => '',
			'width' => '',
			'height' => '',
			'line_height' => '',
			'color' => '',
			'font' => '',
			'margins' => '',
			'text_align' => '',
			'align' => 'alignnone',
			'other' => '',
			'name' => '',
			'company' => ''
		), $atts));

		// Font Size
		if($size != "") {
			if(preg_match('/%/', $size) OR preg_match('/em/', $size) OR preg_match('/px/', $size)) {
				$size = 'font-size: '.$size.'; ';				
			} else {
				$size = 'font-size: '.$size.'px; ';		
			}
		} else {
			$size = "";
		}
	
		// Width
		if($width != "") {
			if(preg_match('/%/', $width) OR preg_match('/em/', $width) OR preg_match('/px/', $width)) {
				$width = 'width: '.$width.'; ';		
			} else {
				$width = 'width: '.$width.'px; ';		
			}
		} else {
			$width = "";
		}
	
		// Height
		if($height != "") {
			if(preg_match('/%/', $height) OR preg_match('/em/', $height) OR preg_match('/px/', $height)) {
				$height = 'height: '.$height.'; ';		
			} else {
				$height = 'height: '.$height.'px; ';		
			}
		} else {
			$height = "";
		}

		// Line Height
		if($line_height != "") {
			if(preg_match('/%/', $line_height) OR preg_match('/em/', $line_height) OR preg_match('/px/', $line_height)) {
				$line_height = 'line-height: '.$line_height.'; ';				
			} else {
				$line_height = 'line-height: '.$line_height.'px; ';		
			}
		} else {
			$line_height = "";
		}

		// Font Colour
		if($color != "") {
			$color = 'color: '.$color.'; '; 
		} else {
			$color = ''; 
		}
	
		// Font Family
		if($font != '') {
			$font = 'font-family: '.$font.'; ';
		} else {
			$font = '';
		}	
	
		// Margins
		if($margins != "") {
			if(preg_match('/%/', $margins) OR preg_match('/em/', $margins) OR preg_match('/px/', $margins)) {
				$margins = str_replace(",", " ", $margins);
				$margins = 'margin: '.$margins.'; ';	
			} else {
				$margins = str_replace(",", "px ", $margins);
				$margins = 'margin: '.$margins.'px; ';		
			}
			$margins = str_replace("autopx", "auto", $margins);
		} else {
			$margins = "";
		}

		// Name
		if($name) {
			$name = '<span class="testimonial-name">'.$name.'</span>';
		} else {
			$name = '';	
		}

		// Company
		if($company) {
			$company = ' <span class="testimonial-company">'.$company.'</span>';
		} else {
			$company = '';	
		}
	
		// Company Comma
		if($name && $company) {
			$company_comma = '<span class="testimonial-comma">,</span>';
		} else {
			$company_comma = '';	
		}
	
		$out = '<div class="text-box '.$text_align.' '.$align.'" style="'.$size.$color.$font.$line_height.$margins.$width.$height.$other.'">'.do_shortcode($content).'<br/>'.$name.$company_comma.$company.'</div>';
	
	   return $out;
	}
}
add_shortcode('text', 'gp_text');

?>