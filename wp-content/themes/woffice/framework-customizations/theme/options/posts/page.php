<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
/**
 * Framework options
 *
 * @var array $options Fill this array with options to generate framework settings form in backend
 */
 
/* Roles array ready for options */
global $wp_roles;
$tt_roles = array();
foreach ($wp_roles->roles as $key=>$value){
$tt_roles[$key] = $value['name']; }
$tt_roles_tmp = array('nope' => __("Everyone","woffice")) + $tt_roles;
/* End */

/* Users array ready for options */
$tt_users = array();
$tt_users_obj = get_users(array( 'fields' => array( 'ID', 'user_nicename' )));    
foreach ($tt_users_obj as $tt_user) {
$tt_users[$tt_user->ID] = $tt_user->user_nicename; }
$tt_users_tmp = array('99999999999999' => __("Select users :","woffice")) + $tt_users;
/* End */

/* Get the revolution SLIDERS and Unyson Sliders */
$sliders = array();
$revsliders = array();
$fwsliders = array();
if (shortcode_exists('rev_slider')) {
	$sliders[0] = 'Select a slider';
	global $wpdb;
	$get_sliders = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'revslider_sliders');
	if($get_sliders) {
		foreach($get_sliders as $slider) {
			$revsliders[$slider->alias] = $slider->title;
		}
	}
}
if (class_exists('FW_Extension_Slider')) {
	if (!shortcode_exists('rev_slider')){
		$sliders[0] = 'Select a slider';
	}
	$fw_custom_query = get_posts( array('showposts'=> -1, 'post_type' => 'fw-slider' ));
	if ( !empty($fw_custom_query) ) { 
		foreach ( $fw_custom_query as $post ) : 
			
			$post_id = $post->ID;
			$post_title = get_the_title($post_id);
			
			$fwsliders[$post_id] = $post_title;
			
		endforeach;
		wp_reset_postdata();
	}
}
if (empty($revsliders) && empty($fwsliders)){
	$sliders[0] = 'Revolution Slider & Slider Extension are not enabled';
}
$sliders =  $sliders + $fwsliders + $revsliders;
/* End */

$options = array(
	'page-box' => array(
		'title'   => __( 'Page settings ', 'woffice' ),
		'type'    => 'box',
		'options' => array(
			'hastitle'    => array(
				'label'   => __( 'Hide the title', 'woffice' ),
				'desc'  => __( 'Only the featured image will be visible, the title will be hidden.', 'woffice' ),
				'type'  => 'checkbox',
				'value' => false
			),
			'exclude_members' => array(
			    'type'  => 'select-multiple',
			    'label' => __('Exclude Members', 'woffice'),
				'help'  => __('Help tip : Hold Ctrl to select multiple users.', 'woffice'),
			    'desc'  => __('The excluded members will not be able to see that page, they will receive an error message instead.', 'woffice'),
			    'choices' => $tt_users_tmp
			),
			'exclude_roles' => array(
			    'type'  => 'select-multiple',
			    'label' => __('Exclude Roles', 'woffice'),
				'help'  => __('Help tip : Hold Ctrl to select multiple roles.', 'woffice'),
			    'desc'  => __('The excluded roles will not be able to see that page, they will receive an error message instead. ', 'woffice'),
			    'choices' => $tt_roles_tmp
			),
			'logged_only'    => array(
				'label'   => __( 'Only for logged users', 'woffice' ),
				'desc'  => __( 'If your website is public you can hide this page from non-logged users, they will find a link to the login page.', 'woffice' ),
				'type'  => 'checkbox',
				'value' => false
			),
			'revslider_featured' => array(
			    'type'  => 'select',
			    'label' => __('Add a slider', 'woffice'),
			    'desc'  => __('This will override the page title box (image & title), you\'ll have the selected Slider instead.', 'woffice'),
			    'choices' => $sliders
			),
			/*
			'featuredopacity' => array(
				'label' => __( 'Layer Opacity', 'woffice' ),
				'type'  => 'short-text',
				'value' => '0.5',
				'desc' => __('This is the opacity of the layer behind the page title and over the featured image','woffice'),
				'help' => __('A number between 0 - 1','woffice')
			),
			'featuredcolor' => array(
				'label' => __( 'Layer Color', 'woffice' ),
				'type'  => 'color-picker',
				'value' => '#000',
				'desc' => __('This is the color of the layer behind the page title and over the featured image','woffice')
			),*/
		)
	),
);
