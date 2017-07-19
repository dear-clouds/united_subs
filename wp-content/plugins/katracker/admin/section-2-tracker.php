<?php

// Admin Tracker Settings //////////////////////////////////////////////////////////////////////////

global $katracker_section;

$katracker_section[basename( __FILE__ )] = array(
	'title'   => __( 'Tracker', 'katracker' ),
	'name'    => 'katrackerTrackerSettings',
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
			_e( 'Here you go more into the depth of the tracker-related settings. Be carefull!', 'katracker' );
		}, 
		$katracker_section[basename( __FILE__ )]['name']
	);

	register_setting( $katracker_section[basename( __FILE__ )]['name'], KATRACKER_PREFIX . 'active' );
	add_settings_field( 
		KATRACKER_PREFIX . 'active', 
		__( 'Activate Tracker', 'katracker' ), 
		function () { 
			$option = get_katracker_option( 'active' );
			?>
				<input type="radio" name="<?php echo KATRACKER_PREFIX; ?>active" value="1" <?php checked( $option, 1, true ); ?>><?php _e( 'Yes', 'katracker' ); ?></br>
				<input type="radio" name="<?php echo KATRACKER_PREFIX; ?>active" value="0" <?php checked( $option, 0, true ); ?>><?php _e( 'No', 'katracker' ); ?>
		<?php }, 
		$katracker_section[basename( __FILE__ )]['name'], 
		KATRACKER_PREFIX . 'section-' . $katracker_section[basename( __FILE__ )]['name'],
		array( 'label_for' => KATRACKER_PREFIX . 'active' )
	);

	register_setting( $katracker_section[basename( __FILE__ )]['name'], KATRACKER_PREFIX . 'open-tracker' );
	add_settings_field( 
		KATRACKER_PREFIX . 'open-tracker', 
		__( 'Open Tracker', 'katracker' ), 
		function () { 
			$option = get_katracker_option( 'open-tracker' );
			?>
				<input type="radio" name="<?php echo KATRACKER_PREFIX; ?>open-tracker" value="1" <?php checked( $option, 1, true ); ?>><?php _e( 'Yes', 'katracker' ); ?></br>
				<input type="radio" name="<?php echo KATRACKER_PREFIX; ?>open-tracker" value="0" <?php checked( $option, 0, true ); ?>><?php _e( 'No', 'katracker' ); ?>
				<p><?php _e( 'Track every torrent announced to the tracker', 'katracker' ); ?></p>
		<?php },
		$katracker_section[basename( __FILE__ )]['name'], 
		KATRACKER_PREFIX . 'section-' . $katracker_section[basename( __FILE__ )]['name'],
		array( 'label_for' => KATRACKER_PREFIX . 'open-tracker' )
	);

	register_setting( $katracker_section[basename( __FILE__ )]['name'], KATRACKER_PREFIX . 'announce-interval' );
	add_settings_field( 
		KATRACKER_PREFIX . 'announce-interval', 
		__( 'Announce Interval', 'katracker' ), 
		function () {
			$option = get_katracker_option( 'announce-interval' );
			?>
				<input type="number" min="0" step="1" name="<?php echo KATRACKER_PREFIX; ?>announce-interval" value="<?php echo ( isset( $option ) ? $option : 1800 ); ?>" >
				<p><?php _e( 'How often client will send requests (in minutes)', 'katracker' ); ?></p>
		<?php }, 
		$katracker_section[basename( __FILE__ )]['name'], 
		KATRACKER_PREFIX . 'section-'.$katracker_section[basename( __FILE__ )]['name'],
		array( 'label_for' => KATRACKER_PREFIX . 'announce-interval' )
	);

	register_setting( $katracker_section[basename( __FILE__ )]['name'], KATRACKER_PREFIX . 'min-interval' );
	add_settings_field( 
		KATRACKER_PREFIX . 'min-interval', 
		__( 'Minimum Interval', 'katracker' ), 
		function () { 
			$option = get_katracker_option( 'min-interval' );
			?>
				<input type="number" min="0" step="1" name="<?php echo KATRACKER_PREFIX; ?>min-interval" value="<?php echo ( isset( $option ) ? $option : 900 ); ?>" >
				<p><?php _e( 'How often client can force requests (in minutes)', 'katracker' ); ?></p>
		<?php }, 
		$katracker_section[basename( __FILE__ )]['name'], 
		KATRACKER_PREFIX . 'section-'.$katracker_section[basename( __FILE__ )]['name'],
		array( 'label_for' => KATRACKER_PREFIX . 'min-interval' )
	);

	register_setting( $katracker_section[basename( __FILE__ )]['name'], KATRACKER_PREFIX . 'num-peers' );
	add_settings_field( 
		KATRACKER_PREFIX . 'num-peers', 
		__( 'Number of Peers', 'katracker' ), 
		function () { 
			$option = get_katracker_option( 'num-peers' );
			?>
				<input type="number" min="1" step="1" name="<?php echo KATRACKER_PREFIX; ?>num-peers" value="<?php echo ( isset( $option ) ? $option : 900 ); ?>" >
				<p><?php _e( 'Default number of peers to announce', 'katracker' ); ?></p>
		<?php }, 
		$katracker_section[basename( __FILE__ )]['name'], 
		KATRACKER_PREFIX . 'section-'.$katracker_section[basename( __FILE__ )]['name'],
		array( 'label_for' => KATRACKER_PREFIX . 'num-peers' )
	);

	register_setting( $katracker_section[basename( __FILE__ )]['name'], KATRACKER_PREFIX . 'max-peers' );
	add_settings_field( 
		KATRACKER_PREFIX . 'max-peers', 
		__( 'Maximum Number of Peers', 'katracker' ), 
		function () { 
			$option = get_katracker_option( 'max-peers' );
			?>
				<input type="number" min="1" step="1" name="<?php echo KATRACKER_PREFIX; ?>max-peers" value="<?php echo ( isset( $option ) ? $option : 900 ); ?>" >
				<p><?php _e( 'Maximum number of peers to announce', 'katracker' ); ?></p>
		<?php }, 
		$katracker_section[basename( __FILE__ )]['name'], 
		KATRACKER_PREFIX . 'section-'.$katracker_section[basename( __FILE__ )]['name'],
		array( 'label_for' => KATRACKER_PREFIX . 'max-peers' )
	);

	register_setting( $katracker_section[basename( __FILE__ )]['name'], KATRACKER_PREFIX . 'slug' );
	add_settings_field( 
		KATRACKER_PREFIX . 'slug', 
		__( 'Tracker URL slug', 'katracker' ), 
		function () { 
			$option = get_katracker_option( 'slug' );
			?>
				<input type="text" name="<?php echo KATRACKER_PREFIX; ?>slug" value="<?php echo ( isset( $option ) ? $option : 'katracker' ); ?>" >
				<p><?php _e( 'The url slug you want to access the tracker options from, for example: www.example.com/<b>katracker</b>/announce', 'katracker' ); ?></p>
		<?php }, 
		$katracker_section[basename( __FILE__ )]['name'], 
		KATRACKER_PREFIX . 'section-'.$katracker_section[basename( __FILE__ )]['name'],
		array( 'label_for' => KATRACKER_PREFIX . 'slug' )
	);
	
	register_setting( $katracker_section[basename( __FILE__ )]['name'], KATRACKER_PREFIX . 'subdomain' );
	add_settings_field( 
		KATRACKER_PREFIX . 'subdomain', 
		__( 'Slug as Subdomain', 'katracker' ), 
		function () { 
			$option = get_katracker_option( 'subdomain' );
			?>
				<input type="radio" name="<?php echo KATRACKER_PREFIX; ?>subdomain" value="1" <?php checked( $option, 1, true ); ?>><?php _e( 'Yes', 'katracker' ); ?></br>
				<input type="radio" name="<?php echo KATRACKER_PREFIX; ?>subdomain" value="0" <?php checked( $option, 0, true ); ?>><?php _e( 'No', 'katracker' ); ?>
				<p><?php _e( 'Only available if permalinks are enabled for the site, and the server is configured to have a subdomain equal to the slug and pointing to the main site.', 'katracker' ); ?></p>
		<?php }, 
		$katracker_section[basename( __FILE__ )]['name'], 
		KATRACKER_PREFIX . 'section-'.$katracker_section[basename( __FILE__ )]['name'],
		array( 'label_for' => KATRACKER_PREFIX . 'subdomain' )
	);
} );
