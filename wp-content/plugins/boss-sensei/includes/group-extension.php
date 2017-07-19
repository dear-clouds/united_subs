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
					$name = __( 'Course', 'boss-sensei' );

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
            
			$group_id = bp_get_group_id();

			$group_status = groups_get_groupmeta( bp_get_group_id(), 'bp_course_attached', true );
			$post = get_post( ( int ) $group_status );

			global $woothemes_sensei, $current_user, $sensei_media_attachments;

			if ( $sensei_media_attachments ) {

				$media = get_post_meta( $post->ID, '_attached_media', true );
				$post_type = ucfirst( get_post_type( $post ) );

				if ( $media && is_array( $media ) && count( $media ) > 0 ) {
					$att_html .= '<div id="attached-media">';
					$att_html .= '<h2>' . sprintf( __( '%s Media', 'sensei_media_attachments' ), $post_type ) . '</h2>';
					$att_html .= '<ul>';
					foreach ( $media as $k => $file ) {
						$file_parts = explode( '/', $file );
						$file_name = array_pop( $file_parts );
						$att_html .= '<li id="attached_media_' . $k . '"><a href="' . esc_url( $file ) . '" target="_blank">' . esc_html( $file_name ) . '</a></li>';
					}
					$att_html .= '</ul>';
					$att_html .= '</div>';
				}

				echo $att_html;
			}

			$html = '';

			// Get Course Lessons
			$course_lessons = Sensei()->course->course_lessons( $post->ID );
			$total_lessons = count( $course_lessons );

			// Check if the user is taking the course
			$is_user_taking_course = WooThemes_Sensei_Utils::user_started_course( $post->ID, $current_user->ID );

			// Get User Meta
			get_currentuserinfo();

			// exit if no lessons exist
			if ( $total_lessons > 0 ) {

				$course_id = $post->ID;
				$modules = $woothemes_sensei->modules->get_course_modules( $course_id );

				// Display each module
				foreach ( $modules as $module ) {

					echo '<article class="post module">';

					// module title link
					$module_url = esc_url( add_query_arg( 'course_id', $course_id, get_term_link( $module, $woothemes_sensei->modules->taxonomy ) ) );
					echo '<header><h2><a href="' . esc_url( $module_url ) . '">' . $module->name . '</a></h2></header>';

					echo '<section class="entry">';

					$module_progress = false;
					if ( is_user_logged_in() ) {
						global $current_user;
						wp_get_current_user();
						$module_progress = $woothemes_sensei->modules->get_user_module_progress( $module->term_id, $course_id, $current_user->ID );
					}

					if ( $module_progress && $module_progress > 0 ) {
						$status = __( 'Completed', 'boss-sensei' );
						$class = 'completed';
						if ( $module_progress < 100 ) {
							$status = __( 'In progress', 'boss-sensei' );
							$class = 'in-progress';
						}
						echo '<p class="status module-status ' . esc_attr( $class ) . '">' . $status . '</p>';
					}

					if ( '' != $module->description ) {
						echo '<p class="module-description">' . $module->description . '</p>';
					}

					$lessons = $woothemes_sensei->modules->get_lessons( $course_id, $module->term_id );

					if ( count( $lessons ) > 0 ) {

						$lessons_list = '';
						foreach ( $lessons as $lesson ) {
							$status = '';
							$lesson_completed = WooThemes_Sensei_Utils::user_completed_lesson( $lesson->ID, get_current_user_id() );
							$title = esc_attr( get_the_title( intval( $lesson->ID ) ) );

							if ( $lesson_completed ) {
								$status = 'completed';
							}

							$lessons_list .= '<li class="' . $status . '"><a href="' . esc_url( get_permalink( intval( $lesson->ID ) ) ) . '" title="' . esc_attr( get_the_title( intval( $lesson->ID ) ) ) . '">' . apply_filters( 'sensei_module_lesson_list_title', $title, $lesson->ID ) . '</a></li>';

							// Build array of displayed lesson for exclusion later
							$displayed_lessons[] = $lesson->ID;
						}
						?>
						<section class="module-lessons">
							<header>
								<h3><?php _e( 'Lessons', 'boss-sensei' ) ?></h3>
							</header>
							<ul>
								<?php echo $lessons_list; ?>
							</ul>
						</section>

					<?php }//end count lessons   ?>
					</section>
					</article>
					<?php
				} // end each module

				$none_module_lessons = $woothemes_sensei->modules->get_none_module_lessons( $post->ID );
				$course_modules = wp_get_post_terms( $post->ID, $woothemes_sensei->modules->taxonomy );

				$html .= '<section class="course-lessons">';
                    $html .= '<div class="course-lessons-inner">';
                        $html .= '<header>';
                        $html .= '<h2>' . apply_filters( 'sensei_lessons_text', __( 'Lessons', 'boss-sensei' ) ) . '</h2>';
                        $html .= '</header>';

                        $lesson_count = 1;

                        $lessons_completed = count( Sensei()->course->get_completed_lesson_ids( $post->ID, $current_user->ID ) );
                        $show_lesson_numbers = false;

                        foreach ( $course_lessons as $lesson_item ) {

                            //skip lesson that are already in the modules
                            if ( false != Sensei()->modules->get_lesson_module( $lesson_item->ID ) ) {
                                continue;
                            }

                            $single_lesson_complete = false;
                            $post_classes = array( 'course', 'post' );
                            $user_lesson_status = false;

                            if ( is_user_logged_in() ) {
                                // Check if Lesson is complete
                                $single_lesson_complete = WooThemes_Sensei_Utils::user_completed_lesson( $lesson_item->ID, $current_user->ID );
                                if ( $single_lesson_complete ) {
                                    $post_classes[] = 'lesson-completed';
                                } // End If Statement
                            } // End If Statement


                            // Get Lesson data
                            $complexity_array = $woothemes_sensei->post_types->lesson->lesson_complexities();
                            $lesson_length = get_post_meta( $lesson_item->ID, '_lesson_length', true );
                            $lesson_complexity = get_post_meta( $lesson_item->ID, '_lesson_complexity', true );
                            if ( '' != $lesson_complexity ) {
                                $lesson_complexity = $complexity_array[ $lesson_complexity ];
                            }
                            $user_info = get_userdata( absint( $lesson_item->post_author ) );
                            $is_preview = WooThemes_Sensei_Utils::is_preview_lesson( $lesson_item->ID );
                            $preview_label = '';
                            if ( $is_preview && ! $is_user_taking_course ) {
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

                            $lesson_count ++;
                        } // End For Loop
                    $html .= '</div>';
				$html .= '</section>';
			} // End If Statement
			// Output the HTML
			echo apply_filters( 'bp_sensei_group_experiences', $html, $group_id );
		}

	}

endif; // if ( class_exists( 'BP_Group_Extension' ) )