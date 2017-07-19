<?php

if ( ! function_exists( 'gp_price_box' ) ) {
	function gp_price_box($atts, $content = null) {
		extract(shortcode_atts(array(
			'title' => '',
			'price' => '',
			'unit' => '',
			'button_text' => '',
			'button_url' => '',
			'width' => '340',
			'height' => '',
			'margins' => '',
			'align' => 'aligncenter'
		), $atts));
	
	
		// Unique Name
	
		STATIC $i = 0;
		$i++;
		$name = 'price-box'.$i;


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
	
		ob_start(); ?>

		<div class="sc-price-box <?php echo $name; ?> <?php echo $align; ?>" style="<?php echo $width.$height.$margins; ?>">
	
			<div class="sc-price-box-inner">
		
				<div class="sc-price-box-title"><?php echo $title; ?></div>
			
				<div class="left">
			
					<span class="sc-price-box-price"><?php echo $price; ?></span>
			
					<span class="sc-price-box-unit"><?php echo $unit; ?></span>
			
				</div>
			
				<?php if($content) { ?>
					<div class="sc-price-divider"> </div>
					<div class="sc-price-box-content"><?php echo do_shortcode($content); ?></div>
				<?php } ?>
			
				<?php if($button_text) { ?>
					<div class="sc-price-box-button">
						<a href="<?php echo $button_url; ?>" class="sc-button large" target="_self"><?php echo $button_text; ?></a>
					</div>
				<?php } ?>
			
				<div class="clear"></div>

			</div>
		
		</div>

	<?php 

		$output_string = ob_get_contents();
		ob_end_clean(); 
	
		return $output_string;

	}
}
add_shortcode('price_box', 'gp_price_box');

?>