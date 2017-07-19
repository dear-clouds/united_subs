function yesno_panel(o,sel){
	if(o.value==1){
		jQuery(sel).fadeIn();
	}else{
		jQuery(sel).fadeOut();
	}
}

function pop_groupcontrol(o,sel,show_values){
 	jQuery(document).ready(function($){
		if( true===pop_in_array( $(o).val() , show_values ) ){
			$(sel).slideDown();			
		}else{
			if( $(sel).is(':visible') ){$(sel).slideUp();}else{$(sel).hide();}		
		}	
	});
}
 
function pop_in_array(val,arr){
	for(var i=0;i<arr.length;i++){
		if(val===arr[i])return true;
	}
	return false;
}

jQuery(document).ready(function($){
	rh_pop_init();
});
 
function rh_pop_init(){
jQuery(document).ready(function($){
	$('.popex-save').click(function(e){
		var status = $(this).parent().find('.popex-status');
		status.html('').addClass('pop-processing');
		var args = {
			'action':'pop-save-settings-' + $('#pop_plugin_id').val(),
			'label': $(this).parent().find('.popex-label').val(),
			'group': $(this).parent().find('.popex-group').val(),
			'fields': $(this).parent().find('.popex-fields').val()
		};
		$.post(ajaxurl,args,function(data){	
			if(data.R=='OK'){
				status.html(data.MSG);
				$('.popex-list').trigger('popex_load');
			}else if(data.R=='ERR'){
				status.html(data.MSG);
			}else{
				status.html('Unexpected api response, please try again.');
			}
			status.removeClass('pop-processing');
		},'json');		
	});
	
	$('.popex-list').bind('popex_load',function(){
		var me = this;
		$(this).find('tr').stop().animate({opacity:0.25},'fast');			
		$(this).addClass('pop-processing')
			.html('<tr><td>&nbsp;</td><td>Loading...</td></tr>');
		var ts = new Date();
		var args = {
			'action':'pop-list-settings-' + $('#pop_plugin_id').val(),
			'ts':escape(ts),
			'groups': $(this).attr('rel').split(',')
		};
		
		$.post(ajaxurl,args,function(data){
			$(this).find('tr').stop().animate({opacity:1},'fast');
			if(data.R=='OK'){
				$(me).html('');
				popex_list_add_item( $(me),data.DATA);			
			}else if(data.R=='ERR'){
				$(me).html( '<tr><td colspan=3>'+data.MSG+'</td></tr>' );
			}else{
				$(me).html( '<tr><td colspan=3>'+'Unexpected error, reload page.'+'</td></tr>' );
			}
			$(me).removeClass('pop-processing');
		},'json');
	}).trigger('popex_load');
	
	$('.popex-btn-refresh').click(function(e){
		$('.popex-list').trigger('popex_load');
	});
	
	$('.pop-onoff-control button').on('click',function(e){
		$(this)
			.parent().find('button').removeClass('checked');
		$(this).addClass('checked');			
		$(this).parent().parent().find('input[type=hidden]').val( $(this).attr('value') ).trigger('change');
	});
	
	$('.pop-onoff-control input[type=hidden]').each(function(i,inp){
		var _val = $(inp).val();
		_val = _val==''?'""':_val;
		$(this).parent().find('button[value='+_val+']').trigger('click');
	});
	//--- for wp_uploader type
	$('.wp_uploader_inp').on('change',function(e){
		var _parent = $(this).parents('.pt-option-wp_uploader');
		if( '' == $(this).val() ){
			_parent.find('.pop-wp-uploader-set')
				.empty()
				.html( $(this).data('set_label') )
			;
			_parent.find('.pop-wp-uploader-unset').hide();
		}else{
			_parent.find('.pop-wp-uploader-set')
				.empty()
				.append('<img />')
				.find('img')
				.attr('src', $(this).data('preview_src') )
				.attr('width', $(this).data('preview_w') )
				.attr('height', $(this).data('preview_h') )
			;
			_parent.find('.pop-wp-uploader-unset').show();
		}
	}).trigger('change');
	$('.pop-wp-uploader-unset').on('click',function(e){
		$(this).parents('.pt-option-wp_uploader').find('.wp_uploader_inp').val('').trigger('change');
	});
	$('.pop-wp-uploader-set').on('click',function(e){
		var _target_id_field = $(this).data('target_field_id');
	    e.preventDefault();
	 
	 	modal = $(_target_id_field).data('wp_uploader_modal');
	    if ( modal ) {
	      modal.open();
	      return;
	    }

	    var _modal = wp.media.frames.rhpop = wp.media({
	      	title: jQuery( this ).data( 'modal_title' ),
	      	button: {
	        	text: jQuery( this ).data( 'modal_button' ),
	      	},
			multiple: false
	    });
	 
	    _modal.on( 'select', function() {
	    	attachment = _modal.state().get('selection').first().toJSON();
			$(_target_id_field).data('preview_src', attachment.url); 
			$(_target_id_field).val( attachment.id ).trigger('change');
	    });
	    _modal.open();
		$(_target_id_field).data('wp_uploader_modal',_modal);
	});
	//-- end wp_uploader type
	//-- handle demo button
	$('input.rh_demo').click(function(e){
		alert( $(this).data('demo_message') );
		return false;
	});
	
	$('.pop-icon-picker').PopIconPicker({});
});
}
function popex_list_add_item(body,items){
	if(items.length>0){
		jQuery(document).ready(function($){
			var o=items.shift();
			var visit_site = (undefined==o.url||o.url=='')?false:$('<span> | </span><a target="blank" href="'+o.url+'">Visit site</a>');
			var link_load = body.hasClass('with-link-load') ? $('<a>Load</a>').attr('rel',o.id).attr('href','javascript:void(0);').click(function(e){pop_load_saved_settings(o.id);}):false;
			var link_restore = body.hasClass('with-link-restore') ? $('<a>Restore</a>').attr('rel',o.id).attr('href','javascript:void(0);').click(function(e){restore_saved_setting(o.id,o.name);}):false;
			var tr = $('<tr></tr>')
				.css('opacity','0')
				.append(
					$('<td></td>')
						.addClass('dc-name')
						.append('<strong>'+o.name+'</strong>')
						.append(
							$('<div class="action-links"></div>')
								.append(link_load)
								.append(link_restore)
								.append('<span> | </span>')
								.append(
									$('<a>Delete</a>')
										.attr('rel',o.id)
										.attr('href','javascript:void(0);')
										.click(function(e){remove_saved_setting(o.id,o.name);})
								)
								.append(visit_site)
						)
				)
				.append($('<td></td>').addClass('popex-list-version').html((o.version==''?'&nbsp;':o.version)))
				.append($('<td></td>').addClass('popex-list-date').html(o.date))
				.appendTo(body)
				.animate({opacity:1},'fast','linear',function(){
					popex_list_add_item(body,items);
				});
		});
	}		
}

function pop_load_saved_settings (_index){
	jQuery(document).ready(function($){
		$('#pop-options-cont').find('form')
			.append('<input type="hidden" name="pop_preview" value="'+_index+'"/>')
			.submit();
	});
}

(function($){
	var helper_lock = false;
	function helper_click( ev, el ){
		if( helper_lock ) return;
		jQuery(document).ready(function($){
			toggle_icon_picker( el );
		});
	}
	
	function helper_mouseover( ev, el ){
		helper_lock=true;
		setTimeout( function(){helper_lock=false;}, 500 );
		if( ! $(el).parents('.pop-icon-picker').hasClass('icon-picker-open') ){
			toggle_icon_picker( el );	
		}
	}
	
	function icon_choose( ev, el ){
		var icon = $(el).data('value');
		var label = $(el).attr('title');
		$(el).parents('.pop-icon-picker').find('.pop-icon-picker-input').val( icon ).trigger('change');
		
		if( ''==icon ){
			$(el).parents('.pop-icon-picker').addClass('no-icon-chosen');
		}else{
			$(el).parents('.pop-icon-picker').removeClass('no-icon-chosen');		
		}
		
		var current_icon = $(el).parents('.icon-picker-container').find('.current-icon');
		var previous_icon = current_icon.data('value');
		current_icon
			.removeClass( previous_icon )
			.html( label )
			.data('value', icon)
			.addClass( icon )		
		;
		//--
		$(el).parents('.icon-picker-container').find('.preview-icon')
			.removeClass( previous_icon )
			.addClass( icon )
		;
		
		toggle_icon_picker( el );
	}
	
	function toggle_icon_picker( el ){
		var holder = $(el).parents('.pop-icon-picker');
		var source = holder.data('source');
		if( source && false!==source ){
			if( holder.hasClass('icon-picker-open') ){
				holder.find('.icon-picker')
					.empty()
				;
			}else{	
				holder.find('.icon-picker')
					.empty()
					.append(
						$(source).children().clone()
					)
				;
				
				holder.find('.pop-icon-item')
						.attr('href','javascript:void(0);')
						.unbind('click')
						.bind('click', function(e){
							icon_choose(e,this);
						})						
				
			}		
		}

		$(el).parents('.pop-icon-picker').toggleClass('icon-picker-open');
	}
	
	var methods = {
		init : function( options ){
			var settings = $.extend( {
				parent_field:	'parent',
				enable_mouseenter: false
			}, options);	
			return this.each(function(){
				if( !$(this).data('PopIconPicker') ){
					if( $(this).find('.icon-picker').data('source') ){
						$(this).data('source', $(this).find('.icon-picker').data('source') );
					}else{
						$(this).data('source', false);
					}	
			
					$(this).data('PopIconPicker',settings);
					$(this).find('.pop-icon-trigger')
						.attr('href','javascript:void(0);')
						.click(function(e){helper_click(e,this);})				
					;
					
					var enable_mouseenter = $(this).find('.pop-icon-picker-input').data('enable_mouseenter')||settings.enable_mouseenter;
					if( enable_mouseenter ){
						$(this).find('.pop-icon-trigger')
							.mouseenter(function(e){ helper_mouseover( e, this ); })
					}
					
					$(this).find('.pop-icon-item')
						.attr('href','javascript:void(0);')
						.click(function(e){icon_choose(e,this);})		
				}

				
			});
		}
	};
	$.fn.PopIconPicker = function( method ) {
		if ( methods[method] ) {
			return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
		} else if ( typeof method === 'object' || ! method ) {
			return methods.init.apply( this, arguments );
		} else {
			$.error( 'Method ' +  method + ' does not exist on jQuery.PopIconPicker' );
		}    
	};
})(jQuery);		