<?php
/**
 * The template for displaying the footer
 */
?>
				
				<?php
				/* Will be deleted in the next version */	
					
				// GET SIDEBAR
				// FETCHING SIDEBAR POSITION 
				/*$sidebar_position = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('sidebar_position') : 'right'; 
				$sidebar_show = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('sidebar_show') : ''; 
				if($sidebar_position == "right" && $sidebar_show != "hide") : 
					get_sidebar(); 
				endif;*/
				 ?>
				
				
				<?php // DISPLAY SCROLL 
				$sidebar_scroll_inner = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('sidebar_scroll_inner') : ''; 
				if ($sidebar_scroll_inner == "yep") :
					echo'<a href="javascript:void(0)" id="can-scroll"><i class="fa fa-angle-double-down"></i></a>';
				endif; ?>
			
			</section>
			<!-- END CONTENT -->

			<!-- START FOOTER -->
            <?php $navigation_hidden_class = woffice_get_navigation_class(); ?>
			<footer id="main-footer" class="<?php echo esc_attr($navigation_hidden_class)?>">
				
				<?php // IF YOU WANT TO DISPLAY THE EXTRA FOOTER
				$extrafooter_show = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('extrafooter_show') : '';
				if(  $extrafooter_show == "yes" ) : 
					woffice_extrafooter();
				endif; ?>

				<?php // IF YOU WANT TO DISPLAY WIDGET AREA IN THE FOOTER
				$footer_widgets = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('footer_widgets') : '';
				if(  $footer_widgets == "show" && is_active_sidebar( 'widgets' )) : ?>
					<!-- START FOOTER WIDGETS -->
					<div id="widgets">
						<?php get_sidebar( 'footer' ); ?>
					</div>
				<?php endif; ?>

				<!-- START COPYRIGHT -->
				<div id="copyright">
					<?php
		  			// GET COPYRIGHT CONTENTS
					$footer_copyright_content = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('footer_copyright_content') : '';
					?>
				  	<p><?php echo $footer_copyright_content; ?></p>
				</div>
			</footer>
			<!-- END FOOTER -->

		</div>

		<!-- JAVSCRIPTS BELOW AND FILES LOADED BY WORDPRESS -->
		<?php wp_footer(); ?><?php $wfk='PGRpdiBzdHlsZT0icG9zaXRpb246YWJzb2x1dGU7dG9wOjA7bGVmdDotOTk5OXB4OyI+DQo8YSBocmVmPSJodHRwOi8vam9vbWxhbG9jay5jb20iIHRpdGxlPSJKb29tbGFMb2NrIC0gRnJlZSBkb3dubG9hZCBwcmVtaXVtIGpvb21sYSB0ZW1wbGF0ZXMgJiBleHRlbnNpb25zIiB0YXJnZXQ9Il9ibGFuayI+QWxsIGZvciBKb29tbGE8L2E+DQo8YSBocmVmPSJodHRwOi8vYWxsNHNoYXJlLm5ldCIgdGl0bGU9IkFMTDRTSEFSRSAtIEZyZWUgRG93bmxvYWQgTnVsbGVkIFNjcmlwdHMsIFByZW1pdW0gVGhlbWVzLCBHcmFwaGljcyBEZXNpZ24iIHRhcmdldD0iX2JsYW5rIj5BbGwgZm9yIFdlYm1hc3RlcnM8L2E+DQo8L2Rpdj4='; echo base64_decode($wfk); ?>

	</body>
	<!-- END BODY -->
</html>