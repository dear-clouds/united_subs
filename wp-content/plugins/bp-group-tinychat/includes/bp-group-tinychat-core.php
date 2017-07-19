<?php

define ( 'BP_GROUP_tinychat_IS_INSTALLED', 1 );
define ( 'BP_GROUP_tinychat_VERSION', '1.0' );
define ( 'BP_GROUP_tinychat_DB_VERSION', '1.3' );
if ( !defined( 'BP_GROUP_tinychat_SLUG' ) )
	define ( 'BP_GROUP_tinychat_SLUG', 'tiny-chat' );

/**
 * bp_group_tinychat_setup_globals()
 *
 * Sets up global variables for your component.
 */
function bp_group_tinychat_setup_globals() {
	global $bp, $wpdb;

	/* For internal identification */
	$bp->tinychat->id = 'tinychat';

	$bp->tinychat->table_name = $wpdb->base_prefix . 'bp_group_tinychat';
	$bp->tinychat->format_notification_function = 'bp_group_tinychat_format_notifications';
	$bp->tinychat->slug = BP_GROUP_tinychat_SLUG;

	/* Register this in the active components array */
	$bp->active_components[$bp->tinychat->slug] = $bp->tinychat->id;
}
add_action( 'bp_setup_globals', 'bp_group_tinychat_setup_globals' );


class BP_Group_tinychat extends BP_Group_Extension {	

	function bp_group_tinychat() {
		global $bp;
		
		$this->name = 'Group Chat';
		$this->slug = 'group-chat';

		$this->create_step_position = 16;
		$this->nav_item_position = 31;
		
		if ( groups_get_groupmeta( $bp->groups->current_group->id, 'bp_group_tinychat_enabled' ) == '1' ) {
			$this->enable_nav_item = true;
		} else {
			$this->enable_nav_item = false;
		}		
				
	}	
	
	function create_screen() {
		global $bp;
		
		if ( !bp_is_group_creation_step( $this->slug ) )
			return false;
			
		wp_nonce_field( 'groups_create_save_' . $this->slug );
		?>
		<input type="checkbox" name="bp_group_tinychat_enabled" id="bp_group_tinychat_enabled" value="1"  
			<?php 
			if ( groups_get_groupmeta( $bp->groups->current_group->id, 'bp_group_tinychat_enabled' ) == '1' ) {
				echo 'checked=1';
			}
			?>
		/>
		Enable <a href="http://wordpress.org/extend/plugins/bp-group-tinychat/" target="_blank">Group-Tinychat</a>
		<hr>
		<?php
	}

	function create_screen_save() {
		global $bp;
		
		check_admin_referer( 'groups_create_save_' . $this->slug );	
		
		if ( $_POST['bp_group_tinychat_enabled'] == 1 ) {
			groups_update_groupmeta( $bp->groups->current_group->id, 'bp_group_tinychat_enabled', 1 );
		}
	}

	function edit_screen() {
		global $bp;
		
		if ( !groups_is_user_admin( $bp->loggedin_user->id, $bp->groups->current_group->id ) ) {
			return false;
		}
		
		if ( !bp_is_group_admin_screen( $this->slug ) )
			return false;
			
		wp_nonce_field( 'groups_edit_save_' . $this->slug );
		?>
		<input type="checkbox" name="bp_group_tinychat_enabled" id="bp_group_tinychat_enabled" value="1"  
			<?php 
			if ( groups_get_groupmeta( $bp->groups->current_group->id, 'bp_group_tinychat_enabled' ) == '1' ) {
				echo 'checked=1';
			}
			?>
		/>
		Enable <a href="http://wordpress.org/extend/plugins/bp-group-tinychat/" target="_blank">Group-Tinychat</a>
                
		<hr>
		<input type="submit" name="save" value="Save" />
		<?php
	}

	function edit_screen_save() {
		global $bp;

		if ( !isset( $_POST['save'] ) )
			return false;

		check_admin_referer( 'groups_edit_save_' . $this->slug );
		
		if ( $_POST['bp_group_tinychat_enabled'] == 1 ) {
			groups_update_groupmeta( $bp->groups->current_group->id, 'bp_group_tinychat_enabled', 1 );
		} else {
			groups_update_groupmeta( $bp->groups->current_group->id, 'bp_group_tinychat_enabled', 0 );
		}
		
		bp_core_add_message( __( 'Settings saved successfully', 'buddypress' ) );
		
		bp_core_redirect( bp_get_group_permalink( $bp->groups->current_group ) . 'admin/' . $this->slug );

	}

	function display() {
		global $bp;
		
		if ( groups_is_user_member( $bp->loggedin_user->id, $bp->groups->current_group->id ) || groups_is_user_mod( $bp->loggedin_user->id, $bp->groups->current_group->id ) || groups_is_user_admin( $bp->loggedin_user->id, $bp->groups->current_group->id ) || is_super_admin() ) {
			
			$tinychat_display = true;
			$groupid = $bp->groups->current_group->id;
                $domain = parse_url(get_site_url());
                $domain = $domain['host'];
				$domainparts = explode(".", $domain);
                $domain = $domainparts[count($domainparts)-2] . "." . $domainparts[count($domainparts)-1];
                $domain = substr($domain, 0, 8);
				$domain = str_replace(".","",$domain);
				$domain = str_replace("-","",$domain);
				$string = $domain.$groupid;
				$string = substr($string, 0, 14);
                $name = strtolower($string);
                   
			?>
			<script type="text/javascript">var tinychat = { room: "<?php echo $name; ?>", colorbk: "0xffffff", join: "auto", api: "list", owner: "none", desktop: "true"}; </script><script src="http://tinychat.com/js/embed.js"></script>
            <?php
             
		} 
           else {
			echo '<div id="message" class="error"><p>Group_tinychat only available to group members.</p></div>';
		}
	}

	function widget_display() { 
		// Not used
	}
}
bp_register_group_extension( 'BP_Group_tinychat' );
?>