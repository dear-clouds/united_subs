
/* Alberto Lau*/

;;
(function($){
	var methods = {
		init : function( options ){
			var settings = $.extend( {
				parent_field:	'parent'
			}, options);	
			return this.each(function(){
		
				var data = $(this).data('ParentChildDropdown');
				if(!data){
					parent = $(this);
					data = {};
					$(this).data('ParentChildDropdown',data);
					data.child = $(this).data('child');
					data.options = [];
					data.child_value = $(data.child).val();
					
					$(data.child).find('option').each(function(i,op){
						data.options.push({
							parent: $(op).data( (parent.data('parent_field')||settings.parent_field) ),
							value: $(op).val(),
							label: $(op).html()
						});
					});
				
					$(this).on('change', function(e){
						var data = $(this).data('ParentChildDropdown');
						parent_value = $(this).val();
						$(data.child)
							.empty()
						;

						new_child_value = '';
						$.each( data.options, function(i,op){
							if( parent_value!=op.parent ) return;
							$(data.child).append(
								$('<option></option>')
									.attr('value', op.value)
									.html( op.label )
							);
							if( op.value==data.child_value ) new_child_value = op.value;
						});
						
						if(new_child_value==''){
							new_child_value = $(data.child).find('option').attr('value');
						}
						
						$(data.child).val(new_child_value).trigger('change');
					}).trigger('change');
					
					$(data.child).on('change', function(e){
						data.child_value = $(this).val();
					});
				}
			});
		}
	};
	$.fn.ParentChildDropdown = function( method ) {
		if ( methods[method] ) {
			return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
		} else if ( typeof method === 'object' || ! method ) {
			return methods.init.apply( this, arguments );
		} else {
			$.error( 'Method ' +  method + ' does not exist on jQuery.ParentChildDropdown' );
		}    
	};
})(jQuery);		
