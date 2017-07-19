jQuery(document).ready(function() {
	jQuery('.userpro-datepicker').datepicker({
		
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		showOtherMonths: true,
		selectOtherMonths: true,
		dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
		yearRange: 'c-65:c+0'
   
 });
 });

jQuery(document).ready(function() {
	
	/* Toggle selection of roles in post screen */
	jQuery(document).on('click', 'input[name=userpro_edit_restrict]', function(){
		if (jQuery(this).val() == 'roles'){
			jQuery('p.restrict_roles').show( function(){
				jQuery("p.restrict_roles select").removeClass("chzn-done").css('display', 'inline').data('chosen', null);
				jQuery("p.restrict_roles *[class*=chzn], p.restrict_roles .chosen-container").remove();
				jQuery("p.restrict_roles .chosen-select").chosen({
					disable_search_threshold: 10
				});
			});
		} else {
			jQuery('p.restrict_roles').hide();
		}
	});

	if (jQuery('input[name=userpro_edit_restrict]:checked').val() == 'roles' ){
			jQuery('p.restrict_roles').show( function(){
				jQuery("p.restrict_roles select").removeClass("chzn-done").css('display', 'inline').data('chosen', null);
				jQuery("p.restrict_roles *[class*=chzn], p.restrict_roles .chosen-container").remove();
				jQuery("p.restrict_roles .chosen-select").chosen({
					disable_search_threshold: 10
				});
			});
	} else {
	
	}

	/* Toggle admin screen headings */
	if ( jQuery('div.userpro-admin h3').length <= 3) {
		jQuery('div.userpro-admin h3:first').addClass('selected');
		jQuery('div.userpro-admin h3:first').next('table.form-table, .upadmin-panel').show();
		jQuery('table[data-type=conditional]').hide();
		jQuery('table[rel=' + jQuery('#badge_method').val() + ']').show();
		jQuery(".userpro-admin select").removeClass("chzn-done").css('display', 'inline').data('chosen', null);
		jQuery(".userpro-admin *[class*=chzn], .userpro-admin .chosen-container").remove();
		jQuery(".userpro-admin .chosen-select").chosen({
			disable_search_threshold: 10
		});
	}
	
	/* Expand table under h3 */
	jQuery(document).on('click', 'div.userpro-admin h3:not(.selected)', function(){
		jQuery(this).addClass('selected');
		jQuery(this).next('table.form-table, .upadmin-panel').show();
		jQuery('table[data-type=conditional]').hide();
		jQuery('table[rel=' + jQuery('#badge_method').val() + ']').show();
		jQuery(".userpro-admin select").removeClass("chzn-done").css('display', 'inline').data('chosen', null);
		jQuery(".userpro-admin *[class*=chzn], .userpro-admin .chosen-container").remove();
		jQuery(".userpro-admin .chosen-select").chosen({
			disable_search_threshold: 10
		});
	});
	
	/* Collapse table under h3 */
	jQuery(document).on('click', 'div.userpro-admin h3.selected', function(){
		jQuery(this).removeClass('selected');
		jQuery(this).next('table.form-table, .upadmin-panel').hide();
	});
	
	/* deny user registration */
	jQuery(document).on('click', '.upadmin-user-deny', function(e){
		e.preventDefault();
		var link = jQuery(this);
		var parent = jQuery(this).parents('.upadmin-pending-verify');
		jQuery.ajax({
			url: ajaxurl,
			data: 'action=userpro_admin_user_deny&user_id=' + jQuery(this).data('user'),
			dataType: 'JSON',
			type: 'POST',
			success:function(data){
				parent.fadeOut();
				if (data.count === '0' || data.count == '' || !data.count) {
					jQuery('.upadmin-bubble-new').remove();
				} else {
					jQuery('.upadmin-bubble-new').html( data.count );
				}
				jQuery('.toplevel_page_userpro').find('span.update-count').html( data.count );
			}
		});
		return false;
	});

jQuery(document).on('change', '#userpro_sortby_verified', function(e){

	var e = document.getElementById("userpro_sortby_verified");
        var selectedval = e.options[e.selectedIndex].value;
	
	if(selectedval=="descending")
	{
	
		var $divs = jQuery("div.boxv");
	 	var alphabeticallyOrderedDivs = $divs.sort(function (a, b) {
        	return jQuery(a).find("p").text() < jQuery(b).find("p").text();
   		 });
    		jQuery("#containerv").html(alphabeticallyOrderedDivs);
	}
	if(selectedval=="ascending")
	{

		var $divs = jQuery("div.boxv");
	 	var alphabeticallyOrderedDivs = $divs.sort(function (a, b) {
        	return jQuery(a).find("p").text() > jQuery(b).find("p").text();
   		 });
    		jQuery("#containerv").html(alphabeticallyOrderedDivs);

	}
	if(selectedval=="default")
	{
		
		
		var alphabeticallyOrderedDivs = jQuery("#containerv").find('.boxv').sort(function (a, b) {
 		   return parseInt(a.id) > parseInt(b.id);
		});
		jQuery("#containerv").html(alphabeticallyOrderedDivs);

	}


});




	jQuery(document).on('change', '#userpro_sortby_manual', function(e){

	var e = document.getElementById("userpro_sortby_manual");
        var selectedval = e.options[e.selectedIndex].value;
	
	if(selectedval=="descending")
	{
	
		var $divs = jQuery("div.box");
	 	var alphabeticallyOrderedDivs = $divs.sort(function (a, b) {
        	return jQuery(a).find("p").text() < jQuery(b).find("p").text();
   		 });
    		jQuery("#container").html(alphabeticallyOrderedDivs);
	}
	if(selectedval=="ascending")
	{

		var $divs = jQuery("div.box");
	 	var alphabeticallyOrderedDivs = $divs.sort(function (a, b) {
        	return jQuery(a).find("p").text() > jQuery(b).find("p").text();
   		 });
    		jQuery("#container").html(alphabeticallyOrderedDivs);

	}
	if(selectedval=="default")
	{
		
		
		var alphabeticallyOrderedDivs = jQuery("#container").find('.box').sort(function (a, b) {
 		   return parseInt(a.id) > parseInt(b.id);
		});
		jQuery("#container").html(alphabeticallyOrderedDivs);

	}


});

	jQuery(document).on('change', '#userpro_sortby_email', function(e){

	var e = document.getElementById("userpro_sortby_email");
        var selectedval = e.options[e.selectedIndex].value;
	
	if(selectedval=="descending")
	{
		
		
		var $divs = jQuery("div.boxe");
	 	var alphabeticallyOrderedDivs = $divs.sort(function (a, b) {
        	return jQuery(a).find("p").text() < jQuery(b).find("p").text();
   		 });
    		jQuery("#containere").html(alphabeticallyOrderedDivs);
	}
	if(selectedval=="ascending")
	{

		var $divs = jQuery("div.boxe");
	 	var alphabeticallyOrderedDivs = $divs.sort(function (a, b) {
        	return jQuery(a).find("p").text() > jQuery(b).find("p").text();
   		 });
    		jQuery("#containere").html(alphabeticallyOrderedDivs);

	}
	if(selectedval=="default")
	{
		
		
		
		var alphabeticallyOrderedDivs = jQuery("#containere").find('.boxe').sort(function (a, b) {
 		   return parseInt(a.id) > parseInt(b.id);
		});
		jQuery("#containere").html(alphabeticallyOrderedDivs);

	}


});


	/* approve user registration */
	jQuery(document).on('click', '.upadmin-user-approve', function(e){
		e.preventDefault();
		var link = jQuery(this);
		var parent = jQuery(this).parents('.upadmin-pending-verify');
		jQuery.ajax({
			url: ajaxurl,
			data: 'action=userpro_admin_user_approve&user_id=' + jQuery(this).data('user'),
			dataType: 'JSON',
			type: 'POST',
			success:function(data){
				parent.fadeOut();
				if (data.count === '0' || data.count == '' || !data.count) {
					jQuery('.upadmin-bubble-new').remove();
				} else {
					jQuery('.upadmin-bubble-new').html( data.count );
				}
				jQuery('.toplevel_page_userpro').find('span.update-count').html( data.count );
			}
		});
		return false;
	});
	
	/* Verify user */
	jQuery(document).on('click', '.upadmin-verify-u', function(e){
		e.preventDefault();
		var link = jQuery(this);
		var parent = jQuery(this).parents('.upadmin-verify-v2');
		jQuery.ajax({
			url: ajaxurl,
			data: 'action=userpro_verify_user&user_id=' + link.data('user'),
			dataType: 'JSON',
			type: 'POST',
			success:function(data){
				parent.hide().html( data.admin_tpl ).fadeIn();
			}
		});
		return false;
	});
	
	/* Unverify user */
	jQuery(document).on('click', '.upadmin-unverify-u', function(e){
		e.preventDefault();
		var link = jQuery(this);
		var parent = jQuery(this).parents('.upadmin-verify-v2');
		jQuery.ajax({
			url: ajaxurl,
			data: 'action=userpro_unverify_user&user_id=' + link.data('user'),
			dataType: 'JSON',
			type: 'POST',
			success:function(data){
				parent.hide().html( data.admin_tpl ).fadeIn();
			}
		});
		return false;
	});
	
	/* Verification invite */
	jQuery(document).on('click', '.upadmin-invite-u', function(e){
		e.preventDefault();
		var link = jQuery(this);
		var parent = jQuery(this).parents('.upadmin-verify-v2');
		jQuery.ajax({
			url: ajaxurl,
			data: 'action=userpro_verify_invite&user_id=' + link.data('user'),
			dataType: 'JSON',
			type: 'POST',
			success:function(data){
				parent.hide().html( data.admin_tpl ).fadeIn();
			}
		});
		return false;
	});
	
	/* Verify user */
	jQuery(document).on('click', '.upadmin-verify', function(e){
		e.preventDefault();
		var link = jQuery(this);
		var parent = jQuery(this).parents('.upadmin-pending-verify');
		jQuery.ajax({
			url: ajaxurl,
			data: 'action=userpro_verify_user&user_id=' + jQuery(this).data('user'),
			dataType: 'JSON',
			type: 'POST',
			success:function(data){
				parent.fadeOut();
				if (data.count === '0' || data.count == '' || !data.count) {
					jQuery('.upadmin-bubble-new').remove();
				} else {
					jQuery('.upadmin-bubble-new').html( data.count );
				}
				jQuery('.toplevel_page_userpro').find('span.update-count').html( data.count );
			}
		});
		return false;
	});
	
	/* Unverify user */
	jQuery(document).on('click', '.upadmin-unverify', function(e){
		e.preventDefault();
		var link = jQuery(this);
		var parent = jQuery(this).parents('.upadmin-pending-verify');
		jQuery.ajax({
			url: ajaxurl,
			data: 'action=userpro_unverify_user&user_id=' + jQuery(this).data('user'),
			dataType: 'JSON',
			type: 'POST',
			success:function(data){
				parent.fadeOut();
				if (data.count === '0' || data.count == '' || !data.count) {
					jQuery('.upadmin-bubble-new').remove();
				} else {
					jQuery('.upadmin-bubble-new').html( data.count );
				}
				jQuery('.toplevel_page_userpro').find('span.update-count').html( data.count );
			}
		});
		return false;
	});
	
	/*  Block user */
	jQuery(document).on('click', '.upadmin-block-u', function(e){
		e.preventDefault();
		$res = window.confirm( "Are you sure you want to block this user ?" );
		if(!$res){
			return;
		}
		var link = jQuery(this);
		var parent = jQuery(this).parents('.upadmin-block-v2');
		jQuery.ajax({
			url: ajaxurl,
			data: 'action=userpro_block_account&user_id=' + link.data('user'),
			dataType: 'JSON',
			type: 'POST',
			success:function(data){
				parent.hide().html( data.admin_tpl ).fadeIn();
			}
		});
		return false;
	});
	
	/* Unblock user */
	jQuery(document).on('click', '.upadmin-unblock-u', function(e){
		e.preventDefault();
		var link = jQuery(this);
		var parent = jQuery(this).parents('.upadmin-block-v2');
		jQuery.ajax({
			url: ajaxurl,
			data: 'action=userpro_unblock_account&user_id=' + link.data('user'),
			dataType: 'JSON',
			type: 'POST',
			success:function(data){
				parent.hide().html( data.admin_tpl ).fadeIn();
			}
		});
		return false;
	});
	/* Mouseenter/leave verify user */
	jQuery(document).on('mouseenter', '.upadmin-unverify,.upadmin-verify', function(e){
		jQuery(this).find('span').show();
	})
	
	jQuery(document).on('mouseleave', '.upadmin-unverify,.upadmin-verify', function(e){
		jQuery(this).find('span').hide();
	});

	/* cancel field editing */
	jQuery(document).on('click', '.upadmin-field-zone-cancel', function(e){
		e.preventDefault();
		jQuery(this).parents('.upadmin-field-zone').hide();
		return false;
	});
	
	/* chosen select */
	jQuery(".chosen-select").chosen({
		disable_search_threshold: 10
	});
	
	/* Setup field options (multi choice) */
	jQuery(document).on('change', '#upadmin_n_type', function(e){
		var type = jQuery(this).val();
		if( type == 'select' || type == 'multiselect' || type == 'radio' || type == 'radio-full' || type == 'checkbox' || type == 'checkbox-full' ) {
			jQuery('.choicebased').show();
		} else {
			jQuery('.choicebased').hide();
		}
		if ( type == 'file' ) {
			jQuery('.filetypes').show();
		} else {
			jQuery('.filetypes').hide();
		}
	});
	
	/* Custom input show/hide */
	if (jQuery('#dashboard_redirect_users').val()==2){
		jQuery('#dashboard_redirect_users').parents('td').find('.userpro-admin-hide-input').css({'display':'block'});
	}
	if (jQuery('#profile_redirect_users').val()==2){
		jQuery('#profile_redirect_users').parents('td').find('.userpro-admin-hide-input').css({'display':'block'});
	}
	if (jQuery('#register_redirect_users').val()==2){
		jQuery('#register_redirect_users').parents('td').find('.userpro-admin-hide-input').css({'display':'block'});
	}
	if (jQuery('#login_redirect_users').val()==2){
		jQuery('#login_redirect_users').parents('td').find('.userpro-admin-hide-input').css({'display':'block'});
	}
	jQuery('#dashboard_redirect_users,#profile_redirect_users,#register_redirect_users,#login_redirect_users').change(function(){
		if (jQuery(this).val() == 2) {
			jQuery(this).parents('td').find('.userpro-admin-hide-input').css({'display':'block'});
		} else {
			jQuery(this).parents('td').find('.userpro-admin-hide-input').css({'display':'none'});
		}
	});
	
	/* the main field list actions */
	jQuery(document).on('click', '#upadmin-sortable-fields .upadmin-field-actions a', function(e){
		e.preventDefault();
		var act = jQuery(this).attr('class');
		var field = jQuery(this).parents('li').attr('id').replace('upadmin-','');
		var load = jQuery(this).parents('.upadmin-fieldlist').find('.upadmin-loader');
		
		if (act == 'upadmin-field-action-remove') {
			if (!confirm('Are you sure you want to delete field from your fields list?')) return false;
			load.addClass('loading');
			jQuery(this).parents('li').fadeOut();
			jQuery.ajax({
				url: ajaxurl,
				data: 'action=userpro_delete_field&field=' + field,
				dataType: 'JSON',
				type: 'POST',
				success:function(data){
					load.removeClass('loading');
					jQuery('span.upadmin-ajax-fieldcount').html( data.count );
				}
			});
		}
		
		if (act == 'upadmin-field-action-edit') {
			jQuery(this).parents('li').find('.upadmin-field-zone').toggle();
		}
		
		return false;
	});
	
	/* blur field edit */
	jQuery(document).on('change', '#upadmin-sortable-fields .upadmin-field-zone input, #upadmin-sortable-fields .upadmin-field-zone select, #upadmin-sortable-fields .upadmin-field-zone textarea', function(e){
	
		var load = jQuery(this).parents('.upadmin-fieldlist').find('.upadmin-loader');
		load.addClass('loading');
		var field = jQuery(this).parents('li').attr('id').replace('upadmin-','');		
		var str = '';
		jQuery(this).parents('li').find('input[type=text]').each(function(){
			str = str + '&' + jQuery(this).attr('id').replace(field + '-','') + '=' + jQuery(this).val();
		});
		jQuery(this).parents('li').find('textarea').each(function(){
			str = str + '&' + jQuery(this).attr('id').replace(field + '-','') + '=' + jQuery(this).val();
		});

		jQuery.ajax({
			url: ajaxurl,
			data: 'action=userpro_update_field&field=' + field + str,
			//dataType: 'JSON',
			type: 'POST',
			success:function(data){
				load.removeClass('loading');
			}
		});
		
	});

	/* click on action of field */
	jQuery(document).on('click', '.upadmin-groups .upadmin-field-actions a', function(e){
	
		e.preventDefault();
		var form = jQuery(this).parents('.upadmin-tpl').find('form');
		var act = jQuery(this).attr('class');
		var proc = jQuery(this).data('proc');
		if (act == 'upadmin-field-action-remove') {
			if (!confirm('Are you sure you want to delete field from this group?')) return false;
			jQuery(this).parents('li').fadeOut(function(){jQuery(this).remove(); form.trigger('submit');});
		}
		if (act == 'upadmin-field-action-edit') {
			jQuery(this).parents('li').find('.upadmin-field-zone').toggle();
		}
		if (act == 'upadmin-field-action upadmin-field-action-hideable off') {
			jQuery(this).removeClass('off').addClass('on');jQuery(this).parents('li').find('input[name=' + jQuery(this).data('key') + '-' + jQuery(this).data('role') + ']').val(1);form.trigger('submit');}
		if (act == 'upadmin-field-action upadmin-field-action-hideable on') {
			jQuery(this).removeClass('on').addClass('off');jQuery(this).parents('li').find('input[name=' + jQuery(this).data('key') + '-' + jQuery(this).data('role') + ']').val(0);form.trigger('submit');}
		if (act == 'upadmin-field-action upadmin-field-action-hidden off') {
			jQuery(this).removeClass('off').addClass('on');jQuery(this).parents('li').find('input[name=' + jQuery(this).data('key') + '-' + jQuery(this).data('role') + ']').val(1);form.trigger('submit');}
		if (act == 'upadmin-field-action upadmin-field-action-hidden on') {
			jQuery(this).removeClass('on').addClass('off');jQuery(this).parents('li').find('input[name=' + jQuery(this).data('key') + '-' + jQuery(this).data('role') + ']').val(0);form.trigger('submit');}
		if (act == 'upadmin-field-action upadmin-field-action-required off') {
			jQuery(this).removeClass('off').addClass('on');jQuery(this).parents('li').find('input[name=' + jQuery(this).data('key') + '-' + jQuery(this).data('role') + ']').val(1);form.trigger('submit');}
		if (act == 'upadmin-field-action upadmin-field-action-required on') {
			jQuery(this).removeClass('on').addClass('off');jQuery(this).parents('li').find('input[name=' + jQuery(this).data('key') + '-' + jQuery(this).data('role') + ']').val(0);form.trigger('submit');}
		if (act == 'upadmin-field-action upadmin-field-action-locked off') {
			jQuery(this).removeClass('off').addClass('on');jQuery(this).parents('li').find('input[name=' + jQuery(this).data('key') + '-' + jQuery(this).data('role') + ']').val(1);form.trigger('submit');}
		if (act == 'upadmin-field-action upadmin-field-action-locked on') {
			jQuery(this).removeClass('on').addClass('off');jQuery(this).parents('li').find('input[name=' + jQuery(this).data('key') + '-' + jQuery(this).data('role') + ']').val(0);form.trigger('submit');}
		if (act == 'upadmin-field-action upadmin-field-action-private off') {
			jQuery(this).removeClass('off').addClass('on');jQuery(this).parents('li').find('input[name=' + jQuery(this).data('key') + '-' + jQuery(this).data('role') + ']').val(1);form.trigger('submit');}
		if (act == 'upadmin-field-action upadmin-field-action-private on') {
			jQuery(this).removeClass('on').addClass('off');jQuery(this).parents('li').find('input[name=' + jQuery(this).data('key') + '-' + jQuery(this).data('role') + ']').val(0);form.trigger('submit');}
		if (act == 'upadmin-field-action upadmin-field-action-html off') {
			jQuery(this).removeClass('off').addClass('on');jQuery(this).parents('li').find('input[name=' + jQuery(this).data('key') + '-' + jQuery(this).data('role') + ']').val(1);form.trigger('submit');}
		if (act == 'upadmin-field-action upadmin-field-action-html on') {
			jQuery(this).removeClass('on').addClass('off');jQuery(this).parents('li').find('input[name=' + jQuery(this).data('key') + '-' + jQuery(this).data('role') + ']').val(0);form.trigger('submit');}
		return false;
	});
	
	/* blur field edit */
	jQuery(document).on('change', '.upadmin-groups .upadmin-field-zone input, .upadmin-groups .upadmin-field-zone select, .upadmin-groups .upadmin-field-zone textarea', function(e){
		var form = jQuery(this).parents('.upadmin-tpl').find('form');
		form.trigger('submit');
	});

	/* toggle adding new field */
	jQuery(document).on('click', '.upadmin-toggle-new', function(e){
		e.preventDefault();
		var new_field = jQuery('.upadmin-new');
		if (new_field.is(':hidden')){
		new_field.show();
		
			/* chosen dropdowns */
			jQuery(".upadmin-new select").removeClass("chzn-done").css('display', 'inline').data('chosen', null);
			jQuery(".upadmin-new *[class*=chzn], .upadmin-new .chosen-container").remove();
			jQuery(".upadmin-new .chosen-select").chosen({
				disable_search_threshold: 10
			});
			
		}else{
		new_field.hide();
		}
		return false;
	});
	
	/* icon clicks */
	jQuery(document).on('click', '.upadmin-icon-abs a:not(.upadmin-noajax)', function(e){
		e.preventDefault();
		return false;
	});

	/* toggle/un-toggle field groups */
	jQuery(document).on('click', '.upadmin-icon-abs a.max', function(e){
		var tpl = jQuery(this).parents('.upadmin-tpl');
		tpl.find('.upadmin-tpl-body').removeClass('max').addClass('min');
		tpl.find('.upadmin-tpl-head').removeClass('max').addClass('min');
		jQuery(this).removeClass('max').addClass('min');
	});
	
	jQuery(document).on('click', '.upadmin-icon-abs a.min', function(e){
		var tpl = jQuery(this).parents('.upadmin-tpl');
		tpl.find('.upadmin-tpl-body').removeClass('min').addClass('max');
		tpl.find('.upadmin-tpl-head').removeClass('min').addClass('max');
		jQuery(this).removeClass('min').addClass('max');
	});
	
	/* cancel new field div */
	jQuery(document).on('click', '#upadmin_n_cancel', function(e){
		e.preventDefault();
		var new_field = jQuery('.upadmin-new');
		new_field.hide();
		return false;
	});
	
	/* reset original fields */
	jQuery(document).on('click', '.upadmin-reset-fields', function(e){
	
		e.preventDefault();
		form = jQuery(this).parents('.upadmin-fieldlist');
		if (!confirm('This will restore original plugin fields. Are you sure?')) return false;
		form.find('.upadmin-loader').addClass('loading');
		jQuery.ajax({
			url: ajaxurl,
			data: 'action=userpro_restore_builtin_fields',
			dataType: 'JSON',
			type: 'POST',
			success:function(data){
				form.find('.upadmin-loader').removeClass('loading');
				jQuery('span.upadmin-ajax-fieldcount').html( data.count );
				jQuery('ul#upadmin-sortable-fields').html( data.html );
			}
		});
		return true;
	});

	/* reset all groups */
	jQuery(document).on('click', '.upadmin-reset-groups', function(e){
		e.preventDefault();
		form = jQuery(this).parents('.upadmin-groups');
		if (!confirm('This will restore original fields for ALL groups. Are you sure?')) return false;
		form.find('.upadmin-loader').addClass('loading');
		jQuery.ajax({
			url: ajaxurl,
			data: 'action=userpro_restore_builtin_groups',
			dataType: 'JSON',
			type: 'POST',
			success:function(data){
				form.find('.upadmin-loader').removeClass('loading');
				jQuery('.upadmin-groups-view').html( data.html );
				jQuery('.upadmin-tpl-body ul').sortable({
					receive: function(e,ui) {
						copyHelper= null;
					}
				});
			}
		});
		return true;
	});
	
	/* Publish new field */
	jQuery(document).on('submit', '.upadmin-new form', function(e){
		e.preventDefault();
		form = jQuery(this);
		form.find('span.error-text').remove();
		form.find('input').removeClass('error');
		form.parents('.upadmin-fieldlist').find('.upadmin-loader').addClass('loading');
		jQuery.ajax({
			url: ajaxurl,
			data: form.serialize() + '&action=userpro_create_field',
			dataType: 'JSON',
			type: 'POST',
			success:function(data){
				form.parents('.upadmin-fieldlist').find('.upadmin-loader').removeClass('loading');
				if (data.error){
					jQuery.each( data.error, function(i, v) {
						jQuery('#'+i).addClass('error').focus().after('<span class="error-text">'+v+'</span>');
					});
				} else {
					form.find('input').removeClass('error');
					jQuery('ul#upadmin-sortable-fields').prepend( data.html );
					jQuery('span.upadmin-ajax-fieldcount').html( data.count );
				}
			}
		});
		return false;
	});
	
	/* reset single group */
	jQuery(document).on('click', '.upadmin-tpl a.resetgroup', function(e){
		e.preventDefault();
		if (!confirm('This will restore original fields for this GROUP. Are you sure?')) return false;
		var form = jQuery(this).parents('.upadmin-tpl').find('form');
		var role = form.data('role');
		form.find('.upadmin-tpl-head').append('<img src="'+form.data('loading')+'" alt="" class="upadmin-miniload" />');
		jQuery.ajax({
			url: ajaxurl,
			data: form.serialize() + '&action=userpro_reset_group&role='+role,
			dataType: 'JSON',
			type: 'POST',
			success:function(data){
				form.find('.upadmin-miniload').remove();
				form.parents('.upadmin-tpl').replaceWith( data.html );
				form.parents('.upadmin-tpl').find('.upadmin-tpl-body ul').sortable({
					receive: function(e,ui) {
						copyHelper= null;
					}
				});
			}
		});
		return false;
	});
	
	/* Save forms */
	jQuery(document).on('click', '.upadmin-tpl a.saveform', function(e){
		form = jQuery(this).parents('.upadmin-tpl').find('form');
		form.trigger('submit');
	});
	
	jQuery(document).on('submit', '.upadmin-tpl form', function(e){
		e.preventDefault();
		form = jQuery(this);
		var role = jQuery(this).data('role');
		var group = jQuery(this).data('group');

		form.find('.upadmin-tpl-head').append('<img src="'+form.data('loading')+'" alt="" class="upadmin-miniload" />');
		
		jQuery.ajax({
			url: ajaxurl,
			data: form.serialize() + '&action=userpro_save_group&role='+role+'&group='+group,
			dataType: 'JSON',
			type: 'POST',
			success:function(data){
				form.find('.upadmin-miniload').remove();
			}
		});
		return false;
	});

	/* The groups that will receive fields */
	jQuery('.upadmin-tpl-body ul').sortable({
        receive: function(e,ui) {
            copyHelper= null;
			var list = jQuery(this).parents('.upadmin-tpl-body');
			jQuery.each( list.find("li[data-special^='newsection'],input[data-special^='newsection'],select[data-special^='newsection']"), function(i, v){
				section_word = 'newsection' + i;
				jQuery(this).data('special', section_word);
				jQuery(this).find('input').each(function(){
					jQuery(this).attr('name', jQuery(this).attr('name').replace('newsection', section_word));
					jQuery(this).attr('id', jQuery(this).attr('id').replace('newsection', section_word));
				});
				jQuery(this).find('select').each(function(){
					jQuery(this).attr('name', jQuery(this).attr('name').replace('newsection', section_word));
					jQuery(this).attr('id', jQuery(this).attr('id').replace('newsection', section_word));
				});
			});
        }
	});
	
	/* Add new section field */
	jQuery('ul#upadmin-newsection').sortable({
		connectWith: ".upadmin-tpl-body ul",
		forcePlaceholderSize: false,
		helper: function(e,li) {
			copyHelper= li.clone().insertAfter(li);
			return li.clone();
		},
		stop: function() {
			copyHelper && copyHelper.remove();
		}
	});
	
	/* Moving out field/sorting between fields */
	var itemList = jQuery('ul#upadmin-sortable-fields');
	itemList.sortable({
		connectWith: ".upadmin-tpl-body ul",
		forcePlaceholderSize: false,
		helper: function(e,li) {
			copyHelper= li.clone().insertAfter(li);
			return li.clone();
		},
		stop: function() {
			copyHelper && copyHelper.remove();
		},
        update: function(event, ui) {
            opts = {
                url: ajaxurl,
                type: 'POST',
                async: true,
                cache: false,
                dataType: 'json',
                data:{
                    action: 'userpro_field_sort',
                    order: itemList.sortable('toArray').toString()
                },
                success: function(data) {
                    return; 
                },
                error: function(xhr,textStatus,e) {
                    return; 
                }
            };
            jQuery.ajax(opts);
        }
	});
	
	jQuery('#reset-options').click(function(e){
		var res = window.confirm( 'Are you sure you want to reset the settings to default ?' );
		
		if( !res )
			{
				return false;
			}
	})
	
});
