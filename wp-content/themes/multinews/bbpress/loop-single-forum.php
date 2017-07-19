<?php

/**
 * Forums Loop - Single Forum
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<ul id="bbp-forum-<?php bbp_forum_id(); ?>" <?php bbp_forum_class(); ?>>

	<li class="bbp-forum-info">

		<?php if ( bbp_is_user_home() && bbp_is_subscriptions() ) : ?>

			<span class="bbp-row-actions">

				<?php do_action( 'bbp_theme_before_forum_subscription_action' ); ?>

				<?php bbp_forum_subscription_link( array( 'before' => '', 'subscribe' => '+', 'unsubscribe' => '&times;' ) ); ?>

				<?php do_action( 'bbp_theme_after_forum_subscription_action' ); ?>

			</span>

		<?php endif; ?>

		<?php do_action( 'bbp_theme_before_forum_title' ); ?>

		<a class="bbp-forum-title" href="<?php bbp_forum_permalink(); ?>"><?php bbp_forum_title(); ?></a>

		<?php do_action( 'bbp_theme_after_forum_title' ); ?>

		<?php do_action( 'bbp_theme_before_forum_description' ); ?>

		<div class="bbp-forum-content"><?php bbp_forum_content(); ?></div>

		<?php do_action( 'bbp_theme_after_forum_description' ); ?>

		<?php do_action( 'bbp_theme_before_forum_sub_forums' ); ?>

		<?php bbp_list_forums(); ?>

		<?php do_action( 'bbp_theme_after_forum_sub_forums' ); ?>

		<?php bbp_forum_row_actions(); ?>

	</li>

	<li class="bbp-forum-topic-count">
		<div><span class="mom-main-color"><?php bbp_forum_topic_count(); ?></span> <?php _e('Topics', 'framework'); ?></div>
		<div><span class="mom-main-color"><?php bbp_show_lead_topic() ? bbp_forum_reply_count() : bbp_forum_post_count(); ?></span> <?php _e('Posts', 'framework'); ?></div>
	</li>


	<li class="bbp-forum-freshness">
		<p class="bbp-topic-meta">

			<?php
				if (class_exists('userpro_api')) {
					/* Integrating UserPro */
					global $userpro;
					$link = preg_replace("/(?<=href=(\"|'))[^\"']+(?=(\"|'))/", $userpro->permalink(  bbp_get_topic_author_id( bbp_get_forum_last_active_id() ) ), bbp_get_author_link( array( 'post_id' => bbp_get_forum_last_active_id(), 'size' => 47 ) ) );
					
				} else {
					$link = bbp_get_author_link( array( 'post_id' => bbp_get_forum_last_active_id(), 'size' => 47 ) );
				}
			?>
			<span class="bbp-topic-freshness-author"><?php echo $link; ?></span>

			<?php do_action( 'bbp_theme_after_topic_author' ); ?>

		</p>

		<?php do_action( 'bbp_theme_before_forum_freshness_link' ); ?>

		<?php bbp_forum_freshness_link(); ?>

		<?php do_action( 'bbp_theme_after_forum_freshness_link' ); ?>

	</li>

</ul><!-- #bbp-forum-<?php bbp_forum_id(); ?> -->
