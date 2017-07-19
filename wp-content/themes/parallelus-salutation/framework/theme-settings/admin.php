<?php

global $theme_settings_settings, $theme_settings;

//	echo '<pre>Post:';
//	print_r($_POST);
//	echo '</pre>';

$required = '<em class="required">' . __('Required', THEME_NAME) . '</em>';
$_data = $theme_settings_settings->data;


switch ($theme_settings_settings->navigation) {
	
	//case 'contact_field':
		//break;
	
default:

// DEFAULT - Theme Settings Page

	$keys = $theme_settings_settings->keys;
	/*$importing = ($keys[0] == '_plugin_saved') ? true : false; // are we currently trying to import saved settings?
	
	// Check for saved data to import
	$current_import_key = $theme_settings_settings->get_val('import_key', $keys);
	$current_version_key = $theme_settings_settings->get_val('version_key', $keys);

	if ( !empty($_data['_plugin_saved']) && $keys[0] != '_plugin_saved' ) {

		foreach ($_data['_plugin_saved'] as $key => $item) {
			$import_version_key = $item['version_key'];
			// Is this overwritten?
			if ( $current_import_key == $import_version_key ) {
				$importStatus = 'old'; // already imported or chose to ignore saved file
			}else {
				if ( $current_version_key == $import_version_key ) {
					$importStatus = 'same'; // probably just created a saved file and the person wants to test if it was recognized. 
				} else {
					$importStatus = 'new'; // we have a new saved file that needs to be imported or discarded
				}
			}
			if ($importStatus == 'same' || $importStatus == 'new') {
				$import_link = array('navigation' => 'options', 'action' => 'edit', 'keys' => '_plugin_saved,'.$key);
				$message = __('A saved data file was found. What would you like to do? &nbsp; %s', THEME_NAME);
				$option_1 = $theme_settings_settings->settings_link(__('View data for import', THEME_NAME), $import_link);
				echo '<div class="updated fade"><p><strong>' . sprintf( $message, $option_1 ) . '</strong></p></div>';
			}
		}
	}*/


	if (!isset($importing)) {
		echo '<p>' . __('Configure the options below to set the theme-specific functionality as needed for your site.' ,THEME_NAME) . '</p>';
	}

	$theme_settings_settings->settings_form_header(array('action' => 'save', 'keys' => '_plugins,options', 'action_keys' => '_plugins,options'));
	
	?>

	<a name="options_misc"></a>
	<!--<h3><?php _e('Miscellaneous', THEME_NAME); ?></h3>-->
	<!--<p><?php _e('Various settings related to your site setup and functionality.' ,THEME_NAME); ?></p>-->
	<!--<div class="meta-box-sortables metabox-holder">
		<div class="postbox">
			<div class="handlediv" title="Click to toggle"><br></div><h3 class="hndle"><span><?php _e('Options', THEME_NAME); ?></span></h3>
			<div class="inside" style="display: none;">-->
				<table class="form-table">
				<?php
					$comment =	__('Enter the full URL to your favorites (shortcut) icon file. For example: ', THEME_NAME) . 
								'<br /><code>'. trailingslashit(get_bloginfo('url')) .'wp-content/uploads/'. date('Y') .'/'. date('m') .'/favicon.ico</code>';
					$comment = $theme_settings_settings->format_comment($comment);
					$row = array(__('Favorites Icon', THEME_NAME), $theme_settings_settings->settings_input('favorites_icon', $keys) . $comment);
					$theme_settings_settings->setting_row($row);
			
					$comment =	__('This icon is used by Android (v2.1+) and iPhones to display home screen bookmarks.<br />Recommended image size ' .
								'<code>129 x 129</code>, saved in <code>PNG</code> format.', THEME_NAME);
					$comment = $theme_settings_settings->format_comment($comment);
					$row = array(__('Mobile Bookmark Icon', THEME_NAME), $theme_settings_settings->settings_input('apple_touch_icon', $keys) . $comment);
					$theme_settings_settings->setting_row($row);
					
					$comment =	__('Optional text appended to browser titlebar. Should start with separator, e.g., " - My Site Name".' . 
								'<br /><strong>Note:</strong> This text will only apear on sub-pages and not the home page of your site.', THEME_NAME);
					$comment = $theme_settings_settings->format_comment($comment);
					$row = array(__('Append to Browser Title', THEME_NAME), $theme_settings_settings->settings_input('append_to_title', $keys) . $comment);
					$theme_settings_settings->setting_row($row);
			
					$comment = __('Show placeholder images for posts and portfolio items without images attached.', THEME_NAME);
					$comment = $theme_settings_settings->format_comment($comment);
					$row = array(__('Placeholder Images', THEME_NAME), $theme_settings_settings->settings_bool('placeholder_images', $keys) . $comment);
					$theme_settings_settings->setting_row($row);
					
					$comment =	__('Enter the full image URL, for example: ', THEME_NAME) . 
								'<br /><code>'. trailingslashit(get_bloginfo('url')) .'wp-content/uploads/'. date('Y') .'/'. date('m') .'/placeholder.jpg</code>';
					$comment = $theme_settings_settings->format_comment($comment);
					$row = array(__('Custom Placeholder Image', THEME_NAME), $theme_settings_settings->settings_input('custom_placeholder', $keys) . $comment);
					$theme_settings_settings->setting_row($row);
					
					$comment = __('Select the page to display for "404" or  "Not Found" errors.', THEME_NAME);
					$comment = $theme_settings_settings->format_comment($comment);
					$pages = $theme_settings_settings->get_pages('Select a page');
					$row = array(__('Error Page (404)', THEME_NAME), $theme_settings_settings->settings_select('404_page', $pages));
					$theme_settings_settings->setting_row($row);
			
					$comment =	__('Enter your Google Analytics tracking ID. For example: <code>UA-XXXXX-X</code>', THEME_NAME) .'<br />'.
								'<a href="http://www.google.com/support/analytics/bin/answer.py?hl=en&answer=55603">'. __('Where can I find my tracking code?', THEME_NAME) .'</a> ' .
								__('Don\'t have a Google Analytics account? ', THEME_NAME) .'<a href="http://www.google.com/analytics/">'. __('Sign up free', THEME_NAME) .'.</a>';
					$comment = $theme_settings_settings->format_comment($comment);
					$row = array(__('Google Analytics', THEME_NAME), $theme_settings_settings->settings_input('google_analytics', $keys) . $comment);
					$theme_settings_settings->setting_row($row);
					
					$comment = sprintf(__('Enable auto paragraph and break tags on WordPress editor content (%swpautop%s). Turning this off may solve common layout and vertical spacing issues.', THEME_NAME), '<a href="http://codex.wordpress.org/Function_Reference/wpautop" target="blank">', '</a>');
					$comment = $theme_settings_settings->format_comment($comment);
					$row = array(__('Auto Paragraphs (wpautop)', THEME_NAME), $theme_settings_settings->settings_bool('wpautop', $keys) . $comment);
					$theme_settings_settings->setting_row($row);
				?>
				</table><?php
				                            /* the_content filters controll */
				                            global $wp_filter;
				                            $the_content_filters = get_option( 'public_content_filters', $wp_filter['the_content'] );  //$wp_filter['the_content'];

				                            $excluded_filters = array(
				                                'capital_P_dangit',
				                                'do_shortcode',
				                                'convert_smilies',
				                                'wpautop',
				                                'shortcode_unautop',
				                                //'prepend_attachment',
				                                'the_content_filter',
				                                'wpautop_control_filter',
				                                'wptexturize',
				                                'convert_chars'
				                            );

				                            $_filters = array();

				                            foreach($the_content_filters as $level => $filters) {

				                                foreach($filters as $key => $val) {

				                                    if(!in_array($key, $excluded_filters) && !in_array($val["function"][1], $excluded_filters)) {
				                                        if(is_object($val["function"][0])) {
				                                            $_filters[] = get_class($val["function"][0]) . "->" . $val["function"][1];
				                                        } else {
				                                            $_filters[] = $key;
				                                        }
				                                    }

				                                }

				                            }

				                            $post_types = get_post_types();


				                            // remove excluded post types
				                            $excluded_types = array(
				                                //'attachment',
				                                'revision',
				                                'nav_menu_item'
				                            );

				                            foreach($post_types as $key => $val) {
				                                if(in_array($val, $excluded_types)) {
				                                    unset($post_types[$key]);
				                                }
				                            }

				                            // remove excluded filters


				                // display UI ?>
				                <a name="options_branding"></a>
				                <div class="meta-box-sortables metabox-holder">
				                    <div class="postbox">
				                        <div class="handlediv" title="Click to toggle"><br></div><h3 class="hndle"><span><?php _e('Filters', THEME_NAME); ?></span></h3>
				                        <div class="inside" style="display: none;">
				                            <table class="form-table">
				                                <tr>
				                                    <th style="font-weight: bold;">Content Filter</th>
				                                    <th style="font-weight: bold;">Disable for Content Type</th>
				                                </tr>
				                                <?php
				                                    foreach($_filters as $filter) {
				                                        if(
				                                            !preg_match("/run_shortcode/", $filter) &&
				                                            !preg_match("/autoembed/", $filter)
				                                        ) {
				                                            $row = array(
				                                                $filter,
				                                                $theme_settings_settings->settings_multicheck('disable_wp_content', $post_types, array(), $filter)
				                                            );
				                                            $theme_settings_settings->setting_row($row);
				                                        }
				                                    }
				                                ?>
				                            </table>
				                        </div>
				                    </div>
				                </div>
			<!--</div>
		</div>
	</div>-->
	<!--<div class="hr"></div>-->

	
	<div class="hr"></div>


	<a name="options_special"></a>
	<h3><?php _e('Special Features', THEME_NAME); ?></h3>
	<p><?php _e('The theme has optional settings for advanced functionality and effects. These can be configured as desired using the settings below.' ,THEME_NAME); ?></p>
	<!--<div class="meta-box-sortables metabox-holder">
		<div class="postbox">
			<div class="handlediv" title="Click to toggle"><br></div><h3 class="hndle"><span><?php _e('Options', THEME_NAME); ?></span></h3>
			<div class="inside" style="display: none;">-->
				<table class="form-table">
				<?php
					$field_set = array( 
						'all' => 'Full Page', 
						'content' => 'Content Area Only (middle)',
						'none' => 'Disabled'
					);
					$filed_comments = array(
						//'all' => 'The entire page will fade in quickly.', 
						//'content' => 'Only the content area in the middle of the page.',
						//'none' => 'Do not fade in page content.'
					);
					$comment = __('Page load effect. Not available on IE6-8.', THEME_NAME);
					$comment = $theme_settings_settings->format_comment($comment);
					$row = array(__('Fade In Page Content', THEME_NAME) . $comment, $theme_settings_settings->settings_radiobuttons('fade_in_content', $field_set, $filed_comments));
					$theme_settings_settings->setting_row($row);

					$field_set = array( 
						'all links' => 'All links', 
						'class' => 'Links with the class "tip"',
						'none' => 'Disabled'
					);
					$filed_comments = array(
						//'all links' => 'All links which contain a "title" attribute.', 
						//'class' => 'Only links you give the class "tip". This includes some default areas like icon shortcodes.',
						//'none' => 'Disable all tool tips.'
					);
					$comment = __('Enable tool tips.', THEME_NAME);
					$comment = $theme_settings_settings->format_comment($comment);
					$row = array(__('Tool tips', THEME_NAME) . $comment, $theme_settings_settings->settings_radiobuttons('tool_tips', $field_set, $filed_comments));
					$theme_settings_settings->setting_row($row);

				?>
				</table>
			<!--</div>
		</div>
	</div>
	<div class="hr"></div>-->





	<?php 
	// Developer theme options. These can be disabled from the theme "functions.php" by setting "$developer_options = false;"
	if ( $GLOBALS['developer_options'] === false) :		// ($ == false) default OFF, ($ === false) default ON 
	
		// Developer options disabled
		// --------------------------
		// to prevent losing the data field values must be inserted in a hidden field.	

		// developer fields
		echo $theme_settings_settings->settings_hidden('developer_custom_fields'); 
		echo $theme_settings_settings->settings_hidden('developer_custom_fields_access'); 
		echo $theme_settings_settings->settings_hidden('access_theme_design'); 
		// branding fields
		echo $theme_settings_settings->settings_hidden('branding_admin_logo'); 
		echo $theme_settings_settings->settings_hidden('branding_admin_help_tab_content'); 
		echo $theme_settings_settings->settings_hidden('branding_admin_custom_right_column_title'); 
		echo $theme_settings_settings->settings_hidden('branding_admin_custom_right_column'); 
		echo $theme_settings_settings->settings_hidden('branding_admin_right_column_theme_settings'); 
		echo $theme_settings_settings->settings_hidden('branding_admin_right_column_design_settings'); 
		
		
	else :

		echo	'<br />' .
				'<h2>'. __('Developer Features', THEME_NAME) .'</h2>' . 
				'<div class="hr"></div>';
				
		echo	'<p>'.__('The features below are provided for developers to customize the theme options panels as needed. This area can be hidden from users by setting <code>$developer_options = false;</code> in the file <code>function.php</code>.', THEME_NAME).'</p>';
	
	
		// Developer optons enabled
		// ------------------------	 ?>
		
		<a name="options_dev"></a>
		<h3><?php _e('Developer', THEME_NAME); ?></h3>
		<p><?php _e('Advanced options for admin permissions and theme setup. After making changes to these settings it may require an additional refresh of the page before you see the changes.' ,THEME_NAME); ?></p>
		<div class="meta-box-sortables metabox-holder">
			<div class="postbox">
				<div class="handlediv" title="Click to toggle"><br></div><h3 class="hndle"><span><?php _e('Developer Options', THEME_NAME); ?></span></h3>
				<div class="inside" style="display: none;">
					<table class="form-table">
					<?php
						$roles = $theme_settings_settings->get_roles();
	
						// Section title
						$warning =  __('<strong>WARNING</strong>: These options are for advanced users only. Changes made using the features in this area, or the tools they enable are your responsability. If you experience problems <u>no support will be provided</u>.', THEME_NAME);
						$warning = '<span class="warning">'. $theme_settings_settings->format_comment($warning) .'</span>';
						$row = array(__('<strong>Developer Tools</strong>', THEME_NAME), $warning);
						$theme_settings_settings->setting_row($row);
						
						$comment = __('Create and edit custom fields in posts and pages from your admin.', THEME_NAME);
						$comment = $theme_settings_settings->format_comment($comment);
						$row = array(__('Custom Fields Manager', THEME_NAME), $theme_settings_settings->settings_bool('developer_custom_fields', $keys) . $comment);
						$theme_settings_settings->setting_row($row);
		
							$comment = __('Minimum access level required. All roles above selection will also have access to Custom Fields Manager.', THEME_NAME);
							$comment = $theme_settings_settings->format_comment($comment);
							$row = array('', $theme_settings_settings->settings_radiobuttons('developer_custom_fields_access', $roles) . $comment);
							$theme_settings_settings->setting_row($row);
	
						/*$comment = __('Create and edit custom "post types" from your admin.', THEME_NAME);
						$comment = $theme_settings_settings->format_comment($comment);
						$row = array(__('Content Types Manager', THEME_NAME), $theme_settings_settings->settings_bool('developer_custom_content_types', $keys) . $comment);
						$theme_settings_settings->setting_row($row);
	
							$comment = __('Minimum access level required. All roles above selection will also have access to Content Types Manager.', THEME_NAME);
							$comment = $theme_settings_settings->format_comment($comment);
							$row = array('', $theme_settings_settings->settings_radiobuttons('developer_custom_content_types_access', $roles) . $comment);
							$theme_settings_settings->setting_row($row);
		
						$comment = __('Create and edit post taxonomies (categories, tags, etc.) from your admin.', THEME_NAME);
						$comment = $theme_settings_settings->format_comment($comment);
						$row = array(__('Taxonomies Manager', THEME_NAME), $theme_settings_settings->settings_bool('developer_custom_taxonomies', $keys) . $comment);
						$theme_settings_settings->setting_row($row);
	
							$comment = __('Minimum access level required. All roles above selection will also have access to Taxonomies Manager.', THEME_NAME);
							$comment = $theme_settings_settings->format_comment($comment);
							$row = array('', $theme_settings_settings->settings_radiobuttons('developer_custom_taxonomies_access', $roles) . $comment);
							$theme_settings_settings->setting_row($row);*/
	
						// Section title
						$row = array(__('<strong>User Permissions</strong>', THEME_NAME), '&nbsp;');
						$theme_settings_settings->setting_row($row);
	
						/*$comment = __('<code>Settings &raquo; Theme Settings</code><br />Roles allowed to manage theme settings.', THEME_NAME);
						$comment = $theme_settings_settings->format_comment($comment);
						$roles = $theme_settings_settings->get_roles();
						$row = array(__('Theme settings', THEME_NAME) . $comment, $theme_settings_settings->checkbox_list('access_theme_settings', $roles));
						$theme_settings_settings->setting_row($row);*/
	
						$comment = __('<code>Appearance &raquo; Design</code><br />Roles allowed to manage design and layout settings.', THEME_NAME);
						$comment = $theme_settings_settings->format_comment($comment);
						$comment_2 = __('Minimum access level required. All roles above selection will also have access.', THEME_NAME);
						$comment_2 = $theme_settings_settings->format_comment($comment_2);
						$row = array(__('Design settings', THEME_NAME) . $comment, $theme_settings_settings->settings_radiobuttons('access_theme_design', $roles) . $comment_2);
						$theme_settings_settings->setting_row($row);
					?>
					</table>
				</div>
			</div>
		</div>
		<div class="hr"></div>
	
	
		
		<a name="options_branding"></a>
		<h3><?php _e('Branding and Admin', THEME_NAME); ?></h3>
		<p><?php _e('Features to enable re-branding of theme options, help content, etc. After making changes to these settings it may require an additional refresh of the page before you see the changes.' ,THEME_NAME); ?></p>
		<div class="meta-box-sortables metabox-holder">
			<div class="postbox">
				<div class="handlediv" title="Click to toggle"><br></div><h3 class="hndle"><span><?php _e('Branding Options', THEME_NAME); ?></span></h3>
				<div class="inside" style="display: none;">
					<table class="form-table">
					<?php
						$comment = __('For branding the top right area of theme options pages.', THEME_NAME);
						$comment = $theme_settings_settings->format_comment($comment);
						$row = array(__('Theme Options Logo', THEME_NAME), $theme_settings_settings->settings_input('branding_admin_logo', $keys) . $comment);
						$theme_settings_settings->setting_row($row);
		
						//$comment = __('Replaces the  WordPress logo in the admin header.', THEME_NAME);
						//$comment = $theme_settings_settings->format_comment($comment);
						//$row = array(__('Admin Logo', THEME_NAME), $theme_settings_settings->settings_input('branding_admin_header_logo', $keys) . $comment);
						//$theme_settings_settings->setting_row($row);
	
						//$comment = __('The title of the "Theme Help" tab on the top right.', THEME_NAME);
						//$comment = $theme_settings_settings->format_comment($comment);
						//$row = array(__('Theme Help Tab - Title', THEME_NAME), $theme_settings_settings->settings_input('branding_admin_help_tab_title', $keys) . $comment);
						//$theme_settings_settings->setting_row($row);
	
						$comment = __('The content of the "Theme Help" tab on the top right. HTML is allowed.', THEME_NAME);
						$comment = $theme_settings_settings->format_comment($comment);
						$row = array(__('Theme Help Tab - Content', THEME_NAME), $theme_settings_settings->settings_textarea('branding_admin_help_tab_content', $keys) . $comment);
						$theme_settings_settings->setting_row($row);
	
						$comment = __('The title for an optional custom right column container for you to add your own information.', THEME_NAME);
						$comment = $theme_settings_settings->format_comment($comment);
						$row = array(__('Right container title', THEME_NAME), $theme_settings_settings->settings_input('branding_admin_custom_right_column_title', $keys) . $comment);
						$theme_settings_settings->setting_row($row);

						$comment = __('The content for an optional custom right column container for you to add your own information. HTML is allowed.', THEME_NAME);
						$comment = $theme_settings_settings->format_comment($comment);
						$row = array(__('Right container content', THEME_NAME), $theme_settings_settings->settings_textarea('branding_admin_custom_right_column', $keys) . $comment);
						$theme_settings_settings->setting_row($row);
						
						$comment = __('Do you want the default theme settings container to show in the right column?', THEME_NAME);
						$comment = $theme_settings_settings->format_comment($comment);
						$row = array(__('Show theme settings<br />(right column)', THEME_NAME), $theme_settings_settings->settings_bool('branding_admin_right_column_theme_settings', $keys) . $comment);
						$theme_settings_settings->setting_row($row);
						
						$comment = __('Do you want the default design settings container to show in the right column?', THEME_NAME);
						$comment = $theme_settings_settings->format_comment($comment);
						$row = array(__('Show design settings<br />(right column)', THEME_NAME), $theme_settings_settings->settings_bool('branding_admin_right_column_design_settings', $keys) . $comment);
						$theme_settings_settings->setting_row($row);
					?>
					</table>
				</div>
			</div>
		</div>
		<div class="hr"></div>

		<?php 
		
	endif; // developer otions on/off
			
	// export button
	if (!isset($importing)) {
		$options = array('navigation' => 'export', 'keys' => $keys, 'class' => 'button');
		echo '<div style="float: right;">' . $theme_settings_settings->settings_link(__('Export Settings', THEME_NAME), $options) . '</div>';
	}
	
	// save button
	$buttonLabel = (isset($importing)) ? __('Import Settings', THEME_NAME) : __('Save Settings', THEME_NAME);
	$theme_settings_settings->settings_save_button($buttonLabel, 'button-primary');	

	
	echo '<br /><br />';


// END - DEFAULT
break; }  
// END - switch ($theme_settings_settings->navigation) 

	//echo '<pre>';
	//print_r($theme_settings_settings->data);
	//echo '</pre>';

?>