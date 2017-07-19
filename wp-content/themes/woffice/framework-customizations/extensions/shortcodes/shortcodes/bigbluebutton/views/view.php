<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
?>

<?php 
	if ( shortcode_exists( 'bigbluebutton' ) ) {
		echo bigbluebutton_shortcode(); 
	}
	else {
		echo __('Sorry, you need to install this plugin first','woffice') .': <a href="https://wordpress.org/plugins/bigbluebutton/">BigBlueButton</a>';
	}
?>