<?php
global $rtl;
$header_style = boss_get_option('boss_header');
$boxed = boss_get_option( 'boss_layout_style' );

if ( 'fluid' == $boxed || '2' == $header_style ) {
	?>
	<div class="<?php echo ($rtl) ? 'right-col' : 'left-col'; ?>">

		<div class="table">

			<div class="header-links">
				<?php if ( !is_page_template( 'page-no-buddypanel.php' ) && !(!boss_get_option( 'boss_panel_hide' ) && !is_user_logged_in()) ) { ?>

					<!-- Menu Button -->
					<a href="#" class="menu-toggle icon" id="left-menu-toggle" title="<?php _e( 'Menu', 'boss' ); ?>">
						<i class="fa fa-bars"></i>
					</a><!--.menu-toggle-->

				<?php } ?>

			</div><!--.header-links-->

            <?php if( '2' == $header_style ): ?>
            <?php get_template_part( 'template-parts/header-middle-column' ); ?>
            <?php else: ?>
			<!-- search form -->
			<div id="header-search" class="search-form">
				<?php
				echo get_search_form();
				?>
			</div><!--.search-form-->
            <?php endif; ?>
		</div>

	</div><!--.left-col-->
	<?php
}