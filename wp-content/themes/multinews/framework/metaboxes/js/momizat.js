jQuery(document).ready(function($) {
    "use strict";
        
    //page Sidebars
    $('input[name="mom_page_layout"]').click( function() {
        if ($(this).val() === 'right-sidebar') {
            $('#mom_left_sidebar').parent().parent().slideUp();
            $('#mom_right_sidebar').parent().parent().slideDown();
        } else if ($(this).val() === 'left-sidebar') {
            $('#mom_right_sidebar').parent().parent().slideUp();
            $('#mom_left_sidebar').parent().parent().slideDown();
        } else if ($(this).val() === 'both-sidebars-all' || $(this).val() === 'both-sidebars-right' || $(this).val() === 'both-sidebars-left' || $(this).val() === '') {
            $('#mom_right_sidebar').parent().parent().slideDown();
            $('#mom_left_sidebar').parent().parent().slideDown();
        } else {
            $('#mom_right_sidebar').parent().parent().slideUp();
            $('#mom_left_sidebar').parent().parent().slideUp();
        }
    });
        if ($('input[name="mom_page_layout"]:checked').val() === 'right-sidebar') {
            $('#mom_left_sidebar').parent().parent().hide();
            $('#mom_right_sidebar').parent().parent().show();
        } else if ($('input[name="mom_page_layout"]:checked').val() === 'left-sidebar') {
            $('#mom_right_sidebar').parent().parent().hide();
            $('#mom_left_sidebar').parent().parent().show();
        } else if ($('input[name="mom_page_layout"]:checked').val() === 'both-sidebars-all' || $('input[name="mom_page_layout"]:checked').val() === 'both-sidebars-right' || $('input[name="mom_page_layout"]:checked').val() === 'both-sidebars-left' || $('input[name="mom_page_layout"]:checked').val() === '') {
            $('#mom_right_sidebar').parent().parent().show();
            $('#mom_left_sidebar').parent().parent().show();
        } else {
            $('#mom_right_sidebar').parent().parent().hide();
            $('#mom_left_sidebar').parent().parent().hide();
        }
        
	//post highlights
	    $('input[name="mom_hide_highlights"]').click( function() {
		if ($(this).attr('checked') === 'checked') {
			 $('#mom_story_highlights').fadeIn();
		} else {
			 $('#mom_story_highlights').fadeOut();
		}
	    });


	if ($('input[name="mom_hide_highlights"]').attr('checked') === 'checked') {
		$('#mom_story_highlights').show();
	} else {
		$('#mom_story_highlights').hide();
	}
	
	//post review	
	$('input[name="mom_review_post"]').click( function() {
		if ($(this).attr('checked') === 'checked') {
			 $('#mom_reviews_meta_metabox').fadeIn();
		} else {
			 $('#mom_reviews_meta_metabox').fadeOut();
		}
	    });


	if ($('input[name="mom_review_post"]').attr('checked') === 'checked') {
		$('#mom_reviews_meta_metabox').show();
	} else {
		$('#mom_reviews_meta_metabox').hide();
	}
	
	//Page templates
	$('select[name="page_template"]').change( function() {
		 if ($(this).val() === 'archive-temp.php') {
			 $('.def-temp').fadeIn(30);
			 $('.def-temp-on').fadeOut(30);
			 $('.weather-temp').fadeOut(30);
			 $('.mag-temp').fadeOut(30);
			 $('.sharep').fadeOut(30);
		 	$('.commp').fadeOut(30);
		 	$('.archives-tem').fadeIn(30);
		 	$('.media-temp').fadeOut(30);
		 	$('.timeline-temp').fadeOut(30);
			$('.authors-temp').fadeOut(30);
		 } else if ($(this).val() === 'authors-temp.php') {
			 $('.def-temp').fadeIn(30);
			 $('.def-temp-on').fadeOut(30);
			 $('.weather-temp').fadeOut(30);
			 $('.mag-temp').fadeOut(30);
			 $('.archives-tem').fadeOut(30);
			 $('.media-temp').fadeOut(30);
			 $('.timeline-temp').fadeOut(30);
			 $('.authors-temp').fadeIn(30);
		 } else if ($(this).val() === 'full-page.php') {
		 	$('.def-temp').fadeIn(30);
		 	$('.def-temp-on').fadeOut(30);
		 	$('.weather-temp').fadeOut(30);
		 	$('.mag-temp').fadeOut(30);
		 	$('.archives-tem').fadeOut(30);
		 	$('.media-temp').fadeOut(30);
		 	$('.timeline-temp').fadeOut(30);
			$('.authors-temp').fadeOut(30);
		 } else if ($(this).val() === 'magazine.php') {
		 	$('.def-temp').fadeOut(30);
		 	$('.def-temp-on').fadeOut(30);
		 	$('.weather-temp').fadeOut(30);
		 	$('.page_color').fadeOut(30);
		 	$('.mag-temp').fadeIn(30);
		 	$('.archives-tem').fadeOut(30);
		 	$('#main_settings').fadeOut(30);
		 	$('.media-temp').fadeOut(30);
		 	$('.timeline-temp').fadeOut(30);
			$('.authors-temp').fadeOut(30);
		 } else if ($(this).val() === 'media.php') {
		 	$('.def-temp').fadeIn(30);
		 	$('.def-temp-on').fadeOut(30);
		 	$('.weather-temp').fadeOut(30);
		 	$('.mag-temp').fadeOut(30);
		 	$('.sharep').fadeOut(30);
		 	$('.commp').fadeOut(30);
		 	$('.archives-tem').fadeOut(30);
		 	$('.media-temp').fadeIn(30);
		 	$('.timeline-temp').fadeOut(30);
			$('.authors-temp').fadeOut(30);
		 } else if ($(this).val() === 'weather.php') {
		 	$('.def-temp').fadeIn(30);
		 	$('.def-temp-on').fadeOut(30);
		 	$('.weather-temp').fadeIn(30);
		 	$('.mag-temp').fadeOut(30);
		 	$('.pbreadcrumb').fadeOut(30);
		 	$('.archives-tem').fadeOut(30);
		 	$('.media-temp').fadeOut(30);
		 	$('.timeline-temp').fadeOut(30);
			$('.authors-temp').fadeOut(30);
		 } else if ($(this).val() === 'timeline.php') {
		 	$('.def-temp').fadeIn(30);
		 	$('.def-temp-on').fadeOut(30);
		 	$('.weather-temp').fadeOut(30);
		 	$('.mag-temp').fadeOut(30);
		 	$('.pbreadcrumb').fadeOut(30);
		 	$('.archives-tem').fadeOut(30);
		 	$('.media-temp').fadeOut(30);
		 	$('.timeline-temp').fadeIn(30);
			$('.authors-temp').fadeOut(30);
		 }	else {
		 	 $('.def-temp-on').fadeIn(30);
			 $('.def-temp').fadeIn(30);
			 $('.weather-temp').fadeOut(30);
			 $('.mag-temp').fadeOut(30);
			 $('.archives-tem').fadeOut(30);
			 $('.media-temp').fadeOut(30);
			 $('.timeline-temp').fadeOut(30);
			 $('.authors-temp').fadeOut(30);
		 }
	});
	if ($('select[name="page_template"]').val() === 'archive-temp.php') {
			$('.def-temp').show();
			 $('.def-temp-on').hide();
			 $('.weather-temp').hide();
			 $('.mag-temp').hide();
			 $('.sharep').hide();
		 	$('.commp').hide();
		 	$('.archives-tem').show();
		 	$('.media-temp').hide();
		 	$('.timeline-temp').hide();
			$('.authors-temp').hide();
	} else if ($('select[name="page_template"]').val() === 'authors-temp.php') {
			$('.def-temp').show();
			 $('.def-temp-on').hide();
			 $('.weather-temp').hide();
			 $('.mag-temp').hide();
			 $('.archives-tem').hide();
			 $('.media-temp').hide();
			 $('.timeline-temp').hide();
			 $('.authors-temp').show();
	} else if ($('select[name="page_template"]').val() === 'full-page.php') {
			$('.def-temp').show();
		 	$('.def-temp-on').hide();
		 	$('.weather-temp').hide();
		 	$('.mag-temp').hide();
		 	$('.archives-tem').hide();
		 	$('.media-temp').hide();
		 	$('.timeline-temp').hide();
			$('.authors-temp').hide();
	} else if ($('select[name="page_template"]').val() === 'magazine.php') {
			$('.def-temp').hide();
			$('.def-temp-on').hide();
			$('.weather-temp').hide();
		 	$('.page_color').hide();
			$('.mag-temp').show();
			$('.archives-tem').hide();
			$('#main_settings').hide();
			$('.media-temp').hide();
			$('.timeline-temp').hide();
			$('.authors-temp').hide();
	} else if ($('select[name="page_template"]').val() === 'media.php') {
			$('.def-temp').show();
			$('.def-temp-on').hide();
			$('.weather-temp').hide();
			$('.mag-temp').hide();
			$('.sharep').hide();
		 	$('.commp').hide();
		 	$('.archives-tem').hide();
		 	$('.media-temp').show();
		 	$('.timeline-temp').hide();
			$('.authors-temp').hide();
	} else if ($('select[name="page_template"]').val() === 'weather.php') {
			$('.def-temp').show();
			$('.def-temp-on').hide();
			$('.weather-temp').show();
			$('.mag-temp').hide();
			$('.pbreadcrumb').hide();
			$('.archives-tem').hide();
			$('.media-temp').hide();
			$('.timeline-temp').hide();
			$('.authors-temp').hide();
	} else if ($('select[name="page_template"]').val() === 'timeline.php') {
			$('.def-temp').show();
			$('.def-temp-on').hide();
			$('.weather-temp').hide();
			$('.mag-temp').hide();
			$('.pbreadcrumb').hide();
			$('.archives-tem').hide();
			$('.media-temp').hide();
			$('.timeline-temp').show();
			$('.authors-temp').hide();
	} else {
			$('.def-temp').show();
			$('.def-temp-on').show();
			$('.weather-temp').hide();
			$('.mag-temp').hide();
			$('.archives-tem').hide();
			$('.media-temp').hide();
			$('.timeline-temp').hide();
			$('.authors-temp').hide();
	}
	
	//Magazine Page
	$('select[name="mom_mag_display"]').change( function() {
		 if ($(this).val() === 'cat') {
		 	$('.mag-cat').slideDown();
		 	$('.mag-ex').slideUp();
		 } else {
			$('.mag-cat').slideUp();
			$('.mag-ex').slideDown();
		 }
	});
	if ($('select[name="mom_mag_display"]').val() === 'cat') {
			$('.mag-cat').show();
			$('.mag-ex').hide();
	} else {
			$('.mag-cat').hide();
			$('.mag-ex').show();
	}
	//Timeline Page
	$('select[name="mom_timeline_display"]').change( function() {
		 if ($(this).val() === 'cat') {
		 	$('.tl-cat').slideDown();
		 	$('.tl-ecat').slideUp();
		 } else {
			$('.tl-cat').slideUp();
			$('.tl-ecat').slideDown();
		 }
	});
	if ($('select[name="mom_timeline_display"]').val() === 'cat') {
			$('.tl-cat').show();
			$('.tl-ecat').hide();
	} else {
			$('.tl-cat').hide();
			$('.tl-ecat').show();
	}
	//Media Page
	$('select[name="mom_media_display"]').change( function() {
		 if ($(this).val() === 'cat') {
		 	$('.media-cat').slideDown();
		 } else {
			$('.media-cat').slideUp();
		 }
	});
	if ($('select[name="mom_media_display"]').val() === 'cat') {
			$('.media-cat').show();
	} else {
			$('.media-cat').hide();
	}
});