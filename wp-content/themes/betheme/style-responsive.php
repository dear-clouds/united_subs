<?php
/**
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

/* ==============================================================================================================================
/*
/*	Mobile Menu | Init																							Mobile Menu | Init
/*
/* ============================================================================================================================ */

<?php if( mfn_opts_get('responsive') ): ?>

	<?php 
		$mobileMenuInitW = $stickyMenuInitW = mfn_opts_get( 'mobile-menu-initial', 1240 );
		
		if( mfn_header_style( true ) == 'header-creative' ){
			$mobileMenuInitW = 1240;
		}
		
		if( mfn_opts_get( 'responsive-sticky' ) ){
			$stickyMenuInitW = 768;
		}
	?>
	
	
	/* ============================================================================================
	/*	Menu | Desktop																Menu | Desktop
	/* ========================================================================================= */

	@media only screen and (min-width: <?php echo $mobileMenuInitW; ?>px) 
	{
	
		body:not(.header-simple) #Top_bar #menu { display:block !important; }
		
		.tr-menu #Top_bar #menu { background:none !important;}
			
		/* Mega Menu */
		
		#Top_bar .menu > li > ul.mfn-megamenu { width:984px; }
		#Top_bar .menu > li > ul.mfn-megamenu > li { float:left;}
		#Top_bar .menu > li > ul.mfn-megamenu > li.mfn-megamenu-cols-1 { width:100%;}
		#Top_bar .menu > li > ul.mfn-megamenu > li.mfn-megamenu-cols-2 { width:50%;}
		#Top_bar .menu > li > ul.mfn-megamenu > li.mfn-megamenu-cols-3 { width:33.33%;}
		#Top_bar .menu > li > ul.mfn-megamenu > li.mfn-megamenu-cols-4 { width:25%;}
		#Top_bar .menu > li > ul.mfn-megamenu > li.mfn-megamenu-cols-5 { width:20%;}
		#Top_bar .menu > li > ul.mfn-megamenu > li.mfn-megamenu-cols-6 { width:16.66%;}
		#Top_bar .menu > li > ul.mfn-megamenu > li > ul { display:block !important; position:inherit; left:auto; top:auto; border-width: 0 1px 0 0; }
		#Top_bar .menu > li > ul.mfn-megamenu > li:last-child > ul{ border: 0; }
		#Top_bar .menu > li > ul.mfn-megamenu > li > ul li { width: auto; }
		
		#Top_bar .menu > li > ul.mfn-megamenu a.mfn-megamenu-title { text-transform: uppercase; font-weight:400; background:none;}
	
		#Top_bar .menu > li > ul.mfn-megamenu a .menu-arrow { display: none; }
			
		.menuo-right #Top_bar .menu > li > ul.mfn-megamenu { left:auto; right:0;}
		.menuo-right #Top_bar .menu > li > ul.mfn-megamenu-bg { box-sizing:border-box;}
			
		/* Mega Menu | Background Image */
		
		#Top_bar .menu > li > ul.mfn-megamenu-bg { padding:20px 166px 20px 20px; background-repeat:no-repeat; background-position: bottom right; }
		#Top_bar .menu > li > ul.mfn-megamenu-bg > li { background:none;}
		#Top_bar .menu > li > ul.mfn-megamenu-bg > li a { border:none;}
		#Top_bar .menu > li > ul.mfn-megamenu-bg > li > ul { background:none !important;
			-webkit-box-shadow: 0 0 0 0;
			-moz-box-shadow: 0 0 0 0;
			box-shadow: 0 0 0 0;
		}
		
		/* Header | Plain */
		
		.header-plain:not(.menuo-right) #Header .top_bar_left { width:auto !important;}
		
		/* Header | Stack */
		
		.header-stack.header-center #Top_bar #menu { display: inline-block !important;}
				
		/* Header Simple | .header-simple */
		
		.header-simple {}
			
		.header-simple #Top_bar #menu { display:none; height: auto; width: 300px; bottom: auto; top: 100%; right: 1px; position: absolute; margin: 0px;}
	
		.header-simple #Header a.responsive-menu-toggle { display:block; line-height: 35px; font-size: 25px; position:absolute; right: 10px; }
		.header-simple #Header a:hover.responsive-menu-toggle { text-decoration: none; }
		
			/* Header Simple | Main Menu |  1st level */
		
			.header-simple #Top_bar #menu > ul { width:100%; float: left; }
			.header-simple #Top_bar #menu ul li { width: 100%; padding-bottom: 0; border-right: 0; position: relative; }
			.header-simple #Top_bar #menu ul li a { padding:0 20px; margin:0; display: block; height: auto; line-height: normal; border:none; }
			.header-simple #Top_bar #menu ul li a:after { display:none;}
			.header-simple #Top_bar #menu ul li a span { border:none; line-height:48px; display:inline; padding:0;}
					
			.header-simple #Top_bar #menu ul li.submenu .menu-toggle { display:block; position:absolute; right:0; top:0; width:48px; height:48px; line-height:48px; font-size:30px; text-align:center; color:#d6d6d6; border-left:1px solid #eee; cursor:pointer;}
			.header-simple #Top_bar #menu ul li.submenu .menu-toggle:after { content:"+"}
			.header-simple #Top_bar #menu ul li.hover > .menu-toggle:after { content:"-"}
			.header-simple #Top_bar #menu ul li.hover a { border-bottom: 0; }
			
			.header-simple #Top_bar #menu ul.mfn-megamenu li .menu-toggle { display:none;}
		
			/* Header Simple | Main Menu | 2nd level */
			
			.header-simple #Top_bar #menu ul li ul { position:relative !important; left:0 !important; top:0; padding: 0; margin-left: 0 !important; width:auto !important; background-image:none;}
			.header-simple #Top_bar #menu ul li ul li { width:100% !important;}
			.header-simple #Top_bar #menu ul li ul li a { padding: 0 20px 0 30px;}
			.header-simple #Top_bar #menu ul li ul li a .menu-arrow { display: none;}
			.header-simple #Top_bar #menu ul li ul li a span { padding:0;}
			.header-simple #Top_bar #menu ul li ul li a span:after { display:none !important;}
			
			.header-simple #Top_bar .menu > li > ul.mfn-megamenu a.mfn-megamenu-title { text-transform: uppercase; font-weight:400;}
			.header-simple #Top_bar .menu > li > ul.mfn-megamenu > li > ul { display:block !important; position:inherit; left:auto; top:auto;}
			
			/* Header Simple | Main Menu | 3rd level */
			
			.header-simple #Top_bar #menu ul li ul li ul { border-left: 0 !important; padding: 0; top: 0; }
			.header-simple #Top_bar #menu ul li ul li ul li a { padding: 0 20px 0 40px;}

			/* Header Simple | RTL */
			
			.rtl.header-simple  #Top_bar #menu { left: 1px; right: auto;}
			.rtl.header-simple #Top_bar a.responsive-menu-toggle { left:10px; right:auto; }
			.rtl.header-simple #Top_bar #menu ul li.submenu .menu-toggle { left:0; right:auto; border-left:none; border-right:1px solid #eee;}
			.rtl.header-simple #Top_bar #menu ul li ul { left:auto !important; right:0 !important;}
			.rtl.header-simple #Top_bar #menu ul li ul li a { padding: 0 30px 0 20px;}
			.rtl.header-simple #Top_bar #menu ul li ul li ul li a { padding: 0 40px 0 20px;}
			
		/* Menu style | Highlight */
		
		.menu-highlight #Top_bar .menu > li { margin: 0 2px; }
		.menu-highlight:not(.header-creative) #Top_bar .menu > li > a { margin: 20px 0; padding: 0; -webkit-border-radius: 5px; border-radius: 5px; }
		.menu-highlight #Top_bar .menu > li > a:after { display: none; }
		.menu-highlight #Top_bar .menu > li > a span:not(.description) { line-height: 50px; }
		.menu-highlight #Top_bar .menu > li > a span.description { display: none; }
		
		.menu-highlight.header-stack #Top_bar .menu > li > a { margin: 10px 0 !important; }
		.menu-highlight.header-stack #Top_bar .menu > li > a span:not(.description) { line-height: 40px; }
		
		.menu-highlight.header-fixed #Top_bar .menu > li > a { margin: 10px 0 !important; padding: 5px 0; }
		.menu-highlight.header-fixed #Top_bar .menu > li > a span { line-height:30px;}
		
		.menu-highlight.header-transparent #Top_bar .menu > li > a { margin: 5px 0; }
		
		.menu-highlight.header-simple #Top_bar #menu ul li,
		.menu-highlight.header-creative #Top_bar #menu ul li { margin: 0; }
		.menu-highlight.header-simple #Top_bar #menu ul li > a,
		.menu-highlight.header-creative #Top_bar #menu ul li > a { -webkit-border-radius: 0; border-radius: 0; }
	
		.menu-highlight:not(.header-simple) #Top_bar.is-sticky .menu > li > a { margin: 10px 0 !important; padding: 5px 0 !important; }
		.menu-highlight:not(.header-simple) #Top_bar.is-sticky .menu > li > a span { line-height:30px !important;}
		
		.header-modern.menu-highlight.menuo-right .menu_wrapper { margin-right: 20px;}
				
		/* Menu style | Line Below  */
		
		.menu-line-below #Top_bar .menu > li > a:after { top: auto; bottom: -4px; }
		.menu-line-below #Top_bar.is-sticky .menu > li > a:after { top: auto; bottom: -4px; }
		
		.menu-line-below-80 #Top_bar:not(.is-sticky) .menu > li > a:after { height: 4px; left: 10%; top: 50%; margin-top: 20px; width: 80%; } 
		
		.menu-line-below-80-1 #Top_bar:not(.is-sticky) .menu > li > a:after { height: 1px; left: 10%; top: 50%; margin-top: 20px; width: 80%; }
		
		/* Menu style | Arrow Top  */
		
		.menu-arrow-top #Top_bar .menu > li > a:after { background: none repeat scroll 0 0 rgba(0, 0, 0, 0) !important; border-color: #cccccc transparent transparent transparent; border-style: solid; border-width: 7px 7px 0 7px; display: block; height: 0; left: 50%; margin-left: -7px; top: 0 !important; width: 0; }
		.menu-arrow-top.header-transparent #Top_bar .menu > li > a:after,
		.menu-arrow-top.header-plain #Top_bar .menu > li > a:after { display: none; }
		.menu-arrow-top #Top_bar.is-sticky .menu > li > a:after { top: 0px !important; }
	
		/* Menu style | Arrow Bottom  */
		
		.menu-arrow-bottom #Top_bar .menu > li > a:after { background: none !important; border-color: transparent transparent #cccccc transparent; border-style: solid; border-width: 0 7px 7px; display: block; height: 0; left: 50%; margin-left: -7px; top: auto; bottom: 0; width: 0; }
		.menu-arrow-bottom.header-transparent #Top_bar .menu > li > a:after,
		.menu-arrow-bottom.header-plain #Top_bar .menu > li > a:after { display: none; }
		.menu-arrow-bottom #Top_bar.is-sticky .menu > li > a:after { top: auto; bottom: 0; }
		
		/* Menu style | No Borders  */
		
		.menuo-no-borders #Top_bar .menu > li > a span:not(.description) { border-right-width: 0; }
		.menuo-no-borders #Header_creative #Top_bar .menu > li > a span { border-bottom-width: 0; }
	
	}
	
	
	/* ============================================================================================
	/*	Sticky Header
	/* ========================================================================================= */

	@media only screen and (min-width: <?php echo $stickyMenuInitW; ?>px) 
	{

		/* Sticky | .is-sticky */
		
		#Top_bar.is-sticky { position:fixed !important; width:100%; left:0; top:-60px; height:60px; z-index:701; background:#fff; opacity:.97; filter: alpha(opacity = 97);
			-webkit-box-shadow: 0px 2px 5px 0px rgba(0, 0, 0, 0.1);
			   -moz-box-shadow: 0px 2px 5px 0px rgba(0, 0, 0, 0.1);
			        box-shadow: 0px 2px 5px 0px rgba(0, 0, 0, 0.1);
		}
		
		.layout-boxed.header-boxed #Top_bar.is-sticky { max-width:<?php echo $mobileMenuInitW; ?>px; left:50%; -webkit-transform: translateX(-50%); transform: translateX(-50%);}
		.layout-boxed.header-boxed.nice-scroll #Top_bar.is-sticky { margin-left:-5px;}
		
		#Top_bar.is-sticky .top_bar_left,
		#Top_bar.is-sticky .top_bar_right,
		#Top_bar.is-sticky .top_bar_right:before { background:none;}
		#Top_bar.is-sticky .top_bar_right { top:-4px;}
		
		#Top_bar.is-sticky .logo { width:auto; margin: 0 30px 0 20px; padding:0;}
		#Top_bar.is-sticky #logo { padding:5px 0 !important; height:50px !important; line-height:50px !important;}
		#Top_bar.is-sticky #logo img:not(.svg) { max-height:35px; width: auto !important;}
		
		#Top_bar.is-sticky #logo img.logo-main 		{ display:none;}
		#Top_bar.is-sticky #logo img.logo-sticky 	{ display:inline;}
		
		#Top_bar.is-sticky .menu_wrapper { clear:none;}
		#Top_bar.is-sticky .menu_wrapper .menu > li > a  { padding:15px 0;}
		
		#Top_bar.is-sticky .menu > li > a,
		#Top_bar.is-sticky .menu > li > a span { line-height:30px;}
		#Top_bar.is-sticky .menu > li > a:after { top:auto; bottom:-4px;}
		
		#Top_bar.is-sticky .menu > li > a span.description { display:none;}
		
		#Top_bar.is-sticky a.responsive-menu-toggle { top: 14px;}
	
		#Top_bar.is-sticky .top_bar_right_wrapper { top:15px;}
		.header-plain #Top_bar.is-sticky .top_bar_right_wrapper { top:0;}
		
		#Top_bar.is-sticky .secondary_menu_wrapper,
		#Top_bar.is-sticky .banner_wrapper { display:none;}
		
		.header-simple #Top_bar.is-sticky .responsive-menu-toggle { top:12px;}

		.header-overlay #Top_bar.is-sticky { display:none;}
		
		
			/* Sticky | Dark */
			
			.sticky-dark #Top_bar.is-sticky { background: rgba(0,0,0,.8); }
			.sticky-dark #Top_bar.is-sticky #menu { background: none; }
			.sticky-dark #Top_bar.is-sticky .menu > li > a { color: #fff; }
			.sticky-dark #Top_bar.is-sticky .top_bar_right a { color: rgba(255,255,255,.5); }
			.sticky-dark #Top_bar.is-sticky .wpml-languages a.active,
			.sticky-dark #Top_bar.is-sticky .wpml-languages ul.wpml-lang-dropdown { background: rgba(0,0,0,0.3); border-color: rgba(0, 0, 0, 0.1); }

	}
	
	
	/* ============================================================================================
	/*	Menu | Mobile																Menu | Mobile
	/* ========================================================================================= */
	
	@media only screen and (max-width: <?php echo $mobileMenuInitW - 1; ?>px)
	{
		.header_placeholder { height: 0 !important;}
	
	
		/* Header */
			
		#Top_bar #menu { display:none; height: auto; width: 300px; bottom: auto; top: 100%; right: 1px; position: absolute; margin: 0px;}
	
		#Top_bar a.responsive-menu-toggle { display:block; width: 35px; height: 35px; text-align: center; position:absolute; top: 28px; right: 10px; -webkit-border-radius: 3px; border-radius: 3px;}
		#Top_bar a:hover.responsive-menu-toggle { text-decoration: none;}
		#Top_bar a.responsive-menu-toggle i { font-size: 25px; line-height: 35px;}
		#Top_bar a.responsive-menu-toggle span { float:right; padding:10px 5px; line-height:14px;}
	
	
		/* Main Menu | 1st level */
		
		#Top_bar #menu > ul { width:100%; float: left; }
		#Top_bar #menu ul li { width: 100%; padding-bottom: 0; border-right: 0; position: relative; }
		#Top_bar #menu ul li a { padding:0 20px; margin:0; display: block; height: auto; line-height: normal; border:none; }
		#Top_bar #menu ul li a:after { display:none;}
		#Top_bar #menu ul li a span { border:none; line-height:48px; display:inline; padding:0;}
		#Top_bar #menu ul li a span.description { margin:0 0 0 5px;}
		#Top_bar #menu ul li.submenu .menu-toggle { display:block; position:absolute; right:0; top:0; width:48px; height:48px; line-height:48px; font-size:30px; text-align:center; color:#d6d6d6; border-left:1px solid #eee; cursor:pointer;}
		#Top_bar #menu ul li.submenu .menu-toggle:after { content:"+"}
		#Top_bar #menu ul li.hover > .menu-toggle:after { content:"-"}
		#Top_bar #menu ul li.hover a { border-bottom: 0; }
		#Top_bar #menu ul li a span:after { display:none !important;} 
		
		#Top_bar #menu ul.mfn-megamenu li .menu-toggle { display:none;}
	
	
		/* Main Menu | 2nd level */
		
		#Top_bar #menu ul li ul { position:relative !important; left:0 !important; top:0; padding: 0; margin-left: 0 !important; width:auto !important; background-image:none !important;
			box-shadow: 0 0 0 0 transparent !important; -webkit-box-shadow: 0 0 0 0 transparent !important;
		}
		#Top_bar #menu ul li ul li { width:100% !important;}
		#Top_bar #menu ul li ul li a { padding: 0 20px 0 30px;}
		#Top_bar #menu ul li ul li a .menu-arrow { display: none;}
		#Top_bar #menu ul li ul li a span { padding:0;}
		#Top_bar #menu ul li ul li a span:after { display:none !important;}
		
		#Top_bar .menu > li > ul.mfn-megamenu a.mfn-megamenu-title { text-transform: uppercase; font-weight:400;}
		#Top_bar .menu > li > ul.mfn-megamenu > li > ul { display:block !important; position:inherit; left:auto; top:auto;}
		
		
		/* Main Menu | 3rd level */
		
		#Top_bar #menu ul li ul li ul { border-left: 0 !important; padding: 0; top: 0; }
		#Top_bar #menu ul li ul li ul li a { padding: 0 20px 0 40px;}
		
		
		/* Main Menu | RTL */
		
		.rtl #Top_bar #menu { left: 1px; right: auto;}
		.rtl #Top_bar a.responsive-menu-toggle { left:10px; right:auto; }
		.rtl #Top_bar #menu ul li.submenu .menu-toggle { left:0; right:auto; border-left:none; border-right:1px solid #eee;}
		.rtl #Top_bar #menu ul li ul { left:auto !important; right:0 !important;}
		.rtl #Top_bar #menu ul li ul li a { padding: 0 30px 0 20px;}
		.rtl #Top_bar #menu ul li ul li ul li a { padding: 0 40px 0 20px;}
	
	
		/* Header | Stack */
		
		.header-stack #Top_bar {}
		.header-stack .menu_wrapper a.responsive-menu-toggle { position: static !important; margin: 11px 0; }
		.header-stack .menu_wrapper #menu { left: 0; right: auto; }
		
		.rtl.header-stack #Top_bar #menu { left: auto; right: 0; }
	}

<?php endif; ?>
