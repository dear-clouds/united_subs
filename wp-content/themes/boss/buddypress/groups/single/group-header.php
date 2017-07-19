<?php
/**
 * BuddyPress - Group Header
 *
 * @package BuddyPress
 * @subpackage Boss
 */
?>

<?php do_action( 'bp_before_group_header' ); ?>

<?php
//output cover photo.
if ( boss_get_option( 'boss_layout_style' ) != 'boxed' && boss_get_option('boss_cover_group') ) {
	echo buddyboss_cover_photo( "group", bp_get_group_id() );
}
?>

<div id="item-header-cover" class="table">

	<div class="table-cell">

		<div id="group-name">
			<h1 class="main-title"><?php
				$group_name = bp_get_group_name();

				if ( ! empty( $group_name ) ) {

					//Get truncated string with long width group title
					if ( wp_is_mobile() ) {
						echo mb_strimwidth( $group_name, 0, 35, "...");
					} else {
						echo mb_strimwidth( $group_name, 0, 55, "...");
					}
				}
				?></h1>
			<span class="activity"><?php printf( __( 'active %s', 'boss' ), bp_get_group_last_active() ); ?></span>
		</div>


		<div id="item-header-avatar-mobile">
			<a href="<?php bp_group_permalink(); ?>" title="<?php bp_group_name(); ?>">

				<?php bp_group_avatar(); ?>

			</a>
		</div><!-- #item-header-avatar -->


		<div id="item-header-content">
			<ul class="group-info">
				<li class="group-type">
					<p>
						<?php
						global $groups_template;
						$group = & $groups_template->group;
						if ( 'public' == $group->status ) {
							$type = __( "Public", "boss" );
						} else if ( 'hidden' == $group->status ) {
							$type = __( "Hidden", "boss" );
						} else if ( 'private' == $group->status ) {
							$type = __( "Private", "boss" );
						} else {
							$type = ucwords( $group->status );
						}

						echo $type;
						?>
					</p>
					<p class="small"><?php _e( "Group", 'boss' ); ?></p>
				</li>
				<li class="group-members">
					<p>
						<?php
						global $groups_template;
						if ( isset( $groups_template->group->total_member_count ) ) {
							$count = (int) $groups_template->group->total_member_count;
						} else {
							$count = 0;
						}
						echo $count;
						?>
					</p>
					<p class="small"><?php echo _n( 'Member', 'Members', $count, 'boss' ); ?></p>
				</li>

				<?php do_action( 'bb_before_group_header_meta_extra_li' ); ?>
			</ul>

			<?php do_action( 'bp_before_group_header_meta' ); ?>


			<div id="item-buttons" class="group">

				<?php
				//as we are going to show join button remove it from header hook
				remove_action( 'bp_group_header_actions', 'bp_group_join_button', 5 );
				ob_start();
				do_action( 'bp_group_header_actions' );
				$action_output = ob_get_contents();
				ob_end_clean();
				?>

				<div id="main-button" class="<?php
				if ( !empty( $action_output ) ) {
					echo 'primary-btn';
				}
				?>">
						 <?php
						 bp_group_join_button();
						 ?>
				</div>

				<?php
				if ( !empty( $action_output ) ): //only show if output exists
					?>

					<!-- more items -->
					<span class="single-member-more-actions">
						<button class="more-items-btn btn"><i class="fa fa-ellipsis-h"></i></button>

						<!--popup-->
						<div class="pop">
							<div class="inner">
								<?php echo $action_output; ?>
							</div>
						</div>
					</span>

				<?php endif; ?>

			</div><!-- #item-buttons -->


		</div><!-- #item-header-content -->

		<div id="item-actions">

			<?php if ( bp_group_is_visible() ) : ?>

				<h3><?php _e( 'Group Admins', 'boss' ); ?></h3>

				<?php
				bp_group_list_admins();

				do_action( 'bp_after_group_menu_admins' );

				if ( bp_group_has_moderators() ) :
					do_action( 'bp_before_group_menu_mods' );
					?>

					<h3><?php _e( 'Group Mods', 'boss' ); ?></h3>

					<?php
					bp_group_list_mods();

					do_action( 'bp_after_group_menu_mods' );

				endif;

			endif;
			?>

		</div><!-- #item-actions -->


	</div>

	<div id="item-header-avatar" class="table-cell">
		<a href="<?php bp_group_permalink(); ?>" title="<?php bp_group_name(); ?>">

			<?php bp_group_avatar(); ?>

		</a>
	</div><!-- #item-header-avatar -->

</div>


<?php
do_action( 'bp_after_group_header' );
do_action( 'template_notices' );
