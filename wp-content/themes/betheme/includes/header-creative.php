<?php
	$translate['wpml-no'] = mfn_opts_get('translate') ? mfn_opts_get('translate-wpml-no','No translations available for this page') : __('No translations available for this page','betheme');

	$creative_classes = '';
	$creative_options = mfn_opts_get( 'menu-creative-options' );
	
	if( is_array( $creative_options ) ){
		
		if( isset( $creative_options['scroll'] ) ){
			$creative_classes .= ' scroll';
		}
		if( isset( $creative_options['dropdown'] ) ){
			$creative_classes .= ' dropdown';
		}
		
	} 
?>

<div id="Header_creative" class="<?php echo $creative_classes; ?>">	
	<a href="#" class="creative-menu-toggle"><i class="icon-menu"></i></a>
	
	<ul class="social creative-social test687">
		<?php if( mfn_opts_get('social-skype') ): ?><li class="skype"><a href="<?php mfn_opts_show('social-skype'); ?>" title="Skype"><i class="icon-skype"></i></a></li><?php endif; ?>
		<?php if( mfn_opts_get('social-facebook') ): ?><li class="facebook"><a target="_blank" href="<?php mfn_opts_show('social-facebook'); ?>" title="Facebook"><i class="icon-facebook"></i></a></li><?php endif; ?>
		<?php if( mfn_opts_get('social-googleplus') ): ?><li class="googleplus"><a target="_blank" href="<?php mfn_opts_show('social-googleplus'); ?>" title="Google+"><i class="icon-gplus"></i></a></li><?php endif; ?>
		<?php if( mfn_opts_get('social-twitter') ): ?><li class="twitter"><a target="_blank" href="<?php mfn_opts_show('social-twitter'); ?>" title="Twitter"><i class="icon-twitter"></i></a></li><?php endif; ?>
		<?php if( mfn_opts_get('social-vimeo') ): ?><li class="vimeo"><a target="_blank" href="<?php mfn_opts_show('social-vimeo'); ?>" title="Vimeo"><i class="icon-vimeo"></i></a></li><?php endif; ?>
		<?php if( mfn_opts_get('social-youtube') ): ?><li class="youtube"><a target="_blank" href="<?php mfn_opts_show('social-youtube'); ?>" title="YouTube"><i class="icon-play"></i></a></li><?php endif; ?>
		<?php if( mfn_opts_get('social-flickr') ): ?><li class="flickr"><a target="_blank" href="<?php mfn_opts_show('social-flickr'); ?>" title="Flickr"><i class="icon-flickr"></i></a></li><?php endif; ?>
		<?php if( mfn_opts_get('social-linkedin') ): ?><li class="linked_in"><a target="_blank" href="<?php mfn_opts_show('social-linkedin'); ?>" title="LinkedIn"><i class="icon-linkedin"></i></a></li><?php endif; ?>
		<?php if( mfn_opts_get('social-pinterest') ): ?><li class="pinterest"><a target="_blank" href="<?php mfn_opts_show('social-pinterest'); ?>" title="Pinterest"><i class="icon-pinterest"></i></a></li><?php endif; ?>
		<?php if( mfn_opts_get('social-dribbble') ): ?><li class="dribbble"><a target="_blank" href="<?php mfn_opts_show('social-dribbble'); ?>" title="Dribbble"><i class="icon-dribbble"></i></a></li><?php endif; ?>
		<?php if( mfn_opts_get('social-instagram') ): ?><li class="instagram"><a target="_blank" href="<?php mfn_opts_show('social-instagram'); ?>" title="Instagram"><i class="icon-instagram"></i></a></li><?php endif; ?>
		<?php if( mfn_opts_get('social-behance') ): ?><li class="behance"><a target="_blank" href="<?php mfn_opts_show('social-behance'); ?>" title="Behance"><i class="icon-behance"></i></a></li><?php endif; ?>
		<?php if( mfn_opts_get('social-tumblr') ): ?><li class="tumblr"><a target="_blank" href="<?php mfn_opts_show('social-tumblr'); ?>" title="Tumblr"><i class="icon-tumblr"></i></a></li><?php endif; ?>
		<?php if( mfn_opts_get('social-vkontakte') ): ?><li class="vkontakte"><a target="_blank" href="<?php mfn_opts_show('social-vkontakte'); ?>" title="VKontakte"><i class="icon-vkontakte"></i></a></li><?php endif; ?>
		<?php if( mfn_opts_get('social-viadeo') ): ?><li class="viadeo"><a target="_blank" href="<?php mfn_opts_show('social-viadeo'); ?>" title="Viadeo"><i class="icon-viadeo"></i></a></li><?php endif; ?>
		<?php if( mfn_opts_get('social-xing') ): ?><li class="xing"><a target="_blank" href="<?php mfn_opts_show('social-xing'); ?>" title="Xing"><i class="icon-xing"></i></a></li><?php endif; ?>
		<?php if( mfn_opts_get('social-rss') ): ?><li class="rss"><a target="_blank" href="<?php echo get_bloginfo('rss2_url'); ?>" title="RSS"><i class="icon-rss"></i></a></li><?php endif; ?>
	</ul>
	
	<div class="creative-wrapper">
	
		<div id="Top_bar">
			<div class="one">
		
				<div class="top_bar_left">
				
					<!-- .logo -->
					<div class="logo<?php if( $textlogo = mfn_opts_get('logo-text') ) echo ' text-logo'; ?>">
						<?php 
							// Logo | Options
							$logo_options = mfn_opts_get( 'logo-link' ) ? mfn_opts_get( 'logo-link' ) : false;
							$logo_before = $logo_after = '';
	
							// Logo | Link
							if( isset( $logo_options['link'] ) ){
								$logo_before 	= '<a id="logo" href="'. get_home_url() .'" title="'. get_bloginfo( 'name' ) .'">';
								$logo_after 	= '</a>';
							} else {
								$logo_before 	= '<span id="logo">';
								$logo_after 	= '</span>';
							}
							
							// Logo | H1
							if( is_front_page() ){
								if( is_array( $logo_options ) && isset( $logo_options['h1-home'] )){
									$logo_before = '<h1>'. $logo_before;
									$logo_after .= '</h1>';
								}
							} else {
								if( is_array( $logo_options ) && isset( $logo_options['h1-all'] )){
									$logo_before = '<h1>'. $logo_before;
									$logo_after .= '</h1>';
								}
							}
							
							// Logo | Source
							if( $layoutID = mfn_layout_ID() ){
								
								$logo_src 		= get_post_meta( $layoutID, 'mfn-post-logo-img', true );
								$logo_mobile 	= get_post_meta( $layoutID, 'mfn-post-responsive-logo-img', true ) ? get_post_meta( $layoutID, 'mfn-post-responsive-logo-img', true ) : $logo_src;
								
							} else {
								
								$logo_src 		= mfn_opts_get( 'logo-img', THEME_URI .'/images/logo/logo.png' );
								$logo_mobile 	= mfn_opts_get( 'responsive-logo-img' ) ? mfn_opts_get( 'responsive-logo-img' ) : $logo_src;
								
							}
							
							// Logo | SVG width
							if( $width = mfn_opts_get( 'logo-width' ) ){
								$width = 'width="'. $width .'"';
								$class = ' svg';
							} else {
								$width = false;
								$class = false;
							}
				
							// Logo | Print
							echo $logo_before;
							
								if( $textlogo ){
								
									echo $textlogo;
								
								} else {
									
									echo '<img class="logo-main scale-with-grid'. $class .'" src="'. $logo_src .'" alt="'. mfn_get_attachment_data( $logo_src, 'alt' ) .'" '. $width .'/>';
									echo '<img class="logo-mobile scale-with-grid'. $class .'" src="'. $logo_mobile .'" alt="'. mfn_get_attachment_data( $logo_mobile, 'alt' ) .'" '. $width .'/>';
									
								}
								
							echo $logo_after;
						?>
					</div>
			
					<div class="menu_wrapper">
						<?php 
							// #menu --------------------------
							mfn_wp_nav_menu(); 
						
							$mb_class = '';
							if( mfn_opts_get('header-menu-mobile-sticky') ) $mb_class .= ' is-sticky';
													
							// responsive menu button ---------
							echo '<a class="responsive-menu-toggle '. $mb_class .'" href="#">';
								if( $menu_text = mfn_opts_get( 'header-menu-text' ) ){
									echo '<span>'. $menu_text .'</span>';
								} else {
									echo '<i class="icon-menu"></i>';
								}  
							echo '</a>';
						?>					
					</div>		
				
					<div class="search_wrapper">
						<!-- #searchform -->
						<?php $translate['search-placeholder'] = mfn_opts_get('translate') ? mfn_opts_get('translate-search-placeholder','Enter your search') : __('Enter your search','betheme'); ?>
						<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
							<?php if( mfn_opts_get('header-search') == 'shop' ): ?>
								<input type="hidden" name="post_type" value="product" />
							<?php endif;?>
							<i class="icon_search icon-search"></i>
							<a href="#" class="icon_close"><i class="icon-cancel"></i></a>
							<input type="text" class="field" name="s" id="s" placeholder="<?php echo $translate['search-placeholder']; ?>" />			
							<input type="submit" class="submit" value="" style="display:none;" />
						</form>
					</div>

				</div>
			
				<?php get_template_part( 'includes/header', 'top-bar-right' ); ?>
				
				<div class="banner_wrapper">
					<?php mfn_opts_show( 'header-banner' ); ?>
				</div>
					
			</div>
		</div>

		<div id="Action_bar">
			<ul class="social">
				<?php if( mfn_opts_get('social-skype') ): ?><li class="skype"><a href="<?php mfn_opts_show('social-skype'); ?>" title="Skype"><i class="icon-skype"></i></a></li><?php endif; ?>
				<?php if( mfn_opts_get('social-facebook') ): ?><li class="facebook"><a target="_blank" href="<?php mfn_opts_show('social-facebook'); ?>" title="Facebook"><i class="icon-facebook"></i></a></li><?php endif; ?>
				<?php if( mfn_opts_get('social-googleplus') ): ?><li class="googleplus"><a target="_blank" href="<?php mfn_opts_show('social-googleplus'); ?>" title="Google+"><i class="icon-gplus"></i></a></li><?php endif; ?>
				<?php if( mfn_opts_get('social-twitter') ): ?><li class="twitter"><a target="_blank" href="<?php mfn_opts_show('social-twitter'); ?>" title="Twitter"><i class="icon-twitter"></i></a></li><?php endif; ?>
				<?php if( mfn_opts_get('social-vimeo') ): ?><li class="vimeo"><a target="_blank" href="<?php mfn_opts_show('social-vimeo'); ?>" title="Vimeo"><i class="icon-vimeo"></i></a></li><?php endif; ?>
				<?php if( mfn_opts_get('social-youtube') ): ?><li class="youtube"><a target="_blank" href="<?php mfn_opts_show('social-youtube'); ?>" title="YouTube"><i class="icon-play"></i></a></li><?php endif; ?>
				<?php if( mfn_opts_get('social-flickr') ): ?><li class="flickr"><a target="_blank" href="<?php mfn_opts_show('social-flickr'); ?>" title="Flickr"><i class="icon-flickr"></i></a></li><?php endif; ?>
				<?php if( mfn_opts_get('social-linkedin') ): ?><li class="linked_in"><a target="_blank" href="<?php mfn_opts_show('social-linkedin'); ?>" title="LinkedIn"><i class="icon-linkedin"></i></a></li><?php endif; ?>
				<?php if( mfn_opts_get('social-pinterest') ): ?><li class="pinterest"><a target="_blank" href="<?php mfn_opts_show('social-pinterest'); ?>" title="Pinterest"><i class="icon-pinterest"></i></a></li><?php endif; ?>
				<?php if( mfn_opts_get('social-dribbble') ): ?><li class="dribbble"><a target="_blank" href="<?php mfn_opts_show('social-dribbble'); ?>" title="Dribbble"><i class="icon-dribbble"></i></a></li><?php endif; ?>
				<?php if( mfn_opts_get('social-instagram') ): ?><li class="instagram"><a target="_blank" href="<?php mfn_opts_show('social-instagram'); ?>" title="Instagram"><i class="icon-instagram"></i></a></li><?php endif; ?>
				<?php if( mfn_opts_get('social-behance') ): ?><li class="behance"><a target="_blank" href="<?php mfn_opts_show('social-behance'); ?>" title="Behance"><i class="icon-behance"></i></a></li><?php endif; ?>
				<?php if( mfn_opts_get('social-tumblr') ): ?><li class="tumblr"><a target="_blank" href="<?php mfn_opts_show('social-tumblr'); ?>" title="Tumblr"><i class="icon-tumblr"></i></a></li><?php endif; ?>
				<?php if( mfn_opts_get('social-vkontakte') ): ?><li class="vkontakte"><a target="_blank" href="<?php mfn_opts_show('social-vkontakte'); ?>" title="VKontakte"><i class="icon-vkontakte"></i></a></li><?php endif; ?>
				<?php if( mfn_opts_get('social-viadeo') ): ?><li class="viadeo"><a target="_blank" href="<?php mfn_opts_show('social-viadeo'); ?>" title="Viadeo"><i class="icon-viadeo"></i></a></li><?php endif; ?>
				<?php if( mfn_opts_get('social-xing') ): ?><li class="xing"><a target="_blank" href="<?php mfn_opts_show('social-xing'); ?>" title="Xing"><i class="icon-xing"></i></a></li><?php endif; ?>
				<?php if( mfn_opts_get('social-rss') ): ?><li class="rss"><a target="_blank" href="<?php echo get_bloginfo('rss2_url'); ?>" title="RSS"><i class="icon-rss"></i></a></li><?php endif; ?>
			</ul>
		</div>
					
	</div>
	
</div>