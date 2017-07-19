<?php
/**
 * @package WordPress
 * @subpackage BuddyBoss Media
 *
 * @todo Better logging, log to file, debug mode, remote error messages/notifications
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Handle logging
 *
 * @param  string $msg Log message
 * @return void
 */
function buddyboss_media_log( $msg )
{
  global $buddyboss_media;

  // $buddyboss_media->log[] = $msg;
}

/**
 * Print log at footer
 *
 * @return void
 */
function buddyboss_media_print_log()
{
  ?>
  <div class="buddyboss-media-log">
    <pre>
      <?php print_r( $buddyboss_media->log ); ?>
    </pre>

    <br/><br/>
    <hr/>
  </div>
  <?php
}
// add_action( 'wp_footer', 'buddyboss_media_print_log' );

/**
 * Get the default slug used by buddyboss media component.
 * 
 * @return string
 */
function buddyboss_media_default_component_slug(){
	return 'photos';
}

/**
 * Get the correct slug used by buddyboss media component.
 * The slug is configurable from settings.
 * 
 * @return string
 */
function buddyboss_media_component_slug(){
	return buddyboss_media()->types->photo->slug;
}

/**
 * Checks if the ajax request is made from global media page.
 * 
 * @since 1.1 
 * @return boolean
 */
function buddyboss_media_cookies_is_global_media_page(){
	$is_global_media_page = false;

	if ( defined('DOING_AJAX') && DOING_AJAX && isset( $_REQUEST['cookie'] ) ) {
		$cookies = wp_parse_args( str_replace( '; ', '&', urldecode( $_REQUEST['cookie'] ) ) );
			
		if( $cookies && isset( $cookies['bp-bboss-is-media-page'] ) && $cookies['bp-bboss-is-media-page']=='yes' ){
			$is_global_media_page = true;
		}
	}
	
	return $is_global_media_page;
}

/**
 * Check if buddyboss media listing is being dispalyed.
 * This might be the photos component under user profile or the global media page.
 * 
 * @since 2.0
 * @return boolean
 */
function buddyboss_media_is_media_listing(){
	$is_media_listing = false;
	if( 
			buddyboss_media_cookies_is_global_media_page() || 
			( buddyboss_media()->option('all-media-page') && is_page( buddyboss_media()->option('all-media-page') ) ) ||
			( bp_is_user() && bp_is_current_component( buddyboss_media_component_slug() ) )
			|| ( bp_is_group() &&  ( bbm_is_group_media_screen( 'uploads' ) || bbm_is_group_media_screen( 'albums' ) ) )
		){
		$is_media_listing = true;
	}
	return $is_media_listing;
}

/*
 * @todo: make the sql filterable, e.g: to add custom conditions
 */
function buddyboss_media_screen_content_pages_sql( $sql ){
	/*
	 * $pages_sql = "SELECT COUNT(*) FROM $activity_table a
                INNER JOIN $activity_meta_table am ON a.id = am.activity_id
                LEFT JOIN (SELECT id FROM $groups_table WHERE status != 'public' ) grp ON a.item_id = grp.id
                WHERE a.user_id = $user_id
                AND (am.meta_key = 'buddyboss_media_aid' OR am.meta_key = 'buddyboss_pics_aid' OR am.meta_key = 'bboss_pics_aid')
                AND (a.component != 'groups' || a.item_id != grp.id)";
	 */
	$activity_table = bp_core_get_table_prefix() . 'bp_activity';
	$activity_meta_table = bp_core_get_table_prefix() . 'bp_activity_meta';
	$groups_table = bp_core_get_table_prefix() . 'bp_groups';
	
	return "SELECT COUNT(*) FROM $activity_table a
                INNER JOIN $activity_meta_table am ON a.id = am.activity_id
                LEFT JOIN (SELECT id FROM $groups_table WHERE status != 'public' ) grp ON a.item_id = grp.id
                WHERE 1=1 
                AND (am.meta_key = 'buddyboss_media_aid' OR am.meta_key = 'buddyboss_pics_aid' OR am.meta_key = 'bboss_pics_aid')
                AND (a.component != 'groups' || a.item_id != grp.id)";
}

/*
 * @todo: make the sql filterable, e.g: to perform custom orderby queries
 */
function buddyboss_media_screen_content_sql( $sql ){
	/*
		$sql = "SELECT a.*, am.meta_value FROM $activity_table a
          INNER JOIN $activity_meta_table am ON a.id = am.activity_id
          LEFT JOIN (SELECT id FROM $groups_table WHERE status != 'public' ) grp ON a.item_id = grp.id
          WHERE a.user_id = $user_id
          AND (am.meta_key = 'buddyboss_media_aid' OR am.meta_key = 'buddyboss_pics_aid' OR am.meta_key = 'bboss_pics_aid')
          AND (a.component != 'groups' || a.item_id != grp.id)
          ORDER BY a.date_recorded DESC";
	 */
	$activity_table = bp_core_get_table_prefix() . 'bp_activity';
	$activity_meta_table = bp_core_get_table_prefix() . 'bp_activity_meta';
	$groups_table = bp_core_get_table_prefix() . 'bp_groups';
	
	return "SELECT a.*, am.meta_value FROM $activity_table a
          INNER JOIN $activity_meta_table am ON a.id = am.activity_id
          LEFT JOIN (SELECT id FROM $groups_table WHERE status != 'public' ) grp ON a.item_id = grp.id
          WHERE 1=1 
          AND (am.meta_key = 'buddyboss_media_aid' OR am.meta_key = 'buddyboss_pics_aid' OR am.meta_key = 'bboss_pics_aid')
          AND (a.component != 'groups' || a.item_id != grp.id)
          ORDER BY a.date_recorded DESC";
}

//Update buddyboss_media table
function bbm_update_media_table( $attachment_id, $media_title, $activity_id, $media_privacy  ) {

	global $wpdb;

	$wpdb->insert(
			$wpdb->prefix . 'buddyboss_media', array(
				'blog_id' => get_current_blog_id(),
				'media_id' => $attachment_id,
				'media_author' => get_current_user_id(),
				'media_title' => $media_title,
				'activity_id' => $activity_id,
				'privacy' => $media_privacy,
				'upload_date' => current_time( 'mysql' ),
			),
			array(
				'%d',
				'%d',
				'%d',
				'%s',
				'%d',
				'%s',
				'%d',
			)
	);
}

/**
 * Delete media before an activity item proceeds to be deleted.
 * @param $args
 */
function bbm_delete_row_media_table( $args ) {
	
	global $wpdb;
	
	$activity_ids = (array)$args['id'];
	if( empty( $activity_ids ) ){
		return;
	}
	
	foreach ( $activity_ids as $activity_id ) {

		//Check delete media marked yes
		$delete_media_permanently = buddyboss_media()->option( 'delete_media_permanently' );

		if ( 'yes' == $delete_media_permanently ) {

			$activities    = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->base_prefix}bp_activity WHERE id = %d", $activity_id ) );
			$act_obj       = $activities;
			$type          = array( 'bbp_topic_edit', 'bbp_topic_create', 'bbp_reply_edit', 'bbp_reply_create' );

			//Verify we are not deleting media if it has bbpress topic and reply associated with it
			if ( isset( $act_obj ) && in_array( $act_obj->type, $type ) ) {

				//Select post_id of bbpress reply or topic
				if ( 'bbpress' === $act_obj->component ) {
					$post_id = $act_obj->item_id;
				} else {
					$post_id = $act_obj->secondary_item_id;
				}

				//Skip permanent delete if it has bbpress topic or reply
				$post = get_post( $post_id );
				if ( ! empty( $post ) ) {
					continue;
				}
			}

			//Delete all media attached in activity
			$activity_media_ids 	= buddyboss_media_compat_get_meta( $activity_id, 'activity.item_keys' );
			if ( ! empty( $activity_media_ids ) && is_array( $activity_media_ids ) ) {
				foreach ( $activity_media_ids as $key => $attachment_id ) {
					wp_delete_attachment( $attachment_id );
				}
			}
		}

		//Delete entry from buddyboss_media table
		$wpdb->delete( $wpdb->prefix . 'buddyboss_media', array( 'activity_id' => $activity_id ), array( '%d' ) );
	}
	
}

add_action('bp_before_activity_delete','bbm_delete_row_media_table');


/**
 * Generate hyperlink text for media in content
 * @param $attachment_ids
 * @return mixed|void
 */
function bbm_generate_media_activity_content( $attachment_ids ) {

	$media_html = '';

	foreach( $attachment_ids as $attachment_id ) {

		$media_src	= current( wp_get_attachment_image_src( $attachment_id, 'full' ) );
		$media_title = get_post_field( 'post_title', $attachment_id );

		$_POST['pics_uploaded'][] = array(
			'status' 		=> 'true',
			'attachment_id' => $attachment_id,
			'url'			=> $media_src,
			'name'			=> $media_title,
		);

		$media_html .= "<a href=\"{$media_src}\" title=\"{$media_title}\" class=\"buddyboss-media-photo-link\">{$media_title}</a>";
	}

	return apply_filters( 'bbm_generate_media_activity_content', $media_html );
}

/**
 * Return all media ids by activity
 * @param $act_id
 * @return mixed|void
 */
function bbm_get_activity_media( $act_id ) {
	global $wpdb;

	$activity_media_query 	= "SELECT media_id FROM {$wpdb->base_prefix}buddyboss_media WHERE activity_id = {$act_id}";
	$media_ids 				= $wpdb->get_col( $activity_media_query );

	return apply_filters( 'bbm_get_activity_media', $media_ids );
}
?>