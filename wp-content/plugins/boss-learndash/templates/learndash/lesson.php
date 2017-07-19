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
		$post 			: (object) The lesson post object
		$topics 		: (array) Array of Topics in the current lesson
		$all_quizzes_completed : (true/false) User has completed all quizzes on the lesson Or, there are no quizzes.
		$lesson_progression_enabled 	: (true/false)
		$show_content	: (true/false) true if lesson progression is disabled or if previous lesson is completed. 
		$previous_lesson_completed 	: (true/false) true if previous lesson is completed
		$lesson_settings : Settings sepecific to the current lesson.

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
	if(@$lesson_progression_enabled && !@$previous_lesson_completed ) {
		?>
        <div id='learndash_complete_prev_lesson'><i class="fa fa-info-circle"></i><?php  _e('Please go back and complete the previous lesson.', 'boss-learndash'); ?></div>
		<?php
		add_filter('comments_array', 'learndash_remove_comments', 1,2);
	}
    ?>
    <?php
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
        <span><?php _e('Lesson', 'boss-learndash'); ?></span>
        <h1 class="entry-title"><?php the_title(); ?></h1>
    </header>
	<?php
	if($show_content)
	{
        echo '<div class="lms-post-content">';
		echo $content;
        echo '</div>';
			
		/* Lesson Topis */
		/*
		Topics Array Format
			(
			    [0] => WP_Post Object
			        (
			            [ID] => 584
			            [post_author] => 1
			            [post_date] => 2014-02-05 22:24:06
			            [post_date_gmt] => 2014-02-05 22:24:06
			            [post_content] => 
			            [post_title] => Lesson Topic 
			            [post_excerpt] => 
			            [post_status] => publish
			            [comment_status] => open
			            [ping_status] => open
			            [post_password] => 
			            [post_name] => lesson-topic
			            [to_ping] => 
			            [pinged] => 
			            [post_modified] => 2014-02-05 22:24:06
			            [post_modified_gmt] => 2014-02-05 22:24:06
			            [post_content_filtered] => 
			            [post_parent] => 0
			            [guid] => http://domain.com/?post_type=sfwd-topic&p=584
			            [menu_order] => 0
			            [post_type] => sfwd-topic
			            [post_mime_type] => 
			            [comment_count] => 0
			            [filter] => raw
			            [completed] => 0
			        )

			)
		*/
		if(!empty($topics)) {
		?>
		<div id='learndash_lesson_topics_list'>
		<div id="learndash_topic_dots-<?php echo $post->ID; ?>" class="learndash_topic_dots type-list">
			<h2><?php _e('Lesson Topics', 'boss-learndash'); ?></h2>
			<ul>
				<?php
				$odd_class = "";
				foreach ($topics as $key => $topic) { 
					$odd_class = empty($odd_class)? "nth-of-type-odd":"";
					$completed_class = empty($topic->completed)? "topic-notcompleted":"topic-completed";
					?>
					<li class="<?php echo $odd_class; ?>">
						<span class="topic_item">
							<a class="<?php echo $completed_class; ?>" href="<?php echo get_permalink($topic->ID); ?>" title="<?php echo $topic->post_title; ?>">
								<?php echo $topic->post_title; ?>
							</a>
						</span>
					</li>
				<?php } ?>
			</ul>
		</div>
		</div>
		<?php } ?>

		<?php

		/* Show Quiz List */
		if ( !empty( $quizzes ) ) {
			?>
			<div id='learndash_quizzes'>
				<div id="quiz_heading"><span><?php _e('Quizzes', 'boss-learndash') ?></span></div>
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
			    <?php if(!empty($assignments)){ ?>
				<h2><?php _e("Files you have uploaded","boss-learndash"); ?></h2>
				<table>
					<?php
                    foreach($assignments as $assignment){
                            ?>
                            <tr>
                                <td><a href="<?php echo get_post_meta($assignment->ID, "file_link", true); ?>" target="_blank"><?php echo __("Download", "boss-learndash")." ".get_post_meta($assignment->ID, "file_name", true); ?></a></td>
                                <td> <a href="<?php echo get_permalink($assignment->ID); ?>"><?php _e("Comments", "boss-learndash"); ?></a></td>
                            </tr>
                            <?php 
                    }
					?>
				</table>
                <?php } ?>
			</div>
			<?php 
		}
		
		/* Show Mark Complete Button */
		if($all_quizzes_completed && $logged_in) {
			?>
			<?php echo learndash_mark_complete($post); ?>
			<?php
		}
		
	}
	?>
<?php

