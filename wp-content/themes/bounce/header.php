<!DOCTYPE html>
<!--[if !IE]><!-->
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?> class="no-js">
<!--<![endif]-->
<!--[if IE 9]>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?> class="no-js ie9">
<![endif]-->
<!--[if IE 8]>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?> class="no-js ie8">
<![endif]-->
<head>
<meta charset=<?php bloginfo('charset'); ?> />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php require(gp_inc . 'options.php'); ?>
<?php if ( file_exists( gp_child_inc . '/page-settings.php' ) ) {
	require_once( gp_child_inc . '/page-settings.php' );
} elseif ( file_exists( gp_inc . '/page-settings.php' ) ) {
	require_once( gp_inc . '/page-settings.php' );
} ?>
<?php global $dirname; ?>
<?php if(get_option($dirname.'_responsive') == "0") { ?><meta name="viewport" content="width=device-width, initial-scale=1"><?php } ?>
<?php wp_head(); ?>
</head>

<?php global $gp_settings, $dirname; ?>

<body <?php body_class($gp_settings['layout'].' '.$gp_settings['padding'].' '.$gp_settings['frame'].' '.$gp_settings['skin']); ?>>
 
 
<!-- BEGIN HEADER OUTER -->

<?php if(!is_page_template('blank-page.php')) { ?>


	<div id="header-outer" class="page-outer">
		
		
		<!-- BEGIN PAGE INNER -->
		
		<div class="page-inner">	
	
			
			<!-- BEGIN LOGIN/REGISTER LINKS -->
			
			<?php if($theme_bp_links == "0" && function_exists('bp_is_active')) { ?>
			
				<div id="bp-links">
				
					<?php if(is_user_logged_in()) { ?>	
										
						<a href="<?php echo wp_logout_url(esc_url($_SERVER['REQUEST_URI'])); ?>" class="bp-logout-link"><?php _e('Logout', 'gp_lang'); ?></a>
	
					<?php } else { ?>
						
						<a href="<?php if($theme_login_url) { echo $theme_login_url; } else { echo wp_login_url(); } ?>" class="bp-login-link"><?php _e('Login', 'gp_lang'); ?></a>
						
						<?php if(bp_get_signup_allowed()) { ?><a href="<?php echo bp_get_signup_page(false); ?>" class="bp-register-link"><?php _e('Register', 'gp_lang'); ?></a><?php } ?>
						
					<?php } ?>
				
				</div>
				
				<div class="clear"></div>
				
			<?php } ?>
			
			<!-- END LOGIN/REGISTER LINKS -->
			
					
			<!-- BEGIN HEADER INNER -->
			
			<div id="header-inner">		
			
				
				<!-- BEGIN HEADER LEFT -->
				
				<div id="header-left">
				
					
					<!-- BEGIN LOGO -->
					
					<<?php if($gp_settings['title'] == "Show") { ?>div<?php } else { ?>h1<?php } ?> id="logo" style="<?php if($theme_logo_top) { ?> margin-top: <?php echo $theme_logo_top; ?>px;<?php } ?><?php if($theme_logo_left) { ?> margin-left: <?php echo $theme_logo_left; ?>px;<?php } ?><?php if($theme_logo_bottom) { ?> margin-bottom: <?php echo $theme_logo_bottom; ?>px;<?php } ?>">
						
						<?php if($theme_logo) { ?>
							<a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>"><img src="<?php echo($theme_logo); ?>"<?php if(get_option($dirname.'_logo_width')) { ?> width="<?php echo get_option($dirname.'_logo_width'); ?>"<?php } ?><?php if(get_option($dirname.'_logo_height')) { ?> height="<?php echo get_option($dirname.'_logo_height'); ?>"<?php } ?> alt="<?php bloginfo('name'); ?>" /></a>
						<?php } else { ?>
							<a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>"><span class="default-logo"></span></a>
						<?php } ?>
						
					</<?php if($gp_settings['title'] == "Show") { ?>div<?php } else { ?>h1<?php } ?>>
					
					<!-- END LOGO -->
					
				
				</div>
				
				<!-- END HEADER LEFT -->
				
				
				<!-- BEGIN HEADER RIGHT -->
				
				<div id="header-right">
					

					<!-- BEGIN CONTACT INFO -->
									
					<?php if($theme_contact_info) { ?>
						<div id="contact-info">
							<?php echo do_shortcode(stripslashes($theme_contact_info)); ?>
						</div>
					<?php } ?>
					
					<!-- END CONTACT INFO -->
				
									
					<!-- BEGIN NAV -->
					
					<div id="nav">
					
						<?php wp_nav_menu('sort_column=menu_order&container=ul&theme_location=header-nav&fallback_cb=null'); ?>
						
						<?php wp_nav_menu(array('theme_location' => 'header-nav', 'items_wrap' => '<select class="mobile-menu">%3$s</select>', 'container' => '', 'menu_class' => 'mobile-menu', 'sort_column' => 'menu_order', 'fallback_cb' => 'null', 'walker' => new gp_mobile_menu)); ?>
								
						
						<!-- BEGIN SOCIAL ICONS -->
											
						<span id="social-icons">
						
							<?php if($theme_rss_button == "1") {} else { ?><a href="<?php if($theme_rss) { ?><?php echo($theme_rss); ?><?php } else { ?><?php bloginfo('rss2_url'); ?><?php } ?>" class="rss-icon" title="<?php _e('RSS Feed', 'gp_lang'); ?>" rel="nofollow" target="_blank"></a><?php } ?>
							
							<?php if($theme_twitter) { ?><a href="<?php echo $theme_twitter; ?>" class="twitter-icon" title="<?php _e('Twitter', 'gp_lang'); ?>" rel="nofollow" target="_blank"></a><?php } ?>
							
							<?php if($theme_facebook) { ?><a href="<?php echo $theme_facebook; ?>" class="facebook-icon" title="<?php _e('Facebook', 'gp_lang'); ?>" rel="nofollow" target="_blank"></a><?php } ?>
							
							<?php if($theme_digg) { ?><a href="<?php echo $theme_digg; ?>" class="digg-icon" title="<?php _e('Digg', 'gp_lang'); ?>" rel="nofollow" target="_blank"></a><?php } ?>
						
							<?php if($theme_delicious) { ?><a href="<?php echo $theme_delicious; ?>" class="delicious-icon" title="<?php _e('Delicious', 'gp_lang'); ?>" rel="nofollow" target="_blank"></a><?php } ?>
				
							<?php if($theme_dribbble) { ?><a href="<?php echo $theme_dribbble; ?>" class="dribbble-icon" title="<?php _e('Dribbble', 'gp_lang'); ?>" rel="nofollow" target="_blank"></a><?php } ?>
							
							<?php if($theme_youtube) { ?><a href="<?php echo $theme_youtube; ?>" class="youtube-icon" title="<?php _e('YouTube', 'gp_lang'); ?>" rel="nofollow" target="_blank"></a><?php } ?>
				
							<?php if($theme_vimeo) { ?><a href="<?php echo $theme_vimeo; ?>" class="vimeo-icon" title="<?php _e('Vimeo', 'gp_lang'); ?>" rel="nofollow" target="_blank"></a><?php } ?>
		
							<?php if($theme_linkedin) { ?><a href="<?php echo $theme_linkedin; ?>" class="linkedin-icon" title="<?php _e('LinkedIn', 'gp_lang'); ?>" rel="nofollow" target="_blank"></a><?php } ?>
							
							<?php if($theme_googleplus) { ?><a href="<?php echo $theme_googleplus; ?>" class="googleplus-icon" title="<?php _e('Google+', 'gp_lang'); ?>" rel="nofollow" target="_blank"></a><?php } ?>
												
							<?php if($theme_myspace) { ?><a href="<?php echo $theme_myspace; ?>" class="myspace-icon" title="<?php _e('MySpace', 'gp_lang'); ?>" rel="nofollow" target="_blank"></a><?php } ?>
													
							<?php if($theme_flickr) { ?><a href="<?php echo $theme_flickr; ?>" class="flickr-icon" title="<?php _e('Flickr', 'gp_lang'); ?>" rel="nofollow" target="_blank"></a><?php } ?>
							
							<?php echo stripslashes($theme_additional_social_icons); ?>
	
						</span>
						
						<!-- END SOCIAL ICONS -->
						
						
					</div>
					
					<!-- END NAV -->
					
			
				</div>
				
				<!-- BEGIN HEADER RIGHT -->
				
			
				<!-- BEGIN TOP CONTENT -->
				
				<?php if($gp_settings['top_content_panel'] == "Show") { ?>
					
					<?php if(get_post_meta(get_the_ID(), 'ghostpool_top_content', true)) {
						$top_content_class = 'top-content-stripes ';
					} else {
						$top_content_class = '';
					}
					
					if($gp_settings['title'] == "Show") {
						$top_content_title_class = 'page-title-width';
					} else {
						$top_content_title_class = '';
					} ?>	
					 
					<div id="top-content" class="<?php echo $top_content_class; ?><?php echo $top_content_title_class; ?>">
						
						<!-- BEGIN TOP CONTENT LEFT -->
						
						<?php if($gp_settings['title'] == "Show") { ?>
						
						
							<div class="left">
							
							
								<!-- BEGIN TITLE -->
	
								<h1 class="page-title">
									<?php if(is_single() OR is_page() OR ( function_exists('is_bbpress') && is_bbPress() ) ) { ?>
										<?php the_title(); ?>
									<?php } elseif(is_search()) { ?>
										<?php echo $wp_query->found_posts; ?> <?php _e('search results for', 'gp_lang'); ?> "<?php echo esc_html($s); ?>"
									<?php } elseif(is_category()) { ?>
										<?php single_cat_title(); ?>
									<?php } elseif(is_tag()) { ?>
										<?php single_tag_title(); ?>
									<?php } elseif(is_404()) { ?>
										<?php _e('Page Not Found', 'gp_lang'); ?>						
									<?php } else { ?>
										<?php if ( ! function_exists( '_wp_render_title_tag' ) && ! function_exists( 'socialize_render_title' ) ) { 
											_e( 'Archives', 'gp_lang' );
										} else {
											the_archive_title();
										} ?>			
									<?php } ?>
								</h1>	
								
								<!-- END TITLE -->
												
			
								<!-- BEGIN POST META -->
	
								<?php if(is_singular() && ( ( isset( $gp_settings['meta_date'] ) && $gp_settings['meta_date'] == "0" ) OR ( isset( $gp_settings['meta_author'] ) && $gp_settings['meta_author'] == "0" ) OR ( isset( $gp_settings['meta_cats'] ) && $gp_settings['meta_cats'] == "0" ) OR ( isset( $gp_settings['meta_commentd'] ) && $gp_settings['meta_comments'] == "0") ) ) { ?>
									<div class="post-meta">
										<?php if( isset( $gp_settings['meta_author'] ) && $gp_settings['meta_author'] == "0") { ?><span class="author-icon"><a href="<?php echo get_author_posts_url($post->post_author); ?>"><?php the_author_meta('display_name', $post->post_author); ?></a></span><?php } ?>
										<?php if( isset( $gp_settings['meta_date'] ) && $gp_settings['meta_date'] == "0") { ?><span class="clock-icon"><?php the_time(get_option('date_format')); ?></span><?php } ?>
										<?php if( isset( $gp_settings['meta_cats'] ) && $gp_settings['meta_cats'] == "0") { ?><span class="folder-icon"><?php the_category(', '); ?></span><?php } ?>
										<?php if( isset( $gp_settings['meta_comments'] ) && $gp_settings['meta_comments'] == "0" && 'open' == $post->comment_status) { ?><span class="speech-icon"><?php comments_popup_link(__('0', 'gp_lang'), __('1', 'gp_lang'), __('%', 'gp_lang'), 'comments-link', ''); ?></span><?php } ?>
									</div>
								<?php } ?>
								
								<!-- END POST META -->
						
						
							</div>
							
						
						<?php } ?>
						
						<!-- END TOP CONTENT LEFT -->
						
						
						<!-- BEGIN TOP CONTENT RIGHT -->
						
						<?php if($gp_settings['search'] == "Show" OR $gp_settings['breadcrumbs'] == "Show") { ?>
						
						
							<div class="right">
								
								
								<!-- BEGIN SEARCH FORM -->
								
								<?php if($gp_settings['search'] == "Show") { ?>
								
									<?php if(function_exists('bp_is_active')) { ?>
		
										<form action="<?php echo bp_search_form_action(); ?>" method="post" id="searchform" class="bp-searchform">
											<input type="text" id="searchbar" name="search-terms" value="<?php echo isset( $_REQUEST['s'] ) ? esc_attr( $_REQUEST['s'] ) : ''; ?>" />
											<?php echo bp_search_form_type_select(); ?>
											<input type="submit" name="searchsubmit" id="searchsubmit" value="<?php _e( 'Search', 'buddypress' ); ?>" />
											<?php wp_nonce_field( 'bp_search_form' ); ?>
										</form>
										
									<?php } else { ?>
									
										<?php get_search_form(); ?>
									
									<?php } ?>
									
								<?php } ?>
								
								<!-- END SEARCH FORM -->
								
								
								<!-- BEGIN BREADCRUMBS -->
								
								<?php if($gp_settings['breadcrumbs'] == "Show") { ?>
									<div id="breadcrumbs"><?php echo gp_breadcrumbs(); ?></div>
								<?php } ?>
								
								<!-- END BREADCRUMBS -->
								
							
							</div>
						
						
						<?php } ?>
						
						<!-- END TOP CONTENT RIGHT -->
						
							
						<div class="clear"></div>
						
						
						<?php echo stripslashes(do_shortcode(get_post_meta(get_the_ID(), 'ghostpool_top_content', true))); ?>
						
			
					</div>
				
				<?php } ?>
				
				<!-- END TOP CONTENT -->
				
				
				<div class="clear"></div>
		
			</div>
			
			<!-- BEGIN HEADER INNER -->
			
		
		</div>
	
	
	</div>


	<!-- END HEADER OUTER -->


	<!-- BEGIN PAGE OUTER -->
	
	<div class="page-outer">
	
		
		<!-- BEGIN PAGE INNER -->
		
		<div class="page-inner">
		
			
			<!-- BEGIN CONTENT WRAPPER -->
			
			<div id="content-wrapper">
			

<?php } ?>	