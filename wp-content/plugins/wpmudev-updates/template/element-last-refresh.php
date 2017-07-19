<?php
/**
 * Dashboard popup template: Info on last update-check
 *
 * Will output a single line of text that displays the last update time and
 * a link to check again.
 *
 * Following variables are passed into the template:
 *   - (none)
 *
 * @since  4.0.0
 * @package WPMUDEV_Dashboard
 */

$url_check = add_query_arg( 'action', 'check-updates' );
$last_check = WPMUDEV_Dashboard::$site->get_option( 'last_run_updates' );
$last_check = WPMUDEV_Dashboard::$site->to_localtime( $last_check );

if ( $last_check ) {
	$time_format = get_option( 'time_format' );
	$day_diff = date( 'Yz', time() ) - date( 'Yz', $last_check );
	if ( $day_diff < 1 ) {
		$day_expression = __( 'today', 'wpmudev' );
	} elseif ( 1 == $day_diff ) {
		$day_expression = __( 'yesterday', 'wpmudev' );
	} else {
		$day_expression = sprintf( __( '%s days ago', 'wpmudev' ), $day_diff );
	}

	?>
	<div class="refresh-infos">
	<?php
	printf(
		esc_html( _x( 'We last checked for updates %1$s at %2$s %3$sCheck again%4$s', 'Placeholders: date, time, link-open, link-close', 'wpmudev' ) ),
		'<strong>' . esc_html( $day_expression ) . '</strong>',
		'<strong>' . esc_html( date_i18n( $time_format, $last_check ) ) . '</strong>',
		' - <a href="' . esc_url( $url_check ) . '" class="has-spinner"><i class="wdv-icon wdv-icon-refresh spin-on-click"></i> ',
		' </a>'
	);
	?>
	</div>
	<?php
} else {
	?>
	<div class="refresh-infos">
	<?php
	printf(
		esc_html( _x( 'We did not check for updates yet... %1$sCheck now%2$s', 'Placeholders: link-open, link-close', 'wpmudev' ) ),
		'<a href="' . esc_url( $url_check ) . '" class="has-spinner"><i class="wdv-icon wdv-icon-refresh spin-on-click"></i> ',
		' </a>'
	);
	?>
	</div>
	<?php
}
