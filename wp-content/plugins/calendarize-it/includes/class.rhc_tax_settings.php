<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/
class rhc_tax_settings {
	function __construct($plugin_id='rhc'){
		//$this->id = $plugin_id.'-log';
		$this->id = $plugin_id;
		add_filter("pop-options_{$this->id}",array(&$this,'options'),10,1);			
	}
	
	function options($t){
		$i = count($t);
		//-------------------------
		$default_taxonomies = array(
			RHC_CALENDAR 	=> __('Calendar','rhc'),
			RHC_ORGANIZER	=> __('Organizer','rhc'),
			RHC_VENUE		=> __('Venues','rhc')
		);
		
		$taxonomies = apply_filters('rhc-taxonomies',$default_taxonomies);
		//-------------------------	
		$i = count($t);
		$t[$i]=(object)array();
		$t[$i]->id 			= 'cal-tax'; 
		$t[$i]->label 		= __('Calendarize taxonomies','rhc');
		$t[$i]->right_label	= __('Calendarize taxonomies','rhc');
		$t[$i]->page_title	= __('Calendarize taxonomies','rhc');
		$t[$i]->theme_option = true;
		$t[$i]->plugin_option = true;
		$t[$i]->options = array();		

		$t[$i]->options[]=(object)array(
			'id'		=> 'tax-description',
			'type'		=> 'subtitle',
			'label'		=> __('Enable calendarize-it taxonomies','rhc'),
			'description'=> __("Check the post type name for wich you want to enable the custom taxonomy.",'rhc')
		);
		
		//--------------
		$post_types=array();
		foreach(get_post_types(array(/*'public'=> true,'_builtin' => false*/),'objects','and') as $post_type => $pt){
			if(in_array($post_type,array('revision','nav_menu_item')))continue;
			$post_types[$post_type]=$pt;
		} 
		$post_types = apply_filters('calendarize_taxonomy_post_type_options',$post_types);
		//--------------	

		if(count($post_types)==0){
			$t[$i]->options[]=(object)array(
				'id'=>'no_ctypes',
				'type'=>'description',
				'description'=>__("There are no additional Post Types to enable.",'rhc')
			);
		}else{
			foreach($taxonomies as $taxonomy => $taxonomy_label){
				$t[$i]->options[]=(object)array(
					'type'=>'subtitle',
					'label'=> $taxonomy_label
				);
				
				$j=0;
				foreach($post_types as $post_type => $pt){
					$tmp=(object)array(
						'id'	=> $taxonomy.'_post_types_'.$post_type,
						'name'	=> $taxonomy.'_post_types[]',
						'type'	=> 'checkbox',
						'option_value'=>$post_type,
						'label'	=> (@$pt->labels->name?$pt->labels->name:$post_type),
						'el_properties' => array(),
						'save_option'=>true,
						'load_option'=>true
					);
//					if($j==0){
//						$tmp->description = __("Calendarize taxonomies (Calendar, Organizer, Venues, Addons)can be enabled for other post types.  Check the post types, where you want the taxonomy to be enabled.",'rhc');
//						$tmp->description_rowspan = count($post_types);
//					}
					$t[$i]->options[]=$tmp;
					$j++;
				}			
			}

		}

		$t[$i]->options[]=(object)array(
				'type'=>'clear'
			);
			
		$t[$i]->options[]=(object)array(
			'type'=>'subtitle',
			'label'=> __('Disable calendarize taxonomies','rhc'),
			'description'=>__('Use this options if you want to disable some of the calendarize-it built in taxonomies.','rhc')
		);
		
		foreach($default_taxonomies as $taxonomy => $label){
			$t[$i]->options[] = (object)array(
				'id'		=> 'disable_'.$taxonomy,
				'label'		=> sprintf(__('Disable %s taxonomy','rhc'),$label),
				'type'		=> 'yesno',
				'default'	=> '0',
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			);	
		
		}

		$t[$i]->options[]=(object)array(
				'type'=>'clear'
			);
			
		$t[$i]->options[]=(object)array(
			'id'		=> 'backend-event-list-taxonomies',
			'type'		=> 'subtitle',
			'label'		=> __('Backend Event List Taxonomies','rhc'),
			'description'=> sprintf('<p>%s</p><p>%s</p>',
				__("Check taxonomies that you would like to remove from the backend event list.",'rhc'),
				__("On some sites, a large number of custom taxonomies makes the backend event list page to load very slow.",'rhc')
			)
		);		
		
		foreach($taxonomies as $taxonomy => $taxonomy_label){
			$tmp=(object)array(
				'id'	=> 'adm_lst_disabled_tax_'.$taxonomy,
				'name'	=> 'adm_lst_disabled_tax[]',
				'type'	=> 'checkbox',
				'option_value'=>$taxonomy,
				'label'	=> sprintf(  __("Disable taxonomy %s",'rhc'), $taxonomy_label),
				'el_properties' => array(),
				'save_option'=>true,
				'load_option'=>true
			);

			$t[$i]->options[]=$tmp;
		}
		
		global $rhc_plugin;
		$linked_taxonomies = $rhc_plugin->get_option('taxonomies',false,true);
		if( is_array($linked_taxonomies) && count($linked_taxonomies)>0 ){
			foreach($linked_taxonomies as $taxonomy){
				if( $tax = get_taxonomy( $taxonomy) ){
					$tmp=(object)array(
						'id'	=> 'adm_lst_disabled_tax_'.$taxonomy,
						'name'	=> 'adm_lst_disabled_tax[]',
						'type'	=> 'checkbox',
						'option_value'=>$taxonomy,
						'label'	=> sprintf(  __("Disable linked taxonomy %s",'rhc'), $tax->label ),
						'el_properties' => array(),
						'save_option'=>true,
						'load_option'=>true
					);
		
					$t[$i]->options[]=$tmp;
				}
			}
		}

		
		$t[$i]->options[]=(object)array(
				'type'=>'clear'
			);	
		/*
		$t[$i]->options[]=(object)array(
			'type'=>'subtitle',
			'label'=> __('Taxonomy bar filter','rhc'),
			'description'=>__('Check no to remove the default taxonomies from the filtering bar.','rhc')
		);

		$tmp = $default_taxonomies;
		$tmp['core_year']=__('Year','rhc');
		$tmp['core_month']=__('Month','rhc');
		foreach($tmp as $taxonomy => $label){
			$t[$i]->options[] = (object)array(
				'id'		=> 'tax_filter_skip_'.$taxonomy,
				'label'		=> sprintf(__('Disable %s taxonomy','rhc'),$label),
				'type'		=> 'yesno',
				'default'	=> '0',
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			);	
		}	
		
		$t[$i]->options[]=	(object)array(
				'id'			=> 'tax_filter_skip',
				'type' 			=> 'textarea',
				'label'			=> __('Other taxonomy slugs','rhc'),
				'description'	=> sprintf('<p>%s</p>',
					__('Add comma separated taxonomy slugs to remove from the filter bar.','rhc')
				),
				'el_properties' => array('rows'=>'5','cols'=>'50'),
				'save_option'=>true,
				'load_option'=>true
			);
		
		$t[$i]->options[]=(object)array(
				'type'=>'clear'
			);
		*/	
		$t[$i]->options[]=(object)array(
				'type'	=> 'submit',
				'label'	=> __('Save','rhc'),
				'class' => 'button-primary'
			);
				
		return $t;
	}
}
?>