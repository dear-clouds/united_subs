<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

/**
 * Returns the Button Upload for the cover
 */
function woffice_upload_cover_btn() {
	
	$ext_instance = fw()->extensions->get( 'woffice-cover' );
	
	if( function_exists('bp_is_active') && bp_is_active( 'xprofile' ) ) {
		
		/* We display it only if it's the user on his own profile or if the current user is an admin*/
		if (bp_is_my_profile() || woffice_current_is_admin()) {
			
			$displayed_user_ID = bp_displayed_user_id();

			/* We check if the user has a cover image */
			$cover_image = $ext_instance->woffice_cover_member_state($displayed_user_ID);
			
			$extra_style = " style='display:none;'";

			if ($cover_image == false){
				echo'<button id="woffice_cover_upload" class="btn-cover-upload"><i class="fa fa-camera"></i></button>';
				echo'<button id="woffice_cover_delete" class="btn-cover-upload" '.$extra_style.'><i class="fa fa-times"></i></button>';
			}
			else {
				echo'<button id="woffice_cover_upload" class="btn-cover-upload" '.$extra_style.'><i class="fa fa-camera"></i></button>';
				echo'<button id="woffice_cover_delete" class="btn-cover-upload"><i class="fa fa-times"></i></button>';
			}
			
		}
		
	}
	
}

/**
 * Custom Directory for the upload
 */
function woffice_cover_upload_dir($upload) {
	
	$upload['subdir'] = '/woffice-covers' . $upload['subdir'];
	$upload['path']   = $upload['basedir'] . $upload['subdir'];
	$upload['url']    = $upload['baseurl'] . $upload['subdir'];
	return $upload;

}

