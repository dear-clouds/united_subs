<?php do_action( 'bbp_template_before_replies_loop' ); ?>

<table id="topic-post-list" class="item-list" role="main">

<thead>
		<tr class="forum-head">
	
			<td class="forum-head-author"><?php  _e( 'Author',  'bbpress' ); ?></td>
			<td class="forum-head-reply">
				<?php _e( 'Posts', 'bbpress' ); ?> <div class="forum-head-reply-tools"><?php bbp_user_subscribe_link('before=&nbsp;'); ?> <?php bbp_user_favorites_link(); ?></div>
			</td>

		</tr>
</thead>

		<?php while ( bbp_replies() ) : bbp_the_reply(); ?>

			<?php bbp_get_template_part( 'loop', 'single-reply' ); ?>

		<?php endwhile; ?>

</table><!-- #topic-<?php bbp_topic_id(); ?>-replies -->

<?php do_action( 'bbp_template_after_replies_loop' ); ?>
