/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* MAIN JAVASCRIPT 
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
(function($) {
    "use strict";
    /*---------------------------------------------------------
	** 
	** SIDEBAR FOR USERS
	**
	----------------------------------------------------------*/
    function UserSidebar() {
		if($("#user-sidebar").length >0 ){
    		var topbarHeight = $("#topbar").height(),
    		 menuHeight = $("#navbar").height(),
    		 sidebarTop = 0;
            if($("topbar").hasClass("topbar-closed")){
                sidebarTop = menuHeight + topbarHeight;
            }
            else{
                sidebarTop = menuHeight;
            }
    	    $("#user-sidebar").css("padding-top",sidebarTop);
        }
    }
    UserSidebar();
	$(".bp_is_active #user-thumb, #user-close").on("click",function(){
    	$("#nav-user, #user-sidebar").toggleClass("active");
    });
    /*---------------------------------------------------------
	** 
	** CUSTOM SCROLL BAR FOR WOFFICE
	**
	----------------------------------------------------------*/
    $(window).load(function(){
        $("body.menu-is-vertical #navigation").mCustomScrollbar({
        	axis:"y",
		    theme:"minimal"
		});
        if(window.matchMedia('(max-width: 992px)').matches || $('body').hasClass('force-responsive')) {
            $("body.menu-is-horizontal #navigation").mCustomScrollbar({
                axis:"y",
                theme:"minimal"
            });
        }
		$("#user-sidebar").mCustomScrollbar({
        	axis:"y",
		    theme:"minimal-dark"
		});
        if($("#woffice-minicart-top").length) {
            $("#woffice-minicart-top").mCustomScrollbar({
                axis:"y",
                theme:"minimal-dark"
            });
        }

    });
    /*---------------------------------------------------------
	** 
	** TOPBAR ALERT
	**
	----------------------------------------------------------*/
    $("#topbar-close").on("click",function(){
    	$("#topbar").slideUp("slow").addClass("topbar-closed");
    });
    /*---------------------------------------------------------
	** 
	** SEARCHBAR
	**
	----------------------------------------------------------*/
    $("#search-trigger").on("click",function(){
    	$("#main-search").slideToggle();
    	$('html,body').animate({ scrollTop: 0 }, 'fast');
        document.getElementById("s").focus();
        return false; 
    });
    /*---------------------------------------------------------
	** 
	** WOOCOMMERCE STUFF
	**
	----------------------------------------------------------*/
	/*CART*/
    $("#nav-buttons").on("click","#nav-cart-trigger.active", function(){
    	$(this).toggleClass("clicked");
    	$("#woffice-minicart-top").slideToggle();
    });
    /*SHORTCODE CAROUSEL*/
    // store the slider in a local variable
	var $window = $(window),
	flexslider_woo = null;
	// tiny helper function to add breakpoints
	function getGridSize() {
		return (window.innerWidth < 400) ? 1 :
			   (window.innerWidth < 600) ? 2 :
		       (window.innerWidth < 910) ? 3 : 4;
	}
	$window.load(function() {
		$('.flexslider > .woocommerce').flexslider({
		    animation: "slide",
			animationLoop: false,
			selector: ".products > li.product", 
			itemWidth: 210, 
			itemMargin: 0,
			controlNav: false,    
			move: 0, 
			slideshow: false,
			minItems: getGridSize(), // use function to pull in initial value
			maxItems: getGridSize(), // use function to pull in initial value
			start: function (slider) {
				flexslider_woo = slider; //Initializing flexslider here.
			}
		});
	});
	// check grid size on resize event
	$window.resize(function() {
		if ($('.flexslider > .woocommerce').length > 0) {
			var gridSize = getGridSize();
            if (flexslider_woo != null) {
                flexslider_woo.vars.minItems = gridSize;
                flexslider_woo.vars.maxItems = gridSize;
            }
		}
	});
    /*---------------------------------------------------------
	** 
	** BLOG Frontend Creation & Edit
	**
	----------------------------------------------------------*/
	/*Creation*/
	if ($('#blog-create').length > 0){
		$("#blog-create, #blog-loader").hide();
		$("#show-blog-create").on('click', function(){
	    	$('#blog-loader').slideDown();
		    $("#show-blog-create").hide();
		    function show_create_blog() {
		    	$("#blog-create").show();
				$('#blog-loader').slideUp();
			}
			setTimeout(show_create_blog, 1000);	    
		});
		$("#hide-blog-create").on('click', function(){
	    	$('#blog-loader').slideDown();
		    $("#blog-create").hide();
		    function hide_create_blog() {
		    	$("#show-blog-create").show();
				$('#blog-loader').slideUp();
			}
			setTimeout(hide_create_blog, 1000);	    
		});
	}
	/*Edit*/
	if ($('#blog-edit').length > 0){
		$("#blog-edit, #blog-loader").hide();
		$("#show-blog-edit").on('click', function(){
	    	$('#blog-loader').slideDown();
		    $("#show-blog-edit").hide();
		    function show_edit_blog() {
		    	$("#blog-edit").show();
				$('#blog-loader').slideUp();
			}
			setTimeout(show_edit_blog, 1000);	    
		});
		$("#hide-blog-edit").on('click', function(){
	    	$('#blog-loader').slideDown();
		    $("#blog-edit").hide();
		    function hide_edit_blog() {
		    	$("#show-blog-edit").show();
				$('#blog-loader').slideUp();
			}
			setTimeout(hide_edit_blog, 1000);	    
		});
	}
    /*---------------------------------------------------------
	** 
	** LANGUAGE SWITCHER
	**
	----------------------------------------------------------*/
    $("#nav-languages a").on("click",function(){
    	$("#nav-languages ul").slideToggle();
    });
    /*---------------------------------------------------------
	** 
	** PAGEHEADER
	**
	----------------------------------------------------------*/
    /*var fadeStart=50,fadeUntil=200,fading = $('#featuredbox .featured-background');
    $(window).bind('scroll', function(){
        var offset = $(document).scrollTop(),opacity=0;
        if( offset<=fadeStart ){
            opacity=1;
        }else if( offset<=fadeUntil ){
            opacity=1-offset/fadeUntil;
        }
        fading.css('opacity',opacity);
    });*/
   
    /*---------------------------------------------------------
	** 
	** SUBMENU & MEGAMENU
	**
	----------------------------------------------------------*/
    var edge_limit = $('#page-wrapper').width();
	$( "#main-menu li" ).each(function() {
		if ($(this).hasClass("menu-item-has-children")){
			var liheight = $(this).height();
			var submenu = $(this).find('.sub-menu');
			$(submenu).css('margin-top', '-'+(liheight)+'px');
		}
	});

	$(document).ready(function() {
		//var resizeTimeoutMenu;
	    // This will fire when document is ready:
	    $(window).resize(function() {

            check_force_responsive();

		    //clearTimeout(resizeTimeoutMenu);
            edge_limit = $('#page-wrapper').width();
		    if($(window).width() <= 992 || $('body').hasClass('force-responsive')) {
	
				//resizeTimeoutMenu = setTimeout(function(){   
					$('.main-menu > li.menu-item-has-children > a:first-child').not(".binded").addClass("binded").on("click",function(){
				    	$(this).toggleClass("mobile-menu-displayed");
						var parentContainer = $(this).parent("li");
                        if(parentContainer.hasClass('menu-item-has-mega-menu')) {
                            parentContainer.find('> .mega-menu').slideToggle();
                        } else {
                            parentContainer.find('> .sub-menu').slideToggle();
                        }
				    	return false;
				    });
				//}, 500);
			    
			}
			else {
			
				var timer;

				$('.main-menu li.menu-item-has-children:not(.menu-item-has-mega-menu)').on({
				    mouseenter: function(){
				        var self = this,
				        	submenu = $(self).find('> .sub-menu');
                            //linkheight = $(self).height(),
							//offset = submenu.offset().top - $(self).offset().top;

						submenu.addClass("display-submenu");

				        $(self).data('timeoutId', timer);
                        calculate_edge(this);

				    },
				    mouseleave: function(){

				        var self = this;
						var submenu = $(self).find('> .sub-menu');

						clearTimeout($(self).data('timeoutId'));
						submenu.removeClass("display-submenu");
                        $(self).removeClass('edge');

				        /*setTimeout(function(){
				        	if (!submenu.is(':hover')){
				            	submenu.removeClass("display-submenu");

				            	/*IF HAS THIRD MENU LEVEL WE CLOSE THE SECOND ONE TOO
				            	if(submenu.parents('.sub-menu').length > 0){
				            		var parentSubmenu = submenu.parents('.sub-menu');
				            		if (!parentSubmenu.is(':hover')){
					            		parentSubmenu.removeClass("display-submenu");
					            	}
				            	}*

				            }
				        }, 500);*/
				    }
				});
				
			}
		
		}).resize(); // This will simulate a resize to trigger the initial run.
	});
    
    /*MEGAMENU*/
    var timer;

    var col_width = 200;
    if(! $('body').hasClass('menu-is-horizontal')) {
        setTimeout(function(){
            $( "#main-menu li" ).each(function() {
                if ($(this).hasClass("menu-item-has-mega-menu")){
                    var liheight = $(this).innerHeight();
                    var megamenu = $(this).find('div.mega-menu');
                    $(megamenu).css('margin-top', '-'+(liheight)+'px');
                }
            });
        }, 2500);
        col_width = 180;
    }


    $('.main-menu > li.menu-item-has-mega-menu').on({
	    mouseenter: function(){
			// COUNT THE NUMBER OF COLUMN
			var megamenucontainer = $(this).find("div.mega-menu");
			var numberofrows = megamenucontainer.children("ul.mega-menu-row").length;
			// SIZE -> 180 per rows
			megamenucontainer.width(numberofrows*col_width + 20);
			// SHOW IT
	        clearTimeout(timer);
	        timer = setTimeout(function(){
				megamenucontainer.addClass('open animated');
			}, 0)
	    },
	    mouseleave: function(){
	        var megamenucontainer = $(this).find("div.mega-menu");
	        clearTimeout(timer);
	        timer = setTimeout(function(){
				megamenucontainer.removeClass('open');
			}, 0)
	    }
	});

    /**
     * Check if the submenu elements is placed over the window limit
     * @param who
     */
    function calculate_edge(who) {
        var elm = $(who).find('ul').first();
        if(elm.length) {
            var off = elm .offset(),
                l = off.left,
                w = elm.width(),
                isEntirelyVisible = (l+ w <= edge_limit);
                //console.log(l + ' + ' + w + ' <= ' + edge_limit);
            if ( ! isEntirelyVisible ) {
                $(who).addClass('edge');
            } else {
                $(who).removeClass('edge');
            }
        }
    }
    /*---------------------------------------------------------
	** 
	** TOOLTIPS
	**
	----------------------------------------------------------*/
	$(document).ready(function(){
    	$('[data-toggle="tooltip"]').tooltip();
    });
    /*---------------------------------------------------------
	** 
	** CHECKBOXES
	**
	----------------------------------------------------------*/
    $('#page-wrapper .wpcf7-checkbox input:checkbox,#page-wrapper .wpcf7-radio input:radio').change(function(){
        if($(this).is(":checked")) {
            $(this).parent("label").addClass("checked");
        } else {
            $(this).parent("label").removeClass("checked");
        }
    });
    /*---------------------------------------------------------
	** 
	** ISOTOP LAYOUT GROUPS & MEMBERS
	**
	----------------------------------------------------------*/
    $(window).load(function(){
    	var $list = null;
        setTimeout(function () {
            $list = $('#groups-list, #members-list').isotope({
              // options
              itemSelector: 'li',
              layoutMode: 'fitRows'
            });
        }, 1000);
		// init
		//$dashboard.isotope( 'on', 'arrangeComplete', function(){});
		$("#nav-trigger, #nav-sidebar-trigger").on('click',function(){
			setTimeout(function () {
				$list.isotope();
	        }, 1000);
		});
	});
    /*---------------------------------------------------------
	** 
	** DASHBOARD & Masonry Layout
	**
	----------------------------------------------------------*/
    /*$(window).load(function() {
		$('#dashboard-loader-container').fadeOut();
	});*/
	var $dashboard = $('#dashboard').isotope({
	  // options
	  itemSelector: '.widget',
	  layoutMode: 'masonry'
	});
	setTimeout(function () {	
		$dashboard.isotope();
    }, 200);

    var dashboard_interval = setInterval(function(){$dashboard.isotope()}, 3000);

    var $masonry = $('.masonry-layout').isotope({
	  // options
	  itemSelector: '.box',
	  layoutMode: 'masonry'
	});
	setTimeout(function () {	
		$masonry.isotope();
    }, 200);
    
    function RefreshLayoutJS() {
        $dashboard.isotope();
        $masonry.isotope();
        // fix ratios for resizing the calendar size
        $('.eventon_fullcal').each(function(){
            var cal_width = $(this).width();
            var strip = $(this).find('.evofc_months_strip');
            var multiplier = strip.attr('data-multiplier');

            if(multiplier<0){
                strip.width(cal_width*3).css({'margin-left':(multiplier*cal_width)+'px'});
            }
            $(this).find('.evofc_month').width(cal_width);
        });
    }
    
    // Run REfresh on several Event
	$("#dashboard").on('click', 'a.evcal_list_a, .widget a, p.evo_fc_day', function($dashboard,$masonry){
		RefreshLayoutJS();
	});
	$("#nav-trigger, #nav-sidebar-trigger").on('click', function($dashboard,$masonry){
		setTimeout(RefreshLayoutJS, 600);
	});
	$(document).ready(RefreshLayoutJS);
	$(window).on('resize',RefreshLayoutJS);
	 
	
    /*---------------------------------------------------------
	** 
	** FUNFACTS
	**
	----------------------------------------------------------*/
    $('.widget_woffice_funfacts .flexslider').flexslider({
		animation: "slide",
        animationLoop: true,
        slideshow: true,
        directionNav: false,
        selector: ".slides > li", 
        smoothHeight: false,
        start: function(){
	        $('.widget_woffice_funfacts .flexslider').resize();
	   }
	});
	$("#dashboard .widget a, #nav-trigger, #nav-sidebar-trigger").on('click',function(){
		setTimeout(function () {
			$('#dashboard .widget_woffice_funfacts .flexslider').flexslider();
        }, 2000);
	});
    /*---------------------------------------------------------
	** 
	**  SLIDER
	**
	----------------------------------------------------------*/
    $('#familiers .flexslider').flexslider({
        animation: "slide",
        animationLoop: true,
        selector: ".slides > li", 
        itemWidth: 80, 
        itemMargin: 0,
        controlNav: false,   
        directionNav: false, 
        minItems: 0,    
        move: 0, 
        slideshow: false
    });
    /*---------------------------------------------------------
	** 
	**  SCROLL TOP
	**
	----------------------------------------------------------*/
    $("#scroll-top").on("click",function(){
        //SCROLL TO TOP
        $('html, body').animate({
            scrollTop: $( $.attr(this, 'href') ).offset().top
        }, 500);
        return false;
    });
    /*---------------------------------------------------------
	** 
	** USER SIDEBAR SUBMENU
	**
	----------------------------------------------------------*/
    $("#user-sidebar nav ul li.menu-parent a, #user-sidebar #dropdown-user-menu li.menu-item-has-children a").bind('click', false);
    $("#user-sidebar nav ul li.menu-child a, #user-sidebar #dropdown-user-menu li.menu-item-has-children ul a").unbind('click', false);
    $("#user-sidebar nav ul li.menu-parent a, #user-sidebar #dropdown-user-menu li.menu-item-has-children a").on("click",function(){
        $(this).toggleClass("dropdownOn");
        $(this).parent("li").toggleClass("dropdownOn");
        $(this).parent("li").find('ul').slideToggle();
    });
    /*---------------------------------------------------------
	** 
	** LINK EFFECT MATERIAL DESIGN INSPIRED
	**
	----------------------------------------------------------*/
    var ink, d, x, y;
    $('#navbar a,.main-menu li > a, a.btn.btn-default, #content-container #buddypress button, #buddypress .button-nav li a,#main-content button[type="submit"], input[type="submit"], #user-sidebar nav ul li a, #buddypress #item-nav div.item-list-tabs ul li a, #woffice-login .login-submit input[type="submit"], #main-content input[type="button"],#learndash_next_prev_link a, #content-container .ssfa_fileup_wrapper span').on("click",function(e){
        if($(this).find(".material").length === 0){
            $(this).prepend("<span class='material'></span>");
        }
             
        ink = $(this).find(".material");
        ink.removeClass("animate");
         
        if(!ink.height() && !ink.width()){
            d = Math.max($(this).outerWidth(), $(this).outerHeight());
            ink.css({height: d, width: d});
        }
         
        x = e.pageX - $(this).offset().left - ink.width()/2;
        y = e.pageY - $(this).offset().top - ink.height()/2;
         
        ink.css({top: y+'px', left: x+'px'}).addClass("animate");
    });
    /*---------------------------------------------------------
	** 
	** NAVIGATION TRIGGER
	**
	----------------------------------------------------------*/
	var counter_menu = 0;
	$("a#nav-trigger").on("click",function() {
	    if ($("#main-content").hasClass("navigation-hidden")){
            showVerticalMenu(true);
			
			PageLayout();
	    }
	    else {
            hideVerticalMenu(true);
			
			PageLayout();
	    }
	});
    //MEDIA QUERIE
    check_force_responsive();

    $(document).ready(function(){
        ResponsiveMenu(true);

        //Fix the menu display onload
        setTimeout(function(){
            $("#navigation").removeClass("mobile-hidden");
        }, 600)
    });

	$(window).on('resize',function(){
        ResponsiveMenu(false);
    });

    function is_touch_device() {
        return 'ontouchstart' in window || navigator.maxTouchPoints;
    };

    function check_force_responsive() {
        if(is_touch_device() && window.matchMedia('(min-width: 993px)').matches)
            $('body').addClass('force-responsive');
    }

	function ResponsiveMenu(onready) {
        if (window.matchMedia('(max-width: 992px)').matches || $('body').hasClass('force-responsive')) {
            if(onready)
	       	    hideVerticalMenu();

			// We create a duplicate of the link
			if (!$('.main-menu').hasClass("menu-loop-happened")){
				$('.main-menu > li.menu-item-has-children').each(function(){
					var linkElement = $(this).find("> a");
					var submenuContainer = $(this).find("> ul.sub-menu");
					var linkElement_href = linkElement.attr('href');

                    if($(this).hasClass('menu-item-has-mega-menu')) {
                        submenuContainer = $(this).find(".mega-menu .sub-menu:first-child");
                    }
					var subElement = '<li class="menu-item mobile-submenu-link"><a href="'+linkElement_href+'" class="center"><i class="fa fa-arrow-right"></i></a></li>';
					submenuContainer.prepend(subElement);
				});
			}
			$('.main-menu').addClass("menu-loop-happened");
			
	    } else {
	    //if (window.matchMedia('(min-width: 993px)').matches && !($('body').hasClass('force-responsive'))) {
	       	$('.main-menu > li.menu-item-has-children').each(function(){
		       	$(this).find(".mobile-submenu-link").remove();
	       	});
			if (!$("#page-wrapper").hasClass("menu-is-closed")) {
                if(!$('body').hasClass('menu-is-horizontal')) {
                    showVerticalMenu();
                }
			}
	    }

        if($('body').hasClass('menu-is-horizontal')) {
            var nav_height = ($('#navbar').length > 0) ? $('#navbar').height() : 0;
            var adminbar_height = ($('#wpadminbar').length > 0) ? $('#wpadminbar').height() : 0;

            //$('#navigation').css('top', nav_height + adminbar_height);
        }
	}

    function hideVerticalMenu(handle_cookie) {
        // Icon class switching
        $("a#nav-trigger i").addClass("fa-bars");
        $("a#nav-trigger i").removeClass("fa-long-arrow-left");

        $("body, #navigation, #main-content, #main-header, #main-footer").addClass("navigation-hidden");

        if(handle_cookie) {
            // Create cookies to save user choice :
            Cookies.set('Woffice_nav_position', 'navigation-hidden', { expires: 7, path: '/' });
            Cookies.set('Woffice_nav_position_icon', 'fa-bars', { expires: 7, path: '/' });
        }
    }

    function showVerticalMenu(handle_cookie) {
        // Icon class switching
        $("a#nav-trigger i").removeClass("fa-bars");
        $("a#nav-trigger i").addClass("fa-long-arrow-left");

        if($(window).width() <= 450 && !$('#navbar').hasClass('has_fixed_navbar') && $("body").hasClass("menu-is-vertical")) {
            $("#navigation").css('top',  $('#wpadminbar').height() + $('#navbar').height() - $(window).scrollTop());
        }


        $("body,#navigation, #main-content, #main-header, #main-footer").removeClass("navigation-hidden");

        if(handle_cookie) {
            // ERASE COOKIES
            Cookies.remove('Woffice_nav_position', {expires: 7, path: '/'});
            Cookies.remove('Woffice_nav_position_icon', {expires: 7, path: '/'});
        }
    }
    /*---------------------------------------------------------
	** 
	** SIDEBAR ACTIONS
	**
	----------------------------------------------------------*/
	/*Function for the layout*/
	function PageLayout() {
		if($("#right-sidebar").length >0 ){
			
			// RIGHT SIDEBAR WIDTH
			var windowWidth = $(window).width();
			if ($("#main-content").hasClass("navigation-hidden") || $("body").hasClass("menu-is-horizontal")){
				var SidebarWidth = (.25 * windowWidth);
			} 
			else{
				var SidebarWidth = (.25 * windowWidth) - 23;
			}
			$("#right-sidebar").width(SidebarWidth);
			 
			$('#can-scroll').width(SidebarWidth);
			
		}
    }
    PageLayout();
	$(window).on('resize',PageLayout);
	
	/*SINCE 1.1.2*/
	/*SCROLL*/
	$('#can-scroll').hide();
	$(window).load(function(){
		if($("#right-sidebar").length >0 ){
			if($('#main-content').hasClass('sidebar-hidden')){
				$('#can-scroll').fadeOut('fast');
			} 
			else{
				if ($('#main-content').height() < $('#right-sidebar')[0].scrollHeight){
					$('#can-scroll').fadeIn('slow');
				}
			}
		}
	});
	$("#right-sidebar").mCustomScrollbar({
    	axis:"y",
	    theme:"minimal-dark",
	    mouseWheel:{ deltaFactor: 100 },
	    callbacks:{
	    	onInit:function(){
				$('#can-scroll').on("click",function(){
					if(!$('#main-content').hasClass('sidebar-hidden')){
						$('#can-scroll').show();
					}
					if($(this).hasClass('clicked')){
						$('#right-sidebar').animate({ scrollTop: 0 }, 1000);
						$(this).removeClass('clicked');
					} 
					else{
						$('#right-sidebar').animate({ scrollTop: $('#right-sidebar')[0].scrollHeight}, 1000);
						$(this).addClass('clicked');
					} 
				});
	    	},
	    	onTotalScroll:function(){
		    	$('#can-scroll').fadeOut('slow');
		    },
		    onTotalScrollBack:function(){
		    	$('#can-scroll').fadeIn();
		    },
		    onUpdate:function(){
		    	if ($('#main-content').height() >= $('#right-sidebar')[0].scrollHeight){
			    	$('#can-scroll').fadeOut('fast');
		    	}
		    }
		}
	});

    
    // IF THE COOKIE ALREADY EXISTS:
	if(Cookies.get('Woffice_sidebar_position')){
		$("#nav-sidebar-trigger").addClass("sidebar-hidden");
		// Main Layout changes 
		$("#main-content, #main-header, body").addClass("sidebar-hidden");
		// Icon Class
		$("#nav-sidebar-trigger i").addClass("fa-long-arrow-left");
		$("#nav-sidebar-trigger i").removeClass("fa-long-arrow-right");
		
		$('#can-scroll').fadeOut('fast');
	}
	// FOR THE DEFAULT POSITION 
	if ($("#main-content").hasClass("sidebar-hidden")){
	    $("#nav-sidebar-trigger i").addClass("fa-long-arrow-left");
		$("#nav-sidebar-trigger i").removeClass("fa-long-arrow-right");
	}
	//OTHERWISE
	$("#nav-sidebar-trigger").on("click",function() {
		if ($("#main-content").hasClass("sidebar-hidden")){
			// Icon class switching
	        $("#nav-sidebar-trigger i").removeClass("fa-long-arrow-left");
			$("#nav-sidebar-trigger i").addClass("fa-long-arrow-right");
			// Navbar Class
			$("#nav-sidebar-trigger").removeClass("sidebar-hidden");
			// Main Layout changes 
			$("#main-content, #main-header, body").removeClass("sidebar-hidden");
			// ERASE COOKIES
			Cookies.remove('Woffice_sidebar_position',{ expires: 7, path: '/' });
			Cookies.remove('Woffice_sidebar_position_icon',{ expires: 7, path: '/' });
			
			$('#can-scroll').fadeIn('fast');
		}
		else{
			// Icon class switching
	        $("#nav-sidebar-trigger i").addClass("fa-long-arrow-left");
			$("#nav-sidebar-trigger i").removeClass("fa-long-arrow-right");
			// Navbar Class
			$("#nav-sidebar-trigger").addClass("sidebar-hidden");
			// Main Layout changes 
			$("#main-content, #main-header, body").addClass("sidebar-hidden");
			// Create cookies to save user choice :
			Cookies.set('Woffice_sidebar_position', 'navigation-hidden', { expires: 7, path: '/' });
			Cookies.set('Woffice_sidebar_position_icon', 'fa-bars', { expires: 7, path: '/' });
			
			$('#can-scroll').fadeOut('fast');
		}
	});
    //MEDIA QUERIE
    $(document).ready(ResponsiveSidebar);
	$(window).on('resize',ResponsiveSidebar);
	function ResponsiveSidebar() {
	    if (window.matchMedia('(max-width: 992px)').matches || $('body').hasClass('force-responsive')) {
	        // Icon class switching
		    $("#nav-sidebar-trigger i").addClass("fa-long-arrow-left");
			$("#nav-sidebar-trigger i").removeClass("fa-long-arrow-right");
			// Navbar Class
			$("#nav-sidebar-trigger").addClass("sidebar-hidden");
			// Main Layout changes 
			$("#main-content, body").addClass("sidebar-hidden");
			
			$('#can-scroll').fadeOut('fast');
			
			// Horizontal menu responsive
			if ($("body").hasClass("menu-is-horizontal")) {
				
				$("#navigation").addClass("menu-responsive-horizontal");
				
				var switcher = $("#horizontal-menu-trigger").length;
				if (!switcher) {
					
					$("#navigation ul.main-menu").prepend('<li id="horizontal-menu-trigger-container"><a href="#" id="horizontal-menu-trigger"><i class="fa fa-bars"></i></a></li>');
				}
			}
	    }
	    else {
		    if($("#horizontal-menu-trigger-container").length > 0) {
                $("#horizontal-menu-trigger-container").remove();
		    }
	    }
	}
	
	$(document).ready(function(){
        $('.main-menu').on("click", "#horizontal-menu-trigger", function(){
            $("#navigation").toggleClass("menu-responsive-horizontal-show");
            $("body").toggleClass("navigation-hidden");
        });


        if($('#right-sidebar').length == 0 || $('#main-content').hasClass('sidebar-hidden'))
            $('body').addClass('sidebar-hidden');
	});
    /*---------------------------------------------------------
	** 
	** ANIMATED NUMBERS
	**
	----------------------------------------------------------*/	
	$('.animated-number h1').countTo({
    	speed: 4000,  
    });
})(jQuery);