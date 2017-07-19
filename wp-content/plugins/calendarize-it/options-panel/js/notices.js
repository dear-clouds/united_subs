


var popns_uid = 0;
function pop_top_notification( msg, type, ttl, holder ){
jQuery(document).ready(function($){
	holder = holder||$('BODY');
	ttl = 'undefined' == typeof ttl ? 6000 : ttl;

	$('.popns-box')
		.removeClass('popns-show')
		.addClass('popns-hide')
	;
	
	$('.popns-box').trigger('pop-close');//cleanup old notices.
	
	var notice = $('<div class="popns-box popns-bar popns-effect-slidetop popns-type-notice pop-notice"><div class="popns-box-inner"><div class="popns-close"></div><span class="popnsicon"></span><div class="popns-notice"></div></div></div>');
	notice.attr('id', 'pop-notice-' + popns_uid++ );
	notice.prependTo('BODY');
	notice
		.find('.popns-notice')
			.html( msg )
		.end()
		.find('.popns-close')
			.bind('click', function(e){
				$(this).trigger('pop-close');
			})	
		.end()
		.removeClass('popns-hide')
		.addClass('popns-show')
		.addClass( 'popns-' + type )
		.bind('pop-close', function(e){	
			var _self = $(this);
			_self
				.removeClass('popns-show')
			;					
			
			setTimeout( function() {
				_self.addClass( 'popns-hide' );
				setTimeout( function() {
					//self.addClass('popns-closed');
				}, 100 );
			}, 25 );	
									
			setTimeout( function() {		
				_self.remove();
			}, 500 );	
					
			e.stopPropagation();
			return false;
		})
	;
	
	holder
		.unbind('pop-close')			
		.bind('pop-close', function(e){	
			notice.trigger('pop-close');
			e.stopPropagation();
			return false;				
		})
		.unbind('pop-open')
		.bind('pop-open', function(e){
			notice.trigger('pop-close');
			e.stopPropagation();
			return false;			
		})			
	;
	
	if( ttl > 0 ){	
		setTimeout( function() {		
			notice.trigger('pop-close');
		}, ttl );	
	}
});	
}	