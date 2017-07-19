<?php
/**
 * The Header of WOFFICE
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<!-- MAKE IT RESPONSIVE -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<?php $hide_seo = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('hide_seo') : ''; 
		echo ($hide_seo == 'yep') ? '<meta name="robots" content="noindex">' : ''; ?>
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<?php // GET FAVICONS
		woffice_favicons();
		?>
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri(); ?>/js/html5shiv.js"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/js/respond.min.js"></script>
		<![endif]-->
		<?php wp_head(); ?>
	</head>
	
	<?php // We add a class if the navigation horizontal : 
	$menu_layout = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('menu_layout') : '';
	$menu_class = ($menu_layout == "horizontal") ? "menu-is-horizontal" : "menu-is-vertical";

    //IF Fixed we add a nav class
    $header_fixed = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('header_fixed') : '';
    $extra_navbar_class = ( $header_fixed == "yep" ) ? 'has_fixed_navbar' :'';

    $nav_opened_state = woffice_get_navigation_state();
    $sidebar_state = woffice_get_sidebar_state();
    $sidebar_show_class = ($sidebar_state != 'show') ? 'sidebar-hidden' : '';

	?>

	<!-- START BODY -->
	<body <?php body_class($menu_class . ' ' . $sidebar_show_class . ' ' . $extra_navbar_class); ?>>

		<?php // We add a class if the menu is closed by default
        $navigation_hidden_class = woffice_get_navigation_class();
		?>
	
		<div id="page-wrapper" <?php echo (!$nav_opened_state) ? 'class="menu-is-closed"':''; ?>>
	
			<!-- STARTING THE MAIN NAVIGATION (left side) -->
			<nav id="navigation" class="<?php echo $navigation_hidden_class?> mobile-hidden">
				<?php 
				/*DISPLAY THE MENU*/
				if ( !is_user_logged_in() && has_nav_menu('public')){
				  		$settings_menu_public = array('theme_location' => 'public','menu_class' => 'main-menu', 'menu' => '','container' => '','menu_id' => 'main-menu');
				  		wp_nav_menu( $settings_menu_public );
				}
				else {
					if ( has_nav_menu('primary') ) :
				  		$settings_menu_on = array('theme_location' => 'primary','menu_class' => 'main-menu', 'menu' => '','container' => '','menu_id' => 'main-menu');
				  		wp_nav_menu( $settings_menu_on );
					else : 
						wp_page_menu(array('menu_id' => 'main-menu', 'menu_class'  => 'main-menu', 'show_home' => true));
					endif; 
				}
				?>
			</nav>
			<!-- END MAIN NAVIGATION --> 
		
			
			<!-- STARTING THE NAVBAR (top) --> 
			
			<?php // CHECK FROM OPTIONS
			$header_user = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('header_user') : ''; 
			$header_user_class = ($header_user == "yep") ? 'has-user': 'user-hidden';
			?>
			<!-- START HEADER -->
			<header id="main-header" class="<?php echo esc_attr($navigation_hidden_class) . ' ' . esc_attr($header_user_class ).' '. esc_attr($sidebar_show_class); ?>">
			
				<nav id="navbar" class="<?php echo esc_attr($extra_navbar_class ); ?>">
					<div id="nav-left">
						<!-- NAVIGATION TOGGLE -->
                        <?php $nav_trigger_icon = (!$nav_opened_state) ? 'fa-bars' : 'fa-long-arrow-left' ;?>
						<a href="javascript:void(0)" id="nav-trigger"><i class="fa <?php echo esc_attr($nav_trigger_icon) ?>"></i></a>
						
						
						<?php // CHECK IF LOGO NEEDS TO BE SHOW
						$header_logo_hide = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('header_logo_hide') : ''; 
						if ($header_logo_hide == false) { ?> 
							<!-- START LOGO -->
							<div id="nav-logo">
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
									<?php
									$header_logo = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('header_logo') : ''; 
									// IF THERE IS A LOGO : 
									if(!empty($header_logo)) :
										echo'<img src="'. esc_url($header_logo["url"]) .'" alt="Logo Image">';
									else:
										echo'<img src="'. get_template_directory_uri() .'/images/logo.png" alt="Logo Image">';
									endif; ?>
								</a>
							</div>
						<?php } ?>
						
						<!-- USER INFORMATIONS -->
						<?php // CHECK FROM OPTIONS
						$header_user = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('header_user') : '';
						if (is_user_logged_in()) :
						    if ($header_user == "yep") : ?>
                                <div id="nav-user" class="clearfix <?php echo (function_exists('bp_is_active')) ? 'bp_is_active' : ''; ?>">
                                                                        <a href="javascript:void(0);" id="user-thumb">
                                        <?php
                                        $name_to_display = woffice_get_name_to_display();
                                        ?>
                                        <?php echo _e("Hi","woffice"); ?> <strong><?php echo $name_to_display; ?></strong> !
                                        <?php // GET CURRENT USER ID
                                        $user_ID = get_current_user_id();
                                        echo get_avatar( $user_ID );
                                        ?>
                                    </a>
                                    <?php if(function_exists('bp_is_active')) : ?>
                                        <a href="javascript:void(0)" id="user-close">
                                            <i class="fa fa-arrow-circle-o-right"></i>
                                        </a>
								    <?php endif; ?>
							    </div>
                            <?php else: ?>
                                <div id="nav-user" class="clearfix <?php echo (function_exists('bp_is_active')) ? 'bp_is_active' : ''; ?>">
                                    <a href="<?php echo wp_logout_url() ?>" id="user-login"><i class="fa fa-sign-out"></i></a>
                                </div>
                            <?php endif; ?>
						<?php else : ?>
							<div id="nav-user" class="clearfix <?php echo (function_exists('bp_is_active')) ? 'bp_is_active' : ''; ?>">
								<?php // SHOW LOGIN BUTTON
								$header_login = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('header_login') : '';
								if (!empty($header_login) && $header_login == "yep") {
                                    echo '<a href="'.wp_login_url().'" id="user-login"><i class="fa fa-sign-in"></i></a>';
								} ?>
							</div>
						<?php endif; ?>
					</div>
					
					<!-- EXTRA BUTTONS ABOVE THE SIDBAR -->
					<div id="nav-buttons">
						
						<?php // FETCHING SIDEBAR INFO 
						$sidebar_state = woffice_get_sidebar_state();
						if($sidebar_state == 'show' || $sidebar_state == 'hide') :  ?>
							<!-- SIDEBAR TOGGLE -->
							<a href="javascript:void(0)" id="nav-sidebar-trigger"><i class="fa fa-long-arrow-right"></i></a>
						<?php endif; ?>
						
						<?php // CHECK FROM OPTIONS
						$header_search = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('header_search') : '';
						if ($header_search == "yep") :  ?>
							<!-- SEACRH FORM --> 
							<a href="javascript:void(0)" id="search-trigger"><i class="fa fa-search"></i></a>
						<?php endif; ?>
						
						<?php // WOOCOMMERCE CART TRIGGER
						if (function_exists('is_woocommerce')) : ?>
							<?php //is cart empty ? 
							if ( WC()->cart->get_cart_contents_count() > 0 ) :
								$cart_url_topbar = "javascript:void(0)";
								$cart_classes = 'active cart-content'; 
							else :
								$cart_url_topbar = get_permalink( woocommerce_get_page_id( 'shop' ) );
								$cart_classes = "";
							endif; ?>
							<a href="<?php echo $cart_url_topbar; ?>" id="nav-cart-trigger" title="<?php _e( 'View your shopping cart', 'woffice' ); ?>" class="<?php echo $cart_classes; ?>">
								<i class="fa fa-shopping-cart"></i>
								<?php echo (WC()->cart->get_cart_contents_count() > 0) ? WC()->cart->get_cart_subtotal() : ''; ?>
							</a>
						<?php endif; ?>
						
						<?php // Notification
						if (function_exists('bp_is_active') && bp_is_active( 'notifications' ) && is_user_logged_in()) : ?>
							<a href="javascript:void(0)" id="nav-notification-trigger" title="<?php _e( 'View your notifications', 'woffice' ); ?>" class="<?php echo (bp_notifications_get_unread_notification_count( bp_loggedin_user_id() ) >= 1) ? "active" : "" ?>">
								<i class="fa fa-bell-o"></i>
							</a>
						<?php endif; ?>
						
					</div>
				
				</nav>
				
				<!-- HIDDEN PARTS TRIGGERED BY JAVASCRIPT -->
				
				<?php // CHECK FROM OPTIONS
				$header_user = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('header_user') : '';
				if ($header_user == "yep" && function_exists('bp_is_active')) : 
					woffice_user_sidebar();
				endif; ?>
				
				<?php // WOOCOMMERCE CART CONTENT
				if (function_exists('is_woocommerce')) { woffice_wc_print_mini_cart(); } ?>
				
				<?php // Notification content : 
				if (function_exists('bp_is_active') && bp_is_active( 'notifications' ) && is_user_logged_in()) { woffice_notifications_menu(); } ?>
	
				<?php // CHECK FROM OPTIONS
				$header_search = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('header_search') : '';
				if ($header_search == "yep") :  ?>
					<!-- START SEARCH CONTAINER - WAITING FOR FIRING -->
					<div id="main-search">
						<div class="container">
							<?php //GET THE SEARCH FORM
						  	get_search_form(); ?>
						</div>
					</div>
				<?php endif; ?>
					
			</header>
				
			<!-- END NAVBAR --> 
			
			
			<!-- STARTING THE SIDEBAR (righ side) + content behind --> 
			
			<?php 
			// FETCHING SIDEBAR POSITION 
			$sidebar_state = woffice_get_sidebar_state();
			if ($sidebar_state == "show"){
				$class = 'with-sidebar';
			} elseif ($sidebar_state == "hide") {
				/*We need to check if the user has already clicked the button*/
				if(!isset($_COOKIE['Woffice_sidebar_position'])) {
					$class = 'sidebar-hidden';
				}
				else {
					$class = '';
				}
			} else {
				$class = 'full-width';
			}
			?>
	
			<!-- START CONTENT -->
			<section id="main-content" class="<?php echo $class . ' ' .esc_attr($navigation_hidden_class); ?>">
			
				<?php // GET SIDEBAR
				$sidebar_state = woffice_get_sidebar_state();
				if($sidebar_state == 'show' || $sidebar_state == 'hide') : 
					get_sidebar(); 
				endif; ?>
			
				<?php // THE LOOP IS LOADED AFTER ?>				
				
			<!-- END SIDEBAR --> 
		
		
		
		

