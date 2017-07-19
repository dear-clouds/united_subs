<?php

/**
 * Fires before the members messages loop.
 *
 * @since BuddyPress (1.2.0)
 */
do_action( 'bp_before_member_messages_loop' ); ?>

<?php if ( bp_has_message_threads( bp_ajax_querystring( 'messages' ) ) ) : ?>

	<div class="pagination no-ajax" id="user-pag">

		<div class="pag-count" id="messages-dir-count">
			<?php bp_messages_pagination_count(); ?>
		</div>

		<div class="pagination-links" id="messages-dir-pag">
			<?php bp_messages_pagination(); ?>
		</div>

	</div><!-- .pagination -->

    <?php

    /**
     * Fires after the members messages pagination display.
     *
     * @since BuddyPress (1.2.0)
     */
    do_action( 'bp_after_member_messages_pagination' ); ?>

    <?php

    /**
     * Fires before the members messages threads.
     *
     * @since BuddyPress (1.2.0)
     */
    do_action( 'bp_before_member_messages_threads' ); ?>

    <form action="<?php echo bp_loggedin_user_domain() . bp_get_messages_slug() . '/' . bp_current_action() ?>/bulk-manage/" method="post" id="messages-bulk-management">

        <div id="message-threads" class="messages-notices">

            <?php while ( bp_message_threads() ) : bp_message_thread(); ?>

                <ul class="mesage-item animated animate-when-almost-visible bottom-to-top">
                    <li id="m-<?php bp_message_thread_id(); ?>"
                        class="<?php bp_message_css_class(); ?><?php if (bp_message_thread_has_unread()) : ?> unread<?php else: ?> read<?php endif; ?>">
                        <label class="mark-item bulk-select-check">
                            <input type="checkbox" name="message_ids[]" value="<?php bp_message_thread_id(); ?>"
                                   class="checkbox-cb"/><span class="checkbox-mark"></span>
                        </label>

                        <div class="thread-count"><span
                                class="unread-count"><?php bp_message_thread_unread_count(); ?></span></div>
                        <div class="thread-avatar rounded"><?php bp_message_thread_avatar(); ?></div>

                        <?php if ('sentbox' != bp_current_action()) : ?>
                            <span class="thread-post-date"><?php bp_message_thread_last_post_date(); ?></span>
                            <div class="thread-from">
                                <?php _e('From:', 'buddypress'); ?> <?php bp_message_thread_from(); ?>

                            </div>

                        <?php else: ?>
                            <span class="thread-post-date"><?php bp_message_thread_last_post_date(); ?></span>
                            <div class="thread-from">
                                <?php _e('To:', 'buddypress'); ?> <?php bp_message_thread_to(); ?>

                            </div>
                        <?php endif; ?>

                        <div class="thread-info">
                            <p><a href="<?php bp_message_thread_view_link(); ?>"
                                  title="<?php esc_attr_e("View Message", "buddypress"); ?>"><?php bp_message_thread_subject(); ?></a>
                            </p>

                            <p class="thread-excerpt"><?php bp_message_thread_excerpt(); ?></p>
                        </div>

                        <?php

                        /**
                         * Fires inside the messages box table row to add a new column.
                         *
                         * This is to primarily add a <td> cell to the message box table. Use the
                         * related 'bp_messages_inbox_list_header' hook to add a <th> header cell.
                         *
                         * @since BuddyPress (1.1.0)
                         */
                        do_action('bp_messages_inbox_list_item'); ?>

                        <div class="thread-options">

                            <a class="button confirm" href="<?php bp_message_thread_delete_link(); ?>"
                               title="<?php _e("Delete Message", "buddypress"); ?>"><?php _e('Delete', 'buddypress'); ?></a>
                            &nbsp;
                            <?php if ( version_compare( BP_VERSION, '2.3', '>=' ) ) :  ?>
                                <?php if (bp_is_active('messages', 'star')) : ?>
                                    <div class="thread-star">
                                       <?php bp_the_message_star_action_link(array('thread_id' => bp_get_message_thread_id())); ?>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                        </div>

                    </li>
                </ul>
            <?php endwhile; ?>
        </div>


        <div class="messages-options-nav">
            <?php bp_messages_bulk_management_dropdown(); ?>
		</div><!-- .messages-options-nav -->

		<?php wp_nonce_field( 'messages_bulk_nonce', 'messages_bulk_nonce' ); ?>
    </form>

    <?php

    /**
     * Fires after the members messages threads.
     *
     * @since BuddyPress (1.2.0)
     */
    do_action( 'bp_after_member_messages_threads' ); ?>

    <?php

    /**
     * Fires and displays member messages options.
     *
     * @since BuddyPress (1.2.0)
     */
    do_action( 'bp_after_member_messages_options' ); ?>

<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( 'Sorry, no messages were found.', 'buddypress' ); ?></p>
	</div>

<?php endif;?>

    <?php

    /**
     * Fires after the members messages loop.
     *
     * @since BuddyPress (1.2.0)
     */
    do_action( 'bp_after_member_messages_loop' ); ?>
