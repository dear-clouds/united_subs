<?php
/**
 * Dashboard popup template: Message to display after project was installed.
 *
 * Displays a success message.
 *
 * Following variables are passed into the template:
 *   $pid (project ID)
 *
 * @since  4.0.0
 * @package WPMUDEV_Dashboard
 */

$item = WPMUDEV_Dashboard::$site->get_project_infos( $pid, true );
$dialog_id = md5( $pid . ':' . time() );

if ( ! $item || ! is_object( $item ) ) {
	include 'popup-no-data-found.php';
	return;
}

$need_refresh = false;
if ( 'plugin' == $item->type && $item->is_active ) {
	$need_refresh = true;
}

if ( 'plugin' == $item->type ) {
	$title = __( 'Plugin installed!', 'wpmudev' );
} else {
	$title = __( 'Theme installed!', 'wpmudev' );
}

?>
<dialog title="<?php echo esc_html( $title ); ?>" class="small no-margin">

<div class="wdp-success-msg" id="<?php echo esc_attr( $dialog_id ); ?>">
<p>
<?php
printf(
	esc_html__( 'Successfully installed %s!', 'wpmudev' ),
	'<strong>' . esc_html( $item->name ) . '</strong>'
);
?>
</p>

<?php if ( 'plugin' == $item->type ) : ?>
<p><small>
<?php
esc_html_e( 'Do you want to activate the plugin now?', 'wpmudev' );
?>
<br><br></small></p>
<?php endif; ?>

<p class="buttons">
	<?php if ( 'plugin' == $item->type ) : ?>
	<a href="#activate" class="activate-plugin button button-small"><?php esc_html_e( 'Activate', 'wpmudev' ); ?></a>
	<a href="#close" class="close button button-grey button-small"><?php esc_html_e( 'Continue installing plugins', 'wpmudev' ); ?></a>
	<?php else : ?>
	<a href="#close" class="close button button-small"><?php esc_html_e( 'Okay', 'wpmudev' ); ?></a>
	<?php endif; ?>
</p>
</div>

<script>
jQuery(function() {
	var dlg = jQuery("#<?php echo esc_attr( $dialog_id ); ?>").closest(".box");

	dlg.on("click", ".activate-plugin", function(ev) {
		var box = jQuery(".wpmud .project-box.project-<?php echo esc_attr( $pid ); ?>");
		ev.preventDefault();

		dlg.loading(true, "<?php esc_attr_e( 'We\'re activating the plugin...', 'wpmudev' ); ?>");
		box.find("[data-action=project-activate]").trigger("click");

		return false;
	});
});
</script>
</dialog>
