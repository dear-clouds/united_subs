<?php

if ( ! function_exists( 'gp_contact_form' ) ) {
	function gp_contact_form($atts, $content = null) {
		extract(shortcode_atts(array(
			'email' => ''
		),$atts));
	
		wp_enqueue_script('gp-contact-init');	
	
		$out = '';
		
		// Form Submitted
		if(isset($_POST['submittedContact'])) {
			require(gp_inc . "/contact.php");
		}
	
		if(isset($emailSent) && $emailSent == true) {
		
			$out .= '<a id="contact_"></a>';
			$out .= '<div class="contact-form notify notify-success">'.__('Thanks', 'gp_lang').' '.$name.'. '.__('Your message was successfully sent.', 'gp_lang').'</div>';
		
		} else {
		
			if(isset($captchaError)) {
				$out .= '<a id="contact_"></a>';
				$out .= '<div class="contact-form notify notify-error">'.__('There was an error submitting this message.', 'gp_lang').'</div>';
			}
				
			// Name
			$out .= '<a id="contact_"></a>';
			$out .= '<form action="' .get_permalink(get_the_ID()). '#contact_" id="contact-form" method="post">';
			$out .= '<p><label class="textfield_label" for="contactName">'.__('Name', 'gp_lang').'  <span class="required">*</span></label><input type="text" name="contactName" id="contactName" value="';
		
			if(isset($_POST['contactName'])) {
				$out .= $_POST['contactName'];
			}
			$out .= '"';
			$out .= ' class="requiredFieldContact textfield';
		
			if(isset($nameError)) {
				$out .= ' input-error';
			}
			$out .= '"';
			$out .= ' size="22" /></p>';

		
			// Email
			$out .= '<p><label class="textfield_label" for="contactEmail">'.__('Email', 'gp_lang').' <span class="required">*</span></label><input type="text" name="contactEmail" id="contactEmail" value="';
		
			if(isset($_POST['contactEmail'])) {
				$out .= $_POST['contactEmail'];
			}
			$out .= '"';
			$out .= ' class="requiredFieldContact email textfield';
		
			if(isset($emailError)) {
				$out .= ' input-error';
			}
			$out .= '"';
			$out .= ' size="22" /></p>';

		
			// Comments
			$out .= '<p><label class="textfield_label" for="contactComment">'.__('Comment', 'gp_lang').' <span class="required">*</span></label><textarea name="comments" id="commentsText" rows="5" cols="40" class="requiredFieldContact textarea';
		
			if(isset($commentError)) {
				$out .= ' input-error';
			}
			$out .= '">';
		
			if(isset($_POST['comments'])) { 
				if(function_exists('stripslashes')) { 
					$out .= stripslashes($_POST['comments']); 
					} else { 
						$out .= $_POST['comments']; 
					} 
				}
			$out .= '</textarea></p>';
		
			$out .= '<div class="contact-verify"><label for="verify" accesskey=V>3 + 1 = </label><input name="verify" type="text" id="verify" value="';

		
			// Verify
			if(isset($_POST['verify'])) {
				$out .= $_POST['verify'];
			}
			$out .= '"';
			$out .= ' class="requiredFieldContact verify';
		
			if(isset($verifyError)) {
				$out .= ' input-error';
			}
			$out .= '"';
			$out .= ' size="2" /></div>';
		
		
			// Submit
			$out .= '<input name="submittedContact" id="submittedContact" class="contact-submit" value="'.__('Send', 'gp_lang').'" type="submit" />';
			$out .= '<p class="loader"></p>';

			$out .= '<input id="submitUrl" type="hidden" name="submitUrl" value="'. gp_inc . 'contact.php" />';
			$out .= '<input id="emailAddress" type="hidden" name="emailAddress" value="' .$email. '" />';
	
			$out .= '</form>';

		}
		return $out;
	}
}
add_shortcode("contact", "gp_contact_form");

?>