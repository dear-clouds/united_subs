<?php do_action( 'bp_before_notices_loop' ) ?>

<?php if ( bp_has_message_threads() ) : ?>

	<div class="bp-pagination" id="user-pag">
		<div class="pag-count" id="messages-dir-count">
			<?php bp_messages_pagination_count() ?>
		</div>
		<div class="pagination-links" id="messages-dir-pag">
			<?php bp_messages_pagination() ?>
		</div>
	</div><!-- .pagination -->

	<?php do_action( 'bp_after_notices_pagination' ) ?>
	<?php do_action( 'bp_before_notices' ) ?>

	<table id="message-threads" class="notice-threads">
		<?php while ( bp_message_threads() ) : bp_message_thread(); ?>
			<tr>
				<td width="43%">
					<div><strong><?php bp_message_is_active_notice() ?></strong></div>
					<div class="m-activity m-date"><?php _e("Sent:", "buddypress"); ?> <?php bp_message_notice_post_date() ?></div>
					
					<div class="hr"></div>
					
					<h4><strong><?php bp_message_notice_subject() ?></strong></h4>
					<?php bp_message_notice_text() ?>
				</td>

				<?php do_action( 'bp_notices_list_item' ) ?>

				<td width="1%">
					<a class="button btn small confirm" href="<?php bp_message_activate_deactivate_link() ?>"><span><?php bp_message_activate_deactivate_text() ?></span></a>
				</td>
				<td width="1%">
					<a class="button btn small confirm" href="<?php bp_message_notice_delete_link() ?>" title="<?php echo __( "Delete Message", "buddypress" ) ?>"><span><?php echo __( "Delete", "buddypress" ) ?></span></a>
				</td>
			</tr>
		<?php endwhile; ?>
	</table><!-- #message-threads -->

	<?php do_action( 'bp_after_notices' ) ?>

<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( 'Sorry, no notices were found.', 'buddypress' ); ?></p>
	</div>

<?php endif;?>

<?php do_action( 'bp_after_notices_loop' ) ?>