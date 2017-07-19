<?php
/**
 * @package WordPress
 * @subpackage BuddyBoss Wall
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * This adds how many people liked an item
 *
 * @since BuddyBoss Wall (1.0.0)
 */
function buddyboss_wall_add_likes_comments()
{
  echo get_wall_add_likes_comments( bp_get_activity_id() );
}
function get_wall_add_likes_comments( $activity_id, $refetch_users_who_liked=false, $cssclass='' )
{
  global $bp, $buddyboss_wall;

  static $ran = array();

  // Only get likes for parent comment items, this can be done else where
  // but let's take care if it at the source of the action
  if ( isset( $_POST['action'] ) && $_POST['action'] == 'new_activity_comment' )
    return;

  // Only run once
  if ( isset( $ran[ $activity_id ] ) && $ran[ $activity_id ] === true )
    return;

  $ran[ $activity_id ] = true;

  $activity_id = (int) $activity_id;

  if ( $activity_id === 0 )
    return false;

  $count = (int) bp_activity_get_meta( $activity_id, 'favorite_count' );

  if ( $count === 0 )
    return false;

  $user_likes_this = false;
  $user_logged_in = is_user_logged_in();

  $subject_single = __( 'person' , 'buddyboss-wall' );
  $subject_plural = __( 'people' , 'buddyboss-wall' );
  $subject = ($count == 1) ? $subject_single : $subject_plural;

  $verb_single = __( 'likes' , 'buddyboss-wall' );
  $verb_plural = __( 'like' , 'buddyboss-wall' );
  $verb = ($count > 1) ? $verb_plural : $verb_single;

  $count_txt = number_format_i18n( $count ) . ' ';

  $like_html = '';
  $like_txt = '';

  $tooltip_txt = '';
  $tooltip_html = '';

  //a value is passed in $cssclass argument only if we are dealing with an activity reply
  //in that case, lets add another class
  if( $cssclass )
	  $activity_classes = array( 'activity-like-count', 'reply-like-count' );
  else
	  $activity_classes = array( 'activity-like-count' );


  // If we don't have a current activity ID we're not in the loop and
  // this is an AJAX request and we need to create a loop
  $forced_loop = false;
  $wrap_in_ul = false;

  //if the function is called from inside an ajax request(like/unlike action)
  //then we must not wrap the response in ul
  //so $wrap_in_ul stays false in that case, no matter what
  if( ! defined( 'DOING_AJAX' ) ){
	if ( ! bp_get_activity_id() )
	{
	  if ( bp_has_activities( 'include=' . $activity_id ) )
	  {
		while ( bp_activities() )
		{
		  bp_the_activity();

		  // If there are no comments we need to wrap this in a UL
		  if ( ! bp_activity_get_comment_count() )
		  {
			$wrap_in_ul = true;
		  }

		  $forced_loop = true;
		}
	  }
	}
	else {
	  // If there are no comments we need to wrap this in a UL
	  if ( ! bp_activity_get_comment_count() )
	  {
		$wrap_in_ul = true;
	  }
	}
  }

  // Check if user likes this
  if ( $user_logged_in )
  {
    $user_id = intval( bp_loggedin_user_id() );

    $favorite_activity_entries = bp_get_user_meta( $user_id, 'bp_favorite_activities', true );

    // Check if logged in user likes this as well
    if ( !empty( $favorite_activity_entries ) && in_array( $activity_id, $favorite_activity_entries ) )
    {
      $user_likes_this = true;
    }
  }

  // If user isn't logged we show simple like html
  if ( ! $user_logged_in )
  {
    $like_txt = sprintf( __( '%s %s %s this.', 'buddyboss-wall' ), $count_txt, $subject, $verb );
  }

  // If user is logged in, show names and tooltip
  else {
    $users_who_liked = buddyboss_wall_get_users_who_liked( $activity_id );
	//if( !$users_who_liked && $refetch_users_who_liked ){
	if( !$users_who_liked ){
		$users_who_liked = buddyboss_wall_refetch_users_who_liked( $activity_id );
	}
	
	if( !$user_likes_this && ( !$users_who_liked || empty( $users_who_liked ) ) ){
        //can occur if user who liked is deleted
        return false;
	}

    $like_txt = $count . ( $user_likes_this ? 'y' : 'n' );
	$activity_like_text = buddyboss_wall()->option( 'activity-like-text' );
	
	if ( empty($activity_like_text) ) { 
		$activity_like_text = 'yes'; //Fix for fresh install
	}

    // Only user likes this
    if ( $count === 1 && $user_likes_this && $activity_like_text == 'yes' )
    {
      $like_txt = __( 'You like this.', 'buddyboss-wall' );
    }
    elseif ( $count === 1 && $user_likes_this && $activity_like_text == 'no' )
    {
      $like_txt = sprintf( __( '<a href="%s" title="%s">%s</a> likes this', 'buddyboss-wall' ), esc_url( bp_get_loggedin_user_link() ), esc_attr( bp_get_loggedin_user_fullname() ), esc_html( bp_get_loggedin_user_fullname() ) );
    }
    // Show up to two user names (you + 2 others)
    else {
      $liked_for_display = array();
      $liked_for_tooltip = array();

      $current = 0;

      // Fallback
      $like_txt = __( 'Error getting likes.', 'buddyboss-wall' );

      foreach( $users_who_liked as $user ) {

        if ( ! $user['profile'] || ! $user['name'] )  continue;

        $user_liked_html = '<a href="'.esc_url( $user['profile'] ).'" title="'.esc_attr( $user['name'] ).'">'.esc_html( $user['name'] ).'</a>';

        // For the first two we want the output to show
        if ( $current < 2 )
        {
          $liked_for_display[] = $user_liked_html;
        }
        // For all other users we want the output in a tooltip
        else {
          $liked_for_tooltip[] = $user_liked_html;
        }

        $current++;
      }

      $others = count( $liked_for_tooltip );

      // 1 user
      if ( count( $liked_for_display ) === 1 )
      {
        if ( $user_likes_this && $activity_like_text == 'yes' )
        {
          $like_txt = sprintf( __( 'You and %s %s this.', 'buddyboss-wall' ), $liked_for_display[0], $verb_plural );
        }
        elseif ( $user_likes_this && $activity_like_text == 'no' )
        {
          $like_txt = sprintf( __( '<a href="%s" title="%s">%s</a>'.' and %s %s this.', 'buddyboss-wall' ), esc_url( bp_get_loggedin_user_link() ), esc_attr( bp_get_loggedin_user_fullname() ), esc_html( bp_get_loggedin_user_fullname() ), $liked_for_display[0], $verb_plural );
        }
        else {
          $like_txt = sprintf( __( '%s %s this.', 'buddyboss-wall' ), $liked_for_display[0], $verb_single );
        }
      }

      // 2 users + no others
      else if ( count( $liked_for_display ) === 2 && $others === 0 )
      {
        if ( $user_likes_this )
        {
          $like_txt = sprintf( __( 'You, %s and %s %s this.', 'buddyboss-wall' ), $liked_for_display[0], $liked_for_display[1], $verb_plural );
        }
        else {
          $like_txt = sprintf( __( '%s and %s %s this.', 'buddyboss-wall' ), $liked_for_display[0], $liked_for_display[1], $verb_plural );
        }
      }

      // 2 users + others
      else if ( count( $liked_for_display ) === 2 && $others > 0 )
      {
        $subject = $others === 1 ? $subject_single : $subject_plural;
        $verb = $others === 1 ? $verb_single : $verb_plural;

        $others_count_txt = number_format_i18n( $others );
        $others_i18n = sprintf( __( '%s other %s', 'buddyboss-wall' ), $others_count_txt, $subject );
        $others_txt = '<a class="buddyboss-wall-tt-others">' . $others_i18n . '</a>';

        if ( $user_likes_this )
        {
          $like_txt = sprintf( __( 'You, %s, %s and %s %s this.', 'buddyboss-wall' ), $liked_for_display[0], $liked_for_display[1], $others_txt, $verb_plural );
        }
        else {
          $like_txt = sprintf( __( '%s, %s and %s %s this.', 'buddyboss-wall' ), $liked_for_display[0], $liked_for_display[1], $others_txt, $verb_plural );
        }
      }

      // Tooltip
      if ( ! empty( $liked_for_tooltip ) )
      {
        $tooltip_html = implode( '<br/>', $liked_for_tooltip );

        $like_txt .= '<div class="buddyboss-wall-tt-content">' . $tooltip_html . '</div>';

        $activity_classes[] = 'buddyboss-wall-tt';
      }

      $liked_for_display_html = implode( ',', $liked_for_display );

      // var_dump( $liked_for_display );
      // var_dump( $liked_for_tooltip );
    }
  }

  $activity_class = implode( ' ', $activity_classes );

  $like_html = sprintf( '<li class="%s">%s</li>', $activity_class, $like_txt );

  if ( $wrap_in_ul )
    $like_html = '<ul class="'. esc_attr($cssclass) .'">' . $like_html . '</ul>';

  return $like_html;
}

function replies_get_wall_add_likes_comments( $reply_id ){
	$html = get_wall_add_likes_comments( $reply_id, false, 'acomment-reply-like-content' );
	
	//make sure its wrappeed in ul tag
	if( substr( $html, 0, 4 ) !== '<ul>' ){
		$html = "<ul class='acomment-reply-like-content'>" . $html . "</ul>";
	}
	return $html;
}
?>