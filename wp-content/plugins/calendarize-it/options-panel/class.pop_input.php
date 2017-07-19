<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/

class pop_input {
	var $uid = 0;
	var $farbtastic = true;
	var $icons_footer = array();
	function __construct($args=array()){
		$defaults = array(
			'farbtastic'	=> true
		);
		foreach($defaults as $property => $default){
			$this->$property = isset($args[$property])?$args[$property]:$default;
		}
		//---	
	}
	function get_el_id($tab,$i,$o){
		$id = property_exists($o,'id')?$o->id:(property_exists($o,'name')?$o->name:$tab->type.$this->uid++);
		if(strpos($id,'[]')){
			$id = str_replace('[]',$this->uid++,$id);
		}
		return $id;
	}
	
	function get_el_name($tab,$i,$o){
		return property_exists($o,'name')?$o->name:(property_exists($o,'id')?$o->id:$tab->type.$this->uid++);
	}	
	
	function get_option_name($tab,$i,$o){
		return property_exists($o,'option_name')?$o->option_name:str_replace("[]", "", $this->get_el_name($tab,$i,$o) );
	}
	
	function get_el_properties($tab,$i,$o){
		$elp = array();
		if(count(@$o->el_properties)>0){
			foreach($o->el_properties as $prop => $val){
				$elp[] = sprintf("%s=\"%s\"",$prop,$val);
			}
		}
		return implode(' ',$elp);
	}	
	function _subtitle($tab,$i,$o,&$save_fields){
		$class = property_exists($o,'class') ? $o->class : '';
		return sprintf("<h3 class=\"option-panel-subtitle %s\">%s</h3>",$class,@$o->label);
	}
	
	static function translucent_description($description=''){
		return trim($description)==''?'':sprintf('<div class="pt-clear"></div><div class="description-holder"><div class="description">%s</div><div class="description-bg">%s</div></div>',$description,$description);
	}
	
	function _description($tab,$i,$o){
		return $this->translucent_description(@$o->description);
	}
	
	function _hr(){
		return sprintf("<hr class=\"hr\" />");
	}
	
	function _textarea($tab,$i,$o,&$save_fields){
		if(true===$o->save_option){
			$save_fields[]= $this->get_option_name($tab,$i,$o);	
		}
		$str = '';
		if(!@$o->nolabel){
			$str.=sprintf("<div class=\"slider-label\">%s</div>",@$o->label);
		}
		$str .= sprintf("<textarea id=\"%s\" name=\"%s\" %s>%s</textarea>",
			$this->get_el_id($tab,$i,$o),
			$this->get_el_name($tab,$i,$o), 
			$this->get_el_properties($tab,$i,$o), 
			$o->value
			);
		return $str;
	}
	
	function _label($tab,$i,$o,&$save_fields){
		$label = property_exists($o,'value')?$o->value:(property_exists($o,'label')?$o->label:false);
		return $label?sprintf('<label>%s</label>',$label ):'';
	}
	
	function _farbtastic($tab,$i,$o,&$save_fields){
		if ( !$this->farbtastic ){
			return $this->_colorpicker($tab,$i,$o,$save_fields);
		}
		//---
		$farbtastic_id = 'pop-farbtastic-'.$this->uid++;
		
		$show_label = property_exists($o,'show_label')?$o->show_label:__('Choose color','pop');
		$hide_label = property_exists($o,'hide_label')?$o->hide_label:__('Close','pop');
		$o->value = trim($o->value)==''?'#':$o->value;
		//return "<div class=\"farbtastic-holder\">".$this->_text($tab,$i,$o,$save_fields).sprintf('<a class="farbtastic-choosecolor" href="javascript:void(0);" rel="%s">%s</a><div id="%s" rel="#%s" class="pop-farbtastic"></div>',$hide_label,$show_label,$farbtastic_id,$this->get_el_id($tab,$i,$o))."</div>";
		return sprintf('<div class="farbtastic-holder">%s<a title="%s" class="farbtastic-choosecolor" href="javascript:void(0);" rel="%s">%s</a><div id="%s" rel="#%s" class="pop-farbtastic"></div></div><div class="pop-float-separator">&nbsp;</div>',
			$this->_text($tab,$i,$o,$save_fields),
			$show_label,
			$hide_label,
			$show_label,
			$farbtastic_id,
			$this->get_el_id($tab,$i,$o)
		);	
	}
	
	function _colorpicker($tab,$i,$o,&$save_fields){
		$o->el_properties = property_exists($o,'el_properties')&&is_array($o->el_properties)?$o->el_properties:array();
		$o->el_properties['class'] = isset($o->el_properties['class'])?$o->el_properties['class'].' pop-colorpicker':'pop-colorpicker';
		return $this->_text($tab,$i,$o,$save_fields);
	}
	
	function _text($tab,$i,$o,&$save_fields){
		$str = sprintf('<input type="text" id="%s" name="%s" value="%s" %s />',
			$this->get_el_id($tab,$i,$o),
			$this->get_el_name($tab,$i,$o),
			(property_exists($o,'value') ? esc_attr( $o->value ) : ''), 
			$this->get_el_properties($tab, $i, $o) 
		);		
		if( property_exists(  $o, 'save_option' ) && true===$o->save_option){
			$save_fields[]=$this->get_option_name($tab,$i,$o);	
		}
		return $str;
	}
	
	function _password($tab,$i,$o,&$save_fields){
		$str = sprintf('<input type="password" id="%s" name="%s" value="%s" %s />',
			$this->get_el_id($tab,$i,$o),
			$this->get_el_name($tab,$i,$o),
			(property_exists($o,'value') ? esc_attr( $o->value ) : ''),
			$this->get_el_properties($tab, $i, $o) 
		);		
		if(true===$o->save_option){
			$save_fields[]=$this->get_option_name($tab,$i,$o);	
		}
		return $str;
	}
	
	function _input_range($tab,$i,$o,&$save_fields){
		foreach(array('step'=>1,'min'=>0,'max'=>1,'nolabel'=>false) as $field => $default){
			$o->$field = property_exists($o,$field)?$o->$field:$default;
		}
		$str = '';
		if(!$o->nolabel){
			$str.=sprintf("<div class=\"slider-label\">%s</div>",@$o->label);
		}
		
		//$o->el_properties = property_exists($o,'el_properties')?$o->el_properties:array();
		//$o->el_properties['class'] = isset($o->el_properties['class'])?$o->el_properties['class'].' pop_rangeinput':'pop_rangeinput';	
		
		$str .= sprintf('<input type="range" id="%s" name="%s" value="%s"  min="%s" max="%s" step="%s" %s /><div class="pop-sep">&nbsp;</div>',$this->get_el_id($tab,$i,$o),$this->get_el_name($tab,$i,$o),$o->value , $o->min, $o->max, $o->step, $this->get_el_properties($tab, $i, $o) );		
		if(true===$o->save_option){
			$save_fields[]=$this->get_option_name($tab,$i,$o);	
		}
		return $str;
	}
	
	function _range($tab,$i,$o,&$save_fields){
		$o->el_properties = property_exists($o,'el_properties')?$o->el_properties:array();
		$o->el_properties['class'] = isset($o->el_properties['class'])?$o->el_properties['class'].' pop_rangeinput':'pop_rangeinput';	
		return $this->_input_range($tab,$i,$o,$save_fields);				
	}
	
	function _arrowslider($tab,$i,$o,&$save_fields){
		$o->el_properties = property_exists($o,'el_properties')?$o->el_properties:array();
		$o->el_properties['class'] = isset($o->el_properties['class'])?$o->el_properties['class'].' arrow-slider':'arrow-slider';	
		$o->nolabel=true;
		return $this->_input_range($tab,$i,$o,$save_fields);				
	}
	
	function _hidden( $tab, $i, $o, &$save_fields ){
		return $this->hidden( $tab, $i, $o, $save_fields );
	}
	
	function hidden($tab,$i,$o,&$save_fields){
		//Note: i think this is just misspelled. but lets add a wrapper just in case.
		$str = sprintf('<input type="hidden" id="%s" name="%s" value="%s" %s />',$this->get_el_id($tab,$i,$o),$this->get_el_name($tab,$i,$o),$o->value, $this->get_el_properties($tab, $i, $o) );		
		if(true===$o->save_option){
			$save_fields[]=$this->get_option_name($tab,$i,$o);	
		}
		return $str;
	}
	
	function _checkbox($tab,$i,$o,&$save_fields){
		$o->option_value=(property_exists($o,'option_value'))?$o->option_value:1;
		if( property_exists($o,'value') ){
			if(is_array($o->value)){
				$checked = in_array($o->option_value,$o->value)?'checked="checked"':'';
			}else{	
				//Note: when the value of a check box is 0 and the option is '' this is evaluating true and checking the checkbox.
				//not sure if === will make it worst, so for now just handle the issue specificaly.
				if( $o->value=='' && $o->option_value==0){
					$checked = '';
				}else{
					$checked = $o->value==$o->option_value?'checked="checked"':''; 
				}				
			}		
		}else{
			$checked='';
		}

		$str = sprintf('<input type="checkbox" id="%s" name="%s" value="%s" %s %s />',$this->get_el_id($tab,$i,$o),$this->get_el_name($tab,$i,$o),$o->option_value, $this->get_el_properties($tab, $i, $o) , $checked);	
		if(true===$o->save_option){
			$save_fields[]=$this->get_option_name($tab,$i,$o);	
		}
		return $str;
	}
	
	function _select($tab,$i,$o,&$save_fields){
		if(property_exists($o,'hidegroup')){
			$hide_values = property_exists($o,'hidevalues')&&is_array($o->hidevalues)?$o->hidevalues:array('1');
			$fn = sprintf(';pop_groupcontrol(this,\'%s\',%s);', $o->hidegroup, str_replace('"',"'",json_encode($hide_values)) );
			$o->el_properties = property_exists($o,'el_properties')&&is_array($o->el_properties)?$o->el_properties:array();
			$o->el_properties['OnChange'] = isset($o->el_properties['OnChange'])?$o->el_properties['OnChange'].' '.$fn:'javascript:'.$fn;			
			$o->el_properties['class'] = isset($o->el_properties['class'])?$o->el_properties['class'].' pop_groupcontrol':'pop_groupcontrol';	
		}
		//---		
		$str = sprintf('<select id="%s" name="%s"  %s />',$this->get_el_id($tab,$i,$o),$this->get_el_name($tab,$i,$o), $this->get_el_properties($tab, $i, $o) );
		if(!empty($o->options)){
			foreach($o->options as $value => $label){
				$selected = $o->value==$value?'selected="selected"':'';
				if( is_object($label) && property_exists($label,'meta_key')){
					$str.=sprintf("<option data-%s=\"%s\" %s value=\"%s\">%s</option>", $label->meta_key, $label->meta_value, $selected, $value, $label->label);
				}else{
					$str.=sprintf("<option %s value=\"%s\">%s</option>", $selected, $value, $label);				
				}
			}
		}
		$str.="</select>";
		if(true===$o->save_option){
			$save_fields[]=$this->get_option_name($tab,$i,$o);	
		}
		return $str;
	}
	
	function _select_parent($tab,$i,$o,&$save_fields){
		$o->el_properties['class'] = isset($o->el_properties['class'])?$o->el_properties['class'].' parent-child-dropdown':'parent-child-dropdown';
		$o->el_properties['data-parent_field'] = isset($o->el_properties['data-parent_field']) ? $o->el_properties['data-parent_field'] : 'parent';
		if( !property_exists($o, 'child')) return '<div>Settings error: parent/child dropdown type specified, but no child was defined</div>';
		$o->el_properties['data-child'] = $o->child;
		return $this->_select($tab,$i,$o,$save_fields);
	}
	
	function _yesno($tab,$i,$o,&$save_fields){
		$o->options = array(
			'1'=>__('Yes','pop'),
			'0'=>__('No','pop')
		);
		if(property_exists($o,'hidegroup')){
			$hide_values = property_exists($o,'hidevalues')&&is_array($o->hidevalues)?$o->hidevalues:array('1');
			$fn = sprintf(';pop_groupcontrol(this,\'%s\',%s);', $o->hidegroup, str_replace('"',"'",json_encode($hide_values)) );
			$o->el_properties = property_exists($o,'el_properties')&&is_array($o->el_properties)?$o->el_properties:array();
			$o->el_properties['OnClick'] = isset($o->el_properties['OnClick'])?$o->el_properties['OnClick'].' '.$fn:'javascript:'.$fn;			
			$o->el_properties['class'] = isset($o->el_properties['class'])?$o->el_properties['class'].' pop_groupcontrol':'pop_groupcontrol';	
		}
		return $this->_switcher($tab,$i,$o,$save_fields);
	}
	
	function _radio($tab,$i,$o,&$save_fields){
		$str = '';
		if(!empty($o->options)){
			$k=0;
			foreach($o->options as $value => $label){
				$id = $this->get_el_id($tab,$i,$o).'_'.($k++);
				$name = $this->get_el_name($tab,$i,$o);
				$selected = $o->value==$value?'checked':'';
				$str.=sprintf("<input %s id=\"%s\" name=\"%s\" type=\"radio\" %s value=\"%s\" />&nbsp;<label for=\"%s\">%s</label>&nbsp;&nbsp;", $this->get_el_properties($tab, $i, $o), $id, $name, $selected, $value, $id, $label);
			}
			if(true===$o->save_option){
				$save_fields[]=$this->get_option_name($tab,$i,$o);	
			}
		}
		return $str;
	}
	//---
	function _div_start($tab,$i,$o,&$save_fields){
		$id = $this->get_el_id($tab,$i,$o);
		$o->el_properties = property_exists($o,'el_properties')&&is_array($o->el_properties)?$o->el_properties:array();
		$o->el_properties['class'] = isset($o->el_properties['class'])?$o->el_properties['class'].' pop-option-group':'pop-option-group';
		$str = sprintf('<div id="%s" %s >',$id, $this->get_el_properties($tab, $i, $o) );		
		return $str;
	}
	function _div_end($tab,$i,$o,&$save_fields){
		return "</div>";
	}
	//---
	function _saved_settings_list($tab,$i,$o,&$save_fields){
		$id = $this->get_el_id($tab,$i,$o);
		$group = property_exists($o,'anygroup')&&$o->anygroup==true?'':$tab->id;
		$o->fields = property_exists($o,'fields')?$o->fields:array('name'=>__('Name','pop'),'version'=>__('Version','pop'),'date'=>__('Date','pop'));
		$labels='';
		$o->link_restore = property_exists($o,'link_restore')?$o->link_restore:false;
		$o->link_load = property_exists($o,'link_load')?$o->link_load:true;
		$o->class = property_exists($o,'class')?$o->class:'';
		$o->class = $o->link_restore ? $o->class.' with-link-restore':$o->class;
		$o->class = $o->link_load ? $o->class.' with-link-load':$o->class;
		foreach($o->fields as $key => $label){
			$labels.="<th>$label</th>";
		}
		$out = "<table id=\"$id\" class=\"widefat\">";
		$out.= "<thead>$labels</thead>";
		$out.= sprintf('<tbody id="%s" class="popex-list %s" rel="%s"></tbody>',$id,@$o->class,$group);
		$out.="<tfoot>$labels</tfoot>";
		$out.= "</table>";
		if(property_exists($o,'debug')&&$o->debug){
			$out.='<input type="button" class="popex-btn-refresh" value="Refresh" />';
		}
		return $out;
	}	
	//---
	/*
	function _saved_settings_list($tab,$i,$o,&$save_fields){
		$id = $this->get_el_id($tab,$i,$o);
		$group = property_exists($o,'anygroup')&&$o->anygroup==true?'':$tab->id;
		return sprintf('<div id="%s" class="popex-list %s" rel="%s"></div>',$id,@$o->class,$group);	
	}	
	*/
	function _save_settings($tab,$i,$o,&$save_fields){
		$id = $this->get_el_id($tab,$i,$o);
		$o->button_label = property_exists($o,'button_label')?$o->button_label:__('Save settings backup','pop');
		$group = property_exists($o,'anygroup')&&$o->anygroup==true?'':$tab->id;
		$o->export_fields = property_exists($o,'export_fields')&&is_array($o->export_fields)?implode(',',$o->export_fields):@$o->export_fields;
		//$out = sprintf('<label class="export-label %s" >%s</label>',@$o->label_class,@$o->label);
		$out= sprintf('<input type="text" value="" class="popex-label inp-export-label" id="popex-label-%s">',$id);
		$out.= sprintf('<input type="button" value="%s" id="popex-save-%s" class="button-secondary popex-save %s"  rel="%s" />',$o->button_label,$id,@$o->button_class,@$o->list_id);
		$out.= sprintf('<input id="pop-export-fields-%s" class="popex-fields" type="hidden" value="%s" />',$id,@$o->export_fields);
		$out.= sprintf('<input id="pop-export-group-%s" class="popex-group" type="hidden" value="%s" />',$id,$group);
		$out.= sprintf('<div id="popex-status-%s" class="popex-status btn-saving-status"></div>',$id);
		return $out;
	}
	
	function _clear($tab,$i,$o){
		return sprintf("<div class=\"pt-clear\" %s></div>",$this->get_el_properties($tab,$i,$o));
	}
	
	function _submit($tab,$i,$o){
		if( !is_super_admin() && current_user_can('rh_demo') ){
			$o->class.= ' rh_demo';
			$o->demo_message = __('Sorry, but this feature is disabled in the demo!','pop');
		}else{
			$o->demo_message = '';
		}
		return sprintf("<input class=\"%s\" type=\"submit\" name=\"theme_options_submit\" value=\"%s\" data-demo_message=\"%s\" />",$o->class, $o->label, $o->demo_message);
	}
	
	function _button($tab,$i,$o){
		$id = $this->get_el_id($tab,$i,$o);
		return sprintf("<input class=\"%s\" type=\"button\" id=\"%s\" name=\"%s\" value=\"%s\" %s />",$o->class, $id, $id, $o->label, $this->get_el_properties($tab,$i,$o) );
	}	
	
	function _callback($tab,$i,$o,&$save_fields){
		if(is_callable($o->callback)){
			if( is_array($o->callback) && count($o->callback)==2 ){
				$co = $o->callback[0];
				$method = $o->callback[1];
				return $co->$method($tab, $i, $o, $save_fields);
			}else if( is_string($o->callback) ){
				$fn = $o->callback;
				return $fn( $tab,$i,$o,$save_fields );
			}else{
				return call_user_func($o->callback,$tab,$i,$o,$save_fields);
			}
		}
		return '';
	}	
	
	function _preview($tab,$i,$o,&$save_fields){
		if(!property_exists($o,'items')||empty($o->items))return '';
		$out = sprintf('<div class="pop-preview"><div class="pop-preview-items">');
		foreach($o->items as $item){
			$out.=sprintf('<div class="pop-preview-item" rel="%s|%s">%s<img src="%s" />%s</div>',
				@$item->focus_target,
				@$items->click_target,
				(property_exists($item,'label')&&$item->label!=''?'<div class="pop-preview-label">'.$item->label.'</div>':''),
				$o->path.$item->src,
				(property_exists($item,'description')&&$item->description!=''?'<div class="pop-preview-description">'.$item->description.'</div>':'')
			);
		}	
		$out.= '</div></div>';
		return $out;
	}	
	
	function _fileuploader($tab,$i,$o,&$save_fields){
		$id = $this->get_el_id($tab,$i,$o);
		$o->el_properties = property_exists($o,'el_properties')?$o->el_properties:array();
		$o->el_properties['class']=isset($o->el_properties['class'])?$o->el_properties['class'].' pop-input-fileuploader':'pop-input-fileuploader';
		//$o->preview_selector = property_exists($o,'preview_selector')?$o->preview_selector:sprintf('%s_preview',$id);
		$o->el_properties['rel']=property_exists($o,'preview_selector')?$o->preview_selector:sprintf('#%s_preview',$id);
		$out = $this->_text($tab,$i,$o,$save_fields);
		$out.= sprintf('<div id="%s_fileuploader" class="pop-fileuploader" rel="#%s"></div><span id="%s_msg" class="pop-fileuploader-msg"></span><div id="%s_preview" class="pop-uploader-preview-holder"></div>',$id,$id,$id,$id);
		$out.= sprintf('<input type="hidden" id="%s_dcurl" value="%s" />',$o->id, (property_exists($o,'dcurl')?$o->dcurl:'') );
		$out.= '<div class="pop-float-separator">&nbsp;</div>';
		return $out;
	}
	
	function _onoff($tab,$i,$o,&$save_fields){
		if(!property_exists($o,'options')){
			$o->options = array(
				'1'=>__('On','pop'),
				'0'=>__('Off','pop')
			);		
		}

		if(property_exists($o,'hidegroup')){
			$hide_values = property_exists($o,'hidevalues')&&is_array($o->hidevalues)?$o->hidevalues:array('1');
			$fn = sprintf(';pop_groupcontrol(this,\'%s\',%s);', $o->hidegroup, str_replace('"',"'",json_encode($hide_values)) );
			$o->el_properties = property_exists($o,'el_properties')&&is_array($o->el_properties)?$o->el_properties:array();
			$o->el_properties['OnChange'] = isset($o->el_properties['OnChange'])?$o->el_properties['OnChange'].' '.$fn:'javascript:'.$fn;			
			$o->el_properties['class'] = isset($o->el_properties['class'])?$o->el_properties['class'].' pop_groupcontrol':'pop_groupcontrol';	
		}

		return $this->_switcher($tab,$i,$o,$save_fields);;
	}

	function _switcher( $tab, $i, $o, &$save_fields ) {
		$current_value = '';
		if(is_array($o->value)){
			foreach($o->options as $v => $l){
				if( ''!=trim($v) && in_array($v, $o->value) ){
					$current_value = $v;
					break;
				}
			}
		}else{
			$current_value = $o->value;
		}
		
		$str = "";
		$str .= "<div class=\"pop-onoff-control\">";
		$id = $this->get_el_id($tab,$i,$o);
		$str .= sprintf('<input type="hidden" id="%s" name="%s" value="%s" %s />',
			$id,
			$this->get_el_name($tab,$i,$o),
			$current_value, 
			$this->get_el_properties($tab, $i, $o) 
		);	

		$str .= "<div class=\"pop-onoff\">";	
		foreach($o->options as $value => $label){
			$str .= sprintf('<button type="button" class="pop-onoff-btn" value="%s" rel="%s">%s</button>',
				$value,
				$id,
				$label
			);		
		}
		$str .= "</div>";
		$str .= "</div>";

		if(true===$o->save_option){
			$save_fields[]=$this->get_option_name($tab,$i,$o);	
		}

		return $str;
	}
	
	function _wp_uploader($tab,$i,$o,&$save_fields){
		$id = $this->get_el_id($tab,$i,$o);
		$size = property_exists($o,'image_size') ? $o->image_size : array(266,199);
		$modal_title = property_exists($o,'modal_title') ? $o->modal_title : '';
		$modal_button = property_exists($o,'modal_button') ? $o->modal_button : __('Select','pop');
		$o->name = $this->get_el_name($tab,$i,$o);
		$out = '';
		
		$set_label = $o->set_label;
	
		$image = $o->value>0 ? wp_get_attachment_image_src( $o->value, $size ) : false;
		$src = false===$image?'':$image[0];
		$out.= sprintf('<input type="hidden" id="%s_inp" name="%s" value="%s" class="wp_uploader_inp" data-preview_src="%s" data-preview_w="%s" data-preview_h="%s"  data-set_label="%s" />', 
			$id, 
			$o->name, 
			$o->value,
			false===$image?'':$image[0],
			false===$image?$size[0]:$image[1],
			false===$image?$size[1]:$image[2],
			$set_label	
		);
		$out.= sprintf('<p class="hide-if-no-js"><a class="pop-wp-uploader-set" data-target_field_id="%s" data-modal_title="%s" data-modal_button="%s" href="javascript:void(0);"></a></p>',
			sprintf('#%s_inp',$id),
			$modal_title,
			$modal_button
		);
		$out.= sprintf('<p class="hide-if-no-js"><a class="pop-wp-uploader-unset" href="javascript:void(0);">%s</a></p>',
			$o->unset_label
		);			
		
		if( property_exists(  $o, 'save_option' ) && true===$o->save_option){
			$save_fields[]=$this->get_option_name($tab,$i,$o);	
		}
		
		return $out;		
	}
	
	function _rolemanager($tab,$i,$o,&$save_fields){
		$id = $this->get_el_id($tab,$i,$o);
		$html = '';
		$roles = get_editable_roles();
		$excluded_roles	= property_exists($o,'excluded_roles') ? $o->excluded_roles : array();
		if(count($roles)>0){
			foreach($roles as $role => $r){
				if( in_array($role,$excluded_roles) ) continue;
				$html .= sprintf('<h3 class="option-panel-subtitle">%s</h3>',$r['name']);
				$html .= '<table class="widefat">';
				foreach( $o->capabilities as $cap => $label ){
					$name = sprintf('rolemanager[%s][%s][%s]',$id,$role,$cap);
					$html.='<tr class="pop-roleman-item">';
					$html.='<td><span class="pt-label">'.$label.'</span></td>';
					$t = (object)array(
						'id'			=> $id.'_'.$role.'_'.$cap,
						'name'			=> $name,
						'value'			=> isset( $roles[$role]['capabilities'][$cap] ) ? $roles[$role]['capabilities'][$cap] : 0,
						'save_option'	=> false,
						'load_option'	=> false
					);
					
					$html.= '<td>';
					$html.= $this->_yesno($tab,$i,$t,$save_fields);
					$html.= '</td>';
					
					$html.='</tr>';
				}
				$html .= "</table>";
			}
		}else{
			return __('You are not allowed to edit user roles.','pop');
		}
				
		return $html;
	}
	
	function _icons( $tab,$i,$o,&$save_fields ){
		$id = $this->get_el_id($tab,$i,$o);
		$source_id = property_exists($o,'source_id') && !empty( $o->source_id ) ? $o->source_id : $id.'_source';
		//$this->_hidden( $tab, $i, $o, $save_fields );
		$o->el_properties['class'] = isset($o->el_properties['class'])?$o->el_properties['class'].' pop-icon-picker-input':'pop-icon-picker-input';
		$options	= property_exists($o,'options') ? $o->options : array();
		if( property_exists($o,'enable_mouseenter') && $o->enable_mouseenter ){
			$o->el_properties['data-enable_mouseenter'] = '1';
		}
		if( empty($options) ) return '';
		$choose_label = property_exists($o,'choose_label') ? $o->choose_label : __('Choose','pop');
		$value = $o->value;
		$label = isset( $options[$value] ) ? '' :  $choose_label;
		
		ob_start();
?>
		<div class="pop-icon-picker icon-picker-container <?php echo empty($value) ? 'no-icon-chosen' : ''?>">
			<?php echo $this->_hidden( $tab, $i, $o, $save_fields ); ?>		
			<a data-value="<?php echo esc_attr( $value ); ?>" class="pop-icon-trigger current-icon icon <?php echo esc_attr( $value ); ?>"><?php echo $label ?></a>
			<a class="pop-icon-item pop-icon-clear icon" data-value="" alt="<?php echo $choose_label?>" title="<?php echo $choose_label ?>"><?php _e('Clear','pop')?></a>
			<span class="icon-picker" data-source="#<?php echo $source_id?>">						
			
			</span>
		</div>
<?php		
		$output = ob_get_contents();
		ob_end_clean();
		
		if( !isset( $this->icons_footer[$source_id] ) ){
			$footer = '<div id="'.$source_id.'" style="display:none;">';
			foreach($options as $value => $label) {
				$footer .= sprintf('<a data-value="%s" class="pop-icon-item icon %s" alt="%s" title="%s"></a>',
					$value,
					$value,
					$label,
					''
				);
			}
			$footer .= '</div>';
			
			$this->icons_footer[$source_id]=$footer;
			
			if( is_admin() ){
				add_action( 'admin_footer', array( &$this, '_icons_footer') );
			}else{
				add_action( 'wp_footer', array( &$this, '_icons_footer') );
			}		
		}

		return $output;
	}
	
	function _icons_footer(){
		echo implode("\n", $this->icons_footer );
	}
}
?>