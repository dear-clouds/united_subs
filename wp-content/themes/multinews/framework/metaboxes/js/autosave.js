jQuery( function( $ )
{
	$( document ).ajaxSend( function( e, xhr, s )
	{
		if ( -1 != s.data.indexOf( 'action=autosave' ) )
		{
			$( '.rwmb-meta-box').each(function(){
				var $meta_box = $( this );
				if( $meta_box.data( 'autosave' ) == true )
				{
					s.data += '&' + $( ':input', $meta_box ).serialize();
				}
			} );
		}
	} );
} );
