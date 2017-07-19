<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$ext_instance = fw()->extensions->get( 'woffice-directory' );

$options = array(
	'build' => array(
		'type'    => 'tab',
		'title'   => __( 'Settings', 'woffice' ),
		'options' => array(
			'directory-box' => array(
				'title'   => __( 'Main Options', 'woffice' ),
				'type'    => 'box',
				'options' => array(
					'custom_post_name' => array(
					    'type'  => 'text',
					    'label' => __('Directory item name', 'woffice'),
					    'desc'  => __('This is the name in the Wordpress menus, like Job, Partners, Corporates...', 'woffice'),
						'value'        => 'Item',
					),
					'map_zoom' => array(
					    'type'  => 'slider',
					    'value' => '2',
					    'properties' => array(
					        'min' => 0,
					        'max' => 21,
					        'sep' => 1,
					    ),
					    'label' => __('Zoom level', 'woffice'),
					    'desc'  => __('Just the level of zooming in the map (Main directory page).', 'woffice'),
					),
					'map_center' => array(
					    'type'  => 'map',
					    'value' => array(
					        'coordinates' => array(
					            'lat'   => 0,
					            'lng'   => 0,
					        )
					    ),
					    'label' => __('Center', 'woffice'),
					    'desc'  => __('This is the center of the map (Main directory page).', 'woffice'),
					),
					'default_fields' => array(
					    'type'  => 'addable-box',
					    'label' => __('Default fields', 'woffice'),
					    'desc'  => __('This is the default fields displayed on all the directory single page, if it is empty you\'ll be able to choose different fields for every item.', 'woffice'),
					    'template' => 'Field : {{- title }}',
					    'box-options' => array(
					        'title' => array( 'type' => 'text', 'label' => __('Name', 'woffice')),
					        'default' => array( 'type' => 'text', 'label' => __('Default value', 'woffice')),
					        'icon' => array( 'type' => 'icon', 'label' => __('Icon', 'woffice'),'value' => 'fa-star',),			    
					    ),
					),
					
				),
			),
		),
	),
);