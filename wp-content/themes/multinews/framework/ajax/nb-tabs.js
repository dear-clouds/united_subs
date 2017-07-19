jQuery(document).ready(function($) {

	jQuery(".nb-tabbed-head li a").click(function(e){

		e.preventDefault();
		var bt = $(this);
		var bts = bt.parent().parent();
		var where = $(this).parent().parent().parent().next();
		var nbs = bt.parent().parent().data('nbs');
		var nop = bt.parent().parent().data('number_of_posts');
	
		cat = bt.data('cat_id');
		if (cat === '') {
			cat = bt.data('parent_cat');
		}
		where.parent().find('.show-more').find('.nomoreposts').remove();
		
		jQuery.ajax({
			type: "post",
			url: nbtabs.url,
                        dataType: 'html',
                        data: "action=nbtabs&nonce="+nbtabs.nonce+"&cat="+cat+"&nbs="+nbs+"&number_of_posts="+nop,
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