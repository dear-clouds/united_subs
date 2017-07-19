<?php
/**
 * Shortcode Generator
 */
class mom_su_Generator_Views {

	/**
	 * Constructor
	 */
	function __construct() {}

	public static function text( $id, $field ) {
		$field = wp_parse_args( $field, array(
			'default' => ''
		) );
		$return = '<input type="text" name="' . $id . '" value="' . esc_attr( $field['default'] ) . '" id="mom-su-generator-attr-' . $id . '" class="mom-su-generator-attr" />';
		return $return;
	}

	public static function textarea( $id, $field ) {
		$field = wp_parse_args( $field, array(
			'rows'    => 3,
			'default' => ''
		) );
		$return = '<textarea name="' . $id . '" id="mom-su-generator-attr-' . $id . '" rows="' . $field['rows'] . '" class="mom-su-generator-attr">' . esc_textarea( $field['default'] ) . '</textarea>';
		return $return;
	}

	public static function select( $id, $field ) {
		// Multiple selects
		$multiple = ( isset( $field['multiple'] ) ) ? ' multiple' : '';
		$return = '<select name="' . $id . '" id="mom-su-generator-attr-' . $id . '" class="mom-su-generator-attr"' . $multiple . '>';
		// Create options
		foreach ( $field['values'] as $option_value => $option_title ) {
			// Is this option selected
			$selected = ( $field['default'] === $option_value ) ? ' selected="selected"' : '';
			// Create option
			$return .= '<option value="' . $option_value . '"' . $selected . '>' . $option_title . '</option>';
		}
		$return .= '</select>';
		return $return;
	}

	public static function radio( $id, $field ) {
		// Create options
		$return = '';
		foreach ( $field['values'] as $option_value => $option_title ) {
			// Is this option checked
			$checked = ( $field['default'] === $option_value ) ? ' checked' : '';
			// Create option
			$return .= '<label class="mom-su-radoio-button"><input type="radio" name="' . $id . '" class="mom-su-generator-attr" value="' . $option_value . '"' . $checked . '>' . $option_title.'</label>';
		}
		return $return;
	}

	public static function radio_img( $id, $field ) {
		// Create options
		$return = '';
		foreach ( $field['values'] as $option_value => $option_img ) {
			// Is this option checked
			$checked = ( $field['default'] === $option_value ) ? ' checked' : '';
			$img = isset($option_img[0]) ? $option_img[0] : '';
			$title = isset($option_img[1]) ? $option_img[1] : '';
			// Create option
			$return .= '<label class="mom-su-radio-button mom-su-radio-img"><input type="radio" name="' . $id . '" class="mom-su-generator-attr" value="' . $option_value . '"' . $checked . '><img src="' . $img.'" alt="'.$title.'" title="'.$title.'"></label>';
		}
		return $return;
	}

	public static function bool( $id, $field ) {
		$return = '<span class="mom-su-generator-switch mom-su-generator-switch-' . $field['default'] . '"><span class="mom-su-generator-yes">' . __( 'Yes', 'theme' ) . '</span><span class="mom-su-generator-no">' . __( 'No', 'theme' ) . '</span></span><input type="hidden" name="' . $id . '" value="' . esc_attr( $field['default'] ) . '" id="mom-su-generator-attr-' . $id . '" class="mom-su-generator-attr mom-su-generator-switch-value" />';
		return $return;
	}

	public static function upload( $id, $field ) {
		$return = '<input type="text" name="' . $id . '" value="' . esc_attr( $field['default'] ) . '" id="mom-su-generator-attr-' . $id . '" class="mom-su-generator-attr mom-su-generator-upload-value" /><div class="mom-su-generator-field-actions"><a href="javascript:;" class="button mom-su-generator-upload-button"><img src="' . admin_url( '/images/media-button.png' ) . '" alt="' . __( 'Media manager', 'theme' ) . '" />' . __( 'Media manager', 'theme' ) . '</a></div>';
		return $return;
	}

	public static function icon( $id, $field ) {
		$return = '<input type="text" name="' . $id . '" value="' . esc_attr( $field['default'] ) . '" id="mom-su-generator-attr-' . $id . '" class="mom-su-generator-attr mom-su-generator-icon-picker-value" /><div class="mom-su-generator-field-actions"><a href="javascript:;" class="button mom-su-generator-upload-button mom-su-generator-field-action"><img src="' . admin_url( '/images/media-button.png' ) . '" alt="' . __( 'Media manager', 'theme' ) . '" />' . __( 'Media manager', 'theme' ) . '</a> <a href="javascript:;" class="button mom-su-generator-icon-picker-button mom-su-generator-field-action"><img src="' . admin_url( '/images/media-button-other.gif' ) . '" alt="' . __( 'Icon picker', 'theme' ) . '" />' . __( 'Icon picker', 'theme' ) . '</a></div><div class="mom-su-generator-icon-picker mom-su-generator-clearfix"><input type="text" class="widefat" placeholder="' . __( 'Filter icons', 'theme' ) . '" /></div>';
		return $return;
	}

	public static function color( $id, $field ) {
		$return = '<span class="mom-su-generator-select-color"><span class="mom-su-generator-select-color-wheel"></span><input type="text" name="' . $id . '" value="' . $field['default'] . '" id="mom-su-generator-attr-' . $id . '" class="mom-su-generator-attr mom-su-generator-select-color-value" /></span>';
		return $return;
	}

	public static function gallery( $id, $field ) {
		$shult = mom_shortcodes_ultimate();
		// Prepare galleries list
		$galleries = $shult->get_option( 'galleries' );
		$created = ( is_array( $galleries ) && count( $galleries ) ) ? true : false;
		$return = '<select name="' . $id . '" id="mom-su-generator-attr-' . $id . '" class="mom-su-generator-attr" data-loading="' . __( 'Please wait', 'theme' ) . '">';
		// Check that galleries is set
		if ( $created ) // Create options
			foreach ( $galleries as $g_id => $gallery ) {
				// Is this option selected
				$selected = ( $g_id == 0 ) ? ' selected="selected"' : '';
				// Prepare title
				$gallery['name'] = ( $gallery['name'] == '' ) ? __( 'Untitled gallery', 'theme' ) : stripslashes( $gallery['name'] );
				// Create option
				$return .= '<option value="' . ( $g_id + 1 ) . '"' . $selected . '>' . $gallery['name'] . '</option>';
			}
		// Galleries not created
		else
			$return .= '<option value="0" selected>' . __( 'Galleries not found', 'theme' ) . '</option>';
		$return .= '</select><small class="description"><a href="' . $shult->admin_url . '#tab-3" target="_blank">' . __( 'Manage galleries', 'theme' ) . '</a>&nbsp;&nbsp;&nbsp;<a href="javascript:;" class="mom-su-generator-reload-galleries">' . __( 'Reload galleries', 'theme' ) . '</a></small>';
		return $return;
	}

	public static function number( $id, $field ) {
		$return = '<input type="number" name="' . $id . '" value="' . esc_attr( $field['default'] ) . '" id="mom-su-generator-attr-' . $id . '" min="' . $field['min'] . '" max="' . $field['max'] . '" step="' . $field['step'] . '" class="mom-su-generator-attr" />';
		return $return;
	}

	public static function slider( $id, $field ) {
		$return = '<div class="mom-su-generator-range-picker mom-su-generator-clearfix"><input type="number" name="' . $id . '" value="' . esc_attr( $field['default'] ) . '" id="mom-su-generator-attr-' . $id . '" min="' . $field['min'] . '" max="' . $field['max'] . '" step="' . $field['step'] . '" class="mom-su-generator-attr" /></div>';
		return $return;
	}

	public static function shadow( $id, $field ) {
		$defaults = ( $field['default'] === 'none' ) ? array ( '0', '0', '0', '#000000' ) : explode( ' ', str_replace( 'px', '', $field['default'] ) );
		$return = '<div class="mom-su-generator-shadow-picker"><span class="mom-su-generator-shadow-picker-field"><input type="number" min="-1000" max="1000" step="1" value="' . $defaults[0] . '" class="mom-su-generator-sp-hoff" /><small>' . __( 'Horizontal offset', 'theme' ) . ' (px)</small></span><span class="mom-su-generator-shadow-picker-field"><input type="number" min="-1000" max="1000" step="1" value="' . $defaults[1] . '" class="mom-su-generator-sp-voff" /><small>' . __( 'Vertical offset', 'theme' ) . ' (px)</small></span><span class="mom-su-generator-shadow-picker-field"><input type="number" min="-1000" max="1000" step="1" value="' . $defaults[2] . '" class="mom-su-generator-sp-blur" /><small>' . __( 'Blur', 'theme' ) . ' (px)</small></span><span class="mom-su-generator-shadow-picker-field mom-su-generator-shadow-picker-color"><span class="mom-su-generator-shadow-picker-color-wheel"></span><input type="text" value="' . $defaults[3] . '" class="mom-su-generator-shadow-picker-color-value" /><small>' . __( 'Color', 'theme' ) . '</small></span><input type="hidden" name="' . $id . '" value="' . esc_attr( $field['default'] ) . '" id="mom-su-generator-attr-' . $id . '" class="mom-su-generator-attr" /></div>';
		return $return;
	}


	public static function border( $id, $field ) {
		$defaults = ( $field['default'] === 'none' ) ? array ( '0', 'solid', '#000000' ) : explode( ' ', str_replace( 'px', '', $field['default'] ) );
		$borders = mom_su_Tools::select( array(
				'options' => mom_su_Data::borders(),
				'class' => 'mom-su-generator-bp-style',
				'selected' => $defaults[1]
			) );
		$return = '<div class="mom-su-generator-border-picker"><span class="mom-su-generator-border-picker-field"><input type="number" min="-1000" max="1000" step="1" value="' . $defaults[0] . '" class="mom-su-generator-bp-width" /><small>' . __( 'Border width', 'theme' ) . ' (px)</small></span><span class="mom-su-generator-border-picker-field">' . $borders . '<small>' . __( 'Border style', 'theme' ) . '</small></span><span class="mom-su-generator-border-picker-field mom-su-generator-border-picker-color"><span class="mom-su-generator-border-picker-color-wheel"></span><input type="text" value="' . $defaults[2] . '" class="mom-su-generator-border-picker-color-value" /><small>' . __( 'Border color', 'theme' ) . '</small></span><input type="hidden" name="' . $id . '" value="' . esc_attr( $field['default'] ) . '" id="mom-su-generator-attr-' . $id . '" class="mom-su-generator-attr" /></div>';
		return $return;
	}

	public static function image_source( $id, $field ) {
		$field = wp_parse_args( $field, array(
				'default' => 'none'
			) );
		$sources = mom_su_Tools::select( array(
				'options'  => array(
					'media'         => __( 'Media library', 'theme' ),
					'posts: recent' => __( 'Recent posts', 'theme' ),
					'category'      => __( 'Category', 'theme' ),
					'taxonomy'      => __( 'Taxonomy', 'theme' )
				),
				'selected' => '0',
				'none'     => __( 'Select images source', 'theme' ) . '&hellip;',
				'class'    => 'mom-su-generator-isp-sources'
			) );
		$categories = mom_su_Tools::select( array(
				'options'  => mom_su_Tools::get_terms( 'category' ),
				'multiple' => true,
				'size'     => 10,
				'class'    => 'mom-su-generator-isp-categories'
			) );
		$taxonomies = mom_su_Tools::select( array(
				'options'  => mom_su_Tools::get_taxonomies(),
				'none'     => __( 'Select taxonomy', 'theme' ) . '&hellip;',
				'selected' => '0',
				'class'    => 'mom-su-generator-isp-taxonomies'
			) );
		$terms = mom_su_Tools::select( array(
				'class'    => 'mom-su-generator-isp-terms',
				'multiple' => true,
				'size'     => 10,
				'disabled' => true,
				'style'    => 'display:none'
			) );
		$return = '<div class="mom-su-generator-isp">' . $sources . '<div class="mom-su-generator-isp-source mom-su-generator-isp-source-media"><div class="mom-su-generator-clearfix"><a href="javascript:;" class="button button-primary mom-su-generator-isp-add-media"><i class="fa fa-plus"></i>&nbsp;&nbsp;' . __( 'Add images', 'theme' ) . '</a></div><div class="mom-su-generator-isp-images mom-su-generator-clearfix"><em class="description">' . __( 'Click the button above and select images.<br>You can select multimple images with Ctrl (Cmd) key', 'theme' ) . '</em></div></div><div class="mom-su-generator-isp-source mom-su-generator-isp-source-category"><em class="description">' . __( 'Select categories to retrieve posts from.<br>You can select multiple categories with Ctrl (Cmd) key', 'theme' ) . '</em>' . $categories . '</div><div class="mom-su-generator-isp-source mom-su-generator-isp-source-taxonomy"><em class="description">' . __( 'Select taxonomy and it\'s terms.<br>You can select multiple terms with Ctrl (Cmd) key', 'theme' ) . '</em>' . $taxonomies . $terms . '</div><input type="hidden" name="' . $id . '" value="' . $field['default'] . '" id="mom-su-generator-attr-' . $id . '" class="mom-su-generator-attr" /></div>';
		return $return;
	}

}