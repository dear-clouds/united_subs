<?php
/**
 * UI module.
 * Functions that render some output on the admin site are here.
 * This module also takes care of most hooks and Ajax calls.
 *
 * @since  4.0.0
 * @package WPMUDEV_Dashboard
 */

/**
 * The UI class.
 */
class WPMUDEV_Dashboard_Ui {

	/**
	 * An object that defines all the URLs for the Dashboard menu/submenu items.
	 *
	 * @var object
	 */
	public $page_urls = null;

	/**
	 * Identifies the currently displayed Dashboard module. If current page is
	 * no dashboard page then this value stays false.
	 *
	 * @var bool|string
	 */
	public $current_module = false;

	/**
	 * Is the current admin screen a WPMUDEV Dashboard page?
	 *
	 * @var bool
	 */
	public $is_dashboard = false;

	/**
	 * Set up the UI module. This adds all the initial hooks for the plugin
	 *
	 * @since 4.0.0
	 * @internal
	 */
	public function __construct() {
		// Redirect to login screen on first plugin activation.
		add_action( 'load-plugins.php', array( $this, 'first_redirect' ) );

		// Localize the plugin.
		add_action( 'plugins_loaded', array( $this, 'localization' ) );

		// Hook up our WordPress customizations.
		add_action( 'init', array( $this, 'setup_branding' ) );

		// Get admin page location.
		$urls = new stdClass();
		if ( is_multisite() ) {
			$urls->dashboard_url = network_admin_url( 'admin.php?page=wpmudev' );
			$urls->settings_url  = network_admin_url( 'admin.php?page=wpmudev-settings' );
			$urls->plugins_url   = network_admin_url( 'admin.php?page=wpmudev-plugins' );
			$urls->themes_url    = network_admin_url( 'admin.php?page=wpmudev-themes' );
			$urls->support_url   = network_admin_url( 'admin.php?page=wpmudev-support' );
		} else {
			$urls->dashboard_url = admin_url( 'admin.php?page=wpmudev' );
			$urls->settings_url  = admin_url( 'admin.php?page=wpmudev-settings' );
			$urls->plugins_url   = admin_url( 'admin.php?page=wpmudev-plugins' );
			$urls->themes_url    = admin_url( 'admin.php?page=wpmudev-themes' );
			$urls->support_url   = admin_url( 'admin.php?page=wpmudev-support' );
		}

		// This URL changes depending on the current admin page.
		$urls->real_support_url = $urls->support_url;

		// While not logged in, only the main dashboard_url is working.
		if ( ! WPMUDEV_Dashboard::$api->has_key() ) {
			$urls->settings_url = $urls->dashboard_url;
			$urls->plugins_url = $urls->dashboard_url;
			$urls->themes_url = $urls->dashboard_url;
			$urls->support_url = $urls->dashboard_url;
		}

		if ( WPMUDEV_CUSTOM_API_SERVER ) {
			$urls->remote_site = trailingslashit( WPMUDEV_CUSTOM_API_SERVER );
		} else {
			$urls->remote_site = 'https://premium.wpmudev.org/';
		}

		$this->page_urls = $urls;

		add_filter(
			'wp_prepare_themes_for_js',
			array( $this, 'hide_upfront_theme' ), 100
		);

		add_action(
			'admin_init',
			array( $this, 'brand_updates_table' ),
			15 // Must be called after prio 10 (WP init code is at 10, we modify it).
		);

		// Some core updates need to be modified via javascript.
		add_action(
			'core_upgrade_preamble',
			array( $this, 'modify_core_updates_page' )
		);

		/**
		 * Deprecated customization option:
		 * Load special code if included with the Dashboard plugin.
		 *
		 * Better option: Create a mu-plugin and use the hook
		 * `wpmudev_dashboard_init` to load and setup custom code.
		 */
		if ( file_exists( dirname( __FILE__ ) . '/includes/custom-module.php' ) ) {
			include_once dirname( __FILE__ ) . '/includes/custom-module.php';
		}

		/**
		 * Run custom initialization code for the UI module.
		 *
		 * @since  4.0.0
		 * @var  WPMUDEV_Dashboard_Ui The dashboards UI module.
		 */
		do_action( 'wpmudev_dashboard_ui_init', $this );
	}


	/*
	 * *********************************************************************** *
	 * *     INTERNAL ACTION HANDLERS
	 * *********************************************************************** *
	 */


	/**
	 * Load the translations if WordPress uses non-english language.
	 *
	 * For this you need a ".mo" file with translations.
	 * Name the file "wpmudev-[value in wp-config].mo"  (e.g. wpmudev-de_De.mo)
	 * Save the file to the folder "wp-content/languages/plugins/"
	 *
	 * @since  1.0.0
	 * @internal Action hook
	 */
	public function localization() {
		load_plugin_textdomain(
			'wpmudev',
			false,
			WPMUDEV_Dashboard::$site->plugin_dir . '/language/'
		);
	}

	/**
	 * Checks if plugin was just activated, and redirects to login page.
	 * No redirect if plugin was actiavted via bulk-update.
	 *
	 * @since  1.0.0
	 * @internal Action hook
	 */
	public function first_redirect() {
		$redirect = true;

		// We only redirect right after plugin activation.
		if ( (empty( $_GET['action'] ) || 'activate' != $_GET['action'] ) || empty( $_GET['activate-multi'] ) ) {
			$redirect = false;
		}
		// This is not a valid request.
		if ( defined( 'DOING_AJAX' ) ) {
			$redirect = false;
		} elseif ( ! current_user_can( 'install_plugins' ) ) {
			// User is not allowed to login to the dashboard.
			$redirect = false;
		} elseif ( isset( $_GET['page'] ) && 'wpmudev' == $_GET['page'] ) {
			// User is already on Login page.
			$redirect = false;

			// Save the flag to not redirect again.
			WPMUDEV_Dashboard::$site->set_option( 'redirected_v4', 1 );
		} elseif ( WPMUDEV_Dashboard::$site->get_option( 'redirected_v4' ) ) {
			// We already redirected the user to login page before.
			$redirect = false;
		}

		/* ----- Save the flag and redirect if needed ----- */

		if ( $redirect ) {
			WPMUDEV_Dashboard::$site->set_option( 'redirected_v4', 1 );

			// Force refresh of all data during first redirect.
			WPMUDEV_Dashboard::$site->set_option( 'refresh_remote_flag', 1 );
			WPMUDEV_Dashboard::$site->set_option( 'refresh_local_flag', 1 );
			WPMUDEV_Dashboard::$site->set_option( 'refresh_profile_flag', 1 );

			header( 'X-Redirect-From: UI first_redirect' );
			wp_safe_redirect( $this->page_urls->dashboard_url );
			exit;
		}
	}

	/**
	 * Register the WPMUDEV Dashboard menu structure.
	 *
	 * @since  1.0.0
	 * @internal Action hook
	 */
	public function setup_menu() {
		$is_logged_in = WPMUDEV_Dashboard::$api->has_key();
		$count_output = '';
		$remote_granted = false;
		$update_plugins = 0;
		$update_themes = 0;

		// Redirect user, if we have a valid PID in URL param.
		if ( ! empty( $_GET['page'] ) && 0 === strpos( $_GET['page'], 'wpmudev' ) ) {
			if ( ! empty( $_GET['pid'] ) && is_numeric( $_GET['pid'] ) ) {
				$project = WPMUDEV_Dashboard::$site->get_project_infos( $_GET['pid'] );
				if ( $project ) {
					if ( 'plugin' == $project->type ) {
						$redirect = $this->page_urls->plugins_url . '#pid=' . $project->pid;
						WPMUDEV_Dashboard::$ui->redirect_to( $redirect );
					} elseif ( 'theme' == $project->type ) {
						$redirect = $this->page_urls->themes_url . '#pid=' . $project->pid;
						WPMUDEV_Dashboard::$ui->redirect_to( $redirect );
					}
				}
			}
		}

		if ( $is_logged_in ) {
			// Show total number of available updates.
			$updates = WPMUDEV_Dashboard::$site->get_option( 'updates_available' );
			if ( is_array( $updates ) ) {
				foreach ( $updates as $item ) {
					if ( 'plugin' == $item['type'] ) {
						$update_plugins += 1;
					} elseif ( 'theme' == $item['type'] ) {
						$update_themes += 1;
					}
				}
			}
			$count = $update_plugins + $update_themes;

			if ( $count > 0 ) {
				$count_output = sprintf(
					'<span class="countval">%s</span>',
					$count
				);
			}
			$count_label = array();
			if ( 1 == $update_plugins ) {
				$count_label[] = __( '1 Plugin update', 'wpmudev' );
			} elseif ( $update_plugins > 1 ) {
				$count_label[] = sprintf( __( '%s Plugin updates', 'wpmudev' ), $update_plugins );
			}
			if ( 1 == $update_themes ) {
				$count_label[] = __( '1 Theme update', 'wpmudev' );
			} elseif ( $update_themes > 1 ) {
				$count_label[] = sprintf( __( '%s Theme updates', 'wpmudev' ), $update_themes );
			}

			$count_output = sprintf(
				' <span class="update-plugins total-updates count-%s" title="%s">%s</span>',
				$count,
				implode( ', ', $count_label ),
				$count_output
			);

			$staff_login = WPMUDEV_Dashboard::$api->remote_access_details();
			$remote_granted = $staff_login->enabled;
		} else {
			// Show icon if user is not logged in.
			$count_output = sprintf(
				' <span style="float:right;margin:-1px 13px 0 0;vertical-align:top;border-radius:10px;background:#F8F8F8;width:18px;height:18px;text-align:center" title="%s">%s</span>',
				__( 'Log in to your WPMU DEV account to use all features!', 'wpmudev' ),
				'<i class="dashicons dashicons-lock" style="font-size:14px;width:auto;line-height:18px;color:#333"></i>'
			);
		}

		$need_cap = 'manage_options'; // Single site.
		if ( is_multisite() ) {
			$need_cap = 'manage_network_options'; // Multi site.
		}

		// Dashboard Main Menu.
		$page = add_menu_page(
			__( 'WPMU DEV Dashboard', 'wpmudev' ),
			'WPMU DEV' . $count_output,
			$need_cap,
			'wpmudev',
			array( $this, 'render_dashboard' ),
			$this->get_menu_icon(),
			WPMUDEV_MENU_LOCATION
		);
		add_action( 'admin_print_styles-' . $page, array( $this, 'admin_styles' ) );

		$this->add_submenu(
			'wpmudev',
			__( 'WPMU DEV Dashboard', 'wpmudev' ),
			__( 'Dashboard', 'wpmudev' ),
			array( $this, 'render_dashboard' )
		);

		if ( $is_logged_in ) {
			$data = WPMUDEV_Dashboard::$api->get_membership_data();

			/**
			 * Use this action to register custom sub-menu items.
			 *
			 * The action is called before each of the default submenu items
			 * is registered, so other plugins can hook into any position they
			 * like by checking the action parameter.
			 *
			 * @var  WPMUDEV_Dashboard_ui $ui Use $ui->add_submenu() to register
			 *       new menu items.
			 * @var  string $menu The menu-item that is about to be set up.
			 */
			do_action( 'wpmudev_dashboard_setup_menu', $this, 'plugins' );

			$plugin_badge = sprintf(
				' <span class="update-plugins plugin-updates count-%s"><span class="countval">%s</span></span>',
				$update_plugins,
				$update_plugins
			);
			// Plugins page.
			$this->add_submenu(
				'plugins',
				__( 'WPMU DEV Plugins', 'wpmudev' ),
				__( 'Plugins', 'wpmudev' ) . $plugin_badge,
				array( $this, 'render_plugins' ),
				'install_plugins'
			);

			do_action( 'wpmudev_dashboard_setup_menu', 'themes' );

			$theme_badge = sprintf(
				' <span class="update-plugins theme-updates count-%s"><span class="countval">%s</span></span>',
				$update_themes,
				$update_themes
			);
			$this->add_submenu(
				'themes',
				__( 'WPMU DEV Themes', 'wpmudev' ),
				__( 'Themes', 'wpmudev' ) . $theme_badge,
				array( $this, 'render_themes' ),
				'install_themes'
			);

			do_action( 'wpmudev_dashboard_setup_menu', 'support' );

			// Support page.
			$support_icon = '';
			if ( $remote_granted ) {
				$support_icon = sprintf(
					' <i class="dashicons dashicons-unlock wdev-access-granted" title="%s"></i>',
					__( 'Support Access enabled', 'wpmudev' )
				);
			}
			$this->add_submenu(
				'support',
				__( 'WPMU DEV Support', 'wpmudev' ),
				__( 'Support', 'wpmudev' ) . $support_icon,
				array( $this, 'render_support' ),
				$need_cap
			);

			do_action( 'wpmudev_dashboard_setup_menu', 'settings' );

			// Manage (Settings).
			$this->add_submenu(
				'settings',
				__( 'WPMU DEV Settings', 'wpmudev' ),
				__( 'Manage', 'wpmudev' ),
				array( $this, 'render_settings' ),
				$need_cap
			);

			do_action( 'wpmudev_dashboard_setup_menu', 'end' );
		}
	}

	/**
	 * Add link to WPMU DEV Dashboard to the WP toolbar; only for multisite
	 * networks, since single-site admins always see the WPMU DEV menu item.
	 *
	 * @since  4.1.0
	 * @param  WP_Admin_Bar $wp_admin_bar The toolbar handler object.
	 */
	public function setup_toolbar( $wp_admin_bar ) {
		if ( is_multisite() ) {
			$args = array(
				'id' => 'network-admin-d2',
				'title' => 'WPMU DEV Dashboard',
				'href' => $this->page_urls->dashboard_url,
				'parent' => 'network-admin',
			);

			$wp_admin_bar->add_node( $args );
		}
	}

	/**
	 * Compatibility URLs with old plugin version.
	 * This can be dropped sometime in the future, when members updated to v4
	 *
	 * @since  4.0.3
	 */
	public function admin_menu_redirect_compat() {
		global $pagenow;
		if ( 'admin.php' && isset( $_GET['page'] ) ) {
			$redirect_to = false;

			switch ( $_GET['page'] ) {
				case 'wpmudev-updates':
					$redirect_to = $this->page_urls->dashboard_url;
					break;
			}

			if ( $redirect_to ) {
				header( 'X-Redirect-From: UI redirect_compat' );
				wp_safe_redirect( $redirect_to );
				exit;
			}
		}
	}

	/**
	 * Load the CSS styles.
	 *
	 * @since  1.0.0
	 * @internal Action hook
	 */
	public function admin_styles() {
		// Remember: Current page is on the WPMUDEV Dashboard!
		$this->is_dashboard = true;
		$this->current_module = 'dashboard';

		// Find out what items to display in the search field.
		$screen = get_current_screen();
		$search_for = 'all';
		$search_class = 'plugins';

		if ( is_object( $screen ) ) {
			$base = (string) $screen->base;

			switch ( true ) {
				case false !== strpos( $base, 'themes' ):
					$search_for = 'theme';
					$search_class = 'themes';
					$this->current_module = 'themes';
					break;

				case false !== strpos( $base, 'plugins' ):
					$search_for = 'plugin';
					$this->current_module = 'plugins';
					break;

				case false !== strpos( $base, 'support' ):
					$this->current_module = 'support';
					break;

				case false !== strpos( $base, 'settings' ):
					$this->current_module = 'settings';
					break;
			}
		}

		/*
		 * Beta-testers will not have cached scripts!
		 * Just in case we have to update the plugin prior to launch.
		 */
		if ( defined( 'WPMUDEV_BETATEST' ) && WPMUDEV_BETATEST ) {
			$script_version = time();
		} else {
			$script_version = WPMUDEV_Dashboard::$version;
		}

		// Enqueue styles =====================================================.
		wp_enqueue_style(
			'wpmudev-admin-css',
			WPMUDEV_Dashboard::$site->plugin_url . 'css/dashboard.css',
			array(),
			$script_version
		);

		// Register scripts ===================================================.
		wp_enqueue_script(
			'wpmudev-dashboard-modules',
			WPMUDEV_Dashboard::$site->plugin_url . 'js/modules.js',
			array( 'jquery' ),
			$script_version
		);

		// Load/Enqueue the plugin UI module.
		WDEV_Plugin_Ui::load(
			WPMUDEV_Dashboard::$site->plugin_url . 'shared-ui/',
			'wpmud-' . $this->current_module
		);

		// Hide all default admin notices from another source on these pages.
		remove_all_actions( 'admin_notices' );
		remove_all_actions( 'network_admin_notices' );
		remove_all_actions( 'all_admin_notices' );
	}

	/**
	 * Enqueue Dashboard styles on all non-dashboard admin pages.
	 *
	 * @since  1.0.0
	 * @internal Action hook
	 */
	public function notification_styles() {
		echo '<style>#toplevel_page_wpmudev .wdev-access-granted { font-size: 14px; line-height: 13px; height: 13px; float: right; color: #1ABC9C; }</style>';
	}


	/*
	 * *********************************************************************** *
	 * *     PUBLIC INTERFACE FOR OTHER MODULES
	 * *********************************************************************** *
	 */


	/**
	 * Should we hide the one-click-installation message from current user?
	 * This message is used on the theme and plugin pages.
	 *
	 * @since  1.0.0
	 * @return bool
	 */
	public function hide_install_notice() {
		return WPMUDEV_Dashboard::$site->get_usermeta( '_wpmudev_install_message' );
	}

	/**
	 * Official way to add new submenu items to the WPMUDEV Dashboard.
	 * The Dashboard styles are automatically enqueued for the new page.
	 *
	 * @since 4.0.0
	 * @param  string   $id The ID is prefixed with 'wpmudev-' for the page body class.
	 * @param  string   $title The documents title-tag.
	 * @param  string   $label The menu label.
	 * @param  callable $handler Function that is executed to render page content.
	 * @param  string   $capability Optional. Required capability. Default: manage_options.
	 * @return string Page hook_suffix of the new menu item.
	 */
	public function add_submenu( $id, $title, $label, $handler, $capability = 'manage_options' ) {
		static $Registered = array();

		// Prevent duplicates of the same menu item.
		if ( isset( $Registered[ $id ] ) ) { return; }
		$Registered[ $id ] = true;

		if ( false === strpos( $id, 'wpmudev' ) ) {
			$id = 'wpmudev-' . $id;
		}

		$page = add_submenu_page(
			'wpmudev',
			$title,
			$label,
			$capability,
			$id,
			$handler
		);
		add_action( 'admin_print_styles-' . $page, array( $this, 'admin_styles' ) );

		return $page;
	}


	/*
	 * *********************************************************************** *
	 * *     HANDLE BRANDING
	 * *********************************************************************** *
	 */


	/**
	 * Register our plugin branding.
	 *
	 * I.e. Setup all the things that are NOT on the dashboard page but modify
	 * the look & feel of WordPress core pages.
	 *
	 * @since  1.0.0
	 * @internal Action hook
	 */
	public function setup_branding() {
		/*
		 * If the current user has access to the WPMUDEV Dashboard then we
		 * always set up our branding hooks.
		 */
		if ( ! WPMUDEV_Dashboard::$site->allowed_user() ) { return false; }

		// Always add this toolbar item, also on front-end.
		add_action(
			'admin_bar_menu',
			array( $this, 'setup_toolbar' ),
			999
		);

		if ( ! is_admin() ) { return false; }

		// Add branded links to install/update process.
		add_filter(
			'install_plugin_complete_actions',
			array( $this, 'branding_install_plugin_done' ), 10, 3
		);
		add_filter(
			'install_theme_complete_actions',
			array( $this, 'branding_install_theme_done' ), 10, 4
		);
		add_filter(
			'update_plugin_complete_actions',
			array( $this, 'branding_update_plugin_done' ), 10, 2
		);
		add_filter(
			'update_theme_complete_actions',
			array( $this, 'branding_update_theme_done' ), 10, 2
		);

		// Add the menu icon to the admin menu.
		if ( is_multisite() ) {
			$menu_hook = 'network_admin_menu';
		} else {
			$menu_hook = 'admin_menu';
		}

		add_action(
			$menu_hook,
			array( $this, 'admin_menu_redirect_compat' )
		);

		add_action(
			$menu_hook,
			array( $this, 'setup_menu' )
		);

		// Abort request if we only need the menu.
		add_action(
			'in_admin_header',
			array( $this, 'maybe_return_menu' )
		);

		// Always load notification css.
		add_action(
			'admin_print_styles',
			array( $this, 'notification_styles' )
		);
	}

	/**
	 * Add WPMUDEV link as return action after installing DEV plugins.
	 *
	 * Default actions are "Return to Themes/Plugins" and "Return to WP Updates"
	 * This filter adds a "Return to WPMUDEV Updates"
	 *
	 * @since  1.0.0
	 * @internal Action hook
	 * @param  array  $install_actions Array of further actions to display.
	 * @param  object $api The update API details.
	 * @param  string $plugin_file Main plugin file.
	 * @return array
	 */
	public function branding_install_plugin_done( $install_actions, $api, $plugin_file ) {
		if ( ! empty( $api->download_link ) ) {
			if ( WPMUDEV_Dashboard::$api->is_server_url( $api->download_link ) ) {
				$install_actions['plugins_page'] = sprintf(
					'<a href="%s" title="%s" target="_parent">%s</a>',
					$this->page_urls->plugins_url,
					esc_attr__( 'Return to WPMU DEV Plugins', 'wpmudev' ),
					__( 'Return to WPMU DEV Plugins', 'wpmudev' )
				);
			}
		}

		return $install_actions;
	}

	/**
	 * Add WPMUDEV link as return action after upgrading DEV plugins.
	 *
	 * Default actions are "Return to Themes/Plugins" and "Return to WP Updates"
	 * This filter adds a "Return to WPMUDEV Updates"
	 *
	 * @since  1.0.0
	 * @internal Action hook
	 * @param  array  $update_actions Array of further actions to display.
	 * @param  string $plugin Main plugin file.
	 * @return array
	 */
	public function branding_update_plugin_done( $update_actions, $plugin ) {
		$updates = WPMUDEV_Dashboard::$site->get_transient( 'update_plugins', false );

		if ( ! empty( $updates->response[ $plugin ] ) ) {
			if ( WPMUDEV_Dashboard::$api->is_server_url( $updates->response[ $plugin ]->package ) ) {
				$update_actions['plugins_page'] = sprintf(
					'<a href="%s" title="%s" target="_parent">%s</a>',
					$this->page_urls->plugins_url,
					esc_attr__( 'Return to WPMU DEV Plugins', 'wpmudev' ),
					__( 'Return to WPMU DEV Plugins', 'wpmudev' )
				);
			}
		}

		return $update_actions;
	}

	/**
	 * Add WPMUDEV link as return action after installing DEV themes.
	 *
	 * Default actions are "Return to Themes/Plugins" and "Return to WP Updates"
	 * This filter adds a "Return to WPMUDEV Updates"
	 *
	 * @since  1.0.0
	 * @internal Action hook
	 * @param  array  $install_actions Array of further actions to display.
	 * @param  object $api The update API details.
	 * @param  string $stylesheet Theme stylesheet name.
	 * @param  object $theme_info Further details about the theme.
	 * @return array
	 */
	public function branding_install_theme_done( $install_actions, $api, $stylesheet, $theme_info ) {
		/*
		 * If just installed an Upfront child theme and Upfront is not
		 * installed warn them with a link.
		 */
		$need_upfront = ('upfront' == $theme_info->template && 'upfront' != $stylesheet);

		if ( $need_upfront && ! WPMUDEV_Dashboard::$site->is_upfront_installed() ) {
			$install_link = WPMUDEV_Dashboard::$upgrader->auto_install_url( WPMUDEV_Dashboard::$site->id_upfront );

			if ( $install_link ) {
				$install_actions = array(
					'install_upfront' => sprintf(
						'<a id="install_upfront" href="%s" title="%s" target="_parent"><strong>%s</strong></a>',
						$install_link,
						esc_attr__( 'You must install the Upfront parent theme for this theme to work.', 'wpmudev' ),
						__( 'Install Upfront (Required)', 'wpmudev' )
					),
				);
				// User cannot activate the theme yet, so offer only 1 action.
				return $install_actions;
			}
		}

		/*
		 * If we just installed Upfront (parent theme) then don't show the
		 * action links which won't work for the parent theme.
		 */
		if ( 'upfront' == $stylesheet ) {
			unset( $install_actions['network_enable'] );
			unset( $install_actions['activate'] );
			unset( $install_actions['preview'] );
		}

		if ( isset( $api->download_link ) ) {
			if ( WPMUDEV_Dashboard::$api->is_server_url( $api->download_link ) ) {
				$install_actions['themes_page'] = sprintf(
					'<a href="%s" title="%s" target="_parent">%s</a>',
					$this->page_urls->themes_url,
					esc_attr__( 'Return to WPMU DEV Themes', 'wpmudev' ),
					__( 'Return to WPMU DEV Themes', 'wpmudev' )
				);
			}
		}

		return $install_actions;
	}

	/**
	 * Add WPMUDEV link as return action after upgrading DEV themes.
	 *
	 * Default actions are "Return to Themes/Plugins" and "Return to WP Updates"
	 * This filter adds a "Return to WPMUDEV Updates"
	 *
	 * @since  1.0.0
	 * @internal Action hook
	 * @param  array  $update_actions Array of further actions to display.
	 * @param  string $theme Name of the theme (= folder name).
	 * @return array
	 */
	public function branding_update_theme_done( $update_actions, $theme ) {
		$updates = WPMUDEV_Dashboard::$site->get_transient( 'update_themes', false );

		if ( ! empty( $updates->response[ $theme ] ) ) {
			/*
			 * If we just installed Upfront (parent theme) then don't show the
			 * action links which won't work for the parent theme.
			 */
			if ( 'upfront' == $theme ) {
				unset( $update_actions['network_enable'] );
				unset( $update_actions['activate'] );
				unset( $update_actions['preview'] );
			}

			if ( WPMUDEV_Dashboard::$api->is_server_url( $updates->response[ $theme ]['package'] ) ) {
				$update_actions['themes_page'] = sprintf(
					'<a href="%s" title="%s" target="_parent">%s</a>',
					$this->page_urls->themes_url,
					esc_attr__( 'Return to WPMU DEV Themes', 'wpmudev' ),
					__( 'Return to WPMU DEV Themes', 'wpmudev' )
				);
			}
		}

		return $update_actions;
	}

	/**
	 * Removes Upfront from being activatable in the theme browser.
	 *
	 * @since  3.0.0
	 * @internal Action hook
	 * @param  array $prepared_themes List of installed WordPress themes.
	 * @return array
	 */
	public function hide_upfront_theme( $prepared_themes ) {
		unset( $prepared_themes['upfront'] );
		return $prepared_themes;
	}

	/**
	 * Called on update-core.php after the list of available updates is printed.
	 * We use this opportunty to inset javascript to modify the update-list
	 * since there are no exising hooks in WP to do this on PHP side:
	 *
	 * Some plugins/themes might not support auto-update. Those items must be
	 * disabled here!
	 *
	 * @since  4.1.0
	 */
	public function modify_core_updates_page() {
		$projects = WPMUDEV_Dashboard::$site->get_cached_projects();
		$themepack = WPMUDEV_Dashboard::$site->get_farm133_themepack();

		$disable = array();
		foreach ( $projects as $pid => $data ) {
			$item = WPMUDEV_Dashboard::$site->get_project_infos( $pid );
			if ( ! $item ) { continue; } // Possibly a free wp.org plugin.
			if ( ! $item->can_update || ! $item->can_autoupdate ) {
				if ( 'plugin' == $item->type ) {
					$disable[ $item->filename ] = $item->url->infos;
				} elseif ( 'theme' == $item->type ) {
					$disable[ $item->slug ] = $item->url->infos;
				}
			}
		}
		?>
		<style>
		.wpmudev-disabled th,
		.wpmudev-disabled td {
			position: relative;
		}
		.wpmudev-disabled th:before,
		.wpmudev-disabled td:before {
			content: '';
			position: absolute;
			left: 0;
			top: 1px;
			right: 0;
			bottom: 1px;
			z-index: 10;
			background: #F8F8F8;
			opacity: 0.5;
		}
		.wpmudev-info {
			font-style: italic;
			position: relative;
			z-index: 11;
		}
		</style>
		<script>
		;(function(){
			var no_update = <?php echo json_encode( $disable ); ?>;
			if ( ! no_update ) { return; }
			for ( var ind in no_update ) {
				if ( ! no_update.hasOwnProperty(ind) ) { continue; }

				var chk = jQuery( 'input[type=checkbox][value="' + ind + '"]');
				var row = chk.closest('tr');
				var infos = row.find('td').last();
				var url = no_update[ind];
				var note = "<?php esc_attr_e( 'Auto-Update not possible.', 'wpmudev' ) ?>";

				chk.prop('disabled', true).prop('checked', false).attr('name', '').addClass('disabled');
				row.addClass('wpmudev-disabled');

				if ( url && url.length ) {
					note += ' <a href="' + url + '"><?php esc_attr_e( 'More infos', 'wpmudev' ); ?></a>';
				}
				infos.append('<div class="wpmudev-info">' + note + '</div>');
			}
		}());
		</script>
		<?php
	}

	/**
	 * Here we will set up custom code to display WPMUDEV plugins/themes on the
	 * pages for WP Updates, Themes and Plugins.
	 *
	 * @since  4.0.0
	 */
	public function brand_updates_table() {
		if ( ! current_user_can( 'update_plugins' ) ) { return; }

		$updates = WPMUDEV_Dashboard::$site->get_option( 'updates_available' );
		if ( is_array( $updates ) && count( $updates ) ) {
			foreach ( $updates as $item ) {
				if ( ! empty( $item['autoupdate'] ) && 2 != $item['autoupdate'] ) {
					if ( 'theme' == $item['type'] ) {
						$hook = 'after_theme_row_' . $item['filename'];
					} else {
						$hook = 'after_plugin_row_' . $item['filename'];
					}
					remove_all_actions( $hook );
					add_action( $hook, array( $this, 'brand_updates_plugin_row' ), 9, 2 );
				}
			}
		}

		$id_themepack = WPMUDEV_Dashboard::$site->id_farm133_themes;
		if ( isset( $updates[ $id_themepack ] ) ) {
			$update = $updates[ $id_themepack ];
			$themepack = WPMUDEV_Dashboard::$site->get_farm133_themepack();
			if ( is_array( $themepack ) && count( $themepack ) ) {
				foreach ( $themepack as $item ) {
					$hook = 'after_theme_row_' . $item['filename'];
					remove_all_actions( $hook );

					// Only add the notice if specific version is wrong.
					if ( version_compare( $item['version'], $update['new_version'], '<' ) ) {
						add_action( $hook, array( $this, 'brand_updates_farm133_row' ), 9, 2 );
					}
				}
			}
		}
	}

	/**
	 * Output a single plugin-row inside the core WP update-plugins list.
	 *
	 * Though the name says "plugin_row", this function is also used to render
	 * rows inside the themes-update list. Code is identical.
	 *
	 * @since  4.0.5
	 * @param  string $file The plugin ID (dir- and filename).
	 * @param  array  $plugin_data Plugin details.
	 */
	public function brand_updates_plugin_row( $file, $plugin_data ) {
		// Get new version and update URL.
		$updates = WPMUDEV_Dashboard::$site->get_option( 'updates_available' );

		if ( ! is_array( $updates ) || ! count( $updates ) ) { return; }
		if ( ! current_user_can( 'update_plugins' ) ) { return; }
		$project = false;

		foreach ( $updates as $id => $plugin ) {
			if ( $plugin['filename'] == $file ) {
				$project_id = $id;
				$project = $plugin;
				break;
			}
		}

		if ( $project ) {
			$this->brand_updates_row_output( $project_id, $project, $plugin_data['Name'] );
		}
	}

	/**
	 * Output a single theme-row inside the core WP update-themes list.
	 *
	 * This handler is only used when updates are available for the farm133
	 * themepack, all other themes are handled by the `brand_updates_plugin_row`
	 * handler above.
	 *
	 * @since  4.0.5
	 * @param  string $file The theme slug.
	 * @param  array  $plugin_data Theme details.
	 */
	public function brand_updates_farm133_row( $file, $plugin_data ) {
		// Get new version and update URL.
		$updates = WPMUDEV_Dashboard::$site->get_option( 'updates_available' );
		$id_themepack = WPMUDEV_Dashboard::$site->id_farm133_themes;

		if ( ! isset( $updates[ $id_themepack ] ) ) { return; }
		if ( ! current_user_can( 'update_themes' ) ) { return; }

		$project = $updates[ $id_themepack ];
		$this->brand_updates_row_output( $id_themepack, $project, $plugin_data['Name'] );
	}

	/**
	 * Shared helper used by brand_updates_* functions above.
	 * This function actually renders the table row with the update text.
	 *
	 * @since  4.0.5
	 * @param  int    $project_id Our internal project-ID.
	 * @param  array  $project The project details.
	 * @param  string $project_name The plugin/theme name.
	 */
	protected function brand_updates_row_output( $project_id, $project, $project_name ) {
		$version = $project['new_version'];
		$plugin_url = $project['url'];
		$autoupdate = $project['autoupdate'];
		$filename = $project['filename'];
		$type = $project['type'];

		$plugins_allowedtags = array(
			'a'       => array( 'href' => array(), 'title' => array(), 'class' => array(), 'target' => array() ),
			'abbr'    => array( 'title' => array() ),
			'acronym' => array( 'title' => array() ),
			'code'    => array(),
			'em'      => array(),
			'strong'  => array(),
		);
		$plugin_name = wp_kses( $project_name, $plugins_allowedtags );

		$url_changelog = add_query_arg(
			array(
				'action' => 'wdp-changelog',
				'pid' => $project_id,
				'hash' => wp_create_nonce( 'changelog' ),
			),
			admin_url( 'admin-ajax.php' )
		);

		$url_action = false;

		if ( WPMUDEV_Dashboard::$upgrader->user_can_install( $project_id ) ) {
			// Current user is logged in and has permission for this plugin.
			if ( $autoupdate ) {
				// All clear: One-Click-Update is available for this plugin!
				$url_action = WPMUDEV_Dashboard::$upgrader->auto_update_url( $project_id );
				$row_text = __( 'There is a new version of %1$s available on WPMU DEV. <a href="%2$s" class="thickbox" title="%3$s">View version %4$s details</a> or <a href="%5$s">automatically update</a>.', 'wpmudev' );
			} else {
				// Can only be manually installed.
				$url_action = $plugin_url;
				$row_text = __( 'There is a new version of %1$s available on WPMU DEV. <a href="%2$s" class="thickbox" title="%3$s">View version %4$s details</a> or <a href="%5$s" target="_blank" title="Download update from WPMU DEV">download update</a>.', 'wpmudev' );
			}
		} elseif ( WPMUDEV_Dashboard::$site->allowed_user() ) {
			// User has no permission for the plugin (anymore).
			if ( ! WPMUDEV_Dashboard::$api->has_key() ) {
				// Ah, the user is not logged in... update currently not available.
				$url_action = $this->page_urls->dashboard_url;
				$row_text = __( 'There is a new version of %1$s available on WPMU DEV. <a href="%2$s" class="thickbox" title="%3$s">View version %4$s details</a> or <a href="%5$s" target="_blank" title="Setup your WPMU DEV account to update">configure to update</a>.', 'wpmudev' );
			} else {
				// User is logged in but apparently no license for the plugin.
				$url_action = apply_filters(
					'wpmudev_project_upgrade_url',
					$this->page_urls->remote_site . 'wp-login.php?redirect_to=' . urlencode( $plugin_url ) . '#signup',
					$project_id
				);
				$row_text = __( 'There is a new version of %1$s available on WPMU DEV. <a href="%2$s" class="thickbox" title="%3$s">View version %4$s details</a> or <a href="%5$s" target="_blank" title="Upgrade your WPMU DEV membership">upgrade to update</a>.', 'wpmudev' );
			}
		} else {
			// This user has no permission to use WPMUDEV Dashboard.
			$row_text = __( 'There is a new version of %1$s available on WPMU DEV. <a href="%2$s" class="thickbox" title="%3$s">View version %4$s details</a>.', 'wpmudev' );
		}

		?><tr class="plugin-update-tr">
		<td colspan="3" class="plugin-update colspanchange">
			<div class="update-message">
				<?php
				printf(
					wp_kses( $row_text, $plugins_allowedtags ),
					esc_html( $plugin_name ),
					esc_url( $url_changelog ),
					esc_attr( $plugin_name ),
					esc_html( $version ),
					esc_url( $url_action )
				);
				?>
			</div>
		</td>
		</tr>
		<?php
	}


	/*
	 * *********************************************************************** *
	 * *     RENDER MENU PAGES
	 * *********************************************************************** *
	 */


	/**
	 * Outputs the Main Dashboard admin page
	 *
	 * @since  1.0.0
	 * @internal Menu callback
	 */
	public function render_dashboard() {
		// These two variables are used in template login.php.
		$connection_error = false;
		$key_valid = true;

		if ( ! current_user_can( 'manage_options' ) ) {
			$this->load_template( 'no_access' );
		}

		// User arrives here: First redirect is done.
		WPMUDEV_Dashboard::$site->set_option( 'redirected_v4', 1 );

		if ( ! empty( $_GET['clear_key'] ) ) {
			// User requested to log-out.
			WPMUDEV_Dashboard::$site->logout();
		} elseif ( ! empty( $_REQUEST['set_apikey'] ) ) {
			// User tried to log-in.
			WPMUDEV_Dashboard::$api->set_key( trim( $_REQUEST['set_apikey'] ) );
			$result = WPMUDEV_Dashboard::$api->refresh_membership_data();

			if ( ! $result || empty( $result['membership'] ) ) {
				// Don't logout at this point!
				WPMUDEV_Dashboard::$api->set_key( '' );
				$key_valid = false;

				if ( false === $result ) { $connection_error = true; }
			} else {
				// You did it! Login was successful :)
				// The current user is our new hero-user with Dashboard access.
				global $current_user;
				$key_valid = true;
				WPMUDEV_Dashboard::$site->set_option( 'limit_to_user', $current_user->ID );
				WPMUDEV_Dashboard::$api->refresh_profile();

				// Login worked, so remove the API key again from the URL so it
				// does not get stored in the browser history.
				$url = esc_url_raw(
					remove_query_arg( array( 'clear_key', 'set_apikey' ) )
				);
				$this->redirect_to( $url );
			}
		}

		$data = WPMUDEV_Dashboard::$api->get_membership_data();
		$member = WPMUDEV_Dashboard::$api->get_profile();
		$is_logged_in = WPMUDEV_Dashboard::$api->has_key();
		$type = WPMUDEV_Dashboard::$api->get_membership_type( $project_id );
		$urls = $this->page_urls;
		$my_project = false;

		echo '<div id="container" class="wrap wrap-dashboard">';

		if ( ! $is_logged_in ) {
			// User did not log in to WPMUDEV -> Show login page!
			$this->load_template(
				'login',
				compact( 'key_valid', 'connection_error', 'urls' )
			);
		} elseif ( ! WPMUDEV_Dashboard::$site->allowed_user() ) {
			// User has no permission to view the page.
			$this->load_template( 'no_access' );
		} else {

			/**
			 * Custom hook to display own notifications inside Dashboard.
			 */
			do_action( 'wpmudev_dashboard_notice-dashboard' );

			if ( $project_id ) {
				$my_project = WPMUDEV_Dashboard::$site->get_project_infos( $project_id );
			}

			$this->load_template(
				'dashboard',
				compact( 'data', 'member', 'urls', 'type', 'my_project' )
			);

			if ( 'free' == $type ) {
				$this->render_upgrade_box( 'free' );
			}
		}

		echo '</div>';

	}

	/**
	 * Outputs the Plugins admin page
	 *
	 * @since  1.0.0
	 * @internal Menu callback
	 */
	public function render_plugins() {
		if ( ! current_user_can( 'install_plugins' ) ) {
			$this->load_template( 'no_access' );
		}

		if ( ! isset( $_GET['fetch_menu'] ) || 1 != $_GET['fetch_menu'] ) {
			// When Plugins page is opened we always scan local folders for changes.
			WPMUDEV_Dashboard::$site->set_option( 'refresh_local_flag', 1 );
			WPMUDEV_Dashboard::$site->refresh_local_projects( 'remote' );
		}

		$data = WPMUDEV_Dashboard::$api->get_membership_data();
		$membership_type = WPMUDEV_Dashboard::$api->get_membership_type( $dummy );
		$tags = $this->tags_data( 'plugin' );
		$urls = $this->page_urls;

		/**
		 * Custom hook to display own notifications inside Dashboard.
		 */
		do_action( 'wpmudev_dashboard_notice-plugins' );

		echo '<div id="container" class="wrap wrap-plugins">';
		$this->load_template(
			'plugins',
			compact( 'data', 'urls', 'tags' )
		);
		echo '</div>';

		if ( ! WPMUDEV_Dashboard::$upgrader->can_auto_install( 'plugin' ) ) {
			$this->load_template( 'popup-ftp-details' );
		}

		if ( 'full' != $membership_type ) {
			$this->render_upgrade_box( 'single', false );
		}
	}

	/**
	 * Outputs the Themes admin page
	 *
	 * @since  1.0.0
	 * @internal Menu callback
	 */
	public function render_themes() {
		if ( ! current_user_can( 'install_themes' ) ) {
			$this->load_template( 'no_access' );
		}

		if ( ! isset( $_GET['fetch_menu'] ) || 1 != $_GET['fetch_menu'] ) {
			// When Themes page is opened we always scan local folders for changes.
			WPMUDEV_Dashboard::$site->set_option( 'refresh_local_flag', 1 );
			WPMUDEV_Dashboard::$site->refresh_local_projects( 'remote' );
		}

		$data = WPMUDEV_Dashboard::$api->get_membership_data();
		$membership_type = WPMUDEV_Dashboard::$api->get_membership_type( $dummy );
		$urls = $this->page_urls;

		// Remove plugins and legacy themes.
		foreach ( $data['projects'] as $key => $project ) {
			if ( 'theme' != $project['type'] ) {
				unset( $data['projects'][ $key ] );
			}
		}

		/**
		 * Custom hook to display own notifications inside Dashboard.
		 */
		do_action( 'wpmudev_dashboard_notice-themes' );

		echo '<div id="container" class="wrap wrap-themes">';
		$this->load_template(
			'themes',
			compact( 'data', 'urls' )
		);
		echo '</div>';

		if ( ! WPMUDEV_Dashboard::$upgrader->can_auto_install( 'theme' ) ) {
			$this->load_template( 'popup-ftp-details' );
		}

		if ( 'full' != $membership_type ) {
			$this->render_upgrade_box( 'single', false );
		}
	}

	/**
	 * Outputs the Support admin page.
	 *
	 * @since  1.0.0
	 * @internal Menu callback
	 */
	public function render_support() {
		$required = (is_multisite() ? 'manage_network_options' : 'manage_options');
		if ( ! current_user_can( $required ) ) {
			$this->load_template( 'no_access' );
		}

		$this->page_urls->real_support_url = $this->page_urls->remote_site . 'hub/support/';

		$profile = WPMUDEV_Dashboard::$api->get_profile();
		$data = WPMUDEV_Dashboard::$api->get_membership_data();
		$spinner = WPMUDEV_Dashboard::$site->plugin_url . 'includes/images/spinner-dark.gif';
		$urls = $this->page_urls;
		$staff_login = WPMUDEV_Dashboard::$api->remote_access_details();
		$notes = WPMUDEV_Dashboard::$site->get_option( 'staff_notes' );
		$access = WPMUDEV_Dashboard::$site->get_option( 'remote_access' );
		if ( empty( $access['logins'] ) || ! is_array( $access['logins'] ) ) {
			$access_logs = array();
		} else {
			$access_logs = $access['logins'];
		}

		/**
		 * Custom hook to display own notifications inside Dashboard.
		 */
		do_action( 'wpmudev_dashboard_notice-support' );

		echo '<div id="container" class="wrap wrap-support">';
		$this->load_template(
			'support',
			compact( 'profile', 'data', 'urls', 'staff_login', 'notes', 'access_logs' )
		);
		echo '</div>';
	}

	/**
	 * Outputs the Manage/Settings admin page
	 *
	 * @since  1.0.0
	 * @internal Menu callback
	 */
	public function render_settings() {
		$required = (is_multisite() ? 'manage_network_options' : 'manage_options');
		if ( ! current_user_can( $required ) ) {
			$this->load_template( 'no_access' );
		}

		$data = WPMUDEV_Dashboard::$api->get_membership_data();
		$member = WPMUDEV_Dashboard::$api->get_profile();
		$urls = $this->page_urls;
		$membership_label = __( 'Free', 'wpmudev' );
		$allowed_users = WPMUDEV_Dashboard::$site->get_allowed_users();
		$auto_update = WPMUDEV_Dashboard::$site->get_option( 'autoupdate_dashboard' );
		$membership_type = WPMUDEV_Dashboard::$api->get_membership_type( $single_id );

		/**
		 * Custom hook to display own notifications inside Dashboard.
		 */
		do_action( 'wpmudev_dashboard_notice-settings' );

		echo '<div id="container" class="wrap wrap-settings">';
		$this->load_template(
			'settings',
			compact( 'data', 'member', 'urls', 'membership_type', 'allowed_users', 'auto_update', 'single_id' )
		);
		echo '</div>';
	}

	/**
	 * Renders the template header that is repeated on every page.
	 *
	 * @since  4.0.0
	 * @param  string $page_title The page caption.
	 */
	protected function render_header( $page_title ) {
		$urls = $this->page_urls;
		$url_support = $urls->real_support_url;
		$url_dash = 'https://premium.wpmudev.org/hub/';
		$url_logout = $urls->dashboard_url . '&clear_key=1';

		if ( $url_support == $urls->support_url ) {
			$support_target = '_self';
		} else {
			$support_target = '_blank';
		}

		?>
		<section id="header">
			<div class="actions">
				<?php if ( WPMUDEV_CUSTOM_API_SERVER ) : ?>
				<span class="flag">
					<span class="tooltip-bottom" tooltip="<?php echo esc_attr( sprintf( "Custom API Server:\n%s", WPMUDEV_CUSTOM_API_SERVER ) ); ?>">
					<i class="wdv-icon wdv-icon-beaker"></i>
					</span>
				</span>
				<?php endif; ?>
				<a href="<?php echo esc_url( $url_support ); ?>" target="<?php echo esc_attr( $support_target ); ?>" class="button">
					<?php esc_html_e( 'Get Support', 'wpmudev' ); ?>
				</a>
				<a href="<?php echo esc_url( $url_dash ); ?>" target="_blank" class="button button-light">
					<?php esc_html_e( 'The Hub', 'wpmudev' ); ?>
				</a>
				<?php if ( ! defined( 'WPMUDEV_APIKEY' ) || WPMUDEV_APIKEY ) : ?>
				<a href="<?php echo esc_url( $url_logout ); ?>" class="button button-light">
					<?php esc_html_e( 'Logout', 'wpmudev' ); ?>
				</a>
				<?php endif; ?>
			</div>
			<h1>
				<?php
				// @codingStandardsIgnoreStart: Title contains HTML, no escaping!
				echo $page_title;
				// @codingStandardsIgnoreEnd
				?>
			</h1>
		</section>
		<dialog id="reload" title="<?php esc_attr_e( 'Almost there!', 'wpmudev' ); ?>" class="small no-close">
		<center>
			<p><span class="loading"></span></p>
			<p><?php _e( 'Hold on a moment while we finish that action and refresh the page...', 'wpmudev' ); ?></p>
			<p>&nbsp;</p>
		</center>
		<span class="the-hero"><i class="dev-icon dev-icon-devman"></i></span>
		</dialog>
		<?php

		$data = array();
		if ( ! isset( $_GET['wpmudev_msg'] ) ) {
			$err = isset( $_GET['failed'] ) ? intval( $_GET['failed'] ) : false;
			$ok = isset( $_GET['success'] ) ? intval( $_GET['success'] ) : false;

			if ( $ok && $ok >= time() ) {
				$data[] = 'WDP.showSuccess()';
			} elseif ( $err && $err >= time() ) {
				$data[] = 'WDP.showError()';
			}
		}

		WDEV_Plugin_Ui::output( $data );

		/**
		 * Custom hook to display own notifications inside Dashboard.
		 */
		do_action( 'wpmudev_dashboard_notice' );
	}

	/**
	 * Display the modal overlay that tells the user to upgrade his membership.
	 *
	 * @since  4.0.0
	 * @param  string $reason The reason why the user needs to upgrade.
	 * @param  string $auto_show If the popup should be displayed on page load.
	 */
	protected function render_upgrade_box( $reason, $auto_show = true ) {
		$is_logged_in = WPMUDEV_Dashboard::$api->has_key();
		$urls = $this->page_urls;
		$user = wp_get_current_user();

		$username = $user->user_firstname;
		if ( empty( $username ) ) {
			$username = $user->display_name;
		}
		if ( empty( $username ) ) {
			$username = $user->user_login;
		}

		$this->load_template(
			'popup-no-access',
			compact( 'is_logged_in', 'urls', 'username', 'reason', 'auto_show' )
		);
	}

	/**
	 * Renders the "card" that displays a single project in the Plugins/Themes
	 * page.
	 *
	 * @since  4.0.0
	 * @param  int    $pid The project-ID.
	 * @param  array  $other_pids Additional projects to include in response.
	 * @param  string $message Additional template to parse and return (ajax).
	 */
	public function render_project( $pid, $other_pids = false, $message = false, $withmenu = false ) {
		$as_json = defined( 'DOING_AJAX' ) && DOING_AJAX;
		if ( $as_json ) { ob_start(); }

		$this->load_template(
			'element-project-info',
			compact( 'pid' )
		);

		if ( $as_json ) {
			$code = ob_get_clean();
			$data = array( 'html' => $code );

			// Optionally include other projets in AJAX response.
			if ( $other_pids && is_array( $other_pids ) ) {
				$data['other'] = array();
				foreach ( $other_pids as $pid2 ) {
					ob_start();
					$this->load_template(
						'element-project-info',
						array( 'pid' => $pid2 )
					);
					$code = ob_get_clean();
					$data['other'][ $pid2 ] = $code;
				}
			}

			if ( $message ) {
				ob_start();
				$this->load_template( $message, compact( 'pid' ) );
				$code = ob_get_clean();
				$data['overlay'] = $code;
			}

			if ( $withmenu ) {
				// Get the current wp-admin menu HTML code.
				$data['admin_menu'] = $this->get_admin_menu();
			}

			wp_send_json_success( $data );
		}
	}

	/**
	 * If a certain URL param is defined we will abort the request now.
	 *
	 * Handles the admin hook `in_admin_header`
	 * This hook is called after init and admin_init.
	 *
	 * @since  1.0.0
	 */
	public function maybe_return_menu() {
		if ( ! isset( $_GET['fetch_menu'] ) ) { return; }
		if ( 1 != $_GET['fetch_menu'] ) { return; }

		while ( ob_get_level() ) {
			ob_end_flush();
		}
		flush();
		wp_die();
	}

	/**
	 * Fetches the admin-menu of the current user via remote get.
	 *
	 * @since  1.0.0
	 * @return string The menu HTML.
	 */
	protected function get_admin_menu() {
		if ( isset( $_GET['fetch_menu'] ) && 1 == $_GET['fetch_menu'] ) {
			// Avoid recursion...
			return '';
		}

		$url = false;
		$cookies = array();
		$menu = '';

		$url = add_query_arg(
			array( 'fetch_menu' => 1 ),
			wp_get_referer()
		);

		foreach ( $_COOKIE as $name => $value ) {
			$cookies[] = new WP_Http_Cookie( array( 'name' => $name, 'value' => $value ) );
		}

		$request = wp_remote_get(
			$url,
			array( 'timeout' => 4, 'cookies' => $cookies )
		);
		$body = wp_remote_retrieve_body( $request );
		$menu = substr( $body, strpos( $body, '<div id="wpwrap">' ) + 17 );
		$menu = '<div>' . trim( $menu ) . '</div>';

		return $menu;
	}

	/**
	 * Outputs the contents of a dashboard-popup (i.e. a <dialog> element)
	 * The function does not return any value but directly output the popup
	 * HTML code.
	 *
	 * This function is used by the ajax handler for `wdp-show-popup`
	 *
	 * @since  4.0.0
	 * @param  string $type The type (i.e. contents) of the popup.
	 * @param  int    $pid Project-ID.
	 */
	public function show_popup( $type, $pid = 0 ) {
		$as_json = defined( 'DOING_AJAX' ) && DOING_AJAX;
		if ( $as_json ) { ob_start(); }

		switch ( $type ) {
			// Project-Info/overview.
			case 'info':
				$this->load_template(
					'popup-project-info',
					compact( 'pid' )
				);
				break;

			// Update information.
			case 'update':
				$this->load_template(
					'popup-update-info',
					compact( 'pid' )
				);
				break;

			// Show the changelog.
			case 'changelog':
				$this->load_template(
					'popup-project-changelog',
					compact( 'pid' )
				);
				break;
		}

		if ( $as_json ) {
			$code = ob_get_clean();
			wp_send_json_success( array( 'html' => $code ) );
		}
	}

	/**
	 * Output the changelog for the specified project.
	 * This changelog is not the one displayed in the WPMUDEV Dashboard, but
	 * inside the WP core pages (update-core.php, themes.php, plugins.php)
	 *
	 * @since  4.0.5
	 * @param  int $pid The project ID.
	 */
	public function wp_popup_changelog( $pid ) {
		$this->load_template(
			'popup-wordpress-changelog',
			compact( 'pid' )
		);

		exit;
	}


	/*
	 * *********************************************************************** *
	 * *     INTERNAL HELPER FUNCTIONS
	 * *********************************************************************** *
	 */


	/**
	 * Redirect to the specified URL, even after page output already started.
	 *
	 * @since  4.0.0
	 * @param  string $url The URL.
	 */
	public function redirect_to( $url ) {
		if ( headers_sent() ) {
			printf(
				'<script>window.location.href="%s";</script>',
				esc_js( $url )
			);
		} else {
			header( 'X-Redirect-From: UI redirect_to' );
			wp_safe_redirect( $url );
		}
		exit;
	}

	/**
	 * Get's a list of tags for given project type. Used for search or dropdowns.
	 *
	 * @since  1.0.0
	 * @param  string $type [plugin|theme].
	 * @return array
	 */
	public function tags_data( $type ) {
		$res = array();
		$data = WPMUDEV_Dashboard::$api->get_membership_data();

		if ( 'plugin' == $type ) {
			if ( isset( $data['plugin_tags'] ) ) {
				$tags = (array) $data['plugin_tags'];
				$res = array(
					// Important: Index 0 is "All", added automatically.
					1 => array(
						'name' => __( 'Business', 'wpmudev' ),
						'pids' => (array) $tags[32]['pids'],
					),
					2 => array(
						'name' => __( 'SEO', 'wpmudev' ),
						'pids' => (array) $tags[50]['pids'],
					),
					3 => array(
						'name' => __( 'Marketing', 'wpmudev' ),
						'pids' => (array) $tags[498]['pids'],
					),
					4 => array(
						'name' => __( 'Publishing', 'wpmudev' ),
						'pids' => (array) $tags[31]['pids'],
					),
					5 => array(
						'name' => __( 'Community', 'wpmudev' ),
						'pids' => (array) $tags[29]['pids'],
					),
					6 => array(
						'name' => __( 'BuddyPress', 'wpmudev' ),
						'pids' => (array) $tags[489]['pids'],
					),
					7 => array(
						'name' => __( 'Multisite', 'wpmudev' ),
						'pids' => (array) $tags[16]['pids'],
					),
				);
			}
		} elseif ( 'theme' == $type ) {
			if ( isset( $data['theme_tags'] ) ) {
				$res = (array) $data['theme_tags'];
			}
		}

		return $res;
	}

	/**
	 * Returns a base64 encoded SVG image that is used as Dashboard menu icon.
	 *
	 * Source image is file includes/images/logo.svg
	 * The source file is included with the plugin but not used.
	 *
	 * @since  4.0.0
	 * @return string Base64 encoded icon.
	 */
	protected function get_menu_icon() {
		ob_start();
		echo '<?xml version="1.0" encoding="UTF-8" standalone="no"?>';
		?><svg width="24px" height="24px" version="1.1" xmlns="http://www.w3.org/2000/svg">
		<g stroke="none" fill="#a0a5aa" fill-rule="evenodd">
			<path d="M12,0 C5.36964981,0 0,5.36964981 0,12 C0,18.6303502 5.36964981,24 12,24 C18.6303502,24 24,18.6303502 24,12 C24,5.36964981 18.6303502,0 12,0 L12,0 Z M19.5004228,4.1500001 L17.8398594,5.47845082 L17.8398594,14.3901411 C17.8398594,14.9436623 17.4523946,15.331127 17.0095777,15.331127 C16.5114087,15.331127 16.1239439,14.9436623 16.1239439,14.3901411 L16.1239439,9.62985934 C16.1239439,8.08000016 15.0169016,6.86225366 13.6330987,6.86225366 C12.2492959,6.86225366 11.1422536,8.08000016 11.1422536,9.62985934 L11.1422536,14.3901411 C11.1422536,14.9436623 10.7547888,15.331127 10.3119719,15.331127 C9.86915502,15.331127 9.48169023,14.9436623 9.48169023,14.3901411 L9.48169023,9.62985934 C9.48169023,8.08000016 8.37464795,6.86225366 6.99084511,6.86225366 C5.60704227,6.86225366 4.5,8.08000016 4.5,9.62985934 L4.5,9.62985934 L4.5,19.8700004 L6.10521129,18.5969017 L6.10521129,9.62985934 C6.10521129,9.13169032 6.49267609,8.68887341 6.99084511,8.68887341 C7.43366202,8.68887341 7.82112682,9.13169032 7.82112682,9.62985934 L7.82112682,14.3901411 C7.82112682,15.9400003 8.92816909,17.2130989 10.3119719,17.2130989 C11.6957748,17.2130989 12.802817,15.9400003 12.802817,14.3901411 L12.802817,14.3901411 L12.802817,9.62985934 C12.802817,9.13169032 13.1902818,8.68887341 13.6330987,8.68887341 C14.1312678,8.68887341 14.5187326,9.13169032 14.5187326,9.62985934 L14.5187326,14.3901411 C14.5187326,15.9400003 15.6257748,17.2130989 17.0095777,17.2130989 C18.3933805,17.2130989 19.5004228,15.9400003 19.5004228,14.3901411 L19.5004228,14.3901411 L19.5004228,4.1500001 L19.5004228,4.1500001 Z"></path>
		</g>
		</svg><?php
		$svg = ob_get_clean();
		return 'data:image/svg+xml;base64,' . base64_encode( $svg );
	}

	/**
	 * Loads the specified template.
	 *
	 * The template name should only contain the filename, without the .php
	 * extension, and without the template/ folder.
	 * If you want to pass variables to the template use the $data parameter
	 * and specify each variable as an array item. The array key will become the
	 * variable name.
	 *
	 * Using this function offers other plugins two filters to output content
	 * before or after the actual template.
	 *
	 * E.g.
	 *   load_template( 'no_access', array( 'msg' => 'test' ) );
	 *   will load the file template/no_access.php and pass it variable $msg
	 *
	 * Views:
	 *   If the REQUEST variable 'view' is set, then this function will attempt
	 *   to load the template file <name>-<view>.php with fallback to default
	 *   <name>.php if the view file does not exist.
	 *
	 * @since  4.0.0
	 * @param  string $name The template name.
	 * @param  array  $data Variables passed to the template, key => value pairs.
	 */
	protected function load_template( $name, $data = array() ) {
		if ( ! empty( $_REQUEST['view'] ) ) {
			$view = strtolower( sanitize_html_class( $_REQUEST['view'] ) );
			$file_1 = $name . '-' . $view . '.php';
			$file_2 = $name . '.php';
		} else {
			$file_1 = $name . '.php';
			$file_2 = $name . '.php';
		}

		$path_1 = WPMUDEV_Dashboard::$site->plugin_path . 'template/' . $file_1;
		$path_2 = WPMUDEV_Dashboard::$site->plugin_path . 'template/' . $file_2;

		$path = false;
		if ( file_exists( $path_1 ) ) {
			$path = $path_1;
		} elseif ( file_exists( $path_2 ) ) {
			$path = $path_2;
		}

		if ( $path ) {
			/**
			 * Output some content before the template is loaded, or modify the
			 * variables passed to the template.
			 *
			 * @var  array $data The
			 */
			$new_data = apply_filters( 'wpmudev_dashboard_before-' . $name, $data );
			if ( isset( $new_data ) && is_array( $new_data ) ) {
				$data = $new_data;
			}

			extract( $data );
			require $path;

			/**
			 * Output code or do stuff after the template was loaded.
			 */
			do_action( 'wpmudev_dashboard_after-' . $name );
		} else {
			printf(
				'<div class="error"><p>%s</p></div>',
				sprintf(
					esc_html__( 'Error: The template %s does not exist. Please re-install the plugin.', 'wpmudev' ),
					'"' . esc_html( $name ) . '"'
				)
			);
		}
	}
}
