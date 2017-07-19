<?php do_action( 'bp_before_member_header' ) ?>

<header id="item-header-content" class="entry-header member-single-header <?php if ( bp_is_my_profile() ) : echo 'my-profile'; endif; ?> clearfix">
	
	<div id="item-header-avatar">
		<a href="<?php bp_user_link() ?>">
			<?php  
			// // get the avatar image
			// $size = 80;
			// $avatarURL = bp_theme_avatar_url($size,$size,'', bp_core_fetch_avatar(array( 'item_id' => $GLOBALS['bp']->displayed_user->id, 'type' => 'full', 'html' => 'false', 'width' => $size, 'height' => $size )) );
			// echo '<div class="avatar" style="background-image: url(\''.$avatarURL.'\'); width:'.$size.'px; height:'.$size.'px; "></div>'; 
			bp_displayed_user_avatar( 'type=full' );
			?>
		</a>
	</div><!-- #item-header-avatar -->
	
	<h1 class="entry-title"><a href="<?php bp_user_link() ?>"><?php bp_displayed_user_fullname() ?></a></h1>
	
	<span class="at-mention">@<?php bp_displayed_user_username() ?></span>
	
	<div class="my-activity"><?php bp_last_activity( bp_displayed_user_id() ) ?></div>
	
	<div class="item-buttons clearfix">
		<?php if ( function_exists( 'bp_add_friend_button' ) ) : ?>
			<?php bp_add_friend_button() ?>
		<?php endif; ?>

		<?php if ( is_user_logged_in() && !bp_is_my_profile() && function_exists( 'bp_send_public_message_link' ) ) : ?>
			<div class="generic-button" id="post-mention">
				<a href="<?php bp_send_public_message_link() ?>" title="<?php _e( 'Mention this user in a new public message, this will send the user a notification to get their attention.', 'buddypress' ) ?>"><?php _e( 'Mention this User', 'buddypress' ) ?></a>
			</div>
		<?php endif; ?>

		<?php if ( is_user_logged_in() && !bp_is_my_profile() && function_exists( 'bp_send_private_message_link' ) ) : ?>
			<div class="generic-button" id="send-private-message">
				<a href="<?php bp_send_private_message_link() ?>" title="<?php _e( 'Send a private message to this user.', 'buddypress' ) ?>"><?php _e( 'Send Private Message', 'buddypress' ) ?></a>
			</div>
		<?php endif; ?>
	</div><!-- #item-buttons -->

</header>

<div class="item-meta">
	
	<?php do_action( 'bp_before_member_header_meta' ); ?>
	
	<?php 
	if ( function_exists( 'bp_activity_latest_update' ) ) : ?>
		<div class="latest-update">
			<?php bp_activity_latest_update( bp_displayed_user_id() ) ?>
		</div>
		<?php 
	endif;
	
	 /***
	  * If you'd like to show specific profile fields here use:
	  * bp_profile_field_data( 'field=About Me' ); -- Pass the name of the field
	  */
	?>

	<?php do_action( 'bp_profile_header_meta' ) ?>
	
</div><!-- #item-meta -->



<?php do_action( 'template_notices' ) ?>

<?php do_action( 'bp_after_member_header' ) ?>
