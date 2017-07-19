<form method="post" action="">

<h3><?php _e('E-mail Notifications','userpro'); ?></h3>
<table class="form-table">

	<tr valign="top">
		<th scope="row"><label for="notification_on_follow"><?php _e('Send e-mail notification when someone follow another user','userpro'); ?></label></th>
		<td>
			<select name="notification_on_follow" id="notification_on_follow" class="chosen-select" style="width:300px">
				<option value="1" <?php selected(1, userpro_sc_get_option('notification_on_follow')); ?>><?php _e('Yes','userpro'); ?></option>
				<option value="0" <?php selected(0, userpro_sc_get_option('notification_on_follow')); ?>><?php _e('No','userpro'); ?></option>
			</select>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="notification_on_follow"><?php _e('Send e-mail notification to followers when user creates post','userpro'); ?></label></th>
		<td>
			<select name="notification_on_follow_post" id="notification_on_follow_post" class="chosen-select" style="width:300px">
				<option value="1" <?php selected(1, userpro_sc_get_option('notification_on_follow_post')); ?>><?php _e('Yes','userpro'); ?></option>
				<option value="0" <?php selected(0, userpro_sc_get_option('notification_on_follow_post')); ?>><?php _e('No','userpro'); ?></option>
			</select>
		</td>
	</tr>
	
</table>

<h3><?php _e('New Follow E-mail Template','userpro'); ?></h3>
<table class="form-table">

	<tr valign="top">
		<th scope="row"><label for="mail_new_follow_s"><?php _e('Subject','userpro'); ?></label></th>
		<td><input type="text" name="mail_new_follow_s" id="mail_new_follow_s" value="<?php echo userpro_sc_get_option('mail_new_follow_s'); ?>" class="regular-text" /></td>
	</tr>
	
	<tr valign="top">
		<th scope="row"><label for="mail_new_follow"><?php _e('Email Content','userpro'); ?></label></th>
		<td><textarea name="mail_new_follow" id="mail_new_follow" class="large-text code" rows="10"><?php echo userpro_sc_get_option('mail_new_follow'); ?></textarea></td>
	</tr>
	
</table>

<h3><?php _e('Activity Stream','userpro'); ?></h3>
<table class="form-table">

	<tr valign="top">
		<th scope="row"><label for="activity_open_to_all"><?php _e('Make public activity visible to guests','userpro'); ?></label></th>
		<td>
			<select name="activity_open_to_all" id="activity_open_to_all" class="chosen-select" style="width:300px">
				<option value="1" <?php selected(1, userpro_sc_get_option('activity_open_to_all')); ?>><?php _e('Yes','userpro'); ?></option>
				<option value="0" <?php selected(0, userpro_sc_get_option('activity_open_to_all')); ?>><?php _e('No','userpro'); ?></option>
			</select>
		</td>
	</tr>
	
	<tr valign="top">
		<th scope="row"><label for="hide_admins"><?php _e('Exclude admin activity from wall','userpro'); ?></label></th>
		<td>
			<select name="hide_admins" id="hide_admins" class="chosen-select" style="width:300px">
				<option value="1" <?php selected(1, userpro_sc_get_option('hide_admins')); ?>><?php _e('Yes','userpro'); ?></option>
				<option value="0" <?php selected(0, userpro_sc_get_option('hide_admins')); ?>><?php _e('No','userpro'); ?></option>
			</select>
		</td>
	</tr>
	
	<tr valign="top">
		<th scope="row"><label for="activity_per_page"><?php _e('No. of activities per page','userpro'); ?></label></th>
		<td>
			<input type="text" name="activity_per_page" id="activity_per_page" value="<?php echo userpro_sc_get_option('activity_per_page'); ?>" class="regular-text" />
			<span class="description"><?php _e('The number of items in activity stream to load per page.','userpro'); ?></span>
		</td>
	</tr>
	
	<tr valign="top">
		<th scope="row"><label for="excluded_post_types"><?php _e('Exclude these post types from activity','userpro'); ?></label></th>
		<td>
			<input type="text" name="excluded_post_types" id="excluded_post_types" value="<?php echo userpro_sc_get_option('excluded_post_types'); ?>" class="regular-text" />
			<span class="description"><?php _e('A comma seperated list of post types to hide from activity.','userpro'); ?></span>
		</td>
	</tr>
	
</table>

<p class="submit">
	<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Save Changes','userpro'); ?>"  />
	<input type="submit" name="reset-options" id="reset-options" class="button" value="<?php _e('Reset Options','userpro'); ?>"  />
</p>

</form>