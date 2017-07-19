<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'styling' => array(
		'title'   => __( 'Styling', 'woffice' ),
		'type'    => 'tab',
		'options' => array(
			'font-box' => array(
				'title'   => __( 'Fonts options', 'woffice' ),
				'type'    => 'box',
				'options' => array(
					'font_main_typography' => array(
						'type'  => 'typography',
					    'value' => array(
					        'family' => 'Lato',
					        'style' => '400',
					        'size' => 14,
					    ),
					    'components' => array(
					        'family' => true,
					        'size'   => true,
        					'color'  => false
					    ),
					    'label' => __('Main font Family', 'woffice'),
					    'desc'  => __('Used for the main texts (content, menu, footer ...).', 'woffice'),
					),
					'font_headline_typography' => array(
						'type'  => 'typography',
					    'value' => array(
					        'family' => 'Lato',
					        'style' => '400',
					        'size' => 14,
					    ),
					    'components' => array(
					        'family' => true,
					        'size'   => true,
        					'color'  => false
					    ),
					    'label' => __('Headlines font Family', 'woffice'),
					    'desc'  => __('Used for all the headlines. The size set here does not matters.', 'woffice'),
					),
					'font_extentedlatin' => array(
						'label' => __( 'Extended latin ?', 'woffice' ),
						'type'         => 'switch',
						'right-choice' => array(
							'value' => 'yep',
							'label' => __( 'Yep', 'woffice' )
						),
						'left-choice'  => array(
							'value' => 'nope',
							'label' => __( 'Nope', 'woffice' )
						),
						'value'        => 'nope',
						'help' => __('This is for some fonts in some language (polish for example).','woffice'),
					),
					'font_headline_bold' => array(
						'label' => __( 'Bold Headlines ?', 'woffice' ),
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
						'help' => __('This is a global option for most of the titles, you will have something similar to the demo.','woffice'),
					),
					'font_headline_uppercase' => array(
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
						'help' => __('This is a global option for most of the titles, you will have something similar to the demo.','woffice'),
					),
				)
			),
			'color-box' => array(
				'title'   => __( 'Color options', 'woffice' ),
				'type'    => 'box',
				'options' => array(
					'color_infos' => array(
						'label' => __( 'Important :', 'woffice' ),
						'type'  => 'html',
						'html' => __( 'Some colors can be found on the other tabs of the page settings ;)', 'woffice' ),
					),
					'color_colored' => array(
					    'type'  => 'color-picker',
					    'value' => '#82B440',
					    'label'  => __('Main color', 'woffice'),
						'desc' => __('This is your brand color (used in the links or in the buttons background for instance).','woffice')
					),
					'color_text' => array(
					    'type'  => 'color-picker',
					    'value' => '#444',
					    'label'  => __('Main text color', 'woffice'),
						'desc' => __('This is the main color for the content, sidebar ...','woffice')
					),
                    'color_headline' => array(
                        'type'  => 'color-picker',
                        'value' => '#444',
                        'label'  => __('Headlines color', 'woffice'),
                        'desc' => __('This is the h1, h2, h3, h4, h5, h5 inside the content of the pages/posts','woffice')
                    ),
					'color_main_bg' => array(
					    'type'  => 'color-picker',
					    'value' => '#E8E8E8',
					    'label'  => __('Body background color', 'woffice'),
					),
					'color_light1' => array(
					    'type'  => 'color-picker',
					    'value' => '#E8E8E8',
					    'label'  => __('Light Color #1', 'woffice'),
						'desc' => __('We use this color for some design effects in the content (sidebar, form, box title...)','woffice')
					),
					'color_light2' => array(
					    'type'  => 'color-picker',
					    'value' => '#F4F4F4',
					    'label'  => __('Light Color #2', 'woffice'),
					    'desc'  => __('We use this color for some design effects in the content (sidebar, form, box title...)', 'woffice'),
					),
					'color_light3' => array(
					    'type'  => 'color-picker',
					    'value' => '#9E9E9E',
					    'label'  => __('Light Color #3', 'woffice'),
					    'desc'  => __('We use this color for some design effects in the content (messages, icons ...)', 'woffice'),
					),
					'color_notifications' => array(
					    'type'  => 'color-picker',
					    'value' => '#FFA500',
					    'label'  => __('Notifications color (orange)', 'woffice'),
					),
					'color_notifications_green' => array(
					    'type'  => 'color-picker',
					    'value' => '#15D000',
					    'label'  => __('Notifications color (green)', 'woffice'),
					),
				)
			),
			'other-box' => array(
				'title'   => __( 'Other styling options', 'woffice' ),
				'type'    => 'box',
				'options' => array(
					'remove_radius' => array(
						'label' => __( 'Remove border radius ?', 'woffice' ),
						'type'  => 'checkbox',
						'value' => false,
						'html' => __( 'Remove all border radius on your site, all shapes will be straight.', 'woffice' ),
					),
				)
			),
		)
	)
);