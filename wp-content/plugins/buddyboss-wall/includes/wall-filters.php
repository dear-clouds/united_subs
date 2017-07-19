<?php
/**
 * @package WordPress
 * @subpackage BuddyBoss Wall
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

function buddyboss_wall_gettext_filter( $translated_text, $text, $domain )
{
    $excluded_textdomains = array( 'bbpress' );
    if( in_array( $domain, $excluded_textdomains ) )
        return $translated_text;
    
  if ( $text === 'Favorite' )
  {
    $translated_text = __( 'Like', 'buddyboss-wall' );
  }
  else if ( $text === 'Remove Favorite' )
  {
    $translated_text = __( 'Unlike', 'buddyboss-wall' );
  }
  else if ( $text === 'Mark as Favorite' )
  {
	  $translated_text = __( 'Like this', 'buddyboss-wall' );
  }
  else if ( $text === "The activity I've marked as a favorite." )
  {
    $translated_text = __( "The activity I've liked.", 'buddyboss-wall' );
  }
  else if ( $text === "My Favorites <span>%s</span>" )
  {
    $translated_text = __( 'My Likes <span>%s</span>', 'buddyboss-wall' );
  }

  return $translated_text;
}
add_filter( 'gettext', 'buddyboss_wall_gettext_filter', 10000, 3 );


?>
