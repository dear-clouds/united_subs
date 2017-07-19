<tr id="bbp-forum-<?php bbp_forum_id(); ?>" <?php bbp_forum_class(); ?>>

	<td class="forum-cell">

		<?php do_action( 'bbp_theme_before_forum_title' ); ?>

		<a class="bbp-forum-title" href="<?php bbp_forum_permalink(); ?>" title="<?php bbp_forum_title(); ?>"><?php bbp_forum_title(); ?></a>

		<?php do_action( 'bbp_theme_after_forum_title' ); ?>

		<?php do_action( 'bbp_theme_before_forum_sub_forums' ); ?>

		<?php bbp_list_forums(); ?>

		<?php do_action( 'bbp_theme_after_forum_sub_forums' ); ?>

		<?php do_action( 'bbp_theme_before_forum_description' ); ?>

		<div class="bbp-forum-content"><?php the_content(); ?></div>

		<?php do_action( 'bbp_theme_after_forum_description' ); ?>

		<?php bbp_forum_row_actions(); ?>

	</td>

	<td class="forum-counter-cell topics-count"><div class="topic-counter"><?php bbp_forum_topic_count(); ?></div></td>

	<td class="forum-counter-cell posts-count"><div class="topic-counter"><?php bbp_show_lead_topic() ? bbp_forum_reply_count() : bbp_forum_post_count(); ?></div></td>

	<td class="forum-freshness-cell">

		<?php do_action( 'bbp_theme_before_forum_freshness_link' ); ?>

			<div class="topic-freshness">
			<div class="last-poster-avatar"><?php bbp_author_link( array( 'post_id' => bbp_get_forum_last_active_id(), 'size' => 40, 'type' => 'avatar' ) ); ?></div>
				<div class="last-poster-right">
				<?php do_action( 'bbp_theme_after_forum_freshness_link' ); ?>
				<div class="time-since"><?php bbp_forum_freshness_link(); ?></div>
				<?php do_action( 'bbp_theme_before_topic_author' ); ?>

				<?php
				if (bbp_get_forum_topic_count() > 0) {
				_e('Last post by ', 'OneCommunity');
				}
				else
				{}
				bbp_author_link( array( 'post_id' => bbp_get_forum_last_active_id(), 'type' => 'name' ) ); ?>
				<?php do_action( 'bbp_theme_after_topic_author' ); ?>
				</div>
			</div>

	</td>
</tr>