<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

/* Roles array ready for options */
global $wp_roles;
$tt_roles = array();
foreach ($wp_roles->roles as $key=>$value){
$tt_roles[$key] = $value['name']; }
$tt_roles_tmp = array('nope' => __("No one","woffice")) + $tt_roles;
/* End */

$options = array(
	'wiki' => array(
		'title'   => __( 'Posts/Wiki/Projects', 'woffice' ),
		'type'    => 'tab',
		'options' => array(
			'frontend_state' => array(
				'label'   => __( 'Post Status on frontend creation', 'woffice' ),
				'desc'  => __( 'When the post is submitted, you can choose if it is directly published or need you approval first.', 'woffice' ),
				'type'    => 'select',
				'choices' => array(
					'draft' => __('Draft', 'woffice'),
					'publish' => __('Publish', 'woffice'),
					'pending' => __('Pending', 'woffice')
				),
				'value' => 'publish'
			),
			'wiki-box' => array(
				'title'   => __( 'Wiki Options', 'woffice' ),
				'type'    => 'box',
				'options' => array(
					'wiki_create' => array(
						'label' => __( 'Who can create a Wiki article ?', 'woffice' ),
						'desc'  => __( 'It is only affecting a front end button on the main wiki page. The roles with post edit capabilities will still be able to create Wiki from the backend.', 'woffice' ),
						'type'         => 'select-multiple',
						'choices'      => $tt_roles_tmp,
						'value'        => 'administrator',
					),
					'wiki_excluded_categories'    => array(
						'label' => __( 'Wiki Exclude categories', 'woffice' ),
						'desc'  => __( 'Do you want to exclude categories from the Wiki page ?', 'woffice' ),
						'type'         => 'multi-select',
						'population' => 'taxonomy',
      					'source' => 'wiki-category',
					),
                    'enable_wiki_like'    => array(
						'label' => __( 'Display like button', 'woffice' ),
						'desc'  => __( 'Do you want display wiki button and counter for wiki elements?', 'woffice' ),
						'type'         => 'switch',
						'right-choice' => array(
							'value' => 'yep',
							'label' => __( 'Yep', 'woffice' )
						),
						'left-choice'  => array(
							'value' => 'nope',
							'label' => __( 'Nope', 'woffice' )
						),
						'value'        => 'yep',
					),
                    'enable_wiki_accordion'    => array(
                        'label' => __( 'Enable collapsing of sub categories', 'woffice' ),
                        'desc'  => __( 'Do you want enable an accordion for subcategories of wiki? (they will be closed by default)', 'woffice' ),
                        'type'         => 'switch',
                        'right-choice' => array(
                            'value' => 'yep',
                            'label' => __( 'Yep', 'woffice' )
                        ),
                        'left-choice'  => array(
                            'value' => 'nope',
                            'label' => __( 'Nope', 'woffice' )
                        ),
                        'value'        => 'nope',
                    ),
                    'wiki_sortbylike'    => array(
                        'label' => __( 'Enable Sorting of wiki by likes', 'woffice' ),
                        'desc'  => __( 'Do you want add a button to wiki list that allow to sort the result by likes?', 'woffice' ),
                        'type'         => 'switch',
                        'right-choice' => array(
                            'value' => 'yep',
                            'label' => __( 'Yep', 'woffice' )
                        ),
                        'left-choice'  => array(
                            'value' => 'nope',
                            'label' => __( 'Nope', 'woffice' )
                        ),
                        'value'        => 'nope',
                    ),
				),
			),
			'projects-box' => array(
				'title'   => __( 'Projects Options', 'woffice' ),
				'type'    => 'box',
				'options' => array(
					'projects_create' => array(
						'label' => __( 'Who can create a project article ?', 'woffice' ),
						'desc'  => __( 'It is only affecting a front end button on the main projects page. The roles with post edit capabilities will still be able to create Projects from the backend.', 'woffice' ),
						'type'         => 'select-multiple',
						'choices'      => $tt_roles_tmp,
						'value'        => 'administrator',
					),
					'projects_public'    => array(
						'label' => __( 'Are the projects public ?', 'woffice' ),
						'desc'  => __( 'If it is "Yep", every non logged users can view the project but not edit them.', 'woffice' ),
						'type'         => 'switch',
						'right-choice' => array(
							'value' => 'yep',
							'label' => __( 'Yep', 'woffice' )
						),
						'left-choice'  => array(
							'value' => 'nope',
							'label' => __( 'Nope', 'woffice' )
						),
						'value'        => 'nope',
					),
					'projects_assigned_email'    => array(
						'label' => __( 'Notice user on task assignment ?', 'woffice' ),
						'desc'  => __( 'Do you want to notice the user by email when a project task is assigned to the user ?', 'woffice' ),
						'type'         => 'switch',
						'right-choice' => array(
							'value' => 'yep',
							'label' => __( 'Yep', 'woffice' )
						),
						'left-choice'  => array(
							'value' => 'nope',
							'label' => __( 'Nope', 'woffice' )
						),
						'value'        => 'nope',
					),
					'projects_assigned_email_content'    => array(
						'label' => __( 'Email\'s content', 'woffice' ),
						'desc'  => __( 'This is the content of the email before the task name.', 'woffice' ),
						'type'         => 'textarea',
						'value'        => 'You have a new task in this project : ',
					),
					'projects_filter'    => array(
						'label' => __( 'See projects filter ?', 'woffice' ),
						'desc'  => __( 'This is a dropdown button to filter projects by category ?', 'woffice' ),
						'type'         => 'switch',
						'right-choice' => array(
							'value' => 'yep',
							'label' => __( 'Yep', 'woffice' )
						),
						'left-choice'  => array(
							'value' => 'nope',
							'label' => __( 'Nope', 'woffice' )
						),
						'value'        => 'nope',
					),
					'projects_groups'    => array(
						'label' => __( 'Include in Buddypress Groups ?', 'woffice' ),
						'desc'  => __( 'A new project category will be created for each Buddypress group and all members set as members of the project.', 'woffice' ),
						'type'         => 'switch',
						'right-choice' => array(
							'value' => 'yep',
							'label' => __( 'Yep', 'woffice' )
						),
						'left-choice'  => array(
							'value' => 'nope',
							'label' => __( 'Nope', 'woffice' )
						),
						'value'        => 'nope',
					),
				),
			),
			'blog-box' => array(
				'title'   => __( 'Blog/Pages Options', 'woffice' ),
				'type'    => 'box',
				'options' => array(
					'post_create' => array(
						'label' => __( 'Who can create a Blog article ?', 'woffice' ),
						'desc'  => __( 'It is only affecting a front end button on the main Blog page. The roles with post edit capabilities will still be able to create Blog article from the backend.', 'woffice' ),
						'type'         => 'select-multiple',
						'choices'      => $tt_roles_tmp,
						'value'        => 'administrator',
					),
					'page_comments'    => array(
						'label' => __( 'Show comments on pages', 'woffice' ),
						'desc'  => __( 'Do you want to display the comments to allow user to comment on pages ? If it you choose "show" you will still be able to override it on every page.', 'woffice' ),
						'type'         => 'switch',
						'right-choice' => array(
							'value' => 'show',
							'label' => __( 'Show', 'woffice' )
						),
						'left-choice'  => array(
							'value' => 'hide',
							'label' => __( 'Hide', 'woffice' )
						),
						'value'        => 'hide',
					),
				),
			),
			'directory-box' => array(
				'title'   => __( 'Directory Options', 'woffice' ),
				'type'    => 'box',
				'options' => array(
					'directory_create' => array(
						'label' => __( 'Who can create a directory item ? (BETA)', 'woffice' ),
						'desc'  => __( 'It is only affecting a front end button on the main directory page. The roles with post edit capabilities will still be able to create an item from the backend.', 'woffice' ),
						'type'         => 'select-multiple',
						'choices'      => $tt_roles_tmp,
						'value'        => 'administrator',
					),
				),
			),
            'learndash-box' => array(
                'title'   => __( 'LearnDash Options', 'woffice' ),
                'type'    => 'box',
                'options' => array(
                    'hide_learndash_meta'    => array(
                        'label' => __( 'Hide meta below LearnDash pages', 'woffice' ),
                        'desc'  => __( 'Meta below LearnDash pages contains: author, date, category, comments', 'woffice' ),
                        'type'         => 'switch',
                        'right-choice' => array(
                            'value' => 'nope',
                            'label' => __( 'Nope', 'woffice' )
                        ),
                        'left-choice'  => array(
                            'value' => 'yep',
                            'label' => __( 'Yep', 'woffice' )
                        ),
                        'value'        => 'nope',
                    ),
                )
            )
		)
	)
);