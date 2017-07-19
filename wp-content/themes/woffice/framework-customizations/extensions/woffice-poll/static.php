<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
/**
 * LOAD THE JAVASCRIPT FOR THE FORM
 */
if ( !is_admin() ) {

		$ext_instance = fw()->extensions->get( 'woffice-poll' );

		wp_enqueue_script(
			'fw-extension-'. $ext_instance->get_name() .'-woffice-poll-scripts',
			$ext_instance->locate_js_URI( 'woffice-poll-scripts' ),
			array( 'jquery'),
			$ext_instance->manifest->get_version(),
			true
		);

		wp_localize_script('fw-extension-'. $ext_instance->get_name() .'-woffice-poll-ajax', 'fw-extension-'. $ext_instance->get_name() .'-woffice-poll-ajax', array('ajaxurl' =>  admin_url('admin-ajax.php')));

    if(!function_exists('woffice_poll_ajax')) {
        function woffice_poll_ajax() {
            echo '<script type="text/javascript">
			jQuery(document).ready( function() {
				jQuery("#woffice_poll").submit(ajaxSubmit);
		
				function ajaxSubmit(){
				
					var woffice_poll = jQuery(this).serialize();
				
					jQuery.ajax({
						type:"POST",
						url: "'.get_site_url().'/wp-admin/admin-ajax.php",
						data: woffice_poll,
						success:function(data){
							jQuery("#woffice_ajax_validation").html(data);
						},
						complete:function(){
					        jQuery("#poll-loader").slideUp();
					    }
					});
				
					return false;
				}
			});
			</script>';
        }
    }
		add_action( 'wp_head', 'woffice_poll_ajax' );
}