<?php
/**
 * @package WordPress
 * @subpackage BuddyBoss Wall
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Sets a cookie and redirects to activity page so the mentions tab
 * will be selected. Used for linking users that click on the new
 * mentions notification in the WP menu.
 * 
 * @since   BuddyBoss Wall (1.0.9)
 * @return  void
 */
function buddyboss_wall_check_force_mentions_tab()
{
  // Check if BP activity component is active, if the directory is active and if we need to activate @mentions tab
  if ( empty( $_REQUEST['buddyboss_wall_mentions_tab'] ) || (int)$_REQUEST['buddyboss_wall_mentions_tab'] !== 1 
       || ! bp_is_active( 'activity' ) || ! bp_activity_has_directory() )
  {
    return;
  }

  // Set proper scope via cookies, the BP Javascript will take care of the rest
  @setcookie( 'bp-activity-scope', 'mentions', 0, '/' );
  @setcookie( 'bp-activity-filter', '-1', 0, '/' );
  @setcookie( 'bp-activity-oldestpage', '1', 0, '/' );

  // Clear notifications
  buddyboss_wall_clear_at_mentions_notifications();

  wp_redirect( bp_get_activity_directory_permalink() );

  exit(0);
}

/**
 * Clear at mention notifications for logged in user
 * 
 * @return  void
 */
function buddyboss_wall_clear_at_mentions_notifications()
{
  if ( (int)bp_loggedin_user_id() > 0 && bp_is_active( 'notifications' ) && bp_is_active( 'activity' ) )
  {
    bp_notifications_mark_notifications_by_type( bp_loggedin_user_id(), buddypress()->activity->id, 'new_at_mention' );
  }
}

/**
 * Handle logging
 *
 * @param  string $msg Log message
 * @return void
 */
function buddyboss_wall_log( $msg )
{
  global $buddyboss_wall;

  // $buddyboss_wall->log[] = $msg;
}

/**
 * Print log at footer
 *
 * @return void
 */
function buddyboss_wall_print_log()
{
  ?>
  <div class="buddyboss-wall-log">
    <pre>
      <?php print_r( $buddyboss_wall->log ); ?>
    </pre>

    <br/><br/>
    <hr/>
  </div>
  <?php
}
// add_action( 'wp_footer', 'buddyboss_wall_print_log' );

/**
 * Check if the current profile a user is on is a friend or not
 *
 * @since BuddyBoss Wall (1.0.0)
 */
function buddyboss_wall_is_my_friend( $id = null )
{
  global $bp, $buddyboss_wall;

  // Return null if we don't know because BuddyPress doesn't
  // exist/isn't activated or the user isn't logged in.
  if ( empty( $bp ) || ! is_user_logged_in() )
    return null;

  if( !bp_is_active('friends') )
	  return null;
  
  // Defaults to checking for if the displayed user is
  // the logged in user's friend if no uder $id is passed.
  if ( $id === null )
  {
    $id = $bp->displayed_user->id;
  }

  return 'is_friend' == BP_Friends_Friendship::check_is_friend( $bp->loggedin_user->id, $id );
}

/**
 * Return array of users who liked an activity item. Relies on
 * the preparation functions and $buddyboss_wall global
 *
 * @param  int    $activity_id [description]
 * @return array              [description]
 */
function buddyboss_wall_get_users_who_liked( $activity_id )
{
  global $buddyboss_wall;

  $like_users = $buddyboss_wall->like_users;
  $likes_to_users = $buddyboss_wall->likes_to_users;

  if ( empty( $like_users ) || empty( $likes_to_users ) )
  {
    return array();
  }

  $users_who_liked = array();
  $user_ids_who_liked = array();

  if ( ! empty( $likes_to_users[ $activity_id ] ) )
  {
    $user_ids_who_liked = (array) $likes_to_users[ $activity_id ];
  }

  if ( ! empty( $user_ids_who_liked ) )
  {
    foreach( $user_ids_who_liked as $user_id )
    {
      $user_data = $like_users[ $user_id ];

      if ( ! empty( $user_data ) )
      {
        $users_who_liked[ $user_id ] = $user_data;
      }
    }
  }

  return $users_who_liked;
}

/**
 * Retrieve user information from liked activity items
 * all at once
 *
 * @since BuddyBoss Wall (1.0.0)
 */
function buddyboss_wall_prepare_user_likes( $activities_template )
{
  global $buddyboss_wall, $wpdb;

  $activities = array();
  $activity_ids = array();

  $user_result = array();
  $users = array();
  $likes_to_users = array();

  // We don't want the logged in user
  $loggedin_user_id = intval( bp_loggedin_user_id() );

  if ( isset( $activities_template->activities ) && ! empty( $activities_template->activities ) && is_array( $activities_template->activities ) )
  {
    $activities = $activities_template->activities;
  }

  if( isset( $activities ) && !empty( $activities ) ){
      foreach( $activities as $activity )
      {
          if ( ! empty( $activity->id ) && intval( $activity->id ) > 0 )
          {
              $activity_ids[] = intval( $activity->id );
          }
      }
  }

  if ( isset( $activity_ids ) && ! empty( $activity_ids ) )
  {
    $sql  = "SELECT user_id,meta_value FROM {$wpdb->base_prefix}usermeta
            WHERE meta_key = 'bp_favorite_activities'
            AND user_id != $loggedin_user_id
            AND (";
    $sql .= ' meta_value LIKE "%' . implode( '%" OR meta_value LIKE "%', $activity_ids ) . '%" )';

    $query = $wpdb->get_results( $sql );

    $user_ids = array();

    // var_dump( $query );

    // Add user IDs to array for USer Query below and store likes
    if ( ! empty( $query ) )
    {
      foreach( $query as $result )
      {
        $user_ids[] = $result->user_id;
        $user_likes = maybe_unserialize( $result->meta_value );

        // Make sure all activity IDs are integers
        if ( ! empty( $user_likes ) && is_array( $user_likes ) )
        {
          $users[ $result->user_id ]['likes'] = array_map( 'intval', $user_likes );
        }
        else {
          $users[ $result->user_id ]['likes'] = array();
        }
      }
    }

    // Get users tha have liked activities in this loop
    if ( ! empty( $user_ids ) )
    {
      $user_query = bp_core_get_users( array(
        'include' => $user_ids
      ) );

      if ( ! empty( $user_query['users'] ) )
      {
        $user_result = $user_query['users'];
      }
    }
  }

  // Add profile links and display names
  foreach ( $user_result as $user )
  {
    $users[ $user->ID ]['profile'] = bp_core_get_user_domain( $user->ID );
    $users[ $user->ID ]['name']    = $user->display_name;
  }

  $like_activity_ids = array();

  foreach( $users as $user_id => $user_data )
  {
    $liked_activities = $user_data['likes'];
    if (is_array($liked_activities) || is_object($liked_activities))
	 {
        foreach( $liked_activities as $liked_activity_id )
        {
          if ( empty( $likes_to_users[ $liked_activity_id ] )
               || ! in_array( $user_id, $likes_to_users[ $liked_activity_id ] ) )
          {
            $likes_to_users[ $liked_activity_id ][] = $user_id;
          }
        }
    }
  }

  $buddyboss_wall->like_users = $users;
  $buddyboss_wall->likes_to_users = $likes_to_users;
  // var_dump( $likes_to_users, $users );
}

function buddyboss_wall_refetch_users_who_liked( $activity_id ){
	global $wpdb;
  $user_result = array();
  $users = array();

  // We don't want the logged in user
  $loggedin_user_id = intval( bp_loggedin_user_id() );

	/* @todo: fix this */
	$activity_ids = array($activity_id);
	
    $sql  = "SELECT user_id,meta_value FROM {$wpdb->usermeta}
            WHERE meta_key = 'bp_favorite_activities'
            AND user_id != $loggedin_user_id
            AND (";
    $sql .= ' meta_value LIKE "%' . implode( '%" OR meta_value LIKE "%', $activity_ids ) . '%" )';

    $query = $wpdb->get_results( $sql );

    $user_ids = array();

    // var_dump( $query );

    // Add user IDs to array for USer Query below and store likes
    if ( ! empty( $query ) )
    {
      foreach( $query as $result )
      {
        $user_ids[] = $result->user_id;
        $user_likes = maybe_unserialize( $result->meta_value );

        // Make sure all activity IDs are integers
        if ( ! empty( $user_likes ) && is_array( $user_likes ) )
        {
          $users[ $result->user_id ]['likes'] = array_map( 'intval', $user_likes );
        }
        else {
          $users[ $result->user_id ]['likes'] = array();
        }
      }
    }

    // Get users who have liked activities in this loop
    if ( ! empty( $user_ids ) )
    {
      $user_query = bp_core_get_users( array(
        'include' => $user_ids
      ) );

      if ( ! empty( $user_query['users'] ) )
      {
        $user_result = $user_query['users'];
      }
    }

  // Add profile links and display names
  foreach ( $user_result as $user )
  {
    $users[ $user->ID ]['profile'] = bp_core_get_user_domain( $user->ID );
    $users[ $user->ID ]['name']    = $user->display_name;
  }

  return $users;
}

/**
 * Determines if the currently logged in user is an admin
 * TODO: This should check in a better way, by capability not role title and
 * this function probably belongs in a functions.php file or utility.php
 */
function buddyboss_wall_is_admin()
{
	return is_user_logged_in() && current_user_can( 'administrator' );
}

/**
 * Url Parser callback
 */
add_action( 'wp_ajax_bb_url_parser', 'bb_url_parser_callback' );
add_action( 'wp_ajax_nopriv_bb_url_parser', 'bb_url_parser_callback' );

function bb_url_parser_callback(){
    require_once BUDDYBOSS_WALL_PLUGIN_DIR . 'includes/url-scraper-php/website_parser.php';

    // curling
	$json_data = array();
    if(  class_exists( 'WebsiteParser' ) ){

		$url = $_POST[ 'url' ];
		$parser = new WebsiteParser( $url );
		$body = wp_remote_get( $url );

		if( ! is_wp_error( $body ) && isset( $body['body'] ) ){

			$title = '';
			$description = '';
			$images = array();

			$parser->content = $body['body'];

			$meta_tags = $parser->getMetaTags( false );
			
			if( is_array( $meta_tags ) && !empty( $meta_tags ) ){
				foreach( $meta_tags as $tag ){
					if( is_array( $tag ) && !empty( $tag ) ){
						if( $tag[0] == 'og:title' ){
							$title = $tag[1];
						}
						if( $tag[0] == 'og:description' ){
							$description = html_entity_decode( $tag[1], ENT_QUOTES, "utf-8" );
						} elseif( strtolower( $tag[0] ) == 'description' && $description == '' ){
							$description = html_entity_decode( $tag[1], ENT_QUOTES, "utf-8" );
						}
						if( $tag[0] == 'og:image' ){
							$images[] = $tag[1];
						}
					}
				}
			}
			if( $title == '' ){
				$title = $parser->getTitle( false );
			}
			if( empty( $images ) ){
				$images = $parser->getImageSources( false );
			}
			$json_data['title'] = $title;

            $bb_link_description_read_more = ' <a href="' . esc_url( $url ) . '" target="_blank" rel="nofollow">'. __( 'Read more', 'buddyboss-wall' ) .'...</a>';
            $description = mb_strimwidth( $description, 0, 400, $bb_link_description_read_more );

			$json_data['description'] = $description;
			$json_data['images'] = $images;
			$json_data['error'] = '';
		} else {
			$json_data['error'] = 'Sorry! preview is not available right now. Please try again later.';
		}
    } else {
		$json_data['error'] = 'Sorry! preview is not available right now. Please try again later.';
	}
	echo json_encode( $json_data );
    die();
}

add_action( 'bp_activity_after_save', 'bb_bp_activity_url_preview' );
function bb_bp_activity_url_preview( &$activity ) {
	global $activity_id, $wpdb, $bp;

    $activity_id = $activity->id;

	if ( isset( $_POST[ 'bb_link_url' ] ) && $_POST[ 'bb_link_url' ] != '' ) {

        // Disable activity embeds by making links clickable
        // We do not want site to have activity embeds enabled when activity has link preview by the wall plugin
        $wpdb->update( $bp->activity->table_name,
            array(
                'content' => make_clickable( $activity->content ),
            ),
            array(
                'id' => $activity_id
            )
        );
		
		$updated_content = '<div class="bb_final_link">';
		if ( isset($_POST[ 'bb_link_img' ]) &&  $_POST[ 'bb_link_img' ] != '' ) {
			$image_url = bb_wall_media_sideload_image($_POST[ 'bb_link_img' ]);
            if( $image_url && !is_wp_error( $image_url ) ){
                $updated_content .= '<div class="bb_link_preview_container">';
                $updated_content .= '<a href="' . esc_url( $_POST[ 'bb_link_url' ] ) . '" target="_blank"><img src="' . $image_url . '" /></a>';
                $updated_content .= '</div>';
            }
		}
		$updated_content .= '<div class="bb_link_contents">';
		$updated_content .= '<span class="bb_link_preview_title"><a href="' . esc_url( $_POST[ 'bb_link_url' ] ) . '" target="_blank" rel="nofollow">' . addslashes( $_POST[ 'bb_link_title' ] ) . '</a></span>';
		$updated_content .= '<span class="bb_link_preview_body">' . addslashes( $_POST[ 'bb_link_description' ] ) . '</span>';
		$updated_content .= '</div>';
		$updated_content .= '</div>';
		$updated_content .= '<br/>';

		bp_activity_update_meta( $activity_id, 'bb_bp_activity_text', $updated_content );
	}
}

/**
 * Deleted activity stream, the attached image/images
 * @param $args
 */
function bb_bp_activity_url_preview_media_delete( $args ) {

  $attachment_id = bp_activity_get_meta( $args['id'], 'bb_bp_activity_media' );

  if ( ! empty ( $attachment_id ) ) {
    wp_delete_attachment( $attachment_id );
  }
}

add_action( 'bp_before_activity_delete', 'bb_bp_activity_url_preview_media_delete', 10, 1 );

add_action('bp_get_activity_content_body','bb_bp_activity_url_filter');
function bb_bp_activity_url_filter($content) {
    //if link preview is disabled, dont do anything.
	if( !buddyboss_wall()->option( 'enabled_link_preview' ) )
        return $content;
    
	global $activities_template;
	
	$curr_id = isset( $activities_template->current_activity ) ? $activities_template->current_activity : '';
    $act_id = isset( $activities_template->activities[$curr_id]->id ) ? (int)$activities_template->activities[$curr_id]->id : '';
	
	// Check for activity ID in $_POST if this is a single
    // activity request from a [read more] action
	if ( $act_id === 0 && ! empty( $_POST['activity_id'] ) )
    {
      $activity_array = bp_activity_get_specific( array(
        'activity_ids'     => $_POST['activity_id'],
        'display_comments' => 'stream'
      ) );

      $activity = ! empty( $activity_array['activities'][0] ) ? $activity_array['activities'][0] : false;
      $act_id = (int)$activity->id;
    }
	
	// This should never happen, but if it does, bail.
    if ( $act_id === 0 ) { return $content; }
	
	$url_preview_html = bp_activity_get_meta( $act_id, 'bb_bp_activity_text', true );

	if ( empty( $url_preview_html ) ) {
		return $content;
	}
	
	$content .= stripslashes( $url_preview_html );
	
	return $content;
	
}

/**
 * Download an image from the specified URL and attach it to a post.
 *
 * @since 1.1.9
 *
 * @param string $file The URL of the image to download
 * @param string $desc Optional. Description of the image
 * @return string|WP_Error id success
 */
function bb_wall_media_sideload_image( $file ) {
	if ( ! empty( $file ) ) {
		// Set variables for storage, fix file filename for query strings.
		preg_match( '/[^\?]+\.(jpe?g|jpe|gif|png)\b/i', $file, $matches );
		$file_array = array();

        if ( empty( $matches ) ) {
          return;
        }

        $file_array['name'] = basename( $matches[0] );

		// Download file to temp location.
		$file_array['tmp_name'] = download_url( $file );

		// If error storing temporarily, return the error.
		if ( is_wp_error( $file_array['tmp_name'] ) ) {
			return $file_array['tmp_name'];
		}

		// Do the validation and storage stuff.
		$id = bb_wall_media_handle_sideload( $file_array );

		// If error storing permanently, unlink.
		if ( is_wp_error( $id ) ) {
			@unlink( $file_array['tmp_name'] );
			return $id;
		}
	}

	// Finally check to make sure the file has been saved, then return the attachment_url.
	if ( ! empty( $id ) ) {
		$attachment_data = wp_get_attachment_image_src($id, 'bbwall-url-preview-thumb');
		return $attachment_data[0];
	}
}

/**
 * This handles a sideloaded file in the same way as an uploaded file is handled by {@link media_handle_upload()}
 *
 * @since 1.9.0
 *
 * @param array $file_array Array similar to a {@link $_FILES} upload array
 * @param array $post_data allows you to overwrite some of the attachment
 * @return int|object The ID of the attachment or a WP_Error on failure
 */
function bb_wall_media_handle_sideload($file_array, $post_data = array()) {
  global $activity_id;;


	$overrides = array('test_form'=>false);

	$time = current_time( 'mysql' );
	if ( $post = get_post() ) {
		if ( substr( $post->post_date, 0, 4 ) > 0 )
			$time = $post->post_date;
	}

	$file = wp_handle_sideload( $file_array, $overrides, $time );
	if ( isset($file['error']) )
		return new WP_Error( 'upload_error', $file['error'] );

	$url = $file['url'];
	$type = $file['type'];
	$file = $file['file'];
	$title = preg_replace('/\.[^.]+$/', '', basename($file));
	$content = '';

	// Use image exif/iptc data for title and caption defaults if possible.
	if ( $image_meta = @wp_read_image_metadata($file) ) {
		if ( trim( $image_meta['title'] ) && ! is_numeric( sanitize_title( $image_meta['title'] ) ) )
			$title = $image_meta['title'];
		if ( trim( $image_meta['caption'] ) )
			$content = $image_meta['caption'];
	}

	if ( isset( $desc ) )
		$title = $desc;

	// Construct the attachment array.
	$attachment = array_merge( array(
		'post_mime_type' => $type,
		'guid' => $url,
		'post_title' => $title,
		'post_content' => $content,
	), $post_data );
	

	// This should never be set as it would then overwrite an existing attachment.
	if ( isset( $attachment['ID'] ) )
		unset( $attachment['ID'] );

	// Save the attachment metadata
	$id = wp_insert_attachment( $attachment, $file );
	if ( !is_wp_error($id) )
		wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $file ) );

    //Set activity link preview media id
    bp_activity_update_meta( $activity_id, 'bb_bp_activity_media', $id );

	return $id;
}

function bb_wall_new_nav_default() {

	$setting_default_profile_tab = buddyboss_wall()->option( 'setting_default_profile_tab' );

    //Bail if default tab is not News Feed or current page part of the profile of the logged-in user
	if ( 'newsfeed' != $setting_default_profile_tab || ! bp_is_my_profile() ) {
		return;
	}
	
	$bp = buddypress();
	$args = array(
		'parent_slug'     => $bp->activity->slug, // Slug of the parent
		'screen_function' => 'bp_activity_screen_my_activity', // The name of the function to run when clicked
		'subnav_slug'     => 'news-feed'  // The slug of the subnav item to select when clicked
	);
	
	bp_core_new_nav_default($args);
}
add_action( 'bp_setup_nav', 'bb_wall_new_nav_default', 999 );

?>