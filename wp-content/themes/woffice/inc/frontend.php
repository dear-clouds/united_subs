<?php 
/**
 * FRONTEND FUNCTIONS
 * @internal
 * You'll find here all the functions we are using for the front end edit so the files look better
 */

/**
 * Does the user can create in frontend ? 
 * - 
 * This function check if the current member can create a post according to the options set in the Theme Settings
 * $users_from_options is an array of users from the theme settings
 * Returns TRUE or FALSE
 */
function woffice_role_allowed ($users_from_options) {
	/* We force the arg to be an array */
	if(is_array($users_from_options) == false) {
        $users_from_options = array($users_from_options);
    }
	
	/* If the users is not logged we reeturn false */
	if (!is_user_logged_in()){
		return false;
	}

 	/* We get the current user data */
	$user = wp_get_current_user();
	/* Thanks to Buddypress we only keep the main role */
	if (!empty($user->roles)) {
		$the_user_role = (is_array($user->roles)) ? $user->roles[0] : $user->roles;
	}
	
	/* We check if it's in the array, OR if it's the administrator  */
	if (in_array( $the_user_role , $users_from_options )) {
		return true;
	}
	else {
		return false;
	}
	 
}
/**
 * Helper, set the terms to a post type with the frontend values
 * - 
 * $post_values : Values selected in the frontend ($_POST) it's an array
 * $type : the post type 
 * $post_id : The ID of the new post
 */
function woffice_frontend_set_terms ($post_values, $type, $post_id) {
	
	/* Categories name */
	if ($type == "project") {
		$term_name = "project-category";
	} elseif ($type == "wiki") {
		$term_name = "wiki-category";
	} elseif ($type == "directory") {
		$term_name = "directory-category";
	} else {
		$term_name = "category";
	}

	$term_array = array();
	
	foreach($post_values as $category) {
		
		if ($category != "no-category") {
			
			if ($type == "post") {
				$type_catgeory_object = get_category_by_slug($category); 
			} else {
				$type_catgeory_object = get_term_by( 'slug', $category, $term_name);
			}
			
			//fw_print($project_catgeory_object);
			$term_array[] = $type_catgeory_object->term_id;
			
		}
		
	}
	$value_set = wp_set_post_terms( $post_id, $term_array, $term_name);
	
}
/**
 * Processing the data sent by the form 
 * - 
 * This function process the data from the FORM (see next function)
 * $type is the kind of post (project, wiki, directory or post)
 */
function woffice_frontend_proccess ($type) {
	
	global $post;
	
	/* If there is no title */	
	$has_error = false;
	$post_title_error = '';

	/* We first check that the form was submitted */
 	if ( isset( $_POST['submitted'] ) && isset( $_POST['post_nonce_field'] ) && wp_verify_nonce( $_POST['post_nonce_field'], 'post_nonce' ) ) {

	 	/* We check that title isn't empty */
	 	if ( trim( $_POST['post_title'] ) === '' ) {
	 	
	        $post_title_error = __('Please enter a title.','woffice');
	        $has_error = true;
	        
	    }
	    else {
		    
		    /* Get the post status when submitted */
			$frontend_state = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('frontend_state') : ''; 
	    	
	    	/* For all posts */
	    	if ($type != "directory") {
				$post_information = array(
				    'post_title' =>  wp_strip_all_tags( $_POST['post_title'] ),
				    'post_content' => $_POST['post_content'],
				    'post_status' => $frontend_state,
				    'post_type' => $type,
				);
	    	}
	    	else{
		    	$post_information = array(
				    'post_title' =>  wp_strip_all_tags( $_POST['post_title'] ),
				    'post_excerpt' => $_POST['post_content'],
				    'post_status' => $frontend_state,
				    'post_type' => $type,
				);
	    	}
			/* We create the Post */
			$post_id = wp_insert_post( $post_information );

		 	
		 	if ($type == 'wiki') {
			/* if it's for a WIKI POST */
			
			 	/*We set the term*/
			 	if (isset($_POST['wiki_category'])) {
			 		woffice_frontend_set_terms($_POST['wiki_category'], $type, $post_id);
			 	}
			 	
		 	} elseif ($type == 'project') {
			/* if it's for a PROJECT POST */
			 	
			 	/*We set the term*/
			 	if (isset($_POST['project_category'])) {
			 		woffice_frontend_set_terms($_POST['project_category'], $type, $post_id);
			 	}
				
				/* We check if dates are set */
				if (!empty($_POST['project_start']) && !empty($_POST['project_end'])){
					
					$start_date = wp_strip_all_tags($_POST['project_start']);
					$end_date = wp_strip_all_tags($_POST['project_end']);
				
					/* We check if dates are end isn't before date start */
					if (strtotime($_POST['project_end']) > strtotime($_POST['project_end'])){
						$postDateError = __( 'Dates are not good, please check again.','woffice');
						$has_error = true;
					}
				
				}
				else {
                    $start_date = $end_date = '';
				}
				
				/* Projects Member */
				$projects_users = array();
				/* We check if some members have been selected */
				if(!empty($_POST['project_members'])) {
					foreach($_POST['project_members'] as $member) {
						$projects_users[] = $member;
					} 
				}
				$only_author_can_edit = (isset($_POST['only_author_can_edit']) && $_POST['only_author_can_edit'] == 'yes' ) ? true : false;
				$calendar_sync = (isset($_POST['calendar_sync']) && $_POST['calendar_sync'] == 'yes' ) ? true : false;
				$enable_todo = (isset($_POST['enable_todo']) && $_POST['enable_todo'] == 'yes' ) ? true : false;
				$enable_files = (isset($_POST['enable_files']) && $_POST['enable_files'] == 'yes' ) ? true : false;

				/* We save the values */
				$project_data = array(
					'project_date_start' => $start_date,
					'project_date_end' =>  $end_date,
					'project_members' => $projects_users,
					'project_files' => $enable_files,
					'project_edit' => 'frontend-edit',
					'project_links' => array(),
					'project_todo' => $enable_todo,
					'project_todo_lists' => array(),
					'project_wunderlist' => '',
					'project_calendar' => $calendar_sync,
                    'only_author_can_edit' => $only_author_can_edit
				);
				add_post_meta($post_id,'fw_options',$project_data);
				
			} elseif ($type == 'directory') {
			/* if it's for a DIRECTORY POST */
			
				/*We set the term*/
				if (isset($_POST['directory_category'])) {
			 		woffice_frontend_set_terms($_POST['directory_category'], $type, $post_id);
			 	}
				
				/* We get the custom DATA for the item */
				$item_button_icon = (!empty($_POST['item_button_icon'])) ? $_POST['item_button_icon'] : "";
				$item_button_text = (!empty($_POST['item_button_text'])) ? $_POST['item_button_text'] : "";
				$item_button_link = (!empty($_POST['item_button_link'])) ? $_POST['item_button_link'] : "";
				
				if (!empty($_POST['item_location_lng']) && !empty($_POST['item_location_lat'])){
					$location = array(
						'location'    => '',
						'venue'       => '',
						'address'     => '',
						'city'        => '',
						'state'       => '',
						'country'     => '',
						'zip'         => '',
						'coordinates' => array(
							'lat' => $_POST['item_location_lat'],
							'lng' => $_POST['item_location_lng'],
						)
					);
				} else {
					$location = "";
				}
				
				/* We save the values */
				$directory_data = array(
					'item_location' => $location,
					'item_button_text' => $item_button_text,
					'item_button_icon' =>  $item_button_icon,
					'item_button_link' => $item_button_link,
				);
				add_post_meta($post_id,'fw_options',$directory_data);
			 	
		 	} else {
		 	/* if it's for a POST POST */
		 	
				/*We set the term*/
				if (isset($_POST['blog_category'])) {
			 		woffice_frontend_set_terms($_POST['blog_category'], $type, $post_id);
			 	}

                if (isset($_POST['everyone_edit']) && $_POST['everyone_edit'] == 'yes' && woffice_current_is_admin() ) {
                    fw_set_db_post_option($post_id, 'everyone_edit', true);
                } else {
                    fw_set_db_post_option($post_id, 'everyone_edit', false);
                }
		 	}
		 	
		 	if ($type != 'wiki' && $type != 'project') {
				/* We add the thubnail image */
				if ($_FILES["post_thumbnail"]["error"] == 0){
					$attach_id = 0;
					require_once(ABSPATH . "wp-admin" . '/includes/image.php');
					require_once(ABSPATH . "wp-admin" . '/includes/file.php');
					require_once(ABSPATH . "wp-admin" . '/includes/media.php');
				    if ($_FILES) {
				        foreach ($_FILES as $file => $array) {
				            if ($_FILES[$file]['error'] !== UPLOAD_ERR_OK) {
				                //return "upload error : " . $_FILES[$file]['error'];
				                fw_print("upload error : " . $_FILES[$file]['error']);
				            }
				            $attach_id = media_handle_upload( $file, $post_id );
				        }   
				    }
				    if ($attach_id > 0){
				        //and if you want to set that image as Post  then use:
				        update_post_meta($post_id,'_thumbnail_id',$attach_id);
				    }
			 	}
		 	}
	
		}
		
		/* What the function is returning */
		if ($has_error == true) {
			return false;	
		}
		else {
		 	/* We refresh to the created post */
		 	wp_redirect(get_permalink($post_id));	
		}
		
    }
}
 
/**
 * Render form HTML
 * - 
 * This function displays HTML form for the frontend edit
 * $type is the kind of post (project, wiki or post)
 */
function woffice_frontend_render ($type, $everything_fine, $child_of = 0) {
	
	$type = ($type == 'post') ? 'blog' : $type;
	/* First the loader */ 
	echo'<!-- LOADER -->
	<div id="'.$type.'-loader" class="intern-padding woffice-loader">
		<i class="fa fa-spinner"></i>
	</div>';
	
	/* Form Wrapper */
	echo'<!-- CREATE NEW ARTICLE-->';
	echo'<div id="'.$type.'-create" class="intern-padding">';
		/* The FORM */
		if ($type == "blog") {
			$the_option = get_option( 'show_on_front' );
			if( $the_option == 'page' ) {
				$blog_page = get_option('page_for_posts' );
                if(empty($blog_page)){
                    $pages = get_pages(array(
                        'meta_key' => '_wp_page_template',
                        'meta_value' => 'page-templates/blog.php'
                    ));
                    $blog_page = $pages[0]->ID;
                }
				$form_url = get_permalink( $blog_page );
			} 
			else {
				$form_url = get_site_url().'/';
			}
		} else {
			$form_url = get_the_permalink();
		}
		?>
		
		<!-- THE FORM -->
		<?php $form_extra = ($type == "blog" || $type == "directory") ? ' enctype="multipart/form-data"' : ''; ?> 
        <form action="<?php echo $form_url; ?>" id="primaryPostForm" method="POST" <?php echo $form_extra; ?> >
        
        	<?php if ($type == 'project' && !current_user_can("edit_posts")) { ?>
	        	
	        	<div class="infobox fa fa-cogs" style="background-color: #7B7B7B;">
		        	<span class="infobox-head"><?php _e("Information","woffice"); ?></span>
		        	<p><?php _e("You'll only find here basic settings for the projects, for more settings please contact an user with author right.","woffice"); ?></p>
		    	</div>
	        	
        	<?php } ?>
        
		    <p>
		    	<?php /* Title Label */
		    	if ($type == "project") {
			    	$title_label = __( 'Project\'s Title:', 'woffice');
			    } elseif($type == "directory") {
				    $title_label = __( 'Item\'s Title:', 'woffice');
				} else {
					$title_label = __( 'Article\'s Title:', 'woffice');
				}  ?>  
		        <label for="post_title"><?php echo $title_label; ?></label>
		        <input type="text" name="post_title" id="post_title" class="required" required/>	 
		    </p>
		 
		    <?php if ($everything_fine === false) { ?>
		        <div id="message" class="infobox" style="background-color: #DE1717;">
		        	<?php _e("Please enter a title","woffice"); ?>
		        </div>
		    <?php } ?>
		    
		    
		    <?php  /* if it's for a WIKI POST */
		 	if ($type == 'wiki') { ?>
		 		
		 		<?php 
	        	// SEARCH FOR WIKI CATEGORIES
                $terms = get_terms('wiki-category', array('hide_empty' => false, 'child_of' => $child_of));
				if ($terms) : ?>
					<p>            
				        <label for="wiki_category"><?php _e( 'Article\'s Category:', 'woffice' ); ?></label>
				        <?php // DROPDOWN LIST
				        echo'<select multiple="multiple" name="wiki_category[]" class="postform form-control">';
					        echo'<option value="no-category">'. __("No category","woffice") .'</option>';
					        foreach ( $terms as $term ) {
					            printf( '<option value="%s">%s</option>', esc_attr( $term->slug ), esc_html( $term->name ) );
					        }
				        echo'</select>'; ?>
				    </p>
				<?php endif; ?>
		 		
		    
		    <?php } elseif ($type == 'project') { 
			/* if it's for a PROJECT POST */
		 	?>
		 	
		 		<div class="row">
			    	<div class="col-md-6">
					    <p>
					        <label for="project_start"><?php _e( 'Project\'s starting date:', 'woffice' ); ?></label>
					        <input type="text" name="project_start" id="project_start" class="datepicker" placeholder="<?php echo date('d-m-Y'); ?>"/>	 
					    </p>
			    	</div>
					<div class="col-md-6">
					    <p>
					        <label for="project_end"><?php _e( 'Project\'s ending date:', 'woffice' ); ?></label>
					        <input type="text" name="project_end" id="project_end" class="datepicker" placeholder="<?php echo date('d-m-Y'); ?>"/>	 
					    </p>
					</div>
			    </div>
				
				<?php 
		    	// SEARCH FOR PROJECT CATEGORIES
                $terms = get_terms('project-category', array('hide_empty' => false));
				if ($terms) : ?>
					<p>            
				        <label for="project_category"><?php _e( 'Project\'s Category:', 'woffice' ); ?></label>
				        <?php // DROPDOWN LIST
				        echo'<select multiple="multiple" name="project_category[]" class="postform form-control">';
					        echo'<option value="no-category">'. __("No category","woffice") .'</option>';
					        foreach ( $terms as $term ) {
					            printf( '<option value="%s">%s</option>', esc_attr( $term->slug ), esc_html( $term->name ) );
					        }
				        echo'</select>'; ?>
				    </p>
				<?php endif; ?>
				
				<?php 
		    	// MEMBERS SELECT
				$tt_users = array();
				$tt_users_obj = get_users(array( 'fields' => array( 'ID', 'user_nicename', 'display_name' )));
				foreach ($tt_users_obj as $tt_user) {
				$tt_users[$tt_user->ID] = woffice_get_name_to_display($tt_user->ID);
                }  ?>
				<p>   
					<label for="project_members"><?php _e( 'Project\'s members:', 'woffice' ); ?></label>
					<small><?php _e( 'If it\'s empty, all members\'ll be allowed to see it (leave empty for groups projects)', 'woffice' ); ?></small>
					<select multiple="multiple" name="project_members[]" class="form-control">
						<?php 
							foreach ($tt_users as $key => $user) {
								echo'<option value="'.$key.'">'.$user.'</option>';
							}
						?>
					</select>
				</p>
                <p>
					<span class="wpcf7-checkbox">
						<span class="wpcf7-list-item">
							<label class="frontend-checkbox">
								<input type="checkbox" name="only_author_can_edit" id="only_author_can_edit" value="yes">
								<span class="wpcf7-list-item-label"><?php _e("Only author can edit ?", "woffice"); ?></span>
							</label>
						</span>
					</span>
                </p>
				<p>
					<span class="wpcf7-checkbox">
						<span class="wpcf7-list-item">
							<label class="frontend-checkbox">
								<input type="checkbox" name="calendar_sync" id="calendar_sync" value="yes">
								<span class="wpcf7-list-item-label"><?php _e("Calendar sync ?", "woffice"); ?></span>
							</label>
						</span>
					</span>
				</p>
				<p>
					<span class="wpcf7-checkbox">
						<span class="wpcf7-list-item">
							<label class="frontend-checkbox">
								<input type="checkbox" name="enable_todo" id="enable_todo" value="yes">
								<span class="wpcf7-list-item-label"><?php _e("Enable project Todo ?", "woffice"); ?></span>
							</label>
						</span>
					</span>
				</p>
				<p>
					<span class="wpcf7-checkbox">
						<span class="wpcf7-list-item">
							<label class="frontend-checkbox">
								<input type="checkbox" name="enable_files" id="enable_files" value="yes">
								<span class="wpcf7-list-item-label"><?php _e("Enable project Files Manager ?", "woffice"); ?></span>
							</label>
						</span>
					</span>
				</p>
			<?php } elseif ($type == 'directory') { 
			/* if it's for a Directory POST */
		 	?>
		 	
		 		<?php 
			 		
			 		/* Function that output a field creator like the projects taks
				 		'box-options' => array(
				        'title' => array( 'type' => 'text', 'label' => __('Content', 'woffice')),
				        'icon' => array( 'type' => 'icon', 'label' => __('Icon', 'woffice'),'value' => 'fa-star'),			    
				    ),
				     */
			 		
		 		?> 
		 	
		 		<div class="row">
			    	<div class="col-md-6">
					    <p>
					        <label for="item_location_lng"><?php _e( 'Location\'s Longitude :', 'woffice' ); ?></label>
							<small><?php _e( 'You can use : ', 'woffice' ); ?><a href="http://www.latlong.net/" target="_blank">LatLong.net</a></small>
					        <input type="text" name="item_location_lng" id="item_location_lng" placeholder="-88.242188" />	 
					    </p>
			    	</div>
			    	<div class="col-md-6">
					    <p>
					        <label for="item_location_lat"><?php _e( 'Location\'s Latitude :', 'woffice' ); ?></label>
							<small><?php _e( 'You can use : ', 'woffice' ); ?><a href="http://www.latlong.net/" target="_blank">LatLong.net</a></small>
					        <input type="text" name="item_location_lat" id="item_location_lat" placeholder="37.544577" />	 
					    </p>
			    	</div>
			    </div>
		 	
		 		<div class="row">
			    	<div class="col-md-6">
					    <p>
					        <label for="item_button_text"><?php _e( 'Button\'s text:', 'woffice' ); ?></label>
							<small><?php _e( 'Button will be displayed on the single page.', 'woffice' ); ?></small>
					        <input type="text" name="item_button_text" id="item_button_text" />	 
					    </p>
			    	</div>
			    	<div class="col-md-6">
					    <p>
					        <label for="item_button_icon"><?php _e( 'Button\'s Icon (Font Awesome) :', 'woffice' ); ?></label>
							<small><?php _e( 'Please see : ', 'woffice' ); ?><a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">FontAwesome Icons</a></small>
					        <input type="text" name="item_button_icon" id="item_button_icon" placeholder="fa-star" />	 
					    </p>
			    	</div>
			    	<div class="col-md-12">
					    <p>
					        <label for="item_button_link"><?php _e( 'Button\'s Link :', 'woffice' ); ?></label>
					        <input type="text" name="item_button_link" id="item_button_link" />	 
					    </p>
			    	</div>
			    </div>
			    
			    <?php 
		    	// SEARCH FOR DIRECTORY CATEGORIES
                $terms = get_terms('directory-category', array('hide_empty' => false));
				if ($terms) : ?>
					<p>            
				        <label for="directory_category"><?php _e( 'Directory\'s Category:', 'woffice' ); ?></label>
				        <?php // DROPDOWN LIST
				        echo'<select multiple="multiple" name="directory_category[]" class="postform form-control">';
					        echo'<option value="no-category">'. __("No category","woffice") .'</option>';
					        foreach ( $terms as $term ) {
					            printf( '<option value="%s">%s</option>', esc_attr( $term->slug ), esc_html( $term->name ) );
					        }
				        echo'</select>'; ?>
				    </p>
				<?php endif; ?>
		    
		    <?php } else { 
			/* if it's for a POST POST */
		 	?>
		 		
		 		<?php 
	        	// SEARCH FOR BLOG CATEGORIES
				$blog_categories_args = array(
					'type'                     => 'post',
					'orderby'                  => 'name',
					'order'                    => 'ASC',
					'number'				   => '0',
					'taxonomy'                 => 'category',
                    'hide_empty'               => false
				);
				$terms = get_categories($blog_categories_args);
				if ($terms) : ?>
					<p>            
				        <label for="blog_category"><?php _e( 'Article\'s Category :', 'woffice' ); ?></label>
				        <?php // DROPDOWN LIST
				        echo'<select multiple="multiple" name="blog_category[]" class="postform form-control">';
					        echo'<option value="no-category">'. __("No category","woffice") .'</option>';
					        foreach ( $terms as $term ) {
					            printf( '<option value="%s">%s</option>', esc_attr( $term->slug ), esc_html( $term->name ) );
					        }
				        echo'</select>'; ?>
				    </p>
				<?php endif; ?>	
		    
		    <?php } 
			    
			if ($type != 'wiki' && $type != 'project') { ?>
				
				<p>            
			        <label for="post_thumbnail"><?php _e( 'Article\'s Thumbnail :', 'woffice' ); ?></label>
			        <input type="file" name="post_thumbnail" id="post_thumbnail">
			    </p>
				
			<?php } ?>
			
		    <p>  
		        <?php /* Content Label */
		        $content_label = ($type == "project") ? __( 'Project\'s Description:', 'woffice') : __( 'Article\'s Content:', 'woffice');  ?>          
		        <label for="post_content"><?php echo $content_label; ?></label>
		        <?php 
		        	$settings = array(
		        		'textarea_name' => 'post_content',
		        		'textarea_rows' => '20',
		        		'dfw' => true
		        	);
			        wp_editor('', 'post_content', $settings);
		        ?>
		    </p>

            <?php if($type == 'blog'):
                if(woffice_current_is_admin()):
                ?>
                    <p>
                        <label for="everyone_edit">Everyone can edit?</label>
                        <input type="checkbox" name="everyone_edit" id="everyone_edit" value="yes"/>
                    </p>
                <?php endif; ?>
            <?php endif; ?>

		    <p class="text-right">        
		        <?php wp_nonce_field( 'post_nonce', 'post_nonce_field' ); ?>
		        <input type="hidden" name="submitted" id="submitted" value="true" />
		        <?php /* Button Label */
		        $button_label = ($type == "project") ? __( 'Create Project', 'woffice') : __( 'Create Article', 'woffice');  ?>
		        <button type="submit" class="btn btn-default"><i class="fa fa-pencil"></i> <?php echo $button_label; ?></button>
		    </p>
		</form>
		<?php
	
		/* This is the "Go Back" button */
		echo'<div class="center">
			<a href="javascript:void(0)" class="btn btn-default" id="hide-'.$type.'-create">
				<i class="fa fa-arrow-left"></i> '. __("Go Back", "woffice") .'
			</a>
		</div>';
	echo'</div>';
	
 
}

/**
 * We re-recreate an addable option 
 * http://manual.unyson.io/en/latest/options/built-in-option-types.html#addable-option
 * On the FRONTEND, this is relative to a post
 * $post_id INTEGER, it's the post's ID
 * $field_name STRING, it's the field's name
 * $field_options ARRAY, an array of Unyson options
 * $field_label STRING, it's the field's label
 * - 
 * Returns HTTML
 *
 * Not Ready for now .... 
 */
function woffice_addable_option_form ($post_id, $field_name, $field_options, $field_label) {
	
	if (empty($post_id) || empty($field_name) || empty($field_options) || empty($field_label)) {
		return;
	}
	
	// 
	// We display the current values
	//
	/* Get all the existing todos : */
	$box_content = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option($post_id, $field_name) : '';
	/*Values */
	echo'<form id="woffice-addable-box-list" class="woffice-project-todo-group" action="'.$_SERVER['REQUEST_URI'].'" method="POST">';
	/* First we display all the values */
	if (!empty($box_content)){
		echo'<input type="hidden" name="post_ID" value="'.$post_id.'" />';
		$counter = 0;
		foreach ($box_content as $fields) {
			$note_class = "";
			echo '<div class="woffice-box '.$note_class.'">';
				echo '<ul>';
				/* We display each field within the box */
				foreach ($fields as $field_name=>$field_value) {
					echo '<li><i class="fa fa-arrow-right"></i> '.$field_name.'</li>';
				}
				echo '</ul>';
				
				/* Delete Icon */
				echo '<a href="#" onclick="return false" class="woffice-box-delete"><i class="fa fa-trash-o"></i></a>';
				
				/* We create some input fields to pass the data through ajax form */
				foreach ($fields as $field_name=>$field_value) {
					echo '<li><i class="fa fa-arrow-right"></i> '.$field_name.'</li>';
					echo '<input type="hidden" name="addable_list['.$counter.']['.$field_name.']" value="'.$field_value.'" />';
				}
				/* Other Data */
				echo'<input type="hidden" name="post_ID" value="'.$post_id.'" />';
				echo'<input type="hidden" name="action" value="wofficeAddableDelete" />';
			echo '</div>';
			$counter++;
		}
	}
	echo '</form>';
	
	//
	// THE FORM TO ADD A NEW BOX
	// 
	echo '<div id="woffice-addable-box-alert"></div>';
	echo '<form id="woffice-addable-box" action="'.$_SERVER['REQUEST_URI'].'" method="POST">';
		/* The heading */
		echo '<div class="heading"><h3>'.$field_label.'</h3></div>';
		
		/* The Fields */
		foreach ($field_options as $option_name=>$option) {
			echo '<div class="row">';
				echo '<div class="col-md-6">'; 
					echo '<label for="'.$option_name.'">'.$option->label.'</label>';
					if ($option->type == "text") {
						echo '<input type="text" name="'.$option_name.'" required="required">';
					} elseif ($option->type == "textarea") {
						echo '<textarea rows="2" name="'.$option_name.'"></textarea>';
					} elseif ($option->type == "icon") {
						echo '<select name="'.$option_name.'" class="form-control">';
						// We grab all the icons : 
						$response_icon = wp_remote_get( 'https://raw.githubusercontent.com/Smartik89/SMK-Font-Awesome-PHP-JSON/master/font-awesome/json/font-awesome-data-readable.json' );
						if( is_array($response_icon) ) {
						  	$body = $response_icon['body']; // use the content
						  	$icons = json_decode($body);
							foreach ($icons as $class => $name) {
								echo'<option value="'.$class.'"><i class="fa '.$class.'></i> "'.$name.'</option>';
							}
						} else {
							echo'<option value="no-icon">'.__('No icon available.','woffice').'</option>';
						}
					echo'</select>';
				}
			echo '</div>';
			echo'</div>';
		}
		
		/* Submit button */
		echo '<div class="text-right">';
			echo '<button type="submit" class="btn btn-default"><i class="fa fa-plus-square-o"></i> '.__('Add a box','woffice').'</button>';
		echo '</div>';
		
		/* Passing extra args */
		echo'<input type="hidden" name="post_ID" value="'.$field_name.'" />';
		echo'<input type="hidden" name="option_name" value="'.$post_id.'" />';
		echo'<input type="hidden" name="action" value="wofficeAddableFrontend" />';
	echo '</form>';
	
	/* SCRIPT called */
	echo '<script type="text/javascript">
	jQuery(document).ready( function() {
		// Delete Box
		jQuery(".woffice-box").on("click", ".woffice-box-delete", function(){
			var Item = jQuery(this).closest(".woffice-box");
			Item.remove();
			var woffice_BoxDelete_data = jQuery("#woffice-addable-box-list").serialize();
			jQuery.ajax({
				type:"POST",
				url: "'.get_site_url().'/wp-admin/admin-ajax.php",
				data: woffice_BoxDelete_data,
				success:function(returnval){
					console.log("task removed");
					jQuery("#woffice-addable-box-alert").html(returnval);
					jQuery("#woffice-addable-box-alert div.infobox").hide(4000, function(){ jQuery("#woffice-addable-box-alert div.infobox").remove(); });	
				},
			}); return false;
		});
				
	});
	</script>';
	
}

//
// AJAX HANDLERS
// 
/*function wofficeAddableFrontend(){
	
	// We get the ID from the current post
	$the_ID = $_POST['post_ID'];
	// We get the current option name 
	$the_option = $_POST['option_name'];
	
	if (!empty($the_ID)) {
		// We get the value which is an array : 
		$the_option_array = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option($the_ID, $the_option) : '';
		if (!empty($the_option_array)){
			print_r($_POST);	
		}
		//fw_set_db_post_option($post_id, $option_id, $value)
	}
	
	//if($updated) {
	//	echo '<div class="infobox fa fa-trash-o" style="background-color: #CC0000;"><p>';
	//		_e('The option has been deleted !','woffice'); 
	//	echo'</p></div>';
	//}
	
	die();
}
add_action('wp_ajax_nopriv_wofficeAddableFrontend', 'wofficeAddableFrontend');
add_action('wp_ajax_wofficeAddableFrontend', 'wofficeAddableFrontend');*/
 
/**
 * Does the user can edit from the frontend
 * Needs to be in the loop
 * - 
 * Returns TRUE or FALSE
 */
function woffice_edit_allowed () {

	/* If the users is not logged we reeturn false */
	if (!is_user_logged_in()){
		return false;
	}
	
	/*We get TRUE or FALSE from the settings */
	$everyone_edit = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option(get_the_ID(), 'everyone_edit') : '';

	/* We get the current user data */
	$user = wp_get_current_user();

	if ($everyone_edit == true) {
		return true;
	}
	/* If it's not allowed for everyone */
	else {
		/* We get the auhor's ID */
        global $post;
		if ($post->post_author == $user->ID || woffice_current_is_admin()) {
			return true;
		}
		else {
			return false;
		}
	}
	 
}



function woffice_render_featured_image_single_post($id, $featured_height = "", $masonry = false)
{
    /*GETTING THE POST THUMBNAIL URL*/
    $auto_height = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('auto_height_featured_image') : 'nope';

    $woffice_thumb_url = wp_get_attachment_url(get_post_thumbnail_id($id));
    if ($auto_height != 'auto'):

        $featured_height = (empty($featured_height)) ? $featured_height : 'height: '.esc_attr($featured_height).'px;';
        ?>
        <div class="intern-thumbnail" style="background-image: url(<?php echo esc_url($woffice_thumb_url); ?>); <?php echo $featured_height ?>;">
            <?php if (!is_single()): ?>
                <a href="<?php the_permalink(); ?>"></a>
            <?php endif; ?>
        </div>
        <?php
    else:
        ?>
        <div class="intern-thumbnail auto-height" >
            <?php if (!is_single()): ?>
                <a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url($woffice_thumb_url); ?>"></a>
            <?php else: ?>
                <img src="<?php echo esc_url($woffice_thumb_url); ?>">
            <?php endif; ?>
        </div>
    <?php endif; ?>


    <?php
}