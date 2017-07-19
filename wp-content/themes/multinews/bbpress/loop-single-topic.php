<?php

/**
 * Topics Loop - Single
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<ul id="bbp-topic-<?php bbp_topic_id(); ?>" <?php bbp_topic_class(); ?>>

	<li class="mom-bbp-topic-data">
	<span class="mom-bbp-topic-avatar"><?php echo get_avatar( bbp_get_topic_author_id(), 65 ); ?></span>
		<?php if ( bbp_is_user_home() ) : ?>

			<?php if ( bbp_is_favorites() ) : ?>

				<span class="bbp-row-actions">

					<?php do_action( 'bbp_theme_before_topic_favorites_action' ); ?>

					<?php bbp_topic_favorite_link( array( 'before' => '', 'favorite' => '+', 'favorited' => '&times;' ) ); ?>

					<?php do_action( 'bbp_theme_after_topic_favorites_action' ); ?>

				</span>

			<?php elseif ( bbp_is_subscriptions() ) : ?>

				<span class="bbp-row-actions">

					<?php do_action( 'bbp_theme_before_topic_subscription_action' ); ?>

					<?php bbp_topic_subscription_link( array( 'before' => '', 'subscribe' => '+', 'unsubscribe' => '&times;' ) ); ?>

					<?php do_action( 'bbp_theme_after_topic_subscription_action' ); ?>

				</span>

			<?php endif; ?>

		<?php endif; ?>

		<?php do_action( 'bbp_theme_before_topic_title' ); ?>

		<a class="bbp-topic-permalink" href="<?php bbp_topic_permalink(); ?>"><?php bbp_topic_title(); ?></a>

		<?php do_action( 'bbp_theme_after_topic_title' ); ?>

		<?php bbp_topic_pagination(); ?>

		<?php do_action( 'bbp_theme_before_topic_meta' ); ?>

		<p class="bbp-topic-meta">

			<?php do_action( 'bbp_theme_before_topic_started_by' ); ?>

			<span class="bbp-topic-started-by">
			<?php 
			if (class_exists('userpro_api')) {
			/* Integrating UserPro */
			global $userpro;
			$link = preg_replace("/(?<=href=(\"|'))[^\"']+(?=(\"|'))/", $userpro->permalink( bbp_get_topic_author_id() ), 
			bbp_get_topic_author_link( array( 'type' => 'name' ) ) );
			} else {
			printf( __( 'Started by: %1$s', 'bbpress' ), bbp_get_topic_author_link( array( 'type' => 'name' ) ) ); 
			}
			?>
			</span>

			<?php do_action( 'bbp_theme_after_topic_started_by' ); ?>

			<?php if ( !bbp_is_single_forum() || ( bbp_get_topic_forum_id() !== bbp_get_forum_id() ) ) : ?>

				<?php do_action( 'bbp_theme_before_topic_started_in' ); ?>

				<span class="bbp-topic-started-in"><?php printf( __( 'in: <a href="%1$s">%2$s</a>', 'bbpress' ), bbp_get_forum_permalink( bbp_get_topic_forum_id() ), bbp_get_forum_title( bbp_get_topic_forum_id() ) ); ?></span>

				<?php do_action( 'bbp_theme_after_topic_started_in' ); ?>

			<?php endif; ?>

		</p>
		<p class="bbp-topic-meta">
		<span><?php _e( 'Last post: ', 'framework' ); ?></span>
		<?php do_action( 'bbp_theme_after_topic_meta' ); ?>
			<?php do_action( 'bbp_theme_before_topic_freshness_author' ); ?>

			<span class="bbp-topic-freshness-author">
			<?php 
			if (class_exists('userpro_api')) {
				global $userpro;
				$link = preg_replace("/(?<=href=(\"|'))[^\"']+(?=(\"|'))/", $userpro->permalink(  bbp_get_topic_author_id( bbp_get_topic_last_active_id() ) ), bbp_get_author_link( array( 'post_id' => bbp_get_topic_last_active_id(), 'size' => 30 ) ) );
			} else {
			bbp_author_link( array( 'post_id' => bbp_get_topic_last_active_id(), 'type' => 'name' ) );
			} 
			?>
			</span> - 

			<?php do_action( 'bbp_theme_after_topic_freshness_author' ); ?>

		<?php do_action( 'bbp_theme_before_topic_freshness_link' ); ?>

		<?php bbp_topic_freshness_link(); ?>

		<?php do_action( 'bbp_theme_after_topic_freshness_link' ); ?>



		</p>
		<?php bbp_topic_row_actions(); ?>

	</li>

	<li class="mom-bbp-topic-counts">
		<div><span class="mom-main-color"><?php bbp_topic_voice_count(); ?></span> <?php _e('Voices', 'framework'); ?></div>
		<div><span class="mom-main-color"><?php bbp_show_lead_topic() ? bbp_topic_reply_count() : bbp_topic_post_count(); ?></span> <?php _e('Posts', 'framework'); ?></div>
	</li>



</ul><!-- #bbp-topic-<?php bbp_topic_id(); ?> -->
