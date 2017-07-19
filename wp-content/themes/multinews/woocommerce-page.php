<?php
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
    //Page settings
    $layout = get_post_meta($woo_page_id, 'mom_page_layout', true);
    $icon = get_post_meta($woo_page_id, 'mom_page_icon', true);
    $custom = get_post_meta($woo_page_id, 'mom_background_tr', true);
    $PS = get_post_meta($woo_page_id, 'mom_page_share', true);
    $PC = get_post_meta($woo_page_id, 'mom_page_comments', true);
    $pagebreadcrumb = get_post_meta($woo_page_id, 'mom_hide_breadcrumb', true);

?>
<?php get_header(); ?>


	<div class="main-container"><!--container-->
		
		<?php if($custom == '') { ?>
		<?php if(mom_option('breadcrumb') != 0) { ?>
		<?php if ($pagebreadcrumb != true) { ?>
		 <div class="post-crumbs entry-crumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
		 	<?php if($icon != '') { ?>
            <div class="crumb-icon"><i class="<?php echo $icon; ?>"></i></div>
            <?php } ?>
            <?php woocommerce_breadcrumb(); ?>
            <?php //echo get_the_title($woo_page_id); ?>
        </div>
        <?php } ?>
        <?php } else { ?>
			<span class="mom-page-title"><h1><?php echo get_the_title($woo_page_id); ?></h1></span>
		<?php } ?>
        <?php } ?>
        		
        
		<?php if ($layout == 'fullwidth') { ?>
				<?php if($custom) {	 
				    woocommerce_content(); 
				} else { ?>
					<div class="site-content page-wrap">
			            <div class="entry-content clearfix">
					<?php woocommerce_content(); ?>
			            </div>
					</div>
				<?php } ?>
		<?php } else { ?>
				<?php if($custom) { ?> 
					<div class="main-left"><!--Main Left-->
			            <div class="main-content" role="main"><!--Main Content-->
				    	<?php woocommerce_content(); ?>
				    </div>
                    	 <?php get_sidebar('left'); ?>
					</div>
					<?php get_sidebar(); ?>
				<?php } else { ?>
					<div class="main-left"><!--Main Left-->
			            <div class="main-content" role="main"><!--Main Content-->
							<div class="site-content page-wrap">
								<div class="entry-content clearfix">
								    <?php woocommerce_content(); ?>
								</div>
							</div> 
			            </div>
			            <?php get_sidebar('left'); ?>
					</div>
					<?php get_sidebar(); ?>
				<?php } ?>
		<?php } ?>
	
    </div><!--container-->

</div><!--wrap-->
            
<?php get_footer(); ?>