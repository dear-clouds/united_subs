<?php
/**
 * @package WordPress
 * @subpackage BuddyBoss Wall
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists( 'BuddyBoss_Wall_Like_Notification' ) ):

class BuddyBoss_Wall_Like_Notification {

	private static $instance;
	private $component_action	= 'buddyboss_wall_like_notifier';

	public static function get_instance() {
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		$this->load();
	}
	
	protected function load() {

		add_action( 'bp_setup_globals',                 array( $this, 'wall_notifier_setup_globals' ) );
		add_action( 'bp_activity_add_user_favorite',    array( $this, 'add_like_notification' ), 10, 2 );
		add_action( 'bp_activity_remove_user_favorite', array( $this, 'remove_like_notification' ), 999, 2 );
		add_action( 'bp_loaded',                        array( $this, 'clear_link_notifications' ) );
	}

	public function wall_notifier_setup_globals() {

		global $bp;
		$bp->buddyboss_wall_like_notifier							 = new stdClass();
		$bp->buddyboss_wall_like_notifier->id						 = 'buddyboss_wall_like_notifier';//I asume others are not going to use this is
		$bp->buddyboss_wall_like_notifier->slug					     = 'buddyboss_wall_like_notification';
		$bp->buddyboss_wall_like_notifier->notification_callback	 = 'buddyboss_wall_like_notifier_format_notifications';//show the notification
		/* Register this in the active components array */
		$bp->active_components[$bp->buddyboss_wall_like_notifier->id] = $bp->buddyboss_wall_like_notifier->id;
	}

	/**
	 * @param $action
	 * @param $item_id
	 * @param $secondary_item_id
	 * @param $total_items
	 * @param string $format
	 * @return array|bool
	 */
	public function format_bp_notifications( $action, $item_id, $secondary_item_id, $total_items, $format='string' ) {

		//Add ?new-wall-like flag so we can mark it read when user click on notification link
		$activity_permalink = add_query_arg( array( 'new-wall-like' => $item_id ), bp_activity_get_permalink( $item_id ) );

		$activities     = bp_activity_get_specific( array( 'activity_ids' => $item_id ) );

		if ( empty( $activities['activities'] ) ) {
			return;
		}

		$activity       = $activities['activities'][0];

		if ( ! empty( $activity->content ) ) {
			$activity_content = mb_strimwidth( strip_tags( $activity->content ), 0, 25, '...');
		} else {
			$activity_content = mb_strimwidth( strip_tags( $activity->action ), 0, 25, '...');
		}


		$count = (int) bp_activity_get_meta( $item_id, 'favorite_count' );

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

		// Check if user likes this
		if ( $user_logged_in )
		{
			$user_id = intval( bp_loggedin_user_id() );

			$favorite_activity_entries = bp_get_user_meta( $user_id, 'bp_favorite_activities', true );

			// Check if logged in user likes this as well
			if ( !empty( $favorite_activity_entries ) && in_array( $item_id, $favorite_activity_entries ) )
			{
				$user_likes_this = true;
			}
		}

		// If user isn't logged we show simple like html
		if ( ! $user_logged_in )
		{
			$like_txt = sprintf( __( '%s %s %s %s.', 'buddyboss-wall' ), $count_txt, $subject, $verb, $activity_content );
		}

		// If user is logged in, show names and tooltip
		else {
			$users_who_liked = buddyboss_wall_get_users_who_liked( $item_id );
			//if( !$users_who_liked && $refetch_users_who_liked ){
			if( !$users_who_liked ){
				$users_who_liked = buddyboss_wall_refetch_users_who_liked( $item_id );
			}

			if( !$user_likes_this && ( !$users_who_liked || empty( $users_who_liked ) ) ){
				//can occur if user who liked is deleted
				return false;
			}

			$like_txt = $count . ( $user_likes_this ? 'y' : 'n' );


			if ( empty($activity_like_text) ) {
				$activity_like_text = 'yes'; //Fix for fresh install
			}

			// Only user likes this
			if ( $count === 1 && $user_likes_this  )
			{
				$like_txt = sprintf( __( 'You like %s.', 'buddyboss-wall' ), $activity_content );
			}
			// Show up to two user names (you + 2 others)
			else {
				$liked_for_display = array();
				$liked_for_tooltip = array();

				$current = 0;

				foreach( $users_who_liked as $user )
				{
					$user_liked_html =  $user['name'];

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
				if ( count( $liked_for_display ) === 1 ) {
					if ( $user_likes_this  )
					{
						$like_txt = sprintf( __( 'You and %s %s %s.', 'buddyboss-wall' ), $liked_for_display[0], $verb_plural, $activity_content );
					} else {
						$like_txt = sprintf( __( '%s %s %s.', 'buddyboss-wall' ), $liked_for_display[0], $verb_single, $activity_content );
					}
				}

				// 2 users + no others
				else if ( count( $liked_for_display ) === 2 && $others === 0 )
				{
					if ( $user_likes_this )
					{
						$like_txt = sprintf( __( 'You, %s and %s %s %s.', 'buddyboss-wall' ), $liked_for_display[0], $liked_for_display[1], $verb_plural, $activity_content );
					}
					else {
						$like_txt = sprintf( __( '%s and %s %s %s.', 'buddyboss-wall' ), $liked_for_display[0], $liked_for_display[1], $verb_plural, $activity_content );
					}
				}

				// 2 users + others
				else if ( count( $liked_for_display ) === 2 && $others > 0 )
				{
					$subject = $others === 1 ? $subject_single : $subject_plural;
					$verb = $others === 1 ? $verb_single : $verb_plural;

					$others_count_txt = number_format_i18n( $others );
					$others_i18n = sprintf( __( '%s other %s', 'buddyboss-wall' ), $others_count_txt, $subject );
					$others_txt = $others_i18n ;

					if ( $user_likes_this )
					{
						$like_txt = sprintf( __( 'You, %s, %s and %s %s %s.', 'buddyboss-wall' ), $liked_for_display[0], $liked_for_display[1], $others_txt, $verb_plural, $activity_content );
					}
					else {
						$like_txt = sprintf( __( '%s, %s and %s %s %s.', 'buddyboss-wall' ), $liked_for_display[0], $liked_for_display[1], $others_txt, $verb_plural, $activity_content );
					}
				}
			}
		}

		return array('link'=> $activity_permalink,
			'text'=> $like_txt );

	}

	/**
	 * Add new notification for like
	 * @param $activity_id
	 * @param $user_id
	 */
	public function add_like_notification( $activity_id, $user_id ) {
		$activities  = bp_activity_get_specific( array( 'activity_ids' => $activity_id ) );
		$activity   = $activities['activities'][0];

		//Add new notification
		bp_notifications_add_notification(
			array(
				'user_id'           => $activity->user_id,
				'item_id'           => $activity_id,
				'secondary_item_id'	=> '',
				'component_name'    => $this->component_action,
				'component_action'  => 'new_wall_post_like_'.$activity_id,
			)
		);
	}

	/**
	 * Remove notification after unlike
	 * @param $activity_id
	 * @param $user_id
	 */
	public function remove_like_notification( $activity_id, $user_id ) {
		$activities  = bp_activity_get_specific( array( 'activity_ids' => $activity_id ) );
		$activity   = $activities['activities'][0];
		$count = (int) bp_activity_get_meta( $activity_id, 'favorite_count' );

		//Delete notification after 0 likes count
		if ( empty( $count ) ) {
			bp_notifications_delete_notifications_by_item_id(
				$activity->user_id,
				$activity_id,
				$this->component_action,
				'new_wall_post_like_'.$activity_id
			);
		}
	}

	/**
	 * Clear activity-like-related notifications when ?new=1
	 */
	public function clear_link_notifications() {
		global $wpdb;

		if ( isset( $_GET['new-wall-like'] ) && bp_is_active( 'notifications' ) ) {

			$sql = $wpdb->prepare("UPDATE {$wpdb->base_prefix}bp_notifications SET is_new = 0 WHERE component_name = %s AND component_action = %s", $this->component_action, 'new_wall_post_like_'. $_GET['new-wall-like'] );
			$wpdb->query( $sql );
		}
	}
	
}// end BuddyBoss_Wall_Like_Notification


//Do not initiate if the Wall Component is not enabled
$wall_options = get_option('buddyboss_wall_plugin_options');

if ( ! isset( $wall_options['enabled'] )
     || 'on' === $wall_options['enabled'] ) {
	BuddyBoss_Wall_Like_Notification::get_instance();
}

endif;