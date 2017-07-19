<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'page-title' => array(
		'title'   => __( 'Title Box', 'woffice' ),
		'type'    => 'tab',
		'options' => array(
			'title-box' => array(
				'title'   => __( 'Main options', 'woffice' ),
				'type'    => 'box',
				'options' => array(
					'main_featured_image' => array(
						'label' => __( 'Default Featured image', 'woffice' ),
						'desc'  => __( 'Upload a large image', 'woffice' ),
						'type'  => 'upload',
						'images_only' => true
					),
					'main_featured_alignment' => array(
						'label' => __( 'Alignment of the background image ?', 'woffice' ),
						'type'  => 'select',
						'value' => 'bottom',
						'desc' => __('Vertical alignment here','woffice'),
						'choices' => array(
					        'center' => __( 'Center', 'woffice' ),
					        'bottom' => __( 'Bottom', 'woffice' ),
					        'top' => __( 'Top', 'woffice' )
					    )
					),
					'main_featured_height' => array(
						'label' => __( 'Height of the page title box', 'woffice' ),
						'type'  => 'short-text',
						'value' => '240',
						'desc' => __('In pixels pixels please, but without the PX','woffice'),
						'help' => __('Just a number without the PX','woffice')
					),
                    'main_featured_font_size' => array(
                        'label' => __( 'Font Size of the page title', 'woffice' ),
                        'type'  => 'short-text',
                        'value' => '56',
                        'desc' => __('In pixels pixels please, but without the PX','woffice'),
                        'help' => __('Just a number without the PX','woffice')
                    ),
					'main_featured_uppercase' => array(
						'label' => __( 'Headline text in uppercase ?', 'woffice' ),
						'type'  => 'checkbox',
						'value' => true
					),
					'main_featured_bold' => array(
						'label' => __( 'Font weight: bold ?', 'woffice' ),
						'type'  => 'checkbox',
						'value' => true
					),
					'main_featured_color' => array(
						'label' => __( 'Headline Color', 'woffice' ),
						'type'  => 'color-picker',
						'value' => '#FFF',
						'desc' => __('This is the color of the headline.','woffice')
					),
					'main_featured_opacity' => array(
						'label' => __( 'Layer Opacity', 'woffice' ),
						'type'  => 'short-text',
						'value' => '0.8',
						'desc' => __('This is the opacity of the layer behind the page title and over the featured image','woffice'),
						'help' => __('A number between 0 - 1, if you choose 0 it will becomes hidden.','woffice')
					),
					'main_featured_bg' => array(
						'label' => __( 'Layer Color', 'woffice' ),
						'type'  => 'color-picker',
						'value' => '#82b440',
						'desc' => __('This is the color of the layer behind the page title and over the featured image','woffice')
					),
					'main_featured_border' => array(
						'label' => __( 'Show border bottom', 'woffice' ),
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
						'desc' => __('This is the colored border below this title box.','woffice')
					),
					'main_featured_border_color' => array(
					    'type'  => 'color-picker',
					    'value' => '#82B440',
						'label' => __( 'Border color', 'woffice' ),
					    'desc'  => __('Color of the border below the the box title.', 'woffice')
					),
                    'auto_height_featured_image' => array(
                        'label' => __( 'Height of featured image of elements', 'woffice' ),
                        'type'         => 'switch',
                        'right-choice' => array(
                            'value' => 'fixed',
                            'label' => __( 'Fixed', 'woffice' )
                        ),
                        'left-choice'  => array(
                            'value' => 'auto',
                            'label' => __( 'Auto', 'woffice' )
                        ),
                        'value'        => 'fixed',
                        'desc' => __('This is the featured image of elements like as blog posts, projects, etc. This option does not work in masonry layout.','woffice')
                    ),
				)
			),
		)
	)
);