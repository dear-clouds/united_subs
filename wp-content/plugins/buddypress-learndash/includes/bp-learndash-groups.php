<?php
/**
 * @package WordPress
 * @subpackage BuddyPress for LearnDash
 */
if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

if ( ! class_exists( 'BuddyPress_LearnDash_Groups' ) ) {

	/**
	 *
	 * BuddyPress_LearnDash_Groups
	 * ********************
	 *
	 *
	 */
	class BuddyPress_LearnDash_Groups {

		/**
		 * empty constructor function to ensure a single instance
		 */
		public function __construct() {
			// leave empty, see singleton below
		}

		public static function instance() {
			static $instance = null;

			if ( null === $instance ) {
				$instance = new BuddyPress_LearnDash_Groups;
				$instance->setup();
			}
			return $instance;
		}

		/**
		 * setup all
		 */
		public function setup() {
			// check if learndash activated
			if ( class_exists( 'SFWD_LMS' ) ) {
				add_action( 'add_meta_boxes', array( $this, 'bp_learndash_metabox' ), 1 );
				add_action( 'save_post', array ( $this, 'bp_learndash_save_postdata' ), 10, 2 );
				add_action( 'body_class', array ( $this, 'bp_learndash_group_body_class' ) );
				add_action( 'learndash_update_course_access', array ( $this, 'bp_learndash_user_course_start' ), 10, 4 );
				
				add_filter('the_content', array( $this,'bp_learndash_group_discussion_button' ),9999 );
				
				add_filter( 'bp_get_group_type', array( $this, 'bp_learndash_course_group_text' ) );

				//Course access list: students group join stuff
				add_action( 'admin_footer', array( $this, 'add_students_to_group_script' ) );
				add_action( 'wp_ajax_add_students_to_group', array( $this, 'add_students_to_group' ) );
			}
		}
		
		/**
		 * course metabox
		 */
		public function bp_learndash_metabox() {

			if ( isset( $_GET[ 'post' ] ) ) {
				$post_id = $_GET[ 'post' ];
			} elseif ( isset( $_POST[ 'post_ID' ] ) ) {
				$post_id = $_POST[ 'post_ID' ];
			}
			add_meta_box( 'bp_course_group', sprintf( __( '%s Group', 'buddypress-learndash' ), LearnDash_Custom_Label::get_label( 'course' ) ), array( $this, 'bp_learndash_metabox_function' ), 'sfwd-courses', 'side', 'core' );
		}
		
		/**
		 * metabox html
		 * @param type $post
		 */
		public function bp_learndash_metabox_function( $post ) {
			wp_nonce_field( plugin_basename( __FILE__ ), $post->post_type . '_noncename' );
			$course_group = get_post_meta( $post->ID, 'bp_course_group', true );

			$groups_arr = BP_Groups_Group::get( array(
							'type' => 'alphabetical',
							'per_page' => 999
						) );
			?>

			<p><?php printf( __( 'Add this %s to a BuddyPress group.', 'buddypress-learndash' ), LearnDash_Custom_Label::label_to_lower( 'course' ) ); ?></p>
			<select name="bp_course_group" id="bp-course-group">
				<option value="-1"><?php _e( '--Select--', 'buddypress-learndash' ); ?></option>
				<?php
				foreach ( $groups_arr[ 'groups' ] as $group ) {
					$group_status = groups_get_groupmeta( $group->id, 'bp_course_attached', true );
					if ( !empty($group_status) && $course_group != $group->id ) {
						continue;
					}
						
					?><option value="<?php echo $group->id; ?>" <?php echo (( $course_group == $group->id )) ? 'selected' : ''; ?>><?php _e( $group->name, 'buddypress-learndash' ); ?></option><?php
				}
				?>
			</select>
			<h4><a href="<?php echo ( home_url() .'/'. buddypress()->{'groups'}->root_slug .'/create' ); ?>" target="_blank"><?php _e( '&#43; Create New Group', 'buddypress-learndash' ); ?></a></h4><?php
		}
		
		/**
		 * Courses save postadata
		 * @param type $post_id
		 */
		public function bp_learndash_save_postdata( $post_id, $post ) {
			// verify if this is an auto save routine. 
			// If it is our form has not been submitted, so we dont want to do anything
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
				return;

			// verify this came from the our screen and with proper authorization,
			// because save_post can be triggered at other times

			if ( ! wp_verify_nonce( @$_POST[ $_POST[ 'post_type' ] . '_noncename' ], plugin_basename( __FILE__ ) ) )
				return;

			// Check permissions
			if ( ! current_user_can( 'edit_post', $post_id ) )
				return;
			// OK, we're authenticated: we need to find and save the data

			if ( 'sfwd-courses' == $post->post_type ) {
				if ( ! current_user_can( 'edit_page', $post_id ) ) {
					return;
				} else {
					$old_group_id = get_post_meta( $post_id, 'bp_course_group', true );
					
					update_post_meta( $post_id, 'bp_course_group', $_POST[ 'bp_course_group' ] );
					
					if ( !empty( $old_group_id ) ) {
						groups_delete_groupmeta( $old_group_id, 'bp_course_attached' );
						//Remove members to group
						bp_learndash_remove_members_group($post_id, $old_group_id );
					}
					if ( $_POST[ 'bp_course_group' ] != '-1' ) {
						groups_add_groupmeta( $_POST[ 'bp_course_group' ], 'bp_course_attached', $post_id );
						//Add members to group
						//bp_learndash_add_members_group($post_id, $_POST[ 'bp_course_group' ] );
						
						//Adding teacher as admin of group
						bp_learndash_course_teacher_group_admin($post_id, $_POST[ 'bp_course_group' ] );
						
						//Attach forum
						bp_learndash_attach_forum( $_POST[ 'bp_course_group' ] );

						//Set group visibility
						bp_learndash_alter_group_status( $_POST[ 'bp_course_group' ] );
						
						//Update Group avatar
						bp_learndash_update_group_avatar( $post_id, $_POST[ 'bp_course_group' ] );
					}
				}
			}
		}
		
		/**
		 * group class
		 * @param string $classes
		 * @return string
		 */
		public function bp_learndash_group_body_class( $classes = '' ) {
			
			if ( in_array( 'group-settings', $classes ) ) {
				$group = groups_get_current_group();
				$course_attached = groups_get_groupmeta( $group->id, 'bp_course_attached',true );
				if ( !  empty( $course_attached ) ) {
					$classes[] = 'bp-hidepublic';
				}
				
			}
			return $classes;
		}
		
		/**
		 * add member to group on course start
		 * @param type $user_id
		 * @param type $course_id
		 */
		public function bp_learndash_user_course_start( $user_id, $course_id, $access_list, $remove ) {

			$group_attached = get_post_meta( $course_id, 'bp_course_group', true );

			if ( ! empty( $group_attached ) ) {
				//$remove
				if ( false === $remove ) {
					groups_join_group( $group_attached, $user_id );
				} else {
					//Delete a membership, based on user + group IDs.
					BP_Groups_Member::delete( $user_id, $group_attached );
				}
			}
		}
		
		/**
		 * Remove member on course reset
		 * @param type $user_id
		 * @param type $course_id
		 */
		public function bp_learndash_user_course_reset( $user_id, $course_id ) {
			
			$group_attached = get_post_meta( $course_id, 'bp_course_group', true );
			
			if ( !empty( $group_attached ) ) {
				groups_remove_member( $user_id, $group_attached );
			}
			
		}
		
		/**
		 * change course group text
		 * @global type $groups_template
		 * @param type $type
		 * @return type
		 */
		public function bp_learndash_course_group_text( $type ) {
			global $groups_template;
			
			if ( empty( $group ) )
				$group =& $groups_template->group;
			
			$group_id = $group->id;
			$course_attached = groups_get_groupmeta( $group_id, 'bp_course_attached', true );
				
			if ( empty( $course_attached ) ) {
				return apply_filters( 'bp_learndash_course_group_text', $type );
			}
			
			if ( 'Private Group' == $type ) {
				$type = __( "Private Course Group", "buddypress-learndash" );
			}
			if ( 'Hidden Group' == $type ) {
				$type = __( "Hidden Course Group", "buddypress-learndash" );
			}
			
			return apply_filters( 'bp_learndash_course_group_text', $type );
		}
		
		public function bp_learndash_group_discussion_button( $content ) {
			
			if ( ( is_singular( array('sfwd-courses', 'sfwd-lessons', 'sfwd-topic') ) ) ) {
				
				$html = '';
				
				if ( get_post_type() == 'sfwd-courses' ) {
					$course_id = get_the_ID();
				}
				
				if ( get_post_type() == 'sfwd-lessons' ) {
					$course_id = get_post_meta(get_the_ID(),'course_id',true);
				}
				
				if ( get_post_type() == 'sfwd-topic' ) {
					$lesson_id = get_post_meta(get_the_ID(),'lesson_id',true);
					$course_id = get_post_meta($lesson_id,'course_id',true);
				}
				
				if ( sfwd_lms_has_access_fn( $course_id ) || current_user_can( 'manage_options' ) ) {
					$group_attached = get_post_meta( $course_id, 'bp_course_group', true );

					if ( empty($group_attached) || $group_attached == '-1' )	return $content;

					$group 		= groups_get_group( array( 'group_id' => $group_attached ) );
					$group_link = bp_get_group_permalink( $group );
					$html 		= '<p class="bp-group-discussion"><a class="button" href="'. $group_link .'">'. sprintf( __('%s Discussion','buddypress-learndash'), LearnDash_Custom_Label::get_label( 'course' ) ).'</a></p>';

					$content .= $html;
				}
			}
			
			return $content;
		}

		/**
		 * Print an inline script to add all students in course access list
		 * to groups
		 */
		public function add_students_to_group_script() {
			global $current_screen;

			// Check to make sure we're on a LearnDash Groups admin page
			if ( ! isset( $current_screen->post_type ) || 'sfwd-courses' != $current_screen->post_type ) return;

			?>
			<script type="text/javascript">

				//On publish button click
				jQuery(document).one( 'click', '#publish', function(e) {

					e.preventDefault();

					var $listTextarea, $submitButtons, $groupSelect, $submitSpinner;

					$listTextarea   = jQuery('textarea[name=sfwd-courses_course_access_list]');
					$submitButtons  = jQuery(this);
					$groupSelect    = jQuery('#bp-course-group');
					$submitSpinner  = jQuery('#publishing-action .spinner');

					$submitButtons.addClass( 'disabled' );
					$submitSpinner.addClass( 'is-active' );

					var bpl_students        = $listTextarea.val().split(',');
					var bpl_group           = $groupSelect.val();
					var bpl_stabpl_index    = 0;
					var bpl_end_index       = 10;

					//Add students in batch of 10
					function JoinGroup(id) {

						if ( 0 == id.length ) {
							JoinGroupFinishUp();
							return 0;
						}

						jQuery.ajax({
							type: 'POST',
							url: ajaxurl,
							data: { action: "add_students_to_group", student_id: id, group_id: bpl_group },
							success: function( response ) {
								if ( response !== Object( response ) || ( typeof response.success === "undefined" && typeof response.error === "undefined" ) ) {
									response = new Object;
									response.success = false;
									response.error = "";
								}

								bpl_stabpl_index = bpl_end_index;
								bpl_end_index = bpl_end_index + 10;
								JoinGroup( bpl_students.slice( bpl_stabpl_index, bpl_end_index ) );
							}
						});
					}


					// Called when all students have been processed. cleans up.
					function JoinGroupFinishUp() {
						$submitButtons.removeClass( 'disabled' );
						$submitSpinner.removeClass( 'is-active' );
						$submitButtons.trigger('click');
					}

					/**
					 * Make sure course access list is not empty and course group
					 * has been selected
					 */
					if( 0 < bpl_students.length && '-1' != bpl_group ) {
						JoinGroup( bpl_students.slice( bpl_stabpl_index, bpl_end_index ) );
					} else {
						//Ok lets click Publish button if course access list is empty and course group is not selected
						JoinGroupFinishUp();
					}

				});
			</script>
			<?php

		}

		/**
		 * Ajax - add students(users) to select group from Course access list
		 */
		public function add_students_to_group() {

			if ( ! isset( $_REQUEST['group_id'] ) ) die;

			if ( ! isset( $_REQUEST['student_id'] ) ) die;

			$group_id = $_REQUEST['group_id'];
			$course_students =  $_REQUEST['student_id'];

			if ( is_array( $course_students ) ) {
				foreach ( $course_students as $course_students_id ) {
					groups_join_group( $group_id, $course_students_id );
				}
			} else {
				groups_join_group( $group_id, $course_students );
			}

			die;
		}

	} // End of class

	if ( bp_is_active('groups') ) {
		BuddyPress_LearnDash_Groups::instance();
	}
}
