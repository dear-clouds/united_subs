<?php
/**
 * Custom Plugin Upgrader class
 */


// Prevent direct call
if ( !defined( 'WPINC' ) ) die;
if ( !class_exists( 'GW_GoPricing' ) ) die;	

// Include original class
include_once( ABSPATH . 'wp-admin/includes/class-wp-upgrader.php' );

// Class
class GW_GoPricing_Plugin_Upgrader extends Plugin_Upgrader {
	

	/**
	 * Validate unzipped temporary plugin
	 *	 	 
	 * @return array | bool
	 */

	public function validate_upload( $source, $product_data ) {
		
		if ( empty( $source ) || empty( $product_data['name'] ) || empty( $product_data['version'] ) ) return false;		
		$folders = glob( $source . '/*', GLOB_ONLYDIR );
		if ( empty( $folders ) || !is_array( $folders ) ) return false;
		
		$files = glob( trailingslashit( $folders[0] ) . '*.php' );
        
		if ( $files ) {
            foreach ( $files as $file ) {

                $info = get_plugin_data( $file, false, false );			

                if ( !empty( $info['Name'] ) && !empty( $info['Version'] ) ) {
					
					if ( in_array( $info['Name'], (array)$product_data['name'] ) &&
						 version_compare( $info['Version'], $product_data['version'], '>=' ) ) return $file;
						                     
                }
            }
        }

		return false;		
	
	}
	
	
	/**
	 * Plugin Update function
	 *
	 * @return object | bool
	 */	
	
	public function update_plugin( $plugin, $plugin_base, $args = array() ) {

		$defaults = array( 'clear_update_cache' => true );
		$parsed_args = wp_parse_args( $args, $defaults );

		$this->init();
		$this->upgrade_strings();

		add_filter( 'upgrader_pre_install', array( $this, 'deactivate_plugin_before_upgrade' ), 10, 2 );
		add_filter( 'upgrader_clear_destination', array( $this, 'delete_old_plugin' ), 10, 4 );

		$result = $this->run( 
			array(
				'package' => $plugin,
				'destination' => WP_PLUGIN_DIR,
				'clear_destination' => true,
				'clear_working' => true,
				'is_multi' => true,			
				'hook_extra' => array(
					'plugin' => $plugin_base,
					'type' => 'plugin',
					'action' => 'update',
				),
			)
		);

		// Cleanup our hooks, in case something else does a upgrade on this connection.
		remove_filter( 'upgrader_pre_install', array( $this, 'deactivate_plugin_before_upgrade' ) );
		remove_filter( 'upgrader_clear_destination', array( $this, 'delete_old_plugin' ) );

		if ( ! $this->result || is_wp_error( $this->result ) ) return $this->result;

		// Force refresh of plugin update information
		wp_clean_plugins_cache( $parsed_args['clear_update_cache'] );

		return true;
		
	}	

}

?>