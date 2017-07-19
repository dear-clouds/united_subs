;;

var debug_loop_count = 0;
jQuery(document).ready(function($){
	if($.fn.button.noConflict)$.fn.button.noConflict();
	var options = {
		editable: true,
		transition: {
			notransition: 1
		},
		selectable:true,
		selectHelper:true,
		select: fc_select,
		events: calendarize_events_source,
		eventClick: function(event,jsEvent,view){
			fc_select(event.start, event.end, event.allDay, jsEvent, view, true);
		},
		eventDrop: fc_event_drop,
		eventResize: fc_event_resize,
		dragOpacity:{'':.7},
		eventRender: function (event,element,view){	
			$('.fc-event-title', element).html(event.title);
		}
	};
	
	all_options = $.extend({},rh_calendar_options,options);
	
	var fullcalendar = $('#calendarize').fullCalendar(all_options);
	
	if( $('#fc_start').length>0 && ''!=$('#fc_start').val() ){
		var sdate = new Date( $('#fc_start').val() );
		if(!isNaN(sdate)){
			$('#calendarize').fullCalendar('gotoDate', sdate );			
		}
	}
	
	$('body').append( $('.fc-dialog') );
	 init_dialog();
	
	$('.fc-dg-cancel').on('click',function(){
		do_restore();
		$('#calendarize').fullCalendar('refetchEvents');
		fc_dg_close(null,null);
	});
	
	$('.fc-dg-ok').on('click',function(){
		$('body').find('.fc-dialog .fc-status').fadeIn('fast');
		var data = [];

		//----
		push_dialog_data_to_form();
		
		$('body').find('.fc-dialog .fc-status').stop().fadeOut('fast');
		fc_dg_close(null,null);
	});
	$('.fc-dg-remove').on('click',function(){
		var msg = $('#prompt-remove').html();
		if( !confirm(msg) ){
			return false;
		}
		
		$('.fc-dialog .fc_input').each(function(i,inp){
			$('#'+inp.name).val( '' );
		});
		$('#fc_rrule,#fc_rdate,#fc_exdate').val( '' );
		$('#calendarize').fullCalendar('refetchEvents');
		fc_dg_close(null,null);
	});
	$('.fc-dg-exclude').on('click',function(){
		var clicked_date = $('.fc-dialog .clicked_start_date').val();	
		_remove_rdate( clicked_date );
		add_exdate( clicked_date );
		render_exdates();
		$('.tabs-exclude a').trigger('click');
	});
	/*
	$('.fc-dg-addnew').on('click',function(){
		var msg = $('#prompt-overwrite').html();
		if( confirm(msg) ){
			$('.fc-dialog')
				.find('.secondary-content').hide().end()
				.find('.main-content').show().end()
			;		
		}
	});
	*/
	$('.fc-dg-main').on('click',function(){
		$('.fc-dialog')
			.find('.secondary-content').hide().end()
			.find('.main-content').show().end()
		;	
	});
	$('.fc-dg-repeat').on('click',function(){
		//---remove previous value
		var prev = $('.fc_rdate_time').attr('rel');
		if(''!=prev){
			_remove_rdate(prev);
		}
		//---
		var time_str = $('.fc_rdate_time').val();
		if(time_str==''){
			var _rdate = $('.fc-selected-date-inp').val(); 
			add_rdate( _rdate ) ;		
		}else{
			var _rtime = _parseTime( time_str );
			var _rdate = $('.fc-selected-date-inp').val() + ' ' + $.fullCalendar.formatDate(_rtime,'HH:mm:ss');
			add_rdate( _rdate ) ;
		}
		$('#calendarize').fullCalendar('refetchEvents');
	});
	$('.fc-dg-repeat-remove').on('click',function(){
		var prev = $('input.fc_rdate_time').attr('rel');
		if(prev!='')
			_remove_rdate(prev);
		$('#calendarize').fullCalendar('refetchEvents');	
		fc_dg_close(null,null);
	});
	//--- change meta field times to 24h
	
	//---time 
	$('.fc_start_time, .fc_end_time').on('click keyup',function(e){
		if( $('.fc_start_time').val()=='' ){
			$('.fc-dialog .fc_allday').attr('checked',true);
		}else{
			$('.fc-dialog .fc_allday').attr('checked',false);
		}
		return true;
	});
	//---- fc helper on date fields on dialog
	$('.fc_start,.fc_end,.fc_end_interval').on('click',function(){
		if( $(this).parent().parent().find('.fc_start_fullcalendar_holder').is(':visible') ){
			$(this).parent().parent().find('.fc_start_fullcalendar_holder').hide();
		}else{
			$('.fc_start_fullcalendar_holder').hide();
			$(this).parent().parent().find('.fc_start_fullcalendar_holder')
				.css({opacity:0})
				.show()
				.find('.fc_start_fullcalendar').fullCalendar('render').end()
				.animate({opacity:1})
				//.fadeIn('fast')
			;
		}
	});	
	$('.fc_start_fullcalendar_holder')
		.on('mouseenter',function(e){$(this).removeClass('close-on-click');})
		.on('mouseleave',function(e){$(this).addClass('close-on-click');})
	$('body').click(function(e){
		$('.fc_start_fullcalendar_holder.close-on-click').removeClass('close-on-click').hide();
	});	
	
	//---farbtastic
	$('.fc-dialog')
		.find('.fc_color').attr('value', $('#fc_color').val() ).change().end()
		.find('.fc_text_color').val( $('#fc_text_color').val() ).change().end()
	;	
	$('.pop-farbtastic').each(function(i,o){
		$(this).farbtastic($(this).attr('rel')).hide();
	});	
	$('.farbtastic-choosecolor').click(function(e){
		var helper = $(this).parent().find('.pop-farbtastic');
		if(helper.is(':visible')){
			helper.slideUp();
			$(this).addClass('show-colorpicker').removeClass('hide-colorpicker');
		}else{
			helper.slideDown();
			$(this).addClass('hide-colorpicker').removeClass('show-colorpicker');
		}
		var tmp = $(this).attr('rel');
		$(this).attr('rel',$(this).attr('title'));
		$(this).attr('title',tmp);		
	});
	$('.farbtastic-choosecolor').mousedown(function(e){$(this).parent().find('input').trigger('focus');});	
	
	//---
	$('.fc_color_input').change(function(){	
		if($(this).val()==''){
			$(this).val('#');
		}
	});
	//--
	$('#rrule_freq').on('change',function(e){	
		$('.rrule_input:checkbox').attr('checked',false);
		rrule_section_change_frequency(e);
	});
	//---- more repeat options
	$('.fc_interval').on('change',function(e){
		if( $(this).val()=='rrule' ){
			$('.rrule_holder').hide();
			$('#rrule_freq')
				.val('WEEKLY')
				.trigger('change');
			$('.rrule_section').show();
		}else{
			$('.rrule_section').hide();
		}
		
		if( $(this).val()=='' ){
			$('.end-repeat-section').hide();
		}else{
			$('.end-repeat-section').show();
		}		
	}).trigger('change');
	//--chk to btns
	$('.rhc-adm-time-format,.rrule_byweekno_group,.rrule_bymonth_group,.rrule_bymonthday_group,.rrule_bysetpos_group,.rrule_bywkst_group,.rrule_several_hours_group,.rrule_byhour_group,.rrule_byminute_group')
		.buttonset();
		
	//--multiple hours button
	$('.rrule_several_hours_inp').on('change',function(e){
		if( $(this).attr('checked') ){
			if('HOURLY'==$('#rrule_freq').val()){
				$('.rrule_byminute_holder').show();
			}else{
				$('.rrule_byhour_holder,.rrule_byminute_holder').show();			
			}
		}else{
			$('.rrule_byhour_holder,.rrule_byminute_holder')
				.slideUp()
				.find('.rrule_input').each(function(i,inp){
					$(inp)
						.attr('checked',false)
						.button('refresh')
					;
				});
			;
		}
	});
	
	//--12h switch
	$('#rhc-switch-12h-format').on('click',function(e){
		$(this).parent().parent().toggleClass('format-12h');
		
		var span = $(this).parent().parent().find('.rrule_byhour_group span.ui-button-text');
		
		if($(this).parent().parent().hasClass('format-12h')){
			$(this).html('24h');
			var _format = 'ht';
		}else{
			$(this).html('12h');
			var _format = 'H';			
		}
			
		span.each(function(i,inp){
			var d = _parseTime(	$(inp).html() );	
			var value = $.fullCalendar.formatDate(d,_format);
			if( $(inp).parent().next().hasClass('rrule_val_13') ){
				value = value=='12a'?'12p':'12';
			}
			$(inp).html( value );
		});
		
	});
	
	//--end repeat type
	$('#rrule_repeat_end_type').on('change',function(e){
		switch( $(this).val() ){
			case 'never':
				$('#rrule_until,#fc_end_count').val('');
				break;
			case 'until':
				$('#fc_end_count').val('');
				break;
			case 'count':
				$('#rrule_until').val('');
				break;
		}
		var vis = '.repeat_type_'+$(this).val();
		$('.repeat_type:not('+vis+')').hide();
		$(vis).show();
	}).trigger('change');
	
	//--- remove exdate
	$('.excluded-date-item a').on('click',function(e){
		remove_exdate(this);
		render_exdates();
	});
	//--- remove rdate
	$('.repeat-date-item a').on('click',function(e){
		remove_rdate(this);
		render_rdates();
	});
	//--- refresh calendar when values are changed on the dialog
});

function push_dialog_data_to_form(){
	jQuery(document).ready(function($){
		$('.fc-dialog .fc_input').each(function(i,inp){
			if(inp.type=='checkbox'){
				if(inp.name!='fc_dow_except[]'){
					$('#'+inp.name).val( ($(inp).is(':checked')?1:0) );				
				}			
			}else{
				$('#'+inp.name).val( $(inp).val() )
					//.trigger('change') //this produces an infinite loop.
				;
			}
		});
		
		set_rrule_from_form(function(rrule){
			$('#fc_rrule').val( rrule );
			if('count'==$('#rrule_repeat_end_type').val()){	
				var arr = $('#fc_start').val().split('-');
				var fc_start = new Date();
				fc_start.setYear(arr[0]);
				fc_start.setMonth(arr[1]-1);
				fc_start.setDate(arr[2]);			
				scheduler = new Scheduler(fc_start, rrule, true);
//console.log( fc_start.getTime(), rrule );
				occurrences = scheduler.all_occurrences( fc_start.getTime(), fc_start.getTime() + 94608000 );
				if(occurrences && occurrences.length>0){
					var last = occurrences.pop();
					var last_date = new Date(last);
					$('#fc_end_interval').val( $.fullCalendar.formatDate(last_date,'yyyy-MM-dd') );
				}
			}			
			
			set_rhc_events();
			
			$('#calendarize').fullCalendar('refetchEvents');
		});		
	});	
}

//Note: this callback is called by the dialog fields, and the change bind is done on func fc_select and also on render_rrules for the bysetpos checkboxes.
function cb_fc_input_change(e){  
	if( jQuery(e.target).is('.calendarize_meta_data') ||  jQuery(e.target).is('.fc_rdate_time') ){
		return true;
	}
	
	if( location.hash=='rhc_debug' )		
		console.log('change');
   
	if( debug_loop_count++ > 1000 ) return true;
	push_dialog_data_to_form();
	dg_refresh_rrule_dates();
	return false;
}

function dg_refresh_rrule_dates(){
	if( location.hash=='rhc_debug' )		
		console.log('dg_refresh_rrule_dates');
		
	jQuery(document).ready(function($){
		rrule_str = $('#fc_rrule').val( );
		if( 0==rrule_str.length ){
			$('.recurring-dates-holder').empty();
			return true;
		}	

		var start_time = $.fullCalendar.formatDate( _parseTime($('#fc_start_time').val()), 'HH:mm:ss');
		var _start_str = $('#fc_start').val() + ' ' + (''==start_time?'00:00:00':start_time) ;
		var start_date = $.fullCalendar.parseDate( _start_str ) ;	
	
		rrule = RRule.fromString( 'DTSTART=' + _timeToUntilString( start_date.getTime() ) + ';' + rrule_str );

		var freq = rrule.options.freq;
		var interval = rrule.options.interval;
		first_date = start_date;
		//Note the following occurences are for the bysetpos selection, therefore we do not want
		//them on this instance
		if( rrule.options.bysetpos ){
			bysetpos = rrule.options.bysetpos.slice();
			rrule.options.bysetpos = null;	
		}else{
			bysetpos = [];
		}

		ocurrences = rrule.all(function (date, i){
			if( i==0 ){
				first_date = new Date( date.getTime() );
			}
		
			if( start_date.getTime() == date.getTime() ){
				return true;
			}

			if( freq == RRule.SECONDLY ){	
				return false;
			}else if( freq == RRule.MINUTELY ){
				if( date.getTime() >= first_date.getTime() + 60000*interval ){
					return false;
				}
			}else if( freq == RRule.HOURLY ){
				if( date.getTime() >= first_date.getTime() + 3600000*interval ){
					return false;
				}
			}else if( freq == RRule.DAILY ){
				if( date.getTime() >= ( first_date.getTime() + 86400000*interval ) ){				
					return false;
				}
			}else if( freq == RRule.WEEKLY ){
				if( date.getTime() >= ( first_date.getTime() + 604800000*interval ) ){			
					return false;
				}
			}else if( freq == RRule.MONTHLY ){
				compare_date = new Date( first_date.getTime() );
				compare_date.setMonth( compare_date.getMonth() + 1 );
				if( compare_date.getTime() <= date.getTime() ){
					return false;
				}
			}else if( freq == RRule.YEARLY ){
				compare_date = new Date( first_date.getTime() );
				compare_date.setFullYear( compare_date.getFullYear() + 1 );
				if( compare_date.getTime() <= date.getTime() ){					
					return false;
				}
			}
			
			
			if( i > 2000 ) {
				return false; //hard limit of 2000
			}
			
			return true;
		});
		


		render_rrule_dates( ocurrences, bysetpos, rrule );
	});
}

function cb_sort_yearly(a,b){
	c = new Date( b.getTime() );
	c.setFullYear( a.getFullYear() );
	return a.getTime() < c.getTime() ? -1 : 1;
}

function cb_sort_monthly(a,b){
	c = new Date( b.getTime() );
	c.setFullYear( a.getFullYear() );
	c.setMonth( a.getMonth() );
	return a.getTime() < c.getTime() ? -1 : 1;
}

function cb_sort_daily(a,b){
	c = new Date( b.getTime() );
	c.setFullYear( a.getFullYear() );
	c.setMonth( a.getMonth() );
	c.setDate( a.getDate() );
	return a.getTime() < c.getTime() ? -1 : 1;
}

function cb_sort_hourly(a,b){
	c = new Date( b.getTime() );
	c.setFullYear( a.getFullYear() );
	c.setMonth( a.getMonth() );
	c.setDate( a.getDate() );
	c.setHours( a.getHours() );
	return a.getTime() < c.getTime() ? -1 : 1;
}

function cb_sort_weekday(a,b){
	if( a.getDay() == b.getDay() ){
		//sort by hour
		return cb_sort_daily(a,b);
	}else{
		return a.getDay() - b.getDay();
	}
}

var rr_wkst;
var rr_weekdays = [0,1,2,3,4,5,6] ;
function cb_sort_weekly(a,b){	
	a_cmp = ( rr_weekdays.indexOf( a.getDay() ) * 10000 ) + ( a.getHours() * 100 ) + a.getMinutes() ;
	b_cmp = ( rr_weekdays.indexOf( b.getDay() ) * 10000 ) + ( b.getHours() * 100 ) + b.getMinutes() ;
	return a_cmp - b_cmp;
}

function render_rrule_dates( ocurrences, bysetpos, rrule ){
	if( ocurrences.length > 0 ){
		if( rrule.options.freq == RRule.WEEKLY ){
			var _map = [1,2,3,4,5,6,0];
			rr_wkst = rrule.options.wkst;
			rr_wkst = _map[rr_wkst];		
			//reorder rr_weekdays
			var flag=0;
			while( rr_wkst != rr_weekdays[0] ){			
				if( flag++ > 10 ) break;
			
				first = rr_weekdays.shift();
				rr_weekdays.push( first );
			}
//console.log( 'rr_weekdays', rr_weekdays );

			ocurrences.sort(cb_sort_weekly);
		}
		//Note: sorted_ocurrences will contain the order where the index of the 
		//array corresponds to the bysetpos number.
		var sorted_ocurrences = [];
		for(var a=0;a<ocurrences.length;a++){
			sorted_ocurrences.push( new Date( ocurrences[a].getTime() ) );
		}

		switch( rrule.options.freq ){
			case  RRule.YEARLY:
				sorted_ocurrences.sort( cb_sort_yearly );
				break;
			case  RRule.MONTHLY:
			case  RRule.WEEKLY:
				sorted_ocurrences.sort( cb_sort_monthly );
				break;
			
			case RRule.DAILY:
				sorted_ocurrences.sort( cb_sort_daily );
				break;
			
			case RRule.HOURLY:
				sorted_ocurrences.sort( cb_sort_hourly );
				break;
		}
	}
//console.log( 'sorted_ocurrences', sorted_ocurrences );		
	//Weekly table
	if( rrule.options.freq == RRule.WEEKLY ){
		return render_rrules_dates_weekly( ocurrences, bysetpos, rrule );
	}
	//The rest
	jQuery(document).ready(function($){
		$('.recurring-dates-holder').empty();
		
		if( ocurrences.length > 0 ){
			$.each( ocurrences, function( i, date ){			
				var setpos = sorted_ocurrences.map(Number).indexOf(+date) + 1;
			
				date_str = $.fullCalendar.formatDate( date, 'ddd MMMM dd @ HH:mm');
				//NOTE: the origional rrule_bysetpos is incorrectly named, rr_bysetpos is the real bysetpos.
				chk = $('<input type="checkbox" class="rr_bysetpos" name="rr_bysetpos" value="' + setpos + '">');
				if( -1 != bysetpos.indexOf( setpos ) || bysetpos.length==0 ){
					chk.prop('checked', true);
				}				
				$('<div></div>')
					.append( chk )
					.append('<span>' + date_str + '</span>')
					.appendTo( $('.recurring-dates-holder') )
			
				chk.bind('change', function(e){
					//updates the cal inmediately. if commented out, then the cal is updated when Accept is pressed.
					push_dialog_data_to_form();
				});
			});
		}
	});
}

function render_rrules_dates_weekly( ocurrences, bysetpos, rrule ){
	jQuery(document).ready(function($){
		var holder = $('.recurring-dates-holder').empty();
		
		var table = $('<div class="rr_bysetpos_weekly"></div>').appendTo( holder );
		
		if( ocurrences.length > 0 ){
			$.each( ocurrences, function( i, date ){
				var setpos = (parseInt(i)+1) ;
				var day = date.getDay();
				col_name = 'rr_bysetpos_col_' + date.getDay();
				if( 0==table.find( '.'+col_name ).length ){
					table.append(
						$('<div ></div>')
							.addClass( 'rr_bysetpos_cell' )
							.addClass( col_name )
							.append(
								$('<div class="rr_bysetpos_header"></div>')
									.html(
										rh_calendar_options.dayNamesShort[day]
									)
							)
					);
				}

				date_str = $.fullCalendar.formatDate( date, 'HH:mm');
				full_date_str = $.fullCalendar.formatDate( date, 'ddd MMMM dd @ HH:mm');
				//NOTE: the origional rrule_bysetpos is incorrectly named, rr_bysetpos is the real bysetpos.
				chk = $('<input type="checkbox" class="rr_bysetpos" name="rr_bysetpos" value="' + setpos + '">');
				chk.attr('data-ref_date', full_date_str);
				if( -1 != bysetpos.indexOf( setpos ) || bysetpos.length==0 ){
					chk.prop('checked', true);
				}				
				$('<div></div>')
					.append( chk )
					.append('<span>' + date_str + '</span>')
					.appendTo( '.'+col_name )
			
				chk.bind('change', function(e){
					//updates the cal inmediately. if commented out, then the cal is updated when Accept is pressed.
					push_dialog_data_to_form();
				});
			});
		}
	});
}

function _timeToUntilString(time) {
	// this is a copy of the one rrule.js uses.
	var date = new Date(time);
	var comp, comps = [
		date.getUTCFullYear(),
		date.getUTCMonth() + 1,
		date.getUTCDate(),
		'T',
		date.getUTCHours(),
		date.getUTCMinutes(),
		date.getUTCSeconds(),
		'Z'
	];
	for (var i = 0; i < comps.length; i++) {
		comp = comps[i];
		if (!/[TZ]/.test(comp) && comp < 10) {
			comps[i] = '0' + String(comp);
		}
	}
	return comps.join('');
};

function set_rhc_events( ){
//console.log('set_rhc_events');
}

function set_rrule_from_form(callback){
	jQuery(document).ready(function($){
		var end = '';
		switch($('#rrule_repeat_end_type').val()){
			case 'until':
				end = $('#rrule_until').val();
				end = end==""?"":";UNTIL="+end.split('-').join('');
				break;
			case 'count':
				end = $('#fc_end_count').val();
				end = end==""?"":";COUNT="+end;
				break;
		}
		var rrule = '';
		var fc_interval = $('#dg_fc_interval').val();
	
		if( fc_interval=='' ){
			
		}else if( 'rrule'==fc_interval ){
			var freq = 	$('#rrule_freq').val();
			var interval = $('#rrule_interval').val();
			rrule = freq==''?rrule:'FREQ='+freq;
			rrule = interval==''?rrule+';INTERVAL=1':rrule+';INTERVAL='+interval;
			//--fill byval section
			var bymonth = $('input:checkbox:checked.rrule_bymonth_inp').map(function(){return this.value;}).get();			
			if(bymonth.length>0){
				rrule = rrule+';BYMONTH='+bymonth.join();
			}
			var byweekno = $('input:checkbox:checked.rrule_byweekno_inp').map(function(){return this.value;}).get();			
			if(byweekno.length>0){
				rrule = rrule+';BYWEEKNO='+byweekno.join();
			}
			var bymonthday = $('input:checkbox:checked.rrule_bymonthday_inp').map(function(){return this.value;}).get();			
			if(bymonthday.length>0){
				rrule = rrule+';BYMONTHDAY='+bymonthday.join();
			}
			var bywkst = $('input:checkbox:checked.rrule_bywkst_inp').map(function(){return this.value;}).get();			
			if(bywkst.length>0){
				var bysetpos = $('input:checkbox:checked.rrule_bysetpos_inp').map(function(){return this.value;}).get();	
				if(bysetpos.length>0){
					//rrule = rrule+';BYSETPOS='+bysetpos.join();
					var tmp = [];
					for(var a=0;a<bysetpos.length;a++){
						for(var b=0;b<bywkst.length;b++){
							tmp.push( bysetpos[a] + bywkst[b] );
						}
					}
					rrule = rrule+';BYDAY='+tmp.join();
				}else{
					rrule = rrule+';BYDAY='+bywkst.join();
				}			
			}
					
			var byhour = $('input:checkbox:checked.rrule_byhour_inp').map(function(){return this.value;}).get();			
			if(byhour.length>0){
				rrule = rrule+';BYHOUR='+byhour.join();
			}
			var byminute = $('input:checkbox:checked.rrule_byminute_inp').map(function(){return this.value;}).get();			
			if(byminute.length>0){
				rrule = rrule+';BYMINUTE='+byminute.join();
			}
	
			var rr_bysetpos = $('input:checkbox:checked.rr_bysetpos').map(function(){return this.value;}).get();			
			if(rr_bysetpos.length>0 && rr_bysetpos.length < $('input:checkbox.rr_bysetpos').length ){
				rrule = rrule+';BYSETPOS='+rr_bysetpos.join();
			}		
	
			if( freq=='WEEKLY' || freq=='YEARLY' ){
				wkst = $('#rrule_input_wkst').val();
				if( ''!=wkst ){
					rrule = rrule+';WKST='+wkst;
				}
			}		
	
			rrule = rrule==''?'':rrule+end;			
		}else{
			rrule = fc_interval+end;
		}
		
		if(callback)
			callback.call(null,rrule);
	});
}

function rrule_section_change_frequency(e){
	jQuery(document).ready(function($){
		//unhook dialog change event that refresh cal
		$('.rrule_inp_section,.fc_input')
			.unbind('change', cb_fc_input_change )
		;	
			
		var visible = '.vis_'+$(e.target).val();
		$('.rrule_holder:not('+visible+')').slideUp(0,'swing',function(){
			$('.rrule_input').each(function(i,inp){
				$(inp)
					//.attr('checked',false)
					.button('refresh')
				;
			});//refresh all checkboxes.
			
			$(visible).show();
			$('.rrule_bymonth_inp').button('refresh');
			$('.rrule_several_hours_inp').trigger('change');
		});		
		
		$('.rrule_inp_section,.fc_input')
			.unbind('change', cb_fc_input_change )
			.bind('change', cb_fc_input_change )
			.first().trigger('change')
		;			
	});
}

function calendarize_events_source(start,end,callback){
	//_calendarize_events_source(start,end,callback);//if all goes good with _local_source, this will e removed on next version.
	_local_source(start,end,callback);
}

function _local_source(start,end,callback){
	jQuery(document).ready(function($){
		var end_time = $.fullCalendar.formatDate( _parseTime($('#fc_end_time').val()), 'HH:mm:ss');
		var start_time = $.fullCalendar.formatDate( _parseTime($('#fc_start_time').val()), 'HH:mm:ss');
		var _end_str = $('#fc_end').val() + ' ' + (''==end_time?'00:00:00':end_time) ;
		var _end = $.fullCalendar.formatDate( $.fullCalendar.parseDate( _end_str ) ,'yyyy-MM-dd HH:mm:ss');//;
		var _start_str = $('#fc_start').val() + ' ' + (''==start_time?'00:00:00':start_time) ;
		var _start = $.fullCalendar.formatDate( $.fullCalendar.parseDate( _start_str ) ,'yyyy-MM-dd HH:mm:ss');//;
		var e = {
			allDay: '1'==$('#fc_allday').val()?true:false,
			end: _end,
			fc_allday: '1'==$('#fc_allday').val()?'1':'0',
			fc_click_link: $('#fc_click_link').val(),
			fc_click_target: $('#fc_click_target').val(),
			fc_color: $('#fc_color').val(),
			fc_dow_except: "",
			fc_end: $('#fc_end').val(),
			fc_end_interval: $('#fc_end_interval').val(),
			fc_end_time: $.fullCalendar.formatDate( $.fullCalendar.parseDate( end ) ,'HH:mm:ss'),
			fc_exdate: $('#fc_exdate').val(),
			fc_interval: $('#fc_interval').val(),
			fc_rdate: $('#fc_rdate').val(),
			fc_rrule: $('#fc_rrule').val(),
			fc_start: $('#fc_start').val(),
			fc_start_time: $.fullCalendar.formatDate( $.fullCalendar.parseDate( start ) ,'HH:mm:ss'),
			fc_text_color: $('#fc_text_color').val(),
			id: $('#post_ID').val(),
			start: _start,
			title: $('#title').val(),
		};
	
		e.color = e.fc_color;
		e.textColor = e.fc_text_color;
		
		if(e.allDay){
			e.fc_start_time = '';
			e.fc_end_time = '';
		}

		var events = [];
		if(e.fc_start==''){
			callback(events);
			return;
		}
		//-------
		if(''==e.fc_rrule && ''==e.fc_rdate){
			events[events.length]=e;
		}else{
			var duration = false;
			if(e.end){
				var e_start = new Date( $.fullCalendar.parseDate(e.start) );
				var e_end = new Date( $.fullCalendar.parseDate(e.end) );
				duration = e_end.getTime() - e_start.getTime();
			}
			
			//var fc_start = new Date(e.fc_start+' '+e.fc_start_time);
			var fc_start = $.fullCalendar.parseDate( e.start );
			e.fc_rrule = ''==e.fc_rrule?'FREQ=DAILY;INTERVAL=1;COUNT=1':e.fc_rrule;
			scheduler = new Scheduler(fc_start, e.fc_rrule, true);
			if(e.fc_interval!=''){
				//handle exception dates
				var fc_exdate_arr = exdate_to_array_of_dates(e.fc_exdate);
				if(fc_exdate_arr.length>0)
					scheduler.add_exception_dates(fc_exdate_arr);
			}
			if(e.fc_rdate!=''){
				//handle rdates
				var fc_rdate_arr = exdate_to_array_of_dates(e.fc_rdate);
				if(fc_rdate_arr.length>0)
					scheduler.add_rdates(fc_rdate_arr);
			}
			occurrences = scheduler.occurrences_between(start, end);

			if(occurrences.length>0){
				$(occurrences).each(function(i,o){
					var new_start = new Date(o);
			
					var p = $.extend(true, {}, e);
					p.id = p.id + '-' + $.fullCalendar.formatDate(new_start,'yyyyMMddHHmmss');
					p._start 	= new_start;
					p.start 	= new_start;
					p.fc_start 	= $.fullCalendar.formatDate(new_start,'yyyy-MM-dd');
					p.fc_start_time = $.fullCalendar.formatDate(new_start,'HH:mm:ss');
					p.fc_date_time 	= $.fullCalendar.formatDate(new_start,'yyyy-MM-dd HH:mm:ss');
					if(duration){
						var end_time = new_start.getTime() + duration;
						var new_end = new Date();
						new_end.setTime(end_time);
						p._end = new_end;
						p.end = new_end;
						p.fc_end = $.fullCalendar.formatDate(new_end,'yyyy-MM-dd');
						p.fc_end_time = $.fullCalendar.formatDate(new_end,'HH:mm:ss');
					}else{
						p.end = p.start;
						p._end = p._start;
					}
			
					events[events.length]=p;
				});
			}
		}
		//---------		
		callback(events);
	});
}

function _calendarize_events_source(start,end,callback){
	jQuery(document).ready(function($){
		var data = [];
		$('.calendarize_meta_data').each(function(i,inp){
			if(inp.type=='checkbox'){
				data[data.length] = [inp.name,($(inp).is(':checked')?1:0)];
			}else{
				data[data.length] = [inp.name,($(inp).val())];
			}
		});
		
		var args = {
			action: 	'calendarize_' + $('#post_type').val(),
			post_ID: 	$('#post_ID').val(),
			start:		Math.round(start.getTime() / 1000),
			end:		Math.round(end.getTime() / 1000),
			'data[]': 	data
		};
	
		$.post(ajaxurl,args,function(data){
			if(data.R=='OK'){
				
				var events = [];
				if(data.EVENTS.length>0){
					$(data.EVENTS).each(function(i,e){
						//-------
						if(''==e.fc_rrule){
							events[events.length]=e;
						}else{
							var duration = false;
							if(e.end){
								var e_start = new Date(e.start);
								var e_end = new Date(e.end);
								duration = e_end.getTime() - e_start.getTime();
							}
							//var fc_start = new Date(e.fc_start+' '+e.fc_start_time);
							var fc_start = $.fullCalendar.parseDate( e.start );

							scheduler = new Scheduler(fc_start, e.fc_rrule, true);
							if(e.fc_interval!=''){
								//handle exception dates
								var fc_exdate_arr = exdate_to_array_of_dates(e.fc_exdate);
								if(fc_exdate_arr.length>0)
									scheduler.add_exception_dates(fc_exdate_arr);
							}
							if(e.fc_rdate!=''){
								//handle rdates
								var fc_rdate_arr = exdate_to_array_of_dates(e.fc_rdate);
								if(fc_rdate_arr.length>0)
									scheduler.add_rdates(fc_rdate_arr);
							}
							occurrences = scheduler.occurrences_between(start, end);

							if(occurrences.length>0){
								$(occurrences).each(function(i,o){
									var new_start = new Date(o);
									var p = $.extend(true, {}, e);
									//p.id = p._id + '-' + $.fullCalendar.formatDate(new_start,'yyyyMMddHHmmss');
									p._start 	= new_start;
									p.start 	= new_start;
									p.fc_start 	= $.fullCalendar.formatDate(new_start,'yyyy-MM-dd');
									p.fc_start_time = $.fullCalendar.formatDate(new_start,'HH:mm:ss');
									p.fc_date_time 	= $.fullCalendar.formatDate(new_start,'yyyy-MM-dd HH:mm:ss');
									if(duration){
										var end_time = new_start.getTime() + duration;
										var new_end = new Date();
										new_end.setTime(end_time);
										p._end = new_end;
										p.end = new_end;
										p.fc_end = $.fullCalendar.formatDate(new_end,'yyyy-MM-dd');
										p.fc_end_time = $.fullCalendar.formatDate(new_end,'HH:mm:ss');
									}
									
									events[events.length]=p;
								});
							}
						}
						//---------
					});
				}			
				callback(events);
			}else if(data.R=='ERR'){
				alert(data.MSG);
			}else{
				alert('Unexpected error');
			}
		},'json');
	});
}

function rrule_to_array(){

}


function fc_select(startDate, endDate, allDay, jsEvent, view, eventClick){
	jQuery(document).ready(function($){
		var pos = $(jsEvent.target).offset();
		var is_repeat = false;
		var _time_str = false;
		
		//unhook dialog change event that refresh cal
		$('.rrule_inp_section,.fc_input')
			.unbind('change', cb_fc_input_change )
		;			
	
		if(eventClick){
			var fc_start = $('#fc_start').val();		
			var fc_end = $('#fc_end').val();
			var fc_start_time = $('#fc_start_time').val();
			var fc_end_time = $('#fc_end_time').val();		
			$('.fc-dialog')
				.find('.secondary-content').hide().end()
				.find('.main-content').show().end()
			;
			//is clicked date a repeat date?
			var rdates_array = exdate_to_array_of_dates( $('#fc_rdate').val() ); 			
			for(var i=0; i<rdates_array.length; i++){
				if(startDate.getTime()==rdates_array[i].getTime()){
					is_repeat = true;
					_time_str = startDate.getHours() + ':' + startDate.getMinutes();				
					break;
				}
			}			
		}else{
			var fc_start = $.fullCalendar.formatDate(startDate,'yyyy-MM-dd');		
			var fc_end = $.fullCalendar.formatDate(endDate,'yyyy-MM-dd');
			var fc_start_time = (allDay?'':$.fullCalendar.formatDate(startDate,'hh:mm tt'));
			var fc_end_time = (allDay?'':$.fullCalendar.formatDate(endDate,'hh:mm tt'));		

			//-----------------
			var events = $('#calendarize').fullCalendar('clientEvents');
			if( events && events.length>0 ){
				is_repeat = true;
				_time_str = startDate.getHours() + ':' + startDate.getMinutes();
			}
			//-------------
		}
		
		if(is_repeat){
			var _rdate = $.fullCalendar.formatDate(startDate,'yyyy-MM-dd');
			$('.fc-dialog')
				.find('.fc-selected-date').html( _rdate ).end()
				.find('.fc-selected-date-inp').val( _rdate ).end()
				.find('.secondary-content').show().end()
				.find('.main-content').hide().end()
				.find('.fc_rdate_time').attr('rel', eventClick?$.fullCalendar.formatDate(startDate,"yyyyMMdd'T'HHmmss"):'' ).end()//new if rel=='' or update if rel==some time str
				.find('.fc-dg-repeat-remove').css('display',eventClick?'block':'none').end()//
				.find('.fc-dg-main').css('display',eventClick?'block':'none').end()//
			;
			
			if( '1'==$('#fc_allday').val() ){
				$('.not-allday-input').hide();
				$('.fc_rdate_time')
					.attr('readonly',true)
					.val('')
				;
			}else{
				_time_str = false==_time_str?$('#fc_start_time').val():_time_str;
				_time = ''==_time_str?'': $.fullCalendar.formatDate(_parseTime(_time_str),'HH:mm');
				$('.not-allday-input').show();
				$('.fc_rdate_time')
					.attr('readonly',false)
					.val(_time)
				;				
			}	
		}
		
		create_restore();
		
		if( is_repeat ){
			$('.fc-dialog')
				.stop().show()
				.css('margin-left',0)
				.offset(pos)
			;			

		}else{
			$('.fc-dialog')
				.find('.fc_start').val( fc_start ).end()
				.find('.fc_end').val( fc_end ).end()
				.find('.fc_start_time').val( fc_start_time ).end()
				.find('.fc_end_time').val( fc_end_time ).end()
				.find('.fc_allday').attr('checked',(allDay?true:false)).end()
				.find('.fc_interval').val( $('#fc_interval').val() ).change().end()
				.find('.fc_end_interval').val( $('#fc_end_interval').val() ).end()
				.find('.fc_color').val( $('#fc_color').val() ).change().end()
				.find('.fc_text_color').val( $('#fc_text_color').val() ).change().end()
				.find('.clicked_start_date').val( startDate ).change().end()
				.find('.fc-dg-exclude,.tabs-exclude').hide().end()
				.find('.fc-status').hide().end()		
				.find('.category-tabs a').first().trigger('click').end().end()//first tab
				.stop().show()
				.css('margin-left',0)
				.offset(pos)
			;			
		}
	
		
		if( ''!=$('#fc_click_link').val() ){
			$('.fc-dialog').find('.fc_click_link').val( $('#fc_click_link').val() ).change();
		}
		
		if( ''!=$('#fc_click_target').val() ){
			$('.fc-dialog').find('.fc_click_target').val( $('#fc_click_target').val() ).change()
		}
		
		if(eventClick){
			$('.fc-dialog .fc-dg-exclude, .tabs-exclude').show();
		}
		
		render_exdates();
		render_rdates();
		
		if(eventClick){
			var rrule = $('#fc_rrule').val();	
			if(rrule!=''){
				var r = rrule.split(';');
				$.each(r,function(i,str){
					var s = str.split('=');				
					if(s.length!=2)return;
					var values = s[1].split(',');
					var show_hours_minutes_group=false;
					switch(s[0]){
						case 'FREQ':
							$('#rrule_freq').val(values[0]);
							break;
						case 'INTERVAL':
							$('#rrule_interval').val(values[0]);
							break;
						case 'BYMONTH':
							$.each(values,function(i,v){
								$('input:checkbox.rrule_bymonth_inp.rrule_val_'+v).attr('checked',true).button('refresh');
							});
							break;
						case 'BYWEEKNO':
							$.each(values,function(i,v){
								$('input:checkbox.rrule_byweekno_inp.rrule_val_'+v).attr('checked',true).button('refresh');
							});
							break;
						case 'BYMONTHDAY':
							$.each(values,function(i,v){
								$('input:checkbox.rrule_bymonthday_inp.rrule_val_'+v).attr('checked',true).button('refresh');
							});
							break;
						case 'BYDAY':
							$.each(values,function(i,v){
								var arr = v.match(/(.+)(SU|MO|TU|WE|TH|FR|SA)/i)
								if( arr && 'undefined'!=typeof arr ){
									$('input:checkbox.rrule_bysetpos_inp.rrule_val_' + arr[1] ).attr('checked',true).button('refresh');
									$('input:checkbox.rrule_bywkst_inp.rrule_val_' + arr[2] ).attr('checked',true).button('refresh');
								}else{
									$('input:checkbox.rrule_bywkst_inp.rrule_val_'+v).attr('checked',true).button('refresh');
								}
							});
							break;
						case 'BYSETPOS':
							//-- loaded and set later.
							break;
						case 'WKST':
							$('#rr_wkst').val(values[0]);
							break;
						case 'BYHOUR':
							show_hours_minutes_group = true;
							$.each(values,function(i,v){
								$('input:checkbox.rrule_byhour_inp.rrule_val_'+v).attr('checked',true).button('refresh');
							});
							break;
						case 'BYMINUTE':
							show_hours_minutes_group = true;
							$.each(values,function(i,v){
								$('input:checkbox.rrule_byminute_inp.rrule_val_'+v).attr('checked',true).button('refresh');
							});
							break;
						case 'COUNT':					
							$('#rrule_repeat_end_type').val('count').trigger('change');
							$('#fc_end_count').val(values[0]);
							break;
						case 'UNTIL':
							$('#rrule_repeat_end_type').val('until').trigger('change');
							var d = new Date();
							d.setYear(values[0].substring(0,4));
							d.setMonth(values[0].substring(4,6)-1);
							d.setDate(values[0].substring(6,8));
							$('#rrule_until').val( $.fullCalendar.formatDate( d ,'yyyy-MM-dd') );
							break;
					}
					if(show_hours_minutes_group){
						$('.rrule_several_hours_inp').attr('checked',true).button('refresh').trigger('change');
					}
				});
			}
		}
		
		dg_refresh_rrule_dates();
		
		$('body').find('.fc-dialog')
			.css('margin-left', $(jsEvent.target).width() );
			
		setTimeout(function(){
			$('.rrule_inp_section,.fc_input')
				.unbind('change', cb_fc_input_change )
				.bind('change', cb_fc_input_change )
			;	
		},200);			
			
	});
}

function create_restore(){
	jQuery(document).ready(function($){
		$('.calendarize_meta_data').each(function(i,inp){
			$(inp).attr('data-value_backup', $(inp).val() );
		});
	});	
}

function do_restore(){
	jQuery(document).ready(function($){
		$('.calendarize_meta_data').each(function(i,inp){
			$(inp).val( $(inp).attr('data-value_backup') );
		});
	});	
}

function init_dialog(){
	jQuery(document).ready(function($){
		//--- create restore data
		create_restore();

		var dialog_options = {
				header:{
					left:'title',
					center:'',
					right:'prevYear,prev,next,nextYear'
				},
				dayClick:function( date, allDay, jsEvent, view ) { 
					$(".fc_start")
						.val( $.fullCalendar.formatDate(date,'yyyy-MM-dd') )
						.focus(); 
					$(".fc_start_fullcalendar_holder").hide();
				}
			};
			
		all_options = $.extend({},rh_calendar_options,dialog_options);	
			
		$('body').find('.fc-dialog')
			.draggable({
				handle:'.fc-hndle'
			})
			.find('.fc_start_fullcalendar_holder').show().end()
			.find('.fc_start_fullcalendar_holder .fc_start_fullcalendar').fullCalendar('destroy').fullCalendar(all_options).end()
			.find('.fc_end_fullcalendar_holder .fc_start_fullcalendar').fullCalendar('destroy').fullCalendar({
				header:{
					left:'title',
					center:'',
					right:'prevYear,prev,next,nextYear'
				},
				dayClick:function( date, allDay, jsEvent, view ) { 
					$(".fc_end")
						.val( $.fullCalendar.formatDate(date,'yyyy-MM-dd') )	
						.focus(); 
					$(".fc_start_fullcalendar_holder").hide();						
				}
			}).end()
			.find('.fc_end_interval_fullcalendar_holder .fc_start_fullcalendar').fullCalendar('destroy').fullCalendar({
				header:{
					left:'title',
					center:'',
					right:'prevYear,prev,next,nextYear'
				},
				dayClick:function( date, allDay, jsEvent, view ) { 
					$(".fc_end_interval")
						.val( $.fullCalendar.formatDate(date,'yyyy-MM-dd') )	
						.focus(); 
					$(".fc_start_fullcalendar_holder").hide();						
				}
			}).end()
			.find('.fc_start_fullcalendar_holder,.fc_end_fullcalendar_holder,.fc_end_interval_fullcalendar_holder').hide().end()		
			.find('.tabs a').click(function(e){
				var group = $(this).data('tab_group')||'none';
				$(this)
					.parent().parent()
						.find('.tabs').addClass('hide-if-no-js').removeClass('tabs').end()
						.parent()
							.find('.tabs-panel[data-tab_group="' + group + '"]')
								.removeClass('tab-open')
							.end()
							.find( $(this).attr('rel') )
								.addClass('tab-open')
							.end()
						.end()
					.end()
					.removeClass('hide-if-no-js').addClass('tabs')
					.end()	
				;
				return true;
			}).end()
			.find('a.first-tab').each(function(i,el){		
				$(el).trigger('click');
			}).end()	
			.hide()
		;
	});
}


function fc_dg_close(view, jsEvent){
	jQuery(document).ready(function($){
		$('body').find('.fc-dialog').fadeOut('fast');			
	});
}

function fc_event_resize( event, dayDelta, minuteDelta, revertFunc, jsEvent, ui, view ) {
	jQuery(document).ready(function($){
		//--
		if(event.end){
			var duration = parseInt((event.end.getTime() - event.start.getTime())/1000);
			if(duration){
				var end_time_str = $.fullCalendar.formatDate(_parseTime($('#fc_start_time').val()),'HH:mm:ss');
				var end_date_time = $.fullCalendar.parseDate( $('#fc_start').val() + ' ' + end_time_str );
				end_date_time.setSeconds( end_date_time.getSeconds()+duration );
				//--		
				$('#fc_end').val( $.fullCalendar.formatDate(end_date_time,'yyyy-MM-dd') );
				$('#fc_end_time').val( (event.allDay?'':$.fullCalendar.formatDate(end_date_time,'hh:mm tt')) );		
			}		
		}else{
			$('#fc_end').val( $('#fc_start').val() );
			$('#fc_end_time').val( '' );			
		}
	
		$('#calendarize').fullCalendar('refetchEvents');	
	});
}

function fc_event_drop( event, dayDelta, minuteDelta, allDay, revertFunc, jsEvent, ui, view ) { 
	jQuery(document).ready(function($){
		var is_repeat = false;
		//-- is repeat date?
		var fc_rdate = $('#fc_rdate').val();
		if(''!=fc_rdate){
			var source_date = $.fullCalendar.parseDate( event.fc_date_time );
			var rdates_array = exdate_to_array_of_dates( fc_rdate );
			for(var i=0;i<rdates_array.length;i++){
				if(source_date.getTime()==rdates_array[i].getTime()){
					is_repeat = true;
					break;
				}
			}
		}
		//--
		if(is_repeat){
			_remove_rdate( $.fullCalendar.formatDate(source_date,"yyyyMMdd'T'HHmmss") );
			add_rdate( event.start );
			
		}else{
			$('#fc_allday').val( (event.allDay?1:0) );
			$('#fc_start').val( $.fullCalendar.formatDate(event.start,'yyyy-MM-dd') );
			$('#fc_end').val( $.fullCalendar.formatDate( (event.end?event.end:event.start),'yyyy-MM-dd') );
			$('#fc_end_time').val( '' );		
			$('#fc_start_time').val( '' );
			
			if(!event.allDay){
				$('#fc_end_time').val( $.fullCalendar.formatDate(event.end,'hh:mm tt') );		
				$('#fc_start_time').val( $.fullCalendar.formatDate(event.start,'hh:mm tt') );
			}
		}		
		$('#calendarize').fullCalendar('refetchEvents');
	});
}

function _parseTime(timeString) {    
    if (timeString == '') return null;
	timeString = timeString.replace('.',':');
    var time = timeString.match(/(\d+)(:(\d\d))?\s*(p?)/i); 
    if (time == null) return null;

    var hours = parseInt(time[1],10);    
    if (hours == 12 && !time[4]) {
  		var time2 = timeString.match(/(\d+)(:(\d\d))?\s*(a?)/i);
		if(time2[4]){//12am?
			hours = 0;
		} 
    }
    else {
        hours += (hours < 12 && time[4])? 12 : 0;
    }   
    var d = new Date();             
    d.setHours(hours);
    d.setMinutes(parseInt(time[3],10) || 0);
    d.setSeconds(0, 0);  
    return d;
}

function add_rdate(_rdate){
	jQuery(document).ready(function($){
		var rdate = $.fullCalendar.parseDate( _rdate );
		if(!rdate){
			alert('Invalid date format ' + _rdate);
			return;
		}		
		var rdate_str = $.fullCalendar.formatDate(rdate,"yyyyMMdd'T'HHmmss");
		_remove_exdate(rdate_str);
		var rdates = $('#fc_rdate').val();
		var rdates_arr = rdates!=''?rdates.split(','):[];
		var added=false;
		for(a=0;a<rdates_arr.length;a++){
			if(rdates_arr[a]==rdate_str){
				added=true;
				break;
			}
		} 
		if(!added){
			rdates_arr[rdates_arr.length]=rdate_str;
		}
		rdates_arr.sort();
		$('#fc_rdate').val( rdates_arr.join(',') );
		
		fc_dg_close(null,null);
	});
}

function remove_rdate(o){
	jQuery(document).ready(function($){
		var rdate_str = $(o).attr('rel');
		_remove_rdate( rdate_str );
	});
}

function _remove_rdate(rdate_str){
	jQuery(document).ready(function($){
		var rdates = $('#fc_rdate').val();
		var rdates_arr = rdates!=''?rdates.split(','):[];
		var new_rdates_arr = [];
		for(a=0;a<rdates_arr.length;a++){
//			console.log(rdates_arr[a]);
//			console.log(rdate_str);
			if(rdates_arr[a]==rdate_str){
				continue;
			}
			new_rdates_arr[new_rdates_arr.length]=rdates_arr[a];
		} 
		rdates_arr = new_rdates_arr;
		rdates_arr.sort();
		$('#fc_rdate').val( rdates_arr.join(',') );
	});
}

function render_rdates(){
	jQuery(document).ready(function($){
		var rdate_str = $('#fc_rdate').val();
		var rdate_arr = rdate_str!=''?rdate_str.split(','):[];		
		$('.fc-repeat-dates').html('');
		if( rdate_arr.length>0 ){
			$('.fc-no-rdate').hide();
			$.each(rdate_arr,function(i,_rdate){
				var rdate = new Date( _rdate.substring(0,4), _rdate.substring(4,6)-1, _rdate.substring(6,8), _rdate.substring(9,11), _rdate.substring(11,13), _rdate.substring(13,15) );
				$('.fc-repeat-dates').append("<div class='repeat-date-item rhcalendar'>"+$.fullCalendar.formatDate(rdate,"yyyy-MM-dd HH:mm")+"<a class='ui-icon ui-icon-closethick' rel='"+_rdate+"' href='javascript:void(0);'>&nbsp;</a></div>");
			});
			
			$('.fc-repeat-dates')
				.find('.repeat-date-item a')
				.unbind('click')
				.bind('click', function(e){
					remove_rdate(this);
					render_rdates();
				});
		}else{
			$('.fc-no-rdate').show();
		}
		
	});
}

function add_exdate(_exdate){
	jQuery(document).ready(function($){
		var exdate = $.fullCalendar.parseDate( _exdate );
		var exdate_str = $.fullCalendar.formatDate(exdate,"yyyyMMdd'T'HHmmss");
		var exdates = $('#fc_exdate').val();
		var exdates_arr = exdates!=''?exdates.split(','):[];
		var added=false;
		for(a=0;a<exdates_arr.length;a++){
			if(exdates_arr[a]==exdate_str){
				added=true;
				break;
			}
		} 
		if(!added){
			exdates_arr[exdates_arr.length]=exdate_str;
		}
		exdates_arr.sort();
		$('#fc_exdate').val( exdates_arr.join(',') );
	});
}

function remove_exdate(o){
	jQuery(document).ready(function($){
		_remove_exdate( $(o).attr('rel') );
	});
}

function _remove_exdate(exdate_str){
	jQuery(document).ready(function($){
		var exdates = $('#fc_exdate').val();
		var exdates_arr = exdates!=''?exdates.split(','):[];
		var new_exdates_arr = [];
		for(a=0;a<exdates_arr.length;a++){
			if(exdates_arr[a]==exdate_str){
				continue;
			}
			new_exdates_arr[new_exdates_arr.length]=exdates_arr[a];
		} 
		exdates_arr = new_exdates_arr;
		exdates_arr.sort();
		$('#fc_exdate').val( exdates_arr.join(',') );
	});
}

function render_exdates(){
	jQuery(document).ready(function($){
		var exdate_str = $('#fc_exdate').val();
		var exdate_arr = exdate_str!=''?exdate_str.split(','):[];		
		$('.fc-excluded-dates').html('');
		if( exdate_arr.length>0 ){
			$('.fc-no-excluded').hide();
			$.each(exdate_arr,function(i,_exdate){
				var exdate = new Date( _exdate.substring(0,4), _exdate.substring(4,6)-1, _exdate.substring(6,8), _exdate.substring(9,11), _exdate.substring(11,13), _exdate.substring(13,15) );
				$('.fc-excluded-dates').append("<div class='excluded-date-item rhcalendar'>"+$.fullCalendar.formatDate(exdate,"yyyy-MM-dd HH:mm")+"<a class='ui-icon ui-icon-closethick' rel='"+_exdate+"' href='javascript:void(0);'>&nbsp;</a></div>");
			});
			
			$('.fc-excluded-dates')
				.find('.excluded-date-item a')
				.unbind('click')
				.bind('click', function(e){
					remove_exdate(this);
					render_exdates();	
				});			
		}else{
			$('.fc-no-excluded').show();
		}
		
	});
}

