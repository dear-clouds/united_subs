;;(function($) {
	var methods = {
		init: function( custom_options ){
			var timeoutId = 0;
			var mousedown = false;
			options = $.extend(true, {}, $.fn.ArrowSlider.defaults, custom_options);
			return this.each(function() {
				var id = $(this).attr('id');
				if( isNaN($(this).attr('step')) ) $(this).attr('step',1);
				if(undefined!=id){
					$(this)
						.wrap('<div class="arrow-slider-holder"/>')
						.parent()
							.append(
								$('<div class="arrow-slider-controls"></div>')
									.append($('<div class="arrow-slider-increase"></div>'))
									.append($('<div class="arrow-slider-decrease"></div>'))
							)
						;
			
					$(this).parent().find('.arrow-slider-increase')
						.mousedown(function(e){
							$("#"+id).addClass('mousedown').ArrowSlider("increase",false);
							timeoutId = setTimeout('jQuery("#'+id+'").ArrowSlider("increase",true,'+options.repeat_interval+');',options.repeat_delay);
						})
						.bind('mouseup mouseleave',function(){
							if($("#"+id).hasClass('mousedown')){
								$("#"+id).removeClass('mousedown').trigger('change');
								clearTimeout(timeoutId);			
							}	
						})
					;
			
					$(this).parent().find('.arrow-slider-decrease')
						.mousedown(function(e){
							$("#"+id).addClass('mousedown').ArrowSlider("decrease",false);
							timeoutId = setTimeout('jQuery("#'+id+'").ArrowSlider("decrease",true,'+options.repeat_interval+');',options.repeat_delay);
						})
						.bind('mouseup mouseleave',function(){
							if($("#"+id).hasClass('mousedown')){
								$("#"+id).removeClass('mousedown').trigger('change');
								clearTimeout(timeoutId);							
							}
						})
					;	
					
					$(this).change(function(){
						if(isNaN(parseFloat( $(this).val() )) )$(this).val($(this).attr('min'));
						var step = $(this).attr('step');
						var _fixed = parseInt(step)==step?0:step.split('.')[1].length;
						if( parseFloat($(this).val()) < parseFloat($(this).attr('min')) ){
							$(this).val( $(this).attr('min') );
						}else if( parseFloat($(this).val()) > parseFloat($(this).attr('max')) ){
							$(this).val( $(this).attr('max') );
						}else{
							var val = $(this).val();
							$(this).val( parseFloat(val).toFixed(_fixed) );
						}
					});
				}
			});
		},
		increase: function(repeat,repeat_interval){
			return this.each(function() {
				if( isNaN(parseFloat( $(this).val() )) )$(this).val($(this).attr('min'));
				var step = $(this).attr('step');
				var _fixed = parseInt(step)==step?0:step.split('.')[1].length;
				var val = parseFloat( $(this).val()) + parseFloat(step);				
				
				if(val<=$(this).attr('max')){
					$(this).val(val.toFixed(_fixed));
					if(repeat&& $(this).hasClass('mousedown') )setTimeout('jQuery("#'+ $(this).attr('id') +'").ArrowSlider("increase",true,'+repeat_interval+');',repeat_interval);
				}
			});
		},
		decrease: function(repeat,repeat_interval){
			return this.each(function() {
				if(isNaN(parseFloat( $(this).val() )) )$(this).val($(this).attr('max'));
				var step = $(this).attr('step');
				var _fixed = parseInt(step)==step?0:step.split('.')[1].length;
				var val = parseFloat( $(this).val()) - parseFloat($(this).attr('step'));			
				if(val>=$(this).attr('min')){
					$(this).val(val.toFixed(_fixed));
					if(repeat&& $(this).hasClass('mousedown') )setTimeout('jQuery("#'+ $(this).attr('id') +'").ArrowSlider("decrease",true,'+repeat_interval+');',repeat_interval);				
				}
			});
		}
	};

	$.fn.ArrowSlider = function( method ) {
		if ( methods[method] ) {
			return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
		}else if ( typeof method === 'object' || ! method ) {
			return methods.init.apply( this, arguments );
		}else{
			$.error( 'Method ' +  method + ' does not exist.' );
		}    
	};
	$.fn.ArrowSlider.defaults = {
		'repeat_interval':100,
		'repeat_delay':500
	};	
})(jQuery);