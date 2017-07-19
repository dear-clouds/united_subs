<?php
/**
 * The template for displaying product content in the single-course.php template
 *
 * Override this template by copying it to yourtheme/sensei/content-single-course.php
 *
 * @author 		WooThemes
 * @package 	Sensei/Templates
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

global $woothemes_sensei, $post, $current_user, $woocommerce;

// Get User Meta
get_currentuserinfo();
// Check if the user is taking the course
$is_user_taking_course = WooThemes_Sensei_Utils::user_started_course( $post->ID, $current_user->ID );

// Content Access Permissions
$access_permission = false;
if ( ( isset( $woothemes_sensei->settings->settings['access_permission'] ) && ! $woothemes_sensei->settings->settings['access_permission'] ) || sensei_all_access() ) {
	$access_permission = true;
} // End If Statement
?>
	<?php
	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked woocommerce_show_messages - 10
	 */
	if ( WooThemes_Sensei_Utils::sensei_is_woocommerce_activated() ) {
		do_action( 'woocommerce_before_single_product' );
	} // End If Statement
	?>

        	<article <?php post_class( array( 'course', 'post' ) ); ?>>
                <!--Modification-->
                <section class="course-header">
                    <div class="table top">
                        <?php $img = get_the_post_thumbnail( $post->ID, 'course-single-thumb', array( 'class' => 'woo-image thumbnail alignleft') ); ?>
                        <div class="table-cell <?php echo (esc_html($img))?'image':''; ?>">
                            <?php echo $img; ?>
                        </div>
                        <div class="table-cell content">
                            <span><?php _e('Course', 'boss-sensei')?></span>
                            <?php do_action( 'sensei_course_single_title' ); ?>
                            <?php echo '<p class="course-excerpt">' . $post->post_excerpt . '</p>'; ?>
                        </div>
                    </div>
                    <div class="table bottom">
                        <div class="table-cell categories">
                           <?php                                 
                            // Get Course Categories
                            echo get_the_term_list( $post->ID, 'course-category', '<span>', '</span><span>', '</span>' );
                            ?>
                        </div>
                        <div class="table-cell progress">
                        <?php

                        $html = '';
                        // Get Course Lessons
                        $lessons_completed = 0;
                        $course_lessons = $woothemes_sensei->post_types->course->course_lessons( $post->ID );
                        $total_lessons = count( $course_lessons );
                        // Check if the user is taking the course

                        $is_user_taking_course = WooThemes_Sensei_Utils::sensei_check_for_activity( array( 'post_id' => $post->ID, 'user_id' => $current_user->ID, 'type' => 'sensei_course_status' ) );

                        if ( 0 < $total_lessons ) {
                            foreach ( $course_lessons as $lesson_item ){
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
                            }

                            if ( is_user_logged_in() && $is_user_taking_course ) {

                                $html = '<span class="course-completion-rate">' . sprintf( __( 'Currently completed %1$s of %2$s in total', 'boss-sensei' ), '######', $total_lessons ) . '</span>';
                                $html .= '<span class="percent">@@@@@%</span>';
                                $html .= '<div class="meter+++++"><span style="width: @@@@@%"></span></div>';

                                // Add dynamic data to the output
                                $html = str_replace( '######', $lessons_completed, $html );
                                $progress_percentage = abs( round( ( doubleval( $lessons_completed ) * 100 ) / ( $total_lessons ), 0 ) );
                                /* if ( 0 == $progress_percentage ) { $progress_percentage = 5; } */
                                $html = str_replace( '@@@@@', $progress_percentage, $html );
                                if ( 50 < $progress_percentage ) { $class = ' green'; } elseif ( 25 <= $progress_percentage && 50 >= $progress_percentage ) { $class = ' orange'; } else { $class = ' red'; }
                                $html = str_replace( '+++++', $class, $html );

                                echo $html;
                            } // End If Statement
                        }
                        ?>
                        </div>
                    </div>
                    
                </section>
                
                <div id="course-video">
                    <a href="#" id="hide-video" class="button"><i class="fa fa-close"></i></a>
                    <?php
                    /**
                    * sensei_course_meta_video hook
                    *
                    * @hooked sensei_course_meta_video - 10 (outputs the video for course)
                    */
                    $course_video_embed = get_post_meta( $post->ID, '_course_video_embed', true );
                    if ( 'http' == substr( $course_video_embed, 0, 4) ) {
                        // V2 - make width and height a setting for video embed
                        $course_video_embed = wp_oembed_get( esc_url( $course_video_embed )/*, array( 'width' => 100 , 'height' => 100)*/ );
                    } // End If Statement
                    if ( '' != $course_video_embed ) {
                    ?><div class="course-video"><?php echo html_entity_decode($course_video_embed); ?></div><?php
                    } // End If Statement
                    ?> 
                </div>
                
                <section id="course-details">
                    <span class="course-statistic">
                        <?php
                        printf( _n( '%s Lesson', '%s Lessons', $total_lessons, 'boss-sensei' ), $total_lessons ); 
                        if(function_exists('Sensei_Course_Participants')) {
                            printf('<span>%s</span>', __(' / ', 'boss-sensei'));
                            do_action('boss_edu_participants');
                        } 
                        ?>
                    </span>
                    <div class="course-buttons">
                       <?php
                        if($course_video_embed) {
                        ?>
                        <a href="#" id="show-video" class="button"><i class="fa fa-play"></i><?php apply_filters( 'boss_edu_show_video_text', _e( 'Watch Introduction', 'boss-sensei' ) ) ?></a>
                        <?php } ?>
                        <?php do_action( 'sensei_course_single_meta' ); ?>
                        <?php 

                        ?>
                    </div>
                </section>
				
				<?php 
				$group_attached = get_post_meta( $post->ID, 'bp_course_group', true );
				if ( !empty($group_attached) ) { 
					$group_data = groups_get_group( array( 'group_id' => $group_attached ) );
					$group_slug = trailingslashit(home_url()).bp_get_root_slug('groups').'/'.$group_data->slug;
//					$members_count = BP_Groups_Member::get_all_for_group($group_attached)['count'];
					?>
					<div id="item-nav" class="course-group-nav">
						<div role="navigation" id="object-nav" class="item-list-tabs no-ajax">
							<ul>
								<li class="current selected" id="home-groups-li"><a href="" id="home"><?php _e('Home','boss-sensei'); ?></a></li>
								<li id="nav-forum-groups-li"><a href="<?php echo $group_slug.'/forum/'; ?>" id="nav-forum"><?php _e('Forum','boss-sensei'); ?></a></li>
								<li id="nav-experiences-groups-li"><a href="" id="nav-experiences"><?php _e('Course','boss-sensei'); ?></a></li>
								<li id="members-groups-li"><a href="<?php echo $group_slug.'/members/'; ?>" id="members"><?php _e('Members','boss-sensei'); ?></a></li>
								<li id="invite-groups-li"><a href="<?php echo $group_slug.'/send-invites/'; ?>" id="invite"><?php _e('Send Invites','boss-sensei'); ?></a></li>
								<li id="admin-groups-li"><a href="<?php echo $group_slug.'/admin/edit-details/'; ?>" id="admin"><?php _e('Manage','boss-sensei'); ?></a></li>
							</ul>
						</div>
					</div><?php
				} ?>
		
                
                
                <?php 
                if ( ( is_user_logged_in() && $is_user_taking_course ) || $access_permission || 'full' == $woothemes_sensei->settings->settings[ 'course_single_content_display' ] ) { 
                    if($post->post_content) {
                        echo '<section class="entry-content">';
                        do_action('boss_edu_sensei_woocommerce_in_cart_message');
                        the_content(); 
                        echo '</section>';
                    }
                } else { 
                    if($post->post_excerpt) {
                        echo '<section class="entry-content">';
                        do_action('boss_edu_sensei_woocommerce_in_cart_message');
                        echo '<p class="course-excerpt">' . $post->post_excerpt . '</p>'; 
                        echo '</section>';
                    }
                } 
                ?>
                
               
                <?php do_action( 'sensei_course_single_lessons' ); ?>

            </article><!-- .post -->

	        <?php do_action('sensei_pagination'); ?>