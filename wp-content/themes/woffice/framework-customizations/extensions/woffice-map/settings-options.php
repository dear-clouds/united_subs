<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$ext_instance = fw()->extensions->get( 'woffice-map' );

$status = $ext_instance->woffice_map_api_status();

$options = array(
	'build' => array(
		'type'    => 'tab',
		'title'   => __( 'Users Map', 'woffice' ),
		'options' => array(
			'map_api' => array(
				'title'   => __( 'Google API Public Key', 'woffice' ),
				'type'    => 'text',
				'value' => 'AIzaSyAyXqXI9qYLIWaD9gLErobDccodaCgHiGs',
				'desc'  => __('We are using the GeoCoding Google API to get coordinates from users locations. By default it is working with our API key but as there are many Woffice around, the Quota (2500 requests per day) may be reached really quickly so the map will no longer be available. That is why it is important to use you own Google API key. Please see : ', 'woffice'). '<a href="https://2f.ticksy.com/article/4227/">Tutorial</a>',
			),
			'map_status' => array(
				'title'   => __( 'Google API Status', 'woffice' ),
				'type'    => 'html',
				'html'  => 'This is the status of your GeoCoding API connection (helps for debugging) :<br> <span class="highlight">'.$status.'</span>',
			),
			'map_field_name' => array(
				'type' => 'text',
				'label' => __('Field\'s name', 'woffice'),
				'desc' => __('This is the name of the field available in the user\'s profile', 'woffice'),
				'value' => 'Location',
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
			    'desc'  => __('Just the level of zooming in the map.', 'woffice'),
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
			    'desc'  => __('This is the center of the map.', 'woffice'),
			)
		)
	),
);