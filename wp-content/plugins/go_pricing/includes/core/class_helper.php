<?php
/**
 * Helper class
 */


// Prevent direct call
if ( !defined( 'WPINC' ) ) die;
if ( !class_exists( 'GW_GoPricing' ) ) die;	

// Class
class GW_GoPricing_Helper {
		

	/**
	 * Clean inpu fields
	 *
	 * @return array
	 */
	 
	public static function clean_input( $data = array(), $format = 'filtered', $exclude_html_keys = array(), $exclude_all_keys = array() ) {
		
		foreach ( (array)$data as $key => $value ) {
			
			if ( is_array( $value ) ) { 
				$data[$key] = self::clean_input( $value, $format, $exclude_html_keys, $exclude_all_keys );	
			} else {
				if ( $format == 'html' || in_array( $key, (array)$exclude_html_keys, true  ) ) {
					$data[$key] = stripslashes( trim( $value ) );
				} elseif ( $format == 'raw' || in_array( $key, (array)$exclude_all_keys, true ) ) {
					$data[$key] = stripslashes( $value );
				} elseif ( $format == 'no_html' || in_array( $key, (array)$exclude_all_keys, true ) ) {
					$data[$key] = stripslashes( strip_tags( trim( $value ) ) );
				} else {
					$data[$key] = stripslashes( sanitize_text_field( $value ) );
				}
			}
			
		}
		
		return $data;
				
	}
	
	
	/**
	 * Remove input (remove private inputs)
	 *
	 * @return array
	 */	
	
	public static function remove_input( $data = array(), $keys = array(), $clean_private = true ) {
		
		foreach ( (array)$data as $key => $value ) {
			
			if ( is_array( $value ) ) { 			
				if ( in_array ( $key, (array)$keys, true ) || ( $clean_private === true && preg_match( '/(_.*)+/' , $key ) == 1 ) ) {
					unset( $data[$key] );
				} else {
					$data[$key] = self::remove_input( $value, $keys, $clean_private );
				}
			} else {
				if ( in_array ( $key, (array)$keys, true ) || ( $clean_private === true && preg_match( '/(_.*)+/' , $key ) == 1 ) ) unset( $data[$key] );										
			}
			
		}
		
		return $data;		
				
	}
	
	
	/**
	 * Parset data (remove private inputs)
	 *
	 * @return array
	 */	
	
	public static function parse_data( $data ) {
		
		if ( !is_string( $data ) || $data == '' ) return;
		
		parse_str( $data, $data );
		
		if ( function_exists( 'get_magic_quotes_gpc' ) && get_magic_quotes_gpc() ) $data = stripslashes_deep( $data );
		
		return $data;		
				
	}
	
	
	/**
	 * Escape % char in (s)printf arg
	 *
	 * @return string
	 */	
	 	
	
	public static function esc_sprint( $string ) {
		
		if ( empty( $string ) ) return $string;
				
		return preg_replace( '/[%]/', '%%', $string );
		
	}

}
 
?>