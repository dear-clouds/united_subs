<?php
/**
 * Plugin Update page controller class
 */
 
 
// Prevent direct call
if ( !defined( 'WPINC' ) ) die;
if ( !class_exists( 'GW_GoPricing' ) ) die;	


// Class
class GW_GoPricing_AdminPage_Update extends GW_GoPricing_AdminPage {
	
	/**
	 * Register ajax actions
	 *
	 * @return void
	 */	
	
	public function register_ajax_actions( $ajax_action_callback ) { 
	
		GW_GoPricing_Admin::register_ajax_action( 'update', $ajax_action_callback );
		
	}
	
	
	/**
	 * Action
	 *
	 * @return void
	 */
	 	
	public function action() {
		
		// Create custom nonce
		$this->create_nonce( 'update' );
		
		// Load views if action is empty		
		if ( empty( $this->action ) ) {
			
			$this->content( $this->view() );
			
		}
		
		// Load views if action is not empty (handle postdata)
		if ( !empty( $this->action ) && check_admin_referer( $this->nonce, '_nonce' ) ) {
			
			add_filter( 'upload_mimes', array( $this, 'restrict_upload_mimes') );
			add_filter( 'upload_dir', array( $this, 'set_upload_dir' ) );
			
			$result = $this->validate_upload( $_FILES );

			if ( $this->is_ajax === false ) {
				if ( $result === false ) {
					wp_redirect( $this->referrer );
				} else {
					wp_redirect( admin_url( 'admin.php?page=go-pricing' ) );
				}
				exit;
			} else {
				echo $this->view();
				GW_GoPricing_AdminNotices::show();
			}

		}
		
	}
	
	
	/**
	 * Load views
	 *
	 * @return void
	 */	
	
	public function view( $view = '' ) {

		ob_start();
		include_once( 'views/page/update.php' );
		return ob_get_clean();
		
	}

	
	/**
	 * Validate & return upload data
	 *
	 * @return string | bool
	 */		
	
	public function validate_upload( $upload_data ) {

		$product_id = isset( $_POST['product'] ) ? sanitize_key( $_POST['product'] ) : '';
		
		if ( $product_id == 'go_pricing' ) {
			
			$product = array(
				'name' => array( 'Go Pricing - WordPress Responsive Pricing Tables', 'Go - Responsive Pricing & Compare Tables' ),
				'version' => self::$plugin_version,
				'base' => $this->plugin_base
			);
			
		} else {
			
			global $go_pricing;
			
			if ( isset( $go_pricing['addons'] ) ) {
				$product_data = !empty( $go_pricing['addons'][$product_id] ) ? $go_pricing['addons'][$product_id] : '';
				
				if ( !empty( $product_data['name'] ) && $product_data['version']  && $product_data['base'] ) {
					$product = array(
						'name' => $product_data['name'],
						'version' => $product_data['version'],
						'base' => $product_data['base']
					);
					

					
				}
			}
			
		}
			
		if ( empty( $product ) )	{
			GW_GoPricing_AdminNotices::add( 'update', 'error', __( 'Invalid product!', 'go_pricing_textdomain' ) );	
			return false;
		}
		
		$product_name = '';	
		$product_name = is_array( $product['name'] ) ? $product['name'][0] : $product['name'];
								
		$hash = md5( microtime() );	
		
		if ( empty( $upload_data ) || empty( $upload_data['plugin-data'] ) || empty( $upload_data['plugin-data']['name'] ) || empty( $upload_data['plugin-data']['tmp_name'] ) || empty( $upload_data['plugin-data']['size'] ) ) {
		
			GW_GoPricing_AdminNotices::add( 'update', 'error', __( 'Please select a file to upload!', 'go_pricing_textdomain' ) );	
			return false;
			
		}
		
		if ( !empty( $upload_data['plugin-data']['error'] ) || ( $file_content = @file_get_contents( $_FILES['plugin-data']['tmp_name'] ) ) === false ) {
		
			GW_GoPricing_AdminNotices::add( 'update', 'error', __( 'Oops, something went wrong!', 'go_pricing_textdomain' ) );	
			return false;
			
		}
		
		$file = wp_upload_bits( $hash . '_' . $_FILES['plugin-data']['name'], '', $file_content );
		
		if ( empty( $file ) || empty( $file['file'] ) || !empty( $file['error'] ) ) {
		
			GW_GoPricing_AdminNotices::add( 'update', 'error', !empty( $file['error'] ) ? $file['error'] : __( 'Oops, something went wrong!', 'go_pricing_textdomain' ) );	
			return false;
			
		}
		
		if ( ( $fs = WP_Filesystem() ) === false ) {
			
			GW_GoPricing_AdminNotices::add( 'update', 'error', __( 'Oops, filesystem error!', 'go_pricing_textdomain' ) );
			unlink( $file['file'] );			
			return false;
			
		}

		global $wp_filesystem;
		
		$upload_dir = wp_upload_dir();
		$temp_dir_path = $upload_dir['path'] . '/' . $hash;
		$unzip_file = unzip_file( $file['file'], $temp_dir_path );		   
		
		if ( ! $unzip_file || !is_dir( $temp_dir_path ) ) {
			unlink( $file['file'] );
			GW_GoPricing_AdminNotices::add( 'update', 'error', __( 'Oops, something went wrong!', 'go_pricing_textdomain' ) );
			return false;	

		}
			
		$upgrader = new GW_GoPricing_Plugin_Upgrader( new GW_GoPricing_Plugin_Installer_Skin() );
		
		if ( ( $plugin_file = $upgrader->validate_upload( $temp_dir_path, $product ) ) === false ) {
			
			GW_GoPricing_AdminNotices::add( 'update', 'error', __( 'Invalid plugin file or version!', 'go_pricing_textdomain' ) );
			unlink( $file['file'] );
			$wp_filesystem->rmdir( $temp_dir_path, true );
			return false;		
			
		}
		
		// Delete temp folder
		$wp_filesystem->rmdir( $temp_dir_path, true );
		
		// Save file data to DB
		$uploads = get_option( self::$plugin_prefix . '_uploads', array() );
		$uploads[] = array(
			'file' => $file['file'],
			'expiration' => gmdate( 'Y-m-d H:i:s', time() + 5 * 60 )
		);
		
		update_option( self::$plugin_prefix . '_uploads', $uploads );
		
		$is_active_for_network = is_plugin_active_for_network( $product['base'] );
		
		if ( $result = $upgrader->update_plugin( $file['file'], $product['base'] ) === false ) {

			GW_GoPricing_AdminNotices::add( 'update', 'error', sprintf( __( '"%s" plugin update failed!', 'go_pricing_textdomain' ), $product_name ) );
			return false;
		}
		
		GW_GoPricing_AdminNotices::add( 'update', 'success', sprintf( __( '"%s" plugin updated successfully!', 'go_pricing_textdomain' ), $product_name ) );

		activate_plugin( $product['base'], NULL, $is_active_for_network, true );

		return $info;
		
	}
	
	
	/**
	 * Restrict allowed mimes
	 *
	 * @return array
	 */		
	
	public function restrict_upload_mimes( $mimes ) {
		
		$allowed_mimes = array( 'zip' => 'application/zip' );
		
		return $allowed_mimes;
		
	}
	
	
	/**
	 * Set custom upload path
	 *
	 * @return array
	 */		
	
	public function set_upload_dir( $param ) {
		
		$param['subdir'] = '/go_pricing_data';
		$param['path'] = $param['basedir'] . $param['subdir'];
				
		return $param;
		
	}		
	
}
 

?>