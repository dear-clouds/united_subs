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
	'type' => array(
	    'type'  => 'select',
	    'label' => __('Type :', 'woffice'),
	    'desc'  => __('What do you want to display ?', 'woffice'),
	    'value' => 'user_list',
	    'choices' => array(
		    'user_list' => __('Current User data (Courses, scores, certificates..)','woffice'),
		    'courses_list' => __('Courses list','woffice'),
		    'lessons_list' => __('Lessons list','woffice'),
		    'quizzes_list' => __('Quizzes list','woffice'),
		    'course_content' => __('Course\'s content','woffice'),
	    )
	),
	'info' => array(
		'type'  => 'html',
		'label' => __('Info', 'woffice'),
		'html'  => __('The next options are only if you have selected Course, Lessons, Quizzes list in the option above.', 'woffice'),
	),
	'num' => array(
	    'type'  => 'slider',
	    'label' => __('Number :', 'woffice'),
	    'properties' => array(
        	'min' => 0,
			'max' => 100,
			'sep' => 1
		),
		'value'        => '10',
	),
	'order' => array(
	    'type'  => 'switch',
	    'label' => __('order :', 'woffice'),
	    'right-choice' => array(
			'value' => 'ASC',
			'label' => __( 'Ascending', 'woffice' )
		),
		'left-choice'  => array(
			'value' => 'DESC',
			'label' => __( 'Descending', 'woffice' )
		),
		'value'        => 'ASC',
	),
	'tag' => array(
	    'type'  => 'text',
	    'label' => __('Optional Tag :', 'woffice'),
	    'desc'  => __('Display only the ones from a specific tag. We need its slug here.', 'woffice')
	),
	'category' => array(
	    'type'  => 'text',
	    'label' => __('Optional Category :', 'woffice'),
	    'desc'  => __('Display only the ones from a specific category. We need its slug here.', 'woffice')
	),
	'only_current_user' => array(
	    'type'  => 'checkbox',
	    'label' => __('For the current user :', 'woffice'),
	    'desc'  => __('Display the data only for the current user ? (Not all courses, but his courses for example). ONLY FOR THE COURSES', 'woffice'),
	    'value' => false
	),
);