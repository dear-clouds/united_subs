<form action="" method="post" id="notifications-bulk-management">
  <table id="message-threads">
      <tbody>
          <?php while ( bp_the_notifications() ) : bp_the_notification(); ?>
                    <tr class="unread">
                        <td></td>
                        <td class="bulk-select-check"><input id="<?php bp_the_notification_id(); ?>" type="checkbox" name="notifications[]" value="<?php bp_the_notification_id(); ?>" class="notification-check"></td>
                        <td><?php bp_the_notification_description();  ?></td>
                        <td><?php bp_the_notification_time_since();   ?></td>
                        <td>
                            <td width="1%" class="thread-options">
                                <a class="button btn small" title="<?php echo __( "Read Notification", "buddypress" ); ?>" <?php echo bp_get_the_notification_mark_link(); ?> </a>
                            </td>        
                            <td width="1%" class="thread-options">
                                <a class="button btn small confirm" title="<?php echo __( "Delete Notification", "buddypress" ); ?>" <?php echo bp_get_the_notification_delete_link(); ?></a>
                            </td>
                       </td>
                    </tr>
          <?php endwhile; ?>
      </tbody>
  </table>

  <div class="messages-options-nav">
    <?php bp_notifications_bulk_management_dropdown(); ?>
  </div>

  <?php wp_nonce_field( 'notifications_bulk_nonce', 'notifications_bulk_nonce' ); ?>  
</form>
