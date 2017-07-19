<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/
class rhc_post_info_shortcode {
	function __construct ($shortcode='rhc_post_info'){
		add_shortcode($shortcode, array(&$this,'handle_shortcode'));
		//keep it for a while until updating addons:
		add_shortcode('post_info', array(&$this,'handle_shortcode'));
		add_shortcode('rhc_echo', array(&$this,'handle_rhc_echo'));
	}
	
	function handle_rhc_echo($atts,$content=null,$code=""){
		extract(shortcode_atts(array(
			'echo'				=> 'test'
		), $atts));
		
		return $echo;
	}
	
	public static function handle_shortcode($atts,$content=null,$code=""){
		extract(shortcode_atts(array(
			'id'				=> 'detailbox',
			'width'				=> '0',
			'columns'			=> false,
			'class'				=> '',
			'post_types'		=> false,//if specified (comma separated post types), then the shortcode will only render for those post types. usefull when showing mixed post types archives, and you need the shortcode on some post types only.
			'calendarized_only'	=>'0',//use 1 to display the fields only if the post is calendarized.			
			'frontend'			=> '1',
			'container_span' 	=> '6',
			'post_id'			=> ''
		), $atts));

		$frontend = ('1'==$frontend?true:false);
		
		if(intval($post_id)>0){
			if($post = get_post($post_id)){
			
			}else{
				global $post;
			}
		}else{
			global $post;		
		}
		
		$out='';
		if( is_object($post) && property_exists($post,'ID') && $post->ID>0){
			$s = rhc_post_info_shortcode::get_post_extra_info($post->ID,$id);
	
			$container_span = ''==$s->span ? $container_span : $s->span;//specific post content size overwrites the shortcode argument value.
			
			if( $calendarized_only=='1' ){
				if( ''==trim(get_post_meta($post->ID,'fc_start',true)) ){
					return '';
				}
			}
		
			if( false!==$post_types ){
				$arr = explode(',',str_replace(' ','',$post_types));
				if(is_array($arr)&&count($arr)>0){
					if( !in_array($post->post_type,$arr) ){
						return '';
					}
				}
			}
			$out =rhc_post_info_shortcode::render($post->ID,intval($width),$class,$columns,$frontend,$container_span,$s);
		}
		return $out;
	}
	
	public static function render($post_ID,$width,$class='',$columns=false,$frontend=true,$container_span='6',$s){
		if(false===$columns){
			$columns = $s->columns;
			$columns = $columns<0?$columns=1:$columns;		
		}
		
		$data = $s->data;	
		
		$out='';
		if(false==$frontend || is_array($data) && count($data)>0){
			//back compat fill in the blanks.
			foreach($data as $i => $cell){
				$arr=(array)$cell;
				if(!property_exists($cell,'column') || ''==$cell->column ){
					$j = $i;			
					$cell->column 	= fmod($j,$columns);
					$cell->span 	= 12;
					$cell->offset 	= 0;		
					$data[$i]=$cell;
				}
			}			
			
			$style = "";
			//$style = $width=='0'?'width:100%;':"width:{$width}px;";
			
			$have_image=false;
			$attachment_holder_class = '';
			$thumbnail = rhc_post_info_shortcode::get_attachment($post_ID,$frontend,$s,$have_image,$attachment_holder_class);	

			$container_span = $have_image?$container_span:'12';
			
			$out .= "<div class=\"rhc fe-extrainfo-container $class fe-have-image-".( $have_image?'1':'0' )."\" style=\"$style\">";
			$out .= "<div class=\"fe-extrainfo-container2 row-fluid\">";
			$out .= "<div class=\"fe-extrainfo-holder fe-extrainfo-col{$columns} span$container_span\">";
			
			$columnas_arr = array();
			for($a=0;$a<$columns;$a++){
				$columnas_arr[$a]=array();
				foreach($data as $index => $cell){
					if($cell->column!=$a)continue;
					$cell->index = $index;
					$columnas_arr[$a][]=$cell;				
				}
			}
			
			if(!$frontend){
				//fill in empty
				for($a=0;$a<$columns;$a++){
					if(!isset($columnas_arr[$a]) || empty($columnas_arr[$a])){
						$columnas_arr[$a]=array();
						$columnas_arr[$a][]=(object)array(
							'type'	=> 'empty'
						);
					}
				}
			}
			
			$out .= "<div class=\"row-fluid\">";
			$span = 12 / count($columnas_arr);
			foreach($columnas_arr as $i => $cells){
				$out .= sprintf("<div class=\"span%s fe-maincol fe-maincol-%s\" data-column_index=\"%s\">",$span,$i,$i);	
				if(!empty($cells)){
					//--
					$pending_close=false;
					$cols = 0;
					foreach($cells as $cell){					
						$c= new rhc_post_info_field( (array)$cell );
						
						if($cols==0){
							$out .= "<div class=\"row-fluid fe-sortable\">";	
							$pending_close=true;
						}
						
						$out .= sprintf("<div class=\"%s%s\">%s</div>",
							($c->span>0?'span'.$c->span:''),
							($c->offset>0?'offset'.$c->offset:''),
							$c->render($frontend)
						);	
						
						$cols = $cols + $c->span + $c->offset;
						if($cols>=12){
							$out .= "</div>";
							$cols=0;	
							$pending_close=false;
						}						
					}
					
					if($pending_close){
						$out .= "</div>";//this closes an open div on the previous foreach.
					}
					//--				
				}
				$out .= "</div>";
			}
			$out .= "</div>";
		

			$out .= "</div>";
			//-----
			if($have_image){
				$out .= sprintf("<div class=\"%s span%s\">", $attachment_holder_class, abs(12-$container_span) );
				$out .= $thumbnail;
				$out .= "</div>";
			}
			//-----
			$out .= "</div>";
			$out .= "</div>";
			
		}
		
		return do_shortcode($out);
	}
	
	public static function get_attachment($post_ID,$frontend,$s,&$have_image,&$holder_class){
		global $rhc_plugin;
		$have_image=false;
		if(!$frontend){
			return'';
		}
		include 'postinfo_boxes.php';
		$pbox = isset($postinfo_boxes[$s->id])?$postinfo_boxes[$s->id]:false;

		if(false===$pbox){
			return '';
		}
		//---
		$enable_meta = $pbox->enable_meta ?$pbox->enable_meta : false;
		if(false!==$enable_meta){
			$enabled = get_post_meta($post_ID,$enable_meta,true);
			$enabled = ''==$enabled? $pbox->enable_default : $enabled;
			if('1'!=$enabled){
				return '';
			}
		}			
		$holder_class = $pbox->holder_class;
		
		if($pbox->type=='attachment'){
			$attachment_id = get_post_meta( $post_ID, $pbox->attachment_id_meta_key, true);
			$size = $rhc_plugin->get_option('rhc_single_media_size',array(300,200),true);
			if( $thumbnail=wp_get_attachment_image( $attachment_id, $size  ) ){
				$have_image=true;
			}			
			return $thumbnail;
		}else if($pbox->type=='shortcode'){		
			$have_image=true;
			return $pbox->shortcode;
			//return do_shortcode($pbox->shortcode);	
		}
		return '';
	}
	
	public static function get_post_extra_info($post_ID,$postinfo_boxes_id){
		$postinfo_boxes = get_post_meta($post_ID,'postinfo_boxes',true);
	
		global $rhc_plugin;
		if(isset($postinfo_boxes['venuebox']) && '1'==$rhc_plugin->get_option('disable_'.RHC_VENUE,'',true)){
			unset($postinfo_boxes['venuebox']);
		}

		if(is_array($postinfo_boxes) && count($postinfo_boxes)>0){
			foreach($postinfo_boxes as $i => $group){
				if(count($group->data)>0){
					foreach($group->data as $j => $f){
						if($f->type=='taxonomy'){
							if(!taxonomy_exists($f->taxonomy)){
								unset($postinfo_boxes[$i]->data[$j]);
							}
						}else if($f->type=='taxonomymeta'){
							if(!taxonomy_exists($f->taxonomymeta)){
								unset($postinfo_boxes[$i]->data[$j]);
							}
						}
					}
				}
			}		
		}

		if(isset($postinfo_boxes[$postinfo_boxes_id])){
			//-- bug fix, force the post_ID, as when saving this was not correctly assigned.
			if(property_exists($postinfo_boxes[$postinfo_boxes_id],'data') && is_array($postinfo_boxes[$postinfo_boxes_id]->data) && count($postinfo_boxes[$postinfo_boxes_id]->data)>0){
				foreach($postinfo_boxes[$postinfo_boxes_id]->data as $data_id => $data_o){
					$postinfo_boxes[$postinfo_boxes_id]->data[$data_id]->post_ID = $post_ID;
				}				
			}
			//------
			return $postinfo_boxes[$postinfo_boxes_id];
		}else{
			$response = (object)array(
				'id'		=> $postinfo_boxes_id,
				'columns'	=> 1,
				'span'		=> 12,
				'data'		=> array()
			);	
			//--- fallback to old version (pre1.5 model)
			if('detailbox'==$postinfo_boxes_id){
				$response->columns = get_post_meta($post_ID,'extra_info_columns',true);
				$response->columns = ''==$response->columns?'2':$response->columns;
				$response->span	= get_post_meta($post_ID,'extra_info_size',true);
				$response->span = ''==$response->span?'6':$response->span;
				$response->data = get_post_meta($post_ID,'extra_info_data',true);
				$response->data = is_array($response->data)?$response->data:array();
			}
			//---
			return $response;	
		}
	}	
}

class rhc_post_info_field {
	var $id;
	var $type;
	var $label;
	var $class;
	var $custom;
	var $value;
	var $nofollow;
	var $taxonomy;
	var $taxonomy_links;
	var $postmeta;
	var $taxonomymeta;
	var $taxonomymeta_field;
	var $render_cb;
	var $post_ID;
	var $date_format;
	var $column;
	var $span;
	var $offset;
	var $index;
	var $frontend=true;
	var $rhc_date=false;
	function __construct($args){
		global $rhc_plugin;
		
		$this->taxonomy_links = $rhc_plugin->get_option('taxonomy_links',true,true);
		$this->taxonomy_links = $this->taxonomy_links=='1'?true:false;

		foreach(array(
			'id'=>'',
			'type'=> '',
			'label'=>'',
			'class'=>'',
			'custom'=>'',
			'value'=>'',
			'nofollow'=>'',
			'taxonomy'=>'',
			'postmeta'=>'',
			'taxonomymeta'=>'',
			'taxonomymeta_field'=>'',
			'post_ID'=>false,
			'date_format'=>false,
			'render_cb'=>false,
			//'taxonomy_links'=>$taxonomy_links,
			'column'=>false,
			'span'=>12,
			'offset'=>0,
			'index'=>'',
			'format'=>''
			) as $field => $default){
			
			if($field=='label'){
				$v = isset($args[$field])? translate($args[$field],'rhc') : translate($default,'rhc');	
			}else{
				$v = isset($args[$field])?$args[$field]:$default;
			}
			/*
			if($field=='taxonomy_links' && is_string($v)){
				$v = ( 'true' === $v );
			}
			*/
			$this->$field = $v;
		}
		
		if( in_array( $this->type, array('taxonomy','taxonomymeta','custom') ) ){
			$this->postmeta='';//bug fix, reset postmeta if it is a taxonomy.
			$this->date_format = false;
		}
		
		if( empty($this->date_format) || false===$this->date_format|| 'false'===$this->date_format ){
			$cell = $this;
			if(in_array($cell->postmeta,array('fc_start','fc_end'))){
				$cell->date_format = $rhc_plugin->get_option('date_format', get_option('date_format'), true  );
			}else if(in_array($cell->postmeta,array('fc_start_time','fc_end_time'))){
				$cell->date_format = $rhc_plugin->get_option('time_format', get_option('time_format'), true  );
			}else if(in_array($cell->postmeta,array('fc_start_datetime','fc_end_datetime','fc_range_start','fc_range_end'))){
				$cell->date_format = $rhc_plugin->get_option('datetime_format', get_option('date_format').' '.get_option('time_format'), true  );
			}				
		}		
	}
	
	function get_template($frontend=false){
		if($frontend)return $this->get_template_frontend();
		ob_start();
?>
<div class="widget rhc-extra-info-cell rhcalendar {class}" rel="{index}">	
	<div class="widget-top">
		<div class="widget-title-action">
			<a href="javascript:void(0);" class="ui-icon extra-info-toggle ui-icon-triangle-1-s"></a>
			<a href="javascript:void(0);" class="ui-icon ui-icon-closethick"></a>
		</div>
		
		<div class="widget-title ">
			<h4  class="rhc-extra-info-label">{label}<span class="rhc-extra-info-value admin-fe-is-empty-{emptyvalue}">:&nbsp; {value}</span></h4>	
		</div>
	</div>
	<div class="widget-inside">
		<div class="widget-content"></div>
		<div class="widget-control-actions">
			<input type="button" class="pinfo-save button-primary" value="<?php _e('Save','rhc')?>" />
		</div>
	</div>
</div>
<?php	
		$out = ob_get_contents();
		ob_end_clean();
		
		if($this->id!=''){
			$out = str_replace("{id}",sprintf('id="%s"',$this->id),$out);
		}
		
		return $out;
	}
	
	function get_template_frontend(){
		$out = '<div class="rhc-info-cell {class} fe-is-empty-{emptyvalue} fe-is-empty-label-{emptylabel}"><label class="fe-extrainfo-label">{label}</label><span class="fe-extrainfo-value {valueclass}" {data}>{value}</span></div>';
		return $out;	
	}
	
	function render($frontend=false){
		$this->frontend = $frontend;
		//todo load template
		$output = '';
//		$template = "<div class=\"rhc-extra-info-cell widget\"><label class=\"rhc-extra-info-cell-label\">{label}</label><span class=\"rhc-extra-info-cell-value\">{value}</span></div>";
		$template = $this->get_template($frontend);
		$method = 'render_'.$this->type;
		if(method_exists($this,$method)){
			$output = $this->$method($template);
		}
		
		$output = apply_filters('rhc_post_info_field_render',$output,$this,$template);	
		
		return $output;
	}
	
	function template_replace($label,$value,$template,$position=''){
		$out = str_replace('{label}',$label,$template);
		$out = str_replace('{data}','',$out);
		$out = str_replace('{valueclass}','',$out);
		return str_replace('{value}',$value,$out);
	}
	
	function inject_values_to_template($data,$template){
		$class = 'postmeta-'.$this->postmeta;
		$data['class'] = isset($data['class']) ? $data['class'].' '.$class:$class;
		$out = $template;
		if(is_array($data)&&count($data)>0){
			foreach($data as $field => $value){
				$out = str_replace( sprintf('{%s}', $field), $value, $out);
				if($field=='value'){
					$v = trim($value)=='' ? '1':'0';
					$out = str_replace( '{emptyvalue}', $v, $out);
				}else if($field=='label'){
					$v = trim($value)=='' ? '1':'0';
					$out = str_replace( '{emptylabel}', $v, $out);				
				}
			}
		}
		$out = str_replace( '{index}', $this->index, $out);
		$out = str_replace('{data}','',$out);
		$out = str_replace('{valueclass}','',$out);
		return $out;
	}
	
	function apply_date_format( $out ){
		$date_format = empty($this->date_format)?'': $this->date_format;
		if(!empty($date_format)){
			include 'php_fc_date_format_map.php';
			if( is_array($php_fc_date_format_map) && count($php_fc_date_format_map)>0 ){
				$new = '';
				for ($i = 0, $l = strlen($date_format); $i < $l; $i++) {
					$item = $date_format{$i};
					$new .= isset( $php_fc_date_format_map[$item] ) ? $php_fc_date_format_map[$item] : $item;
				} 				

				$date_format = $new;
			}		
		}
		$date_format = empty($this->date_format)?'': sprintf('data-fc_date_format="%s"', esc_attr($date_format));
		$out = str_replace('{date_format}', $date_format, $out);	
		return $out;
	}
	
	function apply_client_rhc_date(){
		$out='';
		if( in_array($this->postmeta, array('fc_start','fc_start_time','fc_start_datetime')) ){
			$out .= sprintf('data-fc_field="%s"', 'start');
		}else if( in_array($this->postmeta, array('fc_end','fc_end_time','fc_end_datetime')) ){
			$out .= sprintf('data-fc_field="%s"', 'end');
		}else{
			return '';
		}
		//--
		$date_format = empty($this->date_format)?'': $this->date_format;
		if(!empty($date_format)){
			include 'php_fc_date_format_map.php';
			if( is_array($php_fc_date_format_map) && count($php_fc_date_format_map)>0 ){
				$new = '';
				for ($i = 0, $l = strlen($date_format); $i < $l; $i++) {
					$item = $date_format{$i};
					$new .= isset( $php_fc_date_format_map[$item] ) ? $php_fc_date_format_map[$item] : $item;
				} 				

				$date_format = $new;
			}		
		}
		$date_format = empty($this->date_format)?'': sprintf('data-fc_date_format="%s"', esc_attr($date_format));
				
		$out .= ' '.$date_format;
		$this->rhc_date=true;
		return $out;
	}
	
	function render_label($template){
		return $this->inject_values_to_template( array(
			'label'	=> $this->label,
			'class'	=> 'fe-cell-label',
			'value'	=> ''
		), $template );
	}
	
	function render_empty($template){
		return '<div class="fe-empty"></div>';
	}
	
	function render_custom($template){
		return $this->inject_values_to_template( array(
			'label'	=> $this->label,
			'class'	=> $this->get_uniq_class('fe-cell-custom icon-'),
			'value'	=> $this->filter_value($this->value)
		), $template );
	}
	
	function render_taxonomy($template){
		if(intval($this->post_ID)>0){
			$value='';
			$terms = wp_get_object_terms($this->post_ID,$this->taxonomy);
			if(is_array($terms)&&count($terms)>0){
				$t = array();
				foreach($terms as $term){
					if($this->taxonomy_links){
						$t[] = sprintf("<a href=\"%s\" class=\"rhc-taxonomy-link dbox-taxonomy-%s dbox-term-item\">%s</a>",get_term_link( $term, $this->taxonomy ), $this->taxonomy, $term->name);					
					}else{
						$t[] = sprintf("<span class=\"dbox-term-item dbox-taxonomy-%s\">%s</span>", $this->taxonomy, $term->name);
					}
				}
				$value = implode("",$t);
			}
			
			return $this->inject_values_to_template( array(
				'label'	=> $this->label,
				'class'	=> $this->get_uniq_class('fe-cell-taxonomy icon-'),
				'value'	=> $this->filter_value($value)
			), $template );			
		}else{
			return '';
		}
	}
	
	function render_taxonomymeta($template){
		if(intval($this->post_ID)>0){
			$value='';
			
			$t = array();
			$terms = wp_get_object_terms($this->post_ID,$this->taxonomymeta);
			if(is_array($terms)&&count($terms)>0){
				foreach($terms as $term){
					$for_filter=array(
						'term'=>$term
					);
					$v = $this->filter_value( get_term_meta($term->term_id, $this->taxonomymeta_field, true), $for_filter );
					$t_tmp = trim(apply_filters( sprintf('rhc_post_info_%s_%s',$this->taxonomymeta,$this->taxonomymeta_field) ,$v, $this ));			
					if( !empty($t_tmp) ){
						$t[]=$t_tmp ;
					}
				}
			}
		
			if( $this->frontend && count($t)==0)return '';
			
			$value = implode(", ",$t);
			$label = $this->label;
			if(!$this->frontend){
				$taxonomy = get_taxonomy($this->taxonomymeta);
				if(false!==$taxonomy){
					$label = $taxonomy->labels->singular_name.' '.$this->label;
				}						
			}
			
			$class = sprintf('fe-cell-taxonomymeta fe-%s-%s',$this->taxonomymeta,$this->taxonomymeta_field);
			
			return $this->inject_values_to_template( array(
				'label'	=> $label,
				'class'	=> $this->get_uniq_class($class.' icon-'),
				'value'	=> $value
			), $template );					
		}else{
			return '';
		}
	}
	
	function render_postmeta($template){
		if(intval($this->post_ID)>0){
			$value = get_post_meta($this->post_ID,$this->postmeta,true);
			if(is_string($value)){
				$this->value = $value;
				$value = $this->filter_value($value);//the order of this with the next line is important, so that bug date format changes depending on allday for the apply_client_rhc_date method.
				$data = $this->apply_client_rhc_date();
				return $this->inject_values_to_template( array(
					'label'	=> $this->label,
					'class'	=> $this->get_uniq_class('fe-cell-postmeta icon-'),
					'value'	=> $value,
					'data' => $data,
					'valueclass' => ( $this->rhc_date ? 'rhc_date' : '')
				), $template );					
			}
		}
		return '';
	}
	
	function render_separator(){
		return '<div class="post_extrainfo_separator"></div>';
	}
	
	function filter_value($value,$for_filter=array()){
		global $rhc_plugin;
		//--add the post excerpt in the post meta section.
		if($this->type=='postmeta' && $this->postmeta=='rhc_excerpt' && empty($value)){
			$main_post = get_post($this->post_ID);
			if($main_post){
				$value = $main_post->post_excerpt;
			}
		}
		//--add the post title in the post meta section.
		if($this->type=='postmeta' && $this->postmeta=='rhc_post_title' && empty($value)){
			$main_post = get_post($this->post_ID);
			if($main_post){
				$value = $main_post->post_title;
			}
		}
		   
		if( empty($value) )return '';
		//--- bug fix
		if($this->type=='postmeta' && in_array( $this->postmeta, array('fc_start_datetime', 'fc_end_datetime' ) )  ){
			if( '1' == get_post_meta( $this->post_ID, 'fc_allday', true ) ){
				$this->date_format = $rhc_plugin->get_option('date_format', get_option('date_format'), true  );
			}
		}
		
		//--- bug fix
		if($this->type=='postmeta' && in_array( $this->postmeta, array('fc_start_time', 'fc_end_time' ) )  ){
			if( '1' == get_post_meta( $this->post_ID, 'fc_allday', true ) ){
				$this->date_format = '';
				return '';
			}
		}
		

		
		if(!in_array(trim($this->date_format),array('','false',false))){
			$value = $this->filter_handle_repeat($value);
			$value = date_i18n($this->date_format,strtotime($value));
		}
		
		if(false!==$this->render_cb && is_callable($this->render_cb)){
			$value = call_user_func( $this->render_cb, $value, $this );
		}	
		
		$value = apply_filters('rhc_post_info_value',$value,$this,$for_filter);
		
		if(!empty($this->format)){
			$value = str_replace('{value}',$value,$this->format);
		}
		
		return $value;
	}
	
	function filter_handle_repeat($value){

		if(isset($_REQUEST['event_rdate'])&&''!=$_REQUEST['event_rdate']){
			$arr = explode(',',$_REQUEST['event_rdate']);
			if(count($arr)==2){
				$event_start = $arr[0];
				$event_end = isset( $arr[1] ) ? $arr[1] : '';
				if(in_array($this->postmeta,array('fc_start_datetime','fc_start','fc_start_time'))&&!empty($event_start)){
					$ts = strtotime($event_start);
					switch($this->postmeta){
						case 'fc_start_datetime':
							$value = date('Y-m-d H:i:s',$ts);
							break;
						case 'fc_start':
							$value = date('Y-m-d',$ts);
							break;
						case 'fc_start_time':
							$value = date('H:i:s',$ts);
							break;
		
					}
				}
				if(in_array($this->postmeta,array('fc_end_datetime','fc_end','fc_end_time'))&&!empty($event_end)){
					$ts = strtotime($event_end);
					switch($this->postmeta){
						case 'fc_end_datetime':
							$value = date('Y-m-d H:i:s',$ts);
							break;
						case 'fc_end':
							$value = date('Y-m-d',$ts);
							break;
						case 'fc_end_time':
							$value = date('H:i:s',$ts);
							break;
		
					}
				}			
			}

		}
		return $value;
	}
	
	function get_uniq_class( $prefix ){
		$parts = array();
		if(!empty($this->type)){
			$parts[]=$this->type;
		}
		if(!empty($this->postmeta)){
			$parts[]=$this->postmeta;
		}
		if(!empty($this->taxonomy)){
			$parts[]=$this->taxonomy;
		}
		if(!empty($this->taxonomymeta)){
			$parts[]=$this->taxonomymeta;
		}
		if(!empty($this->taxonomymeta_field)){
			$parts[]=$this->taxonomymeta_field;
		}
		if(!empty($this->custom)){
			$parts[]=$this->custom;
		}
		
		$class = $prefix.implode('-', $parts);
		
		if( !empty($this->class) ){
			$class = $this->class.' '.$class;
		}
		
		return $class;
	}
}


?>