<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$ext_instance = fw()->extensions->get( 'woffice-poll' );

$array = $ext_instance->woffice_poll_get_results_backend();

$options = array(
	'build' => array(
		'type'    => 'tab',
		'title'   => __( 'Build Poll', 'woffice' ),
		'options' => array(
			'information' => array(
				'label' => __( 'Information :', 'woffice' ),
				'type'  => 'html',
				'html'  => 'All the answers, results and users votes can be refreshed when you deactivate/activate the poll extension.',
			),
			'name' => array(
				'label' => __( 'Poll Question', 'woffice' ),
				'type'  => 'text',
			),
			/*'type' => array(
				'label' => __( 'Questions type', 'woffice' ),
				'type'  => 'switch',
				'value' => 'checkbox',
				'desc'  => __('You can choose here, if user can pick only one answer (radio buttons) or several (checkbox )', 'woffice'),
				'left-choice' => array(
			        'value' => 'checkbox',
			        'label' => __('Checkbox', 'woffice'),
			    ),
			    'right-choice' => array(
			        'value' => 'radio',
			        'label' => __('Radio Buttons', 'woffice'),
			    ),
			),*/
			'answers' => array(
				'label' => __( 'Poll answers', 'woffice' ),
				'type'  => 'addable-option',
				'desc'  => __('These questions will be displayed within the widget in Woffice.', 'woffice'),
				'option' => array( 'type' => 'text' ),
				'value' => array('Answer 1'),
			),
			'logged_only' => array(
				'label' => __( 'Only for logged Users', 'woffice' ),
				'type'  => 'checkbox',
				'value' => true
			),
		)
	),
	'results' => array(
		'type'    => 'tab',
		'title'   => __( 'Results', 'woffice' ),
		'options' => $array
	)
);
