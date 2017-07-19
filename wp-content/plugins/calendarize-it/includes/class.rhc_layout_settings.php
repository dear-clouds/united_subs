<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/
class rhc_layout_settings {
	function __construct($plugin_id='rhc'){
		//$this->id = $plugin_id.'-log';
		$this->id = $plugin_id;
		add_filter("pop-options_{$this->id}",array(&$this,'options'),10,1);			
		add_action('pop_handle_save',array(&$this,'pop_handle_save'),50,1);
		add_action("pop_admin_head_{$this->id}", array(&$this,'head'),10,1);
		add_action("pop_body_{$this->id}", array(&$this,'body'),10,1);
		
		add_action('wp_ajax_rhc_default_template', array(&$this,'wp_ajax_rhc_default_template'));
	}
	
	function pop_handle_save($pop){
		global $rhc_plugin;
		if($rhc_plugin->options_varname!=$pop->options_varname)return;
		update_option('rhc_flush_rewrite_rules',true);
		//--- some settings affect output, clear cache
		$this->handle_delete_events_cache();
	}
	
	function list_of_pages_with_shortcode(){
		global $wpdb;
		$sql = "SELECT ID, post_title FROM $wpdb->posts WHERE post_status=\"publish\" AND post_content LIKE \"%[calendarizeit%\" LIMIT 100";
		$ids = $wpdb->query($sql);
		$out = '';
		if($wpdb->num_rows>0){
			$out .= '<ul>';
			foreach($wpdb->last_result as $p){
				$out.= sprintf('<li><a href="%s">%s</a></li>',
					get_permalink( $p->ID ),
					$p->post_title
				);
			}
			$out .= '</ul>';
		}else{
			
		}
		return $out;
	}
	
	function options($t){
	
		$pages = $this->get_pages_for_dropdown();	
		
		$i = count($t);
		$t[$i]=(object)array();
		$t[$i]->id 			= 'rhc-template'; 
		$t[$i]->label 		= __('Template Settings','rhc');
		$t[$i]->right_label	= __('Adjust Template Settings','rhc');
		$t[$i]->page_title	= __('Template Settings','rhc');
		$t[$i]->theme_option = true;
		$t[$i]->plugin_option = true;
		$t[$i]->options = array(
			(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('Current pages using the shortcode','rhc')
			),		
			(object)array(
				'type' 			=> 'callback',
				'callback'		=> array(&$this,'list_of_pages_with_shortcode')
			),		
			(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('Template Integration','rhc'),
				'description'=>__('Use the latest available version.  Version 1 is the original template integration; provided for back compatibility on sites that have already customized their calendar templates but want to update the plugin. ','rhl'),
			),		
			(object)array(
				'id'		=> 'template_integration',
				'label'		=> __('Template Integration','rhc'),
				'type'		=> 'select',
				'default'	=> 'version2',
				'options'	=> array(
					'version1'	=> 'version 1',
					'version2'	=> 'version 2'
				),
				'hidegroup'	=> '#template_integration_meta',
				'hidevalues' => array('version2'),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			),	
			(object)array('type'	=> 'clear'),	
			(object)array(
				'id'	=> 'template_integration_meta',
				'type'=>'div_start'
			)
		);	
		
		$t[$i]->options[]=(object)array(
				'id'			=> 'event_template_page_id',
				'type' 			=> 'select',
				'label'			=> __('Detailed Event Page Template','rhc'),
				'description'	=> sprintf('<p>%s</p>',
					__('Select the page you want to use as a template for the Detailed Event Page and Detailed Venue Page.','rhc')
				),
				'el_properties'=>array('class'=>'widefat'),
				'options'=> $pages,
				'save_option'=>true,
				'load_option'=>true
			);
			
		$t[$i]->options[]=(object)array(
				'id'			=> 'taxonomy_template_page_id',
				'type' 			=> 'select',
				'options'		=> $pages,
				'label'			=> __('Taxonomy Page Template','rhc'),
				'el_properties'=>array('class'=>'widefat'),
				'save_option'=>true,
				'load_option'=>true
			);
			
		$t[$i]->options[]=(object)array(
				'id'			=> 'venue_template_page_id',
				'type' 			=> 'select',
				'options'		=> $pages,
				'label'			=> __('Venue Page Template','rhc'),
				'el_properties'=>array('class'=>'widefat'),
				'save_option'=>true,
				'load_option'=>true
			);
			
		$t[$i]->options[]=(object)array(
				'id'			=> 'organizer_template_page_id',
				'type' 			=> 'select',
				'options'		=> $pages,
				'label'			=> __('Organizer Page Template','rhc'),
				'el_properties'=>array('class'=>'widefat'),
				'save_option'=>true,
				'load_option'=>true
			);
			
		$t[$i]->options[]=(object)array('type'	=> 'div_end');
		$t[$i]->options[]=(object)array('type'	=> 'clear');
		
		$taxonomies = apply_filters('rhc-taxonomies',array());
		if(is_array($taxonomies) && count($taxonomies)>0 ){
			$t[$i]->options[]=(object)array(
					'type' 			=> 'subtitle',
					'label'			=> __('Custom taxonomies template ','rhc')
				);
				
			foreach($taxonomies as $taxonomy => $label){
				$t[$i]->options[]=(object)array(
						'id'			=> $taxonomy.'_template_page_id',
						'type' 			=> 'select',
						'options'		=> $pages,
						'label'			=> sprintf( __('%s page Template','rhc'), $label),
						'el_properties'=>array('class'=>'widefat'),
						'save_option'=>true,
						'load_option'=>true
					);
			}	
		}
		$t[$i]->options[]=(object)array('type'	=> 'clear');
		
		$t[$i]->options[]=(object)array(
				'id'			=> 'widget_link_template_page_id',
				'type' 			=> 'select',
				'options'		=> $pages,
				'label'			=> __('Calendar Widget links to Page','rhc'),
				'el_properties'=>array('class'=>'widefat'),
				'description'	=> sprintf('<p>%s</p>',
					__('Calendar widget: Selet a page, to which the calendar widget will take the user when clicked.  Usually a page containing the calendarizeit shortcode.','rhc')
				),
				'save_option'=>true,
				'load_option'=>true
			);
		$t[$i]->options[]=(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('Calendarize Templates','rhc'),
				'description'	=> __('Disable calendarize templates if you want to use the theme templates.  Observe that meta data like maps, venue and extra info will need to be added manually throught shortcodes.','rhc')
			);
		$t[$i]->options[]=(object)array(
				'id'		=> 'template_archive',
				'label'		=> __('Disable Archive Template','rhc'),
				'type'		=> 'yesno',
				'default'	=> '0',
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			);
		
		$t[$i]->options[]=(object)array(
				'id'		=> 'template_single',
				'label'		=> __('Disable Event Template','rhc'),
				'type'		=> 'yesno',
				'default'	=> '0',
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			);
		$t[$i]->options[]=(object)array(
				'id'		=> 'template_taxonomy',
				'label'		=> __('Disable Taxonomy Template','rhc'),
				'type'		=> 'yesno',
				'default'	=> '0',
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			);
		$t[$i]->options[]=(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('Ajax based templates and sliders','rhc'),
				'description'	=> __('Some themes that load content with ajax, tabs, and sliders break the initial rendering of the calendar.  Choose yes to prevent this.  If not needed the recommended setting is to choose no.','rhc')
			);
		$t[$i]->options[]=(object)array(
				'id'		=> 'visibility_check',
				'label'		=> __('Check calendar visibility','rhc'),
				'type'		=> 'yesno',
				'default'	=> '0',
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			);
		$t[$i]->options[]=(object)array('type'	=> 'clear');
		$t[$i]->options[]=(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('Google map','rhc')
			);
		$t[$i]->options[]=(object)array(
				'id'		=> 'gmap3_scrollwheel',
				'label'		=> __('Enable mouse wheel google map zoom ','rhc'),
				'description'=> __('If disabled, the user can still zoom in or out using the zoom control buttons.','rhc'),
				'type'		=> 'yesno',
				'default'	=> '1',
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			);
		$t[$i]->options[]=(object)array(
				'id'		=> 'gmap3_style',
				'label'		=> __('Map style','rhc'),
				'description'=> __('Get additional free map styles in the Downloads section.','rhc'),
				'type'		=> 'select',
				'default'	=> '',
				'options'	=> apply_filters( 'rhc_gmap3_style_options', array(
					'' => __('Default','')
				)),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			);
		$t[$i]->options[]=(object)array('type'	=> 'clear');
		$t[$i]->options[]=(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('Open Graph headers','rhc')
			);
		$t[$i]->options[]=(object)array(
				'id'		=> 'enable_rhc_og',
				'label'		=> __('Enable opengraph headers','rhc'),
				'description'=> __('If you already have another plugin adding opengraph headers, you can choose to disable it here.','rhc'),
				'type'		=> 'yesno',
				'default'	=> '1',
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			);	
		$t[$i]->options[]=(object)array('type'	=> 'clear');
		$t[$i]->options[]=(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('Google Structured Data','rhc')
			);
		$t[$i]->options[]=(object)array(
				'id'		=> 'enable_rhc_auto_microdata',
				'label'		=> __('Enable automatic microdata (Event)','rhc'),
				'description'=> __('When this option is set to yes, microdata will automatically be added to an event.','rhc'),
				'type'		=> 'yesno',
				'default'	=> '1',
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			);									
		$t[$i]->options[]=(object)array('type'	=> 'clear');
		$t[$i]->options[]=(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('HTML wrapper','rhc')
			);
		$t[$i]->options[]=(object)array(
				'id'			=> 'rhc-before-content',
				'type' 			=> 'textarea',
				'label'			=> __('HTML Between header and content','rhc'),
				'description'	=> sprintf('<p>%s</p><p>%s</p>',
					__('On some themes you may need to add additional html so the content is styled correctly by the theme.','rhc'),
					__('This is only used on template version 1.','rhc')
				),
				'el_properties' => array('rows'=>'15','cols'=>'50'),
				'save_option'=>true,
				'load_option'=>true
			);
		$t[$i]->options[]=(object)array(
				'id'			=> 'rhc-after-content',
				'type' 			=> 'textarea',
				'label'			=> __('HTML Between content and footer','rhc'),
				'el_properties' => array('rows'=>'15','cols'=>'50'),
				'save_option'=>true,
				'load_option'=>true
			);
		
		//-----------
		$t[$i]->options[]=(object)array(
				'type'=>'clear'
			);
		$t[$i]->options[]=(object)array(
				'type'	=> 'submit',
				'label'	=> __('Save','rhc'),
				'class' => 'button-primary'
			);		
			
		//----			
		$i = count($t);
		$t[$i]=(object)array();
		$t[$i]->id 			= 'rhc-meda'; 
		$t[$i]->label 		= __('Media settings','rhc');
		$t[$i]->right_label	= __('Adjust media settings','rhc');
		$t[$i]->page_title	= __('Media settings','rhc');
		$t[$i]->theme_option = true;
		$t[$i]->plugin_option = true;	
		$t[$i]->options = array(
			(object)array(
				'id'		=> 'rhc_media_size',
				'label'		=> __('Event list/tooltip image size','rhc'),
				'type'		=> 'select',
				'default'	=> 'medium',
				'options'	=> array(
					'thumbnail'	=> __('Thumbnail','rhc'),
					'medium'	=> __('Medium','rhc'),
					'large'		=> __('Large','rhc'),
					'full'		=> __('Full','rhc')
				),
				'description'	=> __('Please observe that this does NOT modifies the size of the image on screen wich is controlled by the stylesheet.  This is used to determine what image size to use as source.','rhc'),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			),	
			(object)array(
				'id'		=> 'rhc_single_media_size',
				'label'		=> __('Detail box image','rhc'),
				'type'		=> 'select',
				'default'	=> 'large',
				'options'	=> array(
					'thumbnail'	=> __('Thumbnail','rhc'),
					'medium'	=> __('Medium','rhc'),
					'large'		=> __('Large','rhc'),
					'full'		=> __('Full','rhc')
				),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			)			
		);
		
		$t[$i]->options[]=	(object)array(
				'id'			=> 'default_event_featured_image',
				'type'			=> 'wp_uploader',
				'set_label'		=>  __('Set Default Featured Event Image','rhc'),
				'unset_label'	=>  __('Remove Default Featured Event Image','rhc'),
				'modal_title'	=> __('Set Default Featured Event Image','rhc'),
				'modal_button'	=> __('Set Default Featured Event Image','rhc'),
				'save_option'	=> true,
				'load_option'	=> true
			);			
		
		$t[$i]->options[]=(object)array(
				'type'=>'clear'
			);
		$t[$i]->options[]=(object)array(
				'type'	=> 'submit',
				'label'	=> __('Save','rhc'),
				'class' => 'button-primary'
			);	
			
		//----			
		$i = count($t);
		$t[$i]=(object)array();
		$t[$i]->id 			= 'rhc-general'; 
		$t[$i]->label 		= __('General settings','rhc');
		$t[$i]->right_label	= __('General settings','rhc');
		$t[$i]->page_title	= __('General settings','rhc');
		$t[$i]->theme_option = true;
		$t[$i]->priority 	= 10;
		$t[$i]->plugin_option = true;		
		$t[$i]->options = array(
			(object)array(
				'id'		=> 'disable_event_link',
				'label'		=> __('Disable event link','rhc'),
				'type'		=> 'yesno',
				'default'	=> '0',
				'description'	=> __('Check this option if you do not want the calendar events to link to a single event page.','rhc'),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array(
				'id'		=> 'taxonomy_links',
				'label'		=> __('Taxonomies are links','rhc'),
				'description' => __('Choose yes if you want to make taxonomies hyperlinks.  Example venue will be a link to the venue page.','rhc'),
				'type'		=> 'yesno',
				'default'	=> '1',
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			),			
			(object)array(
				'id'		=> 'disable_event_search',
				'label'		=> __('Disable event search','rhc'),
				'type'		=> 'yesno',
				'default'	=> '0',
				'description'	=> __('Check this option if you do not want events to show in search results.','rhc'),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array(
				'id'		=> 'disable_print_css',
				'label'		=> __('Disable print css','rhc'),
				'type'		=> 'yesno',
				'default'	=> '0',
				'description'	=> __('When printing a page with a calendar, by default only the calendar will be printed.  Check this option to disable print css.','rhc'),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array(
				'id'		=> 'scripts_on_demand',
				'label'		=> __('Scripts and styles on demand','rhc'),
				'type'		=> 'yesno',
				'default'	=> '0',
				'description'	=> sprintf('<p>%s</p><p>%s</p><p>%s</p><p>%s</p>',
					__('Choose yes if you only want Calendarize it! scripts to load when required.','rhc'),
					__('Please observe that this requires that the theme correctly implementes the wp_footer action hook.','rhc'),
					__('Please observe that this may not work with ajax based themes.','rhc'),
					__('Please observe that if you use the Map Addon, Events Grid Addon, or Community Events Addon, you also need the latest version of the addons for this feature to work.','rhc')
				),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			)
			
			
		);		
		
		$t[$i]->options[]=(object)array(
				'type'=>'clear'
			);						
		//$t[$i]->options[]=;
		$t[$i]->options[]=(object)array(
				'type'			=> 'subtitle',
				'label'			=> __('Default layout options','rhc'),
				'description'	=> __('Default layout options values to use when adding events.','rhc')
			);
			
		$t[$i]->options[]=(object)array(
				'id'			=> 'enable_featuredimage',
				'type'			=> 'onoff',
				'default'		=> '1',
				'label'			=>  __('Event Page Top Image','rhc'),
				'save_option'	=> true,
				'load_option'	=> true
			);
			
		$t[$i]->options[]=(object)array(
				'id'			=> 'enable_postinfo',
				'type'			=> 'onoff',
				'default'		=> '1',
				'label'			=>  __('Event Details Box','rhc'),
				'save_option'	=> true,
				'load_option'	=> true
			);
			
		$t[$i]->options[]=(object)array(
				'id'			=> 'enable_postinfo_image',
				'type'			=> 'onoff',
				'default'		=> '1',
				'label'			=>  __('Event Details Box Image','rhc'),
				'save_option'	=> true,
				'load_option'	=> true
			);
			
		$t[$i]->options[]=(object)array(
				'id'			=> 'enable_venuebox',
				'type'			=> 'onoff',
				'default'		=> '1',
				'label'			=>  __('Venue Details Box','rhc'),
				'save_option'	=> true,
				'load_option'	=> true
			);
			
		$t[$i]->options[]=(object)array(
				'id'			=> 'enable_venuebox_gmap',
				'type'			=> 'onoff',
				'default'		=> '1',
				'label'			=>  __('Venue Details Box Map','rhc'),
				'save_option'	=> true,
				'load_option'	=> true
			);

		$t[$i]->options[]=(object)array(
				'type'=>'clear'
			);	

		$t[$i]->options[]=(object)array(
				'type'=>'subtitle',
				'label'=>__('Mobile','rhc'),
				'description'=>__('When the calendar object is smaller than the value set, mobile layout will be displayed instead of the regular calendar layout.  This does not apply to calendar widgets.','rhc')
			);	
			
		$t[$i]->options[]=(object)array(
				'id'	=> 'mobile_width',
				'type'	=> 'range',
				'label'	=> __('Mobile width trigger size','rhc'),
				'min'	=> 0,
				'max'	=> 600,
				'step'	=> 1,
				'default'=> 480,
				'save_option'=>true,
				'load_option'=>true
			);		

		$t[$i]->options[]=(object)array(
				'id'			=> 'postable_args',
				'type' 			=> 'textarea',
				'label'			=> __('Postable arguments','rhc'),
				'description'	=> sprintf('<p>%s</p>',
					__('Write comma separated shortcode arguments that you would like to make available for overwritting through the URL query.','rhc')
				),
				'el_properties' => array('rows'=>'3','cols'=>'50'),
				'save_option'=>true,
				'load_option'=>true
			);
				
		$t[$i]->options[]=(object)array(
				'type'=>'clear'
			);	
			
		$t[$i]->options[]=(object)array(
				'type'	=> 'submit',
				'label'	=> __('Save','rhc'),
				'class' => 'button-primary'
			);			
		//-- default shortcode values --------------------------		

		//-- Calendarize shortcode TAB
		include 'options.calendarize_shortcode.php';
		

		//-- List of events --------------------------
/*
		$i = count($t);
		$t[$i]->id 			= 'rhc-events-list'; 
		$t[$i]->label 		= __('List of events','rhc');
		$t[$i]->right_label	= __('Layout settings, date format','rhc');
		$t[$i]->page_title	= __('List of events','rhc');
		$t[$i]->theme_option = true;
		$t[$i]->plugin_option = true;
		$t[$i]->options = array(
			(object)array(
				'id'			=> 'rhc-list-layout',
				'type' 			=> 'textarea',
				'label'			=> __('Event list layout','rhc'),
				'el_properties' => array('rows'=>'15','cols'=>'50'),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array(
				'id'		=> 'rhc_load_default_list',
				'rel'		=> '#rhc-list-layout',
				'type'		=> 'callback',
				'callback'	=> array($this,'load_default'),
				'label'	=> __('Load default event list content template','rhc'),
				'class' => 'button-secondary rhc-load-default-layout'
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
*/			
		//-- Date formatting ----
		$i = count($t);
		$t[$i]=(object)array();
		$t[$i]->id 			= 'rhc-shortcode-layout'; 
		$t[$i]->label 		= __('Date/time format','rhc');
		$t[$i]->right_label	= __('Customize date and time formats','rhc');
		$t[$i]->page_title	= __('Date/time format','rhc');
		$t[$i]->theme_option = true;
		$t[$i]->plugin_option = true;		
		$t[$i]->options = array(
			(object)array(
				'type'=>'preview',
				'path'=>RHC_URL.'images/preview/dateformat/',
				'items'=>array(
					(object)array(
						'src'=> 'titleformat_month.jpg',
						'focus_target'=>'#cal_titleformat_month',
						'label'=>'',
						'description'=>''
					),
					(object)array(
						'src'=> 'columnformat_month.jpg',
						'focus_target'=>'#cal_columnformat_month',
						'label'=>'',
						'description'=>''
					),
					(object)array(
						'src'=> 'timeformat_month.jpg',
						'focus_target'=>'#cal_timeformat_month',
						'label'=>'',
						'description'=>''
					)
				)
			),		
			(object)array(
				'type'=>'subtitle',
				'label'=>__('Calendar month view','rhc')
			),			
			(object)array(
				'id'			=> 'cal_titleformat_month',
				'type' 			=> 'text',
				'label'			=> __('Month view title','rhc'),
				'el_properties' => array(
					'class'=>'widefat rhc_dateformat',
					'rel'=> __('MMMM yyyy','rhc')
				),
				'save_option'=>true,
				'load_option'=>true
			),			
			(object)array(
				'id'			=> 'cal_columnformat_month',
				'type' 			=> 'text',
				'label'			=> __('Column label','rhc'),
				'el_properties' => array(
					'class'=>'widefat rhc_dateformat',
					'rel'=> __('ddd','rhc')
				),
				'save_option'=>true,
				'load_option'=>true
			),			
			(object)array(
				'id'			=> 'cal_timeformat_month',
				'type' 			=> 'text',
				'label'			=> __('Event time format','rhc'),
				'el_properties' => array(
					'class'=>'widefat rhc_dateformat',
					'rel'=> __('h(:mm)t','rhc')
				),
				'save_option'=>true,
				'load_option'=>true
			),	
			(object)array(
				'type'=>'clear'
			),	
			(object)array(
				'type'=>'preview',
				'path'=>RHC_URL.'images/preview/dateformat/',
				'items'=>array(
					(object)array(
						'src'=> 'titleformat_week.jpg',
						'focus_target'=>'#cal_titleformat_week',
						'label'=>'',
						'description'=>''
					),
					(object)array(
						'src'=> 'columnformat_week.jpg',
						'focus_target'=>'#cal_columnformat_week',
						'label'=>'',
						'description'=>''
					),
					(object)array(
						'src'=> 'timeformat_week.jpg',
						'focus_target'=>'#cal_timeformat_week',
						'label'=>'',
						'description'=>''
					),
					(object)array(
						'src'=> 'axisformat.jpg',
						'focus_target'=>'#cal_axisformat',
						'label'=>'',
						'description'=>''
					)
				)
			),					
			(object)array(
				'type'=>'subtitle',
				'label'=>__('Calendar week view','rhc')
			),				
			(object)array(
				'id'			=> 'cal_titleformat_week',
				'type' 			=> 'text',
				'label'			=> __('Week view title','rhc'),
				'el_properties' => array(
					'class'=>'widefat rhc_dateformat',
					'rel'=> __("MMM d[ yyyy]{ '&#8212;'[ MMM] d yyyy}",'rhc')
				),
				'save_option'=>true,
				'load_option'=>true
			),	
			(object)array(
				'id'			=> 'cal_columnformat_week',
				'type' 			=> 'text',
				'label'			=> __('Week view column','rhc'),
				'el_properties' => array(
					'class'=>'widefat rhc_dateformat',
					'rel'=> __('ddd M/d','rhc')
				),
				'save_option'=>true,
				'load_option'=>true
			),			
			(object)array(
				'id'			=> 'cal_timeformat_week',
				'type' 			=> 'text',
				'label'			=> __('Event time format','rhc'),
				'el_properties' => array(
					'class'=>'widefat rhc_dateformat',
					'rel'=> __('h:mm{ - h:mm}','rhc')
				),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array(
				'id'			=> 'cal_axisformat',
				'type' 			=> 'text',
				'label'			=> __('Axis format (Also affects day view)','rhc'),
				'el_properties' => array(
					'class'=>'widefat rhc_dateformat',
					'rel'=>__('h(:mm)tt','rhc')
				),
				'save_option'=>true,
				'load_option'=>true
			),				
			(object)array(
				'type'=>'clear'
			),	
			(object)array(
				'type'=>'preview',
				'path'=>RHC_URL.'images/preview/dateformat/',
				'items'=>array(
					(object)array(
						'src'=> 'titleformat_day.jpg',
						'focus_target'=>'#cal_titleformat_day',
						'label'=>'',
						'description'=>''
					),
					(object)array(
						'src'=> 'columnformat_day.jpg',
						'focus_target'=>'#cal_columnformat_day',
						'label'=>'',
						'description'=>''
					),
					(object)array(
						'src'=> 'timeformat_day.jpg',
						'focus_target'=>'#cal_timeformat_day',
						'label'=>'',
						'description'=>''
					)
				)
			),					
			(object)array(
				'type'=>'subtitle',
				'label'=>__('Calendar day view','rhc')
			),					
			(object)array(
				'id'			=> 'cal_titleformat_day',
				'type' 			=> 'text',
				'label'			=> __('Day view title','rhc'),
				'el_properties' => array(
					'class'=>'widefat rhc_dateformat',
					'rel'=> __('dddd, MMM d, yyyy','rhc')
				),
				'save_option'=>true,
				'load_option'=>true
			)	,					
			(object)array(
				'id'			=> 'cal_columnformat_day',
				'type' 			=> 'text',
				'label'			=> __('Day view column','rhc'),
				'el_properties' => array(
					'class'=>'widefat rhc_dateformat',
					'rel'=>__('dddd M/d','rhc')
				),
				'save_option'=>true,
				'load_option'=>true
			),					
			(object)array(
				'id'			=> 'cal_timeformat_day',
				'type' 			=> 'text',
				'label'			=> __('Event time format','rhc'),
				'el_properties' => array(
					'class'=>'widefat rhc_dateformat',
					'rel'=>__('h:mm{ - h:mm}','rhc')
				),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array(
				'type'=>'clear'
			),	
			
			(object)array(
				'type'=>'preview',
				'path'=>RHC_URL.'images/preview/dateformat/',
				'items'=>array(
					(object)array(
						'src'=> 'eventlistdateformat.jpg',
						'focus_target'=>'#cal_eventlistdateformat',
						'label'=>'',
						'description'=>''
					),
					(object)array(
						'src'=> 'eventliststartdateformat.jpg',
						'focus_target'=>'#cal_eventliststartdateformat',
						'label'=>'',
						'description'=>''
					)
				)
			),										
			(object)array(
				'type'=>'subtitle',
				'label'=>__('Calendar event list view','rhc')
			),					
			(object)array(
				'id'			=> 'cal_eventlisttitleformat',
				'type' 			=> 'text',
				'label'			=> __('Title format','rhc'),
				'el_properties' => array(
					'class'=>'widefat rhc_dateformat',
					'rel'=>__('MMMM yyyy','rhc')
				),
				'save_option'=>true,
				'load_option'=>true
			),	
			(object)array(
				'id'			=> 'cal_eventlistdateformat',
				'type' 			=> 'text',
				'label'			=> __('Main date format','rhc'),
				'el_properties' => array(
					'class'=>'widefat rhc_dateformat',
					'rel'=>__('dddd MMMM d, yyyy','rhc')
				),
				'save_option'=>true,
				'load_option'=>true
			),					
			(object)array(
				'id'			=> 'cal_eventliststartdateformat',
				'type' 			=> 'text',
				'label'			=> __('Start/end date format','rhc'),
				'el_properties' => array(
					'class'=>'widefat rhc_dateformat',
					'rel'=>__('dddd MMMM d, yyyy. h:mmtt','rhc')
				),
				'save_option'=>true,
				'load_option'=>true
			),		
			(object)array(
				'id'			=> 'cal_eventliststartdateformat_allday',
				'type' 			=> 'text',
				'label'			=> __('Start/end date format (All day)','rhc'),
				'el_properties' => array(
					'class'=>'widefat rhc_dateformat',
					'rel'=>__('dddd MMMM d, yyyy.','rhc')
				),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array(
				'type'=>'clear'
			),		
			(object)array(
				'type'=>'subtitle',
				'label'=>__('Calendar event list view(Extended details)','rhc')
			),	
			(object)array(
				'id'			=> 'cal_eventlistextdateformat',
				'type' 			=> 'text',
				'label'			=> __('Date format','rhc'),
				'el_properties' => array(
					'class'=>'widefat rhc_dateformat',
					'rel'=>__('MMMM d, yyyy','rhc')
				),
				'save_option'=>true,
				'load_option'=>true
			),	
			(object)array(
				'id'			=> 'cal_eventlistexttimeformat',
				'type' 			=> 'text',
				'label'			=> __('Time format','rhc'),
				'el_properties' => array(
					'class'=>'widefat rhc_dateformat',
					'rel'=>__('h:mm tt','rhc')
				),
				'save_option'=>true,
				'load_option'=>true
			),		
			(object)array(
				'id'			=> 'cal_eventlistextdatetimeformat',
				'type' 			=> 'text',
				'label'			=> __('Date with time format','rhc'),
				'el_properties' => array(
					'class'=>'widefat rhc_dateformat',
					'rel'=>__('MMMM d, yyyy.  h:mm tt','rhc')
				),
				'save_option'=>true,
				'load_option'=>true
			),						
			(object)array(
				'type'=>'clear'
			),	
			(object)array(
				'type'=>'preview',
				'path'=>RHC_URL.'images/preview/dateformat/',
				'items'=>array(
					(object)array(
						'src'=> 'tooltip_startdate.jpg',
						'focus_target'=>'#cal_tooltip_startdate',
						'label'=>'',
						'description'=>''
					),
					(object)array(
						'src'=> 'tooltip_enddate.jpg',
						'focus_target'=>'#cal_tooltip_enddate',
						'label'=>'',
						'description'=>''
					)
				)
			),													
			(object)array(
				'type'=>'subtitle',
				'label'=>__('Event popup (click on calendar event)','rhc')
			),
			(object)array(
				'id'			=> 'cal_tooltip_startdate',
				'type' 			=> 'text',
				'label'			=> __('Start date','rhc'),
				'el_properties' => array(
					'class'=>'widefat rhc_dateformat',
					'rel'=>__('ddd MMMM d, yyyy h:mm TT','rhc')
				),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array(
				'id'			=> 'cal_tooltip_startdate_allday',
				'type' 			=> 'text',
				'label'			=> __('Start date(all-day)','rhc'),
				'el_properties' => array(
					'class'=>'widefat rhc_dateformat',
					'rel'=>__('ddd MMMM d, yyyy','rhc')
				),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array(
				'id'			=> 'cal_tooltip_enddate',
				'type' 			=> 'text',
				'label'			=> __('End date','rhc'),
				'el_properties' => array(
					'class'=>'widefat rhc_dateformat',
					'rel'=>__('ddd MMMM d, yyyy h:mm TT','rhc')
				),
				'save_option'=>true,
				'load_option'=>true
			)	,
			(object)array(
				'id'			=> 'cal_tooltip_enddate_allday',
				'type' 			=> 'text',
				'label'			=> __('End date(all-day)','rhc'),
				'el_properties' => array(
					'class'=>'widefat rhc_dateformat',
					'rel'=>__('ddd MMMM d, yyyy','rhc')
				),
				'save_option'=>true,
				'load_option'=>true
			)			
		);
		
		
		$t[$i]->options[] = (object)array(
				'type'=>'subtitle',
				'label'=>__('Date shortcodes default format','rhc')
			);	
			
		$t[$i]->options[] =	(object)array(
				'id'			=> 'cal_rhc_sc_date_format',
				'type' 			=> 'text',
				'label'			=> __('Date format','rhc'),
				'el_properties' => array(
					'class'=>'widefat rhc_dateformat',
					'rel'=>__('MMMM d, yyyy','rhc')
				),
				'save_option'=>true,
				'load_option'=>true
			);
			
		$t[$i]->options[] =	(object)array(
				'id'			=> 'cal_rhc_sc_time_format',
				'type' 			=> 'text',
				'label'			=> __('Time format','rhc'),
				'el_properties' => array(
					'class'=>'widefat rhc_dateformat',
					'rel'=>__('h:mm tt','rhc')
				),
				'save_option'=>true,
				'load_option'=>true
			);
		
		$t[$i]->options[]=(object)array(
				'type'=>'clear'
			);
		$t[$i]->options[]=(object)array(
				'type'	=> 'submit',
				'label'	=> __('Save','rhc'),
				'class' => 'button-primary'
			);		


		//--------------- ROLES CAPABILITES ACCESS ------------
		$i = count($t);
		$t[$i]=(object)array();
		$t[$i]->id 			= 'rhc-cap'; 
		$t[$i]->label 		= __('Feature Access','rhc');
		$t[$i]->right_label	= __('Set permissions by user role. ','rhc');
		$t[$i]->page_title	= __('Feature Access','rhc');
		$t[$i]->theme_option = true;
		$t[$i]->plugin_option = true;		
		$t[$i]->options = array();	

		$excluded_roles = array();
		$roles = get_editable_roles();
		if( is_array($roles) && count($roles)>0){
			foreach($roles as $role => $r){
				if(isset($r['capabilities']) && isset($r['capabilities']['manage_options']) && '1'==$r['capabilities']['manage_options'] ){
					$excluded_roles[]=$role;
				}
			}		
		}

		$capabilities = array(
		'read_'.RHC_CAPABILITY_TYPE						=> __('Read events', 'rhc'),
		'read_private_'.RHC_CAPABILITY_TYPE.'s'			=> __('Read private events', 'rhc'),
		'edit_'.RHC_CAPABILITY_TYPE.'s'					=> __('Edit events', 'rhc'),
		'publish_'.RHC_CAPABILITY_TYPE.'s'				=> __('Publish events', 'rhc'),
		'delete_'.RHC_CAPABILITY_TYPE.'s'				=> __('Delete events', 'rhc'),
		'edit_others_'.RHC_CAPABILITY_TYPE.'s'			=> __('Edit others events', 'rhc'),
		'edit_published_'.RHC_CAPABILITY_TYPE.'s'		=> __('Edit published events', 'rhc'),
		'delete_published_'.RHC_CAPABILITY_TYPE.'s'		=> __('Delete published events', 'rhc'),
		'delete_private_'.RHC_CAPABILITY_TYPE.'s'		=> __('Delete private events', 'rhc'),
		'delete_others_'.RHC_CAPABILITY_TYPE.'s'		=> __('Delete others events', 'rhc'),
		
		'manage_'.RHC_VENUE 							=> __('Manage venues', 'rhc'),
		'manage_'.RHC_CALENDAR							=> __('Manage calendars', 'rhc'),
		'manage_'.RHC_ORGANIZER							=> __('Manage organizers', 'rhc'),

		'calendarize_author'							=> __('Manage custom taxonomies (addon)', 'rhc')
		);		
		
		$capabilities = apply_filters( 'rhc_feature_access_capabilities', $capabilities );
		
		$t[$i]->options[] =	(object)array(
				'id'			=> 'rhc_caps',
				'label'			=> '',
				'type'			=> 'rolemanager',
				'capabilities'	=> $capabilities,
				'excluded_roles' => $excluded_roles,
				'el_properties'	=> array()
			);			
		
		$t[$i]->options[]=(object)array(
				'type'=>'clear'
			);
					
		$t[$i]->options[]=(object)array(
				'type'	=> 'submit',
				'label'	=> __('Save','rhcs'),
				'class' => 'button-primary'
			);
		//--------					
		$this->handle_demo_message();		
			
		return $t;		
		//--  settings -----------------------		
		
		//-------------------------		
		return $t;
	}
	
	function handle_demo_message(){
		if( !is_super_admin() && current_user_can('rh_demo') ){
			add_thickbox();
?>
<div id="demo_alert" style="display:none;">
	<p>Sorry, you can not change the settings in the demo.</p>
</div>		
<a id="btn_demo" style="display:none;" href="#TB_inline?width=400&height=250&inlineId=demo_alert" class="thickbox">View my inline content!</a>	
<script>
jQuery(document).ready(function($){
	setTimeout(function(){ $('#btn_demo').click().trigger('click'); },100);
});
</script>
<?php			
		}

	}
	
	function head(){
		wp_print_scripts( 'fc_dateformat_helper' );
?>
<style>
.pt-option-load-default {
	height:30px;
}
.pt-option-load-default input {
	float:left;
}
.pt-option-load-default img {
	width:21px;
	height:21px;
}
.load-default-status {
	display:none;
}
.rc_dateformat_helper {
	display:block;
	position:absolute;
	left:40px;
}
.rc_dateformat_helper_content {
	width:350px;
	padding:10px;
	z-index:8
}

.helper-arrow-holder {
	position:relative;
	top:-20px;
	left:48px;
}
.helper-arrow,
.helper-arrow-border {
	border-color: transparent  transparent #f5f5f5 transparent ;
    border-style: solid;
    border-width: 12px;
    cursor: pointer;
    font-size: 0;
    left: 0;
    line-height: 0;
    margin: 0 auto;
    position: absolute;
    right: 0;
    top: 0;
    width: 0;
    z-index: 9;
	display:block;
}
.helper-arrow {
    left: -22px;
    right: auto;
}
.helper-arrow-border {
    left: -22px;
    top: -2px;
    border-style: solid;
    border-width: 12px;
    z-index: 5;	
	margin:0;
}
.rc_dateformat_footer {
	padding-top:5px;
	text-align:right;
}
.pt-option {
	position:relative;
}
.rc_dateformat_preview {
	padding:5px;
	margin:5px 0 5px 0;
	font-weight:bold;
	font-size:1.2em;
}
</style>
<script type='text/javascript'>

jQuery(document).ready(function($){ 
	$.fn.extend({
		insertAtCaret: function(myValue){
		  	var obj;
		  	if( typeof this[0].name !='undefined' ) obj = this[0];
		  	else obj = this;
		
		  	if ($.browser.msie) {
		    	obj.focus();
		    	sel = document.selection.createRange();
		    	sel.text = myValue;
		    	obj.focus();
		    }
		 	else if ($.browser.mozilla || $.browser.webkit) {
		    	var startPos = obj.selectionStart;
		    	var endPos = obj.selectionEnd;
		    	var scrollTop = obj.scrollTop;
		    	obj.value = obj.value.substring(0, startPos)+myValue+obj.value.substring(endPos,obj.value.length);
		    	obj.focus();
		    	obj.selectionStart = startPos + myValue.length;
		    	obj.selectionEnd = startPos + myValue.length;
		    	obj.scrollTop = scrollTop;
		  	} else {
		    	obj.value += myValue;
		    	obj.focus();
		   	}
			return this.each(function(){});
		}
	});
	$('.rhc-load-default-layout').live('click',function(e){
		$(this).parent().find('.load-default-status').fadeIn();
		var args = {
			action: 'rhc_default_template',
			id: $(this).attr('rel')
		};
		
		$.post(ajaxurl,args,function(data){
			if(data.R=='OK'){
				$(data.DATA.id).val(data.DATA.value);
			}else{
				alert('Error loading template');
			}
			$('.load-default-status').fadeOut();
		},'json');
	});
		
	$('.rhc_dateformat').each(function(i,inp){
		var _id = $(this).attr('id');
		$('#dateformat_helper_base')
			.clone()
			.attr('id', _id+'_helper' )
			.attr('rel',_id)
			.hide()
			.appendTo( $(this).parent() )
		;
		
		$(this).attr('placeholder', $(this).attr('rel') );
		
		$(this).parent().find('.rhc_button').click(function(e){
			$('#'+_id).insertAtCaret( $(this).val() ).trigger('change');
		});
		
		$(this).parent().find('.rhc_button_default').click(function(e){
			$('#'+_id).val( $('#'+_id).attr('rel') ).trigger('change');	
		});
		
		$(this).parent().find('.rhc_button_space').click(function(e){
			$('#'+_id).insertAtCaret( ' ' ).trigger('change');
		});
		
		$(this).parent().find('.rhc_button_clear').click(function(e){
			$('#'+_id).val('').trigger('change');	
		});
		
		$(this).parent().find('.rhc_button_close').click(function(e){
			close_helper( $('.rc_dateformat_helper') );
		});
		
		$(this).change(function(e){
			var _now = new Date();
			var _formatted = $.fullCalendar.formatDate(_now,$(this).val());
			$(this).parent().find('.rc_dateformat_preview').html(_formatted);	
		});
		
		$(this).focus(function(e){
			close_helper( $('.rc_dateformat_helper') );
			open_helper( $(this).parent().find('.rc_dateformat_helper') );
			$(this).trigger('change');
		});
	});
	
});

function open_helper( helper ){
	
	helper
		//.css('opacity',0.2)
		//.css('margin-top',-10)
		.show()
		//.animate({opacity:1,'margin-top':0})
		;
}

function close_helper( helper ){
	helper.hide();
}
</script>
<?php	
	}
	
	function body(){
	//a template for the tooltip helper on date formats
		$formats = array(


			'd'		=> __('date number','rhc'),
			'dd'	=> __('date number, 2 digits','rhc'),
			'ddd'	=> __('date name, short','rhc'),
			'dddd'	=> __('date name, full','rhc'),
			'M'		=> __('month number','rhc'),
			'MM'	=> __('month number, 2 digits','rhc'),
			'MMM'	=> __('month name, short','rhc'),
			'MMMM'	=> __('month name, full','rhc'),
			'yy'	=> __('year, 2 digits','rhc'),
			'yyyy'	=> __('year, 4 digits','rhc'),
			'h'		=> __('hours, 12 hour format','rhc'),
			'hh'	=> __('hours, 12 hour format, 2 digits','rhc'),
			'H'		=> __('hours, 24 hour format','rhc'),
			'HH'	=> __('hours, 24 hour format, 2 digits','rhc'),		
			":"	=> __("colon",'rhc'),
			'm'		=> __('minutes','rhc'),
			'mm'	=> __('minutes, 2 digits','rhc'),	
			't'		=> sprintf(__("%s or %s",'rhc'),'a','p'),
			'tt'	=> sprintf(__("%s or %s",'rhc'),'am','pm'),
			'T'		=> sprintf(__("%s or %s",'rhc'),'A','P'),
			'TT'	=> sprintf(__("%s or %s",'rhc'),'AM','PM'),
			'u'		=> __("ISO8601 format",'rhc'),
			"''"	=> __("Single quote",'rhc'),
			","	=> __("comma",'rhc'),
			"/"	=> __("forward slash",'rhc')	,
			"."	=> __("dot",'rhc')
		);
?>
<div style="display:none;">
	<div id="dateformat_helper_base" class="rc_dateformat_helper">
		<div class="helper-arrow-holder">
			<div class="helper-arrow"></div>
			<div class="helper-arrow-border"></div>
		</div>
		
		<div class="rc_dateformat_helper_content postbox">
			<div class="rc_dateformat_preview_cont">
				<label class="rc_preview_label"><?php _e('Preview:','rhc')?></label>
				<div class="rc_dateformat_preview postbox"></div>
			</div>
			<div class="rc_dateformat_buttons">
				
				<?php foreach($formats as $format => $title):?>
				<input type="button" class="rhc_button rhc_<?php echo md5($format)?>"  title="<?php echo $title?>" value="<?php echo $format?>" rel="<?php echo $format?>" />
				<?php endforeach;?>
				<input type="button" class="rhc_button_default" title="<?php _e('default format','rhc')?>" value="<?php _e('default','rhc')?>"  />
				<input type="button" class="rhc_button_clear" title="<?php _e('clear value','rhc')?>" value="<?php _e('clear','rhc')?>"  />
				<input type="button" class="rhc_button_space" title="<?php _e('space','rhc')?>" value="&nbsp;&nbsp;&nbsp;<?php _e('space','rhc')?>&nbsp;&nbsp;&nbsp;" />
			</div>
			<div class="rc_dateformat_footer">
				<input type="button" class="button-secondary rhc_button_close" value="<?php _e('done','rhc')?>"  />
			</div>
		</div>
	</div>
</div>
<?php	
	}
	
	function load_default($tab,$i,$o){
		$id = $o->id;
		$load_image = RHC_URL.'options-panel/css/images/spinner_32x32.gif';
		return sprintf("<div class=\"pt-option pt-option-load-default\"><input rel=\"%s\" class=\"%s\" type=\"button\" id=\"%s\" name=\"%s\" value=\"%s\"  /><span class=\"load-default-status\"><img src=\"%s\" /></span></div>",$o->rel,$o->class, $id, $id, $o->label, $load_image );
	}		
	
	function wp_ajax_rhc_default_template(){
		$id = $_REQUEST['id'];
		$value = '';
		
		if($id=='#rhc-list-layout'){
			ob_start();
			require_once RHC_PATH.'templates/event_list_content.php';		
			$value = ob_get_contents();
			ob_end_clean();
		}else if($id=='#rhc-event-layout'){
			ob_start();
			require_once RHC_PATH.'templates/filter_event_content.php';		
			$value = ob_get_contents();
			ob_end_clean();
		}else if($id=='#rhc-venue-layout'){
			ob_start();
			require_once RHC_PATH.'templates/shortcode_venues_template_default.php';		
			$value = ob_get_contents();
			ob_end_clean();
		}else if($id=='#rhc-organizer-layout'){
			ob_start();
			require_once RHC_PATH.'templates/shortcode_organizers_template_default.php';		
			$value = ob_get_contents();
			ob_end_clean();
		}
		
		$r = array(
			'R'=>'OK',
			'MSG'=>'',
			'DATA'=> array(
				'id'=>$id,
				'value'=>$value
			)
		);
		die(json_encode($r));
	}
	
	function get_pages_for_dropdown(){
		$args = array(
			'post_type'=>'page',
			'post_status'=>array('draft','publish'),
			'orderby'=>'title',
			'order'=>'ASC',
			'nopaging'=>true,
			'numberposts'=>-1
		);
	
		$posts = get_posts($args);
		
		if(is_array($posts) && count($posts)>0){
			$arr = array(''=>__('--choose--','rhc'));
			foreach($posts as $r){
				$arr[$r->ID]=$r->post_title;
			}
			return $arr;
		}else{
			return array(''=>__('No options','rhc'));
		}
	}
	//-- copy of the one in class.rhc_calendar_metabox_rrule.php TODO, move to a single collection.
	function handle_delete_events_cache(){
		global $rhc_plugin,$wpdb;		
		if('1'!=$rhc_plugin->get_option('disable_rhc_cache','',true)){
			//clear cache.
			$sql = "TRUNCATE `{$wpdb->prefix}rhc_cache`";
			if($wpdb->query($sql)){
			
			}else{
				$sql = "DELETE FROM `{$wpdb->prefix}rhc_cache` WHERE (1)";
				if($wpdb->query($sql)){
			
				}
			}
		}
		$last_modified = gmdate("D, d M Y H:i:s") . " GMT";
		$rhc_plugin->update_option('data-last-modified', $last_modified );
		$rhc_plugin->update_option('data-last-modified-md5', md5($last_modified) );
	}	
}
?>