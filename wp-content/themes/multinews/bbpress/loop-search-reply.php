<?php

/**
 * Search Loop - Single Reply
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<div class="bbp-reply-header">
	<div class="bbp-reply-title">

		<h3><?php _e( 'In reply to: ', 'bbpress' ); ?>
		<a class="bbp-topic-permalink mom-main-color" href="<?php bbp_topic_permalink( bbp_get_reply_topic_id() ); ?>"><?php bbp_topic_title( bbp_get_reply_topic_id() ); ?></a></h3>

	</div><!-- .bbp-reply-title -->

</div><!-- .bbp-reply-header -->

<div id="post-<?php bbp_reply_id(); ?>" <?php bbp_reply_class(); ?>>

	<div class="bbp-reply-author">

		<?php do_action( 'bbp_theme_before_reply_author_details' ); ?>

		<?php bbp_reply_author_link( array( 'sep' => '', 'show_role' => false, 'type' => 'avatar', 'size' => 65 ) ); ?>

		<?php do_action( 'bbp_theme_after_reply_author_details' ); ?>

	</div><!-- .bbp-reply-author -->

	<div class="bbp-reply-content">
		<div class="mom-bbp-reply-author mom-main-font">
			<span class="mom-main-color"><?php bbp_reply_author_link( array( 'sep' => '', 'show_role' => false, 'type' => 'name' ) ); ?></span> <?php _e('on:','framework'); ?> <?php bbp_reply_post_date(); ?>
			<a href="<?php bbp_reply_url(); ?>" class="bbp-reply-permalink alignright">#<?php bbp_reply_id(); ?></a>
		</div>

		<?php do_action( 'bbp_theme_before_reply_content' ); ?>

		<?php bbp_reply_content(); ?>

		<?php do_action( 'bbp_theme_after_reply_content' ); ?>

	</div><!-- .bbp-reply-content -->

</div><!-- #post-<?php bbp_reply_id(); ?> -->

