<?php
class MFN_Options_color extends MFN_Options{	
	
	/**
	 * Field Constructor.
	 */
	function __construct( $field = array(), $value ='', $parent = NULL ){
		if( is_object($parent) ) parent::__construct($parent->sections, $parent->args, $parent->extra_tabs);
		$this->field = $field;
		$this->value = $value;
	}
	
	/**
	 * Field Render Function.
	 */
	function render( $meta = false ){

		$class = ( isset( $this->field['class']) ) ? 'class="'.$this->field['class'].'" ' : '';
		$name = ( ! $meta ) ? ( $this->args['opt_name'].'['.$this->field['id'].']' ) : $this->field['id'];
		$value = ( $this->value ) ? $this->value : $this->field['std'];
		
		echo '<div class="farb-popup-wrapper">';
		
			echo '<input type="text" id="'.$this->field['id'].'" name="'. $name .'" value="'. $value .'" class="'.$class.' popup-colorpicker"/>';
			echo '<div class="farb-popup"><div class="farb-popup-inside"><div id="'.$this->field['id'].'picker" class="color-picker"></div></div></div>';
			echo '<div class="color-prev prev-'.$this->field['id'].'" style="background-color:'. $value .';" rel="'.$this->field['id'].'"></div>';
			
			echo (isset($this->field['desc']) && !empty($this->field['desc']))?' <span class="description">'.$this->field['desc'].'</span>':'';
			
		echo '</div>';
	}
	
	/**
	 * Enqueue Function.
	 */
	function enqueue(){
		wp_enqueue_script('mfn-opts-field-color-js', MFN_OPTIONS_URI.'fields/color/field_color.js', array('jquery', 'farbtastic'), time(), true);
	}
	
}
