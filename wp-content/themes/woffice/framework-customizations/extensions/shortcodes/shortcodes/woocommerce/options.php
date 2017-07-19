<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'woocommerce_title'  => array(
		'label' => __( 'Headline', 'woffice' ),
		'desc'  => __( 'This is the heading that appears above the carousel', 'woffice' ),
		'type'  => 'text',
		'value' => 'Our Products'
	),
	'woocommerce_type' => array(
	    'type'  => 'select',
	    'label' => __('Type :', 'woffice'),
	    'desc'  => __('You need to have installed before the Plugin Woocommerce.', 'woffice'),
	    'choices' => array(
	    	'recent_products' => __('Recent Products','woffice'),
	    	'featured_products' => __('Featured Products','woffice'),
	    	'products' => __('Products','woffice'),
	    	'top_rated_products' => __('Top Rated Products','woffice'),
	    	'related_products' => __('Releated Products','woffice'),
	    ),
	    'value' => 'products'
	),
	'woocommerce_order_by' => array(
	    'type'  => 'select',
	    'label' => __('Order by :', 'woffice'),
	    'choices' => array(
	    	'menu_order' => __('Menu Order','woffice'),
	    	'title' => __('Title','woffice'),
	    	'date' => __('Date','woffice'),
	    	'rand' => __('Rand','woffice'),
	    	'id' => __('ID','woffice'),
	    ),
	    'value' => 'date'
	),
    'woocommerce_order' => array(
        'type'  => 'switch',
		'label'   => __( 'Order', 'woffice' ),
		'desc'    => __( 'This is the order of the products', 'woffice' ),
        'right-choice' => array(
            'value' => 'asc',
            'label' => __('ASC', 'woffice'),
        ),
        'left-choice' => array(
            'value' => 'desc',
            'label' => __('DESC', 'woffice'),
        ),
	    'value' => 'asc'
    ),
    'woocommerce_per_page' => array(
        'type'  => 'slider',
        'properties' => array(
	        'min' => 0,
	        'max' => 24,
	        'sep' => 1,
	    ),
		'label'   => __( 'How many ?', 'woffice' ),
		'desc'    => __( 'How many products do you want to show, they\'ll be added in a 4 columns carousel.', 'woffice' ),
	    'value' => '8'
    ),
);