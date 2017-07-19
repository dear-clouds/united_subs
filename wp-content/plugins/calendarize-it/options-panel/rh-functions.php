<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/
/**
 * Register new Javascript file; check if it is already registered, if it is compare versions (assumes numerical version number), and registers.
 *
 * 
**/
function rh_enqueue_script( $handle, $src, $deps = array(), $ver = false, $in_footer = false ) {
	return rh_register_script( $handle, $src, $deps, $ver, $in_footer, true );
}

function rh_register_script( $handle, $src, $deps = array(), $ver = false, $in_footer = false, $enqueue=false ) {
	if( wp_script_is( $handle,'done') ) return false; //already printed.
	global $wp_scripts;
	if ( ! is_a( $wp_scripts, 'WP_Scripts' ) ) {
		$wp_scripts = new WP_Scripts();
	}
	
	$query = isset($wp_scripts->registered[$handle])?$wp_scripts->registered[$handle]:false;
	$register = true;
	if( wp_script_is( $handle, 'queue' ) || wp_script_is( $handle, 'to_do' ) ){	
		$enqueue = true;
		if( $ver && $query && $ver < $query->ver ){
			$register = false;
		}else{
			wp_deregister_script( $handle );
		}
	}else if( wp_script_is( $handle, 'registered' ) ){
		if( $ver && $query && $ver < $query->ver ){
			$register = false;
		}else{
			wp_deregister_script( $handle );
		}
	}
	
	if($enqueue){
		if($register)wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer );
	}else{
		if($register)wp_register_script( $handle, $src, $deps, $ver, $in_footer );
	}
}
?>