<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
?>

<?php 
	// default value 
	$title = $subtitle = $msub = '';
	
	//get the variables & check
	if(!empty($atts['eventon_title'])) {
		$title = 'header="'.$atts['eventon_title'].'" ';
	}
	if(!empty($atts['eventon_subtitle'])) {
		$subtitle = 'sheader="'.$atts['eventon_subtitle'].'" ';
	}
	if($atts['eventon_msub'] == true){
		$msub = 'msub="yes" ';
	}
	
	$extra_args = $title . $subtitle . $msub;
	
	
	echo do_shortcode('[add_evo_submission_form '.$extra_args.']'); 
?>