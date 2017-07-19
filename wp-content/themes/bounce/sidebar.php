<?php require(gp_inc . 'options.php'); global $gp_settings; ?>


<?php if($gp_settings['layout'] != "fullwidth") { ?>

	
	<!-- BEGIN SIDEBAR -->
	
	<div id="sidebar">
				
		
		<!-- BEGIN BUDDYPRESS SITEWIDE NOTICES -->
				
		<?php if(function_exists('bp_message_get_notices')) { ?>
			<?php bp_message_get_notices(); ?>
		<?php } ?>
		
		<!-- END BUDDYPRESS SITEWIDE NOTICES -->
		
		
		<?php if(is_active_sidebar($gp_settings['sidebar'])) { ?>


			<!-- BEGIN DESIRED WIDGETS -->		

			<?php dynamic_sidebar($gp_settings['sidebar']); ?>

			<!-- END DESIRED WIDGETS -->			

		
		<?php } ?>
		
		
	</div>
	
	<!-- END SIDEBAR -->
	

<?php } ?>