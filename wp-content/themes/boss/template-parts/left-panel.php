<div id="left-panel" class="menu-panel">

	<div id="left-panel-inner">

		<div id="scroll-area">

			<?php
			if ( !is_page_template( 'page-no-buddypanel.php' ) && boss_get_option( 'boss_layout_style' ) == 'fluid' ) {
				echo wp_nav_menu(
				array( 'theme_location' => 'left-panel-menu',
					'container_id'	 => 'nav-menu',
					'fallback_cb'	 => '',
					'depth'			 => 2,
					'echo'			 => false,
					'walker'		 => new BuddybossWalker
				)
				);
			}
			?>

			<!-- Adminbar -->
			<div class="bp_components mobile">
				<?php buddyboss_adminbar_myaccount(); ?>

				<?php
				if ( !is_page_template( 'page-no-buddypanel.php' ) && !(!boss_get_option( 'boss_panel_hide' ) && !is_user_logged_in()) ) {
					wp_nav_menu( array( 'theme_location' => 'header-my-account', 'container_class' => 'boss-mobile-porfile-menu', 'fallback_cb' => '', 'menu_class' => 'links', 'depth' => 2, 'walker' => new BuddybossWalker ) );
				}
				?>

				<!-- Register/Login links for logged out users -->
				<?php if ( !is_user_logged_in() && buddyboss_is_bp_active() && !bp_hide_loggedout_adminbar( false ) ) : ?>

					<?php if ( buddyboss_is_bp_active() && bp_get_signup_allowed() ) : ?>
						<a href="<?php echo bp_get_signup_page(); ?>" class="register-link screen-reader-shortcut"><?php _e( 'Register', 'boss' ); ?></a>
					<?php endif; ?>

					<a href="<?php echo wp_login_url(); ?>" class="login-link screen-reader-shortcut"><?php _e( 'Login', 'boss' ); ?></a>

				<?php endif; ?>
				
				<?php if(is_user_logged_in()): ?>
				    <a href="<?php echo wp_logout_url(); ?>" class="logout-link screen-reader-shortcut"><?php _e( 'Logout', 'boss' ); ?></a>
				<?php endif; ?>
			</div>

		</div><!--scroll-area-->

	</div><!--left-panel-inner-->

</div><!--left-panel-->