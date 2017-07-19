<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 * Author: Alberto Lau (Righthere.com)
 **/


class custom_taxonomy_with_meta_body {
	var $taxonomy;
	function __construct ($taxonomy,$meta,$args=array()){
		//------------
		$defaults = array(
			'template'		 		=> '<div class="form-field {class} {required}">{label}{input}{description}</div>',
			'template_checkbox'		=> '<div class="form-field-chk {class} {required}">{input}</div>',
			'required_class' 		=> 'form-required',
			'description_template'	=> '<p>%s</p>',
			'subtitle_template'		=> '<h3>%s</h3>',
			'term_id'				=> false,
			'pluginpath'			=> ''
		);
		foreach($defaults as $property => $default){
			$this->$property = isset($args[$property])?$args[$property]:$default;
		}
		//-----------
		if(!is_array($meta)||empty($meta))return;
		$this->taxonomy = $taxonomy;
		$this->render_edit_tags($meta);
	}
	
	function render_edit_tags($meta){
		$tab = null;
		require_once "taxonomy-metadata.php";
		//require_once $this->pluginpath.'options-panel/class.pop_input.php';
		foreach($meta as $i => $o){
			$o->type = property_exists($o,'type')?$o->type:'text';
			
			if(in_array($o->type,array('subtitle'))){
				$method = "__".$o->type;
				$this->$method($tab,$i,$o);
				continue;	
			}
			
			if(false!==$this->term_id&&$this->term_id>0){
				$o->load_option = property_exists($o,'load_option')?$o->load_option:true;
				if($o->load_option){
					$o->value = get_term_meta($this->term_id, $this->get_meta_key(null,$i,$o), true);
				}
			}
			$output = $o->type=='checkbox' ? $this->template_checkbox : $this->template;
			$output = str_replace("{required}",(property_exists($o,'required')&&$o->required?$this->required_class:''),$output);
			$output = str_replace("{class}",($this->get_id(null,$i,$o)),$output);
			$output = str_replace("{label}",($this->label(null,$i,$o)),$output);
			$output = str_replace("{input}",($this->input(null,$i,$o)),$output);
			$output = str_replace("{description}",($this->description(null,$i,$o)),$output);
			echo $output;
		}	
	}
		
	function __subtitle($tab,$i,$o){
		echo sprintf($this->subtitle_template,$o->label);
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
	
	function get_meta_key($tab,$i,$o){
		return property_exists($o,'name')?$o->name:($this->get_id($tab,$i,$o));	
	}
	
	function get_id($tab,$i,$o){
		return property_exists($o,'id')?$o->id:'tax_meta_'.$i;
	}
	
	function get_name($tab,$i,$o){
		return sprintf("%s_meta[%s]",$this->taxonomy,property_exists($o,'name')?$o->name:($this->get_id($tab,$i,$o)));
	}
	
	function get_value($tab,$i,$o){
		return property_exists($o,'value')?$o->value:(property_exists($o,'default')?$o->default:'');
	}
	
	function label($tab,$i,$o){
		return sprintf('<label for="%s">%s</label>',$this->get_id($tab,$i,$o),(property_exists($o,'label')?$o->label:ucfirst($this->get_id($tab,$i,$o))) );
	}
	
	function input($tab,$i,$o){
		$method = property_exists($o,'type')&&method_exists($this,"_".$o->type)?"_".$o->type:"_text";
		return $this->$method($tab,$i,$o);
	}
	
	function description($tab,$i,$o){
		return property_exists($o,'description')&&''!=trim($o->description)?sprintf($this->description_template,$o->description):'';
	}
	
	function _text($tab,$i,$o){
		return sprintf('<input type="text" name="%s" id="%s"  value="%s" %s />',
			$this->get_name($tab,$i,$o),
			$this->get_id($tab,$i,$o),
			$this->get_value($tab,$i,$o),
			$this->get_el_properties($tab,$i,$o)
		);
	}
	
	function _textarea($tab,$i,$o){
		return sprintf('<textarea name="%s" id="%s"  %s >%s</textarea>',
			$this->get_name($tab,$i,$o),
			$this->get_id($tab,$i,$o),
			$this->get_el_properties($tab,$i,$o),
			$this->get_value($tab,$i,$o)
		);
	}
	
	function _checkbox($tab,$i,$o){
		$option_value = (property_exists($o,'option_value') ? $o->option_value : '1' );
		$checked = $option_value == $this->get_value($tab,$i,$o) ? 'checked="checked"' : '';
		return sprintf('<label for="%s"><input type="hidden" name="%s" value=""><input type="checkbox" name="%s" id="%s" %s %s value="%s" >%s</label>',
			$this->get_id($tab,$i,$o),
			$this->get_name($tab,$i,$o),
			$this->get_name($tab,$i,$o),
			$this->get_id($tab,$i,$o),
			$this->get_el_properties($tab,$i,$o),
			$checked,
			esc_attr($option_value),
			(property_exists($o,'label')?$o->label:ucfirst($this->get_id($tab,$i,$o)))
		);	
	}

	function _select($tab,$i,$o){
		/* for future development.
		if(property_exists($o,'hidegroup')){
			$hide_values = property_exists($o,'hidevalues')&&is_array($o->hidevalues)?$o->hidevalues:array('1');
			$fn = sprintf(';pop_groupcontrol(this,\'%s\',%s);', $o->hidegroup, str_replace('"',"'",json_encode($hide_values)) );
			$o->el_properties = property_exists($o,'el_properties')&&is_array($o->el_properties)?$o->el_properties:array();
			$o->el_properties['OnChange'] = isset($o->el_properties['OnChange'])?$o->el_properties['OnChange'].' '.$fn:'javascript:'.$fn;			
			$o->el_properties['class'] = isset($o->el_properties['class'])?$o->el_properties['class'].' pop_groupcontrol':'pop_groupcontrol';	
		}
		*/
		//---		
		$str = sprintf('<select id="%s" name="%s"  %s />',$this->get_id($tab,$i,$o),$this->get_name($tab,$i,$o), $this->get_el_properties($tab, $i, $o) );
		if( property_exists( $o, 'empty_option' ) ){
			$value = '';
			$selected = $value == $this->get_value($tab,$i,$o) ? 'selected="selected"' : '';
			$str.=sprintf("<option %s value=\"%s\">%s</option>", $selected, $value, $o->empty_option );
		}
		if(!empty($o->options)){
			foreach($o->options as $value => $label){
				$selected = $value == $this->get_value($tab,$i,$o) ? 'selected="selected"' : '';
				if( property_exists( $o, 'format_label' ) ){
					$option_label = sprintf( $o->format_label, $value, $label);
				}else{
					$option_label = $label;
				}			
				$str.=sprintf("<option %s value=\"%s\" data-label_no_format=\"%s\">%s</option>", $selected, $value, esc_attr($label), $option_label);
			}
		}
		$str.="</select>";

		return $str;
	}

	function _hidden($tab,$i,$o){
		return sprintf('<input type="hidden" id="%s" name="%s" value="%s" %s />',
			$this->get_id($tab,$i,$o),
			$this->get_name($tab,$i,$o),
			$this->get_value($tab,$i,$o), 
			$this->get_el_properties($tab, $i, $o) 
		);		
	}

	function _callback($tab,$i,$o){
		if(is_callable($o->callback)){
			return call_user_func($o->callback,$tab,$i,$o,$this);
		}
		return '';
	}		
	
}
 
?>