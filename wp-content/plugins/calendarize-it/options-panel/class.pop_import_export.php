<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/

class pop_import_export {
	function __construct($args=array()){
		$defaults = array(
			'plugin_id'				=> '',
			'plugin_code'			=> 'POP',
			'options_varname'		=> 'pop_options',
			'capability'			=> 'manage_options',
			'panel_priority'		=> 90,
			'load_options'			=> true
		);
		foreach($defaults as $property => $default){
			$this->$property = isset($args[$property])?$args[$property]:$default;
		}		
		
		if($this->load_options)add_filter( "pop-options_{$this->plugin_id}",array(&$this,'options'),$this->panel_priority,1);
		add_action("pop_admin_head_{$this->plugin_id}",array(&$this,'pop_admin_head'),$this->panel_priority);
		
		add_action('wp_ajax_pop-load-settings-'.$this->plugin_id, array(&$this,'ajax_load_settings'));
		add_action('wp_ajax_pop-list-settings-'.$this->plugin_id, array(&$this,'ajax_list_settings'));
		add_action('wp_ajax_pop-save-settings-'.$this->plugin_id, array(&$this,'ajax_save_settings'));
		add_action('wp_ajax_pop-export-settings-'.$this->plugin_id, array(&$this,'ajax_export_settings'));
		add_action('wp_ajax_pop-import-info-'.$this->plugin_id, array(&$this,'ajax_import_info'));
		add_action('wp_ajax_pop-import-settings-'.$this->plugin_id, array(&$this,'ajax_import_settings'));
		add_action('wp_ajax_pop-remove-setting-'.$this->plugin_id, array(&$this,'ajax_remove_setting'));
		add_action('wp_ajax_pop-restore-setting-'.$this->plugin_id, array(&$this,'ajax_restore_setting'));
		
		add_action('init', array(&$this,'handle_export'),1);
		add_action('init', array(&$this,'handle_import'),1);
	}
	
	function handle_import(){
		$handle_import = str_replace("-","_",'pop_import_file_'.$this->plugin_id);
		if(isset($_REQUEST[$handle_import])&&current_user_can($this->capability)){
			if(isset($_FILES['pop_import_file']) && $_FILES['pop_import_file']['error']==0){
				$data = unserialize(base64_decode(gzuncompress(file_get_contents($_FILES['pop_import_file']['tmp_name']))));			
				//----
				if(property_exists($data,'id')&&property_exists($data,'name')&&property_exists($data,'options')){
					if($data->id==$this->plugin_id){
						$backup = isset($_REQUEST['pop-backup-on-import'])&&$_REQUEST['pop-backup-on-import']=='1'?true:false;
						if($backup){
							$saved_options = $this->get_saved_options();
							$saved_options[]=(object)array(
								'name' => __('Automatic settings backup','pop'),
								'date' => date('Y-m-d H:i:s'),
								'options' => $this->get_options()
							);
							$var = $this->options_varname.'_saved';
							if(update_option($var,$saved_options)){

							}
						}
						
						$new_options = $data->options;
						$new_options = is_array($new_options)?$new_options:array();
						if($this->import_option($new_options,true)){
						
						}	
					}else{

					}
				}else{

				}
				//------
				$goback = $this->query_arg_add( 'updated', 'true', wp_get_referer() );
				$goback = $this->query_arg_add( 'pop_open_tabs', urlencode( (isset($_REQUEST['pop_open_tabs'])?$_REQUEST['pop_open_tabs']:'') ), $goback );				
				
				wp_redirect( $goback );
			}	
		}	
	}
	
	function handle_export(){
		$handle_export = str_replace("-","_",'pop_export_file_'.$this->plugin_id);
		if(isset($_REQUEST[$handle_export])&&current_user_can($this->capability)){
			$name = (!isset($_REQUEST['code_export_label'])||''==trim($_REQUEST['code_export_label']))?'current':$_REQUEST['code_export_label'];
			
			$data = (object)array(
				'id' 		=> $this->plugin_id,
				'name'		=> $name,
				'date'		=> date('Y-m-d H:i:s'),
				'options' 	=> $this->get_options()
			);
			
			$filename = sprintf("%s_%s_%s.dat",$this->plugin_id,$name,date('Ymd'));
			$filename = str_replace('-','_',$filename);
			$filename = str_replace(' ','_',$filename);
			
			$data = apply_filters('export-settings-'.$this->id,$data);
			$data = base64_encode(serialize($data));
			$data = gzcompress($data);
			
			header('Content-type: text/plain');
			header('Content-Disposition: attachment; filename="'.$filename.'"');
			die($data);
		}
	}
	
	function options($t){
		$i = count($t);
		//-------------------------
		$i++;
		@$t[$i]->id 			= 'import_export'; 
		$t[$i]->label 		= __('Settings import and export','pop');
		$t[$i]->right_label	= __('Settings import and export','pop');
		$t[$i]->page_title	= __('Settings import and export','pop');
		$t[$i]->theme_option = false;
		$t[$i]->plugin_option = true;
		$t[$i]->options = array(
			(object)array(
				'type'=>'description',
				'description'=>sprintf('<p><strong>%s</strong> %s</p><p>%s</p>',
					__('Export settings:','pop'),
					__('Write a short label that identifies this export code and click on "Export settings" to get the site settings.  You can later use this code to restore settings by uploading the file in the Import settings section of this tab.','pop'),
					__('Please observe that this will NOT export images or any other attachments, only the configuration values like image url or attachment paths.','pop')
				)
			),
			(object)array(
				'type'=>'subtitle',
				'label'=>__('Export settings','pop')
			),
			(object)array(
				'id'		=> 'export_settings',
				'type'		=> 'callback',
				'callback'	=> array(&$this,'export_form')	
			),
			(object)array(
				'type'=>'description',
				'description'=>sprintf('<p><strong>%s</strong><ol><li>%s</li><li>%s</li><li>%s</li></ol></p>',
					__('Import settings:','pop'),
					__('Choose a file exported with the Export settings option on this tab','pop'),
					__('Check the "Backup" options if you want to save your current settings locally.','pop'),
					__('Click on "Import settings"','pop')
				)
			),			
			(object)array(
				'type'=>'subtitle',
				'label'=>__('Import settings','pop')
			),			
			(object)array(
				'id'		=> 'import_and_export',
				'type'		=> 'callback',
				'callback'	=> array(&$this,'import_and_export')	
			)		
		);		
		//-------------------------		
		$i++;
		@$t[$i]->id 			= 'saved_settings'; 
		$t[$i]->label 		= __('Saved settings and downloaded content','pop');
		$t[$i]->right_label	= __('Saved settings and downloaded content','pop');
		$t[$i]->page_title	= __('Saved settings and downloaded content','pop');
		$t[$i]->theme_option = false;
		$t[$i]->plugin_option = true;
		$t[$i]->open = false;
		$t[$i]->options = array(
			(object)array(
				'type'=>'subtitle',
				'label'=>__('Settings backup','pop'),
				'description'=> sprintf('<p><strong>%s</strong> %s</p><p>%s</p>',
					__('Settings backup:','pop'),
					__('Type a small description so you can identify this settings and press <i>Save settings</i>.  It will be listed on the Saved settings list.','pop'),
					__('<i>Technical:</i> This is stored in the local site options.','pop')
				)	
			),
			(object)array(
				'id'			=> 'branding-save-btn',
				'type'			=>'save_settings',
				'label'			=>__('Brief description','pop'),
				'anygroup'		=> true,
				'description'	=> '',
				'button_label'	=> __('Save settings','pop')	
			),
			(object)array(
				'type'=>'clear'
			),
			(object)array(
				'type'=>'subtitle',
				'label'=>__('Saved settings','pop'),
				'description'=> '' 	
			),
			(object)array(
				'id'		=> 'popex-list',
				'type'		=> 'saved_settings_list',
				'link_restore'=> true,
				'link_load'=>false,
				'debug'		=> false,
				'anygroup'	=> true
			)
	
		);
		//-------------
		return $t;
	}
	
	function pop_admin_head(){
?>
<script type='text/javascript'>
jQuery(document).ready(function($){
	$('#get_pop_export').click(function(e){
	
	});
	$('#save_pop_export').click(function(e){
		$('#pop-save-settings-status').html('').addClass('pop-processing');
		var args = {
			'action':'pop-save-settings-' + $('#pop_plugin_id').val(),
			'label':$('#export_label').val()
		};	
		$.post(ajaxurl,args,function(data){
			if(data.R=='OK'){
				$('#pop-save-settings-status').html(data.MSG);
				load_saved_settings();
			}else if(data.R=='ERR'){
				$('#pop-save-settings-status').html(data.MSG);
			}else{
				$('#pop-save-settings-status').html('Unexpected api response, please try again.');
			}
			$('#pop-save-settings-status').removeClass('pop-processing');
		},'json');
	});
	
	$('#pop-backup-on-import').attr('checked',true);
	
	load_saved_settings();
});

function load_saved_settings(){
	jQuery(document).ready(function($){
		var ts = new Date();
		var args = {
			'action':'pop-load-settings-' + $('#pop_plugin_id').val(),
			'ts':escape(ts)
		};
		$('.saved-settings').html('').addClass('pop-processing').load(ajaxurl,args,function(data){
			if(data=='-1')$(this).html('Error loading list of saved settings, refresh the screen to try again.');
			$(this).removeClass('pop-processing');			
		});
	});
}

function remove_saved_setting(_index,_name){
	jQuery(document).ready(function($){
		if( window.confirm('Please confirm that you want to permanently remove saved settings with description: ' + _name) ){
			$('.saved-settings').html('').addClass('pop-processing');
			$('.popex-list tr').animate({opacity:0.25},'fast','linear',function(){$('.popex-list').addClass('pop-processing');});			
			var args = {
				'action':'pop-remove-setting-' + $('#pop_plugin_id').val(),
				'index':_index,
				'name':_name
			};
			$.post(ajaxurl,args,function(data){				
				if(data.R=='OK'){
					load_saved_settings();
					$('.popex-list').trigger('popex_load');
				}else if(data.R=='ERR'){
					alert(data.MSG);
				}else{
					alert('Unexpected api response, please try again.');
				}
				$('.saved-settings').html('').removeClass('pop-processing');
				$('.popex-list tr').animate({opacity:1});
				$('.popex-list').removeClass('pop-processing');
				
			},'json');			
		}	
	});
}

function restore_saved_setting(_index,_name){
	jQuery(document).ready(function($){
		if( window.confirm('Please confirm that you want to restore current options to saved settings with description: ' + _name) ){
			$('.saved-settings').html('').addClass('pop-processing');
			$('.popex-list tr').animate({opacity:0.25},'fast','linear',function(){$('.popex-list').addClass('pop-processing');});	
			var args = {
				'action':'pop-restore-setting-' + $('#pop_plugin_id').val(),
				'index':_index,
				'name':_name
			};
			$.post(ajaxurl,args,function(data){
				if(data.R=='OK'){
					//$('.popex-list').trigger('popex_load');
					$('.popex-list').removeClass('pop-processing');
					$('.popex-list tr').animate({opacity:1});
					window.location.reload();
				}else if(data.R=='ERR'){
					$('.popex-list').removeClass('pop-processing');
					$('.popex-list tr').animate({opacity:1});
					alert(data.MSG);
				}else{
					$('.popex-list').removeClass('pop-processing');
					$('.popex-list tr').animate({opacity:1});
					alert('Unexpected api response, please try again.');
				}
				$('.saved-settings').html('').removeClass('pop-processing');
			},'json');			
		}	
	});
}
</script>
<?php
	}
	
	function export_form(){
?>
	<div class="pt-option export_settings">
				<textarea id="export_settings" class="pop-export-settings"></textarea>
				<label class="export-label"><?php _e('Brief description','pop')?></label><input type="text" id="code_export_label" name="code_export_label" class="inp-export-label" value="" />
				<input type="submit" class="button-secondary" name="pop_export_file_<?php echo str_replace("-","_",$this->plugin_id)?>" value="<?php _e('Export settings','pop')?>" />
				<div id="pop-export-settings-status" class="btn-saving-status"></div>
				<div class="pop-float-separator">&nbsp;</div>
	</div>
<?php	
	}
	
	function import_and_export(){
?>		
		<div class="pt-option pop-export">
				<input style="width:98%;" type="file" name="pop_import_file" value="" />
				<div class="chk-backup-on-import"><input type="checkbox" id="pop-backup-on-import" name="pop-backup-on-import" value="1" />&nbsp;<label><?php _e('Backup my current settings locally.','pop')?></label></div>
				<br />
				<input type="submit" class="button-secondary" name="pop_import_file_<?php echo str_replace("-","_",$this->plugin_id)?>" value="<?php _e('Import settings','pop')?>" />
				<div id="pop-import-settings-status" class="btn-saving-status"></div>		
		</div>
		<div class="pt-clear"></div>
<?php	
	}
	//---
	function import_option($new_options,$replace=FALSE){
		if($replace){
			return update_option($this->options_varname,$new_options);
		}
		//only replace those properties that are set in the incoming new_options
		$current_options = $this->get_options();
		if(is_array($new_options)&&count($new_options)>0){

			foreach($new_options as $new_field => $new_value){
				$current_options[$new_field]=$new_value;
			}
			return update_option($this->options_varname,$current_options);
		}else{
			return true;//nothing to replace.
		}
	}
	
	//---ajax section
	function check_ajax(){
		if(current_user_can('manage_options')||current_user_can($this->capability)){
			ini_set('display_errors',false);
			error_reporting(0);
			return true;
		}else{
			return false;
		}
	}		
	
	function get_options(){
		$options = get_option($this->options_varname);
		return is_array($options)?$options:array();
	}	
	
	function get_saved_options(){
		$var = $this->options_varname.'_saved';
		$options = get_option($var);
		return is_array($options)?$options:array();
	}	
	
	function ajax_save_settings(){
		if(!$this->check_ajax()){
			die(json_encode((object)array('R'=>'ERR','MSG'=>  __('No access','pop'))));
		}
		
		if(!isset($_REQUEST['label'])||trim($_REQUEST['label'])==''){
			die(json_encode((object)array('R'=>'ERR','MSG'=> __('Please specify a label for this settings.','pop') )));
		}
		
		$groups = array();
		$groups = isset($_REQUEST['groups'])&&is_array($_REQUEST['groups'])&&count($_REQUEST['groups'])>0?$_REQUEST['groups']:array();
		if(isset($_REQUEST['group'])&&''!=trim($_REQUEST['group'])){
			$groups[]=$_REQUEST['group'];
		}
		
		$fields = isset($_REQUEST['fields'])&&trim($_REQUEST['fields'])!=''?$_REQUEST['fields']:'';
		$fields = explode(',',$fields);
		if(is_array($fields)&&count($fields)>0){
			$options = array();
			foreach($this->get_options() as $index => $value){
				if(in_array($index,$fields)){
					$options[$index]=$value;
				}
			}	
		}else{
			$options = $this->get_options();
		}
		
		$saved_options = $this->get_saved_options();
		$saved_options[]=(object)array(
			'name' => $_REQUEST['label'],
			'groups' => $groups,
			'date' => date('Y-m-d H:i:s'),
			'options' => $options
		);
	
		$var = $this->options_varname.'_saved';
		if(update_option($var,$saved_options)){
			die(json_encode((object)array('R'=>'OK','MSG'=>'')));
		}
		die(json_encode((object)array('R'=>'ERR','MSG'=>__('Error saving options.','pop'))));
	}
	
	function ajax_list_settings(){
		if(!$this->check_ajax()){
			die(json_encode((object)array('R'=>'ERR','MSG'=>__('No access','pop'))));
		}	
		$groups = isset($_REQUEST['groups'])&&is_array($_REQUEST['groups'])&&count($_REQUEST['groups'])>0?$_REQUEST['groups']:false;
		$groups = count($groups)==1&&trim($groups[0])==''?false:$groups;
		$saved_options = $this->get_saved_options();

		if(count($saved_options)>0){
			$data = array();
			$saved_options = array_reverse($saved_options);
			foreach($saved_options as $index => $s){
				if(false!==$groups){
					if(!property_exists($s,'groups'))continue;
					if(false==array_intersect($groups,$s->groups))continue;
				}
				
				$r = (object)array();
				$r->id	 = $index;
				$r->name = property_exists($s,'name')?$s->name:'';
				$r->date = property_exists($s,'date')?substr($s->date,0,10):'';//@substr($s->date,0,10);
				$r->description = property_exists($s,'description')?$s->description:'';//@$s->description;
				$r->url	= property_exists($s,'url')?$s->url:'';//  @$s->url;
				$r->version = property_exists($s,'version')?$s->version:'';
				
				$data[]=$r;
			}
			die(json_encode((object)array('R'=>'OK','MSG'=>'','DATA'=>$data)));
		}else{
			die(json_encode((object)array('R'=>'ERR','MSG'=>__('There are no saved settings.','pop'))));
		}
	}
		
	function ajax_load_settings(){
		if(!$this->check_ajax()){
			die('.');
		}	
		$groups = isset($_REQUEST['groups'])&&is_array($_REQUEST['groups'])&&count($_REQUEST['groups'])>0?$_REQUEST['groups']:false;
		$saved_options = $this->get_saved_options();
		if(count($saved_options)>0){
			$show = false;
			$saved_options = array_reverse($saved_options);
			ob_start();
			echo "<div class=\"pop-list-of-saved-settings\">";
			foreach($saved_options as $index => $s){
				if(false!==$groups){
					if(!property_exists($s,'groups'))continue;
					if(false==array_intersect($groups,$s->groups))continue;
				}
				$show=true;
				echo sprintf("<div class=\"pop-saved-setting-row\">%s<div class=\"pop-saved-setting-desc\">%s %s</div><div class=\"pop-float-separator\">&nbsp;</div></div>",$this->saved_settings_list_controls($index,$s),substr($s->date,0,10),$s->name);
			}
			echo "</div>";
			//--
			if($show){
				ob_end_flush();
			}else{
				ob_end_clean();
				echo sprintf("<p class='pop-no-saved-settings'>%s</p>",__('There are no saved settings.','pop')) ;
			}
		}else{
			echo sprintf("<p class='pop-no-saved-settings'>%s</p>",__('There are no saved settings.','pop')) ;
		}
		die();
	}
	
	function saved_settings_list_controls($index,$s){
		$d = (object)array('index'=>$index,'name'=>$s->name);
		$str = '<div class="pop-saved-settings-controls">';
		$str.= sprintf("<div title=\"%s\" class=\"pop-saved-setting-control pop-saved-setting-delete\" OnClick=\"javascript:remove_saved_setting('%s','%s');\"></div>",__('This will permanently remove this settings.','pop'),$index,str_replace("'","\'",$s->name));
		$str.= sprintf("<div title=\"%s\" class=\"pop-saved-setting-control pop-saved-setting-restore\" OnClick=\"javascript:restore_saved_setting('%s','%s');\"></div>",__('Restore the current options to this settings.','pop'),$index,str_replace("'","\'",$s->name));
		$str.= '</div>';
		return $str;
	}
	
	function ajax_export_settings(){
		if(!$this->check_ajax()){
			die(json_encode((object)array('R'=>'ERR','MSG'=>  __('No access','pop'))));
		}		
		if(!isset($_REQUEST['name'])||''==trim($_REQUEST['name']))
			die(json_encode((object)array('R'=>'ERR','MSG'=>  __('Please write a brief description for this export code.','pop'))));
		
		$data = (object)array(
			'id' 		=> $this->plugin_id,
			'name'		=> $_REQUEST['name'],
			'date'		=> date('Y-m-d H:i:s'),
			'options' 	=> $this->get_options()
		);
		
		$data = apply_filters('export-settings-'.$this->id,$data);
		$data = base64_encode(serialize($data));
		
		$r = (object)array(
			'R'=>'OK',
			'MSG'=>'',
			'DATA'=>$data
		);
		
		die(json_encode($r));
	}
	
	function ajax_import_info(){
		if(!$this->check_ajax()){
			die(json_encode((object)array('R'=>'ERR','MSG'=>  __('No access','pop'))));
		}		
		$data = @$_REQUEST['data'];
		$data = unserialize(base64_decode(trim($data)));
		if(!is_object($data)||!property_exists($data,'id')||!property_exists($data,'name')||!property_exists($data,'options')){
			die(json_encode((object)array('R'=>'ERR','MSG'=> __('Could not read the imported code, please verify and try again.','pop') )));
		}
		if($data->id!=$this->plugin_id){
			die(json_encode((object)array('R'=>'ERR','MSG'=> sprintf(__('The imported code does not belong to this group of settings.  Import code id: %s','pop'),$data->id) )));
		}
		$r=(object)array(
			'id'=>$data->id,
			'name'=>$data->name,
			'date'=>$data->date
		);
		die(json_encode((object)array('R'=>'OK','MSG'=> '','DATA'=>$r)));
	}
	
	function ajax_import_settings(){
		if(!$this->check_ajax()){
			die(json_encode((object)array('R'=>'ERR','MSG'=>  __('No access','pop'))));
		}		
		$data = @$_REQUEST['data'];
		$data = unserialize(base64_decode(trim($data)));
		if(!property_exists($data,'id')||!property_exists($data,'name')||!property_exists($data,'options')){
			die(json_encode((object)array('R'=>'ERR','MSG'=> __('Could not read the imported code, please verify and try again.','pop') )));
		}
		if($data->id!=$this->plugin_id){
			die(json_encode((object)array('R'=>'ERR','MSG'=> sprintf(__('The imported code does not belong to this group of settings.  Import code id: %s','pop'),$data->id) )));
		}
		
		$current_options = $this->get_options();
		if(serialize($current_options)==serialize($data->options)){
			die(json_encode((object)array('R'=>'ERR','MSG'=> __('The settings on this code are the same as the current settings.','pop') )));
		}
		
		$backup = isset($_REQUEST['backup'])&&$_REQUEST['backup']=='true'?true:false;
		if($backup){
			$saved_options = $this->get_saved_options();
			$saved_options[]=(object)array(
				'name' => __('Automatic settings backup','pop'),
				'date' => date('Y-m-d H:i:s'),
				'options' => $this->get_options()
			);
			$var = $this->options_varname.'_saved';
			if(!update_option($var,$saved_options)){
				die(json_encode((object)array('R'=>'ERR','MSG'=> __('There was an error saving a backup of the current settings, please try again.','pop') )));
			}
		}
		
		$new_options = $data->options;
		$new_options = is_array($new_options)?$new_options:array();
		if(!$this->import_option($new_options)){
			die(json_encode((object)array('R'=>'ERR','MSG'=> $this->options_varname.__('There was an error saving the settings, please try again.','pop') )));
		}		
		die(json_encode((object)array('R'=>'OK','MSG'=> '')));
	}
	
	function ajax_remove_setting(){
		if(!$this->check_ajax()){
			die(json_encode((object)array('R'=>'ERR','MSG'=>  __('No access','pop'))));
		}	
		if(!isset($_REQUEST['index'])||!is_numeric($_REQUEST['index'])||$_REQUEST['index']<0||!isset($_REQUEST['name'])){
			die(json_encode((object)array('R'=>'ERR','MSG'=>  __('Missing parameter','pop'))));
		}
		$index = intval($_REQUEST['index']);
		$name = $_REQUEST['name'];
		$saved_options = $this->get_saved_options();
		if(count($saved_options)>0)$saved_options = array_reverse($saved_options);		
		
		if( isset($saved_options[$index]) && 0==strcmp($name,$saved_options[$index]->name)){
			unset($saved_options[$index]);
			if(count($saved_options)>0)$saved_options = array_reverse($saved_options);
			$var = $this->options_varname.'_saved';
			update_option($var,$saved_options);
			die(json_encode((object)array('R'=>'OK','MSG'=>'')));
		}
		die(json_encode((object)array('R'=>'OK','MSG'=> __('Nothing to remove.','pop') )));
	}
	
	function ajax_restore_setting(){
		if(!$this->check_ajax()){
			die(json_encode((object)array('R'=>'ERR','MSG'=>  __('No access','pop'))));
		}	
		if(!isset($_REQUEST['index'])||!is_numeric($_REQUEST['index'])||$_REQUEST['index']<0||!isset($_REQUEST['name'])){
			die(json_encode((object)array('R'=>'ERR','MSG'=>  __('Missing parameter','pop'))));
		}
		$index = intval($_REQUEST['index']);
		$name = $_REQUEST['name'];
		$saved_options = $this->get_saved_options();
		if(count($saved_options)>0)$saved_options = array_reverse($saved_options);		
		
		if( isset($saved_options[$index]) && 0==strcmp($name,$saved_options[$index]->name)){
			$this->import_option($saved_options[$index]->options);
			die(json_encode((object)array('R'=>'OK','MSG'=> sprintf( __('Restored %s:%s','pop'),$index,$saved_options[$index]->name) )));
		}else{
			die(json_encode((object)array('R'=>'ERR','MSG'=> __('Saved setting not found','pop') )));
		}
	}
	
	function query_arg_add() {
		$ret = '';
		$args = func_get_args();
		if ( is_array( $args[0] ) ) {
			if ( count( $args ) < 2 || false === $args[1] )
				$uri = $_SERVER['REQUEST_URI'];
			else
				$uri = $args[1];
		} else {
			if ( count( $args ) < 3 || false === $args[2] )
				$uri = $_SERVER['REQUEST_URI'];
			else
				$uri = $args[2];
		}
	
		if ( $frag = strstr( $uri, '#' ) )
			$uri = substr( $uri, 0, -strlen( $frag ) );
		else
			$frag = '';
	
		if ( 0 === stripos( $uri, 'http://' ) ) {
			$protocol = 'http://';
			$uri = substr( $uri, 7 );
		} elseif ( 0 === stripos( $uri, 'https://' ) ) {
			$protocol = 'https://';
			$uri = substr( $uri, 8 );
		} else {
			$protocol = '';
		}
	
		if ( strpos( $uri, '?' ) !== false ) {
			list( $base, $query ) = explode( '?', $uri, 2 );
			$base .= '?';
		} elseif ( $protocol || strpos( $uri, '=' ) === false ) {
			$base = $uri . '?';
			$query = '';
		} else {
			$base = '';
			$query = $uri;
		}
	
		wp_parse_str( $query, $qs );
		$qs = urlencode_deep( $qs ); // this re-URL-encodes things that were already in the query string
		if ( is_array( $args[0] ) ) {
			$kayvees = $args[0];
			$qs = array_merge( $qs, $kayvees );
		} else {
			$qs[ $args[0] ] = $args[1];
		}
	
		foreach ( $qs as $k => $v ) {
			if ( $v === false )
				unset( $qs[$k] );
		}
	
		$ret = build_query( $qs );
		$ret = trim( $ret, '?' );
		$ret = preg_replace( '#=(&|$)#', '$1', $ret );
		$ret = $protocol . $base . $ret . $frag;
		$ret = rtrim( $ret, '?' );
		return $ret;
	}		
}

class pop_saved_settings_item {
	var $name;
	var $date;
	var $options;
	function __construct(){
	
	}
}
?>