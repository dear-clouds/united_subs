<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'RWMB_Media_Field' ) )
{
	class RWMB_Media_Field
	{
		/**
		 * Enqueue scripts and styles
		 *
		 * @return	void
		 */
		static function admin_enqueue_scripts( )
		{
			$url = RWMB_CSS_URL;
			wp_enqueue_style( 'momizat-media', "{$url}/media.css");
			//wp_enqueue_script( 'momizat-media', RWMB_JS_URL . 'media.js', array('jquery'), RWMB_VER, true );
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
			$val     = " value='{$meta}'";
			$for     = " for='{$field['id']}'";
			$format	 = " rel='{$field['format']}'";
			$rndn = rand(0, 100);
			
			$html .= "<script type='text/javascript'>
			jQuery(document).ready(function($){
	// media upload
	var file_frame;
	var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
	var set_to_post_id = post_id; // Set this
	$('.mom_media_meta_$rndn').live('click', function( event ){
	    var js_this = $(this);
	event.preventDefault();
	if ( file_frame ) {
	file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
	file_frame.open();
	return;
	} else {
	wp.media.model.settings.post.id = set_to_post_id;
	}
	file_frame = wp.media.frames.file_frame = wp.media({
	title: jQuery( this ).data( 'uploader_title' ),
	button: {
	text: jQuery( this ).data( 'uploader_button_text' ),
	},
	multiple: false
	});
	 
	file_frame.on( 'select', function() {
	attachment = file_frame.state().get('selection').first().toJSON();
	
		js_this.next().find('.remove_media_meta').show();
	    js_this.next('.media_meta_preview').find('input').val(attachment.url);
	    js_this.next('.media_meta_preview').find('img').attr({src: attachment.url}).addClass('mom_custom_media_prev').slideDown();

	wp.media.model.settings.post.id = wp_media_post_id;
	});
	file_frame.open();
	});
	jQuery('.mom_media_meta').on('click', function() {
	wp.media.model.settings.post.id = wp_media_post_id;
	});
	if ($('.mom_media_meta_wrap_$rndn').find('input').val() !== '') {
		$('.mom_media_meta_wrap_$rndn').find('.remove_media_meta').show();
		$('.mom_media_meta_wrap_$rndn').find('img').addClass('mom_custom_media_prev');
	}	
$('.mom_media_meta_wrap_$rndn .remove_media_meta').live('click', function() {
	$(this).siblings('img').slideUp(300);	
	$(this).siblings('input').val('');
	$(this).hide();
});
	
}); //end doc ready

			</script>";
			$html   .= '<div class="mom_media_meta_wrap mom_media_meta_wrap_'.$rndn.'">
			<a class="mom_upload_media mom_tiny_button mom_media_meta mom_media_meta_'.$rndn.'" href="#">Upload</a>
			<div class="media_meta_preview"><img src="'.$meta.'" alt=""><input type="text" '.$id.$name.$val.' style="visibility: hidden; height:0;"/><a class="remove_media_meta hide"></a></div>
		    </div>';

			return $html;

		}

		
	}
}