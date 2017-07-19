<?php
/*
 * INSPIRED BY http://gabrieleromanato.name/adding-jquery-ui-autocomplete-to-the-wordpress-search-form/
 * COPYRIGHT gabrieleromanato
 */
function woffice_autocomplete_add_scripts() {
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-ui-autocomplete' );
	//wp_register_style( 'jquery-ui-styles','http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css' );
	//wp_enqueue_style( 'jquery-ui-styles' );
	wp_register_script( 'woffice-autocomplete', get_template_directory_uri() . '/js/autocomplete.js', array( 'jquery', 'jquery-ui-autocomplete' ), '1.0', false );
	wp_localize_script( 'woffice-autocomplete', 'WofficeAutocomplete', array( 'url' => admin_url( 'admin-ajax.php' ) ) );
	wp_enqueue_script( 'woffice-autocomplete' );
}
add_action( 'wp_enqueue_scripts', 'woffice_autocomplete_add_scripts' );

function woffice_search() {
		$term = strtolower( $_GET['term'] );


		$loop = new WP_Query( array( 's' => $term, 'post_type' => array('page', 'post', 'directory', 'project', 'wiki', 'ajde_events', 'forum', 'topic') ) );

		while( $loop->have_posts() ) {

			$loop->the_post();
			$suggestion = array();
			$suggestion['label'] = get_the_title();
			$suggestion['link'] = get_permalink();
			$suggestions[] = $suggestion;

		}

		wp_reset_postdata();
    	
    	
    	$response = json_encode( $suggestions );
    	echo $response;
    	exit();

}

add_action( 'wp_ajax_woffice_search', 'woffice_search' );
add_action( 'wp_ajax_nopriv_woffice_search', 'woffice_search' );

/*
function woffice_search_members()
{
	$term = strtolower($_GET['term']);

	//$suggestions = array(array("label" => "tes", "link" => "a"));

	if (bp_has_members(bp_ajax_querystring('members') . '&s=' . $term)) :

		while (bp_members()) :

			bp_the_member();

			// USERNAME OR NAME DISPLAYED
			$buddy_directory_name = (function_exists('fw_get_db_settings_option')) ? fw_get_db_settings_option('buddy_directory_name') : '';
			if ($buddy_directory_name == "name") {
				$user_info = get_userdata(bp_get_member_user_id());
				$ready_display = $user_info->first_name;
			} else {
				$ready_display = bp_get_member_name();
			}
			$suggestion = array();
			$suggestion['label'] = $ready_display;
			$suggestion['link'] = bp_get_member_permalink();
			$suggestions[] = $suggestion;

		endwhile;

	endif;

	wp_reset_postdata();


	$response = json_encode( $suggestions );

	echo $response;

	exit();

}

add_action( 'wp_ajax_wofficeSearchMembers', 'woffice_search_members' );
add_action( 'wp_ajax_nopriv_wofficeSearchMembers', 'woffice_search_members' );
*/