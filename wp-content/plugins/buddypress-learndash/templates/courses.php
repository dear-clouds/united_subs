<?php
/**
 * @package WordPress
 * @subpackage BuddyPress for LearnDash
 */
?>

<?php
$user_id = bp_displayed_user_id();
$user_courses = ld_get_mycourses($user_id);
$usermeta = get_user_meta( $user_id, '_sfwd-quizzes', true );
$quiz_attempts_meta = empty($usermeta) ?  false : $usermeta;
$quiz_attempts  = array();

if(!empty($quiz_attempts_meta)){
    foreach($quiz_attempts_meta as $quiz_attempt) {
        $c = learndash_certificate_details($quiz_attempt['quiz'], $user_id);
        $quiz_attempt['post'] = get_post( $quiz_attempt['quiz'] );
        $quiz_attempt["percentage"]  = !empty($quiz_attempt["percentage"])? $quiz_attempt["percentage"]:(!empty($quiz_attempt["count"])? $quiz_attempt["score"]*100/$quiz_attempt["count"]:0  );

        if($user_id == get_current_user_id() && !empty($c["certificateLink"]) && ((isset($quiz_attempt['percentage']) && $quiz_attempt['percentage'] >= $c["certificate_threshold"] * 100)))
            $quiz_attempt['certificate'] = $c;
        $quiz_attempts[learndash_get_course_id($quiz_attempt['quiz'])][] = $quiz_attempt;
    }
}
?>
<div id="learndash_profile" class="<?php echo empty( $user_courses ) ? 'user-has-no-lessons' : '';  ?>">
    <div id="course_list">
        <?php
        if(!empty($user_courses)) {
            foreach($user_courses as $course_id) {

                /**
                 * Do not show the free/open course unless those are explicitly started by the users
                 *
                 */

                //Check user have enrolled for course
                $since = ld_course_access_from( $course_id,  $user_id );

                /**
                 * if $since is empty then this could be a free/open course
                 * however we need to check for learndash group level course enrollment status
                 */
                if ( empty( $since ) ) {

                    //Check user has mass enrolled for course
                    $since = learndash_user_group_enrolled_to_course_from( $user_id, $course_id );

                    /**
                     * if $since is still empty then we absolutely sure that the course is free/open
                     * now we only need to check "Has user started taking course? or Did he completed it?"
                     */
                    if ( empty( $since ) ) {

                        //Check user has started course(topic or lesson)
                        $course_status = bp_learndash_course_status( $course_id, $user_id );

                        if ( 'not_started' === $course_status ) {
                            continue;
                        }
                    }
                }

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
                            <div class="learndash_profile_heading course_overview_heading"><?php printf( __("%s Progress Overview", "buddypress-learndash"), LearnDash_Custom_Label::get_label( 'course' ) ); ?></div>
                            <div class="overview table">
                                <div class="table-cell">
                                    <dd class="course_progress" title="<?php echo sprintf(__("%s out of %s steps completed", 'buddypress-learndash'),$progress["completed"], $progress["total"]); ?>">
                                        <div class="course_progress_blue" style="width: <?php echo $progress["percentage"]; ?>%;"> 
                                    </dd>
                                </div>
                                <div class="table-cell">
                                    <div class="right">
                                        <?php echo sprintf(__("%s%% Complete", 'buddypress-learndash'), $progress["percentage"]); ?>
                                    </div>
                                </div>
                            </div>
                            <?php if(!empty($quiz_attempts[$course_id])) { ?>
                                <div class="learndash_profile_quizzes clear_both">
                                    <div class="learndash_profile_quiz_heading">
                                        <div class="quiz_title"><?php echo LearnDash_Custom_Label::get_label( 'quizzes' ) ?></div>
                                        <div class="certificate"><?php _e("Certificate", "buddypress-learndash"); ?></div>
                                        <div class="scores"><?php _e("Score", "buddypress-learndash"); ?></div>
                                        <div class="quiz_date"><?php _e("Date", "buddypress-learndash"); ?></div>
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
                                                <div class="quiz_date"><?php echo date_i18n( "d-M-Y", $quiz_attempt['time'] ) ?></div>
                                            </div>
                                        <?php }
                                    } ?>
                                </div>
                            <?php } ?>
                        </div>
                    </h4>
                </div>
            <?php } 
		} else { ?>
			<p class="no-lesson-msg"><strong><?php printf( __('No %s found.','buddypress-learndash'), LearnDash_Custom_Label::label_to_lower( 'courses' ) ); ?></strong></p><?php
		} ?>
    </div>
</div>
