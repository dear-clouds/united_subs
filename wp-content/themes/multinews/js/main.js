function mom_initiate_geolocation() {
    navigator.geolocation.getCurrentPosition(mom_handle_geolocation_query);
}

function mom_handle_geolocation_query(position){
    //alert('Lat: ' + position.coords.latitude + ' ' + 'Lon: ' + position.coords.longitude);

    jQuery.ajax({
        type: "post",
        url: momAjaxL.url,
        dataType: 'html',
        data: "action=mom_ajaxweather&nonce="+momAjaxL.nonce+"&lat="+position.coords.latitude+"&lon="+position.coords.longitude,
    success: function(data){
        if (data !== '') {
            jQuery('.weather-widget').replaceWith(data).hide().fadeIn();

            jQuery('.w-item-wrap').each( function() {
                var acc = jQuery(this);
                acc.find('.w-item-open').addClass('active');
                acc.find('.w-item-open').next('.w-item-content').show();
                acc.find('.w-item-close').removeClass('active');
                acc.find('.w-item-close').next('.w-item-content').hide();

                acc.find('.w-item-title').on('click',function() {
                    jQuery(this).toggleClass('active');
                    jQuery(this).next('.w-item-content').slideToggle();
                });
            });
        }

    }

    });
}

jQuery(document).ready(function($) {
"use strict";
// remove empty p
$('p')
.filter(function() {
return $.trim($(this).text()) === '' && $(this).children().length == 0
})
.remove();

//images
if (!( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) )) {
$('body.fade-imgs-in-appear .main-container img, body.fade-imgs-in-appear .sidebar img, body.fade-imgs-in-appear .secondary-sidebar img, body.fade-imgs-in-appear #footer img').addClass('disappear');
$('body.fade-imgs-in-appear .main-container img, body.fade-imgs-in-appear .sidebar img, body.fade-imgs-in-appear .secondary-sidebar img, body.fade-imgs-in-appear #footer img').one('inview', function(e, isInView, visiblePartX, visiblePartY) {
    if (visiblePartY == 'top') {
              $(this).addClass('appear');
    } else if (visiblePartY == 'bottom') {
             $(this).addClass('appear');
    } else {
            $(this).addClass('appear');

    }


});
}

$(window).resize(function() {
if ($(window).width() < 1000) {
        $('.both-sidebars-all .main-left .secondary-sidebar').appendTo('.both-sidebars-all .main-left');
} else {
        $('.both-sidebars-all .main-left .secondary-sidebar').prependTo('.both-sidebars-all .main-left');

}
});

if ( $(window).width() < 1000) {
$('.both-sidebars-all .main-left .secondary-sidebar').appendTo('.both-sidebars-all .main-left');
} else {
    $('.both-sidebars-all .main-left .secondary-sidebar').prependTo('.both-sidebars-all .main-left');

}


// automaitc weather since 2.2
if($('body').hasClass('automatic_weather')) {
if($.cookie('lat') == null && $.cookie('lon') == null) {
    mom_initiate_geolocation();
}
}

// widgetized sidebars
$('.wpb_widgetised_column').each(function() {
if ($(this).parents().hasClass('sidebar') || $(this).parents().hasClass('secondary-sidebar')) {
    $(this).removeClass('sidebar');
}
});

//visual composer
if($('.vc_main_col.main-content').length) {
$('.vc_main_col.main-content').parents('.vc_row.wpb_row').css({'margin-left':0, 'margin-right':0});
}
//mom cat links
$('.mom_cat_link').each(function() {
var t = $(this);
var link_color = t.find('a').css('color');
var bull_color = t.find('.mom_cats_color_bull').css('background-color');
t.hover(function() {
$(this).find('a').css('color', $(this).data('color'));
$(this).find('.mom_cats_color_bull').css('background-color', $(this).data('color'));
}, function() {
$(this).find('a').css('color', link_color);
$(this).find('.mom_cats_color_bull').css('background-color', bull_color);
});
});
// banners
$('a.tob_banner_close').on('click', function(e) {
$('.top_banner').slideUp(400);
e.preventDefault();
});

var tob_auto_close = $('.top_banner').data('timeout');

if (tob_auto_close !== '') {
setTimeout(function() {
    $('.top_banner').slideUp();
}, tob_auto_close*1000);
}

$('a.unav_banner_close').on('click', function(e) {
$('.unav_banner').slideUp(400);
e.preventDefault();
});

var unav_auto_close = $('.unav_banner').data('timeout');

if (unav_auto_close !== '') {
setTimeout(function() {
    $('.unav_banner').slideUp();
}, unav_auto_close*1000);
}
// smooth scroll
if ($('body').hasClass('smooth_scroll_enable')) {
$("html").niceScroll({
scrollspeed: 40,
background: '#f9f9f9',
autohidemode: false,
railpadding: { top: 1, right: 3, left: 3, bottom: 1 },
cursorwidth: "8px",
cursorcolor: "#c3c3c3",
cursorborder: "none",
cursorborderradius: "4px",
zindex:  100000,
});
}

//place holder
$('input:not(#tb-search)').each(function() {
$(this).data('holder', $(this).attr('placeholder'));

$('input:not(#tb-search)').focusin(function() {
    $(this).attr('placeholder', '');
});
$('input:not(#tb-search)').focusout(function() {
    $(this).attr('placeholder', $(this).data('holder'));
});
});
$('textarea').each(function() {
    $(this).data('holder', $(this).attr('placeholder'));

    $(this).focusin(function() {
        $(this).attr('placeholder', '');
    });
    $(this).focusout(function() {
        $(this).attr('placeholder', $(this).data('holder'));
    });

});

//HIDPI Images
var hidpi = window.devicePixelRatio > 1 ? true : false;
if (hidpi) {
// Replace img src with data-hidpi
$('img[data-hidpi]').each(function() {
    // If width x height hasn't been set, fill it in
    if ($(this).parents('.tab-content').length === 0) {
        /*
            if ($(this).attr('width') === undefined) {
            $(this).attr('width', $(this).width());
            }
            if ($(this).attr('height') === undefined) {
            $(this).attr('height', $(this).height());
            }
            */
    }
    //$(this).attr('src', $(this).data('hidpi'));
});
}
//feature slider
var fsw = $('.def-slider').width();
if (fsw > 650) {
$('.def-slider-wrap .def-slider-item a img').each(function() {
    $(this).attr('src', $(this).data('hidpi'));
});
}
if (jQuery(".alert-bar").length) {
$('.alert-bar').slideDown();

setTimeout(function() {
$('.alert-bar').slideUp().remove();
}, 5000);
}
//tabbed widget
if (jQuery(".widget_momizattabber").length) {
jQuery(".widget_momizattabber").each(function() {
    var ul = jQuery(this).find(".main_tabs ul.widget-tabbed-header");

    jQuery(this).find(".widget-tab").each(function() {
        jQuery(this).find('a.mom-tw-title').wrap('<li></li>').parent().detach().appendTo(ul);
    });
});
}

//widgets
$('.widget select, select#notifications-sort-order-list, select#members-friends, select#groups-sort-by, #members-order-by, #message-type-select, #activity-filter-by').wrap('<div class="mom-select"></div>')
// search
$('.top-search').click(function(e) {
$(this).toggleClass('active');
//$(this).next('.search-wrap').fadeToggle(250);
$(this).find('.search-dropdown').toggleClass('sw-show');
$(this).find('.search-dropdown').find('input').focus();
e.stopPropagation();

});
$('.search-dropdown').click(function(e) {
e.stopPropagation();
});

$('body').click(function(e) {
$('.top-search').removeClass('active');
$('.search-dropdown').removeClass('sw-show');
});


//Mobile Menus
if ($('.top_menu_handle').length) {
$('.top_menu_handle').toggle( function () {
    $(this).next('.mobile_top_nav').show();
    $(this).addClass('tmh_close');
}, function () {
    $(this).next('.mobile_top_nav').hide();
    $(this).removeClass('tmh_close');
});
}
//br
$('.brmenu').click(function(e) {
$(this).toggleClass('active');
//$(this).next('.search-wrap').fadeToggle(250);
$(this).next('.br-right').toggleClass('sw-show');
e.stopPropagation();

});
$('.br-right').click(function(e) {
e.stopPropagation();
});


$('body').click(function(e) {
$('.brmenu').removeClass('active');
$('.br-right').removeClass('sw-show');
});

//Login box
$('.brmenu .nav-button').click(function(e) {
$(this).toggleClass('active');
//$(this).next('.search-wrap').fadeToggle(250);
$(this).next('.nb-inner-wrap').toggleClass('sw-show');
e.stopPropagation();

});
$('.nb-inner-wrap').click(function(e) {
e.stopPropagation();
});

$('body').click(function(e) {
$('.brmenu .nav-button').removeClass('active');
$('.nb-inner-wrap').removeClass('sw-show');
});

//Sticky navigation
if ( $(window).width() > 1000 ) {
if ($('body').hasClass('sticky_navigation_on')) {
    var aboveHeight = $('#header-wrapper').outerHeight();
    var sl = $('#navigation').data('sticky_logo');
    var slw = $('#navigation').data('sticky_logo_width');
    var inw = $('#navigation').find('.inner').width();
     $('#navigation').find('.inner').css({'width': inw+'px', 'padding':0});
    $(window).scroll(function() {
        //if scrolled down more than the headerÕs height
        if ($(window).scrollTop() > aboveHeight) {
            // if yes, add ÒfixedÓ class to the <nav>
            // add padding top to the #content
            if ( $('#wpadminbar').length ) {
                $('#navigation').addClass('sticky-nav').css('top', '28px').next().css('padding-top', '52px');
            } else {
                $('#navigation').addClass('sticky-nav').css('top', '0').next().css('padding-top', '52px');
            }
            if (sl !== '') {
                $('.sticky_logo').show();
                $('#navigation > .inner').stop().animate({
                    'padding-left': (slw + 15) + 'px',
                }, 300);
                $('.rtl #navigation > .inner').stop().animate({
                    'padding-right': (slw + 15) + 'px',
                }, 300);
            }
        } else {

            // when scroll up or less than aboveHeight,
            $('#navigation').removeClass('sticky-nav').css('top', 0).next().css('padding-top', '0');
            if (sl !== '') {
                $('.sticky_logo').hide();
                $('#navigation > .inner').stop().animate({
                    'padding-left': 0,
                });
                $('.rtl #navigation > .inner').stop().animate({
                    'padding-right': 0,
                });
            }
        }
    });
}
}

//tabbed sort

$('.feature-tabbed').each(function() {
var t = $(this);
    t.find('.tabbed-sort li').click(function() {
        var layout = $(this).attr('class');
        $('.tabbed-sort li').removeClass('active');
        $(this).addClass('active');
        if (layout.indexOf("list") >= 0) {
            t.find('.f-tabbed-body ul').removeClass('f-tabbed-grid');
            t.find('.f-tabbed-body ul').addClass('f-tabbed-list');
        } else {
            t.find('.f-tabbed-body ul').addClass('f-tabbed-grid');
            t.find('.f-tabbed-body ul').removeClass('f-tabbed-list');
        }
        return false;

    });
});

//widget weather
$('.w-item-wrap').each( function() {
var acc = $(this);
acc.find('.w-item-open').addClass('active');
acc.find('.w-item-open').next('.w-item-content').show();
acc.find('.w-item-close').removeClass('active');
acc.find('.w-item-close').next('.w-item-content').hide();

acc.find('.w-item-title').on('click',function() {
    $(this).toggleClass('active');
    $(this).next('.w-item-content').slideToggle();
});
});
//category count
$('.sidebar li.cat-item, .sidebar .widget_archive li').each(function() {
var $contents = $(this).contents();
if ($contents.length > 1) {
    $contents.eq(1).wrap('<div class="cat_num"></div>');

    $contents.eq(1).each(function() {});
}
}).contents();
$('.sidebar li.cat-item .cat_num, .sidebar .widget_archive li .cat_num').each(function () {
$(this).html($(this).text().substring(2));
$(this).html( $(this).text().replace(/\)/gi, "") );
});

if ($('.sidebar li.cat-item').length) {
$('.sidebar li.cat-item .cat_num').each( function() {
    if ($(this).is(':empty')) {
        $(this).hide();
    }

});
}

$('.secondary-sidebar .widget_archive li, .secondary-sidebar .widget_categories li').html( function(idx, html) {
return html.replace(/(\d+)/g, ' $1 ');
});
$(".secondary-sidebar .widget_archive li a, .secondary-sidebar .widget_categories li a").each( function() {
this.href = this.href.replace(/\s/g,"");
});

//category sort
$('.cat-sort li').click(function() {
var layout = $(this).attr('class');
$('.cat-sort li').removeClass('active')
$(this).addClass('active');
if (layout.indexOf("list") >= 0) {
    $('.cat-body ul').removeClass('cat-grid');
    $('.cat-body ul').addClass('cat-list');
} else {
    $('.cat-body ul').addClass('cat-grid');
    $('.cat-body ul').removeClass('cat-list');
}
return false;

});
$(window).resize(function() {
if ($(window).width() < 568) {
    $('.cat-body ul').removeClass('cat-grid');
    $('.cat-body ul').addClass('cat-list');
}
});

if ( $(window).width() < 568) {
$('.cat-body ul').removeClass('cat-grid');
$('.cat-body ul').addClass('cat-list');
}

// Post share
if ($('.mom-share-buttons').length) {
$('.mom-share-buttons').data('height', $('.mom-share-buttons').css('height'));
var curHeight = $('.mom-share-buttons').height();
$('.mom-share-buttons').css('height', 'auto');
var autoHeight = $('.mom-share-buttons').height();
$('.mom-share-buttons').css('height', curHeight);
$('.mom-share-post .sh_arrow').toggle(function () {
    $('.mom-share-buttons').stop().animate({
        height: autoHeight
    }, 300);
    $(this).find('i').removeClass();
    $(this).find('i').addClass('fa-icon-double-angle-up');
}, function () {
    $('.mom-share-buttons').stop().animate({
        height: $('.mom-share-buttons').data('height')
    }, 300);
    $(this).find('i').removeClass();
    $(this).find('i').addClass('fa-icon-double-angle-down');
});
}


// expand post image
var imgH = $('.entry-content-data .post-thumbnail').outerHeight() + 20;
var pi_w = $('.entry-content-data .post-thumbnail').parent().parent().width() - 12;
$('.entry-content-data.has_f_image').css('padding-top', imgH + 'px');
$('.entry-content-data .post-thumbnail:not(.pt-zoom)').click(function() {
if (!$(this).hasClass('active') ) {
    $(this).animate({
        width: pi_w + 'px',
        left: 0,
    });
    $(this).addClass('active');
    $(this).find('desc').fadeOut();
} else {
    $(this).removeClass('active');
    $(this).find('desc').fadeIn();
    $(this).animate({
        width: '152px',
    });
}
});

//widget tabs
if ($("ul.widget-tabbed-header").length) {
$("ul.widget-tabbed-header:not(.mom-bp-tabbed-widgets)").momtabs("div.widget-tabbed-body > .widget-tab", {
    effect: 'fade'
});
}
// news box subcategories
$('.nb-tabbed-head .more-categories > a').click(function(e) {
var t = $(this);
if (t.hasClass('active')) {
    t.removeClass('active');
    t.parent().find('ul').hide();
} else {
    t.addClass('active');
    t.parent().find('ul').show();
}
e.preventDefault();
e.stopPropagation();
});

$('body').click(function(e) {
$('.nb-tabbed-head .more-categories > a').removeClass('active');
$('.nb-tabbed-head .more-categories ul').hide();

});
// get current time
var now = new Date();
$('.t-w-title .weather-date span').text(now.getHours() + ':' + now.getMinutes());

// units form
if ($('#units-form').length) {
$('#units-form input[type="radio"]').click(function() {
    $('#units-form').submit();
});
}

// Avanced search form Validate
$('#advanced-search [type="submit"]').click(function(e) {
var s = $(this).parent().find('input[name="s"]');
if (s.val() === '' ) {
    e.preventDefault()
    s.addClass('invalid');
    s.attr('placeholder', s.data('nokeyword'));
}
});

$('.media-sort-form #media-sort').change(function() {
$('#advanced-search').submit();
});

//Fix ajax search
$( ".ajax-search-results h4" ).prev().css( "border-bottom", "none" );

//social icons
if ($('ul.top-social-icon').length) {
$('ul.top-social-icon li').each(function () {
    var dataHover = $(this).attr('data-bghover');
    if (typeof dataHover !== 'undefined' && dataHover !== false) {
        var origBg = $(this).css('background');
        var hoverBg = $(this).data('bghover');
        $(this).hover(function() {
            $(this).css('background', hoverBg)
        }, function() {
            $(this).css('background', origBg)
        });
    }
});
}

//back to top
var offset = 220;
var duration = 500;
jQuery(window).scroll(function() {
if (jQuery(this).scrollTop() > offset) {
    jQuery('.toup').css({
        opacity: "1",
        display: "block",
    });
} else {
    jQuery('.toup').css('opacity', '0');
}
});

jQuery('.toup').click(function(event) {
event.preventDefault();
jQuery('html, body').animate({
    scrollTop: 0
}, duration);
return false;
})

//Category Menu
$('.mom-megamenu ul.sub-menu li').mouseenter(function() {
var id = $(this).attr('id');
var id = id.split('-');
//console.log(id[2]);
$(this).parent().find('li').removeClass('active');
$(this).addClass('active');
$(this).parent().next('.sub-mom-megamenu, .sub-mom-megamenu2').find('.mom-cat-latest').hide();
$(this).parent().next('.sub-mom-megamenu, .sub-mom-megamenu2').find('#mom-mega-cat-' + id[2]).show();
});

//Submenu auto align
$('ul.main-menu > li').each(function(e) {
var t = $(this),
submenu = t.find('.cats-mega-wrap');
if ( submenu.length > 0 ) {
    var offset = submenu.offset(),
    w = submenu.width();
    if ( offset.left + w > $(window).width() ) {
        t.addClass('sub-menu-left');
    } else {
        t.removeClass('sub-menu-left');
    }
}
});

//post share
$('.mom-share-buttons a:not(.share-email)').click(function(e) {
e.preventDefault();
})

// scroll to links
$('.story-highlights ul li a').click(function() {
$('html, body').animate({
    scrollTop: $('[name="' + $.attr(this, 'href').substr(1) + '"]').offset().top - 18
}, 800);
return false;
});


// Footer Mega Menu
var fm_count = $('.footer_mega_menu > li').length;
var item_width = 100 / fm_count;
$('.footer_mega_menu > li').css('width', item_width + '%');
//alert(fm_count);

//fix twitter widget
$('.twiter-list ul.twiter-buttons li a').click( function(e) {
e.preventDefault();
});

//Ads
if ($('.mca-fixed').length) {
var mca_top = $('.mca-fixed').offset().top;
var mca = $('.mca-fixed');
$(window).scroll(function() {
    if ($(window).scrollTop() > mca_top) {
        if ( $('#wpadminbar').length ) {
            mca.css({
                top: '28px',
                position: 'fixed'
            });
            mca.addClass('mca_touch_top');
        } else {
            mca.css({
                top: '0',
                position: 'fixed'
            });
            mca.addClass('mca_touch_top');
        }
    } else {
        mca.css({
            top: 'auto',
            position: 'absolute'
        });
        mca.removeClass('mca_touch_top');
    }
});
}

//$('.secondary-sidebar').stick_in_parent()

//Fix placeholder in IE9
var isInputSupported = 'placeholder' in document.createElement('input');
var isTextareaSupported = 'placeholder' in document.createElement('textarea');
if (!isInputSupported || !isTextareaSupported) {
$('[placeholder]').focus(function () {
    var input = $(this);
    if (input.val() == input.attr('placeholder') && input.data('placeholder')) {
        input.val('');
        input.removeClass('placeholder');
    }
}).blur(function () {
    var input = $(this);
    if (input.val() == '') {
        input.addClass('placeholder');
        input.val(input.attr('placeholder'));
        input.data('placeholder', true);
    } else {
        input.data('placeholder', false);
    }
}).blur().parents('form').submit(function () {
    $(this).find('[placeholder]').each(function () {
        var input = $(this);
        if (input.val() == input.attr('placeholder') && input.data('placeholder')) {
            input.val('');
        }
    })
});
}
/* ==========================================================================
*               braking
========================================================================== */
if ($('.breaking-cont .webticker').length) {
$('.breaking-cont .webticker').each( function() {
    var brtype = $(this).data('br_type');
    var brspeed = $(this).data('br_speed');
    var brbspeed = $(this).data('br_bspeed');
    var brduration = $(this).data('br_duration');
    if (brtype == 'default') {
        $('body:not(.rtl) .breaking-cont .webticker').liScroll({travelocity: brspeed});
        $('body.rtl .breaking-cont .webticker').liScrollRight({travelocity: brspeed});
       /*
        $('body:not(.rtl) .breaking-cont .webticker').marquee({
            pauseOnHover: true,
            duration: brspeed,
            duplicated: true
        });

        $('body.rtl .breaking-cont .webticker').marquee({
            pauseOnHover: true,
            duration: brspeed,
            direction: 'right',
        });
        */
    } else if(brtype == 'right') {
        $('.breaking-cont .webticker').newsTicker({
            row_height: 39,
            max_rows: 1,
            speed: brbspeed,
            direction: 'up',
            duration: brduration,
            autostart: 1,
            pauseOnHover: 1
        });
    } else if(brtype == 'fade') {
        $('.breaking-cont .webticker').owlCarousel({
            items: 1,
            loop: true,
            mouseDrag: false,
            autoplay: true,
            autoplayTimeout: brduration,
            autoplayHoverPause: true,
            animateOut: 'fadeOut'

        });
    }
});
}

/* ==========================================================================
*               Google maps
========================================================================== */
if ($('.mom_google_map').length) {
$('.mom_google_map').each( function() {
var id = $(this).attr('id');
var lat = $(this).data('lat');
var longi = $(this).data('long');
var color = $(this).data('color');
var zoom = $(this).data('zoom');
var pan = $(this).data('pan');
var controls = $(this).data('controls');
var marker_icon = $(this).data('marker_icon');
var marker_title = $(this).data('marker_title');
var marker_animation = $(this).data('marker_animation');
var sat = $(this).data('sat');
var info = $(this).data('marker_info');
var ani = '';
if (marker_animation == 'BOUNCE') {
  ani = google.maps.Animation.BOUNCE;
} else if(marker_animation == 'DROP') {
    ani = google.maps.Animation.BOUNCE;
}

function maps_init() {
    var styles = {
    'mommap':  [{
    "featureType": "administrative",
    "stylers": [
    { "visibility": "on" }
    ]
    },
    {
    "featureType": "road",
    "stylers": [
    { "visibility": "on" },
    { "hue": color }
    ]
    },
    {
    "elementType": "geometry",
    "stylers": [
    { "visibility": "simplified" },
    { "hue": color },
    {"weight": 1.1}
    ]
    },
    {
    "stylers": [
    { "visibility": "on" },
    { "hue": color },
    { "saturation": sat }
    ]
    }
    ]};

    var coord = new google.maps.LatLng(lat, longi);
    var options = {
    zoom: zoom,
        center: coord,
        //mapTypeId: google.maps.MapTypeId.ROADMAP,
        disableDefaultUI: true,
        mapTypeId: 'mommap',
        draggable: true,
        zoomControl: controls,
        panControl: pan,
        mapTypeControl: controls,
        scaleControl: controls,
        streetViewControl: controls,
        overviewMapControl: controls,
        scrollwheel: false,
        disableDoubleClickZoom: true
    }
var map = new google.maps.Map(document.getElementById(id), options);
var styledMapType = new google.maps.StyledMapType(styles['mommap'], {name: 'mommap'});
map.mapTypes.set('mommap', styledMapType);
 var contentString = '<div class"map-info-window"><p>'+info+'</p></div>';
  var infowindow = new google.maps.InfoWindow({
      content: contentString
  });

        var marker = new google.maps.Marker({
        position: coord,
        map: map,
        title:marker_title,
        icon: marker_icon,
        animation: ani
    });
if (info !== '') {
    google.maps.event.addListener(marker, 'click', function() {
      infowindow.open(map,marker);
    });
  }

    }
    google.maps.event.addDomListener(window, 'load', maps_init);
    google.maps.event.addDomListener(window, 'resize', maps_init);


});
}
/* ==========================================================================
*               Homepage blocks
========================================================================== */
if ($('.def-slider-wrap').length) {
$('.def-slider-wrap').each( function() {
    var rtl = $(this).data('srtl');
    var animate_out = $(this).data('animate_out');
    var animate_in = $(this).data('animate_in');
    var autoplay = $(this).data('autoplay');
    var timeout = $(this).data('timeout');
    var bull_event = $(this).data('bullets_event');
$(this).owlCarousel({
    animateOut: animate_out,
    animateIn: animate_in,
    autoplay: autoplay,
    autoplayTimeout: timeout,
    autoplayHoverPause:false,
    autoHeight:true,
    rtl: rtl,
    loop: true,
    items:1,
    nav: true,
     navText: ['<span class="enotype-icon-arrow-left7"></span>',
        '<span class="enotype-icon-uniE6D8"></span>'
    ],
    smartSpeed:1000,
    lazyLoad : true,
    //dotData:true,
});

});
}
//Cat slider
$('.cat-slider-wrap').show();
if ($('.feature-cat-slider').length) {
$('.cat-slider-wrap').each( function() {
var cat_timeout = $(this).data('cat_timeout');
$(this).cycle({
fx:     'fade',
pager:  '.cat-slider-nav ul',
next: '.fc_next',
prev: '.fc_prev',
timeout: cat_timeout,
pagerAnchorBuilder: function(idx, slide) {
    // return selector string for existing anchor
    return '.cat-slider-nav ul li:eq(' + idx + ')';
},
after: function(el, next_el) {
    $(next_el).addClass('active');
},
timeoutFn: function(el, next_el) {
    $(next_el).addClass('active');
    return cat_timeout;
},
onPagerEvent: function(i, se) {
  $(se).addClass('active');
},
before: function(el) {
    $(el).removeClass('active');
}

});

$(".cat-slider-nav").niceScroll({
    horizrailenabled: false,
});
});
}

//scroller
if ($('.scroller-wrap-1').length) {
$('.scroller-wrap-1').each( function() {
    var scauto = $(this).data('sc-auto');
    var scautotime = $(this).data('sc-autotime');
    var scspeed = $(this).data('sc-speed');
    var scrtl = $(this).data('sc-rtl');
    var items = $(this).data('items');
    var r1 = 3;
    var r2 = 2;
    if (items < r1) {
        r1 = items;
    }
    if (items < r2) {
        r2 = items;
    }

    $(this).owlCarousel({
        autoplay: scauto,
        autoplayTimeout: scautotime,
        slideSpeed : scspeed,
        rtl: scrtl,
        autoplayHoverPause: true,
        items : items,
        lazyLoad : true,
        navigation : true,
        margin: 1,
        nav:true,
        responsiveClass:true,
        responsive:{
        1000:{
          items:items
        },

        671:{
          items:r1
        },

        480:{
          items:r2
        },

        320:{
          items:1
        }
    }
    });

});
}

//scroller2
if ($('.scroller-wrap-2').length) {
$('.scroller-wrap-2').each( function() {
    var sc2auto = $(this).data('sc2-auto');
    var sc2autotime = $(this).data('sc2-autotime');
    var sc2speed = $(this).data('sc2-speed');
    var sc2rtl = $(this).data('sc2-rtl');
    var items = $(this).data('items');
    var r1 = 3;
    var r2 = 2;
    if (items < r1) {
        r1 = items;
    }
    if (items < r2) {
        r2 = items;
    }
    $(this).owlCarousel({
        autoplay: sc2auto,
        autoplayTimeout: sc2autotime,
        slideSpeed : sc2speed,
        rtl: sc2rtl,
        autoplayHoverPause: true,
        items : items,
        lazyLoad : true,
        //navigation : true,
        //loop:true,
        margin: 0,
        nav:true,
        responsiveClass:true,
        responsive:{
        1157: {
            items: items
        },
        1156:{
          items:items
        },

        671:{
          items:r1
        },

        480:{
          items:r2
        },

        320:{
          items:1
        }
    }
    });

});
}

// double tab on navigation
if(( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) )) {
$('#navigation .main-menu > li.menu-item-has-children').doubleTapToGo();
}


// Responsive menus
$('.top-menu-holder').click(function() {
    $('.top-menu').slideToggle();
    $(this).toggleClass('active');
});
$( window ).resize(function() {
if($( window ).width() >= 1000) {
$(".top-menu").show();
}
else {
$(".top-menu").hide();
}
});

$('.device-menu-holder').click(function() {
console.log('clicked');
if ($(this).hasClass('active')) {
    $('.device-menu li').each(function() {
        if ($(this).find('.mom_mega_wrap').length !== 0) {} else {
            $(this).find('.sub-menu').slideUp(400, function() {
                $(this).find('.sub-menu').addClass('hidden_item');
                $(this).find('.sub-menu').show();
            });
        }
    });
    $('.device-menu').find('.dm-active').removeClass('dm-active');
    $('.device-menu').find('.mom_custom_mega').slideUp(400, function() {
        $('.device-menu').find('.mom_custom_mega').addClass('hidden_item');
        $('.device-menu').find('.mom_custom_mega').show();
    });
}
$('.device-menu').slideToggle();
$(this).toggleClass('active');
});

$('.device-menu > li > .responsive-caret').parent().children('a').add('.device-menu > li > .responsive-caret').click(function(e) {
if (!$(this).parent().hasClass('dm-active')) {
    e.preventDefault();
}

var li = $(this).parent();
if (li.hasClass('dm-active') || li.find('.dm-active').length !== 0 || li.find('.sub-menu').is(':visible') || li.find('.mom_custom_mega').is(':visible') ) {
    li.removeClass('dm-active');
    li.children('.sub-menu').slideUp(400, function() {
        li.children('.sub-menu').addClass('hidden_item');
        li.children('.sub-menu').show();
    });
    if (li.find('.mom_mega_wrap').length === 0) {
        li.find('.sub-menu').slideUp(400, function() {
            li.find('.sub-menu').addClass('hidden_item');
            li.find('.sub-menu').show();
        });
    }
    if (li.hasClass('mom_default_menu_item') || li.find('.cats-mega-wrap').length !== 0) {
        li.find('.sub-menu').slideUp(400, function() {
            li.find('.sub-menu').addClass('hidden_item');
            li.find('.sub-menu').show();
        });
        li.find('.mom-megamenu').slideUp(400, function() {
            li.find('.mom-megamenu').addClass('hidden_item');
            li.find('.mom-megamenu').show();
        });
        li.find('.sub-mom-megamenu').slideUp(400, function() {
            li.find('.sub-mom-megamenu').addClass('hidden_item');
            li.find('.sub-mom-megamenu').show();
        });
        li.find('.sub-mom-megamenu2').slideUp(400, function() {
            li.find('.sub-mom-megamenu2').addClass('hidden_item');
            li.find('.sub-mom-megamenu2').show();
        });
    }
    li.find('.dm-active').removeClass('dm-active');
    if (li.find('.mom_custom_mega').length !== 0) {
        li.find('.mom_custom_mega').slideUp(400, function() {
            li.find('.mom_custom_mega').addClass('hidden_item');
            li.find('.mom_custom_mega').show();
        });
    }

} else {
    $('.device-menu').find('.dm-active').removeClass('dm-active');
    li.addClass('dm-active');
    li.children('.sub-menu').removeClass('hidden_item').slideDown();
    if (li.find('.cats-mega-wrap').length !== 0) {
        li.find('.sub-menu').removeClass('hidden_item').slideDown();
        li.find('.mom-megamenu').removeClass('hidden_item').slideDown();
        li.find('.sub-mom-megamenu').removeClass('hidden_item').slideDown();
        li.find('.sub-mom-megamenu2').removeClass('hidden_item').slideDown();
    }
    if (li.find('.mom_custom_mega').length !== 0) {
        li.find('.mom_custom_mega').removeClass('hidden_item').slideDown();
    }

}
});
$('.the_menu_holder_area').html($('.device-menu').find('.current-menu-item').children('a').html());

//media page css problem (Very temp)
$(window).resize(function() {
if ($(window).width() > 1024) {
    $('.media-items-list #m-items').each(function(i) {
        var modulus = (i) % 4;
        if (modulus === 0) {
            $(this).css('clear', 'left');
        }
    });
}
});
if ($(window).width() > 1024) {
$('.media-items-list #m-items').each(function(i) {
    var modulus = (i) % 4;
    if (modulus === 0) {
        $(this).css('clear', 'left');
    }
});
}

}); // End Of File

jQuery(document).ready(function($) {

// ad clicks
jQuery(".mom-ad").mousedown( function(e) {
t = jQuery(this);
id = t.data('id');
jQuery.ajax({
    type: "post",
    url: momAjaxL.url,
    dataType: 'html',
    data: "action=mom_mom_adclicks&nonce=" + momAjaxL.nonce + "&id=" + id,
    beforeSend: function() {},
    success: function() {}
});
});

//Momizat Timeline
$('.blog-timeline-more').click(function(e) {
e.preventDefault();
var t = $(this);
var offset = t.data('offset');
var author = t.data('author');
var count = t.data('count');
var excat = t.data('excat');
var display = t.data('display');
var cats = t.data('cats');
var order = t.data('order');
jQuery.ajax({
    type: "post",
    url: momAjaxL.url,
    dataType: 'html',
    data: "action=mom_timeline&nonce=" + momAjaxL.nonce + "&offset=" + offset + "&count=" + count + "&author=" + author + "&excat=" + excat + "&display=" + display + "&cats=" + cats + "&order=" + order,
    beforeSend: function() {},
    success: function(data) {
        t.before(data);
        if (data === '') {
            t.text(momAjaxL.nomore);
        }
    }
});
t.data('offset', offset + count);
//console.log(t.data('offset'));
});

//Momizat categories mega menu
$('.mom-megamenu.cats-mega-wrap > ul > li').on('mouseenter', function(e) {
e.preventDefault();
var t = $(this);
var tid = t.attr('id');
tid = tid.split('-');
tid = tid[2];
var d = t.parent().next('.sub-cat-megamenu').find('#mom-mega-cat-' + tid);
var dest = t.parent().next('.sub-cat-megamenu').find('#mom-mega-cat-' + tid + ' > ul');
var id = d.data('id');
var object = d.data('object');
var layout = d.data('layout');
if (dest.children().length === 0) {
    jQuery.ajax({
        type: "post",
        url: momAjaxL.url,
        dataType: 'html',
        data: "action=mmcl&nonce=" + momAjaxL.nonce + "&id=" + id + "&object=" + object + "&layout=" + layout,
        beforeSend: function() {
            dest.addClass('mn-load');
        },
        success: function(data) {
            dest.removeClass('mn-load');
            dest.html(data);
        }
    });
}
});

// responsive videos
$('.video_frame').each(function(index, el) {
	var t = $(this);
	var w = t.width();
	var h = w/16;
	h = h*9;

	t.find('iframe').css('height', h+'px');

});
window.onresize = function(event) {
$('.video_frame').each(function(index, el) {
	var t = $(this);
	var w = t.width();
	var h = w/16;
	h = h*9;

	t.find('iframe').css('height', h+'px');

});
};

$('.entry-content .video_frame iframe').each(function(index, el) {
	var t = $(this);
	var w = t.width();
	var h = w/16;
	h = h*9;

	t.css('height', h+'px');

});
window.onresize = function(event) {
$('.entry-content .video_frame iframe').each(function(index, el) {
	var t = $(this);
	var w = t.width();
	var h = w/16;
	h = h*9;

	t.css('height', h+'px');

});
};

/*-------------------------------
Lightbox init
------------------------------- */

function mom_detect_mobile() {
if( navigator.userAgent.match(/Android/i)
|| navigator.userAgent.match(/webOS/i)
|| navigator.userAgent.match(/iPhone/i)
|| navigator.userAgent.match(/iPad/i)
|| navigator.userAgent.match(/iPod/i)
|| navigator.userAgent.match(/BlackBerry/i)
|| navigator.userAgent.match(/Windows Phone/i)
){
return true;
}
else {
return false;
}
}

function scroll_to_item (el) {
if (mom_detect_mobile() === true) {
return;
}

jQuery("html, body").stop();

var destination = el.offset().top;
destination = destination - 220;

jQuery("html, body").animate({ scrollTop: destination }, {
    duration: 1000,
}
);
}
$('body.open_images_in_lightbox a').each(function() {
if(/\.(?:jpg|jpeg|gif|png)$/i.test($(this).attr('href'))){
    if (!$(this).parents().hasClass('mom_images_grid') && !$(this).parents().hasClass('essb_links_list')) {
        $(this).addClass('lightbox-img');
    }
}
});

var last_scrolling_item = '';
/*--------------------
article image
---------------------*/
$('.main-container').magnificPopup({
delegate: 'a.lightbox-img',
type: 'image',
closeOnContentClick: true,
closeBtnInside: true,
mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
gallery: {
  enabled: true
},
image: {
    verticalFit: true,
    titleSrc: function(item) {//console.log(item.el);
            var caption = jQuery(item.el).parent().find('.wp-caption-text').text();
            if (typeof caption != "undefined") {
                return caption;
            } else {
                return '';
            }
        }
},
iframe: {
markup: '<div class="mfp-iframe-scaler">'+
    '<div class="mfp-close"></div>'+
    '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
  '</div>', // HTML markup of popup, `mfp-close` will be replaced by the close button

patterns: {
youtube: {
index: 'youtube.com/', // String that detects type of video (in this case YouTube). Simply via url.indexOf(index).

id: 'v=', // String that splits URL in a two parts, second part should be %id%
// Or null - full URL will be returned
// Or a function that should return %id%, for example:
// id: function(url) { return 'parsed id'; }

src: '//www.youtube.com/embed/%id%?autoplay=1' // URL that will be set as a source for iframe.
},
vimeo: {
index: 'vimeo.com/',
id: '/',
src: '//player.vimeo.com/video/%id%?autoplay=1'
},
gmaps: {
index: '//maps.google.',
src: '%id%&output=embed'
}

// you may add here more sources

},

srcAction: 'iframe_src', // Templating object key. First part defines CSS selector, second attribute. "iframe_src" means: find "iframe" and set attribute "src".
},
zoom: {
    enabled: true,
    duration: 300 // don't foget to change the duration also in CSS
},
  callbacks: {
    change: function(item) {
        scroll_to_item(item.el);
        last_scrolling_item = item.el;

    },
    beforeClose: function() {
       scroll_to_item(last_scrolling_item);
    }
  }
});
/*--------------------
Gallery images
---------------------*/
$('.mom_images_grid, .gallery').magnificPopup({
delegate: 'a',
type: 'image',
closeOnContentClick: true,
closeBtnInside: true,
mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
gallery: {
  enabled: true
},
image: {
    verticalFit: true,
    titleSrc: 'data-title'
},
zoom: {
    enabled: true,
    duration: 300 // don't foget to change the duration also in CSS
},
  callbacks: {
  }
});

}); // end document ready


// Momizat User rate
jQuery(document).ready(function($) {
$(".mom_user_rate").mousemove(function(e){
//if(clicking == false) return;

var style = $(this).data('style');
var units = $(this).data('units');
var thisOffset = $(this).offset();
//or $(this).offset(); if you really just want the current element's offset
var relX = e.pageX - thisOffset.left;
var relY = e.pageY - thisOffset.top;
if (!$(this).hasClass('rated')) {
var percent = relX/parseFloat($(this).width())*100;
var score = Math.round(percent);
if (score > 100) {
score = 100;
}
var starts = (score/20).toFixed(1);
if (style === 'bars') {
$(this).find('.ub-inner').css({width: score+'%' });
if (units === 'points') {
$(this).find('.ub-inner').find('span').text(score/10);
} else {
$(this).find('.ub-inner').find('span').text(score+'%');
}
} else if (style === 'circles') {

} else {
$(this).children('span').css({width: (score+1)+'%' });
}
//$(this).next('.mom_user_rate_score').children('span').text(score/20);
if ($(this).hasClass('star-rating')) {
 $(this).parent().find('.yr').text(starts+'/5');
}
}
});


// show your user rate
$(".mom_user_rate, .mom_user_rate_cr").hover( function() {
if (!$(this).hasClass('rated')) {
$('.review-footer .mom_user_rate_title').find('.user_rate').hide();
$('.review-footer .mom_user_rate_title').find('.your_rate').show();
}

}, function() {
if (!$(this).hasClass('rated')) {
$('.mom_user_rate_title').find('.user_rate').show();
$('.mom_user_rate_title').find('.your_rate').hide();
}
});

$(".mom_user_rate").click(function(){

stars = jQuery(this);
post_id = stars.data("post_id");
style = stars.data("style");
        score = 0;
        if (style === 'stars') {
score = parseFloat(stars.children('span').width())/parseFloat($(this).width())*100;
        }
        if (style === 'bars') {
score = parseFloat(stars.children('.ub-inner').width())/parseFloat($(this).width())*100;
        }
score = Math.round(score);
        vc = stars.data("votes_count");
if (!$(this).hasClass('rated')) {

jQuery.ajax({
    type: "post",
    url: momAjaxL.url,
    data: "action=user-rate&nonce="+momAjaxL.nonce+"&user_rate=&post_id="+post_id+"&user_rate_score="+score,
    success: function(rate){
        if(rate != "already")
        {
            stars.addClass('rated');
            $('.review-footer .mom_user_rate_title').find('.user_rate').hide();
            $('.review-footer .mom_user_rate_title').find('.your_rate').show();
                                $('.review-footer .total-votes').find('.tv-count').text(vc+1);
        }
            //alert(score);
    }
});
}
})

//Circles
if ($('.mom-reveiw-system').length) {
$(".urc-value").knob({
displayInput: false,
change: function (value) {
//console.log("changed to: " + value);
$('.user-rate-circle').find('.cru-num').text(value);
},
release: function (value) {
    circle = jQuery('.user-rate-circle .mom_user_rate_cr');
post_id = circle.data("post_id");
style = circle.data("style");
score = value;
        vc = circle.data("votes_count");

jQuery.ajax({
    type: "post",
    url: momAjaxL.url,
    data: "action=user-rate&nonce="+momAjaxL.nonce+"&user_rate=&post_id="+post_id+"&user_rate_score="+score,
    success: function(rate){
        if(rate != "already")
        {
            circle.addClass('rated');
            $('.review-footer .mom_user_rate_title').find('.user_rate').hide();
            $('.review-footer .mom_user_rate_title').find('.your_rate').show();
                                $('.review-footer .total-votes').find('.tv-count').text(vc+1);

        }

            //alert(score);
    }
});
}
});
}

// set and get posts views with ajax
if ($('body').hasClass('post_views_with_ajax')) {
if ($('body').hasClass('single')) {
            jQuery.ajax({
                type: "post",
                url: momAjaxL.url,
                dataType: "html",
                data: "action=mom_set_post_views&nonce=" + momAjaxL.nonce + "&id=" + momAjaxL.postid,
                beforeSend: function() {},
                success: function(e) {
                }
            })

}

$('.post.blog-post').each(function (i, el) {
    var t = $(el);
    var v = t.find('.post-views');
    var id = t.attr('data-id');
    if (typeof id === 'undefined') {
        id = t.attr('id').split('-');
        id = id[1];
    }
    if (v.length) {
    jQuery.ajax({
            type: "post",
            url: momAjaxL.url,
            dataType: "html",
            data: "action=mom_post_views&nonce=" + momAjaxL.nonce + "&id=" + id+ "&echo=" + 1,
            beforeSend: function() {},
            success: function(e) {
                s = v.find('span');
                v.fadeIn();
                v.html(e);
                v.prepend(s);
            }
        });
    }
});
}


});

//ajax
jQuery(document).ready(function() {
jQuery(".mom-search-form input.sf").on("keyup", function() {
return sf = jQuery(this), term = sf.val(), term.length > 2 ? setTimeout(function() {
    jQuery.ajax({
        type: "post",
        url: momAjaxL.url,
        dataType: "html",
        data: "action=mom_ajaxsearch&nonce=" + momAjaxL.nonce + "&term=" + term,
        beforeSend: function() {
            sf.parent().find(".sf-loading").fadeIn()
        },
        success: function(e) {
            "" !== sf.val() ? (sf.parent().next(".ajax-search-results").html(e), "" !== e ? sf.parent().next(".ajax-search-results").append('<h4 class="show-all-results"><a href="' + momAjaxL.homeUrl + "/?s=" + term + '">' + momAjaxL.viewAll + '<i class="fa-icon-long-arrow-right"></i></a></h4>') : (sf.parent().next(".ajax-search-results").find("show_all_results").remove(), sf.parent().next(".ajax-search-results").html('<span class="sw-not_found">' + momAjaxL.noResults + "</span>"))) : sf.parent().next(".ajax-search-results").html(""), sf.parent().find(".sf-loading").fadeOut()
        }
    })
}, 300) : setTimeout(function() {
    jQuery.ajax({
        type: "post",
        url: momAjaxL.url,
        dataType: "html",
        data: "action=mom_ajaxsearch&nonce=" + momAjaxL.nonce + "&term=" + term,
        success: function() {
            "" === sf.val() && sf.parent().next(".ajax-search-results").html("")
        }
    })
}, 300), !1
})
}), jQuery(document).ready(function(e) {
offset = '';
jQuery(".media-tabs li a").on("click", function() {
return t = jQuery(this).parent(), type = t.data("type"), count = t.parent().data("count"), jQuery.ajax({
    type: "post",
    url: momAjaxL.url,
    dataType: "html",
    data: "action=mom_media_tab&nonce=" + momAjaxL.nonce + "&type=" + type + "&count=" + count,
    beforeSend: function() {
        t.parent().parent().parent().append('<i class="nb-load"></i>')
    },
    success: function(a) {
        "" !== a && (e(".media-page-content").html(a), e(".media-tabs > li").removeClass("active"), t.addClass("active")), t.parent().parent().parent().find(".nb-load").remove();
         offset = e('.media-show-more > a.show-more-posts').data('offset', e('.media-show-more > a.show-more-posts').data('count'));
         e('.media-show-more').show();
    }
}), !1
}),  jQuery(".media-show-more > a.show-more-posts").on("click", function() {
return t = jQuery(this), offset = t.data("offset"), count = t.data("count"), type = e('.media-tabs > li.active').data("type"), jQuery.ajax({
    type: "post",
    url: momAjaxL.url,
    dataType: "html",
    data: "action=mom_media_tab&nonce=" + momAjaxL.nonce + "&type=" + type + "&count=" + count + "&offset=" + offset,
    beforeSend: function() {
        t.parent().parent().append('<i class="nb-load"></i>')
    },
    success: function(a) {
        if (a !== '') {
            e(".media-page-content").html(a);
        } else {
            t.parent().hide();
        }
         t.parent().parent().find(".nb-load").remove();
    }
}), t.data('offset', offset+count), !1

}), jQuery("#media-sort").on("change", function() {
return order = jQuery(this).val(), type = jQuery(this).parent().parent().siblings().find("li.active").data("type"), count = jQuery(this).parent().parent().siblings().find("li.active").parent().data("count"), jQuery.ajax({
    type: "post",
    url: momAjaxL.url,
    dataType: "html",
    data: "action=mom_media_tab&nonce=" + momAjaxL.nonce + "&type=" + type + "&order=" + order + "&count=" + count,
    beforeSend: function() {},
    success: function(t) {
        "" !== t && e(".media-page-content").html(t);

         offset = e('.media-show-more > a.show-more-posts').data('offset', e('.media-show-more > a.show-more-posts').data('count'));
                        e('.media-show-more').show();
    }
}), !1
})
}), jQuery(document).ready(function(e) {
offset = "", offset_rest = "", offset_sec = "", jQuery(".section footer.show_more_ajax a").click(function(e) {
e.preventDefault(), bt = jQuery(this), where = bt.parent().prev(), nbs = bt.parent().data("nbs"),display = bt.parent().data("display"),tag = bt.parent().data("tag"), nop = bt.parent().data("number_of_posts"), norder = bt.parent().data("orderby"), post_type = bt.data("post_type"), offset = bt.data("offset"), nb_excerpt = bt.parent().data("nb_excerpt"), ("nb2" == nbs || "nb4" == nbs || "nb5" == nbs) && (offset_rest = offset + 1), "nb3" == nbs && (offset_sec = offset + 1, offset_rest = offset + 2), cat = bt.parent().parent().find(".nb-tabbed-head").find("li.active a").data("cat_id"), ("" === cat || void 0 === cat) && (cat = bt.parent().data("cat_id")), jQuery.ajax({
    type: "post",
    url: momAjaxL.url,
    dataType: "html",
    data: "action=nbsm&nonce=" + momAjaxL.nonce + "&cat=" + cat + "&nbs=" + nbs + "&number_of_posts=" + nop + "&orderby=" + norder + "&offset=" + offset + "&offset_all=" + offset_rest + "&offset_second=" + offset_sec + "&nb_excerpt=" + nb_excerpt + "&post_type=" + post_type + "&tag=" + tag + "&display=" + display,
    beforeSend: function() {
        where.parent().append('<i class="nb-load"></i>')
    },
    success: function(e) {
        "" == e && bt.parent().append('<a class="nomoreposts">' + momAjaxL.nomore + "</a>").hide().fadeIn(), "" !== e && where.html(e), where.parent().find(".nb-load").remove()
    },
    complete: function() {}
}), ("nb1" == nbs || "list" == nbs) && bt.data("offset", offset + nop), "nb2" == nbs && bt.data("offset", offset + nop + 1), "nb3" == nbs && bt.data("offset", offset + nop + 2), ("nb4" == nbs || "nb5" == nbs) && bt.data("offset", offset + nop + 1), "nb6" == nbs && bt.data("offset", offset + nop), console.log(post_type)
}), jQuery(".nb-tabbed-head li a:not(.more_categories_handle)").click(function(t) {
t.preventDefault();
{
    var a = e(this), n = (a.parents('.nb-tabbed-head'), e(this).parents('.nb-tabbed-head').parent().next()), s = a.parents('.nb-tabbed-head').data("nbs");
    a.parents('.nb-tabbed-head').data("number_of_posts"), a.parents('.nb-tabbed-head').data("orderby")
}
n.parent().find(".show-more").find(".nomoreposts").remove(), origoff = n.parent().find(".show-more").find("a").data("orig-offset"), n.parent().find(".show-more").find("a").data("offset", origoff), ("nb2" == s || "nb4" == s || "nb5" == s) && (offset_rest = n.parent().find(".show-more").find("a").data("offset") + 1), "nb3" == s && (offset_sec = n.parent().find(".show-more").find("a").data("offset") + 1, offset_rest = n.parent().find(".show-more").find("a").data("offset") + 2)//, console.log(n.parent().find(".show-more").find("a").data("offset"))//, console.log(offset_sec), console.log(offset_rest)
})
}), jQuery(document).ready(function(e) {
jQuery(".nb-tabbed-head li a:not(.more_categories_handle)").click(function(t) {
t.preventDefault();
var a = e(this), n = a.parents('.nb-tabbed-head'), s = e(this).parents('.nb-tabbed-head').parent().next(), o = a.parents('.nb-tabbed-head').data("nbs"), r = a.parents('.nb-tabbed-head').data("number_of_posts"), f = a.parents('.nb-tabbed-head').data("nb_excerpt"), i = 1;
"nb3" == o && (i = 2), cat = a.data("cat_id"), "" === cat && (cat = a.data("parent_cat")), s.parent().find(".show-more").find(".nomoreposts").remove(), jQuery.ajax({
    type: "post",
    url: momAjaxL.url,
    dataType: "html",
    data: "action=nbtabs&nonce=" + momAjaxL.nonce + "&cat=" + cat + "&nbs=" + o + "&number_of_posts=" + r + "&nb_excerpt=" + f + "&offset=" + i,
    cach: !1,
    beforeSend: function() {
        s.parent().append('<i class="nb-load"></i>')
    },
    success: function(e) {
        s.hide().html(e).fadeIn("slow"), n.find("li").removeClass("active"), a.parent().addClass("active"), s.parent().find(".nb-load").remove()
    }
})
})
}), jQuery(document).ready(function(e) {
jQuery(".mom_mailchimp_subscribe").submit(function() {
return sf = jQuery(this), email = sf.find(".mms-email").val(), list = sf.data("list_id"), e(".message-box").fadeOut(), "" === email ? sf.before('<span class="message-box error">' + momAjaxL.error2 + '<i class="brankic-icon-error"></i></span>') : mom_isValidEmailAddress(email) ? jQuery.ajax({
    type: "post",
    url: momAjaxL.url,
    dataType: "html",
    data: "action=mom_mailchimp&nonce=" + momAjaxL.nonce + "&email=" + email + "&list_id=" + list,
    beforeSend: function() {
        sf.find(".sf-loading").fadeIn()
    },
    success: function(t) {
        "success" === t ? (sf.find(".email").val(""), sf.before('<span class="message-box success">' + momAjaxL.success + '<i class="brankic-icon-error"></i></span>').hide().fadeIn()) : sf.before('<span class="message-box error">' + momAjaxL.error + '<i class="brankic-icon-error"></i></span>').hide().fadeIn(), sf.find(".sf-loading").fadeOut(), e(".message-box i").on("click", function() {
            e(this).parent().fadeOut()
        })
    }
}) : sf.before('<span class="message-box error">' + momAjaxL.error2 + '<i class="brankic-icon-error"></i></span>'), !1
})
});

function mom_isValidEmailAddress(emailAddress) {
var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
return pattern.test(emailAddress);
};
/*!
* imagesLoaded PACKAGED v3.1.8
* JavaScript is all like "You images are done yet or what?"
* MIT License
*/

(function(){function e(){}function t(e,t){for(var n=e.length;n--;)if(e[n].listener===t)return n;return-1}function n(e){return function(){return this[e].apply(this,arguments)}}var i=e.prototype,r=this,o=r.EventEmitter;i.getListeners=function(e){var t,n,i=this._getEvents();if("object"==typeof e){t={};for(n in i)i.hasOwnProperty(n)&&e.test(n)&&(t[n]=i[n])}else t=i[e]||(i[e]=[]);return t},i.flattenListeners=function(e){var t,n=[];for(t=0;e.length>t;t+=1)n.push(e[t].listener);return n},i.getListenersAsObject=function(e){var t,n=this.getListeners(e);return n instanceof Array&&(t={},t[e]=n),t||n},i.addListener=function(e,n){var i,r=this.getListenersAsObject(e),o="object"==typeof n;for(i in r)r.hasOwnProperty(i)&&-1===t(r[i],n)&&r[i].push(o?n:{listener:n,once:!1});return this},i.on=n("addListener"),i.addOnceListener=function(e,t){return this.addListener(e,{listener:t,once:!0})},i.once=n("addOnceListener"),i.defineEvent=function(e){return this.getListeners(e),this},i.defineEvents=function(e){for(var t=0;e.length>t;t+=1)this.defineEvent(e[t]);return this},i.removeListener=function(e,n){var i,r,o=this.getListenersAsObject(e);for(r in o)o.hasOwnProperty(r)&&(i=t(o[r],n),-1!==i&&o[r].splice(i,1));return this},i.off=n("removeListener"),i.addListeners=function(e,t){return this.manipulateListeners(!1,e,t)},i.removeListeners=function(e,t){return this.manipulateListeners(!0,e,t)},i.manipulateListeners=function(e,t,n){var i,r,o=e?this.removeListener:this.addListener,s=e?this.removeListeners:this.addListeners;if("object"!=typeof t||t instanceof RegExp)for(i=n.length;i--;)o.call(this,t,n[i]);else for(i in t)t.hasOwnProperty(i)&&(r=t[i])&&("function"==typeof r?o.call(this,i,r):s.call(this,i,r));return this},i.removeEvent=function(e){var t,n=typeof e,i=this._getEvents();if("string"===n)delete i[e];else if("object"===n)for(t in i)i.hasOwnProperty(t)&&e.test(t)&&delete i[t];else delete this._events;return this},i.removeAllListeners=n("removeEvent"),i.emitEvent=function(e,t){var n,i,r,o,s=this.getListenersAsObject(e);for(r in s)if(s.hasOwnProperty(r))for(i=s[r].length;i--;)n=s[r][i],n.once===!0&&this.removeListener(e,n.listener),o=n.listener.apply(this,t||[]),o===this._getOnceReturnValue()&&this.removeListener(e,n.listener);return this},i.trigger=n("emitEvent"),i.emit=function(e){var t=Array.prototype.slice.call(arguments,1);return this.emitEvent(e,t)},i.setOnceReturnValue=function(e){return this._onceReturnValue=e,this},i._getOnceReturnValue=function(){return this.hasOwnProperty("_onceReturnValue")?this._onceReturnValue:!0},i._getEvents=function(){return this._events||(this._events={})},e.noConflict=function(){return r.EventEmitter=o,e},"function"==typeof define&&define.amd?define("eventEmitter/EventEmitter",[],function(){return e}):"object"==typeof module&&module.exports?module.exports=e:this.EventEmitter=e}).call(this),function(e){function t(t){var n=e.event;return n.target=n.target||n.srcElement||t,n}var n=document.documentElement,i=function(){};n.addEventListener?i=function(e,t,n){e.addEventListener(t,n,!1)}:n.attachEvent&&(i=function(e,n,i){e[n+i]=i.handleEvent?function(){var n=t(e);i.handleEvent.call(i,n)}:function(){var n=t(e);i.call(e,n)},e.attachEvent("on"+n,e[n+i])});var r=function(){};n.removeEventListener?r=function(e,t,n){e.removeEventListener(t,n,!1)}:n.detachEvent&&(r=function(e,t,n){e.detachEvent("on"+t,e[t+n]);try{delete e[t+n]}catch(i){e[t+n]=void 0}});var o={bind:i,unbind:r};"function"==typeof define&&define.amd?define("eventie/eventie",o):e.eventie=o}(this),function(e,t){"function"==typeof define&&define.amd?define(["eventEmitter/EventEmitter","eventie/eventie"],function(n,i){return t(e,n,i)}):"object"==typeof exports?module.exports=t(e,require("wolfy87-eventemitter"),require("eventie")):e.imagesLoaded=t(e,e.EventEmitter,e.eventie)}(window,function(e,t,n){function i(e,t){for(var n in t)e[n]=t[n];return e}function r(e){return"[object Array]"===d.call(e)}function o(e){var t=[];if(r(e))t=e;else if("number"==typeof e.length)for(var n=0,i=e.length;i>n;n++)t.push(e[n]);else t.push(e);return t}function s(e,t,n){if(!(this instanceof s))return new s(e,t);"string"==typeof e&&(e=document.querySelectorAll(e)),this.elements=o(e),this.options=i({},this.options),"function"==typeof t?n=t:i(this.options,t),n&&this.on("always",n),this.getImages(),a&&(this.jqDeferred=new a.Deferred);var r=this;setTimeout(function(){r.check()})}function f(e){this.img=e}function c(e){this.src=e,v[e]=this}var a=e.jQuery,u=e.console,h=u!==void 0,d=Object.prototype.toString;s.prototype=new t,s.prototype.options={},s.prototype.getImages=function(){this.images=[];for(var e=0,t=this.elements.length;t>e;e++){var n=this.elements[e];"IMG"===n.nodeName&&this.addImage(n);var i=n.nodeType;if(i&&(1===i||9===i||11===i))for(var r=n.querySelectorAll("img"),o=0,s=r.length;s>o;o++){var f=r[o];this.addImage(f)}}},s.prototype.addImage=function(e){var t=new f(e);this.images.push(t)},s.prototype.check=function(){function e(e,r){return t.options.debug&&h&&u.log("confirm",e,r),t.progress(e),n++,n===i&&t.complete(),!0}var t=this,n=0,i=this.images.length;if(this.hasAnyBroken=!1,!i)return this.complete(),void 0;for(var r=0;i>r;r++){var o=this.images[r];o.on("confirm",e),o.check()}},s.prototype.progress=function(e){this.hasAnyBroken=this.hasAnyBroken||!e.isLoaded;var t=this;setTimeout(function(){t.emit("progress",t,e),t.jqDeferred&&t.jqDeferred.notify&&t.jqDeferred.notify(t,e)})},s.prototype.complete=function(){var e=this.hasAnyBroken?"fail":"done";this.isComplete=!0;var t=this;setTimeout(function(){if(t.emit(e,t),t.emit("always",t),t.jqDeferred){var n=t.hasAnyBroken?"reject":"resolve";t.jqDeferred[n](t)}})},a&&(a.fn.imagesLoaded=function(e,t){var n=new s(this,e,t);return n.jqDeferred.promise(a(this))}),f.prototype=new t,f.prototype.check=function(){var e=v[this.img.src]||new c(this.img.src);if(e.isConfirmed)return this.confirm(e.isLoaded,"cached was confirmed"),void 0;if(this.img.complete&&void 0!==this.img.naturalWidth)return this.confirm(0!==this.img.naturalWidth,"naturalWidth"),void 0;var t=this;e.on("confirm",function(e,n){return t.confirm(e.isLoaded,n),!0}),e.check()},f.prototype.confirm=function(e,t){this.isLoaded=e,this.emit("confirm",this,t)};var v={};return c.prototype=new t,c.prototype.check=function(){if(!this.isChecked){var e=new Image;n.bind(e,"load",this),n.bind(e,"error",this),e.src=this.src,this.isChecked=!0}},c.prototype.handleEvent=function(e){var t="on"+e.type;this[t]&&this[t](e)},c.prototype.onload=function(e){this.confirm(!0,"onload"),this.unbindProxyEvents(e)},c.prototype.onerror=function(e){this.confirm(!1,"onerror"),this.unbindProxyEvents(e)},c.prototype.confirm=function(e,t){this.isConfirmed=!0,this.isLoaded=e,this.emit("confirm",this,t)},c.prototype.unbindProxyEvents=function(e){n.unbind(e.target,"load",this),n.unbind(e.target,"error",this)},s});

// Duoble tab to go
;(function( $, window, document, undefined )
{
$.fn.doubleTapToGo = function( params )
{
if( !( 'ontouchstart' in window ) &&
    !navigator.msMaxTouchPoints &&
    !navigator.userAgent.toLowerCase().match( /windows phone os 7/i ) ) return false;

this.each( function()
{
    var curItem = false;

    $( this ).on( 'click', function( e )
    {
        var item = $( this );
        if( item[ 0 ] != curItem[ 0 ] )
        {
            e.preventDefault();
            curItem = item;
        }
    });

    $( document ).on( 'click touchstart MSPointerDown', function( e )
    {
        var resetItem = true,
            parents   = $( e.target ).parents();

        for( var i = 0; i < parents.length; i++ )
            if( parents[ i ] == curItem[ 0 ] )
                resetItem = false;

        if( resetItem )
            curItem = false;
    });
});
return this;
};
})( jQuery, window, document );


// Jquery cookies
!function(e){"function"==typeof define&&define.amd?define(["jquery"],e):"object"==typeof exports?module.exports=e(require("jquery")):e(jQuery)}(function(e){function n(e){return u.raw?e:encodeURIComponent(e)}function o(e){return u.raw?e:decodeURIComponent(e)}function i(e){return n(u.json?JSON.stringify(e):String(e))}function t(e){0===e.indexOf('"')&&(e=e.slice(1,-1).replace(/\\"/g,'"').replace(/\\\\/g,"\\"));try{return e=decodeURIComponent(e.replace(c," ")),u.json?JSON.parse(e):e}catch(n){}}function r(n,o){var i=u.raw?n:t(n);return e.isFunction(o)?o(i):i}var c=/\+/g,u=e.cookie=function(t,c,s){if(arguments.length>1&&!e.isFunction(c)){if(s=e.extend({},u.defaults,s),"number"==typeof s.expires){var a=s.expires,d=s.expires=new Date;d.setMilliseconds(d.getMilliseconds()+864e5*a)}return document.cookie=[n(t),"=",i(c),s.expires?"; expires="+s.expires.toUTCString():"",s.path?"; path="+s.path:"",s.domain?"; domain="+s.domain:"",s.secure?"; secure":""].join("")}for(var f=t?void 0:{},p=document.cookie?document.cookie.split("; "):[],l=0,m=p.length;m>l;l++){var x=p[l].split("="),g=o(x.shift()),j=x.join("=");if(t===g){f=r(j,c);break}t||void 0===(j=r(j))||(f[g]=j)}return f};u.defaults={},e.removeCookie=function(n,o){return e.cookie(n,"",e.extend({},o,{expires:-1})),!e.cookie(n)}});


/*! Magnific Popup - v1.0.0 - 2015-01-03
* http://dimsemenov.com/plugins/magnific-popup/
* Copyright (c) 2015 Dmitry Semenov; */

!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):a("object"==typeof exports?require("jquery"):window.jQuery||window.Zepto)}(function(a){var b,c,d,e,f,g,h="Close",i="BeforeClose",j="AfterClose",k="BeforeAppend",l="MarkupParse",m="Open",n="Change",o="mfp",p="."+o,q="mfp-ready",r="mfp-removing",s="mfp-prevent-close",t=function(){},u=!!window.jQuery,v=a(window),w=function(a,c){b.ev.on(o+a+p,c)},x=function(b,c,d,e){var f=document.createElement("div");return f.className="mfp-"+b,d&&(f.innerHTML=d),e?c&&c.appendChild(f):(f=a(f),c&&f.appendTo(c)),f},y=function(c,d){b.ev.triggerHandler(o+c,d),b.st.callbacks&&(c=c.charAt(0).toLowerCase()+c.slice(1),b.st.callbacks[c]&&b.st.callbacks[c].apply(b,a.isArray(d)?d:[d]))},z=function(c){return c===g&&b.currTemplate.closeBtn||(b.currTemplate.closeBtn=a(b.st.closeMarkup.replace("%title%",b.st.tClose)),g=c),b.currTemplate.closeBtn},A=function(){a.magnificPopup.instance||(b=new t,b.init(),a.magnificPopup.instance=b)},B=function(){var a=document.createElement("p").style,b=["ms","O","Moz","Webkit"];if(void 0!==a.transition)return!0;for(;b.length;)if(b.pop()+"Transition"in a)return!0;return!1};t.prototype={constructor:t,init:function(){var c=navigator.appVersion;b.isIE7=-1!==c.indexOf("MSIE 7."),b.isIE8=-1!==c.indexOf("MSIE 8."),b.isLowIE=b.isIE7||b.isIE8,b.isAndroid=/android/gi.test(c),b.isIOS=/iphone|ipad|ipod/gi.test(c),b.supportsTransition=B(),b.probablyMobile=b.isAndroid||b.isIOS||/(Opera Mini)|Kindle|webOS|BlackBerry|(Opera Mobi)|(Windows Phone)|IEMobile/i.test(navigator.userAgent),d=a(document),b.popupsCache={}},open:function(c){var e;if(c.isObj===!1){b.items=c.items.toArray(),b.index=0;var g,h=c.items;for(e=0;e<h.length;e++)if(g=h[e],g.parsed&&(g=g.el[0]),g===c.el[0]){b.index=e;break}}else b.items=a.isArray(c.items)?c.items:[c.items],b.index=c.index||0;if(b.isOpen)return void b.updateItemHTML();b.types=[],f="",b.ev=c.mainEl&&c.mainEl.length?c.mainEl.eq(0):d,c.key?(b.popupsCache[c.key]||(b.popupsCache[c.key]={}),b.currTemplate=b.popupsCache[c.key]):b.currTemplate={},b.st=a.extend(!0,{},a.magnificPopup.defaults,c),b.fixedContentPos="auto"===b.st.fixedContentPos?!b.probablyMobile:b.st.fixedContentPos,b.st.modal&&(b.st.closeOnContentClick=!1,b.st.closeOnBgClick=!1,b.st.showCloseBtn=!1,b.st.enableEscapeKey=!1),b.bgOverlay||(b.bgOverlay=x("bg").on("click"+p,function(){b.close()}),b.wrap=x("wrap").attr("tabindex",-1).on("click"+p,function(a){b._checkIfClose(a.target)&&b.close()}),b.container=x("container",b.wrap)),b.contentContainer=x("content"),b.st.preloader&&(b.preloader=x("preloader",b.container,b.st.tLoading));var i=a.magnificPopup.modules;for(e=0;e<i.length;e++){var j=i[e];j=j.charAt(0).toUpperCase()+j.slice(1),b["init"+j].call(b)}y("BeforeOpen"),b.st.showCloseBtn&&(b.st.closeBtnInside?(w(l,function(a,b,c,d){c.close_replaceWith=z(d.type)}),f+=" mfp-close-btn-in"):b.wrap.append(z())),b.st.alignTop&&(f+=" mfp-align-top"),b.wrap.css(b.fixedContentPos?{overflow:b.st.overflowY,overflowX:"hidden",overflowY:b.st.overflowY}:{top:v.scrollTop(),position:"absolute"}),(b.st.fixedBgPos===!1||"auto"===b.st.fixedBgPos&&!b.fixedContentPos)&&b.bgOverlay.css({height:d.height(),position:"absolute"}),b.st.enableEscapeKey&&d.on("keyup"+p,function(a){27===a.keyCode&&b.close()}),v.on("resize"+p,function(){b.updateSize()}),b.st.closeOnContentClick||(f+=" mfp-auto-cursor"),f&&b.wrap.addClass(f);var k=b.wH=v.height(),n={};if(b.fixedContentPos&&b._hasScrollBar(k)){var o=b._getScrollbarSize();o&&(n.marginRight=o)}b.fixedContentPos&&(b.isIE7?a("body, html").css("overflow","hidden"):n.overflow="hidden");var r=b.st.mainClass;return b.isIE7&&(r+=" mfp-ie7"),r&&b._addClassToMFP(r),b.updateItemHTML(),y("BuildControls"),a("html").css(n),b.bgOverlay.add(b.wrap).prependTo(b.st.prependTo||a(document.body)),b._lastFocusedEl=document.activeElement,setTimeout(function(){b.content?(b._addClassToMFP(q),b._setFocus()):b.bgOverlay.addClass(q),d.on("focusin"+p,b._onFocusIn)},16),b.isOpen=!0,b.updateSize(k),y(m),c},close:function(){b.isOpen&&(y(i),b.isOpen=!1,b.st.removalDelay&&!b.isLowIE&&b.supportsTransition?(b._addClassToMFP(r),setTimeout(function(){b._close()},b.st.removalDelay)):b._close())},_close:function(){y(h);var c=r+" "+q+" ";if(b.bgOverlay.detach(),b.wrap.detach(),b.container.empty(),b.st.mainClass&&(c+=b.st.mainClass+" "),b._removeClassFromMFP(c),b.fixedContentPos){var e={marginRight:""};b.isIE7?a("body, html").css("overflow",""):e.overflow="",a("html").css(e)}d.off("keyup"+p+" focusin"+p),b.ev.off(p),b.wrap.attr("class","mfp-wrap").removeAttr("style"),b.bgOverlay.attr("class","mfp-bg"),b.container.attr("class","mfp-container"),!b.st.showCloseBtn||b.st.closeBtnInside&&b.currTemplate[b.currItem.type]!==!0||b.currTemplate.closeBtn&&b.currTemplate.closeBtn.detach(),b._lastFocusedEl&&a(b._lastFocusedEl).focus(),b.currItem=null,b.content=null,b.currTemplate=null,b.prevHeight=0,y(j)},updateSize:function(a){if(b.isIOS){var c=document.documentElement.clientWidth/window.innerWidth,d=window.innerHeight*c;b.wrap.css("height",d),b.wH=d}else b.wH=a||v.height();b.fixedContentPos||b.wrap.css("height",b.wH),y("Resize")},updateItemHTML:function(){var c=b.items[b.index];b.contentContainer.detach(),b.content&&b.content.detach(),c.parsed||(c=b.parseEl(b.index));var d=c.type;if(y("BeforeChange",[b.currItem?b.currItem.type:"",d]),b.currItem=c,!b.currTemplate[d]){var f=b.st[d]?b.st[d].markup:!1;y("FirstMarkupParse",f),b.currTemplate[d]=f?a(f):!0}e&&e!==c.type&&b.container.removeClass("mfp-"+e+"-holder");var g=b["get"+d.charAt(0).toUpperCase()+d.slice(1)](c,b.currTemplate[d]);b.appendContent(g,d),c.preloaded=!0,y(n,c),e=c.type,b.container.prepend(b.contentContainer),y("AfterChange")},appendContent:function(a,c){b.content=a,a?b.st.showCloseBtn&&b.st.closeBtnInside&&b.currTemplate[c]===!0?b.content.find(".mfp-close").length||b.content.append(z()):b.content=a:b.content="",y(k),b.container.addClass("mfp-"+c+"-holder"),b.contentContainer.append(b.content)},parseEl:function(c){var d,e=b.items[c];if(e.tagName?e={el:a(e)}:(d=e.type,e={data:e,src:e.src}),e.el){for(var f=b.types,g=0;g<f.length;g++)if(e.el.hasClass("mfp-"+f[g])){d=f[g];break}e.src=e.el.attr("data-mfp-src"),e.src||(e.src=e.el.attr("href"))}return e.type=d||b.st.type||"inline",e.index=c,e.parsed=!0,b.items[c]=e,y("ElementParse",e),b.items[c]},addGroup:function(a,c){var d=function(d){d.mfpEl=this,b._openClick(d,a,c)};c||(c={});var e="click.magnificPopup";c.mainEl=a,c.items?(c.isObj=!0,a.off(e).on(e,d)):(c.isObj=!1,c.delegate?a.off(e).on(e,c.delegate,d):(c.items=a,a.off(e).on(e,d)))},_openClick:function(c,d,e){var f=void 0!==e.midClick?e.midClick:a.magnificPopup.defaults.midClick;if(f||2!==c.which&&!c.ctrlKey&&!c.metaKey){var g=void 0!==e.disableOn?e.disableOn:a.magnificPopup.defaults.disableOn;if(g)if(a.isFunction(g)){if(!g.call(b))return!0}else if(v.width()<g)return!0;c.type&&(c.preventDefault(),b.isOpen&&c.stopPropagation()),e.el=a(c.mfpEl),e.delegate&&(e.items=d.find(e.delegate)),b.open(e)}},updateStatus:function(a,d){if(b.preloader){c!==a&&b.container.removeClass("mfp-s-"+c),d||"loading"!==a||(d=b.st.tLoading);var e={status:a,text:d};y("UpdateStatus",e),a=e.status,d=e.text,b.preloader.html(d),b.preloader.find("a").on("click",function(a){a.stopImmediatePropagation()}),b.container.addClass("mfp-s-"+a),c=a}},_checkIfClose:function(c){if(!a(c).hasClass(s)){var d=b.st.closeOnContentClick,e=b.st.closeOnBgClick;if(d&&e)return!0;if(!b.content||a(c).hasClass("mfp-close")||b.preloader&&c===b.preloader[0])return!0;if(c===b.content[0]||a.contains(b.content[0],c)){if(d)return!0}else if(e&&a.contains(document,c))return!0;return!1}},_addClassToMFP:function(a){b.bgOverlay.addClass(a),b.wrap.addClass(a)},_removeClassFromMFP:function(a){this.bgOverlay.removeClass(a),b.wrap.removeClass(a)},_hasScrollBar:function(a){return(b.isIE7?d.height():document.body.scrollHeight)>(a||v.height())},_setFocus:function(){(b.st.focus?b.content.find(b.st.focus).eq(0):b.wrap).focus()},_onFocusIn:function(c){return c.target===b.wrap[0]||a.contains(b.wrap[0],c.target)?void 0:(b._setFocus(),!1)},_parseMarkup:function(b,c,d){var e;d.data&&(c=a.extend(d.data,c)),y(l,[b,c,d]),a.each(c,function(a,c){if(void 0===c||c===!1)return!0;if(e=a.split("_"),e.length>1){var d=b.find(p+"-"+e[0]);if(d.length>0){var f=e[1];"replaceWith"===f?d[0]!==c[0]&&d.replaceWith(c):"img"===f?d.is("img")?d.attr("src",c):d.replaceWith('<img src="'+c+'" class="'+d.attr("class")+'" />'):d.attr(e[1],c)}}else b.find(p+"-"+a).html(c)})},_getScrollbarSize:function(){if(void 0===b.scrollbarSize){var a=document.createElement("div");a.style.cssText="width: 99px; height: 99px; overflow: scroll; position: absolute; top: -9999px;",document.body.appendChild(a),b.scrollbarSize=a.offsetWidth-a.clientWidth,document.body.removeChild(a)}return b.scrollbarSize}},a.magnificPopup={instance:null,proto:t.prototype,modules:[],open:function(b,c){return A(),b=b?a.extend(!0,{},b):{},b.isObj=!0,b.index=c||0,this.instance.open(b)},close:function(){return a.magnificPopup.instance&&a.magnificPopup.instance.close()},registerModule:function(b,c){c.options&&(a.magnificPopup.defaults[b]=c.options),a.extend(this.proto,c.proto),this.modules.push(b)},defaults:{disableOn:0,key:null,midClick:!1,mainClass:"",preloader:!0,focus:"",closeOnContentClick:!1,closeOnBgClick:!0,closeBtnInside:!0,showCloseBtn:!0,enableEscapeKey:!0,modal:!1,alignTop:!1,removalDelay:0,prependTo:null,fixedContentPos:"auto",fixedBgPos:"auto",overflowY:"auto",closeMarkup:'<button title="%title%" type="button" class="mfp-close">&times;</button>',tClose:"Close (Esc)",tLoading:"Loading..."}},a.fn.magnificPopup=function(c){A();var d=a(this);if("string"==typeof c)if("open"===c){var e,f=u?d.data("magnificPopup"):d[0].magnificPopup,g=parseInt(arguments[1],10)||0;f.items?e=f.items[g]:(e=d,f.delegate&&(e=e.find(f.delegate)),e=e.eq(g)),b._openClick({mfpEl:e},d,f)}else b.isOpen&&b[c].apply(b,Array.prototype.slice.call(arguments,1));else c=a.extend(!0,{},c),u?d.data("magnificPopup",c):d[0].magnificPopup=c,b.addGroup(d,c);return d};var C,D,E,F="inline",G=function(){E&&(D.after(E.addClass(C)).detach(),E=null)};a.magnificPopup.registerModule(F,{options:{hiddenClass:"hide",markup:"",tNotFound:"Content not found"},proto:{initInline:function(){b.types.push(F),w(h+"."+F,function(){G()})},getInline:function(c,d){if(G(),c.src){var e=b.st.inline,f=a(c.src);if(f.length){var g=f[0].parentNode;g&&g.tagName&&(D||(C=e.hiddenClass,D=x(C),C="mfp-"+C),E=f.after(D).detach().removeClass(C)),b.updateStatus("ready")}else b.updateStatus("error",e.tNotFound),f=a("<div>");return c.inlineElement=f,f}return b.updateStatus("ready"),b._parseMarkup(d,{},c),d}}});var H,I="ajax",J=function(){H&&a(document.body).removeClass(H)},K=function(){J(),b.req&&b.req.abort()};a.magnificPopup.registerModule(I,{options:{settings:null,cursor:"mfp-ajax-cur",tError:'<a href="%url%">The content</a> could not be loaded.'},proto:{initAjax:function(){b.types.push(I),H=b.st.ajax.cursor,w(h+"."+I,K),w("BeforeChange."+I,K)},getAjax:function(c){H&&a(document.body).addClass(H),b.updateStatus("loading");var d=a.extend({url:c.src,success:function(d,e,f){var g={data:d,xhr:f};y("ParseAjax",g),b.appendContent(a(g.data),I),c.finished=!0,J(),b._setFocus(),setTimeout(function(){b.wrap.addClass(q)},16),b.updateStatus("ready"),y("AjaxContentAdded")},error:function(){J(),c.finished=c.loadError=!0,b.updateStatus("error",b.st.ajax.tError.replace("%url%",c.src))}},b.st.ajax.settings);return b.req=a.ajax(d),""}}});var L,M=function(c){if(c.data&&void 0!==c.data.title)return c.data.title;var d=b.st.image.titleSrc;if(d){if(a.isFunction(d))return d.call(b,c);if(c.el)return c.el.attr(d)||""}return""};a.magnificPopup.registerModule("image",{options:{markup:'<div class="mfp-figure"><div class="mfp-close"></div><figure><div class="mfp-img"></div><figcaption><div class="mfp-bottom-bar"><div class="mfp-title"></div><div class="mfp-counter"></div></div></figcaption></figure></div>',cursor:"mfp-zoom-out-cur",titleSrc:"title",verticalFit:!0,tError:'<a href="%url%">The image</a> could not be loaded.'},proto:{initImage:function(){var c=b.st.image,d=".image";b.types.push("image"),w(m+d,function(){"image"===b.currItem.type&&c.cursor&&a(document.body).addClass(c.cursor)}),w(h+d,function(){c.cursor&&a(document.body).removeClass(c.cursor),v.off("resize"+p)}),w("Resize"+d,b.resizeImage),b.isLowIE&&w("AfterChange",b.resizeImage)},resizeImage:function(){var a=b.currItem;if(a&&a.img&&b.st.image.verticalFit){var c=0;b.isLowIE&&(c=parseInt(a.img.css("padding-top"),10)+parseInt(a.img.css("padding-bottom"),10)),a.img.css("max-height",b.wH-c)}},_onImageHasSize:function(a){a.img&&(a.hasSize=!0,L&&clearInterval(L),a.isCheckingImgSize=!1,y("ImageHasSize",a),a.imgHidden&&(b.content&&b.content.removeClass("mfp-loading"),a.imgHidden=!1))},findImageSize:function(a){var c=0,d=a.img[0],e=function(f){L&&clearInterval(L),L=setInterval(function(){return d.naturalWidth>0?void b._onImageHasSize(a):(c>200&&clearInterval(L),c++,void(3===c?e(10):40===c?e(50):100===c&&e(500)))},f)};e(1)},getImage:function(c,d){var e=0,f=function(){c&&(c.img[0].complete?(c.img.off(".mfploader"),c===b.currItem&&(b._onImageHasSize(c),b.updateStatus("ready")),c.hasSize=!0,c.loaded=!0,y("ImageLoadComplete")):(e++,200>e?setTimeout(f,100):g()))},g=function(){c&&(c.img.off(".mfploader"),c===b.currItem&&(b._onImageHasSize(c),b.updateStatus("error",h.tError.replace("%url%",c.src))),c.hasSize=!0,c.loaded=!0,c.loadError=!0)},h=b.st.image,i=d.find(".mfp-img");if(i.length){var j=document.createElement("img");j.className="mfp-img",c.el&&c.el.find("img").length&&(j.alt=c.el.find("img").attr("alt")),c.img=a(j).on("load.mfploader",f).on("error.mfploader",g),j.src=c.src,i.is("img")&&(c.img=c.img.clone()),j=c.img[0],j.naturalWidth>0?c.hasSize=!0:j.width||(c.hasSize=!1)}return b._parseMarkup(d,{title:M(c),img_replaceWith:c.img},c),b.resizeImage(),c.hasSize?(L&&clearInterval(L),c.loadError?(d.addClass("mfp-loading"),b.updateStatus("error",h.tError.replace("%url%",c.src))):(d.removeClass("mfp-loading"),b.updateStatus("ready")),d):(b.updateStatus("loading"),c.loading=!0,c.hasSize||(c.imgHidden=!0,d.addClass("mfp-loading"),b.findImageSize(c)),d)}}});var N,O=function(){return void 0===N&&(N=void 0!==document.createElement("p").style.MozTransform),N};a.magnificPopup.registerModule("zoom",{options:{enabled:!1,easing:"ease-in-out",duration:300,opener:function(a){return a.is("img")?a:a.find("img")}},proto:{initZoom:function(){var a,c=b.st.zoom,d=".zoom";if(c.enabled&&b.supportsTransition){var e,f,g=c.duration,j=function(a){var b=a.clone().removeAttr("style").removeAttr("class").addClass("mfp-animated-image"),d="all "+c.duration/1e3+"s "+c.easing,e={position:"fixed",zIndex:9999,left:0,top:0,"-webkit-backface-visibility":"hidden"},f="transition";return e["-webkit-"+f]=e["-moz-"+f]=e["-o-"+f]=e[f]=d,b.css(e),b},k=function(){b.content.css("visibility","visible")};w("BuildControls"+d,function(){if(b._allowZoom()){if(clearTimeout(e),b.content.css("visibility","hidden"),a=b._getItemToZoom(),!a)return void k();f=j(a),f.css(b._getOffset()),b.wrap.append(f),e=setTimeout(function(){f.css(b._getOffset(!0)),e=setTimeout(function(){k(),setTimeout(function(){f.remove(),a=f=null,y("ZoomAnimationEnded")},16)},g)},16)}}),w(i+d,function(){if(b._allowZoom()){if(clearTimeout(e),b.st.removalDelay=g,!a){if(a=b._getItemToZoom(),!a)return;f=j(a)}f.css(b._getOffset(!0)),b.wrap.append(f),b.content.css("visibility","hidden"),setTimeout(function(){f.css(b._getOffset())},16)}}),w(h+d,function(){b._allowZoom()&&(k(),f&&f.remove(),a=null)})}},_allowZoom:function(){return"image"===b.currItem.type},_getItemToZoom:function(){return b.currItem.hasSize?b.currItem.img:!1},_getOffset:function(c){var d;d=c?b.currItem.img:b.st.zoom.opener(b.currItem.el||b.currItem);var e=d.offset(),f=parseInt(d.css("padding-top"),10),g=parseInt(d.css("padding-bottom"),10);e.top-=a(window).scrollTop()-f;var h={width:d.width(),height:(u?d.innerHeight():d[0].offsetHeight)-g-f};return O()?h["-moz-transform"]=h.transform="translate("+e.left+"px,"+e.top+"px)":(h.left=e.left,h.top=e.top),h}}});var P="iframe",Q="//about:blank",R=function(a){if(b.currTemplate[P]){var c=b.currTemplate[P].find("iframe");c.length&&(a||(c[0].src=Q),b.isIE8&&c.css("display",a?"block":"none"))}};a.magnificPopup.registerModule(P,{options:{markup:'<div class="mfp-iframe-scaler"><div class="mfp-close"></div><iframe class="mfp-iframe" src="//about:blank" frameborder="0" allowfullscreen></iframe></div>',srcAction:"iframe_src",patterns:{youtube:{index:"youtube.com",id:"v=",src:"//www.youtube.com/embed/%id%?autoplay=1"},vimeo:{index:"vimeo.com/",id:"/",src:"//player.vimeo.com/video/%id%?autoplay=1"},gmaps:{index:"//maps.google.",src:"%id%&output=embed"}}},proto:{initIframe:function(){b.types.push(P),w("BeforeChange",function(a,b,c){b!==c&&(b===P?R():c===P&&R(!0))}),w(h+"."+P,function(){R()})},getIframe:function(c,d){var e=c.src,f=b.st.iframe;a.each(f.patterns,function(){return e.indexOf(this.index)>-1?(this.id&&(e="string"==typeof this.id?e.substr(e.lastIndexOf(this.id)+this.id.length,e.length):this.id.call(this,e)),e=this.src.replace("%id%",e),!1):void 0});var g={};return f.srcAction&&(g[f.srcAction]=e),b._parseMarkup(d,g,c),b.updateStatus("ready"),d}}});var S=function(a){var c=b.items.length;return a>c-1?a-c:0>a?c+a:a},T=function(a,b,c){return a.replace(/%curr%/gi,b+1).replace(/%total%/gi,c)};a.magnificPopup.registerModule("gallery",{options:{enabled:!1,arrowMarkup:'<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%"></button>',preload:[0,2],navigateByImgClick:!0,arrows:!0,tPrev:"Previous (Left arrow key)",tNext:"Next (Right arrow key)",tCounter:"%curr% of %total%"},proto:{initGallery:function(){var c=b.st.gallery,e=".mfp-gallery",g=Boolean(a.fn.mfpFastClick);return b.direction=!0,c&&c.enabled?(f+=" mfp-gallery",w(m+e,function(){c.navigateByImgClick&&b.wrap.on("click"+e,".mfp-img",function(){return b.items.length>1?(b.next(),!1):void 0}),d.on("keydown"+e,function(a){37===a.keyCode?b.prev():39===a.keyCode&&b.next()})}),w("UpdateStatus"+e,function(a,c){c.text&&(c.text=T(c.text,b.currItem.index,b.items.length))}),w(l+e,function(a,d,e,f){var g=b.items.length;e.counter=g>1?T(c.tCounter,f.index,g):""}),w("BuildControls"+e,function(){if(b.items.length>1&&c.arrows&&!b.arrowLeft){var d=c.arrowMarkup,e=b.arrowLeft=a(d.replace(/%title%/gi,c.tPrev).replace(/%dir%/gi,"left")).addClass(s),f=b.arrowRight=a(d.replace(/%title%/gi,c.tNext).replace(/%dir%/gi,"right")).addClass(s),h=g?"mfpFastClick":"click";e[h](function(){b.prev()}),f[h](function(){b.next()}),b.isIE7&&(x("b",e[0],!1,!0),x("a",e[0],!1,!0),x("b",f[0],!1,!0),x("a",f[0],!1,!0)),b.container.append(e.add(f))}}),w(n+e,function(){b._preloadTimeout&&clearTimeout(b._preloadTimeout),b._preloadTimeout=setTimeout(function(){b.preloadNearbyImages(),b._preloadTimeout=null},16)}),void w(h+e,function(){d.off(e),b.wrap.off("click"+e),b.arrowLeft&&g&&b.arrowLeft.add(b.arrowRight).destroyMfpFastClick(),b.arrowRight=b.arrowLeft=null})):!1},next:function(){b.direction=!0,b.index=S(b.index+1),b.updateItemHTML()},prev:function(){b.direction=!1,b.index=S(b.index-1),b.updateItemHTML()},goTo:function(a){b.direction=a>=b.index,b.index=a,b.updateItemHTML()},preloadNearbyImages:function(){var a,c=b.st.gallery.preload,d=Math.min(c[0],b.items.length),e=Math.min(c[1],b.items.length);for(a=1;a<=(b.direction?e:d);a++)b._preloadItem(b.index+a);for(a=1;a<=(b.direction?d:e);a++)b._preloadItem(b.index-a)},_preloadItem:function(c){if(c=S(c),!b.items[c].preloaded){var d=b.items[c];d.parsed||(d=b.parseEl(c)),y("LazyLoad",d),"image"===d.type&&(d.img=a('<img class="mfp-img" />').on("load.mfploader",function(){d.hasSize=!0}).on("error.mfploader",function(){d.hasSize=!0,d.loadError=!0,y("LazyLoadError",d)}).attr("src",d.src)),d.preloaded=!0}}}});var U="retina";a.magnificPopup.registerModule(U,{options:{replaceSrc:function(a){return a.src.replace(/\.\w+$/,function(a){return"@2x"+a})},ratio:1},proto:{initRetina:function(){if(window.devicePixelRatio>1){var a=b.st.retina,c=a.ratio;c=isNaN(c)?c():c,c>1&&(w("ImageHasSize."+U,function(a,b){b.img.css({"max-width":b.img[0].naturalWidth/c,width:"100%"})}),w("ElementParse."+U,function(b,d){d.src=a.replaceSrc(d,c)}))}}}}),function(){var b=1e3,c="ontouchstart"in window,d=function(){v.off("touchmove"+f+" touchend"+f)},e="mfpFastClick",f="."+e;a.fn.mfpFastClick=function(e){return a(this).each(function(){var g,h=a(this);if(c){var i,j,k,l,m,n;h.on("touchstart"+f,function(a){l=!1,n=1,m=a.originalEvent?a.originalEvent.touches[0]:a.touches[0],j=m.clientX,k=m.clientY,v.on("touchmove"+f,function(a){m=a.originalEvent?a.originalEvent.touches:a.touches,n=m.length,m=m[0],(Math.abs(m.clientX-j)>10||Math.abs(m.clientY-k)>10)&&(l=!0,d())}).on("touchend"+f,function(a){d(),l||n>1||(g=!0,a.preventDefault(),clearTimeout(i),i=setTimeout(function(){g=!1},b),e())})})}h.on("click"+f,function(){g||e()})})},a.fn.destroyMfpFastClick=function(){a(this).off("touchstart"+f+" click"+f),c&&v.off("touchmove"+f+" touchend"+f)}}(),A()});

/**
* jQuery.marquee - scrolling text like old marquee element
* @author Aamir Afridi - aamirafridi(at)gmail(dot)com / http://aamirafridi.com/jquery/jquery-marquee-plugin
*/
;(function(e){e.fn.marquee=function(t){return this.each(function(){var n=e.extend({},e.fn.marquee.defaults,t),r=e(this),i,s,o,u,a,f=3,l="animation-play-state",c=false,h=function(e,t,n){var r=["webkit","moz","MS","o",""];for(var i=0;i<r.length;i++){if(!r[i])t=t.toLowerCase();e.addEventListener(r[i]+t,n,false)}},p=function(e){var t=[];for(var n in e){if(e.hasOwnProperty(n)){t.push(n+":"+e[n])}}t.push();return"{"+t.join(",")+"}"},d=function(){r.timer=setTimeout(M,n.delayBeforeStart)},v={pause:function(){if(c&&n.allowCss3Support){i.css(l,"paused")}else{if(e.fn.pause){i.pause()}}r.data("runningStatus","paused");r.trigger("paused")},resume:function(){if(c&&n.allowCss3Support){i.css(l,"running")}else{if(e.fn.resume){i.resume()}}r.data("runningStatus","resumed");r.trigger("resumed")},toggle:function(){v[r.data("runningStatus")=="resumed"?"pause":"resume"]()},destroy:function(){clearTimeout(r.timer);r.find("*").andSelf().unbind();r.html(r.find(".js-marquee:first").html())}};if(typeof t==="string"){if(e.isFunction(v[t])){if(!i){i=r.find(".js-marquee-wrapper")}if(r.data("css3AnimationIsSupported")===true){c=true}v[t]()}return}var m={},g;e.each(n,function(e,t){g=r.attr("data-"+e);if(typeof g!=="undefined"){switch(g){case"true":g=true;break;case"false":g=false;break}n[e]=g}});n.duration=n.speed||n.duration;u=n.direction=="up"||n.direction=="down";n.gap=n.duplicated?parseInt(n.gap):0;r.wrapInner('<div class="js-marquee"></div>');var y=r.find(".js-marquee").css({"margin-right":n.gap,"float":"left"});if(n.duplicated){y.clone(true).appendTo(r)}r.wrapInner('<div style="width:100000px" class="js-marquee-wrapper"></div>');i=r.find(".js-marquee-wrapper");if(u){var b=r.height();i.removeAttr("style");r.height(b);r.find(".js-marquee").css({"float":"none","margin-bottom":n.gap,"margin-right":0});if(n.duplicated)r.find(".js-marquee:last").css({"margin-bottom":0});var w=r.find(".js-marquee:first").height()+n.gap;n.duration=(parseInt(w,10)+parseInt(b,10))/parseInt(b,10)*n.duration}else{a=r.find(".js-marquee:first").width()+n.gap;s=r.width();n.duration=(parseInt(a,10)+parseInt(s,10))/parseInt(s,10)*n.duration}if(n.duplicated){n.duration=n.duration/2}if(n.allowCss3Support){var E=document.body||document.createElement("div"),S="marqueeAnimation-"+Math.floor(Math.random()*1e7),x="Webkit Moz O ms Khtml".split(" "),T="animation",N="",C="";if(E.style.animation){C="@keyframes "+S+" ";c=true}if(c===false){for(var k=0;k<x.length;k++){if(E.style[x[k]+"AnimationName"]!==undefined){var L="-"+x[k].toLowerCase()+"-";T=L+T;l=L+l;C="@"+L+"keyframes "+S+" ";c=true;break}}}if(c){N=S+" "+n.duration/1e3+"s "+n.delayBeforeStart/1e3+"s infinite "+n.css3easing;r.data("css3AnimationIsSupported",true)}}var A=function(){i.css("margin-top",n.direction=="up"?b+"px":"-"+w+"px")},O=function(){i.css("margin-left",n.direction=="left"?s+"px":"-"+a+"px")};if(n.duplicated){if(u){i.css("margin-top",n.direction=="up"?b:"-"+(w*2-n.gap)+"px")}else{i.css("margin-left",n.direction=="left"?s+"px":"-"+(a*2-n.gap)+"px")}f=1}else{if(u){A()}else{O()}}var M=function(){if(n.duplicated){if(f===1){n._originalDuration=n.duration;if(u){n.duration=n.direction=="up"?n.duration+b/(w/n.duration):n.duration*2}else{n.duration=n.direction=="left"?n.duration+s/(a/n.duration):n.duration*2}if(N){N=S+" "+n.duration/1e3+"s "+n.delayBeforeStart/1e3+"s "+n.css3easing}f++}else if(f===2){n.duration=n._originalDuration;if(N){S=S+"0";C=e.trim(C)+"0 ";N=S+" "+n.duration/1e3+"s 0s infinite "+n.css3easing}f++}}if(u){if(n.duplicated){if(f>2){i.css("margin-top",n.direction=="up"?0:"-"+w+"px")}o={"margin-top":n.direction=="up"?"-"+w+"px":0}}else{A();o={"margin-top":n.direction=="up"?"-"+i.height()+"px":b+"px"}}}else{if(n.duplicated){if(f>2){i.css("margin-left",n.direction=="left"?0:"-"+a+"px")}o={"margin-left":n.direction=="left"?"-"+a+"px":0}}else{O();o={"margin-left":n.direction=="left"?"-"+a+"px":s+"px"}}}r.trigger("beforeStarting");if(c){i.css(T,N);var t=C+" { 100%  "+p(o)+"}",l=e("style");if(l.length!==0){l.filter(":last").append(t)}else{e("head").append("<style>"+t+"</style>")}h(i[0],"AnimationIteration",function(){r.trigger("finished")});h(i[0],"AnimationEnd",function(){M();r.trigger("finished")})}else{i.animate(o,n.duration,n.easing,function(){r.trigger("finished");if(n.pauseOnCycle){d()}else{M()}})}r.data("runningStatus","resumed")};r.bind("pause",v.pause);r.bind("resume",v.resume);if(n.pauseOnHover){r.bind("mouseenter mouseleave",v.toggle)}if(c&&n.allowCss3Support){M()}else{d()}})};e.fn.marquee.defaults={allowCss3Support:true,css3easing:"linear",easing:"linear",delayBeforeStart:1e3,direction:"left",duplicated:false,duration:5e3,gap:20,pauseOnCycle:false,pauseOnHover:false}})(jQuery);
