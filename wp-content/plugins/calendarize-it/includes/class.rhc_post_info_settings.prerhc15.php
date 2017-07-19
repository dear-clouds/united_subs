<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/
class rhc_post_info_settings {
	var $post_type = RHC_EVENTS;
	function __construct($plugin_id='rhc'){
		$this->id = $plugin_id;
		add_filter("pop-options_{$this->id}",array(&$this,'options'),10,1);			
		//add_action('pop_handle_save',array(&$this,'pop_handle_save'),50,1);
		add_action("pop_admin_head_{$this->id}", array(&$this,'head'),10,1);
		
		add_action('wp_ajax_rhc_save_post_info', array(&$this,'wp_ajax_rhc_save_post_info'));
	}
	
	function wp_ajax_rhc_save_post_info(){
		global $rhc_plugin; 
		if(current_user_can($rhc_plugin->options_capability)){
			$post_extrainfo = $_POST['post_extrainfo'];
			$post_extrainfo = is_array($post_extrainfo)?$post_extrainfo:array();
			//--
			$options = get_option($rhc_plugin->options_varname);
			$options = is_array($options)?$options:array();
			$options['post_extrainfo']=$post_extrainfo;
			//--
			update_option($rhc_plugin->options_varname,$options);			
			die(json_encode(array('R'=>'OK','MSG'=>'')));
		}else{
			die(json_encode(array('R'=>'ERR','MSG'=>__('No access','rch'))));
		}
	}
	
	function options($t){
		$i = count($t);
		//-- Permalink settings -----------------------		
		$i++;
		$t[$i]=(object)array();
		$t[$i]->id 			= 'rhc-post-info-settings'; 
		$t[$i]->label 		= __('Default event fields','rhc');
		$t[$i]->right_label	= __('Customize event fields','rhc');
		$t[$i]->page_title	= __('Default event fields','rhc');
		$t[$i]->theme_option = true;
		$t[$i]->plugin_option = true;
		$t[$i]->options = array(
			(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('Default post info fields','rhc')
			),			
			(object)array(
				'id'			=> 'default_post_info_fields',
				'type'			=> 'callback',
				'description'	=> $this->description(),
				'callback'	=> array($this,'default_post_info_fields')
			),
			(object)array(
				'id'			=> 'default_columns',
				'type' 			=> 'select',
				'options'		=> array(1=>1,2=>2,3=>3),
				'default'		=> 2,
				'label'			=> __('Default columns','rhc'),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array(
				'id'			=> 'datetime_format',
				'type' 			=> 'text',
				'default'		=> get_option('links_updated_date_format', __('F j, Y','rhc').' '.__('g:i a','rhc') ),
				'description'	=> __("Datetime, date and time format in this tab only applies to the start and end meta fields (start datetime, start date, start time, end datetime, end date, end time).  Because this values are rendered server side they follow the php <a href=\"http://php.net/manual/en/function.date.php\">date formatting syntax</a>.","rhc"),
				'label'			=> __('Datetime format','rhc'),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array(
				'id'			=> 'date_format',
				'type' 			=> 'text',
				'default'		=> get_option('date_format',__('F j, Y','rhc')),
				'label'			=> __('Date format','rhc'),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array(
				'id'			=> 'time_format',
				'type' 			=> 'text',
				'default'		=> get_option('time_format',__('g:i a','rhc')),
				'label'			=> __('Date format','rhc'),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array(
				'id'		=> 'taxonomy_links',
				'label'		=> __('Taxonomies are links','wlb'),
				'description' => __('Choose yes if you want to make taxonomies hyperlinks.  Example venue will be a link to the venue page.','wlb'),
				'type'		=> 'yesno',
				'default'	=> '0',
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			)					
		);
		
		$t[$i]->options[]=(object)array(
				'type'=>'clear'
			);
		$t[$i]->options[]=(object)array(
				'type'	=> 'submit',
				'label'	=> __('Save','rhc'),
				'class' => 'button-primary'
			);
		//-------------------------		
		return $t;
	}
	
	function head(){
		global $rhc_plugin;
		$data = $rhc_plugin->get_option('post_extrainfo');
		$data = is_array($data)?$data:array();
		wp_print_scripts('jquery-ui-sortable');
?>
<script type='text/javascript'>
var post_extrainfo = eval('<?php echo json_encode($data)?>');
jQuery(document).ready(function($){ 
	$('#post_extrainfo_add').live('click',function(e){
		var _type = $('#post_extrainfo_type').val();
		var item = {
			'type': _type,
			'label': $('#post_extrainfo_label').val(),
			'value': $('#post_extrainfo_value').val(),
			'taxonomy': $('#post_extrainfo_taxonomy').val(),
			'postmeta': $('#post_extrainfo_postmeta').val(),
			'taxonomymeta': _type=='taxonomymeta'?$('#post_extrainfo_taxonomymeta').find('option:selected').attr('rel'):'',
			'taxonomymeta_field': _type=='taxonomymeta'?$('#post_extrainfo_taxonomymeta').val():''
		};
		
		if(item.type=='taxonomy'){
			item.value = 'taxonomy(' + $('#post_extrainfo_taxonomy').val() + ')';
		}else if(item.type=='postmeta'){
			item.value = 'postmeta(' + $('#post_extrainfo_postmeta').val() + ')';
		}else if(item.type=='taxonomymeta'){
			item.value = item.taxonomymeta + ' ' + item.taxonomymeta_field ;
		}
		
		post_extrainfo[post_extrainfo.length]=item;
		save_post_extrainfo();
	});
	
	$('.rhc-extra-info-cell a.ui-icon-closethick').live('click',function(e){
		$(this).parents('.rhc-extra-info-cell').first().addClass('remove');
		$('.rhc-extra-info-cell').each(function(i,inp){
			if( $(this).hasClass('remove') ){
				$(this).animate({opacity:0.2},'fast','swing',function(){
					var tmp = [];
					for(a=0;a<post_extrainfo.length;a++){
						if(a==i)continue;
						tmp[tmp.length]=post_extrainfo[a];
					}
					post_extrainfo = tmp;
					save_post_extrainfo();					
				});
			}
		});
	});	
	
	$('#post_extrainfo_type').live('change',function(e){ 
		$('.post_extrainfo_type-cell').hide();
		$('.post_extrainfo_type-'+$(this).val()).fadeIn();
		
		if($(this).val()=='taxonomy'){$('#post_extrainfo_taxonomy').trigger('change');}
		if($(this).val()=='taxonomymeta'){$('#post_extrainfo_taxonomymeta').trigger('change');}
		if($(this).val()=='postmeta'){$('#post_extrainfo_postmeta').trigger('change');}
	}).trigger('change');
	
	$('#post_extrainfo_taxonomy,#post_extrainfo_postmeta').live('change',function(e){
		$('#post_extrainfo_label').val( $(this).find('option:selected').html() );
	});	

	$('#post_extrainfo_taxonomymeta').live('change',function(e){
		$('#post_extrainfo_label').val( $(this).find('option:selected').attr('alt') );
	});
	
	$('#extrainfo-loading img').hide();	
	render_post_extrainfo();
	
	init_sortable();
});

function render_post_extrainfo(){
	jQuery(document).ready(function($){ 
		var template = '<div class="widget rhc-extra-info-cell rhcalendar" rel="_index_"><div class="widget-top"><div class="widget-title-action"><a href="javascript:void(0);" class="ui-icon ui-icon-closethick"></a></div><div class="widget-title "><h4  class="rhc-extra-info-label"><label>_label_</label>:&nbsp;<span class="rhc-extra-info-value"> _value_</span></h4>	</div></div></div>';
		$('#post_extrainfo').empty();
		$.each(post_extrainfo,function(i,item){
			var _new = $(template);
			_new.attr('rel',i);
			_new.find('.rhc-extra-info-label label').html(item.label);
			_new.find('.rhc-extra-info-value').html(item.value);
			$('#post_extrainfo').append(_new);
		});		
	});
}

function save_post_extrainfo(){
	jQuery(document).ready(function($){
		var args = {
			action: 'rhc_save_post_info',
			post_extrainfo: post_extrainfo
		};
		$('#extrainfo-loading img').fadeIn();
		$.post(ajaxurl,args,function(data){
			if(data.R=='OK'){
				render_post_extrainfo();
			}else if(data.R=='ERR'){
				alert(data.MSG);	
			}else{
				alert('Unexpected error, please reload the page.');
			}
			$('#extrainfo-loading img').stop().fadeOut('slow');
		},'json');
	});
}

function init_sortable(){
	jQuery(document).ready(function($){
		$('#post_extrainfo').sortable({
			'handle':'.widget-top',
			'update': function(e,ui){
				$('#post_extrainfo').sortable('disable');
				var order=[];
				$('.rhc-extra-info-cell').each(function(i,inp){
					order[order.length]=parseInt($(this).attr('rel'));
				});
				if(order.length==post_extrainfo.length){
					var tmp = [];
					$.each(order,function(i,index){
						tmp[i]=post_extrainfo[index];
					});
					post_extrainfo = tmp;
				}
				save_post_extrainfo();
				$('#post_extrainfo').sortable('enable');
			}
		});
	});
}
</script>
<?php	
	}
	
	function default_post_info_fields($tab,$i,$o){
		global $post;
		
		$taxonomies = $this->get_post_taxonomies();
		$metafields = $this->get_meta_fields();
		$taxonomies_meta_fields = $this->get_taxonomies_meta_fields($taxonomies);
		
		$extra_info_columns = 2;
				
		ob_start();
?>
<div class="pt-option pt-option-default-post-info-fields">


	<div id="post_extrainfo">
	
	</div>
	<div class="post_extrainfo_control widefat">
		<div class="post_extrainfo_cell">
			<label><?php _e('Type:','rhc') ?></label>
			<select id="post_extrainfo_type" name="post_extrainfo_type">
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
		
		<div class="post_extrainfo_cell">
			<label>Label:</label>
			<input id="post_extrainfo_label" type="text" name="post_extrainfo_label" value="" />	
		</div>
	
		<div class="post_extrainfo_cell post_extrainfo_type-cell post_extrainfo_type-custom">		
			<label>Value:</label>
			<input id="post_extrainfo_value" type="text" name="post_extrainfo_value" value="" />	
		</div>
		
		<?php if(count($taxonomies)>0):?>
		<div class="post_extrainfo_cell post_extrainfo_type-cell post_extrainfo_type-taxonomy">
			<label>Taxonomy</label>
			<select id="post_extrainfo_taxonomy" name="post_extrainfo_taxonomy">
			<?php foreach($taxonomies as $value => $label): ?>
			<option value="<?php echo $value?>"><?php echo $label?></option>
			<?php endforeach;?>
			</select>
		</div>
		<?php endif;?>
	
		<?php if(count($taxonomies_meta_fields)>0): ?>
		<div class="post_extrainfo_cell post_extrainfo_type-cell post_extrainfo_type-taxonomymeta">
			<label><?php _e('Taxonomy field:','rhc') ?></label>
			<select id="post_extrainfo_taxonomymeta" name="post_extrainfo_taxonomymeta">
			<?php foreach($taxonomies_meta_fields as $taxonomy => $fields): ?>
				<?php foreach($fields as $f):  
					if(!property_exists($f,'id'))continue;
					if(property_exists($f,'type') && in_array($f->type,array('subtitle')))continue; ?>
					<option value="<?php echo $f->id?>" rel="<?php echo $taxonomy?>" alt="<?php echo $f->label?>"><?php echo $taxonomies[$taxonomy].' '.$f->label?></option>		
				<?php endforeach; ?>
			<?php endforeach;?>
			</select>
		</div>	
		<?php endif;?>
		
		<div class="post_extrainfo_cell post_extrainfo_type-cell post_extrainfo_type-postmeta">
			<label>Meta fields</label>
			<select id="post_extrainfo_postmeta" name="post_extrainfo_postmeta">
			<?php foreach($metafields as $value => $label):?>
			<option value="<?php echo $value?>"><?php echo $label?></option>
			<?php endforeach;?>
			</select>	
		</div>
		
		<div class="post_extrainfo_cell">	
			<input id="post_extrainfo_add" type="button" class="button-secondary" name="post_extrainfo_add_button" value="Add" />
			<div id="extrainfo-loading" ><img src="<?php echo admin_url('/images/wpspin_light.gif')?>"  /></div>
			<div class="clear"></div>
		</div>
		
		<div class="clear"></div>
	</div>

</div>
<?php
		$out = ob_get_contents();
		ob_end_clean();
		return $out;
	}	
	
	function description(){
		ob_start();
?>
Use this option to specify a set of default fields added when creating a new event.
<?php		
		$out = ob_get_contents();
		ob_end_clean();
		return $out;
	}	
	
	function get_meta_fields(){
		require_once RHC_PATH.'includes/meta_fields_default_labels.php';
		$tmp = array();
		foreach($default_meta_field_labels as $field => $value){
			if(in_array($field,$default_skip_meta_fields))continue;
			$tmp[$field]=$value;
		}
		return $tmp;
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
?>