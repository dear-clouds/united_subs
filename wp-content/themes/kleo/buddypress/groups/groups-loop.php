<?php

/**
 * BuddyPress - Groups Loop
 *
 * Querystring is set via AJAX in _inc/ajax.php - bp_legacy_theme_object_filter()
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>

<?php do_action( 'bp_before_groups_loop' ); ?>

<?php if ( bp_has_groups( bp_ajax_querystring( 'groups' ). '&per_page='.sq_option('bp_groups_perpage', 24) ) ) : ?>

<?php /*
<!--For iSotope filter-->

<!--<div class="btn-group">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
    Filter By <span class="caret"></span>
  </button>
  <ul id="portfoliofilter" class="dropdown-menu" role="menu">
    <li class="current"><a href="all">All Groups</a></li>
    <li class="divider"></li>
    <li><a href="public">Public</a></li>
    <li><a href="private">Private</a></li>
  </ul>
</div>-->
*/?>

	<div id="pag-top" class="pagination">

		<div class="pag-count" id="group-dir-count-top">

			<?php bp_groups_pagination_count(); ?>

		</div>

		<div class="pagination-links" id="group-dir-pag-top">

			<?php bp_groups_pagination_links(); ?>

		</div>

	</div>

	<?php do_action( 'bp_before_directory_groups_list' ); ?>


	<ul id="groups-list" class="item-list kleo-isotope masonry">

	<?php while ( bp_groups() ) : bp_the_group(); ?>

		<li <?php bp_group_class(); ?>>
    	<div class="group-inner-list animated animate-when-almost-visible bottom-to-top">
      
      <div class="item-avatar rounded">
				<a href="<?php bp_group_permalink(); ?>"><?php bp_group_avatar( 'type=full&width=80&height=80' ); ?></a>
        <span class="member-count"><?php echo preg_replace('/\D/', '', bp_get_group_member_count());  ?></span>
			</div>

			<div class="item">
				<div class="item-title"><a href="<?php bp_group_permalink(); ?>"><?php bp_group_name(); ?></a></div>
				<div class="item-meta"><span class="activity"><?php printf( __( 'active %s', 'buddypress' ), bp_get_group_last_active() ); ?></span></div>

				<div class="item-desc"><?php bp_group_description_excerpt(); ?></div>

				<?php do_action( 'bp_directory_groups_item' ); ?>

			</div>

			<div class="action">

				

				<div class="meta">

					<?php bp_group_type(); ?>

				</div>
        
        <?php do_action( 'bp_directory_groups_actions' ); ?>

			</div>
			</div><!--end group-inner-lis-->
		</li>

	<?php endwhile; ?>

	</ul>

	<?php do_action( 'bp_after_directory_groups_list' ); ?>

	<div id="pag-bottom" class="pagination">

		<div class="pag-count" id="group-dir-count-bottom">

			<?php bp_groups_pagination_count(); ?>

		</div>

		<div class="pagination-links" id="group-dir-pag-bottom">

			<?php bp_groups_pagination_links(); ?>

		</div>

	</div>

<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( 'There were no groups found.', 'buddypress' ); ?></p>
	</div>

<?php endif; ?>

<?php do_action( 'bp_after_groups_loop' ); ?>
