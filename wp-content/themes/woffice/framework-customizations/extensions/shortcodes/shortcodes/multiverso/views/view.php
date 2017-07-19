<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
?>

<?php 

if (!empty($atts['mv_kind'])):
	if ($atts['mv_kind'] == "all_files"):
		echo do_shortcode('[woffice_allfiles]'); 
	elseif ($atts['mv_kind'] == "single"):
		echo do_shortcode('[mv_file id='.$atts['mv_single'].']'); 
	elseif ($atts['mv_kind'] == "category"):
		echo do_shortcode('[mv_single_category id='.$atts['mv_category'].']'); 
	else : 
		echo do_shortcode('[mv_managefiles]'); 
	endif;
else :
	_e('Please select a value in the shortcode option.','woffice'); 
endif;	
?>