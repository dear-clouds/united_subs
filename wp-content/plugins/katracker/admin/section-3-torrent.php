<?php

// Admin Torrents Settings /////////////////////////////////////////////////////////////////////////

global $katracker_section;

$katracker_section[basename( __FILE__ )] = array(
	'title'   => __( 'Torrents', 'katracker' ),
	'name'    => 'katrackerTorrentOptions',
	'slug'    => preg_replace( array( '/^section-\d{1}-/', '/.php$/' ), array( '', '' ) , basename( __FILE__ ) ),
	'submit'  => true,
	'action'  => 'options.php'
);

add_action( 'admin_init', function () {

	global $katracker_section;

	add_settings_section(
		KATRACKER_PREFIX . 'section-'.$katracker_section[basename( __FILE__ )]['name'],
		__( $katracker_section[basename( __FILE__ )]['title'], 'katracker' ),
		function () {
			_e( 'Here you edit torrent file related options, mostly for managing the files in wordpress', 'katracker' );
		},
		$katracker_section[basename( __FILE__ )]['name']
	);

	register_setting( $katracker_section[basename( __FILE__ )]['name'], KATRACKER_PREFIX . 'validate-hash' );
	add_settings_field(
		KATRACKER_PREFIX . 'validate-hash',
		__( 'Validate torrent info hash', 'katracker' ),
		function () {
			$option = get_katracker_option( 'validate-hash' );
			?>
			<input type="radio" name="<?php echo KATRACKER_PREFIX; ?>validate-hash" value="1" <?php checked( $option, 1, true ); ?>><?php _e( 'Yes', 'katracker' ); ?></br>
			<input type="radio" name="<?php echo KATRACKER_PREFIX; ?>validate-hash" value="0" <?php checked( $option, 0, true ); ?>><?php _e( 'No', 'katracker' ); ?>
			<p>
				<?php _e( 'Sometimes mod_security blocks communication with torrents that have hashes with null bytes.</br>' .
				          'With this option active, the torrent hash will be checked on upload and torrent with problematic hashes will be blocked.', 'katracker' ); ?>
			</p>
		<?php },
		$katracker_section[basename( __FILE__ )]['name'],
		KATRACKER_PREFIX . 'section-'.$katracker_section[basename( __FILE__ )]['name'],
		array( 'label_for' => KATRACKER_PREFIX . 'validate-hash' )
	);

	register_setting( $katracker_section[basename( __FILE__ )]['name'], KATRACKER_PREFIX . 'rename-files' );
	add_settings_field(
		KATRACKER_PREFIX . 'rename-files',
		__( 'Rename downloaded files', 'katracker' ),
		function () {
			$option = get_katracker_option( 'rename-files' );
			?>
			<input type="radio" name="<?php echo KATRACKER_PREFIX; ?>rename-files" value="1" <?php checked( $option, 1, true ); ?>><?php _e( 'Yes', 'katracker' ); ?></br>
			<input type="radio" name="<?php echo KATRACKER_PREFIX; ?>rename-files" value="0" <?php checked( $option, 0, true ); ?>><?php _e( 'No', 'katracker' ); ?>
			<p><?php _e( 'If checked, downloaded torrents are renamed to the attachment title, otherwise the filename is generated from the torrent file itself.', 'katracker' ); ?></p>
		<?php },
		$katracker_section[basename( __FILE__ )]['name'],
		KATRACKER_PREFIX . 'section-'.$katracker_section[basename( __FILE__ )]['name'],
		array( 'label_for' => KATRACKER_PREFIX . 'rename-files' )
	);

	register_setting( $katracker_section[basename( __FILE__ )]['name'], KATRACKER_PREFIX . 'tracked-access' );
	add_settings_field(
		KATRACKER_PREFIX . 'tracked-access',
		__( 'Enable download for untracked torrents', 'katracker' ),
		function () {
			$option = get_katracker_option( 'tracked-access' );
			?>
				<input type="radio" name="<?php echo KATRACKER_PREFIX; ?>tracked-access" value="1" <?php checked( $option, 1, true ); ?>><?php _e( 'Yes', 'katracker' ); ?></br>
				<input type="radio" name="<?php echo KATRACKER_PREFIX; ?>tracked-access" value="0" <?php checked( $option, 0, true ); ?>><?php _e( 'No', 'katracker' ); ?>
		<?php },
		$katracker_section[basename( __FILE__ )]['name'],
		KATRACKER_PREFIX . 'section-'.$katracker_section[basename( __FILE__ )]['name'],
		array( 'label_for' => KATRACKER_PREFIX . 'tracked-access' )
	);

	register_setting( $katracker_section[basename( __FILE__ )]['name'], KATRACKER_PREFIX . 'torrent-page' );
	add_settings_field(
		KATRACKER_PREFIX . 'torrent-page',
		__( 'Enable torrent page', 'katracker' ),
		function () {
			$option = get_katracker_option( 'torrent-page' );
			?>
				<input type="radio" name="<?php echo KATRACKER_PREFIX; ?>torrent-page" value="1" <?php checked( $option, 1, true ); ?>><?php _e( 'Yes', 'katracker' ); ?></br>
				<input type="radio" name="<?php echo KATRACKER_PREFIX; ?>torrent-page" value="0" <?php checked( $option, 0, true ); ?>><?php _e( 'No', 'katracker' ); ?>
		<?php },
		$katracker_section[basename( __FILE__ )]['name'],
		KATRACKER_PREFIX . 'section-'.$katracker_section[basename( __FILE__ )]['name'],
		array( 'label_for' => KATRACKER_PREFIX . 'torrent-page' )
	);

	register_setting( $katracker_section[basename( __FILE__ )]['name'], KATRACKER_PREFIX . 'labels' );
	add_settings_field(
		KATRACKER_PREFIX . 'labels',
		__( 'Torrent labels, seperated by commas', 'katracker' ),
		function () {
			$option = get_katracker_option( 'labels' );
			?>
			<input type="text" name="<?php echo KATRACKER_PREFIX; ?>labels" value="<?php echo ( isset( $option ) ? $option : '' ); ?>">
		<?php },
		$katracker_section[basename( __FILE__ )]['name'],
		KATRACKER_PREFIX . 'section-'.$katracker_section[basename( __FILE__ )]['name'],
		array( 'label_for' => KATRACKER_PREFIX . 'labels' )
	);

	register_setting( $katracker_section[basename( __FILE__ )]['name'], KATRACKER_PREFIX . 'reset-announce' );
	add_settings_field(
		KATRACKER_PREFIX . 'reset-announce',
		__( 'Set torrent announce to default', 'katracker' ),
		function () {
			$option = get_katracker_option( 'reset-announce' );
			?>
				<input type="radio" name="<?php echo KATRACKER_PREFIX; ?>reset-announce" value="2" <?php echo checked( $option, 2, false ); ?>><?php _e( 'Set', 'katracker' ); ?></br>
				<input type="radio" name="<?php echo KATRACKER_PREFIX; ?>reset-announce" value="1" <?php echo checked( $option, 1, false ); ?>><?php _e( 'Append', 'katracker' ); ?></br>
				<input type="radio" name="<?php echo KATRACKER_PREFIX; ?>reset-announce" value="0" <?php echo checked( $option, 0, false ); ?>><?php _e( 'Do nothing', 'katracker' ); ?>
		<?php },
		$katracker_section[basename( __FILE__ )]['name'],
		KATRACKER_PREFIX . 'section-'.$katracker_section[basename( __FILE__ )]['name'],
		array( 'label_for' => KATRACKER_PREFIX . 'reset-announce' )
	);

	register_setting( $katracker_section[basename( __FILE__ )]['name'], KATRACKER_PREFIX . 'default-announce' );
	add_settings_field(
		KATRACKER_PREFIX . 'default-announce',
		__( 'Torrent default announces', 'katracker' ),
		function () {
			$option = get_katracker_option( 'default-announce' );
			$mode = get_katracker_option( 'reset-announce' );
			?>
			<textarea class="large-text code" name="<?php echo KATRACKER_PREFIX; ?>default-announce"><?php echo ( !empty( $option ) && $mode != 0 ? $option : get_katracker_url( 'announce' ) ); ?></textarea>
			<p><?php _e( 'You can add a list of announces, seperated by new lines', 'katracker' ); ?></p>
		<?php },
		$katracker_section[basename( __FILE__ )]['name'],
		KATRACKER_PREFIX . 'section-'.$katracker_section[basename( __FILE__ )]['name'],
		array( 'label_for' => KATRACKER_PREFIX . 'default-announce' )
	);

	register_setting( $katracker_section[basename( __FILE__ )]['name'], KATRACKER_PREFIX . 'reset-comment' );
	add_settings_field(
		KATRACKER_PREFIX . 'reset-comment',
		__( 'Set torrent comment to default', 'katracker' ),
		function () {
			$option = get_katracker_option( 'reset-comment' );
			?>
				<input type="radio" name="<?php echo KATRACKER_PREFIX; ?>reset-comment" value="2" <?php checked( $option, 2, true ); ?>><?php _e( 'Set', 'katracker' ); ?></br>
				<input type="radio" name="<?php echo KATRACKER_PREFIX; ?>reset-comment" value="1" <?php checked( $option, 1, true ); ?>><?php _e( 'Append', 'katracker' ); ?></br>
				<input type="radio" name="<?php echo KATRACKER_PREFIX; ?>reset-comment" value="0" <?php checked( $option, 0, true ); ?>><?php _e( 'Do nothing', 'katracker' ); ?>
		<?php },
		$katracker_section[basename( __FILE__ )]['name'],
		KATRACKER_PREFIX . 'section-'.$katracker_section[basename( __FILE__ )]['name'],
		array( 'label_for' => KATRACKER_PREFIX . 'reset-comment' )
	);

	register_setting( $katracker_section[basename( __FILE__ )]['name'], KATRACKER_PREFIX . 'default-comment' );
	add_settings_field(
		KATRACKER_PREFIX . 'default-comment',
		__( 'Torrent default comment', 'katracker' ),
		function () {
			$option = get_katracker_option( 'default-comment' );
			$mode = get_katracker_option( 'reset-comment' );
			?>
			<textarea class="large-text" name="<?php echo KATRACKER_PREFIX; ?>default-comment"><?php echo ( !empty( $option ) && $mode != 0 ? $option : __( 'Proudly tracked with KaTracker wordpress plugin', 'katracker' ) ); ?></textarea>
		<?php },
		$katracker_section[basename( __FILE__ )]['name'],
		KATRACKER_PREFIX . 'section-' . $katracker_section[basename( __FILE__ )]['name'],
		array( 'label_for' => KATRACKER_PREFIX . 'default-comment' )
	);
 } );

 ?>
