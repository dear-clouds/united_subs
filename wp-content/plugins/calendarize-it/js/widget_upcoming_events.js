

function render_upcoming_events(options,events,date_options){
	jQuery(document).ready(function($){
		//this only work on chrome and opera.
		//start = new Date(options.start);
		//end = new Date(options.end);		
		start = $.fullCalendar.parseDate( options.start );
		end = $.fullCalendar.parseDate( options.end );

		if('undefined'!=typeof(options.loading_method) && options.loading_method=='ajax'){
			$.post(events.ajax_url,events,function(data){
				cb_events = [];
				if(data.R=='OK'){
					cb_events = data.EVENTS;
				}				
				//--callback		
				options.loading_method='server';
				render_upcoming_events(options,cb_events,date_options)
			},'json');
		
			return;
		}
	
		var render_events = [];
		if(events.length>0){
			$(events).each(function(i,e){
//				if( render_events.length > options.number ) return;
				
				e.fc_rrule = e.fc_rrule?e.fc_rrule:'';

				e.start = $.fullCalendar.parseDate( e.start );
				e.end = $.fullCalendar.parseDate( e.end );
				
				if(''==e.fc_rrule && ''==e.fc_rdate){
				//if(''==e.fc_rrule){
					//e.start = new Date(e.start);
					render_events[render_events.length]=e;
				}else{						
					var duration = false;
					if(e.end){
						duration = e.end.getTime() - e.start.getTime();
					}	

					var fc_start = e.start;
					e.fc_rrule = ''==e.fc_rrule?'FREQ=DAILY;INTERVAL=1;COUNT=1':e.fc_rrule;
					//scheduler = new Scheduler(fc_start, e.fc_rrule, true);

					scheduler = new Scheduler(fc_start, e.fc_rrule, true);
					if(e.fc_interval!='' && e.fc_exdate){
						//handle exception dates
						var fc_exdate_arr = exdate_to_array_of_dates(e.fc_exdate);
						if(fc_exdate_arr.length>0)
							scheduler.add_exception_dates(fc_exdate_arr);
					}	
					if(e.fc_rdate && e.fc_rdate!=''){
						//handle rdates
						var fc_rdate_arr = exdate_to_array_of_dates(e.fc_rdate);
						if(fc_rdate_arr.length>0)
							scheduler.add_rdates(fc_rdate_arr);
					}	

					occurrences = scheduler.limited_occurrences(start, end, options.number);				
					if(occurrences.length>0){
						var k = 0;
						$(occurrences).each(function(i,o){
//							if( render_events.length > options.number ) return;
							var new_start = new Date(o);
						
							var p = $.extend(true, {}, e);
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
							p.using_calendar_url = options.using_calendar_url?true:false;
							p.repeat_instance = true;
							p = _add_repeat_instance_data_to_event(p);							
							render_events[render_events.length]=p;
						});
					}
				}
			});
			
			if(options.horizon && options.horizon=='hour'){
				var tmp = [];
				var _now = new Date();
				if(options.historic){
					_now = $.fullCalendar.parseDate( options.specific_date );
				}
				for(var a=0;a<render_events.length;a++){
					if(  render_events[a].start.getTime() < _now.getTime() )
						continue;
					tmp[tmp.length]=render_events[a];	
				}
				render_events = tmp;
			}else{
				//handle a situation where repeat events are added and have
				//a  date before the start date
				var tmp = [];
				var _now = new Date();		
				if(options.historic){
					_now = $.fullCalendar.parseDate( options.specific_date );
					
				}							
				for(var a=0;a<render_events.length;a++){
					var event_start = new Date(render_events[a].start);
					_now.setHours(0,0,0,0);
					event_start.setHours(0,0,0,0);
					
					if(  event_start.getTime() < _now.getTime() )
						continue;
					tmp[tmp.length]=render_events[a];	
				}
				render_events = tmp;
			}
			
			render_events.sort( rhc_sort_events );
			render_events = render_events.slice(0, options.number );
		
			var sel = '#'+options.sel;
			var tpl = $(sel).parent().find('.rhc-widget-template div')[0];
			$(sel).empty();
			var done_days = [];
			$.each(render_events,function(i,e){				
				/*
				if(e.gotodate||e.event_rdate){
					var href = 'javascript:rhc_widget_link_click("'+e.url+'","'+e.gotodate+'","'+e.event_rdate+'")';
				}else{
					var href = e.url;
				}
				*/
				var href = e.url;
				var str = $(tpl).clone();		
				str
					.find('.rhc-title-link')
						.html( e.title )
						.data('rhc_event',e)
						.attr('href', href )
						.end()
					.find('.rhc-description').html( e.description ).end()
					.find('.rhc-widget-date').html('').end()
					.find('.rhc-widget-time').html('').end()
					;
				
				if(''!=options.fcdate_format){
					str.find('.rhc-widget-date').html( $.fullCalendar.formatDate(e.start,options.fcdate_format,date_options) );
				}
			
				if(''!=options.fctime_format && !e.allDay){
					str.find('.rhc-widget-time').html(  $.fullCalendar.formatDate(e.start,options.fctime_format,date_options) );
				}
				
				//--- date parts
				str.find('.rhc-date-start').each(function(i,el){
					$(el).html( $.fullCalendar.formatDate(e.start, $(el).html(), date_options) );				
				});
				//--//rhc-featured-date 
				var done_day = $.fullCalendar.formatDate(e.start,'yyyyMMdd',date_options);
				if( -1==$.inArray(done_day,done_days) ){
					done_days.push(done_day);
				}else{
					str.find('.hide-repeat-date').addClass('repeated-date');
				}
				//---
				
				if(options.showimage==1){
					str.addClass('featured-1');
					if( e.image && e.image[0] && e.image[0]!='' ){
						$('<a></a>')
							.addClass('rhc-image-link')
							.data('rhc_event',e)
							.attr('href',href)
							.append( $('<img></img>').attr('src',e.image[0]) )
							.appendTo( str.find('.rhc-widget-upcoming-featured-image') )
						;
					}
				}else{
					str.addClass('featured-0');
					str.find('.rhc-widget-upcoming-featured-image').remove();
				}
				
				$(str).find('.rhc-title-link').on('click',function(_e){
					var args = {url: e.url}
					if(e.gotodate){
						args.gotodate = e.gotodate;
					}
					if(e.event_rdate){
						args.event_rdate = e.event_rdate;
					}
					rhc_widget_link_click(args);	
				});
				
				if(str.find('.move-out').length>0){
					str.find('.move-out').appendTo(sel);
				}
				
				str.appendTo(sel);
			});		
			$(sel).append('<div class="rhc-clear"></div>');
		}			
	});
}

function rhc_widget_link_click(calEvent){
	if(calEvent.event_rdate || calEvent.gotodate){
		jQuery('form#calendarizeit_repeat_instance').remove();
		var form = '<form id="calendarizeit_repeat_instance" method="post"></form>';
		jQuery(form)
			.attr('action',calEvent.url)
			.appendTo('BODY')	
		;
		if(calEvent.gotodate){
			jQuery('<input type="hidden" name="gotodate" value="' + calEvent.gotodate + '"/>')
				.appendTo('form#calendarizeit_repeat_instance')
			;
		}
		if(calEvent.event_rdate){
			jQuery('<input type="hidden" name="event_rdate" value="' + calEvent.event_rdate + '" />')
				.appendTo('form#calendarizeit_repeat_instance')
			;
		}
		jQuery('form#calendarizeit_repeat_instance').submit();	
	}else{
		window.open(calEvent.url);
	}
	return false;
}

function rhc_sort_events(o,p){
	if(o.start>p.start){
		return 1;
	}else if(o.start<p.start){
		return -1;
	}else{
		return 0;
	}
}

jQuery(document).ready(function($){
	$('.rhc-title-link,.rhc-image-link').on('click',function(e){
		var calEvent = $(this).data('rhc_event');
		if(calEvent){
			rhc_widget_link_click(calEvent);
			return false;		
		}
		return true;
	});	
});