<?php 

class rhc_visual_composer_subcategories {
	var $id;
	function __construct($args=array()){
		//------------
		$defaults = array(
			'url'				=> ''
		);
		foreach($defaults as $property => $default){
			$this->$property = isset($args[$property])?$args[$property]:$default;
		}
		//-----------
		
		add_action( 'wp_enqueue_scripts', array( &$this, 'wp_enqueue_scripts') );
		add_action( 'admin_enqueue_scripts', array( &$this, 'wp_enqueue_scripts') );
		
		add_action( 'vc_backend_editor_render', array( &$this, 'vc_editor_render' ) );
		add_action( 'vc_frontend_editor_render_template', array( &$this, 'vc_editor_render' ) );			
		
		add_filter( 'vc_add_element_box_buttons', array( &$this, 'vc_add_element_box_buttons' ), 10, 1 );
		
		$this->selector = '.js-category-' . md5( __( "Calendarize It!", "rhc") );//md5 of the value passed to vc_map as category.
	}
	
	function wp_enqueue_scripts(){
		
	}
	
	function get_rhc_subcategories(){
		return apply_filters('rhc_vc_subcategories', array(
			'rhc-calendar' 	=> __('Calendar','rhc'),
			'rhc-box' 		=> __('Default Details Boxes','rhc'),
			'rhc-custom'	=> __('Custom Details Boxes', 'rhc'),
			'rhc-event'		=> __('Event fields','rhc'),
			'rhc-venue'		=> __('Venue fields', 'rhc'),
			'rhc-organizer'	=> __('Organizer fields', 'rhc'),
			'rhc-tax'		=> __('Taxonomy fields', 'rhc'),
			'rhc-other'		=> __('Other fields','rhc'),
			'rhc-rescrict'	=> __('Restrict access','rhc')
		));
	}
	
	function get_rhc_shortcodes_subcategories(){
		return apply_filters('rhc_vc_shortcode_subcategories',array(
			'calendarizeit' 				=> array('rhc-calendar'),
			'rhc_static_upcoming_events' 	=> array('rhc-calendar'),
			'venue_detailbox' 				=> array('rhc-box'),
			'event_detailbox' 				=> array('rhc-box'),
			'rhc_image' 					=> array('rhc-event'),
			'rhc_conditional_content' 		=> array('rhc-rescrict'),
			'rhc_start'						=> array('rhc-event'),
			'rhc_start_date'				=> array('rhc-event'),
			'rhc_start_time'				=> array('rhc-event'),
			'rhc_end'						=> array('rhc-event'),
			'rhc_end_date'					=> array('rhc-event'),
			'rhc_end_time'					=> array('rhc-event'),
			'rhc_gmap'						=> array('rhc-event','rhc-venue'),
			
			'rhc_dbox'						=> array('rhc-custom'),
			//'rhc_dbox_cell'					=> array('rhc-custom'),,
			'rhc_label'						=> array('rhc-other'),
			
			'rhc_venue_loop'				=> array('rhc-venue'),
			'rhc_organizer_loop'			=> array('rhc-organizer'),
			'rhc_calendar_loop'				=> array('rhc-tax'),
			'rhc_tax_loop'					=> array('rhc-tax'),
			
			'rhc_term'						=> array('rhc-tax'),
			'rhc_venue_term'				=> array('rhc-venue'),
			'rhc_organizer_term'			=> array('rhc-organizer'),
			'rhc_calendar_term'				=> array('rhc-tax'),
			
			'rhc_venue_meta'				=> array('rhc-venue'),
			'rhc_organizer_meta'			=> array('rhc-organizer'),
			'rhc_venue_image'				=> array('rhc-venue'),
			'rhc_venue_website'				=> array('rhc-venue'),
			'rhc_organizer_image'			=> array('rhc-organizer'),
			'rhc_organizer_website'			=> array('rhc-organizer'),
			'rhc_venue_meta_info_cell'		=> array('rhc-venue'),
			'rhc_organizer_meta_info_cell'	=> array('rhc-organizer'),
			
			'rhc_title'						=> array('rhc-event'),
			//'CONTENT'						=> array('rhc-event','rhc-venue','rhc-organizer','rhc-tax'),
			'CONTENT'						=> array('rhc-event'),
			'rhc_description'				=> array('rhc-event'),
			'btn_ical_feed'					=> array('rhc-event')
		));
	}
	
	function vc_editor_render(){
?>
<script type="text/javascript">
try {
	var RHCVC = {};
	RHCVC.vc = {
		category: '<?php echo $this->selector ?>',
		shortcode_subcategories: <?php echo json_encode($this->get_rhc_shortcodes_subcategories())?>
	};
}catch(e){
	if( console && console.log ) console.log( e.message );
}
</script>
<style>
.rhc-sub-container {
   height: auto;
   overflow: hidden;
}

.rhc-sub-left {	
	display:none;
    width: 180px;
    float: left;
}

.rhc-sub-left.rhc-show {
	display:block;
}

.rhc-sub-right {
    float: none; 
    width: auto;
    overflow: hidden;
}​​
</style>
<?php	
		wp_register_script( 'rhc-vc-subcategories', 	$this->url.'js/vc_subcategories.js', array(),'2.6.1.3');
		wp_print_scripts('rhc-vc-subcategories');
	}		
	
	function get_filter_buttons(){
		$out = '';
		$out .= sprintf('<button class="rhc-vc-sub-btn vc_ui-button widefat" data-rhc_subcategory="*">%s</button>',
			__('Show all', 'rhc')
		);
		foreach( $this->get_rhc_subcategories() as $value => $label ){
			$out .= sprintf('<button class="rhc-vc-sub-btn vc_ui-button widefat" data-rhc_subcategory="%s">%s</button>',
				'.'.$value,
				$label
			);
		}
		return $out;
	}
	
	function vc_add_element_box_buttons( $output ){	
		$output = sprintf('<div class="rhc-sub-container"><div class="rhc-sub-left" style="display:none;">%s</div><div class="rhc-sub-right">%s</div></div>',
			$this->get_filter_buttons(),
			$output
		);
		return $output;
	}
}


?>