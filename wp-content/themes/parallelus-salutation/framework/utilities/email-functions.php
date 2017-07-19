<?php 

if (!isset($_SESSION)) session_start(); // if captcha, we need sessions


#-----------------------------------------------------------------
# Send mail function
#-----------------------------------------------------------------

if ( ! function_exists( 'send_theme_contact_form' ) ) :

	function send_theme_contact_form() {
		
		error_reporting (E_ALL ^ E_NOTICE);
		
		$mailFormat = 'html'; // values: html or text
		
		// formatting 
		$before_line = ($mailFormat === 'html') ? '<p>' : '';
		$after_line = ($mailFormat === 'html') ? '</p>' : '"\r\n"';
		$before_title = ($mailFormat === 'html') ? '<strong>' : '';
		$after_title = ($mailFormat === 'html') ? '</strong>' : '';
		$before_h = ($mailFormat === 'html') ? '<h2>' : '';
		$after_h = ($mailFormat === 'html') ? '</h2>' : '';
		$br = ($mailFormat === 'html') ? '<br />' : '"\r\n"';
		
		// get the main data from the database
		$contact_form_data = get_theme_var('contact_form');
		$contact_fields_data = $contact_form_data['contact_fields'];
		
		// set all variables based on defaults
		$default_to = $contact_form_data['to'];
		$default_subject = $contact_form_data['subject'];
		$default_captcha = $contact_form_data['captcha'];
		$fields = $contact_fields_data;
				
		$to = $default_to;
		$subject = $default_subject; 
		$message = '';
		$email_body = '';
		$error = '';
		
		// Check common options for the senders name
		$name = '';
		$commonNames = array('name', 'yourname', 'your-name', 'your_name', 'fromname', 'from-name', 'from_name', 'sender', 'firstname', 'first-name', 'first_name');
		foreach ($commonNames as $name_field) {
			if ($_POST[$name_field]) {
				$name = $_POST[$name_field];
				break; // stop as soon as a match is found
			}
		}
		
		// Check common options for the senders email address
		$email = '';
		$commonEmails = array('email', 'e-mail', 'e_mail', 'emailaddress', 'email-address', 'email_address', 'youremail', 'your-email', 'your_email', 'sender', 'from', 'fromaddress', 'from-address', 'from_address', 'fromemail', 'from-email', 'from_email');
		foreach ($commonEmails as $email_field) {
			if ($_POST[$email_field] && simple_email_validate($_POST[$email_field])) {
				$email = $_POST[$email_field];
				break; // stop as soon as a match is found
			}
		}
		// double check...
		if (empty($email)) $email = $default_to;
				
		
		// Message Heading (title)
		$email_body .= $before_h . __('Form Submission', THEME_NAME) . $after_h;
		$email_body .= ($mailFormat !== 'html') ? $br : '';

		// fields to exclude from the message (these are for internal use)
		$excludeFields = array('mail_action', 'captcha', '_S', '_R'); 
		
		// Get the post values for the email	
		foreach($_POST as $key => $value){
			if( !in_array($key, $excludeFields) ) {
				
				$info = $fields[$key];
				
				// for checkbox values
				if ($info['field_type'] == 'checkbox' && $value == 'on') $value = __('Yes', THEME_NAME);
				
				// for radio and select values
				if ($info['field_type'] == 'radio' || $info['field_type'] == 'select') {
					// get a more human readable version (radio and select form values are sanatized)
					$field_values = explode(',', $info['values']);
					foreach ((array) $field_values as $field_value) :
						if (sanitize_title($field_value) === $value) {
							$value = $field_value; // the unsanitized version
							break; // stop once match is found
						}
					endforeach;
				}
					
				// for blank values
				if ($value == '') $value = '-'; // blank values
				
				// create the entry in the message body
				$email_body .= $before_line;
				$email_body .= $before_title . $info['label'] . $after_title . $br;
				$email_body .= $value . $br;
				$email_body .= $after_line;

			}
			else{
				
				// Special Fields
				// The "to" and "subject" fields may need to be included as hidden fields if their values were
				// specified in the shortcode and differ from the database defaults.
				
				if ($_POST['_R']) {
					// override the "to" address
					$to = strDec(trim($_POST['_R']));
					// double check...
					if (empty($to)) $to = $default_to;
				}
				if ($_POST['_S']) {
					// override the "subject:
					$subject = strDec(trim($_POST['_S']));
					// double check...
					if (empty($subject)) $subject = $default_subject;
				}
			}
		}
		
		// Validate captcha
		if ( array_key_exists('captcha',$_REQUEST )) {	// if (!empty($_REQUEST['captcha'])) {
			if (empty($_SESSION['captcha']) || trim(strtolower($_REQUEST['captcha'])) != $_SESSION['captcha']) {
				$error .= __('Invalid image verification code', THEME_NAME) .'<br />';
			} else {
				// nothing here because the captcha matches
			}
		}
		
		
		// Let's send the email.
		if(!$error) {

			//$headers = 'From: '.$name.' <'.$email.'>' . \\"\r\n\\";
			$headers = 'From: '.$name.' <'.$email.'>' . "\r\n\\";
			$message = $email_body;
			
			if ($mailFormat === 'html') {
				// set mail to send in HTML format
				add_filter('wp_mail_content_type',create_function('', 'return "text/html"; '));
			}
			
			// send
			$mail = wp_mail($to, $subject, $message, $headers);			
	
			if($mail) {
				
				// sent successfully
				$status = 'success';
				
				// clear CAPTCHA value
				if ( isset($_SESSION['captcha']) ) unset($_SESSION['captcha']);
			}
			
		} else {
			// return error messages
			$status = '<div class="error">'.$error.'</div>';
		}
		
		// to avoid loading a full page we end the process here
		exit($status); 
	
	}

endif;


// Prepare content for output
//................................................................

if ( ! function_exists( 'simple_email_validate' ) ) :

	function simple_email_validate($email){
		$regex = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";
		$eregi = preg_replace($regex,'', trim($email));		
		return empty($eregi) ? true : false;
	}
	
endif;


// Check if a form was submitted
//................................................................

if (isset($_POST['mail_action']) && !empty($_POST['mail_action']) && $_POST['mail_action'] == 'send') {
	
	// add email form function to WP init 
	add_action('init', 'send_theme_contact_form');

}
?>