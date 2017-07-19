<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
?>

<div class="shortcode-trello">
	<?php 
	if (class_exists('wp_trello')){
		if (!empty($atts['trello_id'])):
			echo do_shortcode('[wp-trello type="'.$atts['type'].'" id="'.$atts['trello_id'].'" link="'.$atts['link'].'"]'); 
		else :
			_e('Please select an ID for the Trello Element.','woffice'); 
		endif;	
	}
	else {
		_e('Please install the plugin ','woffice'); 
		echo '<a href="https://wordpress.org/plugins/wp-trello/" target="_blank">WP Trello</a>';
	}
	?>
</div>