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
			offset = bt.data('offset');
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
				url: nbsm.url,
				dataType: 'html',
				data: "action=nbsm&nonce="+nbsm.nonce+"&cat="+cat+"&nbs="+nbs+"&number_of_posts="+nop+"&orderby="+norder+"&offset="+offset+"&offset_all="+offset_rest+"&offset_second="+offset_sec,
				beforeSend : function () {
					where.parent().append('<i class="nb-load"></i>');
					//bt.append('<i class="fa-icon-refresh fa-spin sm-icon"></i>');
				},
				success: function(data){
					//bt.find('.sm-icon').remove();
					if (data == '') {
						bt.parent().append('<a class="nomoreposts">'+nbsm.nomore+'</a>').hide().fadeIn();
					}
					if (data !== '') {
						where.html(data);
					} 
					where.parent().find('.nb-load').remove();
				},
				complete: function (data) {
				}
			});
			if (nbs == 'nb1') {
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
			console.log(offset);
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