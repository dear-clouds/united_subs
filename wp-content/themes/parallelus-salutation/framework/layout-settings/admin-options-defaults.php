<style type="text/css">
	form textarea.input-textarea { width: 100% !important; height: 200px !important; }
</style>
<?php

$keys = $layout_admin->keys;
$data = $layout_admin->data;

// Setup defaults from other areas
// ----------------------------------------

// Header drop down data
$page_headers = $layout_admin->get_val('page_headers', '_plugin');
$page_headers_saved = $layout_admin->get_val('page_headers', '_plugin_saved');
if (!empty($page_headers_saved)) {
	$page_headers = array_merge((array)$page_headers_saved, (array)$page_headers);
}

// Footer drop down data
$page_footers = $layout_admin->get_val('page_footers', '_plugin');
$page_footers_saved = $layout_admin->get_val('page_footers', '_plugin_saved');
if (!empty($page_footers_saved)) {
	$page_footers = array_merge((array)$page_footers_saved, (array)$page_footers);
}

// Page layout drop down data
$page_layouts = $layout_admin->get_val('layouts', '_plugin');
$page_layouts_saved = $layout_admin->get_val('layouts', '_plugin_saved');
if (!empty($page_layouts_saved)) {
	$page_layouts = array_merge((array)$page_layouts_saved, (array)$page_layouts);
}

// Assemble the drop down options for each
$select_header = array();
if (!empty($page_headers)) {
	foreach ((array) $page_headers as $item) {
		if (!empty($item)) $select_header[$item['key']] = $item['label'];
	}
}
$select_footer = array();
if (!empty($page_footers)) {
	foreach ((array) $page_footers as $item) {
		if (!empty($item)) $select_footer[$item['key']] = $item['label'];
	}
}
$select_layout = array();
if (!empty($page_layouts)) {
	foreach ((array) $page_layouts as $item) {
		if (!empty($item)) $select_layout[$item['key']] = $item['label'];
	}
}

// DEFAULT DESIGN SETTINGS

	// FORCE THE KEYS - THIS IS IMPORTANT FOR SECTIONS WITH OPTIONS ON THE MAIN PAGE
	$layout_admin->keys = array('_plugin', 'layout_settings');
	
	echo	'<h2>'. __('Layout &amp; Template Defaults', THEME_NAME) .'</h2>' . 
			'<div class="hr"></div>' .
			'<p>' . __('Configure the themes default layout options.', THEME_NAME) . '</p>';

	$form_link = array('navigation' => 'layout_settings', 'action' => 'save', 'keys' => '_plugins,layout_settings', 'action_keys' => '_plugins,layout_settings');
	$layout_admin->settings_form_header($form_link);

	echo '<a name="layouts"></a>';
	echo '<table class="form-table">';

		$select = $select_header;
		$comment = __('This header will be used for layouts without a header specified.', THEME_NAME);
		$comment = $layout_admin->format_comment($comment);
		$row = array(__('Header', THEME_NAME), $layout_admin->settings_select('layout,header', $select) . $comment);
		$layout_admin->setting_row($row);

		$select = $select_footer;
		$comment = __('This footer will be used for layouts without a footer specified.', THEME_NAME);
		$comment = $layout_admin->format_comment($comment);
		$row = array(__('Footer', THEME_NAME), $layout_admin->settings_select('layout,footer', $select) . $comment);
		$layout_admin->setting_row($row);

		$select = $select_layout;
		$comment = __('This layout will be used for any content without a layout specified.', THEME_NAME);
		$comment = $layout_admin->format_comment($comment);
		$row = array(__('Main Layout', THEME_NAME), $layout_admin->settings_select('layout,default', $select) . $comment);
		$layout_admin->setting_row($row);

	echo '</table>';
	
	echo '<div class="hr"></div> <h3>'. __('Templates', THEME_NAME) .'</h3>';
	echo '<table class="form-table">';

		// Home page
		$select = $select_layout;
		$comment = __('The default layout to use for the home page of the site.', THEME_NAME);
		$comment = $layout_admin->format_comment($comment);
		$row = array(__('Home page', THEME_NAME), $layout_admin->settings_select('layout,home', $select) . $comment);
		$layout_admin->setting_row($row);

		// Pages
		$select = $select_layout;
		$comment = __('The default layout to use for new pages.', THEME_NAME);
		$comment = $layout_admin->format_comment($comment);
		$row = array(__('Pages', THEME_NAME), $layout_admin->settings_select('layout,page', $select) . $comment);
		$layout_admin->setting_row($row);

		// Posts
		$select = $select_layout;
		$comment = __('The default layout to use for new posts.', THEME_NAME);
		$comment = $layout_admin->format_comment($comment);
		$row = array(__('Posts', THEME_NAME), $layout_admin->settings_select('layout,post', $select) . $comment);
		$layout_admin->setting_row($row);

		// Blog
		$blog_select = $select_layout;
		$blog_comment = __('This is the WordPress version of a "blog page". Used when a category, author, or date is queried. Note that this layout will be overridden by selections for "Category", "Author", "Tag" and "Date" for their respective query types.', THEME_NAME);
		$blog_comment = $layout_admin->format_comment($blog_comment);
	
			$select = $select_layout;
			array_unshift($select, __('Category (optional)', THEME_NAME)); // add blank value to start (this option can have a "none" setting)
			$comment = __('<strong>Category layout:</strong> Used when a category is queried. Typically the same layout as "Blog".', THEME_NAME);
			$comment = $layout_admin->format_comment($comment);
			$category_row = '<br />' . $layout_admin->settings_select('layout,category', $select) . $comment;
	
			$select = $select_layout;
			array_unshift($select, __('Author (optional)', THEME_NAME)); // add blank value to start (this option can have a "none" setting)
			$comment = __('<strong>Author layout:</strong> Used when posts for a specific author are queried. Typically the same layout as "Blog".', THEME_NAME);
			$comment = $layout_admin->format_comment($comment);
			$author_row = '<br />' . $layout_admin->settings_select('layout,author', $select) . $comment;
	
			$select = $select_layout;
			array_unshift($select, __('Tag (optional)', THEME_NAME)); // add blank value to start (this option can have a "none" setting)
			$comment = __('<strong>Tag layout:</strong> Used when a tag is queried. Typically the same layout as "Blog".', THEME_NAME);
			$comment = $layout_admin->format_comment($comment);
			$tag_row = '<br />' . $layout_admin->settings_select('layout,tag', $select) . $comment;
	
			$select = $select_layout;
			array_unshift($select, __('Date (optional)', THEME_NAME)); // add blank value to start (this option can have a "none" setting)
			$comment = __('<strong>Date layout:</strong> Used when posts for a specific date or time are queried. Typically the same layout as "Blog".', THEME_NAME);
			$comment = $layout_admin->format_comment($comment);
			$date_row = '<br />' . $layout_admin->settings_select('layout,date', $select) . $comment;
		
			// Output completed blog row
			$row = array(__('Blog', THEME_NAME), $layout_admin->settings_select('layout,blog', $blog_select) . $blog_comment . $category_row . $author_row . $tag_row . $date_row);
			$layout_admin->setting_row($row); 
		

		// Search
		$select = $select_layout;
		$comment = __('The layout to use for search results.', THEME_NAME);
		$comment = $layout_admin->format_comment($comment);
		$row = array(__('Search', THEME_NAME), $layout_admin->settings_select('layout,search', $select) . $comment);
		$layout_admin->setting_row($row);

		// Error
		$select = $select_layout;
		$comment = __('The layout to use for error pages.', THEME_NAME);
		$comment = $layout_admin->format_comment($comment);
		$row = array(__('Error', THEME_NAME), $layout_admin->settings_select('layout,error', $select) . $comment);
		$layout_admin->setting_row($row);


		// BuddyPress layouts
		if (bp_plugin_is_active()) {

			$BP_select = $select_layout;
			$BP_comment = __('The default layout for your BuddyPress pages.', THEME_NAME);
			$BP_comment = $layout_admin->format_comment($BP_comment);
		
				$select = $select_layout;
				array_unshift($select, __('Activity (optional)', THEME_NAME)); // add blank value to start (this option can have a "none" setting)
				$comment = __('<strong>Activity</strong>', THEME_NAME);
				$comment = $layout_admin->format_comment($comment);
				$bp_activity_row = '<br />' . $layout_admin->settings_select('layout,bp-activity', $select) . $comment;
		
				$select = $select_layout;
				array_unshift($select, __('Blogs (optional)', THEME_NAME)); // add blank value to start (this option can have a "none" setting)
				$comment = __('<strong>Blogs</strong>', THEME_NAME);
				$comment = $layout_admin->format_comment($comment);
				$bp_blogs_row = '<br />' . $layout_admin->settings_select('layout,bp-blogs', $select) . $comment;
		
				$select = $select_layout;
				array_unshift($select, __('Forums (optional)', THEME_NAME)); // add blank value to start (this option can have a "none" setting)
				$comment = __('<strong>Forums</strong>', THEME_NAME);
				$comment = $layout_admin->format_comment($comment);
				$bp_forums_row = '<br />' . $layout_admin->settings_select('layout,bp-forums', $select) . $comment;
		
				$select = $select_layout;
				array_unshift($select, __('Groups (optional)', THEME_NAME)); // add blank value to start (this option can have a "none" setting)
				$comment = __('<strong>Groups</strong>', THEME_NAME);
				$comment = $layout_admin->format_comment($comment);
				$bp_groups_row = '<br />' . $layout_admin->settings_select('layout,bp-groups', $select) . $comment;
				
				$select = $select_layout;
				array_unshift($select, __('Groups - single (optional)', THEME_NAME)); // add blank value to start (this option can have a "none" setting)
				$comment = __('<strong>Groups - single</strong>', THEME_NAME);
				$comment = $layout_admin->format_comment($comment);
				$bp_groups_single_row = '<br />' . $layout_admin->settings_select('layout,bp-groups-single', $select) . $comment;
				
				$select = $select_layout;
				array_unshift($select, __('Groups - single plugins (optional)', THEME_NAME)); // add blank value to start (this option can have a "none" setting)
				$comment = __('<strong>Groups - single plugins</strong>', THEME_NAME);
				$comment = $layout_admin->format_comment($comment);
				$bp_groups_single_plugins_row = '<br />' . $layout_admin->settings_select('layout,bp-groups-single-plugins', $select) . $comment;
				
				$select = $select_layout;
				array_unshift($select, __('Members (optional)', THEME_NAME)); // add blank value to start (this option can have a "none" setting)
				$comment = __('<strong>Members</strong>', THEME_NAME);
				$comment = $layout_admin->format_comment($comment);
				$bp_members_row = '<br />' . $layout_admin->settings_select('layout,bp-members', $select) . $comment;

				$select = $select_layout;
				array_unshift($select, __('Members - single (optional)', THEME_NAME)); // add blank value to start (this option can have a "none" setting)
				$comment = __('<strong>Members - single</strong>', THEME_NAME);
				$comment = $layout_admin->format_comment($comment);
				$bp_members_single_row = '<br />' . $layout_admin->settings_select('layout,bp-members-single', $select) . $comment;
				
				$select = $select_layout;
				array_unshift($select, __('Members - single plugins (optional)', THEME_NAME)); // add blank value to start (this option can have a "none" setting)
				$comment = __('<strong>Members - single plugins</strong>', THEME_NAME);
				$comment = $layout_admin->format_comment($comment);
				$bp_members_single_plugins_row = '<br />' . $layout_admin->settings_select('layout,bp-members-single-plugins', $select) . $comment;
				
				//$bp_members_single_plugins_row = $layout_admin->settings_hidden('layout,bp-members-single-plugins');
				
				// Output completed blog row
				$row = array(__('BuddyPress', THEME_NAME), $layout_admin->settings_select('layout,bp', $BP_select) . $BP_comment . $bp_activity_row . $bp_blogs_row . $bp_forums_row . $bp_groups_row . $bp_groups_single_row . $bp_groups_single_plugins_row . $bp_members_row . $bp_members_single_row . $bp_members_single_plugins_row );
				$layout_admin->setting_row($row); 

		}  // end BuddyPress layouts

		// bbPress layouts
		if (bbPress_plugin_is_active()) {

			$BBP_select = $select_layout;
			$BBP_comment = __('The default layout for your bbPress forum and topic pages.', THEME_NAME);
			$BBP_comment = $layout_admin->format_comment($BBP_comment);

				array_unshift($select, __('Topic (optional)', THEME_NAME)); // add blank value to start (this option can have a "none" setting)
				$comment = __('<strong>Topic</strong>', THEME_NAME);
				$comment = $layout_admin->format_comment($comment);
				$bbp_topic_row = '<br />' . $layout_admin->settings_select('layout,bbp_topic', $select) . $comment;

				/*
				$select = $select_layout;
				array_unshift($select, __('Reply (optional)', THEME_NAME)); // add blank value to start (this option can have a "none" setting)
				$comment = __('<strong>Reply</strong>', THEME_NAME);
				$comment = $layout_admin->format_comment($comment);
				$bbp_reply_row = '<br />' . $layout_admin->settings_select('layout,bbp_reply', $select) . $comment;
				*/

				// Output completed blog row
				// $row = array(__('bbPress', THEME_NAME), $layout_admin->settings_select('layout,bbpress', $BBP_select) . $BBP_comment . $bbp_topic_row . $bbp_reply_row );
				$row = array(__('bbPress', THEME_NAME), $layout_admin->settings_select('layout,bbpress', $BBP_select) . $BBP_comment . $bbp_topic_row );
				$layout_admin->setting_row($row); 
		}

		echo '</table>';


		// ==========================================
		// Custom layout context 
		// ==========================================

		// These are created by registering a context using the "register_context()"" function. For reference see the function notes in the file "framework/theme-functions/template-engine.php"

		// Default, this is so we don't duplicate
		$default_context_list = array(
			'header',
			'footer',
			'default',
			'home',
			'page',
			'post',
			'category',
			'author',
			'tag',
			'date',
			'blog',
			'search',
			'error',
			'bp',
			'bp-activity',
			'bp-blogs',
			'bp-forums',
			'bp-groups',
			'bp-groups-single',
			'bp-groups-single-plugins',
			'bp-members',
			'bp-members-single',
			'bp-members-single-plugins',
			'bbpress',
			'bbp_topic',
			'bbp_reply' );

		// These are some contexts that might be in the theme or for one or another reason just needs to be skipped
		$ignore_context_list = array(
			'static_block' );

		if (bbPress_plugin_is_active()) {
			// These are kind of generic names so we only add them to the ignore list IF bbPress is installed
			$ignore_context_list[] = 'forum';
			$ignore_context_list[] = 'topic';
			$ignore_context_list[] = 'reply';
		}

		// The list we get from the saved global array
		$custom_context_list = $GLOBALS['master_context_list'];


		// Manually registered context/layouts
		// ---------------------------------------


		// get an array of manually registered contexts after subtracting all defaults and ignored context values
		$manual_context_list = array_flip(array_diff((array)array_flip(isset($custom_context_list['manual'])? (array) $custom_context_list['manual'] : array()), $default_context_list, $ignore_context_list));

		if ( !empty($manual_context_list) ) {
			
			echo '<div class="hr"></div> <h3>'. __('Registered Template Files', THEME_NAME) .'</h3>';
			echo '<p>' . __('Layouts registered manually using the <code>register_context()</code> function for template files.', THEME_NAME) . '</p>';

			echo '<table class="form-table">';
			// Manually registered context/layouts (usually done by the user)
			foreach ($manual_context_list as $context => $name) {
				
				// Skip anything that might be a duplicate of a default
				if (!in_array($context, $default_context_list) && !in_array($context, $ignore_context_list) && $context) {

					// Output the select for the template
					$select = $select_layout;
					$comment = __($name, THEME_NAME);
					$comment = $layout_admin->format_comment($comment);
					$row = array(__($name, THEME_NAME), $layout_admin->settings_select('layout,'.$context, $select) . $comment);
					$layout_admin->setting_row($row);

				}
			}
			echo '</table>';
		}

		echo '<div class="hr"></div>';
		echo '<p>' . __('To manually register a template file you can use the <code>register_context()</code> function. To do this add an entry to your <code>functions.php</code> file.', THEME_NAME) . '</p>';
		echo '<p>' . __('Below is an example usage of how you might register a custom layout for a "news" category file. After you create a category with the slug "news" and add a file to the theme folder named <code>category-news.php</code> you would copy the following to your <code>functions.php</code> file.', THEME_NAME) . '</p>';
		echo '<pre class="code" style="background: #F3F3F3; color: #333; padding: 10px; font-size: 11px; border: 1px solid #EAEAEA; }">'.
			 '// Register custom template file for layout settings'. PHP_EOL .
			 '// -------------------------------------------------'. PHP_EOL .
			 ' '. PHP_EOL .
			 '$news_template = locate_template(\'category-news.php\'); // returns full path of file in theme folder'. PHP_EOL .
			 'register_context( \'News Category\', \'category_news\', $news_template); // $name, $context, $template_file</pre>';
		echo '<br><p>' . __('<strong>Note:</strong> For more detailed documentation of this function, see the notes in the theme file "framework/theme-functions/template-engine.php"', THEME_NAME) . '</p>';


		// Auto registered context/layouts (these might be from plugins, found by searching the WP post type object)
		// ---------------------------------------

		// get an array of manually registered contexts after subtracting all defaults and ignored context values
		$auto_context_list = array_flip(array_diff((array) array_flip((array) $custom_context_list['auto']), $default_context_list, $ignore_context_list));

		if ( !empty($auto_context_list) ) {

			echo '<div class="hr"></div> <h3>'. __('Custom Post Types (auto generated)', THEME_NAME) .'</h3>';
			echo '<p>' . __('The following layouts were generated from the WP Custom Post Type object. They may not apply as some post types do not have public facing template files or may use overload methods for inserting content or shortcodes instead. Setting the values below can allow a custom post type to have the theme specific layout applied but not always.', THEME_NAME) . '</p>';

			echo '<p class="warning"><em>' . __('These settings may not apply depending on the method of inserting content used by the plugin author.', THEME_NAME) . '</em></p>';

			echo '<table class="form-table">';

			foreach ($auto_context_list as $context => $name) {
				
				// Skip anything that might be a duplicate of a default or in the ignore list
				if (!in_array($context, $default_context_list) && !in_array($context, $ignore_context_list) && $context) {

					// Output the select for the template
					$select = $select_layout;
					$comment = __($name, THEME_NAME);
					$comment = $layout_admin->format_comment($comment);
					$row = array(__($name, THEME_NAME), $layout_admin->settings_select('layout,'.$context, $select) . $comment);
					$layout_admin->setting_row($row);

				}
			}
			echo '</table>';
		}


	echo '<div class="hr"></div>';

	// key for this data type is generated at random when adding new slides.
	echo '<input type="hidden" name="key" value="'. $layout_admin->get_val('key') .'" />'; // Normal way causes error --> $layout_admin->settings_hidden('index'); 

	// save button
	$layout_admin->settings_save_button(__('Save Settings', THEME_NAME), 'button-primary');
	
	$options = array('navigation' => 'export', 'keys' => '_plugin,layout_settings', 'class' => 'button');
	echo '<br /><div>' . $layout_admin->settings_link(__('Export Layout Settings', THEME_NAME), $options) . '</div><br />';
	

	?>
	<br /><br />


	
	<script type="text/javascript">
	
	jQuery(document).ready(function($) {
		
		// show/hide custom skin input
		jQuery("select[name='skin']").change( function() {
			var $custom = jQuery("#custom_skin_input");
			if (jQuery(this).val() == 'custom') {
				$custom.slideDown();
			} else {
				$custom.slideUp();
			}
		});
		
		// show/hide custom heading font
		jQuery("select[name='fonts,heading']").change( function() {
			var $custom_cufon = jQuery("#heading_cufon");
			var $custom_standard = jQuery("#heading_standard");

			if (jQuery(this).val() == 'custom:cufon') {
				$custom_cufon.slideDown();
			} else {
				$custom_cufon.slideUp();
			}

			if (jQuery(this).val() == 'custom:standard') {
				$custom_standard.slideDown();
			} else {
				$custom_standard.slideUp();
			}
		});
		
		// show/hide custom body font
		jQuery("select[name='fonts,body']").change( function() {
			var $custom = jQuery("#custom_body_font");
			if (jQuery(this).val() == 'custom:standard') {
				$custom.slideDown();
			} else {
				$custom.slideUp();
			}
		});


	});
	
	</script> 
