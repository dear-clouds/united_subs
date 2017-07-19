jQuery(document).ready(function ($) {
"use strict";

jQuery('.mom_button').hover(
		function(){
		var $hoverbg = jQuery(this).attr('data-hoverbg');
		var $texthcolor = jQuery(this).attr('data-texthover');
		var $borderhover = jQuery(this).attr('data-borderhover');
		jQuery(this).css("background-color",$hoverbg);
		jQuery(this).css("color",$texthcolor);
		jQuery(this).css("border-color",$borderhover);
	},function() {
		var $bgcolor = jQuery(this).attr('data-bg');
		var $textColor = jQuery(this).attr('data-text');
		var $bordercolor = jQuery(this).attr('data-border');
		if($bgcolor!==undefined){
			jQuery(this).css("background-color",$bgcolor);
		}else {
			jQuery(this).css("background-color",'');
		}
		if($textColor!==undefined){
			jQuery(this).css("color",$textColor);
		}else {
			jQuery(this).css("color",'');
		}
		if($bordercolor !== undefined){
			jQuery(this).css("border-color",$bordercolor);
		}else {
			jQuery(this).css("border-color",'');
		}
	});
// Tab Current icon
if ($(".main_tabs ul.tabs").length) { $("ul.tabs").momtabs("div.tabs-content-wrap > .tab-content", { effect: 'fade'}); }

if (('ul.mom_tabs li a i').length) {
    $('.mom_tabs_container').each(function () {
	var $this = $(this);
	var current_tab = $this.find('.mom_tabs li a.current i[class^="momizat-icon"]');
	current_tab.css('color', current_tab.attr('data-current'));
	$this.find('.mom_tabs li a').click(function () {
	if ($(this).hasClass('current')) {
	var $current = $(this).find('[class^="momizat-icon"]').attr('data-current');
	var $orig = $(this).find('[class^="momizat-icon"]').attr('data-color');
	
	$this.find('.mom_tabs li a i[class^="momizat-icon"]').css('color',$orig);
	$('[class^="momizat-icon"]', this).css('color', $current);
	} 
	});
    });
}
// Accordion Current icon
if (('h2.acc_title i').length) {
    $('.accordion').each(function () {
	var $this = $(this);
	var current_acc = $this.find('h2.active i[class^="momizat-icon"]');
	current_acc.css('color', current_acc.attr('data-current'));
	$this.find('h2.acc_title').click(function () {
	if ($(this).hasClass('active')) {
	var $current = $(this).find('[class^="momizat-icon"]').attr('data-current');
	var $orig = $(this).find('[class^="momizat-icon"]').attr('data-color');
	
	$this.find('h2.acc_title i[class^="momizat-icon"]').css('color',$orig);
	$('[class^="momizat-icon"]', this).css('color', $current);
	} 
	});
    });
}
//Pricing table
    $('.pricing-table .plan .plan-content ul li').wrapInner('<span></span>');
    $('.pricing-table .pricetable-featured').next().children('.plan_container').css('border-left', 'none');

//Accordion
$('.accordion').each( function() {
    var acc = $(this);
    if (acc.hasClass('toggle_acc')) {
	acc.find('li:first .acc_title').addClass('active');
	acc.find('.acc_toggle_open').addClass('active');
	acc.find('.acc_toggle_open').next('.acc_content').show();
	acc.find('.acc_toggle_close').removeClass('active');
	acc.find('.acc_toggle_close').next('.acc_content').hide();
	acc.find('.acc_title').click(function() {
	$(this).toggleClass('active');
	$(this).next('.acc_content').slideToggle();
    });
    } else {
    acc.find('li:first .acc_title').addClass('active');
    acc.find('.acc_title').click(function() {
	if(!$(this).hasClass('active')) {
	acc.find('.acc_title').removeClass('active');
	acc.find('.acc_content').slideUp();
	$(this).addClass('active');
	$(this).next('.acc_content').slideDown();
	}
    });
    }
}); 
$(".accordion").each(function () {
    $(this).find('.acc_title').each(function(i) {
	$(this).find('.acch_numbers').text(i+1);
    });
});
//graph
$('.animator.animated, .iconb_wrap.animated').each( function() {
    var $this = $(this);
    var animation = $(this).attr('data-animate');

$this.bind('inview', function(event, isInView, visiblePartX, visiblePartY) {
  if (isInView) {
	    $(this).addClass(animation);
	    if(animation.indexOf('fade') === -1)
	    {
	      $(this).css('opacity', '1');
	    }
    if (visiblePartY == 'top') {
      // top part of element is visible
    } else if (visiblePartY == 'bottom') {
      // bottom part of element is visible
    } else {
      // whole part of element is visible
    }
  } else {
    // element has gone out of viewport
  }
});

});
if ($('.progress_outer').length) {
    $('.progress_outer').each( function() {
	var $this = $(this);
    $this.bind('inview', function(event, isInView, visiblePartX, visiblePartY) {
      if (isInView) {
		$(this).find('.parograss_inner').show();
		$(this).find('.parograss_inner').addClass('ani-bar');
	if (visiblePartY == 'top') {
	  // top part of element is visible
	} else if (visiblePartY == 'bottom') {
	  // bottom part of element is visible
	} else {
	  // whole part of element is visible
	}
      } else {
	// element has gone out of viewport
      }
    });
    
    });
}

//toggles
jQuery("h4.toggle_title").click(function () {
	$(this).next(".toggle_content").slideToggle();
	$(this).toggleClass("active_toggle");
	$(this).parent().toggleClass("toggle_active");
});

$("h4.toggle_min").click(function () {
	$(this).next(".toggle_content_min").slideToggle();
	$(this).toggleClass("active_toggle_min");
});
//Icon Colors in hover
jQuery('.mom_iconbox').hover(
	function(){
	var icon = $(this).find('[class^="momizat-icon"]');
	var icon_wrap = $(this).find('.iconb_wrap');
	
	var $hover = icon.attr('data-hover');
	var $bghover = icon_wrap.attr('data-hover');
	var $bdhover = icon_wrap.attr('data-border_hover');

	icon.css("color",$hover);
	icon_wrap.css("background",$bghover);
	icon_wrap.css("border-color",$bdhover);
},function() {
	var icon = $(this).find('[class^="momizat-icon"]');
	var icon_wrap = $(this).find('.iconb_wrap');

	var $color = icon.attr('data-color');
	var $origcolor = icon.css('color');
	var $bgcolor = icon_wrap.attr('data-color');
	var $origbg = icon_wrap.css('background-color');
	var $bdcolor = icon_wrap.attr('data-border_color');
	var $origbd = icon_wrap.css('border-color');
	if($color!==undefined){
		icon.css("color",$color);
	}else {
		icon.css("color",$origcolor);
	}
	if($bgcolor!==undefined){
		icon_wrap.css("background",$bgcolor);
	}else {
		icon_wrap.css("background",$origbg);
	}
	if($bdcolor!==undefined){
		icon_wrap.css("border-color",$bdcolor);
	}else {
	}
});
//icona
jQuery('.mom_icona').hover(
	function(){
	var icon = $(this).find('[class^="momizat-icon"]');
	var icon_wrap = $(this);
	var $hover = icon.attr('data-hover');
	var $bghover = icon_wrap.attr('data-hover');
	var $bdhover = icon_wrap.attr('data-border_hover');
	icon.css("color",$hover);
	icon_wrap.css("background",$bghover);
	icon_wrap.css("border-color",$bdhover);
},function() {
	var icon = $(this).find('[class^="momizat-icon"]');
	var icon_wrap = $(this);
	var $color = icon.attr('data-color');
	var $origcolor = icon.css('color');
	var $bgcolor = icon_wrap.attr('data-color');
	var $origbg = icon_wrap.css('background-color');
	var $bdcolor = icon_wrap.attr('data-border_color');
	var $origbd = icon_wrap.css('border-color');
	if($color!==undefined){
		icon.css("color",$color);
	}else {
		icon.css("color",$origcolor);
	}
	if($bgcolor!==undefined){
		icon_wrap.css("background",$bgcolor);
	}else {
		icon_wrap.css("background",$origbg);
	}
	if($bdcolor!==undefined){
		icon_wrap.css("border-color",$bdcolor);
	}else {
	}
});
//teaser boxes
	var tb_cols = 2;
	var tb_2_i = 0;
	$(".teaser_box2").each(function(){
		tb_2_i++;
		tb_cols = 2;
		if (tb_2_i % tb_cols === 0) {$(this).addClass("last");}
	});
	var tb_3_i = 0;
	$(".teaser_box3").each(function(){
		tb_3_i++;
		tb_cols = 3;
		if (tb_3_i % tb_cols === 0) {$(this).addClass("last");}
	});

	var tb_4_i = 0;
	$(".teaser_box4").each(function(){
		tb_4_i++;
		tb_cols = 4;
		if (tb_4_i % tb_cols === 0) {$(this).addClass("last");}
	});

	var tb_5_i = 0;
	$(".teaser_box5").each(function(){
		tb_5_i++;
		tb_cols = 5;
		if (tb_5_i % tb_cols === 0) {$(this).addClass("last");}
	});
//team members
	var tm_cols = 2;
	var tm_2_i = 0;
	$(".team_member2").each(function(){
		tm_2_i++;
		tm_cols = 2;
		if (tm_2_i % tm_cols === 0) {$(this).addClass("last");}
	});
	var tm_3_i = 0;
	$(".team_member3").each(function(){
		tm_3_i++;
		tm_cols = 3;
		if (tm_3_i % tm_cols === 0) {$(this).addClass("last");}
	});
	var tm_4_i = 0;
	$(".team_member4").each(function(){
		tm_4_i++;
		tm_cols = 4;
		if (tm_4_i % tm_cols === 0) {$(this).addClass("last");}
	});
	var tm_5_i = 0;
	$(".team_member5").each(function(){
		tm_5_i++;
		tm_cols = 5;
		if (tm_5_i % tm_cols === 0) {$(this).addClass("last");}
	});
$('.team_member').each( function () {
    var socials = $(this).find('.member_social ul li');
    var width = 100/socials.length;
    socials.css('width',width+'%');
});	
//Mom Columns
	var mom_cols = 2;
	var mc_2_i = 0;
	$(".mom_columns2").each(function(){
		mc_2_i++;
		mom_cols = 2;
		if (mc_2_i % mom_cols === 0) {$(this).addClass("last");}
	});
	var mc_3_i = 0;
	$(".mom_columns3").each(function(){
		mc_3_i++;
		mom_cols = 3;
		if (mc_3_i % mom_cols === 0) {$(this).addClass("last");}
	});

	var mc_4_i = 0;
	$(".mom_columns4").each(function(){
		mc_4_i++;
		mom_cols = 4;
		if (mc_4_i % mom_cols === 0) {$(this).addClass("last");}
	});

	var mc_5_i = 0;
	$(".mom_columns5").each(function(){
		mc_5_i++;
		mom_cols = 5;
		if (mc_5_i % mom_cols === 0) {$(this).addClass("last");}
	});
//prallax bg
if ($('.mom_custom_background').length) {
    $('.mom_custom_background').each(function() {
	var $this = $(this);
	$(window).scroll(function () {
		var speed = 8.0;
		$this.css({backgroundPosition:(-window.pageXOffset / speed) + "px " + (-window.pageYOffset / speed) + "px"});
		//document.body.style.backgroundPosition = (-window.pageXOffset / speed) + "px " + (-window.pageYOffset / speed) + "px";
	});
    });
}
//callitout
if ($('.mom_callout').length) {
    $('.mom_callout').each( function () {
	if ($(this).find('.cobtr').length) {
	var btwidth = parseFloat($(this).find('.cobtr').css('width'))+30;
	var btheight = parseFloat($(this).find('.cobtr').css('height'))/2;
	$(this).find('.callout_content').css('margin-right',btwidth+'px');
	$(this).find('.cobtr').css('margin-top', '-'+btheight+'px');
	}
	if ($(this).find('.cobtl').length) {
	var btwidth = parseFloat($(this).find('.cobtl').css('width'))+30;
	var btheight = parseFloat($(this).find('.cobtl').css('height'))/2;
	$(this).find('.callout_content').css('margin-left',btwidth+'px');
	$(this).find('.cobtl').css('margin-top', '-'+btheight+'px');
	}
    });
}
	jQuery('.mom_button').hover(
		function(){
		var $hoverbg = jQuery(this).attr('data-hoverbg');
		var $texthcolor = jQuery(this).attr('data-texthover');
		var $borderhover = jQuery(this).attr('data-borderhover');
		jQuery(this).css("background-color",$hoverbg);
		jQuery(this).css("color",$texthcolor);
		jQuery(this).css("border-color",$borderhover);
	},function() {
		var $bgcolor = jQuery(this).attr('data-bg');
		var $textColor = jQuery(this).attr('data-text');
		var $bordercolor = jQuery(this).attr('data-border');
		if($bgcolor!==undefined){
			jQuery(this).css("background-color",$bgcolor);
		}else {
			jQuery(this).css("background-color",'');
		}
		if($textColor!==undefined){
			jQuery(this).css("color",$textColor);
		}else {
			jQuery(this).css("color",'');
		}
		if($bordercolor !== undefined){
			jQuery(this).css("border-color",$bordercolor);
		}else {
			jQuery(this).css("border-color",'');
		}
	});
//share
/*
if ($('.mom_share_buttons').length) {
    $('.mom_share_buttons').data('height',$('.mom_share_buttons').css('height'));
    var curHeight = $('.mom_share_buttons').height();
    $('.mom_share_buttons').css('height', 'auto');
    var autoHeight = $('.mom_share_buttons').height();
    $('.mom_share_buttons').css('height', curHeight);
    $('.mom_share_it .sh_arrow').toggle(function () {
	$('.mom_share_buttons').stop().animate({height: autoHeight}, 300);
	$(this).find('i').removeClass();
	$(this).find('i').addClass('momizat-icon-193');
    }, function () {
	$('.mom_share_buttons').stop().animate({height: $('.mom_share_buttons').data('height')}, 300);
	$(this).find('i').removeClass();
	$(this).find('i').addClass('momizat-icon-194');
    });
}
*/

$(window).resize(function() {
  if ($(window).width() < 940) {
	$('.video_wrap').fitVids();
  } 
});

  if ($(window).width() < 940) {
	$('.video_wrap').fitVids();
  } 
}); //end