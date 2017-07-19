<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

/**
 * LOAD THE JAVASCRIPT FOR THE FORM
 */
if ( !is_admin() ) {

	$ext_instance = fw()->extensions->get( 'woffice-cover' );

	if (function_exists('bp_is_active')):

        if (bp_is_my_profile() || (bp_is_user() && woffice_current_is_admin())):
			
			wp_localize_script('fw-extension-'. $ext_instance->get_name() .'-woffice-cover-ajax', 'fw-extension-'. $ext_instance->get_name() .'-woffice-cover-ajax', array('ajaxurl' =>  admin_url('admin-ajax.php')));
		
			wp_enqueue_script(
				'fw-simple-ajax-uploader',
				$ext_instance->get_declared_URI( '/static/js/SimpleAjaxUploader.min.js' ),
				array( 'jquery' ),
				'1.0',
				true
			);

		endif;
		
	endif;
	
}