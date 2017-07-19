<?php

	/* Setup global redirection */
	add_action('userpro_super_get_redirect', 'userpro_super_get_redirect');
	function userpro_super_get_redirect($i){
		
		if (isset($_GET['redirect_to'])){
		?>
			<input type="hidden" name="global_redirect-<?php echo $i; ?>" id="global_redirect-<?php echo $i; ?>" value="<?php echo esc_url($_GET['redirect_to']); ?>" />
		<?php
		}
		
	}
