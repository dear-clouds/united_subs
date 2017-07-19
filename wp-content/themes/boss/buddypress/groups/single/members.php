<?php if ( bp_group_has_members( bp_ajax_querystring( 'group_members' ) ) ) : ?>

	<?php do_action( 'bp_before_group_members_content' ); ?>


	<?php
	//only add markup if do action have output.
	$action_out = null;
	ob_start();
	do_action( 'bp_members_directory_member_sub_types' );
	$action_out = ob_get_contents(); //capture the do action content into var.
	ob_end_clean();
	if(!empty($action_out)):
	?>
	<div class="item-list-tabs" id="subnav" role="navigation">
		<ul>
			<?php echo $action_out; ?>
		</ul>
	</div>
	<?php endif; ?>

	<div id="pag-top" class="pagination no-ajax">

		<div class="pag-count" id="member-count-top">

			<?php bp_members_pagination_count(); ?>

		</div>

		<div class="pagination-links" id="member-pag-top">

			<?php bp_members_pagination_links(); ?>

		</div>

	</div>

	<?php do_action( 'bp_before_group_members_list' ); ?>

	<ul id="members-list" class="item-list" role="main">

		<?php while ( bp_group_members() ) : bp_group_the_member(); ?>

			<li>
			    <div class="item-avatar">
                    <a href="<?php bp_group_member_domain(); ?>">

                        <?php bp_group_member_avatar_thumb('type=full&width=70&height=70'); ?>

                    </a>
			    </div>

				<div class="item">
                    <div class="item-title"><?php bp_group_member_link(); ?></div>
                    <div class="item-meta">
                        <span class="activity"><?php bp_group_member_joined_since(); ?></span>
                    </div>

				<?php do_action( 'bp_group_members_list_item' ); ?>

                </div>
                <?php if ( bp_is_active( 'friends' ) ) : ?>

					<div class="action">
					    <div class="action-wrap">

                            <?php bp_add_friend_button( bp_get_group_member_id(), bp_get_group_member_is_friend() ); ?>

                            <?php do_action( 'bp_group_members_list_item_action' ); ?>

					    </div>
					</div>

				<?php endif; ?>
			</li>

		<?php endwhile; ?>

	</ul>

	<?php do_action( 'bp_after_group_members_list' ); ?>

	<div id="pag-bottom" class="pagination">

		<div class="pag-count" id="member-count-bottom">

			<?php bp_members_pagination_count(); ?>

		</div>

		<div class="pagination-links" id="member-pag-bottom">

			<?php bp_members_pagination_links(); ?>

		</div>

	</div>

	<?php do_action( 'bp_after_group_members_content' ); ?>

<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( 'This group has no members.', 'boss' ); ?></p>
	</div>

<?php endif; ?>
