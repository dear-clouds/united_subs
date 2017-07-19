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
		
		$(this).parent().parent().find('input[type=hidden]').val( $(this).attr('value') );
	});
	
	$('.pop-onoff-control input[type=hidden]').each(function(i,inp){
		var _val = $(inp).val();
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
	var uploadID          = '';
	var storeSendToEditor = window.send_to_editor;
    var newSendToEditor   = function(html) {
		imgurl = jQuery('img',html).attr('src');
		var patt=new RegExp(/wp\-image\-([0-9]*)/gim);
		if( arr = patt.exec(html) ){
			$(uploadID).data('preview_src', imgurl); 
			$(uploadID).val( arr[1] ).trigger('change');
		}		
		tb_remove();
		window.send_to_editor = storeSendToEditor;
	};	
	
	$('.pop-wp-uploader-set').on('click',function(e){
		var _target_id_field = $(this).data('target_field_id');
	    e.preventDefault();

        window.send_to_editor = newSendToEditor;
        uploadID = _target_id_field;

        tb_show(jQuery( this ).data( 'modal_title' ), 'media-upload.php?type=image&amp;TB_iframe=true');
        return false;
	});
	//-- end wp_uploader type
});

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