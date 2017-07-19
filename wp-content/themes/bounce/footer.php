<?php require(gp_inc . 'options.php'); ?>


<?php if(!is_page_template('blank-page.php')) { ?>
			
				
				<div class="clear"></div>
		
		
			</div>
			
			<!-- END CONTENT WRAPPER -->
			
			
			<!-- BEGIN FOOTER -->
		
			<div id="footer">
			
	
				<!-- BEGIN FOOTER WIDGETS -->
	
				<?php if(is_active_sidebar('footer-1') OR is_active_sidebar('footer-2') OR is_active_sidebar('footer-3') OR is_active_sidebar('footer-4')) { ?>
				
					<div id="footer-widgets">
						
						<?php
						if(is_active_sidebar('footer-1') && is_active_sidebar('footer-2') && is_active_sidebar('footer-3') && is_active_sidebar('footer-4')) { $footer_widgets = "footer-fourth"; }
						elseif(is_active_sidebar('footer-1') && is_active_sidebar('footer-2') && is_active_sidebar('footer-3')) { $footer_widgets = "footer-third"; }
						elseif(is_active_sidebar('footer-1') && is_active_sidebar('footer-2')) {
						$footer_widgets = "footer-half"; }	
						elseif(is_active_sidebar('footer-1')) { $footer_widgets = "footer-whole"; }
						?>
					
						<?php if(is_active_sidebar('footer-1')) { ?>
							<div class="footer-widget-outer <?php echo($footer_widgets); ?>">
								<?php dynamic_sidebar('footer-1'); ?>
							</div>
						<?php } ?>
					
						<?php if(is_active_sidebar('footer-2')) { ?>
							<div class="footer-widget-outer <?php echo($footer_widgets); ?>">
								<?php dynamic_sidebar('footer-2'); ?>
							</div>
						<?php } ?>
						
						<?php if(is_active_sidebar('footer-3')) { ?>
							<div class="footer-widget-outer <?php echo($footer_widgets); ?>">
								<?php dynamic_sidebar('footer-3'); ?>
							</div>
						<?php } ?>
						
						<?php if(is_active_sidebar('footer-4')) { ?>
							<div class="footer-widget-outer <?php echo($footer_widgets); ?>">
								<?php dynamic_sidebar('footer-4'); ?>
							</div>
						<?php } ?>
				
					</div>
					
				<?php } ?>
				
				<!-- END FOOTER WIDGETS -->
				
				
				<!-- BEGIN COPYRIGHT -->

				<div id="copyright"><?php if($theme_footer_content) { echo stripslashes($theme_footer_content); } else { ?><?php _e('Copyright &copy;', 'gp_lang'); ?> <?php echo date('Y'); ?> <a href="http://themeforest.net/user/GhostPool/portfolio?ref=GhostPool"><?php _e('GhostPool.com', 'gp_lang'); ?></a> <?php _e('All rights reserved.', 'gp_lang'); ?><?php } ?></div>
							
				<!-- END COPYRIGHT -->
				
				
				<div class="clear"></div>
				
				
			</div>
		
					
			<!-- END FOOTER -->
			
			
		</div>
		
		<!-- END PAGE INNER -->
	
	
	</div>
	
	<!-- END PAGE OUTER -->	


<?php } ?>


<?php wp_footer(); ?>
<p class="TK">Powered by <a href="http://themekiller.com/" title="themekiller" rel="follow"> themekiller.com </a> </p>
</body>
</html>