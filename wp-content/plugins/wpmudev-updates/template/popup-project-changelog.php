<?php
/**
 * Dashboard popup template: Project changelog
 *
 * Displays the changelog of a specific project.
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

?>
<dialog title="<?php printf( esc_attr__( '%s changelog', 'wpmudev' ), esc_html( $item->name ) ); ?>" class="small no-margin">
<div class="wdp-changelog <?php echo esc_attr( $dlg_id ); ?>">

<div class="title-action" data-project="<?php echo esc_attr( $pid ); ?>">
	<?php if ( $item->is_licensed ) : ?>
		<?php if ( $item->is_installed && $item->has_update ) { ?>
		<a href="#update" class="button button-small show-project-update">
			<?php esc_html_e( 'Update available', 'wpmudev' ); ?>
		</a>
		<?php } ?>
	<?php else : ?>
		<a href="#upgrade" class="button button-small" rel="dialog">
			<?php esc_html_e( 'Upgrade', 'wpmudev' ); ?>
		</a>
	<?php endif; ?>
</div>

<ul class="versions">
<?php foreach ( $item->changelog as $log ) {
	$row_class = '';
	$badge = '';

	if ( ! is_array( $log ) ) { continue; }
	if ( empty( $log ) ) { continue; }

	if ( $item->is_installed ) {
		// -1 .. local is higher (dev) | 0 .. equal | 1 .. new version available
		$version_check = version_compare( $log['version'], $item->version_installed );

		if ( $item->version_installed && 1 === $version_check ) {
			$row_class = 'new';
		}

		if ( $item->version_installed ) {
			if ( 0 === $version_check ) {
				$badge = sprintf(
					'<div class="current-version">%s %s</div>',
					'<i class="wdv-icon wdv-icon-ok"></i>',
					__( 'Current', 'wpmudev' )
				);
			} elseif ( 1 === $version_check ) {
				$badge = sprintf(
					'<div class="new-version">%s %s</div>',
					'<i class="wdv-icon wdv-icon-star"></i>',
					__( 'New', 'wpmudev' )
				);
			}
		}
	}

	$version = $log['version'];

	if ( empty( $log['time'] ) ) {
		$rel_date = '';
	} else {
		$rel_date = date_i18n( get_option( 'date_format' ), $log['time'] );
	}

	printf(
		'<li class="%s"><h4>%s %s <small class="float-r">%s</small></h4>',
		esc_attr( $row_class ),
		sprintf(
			esc_html__( 'Version %s', 'wpmudev' ), esc_html( $version )
		),
		wp_kses_post( $badge ),
		esc_html( $rel_date )
	);

	$notes = explode( "\n", $log['log'] );
	$detail_level = 0;
	$detail_class = 'intro';

	echo '<ul class="changes">';
	foreach ( $notes as $note ) {
		if ( 0 === strpos( $note, '<p>' ) ) {
			if ( 1 == $detail_level ) {
				printf(
					'<li class="toggle-details">
					<a href="#" class="for-intro">%s</a><a href="#" class="for-detail">%s</a>
					</li>',
					esc_html__( 'Show all changes', 'wpmudev' ),
					esc_html__( 'Hide details', 'wpmudev' )
				);
				$detail_class = 'detail';
			}
			$detail_level += 1;
		}

		$note = stripslashes( $note );
		$note = preg_replace( '/(<br ?\/?>|<p>|<\/p>)/', '', $note );
		$note = trim( preg_replace( '/^\s*(\*|\-)\s*/', '', $note ) );
		$note = str_replace( array( '<', '>' ), array( '&lt;', '&gt;' ), $note );
		$note = preg_replace( '/`(.*?)`/', '<code>\1</code>', $note );
		if ( empty( $note ) ) { continue; }

		printf(
			'<li class="version-%s">%s</li>',
			esc_attr( $detail_class ),
			wp_kses_post( $note )
		);
	}
	echo '</ul></li>';
} ?>
</ul>
</div>
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
});
</script>
</dialog>
