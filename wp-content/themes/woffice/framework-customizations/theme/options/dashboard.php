<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'dashboard' => array(
		'title'   => __( 'Home Dashboard', 'woffice' ),
		'type'    => 'tab',
		'options' => array(
			'home-box' => array(
				'title'   => __( 'Main options', 'woffice' ),
				'type'    => 'box',
				'options' => array(
					'dashboard_columns' => array(
						'label' => __( 'Number of columns in the dashboard', 'woffice' ),
						'type'  => 'select',
						'value' => '3',
						'desc' => __('This is only for non-mobiles devices, because it is responsive.','woffice'),
						'choices' => array(
					        '1' => __( '1 Columns', 'woffice' ),
					        '2' => __( '2 Columns', 'woffice' ),
					        '3' => __( '3 Columns', 'woffice' )
					    )
					)
				)
			),
            'dashboard_headline_uppercase' => array(
                'label' => __( 'Uppercase Headlines ?', 'woffice' ),
                'type'         => 'switch',
                'right-choice' => array(
                    'value' => 'yep',
                    'label' => __( 'Yep', 'woffice' )
                ),
                'left-choice'  => array(
                    'value' => 'nope',
                    'label' => __( 'Nope', 'woffice' )
                ),
                'value'        => 'yep',
                'help' => __('This is an option for the titles of the widgets in the dashboard page.','woffice'),
            ),
		)
	)
);