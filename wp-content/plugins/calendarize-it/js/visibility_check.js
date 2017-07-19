/* when calendar is rendered on a container that is not visible, it doesnt gets the correct height calculated.*/
function _rhc_check_visibility(){
	jQuery(document).ready(function($){
		var recheck = false;
		$('.fullCalendar').each(function(i,c){
			if( $(c).is(':visible') && $(c).find('.fc-content').height()<10 ){
				$(c).fullCalendar('render');
			}else if( $(c).find('.fc-content').height()<10 ){
				recheck = true;
			}		
		});
		
		if( recheck ){
			setTimeout('_rhc_check_visibility()',300);
		}
	});
}

function _rhc_check_init_rhc(){
	jQuery('.rhc_holder').each(function(i,c){
		if( jQuery(this).data('Calendarize') ) return true;
		init_rhc();	
		return false;	
	});
	setTimeout('_rhc_check_init_rhc()',1000);	
}

jQuery(document).ready(function($){
	if( RHC.visibility_check ){
		if( jQuery('.fullCalendar').length>0 )setTimeout('_rhc_check_visibility()',200);
		setTimeout('_rhc_check_init_rhc()',500);
	}else{

	}
});
