<?php
/**
 * Dashboard popup template: No project data found
 *
 * This code will output a small dialog if a certain project was not found in
 * the DB. Most likely this means that the cached project data in DB are out of
 * date or somehow broken. Ask the user to refresh project data via our API.
 *
 * @since  4.0.5
 * @package WPMUDEV_Dashboard
 */

?>
<dialog title="<?php esc_html_e( 'Wait a moment...', 'wpmudev' ); ?>" class="small">
<div class="tc dev-error">
	<?php
	if ( WPMUDEV_Dashboard::$api->has_key() ) {
		// No project found, possibly expired data.
		$url_fix_it = wp_nonce_url(
			add_query_arg( 'action', 'check-updates', WPMUDEV_Dashboard::$ui->page_urls->dashboard_url ),
			'check-updates', 'hash'
		);

		printf(
			'<p>%s</p><p>%s</p>',
			esc_html__( 'We did not find any data for this plugin or theme...', 'wpmudev' ),
			sprintf(
				esc_html__( 'You can %sload project details from WPMU DEV%s to fix this issue.', 'wpmudev' ),
				'<a href="' . esc_url( $url_fix_it ) . '">',
				'</a>'
			)
		);
	} else {
		// No project found but user is not logged in.
		$url_fix_it = add_query_arg( 'clear_key', '1', WPMUDEV_Dashboard::$ui->page_urls->dashboard_url );

		printf(
			'<p>%s</p><p>%s</p>',
			esc_html__( 'We noticed that you are not correctly logged into the WPMUDEV Dashboard...', 'wpmudev' ),
			sprintf(
				esc_html__( 'Please %slog in again%s to fix this issue.', 'wpmudev' ),
				'<a href="' . esc_url( $url_fix_it ) . '">',
				'</a>'
			)
		);
	}
	?>
	<p><br /><br /><small>
	<?php
	$url_support = WPMUDEV_Dashboard::$ui->page_urls->remote_site . 'hub/support/';
	printf(
		wp_kses_post(
			__( 'If the above step does not solve this issue then <br>please %sget in touch with our support heroes%s to find a solution for this.', 'wpmudev' )
		),
		'<a href="' . esc_url( $url_support ) . '" target="_blank">',
		'</a>'
	);
	?>
	</small></p>
	<span class="the-hero"><i class="dev-icon dev-icon-devman"></i></span>
</div>
</dialog>
