<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'menu' => array(
		'title'   => __( 'Menu', 'woffice' ),
		'type'    => 'tab',
		'options' => array(
			'menu-box' => array(
				'title'   => __( 'Main options', 'woffice' ),
				'type'    => 'box',
				'options' => array(
					'menu_background' => array(
					    'type'  => 'color-picker',
					    'value' => '#3a4349',
					    'label'  => __('Background color', 'woffice'),
						'desc' => __('The background color of the menu','woffice')
					),
					'menu_width' => array(
						'label' => __( 'Menu Width', 'woffice' ),
						'type'  => 'short-text',
						'value' => '100',
						'desc' => __('A number please','woffice'),
						'help' => __('No need to set px','woffice'),
					),
					'menu_color2' => array(
					    'type'  => 'color-picker',
					    'value' => '#343637',
					    'label'  => __('Menu color #2', 'woffice'),
						'desc' => __('Used for the text color and the borders','woffice')
					),
					'menu_hover' => array(
					    'type'  => 'color-picker',
					    'value' => '#82b440',
					    'label'  => __('Menu hover color', 'woffice'),
						'desc' => __('Used as a link background, link color on it is white.','woffice')
					),
					'menu_layout'    => array(
						'label' => __( 'Menu Layout', 'woffice' ),
						'desc'  => __( 'Choose your menu layout below. The vertical menu is a beta feature you can try it but we think it needs more options, if you see any bug please report it on 2f.ticksy.com', 'woffice' ),
						'type'         => 'switch',
						'right-choice' => array(
							'value' => 'horizontal',
							'label' => __( 'Horizontal Top', 'woffice' )
						),
						'left-choice'  => array(
							'value' => 'vertical',
							'label' => __( 'Left Vertical', 'woffice' )
						),
						'value'        => 'vertical',
					),
					'menu_default'    => array(
						'label' => __( 'Menu Default State', 'woffice' ),
						'desc'  => __( 'Choose the default state of the menu when the user has not clicked yet on the toggle button.', 'woffice' ),
						'type'         => 'switch',
						'right-choice' => array(
							'value' => 'open',
							'label' => __( 'Open', 'woffice' )
						),
						'left-choice'  => array(
							'value' => 'close',
							'label' => __( 'Close', 'woffice' )
						),
						'value'        => 'open',
					),
                    'menu_headline_uppercase' => array(
                        'label' => __( 'Uppercase Elements', 'woffice' ),
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
                        'help' => __('Do you want menu the links in the menu uppercase?.','woffice'),
                    ),
				)
			),
		)
	)
);