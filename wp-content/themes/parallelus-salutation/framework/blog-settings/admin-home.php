<style type="text/css">
	form textarea.input-textarea { width: 100% !important; height: 200px !important; }
</style>
<?php
// FORCE THE KEYS - THIS IS IMPORTANT FOR SECTIONS WITH OPTIONS ON THE MAIN PAGE
//$blog_admin->keys = array('_plugin', 'blog_setting');

$keys = $blog_admin->keys;
$data = $blog_admin->data;

	if (!isset($importing)) {
		echo '<p>' . __('Configure the options below to set the default blog options for your site.' ,THEME_NAME) . '</p>';
	}


	$form_link = array('navigation' => 'blog_settings', 'action' => 'save', 'keys' => '_plugins,blog_settings', 'action_keys' => '_plugins,blog_settings');
	$blog_admin->settings_form_header($form_link);
	//$blog_admin->settings_form_header(array('action' => 'save', 'keys' => '_plugins,options', 'action_keys' => '_plugins,options'));
	
?>


	<a name="options_blog"></a>
	<h3><?php _e('Blog', THEME_NAME); ?></h3>
	<p><?php _e('Control the display of blog posts, post lists and the content of these pages.' ,THEME_NAME); ?></p>
	<!--<div class="meta-box-sortables metabox-holder">
		<div class="postbox">
			<div class="handlediv" title="Click to toggle"><br></div><h3 class="hndle"><span><?php _e('Options', THEME_NAME); ?></span></h3>
			<div class="inside" style="display: none;">-->
				<table class="form-table">
				<?php
					$comment = __('Include the author name in blog post list.', THEME_NAME);
					$comment = $blog_admin->format_comment($comment);
					$row = array(__('Show author name', THEME_NAME), $blog_admin->settings_bool('show_author_name', $keys) . $comment);
					$blog_admin->setting_row($row);

					$comment = __('Include the author avatar in blog post list.', THEME_NAME);
					$comment = $blog_admin->format_comment($comment);
					$row = array(__('Show author avatar', THEME_NAME), $blog_admin->settings_bool('show_author_avatar', $keys) . $comment);
					$blog_admin->setting_row($row);
					
					$comment = __('Include the posted date in blog post list.', THEME_NAME);
					$comment = $blog_admin->format_comment($comment);
					$row = array(__('Show post date', THEME_NAME), $blog_admin->settings_bool('show_post_date', $keys) . $comment);
					$blog_admin->setting_row($row);
			
					$comment = __('Include the comment count and a link to the form in blog posts.', THEME_NAME);
					$comment = $blog_admin->format_comment($comment);
					$row = array(__('Show comments link', THEME_NAME), $blog_admin->settings_bool('show_comments_link', $keys) . $comment);
					$blog_admin->setting_row($row);
					
					$comment = __('Include a list of categories for the post in the blog post list.', THEME_NAME);
					$comment = $blog_admin->format_comment($comment);
					$row = array(__('Show categories', THEME_NAME), $blog_admin->settings_bool('show_categories', $keys) . $comment);
					$blog_admin->setting_row($row);
					
					$comment = __('Include a list of tags for each post in its description.', THEME_NAME);
					$comment = $blog_admin->format_comment($comment);
					$row = array(__('Show tags', THEME_NAME), $blog_admin->settings_bool('show_tags', $keys) . $comment);
					$blog_admin->setting_row($row);
			
					$comment = __('Show featured image for each article on the blog page?', THEME_NAME);
					$comment = $blog_admin->format_comment($comment);
					$row = array(__('Images on blog lists', THEME_NAME), $blog_admin->settings_bool('blog_show_image', $keys) . $comment);
					$blog_admin->setting_row($row);
			
					$comment = __('Show featured image for current post on the single post page.', THEME_NAME);
					$comment = $blog_admin->format_comment($comment);
					$row = array(__('Featured image on post', THEME_NAME), $blog_admin->settings_bool('post_show_image', $keys) . $comment);
					$blog_admin->setting_row($row);
			
					$comment = __('The default post image width. This can also be set from the blog shortcode or in a single post.', THEME_NAME);
					$comment = $blog_admin->format_comment($comment);
					$row = array(__('Post image width', THEME_NAME), $blog_admin->settings_input('post_image_width', $keys) . $comment);
					$blog_admin->setting_row($row);
			
					$comment = __('The default post image height. This can also be set from the blog shortcode or in a single post.', THEME_NAME);
					$comment = $blog_admin->format_comment($comment);
					$row = array(__('Post image height', THEME_NAME), $blog_admin->settings_input('post_image_height', $keys) . $comment);
					$blog_admin->setting_row($row);
			
					$comment = __('Show content excerpts on your blog pages. Selecting "No" will display the full post in your post list.', THEME_NAME);
					$comment = $blog_admin->format_comment($comment);
					$row = array(__('Use post excerpts', THEME_NAME), $blog_admin->settings_bool('use_post_excerpt', $keys) . $comment);
					$blog_admin->setting_row($row);
			
					$comment = __('The number of words in post excerpts, 250 max. Custom excerpts are not restricted by this setting.', THEME_NAME);
					$comment = $blog_admin->format_comment($comment);
					$row = array(__('Post excerpt length', THEME_NAME), $blog_admin->settings_input('excerpt_length', $keys) . $comment);
					$blog_admin->setting_row($row);
			
					$comment = __('Optional link after post excerpts. Enter desired text for the link or for no link, leave blank or set to "-1".', THEME_NAME);
					$comment = $blog_admin->format_comment($comment);
					$row = array(__('"Read more..." link', THEME_NAME), $blog_admin->settings_input('read_more_text', $keys) . $comment);
					$blog_admin->setting_row($row);
				?>
				</table>
			<!--</div>
		</div>
	</div>-->
	<div class="hr"></div>
	
	<?php
	// key for this data type is generated at random when adding new slides.
	$key = is_array($blog_admin->get_val('key'))? '' : $blog_admin->get_val('key');
	echo '<input type="hidden" name="key" value="'. $key .'" />'; // Normal way causes error --> $blog_admin->settings_hidden('index'); 

	// save button
	$blog_admin->settings_save_button(__('Save Settings', THEME_NAME), 'button-primary');
	
	$options = array('navigation' => 'export', 'keys' => '_plugin,blog_setting', 'class' => 'button');
	echo '<br /><div>' . $blog_admin->settings_link(__('Export Blog Settings', THEME_NAME), $options) . '</div><br />';

	?>
	
	<br /><br />
