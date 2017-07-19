<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'RWMB_Range2_Field' ) )
{
	class RWMB_Range2_Field
	{
		/**
		 * Enqueue scripts and styles
		 *
		 * @return	void
		 */
		static function admin_enqueue_scripts( )
		{
			$url = RWMB_CSS_URL;
			wp_enqueue_script('jquery-ui-slider');
			wp_enqueue_style( 'range2', "{$url}/range2.css");
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
		static function html( $html, $meta, $field )
		{
			$id	     = " id='{$field['id']}'";
			$name	 = "name='{$field['field_name']}'";
			$rndn = rand(0,50);
			if (isset($field['min'])) {
			$min	 = $field['min'];
			}

			if (isset($field['max'])) {
			$max	 = $field['max'];
			}

			if (isset($field['step'])) {
			$step	 = $field['step'];
			}

			if (isset($field['suffix'])) {
			$suffix = '<span class="suffix">'. $field['suffix'] .'</span><br><br>';
			}

			$val     = " value='{$meta}'";
			$for     = " for='{$field['id']}'";
			$format	 = " rel='{$field['format']}'";
			
			$html   .= "
			<script type='text/javascript'>
			jQuery(document).ready(function($) {
				$('.mrs_{$rndn}').slider({
				range: 'min',
				value: {$val},
				step: {$step},
				min: {$min},
				max: {$max},
				slide: function( event, ui ) {
				    $( '.mr_{$rndn}' ).val(ui.value );
				}        
				});
				
				$('.mr_{$rndn}').change(function () {
				var value = this.value.substring(1);
				console.log(value);
				$('.mrs_{$rndn}').slider('value', parseInt(value));
				});
			    
			    });
			</script>
				<div class='clearfix'>
				<div class='mom_range_wrap'>
					<div class='mom_range_slider mrs_{$rndn}'></div>
					<input type='text' class='rwmb-range mom_range mr_{$rndn}'{$format}{$id}{$name}{$val}> $suffix
				</div>
				</div>";

			return $html;

		}

		
	}
}