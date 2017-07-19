<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
?>
	
	
<div class="list-members">
	<?php 
	if (!empty($atts['role'])){
		if ($atts['role'] == "all") {
			$all_members = get_users(array('fields' => array( 'ID', 'display_name' )));
		}
		else{
			$all_members = get_users(array('role' => $atts['role'], 'fields' => array( 'ID', 'display_name' )));			
		}
		if (!empty($all_members)){
			foreach($all_members as $member) {
				if (function_exists('bp_is_active')):
					$user_info = get_userdata($member->ID);
					if (!empty($user_info->display_name)){
						$name = $user_info->display_name;
						echo'<a href="'. esc_url(bp_core_get_user_domain($member->ID)) .'" title="'. $name .'" data-toggle="tooltip" data-placement="top">';
							echo get_avatar($member->ID);
						echo'</a>';
					}
					else {
						echo'<a href="'. esc_url(bp_core_get_user_domain($member->ID)) .'">';
							echo get_avatar($member->ID);
						echo'</a>';	
					}
				else : 
					echo get_avatar($member->ID);
				endif;
			} 
		}
	}
	?>
</div>