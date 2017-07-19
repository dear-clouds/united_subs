<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
/**
 * VIEW OF FW_Extension_Woffice_Map
 */
$ext_instance = fw()->extensions->get( 'woffice-map' );

$js_array = get_option('woffice_map_locations');

if (!empty($js_array)){
	?>
	<div id="members-map-container">
		<div id="members-map"></div>
		<!--
		<div id="members-map-loader" class="woffice-loader">
			<i class="fa fa-spinner"></i>
		</div>-->
		<a href="javascript:void(0)" id="members-map-trigger" class="btn btn-default"><i class="fa fa-map-marker"></i> <?php _e('Members around the world','woffice'); ?></a>
	</div>
	
	<?php
} else {
	?>
	
	<div class="center"><p><?php _e('Sorry there is no users locations so we can not display the map. As it is empty.','woffice'); ?></p></div>
	
	<?php
}