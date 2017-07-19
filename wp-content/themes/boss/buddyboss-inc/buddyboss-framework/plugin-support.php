<?php

/**
 * Supported Plugin List
 */
function boss_install_plugin_manage_hook() {
	if ( current_user_can( 'install_plugins' ) ) {
		add_action( 'wp_ajax_boss_plugin_manage', 'boss_manage_plugin' );
	}
}

add_action( 'admin_init', 'boss_install_plugin_manage_hook' );

/**
 * Plugins Page Content
 */
global $boss_support_plugins;

$boss_support_plugins = array(
	'buddypress'							 => array(
		'title'				 => 'BuddyPress',
		'plugin_path'		 => 'buddypress/bp-loader.php',
		'plugin_link'		 => '//wordpress.org/plugins/buddypress/',
		'is_paid_product'	 => false,
		'product_link'		 => false,
	),
	'bbpress'								 => array(
		'title'				 => 'bbPress',
		'plugin_path'		 => 'bbpress/bbpress.php',
		'plugin_link'		 => '//wordpress.org/plugins/bbpress/',
		'is_paid_product'	 => false,
		'product_link'		 => false,
	),
	'buddyboss-wall'						 => array(
		'title'				 => 'BuddyBoss Wall',
		'plugin_path'		 => 'buddyboss-wall/buddyboss-wall.php',
		'plugin_link'		 => '//www.buddyboss.com/product/buddyboss-wall/',
		'is_paid_product'	 => true,
		'product_link'		 => '//www.buddyboss.com/product/buddyboss-wall/',
	),
	'buddyboss-media'						 => array(
		'title'				 => 'BuddyBoss Media',
		'plugin_path'		 => 'buddyboss-media/buddyboss-media.php',
		'plugin_link'		 => '//www.buddyboss.com/product/buddyboss-media/',
		'is_paid_product'	 => true,
		'product_link'		 => '//www.buddyboss.com/product/buddyboss-media/',
	),
	'buddypress-global-search'				 => array(
		'title'				 => 'BuddyPress Global Search',
		'plugin_path'		 => 'buddypress-global-search/buddypress-global-search.php',
		'plugin_link'		 => '//wordpress.org/plugins/buddypress-global-search/',
		'is_paid_product'	 => false,
		'product_link'		 => false,
	),
	'buddypress-docs'						 => array(
		'title'				 => 'BuddyPress Docs',
		'plugin_path'		 => 'buddypress-docs/loader.php',
		'plugin_link'		 => '//wordpress.org/plugins/buddypress-docs/',
		'is_paid_product'	 => false,
		'product_link'		 => false,
	),
	'buddypress-edit-activity'				 => array(
		'title'				 => 'BuddyPress Edit Activity',
		'plugin_path'		 => 'buddypress-edit-activity/buddypress-edit-activity.php',
		'plugin_link'		 => '//wordpress.org/plugins/buddypress-edit-activity/',
		'is_paid_product'	 => false,
		'product_link'		 => false,
	),
	'buddypress-xprofile-custom-fields-type' => array(
		'title'				 => 'BuddyPress Xprofile Custom Fields Type',
		'plugin_path'		 => 'buddypress-xprofile-custom-fields-type/bp-xprofile-custom-fields-type.php',
		'plugin_link'		 => '//wordpress.org/plugins/buddypress-xprofile-custom-fields-type/',
		'is_paid_product'	 => false,
		'product_link'		 => false,
	),
	'regenerate-thumbnails'					 => array(
		'title'				 => 'Regenerate Thumbnails',
		'plugin_path'		 => 'regenerate-thumbnails/regenerate-thumbnails.php',
		'plugin_link'		 => '//wordpress.org/plugins/regenerate-thumbnails/',
		'is_paid_product'	 => false,
		'product_link'		 => false,
	),
	'buddypress-groups-extras'				 => array(
		'title'				 => 'BuddyPress Groups Extras',
		'plugin_path'		 => 'buddypress-groups-extras/bpge.php',
		'plugin_link'		 => '//wordpress.org/plugins/buddypress-groups-extras/',
		'is_paid_product'	 => false,
		'product_link'		 => false,
	),
	'gd-bbpress-attachments'				 => array(
		'title'				 => 'GD bbPress Attachments',
		'plugin_path'		 => 'gd-bbpress-attachments/gd-bbpress-attachments.php',
		'plugin_link'		 => '//wordpress.org/plugins/gd-bbpress-attachments/',
		'is_paid_product'	 => false,
		'product_link'		 => false,
	),
	'invite-anyone'							 => array(
		'title'				 => 'Invite Anyone',
		'plugin_path'		 => 'invite-anyone/invite-anyone.php',
		'plugin_link'		 => '//wordpress.org/plugins/invite-anyone/',
		'is_paid_product'	 => false,
		'product_link'		 => false,
	),
	'subscribe-to-comments'					 => array(
		'title'				 => 'Subscribe to Comments',
		'plugin_path'		 => 'subscribe-to-comments/subscribe-to-comments.php',
		'plugin_link'		 => '//wordpress.org/plugins/subscribe-to-comments/',
		'is_paid_product'	 => false,
		'product_link'		 => false,
	),
	'woocommerce'							 => array(
		'title'				 => 'WooCommerce - excelling eCommerce',
		'plugin_path'		 => 'woocommerce/woocommerce.php',
		'plugin_link'		 => '//wordpress.org/plugins/woocommerce/',
		'is_paid_product'	 => false,
		'product_link'		 => false,
	),
	'wordpress-seo'							 => array(
		'title'				 => 'WordPress SEO by Yoast',
		'plugin_path'		 => 'wordpress-seo/wp-seo.php',
		'plugin_link'		 => '//wordpress.org/plugins/wordpress-seo/',
		'is_paid_product'	 => false,
		'product_link'		 => false,
	),
	'wordpress-social'							 => array(
		'title'				 => 'WordPress Social login',
		'plugin_path'		 => 'wordpress-social-login/wp-social-login.php',
		'plugin_link'		 => '//wordpress.org/plugins/wordpress-social-login/',
		'is_paid_product'	 => false,
		'product_link'		 => false,
	),
);

/**
 * Include class-wp-upgrader.php
 */
include_once( ABSPATH . 'wp-admin/includes/class-wp-upgrader.php' );

if ( !class_exists( 'boss_Plugin_Upgrader_Skin' ) ) {

	class boss_Plugin_Upgrader_Skin extends WP_Upgrader_Skin {

		function __construct( $args = array() ) {
			$defaults	 = array( 'type' => 'web', 'url' => '', 'plugin' => '', 'nonce' => '', 'title' => '' );
			$args		 = wp_parse_args( $args, $defaults );

			$this->type	 = $args[ 'type' ];
			$this->api	 = isset( $args[ 'api' ] ) ? $args[ 'api' ] : array();

			parent::__construct( $args );
		}

		public function request_filesystem_credentials( $error = false, $context = false,
												  $allow_relaxed_file_ownership = false ) {
			return true;
		}

		public function error( $errors ) {
			die( '-1' );
		}

		public function header() {

		}

		public function footer() {

		}

		public function feedback( $string ) {

		}

	}

}

/**
 * Get Supported Plugin List
 * @global array $boss_support_plugins
 * @return type
 */
function boss_get_supported_plugin() {
	global $boss_support_plugins;
	return apply_filters( 'boss_supported_plugin_list', $boss_support_plugins );
}

/**
 * Manage Plugins
 */
function boss_manage_plugin() {

	$boss_support_plugins = boss_get_supported_plugin();

	if ( !isset( $_POST[ 'plugin' ] ) ) {
		wp_send_json_error();
	}

	if ( !isset( $_POST[ 'plugin_action' ] ) ) {
		wp_send_json_error();
	}

	if ( isset( $_POST[ 'plugin' ] ) && !isset( $boss_support_plugins[ $_POST[ 'plugin' ] ] ) ) {
		wp_send_json_error();
	}

	$plugin = $_POST[ 'plugin' ];

	switch ( $_POST[ 'plugin_action' ] ) {
		case 'activate' :
			$return = activate_plugins( $boss_support_plugins[ $plugin ][ 'plugin_path' ] );
			if ( is_wp_error( $return ) ) {
				wp_send_json_error( array( 'success' => false, 'data' => $return->get_error_message() ) );
			} else {
				wp_send_json_success();
			}
			break;
		case 'deactivate' :
			$return = deactivate_plugins( $boss_support_plugins[ $plugin ][ 'plugin_path' ] );
			if ( is_wp_error( $return ) ) {
				wp_send_json_error( array( 'success' => false, 'data' => $return->get_error_message() ) );
			} else {
				wp_send_json_success();
			}
			break;
		case 'delete' :
			$return = delete_plugins( (array) $boss_support_plugins[ $plugin ][ 'plugin_path' ] );
			if ( is_wp_error( $return ) ) {
				wp_send_json_error( array( 'success' => false, 'data' => $return->get_error_message() ) );
			} else {
				wp_send_json_success();
			}
			break;
		case 'install' :
			include_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );

			$api = plugins_api( 'plugin_information', array( 'slug' => $plugin, 'fields' => array( 'sections' => false ) ) );

			if ( is_wp_error( $api ) ) {
				wp_send_json_error( array( 'success' => false, 'data' => sprintf( __( 'ERROR: Failed to install plugin: %s', 'boss' ), $api->get_error_message() ) ) );
			}

			$upgrader = new Plugin_Upgrader( new boss_Plugin_Upgrader_Skin( array(
				'nonce'	 => 'install-plugin_' . $plugin, 'plugin' => $plugin, 'api'	 => $api,
			) ) );

			$install_result = $upgrader->install( $api->download_link );

			if ( !$install_result || is_wp_error( $install_result ) ) {
				/* $install_result can be false if the file system isn't writable. */
				$error_message = __( 'Please ensure the file system is writable', 'boss' );

				if ( is_wp_error( $install_result ) ) {
					$error_message = $install_result->get_error_message();
				}
				wp_send_json_error( array( 'success' => false, 'data' => sprintf( __( 'ERROR: Failed to install plugin: %s', 'boss' ), $error_message ) ) );
			} else {
				wp_send_json_success();
			}
			break;
	}
	wp_send_json_error();
}

function boss_install_plugin() {
	if ( empty( $_POST[ 'plugin_slug' ] ) ) {
		die( __( 'ERROR: No slug was passed to the AJAX callback.', 'boss' ) );
	}

	check_ajax_referer( $_POST[ 'plugin_slug' ] . '-install' );

	if ( !current_user_can( 'install_plugins' ) || !current_user_can( 'activate_plugins' ) ) {
		die( __( 'ERROR: You lack permissions to install and/or activate plugins.', 'boss' ) );
	}

	include_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );

	$api = plugins_api( 'plugin_information', array( 'slug' => $_POST[ 'plugin_slug' ], 'fields' => array( 'sections' => false ) ) );

	if ( is_wp_error( $api ) ) {
		die( sprintf( __( 'ERROR: Error fetching plugin information: %s', 'boss' ), $api->get_error_message() ) );
	}

	$upgrader = new Plugin_Upgrader( new boss_Plugin_Upgrader_Skin( array(
		'nonce'	 => 'install-plugin_' . $_POST[ 'plugin_slug' ], 'plugin' => $_POST[ 'plugin_slug' ], 'api'	 => $api,
	) ) );

	$install_result = $upgrader->install( $api->download_link );

	if ( !$install_result || is_wp_error( $install_result ) ) {
		/* $install_result can be false if the file system isn't writable. */
		$error_message = __( 'Please ensure the file system is writable', 'boss' );

		if ( is_wp_error( $install_result ) ) {
			$error_message = $install_result->get_error_message();
		}

		die( sprintf( __( 'ERROR: Failed to install plugin: %s', 'boss' ), $error_message ) );
	}

	echo "true";
	die();
}

function boss_plugins_submenu_page_callback() {
	$plugins		 = get_plugins();
	$support_plugins = boss_get_supported_plugin();
	?>
	<div class="boss-manage-plugin">

		<div class="redux-notice-field redux-field-info boss-info-text">
			<p class="redux-info-desc"><?php _e( 'List of supported plugins.', 'boss' ); ?></p>
		</div>

		<table class="form-table">
			<thead>
				<tr>
					<th><?php _e( 'Plugin', 'boss' ); ?></th>
					<th><?php _e( 'Status', 'boss' ); ?></th>
					<th><?php _e( 'Action', 'boss' ); ?></th>
					<th><?php _e( 'Edit', 'boss' ); ?></th>
				</tr>
			</thead>

			<?php foreach ( $support_plugins as $plugin_key => $plugin_info ) { ?>
				<tr><?php
					if ( is_plugin_active( $plugin_info[ 'plugin_path' ] ) ) {
						$status	 = __( 'Active', 'boss' );
						$st_flag = 'active';
					} elseif ( array_key_exists( $plugin_info[ 'plugin_path' ], $plugins ) ) {
						$status	 = __( 'Inactive', 'boss' );
						$st_flag = 'inactive';
					} else {
						$status	 = __( 'Not Installed', 'boss' );
						$st_flag = 'not-installed';
					}
					?>

					<td>
						<a target="_blank" href="<?php echo $plugin_info[ 'plugin_link' ]; ?>"><?php echo $plugin_info[ 'title' ]; ?></a>
					</td>

					<td class="<?php echo str_replace( " ", "-", strtolower( $status ) ) ?>">
						<?php echo $status ?>
					</td>

					<td><?php
						$action_label	 = array();
						$action			 = array();
						$links			 = array();
						switch ( $st_flag ) {
							case 'active' :
								$action_label[]	 = __( 'Deactivate', 'boss' );
								$action []		 = 'deactivate';
								$links []		 = '#';
								break;
							case 'inactive' :
								$action_label[]	 = __( 'Activate', 'boss' );
								$action []		 = 'activate';
								$links []		 = '#';

								$action_label[]	 = __( 'Delete', 'boss' );
								$action []		 = 'delete';
								$links []		 = '#';
								break;
							default :
								if ( $plugin_info[ 'is_paid_product' ] === false || $plugin_info[ 'product_link' ] === false ) {
									$action_label[]	 = __( 'Install', 'boss' );
									$action []		 = 'install';
									$links []		 = '#';
								} else {
									$action_label[]	 = __( 'Buy Now', 'boss' );
									$action []		 = 'purchase';
									$links []		 = $plugin_info[ 'product_link' ];
								}
						}

						$sep = '';
						foreach ( $action_label as $key => $val ) {
							$taget	 = ( $action[ $key ] == 'purchase' ) ? ' target="_blank"' : '';
							echo $sep;
							?><a class="boss-manage-plugin-action <?php echo $action[ $key ]; ?>"
							   data-plugin="<?php echo esc_attr( $plugin_key ); ?>"
							   href="<?php echo $links[ $key ]; ?>"
							   data-action="<?php echo $action[ $key ]; ?>"
							   data-site-url="<?php echo get_template_directory_uri(); ?>"
							   data-plugin-title ="<?php echo $plugin_info[ 'title' ]; ?>"
							   data-nonce="<?php echo esc_attr( wp_create_nonce( $plugin_key ) ); ?>"<?php echo $taget; ?>>
								   <?php echo $action_label[ $key ]; ?>
							</a>
							<?php
							$sep	 = '/ ';
						}
						?>
					</td>

					<td><?php
						if ( $st_flag != "not-installed" ) {
							?>
							<a href="<?php echo admin_url( 'plugin-editor.php?file=' . $plugin_info[ 'plugin_path' ] ) ?>"><?php _e( 'Edit', 'boss' ); ?></a>
							<?php
						} else {
							?>
							-----
						<?php }
						?>
					</td>
				</tr><?php }
					?>
		</table>
	</div>
	<?php
}
