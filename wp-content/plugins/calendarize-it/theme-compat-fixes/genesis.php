<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/

//Bug fix, when using genesis, event pages are defining as canonical url the url of the event template.
//this causes shares to output incorrect data.
add_filter( 'genesis_canonical_url', 'rhc_genesis_canonical_url', 10, 1 );

function rhc_genesis_canonical_url( $canonical ){
	if( is_singular() ){
		global $post;
		if( is_object( $post ) && property_exists( $post, 'post_type' ) && RHC_EVENTS == $post->post_type ){
			return get_permalink( $post->ID );
		}
	}	

	return $canonical ;
}
?>