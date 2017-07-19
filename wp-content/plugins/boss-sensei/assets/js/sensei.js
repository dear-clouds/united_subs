(function($) {
    /* Courses */
    /*!
     * Simple jQuery Equal Heights
     *
     * Copyright (c) 2013 Matt Banks
     * Dual licensed under the MIT and GPL licenses.
     * Uses the same license as jQuery, see:
     * http://docs.jquery.com/License
     *
     * @version 1.5.1
     */
    !function(a){a.fn.equalHeights=function(){var b=0,c=a(this);return c.each(function(){var c=a(this).outerHeight();c>b&&(b=c)}),c.css("height",b)},a("[data-equal]").each(function(){var b=a(this),c=b.data("equal");b.find(c).equalHeights()})}(jQuery);
    
    // get viewport size        
    function viewport() {
        var e = window, a = 'inner';
        if (!('innerWidth' in window )) {
            a = 'client';
            e = document.documentElement || document.body;
        }
        return { width : e[ a+'Width' ] , height : e[ a+'Height' ] };
    }
            
    function equalProjects(){
        if(viewport().width > 550) {
            $('.course-flexible-area').css('height','auto');
            $('.course-flexible-area').equalHeights();
        }
    }

//    imagesLoaded( '.course-flexible-area', function( instance ) {
        equalProjects();
//    });
    
    $('#my-courses ul li a').click(function(){
        $(window).trigger('resize');
    });

    /* throttle */
    $(window).resize(function(){
        clearTimeout($.data(this, 'resizeTimer'));
        $.data(this, 'resizeTimer', setTimeout(function() {
            equalProjects();
        }, 50));
    });
    
    $('#left-menu-toggle').click(function(){
        setTimeout(function() {
            equalProjects();
        }, 550);
    });

    $(window).trigger('resize');
    
    var video_frame = $("#course-video").find('iframe'),
        video_src = video_frame.attr('src');
    
    $('#show-video').click(function(e){
        e.preventDefault();
        $('.course-header').fadeOut(200, 
        function(){
            $("#course-video").fadeIn(200);
        });
        $(this).addClass('hide');
    });
    
    $('#hide-video').click(function(e){
        e.preventDefault();
        $('#course-video').fadeOut(200, 
        function(){
            video_frame.attr('src','');
            $(".course-header").fadeIn(200, function() {
                video_frame.attr('src',video_src);
            });
        });
        $('#show-video').removeClass('hide');
    });
    
//    console.log($("#header-menu > ul"));
//        delete $.fn.jRMenuMore;
//        delete $("#header-menu > ul").jRMenuMore;
//    $("#header-menu > ul").fn.jRMenuMore = null;
    
    
     /* Quiz */
    $('#sensei-quiz-list .answers > li').click(function(){
        $(this).find('input[type=radio], input[type=checkbox]').prop("checked", function(){
            return !($(this).prop("checked"));
        }).trigger("change");
    });
    
    $('#sensei-quiz-list input[type=radio], #sensei-quiz-list input[type=checkbox]').click(function(e){
        e.stopPropagation();
    });
    
    $('#sensei-quiz-list input[type=radio], #sensei-quiz-list input[type=checkbox]').each(function(){
        var $this = $(this);
        if($this.attr('checked') == 'checked') {
            $this.parents('li').addClass('selected');
        } else {
            $this.parents('li').removeClass('selected');
        }
    }); 
    
    $('#sensei-quiz-list input').change(function(){
        if($(this).attr('type') == 'radio') {
            $(this).parents('ul').find('li').each(function(){
                $(this).removeClass('selected');
            });
            $(this).parent('li').addClass('selected');
        } else if($(this).attr('type') == 'checkbox') {
            $(this).parent('li').toggleClass('selected');
        }
    });
    
    $('#sensei-quiz-list').find('.file-upload').find('input[type="file"]').each(function(){
        $this = $(this);
        $this.wrap("<div class='fake-wrap'></div>").before('<a href="#" class="fake-upload">Choose File</a>').before('<span class="fake-link">No file chosen</span>').change(function(){
            $this.prev().text($this.val().match(/([^(\\|\/)]*)\/*$/)[1]);
        });
    });
    
    $(".fake-upload").click(function(e){
        e.preventDefault();
        $(this).next().next().trigger('click');
    });
    
    // Hidding comments
    
    if($('#comments').find('#respond').length == 0) {
        $('#comments').hide();
    }
    
    $('.course-container').prev('p').remove();
	
	
	//Ajax for contact teacher widget
	$( '.boss-edu-send-message-widget' ).on( 'click', function ( e ) {

		e.preventDefault();

		$.post( ajaxurl, {
			action: 'boss_edu_contact_teacher_ajax',
			content: $('.boss-edu-teacher-message').val(),
			sender_id: $('.boss-edu-msg-sender-id').val(),
			reciever_id: $('.boss-edu-msg-receiver-id').val(),
			course_id: $('.boss-edu-msg-course-id').val()
		},
		function(response) {
			
			if ( response.length > 0 && response != 'Failed' ) {
				$('.widget_course_teacher h3').append('<div class="sensei-message tick">Your private message has been sent.</div>');
			}
		});


	} );
    
})(jQuery)