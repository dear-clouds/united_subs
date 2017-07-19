<?php

/**
 * Notifier component
 */
class BP_Badge_Notifier extends BP_Component {

	/**
	 * Forum notifier component setup. Creates component object
	 * and inserts it in buddpress.
	 */
	static public function __setup() {
		global $bp;
		$bp->badge_notifier = new BP_Badge_Notifier();
	}

	/**
	 * Start the notifier component creation process
	 */
	public function __construct() {
		parent::start(
			'badge_notifier',
			__( 'Badge Notifier', 'bp_badge_notifier' ),
			BP_PLUGIN_DIR
		);

		/**
		 * Actions and filters for notification adding and deleting
		 */
		add_action( 'badgeos_award_achievement', array( &$this, 'add_badge_notification' ), 10, 2 );
		add_action( 'badgeos_revoke_achievement', array( &$this, 'delete_badge_notification' ), 10, 2 );
	}

	/**
	 * Setting up buddypress component properties
	 * This is an override
	 * @return void
	 */
	public function setup_globals() {
		if ( ! defined( 'BP_BADGE_NOTIFIER_SLUG' ) ) {
			define( 'BP_BADGE_NOTIFIER_SLUG', $this->id );
		}

		$globals = array(
			'slug' => BP_BADGE_NOTIFIER_SLUG,
			'has_directory' => false,
			'notification_callback' => 'bp_badge_notifier_messages_format'
		);

		parent::setup_globals( $globals );
	}

	/**
	 * Adds newly awarded badge notifications
	 * @param int $user_id
	 * @param int $achievement_id
	 * @return bool
	 */
	public function add_badge_notification( $user_id, $achievement_id ) {
		
		if ( ! $user_id || ! $achievement_id )
			return false;
		
		$post = get_post( $achievement_id );
		$type = $post->post_type;
		
		// Don't make activity posts for step post type
		if ( 'step' == $type ) {
			return false;
		}
		
		bp_core_add_notification( $achievement_id, $user_id, $this->id, 'new_badge_' . $user_id . "_" . $achievement_id  );
	}
	
	/**
	 * Delete revoked badge notification
	 * @param int $user_id
	 * @param int $achievement_id
	 * @return void
	 */
	public function delete_badge_notification( $user_id, $achievement_id  ) {
		bp_core_delete_notifications_by_type( $user_id, $this->id, 'new_badge_' . $user_id . "_" . $achievement_id );
	}

}

/**
 * Formats notification messages. Used as a callback by buddypress
 * @param string $action usually new_[topic|reply|quote]_[ID]
 * @param int $item_id the achievement_id usually
 * @param int $secondary_item_id 
 * @param int $total_items
 * @param string $format string, array or object
 * @return array formatted messages
 */
function bp_badge_notifier_messages_format( $action, $item_id, $secondary_item_id, $total_items, $format = 'string' ) {
	$blogname = get_option( 'blogname' );
	
	switch( substr( $action, 4, 5 ) ) {
		case 'badge':
			$post = get_post( $item_id );
			$title = $post->post_title;
			$link = $post->guid;
			$text = "New Badge - " . $title;
			break;
		default:
			return false;
	}

	switch( $format ) {
		case 'string':
			$return = sprintf(
				'<a href="%s" title="%s">%s</a>',
				$link,
				esc_attr( $text ),
				$text
			);
			break;

		default:
			$return = array(
				'text' => $text,
				'link' => $link
			);
	}

	return $return;
}
