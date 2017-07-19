<?php
/*
 * Plugin Name: Compare Ninja - Comparison Tables
 * Plugin URI: http://compareninja.com
 * Description: Add <strong>beautiful comparison tables</strong> to your Wordpress website on-the-fly. No prior knowledge require. Just a simple integration with Compare Ninja.
 * Version: 1.0.0
 * Author: Common Ninja
 * Author URI: http://commoninja.com/
 * License: GPLv2 or later
 */

/*
 * Shortcode to diplay Compare Ninja table in your site.
 * 
 *	   The list of arguments is below:
 *     'tableid' (string) - Table ID
 */
 
function compareninja_shortcode( $atts ) {
	extract( shortcode_atts( array(
		'tableid' => '1'
	), $atts ) );

	$siteUrl = "http";
	
	if ($_SERVER["HTTPS"] == "on") {$siteUrl .= "s";}
		$siteUrl .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$siteUrl .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$siteUrl .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	
	$html = "
	<div id=\"compareNinjaTable_$tableid\">
		<img src=\"" . plugins_url() . "/compare-ninja-comparison-tables/images/loader_small.gif\" style=\"display: block; width: 18px; margin: 50px auto 0;\" />
		<p style=\"display: none;\">Created with Compare Ninja</p>
	</div>
	<script type=\"text/javascript\">
	(function() {
		var cn = document.createElement('script'); cn.type = 'text/javascript';
		cn.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'compareninja.com/API/table/$tableid?cnurl=' + window.location.href;
		var s = document.getElementsByTagName('head')[0].appendChild(cn);
	})();
	</script>";

	return $html;
}

add_shortcode( 'compareninja', 'compareninja_shortcode' );


/*
 * Compare Ninja tinyMCE button registration
 */
 
function compareninja_register_button( $buttons ) {
   array_push( $buttons, "|", "compareninja" );
   return $buttons;
}

function compareninja_add_plugin( $plugin_array ) {
   $plugin_array['compareninja'] = plugins_url() . '/compare-ninja-comparison-tables/js/compareninja.js';
   return $plugin_array;
}

function compareninja_add_button() {

   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
      return;
   }

   if ( get_user_option('rich_editing') == 'true' ) {
      add_filter( 'mce_external_plugins', 'compareninja_add_plugin' );
      add_filter( 'mce_buttons', 'compareninja_register_button' );
   }

}

add_action('init', 'compareninja_add_button');

?>