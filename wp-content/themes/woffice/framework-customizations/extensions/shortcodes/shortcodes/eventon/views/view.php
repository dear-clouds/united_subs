<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
?>

<?php 
if (!empty($atts['eventon_id'])):

	// main calendar display
	if ($atts['eventon_type'] == "calendar") {
	
		if (!empty($atts['eventon_open'])){
			$extra_args = ($atts['eventon_open'] == "yep") ? ' evc_open="yes"' : '';
		}
		else {
			$extra_args = '';
		}
		echo do_shortcode('[add_eventon_fc cal_id="'.$atts['eventon_id'].'" show_et_ft_img="yes" ft_event_priority="yes" load_fullmonth="no" '.$extra_args.']'); 
		
	}
	// single event 
	else {
		
		if (!empty($atts['eventon_open'])){
			$eventon_open = ($atts['eventon_open'] == "yep") ? 'show_exp_evc="yes" ' : '';
		}
		if (!empty($atts['eventon_excerpt'])){
			$eventon_excerpt = ($atts['eventon_excerpt'] == "yep") ? 'show_excerpt="yes" ' : '';
		}
		$extra_args = $eventon_open . $eventon_excerpt;
		
		echo do_shortcode('[add_single_eventon id="'.$atts['eventon_id'].'" '.$extra_args.' open_as_popup="yes"]'); 
	
	}
	
	
	
else :
	_e('Please select an unique ID in the shortcode option.','woffice'); 
endif;	
?>