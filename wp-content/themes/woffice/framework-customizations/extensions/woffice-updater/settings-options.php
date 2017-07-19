<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$ext_instance = fw()->extensions->get( 'woffice-updater' );

$status = get_option('woffice_license');
$status_ready = ($status == "checked") ? "Checked" : "Not Checked";

$options = array(
	'build' => array(
		'type'    => 'tab',
		'title'   => __( 'Updater Settings', 'woffice' ),
		'options' => array(
			'tf_username' => array(
				'label'   => __( 'Envato Username', 'woffice' ),
				'type'    => 'text',
				'desc'  => __('Your Envato (Themeforest) Username goes here. ','woffice'),
			),
			'tf_purchasecode' => array(
				'label'   => __( 'Woffice Purchase code', 'woffice' ),
				'type'    => 'text',
				'desc'  => __('The Purchase code of this license. You can find it in the Themeforest\'s download page (it\'s a large number).','woffice'),
			),
			'tf_status' => array(
				'label'   => __( 'Purchase code status. The license works for one site only and if you are not on Localhost. Otherwise, your license will be activated when your site will be online. Feel free to get in touch if you need to change that. ', 'woffice' ),
				'type'    => 'html',
				'html'  => '<span class="highlight">'.$status_ready.'</span>',
			),
		)
	),
);