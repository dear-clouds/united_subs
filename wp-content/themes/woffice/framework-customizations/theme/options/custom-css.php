<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'custom-css' => array(
		'title'   => __( 'Custom CSS', 'woffice' ),
		'type'    => 'tab',
		'options' => array(
			'css-box' => array(
				'title'   => __( 'Custom CSS, JS', 'woffice' ),
				'type'    => 'box',
				'options' => array(
					'custom_css' => array(
						'label' => __( 'Type your custom CSS here ', 'woffice' ),
						'type'  => 'textarea',
						'desc' => __('No need to set the tags (&lt;style&gt;&lt;/style&gt;). It is better to change the CSS changes here than editing the theme files ;) or you can create a child theme if you have a lot of changes.','woffice'),
						'help' => __('Without the HTML tags "style" please','woffice'),
					),
					'custom_js' => array(
						'label' => __( 'Type your custom Jquery/Javascript here ', 'woffice' ),
						'type'  => 'textarea',
						'desc' => __('No need to set the tags (&lt;script&gt;&lt;/script&gt;). It will understands the "$", all is wrapped in a Jquery function.','woffice'),
						'help' => __('Without the HTML tags "script" please','woffice'),
					),
				)
			),
		)
	)
);