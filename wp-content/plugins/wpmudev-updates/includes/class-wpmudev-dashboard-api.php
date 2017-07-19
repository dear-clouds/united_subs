<?php
/**
 * API module.
 * Handles all functions that are doing or processing remote calls.
 *
 * @since  4.0.0
 * @package WPMUDEV_Dashboard
 */

/**
 * The main API class.
 */
class WPMUDEV_Dashboard_Api {

	/**
	 * The WPMUDEV API server.
	 *
	 * @var string (URL)
	 */
	protected $server_root = 'https://premium.wpmudev.org/';

	/**
	 * Path to the REST API on the server.
	 *
	 * @var string (URL)
	 */
	protected $rest_api = 'api/dashboard/v1/';

	/**
	 * The complete WPMUDEV REST API endpoint. Defined in constructor.
	 *
	 * @var string (URL)
	 */
	protected $server_url = '';

	/**
	 * Stores the API key used for authentication.
	 *
	 * @var string
	 */
	protected $api_key = '';

	/**
	 * Holds the last API error that occured (if any)
	 *
	 * @var string
	 */
	public $api_error = '';

	/**
	 * Set up the API module.
	 *
	 * @since 4.0.0
	 * @internal
	 */
	public function __construct() {
		if ( WPMUDEV_CUSTOM_API_SERVER ) {
			$this->server_root = trailingslashit( WPMUDEV_CUSTOM_API_SERVER );
		}
		$this->server_url = $this->server_root . $this->rest_api;

		if ( defined( 'WPMUDEV_APIKEY' ) && WPMUDEV_APIKEY ) {
			$this->api_key = WPMUDEV_APIKEY;
		} else {
			// If 'clear_key' is present in URL then do not load the key from DB.
			$this->api_key = get_site_option( 'wpmudev_apikey' );
		}

		// Schedule automatic data update on the main site of the network.
		if ( is_main_site() ) {
			if ( ! wp_next_scheduled( 'wpmudev_scheduled_jobs' ) ) {
				wp_schedule_event( time(), 'twicedaily', 'wpmudev_scheduled_jobs' );
			}

			add_action(
				'wpmudev_scheduled_jobs',
				array( $this, 'refresh_membership_data' )
			);
		} elseif ( wp_next_scheduled( 'wpmudev_scheduled_jobs' ) ) {
			// In case the cron job was already installed in a sub-site...
			wp_clear_scheduled_hook( 'wpmudev_scheduled_jobs' );
		}

		/**
		 * Run custom initialization code for the API module.
		 *
		 * @since  4.0.0
		 * @var  WPMUDEV_Dashboard_Api The dashboards API module.
		 */
		do_action( 'wpmudev_dashboard_api_init', $this );
	}


	/*
	 * *********************************************************************** *
	 * *     PUBLIC INTERFACE FOR OTHER MODULES
	 * *********************************************************************** *
	 */


	/**
	 * Returns true if the API key is defined.
	 *
	 * @since  4.0.0
	 * @return bool
	 */
	public function has_key() {
		return ! empty( $this->api_key );
	}

	/**
	 * Returns the API key.
	 *
	 * @since  1.0.0
	 * @return string
	 */
	public function get_key() {
		return $this->api_key;
	}

	/**
	 * Updates the API key in the database.
	 *
	 * @since 4.0.0
	 * @param string $key The new API key to store.
	 */
	public function set_key( $key ) {
		$this->api_key = $key;
		update_site_option( 'wpmudev_apikey', $key );
	}

	/**
	 * Returns a URL we use to validate connection to server. This is not an
	 * API endpoint and does not return any defined information. Only the
	 * HTTP-Status of the GET/POST response is validated.
	 *
	 * @since  4.0.0
	 * @return string
	 */
	public function get_test_url() {
		return $this->rest_url( 'test' );
	}

	/**
	 * Returns the full URL to the specified REST API endpoint.
	 *
	 * This is a function instead of making the property $server_url public so
	 * we have better control and overview of the requested pages:
	 * It's easy to add a filter or add extra URL params to all URLs this way.
	 *
	 * @since  4.0.0
	 * @param  string $endpoint The endpoint to call on the server.
	 * @return string The full URL to the requested endpoint.
	 */
	public function rest_url( $endpoint ) {
		if ( preg_match( '!^https?://!', $endpoint ) ) {
			$url = $endpoint;
		} else {
			$url = $this->server_url . $endpoint;
		}

		return $url;
	}

	/**
	 * Returns the full URL to the specified REST API endpoint and includes
	 * the API key as last element in URL.
	 *
	 * Uses the function `rest_url()` to build the URL.
	 *
	 * @since  4.0.0
	 * @param  string $endpoint The endpoint to call on the server.
	 * @return string The full URL to the requested endpoint.
	 */
	public function rest_url_auth( $endpoint ) {
		$api_key = $this->get_key();
		if ( false === strpos( $endpoint, '/' . $api_key ) ) {
			$endpoint .= '/' . $api_key;
		}
		$url = $this->rest_url( $endpoint );

		return $url;
	}

	/**
	 * Checks if the specified URL is on our remote server.
	 *
	 * @since  4.0.0
	 * @param  string $url The full URL to evaluate.
	 * @return bool True if the URL is on our remote server.
	 */
	public function is_server_url( $url ) {
		return false !== strpos( $url, $this->server_url );
	}

	/**
	 * Makes an API call and returns the results.
	 *
	 * The remote_path can be either relative to the server_url or it can be
	 * an absolute URL to any server.
	 *
	 * If remote_path is a relative path then the API-Key is automatically
	 * added the URL.
	 *
	 * @since  4.0.0
	 * @param  str|array $remote_path The API function to call.
	 * @param  array     $data Optional. GET or POST data to send.
	 * @param  string    $method Optional. GET or POST.
	 * @param  array     $options Optional. Array of request options.
	 * @return array Results of the wp_remote_get/post call.
	 */
	public function call( $remote_path, $data = false, $method = 'GET', $options = array() ) {
		$link = $this->rest_url( $remote_path );

		$options = wp_parse_args(
			$options,
			array(
				'timeout' => 15,
				'sslverify'  => false, // Many hosts have no updated CA bundle.
				'user-agent' => 'UN Client/' . WPMUDEV_Dashboard::$version,
			)
		);

		// Solve the annoying WordPress warning: "gzinflate(): data error".
		if ( WPMUDEV_API_UNCOMPRESSED ) {
			$options['decompress'] = false;
		}

		if ( WPMUDEV_API_AUTHORIZATION ) {
			if ( ! isset( $options['headers'] ) ) {
				$options['headers'] = array();
			}
			$options['headers']['Authorization'] = WPMUDEV_API_AUTHORIZATION;
		}

		if ( 'GET' == $method ) {
			if ( ! empty( $data ) ) {
				$link = add_query_arg( $data, $link );
			}
			$response = wp_remote_get( $link, $options );
		} elseif ( 'POST' == $method ) {
			$options['body'] = $data;
			$response = wp_remote_post( $link, $options );
		}

		// Add the request-URL to the response data.
		if ( $response && is_array( $response ) ) {
			$response['request_url'] = $link;
		}

		if ( WPMUDEV_API_DEBUG ) {
			$log = '[WPMUDEV API call] %s | %s: %s (%s)';
			if ( WPMUDEV_API_DEBUG_ALL ) {
				$log .= "\nRequest options: %s\nResponse:\n%s";
			}

			$msg = sprintf(
				$log,
				WPMUDEV_Dashboard::$version,
				$method,
				$link,
				wp_remote_retrieve_response_code( $response ),
				json_encode( $options ),
				var_export( $response, true )
			);
			error_log( $msg );
		}

		return $response;
	}

	/**
	 * Makes an API call and includes the API key in the REST URL and returns
	 * the results.
	 *
	 * Uses `call()` to get the results.
	 *
	 * @since  4.0.0
	 * @param  string $remote_path The API function to call.
	 * @param  array  $data Optional. GET or POST data to send.
	 * @param  string $method Optional. GET or POST.
	 * @param  array  $options Optional. List of Request options.
	 * @return array Results of the wp_remote_get/post call.
	 */
	public function call_auth( $remote_path, $data = false, $method = 'GET', $options = array() ) {
		if ( 'GET' == $method ) {
			$remote_path = $this->rest_url_auth( $remote_path );
		} elseif ( 'POST' == $method ) {
			if ( ! is_array( $data ) ) { $data = array(); }
			$data['api_key'] = $this->get_key();
		}

		$response = $this->call( $remote_path, $data, $method, $options );
		return $response;
	}

	/**
	 * The proper way to get details about the current membership and pending
	 * updates.
	 *
	 * @since  1.0.0
	 * @return array {
	 *         Details about current membership and available updates.
	 *
	 *         @type string $downloads  [disabled|enabled]
	 *         @type array  $free_notice  Array with 'key' and 'msg'
	 *         @type array  $full_notice  Array with 'key' and 'msg'
	 *         @type array  $single_notice  Array with 'key' and 'msg'
	 *         @type int    $latest_release  A Project-ID
	 *         @type array  $latest_plugins  Array of latest 5 project-IDs
	 *         @type array  $latest_themes  Array of latest 5 project-IDs
	 *         @type string $membership  [free|single|full]
	 *         @type string $membership_full_level  [gold|bronze|silver]
	 *         @type array  $plugin_tags  List of all plugin tags with list of tagged projects
	 *         @type array  $theme_tags  List of all theme tags with list of tagged projects
	 *         @type array  $projects  Complete list of all available projects (plugins and themes)
	 *         @type string $text_admin_notice  HTML text for display
	 *         @type string $text_page_head  HTML text for display
	 * }
	 */
	public function get_membership_data() {
		$expire = time() - ( HOUR_IN_SECONDS * 12 );
		$flag = WPMUDEV_Dashboard::$site->get_option( 'refresh_remote_flag' );

		if ( $flag ) {
			WPMUDEV_Dashboard::$site->set_option( 'updates_data', false );
			$res = false;
			$last_run = 0;
		} else {
			$res = WPMUDEV_Dashboard::$site->get_option( 'updates_data' );
			$last_run = intval( WPMUDEV_Dashboard::$site->get_option( 'last_run_updates' ) );
		}

		if ( $flag || ! is_array( $res ) || ! $last_run || $expire > $last_run ) {
			// This condition prevents race condition in case of network error
			// or problems on API side.
			if ( $last_run < time() ) {
				$res = $this->refresh_membership_data();
			}
		}

		// Basic sanitation, to avoid incompatible return values.
		if ( ! is_array( $res ) ) {
			$res = array();
		}
		$res = wp_parse_args(
			$res,
			array(
				'latest_release' => 0,
				'latest_plugins' => array(),
				'latest_themes' => array(),
				'membership' => '',
				'plugin_tags' => array(),
				'theme_tags' => array(),
				'projects' => array(),
			)
		);

		return apply_filters( 'wpmudev_dashboard_get_membership_data', $res );
	}

	/**
	 * Returns a string or numeric representation of the current sites
	 * membership-status.
	 *
	 * Possible return values:
	 * 'full'   .. full membership, no restrictions.
	 * 'single' .. single membership (i.e. only 1 project is licensed)
	 * 'free'   .. free membership (i.e. expired/not signed up yet)
	 *
	 * @since  4.0.0
	 * @param  int   $project_id Output parameter. Only for a single membership
	 *         this param gets the project_id of the licensed project.
	 * @param  array $data Optional. Array of membership details to use
	 *         instead of the cached details from DB.
	 * @return string The membership type.
	 */
	public function get_membership_type( &$project_id, $data = null ) {
		$project_id = false;
		if ( ! $data || ! is_array( $data ) || ! isset( $data['membership'] ) ) {
			$data = $this->get_membership_data();
		}

		if ( 'full' == $data['membership'] ) {
			$type = 'full';
		} else {
			$member = $this->get_profile();
			if ( 'Staff' == $member['profile']['title'] ) {
				$type = 'full';
			} elseif ( is_numeric( $data['membership'] ) ) {
				$type = 'single';
				$project_id = intval( $data['membership'] );
			} else {
				$type = 'free';
			}
		}

		return $type;
	}

	/**
	 * Returns the details of a single project from the API.
	 *
	 * @since  4.0.0
	 * @param  int $project_id The project to return.
	 * @return array Project details.
	 */
	public function get_project_data( $project_id ) {
		static $AllProjects = null;
		$item = false;

		if ( null === $AllProjects ) {
			$data = $this->get_membership_data();
			if ( isset( $data['projects'] ) ) {
				$AllProjects = $data['projects'];
			}
		}

		if ( $AllProjects && isset( $AllProjects[ $project_id ] ) ) {
			$item = wp_parse_args(
				$AllProjects[ $project_id ],
				array(
					'id' => 0,
					'paid' => 'paid',
					'type' => 'plugin',
					'name' => '',
					'released' => 0,
					'updated' => 0,
					'downloads' => 0,
					'popularity' => 0,
					'short_description' => '',
					'features' => array(),
					'active' => true,
					'version' => '1.0.0',
					'autoupdate' => 1,
					'requires' => 'wp',
					'compatible' => '',
					'url' => '',
					'thumbnail' => '',
					'video' => false,
					'wp_config_url' => '',
					'ms_config_url' => '',
					'package' => 0,
					'screenshots' => array(),
				)
			);
		} else {
			if ( WPMUDEV_API_DEBUG && WPMUDEV_API_DEBUG_ALL ) {
				error_log(
					sprintf(
						'[WPMUDEV API Warning] No remote data found for project %s',
						$project_id
					)
				);
			}
		}

		return $item;
	}

	/**
	 * Returns a list of all plugins and themes on the WordPress site that have
	 * an pending update. WPMU DEV projects are not included here.
	 *
	 * @since  4.1.0
	 * @return array Array that contains 2 sub-arrays: 'plugins' and 'themes'.
	 */
	public function get_core_updates_infos() {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
		$core_updates = array(
			'plugins' => array(),
			'themes' => array(),
		);

		// Remote our custom filters, so we get the original updates list.
		remove_filter(
			'site_transient_update_plugins',
			array( WPMUDEV_Dashboard::$site, 'filter_plugin_update_count' )
		);
		remove_filter(
			'site_transient_update_themes',
			array( WPMUDEV_Dashboard::$site, 'filter_theme_update_count' )
		);

		// Get the available updates list.
		$plugin_data = get_site_transient( 'update_plugins' );
		$theme_data = get_site_transient( 'update_themes' );

		// Restore our filters to include WPMU DEV projects in the updates list.
		add_filter(
			'site_transient_update_plugins',
			array( WPMUDEV_Dashboard::$site, 'filter_plugin_update_count' )
		);
		add_filter(
			'site_transient_update_themes',
			array( WPMUDEV_Dashboard::$site, 'filter_theme_update_count' )
		);

		// Extract and collect details we need.
		if ( isset( $plugin_data->response ) ) {
			foreach ( $plugin_data->response as $slug => $infos ) {
				$item = get_plugin_data( WP_PLUGIN_DIR . '/' . $infos->plugin );
				$core_updates['plugins'][ $slug ] = array(
					'name' => $item['Name'],
					'version' => $item['Version'],
					'new_version' => $infos->new_version,
				);
			}
		}

		if ( isset( $theme_data->response ) ) {
			foreach ( $theme_data->response as $slug => $infos ) {
				$item = wp_get_theme( $slug );
				$core_updates['themes'][ $slug ] = array(
					'name' => $item->Name,
					'version' => $item->Version,
					'new_version' => $infos['new_version'],
				);
			}
		}

		return $core_updates;
	}

	/**
	 * The proper way to get the array of profile data from cache/Api.
	 *
	 * @since  1.0.0
	 * @return array
	 */
	public function get_profile() {
		$expire = time() - ( MINUTE_IN_SECONDS * 10 );
		$flag = WPMUDEV_Dashboard::$site->get_option( 'refresh_profile_flag' );

		if ( $flag ) {
			WPMUDEV_Dashboard::$site->set_option( 'profile_data', false );
			$res = false;
			$last_run = 0;
		} else {
			$res = WPMUDEV_Dashboard::$site->get_option( 'profile_data' );
			$last_run = intval( WPMUDEV_Dashboard::$site->get_option( 'last_run_profile' ) );
		}

		if ( $flag || ! $res || ! $last_run || $expire > $last_run ) {
			// This condition prevents race condition in case of network error
			// or problems on API side.
			if ( $last_run < time() ) {
				$res = $this->refresh_profile();
			}
		}

		// Basic sanitation, to avoid incompatible return values.
		if ( ! is_array( $res ) ) { $res = array(); }
		if ( empty( $res['profile'] ) || ! is_array( $res['profile'] ) ) { $res['profile'] = array(); }
		if ( empty( $res['points'] ) || ! is_array( $res['points'] ) ) { $res['points'] = array(); }
		if ( empty( $res['forum'] ) ) { $res['forum'] = array(); }
		if ( empty( $res['forum']['support_threads'] ) ) { $res['forum']['support_threads'] = array(); }

		$res['profile'] = wp_parse_args(
			$res['profile'],
			array(
				'avatar' => '',
				'member_since' => time(),
				'name' => '[name]',
				'title' => '[title]',
				'user_name' => '[username]',
			)
		);
		$res['points'] = wp_parse_args(
			$res['points'],
			array(
				'hero_points' => 0,
				'history' => array(),
				'rank' => 0,
				'rep_points' => 0,
			)
		);

		return $res;
	}

	/**
	 * The proper way to get a projects changelog from cache/Api.
	 * The changelog is stored in transients with expire date of 7 days.
	 *
	 * @since  4.0.0
	 * @param  int    $pid The Project ID.
	 * @param  string $last_version Optional. The last version that must appear
	 *         in the changelog; used to refresh cached changelog data before
	 *         the cache expires.
	 * @return array
	 */
	public function get_changelog( $pid, $last_version = false ) {
		$res = WPMUDEV_Dashboard::$site->get_transient( 'changelog_' . $pid );

		if ( $last_version && is_array( $res ) && ! empty( $res[0] ) ) {
			$retry_stamp = time() - MINUTE_IN_SECONDS;

			if ( empty( $res['timestamp'] ) ) {
				$res = false;
			} elseif ( ! empty( $res['timestamp'] ) && $res['timestamp'] <= $retry_stamp ) {
				// Check if version in cache is less then the latest version.
				if ( version_compare( $res[0]['version'], $last_version, 'lt' ) ) {
					$res = false; // Cache is outdated and needs to be refreshed.
				}
			}
		}

		if ( empty( $res ) || ! is_array( $res ) ) {
			$res = $this->refresh_changelog( $pid );
		}

		// Basic sanitation, to avoid incompatible return values.
		if ( ! is_array( $res ) ) { $res = array(); }

		return $res;
	}


	/*
	 * *********************************************************************** *
	 * *     FETCH AND REFRESH DATA FROM API
	 * *********************************************************************** *
	 */


	/**
	 * Contacts the API to send current status of an async/batch upgrade process.
	 * Values completed and failed are total values of current batch-upgrade
	 * process.
	 *
	 * @since  4.1.0
	 * @param  int  $completed Number of successfully completed updates.
	 * @param  int  $failed Number of failed updates.
	 * @param  int  $remaining Number of remaining updates in batch.
	 * @return bool Result of API call (true means no error happened)
	 */
	public function send_remote_upgrade_status( $completed, $failed, $remaining ) {
		$res = false;

		$response = WPMUDEV_Dashboard::$api->call_auth(
			'upgrade-status',
			array(
				'domain' => network_site_url(),
				'completed' => $completed,
				'failed' => $failed,
				'remaining' => $remaining,
			),
			'POST'
		);

		if ( 200 == wp_remote_retrieve_response_code( $response ) ) {
			$res = true;
		} else {
			$this->parse_api_error( $response );
		}

		return $res;
	}

	/**
	 * Contacts the API to get the latest API updates data.
	 *
	 * Returns the available update details if things are working out.
	 * In case the API call fails the function returns boolean false and does
	 * not update the update
	 *
	 * @since  1.0.0
	 * @internal Function only is public because it's an action handler.
	 * @param  bool|array $local_projects Optional array of local projects.
	 * @return array|bool
	 */
	public function refresh_membership_data( $local_projects = false ) {
		global $wp_version;
		$res = false;

		/*
		Note: This endpoint does not require an API key.
		 */

		if ( defined( 'WP_INSTALLING' ) ) { return false; }

		// Clear the "Force data update" flag to avoid infinite loop.
		WPMUDEV_Dashboard::$site->set_option( 'refresh_remote_flag', 0 );

		if ( ! is_array( $local_projects ) ) {
			$local_projects = WPMUDEV_Dashboard::$site->get_cached_projects();
		}

		if ( ! function_exists( 'is_plugin_active' ) ) {
			include_once ABSPATH . 'wp-admin/includes/plugin.php' ;
		}

		$blog_projects = array();

		/*
		Disabled, implementation not finished because of low priority.

		$blog_projects = WPMUDEV_Dashboard::$site->get_option( 'blog_active_projects' );
		if ( ! is_array( $blog_projects ) ) {
			$blog_projects = array();
			WPMUDEV_Dashboard::$site->set_option( 'blog_active_projects', array() );
		}
		*/

		$projects = array();
		$theme = wp_get_theme();
		$ms_allowed = $theme->get_allowed();
		foreach ( $local_projects as $pid => $item ) {
			if ( ! empty( $blog_projects[ $pid ] ) ) {
				// This project is activated on a blog!
				$active = true;
			} else {
				if ( is_multisite() ) {
					if ( 'theme' == $item['type'] ) {
						// If the theme is available on main site it's "active".
						$slug = dirname( $item['filename'] );
						$active = ! empty( $ms_allowed[ $slug ] );
					} else {
						$active = is_plugin_active_for_network( $item['filename'] );
					}
				} else {
					if ( 'theme' == $item['type'] ) {
						$slug = dirname( $item['filename'] );
						$active = ( $theme->stylesheet == $slug || $theme->template == $slug );
					} else {
						$active = is_plugin_active( $item['filename'] );
					}
				}
			}
			$extra = '';

			/**
			 * Collect extra data from individual plugins.
			 *
			 * @since  4.0.0
			 * @api    wpmudev_api_project_extra_data-$pid
			 * @param  string $extra Default extra data is an empty string.
			 */
			$extra = apply_filters( "wpmudev_api_project_extra_data-$pid", $extra );
			$extra = apply_filters( 'wpmudev_api_project_extra_data', $extra, $pid );

			$projects[ $pid ] = array(
				'version' => $item['version'],
				'active' => $active ? true : false,
				'extra' => $extra,
			);
		}

		/**
		 * Allows modification of the plugin data that is sent to the server.
		 *
		 * @since  4.0.0
		 * @api    wpmudev_api_project_data
		 * @param  array $projects The whole array of project details.
		 */
		$projects = apply_filters( 'wpmudev_api_project_data', $projects );

		// Get WP/BP version string to help with support.
		$wp_ver = '';
		if ( is_multisite() ) {
			$wp_ver = "WordPress Multisite $wp_version";
			$blog_count = get_blog_count();
		} else {
			$wp_ver = "WordPress $wp_version";
			$blog_count = 1;
		}
		if ( defined( 'BP_VERSION' ) ) {
			$wp_ver .= ', BuddyPress ' . BP_VERSION;
		}

		// Get a list of pending WP updates of non-WPMUDEV themes/plugins.
		$core_updates = $this->get_core_updates_infos();

		$response = WPMUDEV_Dashboard::$api->call_auth(
			'updates',
			array(
				'blog_count' => $blog_count,
				'wp_version' => $wp_ver,
				'projects' => json_encode( $projects ),
				'domain' => network_site_url(),
				'admin_url' => network_admin_url(),
				'home_url' => network_home_url(),
				'core_updates' => $core_updates,
			),
			'POST'
		);

		if ( 200 == wp_remote_retrieve_response_code( $response ) ) {
			$data = $response['body'];

			if ( 'error' != $data ) {
				$data = json_decode( $data, true );

				if ( is_array( $data ) ) {
					if ( empty( $data['membership'] ) ) {
						WPMUDEV_Dashboard::$site->logout();
					}

					// Default order to display plugins is the order in the array.
					if ( isset( $data['projects'] ) ) {
						$pos = 1;
						foreach ( $data['projects'] as $id => $project ) {
							$data['projects'][ $id ]['_order'] = $pos;
							$pos += 1;
						}
					}

					// Remove projects that are not accessible for current member.
					$data = $this->strip_unavailable_projects( $data );

					WPMUDEV_Dashboard::$site->set_option( 'updates_data', $data );
					WPMUDEV_Dashboard::$site->set_option( 'last_run_updates', time() );
					$this->calculate_upgrades( $local_projects );
					$this->enqueue_notices( $data );

					$res = $data;
				} else {
					$this->parse_api_error( 'Error unserializing remote response.' );
				}
			} else {
				$this->parse_api_error( 'API returned general error.' );
				WPMUDEV_Dashboard::$site->logout();
			}
		} else {
			$this->parse_api_error( $response );
		}

		/*
		 * For network errors, set last run to 1 hour in future so it
		 * doesn't retry every single pageload (in case of server
		 * connection issues)
		 */
		WPMUDEV_Dashboard::$site->set_option(
			'last_run_updates',
			time() + HOUR_IN_SECONDS
		);

		return $res;
	}

	/**
	 * Refresh the user profile in the local cache and return it.
	 *
	 * If there is any error while loading the current profile from the API
	 * the function will return boolean false and not update the cache.
	 *
	 * @since  1.0.0
	 * @return array|bool
	 */
	public function refresh_profile() {
		$res = false;

		/*
		Note: We need a VALID API KEY to access this endpoint.
		 */

		if ( defined( 'WP_INSTALLING' ) ) { return false; }
		if ( ! $this->has_key() ) { return false; }

		WPMUDEV_Dashboard::$site->set_option( 'refresh_profile_flag', 0 );

		$response = WPMUDEV_Dashboard::$api->call_auth(
			'user-info',
			false,
			'GET'
		);

		if ( 200 == wp_remote_retrieve_response_code( $response ) ) {
			$data = $response['body'];

			if ( 'error' != $data ) {
				$data = json_decode( $data, true );

				if ( is_array( $data ) ) {
					// 3.1.2 - 2012-06-26 PaulM Convert image urls for ssl admin
					if ( is_ssl() && isset( $data['profile']['gravatar'] ) ) {
						$data['profile']['gravatar'] = str_replace(
							'http://',
							'https://',
							$data['profile']['gravatar']
						);
					}

					WPMUDEV_Dashboard::$site->set_option( 'profile_data', $data );
					WPMUDEV_Dashboard::$site->set_option( 'last_run_profile', time() );

					if ( ! empty( $data['profile']['user_name'] ) ) {
						// The only place we use this, is the login form.
						WPMUDEV_Dashboard::$site->set_option(
							'auth_user',
							$data['profile']['user_name']
						);
					}

					$res = $data;
				} else {
					$this->parse_api_error( 'Error unserializing remote response.' );
				}
			} else {
				$this->parse_api_error( 'API returned general error.' );
				WPMUDEV_Dashboard::$site->logout();
			}
		} else {
			$this->parse_api_error( $response );
		}

		/*
		 * For network errors, set last run to 1 hour in future so it
		 * doesn't retry every single pageload (in case of server
		 * connection issues)
		 */
		WPMUDEV_Dashboard::$site->set_option(
			'last_run_profile',
			time() + HOUR_IN_SECONDS
		);

		return $res;
	}

	/**
	 * Refresh a single projects changelog in the local cache and return it.
	 *
	 * If there is any error while loading the changelog from the API the
	 * function will return boolean false and not update the cache.
	 *
	 * The changlog is cached in a transient for 7 days.
	 *
	 * @since  4.0.0
	 * @param  int $pid Refresh changelog of this project-ID.
	 * @return array|bool
	 */
	public function refresh_changelog( $pid ) {
		$res = false;

		/*
		Note: This endpoint does not require an API key.
		 */

		if ( defined( 'WP_INSTALLING' ) ) { return false; }

		$response = WPMUDEV_Dashboard::$api->call(
			'changelog/' . $pid,
			false,
			'GET'
		);

		if ( wp_remote_retrieve_response_code( $response ) == 200 ) {
			$data = $response['body'];

			if ( 'error' != $data ) {
				$data = json_decode( $data, true );

				if ( is_array( $data ) ) {
					$data['timestamp'] = time();
					WPMUDEV_Dashboard::$site->set_transient(
						'changelog_' . $pid,
						$data,
						WEEK_IN_SECONDS
					);
					$res = $data;
				} else {
					$this->parse_api_error( 'Error unserializing remote response' );
				}
			} else {
				$this->parse_api_error( 'API returned error' );
				WPMUDEV_Dashboard::$site->logout();
			}
		} else {
			$this->parse_api_error( $response );
		}

		return $res;
	}

	/**
	 * Parses the API response data and enqueues the correct message for the
	 * current member.
	 *
	 * @since  4.0.0
	 * @param  array $api_response Response data from API call to parse.
	 */
	public function enqueue_notices( $api_response ) {
		if ( ! $this->has_key() ) { return false; }
		if ( ! is_array( $api_response ) ) { return false; }
		if ( empty( $api_response['membership'] ) ) { return false; }
		$membership_type = $this->get_membership_type( $dummy );

		$field = false;

		if ( 'full' == $membership_type ) {
			$field = 'full_notice';
		} elseif ( 'single' == $membership_type ) {
			$field = 'single_notice';
		} elseif ( 'free' == $membership_type ) {
			$field = 'free_notice';
		}

		if ( $field && isset( $api_response[ $field ] ) ) {
			$notice = $api_response[ $field ];

			if ( is_array( $notice ) && ! empty( $notice['time'] ) ) {
				WPMUDEV_Dashboard::$notice->enqueue(
					$notice['time'],
					$notice['msg']
				);

				return true;
			}
		}
	}

	/**
	 * Compares the list of local plugins/themes against Api data to determine
	 * available updates. Save the details to wdp_un_updates_available site
	 * option for later use.
	 *
	 * @since  1.0.0
	 * @param  array $local_projects List of local projects from the transient.
	 * @param  int   $force_update Optional. A single project ID that is marked
	 *               for update, regardless of the version-check.
	 * @return array
	 */
	public function calculate_upgrades( $local_projects, $force_update = 0 ) {
		$updates = array();

		// Check for updates.
		foreach ( $local_projects as $pid => $dummy ) {
			// Skip if the project is not installed on current site.
			$item = WPMUDEV_Dashboard::$site->get_project_infos( $pid );
			if ( ! $item || empty( $item->name ) ) { continue; }
			if ( ! $item->is_installed ) { continue; }

			if ( $pid != $force_update ) {
				if ( ! $item->has_update ) { continue; }

				// Schedule auto-upgrade if that feature is enabled.
				WPMUDEV_Dashboard::$upgrader->maybe_auto_upgrade( $item );

				/**
				 * Allows excluding certain projects from update notifications.
				 *
				 * Basically just check the ID and return true if you want to
				 * silence updates.
				 *
				 * Filter result is only used if the remote-project `autoupdate`
				 * attribute does not have value 2.
				 *
				 * @since  1.0.0
				 * @api    wpmudev_project_ignore_updates
				 * @param  bool $flag Defaults to false, return true to silence.
				 * @param  int $pid The WDP ID of the plugin/theme
				 */
				$silence = apply_filters(
					'wpmudev_project_ignore_updates',
					false,
					$pid
				);

				// Handle WP auto-upgrades.
				if ( $silence ) { continue; }
			}

			// Add to array.
			$updates[ $pid ] = array(
				'url'              => $item->url->website,
				'type'             => $item->type,
				'instructions_url' => $item->url->instructions,
				'name'             => $item->name,
				'filename'         => $item->filename,
				'thumbnail'        => $item->url->thumbnail,
				'version'          => $item->version_installed,
				'new_version'      => $item->version_latest,
				'changelog'        => $item->changelog,
				'autoupdate'       => $item->can_autoupdate ? 1 : 0,
			);
		}

		// Record results.
		WPMUDEV_Dashboard::$site->set_option( 'updates_available', $updates );

		return $updates;
	}

	/**
	 * Remove projects from the data array that are not available for the
	 * current users membership-plan.
	 *
	 * This means:
	 * - FULL members will NOT see any LITE projects.
	 * - NON-FULL members will ONLY see LITE and FREE projects.
	 *
	 * @since  4.0.0
	 * @param  array $data Response from the API.
	 * @return array Modified response from the API.
	 */
	protected function strip_unavailable_projects( $data ) {
		if ( ! is_array( $data ) ) { return $data; }
		if ( empty( $data['projects'] ) ) { return $data; }
		if ( empty( $data['membership'] ) ) { return $data; }

		$my_level = $this->get_membership_type( $single_id, $data );

		foreach ( $data['projects'] as $id => $project ) {
			if ( 'full' == $my_level ) {
				// Remove lite from the projects list.
				if ( 'lite' == $project['paid'] ) {
					unset( $data['projects'][ $id ] );
				}
			} elseif ( $id != $single_id ) {
				// Remove projects that are neither free nor lite.
				if ( 'free' != $project['paid'] && 'lite' != $project['paid'] ) {
					unset( $data['projects'][ $id ] );
				}
			}
		}

		return $data;
	}

	/**
	 * Uses usermeta cache to store gravatar validity flag,
	 * in order to tighten up outgoing requests.
	 *
	 * @since  1.0.0
	 * @return bool True if the user has a gravatar.
	 */
	public function current_user_has_dev_gravatar() {
		$res = (int) WPMUDEV_Dashboard::$site->get_usermeta( '_wdp_un_has_gravatar' );

		// If user has a confirmed gravatar we're good already.
		if ( $res ) { return true; }

		$profile = $this->get_profile();

		// Check if the user has a valid gravatar.
		$gravatar = $profile['profile']['gravatar'];
		$res = true;
		$link = false;

		// Extract clean gravatar URL.
		if ( preg_match_all( '/src=[\'"](https?:\/\/.+\.gravatar.com\/avatar\/.+?\b)/', $gravatar, $parts ) ) {
			$link = isset( $parts[1][0] ) ? $parts[1][0] : false;
		} else {
			$res = false;
		}

		// Check if the gravatar URL is valid.
		if ( $res && $link ) {
			// Construct a special, 404-fallback URL format
			// @see https://en.gravatar.com/site/implement/images/ .
			$link .= '?d=404';
			$options = array( 'sslverify' => true, 'timeout' => 5 );
			$response = WPMUDEV_Dashboard::$api->call(
				$link,
				false,
				'GET',
				$options
			);

			if ( wp_remote_retrieve_response_code( $response ) != 200 ) {
				$res = false;
			}
		} else {
			$res = false;
		}

		// Only remember the result if the user has a valid gravatar.
		if ( $res ) {
			WPMUDEV_Dashboard::$site->set_usermeta( '_wdp_un_has_gravatar', 1 );
		}

		return $res;
	}


	/*
	 * *********************************************************************** *
	 * *     REMOTE ACCESS FUNCTIONS
	 * *********************************************************************** *
	 */


	/**
	 * Download and install a plugin update.
	 *
	 * @since  4.0.0
	 * @param  array $params Mandatory POST fields that are concatenated to
	 *         create the authentication hash.
	 * @param  bool  $die_on_failure If set to false the function returns a bool.
	 * @return bool True on success.
	 */
	public function validate_hash( $params, $die_on_failure = true ) {
		if ( defined( 'WPMUDEV_IS_REMOTE' ) && ! WPMUDEV_IS_REMOTE ) {
			if ( $die_on_failure ) {
				wp_send_json_error(
					array( 'message' => 'Remote calls are disabled in wp-config.php' )
				);
			} else {
				return false;
			}
		}

		// @codingStandardsIgnoreStart: We have own validation, not using nonce!
		$_REQUEST = $_POST;
		// @codingStandardsIgnoreEnd

		foreach ( $params as $param ) {
			if ( empty( $_REQUEST[ $param ] ) ) {
				if ( $die_on_failure ) {
					wp_send_json_error(
						array( 'message' => 'Missing param: ' . $param )
					);
				} else {
					return false;
				}
			}
		}

		if ( empty( $_SERVER['HTTP_WDP_AUTH'] ) ) {
			if ( $die_on_failure ) {
				wp_send_json_error(
					array( 'message' => 'Missing authentication header' )
				);
			} else {
				return false;
			}
		}

		$hash = $_SERVER['HTTP_WDP_AUTH'];
		$apikey = $this->get_key();

		$hash_source = '';
		foreach ( $params as $param ) {
			$hash_source .= stripslashes( $_REQUEST[ $param ] );
		}

		$valid = hash_hmac( 'sha256', $hash_source, $apikey );

		$is_valid = ($valid === $hash);

		if ( ! $is_valid && $die_on_failure ) {
			wp_send_json_error(
				array( 'message' => 'Incorrect authentication' )
			);
		}

		if ( ! defined( 'WPMUDEV_IS_REMOTE' ) ) {
			define( 'WPMUDEV_IS_REMOTE', $is_valid );
		}

		return $is_valid;
	}


	/**
	 * Returns details about the remote access permission.
	 *
	 * If no param is specified the function will return a list of all access
	 * details. If a valid param is specified, the function will return a single
	 * string/value of the detail, or false if the detail-name is invalid.
	 *
	 * Details:
	 *   enabled (bool)
	 *   granted (int/timestamp)
	 *   expires (int/timestamp)
	 *   user (int/user-ID)
	 *
	 * @since  4.0.0
	 * @param  string $detail Optional. Specify the requested detail.
	 * @return object|scalar The requested detail or all details.
	 */
	public function remote_access_details( $detail = null ) {
		static $Remote_Details = null;

		if ( null === $Remote_Details ) {
			$Remote_Details = array();

			$Remote_Details['enabled'] = false;
			$Remote_Details['expires'] = 0;
			$Remote_Details['granted'] = 0;
			$Remote_Details['user'] = 0;

			$option_val = WPMUDEV_Dashboard::$site->get_option( 'remote_access' );

			if ( ! WPMUDEV_DISABLE_REMOTE_ACCESS ) {
				$access = true;
				if ( ! $option_val ) {
					$access = false;
				} elseif ( ! is_array( $option_val ) ) {
					$access = false;
				}

				if ( $access ) {
					if ( isset( $option_val['expire'] ) ) {
						$Remote_Details['expires'] = (int) $option_val['expire'];
					}
					if ( isset( $option_val['granted'] ) ) {
						$Remote_Details['granted'] = (int) $option_val['granted'];
					}
					if ( isset( $option_val['userid'] ) ) {
						$Remote_Details['user'] = (int) $option_val['userid'];
					}
				}

				if ( $Remote_Details['expires'] <= time() ) {
					$access = false;
				}

				$Remote_Details['enabled'] = $access;
			}
		}

		// Reset access details for security if remote access is disabled.
		if ( WPMUDEV_DISABLE_REMOTE_ACCESS || ! $Remote_Details['enabled'] ) {
			$Remote_Details['enabled'] = false;
			$Remote_Details['expires'] = 0;
			$Remote_Details['granted'] = 0;
			$Remote_Details['user'] = 0;
		}

		if ( empty( $detail ) ) {
			return (object) $Remote_Details;
		} elseif ( isset( $Remote_Details[ $detail ] ) ) {
			return $Remote_Details[ $detail ];
		} else {
			return false;
		}
	}

	/**
	 * Enable WPMUDEV staff remote access login.
	 *
	 * @since  1.0.0
	 * @param  string $action Optional. Can either be 'start' or 'extend'.
	 *         start .. Will grant access for 5 days from now.
	 *         extend .. Will grant access for additional 3 days to the current
	 *           expiration date. This option only works if support access is
	 *           granted already.
	 */
	public function enable_remote_access( $action = 'start' ) {
		global $current_user;

		if ( ! current_user_can( 'edit_users' ) ) { return false; }

		if ( WPMUDEV_DISABLE_REMOTE_ACCESS ) {
			return false;
		}

		$details = $this->remote_access_details();
		$time_base = time();
		$span = '+5 Days'; // By default grant 5 days from now.

		if ( $details->enabled && $details->expires > $time_base && 'extend' == $action ) {
			// When extending add 3 days to previous expire date.
			$time_base = $details->expires;
			$span = '+3 Days';
		}

		// We will always create a new access key, even if we only extend!
		$access_key = wp_generate_password( 64, true );
		$expiration = strtotime( $span, $time_base );

		$response = WPMUDEV_Dashboard::$api->call_auth(
			'grant-access',
			array(
				'domain' => network_site_url(),
				'auth_key' => $access_key,
				'auth_expire' => $expiration,
				'auth_url' => admin_url( 'admin-ajax.php?action=wdpunauth' ),
			),
			'POST'
		);

		if ( 200 != wp_remote_retrieve_response_code( $response ) || 'true' != $response['body'] ) {
			$this->parse_api_error( $response );
			return false;
		}

		// Save the access details.
		$access = array(
			'userid' => $current_user->ID,
			'key' => $access_key,
			'expire' => $expiration,
			'granted' => time(),
		);
		WPMUDEV_Dashboard::$site->set_option( 'remote_access', $access );

		return true;
	}

	/**
	 * Removes access ability for support staff.
	 *
	 * @since 1.0.0
	 */
	public function revoke_remote_access() {
		if ( ! current_user_can( 'edit_users' ) ) { return false; }

		// Do this whether or not we can update the API.
		WPMUDEV_Dashboard::$site->set_option( 'remote_access', '' );

		$response = $this->call_auth(
			'revoke-access',
			array(
				'domain' => network_site_url(),
			),
			'POST'
		);

		if ( 200 != wp_remote_retrieve_response_code( $response ) ) {
			$this->parse_api_error( $response );
			return false;
		}

		return true;
	}

	/**
	 * Listener for WPMU DEV staff remote access login.
	 *
	 * @since  1.0.0
	 * @internal Ajax handler
	 */
	public function authenticate_remote_access() {
		if ( WPMUDEV_DISABLE_REMOTE_ACCESS ) {
			wp_die( 'Error: Remote access disabled in wp-config' );
		}

		$access = WPMUDEV_Dashboard::$site->get_option( 'remote_access' );

		// @codingStandardsIgnoreStart: We have own validation, not using nonce!
		$_REQUEST = $_POST;
		// @codingStandardsIgnoreEnd

		$error = false;
		if ( ! $access ) {
			$error = 'no token';
		} elseif ( ! is_array( $access ) ) {
			$error = 'no token';
		} elseif ( empty( $_REQUEST['wdpunkey'] ) ) {
			$error = 'invalid';
		} elseif ( $_REQUEST['wdpunkey'] == $access['key'] ) {
			$error = 'invalid';
		} elseif ( (int) $access['expire'] <= current_time( 'timestamp' ) ) {
			$error = 'expired';
		}

		if ( ! $error ) {
			/* Authentication was successful, log in our support user. */

			// Force 1 hour cookie timeout.
			add_filter(
				'auth_cookie_expiration',
				create_function( '$a', 'return 3600;' )
			);

			wp_clear_auth_cookie();
			wp_set_auth_cookie( $access['userid'], false );
			wp_set_current_user( $access['userid'] );
			setcookie( 'wpmudev_is_staff', $_REQUEST['staff'], time() + 3600 );

			// Record login info.
			$access['logins'][ time() ] = $_REQUEST['staff'];
			WPMUDEV_Dashboard::$site->set_option( 'remote_access', $access );

			// Send to dashboard.
			$url = WPMUDEV_Dashboard::$ui->page_urls->support_url;
			wp_redirect( $url );
			exit;
		} else {
			// There was an error. Display the error message.
			switch ( $error ) {
				case 'no token':
					wp_die( 'The admin did not enable remote access. Please ask the user to grant access.' );

				case 'expired':
					wp_die( 'This access token has expired. Please ask the user to renew it.' );

				case 'invalid':
				default:
					wp_die( 'This is an invalid access token. Please ask the user to grant access.' );
			}
		}
	}


	/*
	 * *********************************************************************** *
	 * *     INTERNAL ACTION HANDLERS
	 * *********************************************************************** *
	 */


	/**
	 * Parses an HTTP response object (or other value) to determine an error
	 * reason. The error reason is added to the PHP error log.
	 *
	 * @since  4.0.0
	 * @param  misc $response String, WP_Error object, HTTP response array.
	 */
	protected function parse_api_error( $response ) {
		$error_code = wp_remote_retrieve_response_code( $response );
		if ( ! $error_code ) { $error_code = 500; }
		$this->api_error = '';

		if ( is_scalar( $response ) ) {
			$this->api_error = $response;
		} elseif ( is_wp_error( $response ) ) {
			$this->api_error = $response->get_error_message();
		} elseif ( is_array( $response ) && ! empty( $response['body'] ) ) {
			$data = json_decode( $response['body'], true );
			if ( is_array( $data ) && ! empty( $data['message'] ) ) {
				$this->api_error = $data['message'];
			}
		}

		$url = '(unknown URL)';
		if ( is_array( $response ) && isset( $response['request_url'] ) ) {
			$url = $response['request_url'];
		}

		if ( empty( $this->api_error ) ) {
			$this->api_error = sprintf(
				'HTTP Error: %s "%s"',
				$error_code,
				wp_remote_retrieve_response_message( $response )
			);
		}

		// Collect back-trace information for the logfile.
		$caller_dump = '';
		if ( WPMUDEV_API_DEBUG ) {
			$trace = debug_backtrace();
			$caller = array();
			$last_line = '';
			foreach ( $trace as $level => $item ) {
				if ( ! isset( $item['class'] ) ) { $item['class'] = ''; }
				if ( ! isset( $item['type'] ) ) { $item['type'] = ''; }
				if ( ! isset( $item['function'] ) ) { $item['function'] = '<function>'; }
				if ( ! isset( $item['line'] ) ) { $item['line'] = '?'; }

				if ( $level > 0 ) {
					$caller[] = $item['class'] .
						$item['type'] .
						$item['function'] .
						':' . $last_line;
				}
				$last_line = $item['line'];
			}
			$caller_dump = "\n\t# " . implode( "\n\t# ", $caller );

			if ( is_array( $response ) && isset( $response['request_url'] ) ) {
				$caller_dump = "\n\tURL: " . $response['request_url'] . $caller_dump;
			}
		}

		// Log the error to PHP error log.
		error_log(
			sprintf(
				'[WPMUDEV API Error] %s | %s (%s [%s]) %s',
				WPMUDEV_Dashboard::$version,
				$this->api_error,
				$url,
				$error_code,
				$caller_dump
			),
			0
		);

		// If error was "invalid API key" then log out the user.
		if ( 401 == $error_code ) {
			WPMUDEV_Dashboard::$site->logout();
		}
	}
}
