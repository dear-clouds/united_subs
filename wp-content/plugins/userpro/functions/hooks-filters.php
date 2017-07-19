<?php
	
	/* Overrides default avatars */
	function userpro_get_avatar( $avatar, $id_or_email, $size, $default, $alt='' ) {
		global $userpro;
 		require_once(userpro_path.'lib/BFI_Thumb.php');
		if (isset($id_or_email->user_id)){
			$id_or_email = $id_or_email->user_id;
		} elseif (is_email($id_or_email)){
			$user = get_user_by('email', $id_or_email);
			$id_or_email = $user->ID;
		}
		
		if ($id_or_email && userpro_profile_data( 'profilepicture', $id_or_email ) ) {
			
			$url = $userpro->file_uri(  userpro_profile_data( 'profilepicture', $id_or_email ), $id_or_email );
	        $params = array('width'=>$size);
			if(!userpro_get_option('aspect_ratio')){
				$params['height'] = $size;			
			}
			if(userpro_get_option('pimg')==1)
			{
				$crop=bfi_thumb($url,$params);
			}
			else 
			{
				$crop = bfi_thumb(get_site_url().(strpos($url,"http") !== false ? urlencode($url) : $url),$params);
			}
			$return = '<img src="'.$crop.'" width="'.$size.'" height="'.$size.'" alt="'.$alt.'" class="modified avatar" />';
		
		} else {
		
			if ($id_or_email && userpro_profile_data( 'gender', $id_or_email ) ) {
				$gender = strtolower( userpro_profile_data( 'gender', $id_or_email ) );
			} else {
				$gender = 'male'; // default gender
			}
		
			$userpro_default = userpro_url . 'img/default_avatar_'.$gender.'.jpg';
			$return = '<img src="'.$userpro_default.'" width="'.$size.'" height="'.$size.'" alt="'.$alt.'" class="default avatar" />';
		
		}

		if ( userpro_profile_data( 'profilepicture', $id_or_email ) != '') {
			return $return;
		} else {
			if ( userpro_get_option('use_default_avatars') == 1 ) {
				return $avatar;
			} else {
				return $return;
			}
		}
	}
	add_filter('get_avatar', 'userpro_get_avatar', 99, 5);
	
	/* shortcode allowed in sidebar */
	add_filter('widget_text', 'do_shortcode');
