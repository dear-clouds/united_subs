
jQuery(document).ready(function($){
	$('input[name=rhc_interval]').live('change',function(e){
		if('custom'==$(this).val()){
			$('.pt-option-custom-interval').show();
		}else{
			$('.pt-option-custom-interval').hide();
		}
	});
	
	if($('input[name=rhc_interval]:checked').attr('value')=='custom'){
		$('.pt-option-custom-interval').show();
	}else{
		$('.pt-option-custom-interval').hide();
	}
	
	$('.rc-datetimepicker').datetimepicker({
		dateFormat:'yy-mm-dd',
		timeFormat:'hh:mm',			
		numberOfMonths: 2,
		showButtonPanel: true,
		beforeShow: function(input,inst){
			if( !$(inst.dpDiv).parent().hasClass('righthere-calendar') ){
				$(inst.dpDiv).wrap('<div class="righthere-calendar"></div>');
			}
		}
	});
});