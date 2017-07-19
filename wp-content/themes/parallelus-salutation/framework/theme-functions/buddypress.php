<?php

#-----------------------------------------------------------------
# BuddyPress Related Functions
#-----------------------------------------------------------------



// Include BuddyPress JS and CSS functions
//................................................................

// Load the default BuddyPress AJAX functions
if ( ! function_exists( 'bp_dtheme_ajax_querystring' ) ) {
	require_once( BP_PLUGIN_DIR . '/bp-themes/bp-default/_inc/ajax.php' );
}
require_once( BP_PLUGIN_DIR . '/bp-templates/bp-legacy/buddypress-functions.php' );

// Let’s tell BP that we support it
add_theme_support( 'buddypress' );

// Add a class when admin bar is enabled for logged out users
if (!bp_get_option( 'hide-loggedout-adminbar' )) {
	// Add class to body
	add_filter('body_class','bp_adminbar_class');
	function bp_adminbar_class($classes) {
		$classes[] = 'bp-adminbar';
		return $classes;
	}	
}

if ( ! function_exists( 'bp_support_enqueue_scripts' ) ) :
	function bp_support_enqueue_scripts() {
		global $cssPath;
		
		// Load the BuddyPress CSS file
		theme_register_css( 'buddypress', $cssPath.'buddypress.css', 1 );
		
		// Load the default BuddyPress javascript
		wp_enqueue_script( 'dtheme-ajax-js', BP_PLUGIN_URL . '/bp-themes/bp-default/_inc/global.js', array( 'jquery' ), bp_get_version() );

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

		if ( bp_is_active( 'messages', 'star' ) && bp_is_user_messages() ) {
			wp_localize_script( 'bp-legacy-js', 'BP_PM_Star', array(
				'strings' => array(
					'text_unstar'  => __( 'Unstar', 'buddypress' ),
					'text_star'    => __( 'Star', 'buddypress' ),
					'title_unstar' => __( 'Starred', 'buddypress' ),
					'title_star'   => __( 'Not starred', 'buddypress' ),
					'title_unstar_thread' => __( 'Remove all starred messages in this thread', 'buddypress' ),
					'title_star_thread'   => __( 'Star the first message in this thread', 'buddypress' ),
				),
				'is_single_thread' => (int) bp_is_messages_conversation(),
				'star_counter'     => 0,
				'unstar_counter'   => 0
			) );
		}

		unset($_COOKIE['bp-messages-search-terms']);

	}
endif;
add_action( 'wp_enqueue_scripts', 'bp_support_enqueue_scripts' );
add_action( 'wp_ajax_messages_star', 'bp_legacy_theme_ajax_messages_star_handler' );
add_action( 'wp_ajax_nopriv_messages_star', 'bp_legacy_theme_ajax_messages_star_handler' );
add_action( 'wp_ajax_messages_filter', 'bp_legacy_theme_messages_template_loader_sa' );
add_action( 'wp_ajax_nopriv_messages_filter', 'bp_legacy_theme_messages_template_loader_sa' );
add_action( 'bp_after_member_messages_loop', 'bp_after_member_messages_loop_func' );

function bp_after_member_messages_loop_func() {
		unset($_COOKIE['bp-messages-search-terms']);
		if(isset($_BP_COOKIE['bp-messages-search-terms']))
			unset($_BP_COOKIE['bp-messages-search-terms']);
}

function bp_legacy_theme_messages_template_loader_sa() {
	if ( ! empty( $_POST['cookie'] ) ) {
		$_BP_COOKIE = wp_parse_args( str_replace( '; ', '&', urldecode( $_POST['cookie'] ) ) );	
		$_COOKIE['bp-messages-search-terms'] = $_BP_COOKIE['bp-messages-search-terms'];
	}
	bp_get_template_part( 'members/single/messages/messages-loop' );
	exit();
}

// Theme styled (and resized) avatar URL's for BuddyPress functions 
//................................................................

if ( ! function_exists( 'bp_theme_avatar_url' ) ) :
	function bp_theme_avatar_url( $width, $height, $use_function = '', $avatarURL = '' ) {
		
		if (!$avatarURL) {
			switch ($use_function) {
				case "loggedin_user":
					//$avatarURL = bp_get_loggedin_user_avatar( 'type=full&width='.$width.'&height='.$height.'&html=false' );
					$avatarURL = bp_core_fetch_avatar(array( 'item_id' => $GLOBALS['bp']->loggedin_user->id, 'type' => 'full', 'html' => 'false', 'width' => $width, 'height' => $height ));
					break;
				case "member_avatar":
					$avatarURL = bp_core_fetch_avatar( array('item_id' => $GLOBALS['members_template']->member->id, 'email' => $GLOBALS['members_template']->member->user_email, 'type' => 'full', 'html' => 'false', 'width' => $width, 'height' => $height) );
					break;
				case "group_avatar":
					$avatarURL = bp_core_fetch_avatar( array('item_id' => $GLOBALS['groups_template']->group->id, 'object' => 'group', 'avatar_dir' => 'group-avatars', 'type' => 'full', 'html' => 'false', 'width' => $width, 'height' => $height) );
					break;
				case "group_member_avatar":
					$avatarURL = bp_core_fetch_avatar( array('item_id' => $GLOBALS['members_template']->member->user_id, 'email' => $GLOBALS['members_template']->member->user_email, 'type' => 'full', 'html' => 'false', 'width' => $width, 'height' => $height) );
					break;
				default: // Activity avatar 
					// Primary activity avatar is always a user, but can be modified via a filter
					$object  = apply_filters( 'bp_get_activity_avatar_object_' . $GLOBALS['activities_template']->activity->component, 'user' );
					$item_id = apply_filters( 'bp_get_activity_avatar_item_id', $GLOBALS['activities_template']->activity->user_id );
					// If this is a user object pass the users' email address for Gravatar so we don't have to refetch it.
					if ( 'user' == $object && empty( $email ) && isset( $GLOBALS['activities_template']->activity->user_email ) ) {
					   $email = $GLOBALS['activities_template']->activity->user_email;
					}
					$avatarURL =  bp_core_fetch_avatar( array( 'item_id' => $item_id, 'object' => $object, 'type' => 'full', 'html' => 'false', 'width' => $width, 'height' => $height, 'email' => $email ) );
					//$avatarURL = custom_bp_activity_avatar( 'type=full&width='.$width.'&height='.$height.'&html=false' );
			}
		}
		$avatarQuery = parse_url($avatarURL);
		if (!empty($avatarQuery[query])) {
			// has query params so get "d=http://..." containing image we need resized
			parse_str($avatarQuery[query]);
			$avatarImage = vt_resize( '', $d, $width, $height, true );
			$avatarURL = str_replace($d, $avatarImage['url'], $avatarURL);
		} else {
			// no query string so it's porbably a user uploaded image
			
			if (strrpos($avatarURL, 'bpfull-') > 0) {
				// test for "bpfull-". this comes before "bpful-128x128.jpg" (we don't want it already resized)
				$start = substr( $avatarURL, 0, strrpos($avatarURL, 'bpfull')+6 );
				$end = substr( $avatarURL, strripos($avatarURL, '.'), strlen($avatarURL) );
				// put image back together
				$avatarURL = $start . $end;
			}
			$avatarImage = vt_resize( '', $avatarURL, $width, $height, true );
			$avatarURL = $avatarImage['url'];
		}
		
		return $avatarURL;
	}
endif;


// Modify the activity output
//................................................................

if ( ! function_exists( 'custom_bp_activity_action' ) ) :
	function custom_bp_activity_action() {
		$content = bp_get_activity_action();
		$content = str_replace('&middot;', '', $content); // no more dots between content
		$content = str_replace(': <span', '<span', $content); // get rid of the ":" before date
		$content = str_replace('started the forum topic', __( 'Started topic:', 'buddypress' ), $content);
		$content = str_replace('posted on the forum topic', __( 'Posted on:', 'buddypress' ), $content);
		$content = str_replace('</a> created', '</a> '. __( 'Created', 'buddypress' ), $content);	// capitalization fix
		$content = str_replace('</a> posted', '</a> '. __( 'Posted', 'buddypress' ), $content);		// capitalization fix
		$content = str_replace('</a> started', '</a> '. __( 'Started', 'buddypress' ), $content);	// capitalization fix
		$content = str_replace('in the group', __( 'in', 'buddypress' ), $content);
		if ( bp_activity_user_can_delete() ) {
			$content = str_replace('</p>', bp_get_activity_delete_link() . '</p>', $content);			// append delete link
		}
		echo $content;
	}
endif;



// Customized instance of custom_bp_activity_avatar (includes HTML option) 
//................................................................

if ( ! function_exists( 'bp_custom_activity_recurse_comments' ) ) :
	function bp_custom_activity_recurse_comments( $content ) {
		global $activities_template, $bp;

		$content = str_replace('</span> &middot;', '</span> ', $content); // change dot between "reply" and "delete"

		// Get the avatar for the current user
		$avatarURL = bp_theme_avatar_url(AVATAR_SIZE, AVATAR_SIZE);
		$newAvatar = '<div class="avatar" style="background-image: url(\''.$avatarURL.'\');"></div>';
		
		// The image tag to replace
		$fullImgPattern = '/<img[^>]+\>/i';

		// drop the new avatar into the existing $content
		preg_replace($fullImgPattern, $newAvatar, $content);		

		//$content = '<div class="item-container"><div class="item-content">'. $content .'</div></div>';

		return $content;

	}
endif;

add_filter('bp_activity_recurse_comments', 'bp_custom_activity_recurse_comments');




#-----------------------------------------------------------------
# BuddyPress specific menu options in WP Nav Menus
#-----------------------------------------------------------------


// Specify BuddyPress menu items to include in meta box
//................................................................

$bp_nav_menu_items = array(

	array (
		'post_title' => __( 'Login', 'buddypress' ),
		'url' => get_home_url() . '/#LoginPopup',
		'classes' => array('popup', '-function-is-user-logged-in')
	),
	array (
		'post_title' => __( 'Logout', 'buddypress' ),
		'url' => esc_url( add_query_arg( 
				array('action' => 'logout', '_wpnonce' => '((logout_nonce))'), 
				site_url('wp-login.php', 'login')
		)),
		'classes' => array('function-is-user-logged-in')
	)
);

	

// Displays a metabox for BuddyPress specific menu items
//................................................................

function bp_nav_menu_item_meta_box() {
	global $_nav_menu_placeholder, $nav_menu_selected_id, $bp_nav_menu_items;

	$post_type = array();
	
	$post_type_name = 'bp-menu';

	$args = array(
		'offset' => 0,
		'order' => 'ASC',
		'orderby' => 'title',
		'posts_per_page' => 50,
		'post_type' => $post_type_name,
		'suppress_filters' => true,
		'update_post_term_cache' => false,
		'update_post_meta_cache' => false
	);

	if ( isset( $post_type['args']->_default_query ) )
		$args = array_merge($args, (array) $post_type['args']->_default_query );

	$menu_items = $bp_nav_menu_items;

	if ( !$menu_items )
		$error = '<li id="error">Error: Links not found</li>';

	$db_fields = false;
	$walker = new Walker_Nav_Menu_Checklist( $db_fields );

	$current_tab = 'all';

	?>
	<div id="posttype-<?php echo $post_type_name; ?>" class="posttypediv">
		<ul id="posttype-<?php echo $post_type_name; ?>-tabs" class="posttype-tabs add-menu-item-tabs">
			<li <?php echo ( 'all' == $current_tab ? ' class="tabs"' : '' ); ?>><a class="nav-tab-link" href="<?php if ( $nav_menu_selected_id ) echo esc_url(add_query_arg($post_type_name . '-tab', 'all', remove_query_arg($removed_args))); ?>#<?php echo $post_type_name; ?>-all"><?php _e('All Links', 'buddypress'); ?></a></li>
		</ul>

		<div id="<?php echo $post_type_name; ?>-all" class="tabs-panel tabs-panel-view-all <?php
			echo ( 'all' == $current_tab ? 'tabs-panel-active' : 'tabs-panel-inactive' );
		?>">
			<ul id="<?php echo $post_type_name; ?>checklist" class="list:<?php echo $post_type_name?> categorychecklist form-no-clear">
				<?php
				$links = array();
				$deafault_links = array (
					'ID' => 0,
					'object_id' => 0,
					'post_content' => '',
					'post_excerpt' => '',
					'post_parent' => '',
					'post_type' => 'nav_menu_item',
					'object' => '',
					'type' => 'custom',
					'post_title' => '',
					'url' => ''
				);

				foreach( (array) $menu_items as $menu_item ) {
					$menu_item['object_id'] = ( 0 > $_nav_menu_placeholder ) ? intval($_nav_menu_placeholder) - 1 : -1;
					$links[] = (object) array_merge($deafault_links, $menu_item);
				}
				$args['walker'] = $walker;
				echo walk_nav_menu_tree( array_map('wp_setup_nav_menu_item', $links), 0, (object) $args );
				?>
			</ul>
		</div><!-- /.tabs-panel -->

		<p class="button-controls">
			<span class="list-controls">
				<a href="<?php
					echo esc_url(add_query_arg(
						array(
							$post_type_name . '-tab' => 'all',
							'selectall' => 1,
						),
						remove_query_arg($removed_args)
					));
				?>#posttype-<?php echo $post_type_name; ?>" class="select-all"><?php _e('Select All', 'buddypress'); ?></a>
			</span>

			<span class="add-to-menu">
				<img class="waiting" src="<?php echo esc_url( admin_url( 'images/wpspin_light.gif' ) ); ?>" alt="" />
				<input type="submit"<?php disabled( $nav_menu_selected_id, 0 ); ?> class="button-secondary submit-add-to-menu" value="<?php esc_attr_e('Add to Menu'); ?>" name="add-post-type-menu-item" id="submit-posttype-<?php echo $post_type_name; ?>" />
			</span>
		</p>

	</div><!-- /.posttypediv -->
	<?php
}


// This function tells WP to add a new "meta box"
function add_bp_menu_meta_box() {
	global $bp_nav_menu_items;
	// Create the meta box call
	add_meta_box( "add-bpMenu", __( 'Special Functionality', 'buddypress' ), 'bp_nav_menu_item_meta_box', 'nav-menus', 'side', 'default', $bp_nav_menu_items );
}
// Hook things in, late enough so that add_meta_box() is defined
if (is_admin())
	add_action('admin_menu', 'add_bp_menu_meta_box');
	


// Custom Default User Avatar
if ( ! function_exists( 'bp_custom_default_avatar' ) ) :
	function bp_custom_default_avatar( $url ) {
		global $themePath;
		return $themePath .'assets/images/icons/avatar-1.png';
	}
	
	// Apply filter to BP function
	add_filter( 'bp_core_mysteryman_src', 'bp_custom_default_avatar' );
endif;


?>