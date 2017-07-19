<?php 
// Import defaults to database on theme install
// --------------------------------------------------

// Blog Settings
if( !get_option( 'salutation_blog_settings' ) ) {
	update_option(
		'salutation_blog_settings', 
		maybe_unserialize(
			'a:1:{s:12:"blog_setting";a:17:{s:14:"show_post_date";s:1:"1";s:16:"show_author_name";s:1:"1";s:18:"show_author_avatar";s:1:"1";s:18:"show_comments_link";s:1:"1";s:15:"show_categories";s:1:"1";s:9:"show_tags";s:1:"0";s:15:"blog_show_image";s:1:"1";s:15:"post_show_image";s:1:"0";s:16:"post_image_width";s:3:"687";s:17:"post_image_height";s:3:"250";s:16:"use_post_excerpt";s:1:"1";s:14:"excerpt_length";s:2:"50";s:14:"read_more_text";s:12:"Read more...";s:5:"index";s:12:"blog_setting";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:20:"id_sy2lf38zmp04cu884";s:10:"import_key";s:0:"";}}', 
			true
		)
	);
}

// Content Settings
if( !get_option( 'salutation_content_fields' ) ) {
	update_option(
		'salutation_content_fields', 
		maybe_unserialize(
			'a:1:{s:10:"background";a:8:{s:5:"label";s:10:"Background";s:8:"position";s:4:"left";s:5:"index";s:10:"background";s:12:"ancestor_key";s:10:"background";s:11:"version_key";s:20:"id_ro00b1dw8z3g9z4cg";s:10:"import_key";s:0:"";s:6:"fields";a:5:{s:5:"color";a:10:{s:5:"label";s:5:"Color";s:3:"key";s:8:"bg_color";s:4:"slug";s:0:"";s:10:"field_type";s:4:"text";s:6:"values";s:0:"";s:7:"caption";s:162:"Enter the HEX color value for an option background color.<br><a href="http://www.colorpicker.com/" target="_blank">Where can I get the HEX value for my color?</a>";s:5:"index";s:5:"color";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:20:"id_vpour7fsts5t67d8o";s:10:"import_key";s:0:"";}s:5:"image";a:10:{s:5:"label";s:5:"Image";s:3:"key";s:8:"bg_image";s:4:"slug";s:0:"";s:10:"field_type";s:4:"text";s:6:"values";s:0:"";s:7:"caption";s:65:"Enter the full URL of an image to show in your header background.";s:5:"index";s:5:"image";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:20:"id_vuu1b23jvd2r3uc80";s:10:"import_key";s:0:"";}s:25:"image-position-horizontal";a:10:{s:5:"label";s:27:"Image Position (Horizontal)";s:3:"key";s:8:"bg_pos_x";s:4:"slug";s:0:"";s:10:"field_type";s:5:"radio";s:6:"values";s:20:"*Left, Center, Right";s:7:"caption";s:0:"";s:5:"index";s:25:"image-position-horizontal";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:20:"id_g86w06kscqibnfe8s";s:10:"import_key";s:0:"";}s:23:"image-position-vertical";a:10:{s:5:"label";s:25:"Image Position (Vertical)";s:3:"key";s:8:"bg_pos_y";s:4:"slug";s:0:"";s:10:"field_type";s:5:"radio";s:6:"values";s:20:"*Top, Center, Bottom";s:7:"caption";s:0:"";s:5:"index";s:23:"image-position-vertical";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:20:"id_j3rpf70ojd76mbasc";s:10:"import_key";s:0:"";}s:6:"repeat";a:10:{s:5:"label";s:6:"Repeat";s:3:"key";s:9:"bg_repeat";s:4:"slug";s:0:"";s:10:"field_type";s:5:"radio";s:6:"values";s:54:"*No Repeat, Repeat, Repeat Horizontal, Repeat Vertical";s:7:"caption";s:0:"";s:5:"index";s:6:"repeat";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:19:"id_jle9n59uwd48ls88";s:10:"import_key";s:0:"";}}s:10:"post_types";a:1:{i:0;s:12:"static_block";}}}', 
			true
		)
	);
}

// Design Settings
if( !get_option( 'salutation_design_settings' ) ) {
	update_option(
		'salutation_design_settings', 
		maybe_unserialize(
			'a:1:{s:14:"design_setting";a:17:{s:5:"label";s:0:"";s:4:"logo";s:0:"";s:10:"logo_width";s:0:"";s:11:"logo_height";s:0:"";s:4:"skin";s:16:"style-skin-1.css";s:11:"skin_custom";s:0:"";s:7:"sidebar";s:11:"30fs6yk453s";s:10:"css_custom";s:54:".home-page #Middle .contentMargin { margin-top:30px; }";s:9:"js_custom";s:0:"";s:5:"index";s:14:"design_setting";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:20:"id_oyc4b3hbrb28md1yc";s:10:"import_key";s:0:"";s:5:"fonts";a:5:{s:7:"heading";s:14:"cufon:opensans";s:13:"heading_cufon";s:0:"";s:16:"heading_standard";s:0:"";s:4:"body";s:42:"standard:Arial|Helvetica|Garuda|sans-serif";s:11:"body_custom";s:0:"";}s:6:"header";a:5:{s:8:"bg_color";s:0:"";s:10:"background";s:0:"";s:8:"bg_pos_x";s:0:"";s:8:"bg_pos_y";s:0:"";s:9:"bg_repeat";s:9:"no-repeat";}s:6:"footer";a:5:{s:8:"bg_color";s:0:"";s:10:"background";s:0:"";s:8:"bg_pos_x";s:0:"";s:8:"bg_pos_y";s:0:"";s:9:"bg_repeat";s:9:"no-repeat";}s:4:"body";a:5:{s:8:"bg_color";s:0:"";s:10:"background";s:0:"";s:8:"bg_pos_x";s:0:"";s:8:"bg_pos_y";s:0:"";s:9:"bg_repeat";s:9:"no-repeat";}}}', 
			true
		)
	);
}

// Layout Settings
if( !get_option( 'salutation_layout_settings' ) ) {
	update_option(
		'salutation_layout_settings', 
		maybe_unserialize(
			'a:4:{s:12:"page_headers";a:10:{s:11:"7u25rbxjpqk";a:16:{s:3:"key";s:11:"7u25rbxjpqk";s:5:"label";s:14:"Default Header";s:4:"logo";s:0:"";s:11:"top_sidebar";s:0:"";s:7:"content";s:20:"static,header-defaul";s:13:"top_container";s:4:"show";s:8:"bg_color";s:0:"";s:7:"bg_glow";s:4:"show";s:10:"background";s:0:"";s:8:"bg_pos_x";s:1:"0";s:8:"bg_pos_y";s:1:"0";s:9:"bg_repeat";s:9:"no-repeat";s:5:"index";s:11:"7u25rbxjpqk";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:20:"id_ocxep45pxtbs2lig4";s:10:"import_key";s:0:"";}s:12:"4xasu7a7zvy8";a:16:{s:3:"key";s:12:"4xasu7a7zvy8";s:5:"label";s:16:"Home Page Header";s:4:"logo";s:0:"";s:11:"top_sidebar";s:0:"";s:7:"content";s:7:"rs,home";s:13:"top_container";s:4:"show";s:8:"bg_color";s:0:"";s:7:"bg_glow";s:4:"show";s:10:"background";s:0:"";s:8:"bg_pos_x";s:0:"";s:8:"bg_pos_y";s:0:"";s:9:"bg_repeat";s:9:"no-repeat";s:5:"index";s:12:"4xasu7a7zvy8";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:20:"id_kippv2gm6n4uu917o";s:10:"import_key";s:0:"";}s:12:"5okhw6dohsw0";a:16:{s:3:"key";s:12:"5okhw6dohsw0";s:5:"label";s:14:"Minimal Header";s:4:"logo";s:0:"";s:11:"top_sidebar";s:0:"";s:7:"content";s:11:"static,1786";s:13:"top_container";s:4:"show";s:8:"bg_color";s:0:"";s:7:"bg_glow";s:4:"show";s:10:"background";s:0:"";s:8:"bg_pos_x";s:1:"0";s:8:"bg_pos_y";s:1:"0";s:9:"bg_repeat";s:9:"no-repeat";s:5:"index";s:12:"5okhw6dohsw0";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:20:"id_ni43e2lgiw8xp0go4";s:10:"import_key";s:0:"";}s:12:"4crxqekxnoqo";a:16:{s:3:"key";s:12:"4crxqekxnoqo";s:5:"label";s:22:"Title and Social Links";s:4:"logo";s:0:"";s:11:"top_sidebar";s:0:"";s:7:"content";s:36:"static,header-title-and-social-links";s:13:"top_container";s:4:"show";s:8:"bg_color";s:0:"";s:7:"bg_glow";s:4:"show";s:10:"background";s:0:"";s:8:"bg_pos_x";s:1:"0";s:8:"bg_pos_y";s:1:"0";s:9:"bg_repeat";s:9:"no-repeat";s:5:"index";s:12:"4crxqekxnoqo";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:20:"id_ni7q46ex7ts45myo0";s:10:"import_key";s:0:"";}s:12:"4qj4el1akq68";a:16:{s:3:"key";s:12:"4qj4el1akq68";s:5:"label";s:17:"BuddyPress Header";s:4:"logo";s:0:"";s:11:"top_sidebar";s:0:"";s:7:"content";s:25:"static,buddypress-submenu";s:13:"top_container";s:4:"show";s:8:"bg_color";s:0:"";s:7:"bg_glow";s:4:"show";s:10:"background";s:0:"";s:8:"bg_pos_x";s:1:"0";s:8:"bg_pos_y";s:1:"0";s:9:"bg_repeat";s:9:"no-repeat";s:5:"index";s:12:"4qj4el1akq68";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:20:"id_iblix3vqua12m714w";s:10:"import_key";s:0:"";}s:12:"79cc0yraf74s";a:16:{s:3:"key";s:12:"79cc0yraf74s";s:5:"label";s:18:"Graphic Background";s:4:"logo";s:109:"http://para.llel.us/themes/salutation-wp/wp-content/themes/parallelus-salutation/assets/images/logo-white.png";s:11:"top_sidebar";s:0:"";s:7:"content";s:24:"static,graphic-header-bg";s:13:"top_container";s:4:"show";s:8:"bg_color";s:6:"D95B44";s:7:"bg_glow";s:4:"show";s:10:"background";s:0:"";s:8:"bg_pos_x";s:1:"0";s:8:"bg_pos_y";s:1:"0";s:9:"bg_repeat";s:9:"no-repeat";s:5:"index";s:12:"79cc0yraf74s";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:20:"id_lulet5ay3ht8rn1k4";s:10:"import_key";s:0:"";}s:11:"dpy0bghmejc";a:16:{s:3:"key";s:11:"dpy0bghmejc";s:5:"label";s:13:"Slogan at Top";s:4:"logo";s:0:"";s:11:"top_sidebar";s:12:"2mq19af8nskk";s:7:"content";s:21:"static,header-minimal";s:13:"top_container";s:4:"show";s:8:"bg_color";s:0:"";s:7:"bg_glow";s:4:"show";s:10:"background";s:0:"";s:8:"bg_pos_x";s:1:"0";s:8:"bg_pos_y";s:1:"0";s:9:"bg_repeat";s:9:"no-repeat";s:5:"index";s:11:"dpy0bghmejc";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:20:"id_moc1l2v28pfnu0bk0";s:10:"import_key";s:0:"";}s:12:"3jcac3w8l6qs";a:16:{s:3:"key";s:12:"3jcac3w8l6qs";s:5:"label";s:20:"Page with Slide Show";s:4:"logo";s:0:"";s:11:"top_sidebar";s:0:"";s:7:"content";s:16:"rs,sample-header";s:13:"top_container";s:4:"show";s:8:"bg_color";s:0:"";s:7:"bg_glow";s:4:"show";s:10:"background";s:0:"";s:8:"bg_pos_x";s:0:"";s:8:"bg_pos_y";s:0:"";s:9:"bg_repeat";s:9:"no-repeat";s:5:"index";s:12:"3jcac3w8l6qs";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:20:"id_ly05t5a5e7orcg5wc";s:10:"import_key";s:0:"";}s:12:"4xp241aujuw4";a:16:{s:3:"key";s:12:"4xp241aujuw4";s:5:"label";s:19:"Home Page: Sample 1";s:4:"logo";s:0:"";s:11:"top_sidebar";s:0:"";s:7:"content";s:16:"rs,home-page-alt";s:13:"top_container";s:4:"show";s:8:"bg_color";s:0:"";s:7:"bg_glow";s:4:"show";s:10:"background";s:0:"";s:8:"bg_pos_x";s:0:"";s:8:"bg_pos_y";s:0:"";s:9:"bg_repeat";s:9:"no-repeat";s:5:"index";s:12:"4xp241aujuw4";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:20:"id_gzrgb5xa5jrdunxc0";s:10:"import_key";s:0:"";}s:12:"1aualqh214lc";a:16:{s:3:"key";s:12:"1aualqh214lc";s:5:"label";s:4:"Test";s:4:"logo";s:0:"";s:11:"top_sidebar";s:0:"";s:7:"content";s:18:"ss,4-column-sample";s:13:"top_container";s:4:"show";s:8:"bg_color";s:0:"";s:7:"bg_glow";s:4:"show";s:10:"background";s:0:"";s:8:"bg_pos_x";s:1:"0";s:8:"bg_pos_y";s:1:"0";s:9:"bg_repeat";s:9:"no-repeat";s:5:"index";s:12:"1aualqh214lc";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:19:"id_z3fh5x9e3168i0lw";s:10:"import_key";s:0:"";}}s:12:"page_footers";a:2:{s:10:"kxlrirnmsu";a:12:{s:3:"key";s:10:"kxlrirnmsu";s:5:"label";s:14:"Default Footer";s:7:"content";s:14:"footer-default";s:8:"bg_color";s:0:"";s:10:"background";s:0:"";s:8:"bg_pos_x";s:1:"0";s:8:"bg_pos_y";s:1:"0";s:9:"bg_repeat";s:9:"no-repeat";s:5:"index";s:10:"kxlrirnmsu";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:20:"id_pp8as2x2tv1piizwg";s:10:"import_key";s:0:"";}s:12:"551t41z6yps0";a:12:{s:3:"key";s:12:"551t41z6yps0";s:5:"label";s:20:"Alternate Footer - 1";s:7:"content";s:14:"footer-default";s:8:"bg_color";s:0:"";s:10:"background";s:0:"";s:8:"bg_pos_x";s:1:"0";s:8:"bg_pos_y";s:1:"0";s:9:"bg_repeat";s:9:"no-repeat";s:5:"index";s:12:"551t41z6yps0";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:19:"id_ea64ianiz6z755jc";s:10:"import_key";s:0:"";}}s:7:"layouts";a:13:{s:14:"default-layout";a:10:{s:5:"label";s:14:"Default Layout";s:3:"key";s:14:"default-layout";s:6:"header";s:11:"7u25rbxjpqk";s:6:"footer";s:10:"kxlrirnmsu";s:4:"skin";s:0:"";s:5:"index";s:14:"default-layout";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:20:"id_n441n5syz3fb01sow";s:10:"import_key";s:0:"";s:13:"layout_fields";a:1:{s:11:"container_0";a:2:{i:0;a:2:{s:5:"class";s:7:"col-2-3";s:5:"items";a:1:{i:0;a:1:{i:0;a:2:{s:4:"name";s:15:"content-default";s:5:"value";s:7:"default";}}}}i:1;a:2:{s:5:"class";s:7:"col-1-3";s:5:"items";a:1:{i:0;a:1:{i:0;a:2:{s:4:"name";s:7:"sidebar";s:5:"value";s:11:"30fs6yk453s";}}}}}}}s:16:"home-page-layout";a:10:{s:5:"label";s:16:"Home Page Layout";s:3:"key";s:16:"home-page-layout";s:6:"header";s:12:"4xasu7a7zvy8";s:6:"footer";s:10:"kxlrirnmsu";s:4:"skin";s:0:"";s:5:"index";s:16:"home-page-layout";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:20:"id_uzfyl5aret4y6vr40";s:10:"import_key";s:0:"";s:13:"layout_fields";a:2:{s:11:"container_0";a:1:{i:0;a:2:{s:5:"class";s:7:"col-1-1";s:5:"items";a:1:{i:0;a:1:{i:0;a:2:{s:4:"name";s:14:"content-static";s:5:"value";s:18:"home-page-headline";}}}}}s:11:"container_1";a:2:{i:0;a:2:{s:5:"class";s:7:"col-2-3";s:5:"items";a:1:{i:0;a:1:{i:0;a:2:{s:4:"name";s:14:"content-static";s:5:"value";s:4:"2745";}}}}i:1;a:2:{s:5:"class";s:7:"col-1-3";s:5:"items";a:1:{i:0;a:1:{i:0;a:2:{s:4:"name";s:7:"sidebar";s:5:"value";s:12:"34rkyn956ukg";}}}}}}}s:11:"post-layout";a:10:{s:5:"label";s:11:"Post Layout";s:3:"key";s:11:"post-layout";s:6:"header";s:12:"5okhw6dohsw0";s:6:"footer";s:10:"kxlrirnmsu";s:4:"skin";s:0:"";s:5:"index";s:11:"post-layout";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:19:"id_vodl1rf7k45d5pa8";s:10:"import_key";s:0:"";s:13:"layout_fields";a:1:{s:11:"container_0";a:2:{i:0;a:2:{s:5:"class";s:7:"col-2-3";s:5:"items";a:1:{i:0;a:1:{i:0;a:2:{s:4:"name";s:15:"content-default";s:5:"value";s:7:"default";}}}}i:1;a:2:{s:5:"class";s:7:"col-1-3";s:5:"items";a:1:{i:0;a:1:{i:0;a:2:{s:4:"name";s:7:"sidebar";s:5:"value";s:12:"292lzscgo3tw";}}}}}}}s:20:"post-layout-3-column";a:10:{s:5:"label";s:22:"Post Layout - 3 Column";s:3:"key";s:20:"post-layout-3-column";s:6:"header";s:11:"7u25rbxjpqk";s:6:"footer";s:10:"kxlrirnmsu";s:4:"skin";s:0:"";s:5:"index";s:20:"post-layout-3-column";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:20:"id_nk89s4xckaeqysn0g";s:10:"import_key";s:0:"";s:13:"layout_fields";a:1:{s:11:"container_0";a:3:{i:0;a:2:{s:5:"class";s:7:"col-1-4";s:5:"items";a:1:{i:0;a:1:{i:0;a:2:{s:4:"name";s:7:"sidebar";s:5:"value";s:11:"jydt2hxsqa8";}}}}i:1;a:2:{s:5:"class";s:7:"col-1-2";s:5:"items";a:1:{i:0;a:1:{i:0;a:2:{s:4:"name";s:15:"content-default";s:5:"value";s:7:"default";}}}}i:2;a:2:{s:5:"class";s:7:"col-1-4";s:5:"items";a:1:{i:0;a:1:{i:0;a:2:{s:4:"name";s:7:"sidebar";s:5:"value";s:12:"763njvwsm4o4";}}}}}}}s:10:"full-width";a:10:{s:5:"label";s:10:"Full Width";s:3:"key";s:10:"full-width";s:6:"header";s:11:"7u25rbxjpqk";s:6:"footer";s:10:"kxlrirnmsu";s:4:"skin";s:0:"";s:5:"index";s:10:"full-width";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:20:"id_i8e3g33uwtv3hfzk0";s:10:"import_key";s:0:"";s:13:"layout_fields";a:1:{s:11:"container_0";a:1:{i:0;a:2:{s:5:"class";s:7:"col-1-1";s:5:"items";a:1:{i:0;a:1:{i:0;a:2:{s:4:"name";s:15:"content-default";s:5:"value";s:7:"default";}}}}}}}s:6:"search";a:10:{s:5:"label";s:13:"Search Layout";s:3:"key";s:6:"search";s:6:"header";s:12:"5okhw6dohsw0";s:6:"footer";s:10:"kxlrirnmsu";s:4:"skin";s:0:"";s:5:"index";s:6:"search";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:20:"id_j20kk5clnby34wf40";s:10:"import_key";s:0:"";s:13:"layout_fields";a:1:{s:11:"container_0";a:2:{i:0;a:2:{s:5:"class";s:7:"col-2-3";s:5:"items";a:1:{i:0;a:1:{i:0;a:2:{s:4:"name";s:15:"content-default";s:5:"value";s:7:"default";}}}}i:1;a:2:{s:5:"class";s:7:"col-1-3";s:5:"items";a:3:{i:0;a:1:{i:0;a:2:{s:4:"name";s:14:"content-static";s:5:"value";s:12:"search-input";}}i:1;a:1:{i:0;a:2:{s:4:"name";s:7:"divider";s:5:"value";s:8:"standard";}}i:2;a:1:{i:0;a:2:{s:4:"name";s:7:"sidebar";s:5:"value";s:12:"6jrs8ea0i8ow";}}}}}}}s:9:"bp-layout";a:10:{s:5:"label";s:10:"BuddyPress";s:3:"key";s:9:"bp-layout";s:6:"header";s:12:"4qj4el1akq68";s:6:"footer";s:10:"kxlrirnmsu";s:4:"skin";s:0:"";s:5:"index";s:9:"bp-layout";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:20:"id_jodcz3zsibaukgd2c";s:10:"import_key";s:0:"";s:13:"layout_fields";a:1:{s:11:"container_0";a:2:{i:0;a:2:{s:5:"class";s:7:"col-3-4";s:5:"items";a:1:{i:0;a:1:{i:0;a:2:{s:4:"name";s:15:"content-default";s:5:"value";s:7:"default";}}}}i:1;a:2:{s:5:"class";s:7:"col-1-4";s:5:"items";a:1:{i:0;a:1:{i:0;a:2:{s:4:"name";s:7:"sidebar";s:5:"value";s:12:"7j7cgh3hwf8k";}}}}}}}s:17:"page-left-sidebar";a:10:{s:5:"label";s:19:"Page - Left Sidebar";s:3:"key";s:17:"page-left-sidebar";s:6:"header";s:12:"5okhw6dohsw0";s:6:"footer";s:10:"kxlrirnmsu";s:4:"skin";s:0:"";s:5:"index";s:17:"page-left-sidebar";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:20:"id_pxd3p4onmv4wjly4g";s:10:"import_key";s:0:"";s:13:"layout_fields";a:1:{s:11:"container_0";a:2:{i:0;a:2:{s:5:"class";s:7:"col-1-4";s:5:"items";a:1:{i:0;a:1:{i:0;a:2:{s:4:"name";s:7:"sidebar";s:5:"value";s:11:"jydt2hxsqa8";}}}}i:1;a:2:{s:5:"class";s:7:"col-3-4";s:5:"items";a:1:{i:0;a:1:{i:0;a:2:{s:4:"name";s:15:"content-default";s:5:"value";s:7:"default";}}}}}}}s:23:"page-left-sidebar-13-23";a:10:{s:5:"label";s:31:"Page - Left Sidebar (1/3 - 2/3)";s:3:"key";s:23:"page-left-sidebar-13-23";s:6:"header";s:12:"5okhw6dohsw0";s:6:"footer";s:10:"kxlrirnmsu";s:4:"skin";s:0:"";s:5:"index";s:23:"page-left-sidebar-13-23";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:20:"id_sik8i2tqil6lnt0o4";s:10:"import_key";s:0:"";s:13:"layout_fields";a:1:{s:11:"container_0";a:2:{i:0;a:2:{s:5:"class";s:7:"col-1-3";s:5:"items";a:1:{i:0;a:1:{i:0;a:2:{s:4:"name";s:7:"sidebar";s:5:"value";s:11:"jydt2hxsqa8";}}}}i:1;a:2:{s:5:"class";s:7:"col-2-3";s:5:"items";a:1:{i:0;a:1:{i:0;a:2:{s:4:"name";s:15:"content-default";s:5:"value";s:7:"default";}}}}}}}s:18:"page-right-sidebar";a:10:{s:5:"label";s:20:"Page - Right Sidebar";s:3:"key";s:18:"page-right-sidebar";s:6:"header";s:12:"5okhw6dohsw0";s:6:"footer";s:10:"kxlrirnmsu";s:4:"skin";s:0:"";s:5:"index";s:18:"page-right-sidebar";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:20:"id_u9wxq74b03l5hgqo0";s:10:"import_key";s:0:"";s:13:"layout_fields";a:1:{s:11:"container_0";a:2:{i:0;a:2:{s:5:"class";s:7:"col-3-4";s:5:"items";a:1:{i:0;a:1:{i:0;a:2:{s:4:"name";s:15:"content-default";s:5:"value";s:7:"default";}}}}i:1;a:2:{s:5:"class";s:7:"col-1-4";s:5:"items";a:1:{i:0;a:1:{i:0;a:2:{s:4:"name";s:7:"sidebar";s:5:"value";s:11:"jydt2hxsqa8";}}}}}}}s:24:"page-right-sidebar-23-13";a:10:{s:5:"label";s:32:"Page - Right Sidebar (2/3 - 1/3)";s:3:"key";s:24:"page-right-sidebar-23-13";s:6:"header";s:12:"5okhw6dohsw0";s:6:"footer";s:10:"kxlrirnmsu";s:4:"skin";s:0:"";s:5:"index";s:24:"page-right-sidebar-23-13";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:20:"id_sjaig4unqs4wr1ji8";s:10:"import_key";s:0:"";s:13:"layout_fields";a:1:{s:11:"container_0";a:2:{i:0;a:2:{s:5:"class";s:7:"col-2-3";s:5:"items";a:1:{i:0;a:1:{i:0;a:2:{s:4:"name";s:15:"content-default";s:5:"value";s:7:"default";}}}}i:1;a:2:{s:5:"class";s:7:"col-1-3";s:5:"items";a:1:{i:0;a:1:{i:0;a:2:{s:4:"name";s:7:"sidebar";s:5:"value";s:11:"jydt2hxsqa8";}}}}}}}s:24:"post-layout-left-sidebar";a:10:{s:5:"label";s:26:"Post Layout - Left Sidebar";s:3:"key";s:24:"post-layout-left-sidebar";s:6:"header";s:12:"5okhw6dohsw0";s:6:"footer";s:10:"kxlrirnmsu";s:4:"skin";s:0:"";s:5:"index";s:24:"post-layout-left-sidebar";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:20:"id_r4azr323ug2pu1t2c";s:10:"import_key";s:0:"";s:13:"layout_fields";a:1:{s:11:"container_0";a:2:{i:0;a:2:{s:5:"class";s:7:"col-1-3";s:5:"items";a:1:{i:0;a:1:{i:0;a:2:{s:4:"name";s:7:"sidebar";s:5:"value";s:12:"292lzscgo3tw";}}}}i:1;a:2:{s:5:"class";s:7:"col-2-3";s:5:"items";a:1:{i:0;a:1:{i:0;a:2:{s:4:"name";s:15:"content-default";s:5:"value";s:7:"default";}}}}}}}s:23:"home-page-design-agency";a:10:{s:5:"label";s:24:"Home Page: Design Agency";s:3:"key";s:23:"home-page-design-agency";s:6:"header";s:12:"4xp241aujuw4";s:6:"footer";s:12:"551t41z6yps0";s:4:"skin";s:0:"";s:5:"index";s:23:"home-page-design-agency";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:20:"id_mdo451zrc9yaif7wg";s:10:"import_key";s:0:"";s:13:"layout_fields";a:1:{s:11:"container_0";a:1:{i:0;a:2:{s:5:"class";s:7:"col-1-1";s:5:"items";a:1:{i:0;a:1:{i:0;a:2:{s:4:"name";s:15:"content-default";s:5:"value";s:7:"default";}}}}}}}}s:15:"layout_settings";a:5:{s:5:"index";s:15:"layout_settings";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:20:"id_r7o5o3k8640k5g8kk";s:10:"import_key";s:0:"";s:6:"layout";a:23:{s:6:"header";s:11:"7u25rbxjpqk";s:6:"footer";s:10:"kxlrirnmsu";s:7:"default";s:14:"default-layout";s:4:"home";s:16:"home-page-layout";s:4:"page";s:18:"page-right-sidebar";s:4:"post";s:11:"post-layout";s:4:"blog";s:11:"post-layout";s:8:"category";s:0:"";s:6:"author";s:0:"";s:3:"tag";s:0:"";s:4:"date";s:0:"";s:6:"search";s:6:"search";s:5:"error";s:10:"full-width";s:2:"bp";s:9:"bp-layout";s:11:"bp-activity";s:0:"";s:8:"bp-blogs";s:0:"";s:9:"bp-forums";s:0:"";s:9:"bp-groups";s:0:"";s:16:"bp-groups-single";s:0:"";s:24:"bp-groups-single-plugins";s:0:"";s:10:"bp-members";s:0:"";s:17:"bp-members-single";s:0:"";s:25:"bp-members-single-plugins";s:0:"";}}}', 
			true
		)
	);
}

// Sidebar Settings
if( !get_option( 'salutation_sidebar_settings' ) ) {
	update_option(
		'salutation_sidebar_settings', 
		maybe_unserialize(
			'a:2:{s:8:"sidebars";a:10:{s:11:"30fs6yk453s";a:7:{s:5:"label";s:7:"Default";s:5:"alias";s:7:"default";s:3:"key";s:11:"30fs6yk453s";s:5:"index";s:11:"30fs6yk453s";s:12:"ancestor_key";s:8:"sidebars";s:11:"version_key";s:19:"id_jqmkpz2s4egebc2s";s:10:"import_key";s:0:"";}s:12:"34rkyn956ukg";a:7:{s:5:"label";s:9:"Home Page";s:5:"alias";s:9:"home-page";s:3:"key";s:12:"34rkyn956ukg";s:5:"index";s:12:"34rkyn956ukg";s:12:"ancestor_key";s:8:"sidebars";s:11:"version_key";s:20:"id_pttct1buesuesfikg";s:10:"import_key";s:0:"";}s:12:"292lzscgo3tw";a:7:{s:5:"label";s:4:"Post";s:5:"alias";s:12:"post-sidebar";s:3:"key";s:12:"292lzscgo3tw";s:5:"index";s:12:"292lzscgo3tw";s:12:"ancestor_key";s:8:"sidebars";s:11:"version_key";s:20:"id_ke5vy3wurnmct8mas";s:10:"import_key";s:0:"";}s:11:"jydt2hxsqa8";a:7:{s:5:"label";s:4:"Page";s:5:"alias";s:12:"default-page";s:3:"key";s:11:"jydt2hxsqa8";s:5:"index";s:11:"jydt2hxsqa8";s:12:"ancestor_key";s:8:"sidebars";s:11:"version_key";s:20:"id_sqxuf6qtnwcctdd0k";s:10:"import_key";s:0:"";}s:12:"6jrs8ea0i8ow";a:7:{s:5:"label";s:14:"Search Results";s:5:"alias";s:14:"search-results";s:3:"key";s:12:"6jrs8ea0i8ow";s:5:"index";s:12:"6jrs8ea0i8ow";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:20:"id_shhvk2lte6sg3f0ow";s:10:"import_key";s:0:"";}s:12:"2mq19af8nskk";a:7:{s:5:"label";s:13:"Header Slogan";s:5:"alias";s:13:"header-slogan";s:3:"key";s:12:"2mq19af8nskk";s:5:"index";s:12:"2mq19af8nskk";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:19:"id_kv2dlq5tg7dvwkrk";s:10:"import_key";s:0:"";}s:12:"7j7cgh3hwf8k";a:7:{s:5:"label";s:10:"BuddyPress";s:5:"alias";s:10:"buddypress";s:3:"key";s:12:"7j7cgh3hwf8k";s:5:"index";s:12:"7j7cgh3hwf8k";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:20:"id_exmow1jd73bedmpy8";s:10:"import_key";s:0:"";}s:12:"4tf9mzr8hxk4";a:7:{s:5:"label";s:19:"2 Column Nav - Left";s:5:"alias";s:17:"2-column-nav-left";s:3:"key";s:12:"4tf9mzr8hxk4";s:5:"index";s:12:"4tf9mzr8hxk4";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:19:"id_u5j2o68q2u272uvc";s:10:"import_key";s:0:"";}s:12:"6luwhkhtiask";a:7:{s:5:"label";s:20:"2 Column Nav - Right";s:5:"alias";s:18:"2-column-nav-right";s:3:"key";s:12:"6luwhkhtiask";s:5:"index";s:12:"6luwhkhtiask";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:20:"id_e85s9221d0jgnifwk";s:10:"import_key";s:0:"";}s:12:"763njvwsm4o4";a:7:{s:5:"label";s:13:"Extra Sidebar";s:5:"alias";s:13:"extra-sidebar";s:3:"key";s:12:"763njvwsm4o4";s:5:"index";s:12:"763njvwsm4o4";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:20:"id_h6dxf4kk593au7ukg";s:10:"import_key";s:0:"";}}s:4:"tabs";a:2:{s:12:"4e4od16scosg";a:10:{s:5:"label";s:7:"SIGN IN";s:5:"class";s:12:"sign-in-icon";s:10:"conditions";s:27:"-function-is-user-logged-in";s:8:"bg_color";s:0:"";s:5:"alias";s:12:"4e4od16scosg";s:3:"key";s:12:"4e4od16scosg";s:5:"index";s:12:"4e4od16scosg";s:12:"ancestor_key";s:4:"tabs";s:11:"version_key";s:20:"id_nv5e54o7oz6kkyqyo";s:10:"import_key";s:0:"";}s:12:"4lct468lzl6o";a:10:{s:5:"label";s:8:"REGISTER";s:5:"class";s:11:"primary-tab";s:10:"conditions";s:27:"-function-is-user-logged-in";s:8:"bg_color";s:0:"";s:5:"alias";s:12:"4lct468lzl6o";s:3:"key";s:12:"4lct468lzl6o";s:5:"index";s:12:"4lct468lzl6o";s:12:"ancestor_key";s:4:"tabs";s:11:"version_key";s:20:"id_gfoha5az771bzvmkg";s:10:"import_key";s:0:"";}}}', 
			true
		)
	);
}

// Slideshow Settings
if( !get_option( 'salutation_slideshow_settings' ) ) {
	update_option(
		'salutation_slideshow_settings', 
		maybe_unserialize(
			'a:1:{s:10:"slideshows";a:2:{s:7:"default";a:14:{s:5:"label";s:17:"Default Slideshow";s:3:"key";s:7:"default";s:5:"width";s:3:"972";s:6:"height";s:3:"325";s:6:"timing";s:1:"6";s:10:"transition";s:4:"fade";s:5:"speed";s:0:"";s:14:"pause_on_hover";s:1:"0";s:7:"columns";s:1:"1";s:5:"index";s:7:"default";s:12:"ancestor_key";s:10:"slideshows";s:11:"version_key";s:20:"id_eh2eg55rxitcntjc4";s:10:"import_key";s:0:"";s:8:"slides_1";a:5:{s:12:"2w0q2892v0ow";a:12:{s:3:"key";s:12:"2w0q2892v0ow";s:5:"media";s:82:"wp-content/themes/parallelus-salutation/assets/images/slideshow/sample-slide-1.jpg";s:4:"link";s:0:"";s:12:"target_blank";s:1:"0";s:6:"format";s:5:"image";s:8:"position";s:4:"left";s:10:"transition";s:0:"";s:7:"content";s:0:"";s:5:"index";s:12:"2w0q2892v0ow";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:20:"id_ghv6v5ud6jfkfou80";s:10:"import_key";s:0:"";}s:12:"7ijs7k2n5lkw";a:12:{s:3:"key";s:12:"7ijs7k2n5lkw";s:5:"media";s:82:"wp-content/themes/parallelus-salutation/assets/images/slideshow/sample-slide-2.jpg";s:4:"link";s:0:"";s:12:"target_blank";s:1:"0";s:6:"format";s:5:"image";s:8:"position";s:4:"left";s:10:"transition";s:0:"";s:7:"content";s:0:"";s:5:"index";s:12:"7ijs7k2n5lkw";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:20:"id_plf0u5nw1e0j7j74s";s:10:"import_key";s:0:"";}s:12:"2yquppg4mxs0";a:12:{s:3:"key";s:12:"2yquppg4mxs0";s:5:"media";s:82:"wp-content/themes/parallelus-salutation/assets/images/slideshow/sample-slide-3.jpg";s:4:"link";s:0:"";s:12:"target_blank";s:1:"0";s:6:"format";s:5:"image";s:8:"position";s:4:"left";s:10:"transition";s:0:"";s:7:"content";s:0:"";s:5:"index";s:12:"2yquppg4mxs0";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:20:"id_mw4972cbza4qznow0";s:10:"import_key";s:0:"";}s:11:"r2qg0duab2o";a:12:{s:3:"key";s:11:"r2qg0duab2o";s:5:"media";s:82:"wp-content/themes/parallelus-salutation/assets/images/slideshow/sample-slide-4.jpg";s:4:"link";s:0:"";s:12:"target_blank";s:1:"0";s:6:"format";s:5:"image";s:8:"position";s:4:"left";s:10:"transition";s:0:"";s:7:"content";s:0:"";s:5:"index";s:11:"r2qg0duab2o";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:20:"id_kq5dn1mtcly16zt7o";s:10:"import_key";s:0:"";}s:12:"5qgwee4ei8co";a:12:{s:3:"key";s:12:"5qgwee4ei8co";s:5:"media";s:82:"wp-content/themes/parallelus-salutation/assets/images/slideshow/sample-slide-5.jpg";s:4:"link";s:0:"";s:12:"target_blank";s:1:"0";s:6:"format";s:5:"image";s:8:"position";s:4:"left";s:10:"transition";s:0:"";s:7:"content";s:0:"";s:5:"index";s:12:"5qgwee4ei8co";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:20:"id_kdt5u4xzzxfnkuf8k";s:10:"import_key";s:0:"";}}}s:6:"sample";a:14:{s:5:"label";s:6:"Sample";s:3:"key";s:6:"sample";s:5:"width";s:0:"";s:6:"height";s:0:"";s:6:"timing";s:1:"3";s:10:"transition";s:10:"scrollHorz";s:5:"speed";s:4:"1250";s:14:"pause_on_hover";s:1:"0";s:7:"columns";s:1:"1";s:5:"index";s:6:"sample";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:20:"id_f0jfk55o8lgqa18ws";s:10:"import_key";s:0:"";s:8:"slides_1";a:3:{s:12:"2o6545nt6csg";a:12:{s:3:"key";s:12:"2o6545nt6csg";s:5:"media";s:87:"http://para.llel.us/themes/salutation-wp/wp-content/uploads/2011/09/shortcode-ss-11.jpg";s:4:"link";s:0:"";s:12:"target_blank";s:1:"0";s:6:"format";s:5:"image";s:8:"position";s:4:"left";s:10:"transition";s:0:"";s:7:"content";s:0:"";s:5:"index";s:12:"2o6545nt6csg";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:19:"id_i178l8stsmc5xct4";s:10:"import_key";s:0:"";}s:12:"7gw6lm9f2sg0";a:12:{s:3:"key";s:12:"7gw6lm9f2sg0";s:5:"media";s:87:"http://para.llel.us/themes/salutation-wp/wp-content/uploads/2011/09/shortcode-ss-31.jpg";s:4:"link";s:0:"";s:12:"target_blank";s:1:"0";s:6:"format";s:5:"image";s:8:"position";s:4:"left";s:10:"transition";s:0:"";s:7:"content";s:0:"";s:5:"index";s:12:"7gw6lm9f2sg0";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:20:"id_hoxmt1gfhuohb1ce8";s:10:"import_key";s:0:"";}s:11:"ldebh1gflmo";a:12:{s:3:"key";s:11:"ldebh1gflmo";s:5:"media";s:87:"http://para.llel.us/themes/salutation-wp/wp-content/uploads/2011/09/shortcode-ss-21.jpg";s:4:"link";s:0:"";s:12:"target_blank";s:1:"0";s:6:"format";s:5:"image";s:8:"position";s:4:"left";s:10:"transition";s:0:"";s:7:"content";s:0:"";s:5:"index";s:11:"ldebh1gflmo";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:20:"id_imefs3jtmwviqkzs4";s:10:"import_key";s:0:"";}}}}}', 
			true
		)
	);
}

// Theme Settings
if( !get_option( 'salutation_theme_settings' ) ) {
	update_option(
		'salutation_theme_settings', 
		maybe_unserialize(
			'a:1:{s:7:"options";a:30:{s:15:"fade_in_content";s:3:"all";s:9:"tool_tips";s:5:"class";s:14:"favorites_icon";s:31:"http://para.llel.us/favicon.ico";s:16:"apple_touch_icon";s:41:"http://para.llel.us/apple-itouch-icon.png";s:15:"append_to_title";s:0:"";s:18:"placeholder_images";s:1:"1";s:18:"custom_placeholder";s:0:"";s:8:"404_page";s:4:"1708";s:16:"google_analytics";s:0:"";s:7:"wpautop";s:1:"1";s:21:"access_theme_settings";s:0:"";s:19:"access_theme_design";s:13:"administrator";s:23:"developer_custom_fields";s:1:"0";s:30:"developer_custom_content_types";s:0:"";s:27:"developer_custom_taxonomies";s:0:"";s:30:"developer_custom_fields_access";s:13:"administrator";s:37:"developer_custom_content_types_access";s:0:"";s:34:"developer_custom_taxonomies_access";s:0:"";s:19:"branding_admin_logo";s:0:"";s:26:"branding_admin_header_logo";s:0:"";s:29:"branding_admin_help_tab_title";s:0:"";s:31:"branding_admin_help_tab_content";s:0:"";s:40:"branding_admin_custom_right_column_title";s:0:"";s:34:"branding_admin_custom_right_column";s:0:"";s:42:"branding_admin_right_column_theme_settings";s:1:"1";s:43:"branding_admin_right_column_design_settings";s:1:"1";s:5:"index";s:7:"options";s:12:"ancestor_key";s:0:"";s:11:"version_key";s:20:"id_qqs7f6kpb7dom108w";s:10:"import_key";s:0:"";}}', 
			true
		)
	);
}



# ================================================
# Version 2 upgrade, fix for child theme data
# ------------------------------------------------
# In version 2 there was a change in the naming of a core theme variable which was causing child themes to save data under the parent  
# theme name in the WP '_options' DB table so it was not possible to have different data for child themes. This is fixed, but now
# when you update an existing theme you may appear to lose all your child theme settings. To fix this we are copying all the data from 
# the default Salutation parent theme DB fields to the child theme (if exists) which will allow a seemless upgrade and also provide the
# default theme data for all future created child themes.
# ================================================

// Populate the child theme options from the parent theme data

if (is_child_theme()) {

	// The list of option rows for the theme
	$theme_options_rows = array(
			'blog_settings',
			'contact_form_settings',
			'content_fields',
			'design_settings',
			'layout_settings',
			'sidebar_settings',
			'slideshow_settings',
			'theme_settings'
		);

	// Loop through all the tables and populate the data if they don't exist
	foreach ($theme_options_rows as $option_row) {
		if( !get_option( $shortname . $option_row ) ) {
			update_option(
				$shortname . $option_row, 
				get_option( 'salutation_'.$option_row )
			);
		}
	}

}


# ================================================
# Check for existiong "bp-custom.php" 
# ================================================

if (bp_plugin_is_active()) {
	
	if (!file_exists(WP_PLUGIN_DIR . '/bp-custom.php')) {
		// if there isn't one we will move the example file and rename it (this is for thumbnail size settings)
		if (!copy(dirname(__FILE__).'/example-bp-custom.php', WP_PLUGIN_DIR . '/bp-custom.php')) {
			// This would be the place for an error message...
		}
	}
}






# ================================================
# Import demo slide show (Slider Revolution)
# ================================================

function importDemoSlider(){
	global $wpdb, $shortname;

	$charset_collate = (isset($charset_collate) && !empty($charset_collate))? $charset_collate : "DEFAULT CHARACTER SET ".$wpdb->charset.' COLLATE '.$wpdb->collate;
	
	// Make sure the DB tables exist
	// --------------------------------------------------
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	$RevSlider_sql = "CREATE TABLE IF NOT EXISTS ". $wpdb->prefix ."revslider_sliders (
				  id int(9) NOT NULL AUTO_INCREMENT,
				  title tinytext NOT NULL,
				  alias tinytext,
				  params text NOT NULL,
				  PRIMARY KEY (id)
				)$charset_collate;";
	dbDelta($RevSlider_sql);

	$Slides_sql = "CREATE TABLE IF NOT EXISTS ". $wpdb->prefix ."revslider_slides (
				  id int(9) NOT NULL AUTO_INCREMENT,
				  slider_id int(9) NOT NULL,
				  slide_order int not NULL,		  
				  params text NOT NULL,
				  layers text NOT NULL,
				  PRIMARY KEY (id)
				)$charset_collate;";
	dbDelta($Slides_sql);


	// ==================================================
	// Add default Slide Show
	// ==================================================
	$rev_slider = array();
	$rev_slider["title"]  = 'Home Page';
	$rev_slider["alias"]  = 'home';
	$rev_slider["params"] = '{"title":"Home Page","alias":"home","shortcode":"[rev_slider home]","slider_type":"fullwidth","fullscreen_offset_container":"","width":"972","height":"360","responsitive_w1":"940","responsitive_sw1":"770","responsitive_w2":"780","responsitive_sw2":"500","responsitive_w3":"510","responsitive_sw3":"310","responsitive_w4":"","responsitive_sw4":"","responsitive_w5":"","responsitive_sw5":"","responsitive_w6":"","responsitive_sw6":"","delay":"6000","shuffle":"off","lazy_load":"off","use_wpml":"off","load_googlefont":"false","google_font":"PT+Sans+Narrow:400,700","stop_slider":"off","stop_after_loops":"0","stop_at_slide":"2","position":"center","margin_top":"0","margin_bottom":"0","margin_left":"0","margin_right":"0","shadow_type":"0","show_timerbar":"hide","background_color":"#3F4249","padding":"0","show_background_image":"false","background_image":"","touchenabled":"on","stop_on_hover":"on","navigaion_type":"bullet","navigation_arrows":"solo","navigation_style":"round","navigaion_always_on":"false","hide_thumbs":"200","navigaion_align_hor":"center","navigaion_align_vert":"bottom","navigaion_offset_hor":"0","navigaion_offset_vert":"20","leftarrow_align_hor":"left","leftarrow_align_vert":"center","leftarrow_offset_hor":"20","leftarrow_offset_vert":"0","rightarrow_align_hor":"right","rightarrow_align_vert":"center","rightarrow_offset_hor":"20","rightarrow_offset_vert":"0","thumb_width":"100","thumb_height":"50","thumb_amount":"5","hide_slider_under":"0","hide_defined_layers_under":"0","hide_all_layers_under":"0","start_with_slide":"1","first_transition_type":"fade","first_transition_duration":"300","first_transition_slot_amount":"7","jquery_noconflict":"on","js_to_body":"false","output_type":"none"}';
	
	$slider_rows = $wpdb->insert( $wpdb->prefix.'revslider_sliders', 
		array(
			'title' => $rev_slider["title"],
			'alias' => $rev_slider["alias"],
			'params' => $rev_slider["params"]
		)
	);


	if ($slider_rows) {

		// Get the new ID
		$sql = 'SELECT id FROM '. $wpdb->prefix .'revslider_sliders WHERE alias = "'. $rev_slider["alias"] .'" ;';
		$newSlider = $wpdb->get_results($sql);
		$sliderID = $newSlider[0]->id;


		// Add default Slides to Slide Show
		// --------------------------------------------------
		if ($sliderID) {

			$slides = array();

			// Slide 1
			$slides[] = array(
				'params' => 
					'{"background_type":"image","image":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2013\/09\/ss-home-1-bg.jpg","image_id":"3517","title":"Slide","state":"published","slide_transition":"random","0":"Choose Image","slot_amount":"5","transition_rotation":"0","transition_duration":"300","delay":"","enable_link":"false","link_type":"regular","link":"","link_open_in":"same","slide_link":"nothing","link_pos":"front","slide_thumb":"","fullwidth_centering":"true","date_from":"","date_to":"","slide_bg_color":"#E7E7E7","0":"Choose Image"}',
				
				'layers' => 
					'[{"style":"","text":"Image 2","type":"image","image_url":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2013\/09\/ss-home-arrow-right.png","left":391,"top":92,"animation":"sfl","easing":"easeOutExpo","speed":600,"align_hor":"left","align_vert":"top","hiddenunder":false,"resizeme":false,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","time":800,"endtime":"","endspeed":300,"endanimation":"auto","endeasing":"nothing","corner_left":"nothing","corner_right":"nothing","serial":"0","endTimeFinal":5400,"endSpeedFinal":300,"realEndTime":6000,"timeLast":5200},{"style":"","text":"Image 4","type":"image","image_url":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2013\/09\/ss-home-status-update.png","left":206,"top":117,"animation":"sfl","easing":"easeOutExpo","speed":600,"align_hor":"left","align_vert":"top","hiddenunder":false,"resizeme":false,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","time":1000,"endtime":"","endspeed":300,"endanimation":"auto","endeasing":"nothing","corner_left":"nothing","corner_right":"nothing","serial":"1","endTimeFinal":5400,"endSpeedFinal":300,"realEndTime":6000,"timeLast":5000},{"style":"","text":"Image 5","type":"image","image_url":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2013\/09\/ss-home-1-text.png","left":85,"top":161,"animation":"sfl","easing":"easeOutExpo","speed":600,"align_hor":"left","align_vert":"top","hiddenunder":false,"resizeme":false,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","time":1400,"endtime":"","endspeed":300,"endanimation":"auto","endeasing":"nothing","corner_left":"nothing","corner_right":"nothing","serial":"2","endTimeFinal":5400,"endSpeedFinal":300,"realEndTime":6000,"timeLast":4600}]'
			);

			// Slide 2
			$slides[] = array(
				'params' => 
					'{"background_type":"image","image":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2013\/09\/ss-home-2-bg.jpg","image_id":"3519","title":"Slide","state":"published","slide_transition":"random","0":"Choose Image","slot_amount":"5","transition_rotation":"0","transition_duration":"300","delay":"","enable_link":"false","link_type":"regular","link":"","link_open_in":"same","slide_link":"nothing","link_pos":"front","slide_thumb":"","fullwidth_centering":"true","date_from":"","date_to":"","slide_bg_color":"#E7E7E7","0":"Choose Image"}',
				
				'layers' => 
					'[{"style":"","text":"Image 1","type":"image","image_url":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2013\/09\/ss-home-arrow-left-large.png","left":487,"top":94,"animation":"sfr","easing":"easeOutExpo","speed":600,"align_hor":"left","align_vert":"top","hiddenunder":false,"resizeme":false,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","time":800,"endtime":"","endspeed":300,"endanimation":"auto","endeasing":"nothing","corner_left":"nothing","corner_right":"nothing","serial":"0","endTimeFinal":5400,"endSpeedFinal":300,"realEndTime":6000,"timeLast":5200},{"style":"","text":"Image 2","type":"image","image_url":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2013\/09\/ss-home-status-update.png","left":532,"top":119,"animation":"sfr","easing":"easeOutExpo","speed":600,"align_hor":"left","align_vert":"top","hiddenunder":false,"resizeme":false,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","time":1000,"endtime":"","endspeed":300,"endanimation":"auto","endeasing":"nothing","corner_left":"nothing","corner_right":"nothing","serial":"1","endTimeFinal":5400,"endSpeedFinal":300,"realEndTime":6000,"timeLast":5000},{"style":"","text":"Image 3","type":"image","image_url":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2013\/09\/ss-home-2-text.png","left":530,"top":163,"animation":"sfr","easing":"easeOutExpo","speed":600,"align_hor":"left","align_vert":"top","hiddenunder":false,"resizeme":false,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","time":1400,"endtime":"","endspeed":300,"endanimation":"auto","endeasing":"nothing","corner_left":"nothing","corner_right":"nothing","serial":"2","endTimeFinal":5400,"endSpeedFinal":300,"realEndTime":6000,"timeLast":4600}]'
			);

			// Slide 3
			$slides[] = array(
				'params' => 
					'{"background_type":"image","image":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2013\/09\/ss-home-3-bg.jpg","image_id":"3504","title":"Slide","state":"published","slide_transition":"random","0":"Choose Image","slot_amount":"5","transition_rotation":"0","transition_duration":"300","delay":"","enable_link":"false","link_type":"regular","link":"","link_open_in":"same","slide_link":"nothing","link_pos":"front","slide_thumb":"","fullwidth_centering":"true","date_from":"","date_to":"","slide_bg_color":"#E7E7E7","0":"Choose Image"}',
				
				'layers' => 
					'[{"style":"","text":"Image 1","type":"image","image_url":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2013\/09\/ss-home-arrow-right.png","left":391,"top":106,"animation":"lfl","easing":"easeOutExpo","speed":600,"align_hor":"left","align_vert":"top","hiddenunder":false,"resizeme":false,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","time":800,"endtime":"","endspeed":300,"endanimation":"auto","endeasing":"nothing","corner_left":"nothing","corner_right":"nothing","serial":"0","endTimeFinal":5400,"endSpeedFinal":300,"realEndTime":6000,"timeLast":5200},{"style":"","text":"Image 2","type":"image","image_url":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2013\/09\/ss-home-status-update.png","left":206,"top":132,"animation":"lfl","easing":"easeOutExpo","speed":600,"align_hor":"left","align_vert":"top","hiddenunder":false,"resizeme":false,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","time":1100,"endtime":"","endspeed":300,"endanimation":"auto","endeasing":"nothing","corner_left":"nothing","corner_right":"nothing","serial":"1","endTimeFinal":5400,"endSpeedFinal":300,"realEndTime":6000,"timeLast":4900},{"style":"","text":"Image 3","type":"image","image_url":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2013\/09\/ss-home-3-text.png","left":91,"top":176,"animation":"lfl","easing":"easeOutExpo","speed":600,"align_hor":"left","align_vert":"top","hiddenunder":false,"resizeme":false,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","time":1400,"endtime":"","endspeed":300,"endanimation":"auto","endeasing":"nothing","corner_left":"nothing","corner_right":"nothing","serial":"2","endTimeFinal":5400,"endSpeedFinal":300,"realEndTime":6000,"timeLast":4600}]'
			);

			// Slide 4
			$slides[] = array(
				'params' => 
					'{"background_type":"image","image":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2013\/09\/ss-home-4-bg.jpg","image_id":"3506","title":"Slide","state":"published","slide_transition":"random","0":"Choose Image","slot_amount":"5","transition_rotation":"0","transition_duration":"300","delay":"","enable_link":"false","link_type":"regular","link":"","link_open_in":"same","slide_link":"nothing","link_pos":"front","slide_thumb":"","fullwidth_centering":"true","date_from":"","date_to":"","slide_bg_color":"#E7E7E7","0":"Choose Image"}',
				
				'layers' => 
					'[{"style":"","text":"Image 1","type":"image","image_url":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2013\/09\/ss-home-arrow-left.png","left":559,"top":106,"animation":"lfr","easing":"easeOutExpo","speed":600,"align_hor":"left","align_vert":"top","hiddenunder":false,"resizeme":false,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","time":800,"endtime":"","endspeed":300,"endanimation":"auto","endeasing":"nothing","corner_left":"nothing","corner_right":"nothing","serial":"0","endTimeFinal":5400,"endSpeedFinal":300,"realEndTime":6000,"timeLast":5200},{"style":"","text":"Image 2","type":"image","image_url":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2013\/09\/ss-home-status-update.png","left":605,"top":132,"animation":"lfr","easing":"easeOutExpo","speed":600,"align_hor":"left","align_vert":"top","hiddenunder":false,"resizeme":false,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","time":1100,"endtime":"","endspeed":300,"endanimation":"auto","endeasing":"nothing","corner_left":"nothing","corner_right":"nothing","serial":"1","endTimeFinal":5400,"endSpeedFinal":300,"realEndTime":6000,"timeLast":4900},{"style":"","text":"Image 3","type":"image","image_url":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2013\/09\/ss-home-4-text.png","left":604,"top":177,"animation":"lfr","easing":"easeOutExpo","speed":600,"align_hor":"left","align_vert":"top","hiddenunder":false,"resizeme":false,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","time":1400,"endtime":"","endspeed":300,"endanimation":"auto","endeasing":"nothing","corner_left":"nothing","corner_right":"nothing","serial":"2","endTimeFinal":5400,"endSpeedFinal":300,"realEndTime":6000,"timeLast":4600}]'
			);

			// Slide 5
			$slides[] = array(
				'params' => 
					'{"background_type":"image","image":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2013\/09\/ss-home-5-bg.jpg","image_id":"3508","title":"Slide","state":"published","slide_transition":"random","0":"Choose Image","slot_amount":"5","transition_rotation":"0","transition_duration":"300","delay":"","enable_link":"false","link_type":"regular","link":"","link_open_in":"same","slide_link":"nothing","link_pos":"front","slide_thumb":"","fullwidth_centering":"true","date_from":"","date_to":"","slide_bg_color":"#E7E7E7","0":"Choose Image"}',
				
				'layers' => 
					'[{"style":"","text":"Image 1","type":"image","image_url":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2013\/09\/ss-home-arrow-right-xlarge.png","left":352,"top":65,"animation":"fade","easing":"easeOutExpo","speed":500,"align_hor":"left","align_vert":"top","hiddenunder":false,"resizeme":false,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","time":800,"endtime":"","endspeed":300,"endanimation":"auto","endeasing":"nothing","corner_left":"nothing","corner_right":"nothing","serial":"0","endTimeFinal":5500,"endSpeedFinal":300,"realEndTime":6000,"timeLast":5200},{"style":"","text":"Image 2","type":"image","image_url":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2013\/09\/ss-home-status-update.png","left":167,"top":91,"animation":"randomrotate","easing":"easeOutExpo","speed":500,"align_hor":"left","align_vert":"top","hiddenunder":false,"resizeme":false,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","time":1100,"endtime":"","endspeed":300,"endanimation":"auto","endeasing":"nothing","corner_left":"nothing","corner_right":"nothing","serial":"1","endTimeFinal":5500,"endSpeedFinal":300,"realEndTime":6000,"timeLast":4900},{"style":"","text":"Image 3","type":"image","image_url":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2013\/09\/ss-home-5-text.png","left":56,"top":136,"animation":"randomrotate","easing":"easeOutExpo","speed":500,"align_hor":"left","align_vert":"top","hiddenunder":false,"resizeme":false,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","time":1400,"endtime":"","endspeed":300,"endanimation":"auto","endeasing":"nothing","corner_left":"nothing","corner_right":"nothing","serial":"2","endTimeFinal":5500,"endSpeedFinal":300,"realEndTime":6000,"timeLast":4600}]'
			);

			// Slide 6
			$slides[] = array(
				'params' => 
					'{"background_type":"image","image":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2013\/09\/ss-home-6-bg.jpg","image_id":"3510","title":"Slide","state":"published","slide_transition":"random","0":"Choose Image","slot_amount":"5","transition_rotation":"0","transition_duration":"300","delay":"","enable_link":"false","link_type":"regular","link":"","link_open_in":"same","slide_link":"nothing","link_pos":"front","slide_thumb":"","fullwidth_centering":"false","date_from":"","date_to":"","slide_bg_color":"#E7E7E7","0":"Choose Image"}',
				
				'layers' => 
					'[{"style":"","text":"Image 1","type":"image","image_url":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2013\/09\/ss-home-arrow-left.png","left":529,"top":121,"animation":"fade","easing":"easeOutExpo","speed":500,"align_hor":"left","align_vert":"top","hiddenunder":false,"resizeme":false,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","time":800,"endtime":"","endspeed":300,"endanimation":"auto","endeasing":"nothing","corner_left":"nothing","corner_right":"nothing","serial":"0","endTimeFinal":5500,"endSpeedFinal":300,"realEndTime":6000,"timeLast":5200},{"style":"","text":"Image 2","type":"image","image_url":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2013\/09\/ss-home-status-update.png","left":574,"top":146,"animation":"randomrotate","easing":"easeOutExpo","speed":500,"align_hor":"left","align_vert":"top","hiddenunder":false,"resizeme":false,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","time":1100,"endtime":"","endspeed":300,"endanimation":"auto","endeasing":"nothing","corner_left":"nothing","corner_right":"nothing","serial":1,"endTimeFinal":5500,"endSpeedFinal":300,"realEndTime":6000,"timeLast":4900},{"style":"","text":"Image 3","type":"image","image_url":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2013\/09\/ss-home-6-text.png","left":572,"top":190,"animation":"randomrotate","easing":"easeOutExpo","speed":500,"align_hor":"left","align_vert":"top","hiddenunder":false,"resizeme":false,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","time":1400,"endtime":"","endspeed":300,"endanimation":"auto","endeasing":"nothing","corner_left":"nothing","corner_right":"nothing","serial":2,"endTimeFinal":5500,"endSpeedFinal":300,"realEndTime":6000,"timeLast":4600}]'
			);


			// Loop through data and add to DB 
			// --------------------------------------------------
			$slide_order = 1;
			foreach ($slides as $slide) {
				$rows_affected = $wpdb->insert( $wpdb->prefix.'revslider_slides', 
					array(
						'slider_id' => $sliderID,
						'slide_order' => $slide_order,
						'params' => $slide['params'],
						'layers' => $slide['layers']
					)
				);
				$slide_order++;
			}

		}
									

		// Mark the database showing this has been done
		// --------------------------------------------------
		$rev_slider['slides'] = $slides;
		update_option( $shortname.$rev_slider["alias"], $rev_slider );
	
	} // if $slider_rows (slide show added)


	#================================================================================================================


	// ==================================================
	// Add Another Slide Show
	// ==================================================
	$rev_slider = array();
	$rev_slider["title"]  = 'Page Header Sample';
	$rev_slider["alias"]  = 'sample-header';
	$rev_slider["params"] = '{"title":"Page Header Sample","alias":"sample-header","shortcode":"[rev_slider sample-header]","slider_type":"fullwidth","fullscreen_offset_container":"","width":"972","height":"208","responsitive_w1":"940","responsitive_sw1":"770","responsitive_w2":"780","responsitive_sw2":"500","responsitive_w3":"510","responsitive_sw3":"310","responsitive_w4":"","responsitive_sw4":"","responsitive_w5":"","responsitive_sw5":"","responsitive_w6":"","responsitive_sw6":"","delay":"5000","shuffle":"on","lazy_load":"off","use_wpml":"off","load_googlefont":"false","google_font":"PT+Sans+Narrow:400,700","stop_slider":"off","stop_after_loops":"0","stop_at_slide":"2","position":"center","margin_top":"0","margin_bottom":"0","margin_left":"0","margin_right":"0","shadow_type":"0","show_timerbar":"hide","background_color":"#E9E9E9","padding":"0","show_background_image":"false","background_image":"","touchenabled":"on","stop_on_hover":"on","navigaion_type":"none","navigation_arrows":"solo","navigation_style":"round","navigaion_always_on":"false","hide_thumbs":"200","navigaion_align_hor":"center","navigaion_align_vert":"bottom","navigaion_offset_hor":"0","navigaion_offset_vert":"20","leftarrow_align_hor":"left","leftarrow_align_vert":"center","leftarrow_offset_hor":"20","leftarrow_offset_vert":"0","rightarrow_align_hor":"right","rightarrow_align_vert":"center","rightarrow_offset_hor":"20","rightarrow_offset_vert":"0","thumb_width":"100","thumb_height":"50","thumb_amount":"5","hide_slider_under":"0","hide_defined_layers_under":"0","hide_all_layers_under":"0","start_with_slide":"1","first_transition_type":"fade","first_transition_duration":"300","first_transition_slot_amount":"7","jquery_noconflict":"on","js_to_body":"false","output_type":"none"}';
	
	$slider_rows = $wpdb->insert( $wpdb->prefix.'revslider_sliders', 
		array(
			'title' => $rev_slider["title"],
			'alias' => $rev_slider["alias"],
			'params' => $rev_slider["params"]
		)
	);


	if ($slider_rows) {

		// Get the new ID
		$sql = 'SELECT id FROM '. $wpdb->prefix .'revslider_sliders WHERE alias = "'. $rev_slider["alias"] .'" ;';
		$newSlider = $wpdb->get_results($sql);
		$sliderID = $newSlider[0]->id;


		// Add default Slides to Slide Show
		// --------------------------------------------------
		if ($sliderID) {

			$slides = array();

			// Slide 1
			$slides[] = array(
				'params' => 
					'{"background_type":"image","image":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2011\/09\/ss-mosaic-1.jpg","image_id":"3216","title":"Slide 1","state":"published","slide_transition":"slideup,slidedown","0":"Choose Image","slot_amount":"5","transition_rotation":"0","transition_duration":"300","delay":"","enable_link":"false","link_type":"regular","link":"","link_open_in":"same","slide_link":"nothing","link_pos":"front","slide_thumb":"","fullwidth_centering":"true","date_from":"","date_to":"","slide_bg_color":"#E7E7E7","0":"Choose Image"}',
				
				'layers' => 
					'[{"text":"<span style=\"font-size: 40px; line-height: 66px\">Create Something Awesome<\/span>","type":"text","left":-8,"top":0,"animation":"randomrotate","easing":"easeOutExpo","speed":300,"align_hor":"center","align_vert":"middle","hiddenunder":false,"resizeme":false,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","style":"modern_big_redbg","time":1300,"endtime":"","endspeed":300,"endanimation":"auto","endeasing":"nothing","corner_left":"nothing","corner_right":"nothing","serial":"0","endTimeFinal":4700,"endSpeedFinal":300,"realEndTime":5000,"timeLast":3700}]'
			);

			// Slide 2
			$slides[] = array(
				'params' => 
					'{"background_type":"image","image":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2011\/09\/ss-mosaic-2.jpg","image_id":"3217","title":"Slide 2","state":"published","slide_transition":"slideleft,slideright","0":"Choose Image","slot_amount":"5","transition_rotation":"0","transition_duration":"300","delay":"","enable_link":"false","link_type":"regular","link":"","link_open_in":"same","slide_link":"nothing","link_pos":"front","slide_thumb":"","fullwidth_centering":"true","date_from":"","date_to":"","slide_bg_color":"#E7E7E7","0":"Choose Image"}',
				
				'layers' => 
					'[{"text":"<em>Move Ahead!<\/em>","type":"text","left":75,"top":0,"animation":"lfl","easing":"easeOutQuint","speed":2200,"align_hor":"right","align_vert":"middle","hiddenunder":false,"resizeme":false,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","style":"very_large_text","time":1200,"endtime":"4000","endspeed":400,"endanimation":"str","endeasing":"nothing","corner_left":"nothing","corner_right":"nothing","serial":"0","endTimeFinal":4000,"endSpeedFinal":400,"realEndTime":4400,"timeLast":3200}]'
			);

			// Slide 3
			$slides[] = array(
				'params' => 
					'{"background_type":"image","image":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2011\/09\/ss-mosaic-3.jpg","image_id":"3218","title":"Slide 3","state":"published","slide_transition":"slideup,slidedown","0":"Choose Image","slot_amount":"5","transition_rotation":"0","transition_duration":"300","delay":"","enable_link":"false","link_type":"regular","link":"","link_open_in":"same","slide_link":"nothing","link_pos":"front","slide_thumb":"","fullwidth_centering":"true","date_from":"","date_to":"","slide_bg_color":"#E7E7E7","0":"Choose Image"}',
				
				'layers' => 
					'[{"text":"<span style=\"font-size: 60px; line-height: 66px\"> Make a SPLASH! <\/span>","type":"text","left":-7,"top":-2,"animation":"randomrotate","easing":"easeOutExpo","speed":400,"align_hor":"center","align_vert":"middle","hiddenunder":false,"resizeme":false,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","style":"modern_big_redbg","time":1300,"endtime":"","endspeed":400,"endanimation":"auto","endeasing":"nothing","corner_left":"nothing","corner_right":"nothing","serial":"0","endTimeFinal":4600,"endSpeedFinal":400,"realEndTime":5000,"timeLast":3700}]'
			);

			// Slide 4
			$slides[] = array(
				'params' => 
					'{"background_type":"image","image":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2011\/09\/ss-mosaic-4.jpg","image_id":"3219","title":"Slide 4","state":"published","slide_transition":"slideleft,slideright","0":"Choose Image","slot_amount":"5","transition_rotation":"0","transition_duration":"300","delay":"","enable_link":"false","link_type":"regular","link":"","link_open_in":"same","slide_link":"nothing","link_pos":"front","slide_thumb":"","fullwidth_centering":"true","date_from":"","date_to":"","slide_bg_color":"#E7E7E7","0":"Choose Image"}',
				
				'layers' => 
					'[{"text":"<strong style=\"text-shadow: 0 4px 2px rgba(0,0,0,.9)\">INSPIRE!<\/strong>","type":"text","left":0,"top":-5,"animation":"sfb","easing":"easeOutExpo","speed":800,"align_hor":"center","align_vert":"middle","hiddenunder":false,"resizeme":false,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","style":"big_yellow","time":1400,"endtime":"4200","endspeed":600,"endanimation":"stt","endeasing":"nothing","corner_left":"nothing","corner_right":"nothing","serial":"0","endTimeFinal":4200,"endSpeedFinal":600,"realEndTime":4800,"timeLast":3400}]'
			);

			// Slide 5
			$slides[] = array(
				'params' => 
					'{"background_type":"image","image":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2011\/09\/ss-mosaic-5.jpg","image_id":"3220","title":"Slide 5","state":"published","slide_transition":"slideup,slidedown","0":"Choose Image","slot_amount":"5","transition_rotation":"0","transition_duration":"300","delay":"","enable_link":"false","link_type":"regular","link":"","link_open_in":"same","slide_link":"nothing","link_pos":"front","slide_thumb":"","fullwidth_centering":"true","date_from":"","date_to":"","slide_bg_color":"#E7E7E7","0":"Choose Image"}',
				
				'layers' => 
					'[{"text":"Create Something Awesome","type":"text","left":0,"top":-2,"animation":"sft","easing":"easeOutExpo","speed":500,"align_hor":"center","align_vert":"middle","hiddenunder":false,"resizeme":false,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","style":"very_large_text","time":1300,"endtime":"4000","endspeed":500,"endanimation":"ltb","endeasing":"nothing","corner_left":"nothing","corner_right":"nothing","serial":"0","endTimeFinal":4000,"endSpeedFinal":500,"realEndTime":4500,"timeLast":3200}]'
			);

			// Slide 6
			$slides[] = array(
				'params' => 
					'{"background_type":"image","image":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2011\/09\/ss-mosaic-6.jpg","image_id":"3221","title":"Slide 6","state":"published","slide_transition":"slideleft,slideright","0":"Choose Image","slot_amount":"5","transition_rotation":"0","transition_duration":"300","delay":"","enable_link":"false","link_type":"regular","link":"","link_open_in":"same","slide_link":"nothing","link_pos":"front","slide_thumb":"","fullwidth_centering":"true","date_from":"","date_to":"","slide_bg_color":"#E7E7E7","0":"Choose Image"}',
				
				'layers' => 
					'[{"text":"<em style=\"font-size: 42px; line-height: 50px\">MOVE AHEAD!<\/em>","type":"text","left":75,"top":0,"animation":"lfl","easing":"easeOutQuint","speed":2200,"align_hor":"right","align_vert":"middle","hiddenunder":false,"resizeme":false,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","style":"modern_big_redbg","time":1200,"endtime":"4000","endspeed":400,"endanimation":"str","endeasing":"nothing","corner_left":"nothing","corner_right":"nothing","serial":"0","endTimeFinal":4000,"endSpeedFinal":400,"realEndTime":4400,"timeLast":3200}]'
			);

			// Slide 7
			$slides[] = array(
				'params' => 
					'{"background_type":"image","image":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2011\/09\/ss-mosaic-7.jpg","image_id":"3222","title":"Slide 7","state":"published","slide_transition":"slideup,slidedown","0":"Choose Image","slot_amount":"5","transition_rotation":"0","transition_duration":"300","delay":"","enable_link":"false","link_type":"regular","link":"","link_open_in":"same","slide_link":"nothing","link_pos":"front","slide_thumb":"","fullwidth_centering":"true","date_from":"","date_to":"","slide_bg_color":"#E7E7E7","0":"Choose Image"}',
				
				'layers' => 
					'[{"text":"<span style=\"font-size: 60px; line-height: 65px\">Make a SPLASH!<\/span>","type":"text","left":0,"top":0,"animation":"randomrotate","easing":"easeOutExpo","speed":400,"align_hor":"center","align_vert":"middle","hiddenunder":false,"resizeme":false,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","style":"big_orange","time":1200,"endtime":"","endspeed":400,"endanimation":"auto","endeasing":"nothing","corner_left":"nothing","corner_right":"nothing","serial":"0","endTimeFinal":4600,"endSpeedFinal":400,"realEndTime":5000,"timeLast":3800}]'
			);

			// Slide 8
			$slides[] = array(
				'params' => 
					'{"background_type":"image","image":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2011\/09\/ss-mosaic-8.jpg","image_id":"3223","title":"Slide 8","state":"published","slide_transition":"slideleft,slideright","0":"Choose Image","slot_amount":"5","transition_rotation":"0","transition_duration":"300","delay":"","enable_link":"false","link_type":"regular","link":"","link_open_in":"same","slide_link":"nothing","link_pos":"front","slide_thumb":"","fullwidth_centering":"true","date_from":"","date_to":"","slide_bg_color":"#E7E7E7","0":"Choose Image"}',
				
				'layers' => 
					'[{"text":"<strong style=\"text-shadow: 0 4px 2px rgba(0,0,0,.9); color: #F2F0F0;\">Innovate!<\/strong>","type":"text","left":0,"top":-5,"animation":"fade","easing":"easeOutExpo","speed":300,"align_hor":"center","align_vert":"middle","hiddenunder":false,"resizeme":false,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","style":"big_yellow","time":1400,"endtime":"","endspeed":300,"endanimation":"auto","endeasing":"nothing","corner_left":"nothing","corner_right":"nothing","serial":"0","endTimeFinal":4700,"endSpeedFinal":300,"realEndTime":5000,"timeLast":3600}]'
			);

			// Loop through data and add to DB 
			// --------------------------------------------------
			$slide_order = 1;
			foreach ($slides as $slide) {
				$rows_affected = $wpdb->insert( $wpdb->prefix.'revslider_slides', 
					array(
						'slider_id' => $sliderID,
						'slide_order' => $slide_order,
						'params' => $slide['params'],
						'layers' => $slide['layers']
					)
				);
				$slide_order++;
			}

		}
									

		// Mark the database showing this has been done
		// --------------------------------------------------
		$rev_slider['slides'] = $slides;
		update_option( $shortname.$rev_slider["alias"], $rev_slider );
	
	} // if $slider_rows (slide show added)


	#================================================================================================================


	// ==================================================
	// Add Another Slide Show
	// ==================================================
	$rev_slider = array();
	$rev_slider["title"]  = 'Home Page - Alternate';
	$rev_slider["alias"]  = 'home-page-alt';
	$rev_slider["params"] = '{"title":"Home Page - Alternate","alias":"home-page-alt","shortcode":"[rev_slider home-page-alt]","slider_type":"fullwidth","fullscreen_offset_container":"","width":"972","height":"250","responsitive_w1":"940","responsitive_sw1":"770","responsitive_w2":"780","responsitive_sw2":"500","responsitive_w3":"510","responsitive_sw3":"310","responsitive_w4":"","responsitive_sw4":"","responsitive_w5":"","responsitive_sw5":"","responsitive_w6":"","responsitive_sw6":"","delay":"4000","shuffle":"off","lazy_load":"off","use_wpml":"off","load_googlefont":"false","google_font":"PT+Sans+Narrow:400,700","stop_slider":"off","stop_after_loops":"0","stop_at_slide":"2","position":"center","margin_top":"0","margin_bottom":"0","margin_left":"0","margin_right":"0","shadow_type":"0","show_timerbar":"hide","background_color":"#414B52","padding":"0","show_background_image":"false","background_image":"","touchenabled":"on","stop_on_hover":"on","navigaion_type":"none","navigation_arrows":"solo","navigation_style":"round","navigaion_always_on":"false","hide_thumbs":"200","navigaion_align_hor":"center","navigaion_align_vert":"bottom","navigaion_offset_hor":"0","navigaion_offset_vert":"20","leftarrow_align_hor":"left","leftarrow_align_vert":"center","leftarrow_offset_hor":"20","leftarrow_offset_vert":"0","rightarrow_align_hor":"right","rightarrow_align_vert":"center","rightarrow_offset_hor":"20","rightarrow_offset_vert":"0","thumb_width":"100","thumb_height":"50","thumb_amount":"5","hide_slider_under":"0","hide_defined_layers_under":"0","hide_all_layers_under":"0","start_with_slide":"1","first_transition_type":"fade","first_transition_duration":"300","first_transition_slot_amount":"7","jquery_noconflict":"on","js_to_body":"false","output_type":"none"}';
	
	$slider_rows = $wpdb->insert( $wpdb->prefix.'revslider_sliders', 
		array(
			'title' => $rev_slider["title"],
			'alias' => $rev_slider["alias"],
			'params' => $rev_slider["params"]
		)
	);


	if ($slider_rows) {

		// Get the new ID
		$sql = 'SELECT id FROM '. $wpdb->prefix .'revslider_sliders WHERE alias = "'. $rev_slider["alias"] .'" ;';
		$newSlider = $wpdb->get_results($sql);
		$sliderID = $newSlider[0]->id;


		// Add default Slides to Slide Show
		// --------------------------------------------------
		if ($sliderID) {

			$slides = array();

			// Slide 1
			$slides[] = array(
				'params' => 
					'{"background_type":"trans","title":"Slide 1","state":"published","slide_transition":"slidevertical","0":"Choose Image","slot_amount":"7","transition_rotation":"0","transition_duration":"300","delay":"","enable_link":"false","link_type":"regular","link":"","link_open_in":"same","slide_link":"nothing","link_pos":"front","slide_thumb":"","fullwidth_centering":"true","date_from":"","date_to":"","image_id":"","slide_bg_color":"#E7E7E7","image":"","0":"Choose Image"}',
				
				'layers' => 
					'[{"style":"","text":"Image 1","type":"image","image_url":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2011\/09\/ss-4-column-1.png","left":-347,"top":0,"animation":"lfr","easing":"easeOutQuart","speed":390,"align_hor":"center","align_vert":"middle","hiddenunder":false,"resizeme":false,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","time":300,"endtime":"3100","endspeed":300,"endanimation":"ltl","endeasing":"nothing","corner_left":"nothing","corner_right":"nothing","serial":"0","endTimeFinal":3100,"endSpeedFinal":300,"realEndTime":3400,"timeLast":3100},{"style":"","text":"Image 2","type":"image","image_url":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2011\/09\/ss-4-column-2.png","left":-116,"top":0,"animation":"lfr","easing":"easeOutQuart","speed":460,"align_hor":"center","align_vert":"middle","hiddenunder":false,"resizeme":false,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","time":500,"endtime":"3400","endspeed":250,"endanimation":"ltl","endeasing":"nothing","corner_left":"nothing","corner_right":"nothing","serial":"1","endTimeFinal":3400,"endSpeedFinal":250,"realEndTime":3650,"timeLast":3150},{"style":"","text":"Image 3","type":"image","image_url":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2011\/09\/ss-4-column-3.png","left":116,"top":0,"animation":"lfr","easing":"easeOutQuart","speed":470,"align_hor":"center","align_vert":"middle","hiddenunder":false,"resizeme":false,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","time":750,"endtime":"3600","endspeed":200,"endanimation":"ltl","endeasing":"nothing","corner_left":"nothing","corner_right":"nothing","serial":"2","endTimeFinal":3600,"endSpeedFinal":200,"realEndTime":3800,"timeLast":3050},{"style":"","text":"Image 4","type":"image","image_url":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2011\/09\/ss-4-column-4.png","left":347,"top":0,"animation":"lfr","easing":"easeOutQuart","speed":515,"align_hor":"center","align_vert":"middle","hiddenunder":false,"resizeme":false,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","time":1000,"endtime":"3800","endspeed":150,"endanimation":"ltl","endeasing":"nothing","corner_left":"nothing","corner_right":"nothing","serial":"3","endTimeFinal":3800,"endSpeedFinal":150,"realEndTime":3950,"timeLast":2950}]'
			);

			// Slide 2
			$slides[] = array(
				'params' => 
					'{"background_type":"trans","title":"Slide 2","state":"published","slide_transition":"slidevertical","0":"Choose Image","slot_amount":"7","transition_rotation":"0","transition_duration":"300","delay":"","enable_link":"false","link_type":"regular","link":"","link_open_in":"same","slide_link":"nothing","link_pos":"front","slide_thumb":"","fullwidth_centering":"true","date_from":"","date_to":"","image_id":"","slide_bg_color":"#E7E7E7","image":"","0":"Choose Image"}',
				
				'layers' => 
					'[{"style":"","text":"Image 1","type":"image","image_url":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2011\/09\/ss-4-column-6.png","left":-347,"top":0,"animation":"sft","easing":"easeOutExpo","speed":800,"align_hor":"center","align_vert":"middle","hiddenunder":false,"resizeme":false,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","time":150,"endtime":"3350","endspeed":600,"endanimation":"stb","endeasing":"easeInSine","corner_left":"nothing","corner_right":"nothing","serial":"0","endTimeFinal":3350,"endSpeedFinal":600,"realEndTime":3950,"timeLast":3800},{"style":"","text":"Image 2","type":"image","image_url":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2011\/09\/ss-4-column-5.png","left":-116,"top":0,"animation":"sfb","easing":"easeOutExpo","speed":600,"align_hor":"center","align_vert":"middle","hiddenunder":false,"resizeme":false,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","time":150,"endtime":"3350","endspeed":600,"endanimation":"stt","endeasing":"easeInSine","corner_left":"nothing","corner_right":"nothing","serial":"1","endTimeFinal":3350,"endSpeedFinal":600,"realEndTime":3950,"timeLast":3800},{"style":"","text":"Image 3","type":"image","image_url":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2011\/09\/ss-4-column-8.png","left":116,"top":0,"animation":"sft","easing":"easeOutExpo","speed":600,"align_hor":"center","align_vert":"middle","hiddenunder":false,"resizeme":false,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","time":150,"endtime":"3350","endspeed":600,"endanimation":"stb","endeasing":"easeInSine","corner_left":"nothing","corner_right":"nothing","serial":"2","endTimeFinal":3350,"endSpeedFinal":600,"realEndTime":3950,"timeLast":3800},{"style":"","text":"Image 4","type":"image","image_url":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2011\/09\/ss-4-column-7.png","left":347,"top":0,"animation":"sfb","easing":"easeOutExpo","speed":600,"align_hor":"center","align_vert":"middle","hiddenunder":false,"resizeme":false,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","time":150,"endtime":"3350","endspeed":600,"endanimation":"stt","endeasing":"easeInSine","corner_left":"nothing","corner_right":"nothing","serial":"3","endTimeFinal":3350,"endSpeedFinal":600,"realEndTime":3950,"timeLast":3800}]'
			);

			// Slide 3
			$slides[] = array(
				'params' => 
					'{"background_type":"trans","title":"Slide 3","state":"published","slide_transition":"slidevertical","0":"Choose Image","slot_amount":"7","transition_rotation":"0","transition_duration":"300","delay":"","enable_link":"false","link_type":"regular","link":"","link_open_in":"same","slide_link":"nothing","link_pos":"front","slide_thumb":"","fullwidth_centering":"true","date_from":"","date_to":"","image_id":"","slide_bg_color":"#E7E7E7","image":"","0":"Choose Image"}',
				
				'layers' => 
					'[{"style":"","text":"Image 1","type":"image","image_url":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2011\/09\/ss-4-column-5.png","left":-347,"top":0,"animation":"randomrotate","easing":"easeOutQuart","speed":300,"align_hor":"center","align_vert":"middle","hiddenunder":false,"resizeme":false,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","time":200,"endtime":"2900","endspeed":350,"endanimation":"auto","endeasing":"nothing","corner_left":"nothing","corner_right":"nothing","serial":"0","endTimeFinal":2900,"endSpeedFinal":350,"realEndTime":3250,"timeLast":3050},{"style":"","text":"Image 2","type":"image","image_url":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2011\/09\/ss-4-column-1.png","left":-116,"top":0,"animation":"randomrotate","easing":"easeOutQuart","speed":350,"align_hor":"center","align_vert":"middle","hiddenunder":false,"resizeme":false,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","time":550,"endtime":"3200","endspeed":400,"endanimation":"auto","endeasing":"nothing","corner_left":"nothing","corner_right":"nothing","serial":"1","endTimeFinal":3200,"endSpeedFinal":400,"realEndTime":3600,"timeLast":3050},{"style":"","text":"Image 3","type":"image","image_url":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2011\/09\/ss-4-column-7.png","left":116,"top":0,"animation":"randomrotate","easing":"easeOutQuart","speed":400,"align_hor":"center","align_vert":"middle","hiddenunder":false,"resizeme":false,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","time":800,"endtime":"3400","endspeed":450,"endanimation":"auto","endeasing":"nothing","corner_left":"nothing","corner_right":"nothing","serial":"2","endTimeFinal":3400,"endSpeedFinal":450,"realEndTime":3850,"timeLast":3050},{"style":"","text":"Image 4","type":"image","image_url":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2011\/09\/ss-4-column-3.png","left":347,"top":0,"animation":"randomrotate","easing":"easeOutQuart","speed":500,"align_hor":"center","align_vert":"middle","hiddenunder":false,"resizeme":false,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","time":1000,"endtime":"3600","endspeed":400,"endanimation":"auto","endeasing":"nothing","corner_left":"nothing","corner_right":"nothing","serial":"3","endTimeFinal":3600,"endSpeedFinal":400,"realEndTime":4000,"timeLast":3000}]'
			);

			// Slide 4
			$slides[] = array(
				'params' => 
					'{"background_type":"trans","title":"Slide 4","state":"published","slide_transition":"slidevertical","0":"Choose Image","slot_amount":"7","transition_rotation":"0","transition_duration":"300","delay":"","enable_link":"false","link_type":"regular","link":"","link_open_in":"same","slide_link":"nothing","link_pos":"front","slide_thumb":"","fullwidth_centering":"true","date_from":"","date_to":"","image_id":"","slide_bg_color":"#E7E7E7","image":"","0":"Choose Image"}',
				
				'layers' => 
					'[{"style":"","text":"Image 1","type":"image","image_url":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2011\/09\/ss-4-column-8.png","left":-347,"top":0,"animation":"lft","easing":"easeInOutSine","speed":518,"align_hor":"center","align_vert":"middle","hiddenunder":false,"resizeme":false,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","time":300,"endtime":"3400","endspeed":365,"endanimation":"ltb","endeasing":"easeInSine","corner_left":"nothing","corner_right":"nothing","serial":"0","endTimeFinal":3400,"endSpeedFinal":365,"realEndTime":3765,"timeLast":3465},{"style":"","text":"Image 2","type":"image","image_url":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2011\/09\/ss-4-column-4.png","left":-116,"top":0,"animation":"lft","easing":"easeInOutSine","speed":510,"align_hor":"center","align_vert":"middle","hiddenunder":false,"resizeme":false,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","time":500,"endtime":"3500","endspeed":350,"endanimation":"ltb","endeasing":"easeInSine","corner_left":"nothing","corner_right":"nothing","serial":"1","endTimeFinal":3500,"endSpeedFinal":350,"realEndTime":3850,"timeLast":3350},{"style":"","text":"Image 3","type":"image","image_url":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2011\/09\/ss-4-column-6.png","left":116,"top":0,"animation":"lft","easing":"easeInOutSine","speed":490,"align_hor":"center","align_vert":"middle","hiddenunder":false,"resizeme":false,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","time":700,"endtime":"3600","endspeed":325,"endanimation":"ltb","endeasing":"easeInSine","corner_left":"nothing","corner_right":"nothing","serial":"2","endTimeFinal":3600,"endSpeedFinal":325,"realEndTime":3925,"timeLast":3225},{"style":"","text":"Image 4","type":"image","image_url":"http:\/\/para.llel.us\/themes\/salutation-responsive\/wp-content\/uploads\/2011\/09\/ss-4-column-2.png","left":347,"top":0,"animation":"lft","easing":"easeInOutSine","speed":465,"align_hor":"center","align_vert":"middle","hiddenunder":false,"resizeme":false,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","time":900,"endtime":"3700","endspeed":300,"endanimation":"ltb","endeasing":"easeInSine","corner_left":"nothing","corner_right":"nothing","serial":"3","endTimeFinal":3700,"endSpeedFinal":300,"realEndTime":4000,"timeLast":3100}]'
			);

			// Loop through data and add to DB 
			// --------------------------------------------------
			$slide_order = 1;
			foreach ($slides as $slide) {
				$rows_affected = $wpdb->insert( $wpdb->prefix.'revslider_slides', 
					array(
						'slider_id' => $sliderID,
						'slide_order' => $slide_order,
						'params' => $slide['params'],
						'layers' => $slide['layers']
					)
				);
				$slide_order++;
			}

		}
									

		// Mark the database showing this has been done
		// --------------------------------------------------
		$rev_slider['slides'] = $slides;
		update_option( $shortname.$rev_slider["alias"], $rev_slider );
	
	} // if $slider_rows (slide show added)


	// Mark the database showing demo sliders imported
	// --------------------------------------------------
	$rev_slider['slides'] = $slides;
	update_option( $shortname.'demo_slider', $rev_slider );

}

# --------------------------------------------------
# Add action for data import
# --------------------------------------------------

// Update database if row doesn't exist
if( !get_option( $shortname.'demo_slider' ) ) {

	// Call the demo data function after theme setup (admin only)
	add_action( 'after_setup_theme', 'importDemoSlider' );

}

?>