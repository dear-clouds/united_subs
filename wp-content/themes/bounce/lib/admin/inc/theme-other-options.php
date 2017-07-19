<?php 

/////////////////////////////////////// Media Fields ///////////////////////////////////////


function gp_edit_attachment($form_fields, $post) {

	global $dirname;


	// Lightbox
	
	$form_fields['ghostpool_video_url'] = array(
		"label" => __('Lightbox URL', 'gp_lang'),
		"input" => "text",
		"value" => get_post_meta($post->ID, '_ghostpool_video_url', true),
		"helps" => __('The URL of an image, video or audio file (YouTube/Vimeo/QuickTime/Flash) that loads in the lightbox.', 'gp_lang'),
	);
			
						
	return $form_fields;

}
add_filter("attachment_fields_to_edit", "gp_edit_attachment", null, 2);


function gp_save_attachment($post, $attachment) {
	
	global $dirname;
	
	
	// Lightbox URL
	
	if(isset($attachment['ghostpool_video_url'])){
		update_post_meta($post['ID'], '_ghostpool_video_url', $attachment['ghostpool_video_url']);
	}	
	
	
	return $post;
	
}
add_filter("attachment_fields_to_save", "gp_save_attachment", null , 2);


?>