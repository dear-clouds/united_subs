

jQuery(document).ready(function($){
	$('#btn_dismiss_help_notice').unbind('click').click(function(e){
		$.post( ajaxurl, {action:'rhc_dismiss_notice'},function(data){
			$('.rhc-help-notice').fadeOut();
		},'json');
	});
	$('#btn_confirm_rhc_setup').unbind('click').click(function(e){
		$.post( ajaxurl, {action:'confirm_rhc_setup'},function(data){
			$('.rhc-setup-notice').fadeOut();
			document.location.reload(true);
		},'json');
	});
	$('#btn_dismiss_rhc_setup').unbind('click').click(function(e){
		$.post( ajaxurl, {action:'dismiss_rhc_setup'},function(data){
			$('.rhc-setup-notice').fadeOut();
			document.location.reload(true);
		},'json');
	});
});