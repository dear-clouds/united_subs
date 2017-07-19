<?php

class content_fields_admin extends framework_admin_object_ambassador_1 {

	// Add hooks & crooks
	function add_actions() {
		add_action('admin_head-settings_page_' . $this->slug, array(&$this, 'js_for_fields'));	
		add_action('admin_head-post-new.php', array(&$this, 'add_css'));	
		add_action('admin_head-post.php', array(&$this, 'add_css'));	
		add_action('admin_head-page-new.php', array(&$this, 'add_css'));	
		add_action('admin_head-page.php', array(&$this, 'add_css'));
		
		// Save the meta keys
	 	add_action('save_post', array(&$this, 'save_post_meta'), 11, 2);
		add_action('save_page', array(&$this, 'save_post_meta'), 11, 2);
		
		// Add our rewrite rules
		add_filter('rewrite_rules_array', array(&$this, 'rewrite_rules_array'), 10, 1);


		add_action('wp_ajax_content_fields_file_list', array(&$this, 'axaj_file_list'));
		add_filter('content_fields_write_css', 'content_fields_write_css');
		add_filter('content_fields_write_js', 'content_fields_write_js');
		
		// Check theme settings for menu visibility and permissions
		global $theme_settings;
		if (is_object($theme_settings)) {
			
			$themeSettings = $theme_settings->get_objects(array('_plugin'));
			
			// Hide menu if disabled
			$menuEnabled = isset($themeSettings['options']['developer_custom_fields'])? $themeSettings['options']['developer_custom_fields'] : 0;
			if ($menuEnabled == 0) { // ($ == 0) default OFF, ($ === 0) default ON
				$this->menu_url = 'disabled';
			}

			// Check menu permission settings
			$menuPermissions = isset($themeSettings['options']['developer']['custom_fields_access'])? $themeSettings['options']['developer']['custom_fields_access'] : '';
			switch ($menuPermissions) {
				case 'subscriber':
					$this->menu_permissions = 0;
					break;	
				case 'contributor':
					$this->menu_permissions = 1;					
					break;	
				case 'author':
					$this->menu_permissions = 2;
					break;	
				case 'editor':
					$this->menu_permissions = 5;
					break;	
				default: //administrator (default, already set to this)
					//$this->menu_permissions = 'manage_options';
			}

		}


	}

	function after_settings_init() {
		global $wp_rewrite;

		// Flush the rewrite rules if we're saving
		if ($this->action == 'save') {
			$wp_rewrite->flush_rules();
		}
   	}

	function axaj_file_list() {
		$post_id = esc_attr($_POST['post_id']);
		$attachments['data'] = get_children( array( 'post_parent' => $post_id, 'post_type' => 'attachment', 'orderby' => 'menu_order ASC, ID', 'order' => 'DESC') );
		$attachments['clicked'] = esc_attr($_POST['clicked']);
		echo json_encode($attachments);
		die();
	}
	
	/*
	**
	**
	*/
	function add_css() {
		$css = apply_filters('content_fields_write_css', '');
		$js = apply_filters('content_fields_write_js', '');
		?>
		<script type="text/javascript">
		//<![CDATA[
			jQuery(document).ready(function($){
				$(".mf_update_on_edit").change(function() {
					var val = $(this).val();
					$(this).next().html(val);
				});
				<?php echo $js; ?>
			});
		//]]>
		</script>
		<style type="text/css">
			<?php echo $css; ?>
		</style>
		<?php
	}
	/*
	**
	**
	*/
	function js_for_fields () {
		global $content_fields;
		$js = array();
		foreach ($content_fields->field_types as $key => $field) {
			if ($field['values']) $js[] = "(val == '$key')";
		}
		$jsq = implode(' || ', $js);
		?>
		<script type="text/javascript">
		//<![CDATA[
			jQuery(document).ready(function($){
				var val = $("input[name=field_type]").val();
				if (<?php echo $jsq; ?>) $('input[name=values]').removeAttr("disabled");
				else $('input[name=values]').attr("disabled", true);			
				$("input[name=field_type]").change(function() {
					var val = $(this).val();
					if (<?php echo $jsq; ?>) $('input[name=values]').removeAttr("disabled");
					else $('input[name=values]').attr("disabled", true);
				});
				// Update field on changes
				$(".mf_update_on_edit").change(function() {
					alert('suerk');
				});
			});
		//]]>
		</script>
		<?php
	
	}
	
	/*
	**
	**
	*/
	function get_field_types_select() {
		global $content_fields;
		$ret = array();
		foreach ($content_fields->field_types as $key => $type)
			$ret[$key] = $type['label'];
		return $ret;
	}
	
	/*
	**
	**
	*/
	function get_field_types_comments() {
		global $content_fields;
		$ret = array();
		foreach ($content_fields->field_types as $key => $type)
			$ret[$key] = $type['comment'];
		return $ret;
	
	}
	
	/*
	**
	**
	*/
	function validate_sumbission() {
		if ($this->navigation == 'boxes') {
			if ($this->action == 'save') {
				if (!$_POST) return true;
				// These are the field we are saving.
				$this->fields = array(
					'var' => array('label', 'position'),
					'array' => array('fields', 'more_access_cap', 'post_types'),
				);
				// Validate
				if (!($name = esc_attr($_POST['label']))) {
					$this->set_navigation('box');
					return $this->error(__('Your box needs a title!', 'more-plugins'));
				}
				$name = sanitize_title($name);
				//$this->action_keys = array($name);
				$_POST['index'] = $name;
			}
		}
		// BOXES
		if ($this->navigation == 'box') {

			if ($this->action == 'save') {
				if (!$_POST) return false;
				$this->fields = array(
					'var' => array('label', 'key', 'slug', 'field_type', 'values', 'caption'),
					'array' => array(),
				);
				// Save all level 2 data in 'fields'.
				if (!($name = esc_attr($_POST['label']))) {
					$this->set_navigation('field');
					return $this->error(__('You need a name for the field!', 'more-plugins')); 
				}
				if (!esc_attr($_POST['key'])) {
					$this->set_navigation('field');
					return $this->error(__('You need to specify a custom field key for the field!', 'more-plugins')); 
				}
				$name = sanitize_title($name);
				$_POST['index'] = $name;
//				if (strpos($_POST['action_keys']) $_POST[])
				// $this->action_keys = array($this->keys[1], 'fields', $name);
			}
			if ($this->action == 'add') {
				$this->default = array('position' => 'left', 'post_types' => array('post'));
			}
		}
		if ($this->navigation == 'field') {
			if ($this->action == 'add') {
				$this->default = array('field_type' => 'text');
			}

		}
		return true;
	}
	function load_objects () {
		global $content_fields;
		$this->data = $content_fields->load_objects();
//		if ($this->action != 'add') $this->data = $data; //$content_fields->get_data();
		return $this->data;
	}

	/*
	**	save_post_meta()
	**
	*/
	function save_post_meta($new_post_id, $post) {
	    global $wpdb, $post, $content_fields;

		// Ignore autosaves, ignore quick saves
		if (@constant( 'DOING_AUTOSAVE')) return $post;
		if (!$_POST) return $post;
		if (!in_array($_POST['action'], array('editpost', 'post'))) return $post;


		$post_id = esc_attr($_POST['post_ID']);
		if (!$post_id) $post_id = $new_post_id;
		if (!$post_id) return $post;
		
		// Make sure we're saving the correct version
		if ( $p = wp_is_post_revision($post_id)) $post_id = $p;
		
		$boxes = $content_fields->get_objects(array('_plugin_saved', '_plugin'));

		// Watch me being very defensive.
		// foreach ($ids as $post_id) {
		foreach ($boxes as $box) {
			foreach((array) $box['fields'] as $field) {
				$key = $field['key'];
				$post_key = sanitize_title($key);
				$meta_data = get_post_custom($post_id);
				// Ok, must do this since an unticked checkbox does not appear in $_POST;
				if (array_key_exists($post_key, (array) $_POST) || array_key_exists($key, (array) $meta_data)) {
					$value = isset($_POST[$post_key])? stripslashes($_POST[$post_key]) : '';
					$stored_value = isset($meta_data[$key][0])? $meta_data[$key][0] : '';
						if ($value || (!$value && get_post_meta($post_id, $key, true))) {
						if ($value != get_post_meta($post_id, $key, true))  {
							if ($field['field_type'] == 'wysiwyg') $value = wpautop($value);
							if (!add_post_meta($post_id, $key, $value, true)) 
								update_post_meta($post_id, $key, $value);	
						}
					}
				}
			}	
		}
		// }
		// exit();
		return $post;
	}
	
	/*
	**	after_request_handler()
	
		Handles cross-functionality between More Types and More Fields - any changes
		made here are reflected in the More Types admin too.
	*/
	function after_request_handler() {
		global $content_fields, $more_types_settings;

		if ($this->action == 'get_file_list') {
			$post_id = esc_attr($_GET['post_id']);
			$attachments['data'] = get_children( array( 'post_parent' => $post_id, 'post_type' => 'attachment', 'orderby' => 'menu_order ASC, ID', 'order' => 'DESC') );
			$attachments['clicked'] = esc_attr($_GET['clicked']);
			echo maybe_serialize($attachments);
			exit();
		}
		if ($this->action == 'save') {	
			if (is_callable(array($more_types_settings, 'update_from_more_plugin')))
				$more_types_settings->update_from_more_plugin($content_fields, 'post_types', 'boxes');

		}
	}
	
	/*
	**	build_box_gut()

		This function builds the inside of a box, based on the field types, as
		defined in more-fields-field-types.php.

	*/
	function build_box_gut($box) {
		global $content_fields, $content_fields_settings;
		do_action('mf_box_head', $box);

		foreach ((array) $box['fields'] as $field) {
			if (!($field = apply_filters('mf_field', $field))) continue;

			$title = '<label class="mf_label" for="' . $field['key'] . '">' . $field['label'] . ':</label>';
			
 			echo '<div class="mf_field_wrapper mf_field_' . $field['key'] .' ' . (isset($field['type'])? $field['type'] : '') . '">';
			if (isset($field['title']) && $field['title'] && $field['type'] != 'checkbox') echo $title;


			$type = $content_fields->field_types[$field['field_type']];
			if (!$type) return false;
	
			// Parse out the values, including ascending and descending ranges
			$values = array();
			$parts = explode(',', $field['values']);

			// Add empty option at top for select lists

			if ($field['field_type'] == 'select') $values[] = '- Select -';
			
			// custom fields for theme specific settings
			preg_match('/\[\[(.*?)\]\]/', $field['values'], $matches);
			if (isset($matches[1]) && $matches[1]) {
				// this is one of our special cases... store the data from saved theme options to the values array
				//$design_data = $design_settings->get_objects(array('_plugin_saved', '_plugin'));
				$value_keys = array(); // this is for setting the option "value" instead of just using the name
				// determine where to get the data...
				if ($matches[1] == 'skins') {
					// look up the skins
					$skins = $content_fields_settings->get_skin_css();
					asort($skins);
					$themeOptions = $skins;
					foreach ($themeOptions as $key => $value) {
						$values[] = $value;							// the option name 
						$value_keys[$value] = $key;					// the option value
					}
				} else {
					// this is a theme option, just return array
					$themeOptions = get_theme_var($matches[1]); //$design_data[$matches[1]];
					foreach ($themeOptions as $item) {
						$values[] = $item['label'];					// the option name 
						$value_keys[$item['label']] = $item['key'];	// the option value
					}
				}
				$field['val_keys'] = $value_keys;
			// the standard fields (not theme specific)
			} else {
				// Not theme specific, do default parsing of values
				foreach ((array) $parts as $part) {
					$range = explode(':', $part);
					if (count($range) == 2) {
						if ($range[0] < $range[1]) {
							for ($j = $range[0]; $j <= $range[1]; $j++)
								$values[] = $j;
						} else {
							for ($j = $range[0]; $j >= $range[1]; $j--)
								$values[] = $j;
						}
					} else $values[] = $part;
				}
			}
			$field['vals'] = $values;
			// Get the closed boxes
			//$post_type = sanitize_title($this->get_type());
			//$hidden = (array) get_user_option("meta-box-hidden_${post_type}", 0, false );
			//$box_is_hidden = (in_array(sanitize_title($box['name']), $hidden));

			// Write the field
			if(isset($type['html_before']))
				echo $this->field_type_render($type['html_before'], $field, $box['position']);		
			if (empty($values)) echo $this->field_type_render($type['html_item'], $field, $box['position']);
			else {
				foreach ($values as $v) {
				
					// If there is a range but no item template (e.g. html5 range)
					if (!$type['html_item']) continue;
				
					echo $this->field_type_render($type['html_item'], $field, $box['position'], rtrim(ltrim($v)), (isset($type['html_selected'])? $type['html_selected'] : ''));
				}
			}

			if (isset($type['actions']) && ($actions = $type['actions'])) {
				foreach ($actions as $action => $args) {

					// Render the arguments
					$rendered = array();
					foreach ($args as $arg) $rendered[] = $this->field_type_render($arg, $field, $box['position']);
					// Do the action
					if (!count($args)) do_action($action);
					else if (count($args) == 1) do_action($action, $rendered[0]);
					else if (count($args) == 2) do_action($action, $rendered[0], $rendered[1]);
					else if (count($args) == 3) do_action($action, $rendered[0], $rendered[1], $rendered[2]);			
				}
			}
			//do_action($action);
			
			if(isset($type['html_after']))
				echo $this->field_type_render($type['html_after'], $field, $box['position']);			
			
			// Add caption to field
			// if ($f = html_entity_decode($field['caption'])) echo "<em class='mf_caption'>$f</em>";


			echo '</div>';
			do_action('mf_box_foot', $box);
		}
	}
	
	/*
	**	field_type_render()
	
		Renders the template format in more-fields-field-types.php.
	
	*/
	function field_type_render ($html, $field, $position, $value_raw = '', $html_selected = '') {
		global $post;

		$value_stored = (get_post_meta($post->ID, $field['key'], true));
		if (!$value_raw) $value_raw = $value_stored;
		$value = (strstr($value_raw, '*') && ($html_selected)) ? substr($value_raw, 1) : $value_raw;

		// get the keys for each value (only applies to custom theme fields)
		$value_key_raw = isset($field['val_keys'][$value])? $field['val_keys'][$value] : '';
		// if no value keys, use the $value also as the key (provides fallback support)
		$value_key = ($value_key_raw) ? $value_key_raw : $value;
		

		// Search and replace our template tags
		$html = str_replace('%class%', 'mf_' . $field['field_type'], $html);
		$html = str_replace('%key%', sanitize_title($field['key']), $html);
		$html = str_replace('%value_key%', $value_key, $html);
		$html = str_replace('%value%', htmlspecialchars($value, ENT_QUOTES), $html);
		$html = str_replace('%title%', $field['label'], $html);
		$html = str_replace('%max%', max($field['vals']), $html);
		$html = str_replace('%min%', min($field['vals']), $html);
		$html = str_replace('%caption%', '<p class="mf_caption">' . stripslashes($field['caption']) . '</p>', $html);

		// if ($value_stored) $html = str_replace('%selected%', $html_selected, $html);

		// Does this needs to be checked/selected/ticked?
		//if ($value && ($value == $value_stored)) $html = str_replace('%selected%', $html_selected, $html);
		if ($value_key && ($value_key == $value_stored)) $html = str_replace('%selected%', $html_selected, $html); // modified to use $value_key after adding custom theme fields
		else if ((!$value_stored) && ($value_raw != $value)) $html = str_replace('%selected%', $html_selected, $html);
		else $html = str_replace('%selected%', '', $html);
		if ($value_stored == 'checkbox_on') $html = str_replace('%selected%', $html_selected, $html);

		return $html;
	}
	/*
	**	rewrite_rules_array
	**
	*/
	function rewrite_rules_array ($rules) {
		global $wp_rewrite, $content_fields;
		$boxes = $content_fields->get_objects(array('_plugin_saved', '_plugin'));
		$new = array();
		foreach ((array) $boxes as $box) {
			foreach ((array) $box['fields'] as $field) {

				// Use either the slug, if defined, or the key as the slug
				$key = $field['key'];
				$slug = ($s = $field['slug']) ? $s : $key;
				if (!$slug || !$key) continue;				
				
				// Create the rule
				$new[$slug . '/([^/]+)/?$'] = "index.php?mf_key=$key&mf_value=\$matches[1]";
				
				// Add pagination
				$new[$slug . '/(.+?)/page/?([0-9]{1,})/?$'] = "index.php?mf_key=$key&mf_value=\$matches[1]&paged=\$matches[2]";

				
				// Add feed rule
				$new[$slug . '/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$'] = "index.php?mf_key=$key&mf_value=\$matches[1]&feed=\$matches[2]";
				

			}
		}
		
//		print_r($rules);
		return $new + $rules;
	}
}

function mf_ua_callback($object, $box) {
	global $content_fields, $content_fields_settings;
	$boxes = $content_fields->get_objects(array('_plugin_saved', '_plugin'));
	$content_fields_settings->build_box_gut($boxes[$box['id']]);
}

?>