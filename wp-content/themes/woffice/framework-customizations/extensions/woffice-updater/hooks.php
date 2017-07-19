<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
		
/**
* CHeck for new version - Update
*/

//set_site_transient('update_themes', null);

function woffice_pre_set_transient_update_theme ( $transient ) {
	
	/*We first check if it's the purchase code has been entered */
	$status = get_option('woffice_license');
	if ($status == "checked") {
		
		if( empty( $transient->checked) )
			return $transient;
			
		$theme_version = fw()->theme->manifest->get('version');
		$theme_slug = fw()->theme->manifest->get('id');
		
		$request_string = array(
			'body' => array( 
				'action' => 'check_updated', 
			    'version' => $theme_version
			)
		);
		/* We use our API */
		//$raw_response = wp_remote_post( 'http://alka-web.com/woffice-updater/theme-updater.php', $request_string );
		$raw_response = wp_remote_post( 'https://woffice.io/updater/theme-updater.php', $request_string );
      
		/* We check */
		$response = null;
    	if( !is_wp_error($raw_response) && ($raw_response['response']['code'] == 200) ) {
    		$response = unserialize($raw_response['body']);
    	}
    	
    	if( !empty($response) ) // Feed the update data into WP updater
			$transient->response[$theme_slug] = $response;
    	
    	return $transient;
		
	}

} 
add_filter ( 'pre_set_site_transient_update_themes', 'woffice_pre_set_transient_update_theme' );