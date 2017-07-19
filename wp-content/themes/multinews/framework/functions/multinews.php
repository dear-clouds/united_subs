<?php
$scroller_thumb = mom_option('scroller-thumb');
$scroller_thumb_width = isset($scroller_thumb['width']) ? $scroller_thumb['width'] : 274;
$scroller_thumb_height = isset($scroller_thumb['height']) ? $scroller_thumb['height'] : 183;
$nb1_thumb = mom_option('nb1-thumb');
$nb1_thumb_width = isset($nb1_thumb['width']) ? $nb1_thumb['width'] : 364;
$nb1_thumb_height = isset($nb1_thumb['height']) ? $nb1_thumb['height'] : 245;
$nb3_thumb = mom_option('nb3-thumb');
$nb3_thumb_width = isset($nb3_thumb['width']) ? $nb3_thumb['width'] : 80;
$nb3_thumb_height = isset($nb3_thumb['height']) ? $nb3_thumb['height'] : 54;
$nb5_thumb = mom_option('nb5-thumb');
$nb5_thumb_width = isset($nb5_thumb['width']) ? $nb5_thumb['width'] : 130;
$nb5_thumb_height = isset($nb5_thumb['height']) ? $nb5_thumb['height'] : 87;
$npic_thumb = mom_option('npic-thumb');
$npic_thumb_width = isset($npic_thumb['width']) ? $npic_thumb['width'] : 359;
$npic_thumb_height = isset($npic_thumb['height']) ? $npic_thumb['height'] : 240;
$np_thumb = mom_option('np-thumb');
$np_thumb_width = isset($np_thumb['width']) ? $np_thumb['width'] : 85;
$np_thumb_height = isset($np_thumb['height']) ? $np_thumb['height'] : 57;
$slider_thumb = mom_option('slider-thumb');
$slider_thumb_width = isset($slider_thumb['width']) ? $slider_thumb['width'] : 546;
$slider_thumb_height = isset($slider_thumb['height']) ? $slider_thumb['height'] : 365;
$newstabs_thumb = mom_option('newstabs-thumb');
$newstabs_thumb_width = isset($newstabs_thumb['width']) ? $newstabs_thumb['width'] : 266;
$newstabs_thumb_height = isset($newstabs_thumb['height']) ? $newstabs_thumb['height'] : 179;
$related_thumb = mom_option('related-thumb');
$related_thumb_width = isset($related_thumb['width']) ? $related_thumb['width'] : 165;
$related_thumb_height = isset($related_thumb['height']) ? $related_thumb['height'] : 109;
$search_grid = mom_option('search-grid');
$search_grid_width = isset($search_grid['width']) ? $search_grid['width'] : 347;
$search_grid_height = isset($search_grid['height']) ? $search_grid['height'] : 233;
$megamenu_thumb = mom_option('megamenu-thumb');
$megamenu_thumb_width = isset($megamenu_thumb['width']) ? $megamenu_thumb['width'] : 112;
$megamenu_thumb_height = isset($megamenu_thumb['height']) ? $megamenu_thumb['height'] : 75;
$search_thumb = mom_option('search-thumb');
$search_thumb_width = isset($search_thumb['width']) ? $search_thumb['width'] : 36;
$search_thumb_height = isset($search_thumb['height']) ? $search_thumb['height'] : 36;
$blogb_thumb = mom_option('blogb-thumb');
$blogb_thumb_width = isset($blogb_thumb['width']) ? $blogb_thumb['width'] : 546;
$blogb_thumb_height = isset($blogb_thumb['height']) ? $blogb_thumb['height'] : 300;
$blog_thumb = mom_option('blog-thumb');
$blog_thumb_width = isset($blog_thumb['width']) ? $blog_thumb['width'] : 179;
$blog_thumb_height = isset($blog_thumb['height']) ? $blog_thumb['height'] : 120;
$media_thumb = mom_option('media-thumb');
$media_thumb_width = isset($media_thumb['width']) ? $media_thumb['width'] : 179;
$media_thumb_height = isset($media_thumb['height']) ? $media_thumb['height'] : 116;
$media1_thumb = mom_option('media1-thumb');
$media1_thumb_width = isset($media1_thumb['width']) ? $media1_thumb['width'] : 367;
$media1_thumb_height = isset($media1_thumb['height']) ? $media1_thumb['height'] : 237;
$catslider_thumb = mom_option('catslider-thumb');
$catslider_thumb_width = isset($catslider_thumb['width']) ? $catslider_thumb['width'] : 576;
$catslider_thumb_height = isset($catslider_thumb['height']) ? $catslider_thumb['height'] : 392;
$catslider1_thumb = mom_option('catslider1-thumb');
$catslider1_thumb_width = isset($catslider1_thumb['width']) ? $catslider1_thumb['width'] : 702;
$catslider1_thumb_height = isset($catslider1_thumb['height']) ? $catslider1_thumb['height'] : 432;
$postlist_thumb = mom_option('postlist-thumb');
$postlist_thumb_width = isset($postlist_thumb['width']) ? $postlist_thumb['width'] : 170;
$postlist_thumb_height = isset($postlist_thumb['height']) ? $postlist_thumb['height'] : 113;
$sliderwidget_thumb = mom_option('sliderwidget-thumb');
$sliderwidget_thumb_width = isset($sliderwidget_thumb['width']) ? $sliderwidget_thumb['width'] : 333;
$sliderwidget_thumb_height = isset($sliderwidget_thumb['height']) ? $sliderwidget_thumb['height'] : 227;
$postpicwid_thumb = mom_option('postpicwid-thumb');
$postpicwid_thumb_width = isset($postpicwid_thumb['width']) ? $postpicwid_thumb['width'] : 81;
$postpicwid_thumb_height = isset($postpicwid_thumb['height']) ? $postpicwid_thumb['height'] : 55;
$big_thumb_hd = mom_option('big-thumb-hd');
$big_thumb_hd_width = isset($big_thumb_hd['width']) ? $big_thumb_hd['width'] : 765;
$big_thumb_hd_height = isset($big_thumb_hd['height']) ? $big_thumb_hd['height'] : 510;

if(mom_option('theme_thumb') != 0) {
	//post thumbnails
	add_image_size( 'scroller-thumb', $scroller_thumb_width, $scroller_thumb_height, array( 'center', 'top' ) );
	add_image_size( 'nb1-thumb', $nb1_thumb_width, $nb1_thumb_height, array( 'center', 'top' ) );
	add_image_size( 'nb3-thumb', $nb3_thumb_width, $nb3_thumb_height, array( 'center', 'top' ) );
	add_image_size( 'nb5-thumb', $nb5_thumb_width, $nb5_thumb_height, array( 'center', 'top' ) );
	add_image_size( 'npic-thumb', $npic_thumb_width, $npic_thumb_height, array( 'center', 'top' ) );
	add_image_size( 'np-thumb', $np_thumb_width, $np_thumb_height, array( 'center', 'top' ) );
	add_image_size( 'slider-thumb', $slider_thumb_width, $slider_thumb_height, array( 'center', 'top' ) );
	add_image_size( 'newstabs-thumb', $newstabs_thumb_width, $newstabs_thumb_height, array( 'center', 'top' ) );
	add_image_size( 'related-thumb', $related_thumb_width, $related_thumb_height, array( 'center', 'top' ) );
	add_image_size( 'search-grid', $search_grid_width, $search_grid_height, array( 'center', 'top' ) );
	add_image_size( 'megamenu-thumb', $megamenu_thumb_width, $megamenu_thumb_height, array( 'center', 'top' ) );
	add_image_size( 'search-thumb', $search_thumb_width, $search_thumb_height, array( 'center', 'top' ) );
	add_image_size( 'blogb-thumb', $blogb_thumb_width, $blogb_thumb_height, array( 'center', 'top' ) );
	add_image_size( 'blog-thumb', $blog_thumb_width, $blog_thumb_height, array( 'center', 'top' ) );
	add_image_size( 'media-thumb', $media_thumb_width, $media_thumb_height, array( 'center', 'top' ) );
	add_image_size( 'media1-thumb', $media1_thumb_width, $media1_thumb_height, array( 'center', 'top' ) );
	add_image_size( 'catslider-thumb', $catslider_thumb_width, $catslider_thumb_height, array( 'center', 'top' ) );
	add_image_size( 'catslider1-thumb', $catslider1_thumb_width, $catslider1_thumb_height, array( 'center', 'top' ) );
	//widgets
	add_image_size( 'postlist-thumb', $postlist_thumb_width, $postlist_thumb_height, array( 'center', 'top' ) );
	add_image_size( 'sliderwidget-thumb', $sliderwidget_thumb_width, $sliderwidget_thumb_height, array( 'center', 'top' ) );
	add_image_size( 'postpicwid-thumb', $postpicwid_thumb_width, $postpicwid_thumb_height, array( 'center', 'top' ) );
}
	add_image_size( 'big-thumb-hd', $big_thumb_hd_width, $big_thumb_hd_height, array( 'center', 'top' ) );


$mom_thumbs_sizes = array(
	'thumbnail' => array(get_option( 'thumbnail_size_w' ), get_option( 'thumbnail_size_h' )),
	'medium' => array(get_option( 'medium_size_w' ), get_option( 'medium_size_h' )),
	'large' => array(get_option( 'large_size_w' ), get_option( 'large_size_h' )),
	'full' => array('', ''),
	'scroller-thumb' => array($scroller_thumb_width, $scroller_thumb_height, true ),
	'nb1-thumb' => array($nb1_thumb_width, $nb1_thumb_height, true ),
	'nb3-thumb' => array($nb3_thumb_width, $nb3_thumb_height, true ),
	'nb5-thumb' => array($nb5_thumb_width, $nb5_thumb_height, true ),
	'npic-thumb' => array($npic_thumb_width, $npic_thumb_height, true ),
	'np-thumb' => array($np_thumb_width, $np_thumb_height, true ),
	'slider-thumb' => array($slider_thumb_width, $slider_thumb_height, true ),
	'newstabs-thumb' => array($newstabs_thumb_width, $newstabs_thumb_height, true ),
	'related-thumb' => array($related_thumb_width, $related_thumb_height, true ),
	'search-grid' => array($search_grid_width, $search_grid_height, true ),
	'megamenu-thumb' => array($megamenu_thumb_width, $megamenu_thumb_height, true ),
	'search-thumb' => array($search_thumb_width, $search_thumb_height, true ),
	'blogb-thumb' => array($blogb_thumb_width, $blogb_thumb_height, true ),
	'blog-thumb' => array($blog_thumb_width, $blog_thumb_height, true ),
	'media-thumb' => array($media_thumb_width, $media_thumb_height, true ),
	'media1-thumb' => array($media1_thumb_width, $media1_thumb_height, true ),
	'catslider-thumb' => array($catslider_thumb_width, $catslider_thumb_height, true ),
	'catslider1-thumb' => array($catslider1_thumb_width, $catslider1_thumb_height, true ),
	'big-thumb-hd' => array($big_thumb_hd_width, $big_thumb_hd_height, true ),
	'postlist-thumb' => array($postlist_thumb_width, $postlist_thumb_height, true ),
	'sliderwidget-thumb' => array($sliderwidget_thumb_width, $sliderwidget_thumb_height, true ),
	'postpicwid-thumb' => array($postpicwid_thumb_width, $postpicwid_thumb_height, true ),
);
/* ==========================================================================
 *                Body classes
   ========================================================================== */
function mom_body_classes( $classes ) {
$hst = mom_option('header_style');
$bnmenu = mom_option('bn_bar_menu');
$custom_layout = '';
global $post;
$site_width = mom_option('site_width');
$mom_post_layout = mom_option('post_layout');
if ( is_singular() ) {
$custom_layout = get_post_meta(get_queried_object_id(), 'mom_background_tr', true);
$layout = get_post_meta(get_queried_object_id(), 'mom_page_layout', true);
if ($layout == '') { $layout = mom_option('post_page_layout'); }

if (is_page()) {
	if ($layout == '') {
    	$layout = mom_option('page_layout');
	}
}
if (is_single()) { if ($layout == '') { $layout = mom_option('post_page_layout'); } }

if (is_page_template('media.php')) {
	$layout = 'right-sidebar';
}
      if(function_exists('is_bbpress') && is_bbpress()) {
	if ($layout == '') { $layout = mom_option('bbpress_layout');}
	if(function_exists('is_buddypress') && is_buddypress()) {
	if (get_post_meta(get_queried_object_id(), 'mom_page_layout', true) == '') { $layout = mom_option('buddypress_layout');}
	}

      } elseif(function_exists('is_buddypress') && is_buddypress()) {
	if ($layout == '') { $layout = mom_option('buddypress_layout');}
      }

if ($layout == '') { $layout = mom_option('main_layout'); }
    $mom_post_layout = get_post_meta($post->ID, 'mom_post_layout', true);

    if ($mom_post_layout == '') {
	$mom_post_layout = mom_option('post_layout');
    }
} elseif (function_exists('is_bbpress') && is_bbpress()) {
	$layout = mom_option('bbpress_layout');
	if ($layout == '') {
	    $layout = mom_option('main_layout');
	}
} elseif (function_exists('is_buddypress') && is_buddypress()) {
	$layout = mom_option('buddypress_layout');
	if ($layout == '') {
	    $layout = mom_option('main_layout');
	}
} else {
$layout = mom_option('main_layout');
}



	if (is_archive()) {
	  $layout = mom_option('category_layout');
	  if ($layout == '') {
	    $layout = mom_option('main_layout');
	  }
	}

	if(is_post_type_archive( 'forum' ) || is_singular( array( 'forum', 'topic', 'reply' )) ) {
	$layout = mom_option('bbpress_layout');
	if ($layout == '') {
	   $layout = mom_option('main_layout');
	}
	}
if(function_exists('is_woocommerce') && is_woocommerce()) {
    $woo_page_id = '';
if (is_shop()) {
    $woo_page_id = get_option('woocommerce_shop_page_id');
} elseif (is_cart()) {
    $woo_page_id = get_option('woocommerce_cart_page_id');
} elseif (is_checkout()) {
    $woo_page_id = get_option('woocommerce_checkout_page_id');
} elseif (is_account_page()) {
    $woo_page_id = get_option('woocommerce_myaccount_page_id');
} else {
    $woo_page_id = get_option('woocommerce_shop_page_id');
}
$layout = get_post_meta($woo_page_id, 'mom_page_layout', true);
if ($layout == '') {
  $layout = mom_option('main_layout');
}

$custom_layout = get_post_meta($woo_page_id, 'mom_background_tr', true);

}

	if ($layout != '') {
	    $classes[] = $layout;
	}

	if ($layout == 'right-sidebar' || $layout == 'left-sidebar' ) {
		$classes[] = 'one_side_bar_layout';
	}

	if(is_singular()) {
		global $post;
			/*
			if( !is_object($post) )
	        return;
			*/
		if (strpos($layout,'both') === false && $layout == 'fullwidth') {
			$classes[] = 'one_side_bar_layout';
		}
	} else {
		if (strpos($layout,'both') === false) {
			$classes[] = 'one_side_bar_layout';
		}
	}

	if ($layout != 'right-sidebar' && $layout != 'left-sidebar') {
		$classes[] = 'both-sides-true';
	}

	if ( is_singular() && ! is_front_page() ) {
		$classes[] = 'singular';
	}

	if ($hst == 'st1') {
		$classes[] = 'hst1';
	} elseif ($hst == 'st2') {
		$classes[] = 'hst2';
	} elseif ($hst == 'st3') {
		$classes[] = 'hst3';
	}
if (mom_option('theme_layout') == '') {
		$classes[] = 'theme_layout_full';
}

	if (mom_option('fade_imgs') == 1) {
	    $classes[] = 'fade-imgs-in-appear';
	}

	if (mom_option('sticky_navigation') == 1) {
	    $classes[] = 'sticky_navigation_on';
	}

	if (mom_option('post_format_icons') == 0) {
	    $classes[] = 'no-post-format-icons';
	}
	if (mom_option('post_images_in_lightbox') == 1) {
		$classes[] = 'open_images_in_lightbox';
	}
	if (mom_option('enable_responsive') == 1) {
		$classes[] = 'responsive_enabled';
	}

	if (mom_option('automatic_weather') == 1) {
		$classes[] = 'automatic_weather';
	}

	if (mom_option('show_sidebar_on_ipad') == 1) {
		$classes[] = 'show_sidebar_on_ipad';
	}
	if($bnmenu == false) {
		$classes[] = 'no-bnmenu';
	}


	if (mom_option('nicescroll') == 1) {
		$classes[] = 'smooth_scroll_enable';
	}

	if($custom_layout == true && get_post_meta($post->ID, 'mom_page_layout', true) == 'fullwidth') {
		$classes[] = 'custom-layout';
	}


	if($mom_post_layout == 'layout1'){
		$classes[] = 'post-page-layout1';
	} elseif($mom_post_layout == 'layout2'){
		$classes[] = 'post-page-layout2';
	} elseif($mom_post_layout == 'layout3'){
		$classes[] = 'post-page-layout3';
	} elseif($mom_post_layout == 'layout4'){
		$classes[] = 'post-page-layout4';
	}

	if(mom_option('wpgallery_lightbox') != 0) {
		$classes[] = 'wp_gallery_lightbox_on';
	}
	if (mom_option('hide_sidebars_in_mobiles') == 1) {
		$classes[] = 'hide_sidebars_in_mobiles';
	}

	if( function_exists('is_mobile') && is_mobile() && mom_option('hide_sidebars_in_mobiles') == 1 ){
		$classes[] = 'is_mobile';
	}
	if (mom_option('post_views_ajax') == 1) {
		$classes[] = 'post_views_with_ajax';
	}

	$classes[] = 'multinews-'.MOM_THEME_VERSION;

		$classes[] = 'mom-body';

	return $classes;
}
add_filter( 'body_class', 'mom_body_classes' );

/* ==========================================================================
 *                GeT Years
   ========================================================================== */
function mom_get_years($name, $args = '') {
	global $wpdb, $wp_locale;

	$defaults = array(
		'type' => 'monthly',
                'limit' => '',
		'format' => 'html',
		'echo' => 0,
                'order' => 'DESC',
	);

	$r = wp_parse_args( $args, $defaults );
	extract( $r, EXTR_SKIP );

	if ( '' == $type )
		$type = 'monthly';

	if ( '' != $limit ) {
		$limit = absint($limit);
		$limit = ' LIMIT '.$limit;
	}

	$order = strtoupper( $order );
	if ( $order !== 'ASC' )
		$order = 'DESC';

	$where = apply_filters( 'getarchives_where', "WHERE post_type = 'post' AND post_status = 'publish'", $r );
	$join = apply_filters( 'getarchives_join', '', $r );

	$output = '';

	$last_changed = wp_cache_get( 'last_changed', 'posts' );
	if ( ! $last_changed ) {
		$last_changed = microtime();
		wp_cache_set( 'last_changed', $last_changed, 'posts' );
	}

		$query = "SELECT YEAR(post_date) AS `year`, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date) ORDER BY post_date $order $limit";
		$key = md5( $query );
		$key = "wp_get_archives:$key:$last_changed";
		if ( ! $results = wp_cache_get( $key, 'posts' ) ) {
			$results = $wpdb->get_results( $query );
			wp_cache_set( $key, $results, 'posts' );
		}
		if ( $results ) {
			foreach ( (array) $results as $result) {
				$text = sprintf('%d', $result->year);
				$output .= mom_get_years_text( $text, $name);

			}
		}

	if ( $echo )
		echo $output;
	else
		return $output;
}

function mom_get_years_text( $text,$name = '', $format = 'option', $before = '', $after = '') {
	$text = wptexturize($text);
    if (isset($_GET[$name])) {
        $name = $_GET[$name];
    }
	if ('link' == $format)
		$link_html = "\t<link rel='archives' title='" . esc_attr( $text ) . "' href='$text' />\n";
	elseif ('option' == $format)
		$link_html = "\t<option value='$text'".selected($name , $text).">$before $text $after</option>\n";
	elseif ('html' == $format)
		$link_html = "\t<li>$before<a href='$text'>$text</a>$after</li>\n";
	else // custom
		$link_html = "\t$before<a href='$text'>$text</a>$after\n";

	//$link_html = apply_filters( 'get_archives_link', $link_html );

	return $link_html;
}

/* ==========================================================================
 *                Login Form
   ========================================================================== */
function mom_login_form( $login_only  = 0 ) {
	global $user_ID, $user_identity, $user_level;

	if ( $user_ID ) : ?>
		<?php if( empty( $login_only ) ): ?>
		<div id="user-login">
			<span class="author-avatar"><?php echo get_avatar( $user_ID, $size = '85'); ?></span>
			<h2 class="welcome-text"><?php _e( 'Welcome' , 'framework' ) ?> <strong><?php echo $user_identity ?></strong>.</h2>
			<ul class="user-login-links">
				<?php
					$id = get_current_user_id();
				?>
				<li><a href="<?php echo get_edit_profile_url($id); ?>"><i class="enotype-icon-vcard"></i><?php _e( 'Your Profile' , 'framework' ) ?> </a></li>
				<li><a href="<?php echo wp_logout_url(); ?>"><i class="enotype-icon-logout"></i><?php _e( 'Logout' , 'framework' ) ?> </a></li>
			</ul>
			<div class="clear"></div>

			<div class="clear"></div>
		</div>
		<?php endif; ?>
	<?php else: ?>
		<div class="login-widget">
	        <form action="<?php echo home_url() ?>/wp-login.php" method="post">
	            <div class="login-input-wrap login-user-wrap"><span class="momizat-icon-user3"></span><input type="text" class="login-user" name="log" id="log" value="<?php _e( 'Username' , 'framework' ) ?>" onfocus="if (this.value == '<?php _e( 'Username' , 'framework' ) ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e( 'Username' , 'framework' ) ?>';}"></div>
	            <div class="login-input-wrap login-pwd-wrap"><span></span><input type="password" class="login-pwd" name="pwd" id="pwd" value="<?php _e( 'Password' , 'framework' ) ?>" onfocus="if (this.value == '<?php _e( 'Password' , 'framework' ) ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e( 'Password' , 'framework' ) ?>';}"></div>
	            <input type="submit" class="login-button" name="submit" value="<?php _e( 'login' , 'framework' ) ?>">
	            <input class="rememberme" name="rememberme" id="rememberme" type="checkbox" checked="checked" value="forever">
	            <label for="rememberme"><?php _e( 'Remember Me' , 'framework' ) ?></label>
	            <input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>"/>
	        </form>
	        <ul class="login-links">
	        	<?php if ( get_option('users_can_register') ) : ?> <li><a href="<?php echo home_url() ?>/wp-register.php"><?php _e( 'Register' , 'framework' ) ?></a></li><?php endif; ?>
	            <li><a href="<?php echo home_url() ?>/wp-login.php?action=lostpassword"><?php _e( 'Lost your password?' , 'framework' ) ?></a></li>
	        </ul>
	    </div>
	<?php endif;
}
if (mom_option('redirect_login') == 1) {
	add_action( 'wp_login_failed', 'mom_login_fail' );  // hook failed login
}

function mom_login_fail( $username ) {
   $referrer = $_SERVER['HTTP_REFERER'];  // where did the post submission come from?
   // if there's a valid referrer, and it's not the default log-in screen
   if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') ) {
      wp_redirect( $referrer . '?login=failed' );  // let's append some information (login=failed) to the URL for the theme to use
      exit;
   }
}
/* ==========================================================================
 *                Category Options
   ========================================================================== */
add_action ( 'edit_category_form_fields', 'mom_category_style');
    function mom_category_style( $tag ) {
	$t_id = $tag->term_id;
	$cat_meta = get_option( "category_$t_id");
	// Menus
    $all_menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );

    ?>
    <tr class="form-field">
	<th scope="row" valign="top"><label><?php _e('Category Posts Layout', 'framework'); ?></label></th>
	<td>
	<label for="cat_layout">
		<select name="Cat_meta[layout]" id="cat_layout">
		    <?php
			if (!isset($cat_meta['layout'])) { $cat_meta['layout'] = ''; }
		    ?>
			<option value=""><?php _e('Posts Layout...', 'framework'); ?></option>
			<option value="def" <?php selected($cat_meta['layout'], 'def'); ?>><?php _e('Default Layout', 'framework'); ?></option>
			<option value="blog" <?php selected($cat_meta['layout'], 'blog'); ?>><?php _e('Blog Layout', 'framework'); ?></option>
		</select>
	    <br /><span class="description"><?php _e('select category layout', 'framework'); ?></span>
	</label>
	</td>
	</tr>
	<tr class="form-field">
	<th scope="row" valign="top"><label><?php _e('Category blog Layout style', 'framework'); ?></label></th>
	<td>
	<label for="cat_layout">
		<select name="Cat_meta[layout_style]" id="cat_layout_style">
		    <?php
			if (!isset($cat_meta['layout_style'])) { $cat_meta['layout_style'] = ''; }
		    ?>
			<option value=""><?php _e('Blog Posts Layout style...', 'framework'); ?></option>
			<option value="" <?php selected($cat_meta['layout_style'], ''); ?>><?php _e('Default Style', 'framework'); ?></option>
			<option value="large" <?php selected($cat_meta['layout_style'], 'large'); ?>><?php _e('Big Style', 'framework'); ?></option>
		</select>
	    <br /><span class="description"><?php _e('select category blog Layout style if you choose blog in category posts layout', 'framework'); ?></span>
	</label>
	</td>
	</tr>
	<tr class="form-field">
	<th scope="row" valign="top"><label><?php _e('Color', 'framework'); ?></label></th>
	<td>
	<input id="color" class="mom_color_picker" name="Cat_meta[color]" type="text" value="<?php echo $cat_meta['color'] ? $cat_meta['color'] : ''; ?>"/><br />
	<div id="colorpicker"></div>
	</td>
	</tr>

	<tr class="form-field">
	<th scope="row" valign="top"><label><?php _e('Background', 'framework'); ?></label></th>
	<td>
		<input class="mom_color_picker" name="Cat_meta[bg][color]" type="text" value="<?php echo isset($cat_meta['bg']['color']) ? $cat_meta['bg']['color'] : ''; ?>"/><br />
	    <div>
	    <input id="upload_image" type="text" size="36" name="Cat_meta[bg][image]" placeholder="Background Image" value="<?php echo isset($cat_meta['bg']['image']) ? $cat_meta['bg']['image'] : ''; ?>" style="width: auto !important;"/>
	    <input id="upload_image_button" class="button" type="button" value="Upload Image" style="width: auto !important;"/>
		</div>
		<select name="Cat_meta[bg][repeat]">
		    <?php
			$repeat = isset($cat_meta['bg']['repeat']) ? $cat_meta['bg']['repeat'] :  '';
		    ?>
<option value="" class="placeholder"><?php _e('Backgorund Repeat ...', 'theme'); ?></option>
<option value="no-repeat" <?php selected('no-repeat', $repeat); ?>><?php _e('No Repeat', 'theme'); ?></option>
<option value="repeat" <?php selected('repeat', $repeat); ?>><?php _e('Repeat All', 'theme'); ?></option>
<option value="repeat-x" <?php selected('repeat-x', $repeat); ?>><?php _e('Repeat Horizontally', 'theme'); ?></option>
<option value="repeat-y" <?php selected('repeat-y', $repeat); ?>><?php _e('Repeat Vertically', 'theme'); ?></option>
<option value="inherit" <?php selected('inherit', $repeat); ?>><?php _e('Inherit', 'theme'); ?></option>
		</select>
		<select name="Cat_meta[bg][size]">
		    <?php
			$size = isset($cat_meta['bg']['size']) ? $cat_meta['bg']['size'] :  '';
		    ?>
			<option value="" class="placeholder"><?php _e('Backgorund Size ...', 'theme'); ?></option>
			<option value="inherit" <?php selected('inherit', $size); ?>><?php _e('inherit', 'theme'); ?></option>
			<option value="cover" <?php selected('cover', $size); ?>><?php _e('cover', 'theme'); ?></option>
			<option value="contain" <?php selected('contain', $size); ?>><?php _e('contain', 'theme'); ?></option>
		</select>
		<select name="Cat_meta[bg][attachment]">
		    <?php
			$attachment = isset($cat_meta['bg']['attachment']) ? $cat_meta['bg']['attachment'] :  '';
		    ?>
			<option value="" class="placeholder"><?php _e('Backgorund attachment ...', 'theme'); ?></option>
			<option value="inherit" <?php selected('inherit', $attachment); ?>><?php _e('inherit', 'theme'); ?></option>
			<option value="fixed" <?php selected('fixed', $attachment); ?>><?php _e('fixed', 'theme'); ?></option>
			<option value="scroll" <?php selected('scroll', $attachment); ?>><?php _e('scroll', 'theme'); ?></option>
		</select>

		<select name="Cat_meta[bg][position]">
		    <?php
			$position = isset($cat_meta['bg']['position']) ? $cat_meta['bg']['position'] :  '';
		    ?>
			<option value="" class="placeholder"><?php _e('Backgorund position ...', 'theme'); ?></option>
<option value="left top" <?php selected('left top', $position); ?>><?php _e('left top', 'theme'); ?></option>
<option value="left center" <?php selected('left center', $position); ?>><?php _e('left center', 'theme'); ?></option>
<option value="Left Bottom" <?php selected('Left Bottom', $position); ?>><?php _e('Left Bottom', 'theme'); ?></option>
<option value="Center Top" <?php selected('Center Top', $position); ?>><?php _e('Center Top', 'theme'); ?></option>
<option value="center center" <?php selected('center center', $position); ?>><?php _e('center center', 'theme'); ?></option>
<option value="Center Bottom" <?php selected('Center Bottom', $position); ?>><?php _e('Center Bottom', 'theme'); ?></option>
<option value="right top" <?php selected('right top', $position); ?>><?php _e('right top', 'theme'); ?></option>
<option value="Right center" <?php selected('Right center', $position); ?>><?php _e('Right center', 'theme'); ?></option>
<option value="right bottom" <?php selected('right bottom', $position); ?>><?php _e('right bottom', 'theme'); ?></option>
		</select>

	    <br /><span class="description"><?php _e('Category Background', 'framework'); ?></span>
	</td>
	</tr>

	<tr class="form-field">
	<th scope="row" valign="top"><label><?php _e('Custom Main Sidebar', 'framework'); ?></label></th>
	<td>
	<label for="cat_sidebar">
		<?php
			$sidebars = $GLOBALS['wp_registered_sidebars'];
		?>
		<select name="Cat_meta[sidebar]" id="cat_sidebar">
			<option value=""><?php _e('Select Sidebar ...', 'framework'); ?></option>
			<?php foreach ($sidebars as $sidebar) {
				echo '<option value="'.$sidebar['id'].'"'. selected($cat_meta['sidebar'], $sidebar['id']).'>'.$sidebar['name'].'</option>';
			} ?>
		</select>
	    <br /><span class="description"><?php _e('select category main sidebar', 'framework'); ?></span>
	</label>
	</td>
	</tr>

	<tr class="form-field">
	<th scope="row" valign="top"><label><?php _e('Custom Secondary Sidebar', 'framework'); ?></label></th>
	<td>
	<label for="cat_ssidebar">
		<?php
			$ssidebars = $GLOBALS['wp_registered_sidebars'];
		?>
		<select name="Cat_meta[ssidebar]" id="cat_ssidebar">
			<option value=""><?php _e('Select Sidebar ...', 'framework'); ?></option>
			<?php foreach ($ssidebars as $ssidebar) {
				echo '<option value="'.$ssidebar['id'].'"'. selected($cat_meta['ssidebar'], $ssidebar['id']).'>'.$ssidebar['name'].'</option>';
			} ?>
		</select>
	    <br /><span class="description"><?php _e('select category secondary sidebar', 'framework'); ?></span>
	</label>
	</td>
	</tr>

	<tr class="form-field">
	<th scope="row" valign="top"><label><?php _e('Icon', 'framework'); ?></label></th>
	<td>
		<div class="mom_icons_selector">
		<a href="#" class="mom_select_icon button"><?php _e('Select Icon', 'framework'); ?></a><span class="or">or</span><a href="#" class="mom_upload_icon button simptip-position-top simptip-movable simptip-multiline" data-tooltip="<?php _e('Best Icon size is : 24px', 'framework'); ?>"><?php _e('Upload custom Icon', 'framework'); ?></a>
		<span class="mom_icon_prev"><i></i><a href="#" class="remove_icon enotype-icon-cross2" title="Remove Icon"></a></span>
		<input name="Cat_meta[icon]" class="mom_icon_holder" type="hidden" value="<?php echo isset($cat_meta['icon']) ? $cat_meta['icon'] : ''; ?>"/><br />
		<br /><span class="description"><?php _e('select category icon', 'framework'); ?></span>
		</div>
	</td>
	</tr>
	<tr class="form-field">
	<th scope="row" valign="top"><label><?php _e('Category Slider', 'framework'); ?></label></th>
	<td>
	<label for="cat_slider">
		<select name="Cat_meta[slider]" id="cat_slider">
		    <?php
			if (!isset($cat_meta['slider'])) { $cat_meta['slider'] = ''; }
		    ?>
			<option value=""><?php _e('None', 'framework'); ?></option>
			<option value="1" <?php selected($cat_meta['slider'], '1'); ?>><?php _e('Enable', 'framework'); ?></option>
			<option value="0" <?php selected($cat_meta['slider'], '0'); ?>><?php _e('Disable', 'framework'); ?></option>
		</select>
	    <br /><span class="description"><?php _e('enable or disable category slider, none mean this option will depend on theme options -> category settings', 'framework'); ?></span>
	</label>
	</td>
	</tr>
	<tr class="form-field">
	<th scope="row" valign="top"><label><?php _e('Custom Logo', 'framework'); ?></label></th>
	<td>
	<label for="category_logo">
	    <input id="category_logo" class="custom_img_logo" type="text" size="36" name="Cat_meta[custom_logo]" value="<?php echo isset($cat_meta['custom_logo']) ? $cat_meta['custom_logo'] : ''; ?>" style="width: auto !important;"/>
	    <input id="upload_cat_logo" class="button upload_image_button" type="button" value="Upload Image" data-x="logo" style="width: auto !important;"/>
	    <br /><span class="description"><?php _e('Enter a URL or upload an image', 'framework'); ?></span>
	</label>
	</td>
	</tr>
      <tr class="form-field">
	<th scope="row" valign="top"><label><?php _e('Custom Header banner', 'framework'); ?></label></th>
	<td>
	<label for="custom_banner">
		<?php
			// Get ads
			$ads = get_posts('post_type=ads&posts_per_page=-1');
	  ?>
		<select name="Cat_meta[custom_banner]" id="custom_banner">
			<option value=""><?php _e('Select Banner ...', 'framework'); ?></option>
			<?php foreach ($ads as $ad) {
				echo '<option value="'.$ad->ID.'"'. selected($cat_meta['custom_banner'],$ad->ID).'>'.esc_attr($ad->post_title).'</option>';
			} ?>
		</select>
	</label>
	</td>
	</tr>
	      <tr class="form-field">
	<th scope="row" valign="top"><label><?php _e('Custom navigation menu', 'framework'); ?></label></th>
	<td>
	<label for="custom_menu">
		<select name="Cat_meta[custom_menu]" id="custom_menu">
			<option value=""><?php _e('Select Banner ...', 'framework'); ?></option>
			<?php foreach ($all_menus as $mom_menu) {
				echo '<option value="'.$mom_menu->term_id.'"'. selected($cat_meta['custom_menu'],$mom_menu->term_id).'>'.esc_attr($mom_menu->name).'</option>';
			} ?>
		</select>
	</label>
	</td>
	</tr>
    <?php
    }
add_action ( 'edited_category', 'save_mom_category_style');
    function save_mom_category_style( $term_id ) {
	if ( isset( $_POST['Cat_meta'] ) ) {
	$t_id = $term_id;
	$cat_meta = get_option( "category_$t_id");
	$cat_keys = array_keys($_POST['Cat_meta']);
	foreach ($cat_keys as $key){
	if (isset($_POST['Cat_meta'][$key])){
	$cat_meta[$key] = $_POST['Cat_meta'][$key];
	}
    }
update_option( "category_$t_id", $cat_meta );
}
}

add_action ( 'edit_category_form_fields', 'add_styles_scripts_color');
add_action ( 'category_add_form_fields', 'add_styles_scripts_color');
function add_styles_scripts_color(){
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );
    wp_enqueue_script( 'mom-cats-settings', get_template_directory_uri() . '/framework/helpers/js/cats.js' );
    wp_enqueue_media();
    }
// ajax Action
add_action( 'wp_ajax_mom_loadIcon', 'mom_icon_container' );

/* ==========================================================================
 *                Timeline
   ========================================================================== */
add_action( 'wp_ajax_mom_timeline', 'mom_timeline_posts' );
add_action( 'wp_ajax_nopriv_mom_timeline', 'mom_timeline_posts');

function mom_posts_timeline($count = 10, $author = '', $excat = '', $cats = '', $order = '') {
	if (is_singular()) {
	global $post;
	$display = get_post_meta($post->ID, 'mom_timeline_display', true);
	} else {
	$display = '';
	}
?>

<div class="mom-blog-timeline clearfix">
<?php mom_timeline_posts($count, $author, $excat, $cats , $order); ?>
<a href="#" class="blog-timeline-more" data-offset="<?php echo $count; ?>" data-count="<?php echo $count; ?>" data-author="<?php echo $author; ?>" data-excat="<?php echo $excat; ?>" data-display="<?php echo $display; ?>" data-cats="<?php echo $cats; ?>" data-order="<?php echo $order; ?>"><?php _e('Show More post', 'framework'); ?><span class="enotype-icon-arrow-down2"></span></a>
</div> <!--.mom-timeline-->
<?php }

function mom_timeline_posts ($count = 10, $author = '', $excat = '', $cats = '', $order = '' ) {
$post_meta_hp = mom_option('post_meta_hp');
if($post_meta_hp == 1) {
		$post_head = mom_option('post_head');
		$post_head_author = mom_option('post_head_author');
		$post_head_date = mom_option('post_head_date');
		$post_head_cat = mom_option('post_head_cat');
		$post_head_commetns= mom_option('post_head_commetns');
		$post_head_views = mom_option('post_head_views');
		} else {
		$post_head = 1;
		$post_head_author = 1;
		$post_head_date = 1;
		$post_head_cat = 1;
		$post_head_commetns= 1;
		$post_head_views = 1;
		}

	if (is_singular()) {
	global $post;
	$display = get_post_meta($post->ID, 'mom_timeline_display', true);
	} else {
	$display = '';
	}
?>
<?php

$last_month = 0;
	$offset = isset($_POST['offset']) ? $_POST['offset'] : '';
	if (isset($_POST['count']) ) {
	  $count = $_POST['count'];
	}
	if (isset($_POST['author']) ) {
	  $author = $_POST['author'];
	}
	if (isset($_POST['excat']) ) {
	  $excat = $_POST['excat'];
	}
	if (isset($_POST['display']) ) {
	  $display = $_POST['display'];
	}

	if (isset($_POST['cats']) ) {
	  $cats = $_POST['cats'];
	}
	if (isset($_POST['order']) ) {
	  $order = $_POST['order'];
	}
if ($display == 'cat') {
$query = new WP_Query( array ('post_type' => 'post', "ignore_sticky_posts" => 1, 'cache_results' => false, 'no_found_rows' => true, 'post_status'=>'publish', 'offset' => $offset, 'posts_per_page' => $count, 'author' => $author, 'cat' => $cats, 'orderby' => $order) );
} else {
$query = new WP_Query( array ('post_type' => 'post', "ignore_sticky_posts" => 1, 'cache_results' => false, 'no_found_rows' => true, 'post_status'=>'publish', 'offset' => $offset, 'posts_per_page' => $count, 'author' => $author, 'cat' => $excat, 'orderby' => $order) );
}
update_post_thumbnail_cache( $query );
if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();

$month = get_the_time('n');
$year = get_the_time('Y');
$p_month = get_the_time('F');
global $post;

$single = $post;
if ($month != $last_month)
{
  echo "</ul><span class='blog-timeline-date'>$p_month, $year</span><ul class='tl-posts'>";
  $last_month = $month;
}
?>
	      <li class="nb5">
		    <div <?php post_class('first-item',$single->ID); ?> role="article" itemscope="" itemtype="http://schema.org/Article">
			<h2 itemprop="headline"><a itemprop="url" href="<?php echo get_permalink($single->ID); ?>"><?php echo get_the_title($single->ID); ?></a></h2>
			<?php if( mom_post_image('','',$single->ID) != false ) { ?>
			<figure class="post-thumbnail"><a href="<?php echo get_permalink($single->ID); ?>">
			<?php mom_post_image_full('nb5-thumb', $single->ID ); ?>
 			<span class="post-format-icon"></span>
			</a></figure>
			<?php } ?>
			<?php if( mom_post_image() != false ) {
            	$mom_class = ' class="fix-right-content"';
            } else {
                $mom_class = '';
            }
            ?>
            <div<?php echo $mom_class; ?>>
			<div class="entry-content">
			<p>
			<?php

			$excerpt = get_the_excerpt();
			if($excerpt == ''){
			$excerpt = get_the_content();
			}
			echo wp_html_excerpt(strip_shortcodes($excerpt), 100);
			?> ...
			</p>
			</div>
			<?php if($post_head != 0) { ?>
			<div class="entry-meta">
			<?php if($post_head_date != 0) { ?>
			<time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="datePublished" content="<?php the_time('c'); ?>"><i class="momizat-icon-calendar"></i><?php echo mysql2date(mom_option('date_format'), $single->post_date); ?></time>
			<?php } ?>
			<?php if($post_head_commetns != 0) { ?>
			<div class="comments-link">
			<i class="momizat-icon-bubbles4"></i><a href="<?php echo get_permalink($single->ID); ?>">
			    	<?php
					$num_comments = get_comments_number($single->ID); // get_comments_number returns only a numeric value
						if ( comments_open() ) {
							if ( $num_comments == 0 ) {
								$comments = __('0 Comments', 'framework');
							} elseif ( $num_comments > 1 ) {
								$comments = $num_comments . __(' Comments', 'framework');
							} else {
								$comments = __('1 Comment', 'framework');
							}
							$write_comments = '<a class="comment_number" href="' . get_comments_link($single->ID) .'">'. $comments.'</a>';
						} else {
							//$write_comments =  __('Comments off', 'framework');
							$write_comments = '';
						}
				?>
								<?php echo $write_comments; ?>

			</a>
			</div>
			<?php } ?>
			</div>
			<?php } ?>
            </div>
		    </div>
		</li>

<?php
endwhile; ?>
</ul>
<?php else:
endif;
wp_reset_postdata();
?>
<?php if (isset($_POST['offset'])) { exit(); }
}
/* ==========================================================================
 *                Content ads
   ========================================================================== */
add_action('mom_before_content', 'mom_content_ads');
function mom_content_ads() {
  $posh = mom_option('content_ads_position');
  $rs = mom_option('content_right_banner_id');
  $ls = mom_option('content_left_banner_id');
  $pos = '';
  if (is_singular()) {
	global $post;
    $poshs = get_post_meta($post->ID, 'mom_content_ads_fixed', true);
    if ($poshs != '') {
      $posh = $poshs;
    }

	$prs = get_post_meta($post->ID, 'mom_content_right_banner', true);
	$pls = get_post_meta($post->ID, 'mom_content_left_banner', true);

	if ($prs != '') {
	  $rs = $prs;
	}
	if ($pls != '') {
	  $ls = $pls;
	}
  }


  if ($posh == 1) {
    $pos = 'mca-fixed';
  }
?>

<?php if ($rs != '') { ?>
  <div class="mom_contet_ads mc-ad-right <?php echo $pos; ?>">
      <?php echo do_shortcode('[ad id="'.$rs.'"]'); ?>
  </div>
<?php } ?>
<?php if ($ls != '') { ?>
  <div class="mom_contet_ads mc-ad-left <?php echo $pos; ?>">
      <?php echo do_shortcode('[ad id="'.$ls.'"]'); ?>
  </div>
<?php } ?>
<?php }
/* ==========================================================================
 *                Category page content
   ========================================================================== */
function mom_category_content ($cols = 2) {
  $cols = 'grid-col-'.$cols;
	$cat_data = get_option("category_".get_query_var('cat'));
	$cat_layout = isset($cat_data['layout']) ? $cat_data['layout'] : '' ;
	$cat_layout_style = isset($cat_data['layout_style']) ? $cat_data['layout_style'] : '' ;
	$dateformat = mom_option('date_format');

	$ad_id = mom_option('cat_ad_id');
	$ad_count = mom_option('cat_ad_count');
	$ad_repeat = mom_option('cat_ad_repeat');

	$post_head = '';
	$post_meta_hp = mom_option('post_meta_hp');
		if($post_meta_hp == 1) {
		$post_head = mom_option('post_head');
		$post_head_author = mom_option('post_head_author');
		$post_head_date = mom_option('post_head_date');
		$post_head_cat = mom_option('post_head_cat');
		$post_head_commetns= mom_option('post_head_commetns');
		$post_head_views = mom_option('post_head_views');
		} else {
		$post_head = 1;
		$post_head_author = 1;
		$post_head_date = 1;
		$post_head_cat = 1;
		$post_head_commetns= 1;
		$post_head_views = 1;
		}

                          		if(mom_option('cat_posts_layout') == 'blog' || $cat_layout == 'blog') {
	                        		$style = '';
	                        		if(mom_option('cat_posts_layout_style') == 'large' || $cat_layout_style == 'large') {
		                        		$style = 'large';
	                        		} else {
		                        		$style = '';
	                        		}
	                        		$nexcerpt = '';
	                        		$class = '';
                        		?>
                               		<div class="blog_posts">
                               		<?php
                               			$post_count = 1;
										if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
							   			<?php

							   				mom_blog_post($style, $nexcerpt, $class);
											if ($ad_id != '') {
													if ($ad_repeat == 1) {
															if ($post_count%$ad_count == 0) {
																echo do_shortcode('[ad id="'.$ad_id.'"]');
															}
													} else {
															if ($post_count == $ad_count) {
																echo do_shortcode('[ad id="'.$ad_id.'"]');
															}
													}
											}
											$post_count ++;

							   			?>
                               		<?php
                                    endwhile;
                                    else:  ?>
                                    <!-- Else in here -->
                                    <?php endif; ?>
                                    <?php mom_pagination(); ?>
                               		</div>
                               		<?php } else { ?>
                            <div class="site-content page-wrap">
	                                <?php if(mom_option('cat_swi')) { ?>
	                                <div class="f-tabbed-head">
	                                    <ul class="f-tabbed-sort cat-sort">
	                                        <li class="grid active"><a href="#"><span class="brankic-icon-grid"></span><?php _e(' Grid', 'framework') ?></a></li>
	                                        <li class="list"><a href="#"><span class="brankic-icon-list2"></span><?php _e(' List', 'framework') ?></a></li>
	                                    </ul>
	                                </div>
	                                <?php } ?>

	                                <?php
	                                $catswi = mom_option('cat_swi_def');
	                                $swiclass = 'cat-grid '.$cols;
	                                if($catswi == 'list') {
		                                $swiclass = 'cat-list';
	                                }
	                                $srclass = '';
	                                if(mom_option('cat_swi') != true) {
		                                $srclass = ' no-head';
	                                }
	                                ?>
	                                <div class="cat-body<?php echo $srclass; ?>">
	                                    <ul class="nb1 <?php echo $swiclass; ?> clearfix">
	                                        <?php $post_count = 1; if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	                                        <li <?php post_class(); ?> itemscope="" itemtype="http://schema.org/Article">
	                                            <h2 itemprop="headline" class="cat-list-title"><a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	                                            <?php if($post_head != 0) { ?>
	                                            <div class="cat-list-meta entry-meta">
	                                                <?php if($post_head_author != 0) { ?>
	                                                <div class="author-link">
	                                                <?php _e('Posted by', 'framework') ?> <a itemprop="author" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) )?>" rel="author"><?php echo get_the_author() ?></a>
	                                                </div>
	                                                <?php } ?>
	                                                <?php if($post_head_date != 0) { ?>
	                                                <span>|</span><time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="datePublished" content="<?php the_time('c'); ?>"><?php _e('Date: ', 'framework') ?><?php the_time($dateformat); ?></time>
	                                                <?php } ?>
	                                                <?php if($post_head_commetns != 0) { ?>
	                                                <div class="comments-link">
	                                                <span>|</span><a href="<?php the_permalink(); ?>"> <?php comments_number(__( '0 comments', 'framework' ), __( '(1) Comment', 'framework' ),__( '(%) Comments', 'framework' )); ?></a>
	                                                </div>
	                                                <?php } ?>
	                                            </div>
	                                            <?php } ?>
	                                            <?php if( mom_post_image() != false ) { ?>
	                                            <figure class="post-thumbnail"><a href="<?php the_permalink(); ?>">
	                                            	<?php mom_post_image_full('nb1-thumb'); ?>
	                                                <span class="post-format-icon"></span>
	                                            </a></figure>
	                                            <?php } ?>
	                                            <h2 itemprop="headline" class="cat-grid-title"><a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	                                            <div class="entry-content cat-grid-meta">
	                                                <p>
	                                                    <?php global $post;
	                                                    $excerpt = $post->post_excerpt;
	                                                    if($excerpt==''){
	                                                    $excerpt = get_the_content('');
	                                                    }
	                                                    echo wp_html_excerpt(strip_shortcodes($excerpt),105);
	                                                    ?> ...
	                                                </p>
	                                            </div>
	                                            <?php
	                                            if( mom_post_image() != false ) {
		                                        	$mom_class = ' class="fix-right-content"';
		                                        } else {
			                                        $mom_class = '';
		                                        }
	                                            ?>

	                                            <div<?php echo $mom_class; ?>>
		                                            <div class="entry-content cat-list-meta">
		                                                <p>
		                                                    <?php global $post;
		                                                    $excerpt = $post->post_excerpt;
		                                                    if($excerpt==''){
		                                                    $excerpt = get_the_content('');
		                                                    }
		                                                    echo wp_html_excerpt(strip_shortcodes($excerpt),200);
		                                                    ?> ...
		                                                </p>
		                                            </div>
		                                            <?php if($post_head != 0) { ?>
		                                            <div class="cat-grid-meta entry-meta">
		                                            	<?php if($post_head_date != 0) { ?>
		                                                <time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="datePublished" content="<?php the_time('c'); ?>"><?php the_time($dateformat); ?> </time>
		                                                <?php } ?>
		                                                <?php if($post_head_author != 0) { ?>
		                                                <div class="author-link">
		                                                    |<?php _e(' by ', 'framework') ?><a itemprop="author" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) )?>" rel="author"><?php echo get_the_author() ?></a>
		                                                </div>
		                                                <?php } ?>
		                                                <?php if($post_head_commetns != 0) { ?>
		                                                <div class="comments-link">
		                                                    |<a href="<?php the_permalink(); ?>"> <?php comments_number(__( '0 comments', 'framework' ), __( '(1) Comment', 'framework' ),__( '(%) Comments', 'framework' )); ?></a>
		                                                </div>
		                                                <?php } ?>
		                                            </div>
		                                            <?php } ?>
		                                            <?php if(is_rtl()) { ?>
		                                            <a class="read-more" href="<?php the_permalink(); ?>"><?php _e('Read more', 'framework'); ?> <i class="fa-icon-angle-double-left"></i></a>
		                                            <?php } else { ?>
		                                            <a class="read-more" href="<?php the_permalink(); ?>"><?php _e('Read more', 'framework'); ?> <i class="fa-icon-angle-double-right"></i></a>
													<?php } ?>
	                                            </div>
	                                        </li>
	                                        <?php
				if ($ad_id != '') {
						if ($ad_repeat == 1) {
								if ($post_count%$ad_count == 0) {
									echo '<li>';
									echo do_shortcode('[ad id="'.$ad_id.'"]');
									echo '</li>';
								}
						} else {
								if ($post_count == $ad_count) {
									echo '<li>';
									echo do_shortcode('[ad id="'.$ad_id.'"]');
									echo '</li>';
								}
						}
				}
				$post_count ++;

	                                        endwhile;
	                                        else:  ?>
	                                        <!-- Else in here -->
	                                        <?php endif; ?>
	                                    </ul>

	                                    <?php mom_pagination(); ?>
	                                </div>
                            </div>
                            <?php }

}

/* ==========================================================================
 *                Allow SVG in media uploader
   ========================================================================== */
function mom_custom_mime_types( $mimes ){
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'mom_custom_mime_types' );


// display featured post thumbnails in WordPress feeds
function mom_post_thumbnails_in_feeds( $content ) {
    global $post;
    if( has_post_thumbnail( $post->ID ) ) {
        $content = '<p>' . get_the_post_thumbnail( $post->ID, 'medium' ) . '</p>' . $content;
    }
    return $content;
}
add_filter( 'the_excerpt_rss', 'mom_post_thumbnails_in_feeds' );
add_filter( 'the_content_feed', 'mom_post_thumbnails_in_feeds' );

/* ==========================================================================
                 	Whats app button
========================================================================== */
function mom_wa_btn_shortcode($atts, $content) {
    extract(shortcode_atts(array(
		"title" => get_the_title(),
		"url" => get_permalink(),
    ), $atts));

	$btn = '<!-- WhatsApp Share Button for WordPress: http://peadig.com/wordpress-plugins/whatsapp-share-button/ --><a href="whatsapp://send?text='.$title.' - '.$url.'" class="wabtn">'.balancetags($content).'</a>';
	return $btn;
}
add_shortcode('mom_whatsapp', 'mom_wa_btn_shortcode');
/* ==========================================================================
 *                Wordpress caption
   ========================================================================== */
add_filter( 'img_caption_shortcode', 'mom_cleaner_caption', 10, 3 );

function mom_cleaner_caption( $output, $attr, $content ) {

	/* We're not worried abut captions in feeds, so just return the output here. */
	if ( is_feed() )
		return $output;

	/* Set up the default arguments. */
	$defaults = array(
		'id' => '',
		'align' => 'alignnone',
		'width' => '',
		'caption' => ''
	);

	/* Merge the defaults with user input. */
	$attr = shortcode_atts( $defaults, $attr );

	/* If the width is less than 1 or there is no caption, return the content wrapped between the [caption]< tags. */
	if ( 1 > $attr['width'] || empty( $attr['caption'] ) )
		return $content;

	/* Set up the attributes for the caption <div>. */
	$attributes = ( !empty( $attr['id'] ) ? ' id="' . esc_attr( $attr['id'] ) . '"' : '' );
	$attributes .= ' class="wp-caption ' . esc_attr( $attr['align'] ) . '"';
	$attributes .= ' style="width: ' . esc_attr( $attr['width'] ) . 'px"';

	/* Open the caption <div>. */
	$output = '<figure' . $attributes .'>';

	/* Allow shortcodes for the content the caption was created for. */
	$output .= do_shortcode( $content );

	/* Append the caption text. */
	$output .= '<figcaption class="wp-caption-text">' . $attr['caption'] . '</figcaption>';

	/* Close the caption </div>. */
	$output .= '</figure>';

	/* Return the formatted, clean caption. */
	return $output;
}

function mom_get_pageLayout() {
		if ( is_singular()) {
	$layout = get_post_meta(get_queried_object_id(), 'mom_page_layout', TRUE);
	if (is_single()) { if ($layout == '') { $layout = mom_option('post_page_layout'); } }


if (is_page()) {
	if ($layout == '') {
    	$layout = mom_option('page_layout');
	}
}
if ($layout == '') { $layout = mom_option('main_layout'); }

	if(function_exists('is_bbpress') && is_bbpress()) {
	if ($layout == '') { $layout = mom_option('bbpress_layout');}
	if(function_exists('is_buddypress') && is_buddypress()) {
	if (get_post_meta(get_queried_object_id(), 'mom_page_layout', true) == '') { $layout = mom_option('buddypress_layout');}
	}

      } elseif(function_exists('is_buddypress') && is_buddypress()) {
	if ($layout == '') { $layout = mom_option('buddypress_layout');}
      } else {
	if ($layout == '') { $layout = mom_option('main_layout');}
      }

	} elseif (function_exists('is_bbpress') && is_bbpress()) {
	$layout = mom_option('bbpress_layout');
	if ($layout == '') {
	    $layout = mom_option('main_layout');
	}
	} elseif (function_exists('is_buddypress') && is_buddypress()) {
	$layout = mom_option('buddypress_layout');
	if ($layout == '') {
	    $layout = mom_option('main_layout');
	}
	} elseif (is_archive()) {
	$layout = mom_option('category_layout');
	if ($layout == '') {
	    $layout = mom_option('main_layout');
	}
	} else {
	$layout = mom_option('main_layout');
	}
	$site_width = mom_option('site_width');
if(function_exists('is_woocommerce') && is_woocommerce()) {
    $woo_page_id = '';
if (is_shop()) {
    $woo_page_id = get_option('woocommerce_shop_page_id');
} elseif (is_cart()) {
    $woo_page_id = get_option('woocommerce_cart_page_id');
} elseif (is_checkout()) {
    $woo_page_id = get_option('woocommerce_checkout_page_id');
} elseif (is_account_page()) {
    $woo_page_id = get_option('woocommerce_myaccount_page_id');
} else {
    $woo_page_id = get_option('woocommerce_shop_page_id');
}
$layout = get_post_meta($woo_page_id, 'mom_page_layout', true);
if ($layout == '') {
  $layout = mom_option('main_layout');
}

return $layout;

}
} //end layout function


function mom_remove_number_from_string($str) {
	$word = preg_replace('/[0-9]+/', '', $str);

	return $word;
}
