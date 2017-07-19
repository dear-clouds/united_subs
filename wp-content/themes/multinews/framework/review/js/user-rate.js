jQuery(document).ready(function($) {
/* Mouse Drag Event
var clicking = false;
$('.mom_user_rate').mousedown(function(){
    clicking = true;
    console.log(clicking);
});

$(document).mouseup(function(){
    clicking = false;
    console.log(clicking);
})
*/


$(".mom_user_rate").mousemove(function(e){
       //if(clicking == false) return;

   var style = $(this).data('style');
    var thisOffset = $(this).offset(); 
   //or $(this).offset(); if you really just want the current element's offset
   var relX = e.pageX - thisOffset.left;
   var relY = e.pageY - thisOffset.top;
   if (!$(this).hasClass('rated')) {
   var percent = relX/parseFloat($(this).width())*100;
   var score = Math.round(percent);
   var starts = (score/20).toFixed(1);
   if (style === 'bars') {
      $(this).find('.ub-inner').css({width: score+'%' });
      $(this).find('.ub-inner').find('span').text(score+'%');
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
			url: ajax_var.url,
			data: "action=user-rate&nonce="+ajax_var.nonce+"&user_rate=&post_id="+post_id+"&user_rate_score="+score,
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
			url: ajax_var.url,
			data: "action=user-rate&nonce="+ajax_var.nonce+"&user_rate=&post_id="+post_id+"&user_rate_score="+score,
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
   
})
