<?php

/**
 * Get Boss theme options
 *
 *
 * @param string $id Option ID.
 * @param string $param Option type.
 *
 * @return $output False on failure, Option.
 */
if ( !function_exists( 'boss_get_option' ) ) {

	function boss_get_option( $id, $param = null ) {

		global $boss_options;

		/* Check if options are set */
		if ( !isset( $boss_options ) ) {
			return false;
		}

		/* Check if array subscript exist in options */
		if ( empty( $boss_options[ $id ] ) ) {
			return false;
		}

		/**
		 * If $param exists,  then
		 * 1. It should be 'string'.
		 * 2. '$boss_options[ $id ]' should be array.
		 * 3. '$param' array key exists.
		 */
		if ( !empty( $param ) && is_string( $param ) && (!is_array( $boss_options[ $id ] ) || !array_key_exists( $param, $boss_options[ $id ] ) ) ) {
			return false;
		}

		return apply_filters( 'boss_redux_option_value', empty( $param ) ? $boss_options[ $id ] : $boss_options[ $id ][ $param ], $id, $param );
	}

}