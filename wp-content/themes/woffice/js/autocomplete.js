(function( $ ) {
	$(function() {
		var url = WofficeAutocomplete.url + "?action=woffice_search";
		$("#s").autocomplete({
			source: url,
			delay: 500,
			minLength: 2,
			position: { my : "right top", at: "right bottom" },
			search: function( event, ui ) {
				$("#main-search form").append('<i class="fa fa-spin fa-refresh"></i>');
			},
			response: function( event, ui ) {
				$("#main-search form .fa-spin").remove();
			}
		});
		/*var url_members = WofficeAutocomplete.url + "?action=wofficeSearchMembers";
		$("#members_search").autocomplete({
			source: [ "c++", "java", "php", "coldfusion", "javascript", "asp", "ruby" ],
			delay: 500,
			minLength: 2,
			search: function( event, ui ) {
				$("#search-members-form label").append('<i class="fa fa-spin fa-refresh"></i>');
			},
			response: function( event, ui ) {
				$("#search-members-form label .fa-spin").remove();
			}

		});*/
	});

})( jQuery );