<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

class FW_Extension_Woffice_Cover extends FW_Extension {

	/**
	 * @internal
	 */
	public function _init() {

	}
	
	/**
	 * We check if the user has a cover image, if yes we return the URL of the image
	 */
	public function woffice_cover_member_state($user_ID) {
	
		if (function_exists('bp_is_active')):
			if ( bp_is_active( 'xprofile' ) ) {
				
				$the_cover = bp_get_profile_field_data(array('field' => 'Woffice_Cover', 'user_id' => $user_ID));	
				if (!empty($the_cover)) {
					return $the_cover;
				}
				else {
					return false;
				}
				
			}
			else {
				return false;
			}
		endif;
	

	}
	
}