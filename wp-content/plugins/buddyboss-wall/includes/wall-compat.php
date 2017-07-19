<?php
/**
 * Backwards compatiblity & deprecated functions.
 *
 * @package WordPress
 * @subpackage BuddyBoss Wall
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


function buddyboss_wall_compat( $key )
{
	// switch( $key ) {
	// 	// Activity meta keys are used to identify a BuddyBoss Wall entry
	// 	// in the activity meta table. We used to use 'bboss_pics_aid' and
	// 	// 'buddyboss_pics_aid', and have settled on 'buddyboss_wall_aid'
	// 	case 'activity.item_keys':
	// 	return array( 'buddyboss_wall_aid', 'buddyboss_pics_aid', 'bboss_pics_aid' );

	// 	// Return most recent item key
	// 	case 'activity.item_key':
	// 	$key = buddyboss_wall_compat( 'activity.item_keys' );
	// 	return $key[0];

	// 	// Activity meta keys are used to identify a BuddyBoss Wall entry
	// 	// in the activity meta table. We used to use 'bboss_pics_action' and
	// 	// 'buddyboss_pics_action', and have settled on 'buddyboss_wall_action'
	// 	case 'activity.action_keys':
	// 	return array( 'buddyboss_wall_action', 'buddyboss_pics_action', 'bboss_pics_action' );

	// 	// Return most recent action key
	// 	case 'activity.action_key':
	// 	$key = buddyboss_wall_compat( 'activity.action_keys' );
	// 	return $key[0];
	// }
}

function buddyboss_wall_compat_get_meta( $activity_id, $type )
{
	// $keys = buddyboss_wall_compat( $type );

	// $result = false;

	// foreach( $keys as $key )
	// {
	// 	$result = bp_activity_get_meta( $activity_id, $key );

	// 	if ( $result ) break;
	// }

	// return $result;
}


/**
 * Functions from when this plugin was packaged inside a theme:
 * ============================================================
 */
if ( ! function_exists( 'buddyboss_is_my_friend') ):

function buddyboss_is_my_friend( $id = null )
{
	return buddyboss_wall_is_my_friend( $id );
}

endif;
?>