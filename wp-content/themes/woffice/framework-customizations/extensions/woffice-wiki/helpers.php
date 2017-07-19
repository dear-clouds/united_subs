<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
/**
 * Check if the current user can see the wiki article
 */
function woffice_is_user_allowed_wiki(){
	
	/* Fetch data from options both settings & post options */
	$exclude_roles = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option(get_the_ID(), 'exclude_roles') : '';
	
	$user_ID = get_current_user_id();
	
	$is_allowed = true;
	
	/* We check now if the role is excluded */	
	$role_allowed = true;		
	if (!empty($exclude_roles)) : 
		$user = wp_get_current_user();
		/* Thanks to Buddypress we only keep the main role */
		$the_user_role = (is_array($user->roles)) ? $user->roles[0] : $user->roles;
		
		/* We check if it's in the array, OR if it's the administrator  */
		if (in_array( $the_user_role , $exclude_roles ) || $the_user_role != "administrator") {
			$role_allowed = false;
		}
	endif;
	
	/*We check the results*/
	if ($role_allowed == false){
		$is_allowed = false;
	}
	
	return $is_allowed;
	
}
/**
 * Create the Like Button HTML
 */
function woffice_get_wiki_like_html($post_ID) {
    $enable_wiki_like = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('enable_wiki_like') : '';
    if($enable_wiki_like != 'yep')
        return '';

	$ext_instance = fw()->extensions->get( 'woffice-wiki' );
	
	$vote_count = get_post_meta($post_ID, "votes_count", true);
	$vote_count_disp = (empty($vote_count)) ? '0' : $vote_count; 
	
	$html='<div class="wiki-like-container">';
		$html .='<p class="wiki-like">';
		    if($ext_instance->woffice_user_has_already_voted($post_ID)) {
		        $html .= ' <span title="'.__('I like this article', 'woffice').'" class="like alreadyvoted">
		        	<i class="fa fa-thumbs-up"></i>
		        </span>';
		    } else { 
		        $html .= '<a href="javascript:void(0)" data-post_id="'.$post_ID.'">
	                <i class="fa fa-thumbs-o-up"></i>
	            </a>';
		    }
		    $html .='<span class="count">'.$vote_count_disp.'</span>';
		$html .='</p>';
	$html .='</div>';
	
	return $html;
	
}

/**
 * Get likes number
 */
function woffice_get_wiki_likes($post_ID) {
    $enable_wiki_like = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('enable_wiki_like') : '';
    if($enable_wiki_like != 'yep')
        return '';

	/* We get the data from the post meta */
	$vote_count = get_post_meta($post_ID, "votes_count", true);
	$vote_count_disp = (empty($vote_count)) ? '0' : $vote_count; 

	/* We only return something if there is more than one like */
	
	if ($vote_count_disp > 0) {
		
		$html='<span class="count label"><i class="fa fa-thumbs-o-up"></i> '.$vote_count_disp.'</span>';
		
		return $html;
		
	}
	else {
		return;
	}

}

function woffice_wiki_sort_by_like() {
    /*We check first to display it or not */
    $wiki_sortbylike = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('wiki_sortbylike') : '';
    if ($wiki_sortbylike == "yep") {

        global $wp;
        $current_url = home_url(add_query_arg(array(),$wp->request));
        echo '<p class="text-center">';
        echo '<a id="woffice-members-filter-btn" class="btn btn-default" href="'.esc_url($current_url).'?sortby=like"><i class="fa fa-sort-amount-desc"></i>'.__('Sort By Likes','woffice') .'</a>';
        echo '</p>';

    }
}


function woffice_sort_objects_by_likes($a, $b) {
    return strcmp($b['likes'], $a['likes']);
}