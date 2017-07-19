<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
/**
 * VIEW OF FW_Extension_Woffice_Poll
 */
 
echo $before_widget;

echo $title;
?>
	
		<?php 
		if(!empty($answers)){
			/**
			 * LOAD THE FORM
			 */
			echo '<form id="woffice_poll" action="'.$_SERVER['REQUEST_URI'].'" method="POST" class="wpcf7">';
				
				// Only for logged users ? 
				$logged_only = fw_get_db_ext_settings_option( 'woffice-poll', 'logged_only' );
				if ($logged_only == true && !is_user_logged_in()) {
					
					echo '<div class="woffice-poll-ajax-reply">';
						echo'<i class="fa fa-lock"></i>
						<p>'.__("Sorry ! It is only for logged users.","woffice").'</p>';
					echo '</div>';
					
				}
				else {
					
					/* CHECK IF USER ALREADY VOTED */
					$user_ID = get_current_user_id();
					$the_saved_users = get_option('woffice_poll_users');
					$the_saved_users_array = (is_array($the_saved_users)) ? $the_saved_users : array();
					if( ! in_array($user_ID,$the_saved_users_array) && $type == "question"){
						/* QUESTION NAME */
						echo '<p>'.esc_html($name).'</p>';
						/*NOT DONE YET 0.9 */
						/*echo ($type == 'checkbox') ? '<span class="wpcf7-checkbox">' : '<span class="wpcf7-radio">';*/
						echo '<span class="wpcf7-checkbox">';
							/* LOOP ANSWER */
							foreach ($answers as $answer) {
								echo '<span class="wpcf7-list-item">';
									echo '<label class="poll-answer">';
										/*CHECK DATA KIND*/
										/*if ($type == 'checkbox') :*/
											echo '<input type="checkbox" name="'.sanitize_title($answer).'" id="'.sanitize_title($answer).'" value="'.sanitize_title($answer).'">';
										/*else :
											echo '<input type="radio" name="'.sanitize_title($name).'" id="'.sanitize_title($answer).'" value="'.sanitize_title($answer).'">';
										endif;*/
										/*ANSWER*/
										echo '<span class="wpcf7-list-item-label">'. esc_html($answer) .'</span>';
									echo '</label>';
								echo '</span>';
							}
						echo'</span>';
						
						/*SUBMIT BUTTON*/
						echo'<p class="text-right">';        
					        echo wp_nonce_field( 'woffice_poll_nonce','woffice_poll_nonce_field');
					        echo'<input type="hidden" name="action" value="wofficePolladdAnswer"/>';
					        echo'<button type="submit" class="btn btn-default">';
					        	echo'<i class="fa fa-arrow-right"></i>';
					        	 _e( 'Send', 'woffice');
					         echo'</button>';
					    echo'</p>';
					    
					}
					else {
						/*DISPLAY RESULTS*/
						echo'<div class="woffice-poll-ajax-reply sent">
							<i class="fa fa-check"></i>
							<p>'.__("Thanks ! Here are the results for","woffice").'</p>
							<span class="poll-question-back">'.$name.'</span>
						</div>'; 
						fw()->extensions->get('woffice-poll')->woffice_poll_get_results();
					}
				
				}
			    
			echo '</form>';
			
			/**
			 * LOADING LOOP
			 */
			echo'<!-- LOADER -->
			<div id="poll-loader" class="woffice-loader">
				<i class="fa fa-spinner"></i>
			</div>';
			
			/**
			 * MESSAGE FROM AJAX 
			 */
			echo'<div id="woffice_ajax_validation"></div>' ;
			
		}
		else {
			echo '<p>'. __('Sorry, there is no answer set yet in the Extension options.','woffice') .'</p>';
		} ?>
		
	
<?php 
/* AFTER WIDGET */
echo $after_widget ?>