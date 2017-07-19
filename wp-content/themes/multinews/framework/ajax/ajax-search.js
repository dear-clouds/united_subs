jQuery(document).ready(function() {

	jQuery(".mom-search-form input.sf").on('keyup', function(e){
		sf = jQuery(this);
		term = sf.val();
		if (term.length > 2) {
		setTimeout(function() {
			jQuery.ajax({
			type: "post",
			url: MyAcSearch.url,
                        dataType: 'html',
                        data: "action=mom_ajaxsearch&nonce="+MyAcSearch.nonce+"&term="+term,
			beforeSend: function() {
				sf.parent().find('.sf-loading').fadeIn();
			},
			success: function(data){
                            if (sf.val() !== '') {
                            sf.parent().next('.ajax-search-results').html(data);
				if (data !== '') {
					sf.parent().next('.ajax-search-results').append('<h4 class="show-all-results"><a href="'+MyAcSearch.homeUrl+'/?s='+term+'">'+MyAcSearch.viewAll+'<i class="fa-icon-long-arrow-right"></i></a></h4>');
				} else {
					sf.parent().next('.ajax-search-results').find('show_all_results').remove();
					sf.parent().next('.ajax-search-results').html('<span class="sw-not_found">'+MyAcSearch.noResults+'</span>');
				}
                            } else {
                            sf.parent().next('.ajax-search-results').html('');
                            }
				sf.parent().find('.sf-loading').fadeOut();
				

			}
		});	
		}, 300);
		} else {
				setTimeout(function() {
			jQuery.ajax({
			type: "post",
			url: MyAcSearch.url,
                        dataType: 'html',
                        data: "action=mom_ajaxsearch&nonce="+MyAcSearch.nonce+"&term="+term,
			success: function(data){
                            if (sf.val() === '') {
                            sf.parent().next('.ajax-search-results').html('');
                            }
			
			}
		});	
		}, 300);	
		}
		return false;
	})
})