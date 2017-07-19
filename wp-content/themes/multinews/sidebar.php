<?php
if( function_exists('is_mobile') && is_mobile() && mom_option('hide_sidebars_in_mobiles') == 1 ){
 	// do nothing 
} else {
$swstyle = mom_option('swstyle');
  if( $swstyle == 'style2' ){
    $swclass = ' sws2';
  } else {
    $swclass = '';
  }

?>
<aside class="sidebar<?php echo $swclass; ?>" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar"><!--sidebar-->
    <?php
    if(is_home()) {
    
	    $homesidebar = mom_option('hp_rsidebar');
	    if($homesidebar)
	    dynamic_sidebar ( sanitize_title($homesidebar) );
	    else dynamic_sidebar( 'Main sidebar' );
	    
    } elseif (is_category()) {
    
    	$cat_data = get_option("category_".get_query_var('cat'));
    	$cus_sidebar = isset($cat_data['sidebar']) ? $cat_data['sidebar'] : '' ;
    	$catsidebar = mom_option('cat_rsidebar');
    	
    	if (!empty($cus_sidebar)) {
		    dynamic_sidebar($cus_sidebar);
		} elseif($catsidebar) {
	    	dynamic_sidebar ( sanitize_title($catsidebar) );
	    } else { 
	    	dynamic_sidebar( 'Main sidebar' );
	    }
	    
	} elseif (is_single()) {
		
	    if(function_exists('is_bbpress') && is_bbpress()) {
		    $custom_sidebar = mom_option('bbpress_right_sidebar');
		    if(function_exists('is_buddypress') && is_buddypress()) {
			$custom_sidebar = mom_option('buddypress_right_sidebar');
		    }
		    if (!empty($custom_sidebar)) {
			dynamic_sidebar($custom_sidebar);		    
		    } else {
			dynamic_sidebar( 'Main sidebar' );
		    }
	    } elseif(function_exists('is_buddypress') && is_buddypress()) {
		    $custom_sidebar = mom_option('buddypress_right_sidebar');
		    if (!empty($custom_sidebar)) {
			dynamic_sidebar($custom_sidebar);		    
		    } else {
			dynamic_sidebar( 'Main sidebar' );
		    }
	    } else {
		global $post;
		$custom_sidebar = get_post_meta(get_queried_object_id(), 'mom_right_sidebar', TRUE);
		$postsidebar = mom_option('post_rsidebar');
		
		if (!empty($custom_sidebar)) {
		    dynamic_sidebar($custom_sidebar);		    
		} elseif(!empty($postsidebar)) {
	    	dynamic_sidebar( sanitize_title($postsidebar) );
	    } else {
	    	dynamic_sidebar( 'Main sidebar' );
	    }
	}
	    
	} elseif(is_page()) {
	    if(function_exists('is_bbpress') && is_bbpress()) {
		    $custom_sidebar = mom_option('bbpress_right_sidebar');
		    if (!empty($custom_sidebar)) {
			dynamic_sidebar($custom_sidebar);		    
		    } else {
			dynamic_sidebar( 'Main sidebar' );
		    }
	    } elseif(function_exists('is_buddypress') && is_buddypress()) {
		    $custom_sidebar = mom_option('buddypress_right_sidebar');
		    if (!empty($custom_sidebar)) {
			dynamic_sidebar($custom_sidebar);		    
		    } else {
			dynamic_sidebar( 'Main sidebar' );
		    }
	    } else {
					
		global $post;
		$custom_psidebar = get_post_meta(get_queried_object_id(), 'mom_right_sidebar', TRUE);
		$pagessidebar = mom_option('page_rsidebar');
		
		if (!empty($custom_psidebar)) {
		    dynamic_sidebar($custom_psidebar);		    
		} elseif(!empty($pagessidebar)) {
	    dynamic_sidebar ( sanitize_title($pagessidebar) );
	    } else {
	    dynamic_sidebar( 'Main sidebar' );
	    }
			
	    }
	} elseif(is_archive()) {
		
		
		$archivesidebar = mom_option('archive_rsidebar');

		if(function_exists ( "is_woocommerce" ) && is_woocommerce()) {
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
		
		if(mom_option('woo_rsidebar') != '') {
			$archivesidebar = mom_option('woo_rsidebar');
		} else {
			$archivesidebar = get_post_meta($woo_page_id, 'mom_right_sidebar', TRUE);
		}
		}
	
	  	if(function_exists('is_bbpress') && is_bbpress()) {
		    $archivesidebar = mom_option('bbpress_right_sidebar');
	    } 

	    if(function_exists('is_buddypress') && is_buddypress()) {
		    $archivesidebar = mom_option('buddypress_right_sidebar');
	    }

	    if (!empty($archivesidebar)) {
	    	dynamic_sidebar($archivesidebar);
	    } else {
	    	dynamic_sidebar( 'Main sidebar' );
		}
	
	} else {
		
	    if(function_exists('is_bbpress') && is_bbpress()) {
		    $custom_sidebar = mom_option('bbpress_right_sidebar');
		    if (!empty($custom_sidebar)) {
			dynamic_sidebar($custom_sidebar);		    
		    } else {
			dynamic_sidebar( 'Main sidebar' );
		    }
	    } elseif(function_exists('is_buddypress') && is_buddypress()) {
		    $custom_sidebar = mom_option('buddypress_right_sidebar');
		    if (!empty($custom_sidebar)) {
			dynamic_sidebar($custom_sidebar);		    
		    } else {
			dynamic_sidebar( 'Main sidebar' );
		    }
	    } else {
			dynamic_sidebar( 'Main sidebar' );
	    }
	}
	?>
</aside><!--sidebar-->
<?php } ?>