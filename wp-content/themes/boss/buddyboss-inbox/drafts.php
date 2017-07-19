<?php
do_action('bp_before_member_messages_loop');
global $bp;
$user_compose_draft_ids = bbm_draft_user_compose_drafts();

if ( bp_has_message_threads(bp_ajax_querystring('messages') . 'drafts=true') || !empty($user_compose_draft_ids) ) :
    ?>

    <?php do_action('bp_before_member_messages_threads'); ?>

    <div id="messages-options-nav-drafts" class="messages-options-nav-drafts">
        <?php bbm_messages_options(); ?>
    </div><!-- .messages-options-nav -->

    <?php do_action('bp_after_member_messages_options'); ?>

    <div id="messages-table-wrap">
        <table id="message-threads" class="messages-notices drafts messages-table">
            <thead>
                <tr>
                    <th scope="col" class="thread-checkbox bulk-select-all"><input id="select-all-messages" type="checkbox"><strong></strong></th>
                    <th scope="col" class="thread-from"><?php _e( 'From', 'boss' ); ?></th>
                    <th scope="col" class="thread-info"><?php _e( 'Subject', 'boss' ); ?></th>

                    <?php

                    /**
                     * Fires inside the messages box table header to add a new column.
                     *
                     * This is to primarily add a <th> cell to the messages box table header. Use
                     * the related 'bp_messages_inbox_list_item' hook to add a <td> cell.
                     *
                     * @since 2.3.0
                     */
                    do_action( 'bp_messages_inbox_list_header' ); ?>

                    <th scope="col" class="thread-options"><?php _e( 'Actions', 'boss' ); ?></th>
                </tr>
            </thead>

            <tbody>
            <?php while (bp_message_threads()) : bp_message_thread(); ?>
                <?php $bbm_draft_id = bbm_draft_col_by_thread_id(bp_get_message_thread_id(), 'bbm_draft_id'); ?>
                <tr id="m-<?php bp_message_thread_id(); ?>" class="<?php bp_message_css_class(); ?><?php if (bp_message_thread_has_unread()) : ?> unread<?php else: ?> read<?php endif; ?>">
                    <td class="bulk-select-check">
                        <input type="checkbox" name="message_ids[]" id="bp-message-thread-<?php echo $bbm_draft_id; ?>" class="message-check" value="<?php echo $bbm_draft_id; ?>" />
                    </td>

                    <td class="thread-from">
                       <div class="wrap-message-avatar">
                        <?php bp_message_thread_avatar( array( 'width' => 50, 'height' => 50 ) ); ?>
                        </div>
                        
                        <div class="bb-thread-from-meta">
                            <span class="to"><?php _e('To:', 'boss'); ?></span>
                            <?php
                            $get_to = bp_get_message_thread_to();
                            if(!empty($get_to)){
                                bp_message_thread_to();
                            }else{
                                _e('Draft', 'boss');
                            }
                            ?>
                            <div class="activity">
                                <?php $draft_date = bbm_draft_col_by_thread_id(bp_get_message_thread_id(), 'draft_date'); ?>
                                <?php echo bbm_get_time_bp_format($draft_date); ?>
                            </div>
                        </div>
                    </td>

                    <td class="thread-info">
                        <p>
                            <a href="<?php bp_message_thread_view_link(); ?>" title="<?php esc_attr_e("View Message", "buddyboss-inbox"); ?>">
                                <?php
                                $get_subject = bp_get_message_thread_subject();
                                if(!empty($get_subject)){
                                    bp_message_thread_subject();
                                }else{
                                    _e('Draft', 'boss');
                                }
                                ?>
                            </a>
                        </p>
                        <p class="thread-excerpt">
                            <?php
                            $get_excerpt = bp_get_message_thread_excerpt();
                            if(!empty($get_excerpt)){
                                bp_message_thread_excerpt();
                            }else{
                                _e('Draft', 'boss');
                            }
                            ?>
                        </p>
                    </td>

                    <?php do_action('bp_messages_inbox_list_item'); ?>

                    <td class="thread-options">
                        <a class="delete" href="<?php echo bbm_draft_delete_link($bbm_draft_id); ?>" title="<?php esc_attr_e("Delete Message", "buddyboss-inbox"); ?>"><?php _e('Delete', 'boss'); ?></a>
                    </td>
                </tr>

            <?php endwhile; ?>

            <?php
            if(!empty($user_compose_draft_ids)):
                foreach($user_compose_draft_ids as $single):
                    $draft_detail = $single;
                    $recipient_user_id = bp_is_username_compatibility_mode()
                        ? bp_core_get_userid( $draft_detail->recipients )
                        : bp_core_get_userid_from_nicename( $draft_detail->recipients );

                    $draft_compose_url = trailingslashit(bp_displayed_user_domain() . $bp->messages->slug).'compose';
                    $draft_compose_url = esc_url(add_query_arg( 'draft_id', $draft_detail->bbm_draft_id, $draft_compose_url ));

                    ?>
                    <tr id="m-<?php bp_message_thread_id(); ?>" class="<?php bp_message_css_class(); ?><?php if (bp_message_thread_has_unread()) : ?> unread<?php else: ?> read<?php endif; ?>">

                        <td class="bulk-select-check">
                             <input type="checkbox" name="message_ids[]" id="bp-message-thread-<?php echo $bbm_draft_id; ?>" class="message-check" value="<?php echo $draft_detail->bbm_draft_id; ?>" />
                        </td>

                        <td class="thread-from">
                            <div class="wrap-message-avatar">
                                <?php echo get_avatar( $recipient_user_id, 50 ); ?>
                            </div>
                            
                            <div class="bb-thread-from-meta">
                                <span class="to"><?php _e( 'To:', 'boss' ); ?></span> 
                                <?php
                                $get_to = $draft_detail->recipients;
                                if(!empty($get_to)){
                                    echo !empty($recipient_user_id) ? bp_core_get_userlink( $recipient_user_id ) : $get_to;
                                }else{
                                    _e('Draft', 'boss');
                                }
                                ?>
                                <div class="activity"><?php echo bbm_get_time_bp_format($draft_detail->draft_date); ?></div>                
                            </div>
                        </td>

                        <td class="thread-info">
                            <p>
                                <a href="<?php echo $draft_compose_url; ?>" title="<?php esc_attr_e("View Message", "buddyboss-inbox"); ?>">
                                    <?php
                                    $get_subject = $draft_detail->draft_subject;
                                    if(!empty($get_subject)){
                                        echo $get_subject;
                                    }else{
                                        _e('Draft', 'boss');
                                    }
                                    ?>
                                </a>
                            </p>
                            <p class="thread-excerpt">
                                <?php
                                $get_excerpt = wp_trim_words($draft_detail->draft_content, 5);
                                if(!empty($get_excerpt)){
                                    echo $get_excerpt;
                                }else{
                                    _e('Draft', 'boss');
                                }
                                ?>
                            </p>
                        </td>

                        <?php do_action('bp_messages_inbox_list_item'); ?>

                       <td class="thread-options">
                            <a class="delete" href="<?php echo bbm_draft_delete_link($draft_detail->bbm_draft_id); ?>" title="<?php esc_attr_e("Delete Message", "buddyboss-inbox"); ?>"><?php _e('Delete', 'boss'); ?></a>
                        </td>
                    </tr>
                <?php
                endforeach;
            endif;
            ?>
            </tbody>
        </table><!-- #message-threads -->
    </div>

    <?php do_action('bp_after_member_messages_threads'); ?>

<?php else: ?>

    <div id="message" class="info">
        <p><?php _e('Sorry, no messages were found.', 'boss'); ?></p>
    </div>

<?php endif; ?>

<?php
do_action('bp_after_member_messages_loop');