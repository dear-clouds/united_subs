<?php
/**
 * Dashboard popup template: Message to display after project installation failed.
 *
 * Displays a error message.
 *
 * Following variables are passed into the template:
 *   $pid (project ID)
 *
 * @since  4.0.7
 * @package WPMUDEV_Dashboard
 */

$item = WPMUDEV_Dashboard::$site->get_project_infos( $pid, true );

if ( ! $item || ! is_object( $item ) ) {
	include 'popup-no-data-found.php';
	return;
}

$title = __( 'Installation failed!', 'wpmudev' );

?>
<dialog title="<?php echo esc_html( $title ); ?>" class="small no-margin">

<div class="wdp-error-msg">
<?php
printf(
	esc_html__( 'Installation of %s failed. Most likely reason for this are wrong folder permissions of your wp-contents folder.', 'wpmudev' ),
	'<strong>' . esc_html( $item->name ) . '</strong>'
);
?>

<p class="buttons">
	<a href="#close" class="close button button-small"><?php esc_html_e( 'Okay', 'wpmudev' ); ?></a>
</p>
</div>

</dialog>
