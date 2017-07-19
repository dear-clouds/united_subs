/*
 * Attaches the image uploader to the input field
 */
jQuery(document).ready(function(jQuery){

	// Instantiates the variable that holds the media library frame.
	var meta_image_frame;

	// Runs when the image button is clicked.
	jQuery('#katracker_torrent_button').click(function(e){

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
			library: { type: 'torrent' },
			multiple: true
		});

		// Runs when an image is selected.
		meta_image_frame.on('select', function(){

			// Grabs the attachment selection and creates a JSON representation of the model.
			var media_attachment = meta_image_frame.state().get('selection').toArray();

			// For each torrent in the selection,
			for ( i=0; i < media_attachment.length; i++ ) {
				var shortcode = '[torrent id="' + media_attachment[i].id + '"' +
					( media_attachment[i].attributes.title.length !== 0 ? (' title="' + media_attachment[i].attributes.title + '"') : '' ) + ']';
				wp.media.editor.insert(shortcode);
			}

		});

		// Opens the media library frame.
		meta_image_frame.open();
	});
});
