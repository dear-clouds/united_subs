<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

/*---------------------------------------------------------
** 
** TRICK TO CHECK IF THE EXTENSIONS IS ENABLED
**
----------------------------------------------------------*/
function woffice_directory_extension_on(){
	return;
}

/*---------------------------------------------------------
** 
** JS FOR THE MAP IN THE FOOTER
**
----------------------------------------------------------*/		
function woffice_directory_js_load(){
	/*WE check for the page*/
	if(is_page_template("page-templates/page-directory.php") || is_tax( 'directory-category' )) {
		
		echo fw()->extensions->get( 'woffice-directory' )->woffice_directory_map_js_main();
		
	}
	if(is_singular("directory")) {
		
		echo fw()->extensions->get( 'woffice-directory' )->woffice_directory_map_js_single();
		
	}
}
add_action('wp_footer', 'woffice_directory_js_load');