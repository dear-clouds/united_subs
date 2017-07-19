<?php
/*------------------------------------------*/
/*	Theme constants
/*------------------------------------------*/
define ('MOM_URI' , get_template_directory_uri());
define ('MOM_DIR' , get_template_directory());
define ('MOM_JS' , MOM_URI . '/js');
define ('MOM_CSS' , MOM_URI . '/css');
define ('MOM_IMG' , MOM_URI . '/images');
define ('MOM_FW' , MOM_DIR . '/framework');
define ('MOM_PLUGINS', MOM_FW . '/plugins');
define ('MOM_FUN', MOM_FW . '/functions');
define ('MOM_WIDGETS', MOM_FW . '/widgets');
define ('MOM_SC', MOM_FW . '/shortcodes');
define ('MOM_HELPERS', MOM_URI . '/framework/helpers');
define ('MOM_PB', MOM_FW . '/page-builder/');
define ('MOM_AJAX', MOM_FW . '/ajax');
define ('MOM_ADDON', MOM_FW . '/addons');
define ('MOM_ADDON_URI', MOM_URI . '/framework/addons');

$curr_theme = wp_get_theme();
$theme_version = trim($curr_theme->get('Version'));
if(!$theme_version) $theme_version = "1.0";
//theme data
define ('MOM_THEME_NAME', $curr_theme->get('Name'));
define ('MOM_THEME_VERSION', $theme_version);

/*------------------------------------------*/
/*	Theme Translation
/*------------------------------------------*/
if (file_exists(get_stylesheet_directory().'/languages')) {
	load_theme_textdomain( 'framework', get_stylesheet_directory().'/languages' );


	$locale = get_locale();
	$locale_file = get_stylesheet_directory()."/languages/$locale.php";
	if ( is_readable($locale_file) )
		require_once($locale_file);
} else {
	load_theme_textdomain( 'framework', get_template_directory().'/languages' );
	$locale = get_locale();
	$locale_file = get_stylesheet_directory()."/languages/$locale.php";
	if ( is_readable($locale_file) )
		require_once($locale_file);
}


/*------------------------------------------*/
/*	Extensions
/*------------------------------------------*/
if (is_admin() ) {
	require_once MOM_FW . '/addons/addons.php';
}
/*------------------------------------------*/
/*	Mega menus
/*------------------------------------------*/
if ( file_exists( MOM_FW . '/menus/menu.php' ) ) {
	require_once( MOM_FW . '/menus/menu.php' );
}
/*------------------------------------------*/
/*	Theme Admin
/*------------------------------------------*/
if ( file_exists( MOM_FW . '/admin/admin-init.php' ) ) {
	require_once( MOM_FW . '/admin/admin-init.php' );
}

	// custom fonts
	include MOM_FW . '/admin/fonts-option/class.settings-api.php';
	include MOM_FW . '/admin/fonts-option/options.php';

	function mom_custom_fonts_to_typography() {
		$cf = get_option('mom_custom_fonts');
		$cfs = array();
		if (isset($cf['custom_fonts']) && is_array($cf['custom_fonts'])) {
		foreach ($cf['custom_fonts'] as $font) {
			$cfs[$font['font_name']] = $font['font_name'];
		}
	}

		return $cfs;
	}

	add_filter('mom_custom_fonts', 'mom_custom_fonts_to_typography');

	// add custom fonts to admin
	function mom_admin_custom_fonts() {
		//custom fonts
		ob_start();
		$cf = get_option('mom_custom_fonts');
		if (isset($cf['custom_fonts']) && is_array($cf['custom_fonts'])) { ?>
		<style type="text/css">
		<?php
		foreach ($cf['custom_fonts'] as $font) { ?>
			@font-face {
			font-family: '<?php echo $font['font_name']; ?>';
			src: url('<?php echo $font['eot']; ?>'); /* IE9 Compat Modes */
			src: url('<?php echo $font['eot']; ?>?#iefix') format('embedded-opentype'),
			url('<?php echo $font['woff']; ?>') format('woff'),
			url('<?php echo $font['ff']; ?>')  format('truetype'),
			url('<?php echo $font['svg']; ?>#svgFontName') format('svg');
			}
	<?php }
	?>
	</style>
<?php }
$output = ob_get_contents();
ob_end_clean();

		echo $output;
	}
	add_action('admin_head', 'mom_admin_custom_fonts');

	function mom_custom_tinymce_css($init) {
		ob_start();
		$cf = get_option('mom_custom_fonts');
		if (isset($cf['custom_fonts']) && is_array($cf['custom_fonts'])) { ?>
		<?php
		foreach ($cf['custom_fonts'] as $font) { ?>
			@font-face {
			font-family: '<?php echo $font['font_name']; ?>';
			src: url('<?php echo $font['eot']; ?>'); /* IE9 Compat Modes */
			src: url('<?php echo $font['eot']; ?>?#iefix') format('embedded-opentype'),
			url('<?php echo $font['woff']; ?>') format('woff'),
			url('<?php echo $font['ff']; ?>')  format('truetype'),
			url('<?php echo $font['svg']; ?>#svgFontName') format('svg');
			}
	<?php }
	?>
<?php }
$output = ob_get_contents();
ob_end_clean();

      $css = $output;

if (!empty($output)) {
     ?>

        <script type="text/javascript">

            function addTempCSS( ed ) {
                ed.on('init', function() {
                    tinyMCE.activeEditor.dom.addStyle(<?php echo json_encode($css) ?>);
                } );
            };
        </script>

        <?php
        if (wp_default_editor() == 'tinymce')
            $init['setup'] = 'addTempCSS';
}
        return $init;

    }
    add_filter('tiny_mce_before_init', 'mom_custom_tinymce_css');
/*------------------------------------------*/
/*	Theme Admin
/*------------------------------------------*/
function mom_option($option, $arr=null)
{
	if(defined('ICL_LANGUAGE_CODE') /*  && ICL_LANGUAGE_CODE != 'en' */) {
		$lang = ICL_LANGUAGE_CODE;
		global $opt_name ;
		global ${$opt_name};

		if($arr) {
		    if(isset(${$opt_name}[$option][$arr])) {
			return ${$opt_name}[$option][$arr];
		    }
		    } else {
		     if(isset(${$opt_name}[$option])) {
		   return ${$opt_name}[$option];
		     }
		    }

	} else {
			global $mom_options;
		if($arr) {
		    if(isset($mom_options[$option][$arr])) {
			return $mom_options[$option][$arr];
		    }
		    } else {
		     if(isset($mom_options[$option])) {
		   return $mom_options[$option];
		     }
		    }
	}

}

function is_edit_page($new_edit = null){
    global $pagenow;
    //make sure we are on the backend
    if (!is_admin()) return false;


    if($new_edit == "edit")
        return in_array( $pagenow, array( 'post.php',  ) );
    elseif($new_edit == "new") //check for new post page
        return in_array( $pagenow, array( 'post-new.php' ) );
    else //check for either new or edit
        return in_array( $pagenow, array( 'post.php', 'post-new.php' ) );
}
/*------------------------------------------*/
/*	Theme Widgets
/*------------------------------------------*/
$old_sidebars = get_option('sbg_sidebars');
if (is_array($old_sidebars)) {
require_once  MOM_FW . '/inc/sidebar_generator.php';
}

	if(!is_edit_page()) {
	    foreach ( glob( MOM_WIDGETS . '/*.php' ) as $file )
		{
			require_once $file;
		}
		if (file_exists(MOM_FW. '/sidebars/sidebars.php')) {
			include MOM_FW. '/sidebars/sidebars.php';
		}
	}
/*------------------------------------------*/
/*	Theme Plugins
/*------------------------------------------*/
if(mom_option('breadcrumb') == 1) {
require_once  MOM_FW . '/inc/breadcrumbs-plus/breadcrumbs-plus.php';
}
if (class_exists('WPBakeryVisualComposerAbstract') && file_exists( MOM_FW . '/organized/organized.php' )) {
require_once  MOM_FW . '/organized/organized.php';
}
/*------------------------------------------*/
/*	Theme Shortcodes
/*------------------------------------------*/
if(! is_admin()) {
    foreach ( glob( MOM_SC . '/*.php' ) as $file )
	{
		require_once $file;
	}
}
/*------------------------------------------*/
/*	Theme Ajax
/*------------------------------------------*/
require_once MOM_AJAX . '/ajax-full.php';
/*------------------------------------------*/
/*	Theme TinyMCE
/*------------------------------------------*/
    require_once MOM_FW . '/shortcodes/editor/shortcodes-ultimate.php';
    require_once MOM_FW . '/shortcodes/editor/shortcodes-init.php';
/*------------------------------------------*/
/*	Tiny MCE Custom font-sizes
/*------------------------------------------*/

function add_more_buttons($buttons) {
$buttons[] = 'charmap';
$buttons[] = 'fontselect';
$buttons[] = 'fontsizeselect';

return $buttons;
}
add_filter("mce_buttons", "add_more_buttons");

function mom_customize_text_sizes($initArray){
   $initArray['fontsize_formats'] = "10px 11px 12px 13px 14px 15px 16px 17px 18px 19px 20px 21px 22px 23px 24px 25px 26px 27px 28px 29px 30px 32px 48px";
   return $initArray;
}

// Add custom Fonts to the Fonts list
if ( ! function_exists( 'mom_custom_font_select' ) ) {
	function mom_custom_font_select( $initArray ) {
		$cf = get_option('mom_custom_fonts');
		$cfs = '';
		if (isset($cf['custom_fonts']) && is_array($cf['custom_fonts'])) {
		foreach ($cf['custom_fonts'] as $font) {
			$cfs .= $font['font_name'].'='.$font['font_name'].';';
		}
	}


	    $initArray['font_formats'] = 'Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats;'.$cfs;
            return $initArray;
	}
	add_filter( 'tiny_mce_before_init', 'mom_custom_font_select' );

}

// Assigns customize_text_sizes() to "tiny_mce_before_init" filter
add_filter('tiny_mce_before_init', 'mom_customize_text_sizes');

function mom_custom_upload_mimes($existing_mimes) {
	$existing_mimes['ttf'] = 'font/ttf';
	$existing_mimes['eot'] = 'font/eot';
	$existing_mimes['woff'] = 'font/woff';
	$existing_mimes['svg'] = 'font/svg';
	return $existing_mimes;
}
add_filter('upload_mimes', 'mom_custom_upload_mimes', 1, 1);
/*------------------------------------------*/
/*	Tiny MCE Custom Column dropdown
/*------------------------------------------*/

global $wp_version;
if ( $wp_version < 3.9 ) {
function register_momcols_dropdown( $buttons ) {
   array_push( $buttons, "momcols" );
   return $buttons;
}

function add_momcols_dropdown( $plugin_array ) {
   $plugin_array['momcols'] = get_template_directory_uri() . '/framework/shortcodes/js/cols.js';
   return $plugin_array;
}

function momcols_dropdown() {

   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
      return;
   }

   if ( get_user_option('rich_editing') == 'true' ) {
      add_filter( 'mce_external_plugins', 'add_momcols_dropdown' );
      add_filter( 'mce_buttons_2', 'register_momcols_dropdown' );
   }

}

add_action('admin_init', 'momcols_dropdown');

} else {

add_action('admin_head', 'mom_sc_cols_list');
function mom_sc_cols_list() {
    global $typenow;
    // check user permissions
    if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) {
   	return;
    }
    // verify the post type
    if( ! in_array( $typenow, array( 'post', 'page' ) ) )
        return;
	// check if WYSIWYG is enabled
	if ( get_user_option('rich_editing') == 'true') {
		add_filter("mce_external_plugins", "mom_cols_add_tinymce_plugin");
		add_filter('mce_buttons', 'mom_cols_register_my_tc_button');
	}
}
function mom_cols_add_tinymce_plugin($plugin_array) {
   	$plugin_array['columns'] = MOM_URI . '/framework/shortcodes/js/cols-list.js';
   	return $plugin_array;
}
function mom_cols_register_my_tc_button($buttons) {
   array_push($buttons, 'columns');
   return $buttons;
}

}
/*------------------------------------------*/
/*	Theme Functions
/*------------------------------------------*/
    foreach ( glob( MOM_FUN . '/*.php' ) as $file )
	{
		if ( MOM_FUN . '/functions.php' === $file) {} else {
		require_once $file;
		}
	}
/*------------------------------------------*/
/*	Woocommerce
/*------------------------------------------*/
if ( class_exists( 'woocommerce' ) ) {
	include_once MOM_FW . '/woocommerce/woocommerce.php';
}

/*------------------------------------------*/
/*	Theme Menus
/*------------------------------------------*/
register_nav_menus( array(
    'main'   => __('Main Menu', 'framework'),
    'topnav'   => __('Top Menu', 'framework'),
    'breaking'   => __('Breaking Bar icons Menu', 'framework'),
    'footer'   => __('Footer Menu', 'framework'),
    'copyright'   => __('Copyrights Menu', 'framework'),
) );
/*------------------------------------------*/
/*	Theme Support
/*------------------------------------------*/
add_theme_support( 'automatic-feed-links' );
add_theme_support('post-thumbnails');
add_theme_support( 'post-formats', array( 'image', 'video', 'audio', 'quote', 'gallery' , 'chat' ) );
/*------------------------------------------*/
/*	Theme Sidebars
/*------------------------------------------*/
if ( function_exists('register_sidebar') ) {

      register_sidebar(array(
	'name' => __('Main sidebar', 'framewrok'),
        'id' => 'main-sidebar',
	'description' => __('Default main sidebar.', 'framework'),
	'before_widget' => '<div class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<div class="widget-title"><h4>',
	'after_title' => '</h4></div>'
      ));

      register_sidebar(array(
	'name' => __('Secondary sidebar', 'framewrok'),
        'id' => 'secondary-sidebar',
	'description' => __('Default secondary sidebar.', 'framework'),
	'before_widget' => '<div class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<div class="widget-title"><h4>',
	'after_title' => '</h4></div>'
      ));


// footers
      register_sidebar(array(
	'name' => __('Footer 1', 'framewrok'),
        'id' => 'footer1',
	'description' => 'footer widget.',
	'before_widget' => '<div class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<div class="widget-title"><h4>',
	'after_title' => '</h4></div>'
      ));

      register_sidebar(array(
	'name' => __('Footer 2', 'framewrok'),
        'id' => 'footer2',
	'description' => 'footer widget.',
	'before_widget' => '<div class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<div class="widget-title"><h4>',
	'after_title' => '</h4></div>'
      ));

      register_sidebar(array(
	'name' => __('Footer 3', 'framewrok'),
        'id' => 'footer3',
	'description' => 'footer widget.',
	'before_widget' => '<div class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<div class="widget-title"><h4>',
	'after_title' => '</h4></div>'
      ));

      register_sidebar(array(
	'name' => __('Footer 4', 'framewrok'),
        'id' => 'footer4',
	'description' => 'footer widget.',
	'before_widget' => '<div class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<div class="widget-title"><h4>',
	'after_title' => '</h4></div>'
      ));

      register_sidebar(array(
	'name' => __('Footer 5', 'framewrok'),
        'id' => 'footer5',
	'description' => 'footer widget.',
	'before_widget' => '<div class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<div class="widget-title"><h4>',
	'after_title' => '</h4></div>'
      ));

      register_sidebar(array(
	'name' => __('Footer 6', 'framewrok'),
        'id' => 'footer6',
	'description' => 'footer widget.',
	'before_widget' => '<div class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<div class="widget-title"><h4>',
	'after_title' => '</h4></div>'
      ));

            global $wp_registered_sidebars;
            $n = count($wp_registered_sidebars);
    register_sidebar(array('name' => 'Tabbed Widget', 'id' => 'sidebar-' . ++$n,  'description' => 'Default Tabbed Widget sidebar, you can add you custom one with custom sidebars.'));

 }
/*------------------------------------------*/
/*	Theme Metaboxes
/*------------------------------------------*/
require_once  MOM_FW . '/metaboxes/meta-box.php';
require_once  MOM_FW . '/metaboxes/theme.php';
include_once MOM_FW . '/metaboxes/momizat-class/MetaBox.php';
include_once MOM_FW . '/metaboxes/momizat-class/MediaAccess.php';

// global styles for the meta boxes
if (is_admin()) add_action('admin_enqueue_scripts', 'metabox_style');

function metabox_style() {
	wp_enqueue_style('wpalchemy-metabox', get_template_directory_uri() . '/framework/metaboxes/momizat-class/meta.css');
	wp_enqueue_script('momizat-metabox-js', get_template_directory_uri() . '/framework/metaboxes/momizat-class/meta.js');
}
$wpalchemy_media_access = new MomizatMB_MediaAccess();

// custom metaboxes
include_once MOM_FW . '/metaboxes/momizat-class/posts-spec.php';

/*------------------------------------------*/
/*	Review system
/*------------------------------------------*/
//Backend
include_once MOM_FW . '/review/review-spec.php';
//user rate
include_once MOM_FW . '/review/user_rate.php';
//frontend
include_once MOM_FW . '/review/review-system.php';

/*------------------------------------------*/
/*	Ads system
/*------------------------------------------*/
//Backend
include_once MOM_FW . '/ads/ads-spec.php';
include_once MOM_FW . '/ads/ads-type.php';

//frontend
include_once MOM_FW . '/ads/ads-system.php';

/*------------------------------------------*/
/*	Theme Enhancments
/*------------------------------------------*/
//shortcodes in widgets
add_filter( 'widget_text', 'shortcode_unautop');
add_filter( 'widget_text', 'do_shortcode', 11);

// This theme uses its own gallery styles.
add_filter( 'use_default_gallery_style', '__return_false' );

// Theme options When activated
if (isset($_GET['activated'])) {
	if ($_GET['activated']){
		wp_redirect(admin_url("themes.php?page=momizat_options&settings-updated=true"));
	}
}
/*------------------------------------------*/
/*	Google Fonts
/*------------------------------------------*/
function mom_google_fonts () {
$cutomfont = mom_option('font-name');
$safe_fonts = array(
	'' => 'Default',
	'arial'=>'Arial',
	'georgia' =>'Georgia',
	'arial'=>'Arial',
	'verdana'=>'Verdana, Geneva',
	'trebuchet'=>'Trebuchet',
	'times'=>'Times New Roman',
	'tahoma'=>'Tahoma, Geneva',
	'palatino'=>'Palatino',
	'helvetica'=>'Helvetica',
	'Archivo Narrow'=>'Archivo Narrow',
	$cutomfont=>$cutomfont
	);

return $safe_fonts;

}
/* ==========================================================================
 *                Modal Box
   ========================================================================== */
add_action( 'admin_head', 'mom_admin_modal_box' );
function mom_admin_modal_box() { ?>
	<div class="mom_modal_box">
		<div class="mom_modal_header"><h1><?php _e('Select Icon', 'framework'); ?></h1><a class="media-modal-close" id="mom_modal_close" href="#"><span class="media-modal-icon"></span></a></div>
		<div class="mom_modal_content"><span class="mom_modal_loading"></span></div>
		<div class="mom_modal_footer"><a class="mom_modal_save button-primary" href="#"><?php _e('Save', 'framework'); ?></a></div>
	</div>
	<div class="mom_media_box_overlay"></div>
<?php }
add_action( 'admin_enqueue_scripts', 'mom_admin_global_scripts' );
function mom_admin_global_scripts () {
//Load our custom javascript file
	$Lpage = '';
	if (isset($_GET['page']) && $_GET['page'] == 'codestyling-localization/codestyling-localization.php') {
		$Lpage = true;
	}
	if ($Lpage == false) {
		wp_enqueue_script( 'mom-admin-global-script', get_template_directory_uri() . '/framework/helpers/js/admin.js' );
		wp_localize_script( 'mom-admin-global-script', 'MomCats', array(
			'url' => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'ajax-nonce' ),
			)
		);
	}

}
// ajax Action
add_action( 'wp_ajax_mom_loadIcon', 'mom_icon_container' );
/* ==========================================================================
 *                Visual Composer
   ========================================================================== */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if (class_exists('WPBakeryVisualComposerAbstract')) {
	include_once( MOM_FW . '/includes/builder.php' );
}

if(function_exists('vc_set_as_theme')) vc_set_as_theme(true);

/* ==========================================================================
 *                buddypress
   ========================================================================== */
if (class_exists('BP_Core_Members_Widget')) {
    function mom_unregister_pb_wp_widgets() {
        unregister_widget('BP_Core_Members_Widget');
        unregister_widget('BP_Groups_Widget');
        unregister_widget('BP_Core_Friends_Widget');
    }
    add_action( 'widgets_init', 'mom_unregister_pb_wp_widgets' );
}
/* ==========================================================================
 *                Remove authore meta box if authors more than 1000
   ========================================================================== */
$users_count = count_users();
$users_count = $users_count['total_users'];
if ($users_count > 1000) {
function mom_remove_page_fields() {
 remove_meta_box( 'authordiv' , 'page' , 'normal' ); //removes author
 remove_meta_box( 'authordiv' , 'post' , 'normal' ); //removes author
}
add_action( 'admin_menu' , 'mom_remove_page_fields' );
}
/* ==========================================================================
 *                Remove hentry From post calsses
   ========================================================================== */
function mom_remove_from_posts_class( $classes ) {
    $classes = array_diff( $classes, array( "hentry" ) );
    return $classes;
}
add_filter( 'post_class', 'mom_remove_from_posts_class' );
/* ==========================================================================
 *                Shortcodes content filter Added in version 1.7.2
   ========================================================================== */
/**
 * Removes mismatched </p> and <p> tags from a string
 *
 * @author Jason Lengstorf <jason@copterlabs.com>
 */
function mom_remove_crappy_markup( $string )
{
    $patterns = array(
        '#^\s*</p>#',
        '#<p>\s*$#'
    );

    return preg_replace($patterns, '', $string);
}
/*------------------------------------------*/
/*	Title
/*------------------------------------------*/
function mom_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name', 'display' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'theme' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'mom_wp_title', 10, 2 );


/*------------------------------------------*/
/*	clear all transient if ?
/*------------------------------------------*/
function mom_clear_transients () {
	global $wpdb;
	$sql = 'DELETE FROM ' . $wpdb->options . ' WHERE option_name LIKE "_transient_%"';
	$wpdb->query($sql);
}

if(defined('ICL_LANGUAGE_CODE') || mom_option('theme_cache') == 0) {
	add_action( 'template_redirect', 'mom_clear_transients');
}
add_action( 'save_post', 'mom_clear_transients');
add_action( 'deleted_post', 'mom_clear_transients');
add_action( 'switch_theme', 'mom_clear_transients');
add_action( 'wp_update_nav_menu', 'mom_clear_transients');
add_action( 'wp_insert_comment', 'mom_clear_transients');
add_action( 'edit_category', 'mom_clear_transients');
add_action( 'delete_category', 'mom_clear_transients');
add_action( 'add_category', 'mom_clear_transients');
add_action( 'wp_trash_post', 'mom_clear_transients');
add_action( 'untrash_post', 'mom_clear_transients');
add_action( 'delete_post', 'mom_clear_transients');

//clear transients when save or reset options
add_action('redux/options/mom_options/saved', 'mom_clear_transients');

//after update the theme
add_action('upgrader_process_complete', 'mom_clear_transients');



if (is_admin()) {
if (file_exists(MOM_FW . '/demo/init.php')) {
require_once MOM_FW . '/demo/init.php';
}
}
/* ==========================================================================
 *                using cookies
   ========================================================================== */

if( !function_exists( 'mom_setcookie' ) ) {
    /**
     * Create a cookie.
     *
     * @param string $name
     * @param mixed $value
     * @return bool
     * @since 1.0.0
     */
    function mom_setcookie( $name, $value = array(), $time = null ) {
        $time = $time != null ? $time : time() + 60 * 60 * 24 * 7;

        $value = maybe_serialize( stripslashes_deep( $value ) );
        $expiration = apply_filters( 'mom_cookie_expiration_time', $time ); // Default 7 days

        return setcookie( $name, $value, $expiration, '/' );
    }
}

if( !function_exists( 'mom_getcookie' ) ) {
    /**
     * Retrieve the value of a cookie.
     *
     * @param string $name
     * @return mixed
     * @since 1.0.0
     */
    function mom_getcookie( $name ) {
        if( isset( $_COOKIE[$name] ) )
            { return maybe_unserialize( stripslashes( $_COOKIE[$name] ) ); }

        return array();
    }
}

function momizat_shortcodes_formatter($content) {
	$block = join("|",array("rev_slider", "button", "dropcap", "highlight", "checklist", "tabs", "tab", "accordian", "one_full", "one_half", "one_third", "one_fourth", "two_third", "three_fourth", "one_fifth", "two_fifth", "three_fifth", "four_fifth", "one_sixth", "five_sixth", "lightbox_content", "icontext", "iconbox", "testimonial_slider", "blog", "box", "callout", "button", "graphs", "iconbox", "icon", "social", "lightbox",  "feature_slider", "g_map", "gap", "animate", "visibility", "pop-up", "table", "document", "members", "feed", "mom_adsense", "newsbox", "newspic", "news_tabs", "scroller", "accordions", "tabs", "team", "mom_video", "weather_chart", "weather_map", "dropcap", "incor", "quote", "highlight", "divide", "clear", "list", "tip", "testimonial", "images", "images_grid"));

	// opening tag
	$rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);

	// closing tag
	$rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);

	return $rep;
}

add_filter('the_content', 'momizat_shortcodes_formatter');
add_filter('widget_text', 'momizat_shortcodes_formatter');

function mom_get_lang() {
	        $lang = '';
        if(defined('ICL_LANGUAGE_CODE')) {
            $lang = ICL_LANGUAGE_CODE;
        }
        if (function_exists('qtrans_getLanguage')) {
            $lang = qtrans_getLanguage();
        }

        return $lang;
}
?>
