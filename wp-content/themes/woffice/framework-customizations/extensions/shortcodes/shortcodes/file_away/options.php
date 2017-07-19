<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'file_away_kind' => array(
	    'type'  => 'select',
	    'label' => __('Content', 'woffice'),
	    'desc'  => __('Choose here what you want to generate', 'woffice'),
	    'choices' => array(
	    	'fileaway' => __('Directory View','woffice'),
	    	'fileup' => __('Files Upload','woffice'),
	    ),
	    'value' => 'directory'
	),
	'file_away_directory' => array(
	    'type'  => 'select',
	    'label' => __('Select a directory', 'woffice'),
	    'choices' => array(
		    '1' => '1',
		    '2' => '2',
		    '3' => '3',
		    '4' => '4',
		    '5' => '5',
	    ), 
	    'value' => '1'
	),
	'file_away_sub' => array(
	    'type'  => 'text',
	    'label' => __('Optional Sub directory', 'woffice'),
	    'desc' => __('The path to a sub directory from the directory you have choose in the last option. Like : test/ ', 'woffice'), 
	),
    'file_away_customattr' => array(
        'type'  => 'text',
        'label' => __('Additional attributes', 'woffice'),
        'desc' => __('If you want add additional attributes, you can just put here, separating them with a space. Example: manager=on images=only', 'woffice'),
    ),
	'file_away_info' => array(
	    'type'  => 'html',
	    'label' => __('File Away Info', 'woffice'),
	    'html' => __('If you need more options about this, please use the default shortcode generator from the plugin, it is slower but you\'ll find more options. You can also have  a look on this article for more details', 'woffice'). '<a href="https://2f.ticksy.com/article/5099/" target="_blank">https://2f.ticksy.com/article/5099/</a>', 
	),
);