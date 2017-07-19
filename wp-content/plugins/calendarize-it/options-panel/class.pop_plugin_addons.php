<?php
/*
* 
*/


class pop_plugin_addons {
	var $id;
	var $parent_id;
	var $page_title;
	var $menu_text;
	var $capability;
	var $api_url;
	var $license_keys;
	var $module_url;
	var $uid = 0;
	function __construct($args=array()){
		if(count($args)==0)return;
		$defaults = array(
			'id'					=> 'addons',
			'plugin_id'				=> 'addons',
			'resources_path'		=> 'addons',
			'parent_id'				=> 'rh-plugins',
			'page_title'			=> __('Plugin Add-ons','pop'),
			'menu_text'				=> __('Add-ons','pop'),
			'capability'			=> 'manage_options',
			'api_url'				=> 'http://plugins.righthere.com/',
			//'api_url'				=> 'http://plugins.albertolau.com/',
			'license_keys'			=> array(),
			'module_url'			=> plugin_dir_url(__FILE__),
			'options_varname'		=> 'pop_options',
			'stylesheet'			=> 'pop'
		);
		foreach($defaults as $property => $default){
			$this->$property = isset($args[$property])?$args[$property]:$default;
		}	

		add_action('admin_menu',array(&$this,'admin_menu'));
		add_action('init',array(&$this,'init'));
		add_action('wp_ajax_rhpop_activate_addon_'.$this->id , array(&$this,'handle_activate_addon'));
	}
	
	function handle_activate_addon(){
		if(!current_user_can($this->capability)){
			die(json_encode(array('R'=>'ERR','MSG'=>__('No access','pop'))));
		}
		$plugins = $this->get_plugins();	
		$valid_plugins = array_keys($plugins);
		
		$plugin = @array_key_exists($_REQUEST['plugin'], $plugins) ? $_REQUEST['plugin'] : false;
		if(false===$plugin){
			die(json_encode(array('R'=>'ERR','MSG'=>__('Plugin is no longer available.','pop') )));
		}
		$redirect_url='';
		$current = get_option($this->options_varname, array());
		$current = is_array($current) ? $current : array();
		$current['addons'] = @is_array($current['addons']) ? $current['addons'] : array() ;	
		$activate = isset($_REQUEST['activate']) && 1==intval($_REQUEST['activate']) ? true : false;
		if($activate){
			if(!in_array($plugin,$current['addons'])){
				$upload_dir = wp_upload_dir();
				$addons_path = $upload_dir['basedir'].'/'.$this->resources_path.'/';				
				try {
					$addon = $plugin;
					@include_once $addons_path.$plugin;	
					//----
					//$current['addons'][] = $plugin;
					array_unshift($current['addons'],$plugin);
					$current['addons'] = array_intersect($current['addons'],$valid_plugins);
					update_option($this->options_varname, $current);				
					do_action('activate_'.$plugin,$addons_path,$plugin);
					$redirect_url = apply_filters('activate_url_'.$plugin,$redirect_url);
				}catch(Exception $e){	
					die(json_encode(array('R'=>'ERR','MSG'=> $e->getMessage() )));			
				}			
			}
		}else{
			if(in_array($plugin,$current['addons'])){
				$current['addons'] = array_diff($current['addons'], array($plugin))  ;
				$current['addons'] = array_intersect($valid_plugins,$current['addons']);
				update_option($this->options_varname, $current);			
			}
		}

		die(json_encode(array('R'=>'OK','MSG'=>'','URL'=>$redirect_url)));
	}
	
	function init(){
		//wp_register_script('rh-dc', 	$this->module_url.'js/dc.js', array(), '1.0.0');
	}

	function admin_menu(){
		//--
		$page_id = add_submenu_page( $this->parent_id,$this->page_title ,$this->menu_text,$this->capability,$this->id,array(&$this,'body'));
		add_action( 'admin_head-'. $page_id, array(&$this,'head') );
	}
	
	function head(){
		wp_register_style('rhaddons', 			$this->module_url.'css/addons.css', array(), '1.0.0');
		wp_register_style('rhpop-bootstrap', 	$this->module_url.'bootstrap/css/bootstrap.namespaced.rhpop.css', array(), '2.3.1');
		rh_enqueue_script( 'bootstrap', 		$this->module_url.'bootstrap/js/bootstrap.js', array(),'2.3.1');
		rh_enqueue_script( 'jquery-isotope', 	$this->module_url.'js/jquery.isotope.min.js', array(),'1.5.14');
		
		wp_print_styles('rhaddons');
		wp_print_styles('rhpop-bootstrap');
		wp_print_scripts('bootstrap');
		wp_print_scripts('jquery-isotope');
?>
<script>
jQuery(document).ready(function($){
	$('#pop-addon-items').isotope({
		itemSelector : '.pop-addon-item',
  		layoutMode : 'fitRows'
		/*,filter : '.letter-a'*/
	});
	
	$('.enable-addon,.disable-addon').on('click',function(i,o){
		var plugin = $(this).parent().data('addon_path');
		var id = $(this).attr('id');
		if( $(this).is('.enable-addon') ){
			activate_addon( plugin, id, true );
		}else{
			activate_addon( plugin, id, false );
		}
	});
});

function activate_addon( plugin, el_id, activate ){
	jQuery(document).ready(function($){
		var args = {
			action: 'rhpop_activate_addon_<?php echo $this->id?>',
			plugin: plugin,
			activate: activate ? 1 : 0,
			el_id: el_id
		}

		$.post( ajaxurl, args, function(data){
			if(data.R=='OK'){
				if( activate ){
					$('#'+el_id).parent().find('.btn.enable-addon')
						.addClass('btn-success')
					;
					$('#'+el_id).parent().find('.btn.disable-addon')
						.removeClass('btn-danger')
					;
				}else{
					$('#'+el_id).parent().find('.btn.enable-addon')
						.removeClass('btn-success')
					;
					$('#'+el_id).parent().find('.btn.disable-addon')
						.addClass('btn-danger')
					;	
				}
				
				if(data.URL && ''!=data.URL){
					window.location.replace(data.URL);
				}else{
					window.location.reload();
				}
				
				return;
			}else if(data.R=='ERR'){
				alert(data.MSG);
			}else{
				alert('Error saving, reload page and try again.');
			}
			$('#'+el_id).parent().find('.btn.active').removeClass('active');
		}, 'json');		
	});
}

</script>
<?php
	}
	
	function body(){
		$current = get_option($this->options_varname, array());
		$current = is_array($current) ? $current : array();
		$current['addons'] = isset($current['addons']) && is_array($current['addons']) ? $current['addons'] : array() ;	
	
		$plugins = $this->get_plugins();	
		//activated plugins that are no longer installed, or folder renamed
		if(count($current['addons'])>0){
			$diff = array_diff($current['addons'], array_keys($plugins));
			if(is_array($diff) && count($diff)>0){
				$tmp = array();
				foreach($current['addons'] as $addon){
					if(in_array($addon,$diff))continue;
					$tmp[]=$addon;
				}
				$current['addons'] = $tmp;
				update_option($this->options_varname,$current);
			}		
		}
	
		$message = $message_class = '';
		if(empty($plugins)){
			$message = __('No addons installed.  Go to the Downloads menu to download an addon, then come back to this screen to activate it.','rhc');
			$message_class = 'updated';
		}			
?>
<div class="wrap rhpop">
	<div class="icon32" id="icon-plugins"><br /></div>
	<h2><?php echo $this->page_title?></h2>
	<div id="messages" class="<?php echo $message_class?>"><?php echo $message?></div>
	<div id="pop-addon-items">
	<?php $this->render_plugins($plugins,$current['addons']) ?>
	</div>
</div>
<?php
		/*
		echo "Debugging info: active addons:<br>";
		echo "<pre>";
		@print_r($diff);
		print_r($current['addons']);
		echo "</pre>";
		*/
	}	
	
	function render_plugins($plugins,$current_addons){
		foreach($plugins as $path => $p){
			$class_inactive = $class_active = '';
			if(in_array($path,$current_addons)){
				$class_active = 'active btn-success';
			}else{
				$class_inactive = 'active btn-danger';
			}
			
			$id = $this->uid++;
?>
<div class="pop-addon-item">
	<h4 class="pop-addon-name"><?php echo $p['Name']?></h4>
	<div class="pop-addon-version"><?php echo $p['Version']?></div>
	<div class="pop-addon-description"><?php echo $p['Description']?></div>
	<div style="display:none;"><?php echo $path?></div>
	
	<div class="btn-group addon-control" data-toggle="buttons-radio" data-addon_path="<?php echo $path ?>">
	  <button id="enable_addon_<?php echo $id?>" type="button" class="btn <?php echo $class_active?> enable-addon"><?php _e('On','pop')?></button>
	  <button id="disable_addon_<?php echo $id?>" type="button" data-toggle="button" class="btn <?php echo $class_inactive?> disable-addon"><?php _e('Off','pop')?></button>
	</div>	
</div>
<?php
		}

	}
	
	function get_plugins() {
		$upload_dir = wp_upload_dir();
		$plugin_root = $upload_dir['basedir'].'/'.$this->resources_path;	
		// rewritten version of the one in plugin.php core wordpress 
		$wp_plugins = array ();	
		// Files in wp-content/plugins directory
		$plugins_dir = @ opendir( $plugin_root);
		$plugin_files = array();
		if ( $plugins_dir ) {
			while (($file = readdir( $plugins_dir ) ) !== false ) {
				if ( substr($file, 0, 1) == '.' )
					continue;
				if ( is_dir( $plugin_root.'/'.$file ) ) {
					$plugins_subdir = @ opendir( $plugin_root.'/'.$file );
					if ( $plugins_subdir ) {
						while (($subfile = readdir( $plugins_subdir ) ) !== false ) {
							if ( substr($subfile, 0, 1) == '.' )
								continue;
							if ( substr($subfile, -4) == '.php' )
								$plugin_files[] = "$file/$subfile";
						}
						closedir( $plugins_subdir );
					}
				} else {
					if ( substr($file, -4) == '.php' )
						$plugin_files[] = $file;
				}
			}
			closedir( $plugins_dir );
		}
	
		if ( empty($plugin_files) )
			return $wp_plugins;
	
		foreach ( $plugin_files as $plugin_file ) {
			if ( !is_readable( "$plugin_root/$plugin_file" ) )
				continue;
	
			$plugin_data = get_plugin_data( "$plugin_root/$plugin_file", false, false ); //Do not apply markup/translate as it'll be cached.
	
			if ( empty ( $plugin_data['Name'] ) )
				continue;
	
			$wp_plugins[plugin_basename( $plugin_file )] = $plugin_data;
		}
	
		uasort( $wp_plugins, '_sort_uname_callback' );
		
		return $wp_plugins;
	}	
}


?>