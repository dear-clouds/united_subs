<?php /* Querystring is set via AJAX in _inc/ajax.php - bp_dtheme_object_filter() */ ?>

<?php do_action( 'bp_before_members_loop' ) ?>

<?php if ( bp_has_members( bp_ajax_querystring( 'members' ) ) ) : ?>

	<div class="bp-pagination pagination">
		<div class="pag-count" id="member-dir-count">
			<?php bp_members_pagination_count() ?>
		</div>
		<div class="pagination-links" id="member-dir-pag">
			<?php bp_members_pagination_links() ?>
		</div>
	</div>

	<?php do_action( 'bp_before_directory_members_list' ) ?>

	<div class="clear"></div>

	<ul id="members-list" class="item-list">
	<?php while ( bp_members() ) : bp_the_member(); ?>

		<li class="item-li">
		
			<div class="item-container">
				<div class="item-content clearfix">
				
					<header class="item-header">
						
						<div class="item-avatar">
							<a href="<?php bp_member_permalink() ?>">
								<?php 
								// get the avatar image
								// $avatarURL = bp_theme_avatar_url(AVATAR_SIZE, AVATAR_SIZE, 'member_avatar');
								// echo '<div class="avatar" style="background-image: url(\''.$avatarURL.'\');"></div>'; 
								bp_member_avatar('type=thumb&width='.AVATAR_SIZE.'&height='.AVATAR_SIZE); 
								?>
							</a>
						</div>
					
						<div class="action">
							<?php
							//bp_member_add_friend_button() 
							do_action( 'bp_directory_members_actions' );
							?>
						</div>
									
						<h4 class="item-title poster-name <?php if ( bp_get_member_latest_update() ) echo 'withStatus'; ?>">
							<a href="<?php bp_member_permalink() ?>"><?php bp_member_name() ?></a>
						</h4>
	
						<div class="item-meta"><span class="activity"><?php bp_member_last_active() ?></span></div>
									
					</header>
					
					<?php if ( bp_get_member_latest_update() ) : ?>
						<p class="update"><?php bp_member_latest_update( 'length=50' ) ?></p>
					<?php endif; ?>
	
					<?php do_action( 'bp_directory_members_item' ) ?>
	
					<?php
					 /***
					  * If you want to show specific profile fields here you can,
					  * but it'll add an extra query for each member in the loop
					  * (only one regadless of the number of fields you show):
					  *
					  * bp_member_profile_data( 'field=the field name' );
					  */
					?>
					
				
				</div>
			</div>
			
		</li>

	<?php endwhile; ?>
	</ul>

	<?php do_action( 'bp_after_directory_members_list' ) ?>

	<?php bp_member_hidden_fields() ?>

<?php else: ?>

	<div id="message" class="messageBox note icon">
		<span><?php _e( "Sorry, no members were found.", 'buddypress' ) ?></span>
	</div>

<?php endif; ?>

<?php do_action( 'bp_after_members_loop' ) ?>