<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$ext_instance = fw()->extensions->get( 'woffice-maintenance' );

$options = array(
	'build' => array(
		'type'    => 'tab',
		'title'   => __( 'Content', 'woffice' ),
		'options' => array(
			'maintenance-box-content' => array(
				'title'   => __( 'Content Options', 'woffice' ),
				'type'    => 'box',
				'options' => array(
					'maintenance_status' => array(
					    'label' => __('Status', 'woffice'),
					    'desc'  => __('Once enabled it\'ll redirects all the visitors/members to the maintenance page.', 'woffice'),
					    'type'         => 'switch',
						'right-choice' => array(
							'value' => 'on',
							'label' => __( 'On', 'woffice' )
						),
						'left-choice'  => array(
							'value' => 'off',
							'label' => __( 'Off', 'woffice' )
						),
						'value'        => 'off',
					),
					'maintenance_headline' => array(
					    'type'  => 'text',
					    'label' => __('Headline', 'woffice'),
					    'desc'  => __('This is the headline displayed on the page.', 'woffice'),
						'value'        => 'Maintenance, we\'ll be back in 10 minutes',
					),
					'maintenance_text' => array(
						'type'  => 'wp-editor',
					    'label' => __( 'Content', 'woffice' ),
					    'desc'  => __( 'Below the headline', 'woffice' ),
					    'tinymce' => false,
					    'media_buttons' => false,
					    'teeny' => false,
					    'wpautop' => false,
					    'editor_css' => '',
					    'reinit' => false,
					),
				),
			),
		),
	),
	'style' => array(
		'type'    => 'tab',
		'title'   => __( 'Style', 'woffice' ),
		'options' => array(
			'maintenance-box-style' => array(
				'title'   => __( 'Background Options', 'woffice' ),
				'type'    => 'box',
				'options' => array(
					'maintenance_color' => array(
					    'type'  => 'color-picker',
					    'value' => '#FFFFFF',
					    'label'  => __('Text color', 'woffice'),
						'desc' => __('This is the text color over the image.','woffice')
					),
					'maintenance_bg_color' => array(
					    'type'  => 'color-picker',
					    'value' => '#82b440',
					    'label'  => __('Background color', 'woffice'),
						'desc' => __('This is the background color and the image will be over it.','woffice')
					),
					'maintenance_bg_image' => array(
						'label' => __( 'Background Image', 'woffice' ),
						'desc'  => __( 'Large Image on fullscreen.', 'woffice' ),
						'type'  => 'upload'
					),
					'maintenance_layer_opacity' => array(
						'label' => __( 'Layer Opacity', 'woffice' ),
						'type'  => 'slider',
						'properties' => array(
					        'min' => 0,
					        'max' => 1,
					        'step' => 0.1,
					    ),
						'value' => '0.5',
						'desc' => __('This is the opacity of the layer with the color over the background image.','woffice'),
						'help' => __('A number between 0 - 1, if you choose 0 it will becomes hidden.','woffice')
					),
					'maintenance_icon' => array(
					    'type'  => 'icon',
					    'value' => 'fa-history',
					    'label'  => __('Icon', 'woffice'),
						'desc' => __('This is an extra icon so it looks better.','woffice')
					),
				)
			)
		)
	),
);