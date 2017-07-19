jQuery(document).ready(function($){
        jQuery(".widget_momizattabber").each(function(){
        var ul = jQuery(this).find(".main_tabs ul.widget-tabbed-header");

        jQuery(this).find(".widget-tab").each(function() {
            jQuery(this).find('a.mom-tw-title').wrap('<li></li>').parent().detach().appendTo(ul);
        });
    });
});