<?php
class MFN_Options_textarea extends MFN_Options{	
	
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
		
		// class ----------------------------------------------------
		$class 	= isset( $this->field['class'] ) ? $this->field['class'] : '';
		$param 	= isset( $this->field['param'] ) ? $this->field['param'] : '';

		// name -----------------------------------------------------
		if( $meta == 'new' ){
				
			// builder new
			$name = 'data-name="'. $this->field['id'] .'"';
				
		} elseif( $meta ){
				
			// page mata & builder existing items
			$name = 'name="'. $this->field['id'] .'"';
				
		} else {
				
			// theme options
			$name = 'name="'. $this->args['opt_name'] .'['. $this->field['id'] .']"';
		
		}
		
		// echo -----------------------------------------------------
		echo '<div class="textarea-wrapper '. $class .'">';
		
			if( strpos($class, 'sc') !== false ){
				echo '<div class="mfn-textarea-header">';
					echo '<div class="mfn-sc-add">';
						echo '<a class="mfn-sc-add-btn" href="javascript:void(0);">Add Content Shortcode</a>';
						echo '<ul class="mfn-sc-add-list">';
							echo '<li><a href="javascript:void(0);" data-rel="alert">Alert</a></li>';
							echo '<li><a href="javascript:void(0);" data-rel="blockquote">Blockquote</a></li>';
							echo '<li><a href="javascript:void(0);" data-rel="button">Button</a></li>';
							echo '<li><a href="javascript:void(0);" data-rel="code">Code</a></li>';
							echo '<li><a href="javascript:void(0);" data-rel="content_link">Content Link</a></li>';
							echo '<li><a href="javascript:void(0);" data-rel="dropcap">Dropcap</a></li>';
							echo '<li><a href="javascript:void(0);" data-rel="fancy_link">Fancy Link</a></li>';
							echo '<li><a href="javascript:void(0);" data-rel="google_font">Google Font</a></li>';
							echo '<li><a href="javascript:void(0);" data-rel="highlight">Highlight</a></li>';
							echo '<li><a href="javascript:void(0);" data-rel="hr">Hr</a></li>';
							echo '<li><a href="javascript:void(0);" data-rel="icon">Icon</a></li>';
							echo '<li><a href="javascript:void(0);" data-rel="icon_bar">Icon Bar</a></li>';
							echo '<li><a href="javascript:void(0);" data-rel="icon_block">Icon Block</a></li>';
							echo '<li><a href="javascript:void(0);" data-rel="idea">Idea</a></li>';
							echo '<li><a href="javascript:void(0);" data-rel="image">Image</a></li>';
							echo '<li><a href="javascript:void(0);" data-rel="popup">Popup</a></li>';
							echo '<li><a href="javascript:void(0);" data-rel="progress_icons">Progress Icons</a></li>';
							echo '<li><a href="javascript:void(0);" data-rel="share_box">Share Box</a></li>';
							echo '<li><a href="javascript:void(0);" data-rel="table">Table</a></li>';
							echo '<li><a href="javascript:void(0);" data-rel="tooltip">Tooltip</a></li>';
							echo '<li><a href="javascript:void(0);" data-rel="tooltip_image">Tooltip Image</a></li>';
//							echo '<li><a class="placeholder"></a></li>';
						echo '</ul>';
					echo '</div>';
					
					echo '<div class="mfn-sc-tools">';
						echo '<a class="dashicons dashicons-editor-bold" href="javascript:void(0);" data-open="b" data-close="b"></a>';			
						echo '<a class="dashicons dashicons-editor-italic"href="javascript:void(0);" data-open="i" data-close="i"></a>';			
						echo '<a class="dashicons dashicons-editor-underline"href="javascript:void(0);" data-open="u" data-close="u"></a>';			
						echo '<a class=""href="javascript:void(0);" data-open="h1" data-close="h1">H1</a>';			
						echo '<a class=""href="javascript:void(0);" data-open="h2" data-close="h2">H2</a>';			
						echo '<a class=""href="javascript:void(0);" data-open="h3" data-close="h3">H3</a>';			
						echo '<a class=""href="javascript:void(0);" data-open="h4" data-close="h4">H4</a>';			
						echo '<a class=""href="javascript:void(0);" data-open="h5" data-close="h5">H5</a>';			
						echo '<a class=""href="javascript:void(0);" data-open="h6" data-close="h6">H6</a>';	
						echo '<a class="dashicons dashicons-editor-paragraph"href="javascript:void(0);" data-open="p" data-close="p"></a>';
						echo '<a class="dashicons dashicons-editor-break"href="javascript:void(0);" data-open="br"></a>';
						echo '<a class="dashicons dashicons-camera"href="javascript:void(0);" data-open="img class=Xscale-with-gridX src=X#X alt=XX"></a>';
						echo '<a class="dashicons dashicons-admin-links"href="javascript:void(0);" data-open="a href=X#X" data-close="a"></a>';	
					echo '</div>';
					
				echo '</div>';
			}

			echo '<textarea '. $name .' class="'. $param .'" rows="8">'.esc_attr($this->value).'</textarea>';
			
			if( isset($this->field['desc']) && !empty($this->field['desc']) ){
				echo '<span class="description '.$class.'">'. $this->field['desc'] .'</span>';
			}
			
		echo '</div>';
	}
}
