<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/

function _do_shortcode($t){return $t;}
function get_term_image($term_id){
	$out = '';
	$image = get_term_meta($term_id,'image',true);
	
	//taxonomy image addon
	if( defined('RHC_ETI_VERSION') ){
		$images = get_option( 'term-images' );
		if( is_array( $images ) && isset( $images[ $term_id ] ) ){
			$src = wp_get_attachment_image_src( $images[ $term_id ], 'full', false );
			if( isset( $src[0] ) ){
				$image = $src[0];
			}			
		}
	}
	
	//interoperability:
	if( function_exists('get_term_thumbnail') && trim($image)==''){
		//fallback to the term thumbnail plugin
		$image = get_term_thumbnail( $term_id, 'full', array(
			'class' => "venue-image"
		) );
		return $image;
	}
	
	if(trim($image)!=''){
		$out = sprintf('<img class="venue-image" src="%s"/>',$image);
	}
	return $out;
}
function get_gaddress_link(){

}
function get_google_staticmap($term_id,$w=300,$h=223,$zoom=15){
	$icon_url = urlencode((RHC_URL.'css/images/mapmarker.png'));
	$gaddress = get_term_meta($term_id,'gaddress',true);

	if(trim($gaddress)=='')return '';

	$gaddress = urlencode($gaddress);

	$tpl = sprintf('<img src="https://maps.google.com/maps/api/staticmap?size=%sx%s',$w,$h);
	
	$tpl.= "&amp;center=$gaddress";
	$tpl.= "&amp;zoom=$zoom";
	$tpl.= "&amp;markers=icon:$icon_url%7C$gaddress";
	$tpl.= '" alt="Map">';
	$tpl.= "<a href=\"http://www.google.com/maps?f=q&hl=en&source=embed&q=$gaddress\">".__('Larger map','rhc')."</a>";
	return $tpl;
}

function get_gmap_shortcode_from_term_id($term_id,$canvas_width=960,$canvas_height=250,$zoom=14){
	$address = get_term_meta($term_id,'gaddress',true);
	if(trim($address)==''){
		$address = get_term_meta($term_id,'address',true);

		foreach(array('city','state','zip','country') as $field){
			$$field = get_term_meta($term_id,$field,true);
		}
		/*
		if($city!=''){
			$address.=", $city";
		}
		*/
		if($zip!=''||$state!=''){
			$address.=", $state $zip";
		}
		
		if($country!=''){
			$address.=", $country";
		}
	}
	
	return sprintf('[venue_gmap canvas_width="%s" canvas_height="%s" zoom="%s" address="%s" info_windows="%s" glat="%s" glon="%s"]',
		$canvas_width,
		$canvas_height,
		$zoom,
		$address,
		get_term_meta($term_id,'ginfo',true),
		get_term_meta($term_id,'glat',true),
		get_term_meta($term_id,'glon',true)
	);
}

function the_tax_title(){
	global $term_id,$taxonomy;
	$term = get_term($term_id,$taxonomy);
	echo $term->name;
}

function the_tax_content(){
	echo get_the_tax_content();
}

function get_the_tax_content(){
	global $term_id,$taxonomy;
	$out = '';
	if($term_id&&$taxonomy){
		$term = get_term($term_id,$taxonomy);
		$content = get_term_meta($term_id,'content',true);
		$content = trim($content)==''?$term->description:$content;
		$out = $content;
	}
	return $out;
}

function the_tax_map(){
	global $term_id;
	echo get_gmap_shortcode_from_term_id($term_id);
}

function the_tax_website(){
	global $term_id;
	$website = get_term_meta($term_id,'website',true);
	$href = false===strpos($website,'://')?'http://'.$website:$website;
	echo sprintf('<a target="_blank" class="venue-website" href="%s">%s</a>',$href,$website);
}

function the_tax_image(){
	echo get_the_tax_image();
}

function get_the_tax_image(){
	global $term_id;	
	return get_term_image($term_id);
}

function the_tax_detail($arg){
	global $term_id;
	extract(shortcode_atts(array(
		'field'		=> 'undefined',
		'label'		=> 'undefined',
		'tpl'		=> '<div class="venue-{field}"><label class="tax-{field}">{label}</label>{value}</div>',
		'skip_empty'=> true,
		'echo'		=> true
	),$arg));
	
	$value = get_term_meta($term_id,$field,true);
	
	$value = apply_filters('term_detail',$value,$field,'venue',$term_id);
	
	$tpl = str_replace('{field}',$field,$tpl);
	$tpl = str_replace('{label}',$label,$tpl);
	$tpl = str_replace('{value}',$value,$tpl);
	
	if($skip_empty && trim($value)==''){
		$tpl='';
	}
	
	if($echo){
		echo $tpl;
	}
	return $tpl;
}

function the_term_meta($meta){
	global $term_id;
	echo get_term_meta($term_id,$meta,true);
}

///----- move somewhere else:
add_filter('term_detail','term_detail_filter',10,4);
function term_detail_filter($value,$field,$taxonomy,$term_id=null){
	if(''!=$value && 'venue'==$taxonomy && $field=='website'){
		$website = $value;
		$href = false===strpos($website,'://')?'http://'.$website:$website;
		$value = sprintf('<a target="_blank" class="venue-website" href="%s">%s</a>',$href,$website);
	}
	if($term_id>0 && ''==$value && 'venue'==$taxonomy && $field=='gaddress'){
		//if gaddress is empty, build one from the other terms.
		$tmp = array();
		foreach(array('address','zip','state','country') as $field){
			$val = get_term_meta($term_id,$field,true);
			if(''!=trim($val)){
				$tmp[$field]=$val;
			}		
		}
		$value = implode(', ',$tmp);
	}
	return $value;
}

function get_repeat_start_date($post_id,$date_format='Y-m-d H:i:s'){
	global $rhc_plugin;
	if(isset($_REQUEST['event_rdate'])){
		$arr = explode(',',$_REQUEST['event_rdate']);
		$start = $arr[0];	
		if( '1' == $rhc_plugin->get_option( 'validate_event_rdate', '0', true ) ){
			global $wpdb;
			$sql = sprintf( "select post_id from {$wpdb->prefix}rhc_events where post_id=%s and event_start='%s';", 
				intval( $post_id ),
				intval( $arr[0] ) 
			);
			if( $post_id != $wpdb->get_var( $sql, 0, 0) ){
				//falback to original date.
				$start = get_post_meta($post_id,'fc_start_datetime',true);
			}
		}
	}else{
		$start = get_post_meta($post_id,'fc_start_datetime',true);
	}
	$ts = strtotime($start);
	if( false===$date_format ){
		return $ts;
	}else{
		return date($date_format,$ts);
	}
}

function get_repeat_end_date($post_id,$date_format='Y-m-d H:i:s'){
	global $rhc_plugin;
	if(isset($_REQUEST['event_rdate'])){
		$arr = explode(',',$_REQUEST['event_rdate']);
		$date = $arr[1];
		if( '1' == $rhc_plugin->get_option( 'validate_event_rdate', '0', true ) ){
			global $wpdb;
			$sql = sprintf( "select post_id from {$wpdb->prefix}rhc_events where post_id=%s and event_end='%s';", 
				intval( $post_id ),
				intval( $arr[1] ) 
			);
			if( $post_id != $wpdb->get_var( $sql, 0, 0) ){
				//falback to original date.
				$start = get_post_meta($post_id,'fc_end_datetime',true);
			}
		}			
	}else{
		$date = get_post_meta($post_id,'fc_end_datetime',true);
	}
	$ts = strtotime($date);
	if( false===$date_format ){
		return $ts;
	}else{
		return date($date_format,$ts);
	}
}

function fc_get_repeat_start_date($post_id,$fc_date_format=false){
	if(false===$fc_date_format){
		global $rhc_plugin;
		$fc_date_format = $rhc_plugin->get_option('cal_eventlistdateformat','dddd MMMM d, yyyy',true);
	}
	$date = get_repeat_start_date( $post_id, false );//false returns a ts 
	
	return fc_date_format( $date, $fc_date_format );
	/*
	return sprintf("<script type=\"text/javascript\">try{document.write(jQuery.fullCalendar.formatDate( jQuery.fullCalendar.parseDate('%s'), '%s', %s ))}catch(e){}</script>",
		$date,
		$fc_date_format,
		fc_get_date_options()
	);
	*/
}

function fc_get_repeat_end_date($post_id,$fc_date_format=false){
	if(false===$fc_date_format){
		global $rhc_plugin;
		$fc_date_format = $rhc_plugin->get_option('cal_eventlistdateformat','dddd MMMM d, yyyy',true);
	}
	$date = get_repeat_end_date( $post_id, false );
	
	return fc_date_format( $date, $fc_date_format );
	/*
	return sprintf("<script type=\"text/javascript\">try{document.write(jQuery.fullCalendar.formatDate( jQuery.fullCalendar.parseDate('%s'), '%s', %s ))}catch(e){}</script>",
		$date,
		$fc_date_format,
		fc_get_date_options()
	);
	*/
}

function fc_get_date_options( $json_encode=true, $for_php_date = false ){
	global $rhc_plugin;
	
	$map = array(
		'monthNames'		=> array('cal_monthnames', __('January,February,March,April,May,June,July,August,September,October,November,December','rhc') ),
		'monthNamesShort'	=> array('cal_monthnamesshort', __('Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,Oct,Nov,Dec','rhc') ),
		'dayNames'			=> array('cal_daynames', __('Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday','rhc') ),
		'dayNamesShort'		=> array('cal_daynamesshort', __('Sun,Mon,Tue,Wed,Thu,Fri,Sat','rhc') )
	);
	$options = (object)array();
	foreach($map as $name => $opt){
		$option 	= $opt[0];
		$default	= $opt[1];
		if( $for_php_date ){
			$value = $rhc_plugin->get_option($option,$default,true);
			$value = preg_replace('/((?<!\\\\)[dDjlNSwzWFmMntLoYyaABgGhHisueIOPTZcrU])/', '\\\\$1', $value );
		}
		$options->$name = explode(',',str_replace(' ','', $value ));
	}
	
	if( $json_encode ){
		return json_encode($options);
	}else{
		return $options;
	}
}

function php_date_format_from_fc_format( $fc_format ){
	$result = preg_replace_callback( array(
		"('(([^']|'')*)')",
		'((?<!\\\\)u)',
		'((?<!\\\\)TT)',
		'((?<!\\\\)T)',
		'((?<!\\\\)tt)',
		'((?<!\\\\)t)',
		'((?<!\\\\)yyyy)',
		'((?<!\\\\)yy)',
		'((?<!\\\\)MMMM)',
		'((?<!\\\\)MMM)',
		'((?<!\\\\)MM)',
		'((?<!\\\\|¿)M)',
		'((?<!\\\\)dddd)',
		'((?<!\\\\)ddd)',
		'((?<!\\\\)dd)',
		'((?<!\\\\|¿)d)',
		'((?<!\\\\)HH)',
		'((?<!\\\\|¿)H)',
		'((?<!\\\\)hh)',
		'((?<!\\\\|¿)h)',
		'((?<!\\\\)mm)',
		'((?<!\\\\|¿)m)',
		'((?<!\\\\)ss)',
		'((?<!\\\\)s)'
	) , function( $matches ){
		$map = array(
			's' 	=> 's',
			'ss'	=> 's',
			'm'		=> 'i',
			'mm'	=> 'i',
			'h'		=> 'g',
			'hh'	=> '¿h',
			'H'		=> 'G',
			'HH'	=> '¿H',
			'd'		=> 'j',
			'dd'	=> '¿d',
			'ddd'	=> '¿D',
			'dddd'	=> '¿l',
			'M'		=> 'n',
			'MM'	=> '¿m',
			'MMM'	=> '¿M',
			'MMMM'	=> '¿F',
			'yy'	=> 'y',
			'yyyy'	=> 'Y',
			't'		=> 'a',
			'tt'	=> 'a',
			'T'		=> 'A',
			'TT'	=> 'A',
			'u'		=> 'c'
		);

		if( preg_match( "('(([^']|'')*)')", $matches[0], $smatches ) ){
			$out = str_replace( "''", "'", $smatches[1] );
			$out = preg_replace('/((?<!\\\\)[dDjlNSwzWFmMntLoYyaABgGhHisueIOPTZcrU])/', '\\\\$1', $out);
			return $out;
		}

		$replacements = array();
		foreach( $matches as $m ){
			$replacements[] = isset( $map[$m] ) ?  $map[$m] : $m;
		}
		return $replacements[0];
	}, $fc_format);
	
	foreach( array(
		'¿h' => 'h',
		'¿H' => 'H',
		'¿d' => 'd',
		'¿m' => 'm'
	) as $replace => $with ){
		$result = str_replace( $replace, $with, $result );
	}	
	
	return $result;
}	

function fc_date_format( $ts, $fc_format, $options=false ){	
	if( false===$options ){
		$options = fc_get_date_options( false, true );
	}

	$php_date_format = php_date_format_from_fc_format( $fc_format );
	
	$month = intval( date('n', $ts ) ) - 1;//¿F ¿M
	$dow = intval( date('w', $ts ) ); //¿l ¿D

    $php_date_format = str_replace( '¿F', $options->monthNames[$month], $php_date_format );
    $php_date_format = str_replace( '¿M', $options->monthNamesShort[$month], $php_date_format );
    $php_date_format = str_replace( '¿l', $options->dayNames[$dow], $php_date_format );
    $php_date_format = str_replace( '¿D', $options->dayNamesShort[$dow], $php_date_format );
    
	return date( $php_date_format, $ts );
}
?>