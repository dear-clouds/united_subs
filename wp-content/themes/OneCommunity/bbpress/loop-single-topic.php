<tr id="topic-<?php bbp_topic_id(); ?>" <?php bbp_topic_class(); ?>>


	<td class="forum-author-cell">
	<div class="post-author"><?php do_action( 'bbp_theme_before_topic_started_by' ); ?>
	<?php echo bbp_get_topic_author_link( array( 'size' => '50', 'type' => 'avatar' ) ); ?>
	<?php do_action( 'bbp_theme_after_topic_started_by' ); ?></div>
	</td>

	<td class="forum-topic-cell">

		<?php if ( bbp_is_user_home() ) : ?>

			<?php if ( bbp_is_favorites() ) : ?>

				<span class="bbp-topic-action">

					<?php do_action( 'bbp_theme_before_topic_favorites_action' ); ?>

					<?php bbp_user_favorites_link( array( 'before' => '', 'favorite' => '+', 'favorited' => '&times;' ) ); ?>

					<?php do_action( 'bbp_theme_after_topic_favorites_action' ); ?>

				</span>

			<?php elseif ( bbp_is_subscriptions() ) : ?>

				<span class="bbp-topic-action">

					<?php do_action( 'bbp_theme_before_topic_subscription_action' ); ?>

					<?php bbp_user_subscribe_link( array( 'before' => '', 'subscribe' => '+', 'unsubscribe' => '&times;' ) ); ?>

					<?php do_action( 'bbp_theme_after_topic_subscription_action' ); ?>

				</span>

			<?php endif; ?>

		<?php endif; ?>

		<?php do_action( 'bbp_theme_before_topic_title' ); ?>
		<div class="topic-title">
		<a class="forum-post-title" href="<?php bbp_topic_permalink(); ?>" title="<?php bbp_topic_title(); ?>"><?php bbp_topic_title(); ?></a>
		</div>
		<?php do_action( 'bbp_theme_after_topic_title' ); ?>

		<?php bbp_topic_pagination(); ?>

		<?php do_action( 'bbp_theme_before_topic_meta' ); ?>

		<span class="topic-in">

		<?php _e('Started by', 'OneCommunity'); ?> <?php printf( bbp_get_topic_author_link( array( 'type' => 'name' ) ) ); ?> <?php bbp_reply_post_date(); ?>

			<?php if ( !bbp_is_single_forum() || ( bbp_get_topic_forum_id() != bbp_get_forum_id() ) ) : ?>

				<?php do_action( 'bbp_theme_before_topic_started_in' ); ?>

				<span class="bbp-topic-started-in"><?php printf( __( 'in <a href="%1$s">%2$s</a>', 'bbpress' ), bbp_get_forum_permalink( bbp_get_topic_forum_id() ), bbp_get_forum_title( bbp_get_topic_forum_id() ) ); ?></span>

				<?php do_action( 'bbp_theme_after_topic_started_in' ); ?>

			<?php endif; ?>

		</span>

		<?php do_action( 'bbp_theme_after_topic_meta' ); ?>

		<?php bbp_topic_row_actions(); ?>

	</td>

	<td class="forum-counter-cell"><div class="topic-counter"><?php bbp_show_lead_topic() ? bbp_topic_reply_count() : bbp_topic_post_count(); ?></div></td>

	<td class="forum-freshness-cell">

		<?php do_action( 'bbp_theme_before_topic_freshness_link' ); ?>

				<div class="topic-freshness">
				<div class="last-poster-avatar"><?php bbp_author_link( array( 'post_id' => bbp_get_topic_last_active_id(), 'size' => 40, 'type' => 'avatar' ) ); ?></div>
					<div class="last-poster-right">
					<div class="time-since"><?php bbp_topic_freshness_link(); ?></div>
					<?php do_action( 'bbp_theme_after_topic_freshness_link' ); ?>
					<?php _e('Last post by ', 'OneCommunity'); ?> <?php bbp_author_link( array( 'post_id' => bbp_get_topic_last_active_id(), 'type' => 'name' ) ); ?>
					<?php do_action( 'bbp_theme_before_topic_freshness_author' ); ?>
					</div>
				</div>

			<?php do_action( 'bbp_theme_after_topic_freshness_author' ); ?>

	</td>

</tr>
