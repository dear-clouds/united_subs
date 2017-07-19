<?php
/**
* Template Name: Login
*/
?>
<?php
// IF USER IS ALREADY LOGGED -> REDIRECT HIM TO HOME PAGE
if (is_user_logged_in()) : 	
	wp_redirect( home_url() ); 
	exit;
else :
	// We get the logo image
	$login_logo_image = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('login_logo_image') : '';

?>
<html <?php language_attributes(); ?> style="margin-top: 0 !important;">
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<!-- MAKE IT RESPONSIVE -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<?php // GET FAVICONS
		woffice_favicons();
		?>
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri(); ?>/js/html5shiv.js"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/js/respond.min.js"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/js/flexie.min.js"></script>
		<![endif]-->
		<?php wp_head(); ?>
	</head>
	
	<body <?php body_class(); ?>>
	
		<div id="page-wrapper">
			<div id="content-container">
	
				<!-- START CONTENT -->
				<section id="woffice-login">
				
					<div id="woffice-login-left">
					</div>
					
					<div id="woffice-login-right">
						<!-- LOGO & DESCRIPTION -->
						<header>
							<?php if (!empty($login_logo_image)) { ?>
								<a href="<?php echo home_url(); ?>" id="login-logo"><img src='<?php echo $login_logo_image["url"]; ?>'/></a>
							<?php } ?>
							
							<?php // THE ERRORS
							$login  = (isset($_GET['login']) ) ? $_GET['login'] : 0;
							$color_notifications = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('color_notifications') : '';

                            //Display default message for plugin New User Approve
                            if(class_exists('pw_new_user_approve')) {
                                if((is_string($login) && $login == 'pending_approval')) {
                                    echo'<div class="infobox fa-meh-o" style="background-color: '.$color_notifications.';">';
                                    echo'<span class="infobox-head"><i class="fa fa-exclamation-triangle"></i> '. __('ERROR:','woffice').'</span>';
                                    echo'<p>'. __('Your account is still pending approval.','woffice') .'</p>';
                                    echo'</div>';
                                } else {
                                    echo'<div class="infobox" style="background-color: '.$color_notifications.';">';
                                    echo'<p>'. __('This site is accessible to approved users only. To be approved, you must first register.','woffice') .'</p>';
                                    echo'</div>';
                                }
                            }

							if ( $login === "failed" ) {
								echo'<div class="infobox fa-meh-o" style="background-color: '.$color_notifications.';">';
									echo'<span class="infobox-head"><i class="fa fa-exclamation-triangle"></i> '. __('ERROR:','woffice').'</span>';
									echo'<p>'. __('Invalid username and/or password.','woffice') .'</p>';
								echo'</div>';
							} elseif ( $login === "empty" ) {
								echo'<div class="infobox fa-meh-o" style="background-color: '.$color_notifications.';">';
									echo'<p>'. __('Username and/or Password is empty.','woffice') .'</p>';
								echo'</div>';
							} elseif ( $login === "false" ) {
								$color_notifications_green = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('color_notifications_green') : '';
								echo'<div class="infobox fa-check-circle-o" style="background-color: '.$color_notifications_green.';">';
									echo'<span class="infobox-head"><i class="fa fa-check-circle-o"></i> '. __('Success:','woffice').'</span>';
									echo'<p>'. __('You are logged out.','woffice') .'</p>';
								echo'</div>';
							}
							?>
							
							<?php // GET & DISPLAY LOGIN TEXT 
							$login_text = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('login_text') : ''; 
							if (!empty($login_text)):
								echo"<p>".$login_text."</p>";
							endif; ?>
						
							<?php /* GOOGLE LOGIN */
							if (function_exists('woffice_glogin_frontend')){
								woffice_glogin_frontend();
							} ?>
							
						</header>
						
						<!-- FORM -->
						<?php
						// CHECKING FOR OTHER FORMS FIRST	
						$type = (isset($_GET['type'])) ? $_GET['type'] : "";
						if ($type == "lost-password") {
							//
							// THE RESET PASSWORD FORM
							//
							// https://code.tutsplus.com/tutorials/build-a-custom-wordpress-user-flow-part-3-password-reset--cms-23811
							
							$color_notifications = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('color_notifications') : ''; 							
							echo'<div class="infobox fa-meh-o" style="background-color: '.$color_notifications.';">';

								if ( isset( $_REQUEST['errors'] ) ) {
								    $error_codes = explode( ',', $_REQUEST['errors'] );
								 
								    foreach ( $error_codes as $error_code ) {
									   	switch ( $error_code ) {
											// Lost password
											case 'empty_username':
												$message_error =  __( 'You need to enter your email address to continue.', 'personalize-login' );
											case 'invalid_email':
											case 'invalidcombo':
												$message_error = __( 'There are no users registered with this email address.', 'personalize-login' );
											// Reset password
											/*case 'expiredkey':
											case 'invalidkey':
												$message_error = __( 'The password reset link you used is not valid anymore.', 'personalize-login' );
											case 'password_reset_mismatch':
												$message_error = __( "The two passwords you entered don't match.", 'personalize-login' );
											case 'password_reset_empty':
												$message_error = __( "Sorry, we don't accept empty passwords.", 'personalize-login' );
											default:
												break;*/
										}
										echo'<p>'.$message_error.'</p>';
								    }
								} else {
									echo'<span class="infobox-head">'. __('Forgot Your Password ? ','woffice').'</span>';
									echo'<p>'. __('Enter your email address and we\'ll send you a link you can use to pick a new password.','woffice') .'</p>';
								}
							
							echo'</div>';
							
							?>
							
								<form id="lostpasswordform" action="<?php echo wp_lostpassword_url(); ?>" class="clearfix" method="post">
							        <p class="form-row">
							            <label for="user_login"><?php _e( 'Email', 'woffice' ); ?>
							            <input type="text" name="user_login" id="user_login">
							        </p>
							 
							        <p class="lostpassword-submit">
							            <input type="submit" name="submit" class="lostpassword-button"
							                   value="<?php _e( 'Reset Password', 'woffice' ); ?>"/>
							        </p>
							    </form>
								
							<?php 
														
						} else {
							//
							// THE LOGIN FORM
							//
							if ( isset( $_REQUEST['checkemail'] ) && $_REQUEST['checkemail'] == 'confirm' ) : ?>
								<p class="login-info">
						        <?php _e( 'Check your email for a link to reset your password.', 'woffice' ); ?>
						    </p>
						    <?php endif; 
							
							$aft_login = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('aft_login') : ''; 
							$custom_redirect_url = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('custom_redirect_url') : ''; 
							if($aft_login == "custom") {
								$redirect_url = $custom_redirect_url;
							} elseif ($aft_login == "previous") {
								$redirect_url = site_url( $_SERVER['REQUEST_URI'] );
							} else {
								$redirect_url = home_url();
							}
							
							$login_args = array(
								'redirect' => $redirect_url, 
								'id_username' => 'user',
								'id_password' => 'pass',
							);
							wp_login_form( $login_args );
							// LOST PASSWORD LINK 
							$login_rest_password = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('login_rest_password') : ''; 
							if ($login_rest_password == "yep"){
								echo '<a href="'. wp_lostpassword_url() .'" class="password-lost">'. __('Lost Password','woffice') .'</a>';	
							}
							
						}
						?>
						
						<?php 
						/* REGISTER FORM */
						if (get_option('users_can_register') == '1'){
							$register_message = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('register_message') : ''; 
							echo '<div id="register-wrapper">';
							echo '<p>'.$register_message.'</p>';
							
							// Check for paid membership pro
							$register_pmp = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('register_pmp') : ''; 
							if ( $register_pmp == "yep" && function_exists("pmpro_getOption") ){
								$register_page = get_permalink(pmpro_getOption("levels_page_id"));
								echo '<a href="'.$register_page.'" class="btn btn-default" id="register-trigger"><i class="fa fa-sign-in"></i> '. __('Sign Up','woffice') .'</a>';			
							} else {
								echo '<a href="#register-form" class="btn btn-default" id="register-trigger"><i class="fa fa-sign-in"></i> '. __('Sign Up','woffice') .'</a>';
							}
							
							echo '</div>';
							echo '<div id="register-loader" class="intern-padding woffice-loader"><i class="fa fa-spinner"></i></div>';
							echo do_shortcode('[woffice_registration_form]');
							echo '<div id="goback-trigger"><a href="#loginform" class="btn btn-default"><i class="fa fa-arrow-left"></i> '. __('Go back','woffice') .'</a></div>';
						}
							
						?>
						
						
						<?php // DISPLAY WORDPRESS LINK ? 
						$login_wordpress = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('login_wordpress') : ''; 
						if ($login_wordpress == "yep"):
						?>
							<footer>
								<p>
									<?php _e("Proudly powered by","woffice"); ?> 
									<a href="https://wordpress.org/" target="_blank">
										<img src="<?php echo home_url(); ?>/wp-admin/images/wordpress-logo.svg" alt="wordpress logo">
									</a>
								</p>
							</footer>
						<?php endif; ?>
					</div>
					
				</section>
				<!-- END CONTENT -->
				
			</div>
		</div>
		
		<!-- JAVSCRIPTS BELOW AND FILES LOADED BY WORDPRESS -->
		
		<script type="text/javascript">
			if (jQuery('#success-register').length  > 0) {
				jQuery('#register-loader').slideDown();
				jQuery("#register-form, #goback-trigger").hide();
		    	function show_login() {
			    	jQuery("#loginform, #register-wrapper,a.password-lost").show();
					jQuery('#register-loader').slideUp();
				}
				setTimeout(show_login, 1000);
			}
			jQuery("#register-loader, #register-form, #goback-trigger").hide();
			jQuery("#register-trigger").on('click', function(){
		    	jQuery('#register-loader').slideDown();
				jQuery("#loginform, #register-wrapper,a.password-lost").hide();
		    	function show_register() {
			    	jQuery("#register-form, #goback-trigger").show();
					jQuery('#register-loader').slideUp();
				}
				setTimeout(show_register, 1000);
			});
			jQuery("#goback-trigger a").on('click', function(){
		    	jQuery('#register-loader').slideDown();
				jQuery("#register-form, #goback-trigger").hide();
		    	function show_login() {
			    	jQuery("#loginform, #register-wrapper,a.password-lost").show();
					jQuery('#register-loader').slideUp();
				}
				setTimeout(show_login, 1000);
			});
			var hash = location.hash.replace('#', '');
			if (hash == 'register-form') {
				if (jQuery('#success-register').length  == 0) {
					jQuery('#register-loader').slideDown();
					jQuery("#loginform, #register-wrapper,a.password-lost").hide();
			    	function show_register() {
				    	jQuery("#register-form").show();
						jQuery('#register-loader').slideUp();
					}
					setTimeout(show_register, 1000);
				}
			}
		</script>
		
		<?php wp_footer(); ?>
	</body>
</html>
<?php endif; ?>