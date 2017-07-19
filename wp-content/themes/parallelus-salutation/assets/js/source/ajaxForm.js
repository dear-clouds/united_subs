// Contact form submit function        
function ajaxContact(theForm) {
	var formData = jQuery(theForm).serialize(),
		formContainer = jQuery(theForm).parent(),
		messagesTop = jQuery(theForm).siblings('.formMessages-top'),
		messagesBottom = jQuery(theForm).siblings('.formMessages-bottom'),
		successMsg = messagesTop.children('.formSuccess'),
		errorMsg = messagesBottom.children('.formError'),
		loader = jQuery(theForm).find('.sending');
		
	// get the container height so the page doesn't shift on submit
	var fixedHeight = formContainer.outerHeight();
	
	// show loading graphic (this is after clicking send)
	loaderImg = loader.children('.sendingImg');
	loaderImg.css('display','none'); // hide the actual image
	loader.removeClass('invisible'); // make the image container visible
	loaderImg.fadeIn(); // fade in the image
	
	jQuery.ajax({
		type: 'POST',
		url: window.location.href, //this.href,
		data: formData,
		success: function(response) {
			//( successMsg.height() ) ?	successMsg.fadeIn('fast', function() { jQuery(this).hide(); }) : successMsg.hide();
			loaderImg.fadeOut('fast', function() {
				
				// Sent! Now show the thank you message area.
				if (response === 'success') { 
					errorMsg.fadeOut(); // make sure error message isn't showing
					// set container height so the page doesn't shift
					formContainer.css('height',fixedHeight + 'px');
					var messageArea = successMsg;
				} else {
					errorMsg.html(response); // add the error to the message area
					var messageArea = errorMsg;
				}


				// make the message visible
				var i = setInterval(function() {
					if ( !messageArea.is(':visible') ) {
						
						// again, only on success 
						if (response === 'success') {
							jQuery(theForm).css('display','none'); // completely hide the form now
						}
						
						messageArea.slideDown('fast');
						//msg.html(result).addClass(c).slideDown('fast');
						clearInterval(i);
					}
				}, 40);   

			}); // end loading fade
		}
	});

	return false;
}
