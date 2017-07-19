<?php
/**
 * Site module.
 * Manages all access to the local WordPress site;
 * For example: Storing and fetching settings, activating plugins, etc.
 *
 * @since  4.0.0
 * @package WPMUDEV_Dashboard
 */

/**
 * The site-module class.
 */
class WPMUDEV_Dashboard_Site {

	/**
	 * URL to the Dashboard plugin; used to load images, etc.
	 *
	 * @var string (URL)
	 */
	public $plugin_url = '';

	/**
	 * Name of the Dashboard plugin directory (relative to wp-content/plugins)
	 *
	 * @var string (Path)
	 */
	public $plugin_dir = '';

	/**
	 * Full path to the plugin directory
	 *
	 * @var string (Path)
	 */
	public $plugin_path = '';

	/**
	 * The PID of the Upfront root theme.
	 * Upfront is required for our modern themes. This is used to automatically
	 * install Upfront when required.
	 *
	 * @var int (Project ID)
	 */
	public $id_upfront = 938297;

	/**
	 * The PID of our "133 Theme Pack" package.
	 * This package needs some special treatment; since it contains many themes
	 * we need to update the package when only one of those themes changed.
	 *
	 * @var int (Project ID)
	 */
	public $id_farm133_themes = 128;

	/**
	 * This is the highest Project-ID of the legacy themes: If the theme has an
	 * higher ID it means that it requires Upfront.
	 *
	 * @var int (Project ID)
	 */
	public $id_legacy_themes = 237;

	/**
	 * Internal cache for plugin options (stored in DB).
	 *
	 * This property is used by the functions get_option() and set_option()
	 *
	 * @var array (List of settings)
	 */
	protected $option_cache = array();

	/**
	 * Internal cache for plugin options (stored in DB).
	 *
	 * This property is used by the functions get_option() and set_option()
	 *
	 * @var array (List of settings)
	 */
	protected $option_hash = array();

	/**
	 * Caches the results of our filesystem scan (list of plugins, themes)
	 *
	 * @var array
	 */
	protected static $_cache_filesystem = false;

	/**
	 * Caches the modified theme-updates transient.
	 *
	 * @var array
	 */
	protected static $_cache_themeupdates = false;

	/**
	 * Caches the modified plugin-updates transient.
	 *
	 * @var array
	 */
	protected static $_cache_pluginupdates = false;

	/**
	 * Stores return values of get_project_infos()
	 *
	 * @var array
	 */
	protected static $_cache_projectinfos = false;

	/**
	 * Set up the Site module. Here we load and initialize the settings.
	 *
	 * @since 4.0.0
	 * @param string $main_file Path to the plugins main file.
	 * @internal
	 */
	public function __construct( $main_file ) {
		$this->init_flags();

		// Prepare module settings.
		$this->plugin_url = trailingslashit( plugins_url( '', $main_file ) );
		$this->plugin_dir = dirname( plugin_basename( $main_file ) );
		$this->plugin_path = trailingslashit( dirname( $main_file ) );

		// Process any actions triggered by the UI (e.g. save data).
		add_action( 'current_screen', array( $this, 'process_actions' ) );

		// Process ajax actions.
		$ajax_actions = array(
			'wdp-get-project',
			'wdp-project-activate',
			'wdp-project-deactivate',
			'wdp-project-update',
			'wdp-project-install',
			'wdp-project-install-upfront',
			'wdp-projectsearch',
			'wdp-usersearch',
			'wdp-save-setting',
			'wdp-save-setting-bool',
			'wdp-save-setting-int',
			'wdp-show-popup',
			'wdp-changelog',
			'wdp-credentials',
		);
		foreach ( $ajax_actions as $action ) {
			add_action( "wp_ajax_$action", array( $this, 'process_ajax' ) );
		}

		$nopriv_ajax_actions = array(
			'wdpunauth',
			'wdpupdate',
			'wdpupdate-batch',
			'wdpupdate-cancel',
			'wdpupdate-status',
			'wdpreport',
			'wdplogout',
		);
		foreach ( $nopriv_ajax_actions as $action ) {
			add_action( "wp_ajax_$action", array( $this, 'nopriv_process_ajax' ) );
			add_action( "wp_ajax_nopriv_$action", array( $this, 'nopriv_process_ajax' ) );
		}

		// Check for compatibility issues and display a notificaton if needed.
		add_action(
			'admin_init',
			array( $this, 'compatibility_warnings' )
		);

		add_action( 'update-core.php', array( $this, 'refresh_local_projects_wrapper' ) );
		add_action( 'load-plugins.php', array( $this, 'refresh_local_projects_wrapper' ) );
		add_action( 'load-update.php', array( $this, 'refresh_local_projects_wrapper' ) );
		add_action( 'load-update-core.php', array( $this, 'refresh_local_projects_wrapper' ) );
		add_action( 'load-themes.php', array( $this, 'refresh_local_projects_wrapper' ) );
		add_action( 'wp_update_plugins', array( $this, 'refresh_local_projects_wrapper' ) );
		add_action( 'wp_update_themes', array( $this, 'refresh_local_projects_wrapper' ) );

		// Refresh after upgrade/install.
		add_action(
			'upgrader_process_complete',
			array( $this, 'after_local_files_changed' ),
			10, 999
		);
		add_action(
			'delete_site_transient_update_plugins',
			array( $this, 'after_transient_changed' )
		);
		add_action(
			'delete_site_transient_update_themes',
			array( $this, 'after_transient_changed' )
		);

		// Add WPMUDEV projects to the WP updates list.
		add_filter(
			'site_transient_update_plugins',
			array( $this, 'filter_plugin_update_count' )
		);
		add_filter(
			'site_transient_update_themes',
			array( $this, 'filter_theme_update_count' )
		);

		// Override the theme/plugin-installation API of WordPress core.
		add_filter(
			'plugins_api',
			array( $this, 'filter_plugin_update_info' ),
			101, 3 // Run later to work with bad autoupdate plugins.
		);
		add_filter(
			'themes_api',
			array( $this, 'filter_plugin_update_info' ),
			101, 3 // Run later to work with bad autoupdate plugins.
		);

		// Hook up our own plugin changelog iframe.
		add_action(
			'install_plugins_pre_plugin-information',
			array( $this, 'install_plugin_information' ),
			0
		);

		/*
		// Schedule event that collects data about active plugins/themes.
		Not finished because of low priority.

		if ( is_multisite() && is_main_site() ) {
			if ( ! wp_next_scheduled( 'wpmudev_scheduled_project_status' ) ) {
				wp_schedule_event( time(), 'twicedaily', 'wpmudev_scheduled_project_status' );
			}

			add_action(
				'wpmudev_scheduled_project_status',
				array( $this, 'refresh_blog_project_status' )
			);
		} elseif ( wp_next_scheduled( 'wpmudev_scheduled_project_status' ) ) {
			// In case the cron job was already installed in a sub-site...
			wp_clear_scheduled_hook( 'wpmudev_scheduled_project_status' );
		}
		*/

		/**
		 * Run custom initialization code for the Site module.
		 *
		 * @since  4.0.0
		 * @var  WPMUDEV_Dashboard_Site The dashboards Site module.
		 */
		do_action( 'wpmudev_dashboard_site_init', $this );
	}

	/**
	 * Initialize all plugin options in the DB during activation.
	 * This function is called by the `activate_plugin` plugin in the main
	 * plugin file.
	 *
	 * Note:
	 * Function contains a complete list of all used Dashboard settings.
	 *
	 * @since  4.0.0
	 * @internal
	 * @param  string $action Can be set to 'reset' to overwrite all plugin
	 *                options with the initial value (as if plugin was just
	 *                installed for the first time).
	 *                Any other value will only add the option if it's missing.
	 */
	public function init_options( $action = 'init' ) {
		// Initialize the plugin options stored in the WP Database.
		$options = array(
			'limit_to_user' => '',
			'remote_access' => '',
			'refresh_remote_flag' => 0,
			'refresh_local_flag' => 0,
			'refresh_profile_flag' => 0,
			'updates_data' => '',
			'profile_data' => '',
			'farm133_themes' => '',
			'updates_available' => '',
			'last_run_updates' => 0,
			'last_run_profile' => 0,
			'last_check_upfront' => 0,
			'last_check_autoupdate' => 0,
			'staff_notes' => '',
			'redirected_v4' => 0, // We want to redirect all users after first v4 activation!
			'autoupdate_dashboard' => 1,
			'autoupdate_schedule' => array(),
			'notifications' => array(),
			// 'blog_active_projects' => array(), // Only used on multisite. Not finished.
			'auth_user' => null, // NULL means: Ignore during 'reset' action.
		);

		foreach ( $options as $key => $default_val ) {
			if ( 'reset' == $action && null !== $default_val ) {
				// Reset plugin to initial state.
				$this->set_option( $key, $default_val );
			} else {
				// Do not reset, just add if missing.
				if ( null === $default_val ) { $default_val = ''; }
				$this->add_option( $key, $default_val );
			}
		}
	}


	/*
	 * *********************************************************************** *
	 * *     INTERNAL HELPER FUNCTIONS
	 * *********************************************************************** *
	 */


	/**
	 * Defines missing const flags with default values.
	 * This saves us from checking `if ( defined( ... ) )` all the time.
	 *
	 * Complete list of all supported Dashboard constants:
	 *
	 * - WPMUDEV_APIKEY .. Default: (undefined)
	 *     Define a static API key that cannot be changed via Dashboard.
	 *     If this constant is used then login/logout functions are not
	 *     available in the UI.
	 *
	 * - WPMUDEV_LIMIT_TO_USER .. Default: ''
	 *     Additional users that can access the Dashboard (comma separated).
	 *     This constant will override the user-list that can be defined on
	 *     the plugins Settings tab.
	 *
	 * - WPMUDEV_DISABLE_REMOTE_ACCESS .. Default: false
	 *     Set to true to disable the plugins external access functions.
	 *
	 * - WPMUDEV_MENU_LOCATION .. Default: '3.012'
	 *     Position of the WPMUDEV menu-item in the admin menu.
	 *
	 * - WPMUDEV_NO_AUTOACTIVATE .. Default: false
	 *     Default behavior of Install button is install + activate.
	 *     Set to true to only install the plugin, no activation.
	 *     (only for plugins on single-site)
	 *
	 * - WPMUDEV_CUSTOM_API_SERVER .. Default: false
	 *     Custom API Server from which to get membership details, etc.
	 *
	 * - WPMUDEV_API_UNCOMPRESSED .. Default: false
	 *     Set to true so API calls request uncompressed response values.
	 *
	 * - WPMUDEV_API_AUTHORIZATION .. Default: false
	 *     If the custom API Server needs some kind of authentication.
	 *
	 * - WPMUDEV_API_DEBUG .. Default: false
	 *     If set to true then all API calls are logged in the WordPress
	 *     logfile. This will only work if WP_DEBUG is enabled as well.
	 *
	 * - WPMUDEV_API_DEBUG_ALL .. Default: false
	 *     Adds more details to the output of WPMUDEV_API_DEBUG.
	 *
	 * - WPMUDEV_IS_REMOTE .. Default: (undefined)
	 *     This flag is set by the ajax handler after verifying an incoming
	 *     request from the remote dashboard. True means: The request is
	 *     authorized and will be processed.
	 *
	 *     To disable all remote calls add this in wp-config (not recommended):
	 *     define( 'WPMUDEV_IS_REMOTE', false );
	 *
	 * @since  4.0.0
	 * @internal
	 */
	protected function init_flags() {
		// Do not initialize: WPMUDEV_APIKEY!
		// Do not initialize: WPMUDEV_IS_REMOTE!
		$flags = array(
			'WPMUDEV_LIMIT_TO_USER' => false,
			'WPMUDEV_DISABLE_REMOTE_ACCESS' => false,
			'WPMUDEV_MENU_LOCATION' => '3.012',
			'WPMUDEV_NO_AUTOACTIVATE' => false,
			'WPMUDEV_CUSTOM_API_SERVER' => false,
			'WPMUDEV_API_UNCOMPRESSED' => false,
			'WPMUDEV_API_AUTHORIZATION' => false,
			'WPMUDEV_API_DEBUG' => false,
			'WPMUDEV_API_DEBUG_ALL' => false,
		);

		foreach ( $flags as $flag => $default_val ) {
			if ( ! defined( $flag ) ) { define( $flag, $default_val ); }
		}

		if ( WPMUDEV_API_DEBUG && WPMUDEV_API_DEBUG_ALL ) {
			// This marks a new request.
			error_log( '[WPMUDEV] ========== API debugging enabled ==========' );
		}
	}

	/**
	 * Process actions when page loads.
	 *
	 * @since  4.0.0
	 * @internal
	 * @param  WP_Screen $current_screen The current_screen object.
	 */
	public function process_actions( $current_screen ) {
		$no_nonce = array(
			'check-updates',
		);

		// Remove the "Changes saved" message when user refreshes the browser window.
		if ( empty( $_POST ) ) {
			$err = isset( $_GET['failed'] ) ? intval( $_GET['failed'] ) : false;
			$ok = isset( $_GET['success'] ) ? intval( $_GET['success'] ) : false;

			if ( ( $ok && $ok < time() ) || ( $err && $err < time() ) ) {
				$url = esc_url_raw(
					remove_query_arg( array( 'success', 'failed', 'wpmudev_msg' ) )
				);
				header( 'X-Redirect-From: SITE process_actions top' );
				wp_safe_redirect( $url );
				exit;
			}
		}

		// Do nothing when the current page is NOT a WPMU DEV menu item.
		if ( ! strpos( $current_screen->base, 'page_wpmudev' ) ) {
			return;
		}

		// Do nothing if either action or nonce is missing.
		if ( empty( $_REQUEST['action'] ) ) { return; }

		$action = $_REQUEST['action'];

		// Skip the nonce-check if the action does not require it.
		if ( ! in_array( $action, $no_nonce ) ) {
			if ( empty( $_REQUEST['hash'] ) ) { return; }
			$nonce = $_REQUEST['hash'];

			// Do nothing if the nonce is invalid.
			if ( ! wp_verify_nonce( $nonce, $action ) ) {
				return;
			}
		}

		// Do nothing if the user is not allowed to use the Dashboard.
		if ( ! $this->allowed_user() ) {
			return;
		}

		$res = $this->_process_action( $action );
		$redirect = remove_query_arg( array( 'action', 'hash', 'success', 'failed' ) );

		switch ( $res ) {
			case 'OK':
				$redirect = add_query_arg( 'success', 2 + time(), $redirect );
				break;

			case 'ERR':
				$redirect = add_query_arg( 'failed', 2 + time(), $redirect );
				break;

			case 'SILENT':
				// Nothing.
				break;
		}

		if ( $redirect ) {
			header( 'X-Redirect-From: SITE process_actions bottom' );
			wp_safe_redirect( esc_url_raw( $redirect ) );
			exit;
		}
	}

	/**
	 * Internal processing function to execute specific actions upon page load.
	 * When this function is called we already confirmed that the user is
	 * permitted to use the dashboard and that a correct nonce was supplied.
	 *
	 * @since  4.0.0
	 * @internal
	 * @param  string $action The action to execute.
	 * @return string Either OK|SOK|ERR|SILENT.
	 *         OK     .. Action successful. Display "Saved" message.
	 *         ERR    .. Action failed. Display "Failed" message.
	 *         SILENT .. Do not display any message.
	 */
	protected function _process_action( $action ) {
		do_action( 'wpmudev_dashboard_action-' . $action );
		$success = 'SILENT';

		switch ( $action ) {
			// Tab: Support
			// Function Grant support access.
			case 'remote-grant':
				$success = WPMUDEV_Dashboard::$api->enable_remote_access( 'start' );
				break;

			// Tab: Support
			// Function Revoke support access.
			case 'remote-revoke';
				$success = WPMUDEV_Dashboard::$api->revoke_remote_access();
				break;

			// Tab: Support
			// Function Extend support access.
			case 'remote-extend':
				$success = WPMUDEV_Dashboard::$api->enable_remote_access( 'extend' );
				break;

			// Tab: Support
			// Function Save notes for support staff.
			case 'staff-note':
				$notes = '';
				if ( isset( $_REQUEST['notes'] ) ) {
					$notes = stripslashes( $_REQUEST['notes'] );
				}
				WPMUDEV_Dashboard::$site->set_option( 'staff_notes', $notes );
				break;

			// Tab: Settings
			// Function Add new admin user for Dashboard.
			case 'admin-add':
				if ( ! empty( $_REQUEST['user'] ) ) {
					$user_id = $_REQUEST['user'];
					$success = WPMUDEV_Dashboard::$site->add_allowed_user( $user_id );
				}
				break;

			// Tab: Settings
			// Function Remove other admin user for Dashboard.
			case 'admin-remove':
				if ( ! empty( $_REQUEST['user'] ) ) {
					$user_id = $_REQUEST['user'];
					$success = WPMUDEV_Dashboard::$site->remove_allowed_user( $user_id );
				}
				break;

			// Tab: Plugins
			// Function to check for updates again.
			case 'check-updates':
				WPMUDEV_Dashboard::$site->set_option( 'refresh_remote_flag', 1 );
				WPMUDEV_Dashboard::$site->set_option( 'refresh_local_flag', 1 );
				WPMUDEV_Dashboard::$site->set_option( 'refresh_profile_flag', 1 );
				WPMUDEV_Dashboard::$site->set_option( 'updates_available', false );
				$success = 'SILENT';
				break;
		}

		if ( true === $success ) {
			$success = 'OK';
		} elseif ( false === $success ) {
			$success = 'ERR';
		}

		return $success;
	}

	/**
	 * Entry point for all Ajax requests of the plugin.
	 *
	 * All Ajax handlers point to this function instead of an individual
	 * callback function; this function validates the user before processing the
	 * actual request.
	 *
	 * @since  4.0.0
	 * @internal
	 */
	public function process_ajax() {
		ob_start();

		/*
		 * Do nothing if function was called incorrectly.
		 *
		 * Note: `hash` is a normal wp-nonce.
		 *       We just use name="hash" instead of name="_wpnonce"
		 */
		if ( empty( $_REQUEST['action'] ) || empty( $_REQUEST['hash'] ) ) {
			wp_send_json_error(
				array( 'message' => __( 'Required field missing', 'wpmudev' ) )
			);
		}

		$action = str_replace( 'wdp-', '', $_REQUEST['action'] );
		$nonce = $_REQUEST['hash'];

		// Do nothing if the nonce is invalid.
		if ( ! wp_verify_nonce( $nonce, $action ) ) {
			wp_send_json_error(
				array( 'message' => __( 'Something went wrong, please refresh the page and try again.', 'wpmudev' ) )
			);
		}

		// Do nothing if the user is not allowed to use the Dashboard.
		if ( ! $this->allowed_user() ) {
			wp_send_json_error(
				array( 'message' => __( 'Sorry, you are not allowed to do this.', 'wpmudev' ) )
			);
		}

		$this->_process_ajax( $action, false );

		// When the _projess_ajax function did not send a response assume error.
		wp_send_json_error(
			array( 'message' => __( 'Unexpected action, we could not handle it.', 'wpmudev' ) )
		);
	}

	/**
	 * Entry point for all PUBLIC Ajax requests of the plugin.
	 *
	 * All Ajax handlers point to this function instead of an individual
	 * callback function; These functions are available even when logged out.
	 *
	 * @since  4.0.0
	 * @internal
	 */
	public function nopriv_process_ajax() {
		ob_start();

		// Do nothing if function was called incorrectly.
		if ( empty( $_REQUEST['action'] ) ) {
			wp_send_json_error(
				array( 'message' => __( 'Required field missing', 'wpmudev' ) )
			);
			exit;
		}

		$action = $_REQUEST['action'];

		$this->_process_ajax( $action, true );

		// When the _projess_ajax function did not send a response assume error.
		wp_send_json_error();
	}

	/**
	 * Internal processing function to execute specific ajax actions.
	 * When this function is called we already confirmed that the user is
	 * permitted to use the dashboard.
	 *
	 * @since  4.0.0
	 * @internal
	 * @param  string $action The action to execute.
	 * @param  bool   $allow_guests If true, then only public ajax-actions are
	 *                processed (which use a special authentication method) but
	 *                logged-in-only actions are skipped for security reasons.
	 */
	protected function _process_ajax( $action, $allow_guests = false ) {
		$pid = 0;
		$pids = array();
		$is_network = false;

		if ( isset( $_REQUEST['pid'] ) ) {
			$pid = intval( $_REQUEST['pid'] );
		} elseif ( isset( $_REQUEST['pids'] ) ) {
			$pids = json_decode( stripslashes( $_REQUEST['pids'] ) );
		}

		// Those actions are ONLY available for logged-in admin users.
		if ( ! $allow_guests ) {
			if ( isset( $_REQUEST['is_network'] ) ) {
				$is_network = (1 == intval( $_REQUEST['is_network'] ));
			}

			switch ( $action ) {
				case 'get-project':
					if ( $pid ) {
						WPMUDEV_Dashboard::$ui->render_project( $pid );
					}
					break;

				case 'check-updates':
					WPMUDEV_Dashboard::$site->set_option( 'refresh_remote_flag', 1 );
					WPMUDEV_Dashboard::$site->set_option( 'refresh_local_flag', 1 );
					WPMUDEV_Dashboard::$site->set_option( 'refresh_profile_flag', 1 );
					WPMUDEV_Dashboard::$site->set_option( 'updates_available', false );
					$this->send_json_success();
					break;

				case 'project-activate':
					if ( $pid ) {
						$local = $this->get_cached_projects( $pid );
						$other_pids = false;

						if ( 'plugin' == $local['type'] ) {
							activate_plugins( $local['filename'], '', $is_network );
						} elseif ( 'theme' == $local['type'] ) {
							if ( $is_network ) {
								// Allow theme network wide.
								$allowed_themes = get_site_option( 'allowedthemes' );
								$allowed_themes[ $local['slug'] ] = true;
								update_site_option( 'allowedthemes', $allowed_themes );
							} else {
								// We only activate themes on single-sites.
								$old_theme = $this->get_active_wpmu_theme();
								if ( $old_theme ) {
									$other_pids = array( $old_theme );
								}
								switch_theme( $local['slug'] );
							}
						}
						self::$_cache_projectinfos = null;
						self::$_cache_filesystem = null;

						WPMUDEV_Dashboard::$ui->render_project( $pid, $other_pids, false, true );
					}
					break;

				case 'project-deactivate':
					if ( $pid ) {
						$local = $this->get_cached_projects( $pid );

						if ( 'plugin' == $local['type'] ) {
							deactivate_plugins( $local['filename'], '', $is_network );
						} elseif ( 'theme' == $local['type'] ) {
							if ( $is_network ) {
								// Disallow theme network wide.
								$allowed_themes = get_site_option( 'allowedthemes' );
								unset( $allowed_themes[ $local['slug'] ] );
								update_site_option( 'allowedthemes', $allowed_themes );
							}
						}
						self::$_cache_projectinfos = null;
						self::$_cache_filesystem = null;

						WPMUDEV_Dashboard::$ui->render_project( $pid, false, false, true );
					}
					break;

				case 'project-install':
					if ( $pid ) {
						if ( WPMUDEV_Dashboard::$upgrader->install( $pid ) ) {
							$local = $this->get_cached_projects( $pid );

							WPMUDEV_Dashboard::$ui->render_project(
								$pid,
								false,
								'popup-after-install'
							);
						} else {
							WPMUDEV_Dashboard::$ui->render_project(
								$pid,
								false,
								'popup-after-install-failed'
							);
						}
					}
					break;

				case 'project-install-upfront':
					if ( ! $this->is_upfront_installed() ) {
						$id_upfront = $this->id_upfront;

						$success = WPMUDEV_Dashboard::$upgrader->install( $id_upfront );

						if ( ! $success ) {
							$err = WPMUDEV_Dashboard::$upgrader->get_error();
							wp_send_json_error( $err );
						}
					}

					if ( $pid ) {
						$local = $this->get_cached_projects( $pid );
						WPMUDEV_Dashboard::$ui->render_project(
							$pid,
							false,
							'popup-after-install-upfront'
						);
					}
					break;

				case 'project-update':
					if ( $pid ) {
						$success = WPMUDEV_Dashboard::$upgrader->upgrade( $pid );

						if ( ! $success ) {
							$err = WPMUDEV_Dashboard::$upgrader->get_error();
							$this->send_json_error( $err );
						}

						WPMUDEV_Dashboard::$ui->render_project( $pid );
					}
					break;

				case 'usersearch':
					$items = array();
					if ( ! empty( $_REQUEST['q'] ) ) {
						$users = $this->get_potential_users( $_REQUEST['q'] );
						foreach ( $users as $user ) {
							$items[] = array(
								'id' => $user->id,
								'thumb' => $user->avatar,
								'label' => sprintf(
									'<span class="name title">%1$s</span> <span class="email">%2$s</span>',
									$user->name,
									$user->email
								),
							);
						}
					}
					$this->send_json_success( $items );
					break;

				case 'projectsearch':
					$items = array();
					$urls = WPMUDEV_Dashboard::$ui->page_urls;
					if ( ! empty( $_REQUEST['q'] ) ) {
						$projects = $this->find_projects_by_name( $_REQUEST['q'] );
						foreach ( $projects as $item ) {
							if ( 'theme' == $item->type ) {
								$url = $urls->themes_url;
								$icon = '<i class="dev-icon dev-icon-theme"></i> ';
							} elseif ( 'plugin' == $item->type ) {
								$url = $urls->plugins_url;
								$icon = '<i class="dev-icon dev-icon-plugin"></i> ';
							}
							$items[] = array(
								'id' => $item->id,
								'thumb' => $item->logo,
								'label' => sprintf(
									'<a href="%3$s"><span class="name title">%1$s</span> <span class="desc">%2$s</span></a>',
									$icon . $item->name,
									$item->desc,
									$url . '#pid=' . $item->id
								),
							);
						}
					}
					$this->send_json_success( $items );
					break;

				case 'save-setting':
				case 'save-setting-bool':
				case 'save-setting-int':
					if ( ! empty( $_REQUEST['name'] ) && isset( $_REQUEST['value'] ) ) {
						$name = sanitize_html_class( $_REQUEST['name'] );
						$value = $_REQUEST['value'];

						switch ( $action ) {
							case 'save-setting-bool':
								if ( 'true' == $value
									|| '1' == $value
									|| 'on' == $value
									|| 'yes' == $value
								) {
									$value = true;
								} else {
									$value = false;
								}
								break;

							case 'save-setting-int':
								$value = intval( $value );
								break;
						}

						WPMUDEV_Dashboard::$site->set_option( $name, $value );
					}
					$this->send_json_success();
					break;

				case 'show-popup':
					if ( ! empty( $_REQUEST['type'] ) ) {
						$type = $_REQUEST['type'];
						WPMUDEV_Dashboard::$ui->show_popup( $type, $pid );
					}
					break;

				case 'changelog':
					WPMUDEV_Dashboard::$ui->wp_popup_changelog( $pid );
					break;

				case 'credentials':
					// Remember credentials for FTP update/installation, for 15 min.
					if ( WPMUDEV_Dashboard::$upgrader->remember_credentials() ) {
						$this->send_json_success();
					} else {
						$this->send_json_error();
					}
					break;

				default:
					$this->send_json_error(
						array(
							'message' => sprintf(
								__( 'Unknown action: %s', 'wpmudev' ),
								esc_html( $action )
							),
						)
					);
					break;
			}
		}

		// Those actions are available for logged-in users AND guests.
		if ( $allow_guests ) {
			switch ( $action ) {
				case 'wdpunauth':
					/*
					 * Required POST params:
					 * - wdpunkey .. Temporary Auth Key from the DB.
					 * - staff    .. Name of the user who loggs in.
					 */
					WPMUDEV_Dashboard::$api->authenticate_remote_access();
					break;

				case 'wdpupdate':
					/*
					 * Required HEADER values:
					 * - wdp-auth
					 * Required POST params:
					 * - pid .. single ID
					 */

					// Will `die()` if authentication fails.
					$args = array( 'action', 'pid' ); // Authentication: $action . $pid.
					WPMUDEV_Dashboard::$api->validate_hash( $args );

					$success = WPMUDEV_Dashboard::$upgrader->upgrade( $pid );

					if ( $success ) {
						$this->send_json_success();
					} else {
						$err = WPMUDEV_Dashboard::$upgrader->get_error();
						$this->send_json_error( $err );
					}
					break;

				case 'wdpupdate-batch':
					/*
					 * Required HEADER values:
					 * - wdp-auth
					 * Required POST params:
					 * - pid .. comma-separated list
					 */

					// Will `die()` if authentication fails.
					$args = array( 'action', 'pids' ); // Authentication: $action . $pids.
					WPMUDEV_Dashboard::$api->validate_hash( $args );

					// Will send a json-ajax response and `die()`.
					WPMUDEV_Dashboard::$upgrader->async_upgrade( $pids );
					break;

				case 'wdpupdate-cancel':
					/*
					 * Required HEADER values:
					 * - wdp-auth
					 */

					$args = array( 'action' ); // Authentication: $action.
					WPMUDEV_Dashboard::$api->validate_hash( $args );

					// Will send a json-ajax response and `die()`.
					WPMUDEV_Dashboard::$upgrader->async_upgrade_cancel();

					$this->send_json_success();
					break;

				case 'wdpupdate-status':
					/*
					 * Required HEADER values:
					 * - wdp-auth
					 */

					$args = array( 'action' ); // Authentication: $action.
					WPMUDEV_Dashboard::$api->validate_hash( $args );

					$state = WPMUDEV_Dashboard::$upgrader->async_upgrade_status();

					$this->send_json_success( $state );
					break;

				case 'wdpreport':
					/*
					 * Required HEADER values:
					 * - wdp-auth
					 */

					// Will `die()` if authentication fails.
					$args = array( 'action' ); // Authentication: $action.
					WPMUDEV_Dashboard::$api->validate_hash( $args );

					// Simply refresh the membership details.
					WPMUDEV_Dashboard::$api->refresh_membership_data();

					$this->send_json_success();
					break;

				case 'wdplogout':
					/*
					 * Required HEADER values:
					 * - wdp-auth
					 */

					// Will `die()` if authentication fails.
					$args = array( 'action' ); // Authentication: $action.
					WPMUDEV_Dashboard::$api->validate_hash( $args );

					$this->logout( false );

					$this->send_json_success();
					break;

				default:
					$this->send_json_error(
						array(
							'message' => sprintf(
								__( 'Unknown action: %s', 'wpmudev' ),
								esc_html( $action )
							),
						)
					);
					break;
			}
		}
	}

	/**
	 * Clear all output buffers and send an JSON reponse to an Ajax request.
	 *
	 * @since  4.0.0
	 * @param  mixed $data Optional data to return to the Ajax request.
	 */
	public function send_json_success( $data = null ) {
		while ( ob_get_level() ) { ob_get_clean(); }

		wp_send_json_success( $data );
	}

	/**
	 * Clear all output buffers and send an JSON reponse to an Ajax request.
	 *
	 * @since  4.0.0
	 * @param  mixed $data Optional data to return to the Ajax request.
	 */
	public function send_json_error( $data = null ) {
		while ( ob_get_level() ) { ob_get_clean(); }

		wp_send_json_error( $data );
	}


	/*
	 * *********************************************************************** *
	 * *     PUBLIC INTERFACE FOR OTHER MODULES
	 * *********************************************************************** *
	 */


	/**
	 * Returns the value of a plugin option.
	 * The plugins option-prefix is automatically added to the option name.
	 *
	 * Use this function instead of direct access via get_site_option()
	 *
	 * @since  4.0.0
	 * @param  string $name The option name.
	 * @param  bool   $prefix Optional. Set to false to not prefix the name.
	 * @return mixed The option value.
	 */
	public function get_option( $name, $prefix = true ) {
		if ( $prefix ) {
			$key = 'wdp_un_' . $name;
		} else {
			$key = $name;
		}

		if ( ! $prefix || ! isset( $this->option_cache[ $key ] ) ) {
			$this->option_cache[ $key ] = get_site_option( $key );
			$this->option_hash[ $key ] = md5( json_encode( $this->option_cache[ $key ] ) );
		}

		return $this->option_cache[ $key ];
	}

	/**
	 * Updates the value of a plugin option.
	 * The plugins option-prefix is automatically added to the option name.
	 *
	 * Use this function instead of direct access via update_site_option()
	 *
	 * @since  4.0.0
	 * @param  string $name The option name.
	 * @param  mixed  $value The new option value.
	 */
	public function set_option( $name, $value ) {
		$key = 'wdp_un_' . $name;
		$new_hash = md5( json_encode( $value ) );

		// Don't update if the value did not change.
		if ( isset( $this->option_hash[ $key ] ) ) {
			if ( $new_hash == $this->option_hash[ $key ] ) { return; }
		}

		// Fix to prevent WordPress hashing PHP objects.
		delete_site_option( $key );
		unset( $this->option_cache[ $key ] );
		unset( $this->option_hash[ $key ] );

		if ( null !== $value ) {
			$this->option_cache[ $key ] = $value;
			$this->option_hash[ $key ] = $new_hash;

			if ( $value ) {
				update_site_option( $key, $value );
			}
		}
	}

	/**
	 * Add a new plugin setting to the database.
	 * The plugins option-prefix is automatically added to the option name.
	 *
	 * This function will only save the value if the option does not exist yet!
	 *
	 * Use this function instead of direct access via add_site_option()
	 *
	 * @since  4.0.0
	 * @param  string $name The option name.
	 * @param  mixed  $value The new option value.
	 */
	public function add_option( $name, $value ) {
		$key = 'wdp_un_' . $name;

		/*
		Intentionally NO use of the `option_cache` variable because we cannot
		guarantee that the $value is actually saved to DB (it only is saved
		when the option does not exist yet)
		*/

		$value = add_site_option( $key, $value );
	}

	/**
	 * Returns the value of a plugin transient.
	 * The plugins option-prefix is automatically added to the transient name.
	 *
	 * Use this function instead of direct access via get_site_transient()
	 *
	 * @since  4.0.0
	 * @param  string $name The transient name.
	 * @param  bool   $prefix Optional. Set to false to not prefix the name.
	 * @return mixed The transient value.
	 */
	public function get_transient( $name, $prefix = true ) {
		if ( $prefix ) {
			$key = 'wdp_un_' . $name;
		} else {
			$key = $name;
		}

		// Transient name cannot be longer than 45 characters.
		$key = substr( $key, 0, 45 );

		return get_site_transient( $key );
	}

	/**
	 * Updates the value of a plugin transient.
	 * The plugins option-prefix is automatically added to the transient name.
	 *
	 * Use this function instead of direct access via update_site_option()
	 *
	 * @since  4.0.0
	 * @param  string $name The transient name.
	 * @param  mixed  $value The new transient value.
	 * @param  int    $expiration Time until expiration. Default: No expiration.
	 */
	public function set_transient( $name, $value, $expiration = 0 ) {
		// Transient name cannot be longer than 45 characters.
		$key = substr( 'wdp_un_' . $name, 0, 45 );

		// Fix to prevent WP from hashing PHP objects.
		delete_site_transient( $key );

		if ( null !== $value ) {
			set_site_transient( $key, $value, $expiration );
		}
	}

	/**
	 * Returns a usermeta value of the current user.
	 *
	 * @since  4.0.0
	 * @param  string $name The meta-key.
	 * @return mixed The meta-value.
	 */
	public function get_usermeta( $name ) {
		$user_id = get_current_user_id();

		$value = get_user_meta( $user_id, $name, true );

		return $value;
	}

	/**
	 * Updates a usermeta value of the current user.
	 *
	 * @since  4.0.0
	 * @param  string $name The transient name.
	 * @param  mixed  $value The new transient value.
	 */
	public function set_usermeta( $name, $value ) {
		$user_id = get_current_user_id();

		update_user_meta( $user_id, $name, $value );
	}

	/**
	 * Log out current WPMUDEV user from the local site and erase all cached
	 * data.
	 * After logout, the user is redirected to the login page.
	 *
	 * @since  4.0.5
	 * @param  bool $redirect If set to false, the user will not be redirected
	 *              to the login page. Used for remote logout via ajax handler.
	 */
	public function logout( $redirect = true ) {
		// Prevent infinite loops...
		if ( ! WPMUDEV_Dashboard::$api->has_key() ) { return false; }

		$this->init_options( 'reset' );
		WPMUDEV_Dashboard::$api->set_key( '' );

		if ( $redirect ) {
			// Directly redirect to login page.
			$urls = WPMUDEV_Dashboard::$ui->page_urls;
			WPMUDEV_Dashboard::$ui->redirect_to( $urls->dashboard_url );
		}
	}

	/**
	 * Converts the given date-time string or timestmap from GMT to the local
	 * WordPress timezone.
	 *
	 * @since  4.0.0
	 * @param  string|int $time Either a date-time expression or timestamp.
	 * @return int The timestamp in local WordPress timezone.
	 */
	public function to_localtime( $time ) {
		if ( is_numeric( $time ) ) {
			$timestamp = intval( $time );
		} else {
			$timestamp = strtotime( $time );
		}

		if ( ! $time ) { return 0; }

		// In Multisite networks this option is from the main blog.
		$offset = intval( get_option( 'gmt_offset' ) ) * 60 * 60;
		$timestamp += $offset;

		return $timestamp;
	}

	/**
	 * The proper way to get the array of locally installed products from cache.
	 *
	 * @since  1.0.0
	 * @param  int $project_id Optional. If set then a single project array
	 *             will be returned. Default: Return full project list.
	 * @return array
	 */
	public function get_cached_projects( $project_id = null ) {
		$projects = false;

		if ( $this->get_option( 'refresh_local_flag' ) ) {
			self::$_cache_filesystem = false;
			$this->set_transient( 'local_projects', false );
			$projects = false;
		} else {
			$projects = $this->get_transient( 'local_projects' );
		}

		if ( ! $projects || ! is_array( $projects ) ) {
			// Set param to true to avoid infinite loop.
			$projects = $this->scan_fs_local_projects();
			if ( is_array( $projects ) ) {
				// Save to be able to check for changes later.
				$this->set_transient(
					'local_projects',
					$projects,
					5 * MINUTE_IN_SECONDS
				);

				// Use cached version on next call.
				$this->set_option( 'refresh_local_flag', 0 );
			}
		}

		if ( $project_id ) {
			if ( isset( $projects[ $project_id ] ) ) {
				$res = $projects[ $project_id ];
			} else {
				$res = false;
			}
		} else {
			$res = $projects;
		}
		return $res;
	}

	/**
	 * Returns lots of details about the specified project.
	 *
	 * @since  4.0.0
	 * @param  int  $pid The Project ID.
	 * @param  bool $fetch_full Optional. If true, then even potentially
	 *              time-consuming preparation is done.
	 *              e.g. load changelog via API.
	 * @return object Details about the project.
	 */
	public function get_project_infos( $pid, $fetch_full = false ) {
		$pid = intval( $pid );
		$is_network_admin = is_multisite() && (is_network_admin() || ! empty( $_REQUEST['is_network'] ));
		$urls = WPMUDEV_Dashboard::$ui->page_urls;

		if ( ! is_array( self::$_cache_projectinfos ) ) {
			self::$_cache_projectinfos = array();
		}

		if ( ! isset( self::$_cache_projectinfos[ $pid ] ) ) {
			$res = (object) array(
				'pid' => $pid,
				'type' => '', // Possible: 'plugin' or 'theme'.
				'special' => false, // Possible: false, 'dropin' or 'muplugin'.
				'name' => '', // Project name.
				'path' => '', // Full path to main project file.
				'filename' => '', // Filename, relative to plugins/themes dir.
				'slug' => '', // Slug used for updates.
				'version_latest' => '0.0',
				'version_installed' => '0.0',
				'has_update' => false, // Is new version available?
				'can_update' => false, // User has permission to update?
				'can_activate' => false, // User has permission to activate/deactivate?
				'can_autoupdate' => false, // If plugin should auto-update?
				'is_compatible' => true, // Site has all requirements to install project?
				'incompatible_reason' => '', // If is_compatible is false.
				'need_upfront' => false, // Only used by themes.
				'is_installed' => false, // Installed on current site?
				'is_active' => false, // WordPress state, i.e. plugin activated?
				'is_hidden' => false, // Projects can be hidden via API.
				'is_licensed' => false, // User has license to use this project?
				'default_order' => 0,
				'downloads' => 0,
				'popularity' => 0,
				'release_stamp' => 0,
				'update_stamp' => 0,
				'info' => '',
				'url' => (object) array(
					'instructions' => '',
					'config' => '',
					'activate' => '',
					'deactivate' => '',
					'install' => '',
					'update' => '',
					'download' => '',
					'website' => '',
					'thumbnail' => '',
					'video' => '',
					'infos' => '',
				),
				'changelog' => array(),
				'features' => array(),
				'tags' => array(),
				'screenshots' => array(),
			);

			$remote = WPMUDEV_Dashboard::$api->get_project_data( $pid );
			if ( empty( $remote ) ) {
				self::$_cache_projectinfos[ $pid ] = false;
				return false;
			}
			$local = WPMUDEV_Dashboard::$site->get_cached_projects( $pid );
			$system_projects = WPMUDEV_Dashboard::$site->get_system_projects();

			// General details.
			$res->type = ('theme' == $remote['type'] ? 'theme' : 'plugin');
			$res->name = $remote['name'];
			$res->info = strip_tags( $remote['short_description'] );
			$res->version_latest = $remote['version'];
			$res->features = $remote['features'];
			$res->default_order = intval( $remote['_order'] );
			$res->downloads = intval( $remote['downloads'] );
			$res->popularity = intval( $remote['popularity'] );
			$res->release_stamp = intval( $remote['released'] );
			$res->update_stamp = intval( $remote['updated'] );

			// Project tags.
			if ( 'plugin' == $res->type ) {
				$tags = WPMUDEV_Dashboard::$ui->tags_data( 'plugin' );
			} else {
				$tags = WPMUDEV_Dashboard::$ui->tags_data( 'theme' );
			}
			foreach ( $tags as $tid => $tag ) {
				if ( ! in_array( $pid, $tag['pids'] ) ) { continue; }
				$res->tags[ $tid ] = $tag['name'];
			}

			// Status details.
			$res->can_update = WPMUDEV_Dashboard::$upgrader->user_can_install( $pid );
			$res->is_licensed = WPMUDEV_Dashboard::$upgrader->user_can_install( $pid, true );

			if ( 'theme' == $res->type ) {
				$res->need_upfront = $this->is_upfront_theme( $pid );
			}

			$res->is_installed = WPMUDEV_Dashboard::$upgrader->is_project_installed( $pid );

			if ( $res->is_licensed && WPMUDEV_Dashboard::$api->has_key() ) {
				$res->can_autoupdate = ('1' == $remote['autoupdate']);
			}

			// Plugin can be active, even if not licensed:
			// E.g. it was installed and then the admin logged out from WPMU DEV
			// Dashboard, or the API-Key was changed from the Hub, ...
			if ( $res->is_installed ) {
				$res->is_compatible = WPMUDEV_Dashboard::$upgrader->is_project_compatible( $pid, $incompatible_reason );
				if ( ! empty( $local['name'] ) ) { $res->name = $local['name']; }
				if ( 'muplugin' == $local['type'] ) {
					$res->special = $local['type'];
				} elseif ( 'dropin' == $local['type'] ) {
					$res->special = $local['type'];
				}
				$res->path = $local['path'];
				$res->filename = $local['filename'];
				$res->slug = $local['slug'];
				$res->version_installed = $local['version'];
				$res->has_update = WPMUDEV_Dashboard::$upgrader->is_update_available( $pid );

				if ( 'plugin' == $res->type ) {
					if ( ! function_exists( 'is_plugin_active' ) ) {
						include_once ABSPATH . 'wp-admin/includes/plugin.php' ;
					}

					if ( $is_network_admin ) {
						$res->is_active = is_plugin_active_for_network( $res->filename );
					} else {
						$res->is_active = is_plugin_active( $res->filename );
					}
				} elseif ( 'theme' == $res->type ) {
					if ( $is_network_admin ) {
						$allowed_themes = get_site_option( 'allowedthemes' );
						$res->is_active = ! empty( $allowed_themes[ $res->slug ] );
					} else {
						$res->is_active = ($res->slug == get_option( 'stylesheet' ) );
					}
				}
			}
			if ( in_array( $pid, $system_projects ) ) {
				// Hardcoded by plugin, those are always hidden!
				$res->is_hidden = true;
			} elseif ( $res->is_installed ) {
				// Installed projects are always visible.
				$res->is_hidden = false;
			} elseif ( 'theme' == $res->type && $this->is_legacy_theme( $pid ) ) {
				// Hide all non-installed legacy themes.
				$res->is_hidden = true;
			} else {
				// Project is not installed, then use flag from API.
				$res->is_hidden = ! $remote['active'];
			}
			if ( 'plugin' == $res->type ) {
				if ( $res->special ) {
					// MU-Plugins and Dropins cannot be (de)activated.
					$res->can_activate = false;
				} elseif ( $is_network_admin ) {
					$res->can_activate = current_user_can( 'manage_network_plugins' );
				} else {
					$res->can_activate = current_user_can( 'activate_plugins' );
				}
			} elseif ( 'theme' == $res->type ) {
				if ( $is_network_admin ) {
					$res->can_activate = current_user_can( 'manage_network_themes' );
				} else {
					$res->can_activate = current_user_can( 'switch_themes' );
				}
			}

			// URLs.
			$res->url->website = esc_url( $remote['url'] );
			if ( ! empty( $remote['thumbnail_large'] ) ) {
				$res->url->thumbnail = esc_url( $remote['thumbnail_large'] );
			} else {
				$res->url->thumbnail = esc_url( $remote['thumbnail'] );
			}
			$res->url->video = esc_url( $remote['video'] );
			$res->url->instructions = WPMUDEV_Dashboard::$api->rest_url( 'usage/' . $pid );

			if ( $res->is_active ) {
				if ( 'plugin' == $res->type ) {
					if ( $is_network_admin && ! empty( $remote['ms_config_url'] ) ) {
						$res->url->config = esc_url( network_admin_url( $remote['ms_config_url'] ) );
					} elseif ( ! $is_network_admin && ! empty( $remote['wp_config_url'] ) ) {
						$res->url->config = esc_url( admin_url( $remote['wp_config_url'] ) );
					}
				}
			}

			$res->url->install = WPMUDEV_Dashboard::$upgrader->auto_install_url( $pid );
			$res->url->download = esc_url( $remote['url'] );
			if ( ! $res->special ) {
				// I.e. only if plugin is no dropin/muplugin.
				$res->url->update = WPMUDEV_Dashboard::$upgrader->auto_update_url( $pid );
			}
			if ( ! $res->is_compatible ) {
				switch ( $incompatible_reason ) {
					case 'multisite':
						$res->incompatible_reason = __( 'Requires Multisite', 'wpmudev' );
						break;

					case 'buddypress':
						$res->incompatible_reason = __( 'Requires BuddyPress', 'wpmudev' );
						break;

					default:
						$res->incompatible_reason = __( 'Incompatible', 'wpmudev' );
						break;
				}
			}

			// When not logged in, the project-ID is passed as URL param!
			$pid_sep = WPMUDEV_Dashboard::$api->has_key() ? '#' : '&';

			if ( 'plugin' == $res->type ) {
				$res->url->infos = $urls->plugins_url . $pid_sep . 'pid=' . $pid;

				$res->url->deactivate = 'plugins.php?action=deactivate&plugin=' . urlencode( $res->filename );
				$res->url->activate = 'plugins.php?action=activate&plugin=' . urlencode( $res->filename );

				if ( $is_network_admin ) {
					$res->url->deactivate = network_admin_url( $res->url->deactivate );
					$res->url->activate = network_admin_url( $res->url->activate );
				} else {
					$res->url->deactivate = admin_url( $res->url->deactivate );
					$res->url->activate = admin_url( $res->url->activate );
				}
				$res->url->deactivate = wp_nonce_url( $res->url->deactivate, 'deactivate-plugin_' . $res->filename );
				$res->url->activate = wp_nonce_url( $res->url->activate, 'activate-plugin_' . $res->filename );
			} elseif ( 'theme' == $res->type ) {
				$res->url->infos = $urls->themes_url . $pid_sep . 'pid=' . $pid;

				if ( $is_network_admin ) {
					/*
					 * In Network-Admin following theme-actions are disabled:
					 * - Activate
					 * - Configure
					 */
					$res->url->activate = false;
					$res->url->config = false;
				} else {
					$res->url->activate = wp_nonce_url(
						'themes.php?action=activate&template=' . urlencode( $res->filename ) . '&stylesheet=' . urlencode( $res->filename ),
						'switch-theme_' . $res->filename
					);
					if ( $res->need_upfront ) {
						$res->url->config = home_url( '/?editmode=true' );
					} else {
						$return_url = urlencode( WPMUDEV_Dashboard::$ui->page_urls->themes_url );
						$res->url->config = admin_url( 'customize.php?return=' . $return_url );
					}
				}
			}
			$res->screenshots = $remote['screenshots'];

			// Performance: Only fetch changelog if needed.
			if ( $fetch_full ) {
				$res->changelog = WPMUDEV_Dashboard::$api->get_changelog(
					$pid,
					$res->version_latest
				);
			}

			self::$_cache_projectinfos[ $pid ] = $res;
		}

		// Following flags are not cached.
		if ( self::$_cache_projectinfos[ $pid ] && is_object( self::$_cache_projectinfos[ $pid ] ) ) {
			self::$_cache_projectinfos[ $pid ]->is_network_admin = $is_network_admin;
		} else {
			self::$_cache_projectinfos[ $pid ] = false;
		}

		return self::$_cache_projectinfos[ $pid ];
	}

	/**
	 * Returns a list of all installed 133-theme-pack themes.
	 *
	 * @since  1.0.0
	 * @return array|false
	 */
	public function get_farm133_themepack() {
		return $this->get_option( 'farm133_themes' );
	}

	/**
	 * Check if a given theme project id is an Upfront theme.
	 *
	 * @since  3.0.0
	 * @param  int $project_id The project to check.
	 * @return bool
	 */
	public function is_upfront_theme( $project_id ) {
		if ( $project_id == $this->id_upfront ) { return false; }
		if ( $project_id <= $this->id_legacy_themes ) { return false; }
		return true;
	}

	/**
	 * Check if a given theme project id is a legacy theme.
	 *
	 * @since  3.0.0
	 * @param  int $project_id The project to check.
	 * @return bool
	 */
	public function is_legacy_theme( $project_id ) {
		if ( $project_id > $this->id_legacy_themes ) { return false; }
		return true;
	}

	/**
	 * Check if root Upfront project is installed.
	 *
	 * @since  3.0.0
	 * @return bool
	 */
	public function is_upfront_installed() {
		$data = $this->get_cached_projects( $this->id_upfront );
		return ( ! empty( $data ));
	}

	/**
	 * Check if a child Upfront project is installed.
	 *
	 * @since  3.0.0
	 * @return bool
	 */
	public function is_upfront_theme_installed() {
		$result = false;
		$local_projects = $this->get_cached_projects();

		foreach ( $local_projects as $project_id => $project ) {
			// Quit on first theme installed greater than legacy threshold.
			if ( 'theme' == $project['type'] && $this->is_upfront_theme( $project_id ) ) {
				$result = true;
				break;
			}
		}

		return $result;
	}

	/**
	 * Return the currently active WPMUDEV theme.
	 * If current theme is no WPMUDEV theme, the function returns false.
	 *
	 * Only works on single-site installations!
	 *
	 * @since  4.0.0
	 * @return bool
	 */
	public function get_active_wpmu_theme() {
		$result = false;
		$is_network_admin = is_multisite() && (is_network_admin() || ! empty( $_REQUEST['is_network'] ));

		// Network-installations do not support this function.
		if ( $is_network_admin ) {
			return $result;
		}

		$local_projects = $this->get_cached_projects();
		$current = get_option( 'stylesheet' );
		foreach ( $local_projects as $project_id => $project ) {
			if ( 'theme' == $project['type'] && $project['slug'] == $current ) {
				$result = $project_id;
				break;
			}
		}

		return $result;
	}

	/**
	 * Checks if the current user is in the list of allowed users of the Dashboard.
	 * Allows for multiple users allowed in define, e.g. in this format:
	 *
	 * <code>
	 *  define("WPMUDEV_LIMIT_TO_USER", "1, 10, 15");
	 * </code>
	 *
	 * @since  1.0.0
	 * @param  int $user_id Optional. If empty then the current user-ID is used.
	 * @return bool
	 */
	public function allowed_user( $user_id = null ) {
		// If this is a remote call from WPMUDEV remote dashboard then allow.
		if ( ! $user_id && defined( 'WPMUDEV_IS_REMOTE' ) && WPMUDEV_IS_REMOTE ) {
			return true;
		}

		// Balk if this is called too early.
		if ( ! $user_id && ! did_action( 'set_current_user' ) ) {
			return false;
		}

		if ( empty( $user_id ) ) {
			/*
			 * @todo calling this too soon bugs out in some wp installs
			 * http://premium.wpmudev.org/forums/topic/urgenti-lost-permission-after-upgrading#post-227543
			 */
			$user_id = get_current_user_id();
		}

		$allowed = $this->get_allowed_users( true );

		return in_array( $user_id, $allowed );
	}

	/**
	 * Grant access to the WPMU DEV Dashboard to a new admin user.
	 *
	 * @since  4.0.0
	 * @param  int $user_id The user to add.
	 * @return bool True on success, false on failure.
	 */
	public function add_allowed_user( $user_id ) {
		$user = get_userdata( $user_id );

		if ( ! $user || ! is_a( $user, 'WP_User' ) ) {
			// User not found.
			return false;
		}

		$need_cap = 'manage_options';
		if ( is_multisite() ) {
			$need_cap = 'manage_network_options';
		}

		if ( ! $user->has_cap( $need_cap ) ) {
			// User is no admin.
			return false;
		}

		$allowed = WPMUDEV_Dashboard::$site->get_option( 'limit_to_user' );
		if ( $allowed && ! is_array( $allowed ) ) {
			$allowed = array( $allowed );
		}

		if ( in_array( $user_id, $allowed ) ) {
			// User was already added.
			return false;
		}

		$allowed[] = $user_id;
		WPMUDEV_Dashboard::$site->set_option( 'limit_to_user', $allowed );

		return true;
	}

	/**
	 * Remove access to the WPMU DEV Dashboard from another admin user.
	 *
	 * @since  4.0.0
	 * @param  int $user_id The user to remove.
	 * @return bool True on success, false on failure.
	 */
	public function remove_allowed_user( $user_id ) {
		$user = get_userdata( $user_id );

		$allowed = WPMUDEV_Dashboard::$site->get_option( 'limit_to_user' );
		if ( empty( $allowed ) || ! is_array( $allowed ) ) {
			// The allowed-list is still empty.
			return false;
		}

		$key = array_search( $user_id, $allowed );
		if ( ! $key ) {
			// User not found in the allowed-list.
			return false;
		}

		unset( $allowed[ $key ] );
		$allowed = array_values( $allowed );
		WPMUDEV_Dashboard::$site->set_option( 'limit_to_user', $allowed );

		return true;
	}

	/**
	 * Get a human readable list of users with allowed permissions for the
	 * Dashboard.
	 *
	 * @since  1.0.0
	 * @param  bool $id_only Return only user-IDs or full usernames.
	 * @return array|bool
	 */
	public function get_allowed_users( $id_only = false ) {
		$result = false;

		if ( WPMUDEV_LIMIT_TO_USER ) {
			// Hardcoded list of users.
			if ( is_array( WPMUDEV_LIMIT_TO_USER ) ) {
				$allowed = WPMUDEV_LIMIT_TO_USER;
			} else {
				$allowed = explode( ',', WPMUDEV_LIMIT_TO_USER );
				$allowed = array_map( 'trim', $allowed );
			}
			$allowed = array_map( 'intval', $allowed );
		} else {
			$changed = false;

			// Default: Allow users based on DB settings.
			$allowed = WPMUDEV_Dashboard::$site->get_option( 'limit_to_user' );
			if ( $allowed ) {
				if ( ! is_array( $allowed ) ) {
					$allowed = array( $allowed );
					$changed = true;
				}
			} else {
				// If not set, then add current user as allowed user.
				$cur_user_id = get_current_user_id();
				if ( $cur_user_id ) {
					$allowed = array( $cur_user_id );
					$changed = true;
				} else {
					$allowed = array();
				}
			}

			// Sanitize allowed users after login to Dashboard, so we can
			// react to changes in the user capabilities.
			if ( ! empty( $allowed ) && WPMUDEV_Dashboard::$api->has_key() ) {
				$need_cap = 'manage_options';
				if ( is_multisite() ) {
					$need_cap = 'manage_network_options';
				}

				// Remove invalid users from the allowed-users-list.
				foreach ( $allowed as $key => $user_id ) {
					$user = get_userdata( $user_id );
					if ( ! $user || ! is_a( $user, 'WP_User' ) ) {
						unset( $allowed[ $key ] );
						$changed = true;
					} elseif ( ! $user->has_cap( $need_cap ) ) {
						unset( $allowed[ $key ] );
						$changed = true;
					}
				}

				if ( $changed ) {
					WPMUDEV_Dashboard::$site->set_option( 'limit_to_user', $allowed );
				}
			}
		}

		if ( $id_only ) {
			$result = $allowed;
		} else {
			$result = array();
			foreach ( $allowed as $user_id ) {
				if ( $user_info = get_userdata( $user_id ) ) {
					$result[] = array(
						'id' => $user_id,
						'name' => $user_info->display_name,
						'is_me' => get_current_user_id() == $user_id,
						'profile_link' => get_edit_user_link( $user_id ),
					);
				}
			}
		}

		return $result;
	}

	/**
	 * Returns a list of users with manage_options capability.
	 *
	 * The currently logged in user is excluded from the return value, since
	 * this user is not a potentialy but an actualy allowed user.
	 *
	 * @since  4.0.0
	 * @param  string $filter Optional. Filter by user name.
	 * @return array List of user-details
	 */
	protected function get_potential_users( $filter ) {
		global $wpdb;

		/*
		 * We build a custom SQL here so we can also get users that are not
		 * assigned to a specific blog but only have access to the network
		 * admin (on multisites).
		 */
		$sql = "
		SELECT
			u.ID as id,
			u.display_name,
			m_fn.meta_value as first_name,
			m_ln.meta_value as last_name
		FROM {$wpdb->users} u
			LEFT JOIN {$wpdb->usermeta} m_fn ON m_fn.user_id=u.ID AND m_fn.meta_key='first_name'
			LEFT JOIN {$wpdb->usermeta} m_ln ON m_ln.user_id=u.ID AND m_ln.meta_key='last_name'
		WHERE
			u.ID != %d
			AND (u.display_name LIKE %s OR m_fn.meta_value LIKE %s OR m_ln.meta_value LIKE %s OR u.user_email LIKE %s)
		";
		$filter = '%' . $filter . '%';
		$sql = $wpdb->prepare(
			$sql,
			get_current_user_id(),
			$filter,
			$filter,
			$filter,
			$filter
		);

		// Now we have a list of all users, no matter which blog they belong to.
		$res = $wpdb->get_results( $sql );

		$need_cap = 'manage_options';
		if ( is_multisite() ) {
			$need_cap = 'manage_network_options';
		}

		$items = array();
		// Filter users by capabilty.
		foreach ( $res as $item ) {
			$user = get_userdata( $item->id );
			if ( ! $user || ! is_a( $user, 'WP_User' ) ) { continue; }
			if ( ! $user->has_cap( $need_cap ) ) { continue; }
			if ( $this->allowed_user( $user->ID ) ) { continue; }

			$items[] = (object) array(
				'id' => $user->ID,
				'name' => $user->display_name,
				'first_name' => $user->user_firstname,
				'last_name' => $user->user_lastname,
				'email' => $user->user_email,
				'avatar' => get_avatar_url( $user->ID ),
			);
		}

		return $items;
	}

	/**
	 * Returns a list of projects that match the specified name.
	 *
	 * @since  4.0.0
	 * @param  string $filter Optional. Filter by project name.
	 * @return array List of project-details
	 */
	protected function find_projects_by_name( $filter ) {
		$data = WPMUDEV_Dashboard::$api->get_membership_data();
		$projects = $data['projects'];

		// Remove legacy themes.
		foreach ( $projects as $key => $project ) {
			if ( 'theme' != $project['type'] ) { continue; }
			if ( WPMUDEV_Dashboard::$site->is_legacy_theme( $project['id'] ) ) {
				unset( $projects[ $key ] );
			}
		}

		$items = array();

		foreach ( $projects as $item ) {
			$data = $this->get_project_infos( $item['id'] );

			if ( $data->is_hidden ) { continue; }
			if ( false === stripos( $data->name, $filter ) ) { continue; }

			$items[] = (object) array(
				'id' => $data->pid,
				'name' => $data->name,
				'desc' => $data->info,
				'logo' => $data->url->thumbnail,
				'type' => $data->type,
				'installed' => $data->is_installed,
			);
		}

		return $items;
	}

	/**
	 * Check user permissions to see if we can install this project.
	 *
	 * @since  1.0.0
	 * @param  int  $project_id The project to check.
	 * @param  bool $only_license Skip permission check, only validate license.
	 * @return bool
	 */
	public function user_can_install( $project_id, $only_license = false ) {
		$data = WPMUDEV_Dashboard::$api->get_membership_data();
		$membership_type = WPMUDEV_Dashboard::$api->get_membership_type( $license_for );

		// Basic check if we have valid data.
		if ( empty( $data['membership'] ) ) { return false; }
		if ( empty( $data['projects'] ) ) { return false; }
		if ( empty( $data['projects'][ $project_id ] ) ) { return false; }

		$project = $data['projects'][ $project_id ];

		if ( ! $only_license ) {
			if ( ! $this->allowed_user() ) { return false; }
			if ( ! WPMUDEV_Dashboard::$upgrader->can_auto_install( $project['type'] ) ) { return false; }
		}

		$is_upfront = WPMUDEV_Dashboard::$site->id_upfront == $project_id;
		$package = isset( $project['package'] ) ? $project['package'] : '';
		$access = false;

		if ( 'full' == $membership_type ) {
			// User has full membership.
			$access = true;
		} elseif ( 'single' == $membership_type && $license_for == $project_id ) {
			// User has single membership for the requested project.
			$access = true;
		} elseif ( 'free' == $project['paid'] ) {
			// It's a free project. All users can install this.
			$access = true;
		} elseif ( 'lite' == $project['paid'] ) {
			// It's a lite project. All users can install this.
			$access = true;
		} elseif ( 'single' == $membership_type && $package && $package == $license_for ) {
			// A packaged project that the user bought.
			$access = true;
		} elseif ( $is_upfront && 'single' == $membership_type ) {
			// User wants to get Upfront parent theme.
			$access = true;
		}

		return $access;
	}

	/**
	 * Returns a list of internal/hidden/deprecated projects.
	 *
	 * @since  4.0.0
	 * @return array
	 */
	public function get_system_projects() {
		$list = array(
			// Upfront parent is hidden.
			WPMUDEV_Dashboard::$site->id_upfront,
		);

		return $list;
	}

	/*
	 * *********************************************************************** *
	 * *     INTERNAL ACTION HANDLERS
	 * *********************************************************************** *
	 */


	/**
	 * Check for any compatibility issues or important updates and display a
	 * notice if found.
	 *
	 * @since  4.0.0
	 */
	public function compatibility_warnings() {
		if ( $this->is_upfront_theme_installed() && ! $this->is_upfront_installed() ) {
			// Upfront child theme is installed but not parent theme is missing:
			// Only display this on the WP Dashboard page.
			$upfront = $this->get_project_infos( $this->id_upfront );

			if ( is_object( $upfront ) ) {
				do_action(
					'wpmudev_override_notice',
					__( '<b>The Upfront parent theme is missing!</b><br>Please install it to use your Upfront child themes', 'wpmudev' ),
					'<a href="' . $upfront->url->install . '" class="button button-primary">Install Upfront</a>'
				);
			}
		} elseif ( $this->is_upfront_installed() ) {
			$upfront = $this->get_project_infos( $this->id_upfront );

			if ( is_object( $upfront ) && $upfront->has_update ) {
				// Upfront update is available:
				// Only display this message in the WPMUDEV Themes page!
				add_action(
					'wpmudev_dashboard_notice-themes',
					array( $this, 'notice_upfront_update' )
				);
			}
		}
	}

	/**
	 * Display a notification on the Themes page.
	 *
	 * @since  4.0.3
	 */
	public function notice_upfront_update() {
		$upfront = $this->get_project_infos( $this->id_upfront );
		$message = sprintf(
			'<b>%s</b><br>%s',
			__( 'Awesome news for Upfront', 'wpmudev' ),
			__( 'We have a new version of Upfront for you! Install it right now to get all the latest improvements and features', 'wpmudev' )
		);

		$cta = sprintf(
			'<span data-project="%s">
			<a href="%s" class="button">Update Upfront</a>
			</span>',
			$this->id_upfront,
			$upfront->url->update
		);

		do_action( 'wpmudev_override_notice', $message, $cta );

		WPMUDEV_Dashboard::$notice->setup_message();
	}

	/**
	 * Intercept the default WP iframe that displays a plugins changelog details
	 * and render our own changelog layout if we detect a WPMUDEV project.
	 *
	 * @since  4.0.5
	 */
	public function install_plugin_information() {
		global $tab;

		if ( empty( $_REQUEST['plugin'] ) ) {
			return;
		}
		if ( 'plugin-information' != $tab ) {
			return;
		}

		$search_for = $_REQUEST['plugin'];
		$projects = $this->get_cached_projects();
		$project_id = false;
		foreach ( $projects as $id => $item ) {
			if ( $_REQUEST['plugin'] == $item['slug'] ) {
				$project_id = $id;
				break;
			}
		}

		if ( $project_id ) {
			WPMUDEV_Dashboard::$ui->wp_popup_changelog( $project_id );
		}
	}

	/**
	 * Does a filesystem scan for local plugins/themes and caches it. If any
	 * changes found it will trigger remote api check and calculate upgrades as well.
	 *
	 * @since  1.0.0
	 * @internal
	 * @param  string $check Either 'local' or 'remote'. Local will only scan
	 *                the local FS for changes. Remote will also query the API
	 *                and schedule updates.
	 * @return array
	 */
	public function refresh_local_projects( $check = 'remote' ) {
		// 1. Scan local FS to find projects.
		$local_projects = $this->scan_fs_local_projects();

		// 2. Load the cached project-list from DB.
		$saved_local_projects = $this->get_cached_projects();

		// Check for changes.
		$md5_db = md5( json_encode( $saved_local_projects ) );
		$md5_fs = md5( json_encode( $local_projects ) );

		if ( 'remote' == $check || $md5_db != $md5_fs ) {
			// Refresh data as installed plugins have changed.
			$data = WPMUDEV_Dashboard::$api->refresh_membership_data( $local_projects );
		}

		// Recalculate upgrades with current/updated data.
		WPMUDEV_Dashboard::$api->calculate_upgrades( $local_projects );

		return $local_projects;
	}

	/**
	 * Used to call refresh_local_projects from a hook (strip passed arguments)
	 *
	 * @since  1.0.0
	 * @internal Action hook
	 */
	public function refresh_local_projects_wrapper() {
		static $ResetCache = false;

		// Do not refresh the cache when current user cannot update plugins.
		if ( ! current_user_can( 'update_plugins' ) ) {
			$ResetCache = true;
		}

		// First time this function is called we clear all local caches.
		if ( ! $ResetCache ) {
			$ResetCache = true;
			self::$_cache_filesystem = false;
			self::$_cache_themeupdates = false;
			self::$_cache_pluginupdates = false;
			$this->set_transient( 'local_projects', false );
			$this->set_option( 'refresh_local_flag', 1 );
			$this->set_option( 'updates_available', false );
		}

		if ( isset( $_GET['force-check'] ) ) {
			$this->refresh_local_projects( 'remote' );
		} else {
			$this->refresh_local_projects( 'local' );
		}
	}

	/**
	 * A scheduled event that runs twicedaily on multisite networks. This
	 * function loops through all blogs and stores a list of active WPMUDEV
	 * plugins/themes in a sitemeta value.
	 * This information is used by API::refresh_membership_data() to send an
	 * accurate list of active projects to the API server.
	 *
	 * @todo  We do not want to use site-loops. Find a different way!
	 *
	 * @since  4.0.8
	 */
	public function refresh_blog_project_status() {
		/*
		What a shame. We need to find a more efficient way than this...

		// No need for caching on single-sites.
		if ( ! is_multisite() ) { return; }

		// No point in doing this for large networks (more than 10.000 sites).
		if ( wp_is_large_network() ) { return; }

		if ( ! function_exists( 'is_plugin_active' ) ) {
			include_once ABSPATH . 'wp-admin/includes/plugin.php' ;
		}

		$local_projects = WPMUDEV_Dashboard::$site->get_cached_projects();
		$active_projects = array();

		// First filter out network-wide-actived plugins.
		foreach ( $local_projects as $pid => $item ) {
			if ( 'theme' == $item['type'] ) { continue; }
			if ( is_plugin_active_for_network( $item['filename'] ) ) {
				unset( $local_projects[ $pid ] );
			}
		}

		// We "only" scan the first 1000 sites, not whole network.
		$scan_sites = wp_get_sites(
			array(
				'archived' => false,
				'spam' => false,
				'deleted' => false,
				'limit' => 1000,
			)
		);

		foreach ( $scan_sites as $site ) {
			switch_to_blog( $site['blog_id'] );
			if ( ! count( $local_projects ) ) {
				// Yay! All our plugins are active, no more checks needed...
				break;
			}
			foreach ( $local_projects as $pid => $item ) {
				if ( 'theme' == $item['type'] ) {
					$theme = wp_get_theme();
					$slug = dirname( $item['filename'] );
					if ( $theme->stylesheet == $slug || $theme->template == $slug ) {
						$active_projects[ $pid ] = true;
						unset( $local_projects[ $pid ] );
					}
				} else {
					if ( is_plugin_active( $item['filename'] ) ) {
						$active_projects[ $pid ] = true;
						unset( $local_projects[ $pid ] );
					}
				}
			}
			restore_current_blog();
		}

		// Now save the list with active projects of first 1000 active blogs!
		WPMUDEV_Dashboard::$site->set_option(
			'blog_active_projects',
			$active_projects
		);
		*/
	}

	/**
	 * This handler is called right before starting an upgrade/installation
	 * process, it makes sure that the upgrader will get uncached and
	 * up-to-date details.
	 *
	 * @since  4.1.0
	 */
	public function before_local_files_change() {
		self::$_cache_filesystem = false;
		self::$_cache_projectinfos = false;
		$this->set_transient( 'local_projects', false );
	}

	/**
	 * This handler is called right after a plugin was installed or updated.
	 * It instructs the dashboard to flush all caches (i.e. filesystem is
	 * scanned again, the transient is re-generated, ...)
	 *
	 * @since  4.0.7
	 */
	public function after_local_files_changed() {
		self::$_cache_themeupdates = false;
		self::$_cache_pluginupdates = false;
		self::$_cache_filesystem = false;
		self::$_cache_projectinfos = false;
		$this->set_transient( 'local_projects', false );
	}

	/**
	 * After WordPress deletes the Theme-/Plugin-Updates transient, we also
	 * flush the local Transient cache to reflect that changes.
	 *
	 * @since  4.0.7
	 */
	public function after_transient_changed() {
		self::$_cache_themeupdates = false;
		self::$_cache_pluginupdates = false;
		$this->set_option( 'updates_available', false );
	}

	/**
	 * Scans all folder locations and compiles a list of WPMU DEV plugins and
	 * themes and header data.
	 * Also saves 133 theme pack themes into option for later use.
	 *
	 * @since  1.0.0
	 * @internal
	 * @return array Local projects
	 */
	protected function scan_fs_local_projects() {
		$projects = array();

		if ( ! self::$_cache_filesystem ) {
			// ----------------------------------------------------------------------------------
			// Plugins directory.
			// ----------------------------------------------------------------------------------
			$plugins_root = WP_PLUGIN_DIR;
			if ( empty( $plugins_root ) ) {
				$plugins_root = ABSPATH . 'wp-content/plugins';
			}

			$items = $this->find_project_files( $plugins_root, '.php', true );
			foreach ( $items as $item ) {
				if ( isset( $projects[ $item['pid'] ] ) ) { continue; }

				$item['type'] = 'plugin';
				$projects[ $item['pid'] ] = $item;
			}

			// ----------------------------------------------------------------------------------
			// mu-plugins directory.
			// ----------------------------------------------------------------------------------
			$mu_plugins_root = WPMU_PLUGIN_DIR;
			if ( empty( $mu_plugins_root ) ) {
				$mu_plugins_root = ABSPATH . 'wp-content/mu-plugins';
			}

			$items = $this->find_project_files( $mu_plugins_root, '.php', false );
			foreach ( $items as $item ) {
				if ( isset( $projects[ $item['pid'] ] ) ) { continue; }

				$item['type'] = 'muplugin';
				$projects[ $item['pid'] ] = $item;
			}

			// ----------------------------------------------------------------------------------
			// wp-content directory.
			// ----------------------------------------------------------------------------------
			$content_plugins_root = WP_CONTENT_DIR;
			if ( empty( $content_plugins_root ) ) {
				$content_plugins_root = ABSPATH . 'wp-content';
			}

			$items = $this->find_project_files( $content_plugins_root, '.php', false );
			foreach ( $items as $item ) {
				if ( isset( $projects[ $item['pid'] ] ) ) { continue; }

				$item['type'] = 'dropin';
				$projects[ $item['pid'] ] = $item;
			}

			// ----------------------------------------------------------------------------------
			// Themes directory.
			// ----------------------------------------------------------------------------------
			$themes_root = WP_CONTENT_DIR . '/themes';
			if ( empty( $themes_root ) ) {
				$themes_root = ABSPATH . 'wp-content/themes';
			}

			$items = $this->find_project_files( $themes_root, '.css', true );

			foreach ( $items as $item ) {
				// Skip 133-Farm-Pack themes.
				if ( $item['pid'] == $this->id_farm133_themes ) { continue; }

				// Skip child themes.
				if ( false !== strpos( $item['filename'], '-child' ) ) { continue; }

				$item['type'] = 'theme';
				$item['slug'] = basename( dirname( $item['path'] ) );
				$projects[ $item['pid'] ] = $item;
			}

			$farm133_themes = $this->scan_fs_farm133_themes();

			if ( count( $farm133_themes ) ) {
				$farm133_project = reset( $farm133_themes );
				$projects[ $this->id_farm133_themes ] = $farm133_project;
			}

			// ----------------------------------------------------------------------------------
			self::$_cache_filesystem = $projects;
		}

		return self::$_cache_filesystem;
	}

	/**
	 * Scan the WP themes directory for all 133-Farm-Pack themes and cache the
	 * result in DB option.
	 *
	 * @since  1.0.0
	 * @return array List with all farm133 themes.
	 */
	protected function scan_fs_farm133_themes() {
		$themes_root = WP_CONTENT_DIR . '/themes';
		if ( empty( $themes_root ) ) {
			$themes_root = ABSPATH . 'wp-content/themes';
		}

		$farm133_themes = array();
		$items = $this->find_project_files( $themes_root, '.css', true );
		$version = false;

		foreach ( $items as $item ) {
			// Skip Non-133-Farm-Pack themes.
			if ( $item['pid'] != $this->id_farm133_themes ) { continue; }

			// Skip child themes.
			if ( false !== strpos( $item['filename'], '-child' ) ) { continue; }

			$item['type'] = 'theme';
			$item['slug'] = dirname( $item['filename'] );

			$farm133_themes[ $item['slug'] ] = $item;
		}

		$this->set_option( 'farm133_themes', $farm133_themes );

		return $farm133_themes;
	}

	/**
	 * Returns an array of relevant files from the specified folder.
	 *
	 * @since  4.0.0
	 * @param  strong $path The absolute path to the base directory to scan.
	 * @param  string $ext File extension to return (i.e. '.php' or '.css').
	 * @param  bool   $check_subdirs False will ignore files in sub-directories.
	 * @return array Details about all WPMU Projects found in the directory.
	 *         @var  pid
	 *         @var  name
	 *         @var  filename
	 *         @var  path
	 *         @var  version
	 */
	protected function find_project_files( $path, $ext = '.php', $check_subdirs = true ) {
		$files = array();
		$items = array();
		$h_dir = false;
		$h_subdir = false;
		$ext_len = strlen( $ext );

		if ( is_dir( $path ) ) {
			$h_dir = @opendir( $path );
		}

		while ( $h_dir && ( $file = readdir( $h_dir ) ) !== false ) {
			if ( substr( $file, 0, 1 ) == '.' ) { continue; }

			if ( is_dir( $path . '/' . $file ) ) {
				if ( ! $check_subdirs ) { continue; }

				$h_subdir = @opendir( $path . '/' . $file );
				while ( $h_subdir && ( $subfile = readdir( $h_subdir ) ) !== false ) {
					if ( substr( $subfile, 0, 1 ) == '.' ) { continue; }
					if ( ! is_readable( "$path/$file/$subfile" ) ) { continue; }

					if ( substr( $subfile, - $ext_len ) == $ext ) {
						$files[] = "$file/$subfile";
					}
				}
				if ( $h_subdir ) {
					@closedir( $h_subdir );
				}
			} else {
				if ( ! is_readable( "$path/$file" ) ) { continue; }

				if ( substr( $file, - $ext_len ) == $ext ) {
					$files[] = $file;
				}
			}
		}
		if ( $h_dir ) {
			@closedir( $h_dir );
		}

		foreach ( $files as $file ) {
			$data = $this->get_id_plugin( "$path/$file" );
			if ( ! empty( $data['id'] ) ) {
				$items[] = array(
					'pid' => $data['id'],
					'name' => $data['name'],
					'filename' => $file,
					'path' => "$path/$file",
					'version' => $data['version'],
					'slug' => 'wpmudev_install-' . $data['id'],
				);
			}
		}

		return $items;
	}

	/**
	 * Get our special WDP ID header line from the file.
	 *
	 * @uses get_file_data()
	 * @since  1.0.0
	 * @internal
	 * @param  string $plugin_file Main file of the plugin.
	 * @return array Plugin details: name, id, version.
	 */
	protected function get_id_plugin( $plugin_file ) {
		return get_file_data(
			$plugin_file,
			array(
				'name' => 'Plugin Name',
				'id' => 'WDP ID',
				'version' => 'Version',
			)
		);
	}

	/**
	 * Hooks into the plugin update api to add our custom api data.
	 *
	 * @since  1.0.0
	 * @internal Action handler
	 * @param  object $res Default update-info provided by WordPress.
	 * @param  string $action What action was requested (theme or plugin?).
	 * @param  object $args Details used to build default update-info.
	 * @return object Modified theme/plugin update-info.
	 */
	public function filter_plugin_update_info( $res, $action, $args ) {
		global $wp_version;

		// Is WordPress processing a plugin or theme? If not, stop.
		if ( 'plugin_information' != $action && 'theme_information' != $action ) {
			return $res;
		}

		// Is the theme/plugin by WPMUDEV? If not, stop.
		if ( false === strpos( $args->slug, 'wpmudev_install' ) ) {
			return $res;
		}

		// Do we have an API key? If not, stop.
		if ( ! WPMUDEV_Dashboard::$api->has_key() ) {
			return $res;
		}

		$cur_wp_version = preg_replace( '/-.*$/', '', $wp_version );

		$string = explode( '-', $args->slug );
		$id = intval( $string[1] );
		$data = WPMUDEV_Dashboard::$api->get_membership_data();
		$projects = $data['projects'];

		if ( isset( $projects[ $id ] ) && 1 == $projects[ $id ]['autoupdate'] ) {
			$res = (object) array(
				'name' => $projects[ $id ]['name'],
				'slug' => sanitize_title( $projects[ $id ]['name'] ),
				'version' => $projects[ $id ]['version'],
				'rating' => 100,
				'homepage' => $projects[ $id ]['url'],
				'download_link' => WPMUDEV_Dashboard::$api->rest_url_auth( 'install/' . $id ),
				'tested' => $cur_wp_version,
			);

			return $res;
		}
	}

	/**
	 * Update the transient value of available plugin updates right before WordPress saves it to
	 * the database.
	 *
	 * @since  1.0.0
	 * @internal Action hook
	 * @param  object $value The transient value that will be saved.
	 * @return object Modified transient value.
	 */
	public function filter_plugin_update_count( $value ) {
		if ( ! is_object( $value ) ) { return $value; }

		if ( ! self::$_cache_pluginupdates ) {
			// First remove all installed WPMUDEV plugins from the WP update data.
			$local_projects = WPMUDEV_Dashboard::$site->get_cached_projects();

			foreach ( $local_projects as $id => $update ) {
				if ( 'plugin' != $update['type'] ) { continue; }
				if ( isset( $value->response[ $update['filename'] ] ) ) {
					unset( $value->response[ $update['filename'] ] );
				}
				if ( isset( $value->no_update[ $update['filename'] ] ) ) {
					unset( $value->no_update[ $update['filename'] ] );
				}
			}

			// Finally merge available WPMUDEV updates into default WP update data.
			// Value of 'updates_available' is set by API `calculate_upgrades()`.
			$updates = WPMUDEV_Dashboard::$site->get_option( 'updates_available' );
			if ( false === $updates ) {
				$updates = WPMUDEV_Dashboard::$api->calculate_upgrades( $local_projects );
			}

			if ( is_array( $updates ) && count( $updates ) ) {

				foreach ( $updates as $id => $plugin ) {
					if ( 'theme' == $plugin['type'] ) { continue; }
					if ( '2' == $plugin['autoupdate'] ) { continue; }

					$package = '';
					$autoupdate = false;
					$local = $this->get_cached_projects( $id );
					$last_changes = $plugin['changelog'];

					if ( '1' == $plugin['autoupdate'] && WPMUDEV_Dashboard::$api->has_key() ) {
						$package = WPMUDEV_Dashboard::$api->rest_url_auth( 'download/' . $id );
					}

					// Build plugin class.
					$object = (object) array(
						'url' => $plugin['url'],
						'slug' => $local['slug'],
						'new_version' => $plugin['new_version'],
						'package' => $package,
						'autoupdate' => $autoupdate,
					);

					// Add update information to response.
					$value->response[ $plugin['filename'] ] = $object;
				}
			}

			self::$_cache_pluginupdates = $value;
		}

		return self::$_cache_pluginupdates;
	}

	/**
	 * Update the transient value of available theme updates right after
	 * WordPress read it from the database.
	 * We add the WPMUDEV theme-updates to the default list of theme updates.
	 *
	 * @since  1.0.0
	 * @internal Action hook
	 * @param  object $value The transient value that will be saved.
	 * @return object Modified transient value.
	 */
	public function filter_theme_update_count( $value ) {
		if ( ! is_object( $value ) ) { return $value; }

		if ( ! self::$_cache_themeupdates ) {
			// First remove all installed WPMUDEV themes from the WP update data.
			$local_projects = WPMUDEV_Dashboard::$site->get_cached_projects();
			foreach ( $local_projects as $id => $update ) {
				if ( 'theme' != $update['type'] ) { continue; }
				if ( isset( $value->response[ $update['filename'] ] ) ) {
					unset( $value->response[ $update['filename'] ] );
				}
				if ( isset( $value->no_update[ $update['filename'] ] ) ) {
					unset( $value->no_update[ $update['filename'] ] );
				}
			}

			// Value of 'updates_available' is set by API `calculate_upgrades()`.
			$updates = WPMUDEV_Dashboard::$site->get_option( 'updates_available' );
			if ( false === $updates ) {
				$updates = WPMUDEV_Dashboard::$api->calculate_upgrades( $local_projects );
			}

			if ( is_array( $updates ) && count( $updates ) ) {
				// Loop all available WPMUDEV updates and merge them into WP updates.
				foreach ( $updates as $id => $theme ) {
					if ( 'theme' != $theme['type'] ) { continue; }
					if ( '1' != $theme['autoupdate'] ) { continue; }

					$theme_slug = dirname( $theme['filename'] );

					// Build theme listing.
					$object = array();
					$object['url'] = WPMUDEV_Dashboard::$api->rest_url( 'usage/' . $id );
					$object['new_version'] = $theme['new_version'];
					$object['package'] = WPMUDEV_Dashboard::$api->rest_url_auth( 'download/' . $id );
					$object['theme'] = $theme_slug;

					// Add changes back into response.
					$value->response[ $theme_slug ] = $object;
				}
			}

			// Filter 133 theme pack themes from the list unless update is available.
			$themepack = WPMUDEV_Dashboard::$site->get_farm133_themepack();
			if ( is_array( $themepack ) && count( $themepack ) ) {
				foreach ( $themepack as $slug => $theme ) {
					if ( ! isset( $theme['filename'] ) ) { continue; }
					$local_version = $theme['version'];
					$latest_version = $local_version;
					$theme_slug = dirname( $theme['filename'] );
					$theme_id = $theme['pid'];

					// Remove the 133theme from WP update list.
					if ( ! isset( $value->response[ $theme_slug ] ) ) {
						$value->response[ $theme_slug ] = array();
					}

					// Add to count only if new version exists, otherwise remove.
					if ( isset( $updates[ $theme_id ] ) && isset( $updates[ $theme_id ]['new_version'] ) ) {
						$latest_version = $updates[ $theme_id ]['new_version'];
					}

					if ( version_compare( $local_version, $latest_version, '<' ) ) {
						$value->response[ $theme_slug ]['new_version'] = $latest_version;
						$value->response[ $theme_slug ]['package'] = '';
					} else {
						unset( $value->response[ $theme_slug ] );
					}
				}
			}

			self::$_cache_themeupdates = $value;
		}

		return self::$_cache_themeupdates;
	}
}

/**
 * Returns true if the current member is on a full membership-level.
 *
 * @since  4.0.0
 * @return bool
 */
function is_wpmudev_member() {
	$type = WPMUDEV_Dashboard::$api->get_membership_type( $not_used );
	return 'full' == $type;
}

/**
 * Returns true if the current member is on a single membership-level.
 * If project ID is specified then validation is: Single membership for that
 * specific project? Otherwise the licensed project ID is returned (or false
 * if the member is not on a single license)
 *
 * @since  4.0.0
 * @param  int $pid Optional. The project ID to validate.
 *
 * @return bool|int
 */
function is_wpmudev_single_member( $pid = false ) {
	$type = WPMUDEV_Dashboard::$api->get_membership_type( $licensed_project_id );

	if ( 'single' == $type ) {
		if ( $pid ) {
			return $licensed_project_id == $pid;
		} else {
			return $licensed_project_id;
		}
	}
	return false;
}
