jQuery(document).ready(function() {

	jQuery(".mom-search-form input.sf").on('keyup', function(e){
		sf = jQuery(this);
		term = sf.val();
		if (term.length > 2) {
		setTimeout(function() {
			jQuery.ajax({
			type: "post",
			url: momAjaxL.url,
                        dataType: 'html',
                        data: "action=mom_ajaxsearch&nonce="+momAjaxL.nonce+"&term="+term,
			beforeSend: function() {
				sf.parent().find('.sf-loading').fadeIn();
			},
			success: function(data){
                            if (sf.val() !== '') {
                            sf.parent().next('.ajax-search-results').html(data);
				if (data !== '') {
					sf.parent().next('.ajax-search-results').append('<h4 class="show-all-results"><a href="'+momAjaxL.homeUrl+'/?s='+term+'">'+momAjaxL.viewAll+'<i class="fa-icon-long-arrow-right"></i></a></h4>');
				} else {
					sf.parent().next('.ajax-search-results').find('show_all_results').remove();
					sf.parent().next('.ajax-search-results').html('<span class="sw-not_found">'+momAjaxL.noResults+'</span>');
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
			url: momAjaxL.url,
                        dataType: 'html',
                        data: "action=mom_ajaxsearch&nonce="+momAjaxL.nonce+"&term="+term,
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

jQuery(document).ready(function($) {

	jQuery(".media-tabs li a").on('click', function(e){
		t = jQuery(this).parent();
		type = t.data('type');
		count = t.parent().data('count');
			jQuery.ajax({
			type: "post",
			url: momAjaxL.url,
                        dataType: 'html',
                        data: "action=mom_media_tab&nonce="+momAjaxL.nonce+"&type="+type+"&count="+count,
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
		count = jQuery(this).parent().parent().siblings().find('li.active').parent().data('count');
			jQuery.ajax({
			type: "post",
			url: momAjaxL.url,
                        dataType: 'html',
                        data: "action=mom_media_tab&nonce="+momAjaxL.nonce+"&type="+type+"&order="+order+"&count="+count,
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

jQuery(document).ready(function($) {
		offset = '';
			offset_rest = '';
			offset_sec = '';
		jQuery(".section footer.show_more_ajax a").click(function(e){
			e.preventDefault();
			bt = jQuery(this);
			where = bt.parent().prev();
			nbs = bt.parent().data('nbs');
			nop = bt.parent().data('number_of_posts');
			norder = bt.parent().data('orderby');
			post_type = bt.data('post_type');
			offset = bt.data('offset');
			nb_excerpt = bt.parent().data('nb_excerpt');
			if (nbs == 'nb2' || nbs == 'nb4' || nbs == 'nb5') {
			offset_rest = offset+1;
			}

			if (nbs == 'nb3') {
			offset_sec = offset+1;
			offset_rest = offset+2;
			}
		
			cat = bt.parent().parent().find('.nb-tabbed-head').find('li.active a').data('cat_id');
			if (cat === '' || cat === undefined) {
				cat = bt.parent().data('cat_id');
			}
			
			jQuery.ajax({
				type: "post",
				url: momAjaxL.url,
				dataType: 'html',
				data: "action=nbsm&nonce="+momAjaxL.nonce+"&cat="+cat+"&nbs="+nbs+"&number_of_posts="+nop+"&orderby="+norder+"&offset="+offset+"&offset_all="+offset_rest+"&offset_second="+offset_sec+"&nb_excerpt="+nb_excerpt+"&post_type="+post_type,
				beforeSend : function () {
					where.parent().append('<i class="nb-load"></i>');
					//bt.append('<i class="fa-icon-refresh fa-spin sm-icon"></i>');
				},
				success: function(data){
					//bt.find('.sm-icon').remove();
					if (data == '') {
						bt.parent().append('<a class="nomoreposts">'+momAjaxL.nomore+'</a>').hide().fadeIn();
					}
					if (data !== '') {
						where.html(data);
					} 
					where.parent().find('.nb-load').remove();
				},
				complete: function (data) {
				}
			});
			if (nbs == 'nb1' || nbs == 'list') {
				bt.data('offset', offset+nop);
			}
			if (nbs == 'nb2') {
				bt.data('offset', offset+nop+1);
			}
			if (nbs == 'nb3') {
				bt.data('offset', offset+nop+2);
			}
			if (nbs == 'nb4'|| nbs == 'nb5') {
				bt.data('offset', offset+nop+1);
			}
			if (nbs == 'nb6') {
				bt.data('offset', offset+nop);
			}
			console.log(post_type);
			//console.log(bt.data('offset'));
			//console.log(offset_sec);
			//console.log(offset_rest);
		});
jQuery(".nb-tabbed-head li a").click(function(e){
		e.preventDefault();
		var bt = $(this);
		var bts = bt.parent().parent();
		var where = $(this).parent().parent().parent().next();
		var nbs = bt.parent().parent().data('nbs');
		var nop = bt.parent().parent().data('number_of_posts');
		var norder = bt.parent().parent().data('orderby');
		where.parent().find('.show-more').find('.nomoreposts').remove();
		origoff = where.parent().find('.show-more').find('a').data('orig-offset');
		where.parent().find('.show-more').find('a').data('offset',origoff);
		if (nbs == 'nb2' || nbs == 'nb4' || nbs == 'nb5' ) {
			offset_rest = where.parent().find('.show-more').find('a').data('offset') + 1;
		}
		if (nbs == 'nb3' ) {
			offset_sec = where.parent().find('.show-more').find('a').data('offset') + 1;
			offset_rest = where.parent().find('.show-more').find('a').data('offset') + 2;
		}
		//console.log(offset);
		console.log(where.parent().find('.show-more').find('a').data('offset'));
		console.log(offset_sec);
		console.log(offset_rest);

});		
});

jQuery(document).ready(function($) {

	jQuery(".nb-tabbed-head li a").click(function(e){

		e.preventDefault();
		var bt = $(this);
		var bts = bt.parent().parent();
		var where = $(this).parent().parent().parent().next();
		var nbs = bt.parent().parent().data('nbs');
		var nop = bt.parent().parent().data('number_of_posts');
		var nb_excerpt = bt.parent().parent().data('nb_excerpt');
		var offset = 1;
		if (nbs == 'nb3' ) {
		    offset = 2;
		}
		cat = bt.data('cat_id');
		if (cat === '') {
			cat = bt.data('parent_cat');
		}
		where.parent().find('.show-more').find('.nomoreposts').remove();
		
		jQuery.ajax({
			type: "post",
			url: momAjaxL.url,
                        dataType: 'html',
                        data: "action=nbtabs&nonce="+momAjaxL.nonce+"&cat="+cat+"&nbs="+nbs+"&number_of_posts="+nop+"&nb_excerpt="+nb_excerpt+"&offset="+offset,
			cach: false,
			beforeSend : function () {
				where.parent().append('<i class="nb-load"></i>');
			},
			success: function(data){
				where.hide().html(data).fadeIn('slow');
				bts.find('li').removeClass('active');
				bt.parent().addClass('active');
				where.parent().find('.nb-load').remove();
			}
		});
	})
})

jQuery(document).ready(function($) {

	jQuery(".mom_mailchimp_subscribe").submit( function(e){
		sf = jQuery(this);
		email = sf.find('.mms-email').val();
		list = sf.data('list_id');
		$('.message-box').fadeOut();
		if (email === '')
		{
		    
			sf.before('<span class="message-box error">'+momAjaxL.error2+'<i class="brankic-icon-error"></i></span>');
		}
		else
		{
		    if (!mom_isValidEmailAddress(email)) {
			sf.before('<span class="message-box error">'+momAjaxL.error2+'<i class="brankic-icon-error"></i></span>');
		     } else {
			jQuery.ajax({
			type: "post",
			url: momAjaxL.url,
                        dataType: 'html',
                        data: "action=mom_mailchimp&nonce="+momAjaxL.nonce+"&email="+email+"&list_id="+list,
			beforeSend: function() {
				sf.find('.sf-loading').fadeIn();
			},
			success: function(data){
				if(data ==="success") {
				sf.find('.email').val("");
					sf.before('<span class="message-box success">'+momAjaxL.success+'<i class="brankic-icon-error"></i></span>').hide().fadeIn();
				}
				else
				{
					sf.before('<span class="message-box error">'+momAjaxL.error+'<i class="brankic-icon-error"></i></span>').hide().fadeIn();
				}
				sf.find('.sf-loading').fadeOut();
			//message box
				$('.message-box i').on('click', function(e) {
				    $(this).parent().fadeOut();    
				});
			}
		});
		     }
		}
		return false;
	});
	


});