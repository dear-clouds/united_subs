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
    
    $(document).ready(function(){
        
        //    imagesLoaded( '.course-flexible-area', function( instance ) {
        equalProjects();
        //    });

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
    });
    
    /* Course Progress */
//    $.fn.removeComplete = function(){
//        var text = $(this).text(),
//            lastIndex = text.lastIndexOf(" ");
//        $(this).text(text.substring(0, lastIndex));
//    }
//    $(document).ready(function(){
//        $('.course_progress_blue').each(function(){
//            var $this = $(this),
//                style = $this.attr('style');
//            $this.parents('.course_progress').next('.right').attr('style', style).removeComplete();
//        });
//    });
//    
//    
//    $('#learndash_profile').find('.expand_collapse').insertBefore('#course_list');
    
    /* Quiz */
    $('.wpProQuiz_questionInput[type=radio], .wpProQuiz_questionInput[type=checkbox]').each(function(){
        var $this = $(this);
        if($this.attr('checked') == true) {
            $this.parents('label').addClass('selected');
        } else {
            $this.parents('label').removeClass('selected');
        }
    }); 
    
    $('.wpProQuiz_questionInput').change(function(){
        if($(this).attr('type') == 'radio') {
            $(this).parents('.wpProQuiz_questionList').find('.wpProQuiz_questionListItem').each(function(){
                $(this).find('label').removeClass('selected');
            });
            $(this).parent('label').addClass('selected');
        } else if($(this).attr('type') == 'checkbox') {
            $(this).parent('label').toggleClass('selected');
        }
    });
    
    $('.drop-list').click(function(){
        var $parent = $(this).parents('.has-topics');
        $parent.find('.learndash_topic_dots').slideToggle();
        $parent.toggleClass('expanded');
    });
    
})(jQuery)