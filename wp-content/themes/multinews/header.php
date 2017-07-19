<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->

	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <title><?php wp_title( '|', true, 'right' ); ?></title>
<?php if (mom_option('mom_og_tags') == 1) { ?>
    <?php if (is_singular()) { ?>
    <meta property="og:image" content="<?php echo esc_url(mom_post_image('medium')); ?>"/>
    <meta property="og:image:width" content="<?php echo get_option( 'medium_size_w' ); ?>" />
    <meta property="og:image:height" content="<?php echo get_option( 'medium_size_h' ); ?>" />

    <?php
        $mom_og_title = get_the_title();
    if (function_exists('is_buddypress') && is_buddypress()) {
        if ( bp_is_user() && !bp_is_register_page() ) {
                $mom_og_title = bp_get_displayed_user_fullname();
        } else {
        $mom_og_title = wp_title('', false);
        }
    }
    ?>

    <meta property="og:title" content="<?php echo esc_attr($mom_og_title); ?>"/>
    <meta property="og:type" content="article"/>
    <meta property="og:description" content="<?php global $post; $excerpt = $post->post_excerpt; if ($excerpt == '') { $excerpt = $post->post_content;} echo esc_attr(wp_html_excerpt(strip_shortcodes($excerpt), 200)); ?>"/>
    <meta property="og:url" content="<?php the_permalink(); ?>"/>
    <meta property="og:site_name" content="<?php echo esc_attr(get_bloginfo( 'name' )); ?>"/>
<?php } else { ?>
    <meta property="og:image" content="<?php echo esc_url(mom_option('logo_img', 'url')); ?>"/>
    <meta property="og:image:width" content="<?php mom_option('logo_img', 'width'); ?>" />
    <meta property="og:image:height" content="<?php mom_option('logo_img', 'height'); ?>" />
<?php } ?>
<?php } ?>

	<?php if(mom_option('enable_responsive') != true) { ?>
	<meta name="viewport" content="user-scalable=yes, minimum-scale=0.25, maximum-scale=3.0" />
	<?php } else {  ?>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<?php } ?>
    <?php if(mom_option('sharee_print') != 0) { ?>
    <link rel="stylesheet" type="text/css" href="<?php echo MOM_CSS; ?>/print.css" media="print" />
    <?php } ?>
	<?php if ( mom_option('custom_favicon', 'url') != '') { ?>
	<link rel="shortcut icon" href="<?php echo mom_option('custom_favicon', 'url'); ?>" />
	<?php } ?>
	<?php if ( mom_option('apple_touch_icon', 'url') != '') { ?>
	<link rel="apple-touch-icon" href="<?php echo mom_option('apple_touch_icon', 'url'); ?>" />
	<?php } else { ?>
	<link rel="apple-touch-icon" href="<?php echo MOM_URI; ?>/apple-touch-icon-precomposed.png" />
	<?php } ?>
<?php wp_head(); ?>
</head>
    <?php
        if (is_single()) {
            global $post;
            $schema = 'role="article" itemscope="" itemtype="http://schema.org/Article"';
            if (get_post_meta( $post->ID, 'mom_review_post', true ) == 1) {
                $schema = 'itemscope="" itemtype="http://schema.org/Review"';
            }
        } else {
            $schema = 'itemscope="itemscope" itemtype="http://schema.org/WebPage"';
        }
    ?>
    <body <?php body_class(); ?> <?php echo $schema; ?>>
    <?php do_action('mom_first_on_body');
        if (isset($_GET['login']) && $_GET['login'] == 'failed') {
            echo '<div class="alert-bar hide"><p>'.__('Sorry your username or password is incorrect.', 'theme').'</p></div>';
        }
   ?>
    	<!--[if lt IE 7]>
            <p class="browsehappy"><?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'theme'); ?></p>
        <![endif]-->
    	<?php if(mom_option('bg_ads') == true) { ?>
        	<a style="height:<?php echo mom_option('bg_ads_h', 'height'); ?>" class="ad_bg" href="<?php echo mom_option('bg_ads_url'); ?>" target="_blank">&nbsp;</a>
        <?php } ?>
        <?php
        $mom_layout = '';
		$theme_layout = mom_option('theme_layout');
		if (is_singular()) {
		    $theme_layout = get_post_meta($post->ID, 'mom_theme_layout', true);
		    if ($theme_layout == '') {
			$theme_layout = mom_option('theme_layout');
		    }
		}
        if($theme_layout == 'boxed') {
            $mom_layout = ' class="fixed_wrap fixed clearfix"';
        } else if($theme_layout == 'boxed2') {
            $mom_layout = ' class="fixed_wrap fixed2 clearfix"';
        } else {
            $mom_layout = ' class="fixed_wrap"';
        }
        ?>
        <div class="wrap_every_thing">
        <div<?php echo $mom_layout; ?>><!--fixed layout-->
            <div class="wrap clearfix"><!--wrap-->
                <header class="header"><!--Header-->
                <div id="header-wrapper"><!-- header wrap -->
                <?php get_template_part('topbanner'); ?>
				<?php if(mom_option('tb_disable')) { get_template_part( 'framework/includes/topbar' );  } ?>

                    <div class="header-wrap"><!--header content-->
                        <div class="inner"><!--inner-->
                        	<?php get_template_part( 'framework/includes/header-content' ); ?>
                        </div><!--inner-->
                    </div><!--header content-->
                </div><!-- header wrap -->

				<?php get_template_part( 'framework/includes/navigation' ); ?>

                <?php if(mom_option('bn_bar')) { get_template_part( 'framework/includes/breaking' ); } ?>

            </header><!--Header-->
             <?php get_template_part('unavbanner'); ?>
            <?php do_action('mom_before_content'); ?>
