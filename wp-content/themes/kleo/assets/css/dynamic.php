<?php

/* ----------------------------------------------------------------
    Element definitions here
-----------------------------------------------------------------*/

global $kleo_config, $kleo_theme;
$style_sets = $kleo_config['style_sets'];

$sections = kleo_style_options();

if(!empty($sections)) {
foreach ($sections as $name => $section) {


//checks if we have a dark or light background and then creates a stronger version of the main font color for headings
$section['heading'] = kleo_calc_similar_color($section['text'], (kleo_calc_perceived_brightness($section['bg'], 100) ? 'lighter' : 'darker'), 3);


//making sure there are no errors
if (! isset( $section['headings'] )) {
    $section['headings'] = $section['heading'];
}

//check if we have a dark or light background and then creates a lighter version of the main font color
$section['lighter'] = kleo_calc_similar_color($section['bg'], (kleo_calc_perceived_brightness($section['bg'], 100) ? 'lighter' : 'darker'), 4);

// Highlight background color in RBG
$section["high_bg_rgb"] = kleo_hex_to_rgb($section['high_bg']);

// Alternate background color in RBG
$section["alternate_bg_rgb"] = kleo_hex_to_rgb($section['alt_bg']);

// Text color in RBG
$section["text_color_rgb"] = kleo_hex_to_rgb($section['text']);

// Background color in RBG
$section["bg_color_rgb"] = kleo_hex_to_rgb($section['bg']);

// Link color in RBG
$section["link_color_rgb"] = kleo_hex_to_rgb($section['link']);

//check if we have a dark or light background and then create a stronger version of the background color
$section['mat-color-bg'] = kleo_calc_similar_color($section['bg'], (kleo_calc_perceived_brightness($section['bg'], 50) ? 'lighter' : 'darker'), 1);

/* Use like this
 *
 * .<?php echo $name; ?>-color .rgb-element {
 *	background-color: rgba(<?php echo $section['high_bg_rgb']['r']; ?>,<?php echo $section['high_bg_rgb']['g']; ?>,<?php echo $section['high_bg_rgb']['b']; ?>,0.4);
 * }
 */
?>


<?php if ( $name == 'main' ) { //only for main-color ?>

#main {
    background-color: <?php echo $section['bg']; ?>;
}
/*** Popover ***/
.popover-content {
    color: <?php echo $section['text']; ?>;
}
.popover-title {
    color: <?php echo $section['high_color']; ?>;
    background-color: <?php echo $section['high_bg']; ?>;
}
/*** Tooltip ***/
.tooltip-inner {
  border-color: <?php echo $section['border']; ?>;
}
.tooltip.top .tooltip-arrow,
.tooltip.top-left .tooltip-arrow,
.tooltip.top-right .tooltip-arrow {
border-top-color: <?php echo $section['border']; ?>;
}
.tooltip.bottom .tooltip-arrow,
.tooltip.bottom-left .tooltip-arrow,
.tooltip.bottom-right .tooltip-arrow {
  border-bottom-color: <?php echo $section['border']; ?>;
}
.tooltip.right .tooltip-arrow {
  border-right-color: <?php echo $section['border']; ?>;
}
.tooltip.left .tooltip-arrow {
  border-left-color: <?php echo $section['border']; ?>;
}

<?php } else if ( $name == 'header' ) { ?>

    .kleo-notifications {
        background-color: <?php echo $section['alt_bg']; ?>;
    }
    .kleo-notifications.new-alert {
        background-color: <?php echo $section['high_bg']; ?>;
        color: <?php echo $section['high_color']; ?>;
    }
    .kleo-notifications-nav ul.submenu-inner li:before {
        color: <?php echo $section['border']; ?>;
    }

    .kleo-main-header .nav > li.active > a {
        box-shadow: inset 0px <?php if ( sq_option('header_layout') == 'center_logo' ) { echo '-'; } ?>2px 0px 0px <?php echo $section['high_bg']; ?>;
    }
    .kleo-main-header .nav > li > a:hover {
        box-shadow: inset 0px <?php if ( sq_option('header_layout') == 'center_logo' ) { echo '-'; } ?>2px 0px 0px <?php echo $section['border']; ?>;
    }
    .header-centered .dropdown > .dropdown-menu.sub-menu {
        box-shadow: 0px -2px 0px 0px <?php echo $section['border']; ?>;
    }
    .kleo-main-header .nav > li.kleo-toggle-menu a,
    .kleo-main-header .nav > li.kleo-search-nav a,
    .kleo-main-header .nav > li.kleo-toggle-menu a:hover,
    .kleo-main-header .nav > li.kleo-search-nav a:hover {
        box-shadow: none;
    }

    <?php
    if ( $section['border'] == 'transparent' ) { ?>
        .kleo-main-header.header-scrolled { box-shadow: 0 0 2px 0 rgba(0, 0, 0, 0.22); }
    <?php } ?>

<?php } ?>


/*** TEXT COLOR ***/
.<?php echo $name; ?>-color,
.<?php echo $name; ?>-color .logo a,
.<?php echo $name; ?>-color .breadcrumb a,
.<?php echo $name; ?>-color .nav-pills > li > a,
.<?php echo $name; ?>-color .nav-pills > li.active > a,
.<?php echo $name; ?>-color .nav-tabs > li > a,
.<?php echo $name; ?>-color .kleo-tabs .nav-tabs li a i,
.<?php echo $name; ?>-color .kleo-tabs .tabdrop .dropdown-menu li a,
.<?php echo $name; ?>-color .wpb_tour .nav-tab li a,
.<?php echo $name; ?>-color .sidebar ul li a,
.<?php echo $name; ?>-color .sidebar .widget-title,
.<?php echo $name; ?>-color .sidebar h4.widget-title a,
.<?php echo $name; ?>-color .widget_tag_cloud a,
.<?php echo $name; ?>-color #wp-calendar tbody td:hover,
.<?php echo $name; ?>-color .btn-see-through:hover,
.<?php echo $name; ?>-color article .article-meta .entry-date,
.single-attachment .<?php echo $name; ?>-color .link-list a.post-time,

.<?php echo $name; ?>-color input[type="text"],
.<?php echo $name; ?>-color input[type="password"],
.<?php echo $name; ?>-color input[type="date"],
.<?php echo $name; ?>-color input[type="datetime"],
.<?php echo $name; ?>-color input[type="datetime-local"],
.<?php echo $name; ?>-color input[type="month"],
.<?php echo $name; ?>-color input[type="week"],
.<?php echo $name; ?>-color input[type="email"],
.<?php echo $name; ?>-color input[type="number"],
.<?php echo $name; ?>-color input[type="search"],
.<?php echo $name; ?>-color input[type="tel"],
.<?php echo $name; ?>-color input[type="time"],
.<?php echo $name; ?>-color input[type="url"],
.<?php echo $name; ?>-color textarea,

/* Buddypress */
.<?php echo $name; ?>-color #buddypress div.item-list-tabs a,
.<?php echo $name; ?>-color #bp-login-widget-submit,
.<?php echo $name; ?>-color .widget_bp_groups_widget .item-options a,
.<?php echo $name; ?>-color .widget_bp_core_members_widget .item-options a,
.<?php echo $name; ?>-color .widget_bp_core_friends_widget .item-options a,
.<?php echo $name; ?>-color .widget_bp_groups_widget,
.<?php echo $name; ?>-color .widget_bp_core_members_widget,
.<?php echo $name; ?>-color .widget_bp_core_friends_widget,
.<?php echo $name; ?>-color .bp-login-widget-user-logout a,
.<?php echo $name; ?>-color .read-notifications td.notify-text a,
.<?php echo $name; ?>-color #buddypress div.activity-comments form textarea,

.<?php echo $name; ?>-color #buddypress div#item-nav ul li a:hover:before,
.<?php echo $name; ?>-color #buddypress div#item-nav ul li.current a:before,

.<?php echo $name; ?>-color #buddypress button,
.<?php echo $name; ?>-color #buddypress a.button,
.<?php echo $name; ?>-color #buddypress input[type=submit],
.<?php echo $name; ?>-color #buddypress input[type=button],
.<?php echo $name; ?>-color #buddypress input[type=reset],
.<?php echo $name; ?>-color #buddypress ul.button-nav li a,
.<?php echo $name; ?>-color #buddypress div.generic-button a,
    .<?php echo $name; ?>-color.bp-full-width-profile div.generic-button a,
    .<?php echo $name; ?>-color #buddypress .portfolio-filter-tabs li a,
    .<?php echo $name; ?>-color .profile-cover-action a.button:hover,
    .<?php echo $name; ?>-color .profile-cover-action a.button:before,

/* bbPress */
.<?php echo $name; ?>-color .bbp-pagination-links a:hover,
.<?php echo $name; ?>-color .bbp-pagination-links span.current,

/* rtMedia */
.<?php echo $name; ?>-color #rtMedia-queue-list .remove-from-queue,
.<?php echo $name; ?>-color .rtmedia-container .rtmedia-editor-main dl.tabs dd.active > a,
.<?php echo $name; ?>-color .rtmedia-activity-container .rtmedia-editor-main dl.tabs dd.active > a,
.<?php echo $name; ?>-color #buddypress div.rtmedia-activity-container .rtmedia-editor-main dl.tabs dd.active > a,

    /* WooCommerce */
    .<?php echo $name; ?>-color .kleo-toggle-menu .minicart-buttons .btn-default {
	color: <?php echo $section['text']; ?>;
}

.<?php echo $name; ?>-color .navbar-toggle .icon-bar {
	background-color: <?php echo $section['text']; ?>;
}




/*** LINK COLOR ***/
.<?php echo $name; ?>-color a,
.<?php echo $name; ?>-color .navbar-nav .dropdown-menu li a,
.<?php echo $name; ?>-color .dropdown-menu > li > a:hover,
.<?php echo $name; ?>-color .dropdown-menu > li > a:focus,
.<?php echo $name; ?>-color .dropdown-submenu:hover > a,
.<?php echo $name; ?>-color .dropdown-submenu:focus > a,
.<?php echo $name; ?>-color .dropdown-menu > .active > a,
.<?php echo $name; ?>-color .dropdown-menu > .active > a:hover,
.<?php echo $name; ?>-color .dropdown-menu > .active > a:focus,
.<?php echo $name; ?>-color .form-control:focus,
    .<?php echo $name; ?>-color .wrap-canvas-menu .widget_nav_menu .offcanvas-menu .dropdown-menu > li > a,

/*Buddypress*/
.<?php echo $name; ?>-color #buddypress a.button.unfav,
.<?php echo $name; ?>-color .widget_bp_groups_widget .item-options a.selected,
.<?php echo $name; ?>-color .widget_bp_core_members_widget .item-options a.selected,
.<?php echo $name; ?>-color .widget_bp_core_friends_widget .item-options a.selected,
.<?php echo $name; ?>-color .tabs-style-line > li.active > a,
.<?php echo $name; ?>-color #buddypress #profile-edit-form ul.button-nav li.current a,
.<?php echo $name; ?>-color .read-notifications td.notify-text a:hover,
.<?php echo $name; ?>-color .unread-notifications td.notify-text a:hover,

    /* WooCommerce */
    .woocommerce .<?php echo $name; ?>-color .widget_product_categories li.current-cat a {
	color: <?php echo $section['link']; ?>;
}

.<?php echo $name; ?>-color .btn-primary,

/*Buddypress*/
.<?php echo $name; ?>-color #buddypress li span.unread-count,
.<?php echo $name; ?>-color #buddypress #groups-list .item-avatar .member-count {
	background-color: <?php echo $section['link']; ?>;
}
.<?php echo $name; ?>-color .btn-primary,

/*Buddypress*/
.<?php echo $name; ?>-color .checkbox-mark:before,
.<?php echo $name; ?>-color .checkbox-cb:checked ~ .checkbox-mark,
.<?php echo $name; ?>-color #buddypress #profile-edit-form ul.button-nav li.current a,

/*bbPress*/
.<?php echo $name; ?>-color #bbpress-forums .bbp-forums-list {
	border-color: <?php echo $section['link']; ?>;
}





/*** HOVER LINK COLOR ***/
.<?php echo $name; ?>-color a:hover,
.<?php echo $name; ?>-color #top-social li a:hover,
.<?php echo $name; ?>-color .top-menu li > a:hover,
.<?php echo $name; ?>-color .navbar-nav .dropdown-menu li a:hover,
.<?php echo $name; ?>-color .sidebar ul li a:hover,
    .<?php echo $name; ?>-color .wrap-canvas-menu .widget_nav_menu .offcanvas-menu .dropdown-menu > li > a:hover,
    .<?php echo $name; ?>-color .wrap-canvas-menu .widget_nav_menu .offcanvas-menu .dropdown-menu > li > a:focus,

/* Buddypress */
.<?php echo $name; ?>-color #buddypress .activity-list li.load-more a:hover,
.manage-members .<?php echo $name; ?>-color .member-name:hover,
.manage-members .<?php echo $name; ?>-color .member-name a:hover,

/* rtMedia */
.<?php echo $name; ?>-color #rtm-media-options-list ul li .rtmedia-action-buttons:hover,

/* WooCommerce */
.woocommerce .<?php echo $name; ?>-color .yith-wcwl-add-to-wishlist a:hover,
.woocommerce .<?php echo $name; ?>-color li.product figcaption .shop-actions > a.button:hover,
    .<?php echo $name; ?>-color .kleo-toggle-menu .quick-view:hover {
	color: <?php echo $section['link_hover']; ?>;
}




/*** BACKGROUND COLOR ***/
.<?php echo $name; ?>-color,
.<?php echo $name; ?>-color .kleo-main-header,
.<?php echo $name; ?>-color .btn-default:hover,

.<?php echo $name; ?>-color .nav-tabs > li.active > a,
.<?php echo $name; ?>-color .panel,
.<?php echo $name; ?>-color .dropdown-menu,
.<?php echo $name; ?>-color .pagination > li > a,
.<?php echo $name; ?>-color .pagination > li > span,
.<?php echo $name; ?>-color .post-item,
.<?php echo $name; ?>-color .comment-wrap .comment-avatar,
.<?php echo $name; ?>-color #respond .form-submit input#submit:hover,
.<?php echo $name; ?>-color .form-control,
.<?php echo $name; ?>-color .pricing-table li.list-group-item,
.<?php echo $name; ?>-color .btn-see-through:hover,
.<?php echo $name; ?>-color #ajax_search_container,
.<?php echo $name; ?>-color #ajax_search_container:before,
.<?php echo $name; ?>-color .kleo-toggle-menu .kleo-toggle-submenu:before,
    .<?php echo $name; ?>-color .box-style .feature-item.default-icons-size .feature-icon,
    .<?php echo $name; ?>-color .box-style .feature-item.big-icons-size .feature-icon,

/*Buddypress*/

.<?php echo $name; ?>-color #wp-calendar caption,
.<?php echo $name; ?>-color #buddypress input[type=submit],
.<?php echo $name; ?>-color #buddypress #friend-list .friend-inner-list,
.<?php echo $name; ?>-color #buddypress #member-list .member-inner-list,
.<?php echo $name; ?>-color #buddypress #members-list .member-inner-list,
.<?php echo $name; ?>-color #buddypress #groups-list .group-inner-list,
.<?php echo $name; ?>-color #buddypress .activity-list .activity-avatar,

.<?php echo $name; ?>-color .profile-cover-action a.button:hover,
.<?php echo $name; ?>-color .profile-cover-action a.button:before,
.<?php echo $name; ?>-color div#item-header .toggle-header .bp-toggle-less:hover,
.<?php echo $name; ?>-color div#item-header .toggle-header .bp-toggle-more:hover,
.<?php echo $name; ?>-color div#item-header .toggle-header .bp-toggle-less:before,
.<?php echo $name; ?>-color div#item-header .toggle-header .bp-toggle-more:before,

.<?php echo $name; ?>-color #buddypress .standard-form textarea,
.<?php echo $name; ?>-color #buddypress .standard-form input[type=text],
.<?php echo $name; ?>-color #buddypress .standard-form input[type=color],
.<?php echo $name; ?>-color #buddypress .standard-form input[type=date],
.<?php echo $name; ?>-color #buddypress .standard-form input[type=datetime],
.<?php echo $name; ?>-color #buddypress .standard-form input[type=datetime-local],
.<?php echo $name; ?>-color #buddypress .standard-form input[type=email],
.<?php echo $name; ?>-color #buddypress .standard-form input[type=month],
.<?php echo $name; ?>-color #buddypress .standard-form input[type=number],
.<?php echo $name; ?>-color #buddypress .standard-form input[type=range],
.<?php echo $name; ?>-color #buddypress .standard-form input[type=search],
.<?php echo $name; ?>-color #buddypress .standard-form input[type=tel],
.<?php echo $name; ?>-color #buddypress .standard-form input[type=time],
.<?php echo $name; ?>-color #buddypress .standard-form input[type=url],
.<?php echo $name; ?>-color #buddypress .standard-form input[type=week],
.<?php echo $name; ?>-color #buddypress .standard-form select,
.<?php echo $name; ?>-color #buddypress .standard-form input[type=password],
.<?php echo $name; ?>-color #buddypress .dir-search input[type=search],
.<?php echo $name; ?>-color #buddypress .dir-search input[type=text],

/*bbPress*/
.<?php echo $name; ?>-color .bbp-pagination-links a,
.<?php echo $name; ?>-color .bbp-pagination-links span,
.<?php echo $name; ?>-color .bbp-submit-wrapper button.button:hover,
.<?php echo $name; ?>-color #bbpress-forums .bbp-form input[type="text"],
.<?php echo $name; ?>-color .wp-editor-area,

/* rtMedia */
.<?php echo $name; ?>-color #rtMedia-upload-button,
.<?php echo $name; ?>-color #buddypress div.rtmedia-single-container .rtmedia-single-meta button,
.<?php echo $name; ?>-color .rtmedia-container .rtmedia-editor-main dl.tabs dd > a,
.<?php echo $name; ?>-color .rtmedia-activity-container .rtmedia-editor-main dl.tabs dd > a,
.<?php echo $name; ?>-color #buddypress div.rtmedia-activity-container .rtmedia-editor-main dl.tabs dd > a,

/* WPML */
.<?php echo $name; ?>-color .submenu-languages,

/* WooCommerce */
.<?php echo $name; ?>-color .kleo-toggle-menu .kleo-toggle-submenu,
.<?php echo $name; ?>-color .kleo-toggle-menu .minicart-buttons .btn-default {

	background-color: <?php echo $section['bg']; ?>;
}

<?php
/* Dividers check for transparent BG */
$bg_fallback = $section['bg'] == 'transparent' ? '#ffffff' : $section['bg'];

?>
.<?php echo $name; ?>-color .hr-title abbr,
.<?php echo $name; ?>-color .kleo_ajax_results h4 span,
.<?php echo $name; ?>-color #buddypress .activity-read-more a {
    background-color: <?php echo $bg_fallback; ?>;
}


.<?php echo $name; ?>-color .btn-primary,
.<?php echo $name; ?>-color .btn-primary:hover,
.<?php echo $name; ?>-color .btn-see-through,
    .<?php echo $name; ?>-color .bordered-icons .feature-item:hover .feature-icon,
    .<?php echo $name; ?>-color .colored-icons.bordered-icons .feature-item:hover .feature-icon,

/*Buddypress*/
.buddypress .<?php echo $name; ?>-color #item-header-avatar {
	color: <?php echo $section['bg']; ?>;
}

.<?php echo $name; ?>-color .post-header:before,
    .<?php echo $name; ?>-color .bordered-icons .feature-item:hover .feature-icon,
    .<?php echo $name; ?>-color .colored-icons.bordered-icons .feature-item:hover .feature-icon,

/*Buddypress*/
.<?php echo $name; ?>-color #buddypress #groups-list .item-avatar .member-count,
.<?php echo $name; ?>-color #buddypress li span.unread-count {
	border-color: <?php echo $section['bg']; ?>;
}
.<?php echo $name; ?>-color .callout-blockquote blockquote:after {
	border-top-color: <?php echo $section['bg']; ?>;
}




/*** BORDER COLOR ***/
.<?php echo $name; ?>-color hr,
.<?php echo $name; ?>-color.container-wrap, /* without space between classes*/
.<?php echo $name; ?>-color#footer, /* without space between classes*/
.<?php echo $name; ?>-color#socket, /* without space between classes*/
.<?php echo $name; ?>-color.social-header,
.<?php echo $name; ?>-color .top-menu .tabdrop:before,
.<?php echo $name; ?>-color #top-social .tabdrop:before,
.<?php echo $name; ?>-color #top-social,
.<?php echo $name; ?>-color .top-menu > ul,
.<?php echo $name; ?>-color .kleo-main-header,
.<?php echo $name; ?>-color .template-page,
.<?php echo $name; ?>-color .sidebar-right,
.<?php echo $name; ?>-color .sidebar-left,
.<?php echo $name; ?>-color .sidebar-extra,
.<?php echo $name; ?>-color .sidebar-main,
.<?php echo $name; ?>-color .hr-title,
.<?php echo $name; ?>-color .nav-tabs,
.<?php echo $name; ?>-color .nav-pills > li > a,
.<?php echo $name; ?>-color .kleo-tabs .nav .open > a.dropdown-toggle,
.<?php echo $name; ?>-color .kleo-tabs .nav .open > a.dropdown-toggle:hover,
.<?php echo $name; ?>-color .kleo-tabs .nav .open > a.dropdown-toggle:focus,
.<?php echo $name; ?>-color .kleo-tabs .tabdrop .dropdown-menu,
.<?php echo $name; ?>-color .dropdown-menu,
    .<?php echo $name; ?>-color .kleo-toggle-menu .kleo-toggle-submenu:before,
    .<?php echo $name; ?>-color #ajax_search_container:before,
.<?php echo $name; ?>-color #top-social li a,
.<?php echo $name; ?>-color .top-menu li > a,
.<?php echo $name; ?>-color .pagination > li > a,
.<?php echo $name; ?>-color .pagination > li > span,
.<?php echo $name; ?>-color .callout-blockquote blockquote,
.<?php echo $name; ?>-color .masonry-listing .post-content,
.<?php echo $name; ?>-color .list-divider li,
.<?php echo $name; ?>-color #ajax_search_container,
.<?php echo $name; ?>-color .form-control,
    .<?php echo $name; ?>-color .feature-item:hover .feature-icon,
    .<?php echo $name; ?>-color .bordered-icons .feature-item.default-icons-size .feature-icon,
    .<?php echo $name; ?>-color .bordered-icons .feature-item.big-icons-size .feature-icon,

.<?php echo $name; ?>-color input[type="text"],
.<?php echo $name; ?>-color input[type="password"],
.<?php echo $name; ?>-color input[type="date"],
.<?php echo $name; ?>-color input[type="datetime"],
.<?php echo $name; ?>-color input[type="datetime-local"],
.<?php echo $name; ?>-color input[type="month"],
.<?php echo $name; ?>-color input[type="week"],
.<?php echo $name; ?>-color input[type="email"],
.<?php echo $name; ?>-color input[type="number"],
.<?php echo $name; ?>-color input[type="search"],
.<?php echo $name; ?>-color input[type="tel"],
.<?php echo $name; ?>-color input[type="time"],
.<?php echo $name; ?>-color input[type="url"],
.<?php echo $name; ?>-color textarea,

/* Buddypress */
.<?php echo $name; ?>-color .activity-timeline,
.<?php echo $name; ?>-color #buddypress div.item-list-tabs ul li a span,
.<?php echo $name; ?>-color #buddypress button,
.buddypress .<?php echo $name; ?>-color a.button,
.<?php echo $name; ?>-color #buddypress a.button,
.<?php echo $name; ?>-color #buddypress input[type=submit],
.<?php echo $name; ?>-color #buddypress input[type=button],
.<?php echo $name; ?>-color #buddypress input[type=reset],
.<?php echo $name; ?>-color #buddypress ul.button-nav li a,
.<?php echo $name; ?>-color #buddypress div.generic-button a,
    .<?php echo $name; ?>-color.bp-full-width-profile div.generic-button a,
.<?php echo $name; ?>-color #buddypress .comment-reply-link,
.<?php echo $name; ?>-color #buddypress #whats-new,
.<?php echo $name; ?>-color #buddypress div.message-search,
.<?php echo $name; ?>-color #buddypress div.dir-search,
.<?php echo $name; ?>-color #buddypress .activity-read-more,
.<?php echo $name; ?>-color #bp-login-widget-submit,
.<?php echo $name; ?>-color .bbp_widget_login .button.user-submit,
.<?php echo $name; ?>-color #wp-calendar caption,
.<?php echo $name; ?>-color .wp-caption,
.<?php echo $name; ?>-color .widget .woocommerce-product-search,
.<?php echo $name; ?>-color .widget form#bbp-search-form > div,
.<?php echo $name; ?>-color .page-content #searchform > div,
.<?php echo $name; ?>-color .widget_search #searchform > div,
.<?php echo $name; ?>-color #bp-login-widget-form input[type="text"],
.<?php echo $name; ?>-color #bp-login-widget-form input[type="password"],
.<?php echo $name; ?>-color .bbp-login-form input[type="text"],
.<?php echo $name; ?>-color #buddypress #friend-list .friend-inner-list,
.<?php echo $name; ?>-color #buddypress #member-list .member-inner-list,
.<?php echo $name; ?>-color #buddypress #members-list .member-inner-list,
.<?php echo $name; ?>-color #buddypress #groups-list .group-inner-list,
.<?php echo $name; ?>-color #buddypress div#item-nav .tabdrop .dropdown-menu,
.<?php echo $name; ?>-color #buddypress div.profile,
.<?php echo $name; ?>-color #buddypress #friend-list div.action .generic-button a.send-message,
.<?php echo $name; ?>-color #buddypress #member-list div.action .generic-button a.send-message,
.<?php echo $name; ?>-color #buddypress #members-list div.action .generic-button a.send-message,
.<?php echo $name; ?>-color #buddypress form.standard-form .left-menu img.avatar,
.<?php echo $name; ?>-color .checkbox-mark,
.<?php echo $name; ?>-color #buddypress div#group-create-tabs ul li.current a,
.<?php echo $name; ?>-color .rtmedia-container #rtMedia-queue-list tr td,

.<?php echo $name; ?>-color #buddypress .standard-form textarea,
.<?php echo $name; ?>-color #buddypress .standard-form input[type=text],
.<?php echo $name; ?>-color #buddypress .standard-form input[type=color],
.<?php echo $name; ?>-color #buddypress .standard-form input[type=date],
.<?php echo $name; ?>-color #buddypress .standard-form input[type=datetime],
.<?php echo $name; ?>-color #buddypress .standard-form input[type=datetime-local],
.<?php echo $name; ?>-color #buddypress .standard-form input[type=email],
.<?php echo $name; ?>-color #buddypress .standard-form input[type=month],
.<?php echo $name; ?>-color #buddypress .standard-form input[type=number],
.<?php echo $name; ?>-color #buddypress .standard-form input[type=range],
.<?php echo $name; ?>-color #buddypress .standard-form input[type=search],
.<?php echo $name; ?>-color #buddypress .standard-form input[type=tel],
.<?php echo $name; ?>-color #buddypress .standard-form input[type=time],
.<?php echo $name; ?>-color #buddypress .standard-form input[type=url],
.<?php echo $name; ?>-color #buddypress .standard-form input[type=week],
.<?php echo $name; ?>-color #buddypress .standard-form select,
.<?php echo $name; ?>-color #buddypress .standard-form input[type=password],
.<?php echo $name; ?>-color #buddypress .dir-search input[type=search],
.<?php echo $name; ?>-color #buddypress .dir-search input[type=text],

/* bbPress */
.<?php echo $name; ?>-color .bbp-pagination-links a,
.<?php echo $name; ?>-color .bbp-pagination-links span,
.<?php echo $name; ?>-color #bbpress-forums li.bbp-body ul.forum,
.<?php echo $name; ?>-color #bbpress-forums li.bbp-body ul.topic,
.<?php echo $name; ?>-color form#new-post,
.<?php echo $name; ?>-color #bbpress-forums .bbp-form input[type="text"],
.<?php echo $name; ?>-color .quicktags-toolbar,
.<?php echo $name; ?>-color .wp_themeSkin tr.mceFirst td.mceToolbar,
.<?php echo $name; ?>-color .quicktags-toolbar input,
.<?php echo $name; ?>-color .wp-editor-area,

/* rtMedia */
.<?php echo $name; ?>-color .rtmedia-container .rtmedia_next_prev a,
.<?php echo $name; ?>-color .rtmedia-activity-container .rtmedia_next_prev a,
.<?php echo $name; ?>-color #buddypress div.rtmedia-activity-container .rtmedia_next_prev a,
.<?php echo $name; ?>-color #rtm-gallery-title-container #rtm-media-options,
.<?php echo $name; ?>-color #rtMedia-upload-button,
.<?php echo $name; ?>-color #buddypress #item-body .rtmedia-item-comments .rt_media_comment_form textarea,
.<?php echo $name; ?>-color .rtmedia-container .rtmedia-editor-main dl.tabs dd > a,
.<?php echo $name; ?>-color .rtmedia-activity-container .rtmedia-editor-main dl.tabs dd > a,
.<?php echo $name; ?>-color #buddypress div.rtmedia-activity-container .rtmedia-editor-main dl.tabs dd > a,
.<?php echo $name; ?>-color .rtmedia-container .imgedit-wrap div.imgedit-settings .imgedit-group,

.<?php echo $name; ?>-color #buddypress .rtmedia-container textarea,
.<?php echo $name; ?>-color #buddypress .rtmedia-container input[type=text],
.<?php echo $name; ?>-color #buddypress .rtmedia-container input[type=text],
.<?php echo $name; ?>-color #buddypress .rtmedia-container input[type=color],
.<?php echo $name; ?>-color #buddypress .rtmedia-container input[type=date],
.<?php echo $name; ?>-color #buddypress .rtmedia-container input[type=datetime],
.<?php echo $name; ?>-color #buddypress .rtmedia-container input[type=datetime-local],
.<?php echo $name; ?>-color #buddypress .rtmedia-container input[type=email],
.<?php echo $name; ?>-color #buddypress .rtmedia-container input[type=month],
.<?php echo $name; ?>-color #buddypress .rtmedia-container input[type=number],
.<?php echo $name; ?>-color #buddypress .rtmedia-container input[type=range],
.<?php echo $name; ?>-color #buddypress .rtmedia-container input[type=search],
.<?php echo $name; ?>-color #buddypress .rtmedia-container input[type=tel],
.<?php echo $name; ?>-color #buddypress .rtmedia-container input[type=time],
.<?php echo $name; ?>-color #buddypress .rtmedia-container input[type=url],
.<?php echo $name; ?>-color #buddypress .rtmedia-container input[type=week],
.<?php echo $name; ?>-color #buddypress .rtmedia-container select,
.<?php echo $name; ?>-color #buddypress .rtmedia-container input[type=password],

/* WooCommerce */
.<?php echo $name; ?>-color .kleo-toggle-menu .kleo-toggle-submenu,
    .<?php echo $name; ?>-color .kleo-toggle-menu a.remove,
.<?php echo $name; ?>-color .woocommerce .kleo-cart-totals .totals-wrap,
    .<?php echo $name; ?>-color .kleo-toggle-menu .minicart-buttons .btn-default,
    .<?php echo $name; ?>-color .kleo_ajax_results h4,
    .<?php echo $name; ?>-color .ajax_view_all,

/* Social Article plugin */
.<?php echo $name; ?>-color #articles-dir-list article.article-container {
  border-color: <?php echo $section['border']; ?>;
}

.<?php echo $name; ?>-color .panel-kleo .panel-heading + .panel-collapse .panel-body,
.<?php echo $name; ?>-color .widget_nav_menu li:first-child > a,
.<?php echo $name; ?>-color .kleo-widget-recent-posts-li:first-child,
.<?php echo $name; ?>-color .widget_categories li:first-child,
.<?php echo $name; ?>-color .widget_recent_entries li:first-child,
.<?php echo $name; ?>-color .widget_archive li:first-child,
.<?php echo $name; ?>-color .widget_display_views li:first-child,
.<?php echo $name; ?>-color .widget_recent_comments li:first-child,
.<?php echo $name; ?>-color .widget_product_categories li:first-child,
.<?php echo $name; ?>-color .widget_layered_nav li:first-child,

/* Buddypress */
.<?php echo $name; ?>-color #buddypress div.activity-comments ul li,
.<?php echo $name; ?>-color #buddypress #item-body #pag-bottom,


/* WooCommerce */
.woocommerce .<?php echo $name; ?>-color table.shop_table td,
.woocommerce-page .<?php echo $name; ?>-color table.shop_table td,

/* Social Article plugin */
.<?php echo $name; ?>-color .article-content .article-metadata,
.<?php echo $name; ?>-color .article-content .article-categories,

/* Paid memberships Pro */
.<?php echo $name; ?>-color #pmpro_account .pmpro_box {
  border-top-color: <?php echo $section['border']; ?>;
}

/* rtMedia */
.<?php echo $name; ?>-color #rtMedia-queue-list {
  border-left-color: <?php echo $section['border']; ?>;
}

    #header.<?php echo $name; ?>-color .navbar-nav li,
.<?php echo $name; ?>-color .widget_nav_menu a,
.<?php echo $name; ?>-color .wpex-widget-recent-posts-li,
.<?php echo $name; ?>-color .widget_categories li,
.<?php echo $name; ?>-color .widget_recent_entries li,
.<?php echo $name; ?>-color .widget_archive li,
.<?php echo $name; ?>-color .widget_display_views li,
.<?php echo $name; ?>-color .widget_recent_comments li,
.<?php echo $name; ?>-color .widget_product_categories li,
.<?php echo $name; ?>-color .widget_layered_nav li,
.<?php echo $name; ?>-color .panel-kleo,
.<?php echo $name; ?>-color .panel-kleo .panel,
.<?php echo $name; ?>-color legend,
.<?php echo $name; ?>-color #comments-list .comment-content,
.<?php echo $name; ?>-color .pricing-table .panel-heading h3,
.<?php echo $name; ?>-color .kleo_ajax_entry,
.<?php echo $name; ?>-color .kleo-toggle-submenu .kleo-submenu-item,
.<?php echo $name; ?>-color .posts-listing.standard-listing:not(.template-page) .type-post,

.<?php echo $name; ?>-color .news-focus .left-thumb-listing .post-content,
.<?php echo $name; ?>-color .news-highlight .left-thumb-listing .post-content,

/* Buddypress */
.<?php echo $name; ?>-color #buddypress div#item-nav,
.<?php echo $name; ?>-color #buddypress .activity-list .activity-content,
.<?php echo $name; ?>-color #buddypress form.standard-form .left-menu #invite-list ul li,
.<?php echo $name; ?>-color #buddypress form.standard-form div#invite-list ul li,
.<?php echo $name; ?>-color #buddypress div.item-list-tabs#subnav,
.<?php echo $name; ?>-color #buddypress div#message-thread div.message-content,
.<?php echo $name; ?>-color #buddypress ul.mesage-item,
.<?php echo $name; ?>-color #buddypress div.messages .pagination,


/* WooCommerce */
.<?php echo $name; ?>-color .kleo-toggle-menu .minicart-header,
.<?php echo $name; ?>-color .kleo-toggle-menu .cart-product,
.woocommerce .<?php echo $name; ?>-color table.shop_table thead,
.woocommerce-page .<?php echo $name; ?>-color table.shop_table thead,
.woocommerce .<?php echo $name; ?>-color .cart_totals table th,
.woocommerce .<?php echo $name; ?>-color .cart_totals table td {
  border-bottom-color: <?php echo $section['border']; ?>;
}

.<?php echo $name; ?>-color .carousel-pager a,
.<?php echo $name; ?>-color .mejs-controls .mejs-time-rail .mejs-time-loaded {
  background-color: <?php echo $section['border']; ?>;
}
    .<?php echo $name; ?>-color.container-wrap.border-bottom.half-section:before {
    background-color: <?php echo $section['border']; ?> !important;
    }
.<?php echo $name; ?>-color .pricing-table .list-group-item:before {
  color: <?php echo $section['border']; ?>;
}





/*** ALTERNATE BACKGROUND COLOR ***/
.<?php echo $name; ?>-color .btn-default,
.<?php echo $name; ?>-color .nav-pills > li.active > a,
.<?php echo $name; ?>-color .nav-pills > li.active > a:hover,
.<?php echo $name; ?>-color .nav-pills > li.active > a:focus,
.<?php echo $name; ?>-color .wpb_tour .nav-tab li.active,
.<?php echo $name; ?>-color .wpb_tour .nav-tab li:hover,
.<?php echo $name; ?>-color .tabs-style-square > li > a,
.<?php echo $name; ?>-color .panel-default > .panel-heading,
.<?php echo $name; ?>-color .dropdown-menu > li > a:hover,
.<?php echo $name; ?>-color .dropdown-menu > li > a:focus,
.<?php echo $name; ?>-color .dropdown-menu > .active > a,
.<?php echo $name; ?>-color .dropdown-menu > .active > a:hover,
.<?php echo $name; ?>-color .dropdown-menu > .active > a:focus,
.<?php echo $name; ?>-color .pagination > li > a:hover,
.<?php echo $name; ?>-color .pagination > li > span.current,
.<?php echo $name; ?>-color #wp-calendar thead th,
.<?php echo $name; ?>-color #wp-calendar tbody td a,
.<?php echo $name; ?>-color .widget_tag_cloud a,
.<?php echo $name; ?>-color .widget_nav_menu li.active > a,
.<?php echo $name; ?>-color #wp-calendar tbody td:hover,
.<?php echo $name; ?>-color .widget_nav_menu .current_page_item > a,
.<?php echo $name; ?>-color .callout-blockquote blockquote,
.<?php echo $name; ?>-color #respond .form-submit input#submit,
.<?php echo $name; ?>-color .form-control:focus,
.<?php echo $name; ?>-color .pricing-table .panel-heading,
.<?php echo $name; ?>-color .pricing-table .panel-body,
.<?php echo $name; ?>-color .pricing-table .pmpro-price .lead,
.<?php echo $name; ?>-color .pricing-table .extra-description,
.<?php echo $name; ?>-color .mejs-container .mejs-controls,
.<?php echo $name; ?>-color .box-style .feature-item,

.<?php echo $name; ?>-color input[type="text"][disabled],
.<?php echo $name; ?>-color input[type="password"][disabled],
.<?php echo $name; ?>-color input[type="date"][disabled],
.<?php echo $name; ?>-color input[type="datetime"][disabled],
.<?php echo $name; ?>-color input[type="datetime-local"][disabled],
.<?php echo $name; ?>-color input[type="month"][disabled],
.<?php echo $name; ?>-color input[type="week"][disabled],
.<?php echo $name; ?>-color input[type="email"][disabled],
.<?php echo $name; ?>-color input[type="number"][disabled],
.<?php echo $name; ?>-color input[type="search"][disabled],
.<?php echo $name; ?>-color input[type="tel"][disabled],
.<?php echo $name; ?>-color input[type="time"][disabled],
.<?php echo $name; ?>-color input[type="url"][disabled],
.<?php echo $name; ?>-color textarea[disabled],

/* Buddypress */
.<?php echo $name; ?>-color #buddypress div.item-list-tabs ul li a span,
.<?php echo $name; ?>-color #bp-login-widget-submit,
.<?php echo $name; ?>-color .bbp_widget_login .button.user-submit,
.<?php echo $name; ?>-color .rtmedia-container #rtMedia-queue-list tr > td.close,
.<?php echo $name; ?>-color .rtmedia-activity-container #rtMedia-queue-list tr > td.close,
.<?php echo $name; ?>-color #buddypress div.activity-comments form .ac-textarea,
.<?php echo $name; ?>-color #buddypress .standard-form input[type=text]:focus,
.<?php echo $name; ?>-color #buddypress table.notifications thead tr,
.<?php echo $name; ?>-color #buddypress table.notifications-settings thead tr,
.<?php echo $name; ?>-color #buddypress table.profile-fields thead tr,
.<?php echo $name; ?>-color #buddypress table.wp-profile-fields thead tr,
.<?php echo $name; ?>-color #buddypress table.messages-notices thead tr,
.<?php echo $name; ?>-color #buddypress table.forum thead tr,

.<?php echo $name; ?>-color #buddypress button:hover,
.<?php echo $name; ?>-color #buddypress a.button:hover,
.<?php echo $name; ?>-color #buddypress a.button:focus,
.<?php echo $name; ?>-color #buddypress a.bp-secondary-action.view:hover,
.<?php echo $name; ?>-color #buddypress input[type=submit]:hover,
.<?php echo $name; ?>-color #buddypress input[type=button]:hover,
.<?php echo $name; ?>-color #buddypress input[type=reset]:hover,
.<?php echo $name; ?>-color #buddypress ul.button-nav li a:hover,
.<?php echo $name; ?>-color #buddypress ul.button-nav li.current a,
.<?php echo $name; ?>-color #buddypress div.generic-button a:hover,
    .<?php echo $name; ?>-color.bp-full-width-profile div.generic-button a:hover,
.<?php echo $name; ?>-color #buddypress .comment-reply-link:hover,

/* bbPress */
.<?php echo $name; ?>-color .bbp-pagination-links a:hover,
.<?php echo $name; ?>-color .bbp-pagination-links span.current,
.<?php echo $name; ?>-color #bbpress-forums li.bbp-body ul.topic.sticky,
.<?php echo $name; ?>-color .bbp-submit-wrapper button.button,
.<?php echo $name; ?>-color #bbpress-forums .bbp-form input[type="text"]:focus,
.<?php echo $name; ?>-color .wp-editor-area:focus,
.<?php echo $name; ?>-color .bbp-row-actions #favorite-toggle a,
.<?php echo $name; ?>-color .bbp-row-actions #subscription-toggle a,

/* rtMedia */
.<?php echo $name; ?>-color .rtmedia-container .drag-drop,
.<?php echo $name; ?>-color .rtmedia-activity-container .drag-drop,
.<?php echo $name; ?>-color #buddypress div.rtmedia-activity-container .drag-drop,
.<?php echo $name; ?>-color #buddypress #item-body .rtmedia-container ul#rtmedia_comment_ul li,
.<?php echo $name; ?>-color #buddypress #item-body .rtmedia-activity-container ul#rtmedia_comment_ul li,
.<?php echo $name; ?>-color .rtmedia-container .rtmedia-editor-main dl.tabs dd.active > a,
.<?php echo $name; ?>-color .rtmedia-activity-container .rtmedia-editor-main dl.tabs dd.active > a,
.<?php echo $name; ?>-color #buddypress div.rtmedia-activity-container .rtmedia-editor-main dl.tabs dd.active > a,
.<?php echo $name; ?>-color .rtmedia-container .rtmedia-editor-main dl.tabs dd > a:hover,
.<?php echo $name; ?>-color .rtmedia-activity-container .rtmedia-editor-main dl.tabs dd > a:hover,
.<?php echo $name; ?>-color #buddypress div.rtmedia-activity-container .rtmedia-editor-main dl.tabs dd > a:hover,
.<?php echo $name; ?>-color .rtmedia-container .imgedit-wrap div.imgedit-menu,
.<?php echo $name; ?>-color .rtmedia-container .imgedit-menu div,

/* WooCommerce */
.<?php echo $name; ?>-color .kleo-toggle-menu .minicart-total-checkout,
.<?php echo $name; ?>-color .kleo-toggle-menu .minicart-buttons,
    .<?php echo $name; ?>-color .kleo-toggle-menu a.remove:hover,

.woocommerce .<?php echo $name; ?>-color .widget_product_search #searchsubmit,
.woocommerce .<?php echo $name; ?>-color #content input.button,
.woocommerce .<?php echo $name; ?>-color #respond input#submit,
.woocommerce .<?php echo $name; ?>-color a.button,
.woocommerce .<?php echo $name; ?>-color button.button,
.woocommerce .<?php echo $name; ?>-color input.button,
.woocommerce-page .<?php echo $name; ?>-color #content input.button,
.woocommerce-page .<?php echo $name; ?>-color #respond input#submit,
.woocommerce-page .<?php echo $name; ?>-color a.button,
.woocommerce-page .<?php echo $name; ?>-color button.button,
.woocommerce-page .<?php echo $name; ?>-color input.button {
	background-color: <?php echo $section['alt_bg']; ?>;
}
    .<?php echo $name; ?>-color.container-wrap.half-section {
    background-color: <?php echo $section['alt_bg']; ?> !important;
    }

.<?php echo $name; ?>-color .dropdown-menu li {
	border-bottom-color: <?php echo $section['alt_bg']; ?>;
}

.<?php echo $name; ?>-color .kleo-rounded img.avatar,

/* Buddypress */
.<?php echo $name; ?>-color .bbp_widget_login .bbp-logged-in .user-submit,
    .buddypress .<?php echo $name; ?>-color #item-header-avatar,
.<?php echo $name; ?>-color #buddypress .activity-list .activity-avatar,
.<?php echo $name; ?>-color .bp-login-widget-user-avatar,
.<?php echo $name; ?>-color #buddypress #friend-list li div.item-avatar,
.<?php echo $name; ?>-color #buddypress #member-list li div.item-avatar,
.<?php echo $name; ?>-color #buddypress #members-list li div.item-avatar,
.<?php echo $name; ?>-color div#message-thread div.message-metadata img.avatar,
.<?php echo $name; ?>-color #buddypress #groups-list .item-avatar,
.<?php echo $name; ?>-color #buddypress .kleo-online-status,
.<?php echo $name; ?>-color .kleo-members-carousel .kleo-online-status,
.<?php echo $name; ?>-color #buddypress form.standard-form div#invite-list div.item-avatar,
.<?php echo $name; ?>-color #buddypress #message-threads .thread-avatar {
	border-color: <?php echo $section['alt_bg']; ?>;
}

.<?php echo $name; ?>-color .masonry-listing .post-footer,
#header.<?php echo $name; ?>-color .navbar-nav li:first-child {
	border-top-color: <?php echo $section['alt_bg']; ?>;
}

/* Buddypress */
.<?php echo $name; ?>-color blockquote,
.<?php echo $name; ?>-color .masonry-listing .post-content {
	border-left-color: <?php echo $section['alt_bg']; ?>;
}

.<?php echo $name; ?>-color .container .pricing-table ul.list-group li:last-child {
	border-bottom-color: <?php echo $section['alt_bg']; ?>;
}



/*** ALTERNATE BORDER COLOR ***/
.<?php echo $name; ?>-color .btn-default,
.<?php echo $name; ?>-color .btn-default:hover,
.<?php echo $name; ?>-color .nav-pills > li.active > a,
.<?php echo $name; ?>-color .nav-pills > li.active > a:hover,
.<?php echo $name; ?>-color .nav-pills > li.active > a:focus,
.<?php echo $name; ?>-color .tabs-style-square > li > a,
.<?php echo $name; ?>-color .nav-tabs > li.active > a,
.<?php echo $name; ?>-color .nav-tabs > li.active > a:hover,
.<?php echo $name; ?>-color .nav-tabs > li.active > a:focus,
.<?php echo $name; ?>-color .panel-default,
.<?php echo $name; ?>-color #wp-calendar thead th,
.<?php echo $name; ?>-color #wp-calendar tbody td,
.<?php echo $name; ?>-color .widget_tag_cloud a,
.<?php echo $name; ?>-color #respond .form-submit input#submit,
.<?php echo $name; ?>-color .mejs-container .mejs-controls,
.<?php echo $name; ?>-color .form-control:focus,
    .<?php echo $name; ?>-color .portfolio-filter-tabs li.selected a,

/* Buddypress */
.<?php echo $name; ?>-color #buddypress div.activity-comments form .ac-textarea,
.<?php echo $name; ?>-color #search-members-form,
.<?php echo $name; ?>-color #search-groups-form,
.<?php echo $name; ?>-color #buddypress .standard-form input[type=text]:focus,

/* bbPress */
.<?php echo $name; ?>-color .bbp-topics ul.sticky,
.<?php echo $name; ?>-color .bbp-submit-wrapper button.button,
.<?php echo $name; ?>-color #bbpress-forums form#bbp-search-form,

/* rtMedia */
.<?php echo $name; ?>-color .rtmedia-container .drag-drop,
.<?php echo $name; ?>-color .rtmedia-activity-container .drag-drop,
.<?php echo $name; ?>-color #buddypress div.rtmedia-activity-container .drag-drop,
.<?php echo $name; ?>-color .rtmedia-container .rtmedia-editor-main dl.tabs dd.active > a,
.<?php echo $name; ?>-color .rtmedia-activity-container .rtmedia-editor-main dl.tabs dd.active > a,
.<?php echo $name; ?>-color #buddypress div.rtmedia-activity-container .rtmedia-editor-main dl.tabs dd.active > a,
.<?php echo $name; ?>-color .rtmedia-container .rtmedia-editor-main dl.tabs dd > a:hover,
.<?php echo $name; ?>-color .rtmedia-activity-container .rtmedia-editor-main dl.tabs dd > a:hover,
.<?php echo $name; ?>-color #buddypress div.rtmedia-activity-container .rtmedia-editor-main dl.tabs dd > a:hover {
	border-color: <?php echo $section['alt_border']; ?>;
}
.<?php echo $name; ?>-color .widget_nav_menu a,
.<?php echo $name; ?>-color .wpex-widget-recent-posts-li,
.<?php echo $name; ?>-color .widget_categories li,
.<?php echo $name; ?>-color .widget_recent_entries li,
.<?php echo $name; ?>-color .widget_archive li,
.<?php echo $name; ?>-color .widget_display_views li,
.<?php echo $name; ?>-color .widget_recent_comments li,
.<?php echo $name; ?>-color .widget_product_categories li,
.<?php echo $name; ?>-color .widget_layered_nav li {
	border-bottom-color: <?php echo $section['alt_border']; ?>;
}
.<?php echo $name; ?>-color .widget_nav_menu li:first-child > a,
.<?php echo $name; ?>-color .kleo-widget-recent-posts-li:first-child,
.<?php echo $name; ?>-color .widget_categories li:first-child,
.<?php echo $name; ?>-color .widget_recent_entries li:first-child,
.<?php echo $name; ?>-color .widget_archive li:first-child,
.<?php echo $name; ?>-color .widget_display_views li:first-child,
.<?php echo $name; ?>-color .widget_recent_comments li:first-child,
.<?php echo $name; ?>-color .widget_product_categories li:first-child,
.<?php echo $name; ?>-color .widget_layered_nav li:first-child,
.<?php echo $name; ?>-color .callout-blockquote blockquote:before {
	border-top-color: <?php echo $section['alt_border']; ?>;
}

.<?php echo $name; ?>-color .callout-blockquote blockquote p:before,

/* Buddypress */
<?php /*?>.<?php echo $name; ?>-color #buddypress div#item-nav ul li a:before,
.<?php echo $name; ?>-color #buddypress div#item-nav .tabdrop .dropdown-menu li a:before,<?php */?>

/* bbPress */
.<?php echo $name; ?>-color .bbp-topics ul.sticky:after,
.<?php echo $name; ?>-color .bbp-forum-content ul.sticky:after,

/* Social Article plugin */
.<?php echo $name; ?>-color .article-content .author-options .edit:before,
.<?php echo $name; ?>-color .article-content .author-options .delete:before {
	color: <?php echo $section['alt_border']; ?>;
}




/*** HIGHLIGHT COLOR ***/
.<?php echo $name; ?>-color .btn-highlight,
.<?php echo $name; ?>-color .btn-highlight:hover,
.<?php echo $name; ?>-color .btn-buy.btn-default,
.<?php echo $name; ?>-color .kleo-pin-icon span i,
.<?php echo $name; ?>-color .pricing-table .popular .panel-heading,
.<?php echo $name; ?>-color .pricing-table .popular .panel-body,
.<?php echo $name; ?>-color .pricing-table .popular .pmpro-price .lead,
.<?php echo $name; ?>-color .pricing-table .popular .extra-description,
.<?php echo $name; ?>-color .pricing-table .popular .panel-heading h3,
.<?php echo $name; ?>-color .kleo-mobile-icons .cart-items span,
.<?php echo $name; ?>-color .ordered-list.colored-icons li:before,
.<?php echo $name; ?>-color .masonry-listing .format-quote,
.<?php echo $name; ?>-color .masonry-listing .format-quote .post-footer a,
.<?php echo $name; ?>-color .masonry-listing .format-quote .post-footer a .muted,
    .<?php echo $name; ?>-color .navbar .nav li a em,
    .<?php echo $name; ?>-color .widget_nav_menu li a em,
    .<?php echo $name; ?>-color .news-highlight .posts-listing .label,

/* Buddypress */
.<?php echo $name; ?>-color #buddypress li span.unread-count,
.<?php echo $name; ?>-color #buddypress #groups-list .item-avatar .member-count,
.<?php echo $name; ?>-color #buddypress div.generic-button a.add,
    .<?php echo $name; ?>-color.bp-full-width-profile div.generic-button a.add,
.<?php echo $name; ?>-color #buddypress div.generic-button a.accept,
.<?php echo $name; ?>-color #buddypress div.generic-button a.join-group,
.<?php echo $name; ?>-color #buddypress div.generic-button a.add:hover,
    .<?php echo $name; ?>-color.bp-full-width-profile div.generic-button a.add:hover,
.<?php echo $name; ?>-color #buddypress div.generic-button a.accept:hover,
.<?php echo $name; ?>-color #buddypress div.generic-button a.join-group:hover,
.<?php echo $name; ?>-color #footer .widget-title,

/* WooCommerce */
.<?php echo $name; ?>-color span.onsale,
.woocommerce .<?php echo $name; ?>-color #content input.button.alt,
.woocommerce .<?php echo $name; ?>-color #respond input#submit.alt,
.woocommerce .<?php echo $name; ?>-color a.button.alt,
.woocommerce .<?php echo $name; ?>-color button.button.alt,
.woocommerce .<?php echo $name; ?>-color input.button.alt,
.woocommerce-page .<?php echo $name; ?>-color #content input.button.alt,
.woocommerce-page .<?php echo $name; ?>-color #respond input#submit.alt,
.woocommerce-page .<?php echo $name; ?>-color a.button.alt,
.woocommerce-page .<?php echo $name; ?>-color button.button.alt,
.woocommerce-page .<?php echo $name; ?>-color input.button.alt,

.woocommerce .<?php echo $name; ?>-color #content input.button.alt:hover,
.woocommerce .<?php echo $name; ?>-color #respond input#submit.alt:hover,
.woocommerce .<?php echo $name; ?>-color a.button.alt:hover,
.woocommerce .<?php echo $name; ?>-color button.button.alt:hover,
.woocommerce .<?php echo $name; ?>-color input.button.alt:hover,
.woocommerce-page .<?php echo $name; ?>-color #content input.button.alt:hover,
.woocommerce-page .<?php echo $name; ?>-color #respond input#submit.alt:hover,
.woocommerce-page .<?php echo $name; ?>-color a.button.alt:hover,
.woocommerce-page .<?php echo $name; ?>-color button.button.alt:hover,
.woocommerce-page .<?php echo $name; ?>-color input.button.alt:hover {
	color: <?php echo $section['high_color']; ?>;
}


/*** HIGHLIGHT BACKGROUND ***/
.<?php echo $name; ?>-color .btn-highlight,
.<?php echo $name; ?>-color .btn-buy.btn-default,
.<?php echo $name; ?>-color .kleo-pin-circle span,
.<?php echo $name; ?>-color .kleo-pin-icon span,
.<?php echo $name; ?>-color #wp-calendar td#today a,
.<?php echo $name; ?>-color .kleo-banner-slider .kleo-banner-prev:hover,
.<?php echo $name; ?>-color .kleo-banner-slider .kleo-banner-next:hover,
.<?php echo $name; ?>-color .carousel-pager a.selected,
.<?php echo $name; ?>-color .pricing-table .popular .panel-heading,
.<?php echo $name; ?>-color .pricing-table .popular .panel-body,
.<?php echo $name; ?>-color .pricing-table .popular .pmpro-price .lead,
.<?php echo $name; ?>-color .pricing-table .popular .extra-description,
.<?php echo $name; ?>-color .mejs-controls .mejs-time-rail .mejs-time-current,
.<?php echo $name; ?>-color .kleo-mobile-icons .cart-items span,
.<?php echo $name; ?>-color .ordered-list.colored-icons li:before,
.<?php echo $name; ?>-color .masonry-listing .format-quote .post-content,
.<?php echo $name; ?>-color .bordered-icons .feature-item:hover .feature-icon,
.<?php echo $name; ?>-color .colored-icons.bordered-icons .feature-item:hover .feature-icon,
    .<?php echo $name; ?>-color .navbar .nav li a em,
    .<?php echo $name; ?>-color .widget_nav_menu li a em,
    .<?php echo $name; ?>-color .news-highlight .posts-listing .label,

/* Buddypress */
.<?php echo $name; ?>-color input[type="radio"]:checked + .radiobox-mark span,
.buddypress .<?php echo $name; ?>-color .kleo-online-status.high-bg,
.<?php echo $name; ?>-color #buddypress div.generic-button a.add,
    .<?php echo $name; ?>-color.bp-full-width-profile div.generic-button a.add,
.<?php echo $name; ?>-color #buddypress div.generic-button a.accept,
.<?php echo $name; ?>-color #buddypress div.generic-button a.join-group,

/* rtMedia */
.<?php echo $name; ?>-color .rtm-primary-button,
.<?php echo $name; ?>-color .rtmedia-container .drag-drop .start-media-upload,
.<?php echo $name; ?>-color .rtmedia-activity-container .drag-drop .start-media-upload,
.<?php echo $name; ?>-color #buddypress .rtmedia-container .rtmedia-uploader .drag-drop .start-media-upload,

/* WooCommerce */
.<?php echo $name; ?>-color span.onsale,
.woocommerce .<?php echo $name; ?>-color #content input.button.alt,
.woocommerce .<?php echo $name; ?>-color #respond input#submit.alt,
.woocommerce .<?php echo $name; ?>-color a.button.alt,
.woocommerce .<?php echo $name; ?>-color button.button.alt,
.woocommerce .<?php echo $name; ?>-color input.button.alt,
.woocommerce-page .<?php echo $name; ?>-color #content input.button.alt,
.woocommerce-page .<?php echo $name; ?>-color #respond input#submit.alt,
.woocommerce-page .<?php echo $name; ?>-color a.button.alt,
.woocommerce-page .<?php echo $name; ?>-color button.button.alt,
.woocommerce-page .<?php echo $name; ?>-color input.button.alt {
	background-color: <?php echo $section['high_bg']; ?>;
}

.<?php echo $name; ?>-color .panel-kleo .panel-title a b,
.<?php echo $name; ?>-color .colored-icons i,
.<?php echo $name; ?>-color .standard-list.colored-icons li:before,
.<?php echo $name; ?>-color .panel-kleo .icon-closed,
.<?php echo $name; ?>-color .colored-icons .feature-item .feature-icon,

/* BuddyPress */
.<?php echo $name; ?>-color #buddypress div#subnav.item-list-tabs ul li a.group-create,

/*bbPress*/
.<?php echo $name; ?>-color a.favorite-toggle:before,
.<?php echo $name; ?>-color a.subscription-toggle:before,
.<?php echo $name; ?>-color .bbp-topics-front ul.super-sticky:after,
.<?php echo $name; ?>-color .bbp-topics ul.super-sticky:after,
.<?php echo $name; ?>-color #bbpress-forums li.bbp-body ul.super-sticky,

    /* WooCommerce */
    .woocommerce .<?php echo $name; ?>-color .star-rating span:before,
    .woocommerce-page .<?php echo $name; ?>-color .star-rating span:before {
	color: <?php echo $section['high_bg']; ?>;
}

.<?php echo $name; ?>-color .btn-highlight,
.<?php echo $name; ?>-color .kleo-pin-poi,
.<?php echo $name; ?>-color .bordered-icons .feature-item:hover .feature-icon,
.<?php echo $name; ?>-color .colored-icons .feature-item:hover .feature-icon,
.<?php echo $name; ?>-color .box-style .bordered-icons .feature-item:hover .feature-icon,
.<?php echo $name; ?>-color .box-style .colored-icons.bordered-icons .feature-item:hover .feature-icon,

/* WooCommerce */
.woocommerce .<?php echo $name; ?>-color #content input.button.alt,
.woocommerce .<?php echo $name; ?>-color #respond input#submit.alt,
.woocommerce .<?php echo $name; ?>-color a.button.alt,
.woocommerce .<?php echo $name; ?>-color button.button.alt,
.woocommerce .<?php echo $name; ?>-color input.button.alt,
.woocommerce-page .<?php echo $name; ?>-color #content input.button.alt,
.woocommerce-page .<?php echo $name; ?>-color #respond input#submit.alt,
.woocommerce-page .<?php echo $name; ?>-color a.button.alt,
.woocommerce-page .<?php echo $name; ?>-color button.button.alt,
.woocommerce-page .<?php echo $name; ?>-color input.button.alt,

/* Buddypress */
.<?php echo $name; ?>-color #buddypress div.generic-button a.add,
    .<?php echo $name; ?>-color.bp-full-width-profile div.generic-button a.add,
.<?php echo $name; ?>-color #buddypress div.generic-button a.accept,
.<?php echo $name; ?>-color #buddypress div.generic-button a.join-group,
.<?php echo $name; ?>-color #buddypress div.generic-button a.add:hover,
    .<?php echo $name; ?>-color.bp-full-width-profile div.generic-button a.add:hover,
.<?php echo $name; ?>-color #buddypress div.generic-button a.accept:hover,
.<?php echo $name; ?>-color #buddypress div.generic-button a.join-group:hover,

/* bbPress */
.<?php echo $name; ?>-color #bbpress-forums li.bbp-body ul.super-sticky {
	border-color: <?php echo $section['high_bg']; ?>;
}

.popover.bottom .arrow,
.popover.bottom .arrow:after,
.<?php echo $name; ?>-color .kleo-tabs .tabs-style-line > li.active > a,
.<?php echo $name; ?>-color .kleo-tabs .tabs-style-line > li.active > a:hover,
.<?php echo $name; ?>-color .kleo-tabs .tabs-style-line > li.active > a:focus,
.<?php echo $name; ?>-color .pricing-table .popular .panel-heading h3 {
	border-bottom-color: <?php echo $section['high_bg']; ?>;
}


<?php if ( $name == 'header' ) { ?>

#main .main-color .<?php echo $name; ?>-color h1,
#main .main-color .<?php echo $name; ?>-color h2,
#main .main-color .<?php echo $name; ?>-color h3,
#main .main-color .<?php echo $name; ?>-color h4,
#main .main-color .<?php echo $name; ?>-color h5,
#main .main-color .<?php echo $name; ?>-color h6 {
    color: <?php echo $section['headings']; ?>;
}

<?php } else { ?>

#main .<?php echo $name; ?>-color h1,
#main .<?php echo $name; ?>-color h2,
#main .<?php echo $name; ?>-color h3,
#main .<?php echo $name; ?>-color h4,
#main .<?php echo $name; ?>-color h5,
#main .<?php echo $name; ?>-color h6 {
    color: <?php echo $section['headings']; ?>;
}

<?php } ?>


/*** FOR DARKER COLORS ***/
.<?php echo $name; ?>-color .btn-default,
.<?php echo $name; ?>-color .btn-default:hover,
.<?php echo $name; ?>-color .panel-default .panel-title a,
.<?php echo $name; ?>-color .panel-kleo .panel-title a,
.<?php echo $name; ?>-color .box-style strong,

#main .<?php echo $name; ?>-color h3 a,
.<?php echo $name; ?>-color .posts-listing .article-title a,
.<?php echo $name; ?>-color .entry-content .post-title a,
.<?php echo $name; ?>-color #respond .form-submit input#submit,
.<?php echo $name; ?>-color .pricing-table .pmpro-price .lead,

/*Buddypress*/
.<?php echo $name; ?>-color #buddypress #friend-list .item-title a,
.<?php echo $name; ?>-color #buddypress #member-list h5 a,
.<?php echo $name; ?>-color #buddypress #members-list .item-title a,
.<?php echo $name; ?>-color #buddypress li.unread div.thread-info a,
.<?php echo $name; ?>-color #buddypress #groups-list .item-title a,
.<?php echo $name; ?>-color .unread-notifications td.notify-text a,

.<?php echo $name; ?>-color #buddypress button:hover,
.<?php echo $name; ?>-color #buddypress a.button:hover,
.<?php echo $name; ?>-color #buddypress a.button:focus,
.<?php echo $name; ?>-color #buddypress input[type=submit]:hover,
.<?php echo $name; ?>-color #buddypress input[type=button]:hover,
.<?php echo $name; ?>-color #buddypress input[type=reset]:hover,
.<?php echo $name; ?>-color #buddypress ul.button-nav li a:hover,
.<?php echo $name; ?>-color #buddypress ul.button-nav li.current a,
.<?php echo $name; ?>-color #buddypress div.generic-button a:hover,
    .<?php echo $name; ?>-color.bp-full-width-profile div.generic-button a:hover,
.<?php echo $name; ?>-color #buddypress .comment-reply-link:hover,
.<?php echo $name; ?>-color #buddypress div.item-list-tabs#subnav ul li.selected a,
.<?php echo $name; ?>-color #buddypress div.item-list-tabs#subnav ul li a:hover,
.<?php echo $name; ?>-color #buddypress div.item-list-tabs li.selected a,
.manage-members .<?php echo $name; ?>-color .member-name,
.manage-members .<?php echo $name; ?>-color .member-name a,

.<?php echo $name; ?>-color #buddypress .standard-form textarea,
.<?php echo $name; ?>-color #buddypress .standard-form input[type=text],
.<?php echo $name; ?>-color #buddypress .standard-form input[type=color],
.<?php echo $name; ?>-color #buddypress .standard-form input[type=date],
.<?php echo $name; ?>-color #buddypress .standard-form input[type=datetime],
.<?php echo $name; ?>-color #buddypress .standard-form input[type=datetime-local],
.<?php echo $name; ?>-color #buddypress .standard-form input[type=email],
.<?php echo $name; ?>-color #buddypress .standard-form input[type=month],
.<?php echo $name; ?>-color #buddypress .standard-form input[type=number],
.<?php echo $name; ?>-color #buddypress .standard-form input[type=range],
.<?php echo $name; ?>-color #buddypress .standard-form input[type=search],
.<?php echo $name; ?>-color #buddypress .standard-form input[type=tel],
.<?php echo $name; ?>-color #buddypress .standard-form input[type=time],
.<?php echo $name; ?>-color #buddypress .standard-form input[type=url],
.<?php echo $name; ?>-color #buddypress .standard-form input[type=week],
.<?php echo $name; ?>-color #buddypress .standard-form select,
.<?php echo $name; ?>-color #buddypress .standard-form input[type=password],
.<?php echo $name; ?>-color #buddypress .dir-search input[type=search],
.<?php echo $name; ?>-color #buddypress .dir-search input[type=text],

/* bbPress */
.<?php echo $name; ?>-color li.bbp-forum-info .bbp-forum-title,
.<?php echo $name; ?>-color ul.topic.sticky .bbp-topic-permalink,
.<?php echo $name; ?>-color a.favorite-toggle,
.<?php echo $name; ?>-color a.subscription-toggle,
.<?php echo $name; ?>-color #bbpress-forums div.bbp-forum-author a.bbp-author-name,
.<?php echo $name; ?>-color #bbpress-forums div.bbp-topic-author a.bbp-author-name,
.<?php echo $name; ?>-color #bbpress-forums div.bbp-reply-author a.bbp-author-name,
.<?php echo $name; ?>-color .bbp-submit-wrapper button.button,
.<?php echo $name; ?>-color #bbpress-forums .bbp-form input[type="text"],
.<?php echo $name; ?>-color .wp-editor-area,

/* rtMedia */
.<?php echo $name; ?>-color .rtmedia-container .rtmedia-editor-main dl.tabs dd.active > a,
.<?php echo $name; ?>-color .rtmedia-activity-container .rtmedia-editor-main dl.tabs dd.active > a,
.<?php echo $name; ?>-color #buddypress div.rtmedia-activity-container .rtmedia-editor-main dl.tabs dd.active > a,
.<?php echo $name; ?>-color .rtmedia-container .rtmedia-editor-main dl.tabs dd > a:hover,
.<?php echo $name; ?>-color .rtmedia-activity-container .rtmedia-editor-main dl.tabs dd > a:hover,
.<?php echo $name; ?>-color #buddypress div.rtmedia-activity-container .rtmedia-editor-main dl.tabs dd > a:hover {
	color: <?php echo $section['heading']; ?>;
}



/*** FOR LIGHTER COLORS ***/
.<?php echo $name; ?>-color .muted,
.<?php echo $name; ?>-color .hr-title,
.<?php echo $name; ?>-color .breadcrumb,
.<?php echo $name; ?>-color .breadcrumb .active,
.<?php echo $name; ?>-color .panel-kleo .icon-closed,
.<?php echo $name; ?>-color .panel-kleo .icon-opened,
.<?php echo $name; ?>-color .pagination > li > a,
.<?php echo $name; ?>-color .pagination > li > span,
.<?php echo $name; ?>-color .post-meta,
.<?php echo $name; ?>-color .post-meta a,
.<?php echo $name; ?>-color .post-footer a,
.<?php echo $name; ?>-color .dropdown-submenu > a:after,
.<?php echo $name; ?>-color .pricing-table .list-group-item.unavailable,
.single-attachment .<?php echo $name; ?>-color .link-list,
.single-attachment .<?php echo $name; ?>-color .link-list a,
.<?php echo $name; ?>-color .form-control,
.<?php echo $name; ?>-color #kleo-ajax-search-loading,
.<?php echo $name; ?>-color .kleo_ajax_entry .search_excerpt,
.<?php echo $name; ?>-color .ajax_search_image,
.<?php echo $name; ?>-color .news-focus .left-thumb-listing .post-date,
.<?php echo $name; ?>-color .news-highlight .left-thumb-listing .post-date,


/* Buddypress */

.<?php echo $name; ?>-color #buddypress div#item-nav .tabdrop .dropdown-menu li a:hover:before,
.<?php echo $name; ?>-color #buddypress .activity-header .time-since,
.<?php echo $name; ?>-color .activity-timeline,

.<?php echo $name; ?>-color #buddypress div#item-nav ul li a:before,
.<?php echo $name; ?>-color #buddypress div#item-nav .tabdrop .dropdown-menu li a:before,

.<?php echo $name; ?>-color #buddypress a.button.fav,
.<?php echo $name; ?>-color #buddypress .comment-reply-link,
.<?php echo $name; ?>-color #rtMedia-queue-list tr td:first-child:before,
.<?php echo $name; ?>-color .sidebar .widget.buddypress div.item-meta,
.<?php echo $name; ?>-color .sidebar .widget.buddypress div.item-content,
.<?php echo $name; ?>-color #buddypress div#item-header div#item-meta,
.<?php echo $name; ?>-color table.notifications td.notify-actions,
.<?php echo $name; ?>-color .read-notifications table.notifications tr td,
.<?php echo $name; ?>-color .unread-notifications table.notifications tr td,
.<?php echo $name; ?>-color #buddypress .activity-list li.load-more a,
.<?php echo $name; ?>-color #buddypress div.item-list-tabs#subnav ul li a,

/* bbPress */
.<?php echo $name; ?>-color .bbp-pagination-links a,
.<?php echo $name; ?>-color .bbp-pagination-links span,

/* rtMedia */
.<?php echo $name; ?>-color .rtmedia-container .rtmedia_next_prev a,
.<?php echo $name; ?>-color .rtmedia-activity-container .rtmedia_next_prev a,
.<?php echo $name; ?>-color #buddypress div.rtmedia-activity-container .rtmedia_next_prev a,
.<?php echo $name; ?>-color .rtmedia-container .rtmedia-editor-main dl.tabs dd > a,
.<?php echo $name; ?>-color .rtmedia-activity-container .rtmedia-editor-main dl.tabs dd > a,
.<?php echo $name; ?>-color #buddypress div.rtmedia-activity-container .rtmedia-editor-main dl.tabs dd > a,

/* WooCommerce */
.woocommerce .<?php echo $name; ?>-color ul.products li.product .price del,
.woocommerce-page .<?php echo $name; ?>-color ul.products li.product .price del,
.<?php echo $name; ?>-color .kleo_ajax_results h4,
.<?php echo $name; ?>-color .kleo-toggle-menu .quick-view,
.<?php echo $name; ?>-color .ajax_not_found,

/* Social Article plugin */
.<?php echo $name; ?>-color .article-content .author-options .edit:hover:before,
.<?php echo $name; ?>-color .article-content .author-options .delete:hover:before {
	color: <?php echo $section['lighter']; ?>;
}

<?php if ( $name == 'header' ) { ?>
    #header.<?php echo $name; ?>-color .form-control::-moz-placeholder,
<?php } ?>

/* Buddypress */
.<?php echo $name; ?>-color #buddypress #whats-new:focus {
	border-color: <?php echo $section['lighter']; ?>;
}
/* Buddypress */
.<?php echo $name; ?>-color  #buddypress #whats-new:focus {
	outline-color: <?php echo $section['lighter']; ?>;
}
/* Buddypress */
.buddypress .<?php echo $name; ?>-color .kleo-online-status,
.<?php echo $name; ?>-color .kleo-members-carousel .kleo-online-status {
	background-color: <?php echo $section['lighter']; ?>;
}


    .<?php echo $name; ?>-color *::-moz-selection {
    background-color: <?php echo $section['high_bg']; ?>;
    color: <?php echo $section['high_color']; ?>;
    }
    .<?php echo $name; ?>-color ::selection {
    background-color: <?php echo $section['high_bg']; ?>;
    color: <?php echo $section['high_color']; ?>;
    }


/*** TRANSPARENCY ***/

/* Background */
.<?php echo $name; ?>-color #bbpress-forums li.bbp-body ul.topic.super-sticky {
 	background-color: rgba(<?php echo $section['high_bg_rgb']['r']; ?>,<?php echo $section['high_bg_rgb']['g']; ?>,<?php echo $section['high_bg_rgb']['b']; ?>, 0.1);
}
.<?php echo $name; ?>-color .btn-highlight:hover,
.<?php echo $name; ?>-color #buddypress div.generic-button a.add:hover,
    .<?php echo $name; ?>-color.bp-full-width-profile div.generic-button a.add:hover,
.<?php echo $name; ?>-color #buddypress div.generic-button a.accept:hover,
.<?php echo $name; ?>-color #buddypress div.generic-button a.join-group:hover,

/* WooCommerce */
.woocommerce .<?php echo $name; ?>-color #content input.button.alt:hover,
.woocommerce .<?php echo $name; ?>-color #respond input#submit.alt:hover,
.woocommerce .<?php echo $name; ?>-color a.button.alt:hover,
.woocommerce .<?php echo $name; ?>-color button.button.alt:hover,
.woocommerce .<?php echo $name; ?>-color input.button.alt:hover,
.woocommerce-page .<?php echo $name; ?>-color #content input.button.alt:hover,
.woocommerce-page .<?php echo $name; ?>-color #respond input#submit.alt:hover,
.woocommerce-page .<?php echo $name; ?>-color a.button.alt:hover,
.woocommerce-page .<?php echo $name; ?>-color button.button.alt:hover,
.woocommerce-page .<?php echo $name; ?>-color input.button.alt:hover {
 	background-color: rgba(<?php echo $section['high_bg_rgb']['r']; ?>,<?php echo $section['high_bg_rgb']['g']; ?>,<?php echo $section['high_bg_rgb']['b']; ?>, 0.7);
}

.<?php echo $name; ?>-color #bbpress-forums li.bbp-body ul.topic.sticky,
.<?php echo $name; ?>-color .navbar-toggle:hover,
.<?php echo $name; ?>-color .navbar-toggle:focus {
 	background-color: rgba(<?php echo $section['alternate_bg_rgb']['r']; ?>,<?php echo $section['alternate_bg_rgb']['g']; ?>,<?php echo $section['alternate_bg_rgb']['b']; ?>, 0.2);
}

.<?php echo $name; ?>-color .btn-primary:hover {
 	background-color: rgba(<?php echo $section['link_color_rgb']['r']; ?>,<?php echo $section['link_color_rgb']['g']; ?>,<?php echo $section['link_color_rgb']['b']; ?>, 0.7);
}

/* Color */
.<?php echo $name; ?>-color .caret:after,
.<?php echo $name; ?>-color .widget_archive li:before,
.<?php echo $name; ?>-color .widget_categories li:before,
.<?php echo $name; ?>-color .widget_product_categories li:before,
.<?php echo $name; ?>-color .widget_layered_nav li:before,
.<?php echo $name; ?>-color .widget_display_views li:before,
.<?php echo $name; ?>-color .widget_recent_entries li:before,
.<?php echo $name; ?>-color .widget_recent_comments li:before,
.<?php echo $name; ?>-color .panel .icon-closed,
.<?php echo $name; ?>-color .panel .icon-opened {
 	color: rgba(<?php echo $section['text_color_rgb']['r']; ?>,<?php echo $section['text_color_rgb']['g']; ?>,<?php echo $section['text_color_rgb']['b']; ?>, 0.5);
}

/* Link Color */
.<?php echo $name; ?>-color .top-menu li > a,
.<?php echo $name; ?>-color #top-social li a {
 	color: rgba(<?php echo $section['link_color_rgb']['r']; ?>,<?php echo $section['link_color_rgb']['g']; ?>,<?php echo $section['link_color_rgb']['b']; ?>, 0.5);
}

/* Border */
.<?php echo $name; ?>-color .btn-see-through {
 	border-color: rgba(<?php echo $section['bg_color_rgb']['r']; ?>,<?php echo $section['bg_color_rgb']['g']; ?>,<?php echo $section['bg_color_rgb']['b']; ?>, 0.2);
}

<?php if ( $name == 'header' && sq_option('top_bar_darker', 1) == 1 ) { ?>
    .<?php echo $name; ?>-color.social-header {
    background-color: <?php echo $section['mat-color-bg']; ?>;
    }
<?php } ?>




/*** SPECIFIC COLORS ***/

.<?php echo $name; ?>-color .activity-list .activity-avatar,
.<?php echo $name; ?>-color .comment-wrap .comment-avatar {
	box-shadow: 0 0 0 13px <?php echo $section['bg']; ?>;
}
.<?php echo $name; ?>-color #search-members-form,
.<?php echo $name; ?>-color #search-groups-form,
.<?php echo $name; ?>-color #bbpress-forums form#bbp-search-form {
	box-shadow: 0 0 0 4px <?php echo $section['alt_bg']; ?>;
}

/* rtMedia */
.<?php echo $name; ?>-color #item-body .rtm-top-notch,
.<?php echo $name; ?>-color #item-body .rtmedia-container.rtmedia-single-container .rtm-like-comments-info:before,
.<?php echo $name; ?>-color #item-body .rtmedia-single-container.rtmedia-activity-container .rtm-like-comments-info:before {
	border-color: rgba(0,0,0,0) rgba(0,0,0,0) <?php echo $section['alt_bg']; ?>;
}

#main .<?php echo $name; ?>-color .panel-info.popular h3 {
	color: <?php echo $section['high_color']; ?>;
}

.<?php echo $name; ?>-color select {
  border-color: <?php echo $section['border']; ?>;
}

.<?php echo $name; ?>-color select {
  color: <?php echo $section['text']; ?>;
}


/*** SPECIFIC FOR MEDIA QUERY ***/
@media (max-width: 991px) {
	.<?php echo $name; ?>-color .navbar-nav li .caret:after {

    color: rgba(<?php echo $section['text_color_rgb']['r']; ?>,<?php echo $section['text_color_rgb']['g']; ?>,<?php echo $section['text_color_rgb']['b']; ?>, 0.2);

    }
}


.<?php echo $name; ?>-color.custom-color .hr-title abbr {
	color: <?php echo $section['lighter']; ?>;
}

.alternate-color .masonry-listing .post-content {
	background-color: #fff;
 }
<?php
$extra_section_css = apply_filters( 'kleo_dynamic_' . $name , '', $section );
if ( $extra_section_css != '' ) {
    echo $extra_section_css;
}

} /* end foreach section */

}
/* Body Background */
echo $kleo_theme->get_bg_css('body_bg', 'body.page-boxed-bg');

/* Sections background */
foreach( $style_sets as $set ) {
	if ( $set == 'header' ) {
		$element = '.' . $set . '-color, .' . $set . '-color .kleo-main-header';
	} else {
		$element = '.' . $set . '-color';
	}
	echo $kleo_theme->get_bg_css( 'st__' . $set . '__bg_image', $element );

    if ( $set == 'main' ) {
        $db_option = sq_option( 'st__' . $set . '__bg_image' );

        if ( isset( $db_option['background-image'] ) && $db_option['background-image'] != '' ) {
            echo '.rounded {color: rgba(0,0,0,0);}';
        }
    }
}

if ( sq_option( 'menu_size', '' ) != '' ) {
  echo '.kleo-main-header .navbar-nav > li > a { font-size: ' . sq_option( 'menu_size', '' ) . 'px; }';
}

if ( sq_option( 'boxed_size', '1440' ) != '1440' ) {
    echo '.page-boxed, .kleo-navbar-fixed .page-boxed .kleo-main-header, .kleo-navbar-fixed.navbar-transparent .page-boxed #header { max-width: ' . sq_option( 'boxed_size' ) . 'px; }';
    echo '.navbar-full-width .page-boxed #main, .navbar-full-width .page-boxed #footer, .navbar-full-width .page-boxed #socket { max-width: ' . sq_option( 'boxed_size' ) . 'px; }';

    if ( sq_option( 'boxed_size', '1440' ) == '1024' ) {
        echo '@media (min-width: 1440px) { .page-boxed .container { max-width: 996px;} }';
    }
    elseif ( sq_option( 'boxed_size', '1440' ) == '1200' ) {
        echo '@media (min-width: 1440px) { .page-boxed .container { max-width: 1170px;} }';
    }
}

//title padding
$title_padding = sq_option('title_padding');
echo '.main-title {padding-top: ' . $title_padding['padding-top'] . '; padding-bottom: ' . $title_padding['padding-bottom'] . ';}';

//header height
echo '.navbar-header, .kleo-main-header .navbar-collapse > ul > li > a, .header-banner{line-height: ' . sq_option( 'menu_height', 88 ) . 'px;}';
echo '.navbar-header {height: ' . sq_option( 'menu_height', 88 ) . 'px;}';

//here you can apply other styles
$extra_output = apply_filters( 'kleo_add_dynamic_style', '' );
echo $extra_output;
?>
