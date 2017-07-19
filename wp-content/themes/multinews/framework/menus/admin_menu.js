jQuery(document).ready( function($) {
    /*
     *$('.field-mega-menu select').each(function() {
        $(this).change(function() {
           if ($(this).val() === 'mega') {
                $(this).parent().parent().parent().nextUntil('.menu-item-depth-0').find('span.item-type').text('Column');
                console.log('mega');
            } else {
                $(this).parent().parent().parent().nextUntil('.menu-item-depth-0').find('span.item-type').text('Custom');
            }
        });
        
    });
    */

$('.menu_icon_bt').on('click',function() {
    mid = "#edit-menu-item-micon-" + $(this).attr('data-id');
    prv = "#icon_prv_" + $(this).attr('data-id');
    $('#mom_menu_icon').on('click',function() {
        var icon = $('input[name="mom_menu_item_icon"]:checked').val();
        $(mid).val(icon);
        $(prv).removeClass().addClass('icon_prv '+icon);
        $(prv).find('.remove_icon').show();
            tb_remove();
            return false;
    });
});
$('.icon_prv').each(function() {
    $(this).addClass($(this).next('input').val());
});

$('.icon_prv .remove_icon').click(function () {
    $(this).hide();
   $(this).parent().removeClass().addClass('icon_prv');
   $(this).parent().next('input').val('');
   return false;
});
$('.edit-menu-item-micon').each(function() {
    if ($(this).val() === '') {
        $(this).prev('.icon_prv').find('.remove_icon').hide();
    }
});

$('.edit-menu-item-mtype').on('change', function() {
    var t = $(this);
    var id = $(this).attr('id');
    id = id.split('-');
    if ($(this).val() === 'cats') {
        $(this).parent().parent().parent().find('.field-mcats_layout').slideDown(250);
        $(this).parent().parent().parent().find('.field-mcustom').slideUp('fast');
    } else if ($(this).val() === 'custom') {
        $(this).parent().parent().parent().find('.field-mcustom').slideDown(250);
        $(this).parent().parent().parent().find('.field-mcats_layout').slideUp('fast');
    } else {
        $(this).parent().parent().parent().find('.field-mcustom').slideUp('fast');
        $(this).parent().parent().parent().find('.field-mcats_layout').slideUp('fast');
    }
});

$('.edit-menu-item-mtype').each(function() {
    if ($(this).val() === 'cats') {
        $(this).parent().parent().parent().find('.field-mcats_layout').slideDown(250);
        $(this).parent().parent().parent().find('.field-mcustom').slideUp('fast');
    } else if ($(this).val() === 'custom') {
        $(this).parent().parent().parent().find('.field-mcustom').slideDown(250);
        $(this).parent().parent().parent().find('.field-mcats_layout').slideUp('fast');
    } else {
        $(this).parent().parent().parent().find('.field-mcustom').slideUp('fast');
        $(this).parent().parent().parent().find('.field-mcats_layout').slideUp('fast');
    }
});
//Color Picker field
    $('.mom-color-field').wpColorPicker();
    
    $('*').on('click', function(){
        $('#menu-to-edit li').find(".mom-color-field").not('.wp-color-picker').wpColorPicker();        
    });
    
//icon live search
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

$('.nav_menu_logged_in_out_field').each(function(i){ 

    var $field = $(this);

    var id = $field.find('input.nav-menu-id').val();

    // if set to display by role (aka is null) then show the roles list, otherwise hide
    if( $field.find('input.nav-menu-logged-in-out:checked').val() === 'in' ){
        $field.next('.nav_menu_role_field').show();
    } else {
        $field.next('.nav_menu_role_field').hide();
    }
});

// on in/out/role change, hide/show the roles
$('#menu-to-edit').on('change', 'input.nav-menu-logged-in-out', function() {
    if( $(this).val() === 'in' ){
        $(this).parentsUntil('.nav_menu_logged_in_out').next('.nav_menu_role_field').slideDown();
    } else {
        $(this).parentsUntil('.nav_menu_logged_in_out').next('.nav_menu_role_field').slideUp();
    }
});

});