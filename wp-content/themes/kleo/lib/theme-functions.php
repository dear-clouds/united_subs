<?php
define( 'KLEO_THEME_VERSION', '4.0.7' );

/* Configuration array */
global $kleo_config;

//Post image sizes for carousels and galleries
$kleo_config['post_gallery_img_width'] = 480;
$kleo_config['post_gallery_img_height'] = 270;

//Image width for big images like on single post page
$kleo_config['post_single_img_width'] = 1200;

$kleo_config['blog_layouts'] = array(
    'masonry' => 'Grid Masonry',
    'small' => 'Small Left Thumbnail',
    'standard' => 'Standard'
);

$kleo_config['blog_meta_elements'] = array(
	'avatar' => 'Author Avatar',
	'date' => 'Date',
	'archive' => 'Archive Link',
	'profile' => 'Profile Icon',
	'author_link' => 'Profile Link',
	'message' => 'Message Link',
	'categories' => 'Categories',
	'tags' => 'Tags',
	'comments' => 'Comments'
);
$kleo_config['blog_meta_defaults'] = array('author_link', 'date', 'categories', 'tags', 'comments');

//define dynamic styles path
$upload_dir = wp_upload_dir();
if ( is_ssl() ) {
    if ( strpos( $upload_dir['baseurl'], 'https://' ) === false) {
        $upload_dir['baseurl'] = str_ireplace('http', 'https', $upload_dir['baseurl']);
    }
}

$kleo_config['upload_basedir'] = $upload_dir['basedir'];
$kleo_config['custom_style_path'] = $upload_dir['basedir'] . '/custom_styles';
$kleo_config['custom_style_url'] = $upload_dir['baseurl'] . '/custom_styles';
$kleo_config['image_overlay'] = '<span class="hover-element"><i>+</i></span>';

//define site style sets
$kleo_config['style_sets'] = array(	'header','main','alternate','side','footer','socket');
$kleo_config['font_sections'] = array('h1','h2','h3','h4','h5','h6','body');

//physical file template mapping
$kleo_config['tpl_map'] = array(
			'page-templates/left-sidebar.php' => 'left',
			'page-templates/right-sidebar.php' => 'right',
			'page-templates/full-width.php' => 'no',
			'page-templates/left-right-sidebars.php' => '3lr',
			'page-templates/left-two-sidebars.php' => '3ll',
			'page-templates/right-two-sidebars.php' => '3rr'
	);

/***************************************************
:: Framework initialization with required plugins
***************************************************/

/* Delete plugin version transient on Install plugins page */
$kleo_rem_plugin_transient = false;
if (is_admin() && isset($_GET['page']) && $_GET['page'] == 'install-required-plugins') {
	$kleo_rem_plugin_transient = true;
}

$theme_args = array(
	'required_plugins' => array(
		array(
			'name'                  => 'Buddypress', // The plugin name
			'slug'                  => 'buddypress', // The plugin slug (typically the folder name)
			'required'              => false, // If false, the plugin is only 'recommended' instead of required
			'version'               => '2.3.2.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'          => '', // If set, overrides default API URL and points to an external URL
		),

		array(
			'name'                  => 'bbPress', // The plugin name
			'slug'                  => 'bbpress', // The plugin slug (typically the folder name)
			'required'              => false, // If false, the plugin is only 'recommended' instead of required
			'version'               => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'          => '', // If set, overrides default API URL and points to an external URL
		),
        array(
				'name'			=> 'Visual Composer', // The plugin name
				'slug'			=> 'js_composer', // The plugin slug (typically the folder name)
				'version'			=> kleo_get_plugin_version( 'js_composer', '4.11.2', $kleo_rem_plugin_transient ), // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'source'			=> kleo_get_plugin_src( 'js_composer', '4.11.2', false ), // The plugin source
				'required'			=> true, // If false, the plugin is only 'recommended' instead of required
				'force_activation'		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation'	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'		=> '', // If set, overrides default API URL and points to an external URL
		),
        array(
				'name'			=> 'Revolution Slider', // The plugin name
				'slug'			=> 'revslider', // The plugin slug (typically the folder name)
				'required'			=> true, // If false, the plugin is only 'recommended' instead of required
				'version'			=> kleo_get_plugin_version( 'revslider', '5.2.5', $kleo_rem_plugin_transient ), // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'source'			=> kleo_get_plugin_src( 'revslider', '5.2.5' ), // The plugin source
				'force_activation'		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation'	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'		=> '', // If set, overrides default API URL and points to an external URL
		),
        array(
				'name'			=> 'K Elements', // The plugin name
				'slug'			=> 'k-elements', // The plugin slug (typically the folder name)
				'source'			=> get_template_directory() . '/lib/inc/k-elements.zip', // The plugin source
				'required'			=> true, // If false, the plugin is only 'recommended' instead of required
				'version'			=> '4.0.7', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation'	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'		=> '', // If set, overrides default API URL and points to an external URL
		),
        array(
            'name'			=> 'Go Pricing', // The plugin name
            'slug'			=> 'go_pricing', // The plugin slug (typically the folder name)
            'required'			=> false, // If false, the plugin is only 'recommended' instead of required
            'version'			=> kleo_get_plugin_version( 'go_pricing', '3.2.1', $kleo_rem_plugin_transient ), // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'source'			=> kleo_get_plugin_src( 'go_pricing', '3.2.1' ), // The plugin source
            'force_activation'		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation'	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'		=> '', // If set, overrides default API URL and points to an external URL
        ),
        /*array(
            'name'                  => 'BuddyPress Cover Photo', // The plugin name
            'slug'                  => 'buddypress-cover-photo', // The plugin slug (typically the folder name)
            'required'              => false, // If false, the plugin is only 'recommended' instead of required
            'version'               => '1.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'          => '', // If set, overrides default API URL and points to an external URL
        ),*/
		array(
            'name'                  => 'SideKick - Interactive Tutorials', // The plugin name
            'slug'                  => 'sidekick', // The plugin slug (typically the folder name)
            'required'              => false, // If false, the plugin is only 'recommended' instead of required
            'version'               => '2.6.8', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'          => '', // If set, overrides default API URL and points to an external URL
        ),
		array(
			'name'                  => 'rtMedia', // The plugin name
			'slug'                  => 'buddypress-media', // The plugin slug (typically the folder name)
			'required'              => false, // If false, the plugin is only 'recommended' instead of required
			'version'               => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'          => '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'                  => 'WooCommerce', // The plugin name
			'slug'                  => 'woocommerce', // The plugin slug (typically the folder name)
			'required'              => false, // If false, the plugin is only 'recommended' instead of required
			'version'               => '2.4.5', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'          => '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'                  => 'YITH WooCommerce Wishlist', // The plugin name
			'slug'                  => 'yith-woocommerce-wishlist', // The plugin slug (typically the folder name)
			'required'              => false, // If false, the plugin is only 'recommended' instead of required
			'version'               => '1.1.2', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'          => '', // If set, overrides default API URL and points to an external URL
		),
        array(
            'name'                  => 'Paid Memberships Pro', // The plugin name
            'slug'                  => 'paid-memberships-pro', // The plugin slug (typically the folder name)
            'required'              => false, // If false, the plugin is only 'recommended' instead of required
            'version'               => '1.8', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'          => '', // If set, overrides default API URL and points to an external URL
        ),
        array(
            'name'                  => 'BP Profile Search', // The plugin name
            'slug'                  => 'bp-profile-search', // The plugin slug (typically the folder name)
            'required'              => false, // If false, the plugin is only 'recommended' instead of required
            'version'               => '4.3.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'          => '', // If set, overrides default API URL and points to an external URL
        ),
		array(
			'name'                  => 'MailChimp for WordPress', // The plugin name
			'slug'                  => 'mailchimp-for-wp', // The plugin slug (typically the folder name)
			'required'              => false, // If false, the plugin is only 'recommended' instead of required
			'version'               => '3.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'          => '', // If set, overrides default API URL and points to an external URL
		),


	)
);

//instance of our theme framework
global $kleo_theme;
$kleo_theme = new Kleo($theme_args);


/**
 * Get the source of the plugin depending on the version available
 * @param string $name
 * @param string $version
 * @param boolean $external_only
 *
 * @return string
 */
function kleo_get_plugin_src($name, $version, $external_only = true) {

	$online_version = kleo_get_plugin_version( $name, $version );

	if ( $external_only === true || version_compare( $online_version, $version, '>' ) ) {
		$output = 'http://updates.seventhqueen.com/check/kleo/' . $name . '.zip';
	} else {
		$output = get_template_directory() . '/lib/inc/' . $name . '.zip';
	}

	return $output;
}

/**
 * @param string $name Plugin name
 * @param string $version Default version in case of error
 * @param boolean $reset_transient Delete transient and check the online version now
 *
 * @return mixed|string
 */
function kleo_get_plugin_version( $name, $version, $reset_transient = false ) {

	if( $reset_transient === true ) {
		delete_transient( 'kleo_'. $name );
	}

	$final_version = $version;

	if( get_transient( 'kleo_'. $name ) ) {
		$final_version = get_transient('kleo_'. $name);
	} else {
		$version_get = wp_remote_get( 'http://updates.seventhqueen.com/check/kleo/plugin_version.php?name='. $name );
		// Check for error
		if ( ! is_wp_error( $version_get ) ) {
			$url_version = wp_remote_retrieve_body( $version_get );

			// Check for error
			if ( ! is_wp_error( $url_version ) ) {
				$final_version = $url_version;

				set_transient( 'kleo_'. $name, $url_version, 86400 );
			}
		}
	}

	return $final_version;
}



/***************************************************
:: Load Theme functions
***************************************************/

add_action( 'after_setup_theme', 'kleo_theme_functions', 12 );

function kleo_theme_functions() {

	/* Plugins and functionality */
	
	// BuddyPress compatibility
	if (function_exists( 'bp_is_active' )) {
		require_once( KLEO_LIB_DIR . '/plugin-buddypress/config.php' );	    //compatibility with buddypress plugin
	}  
  
	// bbPress compatibility
	if (class_exists( 'bbPress' )) {
		require_once( KLEO_LIB_DIR . '/plugin-bbpress/config.php' );	    //compatibility with bbpress plugin
	}

	/* Woocommerce compatibility */
	if (  class_exists( 'WooCommerce' ) ) {
		require_once( KLEO_LIB_DIR . '/plugin-woocommerce/config.php' );
	}
	
	// Paid memberships Pro compatibility
	if(function_exists('pmpro_url')) {
		require_once( KLEO_LIB_DIR . '/plugin-pmpro/config.php' );
	}

	// Visual composer compatibility
	if( function_exists( 'vc_set_as_theme' ) ) {
		require_once( KLEO_LIB_DIR . '/plugin-vc/config.php' );
	}

	// Compatibility with GeoDirectory plugin
    if( defined( 'GEODIRECTORY_VERSION' ) ) {
        require_once( KLEO_LIB_DIR . '/plugin-geodirectory/config.php' );
    }

    // Compatibility with Sensei plugin
    if( class_exists( 'WooThemes_Sensei' ) ) {
        require_once( KLEO_LIB_DIR . '/plugin-sensei/config.php' );
    }

    // Compatibility Bp Profile Search
    if( defined( 'BPS_VERSION' ) ) {
        require_once( KLEO_LIB_DIR . '/plugin-bp-profile-search/config.php' );
    }

	// Posts likes
	if (sq_option('likes_status', 1) == 1) {
		require_once( KLEO_LIB_DIR . '/item-likes.php' );
	} 

	// Resize on the fly
	require_once(KLEO_LIB_DIR . '/aq_resizer.php');

	// menu-items-visibility-control plugin compatibility
	if ( class_exists('Boom_Walker_Nav_Menu_Edit') ) {
		require_once(KLEO_LIB_DIR . '/plugin-menu-items-visibility-control/config.php');
	}
	
	/* Custom menu */
    require_if_theme_supports( 'kleo-mega-menu', KLEO_LIB_DIR . '/menu-custom.php');
  
    /* Custom menu items */
    require_if_theme_supports( 'kleo-menu-items', KLEO_LIB_DIR . '/menu-items.php');

	/* Portfolio module */
	if ( sq_option( 'module_portfolio', 1 ) == 1 ) {
		require KLEO_LIB_DIR . '/portfolio.php';
	}

    /* Include admin customizations */
    if ( is_admin() ) {
        //Metaboxes
        require_once(KLEO_LIB_DIR . '/metaboxes.php');
    }

	if (is_admin() || is_customize_preview()) {
		require_once(KLEO_LIB_DIR . '/options.php');
	}
}



/***************************************************
:: 1 Click Install
 ***************************************************/
if ( is_admin() ) {
    require_once(KLEO_LIB_DIR . '/importer/import.php');
}



/***************************************************
:: Load post types class
 ***************************************************/

require_once KLEO_LIB_DIR. '/post-types.php';


/* Testimonials module */
if ( sq_option( 'module_testimonials', 1 ) == 1 ) {
	require KLEO_LIB_DIR . '/testimonials.php';
}

/* Clients module */
if ( sq_option( 'module_clients', 1 ) == 1 ) {
	require KLEO_LIB_DIR . '/clients.php';
}


/***************************************************
:: Theme options
 ***************************************************/

if ( is_admin() ) {
    //Options panel
    if (!class_exists('ReduxFramework') && file_exists(KLEO_DIR . '/options/framework.php')) {
        require_once(KLEO_DIR . '/options/framework.php');
    }
}



/***************************************************
:: Include widgets
***************************************************/

$kleo_widgets = array(
	'recent_posts.php'
);

$kleo_widgets = apply_filters( 'kleo_widgets', $kleo_widgets );

foreach ( $kleo_widgets as $widget ) {
	$file_path = trailingslashit( KLEO_LIB_DIR ) . 'widgets/' . $widget;
	
	if ( file_exists( $file_path ) ) {
		require_once( $file_path );
	}
}


/**
 * Return the breadcrumb area
 * @global object $wp_query
 * @param array $args
 * @return string
 */
function kleo_title_section($args = false)
{
    $defaults 	 = array(
        'title'				=> get_the_title(),
        'show_title'        => true,
        'show_breadcrumb'	=> true,
        'link'				=> '',
        'output'			=> "<section class='{class} border-bottom'><div class='container'>{title_data}<div class='breadcrumb-extra'>{breadcrumb_data}{extra}</div></div></section>",
        'class'				=> 'container-wrap main-title alternate-color ',
        'extra'				=> '<p class="page-info">' . do_shortcode( sq_option( 'title_info', '' ) ) . '</p>',
        'heading'		    => 'h1'
    );

		// Parse incoming $args into an array and merge it with $defaults
		$args = wp_parse_args( $args, $defaults );
		$args = apply_filters('kleo_title_args', $args);

		// OPTIONAL: Declare each item in $args as its own variable i.e. $type, $before.
		extract( $args, EXTR_SKIP );
        
		if(!empty($link)) {
			$title = "<a href='".$link."' rel='bookmark' title='".__('Permanent Link:','kleo_framework')." ".esc_attr( $title )."'>".$title."</a>";
		}
		
		$breadcrumb_data = '';
		if( $show_breadcrumb )
		{
			$breadcrumb_data = kleo_breadcrumb(array(
                'show_browse' => false,
                'separator' => ' ',
                'show_home'  => __( 'Home', 'kleo_framework' ),
                'echo'       => false
            ));
		}
		
		$title_data = '';
		if( $show_title )
		{
			$title_data = '<{heading} class="page-title">{title}</{heading}>';
		}

        if ( ! $show_breadcrumb && $extra == '' ) {
            $class .= ' title-single';
        }

        $title_layout = sq_option( 'title_layout', 'normal' );
        if (is_singular() && get_cfield('title_layout') && get_cfield('title_layout') != '' ) {
            $title_layout = get_cfield('title_layout');
        }
        if ( $title_layout == 'center' ) {
            $class .= ' main-center-title';
        } elseif( $title_layout == 'right_breadcrumb' ) {
            $class .= ' main-right-breadcrumb';
        }


		$output = str_replace('{title_data}', $title_data, $output);
		$output = str_replace('{class}', $class, $output);
		$output = str_replace('{title}', $title, $output);
		$output = str_replace('{breadcrumb_data}', $breadcrumb_data, $output);
		$output = str_replace('{extra}', $extra, $output);
		$output = str_replace('{heading}', $heading, $output);
        
		return $output;
}

/**
 * Prepare the title/breadcrumb area using hide/show site options
 * @param integer $post_id
 * @return array
 */
function kleo_prepare_title( $post_id = null ) {
	$title_arr = array();

	$title_arr['title'] = kleo_title();

	//hide title?
	$title_arr['show_title'] = true;
	if( get_cfield( 'title_checkbox', $post_id ) == 1 ) {
		$title_arr['show_title'] = false;
	}
	if ( sq_option('title_location', 'breadcrumb') == 'main' ) {
		$title_arr['show_title'] = false;
	}

	//hide breadcrumb?
    $title_arr['show_breadcrumb'] = true;
	if(sq_option('breadcrumb_status', 1) == 0) {
		$title_arr['show_breadcrumb'] = false;
	}
	if(get_cfield( 'hide_breadcrumb', $post_id ) == 1) {
		$title_arr['show_breadcrumb'] = false;
	} else if ( get_cfield( 'hide_breadcrumb', $post_id ) === '0' ) {
		$title_arr['show_breadcrumb'] = true;
	}

	//hide extra info?
	if(get_cfield( 'hide_info' , $post_id ) == 1) {
		$title_arr['extra'] = '';
	}
	return $title_arr;
}



/***************************************************
 * TOP TOOLBAR - ADMIN BAR
 * Enable or disable the bar, depending of the theme option setting
***************************************************/
if (sq_option('admin_bar', 1) == '0'):
	remove_action('wp_footer','wp_admin_bar_render',1000);
	add_filter('show_admin_bar', '__return_false');
endif;



/***************************************************
:: MAINTENANCE MODE
***************************************************/
if (!function_exists('kleo_maintenance_mode')) {
	function kleo_maintenance_mode() {

		$logo_path = apply_filters('kleo_logo', sq_option_url('logo'));
		$logo_img = '<img src="'. $logo_path .'" alt="maintenance" style="margin: 0 auto; display: block;" />';
		
		if (sq_option('maintenance_mode', 0) == 1) {

			/* Theme My Login compatibility */
			if ( class_exists( 'Theme_My_Login' ) && Theme_My_Login::is_tml_page( 'login' ) ) {
				return;
			}

			if ( !current_user_can( 'edit_themes' ) || !is_user_logged_in() ) {
				wp_die(
						$logo_img 
							. '<div style="text-align:center">'
							. sq_option('maintenance_msg', '')
							. '</div>',
						get_bloginfo( 'name' )
					);
			}
		}
	}
	add_action('get_header', 'kleo_maintenance_mode');
}



/***************************************************
:: Get social profiles
***************************************************/

if (!function_exists('kleo_get_social_profiles')):

	function kleo_get_social_profiles($args=false)
	{
		$output = '';
		$icons = '';
		$all_options = get_option("kleo_".KLEO_DOMAIN);
		
	    $defaults 	 = array(
					'container'	=> 'ul',
					'item_tag' => 'li',
					'target' => '_blank'
	    );
		// Parse incomming $args into an array and merge it with $defaults
		$args = wp_parse_args( $args, $defaults );
		$args = apply_filters('kleo_get_social_profiles_args', $args);
		
		//get social data from theme options
		if (!empty($all_options)) {
			foreach ($all_options as $k => $opt)
			{
				if (substr( $k, 0, 7 ) === 'social_' && !empty($opt) ) {
					$k = str_replace('social_','',$k);
					$title = str_replace(
							array('gplus', 'vimeo-squared', 'pinterest-circled', 'instagramm'), 
							array('Google+', 'Vimeo','Pinterest', 'Instagram'), 
							$k
						);

					$icons .= '<' . $args['item_tag'] . '>';
					$icons .= '<a target="'.$args['target'].'" href="'.$opt.'"><i class="icon-'.$k.'"></i><div class="ts-text">'.ucfirst($title).'</div></a>';
					$icons .= '</' . $args['item_tag'] . '>';
				}
			}
		}
		
		$icons = apply_filters('kleo_get_social_profiles', $icons);
		if ($icons != '') {
			$output .= '<' . $args['container'] . ' class="kleo-social-icons">';
			$output .= $icons;
			$output .= '</' . $args['container'] . '>';
		}
		
		return $output;
		
	}
    add_shortcode( 'kleo_social_icons', 'kleo_get_social_profiles' );

endif;



/***************************************************
:: Ajax search in header main menu
***************************************************/

//if set from admin to show search
if ( sq_option( 'ajax_search', 1 ) == 1 || sq_option( 'ajax_search', 1 ) == 'logged_in' ) {
	add_filter( 'wp_nav_menu_items', 'kleo_search_menu_item', 200, 2 );
}

if(!function_exists('kleo_search_menu_item'))
{
	/**
	 * Add search to menu
	 * @param string $items
	 * @param object $args
	 * @return string
	 */
	function kleo_search_menu_item ( $items, $args )
	{
        if ( sq_option( 'ajax_search', 1 ) == 'logged_in' && ! is_user_logged_in() ) {
            return $items;
        }

	    if ($args->theme_location == 'primary')
	    {
          $form = kleo_get_search_menu_item();
	        $items .= '<li id="nav-menu-item-search" class="menu-item kleo-search-nav">' . $form . '</li>';
	    }
	    return $items;
	}
}
function kleo_get_search_menu_item() {

    $context = sq_option( 'search_context', '' );
    if ( is_array($context ) ) {
        $context = implode( ',', $context );
    }

    //Defaults
    $action = home_url( '/' );
    $hidden = '';
    $input_name = 's';
    if ( function_exists('bp_is_active') && $context == 'members' ) {
        //Buddypress members form link
        $action = bp_get_members_directory_permalink();

    } elseif ( function_exists( 'bp_is_active' ) && bp_is_active( 'groups' ) && $context == 'groups' ) {
        //Buddypress group directory link
        $action = bp_get_groups_directory_permalink();

    } elseif ( class_exists( 'bbPress' ) && $context == 'forum' ) {
        $action = bbp_get_search_url();
        $input_name = 'bbp_search';

    } elseif ( $context == 'product' ) {
        $hidden .= '<input type="hidden" name="post_type" value="product">';
    }


    ob_start();
    ?>
    <a class="search-trigger" href="#"><i class="icon icon-search"></i></a>
    <div class="kleo-search-wrap searchHidden" id="ajax_search_container">
    <form class="form-inline" id="ajax_searchform" action="<?php echo $action; ?>" data-context="<?php echo $context;?>">
        <?php echo $hidden;?>
        <input name="<?php echo $input_name;?>" class="ajax_s form-control" autocomplete="off" type="text" value="<?php if ( isset($_REQUEST['s']) ) { echo esc_attr($_REQUEST['s']); } ?>" placeholder="<?php _e( "Start typing to search...", "kleo_framework" );?>">
        <span class="kleo-ajax-search-loading"><i class="icon-spin6 animate-spin"></i></span>
    </form>
    <div class="kleo_ajax_results"></div>
    </div>

    <?php
    $form = ob_get_clean();
    return $form;
}

//Catch ajax requests
add_action( 'wp_ajax_kleo_ajax_search', 'kleo_ajax_search' );
add_action( 'wp_ajax_nopriv_kleo_ajax_search', 'kleo_ajax_search' );

if(!function_exists('kleo_ajax_search'))
{
	function kleo_ajax_search()
	{
		//if "s" input is missing exit
		if( empty( $_REQUEST['s'] ) && empty( $_REQUEST['bbp_search'] ) ) die();

		if( ! empty( $_REQUEST['bbp_search'] ) ) {
			$search_string = $_REQUEST['bbp_search'];
		} else {
			$search_string = $_REQUEST['s'];
		}

		$output = "";
        $context = "any";
		$defaults = array(
            'numberposts' => 4,
			'posts_per_page' => 20,
            'post_type' => 'any',
            'post_status' => 'publish',
            'post_password' => '',
            'suppress_filters' => false,
            's' => $_REQUEST['s']
        );

        if ( isset( $_REQUEST['context'] ) && $_REQUEST['context'] != '' ) {
            $context = explode( ",", $_REQUEST['context'] );
            $defaults['post_type'] = $context;
        }
		if ( ! empty( $defaults['post_type'] ) && is_array( $defaults['post_type'] ) ) {
			foreach ( $defaults['post_type'] as $ptk => $ptv ) {
				if ( $ptv == 'forum' ) {
					unset( $defaults['post_type'][$ptk] );
					break;
				}
			}
		}

		$defaults =  apply_filters( 'kleo_ajax_query_args', $defaults);

		$the_query = new WP_Query( $defaults );
		$posts = $the_query->get_posts();

        $members = array();
        $members['total'] = 0;
		$groups = array();
		$groups['total'] = 0;
        $forums = FALSE;


        if ( function_exists( 'bp_is_active' ) && ( $context == "any" || in_array( "members", $context ) ) ) {
            $members = bp_core_get_users(array('search_terms' => $search_string, 'per_page' => $defaults['numberposts'], 'populate_extras' => false));
        }

		if ( function_exists( 'bp_is_active' ) && bp_is_active("groups") && ( $context == "any" || in_array( "groups", $context ) ) ) {
			$groups = groups_get_groups(array('search_terms' => $search_string, 'per_page' => $defaults['numberposts'], 'populate_extras' => false));
		}

        if ( class_exists( 'bbPress' ) && ( $context == "any" || in_array( "forum", $context ) ) ) {
            $forums = kleo_bbp_get_replies( $search_string );
        }


        //if there are no posts, groups nor members
        if( empty( $posts ) && $members['total'] == 0 && $groups['total'] == 0 && ! $forums  ) {
			$output  = "<div class='kleo_ajax_entry ajax_not_found'>";
			$output .= "<div class='ajax_search_content'>";
			$output .= "<i class='icon icon-attention-circled'></i> ";
			$output .= __("Sorry, we haven't found anything based on your criteria.", 'kleo_framework');
			$output .= "<br>";
			$output .= __("Please try searching by different terms.", 'kleo_framework');
			$output .= "</div>";
			$output .= "</div>";
			echo $output;
			die();
		}

        //if there are members
        if ( $members['total'] != 0 ) {

            $output .= '<div class="kleo-ajax-part kleo-ajax-type-members">';
            $output .= '<h4><span>' . __("Members", 'kleo_framework') . '</span></h4>';
            foreach ( (array) $members['users'] as $member ) {
                $image = '<img src="' . bp_core_fetch_avatar(array('item_id' => $member-> ID, 'width' => 25, 'height' => 25, 'html' => false)) . '" class="kleo-rounded" alt="">';
                if ( $update = bp_get_user_meta( $member-> ID, 'bp_latest_update', true ) ) {
                    $latest_activity = char_trim( trim( strip_tags( bp_create_excerpt( $update['content'], 50,"..." ) ) ) );
                } else {
                    $latest_activity = '';
                }
                $output .= "<div class ='kleo_ajax_entry'>";
                $output .= "<div class='ajax_search_image'>$image</div>";
                $output .= "<div class='ajax_search_content'>";
                $output .= "<a href='" . bp_core_get_user_domain( $member->ID ) . "' class='search_title'>";
                $output .= $member->display_name;
                $output .= "</a>";
                $output .= "<span class='search_excerpt'>";
                $output .= $latest_activity;
                $output .= "</span>";
                $output .= "</div>";
                $output .= "</div>";
            }
            $output .= "<a class='ajax_view_all' href='" . esc_url( bp_get_members_directory_permalink() . "?s=" . $search_string ) . "'>" . __('View member results','kleo_framework') . "</a>";
            $output .= "</div>";
        }

		//if there are groups
		if ( $groups['total'] != 0 ) {

			$output .= '<div class="kleo-ajax-part kleo-ajax-type-groups">';
			$output .= '<h4><span>' . __("Groups", 'kleo_framework') . '</span></h4>';
			foreach ( (array) $groups['groups'] as $group ) {
				$image = '<img src="' . bp_core_fetch_avatar(array('item_id' => $group->id, 'object'=>'group', 'width' => 25, 'height' => 25, 'html' => false)) . '" class="kleo-rounded" alt="">';
				$output .= "<div class ='kleo_ajax_entry'>";
				$output .= "<div class='ajax_search_image'>$image</div>";
				$output .= "<div class='ajax_search_content'>";
				$output .= "<a href='" . bp_get_group_permalink( $group ) . "' class='search_title'>";
				$output .= $group->name;
				$output .= "</a>";
				$output .= "</div>";
				$output .= "</div>";
			}
			$output .= "<a class='ajax_view_all' href='" . esc_url( bp_get_groups_directory_permalink() . "?s=" . $search_string ) . "'>" . __('View group results','kleo_framework') . "</a>";
			$output .= "</div>";
		}

		//if there are posts
        if( ! empty( $posts ) ) {
            $post_types = array();
            $post_type_obj = array();
            foreach ( $posts as $post ) {
                $post_types[$post->post_type][] = $post;
                if (empty($post_type_obj[$post->post_type])) {
                    $post_type_obj[$post->post_type] = get_post_type_object($post->post_type);
                }
            }

            foreach ($post_types as $ptype => $post_type) {
                $output .= '<div class="kleo-ajax-part kleo-ajax-type-' . esc_attr( $post_type_obj[$ptype]->name ) . '">';
                if (isset($post_type_obj[$ptype]->labels->name)) {
                    $output .= "<h4><span>" . $post_type_obj[$ptype]->labels->name . "</span></h4>";
                } else {
                    $output .= "<hr>";
                }
				$count = 0;
                foreach ($post_type as $post) {

					$count++;
					if ($count > 4) {
						continue;
					}
                    $format = get_post_format( $post->ID );
                    if ( $img_url = kleo_get_post_thumbnail_url( $post->ID ) ) {
                        $image = aq_resize( $img_url, 44, 44, true, true, true );
                        if( ! $image ) {
                            $image = $img_url;
                        }
                        $image = '<img src="'. $image .'" class="kleo-rounded">';
                    } else {
                        if ($format == 'video') {
                            $image = "<i class='icon icon-video'></i>";
                        } elseif ($format == 'image' || $format == 'gallery') {
                            $image = "<i class='icon icon-picture'></i>";
                        } else {
                            $image = "<i class='icon icon-link'></i>";
                        }
                    }

                    $excerpt = "";

                    if ( ! empty($post->post_content) ) {
	                    $excerpt = $post->post_content;
	                    $excerpt = preg_replace("/\[(.*?)(?:(\/))?\](?:(.+?)\[\/\2\])?/s",'', $excerpt);
	                    $excerpt = char_trim( trim(strip_tags($excerpt)), 40, "..." );
                    }
                    $link = apply_filters('kleo_custom_url', get_permalink($post->ID));
                    $classes = "format-" . $format;
                    $output .= "<div class ='kleo_ajax_entry $classes'>";
                    $output .= "<div class='ajax_search_image'>$image</div>";
                    $output .= "<div class='ajax_search_content'>";
                    $output .= "<a href='$link' class='search_title'>";
                    $output .= get_the_title($post->ID);
                    $output .= "</a>";
                    $output .= "<span class='search_excerpt'>";
                    $output .= $excerpt;
                    $output .= "</span>";
                    $output .= "</div>";
                    $output .= "</div>";
                }
                $output .= '</div>';
            }

            $output .= "<a class='ajax_view_all' href='" . esc_url( home_url( '/' ) . '?s=' . $search_string ) . "'>" . __('View all results', 'kleo_framework') . "</a>";
        }

        /* Forums topics search */
        if( ! empty( $forums ) ) {
            $output .= '<div class="kleo-ajax-part kleo-ajax-type-forums">';
            $output .= '<h4><span>' . __("Forums", 'kleo_framework') . '</span></h4>';

			$i = 0;
            foreach ( $forums as $fk => $forum ) {

				$i++;
				if ($i <= 4 ) {
					$image = "<i class='icon icon-chat-1'></i>";

					$output .= "<div class ='kleo_ajax_entry'>";
					$output .= "<div class='ajax_search_image'>$image</div>";
					$output .= "<div class='ajax_search_content'>";
					$output .= "<a href='" . $forum['url'] . "' class='search_title'>";
					$output .= $forum['name'];
					$output .= "</a>";
					//$output .= "<span class='search_excerpt'>";
					//$output .= $latest_activity;
					//$output .= "</span>";
					$output .= "</div>";
					$output .= "</div>";
				}
            }
            $output .= "<a class='ajax_view_all' href='" . esc_url( bbp_get_search_url() . "?bbp_search=" . $search_string ) . "'>" . __('View forum results','kleo_framework') . "</a>";
            $output .= "</div>";
        }


		echo $output;
		die();
	}
}

if(!function_exists('kleo_bbp_get_replies'))
{
	function kleo_bbp_get_replies($title = '')
	{
		global $wpdb;
		$topic_matches = array();

		/* First do a title search */
		$topics = $wpdb->get_results('SELECT * FROM ' . $wpdb->posts . ' WHERE post_title LIKE "%' . esc_sql(trim($title)) . '%" AND post_type="topic" AND post_status="publish"');

		/* do a tag search if title search doesn't have results */
		if (!$topics) {
			$topic_tags = get_terms('topic-tag');

			if (empty($topic_tags)) {
				return $topic_matches;
			}

			foreach ($topic_tags as $tid => $tag) {
				$tags[$tag->term_id] = $tag->name;
			}

			$tag_matches = kleo_bbp_stristr_array($title, $tags);

			$args = array(
				'post_type' => 'topic',
				'showposts' => -1,
				'tax_query' => array(
					array(
						'taxonomy' => 'topic-tag',
						'field' => 'term_id',
						'terms' => $tag_matches
					)
				)
			);

			$topics = get_posts($args);
		}

		/* Compile results into array*/
		foreach ($topics as $topic) {
			$topic_matches[$topic->ID]['name'] = $topic->post_title;
			$topic_matches[$topic->ID]['url'] = get_post_permalink($topic->ID);
		}


		return $topic_matches;

	}
}

function kleo_bbp_stristr_array( $haystack, $needles ) {

    $elements = array();


    foreach ( $needles as $id => $needle )
    {
        if ( stristr( $haystack, $needle ) )
        {
            $elements[] = $id;
        }
    }

    return $elements;
}



/***************************************************
:: WPML language switch
***************************************************/

if( !function_exists('kleo_wpml_wp_nav_menu_items_filter') && function_exists('icl_get_languages') ){
	function kleo_wpml_wp_nav_menu_items_filter( $items, $args ){
		if( $args->theme_location == 'primary' ) {
			$items = str_replace( '<a href="#" onclick="return false">', '<a href="#" class="js-activated">', $items );
			$items = str_replace( '</a><ul class="sub-menu submenu-languages">', '<span class="caret"></span></a><ul class="sub-menu submenu-languages dropdown-menu pull-left">', $items );
		}
		return $items;
	}
	add_filter( 'wp_nav_menu_items', 'kleo_wpml_wp_nav_menu_items_filter', 10, 2 );
}

if (!function_exists('kleo_lang_menu_item')):
	
	function kleo_lang_menu_item ( $items, $args )
	{
		if ($args->theme_location == 'top')
		{
			$items .= kleo_get_languages();
		}
		
		return $items;
	}
	
endif;						
										
if(sq_option('show_lang',1) == 1) {
	add_filter( 'wp_nav_menu_items', 'kleo_lang_menu_item', 10, 2 );
}

function kleo_get_languages() {

  global $sitepress_settings;
	$output = '';
	$active = '';
	$items = '';

	if (function_exists('icl_get_languages')) {
		$languages = icl_get_languages('skip_missing=0&orderby=code');

		if( ! empty( $languages ) ){
			foreach( $languages as $code => $lang )
			{
        
				$items .= '<li>';
        
        $alt_title_lang = $sitepress_settings['icl_lso_native_lang'] ? esc_attr($lang['native_name']) : esc_attr($lang['translated_name']);
        
        $entry = '';
        
        if( $sitepress_settings['icl_lso_flags'] ){
            $entry .= '<img class="iclflag" src="' . $lang['country_flag_url'] . '" width="18" height="12" alt="' . $alt_title_lang . '" title="' . $alt_title_lang . '" /> ';
        }
        if($sitepress_settings['icl_lso_native_lang']){
            $entry .= $lang['native_name'];
        }
        if($sitepress_settings['icl_lso_display_lang'] && $sitepress_settings['icl_lso_native_lang']){
            $entry .= ' (';
        }
        if($sitepress_settings['icl_lso_display_lang']){
            $entry .= $lang['translated_name'];
        }
        if($sitepress_settings['icl_lso_display_lang'] && $sitepress_settings['icl_lso_native_lang']){
            $entry .= ')';
        }
        

        if( ! $lang['active'] ) {
          $items .= '<a href="' . $lang['url'] . '">' . $entry . '</a>';
        } else {
          $active = '<a href="' . $lang['url'] . '" class="dropdown-toggle js-activated current-language" data-toggle="dropdown">' . $entry .  (count($languages) > 1 ? ' <span class="caret"></span>' : '') . '</a>';
        }

				$items .= '</li>';
			}
		}

		$output .= ' <li class="' . ( count( $languages ) > 1 ? 'dropdown' : '' ) . ' kleo-langs">'
      . $active 
      . '<ul class="dropdown-menu pull-right">'
			. $items
			.'</ul></li>';
	}

	return $output;
}


/***************************************************
:: Go up button
***************************************************/
function kleo_go_up() 
{
	?>
	<a class="kleo-go-top" href="#"><i class="icon-up-open-big"></i></a>
	<?php
}

if(sq_option('go_top',1) == 1) {
	add_action('kleo_after_footer', 'kleo_go_up');
}



/***************************************************
:: Bottom contact form
***************************************************/

if (!function_exists('kleo_contact_form')) {
	function kleo_contact_form( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'title'    	 => 'CONTACT US',
			'builtin_form' => 1
		), $atts));
	
		$output = '';
		
		$output .= '<div class="kleo-quick-contact-wrapper">'
			.'<a class="kleo-quick-contact-link" href="#"><i class="icon-mail-alt"></i></a>'
			.'<div id="kleo-quick-contact">'
				.'<h4 class="kleo-qc-title">'. $title .'</h4>'
				.'<p>'. do_shortcode($content).'</p>';
		if( $builtin_form == 1 ) {
			$output .= '<form class="kleo-contact-form" action="#" method="post" novalidate>'
				. '<input type="text" placeholder="' . __("Your Name", 'kleo_framework') . '" required id="contact_name" name="contact_name" class="form-control" value="" tabindex="276" />'
				. '<input type="email" required placeholder="' . __("Your Email", 'kleo_framework') . '" id="contact_email" name="contact_email" class="form-control" value="" tabindex="277"  />'
				. '<textarea placeholder="' . __("Type your message...", 'kleo_framework') . '" required id="contact_content" name="contact_content" class="form-control" tabindex="278"></textarea>'
				. '<input type="hidden" name="action" value="kleo_sendmail">'
				. '<button tabindex="279" class="btn btn-default pull-right" type="submit">' . __("Send", 'kleo_framework') . '</button>'
				. '<div class="kleo-contact-loading">' . __("Sending", 'kleo_framework') . ' <i class="icon-spinner icon-spin icon-large"></i></div>'
				. '<div class="kleo-contact-success"> </div>'
				. '</form>';
		}
		$output .= '<div class="bottom-arrow"></div>'
			.'</div>'
		.'</div><!--end kleo-quick-contact-wrapper-->';
			
		return $output;
	}
	add_shortcode('kleo_contact_form', 'kleo_contact_form');
}


if (!function_exists('kleo_sendmail')): 
	function kleo_sendmail()
	{
		if(isset($_POST['action'])) {

			$error_tpl = "<span class='mail-error'>%s</span>";
			
			//contact name
			if(trim($_POST['contact_name']) === '') 
			{
				printf($error_tpl, __('Please enter your name.','kleo_framework') );
				die();
			}
			else 
			{
				$name = trim($_POST['contact_name']);
			}

			///contact email
			if(trim($_POST['contact_email']) === '') 
			{
				printf($error_tpl, __('Please enter your email address.','kleo_framework') );
				die();
			} 
			elseif (!preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+.[a-z]{2,4}$/i", trim($_POST['contact_email']))) 
			{
				printf($error_tpl, __('You entered an invalid email address.','kleo_framework') );
				die();
			} 
			else 
			{
				$email = trim($_POST['contact_email']);
			}

			//message
			if(trim($_POST['contact_content']) === '') 
			{
				printf($error_tpl, __('Please enter a message.','kleo_framework') );
				die();
			} 
			else 
			{
				if(function_exists('stripslashes')) {
					$comment = stripslashes(trim($_POST['contact_content']));
				} else {
					$comment = trim($_POST['contact_content']);
				}
			}

			$emailTo = sq_option('contact_form_to','');
			if (!isset($emailTo) || ($emailTo == '') )
			{
				$emailTo = get_option('admin_email');
			}

			$subject = __( 'Contact Form Message', 'kleo_framework' );
			apply_filters( 'kleo_contact_form_subject', $subject );

			$body = __("You received a new contact form message:", 'kleo_framework') . "\n";
			$body .= __("Name: ", 'kleo_framework') . $name . "\n";
			$body .= __("Email: ", 'kleo_framework') .$email . "\n" ;
			$body .= __("Message: ", 'kleo_framework') . $comment . "\n";

			$headers[] = "Content-type: text/html";
			$headers[] = "Reply-To: $name <$email>";
			apply_filters('kleo_contact_form_headers',$headers);

			if(wp_mail($emailTo, $subject, $body, $headers))
			{
				echo '<span class="mail-success">' . __("Thank you. Your message has been sent.", 'kleo_framework').' <i class="icon-ok icon-large"></i></span>';

				do_action('kleo_after_contact_form_mail_send', $name, $email, $comment);
			}
			else
			{
				printf($error_tpl, __("Mail couldn't be sent. Please try again!",'kleo_framework') );
			}

		}
		else
		{
			printf($error_tpl, __("Unknown error occurred. Please try again!",'kleo_framework') );
		}
		 die();
	}
endif;


function kleo_show_contact_form() 
{
	$title = sq_option('contact_form_title','');
	$content = sq_option('contact_form_text','');
	$builtin_form = sq_option('contact_form_builtin', 1);
	
	echo do_shortcode('[kleo_contact_form title="'.$title.'" builtin_form="'.$builtin_form.'"]'.$content.'[/kleo_contact_form]');
}

if(sq_option('contact_form',1) == 1) {
	add_action('wp_ajax_kleo_sendmail', 'kleo_sendmail');
	add_action('wp_ajax_nopriv_kleo_sendmail', 'kleo_sendmail');
	add_action('kleo_after_footer', 'kleo_show_contact_form');
}




/***************************************************
:: SOCKET AREA
***************************************************/
function kleo_show_socket() 
{
	get_template_part('page-parts/socket');
}

if (sq_option('socket_enable', 1) == 1) {
	add_action('kleo_after_footer', 'kleo_show_socket');
}





/***************************************************
:: EXCERPT
***************************************************/

if ( ! function_exists( 'kleo_new_excerpt_length' ) ) {
	function kleo_new_excerpt_length($length) {
        return 60;
	}
	add_filter('excerpt_length', 'kleo_new_excerpt_length');
}

if ( ! function_exists( 'kleo_excerpt' ) ) {
	function kleo_excerpt( $limit = 20, $words = true ) {

		$from_content = false;
		$excerpt_initial = get_the_excerpt();

		if( $excerpt_initial == '' ) {
			$excerpt_initial = get_the_content();
			$from_content = true;
		}
		$excerpt_initial = preg_replace( '`\[[^\]]*\]`', '', $excerpt_initial );
		$excerpt_initial = strip_tags( $excerpt_initial );

		/* If we got it from get_the_content -> apply length restriction */
		if ( $from_content ) {
			$excerpt_length = apply_filters( 'excerpt_length', $limit );
			$excerpt_initial = wp_trim_words( $excerpt_initial, $excerpt_length, '' );
		}

        if ( $words ) {
            $excerpt = explode( ' ', $excerpt_initial, $limit );
            if ( count( $excerpt ) >= $limit ) {
                array_pop( $excerpt );
                $excerpt = implode( " ", $excerpt ) . '...';
            } else {
                $excerpt = implode( " ", $excerpt ) . '';
            }
        } else {
            $excerpt = substr( $excerpt_initial, 0, $limit ) . ( strlen( $excerpt_initial ) > $limit ? '...' : '' );
        }

		return '<p>' . $excerpt . '</p>';
	}
}


if ( ! function_exists( 'kleo_has_shortcode' ) ) {
	function kleo_has_shortcode( $shortcode = '', $post_id = null ) {

		if ( ! $post_id ) {
			if ( ! is_singular() ) {
				return false;
			}
			$post_id = get_the_ID();
		}
		
		if ( is_page() || is_single() ) {
			$current_post = get_post( $post_id );
			$post_content  = $current_post->post_content;
			$found         = false;

			if ( ! $shortcode ) {
				return $found;
			}

			if ( stripos( $post_content, '[' . $shortcode ) !== false ) {
				$found = true;
			}

			return $found;
		} else {
			return false;
		}
	}
}

if ( ! function_exists( 'kleo_icons_array' ) ) {
	function kleo_icons_array( $prefix = '', $before = array( '' ) ) {

		// Get any existing copy of our transient data
		$transient_name = 'kleo_font_icons_' . $prefix . implode( '', $before );

		if ( false === ( $icons = get_transient( $transient_name ) ) ) {

			// It wasn't there, so regenerate the data and save the transient
			$icons = $before;

			$icons_json = file_get_contents( THEME_DIR . '/assets/font/config.json' );
			if ( is_child_theme() && file_exists( CHILD_THEME_DIR . '/assets/css/fontello.css' )) {
				$icons_json = file_get_contents( CHILD_THEME_DIR . '/assets/config.json' );
			}

			if ( $icons_json ) {
				$arr = json_decode( $icons_json, true );
				foreach($arr['glyphs'] as $icon)
				{
					$icons[$prefix . $icon['css']] = $icon['css'];
				}
				asort($icons);
			}

			// set transient for one day
			set_transient( $transient_name, $icons, 86400 );
		}

		return $icons;
	}
}
add_action( 'kleo-opts-saved', 'kleo_delete_font_transient' );
function kleo_delete_font_transient() {
	delete_transient( 'kleo_font_icons_' );
}

if ( ! function_exists( 'kleo_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 *
 * @since Kleo 1.0
 *
 * @return void
 */
function kleo_post_nav( $same_cat = false ) {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( $same_cat, '', true );
	$next     = get_adjacent_post( $same_cat, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	
	<nav class="pagination-sticky member-navigation" role="navigation">
		<?php
		if ( is_attachment() ) :
			previous_post_link( '%link', __( '<span id="older-nav">Go to article</span>', 'kleo_framework' ) );
		else :
            if ($previous) {
                previous_post_link( '%link',  '<span id="older-nav"><span class="outter-title"><span class="entry-title">' . $previous->post_title . '</span></span></span>', $same_cat );
            }
            if ($next) {
			    next_post_link( '%link', '<span id="newer-nav"><span class="outter-title"><span class="entry-title">' . $next->post_title . '</span>', $same_cat );
            }
        endif;
		?>
	</nav><!-- .navigation -->
	
	<?php
}
endif;

/**
 * Check to see if post meta is enabled for a single post
 * @return int
 */
function kleo_postmeta_enabled() {

    if (! is_single() ) {
        return 1;
    }

    /* If we set it via a shortcode */
    global $kleo_config;
    if ( isset( $kleo_config['post_meta_enabled'] ) ) {
        if ( $kleo_config['post_meta_enabled'] ) {
            return 1;
        } else {
            return 0;
        }
    }

	$meta_status = sq_option( 'blog_meta_status', 1 );
	
	if( get_cfield( 'meta_checkbox' ) == 1 ) {
		$meta_status = 0;
	}
	return $meta_status;
}


/**
 * Check to see if post media is enabled for a single post page
 * @param string media_option
 * @param int default
 * @return int
 */
function kleo_postmedia_enabled( $media_option = 'blog_media_status', $default = 1 ) {


    global $conditional_thumb;
    global $wp_query;

	if ( ! is_singular() ) {

        //check for shortcode thumbnail condition
        if ( isset( $conditional_thumb ) ) {
            if( $wp_query->current_post > ( $conditional_thumb - 1 ) ) {
                return false;
            }
        }

		return 1;
	}

	$media_status = sq_option( $media_option, $default );
	$post_status = get_cfield( 'post_media_status' );

	if( $post_status != '' ) {
		$media_status = get_cfield( 'post_media_status' );
	}

	return $media_status;
}

if ( ! function_exists( 'kleo_get_img_overlay' ) ) {

	function kleo_get_img_overlay() {
		global $kleo_config;

		if ( isset( $kleo_config['image_overlay'] ) ) {
			return $kleo_config['image_overlay'];
		}

		return '';
	}

}



/***************************************************
:: Facebook Integration
***************************************************/

if (!function_exists('kleo_fb_button')) :
	function kleo_fb_button()
	{
		echo kleo_get_fb_button();
	}
endif;
if (!function_exists('kleo_get_fb_button')) :
	function kleo_get_fb_button()
	{
		ob_start();
		?>
			<div class="kleo-fb-wrapper text-center">
				<a href="#" class="kleo-facebook-connect btn btn-default "><i class="icon-facebook"></i> &nbsp;<?php _e("Log in with Facebook", 'kleo_framework');?></a>
			</div>
			<div class="gap-20"></div>
			<div class="hr-title hr-full"><abbr> <?php echo __("or", "kleo_framework");?> </abbr></div>
		<?php

		$output = ob_get_clean();

		return $output;
	}
endif;

if (!function_exists('kleo_fb_button_regpage')) :
	function kleo_fb_button_regpage()
	{
		echo kleo_get_fb_button_regpage();
	}
endif;
if (!function_exists('kleo_get_fb_button_regpage')) :
	function kleo_get_fb_button_regpage()
	{
		ob_start();
		?>
			<div class="kleo-fb-wrapper text-center">
				<a href="#" class="kleo-facebook-connect btn btn-default "><i class="icon-facebook"></i> &nbsp;<?php _e("Log in with Facebook", 'kleo_framework');?></a>
			</div>
			<div class="gap-30"></div>
			<div class="hr-title hr-full"><abbr> <?php echo __("or", "kleo_framework");?> </abbr></div>
			<div class="gap-10"></div>
		<?php
		$output = ob_get_clean();

		return $output;
	}
endif;

if (!function_exists('kleo_fb_button_shortcode')) :
	function kleo_fb_button_shortcode()
	{
		$output = '';
		if ( sq_option( 'facebook_login', 0 ) == 1 && get_option( 'users_can_register' ) && !is_user_logged_in() ) {
			$output .= '<a href="#" class="kleo-facebook-connect btn btn-default "><i class="icon-facebook"></i> &nbsp; ' . __("Log in with Facebook", 'kleo_framework') . '</a>';
		}
		return $output;
	}
	add_shortcode('kleo_fb_button', 'kleo_fb_button_shortcode');
endif;

if ( sq_option( 'facebook_login', 0 ) == 1 ) {
	add_action('bp_before_login_widget_loggedout', 'kleo_fb_button' );
    add_action( 'login_form', 'kleo_fb_button', 10 );
    add_action( 'kleo_before_login_form', 'kleo_fb_button', 10 );
    add_action( 'kleo_before_register_form_modal', 'kleo_fb_button', 10 );

	if (  class_exists( 'WooCommerce' ) ) {
		add_action( 'woocommerce_login_form_start', 'kleo_fb_button', 10 );
	}
  
	if (sq_option('facebook_register', 0) == 1) {
		add_action('bp_before_register_page', 'kleo_fb_button_regpage' );
	}
}



/***************************************************
:: oEmbed manipulation for youtube/vimeo video
***************************************************/

if ( ! function_exists( 'kleo_add_video_wmode_transparent' ) ) :
	/**
	 * Automatically add wmode=transparent to embeded media
	 * Automatically add showinfo=0 for youtube
	 * @param type $html
	 * @param type $url
	 * @param type $attr
	 * @return type
	 */
	function kleo_add_video_wmode_transparent($html, $url, $attr)
	{
		if (strpos($html, "youtube.com") !== NULL || strpos($html, "youtu.be") !== NULL) {
			$info = "&amp;showinfo=0";
		}
		else {
			$info = "";
		}

		if ( strpos( $html, "<embed src=" ) !== false ) {
			return str_replace('</param><embed', '</param><param name="wmode" value="opaque"></param><embed wmode="opaque" ', $html); 
		}
		elseif ( strpos ( $html, 'feature=oembed' ) !== false ) { 
			return str_replace( 'feature=oembed', 'feature=oembed&amp;wmode=opaque'.$info, $html ); 
		}
		else {
			return $html;
		}
	}
endif;

add_filter( 'oembed_result', 'kleo_add_video_wmode_transparent', 10, 3);

if (!function_exists('kleo_oembed_filter')):
	function kleo_oembed_filter( $return, $data, $url ) {
		$return = str_replace('frameborder="0"', 'style="border: none"', $return);
		return $return;
	}
endif;

add_filter('oembed_dataparse', 'kleo_oembed_filter', 90, 3 );



/***************************************************
:: Apply oEmbed for post video format
***************************************************/
add_filter( 'kleo_oembed_video', array( $wp_embed, 'autoembed'), 8 );



/***************************************************
:: Custom taxonomy header content
***************************************************/

if(function_exists('get_term_meta')) {
	
	/* GET CUSTOM HEADER CONTENT FOR CATEGORY */
	add_action('kleo_before_main', 'kleo_taxonomy_header', 9);
	
	function kleo_taxonomy_header() {
		$queried_object = get_queried_object();
		if (isset($queried_object->term_id)){

			$term_id = $queried_object->term_id;  
			$content = get_term_meta($term_id, 'cat_meta');

			if( isset( $content[0]['cat_header'] ) && $content[0]['cat_header'] != '' ) {
				echo '<section class="kleo-cat-header container-wrap main-color">';
				echo do_shortcode( $content[0]['cat_header'] );
				echo '</section>';
			}
		}
	}
	
	/* ADD CUSTOM META BOX TO CATEGORY PAGES */
	function kleo_taxonomy_edit_meta_field($term) {
		// put the term ID into a variable
		$t_id = $term->term_id;
		// retrieve the existing value(s) for this meta field. This returns an array
		$term_meta = get_term_meta($t_id,'cat_meta');
		if(!$term_meta){$term_meta = add_term_meta($t_id, 'cat_meta', '');}
		 ?>
		<tr class="form-field">
		<th scope="row" valign="top"><label for="term_meta[cat_header]"><?php _e( 'Top Content', 'kleo_framework' ); ?></label></th>
			<td>				
					<?php 
					$content = (isset( $term_meta[0]['cat_header'] ) && $term_meta[0]['cat_header'] != '' ) ? esc_attr( $term_meta[0]['cat_header'] ) : '';
					echo '<textarea id="term_meta[cat_header]" name="term_meta[cat_header]">'.$content.'</textarea>'; ?>
				<p class="description"><?php _e( 'This will be displayed at top of the category page. Shortcodes are allowed.','kleo_framework' ); ?></p>
			</td>
		</tr>
	<?php
	}
	add_action( 'product_cat_edit_form_fields', 'kleo_taxonomy_edit_meta_field', 10, 2 );

	/* SAVE CUSTOM META*/
	/**
	 * @param $term_id
	 */
	function kleo_save_taxonomy_custom_meta( $term_id ) {
		if ( isset( $_POST['term_meta'] ) ) {
			$t_id = $term_id;
			$term_meta = get_term_meta($t_id,'cat_meta');
			$cat_keys = array_keys( $_POST['term_meta'] );
			foreach ( $cat_keys as $key ) {
				if ( isset ( $_POST['term_meta'][$key] ) ) {
					$term_meta[$key] = $_POST['term_meta'][$key];
				}
			}
			// Save the option array.
			update_term_meta($term_id, 'cat_meta', $term_meta);

		}
	}  
	add_action( 'edited_product_cat', 'kleo_save_taxonomy_custom_meta', 10, 2 );  
}



/***************************************************
:: Add custom HTML to page header set from Page edit
 ***************************************************/

add_action( 'kleo_before_main', 'kleo_header_content', 8 );

function kleo_header_content() {
    if ( is_singular() || is_home() ) {
        $page_header = get_cfield('header_content');
        if( $page_header != '' ) {
            echo '<section class="kleo-page-header container-wrap main-color">';
            echo do_shortcode( html_entity_decode( $page_header) );
            echo '</section>';
        }
    } else {
        return false;
    }
}



/***************************************************
:: Add custom HTML to bottom page set from Page edit
 ***************************************************/

add_action( 'kleo_after_main_content', 'kleo_bottom_content', 12 );

function kleo_bottom_content() {
    if ( is_singular() || is_home() ) {
        $page_bottom = get_cfield('bottom_content');
        if( $page_bottom != '' ) {
            echo '<div class="kleo-page-bottom">';
            echo do_shortcode( html_entity_decode($page_bottom) );
            echo '</div>';
        }
    }else{
        return false;
    }
}



/***************************************************
:: rtMedia small compatibility
***************************************************/

if ( class_exists( 'RTMedia' ) ) {
	add_action('wp_enqueue_scripts', 'kleo_rtmedia_scripts', 999);

	function kleo_rtmedia_scripts() {
		//wp_dequeue_style('rtmedia-font-awesome');
		wp_dequeue_style('rtmedia-magnific');
		wp_dequeue_script('rtmedia-magnific');
		wp_dequeue_script('rtmedia-touchswipe');
	}

    add_filter( 'body_class', 'kleo_rtmedia_class');
    function kleo_rtmedia_class( $classes ) {
        $classes[] = 'rtm-' . RTMEDIA_VERSION ;
        return $classes;
    }

	global $rtmedia_admin;
	remove_action( 'admin_notices', array( $rtmedia_admin, 'rtmedia_admin_notices' ) );

}



/***************************************************
:: WP Multisite Sign-up page
 ***************************************************/
add_action( 'before_signup_form', 'kleo_mu_before_page' );
function kleo_mu_before_page() {
    get_template_part('page-parts/general-before-wrap');
}

add_action( 'after_signup_form', 'kleo_mu_after_page' );
function kleo_mu_after_page() {
    get_template_part('page-parts/general-after-wrap');
    echo '<style>'
        . '.mu_register input[type="submit"], .mu_register #blog_title, .mu_register #user_email, .mu_register #blogname, .mu_register #user_name {font-size: inherit;}'
        . '.mu_register input[type="submit"] {width: auto;}'
        .'</style>'
        . '<script>jQuery(document).ready(function() {  jQuery(\'.mu_register input[type="submit"]\').addClass("btn btn-default"); });</script>';

}
/***************************************************
:: WP Multisite Activate page
 ***************************************************/
if ( defined('WP_INSTALLING') && WP_INSTALLING == true ) {
    add_action( 'kleo_before_main', 'kleo_mu_before_page' );
    add_action( 'kleo_after_main', 'kleo_mu_after_page' );
}



/**
 * Translate column proportions to classes
 * @param string $width
 * @return string
 */
function kleo_translateColumnWidth( $width ) {
    if ( preg_match( '/^(\d{1,2})\/12$/', $width, $match ) ) {
        $w = 'vc_col-sm-'.$match[1];
    } else {
        $w = 'vc_col-sm-';
        switch ( $width ) {
            case "1/6" :
                $w .= '2';
                break;
            case "1/4" :
                $w .= '3';
                break;
            case "1/3" :
                $w .= '4';
                break;
            case "1/2" :
                $w .= '6';
                break;
            case "2/3" :
                $w .= '8';
                break;
            case "3/4" :
                $w .= '9';
                break;
            case "5/6" :
                $w .= '10';
                break;
            case "1/1" :
                $w .= '12';
                break;
			/* custom 5 columns */
			case "1/5" :
				$w = 'col-sm-1-5';
				break;

            default :
                $w = $width;
        }
    }
    return $w;
}



/**
 * GET CUSTOM POST TYPE TAXONOMY LIST
 */
function kleo_get_category_list( $category_name, $filter = 0, $category_child = "" ){

	if ( $category_child != "" && $category_child != "All" ) {

        $childcategory = get_term_by( 'slug', $category_child, $category_name );
        $get_category = get_categories( array( 'taxonomy' => $category_name, 'child_of' => $childcategory->term_id ) );
        $category_list = array( '0' => 'All');

        foreach( $get_category as $category ) {
            if (isset($category->cat_name)) {
                $category_list[] = $category->slug;
            }
        }

        return $category_list;

    } else {
		if ( ! $filter ) {

			$get_category = get_categories( array( 'taxonomy' => $category_name	));
			$category_list = array( '0' => 'All');

			foreach( $get_category as $category ){
				if (isset($category->slug)) {
					$category_list[] = $category->slug;
				}
			}

			return $category_list;

		} else {
			$get_category  = get_categories( array( 'taxonomy' => $category_name ) );
			$category_list = array( '0' => 'All' );

			foreach ( $get_category as $category ) {
				if ( isset( $category->cat_name ) ) {
					$category_list[] = $category->cat_name;
				}
			}

			return $category_list;
		}

    }
}

function kleo_get_category_list_key_array( $category_name, $key = 'slug' ) {

    $get_category = get_categories( array( 'taxonomy' => $category_name	));
    $category_list = array( 'all' => 'All');

    foreach( $get_category as $category ){
        if (isset($category->{$key})) {
            $category_list[$category->{$key}] = $category->cat_name;
        }
    }

    return $category_list;
}



/***************************************************
:: Custom main menu select for each page
 ***************************************************/
if( ! is_admin() ) {
    add_filter('wp_nav_menu_args', 'kleo_set_custom_menu');
}
function kleo_set_custom_menu( $args = '' ) {

    if( 'primary' != $args['theme_location'] ) {
        return $args;
    }

    global $post;

    if( ! empty( $post ) ) {
        $menuslug = get_cfield( 'page_menu', $post->ID );

        if( ! empty( $menuslug ) && $menuslug != 'default' && is_nav_menu( $menuslug ) ) {
            $args['menu'] = $menuslug;
        }

    } // END if(!empty($post))

    return $args;
} // END function kleo_set_custom_menu($args = '')



/***************************************************
:: SIDE MENU
 ***************************************************/

//if set from admin to show side button
if (sq_option( 'side_menu', 0 ) == 1 ) {

    if ( sq_option( 'side_menu_button', 0 ) == 1 ) {
        add_filter('wp_nav_menu_items', 'kleo_side_menu_button', 20, 2);
    }

    add_filter( 'body_class', 'kleo_offcanvas_classes' );
    add_action('kleo_after_page', 'kleo_show_side_menu');
}

if( ! function_exists( 'kleo_side_menu_button' ) ) {
    /**
     * Add side button to menu
     * @param string $items
     * @param object $args
     * @return string
     */
    function kleo_side_menu_button ( $items, $args )
    {
        if ($args->theme_location == 'primary')
        {
            $items .= '<li id="nav-menu-item-side" class="menu-item">' .
                '<a href="#" class="open-sidebar" onclick="javascript:return false;">' .
                '<i class="icon-menu"></i>' .
                '</a>' .
                '</li>';
        }
        return $items;
    }
}

function kleo_show_side_menu()
{
    $side_menu = wp_nav_menu(array(
            'theme_location' => 'side',
            'depth' => 3,
            'container' => '',
            'menu_class' => 'offcanvas-menu',
            'fallback_cb' => '',
            'walker' => new kleo_walker_nav_menu(),
            'echo' => false
        )
    );
    echo '<div class="offcanvas-sidebar side-color">' .
        '<div class="wrap-canvas-menu">' .
        '<div class="offcanvas-title">' .
        '<a href="#" class="open-sidebar"></a>' .
        '</div>' .
        '<div class="offcanvas-before">' . do_shortcode(sq_option('side_menu_before')) . '</div>' .
        '<div class="widget_nav_menu">' .
        $side_menu .
        '</div>' .
        '<div class="offcanvas-after">' . do_shortcode(sq_option('side_menu_after')) . '</div>' .
        '</div>' .
        '</div>';
}



function kleo_offcanvas_classes( $classes = '' ) {

    if ( sq_option( 'side_menu', 0 ) == 1 ) {
        $classes[] = 'offcanvas-' . sq_option( 'side_menu_position', 'left' );
        $classes[] = 'offcanvas-type-' . sq_option( 'side_menu_type', 'default' );
    }

    return $classes;

}



/***************************************************
:: BLOG CUSTOMISATIONS
 ***************************************************/

if ( ! function_exists( 'kleo_view_switch' ) ) {
    /**
     * Show post layout type switcher
     *
     * @param array $layouts
     * @param string $active
     * @param string $identifier
     */
    function kleo_view_switch( $layouts, $active = '', $identifier = '' ) {

        echo '<div class="kleo-view-switch">' .
            '<ul>';

        foreach ( $layouts as $layout ) {

            $selected = '';
            if ( $active  == $layout ) {
                $selected = ' active';
            }
            echo '<li><span data-type="'. $layout .'" class="switch-'. $layout . $selected . '"></span></li>';
        }

        echo '</ul>' .
        '</div>' .
        '<div class="clearfix"></div>';

        ?>

        <script type="text/javascript">
            jQuery(document).ready(function() {
                jQuery('.kleo-view-switch span').click(function () {
                    kleoSetCookie('kleo-blog-layout<?php echo $identifier;?>', jQuery(this).data('type'), '/', 30);
                    location.reload();
                });
            });
        </script>

<?php
    }
}

/**
 * Return the blog layout from visitor Cookie
 * @param string $layout
 * @param string $identifier
 * @return string
 */
function kleo_post_grid_layout( $layout = '', $identifier = '' ) {
    $cookie_name = 'kleo-blog-layout'. $identifier;
    if ( isset($_COOKIE[$cookie_name]) && $_COOKIE[$cookie_name] != '' ) {
        $layout = $_COOKIE[$cookie_name];
    }

	if( function_exists('get_term_meta') ) {
		if ( is_category() ) {

			global $kleo_config;
			$layouts = $kleo_config['blog_layouts'];
			$category = get_category( get_query_var('cat') );
			$category_meta = get_term_meta( $category->term_id, 'kleo_category_display_type' );

			if (isset($category_meta[0]) && isset($layouts[$category_meta[0]])) {
				$layout = $category_meta[0];
			}

		}
	}

    return $layout;
}
add_filter( 'kleo_blog_type', 'kleo_post_grid_layout', 10, 2 );



/***************************************************
:: Let it Snow
 ***************************************************/

function kleo_site_snow()
{
    echo do_shortcode('[kleo_snow scope="window"]');
}
if ( sq_option( 'let_it_snow', 0 ) == 1 ) {
    add_action('kleo_after_page', 'kleo_site_snow');
}



/**
 * Get current post format for posts
 * or custom media settings as post format for custom post type
 * @return mixed|string
 */
function kleo_get_post_format() {
    if ( get_post_type() == 'portfolio' ) {
        if (get_cfield('media_type') && get_cfield('media_type') != '') {
            $media_type = get_cfield('media_type');
            switch ($media_type) {
                case 'slider':
                    $kleo_post_format = 'gallery';
                    break;

                case 'video':
                case 'hosted_video':
                    $kleo_post_format = 'video';
                    break;
            }
        }
        return $kleo_post_format;
    } else {
        return get_post_format();
    }
}



/**
 * Return the URL as requested on the current page load by the user agent.
 *
 * @since KLEO (2.4)
 *
 * @return string Requested URL string.
 */
function kleo_get_requested_url() {
    $url  = is_ssl() ? 'https://' : 'http://';
    $url .= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    return apply_filters( 'kleo_get_requested_url', esc_url($url) );
}



/***************************************************
:: Profile placeholder in menu for bbPress or Buddypress
 ***************************************************/

add_filter('walker_nav_menu_start_el', 'kleo_bp_replace_placeholders');

function kleo_bp_replace_placeholders( $output ) {

    $initial_output = $output;

    if ( strpos( $output, '##profile_link##' ) !== false ) {

        if ( ! is_user_logged_in() ) {
            return '';
        }

        if ( function_exists( 'bp_is_active' ) ) {
            $logged_in_link = bp_loggedin_user_domain( '/' );
            $output = str_replace('##profile_link##', $logged_in_link, $output);
        }
        elseif ( class_exists( 'bbPress' ) ) {
            //$logged_in_link = bb_get_profile_link();
            $logged_in_link = bbp_get_user_profile_url( bbp_get_current_user_id() );
            $output = str_replace('##profile_link##', $logged_in_link, $output);
        }
    }

    if ( strpos( $output, '##member_name##' ) !== false ) {

        if ( ! is_user_logged_in()) {
            return '';
        }
        if ( function_exists( 'bp_is_active' ) ) {
            $logged_in_username = bp_get_loggedin_user_fullname();
            $output = str_replace('##member_name##', $logged_in_username, $output);
        }
        elseif ( class_exists( 'bbPress' ) ) {
            $logged_in_username = bbp_get_user_nicename( bbp_get_current_user_id() );
            $output = str_replace('##member_name##', $logged_in_username, $output);
        }
    }
    $output = apply_filters( 'kleo_bp_replace_placeholders', $output, $initial_output );

    return $output;
}



/***************************************************
:: Custom redirect from Theme options - Miscellaneous
 ***************************************************/

if ( sq_option('login_redirect', 'default') == 'custom' && sq_option( 'login_redirect_custom', '' ) != '' ) {
    add_filter( 'login_redirect', 'kleo_custom_redirect', 12 );
}

function kleo_custom_redirect() {

    $redirect_to = sq_option( 'login_redirect_custom', '' );

    return $redirect_to;
}

if ( ! function_exists('kleo_get_post_media')) {
    /**
     * Return post media by format
     *
     * @param $post_format
     * @param $options
     * @return string
     *
     * @since 3.0
     */
    function kleo_get_post_media($post_format = 'standard', $options = array())
    {

        global $kleo_config;

        if (isset($options['icons']) && $options['icons']) {
            $icons = true;
        } else {
            $icons = false;
        }

        if (isset($options['media_width']) && isset($options['media_height'])) {
            $media_width = $options['media_width'];
            $media_height = $options['media_height'];
        } else {
            $media_width = $kleo_config['post_gallery_img_width'];
            $media_height = $kleo_config['post_gallery_img_height'];
        }

        $output = '';

        switch ($post_format) {

            case 'video':

                //oEmbed video
                $video = get_cfield('embed');
                // video bg self hosted
                $bg_video_args = array();
                $k_video = '';

                if (get_cfield('video_mp4')) {
                    $bg_video_args['mp4'] = get_cfield('video_mp4');
                }
                if (get_cfield('video_ogv')) {
                    $bg_video_args['ogv'] = get_cfield('video_ogv');
                }
                if (get_cfield('video_webm')) {
                    $bg_video_args['webm'] = get_cfield('video_webm');
                }

                if (!empty($bg_video_args)) {
                    $attr_strings = array(
                        'preload="none"'
                    );

                    if (get_cfield('video_poster')) {
                        $attr_strings[] = 'poster="' . get_cfield('video_poster') . '"';
                    }

                    $k_video .= '<div class="kleo-video-wrap"><video ' . join(' ', $attr_strings) . ' controls="controls" class="kleo-video" style="width: 100%; height: 100%;">';

                    $source = '<source type="%s" src="%s" />';
                    foreach ($bg_video_args as $video_type => $video_src) {
                        $video_type = wp_check_filetype($video_src, wp_get_mime_types());
                        $k_video .= sprintf($source, $video_type['type'], esc_url($video_src));
                    }

                    $k_video .= '</video></div>';

                    $output .= $k_video;
                } // oEmbed
                elseif (!empty($video)) {
                    global $wp_embed;
                    $output .= apply_filters('kleo_oembed_video', $video);
                }

                break;

            case 'audio':

                $audio = get_cfield('audio');

                if (!empty($audio)) {
                    $output .=
                        '<div class="post-audio">' .
                        '<audio preload="none" class="kleo-audio" id="audio_' . get_the_ID() . '" style="width:100%;" src="' . $audio . '"></audio>' .
                        '</div>';
                }
                break;

            case 'gallery':

                $slides = get_cfield('slider');

                $output .= '<div class="kleo-banner-slider">'
                    . '<div class="kleo-banner-items" >';

                if ( $slides ) {
                    foreach ($slides as $slide) {
                        if ($slide) {
                            $image = aq_resize($slide, $media_width, $media_height, true, true, true);
                            //small hack for non-hosted images
                            if (!$image) {
                                $image = $slide;
                            }
                            $output .= '<article>
								<a href="' . $slide . '" data-rel="modalPhoto[inner-gallery]">
									<img src="' . $image . '" alt="' . get_the_title() . '">'
                                . kleo_get_img_overlay()
                                . '</a>
							</article>';
                        }
                    }
                }

                $output .= '</div>'
                    . '<a href="#" class="kleo-banner-prev"><i class="icon-angle-left"></i></a>'
                    . '<a href="#" class="kleo-banner-next"><i class="icon-angle-right"></i></a>'
                    . '<div class="kleo-banner-features-pager carousel-pager"></div>'
                    . '</div>';

                break;


            case 'aside':
                if ($icons) {
                    $output .= '<div class="post-format-icon"><i class="icon icon-doc"></i></div>';
                }
                break;

            case 'link':
                if ($icons) {
                    $output .= '<div class="post-format-icon"><i class="icon icon-link"></i></div>';
                }
                break;

            case 'quote':
                if ($icons) {
                    $output .= '<div class="post-format-icon"><i class="icon icon-quote-right"></i></div>';
                }
                break;

            case 'image':
            default:
                if (kleo_get_post_thumbnail_url() != '') {
                    $output .= '<div class="post-image">';

                    $img_url = kleo_get_post_thumbnail_url();
                    $image = aq_resize($img_url, $media_width, $media_height, true, true, true);
                    if (!$image) {
                        $image = $img_url;
                    }
                    $output .= '<a href="' . get_permalink() . '" class="element-wrap">'
                        . '<img src="' . $image . '" alt="' . get_the_title() . '">'
                        . kleo_get_img_overlay()
                        . '</a>';

                    $output .= '</div><!--end post-image-->';
                } elseif ($icons) {
                    $post_icon = $post_format == 'image' ? 'picture' : 'doc';
                    $output .= '<div class="post-format-icon"><i class="icon icon-' . $post_icon . '"></i></div>';
                }

                break;
        }

        return $output;
    }
}


/***************************************************
:: Custom taxonomy category template
 ***************************************************/

if( function_exists('get_term_meta') ) {

	function kleo_category_display_type_form( $category = false ) {

		global $kleo_config;
		$layouts = array_merge( $kleo_config['blog_layouts'], array( 'kb' => 'Knowledge Base' ) );
		$category_layout = '';

		if( $category && is_object( $category ) ) {
			$category_id = $category->term_id;
			$category_meta = get_term_meta($category_id, 'kleo_category_display_type');
			if ( isset( $category_meta[0] ) && isset( $layouts[$category_meta[0]] ) ) {
				$category_layout = $category_meta[0];
			}
		}

		?>
		<tr class="form-field">
			<th scope="row" valign="top"><label for="kleo_category_display_type"><?php _e( 'Display type', 'kleo_framework' ); ?></label></th>
			<td>
				<div class="form-field term-meta-wrap">
					<select id="kleo_category_display_type" name="kleo_category_display_type">
						<option value=""><?php _e( 'Use default display type', 'kleo_framework' ); ?></option>
						<?php foreach( $layouts as $layout => $layout_name ) { ?>
							<option value="<?php echo esc_attr( $layout ); ?>" <?php echo ( $layout == $category_layout ? 'selected="selected"' : '' ); ?>><?php echo esc_html( $layout_name ); ?></option>
						<?php } ?>
					</select>
					<p class="description"><?php _e( 'The "Display type" will override the default display layout for each category in part.','kleo_framework' ); ?></p>
				</div>
			</td>
		</tr>
		<?php

	}
	add_action( 'category_add_form_fields', 'kleo_category_display_type_form' );
	add_action( 'category_edit_form_fields', 'kleo_category_display_type_form' );

	function kleo_category_display_type_save( $category_id ) {

		if ( isset( $_POST['kleo_category_display_type'] ) ) {

			global $kleo_config;
			$layouts = array_merge( $kleo_config['blog_layouts'], array( 'kb' => 'Knowledge Base' ) );
			$category_layout = esc_attr( $_POST['kleo_category_display_type'] );

			if( isset( $layouts[$category_layout] ) ) {
				update_term_meta( $category_id, 'kleo_category_display_type', $category_layout );
			}else{
				delete_term_meta( $category_id, 'kleo_category_display_type' );
			}

		}

	}
	add_action( 'created_category', 'kleo_category_display_type_save' );
	add_action( 'edited_category', 'kleo_category_display_type_save' );

	function kleo_category_display_type_template( $template ) {
		if ( is_category() ) {

			$category = get_category( get_query_var('cat') );
			$category_meta = get_term_meta( $category->term_id, 'kleo_category_display_type' );

			if ( isset( $category_meta[0] ) && $category_meta[0] == 'kb' && locate_template( 'page-parts/posts-layout-kb.php' ) ) {
				return locate_template( 'page-parts/posts-layout-kb.php' );
			}

		}
		return $template;
	}
	add_filter( 'template_include', 'kleo_category_display_type_template' );

}


/***************************************************
:: Allow site layout overriding at page/post level
 ***************************************************/

function kleo_custom_site_style( $style ){
	if( is_singular() ){
		$page_style = get_cfield( 'site_style' );
		if( $page_style ) {
			$style = $page_style == 'boxed' ? ' page-boxed' : '';
		}
	}
	if( $style == ' page-boxed' ){
		add_filter('body_class', 'kleo_boxed_bg_body_class');
	}
	return $style;
}
add_filter( 'kleo_site_style', 'kleo_custom_site_style' );

function kleo_boxed_bg_body_class($classes){
	$classes[] = 'page-boxed-bg';
	return $classes;
}


/***************************************************
:: Allow site layout overriding at page/post level
 ***************************************************/

function kleo_show_post_tags( $content ) {
	if ( is_single() ) {
		$tag_list = get_the_tag_list( '', __(', ', 'kleo_framework'));
		if ( isset( $tag_list ) && $tag_list ) {
			$tags_array = explode( ',', $tag_list );

			$tag_html = '';
			foreach ($tags_array as $tag ) {
				$tag_html .= '<span class="label label-default">' . $tag . '</span> ' ;
			}
			$content .= esc_html__( 'Tags: ', 'kleo_framework' ) . $tag_html;
		}
	}
	return $content;
}
if ( sq_option( 'blog_tags_footer', 0 ) ) {
	add_action('the_content', 'kleo_show_post_tags', 20);
}



/*
 * Force URLs in srcset attributes into HTTPS scheme.
 * This is particularly useful when you're running a Flexible SSL frontend like Cloudflare
 */
function ssl_srcset( $sources ) {
	if (is_ssl()) {
		foreach ( $sources as &$source ) {
			$source['url'] = set_url_scheme( $source['url'], 'https' );
		}
	}

	return $sources;
}
add_filter( 'wp_calculate_image_srcset', 'ssl_srcset' );


/***************************************************
:: Manage custom page redirects
 ***************************************************/

function kleo_template_redirect(){
	if( is_user_logged_in() ){
		$homepage_redirect = sq_option( 'homepage_redirect', 'disabled' );
		if( is_front_page() && ( $homepage_redirect == 'profile' || $homepage_redirect == 'custom' ) ){
			if ( function_exists( 'bp_is_active' ) ) {
				$logged_in_link = bp_loggedin_user_domain( '/' );
			}
			elseif ( class_exists( 'bbPress' ) ) {
				$logged_in_link = bbp_get_user_profile_url( bbp_get_current_user_id() );
			}else{
				$logged_in_link = home_url('author');
			}

			if($homepage_redirect == 'profile'){
				wp_redirect($logged_in_link);
			}
			if($homepage_redirect == 'custom'){
				$homepage_redirect_custom = sq_option( 'homepage_redirect_custom', $logged_in_link );
				if ( strpos( $homepage_redirect_custom, '##profile_link##' ) !== false ) {
					$homepage_redirect_custom = str_replace('##profile_link##', $logged_in_link, $homepage_redirect_custom);
				}
				wp_redirect($homepage_redirect_custom);
			}
			exit;
		}
	}
}
add_action( 'template_redirect', 'kleo_template_redirect' );



/**
 * Remove hentry class from pages to stop google structured data errors
 *
 * @param array $classes
 *
 * @return array
 */
function kleo_remove_hentry_on_pages( $classes ) {
	if ( is_page() && !( function_exists('bp_is_group_forum_topic') && bp_is_group_forum_topic() ) ) {
		$classes = array_diff( $classes, array( 'hentry' ) );
	}
	return $classes;
}
add_filter( 'post_class','kleo_remove_hentry_on_pages' );



/* Re-enable theme auto-update for Go Pricing Tables */
add_action( 'admin_init', 'kleo_go_pricing_enable_updates', 11 );

function kleo_go_pricing_enable_updates() {
	if (class_exists('GW_GoPricing_Update')) {
		remove_filter( 'pre_set_site_transient_update_plugins', array(
			GW_GoPricing_Update::instance(),
			'check_update'
		) );
	}
}


if ( sq_option( 'mobile_app_capable', 1 ) ) {
	add_action('wp_head', 'kleo_add_mobile_app_capable_tag');
}
function kleo_add_mobile_app_capable_tag() {
	?>
	<meta name="mobile-web-app-capable" content="yes">
	<?php
}

if ( sq_option( 'apple_mobile_app_capable', 1 ) ) {
	add_action('wp_head', 'kleo_add_apple_mobile_app_capable_tag');
}
function kleo_add_apple_mobile_app_capable_tag() {
	?>
	<meta name="apple-mobile-web-app-capable" content="yes">
	<?php
}


if ( sq_option( 'meta_theme_color', '' ) != '' && sq_option( 'meta_theme_color', '' ) != 'transparent' ) {
	add_action('wp_head', 'kleo_add_meta_color');
}
function kleo_add_meta_color() {
	?>
	<!-- Chrome, Firefox OS and Opera -->
	<meta name="theme-color" content="<?php echo sq_option( 'meta_theme_color', '' ); ?>">
	<!-- Windows Phone -->
	<meta name="msapplication-navbutton-color" content="<?php echo sq_option( 'meta_theme_color', '' ); ?>">
	<!-- Safari -->
	<meta name="apple-mobile-web-app-status-bar-style" content="<?php echo sq_option( 'meta_theme_color', '' ); ?>">
	<?php
}
