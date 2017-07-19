<?php

// Check to make sure that the name field is not empty
if(trim($_POST['contactName']) === '') {
	$nameError = true;
	$hasError = true;
} else {
	$name = trim($_POST['contactName']);
}

// Check to make sure sure that a valid email address is submitted
if(trim($_POST['contactEmail']) === '')  {
	$emailError = true;
	$hasError = true;
} else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['contactEmail']))) {
	$emailError = true;
	$hasError = true;
} else {
	$contactEmail = trim($_POST['contactEmail']);
}
	
// Check to make sure comments were entered	
if(trim($_POST['comments']) === '') {
	$commentError = true;
	$hasError = true;
} else {
	if(function_exists('stripslashes')) {
		$comments = stripslashes(trim($_POST['comments']));
	} else {
		$comments = trim($_POST['comments']);
	}
}

// Check to see if sum has been correctly answered
if(trim($_POST['verify']) !== '4') {
	$verifyError = true;
	$hasError = true;
}

// Error Message
if(($NameError == true) OR ($emailError == true) OR ($commentError == true) OR ($verifyError == true)) {
	$captchaError = true;
}

// If there is no error, send the email
if(!isset($hasError)) {

	$emailTo = $_POST['emailAddress'];
	$subject = __('You have received a message from ', 'gp_lang') . $name;
	$sendCopy = trim($_POST['sendCopy']);
	$body = __('Name: ', 'gp_lang') . $name . "\n\n" . __('Email: ', 'gp_lang') . $contactEmail . "\n\n" . __('Comment: ', 'gp_lang') . $comments;
	$headers = __('From: ', 'gp_lang') . '<'.$contactEmail.'>' . "\r\n" . __('Reply-To: ', 'gp_lang') . $contactEmail;
	
	mail($emailTo, $subject, $body, $headers);

	if($sendCopy == true) {
		$subject = 'You emailed Your Name';
		$headers = 'From: Your Name <noreply@somedomain.com>';
		mail($contactEmail, $subject, $body, $headers);
	}

	$emailSent = true;

}

?>