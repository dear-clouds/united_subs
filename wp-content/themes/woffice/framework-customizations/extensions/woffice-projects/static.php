<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
/**
 * LOAD THE JAVASCRIPT FOR THE PROJECT
 */
if ( !is_admin() ) {

	$ext_instance = fw()->extensions->get( 'woffice-projects' );

	// LOAD PROJECTS SCRIPTS STYLES
	if (is_page_template("page-templates/projects.php") || is_singular('project')):
		wp_enqueue_style(
			'fw-extension-'. $ext_instance->get_name() .'-datepicker-styles',
			$ext_instance->get_declared_URI( '/static/css/bootstrap-datepicker.min.css' ),
			array(),
			$ext_instance->manifest->get_version()
		);
		wp_enqueue_script(
			'fw-projects-datepicker',
			$ext_instance->get_declared_URI( '/static/js/bootstrap-datepicker.js' ),
			array( 'jquery' ),
			'1.0',
			true
		);
		wp_enqueue_script(
			'fw-sortable',
			$ext_instance->get_declared_URI( '/static/js/jquery-sortable-min.js' ),
			array( 'jquery' ),
			'1.0',
			true
		);
		wp_enqueue_script(
			'fw-projects',
			$ext_instance->get_declared_URI( '/static/js/projects.js' ),
			array( 'jquery' ),
			'1.0',
			true
		);
	endif;
	
	// AJAX STUFF FOR THE TODO MANAGER
	if (is_singular('project')):
		wp_localize_script('fw-extension-'. $ext_instance->get_name() .'-woffice-todo-manager', 'fw-extension-'. $ext_instance->get_name() .'-woffice-todo-manager', array('ajaxurl' =>  admin_url('admin-ajax.php')));
		
		// IF A TASK IS DELETED
		function woffice_taskmanager_delete_ajax() {
			echo'<script type="text/javascript">
			jQuery(document).ready( function() {
			
				jQuery("#woffice-project-todo").on("click", ".woffice-task header .woffice-todo-delete", function(){
					// We get the Task associated to the clicked trash
					var Task = jQuery(this).closest(".woffice-task");
					// We hide it
					Task.remove();

					//WE SEND THE FORM DATA
					if(jQuery("input[name=\"project_todo_lists\"]").val()) {
						var woffice_TodoDelete_data = jQuery("form#woffice-project-todo").serialize();
					} else {
						var woffice_TodoDelete_data = {
							action : "wofficeTodoDelete",
							post_ID : jQuery("input[name=\"post_ID\"]").val()
						};
					}
					// We run a PHP function to save the post meta
					jQuery.ajax({
						type:"POST",
						url: "'.get_site_url().'/wp-admin/admin-ajax.php",
						data: woffice_TodoDelete_data,
						success:function(returnval){
							console.log("task removed");
							jQuery("#woffice-add-todo-alert").html(returnval);
							jQuery("#woffice-add-todo-alert div.infobox").hide(4000, function(){ jQuery("#woffice-add-todo-alert div.infobox").remove(); });	
						},
					});
					
					return false;
					
				});
				
			});
			</script>';
		}
		add_action( 'wp_head', 'woffice_taskmanager_delete_ajax' );
		
		// IF A TASK IS UPDATED
		function woffice_taskmanager_check_ajax() {
			echo'<script type="text/javascript">
			jQuery(document).ready( function() {
			
				jQuery("#woffice-project-todo").on("click", ".woffice-task header label input", function(){
					
					var $checkbox = jQuery(this);
					$checkbox.prop("checked", !$checkbox.prop("checked"));
				
					// We get the Task associated to the clicked task
					var Task = jQuery(this).closest(".woffice-task");
					Task.toggleClass("is-done");
					
					// We find the input element with the Done data : 
					var dataCheck = Task.children(".done-data");
					if (dataCheck.val() == "") {
						dataCheck.val(1);
					}
					else {
						dataCheck.val("");
					} 
					var dataAction = Task.children("input[name=\"action\"]");
					dataAction.val("wofficeTodoCheck");
										
					//WE SEND THE FORM DATA
					var woffice_TodoCheck_data = jQuery("#woffice-project-todo").serialize();
					
					// We run a PHP function to save the post meta
					jQuery.ajax({
						type:"POST",
						url: "'.get_site_url().'/wp-admin/admin-ajax.php",
						data: woffice_TodoCheck_data,
						success:function(returnval){
							console.log("task updated");	
						},
					});
					
					return false;
					
				});
				
			});
			</script>';
		}
		add_action( 'wp_head', 'woffice_taskmanager_check_ajax' );
		
		// IF A TASK IS ADDED
		function woffice_taskmanager_addnew_ajax() {
			echo'<script type="text/javascript">
			jQuery(document).ready( function() {
			
				jQuery("#woffice-add-todo").submit(ajaxSubmitTodo);
		
				function ajaxSubmitTodo(){
				
				
					if(jQuery("input[name=todo_name]").val()) {
						
						// WE GET ALL THE DATA
						var taskName = jQuery("input[name=todo_name]").val();
						var taskDate = jQuery("input[name=todo_date]").val();
						var taskAssigned = jQuery("select[name=todo_assigned]").val();
						var taskNote = jQuery("textarea[name=todo_note]");
						
						if (taskDate) {
							var taskDateHTML = "<span class=\"todo-date\"><i class=\"fa fa-calendar\"></i> "+ taskDate +"</span>";
						}
						else {
							var taskDateHTML = "";
						}
						if (taskNote.val().trim().length > 0) {
							var taskNoteHTML = "<i class=\"fa fa-file-text-o\"></i>";
							var taskNoteHTML2 = "<div class=\"todo-note\"><p>"+ taskNote.val() +"</p></div>";
							var taskNoteClass = "has-note";
						}
						else {
							var taskNoteHTML = "";
							var taskNoteHTML2 = "";
							var taskNoteClass = "";
						}
						
						// THE NEW TASK HTML
						var newTaskHTML = "<div class=\"woffice-task "+ taskNoteClass +"\" >" +
							"<header>" +
								"<label class=\"woffice-todo-label\">" +
									"<input type=\"checkbox\" name=\"woffice-todo-done\">" +
									"<span class=\"checkbox-style\"></span>" + 
									taskName +
								"</label>" +
								"<a href=\"#\" onclick=\"return false\" class=\"woffice-todo-delete\"><i class=\"fa fa-trash-o\"></i></a>" +
								taskDateHTML +
								taskNoteHTML +
							"</header>" +
							taskNoteHTML2 +
						"</div>";
						
						jQuery(newTaskHTML).appendTo("#woffice-project-todo").hide().slideDown();
						
						
				
						//WE SEND THE NEW FORM DATA
						var woffice_TodoADD_data = jQuery(this).serialize();
						
						// We run a PHP function to save the post meta
						jQuery.ajax({
							type:"POST",
							url: "'.get_site_url().'/wp-admin/admin-ajax.php",
							data: woffice_TodoADD_data,
							success:function(returnval){
								console.log("task added");	
								jQuery("#woffice-add-todo-alert").html(returnval);
								jQuery("#woffice-add-todo-alert div.infobox").hide(4000, function(){ jQuery("#woffice-add-todo-alert div.infobox").remove(); });
							},
						});
						
						return false;
					
					}
				
				}
				
			});
			</script>';
		}
		add_action( 'wp_head', 'woffice_taskmanager_addnew_ajax' );
		
	endif;
}