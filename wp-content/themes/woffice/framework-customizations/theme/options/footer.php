<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'footer' => array(
		'title'   => __( 'Footer & Extrafooter', 'woffice' ),
		'type'    => 'tab',
		'options' => array(
			'footer-box' => array(
				'title'   => __( 'Footer Options', 'woffice' ),
				'type'    => 'box',
				'options' => array(
					'footer_widgets'    => array(
						'label' => __( 'Show the Footer Widgets', 'woffice' ),
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
						'desc' => __('They will be above the copyright bar and below the extrafooter bar. You can set them in the widget page.','woffice'),
					),
					'footer_widgets_columns' => array(
						'label' => __( 'Number of columns ?', 'woffice' ),
						'type'  => 'select',
						'desc' => __('For the footer widgets.','woffice'),
						'value' => '4',
						'choices' => array(
					        '1' => '1',
					        '2' => '2',
					        '3' => '3',
					        '4' => '4',
					    )
					),
					'footer_color' => array(
					    'type'  => 'color-picker',
					    'value' => '#E8E8E8',
					    'label'  => __('Text color', 'woffice'),
						'desc' => __('This is the color used in the footer for the texts.','woffice')
					),
					'footer_link' => array(
					    'type'  => 'color-picker',
					    'value' => '#82B440',
					    'label'  => __('Link color', 'woffice'),
						'desc' => __('The colored color within the footer','woffice')
					),
					'footer_background' => array(
					    'type'  => 'color-picker',
					    'value' => '#252C2F',
					    'label'  => __('Widgets Background Color', 'woffice'),
						'desc' => __('Color used in the widget background','woffice')
					),
					'footer_copyright_background' => array(
					    'type'  => 'color-picker',
					    'value' => '#3a4349',
					    'label'  => __('Copyright Background Color', 'woffice')
					),
					'footer_copyright_uppercase' => array(
						'label' => __( 'Copyright text in uppercase ?', 'woffice' ),
						'type'  => 'checkbox',
						'value' => true
					),
					'footer_copyright_content' => array(
						'label' => __( 'Copyright Content', 'woffice' ),
						'type'  => 'textarea',
						'value' => '&#169; 2015 all rights reserved. Powered by <a href="//themeforest.net/user/2Fwebd">Woffice</a>.'
					),
					'footer_border_color' => array(
					    'type'  => 'color-picker',
					    'value' => '#82B440',
					    'label'  => __('Color of the border between the widgets and the copyright.', 'woffice')
					),
				)
			),
			'footer-box1' => array(
				'title'   => __( 'Extra Footer', 'woffice' ),
				'type'    => 'box',
				'options' => array(
					'extrafooter_show'    => array(
						'label' => __( 'Show extra footer bar ?', 'woffice' ),
						'desc'  => __( 'That is a box with random photos of your members with a tagline over these images and a link to any page you like. (Usually, the member directory page)', 'woffice' ),
						'type'         => 'switch',
						'right-choice' => array(
							'value' => 'yes',
							'label' => __( 'Show', 'woffice' )
						),
						'left-choice'  => array(
							'value' => 'no',
							'label' => __( 'Hide', 'woffice' )
						),
						'value'        => 'yes',
					),
					'extrafooter_content' => array(
					    'type'  => 'text',
						'label' => __( 'Extrafooter Content', 'woffice' ),
					    'value' => 'We are more than <span>35</span> around the world !',
					    'desc'  => __('The text on the extra footer, you can use some "span" elements to color some words.', 'woffice')
					),
					'extrafooter_link' => array(
					    'type'  => 'text',
					    'value' => '#',
						'label' => __( 'Extrafooter Link', 'woffice' ),
					    'desc'  => __('Link when the user click on that extra footer bar.', 'woffice')
					),
					'extrafooter_border_color' => array(
					    'type'  => 'color-picker',
					    'value' => '#82B440',
						'label' => __( 'Border color', 'woffice' ),
					    'desc'  => __('Color of the border between the content and the extrafooter.', 'woffice')
					),
					'extrafooter_avatar_only'    => array(
						'label' => __( 'Show only profile with avatar ?', 'woffice' ),
						'desc'  => __( 'This is not a good idea if you have a lot of users (1000+).', 'woffice' ),
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
					),
					'extrafooter_random'    => array(
						'label' => __( 'Random avatars ?', 'woffice' ),
						'desc'  => __( 'We pick 100 random users in every page load.', 'woffice' ),
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
					),
                    'extrafooter_repetition_allowed'    => array(
                        'label' => __( 'Allow repetive faces ?', 'woffice' ),
                        'desc'  => __( 'Allow to display more times the same user.', 'woffice' ),
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
                    ),
				)
			),
		)
	)
);