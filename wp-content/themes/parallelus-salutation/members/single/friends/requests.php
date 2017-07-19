<?php do_action( 'bp_before_member_friend_requests_content' ) ?>

<?php if ( bp_has_members( 'include=' . bp_get_friendship_requests() . '&per_page=0' ) ) : ?>

	<ul id="friend-list" class="item-list">
		<?php while ( bp_members() ) : bp_the_member(); ?>

			<li id="friendship-<?php bp_friend_friendship_id() ?>">
				<div class="item-container">
					<div class="item-content">
						
						<div class="item-avatar">
							<a href="<?php bp_member_link() ?>"><?php bp_member_avatar() ?></a>
						</div>
		
						<div class="action">
							<a class="button accept boxLink" href="<?php bp_friend_accept_request_link() ?>"><?php _e( 'Accept', 'buddypress' ); ?></a> &nbsp;
							<a class="button reject boxLink" href="<?php bp_friend_reject_request_link() ?>"><?php _e( 'Reject', 'buddypress' ); ?></a>
		
							<?php do_action( 'bp_friend_requests_item_action' ) ?>
						</div>	
							
						<div class="item">
							<h4 class="item-title"><a href="<?php bp_member_link() ?>"><?php bp_member_name() ?></a></h4>
							<div class="item-meta"><span class="activity"><?php bp_member_last_active() ?></span></div>
						</div>
		
						<?php do_action( 'bp_friend_requests_item' ) ?>

						
					</div>
				</div>
			</li>

		<?php endwhile; ?>
	</ul>

	<?php do_action( 'bp_friend_requests_content' ) ?>

<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( 'You have no pending friendship requests.', 'buddypress' ); ?></p>
	</div>

<?php endif;?>

<?php do_action( 'bp_after_member_friend_requests_content' ) ?>
