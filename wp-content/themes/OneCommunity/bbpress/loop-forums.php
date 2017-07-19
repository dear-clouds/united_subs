<?php do_action( 'bbp_template_before_forums_loop' ); ?>

<table id="topic-post-list" class="item-list" role="main">

<thead>
	<tr class="forum-head">
		<td class="forum-head-forum"><?php _e( 'Forum', 'bbpress' ); ?></td>
		<td class="forum-head-counter topics-count"><?php _e( 'Topics', 'bbpress' ); ?></td>
		<td class="forum-head-counter posts-count"><?php bbp_show_lead_topic() ? _e( 'Replies', 'bbpress' ) : _e( 'Posts', 'bbpress' ); ?></td>
		<td class="forum-head-freshness"><?php _e( 'Freshness', 'OneCommunity' ); ?></td>
	</tr>
</thead>


	<tbody>

		<?php while ( bbp_forums() ) : bbp_the_forum(); ?>

			<?php bbp_get_template_part( 'loop', 'single-forum' ); ?>

		<?php endwhile; ?>

	</tbody>

</table>

<?php do_action( 'bbp_template_after_forums_loop' ); ?>
