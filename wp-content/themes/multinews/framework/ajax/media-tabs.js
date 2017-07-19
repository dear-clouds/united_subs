jQuery(document).ready(function($) {

	jQuery(".media-tabs li a").on('click', function(e){
		t = jQuery(this).parent();
		type = t.data('type');
			jQuery.ajax({
			type: "post",
			url: momMedia.url,
                        dataType: 'html',
                        data: "action=mom_media_tab&nonce="+momMedia.nonce+"&type="+type,
			beforeSend: function() {
				/* t.parent().find('.sf-loading').fadeIn(); */
				t.parent().parent().parent().append('<i class="nb-load"></i>');
			},
			success: function(data){
                           if (data !== '') {
					$('.media-page-content').html(data);
					$('.media-tabs > li').removeClass('active');
					t.addClass('active');
					
				}
                            
			/* t.parent().find('.sf-loading').fadeOut(); */
			t.parent().parent().parent().find('.nb-load').remove();	

			}
		});

		return false;
	});
	
	jQuery("#media-sort").on('change', function(e){
		order = jQuery(this).val();
		type = jQuery(this).parent().parent().siblings().find('li.active').data('type');
			jQuery.ajax({
			type: "post",
			url: momMedia.url,
                        dataType: 'html',
                        data: "action=mom_media_tab&nonce="+momMedia.nonce+"&type="+type+"&order="+order,
			beforeSend: function() {
				//sf.parent().find('.sf-loading').fadeIn();
			},
			success: function(data){
                           if (data !== '') {
					$('.media-page-content').html(data);
				
				}
                            
			//sf.parent().find('.sf-loading').fadeOut();
				

			}
		});

		return false;
	});
});