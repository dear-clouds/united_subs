<?php 
/**
 * We get all the style options from the Theme Settings and we inject CSS in the page's header
 *
 * @return string
 */
function woffice_custom_css() {
    echo '<style type="text/css">';
    	
		/*---------------------------------------------------------
		** 
		** MAIN FONTS SETTINGS
		**
		----------------------------------------------------------*/
		$font_main_typography = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('font_main_typography') : ''; 
		$font_headline_typography = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('font_headline_typography') : ''; 
		$font_headline_bold = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('font_headline_bold') : '';
		$font_headline_uppercase = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('font_headline_uppercase') : '';
		$dashboard_headline_uppercase = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('dashboard_headline_uppercase') : '';
		$menu_headline_uppercase = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('menu_headline_uppercase') : '';

		if (!isset($font_main_typography) || !isset($font_headline_typography)) {
	        
	    }
	    echo'body, p, .main-menu li a.fa, h3.mv-addfile-title, #content #eventon_form p label,#content #eventon_form p #evoau_submit, .mv-file-managing,table.mv-editfile th{';
			echo'font-family: '.$font_main_typography['family'].',helvetica, arial, sans-serif; ';
			echo'font-size: '.$font_main_typography['size'].'px;';
		echo'}';
	    echo'h1, h2, h3, h4, h5, h6, #content-container .infobox-head{';
			echo'font-family: '.$font_headline_typography['family'].',helvetica, arial, sans-serif; ';
		echo'}';
		echo'h1, h2, h3, h4, h5, h6{';
			if ($font_headline_uppercase == "yep"):
				echo'text-transform: uppercase;';
  			endif;	
			if ($font_headline_bold == "yep"):
  				echo'font-weight: bold;';
  			endif;
		echo'}';
        echo '#content-container .intern-box.box-title h3{';
            if ($dashboard_headline_uppercase == "yep"):
                echo'text-transform: uppercase;';
            else:
                echo'text-transform: none;';
            endif;
        echo'}';
        if ($menu_headline_uppercase == "yep"):
            echo '.main-menu li > a{';
            echo 'text-transform: uppercase;';
            echo '}';
        endif;
    /*---------------------------------------------------------
    **
    ** MAIN COLORS SETTINGS
    **
    ----------------------------------------------------------*/
		$color_colored 		 = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('color_colored') : ''; 
		$color_text 		 = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('color_text') : ''; 
		$color_main_bg 		 = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('color_main_bg') : '';
        $headline_color = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('color_headline') : '';
        $color_light1 		 = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('color_light1') : '';
		$color_light2 		 = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('color_light2') : ''; 
		$color_light3 		 = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('color_light3') : ''; 
		$color_notifications = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('color_notifications') : ''; 
		$color_notifications_green = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('color_notifications_green') : ''; 
		
		echo'#content-container a,#user-sidebar nav ul li a::before, #content-container .dropcap,.woffice-colored,#page-wrapper .wpcf7-checkbox span.wpcf7-list-item-label:before, #page-wrapper .wpcf7-radio span.wpcf7-list-item-label:before, #right-sidebar a, #content-container .fw-iconbox-image, #main-search form button:hover, #content-container .comment-meta a.url, .special-404, .comment-list .children li:before,#content-container div.item-list-tabs ul li a:hover, #content-container div.item-list-tabs-wiki ul li a:hover,#content-container div.item-list-tabs-project ul li a:hover, #content-container #buddypress div.activity-meta a.button:hover, #activity-filter-select:after, ul.project-meta-list li::before,#content-container #buddypress div.activity-meta a.unfav.bp-secondary-action, #content-container span.mv_user, #content-container .eventon_fc_days .evo_fc_day.has_events, .main-menu ul.sub-menu li.current_page_item a, .wcContainer .wcMessage.wcCurrentUserMessage .wcMessageContent:before, .bbp-reply-post-date i, #main-content #bpfb_addPhotos:before,#main-content #bpfb_addVideos:before, #main-content #bpfb_addLinks:before, .animated-number h1, .woocommerce div.product p.price, .woocommerce div.product span.price, #reviews .star-rating, #woffice-minicart-top a, .woffice-mini-cart-subtotal .amount, span.like.alreadyvoted, #content-container #learndash_lessons a, #content-container #learndash_quizzes a, #content-container .expand_collapse a, #content-container .learndash_topic_dots a, #content-container .learndash_topic_dots a > span, #content-container #learndash_lesson_topics_list span a, #content-container #learndash_profile a, #content-container #learndash_profile a span, .woffice-notifications-item a i.fa.component-icon, #nav-buttons a.clicked, .rtm-lightbox-container a, .box .intern-padding h1 a,.box .intern-padding h2 a,.box .intern-padding h3 a,.box .intern-padding h4 a,.box .intern-padding h5 a,.box .intern-padding h6 a, .box .intern-padding a h1,.box .intern-padding a h2,.box .intern-padding a h3,.box .intern-padding a h4,.box .intern-padding a h5,.box .intern-padding a h6{';
			echo 'color: '.esc_html($color_colored).';';
		echo'}';
		echo'#content-container .list-styled li:before, #nav-cart-trigger.active,#main-content #buddypress div.activity-meta a.button:hover,#content-container .blog-next-page .navigation li.active a{';
			echo 'color: '.esc_html($color_colored).' !important;';
		echo'}';
		echo'.pace .pace-progress, .progress-bar.progress-theme,input[type="submit"], #content-container #buddypress input[type="submit"], #buddypress #create-group-form input[type="button"], #content-container #bbpress-forums button[type="submit"], #right-sidebar .widget .intern-box.box-title::after,#nav-sidebar-trigger:hover,.widget.widget_search button, #content-container .heading::before, .widget_recent_entries .post-date, #content-container div.item-list-tabs#subnav ul li.current a, div.activity-meta a, #main-content #buddypress div.generic-button a, #buddypress .comment-reply-link,a.bp-title-button, .progress-bar, #content-container #buddypress .button-nav li a, #dashboard .widget .box-title::after, #content-container .masonry-layout .box .box-title::after, #content-container #buddypress button, #buddypress ul#members-list li div.item-avatar span.member-role, #content-container .mv-btn-success, #content-container td.publish, #content-container .mv-addfile-wrap a, #content-container .mv-submitfields button, #page-wrapper .wcContainer .wcMessage.wcCurrentUserMessage .wcMessageContent, #content-container #bp-browse-button, .gantt,.gantt-day.weekend span, .bbp-topic-tags a, #content #eventon_form p #evoau_submit, #content-container .mv-btn-success,#content-container td.publish, #content-container .mv-addfile-wrap a,#content-container .mv-submitfields button, #content-container div.item-list-tabs ul li.current a, p.wiki-like.voted, #content-container .badgeos-item-points:before, #learndash_next_prev_link a, #content-container .ssfa_fileup_wrapper span, #buddypress div.pagination .pagination-links span, #buddypress div.pagination .pagination-links a, #rtmedia_create_new_album, #dashboard .widget .box-title h3:before, #dashboard .widget .box-title h3:after, #dashboard .widget.evoFC_Widget h3.widget-title:before, #dashboard .widget.evoFC_Widget h3.widget-title:after,#content-container #buddypress .dataTables_wrapper .dataTables_paginate .paginate_button:not(.disabled){';
			echo 'background-color: '.esc_html($color_colored).';';
		echo'}';
		echo '.gantt::-webkit-scrollbar{';
             echo 'background-color: '.esc_html($color_colored).' !important;';
         echo '}';
		
		/*FIREFOX FIX*/
		echo'#wp-submit,.progress-bar,#page-wrapper .wcContainer .wcMessage.wcCurrentUserMessage .wcMessageContent, input[type="submit"],button[type="submit"],#content-container div.item-list-tabs ul li.selected a, #main-content .bbb-join input[type=submit], .btn.btn-default,#buddypress ul#members-list li div.item-avatar span.member-role, #main-content span.label, #main-content #buddypress a.button, #content-container div.item-list-tabs-project ul li.active a, #main-content #buddypress div.generic-button a, #content-container div.item-list-tabs ul li.selected a, #content-container div.item-list-tabs-wiki ul li.active a, #content-container div.item-list-tabs-project ul li.active a, #content-container div.item-list-tabs ul li.selected a, #content-container div.item-list-tabs-wiki ul li.active a, #content-container div.item-list-tabs ul li.current a, #main-content #buddypress ul.button-nav li a, .woocommerce span.onsale, .woocommerce #content-container #respond input#submit:hover, .woocommerce #content-container a.button:hover, #content-container .woocommerce button.button:hover, .woocommerce #content-container #respond input#submit, .woocommerce #content-container a.button, .woocommerce #content-container button.button, .woocommerce #content-container input.button, #content-container .woocommerce input.button:hover, #main-content input[type="button"], #buddypress input[type=button]:hover, .woocommerce #content-container nav.woocommerce-pagination ul li a, .woocommerce #content-container div.product p.price .amount, #nav-cart-trigger .amount, #content-container .woocommerce a.button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, #right-sidebar .buttons a, .woocommerce .widget_price_filter .ui-slider .ui-slider-handle, .woocommerce .widget_price_filter .ui-slider .ui-slider-range, .woocommerce-shortcode .woocommerce .flex-direction-nav a, .it-exchange-product-price ins{';
			//echo 'background-color: '.esc_html($color_colored).' !important;';
			echo 'background-color: '.esc_html($color_colored).' !important;';
		echo'}';
		
		echo'input:focus,textarea:focus, #content-container div.item-list-tabs ul li.current a span.no-count, #content-container div.item-list-tabs ul li.current a span.count, #content-container div.item-list-tabs ul li.selected a span, #content-container div.item-list-tabs-wiki ul li.active a span, #content-container div.item-list-tabs-project ul li.active a span, #featuredbox.has-search form input:focus, .woffice-task.is-done header label .checkbox-style:before, #woffice-minicart-top, #woffice-notifications-menu, #content-container .ui-state-active, #content-container .ui-widget-content .ui-state-active, #content-container .ui-widget-header .ui-state-active, #content-container .ui-state-hover, #content-container .ui-widget-content .ui-state-hover, #content-container .ui-widget-header .ui-state-hover, #content-container .ui-state-focus, #content-container .ui-widget-content .ui-state-focus, #content-container .ui-widget-header .ui-state-focus{';
			echo'border-color: '.esc_html($color_colored).' !important';
		echo'}';
		echo '.woocommerce #content-container div.product p.price .amount:after, .it-exchange-product-price ins:after{border-right-color:'.esc_html($color_colored).'}'; echo'body, p, .widget.widget_search input[type="text"],#content-container .fw-tabs-container .fw-tabs ul li a, .fw-accordion .fw-accordion-title, #featuredbox.has-search form input, #content-container div.item-list-tabs ul li a, #content-container div.item-list-tabs-wiki ul li a, #content-container div.item-list-tabs-project ul li a, table.profile-fields td.label, #item-header.no-featured, #user-sidebar nav ul li a, #content-container .eventon_fc_days .evo_fc_day:hover, .wcContainer *,legend, a#can-scroll,#navbar #nav-user a#user-thumb, #featuredbox .pagetitle #directory-search form #s, .woffice-notifications-item a, #featuredbox.has-search.search-buddypress form i.fa-spin{';
			echo'color: '.esc_html($color_text).';';
		echo'}';
		echo'#buddypress div#message,#bp-uploader-warning{';
			echo'background-color: '.esc_html($color_text).';';
		echo'}';
		echo'#left-content, #user-sidebar, #main-content{';
			echo'background: '.esc_html($color_main_bg).';';
		echo'}';
        echo'.box .intern-padding h1,.box .intern-padding h2,.box .intern-padding h3,.box .intern-padding h4,.box .intern-padding h5,.box .intern-padding h6{';
        echo 'color: ' . $headline_color .';';
        echo'}';
		echo'#content-container .intern-box, #user-sidebar nav ul li a:hover, .wcContainer .wcMessages .wcMessage .wcMessageContent, #buddypress table.notifications thead tr, #buddypress table.notifications-settings thead tr, #buddypress table.profile-settings thead tr, #buddypress table.profile-fields thead tr, #buddypress table.wp-profile-fields thead tr, #buddypress table.messages-notices thead tr, #buddypress table.forum thead tr, #bbpress-forums li.bbp-header, form .woffice-task .todo-note, #content-container article.content.type-sfwd-quiz .intern-padding.heading-container:after, #content-container article.content.type-sfwd-courses .intern-padding.heading-container:after, #content-container article.content.type-sfwd-lessons .intern-padding.heading-container:after, #content-container article.content.type-sfwd-transactions .intern-padding.heading-container:after, #content-container article.content.type-sfwd-certificates .intern-padding.heading-container:after, #content-container article.content.type-multiverso .intern-padding.heading-container:after, #content-container article.content.type-sfwd-topic .intern-padding.heading-container:after, #buddypress .rtm-media-single-comments, #buddypress .rtmedia-like-info,#buddypress .rtmedia-comments-container, #buddypress .rtm-comment-list li{';
			echo'background: '.esc_html($color_light1).';';
		echo'}';
		
		echo'#user-sidebar nav ul li a,#content-container hr, #content-container .intern-box, #dashboard .widget.evoFC_Widget h3.widget-title, #page-wrapper .wpcf7-checkbox span.wpcf7-list-item-label:before, #page-wrapper .wpcf7-radio span.wpcf7-list-item-label:before, #right-sidebar .widget .intern-padding, #right-sidebar .widget .intern-box.box-title,.main-menu li.menu-item-has-children ul li a, .main-menu li.menu-item-has-mega-menu div.mega-menu ul li a, #navigation-mobile ul li a, .main-menu li.menu-item-has-mega-menu div.mega-menu ul.sub-menu.mega-menu-row:first-child li a,.widget.widget_search input[type="text"], #content-container div.item-list-tabs ul li a, #buddypress div.item-list-tabs ul li:last-child a, #content-container div.item-list-tabs-wiki ul li a, #content-container div.item-list-tabs-project ul li a, #buddypress #item-body form#whats-new-form, #content-container div.item-list-tabs#subnav ul, #buddypress .activity-list li.mini, .ui-autocomplete.ui-front.ui-menu li, #buddypress table.notifications tr td.label, #buddypress table.notifications-settings tr td.label, #buddypress table.profile-fields tr td.label, #buddypress table.wp-profile-fields tr td.label, #buddypress table.messages-notices tr td.label, #buddypress table.forum tr td.label, #content-container .bp_activity #buddypress #item-nav.intern-box, #buddypress div.activity-comments form .ac-textarea, #buddypress ul#groups-list li, #buddypress ul#members-list li, #content-container #item-nav.intern-box.group-header, #content-container div.item-list-tabs-wiki ul li:last-child a,#content-container div.item-list-tabs-project ul li:last-child a, #nav-left, #projects-list li,#project-meta, #project-meta .col-md-4, #content-container #evcal_list .eventon_list_event p.no_events, #content-container .ajde_evcal_calendar .eventon_events_list .eventon_list_event.event, #dashboard .widget .box-title, #content-container .masonry-layout .box .box-title, .wcContainer .wcMessages, .widget.buddypress div.item-options a, .bp-avatar-nav ul.avatar-nav-items li.current, .bp-avatar-nav ul, #bbpress-forums li.bbp-body ul.forum, #bbpress-forums li.bbp-body ul.topic, #bbpress-forums div.bbp-breadcrumb p, #bbpress-forums fieldset.bbp-form, #content #eventon_form, #content #eventon_form .evoau_table .row, #content #eventon_form p input, #content #eventon_form p textarea, #content #eventon_form p.dropdown_row select, #content-container .bbb-join select, #main-content #bbb-join-form.bbb-join, .woffice-task header label .checkbox-style:before, #content-container .badgeos-achievements-list-item, #content-container form .select2-container-multi .select2-choices{';
			echo'border-color: '.esc_html($color_light1).';';
		echo'}';
	    echo '.it-exchange-super-widget .it-exchange-sw-product, .it-exchange-super-widget .it-exchange-sw-processing, .it-exchange-product-price, .it-exchange-super-widget .cart-items-wrapper .cart-item, .it-exchange-super-widget .payment-methods-wrapper, .it-exchange-account .it-exchange-customer-menu, #it-exchange-purchases .it-exchange-purchase, #it-exchange-downloads .it-exchange-download-wrapper {';
            echo'border-color: '.esc_html($color_light1).' !important;';
        echo '}';


		echo '#content-container .bp_members #buddypress #item-nav.intern-box div.item-list-tabs ul li a,#content-container .bp_group #buddypress #item-nav.intern-box div.item-list-tabs ul li a{border-top-color: '.esc_html($color_light1).';border-right-color: '.esc_html($color_light1).';border-bottom-color: '.esc_html($color_light1).';}';
		echo '#buddypress .rtm-like-comments-info:after{border-bottom-color: '.esc_html($color_light1).';}';
		
		echo'.wcContainer .wcMessage .wcMessageContent:before{color: '.esc_html($color_light1).';}';
		
		echo'input, input[type="password"],textarea, #buddypress form#whats-new-form textarea, #content-container .intern-box, .blog-authorbox, pre, #page-wrapper .wpcf7-checkbox span.wpcf7-list-item-label:before, #page-wrapper .wpcf7-radio span.wpcf7-list-item-label:before, #right-sidebar .widget:nth-child(odd), #right-sidebar .widget:nth-child(odd) .intern-box.box-title h3,.widget.widget_search input[type="text"], .fw-accordion .fw-accordion-title, .fw-tabs-container .fw-tabs ul li,#content-container div.item-list-tabs#subnav ul, #buddypress #item-body form#whats-new-form, #buddypress div.activity-comments form .ac-textarea, #buddypress table.notifications tr.alt td, #buddypress table.notifications-settings tr.alt td, #buddypress table.profile-settings tr.alt td, #buddypress table.profile-fields tr.alt td, #buddypress table.wp-profile-fields tr.alt td, #buddypress table.messages-notices tr.alt td, #buddypress table.forum tr.alt td, #buddypress ul#groups-list li div.item-avatar, #buddypress ul#members-list li div.item-avatar, #navbar a:hover, #buddypress ul#activity-stream.item-list li:hover, #project-meta, #content-container #mv_file, #content-container #evcal_list .eventon_list_event p.no_events, #bbpress-forums div.odd, #bbpress-forums ul.odd, #bbpress-forums div.bbp-breadcrumb p, #bbpress-forums li.bbp-header, #bbpress-forums li.bbp-footer, #content #eventon_form .evoau_table .row:hover, #content #eventon_form p input, #content #eventon_form p textarea, #content #eventon_form p.dropdown_row select, #main-content .bpfb_form_container, .woffice-task header, #woffice-add-todo, #content-container #woffice-add-todo .heading > *, .woocommerce #content div.product div.summary, .woocommerce div.product div.summary, .woocommerce-page #content div.product div.summary, .woocommerce-page div.product div.summary, ul.woffice-minicart-top-products li:hover, #buddypress .activity-list li .activity-content, .wiki-like-container p.wiki-like, #content-container #badgeos-achievements-filters-wrap, #content-container .ssfa-meta-container, #content-container .ssfa_fileup_container, #it-exchange-product .it-exchange-product-has-images .it-exchange-product-info{';
			echo'background: '.esc_html($color_light2).';';
		echo'}';
		echo'#buddypress .activity-list .activity-content::before{';
			echo'color: '.$color_light2.';';
		echo'}';
		
		echo'#content-container blockquote, #content-container blockquote::before, #content-container blockquote p, #content-container .comment-meta a,#content-container .item-list-tabs ul li.last:after, #content-container .comment-metadata a, #content-container #buddypress div.activity-meta a.button, #navbar a, .woffice-loader, a.project-head span, #content-container .eventon_fc_days .evo_fc_day,#content-container .ajde_evcal_calendar #evcal_head.calendar_header #evcal_cur, .wcContainer .wcMessage .wcMessageTime, .wp-caption .wp-caption-text, .bbp-pagination-count,#content #evoau_form h3,#evoau_form .label, #content-container a.password-lost, #content-container .gform_wrapper span.gform_description, #signup_form > p,.birthdays-head i,.widget .intern-padding ul.birthdays-list li i, .woffice-task header span.todo-date, .woocommerce .woocommerce-ordering, .woocommerce .woocommerce-result-count, .woocommerce ul.products li.product .price, .woocommerce .woocommerce-product-rating .star-rating, #content-container a.woocommerce-review-link, #content-container .woocommerce-tabs .tabs a, .woocommerce div.product form.cart .variations label, .woocommerce #content-container div.product p.price del .amount, .woffice-mini-cart-price,.woffice-mini-cart-quantity, .woocommerce ul.cart_list li .star-rating, .woocommerce ul.product_list_widget li .star-rating, p.wiki-like span.count, #content-container .masonry-layout .box .directory-item-fields ul .directory-item-field i, .directory-category i, .directory-comments i, .directory-item-fields ul li i, #content-container .list-styled.list-wiki li.sub-category, #content-container .badgeos-required-achievements li::before, .metadatas-footer .post-metadatas, .poll-question-back, .woffice-xprofile-list span i, .woffice-notifications-item a span, .woffice-mini-cart-product-empty:before, .woffice-notification-empty:before, .post-metadatas li i, #content-container form .ui-accordion .ui-accordion-icons, #content-container .blog-shortcode-container h4 span,#content-container .blog-shortcode-container .list-styled.list-arrow li::before{';
			echo'color: '.esc_html($color_light3).';';
		echo'}';
		echo'#right-sidebar .widget .intern-padding ul li::before,#dashboard .widget .intern-padding ul li::before, #content-container .masonry-layout .box ul li::before, #content-container .learndash .notcompleted:after, #content-container #learndash_profile .notcompleted:after, #content-container .learndash .topic-notcompleted span:after, .project-assigned-head i.fa{';
			echo'color: '.esc_html($color_light3).' !important;';
		echo'}';
		echo'#content-container .item-list-tabs ul li.last select, .woocommerce #content-container div.product p.price del .amount:after, input,textarea{';
			echo'border-color: '.esc_html($color_light3).';';
		echo'}';
		
		echo '#user-thumb .notifications, #user-sidebar nav ul li a span.count,#user-sidebar nav ul li a span.no-count, #featuredbox.has-search form button, #featuredbox.has-search form input[type="submit"], #content-container div.item-list-tabs ul li.current a span.no-count, #content-container div.item-list-tabs ul li.current a span.count, #content-container div.item-list-tabs ul li.current a span, #content-container div.item-list-tabs ul li.selected a span, #content-container div.item-list-tabs-wiki ul li.active a span, #content-container div.item-list-tabs-project ul li.active a span, #content-container div.item-list-tabs ul li a span.no-count, #content-container div.item-list-tabs ul li a span.count, #content-container div.item-list-tabs ul li a span, #content-container div.item-list-tabs-wiki ul li a span, #content-container div.item-list-tabs-project ul li a span, #buddypress a.bp-primary-action span, #buddypress #reply-title small a span, #buddypress div#message.error, #content-container div.wpcf7-validation-errors, #buddypress div#message.error:hover, #nav-notification-trigger.active:after, .notification-color{background: '.esc_html($color_notifications). ' !important;}';
		
		echo '#buddypress div#message.updated, #content-container div.wpcf7-mail-sent-ok, #buddypress div#message.updated:hover, #bp-avatar-feedback.updated.success{background: '.esc_html($color_notifications_green). ' !important;}';
		echo '.assigned-tasks-empty i.fa,.woffice-poll-ajax-reply.sent i.fa{color: '.esc_html($color_notifications_green). ' !important;}';
			
		
		/*---------------------------------------------------------
		** 
		** MENU SETTINGS
		**
		----------------------------------------------------------*/
		$menu_background 		    = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('menu_background') : ''; 
		$menu_width 			    = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('menu_width') : ''; 
		$menu_color2 			    = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('menu_color2') : ''; 
		$menu_hover 			    = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('menu_hover') : ''; 
		$menu_width = esc_html($menu_width);
		$menu_background = esc_html($menu_background);
		echo '#navigation{width: '.$menu_width.'px;background: '.$menu_background.';}';
		echo '.main-menu ul.sub-menu li a, .main-menu ul.sub-menu li.current-menu-item a{background: '.$menu_background.'}';
		echo 'body.menu-is-vertical #navigation.navigation-hidden{left: -'.$menu_width.'px;}';
		echo 'body.rtl #navigation.navigation-hidden{left: auto; right: -'.$menu_width.'px;}';
		echo '.main-menu{max-width: '.$menu_width.'px;}';
		echo '.main-menu ul.sub-menu{left: -'.(2*$menu_width).'px;}';
		echo '.main-menu ul.sub-menu.display-submenu,.main-menu .mega-menu.open{left: '.$menu_width.'px;}';
		echo '.main-menu ul.sub-menu li a{width: '.(2*$menu_width).'px;}';
		/*THIRD LEVEL SUPPORT*/
		echo '.main-menu ul.sub-menu.display-submenu ul.sub-menu.display-submenu{left: '.(2*$menu_width).'px;}';
        echo '@media only screen and (min-width: 993px) {';
			echo '.main-menu ul.sub-menu li:hover > .sub-menu {left: '.(2*$menu_width).'px !important;}';
			echo 'body.rtl.menu-is-vertical .main-menu ul.sub-menu li:hover > .sub-menu {left: auto; right: '.(2*$menu_width).'px !important;}';
			echo 'body.rtl .main-menu ul.sub-menu{left auto; right: '.($menu_width).'px !important;}';
			echo 'body.rtl.menu-is-vertical .main-menu ul.sub-menu{left: auto; right: '.($menu_width).'px !important;}';
        echo '}';


		
		echo '.main-menu ul.sub-menu li a:hover,.main-menu li > a:hover, .main-menu li.current-menu-item a, .main-menu li.current_page_item a{ background: '.$menu_hover.';}.main-menu li > a{ border-color: '.esc_html($menu_color2).';}';
		
		// LAYOUT
		echo'#main-header #navbar.navigation-fixed{left: '.$menu_width.'px; padding-right: '.$menu_width.'px;}';
		echo'body.rtl.menu-is-vertical #navbar.navigation-fixed{left: 0; right: '.$menu_width.'px;}';
		echo'#main-content:not(.navigation-hidden), #main-header:not(.navigation-hidden), #main-footer:not(.navigation-hidden){padding-left: '.$menu_width.'px;}';
		echo'body.rtl.menu-is-vertical #main-content:not(.navigation-hidden), body.rtl.menu-is-vertical #main-header:not(.navigation-hidden), body.rtl.menu-is-vertical #main-footer:not(.navigation-hidden){padding-left: 0; padding-right: '.$menu_width.'px;}';

		//MOBILE CHANGES SINCE 1.4.3
		echo '@media only screen and (max-width: 992px) {';
			echo '#navbar.navigation-fixed{left: '.(2*$menu_width).'px;}';
			echo '#navigation{width: '.(2*$menu_width).'px;}';
			echo '.main-menu{max-width: '.(2*$menu_width).'px;}';
			echo'#main-content:not(.navigation-hidden), #main-header:not(.navigation-hidden), #main-footer:not(.navigation-hidden){padding-left: '.(2*$menu_width).'px;}';
			echo 'body.menu-is-vertical #navigation.navigation-hidden{left: -'.(2*$menu_width).'px;}';
            echo 'body.rtl #navigation.navigation-hidden{left: auto; right: -'.(2*$menu_width).'px;}';
			echo '#main-content, #main-header, #main-footer{padding-left: '.(2*$menu_width).'px;}';
		echo '}';
        echo 'body.force-responsive #navbar.navigation-fixed{left: '.(2*$menu_width).'px;}';
        echo 'body.force-responsive #navigation{width: '.(2*$menu_width).'px;}';
        echo 'body.force-responsive .main-menu{max-width: '.(2*$menu_width).'px;}';
        echo'body.force-responsive #main-header:not(.navigation-hidden){padding-left: '.(2*$menu_width).'px;}';
        echo'body.rtl.force-responsive #main-header:not(.navigation-hidden){padding-right: '.(2*$menu_width).'px;}';
        echo 'body.menu-is-vertical.force-responsive #navigation.navigation-hidden{left: -'.(2*$menu_width).'px;}';
        echo 'body.rtl.force-responsive #navigation.navigation-hidden{left: auto; right: -'.(2*$menu_width).'px;}';
		
		/*---------------------------------------------------------
		** 
		** HEADER SETTINGS
		**
		----------------------------------------------------------*/
		$header_height 				= ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('header_height') : ''; 
		$header_logo_bg 			= ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('header_logo_bg') : ''; 
		$header_width 			    = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('header_width') : ''; 
		$header_color 				= ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('header_color') : ''; 
		$header_link 				= ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('header_link') : ''; 
		$header_background 			= ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('header_background') : ''; 
		$header_link_hover 			= ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('header_link_hover') : ''; 
		$header_bold     			= ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('header_bold') : ''; 
		$header_user 				= ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('header_user') : ''; 
		echo'#nav-logo{width: '.esc_html($header_width).'px;}';
		/*Horizontal Menu*/
		$menu_layout = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('menu_layout') : '';
		if ($menu_layout == "horizontal") {
			echo 'body.menu-is-horizontal #navigation{top: '.($header_height +2).'px ;}';
			echo 'body.menu-is-horizontal.admin-bar #navigation{top: '. ($header_height + 32) .'px;}';

            echo '@media only screen and (max-width: 783px) {';
            echo'body.menu-is-horizontal.admin-bar #navigation{top: '. ($header_height + 46) .'px;}';
            echo'}';
		}
		/*End*/
		echo'#navbar{';
			echo'height: '.esc_html($header_height).'px;';
			echo'-webkit-box-shadow: 0 0 10px 1px rgba(0,0,0,.2);';
			echo'-moz-box-shadow: 0 0 10px 1px rgba(0,0,0,.2);';
			echo'-ms-box-shadow: 0 0 10px 1px rgba(0,0,0,.2);';
			echo'-o-box-shadow: 0 0 10px 1px rgba(0,0,0,.2);';
			echo'box-shadow: 0 0 10px 1px rgba(0,0,0,.2);';
		echo'}';
		echo '#navbar.navigation-fixed{height: '.esc_html($header_height).'px;}';
		echo'#navbar{';
			echo'line-height: '.esc_html($header_height).'px;';
			echo'background-color: '.esc_html($header_background).';';
		echo'}';
        echo '#navbar #nav-user a#user-thumb {';
            echo'color: '.esc_html($header_color).';';
        echo '}';
		echo'#nav-left{height: '.esc_html($header_height).'px;}';
		echo'a#nav-trigger, #nav-buttons a{color: '.esc_html($header_link).';}';
		echo'a#nav-trigger:hover,#nav-buttons a:hover {color: '.esc_html($header_link).';}';
		/*Fix for the searchform on mobile - Added in 1.4.2 */
		echo'@media only screen and (max-width: 992px) {#main-search .container{padding-top: '.esc_html($header_height).'px;}}';
		echo'@media only screen and (max-width: 450px) {#navigation{top: '.esc_html($header_height).'px;}.logged-in.admin-bar #navigation{top: '.($header_height + 45).'px;}}';

		/*WE PICK THE COLOR FROM THE MENU (not fair)*/
		echo'#nav-user{';
			echo'color: '.esc_html($menu_background).';';
		echo'}';
		echo'#main-search{';
			echo'background-color: '.esc_html($menu_background).';';
		echo'}';
		/*---------------------------------------------------------
		** 
		** PAGE TITLE SETTINGS
		**
		----------------------------------------------------------*/
		$main_featured_image 		= ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('main_featured_image') : ''; 
		$main_featured_height 		= ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('main_featured_height') : ''; 
		$main_featured_font_size	= ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('main_featured_font_size') : '';
		$main_featured_uppercase 	= ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('main_featured_uppercase') : '';
		$main_featured_color    	= ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('main_featured_color') : ''; 
		$main_featured_opacity		= ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('main_featured_opacity') : ''; 
		$main_featured_bg   		= ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('main_featured_bg') : ''; 
		$main_featured_border		= ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('main_featured_border') : ''; 
		$main_featured_border_color = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('main_featured_border_color') : '';
		$main_featured_alignment    = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('main_featured_alignment') : ''; 
		$main_featured_bold         = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('main_featured_bold') : ''; 
		$main_featured_height = esc_html($main_featured_height);
		if( $main_featured_border == "yep" ) :
  			echo'#featuredbox{';
				echo'border-color: '.esc_html($main_featured_border_color).' !important;';
				echo'border-bottom: 6px solid;';
			echo'}';
		endif; 
		echo'#featuredbox .pagetitle, #featuredbox .pagetitle h1{';
			echo'color: '.$main_featured_color.';';
		echo'}';
		echo'#featuredbox.centered .pagetitle > h1{';
			if( $main_featured_uppercase == true ) :
				echo'text-transform: uppercase;';
            else:
                echo'text-transform: none;';
			endif; 
			echo ( $main_featured_bold == true ) ? 'font-weight: bold;' : 'font-weight: 200;';
			echo ( !empty($main_featured_font_size) ) ? 'font-size: '.$main_featured_font_size.'px;' : 'font-size: 4em;';
		echo'}';
		echo'#featuredbox .pagetitle{';
			echo'height: '.($main_featured_height - 44).'px;';
		echo'}';
		echo'#featuredbox.has-search .featured-background,#featuredbox.has-search .pagetitle{';
			echo'height: '.($main_featured_height + 50).'px;';
		echo'}';
		echo'#featuredbox .featured-background{';
			echo'height: '.$main_featured_height.'px;';
		echo'}';
		echo'.featured-layer{';
			echo'background-color: '.$main_featured_bg.';';
			echo'opacity: '.esc_html($main_featured_opacity).';';
		echo'}';
		echo'#featuredbox .featured-background{';
			echo'background-position: '.$main_featured_alignment.' center;';
		echo'}';
        if( !empty($main_featured_font_size) ) {
            echo '@media only screen and (max-width: 600px) {';
                echo '#featuredbox .pagetitle > h1, #featuredbox.has-search.is-404 .pagetitle > h1, #featuredbox.has-search.search-buddypress .pagetitle > h1 {';
                    echo 'font-size: '.round($main_featured_font_size/2).'px !important;';
                echo '}';
            echo'}';
        }
		/*---------------------------------------------------------
		** 
		** FOOTER & EXTRA FOOTER SETTINGS
		**
		----------------------------------------------------------*/
		$footer_color 				= ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('footer_color') : ''; 
		$footer_link 				= ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('footer_link') : ''; 
		$footer_background 			= ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('footer_background') : ''; 
		$footer_copyright_background= ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('footer_copyright_background') : ''; 
		$footer_border_color		= ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('footer_border_color') : ''; 
		$extrafooter_border_color   = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('extrafooter_border_color') : ''; 
		$footer_copyright_uppercase   = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('footer_copyright_uppercase') : ''; 
		
		echo'#widgets{';
			echo'background-color: '.esc_html($footer_background).';';
			echo'color: '.esc_html($footer_color).';';
		echo'}';
		echo'#copyright{';
			echo'background-color: '.esc_html($footer_copyright_background).';';
			echo'border-color: '.esc_html($footer_border_color).';';
		echo'}';
		echo'#copyright p, #widgets p{';
			echo'color: '.esc_html($footer_color).';';
		echo'}';
		if (!empty($footer_copyright_uppercase)){
			echo'#copyright p{';
				echo'text-transform: uppercase;';
			echo'}';
		}
		echo'#widgets .widget{';
			echo'border-color: '.esc_html($color_text).';';
		echo'}';
		echo'#widgets h3:after, #widgets .widget.widget_search button{';
			echo'background-color: '.esc_html($footer_link).';';
		echo'}';
		echo'#copyright a, #widgets a, #extrafooter-layer h1 span{';
			echo'color: '.esc_html($footer_link).';';
		echo'}';
		echo'#extrafooter{';
			echo'border-color: '.esc_html($extrafooter_border_color).';';
		echo'}';
		/* /!\ NEED CHANGE */
		echo'#widgets .widget{';
			echo'border-color: '.esc_html($color_text).';';
		echo'}';
		echo'#extrafooter-layer{';
			echo'background: rgba(0,0,0,.5);';
		echo'}';
		
		/*---------------------------------------------------------
		** 
		** SIDEBAR SETTINGS
		**
		----------------------------------------------------------*/
		$sidebar_mobile 			= ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('sidebar_mobile') : ''; 
		$sidebar_min 	     		= ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('sidebar_min') : ''; 
		//echo '#right-sidebar{ min-height: '.esc_html($sidebar_min).'px;}';
        echo' @media only screen and (max-width: 992px) {';
            echo'#nav-sidebar-trigger {';
                if( $sidebar_mobile == "yep" )
                    echo "display: table-cell !important;";
                else
                    echo "display: none !important;";
            echo'}}';

		
		
		/*---------------------------------------------------------
		** 
		** DASHBOARD SETTINGS
		**
		----------------------------------------------------------*/
		$dashboard_columns = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('dashboard_columns') : '';
		echo'#dashboard .widget{';
			if (!empty($dashboard_columns)){
				if ($dashboard_columns == '1'){
					echo'width: 98%;';
				}
				elseif ($dashboard_columns == '2'){
					echo'width: 48%;';
				}
				else{
					echo'width: 31.2%;';
				}
			} 
			else {
				echo'width: 31.2%;';
			}
		echo'}';

        /*---------------------------------------------------------
        **
        ** BLOG MASONRY SETTINGS
        **
        ----------------------------------------------------------*/
        $masonry_columns = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('masonry_columns') : '';
        echo'#content-container .masonry-layout .box{';
        if (!empty($masonry_columns)){
            if ($masonry_columns == '1'){
                echo'width: 98%;';
            }
            elseif ($masonry_columns == '2'){
                echo'width: 48%;';
            }
            else{
                echo'width: 31.2%;';
            }
        }
        else {
            echo'width: 31.2%;';
        }
        echo'}';

		/*---------------------------------------------------------
		** 
		** LOGIN PAGE SETTINGS
		**
		----------------------------------------------------------*/
		$login_custom 				= ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('login_custom') : ''; 
		$login_background_color 	= ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('login_background_color') : ''; 
		$login_background_image 	= ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('login_background_image') : ''; 
		$login_background_opacity 	= ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('login_background_opacity') : ''; 
		//$login_logo_image 			= ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('login_logo_image') : '';
		$login_logo_image_width 	= ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('login_logo_image_width') : '';
		//$login_logo_image_height 	= ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('login_logo_image_height') : '';

		if ($login_custom != "nope") : 
			echo'#woffice-login{';
				echo'background-color: '.esc_html($login_background_color).';';
			echo'}';
			
			echo'#woffice-login-left{';
				if (!empty($login_background_image)): 
					echo"background-image: url(".esc_url($login_background_image["url"]).");";
				else :
					echo"background-image: url(".get_template_directory_uri() ."/images/1.jpg);";
				endif;
				echo"background-repeat: no-repeat;";
				echo"
				-webkit-background-size: cover;
				-moz-background-size: cover;
				-o-background-size: cover;
				background-size: cover;";
				echo"background-position: center top;";
				echo"opacity: ".esc_html($login_background_opacity).";";
			echo'}';

			/*if (!empty($login_logo_image)):
				echo "#login-logo{";
					echo "background-image: url(".esc_url($login_logo_image["url"]).");";
					echo "background-size: ".$login_logo_image_width."px ".$login_logo_image_height."px;";
					echo "width: ".esc_html($login_logo_image_width)."px;";
					echo "height: ".esc_html($login_logo_image_height)."px;";
				echo "}";
			endif;*/

            if (!empty($login_logo_image_width)) {
                echo '#login-logo img {';
                echo '  width: ',intval($login_logo_image_width),'px;';
                echo '}';
            }

			
		endif;

		/*---------------------------------------------------------
		** 
		** PAGE LOADING OPTION
		**
		----------------------------------------------------------*/
		$page_loading 				= ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('page_loading') : ''; 
		if ($page_loading == "no") :
			echo ".pace {display: none !important;}";
		endif;

		/*---------------------------------------------------------
		**
		** REMOVE BORDER RADIUS OPTION
		**
		----------------------------------------------------------*/
		$remove_radius 				= ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('remove_radius') : '';
		if ($remove_radius == true) :
			echo "#bp-avatar-feedback.updated.success,#bp-uploader-warning,#buddypress #create-group-form input,#buddypress #item-body form#whats-new-form,#buddypress #item-header-avatar img,#buddypress #message-threads thead tr th:first-child,#buddypress #message-threads thead tr th:last-child,#buddypress #reply-title small a span,#buddypress .activity-avatar img.FB_profile_pic,#buddypress .activity-content,#buddypress .activity-list .activity-content .activity-header img.avatar,#buddypress .activity-list li.mini .activity-avatar img.avatar,#buddypress .comment-reply-link,#buddypress .item-avatar img,#buddypress .item-list-tabs ul li.last select,#buddypress a.bp-primary-action span,#buddypress a.button,#buddypress div#item-header div#item-meta #latest-update p,#buddypress div#item-header ul li a img,#buddypress div#message,#buddypress div#message-thread div.alt,#buddypress div.ac-reply-avatar img,#buddypress div.activity-comments form .ac-textarea,#buddypress div.activity-meta a,#buddypress div.bp-avatar-status p.success,#buddypress div.bp-avatar-status p.warning,#buddypress div.generic-button a,#buddypress div.item-list-tabs#subnav ul,#buddypress div.item-list-tabs#subnav ul li:first-child a,#buddypress div.pagination .pagination-links .page-numbers:first-child,#buddypress div.pagination .pagination-links .page-numbers:last-child,#buddypress li.load-more,#buddypress ul#groups-list li,#buddypress ul#groups-list li div.item-avatar,#buddypress ul#members-list li,#buddypress ul#members-list li div.item-avatar,#buddypress ul#members-list li div.item-avatar span.member-role,#buddypress ul.item-list .activity-comments li img.avatar,#content #buddypress table.profile-fields tr td.data,#content-container #bbpress-forums button,#content-container #bp-browse-button,#content-container #buddypress #members-group-list #member-list li img,#content-container #buddypress .button-nav li a,#content-container #buddypress button.btn-cover-upload,#content-container #buddypress div.activity-meta a.button:first-child,#content-container #buddypress div.activity-meta a.button:last-child,#content-container #buddypress input,#content-container #create-group-form #item-nav,#content-container #groups-directory-form #item-nav,#content-container #learndash_next_prev_link a,
			#content-container .box,#content-container .bp_group #buddypress #item-nav.intern-box div.item-list-tabs ul li a,#content-container .bp_members #buddypress #item-nav.intern-box div.item-list-tabs ul li a,#content-container .infobox,#content-container .intern-box#project-nav,#content-container .intern-box#wiki-nav,#content-container .masonry-layout .box .directory-item-fields,#content-container .masonry-layout .box .intern-padding,#content-container .ssfa_fileup_wrapper span,#content-container article.content.type-multiverso .intern-padding.heading-container:after,#content-container article.content.type-sfwd-certificates .intern-padding.heading-container:after,#content-container article.content.type-sfwd-courses .intern-padding.heading-container:after,#content-container article.content.type-sfwd-lessons .intern-padding.heading-container:after,#content-container article.content.type-sfwd-quiz .intern-padding.heading-container:after,#content-container article.content.type-sfwd-topic .intern-padding.heading-container:after,#content-container article.content.type-sfwd-transactions .intern-padding.heading-container:after,#content-container div.item-list-tabs ul li a span,#content-container div.item-list-tabs ul li a span.count,#content-container div.item-list-tabs ul li a span.no-count,#content-container div.item-list-tabs ul li.current a span,#content-container div.item-list-tabs ul li.current a span.count,#content-container div.item-list-tabs ul li.current a span.no-count,#content-container div.item-list-tabs ul li.selected a span,#content-container div.item-list-tabs-project ul li a span,#content-container div.item-list-tabs-project ul li.active a span,#content-container div.item-list-tabs-wiki ul li a span,#content-container div.item-list-tabs-wiki ul li.active a span,#content-container div.wpcf7-response-output,#dashboard .widget .intern-box,#directory-search form button,#featuredbox.directory-header .pagetitle,#featuredbox.has-search form button,#featuredbox.has-search form input,#item-header,#main-content input,#main-search form input,#map-directory-single,#nav-languages>ul,#nav-languages>ul li:first-child a,#nav-languages>ul li:last-child a,#page-wrapper .btn.btn-default,#user-cover a img,#user-thumb img,#whats-new-avatar a img,#woffice-coverprogressOuter,#woffice-notifications-menu,#woffice-poll-result .woffice-poll-result-answer .progress,.ac-reply-avatar img,.activity-avatar a img,.blog-authorbox,.blog-authorbox img,.comment-list .comment-author.vcard img,.intern-thumbnail,.intern-thumbnail a,.list-members img,.progress.project-progress,.project-members img,.user-map-box img,.widget .intern-padding ul.birthdays-list li img,.widget.buddypress .bp-login-widget-user-avatar,.widget.buddypress div.item-avatar img,.widget.buddypress ul.item-list img.avatar,.widget_woffice_usersmap #members-map-widget,.woffice-notifications-item img,.woffice-task .todo-assigned img,.woffice-task header,.woffice-task header label .checkbox-style:after,.woffice-task header label .checkbox-style:before,.woffice-task.has-note.unfolded header,.wpcf7-checkbox span.wpcf7-list-item-label:before,.wpcf7-radio span.wpcf7-list-item-label:before,a.bp-title-button,body.mce-fullscreen #content .mce-tinymce.mce-panel.mce-fullscreen>.mce-container-body.mce-stack-layout,div.bp-progress,input,textarea,.label,.form-control,#woffice-add-todo,.widget.widget_search button{border-radius:0!important}";
		endif;

		/*---------------------------------------------------------
		** 
		** CUSTOM CSS
		**
		----------------------------------------------------------*/
		$custom_css 				= ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('custom_css') : ''; 

		echo $custom_css;

    echo '</style>';
}
add_action( 'wp_head', 'woffice_custom_css' );

/**
* We output the Custom JS set in the theme setiings in the footer
*
*/
function woffice_custom_js() {
    $custom_js = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('custom_js') : ''; 
    if (!empty($custom_js)){ 
	    echo '<script type="text/javascript">';
	    	echo'jQuery(document).ready(function() {';
				echo $custom_js;
	    	echo'});';
	    echo '</script>';
    }
}
add_action( 'wp_footer', 'woffice_custom_js' );

/**
* Revolution Slider Fix on button trigger. We re-create the RevSlider whenever a button is clicked
*
* @return string
*/
function woffice_revSlider_fix() {
	if (class_exists('RevSliderSlider')) {
	    echo '<script type="text/javascript">';
	    	echo' if (jQuery(".rev_slider").length > 0) {
				jQuery("#nav-trigger, #nav-sidebar-trigger").on("click",function(){
					setTimeout(function () {
						revapi2.revredraw();
			        }, 1000);
				});
			}';
	    echo '</script>';
    }
}
add_action( 'wp_footer', 'woffice_revSlider_fix' );

/**
* Register Fonts.
*
* @return string
*/
function woffice_fonts_url() {
    $fonts_url = '';

    //GET FONTS USED IN THE THEME
	$font_main_typography = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('font_main_typography') : ''; 
	$font_headline_typography = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('font_headline_typography') : ''; 
	$font_extentedlatin = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('font_extentedlatin') : '';

	if($font_extentedlatin == "yep"){
		$subset = "&subset=latin,latin-ext";
	}
	else{
		$subset = "";
	}

	if (!empty($font_main_typography)) {
    	$query_args = "family=".$font_main_typography['family'].":100,200,300,400,400italic,600,700italic,800,900|".$font_headline_typography['family'].":100,200,300,400,400italic,600,700italic,800,900".$subset;

		$fonts_url =  '//fonts.googleapis.com/css?'.preg_replace("/ /","+",$query_args);
 
		return $fonts_url;
	}
}