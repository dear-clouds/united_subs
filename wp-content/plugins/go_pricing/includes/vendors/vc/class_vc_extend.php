<?php
/**
 * Visual Composer Extend class
 */


/* Prevent direct call */
if ( ! defined( 'WPINC' ) ) { die; }

class GW_GoPricing_VCExtend {

	protected static $instance = null;


	/**
	 * Initialize the class
	 */

	public function __construct() {
		
         add_action( 'init', array( $this, 'integrateWithVC' ) );
		 
    }
 
 
	/**
	 * Return an instance of this class
	 *
	 * @return object
	 */
	 
	public static function instance() {
		
		if ( self::$instance == null ) self::$instance = new self;
		return self::$instance;
		
	}	
 
 
	/**
	 * Add to Visual Composer
	 */ 
 
    public function integrateWithVC() {

		$names = array();
		$pricing_tables = GW_GoPricing_Data::get_tables( '', false, 'title', 'ASC' );

		if ( !empty( $pricing_tables ) ) {
			foreach ( $pricing_tables as $pricing_table ) {
				if ( !empty( $pricing_table['name'] ) && !empty( $pricing_table['id'] ) ) {
					$names[] = $pricing_table['name'];
					$name_count = array_count_values( $names );
					$dropdown_data[sprintf('%1$s (#%2$s)', $pricing_table['name'], $pricing_table['postid'])] = $pricing_table['id'];
				}
			}
		}
		
		if ( empty( $dropdown_data ) ) $dropdown_data[0] = __('No tables found!', 'go_pricing_textdomain' );
		
		
		if ( function_exists( 'vc_map' ) ) {
		
			vc_map( array (
				'name' => __( 'Go Pricing', 'go_pricing_textdomain' ),
				'description' => __( 'Amazing responsive pricing tables', 'go_pricing_textdomain' ),
				'base' => 'go_pricing',
				'category' => __( 'Content', 'go_pricing_textdomain' ),	
				'class' => '',
				'controls' => 'full',
				'icon' => plugin_dir_url( __FILE__ ) . 'assets/go_pricing_32x32.png',
				'params' => array(
					array(
						'type' => 'dropdown',
						'heading' => __( 'Table Name', 'go_pricing_textdomain' ),
						'param_name' => 'id',
						'value' => $dropdown_data,
						'description' => __( 'Select Pricing Table', 'go_pricing_textdomain' ),
						'admin_label' => true,
						'save_always' => true
					)
				)
			) );

		}
				
    }

}
