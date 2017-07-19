jQuery(document).ready(function($) {
    "use strict";
    $('#post-formats-select input[name="post_format"]').change( function() {
        var val = $(this).val();
       if ( val === 'gallery') {
            $('#mom_posts_extra_metabox .posts_extra_item').fadeOut();
            $('#mom_posts_extra_metabox .pt_slider_meta').fadeIn();
       } else if (val === 'video') {
            $('#mom_posts_extra_metabox .posts_extra_item').fadeOut();
            $('#mom_posts_extra_metabox .pt_video_url').fadeIn();
       }  else if (val === 'audio') {
            $('#mom_posts_extra_metabox .posts_extra_item').fadeOut();
            $('#mom_posts_extra_metabox .pt_audio_st').fadeIn();
       } else if (val === 'aside') {
            $('#mom_posts_extra_metabox .posts_extra_item').fadeOut();
            $('#mom_posts_extra_metabox .pt_aside_st').fadeIn();
       } else if (val === 'status') {
            $('#mom_posts_extra_metabox .posts_extra_item').fadeOut();
            $('#mom_posts_extra_metabox .pt_status_st').fadeIn();
       } else if (val === 'link') {
            $('#mom_posts_extra_metabox .posts_extra_item').fadeOut();
            $('#mom_posts_extra_metabox .pt_link_st').fadeIn();
       } else if (val === 'chat') {
            $('#mom_posts_extra_metabox .posts_extra_item').fadeOut();
            $('#mom_posts_extra_metabox .pt_chat_st').fadeIn();
       } else {
            $('#mom_posts_extra_metabox .posts_extra_item').fadeOut();
            $('#mom_posts_extra_metabox .posts_extra_empty').fadeIn();
       }
       if ( val === 'gallery') {
        $('#flex_settings').fadeIn();
       } else {
        $('#flex_settings').fadeOut();
       }
    });
    var val = $('#post-formats-select input[name="post_format"]:checked').val();
       if ( val === 'gallery') {
            $('#mom_posts_extra_metabox .posts_extra_item').fadeOut();
            $('#mom_posts_extra_metabox .pt_slider_meta').fadeIn();
       } else if (val === 'video') {
            $('#mom_posts_extra_metabox .posts_extra_item').fadeOut();
            $('#mom_posts_extra_metabox .pt_video_url').fadeIn();
       }  else if (val === 'audio') {
            $('#mom_posts_extra_metabox .posts_extra_item').fadeOut();
            $('#mom_posts_extra_metabox .pt_audio_st').fadeIn();
       } else if (val === 'aside') {
            $('#mom_posts_extra_metabox .posts_extra_item').fadeOut();
            $('#mom_posts_extra_metabox .pt_aside_st').fadeIn();
       } else if (val === 'status') {
            $('#mom_posts_extra_metabox .posts_extra_item').fadeOut();
            $('#mom_posts_extra_metabox .pt_status_st').fadeIn();
       } else if (val === 'link') {
            $('#mom_posts_extra_metabox .posts_extra_item').fadeOut();
            $('#mom_posts_extra_metabox .pt_link_st').fadeIn();
       } else if (val === 'chat') {
            $('#mom_posts_extra_metabox .posts_extra_item').fadeOut();
            $('#mom_posts_extra_metabox .pt_chat_st').fadeIn();
       } else {
            $('#mom_posts_extra_metabox .posts_extra_item').fadeOut();
            $('#mom_posts_extra_metabox .posts_extra_empty').fadeIn();
       }
       
       if ( val === 'gallery') {
        $('#flex_settings').fadeIn();
       } else {
        $('#flex_settings').fadeOut();
       }


    $('select[name="mom_posts_extra[video_type]"]').change( function() {
        var val = $(this).val();
       if ( val === 'html5') {
        $('.html5_video').fadeIn();
        $('.external_video').fadeOut();
       } else {
        $('.external_video').fadeIn();
        $('.html5_video').fadeOut();
        
       }
    });

    var val_v = $('select[name="mom_posts_extra[video_type]"]').val();
       if ( val_v === 'html5') {
        $('.html5_video').fadeIn();
        $('.external_video').fadeOut();
       } else {
        $('div.external_video').fadeIn();
        $('.html5_video').fadeOut();
        
       }
    
// audio
    $('select[name="mom_posts_extra[audio_type]"]').change( function() {
        var val = $(this).val();
       if ( val === 'html5') {
        $('.html5_audio').fadeIn();
        $('.external_audio').fadeOut();
       } else {
        $('.external_audio').fadeIn();
        $('.html5_audio').fadeOut();
        
       }
    });

    var val_v = $('select[name="mom_posts_extra[audio_type]"]').val();
       if ( val_v === 'html5') {
        $('.html5_audio').fadeIn();
        $('.external_audio').fadeOut();
       } else {
        $('div.external_audio').fadeIn();
        $('.html5_audio').fadeOut();
        
       }
       
//Color Picker field
    //$('.mom-color-field').wpColorPicker();
	
});
