<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }

/**
 * XPROFILE DATA TABLE'S NAME
 *
 * It's used in the extensions as well and if it doesn't work it can create
 * a loop over the fields, so you'll have thousands of fields
 * You can make the change here, if you're on multisite and it's not working
 *
 * @return string : the table name in the database
 */
if(!function_exists('woffice_profile_calendar_content')) {
	function woffice_get_xprofile_table($type = null)
	{
		if ($type == "fields") {
			$table = 'bp_xprofile_fields';
		}
		else {
			$table = 'bp_xprofile_groups';
		}
		global $wpdb;
		// We check for multisite :
		if (is_multisite() && is_main_site()) {
			$table_name = $wpdb->base_prefix . $table;
		} else {
			$table_name = $wpdb->prefix . $table;
		}

		return $table_name;
	}
}

/**
* Display members filter in the member directory
*
* @return string
*/
if(!function_exists('woffice_members_filter')) {
    function woffice_members_filter() {
        /*We check first to display it or not */
        $buddy_filter = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('buddy_filter') : '';
        if ($buddy_filter == "show") {

            echo'<div id="woffice-members-filter" class="dropdown">';
            global $wp;
            $current_url = home_url(add_query_arg(array(),$wp->request));
            echo'<form id="woffice-members-filter-form" action="'.esc_url($current_url).'" method="get">';
            echo'<input type="hidden" name="filterRole" id="filterRole">';
            echo'<button id="woffice-members-filter-btn" type="button" class="btn btn-default" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            echo'<i class="fa fa-users"></i>';
            _e("Select Members","woffice");
            echo'<i class="fa fa-caret-down"></i>';
            echo'</button>';
            echo'<ul class="dropdown-menu" role="menu">';
            echo'<li><a href="javascript:void(0)" data-role="0">'.esc_html__('All members', 'woffice').'</a></li>';
            global $wp_roles;
            $buddy_excluded_directory = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('buddy_excluded_directory') : '';
            foreach ($wp_roles->roles as $key=>$value):
                if (substr($key, 0, 4) != 'bbp_' && !in_array($key, $buddy_excluded_directory)){
					$value['name'] = ($value['name'] == "Administrator") ? "Administrateur" : $value['name'];

                    echo'<li><a href="javascript:void(0)" data-role="'.esc_attr($key).'">'.esc_html($value['name']).'</a></li>';
                }
            endforeach;
            echo'</ul>';
            echo'</form>';
            echo'</div>';

            echo'<script type="text/javascript">
		jQuery("#woffice-members-filter .dropdown-menu a").on("click",function(){
			jQuery("#filterRole").val(jQuery(this).data("role"));
		    jQuery("#woffice-members-filter-form").submit();
		 });
		</script>';

        }
    }
}

/**
* Exclude some members according to a role
*
* @role : string, it's the role we look for
* @direction : string, exclude_all | exclude_role
* @return string
*/
if(!function_exists('woffice_exclude_members')) {
    function woffice_exclude_members($roles,$direction) {

        if(empty($roles)){
            return;
        }

        /* ALL USERS */
        $all_users = get_users( array('fields' => 'id') );

        /* REQUESTED USERS */
        if(is_array($roles)) {
            $requested_users = array();
            foreach ($roles as $role) {
                $requested_users_role = get_users(array('role' => $role, 'fields' => 'id'));
                $requested_users = array_unique(array_merge($requested_users,$requested_users_role), SORT_REGULAR);
            }
        } else {
            $requested_users = get_users(array('role' => $roles, 'fields' => 'id'));
        }

        /* ALL USERS - REQUESTED MEMBERS = EXCLUDED MEMBERS
         * See members-loop.php file for more details
        */
        if ($direction == 'exclude_all') {
            $exclude_members = array_diff($all_users,$requested_users);
        } else {
            $exclude_members = $requested_users;
        }
        $query_exclude_members = implode(',', $exclude_members);

        return $query_exclude_members;
    }
}

/**
* We get the user's cover image
*
* @user_ID : int, the member's ID
* @return string (the URL)
*/
if(!function_exists('woffice_get_cover_image')) {
    function woffice_get_cover_image($user_ID) {

        if( bp_is_active( 'xprofile' ) ) {

            $the_cover_from_extension = ( bp_is_active( 'xprofile' ) ) ? bp_get_profile_field_data(array('field' => 'woffice_cover', 'user_id' => $user_ID)) : '';
            /*If the cover image extension is enabled*/
            if (!empty($the_cover_from_extension)) {
                return $the_cover_from_extension;
            }
            else {
                $the_cover_old = ( bp_is_active( 'xprofile' ) ) ? bp_get_profile_field_data(array('field' => 'Cover', 'user_id' => $user_ID)) : '';
                $array = array();
                preg_match( '/src="([^"]*)"/i', $the_cover_old, $array ) ;
                if (!empty($array[1])){
                    return $array[1];
                }
                else {
                    /*We check for default image*/
                    $default_cover = (function_exists( 'fw_get_db_ext_settings_option' ) && function_exists("woffice_cover_upload_dir")) ? fw_get_db_ext_settings_option( 'woffice-cover', 'cover_default' ) : '';
                    if (!empty($default_cover)) {
                        return $default_cover['url'];
                    }
                    else {
                        return;
                    }
                }

            }

        } else {
            return;
        }

    }
}
/**
* WOFFICE USER'S NOTIFICATION per compoment
*
* @component : string, it's a Buddypress compoment
* @return string (HTML markup)
*/
if(!function_exists('woffice_user_notifications')) {
    function woffice_user_notifications($component){

		if ($component == "notifications" && bp_is_active("notifications")) {
			$count_notifications = bp_notifications_get_unread_notification_count( bp_loggedin_user_id() );
			return (!empty($count_notifications)) ? '<span class="count">'.bp_core_number_format( $count_notifications ).'</span>' : '';
		}
		elseif ($component == "messages" && bp_is_active("messages")){
			$count_messages = messages_get_unread_count();
			if (!empty($count_messages)) {
				return '<span class="count">'.bp_core_number_format( $count_messages ).'</span>';
			}
		}
		elseif ($component == "friends" && bp_is_active("friends")){
			$count_friends = friends_get_total_friend_count();
			if ($count_friends > 0) {
				return '<span class="count">'.bp_core_number_format( $count_friends ).'</span>';
			}
		}
		elseif ($component == "groups" && bp_is_active("groups")){
			$count_groups = bp_get_total_group_count_for_user();
			if ($count_groups > 0) {
				return '<span class="count">'.bp_core_number_format( $count_groups ).'</span>';
			}
		}
		else {
			if (bp_is_active("notifications")) {
				/*Get all notifications*/
				$notifications = bp_notifications_get_notifications_for_user(bp_loggedin_user_id(), 'object');
				$count = 0;
				if (!empty($notifications)) {
					foreach ($notifications as $single_notifcation) {
						if ($single_notifcation->component_name == $component || $component == 'notifications') {
							$count++;
						}
					}
				}
				if ($count > 0) {
					$html_markup = '<span class="count">' . $count . '</span>';
					return $html_markup;
				} else {
					return '';
				}
			} else {
				return '';
			}
		}

    }
}
/*---------------------------------------------------------
** 
** Notification menu in the top bar
**
----------------------------------------------------------*/
/**
* We create the wrapper (HTML), that's the default state while the AJAX is loading
*
* @return string (HTML markup)
*/
function woffice_notifications_menu() {
	
	echo '<div id="woffice-notifications-menu">';
	
		echo'<div id="woffice-notfications-loader" class="woffice-loader"><i class="fa fa-spinner"></i></div>';
		
		echo '<div id="woffice-notifications-content"></div>';
		
	echo '</div>';
	
}
/**
* Calcualte Time Difference between 2 dates (for the Notifications)
*
* @$ate : string, the actual time
* @return string 
*/
function woffice_calculate_time_span($date){
    $seconds  = strtotime(date('Y-m-d H:i:s')) - strtotime($date);

    $months = floor($seconds / (3600*24*30));
    $day = floor($seconds / (3600*24));
    $hours = floor($seconds / 3600);
    $mins = floor(($seconds - ($hours*3600)) / 60);
    $secs = floor($seconds % 60);

    if($seconds < 60)
        $time = $secs. __(" seconds ago","woffice");
    else if($seconds < 60*60 )
        $time = $mins. __(" min ago","woffice");
    else if($seconds < 24*60*60)
        $time = $hours. __(" hours ago","woffice");
    else if($seconds < 24*60*60)
        $time = $day. __(" day ago","woffice");
    else
        $time = $months. __(" month ago","woffice");

    return $time;
}
/**
* AJAX SCRIPT, We fetch the notification for the users
*
* @return string (HTML markup)
*/
function wofficeNoticationsGetHandler(){
	
	$user_id = $_POST['user'];
	
	if (bp_notifications_get_unread_notification_count($user_id) > 0) {
		$notifications = bp_notifications_get_notifications_for_user($user_id,"object");
		
		//fw_print($notifications);
		/* Returns : 
		[id] => '1'
        [user_id] => '1'
        [item_id] => '10'
		[component_name] => 'activity'
        [component_action] => 'new_at_mention'
        [date_notified] => '2015-11-08 14:50:08'
        [is_new] => '1'
        [content] => 'admin2 mentioned you'
        [href] => '...'	
		*/
		if (!empty($notifications)) {
			
			foreach ($notifications as $notification) {
				// Unread
				$active = ($notification->is_new == 1) ? 'active' : '';
				// Icon 
				switch ($notification->component_name) {
				    case "activity":
				        $icon_class = "fa-share";
				        break;
				    case "blogs":
				        $icon_class = "fa-th-large";
				        break;
				    case "forums":
				        $icon_class = "fa-sitemap";
				        break;
				    case "friends":
				        $icon_class = "fa-user";
				        break;
				    case "groups":
				        $icon_class = "fa-users";
				        break;
				    case "messages":
				        $icon_class = "fa-envelope-o";
				        break;
				    default:
						$icon_class = "fa-bell";
				}
				// Time 
				$time_difference = woffice_calculate_time_span($notification->date_notified);
				
				echo '<div class="woffice-notifications-item '.$active.'">';
					// We check for an username in the content : 
					$strings = explode(" ", $notification->content);
					// We get all the users BUT we limit to 100 queries so it's pretty fast and we save the PHP memory
					$woffice_wp_users = get_users(array('fields' => array('ID', 'display_name'), 'number' => 100));
					foreach ($strings as $word) {
						foreach ($woffice_wp_users as $user){
							if ($user->display_name == $word) {
								echo get_avatar( $user->ID, 50 );
								break; 
							}
						} 
					}
					
				
					// Display notification
					echo '<a href="'.$notification->href.'" alt="'. $notification->content .'">';
						echo'<i class="fa component-icon '. $icon_class .'"></i> '. $notification->content .' <span>('.$time_difference.')</span>';
					echo'</a>';
					
					echo '<a href="javascript:void(0)" class="mark-notification-read" data-component-action="'.$notification->component_action.'" data-component-name="'.$notification->component_name.'" data-item-id="'.$notification->item_id.'">';
						echo'<i class="fa fa-close"></i></a>';
				
				echo '</div>';
				
			}
			
		}
	} else {
		echo '<p class="woffice-notification-empty">'. __("You have","woffice") . " <b>0</b> " . __("unread notifications.","woffice"). '</p>';
	}
	
	exit();
	
}
add_action('wp_ajax_nopriv_wofficeNoticationsGet', 'wofficeNoticationsGetHandler');
add_action('wp_ajax_wofficeNoticationsGet', 'wofficeNoticationsGetHandler');
/**
* Mark a notfication as read in Buddypress
*
* @return null
*/
function wofficeNoticationsMarkedHandler(){
	
	$user_id = $_POST['user'];
	$component_action = $_POST['component_action'];
	$component_name = $_POST['component_name'];
	$item_id = $_POST['item_id'];
	bp_notifications_mark_notifications_by_item_id( $user_id, $item_id, $component_name, $component_action, false, 0 );
	
	exit();
	
}
add_action('wp_ajax_nopriv_wofficeNoticationsMarked', 'wofficeNoticationsMarkedHandler');
add_action('wp_ajax_wofficeNoticationsMarked', 'wofficeNoticationsMarkedHandler');
/**
* JQUERY & AJAX CALLS in the footer 
*
* @return string
*/
function woffice_notifications_scripts() {
	if (function_exists('bp_is_active') && bp_is_active( 'notifications' ) && is_user_logged_in()) : 
		$user_id = get_current_user_id();
		echo "<script type=\"text/javascript\">
		jQuery(document).ready( function() {
			// Close Notification tab : 
			function CloseNotfications() {
				jQuery('#woffice-notifications-menu').fadeOut();
			}
			// Mark as read : 
			function MarkNotificationRead() {
				jQuery('a.mark-notification-read').on('click', function(){
					var readLink = jQuery(this);
					var component_action = readLink.data('component-action');
					var component_name = readLink.data('component-name');
					var item_id = readLink.data('item-id');
					jQuery.ajax({
						url: '".get_site_url()."/wp-admin/admin-ajax.php', 
						type: 'POST',
						data: { 'action': 'wofficeNoticationsMarked', 'component_action': component_action, 'component_name': component_name, 'item_id': item_id },
						success: function(){
							readLink.parent().closest('div').remove();
							if (jQuery('#woffice-notifications-content').children().length == 0 ){
								jQuery('#nav-notification-trigger').removeClass('active');
								CloseNotfications();
							}
						},
						error:function(){
							console.log('Ajax marked failed');
						}   
					});
				});
			}
			// Notification AJAX : 
			jQuery('#nav-notification-trigger').click(function(){
				if (!jQuery(this).hasClass('clicked')) {
					jQuery('#woffice-notifications-menu').slideDown();
					jQuery('#woffice-notfications-loader').fadeIn();
					jQuery('#woffice-notifications-content').empty();
					jQuery.ajax({
						url: '".get_site_url()."/wp-admin/admin-ajax.php', 
						type: 'POST',
						data: { 'action': 'wofficeNoticationsGet', 'user': '".$user_id."' },
						success: function(notifications){
							jQuery('#woffice-notfications-loader').fadeOut();
							jQuery('#woffice-notifications-content').append(notifications);
							MarkNotificationRead();
						},
						error:function(){
							console.log('Ajax notifications failed');
						}   
					});
					jQuery(this).addClass('clicked');
				} else {
					CloseNotfications();
					jQuery(this).removeClass('clicked');
				}
			});
		});
		</script>";
	endif;
}
add_action('wp_footer', 'woffice_notifications_scripts');

/**
* Create the user's sidebar
*
* @return string : HTML markup
*/
if(!function_exists('woffice_user_sidebar')) {
    function woffice_user_sidebar()
    {
        global $bp;

        echo '<!-- START USER LINKS - WAITING FOR FIRING -->';
        echo '<div id="user-sidebar">';
        $user_ID = get_current_user_id();
        $current_user = wp_get_current_user();
        $the_cover = woffice_get_cover_image($user_ID);
        if (!empty($the_cover)):
            echo '<header id="user-cover" style="background-image: url(' . esc_url($the_cover) . ')">';
        else :
            echo '<header id="user-cover">';
        endif;
        echo '<a href="' . bp_core_get_user_domain($user_ID) . '" class="clearfix">';
        echo get_avatar($user_ID);

        $name_to_display = woffice_get_name_to_display($user_ID);

        echo '<span>' . __('Welcome', 'woffice') . ' <span class="woffice-welcome">' . esc_html($name_to_display) . '</span></span>';

        echo '</a>';
        echo '<div class="user-cover-layer"></div>';
        echo '</header>';
        echo '<nav>';
        //bp_nav_menu(array('container' => ''));
        echo '<ul id="menu-bp" class="menu">';
        $profile = bp_loggedin_user_domain();
        // Activity :
        if( bp_is_active( 'activity' ) ) {
            echo '<li id="activity-personal-li" class="menu-parent">
					<a href="' . bp_get_activity_directory_permalink() . '">' . __('Activity', 'woffice') . ' ' . woffice_user_notifications('activity') . '</a>
					<ul class="sub-menu">
						<li id="just-me-personal-li" class="menu-child">
							<a href="' . $profile . 'activity/">' . __('Activity', 'woffice') . '</a>
						</li>
						<li id="activity-mentions-personal-li" class="menu-child">
							<a href="' . $profile . 'activity/mentions/">' . __('Mentions', 'woffice') . '</a>
						</li>
						<li id="activity-favs-personal-li" class="menu-child">
							<a href="' . $profile . 'activity/favorites/">' . __('Favorites', 'woffice') . '</a>
						</li>';
					if (bp_is_active('friends')) {
						echo '<li id="activity-friends-personal-li" class="menu-child">
							<a href="' . $profile . 'activity/friends/">' . __('Friends', 'woffice') . '</a>
						</li>';
					}
					if (bp_is_active('groups')) {
						echo '<li id="activity-groups-personal-li" class="menu-child">
							<a href="' . $profile . 'activity/groups/">' . __('Groups', 'woffice') . '</a>
						</li>';
					}
					echo '</ul>
			</li>';
        }

        // XPROFILE :
        if (bp_is_active('xprofile')) {
            echo '<li id="xprofile-personal-li" class="menu-parent">
                    <a href="' . $profile . '">' . __('Profile', 'woffice') . ' ' . woffice_user_notifications('xprofile') . '</a>
                    <ul class="sub-menu">
                        <li id="public-personal-li" class="menu-child">
                            <a href="' . $profile . 'profile/">' . __('View', 'woffice') . '</a>
                        </li>
                        <li id="edit-personal-li" class="menu-child">
                            <a href="' . $profile . 'profile/edit/">' . __('Edit', 'woffice') . '</a>
                        </li>';
                // == 0, this field has an inverted value
                if(bp_core_get_root_option( 'bp-disable-avatar-uploads' ) == 0){
                    echo '<li id="change-avatar-personal-li" class="menu-child">
                            <a href="' . $profile . 'profile/change-avatar/">' . __('Change Profile Photo', 'woffice') . '</a>
                        </li>';
                }
				echo '</ul>
            </li>';
        }

        // NOTIFICATIONS :
        if (bp_is_active('notifications')) {
            echo '<li id="notifications-personal-li" class="menu-parent">
                <a href="' . $profile . 'notifications/">' . __('Notifications', 'woffice') . ' ' . woffice_user_notifications('notifications') . '</a>';
				echo'<ul class="sub-menu">
					<li id="notifications-my-notifications-personal-li" class="menu-child">
						<a href="' . $profile . 'notifications/">' . __('Unread', 'woffice') . '</a>
					</li>
					<li id="read-personal-li" class="menu-child">
						<a href="' . $profile . 'notifications/read/">' . __('Read', 'woffice') . '</a>
					</li>
				</ul>
			</li>';
        }

        // Messages :
        if (bp_is_active('messages')) {
            echo '<li id="messages-personal-li" class="menu-parent">
            	<a href="' . $profile . 'messages/">' . __('Messages', 'woffice') . ' ' . woffice_user_notifications('messages') . '</a>';
				echo'<ul class="sub-menu">
					<li id="inbox-personal-li" class="menu-child">
						<a href="' . $profile . 'messages/">' . __('Inbox', 'woffice') . '</a>
					</li>
					<li id="starred-personal-li" class="menu-child">
						<a href="' . $profile . 'messages/starred/">' . __('Starred', 'woffice') . '</a>
					</li>
					<li id="sentbox-personal-li" class="menu-child">
						<a href="' . $profile . 'messages/sentbox/">' . __('Sent', 'woffice') . '</a>
					</li>
					<li id="compose-personal-li" class="menu-child">
						<a href="' . $profile . 'messages/compose/">' . __('Compose', 'woffice') . '</a>
					</li>
					<li id="notices-personal-li" class="menu-child">
						<a href="' . $profile . 'messages/notices/">' . __('Notices', 'woffice') . '</a>
					</li>
				</ul>
			</li>';
        }

        // friends :
        if (bp_is_active('friends')) {
            echo '<li id="friends-personal-li" class="menu-parent">
                <a href="' . $profile . 'friends/">' . __('Friends', 'woffice') . ' ' . woffice_user_notifications('friends') . '</a>';
				echo'<ul class="sub-menu">
					<li id="friends-my-friends-personal-li" class="menu-child">
						<a href="' . $profile . 'friends/">' . __('Friendships', 'woffice') . '</a>
					</li>
					<li id="requests-personal-li" class="menu-child">
						<a href="' . $profile . 'friends/requests/">' . __('Requests', 'woffice') . '</a>
					</li>
				</ul>
			</li>';
        }

        // groups :
        if (bp_is_active('groups')) {
            echo '<li id="groups-personal-li" class="menu-parent">
            	<a href="' . $profile . 'groups/">' . __('Groups', 'woffice') . ' ' . woffice_user_notifications('groups') . '</a>';
				echo'<ul class="sub-menu">
					<li id="groups-my-groups-personal-li" class="menu-child">
						<a href="' . $profile . 'groups/">' . __('Memberships', 'woffice') . '</a>
					</li>
					<li id="invites-personal-li" class="menu-child">
						<a href="' . $profile . 'groups/invites/">' . __('Invitations', 'woffice') . '</a>
					</li>
				</ul>
			</li>';
        }

        // settings :
        if( bp_is_active( 'settings' ) ) {
            echo '<li id="settings-personal-li" class="menu-parent">
                    <a href="'.$profile.'settings/">'.__('Settings','woffice').' '.woffice_user_notifications('settings').'</a>
                    <ul class="sub-menu">
                        <li id="general-personal-li" class="menu-child">
                            <a href="'.$profile.'settings/">'.__('General','woffice').'</a>
                        </li>
                        <li id="notifications-personal-li" class="menu-child">
                            <a href="'.$profile.'settings/notifications/">'.__('Email','woffice').'</a>
                        </li>
                        <li id="profile-personal-li" class="menu-child">
                            <a href="'.$profile.'settings/profile/">'.__('Profile Visibility','woffice').'</a>
                        </li>
                        <li id="capabilities-personal-li" class="menu-child">
                            <a href="'.$profile.'settings/capabilities/">'.__('Capabilities','woffice').'</a>
                        </li>
                    </ul>
                </li>';
        }

        // Courses :
        if (function_exists("buddypress_learndash")) {

            echo '<li id="courses-personal-li" class="menu-parent">
                    <a href="'.$profile.'courses/">'.__('Courses','woffice').'</a>
                    <ul class="sub-menu">
                        <li id="general-personal-li" class="menu-child">
                            <a href="'.$profile.'courses/">'.__('General','woffice').'</a>
                        </li>
                    </ul>
                </li>';

        }

        if ( has_nav_menu('woffice_user') ) {
            wp_nav_menu(array('theme_location' => 'woffice_user', 'menu_id'=>'dropdown-user-menu', 'container' => ''));
        }

        // Log out URL
        echo'<li id="logout-li"><a href="'.wp_logout_url().'">'. __('Log Out','woffice').'</a></li>';
        echo'</ul>';

        echo'</nav>';
        echo'</div>';

    } //woffice_user_sidebar()
} //function_exists('woffice_user_sidebar')

/**
* REMOVE CSS FROM BUDDYPRESS, we include it through static.php
*
* @return null
*/
function woffice_dequeue_bp_styles() {
	wp_dequeue_style( 'bp-legacy-css' );
}
add_action( 'wp_enqueue_scripts', 'woffice_dequeue_bp_styles', 20 );

/**
* Removing TITLE OF MEMBER PAGE
*
* @return string (a template for buddypress)
*/
function woffice_member_username() {
    global $members_template;

    return $members_template->member->user_login;
}
add_filter('bp_member_name','woffice_member_username');

/**
* Creating Social fields group & fields for Woffice
*
* @return null
*/
if ( bp_is_active( 'xprofile' ) ){
	function woffice_social_fields(){
	    global $wpdb;
	    $group_args = array(
	        'name' => 'Social',
			'field_group_id' => 'woffice_options',
	    );
		$table_name = woffice_get_xprofile_table();
		$sqlStr = "SELECT * FROM ".$table_name." WHERE name = 'Social'; ";
	    $groups = $wpdb->get_results($sqlStr);
	    if(count($groups) > 0)
	    {
	        return;
	    }
	    $group_id = xprofile_insert_field_group( $group_args );
	    /*
		 * FACEBOOK FIELD 
		 */
	    xprofile_insert_field(
	        array (
	            'field_group_id' => $group_id,
				'can_delete' => true,
				'type' => 'textbox',
				'description' => __('Copy past your URL in this field please, if it is empty it will not be displayed.','woffice'),
				'name' => 'Facebook'
	        )
	    );
	    /*
		 * TWITTER FIELD 
		 */
	    xprofile_insert_field(
	        array (
	            'field_group_id' => $group_id,
				'can_delete' => true,
				'type' => 'textbox',
				'description' => __('Copy past your URL in this field please, if it is empty it will not be displayed.','woffice'),
				'name' => 'Twitter'
	        )
	    );
	    /*
		 * LINKEDIN FIELD 
		 */
	    xprofile_insert_field(
	        array (
	            'field_group_id' => $group_id,
				'can_delete' => true,
				'type' => 'textbox',
				'description' => __('Copy past your URL in this field please, if it is empty it will not be displayed.','woffice'),
				'name' => 'Linkedin'
	        )
	    );
	    /*
		 * SLACK FIELD 
		 */
	    xprofile_insert_field(
	        array (
	            'field_group_id' => $group_id,
				'can_delete' => true,
				'type' => 'textbox',
				'description' => __('Copy past your URL in this field please, if it is empty it will not be displayed.','woffice'),
				'name' => 'Slack'
	        )
	    );
	    /*
		 * GOOGLE FIELD 
		 */
	    xprofile_insert_field(
	        array (
	            'field_group_id' => $group_id,
				'can_delete' => true,
				'type' => 'textbox',
				'description' => __('Copy past your URL in this field please, if it is empty it will not be displayed.','woffice'),
				'name' => 'Google'
	        )
	    );
	    /*
		 * GITHUB FIELD 
		 */
	    xprofile_insert_field(
	        array (
	            'field_group_id' => $group_id,
				'can_delete' => true,
				'type' => 'textbox',
				'description' => __('Copy past your URL in this field please, if it is empty it will not be displayed.','woffice'),
				'name' => 'Github'
	        )
	    );
	    /*
		 * INSTAGRAM FIELD 
		 */
	    xprofile_insert_field(
	        array (
	            'field_group_id' => $group_id,
				'can_delete' => true,
				'type' => 'textbox',
				'description' => __('Copy past your URL in this field please, if it is empty it will not be displayed.','woffice'),
				'name' => 'Instagram'
	        )
	    );
	}
	add_action('bp_init', 'woffice_social_fields');
}
/**
* Renders the HTML markup for the social fields
*
* @return string (HTML markup)
*/
function woffice_member_social_extend(){
	global $bp;
	if ( bp_is_active( 'xprofile' ) ){
		$member_id = $bp->displayed_user->id;
		/*GET THE DATA*/
		$woffice_facebook   = xprofile_get_field_data('Facebook', $member_id);
		$woffice_twitter 	= xprofile_get_field_data('Twitter', $member_id);
		$woffice_linkedin 	= xprofile_get_field_data('Linkedin', $member_id);
		$woffice_slack 		= xprofile_get_field_data('Slack', $member_id);
		$woffice_google 	= xprofile_get_field_data('Google', $member_id);
		$woffice_github 	= xprofile_get_field_data('Github', $member_id);
		$woffice_instagram 	= xprofile_get_field_data('Instagram', $member_id);
		// For your own ones : Replace Custom with your Field name
		//$woffice_custom 	= xprofile_get_field_data('Custom', $member_id);
		/*FRONT END VIEW*/
		if (!empty($woffice_facebook)||!empty($woffice_twitter)||!empty($woffice_linkedin)||!empty($woffice_slack)||!empty($woffice_google)||!empty($woffice_github)||!empty($woffice_instagram)){
			echo '<div class="member-social">';
			echo ($woffice_facebook)  ? '<a href="'.esc_url($woffice_facebook) .'"  title="'.__('Facebook URL','woffice').'" target="_blank"><i class="fa fa-facebook"></i></a>' :'';
			echo ($woffice_twitter)   ? '<a href="'.esc_url($woffice_twitter) .'"  title="'.__('Twitter URL','woffice').'" target="_blank"><i class="fa fa-twitter"></i></a>' :'';
			echo ($woffice_linkedin)  ? '<a href="'.esc_url($woffice_linkedin) .'"  title="'.__('Linkedin URL','woffice').'" target="_blank"><i class="fa fa-linkedin"></i></a>' :'';
			echo ($woffice_slack)     ? '<a href="'.esc_url($woffice_slack) .'"  title="'.__('Slack URL','woffice').'" target="_blank"><i class="fa fa-slack"></i></a>' :'';
			echo ($woffice_google)    ? '<a href="'.esc_url($woffice_google) .'"  title="'.__('Google URL','woffice').'" target="_blank"><i class="fa fa-google-plus"></i></a>' :'';
			echo ($woffice_github)    ? '<a href="'.esc_url($woffice_github) .'"  title="'.__('Github URL','woffice').'" target="_blank"><i class="fa fa-github"></i></a>' :'';
			echo ($woffice_instagram) ? '<a href="'.esc_url($woffice_instagram) .'"  title="'.__('Instagram URL','woffice').'" target="_blank"><i class="fa fa-instagram"></i></a>' :'';
			echo '</div>';
		}
	}
	
}
add_filter( 'bp_before_member_header_meta', 'woffice_member_social_extend' );	

/**
* Renders the HTML markup for the custom search form in the main groups page
*
* @return string (HTML markup)
*/
if(!function_exists('bp_woffice_directory_groups_search_form')) {
    function bp_woffice_directory_groups_search_form() {
        $default_search_value = bp_get_search_default_text( 'groups' );
        $search_value         = !empty( $_REQUEST['s'] ) ? stripslashes( $_REQUEST['s'] ) : $default_search_value; ?>

        <form action="" method="get" id="search-groups-form">
            <label><input type="text" name="s" id="groups_search" placeholder="<?php echo esc_attr( $search_value ) ?>" /></label>
            <button type="submit" id="groups_search_submit" name="groups_search_submit">
                <i class="fa fa-search"></i>
            </button>
        </form>
        <?php
    }
}

/**
* Renders the HTML markup for the custom search form in the main members page
*
* @return string (HTML markup)
*/
if(!function_exists('bp_woffice_directory_members_search_form')) {
    function bp_woffice_directory_members_search_form() {
        $default_search_value = bp_get_search_default_text( 'members' );
        $search_value         = !empty( $_REQUEST['s'] ) ? stripslashes( $_REQUEST['s'] ) : $default_search_value; ?>

        <form action="" method="get" id="search-members-form">
            <label><input type="text" name="s" id="members_search" placeholder="<?php echo esc_attr( $search_value ) ?>" /></label>
            <button type="submit" id="members_search_submit" name="members_search_submit">
                <i class="fa fa-search"></i>
            </button>
        </form>
        <?php
    }
}

if(!function_exists('woffice_list_xprofile_fields')) {
    /**
     * LIST OF BUDDYPRESS FIELDS FOR THE ICONS in the main members page
     *
     * @param int $user_ID
     * @return string (HTML markup)
     */
    function woffice_list_xprofile_fields($user_ID) {

        if (function_exists('bp_is_active') && bp_is_active( 'xprofile' )) {

            // We fetch all the Buddypress fields :
            global $wpdb;
			$table_name = woffice_get_xprofile_table('fields');
			$sqlStr = "SELECT name, type FROM ".$table_name;
            $fields = $wpdb->get_results($sqlStr);
            //fw_print($fields);
            if(count($fields) > 0) {

                echo '<div class="woffice-xprofile-list">';

                foreach ($fields as $field) {

                    $field_name = $field->name;
                    $field_type = $field->type;
                    $field_show = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('buddypress_'.$field_name.'_display') : '';
                    $field_icon = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('buddypress_'.$field_name.'_icon') : '';
                    if (!empty($field_show)) {

                        // We check for display :
                        if ($field_show == true) {

                            $field_value = bp_get_profile_field_data( 'field='.$field_name.'&user_id='.$user_ID);
                            $blank_array = array();
                            $containe_url = preg_match_all('/(((ftp|http|https):\/\/)|(\/)|(..\/))(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/',$field_value, $blank_array);
                            if(empty($field_icon)){
                                $field_icon = 'fa-arrow-right';
                                if($field_type == 'datebox'){
                                    $field_icon = 'fa-calendar';
                                }
                                elseif($field_type == 'email'){
                                    $field_icon = 'fa-envelope';
                                }
                                elseif(!($field_type == 'url' || $field_type == 'web' || $field_type == 'email') && $containe_url){
                                    $field_name = strtolower($field_name);
                                    if(strpos($field_name, 'facebook') !== false){
                                        $field_icon = 'fa-facebook-square';
                                    }
                                    elseif(strpos($field_name, 'twitter') !== false){
                                        $field_icon = 'fa-twitter-square';
                                    }
                                    elseif(strpos($field_name, 'instagram') !== false){
                                        $field_icon = 'fa-instagram-square';
                                    }
                                    elseif(strpos($field_name, 'github') !== false){
                                        $field_icon = 'fa-github-square';
                                    }
                                    elseif(strpos($field_name, 'google') !== false){
                                        $field_icon = 'fa-google-plus-square';
                                    }
                                    elseif(strpos($field_name, 'slack') !== false){
                                        $field_icon = 'fa-slack';
                                    }
                                    elseif(strpos($field_name, 'linkedin') !== false){
                                        $field_icon = 'fa-linkedin-square';
                                    }
                                }
                            }

                            if (!empty($field_value)) {
	                            // we check if it's an URL
                                if($field_type == 'url' || $field_type == 'web' || $field_type == 'email'){
                                    echo '<span>';
                                    echo '<i class="fa '.$field_icon.'"></i>';
                                    echo $field_value;
                                    echo '</span>';
                                }
	                            elseif ( $containe_url ) {
                                    if(strpos($field_value, 'href') !== false) {
                                        $link_content = new SimpleXMLElement($field_value);
                                        $field_value = (string)$link_content['href'];
                                    }
                                    if(!empty($field_value)){
                                        echo '<span class="field-icon">';
                                        echo '<a href="'.$field_value.'" target="_blank">';
                                        echo '<i class="fa '.$field_icon.'"></i>';
                                        echo '</a>';
                                        echo '</span>';
                                    }

	                            }
								elseif (is_array($field_value)){
									echo '<span>';
									echo '<i class="fa '.$field_icon.'"></i>';
									echo implode(", ", $field_value);
									echo '</span>';
								}
								else {
		                            echo '<span>';
	                                echo '<i class="fa '.$field_icon.'"></i>';
	                                echo $field_value;
	                                echo '</span>';
	                            }
                                
                            }

                        }

                    }

                }

                echo '</div>';

            }

        }
    }
}

/**
* ADD CALENDAR TAB TO THE BUDDYPRESS PROFILES
*
* @return null
*/
function woffice_profile_tab_calendar() {
    //global $bp;

    $buddy_calendar = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('buddy_calendar') : '';
    if(function_exists('add_eventon') && $buddy_calendar == "show") {
        bp_core_new_nav_item(array(
            'name' => __('Calendar', 'woffice'),
            'slug' => 'calendar',
            'default_subnav_slug' => 'calendar',
            'screen_function' => 'woffice_profile_calendar_screen',
            'position' => 99,
            'show_for_displayed_user' => true,
        ));
    }
}
add_action( 'bp_setup_nav', 'woffice_profile_tab_calendar' );

/**
* We register the screen for Buddypress engine
*
* @return null
*/
if(!function_exists('woffice_profile_calendar_screen')) {
    function woffice_profile_calendar_screen() {
        //add title and content here - last is to call the members plugin.php template
        //add_action( 'bp_template_title', 'woffice_profile_calendar_title' );
        add_action( 'bp_template_content', 'woffice_profile_calendar_content' );
        bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
    }
}

/**
* Our new tab's title for the calendar
*
* @return string
*/
if(!function_exists('woffice_profile_calendar_title')) {
    function woffice_profile_calendar_title() {
        _e('Personal Calendar','woffice');
    }
}

/**
* The content of the calendar tab's content
*
* @return string : PHP content
*/
if(!function_exists('woffice_profile_calendar_content')) {
    function woffice_profile_calendar_content() {
        global $bp;
        $user_ID = $bp->displayed_user->id;
        if(!empty($user_ID)){
            echo do_shortcode("[add_eventon_fc users='".$user_ID."']");
        }
    }
}

/**
* ADD PERSONAL NOTES TAB TO THE BUDDYPRESS PROFILES
*
* @return null
*/
function woffice_profile_tab_note() {
    //global $bp;
    $buddy_notes = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('buddy_notes') : '';
    if($buddy_notes == "show") {
        bp_core_new_nav_item(array(
            'name' => __('Notes', 'woffice'),
            'slug' => 'notes',
            'default_subnav_slug' => 'notes',
            'screen_function' => 'woffice_profile_tab_note_screen',
            'position' => 99,
            'show_for_displayed_user' => true,
        ));
    }
    
}
add_action( 'bp_setup_nav', 'woffice_profile_tab_note' );

/**
* We register the screen for Buddypress engine
*
* @return null
*/
if(!function_exists('woffice_profile_tab_note_screen')) {
    function woffice_profile_tab_note_screen() {
        //add title and content here - last is to call the members plugin.php template
        //add_action( 'bp_template_title', 'woffice_profile_calendar_title' );
        add_action( 'bp_template_content', 'woffice_profile_note_content' );
        bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
    }
}

/**
* Our new tab's title for the notes
*
* @return string
*/
if(!function_exists('woffice_profile_note_title')) {
    function woffice_profile_note_title() {
        _e('Personal Notes','woffice');
    }
}

/**
* The content of the note tab's content
*
* @return string : PHP content
*/
if(!function_exists('woffice_profile_note_content')) {
    function woffice_profile_note_content() {
	    
	    // Here is the content
        global $bp;
        $user_ID = $bp->displayed_user->id;
        
        if(!empty($user_ID)){
	        
		    // We check the is the notes have been saved
		    if(isset($_POST['woffice_notes'])) {
			    xprofile_set_field_data( 'Woffice_Notes', $user_ID, $_POST['woffice_notes'] );
		    }
	        
            // We fetch the notes
			$the_notes   = xprofile_get_field_data('Woffice_Notes', $user_ID);
			// We display the form
			echo '<form action="http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'" method="POST" enctype="multipart/form-data" id="woffice_user_notes">';
				wp_editor( $the_notes , 'woffice_notes' ,  array('textarea_name' => 'woffice_notes') );
				echo '<button type="submit" class="btn btn-default"><i class="fa fa-edit"></i> '. __('Save my notes', 'woffice') .'</button>';
			echo '</form>';
        }
        
    }
}

/**
* We create the personal note field for Xprofiles
*
* @return null 
*/
function woffice_notes_add_field() {
	if ( bp_is_active( 'xprofile' ) ){
		//global $bp;
		$buddy_notes = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('buddy_notes') : '';
		if($buddy_notes == "show") {
			/*
			 * Create the FIELD
			 **/
			global $bp;
			global $wpdb;
			$table_name = woffice_get_xprofile_table('fields');
			$sqlStr = "SELECT `id` FROM $table_name WHERE `name` = 'Woffice_Notes'";
			$field = $wpdb->get_results($sqlStr);
			if (count($field) > 0) {
				return;
			}
			xprofile_insert_field(
				array(
					'field_group_id' => 1,
					'can_delete' => true,
					'type' => 'textarea',
					'name' => 'Woffice_Notes',
					'field_order' => 1,
					'is_required' => false,
				)
			);
		}
	}
}
add_action('init', 'woffice_notes_add_field');


/**
* CONTROL VIEW OF BUDDYPRESS COMPONENT, if the user is allowed
*
* @type : view || redirect
* @return boolean : true on allowed 
*/
if(!function_exists('woffice_is_user_allowed_buddypress')) {
    function woffice_is_user_allowed_buddypress($type) {

        // We check if the role isn't excluded
        if ($type == "view") {
            // We grab the options
            // It returns a role
            $buddy_members_excluded = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('buddy_members_excluded') : array();
            $buddy_groups_excluded = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('buddy_groups_excluded') : array();
            $buddy_activity_excluded = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('buddy_activity_excluded') : array();

            if(is_user_logged_in()) {

                // User data :
                $user = wp_get_current_user();
                /* Thanks to BBpress we only keep the main role */
                $the_user_role = (is_array($user->roles)) ? $user->roles[0] : $user->roles;


                $excluded_roles = array();

                // Members :
                if (bp_is_members_component()){
                    $excluded_roles = $buddy_members_excluded;
                }
                // Groups :
                if (bp_is_groups_component()){
                    $excluded_roles = $buddy_groups_excluded;
                }
                // Activity : 
                if (bp_is_activity_component()){
                    $excluded_roles = $buddy_activity_excluded;
                }
                
                if(empty($excluded_roles)) {
	                $excluded_roles = array();
                }

                if (!empty($excluded_roles) && in_array($the_user_role, $excluded_roles) && $the_user_role != "administrator") {
                    //if (in_array( $the_user_role , $excluded_roles ) && $the_user_role != "administrator") {
                    return false;

                } else {
                    return true;
                }
            }
            // Otherwise it means the page have been set to public anyway
            else {
                return true;
            }

        }
        // It's in the redirection process
        else {
            // We grab the options
            // Either private or public
            $buddy_members_state = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('buddy_members_state') : '';
            $buddy_groups_state = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('buddy_groups_state') : '';
            $buddy_activity_state = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('buddy_activity_state') : '';

            // Members :
            if(bp_is_members_component() && $buddy_members_state == "private" && !is_user_logged_in()) {
                return false;
            }
            else {
                // Groups :
                if( bp_is_active( 'groups' ) && bp_is_groups_component() && $buddy_groups_state == "private" && !is_user_logged_in()) {
                    return false;
                }
                // Activity : 
                elseif ( bp_is_active( 'activity' ) && bp_is_activity_component() && $buddy_activity_state == "private" && !is_user_logged_in()) {
	                return false;
                }
                else {
                    return true;
                }
            }

        }

    }
}	

/**
* ADD THEME'S POST TYPE TO THE ACTIVITY TRACKER
*
* @ost_types: not used as we re-declare it within the function
* @return null
*/
function woffice_record_custom_post_type_posts( $post_types ) {
    $post_types = array ('project', 'wiki', 'post');
    return $post_types;
}
add_filter( 'bp_blogs_record_post_post_types', 'woffice_record_custom_post_type_posts' );
add_filter( 'bp_blogs_record_comment_post_types', 'woffice_record_custom_post_type_posts' );
/*---------------------------------------------------------
** 
** For now Buddypress cover images aren't ready for Woffice
**
----------------------------------------------------------*/
// For members :
add_filter( 'bp_is_profile_cover_image_active', '__return_false' );
 
// For groups :
add_filter( 'bp_is_groups_cover_image_active', '__return_false' );
