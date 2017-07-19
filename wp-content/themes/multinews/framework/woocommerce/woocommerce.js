jQuery(document).ready(function($) {
	
        $('body').on('click', '.add_to_cart_button', function()
	{
		jQuery(this).parents('.product:eq(0)').addClass('mom_adding_loading').removeClass('mom_added_check');
		var nel = $('.nav-button.nav-cart').find('.numofitems');
		var num = nel.data('num');
		nel.text(num+1);
		nel.data('num', num+1);
		
	})
	
	$('body').bind('added_to_cart', function()
	{
		jQuery('.mom_adding_loading').removeClass('mom_adding_loading').addClass('mom_added_check');
	});

/*----------------------------
	Prettyephoto
----------------------------*/
(function($) {
$(function() {

	// Lightbox
	$("div.product .images").magnificPopup({
		delegate : 'a.zoom',
		type:'image', 
		gallery:{enabled:true}

	});
	//$("a[data-rel^='prettyPhoto']").magnificPopup({});

});
})(jQuery);

 
});