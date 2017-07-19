jQuery(document).ready(function($) {
	$( '.widget-liquid-right' ).append( '<div id="mom_add_custom_sidebar" class="widgets-holder-wrap"><div><label><h3>Add New Custom Sidebar</h3><input id="mom_custom_sidebar" value="" type="text"/></label></div><button class="button button-primary button-large mom_create_custom_sidebar">Add new Sidebar</button></div>' );

	var $custom_sidebar = $('#mom_add_custom_sidebar');

	$custom_sidebar.find( '.mom_create_custom_sidebar' ).click( function( e ) {
			var t = $(this);
			var val = t.parent().find('#mom_custom_sidebar').val();

			e.preventDefault();

			if ( val === '' ) return;

			$.ajax( {
				type: "POST",
				url: mom_admin_ajax.url,
				data: "action=mom_add_custom_sidebar&nonce="+mom_admin_ajax.nonce+"&sidebar_name="+val,
				success: function( data ){
					window.location.reload();
				}
			} );
		} );

	$('.sidebar-momizat-custom').find('.widgets-sortables').append('<div id="major-publishing-actions" class="mom_custom_sidebar_delete hidden"><a href="#">'+mom_admin_ajax.delete+'</a></div>');

		$( '.sidebar-momizat-custom .mom_custom_sidebar_delete a').click( function( e ) {
			var t = $(this);
			var key = t.parent().parent().attr('id');

			e.preventDefault();

		var yes = confirm(mom_admin_ajax.confirm_delete);
		if (yes===true) {
			$.ajax( {
				type: "POST",
				url: mom_admin_ajax.url,
				data: "action=mom_delete_custom_sidebar&nonce="+mom_admin_ajax.nonce+"&key="+key,
				success: function( data ){
						t.parent().parent().parent().slideUp();
				}
			} );
		}
		} );

});