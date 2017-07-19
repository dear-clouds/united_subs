<?php

/**
 * Topics Loop - Single
 *
 * @package bbPress
 * @subpackage Boss
 */

?>

<ul id="bbp-topic-<?php bbp_topic_id(); ?>" <?php bbp_topic_class(); ?>>

	<li class="bbp-topic-title">
		
		<div class="bbp-topic-title-content">
		
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
	
			<a class="bbp-topic-permalink" href="<?php bbp_topic_permalink(); ?>" title="<?php bbp_topic_title(); ?>"><?php bbp_topic_title(); ?></a>
	
			<?php do_action( 'bbp_theme_after_topic_title' ); ?>
	
			<?php bbp_topic_pagination(); ?>
	
			<?php do_action( 'bbp_theme_before_topic_meta' ); ?>
	
			<p class="bbp-topic-meta">
	
				<!--
				<?php do_action( 'bbp_theme_before_topic_started_by' ); ?>
	
				<div class="bbp-topic-started-by"><?php printf( __( 'Started by: %1$s', 'boss' ), bbp_get_topic_author_link( array( 'size' => '14' ) ) ); ?></div>
	
				<?php do_action( 'bbp_theme_after_topic_started_by' ); ?>
				-->
	
				<?php if ( !bbp_is_single_forum() || ( bbp_get_topic_forum_id() != bbp_get_forum_id() ) ) : ?>
	
					<?php do_action( 'bbp_theme_before_topic_started_in' ); ?>
	
					<div class="bbp-topic-started-in"><?php printf( __( 'in: <a href="%1$s">%2$s</a>', 'boss' ), bbp_get_forum_permalink( bbp_get_topic_forum_id() ), bbp_get_forum_title( bbp_get_topic_forum_id() ) ); ?></div>
	
					<?php do_action( 'bbp_theme_after_topic_started_in' ); ?>
	
				<?php endif; ?>
	
			</p>
	
			<?php do_action( 'bbp_theme_after_topic_meta' ); ?>
	
			<?php bbp_topic_row_actions(); ?>
			
		</div>

	</li>

	<li class="bbp-topic-voice-count"><?php bbp_topic_voice_count(); ?></li>

	<li class="bbp-topic-reply-count"><?php bbp_show_lead_topic() ? bbp_topic_reply_count() : bbp_topic_post_count(); ?></li>

	<li class="bbp-topic-freshness">
	
			<?php do_action( 'bbp_theme_before_topic_freshness_author' ); ?>
	
				<?php bbp_author_link( array( 'post_id' => bbp_get_topic_last_active_id(), 'type' => 'avatar', 'size' => 35 ) ); ?>
				
				<p class="bbp-topic-meta">
							
						<span class="bbp-topic-freshness-author"><?php bbp_author_link( array( 'post_id' => bbp_get_topic_last_active_id(), 'type' => 'name' ) ); ?></span>
					
						<?php do_action( 'bbp_theme_before_topic_freshness_link' ); ?>

							<span class="bbp-topic-freshness-link"><?php bbp_topic_freshness_link(); ?></span>
				
						<?php do_action( 'bbp_theme_after_topic_freshness_link' ); ?>
		
				</p>
			
			<?php do_action( 'bbp_theme_after_topic_freshness_author' ); ?>
		
	</li>

</ul><!-- #bbp-topic-<?php bbp_topic_id(); ?> -->
