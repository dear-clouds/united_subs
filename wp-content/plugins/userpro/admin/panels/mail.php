<form method="post" action="">

<p class="upadmin-highlight"><?php _e('The variables in {CURLY BRACKETS} are used to present data and info in email. You can use them to customize your email template.','userpro'); ?><?php userpro_admin_list_builtin_vars('{VAR1}'); ?></p>

<h3><?php _e('Outgoing Mail Settings','userpro'); ?></h3>
<table class="form-table">
	
	<tr valign="top">
		<th scope="row"><label for="mail_from_name"><?php _e('The name that appears on mails sent by UserPro','userpro'); ?></label></th>
		<td><input type="text" name="mail_from_name" id="mail_from_name" value="<?php echo userpro_get_option('mail_from_name'); ?>" class="regular-text" /></td>
	</tr>
	
	<tr valign="top">
		<th scope="row"><label for="mail_from"><?php _e('The address that appears on mails sent by UserPro','userpro'); ?></label></th>
		<td><input type="text" name="mail_from" id="mail_from" value="<?php echo userpro_get_option('mail_from'); ?>" class="regular-text" /></td>
	</tr>
	
</table>

<h3><?php _e('Email Notifications','userpro'); ?></h3>
<table class="form-table">
<tr valign="top">
		<th scope="row"><label for="new_user_notification"><?php _e('Send an Welcome e-mail to new user','userpro'); ?></label></th>
		<td>
			<select name="new_user_notification" id="new_user_notification" class="chosen-select" style="width:300px">
				<option value="1" <?php selected(1, userpro_get_option('new_user_notification')); ?>><?php _e('Yes','userpro'); ?></option>
				<option value="0" <?php selected(0, userpro_get_option('new_user_notification')); ?>><?php _e('No','userpro'); ?></option>
			</select>
		</td>
</tr>	

<tr valign="top">
		<th scope="row"><label for="notify_user_password_update"><?php _e('Send an e-mail for Update password','userpro'); ?></label></th>
		<td>
			<select name="notify_user_password_update" id="notify_user_password_update" class="chosen-select" style="width:300px">
				<option value="1" <?php selected(1, userpro_get_option('notify_user_password_update')); ?>><?php _e('Yes','userpro'); ?></option>
				<option value="0" <?php selected(0, userpro_get_option('notify_user_password_update')); ?>><?php _e('No','userpro'); ?></option>
			</select>
		</td>
	</tr>

<tr valign="top">
		<th scope="row"><label for="enable_reset_by_mail"><?php _e('Reset password by email link','userpro'); ?></label></th>
		<td>
			<select name="enable_reset_by_mail" id="enable_reset_by_mail" class="chosen-select" style="width:300px">
				<option value="y" <?php selected('y', userpro_get_option('enable_reset_by_mail')); ?>><?php _e('Yes','userpro'); ?></option>
				<option value="n" <?php selected('n', userpro_get_option('enable_reset_by_mail')); ?>><?php _e('No','userpro'); ?></option>
			</select>
		</td>
</tr>

	<tr valign="top">
		<th scope="row"><label for="notify_user_verified"><?php _e('Send an e-mail when user is verified','userpro'); ?></label></th>
		<td>
			<select name="notify_user_verified" id="notify_user_verified" class="chosen-select" style="width:300px">
				<option value="1" <?php selected(1, userpro_get_option('notify_user_verified')); ?>><?php _e('Yes','userpro'); ?></option>
				<option value="0" <?php selected(0, userpro_get_option('notify_user_verified')); ?>><?php _e('No','userpro'); ?></option>
			</select>
		</td>
	</tr>
	
	<tr valign="top">
		<th scope="row"><label for="notify_user_unverified"><?php _e('Send an e-mail when user is unverified','userpro'); ?></label></th>
		<td>
			<select name="notify_user_unverified" id="notify_user_unverified" class="chosen-select" style="width:300px">
				<option value="1" <?php selected(1, userpro_get_option('notify_user_unverified')); ?>><?php _e('Yes','userpro'); ?></option>
				<option value="0" <?php selected(0, userpro_get_option('notify_user_unverified')); ?>><?php _e('No','userpro'); ?></option>
			</select>
		</td>
	</tr>
	
	<tr valign="top">
		<th scope="row"><label for="notify_account_blocked"><?php _e('Send an e-mail when account is blocked','userpro'); ?></label></th>
		<td>
			<select name="notify_account_blocked" id="notify_account_blocked" class="chosen-select" style="width:300px">
				<option value="1" <?php selected(1, userpro_get_option('notify_account_blocked')); ?>><?php _e('Yes','userpro'); ?></option>
				<option value="0" <?php selected(0, userpro_get_option('notify_account_blocked')); ?>><?php _e('No','userpro'); ?></option>
			</select>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="notify_account_pendingfor_adminapproval"><?php _e('Send an e-mail to user when account is pending for admin approval','userpro'); ?></label></th>
		<td>
			<select name="notify_account_pendingfor_adminapproval" id="notify_account_pendingfor_adminapproval" class="chosen-select" style="width:300px">
				<option value="1" <?php selected(1, userpro_get_option('notify_account_pendingfor_adminapproval')); ?>><?php _e('Yes','userpro'); ?></option>
				<option value="0" <?php selected(0, userpro_get_option('notify_account_pendingfor_adminapproval')); ?>><?php _e('No','userpro'); ?></option>
			</select>
		</td>
	</tr>	

	<tr valign="top">
		<th scope="row"><label for="notify_account_unblocked"><?php _e('Send an e-mail when account is unblocked','userpro'); ?></label></th>
		<td>
			<select name="notify_account_unblocked" id="notify_account_unblocked" class="chosen-select" style="width:300px">
				<option value="1" <?php selected(1, userpro_get_option('notify_account_unblocked')); ?>><?php _e('Yes','userpro'); ?></option>
				<option value="0" <?php selected(0, userpro_get_option('notify_account_unblocked')); ?>><?php _e('No','userpro'); ?></option>
			</select>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="notify_admin_profile_save"><?php _e('Send admin an e-mail when user updates profile','userpro'); ?></label></th>
		<td>
			<select name="notify_admin_profile_save" id="notify_admin_profile_save" class="chosen-select" style="width:300px">
				<option value="1" <?php selected(1, userpro_get_option('notify_admin_profile_save')); ?>><?php _e('Yes','userpro'); ?></option>
				<option value="0" <?php selected(0, userpro_get_option('notify_admin_profile_save')); ?>><?php _e('No','userpro'); ?></option>
			</select>
		</td>
	</tr>

	<tr valign="top">
		<th scope="row"><label for="notify_admin_profile_remove"><?php _e('Send admin an e-mail when profile gets removed','userpro'); ?></label></th>
		<td>
			<select name="notify_admin_profile_remove" id="notify_admin_profile_remove" class="chosen-select" style="width:300px">
				<option value="1" <?php selected(1, userpro_get_option('notify_admin_profile_remove')); ?>><?php _e('Yes','userpro'); ?></option>
				<option value="0" <?php selected(0, userpro_get_option('notify_admin_profile_remove')); ?>><?php _e('No','userpro'); ?></option>
			</select>
		</td>
	</tr>
	
</table>

<h3><?php _e('User Awaiting Manual Review Template (Admin Notification)','userpro'); ?></h3>
<table class="form-table">

	<tr valign="top">
		<th scope="row"><label for="mail_admin_pendingapprove_s"><?php _e('Subject','userpro'); ?></label></th>
		<td><input type="text" name="mail_admin_pendingapprove_s" id="mail_admin_pendingapprove_s" value="<?php echo userpro_get_option('mail_admin_pendingapprove_s'); ?>" class="regular-text" /></td>
	</tr>
	
	<tr valign="top">
		<th scope="row"><label for="mail_admin_pendingapprove"><?php _e('Email Content','userpro'); ?></label></th>
		<td><textarea name="mail_admin_pendingapprove" id="mail_admin_pendingapprove" class="large-text code" rows="10"><?php echo userpro_get_option('mail_admin_pendingapprove'); ?></textarea></td>
	</tr>
	
</table>

<h3><?php _e('New Registration Template (Admin Notification)','userpro'); ?></h3>
<table class="form-table">
	
	<tr valign="top">
		<th scope="row"><label for="mail_admin_newaccount_s"><?php _e('Subject','userpro'); ?></label></th>
		<td><input type="text" name="mail_admin_newaccount_s" id="mail_admin_newaccount_s" value="<?php echo userpro_get_option('mail_admin_newaccount_s'); ?>" class="regular-text" /></td>
	</tr>
	
	<tr valign="top">
		<th scope="row"><label for="mail_admin_newaccount"><?php _e('Email Content','userpro'); ?></label></th>
		<td><textarea name="mail_admin_newaccount" id="mail_admin_newaccount" class="large-text code" rows="10"><?php echo userpro_get_option('mail_admin_newaccount'); ?></textarea></td>
	</tr>
	
</table>

<h3><?php _e('Profile Updated (Admin Notification)','userpro'); ?></h3>
<table class="form-table">

	<tr valign="top">
		<th scope="row"><label for="mail_admin_profileupdate_s"><?php _e('Subject','userpro'); ?></label></th>
		<td><input type="text" name="mail_admin_profileupdate_s" id="mail_admin_profileupdate_s" value="<?php echo userpro_get_option('mail_admin_profileupdate_s'); ?>" class="regular-text" /></td>
	</tr>
	
	<tr valign="top">
		<th scope="row"><label for="mail_admin_profileupdate"><?php _e('Email Content','userpro'); ?></label></th>
		<td><textarea name="mail_admin_profileupdate" id="mail_admin_profileupdate" class="large-text code" rows="10"><?php echo userpro_get_option('mail_admin_profileupdate'); ?></textarea></td>
	</tr>
	
</table>

<h3><?php _e('Profile Deleted (Admin Notification)','userpro'); ?></h3>
<table class="form-table">

	<tr valign="top">
		<th scope="row"><label for="mail_admin_accountdeleted_s"><?php _e('Subject','userpro'); ?></label></th>
		<td><input type="text" name="mail_admin_accountdeleted_s" id="mail_admin_accountdeleted_s" value="<?php echo userpro_get_option('mail_admin_accountdeleted_s'); ?>" class="regular-text" /></td>
	</tr>
	
	<tr valign="top">
		<th scope="row"><label for="mail_admin_accountdeleted"><?php _e('Email Content','userpro'); ?></label></th>
		<td><textarea name="mail_admin_accountdeleted" id="mail_admin_accountdeleted" class="large-text code" rows="10"><?php echo userpro_get_option('mail_admin_accountdeleted'); ?></textarea></td>
	</tr>
	
</table>

<h3><?php _e('Customize "Email Validation" Mail','userpro'); ?></h3>
<table class="form-table">
	
	<tr valign="top">
		<th scope="row"><label for="mail_verifyemail_s"><?php _e('Subject','userpro'); ?></label></th>
		<td><input type="text" name="mail_verifyemail_s" id="mail_verifyemail_s" value="<?php echo userpro_get_option('mail_verifyemail_s'); ?>" class="regular-text" /></td>
	</tr>
	
	<tr valign="top">
		<th scope="row"><label for="mail_verifyemail"><?php _e('Email Content','userpro'); ?></label></th>
		<td><textarea name="mail_verifyemail" id="mail_verifyemail" class="large-text code" rows="10"><?php echo userpro_get_option('mail_verifyemail'); ?></textarea></td>
	</tr>
	
</table>

<h3><?php _e('Customize "New Account/Welcome" Mail','userpro'); ?></h3>
<table class="form-table">
	
	<tr valign="top">
		<th scope="row"><label for="mail_newaccount_s"><?php _e('Subject','userpro'); ?></label></th>
		<td><input type="text" name="mail_newaccount_s" id="mail_newaccount_s" value="<?php echo userpro_get_option('mail_newaccount_s'); ?>" class="regular-text" /></td>
	</tr>
	
	<tr valign="top">
		<th scope="row"><label for="mail_newaccount"><?php _e('Email Content','userpro'); ?></label></th>
		<td><textarea name="mail_newaccount" id="mail_newaccount" class="large-text code" rows="10"><?php echo userpro_get_option('mail_newaccount'); ?></textarea></td>
	</tr>
	
</table>

<h3><?php _e('Customize "Reset Password" Mail','userpro'); ?></h3>
<table class="form-table">
	
	<tr valign="top">
		<th scope="row"><label for="mail_secretkey_s"><?php _e('Subject','userpro'); ?></label></th>
		<td><input type="text" name="mail_secretkey_s" id="mail_secretkey_s" value="<?php echo userpro_get_option('mail_secretkey_s'); ?>" class="regular-text" /></td>
	</tr>
	
	<tr valign="top">
		<th scope="row"><label for="mail_secretkey"><?php _e('Email Content','userpro'); ?></label></th>
		<td><textarea name="mail_secretkey" id="mail_secretkey" class="large-text code" rows="10"><?php echo userpro_get_option('mail_secretkey'); ?></textarea></td>
	</tr>
	
</table>

<h3><?php _e('Customize "Reset Password by email link" Mail','userpro'); ?></h3>
<table class="form-table">
	
	<tr valign="top">
		<th scope="row"><label for="reset_password_mail_s"><?php _e('Subject','userpro'); ?></label></th>
		<td><input type="text" name="reset_password_mail_s" id="reset_password_mail_s" value="<?php echo userpro_get_option('reset_password_mail_s'); ?>" class="regular-text" /></td>
	</tr>
	
	<tr valign="top">
		<th scope="row"><label for="reset_password_mail_c"><?php _e('Email Content','userpro'); ?></label></th>
		<td><textarea name="reset_password_mail_c" id="reset_password_mail_c" class="large-text code" rows="10"><?php echo userpro_get_option('reset_password_mail_c'); ?></textarea></td>
	</tr>
	
</table>

<h3><?php _e('Customize "Password Change" Mail','userpro'); ?></h3>
<table class="form-table">
	
	<tr valign="top">
		<th scope="row"><label for="mail_password_change_s"><?php _e('Subject','userpro'); ?></label></th>
		<td><input type="text" name="mail_password_change_s" id="mail_password_change_s" value="<?php echo userpro_get_option('mail_password_change_s'); ?>" class="regular-text" /></td>
	</tr>
	
	<tr valign="top">
		<th scope="row"><label for="mail_password_change"><?php _e('Email Content','userpro'); ?></label></th>
		<td><textarea name="mail_password_change" id="mail_password_change" class="large-text code" rows="10"><?php echo userpro_get_option('mail_password_change'); ?></textarea></td>
	</tr>
	
</table>

<h3><?php _e('Customize "Account Removal" Mail','userpro'); ?></h3>
<table class="form-table">
	
	<tr valign="top">
		<th scope="row"><label for="mail_accountdeleted_s"><?php _e('Subject','userpro'); ?></label></th>
		<td><input type="text" name="mail_accountdeleted_s" id="mail_accountdeleted_s" value="<?php echo userpro_get_option('mail_accountdeleted_s'); ?>" class="regular-text" /></td>
	</tr>
	
	<tr valign="top">
		<th scope="row"><label for="mail_accountdeleted"><?php _e('Email Content','userpro'); ?></label></th>
		<td><textarea name="mail_accountdeleted" id="mail_accountdeleted" class="large-text code" rows="10"><?php echo userpro_get_option('mail_accountdeleted'); ?></textarea></td>
	</tr>
	
</table>

<h3><?php _e('Customize "Account Verified" Mail','userpro'); ?></h3>
<table class="form-table">

	<tr valign="top">
		<th scope="row"><label for="mail_accountverified_s"><?php _e('Subject','userpro'); ?></label></th>
		<td><input type="text" name="mail_accountverified_s" id="mail_accountverified_s" value="<?php echo userpro_get_option('mail_accountverified_s'); ?>" class="regular-text" /></td>
	</tr>
	
	<tr valign="top">
		<th scope="row"><label for="mail_accountverified"><?php _e('Email Content','userpro'); ?></label></th>
		<td><textarea name="mail_accountverified" id="mail_accountverified" class="large-text code" rows="10"><?php echo userpro_get_option('mail_accountverified'); ?></textarea></td>
	</tr>
	
</table>

<h3><?php _e('Customize "Account Un-verified" Mail','userpro'); ?></h3>
<table class="form-table">
	
	<tr valign="top">
		<th scope="row"><label for="mail_accountunverified_s"><?php _e('Subject','userpro'); ?></label></th>
		<td><input type="text" name="mail_accountunverified_s" id="mail_accountunverified_s" value="<?php echo userpro_get_option('mail_accountunverified_s'); ?>" class="regular-text" /></td>
	</tr>
	
	<tr valign="top">
		<th scope="row"><label for="mail_accountunverified"><?php _e('Email Content','userpro'); ?></label></th>
		<td><textarea name="mail_accountunverified" id="mail_accountunverified" class="large-text code" rows="10"><?php echo userpro_get_option('mail_accountunverified'); ?></textarea></td>
	</tr>
	
</table>
<h3><?php _e('User Awaiting Manual Review Template (User Notification)','userpro'); ?></h3>
<table class="form-table">

	<tr valign="top">
		<th scope="row"><label for="pending_for_admin_approval"><?php _e('Subject','userpro'); ?></label></th>
		<td><input type="text" name="pending_for_admin_approval" id="pending_for_admin_approval" value="<?php echo userpro_get_option('pending_for_admin_approval'); ?>" class="regular-text" /></td>
	</tr>
	
	<tr valign="top">
		<th scope="row"><label for="pending_for_admin_approval_txt"><?php _e('Email Content','userpro'); ?></label></th>
		<td><textarea name="pending_for_admin_approval_txt" id="pending_for_admin_approval_txt" class="large-text code" rows="10"><?php echo userpro_get_option('pending_for_admin_approval_txt'); ?></textarea></td>
	</tr>
	
</table>



<h3><?php _e('Customize "Account Blocked" Mail','userpro'); ?></h3>
<table class="form-table">

	<tr valign="top">
		<th scope="row"><label for="mail_accountblocked_s"><?php _e('Subject','userpro'); ?></label></th>
		<td><input type="text" name="mail_accountblocked_s" id="mail_accountblocked_s" value="<?php echo userpro_get_option('mail_accountblocked_s'); ?>" class="regular-text" /></td>
	</tr>
	
	<tr valign="top">
		<th scope="row"><label for="mail_accountblocked"><?php _e('Email Content','userpro'); ?></label></th>
		<td><textarea name="mail_accountblocked" id="mail_accountblocked" class="large-text code" rows="10"><?php echo userpro_get_option('mail_accountblocked'); ?></textarea></td>
	</tr>
	
</table>

<h3><?php _e('Customize "Account Unblocked" Mail','userpro'); ?></h3>
<table class="form-table">
	
	<tr valign="top">
		<th scope="row"><label for="mail_accountunblocked_s"><?php _e('Subject','userpro'); ?></label></th>
		<td><input type="text" name="mail_accountunblocked_s" id="mail_accountunblocked_s" value="<?php echo userpro_get_option('mail_accountunblocked_s'); ?>" class="regular-text" /></td>
	</tr>
	
	<tr valign="top">
		<th scope="row"><label for="mail_accountunblocked"><?php _e('Email Content','userpro'); ?></label></th>
		<td><textarea name="mail_accountunblocked" id="mail_accountunblocked" class="large-text code" rows="10"><?php echo userpro_get_option('mail_accountunblocked'); ?></textarea></td>
	</tr>
	
</table>

<h3><?php _e('Customize "Invitation to Get Verified" Mail','userpro'); ?></h3>
<table class="form-table">
	
	<tr valign="top">
		<th scope="row"><label for="mail_verifyinvite_s"><?php _e('Subject','userpro'); ?></label></th>
		<td><input type="text" name="mail_verifyinvite_s" id="mail_verifyinvite_s" value="<?php echo userpro_get_option('mail_verifyinvite_s'); ?>" class="regular-text" /></td>
	</tr>
	
	<tr valign="top">
		<th scope="row"><label for="mail_verifyinvite"><?php _e('Email Content','userpro'); ?></label></th>
		<td><textarea name="mail_verifyinvite" id="mail_verifyinvite" class="large-text code" rows="10"><?php echo userpro_get_option('mail_verifyinvite'); ?></textarea></td>
	</tr>
	
</table>
<h3><?php _e('Admin "Notification email for verification request"','userpro'); ?></h3>
<table class="form-table">
	
	<tr valign="top">
		<th scope="row"><label for="mail_admin_verify_request"><?php _e('Subject','userpro'); ?></label></th>
		<td><input type="text" name="mail_admin_verify_request" id="mail_admin_verify_request" value="<?php echo userpro_get_option('mail_admin_verify_request'); ?>" class="regular-text" /></td>
	</tr>
	
	<tr valign="top">
		<th scope="row"><label for="mail_admin_verify_requests"><?php _e('Email Content','userpro'); ?></label></th>
		<td><textarea name="mail_admin_verify_requests" id="mail_admin_verify_requests" class="large-text code" rows="10"><?php echo userpro_get_option('mail_admin_verify_requests'); ?></textarea></td>
	</tr>
	
</table>
<p class="submit">
	<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Save Changes','userpro'); ?>"  />
	<input type="submit" name="reset-options" id="reset-options" class="button" value="<?php _e('Reset Options','userpro'); ?>"  />
</p>

</form>
