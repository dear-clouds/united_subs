<?php

class plugin_righthere_calendar {
	var $id;
	var $tdom;
	var $plugin_code;
	var $options_varname;
	var $options;
	var $calendar_ajax;
	var $uid=0;
	var $debug_menu = false;
	var $in_footer = false;
	var $debugging_js_css = false;
	var $enqueue_scripts = false;//a flag to enqueue scripts.
	var $template_frontend;
	var $template_taxonomy_title=false;
	var $wp44plus=true;
	function __construct($args=array()){
		//------------
		$defaults = array(
			'id'				=> 'rhc',
			'tdom'				=> 'rhc',
			'plugin_code'		=> 'RHC',
			'options_varname'	=> 'rhc_options',
			'options_parameters'=> array(),
			'options_capability'=> 'manage_options',
			'license_capability'=> 'manage_options',
			'resources_path'	=> 'calendarize-it',
			'options_panel_version'	=> '2.8.3',
			'post_info_shortcode'=> 'rhc_post_info',
			'debug_menu'		=> false,
			'autoupdate'		=> true,
			'debugging_js_css'	=> false
		);
		foreach($defaults as $property => $default){
			$this->$property = isset($args[$property])?$args[$property]:$default;
		}
		//-----------
		global $wp_version;
		$version = substr($wp_version,0,3);	
		if( $version < 4.4 ){
			$this->wp44plus = false;
		}	
		//-----------
		$this->options = get_option($this->options_varname);
		$this->options = is_array($this->options)?$this->options:array();
		//-----------
		$plugins_loaded_hook = '1'==$this->get_option('ignore_wordpress_standard',false,true)?'plugins_loaded':'after_setup_theme';		
		add_action($plugins_loaded_hook,array(&$this,'plugins_loaded'));
		
		//--- taxonomy metadata support based on code by mitcho (Michael Yoshitaka Erlewine), sirzooro
		add_action('init',array(&$this,'taxonomy_metadata_wpdbfix') );
		add_action('switch_blog',array(&$this,'taxonomy_metadata_wpdbfix'));		
		//--------
		//if(is_admin()){ //Note: other plugins/themes are changing what the is_admin() returns causing a fatal error. if you are trying to optimize every posible line uncomment this line and comment the next one.
		if( true ){ 
			require_once RHC_PATH.'options-panel/load.pop.php';
			rh_register_php('options-panel',RHC_PATH.'options-panel/class.PluginOptionsPanelModule.php', $this->options_panel_version);
			rh_register_php('rh-functions', RHC_PATH.'options-panel/rh-functions.php', $this->options_panel_version);
		}else{
			require_once RHC_PATH.'options-panel/load.pop.php';
			rh_register_php('rh-functions', RHC_PATH.'options-panel/rh-functions.php', $this->options_panel_version);
		}
		
		add_filter('rhc-ui-theme',array(&$this,'rhc_ui_theme'),10,1);
		//--
		if('1'==$this->get_option('enable_debug',false,true)){
			$this->debug_menu = true;
		}
		//--
		if('1'==$this->get_option('debug_javascript',false,true)){
			$this->debugging_js_css = true;
		}		
		//--
		if('1'==$this->get_option('enable_addons','1',true)){
			add_action('plugins_loaded',array(&$this,'handle_addons_load'),5);
		}
		
//--
		if('1'==$this->get_option('in_footer',false,true)){
			$this->in_footer = true;
		}	
	
		if(isset($_REQUEST['rhc_action'])){
			if(!defined('DOING_AJAX'))define('DOING_AJAX',true);
		}
		require_once RHC_PATH.'includes/compat.php';	
		//upgrader_post_install hook for post upgrade procedures: rebuild permalink after 3.7 and check fc range meta data.

		add_filter("plugin_action_links_".RHC_SLUG, array(&$this,'rhc_plugin_settings_link') );
		add_action("admin_init",array(&$this,'admin_init'));
		add_action( 'wp_ajax_rhc_dismiss_notice', array(&$this,'rhc_dismiss_notice') );
		add_action( 'wp_ajax_confirm_rhc_setup', array(&$this,'confirm_rhc_setup') );
		add_action( 'wp_ajax_dismiss_rhc_setup', array(&$this,'dismiss_rhc_setup') );
		add_action( 'init', array(&$this,'init_rhc_metaboxes'), 999 );
		
		//---
		$this->handle_theme_compat_fix();
		//--- handle update
		$this->handle_update();
	}

	function handle_update(){
//update_option( 'RHC_VERSION', 0, true );		
		$rhc_version = get_option('RHC_VERSION',0);			
		if (version_compare( RHC_VERSION, $rhc_version) > 0) {
			update_option( 'RHC_VERSION', RHC_VERSION, true );
		
			require RHC_PATH.'includes/update.php';	
			do_action('rhc_updated', $rhc_version);
		}
	}

	function init_rhc_metaboxes(){
		if(is_admin()){	
			//require_once RHC_PATH.'includes/class.rhc_calendar_metabox.php';
// this contains a filter needed by ce in the frontend. moving this to the fortnend until the required code is moved to a separate hook/file.
/*
			require_once RHC_PATH.'includes/class.rhc_calendar_metabox_rrule.php';
			new rhc_calendar_metabox(RHC_EVENTS,$this->debug_menu);
			$post_types = $this->get_option('post_types',array());
			$post_types = is_array($post_types)?$post_types:array();
			$post_types = apply_filters('rhc_calendar_metabox_post_types',$post_types);
			if(is_array($post_types)&&count($post_types)>0){
				foreach($post_types as $post_type){
					new rhc_calendar_metabox($post_type,$this->debug_menu);
				}
			}
*/				
			//---	
			require_once RHC_PATH.'includes/class.rhc_post_info_metabox.php';
			new rhc_post_info_metabox(RHC_EVENTS,'edit_'.RHC_CAPABILITY_TYPE);	
			//--- enable post info for other post types.
			$post_types = $this->get_option('dbox_post_types',array());
			$post_types = is_array($post_types)?$post_types:array();
			$post_types = apply_filters('rhc_dbox_metabox_post_types',$post_types);
			if(is_array($post_types)&&count($post_types)>0){
				foreach($post_types as $post_type){
					$pt = get_post_type_object( $post_type );
					if(is_object($pt)){
						new rhc_post_info_metabox( $post_type, $pt->cap->edit_post );
					}				
				}
			}			
			//--
			require_once RHC_PATH.'includes/class.rhc_event_image_metaboxes.php';
			new rhc_event_image_metaboxes();
			//--- enable post info for other post types.
			$post_types = $this->get_option('img_post_types',array());
			$post_types = is_array($post_types)?$post_types:array();
			$post_types = apply_filters('rhc_img_metabox_post_types',$post_types);					
			if(is_array($post_types)&&count($post_types)>0){
				foreach($post_types as $post_type){
					$pt = get_post_type_object( $post_type );
					if(is_object($pt)){
						new rhc_event_image_metaboxes( $post_type );
					}				
				}
			}					
		}
	}
	
	function admin_init(){
		if(current_user_can('rhc_options')){
			if( get_option('rhc_options_redirect', false)){
				delete_option('rhc_options_redirect');
				wp_safe_redirect( admin_url('/edit.php?post_type='.RHC_EVENTS.'&page=rhc&pop_open_tabs=license/#license') );
				die();
			}
				
			if(!defined('RHCH_PATH')){
				if( ( isset($_REQUEST['page']) && $_REQUEST['page']=='rhc-dc' ) || get_option( 'rhc_dismiss_help_notice', false ) ){
				
				}else{
					add_action( 'admin_notices', array(&$this,'admin_notice_install_help') );
				}
			}	
			
			if( get_option('rhc_setup',false) ){
				if( !$this->is_template_set() || !$this->is_shortcode_set() ){
					add_action( 'admin_notices', array(&$this,'admin_notice_rhc_setup') );
				}else{
					delete_option('rhc_setup');				
				}			
			}							
		}
	}

	function rhc_dismiss_notice(){
		update_option('rhc_dismiss_help_notice',true);
		die(json_encode((object)array('R'=>'OK','MSG'=>'')));
	}
	
	function dismiss_rhc_setup(){
		delete_option( 'rhc_setup' );
		die(json_encode((object)array('R'=>'OK','MSG'=>'')));
	}
	
	function confirm_rhc_setup(){
		global $userdata;
		if(current_user_can('rhc_options')){
			if( !$this->is_template_set() ){
				if( '' == $this->get_option('event_template_page_id','',true) ){
					$post = array(
					  'post_title'    	=> __('Events template','rhc'),
					  'post_content'  	=> '[CONTENT]',
					  'post_status'   	=> 'publish',
					  'post_author'   	=> $userdata->ID,
					  'post_type'		=> 'page'
					);
					$post_ID = wp_insert_post( $post, false );	
					if($post_ID>0){
						$this->update_option('event_template_page_id', $post_ID); 
					}
				}	
				
				if( '' == $this->get_option('taxonomy_template_page_id','',true) ){
					$post = array(
					  'post_title'    	=> __('Taxonomy template','rhc'),
					  'post_content'  	=> '[CONTENT]',
					  'post_status'   	=> 'publish',
					  'post_author'   	=> $userdata->ID,
					  'post_type'		=> 'page'
					);
					$post_ID = wp_insert_post( $post, false );	
					if($post_ID>0){
						$this->update_option('taxonomy_template_page_id', $post_ID); 
					}
				}	
				
				if( '' == $this->get_option('venue_template_page_id','',true) ){
					$post = array(
					  'post_title'    	=> __('Venue template','rhc'),
					  'post_content'  	=> '[CONTENT]',
					  'post_status'   	=> 'publish',
					  'post_author'   	=> $userdata->ID,
					  'post_type'		=> 'page'
					);
					$post_ID = wp_insert_post( $post, false );	
					if($post_ID>0){
						$this->update_option('venue_template_page_id', $post_ID); 
					}
				}	
				
				if( '' == $this->get_option('organizer_template_page_id','',true) ){
					$post = array(
					  'post_title'    	=> __('Organizer template','rhc'),
					  'post_content'  	=> '[CONTENT]',
					  'post_status'   	=> 'publish',
					  'post_author'   	=> $userdata->ID,
					  'post_type'		=> 'page'
					);
					$post_ID = wp_insert_post( $post, false );	
					if($post_ID>0){
						$this->update_option('organizer_template_page_id', $post_ID); 
					}
				}							
			}
			
			if( !$this->is_shortcode_set() ){
				$post = array(
				  'post_title'    	=> __('Events Calendar','rhc'),
				  'post_content'  	=> '[calendarizeit]',
				  'post_status'   	=> 'publish',
				  'post_author'   	=> $userdata->ID,
				  'post_type'		=> 'page'
				);
				wp_insert_post( $post, false );			
			}			
		}

		die(json_encode((object)array('R'=>'OK','MSG'=>'')));
	}
	
	function admin_notice_rhc_setup(){
    	add_action('admin_footer',array(&$this,'admin_help_notice_footer'));
	?>
    <div class="updated rhc-setup-notice">
		<h3><?php _e('Calendarize it! Automatic Setup','rhc')?></h3>
        <?php _e('Click confirm to continue with the automatic setup process:','rhc') ?>
		<ol>
		<?php if( !$this->is_template_set() ):?>
		<li><?php _e('Create Event and Venue templates.','rhc')?></li>
		<?php endif;?>
        <?php if( !$this->is_shortcode_set() ):?>
		<li><?php _e('Create a Calendar page with the Calendarize it! shortcode.','rhc') ?></li>
		<?php endif;?>
		</ol>
		<p>
			<button id="btn_confirm_rhc_setup" class="button-primary"><?php _e('Confirm','rhc')?></button>
			<button id="btn_dismiss_rhc_setup" class="button-secondary"><?php _e('No, I will manually setup the plugin','rhc')?></button>
		</p>
    </div>
    <?php
	}
	
	function admin_notice_install_help(){
    	add_action('admin_footer',array(&$this,'admin_help_notice_footer'));
	?>
    <div class="updated rhc-help-notice">
		<h3>Calendarize it!</h3>
        <p><?php echo sprintf('%s<a href="%s">%s</a>',
			__( 'You have not installed the English Help for Calendarize it! Please go to ', 'rhc' ),
			admin_url('/edit.php?post_type='.RHC_EVENTS.'&page=rhc-dc'),
			__( 'downloads.', 'rhc' )
		); ?></p>
		<p><button id="btn_dismiss_help_notice" class="button-primary"><?php _e('Do not show this message again','rhc')?></button></p>
    </div>
    <?php
	}
	
	function admin_help_notice_footer(){
		wp_print_scripts('rhc_setup');
	}
	
	function rhc_plugin_settings_link($links) { 
		$settings_link = sprintf('<a href="%s">%s</a>',
			admin_url('/edit.php?post_type='.RHC_EVENTS.'&page=rhc'),
			__('Settings','rhc')
		); 
		array_unshift($links, $settings_link); 
		return $links; 
	}

	function handle_addons_load(){
		//-- nexgt gen gallery compat fix.

		if( defined('NGG_PLUGIN') ){
			rh_register_php('options-panel',RHC_PATH.'options-panel/class.PluginOptionsPanelModule.php', $this->options_panel_version);
		}
		//---
		$upload_dir = wp_upload_dir();
		$addons_path = $upload_dir['basedir'].'/'.$this->resources_path.'/';	
		$addons_url = $upload_dir['baseurl'].'/'.$this->resources_path.'/';	
		$addons = $this->get_option('addons',array(),true);
		if(is_array($addons)&&!empty($addons)){
			define('RHC_ADDON_PATH',$addons_path);
			define('RHC_ADDON_URL',$addons_url);
			foreach($addons as $addon){
				try {
					@include_once $addons_path.$addon;
				}catch(Exception $e){
					$current = get_option( $this->options_varname, array() );
					$current = is_array($current) ? $current : array();
					$current['addons'] = is_array($current['addons']) ? $current['addons'] : array() ;
					//----
					$current['addons'] = array_diff($current['addons'], array($addon))  ;
					update_option($this->options_varname, $current);					
				}
			}
		}
	}
	
	function handle_theme_compat_fix(){
		//as we run into theme specific problems, this section loads fixes for that theme. if available.
		$theme = wp_get_theme();
		$filename = str_replace(' ','-', strtolower($theme->get('Name'))).'.php';
		//die($filename);
		@include RHC_PATH.'theme-compat-fixes/'.$filename;
	}
	
	function rhc_ui_theme($t){
		$t = array_merge($t, array( ''=>'no ui-theme'  ));
		return $t ;	
	}
	
	function taxonomy_metadata_wpdbfix() {
	  global $wpdb;
	  $wpdb->taxonomymeta = "{$wpdb->prefix}taxonomymeta";
	}
	
	function plugins_loaded(){
		load_plugin_textdomain('rhc', null, RHC_LANGUAGES );
	
		global $rhc_scripts;
		if( !defined('RHCAJAX') ){
			require_once RHC_PATH.'includes/class.rhc_styles_and_scripts.php';
			$rhc_scripts = new rhc_styles_and_scripts( $this->in_footer, $this->debugging_js_css);
		
			require_once RHC_PATH.'includes/class.ui_themes_for_calendarize_it.php';
			require_once RHC_PATH.'includes/function.generate_calendarize_shortcode.php';
		}
		
		if( PHP_VERSION_ID >= 50300 ){
			require_once RHC_PATH.'includes/functions.template.php';
		}
		
		//frontend
		require_once RHC_PATH.'custom-taxonomy-with-meta/taxonomy-metadata.php';  
		require_once RHC_PATH.'custom-taxonomy-with-meta/taxonomymeta_shortcode.php';

		if( !defined('RHCAJAX') ){
			require_once RHC_PATH.'includes/class.shortcode_calendarize.php';
			new shortcode_calendarize();
		}
		
		require_once RHC_PATH.'includes/class.rhc_static_upcoming_events.php';  
		new rhc_static_upcoming_events();
		
		require_once RHC_PATH.'includes/class.rhc_post_info_shortcode.php';
		new rhc_post_info_shortcode($this->post_info_shortcode);
		
		require_once RHC_PATH.'includes/class.calendar_ajax.php';
		$this->calendar_ajax = new calendar_ajax();

		//widgets
		if( !defined('RHCAJAX') ){
			require_once RHC_PATH.'includes/class.UpcomingEvents_Widget.php';
			add_action( 'widgets_init', create_function( '', 'register_widget( "UpcomingEvents_Widget" );' ) );
			require_once RHC_PATH.'includes/class.EventsCalendar_Widget.php';
			add_action( 'widgets_init', create_function( '', 'register_widget( "EventsCalendar_Widget" );' ) );
		}
		//shortcodes
		require_once RHC_PATH.'shortcodes/venues.php';
		new shortcode_venues(RHC_VENUE);
		require_once RHC_PATH.'shortcodes/organizers.php';
		new shortcode_organizers(RHC_ORGANIZER);
		require_once RHC_PATH.'shortcodes/single.php';
		new rhc_single_shortcoes();		

		if( !defined('RHCAJAX') ){
			if('version1'==$this->get_option('template_integration','version2',true)){
				require_once RHC_PATH.'includes/class.rhc_template_frontend_old.php';
			}else{
				require_once RHC_PATH.'includes/class.rhc_template_frontend.php';
			}
			$this->template_frontend = new rhc_template_frontend();
		}
		//require_once RHC_PATH.'includes/class.load_event_template.php';
		//new load_event_template();
		
		require_once RHC_PATH.'includes/class.rhc_custom_field_filters.php';
		new rhc_custom_field_filters();
		
		if(is_admin()){		
			require 'class.plugin_righthere_calendar.plugins_loaded.admin.php';
		}
		
		require_once RHC_PATH.'includes/class.righthere_calendar.php';
		new righthere_calendar(array(
			'show_in_menu'=>true,
			'menu_position'=> ( intval($this->get_option('menu_position',0,true))>0 ? intval($this->get_option('menu_position',0,true)) : null )
		));
		
		if('1'==$this->get_option('enable_theme_thumb','0',true)){
			add_action('init',array(&$this,'add_events_featured_image'));	
		}
		
		if( !defined('RHCAJAX') ){
			require_once RHC_PATH.'includes/class.rhc_calendar_metabox_rrule.php';
			new rhc_calendar_metabox(RHC_EVENTS,$this->debug_menu);
			$post_types = $this->get_option('post_types',array());
			$post_types = is_array($post_types)?$post_types:array();
			$post_types = apply_filters('rhc_calendar_metabox_post_types',$post_types);
			if(is_array($post_types)&&count($post_types)>0){
				foreach($post_types as $post_type){
					new rhc_calendar_metabox($post_type,$this->debug_menu);
				}
			}	
		}
		
		if( PHP_VERSION_ID >= 50300 && '1'==$this->get_option('enable_rrecur','1',true)){
			require_once RHC_PATH.'includes/class.rhc_recurr.php';
			new rhc_recurr(array(
				'path' => RHC_PATH
			));
		}
		
		if( '1'==$this->get_option('enable_rhc_og','1',true) ){
			require_once RHC_PATH.'includes/class.rhc_single_og.php';
			new rhc_single_og();		
		}
		
		require_once RHC_PATH.'includes/compat_fixes.php';
		
		if( defined('WPB_VC_VERSION') && '1'==$this->get_option('enable_rhc_vc','1',true) ){
			require_once RHC_PATH.'includes/class.rhc_visual_composer.php';
			new rhc_visual_composer( array( 'url' => RHC_URL ) );
			if( '1'==$this->get_option('enable_rhc_vc_sub','1',true) ){
				require_once RHC_PATH.'includes/class.rhc_visual_composer_subcategories.php';
				new rhc_visual_composer_subcategories( array( 'url' => RHC_URL ) );
			}			
		}
		
	}
	
	function add_events_featured_image(){
		add_theme_support( 'post-thumbnails' );
	}
	
	function get_option($name,$default='',$default_if_empty=false){
		$value = isset($this->options[$name])?$this->options[$name]:$default;
		if($default_if_empty){
			$value = ''==$value?$default:$value;
		}
		return $value;
	}	
	
	function update_option($name,$value){
		$options = get_option($this->options_varname);
		$options[$name]=$value;
		update_option($this->options_varname, $options);
		//--update plugin object options
		$this->options = get_option($this->options_varname);
		$this->options = is_array($this->options)?$this->options:array();	
	}
	
	function get_intervals(){//deprecated
		return array(
					''			=> __('Never (Not a recurring event)','rhc'),
					'1 DAY'		=> __('Every day','rhc'),
					'1 WEEK'	=> __('Every week','rhc'),
					'2 WEEK'	=> __('Every 2 weeks','rhc'),
					'1 MONTH'	=> __('Every month','rhc'),
					'1 YEAR'	=> __('Every year','rhc')
				);
	}	
	
	static function get_rrule_freq(){
		return apply_filters('get_rrule_freq',array(
					''							=> __('Never (Not a recurring event)','rhc'),
					/*'FREQ=DAILY;INTERVAL=1;COUNT=1'	=> __('Arbitrary repeat dates','rhc'),*/
					'FREQ=DAILY;INTERVAL=1'	=> __('Every day','rhc'),
					'FREQ=WEEKLY;INTERVAL=1'	=> __('Every week','rhc'),
					'FREQ=WEEKLY;INTERVAL=2'	=> __('Every 2 weeks','rhc'),
					'FREQ=MONTHLY;INTERVAL=1'	=> __('Every month','rhc'),
					'FREQ=YEARLY;INTERVAL=1'	=> __('Every year','rhc')
				));
	}
	
	function get_template_path($file=''){
		$path = RHC_PATH.'templates/default/'.$file;
		return apply_filters('rhc_template_path',$path,$file);
	}
	
	function get_settings_path($file=''){
		$path = RHC_PATH.'settings/default/'.$file;
		return apply_filters('rhc_settings_path',$path,$file);
	}
	
	function is_template_set(){
		if( 'version2'==$this->get_option('template_integration','version2',true) ){		
			if( '' == $this->get_option('event_template_page_id','',true) ){
				return false;
			}
		}	
		return true;
	}
	
	function is_shortcode_set(){
		global $wpdb;
		$sql = "SELECT COALESCE( (SELECT 1 FROM `{$wpdb->posts}` WHERE post_status='publish' AND post_content LIKE \"%[calendarizeit%\" LIMIT 1), 0) ";
		if( $wpdb->get_var($sql,0,0) ){
			return true;
		}else{
			return false;
		}
	}	
	
	function get_save_post_priority( $offset=0 ){
		$option = $this->get_option('save_post_priority', '', true);
		if( 'high' == $option ){
			return 3 + $offset;
		}else if( 'max' == $option ){
			return 1 + $offset;
		}else{
			return 10 + $offset;
		}
	}
}
?>