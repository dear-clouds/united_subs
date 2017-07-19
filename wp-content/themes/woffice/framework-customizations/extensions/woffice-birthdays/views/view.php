<?php 

echo $before_widget;

/* Let's make things easier */
$ext_instance = fw()->extensions->get( 'woffice-birthdays' );

if( function_exists("bp_is_active") && bp_is_active( 'xprofile' ) ) {
?>
	<!-- WIDGET -->
	<div class="birthdays-container">
	
		<div class="birthdays-head">
			<i class="fa fa-birthday-cake"></i>
			<div class="intern-box box-title">
				<?php /*We check for birthdays*/
				$thebirthdays = $ext_instance->woffice_birthdays_get_array();
				/* To debbug the extension : 
				fw_print($thebirthdays); */
				echo $ext_instance->woffice_birthdays_title($thebirthdays);
				?>
			</div>
		</div>
		<ul class="birthdays-list">
			<?php /* We output the results */
			$ext_instance->woffice_birthdays_content($thebirthdays);
			?>
		</ul>
		
	</div>
<?php 
}	
echo $after_widget ?>