<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
if (class_exists( 'multiverso_mv_category_files' )):
	$tt_mvs = array();
	$args = array('post_type' => 'multiverso', 'posts_per_page' => -1);
	$tt_mv_obj = get_posts( $args );    
	foreach ($tt_mv_obj as $tt_mv) {
	$tt_mvs[$tt_mv->ID] = $tt_mv->post_title; }
	
	$tt_categories = array();
	$args2 = array('multiverso-categories');
	$tt_category_obj = get_terms( 'multiverso-categories', array( 'hide_empty' => 0 ));    
	foreach ($tt_category_obj as $tt_category) {
	$tt_categories[$tt_category->term_id] = $tt_category->name; }
else:
	$tt_mvs = array("nothing" => "Plugin Multiverso is not activated");
	$tt_categories = array("nothing" => "Plugin Multiverso is not activated");
endif;

$options = array(
	'mv_kind' => array(
	    'type'  => 'select',
	    'label' => __('Content :', 'woffice'),
	    'desc'  => __('Choose here what you want to generate', 'woffice'),
	    'choices' => array(
	    	'all_files' => __('All files','woffice'),
	    	'single' => __('Single File','woffice'),
	    	'category' => __('Files Category','woffice'),
	    	'management' => __('Files Manager','woffice'),
	    ),
	),
	'mv_single' => array(
	    'type'  => 'select',
	    'label' => __('Select File :', 'woffice'),
	    'desc'  => __('(If you have chosen -> Single file)', 'woffice'),
	    'choices' => $tt_mvs
	),
	'mv_category' => array(
	    'type'  => 'select',
	    'label' => __('Select Category :', 'woffice'),
	    'desc'  => __('(If you have chosen -> Files Category)', 'woffice'),
	    'choices' => $tt_categories
	),
);