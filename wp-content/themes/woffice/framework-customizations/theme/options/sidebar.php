<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'sidebar' => array(
		'title'   => __( 'Sidebar', 'woffice' ),
		'type'    => 'tab',
		'options' => array(
			'side-box' => array(
				'title'   => __( 'Main options', 'woffice' ),
				'type'    => 'box',
				'options' => array(
					'sidebar_show' => array(
						'label' => __( 'Display the Sidebar on pages', 'woffice' ),
						'type'         => 'switch',
						'right-choice' => array(
							'value' => 'show',
							'label' => __( 'Yep', 'woffice' )
						),
						'left-choice'  => array(
							'value' => 'hide',
							'label' => __( 'Nope', 'woffice' )
						),
						'value'        => 'show',
						'help' => __('This is a global option for the whole website, you can still use a full width layout by using a page template.','woffice'),
					),
					'sidebar_only_logged' => array(
						'label' => __( 'Only for logged users ?', 'woffice' ),
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
						'help' => __('Do you want to restrict sidebar access only to the logged users ?','woffice'),
					),
					'sidebar_buddypress' => array(
						'label' => __( 'Sidebar on Group & Member pages ?', 'woffice' ),
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
						'help' => __('Do you want to see the sidebar on these pages','woffice'),
					),
					'sidebar_blog' => array(
						'label' => __( 'Sidebar on Blog pages ?', 'woffice' ),
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
						'help' => __('Do you want to see the sidebar on these pages','woffice'),
					),
					'sidebar_state' => array(
						'label' => __( 'Open the sidebar by default', 'woffice' ),
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
						'help' => __('The sidebar can either be hidden or be visible by default, the user will find an action button in the header bar.','woffice'),
					),
					/*'sidebar_position' => array(
						'label' => __( 'Sidebar Position', 'woffice' ),
						'type'         => 'switch',
						'right-choice' => array(
							'value' => 'left',
							'label' => __( 'Left', 'woffice' )
						),
						'left-choice'  => array(
							'value' => 'right',
							'label' => __( 'Right', 'woffice' )
						),
						'value'        => 'right',
					),*/
					'sidebar_mobile' => array(
						'label' => __( 'Display the Sidebar on mobiles', 'woffice' ),
						'type'         => 'switch',
						'right-choice' => array(
							'value' => 'yep',
							'label' => __( 'Yep', 'woffice' )
						),
						'left-choice'  => array(
							'value' => 'nope',
							'label' => __( 'Nope', 'woffice' )
						),
						'value'        => 'show',
						'help' => __('If you choose "yep" the sidebar will be toggled with a button fixed on the right side during the navigation.','woffice'),
					),
					'sidebar_min' => array(
						'label' => __( 'Minimum sidebar height', 'woffice' ),
						'type'         => 'text',
						'desc' => __('You can set here a minimum height for the sidebar, it may looks weird but that is better for the layout and prevent some javascript bugs.','woffice'),
						'value'        => '1200',
						'help' => __('A value in Pixel but no needs for the px.','woffice'),
					),
					'sidebar_scroll' => array(
						'label' => __( 'Show scroll top arrow ?', 'woffice' ),
						'type'         => 'switch',
						'desc' => __('This is the arrow at the bottom of the page which allow the user to scroll to the top.','woffice'),
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
					'sidebar_scroll_inner' => array(
						'label' => __( 'Show scroll arrow in the sidebar ?', 'woffice' ),
						'type'         => 'switch',
						'desc' => __('Do you want to display at the bottom of the right sidebar an arrow to help user navigation.','woffice'),
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
					
				)
			),
		)
	)
);