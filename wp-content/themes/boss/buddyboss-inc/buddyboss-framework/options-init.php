<?php

if ( !class_exists( 'boss_Redux_Framework_config' ) ) {

	class boss_Redux_Framework_config {

		public $args	 = array();
		public $sections = array();
		public $theme;
		public $ReduxFramework;

		public function __construct() {

			if ( !class_exists( 'ReduxFramework' ) ) {
				return;
			}

			// This is needed. Bah WordPress bugs.  ;)
			if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
				$this->initSettings();
			} else {
				add_action( 'plugins_loaded', array( $this, 'initSettings' ), 10 );
			}
		}

		public function initSettings() {

			// Just for demo purposes. Not needed per say.
			$this->theme = wp_get_theme();

			// Set the default arguments
			$this->setArguments();

			// Create the sections and fields
			$this->setSections();

			if ( !isset( $this->args[ 'opt_name' ] ) ) { // No errors please
				return;
			}

			// If Redux is running as a plugin, this will remove the demo notice and links
			add_action( 'redux/loaded', array( $this, 'remove_demo' ) );

			$this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
		}

		// Remove the demo link and the notice of integrated demo from the redux-framework plugin
		function remove_demo() {

			// Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
			if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
				remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::instance(), 'plugin_metalinks' ), null, 2 );

				// Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
				remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
			}
		}

		public function setSections() {

			$customize_url	 = add_query_arg( 'return', urlencode( wp_unslash( $_SERVER[ 'REQUEST_URI' ] ) ), 'customize.php' );
			$admin_url		 = admin_url( $customize_url );

			// Logo Settings
			$this->sections[] = array(
				'title'		 => __( 'Logo', 'boss' ),
				'icon'		 => 'el-icon-adjust',
				'priority'	 => 20,
				'fields'	 => array(
					array(
						'id'		 => 'logo_switch',
						'type'		 => 'switch',
						'title'		 => __( 'Primary Logo', 'boss' ),
						'subtitle'	 => __( 'Upload your custom site logo (280px by 80px).', 'boss' ),
						'default'	 => '0',
						'on'		 => __( 'On', 'boss' ),
						'off'		 => __( 'Off', 'boss' ),
					),
					array(
						'id'		 => 'boss_logo',
						'type'		 => 'media',
						'url'		 => false,
						'required'	 => array( 'logo_switch', 'equals', '1' ),
					),
					array(
						'id'		 => 'mini_logo_switch',
						'type'		 => 'switch',
						'title'		 => __( 'Mini Logo', 'boss' ),
						'subtitle'	 => __( 'Upload your mini logo, used in collapsed BuddyPanel (80px by 80px).', 'boss' ),
						'default'	 => '0',
						'on'		 => __( 'On', 'boss' ),
						'off'		 => __( 'Off', 'boss' ),
					),
					array(
						'id'		 => 'boss_small_logo',
						'type'		 => 'media',
						'url'		 => false,
						'required'	 => array( 'mini_logo_switch', 'equals', '1' ),
					),
					array(
						'id'		 => 'boss_favicon',
						'type'		 => 'none',
						'url'		 => false,
						'title'		 => __( 'Favicon', 'boss' ),
						'subtitle'	 => __( 'Upload your custom site favicon and Apple device icons at <a href="' . $admin_url . '">Appearance > Customize</a> in the Site Identity section.', 'boss' ),
					),
				)
			);

			// Header Settings
			$this->sections[] = array(
				'title'		 => __( 'Header', 'boss' ),
				'id'		 => 'device_layout',
				'customizer' => false,
				//'desc'		 => __( 'We use device detection to determine the correct layout, with media queries as a fallback.', 'boss' ),
				'icon'		 => 'el-icon-credit-card',
				'fields'	 => array(
                    array(
						'id'		 => 'boss_header',
						'type'		 => 'custom_image_select',
						'presets'	 => true,
						'customizer' => false,
						'default'	 => '1',
						'options'	 => array(
                                '1'      => array(
                                    'alt'   => 'Header style 1',
                                    'img'   => get_template_directory_uri() . '/buddyboss-inc/buddyboss-framework/assets/images/headers/style1.png'
                                ),
                                '2'      => array(
                                    'alt'   => 'Header style 2',
                                    'img'   => get_template_directory_uri() . '/buddyboss-inc/buddyboss-framework/assets/images/headers/style2.png'
                                ),
                        )
					)
                )
            );

			// Layout Settings
			$this->sections[] = array(
				'title'		 => __( 'Layout', 'boss' ),
				'id'		 => 'device_layout',
				'customizer' => false,
				//'desc'		 => __( 'We use device detection to determine the correct layout, with media queries as a fallback.', 'boss' ),
				'icon'		 => 'el-icon-website',
				'fields'	 => array(
					array(
						'id'		 => 'boss_layout_style',
						'type'		 => 'button_set',
						'title'		 => __( 'Fluid vs Boxed', 'boss' ),
						'subtitle'	 => __( 'Use full width "fluid" layout, or a fixed with "boxed" layout.', 'boss' ),
						'options'	 => array(
							'fluid'	 => 'Fluid',
							'boxed'	 => 'Boxed'
						),
						'default'	 => 'fluid'
					),
					array(
						'id'		 => 'boss_activity_infinite',
						'type'		 => 'switch',
						'title'		 => __( 'Activity Infinite Scrolling', 'boss' ),
						'subtitle'	 => __( 'Allow content in all Activity Streams to automatically load more as you scroll down the page.', 'boss' ),
						'default'	 => '1',
						'on'		 => __( 'On', 'boss' ),
						'off'		 => __( 'Off', 'boss' ),
					),
					array(
						'id'	 => 'responsive_layout_info',
						'type'	 => 'info',
						'desc'	 => __( 'Responsive: We use device detection to determine the correct layout, with media queries as a fallback.', 'boss' )
					),
					array(
						'id'		 => 'boss_layout_desktop',
						'type'		 => 'button_set',
						'title'		 => __( 'Desktop', 'boss' ),
						'subtitle'	 => __( 'Select the default desktop layout.', 'boss' ),
						'options'	 => array(
							'desktop'	 => 'Desktop',
							'mobile'	 => 'Mobile'
						),
						'default'	 => 'desktop'
					),
					array(
						'id'		 => 'boss_layout_tablet',
						'type'		 => 'button_set',
						'title'		 => __( 'Tablet', 'boss' ),
						'subtitle'	 => __( 'Select the default tablet layout.', 'boss' ),
						'options'	 => array(
							'desktop'	 => 'Desktop',
							'mobile'	 => 'Mobile'
						),
						'default'	 => 'mobile'
					),
					array(
						'id'		 => 'boss_layout_phone',
						'type'		 => 'button_set',
						'title'		 => __( 'Phone', 'boss' ),
						'subtitle'	 => __( 'Phones can only display mobile layout.', 'boss' ),
						'options'	 => array(
							'mobile' => 'Mobile'
						),
						'default'	 => 'mobile'
					),
					array(
						'id'		 => 'boss_layout_switcher',
						'type'		 => 'switch',
						'title'		 => __( 'View Desktop/Mobile button', 'boss' ),
						'subtitle'	 => __( 'Display or hide the layout switch button in your site footer.', 'boss' ),
						'on'		 => __( 'Display', 'boss' ),
						'off'		 => __( 'Hide', 'boss' ),
						'default'	 => '1',
					),
					array(
						'id'	 => 'mobile_layout_info',
						'type'	 => 'info',
						'desc'	 => __( 'Mobile options', 'boss' )
					),
					array(
						'id'		 => 'boss_search_instead',
						'type'		 => 'switch',
						'title'		 => __( 'Search Input', 'boss' ),
						'subtitle'	 => __( 'The mobile titlebar can optionally display a search input in place of your site logo/title.', 'boss' ),
						'on'		 => __( 'Display', 'boss' ),
						'off'		 => __( 'Hide', 'boss' ),
						'default'	 => '0',
					),
					array(
						'id'		 => 'boss_titlebar_position',
						'type'		 => 'select',
						'title'		 => __( 'Panel Links', 'boss' ),
						'subtitle'	 => __( 'The WordPress menu "Titlebar" can optionally be displayed in the left mobile panel.', 'boss' ),
						'options'	 => array(
							'top'	 => __( 'Display (above other links)', 'boss' ),
							'bottom' => __( 'Display (below other links)', 'boss' ),
							'none'	 => __( 'Hide', 'boss' ),
						),
						'default'	 => 'none',
					),
				)
			);

			// Mobile Options
			$this->sections[] = array(
				'title'		 => __( 'BuddyPanel', 'boss' ),
				'id'		 => 'boss_buddypanel',
				'customizer' => false,
				'icon'		 => 'el-icon-indent-left',
				'fields'	 => array(
					array(
						'id'	 => 'boddypanel_info',
						'type'	 => 'info',
						'desc'	 => __( 'The "BuddyPanel" is the left panel in the desktop view of the theme.', 'boss' )
					),
					array(
						'id'		 => 'boss_panel_hide',
						'type'		 => 'switch',
						'title'		 => __( 'Logged Out Users', 'boss' ),
						'subtitle'	 => __( 'Display or hide the BuddyPanel for logged out users.', 'boss' ),
						'on'		 => __( 'Display', 'boss' ),
						'off'		 => __( 'Hide', 'boss' ),
						'default'	 => '1',
					),
					array(
						'id'		 => 'boss_panel_state',
						'type'		 => 'switch',
						'title'		 => __( 'Default State', 'boss' ),
						'subtitle'	 => __( 'BuddyPanel can default to open or closed on first page load.', 'boss' ),
						'on'		 => __( 'Opened', 'boss' ),
						'off'		 => __( 'Closed', 'boss' ),
						'default'	 => '1',
					),
				)
			);

			$cover_sizes		 = apply_filters( 'boss_profile_cover_sizes', array( '322' => 'Big', '200' => 'Small' ) );
			$group_cover_sizes	 = apply_filters( 'boss_group_cover_sizes', array( '322' => 'Big', '200' => 'Small' ) );
			$blog_cover_sizes	 = apply_filters( 'boss_blog_cover_sizes', array( '350' => 'Big', '200' => 'Small' ) );

//                        BP has issues with bp_attachments_get_cover_image_dimensions function so commenting until it is fixed.
//                        if ( function_exists( 'bp_attachments_get_cover_image_dimensions' ) ) {
//                            $profile_cover_dimensions = bp_attachments_get_cover_image_dimensions('xprofile');
//                            $group_cover_dimensions = bp_attachments_get_cover_image_dimensions('groups');
//                        } else {
//                            $profile_cover_dimensions = '';
//                            $group_cover_dimensions = '';
//                        }
                        $profile_cover_dimensions = array();
                        $group_cover_dimensions = array();
                        
                        $profile_cover_dimensions['width'] = '625'; 
                        $profile_cover_dimensions['height'] = '225'; 
                        $group_cover_dimensions['width'] = '625'; 
                        $group_cover_dimensions['height'] = '225'; 

			// Cover Photos
			$this->sections[] = array(
				'title'		 => __( 'Cover Photos', 'boss' ),
				'id'		 => 'cover_photos',
				'customizer' => false,
				'icon'		 => 'el-icon-picture',
				'fields'	 => array(
					array(
						'id'	 => 'buddypress_profile_info',
						'type'	 => 'info',
						'desc'	 => __( 'BuddyPress Profiles', 'boss' )
					),
					array(
						'id'		 => 'boss_cover_profile',
						'type'		 => 'switch',
						'title'		 => __( 'Profile Cover Photo', 'boss' ),
						'default'	 => '1',
						'on'		 => __( 'On', 'boss' ),
						'off'		 => __( 'Off', 'boss' ),
					),
					array(
						'id'		 => 'boss_cover_profile_size',
						'type'		 => 'select',
						'title'		 => __( 'Cover Photo Size', 'boss' ),
						'required'	 => array( 'boss_cover_profile', 'equals', '1' ),
						'options'	 => $cover_sizes,
						'default'	 => '322',
					),
					array(
						'id'		 => 'boss_profile_cover_default',
						'type'		 => 'media',
						'title'		 => __( 'Default Photo', 'boss' ),
						'subtitle'	 => __( 'We display a photo at random from our included library. You can optionally upload your own image to always use as the default cover photo. Ideal size is '.$profile_cover_dimensions['width'].'px by '.$profile_cover_dimensions['height'].'px .', 'boss' ),
						'url'		 => false,
						'required'	 => array( 'boss_cover_profile', 'equals', '1' ),
					),
					array(
						'id'		 => 'boss_misc_profile_field_address',
						'type'		 => 'select',
						'url'		 => true,
						'title'		 => __( 'BuddyPress Field', 'boss' ),
						'subtitle'	 => __( 'Display an xProfile field in the cover photo.', 'boss' ),
						'required'	 => array( 'boss_cover_profile', 'equals', '1' ),
						'options'	 => $this->boss_customizer_xprofile_field_choices()
					),
					array(
						'id'	 => 'buddypress_group_info',
						'type'	 => 'info',
						'desc'	 => __( 'BuddyPress Groups', 'boss' )
					),
					array(
						'id'		 => 'boss_cover_group',
						'type'		 => 'switch',
						'title'		 => __( 'Group Cover Photo', 'boss' ),
						'default'	 => '1',
						'on'		 => __( 'On', 'boss' ),
						'off'		 => __( 'Off', 'boss' ),
					),
					array(
						'id'		 => 'boss_cover_group_size',
						'type'		 => 'select',
						'title'		 => __( 'Cover Photo Size', 'boss' ),
						'required'	 => array( 'boss_cover_group', 'equals', '1' ),
						'options'	 => $group_cover_sizes,
						'default'	 => '322',
					),
					array(
						'id'		 => 'boss_group_cover_default',
						'type'		 => 'media',
						'title'		 => __( 'Default Photo', 'boss' ),
						'subtitle'	 => __( 'We display a photo at random from our included library. You can optionally upload your own image to always use a default cover photo. Ideal size is '.$group_cover_dimensions['width'].'px by '.$group_cover_dimensions['height'].'px .', 'boss' ),
						'url'		 => false,
						'required'	 => array( 'boss_cover_group', 'equals', '1' ),
					),
					array(
						'id'	 => 'blog_info',
						'type'	 => 'info',
						'desc'	 => __( 'Blog Posts', 'boss' )
					),
					array(
						'id'		 => 'boss_cover_blog',
						'type'		 => 'switch',
						'title'		 => __( 'Blog Cover Photo', 'boss' ),
						'subtitle'	 => __( 'Display the blog post&apos;s featured image as a cover photo.', 'boss' ),
						'default'	 => '1',
						'on'		 => __( 'On', 'boss' ),
						'off'		 => __( 'Off', 'boss' ),
					),
					array(
						'id'		 => 'boss_cover_blog_size',
						'type'		 => 'select',
						'title'		 => __( 'Cover Photo Size', 'boss' ),
						'required'	 => array( 'boss_cover_blog', 'equals', '1' ),
						'options'	 => $blog_cover_sizes,
						'default'	 => '350',
					),
				)
			);

			$this->sections[] = array(
				'title'		 => __( 'Homepage Slides', 'boss' ),
				'icon'		 => 'el-icon-home',
				'customizer' => false,
				'fields'	 => array(
					array(
						'id'		 => 'boss_slider_switch',
						'type'		 => 'switch',
						'title'		 => __( 'Slider Options', 'boss' ),
						'subtitle'	 => __( 'Select if you want to use the Boss slider, or shortcodes from a 3rd party plugin.', 'boss' ),
						'default'	 => '1',
						'on'		 => __( 'Boss', 'boss' ),
						'off'		 => __( 'Shortcode', 'boss' ),
					),
					array(
						'id'			 => 'boss_slides',
						'type'			 => 'custom_slides',
						'title'		 => __( 'Boss Slider', 'boss' ),
						'subtitle'	 => __( 'Use our internal slider code. Drag and drop to re-order. Ideal image size is 1040px by 400px.', 'boss' ),
						'required'		 => array( 'boss_slider_switch', 'equals', '1' ),
						'placeholder'	 => array(
							'title'			 => __( 'Slide Title', 'boss' ),
							'description'	 => __( 'Slide Description', 'boss' ),
							//'button_text'	 => __( 'Read More', 'boss' ),
							'url'			 => __( 'Give us a link!', 'boss' ),
						)
					),
                    array(
						'id'		 => 'boss_plugins_slider',
						'type'		 => 'textarea',
						'required'		 => array( 'boss_slider_switch', 'equals', '0' ),
						'title'		 => __( 'Slider Shortcode', 'boss' ),
						'subtitle'	 => __( 'Add a different slider without editing code. Many of the popular slider plugins provide shortcodes to display their slides, which you can add here.', 'boss' ),
						'default'	 => ''
					),
				)
			);

			// Profile Settings
			$this->sections[] = array(
				'title'		 => __( 'Profiles', 'boss' ),
				'icon'		 => 'el-icon-torso',
				'customizer' => false,
				'fields'	 => array(
					array(
						'id'	 => 'menu_info',
						'type'	 => 'info',
						'desc'	 => __( 'Menu', 'boss' )
					),
					array(
						'id'		 => 'boss_adminbar',
						'type'		 => 'switch',
						'title'		 => __( 'Adminbar', 'boss' ),
						'subtitle'	 => __( 'Display the adminbar for logged in admin users.', 'boss' ),
						'on'		 => __( 'On', 'boss' ),
						'off'		 => __( 'Off', 'boss' ),
						'default'	 => '0',
					),
					array(
						'id'		 => 'boss_dashboard',
						'type'		 => 'switch',
						'title'		 => __( 'Dashboard Links', 'boss' ),
						'subtitle'	 => __( 'For admin users, display links to the WordPress dashboard in their profile dropdown menu.', 'boss' ),
						'on'		 => __( 'On', 'boss' ),
						'off'		 => __( 'Off', 'boss' ),
						'default'	 => '1',
					),
					array(
						'id'		 => 'boss_profile_adminbar',
						'type'		 => 'switch',
						'title'		 => __( '"My Profile" Menu', 'boss' ),
						'subtitle'	 => __( 'Display the WordPress menu titled "My Profile" in the user profile dropdown menu.', 'boss' ),
						'on'		 => __( 'On', 'boss' ),
						'off'		 => __( 'Off', 'boss' ),
						'default'	 => '1',
					),
					array(
						'id'	 => 'social_media_links_info',
						'type'	 => 'info',
						'desc'	 => __( 'Social Media Links', 'boss' )
					),
					array(
						'id'		 => 'profile_social_media_links_switch',
						'type'		 => 'switch',
						'title'		 => __( 'Social Media Links', 'boss' ),
						'subtitle'	 => __( 'Allow users to display their social media links in their profiles.', 'boss' ),
						'default'	 => '1',
						'on'		 => __( 'On', 'boss' ),
						'off'		 => __( 'Off', 'boss' ),
					),
					array(
						'id'            => 'profile_social_media_links',
						'type'          => 'custom_sites',
						'title'		    => __( 'Sites to Allow', 'boss' ),
						'required'	    => array( 'profile_social_media_links_switch', 'equals', '1' ),
						'placeholder'	 => array(
							'title'			 => __( 'Site Name', 'boss' ),
						)
					),
				)
			);

			// Typography Settings
			$this->sections[] = array(
				'title'	 => __( 'Typography', 'boss' ),
				'icon'	 => 'el-icon-font',
				'fields' => array(
					array(
						'id'			 => 'boss_site_title_font_family',
						'type'			 => 'typography',
						'title'			 => __( 'Site Title', 'boss' ),
						'subtitle'		 => __( 'Specify the site title properties.', 'boss' ),
						'google'		 => true,
						'line-height'	 => false,
						'text-align'	 => false,
						'subsets'		 => true,
						'color'			 => false,
						'default'		 => array(
							'font-size'		 => '30px',
							'google'		 => 'true',
							'font-family'	 => 'Pacifico',
							'font-weight'	 => '400',
						),
						'output'		 => array( '.is-desktop #mastlogo .site-title, .is-mobile #mobile-header .site-title a, #mobile-header h1 a' ),
					),
                    array(
                        'id'             => 'boss_body_font_family',
                        'type'           => 'typography',
                        'title'          => __( 'Body Font', 'boss' ),
                        'subtitle'       => __( 'Specify the body font properties.', 'boss' ),
                        'google'         => true,
                        'line-height'    => false,
                        'text-align'     => false,
                        'subsets'        => true,
                        'color'          => false,
                        'default'        => array(
                            'font-size'      => '14px',
                            'font-family'    => 'Lato',
                            'font-weight'    => '400',
                        ),
                        'output'         => array( 'html, #profile-nav span, #wp-admin-bar-shortcode-secondary .alert, .header-notifications a.notification-link span, .site-header #wp-admin-bar-shortcode-secondary .alert, .header-notifications a.notification-link span, .entry-meta .comments-link a, .entry-meta .post-date time' ),
                    ),
					array(
						'id'			 => 'boss_body_font_family_bold',
						'type'			 => 'typography',
						'title'			 => __( 'Body Font Bold', 'boss' ),
						'subtitle'		 => __( 'Specify the bold body font properties.', 'boss' ),
						'google'		 => true,
						'line-height'	 => false,
						'text-align'	 => false,
						'subsets'		 => true,
						'color'			 => false,
						'default'		 => array(
							'font-size'		 => '14px',
							'font-family'	 => 'Lato',
							'font-weight'	 => '700',
						),
						'output'		 => array( 'strong, b' ),
					),
					array(
						'id'			 => 'boss_h1_font_options',
						'type'			 => 'typography',
						'title'			 => __( 'H1 Font', 'boss' ),
						'subtitle'		 => __( 'Specify the H1 tag font properties.', 'boss' ),
						'google'		 => true,
						'font-size'		 => true,
						'line-height'	 => false,
						'text-align'	 => false,
						'subsets'		 => true,
						'color'			 => false,
						'default'		 => array(
							'font-family'	 => 'Arimo',
							'font-size'		 => '36px',
							'font-weight'	 => '700',
						),
						'output'		 => array( 'h1' ),
					),
					array(
						'id'			 => 'boss_h2_font_options',
						'type'			 => 'typography',
						'title'			 => __( 'H2 Font', 'boss' ),
						'subtitle'		 => __( 'Specify the H2 tag font properties.', 'boss' ),
						'google'		 => true,
						'font-size'		 => true,
						'line-height'	 => false,
						'text-align'	 => false,
						'subsets'		 => true,
						'color'			 => false,
						'default'		 => array(
							'font-family'	 => 'Arimo',
							'font-size'		 => '30px',
							'font-weight'	 => '700',
						),
						'output'		 => array( 'h2' ),
					),
					array(
						'id'			 => 'boss_h3_font_options',
						'type'			 => 'typography',
						'title'			 => __( 'H3 Font', 'boss' ),
						'subtitle'		 => __( 'Specify the H3 tag font properties.', 'boss' ),
						'google'		 => true,
						'font-size'		 => true,
						'line-height'	 => false,
						'text-align'	 => false,
						'subsets'		 => true,
						'color'			 => false,
						'default'		 => array(
							'font-family'	 => 'Arimo',
							'font-size'		 => '24px',
							'font-weight'	 => '700',
						),
						'output'		 => array( 'h3' ),
					),
					array(
						'id'			 => 'boss_h4_font_options',
						'type'			 => 'typography',
						'title'			 => __( 'H4 Font', 'boss' ),
						'subtitle'		 => __( 'Specify the H4 tag font properties.', 'boss' ),
						'google'		 => true,
						'font-size'		 => true,
						'line-height'	 => false,
						'text-align'	 => false,
						'subsets'		 => true,
						'color'			 => false,
						'default'		 => array(
							'font-family'	 => 'Arimo',
							'font-size'		 => '18px',
							'font-weight'	 => '700',
						),
						'output'		 => array( 'h4' ),
					),
					array(
						'id'			 => 'boss_h5_font_options',
						'type'			 => 'typography',
						'title'			 => __( 'H5 Font', 'boss' ),
						'subtitle'		 => __( 'Specify the H5 tag font properties.', 'boss' ),
						'google'		 => true,
						'font-size'		 => true,
						'line-height'	 => false,
						'text-align'	 => false,
						'subsets'		 => true,
						'color'			 => false,
						'default'		 => array(
							'font-family'	 => 'Arimo',
							'font-size'		 => '14px',
							'font-weight'	 => '700',
						),
						'output'		 => array( 'h5' ),
					),
					array(
						'id'			 => 'boss_h6_font_options',
						'type'			 => 'typography',
						'title'			 => __( 'H6 Font', 'boss' ),
						'subtitle'		 => __( 'Specify the H6 tag font properties.', 'boss' ),
						'google'		 => true,
						'font-size'		 => true,
						'line-height'	 => false,
						'text-align'	 => false,
						'subsets'		 => true,
						'color'			 => false,
						'default'		 => array(
							'font-family'	 => 'Arimo',
							'font-size'		 => '12px',
							'font-weight'	 => '700',
						),
						'output'		 => array( 'h6' ),
					),
					array(
						'id'			 => 'boss_page_title_font_options',
						'type'			 => 'typography',
						'title'			 => __( 'Page Title', 'boss' ),
						'subtitle'		 => __( 'Specify the page title font properties.', 'boss' ),
						'google'		 => true,
						'font-size'		 => true,
						'line-height'	 => false,
						'text-align'	 => false,
						'subsets'		 => true,
						'color'			 => false,
						'default'		 => array(
							'font-family'	 => 'Arimo',
							'font-size'		 => '30px',
							'font-weight'	 => '700',
						),
						'output'		 => array( '#item-header-content h1,.group-info li p:first-child,#item-statistics .numbers span p:first-child' ),
					),
					array(
						'id'			 => 'boss_slide_title_font_options',
						'type'			 => 'typography',
						'title'			 => __( 'Slide Title', 'boss' ),
						'subtitle'		 => __( 'Specify the slide title font properties.', 'boss' ),
						'google'		 => true,
						'font-size'		 => true,
						'line-height'	 => false,
						'text-align'	 => false,
						'subsets'		 => true,
						'color'			 => false,
						'default'		 => array(
							'font-family'	 => 'Source Sans Pro',
							'font-size'		 => '70px',
							'font-weight'	 => '700',
						),
						'output'		 => array( '.bb-slider-container .title' ),
					),
				)
			);

			$default_scheme = apply_filters( 'boss_default_color_scheme', 'default' );

			$style_elements = array(
				array( 'slug' => 'boss_scheme_select', 'desc' => 'ss', 'type' => 'preset', 'default' => $default_scheme ),
				array( 'slug' => 'text_info', 'desc' => 'Text', 'type' => 'info' ),
				array( 'slug' => 'boss_body_font_color', 'title' => 'Text Color', 'subtitle' => 'Set the text color for body.', 'desc' => '', 'type' => 'color', 'default' => '#737373' ),
				array( 'slug' => 'boss_heading_font_color', 'title' => 'Headings Color', 'subtitle' => 'Set the color for h1, h2, h3, h4, h5, h6 elements.', 'desc' => '', 'type' => 'color', 'default' => '#000000' ),
				array( 'slug' => 'boss_slideshow_font_color', 'title' => 'Slideshow Text Color', 'subtitle' => 'Set the color for slideshow content.', 'desc' => '', 'type' => 'color', 'default' => '#ffffff' ),
				array( 'slug' => 'links_buttons_info', 'desc' => 'Links and Buttons', 'type' => 'info' ),
				array( 'slug' => 'boss_links_pr_color', 'title' => 'Link Color', 'subtitle' => 'Select your color for anchor elements (links).', 'desc' => '', 'type' => 'color', 'default' => '#000000' ),
				array( 'slug' => 'boss_links_color', 'title' => 'Buttons Color', 'subtitle' => 'Select your color for button elements.', 'desc' => '', 'type' => 'color', 'default' => '#4dcadd' ),
				array( 'slug' => 'body_info', 'desc' => 'Body', 'type' => 'info' ),
				array( 'slug' => 'boss_layout_body_color', 'title' => 'Body Background Color', 'subtitle' => 'Select your color for body background.', 'desc' => '', 'type' => 'color', 'default' => '#ffffff' ),
				array( 'slug' => 'footer_color_info', 'desc' => 'Footer', 'type' => 'info' ),
				array( 'slug' => 'boss_layout_footer_top_color', 'title' => 'Footer Widgets Background Color', 'subtitle' => 'Select your background color for footer widget area.', 'desc' => '', 'type' => 'color', 'default' => '#ffffff' ),
				array( 'slug' => 'boss_layout_footer_bottom_color', 'title' => 'Footer Bottom Text Color', 'subtitle' => 'Select your color for footer bottom.', 'desc' => '', 'type' => 'color', 'default' => '#999999' ),
				array( 'slug' => 'boss_layout_footer_bottom_bgcolor', 'title' => 'Footer Bottom Background Color', 'subtitle' => 'Select your color for footer bottom background.', 'desc' => '', 'type' => 'color', 'default' => '#ffffff' ),
				array( 'slug' => 'titlebar_desktop_info', 'desc' => 'Titlebar (Desktop)', 'type' => 'info' ),
				array( 'slug' => 'boss_panel_logo_color', 'title' => 'Logo Area Background', 'subtitle' => 'Set background color for logo area.', 'desc' => '', 'type' => 'color', 'default' => '#30445C' ),
				array( 'slug' => 'boss_title_color', 'title' => 'Site Title Color', 'subtitle' => 'Select your color for site title.', 'desc' => '', 'type' => 'color', 'default' => '#ffffff' ),
				array( 'slug' => 'boss_layout_titlebar_bgcolor', 'title' => 'Titlebar Background Color', 'subtitle' => 'Select your background color for Titlebar.', 'desc' => '', 'type' => 'color', 'default' => '#ffffff' ),
				array( 'slug' => 'boss_layout_titlebar_color', 'title' => 'Titlebar Text Color', 'subtitle' => 'Select your text color for Titlebar.', 'desc' => '', 'type' => 'color', 'default' => '#999999' ),
				array( 'slug' => 'titlebar_nobp_info', 'desc' => 'Titlebar (Desktop without BuddyPanel)', 'type' => 'info' ),
				array( 'slug' => 'boss_layout_nobp_titlebar_bgcolor', 'title' => 'Titlebar Background Color', 'subtitle' => 'Select your background color for Titlebar.', 'desc' => '', 'type' => 'color', 'default' => '#30455c' ),
				array( 'slug' => 'boss_layout_nobp_titlebar_color', 'title' => 'Titlebar Links Color', 'subtitle' => 'Select your color for links in Titlebar.', 'desc' => '', 'type' => 'color', 'default' => '#ffffff' ),
				array( 'slug' => 'boss_layout_nobp_titlebar_hover_color', 'title' => 'Titlebar Links Hover Color', 'subtitle' => 'Select your hover color for links in Titlebar.', 'desc' => '', 'type' => 'color', 'default' => '#4dcadd' ),
				array( 'slug' => 'titlebar_mobile_info', 'desc' => 'Titlebar (Mobile)', 'type' => 'info' ),
				array( 'slug' => 'boss_layout_mobiletitlebar_bgcolor', 'title' => 'Mobile Titlebar Background Color', 'subtitle' => 'Select your background color for mobile Titlebar.', 'desc' => '', 'type' => 'color', 'default' => '#39516e' ),
				array( 'slug' => 'boss_layout_mobiletitlebar_color', 'title' => 'Mobile Titlebar Text Color', 'subtitle' => 'Select your text color for mobile Titlebar.', 'desc' => '', 'type' => 'color', 'default' => '#ffffff' ),
				array( 'slug' => 'buddypanel_color_info', 'desc' => 'BuddyPanel', 'type' => 'info' ),
				array( 'slug' => 'boss_panel_color', 'title' => 'BuddyPanel Background Color', 'subtitle' => 'Select your background color for BuddyPanel.', 'desc' => '', 'type' => 'color', 'default' => '#30445C' ),
				array( 'slug' => 'boss_panel_title_color', 'title' => 'BuddyPanel Title Color', 'subtitle' => 'Select your title color for BuddyPanel.', 'desc' => '', 'type' => 'color', 'default' => '#ffffff' ),
				array( 'slug' => 'boss_panel_icons_color', 'title' => 'BuddyPanel Icons Color', 'subtitle' => 'Select your color for icons in BuddyPanel.', 'desc' => '', 'type' => 'color', 'default' => '#3c7a90' ),
				array( 'slug' => 'boss_panel_open_icons_color', 'title' => 'BuddyPanel Open Icons Color', 'subtitle' => 'Select your color for icons in BuddyPanel.', 'desc' => '', 'type' => 'color', 'default' => '#366076' ),
				array( 'slug' => 'cover_photo_color_info', 'desc' => 'Cover Photos', 'type' => 'info' ),
				array( 'slug' => 'boss_cover_color', 'title' => 'Cover Photo Background', 'subtitle' => 'Select your background color for cover photo.', 'desc' => '', 'type' => 'color', 'default' => '#3c7a90' ),
				array( 'slug' => 'admin_screen_info', 'desc' => 'Admin Screen', 'type' => 'info' ),
				array( 'slug' => 'boss_admin_screen_background_color', 'title' => 'Admin Screen Background Color', 'subtitle' => 'Select your background color for admin screen.', 'desc' => '', 'type' => 'color', 'default' => '#30455c' ),
				array( 'slug' => 'boss_admin_screen_text_color', 'title' => 'Admin Screen Text Color', 'subtitle' => 'Select your text color for admin screen.', 'desc' => '', 'type' => 'color', 'default' => '#ffffff' ),
				array( 'slug' => 'boss_admin_screen_button_color', 'title' => 'Admin Screen Links and Button Color', 'subtitle' => 'Select your links hover color and buttons color for admin screen.', 'desc' => '', 'type' => 'color', 'default' => '#4dcadd' ),
                array( 'slug' => 'boss_edu_color_section', 'desc' => 'Social Learner Options', 'type' => 'info' ),
                array( 'slug' => 'boss_edu_active_link_color', 'title' => 'Active link color', 'subtitle' => 'Set the color for active links.', 'desc' => '', 'type' => 'color', 'default' => '#ea6645' ),
                array( 'slug' => 'boss_edu_sidebar_bg', 'title' => 'Sidebar Background', 'subtitle' => 'Set the color for sidebar.', 'desc' => '', 'type' => 'color', 'default' => '#cdd7e2' ),
			);

			$style_elements = apply_filters( 'boss_filter_color_options', $style_elements );

			$style_fields = array();

			$default = array(
				'alt'		 => 'Default',
				'img'		 => get_template_directory_uri() . '/buddyboss-inc/buddyboss-framework/assets/images/presets/default.png',
				'presets'	 => array(
					'boss_body_font_color'					 => '#737373',
					'boss_heading_font_color'				 => '#000',
					'boss_slideshow_font_color'				 => '#ffffff',
					'boss_links_pr_color'					 => '#000',
					'boss_links_color'						 => '#4dcadd',
                    'boss_edu_active_link_color'             => '#4dcadd',
                    'boss_edu_sidebar_bg'                    => '#ffffff',
					'boss_layout_body_color'				 => '#ffffff',
					'boss_layout_footer_top_color'			 => '#ffffff',
					'boss_layout_footer_bottom_color'		 => '#999999',
					'boss_layout_footer_bottom_bgcolor'		 => '#ffffff',
					'boss_panel_logo_color'					 => '#30445C',
					'boss_title_color'						 => '#ffffff',
					'boss_layout_titlebar_bgcolor'			 => '#ffffff',
					'boss_layout_titlebar_color'			 => '#999999',
					'boss_layout_nobp_titlebar_bgcolor'		 => '#30455c',
					'boss_layout_nobp_titlebar_color'		 => '#fff',
					'boss_layout_nobp_titlebar_hover_color'	 => '#4dcadd',
					'boss_layout_mobiletitlebar_bgcolor'	 => '#39516e',
					'boss_layout_mobiletitlebar_color'		 => '#fff',
					'boss_panel_color'						 => '#30445C',
					'boss_panel_title_color'				 => '#ffffff',
					'boss_panel_icons_color'				 => '#3c7a90',
					'boss_panel_open_icons_color'			 => '#366076',
					'boss_cover_color'						 => '#3c7a90',
					'boss_admin_screen_background_color'	 => '#30455c',
					'boss_admin_screen_text_color'			 => '#ffffff',
					'boss_admin_screen_button_color'		 => '#4dcadd',
				)
			);

			$battleship = array(
				'alt'		 => 'Battleship',
				'img'		 => get_template_directory_uri() . '/buddyboss-inc/buddyboss-framework/assets/images/presets/battleship.png',
				'presets'	 => array(
					'boss_body_font_color'					 => '#737373',
					'boss_heading_font_color'				 => '#000',
					'boss_slideshow_font_color'				 => '#ffffff',
					'boss_links_pr_color'					 => '#000',
					'boss_links_color'						 => '#d82520',
                    'boss_edu_active_link_color'             => '#d82520',
                    'boss_edu_sidebar_bg'                    => '#dcdde2',
					'boss_layout_body_color'				 => '#dcdde2',
					'boss_layout_footer_top_color'			 => '#dcdde2',
					'boss_layout_footer_bottom_color'		 => '#a3a3a5',
					'boss_layout_footer_bottom_bgcolor'		 => '#1d181e',
					'boss_panel_logo_color'					 => '#252525',
					'boss_title_color'						 => '#ffffff',
					'boss_layout_titlebar_bgcolor'			 => '#d82520',
					'boss_layout_titlebar_color'			 => '#ffffff',
					'boss_layout_nobp_titlebar_bgcolor'		 => '#252525',
					'boss_layout_nobp_titlebar_color'		 => '#fff',
					'boss_layout_nobp_titlebar_hover_color'	 => '#fff',
					'boss_layout_mobiletitlebar_bgcolor'	 => '#d82520',
					'boss_layout_mobiletitlebar_color'		 => '#fff',
					'boss_panel_color'						 => '#626167',
					'boss_panel_title_color'				 => '#ffffff',
					'boss_panel_icons_color'				 => '#ffffff',
					'boss_panel_open_icons_color'			 => '#ffffff',
					'boss_cover_color'						 => '#252525',
					'boss_admin_screen_background_color'	 => '#626167',
					'boss_admin_screen_text_color'			 => '#ffffff',
					'boss_admin_screen_button_color'		 => '#d82520',
				)
			);

			$royalty = array(
				'alt'		 => 'Royalty',
				'img'		 => get_template_directory_uri() . '/buddyboss-inc/buddyboss-framework/assets/images/presets/royalty.png',
				'presets'	 => array(
					'boss_body_font_color'					 => '#DED5E1',
					'boss_heading_font_color'				 => '#ffffff',
					'boss_slideshow_font_color'				 => '#ffffff',
					'boss_links_pr_color'					 => '#ffffff',
					'boss_links_color'						 => '#f8b63b',
                    'boss_edu_active_link_color'             => '#f8b63b',
                    'boss_edu_sidebar_bg'                    => '#5e4b61',
					'boss_layout_body_color'				 => '#5e4b61',
					'boss_layout_footer_top_color'			 => '#5e4b61',
					'boss_layout_footer_bottom_color'		 => '#5e4b61',
					'boss_layout_footer_bottom_bgcolor'		 => '#1d181e',
					'boss_panel_logo_color'					 => '#f8b83a',
					'boss_title_color'						 => '#ffffff',
					'boss_layout_titlebar_bgcolor'			 => '#4d3653',
					'boss_layout_titlebar_color'			 => '#ffffff',
					'boss_layout_nobp_titlebar_bgcolor'		 => '#f8b83a',
					'boss_layout_nobp_titlebar_color'		 => '#fff',
					'boss_layout_nobp_titlebar_hover_color'	 => '#fff',
					'boss_layout_mobiletitlebar_bgcolor'	 => '#4a364f',
					'boss_layout_mobiletitlebar_color'		 => '#fff',
					'boss_panel_color'						 => '#4a364f',
					'boss_panel_title_color'				 => '#ffffff',
					'boss_panel_icons_color'				 => '#ffffff',
					'boss_panel_open_icons_color'			 => '#ffffff',
					'boss_cover_color'						 => '#4d3653',
					'boss_admin_screen_background_color'	 => '#4a364f',
					'boss_admin_screen_text_color'			 => '#ffffff',
					'boss_admin_screen_button_color'		 => '#f8b63b',
				)
			);

			$seashell = array(
				'alt'		 => 'Seashell',
				'img'		 => get_template_directory_uri() . '/buddyboss-inc/buddyboss-framework/assets/images/presets/seashell.png',
				'presets'	 => array(
					'boss_body_font_color'					 => '#02899f',
					'boss_heading_font_color'				 => '#0184a2',
					'boss_slideshow_font_color'				 => '#ffffff',
					'boss_links_pr_color'					 => '#0184a2',
					'boss_links_color'						 => '#ee7c35',
                    'boss_edu_active_link_color'             => '#ee7c35',
                    'boss_edu_sidebar_bg'                    => '#d9edee',
					'boss_layout_body_color'				 => '#d9edee',
					'boss_layout_footer_top_color'			 => '#5e4b61',
					'boss_layout_footer_bottom_color'		 => '#a3a3a5',
					'boss_layout_footer_bottom_bgcolor'		 => '#1d181e',
					'boss_panel_logo_color'					 => '#007893',
					'boss_title_color'						 => '#ffffff',
					'boss_layout_titlebar_bgcolor'			 => '#ee7c35',
					'boss_layout_titlebar_color'			 => '#ffffff',
					'boss_layout_nobp_titlebar_bgcolor'		 => '#007893',
					'boss_layout_nobp_titlebar_color'		 => '#fff',
					'boss_layout_nobp_titlebar_hover_color'	 => '#fff',
					'boss_layout_mobiletitlebar_bgcolor'	 => '#ee7c35',
					'boss_layout_mobiletitlebar_color'		 => '#fff',
					'boss_panel_color'						 => '#007893',
					'boss_panel_title_color'				 => '#ffffff',
					'boss_panel_icons_color'				 => '#ffffff',
					'boss_panel_open_icons_color'			 => '#ffffff',
					'boss_cover_color'						 => '#0184a2',
					'boss_admin_screen_background_color'	 => '#007893',
					'boss_admin_screen_text_color'			 => '#ffffff',
					'boss_admin_screen_button_color'		 => '#ee7c35',
				)
			);

			$starfish = array(
				'alt'		 => 'Starfish',
				'img'		 => get_template_directory_uri() . '/buddyboss-inc/buddyboss-framework/assets/images/presets/starfish.png',
				'presets'	 => array(
					'boss_body_font_color'					 => '#6d6d6d',
					'boss_heading_font_color'				 => '#294354',
					'boss_slideshow_font_color'				 => '#ffffff',
					'boss_links_pr_color'					 => '#52c2e7',
					'boss_links_color'						 => '#fc7055',
                    'boss_edu_active_link_color'             => '#fc7055',
                    'boss_edu_sidebar_bg'                    => '#f5f5f5',
					'boss_layout_body_color'				 => '#f5f5f5',
					'boss_layout_footer_top_color'			 => '#f0f0f0',
					'boss_layout_footer_bottom_color'		 => '#c4c4c4',
					'boss_layout_footer_bottom_bgcolor'		 => '#ffffff',
					'boss_panel_logo_color'					 => '#fc7055',
					'boss_title_color'						 => '#ffffff',
					'boss_layout_titlebar_bgcolor'			 => '#fc7055',
					'boss_layout_titlebar_color'			 => '#ffffff',
					'boss_layout_nobp_titlebar_bgcolor'		 => '#fc7055',
					'boss_layout_nobp_titlebar_color'		 => '#fff',
					'boss_layout_nobp_titlebar_hover_color'	 => '#fff',
					'boss_layout_mobiletitlebar_bgcolor'	 => '#fc7055',
					'boss_layout_mobiletitlebar_color'		 => '#fff',
					'boss_panel_color'						 => '#cdc9bd',
					'boss_panel_title_color'				 => '#ffffff',
					'boss_panel_icons_color'				 => '#ffffff',
					'boss_panel_open_icons_color'			 => '#ffffff',
					'boss_cover_color'						 => '#2e2e2e',
					'boss_admin_screen_background_color'	 => '#cdc9bd',
					'boss_admin_screen_text_color'			 => '#ffffff',
					'boss_admin_screen_button_color'		 => '#fc7055',
				)
			);

			$mint = array(
				'alt'		 => 'Mint',
				'img'		 => get_template_directory_uri() . '/buddyboss-inc/buddyboss-framework/assets/images/presets/mint.png',
				'presets'	 => array(
					'boss_body_font_color'					 => '#727272',
					'boss_heading_font_color'				 => '#2c455b',
					'boss_slideshow_font_color'				 => '#ffffff',
					'boss_links_pr_color'					 => '#2c455b',
					'boss_links_color'						 => '#06b39f',
                    'boss_edu_active_link_color'             => '#06b39f',
                    'boss_edu_sidebar_bg'                    => '#ffffff',
					'boss_layout_body_color'				 => '#ffffff',
					'boss_layout_footer_top_color'			 => '#f0f0f0',
					'boss_layout_footer_bottom_color'		 => '#cdcdcd',
					'boss_layout_footer_bottom_bgcolor'		 => '#ffffff',
					'boss_panel_logo_color'					 => '#0cb2a4',
					'boss_title_color'						 => '#ffffff',
					'boss_layout_titlebar_bgcolor'			 => '#d2fcf8',
					'boss_layout_titlebar_color'			 => '#06b39f',
					'boss_layout_nobp_titlebar_bgcolor'		 => '#0cb2a4',
					'boss_layout_nobp_titlebar_color'		 => '#fff',
					'boss_layout_nobp_titlebar_hover_color'	 => '#fff',
					'boss_layout_mobiletitlebar_bgcolor'	 => '#655652',
					'boss_layout_mobiletitlebar_color'		 => '#fff',
					'boss_panel_color'						 => '#544643',
					'boss_panel_title_color'				 => '#ffffff',
					'boss_panel_icons_color'				 => '#10b4a9',
					'boss_panel_open_icons_color'			 => '#10b4a9',
					'boss_cover_color'						 => '#0cb2a4',
					'boss_admin_screen_background_color'	 => '#544643',
					'boss_admin_screen_text_color'			 => '#ffffff',
					'boss_admin_screen_button_color'		 => '#06b39f',
				)
			);

			$iceberg = array(
				'alt'		 => 'Iceberg',
				'img'		 => get_template_directory_uri() . '/buddyboss-inc/buddyboss-framework/assets/images/presets/iceberg.png',
				'presets'	 => array(
					'boss_body_font_color'					 => '#727272',
					'boss_heading_font_color'				 => '#2c455b',
					'boss_slideshow_font_color'				 => '#ffffff',
					'boss_links_pr_color'					 => '#2c455b',
					'boss_links_color'						 => '#6db0dd',
                    'boss_edu_active_link_color'             => '#6db0dd',
                    'boss_edu_sidebar_bg'                    => '#ffffff',
					'boss_layout_body_color'				 => '#ffffff',
					'boss_layout_footer_top_color'			 => '#f0f0f0',
					'boss_layout_footer_bottom_color'		 => '#cdcdcd',
					'boss_layout_footer_bottom_bgcolor'		 => '#ffffff',
					'boss_panel_logo_color'					 => '#545454',
					'boss_title_color'						 => '#ffffff',
					'boss_layout_titlebar_bgcolor'			 => '#545454',
					'boss_layout_titlebar_color'			 => '#ffffff',
					'boss_layout_nobp_titlebar_bgcolor'		 => '#545454',
					'boss_layout_nobp_titlebar_color'		 => '#fff',
					'boss_layout_nobp_titlebar_hover_color'	 => '#fff',
					'boss_layout_mobiletitlebar_bgcolor'	 => '#545454',
					'boss_layout_mobiletitlebar_color'		 => '#fff',
					'boss_panel_color'						 => '#3a8bc2',
					'boss_panel_title_color'				 => '#ffffff',
					'boss_panel_icons_color'				 => '#4ec6e1',
					'boss_panel_open_icons_color'			 => '#4ec6e1',
					'boss_cover_color'						 => '#5ea1cc',
					'boss_admin_screen_background_color'	 => '#3a8bc2',
					'boss_admin_screen_text_color'			 => '#ffffff',
					'boss_admin_screen_button_color'		 => '#6db0dd',
				)
			);

			$nocturnal = array(
				'alt'		 => 'Nocturnal',
				'img'		 => get_template_directory_uri() . '/buddyboss-inc/buddyboss-framework/assets/images/presets/nocturnal.png',
				'presets'	 => array(
					'boss_body_font_color'					 => '#ffffff',
					'boss_heading_font_color'				 => '#ffffff',
					'boss_slideshow_font_color'				 => '#ffffff',
					'boss_links_pr_color'					 => '#4ec3e6',
					'boss_links_color'						 => '#7effbe',
                    'boss_edu_active_link_color'             => '#7effbe',
                    'boss_edu_sidebar_bg'                    => '#201e1f',
					'boss_layout_body_color'				 => '#201e1f',
					'boss_layout_footer_top_color'			 => '#201e1f',
					'boss_layout_footer_bottom_color'		 => '#cdcdcd',
					'boss_layout_footer_bottom_bgcolor'		 => '#181818',
					'boss_panel_logo_color'					 => '#7effbe',
					'boss_title_color'						 => '#ffffff',
					'boss_layout_titlebar_bgcolor'			 => '#181818',
					'boss_layout_titlebar_color'			 => '#ffffffff',
					'boss_layout_nobp_titlebar_bgcolor'		 => '#7effbe',
					'boss_layout_nobp_titlebar_color'		 => '#fff',
					'boss_layout_nobp_titlebar_hover_color'	 => '#fff',
					'boss_layout_mobiletitlebar_bgcolor'	 => '#7effbe',
					'boss_layout_mobiletitlebar_color'		 => '#181818',
					'boss_panel_color'						 => '#181818',
					'boss_panel_title_color'				 => '#ffffff',
					'boss_panel_icons_color'				 => '#ffffff',
					'boss_panel_open_icons_color'			 => '#ffffff',
					'boss_cover_color'						 => '#5ea1cc',
					'boss_admin_screen_background_color'	 => '#181818',
					'boss_admin_screen_text_color'			 => '#ffffff',
					'boss_admin_screen_button_color'		 => '#7effbe',
				)
			);

			$default_themes = array();

			$default_themes[ 'default' ]	 = $default;
			$default_themes[ 'battleship' ]	 = $battleship;
			$default_themes[ 'royalty' ]	 = $royalty;
			$default_themes[ 'seashell' ]	 = $seashell;
			$default_themes[ 'starfish' ]	 = $starfish;
			$default_themes[ 'mint' ]		 = $mint;
			$default_themes[ 'iceberg' ]	 = $iceberg;
			$default_themes[ 'nocturnal' ]	 = $nocturnal;

            global $learner;

            if($learner) {
                $education = array(
                    'education' => array(
                        'alt'		 => 'Social Learner',
                        'img'		 => get_template_directory_uri() . '/buddyboss-inc/buddyboss-framework/assets/images/presets/social_learner.png',
                        'presets'	 => array(
                            'boss_title_color'						 => '#ffffff',
                            'boss_cover_color'						 => '#012243',
                            'boss_panel_logo_color'					 => '#012243',
                            'boss_panel_color'						 => '#012243',
                            'boss_panel_title_color'				 => '#ffffff',
                            'boss_panel_icons_color'				 => '#0e4362',
                            'boss_panel_open_icons_color'			 => '#0e4362',
                            'boss_layout_titlebar_bgcolor'			 => '#fff',
                            'boss_layout_titlebar_color'			 => '#8091a1',
                            'boss_layout_mobiletitlebar_bgcolor'	 => '#012243',
                            'boss_layout_mobiletitlebar_color'		 => '#fff',
                            'boss_layout_nobp_titlebar_bgcolor'		 => '#012243',
                            'boss_layout_nobp_titlebar_color'		 => '#fff',
                            'boss_layout_nobp_titlebar_hover_color'	 => '#ea6645',
                            'boss_edu_sidebar_bg'                    => '#cdd7e2',
                            'boss_layout_body_color'				 => '#e3e9f0',
                            'boss_layout_footer_top_color'			 => '#fff',
                            'boss_layout_footer_bottom_bgcolor'		 => '#fff',
                            'boss_layout_footer_bottom_color'		 => '#8091a1',
                            'boss_links_pr_color'					 => '#012243',
                            'boss_links_color'						 => '#00a6dc',
                            'boss_edu_active_link_color'             => '#ea6645',
                            'boss_slideshow_font_color'				 => '#ffffff',
                            'boss_heading_font_color'				 => '#012243',
                            'boss_body_font_color'					 => '#012243',
                            'boss_admin_screen_background_color'	 => '#012243',
                            'boss_admin_screen_text_color'			 => '#ffffff',
                            'boss_admin_screen_button_color'		 => '#00a6dc',
                        )
                    )
                );

                $default_themes = array_merge( $education, $default_themes );
            }

			foreach ( $style_elements as $elem ) {
				if ( $elem[ 'type' ] == 'color' ) {
					$style_fields[] = array(
						'id'		 => $elem[ 'slug' ],
						'type'		 => $elem[ 'type' ],
						'title'		 => $elem[ 'title' ],
						'subtitle'	 => $elem[ 'subtitle' ],
						'desc'		 => $elem[ 'desc' ],
						'default'	 => $elem[ 'default' ]
					);
				} elseif ( $elem[ 'type' ] == 'info' ) {
					$style_fields[] = array(
						'id'	 => $elem[ 'slug' ],
						'type'	 => 'info',
						'desc'	 => $elem[ 'desc' ],
					);
				} elseif ( $elem[ 'type' ] == 'preset' ) {
					$style_fields[] = array(
						'id'		 => $elem[ 'slug' ],
						'type'		 => 'custom_image_select',
						'title'		 => 'Color Presets',
						'subtitle'	 => 'Change section colors based on these presets.',
						'presets'	 => true,
						'customizer' => false,
						'default'	 => 0,
						'options'	 => apply_filters( 'buddyboss_customizer_themes_preset', $default_themes )
					);
				}
			}

			$this->sections[] = array(
				'icon'		 => 'el-icon-tint',
				'icon_class' => 'icon-large',
				'title'		 => __( 'Styling', 'boss' ),
				'priority'	 => 20,
				'desc'		 => '',
				'fields'	 => $style_fields,
			);

			// Array of social options
			$social_options = array(
				'facebook'		 => '',
				'twitter'		 => '',
				'linkedin'		 => '',
				'google-plus'	 => '',
				'youtube'		 => '',
				'instagram'		 => '',
				'pinterest'		 => '',
				'email'			 => '',
				'dribbble'		 => '',
				'vk'			 => '',
				'tumblr'		 => '',
				'github'		 => '',
				'flickr'		 => '',
				'skype'			 => '',
				'vimeo'			 => '',
				'xing'			 => '',
				'rss'			 => '',
			);

			$social_options = apply_filters( 'boss_social_options', $social_options );

			// Footer Settings
			$this->sections[] = array(
				'title'		 => __( 'Footer', 'boss' ),
				'icon'		 => 'el-icon-bookmark',
				'customizer' => false,
				'fields'	 => array(
					array(
						'id'		 => 'footer_copyright_content',
						'type'		 => 'switch',
						'title'		 => __( 'Copyright Text', 'boss' ),
						'subtitle'	 => __( 'Enter your custom copyright text.', 'boss' ),
						'default'	 => '1',
						'on'		 => __( 'On', 'boss' ),
						'off'		 => __( 'Off', 'boss' ),
					),
					array(
						'id'		 => 'boss_copyright',
						'type'		 => 'editor',
						'default'	 => '&copy; ' . date( 'Y' ) . ' - Boss <span class="boss-credit">&middot; Powered by <a href="https://www.buddyboss.com" title="BuddyPress themes" target="_blank">BuddyBoss</a></span>',
						'args'		 => array(
							'teeny'			 => true,
							'media_buttons'	 => false,
							'textarea_rows'	 => 6
						),
						'required'	 => array( 'footer_copyright_content', 'equals', '1' ),
					),
					array(
						'id'		 => 'footer_social_links',
						'type'		 => 'switch',
						'title'		 => __( 'Social Links', 'boss' ),
						'subtitle'	 => __( 'Define and reorder your social icons in the footer. Keep the input field empty for any social icon you do not wish to display.', 'boss' ),
						'default'	 => '1',
						'on'		 => __( 'On', 'boss' ),
						'off'		 => __( 'Off', 'boss' ),
					),
					array(
						'id'		 => 'boss_footer_social_links',
						'type'		 => 'sortable',
						'label'		 => true,
						'required'	 => array( 'footer_social_links', 'equals', '1' ),
						'options'	 => $social_options,
					),
				)
			);

			// Admin Login
			$this->sections[] = array(
				'title'		 => __( 'Admin Login', 'boss' ),
				'id'		 => 'admin_login',
				'customizer' => false,
				'icon'		 => 'el-icon-lock',
				'fields'	 => array(
					array(
						'id'		 => 'boss_custom_login',
						'type'		 => 'switch',
						'title'		 => __( 'Custom Login Screen', 'boss' ),
						'subtitle'	 => __( 'Toggle the custom login screen design on or off.', 'boss' ),
						'default'	 => '1',
						'on'		 => __( 'On', 'boss' ),
						'off'		 => __( 'Off', 'boss' ),
					),
					array(
						'id'		 => 'boss_admin_login_logo',
						'type'		 => 'media',
						'url'		 => false,
						'required'	 => array( 'boss_custom_login', 'equals', '1' ),
						'title'		 => __( 'Custom Logo', 'boss' ),
						'subtitle'	 => __( 'We display a custom logo in place of the default WordPress logo.', 'boss' ),
					),
					array(
						'id'		 => 'admin_custom_colors',
						'type'		 => 'color',
						'required'	 => array( 'boss_custom_login', 'equals', '1' ),
						'title'		 => __( 'Custom Colors', 'boss' ),
						'subtitle'	 => __( 'Edit the admin login screen colors in the <a href="javascript:void(0);" class="redux-group-tab-link-a" data-key="7" data-rel="7">Styling section</a>, under the "Admin Screen".', 'boss' ),
					),
				)
			);

			// Codes Settings
			$this->sections[] = array(
				'title'		 => __( 'Custom Codes', 'boss' ),
				'icon'		 => 'el-icon-edit',
				'customizer' => false,
				'fields'	 => array(
					array(
						'id'		 => 'tracking',
						'type'		 => 'switch',
						'title'		 => __( 'Tracking Code', 'boss' ),
						'subtitle'	 => __( 'Paste your Google Analytics (or other) tracking code here. This will be added before the closing of body tag.', 'boss' ),
						'default'	 => '0',
						'on'		 => __( 'On', 'boss' ),
						'off'		 => __( 'Off', 'boss' ),
					),
					array(
						'id'		 => 'boss_tracking_code',
						'type'		 => 'ace_editor',
						'mode'		 => 'plain_text',
						'theme'		 => 'chrome',
						'required'	 => array( 'tracking', 'equals', '1' ),
					),
					array(
						'id'		 => 'custom_css',
						'type'		 => 'switch',
						'title'		 => __( 'CSS', 'boss' ),
						'subtitle'	 => __( 'Quickly add some CSS here to make design adjustments. It is a much better solution then manually editing the theme. You may also consider using a child theme.', 'boss' ),
						'default'	 => '0',
						'on'		 => __( 'On', 'boss' ),
						'off'		 => __( 'Off', 'boss' ),
					),
					array(
						'id'		 => 'boss_custom_css',
						'type'		 => 'ace_editor',
						'mode'		 => 'css',
						'validate'	 => 'css',
						'theme'		 => 'chrome',
						'default'	 => ".your-class {\n    color: blue;\n}",
						'required'	 => array( 'custom_css', 'equals', '1' ),
					),
					array(
						'id'		 => 'custom_js',
						'type'		 => 'switch',
						'title'		 => __( 'JavaScript', 'boss' ),
						'subtitle'	 => __( 'Quickly add some JavaScript code here. It is a much better solution then manually editing the theme. You may also consider using a child theme.', 'boss' ),
						'default'	 => '0',
						'on'		 => __( 'On', 'boss' ),
						'off'		 => __( 'Off', 'boss' ),
					),
					array(
						'id'		 => 'boss_custom_js',
						'type'		 => 'ace_editor',
						'mode'		 => 'javascript',
						'validate'	 => 'plain_text',
						'theme'		 => 'chrome',
						'default'	 => "jQuery( document ).ready( function(){\n    //Your codes strat from here\n});",
						'required'	 => array( 'custom_js', 'equals', '1' ),
					)
				)
			);

			// Optimizations
			$this->sections[] = array(
				'title'		 => __( 'Optimizations', 'boss' ),
				'id'		 => 'optimizations',
				'customizer' => false,
				'icon'		 => 'el-icon-tasks',
				'fields'	 => array(
					array(
						'id'		 => 'boss_minified_css',
						'type'		 => 'switch',
						'title'		 => __( 'Minify CSS', 'boss' ),
						'subtitle'	 => __( 'By default the theme loads stylesheets that are not minified. Set this to YES to instead load minified and combined stylesheets.', 'boss' ),
						'default'	 => '0',
						'on'		 => __( 'Yes', 'boss' ),
						'off'		 => __( 'No', 'boss' ),
					),
					array(
						'id'		 => 'boss_minified_js',
						'type'		 => 'switch',
						'title'		 => __( 'Minify JavaScript', 'boss' ),
						'subtitle'	 => __( 'By default the theme loads scripts that are not minified. Set this to YES to instead load minified and combined JS files.', 'boss' ),
						'default'	 => '0',
						'on'		 => __( 'Yes', 'boss' ),
						'off'		 => __( 'No', 'boss' ),
					),
					array(
						'id'		 => 'boss_inputs',
						'type'		 => 'switch',
						'title'		 => __( 'Output JavaScript on ALL form inputs', 'boss' ),
						'subtitle'	 => __( 'We style form inputs (dropdowns, checkboxes, and radios) using JavaScript. Set this to NO to disable this on inputs outside of BuddyPress and bbPress, to improve compatibility with certain plugins.', 'boss' ),
						'on'		 => __( 'Yes', 'boss' ),
						'off'		 => __( 'No', 'boss' ),
						'default'	 => '1',
					),
				)
			);

			//Plugins
			$this->sections[] = array(
				'title'		 => __( 'Plugins', 'boss' ),
				'icon'		 => 'el-icon-wrench',
				'customizer' => false,
				'fields'	 => array(
					array(
						'id'		 => 'boss_plugin_support',
						'type'		 => 'raw',
						'full_width' => true,
						'callback'	 => 'boss_plugins_submenu_page_callback',
					),
				)
			);

			// Theme Support
			$this->sections[] = array(
				'icon'		 => 'el el-universal-access',
				'title'		 => __( 'Support', 'boss' ),
				'customizer' => false,
				'fields'	 => array(
					array(
						'id'		 => 'boss_support',
						'type'		 => 'raw',
						'markdown'	 => true,
						'callback'	 => 'boss_support_tab_content',
					),
				),
			);

			// Theme Documentation
			if ( file_exists( dirname( __FILE__ ) . '/../README.md' ) ) {
				$this->sections[ 'theme_docs' ] = array(
					'icon'	 => 'el-icon-list-alt',
					'title'	 => __( 'Documentation', 'boss' ),
					'fields' => array(
						array(
							'id'		 => '17',
							'type'		 => 'raw',
							'markdown'	 => true,
							'full_width' => true,
							'content'	 => file_get_contents( dirname( __FILE__ ) . '/../README.md' )
						),
					),
				);
			}

			// Import / Export
			$this->sections[] = array(
				'title'	 => __( 'Import / Export', 'boss' ),
				//'desc'	 => __( 'Import and Export your Boss theme settings from file, text or URL.', 'boss' ),
				'icon'	 => 'el-icon-refresh',
				'fields' => array(
					array(
						'id'		 => 'opt-import-export',
						'type'		 => 'import_export',
						//'title'		 => 'Import Export',
						//'subtitle'	 => 'Save and restore your Boss options',
						'full_width' => true,
					),
				),
			);

			if ( file_exists( trailingslashit( dirname( __FILE__ ) ) . 'README.html' ) ) {
				$tabs[ 'docs' ] = array(
					'icon'		 => 'el-icon-book',
					'title'		 => __( 'Documentation', 'boss' ),
					'content'	 => nl2br( file_get_contents( trailingslashit( dirname( __FILE__ ) ) . 'README.html' ) )
				);
			}

			//Miscellaneous settings
			$entry_content		 = apply_filters( 'boss_entry_content', array( 'content' => 'Post Content', 'excerpt' => 'Post Excerpt' ) );
			$this->sections[] = array(
				'title'		 => __( 'Miscellaneous', 'boss' ),
				'icon'		 => 'el-icon-th',
				'fields'	 => array(
					array(
						'id'		 => 'boss_entry_content',
						'type'		 => 'select',
						'title'		 => __( 'Entry Content', 'boss' ),
						'options'	 => $entry_content,
						'default'	 => 'excerpt',
					)
				)
			);

		}

		/**
		 * Returns xprofile fields list
		 */
		public function boss_customizer_xprofile_field_choices() {
            $options = array();
            if ( function_exists( 'bp_is_active' ) && bp_is_active( 'xprofile' ) ) {
                global $wpdb, $bp;
                $field_groups = array();

                $dbfields = $wpdb->get_results(
                    "SELECT g.id as 'group_id', g.name as 'group_name', f.id, f.name "
                    . " FROM {$bp->profile->table_name_fields} f JOIN {$bp->profile->table_name_groups} g ON f.group_id=g.id "
                    . " WHERE f.parent_id=0 "
                    . " ORDER BY f.name ASC "
                );


                if( !empty( $dbfields ) ){
                    foreach( $dbfields as $dbfield ){
                        if( !isset( $field_groups[$dbfield->group_id] ) ){
                            $field_groups[$dbfield->group_id] = array(
                                'name'      => $dbfield->group_name,
                                'fields'    => array(),
                            );
                        }

                        $field_groups[$dbfield->group_id]['fields'][$dbfield->id] = $dbfield->name;
                    }

                    $show_opt_group = count( $field_groups ) > 1 ? true : false;
                    foreach( $field_groups as $group_id => $group ){
                        if( $show_opt_group ){
                            //optgroup > options
                            $options[$group['name']] = $group['fields'];
                        } else {
                            foreach( $group['fields'] as $id=>$name ){
                                //direct options
                                $options[$id] = $name;
                            }
                        }
                    }
                }
            }
            return $options;
        }

		/**
		 * All the possible arguments for Boss.
		 * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
		 * */
		public function setArguments() {

			$theme = wp_get_theme(); // For use with some settings. Not necessary.

			$this->args = array(
				// TYPICAL -> Change these values as you need/desire
				'opt_name'			 => 'boss_options', // This is where your data is stored in the database and also becomes your global variable name.
				'display_name'		 => $theme->get( 'Name' ), // Name that appears at the top of your panel
				'display_version'	 => $theme->get( 'Version' ), // Version that appears at the top of your panel
				'menu_type'			 => 'submenu', //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
				'allow_sub_menu'	 => true, // Show the sections below the admin menu item or not
				'menu_title'		 => __( 'Boss Theme', 'boss' ),
				'page_title'		 => __( 'Boss Theme', 'boss' ),
				// You will need to generate a Google API key to use this feature.
				// Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
				'google_api_key'	 => 'AIzaSyARjtGd3aZFBZ_8kJty6BwgRsCurPFvFeg', // https://console.developers.google.com/project/ Must be defined to add google fonts to the typography module
				'async_typography'	 => false, // Use a asynchronous font on the front end or font string
				//'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
				'admin_bar'			 => false, // Show the panel pages on the admin bar
				'global_variable'	 => '', // Set a different name for your global variable other than the opt_name
				'dev_mode'			 => false, // Show the time the page took to load, etc
				'customizer'		 => true, // Enable basic customizer support
				//'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
				//'disable_save_warn' => true,                    // Disable the save warning when a user changes a field
				// OPTIONAL -> Give you extra features
				'page_priority'		 => null, // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
				'page_parent'		 => 'buddyboss-settings', // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
				'page_permissions'	 => 'manage_options', // Permissions needed to access the options panel.
				'menu_icon'			 => '', // Specify a custom URL to an icon
				'last_tab'			 => '', // Force your panel to always open to a specific tab (by id)
				'page_icon'			 => 'icon-themes', // Icon displayed in the admin panel next to your menu_title
				'page_slug'			 => 'boss_options', // Page slug used to denote the panel
				'save_defaults'		 => true, // On load save the defaults to DB before user clicks save or not
				'default_show'		 => false, // If true, shows the default value next to each field that is not the default value.
				'default_mark'		 => '', // What to print by the field's title if the value shown is default. Suggested: *
				'show_import_export' => true, // Shows the Import/Export panel when not used as a field.
				// CAREFUL -> These options are for advanced use only
				'transient_time'	 => 60 * MINUTE_IN_SECONDS,
				'output'			 => true, // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
				'output_tag'		 => true, // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
				'footer_credit'		 => ' ', // Disable the footer credit of Redux. Please leave if you can help it.
				// FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
				'database'			 => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
				'system_info'		 => false, // REMOVE
				'disable_tracking'	 => true,
				'ajax_save'          => true,
				// HINTS
				'hints'				 => array(
					'icon'			 => 'icon-question-sign',
					'icon_position'	 => 'right',
					'icon_color'	 => 'lightgray',
					'icon_size'		 => 'normal',
					'tip_style'		 => array(
						'color'		 => 'light',
						'shadow'	 => true,
						'rounded'	 => false,
						'style'		 => '',
					),
					'tip_position'	 => array(
						'my' => 'top left',
						'at' => 'bottom right',
					),
					'tip_effect'	 => array(
						'show'	 => array(
							'effect'	 => 'slide',
							'duration'	 => '500',
							'event'		 => 'mouseover',
						),
						'hide'	 => array(
							'effect'	 => 'slide',
							'duration'	 => '500',
							'event'		 => 'click mouseleave',
						),
					),
				)
			);

			// SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
			$this->args[ 'share_icons' ][]	 = array(
				'url'	 => 'https://www.facebook.com/BuddyBossWP',
				'title'	 => 'Like us on Facebook',
				'icon'	 => 'el-icon-facebook'
			);
			$this->args[ 'share_icons' ][]	 = array(
				'url'	 => 'https://twitter.com/buddybosswp',
				'title'	 => 'Follow us on Twitter',
				'icon'	 => 'el-icon-twitter'
			);
			$this->args[ 'share_icons' ][]	 = array(
				'url'	 => 'https://www.linkedin.com/company/buddyboss',
				'title'	 => 'Find us on LinkedIn',
				'icon'	 => 'el-icon-linkedin'
			);

			// Panel Intro text -> before the form
			if ( !isset( $this->args[ 'global_variable' ] ) || $this->args[ 'global_variable' ] !== false ) {
				if ( !empty( $this->args[ 'global_variable' ] ) ) {
					$v = $this->args[ 'global_variable' ];
				} else {
					$v = str_replace( '-', '_', $this->args[ 'opt_name' ] );
				}
				$this->args[ 'intro_text' ] = sprintf( __( '<p>To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'boss' ), $v );
			} else {
				$this->args[ 'intro_text' ] = __( '<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'boss' );
			}

			// Add content after the form.
			//$this->args[ 'footer_text' ] = __( '<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'boss' );
		}

	}

	global $reduxConfig;
	$reduxConfig = new boss_Redux_Framework_config();
}
