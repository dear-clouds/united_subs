<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$ext_instance = fw()->extensions->get( 'woffice-glogin' );

$url = get_site_url() . "/wp-admin/admin-ajax.php?action=googleplus_oauth_callback";

$state = (defined('NEW_FB_LOGIN')) ? 'ON' : 'OFF';

$options = array(
	'google-login' => array(
		'type'    => 'tab',
		'title'   => __( 'Google Login', 'woffice' ),
		'options' => array(
			'google_info' => array(
				'label' => __( 'Important :', 'woffice' ),
				'type'  => 'html',
				'html'  => 'Please make sure you have read the <a href="https://2f.ticksy.com/article/4261" target="_blank">tutorial about Google Login</a>. Because there is some steps in Google Console API to do in order to make it working. Don\t forget the product name in the "Consent Screen" page, it is important so you will be able to generate  a redirect URI.',
			),
			'callbackurl' => array(
				'label' => __( 'Your callback URL :', 'woffice' ),
				'type'  => 'html',
				'html'  => 'When enabling Google+ API, it asks for a callback URL, please copy past :<br> <span class="highlight">'.$url.'</span>',
			),
			'googleplus_app_name' => array(
				'label' => __( 'Project name', 'woffice' ),
				'type' => 'text',
				'desc' => __( 'When you have enabled the Google+ API in the Google API page, you have created a project. Please copy/past its name here.', 'woffice' ),
			),
			'googleplus_client_id' => array(
				'label' => __( 'Client ID', 'woffice' ),
				'type' => 'text',
				'desc' => __( 'Your Google API client ID for this project (see Credentials page).', 'woffice' ),
			),
			'googleplus_client_secret' => array(
				'label' => __( 'Client Secret', 'woffice' ),
				'type' => 'textarea',
				'desc' => __( 'Your Google API Secret key for this project (downloaded in a JSON file).', 'woffice' ),
			),
			'google_show_button' => array(
				'label' => __( 'Show the button ?', 'woffice' ),
				'type'         => 'switch',
				'right-choice' => array(
					'value' => 'show',
					'label' => __( 'Show', 'woffice' )
				),
				'left-choice'  => array(
					'value' => 'hide',
					'label' => __( 'Hide', 'woffice' )
				),
				'value'        => 'show',
				'desc' => __('Do you want to show it on the login page, you can hide if you only want to use Facebook one.','woffice')
			),
		)
	),
	'faecbook-login' => array(
		'type'    => 'tab',
		'title'   => __( 'Facebook Sign In (Register)', 'woffice' ),
		'options' =>  array(
			'facebook_info' => array(
				'label' => __( 'Important :', 'woffice' ),
				'type'  => 'html',
				'html'  => 'Please make sure you have read the <a href="https://2f.ticksy.com/article/4456/" target="_blank">tutorial about Facebook Login</a>. Because there is some steps in Facebook Dev API to do in order to make it working. Don\'t forget that we are using a plugin here, you will have to install it first in order to make it work. Then it is not as the Google one, this one is for the registration/login. Thus, be sure "Anyone can Register" option is checked in your settings.',
			),
			'facebook_state' => array(
				'label' => __( 'Your callback URL :', 'woffice' ),
				'type'  => 'html',
				'html'  => 'Nextend Facebook Connect plugin is :<br> <span class="highlight">'.$state.'</span>',
				'desc'	=>  __( 'If it is on OFF, please be sure to have installed and activated the plugin : Nextend Facebook Connect.', 'woffice' )
			),
			'facebook_show_button' => array(
				'label' => __( 'Show the button ?', 'woffice' ),
				'type'         => 'switch',
				'right-choice' => array(
					'value' => 'show',
					'label' => __( 'Show', 'woffice' )
				),
				'left-choice'  => array(
					'value' => 'hide',
					'label' => __( 'Hide', 'woffice' )
				),
				'value'        => 'hide',
				'desc' => __('Do you want to show it on the login page, you can hide if you only want to use Google one, if the plugin is not installed it will be hide by default.','woffice')
			),
		)
	)
);