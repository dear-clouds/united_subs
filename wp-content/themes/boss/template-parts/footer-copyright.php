<?php
$boss_copyright	 = boss_get_option( 'boss_copyright' );
$show_copyright	 = boss_get_option( 'footer_copyright_content' );

if ( $show_copyright && $boss_copyright ) {
	?>

	<div class="footer-credits <?php if ( !has_nav_menu( 'secondary-menu' ) ) : ?>footer-credits-single<?php endif; ?>">
		<?php echo $boss_copyright; ?>
	</div>

	<?php
}