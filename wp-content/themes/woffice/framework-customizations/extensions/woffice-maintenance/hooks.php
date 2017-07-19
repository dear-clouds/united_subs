<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

/**
 * Check if the there are defined views for the portfolio templates, otherwise are used theme templates
 *
 * @param string $template
 *
 * @return string
 */
function woffice_filter_fw_ext_maintenance_template_include( $template ) {
	
	$maintenance = fw()->extensions->get( 'woffice-maintenance' );
	
	if ( is_page( 'maintenance' )  ) {
		$new_template = $maintenance->locate_view_path( 'page-maintenance' );
		if ( '' != $new_template ) {
			return $new_template ;
		}
	}

	return $template;
	
}
add_filter( 'template_include', 'woffice_filter_fw_ext_maintenance_template_include' );

/**
 * Redirect user to the maintenance page
 */
function woffice_maintenance_redirect_user() {
	
	/* We get the data */
	$maintenance_status = fw_get_db_ext_settings_option( 'woffice-maintenance', 'maintenance_status' ); 

	/*If Enabled*/
	if ($maintenance_status == "on" && !current_user_can('edit_themes')) {
			
		$maintenance_url = esc_url( home_url( '/maintenance/' ) );
		if (!is_page(array('maintenance','login'))){
			wp_redirect( $maintenance_url );
			exit;	
		}
		
	}
	
}

add_action( 'template_redirect', 'woffice_maintenance_redirect_user' );

	
