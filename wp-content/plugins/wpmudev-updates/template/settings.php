<?php
/**
 * Dashboard template: Settings page
 *
 * Here the user can manage the settings for the current website and
 * review/change his subscription details.
 *
 * Following variables are passed into the template:
 *   $data (membership data)
 *   $member (user profile data)
 *   $urls (urls of all dashboard menu items)
 *   $membership_type (full|single|free)
 *   $allowed_users (list of all users that can see the WPUDEV Dashboard)
 *   $auto_update (bool. current value of the auto-update setting)
 *   $single_id (int. ID of the single-license project)
 *
 * @since  4.0.0
 * @package WPMUDEV_Dashboard
 */

$can_manage_users = true;
$profile = $member['profile'];

// Upgrade membership URL.
$url_membership = $urls->remote_site . 'hub/account/';
$url_api_setting = $urls->remote_site . 'hub/account/';
$url_settings = $urls->settings_url;

// Render the page header section.
$page_title = __( 'Manage', 'wpmudev' );
$this->render_header( $page_title );

// Adding users is only passible when the admin did not define a hardcoded
// user-list in wp-config.
if ( WPMUDEV_LIMIT_TO_USER ) {
	$can_manage_users = false;
}

?>
<div class="row">

<div class="col-half">
<section class="box-membership dev-box">
	<div class="box-title">
		<h3><?php esc_html_e( 'Membership', 'wpmudev' ); ?></h3>
	</div>
	<div class="box-content">
		<h4><?php esc_html_e( 'Current subscription', 'wpmudev' ); ?></h4>
		<div class="subscription-detail">
			<span class="label"><?php esc_html_e( 'Type:', 'wpmudev' ); ?></span>
			<span class="value">
				<?php
				switch ( $membership_type ) {
					case 'full':
						esc_html_e( 'Full', 'wpmudev' );
						echo '<i class="status-ok dev-icon dev-icon-radio_checked"></i>';
						break;

					case 'single':
						esc_html_e( 'Single', 'wpmudev' );
						echo '<i class="status-ok dev-icon dev-icon-radio_checked"></i>';
						break;

					default:
						esc_html_e( 'Free', 'wpmudev' );
						break;
				}
				?>
			</span>
		</div>
		<?php if ( 'single' == $membership_type ) : ?>
		<div class="subscription-detail">
			<span class="label"><?php esc_html_e( 'Active Subscription:', 'wpmudev' ); ?></span>
			<span class="value">
				<?php
				$item = WPMUDEV_Dashboard::$site->get_project_infos( $single_id );
				echo esc_html( $item->name );
				?>
			</span>
		</div>
		<?php endif; ?>
		<?php if ( 'Staff' == $profile['title'] ) : ?>
		<div class="subscription-detail">
			<span class="label"><?php esc_html_e( 'Status:', 'wpmudev' ); ?></span>
			<span class="value">
				Staff-Hero
				<span class="status-ok" tooltip="<?php echo "Your duty is no easy one:\n\nHelp members in need...\nMake stranges smile...\nFight evil...\nSave kittens!"; ?>">
					<i class="dev-icon dev-icon-logo_alt"></i>
				</span>
			</span>
		</div>
		<?php endif; ?>
		<div class="subscription-detail">
			<span class="label"><?php esc_html_e( 'Member since:', 'wpmudev' ); ?></span>
			<span class="value">
				<?php echo esc_html( date_i18n( 'F d, Y', $profile['member_since'] ) ); ?>
			</span>
		</div>
		<div class="buttons">
			<a href="<?php echo esc_url( $url_membership ); ?>" target="_blank" class="button">
				<?php esc_html_e( 'Change plan', 'wpmudev' ); ?>
			</a>
		</div>
	</div>
</section>

<section class="box-apikey dev-box">
	<div class="box-title">
		<span class="buttons">
			<a href="<?php echo esc_url( $url_api_setting ); ?>" class="button button-small button-grey" target="_blank">
				<?php esc_html_e( 'Manage global API settings', 'wpmudev' ); ?>
			</a>
		</span>
		<h3><?php esc_html_e( 'API KEY', 'wpmudev' ); ?></h3>
	</div>
	<div class="box-content">
		<p>
			<?php esc_html_e( 'This is your WPMU DEV API Key.', 'wpmudev' ); ?>
		</p>
		<input
			type="text"
			readonly="readonly"
			value="<?php echo esc_attr( strtolower( WPMUDEV_Dashboard::$api->get_key() ) ); ?>"
			class="block disabled apikey sel-all" />
	</div>
</section>
</div>

<div class="col-half">
<section class="box-settings dev-box">
	<div class="box-title">
		<h3><?php esc_html_e( 'General settings', 'wpmudev' ); ?></h3>
	</div>
	<div class="box-content">
		<p>
			<span class="toggle float-r">
				<input type="checkbox" class="toggle-checkbox" id="chk_autoupdate" name="autoupdate_dashboard" data-action="save-setting-bool" data-hash="<?php echo esc_attr( wp_create_nonce( 'save-setting-bool' ) ); ?>" <?php checked( $auto_update ); ?> />
				<label class="toggle-label" for="chk_autoupdate"></label>
			</span>
			<label class="inline-label" for="chk_autoupdate">
				<?php esc_html_e( 'Enable automatic updates for the WPMU DEV plugin', 'wpmudev' ); ?>
			</label>
		</p>
	</div>
</section>

<section class="box-permissions dev-box">
	<div class="box-title">
		<h3><?php esc_html_e( 'Permissions', 'wpmudev' ); ?></h3>
	</div>
	<div class="box-content">
		<ul class="dev-list userlist">
			<li>
			<div>
				<span class="list-label">
				<?php
				if ( $can_manage_users ) {
					esc_html_e( 'Control which administrators (manage_options enabled) can access/see the WPMU DEV Dashboard plugin and announcements. Note: ONLY these users will see announcements.', 'wpmudev' );
				} else {
					esc_html_e( 'The following admin users can access/see the WPMU DEV Dashboard plugin and announcements. Note: ONLY these users will see announcements.', 'wpmudev' );
				}
				?>
				</span>
			</div>
			</li>
			<?php foreach ( $allowed_users as $user ) : ?>
			<?php
			$remove_url = wp_nonce_url(
				add_query_arg(
					array(
						'user' => $user['id'],
						'action' => 'admin-remove',
					),
					$url_settings
				),
				'admin-remove',
				'hash'
			);
			?>
			<li class="user-<?php echo esc_attr( $user['id'] ); ?>">
			<div class="has-hover">
				<span class="list-label">
					<a href="<?php echo esc_url( $user['profile_link'] ); ?>">
						<?php echo get_avatar( $user['id'], 40 ); ?>
						<?php echo esc_html( ucwords( $user['name'] ) ); ?>
					</a>
					<?php if ( $can_manage_users && $user['is_me'] ) : ?>
					<span class="dev-label" tooltip="<?php esc_attr_e( 'You cannot remove yourself', 'wpmudev' ); ?>">
						<?php esc_html_e( 'You', 'wpmudev' ); ?>
					</span>
					<?php endif; ?>
				</span>
				<span class="list-detail">
					<?php if ( $can_manage_users && ! $user['is_me'] ) : ?>
					<a href="<?php echo esc_url( $remove_url ); ?>" class="one-click button button-text show-on-hover">
						<i class="dashicons dashicons-no-alt"></i>
					</a>
					<?php endif; ?>
				</span>
			</div>
			</li>
			<?php endforeach; ?>

			<?php if ( ! $can_manage_users ) : ?>
			<li>
			<div>
				<em class="list-label tc" style="width: 100%">
				<?php esc_html_e( 'To manage user permissions here you need to remove the constant <code>WPMUDEV_LIMIT_TO_USER</code> from your wp-config file.', 'wpmudev' ); ?>
				</em>
			</div>
			</li>
			<?php endif; ?>
		</ul>

		<?php if ( $can_manage_users ) : ?>
		<ul class="dev-list top standalone">
			<li>
			<div>
				<form method="POST" action="<?php echo esc_url( $url_settings ); ?>">
					<input type="hidden" name="action" value="admin-add" />
					<?php wp_nonce_field( 'admin-add', 'hash' ) ?>
					<span class="list-label" style="width: 100%">
						<input
							type="search"
							name="user"
							placeholder="<?php esc_attr_e( "Type an admin user's name", 'wpmudev' ); ?>"
							id="user-search"
							class="user-search"
							data-hash="<?php echo esc_attr( wp_create_nonce( 'usersearch' ) ); ?>"
							data-empty-msg="<?php esc_attr_e( 'We did not find an admin user with this name...', 'wpmudev' ); ?>" />
					</span>
					<span class="list-detail">
						<button id="user-add" type="submit" class="button one-click">
							<?php esc_html_e( 'Add', 'wpmudev' ); ?>
						</button>
					</span>
				</form>
			</div>
			</li>
		</ul>
		<?php endif; ?>
	</div>
</section>
</div>
