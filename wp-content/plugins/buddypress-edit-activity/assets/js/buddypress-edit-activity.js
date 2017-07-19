function buddypress_edit_activity_initiate(link) {
	if (jQuery(link).hasClass('action-save')) {
		buddypress_edit_activity_save(link);
	} else {
		buddypress_edit_activity_get(link);
	}
	return false;
}

function buddypress_edit_activity_get(link) {
	$link = jQuery(link);
	$form = jQuery('#frm_buddypress-edit-activity');
	$form_wrapper = $form.parent();

	$link.addClass('loading');

	if ($link.hasClass('buddyboss_edit_activity_comment')) {
		B_E_A_.current_activity_org = $link.closest('[id^=acomment]').find(' > .acomment-content').html();
	} else {
		B_E_A_.current_activity_org = $link.closest('.activity-content').find('.activity-inner').html();
	}

	var data = {
		'action': $form.find('input[name="action_get"]').val(),
		'buddypress_edit_activity_nonce': $form.find('input[name="buddypress_edit_activity_nonce"]').val(),
		'activity_id': $link.data('activity_id'),
	};

	jQuery.ajax({
		type: "POST",
		url: ajaxurl,
		data: data,
		success: function(response) {
			response = jQuery.parseJSON(response);
			if (response.status) {
				$link.removeClass('loading').addClass('action-save').html(B_E_A_.button_text.save);

				//add cancel button before link
				var $cancel_button = jQuery("<a href='#'>").addClass('bp-secondary-action buddyboss_edit_activity_cancel').html(B_E_A_.button_text.cancel);
				$link.before($cancel_button);
				$cancel_button.attr('onclick', 'return buddypress_edit_activity_cancel(this);');
				$cancel_button.data('target_type', 'activity');

				if ($link.hasClass('buddyboss_edit_activity_comment')) {
					//editing comment
					$link.closest('[id^=acomment]').find(' > .acomment-content').html('').hide().after($form_wrapper);
					$cancel_button.data('target_type', 'comment');
				} else {
					//editing activity
					$link.closest('.activity-content').find('.activity-inner').html('').hide().after($form_wrapper);
					$cancel_button.addClass('button');
				}

				$form_wrapper.show();

				$form.find('input[name="activity_id"]').val(data.activity_id);
				$form.find('textarea').val(response.content);
			}
		},
	});
}

function buddypress_edit_activity_save(link) {
	$link = jQuery(link);
	$form = jQuery('#frm_buddypress-edit-activity');
	$form_wrapper = $form.parent();

	$link.addClass('loading');

	jQuery('.buddyboss_edit_activity_cancel').remove();

	var data = {
		'action': $form.find('input[name="action_save"]').val(),
		'buddypress_edit_activity_nonce': $form.find('input[name="buddypress_edit_activity_nonce"]').val(),
		'activity_id': $link.data('activity_id'),
		'content': $form.find('textarea').val()
	};

	jQuery.ajax({
		type: "POST",
		url: ajaxurl,
		data: data,
		success: function(response) {
			response = jQuery.parseJSON(response);
			if (response.status) {
				$link.removeClass('loading').removeClass('action-save').html(B_E_A_.button_text.edit);

				if ($link.hasClass('buddyboss_edit_activity_comment')) {
					//editing comment
					$link.closest('[id^=acomment]').find(' > .acomment-content').html(response.content).show();
				} else {
					//editing activity
					$link.closest('.activity-content').find('.activity-inner').html(response.content).show();
				}

				$form_wrapper.hide();
				jQuery('body').append($form_wrapper);
			}
		},
	});
}

function buddypress_edit_activity_cancel(cancel_button) {
	var $cancel_button = jQuery(cancel_button);
	var $form = jQuery('#frm_buddypress-edit-activity');
	var $form_wrapper = $form.parent();
	var $save_button = '';

	if ($cancel_button.data('target_type') == 'comment') {
		//editing comment
		$cancel_button.closest('[id^=acomment]').find(' > .acomment-content').html(B_E_A_.current_activity_org).show();
		$save_button = $cancel_button.closest('[id^=acomment]').find('.buddyboss_edit_activity_comment.action-save');
	} else {
		//editing activity
		$cancel_button.closest('.activity-content').find('.activity-inner').html(B_E_A_.current_activity_org).show();
		$save_button = $cancel_button.closest('.activity-content').find('.buddyboss_edit_activity.action-save');
	}

	$save_button.removeClass('action-save').html(B_E_A_.button_text.edit);

	$form_wrapper.hide();
	jQuery('body').append($form_wrapper);
	$cancel_button.remove();

	return false;
}