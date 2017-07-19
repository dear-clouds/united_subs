<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

class FW_Extension_Woffice_Funfacts extends FW_Extension {

	/**
	 * @internal
	 */
	public function _init() {
	
	}
	
	/**
	 * CREATE FUNCTIONS TO GET THE VALUES FROM THE EXTENSION'S SETTINGS
	 * @return array
	 */
	/* THE FUNFACTS QUESTION */
	public function woffice_get_funfacts() {
		return fw_get_db_ext_settings_option( $this->get_name(), 'funfacts' );
	}
	
}