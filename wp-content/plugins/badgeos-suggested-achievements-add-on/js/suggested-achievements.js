jQuery( function( $ ) {

    // Listen for clicks to the join button
    $( 'body' ).on( 'click', '.skip-achievement', function() {

        var achievement_id = $(this).attr("achievement_id");

        // If no code provided, bail
        if ( !achievement_id ) {
            return;
        }
        // Run our ajax request
        $.ajax( {
            url : ajaxurl,
            data : {
                'action' : 'suggested_achievements_skip_ajax',
                'achievement_id' : achievement_id
            },
            dataType : 'json',
            async : false,
            success : function( response ) {
                if(response.data.redirect_url){
                    window.location = response.data.redirect_url;
                }
            },
            error : function() {

                alert( 'There was an issue requesting membership, please contact your site administrator' );

            }
        } );
    } );
} );
