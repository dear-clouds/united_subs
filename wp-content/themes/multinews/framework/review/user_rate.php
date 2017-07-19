<?php 
//function momizat_user_rate_scripts() {
//	wp_enqueue_script( 'user_rate', get_template_directory_uri().'/framework/review/js/user-rate.js', array('jquery'), '1.0', 1 );
//	wp_localize_script( 'user_rate', 'ajax_var', array(
//		'url' => admin_url( 'admin-ajax.php' ),
//		'nonce' => wp_create_nonce( 'ajax-nonce' )
//		)
//	);
//}
//add_action( 'wp_head', 'momizat_user_rate_scripts' ); //add this with main.js

add_action( 'wp_ajax_nopriv_user-rate', 'momizat_user_rate' );
add_action( 'wp_ajax_user-rate', 'momizat_user_rate' );
function momizat_user_rate() {

    // stay away from bad guys 
    $nonce = $_POST['nonce'];
    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
        die ( 'Nope!' );


    // get values
    $post_id = $_POST['post_id'];
    $rate = $_POST['user_rate_score'];

    $rate_score = get_post_meta($post_id, 'mom_rate_score', true);
    if(!$rate_score)
        $rate_score = 0;
    
    $rate_count = get_post_meta($post_id, 'mom_rate_count', true);
    if(!$rate_count)
        $rate_count = 0;

    $the_rate = get_post_meta($post_id, 'mom_star_rate', true);
    if(!$the_rate)
        $the_rate = 0;
        
    // new values
    $new_score = floor(($rate_score * $rate_count + $rate ) / ($rate_count + 1));
    $new_count = $rate_count + 1;
    $new_rate = floor(($new_score / 10) * 5) / 10;
    
    //prevent user rate twice
			$ip = $_SERVER['REMOTE_ADDR']; // user IP address
			$meta_IPS = get_post_meta( $post_id, "mom_rate_user_IP" ); // stored IP addresses
			$rated_IPS = ""; // set up array variable
			
			if ( count( $meta_IPS ) != 0 ) { // meta exists, set up values
				$rated_IPS = $meta_IPS[0];
			}
	
			if ( !is_array( $rated_IPS ) ) // make array just in case
				$rated_IPS = array();
				
			if ( !in_array( $ip, $rated_IPS ) ) // if IP not in array
				$rated_IPS['ip-'.$ip] = $ip; // add IP to array

		if(!momizat_Alreadyrate($post_id))
		{
    // Update rate
		update_post_meta($post_id, "mom_rate_user_IP", $rated_IPS);

            update_post_meta( $post_id, "mom_rate_score", $new_score );
            update_post_meta( $post_id, "mom_rate_count", $new_count );
            update_post_meta( $post_id, "mom_star_rate", $new_rate );

            //echo number_format($the_rate, 1); // update rate on front end
		} else {
			echo 'already';
		}

exit();
}

// check if user already rate this post
function momizat_Alreadyrate( $post_id ) { // test if user liked before
	
    $meta_IPS = get_post_meta($post_id, "mom_rate_user_IP"); // get previously voted IP address
    $ip = momizat_getUserIP(); // Retrieve current user IP
    $rated_IPS = ""; // set up array variable
    
    if ( count( $meta_IPS ) != 0 ) { // meta exists, set up values
            $rated_IPS = $meta_IPS[0];
    }
    
    if ( !is_array( $rated_IPS ) ) // make array just in case
            $rated_IPS = array();
    
    if ( in_array( $ip, $rated_IPS ) ) { // True is IP in array
            return true;
    }
    return false;
}

// rate in frontend
function momizat_getPostRate( $post_id, $style="stars" ) {
$themename = 'theme'; // the theme name
$voters_count = get_post_meta( $post_id, "mom_rate_count", true ); 
$the_rate = get_post_meta( $post_id, "mom_star_rate", true ); 
$the_score = get_post_meta( $post_id, "mom_rate_score", true );
$print_score = $the_score;
$points = $the_score/10;
$units = get_post_meta(get_the_ID(),'_mom_review_box_units',true);
$rs_suffix = '';
if ($units == 'percent') {
	$rs_suffix = '%';
}
if ($units == 'points') {
	$print_score = $points;
} 
if (!$the_score) {
	$the_score = 50;
}
$output = '';
	if ($style == 'bars') {
		if ( momizat_Alreadyrate( $post_id ) ) { // already liked, set up unlike addon
			$output .= '<div><div class="ub-inner"  data-post_id="'.$post_id.'" style="width:'.$the_score.'%;" data-style="bars" data-units="'.$units.'"><span>'.$print_score.$rs_suffix.'</span></div></div>';
			} else { 
			$output .= '<div class="mom_user_rate" data-post_id="'.$post_id.'" data-style="bars" data-votes_count="'.$voters_count.'" data-units="'.$units.'"><div class="ub-inner" style="width:'.$the_score.'%;"><span  style="-moz-user-select: none; -webkit-user-select: none; -ms-user-select:none; user-select:none;" 
 unselectable="on"
 onselectstart="return false;" 
 onmousedown="return false;">'.$print_score.$rs_suffix.'</span></div></div>';
		}
		
	}
	elseif ($style == 'circles') {
			$td_color = '#eee';
			if (mom_option('mom_color_skin') == 'black') {
				$td_color = '#2D2F2F';
			}
			
			$fd_color = '#4A525D';
			if (mom_option('mom_color_skin') == 'black') {
				$fd_color = '#111';
			}
		if ( momizat_Alreadyrate( $post_id ) ) { // already liked, set up unlike addon
			$output .= '<div class="circle"><input type="text" class="urc-value" data-width="80" data-height="45" data-angleArc="200" data-angleOffset="-100" value="'.$the_score.'" data-thickness=".25" data-fgcolor="'.$fd_color.'" data-bgColor="'.$td_color.'" data-readOnly="true"><span class="cru-score"><span class="cru-num">'.$print_score.'</span>'.$rs_suffix.'</span></div>';
			} else { 
			$output .= '<div class="circle mom_user_rate_cr" data-post_id="'.$post_id.'" data-style="bars" data-votes_count="'.$voters_count.'"><input type="text" class="urc-value" data-width="80" data-height="45" data-angleArc="200" data-angleOffset="-100" value="'.$the_score.'" data-thickness=".25" data-fgcolor="'.$fd_color.'" data-bgColor="'.$td_color.'"><span class="cru-score"><span class="cru-num">'.$print_score.'</span>'.$rs_suffix.'</span></div>';
		}
	} else {
		if ( momizat_Alreadyrate( $post_id ) ) { // already liked, set up unlike addon
			$output .= '<div><div class="stars-rate-wrap"><div class="star-rating" data-post_id="'.$post_id.'"><span style="width:'.$the_score.'%;"></span></div><em class="yr">'.$the_rate.'/5</em></div></div>';
			} else { 
			$output .= '<div><div class="stars-rate-wrap"><div class="star-rating mom_user_rate" data-post_id="'.$post_id.'" data-style="stars" data-votes_count="'.$voters_count.'"><span style="width:'.$the_score.'%"></span></div><em class="yr">'.$the_rate.'/5</em></div></div>';
		}
	}

	return $output;
}

function momizat_getUserIP()
{
    if(isset($_SERVER['HTTP_CLIENT_IP'])) {$client  = $_SERVER['HTTP_CLIENT_IP']; } else { $client = '';}
    if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {$forward  = $_SERVER['HTTP_X_FORWARDED_FOR']; } else { $forward = '';}
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}