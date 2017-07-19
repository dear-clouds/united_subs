<?php

/*
 *	Based on the work of Henrik Melin and Kal Ström's "More Fields", "More Types" and "More Taxonomies" plugins.
 *	http://more-plugins.se/
*/

$theme_framework_admin = 'FRAMEWORK_ADMIN_AMBASSADOR_1';
if (!defined($theme_framework_admin)) {

 	class framework_admin_object_ambassador_1 {
		var $name, $slug, $settings_file, $dir, $options_url, $option_key, $data, $url;
	
		var $action, $navigation, $message, $error;
		/*
		**
		**
		*/
		function framework_admin_object_ambassador_1 ($settings) {

			$this->name = $settings['name'];
			$this->slug = sanitize_title($settings['name']);
			$this->fields = $settings['fields'];
			if (isset($settings['settings_file'])) 
				$this->settings_file = $settings['settings_file'];
			else $this->settings_file = 'admin.php'; //else $this->settings_file = $this->slug . '-settings.php';
			$this->dir = plugin_dir_path($settings['file']); //WP_PLUGIN_DIR . '/' . $this->slug . '/';
			$this->url = plugin_dir_url($settings['file']); //get_option('siteurl') . '/wp-content/plugins/' . $this->slug . '/';
			if (isset($settings['menu_permissions'])) 
				$this->menu_permissions = $settings['menu_permissions'];
			else $this->menu_permissions = 'manage_options';
			if (isset($settings['parent_menu'])) 
				$this->parent_menu = $settings['parent_menu'];
			else $this->parent_menu = 'settings';
			$this->menu_url =  $this->get_admin_menu($this->parent_menu);
			$this->options_url = $this->menu_url . '?page=' . $this->slug;
			$this->settings_url = $this->options_url;
			$this->option_key = $settings['option_key'];
			$this->default = $settings['default'];
			$this->default_keys = ($a = $settings['default']) ? $a : array();

			// Create Settings Menu
			add_action('admin_menu', array(&$this, 'admin_menu'));
			add_action('admin_head', array(&$this, 'admin_head'));

			// Handle requests			
			add_action($this->parent_menu . '_page_' . $this->slug, array(&$this, 'request_handler'));
			
			// Add JS & css on settings page
			add_action('admin_head-' . $this->parent_menu . '_page_' . $this->slug, array(&$this, 'settings_head'));
			
			add_action('load-' . $this->parent_menu . '_page_' . $this->slug, array(&$this, 'settings_init'));
			
			add_filter('plugin_row_meta', array(&$this, 'plugin_row_meta'), 10, 2);

			add_action('init', array(&$this, 'admin_init'), 11);
			
			add_action('admin_init', array(&$this, 'contextual_help_tab'));
			
			$this->add_actions();

			$this->add_key = '57UPhPh';

		}
		
		function admin_init() {
			/* nothing */	
		}
		
		function add_actions() {
			// This function was intentionally left blank
		}
		
		function plugin_data() {
			return get_option($this->option_key, array());
		}
		
		/*
		**
		**	Add links to the Plugins page.
		*/
		function plugin_row_meta ($links, $file) {
			if (strpos('padding' . $file, $this->slug)) {
				$links[] = '<a href="' . $this->settings_url . '">' . __('Settings',THEME_NAME) . '</a>';
				$links[] = '<a href="http://more-plugins.se/forum/forum/' . $this->slug . '/">' . __('Support',THEME_NAME) . '</a>';
				$links[] = '<a href="http://more-plugins.se/donate/">' . __('Donate','sitemap') . '</a>';
			}
			return $links;
		}
		
		/*
		**
		**
		*/

		function admin_menu () {
			if ($this->menu_url != 'disabled') {
				// Register menu
				add_submenu_page( $this->menu_url, $this->name, $this->name, $this->menu_permissions, $this->slug, array(&$this, 'options_page') );
			}
		}
		
		function get_admin_menu ($parentMenu) {
			// determine which admin menu to use
			$menu = strtolower($parentMenu);
			$parent_slug = array(
				'dashboard' => 'index.php',
				'posts' => 'edit.php',
				'media' => 'upload.php',
				'links' => 'link-manager.php',
				'pages' => 'edit.php?post_type=page',
				'comments' => 'edit-comments.php',
				'appearance' => 'themes.php',
				'plugins' => 'plugins.php',
				'users' => 'users.php',
				'tools' => 'tools.php',
				'settings' => 'options-general.php',
				'disabled' => 'disabled' // special case for hiding admin menus
			);
			// set the value and return
			$menuURL = ($parent_slug[$menu]) ? $parent_slug[$menu] : $parent_slug['settings'];
			return 	$menuURL;
		}
		
		function contextual_help_tab () {
			global $theme_settings;

				// slug = parent + _page_ + current 
				$parentMenu = ($this->parent_menu) ? $this->parent_menu : 'settings';
				$screen =  $parentMenu . '_page_' . $this->slug;
				add_action( 'load-'. $screen, array($this, 'add_contextual_help_tab'), 10, 2 );
				//add_contextual_help($screen,$help);
		}

		function add_contextual_help_tab() {
			global $theme_settings;
		    $screen = get_current_screen();
		    $themeSettings = $theme_settings->get_objects(array('_plugin'));

			$help = isset($themeSettings['options']['branding_admin_help_tab_content'])? $themeSettings['options']['branding_admin_help_tab_content'] : '';
			$help = html_entity_decode($help, ENT_QUOTES); // allow HTML tags
			
			// Default help content
			if (!$help && isset($_GET['navigation']) && !empty($_GET['navigation'])) {
				$help  =	'<p>' . __('View the help documentation: ',THEME_NAME) . 
							"<a href=\"JavaScript:window.open('". THEME_URL ."assets/docs/readme.html#".$_GET['navigation']."', 'helpWindow','status=1,scrollbars=1,width=960,height=700')\">Help Document</a></p>"; /* .
							"<p>" . __('Or, for additional help please visit:',THEME_NAME) . '<a href="http://para.llel.us/support" target="_blank">Parallelus Support</a>' . "</p>";*/
			}

			$parentMenu = ($this->parent_menu) ? $this->parent_menu : 'settings';
						$screen1 =  $parentMenu . '_page_' . $this->slug;

			$screen->add_help_tab( array(
			      'id'      => $parentMenu . '_page_' . $this->slug,
			      'title'   => isset($themeSettings['options']['branding_admin_help_tab_title'])? $themeSettings['options']['branding_admin_help_tab_title'] : '',
			      'content' => $help
			));
		}

		/*
		**
		**
		*/
		function admin_head () {
			add_thickbox();
		
		}
		
		function is_plugin_installed() {
		
		}
		/*
		**
		**
		*/
		function options_page() {
			$this->options_page_wrapper_header();
			
			// Errors trump notifications
			if ($this->error) echo '<div class="updated fade error"><p><strong>' . $this->error . '</strong></p></div>';
			else if ($this->message) echo '<div class="updated fade"><p><strong>' . $this->message . '</strong></p></div>';

			// Load the settings file
			if (!isset($this->footed)) {
				if ($this->settings_file)
					require($this->dir . $this->settings_file);
			}
			$this->options_page_wrapper_footer();
		}

		function html_encode_for_export($data) {
			
			if (is_array($data)) {
				$d = array();
				foreach ($data as $k => $v) {
					if (is_array($v)) {
						$d[$k] = $this->html_encode_for_export($v);
					} else {
						// remove line breaks and excape html
						$d[$k] = esc_html(str_replace(array("\r\n", "\n", "\r", "]["), array("", "", "", "] ["), $v)); // "][" dirty fix, shortcodes need space between end of previous and start of next 
					}
				}
				return $d;
			}
			return $data;
		}
		
		function export_data() {
			$this->options_page_wrapper_header();
			$data = $this->get_data();
			$function = str_replace('-', '_', $this->slug);
			$filter = $function . '_saved';
			$k = $this->keys[1];
			$a = str_replace('-', '_', $k);
			$f = $function . '_saved_' . $a;
			if (is_array($data)) $data = $this->html_encode_for_export($data); // added to prevent issues with HTML content and quotes in the data
			$j = maybe_serialize($data);
			$export = "<?php \nadd_filter('$filter', '$f');\n";
			$export .= "function $f (\$d) {\$d['$k'] = maybe_unserialize('$j', true); return \$d; }\n?>";
			$filename = $a . '.php';
			$dir = $this->dir . 'saved/';
			$dirText = substr($dir, strpos($dir, 'wp-content'), strlen($dir));

			if (false) {			
				$file = $this->dir . 'registered/' . $filename;
				 if (!$handle = fopen($file, 'a')) {
					echo "Cannot open file ($filename)";
					exit;
				}
				// Write $somecontent to our opened file.
				if (fwrite($handle, $export) === FALSE) {
					echo "Cannot write to file ($filename)";
					exit;
				}
				fclose($handle);
			} 

			$this->navigation_bar(array('Export'));
			
			// Export the save data to a file where it can be downloaded (necessarty to preserve escaped HTML)
			$saveFile = FRAMEWORK_DIR . "utilities/download/save.php"; 
			$file = fopen($saveFile, 'w');
			$fileData = trim($export); 
			fwrite($file, $fileData); 
			fclose($file); 
			?>	
			
				<iframe id='GetFile' width="1px" height="1px" style="width: 1px; height: 1px; visibility: hidden;"></iframe>
				<script type="text/javascript">
					function showCode() {
						jQuery('#GetFile').attr('src', '<?php echo FRAMEWORK_URL; ?>utilities/download/getfile.php?file=save.php');
						return false;
					}
				</script>

				<p><?php printf(__('Options configured under %s can be exported and read from a saved file. The default location for these files is in the %s directory. To create an export file click the download button below. Save the file as %s and copy it to the save directory.', THEME_NAME), $this->name, "<code>$dirText</code>", "<code>$filename</code>", $this->name); ?></p>
				<p><input type="button" class="button-primary" onclick="showCode();" value="Download File"></p>
				<?php /*?><p><textarea rows="15" class="large-text readonly" name="rules" id="rules" readonly="readonly" onclick="this.select();"><?php echo esc_html($export); ?></textarea></p><?php */?>
			<?php
			$this->options_page_wrapper_footer();
		}
		
		/*
		**
		**
		*/
		function data_subset ($args = array()) {
			$ret = array();
			foreach ($this->data as $key => $d) {
				$exclude = false;
				foreach ($args as $k => $a) 
					if ($d[$k] != $a) $exclude = true;				
				if (!$exclude) $ret[$key] = $d;				
			}
			return $ret;
		
		}
		function get_data($s = array(), $override = false) {
			if (empty($s) && !$override) $s = $this->keys;
			if (count($s) == 0) return $this->data;
			if (count($s) == 1) return $this->data[$s[0]];
			if (count($s) == 2) return $this->data[$s[0]][$s[1]];
			if (count($s) == 3) return $this->data[$s[0]][$s[1]][$s[2]];
			if (count($s) == 4) return $this->data[$s[0]][$s[1]][$s[2]][$s[3]];
			if (count($s) == 5) return $this->data[$s[0]][$s[1]][$s[2]][$s[3]][$s[4]];
			if (count($s) == 6) return $this->data[$s[0]][$s[1]][$s[2]][$s[3]][$s[4]][$s[5]];
			return $this->data;
		}		
		function set_data($value, $s = array(), $override = false) {
			if (empty($s) && !$override) $s = $this->keys;
			if (count($s) == 0) $this->data = $value;
			if (count($s) == 1) $this->data[$s[0]] = $value;
			if (count($s) == 2) $this->data[$s[0]][$s[1]] = $value;
			if (count($s) == 3) $this->data[$s[0]][$s[1]][$s[2]] = $value;
			if (count($s) == 4) $this->data[$s[0]][$s[1]][$s[2]][$s[3]] = $value;
			if (count($s) == 5) $this->data[$s[0]][$s[1]][$s[2]][$s[3]][$s[4]] = $value;
			if (count($s) == 6) $this->data[$s[0]][$s[1]][$s[2]][$s[3]][$s[4]][$s[5]] = $value;
			return $this->data;
		}
		function unset_data($s = array()) {
			if (empty($s)) $s = $this->keys;
			$key = array_pop($s);
			$arr = $this->get_data($s, true);
			if (isset($arr[$key]) && $arr[$key]) unset($arr[$key]);
			$this->set_data($arr, $s, true);
			return $this->data;
		}
		
		/*
		**	settings_init()
		**
		**	Extract variables that define what we're trying to do.
		*/
		function settings_init() {

			// Single vars
			$fs = array('action', 'navigation');
			foreach ($fs as $f) $this->{$f} = isset($_GET[$f])? esc_attr($_GET[$f]) : '';

			// Array vars
			$fs = array('keys', 'action_keys');
			foreach ($fs as $f) {
				$a = isset($_GET[$f])? esc_attr($_GET[$f]) : '';
				$argh = $this->extract_array($a);
				$this->{$f} = $argh;
			}

			$this->after_settings_init();
			
			return true;
		}
		function after_settings_init() {
			/*
			** This function is intentionally left blank
			**
			** Overwritten by indiviudal plugin admin objects, if needed.
			*/
		}
		
		/*
		**
		**	Parse requests...
		*/
		function request_handler () {

			// Load up our data, internal and external
			$this->load_objects();
		
			// Ponce som en lugercheck!
			if (isset($_GET['_wpnonce']) && ($nonce = esc_attr($_GET['_wpnonce'])))
				check_admin_referer($this->nonce_action());

			// Check whatever you want - validate_submission should return false if 
			// things don't stack up. 
			if (!($this->validate_sumbission())) {
				if ($this->action == 'save') {
					$keys = $this->keys;
					if (!empty($this->action_keys)) {
						$keys = $this->action_keys;
						$this->keys = $keys;
					}
					$this->set_data($this->extract_submission(), $keys);
				}
				return false;
			}
			
			if ($this->navigation == 'export') {
				return $this->export_data();
			}
			
			if ($this->action == 'move') {
			
				// At what level are we moving?
				$action_keys = $this->extract_array(esc_attr($_GET['action_keys']));
				if (empty($action_keys)) array_push($action_keys, '_plugin');
				$data = $this->get_data($action_keys);

				if (empty($data))
					return $this->error(__('Someting has gone awry. Sorry.', THEME_NAME));
				
				// Which element is being moved?
				$row = esc_attr($_GET['row']);

				// Move a key
				$up = ('up' == esc_attr($_GET['direction'])) ? true : false;
				$data = $this->move_field($data, $row, $up);

				// Save the data
				$this->set_data($data, $action_keys);
				$this->save_data();
				
			}
			if ($this->action == 'save') {

				$arr = $this->extract_submission();
				// The $_POST['index'] needs to be set externally, this is
				// last index of the data to be saved 
				$index = $arr['index'];
				$keys  = $arr['originating_keys'];
				$old_last_key = $keys[count($keys) - 1];

				// We can only save to '_plugin'
				if ($keys[0] != '_plugin') {
					$arr['ancestor_key'] = $keys[1];
					$keys[0] = '_plugin';
				}

			
				// Is this not new stuff?
				if ($index != $this->add_key) {
					// Ok, so it's not new, but has it changed?
					if ($old_last_key != $index) {
						// The old keys are now redundant
						$this->unset_data($keys);
					}
				}
				// Set the appropiate focus
				array_pop($keys);
				array_push($keys, $index);
				unset($arr['originating_keys']);

				// Set and save and provide feedback
				if (count($keys) > 1) {
					$this->set_data($arr, $keys);
					$this->save_data();
					$this->message = __('Saved!', 'more_plugins');
				}
			}
			if ($this->action == 'delete') {
				$data = $this->unset_data($this->action_keys);
				$this->save_data();
				$this->message = __('Deleted!', THEME_NAME);
			}

			if (count($this->keys) && $this->action == 'add') {

				// Extract the last key
				$last = $this->keys[count($this->keys) - 1];

				// Are we trying to add stuff?
				if ($last == $this->add_key) {
					$this->data = $this->set_data($this->default, $this->keys);				
				}

			}
			
			$this->after_request_handler();
		}
		function after_request_handler() {
			/*
			** This function is intentionally left blank
			**
			** Overwritten by indiviudal plugin admin objects, if needed - mostly
			** used for cross more-plugins functionality
			*/
		}
		function extract_submission() {

			// Add required params
			array_push($this->fields['array'], 'originating_keys');
			array_push($this->fields['var'], 'index');
			array_push($this->fields['var'], 'ancestor_key');
			array_push($this->fields['var'], 'version_key');
			array_push($this->fields['var'], 'import_key');

			// Extract
			$arr = array();
			foreach($this->fields['var'] as $field) {
				$v = isset($_POST[$field])? esc_attr($_POST[$field]) : '';
				if ($field == 'disable_wp_content') {
					$disable = array();
					if(isset($_POST['disable_wp_content'])) {
						foreach((array) $_POST['disable_wp_content'] as $key => $val) {
							foreach($val as $_val) {
								$disable[$_val][] = $key;
							}
						}
					}
					$v = serialize($disable);
				}
				$arr[$field] = (stripslashes($v));
			}
			foreach($this->fields['array'] as $level1 => $field) {
				if (!is_array($field)) {
					$vals = $this->extract_array($_POST[$field]);
					foreach ($vals as $k => $v) {
						if (!is_array($v) && !is_object($v)) {
							$arr[$field][$k] = (stripslashes($v));
						} else $arr[$field][$k] = $this->object_to_array($v);
					}
				} else {
					foreach ($field as $level2 => $field2) {
						$post = isset($_POST[$level1 . ',' . $field2])? $this->extract_array($_POST[$level1 . ',' . $field2]) : array();
						$arr[$level1][$field2] = isset($post[0])? (stripslashes($post[0])) : '';
					}
				}
			}

			return $arr;
		}

		/*
		** 	Might be storing serialized data or might be a 
		**	comma separated list
		*/
		function extract_array($a) {
			// *Might* be storing json data or *might* be a 
			// comma separated list
			
			if (is_array($a)) return $a;
			
			if ($a) {

				// $a be a json object
				$b = json_decode(stripslashes_deep($a), true);
				if (is_array($b)) return $this->slasherize($b, true);
								
				// Is this a comma separated list?
				if (strpos($a, ',')) 
					return explode(',', $a);
				
				// $a is just a single value		
				return array($a);
			}
			
			// $a is empty
			return array();
		}
		
		/*
		**
		**
		*/
		function stripslashes_deep ($string) {
			while(strpos($string, '\\')) 
				$string = stripslashes($string);
			return $string;
		}
		/*
		**
		**
		*/
		function object_to_array($data) {
			if (is_array($data) || is_object($data)) {
				$result = array(); 
				foreach($data as $key => $value) $result[$key] = $this->object_to_array($value); 
    			return $result;
  			}
			return $data;
		}
		/*
		**	Get the index name from the $_POST variable
		**	to be used in validate_submission() in individual
		**	settings classes.
		**
		*/		
		function get_index($key) {
			$val = esc_attr($_POST[$key]);
			$val = sanitize_title($val);
			$val = str_replace('-', '_', $val);
			return $val;		
		}
		/*
		**
		**
		*/
/*
		function read_data() {
			return array();
		}
*/
		/*
		**
		**
		*/
		function save_data($data = array()) {
			if (empty($data)) $data = $this->data['_plugin'];
			update_option($this->option_key, $data);
		}
		
		
		/*
		**
		**	Overwrite this function in subclass to validate
		**	the submission data.
		*/		
		function validate_sumbission () {
			// Somthing
			return true;
		}

		/*
		**
		**
		*/
		function error($error) {
			$this->error = $error;
			return false;
		}

		/*
		**
		**
		*/
		function set_navigation($navigation) {
			$_GET['navigation'] = $navigation;
			$_POST['navigation'] = $navigation;
			$this->navigation = $navigation;
			return $navigation;
		}	
		/*
		**
		**
		*/
		function options_page_wrapper_header () {
			global $theme_settings;
			
			if (isset($this->headed) && $this->headed) return false;
			$url = get_option('siteurl');
			?>
				<div class="wrap">
				<div id="theme-framework" class="has-right-sidebar <?php echo $this->slug; ?> <?php echo $this->slug . '-' . $this->navigation; ?>">		
				
					<div id="icon-options-general" class="icon32"><br /></div>
					<h2><?php echo $this->name; ?></h2>
	
					<div class="inner-sidebar metabox-holder">
						
						<?php
						// Check for theme settings related to this area
						if (is_object($theme_settings)) {
							
							$themeSettings = $theme_settings->get_objects(array('_plugin'));
							
							// Check for custom logo
							$logo = isset($themeSettings['options']['branding_admin_logo'])? $themeSettings['options']['branding_admin_logo'] : '';
							$logo_image = !empty($logo)? '<img src="'.$logo.'" alt="" />' : '';

							// Check theme settings box enabled
							$show_theme_settings_box = isset($themeSettings['options']['branding_admin_right_column_theme_settings'])? $themeSettings['options']['branding_admin_right_column_theme_settings'] : '';
							if ($show_theme_settings_box == '') $show_theme_settings_box = true; // default if empty is true

							// Check design settings box enabled
							$show_design_settings_box = isset($themeSettings['options']['branding_admin_right_column_design_settings'])? $themeSettings['options']['branding_admin_right_column_design_settings'] : '';
							if ($show_design_settings_box == '') $show_design_settings_box = true; // default if empty is true

							// Check custom box
							$custom_box_title = isset($themeSettings['options']['branding_admin_custom_right_column_title'])? $themeSettings['options']['branding_admin_custom_right_column_title'] : '';
							$custom_box_content = isset($themeSettings['options']['branding_admin_custom_right_column'])? $themeSettings['options']['branding_admin_custom_right_column'] : '';
							$custom_box_content = html_entity_decode($custom_box_content, ENT_QUOTES); // allow HTML tags
							if ($custom_box_title || $custom_box_content) { $show_custom_box = true; }
				
						}
						// Default help content
						if (empty($logo)) {
							$logo_image = '<img src="'.FRAMEWORK_URL.'images/theme-options-logo.png" width="270" height="48" alt="" />';
						}
						
						echo $logo_image;
						?>
					
						<div id="side-sortables" class="meta-box-sortabless ui-sortable" style="position:relative;">
				
							<?php 
							
							// Custom Box (user created)
							if (isset($show_custom_box) && $show_custom_box) : ?>
							<div class="theme-settings-box postbox theme-framework-box">
								<h3 class="hndle"><span><?php echo $custom_box_title; ?></span></h3>
								<div class="inside">
									<?php echo $custom_box_content; ?>
								</div>
							</div>
							
							<?php endif;
							// Design Settings Box
							if ($show_design_settings_box) : ?>
							<div class="design-settings-box postbox theme-framework-box">
								<h3 class="hndle"><span><?php _e('Appearance', THEME_NAME); ?></span></h3>
								<div class="inside">
									<ul class="action-links">
									
										<li>
											<dl>
												<dt><a href="themes.php?page=design-settings"><?php _e('Design Settings', THEME_NAME); ?></a></dt>
												<dd><?php _e('Default settings including logo, skins, fonts and backgrounds.', THEME_NAME); ?></dd>
											</dl>
										</li>
	
										<li>
											<dl>
												<dt><a href="themes.php?page=layouts"><?php _e('Layouts, Headers and Footers', THEME_NAME); ?></a></dt>
												<dd><?php _e('Create and manage the headers, footers and templates available for your content.', THEME_NAME); ?></dd>
											</dl>
										</li>
	
										<li>
											<dl>
												<dt><a href="themes.php?page=sidebars-top-tabs"><?php _e('Sidebars &amp; Top Tabs', THEME_NAME); ?></a></dt>
												<dd><?php _e('Create sidebars and manage the "slide down" tabs at the top of your site.', THEME_NAME); ?></dd>
											</dl>
										</li>
	
										<li>
											<dl>
												<dt><a href="themes.php?page=slide-shows"><?php _e('Slide shows', THEME_NAME); ?></a></dt>
												<dd><?php _e('Create and manage your slide shows.', THEME_NAME); ?></dd>
											</dl>
										</li>
	
									</ul>
								</div>
							</div>
							<?php endif;
							
							// Theme Settings Box
							if ($show_theme_settings_box) : ?>
							<div class="theme-settings-box postbox theme-framework-box">
								<h3 class="hndle"><span><?php _e('Theme Settings', THEME_NAME); ?></span></h3>
								<div class="inside">
									<ul class="action-links">

										<li>
											<dl>
												<dt><a href="options-general.php?page=theme-settings#options_misc"><?php _e('Basic Settings', THEME_NAME); ?></a></dt>
												<dd><?php _e('Various settings related to your site setup and functionality.', THEME_NAME); ?></dd>
											</dl>
										</li>

										<li>
											<dl>
												<dt><a href="options-general.php?page=theme-settings#options_special"><?php _e('Special Features', THEME_NAME); ?></a></dt>
												<dd><?php _e('Enable optional settings for advanced functionality and display effects.', THEME_NAME); ?></dd>
											</dl>
										</li>
									
										<li>
											<dl>
												<dt><a href="options-general.php?page=blog-settings"><?php _e('Blog Settings', THEME_NAME); ?></a></dt>
												<dd><?php _e('Control the display of blog pages, posts and the content of these pages.', THEME_NAME); ?></dd>
											</dl>
										</li>

										<li>
											<dl>
												<dt><a href="options-general.php?page=contact-form"><?php _e('Contact Form', THEME_NAME); ?></a></dt>
												<dd><?php _e('Create input fields and customize the contact forms for your site.', THEME_NAME); ?></dd>
											</dl>
										</li>
										
										<li>
											<dl>
												<dt><a href="options-general.php?page=theme-settings#options_dev"><?php _e('Developer Options', THEME_NAME); ?></a></dt>
												<dd><?php _e('Advanced options for admin permissions and theme setup.', THEME_NAME); ?></dd>
											</dl>
										</li>

										<li>
											<dl>
												<dt><a href="options-general.php?page=theme-settings#options_branding"><?php _e('Theme Admin Branding', THEME_NAME); ?></a></dt>
												<dd><?php _e('Some features to enable re-branding of theme options, help documents, etc.', THEME_NAME); ?></dd>
											</dl>
										</li>

									</ul>
								</div>
							</div>
							<?php endif; ?>
							
				
						</div> <!-- END id="side-sortables" class="meta-box-sortabless ui-sortable" -->
					</div> <!-- END class="inner-sidebar metabox-holder" -->
	
					<div id="post-body">
						<div id="post-body-content" class="has-sidebar-content">
					<?php
				$this->headed = true;
	
		}

		/*
		**
		**
		*/
		function options_page_wrapper_footer() {
			if (isset($this->footed) && $this->footed) return false;
			?>
						</div> 
					</div>
				<!-- more-plugins --></div>
			<!-- /wrap --></div>
			<?php
			$this->footed = true;
		}
		
		/*
		**
		**
		*/
		function condition($condition, $message, $type = 'error') {
	
			if (!isset($this->is_ok)) $this->is_ok = true;
	
			// If there is an error already return
			if (!$this->is_ok && $type = 'error') return $this->is_ok;
	
			if ($condition == false && $type != 'silent') {
				echo '<div class="updated fade"><p>' . $message . '</p></div>';
	
				// Don't set the error flag if this is a warning.
				if ($type == 'error') $this->is_ok = false;
			}
		
			return ($condition == true);
		}
		
		/*
		**
		**
		*/
		function checkboxes($name, $title, $values, $arr) {
			?>
			<tr>
				<th scope="row" valign="top"><?php echo $title; ?></th>
				<td>
					<?php foreach ($values as $key => $title2) : 
		// 					$selected = ($arr[$name] == $key) ? ' checked="checked"'	: '';	
							$checked = (in_array($key, (array) $arr[$name])) ? " checked='checked'" : '';
		
					?>
						<label><input type="checkbox" name="<?php echo $name; ?>[]" value="<?php echo $key; ?>" <?php echo $checked; ?>> <?php echo $title2; ?></label>
					<?php endforeach; ?>
				</td>
			</tr> 	
			<?php
		}

		/*
		**
		**
		*/

		function bool_var($name, $title, $arr) {
			?>
			<tr>
				<th scope="row" valign="top"><?php echo $title; ?></th>
				<td>
					<?php
							$true = ($arr[$name]) ? " checked='checked'" : '';
							$false = ($true) ?  '' : " checked='checked'";
					?>
						<label><input type="radio" name="<?php echo $name; ?>" value="true" <?php echo $true; ?>> <?php echo $title2; ?> Yes</label>
						<label><input type="radio" name="<?php echo $name; ?>" value="false" <?php echo $false; ?>> <?php echo $title2; ?> No</label>
				</td>
			</tr> 	
			<?php
		
		}
		
		/*
		**
		**
		*/
		function move_field ($data, $nbr, $up = true) {
	
			// Are we moving out of bounds?
			if (count($data) == 1) return $data;
			if ($nbr >= count($data) - 1 && !$up) return $data;
			if ($nbr == 0 && $up) return $data;
	
			$new = array();
			$ctr = 0;
			$offset = ($up) ? 0 : 1;
			foreach ($data as $key => $arr) {
				if ($ctr == $nbr - 1 + $offset) $tmp_key = $key;
				else $new[$key] = $arr;
				if ($ctr == $nbr + $offset) $new[$tmp_key] = $data[$tmp_key];
				$ctr++;
			}
			return $new;

		}

		/*
		**
		**
		*/
		function updown_link ($nbr, $total, $args = array()) {
			$html = '';
			$link = array('row' => $nbr, 'navigation' => $this->navigation, 'action' => 'move');

			// Are we adding more stuff to our link?
			if (!empty($args)) $link = array_merge($link, $args);

			// Build the links
			if ($nbr > 0) $html .= ' | ' . $this->settings_link('&uarr;', array_merge($link, array('direction' => 'up')));
			if ($nbr < $total - 1) $html .= ' | ' . $this->settings_link('&darr;', array_merge($link, array('direction' => 'down')));
			return $html;
		}
		
		/*
		**
		**
		*/
		function settings_link ($text, $args) {
			$link = $this->options_url;
			foreach ($args as $key => $value) {
				if ($key == 'class') continue;
				if (!$value) continue;
				if (is_array($value)) $value = implode(',', $value);
				$link .= '&' . $key . '=' . urlencode($value);
			}
			$link = wp_nonce_url($link, $this->nonce_action($args));
			$class = (isset($args['class']) && ($c = $args['class'])) ? $c : 'more-common';
			$html = "<a class='$class' href='$link'>$text</a>";
			if (!$text) return $link;
			return $html;
		}

		/*
		**
		**
		*/
		function nonce_action($args = array()) {

			if (empty($args)) $args = $_GET;

			$action = $this->slug . '-action_';
			if (isset($args['navigation']) && ($a = esc_attr($args['navigation']))) $action .= $a;			
			if (isset($args['action']) && ($a = esc_attr($args['action']))) $action .= $a;

			return $action;		
		}
		/*
		**
		**
		*/
		function table_header($titles) {
			?>
			<table class="widefat">
				<thead>
					<tr>
						<?php foreach ((array) $titles as $title) : ?>
						<th><?php echo $title; ?></th>
						<?php endforeach; ?>
					</tr>
				</thead>
				<tbody>
			<?php
		}

		/*
		**
		**
		*/
		function table_footer($titles) {
			?>
				</tbody>
				<tfoot>
					<tr>
						<?php foreach ((array) $titles as $title) : ?>
						<th><?php echo $title; ?></th>
						<?php endforeach; ?>
					</tr>
				</tfoot>
			</table>
			<?php
		}

		/*
		**
		**
		*/
		function table_row($contents, $nbr, $class = '') {
			$class .= ($nbr++ % 2) ? ' alternate ' : '' ;
			?>
			<tr class="<?php echo $class; ?>">
			<?php 
			$count = 1;
			$total = count($contents);
			foreach ((array) $contents as $content) : 
				$tdClass = ($count == $total) ? ' class="last-td"' : '';
				?>
				<td<?php echo $tdClass; ?>><?php echo $content; ?></td>
				<?php 
			$count++;
			endforeach; ?>
			</tr>
			<?php
		}

		/*
		**
		**
		*/
		function setting_row($cols, $class = '') {
			?>
				<tr class="<?php echo $class; ?>">
					<th scope="row" valign="top"><?php echo array_shift($cols); ?></th>
					<?php foreach ($cols as $col) : ?>
						<td>
							<?php echo $col; ?>
		 				</td>
					<?php endforeach; ?>
	 			</tr>
			<?php
		}


		function get_val($name, $k = array()) {
			if (empty($k)) $k = $this->keys;
			$s = array();

			// Deal with comma separated keys 
			foreach ((array) $k as $b) {
				if (strpos($b, ',')) {
					$c = explode(',', str_replace(' ', '', $b));
					foreach($c as $d) $s[] = $d;
				}
				else $s[] = $b;
			}

			// Deal with comma separated field names			
			if (strpos($name, ',')) {
				$c = explode(',', str_replace(' ', '', $name));
				foreach($c as $d) $s[] = $d;
			} else $s[] = $name;

			// Iterate through the data
			$subdata = $this->data;
			foreach ($s as $key) {
				$subdata = isset($subdata[$key])? $subdata[$key] : '';
			}
			if (!is_array($subdata)) $subdata = stripslashes($subdata);
			return $subdata;
		

		}
		/*
		**
		**
		*/
		function settings_input($name, $s = array()) {
			$value = esc_attr($this->get_val($name, $s));
			$html = '<input class="input-text" type="text" name="' . $name . '" value="' . $value . '">';		
			return $html;
		}

		/*
		**
		**
		*/
		function settings_bool($name) {
			$vars = array(true => 'Yes', false => 'No');
			$html = $this->settings_radiobuttons($name, $vars);
			return $html;
		}

		function settings_radiobuttons($name, $vars, $comments = array()) {
			$html = '';
			$set = $this->get_val($name);
			foreach ($vars as $key => $value) {
				$checked = ($key == $set) ? ' checked="checked"' : '';
				$html .= "<label><input class='input-radio' type='radio' name='$name' value='$key' $checked /> $value</label> ";		
					if (isset($comments[$key]) && ($c = $comments[$key])) $html .= $this->format_comment($c);
			}
			return $html;
		}
		function settings_hidden($name, $var = 0) {
			if (!$var) $var = $this->get_val($name);
			
			// added condition to test for array so hidden can also be used with individual fields 
			if (is_array($var)) {
				$value = ($var) ? json_encode($this->slasherize($var)) : '';
			} else {
				$value = $var;
			}
			$typeof = '';
			$html = $typeof ."<input type='hidden' name='$name' value='$value'>";
			return $html;
		}
		function slasherize ($var, $strip = false) {		
			$ret = array();
			$word = '2ew8dhpf7f3';
			foreach ($var as $k => $v) {
				if (!$strip) $ret[$k] = (is_array($v)) ? $this->slasherize($v) :  str_replace(array('"', "'"), array($word, strrev($word)), stripslashes_deep(htmlspecialchars_decode($v)));
				else $ret[$k] = (is_array($v)) ? $this->slasherize($v, true) :  str_replace(array($word, strrev($word)), array('"', "'"), $v);
			}
			return $ret;
		}
	
		/*
		**
		**
		*/
		
		// get all user roles
		function get_roles() {
			global $wp_roles;	
			$user_levels = array();
			foreach($wp_roles->roles as $role) { 
				$name = str_replace('|User role', '', $role['name']);
				$value = sanitize_title($name); 
				if ($value) $user_levels[$value] = $name;
			}
			return $user_levels;
		}
		
		// get all pages
		function get_pages($title = false, $indent = true) {
			$wp_pages = get_pages('sort_column=menu_order');	
			$page_list = array();
			if ($title) $page_list[] = $title;
			foreach ($wp_pages as $page) {
				$prefix = '';
				// show indented child pages?
				if ($indent) { 
					$has_parent = $page->post_parent;
					while($has_parent) {
						$prefix .=  ' - ';
						$next_page = get_page($has_parent);
						$has_parent = $next_page->post_parent;
					}
				}
				// add to page list array array
				$page_list[$page->ID] = $prefix . $page->post_title;
			}
			return $page_list;
		}

		// get all posts (works with custom post types also)
		function get_posts($title = false, $indent = true, $post_type = 'post', $useKey = 'ID') {
			$args = array('numberposts' => -1, 'post_type' => $post_type);
			$wp_posts = get_posts($args);	
			$post_list = array();
			if ($title) $post_list[] = $title;
			foreach ($wp_posts as $post) {
				$prefix = '';
				// show indented child posts?
				if ($indent) { 
					$has_parent = $post->post_parent;
					while($has_parent) {
						$prefix .=  ' - ';
						$next_post = get_post($has_parent);
						$has_parent = $next_post->post_parent;
					}
				}
				// add to post list array array
				if ($useKey == 'post_name') {
					$post_list[$post->post_name] = $prefix . $post->post_title;
				} else {
					$post_list[$post->ID] = $prefix . $post->post_title;
				}
			}
			return $post_list;
		}


		/**
		 * Get the theme's CSS skin files 
		 *
		 * @since 1.5.0
		 *
		 * @return array Key is CSS file name, Value is CSS file name
		 */
		function get_skin_css() {
			$theme = wp_get_theme();
			$css_files = $theme['Stylesheet Files'];
			$skins = array();
		
			if ( is_array( $css_files ) ) {
				$base = array( trailingslashit(get_template_directory()), trailingslashit(get_stylesheet_directory()) );
		
				foreach ( $css_files as $skin ) {
					$basename = str_replace($base, '', $skin);
		
					// don't allow template files in subdirectories
					if ( false !== strpos($basename, '/') )
						continue;
		
					$skin_data = implode( '', file( $skin ));
		
					$name = '';
					if ( preg_match( '|Skin Name:(.*)$|mi', $skin_data, $name ) )
						$name = _cleanup_header_comment($name[1]);
		
					if ( !empty( $name ) ) {
						$skins[$basename] = trim( $name );
					}
					//$skins[trim( $skin_data )] = $basename;
				}
			}
		
			return $skins;
		}


		/*
		**
		**
		*/
		function checkbox_list($name, $vars, $options = array()) {
			$values = (array) $this->get_val($name);
			$html = '';

			foreach ($vars as $key => $val) {
				// Options will over-ride values
				$class = ($a = $options[$key]['class']) ? 'class="' . $a . '"' : '';
				$readonly = ($options[$key]['disabled']) ? ' disabled="disabled"' : '';
				
				if (array_key_exists('value', (array) $options[$key]))
					$checked = ($options[$key]['value']) ? ' checked="checked" ' : '';
				else $checked = (in_array($key, $values)) ? ' checked="checked"' : '';
				
				$html .= "<label><input class='input-check' type='checkbox' value='$key' name='${name}[]' $class $readonly $checked /> $val</label>";
				if ($t = $options[$key]['text']) $html .= '<em>' . $t . '</em>';
			}
		//	$html .= '<input type="hidden" name="' . $name . '_values" value="' . implode(',', array_keys($vars)) . '">';
			return $html;		
		}
		
		function settings_select($name, $vars, $values = false) {
			$values = ($values) ? $values : $this->get_val($name);
			//$values = $this->get_val($name);
			$html = "<select class='input-select' name='$name'>";
			foreach ($vars as $key => $val) {
				$checked = ($key == $values) ? ' selected="selected"' : '';
				$html .= "<option value='$key' $checked> $val</option>";
			}
			$html .= "</select>";
			return $html;		
		}
		function settings_textarea($name) {
			$value = $this->get_val($name);
			$html = "<textarea class='input-textarea' name='$name'>$value</textarea>";
			return $html;
		
		}

		function get_version_id($prefix = 'id_') {
			$key1 = base_convert(mt_rand(0x1679616, 0x39AA3FF), 10, 36);
			$key2 = base_convert(microtime(), 10, 36);
			$id = $prefix . $key1 . $key2;
			return $id;
		}

		/*
		**
		**
		function add_button ($options) {
			?>
			<form method="GET" ACTION="<?php echo $this->options_url; ?>">
			<input type="hidden" name="page" value="<?php echo $this->slug; ?>">
			<input type="hidden" name="navigation" value="<?php echo $options['navigation']; ?>">
			<input type="hidden" name="action" value="<?php echo $options['action']; ?>">
			<p><input class="button-primary" type="submit" value="<?php echo $options['title']; ?>"></p>
			</form>
			<?php
		
		}
		*/
		
		/*
		**
		**
		*/
		function navigation_bar($levels) {
		?>
			<ul id="theme-framework-edit">
			<li><a href="<?php echo $this->settings_url; ?>"><?php echo $this->name; ?></a></li>
			<?php 
				for ($i=0; $i<count($levels); $i++) {
					$selected = ($i == count($levels) - 1) ? ' selected="selected"' : '';
					echo '<li ' . $selected . '">' . $levels[$i] . '</li>';
				}
			 ?>
			</ul>
		<?php
		}



		/*
		**
		**
		*/
		function settings_head () {
			?>
			<script type="text/javascript">
			//<![CDATA[
				jQuery(document).ready(function($){
					$("a.common-delete, a.more-common-delete").click(function(){
						return confirm("<?php _e('Are you sure you want to delete?', THEME_NAME); ?>");
					});
					$("#post-body-content .postbox").each( function(){
							var handle = jQuery(this).children('.hndle, .handlediv');
							var content = jQuery(this).children('.inside');
							handle.click( function(){
								content.slideToggle();
								return false;
							});
					});
				});
			//]]>
			</script>
			<?php			
				$css = FRAMEWORK_URL . 'css/styles.css';
			?>
				<link rel='stylesheet' type='text/css' href='<?php echo $css; ?>' />
			<?php
		}
		function settings_form_header($args = array()) {
			$defaults = array('action' => 'save', 'keys' => isset($_GET['keys'])? $_GET['keys'] : '');
			$args = wp_parse_args($args, $defaults);
			?>
			<?php $url = $this->settings_link(false, $args); ?>
			<form method="post" action='<?php echo $url; ?>'>
			<?php 
		}
		function format_comment($comment) {
			return '<em>' . $comment . '</em>';
		}
		function settings_save_button($text = 'Save', $class = 'button') {
			$keys = implode(',', (array) $this->keys);
		?>
			<input type="hidden" name='version_key' value='<?php echo $this->get_version_id(); ?>' />
			<input type="hidden" name='import_key' value='<?php echo $this->get_val("import_key"); ?>' />
			<input type="hidden" name='ancestor_key' value='<?php echo $this->get_val("ancestor_key"); ?>' />
			<input type="hidden" name='originating_keys' value='<?php echo $keys; ?>' />
			<input type="hidden" name='action' value='save' />
			<input type="submit" class='<?php echo $class; ?>' value='<?php _e($text, THEME_NAME); ?>' />		
			</form>

		<?php
		}
		
		function get_post_types() {
			global $wp_post_types;
			$ret = array();
			foreach ($wp_post_types as $key => $pt) {
				$name = ($t = $pt->labels->singular_name) ? $t : $pt->label;
				$ret[$key] = $name;	
			}
			return $ret;
		}
		function permalink_warning() {
			global $wp_rewrite;
			if (empty($wp_rewrite->permalink_structure)) {
				$html = '<em class="warning">';
				$html .= __('Permalinks are currently not enabled! To use this feature, enable permalinks in the <a href="options-permalink.php">Permalink Settings</a>.', THEME_NAME);			
				$html .= '</em>';
				return $html;
			}
			else return '';
		}

        function settings_multicheck($name, $vars, $values = false, $_name = "") {
            global $theme_settings;

            $values = ($values) ? $values : $this->get_val($name);
            $values = ($values) ? $values : unserialize($theme_settings->data_loaded['_plugin']['options']['disable_wp_content']);

            if (!is_array($values))
                $values = unserialize($values);

            if($_name) {
                $tvalues = array();
                if(is_array($values)) {
                    foreach($values as $tkey => $tval) {
                        if(is_array($tval)) {
                            foreach($tval as $ttkey => $ttval) {
                                if($ttval == $_name) {
                                    $tvalues[] = $tkey;
                                }
                            }
                        }
                    }
                }

                $values = $tvalues;
            }

            $html = "";
            foreach ($vars as $key => $val) {
                $checked = (in_array($key, $values)) ? ' checked="checked"' : '';
                $post_type = get_post_type_object($val);
                $html .= '
                    <label>
                        <input type="checkbox" name="'. $name.'['.$_name.'][]" value="'. $key .'" '. $checked .'>
                        '. (!empty($post_type->labels->singular_name) ? $post_type->labels->singular_name : $post_type->labels->menu_name) .'
                    </label>';
            }

            return $html;
        }
	} // end class



} // endif defined

define($theme_framework_admin, true);


if (!is_callable('__d')) {
	function __d($d) {
		echo '<pre>';
		print_r($d);
		echo '</pre>';	
	}
}

?>