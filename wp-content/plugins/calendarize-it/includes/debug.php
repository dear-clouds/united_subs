<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/

if('debug_calendarize'!=get_class($this))die('No access');

function debug_wrap_textarea($text,$properties='class="widefat" rows="10"'){
	return sprintf("<textarea %s>%s</textarea>",$properties,$text);
}

function debug_wordpress_version(){
	global $wp_version;
	return $wp_version;
}

function debug_cal_version(){
	return RHC_VERSION;
}

function debug_template_path(){
	global $rhc_plugin;
	return $rhc_plugin->get_template_path();
}

function debug_saved_options(){
	global $rhc_plugin;
	$options = get_option($rhc_plugin->options_varname);
	return debug_wrap_textarea(print_r($options,true));
}

function debug_loaded_options(){
	global $rhc_plugin;
	return debug_wrap_textarea(print_r($rhc_plugin->options,true));
}

function debug_saved_rewrite_rules(){
	$options = get_option( 'rewrite_rules' );
	return debug_wrap_textarea(print_r($options,true));
}

function debug_loaded_rewrite_rules(){
	global $wp_rewrite;
	return debug_wrap_textarea(print_r($wp_rewrite,true));
}

function debug_wprewrite_rewrite_rules(){
	global $wp_rewrite;
	return debug_wrap_textarea(print_r($wp_rewrite->rewrite_rules(),true));
}

function debug_htaccess(){
	if( file_exists(ABSPATH.'.htaccess') ){
		$ht = file_get_contents(ABSPATH.'.htaccess');
		return debug_wrap_textarea($ht);
	}
	return '.htaccess not found';
}

function debug_implemented_shortcode(){
	global $wpdb;
	$sql = "SELECT ID, post_title FROM $wpdb->posts WHERE post_status=\"publish\" AND post_content LIKE \"%[calendarizeit%\" LIMIT 100";
	$ids = $wpdb->query($sql);
	if($wpdb->num_rows>0){
		foreach($wpdb->last_result as $id){
			echo $id->post_title . "<br />&nbsp;&nbsp;" . site_url('/?p='.$id->ID) . "<br />";
		}
	}else{
		return 'none';
	}
}

function debug_fc_range_set(){
	global $wpdb;
	$sql = "SELECT COUNT(O.post_id) AS total FROM $wpdb->postmeta O LEFT JOIN $wpdb->postmeta P ON (O.post_id=P.post_id AND P.meta_key='fc_range_start') WHERE P.meta_id IS NULL AND (O.meta_key='fc_start' AND O.meta_value!='')";
	$total = intval($wpdb->get_var($sql,0,0));
	if($total>0){
		return sprintf('There are %s post(s) that do not have the fc_range_start post meta field set.',$total);
	}else{
		return 'fc_range_start set OK.';
	}
}

function debug_php_version(){
	return phpversion();
}

function debug_version_3_1_4_query(){
	global $wpdb;		
	//---
	$tables = $wpdb->get_results("show tables like '{$wpdb->prefix}rhc_events'");
	if (!count($tables)){
		return "<span style='color:red;'>".sprintf(__('%s database table not found.','rhc'), "{$wpdb->prefix}rhc_events" )."</span>";
	}
	
	$count = $wpdb->get_var("SELECT COUNT(*) FROM `{$wpdb->prefix}rhc_events`",0,0);
	$out = sprintf(__('%s database table exists. Contains %s records.','rhc'), "{$wpdb->prefix}rhc_events", $count );
	
	$wpdb->query("SELECT * FROM `{$wpdb->prefix}rhc_events` ORDER BY RAND() LIMIT 3");
	$out.="<pre>".print_r($wpdb->last_result,true)."</pre>";
	return $out;
}

function debug_wp_options_row_count(){
	global $wpdb;		
	//---
	$count = $wpdb->get_var("SELECT COUNT(*) FROM `{$wpdb->options}`;",0,0);
	$out = sprintf(__('Options contains %s records.','rhc'), $count );
	
	return $out;
}

function debug_wp_posts_row_count(){
	global $wpdb;		
	//---
	$count = $wpdb->get_var("SELECT COUNT(*) FROM `{$wpdb->posts}`;",0,0);
	$out = sprintf(__('Posts contains %s records.','rhc'), $count );
	
	return $out;
}

function debug_wp_postmeta_row_count(){
	global $wpdb;		
	//---
	$count = $wpdb->get_var("SELECT COUNT(*) FROM `{$wpdb->postmeta}`;",0,0);
	$out = sprintf(__('Postmeta contains %s records.','rhc'), $count );
	
	return $out;
}

function debug_template_meta_data(){
	global $rhc_plugin,$wpdb;
	$template_id = $rhc_plugin->get_option( 'event_template_page_id', 0, true );
	if( $template_id > 0 ){
		$sql = sprintf( "SELECT meta_key FROM `{$wpdb->postmeta}` WHERE post_id=%s", intval($template_id) );
		$fields = $wpdb->get_col( $sql, 0 );
		if( is_array( $fields ) && count( $fields ) > 0 ){
			$out = implode(', ', $fields);
		}else{
			$out = __('Event template does not have any meta data.','rhc');
		}
	}else{
		$out = __('Event template not set','rhc');
	}
	return $out;
}

function debug_righthere_service(){
	global $rhc_plugin;
	$api_url = 'secondary'==$rhc_plugin->get_option('righthere_api_url','',true) ? 'http://plugins.albertolau.com/' : 'http://plugins.righthere.com/';
	$url = sprintf('%s?content_service=get_status&site_url=%s',
		$api_url,
		urlencode(site_url('/'))
	);	
	$output = array();
	$output[] = sprintf( "Contacting %s...", $api_url );

	if(!class_exists('righthere_service'))require_once RHC_PATH.'options-panel/class.righthere_service.php';
	$rh = new righthere_service();
	$response = $rh->rh_service($url);

	if( 'OK' == $response->R ){
		$output[] = __('Connection with RightHere service successful.','rhc');
	}else{ 
		$msg = sprintf( __('Network error: %s'), 
			$rh->last_error_str
		);
		$output[] = sprintf("<textarea cols=70 rows=5 >%s</textarea>",$msg);
	}
	
	//f9cbbeed9aa00d99a69ce52268d493e0
	
	return implode( '<br>', $output );		
}

function debug_ssl(){
	$output = array();
	$output[] = "WP_CONTENT_URL:" . WP_CONTENT_URL;
	$output[] = "site_url():". site_url();
	$output[] = "is_ssl():". ( is_ssl() ? 'returns true' : 'returns false' ) ;
	
	$arr = parse_url( WP_CONTENT_URL );
	$brr = parse_url( site_url() );
	$brr['scheme']='https';
	if( $arr['scheme']!=$brr['scheme'] ){
		$output[] = "<div style='background-color:red;display:inline-block;'>WP_CONTENT_URL and site_url() protocol does not match</div>";
		$output[] = "Verify that Settings->General site url and wordpress url match the site protocol";
	}
	
	return implode( '<br>', $output );		
}

function debug_theme_id(){
	$theme = wp_get_theme();
	$filename = str_replace(' ','-', strtolower($theme->get('Name'))).'.php';
	$output = "Theme id: " . $theme ."<br>" . "Compat filename: " .$filename."<br>";
	$path = RHC_PATH.'theme-compat-fixes/'.$filename;
	if( file_exists( $path ) ){
		$output.="Using compatibility file at: " . $path. "<br>";
	}else{
		$output.="There are no compatibility files for this theme.";
	}
	return $output;
}

$items = array(
	'debug_wordpress_version' => __('WordPress version','rhc'),
	'debug_cal_version'	=> __('Calendarize It version','rhc'),
	'debug_php_version'	=> __('PHP version','rhc'),
	'debug_theme_id' 	 => __('Theme','rhc'),
	'debug_template_path'  => __('Template path','rhc'),
	'debug_saved_options'	=> __('Saved options','rhc'),
	'debug_loaded_options'	=> __('Loaded options','rhc'),
	'debug_saved_rewrite_rules'	=> __('Saved Rewrite rules','rhc'),
	'debug_loaded_rewrite_rules'	=> __('Loaded $wp_rewrite','rhc'),
	'debug_wprewrite_rewrite_rules'	=> __('Rewrite rules as returned by $wp_rewrite->rewrite_rules()','rhc'),
	'debug_htaccess' => __('.htaccess content','rhc'),
	'debug_implemented_shortcode' => __('Published calendar (pages containing calendarizeit shortcode)','rhc'),
	'debug_fc_range_set' => __('fc_range_set meta data','rhc'),
	'debug_version_3_1_4_query' => __('Version 3.1.4 ajax query','rhc'),
	'debug_wp_options_row_count' => __('Options row count','rhc'),
	'debug_wp_posts_row_count' => __('Posts row count','rhc'),
	'debug_wp_postmeta_row_count' => __('Postmeta row count','rhc'),
	'debug_template_meta_data' => __('Event template meta data','rhc'),
	'debug_ssl' => __('SSL related issues'),
	'debug_righthere_service'	=> __('Communication with RightHere Version/Updates/DLC service','rhc')
);


$items = apply_filters('rhc_debug_items',$items);
?>
<div class="wrap">
	<div id="icon-options-general" class="icon32"><br></div>
	<h2>Debugging info</h2>
	<div class="debug-cont">
		<?php foreach($items as $method => $label):?>
		<div class="item">
			<h3><?php echo $label?></h3>
			<div class="widefat">
				<?php echo function_exists($method)?$method():sprintf(__('Unknown function %s','rhc'),$method)?>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
</div>
