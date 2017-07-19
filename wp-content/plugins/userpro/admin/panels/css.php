<form method="post" action="">

<h3><i class="userpro-icon-css3"></i><?php _e('Custom CSS','userpro'); ?></h3>
<table class="form-table">

	<tr valign="top">
		<th scope="row"><label for="userpro_css"><?php _e('Custom CSS Styles','userpro'); ?></label></th>
		<td>
			<textarea name="userpro_css" id="userpro_css" class="large-text code userpro-largeblock" rows="3"><?php echo esc_attr(userpro_get_option('userpro_css')); ?></textarea>
			<span class="description"><?php _e('If you want to override existing styles, or add some specific CSS rules, put them here. They will survive the updates.','userpro'); ?></span>
		</td>
	</tr>
	
</table>

<p class="submit">
	<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Save Changes','userpro'); ?>"  />
	<input type="submit" name="reset-options" id="reset-options" class="button" value="<?php _e('Reset Options','userpro'); ?>"  />
</p>

</form>