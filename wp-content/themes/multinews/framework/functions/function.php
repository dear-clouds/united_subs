<?php
//js Files
add_action( 'wp_enqueue_scripts', 'mom_scripts_styles');
function mom_scripts_styles() {
	global $wp_styles, $post;
		wp_register_script('googlemaps', ('http://maps.google.com/maps/api/js?sensor=false'), false, null, false);

	wp_enqueue_script('jquery', false, array(), false, true);
	// General scripts
	wp_register_script('modernizr', MOM_JS . '/modernizr-2.6.2.min.js', 'jquery');
	wp_register_script( 'nice-scroll', get_template_directory_uri() . '/js/jquery.nicescroll.min.js', array('jquery'), '1.0', true );
	wp_register_script('jflicker', MOM_JS . '/jflickrfeed.min.js', 'jquery', '', true);
	wp_register_script('backstretch', MOM_JS . '/jquery.backstretch.min.js', 'jquery', '', true);
	wp_register_script('handlebars', MOM_JS . '/handlebars-v1.3.0.js', 'jquery', '', true);
	wp_register_script('typehead', MOM_JS . '/typeahead.js', 'jquery', '', true);
	wp_register_script('nticker', MOM_JS . '/jquery.newsTicker.min.js', 'jquery', '', true);
	wp_register_script('nicescroll', MOM_JS . '/nicescroll.js', 'jquery', '', true);
	
	wp_register_script( 'Momizat-main-js', get_template_directory_uri() . '/js/main.js', array('jquery'), '1.0', true );
	wp_localize_script( 'Momizat-main-js', 'momAjaxL', array(
        'url' => admin_url( 'admin-ajax.php' ),
        'nonce' => wp_create_nonce( 'ajax-nonce' ),
        'success' => __('Check your email to complete subscription','framework'),
        'error' => __('Already subscribed', 'framework'),
        'error2' => __('Email invalid', 'framework'),
        'nomore' => __('No More Posts', 'framework'),
		'homeUrl' => home_url(),
		'viewAll' => __('View All Results', 'framework'),
		'noResults' => __('Sorry, no posts matched your criteria', 'framework'),
		'postid' => $post->ID
        )
    );
	wp_enqueue_script( 'Momizat-main-js');

	if (mom_option('nicescroll') == 1) {
		wp_enqueue_script('nice-scroll');
	}
	if ( ! is_page_template('magazine.php') ) {
	wp_enqueue_script( 'plugins-js', get_template_directory_uri() . '/js/plugins.min.js', array('jquery'), '1.0', true ); //minify in main.js
	}

	
	if ( ! is_page_template('magazine.php') ) {
	if(mom_option('bg_slider') == 1) {
		wp_enqueue_script('backstretch');
		add_action('wp_head', 'mom_bg_slider');
	}

	if(mom_option('bn_type') == 'up') {
		wp_enqueue_script('nticker');
	}
	}
	
	wp_register_script('cycle', MOM_JS . '/cycle.min.js', 'jquery', '', true);
	 
//Our stylesheets 
	wp_enqueue_style( 'multinews-style', get_stylesheet_uri() );
	wp_enqueue_style( 'main', get_template_directory_uri() . '/css/main.css' );
	wp_enqueue_style( 'plugins', get_template_directory_uri() . '/css/plugins.css' );
	if(mom_option('main_skin') == 'dark') { wp_enqueue_style( 'dark-style', get_template_directory_uri() . '/css/dark.css' ); }

	do_action('mom_custom_css');
	if(mom_option('enable_responsive') != false) { wp_enqueue_style( 'responsive', get_template_directory_uri() . '/css/media.css' ); }		
	if ( is_page_template('magazine.php')) {
            wp_enqueue_script( 'bookblock', get_template_directory_uri() . '/js/jquery.bookblock.min.js', array('jquery'), '1.0', false );
			wp_enqueue_style( 'bookblocks', get_template_directory_uri() . '/css/bookblock.css' );
	}
	
	if ( is_page_template('weather.php')) {
		wp_enqueue_script('handlebars');
		wp_enqueue_script('typehead');
	}
	
	if ( is_category() ){
		wp_enqueue_style( 'bookblocks', get_template_directory_uri() . '/css/catbookblock.css' );
	} 

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
	} 
	
}

add_action('wp_head', 'mom_header_scripts');
function mom_header_scripts() {
	if ( ! is_page_template('magazine.php') ) {
		echo mom_option('header_script');
	}
}

add_action( 'admin_enqueue_scripts', 'mom_admin_scripts' );
function mom_admin_scripts( $hook_suffix ) {
    // first check that $hook_suffix is appropriate for your admin page
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_style('shortcodes', MOM_URI.'/framework/shortcodes/css/tinymce.css');
}

// using dashicons
add_action( 'wp_enqueue_scripts', 'mom_load_dashicons' );
function mom_load_dashicons() {
	wp_enqueue_style( 'dashicons' );
}
/*  ---------------------------------------------------------------------------- */
// Momizat Get Images
function mom_post_image($size = 'thumbnail', $id='', $pid = '', $di = false){
		global $post;
		$image = '';

    	
		//get the post thumbnail
		if ($pid == '') {
			$pid = $post->ID;
		}


		if ($id != '') {
			$image_id = $id;
		} else {
			$image_id = get_post_thumbnail_id($pid);
		}
		$image = wp_get_attachment_image_src($image_id,  
		$size);

		$image = $image[0];
		
		if ($image) return $image;
			
		
		//if the post is video post and haven't a feutre image
		global $posts_st;
		$extra = get_post_meta($pid, $posts_st->get_the_id(), TRUE);

		  $format = get_post_format($pid);
		  if (isset($extra['video_type'])) { $vtype = $extra['video_type']; }
		  if (isset($extra['video_id'])) { $vId = $extra['video_id']; }
		  if (isset($extra['html5_poster_img'])) { $html5_poster = $extra['html5_poster_img']; } else { $html5_poster = ''; }

		if($format == 'video') {
			if($vtype == 'youtube') {
			  $image = 'http://img.youtube.com/vi/'.$vId.'/0.jpg';
			} elseif ($vtype == 'vimeo') {
			$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$vId.php"));
			  $image = $hash[0]['thumbnail_large'];
			} elseif ($vtype == 'html5') {
			  $image = $html5_poster;
			} elseif ($vtype == 'daily') {
					$image = 'http://www.dailymotion.com/thumbnail/video/'.$vId;
			} elseif ($vtype == 'facebook') {
					$image = 'https://graph.facebook.com/'.$vId.'/picture';

			}

		}

		if($format == 'gallery') {
		global $posts_st;
		$extra = get_post_meta($id , $posts_st->get_the_id(), TRUE);
		$slides = isset($extra['slides']) ? $extra['slides'] : '';
		$image_id = isset($slides[0]['imgid']) ? $slides[0]['imgid'] : '';
		$image = wp_get_attachment_image_src($image_id, $size);
		$image = $image[0];
		}

		if ($image) return $image;

		//If there is still no image, get the first image from the post
		if (mom_option('post_first_image') == 1) {
			if (mom_get_first_image($pid) !== '') {
			return mom_get_first_image($pid,$size);
			}
		}

		$default_image = get_template_directory_uri().'/images/no-image.jpg';
			if (mom_option('post_default_img') == 1) {
				if (mom_option('custom_default_img', 'url') != '') {
					return mom_option('custom_default_img', 'url');
				} else {
						return $default_image;
				}
				
			} else {
				if ($di == true) {
					return $default_image;
				} else {
					return ;
				}
			}
		}

		function mom_get_first_image($id, $size = 'thumbnail') {
	        $post_id = $id;
	        $queried_post = get_post($post_id);
			$first_img = '';
			ob_start();
			ob_end_clean();
			$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $queried_post->post_content, $matches);
			$first_img = '';
			if (isset($matches[1][0])) {$first_img = $matches[1][0];}


		  	global $mom_thumbs_sizes;
			$w = isset($mom_thumbs_sizes[$size][0]) ? $mom_thumbs_sizes[$size][0] : '';
			$h = isset($mom_thumbs_sizes[$size][1]) ? $mom_thumbs_sizes[$size][1] : '';
		  	$first_img = vt_resize( '', $first_img, $w, $h, true );
		  	if (isset($first_img['url'])) {
				return $first_img['url'];
			} else {
				return '';
			}

		} 

		function mom_post_image_full($size = 'thumbnail', $hd = '', $alt = '', $id = ''){
			if (mom_post_image($size, $id) != '') {
				if ($hd == '') {
				$hd = $size;
				}
				if ($alt == '') {
				$alt = esc_attr(get_the_title());
				}
				global $mom_thumbs_sizes;
				$w = isset($mom_thumbs_sizes[$size][0]) ? $mom_thumbs_sizes[$size][0] : '';
				$h = isset($mom_thumbs_sizes[$size][1]) ? $mom_thumbs_sizes[$size][1] : '';

				//$w = ''; $h = '';

				if( has_post_thumbnail() || mom_option('theme_thumb') != 1) {
					$thumb = get_post_thumbnail_id();
					$image = vt_resize( $thumb, mom_post_image($size, $id), $w, $h, true );
					if($image['url'] != ''){
						$output = '<img src="'.$image['url'].'" data-hidpi="'.mom_post_image($hd, $id).'" alt="'.$alt.'" width="'.$image['width'].'" height="'.$image['height'].'">';
					} else {
						$output = '<img src="'.mom_post_image($size, $id).'" data-hidpi="'.mom_post_image($hd, $id).'" alt="'.$alt.'" width="'.$image['width'].'" height="'.$image['height'].'" style="max-height:'.$h.'px;">';
					}
				} else {
					$output = '<img src="'.mom_post_image($size, $id).'" data-hidpi="'.mom_post_image($hd, $id).'" alt="'.$alt.'" width="'.$w.'" height="'.$h.'">';
				}
					//$output .= 'SHARE_FROM_IMAGES';
				echo $output;

			} else {
			return false;
			}
		} 
/*  ---------------------------------------------------------------------------- */		
// Limit String Words
function string_limit_words($string, $word_limit)
{
  $words = explode(' ', $string, ($word_limit + 1));
  if(count($words) > $word_limit)
  array_pop($words);
  return implode(' ', $words);
}
/*  ---------------------------------------------------------------------------- */
// date format
function mom_date_format() {
	return the_time(mom_option('date_format'));
}
/*  ---------------------------------------------------------------------------- */
//breadcrumbs
function mom_breadcrumb () {
	if (mom_option('breadcrumb') != false) {
		breadcrumbs_plus();
	}
}
/*  ---------------------------------------------------------------------------- */
//Post views
add_action( 'wp_ajax_mom_set_post_views', 'setPostViews' );  
add_action( 'wp_ajax_nopriv_mom_set_post_views', 'setPostViews');
function setPostViews($postID) {
if (isset($_POST['nonce'])) {
	$nonce = $_POST['nonce'];
	if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
	die ( '' );
}

if (isset($_POST['id'])) {
	$postID = $_POST['id'];
}
	if(function_exists('the_views') && mom_option('views_by') == 'wpv') { return; }
	if (function_exists('stats_get_csv') && mom_option('views_by') == 'jetpack') { return; }
	if (! is_preview()) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
	}
	if (isset($_POST['id'])) {
		exit();
	}
}

// function to display number of posts.

add_action( 'wp_ajax_mom_post_views', 'getPostViews' );  
add_action( 'wp_ajax_nopriv_mom_post_views', 'getPostViews');
function getPostViews($postID){
if (isset($_POST['nonce'])) {
	$nonce = $_POST['nonce'];
	if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
	die ( '' );
}

if (isset($_POST['id'])) {
	$postID = $_POST['id'];
}
$echo = isset($_POST['echo']) ? $_POST['echo'] : '';
	if(function_exists('the_views') && mom_option('views_by') == 'wpv' ) {
		the_views(false);
	} elseif (function_exists('stats_get_csv') && mom_option('views_by') == 'jetpack') {
        global $post;
    $args = array(
    'days'=>-1,
    'limit'=>-1,
    'post_id'=>$post->ID
    );
$result = stats_get_csv('postviews', $args); 
    $views = $result[0]['views'];
    return number_format_i18n($views).' '.__('Views', 'framework');
} else {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        if ($echo != '') {
        	echo "0 " .__('Views', 'framework');
        } else {
        	return "0 " .__('Views', 'framework');
    	}
    } else {
        if ($echo != '') {
    		echo $count.__(' Views', 'framework');
        } else {
		    return $count.__(' Views', 'framework');
    	}

    }
	}

	if (isset($_POST['id'])) {
		exit();
	}
}
if(mom_option('post_head_views') != 0) {
// Add it to a column in WP-Admin
add_filter('manage_posts_columns', 'posts_column_views');
add_action('manage_posts_custom_column', 'posts_custom_column_views',5,2);
function posts_column_views($defaults){
    $defaults['post_views'] = __('Views', 'framework');
    return $defaults;
}
function posts_custom_column_views($column_name, $id){
	if($column_name === 'post_views'){
        echo getPostViews(get_the_ID());
    }
}
}
/*  ---------------------------------------------------------------------------- */
//IE8 
function mom_ie_shim() { ?>
	<!--[if lt IE 9]>
	<script src="<?php echo MOM_HELPERS; ?>/js/html5.js"></script>
	<script src="<?php echo MOM_HELPERS; ?>/js/IE9.js"></script>
	<![endif]-->
<?php }
add_action( 'wp_head', 'mom_ie_shim' );
/*  ---------------------------------------------------------------------------- */
//title limit
function old_short_title($num) {
 
	$limit = $num+1;
	 
	$title = str_split(get_the_title());
	 
	$length = count($title);
	 
	if ($length>=$num) {
	 
	$title = array_slice( $title, 0, $num);
	 
	$title = implode("",$title)."...";
	 
	echo $title;
	 
} else { 
	the_title();
	}
}
function short_title($num) {
	$thetitle = get_the_title(); /* or you can use get_the_title() */
$getlength = strlen($thetitle);
$thelength = $num;
echo mb_substr($thetitle, 0, $thelength);
if ($getlength > $thelength) echo "...";
}
/*  ---------------------------------------------------------------------------- */
//author filds
function mom_show_extra_profile_fields( $contactmethods ) {
		$contactmethods['facebook'] = 'FaceBook URL';
		$contactmethods['twitter'] = 'Twitter Username';
		$contactmethods['youtube'] = 'YouTube URL';
		$contactmethods['linkedin'] = 'linkedIn URL';
		$contactmethods['flickr'] = 'Flickr URL';
		$contactmethods['pinterest'] = 'Pinterest URL';
		$contactmethods['dribbble'] = 'Dribbble URL';
	return $contactmethods;		
	}
add_filter('user_contactmethods','mom_show_extra_profile_fields',10,1);

## Save user's social accounts

add_action( 'personal_options_update', 'mom_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'mom_save_extra_profile_fields' );

function mom_save_extra_profile_fields( $user_id ) {
	if ( !current_user_can( 'edit_user', $user_id ) ) return false;
	update_user_meta( $user_id, 'pinterest', $_POST['pinterest'] );
	update_user_meta( $user_id, 'twitter', $_POST['twitter'] );
	update_user_meta( $user_id, 'facebook', $_POST['facebook'] );
	update_user_meta( $user_id, 'linkedin', $_POST['linkedin'] );
	update_user_meta( $user_id, 'flickr', $_POST['flickr'] );
	update_user_meta( $user_id, 'youtube', $_POST['youtube'] );
	update_user_meta( $user_id, 'dribbble', $_POST['dribbble'] );
}
add_filter('user_contactmethods','hide_profile_fields',10,1);

function hide_profile_fields( $contactmethods ) {
    unset($contactmethods['aim']);
    unset($contactmethods['jabber']);
    unset($contactmethods['yim']);
    return $contactmethods;
}

function additional_user_fields( $user ) { ?>
    <h3><?php _e( 'Profile Cover Image', 'framework' ); ?></h3>
 
    <table class="form-table">
 
        <tr>
            <th><label for="user_meta_image"><?php _e( 'A special image for each user', 'framework' ); ?></label></th>
            <td>
                <!-- Outputs the image after save -->
                 <input type="text" class="img" name="user_meta_image" id="user_meta_image" value="<?php echo esc_url_raw( get_the_author_meta( 'user_meta_image', $user->ID ) ); ?>" />
                <!-- Outputs the save button -->
                <input type="button" class="select-img button-secondary" id="user_meta_image_button" value="Select Image" />
                <br>
                <span class="description" for="user_meta_image"><?php _e( 'Upload a cover image for your user profile.', 'framework' ); ?></span>
            </td>
        </tr>
	<?php
		wp_enqueue_media();
		wp_enqueue_script('media-upload');
	  ?>
    </table><!-- end form-table -->
<?php } // additional_user_fields
 
add_action( 'show_user_profile', 'additional_user_fields', 8 );
add_action( 'edit_user_profile', 'additional_user_fields', 8 );
/**
* Saves additional user fields to the database
*/
function save_additional_user_meta( $user_id ) {
 
    // only saves if the current user can edit user profiles
    if ( !current_user_can( 'edit_user', $user_id ) )
        return false;
 
    update_user_meta( $user_id, 'user_meta_image', $_POST['user_meta_image'] );
}
 
add_action( 'personal_options_update', 'save_additional_user_meta' );
add_action( 'edit_user_profile_update', 'save_additional_user_meta' );
/*  ---------------------------------------------------------------------------- */
//background slider
function mom_bg_slider() { ?>
	<script type="text/javascript">
	jQuery(document).ready(function($) {
	$("body").backstretch([
	<?php
	$comma = false;
	$slides = mom_option('bg_slider_img');
	foreach ($slides as $slide) {
		if ($comma) echo ","; else $comma=true;
		echo '"'.$slide['image'].'"';
	}
	?>,
	], {duration: <?php echo mom_option('bg_slider_dur'); ?>, fade: 750},"next");
	});
	</script>
<?php }

remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

//Exclude Pages from Search Results
/*-----------------------------------------------------------------------------------*/
function is_type_page() {
	global $post;
	if ($post->post_type == 'page') {
	return true;
	} else {
	return false;
}}

//Exclude Category from Search Results
/*-----------------------------------------------------------------------------------*/
function mom_SearchFilter($query) {
if ($query->is_search) {
$query->set('cat', mom_option('search_cat_ex'));
}
return $query;
}
if(! is_admin()) {
add_filter('pre_get_posts','mom_SearchFilter');
}
/*  ---------------------------------------------------------------------------- */
//chat
/* Filter the content of chat posts. */
add_filter( 'the_content', 'my_format_chat_content' );

/* Auto-add paragraphs to the chat text. */
add_filter( 'my_post_format_chat_text', 'wpautop' );

/**
 * This function filters the post content when viewing a post with the "chat" post format.  It formats the 
 * content with structured HTML markup to make it easy for theme developers to style chat posts.  The 
 * advantage of this solution is that it allows for more than two speakers (like most solutions).  You can 
 * have 100s of speakers in your chat post, each with their own, unique classes for styling.
 *
 * @author David Chandra
 * @link http://www.turtlepod.org
 * @author Justin Tadlock
 * @link http://justintadlock.com
 * @copyright Copyright (c) 2012
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @link http://justintadlock.com/archives/2012/08/21/post-formats-chat
 *
 * @global array $_post_format_chat_ids An array of IDs for the chat rows based on the author.
 * @param string $content The content of the post.
 * @return string $chat_output The formatted content of the post.
 */
function my_format_chat_content( $content ) {
	global $_post_format_chat_ids;

	/* If this is not a 'chat' post, return the content. */
	if ( !has_post_format( 'chat' ) )
		return $content;

	/* Set the global variable of speaker IDs to a new, empty array for this chat. */
	$_post_format_chat_ids = array();

	/* Allow the separator (separator for speaker/text) to be filtered. */
	$separator = apply_filters( 'my_post_format_chat_separator', ':' );

	/* Open the chat transcript div and give it a unique ID based on the post ID. */
	$chat_output = "\n\t\t\t" . '<div id="chat-transcript-' . esc_attr( get_the_ID() ) . '" class="chat-transcript">';

	/* Split the content to get individual chat rows. */
	$chat_rows = preg_split( "/(\r?\n)+|(<br\s*\/?>\s*)+/", $content );

	/* Loop through each row and format the output. */
	foreach ( $chat_rows as $chat_row ) {
	global $posts_st;
$extra = get_post_meta(get_the_ID(), $posts_st->get_the_id(), TRUE);
$avatar1 = '';
$avatar2 = '';
$avatar = '';
if (isset($extra['chat_avatar1_id'])) { $avatar1 = wp_get_attachment_image_src($extra['chat_avatar1_id'], 'square-widgets'); }
if (isset($extra['chat_avatar2_id'])) { $avatar2 = wp_get_attachment_image_src($extra['chat_avatar2_id'], 'square-widgets'); }


		/* If a speaker is found, create a new chat row with speaker and text. */
		if ( strpos( $chat_row, $separator ) ) {

			/* Split the chat row into author/text. */
			$chat_row_split = explode( $separator, trim( $chat_row ), 2 );

			/* Get the chat author and strip tags. */
			$chat_author = strip_tags( trim( $chat_row_split[0] ) );

			/* Get the chat text. */
			$chat_text = trim( $chat_row_split[1] );

			/* Get the chat row ID (based on chat author) to give a specific class to each row for styling. */
			$speaker_id = my_format_chat_row_id( $chat_author );
if ($speaker_id == '1') {
	if ($avatar1) $avatar = '<img src="'.$avatar1[0].'" alt="'. sanitize_html_class( strtolower( "chat-author-{$chat_author}" ) ) .'" width="50" height="50">';
} else {
	if ($avatar2) $avatar = '<img src="'.$avatar2[0].'" alt="'. sanitize_html_class( strtolower( "chat-author-{$chat_author}" ) ) .'" width="50" height="50">';
}
			/* Open the chat row. */
			$chat_output .= "\n\t\t\t\t" . '<div class="chat-row ' . sanitize_html_class( "chat-speaker-{$speaker_id}" ) . '">';

			/* Add the chat row author. */
			$chat_output .= "\n\t\t\t\t\t" . '<div class="mom-main-color chat-author ' . sanitize_html_class( strtolower( "chat-author-{$chat_author}" ) ) . ' vcard">'.$avatar.'<cite class="fn">' . apply_filters( 'my_post_format_chat_author', $chat_author, $speaker_id ) . '</cite></div>';

			/* Add the chat row text. */
			$chat_output .= "\n\t\t\t\t\t" . '<div class="chat-text">' . str_replace( array( "\r", "\n", "\t" ), '', apply_filters( 'my_post_format_chat_text', $chat_text, $chat_author, $speaker_id ) ) . '</div>';

			/* Close the chat row. */
			$chat_output .= "\n\t\t\t\t" . '</div><!-- .chat-row -->';
		}

		/**
		 * If no author is found, assume this is a separate paragraph of text that belongs to the
		 * previous speaker and label it as such, but let's still create a new row.
		 */
		else {

			/* Make sure we have text. */
			if ( !empty( $chat_row ) ) {

				/* Open the chat row. */
				$chat_output .= "\n\t\t\t\t" . '<div class="chat-row ' . sanitize_html_class( "chat-speaker-{$speaker_id}" ) . '">';

				/* Don't add a chat row author.  The label for the previous row should suffice. */

				/* Add the chat row text. */
				$chat_output .= "\n\t\t\t\t\t" . '<div class="chat-text">' . str_replace( array( "\r", "\n", "\t" ), '', apply_filters( 'my_post_format_chat_text', $chat_row, $chat_author, $speaker_id ) ) . '</div>';

				/* Close the chat row. */
				$chat_output .= "\n\t\t\t</div><!-- .chat-row -->";
			}
		}
	}

	/* Close the chat transcript div. */
	$chat_output .= "\n\t\t\t</div><!-- .chat-transcript -->\n";

	/* Return the chat content and apply filters for developers. */
	return apply_filters( 'my_post_format_chat_content', $chat_output );
}

/**
 * This function returns an ID based on the provided chat author name.  It keeps these IDs in a global 
 * array and makes sure we have a unique set of IDs.  The purpose of this function is to provide an "ID"
 * that will be used in an HTML class for individual chat rows so they can be styled.  So, speaker "John" 
 * will always have the same class each time he speaks.  And, speaker "Mary" will have a different class 
 * from "John" but will have the same class each time she speaks.
 *
 * @author David Chandra
 * @link http://www.turtlepod.org
 * @author Justin Tadlock
 * @link http://justintadlock.com
 * @copyright Copyright (c) 2012
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @link http://justintadlock.com/archives/2012/08/21/post-formats-chat
 *
 * @global array $_post_format_chat_ids An array of IDs for the chat rows based on the author.
 * @param string $chat_author Author of the current chat row.
 * @return int The ID for the chat row based on the author.
 */
function my_format_chat_row_id( $chat_author ) {
	global $_post_format_chat_ids;

	/* Let's sanitize the chat author to avoid craziness and differences like "John" and "john". */
	$chat_author = strtolower( strip_tags( $chat_author ) );

	/* Add the chat author to the array. */
	$_post_format_chat_ids[] = $chat_author;

	/* Make sure the array only holds unique values. */
	$_post_format_chat_ids = array_unique( $_post_format_chat_ids );

	/* Return the array key for the chat author and add "1" to avoid an ID of "0". */
	return absint( array_search( $chat_author, $_post_format_chat_ids ) ) + 1;
}
/*  ---------------------------------------------------------------------------- */
//Remove x pingback
function mom_remove_x_pingback($headers) {
    unset($headers['X-Pingback']);
    return $headers;
}
add_filter('wp_headers', 'mom_remove_x_pingback');
/*  ---------------------------------------------------------------------------- */
//Remove Ellipses from Excerpt
function mom_excerpt_more( $more ) {
	return ' ...';
}
add_filter('excerpt_more', 'mom_excerpt_more');
/*  ---------------------------------------------------------------------------- */
// Fix shortcodes bug since wp 4.0.1
add_filter( 'no_texturize_shortcodes', 'mom_shortcodes_to_exempt_from_wptexturize' );
function mom_shortcodes_to_exempt_from_wptexturize($shortcodes){
    $shortcodes[] = 'graphs';
    $shortcodes[] = 'images';
    $shortcodes[] = 'news_tabs';
    $shortcodes[] = 'tabs';
    $shortcodes[] = 'accordions';
    return $shortcodes;
}

/* ==========================================================================
 *              Display logic options
   ========================================================================== */
/**
		@param: string $opt_name 
*/
function mom_display_logic ($opt_name) {
	//$v for visible
	$condition = stripslashes(trim(mom_option($opt_name)));
    if ($condition) {
    	eval( '$v = ' . $condition . ';' );
	} else {
		$v = true;
	}

	return $v;
}
?>