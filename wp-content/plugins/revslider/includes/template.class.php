<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/
 * @copyright 2015 ThemePunch
 */

if( !defined( 'ABSPATH') ) exit();

class RevSliderTemplate {
	
	private $templates_url		= 'http://templates.themepunch.tools/';
	private $templates_list		= 'revslider/get-list.php';
	private $templates_download	= 'revslider/download.php';
	
	private $templates_server_path	= '/revslider/images/';
	private $templates_path			= '/revslider/templates/';
	private $templates_path_plugin	= 'admin/assets/imports/';
	
	const SHOP_VERSION				= '1.2.0';
	
	
	
	/**
	 * Download template by UID (also validates if download is legal)
	 * @since: 5.0.5
	 */
	public function _download_template($uid){
		global $wp_version;
		
		$return = false;
		
		$uid = esc_attr($uid);
		
		$code = get_option('revslider-code', '');
		$shop_version = self::SHOP_VERSION;
		
		$validated = get_option('revslider-valid', 'false');
		if($validated == 'false'){
			$code = '';
		}
		
		$rattr = array(
			'code' => urlencode($code),
			'shop_version' => urlencode($shop_version),
			'version' => urlencode(RevSliderGlobals::SLIDER_REVISION),
			'uid' => urlencode($uid),
			'product' => urlencode('revslider')
		);
		
		
		
		$upload_dir = wp_upload_dir(); // Set upload folder
		// Check folder permission and define file location
		if(wp_mkdir_p( $upload_dir['basedir'].$this->templates_path ) ) { //check here to not flood the server
			$request = wp_remote_post($this->templates_url.$this->templates_download, array(
				'user-agent' => 'WordPress/'.$wp_version.'; '.get_bloginfo('url'),
				'body' => $rattr,
				'timeout' => 45 //DIRK 
			));
			
			if(!is_wp_error($request)) {
				if($response = $request['body']) {
					if($response !== 'invalid'){
						//add stream as a zip file
						$file = $upload_dir['basedir']. $this->templates_path . '/' . $uid.'.zip';
						@mkdir(dirname($file));
						$ret = @file_put_contents( $file, $response );
						if($ret !== false){
							//return $file so it can be processed. We have now downloaded it into a zip file
							$return = $file;
						}else{//else, print that file could not be written
							$return = array('error' => __('Can\'t write the file into the uploads folder of WordPress, please change permissions and try again!', 'revslider'));
						}
					}else{
						$return = array('error' => __('Purchase Code is invalid', 'revslider'));
					}
				}
			}//else, check for error and print it to customer
		}else{
			$return = array('error' => __('Can\'t write into the uploads folder of WordPress, please change permissions and try again!', 'revslider'));
		}
		
		return $return;
	}
	
	
	/**
	 * Delete the Template file
	 * @since: 5.0.5
	 */
	public function _delete_template($uid){
		$uid = esc_attr($uid);
		
		$upload_dir = wp_upload_dir(); // Set upload folder
		
		// Check folder permission and define file location
		if( wp_mkdir_p( $upload_dir['basedir'].$this->templates_path ) ) {
			$file = $upload_dir['basedir']. $this->templates_path . '/' . $uid.'.zip';
			
			if(file_exists($file)){
				//delete file
				return unlink($file);
			}
		}
		
		return false;
	}
	
	
	/**
	 * Get the Templatelist from servers
	 * @since: 5.0.5
	 */
	public function _get_template_list($force = false){
		global $wp_version;
		
		$last_check = get_option('revslider-templates-check');
		
		if($last_check == false){ //first time called
			$last_check = 172801;
			update_option('revslider-templates-check',  time());
		}
		
		// Get latest Templates
		if(time() - $last_check > 345600 || $force == true){ //4 days
			
			update_option('revslider-templates-check',  time());
			
			$validated = get_option('revslider-valid', 'false');
			
			$code = get_option('revslider-code', '');
			$shop_version = self::SHOP_VERSION;
			
			if($validated == 'false'){
				$code = '';
			}
			
			
			$rattr = array(
				'code' => urlencode($code),
				'shop_version' => urlencode($shop_version),
				'version' => urlencode(RevSliderGlobals::SLIDER_REVISION),
				'product' => urlencode('revslider')
			);
			
			
			$request = wp_remote_post($this->templates_url.$this->templates_list, array(
				'user-agent' => 'WordPress/'.$wp_version.'; '.get_bloginfo('url'),
				'body' => $rattr
			));
			
			if(!is_wp_error($request)) {
				if($response = maybe_unserialize($request['body'])) {
					
					$templates = json_decode($response, true);
					
					if(is_array($templates)) {
						RevSliderFunctionsWP::update_option('rs-templates-new', $templates, false);
					}
				}
			}
			
			$this->update_template_list();
		}
	}
	
	
	/**
	 * Update the Templatelist, move rs-templates-new into rs-templates
	 * @since: 5.0.5
	 */
	private function update_template_list(){
		
		$new = get_option('rs-templates-new', false);
		$cur = get_option('rs-templates', array());
		$cur = array();
		
		if($new !== false && !empty($new) && is_array($new)){
			if(empty($cur)){
				$cur = $new;
			}else{
				if(isset($new['slider']) && is_array($new['slider'])){
					foreach($new['slider'] as $n){
						$found = false;
						if(isset($cur['slider']) && is_array($cur['slider'])){
							foreach($cur['slider'] as $ck => $c){
								if($c['uid'] == $n['uid']){
									if(version_compare($c['version'], $n['version'], '<')){
										$n['is_new'] = true;
										$n['push_image'] = true; //push to get new image and replace
									}
									if(isset($c['is_new'])) $n['is_new'] = true; //is_new will stay until update is done
									
									$n['exists'] = true; //if this flag is not set here, the template will be removed from the list
									
									if(isset($n['new_slider'])){
										unset($n['new_slider']); //remove this again, as the new flag should be removed now
									}
									
									$cur['slider'][$ck] = $n;
									$found = true;
									
									break;
								}
							}
						}
						
						if(!$found){
							$n['exists'] = true;
							$n['new_slider'] = true;
							$cur['slider'][] = $n;
						}
						
					}
					
					foreach($cur['slider'] as $ck => $c){ //remove no longer available Slider
						if(!isset($c['exists'])){
							unset($cur['slider'][$ck]);
						}else{
							unset($cur['slider'][$ck]['exists']);
						}
					}
					
					$cur['slides'] = $new['slides']; // push always all slides
				}
			}
			
			RevSliderFunctionsWP::update_option('rs-templates', $cur, false);
			RevSliderFunctionsWP::update_option('rs-templates-new', false, false);
			
			$this->_update_images();
		}
	}
	
	
	/**
	 * Remove the is_new attribute which shows the "update available" button
	 * @since: 5.0.5
	 */
	public function remove_is_new($uid){
		$cur = get_option('rs-templates', array());
		
		if(isset($cur['slider']) && is_array($cur['slider'])){
			foreach($cur['slider'] as $ck => $c){
				if($c['uid'] == $uid){
					unset($cur['slider'][$ck]['is_new']);
					break;
				}
			}
		}
		
		RevSliderFunctionsWP::update_option('rs-templates', $cur, false);
		
	}
	
	
	/**
	 * Update the Images get them from Server and check for existance on each image
	 * @since: 5.0.5
	 */
	private function _update_images(){
		$templates = get_option('rs-templates', array());
		$curl = new WP_Http_Curl();
		if(!$curl->test()){
			$curl = false;
		}
		
		$connection = 0;
		
		$reload = array();
		
		if(!empty($templates) && is_array($templates)){
			$upload_dir = wp_upload_dir(); // Set upload folder
			if(!empty($templates['slider']) && is_array($templates['slider'])){
				foreach($templates['slider'] as $key => $temp){
					
					if($connection > 3) continue; //cant connect to server
						
					// Check folder permission and define file location
					if( wp_mkdir_p( $upload_dir['basedir'].$this->templates_path ) ) {
						$file = $upload_dir['basedir'] . $this->templates_path . '/' . $temp['img'];
						$file_plugin = RS_PLUGIN_PATH . $this->templates_path_plugin . '/' . $temp['img'];
						
						
						if((!file_exists($file) && !file_exists($file_plugin)) || isset($temp['push_image'])){
							if($curl !== false){
								$image_data = @$curl->request($this->templates_url.$this->templates_server_path.$temp['img']); // Get image data
								if(!is_wp_error($image_data) && isset($image_data['body']) && isset($image_data['response']) && isset($image_data['response']['code']) && $image_data['response']['code'] == '200'){
									$image_data = $image_data['body'];
								}else{
									$image_data = false;
								}
							}else{
								$image_data = @file_get_contents($this->templates_url.$this->templates_server_path.$temp['img']); // Get image data
							}
							if($image_data !== false){
								$reload[$temp['alias']] = true;
								unset($templates['slider'][$key]['push_image']);
								@mkdir(dirname($file));
								@file_put_contents( $file, $image_data );
							}else{//could not connect to server
								$connection++;
							}
						}else{//use default image
						}
					}else{//use default images
					}
				}
			}
			if(!empty($templates['slides']) && is_array($templates['slides'])){
				foreach($templates['slides'] as $key => $temp){
					foreach($temp as $k => $tvalues){
						
						if($connection > 3) continue; //cant connect to server
						
						// Check folder permission and define file location
						if( wp_mkdir_p( $upload_dir['basedir'].$this->templates_path ) ) {
							$file = $upload_dir['basedir'] . $this->templates_path . '/' . $tvalues['img'];
							$file_plugin = RS_PLUGIN_PATH . $this->templates_path_plugin . '/' . $tvalues['img'];
							
							if((!file_exists($file) && !file_exists($file_plugin)) || isset($reload[$key])){ //update, so load again
								if($curl !== false){
									$image_data = @$curl->request($this->templates_url.$this->templates_server_path.$tvalues['img']); // Get image data
									if(!is_wp_error($image_data) && isset($image_data['body']) && isset($image_data['response']) && isset($image_data['response']['code']) && $image_data['response']['code'] == '200'){
										$image_data = $image_data['body'];
									}else{
										$image_data = false;
									}
								}else{
									$image_data = @file_get_contents($this->templates_url.$this->templates_server_path.$tvalues['img']); // Get image data
								}
								if($image_data !== false){
									@mkdir(dirname($file));
									@file_put_contents( $file, $image_data );
								}else{//could not connect to server
									$connection++;
								}
							}else{//use default image
							}
						}else{//use default images
						}
						
					}
				}
			}
		}
		
		if($connection > 3){
			//set value that the server cant be contacted
		}
		
		RevSliderFunctionsWP::update_option('rs-templates', $templates, false); //remove the push_image
	}
	
	
	/**
	 * Copy a Slide to the Template Slide list
	 * @since: 5.0
	 */
	public function copySlideToTemplates($slide_id, $slide_title, $slide_settings = array()){
		if(intval($slide_id) == 0) return false;
		$slide_title = sanitize_text_field($slide_title);
		if(strlen(trim($slide_title)) < 3) return false;
		
		global $wpdb;
		
		$table_name = RevSliderGlobals::$table_slides;
		
		$duplicate = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %s", $slide_id), ARRAY_A);
		
		if(empty($duplicate)) // slide not found
			return false;
		
		unset($duplicate['id']);
		
		$duplicate['slider_id'] = -1; //-1 sets it to be a template
		$duplicate['slide_order'] = -1;
		
		$params = json_decode($duplicate['params'], true);
		$settings = json_decode($duplicate['settings'], true);
		
		$params['title'] = $slide_title;
		$params['state'] = 'published';
		
		if(isset($slide_settings['width'])) $settings['width'] = intval($slide_settings['width']);
		if(isset($slide_settings['height'])) $settings['height'] = intval($slide_settings['height']);
		
		$duplicate['params'] = json_encode($params);
		$duplicate['settings'] = json_encode($settings);
		
		$response = $wpdb->insert($table_name, $duplicate);
		
		if($response)
			return true;
		
		return false;
	}
	
	
	/**
	 * Get all Template Slides
	 * @since: 5.0
	 */
	public function getTemplateSlides(){
		global $wpdb;
		
		$table_name = RevSliderGlobals::$table_slides;
		
		$templates = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE slider_id = %s", -1), ARRAY_A);
		
		//add default Template Slides here!
		$default = $this->getDefaultTemplateSlides();
		
		$templates = array_merge($templates, $default);
		
		if(!empty($templates)){
			foreach($templates as $key => $template){
				$templates[$key]['params'] = json_decode($template['params'], true);
				//$templates[$key]['layers'] = json_decode($template['layers'], true);
				$templates[$key]['settings'] = json_decode($template['settings'], true);
			}
		}
		
		return $templates;
	}
	
	
	/**
	 * Add default Template Slides that can't be deleted for example. Authors can add their own Slides here through Filter
	 * @since: 5.0
	 */
	private function getDefaultTemplateSlides(){
		$templates = array();
		
		$templates = apply_filters('revslider_set_template_slides', $templates);
		
		return $templates;
	}
	
	
	/**
	 * get default ThemePunch default Slides
	 * @since: 5.0
	 */
	public function getThemePunchTemplateSlides($sliders = false){
		global $wpdb;
		
		$templates = array();
		
		$slide_defaults = array();//
		
		if($sliders == false){
			$sliders = $this->getThemePunchTemplateSliders();
		}
		$table_name = RevSliderGlobals::$table_slides;
		
		if(!empty($sliders)){
			foreach($sliders as $slider){
				$slides = $this->getThemePunchTemplateDefaultSlides($slider['alias']);
				
				if(!isset($slider['installed'])){
					$templates = array_merge($templates, $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE slider_id = %s", $slider['id']), ARRAY_A));
				}else{
					$templates = array_merge($templates, $slides);
				}
				if(!empty($templates)){
					foreach($templates as $key => $tmpl){
						if(isset($slides[$key])) $templates[$key]['img'] = $slides[$key]['img'];
					}
				}
				
				/*else{
					$templates = array_merge($templates, array($slide_defaults[$slider['alias']]));
				}*/
			}
		}
		
		if(!empty($templates)){
			foreach($templates as $key => $template){
				if(!isset($template['installed'])){
					$template['params'] = (isset($template['params'])) ? $template['params'] : '';
					$template['layers'] = (isset($template['layers'])) ? $template['layers'] : '';
					$template['settings'] = (isset($template['settings'])) ? $template['settings'] : '';
					
					$templates[$key]['params'] = json_decode($template['params'], true);
					//$templates[$key]['layers'] = json_decode($template['layers'], true);
					$templates[$key]['settings'] = json_decode($template['settings'], true);
					
					//$templates[$key][]
					//add missing uid and zipname
				}
			}
		}
		
		return $templates;
	}
	
	
	/**
	 * get default ThemePunch default Slides
	 * @since: 5.0
	 */
	public function getThemePunchTemplateDefaultSlides($slider_alias){
		
		$templates = get_option('rs-templates', array());
		$slides = (isset($templates['slides']) && !empty($templates['slides'])) ? $templates['slides'] : array();
		
		return (isset($slides[$slider_alias])) ? $slides[$slider_alias] : array();
	}
	
	
	/**
	 * Get default Template Sliders
	 * @since: 5.0
	 */
	public function getDefaultTemplateSliders(){
		global $wpdb;
		
		$sliders = array();
		$check = array();
		
		$table_name = RevSliderGlobals::$table_sliders;
		
		//add themepunch default Sliders here
		$check = $wpdb->get_results("SELECT * FROM $table_name WHERE type = 'template'", ARRAY_A);
		
		$sliders = apply_filters('revslider_set_template_sliders', $sliders);
		
		/**
		 * Example		 
			$sliders['Slider Pack Name'] = array(
				array('title' => 'PJ Slider 1', 'alias' => 'pjslider1', 'width' => 1400, 'height' => 868, 'zip' => 'exwebproduct.zip', 'uid' => 'bde6d50c2f73f8086708878cf227c82b', 'installed' => false, 'img' => RS_PLUGIN_URL .'admin/assets/imports/exwebproduct.jpg'),
				array('title' => 'PJ Classic Slider', 'alias' => 'pjclassicslider', 'width' => 1240, 'height' => 600, 'zip' => 'classicslider.zip', 'uid' => 'a0d6a9248c9066b404ba0f1cdadc5cf2', 'installed' => false, 'img' => RS_PLUGIN_URL .'admin/assets/imports/classicslider.jpg')
			);
		 **/
		
		if(!empty($check) && !empty($sliders)){
			foreach($sliders as $key => $the_sliders){
				foreach($the_sliders as $skey => $slider){
					foreach($check as $ikey => $installed){
						if($installed['alias'] == $slider['alias']){
							$img = $slider['img'];
							$sliders[$key][$skey] = $installed;
							
							$sliders[$key][$skey]['img'] = $img;
							
							$sliders[$key]['version'] = (isset($slider['version'])) ? $slider['version'] : '';
							if(isset($slider['is_new'])) $sliders[$key]['is_new'] = true;
							
							$preview = (isset($slider['preview'])) ? $slider['preview'] : false;
							if($preview !== false) $sliders[$key]['preview'] = $preview;
							
							break;
						}
					}
				}
			}
		}
		
		return $sliders;
	}
	
	
	/**
	 * get default ThemePunch default Sliders
	 * @since: 5.0
	 */
	public function getThemePunchTemplateSliders(){
		global $wpdb;
		
		$sliders = array();
		
		$table_name = RevSliderGlobals::$table_sliders;
		
		//add themepunch default Sliders here
		$sliders = $wpdb->get_results("SELECT * FROM $table_name WHERE type = 'template'", ARRAY_A);
		
		$defaults = get_option('rs-templates', array());
		$defaults = (isset($defaults['slider'])) ? $defaults['slider'] : array();
		
		if(!empty($sliders)){
			
			if(!empty($defaults)){
				foreach($defaults as $key => $slider){
					foreach($sliders as $ikey => $installed){
						if($installed['alias'] == $slider['alias']){
							//check if $sliders has slides, if not, set for redownload by deleting Template Slider in table
							$c_slides = $this->getThemePunchTemplateSlides(array($installed));
							if(empty($c_slides)){
								//delete slider in table
								$wpdb->delete($table_name, array('type' => 'template', 'id' => $installed['id']));
								break;
							}
							
							$img = $slider['img'];
							$preview = (isset($slider['preview'])) ? $slider['preview'] : false;
							$defaults[$key] = array_merge($defaults[$key], $installed);
							
							unset($defaults[$key]['installed']);
							
							$defaults[$key]['img'] = $img;
							$defaults[$key]['version'] = $slider['version'];
							$defaults[$key]['cat'] = $slider['cat'];
							$defaults[$key]['filter'] = $slider['filter'];
							
							if(isset($slider['is_new'])){
								$defaults[$key]['is_new'] = true;
								$defaults[$key]['width'] = $slider['width'];
								$defaults[$key]['height'] = $slider['height'];
							}
							$defaults[$key]['zip'] = $slider['zip'];
							$defaults[$key]['uid'] = $slider['uid'];
							
							if(isset($slider['new_slider'])) $defaults[$key]['new_slider'] = $slider['new_slider'];
							
							if($preview !== false) $defaults[$key]['preview'] = $preview;
							break;
						}
					}
				}
			}
		}
		
		krsort($defaults);
		
		return $defaults;
	}
	
	
	/**
	 * check if image was uploaded, if yes, return path or url
	 * @since: 5.0.5
	 */
	public function _check_file_path($image, $url = false){
		$upload_dir = wp_upload_dir(); // Set upload folder
		$file = $upload_dir['basedir'] . $this->templates_path . '/' . $image;
		$file_plugin = RS_PLUGIN_PATH . $this->templates_path_plugin . '/' . $image;
		
		if(file_exists($file)){ //downloaded image first, for update reasons
			if($url){
				$image = $upload_dir['baseurl'] . $this->templates_path . '/' . $image;
			}else{
				$image = $upload_dir['basedir'] . $this->templates_path . '/' . $image; //server path
			}
		}elseif(file_exists($file_plugin)){
			if($url){
				$image = RS_PLUGIN_URL . $this->templates_path_plugin . '/' . $image;
			}else{
				$image = RS_PLUGIN_URL . $this->templates_path_plugin . '/' . $image;
				//$image = $file_plugin; //server path
			}
		}else{
			//redownload image from server and store it
			$this->_update_images();
			if(file_exists($file)){ //downloaded image first, for update reasons
				if($url){
					$image = $upload_dir['baseurl'] . $this->templates_path . '/' . $image;
				}else{
					$image = $upload_dir['basedir'] . $this->templates_path . '/' . $image; //server path
				}
			}else{
				$image = false;
			}
		}
		
		return $image;
	}
	
	/**
	 * output markup for the import template, the zip was not yet improted
	 * @since: 5.0
	 */
	public function write_import_template_markup($template){
		
		$template['img'] = $this->_check_file_path($template['img'], true);
		if($template['img'] == ''){
			//set default image
		}
		
		//check for version and compare, only allow download if version is high enough
		$deny = '';
		if(isset($template['required'])){
			if(version_compare(RevSliderGlobals::SLIDER_REVISION, $template['required'], '<')){
				$deny = ' deny_download';
			}
		}
		?>
		<div data-src="<?php echo $template['img']; ?>" class="template_slider_item_import"
			data-gridwidth="<?php echo $template['width']; ?>"
			data-gridheight="<?php echo $template['height']; ?>"
			data-zipname="<?php echo $template['zip']; ?>"
			data-uid="<?php echo $template['uid']; ?>"
			<?php
			if($deny !== ''){ //add needed version number here 
				?>
				data-versionneed="<?php echo $template['required']; ?>"
				<?php
			}
			?>
			>
			<?php /* <!--div class="template_title"><?php echo (isset($template['title'])) ? $template['title'] : ''; ?></div-->*/ ?>
			
			
			<div class="template_thumb_overview"></div>
			<div class="template_preview_add_wrapper">
				<?php if(isset($template['preview']) && $template['preview'] !== ''){ ?>
				<a class="preview_template_slider" href="<?php echo esc_attr($template['preview']); ?>" target="_blank"><i class="eg-icon-search"></i></a>
				<?php } ?>
				<span class="show_more_template_slider"><i class="eg-icon-plus"></i></span>

			</div>
		</div>

		<div class="template_thumb_more">
			<span class="ttm_label"><?php echo $template['title'];?></span>
			<?php
			if(isset($template['description'])){
				echo $template['description'];
			}
			if(isset($template['setup_notes']) && !empty($template['setup_notes'])){
				?>
				<span class="ttm_label"><?php _e('Setup Notes', 'revslider'); ?></span>
				<?php
				echo $template['setup_notes'];
				?>
				<span class="ttm_space"></span>				
				<?php
			}
			?>
			<span class="ttm_label"><?php _e('Requirements', 'revslider'); ?></span>
			<ul class="ttm_requirements">
				<li><?php
				if(version_compare(RevSliderGlobals::SLIDER_REVISION, $template['required'], '>=')){
					?><i class="eg-icon-check"></i><?php
				}else{
					?><i class="eg-icon-cancel"></i><?php
					$allow_install = false;
				}				
				_e('Slider Revolution Version', 'revslider');
				echo ' '.$template['required'];
				?></li>
				<?php
				$allow_install = true;
				if(isset($template['plugin_require']) && !empty($template['plugin_require'])){
					foreach($template['plugin_require'] as $pk => $pr){
						if($pr['installed'] === true){
							$pr_icon = '<i class="eg-icon-check"></i>';
						}else{
							$pr_icon = '<i class="eg-icon-cancel"></i>';
							$allow_install = false;
						}
						
						echo '<li>';
						 echo $pr_icon; //echo the icon
						if(isset($pr['url'])) echo '<a href="'.esc_attr($pr['url']).'" target="_blank">';
						echo $pr['name'];
						if(isset($pr['url'])) echo '</a>';
						echo '</li>';
					}
				}
				?>
			</ul>		
			<span class="ttm_space"></span>
			<span class="ttm_label_direct"><?php _e('Available Version', 'revslider'); ?></span>
			<span class="ttm_label_half ttm_available"><?php echo $template['version'];?></span>	
			<span class="ttm_space"></span>
			<?php
			if($deny == '' && $allow_install == true){
				?>
				<div class="install_template_slider<?php echo $deny; ?>" data-zipname="<?php echo $template['zip']; ?>" data-uid="<?php echo $template['uid']; ?>"><i class="eg-icon-download"></i><?php _e('Install Slider', 'revslider'); ?></div>							
				<?php
				if(isset($template['package']) && $template['package'] !== ''){
					?>
					<span class="tp-clearfix" style="margin-bottom:5px"></span>
					<div class="install_template_slider_package<?php echo $deny; ?>" data-zipname="<?php echo $template['zip']; ?>" data-uid="<?php echo $template['uid']; ?>"><i class="eg-icon-download"></i><?php _e('Install Slider Pack', 'revslider'); ?></div>							
					<?php
				}
			} else {
				?>
				<div class="dontadd_template_slider_item"><i class="icon-not-registered"></i><?php _e('Requirements not met', 'revslider'); ?></div>
				<?php
			}
			?>
			<span class="tp-clearfix" style="margin-bottom:5px"></span>
			
		</div>

		<?php
	}
	
	
	/**
	 * output markup for the import template, the zip was not yet imported
	 * @since: 5.0
	 */
	public function write_import_template_markup_slide($template){
		
		$template['img'] = $this->_check_file_path($template['img'], true);
		
		if($template['img'] == ''){
			//set default image
		}
		//check for version and compare, only allow download if version is high enough
		$deny = '';
		if(isset($template['required'])){
			if(version_compare(RevSliderGlobals::SLIDER_REVISION, $template['required'], '<')){
				$deny = ' deny_download';
			}
		}
		?>
		<div class="template_slide_item_import">
			<div class="template_slide_item_img<?php echo $deny; ?>" 
				data-src="<?php echo $template['img']; ?>" 
				data-gridwidth="<?php echo $template['width']; ?>"
				data-gridheight="<?php echo $template['height']; ?>"
				data-zipname="<?php echo $template['zip']; ?>"
				data-uid="<?php echo $template['uid']; ?>"
				data-slidenumber="<?php echo $template['number']; ?>"
				<?php
				if($deny !== ''){ //add needed version number here 
					?>
					data-versionneed="<?php echo $template['required']; ?>"
					<?php
				}
				?>
			></div>
			<div class="template_thumb_overview"></div>
			<div class="template_preview_add_wrapper">				
				<span class="show_more_template_slider"><i class="eg-icon-plus"></i></span>
			</div>
			
		</div>

		<div class="template_thumb_more">
			<span class="ttm_label"><?php echo $template['title'];?></span>
			<?php
			if(isset($template['description'])){
				echo $template['description'];
			}
			?>
			<?php
			if(isset($template['setup_notes']) && !empty($template['setup_notes'])){
				?>
				<span class="ttm_label"><?php _e('Setup Notes', 'revslider'); ?></span>
				<?php
				echo $template['setup_notes'];
				?>
				<span class="ttm_space"></span>				
				<?php
			}
			?>
			<span class="ttm_label"><?php _e('Requirements', 'revslider'); ?></span>
			<ul class="ttm_requirements">
				<li><?php
				$allow_install = true;
				if(version_compare(RevSliderGlobals::SLIDER_REVISION, $template['required'], '>=')){
					?><i class="eg-icon-check"></i><?php
				}else{
					?><i class="eg-icon-cancel"></i><?php
					$allow_install = false;
				}				
				_e('Slider Revolution Version', 'revslider');
				echo ' '.$template['required'];
				?></li>
				<?php
				
				if(isset($template['plugin_require']) && is_array($template['plugin_require']) && !empty($template['plugin_require'])){
					foreach($template['plugin_require'] as $pk => $pr){
						if($pr['installed'] === true){
							$pr_icon = '<i class="eg-icon-check"></i>';
						}else{
							$pr_icon = '<i class="eg-icon-cancel"></i>';
							$allow_install = false;

						}
						
						echo '<li>';
						echo $pr_icon; //echo the icon
						if(isset($pr['url'])) echo '<a href="'.esc_attr($pr['url']).'" target="_blank">';
						echo $pr['name'];
						if(isset($pr['url'])) echo '</a>';
						echo '</li>';
					}
				}

				//allow / disallow download
				?>
			</ul>		
			<span class="ttm_space"></span>
			<span class="ttm_label_direct"><span class="ttm_label_half"><?php _e('Installed Vers.', 'revslider'); ?></span><span class="ttm_label_half"><?php _e('Available Vers.', 'revslider'); ?></span></span>
			<span class="ttm_label_half ttm_insalled"><span class="ttm_label_half ttm_available"><?php echo $template['version'];?></span>	
			<span class="ttm_space"></span>	
			<?php
			if($deny == '' && $allow_install == true){
				?>
				<div class="install_template_slide<?php echo $deny; ?>" data-slidenumber="<?php echo $template['number']; ?>" data-zipname="<?php echo $template['zip']; ?>" data-uid="<?php echo $template['uid']; ?>"><i class="eg-icon-download"></i><?php _e('Install Slider', 'revslider'); ?></div>							
				<?php
			} else {
				?>
				<div class="dontadd_template_slider_item"><i class="icon-not-registered"></i><?php _e('Requirements not met', 'revslider'); ?></div>
				<?php
			}
			?>
			<span class="tp-clearfix" style="margin-bottom:5px"></span>
			
		</div>

		<?php
	}
	
	
	/**
	 * output markup for template
	 * @since: 5.0
	 */
	public function write_template_markup($template, $slider_id = false){
		$params = $template['params'];
		$settings = $template['settings'];
		$slide_id = $template['id'];
		

		if($slider_id !== false) $title = ''; //remove Title if Slider
		
		$width = RevSliderBase::getVar($settings, "width", 1240);
		$height = RevSliderBase::getVar($settings, "height", 868);
		
		$bgType = RevSliderBase::getVar($params, "background_type","transparent");
		$bgColor = RevSliderBase::getVar($params, "slide_bg_color","transparent");

		$bgFit = RevSliderBase::getVar($params, "bg_fit","cover");
		$bgFitX = intval(RevSliderBase::getVar($params, "bg_fit_x","100"));
		$bgFitY = intval(RevSliderBase::getVar($params, "bg_fit_y","100"));

		$bgPosition = RevSliderBase::getVar($params, "bg_position","center center");
		$bgPositionX = intval(RevSliderBase::getVar($params, "bg_position_x","0"));
		$bgPositionY = intval(RevSliderBase::getVar($params, "bg_position_y","0"));

		$bgRepeat = RevSliderBase::getVar($params, "bg_repeat","no-repeat");

		$bgStyle = ' ';
		if($bgFit == 'percentage'){
			if(intval($bgFitY) == 0 || intval($bgFitX) == 0){
				$bgStyle .= "background-size: cover;";
			}else{
				$bgStyle .= "background-size: ".$bgFitX.'% '.$bgFitY.'%;';
			}
		}else{
			$bgStyle .= "background-size: ".$bgFit.";";
		}
		if($bgPosition == 'percentage'){
			$bgStyle .= "background-position: ".$bgPositionX.'% '.$bgPositionY.'%;';
		}else{
			$bgStyle .= "background-position: ".$bgPosition.";";
		}
		$bgStyle .= "background-repeat: ".$bgRepeat.";";
		
		
		if(isset($template['img'])){
			$thumb = $this->_check_file_path($template['img'], true);
		}else{
			$imageID = RevSliderBase::getVar($params, "image_id");
			if(empty($imageID)){
				$thumb = RevSliderBase::getVar($params, "image");
		
				$imgID = RevSliderBase::get_image_id_by_url($thumb);
				if($imgID !== false){
					$thumb = RevSliderFunctionsWP::getUrlAttachmentImage($imgID, RevSliderFunctionsWP::THUMB_MEDIUM);
				}
			}else{
				$thumb = RevSliderFunctionsWP::getUrlAttachmentImage($imageID,RevSliderFunctionsWP::THUMB_MEDIUM);
			}
		
			if($thumb == '') $thumb = RevSliderBase::getVar($params, "image");
		}
		
		$bg_fullstyle ='';
		$bg_extraClass='';
		$data_urlImageForView='';

		if(isset($template['img'])){
			$data_urlImageForView = 'data-src="'.$thumb.'"';
		}else{
			if($bgType == 'image' || $bgType == 'vimeo' || $bgType == 'youtube' || $bgType == 'html5') {
				$data_urlImageForView = 'data-src="'.$thumb.'"';
				$bg_fullstyle =' style="'.$bgStyle.'" ';
			}

			if($bgType=="solid")
				$bg_fullstyle =' style="background-color:'.$bgColor.';" ';
				
			if($bgType=="trans" || $bgType=="transparent")
				$bg_extraClass = 'mini-transparent';
		}
		?>
		<div class="template_slide_single_element" style="display:inline-block">
			<div <?php echo $data_urlImageForView; ?> class="<?php echo ($slider_id !== false) ? 'template_slider_item' : 'template_item'; ?> <?php echo $bg_extraClass; ?>" <?php echo $bg_fullstyle; ?>
				data-gridwidth="<?php echo $width; ?>"
				data-gridheight="<?php echo $height; ?>"
				<?php if($slider_id !== false){ ?>
				data-sliderid="<?php echo $slider_id; ?>"
				<?php }else{ ?>
				data-slideid="<?php echo $slide_id; ?>"
				<?php } ?>
				>																					
			</div>
			<div class="template_thumb_overview"></div>
			<div class="template_preview_add_wrapper">
				<?php if(isset($template['preview']) && $template['preview'] !== ''){ ?>
				<a class="preview_template_slider" href="<?php echo esc_attr($template['preview']); ?>" target="_blank"><i class="eg-icon-search"></i></a>
				<?php } ?>
				<span data-sliderid="<?php echo $slider_id; ?>" data-slideid="<?php echo $slide_id; ?>" class="show_more_template_slider <?php if (isset($template["user_template"])) echo 'add_user_template_slide_item'; ?>"><i class="eg-icon-plus"></i></span>

			</div>
			<?php if($slider_id == false){ ?>
				
			<?php } ?>

		</div>
		<?php 
		if (isset($template["user_template"])) {
			// USER TEMPLATE, CAN BE IGNORED
		} else {
			?>
			<div class="template_thumb_more">
				<?php if (isset($template['title']))  { 
				?>	
					<span class="ttm_label"><?php echo $template['title'];?></span>
					<?php
					if(isset($template['description'])){
						echo $template['description'];
					}
				}
					?>
				<?php
				if(isset($template['setup_notes']) && !empty($template['setup_notes'])){
					?>
					<span class="ttm_label"><?php _e('Setup Notes', 'revslider'); ?></span>
					<?php
					echo $template['setup_notes'];
					?>
					<span class="ttm_space"></span>				
					<?php
				}
				?>
				<span class="ttm_label"><?php _e('Requirements', 'revslider'); ?></span>
				<ul class="ttm_requirements">
					<?php 
					$allow_install = true;
					if (isset($template['required'])) {
						?>
						<li><?php
				
				
						if(version_compare(RevSliderGlobals::SLIDER_REVISION, $template['required'], '>=')){
							?><i class="eg-icon-check"></i><?php
						}else{
							?><i class="eg-icon-cancel"></i><?php
							$allow_install = false;
						}				
						_e('Slider Revolution Version', 'revslider');
						echo ' '.$template['required'];
						?></li>					
						<?php
					}
					
					if(isset($template['plugin_require']) && !empty($template['plugin_require'])){
						foreach($template['plugin_require'] as $pk => $pr){
							if($pr['installed'] === true){
								$pr_icon = '<i class="eg-icon-check"></i>';
							}else{
								$pr_icon = '<i class="eg-icon-cancel"></i>';
								$allow_install = false;

							}
							
							echo '<li>';
							echo $pr_icon; //echo the icon
							if(isset($pr['url'])) echo '<a href="'.esc_attr($pr['url']).'" target="_blank">';
							echo $pr['name'];
							if(isset($pr['url'])) echo '</a>';
							echo '</li>';
						}
					}

					//allow / disallow download
					?>
				</ul>		
				<?php
				if (isset($template['version'])) {
					?>
					<span class="ttm_space"></span>
					<span class="ttm_label_direct"><span class="ttm_label_half"><?php _e('Installed Vers.', 'revslider'); ?></span><span class="ttm_label_half"><?php _e('Available Vers.', 'revslider'); ?></span></span>
					<span class="ttm_label_half ttm_insalled"><?php echo isset($template['current_version']) ? $template['current_version'] : 'N/A';?></span><span class="ttm_label_half ttm_available"><?php echo $template['version'];?></span>	
					<?php 
				}
				?>
				<span class="ttm_space"></span>		
				<?php
				if ($allow_install !== false) {
					if($slider_id !== false){
						?>								
						<div class="install_template_slider" data-zipname="<?php echo $template['zip']; ?>" data-uid="<?php echo $template['uid']; ?>"><i class="eg-icon-download"></i><?php _e('Re-Install Slider', 'revslider'); ?></div>							
						<span class="tp-clearfix" style="margin-bottom:5px"></span>
						<?php
						if(isset($template['package']) && $template['package'] !== ''){
							$txt = ($template['package_full_installded']) ? __('Re-Install Slider Pack', 'revslider') : __('Install Slider Pack', 'revslider');
							?>
							<div class="install_template_slider_package" data-zipname="<?php echo $template['zip']; ?>" data-uid="<?php echo $template['uid']; ?>"><i class="eg-icon-download"></i><?php echo $txt; ?></div>							
							<span class="tp-clearfix" style="margin-bottom:5px"></span>
							<?php
						}
					}
					?>	 
					<?php
					if($slider_id !== false){
						?>
						<div class="add_template_slider_item" data-sliderid="<?php echo $slider_id; ?>">
						<?php
					}else{
						?>
						<div class="add_template_slide_item" data-slideid="<?php echo $slide_id; ?>">
						<?php
					}
					?>
					<i class="eg-icon-plus"></i><?php if ($slider_id == false) { echo __('Add Slide', 'revslider'); } else { echo __('Add Slider', 'revslider'); } ?></div>	
					<?php
					if ($slider_id !== false && isset($template['package']) && $template['package'] !== '' && $template['package_full_installded']) {
						?>
						<div class="add_template_slider_item_package" data-uid="<?php echo $template['uid']; ?>"><i class="eg-icon-plus"></i><?php echo __('Add Slider Pack', 'revslider'); ?></div>
						<?php
					}
				} else {
					?>
					<div class="dontadd_template_slider_item"><i class="icon-not-registered"></i><?php _e('Requirements not met', 'revslider'); ?></div>
					<?php
				} ?>
			</div>		
			<?php
		}
	}
	
	
	/**
	 * Get all uids from a certain package, by one uid
	 * @since: 5.2.5
	 */
	public function get_package_uids($uid, $sliders = false){
		if($sliders == false){
			$sliders = $this->getThemePunchTemplateSliders();
		}
		
		$uids = array();
		
		$package = false;
		foreach($sliders as $slider){
			if($slider['uid'] == $uid){
				if(isset($slider['package'])){
					$package = $slider['package'];
				}
				break;
			}
		}
		
		if($package !== false){
			$i = 0;
			foreach($sliders as $slider){
				if(isset($slider['package']) && $slider['package'] == $package){
					if(isset($slider['installed'])){ //add an invalid slider id as we have not yet installed it
						$i--;
						$sid = $i;
					}else{ //add the installed slider id, as we have the template installed already
						$sid = $slider['id'];
					}
					$uids[$sid] = $slider['uid'];
				}
			}
		}
		
		return $uids;
	}
	
	/**
	 * check if all Slider of a certain package is installed, do this with the uid of a slider
	 * @since: 5.2.5
	 */
	public function check_package_all_installed($uid, $sliders = false){
		$uids = $this->get_package_uids($uid, $sliders);
		
		foreach($uids as $sid => $uid){
			if($sid < 0) return false;
		}
		
		return true;
		
	}
}

?>