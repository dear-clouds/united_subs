<form method="get" id="searchform" action="<?php echo home_url(); ?>/">
	<input type="text" name="s" id="searchbar" value="<?php _e('search...', 'gp_lang'); ?>" onblur="if (this.value == '') {this.value = '<?php _e('search...', 'gp_lang'); ?>';}" onfocus="if (this.value == '<?php _e('search...', 'gp_lang'); ?>') {this.value = '';}"  />
	<input type="submit" id="searchsubmit" value="<?php _e('Search', 'gp_lang'); ?>" />
</form>