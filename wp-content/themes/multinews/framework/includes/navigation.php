<?php
		$deffect = mom_option('dropdown-effect');
        if($deffect == '') {
            $deffect = 'dd-effect-slide';
        }
		$sticky_logo = mom_option('sticky_navigation_logo', 'url');
		$sl_w = mom_option('sticky_navigation_logo', 'width');
        $nav_align = '';

        if(mom_option('nav_align') == 'center') {
            $nav_align = 'center-navigation';
        }
        $menu = is_singular() ? get_post_meta(get_queried_object_id(), 'mom_navigation_menu', true) : '';
        if (is_category()) {
            $cat_data = get_option("category_".get_query_var('cat'));
            $menu = isset($cat_data['custom_menu']) ? $cat_data['custom_menu'] : '' ;
        }
if(function_exists('is_woocommerce') && is_woocommerce()) {
    $woo_page_id = '';
if (is_shop()) {
    $woo_page_id = get_option('woocommerce_shop_page_id');
} elseif (is_cart()) {
    $woo_page_id = get_option('woocommerce_cart_page_id');
} elseif (is_checkout()) {
    $woo_page_id = get_option('woocommerce_checkout_page_id');
} elseif (is_account_page()) {
    $woo_page_id = get_option('woocommerce_myaccount_page_id');
} else {
    $woo_page_id = get_option('woocommerce_shop_page_id');
}
$menu = get_post_meta($woo_page_id, 'mom_navigation_menu', true);

}        
        $lang = '';
        if(defined('ICL_LANGUAGE_CODE')) {
            $lang = ICL_LANGUAGE_CODE;
        }
        if (function_exists('qtrans_getLanguage')) {
            $lang = qtrans_getLanguage();
        }

            if ( is_user_logged_in() ) {
                $user = 'u';
            } else {
                $user = 'v';
            }
?>
<nav id="navigation" class="navigation <?php if (mom_option('sticky_logo_out') == 1) { echo 'sticky_logo_out'; } ?> <?php echo $deffect; ?> <?php echo $nav_align; ?>" data-sticky_logo="<?php echo $sticky_logo; ?>" data-sticky_logo_width="<?php echo $sl_w; ?>" role="navigation" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement"><!--Navigation-->
<div class="inner"><!--inner-->
<?php if ($sticky_logo) { ?>
	<a href="<?php echo esc_url(home_url()); ?>" class="sticky_logo"><img src="<?php echo $sticky_logo; ?>" alt="<?php bloginfo('name'); ?>" width="<?php echo mom_option('sticky_navigation_logo', 'width'); ?>" height="<?php echo mom_option('sticky_navigation_logo', 'height'); ?>"></a>
    <?php } ?>
		<?php if ( has_nav_menu( 'main' ) ) { 
            if ($menu != '') {
                    wp_nav_menu ( array( 'menu_class' => 'main-menu main-default-menu','container'=> 'ul', 'menu' => $menu, 'walker' => new mom_custom_Walker() )); 
            } else {
$main_menu_query = get_transient( 'main_menu_query'.get_queried_object_id().$lang.$user );
if (function_exists('is_buddypress')) {$main_menu_query = false;}
if( $main_menu_query === false ) {
    $main_menu_query = wp_nav_menu ( array( 'menu_class' => 'main-menu main-default-menu','container'=> 'ul', 'theme_location' => 'main', 'walker' => new mom_custom_Walker(), 'echo' => 0  )); 
    set_transient( 'main_menu_query'.get_queried_object_id().$lang.$user, $main_menu_query, 60*60*24 );
}
echo $main_menu_query;                 
            }

        ?>
        
         <div class="mom_visibility_device device-menu-wrap">
            <div class="device-menu-holder">
                <i class="momizat-icon-paragraph-justify2 mh-icon"></i> <span class="the_menu_holder_area"><i class="dmh-icon"></i><?php _e('Menu', 'framework'); ?></span><i class="mh-caret"></i>
            </div>
        <?php 
            if ($menu != '') {
                    wp_nav_menu ( array( 'menu_class' => 'device-menu','container'=> 'ul', 'menu' => $menu, 'walker' => new mom_custom_Walker() )); 
            } else {

$mobile_menu_query = get_transient( 'mobile_menu_query'.get_queried_object_id().$lang.$user );
if( $mobile_menu_query == false ) {
        $mobile_menu_query = wp_nav_menu ( array( 'menu_class' => 'device-menu' ,'container'=> 'ul', 'theme_location' => 'main', 'walker' => new mom_mobile_custom_walker(), 'echo' =>  0 )); 
        set_transient( 'mobile_menu_query'.get_queried_object_id().$lang.$user, $mobile_menu_query, 60*60*24 );
}
echo $mobile_menu_query;                 
}

        ?>
        </div>
        <?php } else { ?> <i class="menu-message"><?php _e('Select your Main Menu from wp menus', 'framework'); ?></i> <?php } ?>
<div class="clear"></div>
</div><!--inner-->
</nav><!--Navigation-->