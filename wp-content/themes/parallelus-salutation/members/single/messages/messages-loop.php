<?php do_action( 'bp_before_member_messages_loop' ) ?>

<?php $search_terms = (isset($_COOKIE['bp-messages-search-terms']) && !empty($_COOKIE['bp-messages-search-terms']))? $_COOKIE['bp-messages-search-terms'] : ''; ?>

<?php if ( bp_has_message_threads( array('search_terms' => $search_terms ) ) ) : ?>

	<div class="no-ajax bp-pagination" id="user-pag">
		<div class="pag-count" id="messages-dir-count">
			<?php bp_messages_pagination_count() ?>
		</div>
		<div class="pagination-links" id="messages-dir-pag">
			<?php bp_messages_pagination() ?>
		</div>
	</div><!-- .pagination -->

	<?php do_action( 'bp_after_member_messages_pagination' ) ?>
	<?php do_action( 'bp_before_member_messages_threads' ) ?>

	<table id="message-threads">
		<?php while ( bp_message_threads() ) : bp_message_thread(); ?>

			<tr id="m-<?php bp_message_thread_id() ?>"<?php if ( bp_message_thread_has_unread() ) : ?> class="unread"<?php else: ?> class="read"<?php endif; ?>>
				<td width="1%" class="thread-select"><input type="checkbox" name="message_ids[]" value="<?php bp_message_thread_id() ?>" /></td>
				<!--td width="1%" class="thread-count">
					<span class="unread-count"><?php bp_message_thread_unread_count() ?></span>
				</td-->
				<td width="1%" class="thread-avatar"><?php 
					// get the avatar image
					// $avatarURL = bp_theme_avatar_url(32,32,'',bp_core_fetch_avatar(array( 'item_id' => $GLOBALS['messages_template']->thread->last_sender_id, 'type' => 'full', 'html' => 'false', 'width' => 32, 'height' => 32 )));
					// echo '<div class="avatar" style="background-image: url(\''.$avatarURL.'\'); width:32px; height:32px; "></div>';
					bp_message_thread_avatar( 'type=thumb' );
				?></td>

				<?php if ( 'sentbox' != bp_current_action() ) : ?>
					<td width="17%" class="thread-from">
						<div class="m-sender"><span class="m-from"><?php _e( 'From:', 'buddypress' ); ?></span> <span class="m-email"><?php bp_message_thread_from() ?></span></div>
						<span class="m-activity m-date"><?php bp_message_thread_last_post_date() ?></span>
					</td>
				<?php else: ?>
					<td width="17%" class="thread-from">
						<div class="m-recipient"><span class="m-to"><?php _e( 'To:', 'buddypress' ); ?></span> <span class="m-email"><?php bp_message_thread_to() ?></span></div>
						<span class="m-activity m-date"><?php bp_message_thread_last_post_date() ?></span>
					</td>
				<?php endif; ?>

				<td class="thread-info">
					<div class="m-subject"><a href="<?php bp_message_thread_view_link() ?>" title="<?php _e( "View Message", "buddypress" ); ?>"><?php bp_message_thread_subject() ?></a></div>
					<div class="thread-excerpt"><?php bp_message_thread_excerpt() ?></div>
				</td>

				<?php do_action( 'bp_messages_inbox_list_item' ) ?>
					<td width="1%">
						<?php if ( bp_is_active( 'messages', 'star' ) ) : ?>
							<span class="thread-star">
								<?php bp_the_message_star_action_link( array( 'thread_id' => bp_get_message_thread_id() ) ); ?>
							</span>
						<?php endif; ?>
					</td>
				<td width="1%" class="thread-options">
					<a class="button btn small confirm" href="<?php bp_message_thread_delete_link() ?>" title="<?php _e( "Delete Message", "buddypress" ); ?>"><span><?php _e( "Delete", "buddypress" ); ?></span></a>
				</td>
			</tr>

		<?php endwhile; ?>
	</table><!-- #message-threads -->

	<div class="no-ajax bp-pagination" id="user-pag">
		<div class="pag-count" id="messages-dir-count">
			<?php bp_messages_pagination_count() ?>
		</div>
		<div class="pagination-links" id="messages-dir-pag">
			<?php bp_messages_pagination() ?>
		</div>
	</div><!-- .pagination -->

	<div class="messages-options-nav">
		<?php 
		// BP is so lame! The cre creates this menu manually in a function and includes spaces between the links.
		// The only way to remove them is re-write the function, or use output buffering and strip them with find/replace. 
		// Argggggg!@!!#
		
		// turn on output buffering to capture the code
		ob_start(); 
		bp_messages_options();
		
		// get the content that has been output
		$content = ob_get_clean();
		
		echo str_replace(array(' &nbsp;', '&nbsp;', '&nbsp; '), '', $content);
		
		?>
	</div><!-- .messages-options-nav -->

	<?php do_action( 'bp_after_member_messages_threads' ) ?>

	<?php do_action( 'bp_after_member_messages_options' ) ?>

<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( 'Sorry, no messages were found.', 'buddypress' ); ?></p>
	</div>

<?php endif;?>

<?php do_action( 'bp_after_member_messages_loop' ) ?>