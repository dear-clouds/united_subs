<?php
/*
		Available Variables:
		$user_id 		: Current User ID
		$current_user 	: (object) Currently logged in user object
		$user_courses 	: Array of course ID's of the current user
		$quiz_attempts 	: Array of quiz attempts of the current user
	*/
?>
<div id="learndash_profile">
    <div class="expand_collapse"><a href="#" onClick="return flip_expand_all('#course_list');"><?php _e('Expand All', 'learndash'); ?></a> <span class="sep"><?php _e('/', 'boss-learndash'); ?></span> <a href="#" onClick="return flip_collapse_all('#course_list');"><?php _e('Collapse All','learndash'); ?></a></div>
	<div class="learndash_profile_heading">
        <span class="title"><?php _e("Profile", 'boss-learndash'); ?></span>
        <?php echo '<div class="profile_edit_profile"><a href="'.get_edit_user_link().'">'.__('Edit profile', 'learndash').'</a></div>'; ?>
	</div>
	<div class="profile_info clear_both" style="">
		<div class="profile_avatar" style="">
			<?php echo get_avatar($current_user->user_email, 96); ?>
		</div>
		<div class="learndash_profile_details" style="">
	 <?php if((!empty($current_user->user_lastname))||(!empty($current_user->user_firstname))){ ?>
			<div><b><?php _e("Name", 'boss-learndash'); ?>:</b> <?php echo $current_user->user_firstname." ".$current_user->user_lastname; ?></div>
			<?php
			}
			?>
			<div><b><?php _e("Username", 'boss-learndash'); ?>:</b> <?php echo $current_user->user_login; ?></div>
			<div><b><?php _e("Email", 'boss-learndash'); ?>:</b> <?php echo $current_user->user_email; ?></div>
		</div>
	</div>
	<div class="learndash_profile_heading no_radius clear_both">
			<span class="title"><?php _e("Registered Courses", 'boss-learndash'); ?></span>
			<span class="ld_profile_status"><?php _e("Status", 'boss-learndash'); ?></span>
	</div>
	<div id="course_list-wrap">
        <div id="course_list">
            <?php 
            if(!empty($user_courses))
            foreach($user_courses as $course_id) { 
                $course = get_post($course_id);
                $course_link = get_permalink($course_id);
                $progress = learndash_course_progress(array("user_id" => $user_id, "course_id" => $course_id, "array" => true));
                $status = ($progress["percentage"] == 100)? "completed":"notcompleted";
            ?>
            <div id="course-<?php echo $course->ID; ?>">
                <div class="list_arrow collapse flippable"  onClick="return flip_expand_collapse('#course', <?php echo $course->ID; ?>);"></div>
                <h4>
                    <a class="<?php echo $status; ?>" href="<?php echo $course_link; ?>"><?php echo $course->post_title; ?></a>
                    <div class="flip" style="display:none;">
                        <div class="learndash_profile_heading course_overview_heading"><?php _e("Course Progress Overview", 'boss-learndash'); ?></div>
                        <div class="overview table">
                            <div class="table-cell">
                                <dd class="course_progress" title="<?php echo sprintf(__("%s out of %s steps completed", 'boss-learndash'),$progress["completed"], $progress["total"]); ?>">
                                    <div class="course_progress_blue" style="width: <?php echo $progress["percentage"]; ?>%;"> 
                                </dd>
                            </div>
                            <div class="table-cell">
                                <div class="right">
                                    <?php echo sprintf(__("%s%% Complete", 'boss-learndash'), $progress["percentage"]); ?>
                                </div>
                            </div>
                        </div>
                        <?php if(!empty($quiz_attempts[$course_id])) { ?>
                        <div class="learndash_profile_quizzes clear_both"> 
                            <div class="learndash_profile_quiz_heading">
                                <div class="quiz_title"><?php _e("Quizzes", 'boss-learndash'); ?></div>
                                <div class="certificate"><?php _e("Certificate", 'boss-learndash'); ?></div>
                                <div class="scores"><?php _e("Score", 'boss-learndash'); ?></div>
                                <div class="quiz_date"><?php _e("Date", 'boss-learndash'); ?></div>
                            </div>
                            <?php 
                            foreach( $quiz_attempts[$course_id] as $k => $quiz_attempt ) {
                                $certificateLink = @$quiz_attempt["certificate"]["certificateLink"];
                                $status = empty($quiz_attempt["pass"])? "failed":"passed";
                                $quiz_title = !empty($quiz_attempt["post"]->post_title)? $quiz_attempt["post"]->post_title:@$quiz_attempt['quiz_title'];
                                $quiz_link = !empty($quiz_attempt["post"]->ID)? get_permalink($quiz_attempt["post"]->ID):"#";
                                if(!empty($quiz_title)) {
                                  ?>
                                 <div  class="<?php echo $status; ?>">
                                    <div class="quiz_title"><span class="<?php echo $status; ?>_icon"></span><a href="<?php echo $quiz_link; ?>"><?php echo $quiz_title; ?></a></div>
                                    <div class="certificate"><?php if(!empty($certificateLink)) {?> <a href="<?php echo $certificateLink; ?>&time=<?php echo $quiz_attempt['time'] ?>" target="_blank"><div class="certificate_icon"></div></a><?php } else{ echo '-';	}?></div>

                                    <div class="scores"><?php echo round($quiz_attempt["percentage"],2); ?>%</div>
                                    <div class="quiz_date"><?php echo date_i18n( "d M,Y", $quiz_attempt['time'] ) ?></div>
                                 </div>
                            <?php }
                            } ?>
                        </div>
                        <?php } ?>
                    </div>
                </h4>
            </div>
            <?php } ?>
        </div>
	</div>
</div>
