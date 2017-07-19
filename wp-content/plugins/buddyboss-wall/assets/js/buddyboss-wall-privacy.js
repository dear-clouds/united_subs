if ( typeof jq == "undefined" )
	var jq = jQuery;

jq(document).ready( function() {

	jq('span#activity-visibility').prependTo('div#whats-new-submit');
	jq("input#aw-whats-new-submit").off("click");

	var selected_item_id = jq("select#whats-new-post-in").val();

	jq("select#whats-new-post-in").data('selected', selected_item_id );
	//if selected item is not 'My profile'
	if( 'undefined' != typeof visibility_levels && selected_item_id != undefined && selected_item_id != 0 ){
		jq('select#bbwall-activity-privacy').replaceWith(visibility_levels.groups);
	}

	jq("select#whats-new-post-in").on("change", function() {
		var old_selected_item_id = jq(this).data('selected');
		var item_id = jq("#whats-new-post-in").val();

		if( 'undefined' != typeof visibility_levels ) {
			if(item_id == 0 && item_id != old_selected_item_id){
				jq('select#bbwall-activity-privacy').replaceWith(visibility_levels.profile);
			}else{
				if(item_id != 0 && old_selected_item_id == 0 ){
					jq('select#bbwall-activity-privacy').replaceWith(visibility_levels.groups);
				}
			}
		}
		jq('select#bbwall-activity-privacy').next().remove();
		jq(this).data('selected',item_id);
	});

	/* New posts */
	jq("input#aw-whats-new-submit").on('click', function() {
		var button = jq(this);
		var form = button.parent().parent().parent().parent();

		form.children().each( function() {
			if ( jq.nodeName(this, "textarea") || jq.nodeName(this, "input") )
				jq(this).prop( 'disabled', true );
		});

		/* Remove any errors */
		jq('div.error').remove();
		button.addClass('loading');
		button.prop('disabled', true);

		/* Default POST values */
		var object = '';
		var item_id = jq("#whats-new-post-in").val();
		var content = jq("textarea#whats-new").val();
		var visibility = jq("select#bbwall-activity-privacy").val();

		/* Set object for non-profile posts */
		if ( item_id > 0 ) {
			object = jq("#whats-new-post-object").val();
		}

		if (typeof bp_get_cookies == 'function')
			var cookie = bp_get_cookies();
    	else 
    		var cookie = encodeURIComponent(document.cookie);

		jq.post( ajaxurl, {
			action: 'post_update',
			'cookie': cookie,
			'_wpnonce_post_update': jq("input#_wpnonce_post_update").val(),
			'content': content,
			'visibility': visibility,
			'object': object,
			'item_id': item_id,
			'_bp_as_nonce': jq('#_bp_as_nonce').val() || ''
		},
		function(response) {

			form.children().each( function() {
				if ( jq.nodeName(this, "textarea") || jq.nodeName(this, "input") ) {
					jq(this).prop( 'disabled', false );
				}
			});

			/* Check for errors and append if found. */
			if ( response[0] + response[1] == '-1' ) {
				form.prepend( response.substr( 2, response.length ) );
				jq( 'form#' + form.attr('id') + ' div.error').hide().fadeIn( 200 );
			} else {
				if ( 0 == jq("ul.activity-list").length ) {
					jq("div.error").slideUp(100).remove();
					jq("div#message").slideUp(100).remove();
					jq("div.activity").append( '<ul id="activity-stream" class="activity-list item-list">' );
				}

				jq("ul#activity-stream").prepend(response);
				jq("ul#activity-stream li:first").addClass('new-update');

				jq("li.new-update").hide().slideDown( 300 );
				jq("li.new-update").removeClass( 'new-update' );
				jq("textarea#whats-new").val('');
			}

			jq("#whats-new-options").animate({
				height:'0px'
			});
			jq("form#whats-new-form textarea").animate({
				height:'20px'
			});
			jq("#aw-whats-new-submit").prop("disabled", true).removeClass('loading');

			//reset the privacy selection
			jq("select#bbwall-activity-privacy option[selected]").prop('selected', true).trigger('change');

		});

		return false;
	} );

});

//Adding the privacy filter form 
function buddyboss_wall_initiate_privacy_form( link ) {
	$link = $( link );

	//privacy edit form
	if ( 0 == jq( '#form_buddyboss-wall-privacy').length ) {
		//privacy edit form script template
		var form_tpl = $('#buddyboss-wall-form-wrapper-tpl').html();
		$form = jq(form_tpl).find('#form_buddyboss-wall-privacy');
	} else {
		$form = jq('#form_buddyboss-wall-privacy');
	}

	$form_wrapper = $form.parent();

	//slideup comment form
	$link.closest( '.activity' ).find( 'form.ac-form' ).slideUp();

	if ( $form_wrapper.is( ':visible' ) ) {
		buddyboss_wall_privacy_close();
		return false;
	}

	//Tab should auto close on opening another tab.
	$('.buddyboss-activity-comments-form').hide();

	$link.closest( '.activity-content' ).after( $form_wrapper );

	//Highlight previously selected option
	$selected_visibilty = $link.data( 'visibility' );
	$selected_visibilty_group = $link.hasClass( 'buddyboss-group-privacy-filter' );

	if ( (! $selected_visibilty_group && $selected_visibilty === 'grouponly') || !$selected_visibilty ) {
		$selected_visibilty = 'public';
	} 
	$form.find( '#bbwall-privacy-selectbox' ).val( $selected_visibilty );

	$form_wrapper.slideDown( 200 );
	bbmedia_move_media_opened = true;

	//setup form data
	$form.find( 'input[name="activity_id"]' ).val( $link.data( 'activity_id' ) );

	return false;
}

//Closing the privacy filter form 
function buddyboss_wall_privacy_close(){
    $form = $('#form_buddyboss-wall-privacy');
    $form_wrapper = $form.parent();
    
    $form_wrapper.slideUp(200);
    bbmedia_move_media_opened = false;
    
    return false;
}

//Old post privacy filter form
function buddyboss_wall_submit_privacy() {
	$form = $( '#form_buddyboss-wall-privacy' );
	$form_wrapper = $form.parent();
	$submit_button = $form.find( 'input[type="submit"]' );
	$animated_loader = $form.find('.privacy-filter-ajax-loader');

	if ( $submit_button.hasClass( 'loading' ) )
		return false;//previous request hasn't finished yet!
	
	$animated_loader.css('display','inline-block');

	/**
	 * 1. gather data
	 * 2. start ajax
	 * 3. receive response
	 * 4. process response
	 *      - remove loading class
	 *      - remove activity item entry if required
	 *		- move form to a different place first
	 *      - slideup form
	 */

	var data = {
		'action': 'buddyboss_wall_update_activity_privacy',
		'bboss_wall_privacy_nonce': $form.find( 'input[name="bboss_wall_privacy_nonce"]' ).val(),
		'activity_id': $form.find( 'input[name="activity_id"]' ).val(),
		'buddyboss_activity_visibility': $form.find( 'select[name="bbwall-privacy-selectbox"]' ).val()
	};

	$submit_button.addClass( 'loading' );
	$form.find( "#message" ).removeAttr( 'class' ).html( '' );

	$.ajax( {
		type: "POST",
		url: ajaxurl,
		data: data,
		success: function ( response ) {
			
			$curr_visibility = $form.find( '#bbwall-privacy-selectbox' ).val();
			$form_wrapper.closest( '.activity' ).find( '.buddyboss_privacy_filter' ).data( 'visibility', $curr_visibility );
			$animated_loader.hide();
			
			response = $.parseJSON( response );
			if ( response.status ) {
				$form.find( "#message" ).addClass( 'updated' ).html( "<p>" + response.message + "</p>" );
				setTimeout( function () {
					buddyboss_wall_privacy_cleanup( $form, false );
				}, 2000 );
			} else {
				$form.find( "#message" ).addClass( 'error' ).html( "<p>" + response.message + "</p>" );
			}

			$submit_button.removeClass( 'loading' );
		}
	} );

	return false;
}

// Clean up display message
function buddyboss_wall_privacy_cleanup( $form, remove_activity_item ) {
	$form.find( "#message" ).removeAttr( 'class' ).html( '' );
	$form_wrapper = $form.parent();

	buddyboss_wall_privacy_close();
	if ( remove_activity_item ) {
		$activity = $form.closest( '.activity' );

		$( 'body' ).append( $form_wrapper );
		$form_wrapper.hide();
		$activity.slideUp( 200, function () {
			$activity.remove();
		} );
	}
}
