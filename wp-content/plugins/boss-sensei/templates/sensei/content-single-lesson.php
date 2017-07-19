<?php
/**
 * The template for displaying product content in the single-lessons.php template
 *
 * Override this template by copying it to yourtheme/sensei/content-single-lesson.php
 *
 * @author 		WooThemes
 * @package 	Sensei/Templates
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

 global $woothemes_sensei, $post, $current_user, $view_lesson, $user_taking_course;
 // Content Access Permissions
 $access_permission = false;
 if ( ( isset( $woothemes_sensei->settings->settings['access_permission'] ) && ! $woothemes_sensei->settings->settings['access_permission'] ) || sensei_all_access() ) {
 	$access_permission = true;
 } // End If Statement

?>
            <?php do_action('sensei_pagination'); ?>
           
            <?php 

            $post_id = $post->ID;
            $user_id = $current_user->ID;
            // Get the prerequisite lesson
            $lesson_prerequisite = (int) get_post_meta( $post_id, '_lesson_prerequisite', true );
            $lesson_course_id = (int) get_post_meta( $post_id, '_lesson_course', true );

            // Lesson Quiz Meta
            $quiz_id = $woothemes_sensei->post_types->lesson->lesson_quizzes( $post_id );
            $has_user_completed_lesson = WooThemes_Sensei_Utils::user_completed_lesson( intval( $post_id ), $user_id );
            $show_actions = is_user_logged_in() ? true : false;

            if( intval( $lesson_prerequisite ) > 0 ) {

                // If the user hasn't completed the prereq then hide the current actions
                $show_actions = WooThemes_Sensei_Utils::user_completed_lesson( $lesson_prerequisite, $user_id );
            }
            ?><?php
            if ( $quiz_id && is_user_logged_in() && WooThemes_Sensei_Utils::user_started_course( $lesson_course_id, $user_id ) ) { ?>
                <?php $no_quiz_count = 0; ?>
                <?php
                    $has_quiz_questions = get_post_meta( $post_id, '_quiz_has_questions', true );
                    // Display lesson quiz status message
                    if ( $has_user_completed_lesson || $has_quiz_questions ) {
                        $status = WooThemes_Sensei_Utils::sensei_user_quiz_status_message( $post_id, $user_id, true );
                        echo '<div class="sensei-message ' . $status['box_class'] . '">' . $status['message'] . '</div>';
                    } // End If Statement
                ?>
            <?php }  ?>
           
        	<article <?php post_class( array( 'lesson', 'post' ) ); ?>>
                <?php // Modification:

        	    ?>
				<?php do_action( 'sensei_lesson_image', $post->ID ); ?>
				
				<?php //Modification //do_action( 'sensei_lesson_single_title' ); ?>

                <?php

                $view_lesson = true;

                wp_get_current_user();


                $lesson_prerequisite = absint( get_post_meta( $post->ID, '_lesson_prerequisite', true ) );


				if ( $lesson_prerequisite > 0 ) {
					// Check for prerequisite lesson completions
					$view_lesson = WooThemes_Sensei_Utils::user_completed_lesson( $lesson_prerequisite, $current_user->ID );
				}

				$lesson_course_id = get_post_meta( $post->ID, '_lesson_course', true );
				$user_taking_course = WooThemes_Sensei_Utils::user_started_course( $lesson_course_id, $current_user->ID );

				if( current_user_can( 'administrator' ) ) {
					$view_lesson = true;
					$user_taking_course = true;
				}

				$is_preview = false;
				if( WooThemes_Sensei_Utils::is_preview_lesson( $post->ID ) ) {
					$is_preview = true;
					$view_lesson = true;
				};

				if( $view_lesson ) { ?>
					<section class="entry fix">
					<?php if ( $is_preview && !$user_taking_course ) { ?>
						<div class="sensei-message alert"><?php echo $woothemes_sensei->permissions_message['message']; ?></div>
					<?php } ?>

	                	<?php
	                	if ( $access_permission || ( is_user_logged_in() && $user_taking_course ) || $is_preview ) {
	                		if( apply_filters( 'sensei_video_position', 'top', $post->ID ) == 'top' ) {
	                			do_action( 'sensei_lesson_video', $post->ID );
	                		}
                            // Modification
                            do_action( 'sensei_lesson_single_title' );
	                		the_content();
	                	} else {
	                		echo '<p>' . $post->post_excerpt . '</p>';
	                	}
	            		?>
					</section>

					<?php if ( $access_permission || ( is_user_logged_in() && $user_taking_course ) || $is_preview ) {
						do_action( 'sensei_lesson_single_meta' );
					} else {
						do_action( 'sensei_lesson_course_signup', $lesson_course_id );
					} ?>

					<?php

				} else {
                    // Modification
                    do_action( 'sensei_lesson_single_title' );
					if ( $lesson_prerequisite > 0 ) {
						echo sprintf( __( 'You must first complete %1$s before viewing this Lesson', 'boss-sensei' ), '<a href="' . esc_url( get_permalink( $lesson_prerequisite ) ) . '" title="' . esc_attr(  sprintf( __( 'You must first complete: %1$s', 'boss-sensei' ), get_the_title( $lesson_prerequisite ) ) ) . '">' . get_the_title( $lesson_prerequisite ). '</a>' );
					}
				}

				?>
				
            </article><!-- .post -->