(function($){
	
	"use strict";
	
	$(document).ready(function(){

		// namespace
		var importer = $('.kleo-import');

		// reset select
		$('select.import', importer).val('');

		// disable submit button
		$('.button.advanced', importer).attr('disabled','disabled');

		// select.import change
		$('select.import', importer).change(function(){

			var val = $(this).val();

			// submit button
			if( val ){
				$('.button.advanced', importer).removeAttr('disabled');
			} else {
				$('.button.advanced', importer).attr('disabled','disabled');
			}

			// content
			if( val == 'content' ){
				$('.row-content', importer).show();
			} else {
				$('.row-content', importer).hide();
			}

			// homepage
			if( val == 'page' ){
				$('.row-homepage', importer).show();
			} else {
				$('.row-homepage', importer).hide();
			}

		});

        $('select[name=page], select[name=content], select.import', importer).change(function(){
            var attach = $(this).find('option:selected').attr('data-attach');
            if (typeof attach !== typeof undefined && attach !== false) {
                $('.row-attachments', importer).show();
            } else {
                $('.row-attachments', importer).hide();
            }

        });

		/*$("input.check-attachment").on("change", function() {
			if( $(this).is(":checked")) {
				$(this).closest('.to-left').find("input.check-page").prop('checked', true);
			}
		});*/

		/* Un-check the Attachments checkbox if no page is checked */
		$("input.check-page").on("change", function() {
			var inputContainer = $(this).closest('.to-left');
			if( inputContainer.find("input.check-page:checked").length == 0 ) {

				/* Set initial state before un-checking */
				if (inputContainer.find("input.check-attachment").prop('checked') == true) {
					inputContainer.find("input.check-attachment").data('initial-state', 'checked');
				} else {
					inputContainer.find("input.check-attachment").data('initial-state', 'unchecked');
				}

				inputContainer.find("input.check-attachment").prop('disabled', true);
				inputContainer.find("input.check-attachment").prop('checked', false);

			} else {
				inputContainer.find("input.check-attachment").prop('disabled', false);

				if (inputContainer.find("input.check-page:checked").length == 1 && $(this).is(":checked") && inputContainer.find("input.check-attachment").data('initial-state')) {
					var initialState = inputContainer.find("input.check-attachment").data('initial-state');

					if (initialState == 'checked') {
						inputContainer.find("input.check-attachment").prop('checked', true);
					}
				}
			}
		});



		$(".to-left input[type=checkbox]").on("change", function() {
			var $isChecked = false;
			$(this).closest('.to-left').find('input[type=checkbox]').each(function (index, element) {
				if( $(this).is(":checked")) {
					$isChecked = true;
				}
			});

			if ($isChecked === false) {
				$(this).closest(".demo-options").find('.import-demo-btn').prop('disabled', true);
			} else {
				$(this).closest(".demo-options").find('.import-demo-btn').prop('disabled', false);
			}
		});
		
	});

})(jQuery);