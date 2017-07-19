<?php
if ( !class_exists( 'Mom_Sunrise4' ) ) {

	/**
	 * Sunrise 4
	 *
	 * @author  Vladimir Anokhin <http://gndev.info/>
	 * @version 4
	 */
	class Mom_Sunrise4 {

		/**
		 *
		 *
		 * @var array Class config
		 */
		var $config = array();

		/**
		 * Constructor
		 *
		 * @param array   Config data
		 */
		function __construct( $args = array() ) {
			// Parse config
			$args = wp_parse_args( $args, array(
					'file'        => '',
					'slug'        => '',
					'prefix'      => '',
					'textdomain'  => '',
					'url'         => '',
					'version'     => '4.0',
					'options'     => array(),
					'menus'       => array(),
					'pages'       => array(),
					'slugs'       => array(),
					'css'         => 'assets/css',
					'js'          => 'assets/js',
					'views_class' => 'Mom_Sunrise4_Views'
				) );
			// Check required settings
			if ( !$args['file'] ) wp_die( 'Sunrise: please specify plugin __FILE__' );
			if ( !$args['slug'] ) $args['slug'] = sanitize_key( plugin_basename( basename( $args['file'] , '.php' ) ) );
			if ( !$args['prefix'] ) $args['prefix'] = 'sunrise_' . sanitize_key( $args['slug'] ) . '_';
			if ( !$args['textdomain'] ) $args['textdomain'] = sanitize_key( $args['slug'] );
			// Setup config
			$this->config = $args;
			// Register hooks
			add_action( 'admin_menu', array( &$this, 'register' ) );
			add_action( 'admin_init', array( &$this, 'assets' ), 10 );
			add_action( 'admin_init', array( &$this, 'enqueue' ), 20 );
			add_action( 'admin_init', array( &$this, 'defaults' ) );
			add_action( 'admin_init', array( &$this, 'submit' ) );
		}

		/**
		 * Helper to get config
		 *
		 * @param mixed   $option Option ID
		 * @return mixed Option value
		 */
		public function config( $option = false ) {
			if ( $option ) $data = ( isset( $this->config[$option] ) ) ? $this->config[$option] : false;
			else $data = $this->config;
			return $data;
		}

		/**
		 * Register options pages
		 */
		public function register() {
			if ( isset( $this->config['menus'] ) && count( $this->config['menus'] ) )
				foreach ( $this->config['menus'] as $menu ) {
					add_menu_page( $menu['page_title'], $menu['menu_title'], $menu['capability'], $menu['slug'], array( &$this, 'render' ), $menu['icon_url'], $menu['position'] );
				}
			if ( isset( $this->config['pages'] ) && count( $this->config['pages'] ) )
				foreach ( $this->config['pages'] as $page ) {
					add_submenu_page( $page['parent_slug'], $page['page_title'], $page['menu_title'], $page['capability'], $page['slug'], array( &$this, 'render' ) );
				}
		}

		/**
		 * Add top-level menu
		 *
		 * @param array   $args Page config and options
		 */
		public function add_menu( $args ) {
			// Prepare default config
			$args = wp_parse_args( $args, array(
					'page_title'  => __( 'Plugin Settings', $this->config['textdomain'] ),
					'menu_title'  => __( 'Plugin Settings', $this->config['textdomain'] ),
					'capability'  => 'manage_options',
					'slug'        => $this->config['slug'],
					'icon_url'    => admin_url( 'images/wp-logo.png' ),
					'position'    => '81.' . rand( 0, 99 ),
					'url'         => '',
					'options'     => array()
				) );
			// Define page url
			if ( !$args['url'] ) $args['url'] = admin_url( 'admin.php?page=' . $args['slug'] );
			// Save url to global config
			if ( !$this->config['url'] ) $this->config['url'] = $args['url'];
			// Save options to global config
			if ( is_array( $args['options'] ) && count( $args['options'] ) ) foreach ( $args['options'] as $option ) {
					$this->config['options'][] = $option;
				}
			// Save menu slug to the global config
			$this->config['slugs'][] = $args['slug'];
			// Add page to global config
			$this->config['menus'][$args['slug']] = $args;
		}

		/**
		 * Add sub-menu
		 *
		 * @param array   $args Page config and options
		 */
		public function add_submenu( $args ) {
			// Prepare default config
			$args = wp_parse_args( $args, array(
					'parent_slug' => 'options-general.php',
					'page_title'  => __( 'Plugin Settings', $this->config['textdomain'] ),
					'menu_title'  => __( 'Plugin Settings', $this->config['textdomain'] ),
					'capability'  => 'manage_options',
					'slug'        => $this->config['slug'],
					'url'         => '',
					'options'     => array()
				) );
			// Define page url
			if ( !$args['url'] ) {
				if ( strpos( $args['parent_slug'], '.php' ) !== false && strpos( $args['parent_slug'], '?' ) !== false ) $args['url'] = admin_url( $args['parent_slug'] . '&page=' . $args['slug'] );
				elseif ( strpos( $args['parent_slug'], '.php' ) !== false ) $args['url'] = admin_url( $args['parent_slug'] . '?page=' . $args['slug'] );
				else $args['url'] = ( isset( $this->config['menus'][$args['parent_slug']] ) ) ? admin_url( 'admin.php?page=' . $args['slug'] ) : '';
			}
			// Save url to global config
			if ( !$this->config['url'] ) $this->config['url'] = $args['url'];
			// Save options to global config
			if ( is_array( $args['options'] ) && count( $args['options'] ) && !in_array( $args['slug'], array_keys( (array) $this->config['menus'] ) ) ) foreach ( $args['options'] as $option ) {
					$this->config['options'][] = $option;
				}
			// Save page slug to the global config
			$this->config['slugs'][] = $args['slug'];
			// Add page to global config
			$this->config['pages'][$args['slug']] = $args;
		}

		/**
		 * Display options page
		 */
		public function render() {
			// Prepare page options
			$options = $this->get_page_options();
			// Hook before page output
			do_action( 'sunrise/page/before' );
			echo '<div id="sunrise-settings" class="wrap">';
			echo call_user_func( array( $this->config['views_class'], 'options_page_tabs' ), $options, $this->config );
			echo call_user_func( array( $this->config['views_class'], 'options_page_notices' ), $options, $this->config );
			echo '<form action="" method="post" id="sunrise-form">';
			echo call_user_func( array( $this->config['views_class'], 'options_page_panes' ), $options, $this->config );
			echo '<input type="hidden" name="sunrise_action" value="save" />';
			do_action( 'sunrise/page/form' );
			echo '</form></div>';
			// Hook after page output
			do_action( 'sunrise/page/after' );
		}

		/**
		 * Register class assets
		 */
		public function assets() {
			// Register styles
			wp_register_style(  'sunrise', plugins_url( $this->config['css'], $this->config['file'] ) . '/sunrise.css', false, $this->config['version'], 'all' );
			// Register scripts
			wp_register_script( 'form',    plugins_url( $this->config['js'],  $this->config['file'] ) . '/form.js', array( 'jquery' ), $this->config['version'], true );
			wp_register_script( 'sunrise', plugins_url( $this->config['js'],  $this->config['file'] ) . '/sunrise.js', array( 'form' ), $this->config['version'], true );
			// Add some l10n to JS
			wp_localize_script( 'sunrise', 'sunrise', array(
					'media_title'  => __( 'Choose file', $this->config['textdomain'] ),
					'media_insert' => __( 'Use selected file', $this->config['textdomain'] )
				) );
			// Hook to add/remove custom files
			do_action( 'sunrise/assets/register' );
		}

		/**
		 * Enqueue class assets
		 */
		public function enqueue() {
			// Check there is an options page
			if ( !$this->is_sunrise() ) return;
			// Enqueue styles
			foreach ( array( 'farbtastic', 'sunrise' ) as $style ) wp_enqueue_style( $style );
			// Enqueue scripts
			foreach ( array( 'jquery', 'farbtastic', 'form', 'sunrise' ) as $script ) wp_enqueue_script( $script );
			// Hook to add/remove files
			do_action( 'sunrise/assets/enqueue' );
		}

		/**
		 * Hook to insert default settings
		 */
		public function defaults() {
			// Check defaults isn't set
			if ( get_option( 'sunrise_defaults_' . $this->config['slug'] ) ) return;
			// Check config options
			if ( isset( $this->config['options'] ) && is_array( $this->config['options'] ) ) {
				// Insert default options
				foreach ( $this->config['options'] as $option ) {
					// Option id and option defaut value is present
					if ( isset( $option['id'] ) && isset( $option['default'] ) ) update_option( $this->config['prefix'] . $option['id'], $option['default'] );
					// Default value isn't set bacause there is an multiple options array
					elseif ( isset( $option['id'] ) && isset( $option['options'] ) && is_array( $option['options'] ) ) {
						$options = array();
						foreach ( $option['options'] as $item ) {
							if ( isset( $item['id'] ) && isset( $item['default'] ) ) $options[$item['id']] = $item['default'];
						}
						update_option( $this->config['prefix'] . $option['id'], $options );
					}
				}
				// Defaults is set
				update_option( 'sunrise_defaults_' . $this->config['slug'], true );
			}
		}

		/**
		 * Hook to process submitted data
		 */
		public function submit() {
			// Check request
			if ( empty( $_REQUEST['sunrise_action'] ) || empty( $_REQUEST['page'] ) ) return;
			// Prepare page slug
			$page = sanitize_key( $_GET['page'] );
			// Check page
			if ( !$this->is_sunrise() ) return;
			// Submit hooks
			do_action( 'sunrise/submit', $this );
			do_action( 'sunrise/submit/' . $page, $this );
			// Parse incoming data
			$action  = sanitize_key( $_REQUEST['sunrise_action'] );
			$request = ( isset( $_REQUEST['sunrise'] ) ) ? (array) $_REQUEST['sunrise'] : array();
			// Run actions
			switch ( $action ) {
			case 'save': // Save options
				// Loop through current page options
				foreach ( (array) $this->get_page_options() as $option ) {
					// Option must have an ID
					if ( !isset( $option['id'] ) ) continue;
					// Prepare value
					$val = ( isset( $request[$option['id']] ) ) ? $request[$option['id']] : '';
					// Save options value
					update_option( $this->config['prefix'] . $option['id'], $val );
				}
				// Save hooks
				do_action( 'sunrise/save', $this );
				do_action( 'sunrise/save/' . $page, $this );
				// Go to page with message - Settings is saved
				wp_redirect( $this->get_page_url() . '&message=1' );
				exit;
			case 'reset': // Reset options
				// Loop through current page options
				foreach ( (array) $this->get_page_options() as $option ) {
					// Option must have an ID
					if ( !isset( $option['id'] ) ) continue;
					// Reset option with multiple values
					if ( !isset( $option['default'] ) && isset( $option['options'] ) ) {
						// Prepare variable for default value
						$option['default'] = array();
						// Loop through multiple values
						foreach ( (array) $option['options'] as $item ) {
							if ( isset( $item['id'] ) && isset( $item['default'] ) ) $option['default'][$item['id']] = $item['default'];
						}
					}
					// Save option value
					if ( isset( $option['default'] ) ) update_option( $this->config['prefix'] . $option['id'], $option['default'] );
				}
				// Reset hooks
				do_action( 'sunrise/reset', $this );
				do_action( 'sunrise/reset/' . $page, $this );
				// Go to page with message - Settings is reseted
				wp_redirect( $this->get_page_url() . '&message=2' );
				exit;
			}
		}

		/**
		 * Get current page data
		 */
		public function get_page() {
			$slug = sanitize_key( $_REQUEST['page'] );
			// This page is added to the top-level menus
			if ( in_array( $slug, array_keys( (array) $this->config['menus'] ) ) ) return $this->config['menus'][$slug];
			// This page is added to the sub-menus
			else if ( in_array( $slug, array_keys( (array) $this->config['pages'] ) ) ) return $this->config['pages'][$slug];
				// Return an empty array by default
				return array();
		}

		/**
		 * Get current page options
		 */
		public function get_page_options() {
			// Get current page data
			$page = $this->get_page();
			// Prepare array for options
			$options = array();
			// This page have some options
			if ( isset( $page['options'] ) && is_array( $page['options'] ) )
				// Loop through page options
				foreach ( $page['options'] as $option ) {
					// Add option to resulting array
					$options[] = $option;
				}
			// Return options
			return $options;
		}

		/**
		 * Get current page URL
		 *
		 * @param mixed   $slug Page slug (optional). This parameter can be automatically retrieved from $_GET['page']
		 * @return string  Page URL
		 */
		public function get_page_url( $slug = false ) {
			// Get slug from $_GET['page']
			if ( !$slug && isset( $_REQUEST['page'] ) ) $slug = sanitize_key( $_REQUEST['page'] );
			// Serach for URL in registered top-level menus
			if ( isset( $this->config['menus'][$slug] ) && isset( $this->config['menus'][$slug]['url'] ) ) return $this->config['menus'][$slug]['url'];
			// Serach for URL in registered sub-menus
			elseif ( isset( $this->config['pages'][$slug] ) && isset( $this->config['pages'][$slug]['url'] ) ) return $this->config['pages'][$slug]['url'];
			// Return empty string if URL doesn't found
			return '';
		}

		/**
		 * Conditional check for Sunrise options page
		 *
		 * @return boolean true/false - there is an page created by Sunrise
		 */
		public function is_sunrise() {
			return isset( $_GET['page'] ) && in_array( $_GET['page'], $this->config['slugs'] );
		}

	}
}

if ( !class_exists( 'Mom_Sunrise4_Views' ) ) {

	/**
	 * Sunrise Views
	 *
	 * no comments, just some markup
	 */
	class Mom_Sunrise4_Views {

		function __construct() {}

		public static function notice( $msg = '', $class = '' ) {
			return '<div class="sunrise-notice ' . $class . '"><p>' . $msg . '</p></div>';
		}

		public static function opentab( $field, $config ) {
			return '<div class="sunrise-pane"><h3 class="hide-if-js sunrise-no-js-tab">' . $field['name'] . '</h3><table class="form-table">';
		}

		public static function closetab( $field, $config ) {
			$field = wp_parse_args( $field, array( 'actions' => true ) );
			$return = array();
			$return[] = '</table>';
			if ( $field['actions'] ) $return[] = '<div class="sunrise-actions-bar"><input type="submit" value="' . __( 'Save changes', $config['textdomain'] ) . '" class="sunrise-submit button-primary" /><span class="sunrise-spin"><img src="' . admin_url( 'images/wpspin_light.gif' ) . '" alt="" /> ' . __( 'Saving', $config['textdomain'] ) . '&hellip;</span><span class="sunrise-success-tip"><img src="' . admin_url( 'images/yes.png' ) . '" alt="" /> ' . __( 'Saved', $config['textdomain'] ) . '</span><a href="' . $_SERVER["REQUEST_URI"] . '&amp;sunrise_action=reset" class="sunrise-reset button alignright" title="' . esc_attr( __( 'This action will delete all your settings. Are you sure? This action cannot be undone!', $config['textdomain'] ) ) . '">' . __( 'Restore default settings', $config['textdomain'] ) . '</a></div>';
			$return[] = '</div>';
			return implode( '', $return );
		}

		public static function text( $field, $config ) {
			$field = wp_parse_args( $field, array(
					'name'  => __( 'Text field', $config['textdomain'] ),
					'id'    => '',
					'desc'  => ''
				) );
			return '<tr><th scope="row"><label for="sunrise-field-' . $field['id'] . '">' . $field['name'] . '</label></th><td><input type="text" value="' . get_option( $config['prefix'] . $field['id'] ) . '" name="sunrise[' . $field['id'] . ']" id="sunrise-field-' . $field['id'] . '" class="regular-text" /><p class="description">' . $field['desc'] . '</p></td></tr>';
		}

		public static function hidden( $field, $config ) {
			$field = wp_parse_args( $field, array(
					'name'  => __( 'Text field', $config['textdomain'] ),
					'id'    => '',
					'desc'  => ''
				) );
			return '<input type="hidden" value="' . get_option( $config['prefix'] . $field['id'] ) . '" name="sunrise[' . $field['id'] . ']" id="sunrise-field-' . $field['id'] . '" />';
		}

		public static function number( $field, $config ) {
			$field = wp_parse_args( $field, array(
					'name'  => __( 'Text field', $config['textdomain'] ),
					'id'    => '',
					'desc'  => '',
					'min'   => 0,
					'max'   => 100,
					'step'  => 1
				) );
			return '<tr><th scope="row"><label for="sunrise-field-' . $field['id'] . '">' . $field['name'] . '</label></th><td><input type="number" value="' . get_option( $config['prefix'] . $field['id'] ) . '" name="sunrise[' . $field['id'] . ']" id="sunrise-field-' . $field['id'] . '" class="regular-text" min="' . (string) $field['min'] . '" max="' . (string) $field['max'] . '" step="' . (string) $field['step'] . '" /><p class="description">' . $field['desc'] . '</p></td></tr>';
		}

		public static function textarea( $field, $config ) {
			$field = wp_parse_args( $field, array(
					'name'  => __( 'Textarea field', $config['textdomain'] ),
					'id'    => '',
					'desc'  => '',
					'rows'  => 10,
					'cols'  => 30
				) );
			return '<tr><th scope="row"><label for="sunrise-field-' . $field['id'] . '">' . $field['name'] . '</label></th><td><textarea name="sunrise[' . $field['id'] . ']" id="sunrise-field-' . $field['id'] . '" class="regular-text widefat" cols="' . $field['cols'] . '" rows="' . $field['rows'] . '">' . stripslashes( get_option( $config['prefix'] . $field['id'] ) ) . '</textarea><p class="description">' . $field['desc'] . '</p></td></tr>';
		}

		public static function checkbox( $field, $config ) {
			$field = wp_parse_args( $field, array(
					'name'  => __( 'Checkbox', $config['textdomain'] ),
					'label' => __( 'Label', $config['textdomain'] ),
					'id'    => '',
					'desc'  => ''
				) );
			$checked = ( get_option( $config['prefix'] . $field['id'] ) === 'on' ) ? ' checked="checked"' : '';
			return '<tr><th scope="row"><label for="sunrise-field-' . $field['id'] . '">' . $field['name'] . '</label></th><td><label><input type="checkbox" name="sunrise[' . $field['id'] . ']" id="sunrise-field-' . $field['id'] . '"' . $checked . ' /> ' . $field['label'] . '</label><span class="description">' . $field['desc'] . '</span></td></tr>';
		}

		public static function checkbox_group( $field, $config ) {
			$field = wp_parse_args( $field, array(
					'name'    => __( 'Checkbox', $config['textdomain'] ),
					'options' => array(),
					'id'      => '',
					'desc'    => ''
				) );
			$group = array();
			$value = (array) get_option( $config['prefix'] . $field['id'] );
			if ( is_array( $field['options'] ) ) foreach ( $field['options'] as $single ) {
					$checked = ( isset( $value[$single['id']] ) && $value[$single['id']] === 'on' ) ? ' checked="checked"' : '';
					$group[] = '<label for="sunrise-field-' . $field['id'] . '-' . $single['id'] . '"><input type="checkbox" name="sunrise[' . $field['id'] . '][' . $single['id'] . ']" id="sunrise-field-' . $field['id'] . '-' . $single['id'] . '"' . $checked . ' /> ' . $single['label'] . '</label><br/>';
				}
			return '<tr><th scope="row">' . $field['name'] . '</th><td class="sunrise-checkbox-group">' . implode( '', $group ) . '<span class="description">' . $field['desc'] . '</span></td></tr>';
		}

		public static function media( $field, $config ) {
			$field = wp_parse_args( $field, array(
					'name'  => __( 'Text field', $config['textdomain'] ),
					'id'    => '',
					'desc'  => ''
				) );
			if ( function_exists( 'wp_enqueue_media' ) ) wp_enqueue_media();
			return '<tr class="sunrise-media"><th scope="row"><label for="sunrise-field-' . $field['id'] . '">' . $field['name'] . '</label></th><td><input type="text" value="' . get_option( $config['prefix'] . $field['id'] ) . '" name="sunrise[' . $field['id'] . ']" id="sunrise-field-' . $field['id'] . '" class="regular-text sunrise-media-value" /> <a href="javascript:;" class="button sunrise-media-button hide-if-no-js"><img src="' . admin_url( 'images/media-button.png' ) . '" alt="" /> ' . __( 'Media manager', $config['textdomain'] ) . '</a><p class="description">' . $field['desc'] . '</p></td></tr>';
		}

		public static function color( $field, $config ) {
			$field = wp_parse_args( $field, array(
					'name'  => __( 'Color picker', $config['textdomain'] ),
					'id'    => '',
					'desc'  => ''
				) );
			/////////////////////////////////////////////////////////////////////////////////
			// DON'T PANIC - IT's NOT A MALWARE
			// this base64 code is just an image for color picker =)
			/////////////////////////////////////////////////////////////////////////////////
			return '<tr><th scope="row"><label for="sunrise-field-' . $field['id'] . '">' . $field['name'] . '</label></th><td><div class="sunrise-color-picker"><input type="text" value="' . get_option( $config['prefix'] . $field['id'] ) . '" name="sunrise[' . $field['id'] . ']" id="sunrise-field-' . $field['id'] . '" class="regular-text sunrise-color-picker-value" /><span class="sunrise-color-picker-wheel"></span> <a href="javascript:;" class="button sunrise-color-picker-button hide-if-no-js"><img alt="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAArFJREFUeNqkU01PE1EUPUOn004/hpmmhH6AFA2KRojxIzFoooK4calLXbhyTeLeEFe69Qe4wJiwcKMLo8Yag9EEIgsS0VpKsdOZ0hbaaUtp6cx0vAOkgbjkJefNnXn3nHvefW8Yy7JwlMHa06uXDM566SUB1JbQwxcx7tpwjEJ1hKDRQju6bhg9SzrCcRfOFE2cxib8uGZN7gkckLshnQw8kG7eGREGJ45x7pCARhdaSr1ajacz5TfKbbPEvqDMz4cc7EeTbKz/Uezcs8tcwxSwvAwk54GyDy7vUKDnysVA9/mrx9ee/uw1FYfN+2jTuuzJ4hFmwsLUwPiTMY7PCdheBPyUE40AkSjg6gb+6OCqfmHg4fUxyxeaaoELdxy0grjLhm+NsJLuAyeTIq15g4DbDwgCUO8FPCKwLoH1+3zsBXOk9CV7l6jPdx0U3ZhgpUvBdSYFzSfCDBO5j6rHBggxctGHdjCCmiggX6aenJCCWWCi42BVx3DT7XcVoUCABNHhhSiK8HgiYLwBNBke2hag8UClDTQ5t2sV+nBHIGXAqaKKEizQblHZR4BzwcHzKDFExh7s79skloLh7AhQf9I/6iv9Tr/HWUCTPOyg104Es9vlMqGwA5QaQLUFqGrdSEBPd05BLiL+Vllo5Cj+CwN50lXhoBhYo+qqA8hTKZnsJ6l6PKU0MqjHOw6sFGYWpV/3gpFRPiREnQyRm1TdQ7BHkx4VEimS6VS9qifVtNLG5kzHAW1ebmmt6U9zHworWs3IkW6GyGu2A0KGkKXMlS3NWJifKxh6fZrOVj58E03MNjIb+Fp4/Th8ajvaN+TlRSnKQjdQKZaN7PdkQ32XUIy8TmRx9v+rbA/dnDWWc9/kxPv7spQdp0swiFrAtpHG7604sq0ZtGPyQQpz1N/5nwADAEUXDAYgnuAXAAAAAElFTkSuQmCC" /> ' . __( 'Pick a color', $config['textdomain'] ) . '</a></div><span class="description">' . $field['desc'] . '</span></td></tr>';
		}

		/**
		 * Display options page tabs
		 */
		public static function options_page_tabs( $options, $config ) {
			// Declare tabs array
			$tabs = array();
			// Loop through options
			foreach ( (array) $options as $option ) {
				// Current option is opentab
				if ( isset( $option['type'] ) && isset( $option['name'] ) && $option['type'] === 'opentab' ) $tabs[] = '<span class="nav-tab">' . $option['name'] . '</span>';
			}
			// Return resulting markup
			return ( count( $tabs ) ) ? '<div id="icon-options-general" class="icon32 hide-if-no-js"><br /></div><h2 id="sunrise-tabs" class="nav-tab-wrapper hide-if-no-js">' . implode( '', $tabs ) . '</h2>' : '';
		}

		/**
		 * Display options page notices
		 */
		public static function options_page_notices( $options, $config ) {
			// Setup messsages
			$msgs = apply_filters( 'sunrise/page/notices', array(
						__( 'For full functionality of this page it is reccomended to enable javascript.', $config['textdomain'] ),
						__( 'Settings saved successfully', $config['textdomain'] ),
						__( 'Settings reseted successfully', $config['textdomain'] )
					) );
			// Prepare output variable
			$output = array();
			// Get current message
			$message = ( isset( $_GET['message'] ) && is_numeric( $_GET['message'] ) ) ? intval( sanitize_key( $_GET['message'] ) ) : 0;
			// Add no-js notice (will be hidden for js-enabled browsers)
			$output[] = self::notice( '<a href="http://enable-javascript.com/" target="_blank">' . $msgs[0] . '</a>.', 'error hide-if-js' );
			// Show notice
			if ( $message !== 0 ) $output[] = self::notice( $msgs[$message], 'updated' );
			// Return resulting markup
			return implode( '', $output );
		}

		/**
		 * Display options panes
		 */
		public static function options_page_panes( $options, $config ) {
			// Declare panes array
			$panes = array();
			// Loop through options
			foreach ( $options as $option ) {
				// Check option type definition
				if ( !isset( $option['type'] ) ) continue;
				// Try to call option from external source
				elseif ( isset( $option['callback'] ) && is_callable( $option['callback'] ) ) $panes[] = call_user_func( $option['callback'], $option, $config );
				// Try to call option from built-in class SunriseX_Views
				elseif ( is_callable( array( $config['views_class'], $option['type'] ) ) ) $panes[] = call_user_func( array( $config['views_class'], $option['type'] ), $option, $config );
				// Show error message
				else $panes[] = call_user_func( array( $config['views_class'], 'notice' ), 'Sunrise: ' . sprintf( __( 'option type %s is not callable', $config['textdomain'] ), '<b>' . $option['type'] . '</b>' ), 'error' );
			}
			// Return resulting markup
			return implode( '', $panes );
		}
	}
}
