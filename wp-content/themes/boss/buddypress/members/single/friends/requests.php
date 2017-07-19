<?php do_action( 'bp_before_member_friend_requests_content' ); ?>

<?php if ( bp_has_members( 'type=alphabetical&include=' . bp_get_friendship_requests() ) ) : ?>

	<div id="pag-top" class="pagination no-ajax">

		<div class="pag-count" id="member-dir-count-top">

			<?php bp_members_pagination_count(); ?>

		</div>

		<div class="pagination-links" id="member-dir-pag-top">

			<?php bp_members_pagination_links(); ?>

		</div>

	</div>

	<ul id="friend-list" class="item-list" role="main">
		<?php while ( bp_members() ) : bp_the_member(); ?>

			<li id="friendship-<?php bp_friend_friendship_id(); ?>">
				<div class="item-avatar">
					<a href="<?php bp_member_link(); ?>"><?php bp_member_avatar('type=full&width=70&height=70'); ?></a>
				</div>

				<div class="item">
					<div class="item-title"><a href="<?php bp_member_link(); ?>"><?php bp_member_name(); ?></a></div>
                    <?php
                    $showing = null;
                    //if bp-followers activated then show it.
                    if(function_exists("bp_follow_add_follow_button")) {
                        $showing = "follows";
                        $followers  = bp_follow_total_follow_counts(array("user_id"=>bp_displayed_user_id()));
                    } elseif (function_exists("bp_add_friend_button")) {
                        $showing = "friends";
                    }

                    ?>

                    <div class="item-meta">
                        <div class="activity">
                            <?php bp_member_last_active(); ?>
                        </div>

                        <?php if($showing == "friends"): ?>
                        <span class="count"><?php echo friends_get_total_friend_count(bp_get_member_user_id()); ?></span>
                        	<?php if ( friends_get_total_friend_count(bp_get_member_user_id()) > 1 ) { ?>
                            	<span><?php _e("Friends","boss"); ?></span>
                            <?php } else { ?>
                            	<span><?php _e("Friend","boss"); ?></span>
                            <?php } ?>                        
                        <?php endif; ?>

                        <?php if($showing == "follows"): ?>
                        <span class="count"><?php $followers = bp_follow_total_follow_counts(array("user_id"=>bp_get_member_user_id())); echo $followers["followers"]; ?></span><span><?php _e("Followers","boss"); ?></span>
                        <?php endif; ?>
                    </div>
				</div>
				


				<?php do_action( 'bp_friend_requests_item' ); ?>

				<div class="action">
				    <div class="action-wrap">
                        <div class="generic-button">
                             <a class="button accept" href="<?php bp_friend_accept_request_link(); ?>"><?php _e( 'Accept', 'buddypress' ); ?></a>
                        </div>
                        <div class="generic-button">
                             <a class="button reject" href="<?php bp_friend_reject_request_link(); ?>"><?php _e( 'Reject', 'buddypress' ); ?></a>
                        </div>
    
                        <?php do_action( 'bp_friend_requests_item_action' ); ?>
					</div>
				</div>
			</li>

		<?php endwhile; ?>
	</ul>

	<?php do_action( 'bp_friend_requests_content' ); ?>

	<div id="pag-bottom" class="pagination no-ajax">

		<div class="pag-count" id="member-dir-count-bottom">

			<?php bp_members_pagination_count(); ?>

		</div>

		<div class="pagination-links" id="member-dir-pag-bottom">

			<?php bp_members_pagination_links(); ?>

		</div>

	</div>

<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( 'You have no pending friendship requests.', 'buddypress' ); ?></p>
	</div>

<?php endif;?>

<?php do_action( 'bp_after_member_friend_requests_content' ); ?>
