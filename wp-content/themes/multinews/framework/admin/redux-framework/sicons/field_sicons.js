/* global redux_change, wp */

jQuery(document).ready(function ($) {


    jQuery('.redux-sicons-remove').live('click', function () {
        redux_change(jQuery(this));
        jQuery(this).parent().siblings().find('input[type="text"]').val('');
        jQuery(this).parent().siblings().find('textarea').val('');
        jQuery(this).parent().siblings().find('input[type="hidden"]').val('');

        var iconCount = jQuery(this).parents('.redux-container-sicons:first').find('.redux-sicons-accordion-group').length;

        if (iconCount > 1) {
            jQuery(this).parents('.redux-sicons-accordion-group:first').slideUp('medium', function () {
                jQuery(this).remove();
            });
        } else {
            jQuery(this).parents('.redux-sicons-accordion-group:first').find('.remove-image').click();
            jQuery(this).parents('.redux-container-sicons:first').find('.redux-sicons-accordion-group:last').find('.redux-sicons-header').text("New icon");            
        }
    });

    jQuery('input[class*="mom-color-field"]').wpColorPicker();

    jQuery('.redux-sicons-add').click(function () {
        var newicon = jQuery(this).prev().find('.redux-sicons-accordion-group:last').clone(true);
        var iconCount = jQuery(newicon).find('input[type="text"]').attr("name").match(/[0-9]+(?!.*[0-9])/);
        var iconCount1 = iconCount*1 + 1;
        //sicon
        var sicon = jQuery(newicon).find('a.select_icon').attr("data-x");
        var sicon1 = sicon*1 + 1;
       jQuery(newicon).find('a.select_icon').attr('data-x',sicon1);
       jQuery(newicon).find('.upload_custom_sicon').attr('data-x',sicon1);
       jQuery(newicon).find('.mom_icon_holder').attr('data-id',sicon1);
       jQuery(newicon).find('.icon_prv').attr('data-id',sicon1);
       jQuery(newicon).find('.icon_prv').attr('id','icon_prv_'+sicon1);
	
	
        jQuery(newicon).find('input[type="text"], input[type="hidden"], textarea').each(function(){

            jQuery(this).attr("name", jQuery(this).attr("name").replace(/[0-9]+(?!.*[0-9])/, iconCount1) ).attr("id", jQuery(this).attr("id").replace(/[0-9]+(?!.*[0-9])/, iconCount1) );
            jQuery(this).val('');
            if (jQuery(this).hasClass('icon-sort')){
                jQuery(this).val(iconCount1);
            }
        });
	 jQuery(newicon).find('.sicon-color-wrap').remove();
	 jQuery(newicon).find('.color_field_container').append('<div class="sicon-color-wrap"><input type="text" class="redux-color redux-color-init  wp-color-picker mom-color-field" id="custom_social_icons-bgcolorh_'+iconCount1+'" name="mom_options[custom_social_icons]['+iconCount1+'][bgcolorh]"></div>');
	     jQuery(newicon).find('input[class*="mom-color-field"]').wpColorPicker();

	    jQuery(newicon).find('.upload_custom_sicon').remove();
	    jQuery(newicon).find('.redux_sicons_add_remove').append('<span class="button upload_custom_sicon" id="add_'+iconCount1+'" data-x="'+iconCount1+'">Upload Icon</span>');
    var custom_uploader;

	    	jQuery(newicon).find('.upload_custom_sicon').on('click', function(e) {
 
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
            t.prev('input#selected-icon-'+t.attr('data-x')).val(attachment.url);
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
	     
        jQuery(newicon).find('.icon_prv').hide();
        jQuery(newicon).find('.screenshot').removeAttr('style');
        jQuery(newicon).find('.screenshot').addClass('hide');
        jQuery(newicon).find('.screenshot a').attr('href', '');
        jQuery(newicon).find('.remove-image').addClass('hide');
        jQuery(newicon).find('.redux-sicons-image').attr('src', '').removeAttr('id');
        jQuery(newicon).find('h3').text('').append('<span class="redux-sicons-header">New icon</span><span class="ui-accordion-header-icon ui-icon ui-icon-plus"></span>');
        jQuery(this).prev().append(newicon);
    });

    jQuery('.icon-title').keyup(function(event) {
        var newTitle = event.target.value;
        jQuery(this).parents().eq(3).find('.redux-sicons-header').text(newTitle);
    });

    jQuery(function () {
        jQuery(".redux-sicons-accordion")
            .accordion({
                header: "> div > fieldset > h3",
                collapsible: true,
                active: false,
                heightStyle: "content",
                icons: { "header": "ui-icon-plus", "activeHeader": "ui-icon-minus" }
            })
            .sortable({
                axis: "y",
                handle: "h3",
                connectWith: ".redux-sicons-accordion",
                start: function(e, ui) {
                    ui.placeholder.height(ui.item.height());
                    ui.placeholder.width(ui.item.width());
                },
                placeholder: "ui-state-highlight",
                stop: function (event, ui) {
                    // IE doesn't register the blur when sorting
                    // so trigger focusout handlers to remove .ui-state-focus
                    ui.item.children("h3").triggerHandler("focusout");
                    var inputs = jQuery('input.icon-sort');
                    inputs.each(function(idx) {
                        jQuery(this).val(idx);
                    });
                }
            });
    });

//select icons
// Load Icons

                var fID = '';
                var num = '';
                var mid = '';
                var prv = '';
	jQuery("body").on('click', '.mom_select_icon_sicon', function(e){
		var t = jQuery(this);
                fID = $(this).attr('data-id');
                num = $(this).attr('data-x');
                mid = "#selected-icon-" + num;
                prv = "#icon_prv_" + $(this).attr('data-x');
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
                                        var icon = $('input[name="mom_menu_item_icon"]:checked').val();
                                        //empty image fields
                                        $('#'+fID+'-image_id_'+num).val('');
                                        $('#'+fID+'-thumb_url_'+num).val('');
                                        $('#'+fID+'-image_url_'+num).val('');
                                        $('#'+fID+'-image_height_'+num).val('');
                                        $('#'+fID+'-image_width_'+num).val('');
                                        $('.screenshot-'+num).slideUp();
                                        $(mid).val(icon);
                                        $(prv).show();
                                        $(prv).removeClass().css('background', 'none').addClass('icon_prv '+icon);
                                        $(prv).find('.remove_icon').show();
                                            tb_remove();
                                        console.log(fID);
                                        console.log(num);
                                            return false;
                            });
			}
		});	

		return false;
	});


$('.icon_prv').each(function() {
    var $id = $(this).data('id');
    var $icon =  $(this).parent().find('#selected-icon-'+$id).val();
    
    	if ($icon.match("^http://") || $icon.match("^https://")) {
	    $(this).css({
		    background: 'url('+$icon+') center no-repeat',
		    backgroundSize: '24px'
		    
	    });
	} else {
	    $(this).addClass($icon);
	}
	
});


$('.icon_prv .remove_icon').click(function () {
    var $id = $(this).parent().data('id');
   $(this).parent().removeClass().addClass('icon_prv');
    $(this).parent().hide();
   $('#selected-icon-'+$id).val('');
   return false;
});
$('.selected_icon').each(function() {
    var $id = $(this).data('id');
    if ($(this).val() === '') {
        $('#icon_prv_'+$id).hide();
    }
});

//icons live search
    $("#filter").keyup(function(){

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
    
});