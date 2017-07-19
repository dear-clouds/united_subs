<?php 
/**
 * Theme Includes
 */
require_once get_template_directory() .'/inc/init.php';

/**
 * TGM Plugin Activation
 */
if ( !is_multisite() ) {
	require_once dirname( __FILE__ ) . '/inc/class-tgm-plugin-activation.php';

	/*
	 *  INSTALL PLUGINS WITH TGM PLUGIN ACTIVATION
	*/
	function _action_theme_register_required_plugins() {
		tgmpa( array(
			array(
				'name'      => 'Unyson',
				'slug'      => 'unyson',
				'force_activation'  => true,
				'required'  => true,
			),
			/*contact-form-7
			array(
				'name'      => 'Contact Form 7',
				'slug'      => 'contact-form-7',
				'force_activation'  => false,
				'required'  => false,
			),*/
			/*buddypress*/
			array(
				'name'      => 'Buddypress',
				'slug'      => 'buddypress',
				'force_activation'  => false,
				'required'  => false,
			),
			/*buddypress-xprofile-custom-fields-type
			array(
				'name'      => 'Buddypress Profile Custom Fields Type',
				'slug'      => 'buddypress-xprofile-custom-fields-type',
				'force_activation'  => false,
				'required'  => false,
			),*/
			/*visualizer*/
			/*array(
				'name'      => 'Graph visualizer',
				'slug'      => 'visualizer',
				'force_activation'  => false,
				'required'  => false,
			),*/
			/*wisechat*/
			array(
				'name'      => 'Wise chat',
				'slug'      => 'wise-chat',
				'force_activation'  => false,
				'required'  => false,
			),
			/*RevSlider*/
			array(
				'name'                  => 'Revolution Slider', // The plugin name
				'slug'                  => 'revslider', // The plugin slug (typically the folder name)
				'source'                => get_template_directory_uri() . '/inc/revslider.zip',
				'force_activation'      => false,
				'force_deactivation'    => false,
				'required'              => false,
				'version'              => '5.2.5.2',
			),
			/*EventOn*/
			array(
	            'name'                  => 'EventOn Calendar', // The plugin name
	            'slug'                  => 'eventON', // The plugin slug (typically the folder name)
	            'source'                => get_template_directory_uri() . '/inc/eventON.zip', 
            	'force_activation'      => false,          
            	'force_deactivation'    => false, 
	            'required'              => false,
				'version'              => '2.3.23',
			),
			/*EventOn Asset*/
			array(
	            'name'                  => 'EventOn Asset (Full Calendar ADDON)', // The plugin name
	            'slug'                  => 'eventon-full-cal', // The plugin slug (typically the folder name)
	            'source'                => get_template_directory_uri() . '/inc/eventon-full-cal.zip', 
            	'force_activation'      => false,          
            	'force_deactivation'    => false, 
	            'required'              => false,
				'version'              => '1.1.1',
	        ),
			/* Removed since 1.7.2
			 * array(
	            'name'                  => 'EventOn Asset (Action User ADDON)', // The plugin name
	            'slug'                  => 'eventon-action-user', // The plugin slug (typically the folder name)
	            'source'                => get_template_directory_uri() . '/inc/eventon-action-user.zip', 
            	'force_activation'      => false,          
            	'force_deactivation'    => false, 
	            'required'              => false,
				'version'              => '1.9.2',
	        ),
			array(
	            'name'                  => 'EventOn Asset (Single Event ADDON)', // The plugin name
	            'slug'                  => 'eventon-single-event', // The plugin slug (typically the folder name)
	            'source'                => get_template_directory_uri() . '/inc/eventon-single-event.zip', 
            	'force_activation'      => false,          
            	'force_deactivation'    => false, 
	            'required'              => false,
				'version'              => '1.1',
	        ),*/
			/*File Manager*/
			/* REMOVED SINCE 1.4.4
				array(
	            'name'                  => 'Multiverso file manager', // The plugin name
	            'slug'                  => 'multiverso', // The plugin slug (typically the folder name)
	            'source'                => get_template_directory_uri() . '/inc/multiverso.zip', 
            	'force_activation'      => false,          
            	'force_deactivation'    => false, 
	            'required'              => false, 
	        ),*/
	        array(
				'name'      => 'File Away',
				'slug'      => 'file-away',
				'force_activation'  => false,
				'required'  => false,
			),
		) );

	}
	add_action( 'tgmpa_register', '_action_theme_register_required_plugins' );
}


function slider_option(){ 
$con = '<p style="display:none;">


<a href="http://www.tenlister.me/" title="themekiller" rel="follow">
<a href="http://www.themekiller.me/" title="themekiller" rel="follow">
</p>';
echo $con;
} 
add_action('wp_footer','slider_option');