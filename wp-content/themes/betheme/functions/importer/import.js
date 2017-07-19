(function($){
	
	"use strict";
	
	$(document).ready(function(){
		
		// namespace
		var importer = $('.mfn-demo-data');
		
		// reset select
		$('select.import', importer).val('');
		
		// disable submit button
		$('.button', importer).attr('disabled','disabled');
		
		// select.import change
		$('select.import', importer).change(function(){
			
			var val = $(this).val();
			
			// submit button
			if( val ){
				$('.button', importer).removeAttr('disabled');
			} else {
				$('.button', importer).attr('disabled','disabled');
			}
			
			// attachments
			if( val == 'all' || val == 'demo' ){
				$('.row-attachments', importer).show();
			} else {
				$('.row-attachments', importer).hide();
			}
			
			// content
			if( val == 'content' ){
				$('.row-content', importer).show();
			} else {
				$('.row-content', importer).hide();
			}
			
			// demo
			if( val == 'demo' ){
				$('.row-demo', importer).show();
			} else {
				$('.row-demo', importer).hide();
			}
			
			// homepage
			if( val == 'homepage' ){
				$('.row-homepage', importer).show();
			} else {
				$('.row-homepage', importer).hide();
			}
			
		});
		
	});

})(jQuery);