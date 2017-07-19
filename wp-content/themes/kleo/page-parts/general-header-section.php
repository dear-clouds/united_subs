<?php
/**
 * Header section of our theme
 *
 * Displays all of the <div id="header"> section
 *
 * @package WordPress
 * @subpackage Kleo
 * @since Kleo 1.0
 */

//set logo path
$logo_path = sq_option_url( 'logo' );
$logo_path = apply_filters( 'kleo_logo', $logo_path );
$social_icons = apply_filters( 'kleo_show_social_icons', sq_option( 'show_social_icons', 1 ) );
$top_bar = sq_option( 'show_top_bar', 1 );
$top_bar = apply_filters( 'kleo_show_top_bar', $top_bar );

$top_menu = wp_nav_menu( array(
        'theme_location'    => 'top',
        'depth'             => 2,
        'container'         => 'div',
        'container_class'   => 'top-menu col-xs-12 col-sm-7 no-padd',
        'menu_class'        => '',
        'fallback_cb'       => '',
        'walker'            => new kleo_walker_nav_menu(),
        'echo'              => false
    )
);

$primary_menu = wp_nav_menu( array(
        'theme_location'    => 'primary',
        'depth'             => 3,
        'container'         => 'div',
        'container_class'   => 'collapse navbar-collapse nav-collapse',
        'menu_class'        => 'nav navbar-nav',
        //'fallback_cb'       => 'kleo_walker_nav_menu::fallback',
        'fallback_cb'       => '',
        'walker'            => new kleo_walker_nav_menu(),
        'echo'              => false
    )
);

?>

<div id="header" class="header-color">

	<div class="navbar" role="navigation">

		<?php if ( $top_bar == 1 ) : /* top bar enabled */ ?>

			<!--Attributes-->
			<!--class = social-header inverse-->
			<div class="social-header header-color">
				<div class="container">
					<div class="top-bar">

						<?php
						$social_icons_data  = kleo_get_social_profiles();
						$social_icons_class = '';

						//empty data or disabled social icons
						if ( ! $social_icons || ! $social_icons_data ) {
							$social_icons_class = ' hidden-xs hidden-sm';
						}
						?>
						<div id="top-social" class="col-xs-12 col-sm-5 no-padd<?php echo $social_icons_class; ?>">
							<?php if ( $social_icons == 1 ) {
								echo $social_icons_data;
							} ?>
						</div>

						<?php
						// Top menu
						echo $top_menu;
						?>

					</div><!--end top-bar-->
				</div>
			</div>

		<?php endif; /* end top bar condition */ ?>

		<?php
		$header_style = sq_option( 'header_layout', 'normal' );
		if ( $header_style == 'right_logo' ) {
			$header_class = ' logo-to-right';
		} elseif ( $header_style == 'center_logo' ) {
			$header_class = ' header-centered';
		} elseif ( $header_style == 'left_logo' ) {
			$header_class = ' header-left';
		} else {
			$header_class = ' header-normal';
		}
		?>
		<div class="kleo-main-header<?php echo $header_class; ?>">
			<div class="container">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<div class="kleo-mobile-switch">

						<?php
						$mobile_menu_atts = 'class="navbar-toggle" data-toggle="collapse" data-target=".nav-collapse"';
						/* open the Side menu instead of the normal menu */
						if ( sq_option( 'side_menu', 0 ) == 1 && sq_option( 'side_menu_mobile', 0 ) == 1 ) {
							$mobile_menu_atts = 'class="navbar-toggle open-sidebar"';
						}
						?>
						<button type="button" <?php echo $mobile_menu_atts; ?>>
							<span class="sr-only"><?php esc_html_e( "Toggle navigation", 'kleo_framework' ); ?></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>

					</div>

					<div class="kleo-mobile-icons">

						<?php
						/** kleo_mobile_header_icons - action
						 * You can put here various icons using this action
						 *
						 * @hooked kleo_bp_mobile_notify - 9
						 * @hooked kleo_woo_mobile_icon - 10
						 */
						do_action( 'kleo_mobile_header_icons' );
						?>

					</div>

					<strong class="logo">
						<a href="<?php echo home_url(); ?>">

							<?php if ( $logo_path != '' ) { ?>

								<img id="logo_img" title="<?php bloginfo( 'name' ); ?>" src="<?php echo $logo_path; ?>"
								     alt="<?php bloginfo( 'name' ); ?>">

							<?php } else { ?>

								<?php bloginfo( 'name' ); ?>

							<?php } ?>

						</a>
					</strong>
				</div>

				<?php if ( $header_style == 'left_logo' ) : ?>
					<div class="header-banner">
						<?php echo do_shortcode( sq_option( 'header_banner', '' ) ); ?>
					</div>
				<?php endif; ?>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<?php
				// Main menu
				echo $primary_menu;
				?>
			</div><!--end container-->
		</div>
	</div>

</div><!--end header-->