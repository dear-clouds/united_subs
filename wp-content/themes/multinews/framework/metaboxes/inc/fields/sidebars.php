<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( !class_exists( 'RWMB_Sidebars_Field' ) )
{
	class RWMB_Sidebars_Field
	{
		/**
		 * Enqueue scripts and styles
		 *
		 * @return void
		 */
		static function admin_enqueue_scripts()
		{
			wp_enqueue_style( 'rwmb-select', RWMB_CSS_URL . 'select.css', array(), RWMB_VER );
		}

		/**
		 * Get field HTML
		 *
		 * @param string $html
		 * @param mixed  $meta
		 * @param array  $field
		 *
		 * @return string
		 */
		/*	<select>
<?php foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) { ?>
     <option value="<?php echo ucwords( $sidebar['id'] ); ?>">
              <?php echo ucwords( $sidebar['name'] ); ?>
     </option>
<?php } ?>
</select> */
		static function html( $html, $meta, $field )
		{
				$html = sprintf(
				'<select class="rwmb-select" name="%s" id="%s"%s>',
				$field['field_name'],
				$field['id'],
				$field['multiple'] ? ' multiple="multiple"' : ''
			);

			$option = '<option value="%s" %s>%s</option>';

			$html .= '<option value=""></option>';
			foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) {
					$html .= sprintf(
						$option,
						$sidebar['id'],
						/*  selected( in_array( $value, $meta ), true, false ),*/
						selected( in_array( $sidebar['id'], (array)$meta ), true, false ),
						$sidebar['name']
					);
			}

			if (is_array(get_option('mom_custom_sidebars')) && get_option('mom_custom_sidebars') != '') {
				foreach ( get_option('mom_custom_sidebars') as $key => $sidebar ) {
						$html .= sprintf(
							$option,
							$key,
							/*  selected( in_array( $value, $meta ), true, false ),*/
							selected( in_array( $key, (array)$meta ), true, false ),
							$sidebar
						);
				} 
			}
						 
			$html .= '</select>';

			return $html;
		}

		/**
		 * Get meta value
		 * If field is cloneable, value is saved as a single entry in DB
		 * Otherwise value is saved as multiple entries (for backward compatibility)
		 *
		 * @see "save" method for better understanding
		 *
		 * TODO: A good way to ALWAYS save values in single entry in DB, while maintaining backward compatibility
		 *
		 * @param $meta
		 * @param $post_id
		 * @param $saved
		 * @param $field
		 *
		 * @return array
		 */
		static function meta( $meta, $post_id, $saved, $field )
		{
			$single = $field['clone'] || !$field['multiple'];
			$meta = get_post_meta( $post_id, $field['id'], $single );
			$meta = ( !$saved && '' === $meta || array() === $meta ) ? $field['std'] : $meta;

			$meta = array_map( 'esc_attr', (array) $meta );

			return $meta;
		}

		/**
		 * Save meta value
		 * If field is cloneable, value is saved as a single entry in DB
		 * Otherwise value is saved as multiple entries (for backward compatibility)
		 *
		 * TODO: A good way to ALWAYS save values in single entry in DB, while maintaining backward compatibility
		 *
		 * @param $new
		 * @param $old
		 * @param $post_id
		 * @param $field
		 */
		static function save( $new, $old, $post_id, $field )
		{
			if ( !$field['clone'] )
			{
				RW_Meta_Box::save( $new, $old, $post_id, $field );
				return;
			}

			if ( empty( $new ) )
				delete_post_meta( $post_id, $field['id'] );
			else
				update_post_meta( $post_id, $field['id'], $new );
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
			$field['field_name'] = $field['id'];
			if ( !$field['clone'] && $field['multiple'] )
				$field['field_name'] .= '[]';
			return $field;
		}
	}
}