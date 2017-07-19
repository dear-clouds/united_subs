/* To edit use source file: js/source/onLoad.js  */


/*
 *	Dynamic design functions and onLoad events
 *	----------------------------------------------------------------------
 * 	This file initializes many of the dynamic features after page load.
*/


// 
//	On document ready functions
// ======================================================================

jQuery(document).ready(function($) {

		
	// Fade in content (requires adding class="invisible" to page element
	// -------------------------------------------------------------------
	if (fadeContent !== 'none' && !oldIE) {
		// A little bit fancy... reveals the top, middle & bottom of the page in sequence
		elems = (fadeContent === 'all') ? '#Top, #Middle, #Bottom' : '#Middle';
		hiddenClass = (fadeContent === 'all') ? 'invisibleAll' : 'invisibleMiddle';
		if (fadeContent === 'all' || fadeContent === 'content') {
			$('#Wrapper').children(elems).css('opacity','0').end().parent('body').removeClass(hiddenClass);
			setTimeout(function() {	$('#Middle').animate({'opacity':'1'}, 250); }, 100); // fade in 2nd section, after 100 millisecond delay
			if (fadeContent === 'all') { 
				setTimeout(function() {	$('#Top').animate({'opacity':'1'}, 200); },	0); // fade in 1st section, no delay
				setTimeout(function() {	$('#Bottom').animate({'opacity':'1'}, 300);	},	200); // fade in 3rd section, after 200 millisecond delay  
			}
		}
	}
	
	
	// Style fix: Prevent blank space at bottom of page. 
	// don't apply to small screens, such as mobile devices)
	// -------------------------------------------------------------------
	$(window).bind('resize', function(){ 
		// test the browser height vs. wrapper height
		var browserHeight = $(window).height();
		var wrapperHeight = $('#Wrapper').outerHeight() + $('#Wrapper').offset().top;	// height + offset (in case something is above it, like an admin bar...)
		
		if ( browserHeight >  wrapperHeight ) {
			$middle = $('#Middle .contentMargin');
			// current height of the content "middle" section
			contentHeight = $middle.height();
			// new minimum height to fill browser
			minHeight = contentHeight + (browserHeight - wrapperHeight);
			// apply
			$middle.css('min-height',minHeight+'px');
		}
	});
	// Trigger once at start...
	$(window).trigger('resize');

		
	// Lightbox (colorbox)
	// -------------------------------------------------------------------
	
	lightboxOpacity = 0.8;
	
	// Lightbox for WP [gallery] (groups items for lightbox next/prev) 
	$(".gallery .gallery-item a").attr('rel','gallery');

	// Lightbox for YouTube 
	$("a.popup[href*='youtube.co'], a.popup[href*='youtu.be']").colorbox({		
		href: function() {			
			var videoID = this.href.match(/(youtu\.be\/|&*v=|\/v\/|\/embed\/)+([A-Za-z0-9\-_]{5,11})/);  // get video id
			var id = videoID[2];
			url = 'http://www.youtube.com/embed/' + id;
			if (!id) url = this.href; // if no id was found return original URL
			return url;
		},
		iframe:true,
		innerWidth: function() {
			// get width from url (if entered)
			w = $.getUrlVars(this.href)['width'] || 640;
			return w;
		}, 
		innerHeight: function() {
			h = $.getUrlVars(this.href)['height'] || 390;
			return h;
		},
		opacity: lightboxOpacity
	});

	// Lightbox for Vimeo
	$("a.popup[href*='http://www.vimeo.com/'], a.popup[href*='http://vimeo.com/']").colorbox({
		href: function() {
			//var id = /http:\/\/(www\.)?vimeo.com\/(\d+)($|\/)/.exec(this.href);  // get video id
			var id = /vimeo\.com\/(\d+)/.exec(this.href);  // get video id
			// url = 'http://www.vimeo.com/moogaloop.swf?clip_id=' + id[1];  // Old way
			url="http://player.vimeo.com/video/"+id[1];
			if (!id[1]) url = this.href; // if no id was found return original URL
			return url;
		},
		iframe:true,
		innerWidth: function() {
			// get width from url (if entered)
			w = $.getUrlVars(this.href)['width'] || 640;
			return w;
		}, 
		innerHeight: function() {
			h = $.getUrlVars(this.href)['height'] || 360;
			return h;
		},
		opacity: lightboxOpacity
	});
	
	// generic all links to images selector
	$("a[href$='.jpg'],a[href$='.jpeg'],a[href$='.png'],a[href$='.gif'],a[href$='.tif'],a[href$='.tiff'],a[href$='.bmp']").colorbox({
		maxWidth: '90%', maxHeight: '90%',
		opacity: lightboxOpacity
	});

	// specific target links using "popup" class with "#TartetElement" as href, for opening inline HTML content
	$("a.popup[href$='#LoginPopup'], .popup > a[href$='#LoginPopup']").each( function() {
		// Quick fix for URL with a path before "#LoginPopup"
		this.href = this.hash;
	});
	$("a.popup[href^='#'], .popup > a[href^='#']").colorbox({ maxWidth: '90%', maxHeight: '90%', inline: true, href: this.href, opacity: lightboxOpacity }).removeClass('popup');	// remove class to prevent duplication 
	$(".popup > a[href^='#']").parent().removeClass('popup');	// remove class (from parent for WP menu LI's) to prevent duplication 
	
	// specific target links using "popup" class or "#popup" in URL
	$(".popup").colorbox({ maxWidth: '90%', maxHeight: '90%', opacity: lightboxOpacity });
	$("a[href$='#popup']").colorbox({
		maxWidth: '90%', maxHeight: '90%',
		href: function() { if (this.href) { return this.href.replace('#popup',''); }},
		opacity: lightboxOpacity
	});

	// specific target links using "iframe" class or "#iframe" in URL (non-ajax content)
	$(".iframe").colorbox({ width:"80%", height:"80%", iframe:true });
	$("a[href$='#iframe']").colorbox({
		width:"80%", height:"80%", iframe:true,
		href: function() { if (this.href) { return this.href.replace('#iframe',''); }},
		opacity: lightboxOpacity
	});


	// Button styles (needs condition from theme options for on/off)
	// -------------------------------------------------------------------
	var $buttonElement = $('input[type="submit"]:not(.noStyle), input[type="button"]:not(.noStyle), input[type="reset"]:not(.noStyle), button:not(.noStyle)');
	$($buttonElement).addClass('btn');
	
		// Fix those styled buttons on Safari for Windows!
		// -------------------------------------------------------------------
		if ( (BrowserDetect.browser == "Safari" && BrowserDetect.OS == "Windows") || BrowserDetect.browser == "Opera" ) {
			// provides CSS element to appy a fix for the mysterious extra padding (Safari for Windows only)
			$('.btn').addClass('safariBtn');
		}

	
	
	// Hover effect for containers BP widgets (with bg color change)
	// -------------------------------------------------------------------
	BpWidgetHover();
	

	// Message box - close buttons
	// -------------------------------------------------------------------
	$(".messageBox .closeBox").click( function() {
		jQuery(this).parent('.messageBox').fadeTo(400, 0.001).slideUp();
	});


	// Tabs
	// -------------------------------------------------------------------
	if (jQuery('.tabList').length > 0 ) {
		$('.tabList').sTabs();
	};


	// Toggle (show/hide)
	// -------------------------------------------------------------------
	if (jQuery('.toggleItem').length > 0 ) {
		$('.toggleItem').simpleToggle();
	};
	
	
	// Slide Down Top (Top Tabs)
	// -------------------------------------------------------------------
	if (jQuery('.section-tabs').length > 0 ) {
		$('.section-tabs').simpleSlideTop();
	};
	
		
	// Overlabel - input text 
	// -------------------------------------------------------------------
	//$("label.overlabel").overlabel();
	

	// Tool tips
	// -------------------------------------------------------------------
	switch(toolTips) {
		case 'all links':
			$tipItems = $('a[title]');	// all links with titles
			break;
		case 'class':
			$tipItems = $('.tip');
			break;
		default:
			$tipItems = false;
	}
	// enable the tool tips
	if ($tipItems.length > 0) {
		
		// standard tips
		$tipItems.qtip({
			position: { 
				my: 'bottom center',
				at: 'top center',
				adjust: { y: -3 }
			}
		});
	}

	
	
	// BuddyPress related helpers
	// -------------------------------------------------------------------

		// Activity comment form - show/hide container
		// -------------------------------------------------------------------
		if (typeof jq == 'function') {
			jq('#content').ajaxComplete( function(evt, request, settings){
				var t = setTimeout("BpActivityReply()",325);
			});
			
			// show container when reply link clicked
			jq('div.activity').click( function(event) {
				var target = jq(event.target);
				if ( target.hasClass('acomment-reply') || target.parent().hasClass('acomment-reply') ) {
					
					BpActivityReply();
					
					if ( target.parent().hasClass('acomment-reply') )
						target = target.parent();
				
					var id = target.attr('id');
					ids = id.split('-');
					var form = jq( '#ac-form-' + ids[2] );
					form.parents('.activity-replies').slideDown( 200 )
					return false;
				}
			});
			
			// Escape Key Press for cancelling comment forms (hide the container)
			jq(document).keydown( function(e) {
				e = e || window.event;
				if (e.target)
					element = e.target;
				else if (e.srcElement)
					element = e.srcElement;
		
				if( element.nodeType == 3)
					element = element.parentNode;
		
				if( e.ctrlKey == true || e.altKey == true || e.metaKey == true )
					return;
		
				var keyCode = (e.keyCode) ? e.keyCode : e.which;
		
				if ( keyCode == 27 ) {
					if (element.tagName == 'TEXTAREA') {
						if ( jq(element).hasClass('ac-input') )
							formContainer = jq(element).parent().parent().parents('.activity-replies');
							if (formContainer.find('ul').length <= 0) {
								formContainer.slideUp( 200 );
							}
					}
				}
			});
			
			// Initiate on page load
			BpActivityReply()
		}

		// Refresh Cufon for BP content
		// -------------------------------------------------------------------
		if (typeof jq == 'function' && typeof Cufon == 'function') {
			jq('#content').ajaxComplete(function(evt, request, settings){
				setTimeout( function(){Cufon.refresh();}, 115 ); // Update Cufon
			});
		}

		// Reload theme hover behaviors to BP widgets
		if (typeof jq == 'function') {
			jq('.widget_bp_groups_widget, .widget_bp_core_members_widget').ajaxComplete(function(evt, request, settings){
				setTimeout( function(){
					
					// setup the hover events again
					BpWidgetHover();
					
					// refresh the Cufon text
					if (typeof Cufon == 'function') {
						Cufon.refresh();// Update Cufon
					}
					
				}, 215 ); // Update Cufon
			});
		}

	
});	





//	Design functions
// ======================================================================


// Custom easing effects
// -------------------------------------------------------------------

jQuery.extend( jQuery.easing,
{
	def: 'stopSlow',
	swing: function (x, t, b, c, d) {
		//alert(jQuery.easing.default);
		return jQuery.easing[jQuery.easing.def](x, t, b, c, d);
	},
	stopSlow: function (x, t, b, c, d) {
		return -c *(t/=d)*(t-2) + b;
	},
	stopMedium: function (x, t, b, c, d) {
		return -c * ((t=t/d-1)*t*t*t - 1) + b;
	},
	stopFast: function (x, t, b, c, d) {
		return (t==d) ? b+c : c * (-Math.pow(2, -10 * t/d) + 1) + b;
	},
	stopElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		return a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b;
	},
	stopBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158;
		return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
	},
	stopBounce: function (x, t, b, c, d) {
		if ((t/=d) < (1/2.75)) {
			return c*(7.5625*t*t) + b;
		} else if (t < (2/2.75)) {
			return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
		} else if (t < (2.5/2.75)) {
			return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
		} else {
			return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
		}
	}
});


// Slide show animation
// -------------------------------------------------------------------
function beforeSlide(curr, next, opts, fwd) {
	width  = jQuery(this).closest('div[id|="SS"]').innerWidth(); 	// 972
	height = jQuery(this).closest('div[id|="SS"]').innerHeight(); 	// 325
	// content to slide right
	jQuery(next).find('.slideRight, .slideLeft, .slideUp, .slideDown').each( function() {
		$this  	= jQuery(this);
		$attr  	= {'display':'none'};
		$width 	= '-'+width+'px';
		$height = '-'+height+'px';

		if ($this.hasClass('slideRight')) {
			$attr.left = $width;
		} else if ($this.hasClass('slideLeft')) {
			$attr.right = $width;
		} else if ($this.hasClass('slideDown')) {
			$attr.top = $height;
		} else if ($this.hasClass('slideUp')) {
			$attr.bottom = $height;
		}
		$this.css($attr); 
	});
}

function afterSlide(curr, next, opts, fwd) {
	width  = jQuery(this).closest('div[id|="SS"]').innerWidth(); 	// 972
	height = jQuery(this).closest('div[id|="SS"]').innerHeight(); 	// 325 
	// apply the animation effect to each element
	jQuery(this).find('.slideRight, .slideLeft, .slideUp, .slideDown').each( function(i) {
		$this   = jQuery(this);
		$data   = $this.data('output');
		$attr   = {'opacity':1};
		$easing = $data.easing ;
		$speed  = parseInt($data.speed);
		$delay  = parseInt($data.delay);
		$width  = width - $this.outerWidth(true) + 'px';
		$height = height - $this.outerHeight(true) + 'px';

		if ($this.hasClass('slideRight')) {
			$attr.left = $width;
		} else if ($this.hasClass('slideLeft')) {
			$attr.right = $width;
		} else if ($this.hasClass('slideDown')) {
			$attr.top = $height;
		} else if ($this.hasClass('slideUp')) {
			$attr.bottom = $height;
		}
		// Delay each item in 500ms intervals
		$i = i + 1;
		interval = ( $i > 1) ? $i * 250 : 50;
		interval += $delay;
		$this.css({'display':'block'}).delay(interval).animate($attr, $speed, $easing);
	});

}





// Hover effect for containers BP widgets (with bg color change)
// -------------------------------------------------------------------
function BpWidgetHover() {
		
	elements = '.widget_bp_groups_widget, .widget_bp_core_members_widget'; // defaults
	
	jQuery(elements).find('li:not(.hoverable)').hover(
		function () {
			jQuery(this).addClass('hover');
			if (typeof Cufon == 'function') {
				Cufon.refresh();
			}
		}, 
		function () {
			jQuery(this).removeClass('hover');
			if (typeof Cufon == 'function') {
				Cufon.refresh();
			}
		}
	).click( function() {
		url = jQuery(this).find('.item-title a').attr('href');
		if (url) {
			document.location = url;
		}
	}).addClass('hoverable');
}

// Show/hide containers for BP activity comment form
// -------------------------------------------------------------------
function BpActivityReply() {
	
	jQuery('.activity-replies').each( function() {
		hasComments = jQuery(this).find('ul').first().children('li:visible');
		if (hasComments.length <= 0) {
			jQuery(this).css('display','none');
		}else {
			jQuery(this).slideDown(200);
		}
	});
	
}

//	Other functions
// ======================================================================


// Get parameters from URL or string
// -------------------------------------------------------------------
// Usage:
// ------
// Get object of URL parameters:	allVars = $.getUrlVars();
// Getting URL var by its name:		byName = $.getUrlVar('name');
// Getting alternate URL var:		customURL = $.getUrlVar('name','http://mysite.com/?query=string');
// -------------------------------------------------------------------
jQuery.extend({
  getUrlVars: function(url){
    var vars = [], hash;
	if (!url) {
		url = window.location.href;
	}
    var hashes = url.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
      hash = hashes[i].split('=');
      vars.push(hash[0]);
      vars[hash[0]] = hash[1];
    }
    return vars;
  },
  getUrlVar: function(name, url){
	if (!url) {
		url = window.location.href;
	}
    return jQuery.getUrlVars(url)[name];
  }
});



// Browser detect
// -------------------------------------------------------------------

/* 
	Browser Detect - http://www.quirksmode.org/js/detect.html	
	The commented out code will get stripped by using a minification tool.
*/

var oldIE  = false;

var BrowserDetect = {
	init: function () {
		this.browser = this.searchString(this.dataBrowser) || "An unknown browser";
		this.version = this.searchVersion(navigator.userAgent)
			|| this.searchVersion(navigator.appVersion)
			|| "an unknown version";
		this.OS = this.searchString(this.dataOS) || "an unknown OS";
	},
	searchString: function (data) {
		for (var i=0;i<data.length;i++)	{
			var dataString = data[i].string;
			var dataProp = data[i].prop;
			this.versionSearchString = data[i].versionSearch || data[i].identity;
			if (dataString) {
				if (dataString.indexOf(data[i].subString) != -1)
					return data[i].identity;
			}
			else if (dataProp)
				return data[i].identity;
		}
	},
	searchVersion: function (dataString) {
		var index = dataString.indexOf(this.versionSearchString);
		if (index == -1) return;
		return parseFloat(dataString.substring(index+this.versionSearchString.length+1));
	},
	dataBrowser: [
		{
			string: navigator.vendor,
			subString: "Apple",
			identity: "Safari",
			versionSearch: "Version"
		},
		{
			string: navigator.userAgent,
			subString: "MSIE",
			identity: "Explorer",
			versionSearch: "MSIE"
		},/*
		{
			string: navigator.userAgent,
			subString: "Chrome",
			identity: "Chrome"
		},
		{ 	string: navigator.userAgent,
			subString: "OmniWeb",
			versionSearch: "OmniWeb/",
			identity: "OmniWeb"
		},*/
		{
			prop: window.opera,
			identity: "Opera"
		}/*,
		{
			string: navigator.vendor,
			subString: "iCab",
			identity: "iCab"
		},
		{
			string: navigator.vendor,
			subString: "KDE",
			identity: "Konqueror"
		},
		{
			string: navigator.userAgent,
			subString: "Firefox",
			identity: "Firefox"
		},
		{
			string: navigator.vendor,
			subString: "Camino",
			identity: "Camino"
		},
		{		// for newer Netscapes (6+)
			string: navigator.userAgent,
			subString: "Netscape",
			identity: "Netscape"
		},
		{
			string: navigator.userAgent,
			subString: "Gecko",
			identity: "Mozilla",
			versionSearch: "rv"
		},
		{ 		// for older Netscapes (4-)
			string: navigator.userAgent,
			subString: "Mozilla",
			identity: "Netscape",
			versionSearch: "Mozilla"
		}*/
	],
	dataOS : [
		{
			string: navigator.platform,
			subString: "Win",
			identity: "Windows"
		}/*,
		{
			string: navigator.platform,
			subString: "Mac",
			identity: "Mac"
		},
		{
			   string: navigator.userAgent,
			   subString: "iPhone",
			   identity: "iPhone/iPod"
	    },
		{
			string: navigator.platform,
			subString: "Linux",
			identity: "Linux"
		}*/
	]

};
BrowserDetect.init();

// Handle some IE specific issues (mostly to disable special features, only IE 6, 7 and 8)
if (BrowserDetect.browser == "Explorer" && BrowserDetect.version < 9) {
	oldIE = BrowserDetect.version; // set to version number. used later detect unsupported features.
}



/*
 *  sTabs - simple tabs jQuery plugin
 *  http://labs.smasty.net/jquery/stabs/
 *
 *  Copyright (c) 2010 Martin Srank (http://smasty.net)
 *  Licensed under the MIT license (http://www.opensource.org/licenses/mit-license.php).
 *
 *  Built for jQuery library
 *  http://jquery.com
 *
 */
(function($) {
  $.fn.sTabs = function(opts) {
  
  var options = $.extend({}, $.fn.sTabs.defaults, opts);
  
    return this.each(function() {
      $(this).addClass('tabs');
      $(this).find('a').each(function(){

        $($(this).attr('href')).addClass('tab').hide();

        $(this).bind(options.eventType, function(e){
          e.preventDefault();
          
          $(this).addClass('active');
          
          options.animate ? $($(this).attr('href')).fadeIn(options.duration) : $($(this).attr('href')).show();
          
          $($(this).parent().siblings().find('a')).each(function(){
            $(this).removeClass('active');
            $($(this).attr('href')).hide();
          });
        })
      });

      var first = $(this).find('li:nth-child(' + options.startWith + ')').children('a');
      $(first).addClass('active');
      $($(first).attr('href')).show();
    });
  }
   $.fn.sTabs.defaults = {animate: false, duration: 300, startWith: 1, eventType: 'click'}
})(jQuery);


/*
 * Toggle show/hide content (FAQs)
 *
 */
(function($) {
	$.fn.simpleToggle = function(opts) {
	
		var options = $.extend({}, $.fn.simpleToggle.defaults, opts);
		
		return this.each(function() {
			$title = $(this).children('.togTitle');
			$title.each(function() {
				$(this).click( function() {
					$item = $(this);
					$item.next('.togDesc').slideToggle('fast', function() {
						$icon = $item.children('.iconSymbol');
						if ($(this).css('display') == 'block') {
							$icon.removeClass('plus').addClass('minus');
						} else {
							$icon.removeClass('minus').addClass('plus');
						}
					});
				});
			});
		});
	
	}
	$.fn.simpleToggle.defaults = {}
   
})(jQuery);



// Simple Slide Open Top Content (with tabs)
// -------------------------------------------------------------------------------------

(function($) {
	$.fn.simpleSlideTop = function(opts) {
	
		var options = $.extend({}, $.fn.simpleSlideTop.defaults, opts);
		
		return this.each(function() {
			//$(this).addClass('tabs');
			$container = $(this);
			$(this).find('a').each(function(){
				
				contentID = $(this).attr('href');
				
				$(contentID).hide();
			
				$(this).bind(options.eventType, function(e){
					e.preventDefault();
				
					if ($(this).hasClass('active')) {
						// close everything if the active tab is clicked again
						$($(this).parents('ul').find('a')).each(function(){
							$(this).removeClass('active');
							$($(this).attr('href')).slideUp(options.duration*.65);
						});
					} else {
						// open the selected tab
						$tab = $(this);
						
						// check for any active tabs (so we know if they need to be closed)
						hasActive = false;
						$container.find('a').each(function(){
							if ($(this).hasClass('active')) hasActive = true;
						});
						
						// Now close all tabs except the one we just clicked...
						$($(this).parent().siblings().find('a')).each(function(){
							$(this).removeClass('active');
							$($(this).attr('href')).slideUp(options.duration*.65);
						});
						
						if (hasActive) {
							$($(this).attr('href')).delay(options.duration*.65).slideDown(options.duration);
						} else {
							$($(this).attr('href')).slideDown(options.duration);
						}
						
						$tab.addClass('active')
					}
					return false;
				});

			});
			
			if (options.startOpen) {
				var first = $(this).find('li:nth-child(' + options.defaultTab + ')').children('a');
				$(first).addClass('active');
				$($(first).attr('href')).show();
			}
		
		});
	}
	
	$.fn.simpleSlideTop.defaults = {duration: 300, defaultTab: 1, startOpen: false, eventType: 'click'}

})(jQuery);



// A little error checking...
// This helps prevents a blank page if a JS error occurs and "fade in content" is active
// -------------------------------------------------------------------------------------
if (fadeContent !== 'none' && !oldIE) {
	setTimeout(function() {	jQuery('body').removeClass('invisibleAll invisibleMiddle'); }, 1000);
}