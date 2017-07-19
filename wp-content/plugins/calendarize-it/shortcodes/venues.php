<?php


class shortcode_venues {
	var $uid=100;
	var $gmap_footer_added=false;
	function __construct($shortcode){
		add_shortcode($shortcode, array(&$this,'handle_shortcode'));//default $shortcode is venue, given by RCH_VENUE
		add_shortcode("venue_gmap", array(&$this,'google_map'));
		
		add_shortcode("single_venue_gmap", array(&$this,'single_venue_gmap'));
		//add_shortcode("single_venue_description", array(&$this,'single_venue_description'));
		add_shortcode("tax_detail", array(&$this,'tax_detail'));
		//a venue specific wrapper for the taxonomymeta shortcode
		add_shortcode("venuemeta", array(&$this,'handle_venuemeta'));
		add_shortcode("organizermeta", array(&$this,'handle_venuemeta'));
	}
	
	function handle_venuemeta($atts,$template='',$code=""){
		extract(shortcode_atts(array(
			'term' 	=> ''
		), $atts));
		
		$map = array(
			'venuemeta'		=> RHC_VENUE,
			'organizermeta'	=> RHC_ORGANIZER
		);
		
		$output = sprintf("[taxonomymeta taxonomy='%s'%s] %s[/taxonomymeta]",
			$map[$code],
			($term==''?'':" term='$term'"),
			$template
		);	

		return do_shortcode($output);	
	}
	
	function tax_detail($atts,$template='',$code=""){
		extract(shortcode_atts(array(
			'field' 	=> '',
			'label'		=> ''
		), $atts));
		global $term_id;
		if(0==intval($term_id) || ''==trim($field))return '';
		ob_start();
		$field=strtolower($field);
		switch($field){
			case 'map':				
				echo $this->tax_detail_map($atts,$template,$code);
				break;
			case 'wrapped_map':				
				$val = $this->tax_detail_map($atts,$template,$code);
				if(''!=trim($val)){
					echo sprintf('<div class="venue-small-map">%s</div>', $val);
				}
				break;
			case 'title':
				the_tax_title();
				break;
			case 'wrapped_image':
				$val = get_the_tax_image();
				if(''!=trim($val)){
					echo sprintf('<div class="venue-image-holder">%s</div>', $val );
				}
				break;
			case 'image':
				the_tax_image();
				break;
			case 'content':
				the_tax_content();
				break;
			case 'wrapped_content':
				$val = get_the_tax_content();
				if(''!=trim($val)){
					echo sprintf('<div class="venue-description">%s</div>',  $val);
				}
				break;
			default:
				$label = ''==trim($label)?ucfirst($field):$label;
				the_tax_detail( array('label'=>$label,'field'=>$field));
		}
		$out = ob_get_contents();
		ob_end_clean();
		return $out;
	}
	
	function tax_detail_map($atts,$template='',$code=""){
		global $term_id;
		$address = get_term_meta($term_id,'gaddress',true);
		if(trim($address)==''){
			$address = get_term_meta($term_id,'address',true);
			foreach(array('city','state','zip','country') as $field){
				$$field = get_term_meta($term_id,$field,true);
			}
			if($zip!=''||$state!=''){
				$address.=", $state $zip";
			}
			
			if($country!=''){
				$address.=", $country";
			}
		}		
		
		$atts['address']		= $address;
		
		foreach(array('ginfo'=>'info_windows','glat'=>'glat','glon'=>'glon','gzoom'=>'zoom') as $meta => $att){
			$val = get_term_meta($term_id,$meta,true);
			if(!empty($val)){
				$atts[$att]	= $val;
			}	
		}

		$all_empty = true;
		foreach(array('address','glat','glon') as $field){
			if(isset($atts[$field]) && ''!=trim($atts[$field])){
				$all_empty=false;
				break;
			}
		}
		
		if($all_empty){
			return '';
		}
		
		return $this->google_map($atts,$template,$code);
	}
	
	function single_venue_gmap($atts,$template='',$code=""){
		extract(shortcode_atts(array(
			'width' 	=> '500',
			'height'	=> '300'
		), $atts));
		
		$output = sprintf("[taxonomymeta taxonomy='%s'] [venue_gmap canvas_width='%s' canvas_height='%s' zoom='{gzoom}' address='{gaddress}' glat='{glat}' glon='{glon}' info_windows='{ginfo}'][/taxonomymeta]",
			RHC_VENUE,
			$width,
			$height
		);	
		return do_shortcode($output);		
	}
	
	function handle_shortcode($atts,$template='',$code=""){
		extract(shortcode_atts(array(
			'class' 	=> ''
		), $atts));
		
		$template = trim($template)==''?$this->get_venues_template_default():$template;
	
		$output = sprintf("[taxonomymeta taxonomy='%s'] %s[/taxonomymeta]",RHC_VENUE,$template);	
		return do_shortcode($output);
		//return apply_filters('the_content',$output);
	}	
	
	function get_venues_template_default(){
		global $rhc_plugin; 
		$content = $rhc_plugin->get_option('rhc-venue-layout','');
		if(trim($content)==''){
			ob_start();
			require_once RHC_PATH.'templates/shortcode_venues_template_default.php';		
			$content = ob_get_contents();
			ob_end_clean();		
		}

		return $content;
	}
	
	function google_map($atts,$template='',$code=""){
		$fields = array(
			'uid'=>0,
			'canvas_width'=>500,
			'canvas_height'=>300,
			'info_windows'=>'',
			'glat'=>'0',
			'glon'=>'0',
			'zoom'=>'13',
			'disableDefaultUI'=>'false',
			'map_type'=>'ROADMAP',
			'name'=>'',
			'address'=>'',
			'city'=>'',
			'zip'=>'',
			'country'=>'',
			'traffic'=>'false',
			'markers'=>'|||::',//markers
			'scrollwheel'=>'1',
			'styleid'=>'',
			'styles'=>'[]'
		);

		extract(shortcode_atts($fields, $atts));
		$styles = apply_filters( 'rhc_map_styles', $styles, $styleid, $atts, $template, $code );

		global $rhc_plugin;
		$scrollwheel = $rhc_plugin->get_option('gmap3_scrollwheel',$scrollwheel,true);
		
		$glat = ''==trim($glat)?0:$glat;
		$glon = ''==trim($glon)?0:$glon;
		$zoom = ''==trim($zoom)?13:$zoom;
		
		$name = $address;
		$info_windows = trim($info_windows)==''?$name:$info_windows;	
		if(false===strpos($info_windows,'<br')){
			$info_windows = str_replace("\n","\r",$info_windows);	
			$info_windows = str_replace("\r\r","\r",$info_windows);
			$info_windows = str_replace("\r","<br />",$info_windows);		
		}
			
		if(''==$glat && trim($address)=='')return '';
	
		$uid = $this->uid++;
		
		foreach(array('city','zip','country') as $field){
			if(trim($$field)!=''){
				$address.=", ".$$field;
			}
		}
		//return $address;
		ob_start();
?><div class="sws-gmap3-frame"><div id="map_canvas{uid}" class="sws-gmap3-cont" style="width: {canvas_width}px; height: {canvas_height}px"></div></div><div id="sws-gmap3-marker-{uid}" class="sws-gmap3-marker">{markers}</div>
<div class="sws-gmap3-marker"><div id="sws-gmap3-info-{uid}" >{info_windows}</div></div><script>jQuery(document).ready(function($){rhc_gmap3_init({glat:{glat},glon:{glon},zoom:{zoom},disableDefaultUI:{disableDefaultUI},map_type:google.maps.MapTypeId.{map_type},uid:{uid},name:"{name}",info_windows:"sws-gmap3-info-{uid}",markers:"#sws-gmap3-marker-{uid}",address:"{address}",scrollwheel:{scrollwheel},traffic:{traffic},styles:{styles}});});</script><?php		
		$content = ob_get_contents();
		ob_end_clean();
		foreach($fields as $field => $default){
			$content = str_replace("{".$field."}",$$field,$content);
		}
		
		add_action('wp_footer',array(&$this,'google_map_footer'));
		
		return $content;
	}
	
	function google_map_footer(){
		if($this->gmap_footer_added)return;
		$this->gmap_footer_added = true;
		wp_print_scripts('rhc_gmap3');
	}
}
?>