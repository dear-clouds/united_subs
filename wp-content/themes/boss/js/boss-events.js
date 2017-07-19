(function($) {
    /*------------------------------------------------------------------------------------------------------
     Events File Upload
     --------------------------------------------------------------------------------------------------------*/
    var $file_upload = $('#event-image');

    if($file_upload.length) {
        function readURL() {
            var input = this;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#event-image-preview')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        $file_upload.wrap('<div class="event-upload-container"></div>');

        $file_upload.after('<img id="event-image-preview" src="'+ BuddyBossOptions.tpl_url +'/images/image-placeholder.png" />');

        $file_upload.on('click', function(){
            $('#event-image-preview').attr('src', BuddyBossOptions.tpl_url +'/images/image-placeholder.png' );
        });
        $file_upload.on('change', readURL );
    }
    /*------------------------------------------------------------------------------------------------------
     Responsive Table
     --------------------------------------------------------------------------------------------------------*/
    var $ths = $('#em-tickets-form .form-table th');

    $('#em-tickets-form .form-table tbody').each(function(){
        var jj = -1,
            not_first = false;
        $(this).find('td').each(function(){
            if(not_first) {
                var label = $($ths[jj]).text();
                $(this).attr( "data-th", label );
            }
            not_first = true;
            jj++;
        });
    });

    var days = BuddyBossOptions.days;
    $('.em-calendar.fullcalendar tbody tr td').each(function($index){
        $(this).children('a').attr('data-day', days[($index)%7] + ' ');
    });
    
    /*------------------------------------------------------------------------------------------------------
     Events ajax
     --------------------------------------------------------------------------------------------------------*/

    $('#events-switch-layout a').click( function( event ) {
        event.preventDefault();
        if(!$(this).hasClass('active')) {
            $.cookie( 'events_layout', $(this).attr('id') , { path: '/' } );
            $('#events-switch-layout a').removeClass('active');
            $(this).addClass('active');
            window.location.reload();
        }
    });
    
    var $eventsForm = $('#posts-filter');
    if( $eventsForm.length ) {
        $('.em-button.add-new-h2').insertBefore($eventsForm);
    }
})(jQuery);



