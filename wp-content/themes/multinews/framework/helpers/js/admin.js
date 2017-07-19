//Set up the color pickers to work with our text input field
jQuery( document ).ready(function($){
// modal box
jQuery("body").on('click','.mom_media_box_overlay', function() {
    $('.mom_modal_box').fadeOut();
    $('.mom_media_box_overlay').fadeOut();
});

jQuery("body").on('click','#mom_modal_close', function() {
    $('.mom_modal_box').fadeOut();
    $('.mom_media_box_overlay').fadeOut();
});

jQuery("body").on('click','.mom_modal_save', function(e) {
    e.preventDefault(); 
    $('.mom_modal_box').fadeOut();
    $('.mom_media_box_overlay').fadeOut();
});

// Load Icons 
	jQuery("body").on('click', '.mom_select_icon', function(e){
		var t = jQuery(this);
                        $('.mom_modal_box').fadeIn();
                        $('.mom_media_box_overlay').fadeIn();
			jQuery.ajax({
			type: "post",
			url: MomCats.url,
                        dataType: 'html',
                        data: "action=mom_loadIcon&nonce="+MomCats.nonce,
			beforeSend: function() {
			},
			success: function(data){
                            $('.mom_modal_box').find('.mom_modal_content').html(data);
                            jQuery("body").on('click','.mom_modal_save', function(e) {
                                var icon = $('.mom_modal_box').find('input[name="mom_menu_item_icon"]:checked').val();
                                t.parent('.mom_icons_selector').find('.mom_icon_holder').val(icon);
                                t.parent('.mom_icons_selector').find('.mom_icon_prev i').removeClass().addClass(icon);
				t.parent('.mom_icons_selector').find('.mom_icon_prev').css('background', 'none');
                            });
			}
		});	

		return false;
	});
	
	var custom_uploader;
	jQuery(".mom_upload_icon").on('click', function(e){
            var t = jQuery(this);
          
        e.preventDefault();
 
        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
             t.parent('.mom_icons_selector').find('.mom_icon_holder').val(attachment.url);
                t.parent('.mom_icons_selector').find('.mom_icon_prev i').removeClass().parent().css({
		    background: 'url('+attachment.url+') center no-repeat',
		    backgroundSize: '24px'
		    
		});
        });
    });
    
// Load Menu Icons
// Thanks to Hamdan for function idea 
    jQuery.select_icon_Function = function() {
        var idm = '';
        var iconm = '';
        jQuery(".mom_select_icon_menu").on('click', function(e){
            var t = jQuery(this);
            idm = t.data('id');
            $('.mom_modal_box').fadeIn();
            $('.mom_media_box_overlay').fadeIn();
            
            jQuery.ajax({
                type: "post",
                url: MomCats.url,
                    dataType: 'html',
                    data: "action=mom_loadIcon&nonce="+MomCats.nonce,
                beforeSend: function() {
                },
                success: function(data){
                    $('.mom_modal_box').find('.mom_modal_content').html(data);
    
                },
            });
            
            jQuery("body").on('click','.mom_modal_save', function(e) {
                iconm = $('.mom_modal_box').find('input[name="mom_menu_item_icon"]:checked').val();
                $('#menu-item-settings-'+idm+' .mom_icons_selector').find('.mom_icon_holder').val(iconm);
                $('#menu-item-settings-'+idm+' .mom_icons_selector').find('.mom_icon_prev i').removeClass().addClass(iconm);
                $('#menu-item-settings-'+idm+' .mom_icons_selector').find('.mom_icon_prev').css('background', 'none');
		
            });    
                
            return false;
        });
    };
    jQuery.custom_icon_Function = function() {
        var idm = '';
        var iconm = '';
	var custom_uploader;
        jQuery(".mom_upload_icon_menu").on('click', function(e){
            var t = jQuery(this);
            idm = t.data('id');
            
          
        e.preventDefault();
 
        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
             $('#menu-item-settings-'+idm+' .mom_icons_selector').find('.mom_icon_holder').val(attachment.url);
                $('#menu-item-settings-'+idm+' .mom_icons_selector').find('.mom_icon_prev i').removeClass().parent().css({
		    background: 'url('+attachment.url+') center no-repeat',
		    backgroundSize: '24px'
		    
		});
        });
        //Open the uploader dialog
        custom_uploader.open();
	
        });
    };    
    $.select_icon_Function();
    $.custom_icon_Function();
    
    
    $(document).on('click mouseover', '.mom_select_icon_menu', function(){        
        if ( $.isFunction($.select_icon_Function)) { 
            $.select_icon_Function();
        }                
    });
    
    
//Icon slect 
    $('.mom_icons_selector').each(function () {
	var icon = $(this).find('.mom_icon_holder').val();
	if (icon.match("^http://") || icon.match("^https://")) {
	    $(this).find('.mom_icon_prev').css({
		    background: 'url('+icon+') center no-repeat',
		    backgroundSize: '24px'
		    
	    });
	} else {
	    $(this).find('.mom_icon_prev i').addClass(icon);
	}
    }); 

    $('.mom_icon_prev').on('click', '.remove_icon', function(e) {
	e.preventDefault();
	$(this).parent().parent('.mom_icons_selector').find('.mom_icon_holder').val('');
	$(this).parent().find('i').removeClass();
	$(this).parent().css('background', 'none');
    });
    
//icon live search
    $("body").on('keyup', '#mom_icons_filter', function(){

        // Retrieve the input field text and reset the count to zero
        var filter = $(this).val(), count = 0;


        var regex = new RegExp(filter, "i"); // Create a regex variable outside the loop statement

        // Loop through the icons
        $(".icons_wrap .mom_tiny_icon").each(function(){
            var classname = $('i', this).attr('class');
            // If the list item does not contain the text phrase fade it out
            if (classname.search(regex) < 0) { // use the variable here
                $(this).hide();

            // Show the list item if the phrase matches and increase the count by 1
            } else {
                $(this).fadeIn();
                count++;
            }
        });

    });
    
//upload image    
    var custom_uploader;
    $('#user_meta_image_button').click(function(e) {
 
        e.preventDefault();
 
        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            $('#user_meta_image').val(attachment.url);
        });
        //Open the uploader dialog
        custom_uploader.open();
    });
//upload custom icon for options 
    var custom_uploader;
    $('.upload_custom_icon').click(function(e) {
 
        e.preventDefault();
    var t = $(this);
 
        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            t.prev('input').val(attachment.url);
        prv = "#icon_prv_" + t.attr('data-x');
        $(prv).show();
        $(prv).removeClass().addClass('icon_prv').css({
            background: 'url('+attachment.url+') center no-repeat',
            backgroundSize: '24px'
            
        });
        $(prv).find('.remove_icon').show();
        

        });
        //Open the uploader dialog
        custom_uploader.open();
    });
var custom_uploader;
    $('.upload_custom_sicon').click(function(e) {
 
        e.preventDefault();
    var t = $(this);
 
        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            t.prev('input').val(attachment.url);
        prv = "#icon_prv_" + t.attr('data-x');
        $(prv).show();
        $(prv).removeClass().addClass('icon_prv').css({
            background: 'url('+attachment.url+') center no-repeat',
            backgroundSize: '24px'
            
        });
        $(prv).find('.remove_icon').show();
        

        });
        //Open the uploader dialog
        custom_uploader.open();
    });
});