<?php
/**
 * Dashboard popup template: Update info
 *
 * Will output the contents of a Dashboard popup element with details about the
 * latest project release that we get from the remote site.
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
$dlg_id = 'dlg-' . md5( time() . '-' . $pid );

if ( $item->is_installed ) {
	$notes_intro = array();
	$notes_details = array();
	$release_date = '';
	$date_format = get_option( 'date_format' );

	foreach ( $item->changelog as $log ) {
		if ( version_compare( $log['version'], $item->version_latest, 'eq' ) ) {
			$release_date = date_i18n( $date_format, $log['time'] );
		}

		if ( version_compare( $log['version'], $item->version_installed, 'gt' ) ) {
			$log_items = explode( "\n", $log['log'] );
			$detail_level = 0;

			foreach ( $log_items as $note ) {
				if ( 0 === strpos( $note, '<p>' ) ) { $detail_level += 1; }

				$note = stripslashes( $note );
				$note = preg_replace( '/(<br ?\/?>|<p>|<\/p>)/', '', $note );
				$note = trim( preg_replace( '/^\s*(\*|\-)\s*/', '', $note ) );
				$note = str_replace( array( '<', '>' ), array( '&lt;', '&gt;' ), $note );
				$note = preg_replace( '/`(.*?)`/', '<code>\1</code>', $note );
				if ( empty( $note ) ) { continue; }

				if ( $detail_level < 2 ) {
					$notes_intro[] = $note;
				} else {
					$notes_details[] = $note;
				}
			}
		}
	}
}

if ( 'plugin' == $item->type ) {
	$title_not_installed = __( 'Plugin not installed', 'wpmudev' );
	$title_is_installed = __( 'Update Plugin', 'wpmudev' );
} else {
	$title_not_installed = __( 'Theme not installed', 'wpmudev' );
	$title_is_installed = __( 'Update Theme', 'wpmudev' );
}

if ( ! $item->is_installed ) : ?>
<dialog title="<?php echo esc_attr( $title_not_installed ); ?>" class="small">
<p class="tc">
	<?php esc_html_e( 'Something unexpected happened.', 'wpmudev' ); ?><br />
	<?php esc_html_e( 'Please wait one moment while we refresh the page...', 'wpmudev' ); ?>
</p>
<script>
	window.setTimeout(function(){ window.location.reload(); }, 2000 );
</script>
</dialog>
<?php else : ?>
<dialog title="<?php echo esc_attr( $title_is_installed ); ?>" class="small">
<div class="wdp-update <?php echo esc_attr( $dlg_id ); ?>" data-project="<?php echo esc_attr( $pid ); ?>">

<div class="title-action">
	<?php if ( $item->is_licensed ) : ?>
		<?php if ( $item->has_update && $item->url->update ) { ?>
		<a href="<?php echo esc_url( $item->url->update ); ?>" class="button button-small button-yellow btn-update-ajax">
			<?php esc_html_e( 'Update Now', 'wpmudev' ); ?>
		</a>
		<?php } elseif ( $item->has_update ) { ?>
		<a href="<?php echo esc_url( $item->url->download ); ?>" class="button button-small">
			<?php esc_html_e( 'Download Now', 'wpmudev' ); ?>
		</a>
		<?php } ?>
	<?php else : ?>
		<a href="#upgrade" class="button button-small" rel="dialog">
			<?php esc_html_e( 'Upgrade', 'wpmudev' ); ?>
		</a>
	<?php endif; ?>
</div>

<table class="update-infos" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<th class="col-1"><?php esc_html_e( 'Name', 'wpmudev' ); ?></th>
		<th class="col-2"><?php esc_html_e( 'Release Date', 'wpmudev' ); ?></th>
		<th class="col-3"><?php esc_html_e( 'Version', 'wpmudev' ); ?></th>
	</tr>
	<tr>
		<td><?php echo esc_html( $item->name ); ?></td>
		<td><?php echo esc_html( $release_date ); ?></td>
		<td>
			<span class="version">
				<?php echo esc_html( $item->version_latest ); ?>
			</span>
			&nbsp;
			<span tooltip="<?php esc_html_e( 'Show changelog', 'wpmudev' ); ?>" class="pointer tooltip-s tooltip-right">
			<i class="show-project-changelog dev-icon dev-icon-info"></i>
			</span>
		</td>
	</tr>
	<tr class="after-update" style="display:none">
		<td colspan="3">
			<div class="update-complete">
				<i class="wdv-icon wdv-icon-ok"></i>
				<?php esc_html_e( 'Update complete!', 'wpmudev' ); ?>
			</div>
		</td>
	</tr>
	<tr class="before-update">
		<th colspan="3"><?php esc_html_e( 'Notes', 'wpmudev' ); ?></th>
	</tr>
	<tr class="before-update">
		<td colspan="3" class="col-notes versions">
		<?php
		if ( ! $item->has_update ) {
			printf(
				'<p class="tc">%s</p>',
				sprintf(
					'<i class="wdv-icon wdv-icon-thumbs-up"></i> ' .
					esc_html__( 'You\'ve got the latest version of %s!', 'wpmudev' ),
					'<strong>' . esc_html( $item->name ) . '</strong>'
				)
			);
		} else {
			switch ( $item->special ) {
				case 'dropin':
					printf(
						'<p class="tc"><strong>%s</strong></p>',
						esc_html__( 'This is a Dropin, automatic updates are not possible for this. Please download and install the update manually.', 'wpmudev' )
					);
					break;

				case 'muplugin':
					printf(
						'<p class="tc"><strong>%s</strong></p>',
						esc_html__( 'This is a must-use plugin, automatic updates are not possible for this. Please download and install the update manually.', 'wpmudev' )
					);
					break;
			}
			?>
			<ul class="changes">
			<?php
			foreach ( $notes_intro as $note ) {
				printf(
					'<li class="version-intro">%s</li>',
					wp_kses_post( $note )
				);
			}
			if ( count( $notes_details ) ) {
				printf(
					'<li class="toggle-details">
					<a href="#" class="for-intro">%s</a><a href="#" class="for-detail">%s</a>
					</li>',
					esc_html__( 'Show all changes', 'wpmudev' ),
					esc_html__( 'Hide details', 'wpmudev' )
				);
				foreach ( $notes_details as $note ) {
					printf(
						'<li class="version-detail">%s</li>',
						wp_kses_post( $note )
					);
				}
			}
		}
		?>
		</ul></td>
	</tr>
</table>

<style>
.<?php echo esc_attr( $dlg_id ); ?> .versions ul.changes .for-detail,
.<?php echo esc_attr( $dlg_id ); ?> .versions ul.changes .version-detail {
	display: none;
}
.<?php echo esc_attr( $dlg_id ); ?> .versions ul.changes .for-intro {
	display: inline-block;
}
.<?php echo esc_attr( $dlg_id ); ?> .versions ul.changes.show-details .for-intro {
	display: none;
}
.<?php echo esc_attr( $dlg_id ); ?> .versions ul.changes.show-details .for-detail {
	display: inline-block;
}
.<?php echo esc_attr( $dlg_id ); ?> .versions ul.changes.show-details .version-detail {
	display: list-item;
}
.<?php echo esc_attr( $dlg_id ); ?> .versions ul.changes .toggle-details {
	padding: 8px 0 4px;
	text-align: right;
	font-size: 12px;
	list-style: none;
}
</style>
<script>
jQuery(function(){
	jQuery('.<?php echo esc_attr( $dlg_id ); ?>').on('click', '.toggle-details a', function(ev) {
		var li = jQuery(this),
			ver = li.closest('.changes');

		ev.preventDefault();
		ev.stopPropagation()
		ver.toggleClass('show-details');
		return false;
	});

	var btnUpdate = jQuery('.btn-update-ajax'),
		popup = btnUpdate.closest('.box'),
		pid = "<?php echo esc_attr( $pid ); ?>",
		box = jQuery('.project-box.project-' + pid);

	btnUpdate.on('click', updateHandler);

	function updateHandler(ev) {
		var data = {},
			res = {"scope":this, "param":ev, "func":updateHandler};

		jQuery(document).trigger('wpmu:before-update', [res]);
		if (res && res.cancel) { return false; }

		data.action = 'wdp-project-update';
		data.hash = "<?php echo esc_attr( wp_create_nonce( 'project-update' ) ); ?>";
		data.pid = pid;
		data.is_network = +(jQuery('body').hasClass('network-admin'));

		popup.loading(true, <?php echo json_encode( __( "Hang on while we're installing the update...", 'wpmudev' ) ); ?>);
		jQuery.post(
			window.ajaxurl,
			data,
			function(response) {
				WDP.closeOverlay(); // close overlay, if any is open.

				if (!response || !response.success) {
					if (response && response.data && response.data.message) {
						WDP.showError(response.data.message);
					} else {
						WDP.showError();
					}
					WDP.showError();
					return;
				}

				btnUpdate.hide();
				popup.find('.before-update').hide();
				popup.find('.after-update').show();

				// Return value is the new project box for project list.
				jQuery(document).trigger(
					'wpmu:show-project',
					[box, response.data.html]
				);

				// Update number in the counter-badges in the menu.
				jQuery(document).trigger( 'wpmu:update-done' );
			},
			'json'
		).always(function() {
			popup.loading(false);
		});

		return false;
	}
});
</script>
</div>
</dialog>
<?php endif; /* is_installed  check */ ?>
