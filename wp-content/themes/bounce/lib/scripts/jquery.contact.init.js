jQuery('#contact-form').submit(function() {

	jQuery('.contact-error').remove();
	var hasError = false;
	jQuery('.requiredFieldContact').each(function() {
		if(jQuery.trim(jQuery(this).val()) == '') {
			jQuery(this).addClass('input-error');
			hasError = true;
		} else if(jQuery(this).hasClass('email')) {
			var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
			if(!emailReg.test(jQuery.trim(jQuery(this).val()))) {
				jQuery(this).addClass('input-error');
				hasError = true;
			}
		}
	});

});
		
jQuery('#contact-form .contact-submit').click(function() {
	jQuery('.loader').css({display:"block"});
});	
