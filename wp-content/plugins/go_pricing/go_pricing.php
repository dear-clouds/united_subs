<?php
/**
 * Plugin Name: Go Pricing - WordPress Responsive Pricing Tables
 * Plugin URI:  http://go-pricing.com
 * Description: The New Generation Pricing Tables. If you like traditional Pricing Tables, but you would like get much more out of it, then this rodded product is a useful tool for you.
 * Version:     3.3.1
 * Author:      Granth
 * Author URI:  http://granthweb.com
 * Text Domain: go_pricing_textdomain
 * Domain Path: /lang
 */


// Prevent direct call
if ( !defined( 'WPINC' ) ) die;

// Prevent redeclaring class
if ( class_exists( 'GW_GoPricing' ) ) wp_die ( __( 'GW_GoPricing class has already been declared!', 'go_pricing_textdomain' ) );	

// Include & init main class
include_once( plugin_dir_path( __FILE__ ) . 'includes/class_go_pricing.php' );
GW_GoPricing::instance( __FILE__ );

// Register activation / deactivation / uninstall hooks
register_activation_hook( __FILE__, array( 'GW_GoPricing', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'GW_GoPricing', 'deactivate' ) );
register_uninstall_hook( __FILE__, array( 'GW_GoPricing', 'uninstall' ) );

?>