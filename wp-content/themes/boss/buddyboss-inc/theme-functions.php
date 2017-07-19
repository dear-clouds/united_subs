<?php
/**
 * @package Boss
 */
/**
 * Sets up the content width value based on the theme's design and stylesheet.
 */
global $content_width;
$content_width     = ( isset( $content_width ) ) ? $content_width : 625;

function boss_show_adminbar() {
	$show = false;

	if ( !is_admin() && current_user_can( 'manage_options' ) && (boss_get_option( 'boss_adminbar' )) ) {
		$show = true;
	}

	return apply_filters( 'boss_show_adminbar', $show );
}

/**
 * Set global orientation variable
 */
global $rtl;

$rtl = false;

if ( is_rtl() ) {
	$rtl = true;
}

global $boss_learndash, $boss_sensei, $learner;
$learner = !is_null($boss_learndash) || !is_null($boss_sensei);

/**
 * Sets up theme defaults and registers the various WordPress features that Boss supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add a Visual Editor stylesheet.
 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
 * @uses register_nav_menu() To add support for navigation menus.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Boss 1.0.0
 */
function buddyboss_setup() {
	// Completely Disable Adminbar from frontend.
	//show_admin_bar( false );
	// Makes Boss available for translation.
	load_theme_textdomain( 'boss', get_template_directory() . '/languages' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

    // Add title at wp_head
    add_theme_support( 'title-tag' );

	// Declare theme support for WooCommerce
	add_theme_support( 'woocommerce' );

	// Adds wp_nav_menu() in two locations with BuddyPress deactivated.
	register_nav_menus( array(
		'left-panel-menu'	 => __( 'BuddyPanel', 'boss' ),
		'header-menu'		 => __( 'Titlebar', 'boss' ),
		'header-my-account'	 => __( 'My Profile', 'boss' ),
		'secondary-menu'	 => __( 'Footer', 'boss' ),
	) );

	// Adds wp_nav_menu() in two additional locations with BuddyPress activated.
	if ( function_exists( 'bp_is_active' ) ) {
		register_nav_menus( array(
			'profile-menu'	 => __( 'Profile: Extra Links', 'boss' ),
			'group-menu'	 => __( 'Group: Extra Links', 'boss' ),
		) );
	}


	// This theme uses a custom image size for featured images, displayed on "standard" posts.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 624, 9999 ); // Unlimited height, soft crop

    // Disable wordpress core css
    add_theme_support( 'html5', array(
        'gallery'
    ) );
}

add_action( 'after_setup_theme', 'buddyboss_setup' );

/**
 * Adds Profile menu to BuddyPress profiles
 *
 * @since Boss 1.0.0
 */
function buddyboss_add_profile_menu() {
	if ( function_exists( 'bp_is_active' ) ) {
		if ( has_nav_menu( 'profile-menu' ) ) {
			wp_nav_menu( array( 'container' => false, 'theme_location' => 'profile-menu', 'items_wrap' => '%3$s' ) );
		}
	}
}

add_action( 'bp_member_options_nav', 'buddyboss_add_profile_menu' );

/**
 * Adds Group menu to BuddyPress groups
 *
 * @since Boss 1.0.0
 */
function buddyboss_add_group_menu() {
	if ( function_exists( 'bp_is_active' ) ) {
		if ( has_nav_menu( 'group-menu' ) ) {
			wp_nav_menu( array( 'container' => false, 'theme_location' => 'group-menu', 'items_wrap' => '%3$s' ) );
		}
	}
}

add_action( 'bp_group_options_nav', 'buddyboss_add_group_menu' );

function bb_unique_array( $a ) {
	return array_unique( array_filter( $a ) );
}

/**
 * Detecting phones
 *
 * @since Boss 1.0.6
 * from detectmobilebrowsers.com
 */
function is_phone() {
	$useragent = $_SERVER[ 'HTTP_USER_AGENT' ];
	if ( preg_match( '/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent ) || preg_match( '/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr( $useragent, 0, 4 ) ) )
		return true;
}

/**
 * Enqueues scripts and styles for front-end.
 *
 * @since Boss 1.0.0
 */
function buddyboss_scripts_styles() {

	/*	 * **************************** SCRIPTS ***************************** */

	global $bp, $buddyboss, $buddyboss_js_params, $rtl;

	$class_sufix = '';
	if ( $rtl ) {
		$class_sufix = '-rtl';
		wp_deregister_style( 'bp-legacy-css-rtl' );
	}

    /**
     * Assign the Boss version to a var
     */
    $theme 		    = wp_get_theme( 'boss' );
    $boss_version   = $theme['Version'];

    /*	 * *************************** STYLES ***************************** */

	// FontAwesome icon fonts. If browsing on a secure connection, use HTTPS.
	// We will only load if our is latest.
	$recent_fwver = (isset(wp_styles()->registered["fontawesome"]))?wp_styles()->registered["fontawesome"]->ver:"0";
	$current_fwver = "4.7.0";
	if(version_compare($current_fwver, $recent_fwver , '>')) {
		wp_deregister_style( 'fontawesome' );
		wp_register_style( 'fontawesome', "//maxcdn.bootstrapcdn.com/font-awesome/{$current_fwver}/css/font-awesome.min.css", false, $current_fwver);
		wp_enqueue_style( 'fontawesome' );
	}

	// Used in js file to detect if we are using only mobile layout
	$only_mobile = false;

	$CSS_URL = boss_get_option( 'boss_minified_css' ) ? get_template_directory_uri() . '/css-compressed' : get_template_directory_uri() . '/css';

	// Main stylesheet
	if ( !is_admin() ) {

		// Activate our main stylesheets. Load FontAwesome first.
		wp_enqueue_style( 'boss-main-global', $CSS_URL . '/main-global' . $class_sufix . '.css', array( 'fontawesome' ), $boss_version, 'all' );

        if ( defined('EM_VERSION') && EM_VERSION ) {
		  wp_enqueue_style( 'boss-events-global', $CSS_URL . '/events/events-global' . $class_sufix . '.css', array( 'fontawesome' ), $boss_version, 'all' );
        }

		// Switch between mobile and desktop
		if ( isset( $_COOKIE[ 'switch_mode' ] ) && ( boss_get_option( 'boss_layout_switcher' ) ) ) {
			if ( $_COOKIE[ 'switch_mode' ] == 'mobile' ) {
				wp_enqueue_style( 'boss-main-mobile', $CSS_URL . '/main-mobile' . $class_sufix . '.css', array( 'fontawesome' ), $boss_version, 'all' );

				if ( defined('EM_VERSION') && EM_VERSION ) {
					wp_enqueue_style( 'boss-events-mobile', $CSS_URL . '/events/events-mobile' . $class_sufix . '.css', array( 'fontawesome' ), $boss_version, 'all' );
                }

				$only_mobile = true;
			} else {
				wp_enqueue_style( 'boss-main-desktop', $CSS_URL . '/main-desktop' . $class_sufix . '.css', array( 'fontawesome' ), $boss_version, 'screen and (min-width: 481px)' );
				wp_enqueue_style( 'boss-main-mobile', $CSS_URL . '/main-mobile' . $class_sufix . '.css', array( 'fontawesome' ), $boss_version, 'screen and (max-width: 480px)' );

				if ( defined('EM_VERSION') && EM_VERSION ) {
                    wp_enqueue_style( 'boss-events-desktop', $CSS_URL . '/events/events-desktop' . $class_sufix . '.css', array( 'fontawesome' ), $boss_version, 'screen and (min-width: 481px)' );
				    wp_enqueue_style( 'boss-events-mobile', $CSS_URL . '/events/events-mobile' . $class_sufix . '.css', array( 'fontawesome' ), $boss_version, 'screen and (max-width: 480px)' );
                }
			}
			// Defaults
		} else {
			if ( is_phone() ) {
				wp_enqueue_style( 'boss-main-mobile', $CSS_URL . '/main-mobile' . $class_sufix . '.css', array( 'fontawesome' ), $boss_version, 'all' );
				if ( defined('EM_VERSION') && EM_VERSION ) {
				wp_enqueue_style( 'boss-events-mobile', $CSS_URL . '/events/events-mobile' . $class_sufix . '.css', array( 'fontawesome' ), $boss_version, 'all' );
                }
				$only_mobile = true;
			} elseif ( wp_is_mobile() ) {
				if ( boss_get_option( 'boss_layout_tablet' ) == 'desktop' ) {
					wp_enqueue_style( 'boss-main-desktop', $CSS_URL . '/main-desktop' . $class_sufix . '.css', array( 'fontawesome' ), $boss_version, 'all' );
					if ( defined('EM_VERSION') && EM_VERSION ) {
					wp_enqueue_style( 'boss-events-desktop', $CSS_URL . '/events/events-desktop' . $class_sufix . '.css', array( 'fontawesome' ), $boss_version, 'all' );
                    }
				} else {
                    wp_enqueue_style( 'boss-main-mobile', $CSS_URL . '/main-mobile' . $class_sufix . '.css', array( 'fontawesome' ), $boss_version, 'all' );

					if ( defined('EM_VERSION') && EM_VERSION ) {
					wp_enqueue_style( 'boss-events-mobile', $CSS_URL . '/events/events-mobile' . $class_sufix . '.css', array( 'fontawesome' ), $boss_version, 'all' );
                    }

					$only_mobile = true;
				}
			} else {
				if ( boss_get_option( 'boss_layout_desktop' ) == 'mobile' ) {
					wp_enqueue_style( 'boss-main-mobile', $CSS_URL . '/main-mobile' . $class_sufix . '.css', array( 'fontawesome' ), $boss_version, 'all' );

					if ( defined('EM_VERSION') && EM_VERSION ) {
					wp_enqueue_style( 'boss-events-mobile', $CSS_URL . '/events/events-mobile' . $class_sufix . '.css', array( 'fontawesome' ), $boss_version, 'all' );
                    }

					$only_mobile = true;
				} else {
					wp_enqueue_style( 'boss-main-desktop', $CSS_URL . '/main-desktop' . $class_sufix . '.css', array( 'fontawesome' ), $boss_version, 'screen and (min-width: 481px)' );

					if ( defined('EM_VERSION') && EM_VERSION ) {
					wp_enqueue_style( 'boss-events-desktop', $CSS_URL . '/events/events-desktop' . $class_sufix . '.css', array( 'fontawesome' ), $boss_version, 'screen and (min-width: 481px)' );
                    }
				}
			}

			// Media query fallback
			if ( !wp_script_is( 'boss-main-mobile', 'enqueued' ) ) {
				wp_enqueue_style( 'boss-main-mobile', $CSS_URL . '/main-mobile' . $class_sufix . '.css', array( 'fontawesome' ), $boss_version, 'screen and (max-width: 480px)' );
			}
			if ( !wp_script_is( 'boss-events-mobile', 'enqueued' ) && defined('EM_VERSION') && EM_VERSION ) {
				wp_enqueue_style( 'boss-events-mobile', $CSS_URL . '/events/events-mobile' . $class_sufix . '.css', array( 'fontawesome' ), $boss_version, 'screen and (max-width: 480px)' );
			}
		}

        global $learner;

        if($learner){
            wp_enqueue_style( 'social-learner', $CSS_URL . '/social-learner' . $class_sufix . '.css', array( 'fontawesome' ), $boss_version, 'all' );
        }


        if(!empty($GLOBALS['badgeos'])){
            wp_enqueue_style( 'boss-badgeos', $CSS_URL . '/badgeos/badgeos' . $class_sufix . '.css', array( 'fontawesome' ), $boss_version, 'all' );
        }

        if( '2' == boss_get_option('boss_header') ){
            wp_enqueue_style( 'header-style-2', $CSS_URL . '/header-style-2' . $class_sufix . '.css', array( 'fontawesome' ), $boss_version, 'all' );
        }
	}

	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	/*
	 * Adds mobile JavaScript functionality.
	 */
	if ( !is_admin() ) {
		if ( $rtl ) {
			wp_enqueue_script( 'idangerous-swiper', get_template_directory_uri() . '/js/idangerous.rtl.swiper.js', array( 'jquery' ), '1.9.2', true );
		} else {
			wp_enqueue_script( 'idangerous-swiper', get_template_directory_uri() . '/js/idangerous.swiper.js', array( 'jquery' ), '1.9.2', true );
		}
	}

	$user_profile = null;

	if ( is_object( $bp ) && is_object( $bp->displayed_user ) && !empty( $bp->displayed_user->domain ) ) {
		$user_profile = $bp->displayed_user->domain;
	}

	/*
	 * Adds UI scripts.
	 */
	if ( !is_admin() ) {

		//lets remove these three on next version.
		// JS > Plupload
		//wp_deregister_script( 'moxie' );
		//wp_deregister_script( 'plupload' );

		wp_enqueue_script( 'jquery-effects-core' );
		wp_enqueue_script( 'jquery-ui-tabs' );
		wp_enqueue_script( 'jquery-ui-accordion' );
		wp_enqueue_script( 'jquery-ui-progressbar' );
		wp_enqueue_script( 'jquery-ui-tooltip' );
		//wp_enqueue_script( 'moxie', get_template_directory_uri() . '/js/plupload/moxie.min.js', array( 'jquery' ), '1.2.1' );
		//wp_enqueue_script( 'plupload', get_template_directory_uri() . '/js/plupload/plupload.dev.js', array( 'jquery', 'moxie' ), $boss_version );

		//Heartbeat
		wp_enqueue_script( 'heartbeat' );

		$translation_array = array(
			'only_mobile'			 => $only_mobile,
			'comment_placeholder'	 => __( 'Your Comment...', 'boss' ),
			'view_desktop'			 => __( 'View as Desktop', 'boss' ),
			'view_mobile'			 => __( 'View as Mobile', 'boss' )
		);


		// Add BuddyBoss words that we need to use in JS to the end of the page
		// so they can be translataed and still used.
		$buddyboss_js_vars = array(
			'select_label'	 => __( 'Show:', 'boss' ),
			'post_in_label'	 => __( 'Post in:', 'boss' ),
			'tpl_url'		 => get_template_directory_uri(),
			'child_url'		 => get_stylesheet_directory_uri(),
			'user_profile'	 => $user_profile,
            'days'           =>  array ( __('Monday', 'boss' ), __('Tuesday', 'boss' ), __('Wednesday', 'boss' ), __('Thursday', 'boss' ), __('Friday', 'boss' ), __('Saturday', 'boss' ), __('Sunday', 'boss' ))
		);

		$buddyboss_js_vars = apply_filters( 'buddyboss_js_vars', $buddyboss_js_vars );

		if ( boss_get_option( 'boss_minified_js' ) ) {
			wp_register_script( 'boss-main-min', get_template_directory_uri() . '/js/compressed/boss-main-min.js', array( 'jquery' ), $boss_version, true );
			wp_localize_script( 'boss-main-min', 'translation', $translation_array );
			wp_localize_script( 'boss-main-min', 'BuddyBossOptions', $buddyboss_js_vars );
			wp_enqueue_script( 'boss-main-min' );
		} else {

			/* Adds custom BuddyBoss JavaScript functionality. */

			wp_register_script( 'buddyboss-main', get_template_directory_uri() . '/js/buddyboss.js', array( 'jquery' ), $boss_version, true );

			wp_localize_script( 'buddyboss-main', 'translation', $translation_array );
			wp_localize_script( 'buddyboss-main', 'BuddyBossOptions', $buddyboss_js_vars );

			wp_enqueue_script( 'buddyboss-modernizr', get_template_directory_uri() . '/js/modernizr.min.js', false, '2.7.1', false );
			wp_enqueue_script( 'selectboxes', get_template_directory_uri() . '/js/ui-scripts/selectboxes.js', array(), '1.1.7', true );
			wp_enqueue_script( 'fitvids', get_template_directory_uri() . '/js/ui-scripts/fitvids.js', array(), '1.1', true );
			wp_enqueue_script( 'cookie', get_template_directory_uri() . '/js/ui-scripts/jquery.cookie.js', array(), '1.4.1', true );
			wp_enqueue_script( 'superfish', get_template_directory_uri() . '/js/ui-scripts/superfish.js', array(), '1.7.4', true );
			wp_enqueue_script( 'hoverIntent', get_template_directory_uri() . '/js/ui-scripts/hoverIntent.js', array(), '1.8.0', true );
			wp_enqueue_script( 'imagesLoaded', get_template_directory_uri() . '/js/ui-scripts/imagesloaded.pkgd.js', array(), '3.1.8', true );
			wp_enqueue_script( 'resize', get_template_directory_uri() . '/js/ui-scripts/resize.js', array(), '1.1', true );
			wp_enqueue_script( 'growl', get_template_directory_uri() . '/js/jquery.growl.js', array(), '1.2.4', true );
			wp_enqueue_script( 'buddyboss-slider', get_template_directory_uri() . '/js/slider/slick.min.js', array( 'jquery' ), '1.1.2', true );

			//lets remove these two on next version.
			//	wp_enqueue_script( 'moxie', get_template_directory_uri() . '/js/plupload/moxie.min.js', array( 'jquery' ), '1.2.1' );
			//	wp_enqueue_script( 'plupload', get_template_directory_uri() . '/js/plupload/plupload.dev.js', array( 'jquery', 'moxie' ), '2.1.3' );

			wp_enqueue_script( 'buddyboss-main' );

            if( '2' == boss_get_option('boss_header') ){
                wp_enqueue_script( 'social-learner', get_template_directory_uri() . '/js/social-learner.js', false, $boss_version, false );
            }

			if ( defined('EM_VERSION') && EM_VERSION ) {
                wp_enqueue_script( 'boss-events', get_template_directory_uri() . '/js/boss-events.js', false, $boss_version, true );
            }

		}
	}

	/**
	 * If we're on the BuddyPress messages component we need to load jQuery Migrate first
	 * before bgiframe, so let's take care of that
	 */
	if ( function_exists( 'bp_is_messages_component' ) && bp_is_messages_component() && bp_is_current_action( 'compose' ) ) {
		$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		wp_dequeue_script( 'bp-jquery-bgiframe' );
		wp_enqueue_script( 'bp-jquery-bgiframe', BP_PLUGIN_URL . "bp-messages/js/autocomplete/jquery.bgiframe{$min}.js", array(), bp_get_version() );
	}

	/*
	 * Load our BuddyPress styles manually.
	 * We need to deregister the BuddyPress styles first then load our own.
	 * We need to do this for proper CSS load order.
	 */
	if ( $buddyboss->buddypress_active && !is_admin() ) {
		// Deregister the built-in BuddyPress stylesheet
		wp_deregister_style( 'bp-child-css' );
		wp_deregister_style( 'bp-parent-css' );
		wp_deregister_style( 'bp-legacy-css' );
	}

	/*
	 * Load our bbPress styles manually.
	 * We need to deregister the bbPress style first then load our own.
	 * We need to do this for proper CSS load order.
	 */
	if ( $buddyboss->bbpress_active && !is_admin() ) {
		// Deregister the built-in bbPress stylesheet
		wp_deregister_style( 'bbp-child-bbpress' );
		wp_deregister_style( 'bbp-parent-bbpress' );
		wp_deregister_style( 'bbp-default' );
	}

	// Deregister the wp admin bar stylesheet
	if ( !boss_show_adminbar() ) {
		wp_deregister_style( 'admin-bar' );
	}
}

add_action( 'wp_enqueue_scripts', 'buddyboss_scripts_styles' );

/**
 * We need to enqueue jQuery migrate before anything else for legacy
 * plugin support.
 * WordPress version 3.9 onwards already includes jquery 1.11.n version, which we required,
 * and jquery migrate is also properly enqueued.
 * So we dont need to do anything for WP versions greater than 3.9.
 *
 * @package  Boss
 * @since    Boss 1.0.0
 */
function buddyboss_scripts_jquery_migrate() {
	global $wp_version;
	if ( $wp_version >= 3.9 ) {
		return;
	}

	if ( !is_admin() ) {

		// Deregister the built-in version of jQuery
		wp_deregister_script( 'jquery' );
		// Register jQuery. If browsing on a secure connection, use HTTPS.
		wp_register_script( 'jquery', "//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js", false, null );

		// Activate the jQuery script
		wp_enqueue_script( 'jquery' );

		// Activate the jQuery Migrate script from WordPress
		wp_enqueue_script( 'jquery-migrate', false, array( 'jquery' ) );
	}
}

add_action( 'wp_enqueue_scripts', 'buddyboss_scripts_jquery_migrate', 0 );

/**
 * Removes CSS in the header so we can keep buddyboss clean from admin bar stuff.
 * Note :- we can fully disable admin-bar too but we are using its nodes for BuddyPanel.
 *
 * @package  Boss
 * @since    Boss 1.0.0
 */
function buddyboss_remove_adminbar_inline_styles() {
	if ( !is_admin() && !boss_show_adminbar() ) {

		remove_action( 'wp_head', 'wp_admin_bar_header' );
		remove_action( 'wp_head', '_admin_bar_bump_cb' );
	}
}

add_action( 'wp_head', 'buddyboss_remove_adminbar_inline_styles', 9 );

/**
 * JavaScript mobile init
 *
 * @package  Boss
 * @since    Boss 1.0.0
 */
function buddyboss_mobile_js_init() {
	?>
	<!--
	BuddyBoss Mobile Init
	/////////////////////
	-->
	<div id="mobile-check"></div><!-- #mobile-check -->
	<?php
}

add_action( 'buddyboss_before_header', 'buddyboss_mobile_js_init' );

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
 * @package  Boss
 * @since    Boss 1.0.0
 * @see bp_dtheme_add_nojs_body_class()
 */
function buddyboss_remove_nojs_body_class() {
	?><script type="text/JavaScript">//<![CDATA[
		(function(){var c=document.body.className;c=c.replace(/no-js/,'js');document.body.className=c;})();
		$=jQuery.noConflict();
		//]]></script>
	<?php
}

add_action( 'buddyboss_before_header', 'buddyboss_remove_nojs_body_class' );

/**
 * Determines if the currently logged in user is an admin
 * TODO: This should check in a better way, by capability not role title and
 * this function probably belongs in a functions.php file or utility.php
 */
function buddyboss_is_admin() {
	return is_user_logged_in() && current_user_can( 'administrator' );
}

function buddyboss_members_latest_update_filter( $latest ) {
	$latest = str_replace( array( '- &quot;', '&quot;' ), '', $latest );

	return $latest;
}

add_filter( 'bp_get_activity_latest_update_excerpt', 'buddyboss_members_latest_update_filter' );

/**
 * Moves sitewide notices to the header
 *
 * Since BuddyPress doesn't give us access to BP_Legacy, let
 * us begin the hacking
 *
 * @since Boss 1.0.0
 */
function buddyboss_fix_sitewide_notices() {
	// Check if BP_Legacy is being used and messages are active
	if ( class_exists( 'BP_Legacy' ) && bp_is_active( 'messages' ) ) {
		remove_action( 'wp_footer', array( 'BP_Legacy', 'sitewide_notices' ), 9999 );

		global $wp_filter;

		// Get the wp_footer callbacks
		$footer = !empty( $wp_filter[ 'wp_footer' ] ) && is_array( $wp_filter[ 'wp_footer' ] ) ? $wp_filter[ 'wp_footer' ] : false;

		// Make sure we have some
		if ( is_array( $footer ) && count( $footer ) > 0 ) {
			$new_footer_cbs = array();

			// Cycle through each callback and remove any with sitewide_notices in it,
			// then replace and add to the header
			foreach ( $footer as $priority => $footer_cb ) {
				if ( is_array( $footer_cb ) && !empty( $footer_cb ) ) {
					$keys	 = array_keys( $footer_cb );
					$key	 = $keys[ 0 ];

					if ( stristr( $key, 'sitewide_notices' ) ) {
						add_action( 'buddyboss_inside_wrapper', 'buddyboss_print_sitewide_notices', 9999 );
					} else {
						$new_footer_cbs[ $priority ] = $footer_cb;
					}
				} else {
					$new_footer_cbs[ $priority ] = $footer_cb;
				}
			}

			$wp_filter[ 'wp_footer' ] = $new_footer_cbs;
		}
	}
}

add_action( 'wp', 'buddyboss_fix_sitewide_notices' );

/**
 * Prints sitewide notices (used in the header, by default is in footer)
 */
function buddyboss_print_sitewide_notices() {
	@BP_Legacy::sitewide_notices();
}

/**
 * Load admin bar in header we need it to load on header for getting nodes to use on left panel but wont show it.
 *
 */
function buddyboss_admin_bar_in_header() {
	if ( !is_admin() ) {
		remove_action( 'wp_footer', 'wp_admin_bar_render', 1000 );
		add_action( 'buddyboss_before_header', 'wp_admin_bar_render' );
	}
}

add_action( 'wp', 'buddyboss_admin_bar_in_header' );

/**
 * Makes our wp_nav_menu() fallback -- wp_page_menu() -- show a home link.
 *
 * @since Boss 1.0.0
 */
function buddyboss_page_menu_args( $args ) {
	$args[ 'show_home' ] = true;
	return $args;
}

add_filter( 'wp_page_menu_args', 'buddyboss_page_menu_args' );

/**
 * Registers all of our widget areas.
 *
 * @since Boss 1.0.0
 */
function buddyboss_widgets_init() {
	// Area 1, located in the pages and posts right column.
	register_sidebar( array(
		'name'			 => 'Page Sidebar (default)',
		'id'			 => 'sidebar',
		'description'	 => 'The default Page/Post widget area. Right column is always present.',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h3 class="widgettitle">',
		'after_title'	 => '</h3>'
	) );

	// Area 2, located in the homepage right column.
	register_sidebar( array(
		'name'			 => 'Homepage',
		'id'			 => 'home-right',
		'description'	 => 'The Homepage widget area. Right column only appears if widgets are added.',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h3 class="widgettitle">',
		'after_title'	 => '</h3>'
	) );

	// Area 3, located in the Members Directory right column. Right column only appears if widgets are added.
	register_sidebar( array(
		'name'			 => 'Members &rarr; Directory',
		'id'			 => 'members',
		'description'	 => 'The Members Directory widget area. Right column only appears if widgets are added.',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h3 class="widgettitle">',
		'after_title'	 => '</h3>'
	) );
	// Area 4, located in the Individual Member Profile right column. Right column only appears if widgets are added.
	register_sidebar( array(
		'name'			 => 'Member &rarr; Single Profile',
		'id'			 => 'profile',
		'description'	 => 'The Individual Profile widget area. Right column only appears if widgets are added.',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h3 class="widgettitle">',
		'after_title'	 => '</h3>'
	) );
	// Area 5, located in the Groups Directory right column. Right column only appears if widgets are added.
	register_sidebar( array(
		'name'			 => 'Groups &rarr; Directory',
		'id'			 => 'groups',
		'description'	 => 'The Groups Directory widget area. Right column only appears if widgets are added.',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h3 class="widgettitle">',
		'after_title'	 => '</h3>'
	) );
	// Area 6, located in the Individual Group right column. Right column only appears if widgets are added.
	register_sidebar( array(
		'name'			 => 'Group &rarr; Single Group',
		'id'			 => 'group',
		'description'	 => 'The Individual Group widget area. Right column only appears if widgets are added.',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s"><div class="inner">',
		'after_widget'	 => '</div></aside>',
		'before_title'	 => '<h3 class="widgettitle">',
		'after_title'	 => '</h3>'
	) );
	// Area 7, located in the Activity Directory right column. Right column only appears if widgets are added.
	register_sidebar( array(
		'name'			 => 'Activity &rarr; Directory',
		'id'			 => 'activity',
		'description'	 => 'The Activity Directory widget area. Right column only appears if widgets are added.',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h3 class="widgettitle">',
		'after_title'	 => '</h3>'
	) );
	// Area 8, located in the Forums Directory right column. Right column only appears if widgets are added.
	register_sidebar( array(
		'name'			 => 'Forums &rarr; Directory & Single',
		'id'			 => 'forums',
		'description'	 => 'The Forums Directory widget area. Right column only appears if widgets are added.',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h3 class="widgettitle">',
		'after_title'	 => '</h3>'
	) );
	// Area 9, located in the Members Directory right column. Right column only appears if widgets are added.
	register_sidebar( array(
		'name'			 => 'Blogs &rarr; Directory (multisite)',
		'id'			 => 'blogs',
		'description'	 => 'The Blogs Directory widget area (only for Multisite). Right column only appears if widgets are added.',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h3 class="widgettitle">',
		'after_title'	 => '</h3>'
	) );
	// Area 10, located in the Footer column 1. Only appears if widgets are added.
	register_sidebar( array(
		'name'			 => 'Footer #1',
		'id'			 => 'footer-1',
		'description'	 => 'The first footer widget area. Only appears if widgets are added.',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h4 class="widgettitle">',
		'after_title'	 => '</h4>'
	) );
	// Area 11, located in the Footer column 2. Only appears if widgets are added.
	register_sidebar( array(
		'name'			 => 'Footer #2',
		'id'			 => 'footer-2',
		'description'	 => 'The second footer widget area. Only appears if widgets are added.',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h4 class="widgettitle">',
		'after_title'	 => '</h4>'
	) );
	// Area 12, located in the Footer column 3. Only appears if widgets are added.
	register_sidebar( array(
		'name'			 => 'Footer #3',
		'id'			 => 'footer-3',
		'description'	 => 'The third footer widget area. Only appears if widgets are added.',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h4 class="widgettitle">',
		'after_title'	 => '</h4>'
	) );
	// Area 13, located in the Footer column 4. Only appears if widgets are added.
	register_sidebar( array(
		'name'			 => 'Footer #4',
		'id'			 => 'footer-4',
		'description'	 => 'The fourth footer widget area. Only appears if widgets are added.',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h4 class="widgettitle">',
		'after_title'	 => '</h4>'
	) );
	// Area 14, dedicated sidebar for WooCommerce
	register_sidebar( array(
		'name'			 => 'WooCommerce &rarr; Shop',
		'id'			 => 'woo_sidebar',
		'description'	 => 'Only display on shop page',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h4 class="widgettitle">',
		'after_title'	 => '</h4>',
	) );
}

add_action( 'widgets_init', 'buddyboss_widgets_init' );

if ( !function_exists( 'buddyboss_content_nav' ) ) :

	/**
	 * Displays navigation to next/previous pages when applicable.
	 *
	 * @since Boss 1.0.0
	 */
	function buddyboss_content_nav( $nav_id ) {
		global $wp_query;

		if ( $wp_query->max_num_pages > 1 ) :
			?>
			<nav id="<?php echo esc_attr( $nav_id ); ?>" class="navigation" role="navigation">
				<h3 class="assistive-text"><?php _e( 'Post navigation', 'boss' ); ?></h3>
				<div class="nav-previous alignleft"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'boss' ) ); ?></div>
				<div class="nav-next alignright"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'boss' ) ); ?></div>
			</nav><!-- #<?php echo esc_attr( $nav_id ); ?> .navigation -->
			<?php
		endif;
	}

endif;

if ( !function_exists( 'buddyboss_entry_meta' ) ) :

	/**
	 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
	 *
	 * Create your own buddyboss_entry_meta() to override in a child theme.
	 *
	 * @since Boss 1.0.0
	 */
	function buddyboss_entry_meta( $show_author = true, $show_date = true, $show_comment_info = true ) {
		// Translators: used between list items, there is a space after the comma.
		$categories_list = get_the_category_list( __( ', ', 'boss' ) );

		// Translators: used between list items, there is a space after the comma.
		$tag_list = get_the_tag_list( '', __( ', ', 'boss' ) );

		$date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark" class="post-date fa fa-clock-o"><time class="entry-date" datetime="%3$s">%4$s</time></a>', esc_url( get_permalink() ), esc_attr( get_the_time() ), esc_attr( get_the_date( 'c' ) ), esc_html( get_the_date() )
		);

		$author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), esc_attr( sprintf( __( 'View all posts by %s', 'boss' ), get_the_author() ) ), get_the_author()
		);

		if ( function_exists( 'get_avatar' ) ) {
			$avatar = sprintf( '<a href="%1$s" rel="bookmark">%2$s</a>', esc_url( get_permalink() ), get_avatar( get_the_author_meta( 'email' ), 55 )
			);
		}

		if ( $show_author ) {
			echo '<span class="post-author">';
			echo $avatar;
			echo $author;
			echo '</span>';
		}

		if ( $show_date ) {
			echo $date;
		}

		if ( $show_comment_info ) {
			if ( comments_open() ) :
				?>
				<!-- reply link -->
				<span class="comments-link fa fa-comment-o">
					<?php comments_popup_link( '<span class="leave-reply">' . __( '0 comments', 'boss' ) . '</span>', __( '1 comment', 'boss' ), __( '% comments', 'boss' ) ); ?>
				</span><!-- .comments-link -->
				<?php
			endif; // comments_open()
		}
	}

endif;

/**
 * Extends the default WordPress body classes.
 *
 * @since Boss 1.0.0
 *
 * @param array Existing class values.
 * @return array Filtered class values.
 */
function buddyboss_body_class( $classes ) {
	global $wp_customize;

	if ( !empty( $wp_customize ) ) {
		$classes[] = 'wp-customizer';
	}
	if ( !is_multi_author() )
		$classes[] = 'single-author';

	if ( current_user_can( 'manage_options' ) ) {
		$classes[] = 'role-admin';
	}

	if ( bp_is_user_activity() || ( bp_is_group_home() && bp_is_active( 'activity' ) ) || bp_is_group_activity() || bp_is_current_component( 'activity' ) ) {
		$classes[] = 'has-activity';
	}

	return array_unique( $classes );
}

if ( buddyboss_is_bp_active() ) {
	add_filter( 'body_class', 'buddyboss_body_class' );
}

/**
 * Adjusts content_width value for full-width and single image attachment
 * templates, and when there are no active widgets in the sidebar.
 *
 * @since Boss 1.0.0
 */
function buddyboss_content_width() {
	if ( is_page_template( 'full-width.php' ) || is_attachment() || !is_active_sidebar( 'sidebar-1' ) ) {
		global $content_width;
		$content_width = 960;
	}
}

add_action( 'template_redirect', 'buddyboss_content_width' );



/* * **************************** LOGIN FUNCTIONS ***************************** */

function buddyboss_is_login_page() {
	return in_array( $GLOBALS[ 'pagenow' ], array( 'wp-login.php', 'wp-register.php' ) );
}

add_filter( 'login_redirect', 'buddyboss_redirect_previous_page', 10, 3 );

function buddyboss_redirect_previous_page( $redirect_to, $request, $user ) {
	if ( buddyboss_is_bp_active() ) {
		$bp_pages = bp_get_option( 'bp-pages' );

		$activate_page_id = !empty( $bp_pages ) && isset( $bp_pages[ 'activate' ] ) ? $bp_pages[ 'activate' ] : null;

		if ( (int) $activate_page_id <= 0 ) {
			return $redirect_to;
		}

		$activate_page = get_post( $activate_page_id );

		if ( empty( $activate_page ) || empty( $activate_page->post_name ) ) {
			return $redirect_to;
		}

		$activate_page_slug = $activate_page->post_name;

		if ( strpos( $request, '/' . $activate_page_slug ) !== false ) {
			$redirect_to = home_url();
		}
	}

	$request = isset( $_SERVER[ "HTTP_REFERER" ] ) && !empty( $_SERVER[ "HTTP_REFERER" ] ) ? $_SERVER[ "HTTP_REFERER" ] : false;

	if ( !$request ) {
		return $redirect_to;
	}

	$req_parts	 = explode( '/', $request );
	$req_part	 = array_pop( $req_parts );

	if ( substr( $req_part, 0, 3 ) == 'wp-' ) {
		return $redirect_to;
	}

	$request = str_replace( array( '?loggedout=true', '&loggedout=true' ), '', $request );

	return $request;
}

/**
 * Custom Login Logo and Helper scripts
 *
 * @since Boss 1.0.0
 */
function buddyboss_custom_login_scripts() {
	//placeholders
	echo '<script>
        document.addEventListener("DOMContentLoaded", function(event) {
            document.getElementById("user_login").setAttribute( "placeholder", "' . __( "Username", "boss" ) . '" );
            document.getElementById("user_pass").setAttribute( "placeholder", "' . __( "Password", "boss" ) . '" );

            var input = document.querySelectorAll(".forgetmenot input")[0];
            var label = document.querySelectorAll(".forgetmenot label")[0];
            var text = document.querySelectorAll(".forgetmenot label")[0].innerHTML.replace(/<[^>]*>/g, "");

            label.innerHTML = "";

            label.appendChild(input); ;

            label.innerHTML += "<strong>"+ text +"</strong>";

            labels = document.querySelectorAll("label");

            for (var i = labels.length - 1; i >= 0; i--)
            {
                var child = labels[i].firstChild, nextSibling;

                while (child) {
                    nextSibling = child.nextSibling;
                    if (child.nodeType == 3) {
                        child.parentNode.removeChild(child);
                    }
                    child = nextSibling;
                }
            }

        });

    </script>';

	$show		 = boss_get_option( 'boss_custom_login' );
	$logo_id	 = boss_get_option( 'boss_admin_login_logo', 'id' );
	$logo_img	 = wp_get_attachment_image_src( $logo_id, 'full' );

	// Logo styles updated for the best view
	if ( $show && $logo_id ) {
		$boss_wp_loginbox_width	 = 312;
		$boss_logo_url			 = $logo_img[ 0 ];
		$boss_logo_width		 = $logo_img[ 1 ];
		$boss_logo_height		 = $logo_img[ 2 ];

		if ( $boss_logo_width > $boss_wp_loginbox_width ) {
			$ratio					 = $boss_logo_height / $boss_logo_width;
			$boss_logo_height		 = ceil( $ratio * $boss_wp_loginbox_width );
			$boss_logo_width		 = $boss_wp_loginbox_width;
			$boss_background_size	 = 'contain';
		} else {
			$boss_background_size = 'auto';
		}

		echo '<style type="text/css">
				#login h1 a { background: url( ' . esc_url( $boss_logo_url ) . ' ) no-repeat 50% 0;
                background-size: ' . esc_attr( $boss_background_size ) . ';
				overflow: hidden;
				text-indent: -9999px;
				display: block;';

		if ( $boss_logo_width && $boss_logo_height ) {
			echo 'height: ' . esc_attr( $boss_logo_height ) . 'px;
					width: ' . esc_attr( $boss_logo_width ) . 'px;
					margin: 0 auto;
					padding: 0;
				}';
		}

		echo '</style>';
	}

	$title_font = boss_get_option( 'boss_site_title_font_family' );

	if ( $title_font ) {
		$font_family = $title_font[ 'font-family' ];
		$font_size	 = $title_font[ 'font-size' ];
		$font_weight = ( $title_font[ 'font-weight' ] ) ? ':' . $title_font[ 'font-weight' ] : '';
		$font_style	 = $title_font[ 'font-style' ];
		$subsets	 = ( $title_font[ 'subsets' ] ) ? '&amp;subset=' . $title_font[ 'subsets' ] : '';
		$google		 = $title_font[ 'google' ];

		if ( $google != 'false' && $font_family ) {
			$link = '//fonts.googleapis.com/css?family=' . urlencode( $font_family ) . $font_weight . $subsets;
			echo '<link href="' . $link . '" rel="stylesheet" type="text/css">';
		}
	}
	?>

	<style type="text/css">
		.oneall_social_login {
			padding-top: 20px;
		}
	</style>

	<?php
	if ( boss_get_option( 'boss_custom_login' ) ) {
		?>

		<style type="text/css">
			body.login {
				background-color: <?php echo esc_attr( boss_get_option( 'boss_admin_screen_background_color' ) ); ?> !important;
			}

			<?php if ( $font_family ) { ?>
				#login h1 a {
					font-family: <?php echo $font_family; ?>;
					font-size: <?php echo $font_size; ?>;
					font-weight: <?php echo $title_font[ 'font-weight' ]; ?>;
					<?php if ( $font_style ) { ?>
						font-style: <?php echo $font_style; ?>;
					<?php } ?>
				}
			<?php } ?>

			.login #nav, .login #backtoblog a, .login #nav a, .login label, .login p.indicator-hint {
				color: <?php echo esc_attr( boss_get_option( 'boss_admin_screen_text_color' ) ); ?> !important;
			}

			.login #backtoblog a:hover, .login #nav a:hover, .login h1 a:hover {
				color: <?php echo esc_attr( boss_get_option( 'boss_admin_screen_button_color' ) ); ?> !important;
			}

			.login form .forgetmenot input[type="checkbox"]:checked + strong:before,
			#login form p.submit input {
				background-color: <?php echo esc_attr( boss_get_option( 'boss_admin_screen_button_color' ) ); ?> !important;
				box-shadow: none;
			}

		</style>

		<?php
	}
}

add_action( 'login_head', 'buddyboss_custom_login_scripts', 1 );

/**
 * Custom Login Link
 *
 * @since Boss 1.0.0
 */
function change_wp_login_url() {
	return home_url();
}

function change_wp_login_title() {
	get_option( 'blogname' );
}

add_filter( 'login_headerurl', 'change_wp_login_url' );
add_filter( 'login_headertitle', 'change_wp_login_title' );


/*
 * Adds Login form style.
 */

function buddyboss_login_stylesheet() {
	global $rtl;

	$class_sufix = '';
	if ( $rtl ) {
		$class_sufix = '-rtl';
	}

    /**
     * Assign the Boss version to a var
     */
    $theme 		    = wp_get_theme( 'boss' );
    $boss_version   = $theme['Version'];

	if ( boss_get_option( 'boss_custom_login' ) ) {
		wp_enqueue_style( 'custom-login', get_template_directory_uri() . '/css/style-login' . $class_sufix . '.css', false, $boss_version, 'all' );
	}
}

add_action( 'login_enqueue_scripts', 'buddyboss_login_stylesheet' );


/* * **************************** ADMIN BAR FUNCTIONS ***************************** */

/**
 * Strip all waste and unuseful nodes and keep components only and memory for notification
 * @since Boss 1.0.0
 * */
function buddyboss_strip_unnecessary_admin_bar_nodes( &$wp_admin_bar ) {
	global $admin_bar_myaccount, $bb_adminbar_notifications, $bb_adminbar_messages, $bb_adminbar_friends, $bp;

	$dontalter_adminbar = apply_filters( 'boss_prevent_adminbar_processing', is_admin() );
	if ( $dontalter_adminbar ) { //nothing to do on admin
		return;
	}

	$nodes = $wp_admin_bar->get_nodes();

	$bb_adminbar_notifications[] = @$nodes[ "bp-notifications" ];

	$current_href = $_SERVER[ "HTTP_HOST" ] . $_SERVER[ "REQUEST_URI" ];

	foreach ( $nodes as $name => $node ) {

		if ( $node->parent == "bp-notifications" ) {
			$bb_adminbar_notifications[] = $node;
		}

		if ( $node->parent == "" || $node->parent == "top-secondary" AND $node->id != "top-secondary" ) {
			if ( $node->id == "my-account" ) {
				continue;
			}
		}

		//adding active for parent link
		if ( $node->id == "my-account-xprofile-edit" ||
		$node->id == "my-account-groups-create" ) {

			if ( strpos( "http://" . $current_href, $node->href ) !== false ||
			strpos( "https://" . $current_href, $node->href ) !== false ) {
				buddyboss_adminbar_item_add_active( $wp_admin_bar, $name );
			}
		}

		if ( $node->id == "my-account-activity-personal" ) {
			if ( $bp->current_component == "activity" AND $bp->current_action == "just-me" AND bp_displayed_user_id() == get_current_user_id() ) {
				buddyboss_adminbar_item_add_active( $wp_admin_bar, $name );
			}
		}

		if ( $node->id == "my-account-xprofile-public" ) {
			if ( $bp->current_component == "profile" AND $bp->current_action == "public" AND bp_displayed_user_id() == get_current_user_id() ) {
				buddyboss_adminbar_item_add_active( $wp_admin_bar, $name );
			}
		}

		if ( $node->id == "my-account-messages-inbox" ) {
			$bb_adminbar_messages[] = $node;
			if ( $bp->current_component == "messages" AND $bp->current_action == "inbox" ) {
				buddyboss_adminbar_item_add_active( $wp_admin_bar, $name );
			}
		}

		//adding active for parent link
		if ( $node->id == "my-account-friends-requests" ) {
			$bb_adminbar_friends[] = $node;
		}

		//adding active for child link
		if ( $node->id == "my-account-settings-general" ) {
			if ( $bp->current_component == "settings" ||
			$bp->current_action == "general" ) {
				buddyboss_adminbar_item_add_active( $wp_admin_bar, $name );
			}
		}

		//add active class if it has viewing page href
		if ( !empty( $node->href ) ) {
			if (
			( "http://" . $current_href == $node->href || "https://" . $current_href == $node->href ) ||
			( $node->id = 'my-account-xprofile-edit' && strpos( "http://" . $current_href, $node->href ) === 0 )
			) {
				buddyboss_adminbar_item_add_active( $wp_admin_bar, $name );
				//add active class to its parent
				if ( $node->parent != '' && $node->parent != 'my-account-buddypress' ) {
					foreach ( $nodes as $name_inner => $node_inner ) {
						if ( $node_inner->id == $node->parent ) {
							buddyboss_adminbar_item_add_active( $wp_admin_bar, $name_inner );
							break;
						}
					}
				}
			}
		}
	}
}

add_action( 'admin_bar_menu', 'buddyboss_strip_unnecessary_admin_bar_nodes', 999 );

function buddyboss_adminbar_item_add_active( &$wp_admin_bar, $name ) {
	$gnode = $wp_admin_bar->get_node( $name );
	if ( $gnode ) {
		$gnode->meta[ "class" ] = isset( $gnode->meta[ "class" ] ) ? $gnode->meta[ "class" ] . " active" : " active";
		$wp_admin_bar->add_node( $gnode ); //update
	}
}

/**
 * Store adminbar specific nodes to use later for buddyboss
 * @since Boss 1.0.0
 * */
function buddyboss_memory_admin_bar_nodes() {
	static $bb_memory_admin_bar_step;
	global $bb_adminbar_myaccount;

	$dontalter_adminbar = apply_filters( 'boss_prevent_adminbar_processing', is_admin() );
	if ( $dontalter_adminbar ) { //nothing to do on admin
		return;
	}

	if ( !empty( $bb_adminbar_myaccount ) ) { //avoid multiple run
		return false;
	}

	if ( empty( $bb_memory_admin_bar_step ) ) {
		$bb_memory_admin_bar_step = 1;
		ob_start();
	} else {
		$admin_bar_output = ob_get_contents();
		ob_end_clean();

		if ( boss_show_adminbar() )
			echo $admin_bar_output;

		//strip some waste
		$admin_bar_output = str_replace( array( 'id="wpadminbar"',
			'role="navigation"',
			'class ',
			'class="nojq nojs"',
			'class="quicklinks" id="wp-toolbar"',
			'id="wp-admin-bar-top-secondary" class="ab-top-secondary ab-top-menu"',
		), '', $admin_bar_output );

		//remove screen shortcut link
		$admin_bar_output	 = @explode( '<a class="screen-reader-shortcut"', $admin_bar_output, 2 );
		$admin_bar_output2	 = "";
		if ( count( $admin_bar_output ) > 1 ) {
			$admin_bar_output2 = @explode( "</a>", $admin_bar_output[ 1 ], 2 );
			if ( count( $admin_bar_output2 ) > 1 ) {
				$admin_bar_output2 = $admin_bar_output2[ 1 ];
			}
		}
		$admin_bar_output = $admin_bar_output[ 0 ] . $admin_bar_output2;

		//remove screen logout link
		$admin_bar_output	 = @explode( '<a class="screen-reader-shortcut"', $admin_bar_output, 2 );
		$admin_bar_output2	 = "";
		if ( count( $admin_bar_output ) > 1 ) {
			$admin_bar_output2 = @explode( "</a>", $admin_bar_output[ 1 ], 2 );
			if ( count( $admin_bar_output2 ) > 1 ) {
				$admin_bar_output2 = $admin_bar_output2[ 1 ];
			}
		}
		$admin_bar_output = $admin_bar_output[ 0 ] . $admin_bar_output2;

		//remove script tag
		$admin_bar_output	 = @explode( '<script', $admin_bar_output, 2 );
		$admin_bar_output2	 = "";
		if ( count( $admin_bar_output ) > 1 ) {
			$admin_bar_output2 = @explode( "</script>", $admin_bar_output[ 1 ], 2 );
			if ( count( $admin_bar_output2 ) > 1 ) {
				$admin_bar_output2 = $admin_bar_output2[ 1 ];
			}
		}
		$admin_bar_output = $admin_bar_output[ 0 ] . $admin_bar_output2;

		//remove user details
		$admin_bar_output	 = @explode( '<a class="ab-item"', $admin_bar_output, 2 );
		$admin_bar_output2	 = "";
		if ( count( $admin_bar_output ) > 1 ) {
			$admin_bar_output2 = @explode( "</a>", $admin_bar_output[ 1 ], 2 );
			if ( count( $admin_bar_output2 ) > 1 ) {
				$admin_bar_output2 = $admin_bar_output2[ 1 ];
			}
		}
		$admin_bar_output = $admin_bar_output[ 0 ] . $admin_bar_output2;

		//add active class into vieving link item
		$current_link = $_SERVER[ "HTTP_HOST" ] . $_SERVER[ "REQUEST_URI" ];

		$bb_adminbar_myaccount = $admin_bar_output;
	}
}

add_action( "wp_before_admin_bar_render", "buddyboss_memory_admin_bar_nodes" );
add_action( "wp_after_admin_bar_render", "buddyboss_memory_admin_bar_nodes" );

/**
 * Get adminbar myaccount section output
 * Note :- this function can be overwrite with child-theme.
 * @since Boss 1.0.0
 *
 * */
function buddyboss_adminbar_myaccount() {
	global $bb_adminbar_myaccount;
	echo $bb_adminbar_myaccount;
}

/**
 * Get Notification from admin bar
 * @since Boss 1.0.0
 * */
function buddyboss_adminbar_notification() {
	global $bb_adminbar_notifications;
	return @$bb_adminbar_notifications;
}

/**
 * Get Messages
 * */
if( ! function_exists( 'buddyboss_adminbar_messages' ) ) {
	function buddyboss_adminbar_messages() {
		global $bb_adminbar_messages;
		return @$bb_adminbar_messages;
	}
}

/**
 * Get Friends
 * */
if( ! function_exists( 'buddyboss_adminbar_friends' ) ) {
	function buddyboss_adminbar_friends() {
		global $bb_adminbar_friends;
		return @$bb_adminbar_friends;
	}
}

/**
 * Remove certain admin bar links useful as we using admin bar invisibly
 * @since Boss 1.0.0
 *
 */
function remove_admin_bar_links() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu( 'wp-logo' );
	$wp_admin_bar->remove_menu( 'search' );

	if ( !current_user_can( 'administrator' ) ):
		$wp_admin_bar->remove_menu( 'site-name' );
	endif;
}

add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );

/**
 * Replace admin bar "Howdy" text
 *
 * @since Boss 1.0.0
 *
 */
function replace_howdy( $wp_admin_bar ) {

	if ( is_user_logged_in() ) {

		$my_account	 = $wp_admin_bar->get_node( 'my-account' );
		$newtitle	 = str_replace( 'Howdy,', '', $my_account->title );
		$wp_admin_bar->add_node( array(
			'id'	 => 'my-account',
			'title'	 => $newtitle,
		) );
	}
}

add_filter( 'admin_bar_menu', 'replace_howdy', 25 );



/* * **************************** AVATAR FUNCTIONS ***************************** */


/**
 * Replace default member avatar
 *
 * @since Boss 1.0.0
 * @todo: this will remove in final review
 */
if ( !function_exists( 'buddyboss_addgravatar' ) ) {

	function buddyboss_addgravatar( $avatar_defaults ) {
		$myavatar						 = get_stylesheet_directory_uri() . '/images/avatar-member.jpg';
		$avatar_defaults[ $myavatar ]	 = 'BuddyBoss Man';
		return $avatar_defaults;
	}

	add_filter( 'avatar_defaults', 'buddyboss_addgravatar' );
}

/**
 * Replace default group avatar
 *
 * @since Boss 1.0.0
 */
function buddyboss_default_group_avatar( $avatar ) {
	global $bp, $groups_template;
	if ( strpos( $avatar, 'group-avatars' ) ) {
		return $avatar;
	} else {
		$custom_avatar	 = get_stylesheet_directory_uri() . '/images/avatar-group.jpg';
		$alt			 = 'group avatar';

		if ( $groups_template && ! empty( $groups_template->group->name ) ) {
			$alt = esc_attr( $groups_template->group->name );
		}

		$group_id = ! empty( $bp->groups->current_group->id ) ? $bp->groups->current_group->id : 0;
		if ( $bp->current_action == "" ) {
			return '<img width="' . BP_AVATAR_THUMB_WIDTH . '" height="' . BP_AVATAR_THUMB_HEIGHT . '" src="' . $custom_avatar . '" class="avatar group-'. $group_id .'-avatar" alt="' . $alt . '" />';
		} else {
			return '<img width="' . BP_AVATAR_FULL_WIDTH . '" height="' . BP_AVATAR_FULL_HEIGHT . '" src="' . $custom_avatar . '" class="avatar group-'. $group_id .'-avatar" alt="' . $alt . '" />';
		}
	}
}

add_filter( 'bp_get_group_avatar', 'buddyboss_default_group_avatar' );
add_filter( 'bp_get_new_group_avatar', 'buddyboss_default_group_avatar' );

/**
 * Change the avatar size
 * @since Boss 1.0.0
 * */
function buddyboss_avatar_full_height( $val ) {
	global $bp;
	if ( $bp->current_component == "groups" ) {
		return 400;
	}
	return $val;
}

function buddyboss_avatar_full_width( $val ) {
	global $bp;
	if ( $bp->current_component == "groups" ) {
		return 400;
	}
	return $val;
}

function buddyboss_avatar_thumb_height( $val ) {
	global $bp;
	if ( $bp->current_component == "groups" ) {
		return 150;
	}
	return $val;
}

function buddyboss_avatar_thumb_width( $val ) {
	global $bp;
	if ( $bp->current_component == "groups" ) {
		return 150;
	}
	return $val;
}

add_filter( "bp_core_avatar_full_height", "buddyboss_avatar_full_height" );
add_filter( "bp_core_avatar_full_width", "buddyboss_avatar_full_width" );
add_filter( "bp_core_avatar_thumb_height", "buddyboss_avatar_thumb_height" );
add_filter( "bp_core_avatar_thumb_width", "buddyboss_avatar_thumb_width" );



/* * **************************** WORDPRESS FUNCTIONS ***************************** */

/**
 * Custom Pagination
 * Credits: http://www.kriesi.at/archives/how-to-build-a-wordpress-post-pagination-without-plugin
 *
 * @since Boss 1.0.0
 */
function buddyboss_pagination( $pages = '', $range = 2 ) {
	$showitems = ($range * 2) + 1;

	global $paged;
	if ( empty( $paged ) )
		$paged = 1;

	if ( $pages == '' ) {
		global $wp_query;
		$pages = $wp_query->max_num_pages;
		if ( !$pages ) {
			$pages = 1;
		}
	}

	if ( 1 != $pages ) {
		echo "<div class='pagination'>";
		if ( $paged > 2 && $paged > $range + 1 && $showitems < $pages )
			echo "<a href='" . esc_url( get_pagenum_link( 1 ) ) . "'>&laquo;</a>";
		if ( $paged > 1 && $showitems < $pages )
			echo "<a href='" . esc_url( get_pagenum_link( $paged - 1 ) ) . "'>&lsaquo;</a>";

		for ( $i = 1; $i <= $pages; $i++ ) {
			if ( 1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems ) ) {
				echo ($paged == $i) ? "<span class='current'>" . intval( $i ) . "</span>" : "<a href='" . esc_url( get_pagenum_link( $i ) ) . "' class='inactive' >" . intval( $i ) . "</a>";
			}
		}

		if ( $paged < $pages && $showitems < $pages )
			echo "<a href='" . esc_url( get_pagenum_link( $paged + 1 ) ) . "'>&rsaquo;</a>";
		if ( $paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages )
			echo "<a href='" . esc_url( get_pagenum_link( $pages ) ) . "'>&raquo;</a>";
		echo "</div>\n";
	}
}

/**
 * Checks if a plugin is active.
 *
 * @since Boss 1.0.0
 */
function buddyboss_is_plugin_active( $plugin ) {
	return in_array( $plugin, (array) get_option( 'active_plugins', array() ) );
}

/**
 * Return the ID of a page set as the home page.
 *
 * @return false|int ID of page set as the home page
 * @since Boss 1.0.0
 */
if ( !function_exists( 'bp_dtheme_page_on_front' ) ) :

	function bp_dtheme_page_on_front() {
		if ( 'page' != get_option( 'show_on_front' ) )
			return false;

		return apply_filters( 'bp_dtheme_page_on_front', get_option( 'page_on_front' ) );
	}

endif;

/**
 * Add a View Profile link in Dashboard > Users panel
 *
 * @since Boss 1.0.0
 */
function user_row_actions_bp_view( $actions, $user_object ) {
	if ( function_exists( 'bp_is_active' ) ) {
		$actions[ 'view' ] = '<a href="' . bp_core_get_user_domain( $user_object->ID ) . '">' . __( 'View Profile', 'boss' ) . '</a>';
	}
    return $actions;
}

add_filter( 'user_row_actions', 'user_row_actions_bp_view', 10, 2 );

/**
 * Function that checks if BuddyPress plugin is active
 *
 * @since Boss 1.0.0
 */
function buddyboss_is_bp_active() {
	if ( function_exists( 'bp_is_active' ) ) {
		return true;
	} else {
		return false;
	}
}

function buddyboss_override_page_template( $template ) {
	global $bp;
	$id				 = get_queried_object_id();
	$page_template	 = get_page_template_slug();
	$pagename		 = get_query_var( 'pagename' );

	$bp_pages = buddypress()->pages;

	$bp_page_ids = array();

	foreach ( $bp_pages as $bp_page ) {
		$bp_page_ids[] = $bp_page->id;
	}

	if ( in_array( $id, $bp_page_ids ) ) {
		// locate_template( array( $page_template ), true );
		// var_dump( $page_template, $id, $template, $pagename, buddypress()->pages );
	}
	// die;
}

// add_action( 'template_redirect', 'buddyboss_override_page_template' );

/**
 * Function that modify wp_list_categories function's post count
 *
 * @since Boss 1.0.0
 */
function cat_count_span_inline( $output ) {
	$output	 = str_replace( '</a> (', '</a><span><i>', $output );
	$output	 = str_replace( ')', '</i></span> ', $output );
	return $output;
}

add_filter( 'wp_list_categories', 'cat_count_span_inline' );

/**
 * Function that modify bp_new_group_invite_friend_list function's input checkboxes
 *
 * @since Boss 1.0.0
 */
function buddyboss_new_group_invite_friend_list() {
	echo buddyboss_get_new_group_invite_friend_list();
}

function buddyboss_get_new_group_invite_friend_list( $args = '' ) {
	global $bp;

	if ( !bp_is_active( 'friends' ) )
		return false;

	$defaults = array(
		'group_id'	 => false,
		'separator'	 => 'li'
	);

	$r = wp_parse_args( $args, $defaults );
	extract( $r, EXTR_SKIP );

	if ( empty( $group_id ) )
		$group_id = !empty( $bp->groups->new_group_id ) ? $bp->groups->new_group_id : $bp->groups->current_group->id;

	if ( $friends = friends_get_friends_invite_list( bp_loggedin_user_id(), $group_id ) ) {
		$invites = groups_get_invites_for_group( bp_loggedin_user_id(), $group_id );

		for ( $i = 0, $count = count( $friends ); $i < $count; ++$i ) {
			$checked = '';

			if ( !empty( $invites ) ) {
				if ( in_array( $friends[ $i ][ 'id' ], $invites ) )
					$checked = ' checked="checked"';
			}

			$items[] = '<' . $separator . '><label><input' . $checked . ' type="checkbox" name="friends[]" id="f-' . $friends[ $i ][ 'id' ] . '" value="' . esc_attr( $friends[ $i ][ 'id' ] ) . '" />' . $friends[ $i ][ 'full_name' ] . '</label></' . $separator . '>';
		}
	}

	if ( !empty( $items ) )
		return implode( "\n", (array) $items );

	return false;
}

/**
 * Output a fancy description of the current forum, including total topics,
 * total replies, and last activity.
 *
 * @since Boss 1.0.0
 *
 * @param array $args Arguments passed to alter output
 * @uses bbp_get_single_forum_description() Return the eventual output
 */
function buddyboss_bbp_single_forum_description( $args = '' ) {
	echo buddyboss_bbp_get_single_forum_description( $args );
}

/**
 * Return a fancy description of the current forum, including total
 * topics, total replies, and last activity.
 *
 * @since Boss 1.0.0
 *
 * @param mixed $args This function supports these arguments:
 *  - forum_id: Forum id
 *  - before: Before the text
 *  - after: After the text
 *  - size: Size of the avatar
 * @uses bbp_get_forum_id() To get the forum id
 * @uses bbp_get_forum_topic_count() To get the forum topic count
 * @uses bbp_get_forum_reply_count() To get the forum reply count
 * @uses bbp_get_forum_freshness_link() To get the forum freshness link
 * @uses bbp_get_forum_last_active_id() To get the forum last active id
 * @uses bbp_get_author_link() To get the author link
 * @uses add_filter() To add the 'view all' filter back
 * @uses apply_filters() Calls 'bbp_get_single_forum_description' with
 *                        the description and args
 * @return string Filtered forum description
 */
function buddyboss_bbp_get_single_forum_description( $args = '' ) {

	// Parse arguments against default values
	$r = bbp_parse_args( $args, array(
		'forum_id'	 => 0,
		'before'	 => '<div class="bbp-template-notice info"><p class="bbp-forum-description">',
		'after'		 => '</p></div>',
		'size'		 => 14,
		'feed'		 => true
	), 'get_single_forum_description' );

	// Validate forum_id
	$forum_id = bbp_get_forum_id( $r[ 'forum_id' ] );

	// Unhook the 'view all' query var adder
	remove_filter( 'bbp_get_forum_permalink', 'bbp_add_view_all' );

	// Get some forum data
	$tc_int		 = bbp_get_forum_topic_count( $forum_id, false );
	$rc_int		 = bbp_get_forum_reply_count( $forum_id, false );
	$topic_count = bbp_get_forum_topic_count( $forum_id );
	$reply_count = bbp_get_forum_reply_count( $forum_id );
	$last_active = bbp_get_forum_last_active_id( $forum_id );

	// Has replies
	if ( !empty( $reply_count ) ) {
		$reply_text = sprintf( _n( '%s reply', '%s replies', $rc_int, 'boss' ), $reply_count );
	}

	// Forum has active data
	if ( !empty( $last_active ) ) {
		$topic_text		 = bbp_get_forum_topics_link( $forum_id );
		$time_since		 = bbp_get_forum_freshness_link( $forum_id );
		$last_updated_by = bbp_get_author_link( array( 'post_id' => $last_active, 'size' => $r[ 'size' ] ) );

		// Forum has no last active data
	} else {
		$topic_text = sprintf( _n( '%s topic', '%s topics', $tc_int, 'boss' ), $topic_count );
	}

	// Forum has active data
	if ( !empty( $last_active ) ) {

		if ( !empty( $reply_count ) ) {

			if ( bbp_is_forum_category( $forum_id ) ) {
				$retstr = sprintf( __( '<span class="post-num">%1$s and %2$s</span> <span class="last-activity">Last updated by %3$s %4$s</span>', 'boss' ), $topic_text, $reply_text, $last_updated_by, $time_since );
			} else {
				$retstr = sprintf( __( '<span class="post-num">%1$s and %2$s</span> <span class="last-activity">Last updated by %3$s %4$s<span>', 'boss' ), $topic_text, $reply_text, $last_updated_by, $time_since );
			}
		} else {

			if ( bbp_is_forum_category( $forum_id ) ) {
				$retstr = sprintf( __( '<span class="post-num">%1$s</span> <span class="last-activity">Last updated by %2$s %3$s</span>', 'boss' ), $topic_text, $last_updated_by, $time_since );
			} else {
				$retstr = sprintf( __( '<span class="post-num">%1$s</span> <span class="last-activity">Last updated by %2$s %3$s</span>', 'boss' ), $topic_text, $last_updated_by, $time_since );
			}
		}

		// Forum has no last active data
	} else {

		if ( !empty( $reply_count ) ) {

			if ( bbp_is_forum_category( $forum_id ) ) {
				$retstr = sprintf( __( '<span class="post-num">%1$s and %2$s</span>', 'boss' ), $topic_text, $reply_text );
			} else {
				$retstr = sprintf( __( '<span class="post-num">%1$s and %2$s</span>', 'boss' ), $topic_text, $reply_text );
			}
		} else {

			if ( !empty( $topic_count ) ) {

				if ( bbp_is_forum_category( $forum_id ) ) {
					$retstr = sprintf( __( '<span class="post-num">%1$s</span>', 'boss' ), $topic_text );
				} else {
					$retstr = sprintf( __( '<span class="post-num">%1$s</span>', 'boss' ), $topic_text );
				}
			} else {
				$retstr = __( '<span class="post-num">0 topics and 0 posts</span>', 'boss' );
			}
		}
	}

	// Add feeds
	//$feed_links = ( !empty( $r['feed'] ) ) ? bbp_get_forum_topics_feed_link ( $forum_id ) . bbp_get_forum_replies_feed_link( $forum_id ) : '';
	// Add the 'view all' filter back
	add_filter( 'bbp_get_forum_permalink', 'bbp_add_view_all' );

	// Combine the elements together
	$retstr = $r[ 'before' ] . $retstr . $r[ 'after' ];

	// Return filtered result
	return apply_filters( 'bbp_get_single_forum_description', $retstr, $r );
}

/**
 * Output a fancy description of the current topic, including total topics,
 * total replies, and last activity.
 *
 * @since Boss 1.0.0
 *
 * @param array $args See {@link bbp_get_single_topic_description()}
 * @uses bbp_get_single_topic_description() Return the eventual output
 */
function buddyboss_bbp_single_topic_description( $args = '' ) {
	echo buddyboss_bbp_get_single_topic_description( $args );
}

/**
 * Return a fancy description of the current topic, including total topics,
 * total replies, and last activity.
 *
 * @since Boss 1.0.0
 *
 * @param mixed $args This function supports these arguments:
 *  - topic_id: Topic id
 *  - before: Before the text
 *  - after: After the text
 *  - size: Size of the avatar
 * @uses bbp_get_topic_id() To get the topic id
 * @uses bbp_get_topic_voice_count() To get the topic voice count
 * @uses bbp_get_topic_reply_count() To get the topic reply count
 * @uses bbp_get_topic_freshness_link() To get the topic freshness link
 * @uses bbp_get_topic_last_active_id() To get the topic last active id
 * @uses bbp_get_reply_author_link() To get the reply author link
 * @uses apply_filters() Calls 'bbp_get_single_topic_description' with
 *                        the description and args
 * @return string Filtered topic description
 */
function buddyboss_bbp_get_single_topic_description( $args = '' ) {

	// Parse arguments against default values
	$r = bbp_parse_args( $args, array(
		'topic_id'	 => 0,
		'before'	 => '<div class="bbp-template-notice info"><p class="bbp-topic-description">',
		'after'		 => '</p></div>',
		'size'		 => 14
	), 'get_single_topic_description' );

	// Validate topic_id
	$topic_id = bbp_get_topic_id( $r[ 'topic_id' ] );

	// Unhook the 'view all' query var adder
	remove_filter( 'bbp_get_topic_permalink', 'bbp_add_view_all' );

	// Build the topic description
	$vc_int		 = bbp_get_topic_voice_count( $topic_id, true );
	$voice_count = bbp_get_topic_voice_count( $topic_id, false );
	$reply_count = bbp_get_topic_replies_link( $topic_id );
	$time_since	 = bbp_get_topic_freshness_link( $topic_id );

	// Singular/Plural
	$voice_count = sprintf( _n( '%s voice', '%s voices', $vc_int, 'boss' ), $voice_count );

	// Topic has replies
	$last_reply = bbp_get_topic_last_reply_id( $topic_id );
	if ( !empty( $last_reply ) ) {
		$last_updated_by = bbp_get_author_link( array( 'post_id' => $last_reply, 'size' => $r[ 'size' ] ) );
		$retstr			 = sprintf( __( '<span class="post-num">%1$s, %2$s</span> <span class="last-activity">Last updated by %3$s %4$s</span>', 'boss' ), $reply_count, $voice_count, $last_updated_by, $time_since );

		// Topic has no replies
	} elseif ( !empty( $voice_count ) && !empty( $reply_count ) ) {
		$retstr = sprintf( __( '<span class="post-num">%1$s, %2$s</span>', 'boss' ), $voice_count, $reply_count );

		// Topic has no replies and no voices
	} elseif ( empty( $voice_count ) && empty( $reply_count ) ) {
		$retstr = sprintf( __( '<span class="post-num">0 replies</span>', 'boss' ), $voice_count, $reply_count );
	}

	// Add the 'view all' filter back
	add_filter( 'bbp_get_topic_permalink', 'bbp_add_view_all' );

	// Combine the elements together
	$retstr = $r[ 'before' ] . $retstr . $r[ 'after' ];

	// Return filtered result
	return apply_filters( 'bbp_get_single_topic_description', $retstr, $r );
}

/**
 * Places "Compose" to the first place on messages navigation links
 *
 * @since Boss 1.0.0
 *
 */
function tricks_change_bp_tag_position() {
	global $bp;
    $version_compare = version_compare( BP_VERSION, '2.6', '<' );
    if ( $version_compare ){
        $bp->bp_options_nav[ 'messages' ][ 'compose' ][ 'position' ] = 10;
        $bp->bp_options_nav[ 'messages' ][ 'inbox' ][ 'position' ]	 = 11;
        $bp->bp_options_nav[ 'messages' ][ 'sentbox' ][ 'position' ] = 30;
    } else {
        if( !empty( $bp->messages ) ){
            $subnavs = array( 'compose' => 10, 'inbox' => 11, 'sentbox' => 30, );
            foreach( $subnavs as $subnav => $pos ){
                $nav_args = array( 'position' => $pos );
                $bp->members->nav->edit_nav( $nav_args, $subnav, 'messages' );
            }
        }
    }
}

add_action( 'bp_init', 'tricks_change_bp_tag_position', 999 );

/**
 * Output the markup for the message type dropdown.
 *
 * @since Boss 1.0.0
 *
 */
function buddyboss_bp_messages_options() {
	?>

	<select name="message-type-select" id="message-type-select">
		<option value=""></option>
		<option value="read"><?php _ex( 'Read', 'Message dropdown filter', 'boss' ) ?></option>
		<option value="unread"><?php _ex( 'Unread', 'Message dropdown filter', 'boss' ) ?></option>
		<option value="all"><?php _ex( 'All', 'Message dropdown filter', 'boss' ) ?></option>
	</select> &nbsp;

	<?php if ( !bp_is_current_action( 'sentbox' ) && bp_is_current_action( 'notices' ) ) : ?>

		<a href="#" id="mark_as_read"><?php _ex( 'Mark as Read', 'Message management markup', 'boss' ) ?></a> &nbsp;
		<a href="#" id="mark_as_unread"><?php _ex( 'Mark as Unread', 'Message management markup', 'boss' ) ?></a> &nbsp;

	<?php endif; ?>

	<a href="#" id="delete_<?php echo bp_current_action(); ?>_messages" class="fa fa-trash"></a> &nbsp;

	<?php
}

/**
 * Custom Walker for left panel menu
 *
 * @since Boss 1.0.0
 *
 */
class BuddybossWalker extends Walker {

	/**
	 * What the class handles.
	 *
	 * @see Walker::$tree_type
	 * @since Boss 1.0.0
	 * @var string
	 */
	public $tree_type = array( 'post_type', 'taxonomy', 'custom' );

	/**
	 * Database fields to use.
	 *
	 * @see Walker::$db_fields
	 * @since Boss 1.0.0
	 * @todo Decouple this.
	 * @var array
	 */
	public $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );

	/**
	 * Starts the list before the elements are added.
	 *
	 * @see Walker::start_lvl()
	 *
	 * @since Boss 1.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "\n$indent<div class='sub-menu-wrap'><ul class=\"sub-menu\">\n";
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @see Walker::end_lvl()
	 *
	 * @since Boss 1.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "$indent</ul></div>\n";
	}

	/**
	 * Start the element output.
	 *
	 * @see Walker::start_el()
	 *
	 * @since Boss 1.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 * @param int    $id     Current item ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$icon_class = 'fa-file';

		foreach ( $item->classes as $key => $value ) {
			if ( substr( $value, 0, 3 ) === 'fa-' ) {
				$icon_class = $value;
			}
			if ( substr( $value, 0, 2 ) === 'fa' ) {
				unset( $item->classes[ $key ] );
			}
		}

		$classes	 = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[]	 = 'menu-item-' . $item->ID;

		/**
		 * Filter the CSS class(es) applied to a menu item's <li>.
		 *
		 * @since Boss 1.0.0
		 *
		 * @see wp_nav_menu()
		 *
		 * @param array  $classes The CSS classes that are applied to the menu item's <li>.
		 * @param object $item    The current menu item.
		 * @param array  $args    An array of wp_nav_menu() arguments.
		 */
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		/**
		 * Filter the ID applied to a menu item's <li>.
		 *
		 * @since Boss 1.0.0
		 *
		 * @see wp_nav_menu()
		 *
		 * @param string $menu_id The ID that is applied to the menu item's <li>.
		 * @param object $item    The current menu item.
		 * @param array  $args    An array of wp_nav_menu() arguments.
		 */
		$id	 = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args );
		$id	 = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $class_names . '>';

		$atts				 = array();
		$atts[ 'title' ]	 = !empty( $item->attr_title ) ? $item->attr_title : '';
		$atts[ 'target' ]	 = !empty( $item->target ) ? $item->target : '';
		$atts[ 'rel' ]		 = !empty( $item->xfn ) ? $item->xfn : '';
		$atts[ 'href' ]		 = !empty( $item->url ) ? $item->url : '';

		/**
		 * Filter the HTML attributes applied to a menu item's <a>.
		 *
		 * @since Boss 1.0.0
		 *
		 * @see wp_nav_menu()
		 *
		 * @param array $atts {
		 *     The HTML attributes applied to the menu item's <a>, empty strings are ignored.
		 *
		 *     @type string $title  Title attribute.
		 *     @type string $target Target attribute.
		 *     @type string $rel    The rel attribute.
		 *     @type string $href   The href attribute.
		 * }
		 * @param object $item The current menu item.
		 * @param array  $args An array of wp_nav_menu() arguments.
		 */
		$archor_classes = ($item->menu_item_parent === '0') ? 'class="' . esc_attr( $icon_class ) . '"' : '';

		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( !empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$item_output = $args->before;
		$item_output .= '<a' . $attributes . ' ' . $archor_classes . '>';
		/** This filter is documented in wp-includes/post-template.php */
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		/**
		 * Filter a menu item's starting output.
		 *
		 * The menu item's starting output only includes $args->before, the opening <a>,
		 * the menu item's title, the closing </a>, and $args->after. Currently, there is
		 * no filter for modifying the opening and closing <li> for a menu item.
		 *
		 * @since Boss 1.0.0
		 *
		 * @see wp_nav_menu()
		 *
		 * @param string $item_output The menu item's starting HTML output.
		 * @param object $item        Menu item data object.
		 * @param int    $depth       Depth of menu item. Used for padding.
		 * @param array  $args        An array of wp_nav_menu() arguments.
		 */
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @see Walker::end_el()
	 *
	 * @since Boss 1.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Page data object. Not used.
	 * @param int    $depth  Depth of page. Not Used.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 */
	public function end_el( &$output, $item, $depth = 0, $args = array() ) {
		$output .= "</li>\n";
	}

}

// Walker_Nav_Menu


/*
 * Removing the create a group button from under the title
 *
 * @since Boss 1.0.0
 */

function buddyboss_remove_group_create_button() {
	if ( bp_is_active( 'groups' ) ) {
		remove_filter( 'bp_groups_directory_header', 'bp_legacy_theme_group_create_button' );
	}
}

add_action( "bp_init", "buddyboss_remove_group_create_button" );


/*
 * Places content bellow title on dir pages
 *
 * @since Creacial 1.0.0
 */

function inject_content() {
	global $bp;

	$custom_content = '';

	if ( bp_is_directory() ) {
		foreach ( (array) $bp->pages as $page_key => $bp_page ) {
			if ( $bp_page->slug == bp_current_component() || ($bp_page->slug == 'sites' && bp_current_component() == 'blogs') ) {
				$page_id = $bp_page->id;

				$page_query = new WP_query( array(
					'post_type'	 => 'page',
					'page_id'	 => $page_id
				) );

				$output_page = get_post( $page_id );

				$custom_content = wpautop( $output_page->post_content );
			}
		}
	}

	echo '<div class="entry-content">' . $custom_content . '</div>';
}

add_action( 'bp_before_directory_members_content', 'inject_content' );
add_action( 'bp_before_directory_groups_content', 'inject_content' );
add_action( 'bp_before_directory_blogs_content', 'inject_content' );
add_action( 'bp_before_directory_activity_content', 'inject_content' );

/*
 * Get title on dir pages
 *
 * @since Creacial 1.0.0
 */

function buddyboss_page_title() {
	echo buddyboss_get_page_title();
}

function buddyboss_get_page_title() {
	global $bp;

	if ( bp_is_directory() ) {
		foreach ( (array) $bp->pages as $page_key => $bp_page ) {

			if ( $bp_page->slug == bp_current_component() || ($bp_page->slug == 'sites' && bp_current_component() == 'blogs') ) {
				$page_id = $bp_page->id;

				$page_query = new WP_query( array(
					'post_type'	 => 'page',
					'page_id'	 => $page_id
				) );

				$output_page = get_post( $page_id );

				$custom_title = $output_page->post_title;
			}
		}
	}

	$pattern	 = '/([\s]*|&nbsp;)<a/im';
	$bp_title	 = '';
	$bp_title	 = get_the_title();
	// If we have a custom title and need to grab a BP title button
	if ( ! empty( $custom_title ) && (int) preg_match( $pattern, $bp_title ) > 0 ) {
		$token = md5( '#b#u#d#d#y#b#o#s#s#' );

		$bp_title_parsed = preg_replace( $pattern, $token, $bp_title );

		$bp_title_parts = explode( $token, $bp_title_parsed, 2 );

		$custom_title .= '&nbsp;<a' . $bp_title_parts[ 1 ];
	}

	if ( empty( $custom_title ) ) {
		$custom_title = $bp_title;
	}

	return $custom_title;
}

add_action('wp_head', 'bb_check_page_template');
function bb_check_page_template(){
	if ( is_page_template( 'page-boxed.php' ) ) {
		add_filter( 'boss_redux_option_value', 'boss_filter_layout', 10, 3 );
	}
}
/**
 * Filter Layout Option from Redux
 * @param  String $value value from Redux
 * @param  String $id    option name
 * @param  String $param default value
 * @return String new value
 */
function boss_filter_layout( $value, $id, $param ) {
	if ( $id == 'boss_layout_style' ) {
		$value = 'boxed';
	}
	return $value;
}

/**
 * Adds classes to body
 *
 * @since Boss 1.0.0
 *
 */
add_filter( 'body_class', 'buddyboss_body_classes' );

function buddyboss_body_classes( $classes ) {

    global $learner;

	$panel_class = 'left-menu-open';

    // Learner enabled
    if($learner){
        $classes[] = 'social-learner';
    }

	// Boxed layout
	if ( boss_get_option( 'boss_layout_style' ) == 'boxed' ) {
		$classes[]	 = 'boxed';
		$classes[]	 = $panel_class;
	}

	// Default layout class
	if ( is_phone() ) {
		$classes[] = 'is-mobile';
	} elseif ( wp_is_mobile() ) {
		if ( boss_get_option( 'boss_layout_tablet' ) == 'desktop' ) {
			$classes[] = 'is-desktop';
		} else {
			$classes[] = 'is-mobile';
		}
		$classes[] = 'tablet';
	} else {
		if ( boss_get_option( 'boss_layout_desktop' ) == 'mobile' ) {
			$classes[] = 'is-mobile';
		} else {
			$classes[] = 'is-desktop';
		}
	}

	// Switch layout class
	if ( isset( $_COOKIE[ 'switch_mode' ] ) && ( boss_get_option( 'boss_layout_switcher' ) ) ) {
		if ( $_COOKIE[ 'switch_mode' ] == 'mobile' ) {
			if ( ($key = array_search( 'is-desktop', $classes )) !== false ) {
				unset( $classes[ $key ] );
			}
			$classes[] = 'is-mobile';
		} else {
			if ( ($key = array_search( 'is-mobile', $classes )) !== false ) {
				unset( $classes[ $key ] );
			}
			$classes[] = 'is-desktop';
		}
	}


	// is bbpress active
	if ( buddyboss_is_bp_active() ) {
		$classes[] = 'bp-active';
	}

	// is panel active
	if ( isset( $_COOKIE[ 'left-panel-status' ] ) ) {
		if ( $_COOKIE[ 'left-panel-status' ] == 'open' ) {
			$classes[] = $panel_class;
		}
	} elseif ( boss_get_option( 'boss_panel_state' ) ) {
		$classes[] = $panel_class;
	}

	// is global media page
	if ( function_exists( 'buddyboss_media' ) && buddyboss_media()->option( 'all-media-page' ) && is_page( buddyboss_media()->option( 'all-media-page' ) ) ) {
		$classes[] = 'buddyboss-media-all-media';
	}

	//hide buddypanel
	if ( !boss_get_option( 'boss_panel_hide' ) && !is_user_logged_in() ) {
		$classes[]	 = 'page-template-page-no-buddypanel';
		$classes[]	 = $panel_class;
	}

	if ( is_page_template( 'page-no-buddypanel.php' ) ) {
		$classes[] = $panel_class;
	}

	// Adminbar class
	if ( !boss_get_option( 'boss_adminbar' ) ) {
		$classes[] = 'no-adminbar';
	}

	return array_unique( $classes );
}

/**
 * Correct notification count in header notification
 *
 * @since Boss 1.0.0
 *
 */
function buddyboss_js_correct_notification_count() {
	if ( !is_user_logged_in() || !buddyboss_is_bp_active() || !function_exists( "bp_notifications_get_all_notifications_for_user" ) )
		return;
	$notifications = bp_notifications_get_all_notifications_for_user( bp_loggedin_user_id() );
	if ( !empty( $notifications ) ) {
		$count = count( $notifications );
		?>
		<script type="text/javascript">
		    jQuery( 'document' ).ready( function ( $ ) {
		        $( '.header-notifications .notification-link span.alert' ).html( '<?php echo $count; ?>' );
		    } );
		</script>
		<?php
	}
}

add_action( 'wp_footer', 'buddyboss_js_correct_notification_count' );

/**
 * Heartbeat settings
 *
 * @since Boss 1.0.0
 *
 */
function buddyboss_heartbeat_settings( $settings ) {
	$settings[ 'interval' ] = 5; //pulse on each 20 sec.
	return $settings;
}

add_filter( 'heartbeat_settings', 'buddyboss_heartbeat_settings' );

/**
 * Sending a heartbeat for notification updates
 *
 * @since Boss 1.0.0
 *
 */
function buddyboss_notification_count_heartbeat( $response, $data, $screen_id ) {
    $notifications = array();

	if ( function_exists( "bp_friend_get_total_requests_count" ) )
		$friend_request_count	 = bp_friend_get_total_requests_count();
	if ( function_exists( "bp_notifications_get_all_notifications_for_user" ) )
		$notifications			 = bp_notifications_get_all_notifications_for_user( get_current_user_id() );

	$notification_count		 = count( $notifications );

	if ( function_exists( "bp_notifications_get_all_notifications_for_user" ) ) {
		$notifications			 = bp_notifications_get_notifications_for_user( get_current_user_id() );
		$notification_content	 = '';
        if( !empty( $notifications ) ){
            foreach ( (array) $notifications as $notification ) {
                if( is_array( $notification ) ){
                    if( isset( $notification['link'] ) && isset( $notification['text'] ) ){
                        $notification_content .= "<a href='". esc_url( $notification['link'] ) ."'>{$notification['text']}</a>";
                    }
                } else {
                    $notification_content .= $notification;
                }
            }
        }

		if ( empty( $notification_content ) )
			$notification_content = '<a href="' . bp_loggedin_user_domain() . '' . BP_NOTIFICATIONS_SLUG . '/">' . __( "No new notifications", "buddypress" ) . '</a>';
	}
	if ( function_exists( "messages_get_unread_count" ) )
		$unread_message_count = messages_get_unread_count();

	$response[ 'bb_notification_count' ] = array(
		'friend_request'		 => @intval( $friend_request_count ),
		'notification'			 => @intval( $notification_count ),
		'notification_content'	 => @$notification_content,
		'unread_message'		 => @intval( $unread_message_count )
	);

	return $response;
}

// Logged in users:
add_filter( 'heartbeat_received', 'buddyboss_notification_count_heartbeat', 10, 3 );

/**
 * Add @handle to forum replies
 *
 * @since Boss 1.0.0
 *
 */
function buddyboss_add_handle() {
	if ( bbp_get_reply_id() ) {
		$bb_username = get_userdata( bbp_get_reply_author_id( bbp_get_reply_id() ) );
		echo '<span class="bbp-user-nicename"><span class="handle-sign">@</span>' . $bb_username->user_login . '</span>';
	}
}

add_action( 'bbp_theme_after_reply_author_details', 'buddyboss_add_handle' );


/*
 * Resize images dynamically using wp built in functions
 *
 *
 * Example:
 *
 * <?php
 * $thumb = get_post_thumbnail_id();
 * $image = buddyboss_resize( $thumb, '', 140, 110, true );
 * ?>
 * <img src="<?php echo $image[url]; ?>" width="<?php echo $image[width]; ?>" height="<?php echo $image[height]; ?>" />
 *
 * @param int $attach_id
 * @param string $img_url
 * @param int $width
 * @param int $height
 * @param bool $crop
 * @return array
 */
if ( !function_exists( 'buddyboss_resize' ) ) {

	function buddyboss_resize( $attach_id = null, $img_url = null, $ratio = null, $width = null, $height = null,
							$crop = false ) {
		// Cast $width and $height to integer
		$width	 = intval( $width );
		$height	 = intval( $height );
		// this is an attachment, so we have the ID
		if ( $attach_id ) {
			$image_src	 = wp_get_attachment_image_src( $attach_id, 'full' );
			$file_path	 = get_attached_file( $attach_id );
			// this is not an attachment, let's use the image url
		} else if ( $img_url ) {
			if ( false === ( $upload_dir = wp_cache_get( 'upload_dir', 'cache' ) ) ) {
				$upload_dir = wp_upload_dir();
				wp_cache_set( 'upload_dir', $upload_dir, 'cache' );
			}
			$file_path		 = explode( $upload_dir[ 'baseurl' ], $img_url );
			$file_path		 = $upload_dir[ 'basedir' ] . $file_path[ '1' ];
			//$file_path = ltrim( $file_path['path'], '/' );
			//$file_path = rtrim( ABSPATH, '/' ).$file_path['path'];
			$orig_size		 = getimagesize( $file_path );
			$image_src[ 0 ]	 = $img_url;
			$image_src[ 1 ]	 = $orig_size[ 0 ];
			$image_src[ 2 ]	 = $orig_size[ 1 ];
		}
		$file_info = pathinfo( $file_path );
		// check if file exists
		if ( empty( $file_info[ 'dirname' ] ) && empty( $file_info[ 'filename' ] ) && empty( $file_info[ 'extension' ] ) )
			return;

		$base_file			 = $file_info[ 'dirname' ] . '/' . $file_info[ 'filename' ] . '.' . $file_info[ 'extension' ];
		if ( !file_exists( $base_file ) )
			return;
		$extension			 = '.' . $file_info[ 'extension' ];
		// the image path without the extension
		$no_ext_path		 = $file_info[ 'dirname' ] . '/' . $file_info[ 'filename' ];
		$cropped_img_path	 = $no_ext_path . '-' . $width . 'x' . $height . $extension;
		// checking if the file size is larger than the target size
		// if it is smaller or the same size, stop right here and return

		if ( file_exists( $cropped_img_path ) ) {
			$cropped_img_url = str_replace( basename( $image_src[ 0 ] ), basename( $cropped_img_path ), $image_src[ 0 ] );
			$vt_image		 = array(
				'url'	 => $cropped_img_url,
				'width'	 => $width,
				'height' => $height
			);
			return $vt_image;
		}


		// Check if GD Library installed
		if ( !function_exists( 'imagecreatetruecolor' ) ) {
			echo 'GD Library Error: imagecreatetruecolor does not exist - please contact your web host and ask them to install the GD library';
			return;
		}
		// no cache files - let's finally resize it
		$image = wp_get_image_editor( $file_path );
		if ( !is_wp_error( $image ) ) {

			if ( $ratio ) {
				$size_array	 = $image->get_size();
				$width		 = $size_array[ 'width' ];
				$old_height	 = $size_array[ 'height' ];
				$height		 = intval( $width / $ratio );

				if ( $height > $old_height ) {
					$width	 = $old_height * $ratio;
					$height	 = $old_height;
				}
			}

			$image->resize( $width, $height, $crop );
			$save_data		 = $image->save();
			if ( isset( $save_data[ 'path' ] ) )
				$new_img_path	 = $save_data[ 'path' ];
		}

		$new_img_size	 = getimagesize( $new_img_path );
		$new_img		 = str_replace( basename( $image_src[ 0 ] ), basename( $new_img_path ), $image_src[ 0 ] );
		// resized output
		$vt_image		 = array(
			'url'	 => $new_img,
			'width'	 => $new_img_size[ 0 ],
			'height' => $new_img_size[ 1 ]
		);
		return $vt_image;
	}

}

/**
 * Sensei plugin wrappers
 *
 * @since Boss 1.0.9
 *
 */
global $woothemes_sensei;
if ( $woothemes_sensei ) {
	remove_action( 'sensei_before_main_content', array( $woothemes_sensei->frontend, 'sensei_output_content_wrapper' ), 10 );
	remove_action( 'sensei_after_main_content', array( $woothemes_sensei->frontend, 'sensei_output_content_wrapper_end' ), 10 );

	if ( !function_exists( 'boss_education_wrapper_start' ) ) :
		add_action( 'sensei_before_main_content', 'boss_education_wrapper_start', 10 );

		function boss_education_wrapper_start() {
			if ( is_active_sidebar( 'sidebar' ) ) :
				echo '<div class="page-right-sidebar">';
			else :
				echo '<div class="page-full-width">';
			endif;
			echo '<div id="primary" class="site-content"><div id="content" role="main" class="sensei-content">';
		}

	endif;

	if ( !function_exists( 'boss_education_wrapper_end' ) ) :
		add_action( 'sensei_after_main_content', 'boss_education_wrapper_end', 10 );

		function boss_education_wrapper_end() {
			echo '</div><!-- #content -->
            </div><!-- #primary -->';
			get_sidebar();
			echo '</div><!-- .page-right-sidebar -->';
		}

	endif;
}
/**
 * Declaring Sensei Support
 *
 * @since Boss 1.1.0
 *
 */
add_action( 'after_setup_theme', 'declare_sensei_support' );

function declare_sensei_support() {
	add_theme_support( 'sensei' );
}

/**
 * Header cart live update
 *
 * @since Boss 1.1.0
 *
 */
add_filter( 'add_to_cart_fragments', 'woo_add_to_cart_ajax' );

function woo_add_to_cart_ajax( $fragments ) {
	global $woocommerce;
	ob_start();
	$cart_items = $woocommerce->cart->cart_contents_count;
	?>
	<a class="cart-notification notification-link fa fa-shopping-cart" href="<?php echo $woocommerce->cart->get_cart_url(); ?>">
		<?php if ( $cart_items ) { ?>
			<span><?php echo $cart_items; ?></span>
		<?php } ?>
	</a>
	<?php
	$fragments[ 'a.cart-notification' ] = ob_get_clean();
	return $fragments;
}

/**
 * Removing woocomerce function that disables adminbar for subsribers
 *
 * @since Boss 1.1.4
 *
 */
remove_filter( 'show_admin_bar', 'wc_disable_admin_bar' );


add_action( 'boss_get_group_template', 'boss_get_group_template' );

function boss_get_group_template() {

	//Group Blog plugin template issue fix
	if ( function_exists('bp_set_template_included') ) {
		bp_set_template_included( 'group-single' );
	}

	bp_get_template_part( 'buddypress', 'group-single' );
}

// Add thumbnail size just for this custom post type
add_image_size( 'buddyboss_slides', 1040, 400, true );

/**
 * Add image size for cover photo.
 *
 * @since Boss 1.1.7
 */
if ( !function_exists( 'boss_cover_thumbnail' ) ) :

	add_action( 'after_setup_theme', 'boss_cover_thumbnail' );

	function boss_cover_thumbnail() {
		add_image_size( 'boss-cover-image', 1500, 500, true );
	}

endif;

/**
 * Buddyboss inbox layout support
 */
function boss_bb_inbox_selectbox() {
	if ( function_exists( 'bbm_inbox_pagination' ) ) {
		remove_action( 'bp_before_member_messages_threads', 'bbm_inbox_pagination', 99 );
	}
}

add_action( 'wp', 'boss_bb_inbox_selectbox' );

/**
 * Overriding BB Inbox Label button html
 * @param type $html
 * @return string
 */
function bbm_label_button_html_override( $html ) {
	$new_html = '<a class="bbm-label-button" title="Add/Create Label" href="javascript:void(0)">';
	$new_html .= '<span class="hida"><i class="fa fa-tag"></i></span>';
	$new_html .= '<p class="multiSel"></p></a>';

	return $new_html;
}

add_filter( 'bbm_label_button_html', 'bbm_label_button_html_override' );

/**
 * Woocommerce pages markup
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

add_action( 'woocommerce_before_main_content', 'buddyboss_theme_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content', 'buddyboss_theme_wrapper_end', 10 );

function buddyboss_theme_wrapper_start() {
	if ( is_active_sidebar( 'woo_sidebar' ) ) {
		echo '<div class="page-right-sidebar">';
	} else {
		echo '<div class="page-full-width">';
	}

	echo '<div id="primary" class="site-content">';
	echo '<div id="woo-content" role="main">';
}

function buddyboss_theme_wrapper_end() {
	echo '</div><!-- #woo-content -->';
	echo '</div><!-- #primary -->';
	if ( is_active_sidebar( 'woo_sidebar' ) ) {
		echo '<div id="secondary" class="widget-area" role="complementary">';
		dynamic_sidebar( 'woo_sidebar' );
		echo '</div><!-- #secondary -->';
	}
	echo '</div>';
}

/**
 * Woocommerce remove sidebar
 */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

/**
 * Buddypress Docs Count Tabs
 */
function bb_child_doc_menu_count_tabs() {
	global $bp, $wpdb;

	if ( ! function_exists( 'bp_is_active' ) ) {
		return;
	}

	$numdocsposts = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE (post_status = 'publish' AND post_type = 'bp_doc' AND post_author='" . bp_displayed_user_id() . "' AND ID NOT IN (SELECT object_id as post_id FROM `{$wpdb->prefix}term_relationships` WHERE term_taxonomy_id IN (SELECT term_taxonomy_id FROM `{$wpdb->prefix}term_taxonomy` where taxonomy='bpdw_is_wiki')))" );

	if ( 0 < $numdocsposts ) {
		$numdocsposts = number_format( $numdocsposts );
	}

	$name = get_option( 'bp-docs-user-tab-name' );
	if ( empty( $name ) ) {
		$name = __( 'Docs', 'boss' );
	}

	$bp->bp_nav[ 'docs' ][ 'name' ] = $name . ' <span class="count">' . $numdocsposts . '</span>';

	if ( bp_is_group() ) {
		$get_term_id = get_term_by( 'slug', 'bp_docs_associated_group_' . bp_get_current_group_id(), 'bp_docs_associated_item' );
		if ( $get_term_id ) {
			$get_term_id = $get_term_id->term_id;

			$numdocsposts = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE (post_status = 'publish' AND post_type = 'bp_doc' AND ID IN (SELECT object_id FROM {$wpdb->prefix}term_relationships WHERE term_taxonomy_id='{$get_term_id}') AND ID NOT IN (SELECT object_id as post_id FROM `{$wpdb->prefix}term_relationships` WHERE term_taxonomy_id IN (SELECT term_taxonomy_id FROM `{$wpdb->prefix}term_taxonomy` where taxonomy='bpdw_is_wiki')))" );

			if ( 0 < $numdocsposts ) {
				$numdocsposts = number_format( $numdocsposts );
			}

			$slug = bp_get_current_group_slug();

			$bp->bp_options_nav[ $slug ][ "docs" ][ "name" ] = '' . $bp->bp_options_nav[ $slug ][ "docs" ][ "name" ] . ' <span class="count">' . $numdocsposts . '</span>';
			;
			//$bp->bp_nav
		}
	}

	//print_r($bp);
}

if ( function_exists( 'bp_is_active' ) && (buddyboss_is_plugin_active( 'buddypress-docs/loader.php' )) ) {
	add_action( 'template_redirect', 'bb_child_doc_menu_count_tabs', 999 );
}

if ( buddyboss_is_plugin_active( 'buddypress-docs/loader.php' ) ) {
	add_action( 'template_redirect', 'bb_child_doc_menu_count_tabs', 999 );
}

// THIS GIVES US SOME OPTIONS FOR STYLING THE ADMIN AREA
function bb_child_custom_admin_styles() {
	echo '<style type="text/css">
			.ia-tabs.ia-tabs {padding-top: 0; }
			.ia-tabs.ia-tabs li {margin: 10px 7px; border-bottom: 1px solid #f9f9f9; border-radius: 5px;}
			.ia-tabs.ia-tabs li.current {border-color: #666;}
			.ia-tabs.ia-tabs li a {text-decoration: none;}

			@media screen and (max-width: 1024px) {
			   div.cs.cs p { padding-right: 0; }
			}

			@media screen and (max-width: 640px) {
			   div.cs-explain.cs-explain { clear:both; padding-left: 0; }
			}
         </style>';
}

add_action( 'admin_head', 'bb_child_custom_admin_styles' );

/*
 *  Set of functions for:
 *  BuddyPress Documents - Group document template
 *  Description: Sets group documents to display inside the group, rather than in its own template file.
 */

define( 'BBOSS_BPDOC_GDS_PATH', get_stylesheet_directory() );

//add_filter( 'bp_docs_get_doc_link', 'bboss_bp_doc_group_doc_permalink', 11, 2 );
function bboss_bp_doc_group_doc_permalink( $permalink, $doc_id ) {
	// BP 1.2/1.3 compatibility
	$is_group_component = function_exists( 'bp_is_current_component' ) ? bp_is_current_component( 'groups' ) : $bp->current_component == $bp->groups->slug;

	if ( $is_group_component ) {
		$permalink = trailingslashit( bp_get_group_permalink() ) . bp_docs_get_docs_slug() . '/?doc_id=' . $doc_id;
		//$permalink = bp_docs_get_group_doc_permalink( $doc_id );
	}
	return $permalink;
}

//add_filter( 'bp_docs_get_current_view', 'bboss_bp_doc_group_doc_set_view', 11, 2 );
function bboss_bp_doc_group_doc_set_view( $view, $item_type ) {
	if ( $item_type = 'group' && isset( $_GET[ 'doc_id' ] ) && $_GET[ 'doc_id' ] != '' ) {

		global $bboss_single_group_doc_view;
		$bboss_single_group_doc_view = 'bp_doc_group_doc_single';

		return 'list';
	}
	return $view;
}

//add_filter( 'bp_docs_locate_template', 'bboss_bp_doc_group_doc_single_template', 11, 2 );
function bboss_bp_doc_group_doc_single_template( $template_path, $template ) {
	remove_filter( 'bp_docs_locate_template', 'bboss_bp_doc_group_doc_single_template', 11, 2 );
	global $bp, $bboss_single_group_doc_view;

	if ( $bp->bp_docs->current_view == 'list' && $bboss_single_group_doc_view == 'bp_doc_group_doc_single' ) {

		add_filter( 'bp_docs_is_existing_doc', '__return_true', 11 );

		return BBOSS_BPDOC_GDS_PATH . 'bpdocs_gds/single/index.php';
	}
	return $template_path;
}

//add_filter( 'bp_docs_doc_action_links', 'bboss_bp_doc_group_doc_action_links', 11, 2 );
function bboss_bp_doc_group_doc_action_links( $links, $doc_id ) {
	// BP 1.2/1.3 compatibility
	$is_group_component = function_exists( 'bp_is_current_component' ) ? bp_is_current_component( 'groups' ) : $bp->current_component == $bp->groups->slug;

	if ( $is_group_component ) {
		$permalink	 = trailingslashit( bp_get_group_permalink() ) . bp_docs_get_docs_slug() . '/?doc_id=' . $doc_id;
		$links[ 0 ]	 = '<a href="' . $permalink . '">' . __( 'Read', 'bp-docs' ) . '</a>';
	}
	return $links;
}

function bboss_bp_doc_group_doc_comment_template_path( $path ) {
	return BBOSS_BPDOC_GDS_PATH . 'bpdocs_gds/single/comments.php';
}

//add_action( 'template_redirect', 'bboss_bp_doc_redirect_to_group' );
function bboss_bp_doc_redirect_to_group() {
	if ( !is_singular( 'bp_doc' ) )
		return;

	if ( bp_docs_is_doc_edit() || bp_docs_is_doc_history() )
		return;

	if ( function_exists( 'bp_is_active' ) && bp_is_active( 'groups' ) ) {
		$doc_group_ids	 = bp_docs_get_associated_group_id( get_the_ID(), false, true );
		$doc_groups		 = array();
		foreach ( $doc_group_ids as $dgid ) {
			$maybe_group = groups_get_group( 'group_id=' . $dgid );

			// Don't show hidden groups if the
			// current user is not a member
			if ( isset( $maybe_group->status ) && 'hidden' === $maybe_group->status ) {
				// @todo this is slow
				if ( !current_user_can( 'bp_moderate' ) && !groups_is_user_member( bp_loggedin_user_id(), $dgid ) ) {
					continue;
				}
			}

			if ( !empty( $maybe_group->name ) ) {
				$doc_groups[] = $maybe_group;
			}
		}

		if ( !empty( $doc_groups ) && count( $doc_groups ) == 1 ) {
			//the doc is asssociated with one group
			//redirect
			$group_link	 = bp_get_group_permalink( $doc_groups[ 0 ] );
			$permalink	 = trailingslashit( $group_link ) . bp_docs_get_docs_slug() . '/?doc_id=' . get_the_ID();

			wp_redirect( $permalink );
			exit();
		}
	}
}

function bp_doc_single_group_id( $return_dummy = true ) {
	$group_id = false;
	if ( function_exists( 'bp_is_active' ) && bp_is_active( 'groups' ) ) {
		if ( bp_docs_is_doc_create() ) {
			$group_slug = isset( $_GET[ 'group' ] ) ? $_GET[ 'group' ] : '';
			if ( $group_slug ) {
				global $bp, $wpdb;
				$group_id = $wpdb->get_var( $wpdb->prepare( "SELECT id FROM {$bp->groups->table_name} WHERE slug=%s", $group_slug ) );
			}
			if ( !$group_id ) {
				if ( $return_dummy )
					$group_id = 99999999;
			}
			return $group_id;
		}

		$doc_group_ids	 = bp_docs_get_associated_group_id( get_the_ID(), false, true );
		$doc_groups		 = array();
		foreach ( $doc_group_ids as $dgid ) {
			$maybe_group = groups_get_group( 'group_id=' . $dgid );

			// Don't show hidden groups if the
			// current user is not a member
			if ( isset( $maybe_group->status ) && 'hidden' === $maybe_group->status ) {
				// @todo this is slow
				if ( !current_user_can( 'bp_moderate' ) && !groups_is_user_member( bp_loggedin_user_id(), $dgid ) ) {
					continue;
				}
			}

			if ( !empty( $maybe_group->name ) ) {
				$doc_groups[] = $dgid;
			}
		}

		if ( !empty( $doc_groups ) && count( $doc_groups ) == 1 ) {
			$group_id = $doc_groups[ 0 ];
		}
	}

	if ( !$group_id ) {
		if ( $return_dummy )
			$group_id = 99999999;
	}
	return $group_id;
}

add_action( 'bp_group_options_nav', 'bboss_bpd_sg_save_group_navs_info' );

/**
 * Apparantely, there is no direct way of determining what all nav items will be displayed on a group page.
 *
 * So we'll hook into this action and save the nav items in db for later use.
 *
 * @since 0.0.1
 */
function bboss_bpd_sg_save_group_navs_info() {
	$bp = buddypress();

	if ( !bp_is_single_item() )
		return;
	/**
	 * get all nav items for a single group
	 */
	$group_navs = array();
    $bp_options_nav = buddyboss_bp_options_nav( bp_current_component(), bp_current_item() );
    if( empty( $bp_options_nav ) ){
		return false;
	} else {
		$the_index = bp_current_item();
	}

	// Loop through each navigation item
	foreach ( (array) $bp_options_nav as $subnav_item ) {

        if ( empty( $subnav_item[ 'slug' ] ) ) continue;

		$item = array(
			'name'		 => $subnav_item[ 'name' ],
			'position'	 => $subnav_item[ 'position' ],
		);

		$group_navs[ $subnav_item[ 'slug' ] ] = $item;
	}

	update_option( 'bboss_bpd_sg_group_navs_info', $group_navs );
}

/**
 *
 */
function bboss_bpd_sg_get_create_link( $link ) {

	if( ! bp_is_active( 'groups' ) ) return $link;

	$slug = bp_get_group_slug();
	if ( $slug && current_user_can( 'bp_docs_associate_with_group', bp_get_group_id() ) ) {
		$link = add_query_arg( 'group', $slug, $link );
	}

	return $link;
}

/**
 * Manage logo height for top bar
 */
if ( !function_exists( 'boss_logo_height' ) ) {

	function boss_logo_height( $size ) {
		$h = 74;

		if ( $size == 'big' ) {
			$site_logo_id		 = boss_get_option( 'boss_logo', 'id' );
			$site_logo_img	 = wp_get_attachment_image_src( $site_logo_id, 'full' );
			$boss_fixed_logo_width	 = 187;
			$boss_site_logo_width		 = $site_logo_img[ 1 ];
			$boss_site_logo_height		 = $site_logo_img[ 2 ];
		} else {
			$site_logo_id		 = boss_get_option( 'boss_small_logo', 'id' );
			$logo_img	 = wp_get_attachment_image_src( $site_logo_id, 'full' );
			$boss_fixed_logo_width	 = 45;
			$boss_site_logo_width		 = $logo_img[ 1 ];
			$boss_site_logo_height		 = $logo_img[ 2 ];
		}

		if ( $site_logo_id && ( $boss_site_logo_width > $boss_fixed_logo_width ) ) {
			$ratio = $boss_site_logo_height / $boss_site_logo_width;
			$h = ceil( $ratio * $boss_fixed_logo_width ) + 10; // 10 is padding-top + padding-bottom given to #mastlogo
		}

		return ( $h > 74 ) ? $h : 74;
	}

}

/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own buddyboss_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Boss 1.0.0
 */
if ( !function_exists( 'buddyboss_comment' ) ) {

	function buddyboss_comment( $comment, $args, $depth ) {
		$GLOBALS[ 'comment' ] = $comment;
		switch ( $comment->comment_type ) {
			case 'pingback' :
			case 'trackback' :
				// Display trackbacks differently than normal comments.
				?>
				<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
					<p><?php _e( 'Pingback:', 'boss' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'boss' ), '<span class="edit-link">', '</span>' ); ?></p>
					<?php
					break;
				default :
					// Proceed with normal comments.
					global $post;
					?>
				<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
					<article id="comment-<?php comment_ID(); ?>" class="comment">

						<div class="table-cell avatar-col">
							<?php echo get_avatar( $comment, 60 ); ?>
						</div><!-- .comment-left-col -->

						<div class="table-cell">
							<header class="comment-meta comment-author vcard">
								<?php
								printf( '<cite class="fn">%1$s %2$s</cite>', get_comment_author_link(),
								// If current post author is also comment author, make it known visually.
				( $comment->user_id === $post->post_author ) ? '<span> ' . __( 'Post author', 'boss' ) . '</span>' : ''
								);
								?>
							</header><!-- .comment-meta -->

							<?php if ( '0' == $comment->comment_approved ) : ?>
								<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'boss' ); ?></p>
							<?php endif; ?>

							<section class="comment-content comment">
								<?php comment_text(); ?>
							</section><!-- .comment-content -->

							<footer class="comment-meta">
								<?php
								printf( '<a href="%1$s"><time datetime="%2$s">%3$s ago</time></a>', esc_url( get_comment_link( $comment->comment_ID ) ), get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */ human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) )
								);
								?>
								<span class="entry-actions">
									<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( '<i class="fa fa-reply"></i>', 'boss' ), 'depth' => $depth, 'max_depth' => $args[ 'max_depth' ] ) ) ); ?>
								</span><!-- .entry-actions -->
								<?php edit_comment_link( __( 'Edit', 'boss' ), '<span class="edit-link">', '</span>' ); ?>
							</footer>
						</div>
					</article><!-- #comment-## -->
					<?php
					break;
			}
		}

	}

	function boss_get_docs_group_id() {
		// First, try to set the preselected group by looking at the URL params
		$selected_group_slug = isset( $_GET[ 'group' ] ) ? $_GET[ 'group' ] : '';

		// See if we're associated with a group
		if ( ! function_exists( 'bp_is_active' ) || ! bp_is_active( 'groups' ) ) {
			return 0;
		}

		// Support for BP Group Hierarchy
		if ( false !== $slash = strrpos( $selected_group_slug, '/' ) ) {
			$selected_group_slug = substr( $selected_group_slug, $slash + 1 );
		}

		$selected_group = BP_Groups_Group::get_id_from_slug( $selected_group_slug );
		if ( $selected_group && !current_user_can( 'bp_docs_associate_with_group', $selected_group ) ) {
			$selected_group = 0;
		}

		// If the selected group is still 0, see if there's something in the db
		if ( !$selected_group && is_singular() ) {
			$selected_group = bp_docs_get_associated_group_id( get_the_ID() );
		}

		// Last check: if this is a second attempt at a newly created Doc,
		// there may be a previously submitted value
		if ( empty( $selected_group ) && !empty( buddypress()->bp_docs->submitted_data->associated_group_id ) ) {
			$selected_group = intval( buddypress()->bp_docs->submitted_data->associated_group_id );
		}

		return intval( $selected_group );
	}

	if ( !function_exists( 'boss_pmpro_getLevelCost' ) ):

		/**
		 * Get nicer price formatting for Membership PRO tables
		 * @since Boss 2.0.2
		 */
		function boss_pmpro_getLevelCost( &$level, $tags = true, $short = false ) {
			//initial payment
			if ( !$short )
				$r	 = sprintf( __( 'The price for membership is <strong>%s</strong> now', 'boss' ), pmpro_formatPrice( $level->initial_payment ) );
			else
				$r	 = sprintf( __( '<strong><span>%s</span> now</strong>', 'boss' ), pmpro_formatPrice( $level->initial_payment ) );

			//recurring part
			if ( $level->billing_amount != '0.00' ) {
				if ( $level->billing_limit > 1 ) {
					if ( $level->cycle_number == '1' ) {
						$r .= sprintf( __( ' and then <strong>%s per %s for %d more %s</strong>.', 'boss' ), pmpro_formatPrice( $level->billing_amount ), pmpro_translate_billing_period( $level->cycle_period ), $level->billing_limit, pmpro_translate_billing_period( $level->cycle_period, $level->billing_limit ) );
					} else {
						$r .= sprintf( __( ' and then <strong>%s every %d %s for %d more %s</strong>.', 'boss' ), pmpro_formatPrice( $level->billing_amount ), $level->cycle_number, pmpro_translate_billing_period( $level->cycle_period, $level->cycle_number ), $level->billing_limit, pmpro_translate_billing_period( $level->cycle_period, $level->billing_limit ) );
					}
				} elseif ( $level->billing_limit == 1 ) {
					$r .= sprintf( __( ' and then <strong>%s after %d %s</strong>.', 'boss' ), pmpro_formatPrice( $level->billing_amount ), $level->cycle_number, pmpro_translate_billing_period( $level->cycle_period, $level->cycle_number ) );
				} else {
					if ( $level->billing_amount === $level->initial_payment ) {
						if ( $level->cycle_number == '1' ) {
							if ( !$short )
								$r	 = sprintf( __( 'The price for membership is <strong>%s per %s</strong>.', 'boss' ), pmpro_formatPrice( $level->initial_payment ), pmpro_translate_billing_period( $level->cycle_period ) );
							else
								$r	 = sprintf( __( '<strong><span>%s</span> per %s</strong>.', 'boss' ), pmpro_formatPrice( $level->initial_payment ), pmpro_translate_billing_period( $level->cycle_period ) );
						}
						else {
							if ( !$short )
								$r	 = sprintf( __( 'The price for membership is <strong>%s every %d %s</strong>.', 'boss' ), pmpro_formatPrice( $level->initial_payment ), $level->cycle_number, pmpro_translate_billing_period( $level->cycle_period, $level->cycle_number ) );
							else
								$r	 = sprintf( __( '<strong><span>%s</span> every %d %s</strong>.', 'boss' ), pmpro_formatPrice( $level->initial_payment ), $level->cycle_number, pmpro_translate_billing_period( $level->cycle_period, $level->cycle_number ) );
						}
					} else {
						if ( $level->cycle_number == '1' ) {
							$r .= sprintf( __( ' and then <strong>%s per %s</strong>.', 'boss' ), pmpro_formatPrice( $level->billing_amount ), pmpro_translate_billing_period( $level->cycle_period ) );
						} else {
							$r .= sprintf( __( ' and then <strong>%s every %d %s</strong>.', 'boss' ), pmpro_formatPrice( $level->billing_amount ), $level->cycle_number, pmpro_translate_billing_period( $level->cycle_period, $level->cycle_number ) );
						}
					}
				}
			} else
				$r .= '.';

			//add a space
			$r .= ' ';

			//trial part
			if ( $level->trial_limit ) {
				if ( $level->trial_amount == '0.00' ) {
					if ( $level->trial_limit == '1' ) {
						$r .= ' ' . __( 'After your initial payment, your first payment is Free.', 'boss' );
					} else {
						$r .= ' ' . sprintf( __( 'After your initial payment, your first %d payments are Free.', 'boss' ), $level->trial_limit );
					}
				} else {
					if ( $level->trial_limit == '1' ) {
						$r .= ' ' . sprintf( __( 'After your initial payment, your first payment will cost %s.', 'boss' ), pmpro_formatPrice( $level->trial_amount ) );
					} else {
						$r .= ' ' . sprintf( __( 'After your initial payment, your first %d payments will cost %s.', 'boss' ), $level->trial_limit, pmpro_formatPrice( $level->trial_amount ) );
					}
				}
			}

			//taxes part
			$tax_state	 = pmpro_getOption( "tax_state" );
			$tax_rate	 = pmpro_getOption( "tax_rate" );

			if ( $tax_state && $tax_rate && !pmpro_isLevelFree( $level ) ) {
				$r .= sprintf( __( 'Customers in %s will be charged %s%% tax.', 'boss' ), $tax_state, round( $tax_rate * 100, 2 ) );
			}

			if ( !$tags )
				$r = strip_tags( $r );

			$r = apply_filters( "pmpro_level_cost_text", $r, $level, $tags, $short ); //passing $tags and $short since v2.0
			return $r;
		}

	endif;

/**
 * Cart icon html
 */
function boss_cart_icon_html() {

	global $woocommerce;
	if ( $woocommerce ) {
		$cart_items = $woocommerce->cart->cart_contents_count;
		?>

		<div class="header-notifications cart">
			<a class="cart-notification notification-link fa fa-shopping-cart" href="<?php echo $woocommerce->cart->get_cart_url(); ?>">
				<?php if ( $cart_items ) { ?>
					<span><?php echo $cart_items; ?></span>
				<?php } ?>
			</a>
		</div>
		<?php
	}
}

if( defined('EM_VERSION') && EM_VERSION ) {
    add_action('em_options_page_footer_formats', 'boss_events_setup');
    /**
     * Add settings page
     */
    function boss_events_setup(){
        global $save_button, $events_placeholder_tip;
        ?>
        <div  class="postbox " id="em-opt-boss-events-formats" >
        <div class="handlediv" title="<?php __('Click to toggle', 'boss'); ?>"><br /></div><h3><span><?php _e ( 'BuddyBoss Events', 'boss' ); ?> </span></h3>
        <div class="inside">
            <table class="form-table">
                <tr class="em-header"><td colspan="2">
                    <h4><?php echo sprintf(__('%s Page','boss'),__('Events','boss')); ?></h4>
                    <p><?php _e('These formats will be used on your events page. They will override settings previously set on "Events" dropdown of this page. This will also be used if you do not provide specified formats in other event lists, like in shortcodes.','boss'); ?></p>
                </td></tr>
                <?php
                em_options_radio_binary ( __( 'Use BuddyBoss list layout?', 'boss' ), 'dbem_bb_event_list_layout', __( "Use BuddyBoss grid layout.",'boss' ) );
                em_options_textarea ( __( 'Default event list format header', 'boss' ), 'dbem_bb_event_list_item_format_header', __( 'This content will appear just above your code for the default event list format. Default is blank', 'boss' ) );
                em_options_textarea ( __( 'Default event list format', 'boss' ), 'dbem_bb_event_list_item_format', __( 'The format of any events in a list.', 'boss' ).$events_placeholder_tip );
                em_options_textarea ( __( 'Default event list format footer', 'boss' ), 'dbem_bb_event_list_item_format_footer', __( 'This content will appear just below your code for the default event list format. Default is blank', 'boss' ) );
                em_options_textarea ( __( 'Default event grid format header', 'boss' ), 'dbem_bb_event_grid_item_format_header', __( 'This content will appear just above your code for the default event grid format. Default is blank', 'boss' ) );
                em_options_textarea ( __( 'Default event grid format', 'boss' ), 'dbem_bb_event_grid_item_format', __( 'The format of any events in a list.', 'boss' ).$events_placeholder_tip );
                em_options_textarea ( __( 'Default event grid format footer', 'boss' ), 'dbem_bb_event_grid_item_format_footer', __( 'This content will appear just below your code for the default event grid format. Default is blank', 'boss' ) );
                ?>
                <tr class="em-header">
                    <td colspan="2">
                        <h4><?php echo sprintf(__('Single %s Page','boss'),__('Event','boss')); ?></h4>
                        <em><?php echo sprintf(__('These formats can be used on %s pages or on other areas of your site displaying an %s.','boss'),__('event','boss'),__('event','boss'));?></em>
                </tr>
                <?php
//                em_options_textarea ( sprintf(__('Single %s page header format', 'boss' ),__('event','boss')), 'dbem_bb_single_event_header_format', sprintf(__( 'Choose how to format your event headings.', 'boss' ),__('event','boss')).$events_placeholder_tip );
                em_options_radio_binary ( __( 'Use BuddyBoss single event layout?', 'boss' ), 'dbem_bb_single_event', __( "Use BuddyBoss single event layout.",'boss' ) );
                em_options_textarea ( sprintf(__('Single %s page format', 'boss' ),__('event','boss')), 'dbem_bb_single_event_format', sprintf(__( 'The format used to display %s content on single pages or elsewhere on your site.', 'boss' ),__('event','boss')).$events_placeholder_tip );

                echo $save_button;
                ?>
            </table>
        </div> <!-- . inside -->
        </div> <!-- .postbox -->
    <?php
    }

    add_filter('em_ml_translatable_options', 'boss_add_translatable_options', 10, 1);
    /**
     * Add options to translatable array
     * @param array $array Options array
     */
    function boss_add_translatable_options($array){
        array_push($array, 'dbem_bb_event_list_layout', 'dbem_bb_event_list_item_format_header', 'dbem_bb_event_list_item_format', 'dbem_bb_event_list_item_format_footer', 'dbem_bb_event_grid_layout', 'dbem_bb_event_grid_item_format_header', 'dbem_bb_event_grid_item_format', 'dbem_bb_event_grid_item_format_footer', 'dbem_bb_single_event', 'dbem_bb_single_event_format');
    }

    add_filter('em_content_events_args', 'boss_events_page_arguments', 10, 1);
    /**
     * Events page agruments
     * @param  array $args Arguments array
     * @return array Arguments array
     */
    function boss_events_page_arguments($args){
        $layout = 'list';
        if ( !isset( $_COOKIE[ 'events_layout' ] ) ) {
            if(get_option('dbem_bb_event_list_layout')) {
                $layout = 'list';
            }
            if(get_option('dbem_bb_event_grid_layout')) {
                $layout = 'grid';
            }
        } else {
            $layout = $_COOKIE[ 'events_layout' ];
        }

        $args['format_header']  = get_option('dbem_bb_event_'.$layout.'_item_format_header');
        $args['format']         = get_option('dbem_bb_event_'.$layout.'_item_format');
        $args['format_footer']  = get_option('dbem_bb_event_'.$layout.'_item_format_footer');

        return $args;
    }

    if(get_option('dbem_bb_single_event')) {

        add_filter('em_event_output_single', 'boss_single_event', 10, 3 );
        /**
         * Use Boss Setting on Single Event page
         */
        function boss_single_event($output, $object, $target) {
            $format = get_option('dbem_bb_single_event_format');
            return $object->output($format, $target);
        }
    }

//    add_action('em_options_page_footer_formats', 'boss_events_default_options');
    /**
     * Prepate things on theme switch
     */
    function boss_events_default_options() {
        $bb_event_options = array(
            'dbem_full_calendar_event_format' => '<li style="background-color: #_CATEGORYCOLOR">#_EVENTLINK</li>',
            'dbem_bb_event_list_layout' => 1,
            'dbem_bb_event_list_item_format_header' => '<table cellpadding="0" cellspacing="0" class="events-table" >
            <thead>
                <tr>
                    <th class="event-time" width="150">'.__('Date/Time','boss').'</th>
                    <th class="event-description" width="*">'.__('Event','boss').'</th>
                    <th class="event-location" width="*">'.__('Location','boss').'</th>
                </tr>
            </thead>
            <tbody>',
            'dbem_bb_event_list_item_format' => '<tr>
                <td class="event-time">
                    <i class="fa fa-calendar"></i>#_EVENTDATES<br/>
                    <i class="fa fa-clock-o"></i>#_EVENTTIMES
                </td>
                <td class="event-description">
                    <span class="event-image">
                    #_EVENTIMAGE{100,100}
                    </span>
                    <span class="event-details">
                    #_EVENTLINK
                    {has_location}<br/><span>#_LOCATIONNAME</span>{/has_location}
                    </span>
                </td>
                <td class="event-location">
                    {has_location}<i class="fa fa-globe"></i><span>#_LOCATIONTOWN #_LOCATIONSTATE</span>{/has_location}
                </td>
            </tr>',
            'dbem_bb_event_list_item_format_footer' => '</tbody></table>',
            'dbem_bb_event_grid_layout' => 0,
            'dbem_bb_event_grid_item_format_header' => '<div class="events-grid">',
            'dbem_bb_event_grid_item_format' => '<div class="event-item">
                <a href="#_EVENTURL" class="event-image">
                #_EVENTIMAGECROP{events_thumbnail}
                </a>
                #_EVENTLINK
                <div class="event-details">
                {has_location}<span>#_LOCATIONNAME, #_LOCATIONTOWN #_LOCATIONSTATE</span>{/has_location}
                </div>
                <div class="event-time">
                #_EVENTDATES<span> / </span>#_EVENTTIMES
                </div>
            </div>',
            'dbem_bb_event_grid_item_format_footer' => '</div>',
            'dbem_bb_single_event_format' => '<div class="event-image">#_EVENTIMAGE{1400,332}</div>
             #_EVENTNOTES
            <div class="event-details">
            <div style="float:right; margin:0px 0px 0 15px;">#_LOCATIONMAP</div>
            <p>
                <strong>'.__('Date/Time', 'boss').'</strong>
               #_EVENTDATES @ <i>#_EVENTTIMES</i>
            </p>
            {has_location}
            <p>
                <strong>'.__('Location', 'boss').'</strong>
                #_LOCATIONLINK
            </p>
            {/has_location}
            <p>
                <strong>'.__('Categories', 'boss').'</strong>
                #_CATEGORIES
            </p>
</div>
             {has_bookings}
            <h3>'.__('Bookings', 'boss').'</h3>
            #_BOOKINGFORM
            {/has_bookings}',
            'dbem_image_min_width' => 200,
		    'dbem_image_min_height' => 200
//            'dbem_bb_single_event_header_format' => '<h1 class="entry-title">#s</h1><div class="subtitle">#_EVENTDATES @ #_EVENTTIMES</div>'
        );

        //add new options
        foreach($bb_event_options as $key => $value){
            add_option($key, $value);
        }

        $events_page_id = get_option ( 'dbem_events_page' );
        $events_page = array(
          'ID'           => $events_page_id,
          'page_template'  => 'page-events.php'
        );
        wp_update_post( $events_page );
    }

	/**
	 * Since strait call to boss_events_default_options giving a php warning, boss_events_default_options call is moved on init with priority 11
	 */
	add_action( 'init', 'boss_events_default_options', 11 );


    add_filter( 'body_class', 'boss_events_page_class' );
    /**
     * Evants Page body class
     * @param  array $classes Body classes
     * @return array Body classes
     */
    function boss_events_page_class( $classes ) {
        global $post;
        $events_page_id = get_option ( 'dbem_events_page' );

        if($post->ID == $events_page_id) {
            $classes[] = 'events-page';
        }

        if($post->ID == $events_page_id && get_option('dbem_display_calendar_in_events_page')) {
            $classes[] = 'fullcalendar-page';
        }
        return array_unique( $classes );
    }

    add_action( 'widgets_init', 'boss_events_widgets' );
    /**
     * Events Sidebar
     */
    function boss_events_widgets(){
        register_sidebar( array(
            'name'			 => 'Events Sidebar',
            'id'			 => 'events',
            'description'	 => 'Only display on events pages',
            'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'	 => '</aside>',
            'before_title'	 => '<h4 class="widgettitle">',
            'after_title'	 => '</h4>',
        ) );
    }
}

// Add thumbnail size just events
add_image_size( 'events_thumbnail', 200, 200, true );

/**
 * Crop Event Image by string name
 *
 */
if ( !function_exists( 'boss_hard_crop_event_image' ) ):

add_filter('em_event_output', 'boss_hard_crop_event_image', 10, 4);

function boss_hard_crop_event_image($event_string, $post, $format, $target) {
    preg_match_all("/(#@?_?[A-Za-z0-9]+)({([^}]+)})?/", $event_string, $placeholders);
    $replaces = array();

    foreach($placeholders[1] as $key => $result) {
        $match = true;
        $replace = '';
        $full_result = $placeholders[0][$key];
        if( '#_EVENTIMAGECROP' == $result ) {
            $image_size = $placeholders[3][$key];
            $replace = get_the_post_thumbnail($post->ID, $image_size);
            $event_string = preg_replace( "/".$result."({([^}]+)})?/", $replace, $event_string );
        }
    }
    return $event_string;
}

endif;


if ( !function_exists( 'boss_profile_achievements' ) ):
/**
 * Output badges on profile
 *
 */
function boss_profile_achievements() {
	global $user_ID;

	//user must be logged in to view earned badges and points

	if ( is_user_logged_in() && function_exists( 'badgeos_get_user_achievements' ) ) {

		$achievements = badgeos_get_user_achievements( array( 'user_id' => bp_displayed_user_id() ) );

		if ( is_array( $achievements ) && !empty( $achievements ) ) {

			$number_to_show	 = 5;
			$thecount		 = 0;

			wp_enqueue_script( 'badgeos-achievements' );
			wp_enqueue_style( 'badgeos-widget' );

			//load widget setting for achievement types to display
			$set_achievements = ( isset( $instance[ 'set_achievements' ] ) ) ? $instance[ 'set_achievements' ] : '';

			//show most recently earned achievement first
			$achievements = array_reverse( $achievements );

			echo '<ul class="profile-achievements-listing">';

			foreach ( $achievements as $achievement ) {

				//verify achievement type is set to display in the widget settings
				//if $set_achievements is not an array it means nothing is set so show all achievements
				if ( !is_array( $set_achievements ) || in_array( $achievement->post_type, $set_achievements ) ) {

					//exclude step CPT entries from displaying in the widget
					if ( get_post_type( $achievement->ID ) != 'step' ) {

						$permalink	 = get_permalink( $achievement->ID );
						$title		 = get_the_title( $achievement->ID );
						$img		 = badgeos_get_achievement_post_thumbnail( $achievement->ID, array( 50, 50 ), 'wp-post-image' );
						$thumb		 = $img ? '<a style="margin-top: -25px;" class="badgeos-item-thumb" href="' . esc_url( $permalink ) . '">' . $img . '</a>' : '';
						$class		 = 'widget-badgeos-item-title';
						$item_class	 = $thumb ? ' has-thumb' : '';

						// Setup credly data if giveable
						$giveable	 = credly_is_achievement_giveable( $achievement->ID, $user_ID );
						$item_class .= $giveable ? ' share-credly addCredly' : '';
						$credly_ID	 = $giveable ? 'data-credlyid="' . absint( $achievement->ID ) . '"' : '';

						echo '<li id="widget-achievements-listing-item-' . absint( $achievement->ID ) . '" ' . $credly_ID . ' class="widget-achievements-listing-item' . esc_attr( $item_class ) . '">';
						echo $thumb;
						echo '<a class="widget-badgeos-item-title ' . esc_attr( $class ) . '" href="' . esc_url( $permalink ) . '">' . esc_html( $title ) . '</a>';
						echo '</li>';

						$thecount++;

						if ( $thecount == $number_to_show && $number_to_show != 0 ) {
							echo '<li id="widget-achievements-listing-item-more" class="widget-achievements-listing-item">';
							echo '<a class="badgeos-item-thumb" href="' . bp_core_get_user_domain( get_current_user_id() ) . '/achievements/"><span class="fa fa-ellipsis-h"></span></a>';
							echo '<a class="widget-badgeos-item-title ' . esc_attr( $class ) . '" href="' . bp_core_get_user_domain( get_current_user_id() ) . '/achievements/">' . __( 'See All', 'social-learner' ) . '</a>';
							echo '</li>';
							break;
						}
					}
				}
			}

			echo '</ul><!-- widget-achievements-listing -->';
		}
	}
}

endif;

/**
* Run custom slider shortcode
*/
if(!function_exists('boss_execute_slider_shortcode')):
function boss_execute_slider_shortcode(){
    $slider_shortcode = boss_get_option('boss_plugins_slider') ;
    if(!empty($slider_shortcode) && !boss_get_option( 'boss_slider_switch' )){
    echo do_shortcode(boss_get_option('boss_plugins_slider'));
}
}
endif;

add_action('boss_custom_slider', 'boss_execute_slider_shortcode');

/**
 * Boss header nav > Dashboard
 */
function boss_header_dashboard_subnav_links() { ?>
	<div class="ab-sub-wrapper">
		<ul class="ab-submenu">
			<li>

				<?php if ( current_user_can( 'edit_theme_options' ) ) : ?>
				<a href="<?php echo admin_url( 'admin.php?page=boss_options' ); ?>"><?php _e( 'Boss Options', 'boss' ); ?></a>
				<a href="<?php echo admin_url( 'customize.php' ); ?>"><?php _e( 'Customize', 'boss' ); ?></a>
				<a href="<?php echo admin_url( 'widgets.php' ); ?>"><?php _e( 'Widgets', 'boss' ); ?></a>
				<a href="<?php echo admin_url( 'nav-menus.php' ); ?>"><?php _e( 'Menus', 'boss' ); ?></a>
				<a href="<?php echo admin_url( 'themes.php' ); ?>"><?php _e( 'Themes', 'boss' ); ?></a>
				<?php endif; ?>

				<?php if ( current_user_can( 'activate_plugins' ) ): ?>
				<a href="<?php echo admin_url( 'plugins.php' ); ?>"><?php _e( 'Plugins', 'boss' ); ?></a>
				<?php endif; ?>

				<a href="<?php echo admin_url( 'profile.php' ); ?>"><?php _e( 'Profile', 'boss' ); ?></a>

			</li>
		</ul>
	</div>
	<?php
}

if( !function_exists( 'buddyboss_bp_options_nav' ) ):
/**
 * Support legacy buddypress nav items manipulation
 */
function buddyboss_bp_options_nav( $component_index = false, $current_item = false ){
    $secondary_nav_items = false;

    $bp = buddypress();

    $version_compare = version_compare( BP_VERSION, '2.6', '<' );
    if ( $version_compare ){
        /**
         * @todo In future updates, remove the version compare check completely and get rid of legacy code
         */

        //legacy code
        $secondary_nav_items = isset( $bp->bp_options_nav[ $component_index ] ) ? $bp->bp_options_nav[ $component_index ] : false;
    } else {
        //new navigation apis

        // Default to the Members nav.
        if( !bp_is_single_item() ){
            $secondary_nav_items = $bp->members->nav->get_secondary( array( 'parent_slug' => $component_index ) );
        } else {
            $component_index =  $component_index ? $component_index : bp_current_component();
            $current_item = $current_item ? $current_item : bp_current_item();

            // If the nav is not defined by the parent component, look in the Members nav.
            if ( ! isset( $bp->{$component_index}->nav ) ) {
                $secondary_nav_items = $bp->members->nav->get_secondary( array( 'parent_slug' => $current_item ) );
            } else {
                $secondary_nav_items = $bp->{$component_index}->nav->get_secondary( array( 'parent_slug' => $current_item ) );
            }
        }
    }

    return $secondary_nav_items;
}
endif;
