<?php

/**
 * The class_exists() check is recommended, to prevent problems during upgrade
 * or when the Groups component is disabled
 */
if ( class_exists( 'BP_Group_Extension' ) ) :

	class GType_Course_Group extends BP_Group_Extension {

		private $extension_slug;

		/**
		 * Your __construct() method will contain configuration options for 
		 * your extension, and will pass them to parent::init()
		 */
		function __construct() {
			global $bp;
			if ( function_exists( 'bp_is_group' ) && bp_is_group() ) {

				$group_status = groups_get_groupmeta( $bp->groups->current_group->id, 'bp_course_attached', true );

				if ( $group_status ) {
					$name = __( 'Course', 'buddypress-learndash' );

					$this->extension_slug = 'experiences';
					$args = array(
						'slug' => $this->extension_slug,
						'name' => $name,
						'nav_item_position' => 10,
					);

					parent::init( $args );
				}
			}
		}

		function load_grid_display( $flag ) {
			return 'yes';
		}

		/**
		 * display() contains the markup that will be displayed on the main 
		 * plugin tab
		 */
		function display( $group_id = null ) {
			global $current_user;

			$group_id = bp_get_group_id();
			$course_id = groups_get_groupmeta( bp_get_group_id(), 'bp_course_attached', true );
			$course = $post = get_post( $course_id );

			if ( ! is_singular() || $post->post_type != "sfwd-courses" )
				return '';

			$user_id = $current_user->ID;
			$logged_in = ! empty( $user_id );
			$lesson_progression_enabled = false;

			$course_settings = learndash_get_setting( $course );
			$lesson_progression_enabled = learndash_lesson_progression_enabled();
			$courses_options = learndash_get_option( 'sfwd-courses' );
			$lessons_options = learndash_get_option( 'sfwd-lessons' );
			$quizzes_options = learndash_get_option( 'sfwd-quiz' );
			$course_status = learndash_course_status( $course_id, null );
			$has_access = sfwd_lms_has_access( $course_id, $user_id );

			$lessons = learndash_get_course_lessons_list( $course );
			$quizzes = learndash_get_course_quiz_list( $course );
			$has_course_content = ( ! empty( $lessons ) || ! empty( $quizzes ));

			$has_topics = false;
			if ( ! empty( $lessons ) ) {
				foreach ( $lessons as $lesson ) {
					$lesson_topics[ $lesson[ "post" ]->ID ] = learndash_topic_dots( $lesson[ "post" ]->ID, false, 'array' );
					if ( ! empty( $lesson_topics[ $lesson[ "post" ]->ID ] ) )
						$has_topics = true;
				}
				$level = ob_get_level();
				ob_start();
				include(SFWD_LMS::get_template( 'course_content_shortcode', null, null, true ));
				$content = learndash_ob_get_clean( $level );
				$content = str_replace( array( "\n", "\r" ), " ", $content );
				$user_has_access = $has_access ? "user_has_access" : "user_has_no_access";
				echo '<div class="learndash ' . $user_has_access . '" id="learndash_post_' . $course_id . '">' . apply_filters( "learndash_content", $content, $post ) . '</div>';
			} else { ?>
				<p class="no-lesson-msg"><strong><?php _e('This course has no lessons added yet','buddypress-learndash'); ?></strong></p><?php
			}
		}

	}
	

endif; // if ( class_exists( 'BP_Group_Extension' ) )