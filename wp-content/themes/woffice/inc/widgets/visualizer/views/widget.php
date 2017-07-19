<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }

echo $before_widget;

echo $title;
?>
	<!-- WIDGET -->
	<?php 
    	$widget_text = empty($instance['graph']) ? '' : stripslashes($instance['graph']);
		echo apply_filters('widget_text','[visualizer id="' . $widget_text . '"]');
	?>
	
<?php echo $after_widget ?>