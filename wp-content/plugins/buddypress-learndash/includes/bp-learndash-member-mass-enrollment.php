<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Mass Member Enrollment Class
 *
 * Group Enrollment bulk buddypress group members subscription
 * @author      BuddyBoss
 */
class BuddyPress_Learndash_Member_Mass_Enrollment {

	/** @var BuddyPress_Learndash_Member_Mass_Enrollment The single instance of the class */
	protected static $_instance = null;

	//initialization
	function __construct() {
		add_action( 'admin_footer',             array( $this,  'group_members_enrollment_interface' ) );
		add_action( 'save_post',                array( $this, 'set_session_var' ) );
		add_action( 'admin_enqueue_scripts',    array( &$this, 'admin_enqueues' ) );
		add_action( 'wp_ajax_mass_group_join',  array( &$this, 'mass_group_join' ) );
	}

	/**
	 * Main BuddyPress_Learndash_Member_Mass_Enrollment Instance
	 *
	 * Ensures only one instance of BuddyPress_Sensei_Member_Type_Migration is loaded or can be loaded.
	 *
	 * @static
	 * @return BuddyPress_Sensei_Member_Type_Migration Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Enqueue the needed Javascript and CSS
	 * @param $hook_suffix
	 */
	function admin_enqueues( $hook_suffix ) {
        global $current_screen;

        // Check to make sure we're on a LearnDash Groups admin page
        if ( ! isset( $current_screen->post_type ) || 'groups' != $current_screen->post_type ) return;


        // WordPress 3.1 vs older version compatibility
		if ( wp_script_is( 'jquery-ui-widget', 'registered' ) )
			wp_enqueue_script( 'jquery-ui-progressbar', BUDDYPRESS_LEARNDASH_PLUGIN_URL .'assets/jquery-ui/jquery.ui.progressbar.min.js', array( 'jquery-ui-core', 'jquery-ui-widget' ), '1.8.6' );
		else
			wp_enqueue_script( 'jquery-ui-progressbar',  BUDDYPRESS_LEARNDASH_PLUGIN_URL .'assets/jquery-ui/jquery.ui.progressbar.min.1.7.2.js', array( 'jquery-ui-core' ), '1.7.2' );

		wp_enqueue_style( 'jquery-ui-users-migration', BUDDYPRESS_LEARNDASH_PLUGIN_URL .'assets/jquery-ui/redmond/jquery-ui-1.7.2.custom.css', array(), '1.7.2' );
	}

	function set_session_var() {

		// If it is our form has not been submitted, so we dont want to do anything
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return;

		if ( 'groups' != $_POST['post_type'] )
			return;

		if ( session_status() == PHP_SESSION_NONE ) {
			session_start();
		}

		$_SESSION['learndash_group_enroll_course']      = $_REQUEST['learndash_group_enroll_course'];
		$_SESSION['learndash_group_unenroll_course']    = $_REQUEST['learndash_group_unenroll_course'];
		$_SESSION['learndash_group_users']              = $_REQUEST['learndash_group_users'];

	}

	/**
	 * The user interface plus user migration
	 */
	// The user interface plus thumbnail regenerator
	public function group_members_enrollment_interface() {
        global $current_screen;

        // Check to make sure we're on a LearnDash Groups admin page
        if ( ! isset( $current_screen->post_type ) || 'groups' != $current_screen->post_type ) return;

		if ( session_status() == PHP_SESSION_NONE ) {
			session_start();
		}

		//unset variable
		if ( ( empty( $_SESSION['learndash_group_enroll_course'] )
		       && empty( $_SESSION['learndash_group_unenroll_course'] ) )
		     || empty( $_SESSION['learndash_group_users'] ) ) {
			return;
		}

		//Enqueues the default ThickBox js and css.
		add_thickbox();
		?>

		<a style="display: none;"  name="<?php _e('Mass Group Enrollment', 'buddypress-learndash'); ?>" id="student-mass-enroll-group-button" href="#TB_inline?width=500&height=400&inlineId=student-mass-enroll-thickbox" class="thickbox">View the WordPress Codex!</a>

		<div id="student-mass-enroll-thickbox" class="regenthumbs" style="display: none;">

			<?php

			echo '	<p>' . __( "Please be patient while the mass enrollment process. This can take a while if your server is slow (inexpensive hosting) or if you have many students(members). Do not navigate away from this dialog until this script is done.", 'buddypress-learndash' ) . '</p>';

				$learndash_group_users = isset( $_SESSION['learndash_group_users'] )? $_SESSION['learndash_group_users']:array();
				$learndash_group_enroll_course = isset( $_SESSION['learndash_group_enroll_course'] )? $_SESSION['learndash_group_enroll_course']:array();
				$learndash_group_unenroll_course = isset( $_SESSION['learndash_group_unenroll_course'] )? $_SESSION['learndash_group_unenroll_course']:array();

				//unset session variable
				unset( $_SESSION['learndash_group_enroll_course'] );
				unset( $_SESSION['learndash_group_unenroll_course'] );
				unset( $_SESSION['learndash_group_users'] );

				$images = array_map( 'intval', $learndash_group_users );
				$ids    = implode( ',', $images );
				$count  = count( $images );

				$text_goback = ( ! empty( $_GET['goback'] ) ) ? sprintf( __( 'To go back to the previous page, <a href="%s">click here</a>.', 'buddypress-learndash' ), 'javascript:history.go(-1)' ) : '';
				$text_failures = sprintf( __( 'All done! %1$s image(s) were successfully resized in %2$s seconds and there were %3$s failure(s). To try regenerating the failed images again, <a href="%4$s">click here</a>. %5$s', 'buddypress-learndash' ), "' + bpl_successes + '", "' + bpl_totaltime + '", "' + bpl_errors + '", esc_url( wp_nonce_url( admin_url( 'tools.php?page=buddypress-learndash&goback=1' ), 'buddypress-learndash' ) . '&ids=' ) . "' + bpl_failedlist + '", $text_goback );
				$text_nofailures = sprintf( __( 'All done! %1$s image(s) were successfully resized in %2$s seconds and there were 0 failures. %3$s', 'buddypress-learndash' ), "' + bpl_successes + '", "' + bpl_totaltime + '", $text_goback );
				?>
				<noscript><p><em><?php _e( 'You must enable Javascript in order to proceed!', 'buddypress-learndash' ) ?></em></p></noscript>

				<div id="bp-learndash-bar" style="position:relative;height:25px;">
					<div id="bp-learndash-bar-percent" style="position:absolute;left:50%;top:50%;width:300px;margin-left:-150px;height:25px;margin-top:-9px;font-weight:bold;text-align:center;"></div>
				</div>

				<p><input type="button" class="button hide-if-no-js" name="bp-learndash-stop" id="bp-learndash-stop" value="<?php _e( 'Abort Joining Members', 'buddypress-learndash' ) ?>" /></p>

				<h3 class="title"><?php _e( 'Debugging Information', 'buddypress-learndash' ) ?></h3>

				<p>
					<?php printf( __( 'Total Members: %s', 'buddypress-learndash' ), $count ); ?><br />
					<?php printf( __( 'Members Joined: %s', 'buddypress-learndash' ), '<span id="bp-learndash-debug-successcount">0</span>' ); ?><br />
					<?php printf( __( 'Join Failures: %s', 'buddypress-learndash' ), '<span id="bp-learndash-debug-failurecount">0</span>' ); ?>
				</p>
		</div>


		<script type="text/javascript">
			// <![CDATA[
			jQuery(document).ready(function($){
				var i;
				var bpl_images = [<?php echo $ids; ?>];
				var bpl_enrolled_course      = '<?php echo $learndash_group_enroll_course ?>';
				var bpl_unenrolled_course    = '<?php echo $learndash_group_unenroll_course;?>';
				var bpl_total = bpl_images.length;
				var bpl_count = 0;
				var bpl_percent = 0;
				var bpl_successes = 0;
				var bpl_errors = 0;
				var bpl_failedlist = '';
				var bpl_resulttext = '';
				var bpl_timestart = new Date().getTime();
				var bpl_timeend = 0;
				var bpl_totaltime = 0;
				var bpl_continue = true;
				var bpl_stabpl_index = 0;
				var bpl_end_index  = 10

				// Create the progress bar
				$("#bp-learndash-bar").progressbar();
				$("#bp-learndash-bar-percent").html( "0%" );

				// Stop button
				$("#bp-learndash-stop").click(function() {
					bpl_continue = false;
					$('#bp-learndash-stop').val("<?php echo $this->esc_quotes( __( 'Stopping...', 'buddypress-learndash' ) ); ?>");
				});

				// Called after each resize. Updates debug information and the progress bar.
				function EnrollmentUpdateStatus( id, success, response ) {

					bpl_count = bpl_count + id.length;

					$("#bp-learndash-bar").progressbar( "value", ( bpl_count / bpl_total ) * 100 );
					$("#bp-learndash-bar-percent").html( Math.round( ( bpl_count / bpl_total ) * 1000 ) / 10 + "%" );


					if ( success ) {
						bpl_successes = bpl_successes + id.length;
						$("#bp-learndash-debug-successcount").html(bpl_successes);
					}
					else {
						bpl_errors = bpl_errors + 1;
						bpl_failedlist = bpl_failedlist + ',' + id;
						$("#bp-learndash-debug-failurecount").html(bpl_errors);
					}
				}

				// Called when all images have been processed. Shows the results and cleans up.
				function EnrollmentFinishUp() {
					bpl_timeend = new Date().getTime();
					bpl_totaltime = Math.round( ( bpl_timeend - bpl_timestart ) / 1000 );

					$('#bp-learndash-stop').hide();

					if ( bpl_errors > 0 ) {
						bpl_resulttext = '<?php echo $text_failures; ?>';
					} else {
						bpl_resulttext = '<?php echo $text_nofailures; ?>';
					}

					$("#message").html("<p><strong>" + bpl_resulttext + "</strong></p>");
					$("#message").show();
				}

				// Regenerate a specified image via AJAX
				function Enrollment( id ) {

					if ( 0 == id.length ) {
						EnrollmentFinishUp();
						return 0;
					}

					$.ajax({
						type: 'POST',
						url: ajaxurl,
						data: { action: "mass_group_join", id: id, enroll: bpl_enrolled_course, unenroll: bpl_unenrolled_course },
						success: function( response ) {
							if ( response !== Object( response ) || ( typeof response.success === "undefined" && typeof response.error === "undefined" ) ) {
								response = new Object;
								response.success = false;
								response.error = "<?php printf( esc_js( __( 'The resize request was abnormally terminated (ID %s). This is likely due to the image exceeding available memory or some other type of fatal error.', 'buddypress-learndash' ) ), '" + id + "' ); ?>";
							}

							if ( response.success ) {
								EnrollmentUpdateStatus( id, true, response );
							}
							else {
								EnrollmentUpdateStatus( id, false, response );
							}


							bpl_stabpl_index = bpl_end_index;
							bpl_end_index = bpl_end_index + 10;
							Enrollment( bpl_images.slice( bpl_stabpl_index, bpl_end_index ) );


						}
					});
				}

				Enrollment( bpl_images.slice( bpl_stabpl_index, bpl_end_index ) );

				setTimeout( function() {
					jQuery('#student-mass-enroll-group-button').click();
				},1000 );

			});
			// ]]>
		</script>

		<?php
	}

	/**
	 *  Process a single users batch
	 */
	function mass_group_join() {

		@error_reporting( 0 ); // Don't break the JSON result

		header( 'Content-type: application/json' );

		@set_time_limit( 900 ); // 5 minutes per batch of 100-100 should be PLENTY

		$learndash_group_users = isset($_POST['id'])? $_POST['id']:array();
		$learndash_group_enroll_course = isset($_POST['enroll'])? $_POST['enroll']:array();
		$learndash_group_unenroll_course = isset($_POST['unenroll'])? $_POST['unenroll']:array();

		if(is_numeric($learndash_group_enroll_course)) $learndash_group_enroll_course = array($learndash_group_enroll_course);
		if(is_numeric($learndash_group_unenroll_course)) $learndash_group_unenroll_course = array($learndash_group_unenroll_course);


		//Add a user to enrolled groups
		foreach ( $learndash_group_enroll_course as $course_id ) {
			$group_id = bp_learndash_course_group_id( $course_id );
			foreach ( $learndash_group_users as $ga ) {
				groups_join_group( $group_id, $ga );
			}
		}

		//Remove a user from unenrolled groups
		foreach ( $learndash_group_unenroll_course as $course_id ) {
			$group_id = bp_learndash_course_group_id( $course_id );
			foreach ( $learndash_group_users as $ga ) {
				groups_leave_group( $group_id, $ga );
			}
		}


		die( json_encode( array( 'success' => true ) ) );
	}


	// Helper to make a JSON error message
	function die_json_error_msg( $id, $message ) {
		die( json_encode( array( 'error' => sprintf( __( '&quot;%1$s&quot; (ID %2$s) failed to resize. The error message was: %3$s', 'buddypress-learndash' ), esc_html( get_the_title( $id ) ), $id, $message ) ) ) );
	}


	// Helper function to escape quotes in strings for use in Javascript
	function esc_quotes( $string ) {
		return str_replace( '"', '\"', $string );
	}


}

global $bp_learndash_member_mass_enrollement;
// Attempt to detect if the server supports PHP sessions
if( function_exists( 'session_start' ) ) {
    $bp_learndash_member_mass_enrollement = BuddyPress_Learndash_Member_Mass_Enrollment::instance();
}

?>