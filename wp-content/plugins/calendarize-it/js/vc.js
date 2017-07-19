jQuery(document).ready(function($){
	rh_pop_init();
	//---range input
	$('.pop_rangeinput').pop_rangeinput();
	$('.pt-option-range .handle').mousedown(function(e){$(this).parent().parent().find('.pop_rangeinput').focus();});
});