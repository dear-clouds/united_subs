<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/
class rhc_post_info_settings {
	var $post_type = RHC_EVENTS;
	var $post_info_boxes = array();
	function __construct($plugin_id='rhc'){
		$this->id = $plugin_id;
		add_filter("pop-options_{$this->id}",array(&$this,'options'),10,1);		
		add_action('pop_handle_save',array(&$this,'pop_handle_save'),50,1);	
		
		$this->post_info_boxes = apply_filters('pop_post_info_boxes', array(
			'detailbox' 	=> __('Apply default Event Detail Box','rhc'),
			'venuebox'		=> __('Apply default Venue Detail Box','rhc'),
			'tooltipbox' 	=> __('Apply default Dynamic Tooltip','rhc')
		)); 
	}

	function pop_handle_save($pop){
		global $rhc_plugin;
		if($rhc_plugin->options_varname!=$pop->options_varname)return;
		
		if(isset($_POST['pinfo_restore'])){
			if(current_user_can($rhc_plugin->options_capability)){
				include 'bundle_default_custom_fields.php';
				if(!empty($postinfo_boxes)){
					//--save:
					$options = get_option($rhc_plugin->options_varname);
					$options = is_array($options)?$options:array();
					$options['postinfo_boxes']=$postinfo_boxes;
					//--
					update_option($rhc_plugin->options_varname,$options);	
				}			
			}
		}
		
		$pinfo_apply_default_post_type = isset( $_POST['pinfo_apply_default_post_type'] ) ? $_POST['pinfo_apply_default_post_type'] : RHC_EVENTS ;
		
		$clear_events_cache = false;
		if(isset($_POST['pinfo_apply_default'])){
			$options = get_option($rhc_plugin->options_varname);
			$options = is_array($options)?$options:array();		
			$postinfo_boxes = $options['postinfo_boxes'];
			//---
			global $wpdb;
			$sql = "SELECT M.post_id FROM `{$wpdb->postmeta}` M INNER JOIN `{$wpdb->posts}` P ON P.ID=M.post_id WHERE M.meta_key='postinfo_boxes' AND P.post_type='" . $pinfo_apply_default_post_type . "';";
			$post_ids = $wpdb->get_col($sql,0);
			if(is_array($post_ids) && count($post_ids)>0){
				foreach($post_ids as $post_ID){
					update_post_meta($post_ID, 'postinfo_boxes', $postinfo_boxes);
					$clear_events_cache = true;
				}
			}
		}
		//--
		foreach($this->post_info_boxes as $id => $label){
			$post_field_name = 'pinfo_apply_default_'.$id;
			if(isset($_POST[$post_field_name])){
				$options = get_option($rhc_plugin->options_varname);
				$options = is_array($options)?$options:array();		
				$postinfo_boxes = $options['postinfo_boxes'];
				//---
				global $wpdb;
				$sql = "SELECT M.post_id FROM `{$wpdb->postmeta}` M INNER JOIN `{$wpdb->posts}` P ON P.ID=M.post_id WHERE M.meta_key='postinfo_boxes' AND P.post_type='" . $pinfo_apply_default_post_type . "';";
				$post_ids = $wpdb->get_col($sql,0);
				if(is_array($post_ids) && count($post_ids)>0){
					foreach($post_ids as $post_ID){
						$current = get_post_meta($post_ID, 'postinfo_boxes', true);
						$current = is_array($current)?$current:array();
						$current[$id] = isset($postinfo_boxes[$id]) ? $postinfo_boxes[$id] : array() ;
						update_post_meta($post_ID, 'postinfo_boxes', $current);
						$clear_events_cache = true;
					}
				}
			}			
		}
		
		if( $clear_events_cache ){
			$this->handle_delete_events_cache();
		}
	}
	
	function handle_delete_events_cache(){
		global $rhc_plugin,$wpdb;		
		if('1'!=$rhc_plugin->get_option('disable_rhc_cache','',true)){
			//clear cache.
			if(!function_exists('rhc_handle_delete_events_cache')){
				require_once RHC_PATH.'includes/function.rhc_handle_delete_events_cache.php';
			}
			rhc_handle_delete_events_cache();
		}
	}
	
	function get_post_type_options(){
		global $rhc_plugin;
		$post_types = $rhc_plugin->get_option('dbox_post_types',array());
		$post_types = is_array($post_types)?$post_types:array();
		if( !in_array( RHC_EVENTS, $post_types ) ){
			array_unshift( $post_types, RHC_EVENTS );
		}
		$post_types = apply_filters('rhc_dbox_metabox_post_types',$post_types);

		$options = array();
		foreach( $post_types as $post_type ){
			$options[ $post_type ] = $post_type;
		}
		
		return $options;
	}
	
	function options($t){
		$i = count($t);
		//-- Permalink settings -----------------------		
		$i = count($t);
		$t[$i]=(object)array();
		$t[$i]->id 			= 'rhc-post-info-settings'; 
		$t[$i]->label 		= __('Default event fields','rhc');
		$t[$i]->right_label	= __('Customize event fields','rhc');
		$t[$i]->page_title	= __('Default event fields','rhc');
		$t[$i]->theme_option = true;
		$t[$i]->plugin_option = true;
		
		$t[$i]->options = array(
			(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('Default post info fields','rhc')
			),			
			(object)array(
				'id'			=> 'datetime_format',
				'type' 			=> 'text',
				'default'		=> get_option('links_updated_date_format', __('F j, Y','rhc').' '.__('g:i a','rhc') ),
				'description'	=> __("Datetime, date and time format in this tab only applies to the start and end meta fields (start datetime, start date, start time, end datetime, end date, end time).  Because this values are rendered server side they follow the php <a href=\"http://php.net/manual/en/function.date.php\">date formatting syntax</a>.","rhc"),
				'label'			=> __('Datetime format','rhc'),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array(
				'id'			=> 'date_format',
				'type' 			=> 'text',
				'default'		=> get_option('date_format',__('F j, Y','rhc')),
				'label'			=> __('Date format','rhc'),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array(
				'id'			=> 'time_format',
				'type' 			=> 'text',
				'default'		=> get_option('time_format',__('g:i a','rhc')),
				'label'			=> __('Time format','rhc'),
				'save_option'=>true,
				'load_option'=>true
			),

			(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('Restore custom fields','rhc'),
				'description'	=> sprintf('<p>%s</p><p>%s</p>',
					__('If you have overwritten the default custom fields, use this button to restore the original set.','rhc'),
					__('Observe that the default set is only used when creating new events.  Existing events will keep their current custom field layout.','rhc')
				)
			),			
			(object)array(
				'id'		=> 'pinfo_default_set',
				'label'		=> __('Default','rhc'),
				'type'		=> 'callback',
				'callback'	=> array(&$this,'render_default_set'),
				'el_properties'	=> array(),
				'save_option'=>false,
				'load_option'=>false
			),			
			(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('Apply default to all events','rhc'),
				'description'	=> sprintf('<p>%s</p><p>%s</p><p><b>%s</b></p>',
					__('This option will apply and overwrite the custom field layout with the default one, on ALL events.','rhc'),
					__('This operation may take a while to complete.','rhc'),
					__('This operation cannot be undone. All the events custom field layout will be replaced!','rhc')
				)
			),	
			(object)array(
				'id'		=> 'pinfo_apply_default',
				'label'		=> __('Apply Default','rhc'),
				'type'		=> 'callback',
				'callback'	=> array(&$this,'render_pinfo_apply_default'),
				'el_properties'	=> array(),
				'save_option'=>false,
				'load_option'=>false
			)					
		);
		
		$t[$i]->options[]=(object)array(
				'type'=>'clear'
			);
		
		$t[$i]->options[]=(object)array(
				'type'	=> 'submit',
				'label'	=> __('Save','rhc'),
				'class' => 'button-primary'
			);
		//-------------------------		
		return $t;
	}
	
	function render_default_set(){
		global $rhc_plugin;
		$postinfo_boxes		= $rhc_plugin->get_option('postinfo_boxes',false,true);
		$out = sprintf('<input type="submit" name="pinfo_restore" value="%s" class="button-primary" />',htmlspecialchars(__('Restore custom fields','rhc')));
		$out.= '<div style="display:none;"><textarea>'.json_encode($postinfo_boxes).'</textarea></div>';
		return $out;
	}
	
	function render_pinfo_apply_default(  ){
		$out = '';		

		$post_type_options = $this->get_post_type_options();
		$select = '<select name="pinfo_apply_default_post_type">';
		foreach( $post_type_options as $value => $label ){
			$select .= sprintf( '<option name="%s">%s</option>', 
				$value, 
				$label 
			);
		}
		$select.='</select>';	

		$out.=sprintf( __('Post type to apply: %s','rhc'), $select);

		foreach($this->post_info_boxes as $id => $label){
			$out .= sprintf('<p><input type="submit" name="pinfo_apply_default_%s" value="%s" class="button-primary" /></p>',
				$id,
				htmlspecialchars($label)
			);
		}	
		
		$out.= sprintf('<p><input type="submit" name="pinfo_apply_default" value="%s" class="button-primary" /></p>',
			htmlspecialchars(__('Apply ALL default','rhc'))
		);
		return $out;
	}
}
?>