<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 */

add_filter( 'kleo_meta_boxes', 'kleo_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function kleo_metaboxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_kleo_';
	
	$meta_boxes['general_settings'] = array(
		'id'         => 'general_settings',
		'title'      => esc_html__('Theme General settings', 'kleo_framework'),
		'pages'      => array( 'post','page' ), // Post type
		'context'    => 'normal',
		'priority'   => 'default',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name' => 'Display settings',
				'desc' => '',
				'id'   => 'kleodisplay',
				'type' => 'tab'
			),
			array(
				'name' => esc_html__('Site Layout', 'kleo_framework' ),
				'desc' => esc_html__( 'Override default site layout', 'kleo_framework' ),
				'id'   => $prefix . 'site_style',
				'type' => 'select',
				'options' => array(
					array('value' => '', 'name' => 'Default'),
					array('value' => 'wide', 'name' => 'Wide'),
					array('value' => 'boxed', 'name' => 'Boxed')
				),
				'value' => ''
			),
			array(
				'name' => esc_html__('Centered text', 'kleo_framework' ),
				'desc' => esc_html__( 'Check to have centered text on this page', 'kleo_framework' ),
				'id'   => $prefix . 'centered_text',
				'type' => 'checkbox',
				'value' => '1'
			),
			array(
				'name' => esc_html__('Top bar status', 'kleo_framework' ),
				'desc' => esc_html__( 'Enable/disable site top bar' ,'kleo_framework' ),
				'id'   => $prefix . 'topbar_status',
				'type' => 'select',
				'options' => array(
						array('value' => '', 'name' => 'Default'),
						array('value' => '1', 'name' => 'Visible'),
						array('value' => '0', 'name' => 'Hidden')
					),
				'value' => ''
			),
			array(
				'name' => esc_html__('Hide Header', 'kleo_framework' ),
				'desc' => esc_html__( 'Check to hide whole header area', 'kleo_framework' ),
				'id'   => $prefix . 'hide_header',
				'type' => 'checkbox',
				'value' => '1'
			),
			array(
				'name' => esc_html__('Hide Footer', 'kleo_framework' ),
				'desc' => esc_html__( 'Check to hide whole footer area', 'kleo_framework' ),
				'id'   => $prefix . 'hide_footer',
				'type' => 'checkbox',
				'value' => '1'
			),
			array(
				'name' => esc_html__('Hide Socket area', 'kleo_framework' ),
				'desc' => esc_html__( 'Check to hide the area after footer that contains copyright info.', 'kleo_framework' ),
				'id'   => $prefix . 'hide_socket',
				'type' => 'checkbox',
				'value' => '1'
			),
			array(
				'name' => esc_html__('Custom Logo', 'kleo_framework' ),
				'desc' => esc_html__( 'Use a custom logo for this page only', 'kleo_framework' ),
				'id'   => $prefix . 'logo',
				'type' => 'file',
			),
			array(
				'name' => esc_html__('Custom Logo Retina', 'kleo_framework' ),
				'desc' => esc_html__( 'Use a custom retina logo for this page only', 'kleo_framework' ),
				'id'   => $prefix . 'logo_retina',
				'type' => 'file',
			),
			array(
				'name' => esc_html__('Main Menu Full Width', 'kleo_framework' ),
				'desc' => esc_html__( 'Check to enable full browser width menu style.', 'kleo_framework' ),
				'id'   => $prefix . 'menu_full_width',
				'type' => 'checkbox',
				'value' => '1'
			),
			array(
				'name' => esc_html__('Transparent Main menu', 'kleo_framework' ),
				'desc' => esc_html__( 'Check to have Main menu background transparent.', 'kleo_framework' ),
				'id'   => $prefix . 'transparent_menu',
				'type' => 'checkbox',
				'value' => '1'
			),
            array(
                'name' => esc_html__( 'Transparent Main menu color', 'kleo_framework' ),
                'desc' => '',
                'id'   => $prefix . 'transparent_menu_color',
                'type' => 'select',
                'options' => array(
                    array('value' => 'white', 'name' => esc_html__( 'White', 'kleo_framework' )),
                    array('value' => 'black', 'name' => esc_html__( 'Black', 'kleo_framework' ))
                ),
                'value' => 'white'
            ),
            array(
                'name' => esc_html__('Social share', 'kleo_framework' ),
                'desc' => esc_html__('Display social share at bottom of the single page.', 'kleo_framework' ),
                'id'   => $prefix . 'blog_social_share',
                'type' => 'select',
                'options' => array(
                    array('value' => '', 'name' => esc_html__( 'Default', 'kleo_framework' )),
                    array('value' => '1', 'name' => esc_html__( 'Visible', 'kleo_framework' )),
                    array('value' => '0', 'name' => esc_html__( 'Hidden', 'kleo_framework' ))
                ),
                'value' => ''
            ),
				
				
			array(
				'name' => esc_html__('Title section', 'kleo_framework' ),
				'desc' => '',
				'id'   => 'kleoheader',
				'type' => 'tab'
			),
            array(
                'name' => esc_html__('Section Layout', 'kleo_framework' ),
                'desc' => '',
                'id'   => $prefix . 'title_layout',
                'type' => 'select',
                'options' => array(
                    array('value' => '', 'name' => esc_html__('Default', 'kleo_framework' )),
                    array('value' => 'regular', 'name' => esc_html__('Regular', 'kleo_framework')),
                    array('value' => 'center', 'name' => esc_html__('Centered', 'kleo_framework')),
                    array('value' => 'right_breadcrumb', 'name' => esc_html__('Right Breadcrumb', 'kleo_framework'))
                ),
                'value' => ''
            ),
            array(
                'name' => esc_html__('Custom page title', 'kleo_framework' ),
                'desc' => esc_html__('Set a custom page title here if you need.', 'kleo_framework' ),
                'id'   => $prefix . 'custom_title',
                'type' => 'text',
            ),
			array(
				'name' => esc_html__('Hide the title', 'kleo_framework' ),
				'desc' => esc_html__('Check to hide the title when displaying the post/page', 'kleo_framework' ),
				'id'   => $prefix . 'title_checkbox',
				'type' => 'checkbox',
				'value' => '1'
			),
			array(
				'name' => esc_html__('Breadcrumb', 'kleo_framework' ),
				'desc' => '',
				'id'   => $prefix . 'hide_breadcrumb',
				'type' => 'select',
				'options' => array(
					array('value' => '', 'name' => esc_html__( 'Default', 'kleo_framework' )),
					array('value' => '0', 'name' => esc_html__( 'Visible', 'kleo_framework' )),
					array('value' => '1', 'name' => esc_html__( 'Hidden', 'kleo_framework' ))
					),
				'value' => ''
			),
            array(
                'name' => esc_html__('Hide information', 'kleo_framework' ),
                'desc' => esc_html__('Check to hide contact info in title section', 'kleo_framework' ),
                'id'   => $prefix . 'hide_info',
                'type' => 'checkbox',
                'value' => '1'
            ),
            array(
                'name' => esc_html__('Top Padding', 'kleo_framework' ),
                'desc' => 'Put a value without px. Example: 20<br>Default value is taken from Theme options - Header - Title/Breadcrumb section',
                'id'   => $prefix . 'title_top_padding',
                'type' => 'text',
            ),
            array(
                'name' => esc_html__('Bottom Padding', 'kleo_framework' ),
                'desc' => 'Put a value without px. Example: 20<br>Default value is taken from Theme options - Header - Title/Breadcrumb section',
                'id'   => $prefix . 'title_bottom_padding',
                'type' => 'text',
            ),
            array(
                'name' => esc_html__('Text Color', 'kleo_framework' ),
                'desc' => esc_html__('Override the default text color as set in Theme options - Styling options - Title', 'kleo_framework' ),
                'id'   => $prefix . 'title_color',
                'type' => 'colorpicker',
                'value' => ''
            ),
            array(
                'name' => esc_html__('Background Image', 'kleo_framework' ),
                'desc' => esc_html__('Choose a background image for the section.', 'kleo_framework' ),
                'id'   => $prefix . 'title_bg',
                'type' => 'file',
                'bg_options' => 'yes'
            ),
            array(
                'name' => esc_html__('Background Color', 'kleo_framework' ),
                'desc' => esc_html__('If an image is not set the color will be used', 'kleo_framework' ),
                'id'   => $prefix . 'title_bg_color',
                'type' => 'colorpicker',
                'value' => ''
            ),

            array(
                'name' => esc_html__('Media', 'kleo_framework' ),
                'desc' => '',
                'id'   => 'kleomedia',
                'type' => 'tab'
            ),
            array(
                'name' => esc_html__('Show media on post page', 'kleo_framework' ),
                'desc' => esc_html__('If you want to show image/gallery/video/audio before the post on single page', 'kleo_framework' ),
                'id'   => $prefix . 'post_media_status',
                'type' => 'select',
                'options' => array(
	                array('value' => '', 'name' => esc_html__( 'Default', 'kleo_framework' )),
	                array('value' => '1', 'name' => esc_html__( 'Yes', 'kleo_framework' )),
	                array('value' => '0', 'name' => esc_html__( 'No', 'kleo_framework' ))
                ),
                'value' => ''
            ),
            array(
                'name' => esc_html__('Slider', 'kleo_framework' ),
                'desc' => esc_html__('Used when you select the Gallery format. Upload an image or enter an URL.', 'kleo_framework' ),
                'id'   => $prefix . 'slider',
                'type' => 'file_repeat',
                'allow' => 'url'
            ),
            array(
                'name' => esc_html__('Video oEmbed URL', 'kleo_framework' ),
                'desc' => 'Used when you select Video format. Enter a Youtube, Vimeo, Soundcloud, etc URL. See supported services at <a target="_blank" href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>.',
                'id'   => $prefix . 'embed',
                'type' => 'oembed',
            ),

            array(
                'name' => esc_html__('Video Self hosted(mp4)', 'kleo_framework' ),
                'desc' => 'Used when you select Video format. Upload your MP4 video file. Setting a self hosted video will ignore Video oEmbed above.',
                'id'   => $prefix . 'video_mp4',
                'type' => 'file',
            ),
            array(
                'name' => esc_html__('Video Self hosted(ogv)', 'kleo_framework' ),
                'desc' => 'Used when you select Video format. Upload your OGV video file.',
                'id'   => $prefix . 'video_ogv',
                'type' => 'file',
            ),
            array(
                'name' => esc_html__('Video Self hosted(webm)', 'kleo_framework' ),
                'desc' => 'Used when you select Video format. Upload your WEBM video file.',
                'id'   => $prefix . 'video_webm',
                'type' => 'file',
            ),
            array(
                'name' => esc_html__('Video Self hosted Poster', 'kleo_framework' ),
                'desc' => 'Used to show before the video loads',
                'id'   => $prefix . 'video_poster',
                'type' => 'file',
            ),

            array(
                'name' => esc_html__('Audio', 'kleo_framework' ),
                'desc' => 'Used when you select Audio format. Upload your audio file',
                'id'   => $prefix . 'audio',
                'type' => 'file',
            )
		)
	);

	$meta_boxes[] = array(
		'id'         => 'post_meta',
		'title'      => 'Theme Post Settings',
		'pages'      => array( 'post' ), // Post type
		'context'    => 'normal',
		'priority'   => 'default',
		'show_names' => true, // Show field names on the left
		'fields'     => array(

				array(
				'name' => esc_html__('Hide post meta', 'kleo_framework' ),
				'desc' => 'Check to hide the post meta when displaying a post',
				'id'   => $prefix . 'meta_checkbox',
				'type' => 'checkbox',
				'value' => '1'
			),
			array(
				'name' => esc_html__('Related posts', 'kleo_framework' ),
				'desc' => 'Display related posts at bottom of the single post display',
				'id'   => $prefix . 'related_posts',
				'type' => 'select',
				'options' => array(
					array('value' => '', 'name' => esc_html__( 'Default', 'kleo_framework' )),
					array('value' => '1', 'name' => esc_html__( 'Visible', 'kleo_framework' )),
					array('value' => '0', 'name' => esc_html__( 'Hidden', 'kleo_framework' ))
					),
				'value' => ''
			),
		),
	);
	
	
	
	$meta_boxes[] = array(
		'id'         => 'post_layout',
		'title'      => esc_html__('Post Layout', 'kleo_framework' ),
		'pages'      => array( 'post', 'product', 'portfolio' ), // Post type
		'context'    => 'side',
		'priority'   => 'default',
		'show_names' => false, // Show field names on the left
		'fields'     => array(
			
			array(
				'name' => esc_html__('Post layout', 'kleo_framework' ),
				'desc' => '',
				'id'   => $prefix . 'post_layout',
				'type' => 'select',
				'options' => array(
						array('value' => 'default', 'name' => esc_html__('Default','kleo_framework')),
						array('value' => 'right', 'name' => esc_html__('Right Sidebar','kleo_framework')),
						array('value' => 'left', 'name' => esc_html__('Left sidebar','kleo_framework')),
						array('value' => 'no', 'name' => esc_html__('Full width, no sidebar','kleo_framework')),
						array('value' => '3lr', 'name' => esc_html__('3 columns, Right and Left sidebars','kleo_framework')),
						array('value' => '3ll', 'name' => esc_html__('3 columns, 2 Left sidebars','kleo_framework')),
						array('value' => '3rr', 'name' => esc_html__('3 columns, 2 Right sidebars','kleo_framework')),
					),
				'value' => 'right'
			),

				
		),
	);
	
	$meta_boxes[] = array(
		'id'         => 'header_content',
		'title'      => esc_html__('Header content(optional)', 'kleo_framework' ),
		'pages'      => array( 'post', 'page', 'product' ), // Post type
		'context'    => 'normal',
		'priority'   => 'default',
		'show_names' => false, // Show field names on the left
		'fields'     => array(
	
				array(
				'name' => esc_html__( 'Header content', 'kleo_framework' ),
				'desc' => esc_html__( 'This will be displayed right after the menu. Shortcodes are allowed', 'kleo_framework' ),
				'id'   => $prefix . 'header_content',
				'type' => 'textarea',
			),
				
		),
	);
	
	$meta_boxes[] = array(
		'id'         => 'bottom_content',
		'title'      => esc_html__( 'Bottom content(optional)', 'kleo_framework' ),
		'pages'      => array( 'post', 'page', 'product' ), // Post type
		'context'    => 'normal',
		'priority'   => 'default',
		'show_names' => false, // Show field names on the left
		'fields'     => array(
	
				array(
				'name' => esc_html__('Bottom content', 'kleo_framework' ),
				'desc' => esc_html__('This will be displayed right after the generated page content ends. Shortcodes are allowed', 'kleo_framework' ),
				'id'   => $prefix . 'bottom_content',
				'type' => 'textarea',
			),
				
		),
	);
	
	$meta_boxes[] = array(
		'id'         => 'clients_metabox',
		'title'      => __('Clients - link', 'kleo_framework'),
		'pages'      => array( 'kleo_clients' ), // Post type
		'context'    => 'normal',
		'priority'   => 'default',
		'show_names' => false, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'Client link',
				'desc' => 'http://example.com',
				'id'   => $prefix . 'client_link',
				'type' => 'text',
			),
		)
	);
        
	$meta_boxes[] = array(
		'id'         => 'testimonials_metabox',
		'title'      => esc_html__('Testimonial - Author description', 'kleo_framework'),
		'pages'      => array( 'kleo-testimonials' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => false, // Show field names on the left
		'fields' => array(
			array(
				'name' => esc_html__('Author description', 'kleo_framework' ),
				'desc' => '',
				'id'   => $prefix . 'author_description',
				'type' => 'text',
			),
		)
	);

    //Custom menu
    $kleo_menus = wp_get_nav_menus();
    $menu_options = array();
    $menu_options[] = array( 'value' => 'default', 'name' => 'Site default' );
    foreach ( $kleo_menus as $menu ) {
        $menu_options[] = array( 'value' => $menu->slug, 'name' => $menu->name );
    }

    $meta_boxes[] = array(
        'id'         => 'page_menu',
        'title'      => esc_html__('Main menu options', 'kleo_framework' ),
        'pages'      => array( 'page', 'post' ), // Post type
        'context'    => 'side',
        'priority'   => 'default',
        'show_names' => true, // Show field names on the left
        'fields'     => array(

            array(
                'name' => esc_html__('Custom menu', 'kleo_framework' ),
                'desc' => '',
                'id'   => $prefix . 'page_menu',
                'type' => 'select',
                'options' => $menu_options,
                'value' => 'default'
            ),
            array(
                'name' => esc_html__('Hide Shop', 'kleo_framework' ),
                'desc' => esc_html__( 'Check to hide the Shop icon in the main menu', 'kleo_framework' ),
                'id'   => $prefix . 'hide_shop_icon',
                'type' => 'checkbox',
                'value' => '1'
            ),
            array(
                'name' => esc_html__('Hide Search', 'kleo_framework' ),
                'desc' => 'Check to hide the Search icon in the main menu',
                'id'   => $prefix . 'hide_search_icon',
                'type' => 'checkbox',
                'value' => '1'
            ),

        ),
    );

	
	// Add other metaboxes as needed

	return $meta_boxes;
}

add_action( 'init', 'initialize_meta_boxes', 9999 );
/**
 * Initialize the metabox class.
 */
function initialize_meta_boxes() {

    if ( ! class_exists( 'kleo_Meta_Box' ) ) {
    	require_once trailingslashit( KLEO_DIR ) . 'metaboxes/init.php';
    }
}