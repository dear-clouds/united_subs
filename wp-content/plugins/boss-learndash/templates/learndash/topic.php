<?php
	/*
		Available Variables:
		$course_id 		: (int) ID of the course
		$course 		: (object) Post object of the course
		$course_settings : (array) Settings specific to current course
		$course_status 	: Course Status
		$has_access 	: User has access to course or is enrolled.

		$courses_options : Options/Settings as configured on Course Options page
		$lessons_options : Options/Settings as configured on Lessons Options page
		$quizzes_options : Options/Settings as configured on Quiz Options page

		$user_id 		: (object) Current User ID
		$logged_in 		: (true/false) User is logged in
		$current_user 	: (object) Currently logged in user object
		$quizzes 		: (array) Quizzes Array
		$post 			: (object) The topic post object
		$lesson_post 	: (object) Lesson post object in which the topic exists
		$topics 		: (array) Array of Topics in the current lesson
		$all_quizzes_completed : (true/false) User has completed all quizzes on the lesson Or, there are no quizzes.
		$lesson_progression_enabled 	: (true/false)
		$show_content	: (true/false) true if lesson progression is disabled or if previous lesson and topic is completed. 
		$previous_lesson_completed 	: (true/false) true if previous lesson is completed
		$previous_topic_completed	: (true/false) true if previous topic is completed
	*/
	?>
    <div id='post-entries'>
        <div class="nav-prev">
            <?php echo learndash_previous_post_link(); ?>
        </div>
        <div class="nav-next">
            <?php echo learndash_next_post_link(); ?>
        </div>
    </div>
    <?php
	/* Previous Topic Incomplete Message */
	if($lesson_progression_enabled && !$previous_topic_completed)
	{
		?>
		<div id='learndash_complete_prev_topic'><i class="fa fa-info-circle"></i><?php  _e('Please go back and complete the previous topic.', 'learndash'); ?></div>
		<?php
	}
	else 	/* Previous Lesson Incomplete Message */
	if($lesson_progression_enabled && !$previous_lesson_completed) {
		?>
		<span id='learndash_complete_prev_lesson'><?php _e('Please go back and complete the previous lesson.', 'learndash'); ?></span>
		<?php 
	}
    if($show_content) {
        $course_video_embed = get_post_meta( $post->ID, '_boss_edu_post_video', true );
        if ( 'http' == substr( $course_video_embed, 0, 4) ) {
            // V2 - make width and height a setting for video embed
            $course_video_embed = wp_oembed_get( esc_url( $course_video_embed )/*, array( 'width' => 100 , 'height' => 100)*/ );
        } // End If Statement
        if ( '' != $course_video_embed ) {
        ?><div class="lesson-video"><?php echo html_entity_decode($course_video_embed); ?></div><?php
        } // End If Statement
    }
    ?>
     <header class="entry-header">
        <span><?php _e('Topic', 'boss-learndash'); ?></span>
        <h1 class="entry-title"><?php the_title(); ?></h1>
    </header>
    <?php
	/* Topic Dots */
	if(!empty($topics)) {
		?>
		<div id="learndash_topic_dots-<?php echo $lesson_id; ?>" class="learndash_topic_dots type-dots">
			<strong><?php _e('Topic Progress:', 'learndash'); ?></strong>
			<?php
			foreach ($topics as $key => $topic) { 
				$completed_class = empty($topic->completed)? "topic-notcompleted":"topic-completed";
				?>
				<a class="<?php echo $completed_class; ?>" href="<?php echo get_permalink($topic->ID); ?>" title="<?php echo $topic->post_title; ?>">
					<span title="<?php echo $topic->post_title; ?>"></span>
				</a>
			<?php } ?>
		</div>
		<?php 
	}

	if($show_content)
	{
		/* Show Topic Content */
        echo '<div class="lms-post-content">';
		echo $content;
        echo '</div>';

		/* Show Topic Quizzes */		
		if ( !empty( $quizzes ) ) {
			?>
			<div id='learndash_quizzes'>
				<div id="quiz_heading"><span><?php _e('Quizzes', 'learndash') ?></span></div>
				<div id="quiz_list">
				<?php foreach($quizzes as $quiz) { ?>
					<div id="post-<?php echo $quiz["post"]->ID; ?>" class="<?php echo $quiz["sample"];?>">
						<h4>
							<a class="<?php echo $quiz["status"]; ?>" href="<?php echo $quiz["permalink"]?>"><?php echo $quiz["post"]->post_title; ?></a>
						</h4>
					</div>
				<?php } ?>
				</div>
			</div>
			<?php 	
		}
	
		/* Show Lesson Assignments */
		if(lesson_hasassignments($post)) {		
			$assignments = learndash_get_user_assignments($post->ID, $user_id);
			?>
			<div id='learndash_uploaded_assignments'>
				<h2><?php _e("Files you have uploaded","boss-learndash"); ?></h2>
				<table>
					<?php
					if(!empty($assignments)){
						foreach($assignments as $assignment){
								?>
								<tr>
									<td><a href="<?php echo get_post_meta($assignment->ID, "file_link", true); ?>" target="_blank"><?php echo __("Download", "boss-learndash")." ".get_post_meta($assignment->ID, "file_name", true); ?></a></td>
									<td> <a href="<?php echo get_permalink($assignment->ID); ?>"><?php _e("Comments", "boss-learndash"); ?></a></td>
								</tr>
								<?php 
						}
					}	
					?>
				</table>
			</div>
			<?php 
		}
	
		/* Show Mark Complete Button */
		if($all_quizzes_completed)
			echo learndash_mark_complete($post);
	}
	/* Back to Lesson Link */
	?>
<div id='learndash_back_to_lesson'><a href='<?php echo get_permalink($lesson_id); ?>'><i class="fa fa-mail-reply"></i> <?php _e("Back to Lesson","boss-learndash"); ?></a></div>
	<?php					



