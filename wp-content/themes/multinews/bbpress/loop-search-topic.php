<?php

/**
 * Search Loop - Single Topic
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<div class="bbp-topic-header">

	<div class="bbp-topic-title">

		<?php do_action( 'bbp_theme_before_topic_title' ); ?>

		<h3><?php _e( 'Topic: ', 'bbpress' ); ?><a class="mom-main-color" href="<?php bbp_topic_permalink(); ?>"><?php bbp_topic_title(); ?></a></h3>

		<div class="bbp-topic-title-meta">

			<?php if ( function_exists( 'bbp_is_forum_group_forum' ) && bbp_is_forum_group_forum( bbp_get_topic_forum_id() ) ) : ?>

				<?php _e( 'in group forum ', 'bbpress' ); ?>

			<?php else : ?>

				<?php _e( 'in forum ', 'bbpress' ); ?>

			<?php endif; ?>

			<a class="mom-main-color" href="<?php bbp_forum_permalink( bbp_get_topic_forum_id() ); ?>"><?php bbp_forum_title( bbp_get_topic_forum_id() ); ?></a>

		</div><!-- .bbp-topic-title-meta -->

		<?php do_action( 'bbp_theme_after_topic_title' ); ?>

	</div><!-- .bbp-topic-title -->

</div><!-- .bbp-topic-header -->

<div id="post-<?php bbp_topic_id(); ?>" <?php bbp_topic_class(); ?>>

	<div class="bbp-topic-author">

		<?php do_action( 'bbp_theme_before_topic_author_details' ); ?>

		<?php bbp_topic_author_link(  array( 'sep' => '', 'show_role' => false, 'type' => 'avatar', 'size' => 65 ) ); ?>

		<?php do_action( 'bbp_theme_after_topic_author_details' ); ?>

	</div><!-- .bbp-topic-author -->

	<div class="bbp-topic-content">

		<div class="mom-bbp-reply-author mom-main-font">
			<span class="mom-main-color"><?php bbp_topic_author_link( array( 'sep' => '', 'show_role' => false, 'type' => 'name' ) ); ?></span> <?php _e('on:','framework'); ?> <?php bbp_reply_post_date(); ?>
		<a href="<?php bbp_topic_permalink(); ?>" class="bbp-topic-permalink alignright">#<?php bbp_topic_id(); ?></a>
		</div>

		<?php do_action( 'bbp_theme_before_topic_content' ); ?>

		<?php bbp_topic_content(); ?>

		<?php do_action( 'bbp_theme_after_topic_content' ); ?>

	</div><!-- .bbp-topic-content -->
	

</div><!-- #post-<?php bbp_topic_id(); ?> -->
