jQuery(document).ready(function($) {
    $('.mom_meta_color').wpColorPicker({
        palettes: ['#fff','#000','#78bce7', '#88d46d', '#e7be78', '#e77878', '#e778b9']
    });
    
    
//meta group Expand
$('.mmg-item .mmmg-head').on('click', function(e) {
    if (e.target === this) {
        $(this).next('.mmg-content').slideToggle(250);
        var expand = $(this).find('.edit-ad i');
        if (expand.hasClass('momizat-icon-plus')) {
            expand.removeClass().addClass('momizat-icon-minus');
        } else {
            expand.removeClass().addClass('momizat-icon-plus');
        }
    }
});

$('.mmg-item .mmmg-head .edit-ad').on('click', function(e) {
        e.preventDefault();
        $(this).parent().parent().next('.mmg-content').slideToggle(250);
        var expand = $('i', this);
        if (expand.hasClass('momizat-icon-plus')) {
            expand.removeClass().addClass('momizat-icon-minus');
        } else {
            expand.removeClass().addClass('momizat-icon-plus');
        }
});


// remove previwe image
$('.mom_preview_meta_img').each(function() {
    var img = $(this).parent().find('.mom_preview_meta_input').val();
    $(this).find('img').attr('src', img);
    if(img === '') {
        $(this).find('.mti_remove_img').hide();
    }
});

$('.mti_remove_img').click(function(e) {
    e.preventDefault();
    $(this).parent().find('img').attr('src', '');
    $(this).parent().parent().find('.mom_preview_meta_input').val('');
    $(this).parent().parent().find('.mom_full_meta_input').val('');
    $(this).hide();
});

//date input
$('.mom-metabox-date').datepicker();

}); 