<?php
class mom_shortcodes_ultimate {

	/**
	 * Constructor
	 */
	function __construct() {
		add_action( 'plugins_loaded',             array( __CLASS__, 'init' ) );
		add_action( 'init',                       array( __CLASS__, 'register' ) );
		add_action( 'init',                       array( __CLASS__, 'update' ), 20 );
		register_activation_hook( mom_su_PLUGIN_FILE, array( __CLASS__, 'activation' ) );
		register_activation_hook( mom_su_PLUGIN_FILE, array( __CLASS__, 'deactivation' ) );
	}

	/**
	 * Plugin init
	 */
	public static function init() {
		// Make plugin available for translation
		//load_plugin_textdomain( 'su', false, dirname( plugin_basename( mom_su_PLUGIN_FILE ) ) . '/languages/' );
		// Setup admin class
		$admin = new Mom_Sunrise4( array(
				'file'       => mom_su_PLUGIN_FILE,
				'slug'       => 'su',
				'prefix'     => 'mom_su_option_',
				'textdomain' => 'su'
			) );
		// Top-level menu
		$admin->add_menu( array(
				'page_title'  => __( 'Settings', 'framework' ) . ' &lsaquo; ' . __( 'Shortcodes', 'framework' ),
				'menu_title'  => apply_filters( 'mom_su/menu/shortcodes', __( 'Shortcodes', 'framework' ) ),
				'capability'  => 'manage_options',
				'slug'        => 'mom-shortcodes-ultimate',
				'icon_url'    => 'dashicons-editor-code',
				'position'    => '80.11',
				'options'     => array(
					array(
						'type' => 'opentab',
						'name' => __( 'About', 'framework' )
					),
					array(
						'type'     => 'about',
						'callback' => array( 'mom_su_Admin_Views', 'about' )
					),
					array(
						'type'    => 'closetab',
						'actions' => false
					),
					array(
						'type' => 'opentab',
						'name' => __( 'Settings', 'framework' )
					),
					array(
						'type'    => 'checkbox',
						'id'      => 'custom-formatting',
						'name'    => __( 'Custom formatting', 'framework' ),
						'desc'    => __( 'Disable this option if you have some problems with other plugins or content formatting', 'framework' ) . '<br /><a href="http://gndev.info/kb/custom-formatting/" target="_blank">' . __( 'Documentation article', 'framework' ) . '</a>',
						'default' => 'on',
						'label'   => __( 'Enabled', 'framework' )
					),
					array(
						'type'    => 'checkbox',
						'id'      => 'skip',
						'name'    => __( 'Skip default values', 'framework' ),
						'desc'    => __( 'Enable this option and the generator will insert a shortcode without default attribute values that you have not changed. As a result, the generated code will be shorter.', 'framework' ),
						'default' => 'on',
						'label'   => __( 'Enabled', 'framework' )
					),
					array(
						'type'    => 'text',
						'id'      => 'prefix',
						'name'    => __( 'Shortcodes prefix', 'framework' ),
						'desc'    => sprintf( __( 'This prefix will be added to all shortcodes by this plugin. For example, type here %s and you\'ll get shortcodes like %s and %s. Please keep in mind: this option is not affects your already inserted shortcodes and if you\'ll change this value your old shortcodes will be broken', 'framework' ), '<code>mom_su_</code>', '<code>[mom_su_button]</code>', '<code>[mom_su_column]</code>' ),
						'default' => 'mom_su_'
					),
					array(
						'type'    => 'hidden',
						'id'      => 'skin',
						'name'    => __( 'Skin', 'framework' ),
						'desc'    => __( 'Choose global skin for shortcodes', 'framework' ),
						'default' => 'default'
					),
					array(
						'type' => 'closetab'
					),
					array(
						'type' => 'opentab',
						'name' => __( 'Custom CSS', 'framework' )
					),
					array(
						'type'     => 'custom_css',
						'id'       => 'custom-css',
						'default'  => '',
						'callback' => array( 'mom_su_Admin_Views', 'custom_css' )
					),
					array(
						'type' => 'closetab'
					)
				)
			) );
		// Settings submenu
		$admin->add_submenu( array(
				'parent_slug' => 'mom-shortcodes-ultimate',
				'page_title'  => __( 'Settings', 'framework' ) . ' &lsaquo; ' . __( 'Shortcodes Ultimate', 'framework' ),
				'menu_title'  => apply_filters( 'mom_su/menu/settings', __( 'Settings', 'framework' ) ),
				'capability'  => 'manage_options',
				'slug'        => 'mom-shortcodes-ultimate',
				'options'     => array()
			) );
		// Examples submenu
		$admin->add_submenu( array(
				'parent_slug' => 'mom-shortcodes-ultimate',
				'page_title'  => __( 'Examples', 'framework' ) . ' &lsaquo; ' . __( 'Shortcodes Ultimate', 'framework' ),
				'menu_title'  => apply_filters( 'mom_su/menu/examples', __( 'Examples', 'framework' ) ),
				'capability'  => 'edit_others_posts',
				'slug'        => 'mom-shortcodes-ultimate-examples',
				'options'     => array(
					array(
						'type' => 'examples',
						'callback' => array( 'mom_su_Admin_Views', 'examples' )
					)
				)
			) );
		// Cheatsheet submenu
		$admin->add_submenu( array(
				'parent_slug' => 'mom-shortcodes-ultimate',
				'page_title'  => __( 'Cheatsheet', 'framework' ) . ' &lsaquo; ' . __( 'Shortcodes Ultimate', 'framework' ),
				'menu_title'  => apply_filters( 'mom_su/menu/examples', __( 'Cheatsheet', 'framework' ) ),
				'capability'  => 'edit_others_posts',
				'slug'        => 'mom-shortcodes-ultimate-cheatsheet',
				'options'     => array(
					array(
						'type' => 'cheatsheet',
						'callback' => array( 'mom_su_Admin_Views', 'cheatsheet' )
					)
				)
			) );
		// Add-ons submenu
		$admin->add_submenu( array(
				'parent_slug' => 'mom-shortcodes-ultimate',
				'page_title'  => __( 'Add-ons', 'framework' ) . ' &lsaquo; ' . __( 'Shortcodes Ultimate', 'framework' ),
				'menu_title'  => apply_filters( 'mom_su/menu/addons', __( 'Add-ons', 'framework' ) ),
				'capability'  => 'edit_others_posts',
				'slug'        => 'mom-shortcodes-ultimate-addons',
				'options'     => array(
					array(
						'type' => 'addons',
						'callback' => array( 'mom_su_Admin_Views', 'addons' )
					)
				)
			) );
		// Translate plugin meta
		__( 'Shortcodes Ultimate', 'framework' );
		__( 'Vladimir Anokhin', 'framework' );
		__( 'Supercharge your WordPress theme with mega pack of shortcodes', 'framework' );
		// Add plugin actions links
		add_filter( 'plugin_action_links_' . plugin_basename( mom_su_PLUGIN_FILE ), array( __CLASS__, 'actions_links' ), -10 );
		// Add plugin meta links
		add_filter( 'plugin_row_meta', array( __CLASS__, 'meta_links' ), 10, 2 );
		// Shortcodes Ultimate is ready
		do_action( 'mom_su/init' );
	}

	/**
	 * Plugin activation
	 */
	public static function activation() {
		self::timestamp();
		self::skins_dir();
		update_option( 'mom_su_option_version', mom_su_PLUGIN_VERSION );
		do_action( 'mom_su/activation' );
	}

	/**
	 * Plugin deactivation
	 */
	public static function deactivation() {
		do_action( 'mom_su/deactivation' );
	}

	/**
	 * Plugin update hook
	 */
	public static function update() {
		$option = get_option( 'mom_su_option_version' );
		if ( $option !== mom_su_PLUGIN_VERSION ) {
			update_option( 'mom_su_option_version', mom_su_PLUGIN_VERSION );
			do_action( 'mom_su/update' );
		}
	}

	/**
	 * Register shortcodes
	 */
	public static function register() {
		// Prepare compatibility mode prefix
		$prefix = mom_su_cmpt();
		// Loop through shortcodes
		foreach ( ( array ) mom_su_Data::shortcodes() as $id => $data ) {
			if ( isset( $data['function'] ) && is_callable( $data['function'] ) ) $func = $data['function'];
			elseif ( is_callable( array( 'mom_su_Shortcodes', $id ) ) ) $func = array( 'mom_su_Shortcodes', $id );
			elseif ( is_callable( array( 'mom_su_Shortcodes', 'mom_su_' . $id ) ) ) $func = array( 'mom_su_Shortcodes', 'mom_su_' . $id );
			else continue;
			// Register shortcode
			add_shortcode( $prefix . $id, $func );
		}
		// Register [media] manually // 3.x
		add_shortcode( $prefix . 'media', array( 'mom_su_Shortcodes', 'media' ) );
	}

	/**
	 * Add timestamp
	 */
	public static function timestamp() {
		if ( !get_option( 'mom_su_installed' ) ) update_option( 'mom_su_installed', time() );
	}

	/**
	 * Create directory /wp-content/uploads/mom-shortcodes-ultimate-skins/ on activation
	 */
	public static function skins_dir() {
		$upload_dir = wp_upload_dir();
		$path = trailingslashit( path_join( $upload_dir['basedir'], 'mom-shortcodes-ultimate-skins' ) );
		if ( !file_exists( $path ) ) mkdir( $path, 0755 );
	}

	/**
	 * Add plugin actions links
	 */
	public static function actions_links( $links ) {
		$links[] = '<a href="' . admin_url( 'admin.php?page=mom-shortcodes-ultimate-examples' ) . '">' . __( 'Examples', 'framework' ) . '</a>';
		$links[] = '<a href="' . admin_url( 'admin.php?page=mom-shortcodes-ultimate' ) . '#tab-0">' . __( 'Where to start?', 'framework' ) . '</a>';
		return $links;
	}

	/**
	 * Add plugin meta links
	 */
	public static function meta_links( $links, $file ) {
		// Check plugin
		if ( $file === plugin_basename( mom_su_PLUGIN_FILE ) ) {
			unset( $links[2] );
			$links[] = '<a href="http://gndev.info/mom-shortcodes-ultimate/" target="_blank">' . __( 'Project homepage', 'framework' ) . '</a>';
			$links[] = '<a href="http://wordpress.org/support/plugin/mom-shortcodes-ultimate/" target="_blank">' . __( 'Support forum', 'framework' ) . '</a>';
			$links[] = '<a href="http://wordpress.org/extend/plugins/mom-shortcodes-ultimate/changelog/" target="_blank">' . __( 'Changelog', 'framework' ) . '</a>';
		}
		return $links;
	}
}

/**
 * Register plugin function to perform checks that plugin is installed
 */
function mom_shortcodes_ultimate() {
	return true;
}

new mom_shortcodes_ultimate;
