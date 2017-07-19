<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
/**
 * LOAD THE JAVASCRIPT FOR THE MAP
 */
if ( !is_admin() ) {

	$ext_instance = fw()->extensions->get( 'woffice-map' );
	
	if (function_exists('bp_is_active')):
		/*GET BUDDYPRESS AND CURENT POST INFO*/
		global $bp;
		global $post;
		/*THE MEMBERS SLUG SET IN THE SETTINGS*/
		$members_root = BP_MEMBERS_SLUG;
		/*THE CURRENT POST SLUG*/
		if (is_page()){
			$post_name = get_post( $post )->post_title;
		}
		else {
			$post_name = "nothing";
		}
		$current_slug = sanitize_title($post_name);
		/*THEN WE CHECK
			DOESNT WORK ! -> WIDGET ISSUE ... NO API
		*/
		//if($members_root == $current_slug) {
	
			wp_enqueue_script(
				'fw-extension-'. $ext_instance->get_name() .'-google-map',
				'https://maps.googleapis.com/maps/api/js?key=AIzaSyAyXqXI9qYLIWaD9gLErobDccodaCgHiGs',
				true
			);
		
		//}
	endif;
	
}