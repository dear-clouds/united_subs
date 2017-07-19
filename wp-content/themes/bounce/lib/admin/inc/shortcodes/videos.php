<?php

if ( ! function_exists( 'gp_video' ) ) {
	function gp_video($atts, $content = null) {
		extract(shortcode_atts(array(
			'url' => '',
			'html5_1' => '',
			'html5_2' => '',
			'priority' => 'flash',
			'image' => '',
			'width' => '560',
			'height' => '315',
			'controlbar' => 'bottom',
			'autostart' => 'false',
			'icons' => 'true',
			'stretching' => 'fill',
			'align' => 'alignnone',
			'plugins' => '',
			'skin' => get_template_directory_uri().'/lib/scripts/mediaplayer/fs39/fs39.xml',
			'player' => get_template_directory_uri().'/lib/scripts/mediaplayer/player.swf'        
		), $atts));
	
		require(gp_inc . 'options.php'); global $is_IE, $is_gecko, $gp_settings, $dirname;
	
	
		// Unique Name
	
		STATIC $i = 0;
		$i++;
		$name = 'video'.$i;


		// Video Type	
	
		$vimeo = strpos($url,"vimeo.com");
		$youtube1 = strpos($url,"youtu.be");
		$youtube2 = strpos($url,"youtube.com");	


		// Allow relative URLs
	
		if(!preg_match("/http:/", $image) && !preg_match("/https:/", $image)) { $image = site_url().'/'.$image; }
		if(!preg_match("/http:/", $url) && !preg_match("/https:/", $url)) { $url = site_url().'/'.$url; }
		if($html5_1 && !preg_match("/http:/", $html5_1) && !preg_match("/https:/", $html5_1)) { $html5_1 = site_url().'/'.$html5_1; }
		if($html5_2 && !preg_match("/http:/", $html5_2) && !preg_match("/https:/", $html5_2)) { $html5_2 = site_url().'/'.$html5_2; }


		// Vimeo Autostart
	
		if($autostart == "false") {
			$autostart = "0";
		} elseif($autostart == "true") {
			$autostart = "1";
		}


		// Vimeo Clip ID
	
		if(preg_match('/www.vimeo/',$url)) {							
			$vimeoid = str_replace('http://www.vimeo.com/', '', $url);
		} else {							
			$vimeoid = str_replace('http://vimeo.com/', '', $url);
		}		

			
		ob_start(); ?>
	
		
		<div class="sc-video <?php echo $align; ?> <?php echo $name; ?>" style="width: <?php echo $width; ?>px;">


			<?php if($vimeo) { ?>
			
			
				<iframe src="http://player.vimeo.com/video/<?php echo $vimeoid; ?>?byline=0&amp;portrait=0&amp;autoplay=<?php echo $autostart; ?>" width="<?php echo $width; ?>" height="<?php if($gp_settings['iphone']) { echo $height/2; } else { echo $height; } ?>" allowFullScreen></iframe>
		

			<?php } elseif(($youtube1 OR $youtube2) && get_option($dirname.'_jwplayer') == '1') { ?>
		
			
				<?php global $wp_embed; ?>
				<?php echo $wp_embed->run_shortcode('[embed width="'.$width.'" height="'.$height.'"]'.$url.'[/embed]'); ?>
		
			
			<?php } else { ?>


				<?php if(wp_is_mobile()) { ?>
				
					<video id="<?php echo $name; ?>" controls="controls">
						<source src="<?php if($html5_1) { echo $html5_1; } else { echo $url; } ?>" type="video/mp4" />
						<source src="<?php if($html5_2) { echo $html5_2; } else { echo $url; } ?>" type="video/webm" />
					</video>
			
				<?php } else { ?>	
							
					<div id="<?php echo $name; ?>"></div>
				
				<?php } ?>


				<script>
				jwplayer("<?php echo $name; ?>").setup({
					<?php if($image) { $image = aq_resize($image, $width, $height, true, true, true); ?>image: "<?php echo $image; ?>",<?php } ?>
					icons: "<?php echo $icons; ?>",
					autostart: "<?php echo $autostart; ?>",
					stretching: "<?php echo $stretching; ?>",
					controlbar: "<?php echo $controlbar; ?>",
					skin: "<?php echo $skin; ?>",
					width: <?php echo $width; ?>,
					height: <?php if($gp_settings['iphone']) { echo $height/2; } else { echo $height; } ?>,
					screencolor: "000000",
					modes:
						[
						<?php if($is_IE == "true" OR $priority == "flash") { ?>
							{type: "flash", src: "<?php echo $player; ?>", config: {file: "<?php echo $url; ?>"}},					
							{type: "html5", config: {file: "<?php if($is_gecko && $html5_2) { echo $html5_2; } elseif($html5_1) { echo $html5_1; } else { echo $url; } ?>"}}
						<?php } else { ?>
							{type: "html5", config: {file: "<?php if($is_gecko && $html5_2) { echo $html5_2; } elseif($html5_1) { echo $html5_1; } else { echo $url; } ?>"}},	
							{type: "flash", src: "<?php echo $player; ?>", config: {file: "<?php echo $url; ?>"}}
						<?php } ?>
						],
					plugins: {<?php echo $plugins; ?>}
				});
				</script>
			
		
			<?php } ?>

		</div>

	<?php 

		$output_string = ob_get_contents();
		ob_end_clean(); 
	
		return $output_string;

	}
}
add_shortcode('video', 'gp_video');

?>