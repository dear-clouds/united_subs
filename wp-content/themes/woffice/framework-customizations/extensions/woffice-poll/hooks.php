<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
			
function wofficePolladdAnswer(){
	
	if (!wp_verify_nonce( $_POST['woffice_poll_nonce_field'], 'woffice_poll_nonce')) {
		exit("No naughty business please!");
	} 
	
	$ext_instance = fw()->extensions->get( 'woffice-poll' );
	
	global $wpdb;
	
	/*DEFINE OUR CONSTANT FOR THE TABLE NAME*/
	$table_name = $wpdb->prefix . 'woffice_poll';
	
	$error = TRUE;
	
	/* GET THE ANSWERS AVAILABLE IN THE DATABASE */
	$answers = $ext_instance->woffice_get_poll_answers();
	
	/*LET'S CHECK THEM ALL*/
	foreach ($answers as $answer) {
		/*TRNASFORM AS A SLUG*/
		$the_answer = sanitize_title($answer);
		
		/*CHECK IF IT'S EMPTY*/
		if(isset($_POST[$the_answer])){
		
			/* GET THE DATA FOR EACH FIELD IN THE FORM */
			$the_answer_ready = $_POST[$the_answer];
		
			/*CHECK IF THE VALUE IN RECEIVED IS THE ONE IN THE DATABASE*/
			if($_POST[$the_answer] == $the_answer) {
				/*GET THE NUMBER OF REPS*/
				$reps = $wpdb->get_var( $wpdb->prepare( "SELECT reps FROM $table_name WHERE label = %s",$answer) );
				/*ADD ONE*/
				$new_reps = $reps + 1;
				/*ADD NEW NUMBER OF REPS*/
				if( $wpdb->update($table_name,array('reps'=>$new_reps),array( 'label' => $answer ))===FALSE ){
					$error = TRUE;
				} 
				else {
					$error = FALSE;
					$user_ID = get_current_user_id();
					/* USER CAN'T RE-VOTE */
					$ext_instance->woffice_poll_add_user($user_ID);
				}
			}
		}
		
	}
	
	
	/*DISPLAY MESSAGE*/
	if ($error === TRUE) {
	
		echo'<div class="woffice-poll-ajax-reply fail">
			<i class="fa fa-times"></i>
			<p>'.__("Error, something is wrong please refresh this page. Note that you can not vote twice.","woffice").'</p>
		</div>'; 
		
	}
	else {
		$poll_question = $ext_instance->woffice_get_poll_name();
		echo'<div class="woffice-poll-ajax-reply sent">
			<i class="fa fa-check"></i>
			<p>'.__("Thanks ! Here are the results for","woffice").'</p>
			<span class="poll-question-back">'.$poll_question.'</span>
		</div>'; 
		
		/*DISPLAY THE RESULT HERE*/
		$ext_instance->woffice_poll_get_results();
		
	}
	
	die();
}
add_action('wp_ajax_wofficePolladdAnswer', 'wofficePolladdAnswer');

/**
 * REFRESH TABLE IN THE DATABASE
 */	
function woffice_poll_refresh_table() {
	
	$delete_poll = isset($_GET["delete_poll"]) ? $_GET["delete_poll"] : '';
	if ($delete_poll == "yes") {
    
		/* We delete the entries in the database */
	    global $wpdb;
		$table_name = WOFFICE_POLL_TABLE;
		$sql = "DELETE FROM $table_name;";
		$wpdb->query($sql);
		
		/* We delete the setting in the extension */
		fw_set_db_ext_settings_option('woffice-poll', 'answers', array('Answer 1'));
		
		/* User array refresh */
		update_option('woffice_poll_users', array(0));
		
		/* We remove the GET param */
		wp_redirect(admin_url('admin.php?page=fw-extensions&sub-page=extension&extension=woffice-poll'));
		// echo remove_query_arg( 'delete_poll' );
		// unset($_GET["delete_poll"]);
		
	}
	
}
add_action('admin_init', 'woffice_poll_refresh_table');

/**
 * REFRESH TABLE IN THE DATABASE
 */	
function woffice_poll_export_table() {
	
	$export_poll = isset($_GET["export_poll"]) ? $_GET["export_poll"] : '';
	if ($export_poll == "yes") {
		
		// We get the array of results
		$ext_instance = fw()->extensions->get( 'woffice-poll' );
		$array_results = $ext_instance->woffice_poll_get_results_backend();

		// create a file pointer connected to the output stream
		$output = fopen('php://output', 'w');
		// HEADER READY : 
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=data.csv');
		
		fputcsv($output, array(__('Results are in percentage','woffice')));
		// Output in the file : 
		foreach($array_results as $result) {
			fputcsv($output, array($result['label']));
			fputcsv($output, array($result['html']));
		}
		
		fclose($output);
		
		exit();
		
		wp_redirect(admin_url('admin.php?page=fw-extensions&sub-page=extension&extension=woffice-poll'));
		
	}
	
}
add_action('admin_init', 'woffice_poll_export_table');