<?php 
/* forked from : Plugin URI: http://wordpress.org/plugins/new-google-plus-badge-widget/
 Thanks To : MyThemeShop and Suraj Vibhute
*/

add_action('widgets_init', 'mom_googleplus_load_widgets');

function mom_googleplus_load_widgets()
{
	register_widget('mom_googleplus_Widget');
}

class mom_googleplus_Widget extends WP_Widget {
	var $langs = array(
'af' => 'Afrikaans',
'am' => 'Amharic',
'ar' => 'Arabic',
'eu' => 'Basque',
'bn' => 'Bengali',
'bg' => 'Bulgarian',
'ca' => 'Catalan',
'zh-HK' => 'Chinese (Hong Kong)',
'zh-CN' => 'Chinese (Simplified)',
'zh-TW' => 'Chinese (Traditional)',
'hr' => 'Croatian',
'cs' => 'Czech',
'da' => 'Danish',
'nl' => 'Dutch',
'en-GB' => 'English (UK)',
'en-US' => 'English (US)',
'et' => 'Estonian',
'fil' => 'Filipino',
'fi' => 'Finnish',
'fr' => 'French',
'fr-CA' => 'French (Canadian)',
'gl' => 'Galician',
'de' => 'German',
'el' => 'Greek',
'gu' => 'Gujarati',
'iw' => 'Hebrew',
'hi' => 'Hindi',
'hu' => 'Hungarian',
'is' => 'Icelandic',
'id' => 'Indonesian',
'it' => 'Italian',
'ja' => 'Japanese',
'kn' => 'Kannada',
'ko' => 'Korean',
'lv' => 'Latvian',
'lt' => 'Lithuanian',
'ms' => 'Malay',
'ml' => 'Malayalam',
'mr' => 'Marathi',
'no' => 'Norwegian',
'fa' => 'Persian',
'pl' => 'Polish',
'pt-BR' => 'Portuguese (Brazil)',
'pt-PT' => 'Portuguese (Portugal)',
'ro' => 'Romanian',
'ru' => 'Russian',
'sr' => 'Serbian',
'sk' => 'Slovak',
'sl' => 'Slovenian',
'es' => 'Spanish',
'es-419' => 'Spanish (Latin America)',
'sw' => 'Swahili',
'sv' => 'Swedish',
'ta' => 'Tamil',
'te' => 'Telugu',
'th' => 'Thai',
'tr' => 'Turkish',
'uk' => 'Ukrainian',
'ur' => 'Urdu',
'vi' => 'Vietnamese',
'zu' => 'Zulu',
	);
	
	function mom_googleplus_Widget()
	{
		$widget_ops = array('classname' => 'mom_googleplus', 'description' => __('Adds a beautiful Google Plus badge widget.','framework'));
		parent::__construct('momizat-googlebadgebox', __('Google+ Badge Box','framework'), $widget_ops);
	}
	
	function widget($args, $instance)
	{
		extract($args);

		$title = apply_filters('widget_title', $instance['title']);		
		$page_type = $instance['page_type'];
		$page_url = $instance['page_url'];
		$width = $instance['width'];
		$color_scheme = $instance['color_scheme'];
		$gp_layout = $instance['gp_layout'];
		$cover_photo = isset($instance['cover_photo']) ? 'true' : 'false';
		$tagline = isset($instance['tagline']) ? 'true' : 'false';
		$lang = $instance['lang'];
		echo $before_widget;

		if($title) {
			echo $before_title.$title.$after_title;
		}
		?>
<div class="mom-googleplus-widget">
	<div class="mgw-inner">
		<?php
		if($page_url): ?>	
			<div <?php if($page_type == 'profile') { ?>class="g-person"<?php } elseif($page_type == 'page') { ?>class="g-page"<?php } elseif($page_type == 'community') { ?>class="g-community"<?php } ?> data-width="<?php echo $width; ?>" data-href="<?php echo $page_url; ?>" data-layout="<?php echo $gp_layout; ?>" data-theme="<?php echo $color_scheme; ?>" data-rel="publisher" data-showtagline="<?php echo $tagline; ?>" data-showcoverphoto="<?php echo $cover_photo; ?>"></div>
			<!-- Place this tag after the last badgev2 tag. -->
			<script type="text/javascript">
				var lang = '<?php echo $lang; ?>';
				if (lang !== '') {
					 window.___gcfg = {lang: lang};
				}
			  (function() {
				var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
				po.src = 'https://apis.google.com/js/plusone.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
			  })();
			</script>
		<?php endif;
		?>
	</div>		
<div class="mgw-cover"></div>
</div>

		<?php
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['page_type'] = $new_instance['page_type'];
		$instance['page_url'] = $new_instance['page_url'];
		$instance['width'] = $new_instance['width'];
		$instance['gp_layout'] = $new_instance['gp_layout'];
		$instance['color_scheme'] = $new_instance['color_scheme'];
		$instance['cover_photo'] = $new_instance['cover_photo'];
		$instance['tagline'] = $new_instance['tagline'];
		$instance['lang'] = $new_instance['lang'];
		
		return $instance;
	}

	function form($instance)
	{
		$defaults = array('title' => __('Google+','framework'), 'page_url' => '', 'width' => '336', 'color_scheme' => 'light', 'gp_layout' => 'portrait', 'page_type' => 'profile', 'cover_photo' => 'on', 'tagline' => 'on', 'lang' => '');
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title','framework'); ?>:</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('page_type'); ?>"><?php _e('Page type','framework'); ?>:</label> 
			<select id="<?php echo $this->get_field_id('page_type'); ?>" name="<?php echo $this->get_field_name('page_type'); ?>" class="widefat">
				<option <?php if ('profile' == $instance['page_type']) echo 'selected="selected"'; ?>>profile</option>
				<option <?php if ('page' == $instance['page_type']) echo 'selected="selected"'; ?>>page</option>
				<option <?php if ('community' == $instance['page_type']) echo 'selected="selected"'; ?>>community</option>
			</select>
		</p>		
		<p>
			<label for="<?php echo $this->get_field_id('page_url'); ?>"><?php _e('Google+ Page URL','framework'); ?>:</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('page_url'); ?>" name="<?php echo $this->get_field_name('page_url'); ?>" value="<?php echo $instance['page_url']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Width','framework'); ?>:</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" value="<?php echo $instance['width']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('color_scheme'); ?>"><?php _e('Color Scheme','framework'); ?>:</label> 
			<select id="<?php echo $this->get_field_id('color_scheme'); ?>" name="<?php echo $this->get_field_name('color_scheme'); ?>" class="widefat">
				<option value="light" <?php selected($instance['color_scheme'], 'light'); ?>><?php _e('Light', 'framework'); ?></option>
				<option value="dark" <?php selected($instance['color_scheme'], 'dark'); ?>><?php _e('Dark', 'framework'); ?></option>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('gp_layout'); ?>"><?php _e('Layout','framework'); ?>:</label> 
			<select id="<?php echo $this->get_field_id('gp_layout'); ?>" name="<?php echo $this->get_field_name('gp_layout'); ?>" class="widefat">
				<option value="portrait" <?php selected($instance['gp_layout'], 'portrait'); ?>><?php _e('Portrait', 'framework'); ?></option>
				<option value="landscape" <?php selected($instance['gp_layout'], 'landscape'); ?>><?php _e('Landscape', 'framework'); ?></option>
			</select>
		</p>
		
		<p>
			<b><?php _e('Portrait Layout Settings','framework'); ?></b>
		</p>
		
		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['cover_photo'], 'on'); ?> id="<?php echo $this->get_field_id('cover_photo'); ?>" name="<?php echo $this->get_field_name('cover_photo'); ?>" /> 
			<label for="<?php echo $this->get_field_id('cover_photo'); ?>"><?php _e('Cover Photo','framework'); ?></label>
		</p>
		
		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['tagline'], 'on'); ?> id="<?php echo $this->get_field_id('tagline'); ?>" name="<?php echo $this->get_field_name('tagline'); ?>" /> 
			<label for="<?php echo $this->get_field_id('tagline'); ?>"><?php _e('Tagline','framework'); ?></label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('lang'); ?>"><?php _e('Language','framework'); ?>:</label> 
			<select id="<?php echo $this->get_field_id('lang'); ?>" name="<?php echo $this->get_field_name('lang'); ?>" style="width:100%;">
			<option value=""><?php _e('Select Language ...', 'framework'); ?></option>
			<?php foreach ($this->langs as $code => $name) { ?>
				<option value="<?php echo $code; ?>" <?php selected($instance['lang'], $code); ?>><?php echo $name; ?></option>
			<?php } ?>
			</select>
		</p>
		
	<?php
	}
}