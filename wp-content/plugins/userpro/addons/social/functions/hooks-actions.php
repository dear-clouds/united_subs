<?php

	/* Enqueue Scripts */
	add_action('wp_enqueue_scripts', 'userpro_sc_enqueue_scripts', 99);
	function userpro_sc_enqueue_scripts(){
	
		if (!userpro_get_option('modstate_social') ) return false;
	
		wp_register_script('userpro_sc', userpro_sc_url . 'scripts/userpro-social.min.js');
		wp_enqueue_script('userpro_sc');
		
	}
	
	/* Hook after name in user list compact */
	add_action('userpro_after_name_user_list', 'userpro_sc_show_follow', 99);
	function userpro_sc_show_follow($user_id){
		global $userpro, $userpro_social;
		
		if (!userpro_get_option('modstate_social') ) return false;

		if ( userpro_is_logged_in() && !$userpro->is_user_logged_user($user_id) ) {
			echo '<div class="userpro-sc-flw">'.$userpro_social->follow_text($user_id, get_current_user_id()).'</div>';
		}
	
	}
	
	/* Hook after profile head */
	add_action('userpro_after_profile_head','userpro_sc_bar', 99);
	function userpro_sc_bar( $args ){
		global $userpro, $userpro_social;
		
		$user_id = $args['user_id'];
		
		if (!userpro_get_option('modstate_social') ) return false;
		
		// where to add the hook
		if ( in_array($args['template'], array('view','following','followers') )  && !isset($args['no_style']) ){

		?>
		
		<div class="userpro-sc-bar">
		
			<div class="userpro-sc-left">
				<a href="<?php echo $userpro->permalink($user_id, 'following', 'userpro_sc_pages'); ?>" class="userpro-count-link"><?php echo $userpro_social->following_count( $user_id ); ?></a>
				<a href="<?php echo $userpro->permalink($user_id, 'followers', 'userpro_sc_pages'); ?>" class="userpro-count-link"><?php echo $userpro_social->followers_count( $user_id ); ?></a>
			</div>
			
			<div class="userpro-sc-right">
				<?php echo $userpro_social->follow_text($user_id, get_current_user_id()); ?>
				<?php do_action('userpro_social_buttons', $user_id); ?>
			</div>
			
			<div class="userpro-clear"></div>
		
		</div>
		
		<?php
		}
		
	}
