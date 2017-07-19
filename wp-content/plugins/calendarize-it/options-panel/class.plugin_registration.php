<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/
if(!class_exists('pop_plugin_registration')):
class pop_plugin_registration {
	var $plugin_id;
	var $plugin_code;
	var $label;
	var $right_label;
	var $page_title;
	var $tdom;
	var $options_varname;
	var $panel_priority=100;
	function __construct($args=array()){
		$defaults = array(
			'plugin_id'				=> '',
			'plugin_code'			=> 'POP',
			'tdom'					=> 'righthere',
			'options_varname'		=> 'pop_options',
			'capability'			=> 'manage_options',
			'panel_priority'		=> 100,
			'open'					=> false,
			'support_email'			=> 'support@righthere.com',
			'api_url'				=> 'http://plugins.righthere.com/',
			'multisite'				=> false
		);
		foreach($defaults as $property => $default){
			$this->$property = isset($args[$property])?$args[$property]:$default;
		}		
		add_filter( "pop-options_{$this->plugin_id}",array(&$this,'options'),$this->panel_priority,1);
		add_action("pop_admin_head_{$this->plugin_id}",array(&$this,'pop_admin_head'),$this->panel_priority);
		add_action('wp_ajax_registered-licenses-'.$this->plugin_id, array(&$this,'registered_licenses'));
		add_action('wp_ajax_add-license-'.$this->plugin_id, array(&$this,'add_license'));
		add_filter( "export-settings-{$this->plugin_id}",array(&$this,'export_settings'),10,1);
	}
	
	function options($t){
		//--Default backgrounds -----------------------		
		$i = count($t);
		@$t[$i]->id 			= 'license'; 
		$t[$i]->label 		= __('License','pop');
		$t[$i]->right_label	= __('Item Purchase Key','pop');
		$t[$i]->page_title	= __('Product License','pop');
		$t[$i]->theme_option = false;
		$t[$i]->plugin_option = true;
		$t[$i]->open = $this->open;
		$t[$i]->options = array(
			(object)array(
				'type'=>'description',
				'description'=>sprintf('<p>%s</p><p>%s%s</p><p>%s</p><p>%s</p>',
					__('Your purchase code can be found in your license Certificate file.','pop'),
					__('Go to Codecanyon and click My Account at the top, then click Downloads, and then click the <strong>License Certificate link</strong>.','pop'),
					__('You will find the code in there and it will look something like this:','pop'),
					sprintf('%s:<br>bek72585-d6a6-4724-c8c4-9d32f85734g3', __('Item Purchase Code:','pop')),					
					sprintf(__('This allows us to verify your purchase and provide support to those who have paid. We will also automatically notify you when updates are available. Updates are free to download if you have purchased this once. If you have questions about this, please contact us at %s.','pop'),sprintf('<a href="mailto:%s">%s</a>',$this->support_email,$this->support_email))
				)
			),
			(object)array(
				'type'=>'subtitle',
				'label'=>__('License key','pop')
			),
			(object)array(
				'id'		=> 'license_key_callback',
				'type'		=> 'callback',
				'callback'	=> array(&$this,'login_options')	
			)			
		);
		return $t;
	}
	
	function pop_admin_head(){
?>
<script type='text/javascript'>
jQuery(document).ready(function($){
	$('#submit_license').unbind('click').click(function(e){
		$('#add-license-msg').html('Adding license').addClass('add-license-message').removeClass('add-license-error').fadeIn();
		var url = 'dev.lawley.com';
		var args = {
			'action':'add-license-<?php echo $this->plugin_id ?>',
			'license_key':$('#add_license_key').val()
		};
		$.post(ajaxurl,args,function(data){
			if(data.R=='OK'){
				$('#add-license-msg').html('Done, reloading license keys').show().addClass('add-license-message').removeClass('add-license-error').fadeOut('slow');
				load_registered_licenses();
			}else if(data.R=='ERR'){
				$('#add-license-msg').html(data.MSG).removeClass('add-license-message').addClass('add-license-error').show();
			}else{
				$('#add-license-msg').html('Service not available.').removeClass('add-license-message').addClass('add-license-error').show();
			}
		},'json');
	});
	load_registered_licenses();
});

function load_registered_licenses(){
	jQuery(document).ready(function($){
		var ts = new Date();
		var args = {
			'action':'registered-licenses-<?php echo $this->plugin_id ?>',
			'ts':escape(ts)
		};
		$('.registered-license-cont').load(ajaxurl,args,function(){
		
		});
	});
}
</script>
<?php	
	}
	
	function add_license(){
		if(!$this->check_ajax()){
			die(json_encode((object)array('R'=>'ERR','MSG'=>  __('Service not available.','pop')  )));
		}	
		$license_key = isset($_REQUEST['license_key'])&&trim($_REQUEST['license_key'])!=''?$_REQUEST['license_key']:false;
		if(false===$license_key){
			die(json_encode((object)array('R'=>'ERR','MSG'=> __('Missing parameter','pop') )));
		}
		
		$options = $this->get_options();
		$options['license_keys'] =  isset($options['license_keys']) && is_array($options['license_keys'])&&count($options['license_keys'])>0?$options['license_keys']:array();
		//--check existing
		if(count($options['license_keys'])>0){
			foreach($options['license_keys'] as $l){
				if(@$l->license_key==$license_key){
					die(json_encode((object)array('R'=>'ERR','MSG'=> __('License already added.','pop') )));
				}
			}
		}

		$url = sprintf('%s?content_service=verify_license_key&license_key=%s&plugin_code=%s',$this->api_url,urlencode($license_key),urlencode($this->plugin_code));
		//$url = sprintf('http://plugins.righthere.com/?content_service=verify_license_key&license_key=%s&plugin_code=%s',urlencode($license_key),urlencode($this->plugin_code));
		//$url = sprintf('http://plugins.albertolau.com/?content_service=verify_license_key&license_key=%s&plugin_code=%s',urlencode($license_key),urlencode($this->plugin_code));

		if(!class_exists('righthere_service'))require_once 'class.righthere_service.php';
		$rh = new righthere_service();
		$r = $rh->rh_service($url);		
//file_put_contents( ABSPATH.'theme.log', $url."\n".print_r($r,true));
		if(false!==$r){
			if($r->R=='OK'){
				if(!in_array($r->LICENSE->item_type,array('plugin','theme'))){
					if(count($options['license_keys'])==0){
						die(json_encode((object)array('R'=>'ERR','MSG'=> __('Please add a main license key before adding an addon license key.','pop') )));
					}	
				}
				$options['license_keys'][]=$r->LICENSE;
				$this->update_option($this->options_varname,$options);
				die(json_encode($r));
			}else if($r->R=='ERR'){
				die(json_encode($r));
			}else{
				die(json_encode((object)array('R'=>'ERR','MSG'=>__('Service not available.','pop').'(1)' )));
			}			
		}
		die(json_encode((object)array('R'=>'ERR','MSG'=>__('Service not available.','pop').'(2) '.@$rh->last_error_str)));
	}
	
	function registered_licenses(){
		if(!$this->check_ajax()){
			die('.');
		}	
		$options = $this->get_options();
		if(isset($options['license_keys'])&&count($options['license_keys'])>0){
			foreach($options['license_keys'] as $i => $l){
?>
<div class="license-key-desc-holder">
	<div class="license-key-desc">
		<label><?php echo trim($l->item_name)==''?__('Item name not specified','pop'):$l->item_name?> (<?php echo trim($l->license)==''?__('License not specified','pop'):$l->license;?>)</label><br />
		<i><?php echo @$l->license_key?></i>	
	</div>	
	<div class="license-key-desc-bg">
		<label><?php echo trim($l->item_name)==''?__('Item name not specified','pop'):$l->item_name?> (<?php echo trim($l->license)==''?__('License not specified','pop'):$l->license;?>)</label><br />
		<i><?php echo @$l->license_key?></i>		
	</div>
	<div style="clear:left;"></div>
</div>
<?php							
			}
		}
		
		die();
	}
	function login_options($tab,$i,$o,&$save_fields){
		foreach(array('license_key','license_item_name') as $option_name){
			$$option_name = isset($o->existing_options['license_key'])?$o->existing_options['license_key']:'';
		}
		foreach(array('extra_license_key','extra_license_item_name') as $option_name){
			$$option_name = isset($o->existing_options['license_key'])&&is_array($o->existing_options['license_key'])?$o->existing_options['license_key']:array();
		}
		
?>		
		<div class="pt-option">
			<div class="add-license-key">
				<input type="text" id="add_license_key" class="add_license_key" name="add_license_key" value="" />&nbsp;
				<input class="button-secondary" type="button" id="submit_license" value="<?php _e('Add license','pop')?>" />
			</div>
			<div id="add-license-msg" class="">--</div>	
			<div class="registered-license-cont">
			...
			</div>		
		</div>
		<div class="pt-clear"></div>

<?php		
	}
	function get_license_key(){
		$licenses = $this->get_option('license_keys');
		if(is_array($licenses)&&count($licenses)>0){
			foreach($licenses as $license){
				if(in_array($license->item_type,array('plugin','theme'))){
					return $license->license_key;
				}
			}
		}
		$license_key = $this->get_option('license_key');
		if(trim($license_key)!=''){
			return $license_key;
		}
		return '';
	}
	function get_option($name){
		$options = $this->get_options();
		return isset($options[$name])?$options[$name]:'';
	}	
	
	function update_option( $options_varname, $options ){
		if( $this->multisite ){
			update_site_option( $options_varname, $options );
		}else{
			update_option( $options_varname, $options );
		}
	}
	
	function get_options(){
		if( $this->multisite ){
			$options = get_site_option($this->options_varname);
		}else{
			$options = get_option($this->options_varname);
		}
		
		return is_array($options)?$options:array();
	}	
	function check_ajax(){
		if(current_user_can('manage_options')||current_user_can($this->capability)){
			return true;
		}else{
			return false;
		}
	}
	function export_settings($r){
		if(@isset($r->options['license_keys'])){
			unset($r->options['license_keys']);
		}
		return $r;
	}	
}
endif;

if(!class_exists('righthere_license')):
class righthere_license {
	var $license_key;
	var $item_id;
	var $item_name;
	var $created_at;
	var $license;
	var $item_type;
	function __construct($args=array()){
		if(count($args)>0){
			foreach($args as $field => $value){
				$this->$field = $value;
			}		
		}
	}
}
endif;

?>