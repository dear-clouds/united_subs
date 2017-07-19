<?php do_action( 'bp_before_group_invites_content' ) ?>

<?php if ( bp_has_groups( 'type=invites&user_id=' . bp_loggedin_user_id() ) ) : ?>

	<ul id="group-list" class="invites item-list">

		<?php while ( bp_groups() ) : bp_the_group(); ?>

			<li>
				<div class="item-avatar">
					<?php 
					// get the avatar image
					$avatarURL = bp_theme_avatar_url(80,80, 'group_avatar');
					echo '<div class="avatar" style="background-image: url(\''.$avatarURL.'\'); width:80px; height:80px; "></div>';
					//bp_group_avatar_thumb() ?>
				</div>
				
				<div class="item">
					<h4 class="item-title"><a href="<?php bp_group_permalink() ?>"><?php bp_group_name() ?></a> <span class="small">(<?php printf( __( '%s members', 'buddypress' ), bp_group_total_members( false ) ) ?>)</span></h4>
	
					<div class="item-desc">
						<?php bp_group_description_excerpt() ?>
					</div>
	
					<?php do_action( 'bp_group_invites_item' ) ?>
	
					<div class="action">
						<a class="button btn small accept" href="<?php bp_group_accept_invite_link() ?>"><span><?php _e( 'Accept', 'buddypress' ) ?></span></a>
						<a class="button btn small reject confirm" href="<?php bp_group_reject_invite_link() ?>"><span><?php _e( 'Reject', 'buddypress' ) ?></span></a>
	
						<?php do_action( 'bp_group_invites_item_action' ) ?>
	
					</div>
				</div>
				
				<div class="clear"></div>
			</li>

		<?php endwhile; ?>
	</ul>

<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( 'You have no outstanding group invites.', 'buddypress' ) ?></p>
	</div>

<?php endif;?>

<?php do_action( 'bp_after_group_invites_content' ) ?>