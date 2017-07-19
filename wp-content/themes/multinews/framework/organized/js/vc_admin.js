jQuery(document).ready(function($) {
   $('.vc_navbar li .wpb_edit_inline').parent().parent().addClass('pull-right');

   setTimeout(function() {
		   $('.wpb_column_container .vc_shortcodes_container:not(.vc_tta-container):not(.wpb_vc_tta_section) > .wpb_element_wrapper > .wpb_element_title').each(function() {

				var t = $(this);
				var title = t.attr('title');
				t.text('<span>'+title+'</span>');
				t.css('background', 'red');

		   });   	
   }, 500);

});