<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$user_id = ($atts['user'] == "current") ? get_current_user_id() : $atts['user'];
$ext_instance = fw()->extensions->get( 'woffice-projects' );
$array_result = $ext_instance->woffice_projects_assigned_tasks($user_id);
?>


<div class="project-assigned-container project-assigned-shortcode">

	<div class="project-assigned-head">
		<?php /* the title */
		$user_info = get_userdata($user_id);
		$starter = ($atts['user'] == "current") ? __("You have","woffice") : $user_info->user_login ." ". __("has","woffice");
		$message = $starter. ' <span class="woffice-colored">'. $array_result['number'] .'</span> '. __("tasks","woffice");
		?>
		<h3><i class="fa fa-tasks"></i> <?php echo $message; ?></h3>
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
			<?php if($atts['user'] == "current") : ?>
				<p><strong><?php _e("Well done ! You don't have any task from your projects.","woffice"); ?></strong></p>
			<?php else : ?>
				<p><strong><?php _e("No task found.","woffice"); ?></strong></p>
			<?php endif; ?>
		</div>
	<?php } ?>

</div>