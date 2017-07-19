<?php
/**
  ReduxFramework Sample Config File
  For full documentation, please visit: https://docs.reduxframework.com
 * */
if (!class_exists('Redux_Framework_multinews_config')) {

            $opt_name = 'mom_options';

            if(defined('ICL_LANGUAGE_CODE')) {
                $lang = explode('-',ICL_LANGUAGE_CODE);
                     $lang = $lang[0];
                    if ($lang != '') {
                        $opt_name = 'mom_options_'.$lang;
                    }
            }

    class Redux_Framework_multinews_config {

        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }

            // This is needed. Bah WordPress bugs.  ;)
            if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }

        }

        public function initSettings() {

            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            // If Redux is running as a plugin, this will remove the demo notice and links
            add_action( 'redux/loaded', array( $this, 'remove_demo' ) );

            // Function to test the compiler hook and demo CSS output.
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 2);

            // Change the arguments after they've been declared, but before the panel is created
            //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );

            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );

            // Dynamically add a section. Can be also used to modify sections/fields
            //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        /**

          This is a test function that will let you see when the compiler hook occurs.
          It only runs if a field	set with compiler=>true is changed.

         * */
        function compiler_action($options, $css) {
            //echo '<h1>The compiler hook has run!';
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )

            /*
              // Demo of how to use the dynamic CSS and write your own static CSS file
              $filename = dirname(__FILE__) . '/style' . '.css';
              global $wp_filesystem;
              if( empty( $wp_filesystem ) ) {
                require_once( ABSPATH .'/wp-admin/includes/file.php' );
              WP_Filesystem();
              }

              if( $wp_filesystem ) {
                $wp_filesystem->put_contents(
                    $filename,
                    $css,
                    FS_CHMOD_FILE // predefined mode settings for WP files
                );
              }
             */
        }

        /**

          Custom function for filtering the sections array. Good for child themes to override or add to the sections.
          Simply include this function in the child themes functions.php file.

          NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
          so you must use get_template_directory_uri() if you want to use any of the built in icons

         * */
        function dynamic_section($sections) {
            //$sections = array();
            $sections[] = array(
                'title' => __('Section via hook', 'framework'),
                'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'framework'),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }

        /**

          Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.

         * */
        function change_arguments($args) {
            //$args['dev_mode'] = true;

            return $args;
        }

        /**

          Filter hook for filtering the default value of any given field. Very useful in development mode.

         * */
        function change_defaults($defaults) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {

            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
            }
        }

        /**
          * All the possible arguments for Redux.
          * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.
            global $opt_name;
            $this->args = array(
                'opt_name' => $opt_name,
                'page_slug' => 'momizat_options',
                'page_title' => 'Theme Options',
                'display_name'      => $theme->get('Name'),
                'display_version'   => $theme->get('Version'),
                'update_notice' => '0',
                'admin_bar' => '1',
                'menu_type' => 'menu',
                'menu_title' => 'Theme Options',
                'allow_sub_menu' => false,
                'customizer' => false,
                'google_api_key' => 'AIzaSyAiFUJAG-Vb7DOM1fTkpSAef52e2gPMSoo',
                'google_update_weekly' => false,
                'output' => '1',
                'output_tag' => '1',
                'page_icon' => 'icon-themes',
                'page_permissions' => 'manage_options',
                'save_defaults' => '1',
                'show_import_export' => '1',
                'transient_time' => '3600',
                'network_sites' => '1',
                'dev_mode' => '0',
                'page_priority' => null,
              );

            // Panel Intro text -> before the form
            if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
                if (!empty($this->args['global_variable'])) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace("-", "_", $this->args['opt_name']);
                }
                //$this->args['intro_text'] = sprintf(__('<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'theme'), $v);
            } else {
                //$this->args['intro_text'] = sprintf(__('<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'theme'), $v);
            }

            // Add content after the form.
            $this->args['footer_text'] = '';


        }

        public function setSections() {

            /**
              * Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $sample_patterns_path   = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url    = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns        = array();

            if (is_dir($sample_patterns_path)) :

                if ($sample_patterns_dir = opendir($sample_patterns_path)) :
                    $sample_patterns = array();

                    while (( $sample_patterns_file = readdir($sample_patterns_dir) ) !== false) {

                        if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                            $name = explode('.', $sample_patterns_file);
                            $name = str_replace('.' . end($name), '', $sample_patterns_file);
                            $sample_patterns[]  = array('alt' => $name, 'img' => $sample_patterns_url . $sample_patterns_file);
                        }
                    }
                endif;
            endif;

            ob_start();

            $ct             = wp_get_theme();
            $this->theme    = $ct;
            $item_name      = $this->theme->get('Name');
            $tags           = $this->theme->Tags;
            $screenshot     = $this->theme->get_screenshot();
            $class          = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'framework'), $this->theme->display('Name'));

            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                <?php endif; ?>

                <h4><?php echo $this->theme->display('Name'); ?></h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf(__('By %s', 'framework'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(__('Version %s', 'framework'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . __('Tags', 'framework') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>
            <?php
            if ($this->theme->parent()) {
                printf(' <p class="howto">' . __('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.') . '</p>', __('http://codex.wordpress.org/Child_Themes', 'framework'), $this->theme->parent()->display('Name'));
            }
            ?>

                </div>
            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();


            $imgpath = get_template_directory_uri() . '/framework/admin/images/';
			$themeimgpath = get_template_directory_uri() . '/images/';
			$imglaypath = MOM_URI . '/framework/metaboxes/img/';


            GLOBAL $mfonts;

           //var_dump($mfonts);

            // ACTUAL DECLARATION OF SECTIONS
            //Homepage settings
            $this->sections[] = array(
                'title' => __('Home page', 'framework'),
				'desc' => __('', 'framework'),
				'icon' => 'momizat-icon-home2',
			    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
				'fields' => array(
						array(
						'id'=>'hp-display',
						'type' => 'select',
						'title' => __('Default Homepage Display', 'framework'),
						'default' => 'blog',
						'options' => array(
								'blog' => __('Blog', 'framework'),
								'builder' => __('Build your home page', 'framework')
								),
						),
						array (
                            'id' => 'home_page_builder',
                            'type' => 'editor',
                            'title' => __('Build your home page', 'framework'),
                            'subtitle' => __('Video tutorial <a target="_blank" href="http://www.momizat.com/theme/goodnews/documentation/#tab-1402173051220-8-10">here</a>', 'framework'),
                            'args' => array(
                                'teeny' => false,
                                'drag_drop_upload' => true,
                                'textarea_rows' => 20,
                            ),
							'required' => array('hp-display', '=' , 'builder')
							),
						array(
						'id'=>'hp-blog-style',
						'type' => 'select',
						'title' => __('Default Homepage layout style', 'framework'),
						'default' => 'large',
						'options' => array(
								'def' => __('Default', 'framework'),
								'large' => __('Blog full width', 'framework')
								),
						'required' => array('hp-display', '=' , 'blog')
						),
						array(
						'id'=>'hp-blog-posts',
						'type' => 'slider',
						'title' => __('Number of posts in Home page', 'framework'),
						"default" => "5",
						"min" 	=> "-1",
						"step"	=> "1",
						"max" 	=> "50",
						'desc' => __('-1 for show all posts', 'framework'),
						'required' => array('hp-display', '=' , 'blog')
						),

						/*
                        array (
							'id' => 'uni_posts',
							'desc' => __('you can use this option if you want a unique posts when you create a home page', 'framework'),
							'type' => 'switch',
							'title' => __('Unique Posts', 'framework'),
							'default' => false,
							'on'        => __('Enable', 'framework'),
							'off'       => __('Disable', 'framework'),
							'required' => array('hp-display', '=' , 'builder')
						),
                        */
				)
			);

            $this->sections[] = array(
                'title' => __('General Settings', 'framework'),
				'desc' => __('', 'framework'),
				'icon' => 'momizat-icon-cogs',
			    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
				'fields' => array(
						array (
							'desc' => __('Select theme layout', 'framework'),
							'id' => 'main_layout',
							'type' => 'image_select',
							'options' => array (
									'right-sidebar' => array('img' => $imglaypath.'right_side.png'),
									'left-sidebar' => array('img' => $imglaypath.'left_side.png'),
									'both-sidebars-all' => array('img' => $imglaypath.'both.png'),
									'both-sidebars-right' => array('img' => $imglaypath.'both_right.png'),
									'both-sidebars-left' => array('img' => $imglaypath.'both_left.png'),
							),
							'title' => __('Theme layout', 'framework'),
							'default' => 'right-sidebar',
						),


						array (
							'desc' => __('Select theme Style', 'framework'),
							'id' => 'theme_layout',
							'type' => 'image_select',
							'options' => array (

									'' => array('img' => $imgpath.'full.png'),
									'boxed' => array('img' => $imgpath.'boxed.png'),
									'boxed2' => array('img' => $imgpath.'boxed2.png'),

							),
							'title' => __('Theme Style', 'framework'),
							'default' => 'boxed',
						),
						array (
							'id' => 'date_format',
							'desc' => __('Change date format click <a href="http://codex.wordpress.org/Formatting_Date_and_Time" target="_blank">here</a> to see how to change it', 'framework'),
							'type' => 'text',
							'title' => __('Date Format', 'framework'),
							'default' => 'F d, Y',
						),
						array (
							'id' => 'enable_responsive',
							'desc' => __('Enable or disable responsive', 'framework'),
							'type' => 'switch',
							'title' => __('Enable Responsive', 'framework'),
							'default' => true,
							'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),

                        array (
                            'id' => 'show_sidebar_on_ipad',
                            'desc' => __('by defualt it is hidden from on the ipad landscape', 'framework'),
                            'type' => 'switch',
                            'title' => __('Show secondary sidebar on ipad', 'framework'),
                            'default' => 0,
                            'on'     => __('Enable', 'framework'),
                            'off'    => __('Disable', 'framework'),
                            'required' => array('enable_responsive', '=' , 1)
                        ),

						array (
							'id' => 'breadcrumb',
							'desc' => __('Enable or disable breadcrumb If you disable this option will disable also pages icons', 'framework'),
							'type' => 'switch',
							'title' => __('Breadcrumb', 'framework'),
							'default' => true,
							'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),
                        array (
                            'id' => 'wpgallery_lightbox',
                            'desc' => __('Enable or disable Lightbox in Default Wordpress gallery', 'framework'),
                            'type' => 'switch',
                            'title' => __('Lightbox in WP gallery', 'framework'),
                            'default' => true,
                            'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
                        ),
                        array (
                            'id' => 'theme_thumb',
                            'desc' => __('if enable this the thumbnail image that will be cropped for the modules &amp; blocks. But if is not enabled the module will show a default placeholder with the size of the image, This option will generate a number of thumbnails, Please regenerate your thumbnails if you change any of the thumb settings', 'framework'),
                            'type' => 'switch',
                            'title' => __('Thumbs on modules &amp; blocks', 'framework'),
                            'default' => false,
                            'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
                        ),
						array (
							'id' => 'fade_imgs',
							'desc' => __('if enable this the images will fade in if it visible in viewport', 'framework'),
							'type' => 'switch',
							'title' => __('Fade in images', 'framework'),
							'default' => true,
							'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),
                        array (
							'id' => 'post_first_image',
							'desc' => __('if you enable this, the post automatically use the first image in the post as feature image, if you don\'t upload feature image', 'framework'),
							'type' => 'switch',
							'title' => __('Use first image as feature image', 'framework'),
							'default' => 0,
							'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),
						array (
							'id' => 'post_format_icons',
							'desc' => __('if enable this you will see the post format icons on posts in News boxes, Categories and blog', 'framework'),
							'type' => 'switch',
							'title' => __('Post format icons', 'framework'),
							'default' => true,
							'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),

                        array (
                            'id' => 'theme_cache',
                            'type' => 'switch',
                            'title' => __('Theme Cache System', 'framework'),
                            'default' => 1,
                            'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
                        ),

						array (
							'id' => 'post_default_img',
							'desc' => __('If you want set default feature image for posts that don\'t have one','framework'),
							'type' => 'switch',
							'title' => __('Default Feature Image', 'framework'),
							'default' => false,
						),

						array (
							'id' => 'custom_default_img',
							'type' => 'media',
							'title' => __('Custom Default Image', 'framework'),
                            'required' => array('post_default_img', '=' , 1),
							'subtitle' => __('Best size is 600x404', 'framework'),
							'url' => true,
						),
                        array (
                            'id' => 'mom_og_tags',
                            'type' => 'switch',
                            'title' => __('Facebook open graph tag', 'framework'),
                            'subtitle' => __('You need to disable this if use any SEO plugin for delete duplicate "og" tags', 'framework'),
                            'default' => 1,
                            'on'        => __('Enable', 'framework'),
                            'off'       => __('Disable', 'framework')
                        ),
                        array (
                            'id' => 'automatic_weather',
                            'desc' => __('Auto detect visitor city and display weather from it', 'framework'),
                            'type' => 'switch',
                            'title' => __('Automatic Weather', 'framework'),
                            'default' => false,
                            'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
                        ),

                        array (
                            'id' => 'nicescroll',
                            'type' => 'switch',
                            'title' => __('Smooth scrolling', 'framework'),
                            'desc' => __('Enable/disable smooth scrolling', 'framework'),
                            'default' => 0,
                            'on'        => __('Enable', 'framework'),
                            'off'       => __('Disable', 'framework')
                        ),

                        array (
                            'id' => 'redirect_login;',
                            'type' => 'switch',
                            'title' => __('Redirect Login if fail to same page instead of wodpress admin', 'framework'),
                            'desc' => __('you need to disable this if you use any ajax login plugin like userpro', 'framework'),
                            'default' => 0,
                            'on'        => __('Yes', 'framework'),
                            'off'       => __('No', 'framework')
                        ),

						array (
							'id' => 'scroll_top_bt',
							'desc' =>  __('Enable or disable Scroll to top button', 'framework'),
							'type' => 'switch',
							'title' => __('Scroll to top button', 'framework'),
							'default' => true,
							'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),
						array (
							'desc' => __('upload your favicon','framework'),
							'id' => 'custom_favicon',
							'type' => 'media',
							'title' => __('favicon', 'framework'),
							'url' => true,
						),
						array (
							'id' => 'apple_touch_icon',
							'type' => 'media',
							'title' => __('This icon used for iOS system if user add your site to home page, size must be 152x152', 'framework'),
							'url' => true,
						),
                        array (
                            'desc' => __('We not recommend adding scripts in header for page speed purpose, but if you need to do this add your scripts here', 'framework'),
                            'id' => 'header_script',
                            'type' => 'textarea',
                            'title' => __('Header scripts', 'framework'),
                        ),
						array (
							'desc' => __('it can be google analytics or any Script code, it will be add before closing of body tag', 'framework'),
							'id' => 'footer_script',
							'type' => 'textarea',
							'title' => __('Footer scripts', 'framework'),
						),
				)
            );
            //social icons settings
            $this->sections[] = array(
                'title' => __('Layout settings', 'framework'),
                'desc' => __('', 'framework'),
                'icon' => 'dashicons dashicons-feedback',
                'subsection' => true,
                'fields' => array(

                        array(
                            'id' => 'layout_bothsidebars_notice',
                            'type' => 'info',
                            'notice' => true,
                            'style' => 'critical',
                            'title' => __('Both sidebars layout'),
                        ),
                        array (
                            'id' => 'bsd_container_width',
                            'type' => 'text',
                            'placeholder' => '1200px',
                            'title' => __('Container Width', 'framework'),
                            'subtitle' => __(' this width will apply on both sidebars pages and full width pages', 'framework'),
                        ),
                        array (
                            'id' => 'bsd_main_content_width',
                            'type' => 'text',
                            'placeholder' => '50%',
                            'title' => __('Content Width', 'framework'),
                        ),
                        array (
                            'id' => 'bsd_main_sidebar_width',
                            'type' => 'text',
                            'placeholder' => '31%',
                            'title' => __('Main Sidebar Width', 'framework'),
                        ),

                        array (
                            'id' => 'bsd_sec_sidebar_width',
                            'type' => 'text',
                            'placeholder' => '17%',
                            'title' => __('Secondary Sidebar Width', 'framework'),
                        ),

                        array (
                            'id' => 'bsd_margins',
                            'type' => 'text',
                            'placeholder' => '1%',
                            'title' => __('Margins', 'framework'),
                            'subtitle' => __('Spaces between columns, in this case it will applied to main sidebar and secondary sidebar only', 'framework'),

                        ),

                        array(
                            'id' => 'layout_onesidebar_notice',
                            'type' => 'info',
                            'notice' => true,
                            'style' => 'critical',
                            'title' => __('One sidebar layout'),
                        ),
                        array (
                            'id' => 'osd_container_width',
                            'type' => 'text',
                            'placeholder' => '1200px',
                            'title' => __('Container Width', 'framework'),
                        ),
                        array (
                            'id' => 'osd_main_content_width',
                            'type' => 'text',
                            'placeholder' => '68%',
                            'title' => __('Content Width', 'framework'),
                        ),
                        array (
                            'id' => 'osd_main_sidebar_width',
                            'type' => 'text',
                            'placeholder' => '31%',
                            'title' => __('Main Sidebar Width', 'framework'),
                        ),
                        array (
                            'id' => 'osd_margins',
                            'type' => 'info',
                            'placeholder' => '1%',
                            'title' => __('Margins', 'framework'),
                            'subtitle' => __('Margins will be the difference between the content and main sidebar', 'framework'),

                        ),


                )
            );



            //social icons settings
            $this->sections[] = array(
                'title' => __('Social Icons', 'framework'),
				'desc' => __('', 'framework'),
				'icon' => 'momizat-icon-twitter',
				'subsection' => true,
			    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
				'fields' => array(
						array(
						'id'=>'header_social',
						'type' => 'switch',
						'title' => __('Disable Top Header Social icons', 'framework'),
						"default" 		=> 1,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),
						array(
						'id'=>'footer_social',
						'type' => 'switch',
						'title' => __('Disable Footer Social icons', 'framework'),
						"default" 		=> 1,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),
						array(
						'id'=>'hs_facebook',
						'type' => 'text',
						'title' => __('Facebook', 'framework'),
						"default" => '#',
						),
						array(
						'id'=>'hs_twitter',
						'type' => 'text',
						'title' => __('Twitter', 'framework'),
						"default" => '#',
						),
						array(
						'id'=>'hs_youtube',
						'type' => 'text',
						'title' => __('Youtube', 'framework'),
						"default" => '#',
						),
						array(
						'id'=>'hs_google',
						'type' => 'text',
						'title' => __('Google', 'framework'),
						"default" => '#',
						),
						array(
						'id'=>'hs_pin',
						'type' => 'text',
						'title' => __('Pinterest', 'framework'),
						"default" => '#',
						),
						array(
						'id'=>'hs_vimeo',
						'type' => 'text',
						'title' => __('Vimeo', 'framework'),
						"default" => '#',
						),
						array (
							'id' => 'rss_on_off',
							'type' => 'checkbox',
							'title' => 'RSS',
						),
						array(
						'id'=>'hs_rss',
						'type' => 'text',
						'title' => __('Custom RSS URL', 'framework'),
						'desc' => __('leave empty to use default rss link', 'framework'),
						"default" => '#',
						),
						array(
						'id'=>'custom_social_icons',
						'type' => 'sicons',
						'title' => __('Custom Social Icons', 'framework'),
						'placeholder' => array(
		                        'title' => __('Icon name', 'framework'),
		                        'url' => __('Icon URL', 'framework'),
		                    ),
						),
				)
            );


			//posts settings
            $this->sections[] = array(
                'title' => __('Post Settings', 'framework'),
				'desc' => __('', 'framework'),
				'icon' => 'momizat-icon-newspaper',
				'subsection' => true,
			    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
				'fields' => array(
                        array (
                            'desc' => __('none mean it will take the theme layout', 'framework'),
                            'id' => 'post_page_layout',
                            'type' => 'image_select',
                            'options' => array (
                                    '' => array('img' => $imglaypath.'none.png'),
                                    'right-sidebar' => array('img' => $imglaypath.'right_side.png'),
                                    'left-sidebar' => array('img' => $imglaypath.'left_side.png'),
                                    'both-sidebars-all' => array('img' => $imglaypath.'both.png'),
                                    'both-sidebars-right' => array('img' => $imglaypath.'both_right.png'),
                                    'both-sidebars-left' => array('img' => $imglaypath.'both_left.png'),
                                    'fullwidth' => array('img' => $imglaypath.'no_side.png'),
                            ),
                            'title' => __('Posts layout', 'framework'),
                            'default' => '',
                        ),

						array (
							'desc' => __('Select Post page layout', 'framework'),
							'id' => 'post_layout',
							'type' => 'image_select',
							'options' => array (
                                    'none' => array('img' => $imglaypath.'none.png'),
									'default' => array('img' => $imglaypath.'post.png'),
									'layout1' => array('img' => $imglaypath.'post1.png'),
									'layout2' => array('img' => $imglaypath.'post2.png'),
									'layout3' => array('img' => $imglaypath.'post3.png'),
									'layout4' => array('img' => $imglaypath.'post4.png'),
									'layout5' => array('img' => $imglaypath.'post5.png'),
							),
							'title' => __('Post layout', 'framework'),
							'default' => 'default',
						),
						array(
						'id'=>'post_layout_default_img',
						'type' => 'select',
						'title' => __('Default post layout image on click', 'framework'),
							'default' => 'expand',
						'options' => array (
								'expand' => __('Expand','framework'),
								'zoom' => __('zoom','framework'),
						),
						//'required' => array('post_layout', '=' , 'default'),
						),

						array(
						'id'=>'post_bread',
						'type' => 'switch',
						'title' => __('Post breadcrumb', 'framework'),
						"default" 		=> 1,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),

						array(
						'id'=>'post_icon',
						'type' => 'switch',
						'title' => __('Post Icon', 'framework'),
						"default" 		=> 1,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework'),
                        'required' => array('post_bread', '=' , 1),
						),

						array(
						'id'=>'post_fimage',
						'type' => 'switch',
						'title' => __('Feature area', 'framework'),
						'desc' => __('Enable or Disable feature image and story highlights in posts', 'framework'),
						"default" 		=> 1,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),
						array(
						'id'=>'post_feaimage',
						'type' => 'switch',
						'title' => __('Feature image', 'framework'),
						'desc' => __('Enable or Disable feature image in posts', 'framework'),
						"default" 		=> 1,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework'),
                        'required' => array('post_fimage', '=' , 1),
						),
						array(
						'id'=>'post_story',
						'type' => 'switch',
						'title' => __('Story highlights', 'framework'),
						'desc' => __('Enable or Disable story highlights in posts', 'framework'),
						"default" 		=> 1,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework'),
                        'required' => array('post_fimage', '=' , 1),
						),
						array(
						'id'=>'post_tags',
						'type' => 'switch',
						'title' => __('Post tags', 'framework'),
						"default" 		=> 1,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),

						array(
						'id'=>'post_nav',
						'type' => 'switch',
						'title' => __('posts nav link', 'framework'),
						'desc' => __('Enable or Disable next and previous links in posts', 'framework'),
						"default" 		=> 1,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),

						array(
						'id'=>'post_author',
						'type' => 'switch',
						'title' => __('author box', 'framework'),
						"default" 		=> 1,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),

						array(
						'id'=>'post_comments',
						'type' => 'switch',
						'title' => __('post comments', 'framework'),
						"default" 		=> 1,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),

                        array(
                        'id'=>'post_autoplay_video_posts',
                        'type' => 'switch',
                        'title' => __('Auto play video posts', 'framework'),
                        "default"       => 0,
                        'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
                        ),

                        array(
                        'id'=>'post_images_in_lightbox',
                        'type' => 'switch',
                        'title' => __('Open all images with Lightbox', 'framework'),
                        "default"       => 0,
                        'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
                        ),

		                array(
			                'id' => 'notice_critical222',
			                'type' => 'info',
			                'notice' => true,
			                'style' => 'critical',
			                'icon' => 'momizat-icon-pencil2',
			                'title' => __('Post Meta', 'framework'),
			                'desc' => __('post meta options', 'framework')
			            ),
			            array(
						'id'=>'post_meta_hp',
						'type' => 'switch',
						'title' => __('Apply post meta settings in all pages', 'framework'),
						"default" 		=> 0,
                                                'desc' => __('If you activate this option, the following options will be applied on all pages and widgets', 'framework'),
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework'),
						),
			            array(
						'id'=>'post_head',
						'type' => 'switch',
						'title' => __('Post Meta', 'framework'),
						"default" 		=> 1,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),
						array(
						'id'=>'post_head_author',
						'type' => 'switch',
						'title' => __('by author', 'framework'),
						"default" 		=> 1,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),
						array(
						'id'=>'post_head_date',
						'type' => 'switch',
						'title' => __('Date', 'framework'),
						"default" 		=> 1,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),
						array(
						'id'=>'post_head_cat',
						'type' => 'switch',
						'title' => __('in category', 'framework'),
						"default" 		=> 1,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),
						array(
						'id'=>'post_head_commetns',
						'type' => 'switch',
						'title' => __('comments number', 'framework'),
						"default" 		=> 1,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),
						array(
						'id'=>'post_head_views',
						'type' => 'switch',
						'title' => __('views number', 'framework'),
						"default" 		=> 1,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),
                        array(
                        'id'=>'post_views_ajax',
                        'type' => 'switch',
                        'title' => __('Count post views with Ajax', 'framework'),
                        'subtitle' => __('This is very useful if you use a cache plugin', 'framework'),
                        "default"       => 1,
                        'on'        => __('Yes', 'framework'),
                        'off'       => __('No', 'framework')
                        ),
                        array (
                            'title' => __('Count Views by', 'framework'),
                            'id' => 'views_by',
                            'type' => 'radio',
                            'options' => array (
                                    '' => __('Theme views function', 'framework'),
                                    'jetpack' => __('Jetpack plugin (if installed and enable wp stats)', 'framework'),
                                    'wpv' => __('WP-Postviews plugin (if installed)', 'framework'),
                            ),
                            'required' => array('post_head_views', '=' , 1),
                            'default' => '',
                        ),
						array(
			                'id' => 'notice_critical2qq',
			                'type' => 'info',
			                'notice' => true,
			                'style' => 'critical',
			                'icon' => 'momizat-icon-loop',
			                'title' => __('Posts Share', 'framework'),
			                'desc' => __('Posts Share Options', 'framework')
			            ),
						array(
						'id'=>'post_sharee',
						'type' => 'switch',
						'title' => __('post share', 'framework'),
						"default" 		=> 1,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),
                        array (
                        'id' => 'share_position',
                        'type' => 'radio',
                        'options' => array (
                            'top' => 'Top',
                            'bottom' => 'Bottom',
                            'both' => 'Both',
                        ),
                        'title' => 'Post share position',
                        'default' => 'bottom',
                        'required' => array('post_sharee', '=' , 1),
                        ),
						array(
						'id'=>'sharee_fb',
						'type' => 'switch',
						'title' => __('Facebook share', 'framework'),
						"default" 		=> 1,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework'),
                        'required' => array('post_sharee', '=' , 1),
						),
/*
                        array(
                            'id'        => 'post_share_facebook_count',
                            'type'      => 'radio',
                            'title'     => __('Facebook Count', 'framework'),
                            'required'  => array('post_share_facebook', '=', 1),
                            'default'   => 'share',
                            'options'   => array(
                              'share' => __('Share Count', 'framework'),
                              'like' => __('Like Count', 'framework'),
                              'both' => __('Share + like', 'framework'),
                            ),
                            'required' => array('sharee_fb', '=' , 1),
                        ),
                        */
						array(
						'id'=>'sharee_tw',
						'type' => 'switch',
						'title' => __('Twitter share', 'framework'),
						"default" 		=> 1,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework'),
                        'required' => array('post_sharee', '=' , 1),
						),
						array(
						'id'=>'sharee_go',
						'type' => 'switch',
						'title' => __('Google share', 'framework'),
						"default" 		=> 1,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework'),
                        'required' => array('post_sharee', '=' , 1),
						),
						array(
						'id'=>'sharee_lin',
						'type' => 'switch',
						'title' => __('Linkedin share', 'framework'),
						"default" 		=> 1,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework'),
                        'required' => array('post_sharee', '=' , 1),
						),
						array(
						'id'=>'sharee_pin',
						'type' => 'switch',
						'title' => __('Pinterest share', 'framework'),
						"default" 		=> 1,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework'),
                        'required' => array('post_sharee', '=' , 1),
						),
						array(
						'id'=>'sharee_vk',
						'type' => 'switch',
						'title' => __('Vk share', 'framework'),
						"default" 		=> 1,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework'),
                        'required' => array('post_sharee', '=' , 1),
						),
						array(
						'id'=>'sharee_xing',
						'type' => 'switch',
						'title' => __('Xing share', 'framework'),
						"default" 		=> 1,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework'),
                        'required' => array('post_sharee', '=' , 1),
						),
						array(
						'id'=>'sharee_mail',
						'type' => 'switch',
						'title' => __('Disable Mailto', 'framework'),
						"default" 		=> 1,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework'),
                        'required' => array('post_sharee', '=' , 1),
						),
						array(
						'id'=>'sharee_print',
						'type' => 'switch',
						'title' => __('Print icon', 'framework'),
						"default" 		=> 1,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework'),
                        'required' => array('post_sharee', '=' , 1),
						),
		                array(
			                'id' => 'notice_critical2',
			                'type' => 'info',
			                'notice' => true,
			                'style' => 'critical',
			                'icon' => 'momizat-icon-loop',
			                'title' => __('Related Posts', 'framework'),
			                'desc' => __('Related Posts Options', 'framework')
			            ),

						array(
						'id'=>'post_related',
						'type' => 'switch',
						'title' => __('Related Posts', 'framework'),
						"default" 		=> 1,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),

						array(
						'id'=>'related_type',
						'type' => 'select',
						'title' => __('Related Posts Display by:', 'framework'),
						'default' => 'cat',
						'options' => array(
								'tag' => __('Tags', 'framework'),
								'cat' => __('Category', 'framework')
								),
						'required' => array('post_related', '=' , 1),
						),

						array(
						'id'=>'related_count',
						'type' => 'slider',
						'title' => __('Number of posts', 'framework'),
						"default" => "3",
						"min" 	=> "1",
						"step"	=> "1",
						"max" 	=> "50",
						'required' => array('post_related', '=' , 1),
						),

                    array(
                        'id'        => 'post-ads-info',
                        'type'      => 'info',
			'notice' => true,
			'style' => 'critical',
			'icon' => 'momizat-icon-thumbs-up',
                        'title'      => __('Post Ads', 'framework'),
			'desc' => __('ads inside the posts', 'framework')

                    ),

				array (
					'id' => 'post_top_ad',
					'type' => 'select',
					'data' => 'posts',
					'args' => array('post_type' => 'ads', 'posts_per_page' => -1, 'no_found_rows' => true, 'cache_results' => false),
    					'title' => __('Content top ad', 'framework'),
    					'subtitle' => __('this will be before the post content', 'framework'),
				),

				array (
					'id' => 'post_bottom_content_ad',
					'type' => 'select',
					'data' => 'posts',
					'args' => array('post_type' => 'ads', 'posts_per_page' => -1, 'no_found_rows' => true, 'cache_results' => false),
    					'title' => __('Content bottom ad', 'framework'),
				),

				array (
					'id' => 'post_bottom_ad',
					'type' => 'select',
					'data' => 'posts',
					'args' => array('post_type' => 'ads', 'posts_per_page' => -1, 'no_found_rows' => true, 'cache_results' => false),
    					'title' => __('Bottom ad', 'framework'),
    					'subtitle' => __('this will be after the comments', 'framework'),
				),



				)
            );

            $this->sections[] = array(
                'title' => __('Page settings', 'framework'),
                'desc' => __('', 'framework'),
                'icon' => 'momizat-icon-file',
                'subsection' => true,
                'fields' => array(
                        array (
                            'title' => __('Pages layout', 'framework'),
                            'desc' => __('None mean use the theme layout option', 'framework'),
                            'id' => 'page_layout',
                            'type' => 'image_select',
                            'options' => array (
                                    '' => array('img' => $imglaypath.'none.png'),
                                    'right-sidebar' => array('img' => $imglaypath.'right_side.png'),
                                    'left-sidebar' => array('img' => $imglaypath.'left_side.png'),
                                    'both-sidebars-all' => array('img' => $imglaypath.'both.png'),
                                    'both-sidebars-right' => array('img' => $imglaypath.'both_right.png'),
                                    'both-sidebars-left' => array('img' => $imglaypath.'both_left.png'),
                                    'fullwidth' => array('img' => $imglaypath.'no_side.png'),
                            ),
                            'default' => 'right-sidebar',
                        ),
                )
            );



			//category settings
            $this->sections[] = array(
                'title' => __('Category Settings', 'framework'),
				'desc' => __('', 'framework'),
				'icon' => 'momizat-icon-folder-open',
				'subsection' => true,
			    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
				'fields' => array(
						array (
							'desc' => __('Select category default layout, by select none category layout will be the default layout', 'framework'),
							'id' => 'category_layout',
							'type' => 'image_select',
							'options' => array (
									'' => array('img' => $imglaypath.'none.png'),
									'right-sidebar' => array('img' => $imglaypath.'right_side.png'),
									'left-sidebar' => array('img' => $imglaypath.'left_side.png'),
									'both-sidebars-all' => array('img' => $imglaypath.'both.png'),
									'both-sidebars-right' => array('img' => $imglaypath.'both_right.png'),
									'both-sidebars-left' => array('img' => $imglaypath.'both_left.png'),
									'fullwidth' => array('img' => $imglaypath.'full.png'),
							),
							'title' => __('Category layout', 'framework'),
							'default' => '',
						),

						array(
							'id'=>'cats_bread',
							'type' => 'switch',
							'title' => __('Disable Breadcrumb', 'framework'),
							"default" 		=> 1,
							'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),
						array (
							'id' => 'cat_rss',
							'desc' => __('Enable or disable Category RSS icon', 'framework'),
							'type' => 'switch',
							'title' => __('Enable RSS Icon', 'framework'),
							'default' => true,
							'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),
						array (
							'id' => 'cat_slider',
							'type' => 'switch',
							'title' => __('Enable Category Slider', 'framework'),
							'default' => true,
							'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),

						                    array(
                        'id'            => 'cat_slider_timeout',
                        'type'          => 'slider',
                        'required'  => array('cat_slider', '=', '1'),
                        'title'         => __('Timeout', 'framework'),
                        'default'       => 4000,
                        'min'           => 1000,
                        'subtitle'          => __('time between each slide with ms', 'framework'),
                        'step'          => 500,
                        'max'           => 10000,
                        'display_value' => 'input'
                    ),
						array(
						'id'=>'cat_slider_display',
						'type' => 'select',
						'title' => __('Slider Posts Order by', 'framework'),
						'default' => 'rand',
						'required' => array('cat_slider', '=' , 1),
						'options' => array(
								'rand' => __('Random', 'framework'),
								'date' => __('Latest Posts', 'framework'),
								'modified'=> __('Last Modified', 'framework'),
								'name'=> __('Post Name', 'framework'),
								),
						),
						array (
							'id' => 'cat_slider_mpop',
							'type' => 'switch',
							'title' => __('Enable Most popular in slider', 'framework'),
							'default' => true,
							'required' => array('cat_slider', '=' , 1),
							'on'        => __('Enable', 'framework'),
							'off'       => __('Disable', 'framework')
						),
						array (
							'id' => 'cat_desc',
							'type' => 'switch',
							'title' => __('Enable Category Description', 'framework'),
							'default' => false,
							'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),
						array(
						'id'=>'cat_posts_layout',
						'type' => 'select',
						'title' => __('Category posts layout', 'framework'),
						'default' => 'def',
						'options' => array(
								'def' => __('Default layout (with switcher)', 'framework'),
								'blog' => __('Blog layout', 'framework')
								),
						),
						array(
						'id'=>'cat_posts_layout_style',
						'type' => 'select',
						'title' => __('Category posts layout style', 'framework'),
						'default' => 'def',
						'required' => array('cat_posts_layout', '=' , 'blog'),
						'options' => array(
								'' => __('Default style', 'framework'),
								'large' => __('Big Style', 'framework')
								),
						),
						array (
							'id' => 'cat_swi',
							'type' => 'switch',
							'title' => __('Enable Category Switcher', 'framework'),
							'default' => true,
							'required' => array('cat_posts_layout', '=' , 'def'),
							'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),
						array(
						'id'=>'cat_swi_def',
						'type' => 'select',
						'title' => __('Default:', 'framework'),
						'default' => 'grid',
						'options' => array(
								'grid' => __('Grid', 'framework'),
								'list' => __('List', 'framework')
								),
						'required' => array('cat_swi', '=' , 0),
						),
						array(
						'id'=>'cat_hp_color',
						'type' => 'switch',
						'title' => __('Category color in Home page', 'framework'),
						'desc' => __('Enable or Disable Category color in news boxes', 'framework'),
						"default" 		=> 0,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),

                    array(
                        'id'        => 'category-ads-info',
                        'type'      => 'info',
                        'title'      => __('Ads', 'theme'),
                        'desc' => __('this will be display between category posts', 'theme'),
                    ),
                array (
                    'id' => 'cat_ad_id',
                    'type' => 'select',
                    'data' => 'posts',
                    'args' => array('post_type' => 'ads', 'posts_per_page' => -1, 'no_found_rows' => true, 'cache_results' => false),
                        'title' => __('Select Ad:', 'theme'),
                ),
                array (
                    'id' => 'cat_ad_count',
                    'type' => 'text',
                    'default' => 3,
                        'title' => __('Display after x posts', 'theme'),
                        'desc' => __('the number of posts to display ads after it. default is 3', 'theme'),
                ),
                array (
                    'id' => 'cat_ad_repeat',
                    'type' => 'switch',
                    'default' => 0,
                    'on'        => 'Yes',
                    'off'       => 'No',
                        'title' => __('Repeat ad', 'theme'),
                        'desc' => __('display the ad again after x posts', 'theme'),
                ),


				)
            );

            //Archives Settings
            $this->sections[] = array(
                'title' => __('Archives page Settings', 'framework'),
				'desc' => __('', 'framework'),
				'icon' => 'momizat-icon-cabinet',
				'subsection' => true,
			    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
				'fields' => array(

					array(
						'id'=>'archives_bread',
						'type' => 'switch',
						'title' => __('Disable Breadcrumb', 'framework'),
						"default" 		=> 1,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),
				        array(
						'id'=>'archives_icon',
						'type' => 'switch',
						'title' => __('Disable Archive Icon', 'framework'),
						"default" 		=> 1,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),
						array (
							'id' => 'archive_swi',
							'type' => 'switch',
							'title' => __('Enable Archives Switcher', 'framework'),
							'default' => true,
							'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),
						array(
						'id'=>'archive_swi_def',
						'type' => 'select',
						'title' => __('Default:', 'framework'),
						'default' => 'grid',
						'options' => array(
								'grid' => __('Grid', 'framework'),
								'list' => __('List', 'framework')
								),
						'required' => array('archive_swi', '=' , 0),
						),

				)
			);

			//Author page
			$this->sections[] = array(
			'icon' => 'momizat-icon-user3',
			'title' => __('Author Page Settings', 'framework'),
			'subsection' => true,
			'fields' => array(
						array (
							'desc' => __('Upload Default author cover to appears inside author page','framework'),
							'id' => 'custom_author_cover',
							'type' => 'media',
							'title' => __('Default author cover', 'framework'),
							'url' => true,
							'default'=>array('url'=> $themeimgpath.'cover.png'),
						),
						array (
							'id' => 'email-author-box',
							'desc' => __('Enable / disable email icon from author box and author page', 'framework'),
							'type' => 'switch',
							'title' => __('Author Email icon', 'framework'),
							'default' => true,
							'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),
						array(
						'id'=>'author_post_counter',
						'type' => 'slider',
						'title' => __('Posts per page', 'framework'),
						"default" => "10",
						"min" 	=> "1",
						"step"	=> "1",
						"max" 	=> "50",
						),
					)
			);

			//Search page
            $this->sections[] = array(
                'title' => __('Search page Settings', 'framework'),
				'desc' => __('', 'framework'),
				'icon' => 'momizat-icon-search',
				'subsection' => true,
			    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
				'fields' => array(
						array(
						'id'=>'search_bread',
						'type' => 'switch',
						'title' => __('Disable Breadcrumb', 'framework'),
						"default" 		=> 1,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),

						array(
						'id'=>'adv_search',
						'type' => 'switch',
						'title' => __('Disable Advanced Search', 'framework'),
						"default" 		=> 1,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),

						array(
						'id'=>'search_sort',
						'type' => 'switch',
						'title' => __('Disable Sort by', 'framework'),
						"default" 		=> 1,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),

						array(
						'id'=>'search_count',
						'type' => 'slider',
						'title' => __('Posts per page', 'framework'),
						"default" => "9",
						"min" 	=> "1",
						"step"	=> "1",
						"max" 	=> "50",
						),

						array(
						'id'=>'search_page_ex',
						'type' => 'switch',
						'title' => __('Exclude Pages in results', 'framework'),
						"default" 		=> 0,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),

						array(
						'id'=>'search_cat_ex',
						'type' => 'text',
						'title' => __('Exclude Categories in results', 'framework'),
						"default" 		=> '',
						'desc' => __('Category IDs need to have a “minus” sign and "," to get excluded ex: -2,-12', 'framework'),
						),
				)
            );

            //sidebars settings
            $this->sections[] = array(
                'title' => __('Sidebars Settings', 'framework'),
				'desc' => __('', 'framework'),
				'icon' => 'momizat-icon-pause2',
				'subsection' => true,
			    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
				'fields' => array(
                        array (
                            'id' => 'swstyle',
                            'title' => __('Sidebars widgets style', 'framework'),
                            'type' => 'image_select',
                            'options' => array (
                                    'def' => array('img' => $imgpath.'s1.png'),
                                    'style2' => array('img' => $imgpath.'s2.png'),
                            ),
                        ),
                        array (
                            'id' => 'post_cat_sidebar',
                            'title' => __('Force custom category sidebar for posts', 'framework'),
                            'desc' => __('this option make each custom category sidebar dispaly in any post under it unless you select custom sidebar for this post itself', 'framework'),
                            'type' => 'switch',
                        ),

						array(
		                    'id' => 'hp_rsidebar',
		                    'type' => 'select',
		                    'data' => 'sidebar',
		                    'title' => __('Homepage sidebar', 'framework'),
		                    'subtitle' => __('Select Main sidebar for homepage', 'framework'),
		                ),
		                array(
		                    'id' => 'hp_lsidebar',
		                    'type' => 'select',
		                    'data' => 'sidebar',
		                    'title' => __('Homepage secondary sidebar', 'framework'),
		                    'subtitle' => __('Select Secondary sidebar for homepage', 'framework'),
		                ),
		                array(
		                    'id' => 'cat_rsidebar',
		                    'type' => 'select',
		                    'data' => 'sidebar',
		                    'title' => __('Categories sidebar', 'framework'),
		                    'subtitle' => __('Select Main sidebar for Categories', 'framework'),
		                ),
		                array(
		                    'id' => 'cat_lsidebar',
		                    'type' => 'select',
		                    'data' => 'sidebar',
		                    'title' => __('Categories secondary sidebar', 'framework'),
		                    'subtitle' => __('Select Secondary sidebar for Categories', 'framework'),
		                ),
		                array(
		                    'id' => 'post_rsidebar',
		                    'type' => 'select',
		                    'data' => 'sidebar',
		                    'title' => __('Posts sidebar', 'framework'),
		                    'subtitle' => __('Select Main sidebar for Posts', 'framework'),
		                ),
		                array(
		                    'id' => 'post_lsidebar',
		                    'type' => 'select',
		                    'data' => 'sidebar',
		                    'title' => __('Posts secondary sidebar', 'framework'),
		                    'subtitle' => __('Select Secondary sidebar for Posts', 'framework'),
		                ),
		                array(
		                    'id' => 'page_rsidebar',
		                    'type' => 'select',
		                    'data' => 'sidebar',
		                    'title' => __('pages sidebar', 'framework'),
		                    'subtitle' => __('Select Main sidebar for pages', 'framework'),
		                ),
		                array(
		                    'id' => 'page_lsidebar',
		                    'type' => 'select',
		                    'data' => 'sidebar',
		                    'title' => __('pages secondary sidebar', 'framework'),
		                    'subtitle' => __('Select Secondary sidebar for pages', 'framework'),
		                ),
		                array(
		                    'id' => 'archive_rsidebar',
		                    'type' => 'select',
		                    'data' => 'sidebar',
		                    'title' => __('Archive sidebar', 'framework'),
		                    'subtitle' => __('Select Main sidebar for Archive', 'framework'),
		                ),
		                array(
		                    'id' => 'archive_lsidebar',
		                    'type' => 'select',
		                    'data' => 'sidebar',
		                    'title' => __('Archive secondary sidebar', 'framework'),
		                    'subtitle' => __('Select Secondary sidebar for Archive', 'framework'),
		                ),

		                array(
		                    'id' => 'woo_rsidebar',
		                    'type' => 'select',
		                    'data' => 'sidebar',
		                    'title' => __('Woocommerce sidebar', 'framework'),
		                    'subtitle' => __('Select Main sidebar for Woocommerce', 'framework'),
		                ),
		                array(
		                    'id' => 'woo_lsidebar',
		                    'type' => 'select',
		                    'data' => 'sidebar',
		                    'title' => __('Woocommerce secondary sidebar', 'framework'),
		                    'subtitle' => __('Select Secondary sidebar for Woocommerce', 'framework'),
		                ),

		                array(
		                    'id' => 'info_warning',
		                    'type' => 'info',
		                    'style' => 'warning',
		                    'title' => __('To Add unlimited sidebars.', 'framework'),
		                    'desc' => __('go to Appearance > Unlimited Sidebars and click on +add sidebar', 'framework')
		                ),
				)
            );

            //Image sizes
            $this->sections[] = array(
                'title' => __('Thumbnails Size', 'framework'),
                'desc' => __('You can use this settings to change the Thumbnails ratio but you need to follow this steps for best results: <ol><li>Don\'t change the width just the height</li><li>If you want remove image size just change the dimension for it to be the same as another size the wordpress will consider the both sizes as one</li><li>Use <a href="http://andrew.hedges.name/experiments/aspect_ratio/" target="_blank">This Tool</a> to calculate the ratio </li><li>If you make any changes here you need to <a href="http://wordpress.org/plugins/regenerate-thumbnails/" target="_blank">Regenerate your thumbnails</a></li></ol>', 'framework'),
                'icon' => 'momizat-icon-image',
                'subsection' => true,
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields' => array(
                    array(
                        'id'        => 'scroller-thumb',
                        'type'      => 'dimensions',
                        'title'      => __('Scroller', 'framework'),
                        'default' => array(
                                'width' => '274',
                                'height' => '183'
                            )
                    ),

                    array(
                        'id'        => 'nb1-thumb',
                        'type'      => 'dimensions',
                        'title'      => __('News box 1', 'framework'),
                        'default' => array(
                                'width' => '364',
                                'height' => '245'
                            )
                    ),

                    array(
                        'id'        => 'nb3-thumb',
                        'type'      => 'dimensions',
                        'title'      => __('News box 3', 'framework'),
                        'default' => array(
                                'width' => '80',
                                'height' => '54'
                            )
                    ),

                    array(
                        'id'        => 'nb5-thumb',
                        'type'      => 'dimensions',
                        'title'      => __('News box 5', 'framework'),
                        'default' => array(
                                'width' => '130',
                                'height' => '87'
                            )
                    ),


                    array(
                        'id'        => 'npic-thumb',
                        'type'      => 'dimensions',
                        'title'      => __('News in pics Big image', 'framework'),
                        'default' => array(
                                'width' => '359',
                                'height' => '240'
                            )
                    ),

                    array(
                        'id'        => 'np-thumb',
                        'type'      => 'dimensions',
                        'title'      => __('News in pics', 'framework'),
                        'default' => array(
                                'width' => '85',
                                'height' => '57'
                            )
                    ),

                    array(
                        'id'        => 'slider-thumb',
                        'type'      => 'dimensions',
                        'title'      => __('Slider Image', 'framework'),
                        'default' => array(
                                'width' => '546',
                                'height' => '365'
                            )
                    ),

                    array(
                        'id'        => 'newstabs-thumb',
                        'type'      => 'dimensions',
                        'title'      => __('News Tabs', 'framework'),
                        'default' => array(
                                'width' => '266',
                                'height' => '179'
                            )
                    ),

                    array(
                        'id'        => 'related-thumb',
                        'type'      => 'dimensions',
                        'title'      => __('Related posts', 'framework'),
                        'default' => array(
                                'width' => '165',
                                'height' => '109'
                            )
                    ),

                    array(
                        'id'        => 'search-grid',
                        'type'      => 'dimensions',
                        'title'      => __('Search grid', 'framework'),
                        'default' => array(
                                'width' => '347',
                                'height' => '233'
                            )
                    ),

                    array(
                        'id'        => 'megamenu-thumb',
                        'type'      => 'dimensions',
                        'title'      => __('Mega menu thumbnails', 'framework'),
                        'default' => array(
                                'width' => '112',
                                'height' => '75'
                            )
                    ),
                    array(
                        'id'        => 'search-thumb',
                        'type'      => 'dimensions',
                        'title'      => __('Ajax Search thumbnails', 'framework'),
                        'default' => array(
                                'width' => '36',
                                'height' => '36'
                            )
                    ),

                    array(
                        'id'        => 'blogb-thumb',
                        'type'      => 'dimensions',
                        'title'      => __('Blog large image', 'framework'),
                        'default' => array(
                                'width' => '546',
                                'height' => '300'
                            )
                    ),

                    array(
                        'id'        => 'blog-thumb',
                        'type'      => 'dimensions',
                        'title'      => __('Blog medium image', 'framework'),
                        'default' => array(
                                'width' => '179',
                                'height' => '120'
                            )
                    ),

                    array(
                        'id'        => 'media-thumb',
                        'type'      => 'dimensions',
                        'title'      => __('Media page thumbnails', 'framework'),
                        'default' => array(
                                'width' => '179',
                                'height' => '116'
                            )
                    ),


                    array(
                        'id'        => 'media1-thumb',
                        'type'      => 'dimensions',
                        'title'      => __('Media page large image', 'framework'),
                        'default' => array(
                                'width' => '367',
                                'height' => '237'
                            )
                    ),

                    array(
                        'id'        => 'catslider-thumb',
                        'type'      => 'dimensions',
                        'title'      => __('Category slider', 'framework'),
                        'default' => array(
                                'width' => '576',
                                'height' => '392'
                            )
                    ),

                    array(
                        'id'        => 'catslider1-thumb',
                        'type'      => 'dimensions',
                        'title'      => __('Category slider large image', 'framework'),
                        'default' => array(
                                'width' => '702',
                                'height' => '432'
                            )
                    ),

                    array(
                        'id'        => 'postlist-thumb',
                        'type'      => 'dimensions',
                        'title'      => __('Posts widget', 'framework'),
                        'default' => array(
                                'width' => '170',
                                'height' => '113'
                            )
                    ),

                    array(
                        'id'        => 'sliderwidget-thumb',
                        'type'      => 'dimensions',
                        'title'      => __('Slider widget', 'framework'),
                        'default' => array(
                                'width' => '333',
                                'height' => '227'
                            )
                    ),

                    array(
                        'id'        => 'postpicwid-thumb',
                        'type'      => 'dimensions',
                        'title'      => __('Posts in images widget', 'framework'),
                        'default' => array(
                                'width' => '81',
                                'height' => '55'
                            )
                    ),

                    array(
                        'id'        => 'big-thumb-hd',
                        'type'      => 'dimensions',
                        'title'      => __('Hd image', 'framework'),
                        'default' => array(
                                'width' => '765',
                                'height' => '510'
                            )
                    ),
                )
            );

            //Content ads
			$this->sections[] = array(
			'icon' => 'momizat-icon-image2',
			'title' => __('Content Ads', 'framework'),
			'subsection' => true,
			'fields' => array(
			        array(
			                'id' => 'notice_critical2021',
			                'type' => 'info',
			                'notice' => true,
			                'style' => 'critical',
			                'icon' => 'momizat-icon-image2',
			                'title' => __('Content Ads', 'framework'),
			                'desc' => __('You should see this ads on left and right of main content', 'framework')
			            ),

			        array(
			            'id'        => 'content_ads_position',
			            'type'      => 'switch',
			            'title'     => __('Ads on scroll Down', 'framework'),
			            'default'   => 1,
			            'on'        => 'Fixed',
			            'off'       => 'Scroll',
			        ),

			        array (
					'id' => 'content_right_banner_id',
					'type' => 'select',
					'data' => 'posts',
					'args' => array('post_type' => 'ads', 'posts_per_page' => -1),
						'title' => __('Right banner', 'framework'),
				),

				array (
					'id' => 'content_left_banner_id',
					'type' => 'select',
					'data' => 'posts',
					'args' => array('post_type' => 'ads', 'posts_per_page' => -1),
						'title' => __('Left banner', 'framework'),
				),
			)
			);

if (function_exists('is_bbpress')) {
	$this->sections[] = array(
		'icon' => 'fa-icon-comments-alt',
		'title' => __('bbPress settings', 'framework'),
                'subsection' => true,
		'fields' => array(
                            array (
                                'desc' => __('Select main layout', 'framework'),
                                'id' => 'bbpress_layout',
                                'type' => 'image_select',
                                'options' => array (
									'right-sidebar' => array('img' => $imglaypath.'right_side.png'),
									'left-sidebar' => array('img' => $imglaypath.'left_side.png'),
									'both-sidebars-all' => array('img' => $imglaypath.'both.png'),
									'both-sidebars-right' => array('img' => $imglaypath.'both_right.png'),
									'both-sidebars-left' => array('img' => $imglaypath.'both_left.png'),
									'fullwidth' => array('img' => $imglaypath.'full.png'),

                                ),
                                'title' => __('Layout', 'framework'),
                                'default' => 'right-sidebar',
                        ),

                    array(
                        'id'        => 'bbpress_right_sidebar',
                        'type'      => 'select',
                        'data'      => 'sidebars',
                        'title'     => __('Main Sidebar', 'framework'),
                    ),

                    array(
                        'id'        => 'bbpress_left_sidebar',
                        'type'      => 'select',
                        'data'      => 'sidebars',
                        'title'     => __('Secondary Sidebar', 'framework'),
                    ),
  		)
	);
}


if (function_exists('is_buddypress')) {
	$this->sections[] = array(
		'icon' => 'fa-icon-comments-alt',
		'title' => __('buddypress settings', 'framework'),
                'subsection' => true,
		'fields' => array(
                            array (
                                'desc' => __('Select main layout', 'framework'),
                                'id' => 'buddypress_layout',
                                'type' => 'image_select',
                                'options' => array (
									'right-sidebar' => array('img' => $imglaypath.'right_side.png'),
									'left-sidebar' => array('img' => $imglaypath.'left_side.png'),
									'both-sidebars-all' => array('img' => $imglaypath.'both.png'),
									'both-sidebars-right' => array('img' => $imglaypath.'both_right.png'),
									'both-sidebars-left' => array('img' => $imglaypath.'both_left.png'),
									'fullwidth' => array('img' => $imglaypath.'full.png'),

                                ),
                                'title' => __('Layout', 'framework'),
                                'default' => 'right-sidebar',
                        ),

                    array(
                        'id'        => 'buddypress_right_sidebar',
                        'type'      => 'select',
                        'data'      => 'sidebars',
                        'title'     => __('Main Sidebar', 'framework'),
                    ),

                    array(
                        'id'        => 'buddypress_left_sidebar',
                        'type'      => 'select',
                        'data'      => 'sidebars',
                        'title'     => __('Secondary Sidebar', 'framework'),
                    ),
  		)
	);
}

			if (class_exists('woocommerce')) {
				$this->sections[] = array(
					'icon' => 'fa-icon-shopping-cart',
					'title' => __('Woocommerce settings', 'framework'),
			                'subsection' => true,
					'fields' => array(
							array (
								'id' => 'woo_products_per_page',
								'desc' => __('-1 for all products', 'framework'),
								'step' => '1',
								'min' => '-1',
								'max' => '50',
								'suffix' => 'px',
								'type' => 'slider',
								'title' => __('Number of products per page', 'framework'),
								'default' => '12',
							),
							array (
								'id' => 'nav_cart',
								'type' => 'switch',
			                                        'default' => 1,
			                                        'on' => 'Show',
			                                        'off' => 'Hide',
								'title' => __('Cart In Breaking news', 'framework'),
							),

              array (
								'id' => 'topbar_cart',
								'type' => 'switch',
			                                        'default' => 0,
			                                        'on' => 'Show',
			                                        'off' => 'Hide',
								'title' => __('Cart In Topbar', 'framework'),
							),

							array (
								'id' => 'nav_cart_in_woo',
								'type' => 'switch',
			                                        'default' => 1,
			                                        'required'  => array('nav_cart', '=', 1),
			                                        'on' => 'Yes',
			                                        'off' => 'No',
								'title' => __('Show cart in woocommerce pages only', 'framework'),
								'desc' => __('if select no, the cart will display in whole site ', 'framework'),
							),
			  		)
				);
			}

            //Header settings
            $this->sections[] = array(
                'title' => __('Header Settings', 'framework'),
				'desc' => __('', 'framework'),
				'icon' => 'momizat-icon-credit',
			    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
				'fields' => array(
					array (
						'desc' => __('Select Header Style', 'framework'),
						'id' => 'header_style',
						'type' => 'image_select',
						'options' => array (
								'' => array('img' => $imgpath.'h1.png'),
								'st1' => array('img' => $imgpath.'h2.png'),
								'st2' => array('img' => $imgpath.'h3.png'),
								'st3' => array('img' => $imgpath.'h4.png'),

						),
						'title' => __('Header Style', 'framework'),
						'default' => '',
					),
					array(
					'id'=>'logo_type',
					'type' => 'select',
					'title' => __('Select Logo Type:', 'framework'),
					'options' => array(
							'logo_image' => __('Logo Image', 'framework'),
							'logo_name' => __('Site Name', 'framework'),
							),
					'default' => 'logo_image',
					),

					array(
					'id'=>'logo_img',
					'type' => 'media',
					'title' => __('Upload your logo image', 'framework'),
					'url'=> true,
					'default'=>'',
					'required' => array('logo_type', '=' , 'logo_image'),
					),

					array(
					'id'=>'retina_logo_img',
					'type' => 'media',
					'title' => __('Upload your retina logo image', 'framework'),
					'url'=> true,
					'default'=> 0,
					'required' => array('logo_type', '=' , 'logo_image'),
					),


					array(
					'id'=>'site_name_font',
					'type' => 'typography',
					'output' => array('.site_title a'),
					'title' => __('Site Name', 'framework'),
					'subtitle' => __('Specify the site name font properties.', 'framework'),
					'google'=>true,
                    'fonts' => $mfonts,
					'default' => '',
					'required' => array('logo_type', '=' , 'logo_name'),
					),

					array(
					'id'=>'site_des_font',
					'type' => 'typography',
					'output' => array('.site_desc'),
					'title' => __('Site Description', 'framework'),
					'subtitle' => __('Specify the site Description font properties.', 'framework'),
					'google'=>true,
                    'fonts' => $mfonts,
					'default' => '',
					'required' => array('logo_type', '=' , 'logo_name'),
					),
					array(
                    'id' => 'logo_margin',
                    'type' => 'spacing',
                    'units' => array('px','em','%'),
                    'output' => array('.logo, .logo .site_title'), // An array of CSS selectors to apply this font style to
                    'mode' => 'margin', // absolute, padding, margin, defaults to padding
                    'title' => __('Logo Margin', 'framework'),
                    'default' => array('margin-top' => '', 'margin-right' => "", 'margin-bottom' => '', 'margin-left' => '')
					),
					array (
					'id' => 'logo_align',
					'type' => 'radio',
					'options' => array (
						'def' => 'Default',
						'center' => 'Center',
					),
					'title' => 'Logo align',
					'default' => 'def'
					),

                    array (
                        'id' => 'logo_left_banner',
                        'type' => 'select',
                        'data' => 'posts',
                        'args' => array('post_type' => 'ads', 'posts_per_page' => -1, 'no_found_rows' => true, 'cache_results' => false),
                        'title' => __('Left Banner', 'framework'),
                        'subtitle' => __('a little banner on the left side of the logo', 'framework'),
                        'required'  => array('logo_align', '=', 'center')
                    ),
                    array (
                        'id' => 'logo_right_banner',
                        'type' => 'select',
                        'data' => 'posts',
                        'args' => array('post_type' => 'ads', 'posts_per_page' => -1, 'no_found_rows' => true, 'cache_results' => false),
                        'title' => __('Right Banner', 'framework'),
                        'subtitle' => __('a little banner on the right side of the logo', 'framework'),
                        'required'  => array('logo_align', '=', 'center')
                    ),

					array (
						'id' => 'header_height',
						'desc' => __('set the header height Default: 122px', 'framework'),
						'step' => '1',
						'min' => '40',
						'max' => '300',
						'suffix' => 'px',
						'type' => 'slider',
						'title' => __('Header height', 'framework'),
						'default' => '122',
					),
					array(
		                'id' => 'notice_critical1',
		                'type' => 'info',
		                'notice' => true,
		                'style' => 'critical',
		                'icon' => 'el-icon-info-sign',
		                'title' => __('Header Banner', 'framework'),
		                'desc' => __('Top Header Banner options.', 'framework')
		            ),
                    array(
                    'id'=>'h_banner_type',
                    'type' => 'select',
                    'title' => __('Enable/disable the header ad banner', 'framework'),
                    'default' => 'ads',
                    'options' => array(
                            'ads' => __('Enable Header Ad banner', 'framework'),
                            'custom' => __('Custom content', 'framework'),
                            ),
                    ),
					array (
						'id' => 'header_banner',
						'type' => 'select',
						'data' => 'posts',
                        'args' => array('post_type' => 'ads', 'posts_per_page' => -1, 'no_found_rows' => true, 'cache_results' => false),
						'title' => __('Select Header Banner', 'framework'),
                        'required'  => array('h_banner_type', '=', 'ads')
					),
                    array (
                        'id' => 'header_custom_content',
                        'type' => 'textarea',
                        'required'  => array('h_banner_type', '=', 'custom'),
                        'title' => __('Custom content', 'framework'),
                        'desc' => __('it can be text,html or shortcodes', 'framework'),
                    ),
                    array(
                        'id' => 'ccontent_margin',
                        'type' => 'spacing',
                        'units' => array('px','em','%'),
                        'output' => array('.header-right_custom-content'), // An array of CSS selectors to apply this font style to
                        'mode' => 'margin', // absolute, padding, margin, defaults to padding
                        'title' => __('Custom content Margin', 'framework'),
                        'required'  => array('h_banner_type', '=', 'custom'),
                        'default' => array('margin-top' => '', 'margin-right' => "", 'margin-bottom' => '', 'margin-left' => '')
                    ),
				)
            );
                $this->sections[] = array(
        'icon' => 'el-icon-credit-card',
        'title' => __('Top Banner', 'framework'),
                'subsection' => true,
        'fields' => array(
                array (
                    'id' => 'top_banner',
                    'type' => 'switch',
                                        'default' => 0,
                                        'on' => 'Enable',
                                        'off' => 'Disable',
                    'title' => __('Top banner', 'framework'),
                ),

                array (
                    'id' => 'top_banner_content',
                    'type' => 'switch',
                                        'default' => 1,
                                        'on' => 'Ad',
                                        'off' => 'Custom',
                    'title' => __('Top banner Content', 'framework'),
                ),
                array (
                    'id' => 'top_banner_ad',
                    'type' => 'select',
                    'data' => 'posts',
                    'args' => array('post_type' => 'ads', 'posts_per_page' => -1, 'no_found_rows' => true, 'cache_results' => false),
                                        'required'  => array('top_banner_content', '=', '1'),
                        'title' => __('Select Top banner', 'framework'),
                ),
                array (
                    'id' => 'top_banner_custom',
                    'type' => 'editor',
                                        'args' => array(
                                        'teeny' => false,
                                        'drag_drop_upload' => true,
                                        'textarea_rows' => 20,
                                       ),

                    'title' => __('Custom Content', 'framework'),
                    'subtitle' => __('You can use HTML or shortcodes here', 'framework'),
                                        'required'  => array('top_banner_content', '=', '0'),
                ),

                array (
                    'id' => 'top_banner_close',
                    'type' => 'switch',
                                        'default' => 0,
                    'title' => __('Close button', 'framework'),
                ),

                array (
                    'id' => 'top_banner_close_timeout',
                    'type' => 'text',
                    'desc' => __('Auto close banner after x seconds, leave empty for disable auto close', 'framework'),
                    'title' => __('Auto close', 'framework'),

                ),

                array (
                    'id' => 'top_banner_display_logic',
                    'type' => 'text',
                    'placeholder' => 'is_home() || is_front_page()',
                    'title' => __('Display Logic', 'framework'),
                    'subtitle' => __('For Advanced users only', 'framework'),
                    'desc'  => __('this option allow you to use wordpress <a href="http://codex.wordpress.org/Conditional_Tags" target="_blank">Conditional Tags</a> or any PHP code, be careful anyone has access to edit theme options can add any codes here', 'framework'),
                    'default' => ''
                ),

/*              array (
                    'id' => 'top_banner_close_save',
                    'type' => 'switch',
                                        'default' => 0,
                                        'required'  => array('top_banner_close', '=', '1'),
                    'title' => __('Save with cookies', 'framework'),
                    'subtitle' => __('Some servers don\'t allow cookies', 'framework'),
                    'desc' => __('this option will save the close state if any visitor close the top banner', 'framework'),
                ),
                array (
                    'id' => 'top_banner_close_save_exp',
                    'desc' => __('Days', 'framework'),
                    'step' => '1',
                    'min' => '1',
                    'max' => '356',
                    'type' => 'slider',
                    'title' => __('Delete cookies after', 'framework'),
                    'default' => '7',
                ),
*/

                    array(
                        'id'        => 'topbanner-customization-info',
                        'type'      => 'info',
                        'title'      => __('Customize', 'framework'),
                    ),

                    array (
                            'id' => 'tob_banner-bg',
                            'type' => 'color',
                            'title' => __('Background', 'framework'),
                            'output' => array('color' => '', 'background-color' => '.top_banner')
                    ),

                    array (
                            'id' => 'tob_banner-color',
                            'type' => 'color',
                            'title' => __('Text Color', 'framework'),
                            'output' => array('color' => '.top_banner')
                    ),

                    array (
                            'id' => 'tob_banner-links',
                            'type' => 'color',
                            'title' => __('Links Color', 'framework'),
                            'output' => array('color' => '.top_banner a')
                    ),

                    array (
                            'id' => 'tob_banner-close',
                            'type' => 'color',
                            'title' => __('Close button color', 'framework'),
                            'output' => array('color' => '.top_banner a.tob_banner_close')
                    ),

        )
    );


            //topbar settings
            $this->sections[] = array(
               'title' => __('Top Bar', 'framework'),
				'desc' => __('', 'framework'),
				'icon' => 'momizat-icon-minus',
				'subsection' => true,
			    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
				'fields' => array(
					array (
						'id' => 'tb_disable',
						'type' => 'switch',
						'title' => 'Disable Topbar',
						'default' => 1,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
					),
					array (
						'id' => 'today_date',
						'type' => 'switch',
						'title' => 'Disable Today Date',
						'default' => 0,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
					),
					array (
						'id' => 'today_date_format',
						'desc' => __('Change date format click <a href="http://codex.wordpress.org/Formatting_Date_and_Time" target="_blank">here</a> to see how to change it', 'framework'),
						'type' => 'text',
						'title' => __('Today Date Format', 'framework'),
						'default' => 'F d, Y',
					),
					array (
						'id' => 'tb_search_disable',
						'type' => 'switch',
						'title' => 'Disable Top Search box',
						'default' => 1,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
					),
					array (
						'id' => 'ajax_search_disable',
						'type' => 'switch',
						'title' => 'Disable Ajax From Top Search',
						'default' => 1,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
					),
					array (
						'id' => 'tb_left_content',
						'type' => 'select',
						'options' => array (
							'menu' => 'Menu',
							'social' => 'Social Icons and search',
							'custom' => 'Custom Content',
						),
						'title' => 'Left Content',
						'default' => 'menu',
					),
					array (
						'id' => 'tb_custom_text',
						'type' => 'textarea',
						'title' => 'Custom Text',
						'required' => array('tb_left_content', '=' , 'custom')
					),
					array (
						'id' => 'tb_right_content',
						'type' => 'select',
						'options' => array (
							'menu' => 'Menu',
							'social' => 'Social Icons and search',
							'custom' => 'Custom Content',
						),
						'title' => 'Right Content',
						'default' => 'social',
					),
					array (
						'id' => 'tb_right_custom_text',
						'type' => 'textarea',
						'title' => 'Custom Text',
						'required' => array('tb_right_content', '=' , 'custom')
					),

				)
            );

            //breaking news settings
            $this->sections[] = array(
                'title' => __('Breaking News Bar', 'framework'),
				'desc' => __('', 'framework'),
				'icon' => 'momizat-icon-pencil',
				'subsection' => true,
			    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
				'fields' => array(
						array(
						'id'=>'bn_bar',
						'type' => 'switch',
						'title' => __('Breaking news bar', 'framework'),
						"default" 		=> 1,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),

						array(
						'id'=>'bn_bar_news',
						'type' => 'switch',
						'title' => __('Breaking news', 'framework'),
						"default" 		=> 1,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),

                        array(
                        'id'=>'bn_type',
                        'type' => 'select',
                        'title' => __('Breaking News Direction:', 'framework'),
                        'default' => '',
                        'options' => array(
                                        'right' => __('Right/left', 'framework'),
                                        'up' => __('Up/Down', 'framework'),
                                        'fade' => __('Fade', 'framework'),
                                ),
                        ),

						array(
						'id'=>'bn_bar_title',
						'type' => 'text',
						'title' => __('Breaking news Title', 'framework'),
						"default" 		=> __('Breaking News', 'framework'),
						),

						array(
						'id'=>'bn_bar_display',
						'type' => 'select',
						'title' => __('Breaking News Display:', 'framework'),
						'default' => 'latest',
						'options' => array(
										'latest' => __('Latest News', 'framework'),
										'cats' => __('Category/s', 'framework'),
										'tags' => __('Tag/s', 'framework'),
                                        'rss' => __('Rss feed', 'framework'),
										'custom' => __('Custom Text', 'framework'),
								),
						),

						array(
						'id'=>'bn_bar_cats',
						'type' => 'select',
						'multi' => true,
						'data' => 'categories',
						'title' => __('Category/s:', 'framework'),
						'subtitle' => __('select single or multi category/s', 'framework'),
		                'required' => array('bn_bar_display', '=' , 'cats'),
						),

						array(
						'id'=>'bn_bar_tags',
						'type' => 'text',
						'title' => __('Tag/s:', 'framework'),
						'subtitle' => __('Insert tag id/s saperate each tag id with comma', 'framework'),
						'desc' => __('How to get tag ID? See this <a href="http://www.wpbeginner.com/beginners-guide/how-to-find-post-category-tag-comments-or-user-id-in-wordpress/">tutorial</a>', 'framework'),
			            'required' => array('bn_bar_display', '=' , 'tags'),
						),
		                array(
                        'id'=>'bn_bar_rss',
                        'type' => 'text',
                        'title' => __('Rss feed source:', 'framework'),
                        'subtitle' => __('Get a braking news items from the specified feed source', 'framework'),
                        'required' => array('bn_bar_display', '=' , 'rss'),
                        ),
						array(
						'id'=>'bn_bar_custom',
						'type' => 'textarea',
						'title' => __('Custom Text:', 'framework'),
						'subtitle' => __('each news in new line', 'framework'),
			             'required' => array('bn_bar_display', '=' , 'custom'),
						),
						array(
						'id'=>'num_br_posts',
						'type' => 'slider',
						'title' => __('Number of items', 'framework'),
						"default" => "10",
						"min" 	=> "-1",
						"step"	=> "1",
						"max" 	=> "50",
						'desc' => __('-1 for show all posts', 'framework'),
						),
                        array(
                        'id'            => 'bn_scroll_speed',
                        'type'          => 'slider',
                        'title'         => __('Speed', 'framework'),
                        'default'       => 7,
                        'subtitle'          => __('lower is slower', 'framework'),
                        'min'           => 1,
                        'step'          => 1,
                        'max'           => 30,
                        'display_value' => 'input',
                        'required' => array('bn_type', '=' , 'right'),
                        ),
                        array(
                        'id'            => 'bn_speed',
                        'type'          => 'slider',
                        'title'         => __('Speed', 'framework'),
                        'default'       => 600,
                        'min'           => 50,
                        'subtitle'          => __('defines the animation speed (in ms)', 'framework'),
                        'step'          => 50,
                        'max'           => 10000,
                        'display_value' => 'input',
                        'required' => array('bn_type', '=' , 'up'),
                        ),
                        array(
                        'id'            => 'bn_duration',
                        'type'          => 'slider',
                        'title'         => __('Duration', 'framework'),
                        'default'       => 4000,
                        'min'           => 50,
                        'subtitle'          => __('defines the times (in ms) before the rows automatically move', 'framework'),
                        'step'          => 50,
                        'max'           => 10000,
                        'display_value' => 'input',
                        'required' => array('bn_type', '!=' , 'right'),
                        ),
                        array(
                        'id'=>'bn_bar_links_open',
                        'type' => 'switch',
                        'title' => __('Open links in new window', 'framework'),
                        "default"       => 0,
                        'on'        => __('Yes', 'framework'),
                        'off'       => __('No', 'framework')
                        ),

						array(
						'id'=>'bn_bar_menu',
						'type' => 'switch',
						'title' => __('icons menu in breaking news bar', 'framework'),
						"default" 		=> 1,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),
                        array(
                        'id'=>'bar_search',
                        'type' => 'switch',
                        'title' => __('Search icon breaking news bar', 'framework'),
                        'subtitle' => __('require icon menu to appears', 'framework'),
                        "default"       => 0,
                        'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
                        ),
						array(
						'id'=>'bar_login',
						'type' => 'switch',
                        'title' => __('login box in breaking news bar', 'framework'),
						'subtitle' => __('require icon menu to appears', 'framework'),
						"default" 		=> 0,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),
				)
            );

            //navigation settings
            $this->sections[] = array(
                'title' => __('Navigation settings', 'framework'),
				'desc' => __('', 'framework'),
				'icon' => 'momizat-icon-wrench',
				'subsection' => true,
			    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
				'fields' => array(
					array (
					'id' => 'nav_align',
					'type' => 'radio',
					'options' => array (
						'' => 'Default',
						'center' => 'Center',
					),
					'title' => 'Navigation menu align',
					'default' => ''
					),
					 array (
					'id' => 'nav-itemcolor',
					'type' => 'switch',
					'title' => __('Disable Navigation Menu bottom color', 'framework'),
					"default" => 1,
					'on'        => __('Enable', 'framework'),
                    'off'       => __('Disable', 'framework')
					),
					array(
					'id'=>'dropdown-effect',
					'type' => 'select',
					'title' => __('Navigation Menu dropdown effect', 'framework'),
					'options' => array(
							'dd-effect-fade' => __('Fade', 'framework'),
							'dd-effect-slide' => __('Slide', 'framework'),
							'dd-effect-skew' => __('Skew', 'framework'),
							),
					'default' => 'dd-effect-slide',
					),
					array (
					'id' => 'sticky_navigation',
					'type' => 'switch',
					'title' => __('Sticky Navigation', 'framework'),
					'default' => 0,
                    ),
                    array (
					'id' => 'sticky_navigation_logo',
					'type' => 'media',
					'url' => true,
					'title' => __('Sticky Navigation logo', 'framework'),
					'required' => array('sticky_navigation','=',1),
                    ),

                    array (
                    'id' => 'sticky_logo_out',
                    'type' => 'switch',
                    'title' => __('Sticky logo out boundary', 'framework'),
                    'desc' => __('if your menu has a lot of items you need to set this to ON because sticky logo will push your items down', 'framework'),
                    'default' => 0,
                    ),

                    array(
                    'id'            => 'cm_counter',
                    'type'          => 'slider',
                    'title'         => __('Number Of Posts in Category Menu', 'framework'),
                    'default'       => 3,
                    'min'           => 1,
                    'step'          => 1,
                    'max'           => 10,
                    'display_value' => 'input',
                    ),
				)
			);
                $this->sections[] = array(
        'icon' => 'el-icon-credit-card',
        'title' => __('Under nav Banner', 'framework'),
                'subsection' => true,
        'fields' => array(
                array (
                    'id' => 'unav_banner',
                    'type' => 'switch',
                                        'default' => 0,
                                        'on' => 'Enable',
                                        'off' => 'Disable',
                    'title' => __('Top banner', 'framework'),
                ),

                array (
                    'id' => 'unav_banner_content',
                    'type' => 'switch',
                                        'default' => 1,
                                        'on' => 'Ad',
                                        'off' => 'Custom',
                    'title' => __('Top banner Content', 'framework'),
                ),
                array (
                    'id' => 'unav_banner_ad',
                    'type' => 'select',
                    'data' => 'posts',
                    'args' => array('post_type' => 'ads', 'posts_per_page' => -1, 'no_found_rows' => true, 'cache_results' => false),
                                        'required'  => array('unav_banner_content', '=', '1'),
                        'title' => __('Select Top banner', 'framework'),
                ),
                array (
                    'id' => 'unav_banner_custom',
                    'type' => 'editor',
                                        'args' => array(
                                        'teeny' => false,
                                        'drag_drop_upload' => true,
                                        'textarea_rows' => 20,
                                       ),

                    'title' => __('Custom Content', 'framework'),
                    'subtitle' => __('You can use HTML or shortcodes here', 'framework'),
                                        'required'  => array('unav_banner_content', '=', '0'),
                ),

                array (
                    'id' => 'unav_banner_close',
                    'type' => 'switch',
                                        'default' => 0,
                    'title' => __('Close button', 'framework'),
                ),
                array (
                    'id' => 'unav_banner_close_timeout',
                    'type' => 'text',
                    'desc' => __('Auto close banner after x seconds, leave empty for disable auto close', 'framework'),
                    'title' => __('Auto close', 'framework'),

                ),

                array (
                    'id' => 'unav_banner_display_logic',
                    'type' => 'text',
                    'placeholder' => 'is_home() || is_front_page()',
                    'title' => __('Display Logic', 'framework'),
                    'subtitle' => __('For Advanced users only', 'framework'),
                    'desc'  => __('this option allow you to use wordpress <a href="http://codex.wordpress.org/Conditional_Tags" target="_blank">Conditional Tags</a> or any PHP code, be careful anyone has access to edit theme options can add any codes here', 'framework'),
                    'default' => ''
                ),

                    array(
                        'id'        => 'topbanner-customization-info',
                        'type'      => 'info',
                        'title'      => __('Customize', 'framework'),
                    ),

                    array (
                            'id' => 'unav_banner-bg',
                            'type' => 'color',
                            'title' => __('Background', 'framework'),
                            'output' => array('color' => '', 'background-color' => '.unav_banner')
                    ),

                    array (
                            'id' => 'unav_banner-color',
                            'type' => 'color',
                            'title' => __('Text Color', 'framework'),
                            'output' => array('color' => '.unav_banner')
                    ),

                    array (
                            'id' => 'unav_banner-links',
                            'type' => 'color',
                            'title' => __('Links Color', 'framework'),
                            'output' => array('color' => '.unav_banner a')
                    ),

                    array (
                            'id' => 'unav_banner-close',
                            'type' => 'color',
                            'title' => __('Close button color', 'framework'),
                            'output' => array('color' => '.unav_banner a.unav_banner_close')
                    ),



        )
    );
			//styling settings
            $this->sections[] = array(
                'title' => __('Styling', 'framework'),
				'desc' => __('', 'framework'),
				'icon' => 'momizat-icon-paint-format',
			    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
				'fields' => array(
						array (
							'id' => 'main_skin',
							'type' => 'image_select',
							'options' => array (
									'light' => array('img' => $imgpath.'light.png'),
									'dark' => array('img' => $imgpath.'dark.png'),
							),
							'title' => __('Skin', 'framework'),
							'default' => 'light'
						),
						array (
							'id' => 'nb_skin',
							'type' => 'select',
							'options' => array (
									'' => 'Default',
									'color' => 'colorful',
							),
							'title' => __('News boxes and widget title style', 'framework'),
							'default' => ''
						),
						array(
			                'id' => 'notice_critical3',
			                'type' => 'info',
			                'notice' => true,
			                'style' => 'critical',
			                'icon' => 'momizat-icon-wand',
			                'title' => __('Main Style', 'framework'),
			                'desc' => __('Body Background and body font and links', 'framework')
			            ),

				array(
		                    'id' => 'main-color',
		                    'type' => 'color',
		                    'output' => array('color' => '.entry-crumbs,.entry-crumbs .vbreadcrumb>a,.cat-slider-nav-title,.f-tabbed-head li a.current,.media-main-content .f-tabbed-head li.active a span,.media-main-content .f-tabbed-head li a:hover span,.media-main-content .f-tabbed-head li.active a,.media-main-content .f-tabbed-head li a:hover,.f-tabbed-head li.active a,.f-tabbed-head li a:hover,.cat-grid li h2 a,header.block-title h2 a,header.block-title h2,.sidebar a:hover,.secondary-sidebar a:hover,.main-container a:hover,.sidebar .post-list li h2 a:hover,.secondary-sidebar .post-list li h2 a:hover,.nb1 ul li h2 a:hover,.nb2 .first-item h2 a:hover,.nb3 .first-item h2 a:hover,.nb4 .first-item h2 a:hover,.nb5 .first-item h2 a:hover,.nb6 ul li h2 a:hover,.nb3 ul li h2 a:hover,.nb4 ul li h2 a:hover,.nb2 ul li h2 a:hover,.nb5 ul li h2 a:hover,ul.f-tabbed-list li h2 a:hover,.scroller .owl-next:hover:after,.scroller .owl-prev:hover:before,.sidebar .widget_categories li:hover,.sidebar .widget_categories li:hover a,.secondary-sidebar .widget_categories li:hover,.secondary-sidebar .widget_categories li:hover a,.scroller2 .owl-next:hover:after,.scroller2 .owl-prev:hover:before,.mom-related-posts li:hover h2 a,ul.widget-tabbed-header li a.current,.secondary-sidebar .post-list li .read-more-link,ul.mom_tabs li a.current,ul.mom_tabs li a:hover,.accordion h2.active .acch_arrows:before,.accordion h2.active .acch_arrows:before,.accordion h2.active .acch_numbers,.accordion h2.active .acch_pm:before,ul.mom_tabs li a.current,ul.mom_tabs li a:hover,.tabs_v3 ul.mom_tabs li a.current,.toggle_active h4.toggle_title,.cat-slider-mpop ul li h2 a,.blog-post-big h2 a,.blog-post h2 a,.cat-list li h2 a,ul.widget-tabbed-header li a:hover,ul.widget-tabbed-header li a.current,.pagination span,h1.entry-title,.entry-content-data .post-thumbnail .img-toggle,a:hover,.sidebar .post-list li h2 a:hover,.secondary-sidebar .post-list li h2 a:hover,.nb1 ul li h2 a:hover,.nb2 .first-item h2 a:hover,.nb3 .first-item h2 a:hover,.nb4 .first-item h2 a:hover,.nb5 .first-item h2 a:hover,.nb6 ul li h2 a:hover,.nb3 ul li h2 a:hover,.nb4 ul li h2 a:hover,.nb2 ul li h2 a:hover,.nb5 ul li h2 a:hover,ul.f-tabbed-list li h2 a:hover,.scroller .owl-next:hover:after,.scroller .owl-prev:hover:before,.sidebar .widget_categories li:hover,.sidebar .widget_categories li:hover a,.secondary-sidebar .widget_categories li:hover,.secondary-sidebar .widget_categories li:hover a,.scroller2 .owl-next:hover:after,.scroller2 .owl-prev:hover:before,.mom-related-posts li:hover h2 a,.author-bio-name a,ol.nb-tabbed-head li.active a,.dropcap, .entry-crumbs,.entry-crumbs .vbreadcrumb>a,.f-tabbed-head li a.current,.media-main-content .f-tabbed-head li.active a span,.media-main-content .f-tabbed-head li a:hover span,.media-main-content .f-tabbed-head li.active a,.media-main-content .f-tabbed-head li a:hover,.f-tabbed-head li.active a,.f-tabbed-head li a:hover,.f-tabbed-head li a.current,.media-main-content .f-tabbed-head li.active a span,.media-main-content .f-tabbed-head li a:hover span,.media-main-content .f-tabbed-head li.active a,.media-main-content .f-tabbed-head li a:hover,.f-tabbed-head li.active a,.f-tabbed-head li a:hover,.weather-page-head,header.block-title h2 a,header.block-title h2,.sidebar a:hover,.secondary-sidebar a:hover,.main-container a:hover,.sidebar .post-list li h2 a:hover,.secondary-sidebar .post-list li h2 a:hover,.nb1 ul li h2 a:hover,.nb2 .first-item h2 a:hover,.nb3 .first-item h2 a:hover,.nb4 .first-item h2 a:hover,.nb5 .first-item h2 a:hover,.nb6 ul li h2 a:hover,.nb3 ul li h2 a:hover,.nb4 ul li h2 a:hover,.nb2 ul li h2 a:hover,.nb5 ul li h2 a:hover,ul.f-tabbed-list li h2 a:hover,.scroller .owl-next:hover:after,.scroller .owl-prev:hover:before,.sidebar .widget_categories li:hover,.sidebar .widget_categories li:hover a,.secondary-sidebar .widget_categories li:hover,.secondary-sidebar .widget_categories li:hover a,.scroller2 .owl-next:hover:after,.scroller2 .owl-prev:hover:before,.mom-related-posts li:hover h2 a,ul.widget-tabbed-header li a.current,.secondary-sidebar .post-list li .read-more-link,ul.mom_tabs li a.current,ul.mom_tabs li a:hover,.accordion h2.active .acch_arrows:before,.accordion h2.active .acch_arrows:before,.accordion h2.active .acch_numbers,.accordion h2.active .acch_pm:before,ul.mom_tabs li a.current,ul.mom_tabs li a:hover,.tabs_v3 ul.mom_tabs li a.current,.toggle_active h4.toggle_title,ul.products li .mom_product_details .price,.star-rating,.star-rating,.main_tabs .tabs li.active>a,.blog-post-big h2 a,.blog-post h2 a,.cat-list li h2 a,ol.nb-tabbed-head li.active a,.dropcap, a:hover, .mom-archive ul li ul li a:hover, header.block-title h2 a, header.block-title h2, .error-page .search-form .esearch-submit, .post-list .star-rating, .star-rating, .entry-content-data .story-highlights h4, .entry-content-data .story-highlights ul li:hover a:before, .bbp-body .bbp-forum-title, .mom-main-color, .site-content  .mom-main-color, .bbp-forum-freshness .bbp-author-name, .mom-bbp-topic-data .bbp-topic-permalink, .bbp-topics .bbp-author-name, .bbp-pagination-links span.current, .mom-main-color a, #buddypress div#item-header div#item-meta a, #buddypress div.item-list-tabs ul li span, #buddypress div#object-nav.item-list-tabs ul li.selected a, #buddypress div#object-nav.item-list-tabs ul li.current a, #buddypress div#subnav.item-list-tabs ul li.selected a, #buddypress div#subnav.item-list-tabs ul li.current a, .entry-crumbs a',
                                                      'background-color' => '.entry-crumbs .crumb-icon,.sidebar .widget_archive li:hover a:before,.widget_archive li:hover a:before,.widget_pages li:hover a:before,.widget_meta li:hover a:before,.widget_categories li:hover a:before,.accordion h2.active:before,.accordion h2:hover:before,a.mom_button,.mom_iconbox_square,.mom_iconbox_circle,.toggle_active:before,.cat-slider-nav ul li.activeSlide,.cat-slider-nav ul li:hover,.top-cat-slider-nav ul li:hover,a.read-more,.cat-slider-nav ul li.activeSlide:after,.cat-slider-nav ul li:hover:after,.cat-slider-nav ul li.activeSlide:before,.cat-slider-nav ul li:hover:before,.top-cat-slider-nav ul li:hover:after,.top-cat-slider-nav ul li:hover:before,.button,.mom_button,input[type="submit"],button[type="submit"],a.read-more,.brmenu .nav-button.nav-cart span.numofitems, .entry-crumbs .crumb-icon,.weather-page-icon,.weather-switch-tabs .w-unit.selected,.sidebar .widget_archive li:hover a:before,.media-cat-filter ul>li:hover>a:before,.widget_archive li:hover a:before,.widget_pages li:hover a:before,.widget_meta li:hover a:before,.widget_categories li:hover a:before,.accordion h2.active:before,.accordion h2:hover:before,a.mom_button,.mom_iconbox_square,.mom_iconbox_circle,.toggle_active:before,button,input[type="button"],input[type="reset"],input[type="submit"],.woocommerce .widget_price_filter .ui-slider .ui-slider-handle,.woocommerce-page .widget_price_filter .ui-slider .ui-slider-handle,a.read-more,.brmenu .nav-button.nav-cart span.numofitems, .widget ul:not(.widget-tabbed-header):not(.social-counter):not(.social-widget):not(.latest-comment-list):not(.npwidget):not(.post-list):not(.twiter-list):not(.user-login-links):not(.login-links):not(.product_list_widget):not(.twiter-buttons):not(.w-co-w)>li:hover>a:before,.sidebar .widget_archive li:hover a:before,.media-cat-filter ul>li:hover>a:before,.widget_archive li:hover a:before,.widget_pages li:hover a:before,.widget_meta li:hover a:before,.widget_categories li:hover a:before,.widget_nav_menu ul li a:hover:before, .mom-archive ul li ul li a:before, .alert-bar, .widget.momizat_widget_categories ul li:hover a span',
                                                      'border-color' => '.cat-slider-nav ul li.activeSlide,.cat-slider-nav ul li:hover,.top-cat-slider-nav ul li:hover,.cat-slider-nav ul li.activeSlide+li,.cat-slider-nav ul li:hover+li,.top-cat-slider-nav ul li:hover+li, .tagcloud a:hover, .mom_quote .quote-arrow, .toggle_active:before, .mom_quote',
                                                      'border-right-color' => '.cat-slider-nav ul li.activeSlide h2:before,.cat-slider-nav ul li:hover h2:before,.top-cat-slider-nav ul li:hover h2:before, .rtl .entry-crumbs .crumb-icon:before',
                                                      'border-left-color' => '.entry-crumbs .crumb-icon:before, .weather-page-icon:before, .entry-crumbs .crumb-icon:before' ,
                                                      ),
		                    'title' => __('Main Color', 'framework'),
		                    'subtitle' => __('overwrite the light blue color', 'framework'),
		                ),

						array(
		                    'id' => 'body-color',
		                    'type' => 'color',
		                    'title' => __('Body font color', 'framework'),
		                    'output' => array('body'),
		                    //'default' => '#9a9a9a',
		                    'mode' => 'color',
		                    'validate' => 'color',
		                ),
		                array(
							'id'=>'link-color',
							'type' => 'link_color',
							'title' => __('Links Color', 'framework'),
							//'regular' => false, // Disable Regular Color
							//'hover' => false, // Disable Hover Color
							//'active' => false, // Disable Active Color
							//'visited' => true, // Enable Visited Color
							'output' => array('a, .mom-archive ul li ul li a, body a'),
							/*
'default' => array(
								'regular' => '#2d2d2d',
								'hover' => '',
								'active' => '',
							)
*/
						),
						array(
			                'id' => 'notice_critical4',
			                'type' => 'info',
			                'notice' => true,
			                'style' => 'critical',
			                'icon' => 'momizat-icon-wand',
			                'title' => __('Topbar Style', 'framework'),
			                'desc' => __('Topbar Background and border color top menu color and top social icons color', 'framework')
			            ),
						array(
		                    'id' => 'bg-topbar',
		                    'type' => 'color_rgba',
		                    'title' => __('Topbar Background Color', 'framework'),
		                    'output' => array('.top-bar, ul.top-menu li ul li:hover, .ajax-search-results a:hover'),
		                    //'default' => '#000',
		                    'mode' => 'background',
		                    'validate' => 'colorrgba',
		                ),
		                array(
		                    'id' => 'border-topbar',
		                    'type' => 'color',
		                    'title' => __('Topbar border Color', 'framework'),
		                    'output' => array('.top-bar'),
		                    //'default' => '#222',
		                    'mode' => 'border-color',
		                    'validate' => 'color',
		                ),
		                array(
		                    'id' => 'topmenu_color',
		                    'type' => 'link_color',
		                    'title' => __('Top Menu items color', 'framework'),
		                    'output' => array(
			                    'ul.top-menu li a',
			                    '.mobile-menu li a',
			                    '.ajax-search-results a h2'
		                    ),
		                    'active' => false,
		                    /*
                     'default' => array(
								'regular' => '#c3c3c3',
								'hover' => '#fff',
								'active' => '',
							)
*/
		                ),
		                array(
		                    'id' => 'topmenu_divider',
		                    'type' => 'color',
		                    'title' => __('Top Menu Divider Color', 'framework'),
		                    'output' => array('ul.top-menu li, .mobile-menu ul li, ul.top-menu li:first-child, ul.top-social-icon li, ul.top-social-icon li.top-search, ul.top-menu li ul li, .ajax-search-results, .ajax-search-results a'),
		                    //'default' => '#222',
		                    'mode' => 'border-color',
		                    'validate' => 'color',
		                ),
		                array(
		                    'id' => 'hover-topmenu',
		                    'type' => 'color_rgba',
		                    'title' => __('Top Menu Background Hover', 'framework'),
		                    'output' => array('ul.top-social-icon li:hover, ul.top-menu li.current-menu-item, ul.top-menu li:hover, .mobile-menu .mobile-menu-icon:hover, .mobile-menu .mobile-menu-icon.dl-active, ul.top-menu > li ul.sub-menu, div.search-dropdown, .ajax-search-results'),
		                    //'default' => '#1A1919',
		                    'mode' => 'background',
		                    'validate' => 'colorrgba',
		                ),
		                array(
		                    'id' => 'topmenu_social',
		                    'type' => 'link_color',
		                    'title' => __('Topbar social icons color', 'framework'),
		                    'output' => array('ul.top-social-icon li a'),
		                    'active' => false,
		                    /*
'default' => array(
								'regular' => '#ededed',
								'hover' => '',
								'active' => '',
							)
*/
		                ),
                        array(
                            'id' => 'date-bg',
                            'type' => 'color_rgba',
                            'title' => __('Today Date Background color', 'framework'),
                            'output' => array('.today_date'),
                            //'default' => '#1A1919',
                            'mode' => 'background',
                            'validate' => 'colorrgba',
                        ),
                        array(
                            'id' => 'date-color',
                            'type' => 'color',
                            'title' => __('Today Date text color', 'framework'),
                            'output' => array('.today_date'),
                            //'default' => '#9a9a9a',
                            'mode' => 'color',
                            'validate' => 'color',
                        ),
		                array(
			                'id' => 'notice_critical5',
			                'type' => 'info',
			                'notice' => true,
			                'style' => 'critical',
			                'icon' => 'momizat-icon-wand',
			                'title' => __('Header Style', 'framework'),
			                'desc' => __('Header content background', 'framework')
			            ),
						array(
		                    'id' => 'header_background',
		                    'type' => 'background',
		                    'output' => array('.header-wrap', '.hst1 .header-wrap', '.hst2 .header-wrap', '.hst3 .header-wrap'),
		                    'title' => __('Header Content Background', 'framework'),
		                ),
		                array(
			                'id' => 'notice_critical6',
			                'type' => 'info',
			                'notice' => true,
			                'style' => 'critical',
			                'icon' => 'momizat-icon-wand',
			                'title' => __('Navigation Style', 'framework'),
			                'desc' => __('Navigation background color and border color and main menu color', 'framework')
			            ),
		                array(
		                    'id' => 'nav_background',
		                    'type' => 'color_rgba',
		                    'title' => __('Navigation Menu Background', 'framework'),
		                    'output' => array('.navigation, .hst1 .navigation, .hst2 .navigation, .hst3 .navigation, .fixed-header'),
		                    //'default' => '#262626',
		                    'mode' => 'background',
		                    'validate' => 'colorrgba',
		                ),
		                array(
		                    'id' => 'mainmenu_color',
		                    'type' => 'link_color',
		                    'title' => __('Main Menu items color', 'framework'),
		                    'active' => false,
		                    'output' => array(
		                    	'ul.main-menu li a',
		                    	'.device-menu-holder',
		                    	'.the_menu_holder_area i',
		                    	'.device-menu-holder .mh-icon',
		                    	'#navigation .device-menu li.menu-item > a',
		                    	'.hst1 ul.main-menu li a',
		                    	'.hst2 ul.main-menu li a', '.hst1 .breaking-news .breaking-title, .hst1 ul.main-menu li a, .hst2 .breaking-news .breaking-title, .hst2 ul.main-menu li a, .hst3 .breaking-news .breaking-title, .hst3 ul.main-menu li a'
		                    	),
		                    /*
'default' => array(
								'regular' => '#ededed',
								'hover' => '',
								'active' => '',
							)
*/
		                ),
		                array(
		                    'id' => 'mainmenu_divider',
		                    'type' => 'color',
		                    'title' => __('Main Menu Divider Color', 'framework'),
		                    'output' => array('ul.main-menu li, ul.main-menu li:first-child, .device-menu-holder, #navigation .device-menu, #navigation .device-menu li.menu-item, #navigation .device-menu li .responsive-caret, .hst1 ul.main-menu li, .hst1 ul.main-menu li:first-child, .hst2 ul.main-menu li, .hst2 ul.main-menu li:first-child, .hst2 ul.br-right li, .hst3 ul.main-menu li, .hst3 ul.main-menu li:first-child, .hst1 ul.main-menu li:not(.mom_mega) ul li, .hst2 ul.main-menu li:not(.mom_mega) ul li, .hst3 ul.main-menu li:not(.mom_mega) ul li'),
		                    //'default' => '#000',
		                    'mode' => 'border-color',
		                    'validate' => 'color',
		                ),
		                array(
		                    'id' => 'nav_bg_hover',
		                    'type' => 'color_rgba',
		                    'title' => __('Navigation Menu Background Hover', 'framework'),
		                    'output' => array('ul.main-menu li.current-menu-parent, ul.main-menu li.current-menu-item, ul.main-menu li:hover, .device-menu-holder, #navigation .device-menu li.menu-item:hover, .hst1 ul.main-menu li:hover, .hst2 ul.main-menu li:hover, .hst3 ul.main-menu li:hover, .hst1 ul.main-menu li.current-menu-parent, .hst1 ul.main-menu li.current-menu-item, .hst1 .device-menu-holder, .hst1 #navigation .device-menu li.menu-item:hover, .hst2 ul.main-menu li.current-menu-parent, .hst2 ul.main-menu li.current-menu-item, .hst2 .device-menu-holder, .hst2 #navigation .device-menu li.menu-item:hover, .hst3 ul.main-menu li.current-menu-parent, .hst3 ul.main-menu li.current-menu-item, .hst3 .device-menu-holder, .hst3 #navigation .device-menu li.menu-item:hover'),
		                    //'default' => '#1e1e1e',
		                    'mode' => 'background',
		                    'validate' => 'colorrgba',
		                ),
		                array(
		                    'id' => 'nav_bg_drop',
		                    'type' => 'color_rgba',
		                    'title' => __('Navigation sub-menu Background', 'framework'),
		                    'output' => array('.navigation ul.main-menu > li:not(.mom_mega) ul.sub-menu, .navigation ul.main-menu > li .mom-megamenu, .navigation ul.main-menu > li.mom_mega.menu-item-depth-0 > .mom_mega_wrap, ul.main-menu li.mom_mega ul li ul li:hover, .hst1 .navigation ul.main-menu > li:not(.mom_mega) ul.sub-menu, .hst2 .navigation ul.main-menu > li:not(.mom_mega) ul.sub-menu, .hst3 .navigation ul.main-menu > li:not(.mom_mega) ul.sub-menu, .hst1 .navigation ul.main-menu > li .mom-megamenu, .hst2 .navigation ul.main-menu > li .mom-megamenu, .hst3 .navigation ul.main-menu > li .mom-megamenu, .hst1 .navigation ul.main-menu > li.mom_mega.menu-item-depth-0 > .mom_mega_wrap, .hst2 .navigation ul.main-menu > li.mom_mega.menu-item-depth-0 > .mom_mega_wrap, .hst3 .navigation ul.main-menu > li.mom_mega.menu-item-depth-0 > .mom_mega_wrap, .hst1 ul.main-menu > li ul.sub-menu, .hst2 ul.main-menu > li ul.sub-menu, .hst3 ul.main-menu > li ul.sub-menu, .hst1 .navigation ul.main-menu > li:not(.mom_mega) ul.sub-menu, .hst2 .navigation ul.main-menu > li:not(.mom_mega) ul.sub-menu, .hst3 .navigation ul.main-menu > li:not(.mom_mega) ul.sub-menu'),
		                    //'default' => '#1e1e1e',
		                    'mode' => 'background',
		                    'validate' => 'colorrgba',
		                ),
		                array(
		                    'id' => 'nav_border_drop',
		                    'type' => 'color',
		                    'title' => __('Navigation sub-menu border', 'framework'),
		                    'output' => array('.navigation ul.main-menu > li:not(.mom_mega) ul.sub-menu, ul.main-menu li:not(.mom_mega) ul li, .navigation ul.main-menu > li .mom-megamenu, .navigation .mom-megamenu .sub-mom-megamenu ul li, .navigation ul.main-menu > li.mom_mega.menu-item-depth-0 > .mom_mega_wrap, .main-menu .mom_mega.menu-item-depth-0 > ul.sub-menu > li > a, .navigation .mom-megamenu ul li:last-child, .navigation .mom-megamenu .sub-mom-megamenu2 ul, .navigation .mom-megamenu .sub-mom-megamenu ul, .navigation .mom-megamenu .view-all-link, .hst1 ul.main-menu > li ul.sub-menu, .hst2 ul.main-menu > li ul.sub-menu, .hst3 ul.main-menu > li ul.sub-menu, .hst1 .navigation ul.main-menu > li:not(.mom_mega) ul.sub-menu, .hst2 .navigation ul.main-menu > li:not(.mom_mega) ul.sub-menu, .hst3 .navigation ul.main-menu > li:not(.mom_mega) ul.sub-menu, .hst1 .navigation ul.main-menu > li .mom-megamenu, .hst2 .navigation ul.main-menu > li .mom-megamenu, .hst3 .navigation ul.main-menu > li .mom-megamenu, .hst1 .navigation ul.main-menu > li.mom_mega.menu-item-depth-0 > .mom_mega_wrap, .hst2 .navigation ul.main-menu > li.mom_mega.menu-item-depth-0 > .mom_mega_wrap, .hst3 .navigation ul.main-menu > li.mom_mega.menu-item-depth-0 > .mom_mega_wrap'),
		                    //'default' => '#1e1e1e',
		                    'mode' => 'border-color',
		                    'validate' => 'color',
		                ),
		                array(
		                    'id' => 'nav_bg_hover_drop',
		                    'type' => 'color_rgba',
		                    'title' => __('Navigation sub-menu Background Hover', 'framework'),
		                    'output' => array('ul.main-menu li ul li:hover, .navigation .mom-megamenu ul li.active, .navigation .mom-megamenu ul li:hover, .hst1 .navigation .mom-megamenu ul li.active, .hst1 .navigation .mom-megamenu ul li:hover, .hst2 .navigation .mom-megamenu ul li.active, .hst2 .navigation .mom-megamenu ul li:hover, .hst3 .navigation .mom-megamenu ul li.active, .hst3 .navigation .mom-megamenu ul li:hover, .hst1 ul.main-menu li:not(.mom_mega) ul li:hover, .hst2 ul.main-menu li:not(.mom_mega) ul li:hover, .hst3 ul.main-menu li:not(.mom_mega) ul li:hover, .hst1 ul.main-menu li.mom_mega ul li:not(.mega_col_title):hover, .hst2 ul.main-menu li.mom_mega ul li:not(.mega_col_title):hover, .hst3 ul.main-menu li.mom_mega ul li:not(.mega_col_title):hover'),
		                    //'default' => '#1e1e1e',
		                    'mode' => 'background',
		                    'validate' => 'colorrgba',
		                ),
		                array(
			                'id' => 'notice_critical7',
			                'type' => 'info',
			                'notice' => true,
			                'style' => 'critical',
			                'icon' => 'momizat-icon-wand',
			                'title' => __('Breaking News bar Style', 'framework'),
			                'desc' => __('Breaking News bar background color and border color and news color and braking menu color', 'framework')
			            ),
		                array(
		                    'id' => 'br_bg',
		                    'type' => 'color_rgba',
		                    'title' => __('Breaking News Background', 'framework'),
		                    'output' => array('.mom-body .breaking-news, .mom-body .breaking-news .br-right'),
		                    //'default' => '#262626',
		                    'mode' => 'background',
		                    'validate' => 'colorrgba',
		                ),
		                array(
		                    'id' => 'br_border',
		                    'type' => 'color',
		                    'title' => __('Breaking News Border color', 'framework'),
		                    'output' => array('.mom-body .breaking-news, .mom-body .breaking-cont:after, .mom-body .breaking-cont'),
		                    //'default' => '#000',
		                    'mode' => 'border-right-color',
		                    'validate' => 'color',
		                ),
		                array(
		                    'id' => 'br_title_bg',
		                    'type' => 'color_rgba',
		                    'title' => __('Breaking News Title Background', 'framework'),
		                    'output' => array('.mom-body .breaking-news .breaking-title'),
		                    //'default' => '#262626',
		                    'mode' => 'background',
		                    'validate' => 'colorrgba',
		                ),
		                array(
		                    'id' => 'br_title_border',
		                    'type' => 'color',
		                    'title' => __('Breaking News Title Border', 'framework'),
		                    'output' => array('.mom-body .breaking-news .breaking-title'),
		                    //'default' => '#000',
		                    'mode' => 'border-color',
		                    'validate' => 'color',
		                ),
		                array(
		                    'id' => 'br_title',
		                    'type' => 'color',
		                    'title' => __('Breaking News Title Font color', 'framework'),
		                    'output' => array('.mom-body .breaking-news .breaking-title'),
		                    //'default' => '#fff',
		                    'mode' => 'color',
		                    'validate' => 'color',
		                ),
		                array(
		                    'id' => 'br_items',
		                    'type' => 'link_color',
		                    'title' => __('Breaking News items color', 'framework'),
		                    'output' => array('.mom-body ul.webticker li h4 a'),
		                    'active' => false,
		                    /*
'default' => array(
								'regular' => '#888888',
								'hover' => '',
								'active' => '',
							)
*/
		                ),
		                array(
		                    'id' => 'br_arrow',
		                    'type' => 'color',
		                    'title' => __('Breaking News items arrow color', 'framework'),
		                    'output' => array('.mom-body ul.webticker li span'),
		                    //'default' => '#ededed',
		                    'mode' => 'color',
		                    'validate' => 'color',
		                ),
		                array(
		                    'id' => 'br_menu',
		                    'type' => 'color',
		                    'title' => __('Breaking bar menu color', 'framework'),
		                    'output' => array('.mom-body ul.br-right li a'),
		                    //'default' => '#ededed',
		                    'mode' => 'color',
		                    'validate' => 'color',
		                ),
		                array(
		                    'id' => 'brmenu_divider',
		                    'type' => 'color',
		                    'title' => __('Breaking bar menu Divider Color', 'framework'),
		                    'output' => array('.mom-body .breaking-news .brmenu, .mom-body .breaking-news .br-right,.mom-body ul.br-right li'),
		                    //'default' => '#000',
		                    'mode' => 'border-color',
		                    'validate' => 'color',
		                ),
		                array(
		                    'id' => 'br_menu_hover',
		                    'type' => 'color',
		                    'title' => __('Breaking bar menu Background Hover', 'framework'),
		                    'output' => array('.mom-body ul.br-right li:hover, .mom-body .brmenu.active, .mom-body .breaking-news .brmenu:hover, .mom-body ul.br-right li:hover'),
		                    //'default' => '#1e1e1e',
		                    'mode' => 'background',
		                    'validate' => 'color',
		                ),
		                array(
			                'id' => 'notice_critical8',
			                'type' => 'info',
			                'notice' => true,
			                'style' => 'critical',
			                'icon' => 'momizat-icon-wand',
			                'title' => __('Boxes Style', 'framework'),
			                'desc' => __('This options works for newsboxes , scrollers , news tabs and  widgets', 'framework')
			            ),
						array(
		                    'id' => 'nb_bg',
		                    'type' => 'color_rgba',
		                    'title' => __('News Boxes Background color', 'framework'),
		                    'output' => array('.section, ul.products li .product-inner, .sidebar .widget,.secondary-sidebar .widget , .sidebar.sws2 .widget, .secondary-sidebar.sws2 .widget'),
		                    //'default' => '#fff',
		                    'mode' => 'background',
		                    'validate' => 'colorrgba',
		                ),
		                array(
		                    'id' => 'nb_border',
		                    'type' => 'color',
		                    'title' => __('News Boxes border color', 'framework'),
		                    'output' => array('.section, header.block-title, ul.products li .product-inner, .f-tabbed-head, .sidebar .widget,.secondary-sidebar .widget, .sidebar, .secondary-sidebar, .sidebar.sws2 .widget, .secondary-sidebar.sws2 .widget, .secondary-sidebar .widget-title h4, .sidebar .widget-title h4, .secondary-sidebar .widget-title h2, .sidebar .widget-title h2, .secondary-sidebar .post-list li, ul.latest-comment-list li, .sidebar .post-list li, .tagcloud a'),
		                    //'default' => '#e1e1e1',
		                    'mode' => 'border-color',
		                    'validate' => 'color',
		                ),
		                array(
		                    'id' => 'nb_header',
		                    'type' => 'color_rgba',
		                    'title' => __('News Boxes header background color', 'framework'),
		                    'output' => array('header.block-title, .f-tabbed-head, .section-header, ol.nb-tabbed-head li:hover, ul.f-tabbed-sort li:hover, .secondary-sidebar .widget-title h4, .sidebar .widget-title h4, .secondary-sidebar .widget-title h2, .sidebar .widget-title h2'),
		                    //'default' => '#e9e9e9',
		                    'mode' => 'background',
		                    'validate' => 'colorrgba',
		                ),
		                array(
		                    'id' => 'nb_title',
		                    'type' => 'color',
		                    'title' => __('News Boxes Title color', 'framework'),
		                    'output' => array('section header.block-title h2 a, section header.block-title h2, .f-tabbed-head li a, .section-header h1.section-title2 a, .section-header h1.section-title2, .section-header span.mom-sub-title, ol.nb-tabbed-head li a, .secondary-sidebar .widget-title h4, .sidebar .widget-title h4, .secondary-sidebar .widget-title h2, .sidebar .widget-title h2'),
		                    'default' => '',
		                    'mode' => 'color',
		                    'validate' => 'color',
		                ),

                        array(
                            'id' => 'nb_tabs_border',
                            'type' => 'color',
                            'title' => __('Tabs border color', 'framework'),
                            'output' => array('ol.nb-tabbed-head li, ul.f-tabbed-sort li, .f-tabbed-head li'),
                            'mode' => 'border-color',
                            'validate' => 'color',
                        ),

                        array(
                            'id' => 'nb_active_tab',
                            'type' => 'color',
                            'title' => __('Active Tab background', 'framework'),
                            'output' => array( 'background-color' => 'ol.nb-tabbed-head li.active, .f-tabbed-head li.active, .f-tabbed-head li a.current, ol.nb-tabbed-head li:hover, .f-tabbed-head li:hover, .f-tabbed-head li a:hover', 'border-top-color' => '.f-tabbed-head li:after, .f-tabbed-head li.active:after, .f-tabbed-head li a.current:after, .f-tabbed-head li:before, .f-tabbed-head li.active:before, .f-tabbed-head li a.current:before, ol.nb-tabbed-head li:before, ol.nb-tabbed-head li.active:before, ol.nb-tabbed-head li:after, ol.nb-tabbed-head li.active:after'),
                            'validate' => 'color',
                        ),

                        array(
                            'id' => 'nb_active_tab_text',
                            'type' => 'color',
                            'title' => __('Active Tab text color', 'framework'),
                            'output' => array('color' => 'ol.nb-tabbed-head li.active a , .f-tabbed-head li.active a, .f-tabbed-head li a.current, ul.f-tabbed-sort li:hover a, ol.nb-tabbed-head li:hover a'),
                            'validate' => 'color',
                        ),
		                array(
			                'id' => 'notice_critical9',
			                'type' => 'info',
			                'notice' => true,
			                'style' => 'critical',
			                'icon' => 'momizat-icon-wand',
			                'title' => __('Sidebar Style', 'framework'),
			                'desc' => __('Sidebars and widgets background color and border color', 'framework')
			            ),
						array(
		                    'id' => 'sidebar_bg',
		                    'type' => 'color_rgba',
		                    'title' => __('Sidebars Background color', 'framework'),
		                    'output' => array('.sidebar, .secondary-sidebar'),
		                    //'default' => '#fff',
		                    'mode' => 'background',
		                    'validate' => 'colorrgba',
		                ),
		                array(
		                    'id' => 'sidebar_border',
		                    'type' => 'color',
		                    'title' => __('widgets border color', 'framework'),
		                    'output' => array('.sidebar, .secondary-sidebar, .sidebar .widget,.secondary-sidebar .widget, .sidebar, .secondary-sidebar, .sidebar.sws2 .widget, .secondary-sidebar.sws2 .widget, .secondary-sidebar .widget-title h4, .sidebar .widget-title h4, .secondary-sidebar .widget-title h2, .sidebar .widget-title h2, .secondary-sidebar .post-list li, ul.latest-comment-list li, .sidebar .post-list li, .tagcloud a'),
		                    //'default' => '#e1e1e1',
		                    'mode' => 'border-color',
		                    'validate' => 'color',
		                ),
		                array(
		                    'id' => 'widget_header',
		                    'type' => 'color_rgba',
		                    'title' => __('Widget title background color', 'framework'),
		                    'output' => array('.secondary-sidebar .widget-title h4, .sidebar .widget-title h4, .secondary-sidebar .widget-title h2, .sidebar .widget-title h2'),
		                    //'default' => '#e9e9e9',
		                    'mode' => 'background',
		                    'validate' => 'colorrgba',
		                ),
		                array(
		                    'id' => 'widget_border',
		                    'type' => 'color',
		                    'title' => __('Widget title border color', 'framework'),
		                    'output' => array('.widget-title'),
		                    //'default' => '#dbdbdb',
		                    'mode' => 'border-color',
		                    'validate' => 'color',
		                ),
		                array(
		                    'id' => 'sidebar_title',
		                    'type' => 'color',
		                    'title' => __('Widgets Title color', 'framework'),
		                    'output' => array('.widget-title h4, .widget-title h2'),
		                    //'default' => '#2d2d2d',
		                    'mode' => 'color',
		                    'validate' => 'color',
		                ),
		                array(
			                'id' => 'notice_critical10',
			                'type' => 'info',
			                'notice' => true,
			                'style' => 'critical',
			                'icon' => 'momizat-icon-wand',
			                'title' => __('Footer Style', 'framework'),
			                'desc' => __('Footer background color and border color and footer font color', 'framework')
			            ),
		                array(
		                    'id' => 'footer_bg',
		                    'type' => 'background',
		                    'output' => array('footer.footer'),
		                    'title' => __('Footer Background', 'framework'),
		                    'subtitle' => __('Footer background with image, color, etc.', 'framework'),
		                ),
		                array(
							'id'=>'footer_border',
							'type' => 'border',
							'title' => __('Footer top border', 'framework'),
							'output' => array('footer.footer'),
							'border-right'=>false,
							'border-bottom'=>false,
							'border-left'=>false,
							//'default' => array('border-color' => '#1a1a1a', 'border-style' => 'solid', 'border-top'=>'5px', 'border-right'=>false, 'border-bottom'=>false, 'border-left'=>false)
						),
						array(
		                    'id' => 'footer_color',
		                    'type' => 'color',
		                    'title' => __('Footer Font color', 'framework'),
		                    'output' => array('footer.footer .footer-widget'),
		                    //'default' => '#c6c6c6',
		                    'mode' => 'color',
		                    'validate' => 'color',
		                ),
		                array(
		                    'id' => 'footer_link',
		                    'type' => 'link_color',
		                    'title' => __('Footer Links color', 'framework'),
		                    'output' => array('footer.footer .footer-widget a'),
		                    'active' => false,
		                    /*
'default' => array(
								'regular' => '#c6c6c6',
								'hover' => '',
								'active' => '',
							)
*/
		                ),
						array(
		                    'id' => 'footerw_border',
		                    'type' => 'color',
		                    'title' => __('Footer Widget border color', 'framework'),
		                    'output' => array('footer.footer .footer-widget, footer.footer .footer-widget:first-child'),
		                    //'default' => '#1a1a1a',
		                    'mode' => 'border-color',
		                    'validate' => 'color',
		                ),
		                array(
		                    'id' => 'footerw_title',
		                    'type' => 'color',
		                    'title' => __('Footer Widget title color', 'framework'),
		                    'output' => array('footer.footer .footer-widget .widget-title h4, footer.footer .footer-widget .widget-title h2'),
		                    //'default' => '#fff',
		                    'mode' => 'color',
		                    'validate' => 'color',
		                ),
		                array(
		                    'id' => 'totop_bg',
		                    'type' => 'color_rgba',
		                    'title' => __('Back to top Background', 'framework'),
		                    'output' => array('.toup'),
		                    'default' => '',
		                    'mode' => 'background',
		                    'validate' => 'colorrgba',
		                ),
		                array(
			                'id' => 'notice_critical13',
			                'type' => 'info',
			                'notice' => true,
			                'style' => 'critical',
			                'icon' => 'momizat-icon-wand',
			                'title' => __('Footer Copyright Style', 'framework'),
			                'desc' => __('Footer Copyright background color and border color and font color', 'framework')
			            ),
						array(
		                    'id' => 'copyright_bg',
		                    'type' => 'color_rgba',
		                    'title' => __('Footer Copyright Background color', 'framework'),
		                    'output' => array('.footer-bottom'),
		                    //'default' => '#000',
		                    'mode' => 'background',
		                    'validate' => 'colorrgba',
		                ),
		                array(
		                    'id' => 'copyright_color',
		                    'type' => 'color',
		                    'title' => __('Footer Copyright font color', 'framework'),
		                    'output' => array('.footer-bottom'),
		                    //'default' => '#313131',
		                    'mode' => 'color',
		                    'validate' => 'color',
		                ),
                        array(
                            'id' => 'copyright_links',
                            'type' => 'link_color',
                            'title' => __('Footer Copyright links color', 'framework'),
                            'output' => array('.footer-bottom a'),
                            'active' => false,
                            ),

		                array(
		                    'id' => 'copyright_menu_items',
		                    'type' => 'link_color',
		                    'title' => __('Footer Copyright Menu items color', 'framework'),
		                    'output' => array('ul.footer-bottom-menu > li > a'),
		                    'active' => false,
		                    /*
'default' => array(
								'regular' => '#c6c6c6',
								'hover' => '',
								'active' => '',
							)
*/
		                ),
		                array(
							'id'=>'copyright_border',
							'type' => 'border',
							'title' => __('Footer Copyright Menu bottom border', 'framework'),
							'output' => array('ul.footer-bottom-menu'),
							'border-right'=>false,
							'border-top'=>false,
							'border-left'=>false,
							//'default' => array('border-color' => '#1a1a1a', 'border-style' => 'solid', 'border-top'=>'0', 'border-right'=>'0', 'border-bottom'=>'1px', 'border-left'=>'0')
						),
						array(
		                    'id' => 'copyright_social',
		                    'type' => 'link_color',
		                    'title' => __('Footer Copyright social icons color', 'framework'),
		                    'output' => array('.footer-bottom-social li a'),
		                    /*
'default' => array(
								'regular' => '#3f3f3f',
								'hover' => '',
								'active' => '',
							)
*/
		                ),
		                array(
			                'id' => 'notice_critical12',
			                'type' => 'info',
			                'notice' => true,
			                'style' => 'critical',
			                'icon' => 'momizat-icon-wand',
			                'title' => __('Review Style', 'framework'),
			                'desc' => __('Review Box background color and border color', 'framework')
			            ),
			            array(
		                    'id' => 'rev_header_bg',
		                    'type' => 'color',
		                    'title' => __('Review Header backgorund color', 'framework'),
		                    'output' => array('.mom-reveiw-system .review-header'),
		                    'default' => '',
		                    'mode' => 'background',
		                    'validate' => 'color',
		                ),
		                array(
		                    'id' => 'rev_header_border',
		                    'type' => 'color',
		                    'title' => __('Review Header border color', 'framework'),
		                    'output' => array('.mom-reveiw-system .review-header'),
		                    'default' => '',
		                    'mode' => 'border-color',
		                    'validate' => 'color',
		                ),
		                array(
		                    'id' => 'rev_header_font',
		                    'type' => 'color',
		                    'title' => __('Review Header font color', 'framework'),
		                    'output' => array('.mom-reveiw-system .review-header h2'),
		                    'default' => '',
		                    'mode' => 'color',
		                    'validate' => 'color',
		                ),
			            array(
		                    'id' => 'rev_bg',
		                    'type' => 'color',
		                    'title' => __('Review Content backgorund color', 'framework'),
		                    'output' => array('.mom-reveiw-system .review-content'),
		                    'default' => '',
		                    'mode' => 'background',
		                    'validate' => 'color',
		                ),
		                array(
		                    'id' => 'rev_border',
		                    'type' => 'color',
		                    'title' => __('Review Content border color', 'framework'),
		                    'output' => array('.mom-reveiw-system'),
		                    'default' => '',
		                    'mode' => 'border-color',
		                    'validate' => 'color',
		                ),
		                array(
		                    'id' => 'rev_sb_bg',
		                    'type' => 'color',
		                    'title' => __('Review Score Box background', 'framework'),
		                    'output' => array('.mom-reveiw-system .review-summary .review-score'),
		                    'default' => '',
		                    'mode' => 'background',
		                    'validate' => 'color',
		                ),
		                array(
		                    'id' => 'rev_sb_border',
		                    'type' => 'color',
		                    'title' => __('Review Score Box border', 'framework'),
		                    'output' => array('.mom-reveiw-system .review-summary .review-score'),
		                    'default' => '',
		                    'mode' => 'border-color',
		                    'validate' => 'color',
		                ),
		                array(
		                    'id' => 'rev_sb_font',
		                    'type' => 'color',
		                    'title' => __('Review Score font color', 'framework'),
		                    'output' => array('.mom-reveiw-system .review-summary .review-score .score'),
		                    'default' => '',
		                    'mode' => 'color',
		                    'validate' => 'color',
		                ),
		                array(
		                    'id' => 'rev_foot_bg',
		                    'type' => 'color',
		                    'title' => __('Review Footer backgorund color', 'framework'),
		                    'output' => array('.mom-reveiw-system .review-footer'),
		                    'default' => '',
		                    'mode' => 'background',
		                    'validate' => 'color',
		                ),
		                array(
		                    'id' => 'rev_foot_border',
		                    'type' => 'color',
		                    'title' => __('Review Footer border color', 'framework'),
		                    'output' => array('.mom-reveiw-system .review-footer'),
		                    'default' => '',
		                    'mode' => 'border-color',
		                    'validate' => 'color',
		                ),
				)
            );

            //background settings
            $this->sections[] = array(
                'title' => __('Background settings', 'framework'),
				'desc' => __('', 'framework'),
				'icon' => 'momizat-icon-image2',
				'subsection' => true,
			    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
				'fields' => array(
					array(
		                    'id' => 'body_background',
		                    'type' => 'background',
		                    'output' => array('body'),
		                    'title' => __('Body Background', 'framework'),
		                    'subtitle' => __('Body background with image, color, etc.', 'framework'),
		                ),
		                array(
			                'id' => 'notice_critical1323',
			                'type' => 'info',
			                'notice' => true,
			                'style' => 'critical',
			                'icon' => 'momizat-icon-wand',
			                'title' => __('Background slider', 'framework'),
			                'desc' => __('Background slider Options', 'framework')
			            ),
		                array (
							'id' => 'bg_slider',
							'desc' => __('Enable Background slider and upload your images', 'framework'),
							'type' => 'switch',
							'title' => __('Background Slider', 'framework'),
							'default' => false,
							'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),
						array(
							'id'=>'bg_slider_img',
							'type' => 'slides',
							'title' => __('Background slides Options', 'framework'),
							'desc' => __('Upload your background slides images.', 'framework'),
							'required' => array('bg_slider','=',1),
						),
						array(
							'id'=>'bg_slider_dur',
							'type' => 'slider',
							'title' => __('Duration', 'framework'),
							'desc'=> __('The amount of time in between slides', 'framework'),
							"default" 		=> "5000",
							"min" 		=> "1000",
							"step"		=> "500",
							"max" 		=> "10000",
							'required' => array('bg_slider','=',1),
						),
						array(
			                'id' => 'notice_critical1333',
			                'type' => 'info',
			                'notice' => true,
			                'style' => 'critical',
			                'icon' => 'momizat-icon-wand',
			                'title' => __('Background Ads', 'framework'),
			                'desc' => __('Background Ads Options', 'framework')
			            ),
		                array (
							'id' => 'bg_ads',
							'desc' => __('Use the Background as ad', 'framework'),
							'type' => 'switch',
							'title' => __('Background Ad', 'framework'),
							'default' => false,
							'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),
						array(
							'id'=>'bg_ads_url',
							'type' => 'text',
							'title' => __('Background ad link', 'framework'),
							'validate' => 'url',
							'required' => array('bg_ads','=','1'),
							'default' => ''
						),
						array(
							'id'=>'bg_ads_h',
							'type' => 'dimensions',
							'width' => false,
							'units' => array('px', '%'),
							'units_extended' => 'true', // Allow users to select any type of unit
							'title' => __('Background (Height) Option', 'framework'),
							'desc' => __('Choose Background Ad Height Default 1200px.', 'framework'),
							'required' => array('bg_ads','=','1'),
							'default' => array('height'=>'1200', )
						),
						array(
			                'id' => 'notice_critical134',
			                'type' => 'info',
			                'notice' => true,
			                'style' => 'critical',
			                'icon' => 'momizat-icon-wand',
			                'title' => __('Fixed Background', 'framework'),
			                'desc' => __('Fixed Background color', 'framework')
			            ),
						array(
		                    'id' => 'bg-fixed',
		                    'type' => 'background',
		                    'title' => __('Fixed Wrap Background Color', 'framework'),
		                    'output' => array('.fixed, .fixed2'),
		                    //'default' => '#f2f2f2',
		                    'mode' => 'background',
		                    //'validate' => 'colorrgba',
		                ),
				)
            );


            //custom css settings
            $this->sections[] = array(
                'title' => __('Custom CSS', 'framework'),
				'desc' => __('', 'framework'),
				'icon' => 'momizat-icon-code',
				'subsection' => true,
			    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
				'fields' => array(
					array(
                        'id'        => 'custom_css',
                        'type'      => 'ace_editor',
                        'title'     => __('Custom CSS', 'framework'),
                        'subtitle'  => __('Paste your CSS code here.', 'redux-framework-demo'),
                        'mode'      => 'css',
                        'theme'     => 'monokai',
                    ),
				)
            );

            //typoghraphy
            $this->sections[] = array(
                'title' => __('Typography', 'framework'),
				'desc' => __('', 'framework'),
				'icon' => 'momizat-icon-text-height',
			    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
				'fields' => array(
						array(
		                    'id' => 'main_font',
		                    'type' => 'typography',
		                    'title' => __('Main Font Family', 'framework'),
		                    //'compiler'      => true,  // Use if you want to hook in your own CSS compiler
	                        'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
	                        'font-backup'   => true,    // Select a backup non-google font in addition to a google font
	                        'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
	                        //'subsets'       => false, // Only appears if google is true and subsets not set to false
	                        'font-size'     => false,
	                        'line-height'   => false,
                            'fonts' => $mfonts,
	                        'text-align'  =>   false,
	                        //'word-spacing'  => true,  // Defaults to false
	                        //'letter-spacing'=> true,  // Defaults to false
	                        'color'         => false,
	                        //'preview'       => false, // Disable the previewer
	                        'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
		                    'output' => array('ul.top-menu li,ul.top-social-icon li.top-search div input, ul.main-menu li, .breaking-news .breaking-title,.section-header, footer.show-more a, .def-slider-desc, .f-tabbed-head li a,.scroller ul li .entry-meta, .secondary-sidebar .post-list li .read-more-link,.widget-tab .post-list li .entry-meta, .tagcloud a, .sidebar .social-counter,ul.widget-tabbed-header li a, ul.latest-comment-list li cite, ul.latest-comment-list li .ctime,.login-widget input[type="text"], .login-widget input[type="password"],input[type="button"], input[type="reset"], input[type="submit"],input[type="email"], .login-pwd-wrap span, .login-widget .login-button,ul.login-links li a, .login-widget label, .first-weather .weather-date,.first-weather .weather-result span, .w-item-title, .w-item-content ul li,.poll-widget ul li .poll-title, .poll-widget p, .poll-widget ul li small,.poll-widget ul li button.poll-vote, ul.twiter-list, .sidebar .widget_categories,.sidebar .widget_archive, .secondary-sidebar .widget_categories,.search-form .search-field, .footer .newsletter .nsf, .footer .newsletter .nsb,footer.footer, .footer-menu, .footer-bottom, ol.nb-tabbed-head li a,.nb2 ul li.show-more a, .cat-slider-nav-title, .cat-slider-pop, .entry-crumbs,.entry-content-data .story-highlights ul li, .entry-tag-links, .mom-share-buttons a,.mom-share-post .sh_arrow, .post-nav-links, .author-bio-name a, .comment-list .single-comment cite,.comment-list .single-comment time, .comment-list .single-comment .comment-reply-link,.media-sort-title, .media-cat-filter li, .weather-switch-tabs a, .t-w-title .weather-date,.weather-results-status, .find-weather-box, .adv-search-form label,.adv-search-form .submit, .ajax-search-results a, .mom-megamenu .view-all-link,.widget_pages li, .widget_meta li, .widget_recent_comments li, .widget_recent_entries li,.widget_rss li, .span.blog-timeline-date, .blog-timeline-more, .user-login-links li a,.nsd, .mom-reveiw-system .review-header h2, .today_date, a.read-more,button, .pagination, h1, h2, h3, h4, h5, h6, input[type="text"], textarea,select, .not-valid-city, .entry-content blockquote, ul.mom_tabs li a,.media-cat-filter li, .widget_archive li, .widget_nav_menu ul a, .mobile-menu li a,.device-menu-holder, #navigation .device-menu li.menu-item > a, .section-header h1.section-title2,section-header span.mom-sub-title, .mom-reveiw-system .review-circle .circle .val,.mom-reveiw-system .review-circles .review-circle, .mom-reveiw-system .score-wrap .review-circle,.review-footer .total-votes, .rs-smaller_than_default.mom-reveiw-system .stars-cr,.review-summary .review-score .score-wrap.stars-score .score-title,.mom-reveiw-system .review-summary .review-score .score, .rs-smaller_than_default.mom-reveiw-system .mom-bar .mb-inner .cr,.mom-reveiw-system .mom-bar .mb-score, .mom-reveiw-system .review-summary .review-score .score-wrap,footer.author-box-footer span, .weather-switch-tabs label, .main_tabs .tabs a,.wp-caption-text, th, .bbp-forum-info, .bbp-forums li, #bbpress-forums .mom-bbp-content,.bbp-topics li, .bbp-pagination, .mom-main-font, .widget_display_stats,#buddypress div.item-list-tabs ul, #buddypress button, #buddypress a.button,#buddypress input[type=submit], #buddypress input[type=button], #buddypress input[type=reset],#buddypress ul.button-nav li a, #buddypress div.generic-button a, #buddypress .comment-reply-link,a.bp-title-button, #buddypress .activity-list li.load-more, #buddypress .activity-list li.load-newest,.widget.buddypress ul.item-list, .bp-login-widget-user-links, .vid-box-nav li h2,.chat-author, .photo-credit, .wp-polls-form,.secondary-sidebar .social-counter li, .mom-members, .feature-cat-slider .cat-label, widget-tabbed-body, .numbers_bullets .def-slider .owl-dots > div, .cat_num, .mom_cat_link'), // An array of CSS selectors to apply this font style to dynamically
		                    'subtitle' => __('Select Main Font Family in theme default : Archivo Narrow', 'framework'),
						),
						array(
		                    'id' => 'sec_font',
		                    'type' => 'typography',
		                    'title' => __('Secondary Font Family', 'framework'),
		                    //'compiler'      => true,  // Use if you want to hook in your own CSS compiler
	                        'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
	                        'font-backup'   => true,    // Select a backup non-google font in addition to a google font
	                        'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
	                        //'subsets'       => false, // Only appears if google is true and subsets not set to false
	                        'font-size'     => false,
	                        'line-height'   => false,
                            'fonts' => $mfonts,
	                        'text-align'  =>   false,
	                        //'word-spacing'  => true,  // Defaults to false
	                        //'letter-spacing'=> true,  // Defaults to false
	                        'color'         => false,
	                        //'preview'       => false, // Disable the previewer
	                        'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
		                    'output' => array('
		                    body
							.mom-megamenu .sub-mom-megamenu2 ul li h2 a,
							.mom-megamenu .sub-mom-megamenu ul li h2 a,
							ul.webticker li h4,
							.entry-meta a,
							.entry-meta,
							.review-widget li .rev-title,
							.review-widget li small,
							.widget_rss .rss-date'),
		                    'subtitle' => __('Select Secondary and body Font Family in theme default : Arial, Helvetica, sans-serif', 'framework'),
						),

		                array(
		                    'id' => 'body-typo',
		                    'type' => 'typography',
		                    'title' => __('Body Typography', 'framework'),
		                    'google' => true,
		                    'text-align' =>false,
                            'fonts' => $mfonts,
		                    'output' => 'body, article .entry-content',
		                ),

		                array(
		                    'id' => 'entry-typo',
		                    'type' => 'typography',
		                    'title' => __('Post Content Typography', 'framework'),
		                    'google' => true,
		                    'text-align' =>false,
                            'fonts' => $mfonts,
		                    'output' => 'article .entry-content p, article .entry-content',
		                ),

		                array(
		                    'id' => 'entry-blockquote',
		                    'type' => 'typography',
		                    'title' => __('blockquote Typography', 'framework'),
		                    'google' => true,
		                    'text-align' =>false,
                            'fonts' => $mfonts,
		                    'output' => '.entry-content blockquote',
		                ),

		                array(
		                    'id' => 'entry-forms',
		                    'type' => 'typography',
		                    'title' => __('Forms and Inputs', 'framework'),
		                    'google' => true,
		                    'text-align' =>false,
                            'fonts' => $mfonts,
		                    'output' => 'input, input[type="text"], textarea, select',
		                ),

		                array(
		                    'id' => 'mmenu-typo',
		                    'type' => 'typography',
		                    'title' => __('Main Menu Typography', 'framework'),
		                    'google' => true,
		                    'text-align' =>false,
                            'fonts' => $mfonts,
		                    'output' => 'ul.main-menu > li',
		                ),

		                array(
		                    'id' => 'tmenu-typo',
		                    'type' => 'typography',
		                    'title' => __('Top Menu Typography', 'framework'),
		                    'google' => true,
		                    'text-align' =>false,
                            'fonts' => $mfonts,
		                    'output' => 'ul.top-menu li',
		                ),

						array(
		                    'id' => 'nph-typo',
		                    'type' => 'typography',
		                    'title' => __('New boxes title Typography', 'framework'),
		                    'google' => true,
		                    'text-align' =>false,
                            'fonts' => $mfonts,
		                    'output' => 'header.block-title h2 a, header.block-title h2, .section-header h2.section-title a, .section-header h2.section-title',
		                ),

		                array(
		                    'id' => 'wit-typo',
		                    'type' => 'typography',
		                    'title' => __('Widgets title Typography', 'framework'),
		                    'google' => true,
		                    'text-align' =>false,
                            'fonts' => $mfonts,
		                    'output' => '.widget-title h4, .widget-title h2',
		                ),

						array(
			                'id' => 'notice_critical11',
			                'type' => 'info',
			                'notice' => true,
			                'style' => 'critical',
			                'icon' => 'momizat-icon-font',
			                'title' => __('Entry Headings', 'framework'),
			                'desc' => __('Entry Headings in posts', 'framework')
			            ),

		                array(
		                    'id' => 'h1-font',
		                    'type' => 'typography',
		                    'title' => __('H1', 'framework'),
		                    'subtitle' => __('Specify the Heading font properties.', 'framework'),
		                    'google' => true,
		                    'text-align' =>false,
                            'fonts' => $mfonts,
		                    'output' => '.entry-content h1',
		                    'default' => array(
		                        'color' => '',
		                        'font-size' => '',
		                        'font-family' => '',
		                        'font-weight' => '',
		                    ),
		                ),

		                array(
		                    'id' => 'h2-font',
		                    'type' => 'typography',
		                    'title' => __('H2', 'framework'),
		                    'subtitle' => __('Specify the Heading font properties.', 'framework'),
		                    'google' => true,
		                    'text-align' =>false,
                            'fonts' => $mfonts,
		                    'output' => '.entry-content h2',
		                    'default' => array(
		                        'color' => '',
		                        'font-size' => '',
		                        'font-family' => '',
		                        'font-weight' => '',
		                    ),
		                ),

		                array(
		                    'id' => 'h3-font',
		                    'type' => 'typography',
		                    'title' => __('H3', 'framework'),
		                    'subtitle' => __('Specify the Heading font properties.', 'framework'),
		                    'google' => true,
		                    'text-align' =>false,
                            'fonts' => $mfonts,
		                    'output' => '.entry-content h3',
		                    'default' => array(
		                        'color' => '',
		                        'font-size' => '',
		                        'font-family' => '',
		                        'font-weight' => '',
		                    ),
		                ),

		                array(
		                    'id' => 'h4-font',
		                    'type' => 'typography',
		                    'title' => __('H4', 'framework'),
		                    'subtitle' => __('Specify the Heading font properties.', 'framework'),
		                    'google' => true,
		                    'text-align' =>false,
		                    'output' => '.entry-content h4',
		                    'default' => array(
		                        'color' => '',
		                        'font-size' => '',
		                        'font-family' => '',
		                        'font-weight' => '',
		                    ),
		                ),

		                array(
		                    'id' => 'h5-font',
		                    'type' => 'typography',
		                    'title' => __('H5', 'framework'),
		                    'subtitle' => __('Specify the Heading font properties.', 'framework'),
		                    'google' => true,
		                    'text-align' =>false,
                            'fonts' => $mfonts,
		                    'output' => '.entry-content h5',
		                    'default' => array(
		                        'color' => '',
		                        'font-size' => '',
		                        'font-family' => '',
		                        'font-weight' => '',
		                    ),
		                ),


		                array(
		                    'id' => 'h6-font',
		                    'type' => 'typography',
		                    'title' => __('H6', 'framework'),
		                    'subtitle' => __('Specify the Heading font properties.', 'framework'),
		                    'google' => true,
		                    'text-align' =>false,
		                    'output' => '.entry-content h6',
                            'fonts' => $mfonts,
		                    'default' => array(
		                        'color' => '',
		                        'font-size' => '',
		                        'font-family' => '',
		                        'font-weight' => '',
		                    ),
		                ),

					),
            );

            //footer settings
            $this->sections[] = array(
                'title' => __('Footer Settings', 'framework'),
				'desc' => __('', 'framework'),
				'icon' => 'momizat-icon-storage',
			    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
				'fields' => array(
						array(
						'id'=>'widgets_footer',
						'type' => 'switch',
						'title' => __('Footer widgets', 'framework'),
						"default" 		=> 1,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),

						array (
						'desc' => __('Select footer layout', 'framework'),
						'id' => 'foot_layout',
						'type' => 'image_select',
						'options' => array (
							'one' => $imgpath . '/footer/1.png',
							'one_half' => $imgpath . '/footer/2.png',
							'third' => $imgpath . '/footer/3.png',
							'fourth' => $imgpath . '/footer/4.png',
							'fifth' => $imgpath . '/footer/5.png',
							'sixth' => $imgpath . '/footer/6.png',
							'half_twop' => $imgpath . '/footer/half_twop.png',
							'twop_half' => $imgpath . '/footer/twop_half.png',
							'half_threep' => $imgpath . '/footer/half_threep.png',
							'threep_half' => $imgpath . '/footer/threep_half.png',
							'third_fourp' => $imgpath . '/footer/third_fourp.png',
							'fourp_third' => $imgpath . '/footer/fourp_third.png'
						),
						'title' => __('Footer layout', 'framework'),
						'default' => 'fourth',
						'required' => array('widgets_footer', '=' , 1),
						),

						array(
						'id'=>'cat_footer_menu',
						'type' => 'switch',
						'title' => __('full width Footer Menu', 'framework'),
						"default" 		=> 0,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),

						array(
						'id'=>'bottom_footer',
						'type' => 'switch',
						'title' => __('Copyright Footer', 'framework'),
						"default" 		=> 1,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),

						array(
						'id'=>'footer_logo',
						'type' => 'switch',
						'title' => __('Footer Logo', 'framework'),
						"default" => 1,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),

						array(
						'id'=>'foot_logo',
						'type' => 'media',
						'title' => __('Upload your Footer logo image', 'framework'),
						'url'=> true,
						'default'=>array('url'=> $themeimgpath.'footer-logo.png'),
						),

						array(
						'id'=>'foot_retina_logo',
						'type' => 'media',
						'title' => __('Upload your Footer retina logo image', 'framework'),
						'url'=> true,
						'default'=> 0,
						),

						array(
						'id'=>'foote_retina_logo_size',
						'type' => 'dimensions',
						'title' => __('Orginal Logo Size', 'framework'),
						'desc' => __('default logo size (Width/Height)', 'framework'),
						'default' => array('width' => '195', 'height'=> '46', )
						),

						array(
						'id'=>'copyright_menu',
						'type' => 'switch',
						'title' => __('Copyright Menu', 'framework'),
						"default" => 1,
						'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
						),

						array(
						'id'=>'footer-text',
						'type' => 'editor',
						'title' => __('Footer Text', 'framework'),
						'default' => 'Copyright © 2014 by Multi NEWS. Proudly powered by WordPress.',
						),

				)
            );


            //API settings
            $this->sections[] = array(
                'title' => __('API\'s Authentication', 'framework'),
				'desc' => __('', 'framework'),
				'icon' => 'momizat-icon-key',
			    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
				'fields' => array(
                        array(
                            'id' => 'notice_critical3ff4f5',
                            'type' => 'info',
                            'notice' => true,
                            'style' => 'critical',
                            'icon' => 'momizat-icon-facebook',
                            'title' => __('Facebook (required for social counter widget)', 'framework'),
                            'desc' => __('to get Facebook access token <a href="https://smashballoon.com/custom-facebook-feed/access-token/" target="_blank">Follow this</a>', 'framework')
                        ),
                        array (
                                'id' => 'facebook_access_token',
                                'type' => 'text',
                                'title' => __('Facebook access token', 'framework'),
                        ),

						array(
		                        'id' => 'notice_critical',
		                        'type' => 'info',
		                        'notice' => true,
		                        'style' => 'critical',
		                        'icon' => 'momizat-icon-twitter',
		                        'title' => __('Twitter API (required for using twitter widgets and social counters widget)', 'framework'),
		                        'desc' => __('You can get twitter Authentication data by following this <a href="http://www.youtube.com/watch?v=zdSHhiHAxBA" target="_blank">tutorial</a>.', 'framework')
		                    ),
						array (
							'id' => 'twitter_ck',
							'type' => 'text',
							'title' => 'API key',
						),
						array (
							'id' => 'twitter_cs',
							'type' => 'text',
							'title' => 'API secret',
						),
						array (
							'id' => 'twitter_at',
							'type' => 'text',
							'title' => 'Access token',
						),
						array (
							'id' => 'twitter_ats',
							'type' => 'text',
							'title' => 'Access token secret',
						),
						array(
		                    'id' => 'notice_critical344',
		                    'type' => 'info',
		                    'notice' => true,
		                    'style' => 'critical',
		                    'icon' => 'momizat-icon-mail3',
		                    'title' => __('Mailchimp (required for using newsletter widget)', 'framework'),
		                    'desc' => __('To find your API key <a href="http://kb.mailchimp.com/article/where-can-i-find-my-api-key" target="_blank">Click here</a>.', 'framework')
		                ),
		                array (
							'id' => 'mailchimp_api_key',
							'type' => 'text',
							'title' => 'Mailchimp API Key',
						),
						array(
		                    'id' => 'notice_critical345',
		                    'type' => 'info',
		                    'notice' => true,
		                    'style' => 'critical',
		                    'icon' => 'momizat-icon-google-plus',
		                    'title' => __('Google+ (required for using social counter widget)', 'framework'),
		                    'desc' => __('to get Google+ API key <a href="http://www.youtube.com/watch?v=-wPKcfEadAc" target="_blank">Follow this</a>', 'framework')
		                ),
		                array (
		                        'id' => 'googlep_api_key',
		                        'type' => 'text',
		                        'title' => __('Google+ API Key', 'framework'),
		                ),

                        array(
                            'id' => 'notice_critical34f5',
                            'type' => 'info',
                            'notice' => true,
                            'style' => 'critical',
                            'icon' => 'momizat-icon-youtube',
                            'title' => __('Youtube (required for get video duration in media page and youtube count in social counter widget)', 'framework'),
                            'desc' => __('to get Youtube API key <a href="https://www.youtube.com/watch?v=Im69kzhpR3I" target="_blank">Follow this</a>', 'framework')
                        ),
                        array (
                                'id' => 'youtube_api_key',
                                'type' => 'text',
                                'title' => __('Youtube API Key', 'framework'),
                        ),

						array(
		                    'id' => 'notice_critical346',
		                    'type' => 'info',
		                    'notice' => true,
		                    'style' => 'critical',
		                    'icon' => 'momizat-icon-soundcloud',
		                    'title' => __('Sound Cloud (required for using social counter widget)', 'framework'),
		                    'desc' => __('in documentation.', 'framework')
		                ),
		                 array (
		                        'id' => 'soundcloud_client_id',
		                        'type' => 'text',
		                        'title' => __('Sound Cloud Client ID', 'framework'),
		                ),
		                array(
		                    'id' => 'notice_critical347',
		                    'type' => 'info',
		                    'notice' => true,
		                    'style' => 'critical',
		                    'icon' => 'el-icon-behance',
		                    'title' => __('Behace (required for using social counter widget)', 'framework'),
		                    'desc' => __('in documentation.', 'framework')
		                ),
		                array (
		                        'id' => 'behance_api_key',
		                        'type' => 'text',
		                        'title' => __('Behance API key', 'framework'),
		                ),
						array(
		                    'id' => 'notice_critical348',
		                    'type' => 'info',
		                    'notice' => true,
		                    'style' => 'critical',
		                    'icon' => 'momizat-icon-instagram',
		                    'title' => __('Instagram (required for using social counter widget)', 'framework'),
		                    'desc' => __('<a href="http://www.pinceladasdaweb.com.br/instagram/access-token" target="_blank">Click Here</a> To get the Access Token.', 'framework')
		                ),
			            array (
			                    'id' => 'instagram_access_token',
			                    'type' => 'text',
			                    'title' => __('Instagram Access Token', 'framework'),
			            ),

                    array(
                        'id' => 'auth_weather_info',
                        'type' => 'info',
                            'notice' => true,
                            'style' => 'critical',
                        'icon' => 'fa-icon-cloud',
                        'title' => __('Weather Api key (required for using Weather widget)', 'framework'),
                        'desc' => __('Login into <a href="http://home.openweathermap.org/" target="_blank">Open Weather Map</a> and get API key from your home', 'framework'),
                    ),

                    array (
                            'id' => 'weather_api_key',
                            'type' => 'text',
                            'title' => __('Weather API key', 'framework'),
                    ),
				)
            );

            $this->sections[] = array(
                'title' => __('Mobile settings', 'framework'),
                'desc' => __('A lot of fun will be here in Version 3.0', 'framework'),
                'icon' => 'momizat-icon-mobile',
                'fields' => array(
                        array(
                        'id'=>'hide_sidebars_in_mobiles',
                        'type' => 'switch',
                        'title' => __('Hide sidebars widgets in Mobiles', 'framework'),
                        'desc' => __('this will make theme faster in mobile just if you don\'t need the sidebars widgets', 'framework'),
                        "default" => 0,
                        'on'        => __('Yes', 'framework'),
                        'off'       => __('No', 'framework')
                        ),
                                                array(
                        'id'=>'hide_footer_in_mobiles',
                        'type' => 'switch',
                        'title' => __('Hide footer widgets in Mobiles', 'framework'),
                        'desc' => __('this will make theme faster in mobile just if you don\'t need the footer widgets', 'framework'),
                        "default" => 0,
                        'on'        => __('Yes', 'framework'),
                        'off'       => __('No', 'framework')
                        ),
                )
            );

            //Speed
            $this->sections[] = array(
                'title' => __('Speed Up', 'framework'),
                'desc' => __('', 'framework'),
                'icon' => 'momizat-icon-support',
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields' => array(
                    /*
                        array(
                        'id'=>'photon',
                        'type' => 'switch',
                        'title' => __('Enable Photon', 'framework'),
                        'desc' => __('Photon is a free image CDN service, By caching your image and served from WordPress.com, your site could be running faster, Don\'t use this option if you using another CDN.<p>Important Note: Photon is a free image CDN service but it doesn’t mean you can abuse or violate WordPress.con <a href="http://en.wordpress.com/tos/" target="_blank">TOC</a>.</p>', 'framework'),
                        "default" => 0,
                        'on'        => __('Enable', 'framework'),
                        'off'       => __('Disable', 'framework')
                        ),
                        */
                        array(
                            'id' => 'notice_critical33D4',
                            'type' => 'info',
                            'notice' => true,
                            'style' => 'critical',
                            'icon' => '',
                            'title' => __('<h3>Need More speed ?</h3>', 'framework'),
                            'desc' => __('<ol><li>Choose a good host</li><li>Optimize your homepage to load quickly, Reduce the number of posts and modules on the page</li><li>Use an effective caching plugin like <a href="http://wordpress.org/extend/plugins/w3-total-cache/">W3 Total Cache</a> and <a href="http://wordpress.org/extend/plugins/db-cache/">DB Cache</a> to cache the database query result</li><li>Optimize images (automatically) using <a href="http://wordpress.org/extend/plugins/wp-smushit/">WP-SmushIt</a></li><li>Optimize your WordPress database using <a href="http://wordpress.org/extend/plugins/wp-optimize/installation/">WP-Optimize</a></li><li>Compress and Combine JS and CSS Files using <a href="http://wordpress.org/extend/plugins/wp-minify/">Wp Minify</a></li><li>Add LazyLoad to your images using this plugin <a href="http://wordpress.org/extend/plugins/jquery-image-lazy-loading/">jQuery Image Lazy Load</a></li><li>Enable Gzip File Compression</li><li>Add an expires header to static resources <p>Place this code in your root .htaccess file:</p><pre><IfModule mod_expires.c>
 ExpiresActive on

# Perhaps better to whitelist expires rules? Perhaps.
 ExpiresDefault      "access plus 1 month"

# cache.appcache needs re-requests
# in FF 3.6 (thx Remy ~Introducing HTML5)
 ExpiresByType text/cache-manifest "access plus 0 seconds"

# Your document html
 ExpiresByType text/html "access plus 0 seconds"

# Data
 ExpiresByType text/xml "access plus 0 seconds"
 ExpiresByType application/xml "access plus 0 seconds"
 ExpiresByType application/json "access plus 0 seconds"

# RSS feed
 ExpiresByType application/rss+xml "access plus 1 hour"

# Favicon (cannot be renamed)
 ExpiresByType image/x-icon "access plus 1 week"

# Media: images, video, audio
 ExpiresByType image/gif "access plus 1 month"
 ExpiresByType image/png "access plus 1 month"
 ExpiresByType image/jpg "access plus 1 month"
 ExpiresByType image/jpeg "access plus 1 month"
 ExpiresByType video/ogg "access plus 1 month"
 ExpiresByType audio/ogg "access plus 1 month"
 ExpiresByType video/mp4 "access plus 1 month"
 ExpiresByType video/webm "access plus 1 month"

# HTC files  (css3pie)
 ExpiresByType text/x-component "access plus 1 month"

# Webfonts
 ExpiresByType font/truetype "access plus 1 month"
 ExpiresByType font/opentype "access plus 1 month"
 ExpiresByType application/x-font-woff   "access plus 1 month"
 ExpiresByType image/svg+xml "access plus 1 month"
 ExpiresByType application/vnd.ms-fontobject "access plus 1 month"

# CSS and JavaScript
 ExpiresByType text/css "access plus 1 year"
 ExpiresByType application/javascript "access plus 1 year"
 ExpiresByType text/javascript "access plus 1 year"

 <IfModule mod_headers.c>
  Header append Cache-Control "public"
 </IfModule>
</IfModule></pre></li><li>Disable ETags<p>Place this code in your root .htaccess file:</p><pre>Header unset ETag
FileETag None</pre></li></ol>', 'framework')
                        ),
                    ),
            );



			$this->sections[] = array(
                'type' => 'divide',
            );

            $this->sections[] = array(
                    'icon' => 'el-icon-website',
                    'title' => __('Demo Import', 'framework'),
                    'desc' => __('if you need a quick start or a new to wordpress this section will help your get our demo with one click', 'framework'),
                    'class' => 'demo-import-section',
                    'fields' => array(
                            array(
                                'id'        => 'theme_demo_import',
                                'type'      => 'callback',
                                'title'     => __('Import Demo Content', 'framework'),
                                'callback'  => 'mom_mn_import_demo'
                            ),

                    )
            );
            $this->sections[] = array(
                'title'     => __('Import / Export', 'framework'),
                'desc'      => __('Import and Export your Redux Framework settings from file, text or URL.', 'framework'),
                'icon'      => 'el-icon-refresh',
                'fields'    => array(
                    array(
                        'id'            => 'opt-import-export',
                        'type'          => 'import_export',
                        'title'         => 'Import Export',
                        'subtitle'      => 'Save and restore your Redux options',
                        'full_width'    => false,
                    ),
                ),
            );

        }

        public function setHelpTabs() {
        }

    }

    global $reduxConfig;
    $reduxConfig = new Redux_Framework_multinews_config();

}

/**
  Custom function for the callback referenced above
 */
if (!function_exists('admin_folder_my_custom_field')):
    function admin_folder_my_custom_field($field, $value) {
        print_r($field);
        echo '<br/>';
        print_r($value);
    }
endif;


/**
  Custom function for the callback validation referenced above
 * */
if (!function_exists('admin_folder_validate_callback_function')):
    function admin_folder_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        $value = 'just testing';

        /*
          do your validation

          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;
            $field['msg'] = 'your custom error message';
          }
         */

        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }
endif;
/* Momizat rtl */
if ( is_rtl() ) {
function addrtlCSS() {
    wp_register_style(
        'redux-rtl-custom-css',
        MOM_URI . '/framework/admin/momizat/rtl.css',
        array( 'redux-css' ),
        time(),
        'all'
    );
    wp_enqueue_style('redux-rtl-custom-css');
}
// This example assumes your opt_name is set to redux_demo, replace with your opt_name value
add_action( 'redux/page/mom_options/enqueue', 'addrtlCSS' );
}


/**
  Custom Momizat style
 * */
function addPanelCSS() {
    wp_register_style(
        'redux-custom-css',
        MOM_URI . '/framework/admin/custom.css',
        array( 'redux-css' ), // Be sure to include redux-css so it's appended after the core css is applied
        time(),
        'all'
    );
    wp_enqueue_style('redux-custom-css');
}
// This example assumes your opt_name is set to redux_demo, replace with your opt_name value
add_action( 'redux/page/mom_options/enqueue', 'addPanelCSS' );

/**
  Custom Momizat scripts
 * */
function momizatCustomScripts() {
    wp_register_style(
        'momizat-options-css',
        MOM_URI . '/framework/admin/momizat/momizat.css',
        '', // Be sure to include redux-css so it's appended after the core css is applied
        time(),
        'all'
    );
    wp_enqueue_style('momizat-options-css');

    wp_register_script(
        'momizat-options-js',
        MOM_URI . '/framework/admin/momizat/momizat.js',
        array( 'jquery' ), // Be sure to include redux-css so it's appended after the core css is applied
        time(),
        'all'
    );
    wp_enqueue_script('momizat-options-js');
}
// This example assumes your opt_name is set to redux_demo, replace with your opt_name value
add_action( 'redux/page/mom_options/enqueue', 'momizatCustomScripts' );

if (!function_exists('mom_mn_import_demo')):
    function mom_mn_import_demo() { ?>

    <div class="mom_demo_import_wrap">
        <div class="mom_demo_import_item">
            <a href="#" class="run-demo-content demo-item-image" data-dir="ltr"><span class="demo_loading loading"></span><div class="bt"><span><?php _e('Click to import', 'theme'); ?></span></div><span class="import_warning"><?php _e('Do not close this page!','theme'); ?></span><img src="<?php echo MOM_URI; ?>/framework/admin/images/demo/default.png"></a>
            <div class="mom_demo_import_item_details">
                <p><strong><?php _e('what you get:', 'theme'); ?></strong> <a href="http://themes.momizat.com/multinews/" target="_blank"><?php _e('Online Demo'); ?></a></p>

                <h4><?php _e('Recommended Plugins:', 'theme'); ?> </h4>
                <ul>
                    <li><a href="https://wordpress.org/plugins/buddypress/" target="_blank">Buddypress</a> - <?php _e('for community function', 'theme'); ?> </li>
                    <li><a href="https://wordpress.org/plugins/bbpress/" target="_blank">bbpress</a> - <?php _e('for forums function', 'theme'); ?> </li>
                    <li><a href="https://wordpress.org/plugins/woocommerce/" target="_blank">Woocommerce</a> - <?php _e('for online shop function', 'theme'); ?> </li>
                </ul>
            </div>
        </div>

        <div class="mom_demo_import_item">
            <a href="#" class="run-demo-content demo-item-image" data-dir="rtl"><span class="demo_loading loading"></span><div class="bt"><span><?php _e('Click to import', 'theme'); ?></span></div><span class="import_warning"><?php _e('Do not close this page!','theme'); ?></span><img src="<?php echo MOM_URI; ?>/framework/admin/images/demo/rtl.png"></a>
            <div class="mom_demo_import_item_details">
                <p><strong><?php _e('what you get:', 'theme'); ?></strong> <a href="http://themes.momizat.com/multinews-rtl/" target="_blank"><?php _e('RTL Demo'); ?></a></p>

                <h4><?php _e('Recommended Plugins:', 'theme'); ?> </h4>
                <ul>
                    <li><a href="https://wordpress.org/plugins/buddypress/" target="_blank">Buddypress</a> - <?php _e('for community function', 'theme'); ?> </li>
                    <li><a href="https://wordpress.org/plugins/bbpress/" target="_blank">bbpress</a> - <?php _e('for forums function', 'theme'); ?> </li>
                    <li><a href="https://wordpress.org/plugins/woocommerce/" target="_blank">Woocommerce</a> - <?php _e('for online shop function', 'theme'); ?> </li>
                </ul>
            </div>
        </div>
    </div>

    <?php }
endif;
