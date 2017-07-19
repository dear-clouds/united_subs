<?php

/*
 * Resize images dynamically using wp built in functions
 * Victor Teixeira
 * Tweaked by Pirenko
 *
 * php 5.2+
 *
 * Usage Sample:
 * 
 * <?php 
 * $thumb = get_post_thumbnail_id(); 
 * $image = vt_resize( $thumb, '', 140, 110, true );
 * ?>
 *
 * @param int $attach_id
 * @param string $img_url
 * @param int $width
 * @param int $height
 * @param bool $crop
 * @param bool $retina
 * @return array
 */
if ( ! function_exists( 'vt_resize' ) ) :

	function vt_resize( $attach_id = null, $img_url = null, $width = 0, $height = 0, $crop = false , $retina = false) {
		global  $blog_id;
		$divider=1;
		if ($retina==true)
		{
			$width=$width*2;
			$height=$height*2;
			$divider=2;
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
							$imageParts = explode('THEME_URL', $img_url, 2);
							if (isset($imageParts[1])) {
								$file_path = THEME_DIR . $imageParts[1];
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
				if (0)
				{
					//ORIGINAL IMAGE IS BIGGER - DO NOTHING
					$vt_image = array (
						'url' => $img_url,
						'width' => $orig_size[0],
						'height' => $orig_size[1],
						'not_found' => 'false'
					);
					return $vt_image;
				}
				
			} else {
				// couldn't find the image so set the values back to what was provided and return
				$vt_image = array (
					'url' => $img_url,
					'width' => $width,
					'height' => $height,
					'not_found' => 'true'
				);
				
				return $vt_image;
			}
		}
		if (!isset($file_path)) {
			$file_path = '';
		}
		$file_info = pathinfo($file_path);
		
		//ID WAS RECEIVED, BUT NO IMAGE WAS FOUND
		if ($file_info['basename']=="") {
			return;
		}
			
		$extension = '.'. $file_info['extension'];

		//EXCLUDE GIF FILES
		if($extension ==".gif") 
		{
			$vt_image = array (
				'url' => $img_url,
				'width' => $width,
				'height' => $height,
				'not_found' => 'false'
			);
			return $vt_image;
		}
	
		// the image path without the extension
		$no_ext_path = $file_info['dirname'].'/'.$file_info['filename'];
	
		$cropped_img_path = $no_ext_path.'-'.$width.'x'.$height.$extension;
		
		// if no image size was sent... use the original
		if (!$width) $width =  $image_src[1];
		if (!$height) $height =  $image_src[2];
	
		//FORCE SMALL IMAGES TO APPEAR BIGGER
		if ($image_src[1] < $width)
			$image_src[1]=$width+2;
		if ($image_src[2] < $height )
			$image_src[2] = $height+2;
		if ( $image_src[1] > $width || $image_src[2] > $height ) {
	
			// the file is larger, check if the resized version already exists (for $crop = true but will also work for $crop = false if the sizes match)
			if ( file_exists( $cropped_img_path ) ) {
	
				$cropped_img_url = str_replace( basename( $image_src[0] ), basename( $cropped_img_path ), $image_src[0] );
				
				$vt_image = array (
					'url' => $cropped_img_url,
					'width' => $width/$divider,
					'height' => $height/$divider,
					'not_found' => 'false'
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
						'width' => $proportional_size[0]/$divider,
						'height' => $proportional_size[1]/$divider,
						'not_found' => 'false'
					);
					
					return $vt_image;
				}
			}
	
			// no cache files - let's finally resize it
			// .............................................................

			// first, make sure the directory is writable.
			if (is_writable($file_info['dirname'].'/')) {
				// it's writable, let's do some resizing!
				//WP 3.5 compatible
				//$new_img_path = image_resize( $file_path, $width, $height, $crop, NULL, NULL, 100 );
				$editor = wp_get_image_editor( $file_path );
				if ( is_wp_error( $editor ) ) {
					//SOMETHING WENT WRONG. PROBABLY THE GD LIBRARY IS OFF:http://bhoover.com/wp_image_editor_supports-tutorial-example/ 
					//LET'S RETURN THE ORIGINAL IMAGE
					$vt_image = array (
					'url' => $img_url,
					'width' => $width,
					'height' => $height,
					'not_found' => 'false');
					return $vt_image;
				}
				$editor->set_quality( 88 );
			
				$resized = $editor->resize( $width, $height, $crop );
			
				$dest_file = $editor->generate_filename( NULL, NULL );
				$saved = $editor->save( $dest_file );
			
				if ( is_wp_error( $saved ) ) {
					//SOMETHING WENT WRONG. PROBABLY THE GD LIBRARY IS OFF:http://bhoover.com/wp_image_editor_supports-tutorial-example/ 
					//LET'S RETURN THE ORIGINAL IMAGE
					//CHECK IF WE RECEIVED AN ID
					if ($img_url=="")
					{
						$img_url=$image_src[0];
					}
					$vt_image = array (
					'url' => $img_url,
					'width' => $width,
					'height' => $height,
					'not_found' => 'false');
					return $vt_image;
				}

				$new_img_path=$dest_file;
				//END WP 3.5 compatible
				if (is_string($new_img_path)) {
					$new_img_size = getimagesize( $new_img_path );
					$new_img = str_replace( basename( $image_src[0] ), basename( $new_img_path ), $image_src[0] );
				} else {
					// nope, something is preventing the image from resizing
					$new_img_size[0] = $width/$divider;
					$new_img_size[1] = $height/$divider;
					$new_img = $img_url;
				}
				
			} else {
				// nope, directory isn't writable. return the original file info
				$new_img_size[0] = $width/$divider;
				$new_img_size[1] = $height/$divider;
				$new_img = $img_url;
			}
	
			// set image data for output
			$vt_image = array (
				'url' => $new_img,
				'width' => $new_img_size[0]/$divider,
				'height' => $new_img_size[1]/$divider,
				'not_found' => 'false'
			);
			
			return $vt_image;
		}
	
		// default output - without resizing
		$vt_image = array (
			'url' => $image_src[0],
			'width' => $image_src[1]/$divider,
			'height' => $image_src[2]/$divider,
			'not_found' => 'false'
		);
		
		return $vt_image;
	}

endif;

//ALLOW IMAGE ENLARGE - ONLY WHEN CROP IS SET TO TRUE
function image_crop_dimensions($default, $orig_w, $orig_h, $new_w, $new_h, $crop){
    if ( !$crop ) return null; // let the wordpress default function handle this

    $aspect_ratio = $orig_w / $orig_h;
    $size_ratio = max($new_w / $orig_w, $new_h / $orig_h);

    $crop_w = round($new_w / $size_ratio);
    $crop_h = round($new_h / $size_ratio);

    $s_x = floor( ($orig_w - $crop_w) / 2 );
    $s_y = floor( ($orig_h - $crop_h) / 2 );

    return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h );
}


add_filter('image_resize_dimensions', 'image_crop_dimensions', 10, 6);

?>