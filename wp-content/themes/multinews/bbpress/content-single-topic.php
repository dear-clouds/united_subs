<?php

/**
 * Single Topic Content Part
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<div id="bbpress-forums">

	<?php do_action( 'bbp_template_before_single_topic' ); ?>

	<?php if ( post_password_required() ) : ?>

		<?php bbp_get_template_part( 'form', 'protected' ); ?>

	<?php else : ?>

	<h1 class="mom-bbp-title mom-main-color"><?php the_title(); ?></h1>
<div id="post-<?php bbp_reply_id(); ?>" class="bbp-reply-header">
	<div class="mom-main-font">
		<?php _e('Posted In:','framework'); ?>
		<span class="mom-main-color"><?php  echo get_the_title($post->post_parent); ?></span>

	</div>
</div><!-- #post-<?php bbp_reply_id(); ?> -->
		<?php if ( bbp_show_lead_topic() ) : ?>

			<?php bbp_get_template_part( 'content', 'single-topic-lead' ); ?>

		<?php endif; ?>

		<?php if ( bbp_has_replies() ) : ?>
			<?php bbp_get_template_part( 'loop',       'replies' ); ?>

			<?php bbp_get_template_part( 'pagination', 'replies' ); ?>

		<?php endif; ?>

		<?php bbp_get_template_part( 'form', 'reply' ); ?>

	<?php endif; ?>

	<?php do_action( 'bbp_template_after_single_topic' ); ?>

</div>
