/*
 * Attaches the image uploader to the input field
 */
jQuery(document).ready(function(jQuery){
 
	// Instantiates the variable that holds the media library frame.
	var meta_image_frame;
 
	// Runs when the image button is clicked.
	jQuery('#katracker_thumb_button').click(function(e){
 
		// Prevents the default action from occuring.
		e.preventDefault();
 
		// If the frame already exists, re-open it.
		if ( meta_image_frame ) {
			meta_image_frame.open();
			return;
		}
 
		// Sets up the media library frame
		meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
			title: meta_image.title,
			button: { text: meta_image.button },
			library: { type: 'image' }
		});
 
		// Runs when an image is selected.
		meta_image_frame.on('select', function(){
 
			// Grabs the attachment selection and creates a JSON representation of the model.
			var media_attachment = meta_image_frame.state().get('selection').first().toJSON();

			// Sends the attachment URL to our custom image input field.
			jQuery('#katracker_thumb').empty();
			jQuery('#katracker_thumb').val(media_attachment.id);
			jQuery('#katracker_thumb_button span').hide();
			jQuery('#katracker_edit_thumb').css('display', 'inline-block');
			jQuery('#katracker_edit_thumb').attr('href', "http://www.kateam.org/wp-admin/post.php?post=" + media_attachment.id + "&action=edit&image-editor&TB_iframe=1");
			jQuery('#katracker_remove_thumb').css('display', 'inline-block');
			jQuery('.wp-post-image').attr('src', media_attachment.url);
			jQuery('.wp-post-image').css('display', 'block');
		});
 
		// Opens the media library frame.
		meta_image_frame.open();
	});
	jQuery('#katracker_remove_thumb').click(function(e){
		jQuery('#katracker_thumb').removeAttr('value');
		jQuery('.wp-post-image').hide();
		jQuery('#katracker_thumb_button span').show();
		jQuery('#katracker_remove_thumb').hide();
		jQuery('#katracker_edit_thumb').hide();
	});
});
