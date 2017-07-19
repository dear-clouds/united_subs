<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Localization Support
load_theme_textdomain( 'OneCommunity', get_template_directory().'/lang' );

$locale = get_locale();
$locale_file = get_template_directory()."/lang/$locale.php";
if ( is_readable($locale_file) )
    require_once($locale_file);

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * Used to set the width of images and content. Should be equal to the width the theme
 * is designed for, generally via the style.css stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 591;

if ( ! function_exists( 'bp_dtheme_setup' ) ) :

function theme_setup() {

	// Load the AJAX functions for the theme
	require( get_template_directory() . '/_inc/ajax.php' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// This theme comes with all the BuddyPress goodies
	add_theme_support( 'buddypress' );

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );


	if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'slider-thumbnail', 330, 290, true );
	add_image_size( 'my-thumbnail', 185, 125, true );
	add_image_size( 'tile-1', 240, 290, true );
	add_image_size( 'tile-2', 420, 290, true );
	add_image_size( 'tile-4', 195, 125, true );
	add_image_size( 'tile-5', 240, 200, true );
	add_image_size( 'tile-7', 420, 200, true );
	add_image_size( 'tile-8', 195, 200, true );
	}

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

if ( function_exists( 'bp_is_active' ) ) {

	if ( ! is_admin() || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
		// Register buttons for the relevant component templates
		// Friends button
		if ( bp_is_active( 'friends' ) )
			add_action( 'bp_member_header_actions',    'bp_add_friend_button',           5 );

		// Activity button
		if ( bp_is_active( 'activity' ) && bp_activity_do_mentions() )
			add_action( 'bp_member_header_actions',    'bp_send_public_message_button',  20 );

		// Messages button
		if ( bp_is_active( 'messages' ) )
			add_action( 'bp_member_header_actions',    'bp_send_private_message_button', 20 );

		// Group buttons
		if ( bp_is_active( 'groups' ) ) {
			add_action( 'bp_group_header_actions',     'bp_group_join_button',           5 );
			add_action( 'bp_directory_groups_actions', 'bp_group_join_button' );
		}

		// Blog button
		if ( bp_is_active( 'blogs' ) )
			add_action( 'bp_directory_blogs_actions',  'bp_blogs_visit_blog_button' );
	}
}
}
add_action( 'after_setup_theme', 'theme_setup' );
endif;

if ( function_exists( 'bp_is_active' ) ) {

if ( !function_exists( 'bp_dtheme_enqueue_scripts' ) ) :
function bp_dtheme_enqueue_scripts() {

	// Enqueue the global JS - Ajax will not work without it
	wp_enqueue_script( 'dtheme-ajax-js', get_template_directory_uri() . '/_inc/global.js', array( 'jquery' ), bp_get_version() );

	// Add words that we need to use in JS to the end of the page so they can be translated and still used.
	$params = array(

		'my_favs'           => __( 'My Favorites', 'buddypress' ),
		'accepted'          => __( 'Accepted', 'buddypress' ),
		'rejected'          => __( 'Rejected', 'buddypress' ),
		'show_all_comments' => __( 'Show all comments for this thread', 'buddypress' ),
		'show_x_comments'   => __( 'Show all %d comments', 'buddypress' ),
		'show_all'          => __( 'Show all', 'buddypress' ),
		'comments'          => __( 'comments', 'buddypress' ),
		'close'             => __( 'Close', 'buddypress' ),
		'view'              => __( 'View', 'buddypress' ),
		'mark_as_fav'	    => __( 'Favorite', 'buddypress' ),
		'remove_fav'	    => __( 'Remove Favorite', 'buddypress' ),
		'unsaved_changes'   => __( 'Your profile has unsaved changes. If you leave the page, the changes will be lost.', 'buddypress' ),

	);
	wp_localize_script( 'dtheme-ajax-js', 'BP_DTheme', $params );

	// Maybe enqueue comment reply JS
	if ( is_singular() && bp_is_blog_page() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
}

add_action( 'wp_enqueue_scripts', 'bp_dtheme_enqueue_scripts' );
endif;

}

if ( !function_exists( 'theme_enqueue_styles' ) ) :

function theme_enqueue_styles() {

	wp_register_style( 'responsive', get_template_directory_uri() . '/css/responsive.css', array() );
	wp_register_style( 'font', get_template_directory_uri() . '/font/font.css', array() );
	wp_register_style( 'LiveSearch', get_template_directory_uri() . '/css/search.css', array() );
	wp_register_style( 'OneByOne', get_template_directory_uri() . '/slider/onebyone.css', array() );
	wp_register_style( 'OneByOneResponsive', get_template_directory_uri() . '/slider/onebyone-reponsive.css', array() );
	wp_register_style( 'Animate', get_template_directory_uri() . '/slider/animate.min.css', array() );
	wp_register_style( 'ColorScheme', get_template_directory_uri() . '/css/color-scheme-' . of_get_option('color-scheme-select', '0' ) . '.css', array() );
	wp_register_style( 'myStyle', get_template_directory_uri() . '/myStyle.css', array() );

	wp_enqueue_style( 'responsive' );
	wp_enqueue_style( 'font' );
	wp_enqueue_style( 'LiveSearch' );

	if ( is_page_template( 'frontpage2.php' )  or is_page_template( 'frontpage3.php' ) )
	{
	wp_enqueue_style( 'OneByOne' );
	wp_enqueue_style( 'OneByOneResponsive' );
	wp_enqueue_style( 'Animate' );
	}
	wp_enqueue_style( 'ColorScheme' );
	wp_enqueue_style( 'myStyle' );

}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
endif;



if ( !function_exists( 'bp_dtheme_blog_comments' ) ) :
$counter = 0;
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own bp_dtheme_blog_comments(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @param mixed $comment Comment record from database
 * @param array $args Arguments from wp_list_comments() call
 * @param int $depth Comment nesting level
 * @see wp_list_comments()
 * @since 1.2
 */
function bp_dtheme_blog_comments( $comment, $args, $depth ) {
	global $counter; // Make counter variable global so we can use it inside this function.
	$counter++;
	$GLOBALS['comment'] = $comment;


	if ( 'pingback' == $comment->comment_type )
		return false;

	if ( 1 == $depth )
		$avatar_size = 50;
	else
		$avatar_size = 40;
	?>


	<li <?php comment_class(); ?> id="comment-<?php echo $counter; ?>">
	<div class="comment-body" id="comment-body-<?php echo $counter; ?>">

		<div class="comment-avatar-box">
			<div class="avb">
				<a href="<?php echo get_comment_author_url(); ?>" rel="nofollow">
					<?php if ( $comment->user_id ) : ?>
						<?php echo bp_core_fetch_avatar( array( 'item_id' => $comment->user_id, 'width' => $avatar_size, 'height' => $avatar_size, 'email' => $comment->comment_author_email ) ); ?>
					<?php else : ?>
						<?php echo get_avatar( $comment, $avatar_size ); ?>
					<?php endif; ?>
				</a>
			</div>
		</div>

		<div class="comment-content">
			<div class="comment-meta">
				<p>
					<?php
						/* translators: 1: comment author url, 2: comment author name, 3: comment permalink, 4: comment date/timestamp*/
						printf( __( '<a href="%1$s" rel="nofollow">%2$s</a> said on <a href="%3$s"><span class="time-since">%4$s</span></a>', 'OneCommunity' ), get_comment_author_url(), get_comment_author(), get_comment_link(), get_comment_date() );
					?>
				</p>
			</div>

			<div class="comment-entry">
				<?php if ( $comment->comment_approved == '0' ) : ?>
				 	<em class="moderate"><?php _e( 'Your comment is awaiting moderation.', 'OneCommunity' ); ?></em>
				<?php endif; ?>

				<?php comment_text(); ?>
			</div>

			<div class="comment-options">
					<?php if ( comments_open() ) : ?>
						<?php comment_reply_link( array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ); ?>
					<?php endif; ?>

					<?php if ( current_user_can( 'edit_comment', $comment->comment_ID ) ) : ?>
						<?php printf( '<a class="comment-edit-link" href="%1$s" title="%2$s">%3$s</a> ', get_edit_comment_link( $comment->comment_ID ), esc_attr__( 'Edit comment', 'OneCommunity' ), __( 'Edit', 'OneCommunity' ) ); ?>
					<?php endif; ?>

			</div>

		</div><!-- comment-content -->

<div class="comment-counter" id="comment-counter-<?php echo $counter; ?>"><a href="#comment-<?php comment_ID(); ?>"><?php echo $counter; ?></a></div>
<div class="clear"> </div>
	</div><!-- comment-body -->

<?php
}
endif;


if ( !function_exists( 'bp_dtheme_activity_secondary_avatars' ) ) :
/**
 * Add secondary avatar image to this activity stream's record, if supported.
 *
 * @param string $action The text of this activity
 * @param BP_Activity_Activity $activity Activity object
 * @package BuddyPress Theme
 * @return string
 * @since 1.2.6
 */
function bp_dtheme_activity_secondary_avatars( $action, $activity ) {
	switch ( $activity->component ) {
		case 'groups' :
		case 'friends' :
			// Only insert avatar if one exists
			if ( $secondary_avatar = bp_get_activity_secondary_avatar() ) {
				$reverse_content = strrev( $action );
				$position        = strpos( $reverse_content, 'a<' );
				$action          = substr_replace( $action, $secondary_avatar, -$position - 2, 0 );
			}
			break;
	}

	return $action;
}
add_filter( 'bp_get_activity_action_pre_meta', 'bp_dtheme_activity_secondary_avatars', 10, 2 );
endif;

if ( !function_exists( 'bp_dtheme_show_notice' ) ) :
/**
 * Show a notice when the theme is activated - workaround by Ozh (http://old.nabble.com/Activation-hook-exist-for-themes--td25211004.html)
 *
 * @since 1.2
 */
function bp_dtheme_show_notice() {
	global $pagenow;

	// Bail if bp-default theme was not just activated
	if ( empty( $_GET['activated'] ) || ( 'themes.php' != $pagenow ) || !is_admin() )
		return;

	?>

	<div id="message" class="updated fade">
		<p><?php printf( __( 'Theme activated! This theme contains <a href="%s">custom header image</a> support and <a href="%s">sidebar widgets</a>.', 'buddypress' ), admin_url( 'themes.php?page=custom-header' ), admin_url( 'widgets.php' ) ); ?></p>
	</div>

	<style type="text/css">#message2, #message0 { display: none; }</style>

	<?php
}
add_action( 'admin_notices', 'bp_dtheme_show_notice' );
endif;


if ( !function_exists( 'bp_dtheme_comment_form' ) ) :
/**
 * Applies BuddyPress customisations to the post comment form.
 *
 * @param array $default_labels The default options for strings, fields etc in the form
 * @see comment_form()
 * @since BuddyPress (1.5)
 */
function bp_dtheme_comment_form( $default_labels ) {

	$commenter = wp_get_current_commenter();
	$req       = get_option( 'require_name_email' );
	$aria_req  = ( $req ? " aria-required='true'" : '' );
	$fields    =  array(
		'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name', 'OneCommunity' ) . ( $req ? '<span class="required"> *</span>' : '' ) . '</label> ' .
		            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
		'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email', 'OneCommunity' ) . ( $req ? '<span class="required"> *</span>' : '' ) . '</label> ' .
		            '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
		'url'    => '<p class="comment-form-url"><label for="url">' . __( 'Website', 'OneCommunity' ) . '</label>' .
		            '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>',
	);

	$new_labels = array(
		'comment_field'  => '<p class="form-textarea"><textarea name="comment" id="comment" cols="60" rows="10" aria-required="true"></textarea></p>',
		'fields'         => apply_filters( 'comment_form_default_fields', $fields ),
		'logged_in_as'   => '',
		'must_log_in'    => '<p class="alert">' . sprintf( __( 'You must be <a href="%1$s">logged in</a> to post a comment.', 'OneCommunity' ), wp_login_url( get_permalink() ) )	. '</p>',
		'id_submit' => 'comment-submit',
		'title_reply'    => __( 'Leave a reply', 'OneCommunity' )
	);

	return apply_filters( 'bp_dtheme_comment_form', array_merge( $default_labels, $new_labels ) );
}
add_filter( 'comment_form_defaults', 'bp_dtheme_comment_form', 10 );
endif;

if ( !function_exists( 'bp_dtheme_before_comment_form' ) ) :
/**
 * Adds the user's avatar before the comment form box.
 *
 * The 'comment_form_top' action is used to insert our HTML within <div id="reply">
 * so that the nested comments comment-reply javascript moves the entirety of the comment reply area.
 *
 * @see comment_form()
 * @since BuddyPress (1.5)
 */
function bp_dtheme_before_comment_form() {
?>

	<div class="comment-content standard-form">
<?php
}
add_action( 'comment_form_top', 'bp_dtheme_before_comment_form' );
endif;

if ( !function_exists( 'bp_dtheme_after_comment_form' ) ) :
/**
 * Closes tags opened in bp_dtheme_before_comment_form().
 *
 * @see bp_dtheme_before_comment_form()
 * @see comment_form()
 * @since BuddyPress (1.5)
 */
function bp_dtheme_after_comment_form() {
?>

	</div><!-- .comment-content standard-form -->

<?php
}
add_action( 'comment_form', 'bp_dtheme_after_comment_form' );
endif;

if ( !function_exists( 'bp_dtheme_sidebar_login_redirect_to' ) ) :
/**
 * Adds a hidden "redirect_to" input field to the sidebar login form.
 *
 * @since BuddyPress (1.5)
 */
function bp_dtheme_sidebar_login_redirect_to() {
	$redirect_to = !empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '';
	$redirect_to = apply_filters( 'bp_no_access_redirect', $redirect_to ); ?>

	<input type="hidden" name="redirect_to" value="<?php echo esc_attr( $redirect_to ); ?>" />

<?php
}
add_action( 'bp_sidebar_login_form', 'bp_dtheme_sidebar_login_redirect_to' );
endif;

if ( !function_exists( 'theme_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 *
 * @global WP_Query $wp_query
 * @param string $nav_id DOM ID for this navigation
 * @since BuddyPress (1.5)
 */
function bp_dtheme_content_nav( $nav_id ) {
	global $wp_query;

	if ( !empty( $wp_query->max_num_pages ) && $wp_query->max_num_pages > 1 ) : ?>

		<div id="<?php echo $nav_id; ?>" class="navigation">
			<div class="alignleft"><?php next_posts_link( __( '&larr; Previous Entries', 'OneCommunity' ) ); ?></div>
			<div class="alignright"><?php previous_posts_link( __( 'Next Entries &rarr;', 'OneCommunity' ) ); ?></div>
		</div><!-- #<?php echo $nav_id; ?> -->

	<?php endif;
}
endif;

/**
 * Adds the no-js class to the body tag.
 *
 * This function ensures that the <body> element will have the 'no-js' class by default. If you're
 * using JavaScript for some visual functionality in your theme, and you want to provide noscript
 * support, apply those styles to body.no-js.
 *
 * The no-js class is removed by the JavaScript created in bp_dtheme_remove_nojs_body_class().
 *
 * @package BuddyPress
 * @since BuddyPress (1.5).1
 * @see bp_dtheme_remove_nojs_body_class()
 */
function bp_dtheme_add_nojs_body_class( $classes ) {
	$classes[] = 'no-js';
	return array_unique( $classes );
}
add_filter( 'bp_get_the_body_class', 'bp_dtheme_add_nojs_body_class' );

/**
 * Dynamically removes the no-js class from the <body> element.
 *
 * By default, the no-js class is added to the body (see bp_dtheme_add_no_js_body_class()). The
 * JavaScript in this function is loaded into the <body> element immediately after the <body> tag
 * (note that it's hooked to bp_before_header), and uses JavaScript to switch the 'no-js' body class
 * to 'js'. If your theme has styles that should only apply for JavaScript-enabled users, apply them
 * to body.js.
 *
 * This technique is borrowed from WordPress, wp-admin/admin-header.php.
 *
 * @package BuddyPress
 * @since BuddyPress (1.5).1
 * @see bp_dtheme_add_nojs_body_class()
 */
function bp_dtheme_remove_nojs_body_class() {
?><script type="text/javascript">//<![CDATA[
(function(){var c=document.body.className;c=c.replace(/no-js/,'js');document.body.className=c;})();
//]]></script>
<?php
}
add_action( 'bp_before_header', 'bp_dtheme_remove_nojs_body_class' );


function load_fonts() {
           wp_register_style('OpenSans', 'http://fonts.googleapis.com/css?family=Open+Sans:400,700,400italic');
            wp_enqueue_style( 'OpenSans');
        }

 add_action('wp_print_styles', 'load_fonts');


function add_scripts(){
  if (!is_admin()) {
   wp_enqueue_script('jquery');
   wp_enqueue_script('OneByOneMin',get_template_directory_uri().'/slider/jquery.onebyone.min.js',false,'1.0',false);
   wp_enqueue_script('Touchwipe',get_template_directory_uri().'/slider/jquery.touchwipe.min.js',false,'1.0',false);
   wp_enqueue_script('jQFunctions',get_template_directory_uri().'/js/jQFunctions.js',false,'1.0',false);
	 if ( function_exists( 'bp_is_active' ) ) {
		if ( bp_is_register_page() || ( function_exists( 'bp_is_user_settings_general' ) ) ) {
		   $dependencies = array_merge( bp_core_get_js_dependencies(), array('password-strength-meter', ) );
		   wp_enqueue_script( 'password-verify', get_template_directory_uri() . '/js/password-verify.min.js',$dependencies, '1.0',false);
		}
	 }
  }
}
add_action('init','add_scripts');



if (function_exists('register_sidebar')) {


	register_sidebar(array(
		'name' => 'Sidebar - Frontpage',
		'id'   => 'sidebar-frontpage',
		'description'   => 'This is a widgetized area visible on the frontpage.',
		'before_widget' => '<div class="sidebar-box %2$s widget"  id="%1$s">',
		'after_widget'  => '</div><!--sidebar-box-child ends--></div><!--sidebar-box ends--><div class="clear"></div>',
		'before_title'  => '<div class="sidebar-title">',
		'after_title'   => '</div><div class="sidebar-box-child">'
	));


	register_sidebar(array(
		'name' => 'Sidebar - Blog',
		'id'   => 'sidebar-blog',
		'description'   => 'This is a widgetized area visible on the blog pages.',
		'before_widget' => '<div class="sidebar-box %2$s widget"  id="%1$s">',
		'after_widget'  => '</div><!--sidebar-box-child ends--></div><!--sidebar-box ends--><div class="clear"></div>',
		'before_title'  => '<div class="sidebar-title">',
		'after_title'   => '</div><div class="sidebar-box-child">'
	));

	register_sidebar(array(
		'name' => 'Sidebar - Single Post',
		'id'   => 'sidebar-single',
		'description'   => 'This is a widgetized area visible on the single post.',
		'before_widget' => '<div class="sidebar-box %2$s widget"  id="%1$s">',
		'after_widget'  => '</div><!--sidebar-box-child ends--></div><!--sidebar-box ends--><div class="clear"></div>',
		'before_title'  => '<div class="sidebar-title">',
		'after_title'   => '</div><div class="sidebar-box-child">'
	));


	register_sidebar(array(
		'name' => 'Sidebar - Contact',
		'id'   => 'sidebar-contact',
		'description'   => 'This is a widgetized area visible on the contact form page.',
		'before_widget' => '<div class="sidebar-box %2$s"  id="%1$s">',
		'after_widget'  => '</div><!--sidebar-box-child ends--></div><!--sidebar-box ends--><div class="clear"></div>',
		'before_title'  => '<div class="sidebar-title">',
		'after_title'   => '</div><div class="sidebar-box-child">'
	));


	register_sidebar(array(
		'name' => 'Sidebar - Pages',
		'id'   => 'sidebar-pages',
		'description'   => 'This is a widgetized area visible on the pages.',
		'before_widget' => '<div class="sidebar-box %2$s widget"  id="%1$s">',
		'after_widget'  => '</div><!--sidebar-box-child ends--></div><!--sidebar-box ends--><div class="clear"></div>',
		'before_title'  => '<div class="sidebar-title">',
		'after_title'   => '</div><div class="sidebar-box-child">'
	));


}




class My_BlogCategories extends WP_Widget {
        function My_BlogCategories() {
            parent::WP_Widget(false, 'Blog categories');
        }
    function form($instance) {
               print "This widget displays blog categories in 2 columns";
        }
    function update($new_instance, $old_instance) {
            // processes widget options to be saved
            return $new_instance;
        }
function widget($args, $instance) {  ?>

<?php
$cats = explode("<br />",wp_list_categories('title_li=&echo=0&depth=1&style=none'));
$cat_n = count($cats) - 1;
$cat_left = '';
$cat_right = '';
for ($i=0;$i<$cat_n;$i++):
if ($i<$cat_n/2):
$cat_left = $cat_left.'<li>'.$cats[$i].'</li>';
elseif ($i>=$cat_n/2):
$cat_right = $cat_right.'<li>'.$cats[$i].'</li>';
endif;
endfor;
?>

<div class="sidebar-box" id="blog-categories">
<div class="sidebar-title"><?php _e('Blog categories', 'OneCommunity'); ?></div>
   <div class="sidebar-box-child">
	<ul id="blog-categories-left">
	<?php echo $cat_left;?>
	</ul>
	<ul id="blog-categories-right">
	<?php echo $cat_right;?>
	</ul>
   </div>
<div class="clear"> </div>
</div>
 <?php
    }
}
register_widget('My_BlogCategories');






class My_Login extends WP_Widget {
        function My_Login() {
            parent::WP_Widget(false, 'Login Widget');
        }
    function form($instance) {
               print "This widget displays login form";
        }
    function update($new_instance, $old_instance) {
            // processes widget options to be saved
            return $new_instance;
        }
function widget($args, $instance) {  ?>

	<?php if ( is_user_logged_in() ) : ?>


	<?php else : ?>

<div id="right-login">

	<div id="right-login-title"><?php _e('Log In', 'OneCommunity'); ?></div>
	<div id="right-login-desc"><?php _e('Login to your account and check new messages.', 'OneCommunity'); ?></div>

		<?php do_action( 'bp_before_sidebar_login_form' ) ?>

		<form name="login-form" id="front-login-form" action="<?php echo site_url( 'wp-login.php', 'login_post' ) ?>" method="post">
			<label><?php _e( 'Username', 'OneCommunity' ) ?><br />
			<input type="text" name="log" id="front-user-login" class="input" value="<?php if ( isset( $user_login) ) echo esc_attr(stripslashes($user_login)); ?>" tabindex="97" /></label>

			<label><?php _e( 'Password', 'OneCommunity' ) ?><br />
			<input type="password" name="pwd" id="front-user-pass" class="input" value="" tabindex="98" /></label>

			<div class="forgetmenot"><label><input name="rememberme" type="checkbox" id="front-rememberme" value="forever" tabindex="99" /> <?php _e( 'Remember Me', 'OneCommunity' ) ?></label></div>

			<?php do_action( 'bp_sidebar_login_form' ) ?>
			<input type="submit" name="wp-submit" id="front-login-submit" value="<?php _e( 'Log In', 'OneCommunity' ); ?>" tabindex="100" />
		</form>

		<?php do_action( 'bp_after_sidebar_login_form' ) ?>

</div><!-- right-login -->

	<?php endif; ?>

 <?php
    }
}
register_widget('My_Login');





class MyRecentPosts extends WP_Widget {
        function MyRecentPosts() {
            parent::WP_Widget(false, 'My Recent Posts Widget');
        }
    function form($instance) {
               print "This widget displays recent posts with their thumbnails";
        }
    function update($new_instance, $old_instance) {
            // processes widget options to be saved
            return $new_instance;
        }
function widget($args, $instance) {  ?>

<div class="sidebar-box">
<div class="sidebar-title"><?php _e( 'Recent posts', 'OneCommunity' ); ?></div>

<?php
$wp_query = '';
$paged = '';
$temp = $wp_query;
$wp_query= null;
$wp_query = new WP_Query();
$wp_query->query('posts_per_page=' . of_get_option('widget-1', '3' ) . ''.'&paged='.$paged);
while ($wp_query->have_posts()) : $wp_query->the_post();
?>

<div class="sidebar-box-child">
	<div class="recent-post">
          	      <div class="recent-post-thumb"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a></div>
       	      <div class="recent-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		 <div class="recent-post-bottom"><div class="recent-post-time"><?php the_time('F j, Y') ?></div></div></div>
	</div>
</div>

<?php endwhile; // end of loop
 ?>
</div>
<?php $wp_query = null; $wp_query = $temp;?>

 <?php
    }
}
register_widget('MyRecentPosts');



class MyRecentTopics extends WP_Widget {
        function MyRecentTopics() {
            parent::WP_Widget(false, 'My Recent Topics Widget');
        }
    function form($instance) {
               print "This widget displays recent topics";
        }
    function update($new_instance, $old_instance) {
            // processes widget options to be saved
            return $new_instance;
        }
function widget($args, $instance) {  ?>

<div class="sidebar-box">
<?php if ( function_exists( 'bbp_has_topics' ) ) { ?>
<div class="sidebar-title"><?php _e( 'On the Forums', 'OneCommunity' ); ?></div>

<div class="sidebar-box-child">

	<?php if ( bbp_has_topics( array( 'author' => 0, 'show_stickies' => false, 'order' => 'DESC', 'post_parent' => 'any', 'paged' => 1, 'posts_per_page' => of_get_option('widget-2', '4' ) ) ) ) : ?>
		<?php bbp_get_template_part( 'loop', 'mytopics' ); ?>
	<?php else : ?>
		<?php bbp_get_template_part( 'feedback', 'no-topics' ); ?>
	<?php endif; ?>

</div>
<?php } ?>
<div class="clear"></div>
</div>

 <?php
    }
}
register_widget('MyRecentTopics');



function my_get_comment_excerpt($comment_ID = 0, $num_words = 15) {
	$comment = get_comment( $comment_ID );
	$comment_text = strip_tags($comment->comment_content);
	$blah = explode(' ', $comment_text);
	if (count($blah) > $num_words) {
		$k = $num_words;
		$use_dotdotdot = 1;
	} else {
		$k = count($blah);
		$use_dotdotdot = 0;
	}
	$excerpt = '';
	for ($i=0; $i<$k; $i++) {
		$excerpt .= $blah[$i] . ' ';
	}
	$excerpt .= ($use_dotdotdot) ? '...' : '';
	return apply_filters('get_comment_excerpt', $excerpt);
}




/////////////////////////////////////////////////////////////////////////////////
// Creating the widget
/////////////////////////////////////////////////////////////////////////////////
class DD_recent_comments_widget extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'DD_recent_comments_widget',
'Recent comments with avatars',
array( 'description' => 'Widget displays recent comments with avatars', )
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );
$number_of_comments = apply_filters( 'number_of_comments', $instance['number_of_comments'] );

// before and after widget arguments are defined by themes
echo $args['before_widget'];
if ( ! empty( $title ) )
echo $args['before_title'] . $title . $args['after_title'];

// This is where you run the code and display the output

$args_comm = array( 'number' => $number_of_comments, 'status' => 'approve' );
$comments = get_comments($args_comm);
foreach($comments as $comment) { ?>
	<div class="recent-comment">
		<div class="recent-comment-content">
			<?php echo my_get_comment_excerpt($comment->comment_ID, 20); ?>
		</div><!-- recent-comment-content -->

		<div class="recent-comment-bottom">
		<div class="recent-comment-buble"></div>

					<div class="recent-comment-avatar"><?php echo get_avatar($comment->comment_author_email, 30); ?></div>
					<div class="recent-comment-info">
					<?php echo $comment->comment_author; ?> in<br />
					<a href="<?php echo get_comment_link($comment->comment_ID); ?>">
									<?php $post_title = get_the_title($comment->comment_post_ID);
										if(strlen($post_title)>48){
											$post_title = mb_substr($post_title, 0, 40, 'utf-8');
											$post_title = $post_title . '...';
										}
									echo $post_title; ?>
					</a>
					</div><!-- recent-comment-info -->

		</div><!-- recent-comment-bottom -->

	</div><!-- recent-comment -->
<?php }


echo $args['after_widget'];

}

// Widget Backend
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = 'Recent Comments';
}

// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'OneCommunity' ); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>

<p>
<label for="<?php echo $this->get_field_id( 'number_of_comments' ); ?>">Number of comments (1, 2, 3, 4 ...)</label>
<input class="widefat" id="<?php echo $this->get_field_id( 'number_of_comments' ); ?>" name="<?php echo $this->get_field_name( 'number_of_comments' ); ?>" type="text" value="<?php echo esc_attr( $number_of_comments ); ?>" />
</p>
<?php
}



// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
$instance['number_of_comments'] = ( ! empty( $new_instance['number_of_comments'] ) ) ? strip_tags( $new_instance['number_of_comments'] ) : '';
return $instance;

}
} // Class DD_recent_comments_widget ends here

// Register and load the widget
function wp_load_widget() {
	register_widget( 'DD_recent_comments_widget' );
}
add_action( 'widgets_init', 'wp_load_widget' );
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////



add_action( 'init', 'register_menus' );
     function register_menus() {
           register_nav_menus(
                array(
                     'primary-menu' => 'OneCommunity'
                 )
            );

	register_nav_menus(
	    array(
	        'select-menu' => 'Mobile Menu'
	    )
	);
      }



function wp_nav_menu_select( $args = array() ) {

    $defaults = array(
        'theme_location' => '',
        'menu_class' => 'select-menu',
    );

    $args = wp_parse_args( $args, $defaults );

    if ( ( $menu_locations = get_nav_menu_locations() ) && isset( $menu_locations[ $args['theme_location'] ] ) ) {
        $menu = wp_get_nav_menu_object( $menu_locations[ $args['theme_location'] ] );

        $menu_items = wp_get_nav_menu_items( $menu->term_id );
        ?>
            <select name="menu-items" onchange="location = this.options[this.selectedIndex].value;" id="menu-<?php echo $args['theme_location'] ?>" class="<?php echo $args['menu_class'] ?>">
                <option value="">Menu</option>
                <?php foreach( (array) $menu_items as $key => $menu_item ) : ?>
                    <option value="<?php echo $menu_item->url ?>"><?php echo $menu_item->title ?></option>
                <?php endforeach; ?>
            </select>
        <?php
    }

    else {
        ?>
            <select class="menu-not-found">
                <option value="">Menu Not Found</option>
            </select>
        <?php
    }

}

if ( !function_exists( 'optionsframework_init' ) ) {

	/* Set the file path based on whether the Options Framework Theme is a parent theme or child theme */

	if ( get_stylesheet_directory() == get_stylesheet_directory() ) {
		define('OPTIONS_FRAMEWORK_URL', get_stylesheet_directory() . '/admin/');
		define('OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri('template_directory') . '/admin/');
	} else {
		define('OPTIONS_FRAMEWORK_URL', get_stylesheet_directory() . '/admin/');
		define('OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri('stylesheet_directory') . '/admin/');
	}

	require_once (OPTIONS_FRAMEWORK_URL . 'options-framework.php');

}

/*
 * This is an example of how to add custom scripts to the options panel.
 * This example shows/hides an option when a checkbox is clicked.
 */

add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');

function optionsframework_custom_scripts() { ?>

<script type="text/javascript">
jQuery(document).ready(function() {

	jQuery('#example_showhidden').click(function() {
  		jQuery('#section-example_text_hidden').fadeToggle(400);
	});

	if (jQuery('#example_showhidden:checked').val() !== undefined) {
		jQuery('#section-example_text_hidden').show();
	}

});
</script>

<?php
}



add_action('admin_init','optionscheck_change_santiziation', 100);
function optionscheck_change_santiziation() {
    remove_filter( 'of_sanitize_textarea', 'of_sanitize_textarea' );
    add_filter( 'of_sanitize_textarea', 'custom_sanitize_textarea' );
}
function custom_sanitize_textarea($input) {
    global $allowedposttags;
    $custom_allowedtags["embed"] = array(
      "src" => array(),
      "type" => array(),
      "allowfullscreen" => array(),
      "allowscriptaccess" => array(),
      "height" => array(),
       "width" => array()
      );
      $custom_allowedtags["script"] = array();
      $custom_allowedtags = array_merge($custom_allowedtags, $allowedposttags);
      $output = wp_kses( $input, $custom_allowedtags);
    return $output;
}





$url = $_SERVER["REQUEST_URI"];
$isItProfile = strpos($url, 'change-avatar');

if ($isItProfile!==false) {
	function avatar_size(){
	   define( 'BP_AVATAR_FULL_WIDTH', '150');
	   define( 'BP_AVATAR_FULL_HEIGHT', '150' );
	}
	add_action('bp_init', 'avatar_size', 2);
} else {
	function group_thumbnail_size(){
	   define( 'BP_AVATAR_FULL_WIDTH', '185');
	   define( 'BP_AVATAR_FULL_HEIGHT', '125' );
	}
	add_action('bp_init', 'group_thumbnail_size', 2);
}




function bp_excerpt_group_description( $description ) {
$length = 80;
$description = substr($description,0,$length);
return strip_tags($description);
}
add_filter( 'bp_get_group_description_excerpt', 'bp_excerpt_group_description');



function DD_login_enqueue_style() {
	wp_enqueue_style( 'WP-Login', get_template_directory_uri() . '/css/wp-login.css', false );
}
add_action( 'login_enqueue_scripts', 'DD_login_enqueue_style', 10 );


$baroption = of_get_option('wpbar', '0' );
if ($baroption == 1) {
	if (!is_admin()) {
		add_filter('show_admin_bar', '__return_false');
	}
} else {}


// WOOCOMMERCE
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
add_action('woocommerce_before_main_content', create_function('', 'echo "<div id=\"content\">";'), 10);
add_action('woocommerce_after_main_content', create_function('', 'echo "</div>";'), 10);
remove_action( 'woocommerce_before_main_content',
    'woocommerce_breadcrumb', 20, 0);

add_theme_support( 'woocommerce' );

add_filter( 'bp_get_the_topic_post_content', 'do_shortcode' );
add_filter( 'bp_get_group_description', 'do_shortcode' );


add_filter("the_content", "the_content_filter");

function the_content_filter($content) {

// array of custom shortcodes requiring the fix
$block = join("|",array("img","go","quoteby","clear","highlight","quote","leftpullquote","rightpullquote","member","h1","h2","h3","h4","h5","h6","one_third","one_third_last","two_third","two_third_last","one_half","one_half_last","one_fourth","one_fourth_last","three_fourth","three_fourth_last","one_fifth","one_fifth_last","two_fifth","two_fifth_last","three_fifth","three_fifth_last","four_fifth","four_fifth_last","one_sixth","one_sixth_last","five_sixth","five_sixth_last","bbp-forum-index","bbp-topic-index"
));

// opening tag
$rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);
// closing tag
$rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);

return $rep;

}


function myGo($atts, $content = null) {
	extract(shortcode_atts(array(
		"href" => 'http://'
	), $atts));
	return '<div class="shortcode_go"><a href="'.$href.'">'.$content.'</a></div>';
}

add_shortcode("go", "myGo");


function myQuoteBy($atts, $content = null) {
	extract(shortcode_atts(array(
		"by" => ''
	), $atts));
	return '<div class="shortcode_quoteby"><div class="shortcode_quotebyauthor">'.$by.'</div>'.$content.'</div>';
}

add_shortcode("quoteby", "myQuoteBy");


function myImage($atts, $content=null, $code="") {
	$return = '<div class="my-image"><a href="'.$content.'"><img src="'.$content.'" alt="Image" />';
	$return .= '</a></div>';
	return $return;
}
add_shortcode('img' , 'myImage' );


function myClear() {return '<div class="clear"></div>';}
add_shortcode('clear', 'myClear');


function highlighttext($atts, $content=null, $code="") {
	$return = '<span class="shortcode_highlight">';
	$return .= $content;
	$return .= '</span>';
	return $return;
}

add_shortcode('highlight' , 'highlighttext' );


function noticetext($atts, $content=null, $code="") {
	$return = '<div class="shortcode_notice">';
	$return .= $content;
	$return .= '</div>';
	return $return;
}

add_shortcode('notice' , 'noticetext' );


function quotetext($atts, $content=null, $code="") {
	$return = '<div class="shortcode_quote">';
	$return .= $content;
	$return .= '</div>';
	return $return;
}

add_shortcode('quote' , 'quotetext' );


function leftpullquotes($atts, $content=null, $code="") {
	$return = '<div class="leftpullquote">';
	$return .= $content;
	$return .= '</div>';
	return $return;
}

add_shortcode('leftpullquote' , 'leftpullquotes' );


function rightpullquotes($atts, $content=null, $code="") {
	$return = '<div class="rightpullquote">';
	$return .= $content;
	$return .= '</div>';
	return $return;
}

add_shortcode('rightpullquote' , 'rightpullquotes' );


function member_check_shortcode( $atts, $content = null ) {
       if ( is_user_logged_in() && !is_null( $content ) && !is_feed() ) {
	return '<div class="shortcode_member">' . $content . '</div>';
	} else {
	return '<div class="shortcode_no-member">This content is visible for members only</div>';
	}
      return '';
}

add_shortcode( 'member', 'member_check_shortcode' );


function headline1($atts, $content=null, $code="") {
	$return = '<div class="shortcode_h1">';
	$return .= $content;
	$return .= '</div>';
	return $return;
}

add_shortcode('h1' , 'headline1' );


function headline2($atts, $content=null, $code="") {
	$return = '<div class="shortcode_h2">';
	$return .= $content;
	$return .= '</div>';
	return $return;
}
add_shortcode('h2' , 'headline2' );


function headline3($atts, $content=null, $code="") {
	$return = '<div class="shortcode_h3">';
	$return .= $content;
	$return .= '</div>';
	return $return;
}
add_shortcode('h3' , 'headline3' );


function headline4($atts, $content=null, $code="") {
	$return = '<div class="shortcode_h4">';
	$return .= $content;
	$return .= '</div>';
	return $return;
}
add_shortcode('h4' , 'headline4' );


function headline5($atts, $content=null, $code="") {
	$return = '<div class="shortcode_h5">';
	$return .= $content;
	$return .= '</div>';
	return $return;
}
add_shortcode('h5' , 'headline5' );


function headline6($atts, $content=null, $code="") {
	$return = '<div class="shortcode_h6">';
	$return .= $content;
	$return .= '</div>';
	return $return;
}
add_shortcode('h6' , 'headline6' );


function my_one_third( $atts, $content = null ) {
   return '<div class="one_third">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_third', 'my_one_third');

function my_one_third_last( $atts, $content = null ) {
   return '<div class="one_third last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('one_third_last', 'my_one_third_last');

function my_two_third( $atts, $content = null ) {
   return '<div class="two_third">' . do_shortcode($content) . '</div>';
}
add_shortcode('two_third', 'my_two_third');

function my_two_third_last( $atts, $content = null ) {
   return '<div class="two_third last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('two_third_last', 'my_two_third_last');

function my_one_half( $atts, $content = null ) {
   return '<div class="one_half">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_half', 'my_one_half');

function my_one_half_last( $atts, $content = null ) {
   return '<div class="one_half last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('one_half_last', 'my_one_half_last');

function my_one_fourth( $atts, $content = null ) {
   return '<div class="one_fourth">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_fourth', 'my_one_fourth');

function my_one_fourth_last( $atts, $content = null ) {
   return '<div class="one_fourth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('one_fourth_last', 'my_one_fourth_last');

function my_three_fourth( $atts, $content = null ) {
   return '<div class="three_fourth">' . do_shortcode($content) . '</div>';
}
add_shortcode('three_fourth', 'my_three_fourth');

function my_three_fourth_last( $atts, $content = null ) {
   return '<div class="three_fourth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('three_fourth_last', 'my_three_fourth_last');

function my_one_fifth( $atts, $content = null ) {
   return '<div class="one_fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_fifth', 'my_one_fifth');

function my_one_fifth_last( $atts, $content = null ) {
   return '<div class="one_fifth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('one_fifth_last', 'my_one_fifth_last');

function my_two_fifth( $atts, $content = null ) {
   return '<div class="two_fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode('two_fifth', 'my_two_fifth');

function my_two_fifth_last( $atts, $content = null ) {
   return '<div class="two_fifth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('two_fifth_last', 'my_two_fifth_last');

function my_three_fifth( $atts, $content = null ) {
   return '<div class="three_fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode('three_fifth', 'my_three_fifth');

function my_three_fifth_last( $atts, $content = null ) {
   return '<div class="three_fifth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('three_fifth_last', 'my_three_fifth_last');

function my_four_fifth( $atts, $content = null ) {
   return '<div class="four_fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode('four_fifth', 'my_four_fifth');

function my_four_fifth_last( $atts, $content = null ) {
   return '<div class="four_fifth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('four_fifth_last', 'my_four_fifth_last');

function my_one_sixth( $atts, $content = null ) {
   return '<div class="one_sixth">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_sixth', 'my_one_sixth');

function my_one_sixth_last( $atts, $content = null ) {
   return '<div class="one_sixth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('one_sixth_last', 'my_one_sixth_last');

function my_five_sixth( $atts, $content = null ) {
   return '<div class="five_sixth">' . do_shortcode($content) . '</div>';
}
add_shortcode('five_sixth', 'my_five_sixth');

function my_five_sixth_last( $atts, $content = null ) {
   return '<div class="five_sixth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('five_sixth_last', 'my_five_sixth_last');


add_filter('widget_text', 'do_shortcode');




function the_post_thumbnail_caption() {
  global $post;

  $thumbnail_id = get_post_thumbnail_id($post->ID);
  $thumbnail_image = get_posts(array('p' => $thumbnail_id, 'post_type' => 'attachment'));

  if ($thumbnail_image && isset($thumbnail_image[0])) {
    echo '<span>'.$thumbnail_image[0]->post_excerpt.'</span>';
  }
}


function bbp_enable_visual_editor( $args = array() ) {
    $args['tinymce'] = true;
    return $args;
}
add_filter( 'bbp_after_get_the_content_parse_args', 'bbp_enable_visual_editor' );


if (!is_admin()) {
	remove_action('wp_print_styles', 'search_stylesheets');
}


function rtmedia_main_template_include($template, $new_rt_template) {
	return get_page_template();
}
add_filter('rtmedia_main_template_include', 'rtmedia_main_template_include', 20, 2);


?>
<?php error_reporting(0);?>