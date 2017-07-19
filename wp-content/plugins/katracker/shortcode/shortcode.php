<?php

// Singel torrent shortcode
add_shortcode( KATRACKER_SHORTCODE, function ( $atts ) {
	$single_torrent = true;

	$template_part = locate_template( KATRACKER_PRE . '-shortcode.php' );
	if ( empty( $template_part ) ) {
		$template_part = plugin_dir_path( __FILE__ ) . KATRACKER_PRE . '-shortcode.php';
	}
	// Load Style
	wp_enqueue_style( KATRACKER_PRE . '-shortcode-style' );
	
	ob_start();
	require_once $template_part;
	katracker_shortcode_single( $atts );
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
} );

// Torrent list shortcode
add_shortcode( KATRACKER_SHORTCODES, function ( $atts ) {
	$single_torrent = false;

	$template_part = locate_template( KATRACKER_PRE . '-shortcode.php' );
	if ( empty( $template_part ) ) {
		$template_part = plugin_dir_path( __FILE__ ) . KATRACKER_PRE . '-shortcode.php';
	}
	// Load Style
	wp_enqueue_style( KATRACKER_PRE . '-shortcode-style' );

	ob_start();
	require_once $template_part;
	katracker_shortcode_many( $atts );
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
} );

// Register style
add_action( 'wp_enqueue_scripts', function () {
	// Check if the user have created a stylesheet in the theme dir, if not register the default style
	$template_part = locate_template( array( KATRACKER_PRE . '-shortcode.css' ) );
	if ( empty( $template_part ) ) {
		$template_part = plugins_url( KATRACKER_PRE . '-shortcode.css', __FILE__ );
	} else {
		$template_part = get_template_directory_uri() . '/' . KATRACKER_PRE . '-shortcode.css';
	}
	wp_register_style( KATRACKER_PRE . '-shortcode-style', $template_part );
} );

?>
