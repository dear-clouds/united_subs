<?php do_action( 'bp_before_group_header' ) ?>

<div id="item-actions">

	<h5 class="item-actions-title"><?php _e( 'Group Admins', 'buddypress' ) ?></h5>
	
	<?php 
	
	// Get the admin avatars
	//................................................................
	
	// Stripped from function "bp_group_list_admins()"

	$group =& $GLOBALS['groups_template']->group;
	if ( $group->admins ) : ?>
		<ul id="group-admins">
			<?php foreach( (array)$group->admins as $admin ) { ?>
				<li>
					<a href="<?php echo bp_core_get_user_domain( $admin->user_id, $admin->user_nicename, $admin->user_login ) ?>" title="<?php echo bp_core_get_user_displayname($admin->user_id); ?>">
						<?php
						// get the avatar image
						// $avatarURL = bp_theme_avatar_url(24,24,'', bp_core_fetch_avatar(array( 'item_id' => $admin->user_id, 'email' => $admin->user_email, 'type' => 'full', 'html' => 'false', 'width' => 24, 'height' => 24 )) );
						// echo '<div class="avatar" style="background-image: url(\''.$avatarURL.'\'); width:24px; height:24px; "></div>';
						echo bp_core_fetch_avatar( array( 'item_id' => $admin->user_id, 'email' => $admin->user_email ) );
						?>
					</a>
					<div class="nickname"><?php echo bp_core_get_user_displayname($admin->user_id); ?></div>
					<div class="clear"></div>
				</li>
			<?php } ?>
		</ul>
	<?php else: ?>
		<span class="activity"><?php _e( 'No Admins', 'buddypress' ) ?></span>
	<?php endif; ?>


	<?php do_action( 'bp_after_group_menu_admins' ) ?>


	<?php if ( bp_group_has_moderators() ) : ?>
		<?php do_action( 'bp_before_group_menu_mods' ) ?>

		<h5 class="item-actions-title"><?php _e( 'Group Mods' , 'buddypress' ) ?></h5>
		<?php 
		
		// Get the moderator avatars
		//................................................................

		// Stripped from function "bp_group_list_mods()"

		$group =& $GLOBALS['groups_template']->group;
		if ( $group->mods ) : ?>
			<ul id="group-mods">
				<?php foreach( (array)$group->mods as $mod ) { ?>
					<li>
						<a href="<?php echo bp_core_get_user_domain( $mod->user_id, $mod->user_nicename, $mod->user_login ) ?>" title="<?php echo bp_core_get_user_displayname($mod->user_id); ?>">
							<?php
							// get the avatar image
							// $avatarURL = bp_theme_avatar_url(24,24,'', bp_core_fetch_avatar(array( 'item_id' => $mod->user_id, 'email' => $mod->user_email, 'type' => 'full', 'html' => 'false', 'width' => 24, 'height' => 24 )) );
							// echo '<div class="avatar" style="background-image: url(\''.$avatarURL.'\'); width:24px; height:24px; "></div>';
							echo bp_core_fetch_avatar( array( 'item_id' => $mod->user_id, 'email' => $mod->user_email ) );
							?>
						</a>
						<div class="nickname"><?php echo bp_core_get_user_displayname($mod->user_id); ?></div>
						<div class="clear"></div>
					</li>
				<?php } ?>
			</ul>
		<?php else: ?>
			<span class="activity"><?php _e( 'No Mods', 'buddypress' ) ?></span>
		<?php endif ?>


		<?php do_action( 'bp_after_group_menu_mods' ) ?>
	<?php endif; ?>

</div><!-- #item-actions -->



<div>
	<header id="item-header-content" class="entry-header group-single-header clearfix">
	
		<div id="item-header-avatar">
			<a href="<?php bp_group_permalink() ?>" title="<?php bp_group_name() ?>">
				<?php 
				// get the avatar image
				// $size = 80;
				// $avatarURL = bp_theme_avatar_url($size, $size, 'group_avatar');
				// echo '<div class="avatar" style="background-image: url(\''.$avatarURL.'\'); width:'.$size.'px; height:'.$size.'px; "></div>'; 
				bp_group_avatar( 'type=full' ) ?>
			</a>
		</div><!-- #item-header-avatar -->
		
		<h1 class="entry-title"><a href="<?php bp_group_permalink() ?>" title="<?php bp_group_name() ?>"><?php bp_group_name() ?></a></h1>
		
		<div class="my-activity">
			<span class="group-type"><?php bp_group_type() ?>&nbsp; |&nbsp;</span>
			<?php printf( __( 'active %s ago', 'buddypress' ), bp_get_group_last_active() ) ?>
		</div>
		
		<?php do_action( 'bp_before_group_header_meta' ) ?>
	
		<div class="item-buttons">
			<?php bp_group_join_button() ?>
	
			<?php do_action( 'bp_group_header_meta' ) ?>
		</div>
		
		<div style="clear:left;"></div>
					
		<div id="item-meta">
			<?php bp_group_description() ?>
		</div>
	
	</header> <!-- #item-header-content -->
</div>



<?php do_action( 'template_notices' ) ?>

<?php do_action( 'bp_after_group_header' ) ?>

