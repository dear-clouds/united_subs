<?php
/**
 * Register Globals - Shadows
 */


// Prevent direct call
if ( !defined( 'WPINC' ) ) die;
if ( !class_exists( 'GW_GoPricing' ) ) die;	


/**
 * Shadows
 */	

$go_pricing['shadows'] = array (
	array(
		'name' => __( 'None', 'go_pricing_textdomain' ),
		'value' => ''
	),								
	array(
		'name' => sprintf( __( 'Shadow Style %s', 'go_pricing_textdomain' ), '1' ),
		'value' => 'shadow1', 
		'data' => $this->plugin_url . 'assets/admin/images/shadow_1.png'
	),
	array(
		'name' => sprintf( __( 'Shadow Style %s', 'go_pricing_textdomain' ), '2' ),
		'value' => 'shadow2', 
		'data' => $this->plugin_url . 'assets/admin/images/shadow_2.png'
	),
	array(
		'name' => sprintf( __( 'Shadow Style %s', 'go_pricing_textdomain' ), '3' ),
		'value' => 'shadow3', 
		'data' => $this->plugin_url . 'assets/admin/images/shadow_3.png'
	),
	array(
		'name' => sprintf( __( 'Shadow Style %s', 'go_pricing_textdomain' ), '4' ),
		'value' => 'shadow4', 
		'data' => $this->plugin_url . 'assets/admin/images/shadow_4.png'
	),
	array(
		'name' => sprintf( __( 'Shadow Style %s', 'go_pricing_textdomain' ), '5' ),
		'value' => 'shadow5', 
		'data' => $this->plugin_url . 'assets/admin/images/shadow_5.png'											
	)
);


// Global shadow filter
$go_pricing['shadows'] = apply_filters( 'go_pricing_shadows', $go_pricing['shadows'] );

?>