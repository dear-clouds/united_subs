<?php
/**
 * Dashboard popup template: Message to display after Upfront parent was installed.
 *
 * Displays a success message and refreshes the current page.
 *
 * Following variables are passed into the template:
 *   $pid (project ID)
 *
 * @since  4.0.0
 * @package WPMUDEV_Dashboard
 */

$item = WPMUDEV_Dashboard::$site->get_project_infos( $pid, true );

if ( ! $item || ! is_object( $item ) ) {
	include 'popup-no-data-found.php';
	return;
}

?>
<dialog title="<?php esc_html_e( 'Upfront installed!', 'wpmudev' ); ?>" class="small no-margin no-close">

<div class="wdp-success-msg">
<p>
<?php esc_html_e( 'Successfully installed Upfront!', 'wpmudev' ); ?>
</p>
<p>
<?php esc_html_e( 'Hang on while we reload the page for you', 'wpmudev' ); ?>
</p>
<script>window.setTimeout( function() { window.location.reload(); }, 1000 );</script>
</div>

</dialog>
