<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

/*---------------------------------------------------------
** 
** TRICK TO CHECK IF THE EXTENSIONS IS ENABLED
**
----------------------------------------------------------*/
function woffice_projects_extension_on(){
	return;
}
/*---------------------------------------------------------
** 	
** CHECK IF USER CAN SEE THE PROJECT
**
----------------------------------------------------------*/
function woffice_is_user_allowed_projects(){
	// PROJECT MEMBERS
	$project_members = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option(get_the_ID(), 'project_members') : '';
	// We exclude the author and the admins as they must access the project anyway
	$author_id = get_the_author_meta('ID');
	$excluded = get_users( array('fields' => 'id', 'role' => 'administrator') );
	if (!in_array($author_id,$excluded)) {
		array_push($excluded, (string)$author_id);
	}
	// ALL USERS WITHOUT THE ADMINS
	$all_users = get_users( array('fields' => 'id', 'exclude' => $excluded) );
	// ALL USERS - PROJECT MEMBERS = EXCLUDED MEMBERS
	if (!empty($project_members)){
		$exclude_members = array_diff($all_users,$project_members);
	}
	else {
		$exclude_members = array();
	}
	$user_ID = get_current_user_id();
	$is_allowed = true;
	
	/* ADDED IN 1.2.6, we check if the projects are public */
	if (!is_user_logged_in()){
		$projects_public = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('projects_public') : ''; 
		$is_allowed = ($projects_public == "yep") ? true : false;
	}
	else {
		/* We check if the member is excluded */
		if (!empty($exclude_members)) : 
			foreach($exclude_members as $exclude_member) {
				if ($exclude_member == $user_ID ): 
					$is_allowed = false;
				endif;
			}
		endif;	
	}
	return $is_allowed;
}
/*---------------------------------------------------------
** 	
** WOFFICE PROJECT PROGRESS PERCENTAGE
**
----------------------------------------------------------*/
function woffice_projects_percentage(){
	// Check how we check the progress first : 
	$project_progress = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option(get_the_ID(), 'project_progress') : '';
		
	if ($project_progress == "tasks") { 
		
		// GET VALUES FROM OPTIONS
		$project_todo_lists = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option(get_the_ID(), 'project_todo_lists') : '';
		// WE track by tasks
		if(!empty($project_todo_lists)){
			$tasks_count = 0;
			$tasks_done = 0;
			foreach($project_todo_lists as $todo) {
				$tasks_count++;
				if ($todo['done'] == TRUE) {
					$tasks_done++;
				}
			}
			$percent = (($tasks_done / $tasks_count) * 100);
			
		} 
		else {
			$percent_f = 0;	
		}
		
	} 
	else {
		
		// GET VALUES FROM OPTIONS
		$project_date_start = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option(get_the_ID(), 'project_date_start') : '';
		$project_date_end = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option(get_the_ID(), 'project_date_end') : '';

		// WE track by time
		$begin = strtotime($project_date_start);
		$now = strtotime("now");
		$end = strtotime($project_date_end);

		$percent = ($end-$begin > 0) ? (($now-$begin) / ($end-$begin)) * 100 : 0;
		
	}
	
	if ($percent < 0):
		$percent_f = 0;
	elseif ($percent > 100) : 
		$percent_f = 100;
	else : 
		$percent_f = $percent;
	endif; 
	
	return floor($percent_f);
}

function woffice_project_progressbar(){
	// Check how we check the progress first : 
	$project_progress = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option(get_the_ID(), 'project_progress') : '';
		
	if ($project_progress == "tasks") { 
		
		$project_todo_lists = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option(get_the_ID(), 'project_todo_lists') : '';
		// THE PROGRESS BAR
		if(!empty($project_todo_lists)):
			echo'<div class="progress project-progress">
				<div class="progress-bar" role="progressbar" aria-valuenow="'.woffice_projects_percentage().'" aria-valuemin="0" aria-valuemax="100" style="width: '.woffice_projects_percentage().'%">
					<span class="progress-current">
						<i class="fa fa-tasks"></i> '.woffice_projects_percentage().' %
					</span>
				</div>
			</div>';
		endif;
		
	} else {
		
		// THE PROGRESS BAR
		$project_date_start = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option(get_the_ID(), 'project_date_start') : '';
		$project_date_end = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option(get_the_ID(), 'project_date_end') : '';
		if(!empty($project_date_start)):
			echo'<div class="progress project-progress">
				<div class="progress-bar" role="progressbar" aria-valuenow="'.woffice_projects_percentage().'" aria-valuemin="0" aria-valuemax="100" style="width: '.woffice_projects_percentage().'%">
					<!-- <span class="progress-start">'.$project_date_start.'</span> -->
					<span class="progress-current">
						<i class="fa fa-clock-o"></i> '.woffice_projects_percentage().' %
					</span>
					<!-- <span class="progress-end">'.$project_date_end.'</span> -->
				</div>
			</div>';
		endif;
		
	}
}

/*---------------------------------------------------------
** 
** CREATE A NEW CATEGORY FOR FILE MANANAGER FOR THE PROJECT POST TYPE
**
----------------------------------------------------------*/
if (class_exists( 'multiverso_mv_category_files' ) && !defined('fileaway')):

	add_action('save_post', 'woffice_add_title_as_mv_category');
	
	function woffice_add_title_as_mv_category( $postid ) {
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
		$post = get_post($postid);
		if ( $post->post_type == 'project') { 
			$term = get_term_by('slug', $post->post_name, 'multiverso-categories');
			if ( empty($term) ) {
				$add = wp_insert_term( $post->post_title, 'multiverso-categories', array('slug'=> $post->post_name) );
				if ( is_array($add) && isset($add['term_id']) ) {
					wp_set_object_terms($postid, $add['term_id'], 'multiverso-categories', true );
				}
			}
		}
	}
	
	// GET A NEW SHORTCODE FOR THE PROJECT
	function mv_managefiles_projects($id) {
		require_once(WP_PLUGIN_DIR . '/multiverso/inc/functions.php');
		$mv_single_cat_id = $id;
		require_once(get_template_directory() . '/inc/multiverso.php');
	}
	
endif;

/*---------------------------------------------------------
** 
** CHECK if todo is deleted in the Todo Manager
**
----------------------------------------------------------*/
function wofficeTodoDelete(){

	$ext_instance = fw()->extensions->get( 'woffice-projects' );
	
	// We get the ID from the current Project post
	$the_ID = $_POST['post_ID'];
	
	// WE get all TODO(S) data and we store it in an array like : 
	/*array(
	    [0] => array
	    (
	        [title] => 'Test'
	        [done] => false
	        [date] => '31-07-2015'
	        [note] => 'Just a note her',
	        [assigned] => ID of member or null
	        [email-sent] => 'not-sent'
	    )
	    [1] => array
	    (
	        [title] => 'Another one'
	        [done] => true
	        [date] => '04-10-2015'
	        [note] => '',
	        [assigned] => ID of member or null
	        [email-sent] => 'not-sent'
	    )
	)*/
	
	/* The $Post return here an array with the same format */
	$new_todos = array();
	if(isset($_POST['project_todo_lists'])) {
		foreach($_POST['project_todo_lists'] as $task){
			$new_todos[] = array(
				'title' => $task['title'],
				'done' => $task['done'],
				'date' => $task['date'],
				'note' => $task['note'],
				'assigned' => explode(',', $task['assigned']),
				'email_sent' => $task['email_sent'],
			);
		}
	}
	
	$updated = $ext_instance->woffice_projects_update_postmeta($the_ID,$new_todos);
	
	if($updated) {
		echo '<div class="infobox fa fa-trash-o" style="background-color: #CC0000;"><p>';
			_e('The task has been deleted !','woffice'); 
		echo'</p></div>';
	}
	
	die();
}
add_action('wp_ajax_nopriv_wofficeTodoDelete', 'wofficeTodoDelete');
add_action('wp_ajax_wofficeTodoDelete', 'wofficeTodoDelete');
/*---------------------------------------------------------
** 
** CHECK if todo is checked in the Todo Manager
**
----------------------------------------------------------*/
function wofficeTodoCheck(){

	$ext_instance = fw()->extensions->get( 'woffice-projects' );
	
	// We get the ID from the current Project post
	$the_ID = $_POST['post_ID'];
	
	// WE get all TODO(S) data and we store it in an array like : 
	/*array(
	    [0] => array
	    (
	        [title] => 'Test'
	        [done] => false
	        [date] => '31-07-2015'
	        [note] => 'Just a note her'
	        [assigned] => USER ID
	        [email-sent] => 'not-sent'
	    )
	    [1] => array
	    (
	        [title] => 'Another one'
	        [done] => true
	        [date] => '04-10-2015'
	        [note] => ''
	        [assigned] => USER ID
	        [email-sent] => 'not-sent'
	    )
	)*/
	
	/* The $Post return here an array with the same format */
	$new_todos = array();
	foreach($_POST['project_todo_lists'] as $task){
		$new_todos[] = array(
			'title' => $task['title'],
			'done' => $task['done'],
			'date' => $task['date'],
			'note' => $task['note'],
			'assigned' => explode(',', $task['assigned']),
			'email_sent' => $task['email_sent'],
		);
	}
	
	
	$ext_instance->woffice_projects_update_postmeta($the_ID,$new_todos);
	
	die();
}
add_action('wp_ajax_nopriv_wofficeTodoCheck', 'wofficeTodoCheck');
add_action('wp_ajax_wofficeTodoCheck', 'wofficeTodoCheck');
/*---------------------------------------------------------
** 
** ADD A NEW TODO
**
----------------------------------------------------------*/
function wofficeTodoADD(){

	$ext_instance = fw()->extensions->get( 'woffice-projects' );
	
	// We get the ID from the current Project post
	$the_ID = $_POST['post_ID'];
	
	/*We get the excisting todo */
	$project_todo_lists = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option($the_ID, 'project_todo_lists') : '';
	
	/*We get the values from the form */
	$the_title = (isset($_POST['todo_name'])) ? sanitize_text_field($_POST['todo_name']) : '';
	$the_date = (isset($_POST['todo_date'])) ? $_POST['todo_date'] : '';
	$the_note = (isset($_POST['todo_note'])) ? sanitize_text_field($_POST['todo_note']) : '';
	$the_assigned = ($_POST['todo_assigned'] != 'nope') ? $_POST['todo_assigned'] : '';
	
	if(!empty($project_todo_lists)){
		$key = 1;
		foreach ($project_todo_lists as $todo){
			$key++;
		}
	}
	else {
		$key = 0;
	}
	
	$ready_to_push = array();
	
	$new_data =  array(
		'title' => $the_title,
		'done' => false,
		'date' => $the_date,
		'note' => $the_note,
		'assigned' => $the_assigned,
		'email_sent' => 'not_sent'
	);
	
	/* We just merge the 2 arrays */
	if (!empty($project_todo_lists)){
	
		$ready_to_push = $new_data;
		
		array_push($project_todo_lists,$ready_to_push);
		$new_todos = $project_todo_lists;
	}
	else {
		$ready_to_push[$key] = $new_data;
		$new_todos = $ready_to_push;
	}
	
	/* Only if the option is turned on to send email on assigned task */
	$projects_assigned_email = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('projects_assigned_email') : ''; 
	if ($projects_assigned_email == "yep") {
			
		/* We send email if needed */
		$new_todos_email_checked = $ext_instance->woffice_projects_assigned_email($the_ID,$new_todos);
			
		/* We save the data in the postmeta*/
		$updated = $ext_instance->woffice_projects_update_postmeta($the_ID,$new_todos_email_checked);
		
	} else {
		
		$updated = $ext_instance->woffice_projects_update_postmeta($the_ID,$new_todos);
		
	}
	
	
	if($updated) {
		echo '<div class="infobox fa fa-check-circle-o" style="background-color: #669900;"><p>';
			_e('The task has been added !','woffice'); 
		echo'</p></div>';
	}
	
	/* 
	We add it to the Buddypress activity Personal Stream
	*/
	$current_user_id = get_current_user_id();
	if ($current_user_id != 0 && bp_is_active( 'activity' )) {
		$activity_args = array(
			'action' => '<a href="'.bp_loggedin_user_domain().'">'.bp_get_displayed_user_mentionname().'</a> '.__('Added a new task in','woffice').' <a href="'.get_the_permalink($the_ID).'">'.get_the_title($the_ID).'</a>',
			'content' => $the_title,	
			'component' => 'project',
			'type' => 'todo-manager',
			'user_id' => $current_user_id,
			//'hide_sitewide' => true
		);
		bp_activity_add( $activity_args );
	}
	/*
	We add it to the Buddypress Group activity Feed
	*/
	// We fetch the option :
	$projects_groups = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('projects_groups') : '';
	if ($projects_groups == "yep" && bp_is_active( 'activity' ) && bp_is_active( 'groups' )) {
		// We get the group name associated to the project
		$post_terms = get_the_terms($the_ID, 'project-category');
		if ($post_terms && !is_wp_error($post_terms)) {
			foreach ($post_terms as $term) {
				// We consider there is only one term for the project, might need to be improved later
				$group_name = $term->name;
				$group_id = groups_get_id(sanitize_title_with_dashes($group_name));
			}
		}
		if (isset($group_id)) {
			groups_record_activity(array(
				'action' => '<a href="'.bp_loggedin_user_domain().'">'.bp_get_displayed_user_mentionname().'</a> '.__('Added a new task in','woffice').' <a href="'.get_the_permalink($the_ID).'">'.get_the_title($the_ID).'</a>',
				'content' => $the_title,
				'item_id' => $group_id,
				'user_id' => $current_user_id,
				'type' => 'activity_update',
			));
		}
	}
	
	// For the tasks
	global $post;
	do_action('save_post', $the_ID, $post, true);
	
	die();
}
add_action('wp_ajax_nopriv_wofficeTodoADD', 'wofficeTodoADD');
add_action('wp_ajax_wofficeTodoADD', 'wofficeTodoADD');

/*---------------------------------------------------------
** 
** UPDATE LIST ORDER
**
----------------------------------------------------------*/
function wofficeTodoOrder(){

	$ext_instance = fw()->extensions->get( 'woffice-projects' );
	
	// We unszeialize from the Javascript function
	parse_str($_POST['form'],$data);
	
	// We get the ID from the current Project post
	$the_ID = $data['post_ID'];
	
	// We create the new array of tasks : 
	$tasks_new_order = array();
	
	foreach ($data['project_todo_lists'] as $todo) {
		/*We get the values from the form */
		$the_title = (isset($todo['title'])) ? sanitize_text_field($todo['title']) : '';
		$the_done = (isset($todo['done'])) ? $todo['done'] : '';
		$the_date = (isset($todo['date'])) ? $todo['date'] : '';
		$the_note = (isset($todo['note'])) ? sanitize_text_field($todo['note']) : '';
		$the_assigned = ($todo['assigned'] != 'nope') ? explode(',', $todo['assigned']) : '';
		$the_email_sent = ($todo['email_sent'] != 'nope') ? $todo['email_sent'] : '';
		
		$tasks_new_order[] =  array(
			'title' => $the_title,
			'done' => $the_done,
			'date' => $the_date,
			'note' => $the_note,
			'assigned' => $the_assigned,
			'email_sent' => $the_email_sent
		);
		
	}
	
	$updated = $ext_instance->woffice_projects_update_postmeta($the_ID,$tasks_new_order);
	
	// For the tasks
	global $post;
	do_action('save_post', $the_ID, $post, true);
	
	die();
}
add_action('wp_ajax_nopriv_wofficeTodoOrder', 'wofficeTodoOrder');
add_action('wp_ajax_wofficeTodoOrder', 'wofficeTodoOrder');



/**
 * Send email to an user if he's assigned to an user
 */
function woffice_project_assigned_user($post_id, $post, $update) {
	
	if (!empty($post)){
		$ext_instance = fw()->extensions->get( 'woffice-projects' );
		
		/* We only process if it's a project : */
		$slug = "project";
		if ( $post->post_type != $slug) {
	    	return;
		}	
		
		/* If this is just a revision, don't send the email. */
		if ( wp_is_post_revision( $post_id ) ) {
			return;
		}
		
		/* Only if the option is turned on */
		$projects_assigned_email = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('projects_assigned_email') : ''; 
		if ($projects_assigned_email == "yep") {
			
			/* We get all the todos */
			$project_todo_lists = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option($post_id, 'project_todo_lists') : '';
			if (!empty($project_todo_lists)) {
				
				/* We send email if needed */
				$new_todos = $ext_instance->woffice_projects_assigned_email($post_id,$project_todo_lists);
				
				/* We save the data in the postmeta*/
				$ext_instance->woffice_projects_update_postmeta($post_id,$new_todos);
				
			}
			
		}
	}
	
}
add_action('save_post','woffice_project_assigned_user', 100, 3 );

/**
 * ADD Project to the calendar
 */
function woffice_project_sync_eventON($post_id, $post, $update) {
	
	 if (defined('DOING_AJAX') && DOING_AJAX) return;
	
	$ext_instance = fw()->extensions->get( 'woffice-projects' );
	
	/* We only process if it's a project : */
	$slug = "project";
	if ( $post->post_type != $slug) {
    	return;
	}	
	
	/* If this is just a revision, don't send the email. */
	if ( wp_is_post_revision( $post_id ) ) {
		return;
	}
	
	/* Only if the option is turned on */
	$project_calendar = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option($post_id, 'project_calendar') : '';
	if ($project_calendar && class_exists( 'EventON' )) {
		
		/* We get the dates */
		$project_date_start = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option($post_id, 'project_date_start') : '';
		$project_date_end = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option($post_id, 'project_date_end') : '';
		if (!empty($project_date_end) && !empty($project_date_start)) {
			/*Unix Time*/
			$begin = strtotime($project_date_start);
			$end = strtotime($project_date_end);
			/*We get other data */
			$title = get_the_title($post_id);
			//$content = get_the_excerpt($post_id);
			$url = get_permalink($post_id);
			$color_colored = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('color_colored') : '';
			$project_members = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option($post_id, 'project_members') : '';
			
			/*We check if the calendar event already exists*/
			global $wpdb;
			$query = $wpdb->prepare(
				'SELECT ID FROM ' . $wpdb->posts . '
				WHERE post_title = %s
				AND post_type = \'ajde_events\'',
				$title
			);
			$check_exists = $wpdb->get_results( $query );
			if(!$check_exists) {
				/*We create the calendar post*/
				$post_information = array(
				    'post_title' =>  wp_strip_all_tags( $title ),
				    //'post_content' => $content,
				    'post_status' => 'publish',
				    'post_type' => 'ajde_events',
				);
				/* We create the Post */
				$calendar_event_id = wp_insert_post( $post_information );
				
				if ($calendar_event_id != 0) {
				
					/*We add the post meta - http://www.myeventon.com/documentation/event-post-meta-variables/*/
					add_post_meta($calendar_event_id,'evcal_srow',$begin);
					add_post_meta($calendar_event_id,'evcal_erow',$end);
					add_post_meta($calendar_event_id,'evcal_event_color',$color_colored);
					add_post_meta($calendar_event_id,'evcal_allday','yes');
					add_post_meta($calendar_event_id,'evcal_lmlink',$url);
					
					/*We add the taxonomy*/
					$eventON_catgeory_object = get_term_by( 'slug', 'Projects', 'event_type' );
					if ($eventON_catgeory_object != false) {
						$value_set = wp_set_post_terms( $calendar_event_id, array($eventON_catgeory_object->term_id), 'event_type' );
					}
					
					/* We add the users */
					if (!empty($project_members)) {
						$tagged = wp_set_object_terms( $calendar_event_id, $project_members, 'event_users' );
					}
					
				}
			}
		}
		
	} else if(!$project_calendar) {
        /*We check if the calendar event already exists*/
        $title = get_the_title($post_id);
        global $wpdb;
        $query = $wpdb->prepare(
            'SELECT ID FROM ' . $wpdb->posts . '
				WHERE post_title = %s
				AND post_type = \'ajde_events\'',
            $title
        );
        $check_exists = $wpdb->get_results( $query );

        /*If exist delete it*/
        if($check_exists) {
            wp_delete_post( $check_exists[0]->ID );
        }
    }
	
}
add_action('save_post','woffice_project_sync_eventON', 100, 3 );

/**
 * Buddypress create a new category for each Group : 
 */
function woffice_groups_create_new_categories($group_id) {
	// We fetch the option : 
	$projects_groups = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('projects_groups') : '';
	if ($projects_groups == "yep") {
		// We get all the groups : 
		if (function_exists('bp_is_active') && bp_is_active('groups')){
			$groups = groups_get_groups(array('show_hidden' => true));
		    foreach ($groups['groups'] as $group) {
			    // we check if there is already a ctageory with the group's name 
			    $term = term_exists($group->name, 'project-category');
			    // If it doesn't exist then create it
			    if ($term == 0 || $term == null) {
				    wp_insert_term( $group->name, 'project-category');
			    }
		    } 
		}
	}
}	
add_action('groups_group_create_complete','woffice_groups_create_new_categories');
add_action('fw_settings_form_saved','woffice_groups_create_new_categories');
/**
 * Buddypress add all members to the project whenever a post is saved
 */
function woffice_groups_sync_members($post_id, $post, $update) {
	
	// We check if it's a project being saved
	if (defined('DOING_AJAX') && DOING_AJAX) return;
	if ($post->post_type != "project") return;
	if (wp_is_post_revision( $post_id )) return;
	
	// We fetch the option : 
	$projects_groups = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('projects_groups') : '';
	if ($projects_groups == "yep") {
		
		// we check for each group if it's a term name : 
		$groups = groups_get_groups();
		foreach ($groups['groups'] as $group) {
			// If it has the term and it's a buddypress group name
		    if( has_term( $group->name, 'project-category', $post_id )) {
			    // We create an array :
				$array_members = array();
				// we get the members
			    $group_members = groups_get_group_members(array('group_id' => $group->id));
				if(!empty($group_members)) {
					foreach($group_members['members'] as $member){
						$array_members[] = $member->ID;
					}
				}
				// we get the admins
				$group_admins = groups_get_group_admins($group->id);
				if(!empty($group_admins)) {
					foreach($group_admins as $admins){
						$array_members[] = $admins->user_id;
					}
				}
				// we get the mods
				$group_mods = groups_get_group_mods($group->id);
				if(!empty($group_mods)) {
					foreach($group_mods as $mods){
						$array_members[] = $mods->user_id;
					}
				}

				// We update the option :
				if (!empty($array_members)) {
					fw_set_db_post_option($post_id, 'project_members', $array_members);
				}

				// We exit the loop
				break;
		    }
	    }


		
	}
}	
add_action('save_post','woffice_groups_sync_members', 10, 3 );