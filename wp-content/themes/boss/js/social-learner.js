;( function( $, window, document, undefined ) {
    
    var $window = $(window),
        $document = $(document);
    
    $document.ready(function(){
        

        /*--------------------------------------------------------------------------------------------------------
        1.1 - Search
        --------------------------------------------------------------------------------------------------------*/
        
        var $search_form = $('#titlebar-search').find('form');
        
        $('#search-open').click(function(e){
            e.preventDefault();
            $search_form.fadeIn();
            setTimeout(function(){
                $search_form.find('#s').focus();
            }, 301);
        });  
        
        $('#search-close').click(function(e){
            e.preventDefault();
            $search_form.fadeOut();
        });
        
        $(document).click(function (e)
        {
            var container = $("#titlebar-search");

            if (!container.is(e.target) // if the target of the click isn't the container...
                && container.has(e.target).length === 0) // ... nor a descendant of the container
            {
                $search_form.fadeOut();
            }
        });
        
        if($('body').hasClass('left-menu-open')){
            $('.right-col').addClass('hide');
        }

        $('#left-menu-toggle').click(function(e){
            e.preventDefault();
            if($('body').hasClass('left-menu-open')){
                setTimeout(function(){
                    $('.right-col').toggleClass('hide');
                }, 500);    
            } else {
                $('.right-col').toggleClass('hide');
            }
        });
        
        /*--------------------------------------------------------------------------------------------------------
        1.2 - Site title
        --------------------------------------------------------------------------------------------------------*/     
        $(".site-title a, .mobile-site-title").html(function(index, curHTML) {
            if(!$(this).has('img')) {
                curHTML = curHTML.trim();
                var text = curHTML.split(/[\s-]/),
                    newtext = '<span class="colored">' + text.pop() + '</span>';
                return text.join(' ').concat(' ' + newtext);
            }
         }); 
        
    });
}( jQuery, document, window ) );