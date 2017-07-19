<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
$color_colored 		 = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('color_colored') : ''; 
$options = array(
	'label'  => array(
		'label' => __( 'Button Label', 'woffice' ),
		'desc'  => __( 'This is the text that appears on your button', 'woffice' ),
		'type'  => 'text',
		'value' => 'Learn More'
	),
	'link'   => array(
		'label' => __( 'Button Link', 'woffice' ),
		'desc'  => __( 'Where should your button link to', 'woffice' ),
		'type'  => 'text',
		'value' => '#'
	),
    'target' => array(
        'type'  => 'switch',
		'label'   => __( 'Open Link in New Window', 'woffice' ),
		'desc'    => __( 'Select here if you want to open the linked page in a new window', 'woffice' ),
        'right-choice' => array(
            'value' => '_blank',
            'label' => __('Yes', 'woffice'),
        ),
        'left-choice' => array(
            'value' => '_self',
            'label' => __('No', 'woffice'),
        ),
    ),
    'icon'  => array(
		'label' => __( 'Button icon', 'woffice' ),
		'desc'    => __( 'Choose an icon for your button just before the label', 'woffice' ),
		'type'  => 'icon',
		'value' => 'fa fa-book'
	),
    'size'  => array(
		'label' => __( 'Button size', 'woffice' ),
		'desc'    => __( 'Choose a size for your button', 'woffice' ),
		'type'  => 'select',
		'value' => 'btn-medium',
        'choices' => array(
            'btn-sm' => __('Small', 'woffice'),
            'btn-medium' => __('Default', 'woffice'),
            'btn-lg' => __('Large', 'woffice'),
        ),
	),
    'color'  => array(
		'label' => __( 'Button color', 'woffice' ),
		'desc'    => __( 'Choose a color for your button background', 'woffice' ),
		'type'  => 'color-picker',
		'value' => $color_colored,
	)
);