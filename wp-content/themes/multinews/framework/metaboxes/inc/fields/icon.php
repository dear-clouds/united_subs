<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'RWMB_Icon_Field' ) )
{
	class RWMB_Icon_Field
	{
		/**
		 * Get field HTML
		 *
		 * @param string $html
		 * @param mixed  $meta
		 * @param array  $field
		 *
		 * @return string
		 */
		static function html( $html, $meta, $field )
		{
			return sprintf(
				'<div class="mom_icons_selector">
		<a href="#" class="mom_select_icon button">'.__('Select Icon', 'framework').'</a></a><span class="or">or</span><a href="#" class="mom_upload_icon button simptip-position-top simptip-movable simptip-multiline" data-tooltip="'.__('Best Icon size is : 24px', 'framework').'">'. __('Upload custom Icon', 'framework').'</a>
		<span class="mom_icon_prev"><i></i><a href="#" class="remove_icon enotype-icon-cross2" title="Remove Icon"></a></span>
		<input name="%s" id="%s" class="mom_icon_holder" type="hidden" value="%s"/><br />
		<br /><span class="description">'. __('select category icon', 'framework').'</span>
		</div>',
				$field['field_name'],
				$field['id'],
				$meta
			);
		}

		/**
		 * Normalize parameters for field
		 *
		 * @param array $field
		 *
		 * @return array
		 */
		static function normalize_field( $field )
		{
			$field = wp_parse_args( $field, array(
			) );
			return $field;
		}
	}
}