<div class="userpro userpro-<?php echo $i; ?> userpro-<?php echo $layout; ?>" <?php userpro_args_to_data( $args ); ?>>

	<div class="userpro-head">
		<div class="userpro-left"><i class="userpro-icon-lock"></i><?php echo __('Restricted Content / Members Only','userpro'); ?></div>
		<div class="userpro-clear"></div>
	</div>
	
	<div class="userpro-body">
	
		<?php do_action('userpro_pre_form_message'); ?>
		<?php if($args['login_redirect']=="")
			{?>
		<p><?php printf(__('You cannot view this content because It is available to members only. Please <a href="#" class="popup-login" data-force_redirect_uri="1">login</a> or <a href="%s">register</a> to view this area.','userpro'), $userpro->permalink(0, 'register') ); ?></p>
			<?php }
			else
			{?>
				<p><?php printf(__('You cannot view this content because It is available to members only. Please <a href="#" class="popup-login" data-login_redirect="'.$args['login_redirect'].'">login</a> or <a href="%s">register</a> to view this area.','userpro'), $userpro->permalink(0, 'register') ); ?></p>
			<?php }?>
		

	</div>

</div>