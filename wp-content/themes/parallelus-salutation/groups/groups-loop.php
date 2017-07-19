<?php /* Querystring is set via AJAX in _inc/ajax.php - bp_dtheme_object_filter() */ ?>

<?php do_action( 'bp_before_groups_loop' ) ?>

<?php if ( bp_has_groups( bp_ajax_querystring( 'groups' ) ) ) : ?>

	<div class="bp-pagination">

		<div class="pag-count" id="group-dir-count">
			<?php bp_groups_pagination_count() ?>
		</div>

		<div class="pagination-links" id="group-dir-pag">
			<?php bp_groups_pagination_links() ?>
		</div>

	</div>

	<ul id="groups-list" class="item-list">
	<?php while ( bp_groups() ) : bp_the_group(); ?>

		<li class="item-li">
			<div class="item-container">
				<div class="item-content">
				
					<div class="item-avatar">
						<a href="<?php bp_group_permalink() ?>">
							<?php 
							// get the avatar image
							// $avatarURL = bp_theme_avatar_url(80,80, 'group_avatar');
							// echo '<div class="avatar" style="background-image: url(\''.$avatarURL.'\'); width:80px; height:80px; "></div>';
							bp_group_avatar( 'type=full' ) ?>
						</a>
					</div>
		
					<div class="action">
						<?php bp_group_join_button() ?>
		
						<div class="meta">
							<?php bp_group_type() ?> / <?php bp_group_member_count() ?>
						</div>
		
						<?php do_action( 'bp_directory_groups_actions' ) ?>
					</div>
		
					<div class="item">
						<h4 class="item-title"><a href="<?php bp_group_permalink() ?>"><?php bp_group_name() ?></a></h4>
						<div class="item-meta"><span class="activity"><?php printf( __( 'active %s', 'buddypress' ), bp_get_group_last_active() ) ?></span></div>
		
						<div class="item-desc"><?php 
							if ( !isset($group ) ) {
								$group =& $GLOBALS['groups_template']->group;
							}
							echo bp_create_excerpt( $group->description, 100 )
							//bp_group_description_excerpt() ?>
						</div>
		
						<?php do_action( 'bp_directory_groups_item' ) ?>
					</div>
		
					<div class="clear"></div>
				
				</div>
			</div>
		</li>

	<?php endwhile; ?>
	</ul>

	<?php do_action( 'bp_after_groups_loop' ) ?>

<?php else: ?>

	<div id="message" class="messageBox note icon">
		<span><?php _e( 'There were no groups found.', 'buddypress' ) ?></span>
	</div>

<?php endif; ?>