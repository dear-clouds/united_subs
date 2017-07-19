<?php
/**
 * @package WordPress
 * @subpackage BuddyBoss Wall
 */
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) )
	exit;

/**
 * Return Html Select box for activity privacy UI
 * @return [type] [description]
 */
function buddyboss_wall_add_activitiy_visibility_selectbox() {
	echo '<span name="activity-visibility" id="activity-visibility">';
	/* _e( 'Privacy: ', 'bp-bbwall-activity-privacy' ); */
	if ( bp_is_group_home() )
		buddyboss_wall_groups_activity_visibility();
	else
		buddyboss_wall_profile_activity_visibility();
	echo '</span>';
}

if ( buddyboss_wall()->is_wall_privacy_enabled() ):
	add_action( 'bp_activity_post_form_options', 'buddyboss_wall_add_activitiy_visibility_selectbox' );
endif;

/**
 * Markup for select box of profile activity privacy
 * @return String [description]
 */
function buddyboss_wall_profile_activity_visibility() {
	echo buddyboss_wall_get_profile_activity_visibility();
}

function buddyboss_wall_get_profile_activity_visibility() {
	$html = '<select name="bbwall-activity-privacy" id="bbwall-activity-privacy">';

	$options = buddyboss_wall_get_visibility_lists();

	foreach ( $options as $key => $val ) {
		$html .= "<option value='" . esc_attr( $key ) . "'>$val</option>";
	}
	$html .= '</select>';

	return apply_filters( 'buddyboss_wall_get_profile_activity_visibility_filter', $html );
}

/**
 * Markup for select box of groups activity privacy
 * @return String [description]
 */
function buddyboss_wall_groups_activity_visibility() {
	echo buddyboss_wall_get_groups_activity_visibility();
}

function buddyboss_wall_get_groups_activity_visibility() {
	if ( bp_is_group() ) {
		/*
		 * if group is hidden or private, we shouldn't show activity privacy options
		 * as the privacy is determined on group level anyway.
		 */
		global $groups_template;
		$group = & $groups_template->group;
		if ( !empty( $group ) && ( 'hidden' == $group->status || 'private' == $group->status ) ) {
			//this is a hidden/private group. dont show the privacy UI
			return apply_filters( 'buddyboss_wall_get_groups_activity_visibility', '' );
		}
	}
	$html = '<select name="bbwall-activity-privacy" id="bbwall-activity-privacy">';

	$options = buddyboss_wall_get_visibility_lists( true );

	foreach ( $options as $key => $val ) {
		$html .= "<option value='" . esc_attr( $key ) . "'>$val</option>";
	}
	$html .= '</select>';

	return apply_filters( 'buddyboss_wall_get_groups_activity_visibility', $html );
}

/**
 * Filter wall posts based on privacy
 * @param $content
 * @param $user_id
 * @param $activity_id
 */
function buddyboss_wall_add_visibility_to_activity( $content, $user_id, $activity_id ) {
	$visibility = 'public';

	$options = buddyboss_wall_get_visibility_lists();

	if ( isset( $_POST[ 'visibility' ] ) && in_array( esc_attr( $_POST[ 'visibility' ] ), array_keys( $options ) ) )
		$visibility = esc_attr( $_POST[ 'visibility' ] );

	bp_activity_update_meta( $activity_id, 'bbwall-activity-privacy', $visibility );
}

if ( buddyboss_wall()->is_wall_privacy_enabled() ):
	add_action( 'bp_activity_posted_update', 'buddyboss_wall_add_visibility_to_activity', 10, 3 );
endif;

/**
 * Add visibility level to group activity meta
 * @param  [type] $content     [description]
 * @param  [type] $user_id     [description]
 * @param  [type] $group_id    [description]
 * @param  [type] $activity_id [description]
 * @return [type]              [description]
 */
function buddyboss_wall_add_visibility_to_group_activity( $content, $user_id, $group_id, $activity_id ) {
	$visibility = 'public';

	$options = buddyboss_wall_get_visibility_lists( true );

	if ( isset( $_POST[ 'visibility' ] ) && in_array( esc_attr( $_POST[ 'visibility' ] ), array_keys( $options ) ) )
		$visibility = esc_attr( $_POST[ 'visibility' ] );

	bp_activity_update_meta( $activity_id, 'bbwall-activity-privacy', $visibility );
}

if ( buddyboss_wall()->is_wall_privacy_enabled() ):
	add_action( 'bp_groups_posted_update', 'buddyboss_wall_add_visibility_to_group_activity', 10, 4 );
endif;

/**
 * get options for visibility
 * @param bool $friend
 * @param bool $group
 * @return array
 */
function buddyboss_wall_get_visibility_lists( $is_group_activity = false ) {
	$bp_displayed_user_id	 = bp_displayed_user_id();
	$bp_loggedin_user_id	 = bp_loggedin_user_id();
	$disble_everyone_privacy = buddyboss_wall()->option( 'disable_everyone_option' );
	$options				 = array();

	if ( !$disble_everyone_privacy ) {
		$options[ 'public' ] = __( 'Everyone', 'buddyboss-wall' );
	}

	$options[ 'loggedin' ] = __( 'Logged In Users', 'buddyboss-wall' );

	if ( $bp_displayed_user_id == $bp_loggedin_user_id || !bp_is_user_activity() ) {
		$options[ 'onlyme' ] = __( 'Only Me', 'buddyboss-wall' );
	}
	if ( bp_is_active( 'friends' ) ) {
		$options[ 'friends' ] = __( 'My Friends', 'buddyboss-wall' );
	}
	if ( $is_group_activity && bp_is_active( 'groups' ) ) {
		$options[ 'grouponly' ] = __( 'Group Members', 'buddyboss-wall' );
	}

	return $options;
}

function buddyboss_wall_visibility_is_activity_invisible( $activity, $bp_loggedin_user_id, $is_super_admin ) {

	//Bail if an activity is not set
	if ( ! $activity ) {
		return;
	}

	$activity->user_id	 = isset( $activity->user_id ) ? $activity->user_id : '';
	$activity->id		 = isset( $activity->id ) ? $activity->id : '';

	if ( $bp_loggedin_user_id == $activity->user_id )
		return false;

	$visibility			 = bp_activity_get_meta( $activity->id, 'bbwall-activity-privacy' );
	$remove_from_stream	 = false;

	switch ( $visibility ) {
		//Logged in users
		case 'loggedin' :
			if ( !$bp_loggedin_user_id )
				$remove_from_stream = true;
			break;

		//My friends
		case 'friends' :
			if ( bp_is_active( 'friends' ) ) {
				$is_friend			 = friends_check_friendship( $bp_loggedin_user_id, $activity->user_id );
				if ( !$is_friend )
					$remove_from_stream	 = true;
			}
			break;

		//Only group members
		case 'grouponly' :
			$group_is_user_member	 = groups_is_user_member( $bp_loggedin_user_id, $activity->item_id );
			if ( !$group_is_user_member )
				$remove_from_stream		 = true;
			break;

		//Only Me
		case 'onlyme' :
			if ( $bp_loggedin_user_id != $activity->user_id )
				$remove_from_stream = true;
			break;

		default:
			//public
			break;
	}

	// mentioned members can always see the acitivity whatever the privacy level
	if ( $visibility != 'mentionedonly' && $bp_loggedin_user_id && $remove_from_stream ) {
		$usernames		 = bp_activity_find_mentions( $activity->content );
		$is_mentioned	 = array_key_exists( $bp_loggedin_user_id, (array) $usernames );
		if ( $is_mentioned ) {
			$remove_from_stream = false;
		}
	}

	$remove_from_stream = apply_filters( 'buddyboss_wall_more_visibility_activity_filter', $remove_from_stream, $visibility, $activity );

	return $remove_from_stream;
}

/**
 * buddyboss_wall_visibility_activity_filter
 * @param  [type] $a          [description]
 * @param  [type] $activities [description]
 * @return [type]             [description]
 */
function buddyboss_wall_visibility_activity_filter( $has_activities, $activities ) {
	global $bp;

	$is_super_admin			 = is_super_admin();
	$bp_displayed_user_id	 = bp_displayed_user_id();
	$bp_loggedin_user_id	 = bp_loggedin_user_id();

	foreach ( $activities->activities as $key => $activity ) {

		$remove_from_stream = buddyboss_wall_visibility_is_activity_invisible( $activity, $bp_loggedin_user_id, $is_super_admin );

		if ( $remove_from_stream && isset( $activities->activity_count ) ) {
			$activities->activity_count = $activities->activity_count - 1;
			unset( $activities->activities[ $key ] );
		}
	}

	$activities_new			 = array_values( $activities->activities );
	$activities->activities	 = $activities_new;

	return $has_activities;
}

if ( buddyboss_wall()->is_wall_privacy_enabled() ):
	add_action( 'bp_has_activities', 'buddyboss_wall_visibility_activity_filter', 10, 2 );
endif;


if ( buddyboss_wall()->is_wall_privacy_enabled() ):
	add_filter( 'bp_get_activity_latest_update', 'buddyboss_wall_activity_privacy_latest_update', 10, 1 );
endif;

function buddyboss_wall_activity_privacy_latest_update( $latest_update ) {

	$user_id = bp_displayed_user_id();

	if ( bp_is_user_inactive( $user_id ) )
		return $latest_update;

	if ( !$update = bp_get_user_meta( $user_id, 'bp_latest_update', true ) )
		return $latest_update;

	$activity_id = $update[ 'id' ];

    //Bail before fetch all activities when $activity_id is false
    if ( ! $activity_id ) return $latest_update;

	$activity	 = bp_activity_get_specific( array( 'activity_ids' => $activity_id ) );

	// single out the activity
	$activity_single = isset( $activity[ "activities" ][ 0 ] ) ? $activity[ "activities" ][ 0 ] : '';

	$has_activities				 = false;
	$activities					 = new stdClass();
	$activities->activities		 = array();
	$activities->activities[]	 = $activity_single;

	buddyboss_wall_visibility_activity_filter( $has_activities, $activities );

	if ( empty( $activities->activities ) )
		$latest_update = null;

	return $latest_update;
}

// prevent members to see last activity on members loop
if ( buddyboss_wall()->is_wall_privacy_enabled() ):
	add_filter( 'bp_get_member_latest_update', 'buddyboss_wall_activity_privacy_member_latest_update', 10, 1 );
endif;

function buddyboss_wall_activity_privacy_member_latest_update( $update_content ) {
	global $members_template;

	$latest_update = bp_get_user_meta( bp_get_member_user_id(), 'bp_latest_update', true );
	if ( !empty( $latest_update ) ) {
		$activity_id = $latest_update[ 'id' ];
		if ( !(int) $activity_id ) {
			return $update_content;
		}

		$activities = bp_activity_get_specific( array( 'activity_ids' => $activity_id ) );

		// single out the activity
		$activity = isset( $activities[ "activities" ][ 0 ] ) ? $activities[ "activities" ][ 0 ] : '';

		$is_super_admin			 = is_super_admin();
		$bp_displayed_user_id	 = bp_displayed_user_id();
		$bp_loggedin_user_id	 = bp_loggedin_user_id();

		$remove_from_stream = buddyboss_wall_visibility_is_activity_invisible( $activity, $bp_loggedin_user_id, $is_super_admin );

		if ( $remove_from_stream )
			return false;
	}

	return $update_content;
}

// prevent members to see last activity on member header page
if ( buddyboss_wall()->is_wall_privacy_enabled() ):
	add_filter( 'get_user_metadata', 'buddyboss_wall_last_activitymeta', 10, 3 );
endif;

function buddyboss_wall_last_activitymeta( $retval, $object_id, $meta_key ) {
	if ( $meta_key == 'bp_latest_update' ) {
		remove_filter( 'get_user_metadata', 'buddyboss_wall_last_activitymeta' );
		$retval = get_metadata( 'user', $object_id, $meta_key );
		if ( !isset( $retval ) || empty( $retval ) ) {
			return false;
		}
		if ( isset( $retval[ 'id' ] ) && !empty( $retval[ 'id' ] ) ) {
			$activity_id = $retval[ 'id' ];

			$is_super_admin			 = is_super_admin();
			$bp_displayed_user_id	 = bp_displayed_user_id();
			$bp_loggedin_user_id	 = bp_loggedin_user_id();

			$activities			 = bp_activity_get_specific( array( 'activity_ids' => $activity_id ) );
			$activity			 = isset( $activities[ "activities" ][ 0 ] ) ? $activities[ "activities" ][ 0 ] : '';
			$remove_from_stream	 = buddyboss_wall_visibility_is_activity_invisible( $activity, $bp_loggedin_user_id, $is_super_admin, $bp_displayed_user_id );
			if ( $remove_from_stream ) {
				return false;
			}
		}
		return $retval;
	}
}

/**
 * Privacy selectbox html
 * @return type String
 */
function buddyboss_wall_editing_privacy_script_template() {
	if ( bp_is_group_home() ) {
		$options = buddyboss_wall_get_visibility_lists( true );
	} else {
		$options = buddyboss_wall_get_visibility_lists();
	}
	?>

	<script type="text/html" id="buddyboss-wall-form-wrapper-tpl">
		<div class="activity-comments buddyboss-wall-form-wrapper buddyboss-activity-comments-form" style="display:none">
			<form id="form_buddyboss-wall-privacy" method="POST" onsubmit="return buddyboss_wall_submit_privacy();">
				<input type="hidden" name="bboss_wall_privacy_nonce" value="<?php echo wp_create_nonce( 'bboss_wall_privacy' ); ?>" >
				<input type="hidden" name="activity_id" value="">

				<div class="clearfix" id="buddyboss-wall-privacy">
					<div class="field">
						<label><?php _e( 'Who can see this', 'buddyboss-wall' ); ?></label>
						<select name="bbwall-privacy-selectbox" id="bbwall-privacy-selectbox" class="bbwall-privacy-selectbox">
							<?php
							foreach ( $options as $key => $val ) {
								?>
								<option value="<?php echo esc_attr( $key ); ?>" ><?php echo $val; ?></option><?php
							}
							?>
						</select>
					</div>
					<div class="field submit">
						<input type="submit" id="buddyboss-wall-privacy-submit" value="<?php _e( 'Save', 'buddyboss-wall' ); ?>" > &nbsp;
						<a class='buddyboss-wall-privacy-cancel' href='#' onclick='return buddyboss_wall_privacy_close();'>
							<?php _e( 'Cancel', 'buddyboss-wall' ); ?>
						</a>
						<i class="buddyboss-wall-ajax-loader privacy-filter-ajax-loader fa fa-spinner"></i>
					</div>
				</div>

				<div id="message"></div>
			</form>
		</div>
	</script>
	<?php
}

add_action( 'wp_footer', 'buddyboss_wall_editing_privacy_script_template' );

/**
 * Privacy selectbox on activity meta
 */
function buddyboss_wall_editing_privacy() {

	if ( ( buddyboss_wall()->is_wall_privacy_enabled() ) && ( bp_get_activity_user_id() == bp_loggedin_user_id() ) ) {
		/*
		 * If activity is hidden sitewide, we shouldn't show activity privacy options
		 */
		global $activities_template;
		if ( 1 == $activities_template->activity->hide_sitewide ) {
			return;
		}
		if ( bp_is_group_home() ) {
			$apply_class = 'buddyboss-group-privacy-filter';
		} else {
			$apply_class = '';
		}
		$visibility = bp_activity_get_meta( bp_get_activity_id(), 'bbwall-activity-privacy' );
		?>
		<a href="#" class="button bp-secondary-action buddyboss_privacy_filter <?php echo $apply_class; ?> " onclick="return buddyboss_wall_initiate_privacy_form( this );" data-activity_id="<?php bp_activity_id(); ?>" data-visibility="<?php echo $visibility; ?>" title="<?php _e( 'Privacy', 'buddyboss-wall' ); ?>">
			<?php _e( 'Privacy', 'buddyboss-wall' ); ?>
		</a>
		<?php
	}
}

add_action( 'bp_activity_entry_meta', 'buddyboss_wall_editing_privacy', 10 );

/**
 *  Do action bp_activity_privacy_load_core
 */
function buddyboss_wall_activity_privacy_load_core() {
	do_action( 'bp_activity_privacy_load_core' );
}

add_action( 'bp_init', 'buddyboss_wall_activity_privacy_load_core', 5 );

/**
 * Register AJAX handlers for a list of actions.
 *
 */
function buddyboss_wall_activity_privacy_register_actions() {
	$actions = array(
		// Update filters
		'buddyboss_wall_update_activity_privacy' => 'buddyboss_wall_update_activity_privacy',
	);

	/**
	 * Register all of these AJAX handlers
	 *
	 * The "wp_ajax_" action is used for logged in users, and "wp_ajax_nopriv_"
	 * executes for users that aren't logged in. This is for backpat with BP <1.6.
	 */
	foreach ( $actions as $name => $function ) {
		add_action( 'wp_ajax_' . $name, $function );
		add_action( 'wp_ajax_nopriv_' . $name, $function );
	}
}

add_action( 'bp_activity_privacy_load_core', 'buddyboss_wall_activity_privacy_register_actions', 1 );

/**
 * Update the privacy meta
 *
 */
function buddyboss_wall_update_activity_privacy() {

	check_ajax_referer( 'bboss_wall_privacy', 'bboss_wall_privacy_nonce' );

	// Sanitize the post object
	$activity_id = esc_attr( $_POST[ 'activity_id' ] );
	$visibility	 = esc_attr( $_POST[ 'buddyboss_activity_visibility' ] );

	if ( isset( $visibility ) ) {
		bp_activity_update_meta( $activity_id, 'bbwall-activity-privacy', $visibility );
	}
	$retval = array(
		'status'	 => true,
		'message'	 => __( 'Privacy updated', 'buddyboss-wall' ),
	);
	die( json_encode( $retval ) );
}
