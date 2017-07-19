
// EDIT BELOW THIS LINE FOR CUSTOM EFFECTS, TWEAKS AND INIT

/*--------------------------------------------------

Custom overwiev:

Animations
Shortcodes
---------------------------------------------------*/


function activate_waypoints(container)
{
	//activates simple css animations of the content once the user scrolls to an elements
	if(jQuery.fn.kleo_waypoints)
	{
		if(typeof container == 'undefined'){ container = 'body';};

		jQuery('.animate-when-visible', container).kleo_waypoints();
		jQuery('.animate-when-almost-visible', container).kleo_waypoints({ offset: '90%'});
	}
}


function activate_shortcode_scripts(container)
{
if(typeof container == 'undefined'){ container = 'body';};

//activates behavior and animation for gallery
if(jQuery.fn.kleo_sc_gallery)
{
	jQuery('.kleo-gallery', container).kleo_sc_gallery();
}

//activates behavior and animation for one by one general
if(jQuery.fn.kleo_general_onebyone)
{
	jQuery('.one-by-one-general', container).kleo_general_onebyone();
}

if(jQuery.fn.kleo_animate_number)
{
	jQuery('.kleo-animate-number', container).kleo_animate_number();
}

//activates animation for elements
if(jQuery.fn.one_by_one_animated)
{
	jQuery('.one-by-one-animated', container).one_by_one_animated();
}

//activates animation for progress bar
if(jQuery.fn.kleo_sc_progressbar)
{
	jQuery('.progress-bar-container', container).kleo_sc_progressbar();
}

//activates animation for testimonial
if(jQuery.fn.kleo_sc_testimonial)
{
	jQuery('.kleo-testimonial-wrapper', container).kleo_sc_testimonial();
}

}


(function($){
	
	"use strict";

// -------------------------------------------------------------------------------------------
// testimonial shortcode javascript
// -------------------------------------------------------------------------------------------

$.fn.kleo_sc_testimonial = function(options)
{
	return this.each(function()
	{
		var container = $(this), elements = container.find('.kleo-testimonial');


		//trigger displaying of thumbnails
		container.on('kleo-start-animation', function()
		{
			elements.each(function(i)
			{
				var element = $(this);
				setTimeout(function(){ element.addClass('kleo-start-animation') }, (i * 150));
			});
		});
	});
}



// -------------------------------------------------------------------------------------------
// Progress bar shortcode javascript
// -------------------------------------------------------------------------------------------

$.fn.kleo_sc_progressbar = function(options)
{
	return this.each(function()
	{
		var container = $(this), elements = container.find('.progress');


		//trigger displaying of thumbnails
		container.on('start-animation', function()
		{
			elements.each(function(i)
			{
				var element = $(this);
				setTimeout(function(){
				$('.bar strong').css('opacity', 1);
				//$('.bar strong').css('left', -30 + 'px');
				element.addClass('start-animation') }, (i * 250));
			});
		});
	});
}



// -------------------------------------------------------------------------------------------
// Iconlist shortcode javascript
// -------------------------------------------------------------------------------------------

$.fn.one_by_one_animated = function(options)
{
	return this.each(function()
	{
		var listicons = $(this), elements = listicons.find('.list-el-animated');

		listicons.on('start-animation', function()
		{
			elements.each(function(i)
			{
				var element = $(this);
				setTimeout(function(){ element.addClass('start-animation') }, (i * 350));
			});
		});
	});
}


// -------------------------------------------------------------------------------------------
// Big Number animation shortcode javascript
// -------------------------------------------------------------------------------------------

//http://codetheory.in/controlling-the-frame-rate-with-requestanimationframe/ (improve it with framerate in the future?)

$.fn.kleo_animate_number = function(options)
{
	var start_count = function(element, countTo, increment, current)
	{
	
		//calculate the new number
		var newCount = current + increment;
		
		//if the number is bigger than our final number set the number and finish
		if(newCount >= countTo) 
		{
			element.text(countTo);
			//exit
		}
		else
		{
			var prepend = "", addZeros = countTo.toString().length - newCount.toString().length
			
			//if the number has less digits than the final number some zeros where omitted. add them to the front
			for(var i = addZeros; i > 0; i--){ prepend += "0"; }
			
			element.text(prepend + newCount);
			window.kleoAnimFrame(function(){ start_count(element, countTo, increment, newCount) });
		}
	};

		$(this).each(function(i)
		{
			//prepare elements
			var element = $(this), text = element.text();
			element.text( text.replace(/./g, "0")); 
			
			var countTimer = element.data('timer') || 3000;
			
			//trigger number animation
			element.addClass('number_prepared').on('start-animation', function()
			{
				var element = $(this), countTo = element.data('number'), current = parseInt(element.text(),10), increment = Math.round( countTo * 30 / countTimer);
				if(increment == 0 || increment % 10 == 0) increment += 1;
				
				setTimeout(function(){ start_count(element, countTo, increment, current);}, 300);
			});
			
		});

}

window.kleoAnimFrame = (function(){
  return  window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || function( callback ){ window.setTimeout(callback, 1000 / 60); };
})();



// -------------------------------------------------------------------------------------------
// Gallery shortcode javascript
// -------------------------------------------------------------------------------------------

$.fn.kleo_sc_gallery = function(options)
{
	return this.each(function()
	{
		var gallery = $(this), images = gallery.find('img'), big_prev = gallery.find('.kleo-gallery-big');


		//trigger displaying of thumbnails
		gallery.on('start-animation', function()
		{
			images.each(function(i)
			{
				var image = $(this);
				setTimeout(function(){ image.addClass('start-animation') }, (i * 150));
				//alert('test');
			});
		});

		

		
	});
}


// -------------------------------------------------------------------------------------------
// One by one general shortcode javascript
// -------------------------------------------------------------------------------------------

$.fn.kleo_general_onebyone = function(options)
{
	return this.each(function()
	{
		var container = $(this), items = container.children();

		//trigger displaying of items
		container.on('start-animation', function()
		{
			items.each(function(i)
			{
				var item = $(this);
				setTimeout(function(){ item.addClass('start-animation') }, (i * 150));
			});
		});
	});
}



// -------------------------------------------------------------------------------------------
// HELPER FUNCTIONS
// -------------------------------------------------------------------------------------------


//waipoint script when something comes into viewport
 $.fn.kleo_waypoints = function(options_passed)
	{
		if(! $('html').is('.kleo-transform')) return;

		var defaults = { offset: 'bottom-in-view' , triggerOnce: true},
			options  = $.extend({}, defaults, options_passed);

		return this.each(function()
		{
			var element = $(this);

			setTimeout(function()
			{
				element.waypoint(function(direction)
				{
				 	$(this).addClass('start-animation').trigger('start-animation');

				}, options );

			},100)
		});
	};
	
})( jQuery );