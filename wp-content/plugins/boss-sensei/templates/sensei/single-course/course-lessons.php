<?php
/**
 * The Template for displaying all single course meta information.
 *
 * Override this template by copying it to yourtheme/sensei/single-course/course-lessons.php
 *
 * @author 		WooThemes
 * @package 	Sensei/Templates
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

global $post, $woothemes_sensei, $current_user;
$html = '';

// Get Course Lessons
$course_lessons = Sensei()->course->course_lessons( $post->ID );
$total_lessons = count( $course_lessons );

// Check if the user is taking the course
$is_user_taking_course = WooThemes_Sensei_Utils::user_started_course( $post->ID, $current_user->ID );

// Get User Meta
get_currentuserinfo();

// exit if no lessons exist
if (  ! ( $total_lessons  > 0 ) ) {
    return;
}

$none_module_lessons = $woothemes_sensei->modules->get_none_module_lessons($post->ID);
$course_modules = wp_get_post_terms($post->ID, $woothemes_sensei->modules->taxonomy);

if ( 0 < $total_lessons ) {


    $html .= '<section class="course-lessons">';
        $html .= '<div class="course-lessons-inner">';

            if (count($none_module_lessons) > 0) {
                
                $html .= '<header>';

                    $html .= '<h2>' . __( 'Other Lessons', 'boss-sensei' ) . '</h2>';

                $html .= '</header>';

            } elseif( empty( $course_modules ) || isset( $course_modules['errors']  ) ){
                // the course has no module show the lessons heading
                $html .= '<header>';

                    $html .= '<h2>' . __( 'Lessons', 'boss-sensei' ) . '</h2>';

                $html .= '</header>';

            }

            $lesson_count = 1;
            $lessons_completed = 0;
            $show_lesson_numbers = false;

            foreach ( $course_lessons as $lesson_item ){
                
                //skip lesson that are already in the modules
                if( false != Sensei()->modules->get_lesson_module( $lesson_item->ID ) ){
                    continue;
                }
                
                $single_lesson_complete = false;
                $post_classes = array( 'course', 'post' );
                $user_lesson_status = false;
                if ( is_user_logged_in() ) {
                    // Check if Lesson is complete
                    $user_lesson_status = WooThemes_Sensei_Utils::user_lesson_status( $lesson_item->ID, $current_user->ID );
                    $single_lesson_complete = WooThemes_Sensei_Utils::user_completed_lesson( $user_lesson_status );
                    if ( $single_lesson_complete ) {
                        $lessons_completed++;
                        $post_classes[] = 'lesson-completed';
                    } // End If Statement
                } // End If Statement

                // Get Lesson data
                $complexity_array = $woothemes_sensei->post_types->lesson->lesson_complexities();
                $lesson_length = get_post_meta( $lesson_item->ID, '_lesson_length', true );
                $lesson_complexity = get_post_meta( $lesson_item->ID, '_lesson_complexity', true );
                if ( '' != $lesson_complexity ) { $lesson_complexity = $complexity_array[$lesson_complexity]; }
                $user_info = get_userdata( absint( $lesson_item->post_author ) );
                $is_preview = WooThemes_Sensei_Utils::is_preview_lesson( $lesson_item->ID );
                $preview_label = '';
                if ( $is_preview && !$is_user_taking_course ) {
                    $preview_label = $woothemes_sensei->frontend->sensei_lesson_preview_title_text( $post->ID );
                    $preview_label = '<span class="preview-heading">' . $preview_label . '</span>';
                    $post_classes[] = 'lesson-preview';
                }

                $html .= '<article class="' . esc_attr( join( ' ', get_post_class( $post_classes, $lesson_item->ID ) ) ) . '">';

                    $html .= '<header>';
                
                        if ( $single_lesson_complete ) {
                            $html .= '<span class="lesson-status complete"><i class="fa fa-check-circle"></i></span>';
                        }
                        elseif ( $user_lesson_status ) {
                            $html .= '<span class="lesson-status in-progress"><i class="fa fa-spinner"></i></span>';
                        } else {
                            $html .= '<span class="lesson-status not-started"><i class="fa fa-circle-o"></i></span>';
                        } 
                        // End If Statement
                
                        $html .= '<h2><a href="' . esc_url( get_permalink( $lesson_item->ID ) ) . '" title="' . esc_attr( sprintf( __( 'Start %s', 'boss-sensei' ), $lesson_item->post_title ) ) . '">';

                        if( apply_filters( 'sensei_show_lesson_numbers', $show_lesson_numbers ) ) {
                            $html .= '<span class="lesson-number">' . $lesson_count . '. </span>';
                        }

                        $html .= esc_html( sprintf( __( '%s', 'boss-sensei' ), $lesson_item->post_title ) ) . $preview_label . '</a></h2>';

                        $html .= '<p class="lesson-meta">';

                            if ( '' != $lesson_length ) { $html .= '<span class="lesson-length">' . $lesson_length . __( ' minutes', 'boss-sensei' ) . '</span>'; }

                        $html .= '</p>';

                    $html .= '</header>';

                $html .= '</article>';

                $lesson_count++;

            } // End For Loop

        $html .= '</div>';
    $html .= '</section>';

} // End If Statement
// Output the HTML
echo $html; ?>