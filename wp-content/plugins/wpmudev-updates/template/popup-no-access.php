<?php
/**
 * Dashboard popup template: No Access!
 *
 * This popup is displayed when a user is logged in and can view the current
 * Dashboard page, but the WPMUDEV account does not allow him to use the
 * features on the current page.
 * Usually this is displayed when a member has a single license and visits the
 * Plugins or Themes page (he cannot install new plugins or themes).
 *
 * Following variables are passed into the template:
 *   $is_logged_in
 *   $urls
 *   $username
 *   $reason
 *   $auto_show
 *
 * @since  4.0.0
 * @package WPMUDEV_Dashboard
 */

$url_upgrade = $urls->remote_site . '#pricing';
$url_logout = $urls->dashboard_url . '&clear_key=1';
$url_refresh = wp_nonce_url( add_query_arg( 'action', 'check-updates' ), 'check-updates', 'hash' );
$url_devman = WPMUDEV_Dashboard::$site->plugin_url . '/image/devman.svg';

switch ( $reason ) {
	case 'free':
		$reason_text = __( "%s, to get access to all of our premium plugins and themes, as well as 24/7 support you'll need an <strong>active membership</strong>. It's easy to do and only takes a few minutes!", 'wpmudev' );
		break;

	case 'single':
		$reason_text = __( "%s, to get access to all of our premium plugins and themes, as well as 24/7 support you'll need to upgrade your membership from <strong>single</strong> to <strong>full</strong>. It's easy to do and only takes a few minutes!", 'wpmudev' );
		break;

	default:
		$reason_text = __( "%s, to get access to all of our premium plugins and themes, as well as 24/7 support you'll need to upgrade your membership. It's easy to do and only takes a few minutes!", 'wpmudev' );
		break;
}

$classes = array();
$classes[] = 'small';

if ( $auto_show ) {
	$classes[] = 'no-close';
	$classes[] = 'auto-show';
}

?>
<dialog id="upgrade" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>" title="<?php esc_html_e( 'Upgrade Membership', 'wpmudev' ); ?>">
<div class="dialog-upgrade">
	<p>
	<?php
	// @codingStandardsIgnoreStart: Reason contains HTML, no escaping!
	printf( $reason_text, esc_html( $username ) );
	// @codingStandardsIgnoreEnd
	?>
	</p>
	<ul class="listing bold">
	<li><?php esc_html_e( 'Access to 140+ Plugins & Upfront Themes', 'wpmudev' ); ?></li>
	<li><?php esc_html_e( 'Access to Security, Backups, SEO and Performance Services', 'wpmudev' ); ?></li>
	<li><?php esc_html_e( '24/7 Expert WordPress Support', 'wpmudev' ); ?></li>
	</ul>
	<p>
	<a href="<?php echo esc_url( $url_upgrade ); ?>" class="block button button-big button-cta" target="_blank">
		<?php esc_html_e( 'Upgrade Membership', 'wpmudev' ); ?>
	</a>
	</p>
	<div class="dev-man">
		<img src="<?php echo esc_url( $url_devman ); ?>" />
	</div>
	<?php if ( $auto_show && $is_logged_in ) : ?>
	<p class="below-dev-man">
		<small>
		<?php
		printf(
			esc_html__( 'You can also %srefresh data%s or %slogout%s', 'wpmudev' ),
			'<a href="' . esc_url( $url_refresh ) . '"class="has-spinner"><i class="wdv-icon wdv-icon-refresh spin-on-click"></i> ',
			'</a>',
			'<a href="' . esc_url( $url_logout ) . '">',
			'</a>'
		);
		?>
		</small>
	</p>
	<?php endif; ?>
</div>
</dialog>
