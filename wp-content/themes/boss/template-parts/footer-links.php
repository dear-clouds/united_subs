<div id="footer-links">

	<?php if ( has_nav_menu( 'secondary-menu' ) ) : ?>
		<ul class="footer-menu">
			<?php wp_nav_menu( array( 'container' => false, 'menu_id' => 'nav', 'theme_location' => 'secondary-menu', 'items_wrap' => '%3$s', 'depth' => -1 ) ); ?>
		</ul>
	<?php endif; ?>

	<?php get_template_part( 'template-parts/footer-social-links' ); ?>

	<?php if ( boss_get_option( 'boss_layout_switcher' ) ) { ?>

		<form id="switch-mode" name="switch-mode" method="post">
			<input type="submit" value="View as Desktop" tabindex="1" id="switch_submit" name="submit" />
			<input type="hidden" id="switch_mode" name="switch_mode" value="desktop" />
			<?php wp_nonce_field( 'switcher_action', 'switcher_nonce_field' ); ?>
		</form>

	<?php } else { ?>

		<a href="#scroll-to" class="to-top fa fa-angle-up scroll"></a>

	<?php } ?>

</div>