<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
?>

<?php 
if (!empty($atts['contact_form'])):
	echo do_shortcode('[contact-form-7 id="'.$atts['contact_form'].'"]'); 
else :
	_e('Please select a form in the shortcode option.','woffice'); 
endif;	
?>