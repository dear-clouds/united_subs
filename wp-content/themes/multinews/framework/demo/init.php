<?php
/**
 * Version 0.0.2
 */

require_once(  dirname( __FILE__ ) .'/importer/radium-importer.php' ); //load admin theme data importer

class Radium_Theme_Demo_Data_Importer extends Radium_Theme_Importer {

    /**
     * Holds a copy of the object for easy reference.
     *
     * @since 0.0.1
     *
     * @var object
     */
    private static $instance;
    
    /**
     * Set the key to be used to store theme options
     *
     * @since 0.0.2
     *
     * @var object
     */
    public $theme_option_name = 'mom_options'; //set theme options name here
		
	public $theme_options_file_name = 'options.json';
	
	public $widgets_file_name 		=  'widgets.json';
	
	public $content_demo_file_name  =  'content.xml';
	

	public $theme_options_rtl_file_name = 'options-rtl.json';
	
	public $widgets_rtl_file_name 		=  'widgets-rtl.json';
	
	public $content_demo_rtl_file_name  =  'content-rtl.xml';

	/**
	 * Holds a copy of the widget settings 
	 *
	 * @since 0.0.2
	 *
	 * @var object
	 */
	public $widget_import_results;
	
    /**
     * Constructor. Hooks all interactions to initialize the class.
     *
     * @since 0.0.1
     */
    public function __construct() {
    
		$this->demo_files_path = dirname(__FILE__) . '/demo-files/';

        self::$instance = $this;
		parent::__construct();

    }
	
	/**
	 * Add menus
	 *
	 * @since 0.0.1
	 */
	public function set_demo_menus(){

		// Menus to Import and assign - you can remove or add as many as you want
		$top_menu = get_term_by('name', 'Top Menu', 'nav_menu');
		$main_menu = get_term_by('name', 'Main Menu', 'nav_menu');
	
		$locations = array(
				'main' => $main_menu->term_id,
				'topnav' => $top_menu->term_id,
			);
		set_theme_mod('nav_menu_locations', $locations);


	}
	public function set_home_page()
	{

		// set the home page
		$home = get_page_by_title('Home Page');

		if (is_object($home)) {
			update_option('show_on_front', 'page');
			update_option('page_on_front', $home->ID);
		}

		// remove hello world post
		wp_delete_post( 1, true );

		// remove default sidebars widgets 
		$widgets = get_option('sidebars_widgets');
		$widgets['right-sidebar'] = '';

		update_option('sidebars_widgets', $widgets);

		// update permalinks
		update_option('permalink_structure', '/%year%/%monthnum%/%postname%/');

	}

	public function set_demo_custom_sidebars() {
		
		$sidebars = array(
					'Mainsidebar2' => 'Main sidebar2',
					'Secondarysidebar2' => 'Secondary sidebar2',
					'Adssidebar1' => 'Ads sidebar1',
					'Adssidebar2' => 'Ads sidebar2',
					'woocommerce' => 'woocommerce',
					'ratiosidebar' => 'ratio sidebar',
					'ratiossidebar' => 'ratio ssidebar',
					'dwm' => 'dwm',
					'dws' => 'dws',
					'bbpress' => 'bbpress',
					'buddypress' => 'buddypress',
					'features' => 'features',
					'test' => 'test',

					'sec1' => 'sec1',
					'main1' => 'main1',
					'ads' => 'ads',
					'woocommerce' => 'woocommerce',
					'ads2' => 'ads2',
					
			);

		update_option('sbg_sidebars', $sidebars);
	
	}


}

new Radium_Theme_Demo_Data_Importer;