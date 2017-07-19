<?php
/**
 * @package WordPress
 * @subpackage BuddyBoss Wall
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'BuddyBoss_Wall_Admin' ) ):
/**
 *
 * BuddyBoss Wall Admin
 * ********************
 *
 *
 */
class BuddyBoss_Wall_Admin
{
	/* Options/Load
	 * ===================================================================
	 */

	/**
	 * Plugin options
	 *
	 * @var array
	 */
	public	$options = array();
	private $plugin_settings_tabs = array();
	
	private $network_activated = false,
			$plugin_slug = 'bb-buddyboss-wall',
			$menu_hook = 'admin_menu',
			$settings_page = 'buddyboss-settings',
			$capability = 'manage_options',
			$form_action = 'options.php',
			$plugin_settings_url;

	/**
	 * Empty constructor function to ensure a single instance
	 */
	public function __construct()
	{
		// ... leave empty, see Singleton below
	}


	/* Singleton
	 * ===================================================================
	 */

	/**
	 * Admin singleton
	 *
	 * @since BuddyBoss Wall (1.0.0)
	 *
	 * @param  array  $options [description]
	 *
	 * @uses BuddyBoss_Wall_Admin::setup() Init admin class
	 *
	 * @return object Admin class
	 */
	public static function instance()
	{
		static $instance = null;

		if ( null === $instance )
		{
			$instance = new BuddyBoss_Wall_Admin;
			$instance->setup();
		}

		return $instance;
	}


	/* Utility functions
	 * ===================================================================
	 */

	/**
	 * Get option
	 *
	 * @since BuddyBoss Wall (1.0.0)
	 *
	 * @param  string $key Option key
	 *
	 * @uses BuddyBoss_Wall_Plugin::option() Get option
	 *
	 * @return mixed      Option value
	 */
	public function option( $key )
	{
		$value = buddyboss_wall()->option( $key );
		return $value;
	}

	/* Actions/Init
	 * ===================================================================
	 */

	/**
	 * Setup admin class
	 *
	 * @since BuddyBoss Wall (1.0.0)
	 *
	 * @uses buddyboss_wall() Get options from main BuddyBoss_Wall_Plugin class
	 * @uses is_admin() Ensures we're in the admin area
	 * @uses curent_user_can() Checks for permissions
	 * @uses add_action() Add hooks
	 */
	public function setup()
	{
		if ( ( ! is_admin() && ! is_network_admin() ) || ! current_user_can( 'manage_options' ) )
		{
			return;
		}

		$this->plugin_settings_url = admin_url( 'admin.php?page=' . $this->plugin_slug );

		$this->network_activated = $this->is_network_activated();

		//if the plugin is activated network wide in multisite, we need to override few variables
		if ( $this->network_activated ) {
			// Main settings page - menu hook
			$this->menu_hook = 'network_admin_menu';

			// Main settings page - parent page
			$this->settings_page = 'settings.php';

			// Main settings page - Capability
			$this->capability = 'manage_network_options';

			// Settins page - form's action attribute
			$this->form_action = 'edit.php?action=' . $this->plugin_slug;

			// Plugin settings page url
			$this->plugin_settings_url = network_admin_url('settings.php?page=' . $this->plugin_slug);
		}

		//if the plugin is activated network wide in multisite, we need to process settings form submit ourselves
		if ( $this->network_activated ) {
			add_action('network_admin_edit_' . $this->plugin_slug, array( $this, 'save_network_settings_page' ));
		}

		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'admin_init', array($this, 'register_support_settings' ) );
		add_action( $this->menu_hook, array( $this, 'admin_menu' ) );

		add_filter( 'plugin_action_links', array( $this, 'add_action_links' ), 10, 2 );
		add_filter( 'network_admin_plugin_action_links', array( $this, 'add_action_links' ), 10, 2 );
	}
	
	/**
	 * Check if the plugin is activated network wide(in multisite).
	 * 
	 * @return boolean
	 */
	private function is_network_activated() {
	   $network_activated = false;
	   if ( is_multisite() ) {
		   if ( !function_exists('is_plugin_active_for_network') )
			   require_once( ABSPATH . '/wp-admin/includes/plugin.php' );

		   if ( is_plugin_active_for_network(basename( constant( 'BUDDYBOSS_WALL_PLUGIN_DIR' ) ).'/buddyboss-wall.php') ) {
			   $network_activated = true;
		   }
	   }
	   return $network_activated;
	}

	/**
	 * Register admin settings
	 *
	 * @since BuddyBoss Wall (1.0.0)
	 *
	 * @uses register_setting() Register plugin options
	 * @uses add_settings_section() Add settings page option sections
	 * @uses add_settings_field() Add settings page option
	 */
	public function admin_init()
	{	
		$this->plugin_settings_tabs['buddyboss_wall_plugin_options'] = 'General';
		
		register_setting( 'buddyboss_wall_plugin_options', 'buddyboss_wall_plugin_options', array( $this, 'plugin_options_validate' ) );
		add_settings_section( 'general_section', __( 'General Settings', 'buddyboss-wall' ), array( $this, 'section_general' ), __FILE__ );
		// add_settings_section( 'style_section', 'Style Settings', array( $this, 'section_style' ), __FILE__ );

		//general options
		add_settings_field( 'enabled', __( 'Enable Wall Component', 'buddyboss-wall' ), array( $this, 'setting_enabled' ), __FILE__, 'general_section' );
        add_settings_field( 'all-members', __( 'Available to all members', 'buddyboss-wall' ), array( $this, 'setting_available_to_allmembers' ), __FILE__, 'general_section' );
        add_settings_field( 'activity-posted-text', __( 'Activity post text', 'buddyboss-wall' ), array( $this, 'setting_activity_posted_text' ), __FILE__, 'general_section' );
        add_settings_field( 'activity-like-text', __( 'Activity Like text', 'buddyboss-wall' ), array( $this, 'setting_activity_like_text' ), __FILE__, 'general_section' );
        add_settings_field( 'enabled-wall-privacy', __( 'Wall Privacy', 'buddyboss-wall' ), array( $this, 'setting_enabled_wall_privacy' ), __FILE__, 'general_section' );
        add_settings_field( 'disable_everyone_option', __( 'Wall Privacy Options', 'buddyboss-wall' ), array( $this, 'setting_disable_everyone_option' ), __FILE__, 'general_section' );
        add_settings_field( 'enabled_link_preview', __( 'Link Preview', 'buddyboss-wall' ), array( $this, 'setting_enabled_link_preview' ), __FILE__, 'general_section' );
        add_settings_field( 'default_profile_tab', __( 'Default Profile Tab', 'buddyboss-wall' ), array( $this, 'setting_default_profile_tab' ), __FILE__, 'general_section' );
	}

	function register_support_settings() {
		$this->plugin_settings_tabs[ 'buddyboss_wall_support_options' ] = __('Support','buddyboss-wall');

		register_setting( 'buddyboss_wall_support_options', 'buddyboss_wall_support_options' );
		add_settings_section( 'section_support', ' ', array( &$this, 'section_support_desc' ), 'buddyboss_wall_support_options' );
	}

	function section_support_desc() {
		if ( file_exists( dirname( __FILE__ ) . '/help-support.php' ) ) {
			require_once( dirname( __FILE__ ) . '/help-support.php' );
		}
	}
	
	/**
	 * Add plugin settings page
	 *
	 * @since BuddyBoss Wall (1.0.0)
	 *
	 * @uses add_options_page() Add plugin settings page
	 */
	public function admin_menu()
	{
		add_submenu_page(
				$this->settings_page, 'BuddyBoss Wall', 'Wall', $this->capability, $this->plugin_slug, array( $this, 'options_page' )
		);
	}

	/**
	 * Add plugin settings page
	 *
	 * @since BuddyBoss Wall (1.0.0)
	 *
	 * @uses BuddyBoss_Wall_Admin::admin_menu() Add settings page option sections
	 */
	public function network_admin_menu()
	{
		return $this->admin_menu();
	}

	/**
	 * Register admin scripts
	 *
	 * @since BuddyBoss Wall (1.0.0)
	 *
	 * @uses wp_enqueue_script() Enqueue admin script
	 * @uses wp_enqueue_style() Enqueue admin style
	 * @uses buddyboss_wall()->assets_url Get plugin URL
	 */
	public function admin_enqueue_scripts()
	{
		$js  = buddyboss_wall()->assets_url . '/js/';
		$css = buddyboss_wall()->assets_url . '/css/';
	}

	/* Settings Page + Sections
	 * ===================================================================
	 */

	/**
	 * Render settings page
	 *
	 * @since BuddyBoss Wall (1.0.0)
	 *
	 * @uses do_settings_sections() Render settings sections
	 * @uses settings_fields() Render settings fields
	 * @uses esc_attr_e() Escape and localize text
	 */
	public function options_page()
	{
		$tab = isset( $_GET['tab'] ) ? $_GET['tab'] : __FILE__;
	?>
		<div class="wrap">
			<h2><?php _e( 'BuddyBoss Wall', 'buddyboss-wall' ); ?></h2>
			<?php $this->plugin_options_tabs(); ?>
			<form action="<?php echo $this->form_action; ?>" method="post">
				
				<?php
					if ( $this->network_activated && isset($_GET['updated']) ) {
						echo "<div class='updated'><p>" . __('Settings updated.', 'buddyboss-wall') . "</p></div>";
					}
				?>
				
				<?php
				if ( 'buddyboss_wall_plugin_options' == $tab || empty($_GET['tab']) ) {
					settings_fields( 'buddyboss_wall_plugin_options' );
					do_settings_sections( __FILE__ ); ?>
					<p class="submit">
						<input name="bboss_g_s_settings_submit" type="submit" class="button-primary" value="<?php echo esc_attr( __('Save Changes', 'buddyboss-wall') ); ?>" />
					</p><?php
				} else {
					settings_fields( $tab );
					do_settings_sections( $tab );
				} ?>

			</form>
		</div>

	<?php
	}
	
	function plugin_options_tabs() {
		$current_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'buddyboss_wall_plugin_options';

		echo '<h2 class="nav-tab-wrapper">';
		foreach ( $this->plugin_settings_tabs as $tab_key => $tab_caption ) {
			$active = $current_tab == $tab_key ? 'nav-tab-active' : '';
			echo '<a class="nav-tab ' . $active . '" href="?page=' . 'buddyboss-wall' . '&tab=' . $tab_key . '">' . $tab_caption . '</a>';
		}
		echo '</h2>';
	}

	public function add_action_links( $links, $file ) {
		// Return normal links if not this plugin
		if ( plugin_basename( basename( constant( 'BUDDYBOSS_WALL_PLUGIN_DIR' ) ) . '/buddyboss-wall.php' ) != $file ) {
			return $links;
		}

		$mylinks = array(
			'<a href="' . esc_url( $this->plugin_settings_url ) . '">' . __( "Settings", "buddyboss-wall" ) . '</a>',
		);
		return array_merge( $links, $mylinks );
	}

	public function save_network_settings_page() {
		if ( ! check_admin_referer( 'buddyboss_wall_plugin_options-options' ) )
			return;

		if ( ! current_user_can( $this->capability ) )
			die( 'Access denied!' );

		if ( isset( $_POST[ 'bboss_g_s_settings_submit' ] ) ) {
			$submitted = stripslashes_deep( $_POST[ 'buddyboss_wall_plugin_options' ] );
			$submitted = $this->plugin_options_validate( $submitted );

			update_site_option( 'buddyboss_wall_plugin_options', $submitted );
		}

		// Where are we redirecting to?
		$base_url = trailingslashit( network_admin_url() ) . 'settings.php';
		$redirect_url = esc_url_raw(add_query_arg( array( 'page' => $this->plugin_slug, 'updated' => 'true' ), $base_url ));

		// Redirect
		wp_redirect( $redirect_url );
		die();
	}
	
	/**
	 * General settings section
	 *
	 * @since BuddyBoss Wall (1.0.0)
	 */
	public function section_general()
	{
		_e( 'Make sure BuddyPress <strong>Activity Streams</strong> are enabled for the Wall to function. Go to <em>Settings &rarr; BuddyPress &rarr; Components</em>', 'buddyboss-wall' );
	}

	/**
	 * Style settings section
	 *
	 * @since BuddyBoss Wall (1.0.0)
	 */
	public function section_style()
	{

	}

	/**
	 * Validate plugin option
	 *
	 * @since BuddyBoss Wall (1.0.0)
	 */
	public function plugin_options_validate( $input )
	{
		$input['enabled']              = isset( $input['enabled'] ) ? sanitize_text_field( $input['enabled'] ) : '';
		$input['enabled-wall-privacy'] = isset( $input['enabled-wall-privacy'] ) ? sanitize_text_field( $input['enabled-wall-privacy'] ) : '';
		$input['enabled_link_preview'] = isset( $input['enabled_link_preview'] ) ? sanitize_text_field( $input['enabled_link_preview'] ) : '';

		return $input; // return validated input
	}

	/* Settings Page Options
	 * ===================================================================
	 */

	/**
	 * Setting > BuddyBoss Wall Enabled
	 *
	 * @since BuddyBoss Wall (1.0.0)
	 *
	 * @uses BuddyBoss_Wall_Admin::option() Get plugin option
	 */
	public function setting_enabled()
	{
		$value = buddyboss_wall()->is_enabled();

		$checked = '';

		if ( $value )
		{
			$checked = ' checked="checked" ';
		}

		echo "<input ".$checked." id='enabled' name='buddyboss_wall_plugin_options[enabled]' type='checkbox' />  ";

		_e( 'Enable Wall Component.', 'buddyboss-wall' );
	}

    /**
     * Setting > all members
     *
     * @since BuddyBoss Wall (1.0.0)
     *
     * @uses BuddyBoss_Wall_Admin::option() Get plugin option
     */
    public function setting_available_to_allmembers()
    {
        $value = $this->option( 'all-members' );

        $checked = '';

        if ( $value )
        {
            $checked = ' checked="checked" ';
        }

        echo "<input ".$checked." id='all-members' name='buddyboss_wall_plugin_options[all-members]' type='checkbox' />  ";

        _e('Allow Wall posting for all members (not just friends).', 'buddyboss-wall');
    }

    /**
     * Setting > enabled wall privacy
     *
     * @since BuddyBoss Wall (1.0.0)
     *
     * @uses BuddyBoss_Wall_Admin::option() Get plugin option
     */
    public function setting_enabled_wall_privacy()
    {
        $value = $this->option( 'enabled-wall-privacy' );

        $checked = '';

        if ( $value )
        {
            $checked = ' checked="checked" ';
        }

        echo "<input ".$checked." id='enabled-wall-privacy' name='buddyboss_wall_plugin_options[enabled-wall-privacy]' type='checkbox' />  ";

        _e('Allow members to set privacy options when they post.', 'buddyboss-wall');
    }
    
    /**
     * Setting > enabled link preview
     *
     * @since BuddyBoss Wall (1.2.1)
     *
     * @uses BuddyBoss_Wall_Admin::option() Get plugin option
     */
    public function setting_enabled_link_preview() {
        $value = $this->option( 'enabled_link_preview' );
        
        $checked = $value ? ' checked="checked" ' : '';
        echo "<input ".$checked." id='enabled_link_preview' name='buddyboss_wall_plugin_options[enabled_link_preview]' type='checkbox' />  ";

        _e('Allow link previews in activity posts.', 'buddyboss-wall');
    }
	
    /**
     * Setting > disbale everyone privacy option
     *
     * @since BuddyBoss Wall (1.2.3)
     *
     * @uses BuddyBoss_Wall_Admin::option() Get plugin option
     */
    public function setting_disable_everyone_option() {
        $value = $this->option( 'disable_everyone_option' );
        
        $checked = $value ? ' checked="checked" ' : '';
        echo "<input ".$checked." id='disable_everyone_option' name='buddyboss_wall_plugin_options[disable_everyone_option]' type='checkbox' />  ";

        _e('Disable the "Everyone" privacy option.', 'buddyboss-wall');
    }
	
    /**
     * Setting > Activity posted text
     *
     * @since BuddyBoss Wall (1.1.9)
     *
     * @uses BuddyBoss_Wall_Admin::option() Get plugin option
     */
    public function setting_activity_posted_text()
    {
        $value = $this->option( 'activity-posted-text' );

       if( !$value ){
			$value = 'yes';
		}
		
		$options = array(
			'yes'	=> __( 'You', 'buddyboss-wall' ),
			'no'	=> __( 'Username', 'buddyboss-wall' )
		);
		foreach( $options as $option=>$label ){
			$checked = $value == $option ? ' checked' : '';
			echo '<label><input type="radio" name="buddyboss_wall_plugin_options[activity-posted-text]" value="'. $option . '" '. $checked . '>' . $label . '</label>&nbsp;&nbsp;';
		}
		
		echo '<p class="description">' . __( 'In your wall, show activity posted by \'You\' or \'Username\'.', 'buddyboss-wall' ) . '</p>';
    }
	
    /**
     * Setting > default subnav
     *
     * @since BuddyBoss Wall (1.2.3)
     *
     * @uses BuddyBoss_Wall_Admin::option() Get plugin option
     */
    public function setting_default_profile_tab()
    {
        $value = $this->option( 'setting_default_profile_tab' );

       if( !$value ){
			$value = 'wall';
		}
		
		$options = array(
			'wall'	=> __( 'Wall', 'buddyboss-wall' ),
			'newsfeed'	=> __( 'News Feed', 'buddyboss-wall' )
		);
		foreach( $options as $option=>$label ){
			$checked = $value == $option ? ' checked' : '';
			echo '<label><input type="radio" name="buddyboss_wall_plugin_options[setting_default_profile_tab]" value="'. $option . '" '. $checked . '>' . $label . '</label>&nbsp;&nbsp;';
		}
		
		echo '<p class="description">' . __( 'Select the default Wall tab on profiles.', 'buddyboss-wall' ) . '</p>';
    }
	
    /**
     * Setting > Activity like text
     *
     * @since BuddyBoss Wall (1.2.1)
     *
     * @uses BuddyBoss_Wall_Admin::option() Get plugin option
     */
    public function setting_activity_like_text()
    {
        $value = $this->option( 'activity-like-text' );

       if( !$value ){
			$value = 'yes';
		}
		
		$options = array(
			'yes'	=> __( 'You', 'buddyboss-wall' ),
			'no'	=> __( 'Username', 'buddyboss-wall' )
		);
		foreach( $options as $option=>$label ){
			$checked = $value == $option ? ' checked' : '';
			echo '<label><input type="radio" name="buddyboss_wall_plugin_options[activity-like-text]" value="'. $option . '" '. $checked . '>' . $label . '</label>&nbsp;&nbsp;';
		}
		
		echo '<p class="description">' . __( 'In your wall, show activity liked by \'You\' or \'Username\'.', 'buddyboss-wall' ) . '</p>';
    }
	
}
// End class BuddyBoss_Wall_Admin

endif;

?>