<?php
/*
Plugin Name: bbPress Admin Answers
Description: The plugin allows you to isolate the answers of the administration or moderators of a particular color, plugin adding a checkbox to the form of the answer.
Version: 2.0.1
Author: Daniel 4000
Author URI: http://vk.com/daniluk4000
Contributors: daniluk4000
Text Domain: bbp_admin_topics
Domain Path: languages
*/
require_once 'replies.php';
class BBP_Admin_Topics {

	/*--------------------------------------------*
	 * Constructor
	 *--------------------------------------------*/

	/**
	 * Initializes the plugin by setting localization, filters, and administration functions.
	 */
	function __construct() {

		// load the plugin translation files
		add_action( 'init', array( $this, 'textdomain' ) );

		// show the "Private Reply?" checkbox
		add_action( 'bbp_theme_before_topic_form_submit_wrapper', array( $this, 'checkbox' ) );

		// save the private reply state
		add_action( 'bbp_new_topic',  array( $this, 'update_topic' ), 0, 6 );
		add_action( 'bbp_edit_topic',  array( $this, 'update_topic' ), 0, 6 );

		add_action( 'bbp_new_reply',  array( $this, 'update_reply' ), 0, 6 );
		add_action( 'bbp_edit_reply',  array( $this, 'update_reply' ), 0, 6 );

		// hide reply content
		add_filter( 'bbp_get_topic_excerpt', array( $this, 'hide_topic' ), 999, 2 );
		add_filter( 'bbp_get_topic_content', array( $this, 'hide_topic' ), 999, 2 );
		add_filter( 'the_content', array( $this, 'hide_topic' ), 999 );
		add_filter( 'the_excerpt', array( $this, 'hide_topic' ), 999 );

		add_filter( 'bbp_get_reply_excerpt', array( $this, 'hide_reply' ), 999, 2 );
		add_filter( 'bbp_get_reply_content', array( $this, 'hide_reply' ), 999, 2 );
		add_filter( 'the_content', array( $this, 'hide_reply' ), 999 );
		add_filter( 'the_excerpt', array( $this, 'hide_reply' ), 999 );

		// add a class name indicating the read status


		add_filter( 'post_class', array( $this, 'reply_post_class' ) );
		add_filter( 'post_class', array( $this, 'topic_post_class' ) );

		// register css files
		add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_styles' ) );
	} // end constructor


	/**
	 * Load the plugin's text domain
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	public function textdomain() {
		load_plugin_textdomain( 'bbp_admin_topics', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}


	/**
	 * Outputs the "Set as private reply" checkbox
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	public function checkbox() {

?>
		<p>

			<?php if ( current_user_can('moderate') ) : ?>
			<input name="bbp_admin_topic" id="bbp_admin_topic" type="checkbox"<?php checked( '1', $this->is_private( bbp_get_topic_id() ) ); ?> value="1" tabindex="<?php bbp_tab_index(); ?>" />
			<?php endif; ?>

			<?php if ( current_user_can('moderate') ) : ?>

				<label for="bbp_admin_topic"><?php _e( 'This topic of a moderator/admin', 'bbp_admin_topics' ); ?></label>
				<label for="bbp_admin_topic"><?php _e( '', 'bbp_admin_topics' ); ?></label>

			<?php endif; ?>

		</p>
<?php

	}


	/**
	 * Stores the private state on reply creation and edit
	 *
	 * @since 1.0
	 *
	 * @param $reply_id int The ID of the reply
	 * @param $topic_id int The ID of the topic the reply belongs to
	 * @param $forum_id int The ID of the forum the topic belongs to
	 * @param $anonymous_data bool Are we posting as an anonymous user?
	 * @param $author_id int The ID of user creating the reply, or the ID of the replie's author during edit
	 * @param $is_edit bool Are we editing a reply?
	 *
	 * @return void
	 */
	public function update_topic( $topic_id = 0, $forum_id = 0, $anonymous_data = false, $author_id = 0, $is_edit = false ) {

		if( isset( $_POST['bbp_admin_topic'] ) )
			update_post_meta( $topic_id, '_bbp_topic_is_admin', '1' );
		else
			delete_post_meta( $topic_id, '_bbp_topic_is_admin' );

	}

	public function update_reply( $reply_id = 0, $topic_id = 0, $forum_id = 0, $anonymous_data = false, $author_id = 0, $is_edit = false ) {

		if( isset( $_POST['bbp_admin_reply'] ) )
			update_post_meta( $reply_id, '_bbp_reply_is_admin', '1' );
		else
			delete_post_meta( $reply_id, '_bbp_reply_is_admin' );

	}


	/**
	 * Determines if a reply is marked as admin
	 *
	 * @since 1.0
	 *
	 * @param $reply_id int The ID of the reply
	 *
	 * @return bool
	 */
	public function is_private( $topic_id = 0, $reply_id = 0 ) {

		$retval 	= false;

		// Checking a specific reply id
		if ( !empty( $topic_id ) ) {
			$topic     = bbp_get_topic( $topic_id );
			$topic_id = !empty( $topic ) ? $topic->ID : 0;

		// Using the global reply id
		} elseif ( bbp_get_topic_id() ) {
			$topic_id = bbp_get_topic_id();

		// Use the current post id
		} elseif ( !bbp_get_topic_id() ) {
			$topic_id = get_the_ID();
		}

		if ( ! empty( $topic_id ) ) {
			$retval = get_post_meta( $topic_id, '_bbp_topic_is_admin', true );
		}

		return (bool) apply_filters( 'bbp_topic_is_admin', (bool) $retval, $topic_id );

		// Checking a specific reply id
		if ( !empty( $reply_id ) ) {
			$reply     = bbp_get_reply( $reply_id );
			$reply_id = !empty( $reply ) ? $reply->ID : 0;

		// Using the global reply id
		} elseif ( bbp_get_reply_id() ) {
			$reply_id = bbp_get_reply_id();

		// Use the current post id
		} elseif ( !bbp_get_reply_id() ) {
			$reply_id = get_the_ID();
		}

		if ( ! empty( $reply_id ) ) {
			$retval = get_post_meta( $reply_id, '_bbp_reply_is_private', true );
		}

		return (bool) apply_filters( 'bbp_reply_is_admin', (bool) $retval, $reply_id );
	}

	/**
	 * Hides the reply content for users that do not have permission to view it
	 *
	 * @since 1.0
	 *
	 * @param $content string The content of the reply
	 * @param $reply_id int The ID of the reply
	 *
	 * @return string
	 */
	public function hide_topic( $content = '', $topic_id = 0 ) {

		if( empty( $topic_id ) )
			$topic_id = bbp_get_topic_id( $topic_id );

		if( $this->is_private( $topic_id ) ) {

			$can_view     = true;
			$current_user = is_user_logged_in() ? wp_get_current_user() : true;
			$topic_author = bbp_get_topic_author_id( $topic_id );

			if( $topic_author === $current_user->ID && user_can( $topic_author, 'moderate' ) ) {
				// Let the thread author view replies if the reply author is from a moderator
				$can_view = true;
			}

			if( $topic_author === $current_user->ID ) {
				// Let the reply author view their own reply
				$can_view = true;
			}

			if( current_user_can( 'moderate' ) ) {
				// Let moderators view all replies
				$can_view = true;
			}
		}

		return $content;
	}

	public function hide_reply( $content = '', $reply_id = 0 ) {

		if( empty( $reply_id ) )
			$reply_id = bbp_get_reply_id( $reply_id );

		if( $this->is_private( $reply_id ) ) {

			$can_view     = true;
			$current_user = is_user_logged_in() ? wp_get_current_user() : true;
			$topic_author = bbp_get_topic_author_id();
			$reply_author = bbp_get_reply_author_id( $reply_id );

			if( $topic_author === $current_user->ID && user_can( $reply_author, 'moderate' ) ) {
				// Let the thread author view replies if the reply author is from a moderator
				$can_view = true;
			}

			if( $reply_author === $current_user->ID ) {
				// Let the reply author view their own reply
				$can_view = true;
			}

			if( current_user_can( 'moderate' ) ) {
				// Let moderators view all replies
				$can_view = true;
			}

			if( ! $can_view ) {
				$content = __( 'This reply has been marked as private.', 'bbp_admin_replies' );
			}
		}

		return $content;
	}




	/**
	 * Adds a new class to replies that are marked as admin
	 *
	 * @since 1.0
	 *
	 * @param $classes array An array of current class names
	 *
	 * @return bool
	 */


	function reply_post_class( $classes ) {

		$reply_id = bbp_get_reply_id();

		// only apply the class to replies
		if( bbp_get_reply_post_type() != get_post_type( $reply_id ) )
			return $classes;

		if( $this->is_private( $reply_id ) )
			$classes[] = 'bbp-admin-reply';

		return $classes;
	}


	function topic_post_class( $classes ) {

		$topic_id = bbp_get_topic_id();

		// only apply the class to replies
		if( bbp_get_topic_post_type() != get_post_type( $topic_id ) )
			return $classes;

		if( $this->is_private( $topic_id ) )
			$classes[] = 'bbp-admin-topic';

		return $classes;
	}


	/**
	 * Load the plugin's CSS files
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	function register_plugin_styles() {
		$css_path = plugin_dir_path( __FILE__ ) . '/css/style-topics.css';
	    wp_enqueue_style( 'bbp_admin_topics_style', plugin_dir_url( __FILE__ ) . '/css/style-topics.css', filemtime( $css_path ) );
	}

} // end class

// instantiate our plugin's class
$GLOBALS['bbp_admin_topics'] = new BBP_Admin_Topics();