<?php
/**
 * Upgrader module.
 * Handles all plugin updates and installations.
 *
 * @since  4.1.0
 * @package WPMUDEV_Dashboard
 */

/**
 * The update/installation handler.
 */
class WPMUDEV_Dashboard_Upgrader {

	/**
	 * Timeout (in seconds) of the async bulk-upgrade handler.
	 * This timeout is used to re-enable bulk-upgrades if for some reason the
	 * upgrade process fails before completing all updates.
	 */
	const ASYNC_TIMEOUT = 300;

	/**
	 * Stores the last error that happened during any upgrade/install process.
	 *
	 * @var array With elements 'code' and 'message'.
	 */
	protected $error = false;

	/**
	 * Flag, if the current request is an async/background task.
	 *
	 * @var bool
	 */
	protected $is_async = false;

	/**
	 * Set up actions for the Upgrader module.
	 *
	 * @since 4.1.0
	 * @internal
	 */
	public function __construct() {
		if ( isset( $_GET['wpmudev-async'] ) && 'async' == $_GET['wpmudev-async'] ) {
			$this->is_async = true;
			ignore_user_abort( true );

			add_action(
				'init',
				array( $this, 'async_upgrade_process' )
			);
		}

		// Auto-Install scheduled updates.
		add_action(
			'admin_init',
			array( $this, 'process_auto_upgrade' )
		);

		// Apply FTP credentials to install/update plugins and themes.
		add_action(
			'plugins_loaded',
			array( $this, 'apply_credentials' )
		);
	}

	/**
	 * Checks if an installed project is the latest version or if an update
	 * is available.
	 *
	 * @since  4.0.0
	 * @param  int $project_id The project-ID.
	 * @return bool True means there is an update (local project is outdated)
	 */
	public function is_update_available( $project_id ) {
		if ( ! $this->is_project_installed( $project_id ) ) {
			return false;
		}

		$local = WPMUDEV_Dashboard::$site->get_cached_projects( $project_id );
		$local_version = $local['version'];

		$remote = WPMUDEV_Dashboard::$api->get_project_data( $project_id );
		$remote_version = $remote['version'];

		return version_compare( $local_version, $remote_version, 'lt' );
	}

	/**
	 * Checks if a certain project is localy installed.
	 *
	 * @since  4.0.0
	 * @param  int $project_id The project to check.
	 * @return bool True if the project is installed.
	 */
	public function is_project_installed( $project_id ) {
		$data = WPMUDEV_Dashboard::$site->get_cached_projects( $project_id );
		return ( ! empty( $data ));
	}

	/**
	 * Get the nonced admin url for installing a given project.
	 *
	 * @since 1.0.0
	 * @param  int $project_id The project to install.
	 * @return string|bool Generated admin url for installing the project.
	 */
	public function auto_install_url( $project_id ) {
		// Download possible?
		if ( ! WPMUDEV_Dashboard::$api->has_key() ) { return false; }

		$data = WPMUDEV_Dashboard::$api->get_membership_data();
		$project = WPMUDEV_Dashboard::$api->get_project_data( $project_id );

		// Valid project ID?
		if ( empty( $project ) ) { return false; }

		// Already installed?
		if ( $this->is_project_installed( $project_id ) ) { return false; }

		// Auto-update possible for this project?
		if ( empty( $project['autoupdate'] ) ) { return false; }
		if ( 1 != $project['autoupdate'] ) { return false; }

		// User can install the project (license and tech requirements)?
		if ( ! $this->user_can_install( $project_id ) ) { return false; }
		if ( ! $this->is_project_compatible( $project_id ) ) { return false; }

		// All good, create the download URL.
		$url = false;
		if ( 'plugin' == $project['type'] ) {
			$url = wp_nonce_url(
				self_admin_url( "update.php?action=install-plugin&plugin=wpmudev_install-$project_id" ),
				"install-plugin_wpmudev_install-$project_id"
			);
		} elseif ( 'theme' == $project['type'] ) {
			$url = wp_nonce_url(
				self_admin_url( "update.php?action=install-theme&theme=wpmudev_install-$project_id" ),
				"install-theme_wpmudev_install-$project_id"
			);
		}

		return $url;
	}

	/**
	 * Get the nonced admin url for updating a given project.
	 *
	 * @since 1.0.0
	 * @param  int $project_id The project to install.
	 * @return string|bool Generated admin url for updating the project.
	 */
	public function auto_update_url( $project_id ) {
		// Download possible?
		if ( ! WPMUDEV_Dashboard::$api->has_key() ) { return false; }

		$data = WPMUDEV_Dashboard::$api->get_membership_data();
		$project = WPMUDEV_Dashboard::$api->get_project_data( $project_id );

		// Valid project ID?
		if ( empty( $project ) ) { return false; }

		// Already installed?
		if ( ! $this->is_project_installed( $project_id ) ) { return false; }

		$local = WPMUDEV_Dashboard::$site->get_cached_projects( $project_id );
		if ( empty( $local ) ) { return false; }

		// Auto-update possible for this project?
		if ( empty( $project['autoupdate'] ) ) { return false; }
		if ( 1 != $project['autoupdate'] ) { return false; }

		// User can install the project (license and tech requirements)?
		if ( ! $this->user_can_install( $project_id ) ) { return false; }
		if ( ! $this->is_project_compatible( $project_id ) ) { return false; }

		// All good, create the update URL.
		$url = false;
		if ( 'plugin' == $project['type'] ) {
			$update_file = $local['filename'];
			$url = wp_nonce_url(
				self_admin_url( 'update.php?action=upgrade-plugin&plugin=' . $update_file ),
				'upgrade-plugin_' . $update_file
			);
		} elseif ( 'theme' == $project['type'] ) {
			$update_file = $local['slug'];
			$url = wp_nonce_url(
				self_admin_url( 'update.php?action=upgrade-theme&theme=' . $update_file ),
				'upgrade-theme_' . $update_file
			);
		}

		return $url;
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
			if ( ! WPMUDEV_Dashboard::$site->allowed_user() ) { return false; }
			//if ( ! $this->can_auto_install( $project['type'] ) ) { return false; }
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
	 * Check whether this project is compatible with the current install based
	 * on requirements from API.
	 *
	 * @since  1.0.0
	 * @param  int    $project_id The project to check.
	 * @param  string $reason If incompatible the reason is stored in this
	 *         output-parameter.
	 * @return bool True if the project is compatible with current site.
	 */
	public function is_project_compatible( $project_id, &$reason = '' ) {
		$data = WPMUDEV_Dashboard::$api->get_membership_data();
		$reason = '';

		if ( empty( $data['projects'][ $project_id ] ) ) {
			return false;
		}

		$project = $data['projects'][ $project_id ];
		if ( empty( $project['requires'] ) ) {
			$reason = 'unknown requirements';
			return false;
		}

		// Skip multisite only products if not compatible.
		if ( 'ms' == $project['requires'] && ! is_multisite() ) {
			$reason = 'multisite';
			return false;
		}

		// Skip BuddyPress only products if not active.
		if ( 'bp' == $project['requires'] && ! defined( 'BP_VERSION' ) ) {
			$reason = 'buddypress';
			return false;
		}

		return true;
	}

	/**
	 * Can plugins be automatically installed? Checks filesystem permissions
	 * and WP configuration to determine.
	 *
	 * @since  1.0.0
	 * @param  string $type Either plugin or theme.
	 * @return bool True means that projects can be downloaded automatically.
	 */
	public function can_auto_install( $type ) {
		$writable = false;

		if ( ! function_exists( 'get_filesystem_method' ) ) {
			include_once ABSPATH . '/wp-admin/includes/file.php';
		}

		// Are we dealing with direct access FS?
		if ( 'direct' == get_filesystem_method() ) {
			if ( 'plugin' == $type ) {
				$root = WP_PLUGIN_DIR;
			} else {
				$root = WP_CONTENT_DIR . '/themes';
			}

			$writable = is_writable( $root );
		}

		// If we don't have write permissions, do we have FTP settings?
		if ( ! $writable ) {
			$writable = defined( 'FTP_USER' )
				&& defined( 'FTP_PASS' )
				&& defined( 'FTP_HOST' );
		}

		// Lastly, if no other option worked, do we have SSH settings?
		if ( ! $writable ) {
			$writable = defined( 'FTP_USER' )
				&& defined( 'FTP_PUBKEY' )
				&& defined( 'FTP_PRIKEY' );
		}

		return $writable;
	}

	/**
	 * Read FTP credentials from the POST data and store them in a httponly
	 * cookie, with expiration 15 mintues.
	 *
	 * @since  1.0.0
	 * @return bool True on success.
	 */
	public function remember_credentials() {
		if ( ! isset( $_POST['ftp_user'] ) ) { return false; }
		if ( ! isset( $_POST['ftp_pass'] ) ) { return false; }
		if ( ! isset( $_POST['ftp_host'] ) ) { return false; }

		// Store user + host in DB so we have correct default values next time.
		$credentials = (array) get_option( 'ftp_credentials', array( 'hostname' => '', 'username' => '' ) );
		$credentials['hostname'] = $_POST['ftp_host'];
		$credentials['username'] = $_POST['ftp_user'];
		update_option( 'ftp_credentials', $credentials );

		// Prepare and set the httponly cookie for next 15 minutes.
		$cookie_data = array(
			urlencode( $_POST['ftp_user'] ),
			urlencode( $_POST['ftp_pass'] ),
			urlencode( $_POST['ftp_host'] ),
		);
		$expire = time() + 900; // 15minutes * 60seconds.

		return setcookie(
			COOKIEHASH . '-dev_ftp_data',
			implode( '&', $cookie_data ),
			$expire,
			COOKIEPATH,
			COOKIE_DOMAIN,
			false,
			false
		);
	}

	/**
	 * If we have a cookie with FTP credentials we will apply them here so
	 * WordPress can use them to install/update plugins.
	 *
	 * @since  1.0.0
	 */
	public function apply_credentials() {
		$cookie_name = COOKIEHASH . '-dev_ftp_data';
		if ( empty( $_COOKIE[ $cookie_name ] ) ) { return; }

		$cookie_data = explode( '&', $_COOKIE[ $cookie_name ] );
		if ( 3 != count( $cookie_data ) ) {
			// Clear invalid cookie!
			setcookie(
				$cookie_name,
				'',
				1,
				COOKIEPATH,
				COOKIE_DOMAIN,
				false,
				false
			);
			return;
		}

		// Set the const values so WP can use them.
		if ( ! defined( 'FTP_USER' ) ) {
			define( 'FTP_USER', urldecode( $cookie_data[0] ) );
		}
		if ( ! defined( 'FTP_PASS' ) ) {
			define( 'FTP_PASS', urldecode( $cookie_data[1] ) );
		}
		if ( ! defined( 'FTP_HOST' ) ) {
			define( 'FTP_HOST', urldecode( $cookie_data[2] ) );
		}
	}

	/**
	 * Enqueue specified projects to be updated and then starts an asynchronous
	 * request that will update all those projects in the background.
	 *
	 * @since  4.1.0
	 * @param  array $pid List of Project IDs or plugin-slugs.
	 */
	public function async_upgrade( $pids ) {
		$state = $this->async_upgrade_status();

		// First check if an async-upgrade is active at the moment.
		if ( $state['started'] ) {
			if ( defined( 'DOING_AJAX' ) ) {
				$err = array( 'message' => __( 'Another upgrade is processed right now...', 'wpmudev' ) );
				wp_send_json_error( $err );
			}
			return false;
		}

		if ( is_scalar( $pids ) ) {
			$pids = json_decode( $pids, true );
		}
		if ( ! is_array( $pids ) ) {
			if ( defined( 'DOING_AJAX' ) ) {
				wp_send_json_error( array( 'message' => __( 'Invalid param: pids', 'wpmudev' ) ) );
			}
			return false;
		}

		// Initiate the async-update-transient.
		$state['started'] = time(); // Transient will live for 300 seconds (5 min) from now.
		$state['current'] = '...';
		$state['queue'] = $pids;
		$this->async_upgrade_status( $state );

		// Reset an remaining cancel-flag.
		WPMUDEV_Dashboard::$site->set_transient( 'async_upgrade_cancel', null );

		// Launch the background process to process updates.
		$async_url = add_query_arg(
			array( 'action' => 'wpmudev-batch-upgrade', 'wpmudev-async' => 'async' ),
			admin_url()
		);
		$async_args = array(
			'timeout'   => 1,   // use timeout "1" - lower than 1 sec might
								// lead to a timeout before we can change the
								// ignore_user_abort() setting...
			'blocking'  => false,
			'sslverify' => apply_filters( 'https_local_ssl_verify', false ),
		);
		$res = wp_remote_post( $async_url, $async_args );

		// Report back an 'OK' to the ajax caller.
		if ( defined( 'DOING_AJAX' ) ) { wp_send_json_success(); }
		return true;
	}

	/**
	 * Clears the async-update queue, i.e. cancel the background process.
	 *
	 * @since  4.1.0
	 */
	public function async_upgrade_cancel() {
		WPMUDEV_Dashboard::$site->set_transient( 'async_upgrade', false, self::ASYNC_TIMEOUT );
		WPMUDEV_Dashboard::$site->set_transient( 'async_upgrade_cancel', true, self::ASYNC_TIMEOUT );
	}

	/**
	 * Clears the async-update queue, i.e. cancel the background process.
	 *
	 * @since  4.1.0
	 * @return array Contains at least the element 'started'.
	 */
	public function async_upgrade_status( $new_state = null ) {
		$cancel = WPMUDEV_Dashboard::$site->get_transient( 'async_upgrade_cancel' );
		if ( $cancel ) {
			WPMUDEV_Dashboard::$site->set_transient( 'async_upgrade', false, 1 );
			WPMUDEV_Dashboard::$site->set_transient( 'async_upgrade_cancel', null );
			return array( 'started' => 0 );
		}

		// Get current state from DB.
		$state = WPMUDEV_Dashboard::$site->get_transient( 'async_upgrade' );

		if ( is_object( $state ) ) { $state = (array) $state; }
		if ( ! is_array( $state ) ) { $state = array(); }
		if ( empty( $state['started'] ) ) { $state['started'] = 0; }
		if ( empty( $state['current'] ) ) { $state['current'] = ''; }
		if ( empty( $state['queue'] ) ) { $state['queue'] = array(); }

		if ( $new_state ) {
			// If requested update the state in DB with new values.
			$state = array_merge( $state, $new_state );

			/*
			 * Note: Every time this condition is triggered, the expiration of
			 *       the transient is set to 300sec from now.
			 */
			WPMUDEV_Dashboard::$site->set_transient(
				'async_upgrade',
				$state,
				self::ASYNC_TIMEOUT
			);
		}

		return $state;
	}

	/**
	 * Installs a single project update and then starts a new async process
	 * to install the next pending update (if any)
	 *
	 * @since  4.1.0
	 */
	public function async_upgrade_process() {
		$state = $this->async_upgrade_status();

		// If not started or timed-out: Stop right here.
		if ( ! $state['started'] ) { return; }

		// If nothing is enqueued then also stop here.
		if ( empty( $state['queue'] ) || ! is_array( $state['queue'] ) ) {
			$this->async_upgrade_cancel();
			return;
		}

		$prev_status = false;
		$done = array();

		// Loop through each project and update it.
		do {
			$next = array_shift( $state['queue'] );
			if ( ! $next ) { break; }

			// First update the async-state, this avoids timeouts.
			$state['current'] = $next;
			$this->async_upgrade_status( $state );

			// UPGRADE THE PLUGIN NOW!
			$res = $this->upgrade( $next );
			$done[ $next ] = $res;

			// Notify dev site about update progress.
			$count_success = count( array_filter( $done ) );
			WPMUDEV_Dashboard::$api->send_remote_upgrade_status(
				$count_success, // Updated successfully.
				count( $done ) - $count_success, // Update failed.
				count( $state['queue'] ) // Count remaining updates.
			);

			$cancel = WPMUDEV_Dashboard::$site->get_transient( 'async_upgrade_cancel' );
			if ( $cancel ) { break; }

			// Fetch data from transient again, in case it was cancelled.
			$state = $this->async_upgrade_status();
		} while ( $next );

		// No need to do anything here, just remove the async-state.
		$this->async_upgrade_cancel();

		// API call to inform wpmudev site about current version of all plugins.
		WPMUDEV_Dashboard::$site->refresh_local_projects( 'remote' );
	}

	/**
	 * Checks requirements, install-status, etc before upgrading the specific
	 * WPMU DEV project. Returns the project slug for upgrader.
	 *
	 * @since  1.0.0
	 * @param  int $pid Project ID.
	 * @return array Details about the project needed by upgrade().
	 */
	protected function prepare_dev_upgrade( $pid ) {
		$resp = array(
			'slug' => 'wpmudev_install-' . $pid,
			'filename' => '',
			'type' => '',
		);

		// Refresh local project cache before the update starts.
		WPMUDEV_Dashboard::$site->set_option( 'refresh_local_flag', true );
		$local_projects = WPMUDEV_Dashboard::$site->get_cached_projects();

		// Now make sure that the project is updated, no matter what!
		WPMUDEV_Dashboard::$api->calculate_upgrades( $local_projects, $pid );

		if ( ! $this->is_project_installed( $pid ) ) {
			$this->set_error( $pid, 'UPG.01', __( 'Project not installed', 'wdpmudev' ) );
			return false;
		}

		$project = WPMUDEV_Dashboard::$site->get_project_infos( $pid );
		$resp['type'] = $project->type;
		$resp['filename'] = $project->filename;

		// Upfront special: If updating a child theme first update parent.
		if ( $project->need_upfront ) {
			$upfront = WPMUDEV_Dashboard::$site->get_project_infos( WPMUDEV_Dashboard::$site->id_upfront );

			// Time condition to avoid repeated UF checks if there was an error.
			$check = (int) WPMUDEV_Dashboard::$site->get_option( 'last_check_upfront' );

			if ( ! $upfront->is_installed ) {
				if ( time() > $check + (3 * MINUTE_IN_SECONDS) ) {
					WPMUDEV_Dashboard::$site->set_option( 'last_check_upfront', time() );
					$this->install( $upfront->pid );
				}
			} elseif ( $upfront->version_installed != $upfront->version_latest ) {
				if ( time() > $check + (3 * MINUTE_IN_SECONDS) ) {
					WPMUDEV_Dashboard::$site->set_option( 'last_check_upfront', time() );
					$this->upgrade( $upfront->pid, false );
				}
			}
		}

		return $resp;
	}

	/**
	 * Download and install a single plugin/theme update.
	 *
	 * @since  4.0.0
	 * @param  int/string $pid The project ID or a plugin slug.
	 * @return bool True on success.
	 */
	public function upgrade( $pid ) {
		$this->clear_error();

		// Is a WPMU DEV project?
		$is_dev = (is_numeric( $pid ) );

		if ( $is_dev ) {
			$pid = (int) $pid;
			$infos = $this->prepare_dev_upgrade( $pid );
			if ( ! $infos ) { return false; }

			$filename = $infos['filename'];
			$slug = $infos['slug'];
			$type = $infos['type'];
		} elseif ( is_string( $pid ) ) {
			// No need to check if the plugin exists/is installed. WP will check it.
			list( $type, $filename ) = explode( ':', $pid );
			$slug = $filename;
		} else {
			$this->set_error( $pid, 'UPG.07', __( 'Invalid upgrade call', 'wdpmudev' ) );
			return false;
		}

		// For plugins_api..
		include_once( ABSPATH . 'wp-admin/includes/class-wp-upgrader.php' );
		include_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );
		include_once( ABSPATH . 'wp-admin/includes/file.php' );

		// Save on a bit of bandwidth.
		$api = plugins_api(
			'plugin_information',
			array(
				'slug' => $slug,
				'fields' => array( 'sections' => false ),
			)
		);

		if ( is_wp_error( $api ) ) {
			$this->set_error( $pid, 'UPG.02', __( 'No data found', 'wdpmudev' ) );
			return false;
		}

		ob_start();

		$skin = new Automatic_Upgrader_Skin();
		$result = false;
		$success = false;

		/*
		 * Set before the update:
		 * WP will refresh local cache via action-hook before the install()
		 * method is finished. That refresh call must scan the FS again.
		 */
		WPMUDEV_Dashboard::$site->before_local_files_change();

		switch ( $type ) {
			case 'plugin':
				wp_update_plugins();

				$active_blog = is_plugin_active( $filename );
				$active_network = is_multisite() && is_plugin_active_for_network( $filename );

				$upgrader = new Plugin_Upgrader( $skin );
				$result = $upgrader->upgrade( $filename );

				/*
				 * Note: The following plugin activation is an intended and
				 * needed step. During upgrade() WordPress deactivates the
				 * plugin network- and site-wide. By default the user would
				 * see a upgrade-results page with the option to activate the
				 * plugin again. We skip that screen and restore original state.
				 */
				if ( $active_blog ) {
					activate_plugin( $filename, false, false, true );
				}
				if ( $active_network ) {
					activate_plugin( $filename, false, true, true );
				}
				break;

			case 'theme':
				wp_update_themes();
				$filename = dirname( $filename );

				$upgrader = new Theme_Upgrader( $skin );
				$result = $upgrader->upgrade( $filename );
				break;

			default:
				$this->set_error( $pid, 'UPG.08', __( 'Invalid upgrade call', 'wpmudev' ) );
				return false;
		}

		// Check for errors.
		if ( is_array( $result ) && empty( $result[ $filename ] ) && is_wp_error( $skin->result ) ) {
			$result = $skin->result;
		}

		$details = ob_get_clean();

		if ( is_array( $result ) && ! empty( $result[ $filename ] ) ) {
			$plugin_update_data = current( $result );

			if ( true === $plugin_update_data ) {
				$this->set_error( $pid, 'UPG.03', implode( '<br>', $skin->get_upgrade_messages() ) );
				return false;
			}
		} elseif ( is_wp_error( $result ) ) {
			$this->set_error( $pid, 'UPG.04', $result->get_error_message() );
			return false;
		} elseif ( is_bool( $result ) && ! $result ) {
			// $upgrader->upgrade() returned false.
			// Possibly because WordPress did not find an update for the project.
			$this->set_error( $pid, 'UPG.05', __( 'Could not find update source', 'wpmudev' ) );
			return false;
		}

		if ( $is_dev ) {
			if ( ! $this->is_async ) {
				// API call to inform wpmudev site about the change.
				WPMUDEV_Dashboard::$site->refresh_local_projects( 'remote' );
			} else {
				// Only refresh the local project cache, no API call now.
				WPMUDEV_Dashboard::$site->refresh_local_projects( 'local' );
			}

			// Check if the update was successful.
			$project = WPMUDEV_Dashboard::$site->get_project_infos( $pid );

			if ( $project->version_installed != $project->version_latest ) {
				$this->set_error( $pid, 'UPG.06', __( 'Maybe wrong folder permissions', 'wpmudev' ) );
				return false;
			}
		}

		return true;
	}

	/**
	 * Install a new WPMU DEV plugin.
	 *
	 * @since  4.0.0
	 * @param  int $pid The project ID.
	 * @return bool True on success.
	 */
	public function install( $pid ) {
		$this->clear_error();

		if ( $this->is_project_installed( $pid ) ) {
			$this->set_error( $pid, 'INS.01', __( 'Already installed', 'wpmudev' ) );
			return false;
		}

		$project = WPMUDEV_Dashboard::$site->get_project_infos( $pid );

		// Make sure Upfront is available before an upfront theme is installed.
		if ( $project->need_upfront && ! WPMUDEV_Dashboard::$site->is_upfront_installed() ) {
			$this->install( WPMUDEV_Dashboard::$site->id_upfront );
		}

		// For plugins_api..
		include_once( ABSPATH . 'wp-admin/includes/class-wp-upgrader.php' );
		include_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );

		ob_start();

		// Save on a bit of bandwidth.
		$api = plugins_api(
			'plugin_information',
			array(
				'slug' => 'wpmudev_install-' . $pid,
				'fields' => array( 'sections' => false ),
			)
		);

		if ( is_wp_error( $api ) ) {
			$this->set_error( $pid, 'INS.02', __( 'No data found', 'wpmudev' ) );
			return false;
		}

		$skin = new Automatic_Upgrader_Skin();

		/*
		 * Set before the update:
		 * WP will refresh local cache via action-hook before the install()
		 * method is finished. That refresh call must scan the FS again.
		 */
		WPMUDEV_Dashboard::$site->before_local_files_change();

		switch ( $project->type ) {
			case 'plugin':
				$upgrader = new Plugin_Upgrader( $skin );
				$upgrader->install( $api->download_link );
				break;

			case 'theme':
				$upgrader = new Theme_Upgrader( $skin );
				$upgrader->install( $api->download_link );
				break;
		}

		$details = ob_get_clean();

		if ( is_wp_error( $skin->result ) ) {
			WPMUDEV_Dashboard::$site->refresh_local_projects( 'remote' );
			$this->set_error( $pid, 'INS.03', $skin->result->get_error_message() );
			return false;
		}

		// API call to inform wpmudev site about the change.
		WPMUDEV_Dashboard::$site->refresh_local_projects( 'remote' );

		// Fetch latest project details.
		$project = WPMUDEV_Dashboard::$site->get_project_infos( $pid );

		if ( ! $project->is_installed ) {
			$this->set_error( $pid, 'INS.04', __( 'Maybe wrong folder permissions', 'wpmudev' ) );
		}

		return $project->is_installed;
	}

	/**
	 * This function checks if the specified project is configured for automatic
	 * upgrade in the background (without telling the user about the upgrade).
	 *
	 * If auto-upgrade is enabled then the information is stored in a option
	 * value and the function returns true. The actual upgrade is done on next
	 * page refresh.
	 *
	 * This function will only schedule auto-updates if the setting "Enable
	 * automatic updates of WPMU DEV plugin" on the Manage page is enabled.
	 *
	 * @since  4.0.0
	 * @param  object $project Return value of get_project_infos().
	 * @return bool True means the project was scheduled for auto-upgrade.
	 */
	public function maybe_auto_upgrade( $project ) {
		$autoupdate = WPMUDEV_Dashboard::$site->get_option( 'autoupdate_dashboard' );
		if ( ! $autoupdate ) {
			// Do nothing, auto-update is disabled!
			return false;
		}

		/*
		 * List of projects that will be automatically upgraded when the above
		 * flag is enabled.
		 */
		$auto_update_projects = apply_filters(
			'wpmudev_project_auto_update_projects',
			array(
				119, // WPMUDEV dashboard.
			)
		);

		if ( in_array( $project->pid, $auto_update_projects ) ) {
			if ( ! $project->can_autoupdate ) { return false; }

			// Save the Project-ID to database.
			$scheduled = WPMUDEV_Dashboard::$site->get_option( 'autoupdate_schedule' );
			if ( ! is_array( $scheduled ) ) {
				$scheduled = array();
			}
			$scheduled[] = $project->pid;
			WPMUDEV_Dashboard::$site->set_option( 'autoupdate_schedule', $scheduled );

			return true;
		}

		return false;
	}

	/**
	 * This function is called on every admin-page load and will update any
	 * projects that were scheduled for auto-upgrade.
	 *
	 * After the upgrade the page is refreshed.
	 *
	 * @since  4.0.0
	 */
	public function process_auto_upgrade() {
		if ( $this->is_async && isset( $_GET['action'] ) && 'wpmudev-batch-upgrade' == $_GET['action'] ) {
			$this->async_upgrade_process();
			exit;
		}

		$autoupdate = WPMUDEV_Dashboard::$site->get_option( 'autoupdate_dashboard' );
		if ( ! $autoupdate ) {
			// Do nothing, auto-update is disabled!
			return;
		}

		$scheduled = WPMUDEV_Dashboard::$site->get_option( 'autoupdate_schedule' );
		if ( ! is_array( $scheduled ) || ! count( $scheduled ) ) {
			// Do nothing, no updates were scheduled!
			return;
		}

		// Time condition to avoid blocking wp-admin infinite auto-update-loop.
		// Issue should not occur anymore, but better save than sorry!
		$check = (int) WPMUDEV_Dashboard::$site->get_option( 'last_check_autoupdate' );
		if ( time() > $check + (DAY_IN_SECONDS) ) {
			// We installed auto-updates in last 3 minutes, not yet again...!
			return;
		}
		WPMUDEV_Dashboard::$site->set_option( 'last_check_autoupdate', time() );
		$all_okay = true;

		// Upgrade all projects.
		foreach ( $scheduled as $pid ) {
			// Note: We intentionally ignore the function return value here!
			$res = $this->upgrade( $pid );

			// Log the result in default PHP error log.
			if ( ! $res ) {
				$all_okay = false;
				$this->set_error( $pid, 'AUT.01', __( 'Auto-Upgrade failed', 'wpmudev' ) );
			}
		}

		/*
		 * If all updates were installed then we are good to install new updates
		 * asap. Otherwise the DAY_IN_SECONDS delay is in effect to prevent
		 * retrying a failed update too often.
		 */
		if ( $all_okay ) {
			WPMUDEV_Dashboard::$site->set_option( 'last_check_autoupdate', 0 );
		}

		// Clear the whole update schedule!
		WPMUDEV_Dashboard::$site->set_option( 'autoupdate_schedule', '' );

		$args = array(
			'wpmudev_msg' => '1',
			'success' => time(),
		);
		$url = esc_url_raw( add_query_arg( $args ) );
		header( 'X-Redirect-From: SITE process_auto_upgrade' );
		wp_safe_redirect( $url );
		exit;
	}

	/**
	 * Stores the specific error details.
	 *
	 * @since 4.1.0
	 * @param string $pid The PID that was installed/updated.
	 * @param string $code Error code.
	 * @param string $message Error message.
	 */
	public function set_error( $pid, $code, $message ) {
		$this->error = array(
			'pid' => $pid,
			'code' => $code,
			'message' => $message,
		);

		error_log(
			sprintf( 'WPMU DEV Upgrader error: %s - %s.', $code, $message )
		);
	}

	/**
	 * Clears the current error flag.
	 *
	 * @since  4.1.0
	 */
	public function clear_error() {
		$this->error = false;
	}

	/**
	 * Returns the current error details, or false if no error is set.
	 *
	 * @since  4.1.0
	 * @return false|array Either the error details or false (no error).
	 */
	public function get_error() {
		return $this->error;
	}
}
