<?php

/* Buddypress Notifications in menu item */
add_filter('kleo_nav_menu_items', 'kleo_add_notifications_nav_item' );
function kleo_add_notifications_nav_item( $menu_items ) {
  $menu_items[] = array(
    'name' => __( 'Live Notifications', 'kleo_framework' ),
    'slug' => 'notifications',
    'link' => '#',
  );

  return $menu_items;
}

/* Localize refresh interval to JavaScript app.js */
add_filter( 'kleo_localize_app', 'kleo_bp_notif_refresh_int' );
function kleo_bp_notif_refresh_int( $data ) {
    $data['bpNotificationsRefresh'] = sq_option( 'bp_notif_interval', 20000 );

    return $data;
}


add_filter('kleo_setup_nav_item_notifications' , 'kleo_setup_notifications_nav');
function kleo_setup_notifications_nav( $menu_item ) {
    $menu_item->classes[] = 'kleo-toggle-menu';
    if ( ! is_user_logged_in() ) {
        $menu_item->_invalid = true;
    } else {
        add_filter( 'walker_nav_menu_start_el_notifications', 'kleo_menu_notifications', 10, 4 );
    }

    return $menu_item;
}

function kleo_bp_mobile_notify() {
    global $kleo_config;

    $output = '';
    $url = bp_loggedin_user_domain() . BP_NOTIFICATIONS_SLUG;
    $notifications = bp_notifications_get_notifications_for_user( bp_loggedin_user_id(), 'object' );
    $count         = ! empty( $notifications ) ? count( $notifications ) : 0;

    if ($count > 0 ) {
        $alert = 'new-alert';
    } else {
        $alert = 'no-alert';
    }

    if ( isset( $kleo_config['mobile_notify_icon'] ) ) {
        $icon = $kleo_config['mobile_notify_icon'];
    } else {
        $icon = 'mail-2';
    }

    $title = '<span class="notify-items"><i class="icon-' . $icon . '"></i> <span class="kleo-notifications ' . $alert . '">' . $count . '</span></span>';
    $output .= '<a title="' . __( 'View Notifications', 'kleo_framework' ) . '" class="notify-contents" href="' . $url .'">' . $title . '</a>';
    echo $output;
}

function kleo_menu_notifications( $item_output, $item, $depth, $args ) {
    global $kleo_config;

    $output = '';
    $url = bp_loggedin_user_domain() . BP_NOTIFICATIONS_SLUG;
    $notifications = bp_notifications_get_notifications_for_user( bp_loggedin_user_id(), 'object' );
    $count         = ! empty( $notifications ) ? count( $notifications ) : 0;

    if ( $count > 0 ) {
      $alert = 'new-alert';
      $status = ' has-notif';
    } else {
      $alert = 'no-alert';
      $status = '';
    }
    $attr_title = strip_tags( $item->attr_title );

    if (isset( $item->icon ) && $item->icon != '') {

        $kleo_config['mobile_notify_icon'] = $item->icon;

        $title_icon = '<i class="icon-' . $item->icon . '"></i>';

        if ( $item->iconpos == 'after' ) {
            $title = $item->title . ' ' . $title_icon;
        }
        elseif ( $item->iconpos == 'icon' ) {
            $title = $title_icon;
        }
        else {
            $title = $title_icon . ' ' . $item->title;
        }

        //If we have the menu item then add it to the mobile menu
        add_action( 'kleo_mobile_header_icons', 'kleo_bp_mobile_notify', 9 );
    }
    else {
        $title = $item->title;
    }

    $output .= '<a class="notify-contents" href="' . $url . '" title="' . $attr_title .'">'
        . '<span class="notify-items"> ' . $title . ' <span class="kleo-notifications ' . $alert . '">' . $count . '</span></span>'
        . '</a>';

    $output .= '<div class="kleo-toggle-submenu"><ul class="submenu-inner' . $status . '">';

    if ( !empty( $notifications ) ) {
        foreach ( (array)$notifications as $notification ) {
          $output .='<li class="kleo-submenu-item" id="kleo-notification-' . $notification->id . '">';
          $output .='<a href="' . $notification->href . '">' . $notification->content . '</a>';
          //$output .= '<a data-id="' . $notification->id . '" title="' . __( 'Mark as read', 'kleo_framework' ) . '" class="remove" href="#">×</a>';
          $output .='</li>';
        }
    }
    else {
        $output .= '<li class="kleo-submenu-item">' . __( 'No new notifications' , 'kleo_framework' ) . '</li>';
    }

    $output .= '</ul>';
    if ( !empty( $notifications ) ) {
        $style = '';
    } else {
        $style = ' style="display: none;"';
    }
    $output .= '<div class="minicart-buttons text-center"' . $style . '><a class="btn btn-default mark-as-read" href="#">' . __( 'Mark all as read', 'kleo_framework' ) . '</a></div>';

    $output .= '</div>';

    return $output;
}


/* Mark notfications as read by AJAX */
add_action('wp_ajax_kleo_bp_notification_mark_read', 'kleo_bp_notification_mark_read');

function kleo_bp_notification_mark_read() {
  $response = array();

  if ( BP_Notifications_Notification::mark_all_for_user( bp_loggedin_user_id() ) ) {
    $response['status'] = 'success';
  }
  else {
    $response['status'] = 'failure';
  }

  $notifications = bp_notifications_get_notifications_for_user( bp_loggedin_user_id(), 'object' );
  $count         = ! empty( $notifications ) ? count( $notifications ) : 0;
  $response['count']  = $count;
  $response['empty']  = '<li class="kleo-submenu-item">' . __( 'No new notifications' , 'kleo_framework' ) . '</li>';

  echo json_encode( $response );
  exit;
}


/* Refresh notfications by AJAX */
add_action('wp_ajax_kleo_bp_notifications_refresh', 'kleo_bp_notifications_refresh');

function kleo_bp_notifications_refresh() {
  $response = array();
  
  if ( ! isset( $_GET['current'] ) ) {
    $response['status'] = 'failure';
    echo json_encode( $response );
    exit;
  }
  
  $old_count = (int) $_GET['current'];
  
  $notifications = bp_notifications_get_notifications_for_user( bp_loggedin_user_id(), 'object' );
  $count         = ! empty( $notifications ) ? count( $notifications ) : 0;

  if ( $count == $old_count ) {
    $response['status'] = 'no_change';
    echo json_encode( $response );
    exit;
  }
  
  $output = '';

  if ( !empty( $notifications ) ) {
    foreach ( (array)$notifications as $notification ) {
      $output .='<li class="kleo-submenu-item" id="kleo-notification-' . $notification->id . '">';
      $output .='<a href="' . $notification->href . '">' . $notification->content . '</a>';
      $output .='</li>';
    }
  } else {
    $output .= '<li class="kleo-submenu-item">' . __( 'No new notifications' , 'kleo_framework' ) . '</li>';
  }
  $response['data'] = $output;
  $response['count']  = $count;
  $response['status']  = 'success';
  
  echo json_encode( $response );
  exit;
}
