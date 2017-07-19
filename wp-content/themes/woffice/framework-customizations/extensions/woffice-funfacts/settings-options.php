<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$ext_instance = fw()->extensions->get( 'woffice-funfacts' );

$options = array(
	'build' => array(
		'type'    => 'tab',
		'title'   => __( 'Fun Facts', 'woffice' ),
		'options' => array(
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
						'template' => 'Item', // box title
					    'box-controls' => array( // buttons next to (x) remove box button
					        'control-id' => '<small class="dashicons dashicons-smiley"></small>',
					    ),
					    'limit' => 18, // limit the number of boxes that can be added
					)
				)
			)
		)
	),
);