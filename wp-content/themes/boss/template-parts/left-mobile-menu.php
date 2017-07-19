<div id="mobile-menu" class="menu-panel">

	<div id="mobile-menu-inner" data-titlebar="<?php echo (boss_get_option( 'boss_titlebar_position' )) ? boss_get_option( 'boss_titlebar_position' ) : 'top'; ?>">

		<?php
		if ( !is_page_template( 'page-no-buddypanel.php' ) && !(!boss_get_option( 'boss_panel_hide' ) && !is_user_logged_in()) ) {
			echo wp_nav_menu(
			array(
				'theme_location' => 'left-panel-menu',
				'container_id'	 => 'nav-menu',
				'fallback_cb'	 => '',
				'depth'			 => 2,
				'echo'			 => false,
				'walker'		 => new BuddybossWalker
			) );
		}
		?>

	</div>

</div> <!-- #mobile-menu -->