<?php 
		$logo_right_banner = '';
		$logo_left_banner = '';
		
		if (mom_option('logo_align') == 'center') {
			$logo_right_banner = mom_option('logo_right_banner');
			$logo_left_banner = mom_option('logo_left_banner');
		}


    	if (is_singular()) {

		    //custom banner
		    $header_banner = get_post_meta(get_the_ID(), 'mom_Header_banner', true);
		    if ($header_banner == '' && is_single())  {
				global $post;
				if (has_category('',$post->ID)) {
				$cat_obj = get_the_category($post->ID);
				$cat_id = $cat_obj[0]->term_id;
				$cat_data1 = get_option( 'category_'.$cat_id);
					if( isset($cat_data1['custom_banner']) != '') {
	    				$header_banner = isset($cat_data1['custom_banner']) ? $cat_data1['custom_banner'] : '';
					}
				}
				} 
        } elseif ( is_category() ) {
		    $cat_data = get_option("category_".get_query_var('cat'));
		    //custom banner
		    $header_banner = isset($cat_data['custom_banner']) ? $cat_data['custom_banner'] :'';
		    if ($header_banner == '')  {
			$header_banner = mom_option('header_banner');
		    }
	} else {
		    $header_banner = mom_option('header_banner');
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
		    $header_banner = get_post_meta($woo_page_id, 'mom_Header_banner', true);
} 

	if ($header_banner == '') {
		$header_banner = mom_option('header_banner');
	}

	if(mom_option('logo_type') == 'logo_image') { 
    	$def_logo = MOM_IMG .'/logo.png';
    	$def_r_logo = MOM_IMG .'/logo-hd.png';
    	if(mom_option('header_style') != ''){
        $def_logo = MOM_IMG .'/logo-dark.png';
    	$def_r_logo = MOM_IMG .'/logo-hd-dark.png';
    	}
	?>
    <div class="logo" itemscope="itemscope" itemtype="http://schema.org/Organization">
        
        <?php if(mom_option('sharee_print') != 0) { ?>
        <img class="print-logo" itemprop="logo" src="<?php echo mom_option('logo_img','url'); ?>" width="<?php echo mom_option('logo_img','width'); ?>" height="<?php echo mom_option('logo_img','height'); ?>" alt="<?php bloginfo('name'); ?>"/> 
        <?php } ?>
        <?php if (is_home() || is_front_page()) {?><h1><?php } ?> 
        <a href="<?php echo esc_url(home_url()); ?>" itemprop="url" title="<?php bloginfo('name'); ?>">
        <?php 
        if ( is_singular() ) {
		    // custom logo 
		    $the_logo = get_post_meta(get_the_ID(), 'mom_custom_logo', true);    
		    if ($the_logo == '') {
		    global $post;
			if (has_category('',$post->ID)) {
            $cat_obj = get_the_category($post->ID);
            $cat_id = $cat_obj[0]->term_id;
            $cat_data2 = get_option( 'category_'.$cat_id);
            $the_logo = isset($cat_data2['custom_logo']) ? $cat_data2['custom_logo'] : '';
            }
		    }   
		    $r_logo = '';
		    if ($the_logo == '') {
			$the_logo = mom_option('logo_img', 'url');
			$r_logo = mom_option('retina_logo_img', 'url');
		    }

        } else if ( is_category() ) {
		    // custom logo
		    $cat_data = get_option("category_".get_query_var('cat'));
		    $the_logo = isset($cat_data['custom_logo']) ? $cat_data['custom_logo'] :'';
		    $r_logo = '';
		    if ($the_logo == '') {
			$the_logo = mom_option('logo_img', 'url');
			$r_logo = mom_option('retina_logo_img', 'url');
		    }
		    
		} else {
		    $the_logo = mom_option('logo_img', 'url');
		    $r_logo = mom_option('retina_logo_img', 'url');
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
		    $the_logo = get_post_meta($woo_page_id, 'mom_custom_logo', true);    
		    $r_logo = '';

		    if ($the_logo == '') {
				$the_logo = mom_option('logo_img', 'url');
			    $r_logo = mom_option('retina_logo_img', 'url');
		    }
}   
        
        if($the_logo != '') { ?>
        		<img itemprop="logo" src="<?php echo $the_logo; ?>" alt="<?php bloginfo('name'); ?>"/>  
        <?php } else { ?>
        		<img itemprop="logo" src="<?php echo $def_logo; ?>" alt="<?php bloginfo('name'); ?>"/>
        <?php } ?>
        
        <?php if($r_logo != '') { ?>  
        		<img itemprop="logo" class="mom_retina_logo" src="<?php echo $r_logo; ?>" width="<?php echo mom_option('logo_img','width'); ?>" height="<?php echo mom_option('logo_img','height'); ?>" alt="<?php bloginfo('name'); ?>" />
        <?php } else { ?>		
        		<?php if($the_logo != '') { ?>
        			<img itemprop="logo" class="mom_retina_logo" src="<?php echo $the_logo; ?>" alt="<?php bloginfo('name'); ?>" />
        		<?php } else { ?>
        			<img itemprop="logo" class="mom_retina_logo" src="<?php echo $def_r_logo; ?>" alt="<?php bloginfo('name'); ?>" />
        		<?php } ?>
		<?php } ?>
        </a>
        <?php if (is_home() || is_front_page()) { ?> </h1> <?php } ?> 

        <meta itemprop="name" content="<?php bloginfo('name'); ?>">
    </div>
<?php } else { ?>
    <div class="logo" itemscope="itemscope" itemtype="http://schema.org/Organization">
        <h1 class="site_title"><a href="<?php echo esc_url(home_url()); ?>" itemprop="url" title="<?php bloginfo( 'name' ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		<h2 class="site_desc"><?php bloginfo( 'description' ); ?></h2>
        <meta itemprop="name" content="<?php bloginfo('name'); ?>">
    </div>
<?php } ?>
           <?php 
	           if ($logo_left_banner) { echo '<div class="logo_left_banner">'. do_shortcode('[ad id="'.$logo_left_banner.'"]') . '</div>'; }  
	           if ($logo_right_banner) { echo '<div class="logo_right_banner">'. do_shortcode('[ad id="'.$logo_right_banner.'"]') . '</div>'; } 
           ?>     
<?php if(mom_option('h_banner_type') == 'ads') { ?>
    <div class="header-banner">
		<?php echo do_shortcode('[ad id="'.$header_banner.'"]'); ?>
    </div>
<?php } else { 
	if (mom_option('header_custom_content') != '' && mom_option('h_banner_type') == 'custom') {
	echo '<div class="header-right header-right_custom-content">'.do_shortcode(mom_option('header_custom_content')).'</div>';
    }
} ?>