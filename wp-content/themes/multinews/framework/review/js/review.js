jQuery(document).ready (function ($) {
"use strict";
// review 
if ($('.mom-reveiw-system').length) {
        $(".rc-value").knob({
        displayInput: false,
        });

// review tabs 
    $('.mom-reveiw-system .review-header .mr-types li:first-child').addClass('current');
    $('.mom-reveiw-system .review-header .mr-types li').click( function() {
        var $wrap = $(this).parent().parent().parent();
        $(this).parent().find('li').removeClass('current');
        $(this).addClass('current');
        $wrap.find('.review-tab').hide();
        if ($(this).hasClass('bars')) {
            $wrap.find('.bars-tab').fadeIn();
        } else if ($(this).hasClass('stars')) {
            $wrap.find('.stars-tab').fadeIn();
        } else if ($(this).hasClass('circles')) {
            $wrap.find('.circles-tab').fadeIn();
        }
    });
    
// adapt it
$('.mom-reveiw-system').each(function() {
    var width = $(this).width();
    if (width < 608) {
	$(this).addClass('rs-smaller_than_default');
    }

    if ((width > 608) && (width > 800)) {
	$(this).addClass('rs-full_width');
    }
});

}

}); //end of file