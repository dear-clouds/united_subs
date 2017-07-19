<?php

class rhc_post_info_metabox {
	var $post_type;
	var $capability;
	var $debug=false;
	function __construct($post_type,$capability){
		if(!class_exists('post_meta_boxes'))require_once('class.post_meta_boxes.php');		
		$this->post_type = $post_type;
		$this->capability = $capability;
		$this->metabox_meta_fields = array("fc_post_info");
		$this->post_meta_boxes = new post_meta_boxes(array(
			'post_type'=>$post_type,
			'options'=>$this->metaboxes(),
			'styles'=>array(),
			'scripts'=>array('postinfo-metabox','calendarize'),
			'metabox_meta_fields' =>  'post_info_metabox_meta_fields',
			'pluginpath'=>RHC_PATH
		));
		$this->post_meta_boxes->save_fields = $this->metabox_meta_fields;
		//---
		add_action('wp_ajax_get_postinfo_'.$post_type, array(&$this,'wp_ajax_get_postinfo'));
		add_action('wp_ajax_update_postinfo_'.$post_type, array(&$this,'wp_ajax_update_postinfo'));
		add_action('wp_ajax_set_pinfo_default_'.$post_type, array(&$this,'wp_ajax_set_pinfo_default'));
		add_action('wp_ajax_pinfo_reset_to_default_'.$post_type, array(&$this,'wp_ajax_pinfo_reset_to_default'));
		//----
		add_action('wp_insert_post', array(&$this,'wp_insert_post'), 10, 2 );
		add_filter('postinfo_postmeta_exclude', array(&$this,'postinfo_postmeta_exclude'), 10, 1);//post meta fields values not to show in post info.
	}
	
	function postinfo_postmeta_exclude($arr){
		return array_merge($arr,array(
			'rhc_month_image', 'ce_draft', 'enable_venuebox_gmap', 'extra_info_size', 'fc_click_link','fc_exdate', 'fc_rdate', 'enable_postinfo','enable_featuredimage','enable_venuebox','enable_postinfo_image','rhc_top_image', 'rhc_dbox_image', 'rhc_tooltip_image'
		));
	}
	
	function wp_insert_post( $post_ID, $post ){
		if( 'auto-draft' == $post->post_status && $this->post_type == $post->post_type ){
			if($post_ID>0){
				if (current_user_can($this->capability, $post_ID)){
					global $rhc_plugin;
					$postinfo_boxes		= $rhc_plugin->get_option('postinfo_boxes',false,true);
					if(false!==$postinfo_boxes){	
						foreach($postinfo_boxes as $id => $o){
							foreach($o->data as $data_id => $data_o){
								@$postinfo_boxes[$id]->data[$data_id]->post_ID = $post_ID;
							}
						}					
						update_post_meta($post_ID,'postinfo_boxes',$postinfo_boxes);					
					}
				}			
			}			
		}
	}
	
	function wp_ajax_update_postinfo(){
		$out = '';
		$r = array();
		$save = array();
		foreach(array('columns'=>2,'postinfo_boxes_id'=>0,'post_ID'=>0,'content_span'=>6) as $field => $default){
			$$field = isset($_POST[$field])?$_POST[$field]:$default;
		}
		if($_POST['post_ID']>0 && !empty($_POST['data'])){
			$k = 0;
			foreach($_POST['data'] as $info){
				if(is_array($info)){
					if($info['type']!='separator')$k++;
					$info['post_ID'] = $_POST['post_ID'];
		
					$r[] = new rhc_post_info_field($info);
					$save[] = new rhc_post_info_field($info);
				}
			}
		}

		//--
		if($post_ID>0){
			if (current_user_can($this->capability, $post_ID)){
				$meta_value = get_post_meta($post_ID,'postinfo_boxes',true);
				$meta_value = is_array($meta_value)?$meta_value:array();
				$meta_value[$postinfo_boxes_id] = (object)array(
					'id'		=> $postinfo_boxes_id,
					'columns'	=> $columns,
					'span'		=> $content_span,
					'data'		=> $save
				);	
				
				update_post_meta($post_ID,'postinfo_boxes',$meta_value);
			}			
		}
		//--
		global $post;
		$post = (object)array();
		$post->ID = $post_ID;
		$post->post_type = $this->post_type;
		$out = do_shortcode('[rhc_post_info frontend="0" id="'.$postinfo_boxes_id.'"]');
		
		$response = (object)array(
			'R'=>'OK',
			'MSG'=>'',
			'HTML'=>$out,
			'ITEMS'=>$r
		);
		die(json_encode($response));
	}
	
	function metaboxes($t=array()){
		
		if( false === apply_filters('event_venue_detail_metabox', true) ){
			return $t;
		}
		
		$i = count($t);
		//------------------------------
		$i++;
		$t[$i]=(object)array();
		$t[$i]->id 			= 'rhc-post-info'; 
		$t[$i]->label 		= __('Event, Venue & Tooltip Details Box Layout','rhc');
		$t[$i]->right_label	= __('Event, Venue & Tooltip Details Box Layout','rhc');
		$t[$i]->page_title	= __('Event, Venue & Tooltip Details Box Layout','rhc');
		$t[$i]->theme_option = true;
		$t[$i]->plugin_option = true;
		$t[$i]->options = array(
			(object)array(
				'id'=>'rhc_post_info',
				'type'=>'callback',
				'postinfo_boxes_id'=>'detailbox',//default selected view
				'callback'=> array(&$this,'body')
			),
			(object)array(
				'type'=>'clear'
			)
		);
		//------------------------------
		return $t;
	}	
	
	function body($tab,$i,$o){
		global $post,$rhc_plugin;
		
		$taxonomies = $this->get_post_taxonomies();
		$metafields = $this->get_meta_fields($post);
		$taxonomies_meta_fields = $this->get_taxonomies_meta_fields($taxonomies);
		
		$postinfo_boxes_id = property_exists($o,'postinfo_boxes_id')?$o->postinfo_boxes_id:'detailbox';
		$postinfo_boxes = rhc_post_info_shortcode::get_post_extra_info($post->ID,$postinfo_boxes_id);
		$extra_info_size = $postinfo_boxes->span;
		$extra_info_columns = $postinfo_boxes->columns;

		$content_columns = array(1,2,3);
		$holder_proportions = array( 
			'3' => array('1-4_3-4', __('1/4 content - 3/4 Image','rhc')), 
			'4' => array('1-3_2-3', __('1/3 content - 2/3 Image','rhc')), 
			'6' => array('1-2_1-2', __('1/2 content - 1/2 Image','rhc')), 
			'8' => array('2-3_1-3', __('2/3 content - 1/3 Image','rhc')), 
			'9' => array('3-4_1-4', __('3/4 content - 1/4 Image','rhc')) 
		);
		include 'quick_icons.php';//defines $quick_icons
		$quick_icons = apply_filters('rhc_post_info_quick_icons',$quick_icons);
		//do not allow any quick icon related to disabled taxonomies		
		foreach($quick_icons as $i => $g){
			if(count($g->items)>0){
				$tmp = array();
				foreach($g->items as $j => $item){
					if( !empty($item->post_extrainfo_taxonomy) ){
						if( !taxonomy_exists($item->post_extrainfo_taxonomy) ){
							continue;
						}
					}
					
					if( !empty($item->post_extrainfo_taxonomymeta) ){
						$arr = explode('|', $item->post_extrainfo_taxonomymeta);
						if( count($arr)==2 && !taxonomy_exists($arr[1]) ){
							continue;
						}
					}
					
					
					$tmp[]=$item;
				}
				$quick_icons[$i]->items = $tmp;
				if(count($quick_icons[$i]->items)==0){
					unset($quick_icons[$i]);
				}
			}
		}

		include 'postinfo_boxes.php';//defines $postinfo_boxes
		if(isset($postinfo_boxes['venuebox']) && '1'==$rhc_plugin->get_option('disable_'.RHC_VENUE,'',true)){
			unset($postinfo_boxes['venuebox']);
		}
?>

<div class="post_extrainfo-visual-column-control rhc">
<?php foreach($holder_proportions as $span => $p):?>
	<div class="row-fluid pinfo-layout-row">
	<?php foreach($content_columns as $columns): 
		$selected = $extra_info_size==$span && $extra_info_columns==$columns ? 'current-selection' : '';
	?>
		<div class="span4">
			<a class="pinfo-layout-helper <?php echo $selected?>" data-pinfo_columns="<?php echo $columns?>" data-pinfo_span="<?php echo $span?>" title="<?php echo sprintf( __('%s content columns. Holder proportion: %s','rhc'), $columns,$p[1])?>" href="javascript:void(0);">
				<img src="<?php echo RHC_URL.'images/preview/postinfo_layout/'.sprintf('%scolumns_%s.png',$columns,$p[0])?>" />
			</a>
		</div>
	<?php endforeach; ?>
	</div>
<?php endforeach;?>
</div>
<div class="post_extrainfo-column-control" style="<?php echo $this->debug?'':'display:none;'?>">
	<label>Columns:&nbsp;&nbsp;</label>
	<select id="extra_info_columns">
	<?php foreach( array('1','2','3') as $v):?>
	<option <?PHP echo $v==$extra_info_columns?'selected="selected"':'';?> value="<?php echo $v?>"><?php echo $v?></option>
	<?php endforeach;?>
	</select>

	<label><?php _e('Content size / Image size','rhc')?>:&nbsp;&nbsp;</label>
	<select id="extra_info_size">
	<?php foreach( array( '3' => __('1/4 - 3/4','rhc'), '4' => __('1/3 - 2/3','rhc'), '6' => __('Half/Half','rhc'), '8' => __('2/3 - 1/3','rhc'), '9' => __('3/4 - 1/4','rhc') ) as $v => $label):?>
	<option <?PHP echo $v==$extra_info_size?'selected="selected"':'';?> value="<?php echo $v?>"><?php echo $label?></option>
	<?php endforeach;?>
	</select>	
&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="hidden" id="extra_info_separators" class="i-dont-think-this-is-used" value="0"/>
</div>

<div id="post_extrainfo_quick_icons" class="post_extrainfo_quick_icons">
	<ul class="quick_icons_tabs_nav">
		<?php foreach($quick_icons as $group): ?>		
		<li class="quick_icons_tabs"><a href="<?php echo sprintf("#pinfo_%s",$group->id) ?>"><?php echo $group->label?></a></li>
		<?php endforeach; ?>
	</ul>
	<select id="postinfo_boxes_id" class="postinfo_box_select">
		<?php foreach($postinfo_boxes as $id => $box): ?>
			<option value="<?php echo $id ?>"><?php echo $box->label?></option>
		<?php endforeach; ?>
	</select>	
<?php foreach($quick_icons as $group): if(count($group->items)>0):?>
	<div id="<?php echo sprintf("pinfo_%s",$group->id) ?>" class="quick_icon_tab_panel">
	<?php foreach($group->items as $item): ?>
		<div class="pinfo_quick_icon" <?php echo $item->get_parameters_for_html_tag()?>><?php echo $item->label?></div>
	<?php endforeach; ?>
	</div>
<?php endif;endforeach; ?>
	<!-- input -->

	<?php /*do not remove the form, it is used to render each of the added widgets edit forms.*/?>
	<div class="post_extrainfo_control "  style="<?php echo $this->debug?'':'display:none;'?>">
		<div class="post_extrainfo_cell">
			<label><?php _e('Label:','rhc') ?></label>
			<input class="pinfo_input" id="post_extrainfo_label" type="text" name="post_extrainfo_label" value="" />	
		</div>	
		<div class="post_extrainfo_cell">
			<label><?php _e('Width:','rhc') ?></label>
			<select class="pinfo_input" id="post_extrainfo_span" name="post_extrainfo_span">
				<option value="12"><?php _e('Full','rhc')?></option>
				<option value="6"><?php _e('Half','rhc')?></option>
			</select>
		</div>
		<div class="post_extrainfo_cell">
			<label><?php _e('Class:','rhc') ?></label>
			<input class="pinfo_input" id="post_extrainfo_class" type="text" name="post_extrainfo_class" value="" />	
		</div>			
		<div class="post_extrainfo_cell">
			<label><?php _e('Type:','rhc') ?></label>
			<select class="pinfo_input" id="post_extrainfo_type" name="post_extrainfo_type">
				<option value="label"><?php _e('Label','rhc') ?></option>
				<option value="custom"><?php _e('Custom','rhc') ?></option>
				<?php if(count($taxonomies)>0):?>
				<option value="taxonomy"><?php _e('Taxonomy','rhc') ?></option>
				<?php endif;?>
				<?php if(count($taxonomies_meta_fields)>0): ?>
				<option value="taxonomymeta"><?php _e('Taxonomy meta','rhc') ?></option>
				<?php endif;?>
				<option value="postmeta"><?php _e('Post meta data','rhc') ?></option>
			</select>
		</div>	
		<div class="post_extrainfo_cell" style="<?php echo $this->debug?'':'display:none;'?>">
			<label><?php _e('Format:','rhc') ?></label>
			<input class="pinfo_input" id="post_extrainfo_format" type="text" name="post_extrainfo_format" value="" />	
		</div>	

		<div class="post_extrainfo_cell" style="<?php echo $this->debug?'':'xdisplay:none;'?>">
			<label><?php _e('PHP date format(optional):','rhc') ?></label>
			<input class="pinfo_input" id="post_extrainfo_date_format" type="text" name="post_extrainfo_date_format" value="" />	
		</div>		
					
		<div class="post_extrainfo_cell" style="<?php echo $this->debug?'':'display:none;'?>">
			<label><?php _e('Custom:','rhc') ?></label>
			<input class="pinfo_input" id="post_extrainfo_custom" type="text" name="post_extrainfo_custom" value="" />
		</div>
		<div class="post_extrainfo_cell post_extrainfo_type-cell post_extrainfo_type-custom">		
			<label><?php _e('Value:','rhc') ?></label>
			<input class="pinfo_input" id="post_extrainfo_value" type="text" name="post_extrainfo_value" value="" />	
		</div>

		<div class="post_extrainfo_cell post_extrainfo_type-cell post_extrainfo_type-custom">		
			<label><?php _e('Use rel="nofollow" for link:','rhc') ?></label>
			<select class="pinfo_input" id="post_extrainfo_nofollow" name="post_extrainfo_nofollow">
				<option value="1"><?php _e('Yes','rhc') ?></option>
				<option value=""><?php _e('No','rhc') ?></option>
			</select>			
		</div>
		
		<?php if(count($taxonomies)>0):?>
		<div class="post_extrainfo_cell post_extrainfo_type-cell post_extrainfo_type-taxonomy">
			<label><?php _e('Taxonomy:','rhc') ?></label>
			<select class="pinfo_input" id="post_extrainfo_taxonomy" name="post_extrainfo_taxonomy">
			<?php foreach($taxonomies as $value => $label): ?>
			<option value="<?php echo $value?>"><?php echo $label?></option>
			<?php endforeach;?>
			</select>
		</div>
		<?php endif;?>
		
		<?php if(count($taxonomies_meta_fields)>0): ?>
		<div class="post_extrainfo_cell post_extrainfo_type-cell post_extrainfo_type-taxonomymeta">
			<label><?php _e('Taxonomy field:','rhc') ?></label>
			<select class="pinfo_input" id="post_extrainfo_taxonomymeta" name="post_extrainfo_taxonomymeta">
			<?php foreach($taxonomies_meta_fields as $taxonomy => $fields): ?>
				<?php foreach($fields as $f):  
					if(!property_exists($f,'id'))continue;
					if(property_exists($f,'type') && in_array($f->type,array('subtitle')))continue; ?>
					<option value="<?php echo sprintf('%s|%s',$f->id,$taxonomy)?>" alt="<?php echo $f->label?>"><?php echo $taxonomies[$taxonomy].' '.$f->label?></option>		
				<?php endforeach; ?>
			<?php endforeach;?>
			</select>
		</div>	
		<?php endif;?>
		
		
		<div class="post_extrainfo_cell post_extrainfo_type-cell post_extrainfo_type-postmeta">
			<label><?php _e('Meta fields:','rhc') ?></label>
			<select class="pinfo_input" id="post_extrainfo_postmeta" name="post_extrainfo_postmeta">
			<?php foreach($metafields as $value => $label):?>
			<option value="<?php echo $value?>"><?php echo $label?></option>
			<?php endforeach;?>
			</select>	
		</div>
		
		<div class="post_extrainfo_cell">	
			<div id="extrainfo-loading" ><img src="<?php echo admin_url('/images/wpspin_light.gif')?>"  /></div>
			<input id="post_extrainfo_add" type="button" class="button-secondary" name="post_extrainfo_add_button" value="<?php _e('Add','rhc')?>" data-add_label="<?php _e('Add','rhc')?>" data-save_label="<?php _e('Save','rhc')?>" />	
		</div>
		
		<div class="clear"></div>
	</div>
	<!--end input-->	
	<div id="post_extrainfo" class="post_extrainfo_holder"></div>
</div>
<div class="pinfo-set-default-holder">
	<input id="pinfo-reset-to-default" data-confirm_message="<?php echo htmlspecialchars(__('This will restore the default template.  Any customization will be lost on all boxes.','rhc'))?>" type="button" class="button-primary" value="<?php _e('Reset to default template','rhc')?>">
	<?php global $rhc_plugin;if(current_user_can($rhc_plugin->options_capability)):?>
	<input id="pinfo-set-default" data-confirm_message="<?php echo htmlspecialchars(__('This will replace the existing default fields with the layout set on this page for all boxes.','rhc'))?>" type="button" class="button-primary" value="<?php _e('Save as default template','rhc')?>">
	<?php endif; ?>
</div>
<?php		
	}
	
	function wp_ajax_get_postinfo(){
		foreach(array('post_ID'=>0,'postinfo_boxes_id'=>'') as $field => $default){
			$$field = isset($_POST[$field])?$_POST[$field]:$default;
		}
		if(!empty($post_ID)&&!empty($postinfo_boxes_id)){
			$response = (object)array(
				'R'		=> 'OK',
				'DATA'	=> rhc_post_info_shortcode::get_post_extra_info($post_ID,$postinfo_boxes_id)
			);
			die(json_encode($response));
		}else{
			$response = (object)array(
				'R'		=> 'ERR',
				'MSG'	=> __('Missing parameter.','rhc')
			);
			die(json_encode($response));		
		}
	}
	
	function wp_ajax_set_pinfo_default(){
		global $rhc_plugin;
		if(!current_user_can($rhc_plugin->options_capability)){
			die(json_encode((object)array('R'=>'ERR','MSG'=>__('No access','rhc'))));
		}
		foreach(array('post_ID'=>0) as $field => $default){
			$$field = isset($_POST[$field])?$_POST[$field]:$default;
		}
		$response = (object)array('R'=>'OK');
		if($post_ID>0){
			$postinfo_boxes = get_post_meta($post_ID,'postinfo_boxes',true);
			//--save:
			$options = get_option($rhc_plugin->options_varname);
			$options = is_array($options)?$options:array();
			$options['postinfo_boxes']=$postinfo_boxes;
			//--
			update_option($rhc_plugin->options_varname,$options);					
		}
		die(json_encode($response));
	}

	function wp_ajax_pinfo_reset_to_default(){
		global $rhc_plugin;
		foreach(array('post_ID'=>0) as $field => $default){
			$$field = isset($_POST[$field])?$_POST[$field]:$default;
		}	
				
		if(!current_user_can('edit_'.$this->post_type, $post_ID)){
			die(json_encode((object)array('R'=>'ERR','MSG'=>__('You cannot edit this post.','rhc'))));
		}
		
		$postinfo_boxes = $rhc_plugin->get_option('postinfo_boxes',false,true);
		if(is_array($postinfo_boxes)){
			update_post_meta($post_ID,'postinfo_boxes',$postinfo_boxes);
		}
		die(json_encode((object)array('R'=>'OK')));
	}
	
	function get_meta_fields($post){
		global $wpdb;
		$options = array();
		include RHC_PATH.'includes/meta_fields_default_labels.php';
		
		$always_keys = array_keys($default_meta_field_labels);

		$meta_keys = $wpdb->get_col("SELECT DISTINCT(meta_key) FROM `{$wpdb->postmeta}` WHERE post_id={$post->ID} AND meta_key NOT LIKE '\_%'",0);
		$meta_keys = is_array( $meta_keys ) ? $meta_keys : array() ;
		
		$b = array_merge( $always_keys, $meta_keys );
		$b = array_unique( $b );

		$meta_keys = $b;

		if(is_array($meta_keys) && count($meta_keys)>0){
			$meta_keys[]='rhc_excerpt';
			$meta_keys[]='rhc_post_title';
			
			foreach($meta_keys as $field){
				if(in_array($field, apply_filters('postinfo_postmeta_exclude',array('extra_info_columns','extra_info_separators','extra_info_data'))))continue;
				$value = get_post_meta($post->ID,$field,true);
				$label = isset($default_meta_field_labels[$field])?$default_meta_field_labels[$field]:$field;
				if(is_string($value)){
//					$options[$field]=sprintf('%s(%s)',$label,substr($value,0,10));
					if(in_array($field,$default_skip_meta_fields))continue;
					$options[$field]=$label;
				}
			}
		}
		
		if(count($options) <= 1){// it always has at least 1 since we added rhc_excerpt.
			require_once RHC_PATH.'includes/meta_fields_default_labels.php';
			foreach(array('fc_start','fc_start_time','fc_end','fc_end_time','fc_start_datetime','fc_end_datetime','rhc_excerpt','rhc_post_title') as $field){
				$label = isset($default_meta_field_labels[$field])?$default_meta_field_labels[$field]:$field;
				$options[$field]=$label;
			}
		}
		
		$options = apply_filters('postinfo_postmeta_include', $options);
		
		return $options;
	}
	
	function get_post_taxonomies(){
	    $taxonomies = get_object_taxonomies(array( 'post_type' => $this->post_type ),'objects');
		$options = array();
		if(is_array($taxonomies) && count($taxonomies)>0){
			foreach($taxonomies as $id => $o){
				$tax = get_taxonomy($id);
				$options[$id]=$tax->label;
			}
		}
		return $options; 
	}

	function get_taxonomies_meta_fields($taxonomies){
		$taxonomies_meta_fields = array();
		if(is_array($taxonomies)&&count($taxonomies)>0){
			foreach($taxonomies as $taxonomy => $label){
				$tax_meta_fields = apply_filters($taxonomy.'_taxonomy_meta_fields',array());
				if(is_array($tax_meta_fields)&&!empty($tax_meta_fields)){
					$taxonomies_meta_fields[$taxonomy]=	$tax_meta_fields;				
				}
			}
		}
		return 	$taxonomies_meta_fields;
	}
}

class quick_icon_item {
	function __construct($args){
		$defaults = array(
			'label' 						=> __('Label','rhc'),
			'post_extrainfo_type'			=> 'label',
			'post_extrainfo_label'			=> __('Label','rhc'),
			'post_extrainfo_class'			=> '',
			'post_extrainfo_taxonomy'		=> '',
			'post_extrainfo_taxonomymeta'	=> '',
			'post_extrainfo_postmeta'		=> '',
			'post_extrainfo_custom'			=> '',
			'post_extrainfo_value'			=> '',
			'post_extrainfo_nofollow'		=> ''
		);
		//--
		foreach($defaults as $field => $default){
			$this->$field = isset($args[$field])?$args[$field]:$default;
		}
		//--
		$this->fields = array_keys($defaults);
	}
	
	function get_parameters_for_html_tag(){
		$arr=array();
		foreach($this->fields as $field){
			if('label'==$field)continue;
			$arr[] = sprintf('data-%s="%s"', $field, htmlspecialchars($this->$field));
		}
		//$arr[]=sprintf('data-post_extrainfo_fields="%s"',implode(',',$this->fields));
		return implode(" ",$arr);
	}
}
?>