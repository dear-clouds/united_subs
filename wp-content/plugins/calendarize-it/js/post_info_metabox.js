jQuery(document).ready(function($){
	$('#post_extrainfo_type').on('change',function(e){ 
		var p = $(this).parents('.post_extrainfo_control');
		p.find('.post_extrainfo_type-cell').hide();
		p.find('.post_extrainfo_type-'+$(this).val()).fadeIn();
		
		if($(this).val()=='taxonomy'){$('#post_extrainfo_taxonomy').trigger('change');}
		if($(this).val()=='taxonomymeta'){$('#post_extrainfo_taxonomymeta').trigger('change');}
		if($(this).val()=='postmeta'){$('#post_extrainfo_postmeta').trigger('change');}
	}).trigger('change');
	
	$('#post_extrainfo_add').on('post_extrainfo',function(e){
		if( $(this).data('post_extrainfo') ){
			$(this).attr('value', $(this).data('save_label') );
		}else{
			$(this).attr('value', $(this).data('add_label') );
		}
	});
	
	$('#post_extrainfo_add').on('click',function(e){
		var _taxonomymeta = '';
		var _taxonomymeta_field = '';
		var arr = $('#post_extrainfo_taxonomymeta').val().split('|');
		if(arr.length==2){
			_taxonomymeta_field = arr[0];
			_taxonomymeta = arr[1];
		}
		var _type=$('#post_extrainfo_type').val();
		var o = {
			'type': _type,
			'span': $('#post_extrainfo_span').val(),
			'column': 0,
			'label': $('#post_extrainfo_label').val(),
			'class': $('#post_extrainfo_class').val(),
			'value': _type=='custom'?$('#post_extrainfo_value').val():'',
			'nofollow': _type=='custom'?$('#post_extrainfo_nofollow').val():'',
			'taxonomy': _type=='taxonomy'?$('#post_extrainfo_taxonomy').val():'',
			'postmeta': _type=='postmeta'?$('#post_extrainfo_postmeta').val():'',
			'taxonomymeta': _type=='taxonomymeta'?_taxonomymeta:'',
			'taxonomymeta_field': _type=='taxonomymeta'?_taxonomymeta_field:''
		};
		
		if( $(this).data('post_extrainfo') ){
			//saving
			var p = $(this).data('post_extrainfo');
			var index = $(this).data('post_extrainfo_id');
			var n = $.extend({},p,o);
			n.column = p.column;//do not overwrite the column
			post_extrainfo[index]=n;
			//--
			$(this).data('post_extrainfo_id',null);
			$(this).data('post_extrainfo',null).trigger('post_extrainfo');
		}else{//new
			post_extrainfo[post_extrainfo.length]=o;
		}			
			
		load_extra_info();
	});
	
	$('#post_extrainfo_taxonomy,#post_extrainfo_postmeta').on('change',function(e){
		$('#post_extrainfo_label').val( $(this).find('option:selected').html() );
	});
	
	$('#post_extrainfo_taxonomymeta').on('change',function(e){
		$('#post_extrainfo_label').val( $(this).find('option:selected').attr('alt') );
	});
	
	$('#extra_info_columns,#extra_info_size,#extra_info_separators').on('change',function(e){load_extra_info();});
		
	//-- layout choose helper
	$('.pinfo-layout-helper').hover(
		function(e){ if(!$(this).hasClass('current-selection'))$(this).addClass('pinfo-hovered');},
		function(e){$(this).removeClass('pinfo-hovered');}
	);
	$('.pinfo-layout-helper').on('click',function(e){
		$('.pinfo-layout-helper').removeClass('current-selection');
		$(this).addClass('current-selection');
		$('#extra_info_columns').val( $(this).data('pinfo_columns') ).trigger('change');
		$('#extra_info_size').val( $(this).data('pinfo_span') ).trigger('change');
	});
	//-- quick access icons
	$('#post_extrainfo_quick_icons').tabs();
	$('.pinfo_quick_icon').on('click',function(e){
		var me = this;
		var fields = ['post_extrainfo_type','post_extrainfo_taxonomy','post_extrainfo_taxonomymeta','post_extrainfo_postmeta','post_extrainfo_label','post_extrainfo_class','post_extrainfo_value','post_extrainfo_nofollow'];
		$.each(fields,function(i,f){
			var v = $(me).data(f);
			if(v){
				$('#'+f).val( v ).trigger('change');
			}
		});
	});
	$('.pinfo_quick_icon').draggable({
		revert:true,
		helper:"clone",
		zIndex:9999,
		stop:function(e,ui){
			$('.fe-maincol').removeClass('receiving-icon');
		}
	});
	//-- end quick access icons
	//--save default
	$('#pinfo-set-default').on('click',function(e){
		if( confirm( $(this).data('confirm_message') ) ) {
			set_default_fields();
		}
	});
	//--reset to default
	$('#pinfo-reset-to-default').on('click',function(e){
		if( confirm( $(this).data('confirm_message') ) ) {
			reset_to_default_fields();
		}	
	});
	//--change box id
	$('#postinfo_boxes_id').on('change',function(e){
		get_post_extrainfo();
	}).trigger('change');
	//load_extra_info();
});

function init_sortable(){
	jQuery(document).ready(function($){
		$('.fe-sortable').each(function(i,inp){
			$(inp).sortable({
				'handle':'.widget-top',
				'connectWith': '.fe-sortable',
				'beforeStop': function(e,ui){
					$('#post_extrainfo').stop().animate({opacity:0.2});
					$('.fe-sortable').sortable('disable');
					new_post_extrainfo = [];
					$('.rhc-extra-info-cell').each(function(i,inp){	
						var col = $(this).parents('.fe-maincol').data('column_index');
						var index = $(this).attr('rel');
						post_extrainfo[index].column = col;
						new_post_extrainfo[new_post_extrainfo.length]=post_extrainfo[index];
					});
					post_extrainfo = new_post_extrainfo;
					load_extra_info();
				},
				stop:function(e,ui){
					$('.fe-maincol').removeClass('receiving-icon');
				}				
			});
		});	
		//-- also init dropable for icons
		$('.fe-maincol').droppable({
			drop:function(e,ui){	
				var item = ui.draggable;	
				if( $(item).hasClass('pinfo_quick_icon') ){
					$('#post_extrainfo').stop().animate({opacity:0.2});
					var _type = $(item).data('post_extrainfo_type'); 
					var arr = $(item).data('post_extrainfo_taxonomymeta').split('|');
					var _taxonomymeta_field = '';
					var _taxonomymeta = '';
					if(arr.length==2){
						_taxonomymeta_field = arr[0];
						_taxonomymeta = arr[1];
					}			
					
					var o = {
						'type': 			_type,
						'span': 			'12',
						'column': 			parseInt( $(this).data('column_index') ) ,
						'label': 			$(item).data('post_extrainfo_label'),
						'class': 			$(item).data('post_extrainfo_class')||'',
						'custom': 			$(item).data('post_extrainfo_custom')||'',
						'value': 			_type=='custom'?$(item).data('post_extrainfo_value'):'',
						'nofollow':			_type=='custom'?$(item).data('post_extrainfo_nofollow'):'',
						'taxonomy':			_type=='taxonomy'?$(item).data('post_extrainfo_taxonomy'):'',
						'postmeta': 		_type=='postmeta'?$(item).data('post_extrainfo_postmeta'):'',
						'taxonomymeta': 	_type=='taxonomymeta'?_taxonomymeta:'',
						'taxonomymeta_field': _type=='taxonomymeta'?_taxonomymeta_field:''
					};
					post_extrainfo[post_extrainfo.length] = o;
					load_extra_info();				
				}		
			},
			over:function(e,ui){
				$(this).addClass('receiving-icon');
			},
			out:function(e,ui){
				$(this).removeClass('receiving-icon');
			}
		});		
		//-- init the widget delete icon
		$('.rhc-extra-info-cell a.ui-icon-closethick').on('click',function(e){
			$(this).parents('.rhc-extra-info-cell').first().addClass('remove');
			$('.rhc-extra-info-cell').each(function(i,inp){
				if( $(this).hasClass('remove') ){
					var remove_index = $(this).attr('rel');
					$(this).animate({opacity:0.2});
					var tmp = [];
					for(a=0;a<post_extrainfo.length;a++){
						if(a==remove_index)continue;
						tmp[tmp.length]=post_extrainfo[a];
					}
					post_extrainfo = tmp;
					load_extra_info();
					return;				
				}
			});
		});		
		//-- also init toggle of widgets
		//--widget toggle
		$('.extra-info-toggle').on('click',function(e){
			e.stopPropagation();
			var widget_content = $(this).parents('.widget').find('.widget-inside');
			widget_content.toggle();
			if( widget_content.is(':visible') ){
				$(this).removeClass('ui-icon-triangle-1-s').addClass('ui-icon-triangle-1-n');
			}else{
				$(this).removeClass('ui-icon-triangle-1-n').addClass('ui-icon-triangle-1-s');
			}
		});	
		//--render the form inside the widgets
		$('.rhc-extra-info-cell').each(function(i,inp){
			var widget_content = $(this).find('.widget-content');
			if( ''!=widget_content.html() )return;
			var index = $(this).attr('rel');
			$('.post_extrainfo_control .post_extrainfo_cell').each(function(j,control){
				if( $(this).find('.pinfo_input').length==0 )return;
				var _input_id = $(this).find('.pinfo_input').attr('id');
				var _new_input_id = _input_id + '_' + index;
				var _row = $(this).clone();
				var _value = '';

				//--fill values
				$.each([['post_extrainfo_date_format','date_format'],['post_extrainfo_span','span'],['post_extrainfo_type','type'],['post_extrainfo_label','label'],['post_extrainfo_class','class'],['post_extrainfo_custom','custom'],['post_extrainfo_value','value'],['post_extrainfo_nofollow','nofollow'],['post_extrainfo_taxonomy','taxonomy'],['post_extrainfo_postmeta','postmeta']],function(i,s){
					if( _input_id==s[0] ){
						if( typeof post_extrainfo[index]!='undefined' ){
							_value = post_extrainfo[index][s[1]];
						}
					}				
				});
				if( 'post_extrainfo_taxonomymeta'==_input_id ){
					if( typeof post_extrainfo[index]!='undefined' ){
						_value = (post_extrainfo[index].taxonomymeta_field?post_extrainfo[index].taxonomymeta_field:'') + '|' + post_extrainfo[index].taxonomymeta;
					}
				}
				//--			
				_row
					.removeClass('post_extrainfo_cell')
					.addClass( 'wcell' )
					.find('.pinfo_input')
						.val(_value)
						.attr('id', _new_input_id )
						.attr('name', _new_input_id)
						.addClass(_input_id)
						.end()
					.appendTo( widget_content )
				;
				//---
			});
		});
		//--- create the post info type, change event
		$('.rhc-extra-info-cell .post_extrainfo_type').on('change',function(e){ 
			var p = $(this).parents('.rhc-extra-info-cell');
			p.find('.post_extrainfo_type-cell').hide();
			p.find('.post_extrainfo_type-'+$(this).val()).fadeIn();
			
			if($(this).val()=='taxonomy'){p.find('.post_extrainfo_taxonomy').trigger('change');}
			if($(this).val()=='taxonomymeta'){p.find('.post_extrainfo_taxonomymeta').trigger('change');}
			if($(this).val()=='postmeta'){p.find('.post_extrainfo_postmeta').trigger('change');}
		}).trigger('change');	
		//--- change the label on some of the dropdown change event
		$('.rhc-extra-info-cell .post_extrainfo_taxonomy, .rhc-extra-info-cell .post_extrainfo_postmeta').on('change',function(e){
			$(this).parents('.rhc-extra-info-cell').find('.post_extrainfo_label').val( $(this).find('option:selected').html() );
		});
		
		$('.rhc-extra-info-cell .post_extrainfo_taxonomymeta').on('change',function(e){
			$(this).parents('.rhc-extra-info-cell').find('.post_extrainfo_label').val( $(this).find('option:selected').attr('alt') );
		});		
		//--- save button
		$('.rhc-extra-info-cell .pinfo-save').on('click',function(e){
			$('#post_extrainfo').stop().animate({opacity:0.2});
			var index = $(this).parents('.rhc-extra-info-cell').attr('rel');
			var column = $(this).parents('.fe-maincol').data('column_index');
			var p = $(this).parents('.rhc-extra-info-cell');
			var _type = p.find('.post_extrainfo_type').val(); 
			if(p.find('.post_extrainfo_taxonomymeta').length>0){
				//arr = p.find('.post_extrainfo_taxonomymeta').val().split('|');
				var _val = p.find('.post_extrainfo_taxonomymeta').val();
				if(_val){
					arr = _val.split('|');
				}else{
					arr = [];
				}
			}else{
				arr = [];
			}
			var _taxonomymeta_field = '';
			var _taxonomymeta = '';
			if(arr.length==2){
				_taxonomymeta_field = arr[0];
				_taxonomymeta = arr[1];
			}			
			
			var o = {
				'type': 			_type,
				'span': 			p.find('.post_extrainfo_span').val(),
				'column': 			parseInt( column ) ,
				'label': 			p.find('.post_extrainfo_label').val(),
				'class': 			p.find('.post_extrainfo_class').val(),
				'value': 			_type=='custom'?p.find('.post_extrainfo_value').val():'',
				'nofollow': 		_type=='custom'?p.find('.post_extrainfo_nofollow').val():'',
				'custom': 			p.find('.post_extrainfo_custom').val()||'',
				'taxonomy':			_type=='taxonomy'?p.find('.post_extrainfo_taxonomy').val():'',
				'postmeta': 		_type=='postmeta'?p.find('.post_extrainfo_postmeta').val():'',
				'taxonomymeta': 	_type=='taxonomymeta'?_taxonomymeta:'',
				'taxonomymeta_field': _type=='taxonomymeta'?_taxonomymeta_field:''
			};
		
			_format = p.find('.post_extrainfo_date_format').val();
			if( ''!=_format ){
				o.date_format = _format
			}
		
			post_extrainfo[index]=o;
			load_extra_info();
		});	
	});
}

function load_extra_info(){
	jQuery(document).ready(function($){
		//reset the add button.
		$('#post_extrainfo_add').data('post_extrainfo_id',null);
		$('#post_extrainfo_add').data('post_extrainfo',null).trigger('post_extrainfo');	
		
		$('#extrainfo-loading img').stop().fadeIn('slow');
		//--move elements to the first column if they are not in the selected layout columns
		var columns = $('#extra_info_columns').val();
		$.each(post_extrainfo,function(i,p){
			if( p.column+1 > columns ){
				post_extrainfo[i].column = 0;
			}
		});	
		//--
		var args = {
			action: 'update_postinfo_' + $('#post_type').val(),
			post_ID: $('#post_ID').val(),
			'columns': $('#extra_info_columns').val(),
			'content_span': $('#extra_info_size').val(),
			'postinfo_boxes_id': $('#postinfo_boxes_id').val(),
			data:post_extrainfo		
		}
	
		$.post(ajaxurl,args,function(data){
			if(data.R=='OK'){		
				$("#post_extrainfo").html(data.HTML);
				init_sortable();
				init_post_info_viewport();
			}
			$('#extrainfo-loading img').stop().fadeOut();
			$('#post_extrainfo').stop().animate({opacity:1});
		},'json');
	});
}

function init_post_info_viewport(){
	jQuery(document).ready(function($){
		$('#postinfo_boxes_id').find('option').each(function(i,option){
			$('.post_extrainfo_holder').removeClass( $(option).attr('value') );
		});
		$('.post_extrainfo_holder').addClass( $('#postinfo_boxes_id').val() );
	});
}

function init_editable(){
	jQuery(document).ready(function($){
		$('.rhc-extra-info-cell').on('click',function(e){
			var id = $(this).attr('rel');
			
			$('#post_extrainfo_span').val(post_extrainfo[id].span).trigger('change');
			$('#post_extrainfo_type').val(post_extrainfo[id].type).trigger('change');
			$('#post_extrainfo_value').val(post_extrainfo[id].value).trigger('change');
			$('#post_extrainfo_nofollow').val(post_extrainfo[id].nofollow).trigger('change');
			
			var _post_extrainfo_taxonomymeta = post_extrainfo[id].taxonomymeta_field + '|' + post_extrainfo[id].taxonomymeta; 
			$('#post_extrainfo_taxonomymeta')
				.val(_post_extrainfo_taxonomymeta)
				.trigger('change')
			;
			
			$('#post_extrainfo_label').val(post_extrainfo[id].label).trigger('change');
			
			$('#post_extrainfo_add').data('post_extrainfo_id', id ).trigger('post_extrainfo');
			$('#post_extrainfo_add').data('post_extrainfo', post_extrainfo[id] ).trigger('post_extrainfo');
		});	
	});	
}

function remove_extrainfo_cell(){
	jQuery(document).ready(function($){
		
	});
}

var post_extrainfo = [];
function get_post_extrainfo(){
	jQuery(document).ready(function($){
		$('#post_extrainfo').stop().animate({opacity:0.2});
		//-- init post_extrainfo
		var args = {
			action: 'get_postinfo_' + $('#post_type').val(),
			post_ID: $('#post_ID').val(),
			postinfo_boxes_id: $('#postinfo_boxes_id').val()
		}
		$.post(ajaxurl,args,function(data){
			if(data.R=='OK'){
				post_extrainfo = data.DATA.data;
				$('#extra_info_size').val( data.DATA.span );
				$('#extra_info_columns').val( data.DATA.columns );
				//-- refresh the column/span helper
				$('.pinfo-layout-helper.current-selection').removeClass('current-selection');
				$('.pinfo-layout-helper').each(function(i,inp){
					if( (data.DATA.span==$(inp).data('pinfo_span')) ){
						if( (data.DATA.columns==$(inp).data('pinfo_columns')) ){
							$(inp).addClass('current-selection');
						}
					}
				});
				//--				
				load_extra_info();
			}else{
				$('#post_extrainfo').stop().animate({opacity:1});
				alert(data.MSG);
			}
		},'json');			
	});
}

function set_default_fields(){
	jQuery(document).ready(function($){
		$('#post_extrainfo').stop().animate({opacity:0.2});
		var args = {
			action: 'set_pinfo_default_' + $('#post_type').val(),
			post_ID: $('#post_ID').val()
		}
	
		$.post(ajaxurl,args,function(data){
			if(data.R=='OK'){	
			
			}else if(data.R=='ERR'){
				alert(data.MSG);
			}
			$('#post_extrainfo').stop().animate({opacity:1});
		},'json');
	});
}

function reset_to_default_fields(){
	jQuery(document).ready(function($){
		$('#post_extrainfo').stop().animate({opacity:0.2});
		var args = {
			action: 'pinfo_reset_to_default_' + $('#post_type').val(),
			post_ID: $('#post_ID').val()
		}
	
		$.post(ajaxurl,args,function(data){
			if(data.R=='OK'){	
				get_post_extrainfo();
			}else if(data.R=='ERR'){
				alert(data.MSG);
			}
			$('#post_extrainfo').stop().animate({opacity:1});
		},'json');
	});
}