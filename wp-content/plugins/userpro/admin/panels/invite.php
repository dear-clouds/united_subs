<script>

jQuery(function(){
	jQuery('#invite').click(function(e){
		e.preventDefault();
		var emails = jQuery('#userpro_invite_emails').val();
		var data = {
				'action': 'userpro_user_invite',
				'emails': emails , 
			};

			jQuery.post(ajaxurl, data, function(response) {
				jQuery('#userpro_invite_emails').val('');
				jQuery('#invite_success_msg').html("Invitation mail sent Successfully!");
			});
	});
});
</script>
<form method="post" action="">

<h3><?php _e('Invite Users Setting','userpro'); ?></h3>
<table class="form-table">

	<tr valign="top">
		<th scope="row"><label for="userpro_invite_emails_enable"><?php _e('Allow only invited users to register','userpro'); ?></label></th>
		<td>
			<select name="userpro_invite_emails_enable" id="userpro_invite_emails_enable" class="chosen-select" style="width:300px">
				<option value="1" <?php selected(1, userpro_get_option('userpro_invite_emails_enable')); ?>><?php _e('Yes','userpro'); ?></option>
				<option value="0" <?php selected(0, userpro_get_option('userpro_invite_emails_enable')); ?>><?php _e('No','userpro'); ?></option>
			</select>
		</td>
	</tr>
<tr valign="top">
		<th scope="row"><label for="invite_subject"><?php _e('Subject','userpro'); ?></label></th>
		<td><input type="text" name="invite_subject" id="invite_subject" value="<?php echo userpro_get_option('invite_subject'); ?>" class="regular-text" /></td>
	</tr>
	<tr>
		<th><label for="userpro_invite_emails_template"><?php _e('Email Template to send invitation email' , 'userpro')?></label></th>
		<td>
			
			<textarea name="userpro_invite_emails_template" id="userpro_invite_emails_template" class="large-text userpro-largeblock" ><?php echo userpro_get_option('userpro_invite_emails_template'); ?></textarea>
			<span class="description"><?php _e('Use {invitelink} at the place of your invitation link in your email template','userpro'); ?></span>
		</td>
	</tr>
</table>

<p class="submit">
	<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Save Settings','userpro'); ?>"  />
</p>

<h3><?php _e('Invite Users','userpro'); ?></h3>
<table class="form-table">
<tr valign="top">
		<th scope="row"></th>
		<td>

			<span class="description" id="invite_success_msg"></span>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="userpro_invite_emails"><?php _e('Enter Email addresses to Invite','userpro'); ?></label></th>
		<td>
			<input type="text" name="userpro_invite_emails" id="userpro_invite_emails" value="" class="regular-text" />
			<span class="description"><?php _e('Enter Email addresses separated by comma','userpro'); ?></span>
		</td>
	</tr>

	<tr>
		<th>
				<input type="submit" name="invite" id="invite" class="button button-primary" value="<?php _e('Invite','userpro'); ?>"  />
		</th>
	</tr>
</table>
</form>
