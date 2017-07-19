<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/

class righthere_service {
	function __construct(){
	
	}
	
	function rh_service($url){
		//@ini_set('memory_limit','100M');
		@set_time_limit ( 360 );	
		$args = array('timeout'=>360);
		$this->build_post( $url, $args );
		$request = wp_remote_post( $url , $args );

		if ( is_wp_error($request) ){
			$this->last_error_str = $request->get_error_message();
			return false;
		}else{
			$r = json_decode($request['body']);
			if(is_object($r)&&property_exists($r,'R')){
				return $r;
			}else{
				$this->last_error_str = $request['body'];
				return false;
			}	
		}
		return false;
	}

	function build_post( &$url, &$args ){
		$url_data = parse_url($url);
		
		$params = array();
		parse_str($url_data['query'], $params);
		$params = is_array($params) ? $params : array();
		
		$args['body']=$params;
		
		if(isset($url_data['query']))
			unset($url_data['query']);
			
		$url = $this->build_url( $url_data );		
	}
	
	static function build_url($url_data) {
	    $url="";
	    if(isset($url_data['host']))
	    {
	        $url .= $url_data['scheme'] . '://';
	        if (isset($url_data['user'])) {
	            $url .= $url_data['user'];
	                if (isset($url_data['pass'])) {
	                    $url .= ':' . $url_data['pass'];
	                }
	            $url .= '@';
	        }
	        $url .= $url_data['host'];
	        if (isset($url_data['port'])) {
	            $url .= ':' . $url_data['port'];
	        }
	    }
	    $url .= $url_data['path'];
	    if (isset($url_data['query'])) {
	        $url .= '?' . $url_data['query'];
	    }
	    if (isset($url_data['fragment'])) {
	        $url .= '#' . $url_data['fragment'];
	    }
	    return $url;
	}	
}
?>