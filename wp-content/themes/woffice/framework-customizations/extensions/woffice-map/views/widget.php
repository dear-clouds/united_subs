<?php 

echo $before_widget;

echo $title;

/* Let's make things easier */
$ext_instance = fw()->extensions->get( 'woffice-map' );

?>
	<!-- WIDGET -->
	<div class="users-map-container">
	
		<div id="members-map-widget"></div>
		
	</div>
<?php echo $after_widget ?>