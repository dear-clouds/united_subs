<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

if(!function_exists('woffice_get_project_menu')) {
    /**
     * Returns the Project Menu
     */
    function woffice_get_project_menu($post)
    {
        $html = '<ul>';
        $current_user_is_admin = woffice_current_is_admin();
        /* View Link */
        $html .= '<li id="project-tab-view" class="active">
			<a href="#project-content-view" class="fa-file-o">' . __("View", "woffice") . '</a>
		</li>';

        /* Edit Link */
        $project_edit = (function_exists('fw_get_db_post_option')) ? fw_get_db_post_option(get_the_ID(), 'project_edit') : '';
        if ($project_edit != 'no-edit' && is_user_logged_in()) :
            $display_edit_button = true;

            $only_author_can_edit = (function_exists('fw_get_db_post_option')) ? fw_get_db_post_option(get_the_ID(), 'only_author_can_edit') : '';
            if($only_author_can_edit == true) {
                $user = wp_get_current_user();
                global $post;
                if ($post->post_author != $user->ID && !$current_user_is_admin) {
                    $display_edit_button = false;
                }
            }
            if($display_edit_button) {
                $html .= '<li id="project-tab-edit">';
                if ($project_edit == 'frontend-edit'):
                    $html .= '<a href="#project-content-edit" class="fa-pencil-square-o">' . __("Quick Edit", "woffice") . '</a>';
                else :
                    $html .= '<a href="' . get_edit_post_link($post->ID) . '" class="fa-pencil-square-o">' . __("Quick Edit", "woffice") . '</a>';
                endif;
                $html .= '</li>';
            }
        endif;

        /* Todo Link */
        // IF TODO IS ENABLED
        $project_todo = (function_exists('fw_get_db_post_option')) ? fw_get_db_post_option(get_the_ID(), 'project_todo') : '';
        if ($project_todo):
            $html .= '<li id="project-tab-todo">
				<a href="#project-content-todo" class="fa-check-square-o">' . __("Todo", "woffice") . '</a>
			</li>';
        endif;


        /* Files Link */
        // IF THERE IS FILES
        $project_files = (function_exists('fw_get_db_post_option')) ? fw_get_db_post_option(get_the_ID(), 'project_files') : '';
        if (!empty($project_files)):
            $html .= '<li id="project-tab-files">
				<a href="#project-content-files" class="fa-files-o">' . __("Files", "woffice") . '</a>
			</li>';
        endif;

        /* Comments Link */
        if (comments_open()) {
            $html .= '<li id="project-tab-comments">
				<a href="#project-content-comments" class="fa-comments-o">
					' . __("Comments", "woffice") . '
					<span>' . get_comments_number() . '</span>
				</a>
			</li>';
        }

        /* Delete Link */
        $user = wp_get_current_user();
        if ($post->post_author == $user->ID || $current_user_is_admin) :
            $html .= '<li id="project-tab-delete">
				<a onclick="return confirm(\'' . __('Are you sure you wish to delete article :', 'woffice') . ' ' . get_the_title() . ' ?\')" href="' . get_delete_post_link(get_the_ID(), '', true) . '" class="fa-trash-o">
					' . __("Delete", "woffice") . '
				</a>
			</li>';
        endif;

        $html .= '</ul>';

        return $html;
    }
}
if(!function_exists('woffice_projects_todo')) {
    /**
     * Returns the Todo Form (List + Add form)
     */
    function woffice_projects_todo($post)
    {

        /* Get all the existing todos : */
        $project_todo_lists = (function_exists('fw_get_db_post_option')) ? fw_get_db_post_option(get_the_ID(), 'project_todo_lists') : '';

        global $post;
        $only_author_can_edit = (function_exists('fw_get_db_post_option')) ? fw_get_db_post_option($post->ID, 'only_author_can_edit') : '';
        $allowed_modify = true;
        if($only_author_can_edit == true) {
            $user = wp_get_current_user();
            $allowed_modify = ($post->post_author == $user->ID || woffice_current_is_admin()) ? true : false;
        }

        echo '<form id="woffice-project-todo" class="woffice-project-todo-group" action="' . $_SERVER['REQUEST_URI'] . '" method="POST">';

        /* First we display all the todos */
        if (!empty($project_todo_lists)) {

            echo '<input type="hidden" name="post_ID" value="' . get_the_ID() . '" />';

            $counter = 0;
            foreach ($project_todo_lists as $todo) {

                /* Each Todo */
                $note_class = ($todo['note']) ? 'has-note' : '';
                echo '<div class="woffice-task ' . $note_class . '">';

                /* The task header */
                echo '<header>';

                /* Checkbox */
                $attribute = ($todo['done']) ? 'checked' : '';
                echo '<label class="woffice-todo-label">';
                echo '<input type="checkbox" name="woffice-todo-done" ' . $attribute . '>';
                echo '<span class="checkbox-style"></span>';
                /* Title */
                if (!empty($todo['title'])) {
                    echo $todo['title'];
                }
                echo '</label>';

                /* Delete Icon */
                if($allowed_modify) {
                    echo '<a href="#" onclick="return false" class="woffice-todo-delete"><i class="fa fa-trash-o"></i></a>';
                }

                /* Assigned User */
                if (!empty($todo['assigned'])) {
                    $todo['assigned'] = (is_array($todo['assigned'])) ? $todo['assigned'] : explode(',',$todo['assigned']);
                    foreach($todo['assigned'] as $assigned) {
                        if (function_exists('bp_core_get_user_domain')) {
                            echo '<span class="todo-assigned">';
                            echo '<a href="' . bp_core_get_user_domain($assigned) . '" class="clearfix">';
                            echo get_avatar($assigned);
                            echo '</a>';
                            echo '</span>';
                        } else {
                            echo '<span class="todo-assigned">' . get_avatar($assigned) . '</span>';
                        }
                    }
                }

                /* Date */
                if (!empty($todo['date'])) {
                    echo '<span class="todo-date"><i class="fa fa-calendar"></i> ' . date_i18n(get_option('date_format'), strtotime($todo['date'])) . '</span>';
                }
                /* Note Icon */
                if (!empty($todo['note'])) {
                    echo '<i class="fa fa-file-text-o"></i>';
                }
                echo '</header>';

                /* If there is some note we add some another container */
                if (!empty($todo['note'])) {
                    echo '<div class="todo-note">';
                    echo '<p>' . $todo['note'] . '</p>';
                    echo '</div>';
                }
                $todo['assigned'] = (is_array($todo['assigned'])) ? $todo['assigned'] : explode(',',$todo['assigned']);
                /* We create some input fields to pass the data through ajax form */
                echo '<input type="hidden" name="project_todo_lists[' . $counter . '][title]" value="' . $todo['title'] . '" />';
                echo '<input type="hidden" name="project_todo_lists[' . $counter . '][done]" value="' . $todo['done'] . '" class="done-data"/>';
                echo '<input type="hidden" name="project_todo_lists[' . $counter . '][date]" value="' . $todo['date'] . '" />';
                echo '<input type="hidden" name="project_todo_lists[' . $counter . '][note]" value="' . $todo['note'] . '" />';
                echo '<input type="hidden" name="project_todo_lists[' . $counter . '][assigned]" value="' . implode(',' ,$todo['assigned']) . '" />';
                echo '<input type="hidden" name="project_todo_lists[' . $counter . '][email_sent]" value="' . $todo['email_sent'] . '" />';
                /* Other Data */
                echo '<input type="hidden" name="post_ID" value="' . get_the_ID() . '" />';
                echo '<input type="hidden" name="action" value="wofficeTodoDelete" />';


                echo '</div>';

                $counter++;

            }

        }

        echo '</form>';

        /*
         * We display now the form :
          */
        echo '<div id="woffice-add-todo-alert"></div>';


        if ($allowed_modify) {
            echo '<form id="woffice-add-todo" action="' . $_SERVER['REQUEST_URI'] . '" method="POST">';

            /* The heading */
            echo '<div class="heading"><h3>' . __('Add a New Task', 'woffice') . '</h3></div>';

            /* The Fields */
            echo '<div class="row">';

            echo '<div class="col-md-6">';
            echo '<label for="todo_name">' . __('Name', 'woffice') . '</label>';
            echo '<input type="text" name="todo_name" required="required">';
            echo '</div>';

            echo '<div class="col-md-6">';
            echo '<label for="todo_date">' . __('Due date', 'woffice') . '</label>';
            echo '<input type="text" name="todo_date" class="datepicker">';
            echo '</div>';

            echo '</div>';

            echo '<div class="row woffice-add-todo-note">';
            echo '<div class="col-md-12">';
            echo '<label for="todo_note">' . __('Add a note', 'woffice') . '</label>';
            echo '<textarea rows="2" name="todo_note"></textarea>';
            echo '</div>';
            echo '</div>';

            echo '<div class="row woffice-add-todo-assigned">';
            echo '<div class="col-md-12">';
            echo '<label for="todo_assigned">' . __('Assign an user (optional)', 'woffice') . '</label>';
            // MEMBERS SELECT
            $project_members = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option(get_the_ID(), 'project_members') : '';
            $tt_users = array();
            if(empty($project_members)) {
                $tt_users_obj = get_users(array('fields' => array('ID', 'user_nicename')));
                foreach ($tt_users_obj as $tt_user) {
                    $tt_users[$tt_user->ID] = woffice_get_name_to_display($tt_user->ID);
                }
            } else {
                $tt_users_obj = $project_members;
                foreach ($tt_users_obj as $tt_user) {
                    if(!empty($tt_user)){
                        $user_info = get_userdata($tt_user);
                        if($user_info)
                            $tt_users[$user_info->ID] = woffice_get_name_to_display($user_info);
                    }
                }
            }
            $tt_users_tmp = array('nope' => __("No one", "woffice")) + $tt_users;
            echo '<select name="todo_assigned[]" class="form-control" multiple="multiple">';
            foreach ($tt_users_tmp as $key => $user) {
                echo '<option value="' . $key . '">' . $user . '</option>';
            }
            echo '</select>';
            echo '</div>';
            echo '</div>';

            echo '<div class="text-right">';
            echo '<button type="submit" class="btn btn-default"><i class="fa fa-plus-square-o"></i> ' . __('Add Task', 'woffice') . '</button>';
            echo '</div>';


            echo '<input type="hidden" name="post_ID" value="' . get_the_ID() . '" />';
            echo '<input type="hidden" name="action" value="wofficeTodoADD" />';

            echo '</form>';
        }
    }

}
if(!function_exists('woffice_projects_fileway_manager')) {
    /**
     * Returns the File Away file manager :
     */
    function woffice_projects_fileway_manager($post_slug) {

        $sub_name = "projects_" . $post_slug;

        /* We output the directory */
        echo do_shortcode('[fileaway base="1" makedir="true" sub="' . $sub_name . '" type="table" directories="true" paginate="false" makedir="true"  flightbox="images" bulkdownload="on"]');

        /* We output the file uploader */
        echo do_shortcode('[fileup base="1" makedir="true" sub="' . $sub_name . '"]');

    }
}
if(!function_exists('woffice_projects_filter')) {
    /**
     * Returns the project filter :
     */
    function woffice_projects_filter()
    {

        // The Project filter
        $projects_filter = (function_exists('fw_get_db_settings_option')) ? fw_get_db_settings_option('projects_filter') : '';
        if ($projects_filter != "nope") {
            echo '<div class="center">';
            echo '<div id="woffice-project-filter" class="dropdown">';
            echo '<button id="woffice-projects-filter-btn" type="button" class="btn btn-default" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            echo '<i class="fa fa-archive"></i>';
            _e("Select Category", "woffice");
            echo '<i class="fa fa-caret-down"></i>';
            echo '</button>';
            echo '<ul class="dropdown-menu" role="menu">';
            // SEARCH FOR PROJECT CATEGORIES
            $terms = get_terms('project-category');
            if ($terms) :
                // DROPDOWN LIST
                foreach ($terms as $term) {
                    echo '<li><a href="' . get_term_link($term) . '" data-slug="' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</a></li>';
                }
            endif;
            echo '</ul>';
            echo '</div>';
            echo '</div>';
        }

    }
}

