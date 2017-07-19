<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/
if('plugin_righthere_calendar'==get_class($this)): 
			require_once RHC_PATH.'includes/class.rhc_layout_settings.php';
			new rhc_layout_settings($this->id);	

			require_once RHC_PATH.'includes/class.rhc_post_info_settings.php';
			new rhc_post_info_settings($this->id);	
			
			require_once RHC_PATH.'includes/class.rhc_settings.php';
			new rhc_settings($this->id);	
			
			require_once RHC_PATH.'includes/class.rhc_tax_settings.php';
			new rhc_tax_settings($this->id);		
			
			$license_keys = $this->get_option('license_keys',array());
			$license_keys = is_array($license_keys)?$license_keys:array();
			
			$api_url = 'secondary'==$this->get_option('righthere_api_url','',true) ? 'http://plugins.albertolau.com/' : 'http://plugins.righthere.com/';
			
			$dc_options = array(
				'id'			=> $this->id.'-dc',
				'plugin_id'		=> $this->id,
				'capability'	=> $this->options_capability,
				'resources_path'=> $this->resources_path,
				'parent_id'		=> 'edit.php?post_type='.RHC_EVENTS,
				'menu_text'		=> __('Downloads','rhc'),
				'page_title'	=> __('Downloadable content - Calendarize it! for WordPress','rhc'),
				'license_keys'	=> $license_keys,
				'plugin_code'	=> $this->plugin_code,
				'api_url'		=> $api_url,
				'product_name'	=> __('Calendarize-it','rhc'),
				'options_varname' => $this->options_varname,
				'tdom'			=> 'rhc',
				'alt_temp'		=> $this->get_option('alt_temp',false,true),
				'module_url'	=> RHC_URL.'options-panel/'
			);
			
			$ad_options = array(
				'id'			=> $this->id.'-addons',
				'plugin_id'		=> $this->id,
				'capability'	=> $this->options_capability,
				'resources_path'=> $this->resources_path,
				'parent_id'		=> 'edit.php?post_type='.RHC_EVENTS,
				'menu_text'		=> __('Add-ons','rhc'),
				'page_title'	=> __('Calendarize it! add-ons','rhc'),
				'options_varname' => $this->options_varname,
				'module_url'	=> RHC_URL.'options-panel/'
			);
			
			$settings = array(				
				'id'					=> $this->id,
				'plugin_id'				=> $this->id,
				'capability'			=> $this->options_capability,
				'capability_license'	=> $this->license_capability,
				'options_varname'		=> $this->options_varname,
				'menu_id'				=> 'rhc-options',
				'page_title'			=> __('Options','rhc'),
				'menu_text'				=> __('Options','rhc'),
				'option_menu_parent'	=> 'edit.php?post_type='.RHC_EVENTS,
				//'option_menu_parent'	=> $this->id,
				'notification'			=> (object)array(
					'plugin_version'=> RHC_VERSION,
					'plugin_code' 	=> 'RHC',
					'message'		=> __('Calendar plugin update %s is available! <a href="%s">Please update now</a>','rhc')
				),
				'ad_options'			=> $ad_options,
				//'addons'				=> is_array($license_keys)&&count($license_keys)>0?true:false,
				'addons'				=> $this->debug_menu,
				'dc_options'			=> $dc_options,
				'fileuploader'			=> true,
				'wp_uploader'			=> true,
				'theme'					=> false,
				'stylesheet'			=> 'rhc-options',
				'option_show_in_metabox'=> true,
				'path'			=> RHC_PATH.'options-panel/',
				'url'			=> RHC_URL.'options-panel/',
				'pluginslug'	=> RHC_SLUG,
				'pluginfile'	=> RHC_SLUG,
				'api_url' 		=> $api_url,//affects registration api
				'layout'		=> 'horizontal',
				'enable_notifications'	=> ( '1'==$this->get_option('enable_notifications','1',true) ? true : false )
			);
			
			do_action('rh-php-commons');	
			
			$settings['id'] 		= $this->id;
			$settings['menu_id'] 	= $this->id;
			$settings['menu_text'] 	= __('Options','rhc');
			$settings['import_export'] = false;
			$settings['import_export_options'] =false;
			$settings['registration'] = true;
			$settings['downloadables'] = true;
				
			if(class_exists('PluginOptionsPanelModule'))new PluginOptionsPanelModule($settings);
			$settings['enable_notifications'] = false;
			//--------
			if($this->debug_menu){
				require_once RHC_PATH.'includes/class.debug_calendarize.php';
				new debug_calendarize('edit.php?post_type='.RHC_EVENTS);
			}
			
			//--adds metabox for choosing template. not supported yet.
			//require_once RHC_PATH.'includes/class.rhc_event_template_metabox.php';
			//new rhc_event_template_metabox(RHC_EVENTS,$this->debug_menu);

endif;
?>