<?php
add_action('wp_head', 'mom_custom_colors', 160);
function mom_custom_colors() {
	global $post;
	$pagecolor = get_post_meta(get_the_ID(), 'mom_page_color', true);

	$maincolor = mom_option('main-color');
	global $wp_query;
	$cat_ID = get_query_var('cat');
	if (is_single()) {
		global $post;
		$cat_ID = get_the_category( $post->ID );
		if ($cat_ID != false) {
		$cat_ID = $cat_ID[0]->term_id;
		}
	}
	$cat_color = '';
	if ($cat_ID != false) {
	$cat_data = get_option("category_".$cat_ID);
	$cat_color = isset($cat_data['color']) ? $cat_data['color'] : '' ;
	$cat_bg = isset($cat_data['bg']) ? $cat_data['bg'] : '' ;
	}
?>
	<style type="text/css" class="multinews-custom-dynamic-css">
	<?php if(mom_option('font-name') != '') { ?>
		@font-face {
		    font-family: '<?php echo mom_option("font-name"); ?>';
		    src: url('<?php echo mom_option("font-eot","url"); ?>');
		    src: url('<?php echo mom_option("font-eot","url"); ?>?#iefix') format('embedded-opentype'),
		    url('<?php echo mom_option("font-woff","url"); ?>') format('woff'),
		    url('<?php echo mom_option("font-ttf","url"); ?>') format('truetype'),
		    url('<?php echo mom_option("font-svg","url"); ?>#<?php echo mom_option("font-name"); ?>') format('svg');
		    font-weight: <?php echo mom_option("mom-font-weight"); ?>;
		    font-style: <?php echo mom_option("mom-font-style"); ?>;

		}
	<?php } ?>
	<?php if(mom_option('bn_type') == 'up') { ?>
			ul.webticker li{
				float: none !important;
				margin-right: 0;
				padding-left: 20px;
			}
	<?php } ?>
	<?php if(mom_option('nph-typo') != '') { ?>
		header.block-title h2 a, header.block-title h2, .section-header h2.section-title a, .section-header h2.section-title{
			color: <?php echo mom_option('nph-typo', 'color'); ?>;
		}
	<?php } ?>
	<?php if(mom_option('wit-typo') != '') { ?>
		.widget-title h2{
			color: <?php echo mom_option('wit-typo', 'color'); ?>;
		}
	<?php } ?>
	<?php if(mom_option('header_height') != '') { ?>
		.header-wrap > .inner,
		.header-wrap{
			line-height: <?php echo mom_option('header_height'); ?>px;
			height: <?php echo mom_option('header_height'); ?>px;
		}
	<?php } ?>
	<?php if(mom_option('logo_align') == 'center') { ?>
		<?php if ( !is_page_template('magazine.php')) { ?>

	.logo{
		float: none;
		text-align: center;
	}
	.header-banner{
		float: none;
		margin: auto;
		margin-bottom: 20px;
	}
	.header-wrap > .inner, .header-wrap {
		height: auto;
	}
	<?php } ?>
	<?php } ?>
	<?php if (mom_option('body_background', 'background-color') != '' && mom_option('body_background', 'background-image') == '') { ?>
		body {
			background: <?php echo mom_option('body_background', 'background-color'); ?>;
		}
	<?php } ?>
	<?php if(mom_option('nav_bg_hover_drop') != '') { ?>
		.navigation .mom-megamenu ul li.active:before, .navigation .mom-megamenu ul li:hover:before{
			border-left-color: <?php echo mom_option('nav_bg_hover_drop', 'rgba'); ?>;
		}
	<?php } ?>
	<?php if(mom_option('nav_border_drop') != '') { ?>
		.navigation .mom-megamenu ul li:last-child {
			border-color: <?php echo mom_option('nav_border_drop'); ?> !important;
		}
	<?php } ?>
	<?php if($maincolor != '') { ?>
	/* Main color */
		.entry-crumbs,.entry-crumbs .vbreadcrumb>a,.cat-slider-nav-title,.f-tabbed-head li a.current,.media-main-content .f-tabbed-head li.active a span,.media-main-content .f-tabbed-head li a:hover span,.media-main-content .f-tabbed-head li.active a,.media-main-content .f-tabbed-head li a:hover,.f-tabbed-head li.active a,.f-tabbed-head li a:hover,.cat-grid li h2 a,header.block-title h2 a,header.block-title h2,.sidebar a:hover,.secondary-sidebar a:hover,.main-container a:hover,.sidebar .post-list li h2 a:hover,.secondary-sidebar .post-list li h2 a:hover,.nb1 ul li h2 a:hover,.nb2 .first-item h2 a:hover,.nb3 .first-item h2 a:hover,.nb4 .first-item h2 a:hover,.nb5 .first-item h2 a:hover,.nb6 ul li h2 a:hover,.nb3 ul li h2 a:hover,.nb4 ul li h2 a:hover,.nb2 ul li h2 a:hover,.nb5 ul li h2 a:hover,ul.f-tabbed-list li h2 a:hover,.scroller .owl-next:hover:after,.scroller .owl-prev:hover:before,.sidebar .widget_categories li:hover,.sidebar .widget_categories li:hover a,.secondary-sidebar .widget_categories li:hover,.secondary-sidebar .widget_categories li:hover a,.scroller2 .owl-next:hover:after,.scroller2 .owl-prev:hover:before,.mom-related-posts li:hover h2 a,ul.widget-tabbed-header li a.current,.secondary-sidebar .post-list li .read-more-link,ul.mom_tabs li a.current,ul.mom_tabs li a:hover,.accordion h2.active .acch_arrows:before,.accordion h2.active .acch_arrows:before,.accordion h2.active .acch_numbers,.accordion h2.active .acch_pm:before,ul.mom_tabs li a.current,ul.mom_tabs li a:hover,.tabs_v3 ul.mom_tabs li a.current,.toggle_active h4.toggle_title,.cat-slider-mpop ul li h2 a,.blog-post-big h2 a,.blog-post h2 a,.cat-list li h2 a,ul.widget-tabbed-header li a:hover,ul.widget-tabbed-header li a.current,.pagination span,h1.entry-title,.entry-content-data .post-thumbnail .img-toggle,a:hover,.sidebar .post-list li h2 a:hover,.secondary-sidebar .post-list li h2 a:hover,.nb1 ul li h2 a:hover,.nb2 .first-item h2 a:hover,.nb3 .first-item h2 a:hover,.nb4 .first-item h2 a:hover,.nb5 .first-item h2 a:hover,.nb6 ul li h2 a:hover,.nb3 ul li h2 a:hover,.nb4 ul li h2 a:hover,.nb2 ul li h2 a:hover,.nb5 ul li h2 a:hover,ul.f-tabbed-list li h2 a:hover,.scroller .owl-next:hover:after,.scroller .owl-prev:hover:before,.sidebar .widget_categories li:hover,.sidebar .widget_categories li:hover a,.secondary-sidebar .widget_categories li:hover,.secondary-sidebar .widget_categories li:hover a,.scroller2 .owl-next:hover:after,.scroller2 .owl-prev:hover:before,.mom-related-posts li:hover h2 a,.author-bio-name a,ol.nb-tabbed-head li.active a,.dropcap, .entry-crumbs,.entry-crumbs .vbreadcrumb>a,.f-tabbed-head li a.current,.media-main-content .f-tabbed-head li.active a span,.media-main-content .f-tabbed-head li a:hover span,.media-main-content .f-tabbed-head li.active a,.media-main-content .f-tabbed-head li a:hover,.f-tabbed-head li.active a,.f-tabbed-head li a:hover,.f-tabbed-head li a.current,.media-main-content .f-tabbed-head li.active a span,.media-main-content .f-tabbed-head li a:hover span,.media-main-content .f-tabbed-head li.active a,.media-main-content .f-tabbed-head li a:hover,.f-tabbed-head li.active a,.f-tabbed-head li a:hover,.weather-page-head,header.block-title h2 a,header.block-title h2,.sidebar a:hover,.secondary-sidebar a:hover,.main-container a:hover,.sidebar .post-list li h2 a:hover,.secondary-sidebar .post-list li h2 a:hover,.nb1 ul li h2 a:hover,.nb2 .first-item h2 a:hover,.nb3 .first-item h2 a:hover,.nb4 .first-item h2 a:hover,.nb5 .first-item h2 a:hover,.nb6 ul li h2 a:hover,.nb3 ul li h2 a:hover,.nb4 ul li h2 a:hover,.nb2 ul li h2 a:hover,.nb5 ul li h2 a:hover,ul.f-tabbed-list li h2 a:hover,.scroller .owl-next:hover:after,.scroller .owl-prev:hover:before,.sidebar .widget_categories li:hover,.sidebar .widget_categories li:hover a,.secondary-sidebar .widget_categories li:hover,.secondary-sidebar .widget_categories li:hover a,.scroller2 .owl-next:hover:after,.scroller2 .owl-prev:hover:before,.mom-related-posts li:hover h2 a,ul.widget-tabbed-header li a.current,.secondary-sidebar .post-list li .read-more-link,ul.mom_tabs li a.current,ul.mom_tabs li a:hover,.accordion h2.active .acch_arrows:before,.accordion h2.active .acch_arrows:before,.accordion h2.active .acch_numbers,.accordion h2.active .acch_pm:before,ul.mom_tabs li a.current,ul.mom_tabs li a:hover,.tabs_v3 ul.mom_tabs li a.current,.toggle_active h4.toggle_title,ul.products li .mom_product_details .price,.star-rating,.star-rating,.main_tabs .tabs li.active>a,.blog-post-big h2 a,.blog-post h2 a,.cat-list li h2 a,ol.nb-tabbed-head li.active a,.dropcap, a:hover, .mom-archive ul li ul li a:hover, header.block-title h2 a, header.block-title h2, .error-page .search-form .esearch-submit, .post-list .star-rating, .star-rating, .entry-content-data .story-highlights h4, .entry-content-data .story-highlights ul li:hover a:before, .bbp-body .bbp-forum-title, .mom-main-color, .site-content  .mom-main-color, .bbp-forum-freshness .bbp-author-name, .mom-bbp-topic-data .bbp-topic-permalink, .bbp-topics .bbp-author-name, .bbp-pagination-links span.current, .mom-main-color a, #buddypress div#item-header div#item-meta a, #buddypress div.item-list-tabs ul li span, #buddypress div#object-nav.item-list-tabs ul li.selected a, #buddypress div#object-nav.item-list-tabs ul li.current a, #buddypress div#subnav.item-list-tabs ul li.selected a, #buddypress div#subnav.item-list-tabs ul li.current a, .entry-crumbs a{
			color: <?php echo $maincolor ?>;
		}
      .entry-crumbs .crumb-icon,.sidebar .widget_archive li:hover a:before,.widget_archive li:hover a:before,.widget_pages li:hover a:before,.widget_meta li:hover a:before,.widget_categories li:hover a:before,.accordion h2.active:before,.accordion h2:hover:before,a.mom_button,.mom_iconbox_square,.mom_iconbox_circle,.toggle_active:before,.cat-slider-nav ul li.activeSlide,.cat-slider-nav ul li:hover,.top-cat-slider-nav ul li:hover,a.read-more,.cat-slider-nav ul li.activeSlide:after,.cat-slider-nav ul li:hover:after,.cat-slider-nav ul li.activeSlide:before,.cat-slider-nav ul li:hover:before,.top-cat-slider-nav ul li:hover:after,.top-cat-slider-nav ul li:hover:before,.button,.mom_button,input[type="submit"],button[type="submit"],a.read-more,.brmenu .nav-button.nav-cart span.numofitems, .entry-crumbs .crumb-icon,.weather-page-icon,.weather-switch-tabs .w-unit.selected,.sidebar .widget_archive li:hover a:before,.media-cat-filter ul>li:hover>a:before,.widget_archive li:hover a:before,.widget_pages li:hover a:before,.widget_meta li:hover a:before,.widget_categories li:hover a:before,.accordion h2.active:before,.accordion h2:hover:before,a.mom_button,.mom_iconbox_square,.mom_iconbox_circle,.toggle_active:before,button,input[type="button"],input[type="reset"],input[type="submit"],.woocommerce .widget_price_filter .ui-slider .ui-slider-handle,.woocommerce-page .widget_price_filter .ui-slider .ui-slider-handle,a.read-more,.brmenu .nav-button.nav-cart span.numofitems, .widget ul:not(.widget-tabbed-header):not(.social-counter):not(.social-widget):not(.latest-comment-list):not(.npwidget):not(.post-list):not(.twiter-list):not(.user-login-links):not(.login-links):not(.product_list_widget):not(.twiter-buttons):not(.w-co-w)>li:hover>a:before,.sidebar .widget_archive li:hover a:before,.media-cat-filter ul>li:hover>a:before,.widget_archive li:hover a:before,.widget_pages li:hover a:before,.widget_meta li:hover a:before,.widget_categories li:hover a:before,.widget_nav_menu ul li a:hover:before, .mom-archive ul li ul li a:before{
      		background-color: <?php echo $maincolor ?>;
      }
      .cat-slider-nav ul li.activeSlide,.cat-slider-nav ul li:hover,.top-cat-slider-nav ul li:hover,.cat-slider-nav ul li.activeSlide+li,.cat-slider-nav ul li:hover+li,.top-cat-slider-nav ul li:hover+li, .tagcloud a:hover, .mom_quote .quote-arrow, .toggle_active:before, .mom_quote{
      		border-color: <?php echo $maincolor ?>;
      }
      .cat-slider-nav ul li.activeSlide h2:before,.cat-slider-nav ul li:hover h2:before,.top-cat-slider-nav ul li:hover h2:before, .rtl .entry-crumbs .crumb-icon:before, .rtl .weather-page-icon:before{
      		border-right-color: <?php echo $maincolor ?>;
      }
      .entry-crumbs .crumb-icon:before, .weather-page-icon:before, .entry-crumbs .crumb-icon:before{
      		border-left-color: <?php echo $maincolor ?>;
      }
      <?php if(is_rtl()) { ?>
		.rtl .entry-crumbs .crumb-icon:before{
		border-right-color: <?php echo $maincolor; ?>;
		}
		.rtl .cat-slider-nav ul li.activeSlide h2:before, .rtl .cat-slider-nav ul li:hover h2:before{
		border-left-color: <?php echo $maincolor; ?>;
		}
		<?php } ?>
	<?php } ?>
	<?php if($pagecolor != '') { ?>
	/* Page color */
	.entry-crumbs .crumb-icon,.weather-page-icon,.weather-switch-tabs .w-unit.selected,.sidebar .widget_archive li:hover a:before,.media-cat-filter ul > li:hover > a:before,.widget_archive li:hover a:before,.widget_pages li:hover a:before,.widget_meta li:hover a:before,.widget_categories li:hover a:before, .accordion h2.active:before, .accordion h2:hover:before, a.mom_button, .mom_iconbox_square, .mom_iconbox_circle, .toggle_active:before,button, input[type="button"], input[type="reset"], input[type="submit"], .woocommerce .widget_price_filter .ui-slider .ui-slider-handle, .woocommerce-page .widget_price_filter .ui-slider .ui-slider-handle, a.read-more, .brmenu .nav-button.nav-cart span.numofitems{
		background: <?php echo $pagecolor; ?>;
	}
	.weather-page-icon:before, .entry-crumbs .crumb-icon:before{
		border-left-color: <?php echo $pagecolor; ?>;
	}
	<?php if(is_rtl()) { ?>
	.rtl .entry-crumbs .crumb-icon:before{
		border-right-color: <?php echo $pagecolor; ?>;
	}
	.rtl .weather-page-icon:before{
		border-right-color: <?php echo $pagecolor; ?>;
	}
	<?php } ?>
	.entry-crumbs,.entry-crumbs .vbreadcrumb > a, .entry-crumbs a, .woocommerce-breadcrumb a,  .f-tabbed-head li a.current, .media-main-content .f-tabbed-head li.active a span, .media-main-content .f-tabbed-head li a:hover span, .media-main-content .f-tabbed-head li.active a, .media-main-content .f-tabbed-head li a:hover, .f-tabbed-head li.active a, .f-tabbed-head li a:hover,.f-tabbed-head li a.current, .media-main-content .f-tabbed-head li.active a span, .media-main-content .f-tabbed-head li a:hover span, .media-main-content .f-tabbed-head li.active a, .media-main-content .f-tabbed-head li a:hover, .f-tabbed-head li.active a, .f-tabbed-head li a:hover, .weather-page-head, header.block-title h2 a, header.block-title h2, .sidebar a:hover, .secondary-sidebar a:hover, .main-container a:hover, .sidebar .post-list li h2 a:hover, .secondary-sidebar .post-list li h2 a:hover, .nb1 ul li h2 a:hover, .nb2 .first-item h2 a:hover, .nb3 .first-item h2 a:hover, .nb4 .first-item h2 a:hover, .nb5 .first-item h2 a:hover, .nb6 ul li h2 a:hover, .nb3 ul li h2 a:hover, .nb4 ul li h2 a:hover, .nb2 ul li h2 a:hover, .nb5 ul li h2 a:hover, ul.f-tabbed-list li h2 a:hover, .scroller .owl-next:hover:after, .scroller .owl-prev:hover:before, .sidebar .widget_categories li:hover, .sidebar .widget_categories li:hover a, .secondary-sidebar .widget_categories li:hover, .secondary-sidebar .widget_categories li:hover a, .scroller2 .owl-next:hover:after, .scroller2 .owl-prev:hover:before, .mom-related-posts li:hover h2 a, ul.widget-tabbed-header li a.current, .secondary-sidebar .post-list li .read-more-link, ul.mom_tabs li a.current, ul.mom_tabs li a:hover, .accordion h2.active .acch_arrows:before, .accordion h2.active .acch_arrows:before, .accordion h2.active .acch_numbers, .accordion h2.active .acch_pm:before, ul.mom_tabs li a.current,ul.mom_tabs li a:hover, .tabs_v3 ul.mom_tabs li a.current, .toggle_active h4.toggle_title, ul.products li .mom_product_details .price, .star-rating, .star-rating, .main_tabs .tabs li.active > a, .blog-post-big h2 a, .blog-post h2 a, .cat-list li h2 a, ol.nb-tabbed-head li.active a, .dropcap, .post-list .star-rating, .star-rating, .mom-page-title h1, vid-box-nav li.active h2 a{
		color: <?php echo $pagecolor; ?> !important;
	}
	.tagcloud a:hover, .mom_quote .quote-arrow, .toggle_active:before, .mom_quote{
		border-color: <?php echo $pagecolor; ?>;
	}
	<?php } ?>
	/* navigation style */
	<?php if(mom_option('nav-itemcolor') == 0) { ?>
	.navigation{
		height: 42px;
	}
	ul.main-menu > li > a{
		padding-bottom: 0 !important;
	}
	.navigation ul.main-menu > li .mom-megamenu,
	.navigation ul.main-menu > li:not(.mom_mega) ul.sub-menu{
		top: 42px;
	}
	.navigation ul.main-menu > li .mom-megamenu ul.sub-menu{
		top: 0;
	}
	.navigation ul.main-menu li a span.menu_bl{
		display: none;
	}
	<?php } ?>
	<?php if($cat_color != '') { ?>
	/* Category color */
	.entry-crumbs .crumb-icon,.sidebar .widget_archive li:hover a:before,.widget_archive li:hover a:before,.widget_pages li:hover a:before,.widget_meta li:hover a:before,.widget_categories li:hover a:before, .accordion h2.active:before, .accordion h2:hover:before, a.mom_button, .mom_iconbox_square, .mom_iconbox_circle, .toggle_active:before,.cat-slider-nav ul li.activeSlide,.cat-slider-nav ul li:hover,.top-cat-slider-nav ul li:hover,a.read-more,.cat-slider-nav ul li.activeSlide:after, .cat-slider-nav ul li:hover:after,.cat-slider-nav ul li.activeSlide:before, .cat-slider-nav ul li:hover:before,.top-cat-slider-nav ul li:hover:after,.top-cat-slider-nav ul li:hover:before,.button, .mom_button, input[type="submit"], button[type="submit"],a.read-more, .brmenu .nav-button.nav-cart span.numofitems{
		background: <?php echo $cat_color; ?>;
	}
	<?php if(is_rtl()) { ?>
	.rtl .entry-crumbs .crumb-icon:before{
	border-right-color: <?php echo $cat_color; ?>;
	}
	.rtl .cat-slider-nav ul li.activeSlide h2:before, .rtl .cat-slider-nav ul li:hover h2:before{
	border-left-color: <?php echo $cat_color; ?>;
	}
	<?php } ?>
    .cat-slider-nav ul li.activeSlide,.cat-slider-nav ul li:hover,.top-cat-slider-nav ul li:hover,.cat-slider-nav ul li.activeSlide+li,.cat-slider-nav ul li:hover+li,.top-cat-slider-nav ul li:hover+li{
		border-color: <?php echo $cat_color; ?>;
	}
	.cat-slider-nav ul li.activeSlide h2:before,
	.cat-slider-nav ul li:hover h2:before,
	.top-cat-slider-nav ul li:hover h2:before{
		border-right-color: <?php echo $cat_color; ?>;
	}
	.entry-crumbs .crumb-icon:before{
		border-left-color: <?php echo $cat_color; ?>;
	}
	<?php if(is_rtl()) { ?>
	.entry-crumbs .crumb-icon:before{
	border-right-color: <?php echo $cat_color; ?>;
	}
	<?php } ?>
	.entry-crumbs,
	.entry-crumbs .vbreadcrumb > a, .woocommerce-breadcrumb a,
	.cat-slider-nav-title,
	.f-tabbed-head li a.current, .media-main-content .f-tabbed-head li.active a span, .media-main-content .f-tabbed-head li a:hover span, .media-main-content .f-tabbed-head li.active a, .media-main-content .f-tabbed-head li a:hover, .f-tabbed-head li.active a, .f-tabbed-head li a:hover, .cat-grid li h2 a, header.block-title h2 a, header.block-title h2, .sidebar a:hover, .secondary-sidebar a:hover, .main-container a:hover, .sidebar .post-list li h2 a:hover, .secondary-sidebar .post-list li h2 a:hover, .nb1 ul li h2 a:hover, .nb2 .first-item h2 a:hover, .nb3 .first-item h2 a:hover, .nb4 .first-item h2 a:hover, .nb5 .first-item h2 a:hover, .nb6 ul li h2 a:hover, .nb3 ul li h2 a:hover, .nb4 ul li h2 a:hover, .nb2 ul li h2 a:hover, .nb5 ul li h2 a:hover, ul.f-tabbed-list li h2 a:hover, .scroller .owl-next:hover:after, .scroller .owl-prev:hover:before, .sidebar .widget_categories li:hover, .sidebar .widget_categories li:hover a, .secondary-sidebar .widget_categories li:hover, .secondary-sidebar .widget_categories li:hover a, .scroller2 .owl-next:hover:after, .scroller2 .owl-prev:hover:before, .mom-related-posts li:hover h2 a, ul.widget-tabbed-header li a.current, .secondary-sidebar .post-list li .read-more-link, ul.mom_tabs li a.current, ul.mom_tabs li a:hover, .accordion h2.active .acch_arrows:before, .accordion h2.active .acch_arrows:before, .accordion h2.active .acch_numbers, .accordion h2.active .acch_pm:before, ul.mom_tabs li a.current,
	ul.mom_tabs li a:hover, .tabs_v3 ul.mom_tabs li a.current, .toggle_active h4.toggle_title, .cat-slider-mpop ul li h2 a,
	.blog-post-big h2 a, .blog-post h2 a, .cat-list li h2 a, ul.widget-tabbed-header li a:hover, ul.widget-tabbed-header li a.current,
	.pagination span, h1.entry-title, .entry-content-data .post-thumbnail .img-toggle,
	a:hover, .sidebar .post-list li h2 a:hover, .secondary-sidebar .post-list li h2 a:hover, .nb1 ul li h2 a:hover, .nb2 .first-item h2 a:hover, .nb3 .first-item h2 a:hover, .nb4 .first-item h2 a:hover, .nb5 .first-item h2 a:hover, .nb6 ul li h2 a:hover, .nb3 ul li h2 a:hover, .nb4 ul li h2 a:hover, .nb2 ul li h2 a:hover, .nb5 ul li h2 a:hover, ul.f-tabbed-list li h2 a:hover, .scroller .owl-next:hover:after, .scroller .owl-prev:hover:before, .sidebar .widget_categories li:hover, .sidebar .widget_categories li:hover a, .secondary-sidebar .widget_categories li:hover, .secondary-sidebar .widget_categories li:hover a, .scroller2 .owl-next:hover:after, .scroller2 .owl-prev:hover:before, .mom-related-posts li:hover h2 a, .author-bio-name a, ol.nb-tabbed-head li.active a, .dropcap, .post-list .star-rating, .star-rating, .mom-page-title h1, .entry-content-data .story-highlights h4, .entry-crumbs a {
		color: <?php echo $cat_color; ?>;
	}
	<?php } ?>
	<?php /* Links color */ if (mom_option('link-color', 'regular') != '') { ?>
		a, .mom-archive ul li ul li a {
			color: <?php echo mom_option('link-color', 'regular'); ?>;
		}
	<?php } ?>

	<?php if (mom_option('link-color', 'hover') != '') { ?>
		a:hover, .mom-archive ul li ul li a:hover {
			color: <?php echo mom_option('link-color', 'hover'); ?>;
		}
	<?php } ?>

	<?php if (mom_option('link-color', 'active') != '') { ?>
		a:active, .mom-archive ul li ul li a:active{
			color: <?php echo mom_option('link-color', 'active'); ?>;
		}
	<?php } ?>
	<?php /* Custom css */ echo mom_option('custom_css'); ?>
<?php if (is_singular()) {
    global $post;

    //custom page/post background
    $page_bg = get_post_meta($post->ID, 'mom_custom_bg', true);
    $page_bg_img = get_post_meta($post->ID, 'mom_custom_bg_img', true);
    $page_bg_pos = get_post_meta($post->ID, 'mom_custom_bg_pos', true);
    $page_bg_repeat = get_post_meta($post->ID, 'mom_custom_bg_repeat', true);
    $page_bg_attach = get_post_meta($post->ID, 'mom_custom_bg_attach', true);
    $page_bg_size = get_post_meta($post->ID, 'mom_custom_bg_size', true);

if ($page_bg == '' && $page_bg_img == '') {
if (is_single()) {
$cID =  get_the_category();
$cID = $cID[0]->term_id;
$cdata = get_option("category_".$cID);
$cat_bg = isset($cdata['bg']) ? $cdata['bg'] : '' ;
if ($cat_bg != '' && is_array($cat_bg)) {
?>
body {
<?php if (isset($cat_bg['color']) && $cat_bg['color'] != '') { ?>
    background: <?php echo $cat_bg['color']; ?>;
<?php } ?>
<?php if (isset($cat_bg['image']) && $cat_bg['image'] != '') { ?>
    background-image: url(<?php echo $cat_bg['image']; ?>);
<?php if (isset($cat_bg['position']) && $cat_bg['position'] != '') { ?>
    background-position:<?php echo $cat_bg['position']; ?>;
<?php } ?>
<?php if (isset($cat_bg['repeat']) && $cat_bg['repeat'] != '') { ?>
    background-repeat:<?php echo $cat_bg['repeat']; ?>;
<?php } ?>
<?php if (isset($cat_bg['attachment']) && $cat_bg['attachment'] != '') { ?>
    background-attachment:<?php echo $cat_bg['attachment']; ?>;
<?php } ?>
<?php if (isset($cat_bg['size']) && $cat_bg['size'] != '') { ?>
    background-size:<?php echo $cat_bg['size']; ?>;
<?php } ?>
<?php } ?>
}
<?php }
}
}
?>
body {
<?php if ($page_bg != '') { ?>
    background: <?php echo $page_bg; ?>;
<?php } ?>
<?php if ($page_bg_img != '') { ?>
    background-image: url(<?php echo $page_bg_img; ?>);
<?php if ($page_bg_pos != '') { ?>
    background-position:<?php echo $page_bg_pos; ?>;
<?php } ?>
<?php if ($page_bg_repeat != '') { ?>
    background-repeat:<?php echo $page_bg_repeat; ?>;
<?php } ?>
<?php if ($page_bg_attach != '') { ?>
    background-attachment:<?php echo $page_bg_attach; ?>;
<?php } ?>
<?php if ($page_bg_size != '') { ?>
    background-size:<?php echo $page_bg_size; ?>;
<?php } ?>
<?php } ?>

}
<?php } ?>
<?php
if (is_category()) {
$cID = get_query_var('cat');
$cdata = get_option("category_".$cID);
$cat_bg = isset($cdata['bg']) ? $cdata['bg'] : '' ;
if ($cat_bg != '' && is_array($cat_bg)) {
?>
body {
<?php if (isset($cat_bg['color']) && $cat_bg['color'] != '') { ?>
    background: <?php echo $cat_bg['color']; ?>;
<?php } ?>
<?php if (isset($cat_bg['image']) && $cat_bg['image'] != '') { ?>
    background-image: url(<?php echo $cat_bg['image']; ?>);
<?php if (isset($cat_bg['position']) && $cat_bg['position'] != '') { ?>
    background-position:<?php echo $cat_bg['position']; ?>;
<?php } ?>
<?php if (isset($cat_bg['repeat']) && $cat_bg['repeat'] != '') { ?>
    background-repeat:<?php echo $cat_bg['repeat']; ?>;
<?php } ?>
<?php if (isset($cat_bg['attachment']) && $cat_bg['attachment'] != '') { ?>
    background-attachment:<?php echo $cat_bg['attachment']; ?>;
<?php } ?>
<?php if (isset($cat_bg['size']) && $cat_bg['size'] != '') { ?>
    background-size:<?php echo $cat_bg['size']; ?>;
<?php } ?>
<?php } ?>
}
<?php } }
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


    //custom page/post background
    $page_bg = get_post_meta($woo_page_id, 'mom_custom_bg', true);
    $page_bg_img = get_post_meta($woo_page_id, 'mom_custom_bg_img', true);
    $page_bg_pos = get_post_meta($woo_page_id, 'mom_custom_bg_pos', true);
    $page_bg_repeat = get_post_meta($woo_page_id, 'mom_custom_bg_repeat', true);
    $page_bg_attach = get_post_meta($woo_page_id, 'mom_custom_bg_attach', true);
    $page_bg_size = get_post_meta($woo_page_id, 'mom_custom_bg_size', true);
?>
<?php if ($page_bg != '') { ?>
body {
    background: <?php echo $page_bg; ?>;
<?php if ($page_bg_img != '') { ?>
    background-image: url(<?php echo $page_bg_img; ?>);
<?php } ?>
<?php if ($page_bg_pos != '') { ?>
    background-position:<?php echo $page_bg_pos; ?>;
<?php } ?>
<?php if ($page_bg_repeat != '') { ?>
    background-repeat:<?php echo $page_bg_repeat; ?>;
<?php } ?>
<?php if ($page_bg_attach != '') { ?>
    background-attachment:<?php echo $page_bg_attach; ?>;
<?php } ?>
<?php if ($page_bg_size != '') { ?>
    background-size:<?php echo $page_bg_size; ?>;
<?php } ?>
}
<?php } ?>
<?php }
if(mom_option('cat_hp_color') != '0') {
$of_categories 		= array();
$of_categories_obj 	= get_categories('hide_empty=0');
foreach ($of_categories_obj as $of_cat) {
    $of_categories = $of_cat->cat_ID;

$cat_data2 = get_option("category_$of_categories");
$cat_color = $cat_data2['color'];
if( get_option("category_$of_categories") ){ ?>
	section.news-box.cat_<?php echo $of_categories ; ?> header.block-title:not(.colorful-box) h2 a,
	section.news-box.cat_<?php echo $of_categories ; ?> header.block-title:not(.colorful-box) h2,
	.f-tabbed-head li.cat_<?php echo $of_categories ; ?>.active a,
	.f-tabbed-head li.cat_<?php echo $of_categories ; ?> a.current,
	.f-tabbed-head li.cat_<?php echo $of_categories ; ?> a:hover,
	.f-tabbed-body.cat_<?php echo $of_categories ; ?> ul.f-tabbed-list li h2 a:hover,
	section.news-box.cat_<?php echo $of_categories ; ?> footer.show-more a:hover,
    section.news-box.cat_<?php echo $of_categories ; ?> .nb1 ul li h2 a:hover,
    section.news-box.cat_<?php echo $of_categories ; ?> .nb2 .first-item h2 a:hover,
    section.news-box.cat_<?php echo $of_categories ; ?> .nb3 .first-item h2 a:hover,
    section.news-box.cat_<?php echo $of_categories ; ?> .nb4 .first-item h2 a:hover,
    section.news-box.cat_<?php echo $of_categories ; ?> .nb5 .first-item h2 a:hover,
    section.news-box.cat_<?php echo $of_categories ; ?> .nb6 ul li h2 a:hover,
    section.news-box.cat_<?php echo $of_categories ; ?> .nb3 ul li h2 a:hover,
    section.news-box.cat_<?php echo $of_categories ; ?> .nb4 ul li h2 a:hover,
    section.news-box.cat_<?php echo $of_categories ; ?> .nb2 ul li h2 a:hover,
    section.news-box.cat_<?php echo $of_categories ; ?> .nb5 ul li h2 a:hover,
    .section .feature-tabbed.cat_<?php echo $of_categories ; ?> ul.f-tabbed-list li h2 a:hover,
    .nip-box.cat_<?php echo $of_categories ; ?> header.block-title:not(.colorful-box) h2{
	    color: <?php echo $cat_color ; ?>;
	}
<?php } } } ?>

<?php
//custom fonts
$cf = get_option('mom_custom_fonts');
if (isset($cf['custom_fonts']) && is_array($cf['custom_fonts'])) {
foreach ($cf['custom_fonts'] as $font) { ?>
@font-face {
font-family: '<?php echo $font['font_name']; ?>';
src: url('<?php echo $font['eot']; ?>'); /* IE9 Compat Modes */
src: url('<?php echo $font['eot']; ?>?#iefix') format('embedded-opentype'),
url('<?php echo $font['woff']; ?>') format('woff'),
url('<?php echo $font['ff']; ?>')  format('truetype'),
url('<?php echo $font['svg']; ?>#svgFontName') format('svg');
}
<?php } } ?>
/* ==========================================================================
                 	Visual composer
========================================================================== */
.wpb_row, .wpb_content_element, ul.wpb_thumbnails-fluid > li, .wpb_button {
    margin-bottom: 20px;
}
.wpb_row .wpb_wrapper > *:last-child {
	margin-bottom: 0;
}

<?php
$bsd_container_width = mom_option('bsd_container_width');
$bsd_main_content_width = mom_option('bsd_main_content_width');
$bsd_main_sidebar_width = mom_option('bsd_main_sidebar_width');
$bsd_sec_sidebar_width = mom_option('bsd_sec_sidebar_width');
$bsd_margins = mom_option('bsd_margins');

$osd_container_width = mom_option('osd_container_width');
$osd_main_content_width = mom_option('osd_main_content_width');
$osd_main_sidebar_width = mom_option('osd_main_sidebar_width');
$osd_margins = mom_option('osd_margins');

$layout = mom_get_pageLayout();
$advanced_layout = true;
if ($advanced_layout == true) { ?>
.inner, .main-container {
width:auto;
padding: 0 20px;
}
<?php
if ($bsd_container_width != '') {
if (mom_option('theme_layout') == '') { ?>
.inner, .main-container {
	width:<?php echo $bsd_container_width; ?>;
}
<?php } else { ?>
	.fixed, .fixed2 {
	width:<?php echo $bsd_container_width; ?>;
	}
<?php }
}
if ($bsd_main_content_width != '') { ?>
.main-content, .main-content.vc_column_container {
width:<?php echo $bsd_main_content_width; ?>;
}
<?php }
if ($bsd_main_sidebar_width != '') { ?>
.sidebar, .sidebar.vc_column_container, .media-filter {
width:<?php echo $bsd_main_sidebar_width; ?>;
}
<?php } if ($bsd_sec_sidebar_width != '') { ?>
.secondary-sidebar, .secondary-sidebar.vc_column_container {
width:<?php echo $bsd_sec_sidebar_width; ?>;
}
<?php }
if ($bsd_margins != '') { ?>
.media-filter, .both-sidebars-right .secondary-sidebar, .secondary-sidebar.vc_column_container:not(.alignlefti),
.both-sidebars-right .sidebar, .sidebar.vc_column_container:not(.alignlefti)
 {
margin: 0;
margin-left:<?php echo $bsd_margins; ?>;
}

.both-sidebars-left .secondary-sidebar, .secondary-sidebar.vc_column_container.alignlefti,
.both-sidebars-left .sidebar, .sidebar.vc_column_container.alignlefti, .both-sidebars-all .secondary-sidebar
 {
margin: 0;
margin-right:<?php echo $bsd_margins; ?>;
}

.both-sidebars-left .main-left, .both-sidebars-all .main-left {
float: none;
}
<?php }

if ($osd_container_width != '') { ?>
.one_side_bar_layout:not(.both-sides-true) .fixed, .one_side_bar_layout:not(.both-sides-true) .fixed2 {
width:<?php echo $osd_container_width; ?>;
}
<?php }
if ($osd_main_content_width != '') { ?>
.one_side_bar_layout:not(.both-sides-true) .main-content:not(.both-sides-layout), .one_side_bar_layout .vc_sidebar.sidebar+.main-content.both-sides-layout,
.one_side_bar_layout .main-content.one_side:not(.both-sides-layout), .media-main-content {
width:<?php echo $osd_main_content_width; ?>;
}
<?php }
if ($osd_main_sidebar_width != '') { ?>
.one_side_bar_layout:not(.both-sides-true) .sidebar, .media-filter {
width:<?php echo $osd_main_sidebar_width; ?>;
}
<?php }

	} // end if enable advanced layout
 ?>
</style>
<?php
	}
?>
