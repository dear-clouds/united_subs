<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
/**
 * Framework options
 *
 * @var array $options Fill this array with options to generate framework settings form in backend
 */
// Check for default Options : 
$default_fields = fw_get_db_ext_settings_option('woffice-directory', 'default_fields');
if (!empty($default_fields)) {
	
	$default_fields_array = array();
	
	$counter = 1;
	
	foreach($default_fields as $default_field) {
		
		$title_r = (!empty($default_field['title'])) ? $default_field['title'] : '';
		$value_r = (!empty($default_field['default'])) ? $default_field['default'] : '';
		
		$default_fields_array[$counter.'-content'] = array(
			'type' => 'text',
			'label' => $title_r,
			'value' => $value_r,
		);
		
		$counter++;	
		
	}
	
	// THERE IS SOME DEFAULT OPTIONS 
	$options_ready = array(
		'type' => 'group',
		'title' => __('Custom fields', 'woffice'),
		'options' => $default_fields_array
	);
	
}
else {
	
	$options_ready =  array(
	    'type'  => 'addable-box',
	    'label' => __('Custom fields', 'woffice'),
	    'desc'  => __('You can add any data here (salary,population,dates,birthdays...anything you like).', 'woffice'),
	    'template' => 'Field : {{- title }}',
	    'box-options' => array(
	        'title' => array( 'type' => 'text', 'label' => __('Content', 'woffice')),
	        'icon' => array( 'type' => 'icon', 'label' => __('Icon', 'woffice'),'value' => 'fa-star'),			    
	    ),
	);
	
}

$options = array(
	'directory-item-box' => array(
		'title'   => __( 'Item settings ', 'woffice' ),
		'type'    => 'box',
		'options' => array(
			'item_location' => array(
			    'type'  => 'map',
			    'label' => __('Location', 'woffice'),
			    'desc'  => __('The location will be visible in the main directory page & single page.', 'woffice'),
			),
			'item_fields' => $options_ready,
			'item_button_text' => array(
			    'type'  => 'text',
			    'label' => __('Button text', 'woffice'),
			    'desc'  => __('If you fill this option, you\'ll the possibility to add a button on the single page (can link to a form within your site or an extern URL). If you leave it empty, it won\'t be displayed.', 'woffice'),
			),
			'item_button_link' => array(
			    'type'  => 'text',
			    'label' => __('Button link', 'woffice'),
			),
			'item_button_icon' => array(
			    'type'  => 'icon',
			    'label' => __('Button Icon', 'woffice'),
			),
		)
	),
);
