jQuery(document).ready(function($){
	// media upload
	var file_frame;
	var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
	var set_to_post_id = post_id; // Set this
	$('.mom_media_meta').live('click', function( event ){
	    var $this = $(this);
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
	
		$this.next().find('.remove_media_meta').show();
	    $this.next('.media_meta_preview').find('input').val(attachment.url);
	    $this.next('.media_meta_preview').find('img').attr({src: attachment.url}).addClass('mom_custom_media_prev').slideDown();

	wp.media.model.settings.post.id = wp_media_post_id;
	});
	file_frame.open();
	});
	jQuery('.mom_media_meta').on('click', function() {
	wp.media.model.settings.post.id = wp_media_post_id;
	});
$('.mom_media_meta_wrap').each( function() {
	$this = $(this);
	if ($(this).find('input').val() !== '') {
		$this.find('.remove_media_meta').show();
		$this.find('img').addClass('mom_custom_media_prev');
	}	
});
$('.remove_media_meta').live('click', function() {
	$(this).siblings('img').slideUp(300);	
	$(this).siblings('input').val('');
	$(this).remove();
});
	
}); //end doc ready
