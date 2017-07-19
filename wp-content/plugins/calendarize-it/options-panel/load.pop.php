<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/
if(!function_exists('rh_register_php')):
 
function rh_register_php($id,$path,$version){
	global $rh_php_commons;
	$rh_php_commons = isset($rh_php_commons)&&is_array($rh_php_commons)?$rh_php_commons:array();
	$rh_php_commons[$id][$version]=(object)array('version'=>$version,'path'=>$path);
}


function rh_php_commons(){
	//if(did_action('rh-php-commons')>1)return;
	global $rh_php_commons;
	if(is_array($rh_php_commons)&&count($rh_php_commons)>0){
		foreach($rh_php_commons as $id => $brr){
			if( isset($rh_php_commons[$id]['included']) )continue;
			$sorted = krsort($brr);
			$include = array_shift($brr);
			$rh_php_commons[$id]['included']=$include;
			require_once($include->path);
		}
	}	
}

add_action('rh-php-commons', 'rh_php_commons'); 
endif;
?>