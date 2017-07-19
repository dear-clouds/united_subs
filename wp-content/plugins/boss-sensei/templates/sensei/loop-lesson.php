<?php
/**
 * The Template for outputting Lesson Archive items
 *
 * Override this template by copying it to yourtheme/sensei/loop-lesson.php
 *
 * @author 		WooThemes
 * @package 	Sensei/Templates
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

global $woothemes_sensei, $post, $wp_query, $current_user;

wp_get_current_user();
$lesson_count = 1;

?>

    <?php if ( have_posts() ) { ?>
		<section id="main-course" class="course-container">
            <section class="module-lessons">

        	    <?php do_action( 'sensei_lesson_archive_header' ); ?>

        	    <?php while ( have_posts() ) { the_post();
        			// Meta data
        			$post_id = get_the_ID(); ?>

					<?php
					$single_lesson_complete = false;
					$user_lesson_status = false;
					if ( is_user_logged_in() ) {
						// Check if Lesson is complete
						$user_lesson_status = WooThemes_Sensei_Utils::user_lesson_status( $post_id, $current_user->ID );
						if ( WooThemes_Sensei_Utils::user_completed_lesson( $user_lesson_status ) ) {
							$single_lesson_complete = true;
						}
					} // End If Statement

                    $complexity_array = $woothemes_sensei->post_types->lesson->lesson_complexities();
                    $lesson_length = get_post_meta( $post_id, '_lesson_length', true );
                    $lesson_complexity = get_post_meta( $post_id, '_lesson_complexity', true );
                    if ( '' != $lesson_complexity ) { $lesson_complexity = $complexity_array[$lesson_complexity]; }
                    $user_info = get_userdata( absint( get_the_author_meta( 'ID' ) ) );

                    $html = '<article class="' . esc_attr( join( ' ', get_post_class( array( 'lesson', 'course', 'post' ), $post_id ) ) ) . '">';

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

                            $html .= '<h2><a href="' . esc_url( get_permalink( $post_id ) ) . '" title="' . esc_attr( sprintf( __( 'Start %s', 'boss-sensei' ), get_the_title() ) ) . '">';

                            if( apply_filters( 'sensei_show_lesson_numbers', false ) ) {
                                $html .= '<span class="lesson-number">' . $lesson_count . '. </span>';
                            }

                            $html .= esc_html( sprintf( __( '%s', 'boss-sensei' ), get_the_title() ) ) . '</a></h2>';

                            $html .= '<p class="lesson-meta">';

                                if ( '' != $lesson_length ) { $html .= '<span class="lesson-length">' . $lesson_length . __( ' minutes', 'boss-sensei' ) . '</span>'; }

                            $html .= '</p>';

                        $html .= '</header>';

                    $html .= '</article>';

                    echo $html;

                    ?>

        		<?php } // End While Loop ?>

        	</section>
        </section>
    <?php } ?>