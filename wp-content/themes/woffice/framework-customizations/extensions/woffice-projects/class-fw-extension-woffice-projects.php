<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

class FW_Extension_Woffice_Projects extends FW_Extension {
	/**
	 * @internal
	 */
	public function _init() {
	
		add_action( 'init', array( $this, '_action_register_post_type' ) );
		add_action( 'init', array( $this, '_action_register_taxonomy' ) );
		add_action('fw_extensions_after_activation', array($this, 'woffice_projects_flush'));
	
	}
	
	/**
	 * @internal
	 */
	public function _action_register_post_type() {

		$labels = array(
			'name'               => __( 'Projects', 'woffice' ),
			'singular_name'      => __( 'Project', 'woffice' ),
			'menu_name'          => __( 'Projects', 'woffice' ),
			'name_admin_bar'     => __( 'Project', 'woffice' ),
			'add_new'            => __( 'Add New', 'woffice' ),
			'new_item'           => __( 'Project', 'woffice' ),
			'edit_item'          => __( 'Edit Project', 'woffice' ),
			'view_item'          => __( 'View Project', 'woffice' ),
			'all_items'          => __( 'All Projects', 'woffice' ),
			'search_items'       => __( 'Search Project', 'woffice' ),
			'not_found'          => __( 'No Project found.', 'woffice' ),
			'not_found_in_trash' => __( 'No Project found in Trash.', 'woffice' )
		);
	
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'menu_icon' => 'dashicons-index-card',
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'project' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => true,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor','thumbnail', 'revisions', 'author', 'comments' )
		);
	
		register_post_type( 'project', $args );
		
	}
	
	/**
	 * @internal
	 */
	public function woffice_projects_flush($extensions) {
	
		if (!isset($extensions['woffice-projects'])) {
	        return;
	    }
	    
	    flush_rewrite_rules();
		
	}

	/**
	 * @internal
	 */
	public function _action_register_taxonomy() {

		$labels = array(
			'name'              => __( 'Project Categories', 'woffice' ),
			'singular_name'     => __( 'Project Category', 'woffice' ),
			'search_items'      => __( 'Search Project Categories', 'woffice' ),
			'all_items'         => __( 'All Project Categories', 'woffice' ),
			'edit_item'         => __( 'Edit Category', 'woffice' ),
			'update_item'       => __( 'Update Project Category', 'woffice' ),
			'add_new_item'      => __( 'Add New Project Category', 'woffice' ),
			'new_item_name'     => __( 'New Project Category', 'woffice' ),
			'menu_name'         => __( 'Categories', 'woffice' ),
		);
	
		$args = array(
			'hierarchical'      => false,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => false,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'project-category' ),
		);
	
		register_taxonomy( 'project-category', array( 'project' ), $args );
		
	}

	/**
	 * Update the Project post meta data with the post name and the new todos
	 */
	public function woffice_projects_update_postmeta($the_ID,$new_todos) {

		// We get the data from that project (we don't change it):
		$page_builder = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option($the_ID, 'page-builder') : '';
		$project_date_start = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option($the_ID, 'project_date_start') : '';
		$project_date_end = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option($the_ID, 'project_date_end') : '';
		$project_members = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option($the_ID, 'project_members') : '';
		$project_links = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option($the_ID, 'project_links') : '';
		$project_edit = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option($the_ID, 'project_edit') : '';
        $only_author_can_edit = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option($the_ID, 'only_author_can_edit') : '';
		$project_files = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option($the_ID, 'project_files') : '';
	
		
		// We Update the Post Data
        $project_progress = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option($the_ID, 'project_progress') : '';
        $project_calendar = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option($the_ID, 'project_calendar') : '';
        $project_wunderlist = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option($the_ID, 'project_wunderlist') : '';



        // We Update the Post Data
		$project_data = array(
			'page-builder' => $page_builder,
			'project_progress' => $project_progress,
			'project_date_start' => $project_date_start,
			'project_date_end' => $project_date_end,
			'project_members' => $project_members,
			'project_files' => $project_files,
			'project_edit' => $project_edit,
            'only_author_can_edit' => $only_author_can_edit,
			'project_links' => $project_links,
			'project_todo' => true,
			// WE ONLY CHANGE HERE !!
			'project_todo_lists' => $new_todos,
            'project_wunderlist' => $project_wunderlist,
            'project_calendar' => $project_calendar,
		);
		
		return update_post_meta($the_ID,'fw_options',$project_data);
		
	}
	
	/**
	 * Send email if needed for the assigned user
	 */
	public function woffice_projects_assigned_email($post_id,$project_todo_lists) {

		/* We're using an array to save the new value once updated */
		$new_todos = array();
		
		/* We check if there is an asignement */
		foreach ($project_todo_lists as $key=>$todo) {

			$sent_counter = 0;
			
			/* We check if the email isn't sent AND there is a member assigned */
			if ($todo['email_sent'] == 'not_sent' && $todo['assigned'] != 'nope') {
				
				$post_title = get_the_title( $post_id );
				$post_url = get_permalink( $post_id );
			
				/* Then, We send the email : */
				$subject = $post_title . ': '. __('You have a new task','woffice') .'->'. $todo['title'];
				$projects_assigned_email_content = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('projects_assigned_email_content') : ''; 
				$message = $projects_assigned_email_content;
				$message .= "\n\n";
				$message .= $post_title . ": " . $post_url;

				// Send email to the user.
				foreach ($todo['assigned'] as $assigned) {
					$user_info = get_userdata($assigned);
					$user_email = $user_info->user_email;
					$email = wp_mail($user_email, $subject, $message);
					if ($email == true) {
						/*We update the value of the post meta sent so it's not a loop */
						$sent_counter = $sent_counter + 1;
					}
				}
				
			} elseif ($todo['email_sent'] == 'sent' && $sent_counter >= 1){
				$sent = 'sent';
			}
			else {
				$sent = 'not_sent';
			}
			
			/* We keep the same values except for the email_sent */
			$new_todos[$key] = array(
				'title' => $todo['title'],
				'done' => $todo['done'],
				'date' => $todo['date'],
				'note' => $todo['note'],
				'assigned' => $todo['assigned'],
				'email_sent' => $sent
			);
			
		}
		
		return $new_todos;
		
	}

    private static function woffice_sort_tasks_by_date($a, $b) {
        //var_dump($a);
        if(empty($a['task_date']) && empty($b['task_date']))
            return 0;
        elseif(empty($a['task_date']))
            return 1;
        elseif(empty($b['task_date']))
            return -1;

        return strtotime($a['task_date']) - strtotime($b['task_date']);
    }

	/**
	 * Return array list of the assigned tasks for a certain user
	 */
	public function woffice_projects_assigned_tasks($user_ID) {

		/*Array of assigned tasks*/
		$the_assigned_tasks = array();
		/*Counter*/
		$count = 0;
		
		if ($user_ID != 0){
		
			/*We loop all the projects to fetch tasks*/
			$projects_query = new WP_Query('post_type=project&showposts=-1');
			while($projects_query->have_posts()) : $projects_query->the_post(); 
					
				/*We get the tasks*/
				$project_tasks = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option(get_the_ID(), 'project_todo_lists') : '';
				if (!empty($project_tasks)) {
					
					/*We loop the task*/
					foreach ($project_tasks as $task){
						
						/* We check if it's not done AND it's assigned to the user */
						$task['assigned'] = (is_array($task['assigned'])) ? $task['assigned'] : explode(',',$task['assigned']);
						if ($task['done'] == false && in_array($user_ID, $task['assigned'])){
							
							$title_task = (!empty($task['title'])) ? $task['title'] : "";
							$title_date = (!empty($task['date'])) ? $task['date'] : "";
							
							$the_assigned_tasks[] = array(
								'task_name' => $title_task,
								'task_date' => $title_date,	
								'task_project' => get_permalink(),
							);
							$count++;
							
						}
					
					}
				}
				
			endwhile;
			wp_reset_postdata();
			
		}

        usort($the_assigned_tasks, array('FW_Extension_Woffice_Projects', 'woffice_sort_tasks_by_date'));
		return array( 'number' => $count , 'tasks' => $the_assigned_tasks); 
		
	}			
			
}
