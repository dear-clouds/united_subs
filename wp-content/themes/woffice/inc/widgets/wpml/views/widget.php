<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }

echo $before_widget;

echo $title;
?>

	<!-- WIDGET -->
	<?php 
    	woffice_language_switcher();
	?>
	
<?php echo $after_widget ?>