<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }

echo $before_widget;

echo $title;
?>
	<!-- WIDGET -->
	<?php 
    	$widget_text = empty($instance['form']) ? '' : stripslashes($instance['form']);
		echo apply_filters('widget_text','[contact-form-7 id="' . $widget_text . '"]');
	?>
	
<?php echo $after_widget ?>