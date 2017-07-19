<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
?>

<?php 
if (defined('fileaway')):

	$kind = (!empty($atts['file_away_kind'])) ? $atts['file_away_kind'] : 'fileaway';
	$dir = (!empty($atts['file_away_kind'])) ? $atts['file_away_directory'] : '1';
	$sub = (!empty($atts['file_away_sub'])) ? 'sub="'.$atts['file_away_sub'].'" ' : '';
    $additional_attributes = (!empty($atts['file_away_customattr'])) ? $atts['file_away_customattr'] : '';
	if ($kind == "fileup") {
		$extra_fields = '';
	}
	else {
		$extra_fields = 'type="table" directories="true" paginate="false" makedir="true" flightbox="images"';
	}
	$sub_ready = (!empty($sub)) ? 'sub="'.$sub.'"' : '';
	
	
	echo do_shortcode('['.$kind.' base="'.$dir.'" makedir="true" '.$sub_ready.' '.$extra_fields.' '.$additional_attributes.']');
	
else :
	_e('Please install File Away plugin and make sure it is activated.','woffice'); 
	echo '<a href="https://wordpress.org/plugins/file-away/" target="_blank">Plugin Page</a>';
endif;	
?>