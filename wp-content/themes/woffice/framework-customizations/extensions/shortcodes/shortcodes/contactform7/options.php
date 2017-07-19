<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
//Access the WordPress Contact Fort via an Array
$tt_forms = array();
$args = array('post_type' => 'wpcf7_contact_form', 'posts_per_page' => -1);
$tt_forms_obj = get_posts( $args );    
foreach ($tt_forms_obj as $tt_form) {
$tt_forms[$tt_form->ID] = $tt_form->post_title; }

$options = array(
	'contact_form' => array(
	    'type'  => 'select',
	    'label' => __('Choose a form :', 'woffice'),
	    'desc'  => __('You need to have installed before the Plugin Contact Form 7.', 'woffice'),
	    'choices' => $tt_forms
	)
);