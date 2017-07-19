/**
 * KLEO custom JS logic
 */


(function ( $ ) {

    $(document).ready(function() {

        /* Change VC icon elements to reflect theme shortcodes in shortcode modal*/
        $(document).on('change', '.vc_properties-list', function() {
            var myElem = $(this).find('.wpb_el_type_iconpicker');

            if ( myElem.length ) {
                myElem.find(".fip-icons-container i, .selected-icon i").each(function() {
                    kleoAdjustFontIcon(this);
                });
            }
        });

    });

    function kleoAdjustFontIcon(elem) {
        if(!$(elem).is('[class*="icon-"], [class*="vc_li-"], [class*="entypo-icon"], [class*="typcn-"], [class*="vc-oi-"], [class*="fa-"]')) {
            var className = $(elem).attr('class');
            $(elem).removeAttr('class').addClass("icon-" + className);
        }

    }

})( jQuery );