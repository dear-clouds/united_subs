<?php

/**
 * BuddyPress - Members Loop
 *
 * Querystring is set via AJAX in _inc/ajax.php - bp_legacy_theme_object_filter()
 *
 * @package Boss
 * @subpackage bp-legacy
 */

?>

<?php do_action( 'bp_before_members_loop' ); ?>

<?php if ( bp_has_members( bp_ajax_querystring( 'members' ) ) ) : ?>

	<div id="pag-top" class="pagination">

		<div class="pag-count" id="member-dir-count-top">

			<?php bp_members_pagination_count(); ?>

		</div>

		<div class="pagination-links" id="member-dir-pag-top">

			<?php bp_members_pagination_links(); ?>

		</div>

	</div>

	<?php do_action( 'bp_before_directory_members_list' ); ?>

	<ul id="members-list" class="item-list" role="main">

	<?php while ( bp_members() ) : bp_the_member(); ?>

		<li>
			<div class="item-avatar">
				<a href="<?php bp_member_permalink(); ?>"><?php bp_member_avatar('type=full&width=70&height=70'); ?></a>
			</div>

			<div class="item">
				<div class="item-title">
					<a href="<?php bp_member_permalink(); ?>"><?php bp_member_name(); ?></a>
				</div>

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

				<div class="item-desc">
					<p>
						<?php if ( bp_get_member_latest_update() ) : ?>
							<?php bp_member_latest_update( array( 'view_link' => true ) ); ?>
						<?php endif; ?>
					</p>
				</div>

				<?php do_action( 'bp_directory_members_item' ); ?>

				<?php
				 /***
				  * If you want to show specific profile fields here you can,
				  * but it'll add an extra query for each member in the loop
				  * (only one regardless of the number of fields you show):
				  *
				  * bp_member_profile_data( 'field=the field name' );
				  */
				?>
			</div>

			<div class="action">
                <div class="action-wrap">
				    <?php do_action( 'bp_directory_members_actions' ); ?>
                </div>
			</div>

			<div class="clear"></div>
		</li>

	<?php endwhile; ?>

	</ul>

	<?php do_action( 'bp_after_directory_members_list' ); ?>

	<?php bp_member_hidden_fields(); ?>

	<div id="pag-bottom" class="pagination">

		<div class="pag-count" id="member-dir-count-bottom">

			<?php bp_members_pagination_count(); ?>

		</div>

		<div class="pagination-links" id="member-dir-pag-bottom">

			<?php bp_members_pagination_links(); ?>

		</div>

	</div>

<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( "Sorry, no members were found.", 'boss' ); ?></p>
	</div>

<?php endif; ?>

<?php do_action( 'bp_after_members_loop' ); ?>
