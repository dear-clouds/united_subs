<tr>

	<td class="post-author-cell">
	<div class="post-author"><?php do_action( 'bbp_theme_before_reply_author_details' ); ?>
		<?php bbp_reply_author_link( array( 'show_role' => true, 'size' => 75 ) ); ?>
		<?php if ( bbp_is_user_keymaster() ) : ?>

			<?php do_action( 'bbp_theme_before_reply_author_admin_details' ); ?>

			<div class="bbp-reply-ip"><?php bbp_author_ip( bbp_get_reply_id() ); ?></div>

			<?php do_action( 'bbp_theme_after_reply_author_admin_details' ); ?>

		<?php endif; ?>

		<?php do_action( 'bbp_theme_after_reply_author_details' ); ?>
	</div>
	</td>
	
	<td class="topic-content-cell">
	<div class="topic-content">
	<p class="topic-meta"><a href="<?php bbp_reply_url(); ?>" title="<?php bbp_reply_title(); ?>"><?php bbp_reply_post_date(); ?></a>
			<?php if ( bbp_is_single_user_replies() ) : ?>
				<?php _e( 'in reply to: ', 'bbpress' ); ?>
				<a class="bbp-topic-permalink" href="<?php bbp_topic_permalink( bbp_get_reply_topic_id() ); ?>" title="<?php bbp_topic_title( bbp_get_reply_topic_id() ); ?>"><?php bbp_topic_title( bbp_get_reply_topic_id() ); ?></a>
			<?php endif; ?>
	</p>
	<?php do_action( 'bbp_theme_before_reply_content' ); ?>	
	
	<div class="bbp-reply-title">
	
		<?php _e( 'In reply to: ', 'bbpress' ); ?>
		<a class="bbp-topic-permalink" href="<?php bbp_topic_permalink( bbp_get_reply_topic_id() ); ?>" title="<?php bbp_topic_title( bbp_get_reply_topic_id() ); ?>"><?php bbp_topic_title( bbp_get_reply_topic_id() ); ?></a>
	
	</div><!-- .bbp-reply-title -->
	
	<?php bbp_reply_content(); ?>

	<?php do_action( 'bbp_theme_after_reply_content' ); ?>

			<div class="admin-links">
					<?php do_action( 'bbp_theme_before_reply_admin_links' ); ?>			
					<?php bbp_reply_admin_links(); ?>			
					<?php do_action( 'bbp_theme_after_reply_admin_links' ); ?>

				<?php do_action( 'bp_group_forum_post_meta' ); ?>
			</div>	
	</div>
	</td>

</tr>