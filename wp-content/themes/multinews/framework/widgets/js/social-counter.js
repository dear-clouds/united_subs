jQuery(document).ready(function($) {

	jQuery(".widget-content").on('click','.delete-sc-cache', function(e){
                var t = $(this);
			jQuery.ajax({
			type: "post",
			url: MomSCW.url,
                        dataType: 'html',
                        data: "action=mom_scwdc&nonce="+MomSCW.nonce,
			beforeSend: function() {
                            t.next('span').text(' deleting...').hide().fadeIn();
			},
			success: function(data){
                            t.next('span').text(' done...').delay(1000).fadeOut();
			}
			
		});	
		return false;
	})
})