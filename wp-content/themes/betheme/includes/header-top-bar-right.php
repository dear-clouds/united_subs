<?php
global $woocommerce;
$translate['wpml-no'] = mfn_opts_get('translate') ? mfn_opts_get('translate-wpml-no','No translations available for this page') : __('No translations available for this page','betheme');

// WooCommerce Cart
$show_cart = trim( mfn_opts_get( 'shop-cart' ) );
if( $show_cart == 1 ) $show_cart = 'icon-basket';
$has_cart = ( $woocommerce && $show_cart ) ? true : false;

// Search
$header_search = mfn_opts_get( 'header-search' );

// Action Button
$header_action_link	= mfn_opts_get( 'header-action-link' );

// WPML Icon
if( has_nav_menu( 'lang-menu' ) ){
	$wpml_icon = true;
} elseif( function_exists( 'icl_get_languages' ) && mfn_opts_get('header-wpml') != 'hide' ){
	$wpml_icon = true;
} else {
	$wpml_icon = false;
}

if( $has_cart || $header_search || $header_action_link || $wpml_icon ){
	echo '<div class="top_bar_right">';
		echo '<div class="top_bar_right_wrapper">';
		
			// WooCommerce Cart
			if( $has_cart ){
				echo '<a id="header_cart" href="'. $woocommerce->cart->get_cart_url() .'"><i class="'. $show_cart .'"></i><span>'. $woocommerce->cart->cart_contents_count .'</span></a>';
			}
			
			// Search Icon
			if( $header_search == 'input' ){
				
				$translate['search-placeholder'] = mfn_opts_get('translate') ? mfn_opts_get('translate-search-placeholder','Enter your search') : __('Enter your search','betheme');
				
				echo '<a id="search_button" class="has-input">';
					echo '<form method="get" id="searchform" action="'. esc_url( home_url( '/' ) ) .'">';
					
						echo '<i class="icon-search"></i>';
						echo '<input type="text" class="field" name="s" id="s" placeholder="'. $translate['search-placeholder'] .'" />';
						echo '<input type="submit" class="submit" value="" style="display:none;" />';	
										
					echo '</form>';
				echo '</a>';
				
			} elseif( $header_search ){
				
				echo '<a id="search_button" href="#"><i class="icon-search"></i></a>';
				
			}
			
			// Languages menu
			if( has_nav_menu( 'lang-menu' ) ){
				// Custom Languages Menu
				
				echo '<div class="wpml-languages custom">';
					echo '<a class="active" href="#">'. mfn_get_menu_name( 'lang-menu' ) .'<i class="icon-down-open-mini"></i></a>';
					mfn_wp_lang_menu();
				echo '</div>';
				
			} elseif( function_exists( 'icl_get_languages' ) ){
				// WPML - Custom Languages Menu
				
				$lang_args = '';
				$lang_options = mfn_opts_get( 'header-wpml-options' );
				if( is_array( $lang_options ) && isset( $lang_options['link-to-home'] )){
					$lang_args .= 'skip_missing=0';
				} else {
					$lang_args .= 'skip_missing=1';
				}
				$languages	= icl_get_languages( $lang_args );
				
				$wmpl_flags = mfn_opts_get('header-wpml');

				if( $wmpl_flags != 'hide' && is_array( $languages ) ){
					
					if( ! $wmpl_flags || $wmpl_flags == 'dropdown-name'  ){
						// dropdown ------------
						
						$active_lang = false;
						foreach( $languages as $lang_k=>$lang ){
							if( $lang['active'] ){
								$active_lang = $lang;
								unset( $languages[$lang_k] );
							}
						}

						// disabled
						if( count( $languages ) ){
							$lang_status = 'enabled';
						} else {
							$lang_status = 'disabled';
						}
						
						if( $active_lang ){
							echo '<div class="wpml-languages '. $lang_status .'">';
							
								echo '<a class="active tooltip" ontouchstart="this.classList.toggle(\'hover\');" data-tooltip="'. $translate['wpml-no'] .'">';
									
									if( $wmpl_flags == "dropdown-name" ){
										echo $active_lang['native_name'];
									} else {
										echo '<img src="'. $active_lang['country_flag_url'] .'" alt="'. $active_lang['translated_name'] .'" width="18" height="12"/>';
									}
									
									if( count( $languages ) ) echo '<i class="icon-down-open-mini"></i>';
									
								echo '</a>';
								
								if( count( $languages ) ){
									echo '<ul class="wpml-lang-dropdown">';
										foreach( $languages as $lang ){
											
											if( $wmpl_flags == 'dropdown-name' ){
												echo '<li><a href="'. $lang['url'] .'">'. $lang['native_name'] .'</a></li>';
											} else {
												echo '<li><a href="'. $lang['url'] .'"><img src="'. $lang['country_flag_url'] .'" alt="'. $lang['translated_name'] .'" width="18" height="12"/></a></li>';
											}

										}
									echo '</ul>';
								}
								
							echo '</div>';
						}
						
					} else {
						// horizontal ------------
						
						echo '<div class="wpml-languages horizontal">';
							echo '<ul>';
								foreach( $languages as $lang ){
									
									if( $lang['active'] ){
										$lang_class = 'lang-active';
									} else {
										$lang_class = false;
									}
									
									if( $wmpl_flags == 'horizontal-code' ){
										echo '<li class="'. $lang_class .'"><a href="'. $lang['url'] .'">'. strtoupper( $lang['language_code'] ) .'</a></li>';
									} else {
										echo '<li class="'. $lang_class .'"><a href="'. $lang['url'] .'"><img src="'. $lang['country_flag_url'] .'" alt="'. $lang['translated_name'] .'" width="18" height="12"/></a></li>';
									}

								}
							echo '</ul>';
						echo '</div>';
						
					}
					
				}

			}

			// Action Button
			if( $header_action_link ){
				
				$header_action_options = mfn_opts_get( 'header-action-target' );
				$action_target = $action_class = false;
				
				// Action | Target
				if( isset( $header_action_options['target'] ) ) $action_target = 'target="_blank"';
				
				// Action | Scroll
				if( is_array( $header_action_options ) && isset( $header_action_options['scroll'] ) ) $action_class = 'scroll';
				
				echo '<a href="'. $header_action_link .'" class="button button_theme button_js action_button '. $action_class .'" '. $action_target .'><span class="button_label">'. mfn_opts_get( 'header-action-title' ) .'</span></a>';
			}
						
		echo '</div>';
	echo '</div>';
}
