<?php
/**
 * @package WordPress
 * @subpackage BuddyBoss Wall
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * 
 */
function buddyboss_wall_check_mentions_notifications()
{
  if ( ! bp_is_active( 'activity' ) || ! bp_is_active( 'notifications' ) || ! bp_activity_do_mentions() )
  {
    return;
  }

  // If we the global activity directory is disabled handle this on the user's profile
  if ( bp_is_my_profile() && bp_is_current_component( 'activity' ) && ! bp_activity_has_directory() )
  {
    buddyboss_wall_clear_at_mentions_notifications();
  }
  // Otherwise we'll try to force the mentions tab on the activity page to be active
  else if ( bp_activity_has_directory() )
  {
    buddyboss_wall_check_force_mentions_tab();
  }
}
add_action( 'bp_init', 'buddyboss_wall_check_mentions_notifications' );

/**
 * This echos inline styles that we need to ensure are used,
 * hides post-in select box on the what new (post update) form.
 *
 * @since BuddyBoss Wall (1.0.0)
 */
function buddyboss_wall_inline_styles()
{
  global $bp;

  if ( bp_is_user() || ! bp_is_current_component( 'activity' ) )
  {
    echo '<style type="text/css">#whats-new-post-in-box { display: none!important; }</style>';
  }
}

/**
 * This filters wall actions, when reading an item it will convert it to use wall markup
 *
 * @since BuddyBoss Wall (1.0.0)
 */
function buddyboss_wall_read_filter( $action )
{
  global $activities_template;

  $current_activity_index = isset( $activities_template->current_activity ) ? $activities_template->current_activity : '';

  $current_activity = isset( $activities_template->activities[$current_activity_index] ) ? $activities_template->activities[$current_activity_index] : '';

  $current_activity_id = isset( $current_activity->id ) ? $current_activity->id : '';

  // Check if the activity meta table has an associated wall action
  $bbwall_action = bp_activity_get_meta( $current_activity_id, 'buddyboss_wall_action' );

  // This section formats a group status update
  //
  // If you're looking at your own activity it should say:
  // You posted an update to [group name]
  //
  // Without this formatting it would say:
  // [username] posted an update to [group name]
  //
  // That doesn't make sense when you're looking at your own activity stream
  if ( $current_activity->component === 'groups' &&
       (int)$current_activity->user_id === bp_loggedin_user_id() )
  {
    $to_replace = bp_core_get_userlink( bp_loggedin_user_id() );

    $you_text   = sprintf( '<span class="buddyboss-you-text">%s</span>', __( 'You', 'buddyboss-wall' ) );

    $bbwall_action = str_replace( $to_replace, $you_text, $action );
  }

	if ( $bbwall_action )
  {
    // Strip any legacy time since placeholders from BP 1.0-1.1
    $content = str_replace( '<span class="time-since">%s</span>', '', $bbwall_action );

    // Insert the time since.
    $time_since = apply_filters_ref_array( 'bp_activity_time_since', array( '<span class="time-since">' . bp_core_time_since( $activities_template->activity->date_recorded ) . '</span>', &$activities_template->activity ) );
    
    // if group component then pass blank time_since
    if($current_activity->component === 'groups'){
        $time_since = '';
    }
    
    // Insert the permalink
    if ( !bp_is_single_activity() )
      $content = apply_filters_ref_array( 'bp_activity_permalink', array( sprintf( '%1$s <a href="%2$s" class="view activity-time-since" title="%3$s">%4$s</a>', $content, bp_activity_get_permalink( $activities_template->activity->id, $activities_template->activity ), esc_attr__( 'View Discussion', 'buddypress' ), $time_since ), &$activities_template->activity ) );
    else
      $content .= str_pad( $time_since, strlen( $time_since ) + 2, ' ', STR_PAD_BOTH );

    return apply_filters( 'buddyboss_wall_activity_action', $content );
  }
  
  return $action;
}

/**
 * This will save wall related data to the activity meta table when a new wall post happens
 *
 * @since BuddyBoss Wall (1.0.0)
 */
function buddyboss_wall_input_filter( &$activity ) {
  global $bp, $buddyboss_wall;

  $user       = $bp->loggedin_user;
  $tgt        = $bp->displayed_user;
  $new_action = false;
  $object     = null;

  // Need to check the object
  if ( ! empty( $_POST['whats-new-post-object'] ) ) {
    $object = apply_filters( 'bp_activity_post_update_object', $_POST['whats-new-post-object'] );
  }
  else if ( ! empty( $_POST['object'] ) ) {
    $object = apply_filters( 'bp_activity_post_update_object', $_POST['object'] );
  }

  // Are we on wall (my own or someone else's) or on sitewide activity page?
  //
  // If we're on the sitewide activity page the user can still select to
  // post to a group so we check that here as well
  //
  // Our conditional will make sure that the object is empty. The object is
  // always empty when we're posting in our activity or someone else's (wall),
  // so to be forward thinking it's best to check for an empty object rather
  // than if $object !== 'groups'
  //
  // This way future plugin conflicts will be resolved, because a plugin can
  // define an object like "clan" and we'd run into the same problems.
  //
  $is_wall_action = bp_is_current_component( 'activity' ) && empty( $object )
                    && ! empty( $_POST['action'] ) && $_POST['action'] === 'post_update';

  if ( !empty($activity->content) && ( $is_wall_action || $bp->current_action == 'forum' ) )
  {
  	/**
  	 * is it mention?
  	 *	yes
  	 *		- does it mention multiple people?
  	 *			yes
  	 *				- it should be '%INITIATOR% mentioned .......'
  	 *			no
  	 *				only one user was mentioned.
  	 *				it can happen in 2 cases:
  	 *				1. member1 posting on member2's wall
  	 *				2. member1 mentioning member2(from anywhere else on the website)
  	 *
  	 *				are we on someone else's profile?
  	 *					yes
  	 *						- it should be '%INITIATOR% posted on %TARGET% wall'
  	 *					no
  	 *						- it should be '%INITIATOR% mentioned .......'
  	 *	no
  	 *		- continue
  	 * is it a forum post
  	 *	yes
  	 *		- do something incomprehensible!
  	 *	no
  	 *		its not a mention.
  	 *		its not a forum post.
  	 *		so it must a siimple status update
  	 *
  	 *		- it should be '%INITIATOR% posted an update ...'
  	 */

    //Set activity target id
    if ( isset( $tgt->id ) ) {
      $activity_target_user_id = $tgt->id;
    }

  	//key value pairs of userid=>username
  	$mentioned = bp_activity_find_mentions($activity->content);
	
  	$len = !empty($mentioned) ? count($mentioned) : 0;
	
  	//is it a mention?
  	if( $len>0 ){
  		//yes its a mention

  		//does it mention multiple people?
  		if( $len> 1 ){
  			//yes, multiple mention
  			$new_action = "%INITIATOR% " . __( 'mentioned' , 'buddyboss-wall' ) ." ".$len." " . __( 'people' , 'buddyboss-wall' );
  		} else {
  			//no, single mention

  			//are we on someone else's profile?
  			if( $tgt->id && $user->id != $tgt->id ){
  				//yes, we are on someone else's profile

  				//it should be '%INITIATOR% posted on %TARGET% wall'
  				$new_action = sprintf( __( "%s wrote on %s Wall", 'buddyboss-wall' ), '%INITIATOR%' , '%TARGET%' );
  			} else {
  				//nope.

  				//it should be '%INITIATOR% mentioned @member3 in a public message.......'
  				//cant save userid as %TARGET%, for while displaying, an apostrophe s will be added and will render the sentence incorrect
  				//temporary solution
  				$arrayKeys = array_keys($mentioned);
  				$user_link = bp_core_get_userlink( $arrayKeys[0] );
  				$new_action = sprintf( __( "%s mentioned %s in a public message", 'buddyboss-wall' ), '%INITIATOR%' , $user_link );
  				$activity_target_user_id = false;
  			}
  		}
  	} else {
  		//not a mention

  		//is it a forum post?
  		if( $bp->current_action == 'forum' ){
  			//yes, its a forum

  			//dont know what to do here
  		} else {
  			//nope. not a forum. so it must be a simple status update

  			//it should be '%INITIATOR% posted an update ...'
  			$new_action = sprintf( __( "%s posted an update", 'buddyboss-wall' ), '%INITIATOR%' );
  			$activity_target_user_id = false;
  		}
  	}
  }

  if ( $new_action )
  {
    $new_action = apply_filters( 'buddyboss-wall-new-action', $new_action, $user, $tgt );

    bp_activity_update_meta( $activity->id, 'buddyboss_wall_action', $new_action );
  	bp_activity_update_meta( $activity->id, 'buddyboss_wall_initiator', bp_loggedin_user_id() );

    if ( $activity_target_user_id )
      bp_activity_update_meta( $activity->id, 'buddyboss_wall_target', $activity_target_user_id );
  }
}

// AJAX update posting
// Credt: POST IN WIRE by Brajesh Singh
function buddyboss_wall_post_update()
{
  global $bp;

  // Check the nonce
  check_admin_referer( 'post_update', '_wpnonce_post_update' );

  if ( !is_user_logged_in() ) {
    echo '-1';
    return false;
  }

  if ( empty( $_POST['content'] ) ) {
    echo '-1<div id="message" class="error"><p>' . __( 'Please enter some content to post.', 'buddyboss-wall' ) . '</p></div>';
    return false;
  }

  $activity_id = false;

  if ( empty( $_POST['object'] ) && function_exists( 'bp_activity_post_update' ) )
  {
    if ( ! bp_is_my_profile() && bp_is_user() )
    {
      $content = "@". bp_get_displayed_user_username()." ".$_POST['content'];
    }
    else {
      $content = $_POST['content'];
    }

    $activity_id = bp_activity_post_update( array( 'content' => $content ) );
  }
  elseif ( $_POST['object'] == 'groups' )
  {
    if ( !empty( $_POST['item_id'] ) && function_exists( 'groups_post_update' ) )
    {
      $activity_id = groups_post_update( array( 'content' => $_POST['content'], 'group_id' => $_POST['item_id'] ) );
    }
  }
  else {
    $activity_id = apply_filters( 'bp_activity_custom_update', $_POST['object'], $_POST['item_id'], $_POST['content'] );
  }

  if ( ! $activity_id )
  {
    echo '-1<div id="message" class="error"><p>' . __( 'There was a problem posting your update, please try again.', 'buddyboss-wall' ) . '</p></div>';
    return false;
  }

  if ( bp_has_activities ( 'include=' . $activity_id ) ) : ?>
  <?php while ( bp_activities() ) : bp_the_activity(); ?>
  <?php bp_get_template_part( 'activity/entry' ) ?>
  <?php endwhile; ?>
  <?php endif;
}

/**
 * Mark an activity as a favourite via a POST request.
 *
 * @return string HTML
 * @since BuddyBoss Wall (1.0.0)
 */
function buddyboss_wall_mark_activity_favorite()
{
  // Bail if not a POST action
  if ( 'POST' !== strtoupper( $_SERVER['REQUEST_METHOD'] ) )
    return;

  if ( bp_activity_add_user_favorite( $_POST['id'] ) )
    $resp['but_text'] = __( 'Unlike', 'buddyboss-wall' );
  else
    $resp['but_text'] = __( 'Like', 'buddyboss-wall' );

  $is_a_comment = isset( $_POST['item_type'] ) && $_POST['item_type']=='comment';
  $resp['num_likes'] = get_wall_add_likes_comments( (int)$_POST['id'], true, $is_a_comment );
  $resp['like_count'] = (int) bp_activity_get_meta( (int)$_POST['id'], 'favorite_count' );

  echo json_encode( $resp );

  exit;
}


/**
 * Un-favourite an activity via a POST request.
 *
 * @return string HTML
 * @since BuddyBoss Wall (1.0.0)
 */
function buddyboss_wall_unmark_activity_favorite() {
  // Bail if not a POST action
  if ( 'POST' !== strtoupper( $_SERVER['REQUEST_METHOD'] ) )
    return;

  if ( bp_activity_remove_user_favorite( $_POST['id'] ) )
    $resp['but_text'] = __( 'Like', 'buddyboss-wall' );
  else
    $resp['but_text'] = __( 'Unlike', 'buddyboss-wall' );

  $is_a_comment = isset( $_POST['item_type'] ) && $_POST['item_type']=='comment';
  $resp['num_likes'] = get_wall_add_likes_comments( (int)$_POST['id'], true, $is_a_comment );
  $resp['like_count'] = (int) bp_activity_get_meta( (int)$_POST['id'], 'favorite_count' );

  echo json_encode( $resp );

  exit;
}

function buddyboss_wall_remove_original_update_functions()
{
  /* actions */
  if ( buddyboss_wall()->is_enabled() )
  {
    // Remove actions related to posting and likes
    remove_action( 'wp_ajax_post_update', 'bp_dtheme_post_update' );
    remove_action( 'wp_ajax_post_update', 'bp_legacy_theme_post_update' );
    remove_action( 'wp_ajax_activity_mark_fav',   'bp_legacy_theme_mark_activity_favorite' );
    remove_action( 'wp_ajax_activity_mark_unfav', 'bp_legacy_theme_unmark_activity_favorite' );

    // Add our custom actions to handle posting and likes
    add_action( 'wp_ajax_activity_mark_unfav', 'buddyboss_wall_unmark_activity_favorite' );
    add_action( 'wp_ajax_activity_mark_fav', 'buddyboss_wall_mark_activity_favorite' );
    add_action( 'wp_ajax_post_update', 'buddyboss_wall_post_update' );

    // Add action for read more links to handle embeds,
    // this was left out of BP's legacy theme support
    add_action( 'bp_legacy_theme_get_single_activity_content', 'bp_dtheme_embed_read_more' );
  }
}
add_action( 'bp_init', 'buddyboss_wall_remove_original_update_functions', 9999 );

function buddyboss_wall_load_template_filter( $found_template, $templates )
{
  global $bp;

  if ( ! buddyboss_wall()->is_enabled() )
    return $found_template;

  $filtered_templates = array();

  foreach ( (array) $templates as $template ) {
    if ( file_exists( STYLESHEETPATH . '/' . $template ) )
      $filtered_templates[] = STYLESHEETPATH . '/' . $template;
    elseif ( file_exists( TEMPLATEPATH . '/' . $template ) )
      $filtered_templates[] = TEMPLATEPATH . '/' . $template;
    elseif ( file_exists( dirname( __FILE__ ) . '/templates/' . $template ) )
      $filtered_templates[] = dirname( __FILE__ ) . '/templates/' . $template;
  }

  if( !empty( $filtered_templates ) )
    $found_template = $filtered_templates[0];

  return apply_filters( 'buddyboss_wall_load_template_filter', $found_template );
}
add_filter( 'bp_located_template', 'buddyboss_wall_load_template_filter', 10, 2 );


function buddyboss_wall_cancel_bp_has_activities()
{
  return false;
}
function buddyboss_wall_qs_filter( $qs )
{
  global $bp, $buddyboss_wall, $buddyboss_ajax_qs;

  $buddyboss_ajax_qs = $qs;

  $action = $bp->current_action;

  if ( $action != "just-me" && $action != "news-feed" )
  {
    // if we're on a different page than wall pass qs as is
    return $qs;
  }

  // else modify it to include wall activities

  // see if we have a page string
  $page = 1;
  if ( preg_match("/^page=\d+/", $qs, $m) || preg_match("/&page=\d+/", $qs, $m) )
    $page = intval(str_replace("page=", "", $m[0])); // if so grab the number

  $activities = $action === 'just-me'
              ? $buddyboss_wall->component->get_wall_activities( $page ) // load wall activities for this page
              : $buddyboss_wall->component->get_feed_activities( $page ); // load feed activities for this page

  if ( ! $activities )
  {
    add_filter( 'bp_has_activities', 'buddyboss_wall_cancel_bp_has_activities' );
  }

  $nqs = "include=$activities";

  // fix the issue- Private Groups do Not Display in News Feed
  if( bp_loggedin_user_id() == bp_displayed_user_id() ){
      $nqs .= "&show_hidden=1";
  }

  return $nqs;
}

/**
 * Trigger cache prime of user names and profile links
 *
 * @since BuddyBoss Wall (1.0.0)
 */
function buddyboss_wall_prepare_likes_filter( $activity, $activities_template )
{
  buddyboss_wall_prepare_user_likes( $activities_template );

  return $activity;
}


/**
 * Format @mention notifications to redirect to the wall
 * @param  [type] $notification [description]
 * @return [type]              [description]
 */
function buddyboss_wall_format_mention_notification( $notification, $at_mention_link, $total_items, $activity_id, $poster_user_id )
{
  // Default activity link
  $activity_link = trailingslashit( bp_loggedin_user_domain() . bp_get_activity_slug() );
  
  // If there's a global activity page, link user to mentions tab
  // We check for this query string in wall-functions.php
  if ( bp_activity_has_directory() )
  {
    $activity_link = trailingslashit( bp_get_activity_directory_permalink() ) . '?buddyboss_wall_mentions_tab=1';
  }

  $at_mention_title = sprintf( __( '@%s Mentions', 'buddyboss-wall' ), bp_get_loggedin_user_username() );

  if ( (int) $total_items > 1 ) {
    $text = sprintf( __( 'You have %1$d new mentions', 'buddyboss-wall' ), (int) $total_items );
  } else {
    $user_fullname = bp_core_get_user_displayname( $poster_user_id );
    $text =  sprintf( __( '%1$s mentioned you', 'buddyboss-wall' ), $user_fullname );
  }

  if ( is_array( $notification ) )
  {
    $notification['link'] = $activity_link;
  }
  else {
    $notification = '<a href="' . $activity_link . '" title="' . $at_mention_title . '">' . $text . '</a>';
  }

  return $notification;
}

/**
 * This filter(and the function hooked) can be entirely removed.
 * Since the new approach saves placeholders in database instead of actual member names,
 * the following method will no longer be required
 */
//add_filter( 'bp_get_activity_action', 'buddyboss_wall_format_post_initiator_name', 11, 3 );
function buddyboss_wall_format_post_initiator_name( $action, $activity, $args ){

	if( 'activity_update'==bp_get_activity_type() && is_user_logged_in() ){
		//if logged in user had posted it, lets replced his/her name with 'You'
		$initiator_id = bp_activity_get_meta($activity->id, 'buddyboss_wall_initiator', true);

		if( bp_loggedin_user_id()==$initiator_id ){
			$myprofile_link = '<a href="'. esc_url( bp_loggedin_user_domain() ) .'" title="' . esc_attr( bp_get_loggedin_user_fullname() ) . '">'. bp_get_loggedin_user_fullname() .'</a>';

			$action = str_replace($myprofile_link, __( 'You', 'buddyboss-wall' ), $action);
		}

		//if it was posted on loggein user's wall, lets replce his/her name with 'your'
		$target_id = bp_activity_get_meta($activity->id, 'buddyboss_wall_target', true);
		if( bp_loggedin_user_id()==$target_id ){
			global $bp;
			$tgt = $bp->loggedin_user;

			if ( substr( $tgt->fullname, -1 ) === 's' ){
				$target_possesive_fullname = sprintf( __( "%s'", 'buddyboss-wall' ), $tgt->fullname );
			}
			else {
				$target_possesive_fullname = sprintf( __( "%s's", 'buddyboss-wall' ), $tgt->fullname );
			}

			$action_href_title = sprintf( __( "%s Wall", 'buddyboss-wall' ), $target_possesive_fullname );

			$tgt_url = sprintf(
				'<a href="%s" title="%s">%s</a>',
				esc_url( $tgt->domain ),
				esc_attr( $action_href_title ),
				$target_possesive_fullname
			);

			$action = str_replace($tgt_url, __( 'your', 'buddyboss-wall' ), $action);
		}
	}

	return $action;
}

function buddyboss_wall_replace_placeholders_with_url( $action, $activity ){

	if( 1==1 ){
		$initiator_id = bp_activity_get_meta($activity->id, 'buddyboss_wall_initiator', true);
		$target_id = bp_activity_get_meta($activity->id, 'buddyboss_wall_target', true);

		// replace %INITIATOR% with userlink/You
		if( is_user_logged_in() && bp_loggedin_user_id()==$initiator_id ){
			$action = str_replace( '%INITIATOR%', __( 'You', 'buddyboss-wall' ), $action);
		}
		else{
			$initiator_name = bp_core_get_user_displayname( $initiator_id );
			/*
			 * a quick workaround to check if the user in question is still valid/account not deleted.
			 * Although, activity entries posted by a, now deleted user, dont show up on activity stream.
			 * Just to be on safe side.
			 */
			if( $initiator_name ){
				$initiator_profile_link = '<a href="'. esc_url( bp_core_get_user_domain( $initiator_id ) ) .'" title="' . esc_attr( $initiator_name ) . '">'. $initiator_name .'</a>';
			}
			else{
				$initiator_profile_link = __( 'Deleted User', 'buddyboss-wall' );
			}

			$action = str_replace( '%INITIATOR%', $initiator_profile_link, $action);
		}

		// replace %TARGET% with userlink/your
		if( is_user_logged_in() && bp_loggedin_user_id()==$target_id ){
			$action = str_replace( '%TARGET%', __( 'your', 'buddyboss-wall' ), $action);
		}
		else{
			$target_name = bp_core_get_user_displayname( $target_id );
			/*
			 * a quick workaround to check if the user in question is still valid/account not deleted
			 */
			if( $target_name ){
				if ( substr( $target_name, -1 ) === 's' ){
					$target_possesive_fullname = sprintf( __( "%s'", 'buddyboss-wall' ), $target_name );
				}
				else {
					$target_possesive_fullname = sprintf( __( "%s's", 'buddyboss-wall' ), $target_name );
				}

				$target_profile_link = '<a href="'. esc_url( bp_core_get_user_domain( $target_id ) ) .'" title="' . esc_attr( $target_name ) . '">'. $target_possesive_fullname .'</a>';
			}
			else{
				$target_profile_link = __( "Deleted User's", "buddyboss-wall" );
			}
			$action = str_replace( '%TARGET%', $target_profile_link, $action);
		}
	}

	return $action;
}

/**
 * add 'like/favorite' button on activity comments
 */
function buddyboss_wall_comments_add_like(){
	if( is_user_logged_in() ):
		if ( !bp_get_comment_is_favorite() ) : ?>
			<a href="<?php bp_comment_favorite_link(); ?>" class="acomment-like fav-comment bp-secondary-action" title="<?php esc_attr_e( 'Mark as Favorite', 'buddypress' ); ?>" onclick="return budyboss_wall_comment_like_unlike(this);"><?php _e( 'Favorite', 'buddypress' ); ?></a>
		<?php else : ?>
			<a href="<?php bp_comment_unfavorite_link(); ?>" class="acomment-like unfav-comment bp-secondary-action" title="<?php esc_attr_e( 'Remove Favorite', 'buddypress' ); ?>" onclick="return budyboss_wall_comment_like_unlike(this);"><?php _e( 'Remove Favorite', 'buddypress' ); ?></a>
		<?php endif;
	endif;
}
add_action( 'bp_activity_comment_options', 'buddyboss_wall_comments_add_like' );

function bp_comment_favorite_link(){
	echo apply_filters( 'bp_get_activity_favorite_link', wp_nonce_url( home_url( bp_get_activity_root_slug() . '/favorite/' . bp_get_activity_comment_id() . '/' ), 'mark_favorite' ) );
}
function bp_comment_unfavorite_link(){
	echo apply_filters( 'bp_get_activity_unfavorite_link', wp_nonce_url( home_url( bp_get_activity_root_slug() . '/unfavorite/' . bp_get_activity_comment_id() . '/' ), 'unmark_favorite' ) );
}

function bp_get_comment_is_favorite() {
	global $activities_template;
    $activities_template->my_favs  = isset( $activities_template->my_favs ) ? $activities_template->my_favs : array();
	return apply_filters( 'bp_get_activity_is_favorite', in_array( bp_get_activity_comment_id(), (array) $activities_template->my_favs ) );
}

/**
 * dlisplay likes for activity comments
 */
function buddyboss_wall_comments_display_likes(){
	if( is_user_logged_in() ){
		echo replies_get_wall_add_likes_comments( bp_get_activity_comment_id() );
	}
}
add_action( 'bp_activity_comment_options', 'buddyboss_wall_comments_display_likes', 999 );

/**
 * Catch access to certain activity type( friends, groups, mention )
 * and redirect accordingly to news-feeds.
 */
function bb_wall_redirect_to_feeds() {
  global $bp;

  if ( ! empty( $bp->current_component )  && BP_ACTIVITY_SLUG == $bp->current_component
       && in_array( $bp->current_action, array( 'friends', 'groups', 'mentions' ) ) ) {

    $news_feed_url = $bp->loggedin_user->domain.'/'.BP_ACTIVITY_SLUG.'/news-feed/';
    wp_redirect( $news_feed_url );
  }

}

add_action( 'bp_template_redirect', 'bb_wall_redirect_to_feeds' );
?>
