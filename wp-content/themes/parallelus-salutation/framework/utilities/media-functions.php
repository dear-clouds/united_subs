<?php

/*
 * Resize images dynamically using wp built in functions
 * Victor Teixeira
 *
 * php 5.2+
 *
 * Exemplo de uso:
 * 
 * <?php 
 * $thumb = get_post_thumbnail_id(); 
 * $image = vt_resize( $thumb, '', 140, 110, true );
 * ?>
 * <img src="<?php echo $image[url]; ?>" width="<?php echo $image[width]; ?>" height="<?php echo $image[height]; ?>" />
 *
 * @param int $attach_id
 * @param string $img_url
 * @param int $width
 * @param int $height
 * @param bool $crop
 * @return array
 */
if ( ! function_exists( 'vt_resize' ) ) :

	function vt_resize( $attach_id = null, $img_url = null, $width = 0, $height = 0, $crop = false ) {
		global  $blog_id;

		// placeholder images
		$use_placeholders = get_theme_var('options,placeholder_images');
		$custom_placeholder = get_theme_var('options,custom_placeholder');
		if ( !$img_url && $use_placeholders ) {
			$img_url = ($custom_placeholder) ? $custom_placeholder : THEME_URL .'assets/images/placeholder.jpg';
		}
		
		// this is an attachment, so we have the ID
		if ( $attach_id ) {
		
			$image_src = wp_get_attachment_image_src( $attach_id, 'full' );
			$file_path = get_attached_file( $attach_id );
		
		// this is not an attachment, let's use the image url
		} else if ( $img_url ) {
			
			$file_path = parse_url( $img_url );
			$file_path = $_SERVER['DOCUMENT_ROOT'] . $file_path['path'];
			
			if (!file_exists($file_path)) {
				// Double check for some kind of virtual path that fails with $_SERVER['DOCUMENT_ROOT']
				$imageParts = explode(site_url(), $img_url, 2);
				if (isset($imageParts[1])) {
					$file_path = ABSPATH  . $imageParts[1];
				}
				// if not found with the backup path...
				if (!file_exists($file_path)) {
					// simple fix for direct links to images on multi-site installs
					if (isset($blog_id) && $blog_id > 0) {
						// uploaded images to media folders
						$imageParts = explode('/files/', $img_url, 2);
						if (isset($imageParts[1])) {
							$img_url = get_site_url(1) .'/wp-content/blogs.dir/'. $blog_id .'/files/'. $imageParts[1];
							$file_path = parse_url( $img_url );
							$file_path = $_SERVER['DOCUMENT_ROOT'] . $file_path['path'];
						}
						// if not found in media folders check theme folders
						if (!file_exists($file_path)) {
							// files in the theme folder
							$imageParts = explode(THEME_URL, $img_url, 2);
							if (isset($imageParts[1])) {
								$file_path = THEME_DIR . $imageParts[1];
							}
							// one more check, helps with child theme support
							if ( !file_exists($file_path) && is_child_theme() ) {
								// files in the parent theme folder
								$imageParts = explode(trailingslashit(TEMPLATEPATH), $img_url, 2);
								if (isset($imageParts[1])) {
									$file_path = trailingslashit(TEMPLATEPATH) . $imageParts[1];
								}
							}
						}
					}
				}
			}

			
			//$file_path = ltrim( $file_path['path'], '/' );
			//$file_path = rtrim( ABSPATH, '/' ).$file_path['path'];
			
			if (file_exists($file_path)) {
				
				$orig_size = getimagesize( $file_path );
			
				$image_src[0] = $img_url;
				$image_src[1] = $orig_size[0];
				$image_src[2] = $orig_size[1];
				
			} else {
				// couldn't find the image so set the values back to what was provided and return
				$vt_image = array (
					'url' => $img_url,
					'width' => $width,
					'height' => $height
				);
				
				return $vt_image;
			}
		}

		// if no image size was sent... use the original
		if(!$width && !$height) {
			$width =  $image_src[1];
			$height = $image_src[2];
		}
		if($width && !$height) {
			$height = ceil($width/($image_src[1]/$image_src[2]));
		}

		$file_info = pathinfo( $file_path );
		$extension = '.'. $file_info['extension'];
	
		// the image path without the extension
		$no_ext_path = $file_info['dirname'].'/'.$file_info['filename'];
	
		$cropped_img_path = $no_ext_path.'-'.$width.'x'.$height.$extension;
		
		// if no image size was sent... use the original
		//if (!$width) $width =  $image_src[1];
		//if (!$height) $height =  $image_src[2];
	
		// checking if the file size is larger than the target size
		// if it is smaller or the same size, stop right here and return
		if ( $image_src[1] > $width || $image_src[2] > $height ) {
	
			// the file is larger, check if the resized version already exists (for $crop = true but will also work for $crop = false if the sizes match)
			if ( file_exists( $cropped_img_path ) ) {
	
				$cropped_img_url = str_replace( basename( $image_src[0] ), basename( $cropped_img_path ), $image_src[0] );
				
				$vt_image = array (
					'url' => $cropped_img_url,
					'width' => $width,
					'height' => $height
				);
				
				return $vt_image;
			}
	
			// $crop = false
			if ( $crop == false ) {
			
				// calculate the size proportionaly
				$proportional_size = wp_constrain_dimensions( $image_src[1], $image_src[2], $width, $height );
				$resized_img_path = $no_ext_path.'-'.$proportional_size[0].'x'.$proportional_size[1].$extension;			
	
				// checking if the file already exists
				if ( file_exists( $resized_img_path ) ) {
				
					$resized_img_url = str_replace( basename( $image_src[0] ), basename( $resized_img_path ), $image_src[0] );
	
					$vt_image = array (
						'url' => $resized_img_url,
						'width' => $proportional_size[0],
						'height' => $proportional_size[1]
					);
					
					return $vt_image;
				}
			}
	
			// no cache files - let's finally resize it
			// .............................................................

			// first, make sure the directory is writable.
			if (is_writable($file_info['dirname'].'/')) {
				// it's writable, let's do some resizing!
				$file_info = pathinfo($file_path);
				$img_path_save = str_replace($file_info['filename'], $file_info['filename'].'-'.$width.'x'.$height,$file_path);
				$img_url = str_replace(basename($image_src[0]), basename($img_path_save), $image_src[0]);
				$new_img_path = wp_get_image_editor( $file_path );
				if ( ! is_wp_error( $new_img_path ) ) {
				    $new_img_path->resize( $width, $height, $crop );
					$new_img_path->save($img_path_save);
				}
				$new_img_size['width'] = $width;
				$new_img_size['height'] = $height;						
				$new_img = $img_url;//str_replace( basename( $image_src[0] ), basename( $new_img_path ), $image_src[0] );
			} else {
				// nope, directory isn't writable. return the original file info
				$new_img_size['width'] = $width;
				$new_img_size['height'] = $height;
				$new_img = $img_url;
			}
	
			// set image data for output
			$vt_image = array (
				'url' => $new_img,
				'width' => $new_img_size['width'],
				'height' => $new_img_size['height']
			);
			
			return $vt_image;
		}
	
		// default output - without resizing
		$vt_image = array (
			'url' => $image_src[0],
			'width' => $image_src[1],
			'height' => $image_src[2]
		);
	
		return $vt_image;
	}

endif;

// Embed video, requires swfobject
function embed_video($url, $width, $height, $id = false, $method = 'swf') {
	
	if (!$id) $id = 'video_' . base_convert(microtime(), 10, 36);
	
	$flashvars = '{}';
	$params = '{ wmode: "transparent", allowfullscreen: "true", allowscriptaccess: "always" }';
	$attributes = '{}';
	
	switch ($method) {
		
		case 'youtube-iframe':
			echo '<div id="'. $id .'"><iframe src="'. $url .'" width="'. $width .'" height="'. $height .'" frameborder="0" allowfullscreen></iframe></div>';
			break;
		case 'vimeo-iframe':
			echo '<div id="'. $id .'"><iframe src="'. $url .'" width="'. $width .'" height="'. $height .'" frameborder="0"></iframe></div>';
			break;
		default: // $method = 'swfobject'
			echo '<script type="text/javascript"> swfobject.embedSWF("'. $url .'", "'. $id .'", "'. $width .'", "'. $height .'", "9.0.0", "", '. $flashvars . ', '. $params .', '. $attributes .'); </script>';
			echo '<div id="'. $id .'">'.
				 '<p><a href="'. $url .'" target="_blank">Watch video</a></p>'.
				 '<p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>'.
				 '</div>';
	}
		 
}



/* Source: http://forrst.com/posts/Grab_Youtube_or_Vimeo_Info_with_PHP-0el  */

function video_info($url) {

// Handle Youtube
if ( strpos($url, "youtube.com") || strpos($url, "youtu.be") ) {
    $url = preg_match('/(youtu\.be\/|&*v=|\/v\/|\/embed\/)+([A-Za-z0-9\-_]{5,11})/', $url, $output);
    $video_id = $output[2];
    $data['video_type'] = 'youtube';
    $data['video_id'] = $video_id;
	// next part requires PHP 5.1+
	if (function_exists('simplexml_load_file')) {
		$xml = simplexml_load_file("http://gdata.youtube.com/feeds/api/videos?q=$video_id");
	
		foreach ($xml->entry as $entry) {
			// get nodes in media: namespace
			$media = $entry->children('http://search.yahoo.com/mrss/');
			
			// get video player URL
			$attrs = $media->group->player->attributes();
			$watch = $attrs['url']; 
			
			// get video thumbnail
			$data['thumb_1'] = $media->group->thumbnail[0]->attributes(); // Thumbnail 1
			$data['thumb_2'] = $media->group->thumbnail[1]->attributes(); // Thumbnail 2
			$data['thumb_3'] = $media->group->thumbnail[2]->attributes(); // Thumbnail 3
			$data['thumb_large'] = $media->group->thumbnail[3]->attributes(); // Large thumbnail
			$data['tags'] = $media->group->keywords; // Video Tags
			$data['cat'] = $media->group->category; // Video category
			$attrs = $media->group->thumbnail[0]->attributes();
			$thumbnail = $attrs['url']; 
			
			// get <yt:duration> node for video length
			$yt = $media->children('http://gdata.youtube.com/schemas/2007');
			$attrs = $yt->duration->attributes();
			$data['duration'] = $attrs['seconds'];
			
			// get <yt:stats> node for viewer statistics
			$yt = $entry->children('http://gdata.youtube.com/schemas/2007');
			$attrs = $yt->statistics->attributes();
			$data['views'] = $viewCount = $attrs['viewCount']; 
			$data['title']=$entry->title;
			$data['info']=$entry->content;
			
			// get <gd:rating> node for video ratings
			$gd = $entry->children('http://schemas.google.com/g/2005'); 
			if ($gd->rating) {
				$attrs = $gd->rating->attributes();
				$data['rating'] = $attrs['average']; 
			} else { $data['rating'] = 0;}
			
			// record the source of the data
			$data['xml'] = true;

		} // End foreach
	} else {
		$data['xml'] = false;
	} // End function_exists('simplexml_load_file')
} // End Youtube

// Handle Vimeo
else if (strpos($url, "vimeo.com")) {
    $video_id=explode('vimeo.com/', $url);
    $video_id=$video_id[1];
    $data['video_type'] = 'vimeo';
    $data['video_id'] = $video_id;
	// next part requires PHP 5.1+
	if (function_exists('simplexml_load_file')) {
		$xml = simplexml_load_file("http://vimeo.com/api/v2/video/$video_id.xml");
			
		foreach ($xml->video as $video) {
			$data['id']=$video->id;
			$data['title']=$video->title;
			$data['info']=$video->description;
			$data['url']=$video->url;
			$data['upload_date']=$video->upload_date;
			$data['mobile_url']=$video->mobile_url;
			$data['thumb_small']=$video->thumbnail_small;
			$data['thumb_medium']=$video->thumbnail_medium;
			$data['thumb_large']=$video->thumbnail_large;
			$data['user_name']=$video->user_name;
			$data['urer_url']=$video->urer_url;
			$data['user_thumb_small']=$video->user_portrait_small;
			$data['user_thumb_medium']=$video->user_portrait_medium;
			$data['user_thumb_large']=$video->user_portrait_large;
			$data['user_thumb_huge']=$video->user_portrait_huge;
			$data['likes']=$video->stats_number_of_likes;
			$data['views']=$video->stats_number_of_plays;
			$data['comments']=$video->stats_number_of_comments;
			$data['duration']=$video->duration;
			$data['width']=$video->width;
			$data['height']=$video->height;
			$data['tags']=$video->tags;

			// record the source of the data
			$data['xml'] = true;

		} // End foreach
	} else {
		$data['xml'] = false;
	} // End function_exists('simplexml_load_file')
} // End Vimeo

// Set false if invalid URL
else { $data = false; }

return $data;

}







?>