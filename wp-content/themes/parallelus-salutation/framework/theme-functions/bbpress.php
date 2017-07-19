<?php

#-----------------------------------------------------------------
# bbPress Forums Related Functions
#-----------------------------------------------------------------


// Add support - tells bbPress the theme has templates and own styles
//................................................................

add_theme_support('bbpress'); 



// Include bbPress JS and CSS functions
//................................................................

// bbPress CSS files. These provide the base styles, theme specific styling in main theme CSS and skin specific CSS files.
if ( is_rtl() ) {
	theme_register_css( 'bbPress-rtl', $cssPath.'bbpress-rtl.css', 1 );	// bbPress base styles (RTL)
} else {
	theme_register_css( 'bbPress', $cssPath.'bbpress.css', 1 );			// bbPress base styles
}

// bbPress scripts
if ( bbp_is_single_topic() ) wp_enqueue_script( 'bbp_topic', $jsPath.'bbPress-topic.js', array( 'wp-lists' ), '20110921' );
if ( bbp_is_single_user_edit() ) wp_enqueue_script( 'user-profile' );



// bbPress - Enqueue theme script localization
//................................................................



// bbPress - Output some extra JS in the <head>
//................................................................

if ( ! function_exists( 'bbPress_head_scripts' ) ) :
	function bbPress_head_scripts() {
		// Put some scripts in the header, like AJAX url for wp-lists
		
		if ( bbp_is_single_topic() ) : ?>
	
		<script type='text/javascript'>
			/* <![CDATA[ */
			var ajaxurl = '<?php echo admin_url( 'admin-ajax.php' ); ?>';
			/* ]]> */
		</script>
	
		<?php elseif ( bbp_is_single_user_edit() ) : ?>
	
		<script type="text/javascript" charset="utf-8">
			if ( window.location.hash == '#password' ) {
				document.getElementById('pass1').focus();
			}
		</script>
	
		<?php
		endif;
	}
	
	add_action( 'bbp_head', 'bbPress_head_scripts' );
endif;



// bbPress - Handles the ajax favorite/unfavorite
//................................................................

if ( ! function_exists( 'bbPress_ajax_favorite' ) ) :
	function bbPress_ajax_favorite() {
		$user_id = bbp_get_current_user_id();
		$id      = intval( $_POST['id'] );
	
		if ( !current_user_can( 'edit_user', $user_id ) )
			die( '-1' );
	
		if ( !$topic = bbp_get_topic( $id ) )
			die( '0' );
	
		check_ajax_referer( 'toggle-favorite_' . $topic->ID );
	
		if ( bbp_is_user_favorite( $user_id, $topic->ID ) ) {
			if ( bbp_remove_user_favorite( $user_id, $topic->ID ) ) {
				die( '1' );
			}
		} else {
			if ( bbp_add_user_favorite( $user_id, $topic->ID ) ) {
				die( '1' );
			}
		}
	
		die( '0' );
	}
		
	add_action( 'wp_ajax_dim-favorite', 'bbPress_ajax_favorite' );
endif;



// bbPress - Handles the ajax subscribe/unsubscribe
//................................................................

if ( ! function_exists( 'bbPress_ajax_subscription' ) ) :
	function bbPress_ajax_subscription() {
		if ( !bbp_is_subscriptions_active() )
			return;
	
		$user_id = bbp_get_current_user_id();
		$id      = intval( $_POST['id'] );
	
		if ( !current_user_can( 'edit_user', $user_id ) )
			die( '-1' );
	
		if ( !$topic = bbp_get_topic( $id ) )
			die( '0' );
	
		check_ajax_referer( 'toggle-subscription_' . $topic->ID );
	
		if ( bbp_is_user_subscribed( $user_id, $topic->ID ) ) {
			if ( bbp_remove_user_subscription( $user_id, $topic->ID ) ) {
				die( '1' );
			}
		} else {
			if ( bbp_add_user_subscription( $user_id, $topic->ID ) ) {
				die( '1' );
			}
		}
	
		die( '0' );
	}
		
	add_action( 'wp_ajax_dim-subscription', 'bbPress_ajax_subscription' );
endif;



// bbPress Shortcodes - helper to apply wrappers and styling
//................................................................

// array of all possible bbPress shortcodes
$bbPress_shortcodeList = array (
	'bbp-forum-index',
	'bbp-single-forum',
	'bbp-topic-index',
	'bbp-topic-form',
	'bbp-single-topic',
	'bbp-topic-tags',
	'bbp-single-topic-tag',
	'bbp-reply-form',
	'bbp-single-view',
	'bbp-login',
	'bbp-register',
	'bbp-lost-pass'
);

// Check for bbPress shortcode and wrap content in default bbPress (and theme bbPress) containers so CSS styling is applied properly
if ( ! function_exists( 'bbpress_shortcode_content_wrap' ) ) :
	function bbpress_shortcode_content_wrap($content) {
		global $bbPress_shortcodeList;
		
		// get all shortcodes in $content
		$pattern = get_shortcode_regex();
		preg_match_all( '/'. $pattern .'/s', $content, $matches );
		
		// Make sure the CURRENT content section has a bbPress shortcodes included.
		if ( is_array( $matches ) && array_key_exists( 2, $matches ) ) {
			foreach ($bbPress_shortcodeList as $shortcode) { 
				if ( in_array($shortcode, $matches[2]) ) {
				//if ( strpos($content, $shortcode)  ) { 
					// bbPress shortcode used for this specific content section
					// $content = '<div id="bbPress-Container"><div id="bbPress-Content" role="main"><div id="container"><div id="content" role="main">'. $content .'</div></div></div></div><div class="clear"></div>';
					$content = '<div id="container"><div id="content" role="main">'. $content .'</div></div><div class="clear"></div>';
					break;
				}
			}
		}
		
		return $content; 
	}
	add_filter('the_content', 'bbpress_shortcode_content_wrap', 1);
endif;

?>