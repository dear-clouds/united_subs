<?php
/**
 * Options panel Config File
 */

// This is your option name where all the Redux data is stored.
$opt_name = "kleo_" . KLEO_DOMAIN;
$args = array();

// BEGIN Config

// Setting dev mode to true allows you to view the class settings/info in the panel.
// Default: true
$args['dev_mode'] = false;
// Set the icon for the dev mode tab.
// If $args['icon_type'] = 'image', this should be the path to the icon.
// If $args['icon_type'] = 'iconfont', this should be the icon name.
// Default: info-sign
//$args['dev_mode_icon'] = 'info-sign';

// Set the class for the dev mode tab icon.
// This is ignored unless $args['icon_type'] = 'iconfont'
// Default: null
$args['dev_mode_icon_class'] = 'icon-large';

// Set a custom option name. Don't forget to replace spaces with underscores!
$args['opt_name'] = $opt_name;

/** AJAX saving theme options. Disable it in child theme if you encounter problems
 * Code example: add_filter( 'kleo_theme_options_ajax', '__return_false' ); */

$args['ajax_save'] = apply_filters( 'kleo_theme_options_ajax', false );

$args['global_variable'] = false;
$args['compiler'] = false;
$args['output'] = false;
$args['customizer'] = false;
$args['disable_tracking'] = true;
$theme = wp_get_theme();

$args['display_name'] = $theme->get('Name');
//$args['database'] = "theme_mods_expanded";
$args['display_version'] = $theme->get('Version');

// If you want to use Google Webfonts, you MUST define the api key.
$args['google_api_key'] = '';
$args['google_update_weekly'] = false;

// Set the class for the import/export tab icon.
// This is ignored unless $args['icon_type'] = 'iconfont'
// Default: null
$args['import_icon_class'] = 'icon-large';

/**
 * Set default icon class for all sections and tabs
 * @since 3.0.9
 */
$args['default_icon_class'] = 'icon-large';

// Set a custom menu icon.
//$args['menu_icon'] = '';

// Set a custom title for the options page.
// Default: Options
$args['menu_title'] = __('Theme options', 'kleo_framework');

// Set a custom page title for the options page.
// Default: Options
$args['page_title'] = __('Theme options', 'kleo_framework');

// Set a custom page slug for options page (wp-admin/themes.php?page=***).
// Default: redux_options
$args['page_slug'] = 'kleo_options';

$args['default_show'] = true;
$args['default_mark'] = '*';

// Add HTML before the form.
$demo_link = admin_url( 'themes.php?page=kleo_import' );
$args['intro_text'] = sprintf( __('<p>Theme customisations are done here. Make sure to <a target="_blank" href="%s">Import Demo Content</a> first</p>', 'kleo_framework'), $demo_link );

// Set footer/credit line.
$args['footer_credit'] = ' ';
$args['page_permissions'] = 'manage_options';



$args['hints'] = array(
	'icon'              => 'el el-question-sign',
	'icon_position'     => 'left',
	'icon_color'        => '#348DFC',
	'icon_size'         => 'normal',

	'tip_style'         => array(
		'color'     => 'light',
		'shadow'    => true,
		'rounded'   => false,
		'style'     => '',
	),
	'tip_position'      => array(
		'my' => 'top left',
		'at' => 'bottom left',
	),
	'tip_effect' => array(
		'show' => array(
			'effect'    => 'slide',
			'duration'  => '500',
			'event'     => 'mouseover',
		),
		'hide' => array(
			'effect'    => 'slide',
			'duration'  => '500',
			'event'     => 'click mouseleave',
		),
	),
);


/* ----------------------------------------------------------------
  DEFAULT Header Colors
-----------------------------------------------------------------*/

$customizer_teaser = sprintf(__('<br><strong>It is advised to use <a href="%s">Customizer</a> to live preview these color settings in your site.</strong>', 'kleo_framework'), admin_url('customize.php'));

//Description
$style_defaults['header']['desc'] = __('Style your Header section(Logo, menu) with color and background settings. ' .
                                       'This affects the Top bar section too', 'kleo_framework') .
                                    '<br>' . $customizer_teaser;
//Text color
$style_defaults['header']['text'] = "#444444";
//Headings color
$style_defaults['header']['headings'] = "#111111";
//Background color
$style_defaults['header']['bg'] = "#ffffff";
//Link color
$style_defaults['header']['link'] = "#444444";
//Hover link color
$style_defaults['header']['link_hover'] = "#777777";
//Highlight color
$style_defaults['header']['high_color'] = "#ffffff";
//Highlight hover color
$style_defaults['header']['high_bg'] = "#00b9f7";
//Border color
$style_defaults['header']['border'] = "#e5e5e5";

//Alternate Background color
$style_defaults['header']['alt_bg'] = "#f7f7f7";
//Alternate Border color
$style_defaults['header']['alt_border'] = "#e5e5e5";



/* ----------------------------------------------------------------
    Main Colors
-----------------------------------------------------------------*/

//Description
$style_defaults['main']['desc'] = __('Style your Main site section with color and background settings. ' .
                                     'This includes the sidebar too.', 'kleo_framework') .
                                  '<br>' . $customizer_teaser;
//Text color
$style_defaults['main']['text'] = "#777777";
//Headings color
$style_defaults['main']['headings'] = "#444444";
//Background color
$style_defaults['main']['bg'] = "#ffffff";
//Link color
$style_defaults['main']['link'] = "#367bb7";
//Hover link color
$style_defaults['main']['link_hover'] = "#00b9f7";
//Highlight color
$style_defaults['main']['high_color'] = "#ffffff";
//Highlight hover color
$style_defaults['main']['high_bg'] = "#00b9f7";
//Border color
$style_defaults['main']['border'] = "#e5e5e5";

//Alternate Background color
$style_defaults['main']['alt_bg'] = "#f7f7f7";
//Alternate Border color
$style_defaults['main']['alt_border'] = "#e5e5e5";



/* ----------------------------------------------------------------
    Alternate Colors
-----------------------------------------------------------------*/

//Description
$style_defaults['alternate']['desc'] = __('Style your Title / Breadcrumb / Extra information section with color and background settings.', 'kleo_framework') .
                                       '<br>' . $customizer_teaser;
//Text color
$style_defaults['alternate']['text'] = "#777777";
//Headings color
$style_defaults['alternate']['headings'] = "#444444";
//Background color
$style_defaults['alternate']['bg'] = "#f7f7f7";
//Link color
$style_defaults['alternate']['link'] = "#367bb7";
//Hover link color
$style_defaults['alternate']['link_hover'] = "#00b9f7";
//Highlight color
$style_defaults['alternate']['high_color'] = "#ffffff";
//Highlight hover color
$style_defaults['alternate']['high_bg'] = "#00b9f7";
//Border color
$style_defaults['alternate']['border'] = "#e5e5e5";

//Alternate Background color
$style_defaults['alternate']['alt_bg'] = "#ffffff";
//Alternate Border color
$style_defaults['alternate']['alt_border'] = "#e5e5e5";


/* ----------------------------------------------------------------
    Side Menu Colors
-----------------------------------------------------------------*/

//Description
$style_defaults['side']['desc'] = __("Style your Side menu section with color and background settings. " .
                                     "This appears from left/right side of the site", "kleo_framework") .
                                  '<br>' . $customizer_teaser;
//Text color
$style_defaults['side']['text'] = "#777777";
//Headings color
$style_defaults['side']['headings'] = "#aaaaaa";
//Background color
$style_defaults['side']['bg'] = "#1c1c1c";
//Link color
$style_defaults['side']['link'] = "#cccccc";
//Hover link color
$style_defaults['side']['link_hover'] = "#777777";
//Highlight color
$style_defaults['side']['high_color'] = "#ffffff";
//Highlight hover color
$style_defaults['side']['high_bg'] = "#00b9f7";
//Border color
$style_defaults['side']['border'] = "#333333";

//Alternate Background color
$style_defaults['side']['alt_bg'] = "#272727";
//Alternate Border color
$style_defaults['side']['alt_border'] = "#333333";


/* ----------------------------------------------------------------
    Footer Colors
-----------------------------------------------------------------*/

//Description
$style_defaults['footer']['desc'] = __("Style your Footer section with color and background settings. " .
                                       "This is the section with the four columns at the bottom of your site.", "kleo_framework") .
                                    '<br>' . $customizer_teaser;
//Text color
$style_defaults['footer']['text'] = "#777777";
//Headings color
$style_defaults['footer']['headings'] = "#aaaaaa";
//Background color
$style_defaults['footer']['bg'] = "#1c1c1c";
//Link color
$style_defaults['footer']['link'] = "#cccccc";
//Hover link color
$style_defaults['footer']['link_hover'] = "#777777";
//Highlight color
$style_defaults['footer']['high_color'] = "#ffffff";
//Highlight hover color
$style_defaults['footer']['high_bg'] = "#00b9f7";
//Border color
$style_defaults['footer']['border'] = "#333333";

//Alternate Background color
$style_defaults['footer']['alt_bg'] = "#272727";
//Alternate Border color
$style_defaults['footer']['alt_border'] = "#333333";



/* ----------------------------------------------------------------
    Socket Colors
-----------------------------------------------------------------*/

//Description
$style_defaults['socket']['desc'] = __("Style your Socket area with color and background settings. " .
                                       "This is the last section of your site with the Credits information.", "kleo_framework") .
                                    '<br>' . $customizer_teaser;
//Text color
$style_defaults['socket']['text'] = "#515151";
//Headings color
$style_defaults['socket']['headings'] = "#cccccc";
//Background color
$style_defaults['socket']['bg'] = "#171717";
//Link color
$style_defaults['socket']['link'] = "#515151";
//Hover link color
$style_defaults['socket']['link_hover'] = "#777777";
//Highlight color
$style_defaults['socket']['high_color'] = "#ffffff";
//Highlight hover color
$style_defaults['socket']['high_bg'] = "#00b9f7";
//Border color
$style_defaults['socket']['border'] = "#333333";

//Alternate Background color
$style_defaults['socket']['alt_bg'] = "#f7f7f7";
//Alternate Border color
$style_defaults['socket']['alt_border'] = "#272727";


/**
 * Get Default section colors presets
 * @return mixed|null|void
 */
function kleo_get_color_presets() {
	$presets = array(
		'default' => array(
			'alt'     => 'Default',
			'img'     => KLEO_LIB_URI . '/assets/images/presets/default.jpg',
			'presets' => array(
				'text'    => '#777777',
				'headings'    => '#444444',
				'bg'    => '#ffffff',
				'border'    => '#e5e5e5',
				'link'    => '#367bb7',
				'link_hover'    => '#00b9f7',
				'high_color'    => '#ffffff',
				'high_bg'    => '#00b9f7',
				'alt_bg'    => '#f7f7f7',
				'alt_border'    => '#e5e5e5',
			)
		),
		'dark' => array(
			'alt'     => 'Dark',
			'img'     => KLEO_LIB_URI . '/assets/images/presets/dark.jpg',
			'presets' => array(
				'text'    => '#777777',
				'headings'    => '#aaaaaa',
				'bg'    => '#1c1c1c',
				'border'    => '#333333',
				'link'    => '#cccccc',
				'link_hover'    => '#777777',
				'high_color'    => '#ffffff',
				'high_bg'    => '#00b9f7',
				'alt_bg'    => '#272727',
				'alt_border'    => '#333333',
			)
		),
		'amber-brown' => array(
			'alt'     => 'Amber/Brown',
			'img'     => KLEO_LIB_URI . '/assets/images/presets/amber-ac-brown.jpg',
			'presets' => array(
				'text'    => '#000000',
				'headings'    => '#000000',
				'bg'    => '#ffc107',
				'border'    => '#ffca28',
				'link'    => '#000000',
				'link_hover'    => '#616161',
				'high_color'    => '#ffffff',
				'high_bg'    => '#795548',
				'alt_bg'    => '#ffca28',
				'alt_border'    => '#ffca28',
			)
		),
		'blue-orange' => array(
			'alt'     => 'Blue-Gray/Deep-Orange',
			'img'     => KLEO_LIB_URI . '/assets/images/presets/blue-gray-ac-deep-orange.jpg',
			'presets' => array(
				'text'    => '#ffffff',
				'headings'    => '#ffffff',
				'bg'    => '#607d8b',
				'border'    => '#78909c',
				'link'    => '#ffffff',
				'link_hover'    => '#cfd8dc',
				'high_color'    => '#ffffff',
				'high_bg'    => '#ff5722',
				'alt_bg'    => '#78909c',
				'alt_border'    => '#78909c',
			)
		),
		'brown-amber' => array(
			'alt'     => 'Brown/Amber',
			'img'     => KLEO_LIB_URI . '/assets/images/presets/brown-ac-amber.jpg',
			'presets' => array(
				'text'    => '#ffffff',
				'headings'    => '#ffffff',
				'bg'    => '#795548',
				'border'    => '#8d6e63',
				'link'    => '#ffffff',
				'link_hover'    => '#d7ccc8',
				'high_color'    => '#ffffff',
				'high_bg'    => '#ffc107',
				'alt_bg'    => '#8d6e63',
				'alt_border'    => '#8d6e63',
			)
		),
		'green-amber' => array(
			'alt'     => 'Green/Amber',
			'img'     => KLEO_LIB_URI . '/assets/images/presets/green-ac-amber.jpg',
			'presets' => array(
				'text'    => '#ffffff',
				'headings'    => '#ffffff',
				'bg'    => '#4caf50',
				'border'    => '#66bb6a',
				'link'    => '#ffffff',
				'link_hover'    => '#c8e6c9',
				'high_color'    => '#ffffff',
				'high_bg'    => '#ffc107',
				'alt_bg'    => '#66bb6a',
				'alt_border'    => '#66bb6a',
			)
		),
		'indigo-light-blue' => array(
			'alt'     => 'Indigo/Light Blue',
			'img'     => KLEO_LIB_URI . '/assets/images/presets/indigo-ac-light-blue.jpg',
			'presets' => array(
				'text'    => '#ffffff',
				'headings'    => '#ffffff',
				'bg'    => '#3f51b5',
				'border'    => '#5c6bc0',
				'link'    => '#ffffff',
				'link_hover'    => '#c5cae9',
				'high_color'    => '#ffffff',
				'high_bg'    => '#03a9f4',
				'alt_bg'    => '#5c6bc0',
				'alt_border'    => '#5c6bc0',
			)
		),
		'pink-deep-orange' => array(
			'alt'     => 'Pink/Deep Orange',
			'img'     => KLEO_LIB_URI . '/assets/images/presets/pink-ac-deep-orange.jpg',
			'presets' => array(
				'text'    => '#ffffff',
				'headings'    => '#ffffff',
				'bg'    => '#e91e63',
				'border'    => '#ec407a',
				'link'    => '#ffffff',
				'link_hover'    => '#f8bbd0',
				'high_color'    => '#ffffff',
				'high_bg'    => '#ff5722',
				'alt_bg'    => '#ec407a',
				'alt_border'    => '#ec407a',
			)
		),
		'deep-purple-amber' => array(
			'alt'     => 'Deep Purple/Amber',
			'img'     => KLEO_LIB_URI . '/assets/images/presets/deep-purple-ac-amber.jpg',
			'presets' => array(
				'text'    => '#ffffff',
				'headings'    => '#ffffff',
				'bg'    => '#673ab7',
				'border'    => 'transparent',
				'link'    => '#ffffff',
				'link_hover'    => '#d1c4e9',
				'high_color'    => '#ffffff',
				'high_bg'    => '#ffc107',
				'alt_bg'    => '#7e57c2',
				'alt_border'    => '#7e57c2',
			)
		),
	);

	return apply_filters('section_color_presets', $presets);
}

/**
 * Return the prepared array for the color presets sections
 * @param string $name
 *
 * @return mixed|null|void
 */
function kleo_get_color_presets_array( $name ) {
	$color_sets = kleo_get_color_presets();

	if ( $color_sets && ! empty( $color_sets ) ) {
		foreach ( $color_sets as $key => $set ) {
			foreach( $set['presets'] as $preset_key => $preset_value ) {
				$color_sets[$key]['presets'][ $name . $preset_key ] = $preset_value;
				unset($color_sets[$key]['presets'][$preset_key]);
			}
		}
	}

	return $color_sets;
}


global $kleo_config;
$style_sets = $kleo_config['style_sets'];

$style_elements = array(
    array('slug' => 'desc', 'desc' => 'ss', 'type' => 'info'),
    array('slug' => 'preset', 'desc' => 'ss', 'type' => 'preset'),
    array('slug' => 'text', 'title' => 'Text color', 'subtitle' => '', 'desc' => 'Set the text color for this section', 'type' => 'color'),
    array('slug' => 'headings', 'title' => 'Headings color', 'subtitle' => '', 'desc' => 'Set the text color for h1,h2,h3,h4,h5,h6 elements', 'type' => 'color'),
    array('slug' => 'bg', 'title' => 'Background color', 'subtitle' => '', 'desc' => 'Set the background color for this section', 'type' => 'color'),
    array('slug' => 'bg_image', 'title' => 'Background image', 'subtitle' => '', 'desc' => 'Set a background image for this section', 'type' => 'background', 'default' => array()),
    array('slug' => 'border', 'title' => 'Border color', 'subtitle' => '', 'desc' => 'Set the borders color for this section. It affects the border css property for elements in this section', 'type' => 'color', 'default' => ''),
    array('slug' => 'link', 'title' => 'Link color', 'subtitle' => '', 'desc' => 'Select your color for anchor elements(links) for this section', 'type' => 'color'),
    array('slug' => 'link_hover', 'title' => 'Hover link color', 'desc' => 'Select your color for anchor elements(links) when hovered', 'subtitle' => '', 'type' => 'color'),
    array('slug' => 'high_color', 'title' => 'Highlight color', 'desc' => 'Select your text color for highlight elements. It can be the highlight button style, notification bubbles, pricing table popular column or Pin shortcode color', 'subtitle' => '', 'type' => 'color'),
    array('slug' => 'high_bg', 'title' => 'Highlight background color', 'desc' => 'Select your background color for highlight elements. It can be the highlight button style, notification bubbles, pricing table popular column or Pin shortcode color', 'subtitle' => '', 'type' => 'color'),
    array('slug' => 'alt_bg', 'title' => 'Alternate background color', 'desc' => 'This is not very used in the design but is a supplementary color when some elements needed it. It is mostly used on elements hover like tabbed navigation, pagination or disabled inputs.', 'subtitle' => '', 'type' => 'color'),
    array('slug' => 'alt_border', 'title' => 'Alternate border color', 'desc' => 'This is not very used in the design but is a supplementary color when some elements needed it. It is mostly used on elements hover like tabbed navigation, pagination or disabled inputs.', 'subtitle' => '', 'type' => 'color')
);


$sections = array();
$sections[] = array(
		'icon' => 'el-icon-home',
		'icon_class' => 'icon-large',
		'title' => __('General settings', 'kleo_framework'),
        'customizer' => false,
		'desc' => __('<p class="description">Here you will set your site-wide preferences.</p>', 'kleo_framework'),
		'fields' => array(
				
			array(
					'id' => 'maintenance_mode',
					'type' => 'switch',
					'title' => __('Enable maintenance mode.', 'kleo_framework'), 
					'subtitle' => __('Site visitors will see a banner with the message you set bellow.', 'kleo_framework'),
					'default' => '0' // 1 = checked | 0 = unchecked
			),
			array(
					'id' => 'maintenance_msg',
					'type' => 'textarea',
					'required' => array('maintenance_mode','equals','1'),	
					'title' => __('Message to show in maintenance mode', 'kleo_framework'), 
					'subtitle' => '',
					'desc' => '',
					'default' => 'We are currently in maintenance mode. Please check back later.'
			),				
				
			array(
					'id' => 'logo',
					'type' => 'media',
					'url'=> true,
					'readonly' => false,
					'title' => __('Logo', 'kleo_framework'), 
					'subtitle' => __('Upload your own logo.', 'kleo_framework'),
					'default' => ''
			),
			array(
					'id' => 'logo_retina',
					'type' => 'media',
					'url'=> true,
					'readonly' => false,
					'title' => __('Logo Retina', 'kleo_framework'), 
					'subtitle' => __('Upload retina logo. This is optional and should be double in size than normal logo.', 'kleo_framework'),
			),
			array(
					'id' => 'favicon',
					'type' => 'media',
					'url'=> true,
					'readonly' => false,
					'title' => __('Favicon', 'kleo_framework'), 
					'subtitle' => __('image that will be used as favicon (32px32px).', 'kleo_framework'),
					'default' => array('url'=> get_template_directory_uri().'/assets/ico/favicon.png')
			),
			array(
					'id' => 'apple57',
					'type' => 'media',
					'url'=> true,
					'readonly' => false,
					'title' => __('Apple Iphone Icon', 'kleo_framework'), 
					'subtitle' => __('Apple Iphone Icon (57px 57px).', 'kleo_framework'),
					'default' => array('url'=> get_template_directory_uri().'/assets/ico/apple-touch-icon-57-precomposed.png')
			),
			array(
					'id' => 'apple114',
					'type' => 'media',
					'url'=> true,
					'readonly' => false,
					'title' => __('Apple Iphone Retina Icon', 'kleo_framework'), 
					'subtitle' => __('Apple Iphone Retina Icon (114px 114px).', 'kleo_framework'),
					'default' => array('url'=> get_template_directory_uri().'/assets/ico/apple-touch-icon-114-precomposed.png')
			),     
			array(
					'id' => 'apple72',
					'type' => 'media',
					'url'=> true,
					'readonly' => false,
					'title' => __('Apple iPad Icon', 'kleo_framework'), 
					'subtitle' => __('Apple Iphone Retina Icon (72px 72px).', 'kleo_framework'),
					'default' => array('url'=> get_template_directory_uri().'/assets/ico/apple-touch-icon-72-precomposed.png')
			),    
			array(
					'id' => 'apple144',
					'type' => 'media',
					'url'=> true,
					'readonly' => false,
					'title' => __('Apple iPad Retina Icon', 'kleo_framework'), 
					'subtitle' => __('Apple iPad Retina Icon (144px 144px).', 'kleo_framework'),
					'default' => array('url'=> get_template_directory_uri().'/assets/ico/apple-touch-icon-144-precomposed.png')
			),

			array(
					'id' => 'analytics',
					'type' => 'textarea',
					'title' => __('JavaScript code', 'kleo_framework'), 
					'subtitle' => __('Paste your Google Analytics, other tracking code or any script you need.<br/> This will be loaded in the footer.', 'kleo_framework'),
					'desc' => ''
			),
			
			array(
					'id' => 'quick_css',
					'type' => 'textarea',
					'title' => __('Quick css', 'kleo_framework'), 
					'subtitle' => __('Place you custom css here', 'kleo_framework'),
					'desc' => ''
			),   
				
			array(
					'id' => 'socket_enable',
					'type' => 'switch',
					'title' => __('Enable socket text', 'kleo_framework'), 
					'subtitle' => __('Enable text under the footer widgets area', 'kleo_framework'),
					'default' => '1' // 1 = checked | 0 = unchecked
			),
				
			array(
				'id'=>'footer_text',
				'type' => 'editor',
				'required' => array('socket_enable','equals','1'),	
				'title' => __('Footer Text', 'kleo_framework'), 
				'subtitle' => __('You can use shortcodes in your footer text like: [site-url] [current-year]', 'kleo_framework'),
				'default' => '<p style="text-align: center;"><strong>&copy;[current-year] KLEO Template</strong> a premium and multipurpose theme from <a href="http://www.seventhqueen.com" target="_blank">Seven<sup>th</sup> Queen</a></p>',
				),

		)
);

$sections[] = array(
		'icon' => 'el-icon-website',
		'icon_class' => 'icon-large',
		'title' => __('Layout settings', 'kleo_framework'),
        'customizer' => false,
		'desc' => __('<p class="description">Here you set options for the layout.</p>', 'kleo_framework'),

		'fields' => array(

            array(
                    'id' => 'site_style',
                    'type' => 'button_set',
                    'title' => __('Site Layout', 'kleo_framework'),
                    'subtitle' => __('Select between wide or boxed site layout', 'kleo_framework'),
                    'options' => array(
                            'wide' => 'Wide', 'boxed' => 'Boxed'
                    ),
                    'default' => 'wide'
            ),
            array(
                'id' => 'boxed_size',
                'type' => 'select',
                'required' => array('site_style','equals','boxed'),
                'title' => __('Site Width', 'kleo_framework'),
                'subtitle' => 'Select the width for the site when using boxed version',
                'options' => array('1440' => '1440px', '1200' => '1200px', '1024' => '1024px'),
                'default' => '1440'
            ),

			//BOXED BACKGROUND
			array(
					'id'=>'body_bg',
					'type' => 'background',
					'tiles' => true,
					'required' => array('site_style','equals','boxed'),
					'title' => __('- Background', 'kleo_framework'),
					'subtitle'=> __('Select your boxed background', 'kleo_framework'),
					'default' => array('background-image' => get_template_directory_uri() . '/assets/img/bg-body.gif', 'background-repeat' => 'repeat' ),
					'preview' => false,
					'preview_media' => true
				),

            array(
                    'id' => 'global_sidebar',
                    'type' => 'image_select',
                    'compiler'=>true,
                    'title' => __('Main Layout', 'kleo_framework'),
                    'subtitle' => __('Select main content and sidebar alignment. Choose between 1, 2 or 3 column layout.', 'kleo_framework'),
                    'options' => array(
                            'no' => array('alt' => 'No sidebar', 'img' => KLEO_URI . '/options/assets/img/1col.png'),
                            'left' => array('alt' => '2 Column Left', 'img' => KLEO_URI . '/options/assets/img/2cl.png'),
                            'right' => array('alt' => '2 Column Right', 'img' => KLEO_URI . '/options/assets/img/2cr.png'),
                            '3lr' => array('alt' => '3 Column Middle', 'img' => KLEO_URI . '/options/assets/img/3cm.png'),
                            '3ll' => array('alt' => '3 Column Left', 'img' => KLEO_URI . '/options/assets/img/3cl.png'),
                            '3rr' => array('alt' => '3 Column Right', 'img' => KLEO_URI . '/options/assets/img/3cr.png')
                        ),
                    'default' => 'right'
            ),

				array(
					'id' => 'main_width_2cols',
					'type' => 'select',
					'title' => __('Main content width for one sidebar templates', 'kleo_framework'),
					'subtitle' => 'Select the width for the main container used in templates with just one sidebar like "Right Sidebar"',
					'options' => array('6' => '50%', '7' => '58.3%', '8' => '67%',  '9' => '75%'),
					'default' => '9'
				),
				array(
					'id' => 'main_width_3cols',
					'type' => 'select',
					'title' => __('Main content width for two sidebars templates', 'kleo_framework'),
					'subtitle' => 'Select the width for the main container used in templates with two sidebars like "Two left sidebars"',
					'options' => array('4' => '33%', '6' => '50%', '8' => '67%'),
					'default' => '6'
				),

				array(
						'id' => 'go_top',
						'type' => 'switch',
						'title' => __('Enable Go Up button', 'kleo_framework'),
						'subtitle' => __('Enable or disable the button in the right down corner that takes you to the top of the screen.', 'kleo_framework'),
						'default' => '1' // 1 = checked | 0 = unchecked
				),

			 array(
						'id' => 'title_location',
						'type' => 'button_set',
						'compiler'=>true,
						'title' => __('Page Title location', 'kleo_framework'),
						'subtitle' => __('Choose where to show page title. In the breadcrumb section or in the main content', 'kleo_framework'),
						'options' => array('breadcrumb' => 'Breadcrumb section', 'main' => 'Main section'),
						'default' => 'breadcrumb'
				),

				array(
						'id' => 'contact_form',
						'type' => 'switch',
						'title' => __('Enable Contact form', 'kleo_framework'),
						'subtitle' => __('Enable or disable the contact form bottom screen', 'kleo_framework'),
						'default' => '1' // 1 = checked | 0 = unchecked
				),
				array(
						'id' => 'contact_form_builtin',
						'type' => 'switch',
						'required' => array('contact_form','equals','1'),
						'title' => __('Built-in Contact Form', 'kleo_framework'),
						'subtitle' => __('Enable or disable the built-in contact form. You can choose to disable it if you want to use your own custom form by adding shortcodes in the Contact Form Text box below.', 'kleo_framework'),
						'default' => '1' // 1 = checked | 0 = unchecked
				),
			array(
				'id' => 'contact_form_to',
				'type' => 'text',
				'required' => array('contact_form','equals','1'),
				'title' => __('TO email', 'kleo_framework'),
				'subtitle' => __('Enter a valid email address where the emails are sent to', 'kleo_framework'),
				'desc' => '',
				'default' => ''
				),

			array(
				'id' => 'contact_form_title',
				'type' => 'text',
				'required' => array('contact_form','equals','1'),
				'title' => __('Contact form title', 'kleo_framework'),
				'sub_desc' => "",
				'desc' => '',
				'default' => 'CONTACT US'
				),
			array(
				'id' => 'contact_form_text',
				'type' => 'textarea',
				'required' => array('contact_form','equals','1'),
				'title' => __('Contact form text', 'kleo_framework'),
				'subtitle' => __('Enter the content to show in the contact floating box. You can even use shortcodes to output whatever you like in it.', 'kleo_framework'),
				'sub_desc' => "",
				'desc' => '',
				'default' => "We're not around right now. But you can send us an email and we'll get back to you, asap."
				),

		)

);


$sections[] = array(
	'icon' => 'el-icon-plus',
	'icon_class' => 'icon-large',
	'title' => __('Modules', 'kleo_framework'),
	'customizer' => false,
	'desc' => '<p class="description">' . __('Choose what modules to enable on your site. Make sure to leave only used modules active to increase performance!', 'kleo_framework') . '</p>',
	'fields' => array(

		array(
			'id' => 'module_testimonials',
			'type' => 'switch',
			'title' => __('Testimonials module', 'kleo_framework'),
			'subtitle' => __('Enable testimonials module.', 'kleo_framework'),
			'default' => '1' // 1 = checked | 0 = unchecked
		),
		array(
			'id' => 'module_clients',
			'type' => 'switch',
			'title' => __('Clients module', 'kleo_framework'),
			'subtitle' => __('Enable clients module.', 'kleo_framework'),
			'default' => '1' // 1 = checked | 0 = unchecked
		),
		array(
			'id' => 'module_portfolio',
			'type' => 'switch',
			'title' => __('Portfolio module', 'kleo_framework'),
			'subtitle' => __('Enable portfolio module.', 'kleo_framework'),
			'default' => '1' // 1 = checked | 0 = unchecked
		),
	)
);

/* Get post types for Search scope */
function kleo_search_scope_post_types() {
    $scope_atts = array();
    $scope_atts['extra'] = array();
    if (function_exists('bp_is_active')) {
        $scope_atts['extra']['members'] = 'Members';
        $scope_atts['extra']['groups'] = 'Groups';
    }
    $scope_atts['extra']['post'] = 'Posts';
    $scope_atts['extra']['page'] = 'Pages';
    $scope_atts['exclude'] = array('kleo_clients', 'kleo-testimonials', 'topic', 'reply');

    return kleo_post_types( $scope_atts );
}

$sections[] = array(
    'icon' => 'el-icon-lines',
    'icon_class' => 'icon-large',
    'title' => __('Header options', 'kleo_framework'),
    'customizer' => false,
		'desc' => __('<p class="description">Customize header appearance</p>', 'kleo_framework'),
		'fields' => array(
            array(
                'id' => 'header_layout',
                'type' => 'image_select',
                'title' => __('Header Layout', 'kleo_framework'),
                'subtitle' => __('Select how you want your header format', 'kleo_framework'),
                'options' => array(
                    'normal' => array('alt' => 'Normal header', 'img' => KLEO_FW_URI . '/assets/img/normal-logo.png'),
                    'right_logo' => array('alt' => 'Right logo', 'img' => KLEO_FW_URI . '/assets/img/right-logo.png'),
                    'center_logo' => array('alt' => 'Center logo', 'img' => KLEO_FW_URI . '/assets/img/center-logo.png'),
                    'left_logo' => array('alt' => 'Left logo and menu', 'img' => KLEO_FW_URI . '/assets/img/left-logo.png'),
                ),
                'default' => 'normal'
            ),
            array(
                'id'=>'header_banner',
                'type' => 'editor',
                'required' => array('header_layout','equals','left_logo'),
                'title' => __('Header Banner content', 'kleo_framework'),
                'subtitle' => 'You can add content to the banner section in the menu. It can include shortcodes as well.<br> Examples: <br>- show main sidebar: [vc_widget_sidebar sidebar_id="sidebar-1"]',
                'default' => 'Banner text/AD here',
            ),
			array(
				'id' => 'menu_full_width',
				'type' => 'switch',
				'title' => __('Main Menu Full Width', 'kleo_framework'),
				'subtitle' => __('Enable full browser width menu style.', 'kleo_framework'),
				'default' => '0' // 1 = checked | 0 = unchecked
			),
			array(
                'id' => 'menu_size',
                'type' => 'text',
                'title' => __('Main Menu Font size', 'kleo_framework'),
                'subtitle' => __('Font size in pixels. Default: 12', 'kleo_framework'),
                'default' => ''
            ),
            array(
                'id' => 'menu_height',
                'type' => 'text',
                'title' => __('Main Menu Height', 'kleo_framework'),
                'subtitle' => __('Set your header height expressed in pixels. Example: 88', 'kleo_framework'),
                'default' => '88'
            ),
            array(
                    'id' => 'show_top_bar',
                    'type' => 'switch',
                    'title' => __('Display top bar', 'kleo_framework'),
                    'subtitle' => __('Enable or disable the top bar.<br> See Social icons tab to enable the social icons inside it.<br> Set a Top menu from  Appearance - Menus ', 'kleo_framework'),
                    'default' => '1' // 1 = checked | 0 = unchecked
            ),
            array(
                'id' => 'top_bar_darker',
                'type' => 'switch',
                'title' => __('Top bar - Darker background', 'kleo_framework'),
                'required' => array('show_top_bar','equals','1'),
                'subtitle' => __('Make the Top bar background a little darker instead of same header color. This is based on Styling options - Header.', 'kleo_framework'),
                'default' => '1' // 1 = checked | 0 = unchecked
            ),
            array(
                    'id' => 'show_lang',
                    'type' => 'switch',
                    'title' => __('Show language switch', 'kleo_framework'),
                    'subtitle' => __('Works only when WPML plugin is enabled.', 'kleo_framework'),
                    'default' => '1' // 1 = checked | 0 = unchecked
            ),
				array(
						'id' => 'sticky_menu',
						'type' => 'switch',
						'title' => __('Sticky Main menu', 'kleo_framework'),
						'subtitle' => __('Enable or disable the sticky menu.', 'kleo_framework'),
						'default' => '1' // 1 = checked | 0 = unchecked
				),
				array(
						'id' => 'resize_logo',
						'type' => 'switch',
						'required' => array('sticky_menu','equals','1'),
						'title' => __('Resize logo on scroll', 'kleo_framework'),
						'subtitle' => __('Enable or disable logo resizing when scrolling down the page', 'kleo_framework'),
						'default' => '1' // 1 = checked | 0 = unchecked
				),
				array(
						'id' => 'transparent_logo',
						'type' => 'switch',
						'required' => array('sticky_menu','equals','1'),
						'title' => __('Transparent Main Menu', 'kleo_framework'),
						'subtitle' => __('Enable or disable main menu background transparency', 'kleo_framework'),
						'description' => __('WARNING: This will be removed as a general option. Enable it from Page edit only.', 'kleo_framework'),
						'default' => '0' // 1 = checked | 0 = unchecked
				),


			array(
				'id' => 'header_overlay_hover',
				'type' => 'switch',
				'title' => __('Increased header opacity when hovered', 'kleo_framework'),
				'subtitle' => __('For transparent header only and when page is not scrolled. When hovering the header area it will become slightly opaque.', 'kleo_framework'),
				'default' => '0', // 1 = checked | 0 = unchecked
				'hint' => array(
						'title'   => 'Preview',
						'content' => '<img width=\'300\' src=\'http://seventhqueen.com/support/files/kleo/doc/header-hover-option.gif\'>'
				),
			),

            array(
                    'id' => 'ajax_search',
                    'type' => 'button_set',
                    'title' => __('Ajax Search in menu', 'kleo_framework'),
                    'options' => array( '0' => 'OFF', '1' => 'ON', 'logged_in' => 'For logged users' ),
                    'subtitle' => __('Enable or disable the button for search.', 'kleo_framework'),
                    'default' => '1' // 1 = checked | 0 = unchecked
            ),
            array(
                'id' => 'search_context',
                'type' => 'select',
                'multi' => true,
                'required' => array('ajax_search','equals','1'),
                'title' => __('Search context', 'kleo_framework'),
                'subtitle' => 'Leave unchecked to search in all content, otherwise check the content you want to appear in the search',
                //'options' => kleo_post_types( $scope_atts ),
                'data' => 'callback',
                'args' => array('kleo_search_scope_post_types'),
                'default' => ''
            ),

            array(
                'id' => 'section-title-breadcrumb',
                'type' => 'section',
                'title' => __( 'Title/Breadcrumb Section', 'kleo_framework' ),
                'subtitle' => __( 'Settings for the title/breadcrumb section that comes just after the menu.<br>To <strong>Style this section</strong> go to Styling options - Alternate', 'kleo_framework' ),
                'indent' => true, // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id' => 'breadcrumb_status',
                'type' => 'switch',
                'title' => __('Show breadcrumb', 'kleo_framework'),
                'subtitle' => __('Enable or disable the site path under the page title.', 'kleo_framework'),
                'default' => '1' // 1 = checked | 0 = unchecked
            ),
            array(
                'id' => 'title_info',
                'type' => 'textarea',
                'title' => __('Main menu info', 'kleo_framework'),
                'sub_desc' => __('This text displays next to the main menu. To disable it just delete the whole text.', 'kleo_framework'),
                'desc' => '',
                'default' => '<em class="muted">feel free to call us</em> &nbsp;&nbsp;<i class="icon-phone"></i> +91.33.26789234 &nbsp;&nbsp;&nbsp;&nbsp;<i class="icon-mail-alt"></i> youremail@yourdomain.com'
            ),
            array(
                'id' => 'title_layout',
                'type' => 'image_select',
                'title' => __('Title/Breadcrumb layout', 'kleo_framework'),
                'subtitle' => __('Select the appearance for the title and breadcrumb section', 'kleo_framework'),
                'options' => array(
                    'normal' => array('alt' => 'Normal', 'img' => KLEO_FW_URI . '/assets/img/normal-title.png'),
                    'right_breadcrumb' => array('alt' => 'Right Breadcrumb', 'img' => KLEO_FW_URI . '/assets/img/right-breadcrumb.png'),
                    'center' => array('alt' => 'Centered', 'img' => KLEO_FW_URI . '/assets/img/center-title.png'),
                ),
                'default' => 'normal'
            ),

            array(
                'id' => 'title_padding',
                'type' => 'spacing',
                'output' => array( '.main-title' ),
                // An array of CSS selectors to apply this font style to
                'mode' => 'padding',
                // absolute, padding, margin, defaults to padding
                //'all' => true,
                // Have one field that applies to all
                //'top' => false, // Disable the top
                'right' => false, // Disable the right
                //'bottom' => false, // Disable the bottom
                'left' => false, // Disable the left
                'units' => 'px', // You can specify a unit value. Possible: px, em, %
                //'units_extended'=> 'true', // Allow users to select any type of unit
                'display_units' => 'true', // Set to false to hide the units if the units are specified
                'title' => __( 'Padding', 'kleo_framework' ),
                'subtitle' => __( 'Set a top/bottom padding for the title section', 'kleo_framework' ),
                'desc' => __( 'Defined in px. Enter values without px', 'kleo_framework' ),
                'default' => array(
                    'padding-top' => '10px',
                    'padding-bottom' => '10px'
                )
            ),

            array(
                'id' => 'section-title-breadcrumb-end',
                'type' => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),




		)
);

$sections[] = array(
    'icon' => 'el-icon-chevron-right',
    'icon_class' => 'icon-large',
    'title' => __('Side Menu', 'kleo_framework'),
    'customizer' => false,
    'desc' => __('<p class="description">Here you can enable side menu.</p>', 'kleo_framework'),
    //'subsection' => true,
    'fields' => array(
        array(
            'id' => 'side_menu',
            'type' => 'switch',
            'title' => __('Enable side menu on your site', 'kleo_framework'),
            'subtitle' => __('This will load the side menu functionality', 'kleo_framework'),
            'description' => 'Make sure to assign a menu from Appearance - Menus - Manage Locations',
            'default' => '0' // 1 = checked | 0 = unchecked
        ),
        array(
            'id' => 'side_menu_button',
            'type' => 'switch',
            'required' => array('side_menu','equals','1'),
            'title' => __('Add toggle button on your main menu', 'kleo_framework'),
            'subtitle' => __('It will appear at the end of your primary menu', 'kleo_framework'),
            'description' => 'Another way to toggle it is by adding this class to any element on the page: open-sidebar<br> You can even <strong>add this class to a menu item</strong> by putting in the Title Attribute input: class=open-sidebar ',
            'default' => '1' // 1 = checked | 0 = unchecked
        ),
        array(
            'id' => 'side_menu_mobile',
            'type' => 'switch',
            'required' => array('side_menu','equals','1'),
            'title' => __('Replace the default Mobile Menu with the Side Menu', 'kleo_framework'),
            'subtitle' => __('When you click the menu icon on mobile, the side menu will open instead of the normal menu', 'kleo_framework'),
            'default' => '0' // 1 = checked | 0 = unchecked
        ),
        array(
            'id' => 'side_menu_position',
            'type' => 'select',
            'required' => array('side_menu','equals','1'),
            'title' => __('Side menu position', 'kleo_framework'),
            'subtitle' => __('Where the side menu will appear', 'kleo_framework'),
            'options' => array('left' => 'Left', 'right' => 'Right'),
            'default' => 'left'
        ),
        array(
            'id' => 'side_menu_type',
            'type' => 'select',
            'required' => array('side_menu','equals','1'),
            'title' => __('Side menu type', 'kleo_framework'),
            'subtitle' => __('Type of side menu appearance', 'kleo_framework'),
            'options' => array('default' => 'Default', 'overlay' => 'Overlay'),
            'default' => 'default'
        ),
        array(
            'id'=>'side_menu_before',
            'type' => 'editor',
            'required' => array('side_menu','equals','1'),
            'title' => __('Before Menu text', 'kleo_framework'),
            'subtitle' => 'You can add a text to show before the menu. It can include shortcodes as well.<br> Examples: <br>- show main sidebar: [vc_widget_sidebar sidebar_id="sidebar-1"]<br> - show social icons: [kleo_social_icons]',
            'default' => '',
        ),
        array(
            'id'=>'side_menu_after',
            'type' => 'editor',
            'required' => array('side_menu','equals','1'),
            'title' => __('After Menu text', 'kleo_framework'),
            'subtitle' => 'You can add a text to show after the menu. It can include shortcodes as well.<br> Examples: <br>- show main sidebar: [vc_widget_sidebar sidebar_id="sidebar-1"]<br> - show social icons: [kleo_social_icons]',
            'default' => '[kleo_social_icons]',
        ),

    )
);

$sections[] = array(
    'icon' => 'el-icon-pencil-alt',
    'icon_class' => 'icon-large',
    'title' => __('Blog', 'kleo_framework'),
    'customizer' => false,
		'desc' => __('<p class="description">Settings related to blog</p>', 'kleo_framework'),
		'fields' => array(

			 array(
                'id' => 'blog_layout',
                'type' => 'image_select',
                'title' => __('Blog Page Layout', 'kleo_framework'),
                'subtitle' => __('Select your blog layout. Choose between 1, 2 or 3 column layout.', 'kleo_framework'),
                'options' => array(
                        'no' => array('alt' => 'No sidebar', 'img' => KLEO_URI . '/options/assets/img/1col.png'),
                        'left' => array('alt' => '2 Column Left', 'img' => KLEO_URI . '/options/assets/img/2cl.png'),
                        'right' => array('alt' => '2 Column Right', 'img' => KLEO_URI . '/options/assets/img/2cr.png'),
                        '3lr' => array('alt' => '3 Column Middle', 'img' => KLEO_URI . '/options/assets/img/3cm.png'),
                        '3ll' => array('alt' => '3 Column Left', 'img' => KLEO_URI . '/options/assets/img/3cl.png'),
                        '3rr' => array('alt' => '3 Column Right', 'img' => KLEO_URI . '/options/assets/img/3cr.png')
                    ),
                'default' => 'right'
				),
			 array(
                'id' => 'cat_layout',
                'type' => 'image_select',
                'title' => __('Categories/Archives Layout', 'kleo_framework'),
                'subtitle' => __('Select your blog categories layout. Choose between 1, 2 or 3 column layout.', 'kleo_framework'),
                'options' => array(
                        'no' => array('alt' => 'No sidebar', 'img' => KLEO_URI . '/options/assets/img/1col.png'),
                        'left' => array('alt' => '2 Column Left', 'img' => KLEO_URI . '/options/assets/img/2cl.png'),
                        'right' => array('alt' => '2 Column Right', 'img' => KLEO_URI . '/options/assets/img/2cr.png'),
                        '3lr' => array('alt' => '3 Column Middle', 'img' => KLEO_URI . '/options/assets/img/3cm.png'),
                        '3ll' => array('alt' => '3 Column Left', 'img' => KLEO_URI . '/options/assets/img/3cl.png'),
                        '3rr' => array('alt' => '3 Column Right', 'img' => KLEO_URI . '/options/assets/img/3cr.png')
                    ),
                'default' => 'right'
				),
            array(
                'id' => 'blog_post_layout',
                'type' => 'select',
                'compiler'=>true,
                'title' => __('Single Post page Layout', 'kleo_framework'),
                'subtitle' => __('Select your Blog post page layout. Choose between 1, 2 or 3 column layout.', 'kleo_framework'),
                'options' => array(
                    'default' => 'Default as in Layout Settings',
                    'no' => 'Full width',
                    'left' => 'Left Sidebar',
                    'right' => 'Right Sidebar',
                    '3lr' => '3 Column, Left and Right Sidebars',
                    '3ll' => '3 Column, 2 Left sidebars',
                    '3rr' => '3 Column, 2 Right sidebars'
                ),
                'default' => 'default'
            ),

			array(
				'id' => 'blog_type',
				'type' => 'select',
				'title' => __('Display type', 'kleo_framework'),
				'subtitle' => __('How your blog posts will display', 'kleo_framework'),
				'options' => $kleo_config['blog_layouts'],
				'default' => 'masonry'
			),

            array(
                'id' => 'blog_columns',
                'type' => 'select',
                'required' => array('blog_type','equals','masonry'),
                'title' => __('Posts per row', 'kleo_framework'),
                'subtitle' => __('How many columns to have in the grid', 'kleo_framework'),
                'options' => array( '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6' ),
                'default' => '3'
            ),
            array(
                'id' => 'blog_switch_layout',
                'type' => 'switch',
                'title' => __('Enable Layout Switcher Icons', 'kleo_framework'),
                'subtitle' => __('Let your visitors switch the layout of the Blog page', 'kleo_framework'),
                'default' => '0' // 1 = checked | 0 = unchecked
            ),
            array(
                'id' => 'blog_enabled_layouts',
                'type' => 'select',
                'multi' => true,
                'title' => __('Enabled Layouts', 'kleo_framework'),
                'required' => array('blog_switch_layout','equals','1'),
                'subtitle' => 'What layouts are available for the user to switch.',
                'options' => $kleo_config['blog_layouts'],
                'default' => array_values(array_flip($kleo_config['blog_layouts']))
            ),
			array(
				'id' => 'featured_content_layout',
				'type' => 'select',
				'title' => __('Featured content display type', 'kleo_framework'),
				'subtitle' => 'Featured articles can be displayed on your Blog page just above regular articles. Just add them a tag named Featured. Change default tag name <a href="' . admin_url( 'customize.php' ) . '">here</a><br>This setting affects the way they are displayed',
				'options' => array('carousel' => 'Carousel', 'grid' => 'Grid'),
				'default' => 'carousel'
			),
            array(
                'id' => 'featured_grid_columns',
                'type' => 'select',
                'title' => __('Featured articles per row', 'kleo_framework'),
                'required' => array('featured_content_layout','equals','grid'),
                'subtitle' => 'Number of articles to show per row.',
                'options' => array( '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6' ),
                'default' => '3'
            ),
            array(
                'id' => 'section-title-blog-meta',
                'type' => 'section',
                'title' => __( 'Meta settings', 'kleo_framework' ),
                'subtitle' => __( 'Enable/disable the display of post meta like author, categories, date', 'kleo_framework' ),
                'indent' => true, // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id' => 'blog_archive_meta',
                'type' => 'switch',
                'title' => __('Display post meta on archive listing', 'kleo_framework'),
                'subtitle' => __('If you want to show meta info in Blog posts listing like Author, Date, Category', 'kleo_framework'),
                'default' => '1' // 1 = checked | 0 = unchecked
            ),
            array(
                'id' => 'blog_meta_status',
                'type' => 'switch',
                'title' => __('Display post meta in Single post page', 'kleo_framework'),
                'subtitle' => __('If enabled it will show post info like author, categories', 'kleo_framework'),
                'default' => '1' // 1 = checked | 0 = unchecked
            ),
			array(
				'id' => 'blog_meta_elements',
				'type' => 'select',
				'multi' => true,
				'title' => __('Display Meta Fields', 'kleo_framework'),
				'subtitle' => __('What fields do you want displayed? Link fields will only work if BuddyPress is active.', 'kleo_framework'),
				'options' => $kleo_config['blog_meta_elements'],
				'default' => $kleo_config['blog_meta_defaults']
			),
            array(
                'id' => 'blog_meta_sep',
                'type' => 'text',
                'title' => __('Post meta separator', 'kleo_framework'),
                'subtitle' => __('Customize your post meta separator.', 'kleo_framework'),
                'default' => ', '
            ),
            array(
                'id' => 'blog_standard_meta',
                'type' => 'select',
                'title' => __( 'Post meta style for standard layout', 'kleo_framework' ),
                'subtitle' => __('How the display meta, left side or under the title. Applies to standard layout only.', 'kleo_framework'),
                'options' => array( 'left' => 'Left side', 'inline' => 'Inline under title' ),
                'default' => 'left'
            ),
			array(
				'id' => 'blog_single_meta',
				'type' => 'select',
				'title' => __( 'Post meta style for single post page', 'kleo_framework' ),
				'subtitle' => __('How the display meta, left side or before content.', 'kleo_framework'),
				'options' => array( 'left' => 'Left side', 'inline' => 'Inline before content' ),
				'default' => 'left'
			),
			array(
				'id' => 'blog_tags_footer',
				'type' => 'switch',
				'title' => __('Display post tags after the content', 'kleo_framework'),
				'subtitle' => __('If enabled it will show post tags after the post content in single pages. Make sure to remove the Tags options above in Display meta fields.', 'kleo_framework'),
				'default' => '0' // 1 = checked | 0 = unchecked
			),
            array(
                'id' => 'section-title-blog-meta-end',
                'type' => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),
			array(
					'id' => 'blog_media_status',
					'type' => 'switch',
					'title' => __('Display media on post page', 'kleo_framework'),
					'subtitle' => __('If you want to show image/gallery/video/audio before the post on single page', 'kleo_framework'),
					'default' => '1' // 1 = checked | 0 = unchecked
			),
			array(
					'id' => 'blog_get_image',
					'type' => 'switch',
					'title' => __('Get Featured image from content', 'kleo_framework'),
					'subtitle' => __('If you have not set a Featured image allow the system to show the first image from post content on archive pages', 'kleo_framework'),
					'default' => '1' // 1 = checked | 0 = unchecked
			),
			array(
					'id' => 'blog_default_image',
					'type' => 'media',
					'url'=> true,
					'readonly' => false,
					'title' => __('Default Featured Image Placeholder', 'kleo_framework'),
					'subtitle' => __('If your post does not have a Featured image set then show a default image on archive pages.', 'kleo_framework'),
			),
            array(
                'id' => 'post_navigation',
                'type' => 'switch',
                'title' => __('Enable post navigation', 'kleo_framework'),
                'subtitle' => __('Display previous and next post navigation', 'kleo_framework'),
                'default' => '1' // 1 = checked | 0 = unchecked
            ),
			array(
					'id' => 'related_posts',
					'type' => 'switch',
					'title' => __('Enable related posts', 'kleo_framework'),
					'subtitle' => __('Display related posts in single blog entry', 'kleo_framework'),
					'default' => '1' // 1 = checked | 0 = unchecked
			),
            array(
					'id' => 'related_custom_posts',
					'type' => 'switch',
					'title' => __('Enable custom posts related', 'kleo_framework'),
					'subtitle' => __('Display related posts in custom post type single entry', 'kleo_framework'),
					'default' => '0' // 1 = checked | 0 = unchecked
			)
		)
);

$sections[] = array(
    'icon' => 'el-icon-file-alt',
    'icon_class' => 'icon-large',
    'title' => __('Pages', 'kleo_framework'),
    'desc' => __('<p class="description">Settings related to Pages</p>', 'kleo_framework'),
    'fields' => array(
        array(
            'id' => 'page_media',
            'type' => 'switch',
            'title' => __('Enable Media on single page', 'kleo_framework'),
            'subtitle' => __('Video, Sound or Image Thumbnail will appear before post content', 'kleo_framework'),
            'default' => '0' // 1 = checked | 0 = unchecked
        ),
        array(
            'id' => 'page_comments',
            'type' => 'switch',
            'title' => __('Enable Page comments', 'kleo_framework'),
            'subtitle' => __('If you enable this make sure you have checked also Settings - Discussion - Allow people to post comments on new articles ', 'kleo_framework'),
            'default' => '0' // 1 = checked | 0 = unchecked
        ),
    )
);


/* Get post types for Search scope */
function kleo_share_post_types() {
    $scope_atts = array();
    $scope_atts['extra'] = array();
    $scope_atts['extra']['post'] = 'Posts';
    $scope_atts['extra']['page'] = 'Pages';
    return kleo_post_types( $scope_atts );
}


$sections[] = array(
    'icon' => 'el-icon-share',
    'icon_class' => 'icon-large',
    'title' => __('Social Share', 'kleo_framework'),
    'customizer' => false,
    'desc' => __('<p class="description">Settings related to Social sharing that appear after post/page content<br>' .
        'NOTE: Woocommerce Wishlist share options are configured from plugin page: WP admin - Woocommerce - Settings - Wishlist</p>', 'kleo_framework'),
    'fields' => array(
        array(
            'id' => 'blog_social_share',
            'type' => 'switch',
            'title' => __('Enable Social share', 'kleo_framework'),
            'subtitle' => __('Display social share icons after single blog entry.', 'kleo_framework'),
            'default' => '1' // 1 = checked | 0 = unchecked
        ),
        array(
            'id' => 'blog_share_types',
            'type' => 'select',
            'multi' => true,
            'required' => array('blog_social_share','equals','1'),
            'title' => __('Social share Post types', 'kleo_framework'),
            'subtitle' => 'Select the post types to enable social sharing for.',
            //'options' => kleo_post_types( $scope_atts ),
            'data' => 'callback',
            'args' => array('kleo_share_post_types'),
            'default' => array( 'post', 'product' )
        ),
        array(
            'id' => 'blog_share_exclude',
            'type' => 'text',
            'required' => array('blog_social_share','equals','1'),
            'title' => __('Exclude social share by Post IDs', 'kleo_framework'),
            'subtitle' => __('List of Post IDs separated by comma to exclude from showing.', 'kleo_framework'),
            'default' => ''
        ),

	    array(
		    'id' => 'blog_social_share_facebook',
		    'type' => 'switch',
		    'title' => __('Enable Facebook sharing', 'kleo_framework'),
		    'subtitle' => __('Show Facebook sharing icon', 'kleo_framework'),
		    'default' => '1' // 1 = checked | 0 = unchecked
	    ),
	    array(
		    'id' => 'blog_social_share_twitter',
		    'type' => 'switch',
		    'title' => __('Enable Twitter sharing', 'kleo_framework'),
		    'subtitle' => __('Show Twitter sharing icon', 'kleo_framework'),
		    'default' => '1' // 1 = checked | 0 = unchecked
	    ),
	    array(
		    'id' => 'blog_social_share_googleplus',
		    'type' => 'switch',
		    'title' => __('Enable Google+ sharing', 'kleo_framework'),
		    'subtitle' => __('Show Google+ sharing icon', 'kleo_framework'),
		    'default' => '1' // 1 = checked | 0 = unchecked
	    ),
	    array(
		    'id' => 'blog_social_share_pinterest',
		    'type' => 'switch',
		    'title' => __('Enable Pinterest sharing', 'kleo_framework'),
		    'subtitle' => __('Show Pinterest sharing icon', 'kleo_framework'),
		    'default' => '1' // 1 = checked | 0 = unchecked
	    ),
	    array(
		    'id' => 'blog_social_share_linkedin',
		    'type' => 'switch',
		    'title' => __('Enable Linkedin sharing', 'kleo_framework'),
		    'subtitle' => __('Show Linkedin sharing icon', 'kleo_framework'),
		    'default' => '0' // 1 = checked | 0 = unchecked
	    ),
	    array(
		    'id' => 'blog_social_share_whatsapp',
		    'type' => 'switch',
		    'title' => __('Enable Whatsapp sharing', 'kleo_framework'),
		    'subtitle' => __('Show Whatsapp sharing icon on mobile and tablet devices', 'kleo_framework'),
		    'default' => '0' // 1 = checked | 0 = unchecked
	    ),
	    array(
		    'id' => 'blog_social_share_mail',
		    'type' => 'switch',
		    'title' => __('Enable Mail sharing', 'kleo_framework'),
		    'subtitle' => __('Show Mail sharing icon', 'kleo_framework'),
		    'default' => '1' // 1 = checked | 0 = unchecked
	    ),

			array(
                'id' => 'likes_status',
                'type' => 'switch',
                'title' => __('Enable post likes', 'kleo_framework'),
                'subtitle' => __('Allow people to like your post', 'kleo_framework'),
                'default' => '1' // 1 = checked | 0 = unchecked
            ),
			array(
                'id' => 'likes_exclude',
                'type' => 'text',
                'required' => array('likes_status','equals','1'),
                'title' => __('Exclude IDs', 'kleo_framework'),
                'subtitle' => __('List of Post IDs separated by comma to exclude from showing likes', 'kleo_framework'),
                'default' => ''
            ),
			array(
                'id' => 'likes_ajax',
                'type' => 'switch',
                'required' => array('likes_status','equals','1'),
                'title' => __('Enable Likes by Ajax', 'kleo_framework'),
                'subtitle' => __('Get the likes count by Ajax if you have cached content. <br> NOTE: Not recommended. This will increase page load DRAMATICALLY.', 'kleo_framework'),
                'default' => '0' // 1 = checked | 0 = unchecked
            ),
			array(
                'id' => 'likes_zero_text',
                'type' => 'text',
                'required' => array('likes_status','equals','1'),
                'title' => __('0 likes text', 'kleo_framework'),
                'subtitle' => __('Text to show in case the post has no likes', 'kleo_framework'),
                'default' => 'likes' // 1 = checked | 0 = unchecked
            ),

			array(
                'id' => 'likes_one_text',
                'type' => 'text',
                'required' => array('likes_status','equals','1'),
                'title' => __('1 like text', 'kleo_framework'),
                'subtitle' => __('Text to show in case the post has 1 like', 'kleo_framework'),
                'default' => 'like' // 1 = checked | 0 = unchecked
            ),
			array(
                'id' => 'likes_more_text',
                'type' => 'text',
                'required' => array('likes_status','equals','1'),
                'title' => __('More than 1 like text', 'kleo_framework'),
                'subtitle' => __('Text to show in case the post has more than 1 like', 'kleo_framework'),
                'default' => 'likes' // 1 = checked | 0 = unchecked
            ),
			array(
                'id' => 'likes_already',
                'type' => 'text',
                'required' => array('likes_status','equals','1'),
                'title' => __('More than 1 like text', 'kleo_framework'),
                'subtitle' => __('Text to show in case user has already liked the post', 'kleo_framework'),
                'default' => 'You already like this' // 1 = checked | 0 = unchecked
            ),
            array(
                'id' => 'like_this_text',
                'type' => 'text',
                'required' => array('likes_status','equals','1'),
                'title' => __('Text on icon hover', 'kleo_framework'),
                'subtitle' => __('Text that shows when hovering the icon', 'kleo_framework'),
                'default' => 'Like this' // 1 = checked | 0 = unchecked
            )
    )
);


$font_fields = array();
$font_sections = array(
		'h1' => array('size' => '36','height' => '48', 'font' => 'Roboto Condensed', 'weight' => '300'),
		'h2' => array('size' => '28','height' => '36', 'font' => 'Roboto Condensed', 'weight' => '300'),
		'h3' => array('size' => '22','height' => '28', 'font' => 'Roboto Condensed', 'weight' => '300'),
		'h4' => array('size' => '18','height' => '28', 'font' => 'Roboto Condensed', 'weight' => '300'),
		'h5' => array('size' => '17','height' => '27', 'font' => 'Roboto Condensed', 'weight' => '300'),
		'h6' => array('size' => '16','height' => '24', 'font' => 'Roboto Condensed', 'weight' => '300'),
		'body' => array('size' => '13','height' => '20', 'font' => 'Open Sans', 'weight' => '400')
	);

foreach ($font_sections as $k => $font) {
	$font_fields[] =	array(
			'id'=>'font_'.$k,
			'type' => 'typography',
			'title' => ucwords($k),
			//'compiler'=>true, // Use if you want to hook in your own CSS compiler
			'google'=>true, // Disable google fonts. Won't work if you haven't defined your google api key
			'font-backup'=>true, // Select a backup non-google font in addition to a google font
			'font-style'=>true, // Includes font-style and weight. Can use font-style or font-weight to declare
			//'subsets'=>false, // Only appears if google is true and subsets not set to false
			//'font-size'=>false,
			//'line-height'=>false,
			//'word-spacing'=>true, // Defaults to false
			//'letter-spacing'=>true, // Defaults to false
			'color'=>false,
			//'preview'=>false, // Disable the previewer
			'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
			'output' => array(), // An array of CSS selectors to apply this font style to dynamically
			'units'=>'px', // Defaults to px
			'subtitle'=> "",
			'default'=> array(
				'font-weight'=>$font['weight'],
				'font-family'=>$font['font'],
				'google' => 'true',
				'font-size'=>$font['size'].'px',
				'line-height'=>$font['height'].'px'),
		);
}

$style_fields = array();
$style_sections = array();

$sections[] = $style_sections[] = array(
    'icon' => 'el-icon-adjust',
    'icon_class' => 'icon-large',
    'title' => __('Styling options', 'kleo_framework'),
    'desc' => '',
    'fields' => array(
        array(
            'id' => 'styling-info',
            'type' => 'info',
            'notice' => true,
            'style' => 'success',
            'desc' => __('Style colors and backgrounds for each section of your site.<br>' .
                         'Start by selecting a sub-menu from the left.', 'kleo_framework') . "<br>" . $customizer_teaser,
        ),
    )
);


/* Generate the Styling options sections */
foreach ($style_sets as $set ) {
    $style_fields = array();

    foreach( $style_elements as $elem ) {
        if ($elem['type'] == 'color') {

            /*if ( $set == 'header' && $elem['slug'] == 'headings' ) {
                continue;
            }*/

            $style_fields[] = array(
                'id'=>'st__'.$set.'__'.$elem['slug'],
                'type' => $elem['type'],
                'title' =>  $elem['title'],
                'subtitle' => $elem['subtitle'],
                'desc' => $elem['desc'],
                'default' => $style_defaults[$set][$elem['slug']]
            );
        }
        elseif($elem['type'] == 'background') {
            $style_fields[] = array(
                'id'=>'st__'.$set.'__'.$elem['slug'],
                'type' => $elem['type'],
                'title' =>  $elem['title'],
                'subtitle' => $elem['subtitle'],
                'desc' => $elem['desc'],
                'default' => $elem['default'],
                'background-color' =>  false,
                'preview' => false,
                'preview_media' => true
            );
        }
        elseif($elem['type'] == 'info') {
            $style_fields[] = array(
                'id'=>'st__'.$set.'__'.$elem['slug'],
                'type' => 'info',
                'notice' => true,
                'style' => 'success',
                'desc' => $style_defaults[$set]['desc']
            );
        } elseif ($elem['type'] == 'preset') {
            $style_fields[] = array(
                'id'=>'st__' . $set . '__' . $elem['slug'],
                'type' => 'image_select',
                'title' =>  'Color presets',
                'subtitle' => 'Change section colors based on these presets',
                'presets'    => true,
                'default'    => 0,
                'options'    => kleo_get_color_presets_array( 'st__' . $set . '__' )
            );
        }
    }

    $sections[] = $style_sections[] = array(
        'icon' => 'el-icon-adjust',
        'icon_class' => 'icon-large',
        'title' => ucfirst( ( $set == 'alternate' ? 'Title/Breadcrumb' : $set ) ),
        'desc' => '',
        'fields' => $style_fields,
        'subsection' => true
    );
}


$sections[] = array(
		'icon' => 'el-icon-fontsize',
		'icon_class' => 'icon-large',
		'title' => __('Fonts', 'kleo_framework'),
		'desc' => __('<p class="description">Customize font options for body text and headings.</p>', 'kleo_framework'),
		'fields' => $font_fields
);

if (sq_option('module_portfolio', 1) == 1 ) {
	$sections[] = array(
		'icon'       => 'el-icon-th-large',
		'icon_class' => 'icon-large',
		'title'      => __( 'Portfolio', 'kleo_framework' ),
		'customizer' => false,
		'desc'       => __( '<p class="description">Portfolio related settings. Please re-save permalinks when changing slugs or archive page.</p>', 'kleo_framework' ),
		'fields'     => array(

			array(
				'id'          => 'portfolio_custom_archive',
				'type'        => 'switch',
				'title'       => __( 'Custom page for Portfolio Archive', 'kleo_framework' ),
				'subtitle'    => 'This means you need to create a page and assign it below. Re-save permalinks from Settings - Permalinks',
				'description' => 'Setting it to ON will take the name and slug from the page assigned.',
				'default'     => '0' // 1 = checked | 0 = unchecked
			),
			array(
				'id'       => 'portfolio_page',
				'type'     => 'select',
				'data'     => 'pages',
				'required' => array( 'portfolio_custom_archive', 'equals', '1' ),
				'title'    => __( 'Portfolio Page', 'kleo_framework' ),
				'subtitle' => "You need to add [kleo_portfolio] shortcode to the page or using Visual Composer.",
				'default'  => ''
			),
			array(
				'id'       => 'portfolio_name',
				'type'     => 'text',
				'required' => array( 'portfolio_custom_archive', 'equals', '0' ),
				'title'    => __( 'Portfolio name', 'kleo_framework' ),
				'subtitle' => "You can replace the name with something else",
				'default'  => 'Portfolio'
			),
			array(
				'id'       => 'portfolio_slug',
				'type'     => 'text',
				'required' => array( 'portfolio_custom_archive', 'equals', '0' ),
				'title'    => __( 'Portfolio link', 'kleo_framework' ),
				'subtitle' => "You can replace the name with something else. This affects your permalink structure so after changing this you must re-save options in Settings - Permalinks",
				'default'  => 'portfolio'
			),
			array(
				'id'       => 'portfolio_style',
				'type'     => 'select',
				'required' => array( 'portfolio_custom_archive', 'equals', '0' ),
				'title'    => __( 'Display style for Portfolio page', 'kleo_framework' ),
				'subtitle' => 'How to display the portfolio listed items ',
				'options'  => array(
					'default' => 'Default',
					'overlay' => 'Overlay'
				),
				'default'  => 'default'
			),
			array(
				'id'       => 'portfolio_title_style',
				'type'     => 'select',
				'required' => array(
					array( 'portfolio_custom_archive', 'equals', '0' ),
					array( 'portfolio_style', 'equals', 'overlay' )
				),
				'title'    => __( 'Title style', 'kleo_framework' ),
				'subtitle' => '',
				'options'  => array(
					'normal' => 'Normal',
					'hover'  => 'Shown only on item hover'
				),
				'default'  => 'normal' // 1 = checked | 0 = unchecked
			),
			array(
				'id'       => 'portfolio_excerpt',
				'type'     => 'switch',
				'required' => array( 'portfolio_custom_archive', 'equals', '0' ),
				'title'    => __( 'Show/Hide subtitle', 'kleo_framework' ),
				'subtitle' => 'Display item excerpt on portfolio page',
				'default'  => '1' // 1 = checked | 0 = unchecked
			),
			array(
				'id'       => 'portfolio_per_row',
				'type'     => 'text',
				'required' => array( 'portfolio_custom_archive', 'equals', '0' ),
				'title'    => __( 'Number of items per row', 'kleo_framework' ),
				'subtitle' => "A number between 2 and 6",
				'default'  => '4'
			),
			array(
				'id'       => 'portfolio_filter',
				'type'     => 'select',
				'required' => array( 'portfolio_custom_archive', 'equals', '0' ),
				'title'    => __( 'Show categories filter on portfolio page', 'kleo_framework' ),
				'subtitle' => '',
				'options'  => array(
					'yes' => 'Yes',
					'no'  => 'No'
				),
				'default'  => 'yes'
			),
			array(
				'id'       => 'portfolio_image',
				'type'     => 'text',
				'required' => array( 'portfolio_custom_archive', 'equals', '0' ),
				'title'    => __( 'Thumbnail image size', 'kleo_framework' ),
				'subtitle' => __( 'Set your portfolio image size in portfolio list. Defined in pixels. If you are using video items, use a 16:9 size format', 'kleo_framework' ),
				'default'  => $kleo_config['post_gallery_img_width'] . "x" . $kleo_config['post_gallery_img_height']
			),
			array(
				'id'          => 'portfolio_video_height',
				'type'        => 'text',
				'title'       => __( 'Portfolio list Video Height', 'kleo_framework' ),
				'description' => __( 'Set your portfolio video height default size. It is used when you only have videos in a page. In portfolio lists where you also have images it will have the image height.', 'kleo_framework' ),
				'subtitle'    => __( "Expressed in pixels. Example: 160", "kleo_framework" ),
				'default'     => '160'
			),
			array(
				'id'       => 'portfolio_slider_action',
				'type'     => 'select',
				'title'    => __( 'Click on Slider images action', 'kleo_framework' ),
				'subtitle' => 'What to do when you click a Slider image on the archive page or from shortcode. Works only for the Slider media type',
				'options'  => array(
					'default' => 'Open portfolio item',
					'modal'   => 'Open big image in modal'
				),
				'default'  => 'default'
			),

			array(
				'id'       => 'section-title-porto-single',
				'type'     => 'section',
				'title'    => __( 'Portfolio Single Item Page', 'kleo_framework' ),
				'subtitle' => __( 'Settings for portfolio item page', 'kleo_framework' ),
				'indent'   => true, // Indent all options below until the next 'section' option is set.
			),
			array(
				'id'       => 'portfolio_media_status',
				'type'     => 'switch',
				'title'    => __( 'Display media on single portfolio page', 'kleo_framework' ),
				'subtitle' => __( 'If you want to show image/gallery/video before the content on single portfolio page', 'kleo_framework' ),
				'default'  => '1' // 1 = checked | 0 = unchecked
			),
			array(
				'id'       => 'portfolio_back_to',
				'type'     => 'switch',
				'title'    => __( 'Show back to Portfolio icon(bottom of single portfolio item page)', 'kleo_framework' ),
				'subtitle' => '',
				'default'  => '1' // 1 = checked | 0 = unchecked
			),
			array(
				'id'       => 'portfolio_comments',
				'type'     => 'switch',
				'title'    => __( 'Enable comments on portfolio single page', 'kleo_framework' ),
				'subtitle' => '',
				'default'  => '0' // 1 = checked | 0 = unchecked
			),
			array(
				'id'       => 'portfolio_navigation',
				'type'     => 'switch',
				'title'    => __( 'Enable portfolio navigation', 'kleo_framework' ),
				'subtitle' => 'Display previous and next portfolio navigation',
				'default'  => '1' // 1 = checked | 0 = unchecked
			),
			array(
				'id'     => 'section-title-porto-single-end',
				'type'   => 'section',
				'indent' => false, // Indent all options below until the next 'section' option is set.
			),
		)
	);
}

$sections[] = array(
    'icon' => 'el-icon-torso',
    'icon_class' => 'icon-large',
    'title' => __('Buddypress', 'kleo_framework'),
    'customizer' => false,
		'desc' => __('<p class="description">Buddypress related settings</p>', 'kleo_framework'),
		'fields' => array(

			array(
					 'id' => 'bp_layout',
					 'type' => 'image_select',
					 'compiler'=>true,
					 'title' => __('Default Layout', 'kleo_framework'),
					 'subtitle' => __('Select your Buddypress pages layout. Choose between 1, 2 or 3 column layout.', 'kleo_framework'),
					 'options' => array(
							 'no' => array('alt' => 'No sidebar', 'img' => KLEO_URI . '/options/assets/img/1col.png'),
							 'left' => array('alt' => '2 Column Left', 'img' => KLEO_URI . '/options/assets/img/2cl.png'),
							 'right' => array('alt' => '2 Column Right', 'img' => KLEO_URI . '/options/assets/img/2cr.png'),
							 '3lr' => array('alt' => '3 Column Middle', 'img' => KLEO_URI . '/options/assets/img/3cm.png'),
							 '3ll' => array('alt' => '3 Column Left', 'img' => KLEO_URI . '/options/assets/img/3cl.png'),
							 '3rr' => array('alt' => '3 Column Right', 'img' => KLEO_URI . '/options/assets/img/3cr.png')
						 ),
					 'default' => 'right'
			 ),
			array(
					 'id' => 'bp_layout_members_dir',
					 'type' => 'select',
					 'compiler'=>true,
					 'title' => __('Members Directory Layout', 'kleo_framework'),
					 'subtitle' => __('Select your Buddypress Members directory layout. Choose between 1, 2 or 3 column layout.', 'kleo_framework'),
					 'options' => array(
							 'default' => 'Default layout as set above',
							 'no' => 'Full width',
							 'left' => 'Left Sidebar',
							 'right' => 'Right Sidebar',
							 '3lr' => '3 Column, Left and Right Sidebars',
							 '3ll' => '3 Column, 2 Left sidebars',
							 '3rr' => '3 Column, 2 Right sidebars'
						 ),
					 'default' => 'default'
			 ),
			array(
					 'id' => 'bp_layout_profile',
					 'type' => 'select',
					 'compiler'=>true,
					 'title' => __('Member Profile Layout', 'kleo_framework'),
					 'subtitle' => __('Select your Member profile layout. Choose between 1, 2 or 3 column layout.', 'kleo_framework'),
					 'options' => array(
							 'default' => 'Default layout as set above',
							 'no' => 'Full width',
							 'left' => 'Left Sidebar',
							 'right' => 'Right Sidebar',
							 '3lr' => '3 Column, Left and Right Sidebars',
							 '3ll' => '3 Column, 2 Left sidebars',
							 '3rr' => '3 Column, 2 Right sidebars'
						 ),
					 'default' => 'default'
			 ),
			array(
					 'id' => 'bp_layout_groups',
					 'type' => 'select',
					 'compiler'=>true,
					 'title' => __('Groups Layout', 'kleo_framework'),
					 'subtitle' => __('Select your Groups pages layout. Choose between 1, 2 or 3 column layout.', 'kleo_framework'),
					 'options' => array(
							 'default' => 'Default layout as set above',
							 'no' => 'Full width',
							 'left' => 'Left Sidebar',
							 'right' => 'Right Sidebar',
							 '3lr' => '3 Column, Left and Right Sidebars',
							 '3ll' => '3 Column, 2 Left sidebars',
							 '3rr' => '3 Column, 2 Right sidebars'
						 ),
					 'default' => 'default'
			 ),
			array(
					 'id' => 'bp_layout_activity',
					 'type' => 'select',
					 'compiler'=>true,
					 'title' => __('Activity Layout', 'kleo_framework'),
					 'subtitle' => __('Select your Activity pages layout. Choose between 1, 2 or 3 column layout.', 'kleo_framework'),
					 'options' => array(
							 'default' => 'Default layout as set above',
							 'no' => 'Full width',
							 'left' => 'Left Sidebar',
							 'right' => 'Right Sidebar',
							 '3lr' => '3 Column, Left and Right Sidebars',
							 '3ll' => '3 Column, 2 Left sidebars',
							 '3rr' => '3 Column, 2 Right sidebars'
						 ),
					 'default' => 'default'
			 ),
			array(
					 'id' => 'bp_layout_register',
					 'type' => 'select',
					 'compiler'=>true,
					 'title' => __('Register page Layout', 'kleo_framework'),
					 'subtitle' => __('Select your Register page layout. Choose between 1, 2 or 3 column layout.', 'kleo_framework'),
					 'options' => array(
							 'default' => 'Default layout as set above',
							 'no' => 'Full width',
							 'left' => 'Left Sidebar',
							 'right' => 'Right Sidebar',
							 '3lr' => '3 Column, Left and Right Sidebars',
							 '3ll' => '3 Column, 2 Left sidebars',
							 '3rr' => '3 Column, 2 Right sidebars'
						 ),
					 'default' => 'default'
			 ),

            array(
						'id' => 'bp_title_location',
						'type' => 'button_set',
						'compiler'=>true,
						'title' => __('Page Title location', 'kleo_framework'),
						'subtitle' => __('Choose where to show page title. In the breadcrumb section or in the main content', 'kleo_framework'),
						'options' => array('default' => 'Site Default', 'breadcrumb' => 'Breadcrumb section', 'main' => 'Main section', 'disabled' => "Disabled"),
						'default' => 'default'
            ),
            array(
                    'id' => 'bp_breadcrumb_status',
                    'type' => 'switch',
                    'title' => __('Show breadcrumb', 'kleo_framework'),
                    'subtitle' => __('Enable or disable the site path under the page title.', 'kleo_framework'),
                    'default' => '1' // 1 = checked | 0 = unchecked
            ),
            array(
                'id' => 'bp_custom_info',
                'type' => 'switch',
                'title' => __('Custom main menu info', 'kleo_framework'),
                'subtitle' => __('Add a custom text in the main menu to show only on Buddypress pages.', 'kleo_framework'),
                'default' => '0' // 1 = checked | 0 = unchecked
            ),
            array(
                'id' => 'bp_title_info',
                'type' => 'textarea',
                'title' => __('Main menu info', 'kleo_framework'),
                'required' => array('bp_custom_info', '=' , '1'),
                'subtitle' => __('This text displays next to the main menu', 'kleo_framework'),
                'desc' => '',
                'default' => '<em class="muted">feel free to call us</em> &nbsp;&nbsp;<i class="icon-phone"></i> +91.33.26789234 &nbsp;&nbsp;&nbsp;&nbsp;<i class="icon-mail-alt"></i> support@seventhqueen.com'
            ),
            array(
                'id' => 'bp_profile_breadcrumb_disable',
                'type' => 'switch',
                'title' => __('Hide Breadcrumb section for Profile pages', 'kleo_framework'),
                'subtitle' => __('If enabled the breadcrumb section will be hidden. Best used when you enable full width profile page below', 'kleo_framework'),
                'default' => '0' // 1 = checked | 0 = unchecked
            ),
            array(
                'id' => 'bp_full_profile',
                'type' => 'switch',
                'title' => __('Enable Full width Profile Header', 'kleo_framework'),
                'subtitle' => __('If enabled it will show the profile Photo in full width', 'kleo_framework'),
                'default' => '0' // 1 = checked | 0 = unchecked
            ),
            array(
                'id' => 'bp_full_group',
                'type' => 'switch',
                'title' => __('Enable Full width Group Header', 'kleo_framework'),
                'subtitle' => __('If enabled it will show the Group Photo section in full width', 'kleo_framework'),
                'default' => '0' // 1 = checked | 0 = unchecked
            ),
            array(
					'id' => 'bp_online_status',
					'type' => 'switch',
					'title' => __('Enable online status', 'kleo_framework'),
					'subtitle' => __('If enabled it will show a colored dot next to each member avatar', 'kleo_framework'),
					'default' => '1' // 1 = checked | 0 = unchecked
			),
            array(
                'id' => 'member_navigation',
                'type' => 'switch',
                'title' => __('Enable member navigation', 'kleo_framework'),
                'subtitle' => __('Display previous and next member navigation', 'kleo_framework'),
                'default' => '1' // 1 = checked | 0 = unchecked
            ),
			array(
					'id' => 'bp_notif_interval',
					'type' => 'text',
					'title' => __('Live Notifications interval', 'kleo_framework'),
					'subtitle' => 'Refresh time in miliseconds for the live menu notification. Default is 20000 which means 20 seconds. Put 0 to disable notifications refresh. Add it to the menu from Appearance - Menus - KLEO section.',
					'default' => '20000' // 1 = checked | 0 = unchecked
			),
			array(
					'id' => 'bp_members_perpage',
					'type' => 'text',
					'title' => __('Members per page', 'kleo_framework'),
					'subtitle' => __('How many members to show per page in the Members Directory', 'kleo_framework'),
					'default' => '24' // 1 = checked | 0 = unchecked
			),
			array(
					'id' => 'bp_groups_perpage',
					'type' => 'text',
					'title' => __('Groups per page', 'kleo_framework'),
					'subtitle' => __('How many groups to show per page in the Groups Directory', 'kleo_framework'),
					'default' => '24' // 1 = checked | 0 = unchecked
			),


		)
);


if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

    $sections[] = array(
        'icon' => 'el-icon-shopping-cart',
        'icon_class' => 'icon-large',
        'title' => __('Woocommerce', 'kleo_framework'),
        'customizer' => false,
        'desc' => '',
        'fields' => array(
            array(
                'id' => 'woo_sidebar',
                'type' => 'select',
                'compiler' => true,
                'title' => __('Woocommerce Pages Layout', 'kleo_framework'),
                'subtitle' => __('Select the layout to use in Woocommerce pages.', 'kleo_framework'),
                'options' => array(
                    'default' => 'Default site layout',
                    'no' => 'Full width',
                    'left' => 'Left Sidebar',
                    'right' => 'Right Sidebar',
                    '3lr' => '3 Column, Left and Right Sidebars',
                    '3ll' => '3 Column, 2 Left sidebars',
                    '3rr' => '3 Column, 2 Right sidebars'
                ),
                'default' => 'default'
            ),
            array(
                'id' => 'woo_cat_sidebar',
                'type' => 'select',
                'compiler' => true,
                'title' => __('Woocommerce Category Layout', 'kleo_framework'),
                'subtitle' => __('Select the layout to use in Woocommerce product listing pages.', 'kleo_framework'),
                'options' => array(
                    'default' => 'Default as set above',
                    'no' => 'Full width',
                    'left' => 'Left Sidebar',
                    'right' => 'Right Sidebar',
                    '3lr' => '3 Column, Left and Right Sidebars',
                    '3ll' => '3 Column, 2 Left sidebars',
                    '3rr' => '3 Column, 2 Right sidebars'
                ),
                'default' => 'default'
            ),
            array(
                'id' => 'woo_cart_location',
                'type' => 'button_set',
                'title' => __('Menu cart location', 'kleo_framework'),
                'subtitle' => __('Shopping Cart in header menu location', 'kleo_framework'),
                'options' => array(
                    'off' => 'Disabled', 'primary' => 'Primary menu', 'top' => 'Top menu'
                ),
                'default' => 'primary'
            ),

            array(
                'id' => 'woo_mobile_cart',
                'type' => 'switch',
                'title' => __('Mobile menu Cart Icon', 'kleo_framework'),
                'subtitle' => __('This will show on mobile menu a shop icon with the number of cart items', 'kleo_framework'),
                'default' => '1' // 1 = checked | 0 = unchecked
            ),

            array(
                'id' => 'woo_image_effect',
                'type' => 'button_set',
                'title' => __('Product image effect', 'kleo_framework'),
                'subtitle' => __('The effect on products listing when hovering an image.', 'kleo_framework'),
                'options' => array(
                    'default' => 'Bottom-Top', 'fade' => 'Fade', 'alt' => 'Left-Right', 'single' => 'No effect'
                ),
                'default' => 'default'
            ),

            array(
                'id' => 'woo_product_animate',
                'type' => 'switch',
                'title' => __('Enable product listing Appear Animation', 'kleo_framework'),
                'subtitle' => __('On product listing the products will have a appear animation.', 'kleo_framework'),
                'default' => '1' // 1 = checked | 0 = unchecked
            ),

            array(
                'id' => 'woo_percentage_badge',
                'type' => 'switch',
                'title' => __('Show percentage badge on products list', 'kleo_framework'),
                'subtitle' => __('This will replace the "Sale" badge with "SAVE UP TO xx%"', 'kleo_framework'),
                'default' => '0' // 1 = checked | 0 = unchecked
            ),
            array(
                'id' => 'woo_percent_color',
                'type' => 'color',
                'required' => array('woo_percentage_badge', '=', '1'),
                'title' => __('Custom Badge color', 'kleo_framework'),
                'subtitle' => '',
                'default' => '#ffffff' // 1 = checked | 0 = unchecked
            ),
            array(
                'id' => 'woo_percent_bg',
                'type' => 'color',
                'required' => array('woo_percentage_badge', '=', '1'),
                'title' => __('Custom Badge Background', 'kleo_framework'),
                'subtitle' => '',
                'default' => '#000000' // 1 = checked | 0 = unchecked
            ),
			array(
				'id' => 'woo_free_badge',
				'type' => 'switch',
				'title' => __('Show free badge on products list', 'kleo_framework'),
				'default' => '1' // 1 = checked | 0 = unchecked
			),

            array(
                'id' => 'woo_new_badge',
                'type' => 'switch',
                'title' => __('Show NEW badge for new products added', 'kleo_framework'),
                'subtitle' => '',
                'default' => '1' // 1 = checked | 0 = unchecked
            ),
			array(
				'id' => 'woo_show_excerpt_single',
				'type' => 'switch',
				'title' => __('Show excerpt on product page', 'kleo_framework'),
				'subtitle' => '',
				'default' => '0' // 1 = checked | 0 = unchecked
			),
            array(
                'id' => 'woo_product_navigation',
                'type' => 'switch',
                'title' => __('Enable product navigation', 'kleo_framework'),
                'subtitle' => 'Display previous and next product navigation',
                'default' => '1' // 1 = checked | 0 = unchecked
            ),
			array(
				'id' => 'woo_buddypress_menus',
				'type' => 'switch',
				'title' => __('Manage account in Buddypress', 'kleo_framework'),
				'subtitle' => __('Integrates "My Account" into Buddypress profile tabs', 'kleo_framework'),
				'default' => '1' // 1 = checked | 0 = unchecked
			),
            array(
                'id' => 'woo_new_days',
                'type' => 'text',
                'required' => array('woo_new_badge', '=', '1'),
                'title' => __('Number of days to treat a product as new', 'kleo_framework'),
                'subtitle' => __('For how many days to show the NEW badge once a product is added to the shop.', 'kleo_framework'),
                'default' => '7' // 1 = checked | 0 = unchecked
            ),

            array(
                'id' => 'woo_catalog',
                'type' => 'button_set',
                'title' => __('Catalog mode', 'kleo_framework'),
                'subtitle' => __('If you enable catalog mode will disable Add To Cart buttons, Checkout and Shopping cart.', 'kleo_framework'),
                'options' => array(
                    '0' => 'No', '1' => 'Yes'
                ),
                'default' => '0'
            ),
            array(
                'id' => 'woo_disable_prices',
                'type' => 'button_set',
                'title' => __('Disable prices', 'kleo_framework'),
                'subtitle' => __('Disable prices on category pages and product page', 'kleo_framework'),
                'options' => array(
                    '0' => 'No', '1' => 'Yes'
                ),
                'required' => array('woo_catalog', '=', '1'),
                'default' => '0'
            ),
            array(
                'id' => 'woo_shop_columns',
                'type' => 'select',
                'title' => __('Shop Products Columns', 'kleo_framework'),
                'subtitle' => __('Select the number of columns to use for products display.', 'kleo_framework'),
                'options' => array(
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6'
                ),
                'default' => '3'
            ),
            array(
                'id' => 'woo_shop_products',
                'type' => 'text',
                'title' => __('Shop Products per page', 'kleo_framework'),
                'subtitle' => __('How many products to show per page', 'kleo_framework'),
                'default' => '15' // 1 = checked | 0 = unchecked
            ),
            array(
                'id' => 'woo_related_columns',
                'type' => 'select',
                'title' => __('Related Products number', 'kleo_framework'),
                'subtitle' => __('Select the number of related products to show on product page.', 'kleo_framework'),
                'options' => array(
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6'
                ),
                'default' => '3'
            ),
            array(
                'id' => 'woo_upsell_columns',
                'type' => 'select',
                'title' => __('Upsell Products number', 'kleo_framework'),
                'subtitle' => __('Select the number of upsell products to show on product page.', 'kleo_framework'),
                'options' => array(
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6'
                ),
                'default' => '3'
            ),
            array(
                'id' => 'woo_cross_columns',
                'type' => 'select',
                'title' => __('Cross-sell Products number', 'kleo_framework'),
                'subtitle' => __('Select the number of Cross-sell products to show on cart page.', 'kleo_framework'),
                'options' => array(
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6'
                ),
                'default' => '3'
            )
        )
    );
}

if ( class_exists('bbPress') ) {

	$sections[] = array(
        'icon' => 'el-icon-comment-alt',
        'icon_class' => 'icon-large',
        'title' => __('bbPress', 'kleo_framework'),
        'customizer' => false,
        'desc' => '',
        'fields' => array(
            array(
                 'id' => 'bbpress_sidebar',
                 'type' => 'select',
                 'title' => __('bbPress Pages Layout', 'kleo_framework'),
                 'subtitle' => __('Select the layout to use in bbPress pages.', 'kleo_framework'),
                 'options' => array(
                     'default' => 'Default site layout',
                     'no' => 'Full width',
                     'left' => 'Left Sidebar',
                     'right' => 'Right Sidebar',
                     '3lr' => '3 Column, Left and Right Sidebars',
                     '3ll' => '3 Column, 2 Left sidebars',
                     '3rr' => '3 Column, 2 Right sidebars'
                     ),
                 'default' => 'default'
             ),
            array(
                'id' => 'bbpress_mentions',
                'type' => 'switch',
                'title' => __('Enable @mentions.', 'kleo_framework'),
                'subtitle' => __('Enable or disable Buddypress @mentions in forum topics.', 'kleo_framework'),
                'default' => '1' // 1 = checked | 0 = unchecked
            ),
        )
    );
}

if (function_exists('pmpro_url')):


    $sections[] = array(

        'icon' => 'el-icon-group',
        'icon_class' => 'icon-large',
        'title' => __('Memberships', 'kleo_framework'),
        'customizer' => false,
        'desc' => __('<p class="description">Settings related to membership. You need to have Paid Memberships Pro plugin activated</p>', 'kleo_framework'),
        'fields' => array(
            array(
                'id' => 'membership',
                'type' => 'callback',
                'title' => __('Membership settings', 'kleo_framework'),
                'sub_desc' => '',
                'callback' => 'pmpro_data_set',
            )
        )
    );

endif;


$sections[] = array(

	'icon' => 'el-icon-iphone-home',
	'icon_type' => 'iconfont',
	'icon_class' => 'icon-large',
	'title' => __('Mobile options', 'kleo_framework'),
	'customizer' => false,
	'desc' => esc_html__("Mobile specific customisations", "kleo_framework"),
	'fields' => array(
		array(
			'id' => 'mobile_app_capable',
			'type' => 'switch',
			'title' => __('Add mobile app capable meta tag', 'kleo_framework'),
			'subtitle' => sprintf(__('See more <a target="_blank" href="%s">here</a> ', 'kleo_framework'), 'https://developer.chrome.com/multidevice/android/installtohomescreen'),
			'default' => '1' // 1 = checked | 0 = unchecked
		),
		array(
			'id' => 'apple_mobile_app_capable',
			'type' => 'switch',
			'title' => __('Add Apple mobile app capable meta tag', 'kleo_framework'),
			'subtitle' => sprintf(__('See more <a target="_blank" href="%s">here</a> ', 'kleo_framework'), 'https://developer.apple.com/library/iad/documentation/AppleApplications/Reference/SafariHTMLRef/Articles/MetaTags.html'),
			'default' => '0' // 1 = checked | 0 = unchecked
		),
		array(
			'id' => 'meta_theme_color',
			'type' => 'color',
			'title' => __('Set mobile browser theme color(only on supported browsers)', 'kleo_framework'),
			'subtitle' => sprintf(__('See more <a target="_blank" href="%s">here</a> ', 'kleo_framework'), 'https://developers.google.com/web/fundamentals/design-and-ui/browser-customization/theme-color?hl=en'),
			'description' => __("Allows you to set a browser theme color. To disable it just remove the color code", "kleo_framework"),
			'default' => '' // 1 = checked | 0 = unchecked
		),
	)
);

$sections[] = array(

	'icon' => 'el-icon-cogs',
	'icon_type' => 'iconfont',
	'icon_class' => 'icon-large',
	'title' => __('Miscellaneous', 'kleo_framework'),
    'customizer' => false,
	'desc' => "",
	'fields' => array(
			array(
				'id' => 'sitewide_animations',
				'type' => 'button_set',
				'title' => __('Site-Wide Animations', 'kleo_framework'),
				'subtitle' => __('Options to turn site-wide animations on/off.', 'kleo_framework'),
				'options' => array(
					'enabled' => 'On', 'disable-all' => 'Disable on all devices ', 'disable-mobile' => 'Disable on mobile devices only'
				),
				'default' => 'enabled'
			),
			array(
					'id' => 'admin_bar',
					'type' => 'switch',
					'title' => __('Admin toolbar', 'kleo_framework'),
					'subtitle' => __('Enable or disable wordpress default top toolbar', 'kleo_framework'),
					'default' => '1' // 1 = checked | 0 = unchecked
			),
            array(
                'id' => 'login_redirect',
                'type' => 'select',
                'title' => __('Login redirect for Popup', 'kleo_framework'),
                'subtitle' => __('Select the redirect action taken when members login from the popup window.', 'kleo_framework'),
                'options' => array(
                    'default' => __( 'Default WordPress redirect', 'kleo_framework' ),
                    'reload' => __( 'Reload the current page' ,'kleo_framework' ),
                    'custom' => __( 'Custom link' ,'kleo_framework' ),
                ),
                'default' => 'default'
            ),
			array(
				'id' => 'login_redirect_custom',
				'type' => 'text',
				'title' => __('Custom link redirect', 'kleo_framework'),
				'description' => __('Set a link like http://yoursite.com/homepage for users to get redirected on login.<br>' .
					' For more complex redirect logic please set Login redirect to Default WordPress and use Peter\'s redirect plugin or a similar plugin.', 'kleo_framework'),
				'default' => '',
				'required' => array('login_redirect', '=' , 'custom'),
			),
			 array(
                'id' => 'homepage_redirect',
                'type' => 'select',
                'title' => __('Homepage redirect', 'kleo_framework'),
                'subtitle' => __('This option will help you redirect your users away from the homepage once they are logged in.', 'kleo_framework'),
                'options' => array(
                    'disabled' => __( 'Disabled', 'kleo_framework' ),
                    'profile' => __( 'Redirect to current user profile or author page' ,'kleo_framework' ),
                    'custom' => __( 'Custom link' ,'kleo_framework' ),
                ),
                'default' => 'disabled'
            ),
			array(
				'id' => 'homepage_redirect_custom',
				'type' => 'text',
				'title' => __('Custom link redirect', 'kleo_framework'),
				'description' => __('Set a link like http://yoursite.com/custompage to redirect logged in users away from your homepage.<br>' .
					' With BuddyPress/bbPress installed you can add a link to your profile with ##profile_link## in the URL input. Example: ##profile_link##/messages', 'kleo_framework'),
				'default' => '',
				'required' => array('homepage_redirect', '=' , 'custom'),
			),
			array(
					'id' => 'facebook_login',
					'type' => 'switch',
					'title' => __('Facebook integration', 'kleo_framework'),
					'subtitle' => __('Enable or disable Login/Register with Facebook', 'kleo_framework'),
					'default' => '0', // 1 = checked | 0 = unchecked
			),
			array(
					'id' => 'fb_app_id',
					'type' => 'text',
					'title' => __('Facebook APP ID', 'kleo_framework'),
					'subtitle' => __('In order to integrate with Facebook you need to enter your Facebook APP ID<br/>If you don\'t have one, you can create it from: <a target="_blank" href="https://developers.facebook.com/apps">HERE</a> ', 'kleo_framework'),
					'description' => sprintf( __( "See tutorial <a href='%s'>here</a>", "kleo_framework" ), 'http://seventhqueen.com/support/general/article/create-facebook-app-get-app-id-facebook-login' ),
					'default' => '',
					'required' => array('facebook_login', '=' , '1'),
			),
			array(
					'id' => 'facebook_avatar',
					'type' => 'switch',
					'title' => __('Show Facebook avatar', 'kleo_framework'),
					'subtitle' => __('If you enable this, users that registered with Facebook will display Facebook profile image as avatar.', 'kleo_framework'),
					'default' => '0', // 1 = checked | 0 = unchecked
					'required' => array('facebook_login', '=' , '1'),
			),
			array(
					'id' => 'facebook_register',
					'type' => 'switch',
					'title' => __('Enable Registration via Facebook', 'kleo_framework'),
					'subtitle' => __('If you enable this, users will be able to register a new account using Facebook. This skips the registration page including required profile fields', 'kleo_framework'),
					'default' => '0', // 1 = checked | 0 = unchecked
					'required' => array('facebook_login', '=' , '1'),
			),

            array(
                'id' => 'let_it_snow',
                'type' => 'switch',
                'title' => __('Let it snow', 'kleo_framework'),
                'subtitle' => __('If you enable this, a beautiful snowing effect will cover the whole site', 'kleo_framework'),
                'default' => '0', // 1 = checked | 0 = unchecked
            ),
		array(
			'id' => 'magnific_disable_gallery',
			'type' => 'switch',
			'title' => __('Disable Magnific popup for blog gallery', 'kleo_framework'),
			'subtitle' => __('WARNING: Not recommended. Disable this only if you have other implementation for Image popup.(ON will disable the popup)', 'kleo_framework'),
			'description' => "<small>Will disable popups for this image tags:<br> a[data-rel^='prettyPhoto'], a[rel^='prettyPhoto'], a[rel^='modalPhoto'], a[data-rel^='modalPhoto'], .article-content a[href$=jpg]:has(img), .article-content a[href$=JPG]:has(img), .article-content a[href$=jpeg]:has(img), .article-content a[href$=JPEG]:has(img), .article-content a[href$=gif]:has(img), .article-content a[href$=GIF]:has(img), .article-content a[href$=bmp]:has(img), .article-content a[href$=BMP]:has(img), .article-content a[href$=png]:has(img), .article-content a[href$=PNG]:has(img)</small>",
			'default' => '0', // 1 = checked | 0 = unchecked
		),
        array(
            'id' => 'dev_mode',
            'type' => 'switch',
            'title' => __('Development mode', 'kleo_framework'),
            'subtitle' => __('If you enable this, CSS and JS resources will not be loaded minified', 'kleo_framework'),
            'default' => '0', // 1 = checked | 0 = unchecked
        ),
	)
);


$sections[] = array(
	'icon_type' => 'iconfont',
	'icon_class' => 'el-icon-twitter',
	'title' => __('Social Info', 'kleo_framework'),
    'customizer' => false,
	'desc' => __('<p class="description">Here you can set your contact info that will display in the top bar.</p>', 'kleo_framework'),
	'fields' => array(

			array(
					'id' => 'show_social_icons',
					'type' => 'switch',
					'title' => __('Display social icons', 'kleo_framework'),
					'subtitle' => __('Enable or disable the social icons in top bar.', 'kleo_framework'),
					'default' => '1' // 1 = checked | 0 = unchecked
			),

			array(
				'id' => 'social_twitter',
				'type' => 'text',
				'title' => __('Twitter', 'kleo_framework'),
				'subtitle' => "Your Twitter link",
				'desc' => '',
				'default' => ''
				),
			array(
				'id' => 'social_facebook',
				'type' => 'text',
				'title' => __('Facebook', 'kleo_framework'),
				'subtitle' => "Your Facebook page/profile link",
				'desc' => '',
				'default' => ''
				),
			array(
				'id' => 'social_dribbble',
				'type' => 'text',
				'title' => __('Dribbble', 'kleo_framework'),
				'subtitle' => "Your Dribbble link",
				'desc' => '',
				'default' => ''
				),
			array(
				'id' => 'social_vimeo-squared',
				'type' => 'text',
				'title' => __('Vimeo', 'kleo_framework'),
				'subtitle' => "Your Vimeo link",
				'desc' => '',
				'default' => ''
				),
			array(
				'id' => 'social_tumblr',
				'type' => 'text',
				'title' => __('Tumblr', 'kleo_framework'),
				'subtitle' => "Your Tumblr link",
				'desc' => '',
				'default' => ''
				),
			array(
				'id' => 'social_linkedin',
				'type' => 'text',
				'title' => __('LinkedIn', 'kleo_framework'),
				'subtitle' => "Your LinkedIn link",
				'desc' => '',
				'default' => ''
				),
			array(
				'id' => 'social_gplus',
				'type' => 'text',
				'title' => __('Google+', 'kleo_framework'),
				'subtitle' => "Your Google+ link",
				'desc' => '',
				'default' => ''
				),
			array(
				'id' => 'social_flickr',
				'type' => 'text',
				'title' => __('Flickr', 'kleo_framework'),
				'subtitle' => "Your Flickr page link",
				'desc' => '',
				'default' => ''
				),
			array(
				'id' => 'social_youtube',
				'type' => 'text',
				'title' => __('YouTube', 'kleo_framework'),
				'subtitle' => "Your YouTube link",
				'desc' => '',
				'default' => ''
				),
			array(
				'id' => 'social_pinterest-circled',
				'type' => 'text',
				'title' => __('Pinterest', 'kleo_framework'),
				'subtitle' => "Your Pinterest link",
				'desc' => '',
				'default' => ''
				),
			array(
				'id' => 'social_foursquare',
				'type' => 'text',
				'title' => __('Foursquare', 'kleo_framework'),
				'subtitle' => "Your Foursqaure link",
				'desc' => '',
				'default' => ''
				),
			array(
				'id' => 'social_instagramm',
				'type' => 'text',
				'title' => __('Instagram', 'kleo_framework'),
				'subtitle' => "Your Instagram link",
				'desc' => '',
				'default' => ''
				),
			array(
				'id' => 'social_github',
				'type' => 'text',
				'title' => __('GitHub', 'kleo_framework'),
				'subtitle' => "Your GitHub link",
				'desc' => '',
				'default' => ''
				),
			array(
				'id' => 'social_xing',
				'type' => 'text',
				'title' => __('Xing', 'kleo_framework'),
				'subtitle' => "Your Xing link",
				'desc' => '',
				'default' => ''
				)
		)
	);

$sections[] = array(
    'icon' => 'el-icon-key',
    'icon_class' => 'icon-large',
    'title' => __('Theme update', 'kleo_framework'),
    'customizer' => false,
		'desc' => __('<p class="description">To automatically get theme updates you need to enter the username and API KEY from your Themeforest account.<br>Please make a backup of current files each time you do a theme update.</p>', 'kleo_framework'),
		'fields' => array(
				array(
						'id' => 'tf_username',
						'type' => 'text',
						'title' => __('Themeforest Username', 'kleo_framework'),
						'subtitle' => __('', 'kleo_framework'),
						'default' => ''
				),
				array(
						'id' => 'tf_apikey',
						'type' => 'text',
						'title' => __('Themeforest API KEY', 'kleo_framework'),
						'subtitle' => sprintf(__('<a href="%s" target="_blank">See how to get your API Key</a>', 'kleo_framework'), 'http://seventhqueen.com/support/general/article/how-to-get-themeforest-api-key'),
						'default' => ''
				)
		)
);


  /* $sections[] = array(
        'icon' => 'el-icon-info-circle',
        'icon_class' => 'icon-large',
        'title' => __('System info', 'kleo_framework'),
        'customizer' => false,
        'desc' => __('<p class="description">System information useful for support problems</p>', 'kleo_framework'),
        'fields' => array(
            array(
                'id' => 'support_callback',
                'type' => 'callback ',
                'title' => __('Debug data'),
                'callback' => 'kleo_show_system_status'
            )
        )
    );*/

    function kleo_show_system_status() {
        echo 'Home URL: ' .         home_url() . '<br>';
        echo 'Site URL: ' .         site_url() . '<br>';
        echo 'WP Content URL: ' .         WP_CONTENT_URL . '<br>';
        echo 'WP Version: ' .         get_bloginfo( 'version' ) . '<br>';
        echo 'WP MultiSite: ' .         (is_multisite() ? 'yes' : 'no') . '<br>';
        echo 'Permalink: : ' .         (get_option( 'permalink_structure' ) ? get_option( 'permalink_structure' ) : 'Default') . '<br>';

        $front_page_display   = get_option( 'show_on_front' );
        if ( $front_page_display == 'page' ) {
            $front_page_id = get_option( 'page_on_front' );
            $blog_page_id  = get_option( 'page_for_posts' );
            echo 'Front Page: ' . ($front_page_id != 0 ? get_the_title( $front_page_id ) . ' (#' . $front_page_id . ')' : 'Unset') . '<br>';
            echo 'Posts Page: ' . ($blog_page_id != 0 ? get_the_title( $blog_page_id ) . ' (#' . $blog_page_id . ')' : 'Unset') . '<br>';
        }

        if ( function_exists( 'ini_get' ) ) {
            echo 'PHP memory limit: ' . ini_get( 'memory_limit' );
        }

    }

// END Config

if ( class_exists( 'Redux' ) ) {
    Redux::setArgs($opt_name, $args);
    Redux::setSections( $opt_name, $sections);
}



/**
 * Get an array of registered post types with different options
 *
 * @param array $args
 * @return array
 */
function kleo_post_types($args = array())
{
    $kleo_post_types = array();

    if (isset($args['extra'])) {
        $kleo_post_types = $args['extra'];
    }

    $post_args = array(
        'public' => true,
        '_builtin' => false
    );

    $types_return = 'objects'; // names or objects, note names is the default
    $post_types = get_post_types($post_args, $types_return);

    if (isset($args['exclude'])) {
        $except_post_types = array('kleo_clients', 'kleo-testimonials', 'topic', 'reply');
    }

    foreach ($post_types as $post_type) {
        if (isset($except_post_types) && in_array($post_type->name, $except_post_types)) {
            continue;
        }
        $kleo_post_types[$post_type->name] = $post_type->labels->name;
    }

    return $kleo_post_types;
}


if( (isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] == 'true')
    || isset($_POST["kleo_".KLEO_DOMAIN]['defaults-section'])
    || isset($_POST["kleo_".KLEO_DOMAIN]['defaults'])
) {
    kleo_write_dynamic_css_file();
}

add_action( 'kleo-opts-saved', 'kleo_write_dynamic_css_file' );
add_action( 'customize_save_after', 'kleo_write_dynamic_css_file', 100 );
add_action( 'customize_save_after', 'kleo_save_customizer_options' );

/* Generate styling for customizer preview only */
if ( is_customize_preview() ) {
    if (isset($_POST['customized']) && ! empty($_POST['customized']) && $_POST['customized'] != '{}' ) {
        add_filter( 'kleo_options', 'kleo_customizer_override_options' );
        add_action( 'wp_head', 'kleo_custom_head_css', 998 );
    }
}


/* When theme options are saved, remove the dynamic css file */
function kleo_write_dynamic_css_file() {

    global $kleo_config;
    if ( file_exists( trailingslashit( $kleo_config['custom_style_path'] ) . 'dynamic.css' ) ) {
        unlink( trailingslashit( $kleo_config['custom_style_path'] ) . 'dynamic.css' ) ; // Delete it
    }

    delete_transient( KLEO_DOMAIN.'_google_link' );
}


function kleo_customizer_override_options( $options ) {

    if (isset($_POST['customized']) && ! empty($_POST['customized']) && $_POST['customized'] != '{}' ) {
        $changed_options = json_decode( wp_unslash( $_POST['customized'] ), true );

        $new_options = array();

        foreach ( $changed_options as $key => $option ) {
            $replaced_key = rtrim(ltrim(str_replace( 'kleo_' . KLEO_DOMAIN, '', $key ), '['), ']');
            $new_options[$replaced_key] = $option;
        }

        return array_merge( $options, $new_options );
    }

    return $options;
}


function kleo_save_customizer_options( $wp_customize ) {

    $options  = json_decode( stripslashes_deep( $_POST['customized'] ), true );
    $opt_name = 'kleo_' . KLEO_DOMAIN;
    $old_options = get_option( 'kleo_' . KLEO_DOMAIN );
    $changed  = false;

    if (! empty ( $old_options ) ) {
        foreach ($options as $key => $value) {
            if (strpos($key, $opt_name) !== false) {
                $key = str_replace($opt_name . '[', '', rtrim($key, "]"));

                if ( ! isset ( $old_options[$key] ) || $old_options[$key] != $value || (isset($old_options[$key]) && !empty($old_options[$key]) && empty($value))) {
                    $old_options[$key] = $value;
                    $changed = true;
                }
            }
        }

        if ($changed) {
            update_option($opt_name, $old_options);
        }
    }
}





/* Customizer register */
add_action( 'customize_register', 'kleo_register_customizer_controls' ); // Create controls



class KleoOptions
{
    public $args = array();
    public $options = array();
    public $sections = array();
    public $style_sections = array();

    public function __construct( $args, $sections, $options )
    {
        $this->options = $options;
        $this->args = $args;
        $this->sections = $sections;
        $this->opt_name = 'kleo_' . KLEO_DOMAIN;
    }
}

global $kleo_opts_class, $kleo_options;
$kleo_opts_class = new KleoOptions( $args, $sections, $kleo_options );

function kleo_register_customizer_controls( $wp_customize )
{
    global $kleo_opts_class;
    $customizer_sections = $kleo_opts_class->sections;

    // All sections, settings, and controls will be added here
    $order = array(
        'heading' => -500,
        'option' => -500,
    );
    $panel = "";

    foreach ( $customizer_sections as $key => $section) {

        // If section customizer is set to false
        if (isset($section['customizer']) && $section['customizer'] === false) {
            continue;
        }

        if (isset($section['id']) && $section['id'] == "import/export") {
            continue;
        }

        // Not a type that should go on the customizer
        if (empty($section['fields']) || (isset($section['type']) && $section['type'] == "divide")) {
            continue;
        }

        // Evaluate section permissions
        if (isset($section['permissions'])) {
            if (!current_user_can($section['permissions'])) {
                continue;
            }
        }

        // No errors please
        if (!isset($section['desc'])) {
            $section['desc'] = "";
        }

        // Fill the description if there is a subtitle
        if (empty($section['desc']) && !empty($section['subtitle'])) {
            $section['desc'] = $section['subtitle'];
        }

        // Let's make a section ID from the title
        if (empty($section['id'])) {
            $section['id'] = strtolower(str_replace(" ", "", $section['title']));
        }


        // Let's set a default priority
        if (empty($section['priority'])) {
            $section['priority'] = $order['heading'];
            $order['heading']++;
        }

        if (method_exists($wp_customize, 'add_panel') && (!isset($section['subsection']) || (isset($section['subsection']) && $section['subsection'] != true)) && isset($customizer_sections[($key + 1)]['subsection']) && $customizer_sections[($key + 1)]['subsection']) {

            $wp_customize->add_panel($section['id'], array(
                'priority' => $section['priority'],
                'capability' => 'customize',
                'theme_supports' => '',
                'title' => $section['title'],
                'description' => $section['desc'],
            ));
            $panel = $section['id'];

            $wp_customize->add_section($section['id'], array(
                'title' => $section['title'],
                'priority' => $section['priority'],
                'description' => $section['desc'],
                'panel' => $panel
            ));


        } else {
            if (!isset($section['subsection']) || (isset($section['subsection']) && $section['subsection'] != true)) {
                $panel = "";
            }
            $wp_customize->add_section($section['id'], array(
                'title' => $section['title'],
                'priority' => $section['priority'],
                'description' => $section['desc'],
                'panel' => $panel
            ));
        }

        foreach ($section['fields'] as $skey => $option) {

            // Evaluate section permissions
            if (isset($option['permissions'])) {
                if (!current_user_can($option['permissions'])) {
                    continue;
                }
            }
            if (isset($option['validate']) && $option['validate'] != false) {
                continue;
            }

            if (isset($option['validate_callback']) && !empty($option['validate_callback'])) {
                continue;
            }

            if (isset($option['customizer']) && $option['customizer'] === false) {
                continue;
            }

            //Change the item priority if not set
            if ($option['type'] != 'heading' && !isset($option['priority'])) {
                $option['priority'] = $order['option'];
                $order['option']++;
            }

            if (isset($kleo_opts_class->options[$option['id']])) {
                $option['default'] = $kleo_opts_class->options[$option['id']];
            } else {
                $option['default'] = '';
            }

            if (!isset($option['title'])) {
                $option['title'] = "";
            }

            // Wordpress doesn't support multi-select
            if ($option['type'] == "select" && isset($option['multi']) && $option['multi'] == true) {
                continue;
            }

            $option['id'] = $kleo_opts_class->opt_name . '[' . $option['id'] . ']';

            if ($option['type'] != "heading" && $option['type'] != "import_export" && $option['type'] != "options_object" && !empty($option['type'])) {
                $wp_customize->add_setting($option['id'],
                    array(
                        'default' => $option['default'],
                        'type' => 'option',
                        'capabilities' => 'edit_theme_options',
                        //'capabilities'    => $this->parent->args['page_permissions'],
                        'transport' => isset($option['customizer_post']) ? 'postMessage' : 'refresh',
                        'theme_supports' => '',
                        //'sanitize_callback' => '__return_false',
                        'sanitize_callback' => 'kleo_field_validation',
                        //'sanitize_js_callback' =>array( &$parent, '_field_input' ),
                    )
                );
            }


            switch ($option['type']) {
                case 'heading':
                    // We don't want to put up the section unless it's used by something visible in the customizer
                    $section = $option;
                    $section['id'] = strtolower(str_replace(" ", "", $option['title']));
                    $order['heading'] = -500;

                    if (!empty($option['priority'])) {
                        $section['priority'] = $option['priority'];
                    } else {
                        $section['priority'] = $order['heading'];
                        $order['heading']++;
                    }
                    break;

                case 'text':
                    if (isset($option['data']) && $option['data']) {
                        continue;
                    }
                    $wp_customize->add_control($option['id'], array(
                        'label' => $option['title'],
                        'section' => $section['id'],
                        'settings' => $option['id'],
                        'priority' => $option['priority'],
                        'type' => 'text',
                    ));
                    break;

                case 'select':
                case 'button_set':
                    if (!isset($option['options'])) {
                        continue;
                    }

                    $newOptions = array();
                    foreach ($option['options'] as $key => $value) {
                        if (is_array($value)) {
                            foreach ($value as $key => $v) {
                                $newOptions[] = $v;
                            }

                        }
                    }

                    if (!empty($newOptions)) {
                        $option['options'] = $newOptions;
                    }

                    if ((isset($option['sortable']) && $option['sortable'])) {
                        continue;
                    }

                    if ((isset($option['multi']) && $option['multi'])) {
                        continue;
                    }

                    $wp_customize->add_control($option['id'], array(
                        'label' => $option['title'],
                        'section' => $section['id'],
                        'settings' => $option['id'],
                        'priority' => $option['priority'],
                        'type' => 'select',
                        'choices' => $option['options']
                    ));
                    break;

                case 'radio':
                    //continue;
                    $wp_customize->add_control($option['id'], array(
                        'label' => $option['title'],
                        'section' => $section['id'],
                        'settings' => $option['id'],
                        'priority' => $option['priority'],
                        'type' => 'radio',
                        'choices' => $option['options']
                    ));
                    break;

                case 'checkbox':
                    if ((isset($option['data']) && $option['data']) || ((isset($option['multi']) && $option['multi'])) || ((isset($option['options']) && !empty($option['options'])))) {
                        continue;
                    }
                    $wp_customize->add_control($option['id'], array(
                        'label' => $option['title'],
                        'section' => $section['id'],
                        'settings' => $option['id'],
                        'priority' => $option['priority'],
                        'type' => 'checkbox',
                    ));
                    break;

                case 'media':
                    continue;
                    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, $option['id'], array(
                        'label' => $option['title'],
                        'section' => $section['id'],
                        'settings' => $option['id'],
                        'priority' => $option['priority']
                    )));
                    break;

                case 'color':
                    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, $option['id'], array(
                        'label' => $option['title'],
                        'section' => $section['id'],
                        'settings' => $option['id'],
                        'priority' => $option['priority'],
                        'description' => $option['desc']
                    )));
                    break;

                default:
                    break;
            }
        }
    }
}


function kleo_field_validation( $value ) {
    return $value;
}