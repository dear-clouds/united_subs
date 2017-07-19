<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'widgets' => array(
		'title'   => __( 'Custom Widgets', 'woffice' ),
		'type'    => 'tab',
		'options' => array(
			// HTML INFORMATIONS
			'widgets-info' => array(
			    'type'  => 'html',
			    'html'  => '<span class="dashicons dashicons-info"></span> Info : Once the widgets settings filled, you can use them through the widgets page in <b>Appearance -> Widgets custom</b>',
			),
			'funfacts-box' => array(
				'title'   => __( 'Fun Facts Widget', 'woffice' ),
				'type'    => 'box',
				'options' => array(
					'funfacts' => array(
					    'type'  => 'addable-box',
					    'value' => array(
					        array(
					            'fact_content' => 'Anything you like here...',
					            'fact_icon' => 'fa-star',
					        )
					    ),
					    'label' => __('Fun facts', 'woffice'),
					    'desc'  => __('They will be displayed as in a slider within the widget, you can use for any other purpose than fun facts.', 'woffice'),
					    'box-options' => array(
					        'fact_content' => array(
					        	'type' => 'textarea',
					        	'title'   => __( 'Content', 'woffice' ),
					        ),
					        'fact_icon' => array(
					        	'type' => 'icon',
					        	'title'   => __( 'Icon', 'woffice' ),
					        ),
					    ),
					    'box-controls' => array( // buttons next to (x) remove box button
					        'control-id' => '<small class="dashicons dashicons-smiley"></small>',
					    ),
					    'limit' => 18, // limit the number of boxes that can be added
					)
				)
			),
			'poll-box' => array(
				'title'   => __( 'Poll Widget', 'woffice' ),
				'type'    => 'box',
				'options' => array(
					'sidebar_position' => array(
						'label' => __( 'Sidebar Position', 'woffice' ),
						'type'         => 'switch',
						'right-choice' => array(
							'value' => 'left',
							'label' => __( 'Left', 'woffice' )
						),
						'left-choice'  => array(
							'value' => 'right',
							'label' => __( 'Right', 'woffice' )
						),
						'value'        => 'right',
					),
				)
			),
		)
	)
);