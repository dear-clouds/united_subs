<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }
/**
 * WOFFICE CUSTOM Functions
 * MAPS : 
 * - THEME SETUP
 * - PAGE TITLE FOR WORDPRESS 4.1 +
 * - CHANGES FROM THE THEME SETTINGS
 * - AUTOCOMPLETE FORM
 * - PRIVATE WEBSITE 
 * - LOGIN PAGE
 * - Create JSON File for Web APP ICON On android
 * - LANGUAGE SWITCHERS
 * - BUDDYPRESS CHANGES
 * - CUSTOM SEARCH FORM 
 * - REGISTER SIDEBARS
 * - WOFFICE FAVICON
 * - WOFFICE HEADER
 * - WOFFICE NAVIGATION
 * - WOFFICE POST METADATAS
 * - FILTERS FOR THE COMMENTS
 * - WOFFICE USERS ONLINE
 * - WOFFICE IS USER ALLOWED TO SEE CONTENT
 * - WOFFICE EXTRAFOOTER
 * - WOFFICE CURRENT TIME IN THE HEADER
 * - WOFFICE PROJECT PROGRESS PERCENTAGE
 * - CREATE A NEW CATEGORY FOR FILE MANANAGER FOR THE PROJECT POST TYPE
 * - Extend the default WordPress post classes.
 * - REMOVE SOME UNYSON EXTENSIONS
 * - REMOVE EVENTON WIDGETS
 * - MV FIle Sharing Customization
 * - 
 * - Add more buttons to the html editor
 * - ADDING DOCUMENTATION LINK
 * - THE ADMIN BAR
 */
/**
 * Basic features for Wordpress setup
 */
if ( ! function_exists( 'woffice_action_theme_setup' ) ) : 
function woffice_action_theme_setup() {

	/*
	 * Make Theme available for translation.
	 */
	load_theme_textdomain( 'woffice', get_template_directory() . '/languages' );

	// Add RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// Enable support for Post Thumbnails, and declare two sizes.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 800, 600, true );
	add_image_size( 'fw-theme-full-width', 1038, 576, true );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption'
	) );
	
	/* Woocommerce Support since @1.2.0 */
	add_theme_support( 'woocommerce' );
	
	/*add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'audio',
		'quote',
		'link',
		'gallery',
	) );*/
	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );

	// CONTENT WIDTH
	if ( ! isset( $content_width ) ) $content_width = 900;
}
endif;
add_action( 'init', 'woffice_action_theme_setup' );
/**
 * PAGE TITLE FOR WORDPRESS 4.1 +
 */
function woffice_theme_slug_setup() {
	add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'woffice_theme_slug_setup' );
//TITLE RENDER IF IT IS NOT WP 4.1
if ( ! function_exists( '_wp_render_title_tag' ) ) :
	function woffice_theme_slug_render_title() { ?>
		<title><?php wp_title( '|', true, 'right' ); ?></title>
	<?php }
	add_action( 'wp_head', 'woffice_theme_slug_render_title' );
endif;
/*---------------------------------------------------------
** 
** CHANGES FROM THE THEME SETTINGS
**
----------------------------------------------------------*/
require_once(get_template_directory() . '/inc/customize.php');

/*---------------------------------------------------------
** 
** AUTOCOMPLETE FORM 
**
----------------------------------------------------------*/
require_once(get_template_directory() . '/inc/autocomplete.php');

/*---------------------------------------------------------
** 
** REDIRECT STUFF 
** We redirect custom visitors or not
**
----------------------------------------------------------*/
function woffice_redirect_user() {
	
	// We get the site status 
	$public = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('public') : '';
	// If site is public & user isn't logged we'll check for the pages
	if ($public == "nope" && !is_user_logged_in() ) {
		
		// Redirect constant
		//$redirect = false;
		
		// We get the login page to avoid infinite loop : 
		$login_page_slug = woffice_get_login_page_name();
		if (!is_page($login_page_slug)) {
			
			// We need it to know if tge first one is condition is checked (Buddypress)
			$buddypress_check_passed = false;
		
			// We check for Buddypress components : 
			if (function_exists("woffice_is_user_allowed_buddypress")) {
				// We run it only for Buddypress pages
				if (is_buddypress()) {
					$buddypress_check = woffice_is_user_allowed_buddypress("redirect");
					if ($buddypress_check == false) {
						wp_redirect(  esc_url( home_url( '/wp-login.php' ) ) );
						exit();
					}
					else {
						$buddypress_check_passed = true;
					}
				}
			}
			
			if ($buddypress_check_passed != true) {
			
				// We check for excluded page - Check if there is some pages that need to be public
				$excluded_pages = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('excluded_pages') : ''; 
				$the_pages_tmp = array();
				$it_is_blog_component = false;
				if (!empty($excluded_pages)) {
					
					// We check for the Blog page : 
					$page_for_posts = get_option( 'page_for_posts' );
					$ID_page_for_posts = (!empty($page_for_posts)) ? $page_for_posts : 0;
					// If the blog page is in the excluded pages && it's this page: 
					if (in_array($ID_page_for_posts, $excluded_pages) && $ID_page_for_posts != 0 && (is_home() || is_singular('post'))) {
						$it_is_blog_component = true;
					}

					// We fill the array 
					foreach ($excluded_pages as $page){
						$the_pages_tmp[] = $page;
					}
					
				}
				else {
					$the_pages_tmp = array("-1");
				}

				// We check for the Woocommerce products : 
				if (function_exists('is_woocommerce')) {
					$products_public = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('products_public') : ''; 
					if ($products_public == "yep" && is_product()){
						$allowed_product = true;
					} 
					else {
						$allowed_product = false;
					}
				}
				else {
					$allowed_product = false;
				}
				
				// If it's not one of the excluded pages AND Not the blog page, we redirect :
				if (!is_page($the_pages_tmp) && $it_is_blog_component == false && $allowed_product == false) {
					// We check for custom login page
					$login_custom = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('login_custom') : '';
					if ($login_custom != "nope") {
						$login_page_slug = woffice_get_login_page_name();
						$login_page = home_url('/' . $login_page_slug . '/');
						wp_redirect($login_page);
						exit();
					} else {
						wp_redirect(esc_url(home_url('/wp-login.php')));
						exit();
					}
				}
			
			}
			
		}
		
	} 
}

add_action( 'template_redirect', 'woffice_redirect_user' );
/*---------------------------------------------------------
** 
** LOGIN PAGE
**
----------------------------------------------------------*/

$login_custom = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('login_custom') : ''; 
if ($login_custom != "nope") : 

	// CREATE THE LOGIN PAGE
	global $wpdb;
	$table_name = $wpdb->prefix . 'posts';
	$check_page = $wpdb->get_row("SELECT post_name FROM ".$table_name." WHERE post_name = 'login'", 'ARRAY_A');
	if(empty($check_page)) {
	    $prop_page = array(
			'ID' 			=> '',
			'post_title'    => 'Login',
			'post_content'  => '', 
			'post_excerpt'  => '',
			'post_name' => 'login',
			'post_type' 	=> 'page',
			'post_status'   => 'publish',
			'post_author'   => 1,
			'page_template' => 'page-templates/login.php'
		);
		wp_insert_post($prop_page);
	} 
	
	function woffice_get_login_page_name(){
		/* We fetch the data from the settings */
		$the_login_page = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('login_page') : ''; 
		
		if (!empty($the_login_page)) {
			/* We have the ID we need the name */
			$login_post = get_post($the_login_page[0]);
			$slug = $login_post->post_name;
			return $slug;
		} 
		else {
			return 'login';
		}
		
	}
	
endif;
	
	// REDIRECT LOGIN PAGE
	function woffice_redirect_login_page() {
		$login_custom = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('login_custom') : ''; 
		if ($login_custom != "nope") : 
		
			$login_page_slug = woffice_get_login_page_name();
		    $login_page  = home_url( '/'.$login_page_slug.'/' );
		    $page_viewed = basename($_SERVER['REQUEST_URI']);
		 
		    if( $page_viewed == "wp-login.php" && $_SERVER['REQUEST_METHOD'] == 'GET') {
		        wp_redirect($login_page);
		        exit;
		    }
		    
		endif;
	}
	add_action('init','woffice_redirect_login_page');
	
	// CHECK DATA
	function woffice_login_failed() {
		$login_custom = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('login_custom') : ''; 
		if ($login_custom != "nope") : 
			$login_page_slug = woffice_get_login_page_name();
	    	$login_page  = home_url( '/'.$login_page_slug.'/' );
			wp_redirect( $login_page . '?login=failed' );
			exit;
		endif;
	}
	add_action( 'wp_login_failed', 'woffice_login_failed' );
	
	function woffice_verify_username_password( $user, $username, $password ) {
		$login_custom = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('login_custom') : ''; 
		if ($login_custom != "nope") : 
			$login_page_slug = woffice_get_login_page_name();
		    $login_page  = home_url( '/'.$login_page_slug.'/' );
		    if( $username == "" || $password == "" ) {
		        wp_redirect( $login_page . "?login=empty" );
		        exit;
		    }
		endif;
	}
	add_filter( 'authenticate', 'woffice_verify_username_password', 1, 3);

    function woffice_check_pending( $message, $status ) {
        if($status == 'pending') {
            $login_page_slug = woffice_get_login_page_name();
            $login_page  = home_url( '/'.$login_page_slug.'/' );
            wp_redirect( $login_page . "?login=pending_approval" );
            exit;
        }
    }
    if(class_exists('pw_new_user_approve')) {
        add_filter('new_user_approve_default_authentication_message', 'woffice_check_pending', 10, 2);
        add_filter('new_user_approve_bypass_password_reset', 'turn_off_passowrd_reset',10,0);
        function turn_off_passowrd_reset() {
            return true;
        }
    }
	// After reseting password
	function woffice_lost_password_redirect() {
		$login_custom = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('login_custom') : ''; 
		if ($login_custom != "nope") : 
			wp_redirect( home_url() ); 
			exit;
		endif;
	}
	//add_action('password_reset', 'woffice_lost_password_redirect');
	
	// LOG OUT
	function woffice_logout_page() {
		$login_custom = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('login_custom') : ''; 
		if ($login_custom != "nope") : 
			$login_page_slug = woffice_get_login_page_name();
	    	$login_page  = home_url( '/'.$login_page_slug.'/' );
			wp_redirect( $login_page . "?login=false" );
			exit;
		endif;
	}
	add_action('wp_logout','woffice_logout_page');
	
	// LOST PASSWORD
	function woffice_redirect_to_custom_lostpassword() {
		$login_custom = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('login_custom') : ''; 
		$login_rest_password = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('login_rest_password') : ''; 
		if ($login_custom != "nope" && $login_rest_password == "yep" && 'GET' == $_SERVER['REQUEST_METHOD'] ) : 
		
	        if ( is_user_logged_in() ) {
	            wp_redirect( home_url() );
	            exit;
	        }
			$login_page_slug = woffice_get_login_page_name();
			$login_page  = home_url( '/'.$login_page_slug.'/' );
	        wp_redirect( $login_page . "?type=lost-password"  );
	        exit;
		    
		endif;
	}
	add_action( 'login_form_lostpassword','woffice_redirect_to_custom_lostpassword' );
	function woffice_password_lost () {
		$login_custom = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('login_custom') : ''; 
		$login_rest_password = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('login_rest_password') : ''; 
		if ($login_custom != "nope" && $login_rest_password == "yep" && 'POST' == $_SERVER['REQUEST_METHOD'] ) : 
	        $errors = retrieve_password();
            $login_page_slug = woffice_get_login_page_name();
			$login_page  = home_url( '/'.$login_page_slug.'/' );
	        if ( is_wp_error( $errors ) ) {
	            // Errors found
	            $redirect_url = $login_page . "?type=lost-password";
	            $redirect_url = add_query_arg( 'errors', join( ',', $errors->get_error_codes() ), $redirect_url );
	        } else {
	            // Email sent
	            $redirect_url = $login_page;
	            $redirect_url = add_query_arg( 'checkemail', 'confirm', $redirect_url );
	        }
	 
	        wp_redirect( $redirect_url );
	        exit;
	    endif;
	}
	add_action( 'login_form_lostpassword', 'woffice_password_lost' );
	
	
// CHANGING AUTH ON WORDPRESS PAGE
add_action('admin_head', 'woffice_auth_css');
function woffice_auth_css() {
  echo '<style>
    #wp-auth-check-wrap #wp-auth-check{
      margin: 0 0 0 -45%;
      width: 90%;
    }
  </style>';
}
/*---------------------------------------------------------
** 
** REGISTER OPTION (@1.1.1)
**
----------------------------------------------------------*/
if(!function_exists('woffice_recaptcha_header_script')) {
    /** reCAPTCHA header script */
    function woffice_recaptcha_header_script() {
        $recatpcha_enable = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('recatpcha_enable') : '';
        $login_page_slug = woffice_get_login_page_name();
        if ($recatpcha_enable == "yep" && is_page($login_page_slug)){
            echo '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
        }
    }
}

if(!function_exists('woffice_render_registration_form')) {
    function woffice_render_registration_form() {
        require_once(get_template_directory() . '/inc/register.php');

        // Hook to add the recaptcha to the header part :
        add_action('wp_head', 'woffice_recaptcha_header_script');
    }
}

if (get_option('users_can_register') == '1'){

    woffice_render_registration_form();

}
/*---------------------------------------------------------
** 
** FRONTEND EDIT Functions (@1.2.2)
**
----------------------------------------------------------*/
if(!function_exists('woffice_include_frontend_file')) {
    function woffice_include_frontend_file(){
        require_once(get_template_directory() . '/inc/frontend.php');
    }
}
woffice_include_frontend_file();

/*---------------------------------------------------------
** 
** Create JSON File for Web APP ICON On android
**
----------------------------------------------------------*/
function woffice_creates_json_manifest(){
	$favicon_android_1 = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('favicon_android_1') : '';
	$favicon_android_2 = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('favicon_android_2') : '';
	if ( !empty( $favicon_android_1 )) {
		$size1 = '{"src": "http:'.esc_url($favicon_android_1['url']).'","sizes": "192x192","type": "image\/png","density": "4.0"}';
		$sizes = $size1;
	}
	if (!empty( $favicon_android_2)) {
		$size2 = '{"src": "http:'.esc_url($favicon_android_2['url']).'","sizes": "144x144","type": "image\/png","density": "3.0"}';
		$sizes = $size2;
		if (!empty($favicon_android_1)){
			$sizes = $size2 .','. $size1;
		}
	}
	else{
		$sizes = "";
	}
	$json_content = '{"name": "'.get_bloginfo('name').'","icons": ['.$sizes.']}';
	$fp = fopen(get_template_directory().'/js/manifest.json', 'w');
	fwrite($fp, $json_content);
	fclose($fp);
}
add_action('fw_settings_form_saved','woffice_creates_json_manifest');
/*---------------------------------------------------------
** 
** LANGUAGE SWITCHERS
**
----------------------------------------------------------*/
if (!function_exists('woffice_language_switcher')) {
    function woffice_language_switcher()
    {

        // IF IS WPML ENABLE
        if (class_exists('SitePress')) {
            function getActiveLanguage()
            {
                // fetches the list of languages
                $languages = icl_get_languages('skip_missing=N&orderby=KEY&order=DIR');
                $activeLanguage = 'Englsih';
                // runs through the languages of the system, finding the active language
                foreach ($languages as $language) {
                    // tests if the language is the active one
                    if ($language['active'] == 1) {
                        $activeLanguage = $language['native_name'];
                    }
                }
                return $activeLanguage;
            }

            $languages = icl_get_languages('skip_missing=0&orderby=code');
            if (!empty($languages)) {
                echo '<div id="nav-languages">';
                echo '<a href="javascript:void(0)">
	    		<i class="fa fa-flag"></i><em>' . getActiveLanguage() . '</em> <i class="fa fa-angle-down"></i>
	    	</a>';
                echo '<ul>';
                foreach ($languages as $l) {
                    if (!$l['active'] == 1) {
                        echo '<li class="menu-item"><a href="' . esc_url($l['url']) . '">' . esc_html($l['translated_name']) . '</a></li>';
                    }
                }
                echo '</ul></div>';
            }
        } // ELSE IF TRANSLATE UNYSON EXTENSION IS HERE
        elseif (function_exists('fw_ext_translation_get_frontend_active_language')) {
            echo '<div id="nav-languages">
		<a href="javascript:void(0)">
			<i class="fa fa-flag"></i>' . esc_html(fw_ext('translation')->get_frontend_active_language()) . ' <i class="fa fa-angle-down"></i>
		</a>';
            fw_ext('translation')->frontend_language_switcher();
            echo '</div>';
        } // ELSE RETURN NOTHING
        else {
            return;
        }
    }
}
/*---------------------------------------------------------
** 
** BUDDYPRESS CHANGES
**
----------------------------------------------------------*/
if (function_exists('bp_is_active')):
	require_once(get_template_directory() . '/inc/buddypress.php');
endif;

/*---------------------------------------------------------
** 
** CUSTOM SEARCH FORM 
**
----------------------------------------------------------*/
function woffice_search_form( $form ) {
	if (is_page_template("page-templates/wiki.php") ) { 
		$extrafield = '<input type="hidden" name="post_type" value="wiki" />';
	} else if ( is_page_template("page-templates/projects.php") ) {
		$extrafield = '<input type="hidden" name="post_type" value="projects" />';
	} else if ( is_page_template("page-templates/page-directory.php") ) {
		$extrafield = '<input type="hidden" name="post_type" value="directory" />';
	} else {
		$extrafield = '';
	}
	$form = '<form role="search" method="get" action="' . esc_url( home_url( '/' ) ) . '" >
		<input type="text" value="' . esc_attr(get_search_query()) . '" name="s" id="s" placeholder="' . __( 'Search...','woffice' ) . '"/>
		<input type="hidden" name="searchsubmit" id="searchsubmit" value="true" />'.$extrafield.'
		<button type="submit" name="searchsubmit"><i class="fa fa-search"></i></button>
    </form>';
	return $form;
}
add_filter( 'get_search_form', 'woffice_search_form' );
/*---------------------------------------------------------
** 
** REGISTER SIDEBARS
**
----------------------------------------------------------*/
function woffice_action_theme_widgets_init() {
	$footer_widgets_columns = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('footer_widgets_columns') : ''; 
	if ($footer_widgets_columns == "1") :
		$footer_widgets_top = '<div id="%1$s" class="widget col-md-12 %2$s animate-me fadeIn">';
	elseif ($footer_widgets_columns == "2") : 
		$footer_widgets_top = '<div id="%1$s" class="widget col-md-6 %2$s animate-me fadeIn">';
	elseif ($footer_widgets_columns == "3") : 
		$footer_widgets_top = '<div id="%1$s" class="widget col-md-4 %2$s animate-me fadeIn">';
	else : 
		$footer_widgets_top = '<div id="%1$s" class="widget col-md-3 %2$s animate-me fadeIn">';
	endif; 
	
	register_sidebar( array(
		'name'          => __( 'Right Sidebar', 'woffice' ),
		'id'            => 'content',
		'description'   => __( 'Appears in the main content, left or right as you like see theme settings. Every widget need a title.', 'woffice' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="intern-padding">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<div class="intern-box box-title"><h3>',
		'after_title'   => '</h3></div>',
	) );

	register_sidebar( array(
		'name'          => __( 'Dashboard Widgets (Page content)', 'woffice' ),
		'id'            => 'dashboard',
		'description'   => __( 'Appears in the dashboard page.', 'woffice' ),
		'before_widget' => '<div id="%1$s" class="widget box %2$s"><div class="intern-padding">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<div class="intern-box box-title"><h3>',
		'after_title'   => '</h3></div>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Widgets', 'woffice' ),
		'id'            => 'widgets',
		'description'   => __( 'Appears in the footer section of the site.', 'woffice' ),
		'before_widget' => $footer_widgets_top,
		'after_widget'  => '</div>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>',
	) );

	
}
add_action( 'widgets_init', 'woffice_action_theme_widgets_init' );
/*---------------------------------------------------------
** 
** WOFFICE SIDEBAR (right) STATE
**
----------------------------------------------------------*/
if (!function_exists('woffice_get_sidebar_state')) {
    function woffice_get_sidebar_state()
    {

        /* Data from the database */
        $sidebar_show = (function_exists('fw_get_db_settings_option')) ? fw_get_db_settings_option('sidebar_show') : '';
        $sidebar_state = (function_exists('fw_get_db_settings_option')) ? fw_get_db_settings_option('sidebar_state') : '';
        $sidebar_only_logged = (function_exists('fw_get_db_settings_option')) ? fw_get_db_settings_option('sidebar_only_logged') : '';
        $sidebar_blog = (function_exists('fw_get_db_settings_option')) ? fw_get_db_settings_option('sidebar_blog') : '';
        $sidebar_buddypress = (function_exists('fw_get_db_settings_option')) ? fw_get_db_settings_option('sidebar_buddypress') : '';

        /* Checks and returns : none|hide|show */

        /* We first check it it's for every one AND   */
        if ($sidebar_only_logged == "yep" && !is_user_logged_in()) {
            return "none";
        } else {
            /* We check for the page and if it's hidden */
            $page_url = $_SERVER['REQUEST_URI'];
            if (function_exists('bp_is_active')) {
                global $bp;
                $members_root = (bp_is_active('members')) ? BP_MEMBERS_SLUG : 'not-in-the-url';
                $groups_root = (bp_is_active('groups')) ? BP_GROUPS_SLUG : 'not-in-the-url';
                // We check if the root is in the url
                $slug_position_members = stripos($page_url, $members_root);
                $slug_position_groups = stripos($page_url, $groups_root);
                // We are in a member page or Group page ?
                $is_members_page = ($slug_position_members !== false) ? true : false;
                $is_groups_page = ($slug_position_groups !== false) ? true : false;
            } else {
                $is_members_page = false;
                $is_groups_page = false;
            }

            if ($sidebar_buddypress == "nope" && ($is_members_page == true || $is_groups_page == true)) {
                return "none";
            } elseif ($sidebar_blog == "nope" && (is_singular('post') || is_home())) {
                return "none";
            } else {
                /* We check then if it's hidden, not active or not the full width template */
                if ($sidebar_show == "hide" || !is_active_sidebar('content') || is_page_template("page-templates/full-width.php")) {
                    return "none";
                } else {
                    if ($sidebar_state == "nope") {
                        return "hide";
                    } else {
                        return "show";

                    }
                }
            }
        }

    }
}
/*---------------------------------------------------------
** 
** WOFFICE FAVICON
**
----------------------------------------------------------*/
if(!function_exists('woffice_favicons')) {
    function woffice_favicons()
    {
        $favicon = (function_exists('fw_get_db_settings_option')) ? fw_get_db_settings_option('favicon') : '';
        echo (!empty($favicon)) ? '<link rel="shortcut icon" type="image/png" href="' . esc_url($favicon['url']) . '">' : '';

        $favicon_android_1 = (function_exists('fw_get_db_settings_option')) ? fw_get_db_settings_option('favicon_android_1') : '';
        $favicon_android_2 = (function_exists('fw_get_db_settings_option')) ? fw_get_db_settings_option('favicon_android_2') : '';
        if (!empty($favicon_android_1) || !empty($favicon_android_2)):
            echo '<link rel="manifest" href="' . get_template_directory_uri() . '/js/manifest.json">';
        endif;

        $favicon_iphone = (function_exists('fw_get_db_settings_option')) ? fw_get_db_settings_option('favicon_iphone') : '';
        echo (!empty($favicon_iphone)) ? '<link rel="apple-touch-icon" sizes="114x114" href="' . esc_url($favicon_iphone['url']) . '">' : '';

        $favicon_ipad = (function_exists('fw_get_db_settings_option')) ? fw_get_db_settings_option('favicon_ipad') : '';
        echo (!empty($favicon_ipad)) ? '<link rel="apple-touch-icon" sizes="144x144" href="' . esc_url($favicon_ipad['url']) . '">' : '';
    }
}

/*---------------------------------------------------------
** 
** WOFFICE HEADER
**
----------------------------------------------------------*/
if(!function_exists('woffice_title')) {
    function woffice_title($title)
    {
        echo '<!-- START FEATURED IMAGE AND TITLE -->';

        /*
         * WE SET THE CLASS
        */

        /*GET BUDDYPRESS AND CURENT POST INFO*/
        global $bp;
        global $post;
        /*THE MEMBERS & GROUP SLUG SET IN THE SETTINGS*/
        if (function_exists('bp_is_active')):
            $members_root = BP_MEMBERS_SLUG;
            //bp_is_members_directory
            if (bp_is_active('groups')) :
                $groups_root = BP_GROUPS_SLUG;
            else :
                $groups_root = "extensions-group-not-enabled";
            endif;
        endif;

		if(function_exists('is_bbpress') && is_bbpress()) {
			if(function_exists('bp_is_active') && bp_is_user()){
				$is_forum_page = false;
			} else {
				$is_forum_page = true;
			}
		} else {
			$is_forum_page = false;
		}

        /*THE CURRENT POST SLUG*/
        $post_name = (is_page()) ? get_post($post)->post_title : '';
        $current_slug = sanitize_title($post_name);

        if (is_search() || is_404() || is_page_template("page-templates/wiki.php") || is_page_template("page-templates/projects.php") || $is_forum_page):
            $title_class = "has-search is-404";
        elseif (is_page_template("page-templates/page-directory.php") || is_tax('directory-category')) :
            $title_class = "directory-header";
        else :
            $title_class = "";
        endif;
        if (function_exists('bp_is_active')):
            if (($groups_root == $current_slug) || (bp_is_members_directory())) :
                $title_class = "has-search search-buddypress";
            endif;
        endif;
        $post_top_featured = (function_exists('fw_get_db_post_option')) ? fw_get_db_post_option(get_the_ID(), 'post_top_featured') : '';
        $main_featured_image = (function_exists('fw_get_db_settings_option')) ? fw_get_db_settings_option('main_featured_image') : '';

        /*
         * HTML
        */

        echo '<header id="featuredbox" class="centered ' . esc_attr($title_class) . '">';

        /*We check for Revolution SLiders*/
        if (is_page() || (is_home() && get_option('page_for_posts'))) {
            $page_ID = (is_home() && get_option('page_for_posts')) ? get_option('page_for_posts') : get_the_ID();
            $slider_featured = (function_exists('fw_get_db_post_option')) ? fw_get_db_post_option($page_ID, 'revslider_featured') : '';
        } else {
            $slider_featured = "";
        }
        if (empty($slider_featured) || (!shortcode_exists('rev_slider') && !class_exists('FW_Extension_Slider'))) {

            echo '<div class="pagetitle animate-me fadeIn">';
            $hastitle = (function_exists('fw_get_db_post_option')) ? fw_get_db_post_option(get_the_ID(), 'hastitle') : '';
            if ($hastitle != true) :
                if (is_singular('post')) :
                    /*See: https://2f.ticksy.com/ticket/539682 */
                    if (function_exists('bp_is_active') && bp_is_user()) {
                        echo '<h1>';
                        if (defined('bp_displayed_user_mentionname')) {
                            bp_displayed_user_mentionname();
                        } else {
                            echo bp_get_displayed_user_fullname();
                        }
                        echo '</h1>';
                    } else {
                        $index_title = (function_exists('fw_get_db_settings_option')) ? fw_get_db_settings_option('index_title') : '';
                        echo '<h1>' . $index_title . '</h1>';
                    }
                else:
                    echo '<h1>' . $title . '</h1>';
                endif;
                // CHECK FOR BREADCRUMB
                if (!is_front_page() && function_exists('fw_ext_breadcrumbs') && is_page() && !is_singular('wiki')) :
                    fw_ext_breadcrumbs();
                endif;
                // SINGULAR WIKI PAGE -> WE DISPLAY PARENT LINK
                if (is_singular('wiki')):
                    echo empty($post->post_parent) ? '' : get_the_title($post->post_parent);
                endif;
            endif;
            if (is_search() || is_404() || is_page_template("page-templates/wiki.php") || is_page_template("page-templates/projects.php") || $is_forum_page):
                if($is_forum_page){
					echo do_shortcode('[bbp-search]');
				} else {
					get_search_form();
				}
            endif;
            // BUDDYPRESS SEARHFORMS
            if (function_exists('bp_is_active')):
                /*THEN WE CHECK*/
                if ($groups_root == $current_slug) :
                    bp_woffice_directory_groups_search_form();
                endif;
                if (bp_is_members_directory()) :
                    bp_woffice_directory_members_search_form();
                endif;
            endif;
            //DIRECTORY STUFF
            if (is_page_template("page-templates/page-directory.php") || is_tax('directory-category')) {
                echo '<div class="title-box-buttons">';
                echo '<div id="directory-search">';
                get_search_form();
                echo '</div>';
                echo '<a href="javascript:void(0)" class="btn btn-default" id="directory-show-search"><i class="fa fa-search"></i> ' . __('Search', 'woffice') . '</a>';
                $directory_create = (function_exists('fw_get_db_settings_option')) ? fw_get_db_settings_option('directory_create') : '';
                /*if (woffice_role_allowed($directory_create)):
                    echo '<a href="javascript:void(0)" class="btn btn-default" id="directory-add-item"><i class="fa fa-plus-square"></i> '. __('Create a new item','woffice') .'</a>';
                endif;*/
                echo '</div>';
            }
            echo '</div>';
            if ((has_post_thumbnail() && is_page()) || (is_singular('directory') && has_post_thumbnail())) :
                $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                $final_image = $image[0];
                echo '<div class="featured-background" style="background-image:url(' . esc_url($final_image) . ');">';
            elseif (is_single() && !empty($post_top_featured)) :
                $final_image = $post_top_featured["url"];
                echo '<div class="featured-background" style="background-image:url(' . esc_url($final_image) . ');">';
            elseif (is_page_template("page-templates/page-directory.php") || is_tax('directory-category')):
                if (!has_post_thumbnail()) {
                    echo '<div id="map-directory"></div>';
                } else {
                    $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                    $final_image = $image[0];
                    echo '<div class="featured-background" style="background-image:url(' . esc_url($final_image) . ');">';
                }
            elseif (!empty($main_featured_image)):
                echo '<div class="featured-background" style="background-image: url(' . esc_url($main_featured_image['url']) . ');">';
            else :
                if (is_home() && get_option('page_for_posts')) {
                    $image = wp_get_attachment_image_src(get_post_thumbnail_id(get_option('page_for_posts')), 'full');
                    $final_image = $image[0];
                    echo '<div class="featured-background" style="background-image:url(' . esc_url($final_image) . ');">';
                } else {
                    echo '<div class="featured-background" style="background-image: url(' . get_template_directory_uri() . '/images/1.jpg);">';
                }
            endif;
            echo '<div class="featured-background">
				<div class="featured-layer"></div>
			</div>';
        } else {
	        /*We look for an Unyson slider first (an numerical post id and not a revolution slider slug */
	        if (is_numeric($slider_featured)){
				echo do_shortcode('[slider slider_id="'.$slider_featured.'" width="1200" height="auto" /]');
	        } else{
		        // LAST CHECK
		        if (shortcode_exists('rev_slider')) {
		        	putRevSlider($slider_featured);
		        }
	        }
        }
        echo '</header>';
    }
}
/*---------------------------------------------------------
** 
** WOFFICE NAVIGATION
**
----------------------------------------------------------*/
if(!function_exists('woffice_paging_nav')) {
    function woffice_paging_nav($custom_query = null)
    {
        if(is_singular() && is_null($custom_query))
            return;

        if(is_null($custom_query)) {
            global $wp_query;
            $custom_query = $wp_query;
        }

        $total_pages = $custom_query->max_num_pages;

        /** Stop execution if there's only 1 page */
        if ($total_pages <= 1)
            return;

        $max = intval($total_pages);
        global $paged;
        $paged = (empty($paged)) ? 1 : $paged;


        /**    Add current page to the array */
        if ($paged >= 1)
            $links[] = $paged;

        /**    Add the pages around the current page to the array */
        if ($paged >= 3) {
            $links[] = $paged - 1;
            $links[] = $paged - 2;
        }

        if (($paged + 2) <= $max) {
            $links[] = $paged + 2;
            $links[] = $paged + 1;
        }

		echo '<div class="blog-next-page center">' . "\n";

        echo '<ul class="navigation clearfix">' . "\n";

        /**    Previous Post Link */
        if ($paged > 1) {
            $previous_posts_link = explode('"', get_previous_posts_link());
            $npl_url = $previous_posts_link[1];
            echo '<li><a href="' . esc_url($previous_posts_link[1]) . '" class="btn btn-default"><i class="fa fa-hand-o-left"></i> ' . __('Previous Posts', 'woffice') . '</a></li>';
        }

        /**    Link to first page, plus ellipses if necessary */
        if (!in_array(1, $links)) {
            $class = (1 == $paged) ? ' class="active"' : '';

            printf('<li%s><a class="btn btn-default" href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link(1)), '1');

            if (!in_array(2, $links))
                echo '<li><span class="btn btn-default disabled">...</span></li>';
        }

        /**    Link to current page, plus 2 pages in either direction if necessary */
        sort($links);
        foreach ((array)$links as $link) {
            $class = $paged == $link ? ' class="active"' : '';
            printf('<li%s><a class="btn btn-default" href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($link)), $link);
        }

        /**    Link to last page, plus ellipses if necessary */
        if (!in_array($max, $links)) {
            if (!in_array($max - 1, $links))
                echo '<li><span class="btn btn-default disabled">...</span></li>' . "\n";

            $class = $paged == $max ? ' class="active"' : '';
            printf('<li%s><a class="btn btn-default" href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($max)), $max);
        }

        /**    Next Post Link */
          if ($paged < $max) {
            $next_posts_link = explode('"', get_next_posts_link('', $max));
            echo '<li><a href="' . esc_url($next_posts_link[1]) . '" class="btn btn-default">' . __('Next Posts', 'woffice') . ' <i class="fa fa-hand-o-right"></i></a></li>';
        }

        echo '</ul>' . "\n";

        echo '</div>' . "\n";
    }
}

if(!function_exists('woffice_post_nav')) {
    function woffice_post_nav()
    {
        // Don't print empty markup if there's nowhere to navigate.
        $previous = (is_attachment()) ? get_post(get_post()->post_parent) : get_adjacent_post(false, '',
            true);
        $next = get_adjacent_post(false, '', false);
        if (!$next && !$previous) {
            return;
        }
        echo '
		<hr><div class="blog-next-page center animate-me fadeInUp" role="navigation">' . "\n";
        ob_start();
        previous_post_link('%link',
            __('<i class="fa fa-hand-o-left"></i> %title', 'woffice'));
        next_post_link('%link',
            __('%title <i class="fa fa-hand-o-right"></i>', 'woffice'));
        $link = ob_get_clean();
        echo str_replace('<a ', '<a class="btn btn-default" ', $link);


        echo '</div>' . "\n";
    }
}
/*---------------------------------------------------------
** 
** WOFFICE POST METADATAS
**
----------------------------------------------------------*/
if(!function_exists('woffice_postmetas')) {
    function woffice_postmetas()
    {
        echo '<ul class="post-metadatas list-inline">';
        echo '<li><i class="fa fa-clock-o"></i> ' . get_the_date() . '</li>';
        echo '<li><i class="fa fa-user"></i> ' . get_the_author() . '</li>';
        if (get_comment_count(get_the_ID()) > 0 && comments_open()) {
            echo '<li><i class="fa fa-comments-o"></i> <a href="' . get_the_permalink() . '#respond">' . get_comments_number('0', '1', '%') . '</a></li>';
        }
        if (get_the_category_list() != "") {
            echo '<li><i class="fa fa-thumb-tack"></i> ' . get_the_category_list(__(', ', 'woffice')) . '</li>';
        }
        if (get_the_tag_list() != "") {
            echo '<li class="meta-tags"><i class="fa fa-tags"></i> ' . get_the_tag_list('', __(', ', 'woffice')) . '</li>';
        }
        echo '</ul>';
    }
}
/*---------------------------------------------------------
** 
** WOFFICE BLOG LIKE BUTTON
**
----------------------------------------------------------*/
// VIEW
if (!function_exists("woffice_blog_user_has_already_voted")){
	function woffice_blog_user_has_already_voted($post_ID) {
		$timebeforerevote = 240; // = 4 hours
		// Retrieve post votes IPs
	    $meta_IP = get_post_meta($post_ID, "voted_IP");
	    if (empty($meta_IP)) {
		    return false;
	    }
	    $voted_IP = $meta_IP[0];
	    if(!is_array($voted_IP))
	        $voted_IP = array();
	    // Retrieve current user IP
	    $ip = $_SERVER['REMOTE_ADDR'];
	    // If user has already voted
	    if(in_array($ip, array_keys($voted_IP)))
	    {
	        $time = $voted_IP[$ip];
	        $now = time();
	        // Compare between current time and vote time
	        if(round(($now - $time) / 60) > $timebeforerevote)
	            return false; 
	        return true;
	    }
	    return false;
	}
}
function woffice_blog_like_buttons_js(){
	if (is_singular("post")){
		/*Ajax URL*/
		$ajax_url = admin_url('admin-ajax.php');
		/*Ajax Nonce*/
		$ajax_nonce = wp_create_nonce('ajax-nonce');
		echo'<script type="text/javascript">
			jQuery(function () {
				jQuery(".wiki-like a").click(function(){
			        like = jQuery(this);
			        post_id = like.data("post_id");
			        // Ajax call
			        jQuery.ajax({
			            type: "post",
			            url: "'.$ajax_url.'",
			            data: "action=blogPostLike&nonce='.$ajax_nonce.'&post_like=&post_id="+post_id,
			            success: function(count){
			                if(count != "already")
			                {
			                    like.closest(".wiki-like").addClass("voted");
			                    like.siblings(".count").text(count);
			                }
			            }
			        });
			        return false;
			    });
			});
		</script>';
	}
}
add_action('wp_footer', 'woffice_blog_like_buttons_js');
// AJAX	HANDLE
function blogPostLike(){
	
    // Check for nonce security
    $nonce = $_POST['nonce'];
  
    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
        die ( 'Busted!');
     
    if(isset($_POST['post_like'])){
        // Retrieve user IP address
        $ip = $_SERVER['REMOTE_ADDR'];
        $post_id = $_POST['post_id'];
         
        // Get voters'IPs for the current post
        $meta_IP = get_post_meta($post_id, "voted_IP");
        $voted_IP = (empty($meta_IP)) ? 0 : $meta_IP[0];
 
        if(!is_array($voted_IP))
            $voted_IP = array();
         
        // Get votes count for the current post
        $meta_count = get_post_meta($post_id, "votes_count", true);
 
        // Use has already voted ?
        if(!woffice_blog_user_has_already_voted($post_id))
        {
            $voted_IP[$ip] = time();
 
            // Save IP and increase votes count
            update_post_meta($post_id, "voted_IP", $voted_IP);
            update_post_meta($post_id, "votes_count", ++$meta_count);
             
            // Display count (ie jQuery return value)
            echo $meta_count;
        }
        else
            echo "already";
    }
    exit;
}
add_action('wp_ajax_nopriv_blogPostLike', 'blogPostLike');
add_action('wp_ajax_blogPostLike', 'blogPostLike');
/*---------------------------------------------------------
** 
** FILTER FOR THE COMMENTS
**
----------------------------------------------------------*/
// ADDING BUTTON STYLE TO TEH REPLY LINK
add_filter('comment_reply_link', 'woffice_replace_reply_link_class');
function woffice_replace_reply_link_class($class){
    $class = str_replace("class='comment-reply-link", "class='btn btn-default", $class);
    return $class;
}

// SENDING BUTTONS
add_action('comment_form', 'woffice_comment_button' );
function woffice_comment_button() {
    echo '<div class="control-group text-right"><button class="btn btn-default" type="submit"><i class="fa fa-paper-plane-o"></i>' . __( 'Post Comment','woffice' ) . '</button></div>';
}
/*---------------------------------------------------------
** 
** TAXONOMY CREATOR FROM FRONTEND TEMPLATE AJAX
**
----------------------------------------------------------*/
function wofficeTaxonomyFetching(){
	
	// We get the Post Name selected 
	$post_name = $_POST['ajax_post_name'];
	if (isset($post_name)) {
		
		$taxonomy_objects = get_object_taxonomies( $post_name, 'names' );
		echo'<label for="taxonomy"><i class="fa fa-tag"></i> '. __('Choose a taxonomy','woffice') .'</label>';
		echo'<select class="form-control" name="taxonomy">';
	
			if (!empty($taxonomy_objects)) {
				foreach ($taxonomy_objects as $key=>$taxonomy) {
					 echo '<option value="'.$taxonomy.'">'.$taxonomy.'</option>';
				}
			} 
			else {
				echo '<option value="no_tax">'. __('No Taxonomy..', 'woffice') .'</option>';
			}
			
		echo '</select>';
		
	}
	wp_die();
}
add_action('wp_ajax_nopriv_wofficeTaxonomyFetching', 'wofficeTaxonomyFetching');
add_action('wp_ajax_wofficeTaxonomyFetching', 'wofficeTaxonomyFetching');

function wofficeTaxonomyAdd(){
	
	// The check the values
	if (empty($_POST['ajax_taxonomy'])) {
		$message = __('You need to choose a taxonomy to add your new category.','woffice');
	}
	elseif (empty($_POST['ajax_new_tax'])) {
		$message = __('You need to enter a new category.','woffice');
	}
	else {
		// We set the new term : 
		$tax_ready = sanitize_text_field($_POST['ajax_new_tax']);
		$taxonomy = sanitize_text_field($_POST['ajax_taxonomy']);
	
		if ($taxonomy != 'no_tax') {
			
			// We insert the tax 
			$insert_term = wp_insert_term( $tax_ready, $taxonomy);
			
			$message = __('Successfully Added.','woffice');
			
		} 
	}
	
	echo '<div class="infobox notification-color">'.$message.'</div>';
	
	wp_die();
}
add_action('wp_ajax_nopriv_wofficeTaxonomyAdd', 'wofficeTaxonomyAdd');
add_action('wp_ajax_wofficeTaxonomyAdd', 'wofficeTaxonomyAdd');
/*---------------------------------------------------------
** 
** WOFFICE USERS ONLINE
** @USELESS
**
----------------------------------------------------------*/
function woffice_online_users(){
	global $bp;
	if(bp_has_members('type=online')):
		echo'<li><span class="has-online"></span> <strong>'.bp_has_members('type=online').'</strong></li>';
	else :
		echo'<li><span class="has-online"></span> <strong>0</strong></li>';
	endif;
}
/*---------------------------------------------------------
** 
** WOFFICE IS USER ALLOWED TO SEE CONTENT
**
----------------------------------------------------------*/
if(!function_exists('woffice_is_user_allowed')) {
    function woffice_is_user_allowed()
    {

        /* Fetch data from options both settings & post options */
        $exclude_members = (function_exists('fw_get_db_post_option')) ? fw_get_db_post_option(get_the_ID(), 'exclude_members') : '';
        $exclude_roles = (function_exists('fw_get_db_post_option')) ? fw_get_db_post_option(get_the_ID(), 'exclude_roles') : '';
        $logged_only = (function_exists('fw_get_db_post_option')) ? fw_get_db_post_option(get_the_ID(), 'logged_only') : '';
        if (empty($logged_only)) {
            $logged_only = false;
        }

        $user_ID = get_current_user_id();

        $is_allowed = true;

        /* We start by checking if the member is logged in and if the page allow you to view the content*/
        if ($logged_only == true && is_user_logged_in() == false) :
            $is_allowed = false;
        else :
            /* We check now if the user is excluded */
            $member_allowed = true;
            if (!empty($exclude_members)) :
                foreach ($exclude_members as $exclude_member) {
                    if ($exclude_member == $user_ID):
                        $member_allowed = false;
                    endif;
                }
            endif;
            /* We check now if the role is excluded */
            $role_allowed = true;
            if (!empty($exclude_roles)) :
                $user = wp_get_current_user();
                /* Thanks to Buddypress we only keep the main role */
                $the_user_role = (is_array($user->roles)) ? $user->roles[0] : $user->roles;

                /* We check if it's in the array, OR if it's the administrator  */
                if (in_array($the_user_role, $exclude_roles) && $the_user_role != "administrator") {
                    $role_allowed = false;
                }
            endif;
            /*We check the results*/
            if ($role_allowed == false || $member_allowed == false) {
                $is_allowed = false;
            }
        endif;

        return $is_allowed;
    }
}
/*---------------------------------------------------------
** 
** WOFFICE RETURN SCROLL TOP HTML
**
----------------------------------------------------------*/
if(!function_exists('woffice_scroll_top')) {
    function woffice_scroll_top()
    {
        $sidebar_scroll = (function_exists('fw_get_db_settings_option')) ? fw_get_db_settings_option('sidebar_scroll') : '';
        if ($sidebar_scroll == "yep") : ?>
            <!--SCROLL TOP-->
            <div id="scroll-top-container">
                <a href="#main-header" id="scroll-top">
                    <i class="fa fa-arrow-circle-o-up"></i>
                </a>
            </div>
        <?php endif;
    }
}
/*---------------------------------------------------------
** 
** WOFFICE WOOCOMMERCE
**
----------------------------------------------------------*/
if (function_exists('is_woocommerce')) {
	/* Single product change */
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
	/* Change number of related products on product page & other */
	add_filter( 'woocommerce_output_related_products_args', 'woffice_related_products_args' );
	function woffice_related_products_args( $args ) {
	
		$args['posts_per_page'] = 4; // 4 related products
		$args['columns'] = 4; // arranged in 2 columns
		return $args;
	}
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
	add_action( 'woocommerce_after_single_product_summary', 'woffice_woocommerce_output_upsells', 15 );
	if ( ! function_exists( 'woocommerce_output_upsells' ) ) {
		function woffice_woocommerce_output_upsells() {
		    woocommerce_upsell_display( 4,4 ); // Display 3 products in rows of 3
		}
	}
	/*add_filter( 'woocommerce_cross_sells_columns', 'woffice_cross_sells_columns' );
	function woffice_cross_sells_columns( $columns ) {
		return 1;
	}*/
	/* Ensure cart contents update when products are added to the cart via AJAX */
	add_filter( 'woocommerce_add_to_cart_fragments', 'woffice_woocommerce_header_add_to_cart_fragment' );
	
	function woffice_woocommerce_header_add_to_cart_fragment( $fragments ) {
		ob_start();
		?>
		<a href="javascript:void(0)" id="nav-cart-trigger" title="<?php _e( 'View your shopping cart', 'woffice' ); ?>" class="<?php echo sizeof(WC()->cart->get_cart()) > 0 ? 'active' : ''; ?> cart-contents">
			<i class="fa fa-shopping-cart"></i>
			<?php echo (sizeof( WC()->cart->get_cart()) > 0) ? WC()->cart->get_cart_subtotal() : ''; ?>
		</a>
		<?php
		
		$fragments['a.cart-contents'] = ob_get_clean();
		
		return $fragments;
	}
	/* Custom Shoping Cart in the top */
	function woffice_wc_print_mini_cart() {
		?>
		<div id="woffice-minicart-top">
			<?php if ( sizeof( WC()->cart->get_cart() ) > 0 ) : ?>
				<ul class="woffice-minicart-top-products">
					<?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
					$_product = $cart_item['data'];
					// Only display if allowed
					if ( ! apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) || ! $_product->exists() || $cart_item['quantity'] == 0 ) continue;
					// Get price
					$product_price = get_option( 'woocommerce_tax_display_cart' ) == 'excl' ? $_product->get_price_excluding_tax() : $_product->get_price_including_tax();
					$product_price = apply_filters( 'woocommerce_cart_item_price_html', woocommerce_price( $product_price ), $cart_item, $cart_item_key );
					?>
					<li class="woffice-mini-cart-product clearfix">
						<span class="woffice-mini-cart-thumbnail">
							<?php echo $_product->get_image(); ?>
						</span>
						<span class="woffice-mini-cart-info">
							<a class="woffice-mini-cart-title" href="<?php echo get_permalink( $cart_item['product_id'] ); ?>">
								<h4><?php echo apply_filters('woocommerce_widget_cart_product_title', $_product->get_title(), $_product ); ?></h4>
							</a>
							<?php echo apply_filters( 'woocommerce_widget_cart_item_price', '<span class="woffice-mini-cart-price">' . __('Unit Price', 'woffice') . ':' . $product_price . '</span>', $cart_item, $cart_item_key ); ?>
							<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="woffice-mini-cart-quantity">' . __('Quantity', 'woffice') . ':' . $cart_item['quantity'] . '</span>', $cart_item, $cart_item_key ); ?>
						</span>
					</li>
					<?php endforeach; ?>
				</ul><!-- end .tee-mini-cart-products -->
			<?php else : ?>
				<p class="woffice-mini-cart-product-empty"><?php _e( 'No products in the cart.', 'woffice' ); ?></p>
			<?php endif; ?>
			<?php if (sizeof( WC()->cart->get_cart()) > 0) : ?>
				<h4 class="text-center woffice-mini-cart-subtotal"><?php _e( 'Cart Subtotal', 'woffice' ); ?>: <?php echo WC()->cart->get_cart_subtotal(); ?></h4>
				<div class="text-center">
					<a href="<?php echo WC()->cart->get_cart_url(); ?>" class="cart btn btn-default">
						<i class="fa fa-shopping-cart"></i> <?php _e( 'Cart', 'woffice' ); ?>
					</a>
					<a href="<?php echo WC()->cart->get_checkout_url(); ?>" class="alt checkout btn btn-default">
						<i class="fa fa-credit-card"></i> <?php _e( 'Checkout', 'woffice' ); ?>
					</a>
				</div>
			<?php endif; ?>
		</div>
		<?php
	}

    function woffice_preserve_lostpassword_link() {
        return get_option('siteurl') .'/wp-login.php?action=lostpassword';
    }
    add_filter( 'lostpassword_url',  'woffice_preserve_lostpassword_link', 11, 0 );
}
/*---------------------------------------------------------
** 
** WOFFICE EXTRAFOOTER
**
----------------------------------------------------------*/
if(!function_exists('woffice_url_from_img')) {
    function woffice_url_from_img($img)
    {
        $matches = array();
        preg_match('/src="(.*?)"/i', $img, $matches);
        return $matches[1];
    }
}

// Function wich check if the Gravatar image exists
if(!function_exists('validate_gravatar')) {
    function validate_gravatar($id_of_user)
    {
        //id or email code borrowed from wp-includes/pluggable.php

        $id = (int)$id_of_user;
        $user = get_userdata($id);
        $email = ($user) ? $user->user_email : '';

        $hashkey = md5(strtolower(trim($email)));
        $uri = 'http://www.gravatar.com/avatar/' . $hashkey . '?d=404';

        $data = wp_cache_get($hashkey);
        if (false === $data) {
            $response = wp_remote_head($uri);
            if (is_wp_error($response)) {
                $data = 'not200';
            } else {
                $data = $response['response']['code'];
            }
            wp_cache_set($hashkey, $data, $group = '', $expire = 60 * 5);

        }
        if ($data == '200') {
            return true;
        } else {
            //Check if link is not a gravat link, so it mean that is an avatar uploaded on site, in this case return true
            $avatar_url = woffice_url_from_img(get_avatar($id, 80));
            return (strpos($avatar_url, 'gravatar') === FALSE);

        }
    }
}

if(!function_exists('woffice_extrafooter')) {
    function woffice_extrafooter()
    {
        // GET THE OPTIONS
        $extrafooter_content = (function_exists('fw_get_db_settings_option')) ? fw_get_db_settings_option('extrafooter_content') : '';
        $extrafooter_link = (function_exists('fw_get_db_settings_option')) ? fw_get_db_settings_option('extrafooter_link') : '';
        $extrafooter_avatar_only = (function_exists('fw_get_db_settings_option')) ? fw_get_db_settings_option('extrafooter_avatar_only') : '';
        $extrafooter_random = (function_exists('fw_get_db_settings_option')) ? fw_get_db_settings_option('extrafooter_random') : '';
        $extrafooter_repetition_allowed = (function_exists('fw_get_db_settings_option')) ? fw_get_db_settings_option('extrafooter_repetition_allowed') : '';

        // FRONTEND DISPLAY
        echo '<!-- START EXTRAFOOTER -->';
        echo '<section id="extrafooter">';
        echo '<div id="extrafooter-layer" class="animate-me fadeIn">';
        echo '<a href="' . esc_url($extrafooter_link) . '"><h1>' . $extrafooter_content . '</h1></a>';
        echo '</div>';
        echo '<div id="familiers">';
        // GET USERS
        $woffice_wp_users = get_users(array('fields' => array('ID', 'user_url')));
        $users_already_displayed = array();

        // If is set random faces, shuffle array of users
        if ($extrafooter_random == "yep")
            shuffle($woffice_wp_users);

        //Do this for each user, max 100 because are not displayed more than 100 users in the extrafooter
        //$j is max counter; $x is users array index
        for ($x = 0, $j = 0; $j < 99 && $x < count($woffice_wp_users); $x++){

            //If repetition of faces are not allowed, display only if is not already displayed
            if($extrafooter_repetition_allowed == 'yep' || !in_array($woffice_wp_users[$x]->ID, $users_already_displayed))
                if ($extrafooter_avatar_only == "yep") {
                    if(validate_gravatar($woffice_wp_users[$x]->ID)) {
                        print get_avatar($woffice_wp_users[$x]->ID, 80);
                        array_push($users_already_displayed, $woffice_wp_users[$x]->ID);
                        $j++;
                    }
                } else {
                    print get_avatar($woffice_wp_users[$x]->ID, 80);
                    array_push($users_already_displayed, $woffice_wp_users[$x]->ID);
                    $j++;
                }
        }

        //If repetitive faces are allowed and it need more faces to reach 100, than get more faces randomly from already inserted user
        if($extrafooter_repetition_allowed == 'yep' && $j < 99) {
            for ($x = 0; $x < (99-$j); $x++){
                $woffice_wp_selected = $users_already_displayed[array_rand($users_already_displayed)];
                print get_avatar($woffice_wp_selected, 80);
            }
        }

        echo '</div>';
        echo '</section>';
    }
}

/*---------------------------------------------------------
** 
** WOFFICE CURRENT TIME IN THE HEADER
**
----------------------------------------------------------*/
function woffice_current_time(){
	$blogtime = current_time( 'mysql' ); 
	echo  $blogtime;
}

/*---------------------------------------------------------
** 
** Extend the default WordPress post classes.
**
----------------------------------------------------------*/
function woffice_filter_theme_post_classes( $classes ) {
	if ( ! post_password_required() && ! is_attachment() && has_post_thumbnail() ) {
		$classes[] = 'has-post-thumbnail';
	}
	return $classes;
}
add_filter( 'post_class', 'woffice_filter_theme_post_classes' );
/*---------------------------------------------------------
** 
** REMOVE SOME UNYSON EXTENSIONS
**
----------------------------------------------------------*/
function woffice_action_hide_extensions_from_the_list() {
    //global $current_screen; fw_print($current_screen); // debug
	
	if (function_exists('fw_current_screen_match')) {
	    if (fw_current_screen_match(array('only' => array('id' => 'toplevel_page_fw-extensions')))) {
	        echo '<style type="text/css"> 
	        #fw-ext-events, 
	        #fw-ext-translation,
	        #fw-ext-feedback, #fw-ext-styling
	        { display: none !important; } 
	        </style>';
	    }
	}
	
}
add_action('admin_print_scripts', 'woffice_action_hide_extensions_from_the_list');

/*---------------------------------------------------------
** 
** REMOVE EVENTON WIDGETS
**
----------------------------------------------------------*/
if (class_exists( 'EventON' )):
	function wofffice_remove_eventON_widget() {
		unregister_widget('EvcalWidget');
		unregister_widget('EvcalWidget_SC');
		unregister_widget('EvcalWidget_three');
		unregister_widget('EvcalWidget_four');
	}
	add_action( 'widgets_init', 'wofffice_remove_eventON_widget' );
endif;
if (class_exists( 'EventON_full_cal' )):
	function woffice_remove_eventON_FC_widget() {
		unregister_widget('evoFC_Widget');
	}
	//add_action( 'widgets_init', 'woffice_remove_eventON_FC_widget',11 );
endif;

/*---------------------------------------------------------
** 
** REMOVE WISE CHAT WIDGET
**
----------------------------------------------------------*/
if (class_exists( 'WiseChat' )):
	function woffice_remove_wise_widget() {
		unregister_widget('WiseChatWidget');
	}
	//add_action( 'widgets_init', 'woffice_remove_wise_widget',11 );
endif;

/*---------------------------------------------------------
** 
** MV FIle Sharing Customization
**
----------------------------------------------------------*/
if (class_exists( 'multiverso_mv_category_files' )):
	function woffice_remove_mv_widget() {
		unregister_widget('multiverso_mv_category_files');
		unregister_widget('multiverso_login_register');
		unregister_widget('multiverso_mv_personal_recent_files');
		unregister_widget('multiverso_mv_recent_files');
		unregister_widget('multiverso_search');
		unregister_widget('multiverso_mv_registered_recent_files');
	}
	add_action( 'widgets_init', 'woffice_remove_mv_widget' );

	// NEW ALL FILES SHORTCODE TO EXCLUDE PORTFOLIO NEW CATEGORY
	function woffice_allfiles() {
		// Include allfiles.php template
		return include(get_template_directory() . '/inc/allfiles.php');
	}
	add_shortcode( 'woffice_allfiles', 'woffice_allfiles' );
	
endif;

/*---------------------------------------------------------
** 
** BBPRESS STUFF
**
----------------------------------------------------------*/
if (class_exists( 'bbPress' )):
	function woffice_remove_bbp_widget() {	
		unregister_widget('BBP_Login_Widget');
	}
	add_action( 'widgets_init', 'woffice_remove_bbp_widget' );
endif;
/*---------------------------------------------------------
** 
** Outsource the extensions from the theme files
** Removed in @1.6.0
**
----------------------------------------------------------*/
function woffice_filter_load_extensions($locations) {
    //$locations['/home/alkawebc/public_html/woffice-io/extensions/sources'] = 'https://woffice.io/extensions/sources';
    // Only for the Maintenance & Social login extension for now
    $locations['/home/alkawebc/public_html/woffice-io/extensions/sources-first'] = 'https://woffice.io/extensions/sources-first';

    return $locations;
}
//add_filter('fw_extensions_locations', 'woffice_filter_load_extensions');
/*---------------------------------------------------------
** 
** REMOVE CUSTOMIZE PAGE FROM WP MENU
**
----------------------------------------------------------*/
function woffice_remove_customize_page(){
	global $submenu;
	unset($submenu['themes.php'][6]); // remove customize link
}
add_action( 'admin_menu', 'woffice_remove_customize_page');
/*---------------------------------------------------------
** 
** Woffice Demo
**
----------------------------------------------------------*/
function woffice_filter_theme_fw_ext_backups_demos($demos) {
    $demos_array = array(
        'business-demo' => array(
            'title' => __('Business Demo', 'woffice'),
            'screenshot' => 'https://woffice.io/demos/demo-business.png',
            'preview_link' => 'http://alka-web.com/woffice-business/',
        ),
        'community-demo' => array(
            'title' => __('Community Demo', 'woffice'),
            'screenshot' => 'https://woffice.io/demos/demo-community.png',
            'preview_link' => 'https://woffice.io/demo-community/',
        ),
        'school-demo' => array(
            'title' => __('School Demo', 'woffice'),
            'screenshot' => 'https://woffice.io/demos/demo-school.png',
            'preview_link' => 'http://alka-web.com/woffice-school/',
        ),
    );

    $download_url = 'https://woffice.io/demos/index.php';

    foreach ($demos_array as $id => $data) {
        $demo = new FW_Ext_Backups_Demo($id, 'piecemeal', array(
            'url' => $download_url,
            'file_id' => $id,
        ));
        $demo->set_title($data['title']);
        $demo->set_screenshot($data['screenshot']);
        $demo->set_preview_link($data['preview_link']);

        $demos[ $demo->get_id() ] = $demo;

        unset($demo);
    }

    return $demos;
}
add_filter('fw:ext:backups-demo:demos', 'woffice_filter_theme_fw_ext_backups_demos');
// We don't save the Theme version used / exported 
/*function woffice_filter_fw_ext_backups_db_restore_keep_options($options, $is_full) {
    if (!$is_full) {
        $options[ 'template' ] = true;
        $options[ 'stylesheet' ] = true;
    }

    return $options;
}
add_filter('fw_ext_backups_db_restore_keep_options', 'woffice_filter_fw_ext_backups_db_restore_keep_options', 10, 2);*/
/*---------------------------------------------------------
** 
** Add more buttons to the html editor
**
----------------------------------------------------------*/
function woffice_add_quicktags() {
    if (wp_script_is('quicktags')){
?>
    <script type="text/javascript">
    QTags.addButton( 'eg_highlight', 'highlight', '<span class="highlight">', '</span>', 'hightlight', 'Highlight tag', 1 );
    QTags.addButton( 'eg_label', 'label', '<span class="label">', '</span>', 'label', 'Label tag', 1 );
    QTags.addButton( 'eg_dropcap', 'dropcap', '<span class="dropcap">', '</span>', 'dropcap', 'Dropcap tag', 1 );
    </script>
<?php
    }
}
add_action( 'admin_print_footer_scripts', 'woffice_add_quicktags' );
/*---------------------------------------------------------
** 
** Add lato to the WOrdpress editor
**
----------------------------------------------------------*/
function woffice_add_editor_styles() {
    $font_url = str_replace( ',', '%2C', '//fonts.googleapis.com/css?family=Lato:300,400,700' );
    add_editor_style( $font_url );
}
add_action( 'after_setup_theme', 'woffice_add_editor_styles' );
/*---------------------------------------------------------
** 
** ADDING DOCUMENTATION LINK
**
----------------------------------------------------------*/
add_action( 'admin_bar_menu', 'woffice_toolbar_link_to_mypage', 999 );
function woffice_toolbar_link_to_mypage( $wp_admin_bar ) {
	/*DOC LINK*/
	$topbar_woffice = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('topbar_woffice') : '';
	if ( current_user_can('administrator') && $topbar_woffice == "yep") {
		/*MAIN LINK*/
		$args_1 = array(
			'id'    => 'woffice_settings',
			'title' => 'Woffice Settings',
			'href'  => admin_url('themes.php?page=fw-settings'),
			'meta'  => array( 'class' => 'woffice_page' )
		);
		$wp_admin_bar->add_node( $args_1 );
		/*Doc*/
		$args_2 = array(
			'id'    => 'woffice_doc',
			'title' => 'Online Doc',
			'parent'=> 'woffice_settings',
			'href'  => 'https://woffice.io/documentation/',
			'meta'  => array( 'class' => 'woffice-documentation-page' )
		);
		$wp_admin_bar->add_node( $args_2 );
		/*Extension*/
		$args_3 = array(
			'id'    => 'woffice_extensions',
			'title' => 'Extensions',
			'parent'=> 'woffice_settings',
			'href'  => admin_url('index.php?page=fw-extensions'),
			'meta'  => array( 'class' => 'woffice-extension-page' )
		);
		$wp_admin_bar->add_node( $args_3 );
		/*Support*/
		$args_4 = array(
			'id'    => 'woffice_support',
			'title' => 'Support',
			'parent'=> 'woffice_settings',
			'href'  => 'https://2f.ticksy.com/',
			'meta'  => array( 'class' => 'woffice-support-page' )
		);
		$wp_admin_bar->add_node( $args_4 );
		/*Changelog*/
		$args_5 = array(
			'id'    => 'woffice_changelog',
			'title' => 'Changelog',
			'parent'=> 'woffice_settings',
			'href'  => 'https://woffice.io/changelog/',
			'meta'  => array( 'class' => 'woffice-changelog-page' )
		);
		$wp_admin_bar->add_node( $args_5 );
	}
}
/*---------------------------------------------------------
** 
** ADDING Woffice Version
**
----------------------------------------------------------*/
function woffice_filter_footer_version( $html ) {
	if ( (current_user_can( 'update_themes' ) || current_user_can( 'update_plugins' )) && defined("FW")) {
		return ( empty( $html ) ? '' : $html . ' | ' ) . fw()->theme->manifest->get('name') . ' ' . fw()->theme->manifest->get('version');
	} else {
		return $html;
	}
}
add_filter('update_footer', 'woffice_filter_footer_version', 12);
/*---------------------------------------------------------
** 
** THE ADMIN BAR
**
----------------------------------------------------------*/	
add_action('after_setup_theme', 'woffice_remove_admin_bar');
function woffice_remove_admin_bar() {
	if (!current_user_can('administrator') && !is_admin()) {
		show_admin_bar(false);
	}
}

/*---------------------------------------------------------
**
** FIX 404 ERROR AFTER DELETING POST
**
----------------------------------------------------------*/
/*
add_action('deleted_post', 'woffice_trashed_post_handler', 10);
function woffice_trashed_post_handler($post_id) {
    if(!is_admin()) {
        wp_redirect( get_option('site_url') );
        exit;
    }
}
*/

add_action( 'parse_request', 'woffice_trashed_post_handler' );
function woffice_trashed_post_handler() {
    if (!is_admin() && array_key_exists( 'deleted', $_GET ) && $_GET['deleted'] == '1') {
        wp_redirect( home_url() );
        exit;
    }
}

