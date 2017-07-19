<?php
/*
 * Custom CSS
 */

if ( !function_exists( 'boss_generate_option_css' ) ) {

	function boss_generate_option_css() {

		$limited_logo_height = false;
		$big_logo_h		 = boss_logo_height( 'big' );
		if($big_logo_h > 110) {
			$big_logo_h = 110;
			$limited_logo_height = true;
		}
		$small_logo_h	 = boss_logo_height( 'small' );

		$header_admin_class	 = '.right-col';
		$header_menu_class	 = '.left-col';

		if ( is_rtl() ) {
			$header_admin_class	 = '.left-col';
			$header_menu_class	 = '.right-col';
		}
		/** Capture CSS output * */
		ob_start();
		?>

		<?php if ( boss_get_option( 'mini_logo_switch' ) && boss_get_option( 'boss_small_logo', 'id' ) ) { ?>

			/* Header height based on logo height */
			body:not(.left-menu-open)[data-logo="1"] .site-header <?php echo $header_menu_class; ?> .table {
				height: <?php echo $small_logo_h . 'px'; ?>;
			}

			body.is-desktop:not(.left-menu-open)[data-logo="1"] #right-panel {
				margin-top: <?php echo $small_logo_h.'px'; ?>;
			}

			body.is-desktop:not(.left-menu-open)[data-logo="1"] #left-panel-inner {
				padding-top: <?php echo $small_logo_h.'px'; ?>;
			}

			body:not(.left-menu-open)[data-logo="1"].boxed .middle-col {
				height: <?php echo $small_logo_h . 'px'; ?>;
			}

			body:not(.left-menu-open)[data-logo="1"] #search-open,
			body:not(.left-menu-open)[data-logo="1"] .header-account-login,
			body:not(.left-menu-open)[data-logo="1"] #wp-admin-bar-shortcode-secondary .menupop,
			body:not(.left-menu-open)[data-logo="1"] .header-notifications {
				line-height: <?php echo $small_logo_h . 'px'; ?>;
				height: <?php echo $small_logo_h . 'px'; ?>;
			}

			body:not(.left-menu-open)[data-logo="1"] #wp-admin-bar-shortcode-secondary .ab-sub-wrapper,
			body:not(.left-menu-open)[data-logo="1"] .header-notifications .pop,
			body:not(.left-menu-open)[data-logo="1"] .header-account-login .pop {
				top: <?php echo $small_logo_h . 'px'; ?>;
			}

		<?php } ?>

		<?php if ( boss_get_option( 'logo_switch' ) && boss_get_option( 'boss_logo', 'id' ) ) { ?>
			<?php if($limited_logo_height) {?>
			body.left-menu-open #mastlogo #logo img {
				height: <?php echo $big_logo_h - 20 . 'px'; ?>;
				width: auto;
			}
			<?php } ?>
			body.left-menu-open[data-logo="1"] #mastlogo,
			body.left-menu-open[data-logo="1"] .site-header <?php echo $header_menu_class; ?>  .table {
			height: <?php echo $big_logo_h . 'px'; ?>;
			}

			body.is-desktop[data-header="1"] #header-menu > ul > li {
			height: <?php echo $big_logo_h - 70 . 'px'; ?>;
			}

			body.is-desktop.left-menu-open[data-logo="1"] #right-panel {
			margin-top: <?php echo $big_logo_h . 'px'; ?>;
			}

 			body.is-desktop.left-menu-open[data-logo="1"] #left-panel-inner {
 			padding-top: <?php echo $big_logo_h . 'px'; ?>;
 			}

			body.left-menu-open[data-logo="1"].boxed .middle-col {
			height: <?php echo $big_logo_h . 'px'; ?>;
			}

			body.left-menu-open[data-logo="1"] #search-open,
			body.left-menu-open[data-logo="1"] .header-account-login,
			body.left-menu-open[data-logo="1"] #wp-admin-bar-shortcode-secondary .menupop,
			body.left-menu-open[data-logo="1"] .header-notifications {
			line-height: <?php echo $big_logo_h . 'px'; ?>;
			height: <?php echo $big_logo_h . 'px'; ?>;
			}

			body.left-menu-open[data-logo="1"] #wp-admin-bar-shortcode-secondary .ab-sub-wrapper,
			body.left-menu-open[data-logo="1"] .header-notifications .pop,
			body.left-menu-open[data-logo="1"] .header-account-login .pop {
			top: <?php echo $big_logo_h . 'px'; ?>;
			}

		<?php } ?>

		body, p,
		input[type="text"],
		input[type="email"],
		input[type="url"],
		input[type="password"],
		input[type="search"],
		textarea {
			color: <?php echo esc_attr( boss_get_option( 'boss_body_font_color' ) ); ?>;
		}

		body,
		#wpwrap,
		<?php echo $header_menu_class; ?> .search-wrap,
		#item-buttons .pop .inner,
		#buddypress div#item-nav .item-list-tabs ul li.hideshow ul {
			background-color: <?php echo esc_attr( boss_get_option( 'boss_layout_body_color' ) ); ?>;
		}

		.archive.post-type-archive-bp_doc.bp-docs.bp-docs-create #primary,
		.archive.post-type-archive-bp_doc.bp-docs.bp-docs-create #secondary,
		.single-bp_doc.bp-docs #primary,
		.single-bp_doc.bp-docs #secondary,
		body .site, body #main-wrap {
			background-color: <?php echo esc_attr( boss_get_option( 'boss_layout_body_color' ) ); ?>;
		}

		.bp-avatar-nav ul.avatar-nav-items li.current {
		border-bottom-color: <?php echo esc_attr( boss_get_option( 'boss_layout_body_color' ) ); ?>
		}

		a {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_pr_color' ) ); ?>;
		}

		#item-buttons .pop .inner:before {
		background-color: <?php echo esc_attr( boss_get_option( 'boss_layout_body_color' ) ); ?>;
		}

		/* Heading Text color */
		.group-single #buddypress #item-header-cover #item-actions h3,
		.left-menu-open .group-single #buddypress #item-header-cover #item-actions h3,
		.comments-area article header cite a,
		#groups-stream li .item-desc p, #groups-list li .item-desc p,
		.directory.groups #item-statistics .numbers span p,
		.entry-title a, .entry-title,
		.widget_buddyboss_recent_post h3 a,
		h1, h2, h3, h4, h5, h6 {
		color: <?php echo esc_attr( boss_get_option( 'boss_heading_font_color' ) ); ?>;
		}

		#group-description .group-name,
		.author.archive .archive-header .archive-title a:hover,
		.entry-buddypress-content #group-create-body h4,
		.bb-add-label-button,
		.boss-modal-form a,
		.bb-message-tools > a,
		.bb-message-tools a.bbm-label-button,
		.widget_buddyboss_recent_post h3 a:hover,
		.sap-container-wrapper .sap-author-name.sap-author-name,
		a:hover {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		#wp-admin-bar-shortcode-secondary a.button {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		#wp-admin-bar-shortcode-secondary a.button:hover,
		.boss-modal-form a:hover {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_pr_color' ) ); ?>;
		}

		input[type="checkbox"].styled:checked + span:after,
		input[type="checkbox"].styled:checked + label:after,
		input[type="checkbox"].styled:checked + strong:after {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		.header-navigation ul li a span,
		input[type="radio"].styled:checked + span:before ,
		input[type="radio"].styled:checked + label:before ,
		input[type="radio"].styled:checked + strong:before {
		background-color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		input[type="radio"].styled + span:before,
		input[type="radio"].styled + label:before,
		input[type="radio"].styled + strong:before {
		border-color: <?php echo esc_attr( boss_get_option( 'boss_layout_body_color' ) ); ?>;
		}

		#buddypress input[type="text"]::-webkit-input-placeholder {
		color: <?php echo esc_attr( boss_get_option( 'boss_body_font_color' ) ); ?>;
		}
		#buddypress input[type="text"]:-ms-input-placeholder  {
		color: <?php echo esc_attr( boss_get_option( 'boss_body_font_color' ) ); ?>;
		}
		/* For Firefox 18 or under */
		#buddypress input[type="text"]:-moz-placeholder {
		color: <?php echo esc_attr( boss_get_option( 'boss_body_font_color' ) ); ?>;
		}
		/* For Firefox 19 or above */
		#buddypress input[type="text"]::-moz-placeholder {
		color: <?php echo esc_attr( boss_get_option( 'boss_body_font_color' ) ); ?>;
		}
		.header-navigation li.hideshow > ul,
		.header-navigation .sub-menu,
		body.activity:not(.bp-user)  .item-list-tabs ul li,
		.sap-publish-popup .button-primary,
		.logged-in .dir-form .item-list-tabs ul li, .dir-form .item-list-tabs ul li:last-child {
		border-color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?> !important;
		}
		.ui-tabs-nav li.ui-state-default a, body.activity:not(.bp-user)  .item-list-tabs ul li a, .dir-form .item-list-tabs ul li a {
		color: <?php echo esc_attr( boss_get_option( 'boss_body_font_color' ) ); ?> !important;
		}

		/* Buttons */
		.woocommerce #respond input#submit,
		.woocommerce a.button,
		.woocommerce button.button, .woocommerce input.button,
		.woocommerce #respond input#submit:hover,
		.woocommerce a.button:hover,
		.woocommerce button.button, .woocommerce input.button:hover,
		#buddypress .activity-list li.load-more a,
		#buddypress .activity-list li.load-newest a,
		.btn, button, input[type="submit"], input[type="button"]:not(.button-small), input[type="reset"], article.post-password-required input[type=submit], li.bypostauthor cite span, a.button, #create-group-form .remove, #buddypress ul.button-nav li a, #buddypress div.generic-button a, #buddypress .comment-reply-link, .entry-title a.button, span.create-a-group > a, #buddypress div.activity-comments form input[disabled],
		.woocommerce #respond input#submit.alt, .woocommerce a.button.alt,
		.woocommerce button.button.alt, .woocommerce input.button.alt,
		.woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover,
		.woocommerce ul.products li.product .add_to_cart_button:hover,
		.widget_price_filter .price_slider_amount button:hover,
		.woocommerce .widget_shopping_cart_content .buttons a:hover,
		.woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover {
		background-color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		body .boss-modal-form .button {
		background: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		.woocommerce a.remove,
		.woocommerce div.product p.price,
		.woocommerce div.product span.price,
		.woocommerce ul.products li.product .price {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		.widget_price_filter .price_slider_amount button:hover,
		.woocommerce ul.products li.product .add_to_cart_button:hover,
		.woocommerce .widget_price_filter .ui-slider .ui-slider-handle:hover {
		border-color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		#switch_submit {
		background-color: transparent;
		}

		.bb-slider-container .progress,
		.bb-slider-container .readmore a {
		background-color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		.selected-tab,
		.btn.inverse,
		.buddyboss-select-inner {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		border-color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		.btn-group.inverse > .btn {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		border-color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		.btn-group.inverse > .btn:first-child:not(:last-child) {
		border-color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		/* Widgets */
		.widget-area .widget:not(.widget_buddyboss_recent_post) ul li a {
		color: <?php echo esc_attr( boss_get_option( 'boss_body_font_color' ) ); ?>;
		}

		.widget .avatar-block img.avatar,
		.widget-area .widget.widget_bp_core_login_widget .bp-login-widget-register-link a,
		.widget-area .widget.buddyboss-login-widget a.sidebar-wp-register,
		.widget-area .widget_tag_cloud .tagcloud a,
		.widget-area .widget #sidebarme ul.sidebarme-quicklinks li.sidebarme-profile a:first-child,
		.widget-area .widget_bp_core_login_widget img.avatar,
		.widget-area .widget #sidebarme img.avatar {
		border-color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		.widget-area .widget.widget_buddyboss_recent_post  ul li a.category-link,
		.widget-area .widget.widget_bp_core_login_widget .bp-login-widget-register-link a,
		.widget-area .widget.buddyboss-login-widget a.sidebar-wp-register,
		.widget-area .widget_tag_cloud .tagcloud a,
		.widget-area .widget #sidebarme ul.sidebarme-quicklinks li.sidebarme-profile a:first-child,
		#wp-calendar td#today,
		.widget-area .widget:not(.widget_buddyboss_recent_post) ul li a:hover {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		.widget.widget_display_stats strong {
		background-color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		.a-stats a {
		background-color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?> !important;
		}

		.widget-area .widget div.item-options a.selected,
		.widget-area .widget .textwidget,
		.widget-area .widget:not(.widget_buddyboss_recent_post) ul li a {
		color: <?php echo esc_attr( boss_get_option( 'boss_body_font_color' ) ); ?>;
		}

		/* 404 */
		.error404 .entry-content p,
		.error404 h1 {
		color: <?php echo esc_attr( boss_get_option( 'boss_panel_color' ) ); ?>;
		}

		/* BuddyBoss Panel */
		#adminmenu,
		#adminmenuback,
		#adminmenuwrap,
		#adminmenu .wp-submenu,
		.menu-panel,
		.menu-panel #nav-menu .sub-menu-wrap,
		.menu-panel #header-menu .sub-menu-wrap,
		.bp_components ul li ul li.menupop .ab-sub-wrapper {
		background-color: <?php echo esc_attr( boss_get_option( 'boss_panel_color' ) ); ?>;
		}

		.left-menu-open .menu-panel #nav-menu > ul > li.current-menu-item > a,
		.left-menu-open .menu-panel #header-menu > ul > li.current-menu-item > a,
		.left-menu-open .menu-panel #nav-menu > ul > li.current-menu-parent > a,
		.left-menu-open .menu-panel #header-menu > ul > li.current-menu-parent > a,
		.left-menu-open .bp_components ul li ul li.menupop.active > a,
		.menu-panel .header-menu > ul li a,
		#nav-menu > ul > li > a, body:not(.left-menu-open) .menu-panel .sub-menu-wrap > a,
		body:not(.left-menu-open) .menu-panel .ab-sub-wrapper > .ab-item,
		.menu-panel #nav-menu > a, .menu-panel .menupop > a,
		.menu-panel #header-menu > a, .menu-panel .menupop > a,
		.menu-panel .menupop > div.ab-item
		{
		color: <?php echo esc_attr( boss_get_option( 'boss_panel_title_color' ) ); ?>;
		}

		.menu-panel .header-menu > ul li a:before,
		.menu-panel #nav-menu > ul > li > a:not(.open-submenu):before,
		.menu-panel #header-menu > ul > li > a:not(.open-submenu):before,
		.menu-panel .screen-reader-shortcut:before,
		.menu-panel .bp_components ul li ul li > .ab-item:before {
		color: <?php echo esc_attr( boss_get_option( 'boss_panel_icons_color' ) ); ?>;
		}

		body.left-menu-open .menu-panel #nav-menu > ul > li > a:not(.open-submenu):before,
		body.left-menu-open .menu-panel #header-menu > ul > li > a:not(.open-submenu):before,
		body.left-menu-open .menu-panel .bp_components ul li ul li > .ab-item:before,
		body.left-menu-open .menu-panel .screen-reader-shortcut:before,
		body .menu-panel .boss-mobile-porfile-menu ul a::before {
		color: <?php echo esc_attr( boss_get_option( 'boss_panel_open_icons_color' ) ); ?>;
		}

		/* Counting Numbers and Icons */
		.widget_categories .cat-item i,
		.menu-panel ul li a span {
		background-color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		body .menu-panel #nav-menu > ul > li.dropdown > a:not(.open-submenu):before,
		body .menu-panel #header-menu > ul > li.dropdown > a:not(.open-submenu):before,
		body .menu-panel .bp_components ul li ul li.menupop.dropdown > a:not(.open-submenu):before,
		body.tablet .menu-panel #nav-menu > ul > li.current-menu-item > a:not(.open-submenu):before,
		body.tablet .menu-panel #header-menu > ul > li.current-menu-item > a:not(.open-submenu):before,
		body.tablet .menu-panel #nav-menu > ul > li.current-menu-parent > a:not(.open-submenu):before,
		body.tablet .menu-panel #header-menu > ul > li.current-menu-parent > a:not(.open-submenu):before,
		body.tablet .menu-panel .bp_components ul li ul li.menupop.active > a:not(.open-submenu):before,
		body .menu-panel #nav-menu > ul > li.current-menu-item > a:not(.open-submenu):before,
		body .menu-panel #header-menu > ul > li.current-menu-item > a:not(.open-submenu):before,
		body .menu-panel #nav-menu > ul > li.current-menu-parent > a:not(.open-submenu):before,
		body .menu-panel #header-menu > ul > li.current-menu-parent > a:not(.open-submenu):before,
		body .menu-panel .bp_components ul li ul li.menupop.active > a:not(.open-submenu):before {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		/* Pagination */
		.search_results .navigation .wp-paginate .current, .pagination .current, .em-pagination strong, .bbp-pagination-links span:not(.dots) {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		border-color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		/* Cover */
		.page-cover, .bb-cover-photo {
		background-color: <?php echo esc_attr( boss_get_option( 'boss_cover_color' ) ); ?>;
		}

		/* Small Buttons */
		.bbp-topic-details #subscription-toggle a,
		.bbp-forum-details #subscription-toggle a,
		.widget-area .widget .bp-login-widget-register-link a,
		.widget-area .widget a.sidebar-wp-register,
		.widget-area .widget_bp_core_login_widget a.logout,
		.widget-area .widget_tag_cloud a,
		.widget-area .widget #sidebarme ul.sidebarme-quicklinks li.sidebarme-profile a,
		.bbp-logged-in a.button,
		<?php echo $header_admin_class; ?> .register,
		<?php echo $header_admin_class; ?> .login,
		.header-account-login .pop .logout a {
		background-color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		/* Footer */
		#footer-links a:hover {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		/* 1st Footer Background Color */
		div.footer-inner-top {
		background-color: <?php echo esc_attr( boss_get_option( 'boss_layout_footer_top_color' ) ); ?>;
		}

		/* 2nd Footer Background Color */
		div.footer-inner-bottom {
		background-color: <?php echo esc_attr( boss_get_option( 'boss_layout_footer_bottom_bgcolor' ) ); ?>;
		}

		/* Comments */
		.comments-area article header a:hover,
		.comment-awaiting-moderation {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		/* Shortcodes */
		.menu-dropdown li a:hover,
		.tooltip,
		.progressbar-wrap p,
		.ui-tabs-nav li.ui-state-active a,
		.ui-accordion.accordion h3.ui-accordion-header-active:after,
		.ui-accordion.accordion h3.ui-accordion-header {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		.entry-content .underlined:after,
		.progressbar-wrap .ui-widget-header,
		.ui-tabs-nav li a span {
		background-color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		.ui-tooltip, .ui-tooltip .arrow:after {
		background-color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?> !important;
		}

		/* Slideshow Text color */
		.bb-slider-container .title,
		.bb-slider-container .description {
		color: <?php echo esc_attr( boss_get_option( 'boss_slideshow_font_color' ) ); ?>;
		}

		/************** BuddyPress **************************/

		/* Covers */

		/*** Profile Cover ****/
		<?php
		$pc_height = esc_attr( boss_get_option( 'boss_cover_profile_size' ) );
		if ( !empty( $pc_height ) ) {
			if ( $pc_height == '200' ) {
				?>

				/* ---------------- Desktop ---------------- */
				.is-desktop .network-profile #item-header {
				min-height: <?php echo $pc_height; ?>px;
				}

				.is-desktop.bp-user .bb-cover-photo,
				.is-desktop.bp-user #buddypress #item-header-cover > .table-cell {
				height: <?php echo $pc_height; ?>px;
				}

				.is-desktop.bp-user #buddypress div#item-header img.avatar {
				max-width: 90px;
				}

				.is-desktop.bp-user #item-header-content {
				margin-top: 0;
				}
				/* ---------------- End Desktop ---------------- */

			<?php } elseif ( $pc_height == 'none' ) { ?>

				.bp-user .bb-cover-photo {
				display: none;
				}

				.bp-user #buddypress #item-header-cover {
				position: relative;
				}

				.network-profile #buddypress #item-header-cover .cover-content > .table-cell:first-child {
				background: <?php echo esc_attr( boss_get_option( 'boss_cover_color' ) ); ?>;
				}

				/* ---------------- Desktop ---------------- */
				.is-desktop .network-profile #item-header {
				min-height: 200px;
				}

				.is-desktop.bp-user .bb-cover-photo,
				.is-desktop.bp-user #buddypress #item-header-cover > .table-cell {
				height: 200px;
				}

				.is-desktop .network-profile #item-header {
				background: transparent;
				}
				.is-desktop.bp-user .cover-content {
				padding: 30px 0;
				}

				.is-desktop.bp-user #buddypress #item-header-cover {
				background: <?php echo esc_attr( boss_get_option( 'boss_cover_color' ) ); ?>;
				}
				/* ---------------- End Desktop ---------------- */
				<?php
			}
		}
		?>

		/*** Group Cover ****/
		<?php
		$gc_height = esc_attr( boss_get_option( 'boss_cover_group_size' ) );
		if ( !empty( $gc_height ) ) {
			if ( $gc_height != '322' ) {
				?>
				/* ---------------- Desktop ---------------- */
				.is-desktop .group-single #item-header {
				min-height: 200px;
				}

				.is-desktop.single-item.groups .bb-cover-photo,
				.is-desktop.single-item.groups #buddypress #item-header-cover > .table-cell {
				height: 200px;
				}

				.is-desktop .group-single #buddypress #item-header-content {
				margin-top: 15px;
				margin-bottom: 15px;
				}

				.is-desktop .group-single #buddypress .single-member-more-actions,
				.is-desktop .group-single #buddypress div#item-header div.generic-button {
				margin-top: 0;
				}

				.is-desktop .group-info li p:first-child {
				font-size: 20px;
				}

				.is-desktop .group-single h1.main-title {
				font-size: 50px;
				}

				.is-desktop div#group-name {
				padding-bottom: 15px;
				}

				@media screen and (max-width: 900px) and (min-width: 721px) {
				.is-desktop .group-single #buddypress #item-header-cover #item-header-avatar > a {
				padding-top: 10px;
				}

				.is-desktop .group-single #buddypress #item-header-content {
				margin-top: 15px;
				margin-bottom: 15px;
				}

				.is-desktop .group-single #buddypress #item-header-cover > .table-cell:first-child {
				vertical-align: bottom;
				}

				.is-desktop div#group-name h1 {
				font-size: 34px;
				}

				.is-desktop .group-info li p:first-child {
				font-size: 16px;
				}

				.is-desktop .group-info li p:nth-child(2) {
				font-size: 12px;
				}
				}

				@media screen and (max-width: 1000px) and (min-width: 721px) {
				.is-desktop.left-menu-open .group-single #buddypress #item-header-cover #item-header-avatar > a {
				padding-top: 10px;
				}

				.is-desktop.left-menu-open .group-single #buddypress #item-header-content {
				margin-top: 15px;
				margin-bottom: 15px;
				}

				.is-desktop.left-menu-open .group-single #buddypress #item-header-cover > .table-cell:first-child {
				vertical-align: bottom;
				}

				.is-desktop.left-menu-open div#group-name h1 {
				font-size: 34px;
				}

				.is-desktop.left-menu-open .group-info li p:first-child {
				font-size: 16px;
				}

				.is-desktop.left-menu-open .group-info li p:nth-child(2) {
				font-size: 12px;
				}
				}
				/* ---------------- End Desktop ---------------- */

				<?php
			}
			if ( $gc_height == 'none' ) {
				?>

				.group-single .bb-cover-photo {
				display: none;
				}

				.group-single #buddypress #item-header-cover {
				position: relative;
				}

				/* ---------------- Desktop ---------------- */
				.is-desktop .group-single #buddypress #item-header-cover {
				background: <?php echo esc_attr( boss_get_option( 'boss_cover_color' ) ); ?>;
				}
				/* ---------------- End Desktop ---------------- */

				/* ---------------- Mobile ---------------- */
				.is-mobile .group-single #buddypress #item-header-cover > .table-cell {
				padding: 0;
				}
				.is-mobile .group-single #buddypress #item-header-cover > .table-cell {
				padding-left: 30px;
				padding-right: 30px;
				background: <?php echo esc_attr( boss_get_option( 'boss_cover_color' ) ); ?>;
				}
				/* ---------------- End Mobile ---------------- */

				<?php
			}
		}
		?>

		#buddypress #activity-stream .activity-meta .unfav.bp-secondary-action:before {
		color: <?php echo esc_attr( boss_get_option( 'boss_cover_profile_size' ) ); ?>;
		}

		/* Activities */
		#buddypress #activity-stream .activity-meta .unfav.bp-secondary-action:before {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		/* Tabs */
		body.activity:not(.bp-user)  .item-list-tabs ul li.selected a ,
		.dir-form .item-list-tabs ul li.selected a,
		body.activity:not(.bp-user)  .item-list-tabs ul li ,
		.dir-form .item-list-tabs ul li {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		.item-list li .item-meta .count,
		body.activity:not(.bp-user)  .item-list-tabs ul li a span ,
		.dir-form .item-list-tabs ul li a span {
		background-color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		/* Groups Create */
		.entry-content #group-create-body h4,
		#buddypress .standard-form div.submit #group-creation-previous,
		#buddypress div#group-create-tabs ul.inverse > li,
		#buddypress div#group-create-tabs ul li.current a {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		#buddypress .standard-form div.submit #group-creation-previous,
		#buddypress div#group-create-tabs ul.inverse > li {
		border-color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		/* Cover *
        .page-cover[data-photo="no"] > .table-cell,
		.entry-post-thumbnail,
		.bb-cover-photo .progress {
		background-color: <?php echo esc_attr( boss_get_option( 'boss_cover_color' ) ); ?>;
		}

		.bb-cover-photo .update-cover-photo div {
		background-color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		/* Item List */
		#friend-list li .action div.generic-button:nth-child(2n) a,
		#members-stream li .action div.generic-button:nth-child(2n) a ,
		#members-list li .action div.generic-button:nth-child(2n) a,
		#buddypress div#item-nav .item-list-tabs ul li.current > a,
		#buddypress div#item-nav .item-list-tabs ul li:hover > a {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		#buddypress div#item-nav .item-list-tabs > ul > li.current,
		#buddypress div#item-nav .item-list-tabs > ul > li:not(.hideshow):hover {
		border-color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		.header-account-login .pop #dashboard-links .menupop a span,
		.header-account-login .pop ul > li > .ab-sub-wrapper > ul li a span,
		#buddypress div#item-nav .item-list-tabs ul li a span {
		background-color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		#friend-list li .action div.generic-button:nth-child(2n) a,
		#members-stream li .action div.generic-button:nth-child(2n) a ,
		#members-list li .action div.generic-button:nth-child(2n) a{
		border-color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		/* Fav icon */

		#buddypress #activity-stream .acomment-options .acomment-like.unfav-comment:before, #buddypress #activity-stream .activity-meta .unfav.bp-secondary-action:before {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		/* Group Settings */
		#buddypress form#group-settings-form ul.item-list > li > span a,
		body:not(.group-cover-image ) #buddypress form#group-settings-form h4 {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		/* Private Messaging Threads */
		#buddypress table.notifications tr th,
		#message-threads.messages-table tbody tr a,
		#message-threads.notices-table a.button {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_pr_color' ) ); ?>;
		}
		#message-threads.messages-table tbody tr a:hover,
		#message-threads.notices-table a.button:hover {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		/* Widgets */
		.secondary-inner #item-actions #group-admins img.avatar,
		.widget-area .widget ul.item-list img.avatar {
		border-color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		/************* BBPress ************************/

		#bbpress-forums li.bbp-header,
		#bbpress-forums li.bbp-footer {
		background-color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		border-color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		.bbp-topic-details .bbp-forum-data .post-num ,
		.bbp-forum-details .bbp-forum-data .post-num {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		.bbp-logged-in img.avatar {
		border-color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		/************ Other Plugins **********************/
		.pricing-button .pmpro_btn,
		.pricing-header {
		background-color: <?php echo esc_attr( boss_get_option( 'boss_panel_color' ) ); ?>;
		}
		.checklist ul li:before,
		.pricing-content {
		color: <?php echo esc_attr( boss_get_option( 'boss_panel_color' ) ); ?>;
		}
		.checklist.unchecked ul li:before {
		color: #f44a53;
		}
		.active .pricing-header,
		.pricing-button .pmpro_btn.disabled {
		color: <?php echo esc_attr( boss_get_option( 'boss_panel_color' ) ); ?>;
		}
		.pmpro_btn:hover,
		.pmpro_btn:focus,
		.pmpro_content_message a:focus,
		.pmpro_content_message a:hover,
		.pricing-button .pmpro_btn:hover {
		background-color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}
		.active .pricing-header,
		.pricing-button .pmpro_btn.disabled {
		color: <?php echo esc_attr( boss_get_option( 'boss_panel_color' ) ); ?>;
		background-color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}
		.active .pricing-header .separator:after {
		background-color: <?php echo esc_attr( boss_get_option( 'boss_panel_color' ) ); ?>;
		}
		#buddypress div#item-nav .search_filters.item-list-tabs ul li.forums a span {
		background-color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}
		.results-group-forums .results-group-title span {
		border-bottom-color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		.item-list-tabs.bps_header input[type="submit"],
		.bboss_ajax_search_item .item .item-title {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		.item-list-tabs.bps_header input[type="submit"]:hover {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_pr_color' ) ); ?>;
		}

		.service i {
		box-shadow: 0 0 0 3px <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		.service i:after {
		background-color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		/* BuddyPress Docs */
		.site #buddypress table.doctable tr th,
		.site #doc-permissions-summary,
		.site #doc-group-summary,
		#bp-docs-single-doc-header .doc-title .breadcrumb-current:only-child {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_pr_color' ) ); ?>;
		}
		#buddypress #doc-attachments label[for='insert-media-button'],
		#buddypress #doc-form.standard-form label[for='bp_docs_tag'],
		#buddypress #doc-form.standard-form label[for='associated_group_id'],
		.site .doc-tabs li a,
		.site .doc-tabs .current a {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_pr_color' ) ); ?>;
		}
		.site .bp-docs-attachment-clip:before,
		.site .doc-attachment-mime-icon:before {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}
		.site #buddypress .toggle-switch a,
		.site .entry-content p.toggle-switch a {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_pr_color' ) ); ?>;
		}
		.site #buddypress .plus-or-minus {
		background: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}
		.author-cell,
		.title-cell > a {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_pr_color' ) ); ?>;
		}
		.site .doc-title a:hover,
		.directory-title a:hover {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}
		.site .doc-title .breadcrumb-current,
		h2.directory-title .breadcrumb-current {
		border-bottom-color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}
		.directory-breadcrumb-separator::before {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}
		.site a.docs-filter-title.current {
		border-bottom-color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}
		.folder-row .genericon,
		.title-cell .genericon,
		.site .asc a:before,
		.site .desc a:before,
		.genericon-category.genericon-category:before
		{
		color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}
		.single-bp_doc #comments > h3,
		.groups.docs #comments > h3 {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_pr_color' ) ); ?>;
		}

		.site .docs-folder-manage .folder-toggle-edit a,
		.currently-viewing a[title="View All Docs"] {
		background: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?> none repeat scroll 0 0;
		}

		/* BuddyPress Docs Wiki */

		.wiki-page-title a {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}
		#buddypress .standard-form label[for="parent_id"] {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_pr_color' ) ); ?>;
		}
		.item-subitem-indicator.bb-subitem-open:after {
		background: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}
		.item-subitem-indicator a:before {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}
		#primary #groups-list #groups-list li .item-avatar:after,
		#buddypress .subitem:before {
		background: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}
		#primary #groups-list #groups-list li .item-avatar:before {
		background: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?> none repeat scroll 0 0;
		}

		/* Group Extras */

		#buddypress form#group-settings-form span.extra-subnav a,
		.site #buddypress div#group-create-tabs.item-list-tabs ul li.current:after {
		border-color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}
		#buddypress form#group-settings-form span.extra-subnav a {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_pr_color' ) ); ?>;
		}
		#buddypress form#group-settings-form span.extra-subnav a:hover,
		#buddypress form#group-settings-form span.extra-subnav a:focus,
		#buddypress form#group-settings-form span.extra-subnav a.active {
		background: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}
		#buddypress #group-settings-form span.extra-title,
		#buddypress form#group-settings-form label {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_pr_color' ) ); ?>;
		}
		#group-settings-form input[type="radio"]:checked + strong + span,
		.bb-arrow {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}
		.site #bbpress-forums .bbp-attachments ol li.bbp-atthumb .wp-caption p.wp-caption-text a[href$='=detach']:before {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		/* Invite Anyone */

		#buddypress #subnav #sent-invites {
		background: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}
		.site #invite-anyone-steps > li::before {
		background: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}
		.site form#invite-anyone-by-email p,
		.site #invite-anyone-steps label {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_pr_color' ) ); ?>;
		}
		.invite-anyone thead tr th a.DESC:before,
		.invite-anyone thead tr th a.ASC:before {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}
		.invite-anyone .invite-anyone-sent-invites th a,
		.invite-anyone #buddypress .invite-anyone-sent-invites tr th,
		.invite-anyone .invite-anyone-sent-invites th.sort-by-me a,
		.site #invite-anyone-group-list label span {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_pr_color' ) ); ?>;
		}

		/* ---------------- Mobile ---------------- */
		body.is-mobile {
		background-color: <?php echo esc_attr( boss_get_option( 'boss_panel_color' ) ); ?>;
		}

		/* Navigation */
		.is-mobile .menu-panel {
		background-color: <?php echo esc_attr( boss_get_option( 'boss_panel_color' ) ); ?>;
		}

		.is-mobile #mobile-header {
		background-color: <?php echo esc_attr( boss_get_option( 'boss_layout_mobiletitlebar_bgcolor' ) ); ?>;
		}

		.is-mobile .menu-panel #nav-menu > ul > li.current-menu-item > a,
		.is-mobile .menu-panel #header-menu > ul > li.current-menu-item > a {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		.is-mobile .menu-panel #nav-menu > ul > li.dropdown > a:before,
		.is-mobile .menu-panel #header-menu > ul > li.dropdown > a:before,
		.is-mobile .menu-panel .bp_components ul li ul li.menupop.dropdown > a:before {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		/* Header */
		.is-mobile #mobile-header h1 a {
		color: <?php echo esc_attr( boss_get_option( 'boss_title_color' ) ); ?>;
		}

		/************************ BuddyPress *****************/

		/* Tabs */
		.is-mobile #buddypress div#subnav.item-list-tabs ul li.current a,
		.is-mobile #buddypress #mobile-item-nav ul li:active,
		.is-mobile #buddypress #mobile-item-nav ul li.current,
		.is-mobile #buddypress #mobile-item-nav ul li.selected {
		background-color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}
		.is-mobile #buddypress #mobile-item-nav ul li,
		.is-mobile #buddypress div#subnav.item-list-tabs ul li a {
		background-color: <?php echo esc_attr( boss_get_option( 'boss_panel_color' ) ); ?>;
		}
		.is-mobile #buddypress div.item-list-tabs ul li.current a,
		.is-mobile #buddypress div.item-list-tabs ul li.selected a {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}
		.is-mobile #buddypress div#subnav.item-list-tabs ul li a {
		color: #fff;
		}

		/* ---------------- End Mobile ---------------- */

		/* ---------------- Desktop ---------------- */
		body.is-desktop {
		background-color: <?php echo esc_attr( boss_get_option( 'boss_panel_color' ) ); ?>;
		}

		/* Cover Buttons */
		.is-desktop .header-navigation ul li a span {
		color: <?php echo esc_attr( boss_get_option( 'boss_panel_logo_color' ) ); ?>;
		}

		/* Cover Follow Button */
		.is-desktop #item-buttons .pop .inner a {
			color: <?php echo esc_attr( boss_get_option( 'boss_links_pr_color' ) ); ?>;
		}
		.is-desktop #item-buttons .pop .inner a:hover {
			color: #fff;
			background-color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		/* Logo Area */
		#mastlogo,
		.boxed.is-desktop #mastlogo {
		background-color: <?php echo esc_attr( boss_get_option( 'boss_panel_logo_color' ) ); ?>;
		}

		/* Logo Area */
		<?php if ( boss_get_option( 'boss_panel_color' ) ) { ?>
			.is-desktop .menu-panel .sub-menu-wrap:before,
			.is-desktop .menu-panel .ab-sub-wrapper:before {
			border-color: transparent <?php echo esc_attr( boss_get_option( 'boss_panel_color' ) ); ?> transparent transparent;
			}
		<?php } ?>

		/* Header */
		.header-account-login a {
		color: <?php echo esc_attr( boss_get_option( 'boss_body_font_color' ) ); ?>;
		}

		.header-account-login .pop .bp_components .menupop:not(#wp-admin-bar-my-account) > .ab-sub-wrapper li.active a,
		.header-account-login .pop .links li > .sub-menu li.active a,
		.header-account-login a:hover {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		.header-navigation li.hideshow ul,
		.header-account-login .pop .bp_components .menupop:not(#wp-admin-bar-my-account) > .ab-sub-wrapper:before, .header-account-login .pop .links li > .sub-menu:before,
		.header-account-login .pop .bp_components .menupop:not(#wp-admin-bar-my-account) > .ab-sub-wrapper,
		.header-account-login .pop .links li > .sub-menu,
		.bb-global-search-ac.ui-autocomplete,
		.site-header #wp-admin-bar-shortcode-secondary .ab-sub-wrapper,
		.header-notifications .pop, .header-account-login .pop,
		.header-inner .search-wrap,
		.header-inner {
		background-color: <?php echo esc_attr( boss_get_option( 'boss_layout_titlebar_bgcolor' ) ); ?>;
		}

		.page-template-page-no-buddypanel .header-inner .search-wrap,
		.page-template-page-no-buddypanel:not(.boxed) .header-inner,
		.page-template-page-no-buddypanel #mastlogo {
		background-color: <?php echo esc_attr( boss_get_option( 'boss_layout_nobp_titlebar_bgcolor' ) ); ?>;
		}

		body:not(.left-menu-open).is-desktop #mastlogo .site-title a:first-letter,
		.is-desktop #mastlogo .site-title a,
		.boxed.is-desktop #mastlogo .site-title a {
		color: <?php echo esc_attr( boss_get_option( 'boss_title_color' ) ); ?>;
		}

		/* Footer */
		div.footer-inner ul.social-icons li a span,
		#switch_submit {
		border: 1px solid <?php echo esc_attr( boss_get_option( 'boss_layout_footer_bottom_color' ) ); ?>;
		}

		div.footer-inner ul.social-icons li a span,
		#switch_submit,
		.footer-credits, .footer-credits a, #footer-links a,
		#footer-links a.to-top {
		color: <?php echo esc_attr( boss_get_option( 'boss_layout_footer_bottom_color' ) ); ?>;
		}

		.footer-credits a:hover {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		/******************** BuddyPress *****************/

		/* Activities */
		.is-desktop #buddypress .activity-list li.load-more a,
		.is-desktop #buddypress .activity-list li.load-newest a {
		background-color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		/* Private Messaging Threads */
		.is-desktop.bp-user.messages #buddypress div#subnav.item-list-tabs ul li.current a:after,
		.is-desktop.bp-user.messages #buddypress div#subnav.item-list-tabs ul li:first-child a {
		background-color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		/************ Other Plugins **********************/
		.is-desktop button#buddyboss-media-add-photo-button {
		background-color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		/*** Header Links ****/
		.site-header #wp-admin-bar-shortcode-secondary .ab-icon:before,
		.header-account-login a,
		.header-account-login .pop li,
		.header-notifications a.notification-link,
		.header-notifications .pop a,
		#wp-admin-bar-shortcode-secondary .thread-from a,
		#masthead #searchsubmit,
		.header-navigation ul li a,
		.header-inner <?php echo $header_menu_class; ?>  a,
		#wp-admin-bar-shortcode-secondary .notices-list li p,
		.header-inner <?php echo $header_menu_class; ?>  a:hover
		{
		color: <?php echo esc_attr( boss_get_option( 'boss_layout_titlebar_color' ) ); ?>;
		}

		.boxed #masthead #searchsubmit {
		color: #999;
		}

		.header-navigation ul li.current-menu-item > a,
		.header-navigation ul li.current-page-item > a,
		.header-navigation ul li.current_page_item > a,
		#wp-admin-bar-shortcode-secondary .thread-from a:hover,
		.header-notifications .pop a:hover,
		.header-navigation ul li a:hover {
		color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
		}

		.page-template-page-no-buddypanel .site-header #wp-admin-bar-shortcode-secondary .ab-icon:before,
		.page-template-page-no-buddypanel:not(.boxed) .header-notifications a.notification-link,
		.page-template-page-no-buddypanel #wp-admin-bar-shortcode-secondary .thread-from a,
		.page-template-page-no-buddypanel[data-header="1"] #masthead #searchsubmit,
		.page-template-page-no-buddypanel:not(.boxed) .header-navigation #header-menu > ul > li > a,
		.page-template-page-no-buddypanel[data-header="1"]:not(.boxed) .header-inner <?php echo $header_menu_class; ?>  a {
		color: <?php echo esc_attr( boss_get_option( 'boss_layout_nobp_titlebar_color' ) ); ?>;
		}

		.page-template-page-no-buddypanel:not(.boxed) .header-account-login > a,
		.page-template-page-no-buddypanel .header-inner .search-wrap input[type="text"] {
		color: <?php echo esc_attr( boss_get_option( 'boss_layout_nobp_titlebar_color' ) ); ?>;
		}

        .page-template-page-no-buddypanel[data-header="1"] #masthead #searchsubmit:hover,
		.page-template-page-no-buddypanel .header-notifications a.notification-link:hover,
		.page-template-page-no-buddypanel .header-account-login > a:hover,
		.page-template-page-no-buddypanel .header-notifications .pop a:hover,
		.page-template-page-no-buddypanel .header-navigation #header-menu > ul > li > a:hover {
		color: <?php echo esc_attr( boss_get_option( 'boss_layout_nobp_titlebar_hover_color' ) ); ?>;
		}

		/* ---------------- End Desktop ---------------- */

		/******************* Color Schemes **********************/

		<?php
		$theme = boss_get_option( 'boss_scheme_select' );

		if ( !empty( $theme ) && $theme != 'default' && $theme != 'education' ) {
			?>

			/*** Dropdown ***/
			.bb-global-search-ac li.bbls-category {
			color: <?php echo esc_attr( boss_get_option( 'boss_heading_font_color' ) ); ?>;
			}

			/*** Header Buttons ****/
			<?php echo $header_admin_class; ?> .register,
			<?php echo $header_admin_class; ?> .login,
			.header-account-login .pop .logout a {
			background-color: #fff;
			color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
			}

			#wp-admin-bar-shortcode-secondary a {
			color: #fff;
			}

			/*** Header Links Hover ****/
			.header-account-login .pop .bp_components .menupop:not(#wp-admin-bar-my-account) > .ab-sub-wrapper li.active a,
			.header-account-login .pop .links li > .sub-menu li.current-menu-item a,
			.header-account-login .pop .links li > .sub-menu li.current-menu-parent a,
			#wp-admin-bar-shortcode-secondary a:hover,
			#wp-admin-bar-shortcode-secondary .thread-from a:hover,
			.header-account-login a:hover,
			.header-notifications a.notification-link:hover,
			#wp-admin-bar-shortcode-secondary a:hover .ab-icon:before,
			.header-navigation ul li.current-menu-item > a,
			.header-navigation ul li.current-page-item > a,
			.header-navigation ul li.current_page_item > a,
			.header-notifications .pop a:hover,
			#masthead #searchsubmit:hover,
			.header-navigation ul li a:hover {
			color: rgba(255,255,255,0.7);
			}

			.is-desktop .header-navigation li.hideshow > ul, .is-desktop .header-navigation .sub-menu {
			background-color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
			}

			/*** Search Border ****/
			.header-inner .search-wrap {
			border: none;
			}

			.error404 #primary .search-wrap {
			border: none;
			}

			.error404 #primary .search-wrap input[type="text"] {
			height: 50px;
			}

			/******* Footer Bottom Text ******/
			.footer-credits, .footer-credits a, #footer-links a {
			color: <?php echo esc_attr( boss_get_option( 'boss_layout_footer_bottom_color' ) ); ?>;
			}

			/******* Tabs ******/

			<?php if ( $theme != 'mint' && $theme != 'iceberg' ) { ?>
				.ui-tabs-nav.btn-group li.btn:first-child:not(:last-child), .ui-tabs-nav.btn-group li.btn,
				.ui-accordion.accordion h3.ui-accordion-header,
				.ui-accordion-content .inner,
				body.activity:not(.bp-user)  .item-list-tabs ul li:last-child, .dir-form .item-list-tabs ul li:last-child,
				body.activity:not(.bp-user)  .item-list-tabs ul li, .dir-form .item-list-tabs ul li {
				border-color: #fff;
				}

				.ui-tabs-nav li.ui-state-default a,
				body.activity:not(.bp-user)  .item-list-tabs ul li a, .dir-form .item-list-tabs ul li a {
				color: #fff;
				}
			<?php } ?>

			.ui-tabs-nav li.ui-state-active a,
			.ui-accordion.accordion h3.ui-accordion-header,
			.ui-accordion.accordion h3.ui-accordion-header-active:after {
			color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
			}

			/***** Input ******/
			input[type="text"]:not([name="s"]),
			input[type="email"],
			input[type="url"],
			input[type="password"],
			input[type="search"],
			textarea {
			background-color: <?php echo esc_attr( boss_get_option( 'boss_panel_color' ) ); ?>;
			-webkit-box-shadow: none;
			-moz-box-shadow:    none;
			box-shadow:         none;
			}

			input[type="text"]:not([name="s"]):focus,
			input[type="email"]:focus,
			input[type="url"]:focus,
			input[type="password"]:focus,
			input[type="search"]:focus,
			textarea:focus {
			background-color: <?php echo esc_attr( boss_get_option( 'boss_panel_color' ) ); ?>;
			-webkit-box-shadow:  inset 0px 1px 2px 1px rgba(0, 0, 0, 0.3);
			-moz-box-shadow:     inset 0px 1px 2px 1px rgba(0, 0, 0, 0.3);
			box-shadow:          inset 0px 1px 2px 1px rgba(0, 0, 0, 0.3);
			}

		<?php } ?>

		<?php if ( $theme == 'social-learner' ) { ?>
		    .header-notifications a.notification-link span {
                background-color: <?php echo esc_attr( boss_get_option( 'boss_edu_active_link_color' ) ); ?>;
            }
		<?php } ?>
		<?php if ( $theme == 'royalty' || $theme == 'nocturnal' ) { ?>

			/***** Sitewide notice *****/
			div#sitewide-notice div#message p {
			color: #fff;
			}
			/***** 404 *****/
			.error404 .entry-content p, .error404 h1 {
			color: <?php echo esc_attr( boss_get_option( 'boss_body_font_color' ) ); ?>;
			}
			/******* ******* ******/
			.widget-area .widget ul.item-list .item .item-meta,
			.widget.widget_buddyboss_recent_post .post-time,
			.widget-area .widget div.item-options a:not(.selected),
			#primary #members-list li .item-meta span:not(.count),
			#primary .item-list li .item-meta span:not(.count).desktop,
			#primary .item-list li .item-meta span:not(.count).activity,
			#primary .item-list li .item-meta .meta-wrap span:not(.count) {
			color: <?php echo esc_attr( boss_get_option( 'boss_body_font_color' ) ); ?>;
			opacity: 0.6;
			}

			/******* Small Searches ******/
			.groups-members-search input[type="text"],
			#buddypress div.dir-search input[type="text"],
			#bbpress-forums #bbp-search-index-form input#bbp_search,
			#buddypress #search-message-form input[type="text"] {
			color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
			}

			input[type="text"]:not([name="s"]),
			input[type="email"],
			input[type="url"],
			input[type="password"],
			input[type="search"],
			textarea {
			color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
			}

			/***** Input ******/
			::-webkit-input-placeholder {
			color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
			opacity: 0.6;
			}
			:-moz-placeholder {
			color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
			opacity: 0.6;
			}
			::-moz-placeholder {
			color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
			opacity: 0.6;
			}
			:-ms-input-placeholder {
			color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
			opacity: 0.6;
			}

			#respond form textarea::-webkit-input-placeholder {
			color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
			opacity: 0.6;
			}
			#respond form textarea:-moz-placeholder {
			color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
			opacity: 0.6;
			}
			#respond form textarea::-moz-placeholder {
			color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
			opacity: 0.6;
			}
			#respond form textarea:-ms-input-placeholder {
			color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
			opacity: 0.6;
			}

			/***** Tabs ******/
			#buddypress #mobile-item-nav ul li a {
			color: #fff;
			}
		<?php } ?>


		<?php if ( $theme == 'royalty' ) { ?>
			/******* Light borders ******/
			#bbp-search-index-form, #search-message-form, .groups-members-search, #buddypress div.dir-search,
			body.activity:not(.bp-user)  .item-list-tabs ul li:last-child, .dir-form .item-list-tabs ul li:last-child,
			body.activity:not(.bp-user)  .item-list-tabs ul li, .dir-form .item-list-tabs ul li {
			border-color: #dfe3e6;
			}

			body.activity:not(.bp-user)  .item-list-tabs ul li a, .dir-form .item-list-tabs ul li a {
			color: #dfe3e6;
			}

			/******* Global borders ******/
			hr,
			.progressbar,
			form#group-settings-form hr
			{
			background-color: #6e5b71;
			}

			div#sitewide-notice div#message p,
			.archive-header, .comments-area ol.children, #bbp-search-index-form, #search-message-form, .groups-members-search, #buddypress div.dir-search,
			.author.archive .author-info,
			.secondary-inner #item-actions,
			#group-description,
			#secondary.widget-area .widget,
			.widget-area .widget div.item-options,
			div.footer-inner-top,
			.footer-inner.widget-area,
			.footer-inner-bottom,
			.single .site-content article.post,
			.filters,
			.post-wrap,
			.commentlist > li.comment,
			.search-results .page-header,
			.entry-meta.mobile,
			.footer-inner.widget-area .footer-widget .widget,
			.header-account-login .pop .network-menu,
			.header-account-login .pop #dashboard-links,
			.header-account-login .pop .logout,
			body.activity:not(.bp-user)  .item-list-tabs ,
			.dir-form .item-list-tabs,
			#group-create-body .big-caps,
			#buddypress .profile-fields tr td,
			#buddypress table.notification-settings th,
			.secondary-inner > a img,
			#primary .item-list li,
			#buddypress div#message-threads,
			#buddypress div#message-threads ul,
			div#register-page .register-section,
			div#register-page .security-question-section,
			#buddypress div.activity-comments ul li,
			#buddypress div.activity-comments form.ac-form,
			#buddypress ul.item-list li div.action .action-wrap,
			#buddypress .activity-list li.new_forum_post .activity-content .activity-inner,
			#buddypress .activity-list li.new_forum_topic .activity-content .activity-inner,
			.bp-user.messages #buddypress div#subnav.item-list-tabs ul li:first-child,
			#contentcolumn,
			#bbpress-forums li.bbp-body ul.forum,
			#bbpress-forums li.bbp-body ul.topic,
			.bp-user.messages #buddypress div.pagination {
			border-color: #6e5b71;
			}

			#primary, #secondary {
			border-color: #6e5b71!important;
			}

			@media screen and (max-width: 820px) and (min-width:721px){
			body.left-menu-open.is-desktop .footer-widget:not(:last-child) {
			border-color: #6e5b71;
			}
			}

			.is-mobile #item-buttons .pop .inner {
			border-color: #6e5b71;
			}

			@media screen and (max-width: 1000px) and (min-width:721px) {
			body.left-menu-open.messages.bp-user.is-desktop #secondary {
			border-color: #6e5b71;
			}
			}


		<?php } ?>

		<?php if ( $theme == 'seashell' ) { ?>

			hr,
			.progressbar,
			form#group-settings-form hr
			{
			background-color: #c3e7e5;
			}

			div#sitewide-notice div#message p,
			.archive-header,  .comments-area ol.children, #bbp-search-index-form, #search-message-form, .groups-members-search, #buddypress div.dir-search,
			.author.archive .author-info,
			.secondary-inner #item-actions,
			#group-description,
			#secondary.widget-area .widget,
			.widget-area .widget div.item-options,
			div.footer-inner-top,
			.footer-inner.widget-area,
			.footer-inner-bottom,
			.single .site-content article.post,
			.filters,
			.post-wrap,
			.commentlist > li.comment,
			.search-results .page-header,
			.entry-meta.mobile,
			.footer-inner.widget-area .footer-widget .widget,
			.header-account-login .pop .network-menu,
			.header-account-login .pop #dashboard-links,
			.header-account-login .pop .logout,
			body.activity:not(.bp-user)  .item-list-tabs ,
			.dir-form .item-list-tabs,
			#group-create-body .big-caps,
			#buddypress .profile-fields tr td,
			#buddypress table.notification-settings th,
			.secondary-inner > a img,
			#primary .item-list li,
			#buddypress div#message-threads,
			#buddypress div#message-threads ul,
			div#register-page .register-section,
			div#register-page .security-question-section,
			#buddypress div.activity-comments ul li,
			#buddypress div.activity-comments form.ac-form,
			#buddypress ul.item-list li div.action .action-wrap,
			#buddypress .activity-list li.new_forum_post .activity-content .activity-inner,
			#buddypress .activity-list li.new_forum_topic .activity-content .activity-inner,
			.bp-user.messages #buddypress div#subnav.item-list-tabs ul li:first-child,
			#contentcolumn,
			#bbpress-forums li.bbp-body ul.forum,
			#bbpress-forums li.bbp-body ul.topic,
			.bp-user.messages #buddypress div.pagination {
			border-color: #c3e7e5;
			}

			#primary, #secondary {
			border-color: #c3e7e5!important;
			}

			@media screen and (max-width: 820px) and (min-width:721px){
			body.left-menu-open.is-desktop .footer-widget:not(:last-child) {
			border-color: #c3e7e5;
			}
			}

			.is-mobile #item-buttons .pop .inner {
			border-color: #c3e7e5;
			}

			@media screen and (max-width: 1000px) and (min-width:721px) {
			body.left-menu-open.messages.bp-user.is-desktop #secondary {
			border-color: #c3e7e5;
			}
			}

		<?php } ?>


		<?php if ( $theme == 'starfish' ) { ?>

			/*** Header Notifications ****/
			body.activity:not(.bp-user)  .item-list-tabs ul li a span, .dir-form .item-list-tabs ul li a span,
			#profile-nav span,
			.header-account-login .pop #dashboard-links .menupop a span,
			.header-account-login .pop ul > li > .ab-sub-wrapper > ul li a span,
			.site-header #wp-admin-bar-shortcode-secondary .alert,
			.header-notifications a.notification-link span {
			background-color: <?php echo esc_attr( boss_get_option( 'boss_links_pr_color' ) ); ?>;
			}

			/******* Input  ******/

			input[type="text"]:not([name="s"]),
			input[type="email"],
			input[type="url"],
			input[type="password"],
			input[type="search"],
			textarea {
			background-color: #efefef;
			-webkit-box-shadow: none;
			-moz-box-shadow:    none;
			box-shadow:         none;
			}

			input[type="text"]:not([name="s"]):focus,
			input[type="email"]:focus,
			input[type="url"]:focus,
			input[type="password"]:focus,
			input[type="search"]:focus,
			textarea:focus {
			color: <?php echo esc_attr( boss_get_option( 'boss_links_pr_color' ) ); ?>;
			background-color: #fff;
			-webkit-box-shadow: none;
			-moz-box-shadow:    none;
			box-shadow:         none;
			}

			/******* Icons  ******/
			.tablet .menu-panel #nav-menu > ul > li.dropdown > a:before,
			.tablet .menu-panel #header-menu > ul > li.dropdown > a:before,
			.tablet .menu-panel .bp_components ul li ul li.menupop.dropdown > a:before,
			body:not(.tablet) .menu-panel .screen-reader-shortcut:hover:before,
			body:not(.tablet) .menu-panel #nav-menu > ul > li:hover > a:before,
			body:not(.tablet) .menu-panel #header-menu > ul > li:hover > a:before,
			body:not(.tablet) .menu-panel .bp_components ul li ul li.menupop:hover > a:before {
			color: <?php echo esc_attr( boss_get_option( 'boss_cover_color' ) ); ?>;
			}

			/******* Tabs ******/
			.ui-tabs-nav.btn-group li.btn:first-child:not(:last-child), .ui-tabs-nav.btn-group li.btn,
			.ui-accordion.accordion h3.ui-accordion-header,
			.ui-accordion-content .inner,
			body.activity:not(.bp-user)  .item-list-tabs ul li:last-child, .dir-form .item-list-tabs ul li:last-child,
			body.activity:not(.bp-user)  .item-list-tabs ul li, .dir-form .item-list-tabs ul li {
			border-color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
			}

			.ui-tabs-nav li.ui-state-default a,
			body.activity:not(.bp-user)  .item-list-tabs ul li a, .dir-form .item-list-tabs ul li a {
			color: <?php echo esc_attr( boss_get_option( 'boss_links_pr_color' ) ); ?>;
			}

			.ui-tabs-nav li.ui-state-active a, .ui-accordion.accordion h3.ui-accordion-header, .ui-accordion.accordion h3.ui-accordion-header-active:after {
			color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
			}

		<?php } ?>


		<?php if ( $theme == 'mint' || $theme == 'iceberg' ) { ?>

			/******* Input  ******/
			input[type="text"]:not([name="s"]),
			input[type="email"],
			input[type="url"],
			input[type="password"],
			input[type="search"],
			textarea {
			background-color: #efefef;
			-webkit-box-shadow: none;
			-moz-box-shadow:    none;
			box-shadow:         none;
			}

			input[type="text"]:not([name="s"]):focus,
			input[type="email"]:focus,
			input[type="url"]:focus,
			input[type="password"]:focus,
			input[type="search"]:focus,
			textarea:focus {
			color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
			background-color: #efefef;
			-webkit-box-shadow: none;
			-moz-box-shadow:    none;
			box-shadow:         none;
			}

		<?php } ?>


		<?php if ( $theme == 'iceberg' || $theme == 'starfish' || $theme == 'battleship' ) { ?>

			.search-wrap input[type="text"] {
			color: <?php echo esc_attr( boss_get_option( 'boss_layout_titlebar_color' ) ); ?>;
			}

		<?php } ?>


		<?php if ( $theme == 'iceberg' ) { ?>

			#masthead #searchsubmit {
			color: <?php echo esc_attr( boss_get_option( 'boss_layout_titlebar_bgcolor' ) ); ?>;
			}

		<?php } ?>


		<?php if ( $theme == 'nocturnal' ) { ?>

			#wp-admin-bar-shortcode-secondary a {
			color: <?php echo esc_attr( boss_get_option( 'boss_layout_titlebar_color' ) ); ?>;
			}

			.bb-global-search-ac.ui-autocomplete:before {
			background-color: rgba(255,255,255,0.4);
			}

			/**** Panel *****/
			body:not(.tablet) .menu-panel #nav-menu > ul > li:hover,
			body:not(.tablet) .menu-panel #header-menu > ul > li:hover,
			body:not(.tablet) .menu-panel ul li .menupop:hover,
			.left-menu-open .menu-panel #nav-menu > ul > li.current-menu-item:hover,
			.left-menu-open .menu-panel #header-menu > ul > li.current-menu-item:hover,
			.left-menu-open .menu-panel #nav-menu > ul > li.current-menu-parent:hover,
			.left-menu-open .menu-panel #header-menu > ul > li.current-menu-parent:hover,
			.left-menu-open .menu-panel ul li .menupop.active:hover,
			.menu-panel #nav-menu > ul > li.dropdown,
			.menu-panel #header-menu > ul > li.dropdown,
			.menu-panel .bp_components ul li ul li.menupop.dropdown,
			.tablet .menu-panel #nav-menu > ul > li.current-menu-item,
			.tablet .menu-panel #header-menu > ul > li.current-menu-item,
			.tablet .menu-panel #nav-menu > ul > li.current-menu-parent,
			.tablet .menu-panel #header-menu > ul > li.current-menu-parent,
			.tablet .bp_components ul li ul li.menupop.active,
			.menu-panel #nav-menu > ul > li.current-menu-item,
			.menu-panel #header-menu > ul > li.current-menu-item,
			.menu-panel #nav-menu > ul > li.current-menu-parent,
			.menu-panel #header-menu > ul > li.current-menu-parent,
			.bp_components ul li ul li.menupop.active {
			background-color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
			}

			.menu-panel #nav-menu > ul > li.dropdown > a,
			.menu-panel #header-menu > ul > li.dropdown > a,
			.menu-panel .bp_components ul li ul li.menupop.dropdown > a,
			body:not(.tablet) .menu-panel #nav-menu > ul > li:hover > a,
			body:not(.tablet) .menu-panel #header-menu > ul > li:hover > a,
			body:not(.tablet) .menu-panel #nav-menu > ul > li:hover > a,
			body:not(.tablet) .menu-panel #header-menu > ul > li:hover > a,
			body:not(.tablet) #left-panel .bp_components ul li ul li.menupop:hover > a,
			.menu-panel #nav-menu > ul > li.current-menu-item > a,
			.menu-panel #header-menu > ul > li.current-menu-item > a,
			.menu-panel #nav-menu > ul > li.current-menu-parent > a,
			.menu-panel #header-menu > ul > li.current-menu-parent > a,
			#left-panel .bp_components ul li ul li.menupop.active > a,
			body:not(.tablet).left-menu-open .menu-panel #nav-menu > ul > li:hover > a,
			body:not(.tablet).left-menu-open .menu-panel #header-menu > ul > li:hover > a,
			body:not(.tablet).left-menu-open .menu-panel #nav-menu > ul > li:hover > a,
			body:not(.tablet).left-menu-open .menu-panel #header-menu > ul > li:hover > a,
			body:not(.tablet).left-menu-open #left-panel .bp_components ul li ul li.menupop:hover > a,
			.left-menu-open .menu-panel #nav-menu > ul > li.current-menu-item > a,
			.left-menu-open .menu-panel #header-menu > ul > li.current-menu-item > a,
			.left-menu-open .menu-panel #nav-menu > ul > li.current-menu-parent > a,
			.left-menu-open .menu-panel #header-menu > ul > li.current-menu-parent > a,
			.left-menu-open #left-panel .bp_components ul li ul li.menupop.active > a {
			color: <?php echo esc_attr( boss_get_option( 'boss_layout_titlebar_bgcolor' ) ); ?>;
			}

			.menu-panel #nav-menu > ul > li.dropdown > a:before,
			.menu-panel .bp_components ul li ul li.menupop.dropdown > a:before,
			body:not(.tablet) .menu-panel #nav-menu > ul > li:hover > a:before,
			body:not(.tablet) .menu-panel #header-menu > ul > li:hover > a:before,
			body:not(.tablet) .menu-panel #nav-menu > ul > li:hover > a:before,
			body:not(.tablet) .menu-panel #header-menu > ul > li:hover > a:before,
			body:not(.tablet) #left-panel .bp_components ul li ul li.menupop:hover > a:before,
			.menu-panel #nav-menu > ul > li.current-menu-item > a:before,
			.menu-panel #nav-menu  > ul > li.current-menu-parent > a:before,
			#left-panel .bp_components ul li ul li.menupop.active > a:before,
			body:not(.tablet).left-menu-open .menu-panel #nav-menu > ul > li:hover > a:before,
			body:not(.tablet).left-menu-open .menu-panel #header-menu > ul > li:hover > a:before,
			body:not(.tablet).left-menu-open .menu-panel #nav-menu > ul > li:hover > a:before,
			body:not(.tablet).left-menu-open .menu-panel #header-menu > ul > li:hover > a:before,
			body:not(.tablet).left-menu-open #left-panel .bp_components ul li ul li.menupop:hover > a:before,
			.left-menu-open .menu-panel #nav-menu > ul > li.current-menu-item > a:before,
			.left-menu-open .menu-panel #header-menu > ul > li.current-menu-item > a:before,
			.left-menu-open .menu-panel #nav-menu > ul > li.current-menu-parent > a:before,
			.left-menu-open .menu-panel #header-menu > ul > li.current-menu-parent > a:before,
			.left-menu-open #left-panel .bp_components ul li ul li.menupop.active > a:before {
			color: <?php echo esc_attr( boss_get_option( 'boss_layout_titlebar_bgcolor' ) ); ?> !important;
			}

			.menu-panel #nav-menu > ul > li.current-menu-item > a:after,
			.menu-panel #header-menu > ul > li.current-menu-item > a:after,
			.menu-panel #nav-menu > ul > li.current-menu-parent > a:after,
			.menu-panel #header-menu > ul > li.current-menu-parent > a:after,
			#left-panel .bp_components ul li ul li.menupop.active > a:after {
			background-color: <?php echo esc_attr( boss_get_option( 'boss_layout_titlebar_bgcolor' ) ); ?> !important;
			}

			.menu-panel #nav-menu .sub-menu-wrap > a,
			.menu-panel #header-menu .sub-menu-wrap > a,
			.menu-panel ul li ul li .ab-sub-wrapper > .ab-item,
			.menu-panel #nav-menu .sub-menu-wrap > ul,
			.menu-panel #header-menu .sub-menu-wrap > ul,
			.menu-panel ul li ul li .ab-sub-wrapper > ul {
			background-color: #242223;
			}

			.menu-panel .sub-menu-wrap:before, .menu-panel .ab-sub-wrapper:before, .menu-panel .sub-menu-wrap:after, .menu-panel .ab-sub-wrapper:after {
			border-color: transparent #242223 transparent transparent;
			}


			/*** Less visible texts ****/
			#buddypress #activity-stream div.acomment-options a.acomment-reply:before, #buddypress #activity-stream .acomment-options .bp-secondary-action:before, #buddypress #activity-stream .acomment-options .delete-activity-single:before, #buddypress #activity-stream .acomment-options .delete-activity:before, #buddypress div.activity-meta a.delete-activity, #buddypress div.activity-meta a.acomment-reply, #buddypress div.activity-meta a.unfav, #buddypress div.activity-meta a.fav, #buddypress div.activity-meta a.buddyboss_media_move, #buddypress #activity-stream .activity-meta .bp-secondary-action:before, #buddypress #activity-stream .activity-meta .delete-activity-single:before, #buddypress #activity-stream .activity-meta .delete-activity:before,
			.comments-area .edit-link a,
			.entry-actions a,
			.comments-area article footer > a {
			color: rgba(255,255,255,0.7);
			}

			#buddypress #activity-stream div.acomment-options a.acomment-reply:hover:before, #buddypress #activity-stream .acomment-options .delete-activity-single:hover:before, #buddypress #activity-stream .acomment-options .delete-activity:hover:before, #buddypress #activity-stream .acomment-options .bp-secondary-action:hover:before, #buddypress div.activity-meta a.unfav:hover:before, #buddypress div.activity-meta a.fav:hover:before, #buddypress div.activity-meta a.buddyboss_media_move:hover:before, #buddypress div.activity-meta a.acomment-reply:hover:before, #buddypress #activity-stream .activity-meta .delete-activity-single:hover:before, #buddypress #activity-stream .activity-meta .delete-activity:hover:before, #buddypress #activity-stream .activity-meta .bp-secondary-action:hover:before,
			.comments-area .edit-link a:hover,
			.comments-area article footer a:hover,
			.entry-actions a:hover,
			.comments-area article footer > a:hover {
			color: rgba(255,255,255, 1);
			}

			/******* Counters ******/
			.item-list li .item-meta .count, body.activity:not(.bp-user)  .item-list-tabs ul li a span, .dir-form .item-list-tabs ul li a span,
			.header-account-login .pop #dashboard-links .menupop a span, .header-account-login .pop ul > li > .ab-sub-wrapper > ul li a span, #buddypress div#item-nav .item-list-tabs ul li a span {
			color: <?php echo esc_attr( boss_get_option( 'boss_layout_titlebar_bgcolor' ) ); ?>;
			}

			/******* Notice ******/
			div#sitewide-notice div#message p {
			color: #fff;
			background-color: rgba(255,255,255,0.1);
			}

			/******* Site Title ******/
			body:not(.left-menu-open) #mastlogo .site-title a:first-letter, #mastlogo .site-title a {
			color: <?php echo esc_attr( boss_get_option( 'boss_layout_titlebar_bgcolor' ) ); ?>;
			}

			/******* Buttons ******/
			<?php echo $header_admin_class; ?> .register, <?php echo $header_admin_class; ?> .login, .header-account-login .pop .logout a {
			background-color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
			color: <?php echo esc_attr( boss_get_option( 'boss_layout_titlebar_bgcolor' ) ); ?>;
			}
			.btn:hover, button:hover, input[type="submit"]:hover, input[type="button"]:not(.button-small):hover, input[type="reset"]:hover, article.post-password-required input[type=submit]:hover, a.button:hover, #create-group-form .remove:hover, #buddypress ul.button-nav li a:hover, #buddypress ul.button-nav li.current a, #buddypress div.generic-button a:hover, #buddypress .comment-reply-link:hover, .entry-title a.button:hover, #buddypress div.activity-comments form input[disabled]:hover,
			.btn, button, input[type="submit"], input[type="button"]:not(.button-small), input[type="reset"], article.post-password-required input[type=submit], li.bypostauthor cite span, a.button, #create-group-form .remove, #buddypress ul.button-nav li a, #buddypress div.generic-button a, #buddypress .comment-reply-link, .entry-title a.button, span.create-a-group > a, #buddypress div.activity-comments form input[disabled]
			{
			color: <?php echo esc_attr( boss_get_option( 'boss_layout_titlebar_bgcolor' ) ); ?>;
			}

			/******* Global borders ******/
			hr,
			.progressbar,
			form#group-settings-form hr
			{
			background-color: rgba(255,255,255,0.1);
			}

			div#sitewide-notice div#message p,
			.archive-header,  .comments-area ol.children, #bbp-search-index-form, #search-message-form, .groups-members-search, #buddypress div.dir-search,
			.author.archive .author-info,
			.secondary-inner #item-actions,
			#group-description,
			#secondary.widget-area .widget,
			.widget-area .widget div.item-options,
			div.footer-inner-top,
			.footer-inner.widget-area,
			.footer-inner-bottom,
			.single .site-content article.post,
			.filters,
			.post-wrap,
			.commentlist > li.comment,
			.search-results .page-header,
			.entry-meta.mobile,
			.footer-inner.widget-area .footer-widget .widget,
			.header-account-login .pop .network-menu,
			.header-account-login .pop #dashboard-links,
			.header-account-login .pop .logout,
			body.activity:not(.bp-user)  .item-list-tabs ,
			.dir-form .item-list-tabs,
			#group-create-body .big-caps,
			#buddypress .profile-fields tr td,
			#buddypress table.notification-settings th,
			.secondary-inner > a img,
			#primary .item-list li,
			#buddypress div#message-threads,
			#buddypress div#message-threads ul,
			div#register-page .register-section,
			div#register-page .security-question-section,
			#buddypress div.activity-comments ul li,
			#buddypress div.activity-comments form.ac-form,
			#buddypress ul.item-list li div.action .action-wrap,
			#buddypress .activity-list li.new_forum_post .activity-content .activity-inner,
			#buddypress .activity-list li.new_forum_topic .activity-content .activity-inner,
			.bp-user.messages #buddypress div#subnav.item-list-tabs ul li:first-child,
			#contentcolumn,
			#bbpress-forums li.bbp-body ul.forum,
			#bbpress-forums li.bbp-body ul.topic,
			.bp-user.messages #buddypress div.pagination {
			border-color: rgba(255,255,255,0.1);
			}

			#primary, #secondary {
			border-color: rgba(255,255,255,0.1) !important;
			}

			@media screen and (max-width: 820px) and (min-width:721px){
			body.left-menu-open.is-desktop .footer-widget:not(:last-child) {
			border-color: rgba(255,255,255,0.1);
			}
			}

			.is-mobile #item-buttons .pop .inner {
			border-color: rgba(255,255,255,0.1);
			}

			@media screen and (max-width: 1000px) and (min-width:721px) {
			body.left-menu-open.messages.bp-user.is-desktop #secondary {
			border-color: rgba(255,255,255,0.1);
			}
			}

		<?php } ?>


		<?php if ( $theme == 'mint' ) { ?>

			.page-template-page-no-buddypanel .header-notifications .pop a:hover, .page-template-page-no-buddypanel .header-navigation ul li a:hover {
			color: <?php echo esc_attr( boss_get_option( 'boss_heading_font_color' ) ); ?>;
			}

			.page-template-page-no-buddypanel .header-inner .search-wrap input[type="text"] {
			background-color: rgba(255,255,255,0.15);
			}

			#wp-admin-bar-shortcode-secondary a {
			color: <?php echo esc_attr( boss_get_option( 'boss_links_color' ) ); ?>;
			}

			/*** Header Links Hover ****/
			.header-account-login .pop .bp_components .menupop:not(#wp-admin-bar-my-account) > .ab-sub-wrapper li.active a,
			.header-account-login .pop .links li > .sub-menu li.current-menu-item a,
			.header-account-login .pop .links li > .sub-menu li.current-menu-parent a,

			#wp-admin-bar-shortcode-secondary a:hover,
			#wp-admin-bar-shortcode-secondary .thread-from a:hover,
			.header-account-login a:hover,
			.header-notifications a.notification-link:hover,
			#wp-admin-bar-shortcode-secondary a:hover .ab-icon:before,
			.header-notifications .pop a:hover,
			#masthead #searchsubmit:hover,
			.header-navigation ul li a:hover {
			color: <?php echo esc_attr( boss_get_option( 'boss_heading_font_color' ) ); ?>;
			}

			.header-account-login .pop .links > .current-menu-item > a, .header-account-login .pop .links > .current-menu-parent > a, .header-account-login .pop .bp_components ul li ul li.menupop.active > a {
			background-color: <?php echo esc_attr( boss_get_option( 'boss_panel_color' ) ); ?>;
			}

			.header-navigation li.hideshow ul {
			border-color: rgba(0,0,0,0.11);
			}

			/**** Search Input ******/
			.header-inner .search-wrap input[type="text"] {
			background-color: rgba(50,200,200,0.1);
			}

			/***** Search Icon ******/
			.groups-members-search input[type="submit"], #buddypress div.dir-search input[type="submit"], #bbpress-forums #bbp-search-index-form input#bbp_search_submit, #buddypress #search-message-form input#messages_search_submit {
			background-image: url(../images/search-gray.svg);
			}

		<?php } ?>


		<?php if ( $theme == 'battleship' || $theme == 'seashell' ) { ?>

			/***** Input ******/
			input[type="text"]:not(#s),
			input[type="email"],
			input[type="url"],
			input[type="password"],
			input[type="search"],
			textarea {
			color: #fff;
			}

			::-webkit-input-placeholder {
			color: rgba(255,255,255,0.7);
			}
			:-moz-placeholder {
			color: rgba(255,255,255,0.7);
			}
			::-moz-placeholder {
			color: rgba(255,255,255,0.7);
			}
			:-ms-input-placeholder {
			color: rgba(255,255,255,0.7);
			}

			#respond form textarea::-webkit-input-placeholder {
			color: rgba(255,255,255,0.7);
			}
			#respond form textarea:-moz-placeholder {
			color: rgba(255,255,255,0.7);
			}
			#respond form textarea::-moz-placeholder {
			color: rgba(255,255,255,0.7);
			}
			#respond form textarea:-ms-input-placeholder {
			color: rgba(255,255,255,0.7);
			}

			/***** Search Icon ******/
			.groups-members-search input[type="submit"], #buddypress div.dir-search input[type="submit"], #bbpress-forums #bbp-search-index-form input#bbp_search_submit, #buddypress #search-message-form input#messages_search_submit {
			background-image: url(../images/search-gray.svg);
			}

		<?php } ?>


		<?php if ( $theme == 'battleship' || $theme == 'seashell' ) { ?>
			.error404 #searchsubmit {
			color: #fff;
			}
		<?php } ?>

		<?php if ( $theme == 'battleship' || $theme == 'seashell' ) { ?>
			/*** Header Notifications ****/
			#profile-nav span,
			.header-account-login .pop #dashboard-links .menupop a span,
			.header-account-login .pop ul > li > .ab-sub-wrapper > ul li a span,
			.site-header #wp-admin-bar-shortcode-secondary .alert,
			.header-notifications a.notification-link span {
			background-color: <?php echo esc_attr( boss_get_option( 'boss_links_pr_color' ) ); ?>;
			}
			<?php
		}
		?>

		<?php
		$blog_img_height = boss_get_option( 'boss_cover_blog_size' );

		if ( boss_get_option( 'boss_cover_blog' ) && $blog_img_height ) {
			?>

			.page-cover > .table-cell {
			height: <?php echo $blog_img_height; ?>px;
			}

		<?php } ?>

        /*** Social Learner ****/

        <?php
        global $learner;

        if($learner){

        $sidebar_color		 = esc_attr( boss_get_option( 'boss_edu_sidebar_bg' ) );
        $active_link_color	 = esc_attr( boss_get_option( 'boss_edu_active_link_color' ) );

        $social_learner_css = "
                #certificates_user_settings input[type=\"checkbox\"] +strong,
                .quiz form ol#sensei-quiz-list li ul li input[type='checkbox'] + label,
                .quiz form ol#sensei-quiz-list li ul li input[type='radio'] + label,
                #buddypress div#group-create-tabs ul > li span,
                .tax-module .course-container .archive-header h1,
                .widget_course_progress footer a.btn,
                .widget .my-account .button, .widget_course_teacher footer a.btn,
                .widget-area .widget_course_teacher header span a,
                .widget_course_progress .module header h2 a,
                #main .widget_course_progress .course header h4 a,
                .widget-area .widget li.fix > a:first-child,
                .widget-area .widget li.fix > a:nth-child(2),
                #main .course-container .module-lessons .lesson header h2,
				.module .module-lessons ul li.completed a,
				.module .module-lessons ul li a,
				#main .course .course-lessons-inner header h2 a,
                #post-entries a,
                .comments-area article header cite a,
                .course-inner h2 a,
                h1, h2, h3, h4, h5, h6,
                .course-inner .sensei-course-meta .price {
                    color: " . esc_attr( boss_get_option( 'boss_heading_font_color' ) ) . ";
                }
                .widget_course_progress footer a.btn,
                .widget .my-account .button, .widget_course_teacher footer a.btn {
                    border-color: " . esc_attr( boss_get_option( 'boss_heading_font_color' ) ) . ";
                }
                body #main-wrap {
                    background-color: " . esc_attr( boss_get_option( 'boss_layout_body_color' ) ) . ";
                }
                .bp-avatar-nav ul.avatar-nav-items li.current {
                    border-bottom-color: " . esc_attr( boss_get_option( 'boss_layout_body_color' ) ) . ";
                }
                .archive.post-type-archive-bp_doc.bp-docs.bp-docs-create #secondary,
                .single-bp_doc.bp-docs #secondary,
                #secondary {
                    background-color: {$sidebar_color};
                }
                .is-desktop.single-bp_doc .page-right-sidebar,
                .is-desktop.single-item.groups .page-right-sidebar {
                    background-color: {$sidebar_color};
                }
                .is-mobile.single-item.groups .page-right-sidebar,
                #primary {
                    background-color: " . esc_attr( boss_get_option( 'boss_layout_body_color' ) ) . ";
                }
                .tablet .menu-panel #nav-menu > ul > li.dropdown > a:before, .tablet .menu-panel .bp_components ul li ul li.menupop.dropdown > a:before, body:not(.tablet) .menu-panel .screen-reader-shortcut:hover:before, body:not(.tablet) .menu-panel #nav-menu > ul > li:hover > a:before, body:not(.tablet) .menu-panel .bp_components ul li ul li.menupop:hover > a:before {
                    color: #fff;
                }
                .course-buttons .status.in-progress,
                .course-container a.button, .course-container a.button:visited, .course-container a.comment-reply-link, .course-container #commentform #submit, .course-container .submit, .course-container input[type=submit], .course-container input.button, .course-container button.button, .course a.button, .course a.button:visited, .course a.comment-reply-link, .course #commentform #submit, .course .submit, .course input[type=submit], .course input.button, .course button.button, .lesson a.button, .lesson a.button:visited, .lesson a.comment-reply-link, .lesson #commentform #submit, .lesson .submit, .lesson input[type=submit], .lesson input.button, .lesson button.button, .quiz a.button, .quiz a.button:visited, .quiz a.comment-reply-link, .quiz #commentform #submit, .quiz .submit, .quiz input[type=submit], .quiz input.button, .quiz button.button {
                    border-color: " . esc_attr( boss_get_option( 'boss_links_color' ) ) . ";
                    color: " . esc_attr( boss_get_option( 'boss_links_color' ) ) . ";
                    background-color: transparent;
                }
                .sensei-content .item-list-tabs ul li:hover, .sensei-content .item-list-tabs ul li.current,
                #learner-info #my-courses.ui-tabs .ui-tabs-nav li:hover a,
                #learner-info #my-courses.ui-tabs .ui-tabs-nav li.ui-state-active a,
                #buddypress div#group-create-tabs ul > li,
                #buddypress div#group-create-tabs ul > li:first-child:not(:last-child),
                .quiz form ol#sensei-quiz-list li ul li.selected {
                    border-color: " . esc_attr( boss_get_option( 'boss_links_color' ) ) . ";
                }
                .sensei-content .item-list-tabs ul li span,
                body:not(.tablet) .menu-panel #nav-menu > ul > li:hover, body:not(.tablet) .menu-panel ul li .menupop:hover,
                .menu-panel ul li a span,
                #course-video #hide-video,
                .quiz form ol#sensei-quiz-list li ul li input[type='checkbox']:checked + label:after,
                .widget_sensei_course_progress header,
                #my-courses .meter > span,
                .widget_course_progress .widgettitle,
                .widget-area .widget.widget_course_progress .course-lessons-widgets > header,
                .course-header {
                    background-color: " . esc_attr( boss_get_option( 'boss_links_color' ) ) . ";
                }
                body:not(.tablet) .menu-panel #nav-menu > ul > li:hover a span, body:not(.tablet) .menu-panel ul li .menupop:hover a span {
                    background-color: #fff;
                    color: " . esc_attr( boss_get_option( 'boss_links_color' ) ) . ";
                }
                nav.navigation.post-navigation .nav-links .nav-previous:before,
                nav.navigation.post-navigation .nav-links .nav-next:after,
                .bp-learndash-activity h4 i.fa-spinner,
                .bp-sensei-activity h4 i.fa-spinner,
                .bp-user.achievements #item-body > #subnav li.current a,
                #content .woocommerce-message .wc-forward,
                .widget_sensei_course_progress .course-progress-lessons .course-progress-lesson a:before,
                #learner-info .my-messages-link:before,
                .post-type-archive-lesson #module_stats span,
                .sensei-course-participants,
                .nav-previous .meta-nav:before,
                .nav-prev .meta-nav:before, .nav-next .meta-nav:before,
                #my-courses .meter-bottom > span > span,
                #my-courses section.entry span.course-lesson-progress,
                .quiz form ol#sensei-quiz-list li>span span,
                .module-archive #module_stats span,
                .widget_course_progress .module header h2 a:hover,
                #main .widget_course_progress .course header h4 a:hover,
                .course-statistic,
                #post-entries a:hover,
                #main .course-container .sensei-course-meta .course-author a,
                #main .course .sensei-course-meta .course-author a,
                .course-inner h2 a:hover,
                .menu-toggle i {
                    color: " . esc_attr( boss_get_option( 'boss_links_color' ) ) . ";
                }
                body.is-desktop,
                .menu-panel, .menu-panel #nav-menu .sub-menu-wrap,
                .bp_components ul li ul li.menupop .ab-sub-wrapper {
                    background-color: " . esc_attr( boss_get_option( 'boss_panel_color' ) ) . ";
                }
                .single-badgeos article .badgeos-item-points,
                .widget-area .widget:not(.widget_buddyboss_recent_post) .widget-achievements-listing li.has-thumb .widget-badgeos-item-title,
                .badgeos-achievements-list-item .badgeos-item-description .badgeos-item-points,
                .widget-area .widget_course_teacher header span p {
                    color: " . esc_attr( boss_get_option( 'boss_layout_titlebar_color' ) ) . ";
                }
                .mobile-site-title .colored,
                .site-title a .colored,
                section.entry span.course-lesson-count,
                .widget_course_progress .module.current header h2 a,
                .module .module-lessons ul li.current a {
                    color: {$active_link_color};
                }
                .sensei-course-filters li a.active,
                #main .course .module-status,
                .module-archive #main .status,
                #main .course .module-status:before,
                .module-archive #main .status:before,
                .lesson-status.in-progress, .lesson-status.not-started,
                .module .module-lessons ul li a:before,
                .module .module-lessons ul li a:hover:before,
                .widget_course_progress .module.current header h2 a:hover,
                .module .module-lessons ul li a:hover,
                #main .course .course-lessons-inner header h2 a:hover {
                    color: " . esc_attr( boss_get_option( 'boss_links_color' ) ) . ";
                }
                .lesson-status.complete,
                .module .module-lessons ul li.completed a:before {
                    color: #61a92c;
                }
                #profile-nav span,
                .widget_categories .cat-item i,
                #wp-admin-bar-shortcode-secondary .alert {
                    background-color: {$active_link_color};
                }
                .widget_categories .cat-item i {
                    background-color: {$active_link_color};
                }
                .course-inner .course-price del,
                .widget_sensei_course_progress .course-progress-lessons .course-progress-lesson.current span {
                    color: {$active_link_color};
                }
                .is-mobile #buddypress div#subnav.item-list-tabs ul li.current a {
                    color: #fff;
                }

                .wpProQuiz_questionList input[type=\"checkbox\"] + strong,
                .wpProQuiz_questionList input[type=\"radio\"] + strong {
                    color: " . esc_attr( boss_get_option( 'boss_heading_font_color' ) ) . ";
                }
                .single-sfwd-lessons u + table td .button-primary,
                .wpProQuiz_button2,
                input[type=\"button\"]:not(.button-small).wpProQuiz_button,
                #sfwd-mark-complete input[type=\"submit\"],
                .sfwd-courses a.button {
                    border-color: " . esc_attr( boss_get_option( 'boss_links_color' ) ) . ";
                    color: " . esc_attr( boss_get_option( 'boss_links_color' ) ) . ";
                }
                .sensei-course-filters li a,
                .sensei-course-filters li a:hover,
                .sensei-course-filters li a.active,
                .wpb_row .woocommerce ul.products li.product a img:hover {
                    border-color: " . esc_attr( boss_get_option( 'boss_links_color' ) ) . ";
                }
                body .wpb_gallery .wpb_flexslider .flex-control-paging .flex-active {
                    background-color: " . esc_attr( boss_get_option( 'boss_links_color' ) ) . ";
                }
                body .entry-content #students .vc_col-sm-3 a,
                body .entry-content #counters h3 {
                    color: " . esc_attr( boss_get_option( 'boss_links_color' ) ) . ";
                }
                .wpProQuiz_formFields input[type=\"radio\"]:checked+strong,
                .courses-quizes-results .percent,
                .wpProQuiz_forms table td:nth-child(2) div,
                .quiz_title a,
                .learndash_profile_quizzes .failed .scores,
                #learndash_profile .list_arrow:before,
                .learndash_profile_heading .ld_profile_status,
                .profile_edit_profile a,
                #course_navigation .learndash_topic_widget_list .topic-notcompleted:before,
                .wpProQuiz_question_page,
                .learndash .in-progress:before,
                .learndash .notcompleted:before {
                    color: " . esc_attr( boss_get_option( 'boss_links_color' ) ) . ";
                }
                .wpProQuiz_quiz_time,
                #learndash_profile dd.course_progress div.course_progress_blue,
                .widget_ldcourseprogress,
                .lms-post-content dd.course_progress div.course_progress_blue,
                .type-sfwd-courses .item-list-tabs ul li span,
                .single-sfwd-quiz dd.course_progress div.course_progress_blue,
                .wpProQuiz_time_limit .wpProQuiz_progress {
                    background-color: " . esc_attr( boss_get_option( 'boss_links_color' ) ) . ";
                }
                .type-sfwd-courses .item-list-tabs ul li:hover, .type-sfwd-courses .item-list-tabs ul li.current {
                    border-color: " . esc_attr( boss_get_option( 'boss_links_color' ) ) . ";
                }
                .wpProQuiz_questionList .wpProQuiz_questionListItem label.selected {
                    border-color: " . esc_attr( boss_get_option( 'boss_links_color' ) ) . ";
                }
                .quiz_title a:hover,
                #learndash_profile .learndash_profile_details b,
                .profile_edit_profile a:hover {
                    color: " . esc_attr( boss_get_option( 'boss_heading_font_color' ) ) . ";
                }
                .wpProQuiz_catName,
                span.wpProQuiz_catPercent {
                    background-color: " . esc_attr( boss_get_option( 'boss_layout_body_color' ) ) . ";
                }
                #course_navigation .topic_item a.current,
                #course_navigation .active .lesson a {
                    color: {$active_link_color};
                }
                #learndash_profile .learndash_profile_heading.course_overview_heading {
                    background-color: {$sidebar_color};
                }
                ";

            echo $social_learner_css;

        }

        if('2' == boss_get_option('boss_header')){

            $sidebar_color		 = esc_attr( boss_get_option( 'boss_edu_sidebar_bg' ) );
            $active_link_color	 = esc_attr( boss_get_option( 'boss_edu_active_link_color' ) );

            $social_learner_header_css = "
            .header-inner {$header_menu_class} .header-navigation ul li a {
                color: " . esc_attr( boss_get_option( 'boss_heading_font_color' ) ) . ";
            }
            .site-header {$header_admin_class} {
                color: #fff;
                background-color: " . esc_attr( boss_get_option( 'boss_panel_color' ) ) . ";
            }
            .header-account-login .user-link span.name:after,
            .header-notifications a.notification-link {
                color: " . esc_attr( boss_get_option( 'boss_layout_titlebar_color' ) ) . ";
            }
            .header-navigation ul li > a:hover:after,
            .header-navigation ul li.current-menu-item > a:after,
            .header-navigation ul li.current-page-item > a:after {
                background-color: {$active_link_color};
            }
            .page-template-page-no-buddypanel .header-navigation #header-menu > ul > li > a:hover,
            .header-inner {$header_menu_class} .header-navigation ul li > a:hover,
            .header-inner {$header_menu_class} .header-navigation ul li.current-menu-item > a,
            .header-inner {$header_menu_class} .header-navigation ul li.current-page-item > a {
                color: {$active_link_color};
            }

            #search-open,
            .header-account-login .pop .logout a {
                color: #fff;
                background-color: " . esc_attr( boss_get_option( 'boss_links_color' ) ) . ";
            }
            .header-navigation li.hideshow > ul, .header-navigation .sub-menu, body.activity:not(.bp-user) .item-list-tabs ul li, .logged-in .dir-form .item-list-tabs ul li, .dir-form .item-list-tabs ul li:last-child {
                 border-top: 2px solid " . esc_attr( boss_get_option( 'boss_links_color' ) ) . " !important;
            }";

            if ( boss_get_option( 'mini_logo_switch' ) && boss_get_option( 'boss_small_logo', 'id' ) ) {
                $social_learner_header_css .= "

                        ";
            }

			if ( boss_get_option( 'logo_switch' ) && boss_get_option( 'boss_logo', 'id' ) ) {
                $social_learner_header_css .= "
                        .is-desktop.left-menu-open .header-navigation > div > ul {
                            height: " . $big_logo_h . "px;
                        }
                        .is-desktop.left-menu-open #header-menu > ul > li {
                            height: " . $big_logo_h . "px;
                            line-height: " . $big_logo_h . "px;
                        }
                        ";
            }

            $theme = boss_get_option( 'boss_scheme_select' );

            if ( !empty( $theme ) && $theme != 'default' && $theme != 'education' ) {
                $social_learner_header_css .= "
                .header-inner {$header_menu_class} .header-navigation ul li a {
                    color: #fff;
                }
                .header-inner {$header_menu_class} .header-navigation ul li a:hover {
                    color: rgba(255,255,255,0.7);
                }
                ";
            }
            
            echo $social_learner_header_css;
        }

		if ( defined('EM_VERSION') && EM_VERSION ) {
            $events_css = "
                #buddypress #dbem-bookings-table th,
                #em-wrapper .events-list-content table th,
                #em-tickets-add,
                #em-tickets-form .form-table thead th,
                .bp-user.events.my-bookings #buddypress table thead th,
                .bp-user.events #buddypress #posts-filter .events-table thead th {
                    background-color: ". esc_attr( boss_get_option( 'boss_links_color' ) ) .";
                }
                .bp-user.events.my-locations #buddypress .widefat thead th {
                    color: ". esc_attr( boss_get_option( 'boss_links_pr_color' ) ) .";
                }
                .events .ui-datepicker .ui-datepicker-header,
                .events .ui-dialog .ui-widget-header {
                    background: ". esc_attr( boss_get_option( 'boss_links_color' ) ) .";
                }
                .events .ui-dialog .ui-state-hover, .ui-widget-content .ui-state-hover, 
                .events .ui-dialog .ui-widget-header .ui-state-hover, .ui-state-focus, 
                .events .ui-dialog .ui-widget-content .ui-state-focus, .ui-widget-header .ui-state-focus,
                .events .ui-dialog .ui-state-default .ui-icon {
                    color: ". esc_attr( boss_get_option( 'boss_links_color' ) ) .";
                    border-color: ". esc_attr( boss_get_option( 'boss_links_color' ) ) .";
                }
                .em-recurring-text #recurrence-interval {
                    color: ". esc_attr( boss_get_option( 'boss_body_font_color' ) ) .";
                }
                body.page:not(.buddypress).events-page .events-list-content table:after,
                body.page:not(.buddypress).events-page .events-list-content table:before {
                    background-color: ". esc_attr( boss_get_option( 'boss_links_color' ) ) .";
                }
                div.css-search div.em-search-main .em-search-submit:hover,
                div.css-search div.em-search-main .em-search-submit {
                    background: ". esc_attr( boss_get_option( 'boss_links_color' ) ) .";
                }
                #events-switch-layout.btn-group > .btn.active,
                #events-switch-layout.btn-group > .btn:hover {
                    background-color: ". esc_attr( boss_get_option( 'boss_links_color' ) ) .";
                }
                .widget table.em-calendar thead td {
                    color: ". esc_attr( boss_get_option( 'boss_links_pr_color' ) ) .";
                    background-color: ". esc_attr( boss_get_option( 'boss_links_color' ) ) .";
                }
                table.em-calendar td.eventful a, 
                table.em-calendar td.eventful-today a {
                    color: ". esc_attr( boss_get_option( 'boss_links_pr_color' ) ) .";
                }
                .widget table.em-calendar td.eventful a, 
                .widget table.em-calendar td.eventful-today a {
                    border-bottom: 1px solid ". esc_attr( boss_get_option( 'boss_links_pr_color' ) ) .";
                }
                .widget table.em-calendar td.eventless-today, 
                .widget table.em-calendar td.eventful-today {
                    background-color: ". esc_attr( boss_get_option( 'boss_links_color' ) ) .";
                }
                .widget-area .widget_em_locations_widget li.bb-location a:not(:hover),
                .widget-area .widget_em_widget li.bb-event a:not(:hover) {
                    color: ". esc_attr( boss_get_option( 'boss_links_pr_color' ) ) .";
                }
                .fc-day-header.ui-widget-header,
                table.fullcalendar tr.days-names td {
                    background: ". esc_attr( boss_get_option( 'boss_panel_color' ) ) .";
                }
                table.fullcalendar thead td.month_name {
                    color: ". esc_attr( boss_get_option( 'boss_links_pr_color' ) ) .";
                }
                .fc-toolbar button {
                    color: ". esc_attr( boss_get_option( 'boss_body_font_color' ) ) .";
                }
                .fc .fc-button-group > button.ui-state-active span:before, 
                .fc .fc-button-group > button.ui-state-hover span:before {
                    color: ". esc_attr( boss_get_option( 'boss_panel_color' ) ) .";
                }
                .fc-toolbar button.ui-state-hover,
                .fc-toolbar button.ui-state-active,
                .fc-toolbar button.ui-state-disabled {
                    border-color: ". esc_attr( boss_get_option( 'boss_links_color' ) ) .";
                    color: ". esc_attr( boss_get_option( 'boss_links_color' ) ) .";
                }
                .wpfc-calendar-search .ui-selectmenu-button.ui-state-hover {
                    border-color: ". esc_attr( boss_get_option( 'boss_links_color' ) ) .";
                }
                .ui-selectmenu-menu .ui-state-focus, .ui-selectmenu-menu .ui-widget-content .ui-state-focus,
                .wpfc-calendar-search .ui-selectmenu-button span.ui-icon,
                .wpfc-calendar-search .ui-selectmenu-button .ui-selectmenu-text {
                    color: ". esc_attr( boss_get_option( 'boss_body_font_color' ) ) .";
                }
                .fc-head tr td {
                    background: ". esc_attr( boss_get_option( 'boss_panel_color' ) ) .";
                }
                .event-details .event-categories,
                .event-details a,
                body.single-event .event-location {
                    color: ". esc_attr( boss_get_option( 'boss_links_color' ) ) .";
                }
                .event-details p strong {
                    color: ". esc_attr( boss_get_option( 'boss_panel_color' ) ) .";
                }
                ";
            echo $events_css;
        }
        
		$css = ob_get_clean();
		$css = apply_filters( 'boss_customizer_css', $css );
		echo '<style type="text/css">';
		echo $css;
		echo '</style>';
	}

	/* Add Action */
	add_action( 'wp_head', 'boss_generate_option_css', 99 );
}