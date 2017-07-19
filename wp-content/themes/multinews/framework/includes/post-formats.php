<?php
		$format = get_post_format();
		$site_width = mom_option('site_width');
		global $posts_st;
		$extra = get_post_meta(get_the_ID(), $posts_st->get_the_id(), TRUE);
		$PCT = get_post_meta(get_the_ID(), 'mom_photo_credit', true);
		$autoplay = mom_option('post_autoplay_video_posts');
		$e_autoplay = '';
		$s_autoplay = '';
		if($autoplay == 1) {
			$e_autoplay = 'autoplay=1&amp;';
			$s_autoplay = ' autoplay="on"';
		}
		
if($format == 'image') {
?>
		<figure class="post-thumbnail" itemprop="associatedMedia" itemscope="" itemtype="http://schema.org/ImageObject">
		    <?php the_post_thumbnail('larg'); ?>
		</figure>
		
<?php } elseif($format == 'video') {
 
		$vi_width = '536';
	if ($site_width == 'wide') {
		$vi_width = '746';
	}

	
        if (isset($extra['video_type'])) { $video_type = $extra['video_type']; }
        if (isset($extra['video_id'])) { $video_id = $extra['video_id']; }
        if (isset($extra['video_height'])) { $vi_height = $extra['video_height']; } else {
	        $vi_height = '323';
			if ($site_width == 'wide') {
				$vi_height = '450';
			}
        }
        if (isset($extra['html5_poster_img'])) { $html5_poster = ' poster="'.$extra['html5_poster_img'].'"'; } else { $html5_poster = ''; }
        
        if (isset($extra['html5_mp4']) && $extra['html5_mp4'] != '') { $mp4 = ' mp4="'.$extra['html5_mp4'].'"'; } else { $mp4 = ''; }
        if (isset($extra['html5_m4v']) && $extra['html5_m4v'] != '') { $m4v = ' m4v="'.$extra['html5_m4v'].'"'; } else { $m4v = ''; }
        if (isset($extra['html5_webm']) && $extra['html5_webm'] != '') { $webm = ' webm="'.$extra['html5_webm'].'"'; } else { $webm = ''; }
        if (isset($extra['html5_ogv']) && $extra['html5_ogv'] != '') { $ogv = ' ogv="'.$extra['html5_ogv'].'"'; } else { $ogv = ''; }
        if (isset($extra['html5_wmv']) && $extra['html5_wmv'] != '') { $wmv = ' wmv="'.$extra['html5_wmv'].'"'; } else { $wmv = ''; }
        if (isset($extra['html5_flv']) && $extra['html5_flv'] != '') { $flv = ' flv="'.$extra['html5_flv'].'"'; } else { $flv = ''; }
        
        if ($video_type == 'youtube') {
        ?>
			<div class="video_frame">
	         	<iframe width="<?php echo $vi_width; ?>" height="<?php echo $vi_height; ?>" src="//www.youtube.com/embed/<?php echo $video_id; ?>?<?php echo $e_autoplay; ?>" frameborder="0" allowfullscreen></iframe>
	        </div>
	        
		<?php } elseif ($video_type == 'facebook') { ?>
			<div class="video_frame">
			    <iframe src="//www.facebook.com/video/embed?video_id=<?php echo $video_id; ?>" width="<?php echo $vi_width; ?>" height="<?php echo $vi_height; ?>" frameborder="0"></iframe>
			</div><!--End Vido_frame-->
        <?php } elseif ($video_type == 'vimeo') { ?>
	        <div class="video_frame">
	         	<iframe src="//player.vimeo.com/video/<?php echo $video_id; ?>?<?php echo $e_autoplay; ?>title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" width="<?php echo $vi_width; ?>" height="<?php echo $vi_height; ?>" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
	        </div>
        <?php } elseif ($video_type == 'daily') { ?>
        	<div class="video_frame">
        		<iframe frameborder="0" width="<?php echo $vi_width; ?>" height="<?php echo $vi_height; ?>" src="//www.dailymotion.com/embed/video/<?php echo $video_id ?>?<?php echo $e_autoplay; ?>logo=0"></iframe>
        	</div>
		<?php } elseif ($video_type == 'html5') { ?>
			<div class="video_frame">
                <?php echo do_shortcode('[video'.$mp4.$m4v.$webm.$ogv.$wmv.$flv.$html5_poster.$s_autoplay.']'); ?>
            </div>
		<?php } ?>
		
<?php } elseif( $format == 'audio' ) { 
	
		if (isset($extra['audio_type'])) { $audio_type = $extra['audio_type']; } else {$audio_type = '';}
	  	if (isset($extra['audio_sc'])) { $soundcloud = $extra['audio_sc']; } else {$soundcloud = '';}
	
	
	    if (isset($extra['audio_poster_img'])) { $audio_poster = ' poster="'.$extra['audio_poster_img'].'"'; } else { $audio_poster = ''; }
	    
	    if (isset($extra['audio_mp3']) && $extra['audio_mp3'] != '') { $mp3 = ' mp3="'.$extra['audio_mp3'].'"'; } else { $mp3 = ''; }
	    if (isset($extra['audio_ogg']) && $extra['audio_ogg'] != '') { $ogg = ' ogg="'.$extra['audio_ogg'].'"'; } else { $ogg = ''; }
	    if (isset($extra['audio_m4a']) && $extra['audio_m4a'] != '') { $m4a = ' m4a="'.$extra['audio_m4a'].'"'; } else { $m4a = ''; }
	    if (isset($extra['audio_wav']) && $extra['audio_wav'] != '') { $wav = ' wav="'.$extra['audio_wav'].'"'; } else { $wav = ''; }
	    if (isset($extra['audio_wma']) && $extra['audio_wma'] != '') { $wma = ' wma="'.$extra['audio_wma'].'"'; } else { $wma = ''; }
		?>
		
		<div class="audio_frame">
            <?php if ( $audio_type == 'soundcloud' ) { ?>
                <div class="soundcloud">
					<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=<?php echo $soundcloud; ?>"></iframe>
				</div>
            <?php } else { ?>
               <?php echo do_shortcode('[audio'.$mp3.$m4a.$ogg.$wav.$wma.']'); ?>
            <?php } ?>
        </div>

<?php } elseif( $format == 'gallery' ) { ?>
		<div class="postformat-gallery">
			<div class="postformat-gallery-wrap momizat-custom-slider">
			<?php 
				global $posts_st;
				$extra = get_post_meta($id , $posts_st->get_the_id(), TRUE);
				$slides = isset($extra['slides']) ? $extra['slides'] : '';
				if (is_array($slides)) { 
				foreach($slides as $slide) {
					$imgid = isset($slide['imgid']) ? $slide['imgid'] : '';
					if ($imgid == '') { $imgid = $slide; }
					$img = wp_get_attachment_image_src($imgid, 'large');
					$img = $img[0];
					$imgFull = wp_get_attachment_image_src($imgid, 'full');
					$imgFull = $imgFull[0];
					$caption = isset($slide['caption']) ? $slide['caption'] : '';
					$link = isset($slide['link']) ? $slide['link'] : $imgFull;
					if (!isset($slide['link']) || $slide['link'] == '') { $lightbox = 'class= "lightbox-img"';} else {$lightbox = '';} 
					$target = isset($slide['target']) ? 'target="'.$slide['target'].'"' : '';			
				?>
				<div class="postformat-gallery-item">
				    <a href="<?php echo $link; ?>" <?php echo $lightbox.$target; ?>><img src="<?php echo $img; ?>" width="100%" height="415" alt="gallery" /></a>
				    <?php if (isset($slide['caption']) != '') { ?><div class="postformat-gallery-cap"><h2><?php echo $caption; ?> </h2></div><!--End Caption--><?php } ?>
				</div>
		    <?php } } ?>
			</div>
			<script>
	        jQuery(document).ready(function($) {
	            //widget slider
	          $('.postformat-gallery-wrap').owlCarousel({
					animateOut: 'fadeOut',
					animateIn: '',
					autoplay:true,
					autoHeight:true,
					items:1,
					nav: true,
					 navText: ['<span class="enotype-icon-arrow-left7"></span>',
						'<span class="enotype-icon-uniE6D8"></span>'
					],
		});
	        });
			</script>
			
		</div>
		
<?php } else {
    $mom_post_layout = get_post_meta($post->ID, 'mom_post_layout', true);
    if ($mom_post_layout == '') {
	$mom_post_layout = mom_option('post_layout');
    }
		if ($mom_post_layout == 'layout5') {
				if(mom_option('post_feaimage') == 1) {
						if (mom_post_image() != false) {
								?>
								<figure class="post-thumbnail" itemprop="associatedMedia" itemscope="" itemtype="http://schema.org/ImageObject">
								<?php
								echo '<img class="post_layout_5_img" src="'.mom_post_image('full').'" alt="'.get_the_title().'">';
								?></figure><?php
								if($PCT != '') { ?><div class="photo-credit img-pct"><i class="momizat-icon-camera"></i><?php _e('Photo Credit To ', 'framework'); ?><?php echo $PCT; ?></div><?php }
						}
				}
		}
} ?>