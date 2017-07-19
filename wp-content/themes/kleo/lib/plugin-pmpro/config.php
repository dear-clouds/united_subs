<?php
/**
 * Membership functions
 * 
 * @package WordPress
 * @subpackage Kleo
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since Kleo 1.0
 */

//options array for restrictions: kleo_restrict_sweetdate
global $kleo_pay_settings;
$kleo_pay_settings = array (
    array(
        'title' => __('Members directory restriction','kleo_framework'),
        'front' => __('View members directory','kleo_framework'),
        'name' => 'members_dir'
    ),
    array(
        'title' => __('Restrict viewing other profiles','kleo_framework'),
        'front' => __('View members profile','kleo_framework'),
        'name' => 'view_profiles'
    ),
    array(
        'title' => __('Groups directory restriction','kleo_framework'),
        'front' => __('Access group directory','kleo_framework'),
        'name' => 'groups_dir'
    ),
    array(
        'title' => __('Group page restriction','kleo_framework'),
        'front' => __('Access to groups','kleo_framework'),
        'name' => 'view_groups'
    ),
    array(
        'title' => __('Site activity restriction','kleo_framework'),
        'front' => __('View site activity','kleo_framework'),
        'name' => 'show_activity'
    ),
    array(
        'title' => __('Sending private messages restriction','kleo_framework'),
        'front' => __('Send Private messages','kleo_framework'),
        'name' => 'pm'
    ),
    array(
        'title' => __('Restrict users from adding media to their profile using rtMedia','kleo_framework'),
        'front' => __('Add media to your profile','kleo_framework'),
        'name' => 'add_media'
    )
);

$kleo_pay_settings = apply_filters('kleo_pmpro_level_restrictions', $kleo_pay_settings);

/**
 * Get saved membership settings
 * @return array
 * @since 2.0
 */
function kleo_memberships($theme='')
{
	$restrict_options = sq_option('membership');
	
	return $restrict_options;
}

if (!function_exists('kleo_pmpro_restrict_rules')):
/**
 * Applies restrictions based on the Theme options -> Memberships
 * @return void
 * @since 2.0
 */
function kleo_pmpro_restrict_rules()
{
  //if PMPRO is not activated 
  if (! function_exists('pmpro_url')) {
    return;
  }
	
  //if buddypress is not activated
  if (!function_exists('bp_is_active')) {
    return;
  }
	
	//full current url
	$actual_link = kleo_full_url();
	
	//our request uri
	$home_url = home_url();
	
	//WPML support
	if (defined('ICL_SITEPRESS_VERSION'))
	{
		global $sitepress;
		$home_url = $sitepress->language_url( ICL_LANGUAGE_CODE );
	}
	
	$home_url = str_replace("www.","",$home_url);
	
	$uri = str_replace(untrailingslashit($home_url),"",$actual_link);

	//restriction match array
	$final = array();

	$allowed_chars = apply_filters('kleo_pmpro_allowed_chars', "a-z 0-9~%.:_\-");
	$restrict_options = kleo_memberships();
	$members_slug = str_replace('/', '\/', bp_get_members_root_slug());
	
	

	/*-----------------------------------------------------------------------------------*/
	/* Preg match rules
	/*-----------------------------------------------------------------------------------*/

	//members directory restriction rule
	$final["/^\/".$members_slug."\/?$/"] = array('name' => 'members_dir', 'type' => $restrict_options['members_dir']['type'], 'levels' => isset($restrict_options['members_dir']['levels'])?$restrict_options['members_dir']['levels']:array());

	if (function_exists('bp_get_groups_root_slug'))
	{
		$groups_slug = str_replace('/', '\/', bp_get_groups_root_slug());

		//groups directory restriction rule
		$final["/^\/".$groups_slug."\/?$/"] = array('name' => 'groups_dir', 'type' => $restrict_options['groups_dir']['type'], 'levels' => isset($restrict_options['groups_dir']['levels'])?$restrict_options['groups_dir']['levels']:array());
		
		//groups single page restriction rule
		$final["/^\/".$groups_slug."\/[".$allowed_chars."\/]+\/?$/"] = array('name' => 'view_groups', 'type' => $restrict_options['view_groups']['type'], 'levels' => isset($restrict_options['view_groups']['levels'])?$restrict_options['view_groups']['levels']:array());
	}
    
	if (function_exists('bp_get_activity_root_slug'))
	{
		$activity_slug = str_replace('/', '\/', bp_get_activity_root_slug());
		//activity page restriction rule
		$final["/^\/".$activity_slug."\/?$/"] = array('name' => 'show_activity', 'type' => $restrict_options['show_activity']['type'], 'levels' => isset($restrict_options['show_activity']['levels'])?$restrict_options['show_activity']['levels']:array());
	}
    
	/* You can add extra restrictions using this filter */
	$final = apply_filters('kleo_pmpro_match_rules',$final);

	//no redirection for super-admin
	if (is_super_admin())
	{
		return false;
	}
	elseif (is_user_logged_in()) //only if logged in
	{
		//restrict media
		if(preg_match("/^\/".$members_slug."\/". bp_get_loggedin_user_username()."\/media\/?/", $uri) 
				|| preg_match("/^\/".$members_slug."\/". bp_get_loggedin_user_username()."\/album\/?/", $uri)
			)
		{
			kleo_check_access('add_media', $restrict_options);
		}
		//restrict private messages
		elseif(preg_match("/^\/".$members_slug."\/". bp_get_loggedin_user_username()."\/messages\/compose\/?/", $uri)
				|| preg_match("/^\/".$members_slug."\/". bp_get_loggedin_user_username()."\/messages\/view\/[".$allowed_chars."\/]?\/?/", $uri)
		)
		{
			kleo_check_access('pm', $restrict_options);
		}

		/* Add other restrictions for own profile */
		do_action('kleo_pmro_extra_restriction_before_my_profile',$restrict_options); /* Deprecated */
		do_action('kleo_pmpro_extra_restriction_before_my_profile',$restrict_options);

		//allow me to view other parts of my profile
		if (bp_is_my_profile())
		{
			return false;
		}
	}

	//members single profile restriction rule
	if (bp_is_user()) {
		kleo_check_access('view_profiles', $restrict_options);
	}

	//loop through remaining restrictions
	foreach($final as $rk => $rv)
	{
		if(preg_match($rk, $uri))
		{
			kleo_check_access($rv['name'], $restrict_options);
		}
	}

	do_action( 'kleo_pmro_extra_restriction_rules', $restrict_options ); /* Deprecated */
	do_action( 'kleo_pmpro_extra_restriction_rules', $restrict_options );
}
endif;

if (! is_admin()) {
	add_action("init", "kleo_pmpro_restrict_rules");
}

if (!function_exists('kleo_check_access')) : 
/**
 * Checks $area for applied restrictions based on user status(logged in, membership level)
 * and does the proper redirect
 * @global object $current_user
 * @param string $area
 * @param array $restrict_options
 * @param boolean $return Whether to just return true if the restriction should be applied
 *
 * @return boolean|void
 * @since 2.0
 */
function kleo_check_access($area, $restrict_options=null, $return = false)
{
  global $current_user;
	
  if (!$restrict_options) {
    $restrict_options = kleo_memberships();
  }
	
	if (pmpro_url("levels")) {
		$default_redirect = pmpro_url("levels");
	}
	else {
		$default_redirect = bp_get_signup_page();
	}
	$default_redirect = apply_filters('kleo_pmpro_url_redirect', $default_redirect);
	
	//no restriction
  if ($restrict_options[$area]['type'] == 0) 
  {
		return false;
	}
	
  //restrict all members -> go to home url
  if ($restrict_options[$area]['type'] == 1) 
  {
		wp_redirect(apply_filters('kleo_pmpro_home_redirect',home_url()));
		exit;
  }

  //is a member
  if (isset($current_user->membership_level) && $current_user->membership_level->ID) {

    //if restrict my level
    if ($restrict_options[$area]['type'] == 2 && isset($restrict_options[$area]['levels']) && is_array($restrict_options[$area]['levels']) && !empty($restrict_options[$area]['levels']) && pmpro_hasMembershipLevel($restrict_options[$area]['levels']) )
    {
	    return kleo_pmpro_return_restriction($return, $default_redirect);
	    exit;
    }
    
  //logged in but not a member
  } else if (is_user_logged_in()) {
    if ($restrict_options[$area]['type'] == 2 && isset($restrict_options[$area]['not_member']) && $restrict_options[$area]['not_member'] == 1)
    {
	    return kleo_pmpro_return_restriction($return, $default_redirect);
	    exit;
    }
  }
  //not logged in
  else {
    if ($restrict_options[$area]['type'] == 2 && isset($restrict_options[$area]['guest']) && $restrict_options[$area]['guest'] == 1)
    {
	    return kleo_pmpro_return_restriction($return, $default_redirect);
	    exit;
    }
  }
}
endif;

/**
 * Calculate if we want to apply the redirect or just return true when restriction is applied
 *
 * @param boolean $return
 * @param string $default_redirect
 * @return boolean
 *
 * @since 4.0.3
 */
function kleo_pmpro_return_restriction($return = false, $default_redirect = null) {
	if ($return === false) {
		wp_redirect($default_redirect);
		exit;
	} else {
		return true;
	}
}


if (!function_exists('kleo_membership_info')) :
/**
 * Add membership info next to profile page username
 * @since 2.0
 */
function kleo_membership_info()
{
  global $membership_levels,$current_user;
  if (! $membership_levels) {
    return;
  }
  
  if (bp_is_my_profile())
  {
    if (isset($current_user->membership_level) && $current_user->membership_level->ID)
    {
      echo '<a href="'.pmpro_url("account").'"><span class="label radius pmpro_label">'.$current_user->membership_level->name.'</span></a>';
    }
    else
    {
      echo '<a href="'.pmpro_url("levels").'"><span class="label radius pmpro_label">'.__("Upgrade account",'kleo_framework').'</span></a>';
    }
  }
}
endif;
add_action('bp_before_member_header_meta', 'kleo_membership_info');


/*
 * Some template hacking because if you are using child theme 
 * PMPRO fails to get parent templates
 */

//remove default function
remove_action("wp", "pmpro_wp", 1);

//this code runs after $post is set, but before template output
function pmpro_wp_custom()
{
	if(!is_admin())
	{
        global $post, $pmpro_pages, $pmpro_page_name, $pmpro_page_id, $pmpro_body_classes;

        //no pages yet?
        if(empty($pmpro_pages))
            return;

        //run the appropriate preheader function
        foreach($pmpro_pages as $pmpro_page_name => $pmpro_page_id)
        {
            if(!empty($post->post_content) && strpos($post->post_content, "[pmpro_" . $pmpro_page_name . "]") !== false)
            {
                //preheader
                require_once(PMPRO_DIR . "/preheaders/" . $pmpro_page_name . ".php");

                //add class to body
                $pmpro_body_classes[] = "pmpro-" . str_replace("_", "-", $pmpro_page_name);

                //shortcode
                function pmpro_pages_shortcode($atts, $content=null, $code="")
                {
                    global $pmpro_page_name;
                    ob_start();
					if(file_exists(get_stylesheet_directory() . "/paid-memberships-pro/pages/" . $pmpro_page_name . ".php"))
						include(get_stylesheet_directory() . "/paid-memberships-pro/pages/" . $pmpro_page_name . ".php");
					elseif(file_exists(get_template_directory() . "/paid-memberships-pro/pages/" . $pmpro_page_name . ".php"))
						include(get_template_directory() . "/paid-memberships-pro/pages/" . $pmpro_page_name . ".php");
					else
						include(PMPRO_DIR . "/pages/" . $pmpro_page_name . ".php");
					
					$temp_content = ob_get_contents();
					ob_end_clean();
					return apply_filters("pmpro_pages_shortcode_" . $pmpro_page_name, $temp_content);
				}
				add_shortcode("pmpro_" . $pmpro_page_name, "pmpro_pages_shortcode");
				break;	//only the first page found gets a shortcode replacement
			}
		}
	}
}
add_action("wp", "pmpro_wp_custom", 1);


//checkout shortcode override
remove_shortcode("pmpro_checkout", "pmpro_checkout_shortcode");
function pmpro_checkout_shortcode_custom($atts, $content=null, $code="")
{	
	ob_start();
	if(file_exists(get_stylesheet_directory() . "/paid-memberships-pro/pages/checkout.php")) {
		include(get_stylesheet_directory() . "/paid-memberships-pro/pages/checkout.php");
	}
	elseif(file_exists(get_template_directory() . "/paid-memberships-pro/pages/checkout.php")) {
		include(get_template_directory() . "/paid-memberships-pro/pages/checkout.php");
	}
	else {
		include(PMPRO_DIR . "/pages/checkout.php");
	}
	$temp_content = ob_get_contents();
	ob_end_clean();
	return apply_filters("pmpro_pages_shortcode_checkout", $temp_content);			
}
add_shortcode("pmpro_checkout", "pmpro_checkout_shortcode_custom");


/**
 * BP Profile Message UX compatibility
 * @since 4.0.3
 */
function kleo_bp_profile_message_ux_send_private_message() {
	if ( isset( $_POST['private_message_content'] ) && ! empty( $_POST['private_message_content'] ) ) {
		$content_restricted = __("You aren't allowed to perform this action", "kleo_framework");

		if (kleo_check_access('pm', null, true)) {
			bp_core_add_message( $content_restricted, 'error' );
			bp_core_redirect( bp_displayed_user_domain() );
		}
	}
}

add_action( 'wp', 'kleo_bp_profile_message_ux_send_private_message', 2 );


/**
 * Options settings callback function
 * 
 * @global array $kleo_pay_settings
 * @global object $wpdb
 * @param string $field
 * @param array $value
 */
function pmpro_data_set($field, $value) {
	
	//print_r($value);
	global $kleo_pay_settings, $wpdb;
	$sqlQuery = "SELECT * FROM $wpdb->pmpro_membership_levels ";						
	$levels = $wpdb->get_results($sqlQuery, OBJECT);
	echo '<table class="membership-settings">';
  foreach ($kleo_pay_settings as $pays) :
	?>
	<tr>
		<td scope="row" valign="top">
			<label for="<?php echo $pays['name'];?>"><strong><?php echo $pays['title'];?></strong></label>
		</td>
		<td>
			<select id="<?php echo $pays['name'];?>" name="<?php echo 'kleo_'. KLEO_DOMAIN.'['.$field['id'].']';?>[<?php echo $pays['name'];?>][type]" onchange="pmpro_update<?php echo $pays['name'];?>TRs();">
				<option value="0" <?php if(!isset($value[$pays['name']]['type'])) { ?>selected="selected"<?php } ?>><?php _e('No', 'pmpro');?></option>
				<option value="1" <?php if(isset($value[$pays['name']]['type']) && $value[$pays['name']]['type'] == 1) { ?>selected="selected"<?php } ?>><?php _e('Restrict All Members', 'pmpro');?></option>
				<option value="2" <?php if(isset($value[$pays['name']]['type']) && $value[$pays['name']]['type'] == 2) { ?>selected="selected"<?php } ?>><?php _e('Restrict Certain Levels', 'pmpro');?></option>
		</select>                        
		</td>
	</tr> 	
	<tr id="<?php echo $pays['name'];?>levels_tr" <?php if(isset($value[$pays['name']]['type']) && $value[$pays['name']]['type'] != 2) { ?>style="display: none;"<?php } ?>>
		<td scope="row" valign="top">
			<label for="<?php echo 'kleo_'. KLEO_DOMAIN.'['.$field['id'].']';?>[<?php echo $pays['name'];?>][levels][]"><?php _e('Choose Levels to Restrict', 'pmpro');?>:</label>
		</td>
		<td>
			<div class="checkbox_box" <?php if(count($levels) > 3) { ?>style="height: 100px; overflow: auto;"<?php } ?>>
				<div class="clickable"><label><input type="checkbox" id="<?php echo $pays['name'];?>levels_guest" name="<?php echo 'kleo_'. KLEO_DOMAIN.'['.$field['id'].']';?>[<?php echo $pays['name'];?>][guest]" value="1" <?php if(isset($value[$pays['name']]['guest']) && $value[$pays['name']]['guest'] == 1) { ?>checked="checked"<?php } ?>> <?php echo __("Not logged in","kleo_framework");?></label></div>
				<div class="clickable"><label><input type="checkbox" id="<?php echo $pays['name'];?>levels_not_member" name="<?php echo 'kleo_'. KLEO_DOMAIN.'['.$field['id'].']';?>[<?php echo $pays['name'];?>][not_member]" value="1" <?php if(isset($value[$pays['name']]['not_member']) && $value[$pays['name']]['not_member'] == 1) { ?>checked="checked"<?php } ?>> <?php echo __("Not members","kleo_framework");?></label></div>
					<?php 										
					if (isset($value[$pays['name']]['levels'])) {
						if(!is_array($value[$pays['name']]['levels']))
							$value[$pays['name']]['levels'] = explode(",", $value[$pays['name']]['levels']);
					}
					else {
						$value[$pays['name']]['levels'] = array();
					}					
					foreach($levels as $level) 
					{ 
				?>
					<div class="clickable"><label><input type="checkbox" class="kleo-no-click-event" id="<?php echo $pays['name'];?>levels_<?php echo $level->id; ?>" name="<?php echo 'kleo_'. KLEO_DOMAIN.'['.$field['id'].']'; ?>[<?php echo $pays['name']; ?>][levels][]" value="<?php echo $level->id; ?>" data-initval="<?php echo $level->id; ?>" <?php if( in_array( $level->id, $value[$pays['name']]['levels'] ) ) { ?>checked="checked"<?php } ?>> <?php echo $level->name?></label></div>
				<?php 
					} 
				?>
			</div> 
		</td>
	</tr> 
	<tr class="bottom-border">
		<td scope="row" valign="top">
			<label><?php _e("Show field in memberships table","kleo_framework");?></label>
		</td>
		<td>
			<select name="<?php echo 'kleo_'. KLEO_DOMAIN.'['.$field['id'].']';?>[<?php echo $pays['name'];?>][showfield]">
				<option value="1" <?php if(isset($value[$pays['name']]['showfield']) && $value[$pays['name']]['showfield'] != 2) { ?>selected="selected"<?php } ?>><?php _e('Yes', 'pmpro');?></option>
				<option value="2" <?php if(isset($value[$pays['name']]['showfield']) && $value[$pays['name']]['showfield'] == 2) { ?>selected="selected"<?php } ?>><?php _e('No', 'pmpro');?></option>
			</select>    
		</td>
	</tr> 

	<script>
	function pmpro_update<?php echo $pays['name'];?>TRs()
	{
		var <?php echo $pays['name'];?> = jQuery('#<?php echo $pays['name'];?>').val();
		if( <?php echo $pays['name'];?> == 2) 
		{
			jQuery('#<?php echo $pays['name'];?>levels_tr').show();
		} 
		else
		{
			jQuery('#<?php echo $pays['name'];?>levels_tr').hide();
		}

		if( <?php echo $pays['name'];?> > 0) 
		{
			jQuery('#<?php echo $pays['name'];?>_explanation').show();
		} 
		else
		{
			jQuery('#<?php echo $pays['name'];?>_explanation').hide();
		}
	}
	pmpro_update<?php echo $pays['name'];?>TRs();
	</script>
	<?php endforeach; ?>
	<tr>
			<td scope="row" valign="top">
				<label><?php _e("Popular level",'kleo_framework');?></label>
			</td>
			<td>
				<select name="<?php echo 'kleo_'. KLEO_DOMAIN.'['.$field['id'].']';?>[kleo_membership_popular]">
		<option value='0'><?php _e("None", 'pmpro');?></option>
		<?php
		if ($levels) {
		  foreach($levels as $level) 
		  { 
		  ?>
			<option value="<?php echo $level->id?>" <?php if($level->id == $value['kleo_membership_popular']) { ?>selected="selected"<?php } ?>><?php echo $level->name?></option>
		  <?php 
		  }
		}
		?>
				</select>                        
			</td>
		</tr>     
		<tr class="bottom-border">
			<td scope="row" valign="top">
				<label for="nonmembertext"><?php _e('Order in Membership table', 'kleo_framework');?>:</label>
			</td>
			<td>
		<?php	
		if ($levels) {
		  foreach($levels as $level) 
		  { 
		  ?>
		  <?php echo $level->name?>: <input type="text" size="2" name="<?php echo 'kleo_'. KLEO_DOMAIN.'['.$field['id'].']';?>[kleo_pmpro_levels_order][<?php echo $level->id;?>]" value="<?php if(isset($value['kleo_pmpro_levels_order'][$level->id])) echo $value['kleo_pmpro_levels_order'][$level->id]; else echo "0";?>"><br>
		  <?php 
		  }
		} else { echo 'No levels added to apply sorting.'; }
		?>
			</td>
		</tr>  
	<?php

	echo '</table>';
}



/* Restrict email messages content to non paying members */
if ( ! function_exists( 'kleo_pmpro_restrict_pm_email_content' ) ) {
    function kleo_pmpro_restrict_pm_email_content($email_content, $sender_name, $subject, $content, $message_link, $settings_link, $ud)
    {

        $restrict_message = false;
        $restrict_options = kleo_memberships();
        $area = 'pm';

        if (pmpro_getMembershipLevelForUser($ud->ID)) {
            $current_level_obj = pmpro_getMembershipLevelForUser($ud->ID);
            $current_level = $current_level_obj->ID;

            //if restrict my level
            if ($restrict_options[$area]['type'] == 2 && isset($restrict_options[$area]['levels']) && is_array($restrict_options[$area]['levels']) && !empty($restrict_options[$area]['levels']) && in_array($current_level, $restrict_options[$area]['levels'])) {
                $restrict_message = true;
            }


        } else { /* not a member */
            if ($restrict_options[$area]['type'] == 2 && isset($restrict_options[$area]['not_member']) && $restrict_options[$area]['not_member'] == 1) {
                $restrict_message = true;
            }
        }

        if ($restrict_message) {

            $content = 'Your current membership does not allow private messages access.';
            $email_content = sprintf(__(
                '%1$s sent you a new message:

Subject: %2$s

"%3$s"

To view and read your messages please log in and visit: %4$s

---------------------
', 'buddypress'), $sender_name, $subject, $content, $message_link);

            // Only show the disable notifications line if the settings component is enabled
            if (bp_is_active('settings')) {
                $email_content .= sprintf(__('To disable these notifications, please log in and go to: %s', 'buddypress'), $settings_link);
            }

            return $email_content;
        }

        return $email_content;

    }
}
add_filter( 'messages_notification_new_message_message', 'kleo_pmpro_restrict_pm_email_content', 11, 7 );

