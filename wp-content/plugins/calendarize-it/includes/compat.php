<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/
 
/* WPML */ 
//add_filter('icl_set_current_language','rhc_icl_set_current_language');
function rhc_icl_set_current_language($lang){
	if(isset($_REQUEST['rhc_action'])&&isset($_REQUEST['lang']))return $_REQUEST['lang'];
	return $lang;
}
?>