;;

jQuery(document).ready(function($){
	function cb_click_rhc_subcategory(e){
		try {
			if( RHCVC.vc.category == $(this).data('filter') ){
				$('.rhc-sub-left').show();
			}else{
				$('.rhc-sub-left').hide();
			}
		}catch(e){
			console.log( e.message );
		}
		return true;
	}
	
	$('.vc_add-element-filter-button')
		.unbind('click', cb_click_rhc_subcategory )
		.bind('click', cb_click_rhc_subcategory )
	;
	
	//assign each shortcode a subcategory.
	var rhc_shortcodes = [];
	$(RHCVC.vc.shortcode_subcategories).each(function(i,sc){
		for (var sub in sc ){
		    if ( sc.hasOwnProperty( sub ) ) {
				thumb = $('#' + sub);
				$(sc[sub]).each(function( j, subcategory ){
					$('#' + sub).addClass(subcategory);
				});
				rhc_shortcodes.push( thumb );
			}		
		}
	});
	
	function cb_filter_click_subcategory(e){
		var rhc_subcategory = $(this).attr('data-rhc_subcategory');
  		$(rhc_shortcodes).each(function(){
  			if( $(this).is( rhc_subcategory ) ){
  				$(this).closest('.wpb-layout-element-button').addClass('vc_visible');
  			}else{
  				$(this).closest('.wpb-layout-element-button').removeClass('vc_visible');
  			}
  		});
  		
		return true;
	}
	
	//-sub filter click
	$('button[data-rhc_subcategory]')
		.unbind('click', cb_filter_click_subcategory)
		.bind('click', cb_filter_click_subcategory)
	;
	
});