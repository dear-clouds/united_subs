<?php

class Kleo {

    /*
     * Initialization args
     */
    public $args;

    private $custom_css;

    private $tgm_plugins;

	static $modules = array();
    
	/**
	 * Constructor method for the Kleo class. It controls the load order of the required files for running 
	 * the framework.
	 *
	 * @since 1.0.0
	 */
	function __construct( $args ) {

		$this->args = $args;
        
		/* Define framework, parent theme, and child theme constants. */
		$this->constants();

		/* Load core functions */
		$this->core();

		/* Initialize the framework's default actions and filters. */
		add_action( 'after_setup_theme', array( &$this, 'default_filters' ), 3 );

		/* Load the framework functions. */
		add_action( 'after_setup_theme', array( &$this, 'functions' ), 12 );

	}

	/**
	 * Defines the constant paths for use within the core framework, parent theme, and child theme.  
	 *
	 * @since 1.0.0
	 */
	function constants() {

		/* Sets the framework version number. */
		define( 'KLEO_VERSION', '2.3' );
        
		/* Sets the framework domain */
		define( 'KLEO_DOMAIN', str_replace(" ","_",strtolower(wp_get_theme())) );

		/* Sets the path to the parent theme directory. */
		define( 'THEME_DIR', get_template_directory() );

		/* Sets the path to the parent theme directory URI. */
		define( 'THEME_URI', get_template_directory_uri() );

		/* Sets the path to the child theme directory. */
		define( 'CHILD_THEME_DIR', get_stylesheet_directory() );

		/* Sets the path to the child theme directory URI. */
		define( 'CHILD_THEME_URI', get_stylesheet_directory_uri() );

		/* Sets the path to the core framework directory. */
		define( 'KLEO_DIR', trailingslashit( THEME_DIR ) . basename( dirname( __FILE__ ) ) );

		/* Sets the path to the core framework directory URI. */
		define( 'KLEO_URI', trailingslashit( THEME_URI ) . basename( dirname( __FILE__ ) ) );

		/* Sets the path to the theme library folder. */
		define( 'KLEO_LIB_DIR', trailingslashit( THEME_DIR ) . 'lib' );
		
		/* Sets the url to the theme library folder. */
		define( 'KLEO_LIB_URI', trailingslashit( THEME_URI ) . 'lib' );

        /* Sets the path to the theme framework folder. */
        define( 'KLEO_FW_DIR', trailingslashit( THEME_DIR ) . 'kleo-framework' );

        /* Sets the url to the theme framework folder. */
        define( 'KLEO_FW_URI', trailingslashit( THEME_URI ) . 'kleo-framework' );
		

		/* If is a AJAX request */
		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

	}

	/**
	 * Set a module init
	 * @param $name
	 * @param $value
	 */
	static function set_module( $name, $value ) {
		self::$modules[$name] = $value;
	}

	/**
	 * Get a module initialization
	 * @param $name
	 *
	 * @return bool|mixed
	 */
	static function get_module( $name ) {
		if ( isset( self::$modules[ $name ] ) ) {
			return self::$modules[ $name ];
		}

		return false;
	}

	/**
	 * Get all initialized modules
	 * @return array
	 */
	static function get_modules() {
		return self::$modules;
	}

	/**
	 * Loads the core framework functions.  These files are needed before loading anything else in the 
	 * framework because they have required functions for use.
	 *
	 * @since 1.0.0
	 */
	function core() {

		/* Load the core framework functions. */
		require_once( trailingslashit( KLEO_DIR ) . 'lib/function-core.php' );

        /* load required plugins if the theme needs to */
        if (!empty($this->args['required_plugins'])) {
            $this->tgm_plugins = $this->args['required_plugins'];
            require_once KLEO_DIR. '/lib/class-tgm-plugin-activation.php';
            add_action( 'tgmpa_register', array( $this, 'required_plugins' ) );
        }

	}

	/**
	 * Loads the framework functions.
	 *
	 * @since 1.0.0
	 */
	function functions() {

		/* Load multiple sidebars plugin */
		if(!class_exists('sidebar_generator')) {
			 require_if_theme_supports ('kleo-sidebar-generator', KLEO_DIR. '/lib/class-multiple-sidebars.php');
		}

		/* Load facebook login if it is enabled in theme options */
		if (sq_option('facebook_login', 1) == 1 && sq_option('fb_app_id', '') !== '') {
				require_if_theme_supports('kleo-facebook-login', KLEO_DIR. '/lib/function-facebook-login.php');
		}

		// Include breadcrumb
		if (!is_admin()) {
				require_once(KLEO_DIR.'/lib/function-breadcrumb.php');
		}

		//envato theme update
		add_filter("pre_set_site_transient_update_themes", array(&$this,"themeforest_themes_update"));

	}

	
	/**
	 * Adds the default framework actions and filters.
	 *
	 * @since 1.0.0
	 */
	function default_filters() 
	{

		/* Remove bbPress theme compatibility if current theme supports bbPress. */
		if ( current_theme_supports( 'bbpress' ) ) {
			remove_action( 'bbp_init', 'bbp_setup_theme_compat', 8 );
		}
		
		/* Make text widgets and term descriptions shortcode aware. */
		add_filter( 'widget_text', 'do_shortcode' );
		add_filter( 'term_description', 'do_shortcode' );
		
	}


	public function required_plugins() {
		// Change this to your theme text domain, used for internationalising strings
		$theme_text_domain = 'kleo_framework';

		/**
		 * Array of configuration settings. Amend each line as needed.
		 * If you want the default strings to be available under your own theme domain,
		 * leave the strings uncommented.
		 * Some of the strings are added into a sprintf, so see the comments at the
		 * end of each line for what each argument will be.
		 */
		$config = array(
            'id'                => 'tgmpa-kleo-' . KLEO_THEME_VERSION,
            //'domain'            => $theme_text_domain,           // Text domain - likely want to be the same as your theme.
			'default_path'      => '',                           // Default absolute path to pre-packaged plugins
			//'parent_menu_slug'  => 'themes.php',         // Default parent menu slug
			//'parent_url_slug'   => 'themes.php',         // Default parent URL slug
			'menu'              => 'install-required-plugins',   // Menu slug
			'has_notices'       => true,                         // Show admin notices or not
			'is_automatic'      => true,            // Automatically activate plugins after installation or not
			'message'           => '',               // Message to output right before the plugins table
			'strings'           => array(
				'page_title'                                => __( 'Install Required Plugins', 'kleo_framework' ),
				'menu_title'                                => __( 'Install Plugins', 'kleo_framework' ),
				'installing'                                => __( 'Installing Plugin: %s', 'kleo_framework' ), // %1$s = plugin name
				'oops'                                      => __( 'Something went wrong with the plugin API.', 'kleo_framework' ),
				'notice_can_install_required'               => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.','kleo_framework' ), // %1$s = plugin name(s)
				'notice_can_install_recommended'            => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.','kleo_framework' ), // %1$s = plugin name(s)
				'notice_cannot_install'                     => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.','kleo_framework' ), // %1$s = plugin name(s)
				'notice_can_activate_required'              => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.','kleo_framework' ), // %1$s = plugin name(s)
				'notice_can_activate_recommended'           => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.','kleo_framework' ), // %1$s = plugin name(s)
				'notice_cannot_activate'                    => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.','kleo_framework' ), // %1$s = plugin name(s)
				'notice_ask_to_update'                      => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.','kleo_framework' ), // %1$s = plugin name(s)
				'notice_cannot_update'                      => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.','kleo_framework' ), // %1$s = plugin name(s)
				'install_link'                              => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'kleo_framework' ),
				'activate_link'                             => _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'kleo_framework' ),
				'return'                                    => __( 'Return to Required Plugins Installer', 'kleo_framework', 'kleo_framework' ),
				'plugin_activated'                          => __( 'Plugin activated successfully.', 'kleo_framework' ),
				'complete'                                  => __( 'All plugins installed and activated successfully. %s', 'kleo_framework' ) // %1$s = dashboard link
			)
		);

		tgmpa( $this->tgm_plugins, $config );

	}

    
    public function add_css($data)
    {
        $this->custom_css .= $data;
    }
    
    public function render_css() {

        echo "\n<style>\n";
        echo $this->custom_css;

        if(sq_option('quick_css'))
        {
            echo sq_option('quick_css')."\n";
        }
        echo "\n</style>\n";
    }
    
     
    /**
     * Get css for background option
     *
     * @param string $option Theme option to get
     * @param string $css_elements Css elements to apply style
     * @return string
     */
    public function get_bg_css($option = false, $css_elements = false)
    {
        if (!$option || !$css_elements) {
            return '';
        }

        $output = '';
        $has_data = false;
        $db_option = sq_option($option);

        if (isset($db_option['background-image']) && $db_option['background-image'] != '') {
            $has_data = true;
            $output .= 'background-image: url("'.$db_option['background-image'].'");';

            if (isset($db_option['background-repeat']) && $db_option['background-repeat'] != '') {
                $output .= 'background-repeat: '.$db_option['background-repeat'].';';
            }
            if (isset($db_option['background-size']) && $db_option['background-size'] != '') {
                $output .= 'background-size: '.$db_option['background-size'].';';
            }
            if (isset($db_option['background-attachment']) && $db_option['background-attachment'] != '') {
                $output .= 'background-attachment: '.$db_option['background-attachment'].';';
            }
            if (isset($db_option['background-position']) && $db_option['background-position'] != '') {
                $output .= 'background-position: '.$db_option['background-position'].';';
            }
            if (isset($db_option['background-color']) && $db_option['background-color'] != '') {
                $output .= 'background-color: '.$db_option['background-color'].';';
            }
        }
        elseif (isset($db_option['background-color']) && $db_option['background-color'] != '') {
            $has_data = true;
            $output .= 'background-color: '.$db_option['background-color'].';background-image: none;';
        }
        if ($has_data) {
            $output = $css_elements.' {'. $output . '}';
        }
			
        return $output;
    }


	public function get_std_fonts() {
		return array(
			"Arial, Helvetica, sans-serif",
			"'Arial Black', Gadget, sans-serif",
			"'Bookman Old Style', serif",
			"'Comic Sans MS', cursive",
			"Courier, monospace",
			"Garamond, serif",
			"Georgia, serif",
			"Impact, Charcoal, sans-serif",
			"'Lucida Console', Monaco, monospace",
			"'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
			"'MS Sans Serif', Geneva, sans-serif",
			"'MS Serif', 'New York', sans-serif",
			"'Palatino Linotype', 'Book Antiqua', Palatino, serif",
			"Tahoma, Geneva, sans-serif",
			"'Times New Roman', Times, serif",
			"'Trebuchet MS', Helvetica, sans-serif",
			"Verdana, Geneva, sans-serif"
		);
	}
    
    /**
     * Add css for typography option
     * @param string $option Theme option to get
     * @param string $css_elements Css elements to apply style
     */
    public function add_google_fonts_link()
    {
			/*
			 * [font-family] => Roboto Condensed  
			 * [google] => true [font-weight] => 400 
			 * [font-style] => 
			 * [subsets] => latin-ext 
			 * [font-size] => 36px 
			 * [line-height] => 48px 
			 * [font-backup] => 'Arial Black', Gadget, sans-serif ) 
			*/

			global $kleo_config;

            $std_fonts = $this->get_std_fonts();
			
			$fonts = array();
			$sections = $kleo_config['font_sections'];

			if (get_transient(KLEO_DOMAIN.'_google_link') === FALSE)
			{

				foreach ($sections as $section) 
				{
					$font = sq_option( 'font_' . $section );
					
					if($font['google'] == 'false') {
						continue;
					}

                    $font['font-family'] = str_replace($std_fonts, '', $font['font-family']);

					if(empty($font['font-family']) || $font['font-family'] == '' ) {
						continue;
					}

					if (!empty($font['font-family']) && !empty($font['font-backup'])) {
						$font['font-family'] = str_replace(', ' . $font['font-backup'], '', $font['font-family']);
					}
					
					$font['font-family'] = str_replace( ' ', '+', $font['font-family'] );
					if ( ! isset( $fonts[$font['font-family']] ) ) {
						$fonts[$font['font-family']] = array();
					}
					
					
					if (isset($font['font-weight']) && !empty($font['font-weight'])) {
						$style = isset($font['font-style']) ? $font['font-style'] : "";
						$fonts[$font['font-family']]['font-style'][$font['font-weight'].$style] = $font['font-weight'].$style;
					}
					
					/*
					if ( !isset( $fonts[$font['font-family']]['all-styles'] ) || empty( $fonts[$font['font-family']]['all-styles'] ) ) {
						$fonts[$font['font-family']]['all-styles'] = array();
						if (isset($font['font-options'])) {
							$font['font-options'] = json_decode($font['font-options'], true);
						}
						if (isset($font['font-options']['variants']) && is_array($font['font-options']['variants'])) {
							foreach($font['font-options']['variants'] as $variant) {
								$fonts[$font['font-family']]['all-styles'][] = $variant['id'];
							}
						}
					}*/


					if ( isset( $font['subsets'] ) && $font['subsets'] != '' ) {
						$fonts[$font['font-family']]['subset'][] = $font['subsets'];
					}

				}
				
				if ( !empty( $fonts ) ) {
					$google_link = $this->makeGoogleWebfontLink( $fonts );
					set_transient(KLEO_DOMAIN.'_google_link', $google_link, 12 * 60 * 60);
				}
			}
			else {
				$google_link = get_transient( KLEO_DOMAIN . '_google_link' );
			}

			//Load Google Font
			if (isset( $google_link ) && $google_link != '') {
				add_action( 'wp_enqueue_scripts', create_function( '', "wp_register_style('kleo-google-fonts', \"$google_link\", array(), '', 'all' ); wp_enqueue_style('kleo-google-fonts');" ) );   
			} else {
				//add_action( 'wp_enqueue_scripts', create_function( '', "wp_register_style('kleo-google-fonts', '//fonts.googleapis.com/css?family=Roboto Condensed:300,400,700|Open Sans:400' , array(), '', 'all' ); wp_enqueue_style('kleo-google-fonts');" ) ); 
			}

    }

		public function add_font_css() {

			global $kleo_config;
			$std_fonts  = $this->get_std_fonts();
			$sections   = $kleo_config['font_sections'];
			$output     = '';


			foreach($sections as $section) {
				$font = sq_option('font_'.$section);

				if ( in_array($font['font-family'], $std_fonts )) {
					$is_google = false;
				} else {
					$is_google = true;
				}

				//family
				if ( $is_google === true ) {
					$font_backup = '';
					if ( isset($font['font-backup']) && ! empty($font['font-backup']) ) {
						$font_backup = ', ' . $font['font-backup'];
					}
					$output .= $section . ' {font-family:"' . $font['font-family'] . '"' . $font_backup . ';}';
				} else {
					$output .= $section . ' {font-family:' . $font['font-family'] . ';}';
				}

				if ( $section == 'h1' ) {
                    $output .= '.lead p, p.lead, article .article-meta .entry-date, .single-attachment .post-time, #buddypress #groups-list .item-title, .popover-title, .nav-tabs > li > a, .nav-pills > li > a, .panel-kleo .panel-title {font-family:'.$font['font-family'].';}';
                    $output .= '#rtm-gallery-title-container .rtm-gallery-title, #item-body .rtmedia-container h2 {font-family:' . $font['font-family'] . ' !important;}';
                } elseif( $section == 'body' ) {
                    $output .= 'li.bbp-forum-info .bbp-forum-title, .woocommerce #accordion-woo .panel-title, .woocommerce ul.products li.product h3, .woocommerce-page ul.products li.product h3, .woocommerce .kleo-cart-totals .shipping-calculator-button {font-family:'.$font['font-family'].';}';
                }
				//size
				if (isset($font['font-size']) && !empty($font['font-size'])) {
					$output .= $section.' {font-size:'.$font['font-size'].';}';
				}
				//line-height
				if (isset($font['line-height']) && !empty($font['line-height'])) {
					$output .= $section.' {line-height:'.$font['line-height'].';}';
				}	
				//weight
				if (isset($font['font-weight']) && !empty($font['font-weight'])) {
					$output .= $section.' {font-weight:'.$font['font-weight'].';}';
				}
			}
			echo $output;
		}
		
    public function makeGoogleWebfontLink( $fonts ) {
      $link = "";
      $subsets = array();
			
      foreach( $fonts as $family => $font ) {
        if (!empty($link)) {
          $link .= "|"; // Append a new font to the string
        }
        $link .= $family;

        if ( isset( $font['font-style'] ) && ! empty( $font['font-style'] ) || ( isset($font['all-styles']) && ! is_array( $font['all-styles'] ) ) ) {
            $link .= ':';
            if ( isset( $font['all-styles'] ) && !is_array($font['all-styles']) ) {
                $link .= implode( ',', $font['all-styles'] );
            } else if ( !empty($font['font-style'] ) ) {
                $link .= implode(',', $font['font-style']);
            }
        }
				
        if ( !empty( $font['subset'] ) ) {
          foreach( $font['subset'] as $subset ) {
            if ( !in_array( $subset, $subsets ) ) {
              array_push( $subsets, $subset );
            }  
          }
          
        }
      }
      if ( ! empty( $subsets ) ) {
        $link .= "&amp;subset=".implode(',', $subsets);
      }

      return '//fonts.googleapis.com/css?family=' . $link;

    }
		
    
    /**
     * 
     * @param type $updates
     * @return type
     */
    public function themeforest_themes_update($updates) {
        if (isset($updates->checked)) {
            if ( ! class_exists( 'Pixelentity_Themes_Updater' ) ) {
                require_once(KLEO_DIR ."/inc/pixelentity-themes-updater/class-pixelentity-themes-updater.php");
            }
            $username = sq_option( 'tf_username', false ) ? trim(sq_option( 'tf_username' )) : null;
            $apikey = sq_option('tf_apikey', false) ? trim(sq_option('tf_apikey')) : null;

            $updater = new Pixelentity_Themes_Updater( $username,$apikey );
            $updates = $updater->check($updates);
        }
        return $updates;
    }
    
}