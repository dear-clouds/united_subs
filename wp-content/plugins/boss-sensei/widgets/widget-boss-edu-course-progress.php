<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

/**
 * Course Progress Widget
 *
 * A Course Progress Widget widget to display a progress of current Course.
 *
 * @package WordPress
 * @subpackage Boss for Sensei
 * @category Widgets
 * @author BuddyBoss
 * @since 1.0.0
 *
 * TABLE OF CONTENTS
 *
 * protected $boss_edu_widget_cssclass
 * protected $boss_edu_widget_description
 * protected $boss_edu_widget_idbase
 * protected $boss_edu_widget_title
 *
 * - __construct()
 * - widget()
 * - update()
 * - form()
 * - load_component()
 */
class Boss_Edu_Course_Progress_Widget extends WP_Widget {
	protected $boss_edu_widget_cssclass;
	protected $boss_edu_widget_description;
	protected $boss_edu_widget_idbase;
	protected $boss_edu_widget_title;

	/**
	 * Constructor function.
	 * @since  1.1.0
	 * @return  void
	 */
	public function __construct() {
		/* Widget variable settings. */
		$this->boss_edu_widget_cssclass = 'widget_course_progress';
		$this->boss_edu_widget_description = __( 'This widget will output a progress of current Course.', 'boss-sensei' );
		$this->boss_edu_widget_idbase = 'widget_course_progress';
		$this->boss_edu_widget_title = __( '(BuddyBoss) - Course Progress', 'boss-sensei' );

		/* Widget settings. */
		$widget_ops = array( 'classname' => $this->boss_edu_widget_cssclass, 'description' => $this->boss_edu_widget_description );

		/* Widget control settings. */
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => $this->boss_edu_widget_idbase );

		/* Create the widget. */
		$this->WP_Widget( $this->boss_edu_widget_idbase, $this->boss_edu_widget_title, $widget_ops, $control_ops );
	} // End __construct()

	/**
	 * Display the widget on the frontend.
	 * @since  1.1.0
	 * @param  array $args     Widget arguments.
	 * @param  array $instance Widget settings for this instance.
	 * @return void
	 */
	public function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'], $instance, $this->id_base );

        if( is_singular( 'lesson' ) || is_singular( 'quiz' ) ) {
            /* Before widget (defined by themes). */
            echo $before_widget;

            /* Display the widget title if one was input (before and after defined by themes). */
            if ( $title ) { echo $before_title . $title . $after_title; }

            /* Widget content. */
            // Add actions for plugins/themes to hook onto.
            do_action( $this->boss_edu_widget_cssclass . '_top' );

    //		if ( 0 < intval( $instance['course_category'] ) ) {
            $this->load_component( $instance );
    //		} // End If Statement

            // Add actions for plugins/themes to hook onto.
            do_action( $this->boss_edu_widget_cssclass . '_bottom' );

            /* After widget (defined by themes). */
            echo $after_widget;
        }

	} // End widget()

	/**
	 * Method to update the settings from the form() method.
	 * @since  1.1.0
	 * @param  array $new_instance New settings.
	 * @param  array $old_instance Previous settings.
	 * @return array               Updated settings.
	 */
	public function update ( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;
	} // End update()

	/**
	 * The form on the widget control in the widget administration area.
	 * Make use of the get_field_id() and get_field_name() function when creating your form elements. This handles the confusing stuff.
	 * @since  1.1.0
	 * @param  array $instance The settings for this instance.
	 * @return void
	 */
    public function form( $instance ) {

		/* Set up some default widget settings. */
		/* Make sure all keys are added here, even with empty string values. */
		$defaults = array(
						'title' => ''
					);

		$instance = wp_parse_args( (array) $instance, $defaults );
?>
		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title (optional):', 'boss-sensei' ); ?></label>
			<input type="text" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"  value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" />
		</p>

<?php
	} // End form()

	/**
	 * Load the output.
	 * @param  array $instance.
	 * @since  1.1.0
	 * @return void
	 */
	protected function load_component ( $instance ) {
        
        global $woothemes_sensei, $current_user, $sensei_modules;
        
        $queried_object = get_queried_object();

        if ( $queried_object ) {
            $post_id = $queried_object->ID;
        }
        
        if(is_singular('quiz')) {
            $post_id = $woothemes_sensei->quiz->data->quiz_lesson;
        }

        $html = '';
        // Get Course Lessons
        $lessons_completed = 0;
        $lesson_course_id = get_post_meta( $post_id , '_lesson_course', true);
        $course_lessons = $woothemes_sensei->post_types->course->course_lessons( $lesson_course_id );
        $total_lessons = count( $course_lessons );
        // Check if the user is taking the course
        $is_user_taking_course = WooThemes_Sensei_Utils::user_started_course( $lesson_course_id, $current_user->ID );

        // Get User Meta
        get_currentuserinfo();
        
        if ( 0 < $total_lessons ) {

            $html .= '<section class="course-lessons-widgets">';

                $html .= '<header>';
                  $html .= '<h3><a href="'.get_permalink($lesson_course_id).'">'.get_the_title($lesson_course_id).'</a></h3>';
                  if ( is_user_logged_in() && $is_user_taking_course ) {
                        $html .= '<div class="course_stats">';
                            $html .= '<span class="course-completion-rate">' . sprintf( __( 'Currently completed %1$s of %2$s in total', 'boss-sensei' ), '######', $total_lessons ) . '</span>';
                            $html .= '<div class="meter+++++"><span style="width: @@@@@%"></span></div>';
                            $html .= '<div class="meter-bottom"><span style="width: @@@@@%"><span>@@@@@%<span></span></div>';
                        $html .= '</div>';
                  } // End If Statement
                $html .= '</header>';
            

//            if($sensei_modules) {
                
        $course_id = $lesson_course_id;
        $modules = $woothemes_sensei->modules->get_course_modules( $course_id  );

        $none_module_lessons = $woothemes_sensei->modules->get_none_module_lessons($course_id);
        $course_modules = wp_get_post_terms($course_id, $woothemes_sensei->modules->taxonomy);
            
        // Display each module
        foreach ($modules as $module) {

            $html .= '<article class="post module">';
            
            $class = '';
            $status = '';
            $module_progress = false;
            if (is_user_logged_in()) {
                global $current_user;
                wp_get_current_user();
                $module_progress = $woothemes_sensei->modules->get_user_module_progress($module->term_id, $course_id, $current_user->ID);
            }
    
            if( $module_progress && $module_progress > 0 ) {
                $status = '<i class="fa fa-check-circle"></i>';
                $class = 'completed';
                if( $module_progress < 100 ) {
                    $status = '<i class="fa fa-spinner"></i>';
                    $class = 'in-progress';
                }
            }
            // module title link
            $module_url = esc_url(add_query_arg('course_id', $course_id, get_term_link($module, $woothemes_sensei->modules->taxonomy)));
            $html .= '<header><h2><a href="' . esc_url($module_url) . '">' . $module->name . '<span class="status module-status ' . esc_attr( $class ) . '">' . $status . '</span></a></h2></header>';

            $html .= '<section class="entry">';

            $lessons = $woothemes_sensei->modules->get_lessons( $course_id ,$module->term_id );

            if (count($lessons) > 0) {

                $lessons_list = '';
                foreach ($lessons as $lesson) {
                    $status = '';
                    $lesson_completed = WooThemes_Sensei_Utils::user_completed_lesson($lesson->ID, get_current_user_id() );
                    $title = esc_attr(get_the_title(intval($lesson->ID)));

                    if ($lesson_completed) {
                        $status = 'completed';
                        $lessons_completed ++;
                    }

                    $lessons_list .= '<li class="' . $status . (($post_id == $lesson->ID )?'current':'') . '"><a href="' . esc_url(get_permalink(intval($lesson->ID))) . '" title="' . esc_attr(get_the_title(intval($lesson->ID))) . '">' . apply_filters('sensei_module_lesson_list_title', $title, $lesson->ID) . '</a></li>';

                    // Build array of displayed lesson for exclusion later
                    $displayed_lessons[] = $lesson->ID;
                }
                $html .= '<section class="module-lessons">
                            <header>
                                <h3>'. __('Lessons', 'boss-sensei') . '</h3>
                            </header>
                    <ul>
                        '. $lessons_list . '
                    </ul>
                </section>';

            }//end count lessons
                $html .= '</section>';
            $html .= '</article>';

        } // end each module
            
            $html .= '<section class="lessons-list">';
            
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

               $html .= '<ul class="other-lessons">';
                $lesson_count = 1;
//                $lessons_completed = 0;
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

                    $html .= '<li class="' . esc_attr( join( ' ', get_post_class( $post_classes, $lesson_item->ID ) ) ) . (($post_id == $lesson_item->ID)?' current':''). '">';

                        $html .= '<header>';

                            $html .= '<h4><a href="' . esc_url( get_permalink( $lesson_item->ID ) ) . '" title="' . esc_attr( sprintf( __( 'Start %s', 'boss-sensei' ), $lesson_item->post_title ) ) . '">';

                            if( apply_filters( 'sensei_show_lesson_numbers', $show_lesson_numbers ) ) {
                                $html .= '<span class="lesson-number">' . $lesson_count . '. </span>';
                            }

                            $html .= esc_html( sprintf( __( '%s', 'boss-sensei' ), $lesson_item->post_title ) ) . $preview_label . '</a></h4>';

                            if ( $single_lesson_complete ) {
                                $html .= '<span class="lesson-status complete"><i class="fa fa-check-circle"></i></span>';
                            }
                            elseif ( $user_lesson_status ) {
                                $html .= '<span class="lesson-status in-progress"><i class="fa fa-spinner"></i></span>';
                            } else {
                                $html .= '<span class="lesson-status not-started"><i class="fa fa-circle-o"></i></span>';
                            } 

                        $html .= '</header>';

                    $html .= '</li>';

                    $lesson_count++;

                } // End For Loop
                $html .= '</ul>';
            $html .= '</section>';
//            } // if modules

            if ( is_user_logged_in() && $is_user_taking_course ) {
                // Add dynamic data to the output
                $html = str_replace( '######', $lessons_completed, $html );
                $progress_percentage = abs( round( ( doubleval( $lessons_completed ) * 100 ) / ( $total_lessons ), 0 ) );
                /* if ( 0 == $progress_percentage ) { $progress_percentage = 5; } */
                $html = str_replace( '@@@@@', $progress_percentage, $html );
                if ( 50 < $progress_percentage ) { $class = ' green'; } elseif ( 25 <= $progress_percentage && 50 >= $progress_percentage ) { $class = ' orange'; } else { $class = ' red'; }
                $html = str_replace( '+++++', $class, $html );
                
                
//                $lessons_completed = get_comment_meta( $course_status_id, 'complete', true );
//
//	    		// Add dynamic data to the output
//	    		$html = str_replace( '######', $lessons_completed, $html );
//	    		$progress_percentage = get_comment_meta( $course_status_id, 'percent', true );
//
//	    		$html = str_replace( '@@@@@', $progress_percentage, $html );
//	    		if ( 50 < $progress_percentage ) { $class = ' green'; } elseif ( 25 <= $progress_percentage && 50 >= $progress_percentage ) { $class = ' orange'; } else { $class = ' red'; }
//
//	    		$html = str_replace( '+++++', $class, $html );
            } // End If Statement

                $post = get_post( $lesson_course_id );
            
                if ( function_exists('bp_is_active') ) {
                    $author_avatar = bp_core_fetch_avatar ( array( 'item_id' => $post->post_author , 'type' => 'full', 'width' => '50', 'height' => '50' ) );
                    $author = '<a class="user-link" href="' . bp_core_get_user_domain( $post->post_author ) . '">' . bp_core_get_user_displayname( $post->post_author ) . '</a>';  
                } else {
                    $author_avatar = get_avatar( $post->post_author, 50 );
                    $author = get_the_author_meta( 'display_name', $post->post_author );
                }
            
                $html .= '<footer>';
                    $html .= '<h4>'.__('About this Course', 'boss-sensei').'</h4>';
                    $html .= '<p>' . $post->post_excerpt . '</p>';
                    $html .= $author_avatar;
                    $html .= '<span><p>'.__( 'Course by', 'boss-sensei' ).'</p><p>'.$author.'</p></span>';
                $html .= '</footer>';

            $html .= '</section>';

            echo $html;
            
        } // if lessons
	} // End load_component()
} // End Class
?>