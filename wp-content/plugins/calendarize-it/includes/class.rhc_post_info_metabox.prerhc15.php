<?php

class rhc_post_info_metabox {
	var $post_type;
	var $capability;
	function __construct($post_type,$capability){
		if(!class_exists('post_meta_boxes'))require_once('class.post_meta_boxes.php');		
		$this->post_type = $post_type;
		$this->capability = $capability;
		$this->metabox_meta_fields = array("fc_post_info");
		$this->post_meta_boxes = new post_meta_boxes(array(
			'post_type'=>$post_type,
			'options'=>$this->metaboxes(),
			'styles'=>array(),
			'scripts'=>array(),
			'metabox_meta_fields' =>  'post_info_metabox_meta_fields',
			'pluginpath'=>RHC_PATH
		));
		$this->post_meta_boxes->save_fields = $this->metabox_meta_fields;
		//---
		add_action('wp_ajax_post_extrainfo_'.$post_type, array(&$this,'wp_ajax_post_extrainfo'));
		//----
		add_action('wp_insert_post', array(&$this,'wp_insert_post'), 10, 2 );
	}
	
	function wp_insert_post( $post_ID, $post ){
		if( 'auto-draft' == $post->post_status && $this->post_type == $post->post_type ){
			if($post_ID>0){
				if (current_user_can($this->capability, $post_ID)){
					global $rhc_plugin;
					$default_columns 	= $rhc_plugin->get_option('default_columns',2,true);
					$post_extrainfo		= $rhc_plugin->get_option('post_extrainfo',false,true);
					if(false!==$post_extrainfo){
						update_post_meta($post_ID,'extra_info_columns',$default_columns);
						//update_post_meta($post_ID,'extra_info_separators',$separators);
						update_post_meta($post_ID,'extra_info_data',$post_extrainfo);					
					}
				}			
			}			
		}
	}
	
	function wp_ajax_post_extrainfo(){
		$out = '';
		$r = array();
		$save = array();
		foreach(array('columns'=>2,'separators'=>1,'post_ID'=>0) as $field => $default){
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
					if($separators==1 && $columns>1 && 0==fmod( $k ,$columns)){	 
						$r[] = new rhc_post_info_field(array('type'=>'separator'));
					}
				}
			}
		}
		
		//--
		if($post_ID>0){
			if (current_user_can($this->capability, $post_ID)){
				update_post_meta($post_ID,'extra_info_columns',$columns);
				update_post_meta($post_ID,'extra_info_separators',$separators);
				update_post_meta($post_ID,'extra_info_data',$save);
			}			
		}
		//--
		
		if(count($r)>0){
			$k=0;
			foreach($r as $s){
				if($s->type=='separator'){
					$index='';
				}else{
					$index=$k;
					$k++;
				}
				$cell = $s->render();
				$cell = str_replace('{index}',$index,$cell);
				$out.=$cell;
			}
			$out = sprintf('<div class="post_extrainfo post_extrainfo_cols-%s">%s</div>',$columns,$out);
		}
		
		$response = (object)array(
			'R'=>'OK',
			'MSG'=>'',
			'HTML'=>$out,
			'ITEMS'=>$r,
			'showcontrols'=> count($r)>0?true:false
		);
		die(json_encode($response));
	}
	
	function metaboxes($t=array()){
		$i = count($t);
		//------------------------------
		$i++;
		$t[$i]=(object)array();
		$t[$i]->id 			= 'rhc-post-info'; 
		$t[$i]->label 		= __('Additional info layout','rhc');
		$t[$i]->right_label	= __('Additional info layout','rhc');
		$t[$i]->page_title	= __('Additional info layout','rhc');
		$t[$i]->theme_option = true;
		$t[$i]->plugin_option = true;
		$t[$i]->options = array(
			(object)array(
				'id'=>'rhc_post_info',
				'type'=>'callback',
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
		global $post;
		
		$taxonomies = $this->get_post_taxonomies();
		$metafields = $this->get_meta_fields($post);
		$taxonomies_meta_fields = $this->get_taxonomies_meta_fields($taxonomies);
		
		foreach(array('extra_info_columns'=>2,'extra_info_separators'=>1) as $field => $default){
			$$field = get_post_meta($post->ID,$field,true);
			$$field = $$field==''?$default:$$field;
		}

?>
<div id="post_extrainfo">

</div>
<div class="post_extrainfo-column-control">
	<label>Columns:&nbsp;&nbsp;</label>
	<select id="extra_info_columns">
	<?php foreach( array('1','2','3') as $v):?>
	<option <?PHP echo $v==$extra_info_columns?'selected="selected"':'';?> value="<?php echo $v?>"><?php echo $v?></option>
	<?php endforeach;?>
	</select>

&nbsp;&nbsp;&nbsp;&nbsp;
	<div style="display:none;">
	<label>Add row separators:&nbsp;&nbsp;</label>
	<select id="extra_info_separators">
	<?php foreach( array('1'=>'Yes','0'=>'No') as $v=>$label):?>
	<option <?PHP echo $v==$extra_info_separators?'selected="selected"':'';?> value="<?php echo $v?>"><?php echo $label?></option>
	<?php endforeach;?>
	</select>
	</div>
</div>
<div class="post_extrainfo_control widefat">
	<div class="post_extrainfo_cell">
		<label><?php _e('Type:','rhc') ?></label>
		<select id="post_extrainfo_type" name="post_extrainfo_type">
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
	
	<div class="post_extrainfo_cell">
		<label><?php _e('Label:','rhc') ?></label>
		<input id="post_extrainfo_label" type="text" name="post_extrainfo_label" value="" />	
	</div>

	<div class="post_extrainfo_cell post_extrainfo_type-cell post_extrainfo_type-custom">		
		<label><?php _e('Value:','rhc') ?></label>
		<input id="post_extrainfo_value" type="text" name="post_extrainfo_value" value="" />	
	</div>
	
	<?php if(count($taxonomies)>0):?>
	<div class="post_extrainfo_cell post_extrainfo_type-cell post_extrainfo_type-taxonomy">
		<label><?php _e('Taxonomy:','rhc') ?></label>
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
		<label><?php _e('Meta fields:','rhc') ?></label>
		<select id="post_extrainfo_postmeta" name="post_extrainfo_postmeta">
		<?php foreach($metafields as $value => $label):?>
		<option value="<?php echo $value?>"><?php echo $label?></option>
		<?php endforeach;?>
		</select>	
	</div>
	
	<div class="post_extrainfo_cell">	
		<div id="extrainfo-loading" ><img src="<?php echo admin_url('/images/wpspin_light.gif')?>"  /></div>
		<input id="post_extrainfo_add" type="button" class="button-secondary" name="post_extrainfo_add_button" value="Add" />	
	</div>
	
	<div class="clear"></div>
</div>
<?php		
		add_action('admin_footer',array(&$this,'admin_footer'));
//		echo "<PRE>";
//		print_r($taxonomies_meta_fields);
//		echo "</PRE>";		
	}
	
	function admin_footer(){
		global $post;
		$data = get_post_meta($post->ID,'extra_info_data',true);
		$data = is_array($data)?$data:array();
		if(!empty($data)){
			foreach($data as $i => $d){
				$data[$i]->value = str_replace('"','\\"',$d->value);
			}
		}
?>
<script type="text/javascript">
var post_extrainfo = eval('<?php echo json_encode($data)?>');
jQuery(document).ready(function($){
	$('#post_extrainfo_type').live('change',function(e){ 
		$('.post_extrainfo_type-cell').hide();
		$('.post_extrainfo_type-'+$(this).val()).fadeIn();
		
		if($(this).val()=='taxonomy'){$('#post_extrainfo_taxonomy').trigger('change');}
		if($(this).val()=='taxonomymeta'){$('#post_extrainfo_taxonomymeta').trigger('change');}
		if($(this).val()=='postmeta'){$('#post_extrainfo_postmeta').trigger('change');}
	}).trigger('change');
	
	$('#post_extrainfo_add').live('click',function(e){
		var _type=$('#post_extrainfo_type').val();
		var o = {
			'type': _type,
			'label': $('#post_extrainfo_label').val(),
			'value': _type=='custom'?$('#post_extrainfo_value').val():'',
			'taxonomy': _type=='taxonomy'?$('#post_extrainfo_taxonomy').val():'',
			'postmeta': _type=='postmeta'?$('#post_extrainfo_postmeta').val():'',
			'taxonomymeta': _type=='taxonomymeta'?$('#post_extrainfo_taxonomymeta').find('option:selected').attr('rel'):'',
			'taxonomymeta_field': _type=='taxonomymeta'?$('#post_extrainfo_taxonomymeta').val():''
		};
		post_extrainfo[post_extrainfo.length]=o;
		load_extra_info();
		//$('#post_extrainfo_value').val('');
		//$('#post_extrainfo_label').val('');
	});
	
	$('#post_extrainfo_taxonomy,#post_extrainfo_postmeta').live('change',function(e){
		$('#post_extrainfo_label').val( $(this).find('option:selected').html() );
	});
	
	$('#post_extrainfo_taxonomymeta').live('change',function(e){
		$('#post_extrainfo_label').val( $(this).find('option:selected').attr('alt') );
	});
	
	$('.rhc-extra-info-cell a.ui-icon-closethick').live('click',function(e){
		$(this).parents('.rhc-extra-info-cell').first().addClass('remove');
		$('.rhc-extra-info-cell').each(function(i,inp){
			if( $(this).hasClass('remove') ){
				$(this).animate({opacity:0.2});
				var tmp = [];
				for(a=0;a<post_extrainfo.length;a++){
					if(a==i)continue;
					tmp[tmp.length]=post_extrainfo[a];
				}
				post_extrainfo = tmp;
				load_extra_info();
				return;				
			}
		});
	});
	
	$('#extra_info_columns,#extra_info_separators').live('change',function(e){load_extra_info();});
	
	load_extra_info();
});

function init_sortable(){
	jQuery(document).ready(function($){
		$('#post_extrainfo .post_extrainfo').sortable({
			'handle':'.widget-top',
			'update': function(e,ui){
				$('#post_extrainfo .post_extrainfo').sortable('disable');
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
				load_extra_info();
			},
			'start':function(e,ui){
				$(this).find('.post_extrainfo_separator').hide();
			}
		});
	});
}

function load_extra_info(){
	jQuery(document).ready(function($){
		$('#extrainfo-loading img').stop().fadeIn('slow');
		
		var args = {
			action: '<?php echo 'post_extrainfo_'.$this->post_type?>',
			post_ID: $('#post_ID').val(),
			'columns': $('#extra_info_columns').val(),
			'separators': $('#extra_info_separators').val(),
			data:post_extrainfo		
		}
		//$("#post_extrainfo").load(ajaxurl,args,function(){});
		
		$.post(ajaxurl,args,function(data){
			if(data.R=='OK'){
				$("#post_extrainfo").html(data.HTML);
				init_sortable();
				if(data.showcontrols){
					$('.post_extrainfo-column-control').fadeIn();
				}else{
					$('.post_extrainfo-column-control').fadeOut();					
				}
			}else{
			
			}
			$('#extrainfo-loading img').stop().fadeOut();
		},'json');
	});
}


function remove_extrainfo_cell(){
	jQuery(document).ready(function($){
	
	});
}
</script>
<?PHP
	}	
	
	function get_meta_fields($post){
		global $wpdb;
		$options = array();
		$meta_keys = $wpdb->get_col("SELECT DISTINCT(meta_key) FROM `{$wpdb->postmeta}` WHERE post_id={$post->ID} AND meta_key NOT LIKE '\_%'",0);
		if(is_array($meta_keys) && count($meta_keys)>0){
			require_once RHC_PATH.'includes/meta_fields_default_labels.php';
			foreach($meta_keys as $field){
				if(in_array($field,array('extra_info_columns','extra_info_separators','extra_info_data')))continue;
				$value = get_post_meta($post->ID,$field,true);
				$label = isset($default_meta_field_labels[$field])?$default_meta_field_labels[$field]:$field;
				if(is_string($value)){
//					$options[$field]=sprintf('%s(%s)',$label,substr($value,0,10));
					if(in_array($field,$default_skip_meta_fields))continue;
					$options[$field]=$label;
				}
			}
		}
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


?>