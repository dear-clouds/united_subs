<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }

echo $before_widget;

/*We get the data : */
$user_id = get_current_user_id(); 
$ext_instance = fw()->extensions->get( 'woffice-projects' );
$array_result = $ext_instance->woffice_projects_assigned_tasks($user_id);
?>
	<!-- WIDGET -->
	<div class="project-assigned-container">
	
		<div class="project-assigned-head">
			<?php echo ($array_result['number'] > 0) ? '<i class="fa fa-tasks"></i>' : ''; ?>
			<div class="intern-box box-title">
				<?php /* the title */
				$message = __("You have","woffice"). ' <span class="woffice-colored">'. $array_result['number'] .'</span> '. __("tasks","woffice");
				?>
				<h3><?php echo $message; ?></h3>
			</div>
		</div>
	
		<?php /* We get the tasks */ 
		$tasks = $array_result['tasks']; 
		if (!empty($tasks)) { ?>
			<ul class="assigned-tasks-list">
				<?php 
				foreach ($tasks as $task){
					echo '<li class="assigned-task">';
						echo '<a href="'.$task['task_project'].'?#project-content-todo">';
							if (!empty($task['task_date'])) {
								echo '<span class="label">'.date(get_option('date_format'),strtotime(esc_html($task['task_date']))).'</span>';
							}
							echo $task['task_name'];
						echo'</a>';
					echo '</li>';
				}
				?>
			</ul>
		<?php } else { ?>
			<div class="assigned-tasks-empty">
				<i class="fa fa-check-circle fa-4x"></i>
				<p><strong><?php _e("Well done ! You don't have any task from your projects.","woffice"); ?></strong></p>
			</div>
		<?php } ?>
		
	</div>
	
<?php echo $after_widget ?>