<?php
/*
vc notes
is_container: if set to true, cannot insert the el into row
*/
class WPBakeryShortCode_rhc_conditional_content extends WPBakeryShortCodesContainer {
		/* same as the one on shortcodes.php WPBakeryShortCodesContainer*/
		protected function outputTitle( $title ) {
			$icon = $this->settings( 'icon' );
			if ( filter_var( $icon, FILTER_VALIDATE_URL ) ) {
				$icon = '';
			}
			$params = array(
				'icon' => $icon,
				'is_container' => $this->settings( 'is_container' )/*,
				'title' => $title,*/
			);

			return '<h4 class="wpb_element_title"> ' . $this->getIcon( $params ) . '<div class="rhc-vc-container-label">'.$title.'</div></h4>';
		}
}
class WPBakeryShortCode_rhc_dbox extends WPBakeryShortCodesContainer {
		protected function outputTitle( $title ) {
			$icon = $this->settings( 'icon' );
			if ( filter_var( $icon, FILTER_VALIDATE_URL ) ) {
				$icon = '';
			}
			$params = array(
				'icon' => $icon,
				'is_container' => $this->settings( 'is_container' )/*,
				'title' => $title,*/
			);

			return '<h4 class="wpb_element_title"> ' . $this->getIcon( $params ) . '<div class="rhc-vc-container-label">'.$title.'</div></h4>';
		}
}

class WPBakeryShortCode_rhc_dbox_cell extends WPBakeryShortCodesContainer {
		protected function outputTitle( $title ) {
			$icon = $this->settings( 'icon' );
			if ( filter_var( $icon, FILTER_VALIDATE_URL ) ) {
				$icon = '';
			}
			$params = array(
				'icon' => $icon,
				'is_container' => $this->settings( 'is_container' )/*,
				'title' => $title,*/
			);

			return '<h4 class="wpb_element_title"> ' . $this->getIcon( $params ) . '<div class="rhc-vc-container-label">'.$title.'</div></h4>';
		}
}

class WPBakeryShortCode_rhc_tax_loop extends WPBakeryShortCodesContainer {
		protected function outputTitle( $title ) {
			$icon = $this->settings( 'icon' );
			if ( filter_var( $icon, FILTER_VALIDATE_URL ) ) {
				$icon = '';
			}
			$params = array(
				'icon' => $icon,
				'is_container' => $this->settings( 'is_container' )/*,
				'title' => $title,*/
			);

			return '<h4 class="wpb_element_title"> ' . $this->getIcon( $params ) . '<div class="rhc-vc-container-label">'.$title.'</div></h4>';
		}
}

class WPBakeryShortCode_rhc_venue_loop extends WPBakeryShortCodesContainer {
		protected function outputTitle( $title ) {
			$icon = $this->settings( 'icon' );
			if ( filter_var( $icon, FILTER_VALIDATE_URL ) ) {
				$icon = '';
			}
			$params = array(
				'icon' => $icon,
				'is_container' => $this->settings( 'is_container' )/*,
				'title' => $title,*/
			);

			return '<h4 class="wpb_element_title"> ' . $this->getIcon( $params ) . '<div class="rhc-vc-container-label">'.$title.'</div></h4>';
		}
}

class WPBakeryShortCode_rhc_organizer_loop extends WPBakeryShortCodesContainer {
		protected function outputTitle( $title ) {
			$icon = $this->settings( 'icon' );
			if ( filter_var( $icon, FILTER_VALIDATE_URL ) ) {
				$icon = '';
			}
			$params = array(
				'icon' => $icon,
				'is_container' => $this->settings( 'is_container' )/*,
				'title' => $title,*/
			);

			return '<h4 class="wpb_element_title"> ' . $this->getIcon( $params ) . '<div class="rhc-vc-container-label">'.$title.'</div></h4>';
		}
}

class WPBakeryShortCode_rhc_calendar_loop extends WPBakeryShortCodesContainer {
		protected function outputTitle( $title ) {
			$icon = $this->settings( 'icon' );
			if ( filter_var( $icon, FILTER_VALIDATE_URL ) ) {
				$icon = '';
			}
			$params = array(
				'icon' => $icon,
				'is_container' => $this->settings( 'is_container' )/*,
				'title' => $title,*/
			);

			return '<h4 class="wpb_element_title"> ' . $this->getIcon( $params ) . '<div class="rhc-vc-container-label">'.$title.'</div></h4>';
		}
}


class rhc_visual_composer {
	var $pop_input = false;
	function __construct($args=array()){
		//------------
		$defaults = array(
			'url'				=> ''
		);
		foreach($defaults as $property => $default){
			$this->$property = isset($args[$property])?$args[$property]:$default;
		}
		//-----------
		add_shortcode_param( 'pop_subtitle' , array( &$this, 'pop_subtitle' ) );
		add_shortcode_param( 'pop_option' , array( &$this, 'pop_option' ), $this->url.'js/vc.js' );
		
		//This one is the recommend method by vc:
		add_action( 'vc_before_init', array( &$this, 'vc_before_init' ) );
		/*
		//Note: this is getting called with every page load by vc. need to find a way 
		//to only call our vc_before_init when the vc editor is actually being used.
		add_action( 'vc_before_init_backend_editor', array( &$this, 'vc_before_init' ) );
		add_action( 'vc_before_init_frontend_editor', array( &$this, 'vc_before_init' ) );
		add_action( 'vc_backend_editor_render', array( &$this, 'vc_before_init' ) );
		add_action( 'vc_frontend_editor_render', array( &$this, 'vc_before_init' ) );
		*/

		//--
		add_action( 'wp_enqueue_scripts', array( &$this, 'wp_enqueue_scripts') );
		//add_action( 'admin_enqueue_scripts', array( &$this, 'wp_enqueue_scripts') );
		
		add_action( 'vc_backend_editor_enqueue_js_css', array( &$this, 'vc_backend_editor_enqueue_js_css' ) );
		add_action( 'vc_frontend_editor_enqueue_js_css', array( &$this, 'vc_frontend_editor_enqueue_js_css' ) );
		
		add_filter( 'pop_calendarizeit_options_for_vc_params', array( &$this, 'pop_calendarizeit_options_for_vc_params' ), 10, 1);

		//-- default templates
		add_action('vc_load_default_templates_action', array( &$this, 'vc_load_default_templates_action' ) );
	}

	function vc_load_default_templates_action(){
		include 'vc_default_templates.php';
		$vc_default_templates = apply_filters('rhc_vc_default_templates', $vc_default_templates );
		if( is_array( $vc_default_templates ) && count( $vc_default_templates ) > 0 ){
			foreach( $vc_default_templates as $data ){
				vc_add_default_templates( $data );
			}
		}
	}

	function wp_enqueue_scripts(){
		//wp_register_style( 'pop', 	$this->url.'options-panel/style.css', array(),'1.0.1.1');
		wp_register_script( 'pop', 	$this->url.'options-panel/js/pop.js', array(),'2.6.1.3');
	}
	
	function vc_frontend_editor_enqueue_js_css(){
		//wp_enqueue_style('pop');
		wp_enqueue_script('pop');
	}
	
	function vc_backend_editor_enqueue_js_css(){
		//wp_enqueue_style('pop');
		wp_enqueue_script('pop');
	}
					
	function vc_before_init(){
	
		//--handle unsupported subtitle element
		//add_shortcode_param( 'pop_subtitle' , array( &$this, 'pop_subtitle' ) );	
	
/*
echo "TODO: Unhandled options in VC";		
echo "<pre>";
print_r($unhandled_types);
echo "</Pre>";			
*/
//file_put_contents( ABSPATH.'vc.log', time()."\n".print_r($unhandled_types,true) );
//error_log( "LINE:".__LINE__."\n", 3, ABSPATH.'vc.log');	
/*
echo "<pre>";
print_r($params);
echo "</Pre>";	
*/		
		vc_add_shortcode_param( 'rhc_postmeta_dropdown', array( &$this, 'rhc_postmeta_dropdown' ) );

		$scripts = array(
			//$this->url.'options-panel/js/pop.js',
			$this->url.'options-panel/js/rangeinput.js'
		);
		
		$styles = array(
			$this->url.'options-panel/style.css',
			$this->url.'css/vc.css'
		);

//		$vc_category = __( "Calendarize It!", "rhc");
		//Note: This name cannot be localized, because it is used to generate a unique key
		//wich is the only way we currently have to style the tab body.
		$vc_category = "Calendarize It!";
		
		vc_map( array(
			"name" 		=> __( "Calendarize It!", "rhc" ),
			"base" 		=> "calendarizeit",
			"category" 	=> $vc_category,
			"description"		=> __("Add Calendar","rhc"),
			"params" => $this->get_vc_map_params_for_calendarizeit(),
			"admin_enqueue_js" => $scripts,
			"admin_enqueue_css" => $styles,
			"front_enqueue_js" => $scripts,
			"front_enqueue_css" => $styles
		)); // calendarizeit
		
		//--- Upcoming Events
		vc_map( array(
			"name" 				=> __( "Upcoming Events", "rhc" ),
			"base" 				=> "rhc_static_upcoming_events",
			"category" 			=> $vc_category,
			"description"		=> __("Add Upcoming Events List","rhc"),
			"params" 			=> $this->get_vc_map_params_for_supe(),
			"admin_enqueue_js" 	=> $scripts,
			"admin_enqueue_css" => $styles,
			"front_enqueue_js" 	=> $scripts,
			"front_enqueue_css" => $styles
		)); // rhc_static_upcoming_events
		
		//--- Venue detailbox
		vc_map( array(
			"name" 				=> __( "Venue Details Box", "rhc" ),
			"base" 				=> "venue_detailbox",
			"category" 			=> $vc_category,
			"description"		=> __("Add Venue Details Box","rhc"),
			"params" 			=> $this->get_vc_map_params_for_detailbox(),
			"admin_enqueue_js" 	=> $scripts,
			"admin_enqueue_css" => $styles,
			"front_enqueue_js" 	=> $scripts,
			"front_enqueue_css" => $styles
		)); // venue_detailbox
		
		//--- Event detailbox
		vc_map( array(
			"name" 				=> __( "Event Details Box", "rhc" ),
			"base" 				=> "event_detailbox",
			"category" 			=> $vc_category,
			"description"		=> __("Add Event Details Box","rhc"),
			"params" 			=> $this->get_vc_map_params_for_detailbox(),
			"admin_enqueue_js" 	=> $scripts,
			"admin_enqueue_css" => $styles,
			"front_enqueue_js" 	=> $scripts,
			"front_enqueue_css" => $styles
		)); //event_detailbox
		
		vc_map( array(
			"name" 				=> __( "Custom Details Box", "rhc" ),
			"base" 				=> "rhc_dbox",
			"category" 			=> $vc_category,
			"description"		=> __("Add a Custom Details Box","rhc"),
			"as_parent" 		=> array('except' => 'rhc_dbox'),
			"show_settings_on_create" => false,			
			"js_view"			=> "VcColumnView",
			"params" 			=> $this->get_vc_map_params_for_custom_detailbox(),
			"admin_enqueue_js" 	=> $scripts,
			"admin_enqueue_css" => $styles,
			"front_enqueue_js" 	=> $scripts,
			"front_enqueue_css" => $styles
		)); //Custom Detailbox
		
		//--- Conditional content -not rely rhc, but its there here already.
		vc_map( array(
			"name" 					=> __( "Conditional Content", "rhc" ),
			"base" 					=> "rhc_conditional_content",
			"category" 				=> $vc_category,
			"description"		=> __("Add Conditional Content","rhc"),
			"params" 				=> $this->get_vc_map_params_for_conditional_content(),
			//"is_container"			=> true,
			'holder'				=> 'div',
			"show_settings_on_create" => false,			
			"js_view"				=> "VcColumnView"
		));	//rhc_conditional_content
		

		$descriptions = array(
			'rhc_title' 		=> __("Add Event Title","rhc"),
			'rhc_description'	=> __("Add Event Excerpt","rhc"),
			'btn_ical_feed' 	=> __("Add iCal Button","rhc"),
			'rhc_label'			=> __("Add Cutom Label","rhc")
		);		
		
		foreach( array(
			'rhc_title' 		=> __('Event Title','rhc'),
			'rhc_description'	=> __('Event Excerpt','rhc'),
			'btn_ical_feed' 	=> __('iCal Button','rhc'),
			'rhc_label'			=> __('Custom Label','rhc')
		) as $base => $label ){
			vc_map( array(
				"name" 				=> $label,
				"base" 				=> $base,
				"category" 			=> $vc_category,
				"description"		=> $descriptions[$base],
				"show_settings_on_create" => ( in_array( $base, array('rhc_label') ) ? true : false ),
				"params" 			=> $this->get_vc_map_params_for_event( $base )
			));	
		}	

		vc_map( array(
			"name" 						=> __( "Template content", "rhc" ),
			"base" 						=> "CONTENT",
			"show_settings_on_create" 	=> false,
			"category" 					=> $vc_category,
			"description"				=> __("Add Template content","rhc")
		));	

		vc_map( array(
			"name" 				=> __( "Post Meta", "rhc" ),
			"base" 				=> "rhc_postmeta",
			"show_settings_on_create" => true,
			"category" 			=> $vc_category,
			"description"		=> __("Add Post Event Meta Data field","rhc"),
			"params" 			=> $this->get_vc_map_params_for_rhc_postmeta()
		));	

		// Event date
		vc_map( array(
			"name" 				=> __( "Start DateTime", "rhc" ),
			"base" 				=> "rhc_start",
			"class" 			=> "",
			"show_settings_on_create" => false,
			"category" 			=> $vc_category,
			"description"		=> __("Add Start Date and Time field","rhc"),
			"params" 			=> $this->get_vc_map_params_for_rhc_date(),
			"admin_enqueue_js" 	=> $scripts,
			"admin_enqueue_css" => $styles,
			"front_enqueue_js" 	=> $scripts,
			"front_enqueue_css" => $styles
		));		//Start datetime
		vc_map( array(
			"name" 				=> __( "Start Date", "rhc" ),
			"base" 				=> "rhc_start_date",
			"class" 			=> "",
			"show_settings_on_create" => false,
			"category" 			=> $vc_category,
			"description"		=> __("Add Start Date field","rhc"),
			"params" 			=> $this->get_vc_map_params_for_rhc_date(),
			"admin_enqueue_js" 	=> $scripts,
			"admin_enqueue_css" => $styles,
			"front_enqueue_js" 	=> $scripts,
			"front_enqueue_css" => $styles
		));		//Start date	
		vc_map( array(
			"name" 				=> __( "Start Time", "rhc" ),
			"base" 				=> "rhc_start_time",
			"class" 			=> "",
			"show_settings_on_create" => false,
			"category" 			=> $vc_category,
			"description"		=> __("Add Start Time field","rhc"),
			"params" 			=> $this->get_vc_map_params_for_rhc_date(),
			"admin_enqueue_js" 	=> $scripts,
			"admin_enqueue_css" => $styles,
			"front_enqueue_js" 	=> $scripts,
			"front_enqueue_css" => $styles
		));		//Start time
		vc_map( array(
			"name" 				=> __( "End DateTime", "rhc" ),
			"base" 				=> "rhc_end",
			"class" 			=> "",
			"show_settings_on_create" => false,
			"category" 			=> $vc_category,
			"description"		=> __("Add End Date and Time field","rhc"),
			"params" 			=> $this->get_vc_map_params_for_rhc_date(),
			//"custom_markup" 	=> __( "End datetime", "rhc" ),
			"admin_enqueue_js" 	=> $scripts,
			"admin_enqueue_css" => $styles,
			"front_enqueue_js" 	=> $scripts,
			"front_enqueue_css" => $styles
		));		//End datetime
		vc_map( array(
			"name" 				=> __( "End Date", "rhc" ),
			"base" 				=> "rhc_end_date",
			"class" 			=> "",
			"show_settings_on_create" => false,
			"category" 			=> $vc_category,
			"description"		=> __("Add End Date field","rhc"),
			"params" 			=> $this->get_vc_map_params_for_rhc_date(),
			//"custom_markup" 	=> __( "End date", "rhc" ),
			"admin_enqueue_js" 	=> $scripts,
			"admin_enqueue_css" => $styles,
			"front_enqueue_js" 	=> $scripts,
			"front_enqueue_css" => $styles
		));		//End date
		vc_map( array(
			"name" 				=> __( "End Time", "rhc" ),
			"base" 				=> "rhc_end_time",
			"class" 			=> "",
			"show_settings_on_create" => false,
			"category" 			=> $vc_category,
			"description"		=> __("Add End Time field","rhc"),
			"params" 			=> $this->get_vc_map_params_for_rhc_date(),
			//"custom_markup" 	=> __( "End time", "rhc" ),
			"admin_enqueue_js" 	=> $scripts,
			"admin_enqueue_css" => $styles,
			"front_enqueue_js" 	=> $scripts,
			"front_enqueue_css" => $styles
		));		//End time
		vc_map( array(
			"name" 				=> __( "Venue Map", "rhc" ),
			"base" 				=> "rhc_gmap",
			"category" 			=> $vc_category,
			"description"		=> __("Add a Venue Map","rhc"),
			"params" 			=> $this->get_vc_map_params_for_rhc_gmap(),
			"admin_enqueue_js" 	=> $scripts,
			"admin_enqueue_css" => $styles,
			"front_enqueue_js" 	=> $scripts,
			"front_enqueue_css" => $styles
		));		//Map(Multiple venues)
		
		//--- RHC Images
		//rhc_image [featuredimage meta_key='enable_featuredimage' meta_value='1' default='1' custom='rhc_top_image']		
		vc_map( array(
			"name" 				=> __( "Event Image", "rhc" ),
			"base" 				=> "rhc_image",
			"class" 			=> "",
			"category" 			=> $vc_category,
			"description"		=> __("Add an Event Image","rhc"),
			"params" 			=> $this->get_vc_map_params_for_rhc_image(),
			//"custom_markup" 	=> __( "RHC Image", "rhc" ),
			"admin_enqueue_js" 	=> $scripts,
			"admin_enqueue_css" => $styles,
			"front_enqueue_js" 	=> $scripts,
			"front_enqueue_css" => $styles
		));	//rhc_image
		
		foreach( array(
			'rhc_venue_loop' 	=> __( "Venue Loop", "rhc" ),
			'rhc_organizer_loop'=> __( "Organizer Loop", "rhc" ),
			'rhc_calendar_loop'=> __( "Calendar Loop", "rhc" ),
			'rhc_tax_loop' 		=> __( "Taxonomy Loop", "rhc" )
		) as $base => $name ){
			vc_map( array(
				"name" 					=> $name,
				"base" 					=> $base,
				"category" 				=> $vc_category,
				"description"			=> __("Add Loop Shortcode","rhc"),				
				"as_parent" 			=> array('except' => array('rhc_venue_loop','rhc_organizer_loop','rhc_tax_loop') ),		
				"show_settings_on_create" => ( $base=='rhc_tax_loop' ? true : false ) ,		
				"js_view"			=> "VcColumnView",
				"params" 			=> $this->get_vc_map_params_for_tax_loop( $base ),
				"admin_enqueue_js" 	=> $scripts,
				"admin_enqueue_css" => $styles,
				"front_enqueue_js" 	=> $scripts,
				"front_enqueue_css" => $styles
			));	
		}	
		
		foreach( array(
			'rhc_term' 				=> __('Term Name','rhc'),
			'rhc_venue_term' 		=> __('Venue Name','rhc'),
			'rhc_organizer_term' 	=> __('Organizer Name','rhc'),
			'rhc_calendar_term' 	=> __('Calendar Name','rhc')
		) as $base => $name ){
			vc_map( array(
				"name" 				=> $name,
				"base" 				=> $base,
				"category" 			=> $vc_category,
				"description"			=> __("The Term Name","rhc"),		
				"show_settings_on_create" => false,
				"params" 			=> $this->get_vc_map_params_for_rhc_term( $base ),
				"admin_enqueue_js" 	=> $scripts,
				"admin_enqueue_css" => $styles,
				"front_enqueue_js" 	=> $scripts,
				"front_enqueue_css" => $styles
			));	
		}
/* will not use in vc.			
		vc_map( array(
			"name" 				=> __('Venue meta','rhc'),
			"base" 				=> 'rhc_venue_meta',
			"class" 			=> "",
			"category" 			=> $vc_category,
			"params" 			=> $this->get_vc_map_params_for_venue_meta( ),
			"admin_enqueue_js" 	=> $scripts,
			"admin_enqueue_css" => $styles,
			"front_enqueue_js" 	=> $scripts,
			"front_enqueue_css" => $styles
		));	//Venue meta
			
		vc_map( array(
			"name" 				=> __('Organizer meta','rhc'),
			"base" 				=> 'rhc_organizer_meta',
			"class" 			=> "",
			"category" 			=> $vc_category,
			"params" 			=> $this->get_vc_map_params_for_organizer_meta(),
			"admin_enqueue_js" 	=> $scripts,
			"admin_enqueue_css" => $styles,
			"front_enqueue_js" 	=> $scripts,
			"front_enqueue_css" => $styles
		));	//Organizer meta
*/			
		vc_map( array(
			"name" 				=> __('Venue Meta','rhc'),
			"base" 				=> 'rhc_venue_meta_info_cell',
			"category" 			=> $vc_category,
			"description"				=> __("Add Venue Meta field","rhc"),				
			"show_settings_on_create" => true,
			"params" 			=> $this->get_vc_map_params_for_venue_meta_cell(),
			"admin_enqueue_js" 	=> $scripts,
			"admin_enqueue_css" => $styles,
			"front_enqueue_js" 	=> $scripts,
			"front_enqueue_css" => $styles
		));	//Venue meta cell
			
		vc_map( array(
			"name" 				=> __('Organizer Meta','rhc'),
			"base" 				=> 'rhc_organizer_meta_info_cell',
			"category" 			=> $vc_category,
			"description"				=> __("Add Organizer Meta field","rhc"),	
			"show_settings_on_create" => true,
			"params" 			=> $this->get_vc_map_params_for_organizer_meta_cell(),
			"admin_enqueue_js" 	=> $scripts,
			"admin_enqueue_css" => $styles,
			"front_enqueue_js" 	=> $scripts,
			"front_enqueue_css" => $styles
		));	//Organizer meta cell
			
		vc_map( array(
			"name" 				=> __('Venue Image','rhc'),
			"base" 				=> 'rhc_venue_image',
			"class" 			=> "",
			"category" 			=> $vc_category,
			"description"				=> __("Add a Venue Image","rhc"),	
			"show_settings_on_create" => false,
			"params" 			=> $this->get_vc_map_params_for_venue_image(),
			"admin_enqueue_js" 	=> $scripts,
			"admin_enqueue_css" => $styles,
			"front_enqueue_js" 	=> $scripts,
			"front_enqueue_css" => $styles
		));	//Venue image	rhc_venue_image
			
		vc_map( array(
			"name" 				=> __('Venue Website','rhc'),
			"base" 				=> 'rhc_venue_website',
			"class" 			=> "",
			"category" 			=> $vc_category,
			"description"				=> __("Add Venue Website field","rhc"),	
			"show_settings_on_create" => false,
			"params" 			=> $this->get_vc_map_params_for_venue_website(),
			"admin_enqueue_js" 	=> $scripts,
			"admin_enqueue_css" => $styles,
			"front_enqueue_js" 	=> $scripts,
			"front_enqueue_css" => $styles
		));	//Venue website	rhc_venue_website			
				
		vc_map( array(
			"name" 				=> __('Organizer Image','rhc'),
			"base" 				=> 'rhc_organizer_image',
			"class" 			=> "",
			"category" 			=> $vc_category,
			"description"				=> __("Add a Organizer Image","rhc"),	
			"show_settings_on_create" => false,
			"params" 			=> $this->get_vc_map_params_for_venue_image(),
			"admin_enqueue_js" 	=> $scripts,
			"admin_enqueue_css" => $styles,
			"front_enqueue_js" 	=> $scripts,
			"front_enqueue_css" => $styles
		));	//Organizer image 
		
		vc_map( array(
			"name" 				=> __('Organizer Website','rhc'),
			"base" 				=> 'rhc_organizer_website',
			"category" 			=> $vc_category,
			"description"				=> __("Add a Organizer Website field","rhc"),	
			"show_settings_on_create" => false,
			"params" 			=> $this->get_vc_map_params_for_venue_website(),
			"admin_enqueue_js" 	=> $scripts,
			"admin_enqueue_css" => $styles,
			"front_enqueue_js" 	=> $scripts,
			"front_enqueue_css" => $styles
		));	//Organizer website	rhc_organizer_website		
		
	}
	
	function rhc_postmeta_dropdown( $settings, $value ) {
		//custom vc param
		global $wpdb;		
		$post_id = isset( $_REQUEST['post_id'] ) ? $_REQUEST['post_id'] : '' ;
		
		if( $post_id > 0 ){
			$out = '<div class="rhc_postmeta_dropdown_cont">';   
			$out.= '<select name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-input wpb-select ' .
					 esc_attr( $settings['param_name'] ) . ' ' .
					 esc_attr( $settings['type'] ) . '_field" type="text" value="' . esc_attr( $value ) . '">' 
			;
		
			foreach( $this->get_meta_fields($post_id) as $field => $label ){
				$out.=sprintf('<option %3$s value="%2$s">%1$s</option>',
					$label,
					$field,
					( $value==$field ? 'selected="selected"' : '' )
				);
				$out.="\n";
			}
				  
		
			$out.= '</select>';
		
			$out.= '</div>';
				 
			return $out;		
		}else{
			return '';
		}
	}

	function get_meta_fields($post_id){
		global $wpdb;
		$options = array();
		include RHC_PATH.'includes/meta_fields_default_labels.php';
		
		$always_keys = array_keys($default_meta_field_labels);

		$meta_keys = $wpdb->get_col("SELECT DISTINCT(meta_key) FROM `{$wpdb->postmeta}` WHERE post_id={$post_id} AND meta_key NOT LIKE '\_%'",0);
		$meta_keys = is_array( $meta_keys ) ? $meta_keys : array() ;
		
		$b = array_merge( $always_keys, $meta_keys );
		$b = array_unique( $b );

		$meta_keys = $b;

		if(is_array($meta_keys) && count($meta_keys)>0){
			$meta_keys[]='rhc_post_title';
			
			foreach($meta_keys as $field){
				if(in_array($field, apply_filters('postinfo_postmeta_exclude',array('extra_info_columns','extra_info_separators','extra_info_data'))))continue;
				$value = get_post_meta($post_id,$field,true);
				$label = isset($default_meta_field_labels[$field])?$default_meta_field_labels[$field]:$field;
				if(is_string($value)){
//					$options[$field]=sprintf('%s(%s)',$label,substr($value,0,10));
					if(in_array($field,$default_skip_meta_fields))continue;
					$options[$field]=$label;
				}
			}
		}
		
		if(count($options) <= 1){// it always has at least 1 since we added rhc_excerpt.
			require_once RHC_PATH.'includes/meta_fields_default_labels.php';
			foreach(array('fc_start','fc_start_time','fc_end','fc_end_time','fc_start_datetime','fc_end_datetime','rhc_excerpt','rhc_post_title') as $field){
				$label = isset($default_meta_field_labels[$field])?$default_meta_field_labels[$field]:$field;
				$options[$field]=$label;
			}
		}

		if( defined('RHCCE_PATH') ){
			//apply CE custom labels
			$ce_custom_meta_fields = $this->get_ce_custom_meta_fields();
			foreach( $options as $value => $label ){
				foreach( $ce_custom_meta_fields as $ce ){
					if( $value == $ce->meta_key ){
						$options[$value] = $ce->label;
					}
				}
			}
		}
		
		$options = apply_filters('postinfo_postmeta_include', $options);
		
		return $options;
	}

	function get_ce_custom_meta_fields(){
		global $rhc_plugin;
		$meta_fields = array();
		$max_custom_fields = intval( $rhc_plugin->get_option('max_custom_fields',3,true) );
		$max_custom_fields = $max_custom_fields<=0?3:$max_custom_fields;
		for($a=0;$a<$max_custom_fields;$a++){
			$option_meta_key = 'custom_field_'.$a;
			$tmp = (object)array(
				'label'		=> '',
				'meta_key'	=> $rhc_plugin->get_option($option_meta_key,'',true)
			);
			
			if(!empty($tmp->meta_key)){
				$this->metabox_meta_fields[] = $tmp->meta_key;
				
				$option_label = 'custom_label_'.$a;
				$tmp->label = $rhc_plugin->get_option($option_label,'',true);
				$meta_fields[]=$tmp;
			}
		}
		return $meta_fields;
	}	
	
	function set_pop_conditional_options( &$t, $i ){
		$t[$i]->options[]=(object)array(
				'id'			=> 'vc_tab_condition',
				'type' 			=> 'vc_tab', 
				'label'			=> __('Conditions','rhc'),
				'vc_tab'		=> true //flat the start of a tab in vc.
			);		
	
		$t[$i]->options[]=(object)array(
				'id'	=> 'cal_capability',
				'type'	=> 'text',
				'label' => __('Permission (capability)','rhc'),
				'description' => __( 'If used, the shortcode will only display if the user is logged in and have the specific capability.', 'rhc')
			);	
		$conditional_tags = apply_filters( 'postinfo_allowed_conditional_tags', array( 
				'is_home',
				'is_front_page',
				'is_singular',
				'is_page',
				'is_single',
				'is_sticky',
				'is_category',
				'is_tax',
				'is_author',
				'is_archive',
				'is_search',
				'is_attachment',
				'is_tag',
				'is_date',
				'is_paged',
				'is_main_query',
				'is_feed',
				'is_trackback',
				'in_the_loop',
				'is_user_logged_in'
				));
		$j = 0;	
		foreach($conditional_tags as $is_condition){				
			$tmp=(object)array(
				'id'			=> 'cal_conditional_tag_'.$is_condition,
				'name'			=> 'cal_conditional_tag[]',
				'type'			=> 'checkbox',
				'option_value'	=>$is_condition,
				'default'		=> '',
				'label'			=> $is_condition,
				'vc_label' 		=> __('Conditional Render','rhc')
			);
			if($j==0){
				$tmp->description = __("Check the conditions to test for displaying the shortcode.  Leave empty to display everywhere, included feeds and trackbacks.",'rhc');
			}
			$t[$i]->options[]=$tmp;
			$j++;	
		}					
	}
	
	function get_vc_map_params_for_event( $base ){
		$t = array();
		$i = 0;		
		$t[$i] = (object)array('options' => array());
		
		if( in_array( $base, array('rhc_label') ) ){
			$t[$i]->options[]=(object)array(
					'id'			=> 'cal_label',
					'type' 			=> 'text', 
					'label'			=> __('Label','rhc'),
					'vc_admin_label'=> true
				);
		}
		$this->set_pop_conditional_options( $t, $i );	
				
		return $this->convert_rhc_options_to_vc_params( $t );	
	}
	
	function get_vc_map_params_for_rhc_gmap( ){
		$t = array();
		$i = 0;	
		$t[$i] = (object)array('options' => array());	
		
		$t[$i]->options[]=(object)array(
				'id'			=> 'vc_tab_general',
				'type' 			=> 'vc_tab', 
				'label'			=> __('General','rhc'),
				'vc_tab'		=> true //flat the start of a tab in vc.
			);
				
		$t[$i]->options[]=(object)array(
				'id'	=> 'cal_post_id',
				'type'	=> 'text',
				'label' => __('Post ID','rhc'),
				'description' => __( 'You only need to set the post id if you want to bring the map of a diferent event.', 'rhc')
			);	
			
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_single_marker',
				'type' 			=> 'select',
				'label'			=> __('Multiple markers','rhc'),
				'options'		=> array(
					'' 	=> sprintf('----%s----',__('auto','rhc')),
					'0' => __('Multiple markers','rhc'),
					'1' => __('Single marker','rhc')
				),
				'description' 	=> __('Leave automatic an it will render all venues associated to an event if it is outside a venue loop; if inside, it will only render the venue on that iteration.  Or choose an option to force a behavior.','rhc')
			);	
			
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_type',
				'type' 			=> 'select',
				'label'			=> __('Type','rhc'),
				'vc_admin_label'=> true,
				'options'		=> array(
					'interactive' 	=> __('Interactive','rhc'),
					'static' 		=> __('Static','rhc')
				)
			);	
		
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_maptype',
				'type' 			=> 'select',
				'label'			=> __('Maptype','rhc'),
				'vc_admin_label'=> true,
				'options'		=> array(
					'ROADMAP' 	=> 'ROADMAP',
					'SATELLITE' => 'SATELLITE',
					'HYBRID' 	=> 'HYBRID',
					'TERRAIN' 	=> 'TERRAIN'
				)
			);	
		
		$t[$i]->options[] =	(object)array(
				'id'			=> 'cal_ratio',
				'type' 			=> 'text',
				'label'			=> __('Ratio','rhc'),
				'el_properties' => array(
					'placeholder' => '4:3'
				),
				'description'	=> __('Only set this to change the proportion of the rendered map.  Default to 4:3')
			);
			
		$t[$i]->options[]=(object)array(
				'id'	=> 'cal_zoom',
				'type'	=> 'range',
				'label' => '',
				'vc_label'	=> __('Zoom','rhc'),
				'min'	=> 0,
				'max'	=> 19,
				'step'	=> 1,
				'vc_default'=> 15,
				'description' => __( 'In interactive mode, zoom level will adjust if more than one venue is added.', 'rhc')
			);	
			
		$this->set_pop_conditional_options( $t, $i );		
	
		return $this->convert_rhc_options_to_vc_params( $t );				
	}
	
	function get_vc_map_params_for_single_venue_gmap(){
		$t = array();
		$i = 0;	
		$t[$i] = (object)array('options' => array());	
		
		$t[$i]->options[]=(object)array(
				'id'			=> 'vc_tab_general',
				'type' 			=> 'vc_tab', 
				'label'			=> __('General','rhc'),
				'vc_tab'		=> true //flat the start of a tab in vc.
			);
				
		$t[$i]->options[]=(object)array(
				'id'		=> 'cal_width',
				'type'		=> 'range',
				'label' 	=> '',
				'vc_label'	=> __('Width','rhc'),
				'min'		=> 0,
				'max'		=> 1024,
				'step'		=> 1,
				'vc_default'=> 500
			);	
				
		$t[$i]->options[]=(object)array(
				'id'		=> 'cal_height',
				'type'		=> 'range',
				'label' 	=> '',
				'vc_label'	=> __('Height','rhc'),
				'min'		=> 0,
				'max'		=> 1024,
				'step'		=> 1,
				'vc_default'=> 300
			);		
			
		$this->set_pop_conditional_options( $t, $i );		
	
		return $this->convert_rhc_options_to_vc_params( $t );				
	}
	
	function get_vc_map_params_for_rhc_date(){
		$t = array();
		$i = 0;	
		
		$t[$i]->options[]=(object)array(
				'id'			=> 'vc_tab_general',
				'type' 			=> 'vc_tab', 
				'label'			=> __('General','rhc'),
				'vc_tab'		=> true //flat the start of a tab in vc.
			);	
			
		$t[$i]->options[]=(object)array(
				'id'	=> 'cal_post_id',
				'type'	=> 'text',
				'label' => __('Post ID','rhc'),
				'description' => __( 'You only need to set the post id if you want to bring the date of a diferent event.', 'rhc')
			);	
			
		$t[$i]->options[]=(object)array(
				'id'	=> 'cal_label',
				'type'	=> 'text',
				'label' => __('Label','rhc')
			);		

		$t[$i]->options[] =	(object)array(
				'id'			=> 'cal_rhc_sc_date_format',
				'type' 			=> 'text',
				'label'			=> __('Date format','rhc'),
				'el_properties' => array(
					'class'=>'widefat rhc_dateformat',
					'rel'=>__('MMMM d, yyyy','rhc')
				)
			);
			
		$t[$i]->options[] =	(object)array(
				'id'			=> 'cal_rhc_sc_time_format',
				'type' 			=> 'text',
				'label'			=> __('Time format','rhc'),
				'el_properties' => array(
					'class'=>'widefat rhc_dateformat',
					'rel'=>__('h:mm tt','rhc')
				)
			);
			
		$this->set_pop_conditional_options( $t, $i );		
	
		return $this->convert_rhc_options_to_vc_params( $t );					
	}

	function get_vc_map_params_for_rhc_image(){
		$t = array();
		$i = 0;	
		
		$t[$i]->options[]=(object)array(
				'id'			=> 'vc_tab_content',
				'type' 			=> 'vc_tab', 
				'label'			=> __('Content','rhc'),
				'vc_tab'		=> true //flat the start of a tab in vc.
			);	

		//--harcode label mapping
		add_filter( 'rhc_image_label', 'filter_label_mapping', 10, 1 );

		function filter_label_mapping( $image ) {
			$map = array(
				'rhc_top_image' 	=> __('Event Page Top Image','rhc'),
				'rhc_dbox_image'	=> __('Event Detail Box Image','rhc'),
				'rhc_tooltip_image' =>  __('Event Featured Image','rhc'),
				'rhc_month_image'	=> __('Month view image','rhc')
			);
			return isset( $map[$image] ) ? $map[$image] : $image ;
		}

		$options = array();
		$images = apply_filters( 'rhc_images', array('rhc_top_image','rhc_dbox_image','rhc_tooltip_image','rhc_month_image') );
		foreach( $images as $image ){
			$options[$image] = apply_filters( 'rhc_image_label', $image );
		}		
		
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_custom',
				'type' 			=> 'select',
				'label'			=> __('Image Source','rhc'),
				'vc_admin_label'	=> true,
				'options'		=> $options
			);			
			
		$this->set_pop_conditional_options( $t, $i );		
	
		return $this->convert_rhc_options_to_vc_params( $t );
	}
	
	function get_vc_map_params_for_conditional_content(){
		$t = array();
		$i = 0;	
		/*
		$t[$i]->options[]=(object)array(
				'id'			=> 'vc_tab_content',
				'type' 			=> 'vc_tab', 
				'label'			=> __('Content','rhc'),
				'vc_tab'		=> true //flat the start of a tab in vc.
			);	

		$t[$i]->options[]=(object)array(
				'id'	=> 'shortcode_content',
				'type'	=> 'shortcode_content',
				'label' => __('Conditional content','rhc'),
				'description' => __( 'Content to display if conditions are met.', 'rhc')
			);			
		*/	
		$this->set_pop_conditional_options( $t, $i );		
	
		return $this->convert_rhc_options_to_vc_params( $t );									
	}

	function get_vc_map_params_for_custom_detailbox(){
		$t = array();
		$i = 0;
		
		$t[$i]->options[]=(object)array(
				'id'			=> 'vc_tab_general',
				'type' 			=> 'vc_tab', 
				'label'			=> __('General','rhc'),
				'vc_tab'		=> true //flat the start of a tab in vc.
			);	

		$t[$i]->options[]=(object)array(
				'id'		=> 'cal_width',
				'type'		=> 'range',
				'label' 	=> '',
				'vc_label'	=> __('Width','rhc'),
				'min'		=> 0,
				'max'		=> 1024,
				'step'		=> 1,
				'vc_default'=> 0,
				'description' => __( 'Leave 0 for automatic width.', 'rhc')
			);	
		
		$this->set_pop_conditional_options( $t, $i );			
		return $this->convert_rhc_options_to_vc_params( $t );		
	}

	function get_vc_map_params_for_detailbox(){
		$t = array();
		$i = 0;
		
		$t[$i] = (object)array('options' => array());
		
		$t[$i]->options[]=(object)array(
				'id'			=> 'vc_tab_general',
				'type' 			=> 'vc_tab', 
				'label'			=> __('General','rhc'),
				'vc_tab'		=> true //flat the start of a tab in vc.
			);	

		$t[$i]->options[]=(object)array(
				'id'	=> 'cal_post_id',
				'type'	=> 'text',
				'label' => __('Post ID','rhc'),
				'description' => __( 'Only set the post ID if you want to bring the detail box of another event.  Leave empty to catch the currently loaded post detail box.', 'rhc')
			);	

		$t[$i]->options[]=(object)array(
				'id'		=> 'cal_width',
				'type'		=> 'range',
				'label' 	=> '',
				'vc_label'	=> __('Width','rhc'),
				'min'		=> 0,
				'max'		=> 1024,
				'step'		=> 1,
				'vc_default'=> 0,
				'description' => __( 'Leave 0 for automatic width.', 'rhc')
			);	
		
		$this->set_pop_conditional_options( $t, $i );	
				
		return $this->convert_rhc_options_to_vc_params( $t );		
	}
	
	function get_vc_map_params_for_rhc_dbox_cell(){
		$t = array();
		$i = 0;
		
		$t[$i] = (object)array('options' => array());
		
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_label',
				'type' 			=> 'text', 
				'label'			=> __('Label','rhc'),
				'vc_admin_label'=> true
			);
				
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_content',
				'type' 			=> 'textarea', 
				'label'			=> __('Content','rhc'),
				'description'	=> __('You can use this field for custom content.  Or leave empty and drag existing elements here.','rhc')
			);	
			
		$this->set_pop_conditional_options( $t, $i );			
		return $this->convert_rhc_options_to_vc_params( $t );		
	}
	
	function get_vc_map_params_for_tax_loop( $code ){
		$t = array();
		$i = 0;
		
		$t[$i] = (object)array('options' => array());
		
		if( in_array( $code, array('rhc_tax_loop','rhc_term') ) ){
			$t[$i]->options[]=(object)array(
					'id'			=> 'vc_tab_general',
					'type' 			=> 'vc_tab', 
					'label'			=> __('General','rhc'),
					'vc_tab'		=> true //flat the start of a tab in vc.
				);	
			$this->set_taxonomy_option( $t, $i, __('Taxonomy loop','rhc'), false );
		}
		
		$this->set_pop_conditional_options( $t, $i );			
		return $this->convert_rhc_options_to_vc_params( $t );		
	}	
	
	function get_vc_map_params_for_rhc_term( $code ){
		$t = array();
		$i = 0;
		
		$t[$i] = (object)array('options' => array());

		$t[$i]->options[]=(object)array(
				'id'			=> 'vc_tab_general',
				'type' 			=> 'vc_tab', 
				'label'			=> __('General','rhc'),
				'vc_tab'		=> true //flat the start of a tab in vc.
			);	

		$tmp=(object)array(
				'id'			=> 'cal_label',
				'type' 			=> 'text', 
				'label'			=> __('Label','rhc'),
				'vc_admin_label'=> true,
				'description'	=> __('Only applicable inside a detail box.','rhc')
			);
		switch( $code ){
			case 'rhc_venue_term':
				$tmp->default = __('Venue','rhc');
				$tmp->vc_default = __('Venue','rhc');
				break;
			case 'rhc_organizer_term':
				$tmp->default = __('Organizer','rhc');
				$tmp->vc_default = __('Organizer','rhc');
				break;
			case 'rhc_calendar_term':
				$tmp->default = __('Calendar','rhc');
				$tmp->vc_default = __('Calendar','rhc');
				break;
		}
		$t[$i]->options[]=$tmp;
		
		if( in_array( $code, array('rhc_tax_loop','rhc_term') ) ){

				
				
				
			$this->set_taxonomy_option( $t, $i, __('Taxonomy','rhc'), true );
			
			$t[$i]->options[]=(object)array(
					'id'		=> 'cal_enable_link',
					'label'		=> __('Enable term link','rhc'),
					'type'		=> 'onoff',
					'vc_default'	=> '1'
				);				
		}
		
		$this->set_pop_conditional_options( $t, $i );			
		return $this->convert_rhc_options_to_vc_params( $t );	
	}
	
	function get_vc_map_params_for_rhc_postmeta(){
		$t = array();
		$i = 0;
		
		$t[$i] = (object)array('options' => array());	

		$t[$i]->options[]=(object)array(
				'id'		=> 'cal_label',
				'label'		=> __('Label','rhc'),
				'type'		=> 'text',
				'vc_admin_label'=> true,
			);	
		/*	
		$t[$i]->options[]=(object)array(
				'id'		=> 'cal_postmeta_fields',
				'label'		=> __('Post Meta Field','rhc'),
				'type'		=> 'text'
			);	
		*/				
		$t[$i]->options[]=(object)array(
				'id'		=> 'cal_postmeta_fields',
				'label'		=> __('Post Meta Field','rhc'),
				'type'		=> 'rhc_postmeta_dropdown'
			);	
		
		$this->set_pop_conditional_options( $t, $i );	
		
		return $this->convert_rhc_options_to_vc_params( $t );
	}
	
	function get_vc_map_params_for_venue_meta(){
		$t = array();
		$i = 0;
		
		$t[$i] = (object)array('options' => array());
			
		$this->set_rhc_venue_meta_general_options( $t, $i );	
		$this->set_rhc_venue_meta_advanced_options( $t, $i );
		$this->set_pop_conditional_options( $t, $i );			
		return $this->convert_rhc_options_to_vc_params( $t );
	}
	
	function get_vc_map_params_for_organizer_meta(){
		$t = array();
		$i = 0;
		
		$t[$i] = (object)array('options' => array());
			
		$this->set_rhc_organizer_meta_general_options( $t, $i );	

		$this->set_rhc_organizer_meta_advanced_options( $t, $i );
		$this->set_pop_conditional_options( $t, $i );			
		return $this->convert_rhc_options_to_vc_params( $t );
	}
	
	function get_vc_map_params_for_venue_image(){
		$t = array();
		$i = 0;
		
		$t[$i] = (object)array('options' => array());

		$t[$i]->options[]=(object)array(
				'id'			=> 'vc_tab_general',
				'type' 			=> 'vc_tab', 
				'label'			=> __('General','rhc'),
				'vc_tab'		=> true //flat the start of a tab in vc.
			);	
		
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_class',
				'type' 			=> 'text',
				'label'			=> __('Class','rhc'),
				'vc_admin_label'=> false,
				'description' => __('Optional alternative class.', 'rhc')
			);	

		$this->set_pop_conditional_options( $t, $i );			
		return $this->convert_rhc_options_to_vc_params( $t );		
	}
	
	function get_vc_map_params_for_venue_website(){
		$t = array();
		$i = 0;
		
		$t[$i] = (object)array('options' => array());

		$t[$i]->options[]=(object)array(
				'id'			=> 'vc_tab_general',
				'type' 			=> 'vc_tab', 
				'label'			=> __('General','rhc'),
				'vc_tab'		=> true //flat the start of a tab in vc.
			);	
			
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_label',
				'type' 			=> 'text', 
				'label'			=> __('Label','rhc'),
				'vc_admin_label'=> true,
				'default'	=> __('Website','rhc')
			);	
			
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_link_target',
				'type' 			=> 'select',
				'label'			=> __('Link target','rhc'),
				'vc_admin_label'=> false,
				'options'		=> array(
					'_blank'	=> __('_blank','rhc'),
					'_self'		=> __('_self','rhc')
				),
				'vc_default'	=> '_blank'
			);	
		
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_raw',
				'name'			=> 'raw',
				'type' 			=> 'checkbox',
				'label'			=> __('No link','rhc'),
				'vc_label'		=> __('No link','rhc'),
				'vc_admin_label'=> false,
				'option_value'	=> '1',
				'description'	=> __('Check to just show the url, no link wrap.','rhc')
			);	

		$this->set_pop_conditional_options( $t, $i );			
		return $this->convert_rhc_options_to_vc_params( $t );		
	}	
	
	function get_vc_map_params_for_venue_meta_cell(){
		$t = array();
		$i = 0;
		
		$t[$i] = (object)array('options' => array());
		
		$this->set_rhc_venue_meta_general_options( $t, $i, true );
			
		$this->set_pop_conditional_options( $t, $i );			
		return $this->convert_rhc_options_to_vc_params( $t );
	}
	
	function get_vc_map_params_for_organizer_meta_cell(){
		$t = array();
		$i = 0;
		
		$t[$i] = (object)array('options' => array());
		
		$this->set_rhc_organizer_meta_general_options( $t, $i, true );
			
		$this->set_pop_conditional_options( $t, $i );			
		return $this->convert_rhc_options_to_vc_params( $t );
	}
//shortcode calendarize-it
	function set_taxonomy_option( &$t, $i, $taxonomy_label='', $taxonomy_vc_admin_label=false ){
		global $rhc_plugin;
		
		$post_types = $rhc_plugin->get_option('post_types',array());
		$post_types = is_array($post_types) ? $post_types:array();
		array_unshift( $post_types, RHC_EVENTS );
		$post_types = apply_filters('rhc_calendar_metabox_post_types',$post_types);

		$default_taxonomies = array(
			''				=> __('--none--','rhc'),
			RHC_CALENDAR 	=> __('Calendar','rhc'),
			RHC_ORGANIZER	=> __('Organizer','rhc'),
			RHC_VENUE		=> __('Venues','rhc')
		);
	
		$taxonomies = apply_filters('rhc-taxonomies',$default_taxonomies);

		foreach( $post_types as $post_type ){
			$tmp = get_object_taxonomies(array('post_type'=>$post_type),'objects');
			if( is_array($tmp) && count($tmp) > 0 ){
				foreach( $tmp as $taxonomy => $tax ){
					$taxonomies[$taxonomy] = $tax->labels->name;
				}
			}
		}	

		$t[$i]->options[] = (object)array(
				'id'			=> 'cal_taxonomy',
				'type' 			=> 'select',
				'label'			=> (empty( $taxonomy_label ) ? __('Taxonomy','rhc') : $taxonomy_label),
				'options'		=> $taxonomies,
				'description'	=> __('Choose a taxonomy and terms to filter events.', 'rhc'),
				'vc_admin_label'=> true
			);	
	}
	
	function set_rhc_organizer_meta_general_options( &$t, $i, $include_label=false ){
		$t[$i]->options[]=(object)array(
				'id'			=> 'vc_tab_general',
				'type' 			=> 'vc_tab', 
				'label'			=> __('General','rhc'),
				'vc_tab'		=> true //flat the start of a tab in vc.
			);	
		if( $include_label ):	
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_label',
				'type' 			=> 'text', 
				'label'			=> __('Label','rhc'),
				'vc_admin_label'=> true
			);				
		endif;	
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_field',
				'type' 			=> 'select',
				'label'			=> __('Fields','rhc'),
				'vc_admin_label'=> true,
				'options'		=> array(
					''			=> __('--choose--','rhc'),
					'phone' 	=> __('Phone','rhc'),
					'email' 	=> __('Email','rhc'),
					'website' 	=> __('Website url','rhc'),
					'websitelabel' 	=> __('Website label','rhc'),
					'image'		 	=> __('Image','rhc'),
					'content' 		=> __('HTML Description','rhc')
				),
				'description' => __('Observe that if you use the advanced option, this field is ignored.', 'rhc')
			);	
		if( $include_label ):	
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_raw',
				'type' 			=> 'yesno', 
				'label'			=> __('Raw output','rhc'),
				'description'	=> __('Check this option to output without detail box html wrappers.  Ignores the label field.','rhc')
			);
		endif;				
	}
	
	function set_rhc_organizer_meta_advanced_options( &$t, $i ){
		$t[$i]->options[]=(object)array(
				'id'			=> 'vc_tab_advanced',
				'type' 			=> 'vc_tab', 
				'label'			=> __('Advanced','rhc'),
				'vc_tab'		=> true //flat the start of a tab in vc.
			);	
		$j=0;
		foreach(array(
					'phone' 			=> __('Phone','rhc'),
					'email' 			=> __('Email','rhc'),
					'website' 			=> __('Website url','rhc'),
					'websitelabel' 		=> __('Website label','rhc'),
					'website_nofollow' 	=> __('Website url nofollow behavior','rhc'),
					'image'		 		=> __('Image','rhc'),
					'content' 			=> __('HTML Description','rhc')
				) as $field => $label ){
				
			$tmp=(object)array(
				'id'			=> 'cal_meta_fields_'.$field,
				'name'			=> 'cal_meta_fields[]',
				'type'			=> 'checkbox',
				'option_value'	=> $field,
				'label'			=> $label,
				'vc_label' 		=> __('Fields','rhc'),
				'vc_admin_label'=> true
			);
			if($j==0){
				$tmp->description = __("Selecting multiple fields requires that you properly setup a format that contains a placeholder for each of them.",'rhc');
			}
			$t[$i]->options[]=$tmp;
			$j++;
			
		}
		
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_content',
				'type' 			=> 'textarea', 
				'label'			=> __('Format','rhc'),
				'description'	=> sprintf('<p>%s</p><p>%s</p>',
					__('Selected fields will be inserted in order into the format.  For field 1 use %1$s, for field 2 use %2$s, for field 3 use %3$s.  Example: to render a link choose "Website url" and "Website label" in the fields, then use the following format:','rhc'),
					esc_attr('<a href="%1$s">%2$s</a>')
				)
			);	
		
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_template',
				'type' 			=> 'textarea', 
				'label'			=> __('Template','rhc'),
				'description'	=> sprintf('<p>%s</p><p>%s</p>',
					__('Template refers to the main element holder, by default it is: &lt;span%1$s&gt;&lt;/span&gt;','rhc'),
					__('The elements inner html gets replaced with the actual fields value, using the format field.','rhc')
				)
			);	
	}
	
	function set_rhc_venue_meta_general_options( &$t, $i, $include_label=false ){
		$t[$i]->options[]=(object)array(
				'id'			=> 'vc_tab_general',
				'type' 			=> 'vc_tab', 
				'label'			=> __('General','rhc'),
				'vc_tab'		=> true //flat the start of a tab in vc.
			);	
		if( $include_label ):	
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_label',
				'type' 			=> 'text', 
				'label'			=> __('Label','rhc'),
				'vc_admin_label'=> true
			);					
		endif;	
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_field',
				'type' 			=> 'select',
				'label'			=> __('Fields','rhc'),
				'vc_admin_label'=> true,
				'options'		=> array(
					''			=> __('--choose--','rhc'),
					'address' 	=> __('Address','rhc'),
					'city' 		=> __('City','rhc'),
					'state' 	=> __('State/Province/Other','rhc'),
					'zip' 		=> __('Postal code','rhc'),
					'country' 	=> __('Country','rhc'),
					'sub_gmap' 	=> __('Details for google map','rhc'),
					'gaddress'	=> __('Google address','rhc'),
					'glat' 		=> __('Latitude','rhc'),
					'glon' 		=> __('Longitud','rhc'),
					'gzoom' 	=> __('Zoom','rhc'),
					'ginfo' 	=> __('Text for info windows','rhc'),
					'phone' 	=> __('Phone','rhc'),
					'email' 	=> __('Email','rhc'),
					'website' 	=> __('Website url','rhc'),
					'websitelabel' 	=> __('Website label','rhc'),
					'image'		 	=> __('Image','rhc'),
					'content' 		=> __('HTML Description','rhc')
				),
				'description' => __('Observe that if you use the advanced option, this field is ignored.', 'rhc')
			);	
		if( $include_label ):	
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_raw',
				'type' 			=> 'yesno', 
				'label'			=> __('Raw output','rhc'),
				'description'	=> __('Check this option to output without detail box html wrappers.  Ignores the label field.','rhc')
			);
		endif;		
					
	}
	
	function set_rhc_venue_meta_advanced_options( &$t, $i ){
		$t[$i]->options[]=(object)array(
				'id'			=> 'vc_tab_advanced',
				'type' 			=> 'vc_tab', 
				'label'			=> __('Advanced','rhc'),
				'vc_tab'		=> true //flat the start of a tab in vc.
			);	
		$j=0;
		foreach(array(
					'address' 	=> __('Address','rhc'),
					'city' 		=> __('City','rhc'),
					'state' 	=> __('State/Province/Other','rhc'),
					'zip' 		=> __('Postal code','rhc'),
					'country' 	=> __('Country','rhc'),
					'sub_gmap' 	=> __('Details for google map','rhc'),
					'gaddress'	=> __('Google address','rhc'),
					'glat' 		=> __('Latitude','rhc'),
					'glon' 		=> __('Longitud','rhc'),
					'gzoom' 	=> __('Zoom','rhc'),
					'ginfo' 	=> __('Text for info windows','rhc'),
					'phone' 	=> __('Phone','rhc'),
					'email' 	=> __('Email','rhc'),
					'website' 	=> __('Website url','rhc'),
					'websitelabel' 	=> __('Website label','rhc'),
					'website_nofollow' 	=> __('Website url nofollow behavior','rhc'),
					'image'		 	=> __('Image','rhc'),
					'content' 		=> __('HTML Description','rhc')
				) as $field => $label ){
				
			$tmp=(object)array(
				'id'			=> 'cal_meta_fields_'.$field,
				'name'			=> 'cal_meta_fields[]',
				'type'			=> 'checkbox',
				'option_value'	=> $field,
				'label'			=> $label,
				'vc_label' 		=> __('Fields','rhc'),
				'vc_admin_label'=> true
			);
			if($j==0){
				$tmp->description = __("Selecting multiple fields requires that you properly setup a format that contains a placeholder for each of them.",'rhc');
			}
			$t[$i]->options[]=$tmp;
			$j++;
			
		}
		
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_content',
				'type' 			=> 'textarea', 
				'label'			=> __('Format','rhc'),
				'description'	=> sprintf('<p>%s</p><p>%s</p>',
					__('Selected fields will be inserted in order into the format.  For field 1 use %1$s, for field 2 use %2$s, for field 3 use %3$s.  Example: to render a link choose "Website url" and "Website label" in the fields, then use the following format:','rhc'),
					esc_attr('<a href="%1$s">%2$s</a>')
				)
			);	
		
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_term_meta_template',
				'type' 			=> 'textarea', 
				'label'			=> __('Template','rhc'),
				'description'	=> sprintf('<p>%s</p><p>%s</p>',
					__('Template refers to the main element holder, by default it is: &lt;span%1$s&gt;&lt;/span&gt;','rhc'),
					__('The elements inner html gets replaced with the actual fields value, using the format field.','rhc')
				)
			);	
	}
	
	function pop_calendarizeit_options_for_vc_params( $t ){
		$more_options = $this->get_filter_tab_options_for_vc_params();
		foreach( $t as $i => $tab ){
			foreach( $tab->options as $j => $o ){
				if( intval( @$o->vc_tab ) && 'vc_tab_labels' == @$o->id  ){
					array_splice( $t[$i]->options, $j, 0, $more_options );
					break 2;
				}
			}
		}
		return $t;
	}
	//shortcode calendarize-it filter tab
	function get_filter_tab_options_for_vc_params(){
//error_log( date('Y-m-d H:i:s')."<-- vc get_filter_tab_options_for_vc_params\n", 3, ABSPATH.'vc.log' );
		//in pop syntax
		global $rhc_plugin;
		$options = array();
	 		
		$post_types = $rhc_plugin->get_option('post_types',array());
		$post_types = is_array($post_types) ? $post_types:array();
		array_unshift( $post_types, RHC_EVENTS );
		$post_types = apply_filters('rhc_calendar_metabox_post_types',$post_types);
		
		$options[] = (object)array(
				'id'			=> 'vc_tab_filter',
				'type' 			=> 'vc_tab', 
				'label'			=> __('Filter','rhc'),
				'vc_tab'		=> true //flat the start of a tab in vc.
			);
		
		$j = 0;	
		foreach($post_types as $post_type){

			$rhc_post_type_labels = array(
				RHC_EVENTS => __('Events','rhc')
			);
		
			$rhc_post_type_labels = apply_filters('rhc_post_type_labels',$rhc_post_type_labels);
			
			if( $pt = get_post_type_object( $post_type ) ){
			
			}else{
				//for some reason the events post type is not registered at this stage.
				$pt = (object)array(
					'name' 		=> $post_type,
					'labels'	=> (object)array(
						'name' => isset( $rhc_post_type_labels[ $post_type ] ) ? $rhc_post_type_labels[ $post_type ] : str_replace('_',' ', ucfirst( $post_type ) )
					)
				);
			}
				
			$tmp=(object)array(
				'id'	=> 'post_type_'.$pt->name,
				'name'	=> 'cal_post_type[]',
				'type'	=> 'checkbox',
				'option_value'=>$post_type,
				'default'	=> '',
				'label'	=> $pt->labels->name,
				'el_properties' => array(),
				'save_option'=>true,
				'load_option'=>true,
				'vc_label' => __('Post types')
			);
			if($j==0){
				$tmp->description = __("Choose post types to include in the calendar.",'rhc');
			}
			$options[]=$tmp;
			$j++;	
		}
			
		$options[] = (object)array(
				'id'			=> 'cal_author',
				'name'			=> 'author',
				'type' 			=> 'checkbox',
				'label'			=> __('Display events authored by the user that is logged in.','rhc'),
				'vc_label'		=> __('Logged user events','rhc'),
				'option_value'	=> 'current_user',
				'description'	=> __('Check this option to display events from the logged in user.  Observe that you need to go to Calendarize It! (menu) -> Options (submenu) -> Events cache (tab) and enable "Cache by user" (yes).', 'rhc')
			);
			
		$options[] = (object)array(
				'id'			=> 'cal_author_name',
				'type' 			=> 'text',
				'label'			=> __('Author','rhc'),
				'description'	=> __('Write an author user_login to display events from that author only', 'rhc')
			);

		$options[] = (object)array(
				'id'		=> 'cal_auto',
				'label'		=> __('Related events','rhc'),
				'type'		=> 'onoff',
				'default'	=> '0',
				'description' => __('Choose yes to only show events with the same taxonomy and term as the loaded page.  Used on venue template content.','rhc')
			);
		
		$default_taxonomies = array(
			''				=> __('--none--','rhc'),
			RHC_CALENDAR 	=> __('Calendar','rhc'),
			RHC_ORGANIZER	=> __('Organizer','rhc'),
			RHC_VENUE		=> __('Venues','rhc')
		);
		
		$taxonomies = apply_filters('rhc-taxonomies',$default_taxonomies);
		
		
		foreach( $post_types as $post_type ){
			$tmp = get_object_taxonomies(array('post_type'=>$post_type),'objects');
			if( is_array($tmp) && count($tmp) > 0 ){
				foreach( $tmp as $taxonomy => $tax ){
					$taxonomies[$taxonomy] = $tax->labels->name;
				}
			}
		}			

		$options[] = (object)array(
				'id'			=> 'cal_taxonomy',
				'type' 			=> 'select',
				'label'			=> __('Taxonomy','rhc'),
				'options'		=> $taxonomies,
				'description'	=> __('Choose a taxonomy and terms to filter events.', 'rhc')
			);
		//----- terms ------
		if( 'dropdown' == $rhc_plugin->get_option('vc_term_input', 'text', true ) ){
			$taxonomy_ids = array_filter(array_keys( $taxonomies ));

			if( is_array( $taxonomy_ids ) && count( $taxonomy_ids ) > 0 ){
				$terms = get_terms( $taxonomy_ids );			
				if( !empty($terms) ){					
					foreach( $taxonomy_ids as $tax_id ){
						$field_options = array();
						foreach( $terms as $term ){
							if( $term->taxonomy != $tax_id || !is_object( $term ) ) continue;
						
							$options[] = (object)array(
								'id'			=> 'cal_terms_'.$tax_id.'-'.$term->term_id,
								'name'			=> 'cal_terms[]',
								'type' 			=> 'checkbox',
								'label'			=> $term->name,
								'vc_label'		=> __('Terms','rhc'),
								'option_value'	=> $term->slug/*,
								"vc_dependency" 	=>array("element" => "taxonomy","value" => array($tax_id))*/
							);							
						}	
					}
				}
				/*
				$options[] = (object)array(
						'id'			=> 'cal_terms',
						'type' 			=> 'select',
						'label'			=> __('Local/External sources (feeds)','rhc'),
						'options'		=> apply_filters('rhc_views', array(
							''			=> __('Both local and external sources','rhc'),
							'0'			=> __('Only local','rhc'),
							'1'			=> __('Only external sources','rhc')
						))
					);
				*/	
			}
		}else{
			$options[] = (object)array(
				'id'			=> 'cal_terms',
				'type' 			=> 'text',
				'label'			=> __('Terms','rhc'),
				'description'	=> __('Comma separated term slug. (Not label)', 'rhc')
			);	
		}
		//-----------------------
		
		$options[] = (object)array(
				'id'			=> 'cal_feed',
				'type' 			=> 'select',
				'label'			=> __('Local/External sources (feeds)','rhc'),
				'options'		=> apply_filters('rhc_views', array(
					''			=> __('Both local and external sources','rhc'),
					'0'			=> __('Only local','rhc'),
					'1'			=> __('Only external sources','rhc')
				))
			);
			
		return $options;
	}	
	//sc calendarize-it
	function get_vc_map_params_for_calendarizeit(){
		$t = array();
		//options in RightHere options syntax.
		include 'options.calendarize_shortcode.php';
		$t = apply_filters( 'pop_calendarizeit_options_for_vc_params', $t );

/* this is only to generate a quick reference of rhc options types to conver to vc.	*/
/*
		$pop_types = array();
		foreach( $t as $i => $tab ){
			foreach( $tab->options as $j => $option ) {	
				if( in_array( $option->type, $pop_types ) ) continue;
				$pop_types[]=$option->type;
			}	
		}
*/		
/*
echo "<pre>";
print_r($t);
print_r($pop_types);
echo "</Pre>";	
*/
		$this->set_pop_conditional_options( $t, $i );	

		return $this->convert_rhc_options_to_vc_params( $t );
	}

//-- supe params for vc	
	function get_vc_map_params_for_supe(){
		global $rhc_plugin;	
		require_once RHC_PATH.'includes/class.rh_templates.php';
		$t = new rh_templates( array('template_directory'=>$rhc_plugin->get_template_path()) );
		$templates = $t->get_template_files('widget_upcoming_events');
		$templates = is_array($templates)&&count($templates)>0?$templates:array('widget_upcoming_events.php');		
		$templates = apply_filters('rhc_uew_templates', $templates);	
		//---
		$t = array();
		$i = 0;
		
		$t[$i]->options[]=(object)array(
				'id'			=> 'vc_tab_general',
				'type' 			=> 'vc_tab', 
				'label'			=> __('General','rhc'),
				'vc_tab'		=> true //flat the start of a tab in vc.
			);		
		
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_template',
				'type' 			=> 'select',
				'label'			=> __('Template','rhc'),
				'options'		=> $templates
			);	

		$t[$i]->options[]=(object)array(
				'id'		=> 'cal_nav',
				'label'		=> __('Navigation','rhc'),
				'type'		=> 'onoff',
				'default'	=> '0',
				'description' => __('Display navigation controls.','rhc'),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			);

		$t[$i]->options[]=(object)array(
				'id'	=> 'cal_number',
				'type'	=> 'range',
				'label' => '',
				'vc_label'	=> __('Number of events','rhc'),
				'vc_admin_label' => true,
				'min'	=> 0,
				'max'	=> 500,
				'step'	=> 1,
				'vc_default'=> 20
			);	

		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_order',
				'type' 			=> 'select',
				'label'			=> __('Order','rhc'),
				'options'		=> array(
					'ASC'	=> __('Ascending','rhc'),
					'DESC'	=> __('Descending', 'rhc')
				)
			);	
			
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_horizon',
				'type' 			=> 'select',
				'label'			=> __('Remove event by','rhc'),
				'options'		=> array(
					'day'	=> __('Day', 'rhc'),
					'hour'	=> __('Hour','rhc'),
					'end'	=> __('By event end', 'rhc')
				)
			);			

		$t[$i]->options[] = (object)array(
				'id'			=> 'cal_no_events_message',
				'type' 			=> 'text',
				'label'			=> __('No events message','rhc'),
				'description'	=> __('Specify a text to show if there are no more events.', 'rhc')
			);	

		$t[$i]->options[] = (object)array(
				'id'			=> 'vc_tab_filter',
				'type' 			=> 'vc_tab', 
				'label'			=> __('Filter','rhc'),
				'vc_tab'		=> true //flat the start of a tab in vc.
			);		

		$t[$i]->options[] = (object)array(
				'id'			=> 'cal_current_post',
				'name'			=> 'current_post',
				'type' 			=> 'checkbox',
				'label'			=> __('Current event recurring instances','rhc'),
				'vc_label'		=> __('Display recurring events.','rhc'),
				'option_value'	=> '1',
				'description'	=> __('Check this option to display recurring instances of the current post.  Expected inside a loop (get_the_ID).', 'rhc')
			);
			
		$t[$i]->options[] = (object)array(
				'id'			=> 'cal_post_id',
				'type' 			=> 'text',
				'label'			=> __('Post ID','rhc'),
				'description'	=> __('Specify a post ID if you want to show a list of recurring instances for that particular event.  This is overwritten by the previous option.', 'rhc')
			);				
		//-----------	
		$post_types = $rhc_plugin->get_option('post_types',array());
		$post_types = is_array($post_types) ? $post_types:array();
		array_unshift( $post_types, RHC_EVENTS );
		$post_types = apply_filters('rhc_calendar_metabox_post_types',$post_types);			
			
		$j = 0;	
		foreach($post_types as $post_type){

			$rhc_post_type_labels = array(
				RHC_EVENTS => __('Events','rhc')
			);
		
			$rhc_post_type_labels = apply_filters('rhc_post_type_labels',$rhc_post_type_labels);
			
			if( $pt = get_post_type_object( $post_type ) ){
			
			}else{
				//for some reason the events post type is not registered at this stage.
				$pt = (object)array(
					'name' 		=> $post_type,
					'labels'	=> (object)array(
						'name' => isset( $rhc_post_type_labels[ $post_type ] ) ? $rhc_post_type_labels[ $post_type ] : str_replace('_',' ', ucfirst( $post_type ) )
					)
				);
			}
				
			$tmp=(object)array(
				'id'	=> 'cal_post_type_'.$pt->name,
				'name'	=> 'cal_post_type[]',
				'type'	=> 'checkbox',
				'option_value'=>$post_type,
				'default'	=> '',
				'label'	=> $pt->labels->name,
				'el_properties' => array(),
				'save_option'=>true,
				'load_option'=>true,
				'vc_label' => __('Post types')
			);
			if($j==0){
				$tmp->description = __("Choose post types to include in the list.",'rhc');
			}
			$t[$i]->options[]=$tmp;
			$j++;	
		}			

		$t[$i]->options[] = (object)array(
				'id'			=> 'cal_author_current',
				'name'			=> 'author_current',
				'type' 			=> 'checkbox',
				'label'			=> __('Display events authored by the user that is logged in.','rhc'),
				'vc_label'		=> __('Logged user events','rhc'),
				'option_value'	=> '1',
				'description'	=> __('Check this option to display events from the logged in user.', 'rhc')
			);
			
		$t[$i]->options[] = (object)array(
				'id'			=> 'cal_author',
				'type' 			=> 'text',
				'label'			=> __('Author','rhc'),
				'description'	=> __('Write an author user_login to display events from that author only', 'rhc')
			);			

		$t[$i]->options[]=(object)array(
				'id'		=> 'cal_auto',
				'label'		=> __('Related events','rhc'),
				'type'		=> 'onoff',
				'default'	=> '0',
				'description' => __('Choose yes to only show events with the same taxonomy and term as the loaded page.  Used on venue template content.','rhc')
			);

		$default_taxonomies = array(
			''				=> __('--none--','rhc'),
			RHC_CALENDAR 	=> __('Calendar','rhc'),
			RHC_ORGANIZER	=> __('Organizer','rhc'),
			RHC_VENUE		=> __('Venues','rhc')
		);
		
		$taxonomies = apply_filters('rhc-taxonomies',$default_taxonomies);
		
		
		foreach( $post_types as $post_type ){
			$tmp = get_object_taxonomies(array('post_type'=>$post_type),'objects');
			if( is_array($tmp) && count($tmp) > 0 ){
				foreach( $tmp as $taxonomy => $tax ){
					$taxonomies[$taxonomy] = $tax->labels->name;
				}
			}
		}			

		$t[$i]->options[] = (object)array(
				'id'			=> 'cal_taxonomy',
				'type' 			=> 'select',
				'label'			=> __('Taxonomy','rhc'),
				'options'		=> $taxonomies,
				'description'	=> __('Choose a taxonomy and terms to filter events.', 'rhc')
			);
		
		if( 'dropdown' == $rhc_plugin->get_option('vc_term_input', 'text', true ) ){
			
		}else{
			$t[$i]->options[] = (object)array(
					'id'			=> 'cal_terms',
					'type' 			=> 'text',
					'label'			=> __('Terms','rhc'),
					'description'	=> __('Comma separated term slug. (Not label)', 'rhc')
				);
		}



		$t[$i]->options[]=(object)array(
				'id'			=> 'vc_tab_format',
				'type' 			=> 'vc_tab', 
				'label'			=> __('Format','rhc'),
				'vc_tab'		=> true //flat the start of a tab in vc.
			);

		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_date_format',
				'type' 			=> 'text',
				'label'			=> __('Date format','rhc')
			);	
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_time_format',
				'type' 			=> 'text',
				'label'			=> __('Time format','rhc')
			);	

		$t[$i]->options[]=(object)array(
				'id'		=> 'cal_premiere',
				'label'		=> __('Premiere','rhc'),
				'type'		=> 'onoff',
				'default'	=> '0',
				'description' => __('Choose yes to only show the first event in a recurring set.','rhc'),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			);

		$t[$i]->options[]=(object)array(
				'id'			=> 'vc_tab_other',
				'type' 			=> 'vc_tab', 
				'label'			=> __('Other','rhc'),
				'vc_tab'		=> true //flat the start of a tab in vc.
			);			
			
		$this->set_pop_conditional_options( $t, $i );		
			
		return $this->convert_rhc_options_to_vc_params( $t );
	}
	
	/* convert an  array of pop options to an array of vc params */
	function convert_rhc_options_to_vc_params( $t ){
		$group = '';
		$unhandled_types = array();
		$params = array();
		foreach( $t as $i => $tab ){
			foreach( $tab->options as $j => $option ) {	
			
				if( property_exists( $option, 'vc_tab' ) && $option->vc_tab ){
					$group = $option->label;
				}
			
				try {
					if( !empty($option->vc_skip) && $option->vc_skip ) continue;
//echo $option->type."<---<br>";			
					//$params[] = $this->get_vc_param( $option, $tab->options, $group, $tab, $i );
					$params[] = $this->get_vc_param( $option, $tab->options, $group, null, $i );//VC outputs this in the html element, we dont need now so lets not pass garbage.	
				}catch( Exception $e ){
					$message = $option->type." ".$e->getMessage();
					if( !array_key_exists( $message, $unhandled_types ) ){
						$unhandled_types[ $message] = 1;
					}else{
						$unhandled_types[ $message ]++;
					}
						
				}
			}	
		}		
		return $params;
	}	

	/* convert a single rhc option to vc param */
	function get_vc_param( $rhc_option, $rhc_options, $group='', $tab, $i ){
	
		$method = 'get_vc_param_from_rhc_' . $rhc_option->type;
		if( method_exists( $this, $method ) ){
			//render using vc renderer
			$param = $this->$method( $rhc_option, $rhc_options );
			$this->set_admin_label( $param, $rhc_option );
			$this->set_group( $param, $group );
			
			return $param;
		} else {
			if( !in_array( $rhc_option->type, array('clear', 'div_start', 'div_end','vc_tab') ) ){
				$param	= $this->rhc_pop_to_vc_param( $tab, $i, $rhc_option) ;
	//error_log( "LINE:".__LINE__."\n".print_r($param,true)."\n", 3, ABSPATH.'vc.log');	
				if( false!==$param ){
					$this->set_admin_label( $param, $rhc_option );
					$this->set_group( $param, $group );
					return $param;
				}
				//render using pop renderer
			}	

		}
//error_log( "LINE:".__LINE__."\n", 3, ABSPATH.'vc.log');		
		throw new Exception( 'RHC Option to VC Param method not found' );

	}
	/* conver a single rhc option to vc param helper */
	function rhc_pop_to_vc_param( $tab, $i, $o ){
		if( !property_exists( $o, 'id' ) ) return false;
		if( 'yesno' == $o->type ){
			$o->type = 'onoff'; //vc doesnt seem to support radio.
			$o->options = array(
				'1'=>__('Yes','pop'),
				'0'=>__('No','pop')
			);				
		}
	
		$param = array(
				"type" 			=> "pop_option",  //vc will call this::pop_option
				//"holder" 		=> "div",
				"class" 		=> "pt-option-" . $o->type,
				"param_name" 	=> str_replace( 'cal_', '', $o->id ),
				"rhc_pop"		=> compact( 'tab', 'i', 'o' )
			);
		
		if( property_exists( $o, 'vc_label' ) ){
			$param["heading"] = $o->vc_label;
		}else if( property_exists( $o, 'label' ) && !empty( $o->label ) ){
			$param["heading"] = $o->label;
		}
			
		$this->set_vc_field( $param, 'description', $this->get_vc_description( $o ) );	
		// 
		//$this->set_vc_field( $param, 'value', (property_exists( $o, 'default' ) ? $o->default : '') );	
		if( property_exists( $o, 'vc_default' ) ){
			$this->set_vc_field( $param, 'value', $o->vc_default );
		}else{
			if( in_array( $o->type, array('yesno','range','onoff') ) && property_exists( $o, 'default' ) ){
				$this->set_vc_field( $param, 'value', $o->default );
			}
		}
				
		return $param;
	}
	
	function set_group( &$param, $group ){
		if( !empty( $group ) ){
			$param['group'] = $group;
		}
	}
	
	function set_admin_label( &$param, $pop_option ){
		if( property_exists( $pop_option, 'vc_admin_label') ){
			$param['admin_label'] = $pop_option->vc_admin_label;
		}
	}
	/* converts a pop dropdown options to vc dropdown options */
	function rhc_to_vc_dropdown_options( $options ){
		$vc_options = array();
		foreach( $options as $value => $label ){
			$value = (string)$value;
			$vc_options[$label] = $value;
		}
		return $vc_options;
	}
		
	//rhc option to vc param mapping methods
	function get_vc_param_from_rhc_shortcode_content( $o ) {
	
		$param = array(
				"type" 			=> "textarea_html",
				"class" 		=> "",
				"heading" 		=> $o->label,
				"param_name" 	=> "content"
		);
		
		$this->set_vc_field( $param, 'description', $this->get_vc_description( $o ) );
			
		if( property_exists( $o, 'default' ) ) {
			$this->set_vc_field( $param, 'value', $o->default );	
		}			

		return $param;
	}
	
	function get_vc_param_from_rhc_textarea( $o ){
		$param = array(
				"type" 			=> "textarea",
				"class" 		=> "",
				"heading" 		=> $o->label,
				"param_name" 	=> str_replace( 'cal_', '', $o->id )
			);
		
		$this->set_vc_field( $param, 'description', $this->get_vc_description( $o ) );	
		$this->set_vc_field( $param, 'value', (property_exists( $o, 'default' ) ? $o->default : '') );				

		return $param;
	}
	
	function get_vc_param_from_rhc_textarea_raw_html( $o ){
		$param = array(
				"type" 			=> "textarea_raw_html",
				"class" 		=> "",
				"heading" 		=> $o->label,
				"param_name" 	=> str_replace( 'cal_', '', $o->id )
			);
		
		$this->set_vc_field( $param, 'description', $this->get_vc_description( $o ) );	
		$this->set_vc_field( $param, 'value', (property_exists( $o, 'default' ) ? $o->default : '') );				

		return $param;
	}
		
	function get_vc_param_from_rhc_text( $o ){
		$param = array(
				"type" 			=> "textfield",
				"class" 		=> "",
				"heading" 		=> $o->label,
				"param_name" 	=> str_replace( 'cal_', '', $o->id )
			);
		//if value is set with an empty value, the shortcode always render with the attribute even if empty.	
		$this->set_vc_field( $param, 'description', $this->get_vc_description( $o ) );	
		$this->set_vc_field( $param, 'value', (property_exists( $o, 'default' ) ? $o->default : '') );	
			
		return $param;
	}
	
	function get_vc_param_from_rhc_select( $o ){
		$param = array(
				"type" 			=> "dropdown",
				"class" 		=> "",
				"heading" 		=> $o->label,
				"param_name" 	=> str_replace( 'cal_', '', $o->id ),
				"value" 		=> $this->rhc_to_vc_dropdown_options( $o->options )
			);
			
		$this->set_vc_field( $param, 'description', $this->get_vc_description( $o ) );	
		$this->set_vc_field( $param, 'std', (property_exists( $o, 'default' ) ? $o->default : '') );	
		
		return $param;
	}
	
	function get_vc_param_from_rhc_checkbox( $o, $options){
		$group_checkboxes = array();
		foreach( $options as $i => $option ){
			if( $option->type == "checkbox" && $option->name == $o->name ){
				if( $o->id !== $option->id ){
					throw new Exception('Checkbox already grouped');
				}else{
					break;
				}
			}
		}
		
		$values = array();
		foreach( $options as $i => $option ){
			if( $option->type == "checkbox" && $option->name == $o->name ){
				$values[ $option->label ] = $option->option_value;
			}
		}

		$param = array(
				"type" 			=> "checkbox",
				"class" 		=> "",
				"heading" 		=> @$o->vc_label,
				"param_name" 	=> str_replace( '[]', '', str_replace( 'cal_', '', $o->name ) ),
				"value" 		=> $values
			);
			
		$this->set_vc_field( $param, 'description', $this->get_vc_description( $o ) );	
		$this->set_vc_field( $param, 'std', (property_exists( $o, 'default' ) ? $o->default : '') );	
		$this->set_vc_field( $param, 'admin_label', (property_exists( $o, 'vc_admin_label' ) ? $o->vc_admin_label : false) );	
		if( property_exists( $o, 'vc_dependency' ) ){
			$param['dependency'] = $o->vc_dependency;
		}	

		return $param;

	}
	
	function get_vc_param_from_rhc_subtitle( $o ){
	
		$param = array(
				"type" 			=> "pop_subtitle",
				"param_name"	=> "sub",
				"class" 		=> "rhc-vc-subtitle",
				"heading" 		=> $o->label
			);
			
		$this->set_vc_field( $param, 'description', $this->get_vc_description( $o ) );		
		
		return $param;
	}
	
	function get_vc_param_from_rhc_rhc_postmeta_dropdown( $o ){
		
		$param = array(
				"type" 			=> "rhc_postmeta_dropdown",//custom vc param
				"class" 		=> "",
				"heading" 		=> $o->label,
				"param_name" 	=> str_replace( 'cal_', '', $o->id )
			);		
		return $param;
	}
		
	//--- custom type callbacks.
	function pop_subtitle( $settings, $value ){
	 	//without this, vc output the shortcode attribute. but this is just a dummy element to display a label.
	   return '<input name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-hiddeninput ' .
             esc_attr( $settings['param_name'] ) . ' ' .
             esc_attr( $settings['type'] ) . '_field" type="hidden" value="' . esc_attr( $value ) . '" />' ;	
	}
	//--- this is the callback that maps to a pop render fn	
	function pop_option( $settings, $value ){
		if( false===$this->pop_input ){
			//Righthere pop rendered
			if(!class_exists('pop_input'))require_once  RHC_PATH . 'options-panel/class.pop_input.php';		
			$this->pop_input = new pop_input();
		}
//error_log( print_r($settings,true)."\n", 3, ABSPATH.'api.log' );		
		extract( $settings['rhc_pop'] );
		$o->id 	= $settings['param_name'];
		$o->name= $settings['param_name'];
		$o->load_option = false;
		$o->save_option = false;
		$o->value = $value;
//error_log( "value:".$value."\n", 3, ABSPATH.'api.log' );
		/*
		echo "<pre>";
		//print_r( $o );
		echo "</pre>";
		return "TODO: field type ".$o->type."<br>";
		*/
		$class = sprintf( "wpb_vc_param_value %s %s_field",
			esc_attr( $settings['param_name'] ),
			esc_attr( $settings['type'] )
		);
		
		$o->el_properties = property_exists($o,'el_properties')?$o->el_properties:array();
		$o->el_properties['class']=isset($o->el_properties['class'])?$o->el_properties['class'].' '.$class:$class;
		if( isset( $settings['class'] ) ){
			$o->el_properties['class'].= ' '.$settings['class'];		
		}

		//throw new Exception('TODO LINE:'.__LINE__);
		$method = "_".$o->type;
		if( ! method_exists( $this->pop_input, $method ) ) 
			throw new Exception( sprintf( __('Method %s does not exists on renderer','rhc'), $method ) );
		$save_fields = array();//not used.
		return sprintf('<div class="%s">%s</div>', 
			isset( $settings['class'] ) ? esc_attr($settings['class']) : '',
			$this->pop_input->$method($tab,$i,$o,$save_fields)
		);
	}	
		
	function get_vc_description( $o ){
		return property_exists( $o, 'vc_description' ) ? $o->vc_description : @$o->description ;
	}
	
	function set_vc_field( &$param, $field, $value ){
		if( ''!=trim($value) ){
			$param[$field]=$value;
		}
	}

}

