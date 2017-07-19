<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
/**
 * Framework options
 *
 * @var array $options Fill this array with options to generate framework settings form in backend
 */
// GET ALL USERS 
//Access the WordPress USERNAMES via an Array
$tt_users = array();
$tt_users_obj = get_users(array( 'fields' => array( 'ID', 'user_nicename' )));    
foreach ($tt_users_obj as $tt_user) {
$tt_users[$tt_user->ID] = $tt_user->user_nicename; }
$tt_users_tmp = array('nope' => __("No one","woffice")) + $tt_users; 

$options = array(
	'project-box' => array(
		'title'   => __( 'Project settings ', 'woffice' ),
		'type'    => 'box',
		'options' => array(
			'project_progress'    => array(
				'label' => __( 'Project Progress', 'woffice' ),
				'desc'  => __( 'How do you want to track the progress on this project ?', 'woffice' ),
				'type'         => 'switch',
				'right-choice' => array(
					'value' => 'tasks',
					'label' => __( 'Tasks', 'woffice' )
				),
				'left-choice'  => array(
					'value' => 'time',
					'label' => __( 'Time', 'woffice' )
				),
				'value'        => 'time',
			),
			'project_date_start' => array(
			    'type'  => 'date-picker',
			    'label' => __('Project Starting Date', 'woffice'),
			    'desc'  => __('Will be used for the progress bar on the single project page and in the widget.', 'woffice'),
			    'min-date' => date('1-0-2000'),
			),
			'project_date_end' => array(
			    'type'  => 'date-picker',
			    'label' => __('Project Ending Date', 'woffice'),
			    'desc'  => __('Will be used for the progress bar on the single project page and in the widget.', 'woffice'),
			    'min-date' => null,
			),
			'project_members' => array(
			    'type'  => 'select-multiple',
			    'label' => __('Project Members', 'woffice'),
				'help'  => __('Help tip : Hold Ctrl to select multiple users.', 'woffice'),
			    'desc'  => __('They will be allowed to modify the project from the single page and view it of course.', 'woffice'),
			    'choices' => $tt_users
			),
			'project_files' => array(
			    'type'  => 'checkbox',
			    'label' => __('Project Files', 'woffice'),
			    'desc'  => __('If it is checked, a directory will be created in your directory 1 set in your File Away settings. See the following link for details informations :', 'woffice'). 'https://2f.ticksy.com/article/5099/',
			    'value' => TRUE
			),
			'project_edit' => array(
			    'type'  => 'select',
			    'label' => __('Allow edit', 'woffice'),
			    'desc'  => __('Allowing the frontend edit from the users allowed to see the project, this may not be a good idea if you are using the page builder on that page. You can also choose in the other options.', 'woffice'),
			    'choices' => array(
			        'frontend-edit' => __('Frontend Edit', 'woffice'),
			        'backend-edit' => __('Backend Edit link', 'woffice'),
			        'no-edit' => __('No Edit icon', 'woffice'),
			    ),
			    'value' => 'frontend-edit'
			),
            'only_author_can_edit' => array(
                'type'  => 'checkbox',
                'label' => __('Only author can edit', 'woffice'),
                'desc'  => __('If it is checked, only author and admin are able to modify the project, otherwise all members will be allowed to do it.', 'woffice'),
                'value' => FALSE
            ),
			'project_links' => array(
			    'type'  => 'addable-box',
			    'label' => __('Project extern Links', 'woffice'),
			    'desc'  => __('You can add here extern links related to the projects.', 'woffice'),
			    'template' => 'Link : {{- title }}',
			    'box-options' => array(
			        'title' => array( 'type' => 'text', 'label' => __('Name', 'woffice')),
			        'href' => array( 'type' => 'text', 'label' => __('Link', 'woffice')),
			        'icon' => array( 'type' => 'icon', 'label' => __('Icon', 'woffice'),'value' => 'fa-arrow-right',),			    
			    ),
			),
			'project_todo' => array(
			    'type'  => 'checkbox',
			    'label' => __('Project Todo', 'woffice'),
			    'desc'  => __('If it is checked, a todo tab will be displayed and the project members will be able to create tasks for the project. Note it\ll be overwritten if you enter a Wunderlist List ID below.', 'woffice'),
			    'value' => TRUE
			),
			'project_todo_lists' => array(
			    'type'  => 'addable-box',
			    'label' => __('Project Todo tasks', 'woffice'),
			    'desc'  => __('It can be edited on the frontend by the projects member.', 'woffice'),
			    'template' => 'Task : {{- title }}',
			    'box-options' => array(
			        'title' => array( 'type' => 'text', 'label' => __('Name', 'woffice')),
			        'done' => array( 'type' => 'checkbox', 'label' => __('Done ?', 'woffice')),
			        'date' => array( 'type' => 'date-picker', 'label' => __('Due Date ?', 'woffice'),'min-date' => date('1-0-2000')),
			        'note' => array( 'type' => 'textarea', 'label' => __('Note ?', 'woffice')),		    
			        'assigned' => array( 
			        	'type' => 'select-multiple',
			        	'label' => __('Specific member ?', 'woffice'),
			        	'choices' => $tt_users_tmp,
						'desc'  => __('If you have already some project\s member, the selected user have to be one of them.', 'woffice'),
			        ),
			        'email_sent' => array( 'type' => 'hidden', 'value' => 'not_sent'),
			    ),
			),
			'project_wunderlist' => array(
			    'type'  => 'text',
			    'label' => __('Wunderlist List ID', 'woffice'),
			    'help' => __('The xxxxx in https://www.wunderlist.com/list/xxxxx', 'woffice'),
			    'desc'  => __('You can set here a Wunderlist list ID, once it is PUBLISHED. However, this is an experimental feature for now, because your list will be public but only the persons with the link will be able to see it ', 'woffice'),
			),
			'project_calendar' => array(
			    'type'  => 'checkbox',
			    'label' => __('Calendar sync', 'woffice'),
			    'desc'  => __('If it is checked, an event will be added to eventON calendar when the post is created.', 'woffice'),
			    'value' => FALSE
			),
		)
	),
);
