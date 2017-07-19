<?php

/**
 * Topics Loop - Single
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

	<tr id="topic-<?php bbp_topic_id(); ?>" <?php bbp_topic_class(); ?>>

		<td class="bbp-topic-info">

			<div class="bbp-topic-meta-content">
			
				<div class="bbp-topic-meta-counts">
					<span class="bbp-topic-reply-count"><?php bbp_show_lead_topic() ? bbp_topic_reply_count() : bbp_topic_post_count(); ?></span>
					<span class="bbp-topic-reply-label"><?php bbp_show_lead_topic() ? _e( 'Replies', 'bbpress' ) : _e( 'Posts', 'bbpress' ); ?></span>
					<span class="bbp-topic-voice-count"><?php bbp_topic_voice_count(); ?></span>
					<span class="bbp-topic-voices-label"><?php _e( 'Voices', 'bbpress' ); ?></span>
					<div class="clear"></div>
				</div>
				
				<div class="bbp-topic-meta-latest">
					<span class="bbp-topic-freshness">
									
						<?php do_action( 'bbp_theme_before_topic_freshness_link' ); ?>
			
						<?php bbp_topic_freshness_link(); ?>
			
						<?php do_action( 'bbp_theme_after_topic_freshness_link' ); ?>
						
					</span>
				</div>
				
				<?php if ( bbp_is_user_home() ) : ?>
				
					<?php if ( bbp_is_favorites() ) : ?>
					
						<div class="bbp-topic-action">
					
							<?php do_action( 'bbp_theme_before_topic_favorites_action' ); ?>
					
							<?php bbp_user_favorites_link( array( 'mid' => '+', 'post' => '' ), array( 'pre' => '', 'mid' => '&times;', 'post' => '' ) ); ?>
					
							<?php do_action( 'bbp_theme_after_topic_favorites_action' ); ?>
					
						</div>
					
					<?php elseif ( bbp_is_subscriptions() ) : ?>
					
						<div class="bbp-topic-action">
					
							<?php do_action( 'bbp_theme_before_topic_subscription_action' ); ?>
					
							<?php bbp_user_subscribe_link( array( 'before' => '', 'subscribe' => '+', 'unsubscribe' => '&times;' ) ); ?>
					
							<?php do_action( 'bbp_theme_after_topic_subscription_action' ); ?>
					
						</div>
					
					<?php endif; ?>
				
				<?php endif; ?>
	
			</div>
			
			<div class="bbp-topic-creator-avatar clearfix">
				<div class="avatar">
					<?php echo bbp_get_topic_author_link( array( 'size' => '128' ) ); ?>
				</div>
			</div>

			<?php do_action( 'bbp_theme_before_topic_title' ); ?>

			<h4 class="item-title">
				<a class="bbp-topic-title" href="<?php bbp_topic_permalink(); ?>" title="<?php bbp_topic_title(); ?>"><?php bbp_topic_title(); ?></a>
			</h4>

			<?php do_action( 'bbp_theme_after_topic_title' ); ?>

			<?php bbp_topic_pagination(); ?>

			<?php do_action( 'bbp_theme_before_topic_meta' ); ?>

			<p class="bbp-topic-meta">

				<?php do_action( 'bbp_theme_before_topic_started_by' ); ?>

				<span class="bbp-topic-started-by"><?php printf( __( 'Started by: %1$s', 'bbpress' ), bbp_get_topic_author_link( array( 'size' => '14' ) ) ); ?></span>

				<?php do_action( 'bbp_theme_after_topic_started_by' ); ?>

				<?php if ( !bbp_is_single_forum() || ( bbp_get_topic_forum_id() != bbp_get_forum_id() ) ) : ?>

					<?php do_action( 'bbp_theme_before_topic_started_in' ); ?>

					<span class="bbp-topic-started-in"><?php printf( __( 'in: <a href="%1$s">%2$s</a>', 'bbpress' ), bbp_get_forum_permalink( bbp_get_topic_forum_id() ), bbp_get_forum_title( bbp_get_topic_forum_id() ) ); ?></span>

					<?php do_action( 'bbp_theme_after_topic_started_in' ); ?>

				<?php endif; ?>
				
				<span class="sep">|</span>
				
				<span class="bbp-topic-meta">
				
					<?php do_action( 'bbp_theme_before_topic_freshness_author' ); ?>
	
					<span class="bbp-topic-freshness-author"><?php printf( __( 'Latest: %1$s', 'bbpress' ), bbp_get_author_link( array( 'post_id' => bbp_get_topic_last_active_id(), 'size' => 14 ) ) ); ?></span>
	
					<?php do_action( 'bbp_theme_after_topic_freshness_author' ); ?>
	
				</span>

			</p>

			<?php do_action( 'bbp_theme_after_topic_meta' ); ?>

		</td>

		<?php /*?><td class="bbp-topic-voice-count"><?php bbp_topic_voice_count(); ?></td><?php */?>

		<?php /*?><td class="bbp-topic-reply-count"><?php bbp_show_lead_topic() ? bbp_topic_reply_count() : bbp_topic_post_count(); ?></td><?php */?>

		<?php /*?><td class="bbp-topic-freshness">

			<?php do_action( 'bbp_theme_before_topic_freshness_link' ); ?>

			<?php bbp_topic_freshness_link(); ?>

			<?php do_action( 'bbp_theme_after_topic_freshness_link' ); ?>

			<p class="bbp-topic-meta">

				<?php do_action( 'bbp_theme_before_topic_freshness_author' ); ?>

				<span class="bbp-topic-freshness-author"><?php bbp_author_link( array( 'post_id' => bbp_get_topic_last_active_id(), 'size' => 14 ) ); ?></span>

				<?php do_action( 'bbp_theme_after_topic_freshness_author' ); ?>

			</p>
		</td><?php */?>

		<?php /*?><?php if ( bbp_is_user_home() ) : ?>

			<?php if ( bbp_is_favorites() ) : ?>

				<td class="bbp-topic-action">

					<?php do_action( 'bbp_theme_before_topic_favorites_action' ); ?>

					<?php bbp_user_favorites_link( array( 'mid' => '+', 'post' => '' ), array( 'pre' => '', 'mid' => '&times;', 'post' => '' ) ); ?>

					<?php do_action( 'bbp_theme_after_topic_favorites_action' ); ?>

				</td>

			<?php elseif ( bbp_is_subscriptions() ) : ?>

				<td class="bbp-topic-action">

					<?php do_action( 'bbp_theme_before_topic_subscription_action' ); ?>

					<?php bbp_user_subscribe_link( array( 'before' => '', 'subscribe' => '+', 'unsubscribe' => '&times;' ) ); ?>

					<?php do_action( 'bbp_theme_after_topic_subscription_action' ); ?>

				</td>

			<?php endif; ?>

		<?php endif; ?><?php */?>

	</tr><!-- #topic-<?php bbp_topic_id(); ?> -->
