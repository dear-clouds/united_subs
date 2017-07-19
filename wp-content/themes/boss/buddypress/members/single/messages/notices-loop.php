<?php do_action( 'bp_before_notices_loop' ); ?>

<?php if ( bp_has_message_threads() ) : ?>

	<?php do_action( 'bp_before_notices' ); ?>
    <div id="messages-table-wrap">
        <table id="message-threads" class="messages-notices notices-table">
            <?php while ( bp_message_threads() ) : bp_message_thread(); ?>
                <tr id="notice-<?php bp_message_notice_id(); ?>" class="<?php bp_message_css_class(); ?>">
                    <td width="1%"></td>
                    <td width="38%">
                        <strong><?php bp_message_notice_subject(); ?></strong>
                        <?php bp_message_notice_text(); ?>
                    </td>
                    <td width="21%">
    
                        <?php if ( bp_messages_is_active_notice() ) : ?>
    
                            <strong><?php bp_messages_is_active_notice(); ?></strong>
    
                        <?php endif; ?>
    
                        <span class="activity"><?php _e( 'Sent:', 'boss' ); ?> <?php bp_message_notice_post_date(); ?></span>
                    </td>
    
                    <?php do_action( 'bp_notices_list_item' ); ?>
    
                    <td width="10%">
                        <a class="button" href="<?php bp_message_activate_deactivate_link(); ?>" class="confirm"><?php bp_message_activate_deactivate_text(); ?></a>
                        <a class="button" href="<?php bp_message_notice_delete_link(); ?>" class="confirm" title="<?php esc_attr_e( "Delete Message", "boss" ); ?>"><?php _e( 'Delete', 'boss' ); ?></a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table><!-- #message-threads -->
    </div>
    <!-- /#notices-table-wrap -->

	<?php do_action( 'bp_after_notices' ); ?>
	
    <div class="pagination no-ajax" id="user-pag">

		<div class="pag-count" id="messages-dir-count">
			<?php bp_messages_pagination_count(); ?>
		</div>

		<div class="pagination-links" id="messages-dir-pag">
			<?php bp_messages_pagination(); ?>
		</div>

	</div><!-- .pagination -->

	<?php do_action( 'bp_after_notices_pagination' ); ?>

<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( 'Sorry, no notices were found.', 'boss' ); ?></p>
	</div>

<?php endif;?>

<?php do_action( 'bp_after_notices_loop' ); ?>