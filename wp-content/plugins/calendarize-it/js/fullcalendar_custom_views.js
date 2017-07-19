//custom fullCalendar views created for calendarize-it.

(function($){

$.fullCalendar.views.WeekEventList = WeekEventList;	
function WeekEventList(element, calendar) {
	var t = this;
	var body;
	var addDays = $.fullCalendar.addDays;
	var cloneDate = $.fullCalendar.cloneDate;
	var formatDates = $.fullCalendar.formatDates;
	
	options = calendar.options;
	// imports
	EventView.call(t, element, calendar );

	// exports
	t.render = render;
	t.viewChanged = viewChanged;
	function render(date, delta) {

		if (delta) {
			addDays(date, delta * 7);
		}

		var start = addDays(cloneDate(date), -((date.getDay() - opt('firstDay') + 7) % 7));
		var end = addDays(cloneDate(start), 7);

		var visStart = cloneDate(start);
		//skipHiddenDays(visStart);

		var visEnd = cloneDate(end);
		//skipHiddenDays(visEnd, -1, true);

		//var colCnt = getCellsPerWeek();

		if( calendar.options.titleFormat.week ){
			calendar.options.titleFormat.week = calendar.options.titleFormat.week.replace(/&#91;/g,'[');
			calendar.options.titleFormat.week = calendar.options.titleFormat.week.replace(/&#93;/g,']');
			t.title = formatDates(
				visStart,
				addDays(cloneDate(visEnd), -1),
				calendar.options.titleFormat.week,
				calendar.options
			);				
		}

		t.start = start;
		t.end = end;
		t.visStart = visStart;
		t.visEnd = visEnd;

		//---
		var firstTime = !body;
		if(firstTime){
			$('<div class="fc-events-holder"></div>').appendTo(element);
			body = true;
		}else{
			 
		}		
	}
	
	function viewChanged(){
	
	}
	
	function opt(name, viewNameOverride) {
		var v = options[name];
		return v;
	}	
}

$.fullCalendar.views.rhc_event = EventView;	
function EventView(element, calendar) {
	var t = this;
	var body;
	t.name = 'rhc_event';
	t.render = render;
	t.unselect = unselect;
	t.setHeight = setHeight;
	t.setWidth = setWidth;
	t.clearEvents = clearEvents;
	t.renderEvents = renderEvents;
	t.trigger = trigger;
	t.viewChanged = viewChanged;
	t.beforeAnimation = beforeAnimation;
	t.setEventData = setEventData; //fc 1.64
	t.clearEventData = clearEventData;//fc 1.64
	t.triggerEventDestroy = triggerEventDestroy;//fc 1.64
	
	t.element = element;
	t.oldView = null;
	//not part of fc api.
	t.calendar = calendar;//needed for clicking event title.
	fc = $.fullCalendar;
	//--
	t.direction = 0;//direction in wich the user is navigating.
	t.first_date = null;
	t.scroll_lockdown = false;
	t.loading = loading;
	t.have_events = false;
	t.rendered_events = [];
	
	if( calendar.options.eventList.daysahead && parseInt( calendar.options.eventList.delta ) > parseInt( calendar.options.eventList.daysahead )  ){
		calendar.options.eventList.delta = calendar.options.eventList.daysahead;
	}
	
	function viewChanged(oldView){
		if(oldView){
			if( oldView.visStart && oldView.visEnd ){
				t.title = oldView.title;
				//t.visStart = oldView.visStart;
				t.visStart = oldView.start;
				t.visEnd = oldView.visEnd;
				t.oldView = oldView;

				if( calendar.options.eventList.upcoming && calendar.options.eventList.upcoming=='1' ){
					var _now = new Date();
					t.visStart = t.visStart.getTime() > _now.getTime() ? t.visStart : _now ;
				}		
				
				var months = calendar.options.eventList.monthsahead?calendar.options.eventList.monthsahead:'';
				months = months.replace(' ','')==''?1:parseInt(months);	
				if( months>0 ){
					var _visEnd = new Date( t.visStart );
					_visEnd.setMonth( _visEnd.getMonth() + months );
					t.visEnd = _visEnd;		
				}	
				
				var days = calendar.options.eventList.daysahead?calendar.options.eventList.daysahead:'';
				days = days.replace(' ','')==''?0:parseInt(days);	
				if( days>0 ){
					var _visEnd = new Date( t.visStart );
					_visEnd.setDate( _visEnd.getDate() + days - 1 );
					_visEnd.setHours(23,59,59);
					t.visEnd = _visEnd;						
				}						
			}	
		}
	}

	
	function setEventData( events ){
/*		events.splice(3,5);
console.log('setEventData', typeof events );
console.log(events);	
*/
	}
	
	function clearEventData(){
	
	}
	
	function triggerEventDestroy(){
	
	}
	
	//not part of fc api.
	function beforeAnimation(oldView){
		
	}

	function render(date,delta){	

		var stack = calendar.options.eventList.stack && parseInt(calendar.options.eventList.stack)==1 || false ;
		t.direction = delta;
		custom_delta = parseInt( calendar.options.eventList.delta );
		custom_delta = isNaN(custom_delta) ? 0 : custom_delta;
		date_changed = false;
		if( stack && custom_delta > 0 && t.first_date && t.direction < 0 && date > t.first_date ){
			date = fc.cloneDate( t.first_date );
			date_changed=true;
		}
	
		if( t.direction == 0 ){
			t.first_date = fc.cloneDate( date );
		}else if( t.direction < 0 && t.first_date < date ){
			t.first_date = fc.cloneDate( date );
		}

		if(delta && (custom_delta > 0) ){
			fc.addDays( date, custom_delta*delta );
			delta=0;
		}

		if(date_changed){
			calendar.gotoDate(date);//change the calendar current date
		}
		
		if(custom_delta > 0){
			start = fc.cloneDate(date, true);
			end = fc.addDays( fc.cloneDate(start), custom_delta );		
			_end = fc.cloneDate( end );					
		}else{
			_end = false;
		}
	
		//----------------------------------------------------------------
		t.start = fc.cloneDate(date, true);//if not defined, hidden views do not update size on window resize.
		var firstTime = !body;
		if(firstTime){
			$('<div class="fc-events-holder"></div>').appendTo(element);
			body = true;
		}else{
			 
		}

		if(t.oldView){
		
		}else{
			t.oldView = new $.fullCalendar.views['month']( $('<div>') ,calendar);
//			calendar.gotoDate(date);//this produces a double load. i dont remember what this was for. but it no longer seems aplicable
		}

		if(t.oldView){	
			if( custom_delta ){		
				t.oldView.render( fc.cloneDate(date), delta );
			}else{
				t.oldView.render( date, delta ); //allow the regular view to modify date when custom delta not used.
			}
			_end = false===_end ?  fc.cloneDate( t.oldView.visEnd ) : _end ;

			if( t.oldView.visStart && t.oldView.visEnd ){
				t.title = t.oldView.title;
				if(custom_delta){
					t.start 	= fc.cloneDate( start );
					t.end 		= fc.cloneDate( end );
					t.visStart 	= fc.cloneDate( start );
					t.visEnd 	= fc.cloneDate( end );							
				}else{
					t.start 	= fc.cloneDate( t.oldView.start );
					t.end 		= fc.cloneDate( t.oldView.end );
					t.visStart 	= fc.cloneDate( t.oldView.start );
					t.visEnd 	= fc.cloneDate( t.oldView.visEnd );				
				}
		
				if( calendar.options.eventList.TitleFormat ){
					calendar.options.eventList.TitleFormat = calendar.options.eventList.TitleFormat.replace(/&#91;/g,'[');
					calendar.options.eventList.TitleFormat = calendar.options.eventList.TitleFormat.replace(/&#93;/g,']');
					t.title = fc.formatDates(
						fc.cloneDate( t.visStart ),
						fc.addDays( fc.cloneDate( _end ), -1),
						calendar.options.eventList.TitleFormat,
						calendar.options
					);				
				}
			}		
		}

		if( calendar.options.eventList.upcoming && calendar.options.eventList.upcoming=='1' ){
			var _now = new Date();
			_now.setHours(0,0,0);//set the first hour of the day for the cache.
			dayspast = calendar.options.widgetlist.dayspast || 0 ;
			_now.setDate(_now.getDate()-parseInt(dayspast));		
			t.visStart = t.visStart.getTime() > _now.getTime() ? t.visStart : _now ;
		}

		var months = calendar.options.eventList.monthsahead?calendar.options.eventList.monthsahead:'';
		months = months.replace(' ','')==''?( custom_delta > 0 ? 0 : 1 ):parseInt(months);	
		if( months>0 ){
			var _visEnd = new Date( t.visStart );
			_visEnd.setMonth( _visEnd.getMonth() + months );
			t.visEnd = _visEnd;		
		}
		
		var days = calendar.options.eventList.daysahead?calendar.options.eventList.daysahead:'';
		days = days.replace(' ','')==''?0:parseInt(days);	
		if( days>0 ){
			var _visEnd = new Date( t.visStart );
			_visEnd.setDate( _visEnd.getDate() + days - 1 );
			_visEnd.setHours(23,59,59);
			t.visEnd = _visEnd;									
		}			
				
		//-- auto scroll
		if( parseInt(calendar.options.eventList.auto) && parseInt(calendar.options.eventList.stack) ){
			var _id = $(element).parents('.rhc_holder').attr('id');
			if( 'undefined' == typeof $(document).data( 'rhc_event_scroll' ) ){
				$(document).data( 'rhc_event_scroll' , _id )
				jQuery(document).scroll(function(){ rhc_event_scroll( _id ); });
			}
		}
	}
	
	function rhc_event_scroll( id ){
		if( false===t.have_events ) return;
		var _view = $('#' + id + ' .fc-view-rhc_event');
		if( _view.is(':visible') && !t.scroll_lockdown){
			//console.log( 'scrolled and not loading' );	
			// Get the positon of the more_items div if all your items are ind objects and they push down the more_item will it alwase be in a different pos
			var items_div = $(_view).parents('.rhc_holder');//$(_view).find('.fc-events-holder');
			var items_div_offset = items_div.offset();
			// extra calibration for mobil phones
			if (window.mobile){
				paddingForMobile = 1000;
			}else{
				paddingForMobile = 0;
			}

			if( ($(window).scrollTop() + $(window).height()) == $(document).height() ){
				//scroll hit the bottom
				t.scroll_lockdown = true;
				$(_view).parents('.rhc_holder').find('.fullCalendar').fullCalendar('next');				
			}else{
				//bottom of list passed a certain offset
				var _offset =  ( calendar.options.eventList.scrolloffset && ''!=calendar.options.eventList.scrolloffset ) ? calendar.options.eventList.scrolloffset : ( $(window).height() / 2 );
				var _offset = _offset -paddingForMobile ; 
				document_bottom = $(document).scrollTop()+$(window).height();
				bottom_position = items_div_offset.top + items_div.outerHeight();				
				if ( document_bottom > (bottom_position + _offset) ){
					t.scroll_lockdown = true;
					$(_view).parents('.rhc_holder').find('.fullCalendar').fullCalendar('next');
				}
			}						
		}
	}
	
	function unselect(){

	}
	function setHeight(h){
		//element.css('min-height',h);
		element.css('min-height','200px');
		element.css('height','auto');
	}
	function setWidth(){/*console.log('setWidth');*/}
	function clearEvents(){

	}
	function renderEvents(_events, modifiedEventId){
		var view_template = $(rhc_event_tpl);
		var item_template = view_template.find('.fc-event-list-item').clone().removeClass('fc-remove');
		var date_template = view_template.find('.fc-event-list-date').clone().removeClass('fc-remove');
		var no_events_template = view_template.find('.fc-event-list-no-events').clone().removeClass('fc-remove');
		if(calendar.options.eventList && calendar.options.eventList.eventListNoEventsText){
			no_events_template.find('.fc-no-list-events-message').html(calendar.options.eventList.eventListNoEventsText);
		}
		
		//--support widget templates
		widget_templates = false;
		if( calendar.options.eventList && calendar.options.eventList.eventlist_template && ''!=calendar.options.eventList.eventlist_template ){
			if( $(calendar.options.eventList.eventlist_template).length>0 ){
				widget_templates = true;
				item_template = $(calendar.options.eventList.eventlist_template).find('.rhc-widget-upcoming-item');
			}		
		}
		//---
		var stack_events = calendar.options.eventList.stack && '1'==calendar.options.eventList.stack ? true :false;
		
		if( stack_events && t.direction > 0 ){
			var _fc_events_holder = element.find('.fc-events-holder');//stack behavior.
		}else{
			var _fc_events_holder = element.find('.fc-events-holder').empty();
			t.rendered_events = [];
		}

		view_template
			.appendTo( _fc_events_holder )
			.find('.fc-remove').remove();
					
		if( stack_events ){
			$(_fc_events_holder).find('.fc-event-list-no-events').parents('.fc-event-list-container').remove();
		}					
					
		if(_events.length>0){		
			t.have_events = true;
			if(widget_templates){
				//widget template based render.
				var date_options = calendar.options;
				var options = calendar.options.widgetlist;
				var render_events=_events;		
				var sel = '#'+options.sel;
				options.dayspast = options.dayspast?options.dayspast:0;
				 				
				var vis_end = $.fullCalendar.parseDate( options.end );			
				if(options.horizon && ( options.horizon=='hour' || options.horizon=='end') ){
					var tmp = [];
					var _now = new Date();					
					_now.setDate(_now.getDate()-options.dayspast);				

					if(options.historic && options.historic=='1'){
						_now = $.fullCalendar.parseDate( options.specific_date );
					}
								
					for(var a=0;a<render_events.length;a++){
						if( render_events[a].end && options.horizon=='end' ){
							if(  render_events[a].end.getTime() < _now.getTime() )
								continue;						
						}else{
							if(  render_events[a].start.getTime() < _now.getTime() )
								continue;
						}
						
						if(  render_events[a].start.getTime() > vis_end.getTime() )
							continue;
							
						tmp[tmp.length]=render_events[a];	
					}
					render_events = tmp;
				}else{
					//handle a situation where repeat events are added and have
					//a  date before the start date
					var tmp = [];
					var _now = new Date();	
					_now.setDate(_now.getDate()-options.dayspast);	
					if(options.historic){
						if(''!=options.specific_date){
							_now = $.fullCalendar.parseDate( options.specific_date );
						}					
					}							
					for(var a=0;a<render_events.length;a++){
						var event_start = new Date(render_events[a].start);
						_now.setHours(0,0,0,0);
						event_start.setHours(0,0,0,0);
						
						if(  event_start.getTime() < _now.getTime() )			
							continue;

						if(  event_start.getTime() > vis_end.getTime() )	
							continue;
							
						tmp[tmp.length]=render_events[a];	
					}
					render_events = tmp;
				}
					
				render_events.sort( _rhc_sort_events );	
				//handle premiere
				if( options.premiere && options.premiere=='1' ){
					//real premiere
					var tmp = [];
					for(var a=0;a<render_events.length;a++){								
						if( render_events[a].premiere ){
							tmp[tmp.length]=render_events[a];						
						}	
					}
					render_events = tmp;					
				}else if( options.premiere && options.premiere=='2' ){
					//first event in a requested range
					var done_event_ids = [];
					var tmp = [];
					for(var a=0;a<render_events.length;a++){		
						if( $.inArray( render_events[a]._id, done_event_ids ) > -1 ){
							continue;
						}						
						done_event_ids.push( render_events[a]._id );
						tmp.push( render_events[a] );	
					}
					render_events = tmp;	
				}
				//--					
				
				render_events = render_events.slice(0, options.number );				
				
				var done_days = [];//for eventlist widget supppport.	
				$.each(render_events,function(i,ev){
					var item = item_template.clone();
					//-- support widget templates:
					var e = ev;
					var desc = e.description.split(' ');
					desc = desc.slice(0, options.words);
					e.description = desc.join(' ');
					//--
					if( options.using_calendar_url && ''!=options.using_calendar_url ){
						e.url = options.using_calendar_url; 
					}
					var href = e.url;
		
					var str = item_template.clone();
					str
						.find('.rhc-title-link')
							.html( e.title )
							.data('rhc_event',e)
							.attr('href', href )
							.end()
						.find('.rhc-event-link')
							.data('rhc_event',e)
							.attr('href', href )
							.end()
						.find('.rhc-description').html( e.description ).end()
						.find('.rhc-widget-date').html('').end()
						.find('.rhc-widget-time').html('').end()
						.find('.rhc-widget-end-date').html('').end()
						.find('.rhc-widget-end-time').html('').end()
						;
					
					if(''!=options.fcdate_format){
						str.find('.rhc-widget-date').html( $.fullCalendar.formatDate(e.start,options.fcdate_format,date_options) );
						str.find('.rhc-widget-end-date').html( $.fullCalendar.formatDate(e.end,options.fcdate_format,date_options) );
						//-- start end range
						dstart = $.fullCalendar.formatDate(e.start,'yyyy-MM-dd',date_options);
						dend = $.fullCalendar.formatDate(e.end,'yyyy-MM-dd',date_options);
						var diff =  Math.floor(( Date.parse(dend) - Date.parse(dstart) ) / 86400000);
						if( diff>0 ){
							tmp = $.fullCalendar.formatDate(e.start,options.fcdate_format,date_options) + ' &#8211; ' + $.fullCalendar.formatDate(e.end,options.fcdate_format,date_options);
							str.find('.rhc-widget-date-range').html( tmp );
							str.find('.rhc-day_diff0').hide();
						}else{
							str.find('.rhc-widget-date-range').html( $.fullCalendar.formatDate(e.start,options.fcdate_format,date_options) );
							str.find('.rhc-day_diff1').hide();
						}
						//--
					}
				
					if(''!=options.fctime_format && !e.allDay){
						str.find('.rhc-widget-time').html(  $.fullCalendar.formatDate(e.start,options.fctime_format,date_options) );
						str.find('.rhc-widget-end-time').html(  $.fullCalendar.formatDate(e.end,options.fctime_format,date_options) );
					}else{
						//str.find('.rhc-widget-date-time').hide();
					}
					
					if(e.allDay){
						str.addClass('fc-is-allday');
						str.find('.rhc-widget-time').hide();
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
					
					$(str).find('.rhc-title-link,.rhc-event-link,.rhc-image-link').click(function(_e){
						var args = {url: e.url}
						if(e.gotodate){
							args.gotodate = e.gotodate;
						}
						if(e.event_rdate){
							args.event_rdate = e.event_rdate;
						}
						return _rhc_widget_link_click(args,this);	
					});
					//--terms
					item=str;
					item.find('.fc-event-term')
						.empty().hide()
						.parent().addClass('rhc_event-empty-taxonomy')
					;
					if(ev.terms && ev.terms.length>0){
						$.each(ev.terms,function(i,t){		
							if( item.find('.taxonomy-'+t.taxonomy).parent().find('a').length>0 ){
								item.find('.taxonomy-'+t.taxonomy).parent().append( '<span class="rhc-event-list tax-term-divider"></span>' );
							}
													
							if( t.name && ''!=t.name && item.find('.taxonomy-'+t.taxonomy).length>0 ){
								if( t.url=='' ){
									$('<span>'+ t.name +'</span>')
										.appendTo( item.find('.taxonomy-'+t.taxonomy).show().parent().removeClass('rhc_event-empty-taxonomy') )
									;	
								}else{
									$('<a>'+ t.name +'</a>')
										.attr('href',t.url)
										.appendTo( item.find('.taxonomy-'+t.taxonomy).show().parent().removeClass('rhc_event-empty-taxonomy') )
									;								
								}
		
							}
							
							if( item.find('.taxonomy-'+t.taxonomy+'-gaddress').length>0 && t.gaddress && t.gaddress!=''){
								if( item.find('.taxonomy-'+t.taxonomy+'-gaddress' ).parent().find('a').length>0 ){
									item.find('.taxonomy-'+t.taxonomy+'-gaddress' ).parent().append( '<span class="rhc-event-list tax-term-divider"></span>' );
								}							
								
								var _url = 'http://www.google.com/maps?f=q&hl=en&source=embed&q=' + escape(t.gaddress);
								$('<a>'+ t.gaddress +'</a>')
									.attr('href', _url)
									.attr('target','_blank')
									.appendTo( item.find('.taxonomy-'+t.taxonomy+'-gaddress' ).show().parent().removeClass('rhc_event-empty-taxonomy').end() )
								;	
							}
							
							for(var term_property in t) {
								if( term_property=='taxonomy' ) continue;
								term_property_value = t[term_property];
								if( item.find('.taxonomy-'+t.taxonomy+'-'+term_property).length>0 && term_property_value!=''){
									$('<span>'+ term_property_value +'</span>')
										.appendTo( item.find('.taxonomy-'+t.taxonomy+'-'+term_property) )
									;	
								}
							}								
						});
					}
					//-----------------------------------------------------------------							
					if(str.find('.move-out').length>0){
						str.find('.move-out').appendTo(sel);
					}		
					
					triggerRes = trigger('eventRender', ev, ev, str);
					if(false===triggerRes){
					
					}else{
						view_template.find('.fc-event-list-holder').append(str);
					}					
					trigger('loading', null, false);
					return;		
				});
			}else{
				calendar.options.widgetlist.dayspast = calendar.options.widgetlist.dayspast?calendar.options.widgetlist.dayspast:0;
				//default original view render
				events = [];
				var now = new Date();
				now.setDate(now.getDate()-calendar.options.widgetlist.dayspast);
				$.each(_events,function(i,ev){
					if(stack_events && t.rendered_events.length>0){
						//prevent repeating events when stacking is active.
						for(var a=0; a<t.rendered_events.length; a++){
							test_event = t.rendered_events[a];
							if( 'function'==typeof test_event.start.getTime && 'function'==typeof ev.start.getTime ){				
								if(test_event.id==ev.id && test_event.start.getTime()==ev.start.getTime() )return;
							}
						};
					}

					t.rendered_events.push(ev);

					if(calendar.options.eventList && 1==parseInt(calendar.options.eventList.removeended) ){
						if(ev.end!=null && ev.end<now)return;				
					}
					
					if(calendar.options.eventList && calendar.options.eventList.outofrange=='1'){
						//if(ev.end!=null && ev.start<t.visStart && ev.end<t.visEnd)return;
						if(ev.end!=null){
							if(ev.end<t.visStart)return;
						}
					}else{
						if(ev.start<t.visStart)return;
						if(ev.start>t.visEnd)return;				
					}
					events[events.length]=ev;
				});
				if(events.length==0)return;
				//---
				if( '1'==calendar.options.eventList.reverse ){
					events.sort(_rsort_events);
				}else{
					events.sort(_sort_events);
				}
				
				var extended_details_ids = [];
				var extended_details = calendar.options.eventList.extendedDetails && '1'==calendar.options.eventList.extendedDetails ? true : false;
				var last_date = '';		
				var done_days = [];//for eventlist widget supppport.	
				$.each(events,function(i,ev){
				
					if( 'undefined'!=typeof(calendar.options.eventList.display) && calendar.options.eventList.display>0 ){
						if(i>=calendar.options.eventList.display)return;
					}
					
					var item = item_template.clone();
					
					if(ev.gcal || ev.url==''){
						item
							.find('.fc-event-list-title').parent()
							.empty()
							.append( $('<span></span>').addClass('fc-event-list-title').html(ev.title) )
						;
					}else if(ev.direct_link){
						item
							.find('.fc-event-list-title').html(ev.title).end()
							.find('a.fc-event-link')
								.attr('href',ev.url)	
								.end()	
						;
					}else{
						item
							.find('.fc-event-list-title').html(ev.title).end()
							.find('a.fc-event-link')
								.attr('target','')
								.attr('href','javascript:void(0);')	
								.bind('click',function(e){
									var click_method = calendar.options.eventClick?calendar.options.eventClick:fc_click;
									click_method(ev,e,t);
								})
								.end()	
						;
					}
//extended_details=true;//force extended details
					var local_feed = ev.local_feed ? true : false;					
					if(extended_details && local_feed){									
						item.find('.fe-extrainfo-container')
							.addClass('skip-render')
							.addClass('ext_det_'+ev.id)
							.hide()
							.data('ev',ev)
							.before('<div class="ext-list-loading loading-events"><div class="ext-list-loading-1 ajax-loader loading-events"><div class="ext-list-loading-2x xspinner icon-xspinner-3"></div></div></div>')
							;
							
						if(-1==$.inArray(ev.id,extended_details_ids) ){
							extended_details_ids.push(ev.id);
						}	
					}
					
					if( true ){		
						//regular template
						//-----------------------------------------------------------------
						item
							.find('.fc-event-list-description').html(ev.description).end()
						;
		
						if( ev.description && ''==ev.description.replace(' ','') ){
							item.find('.fc-event-list-description').addClass('rhc-empty-description');
						}
						
						if(ev.fc_click_link=='none'){
							item.find('a.fc-event-link').addClass('fc-no-link');
						}
						
						//--thumbnail
						if(ev.image&&ev.image[0]){
							item.find('img.fc-event-list-image').attr('src',ev.image[0]);
						}else{
							item.find('.fc-event-list-featured-image').empty();
						}	
						//--hour
						if(ev.allDay){
							item.find('.fc-time').remove();
							item.find('.fc-end-time').remove();
							var _start_date_format = calendar.options.eventList.extDateFormat||'dddd MMMM d, yyyy.';
						}else{
							item.find('.fc-time').html( $.fullCalendar.formatDate(ev.start,'h:mmtt') );
							item.find('.fc-end-time').html( $.fullCalendar.formatDate(ev.end,'h:mmtt') );
							var _start_date_format = calendar.options.eventList.extDateFormat||'dddd MMMM d, yyyy.';
						}

						//--start
						if(ev.start){
							item.find('.fc-start').html( $.fullCalendar.formatDate(ev.start,_start_date_format,calendar.options) );
						}else{
							item.find('.fc-start').remove();
						}
						//--end
						if(ev.end){
							item.find('.fc-end').html( $.fullCalendar.formatDate(ev.end,_start_date_format,calendar.options) );
						}else{
							item.find('.fc-end')
								.parent().addClass('rhc_event-empty-taxonomy').end()
								.remove()
								
							;
						}
						//--remove link
						item.find('.fc-event-link.fc-event-list-title').each(function(i,el){				
							if( parseInt( RHC.disable_event_link ) && 'javascript:void(0);' == $(el).attr('href') ){
								$(el).replaceWith( $(el).text() );
							}
						});
						//--terms
						item.find('.fc-event-term')
							.empty().hide()
							.parent().addClass('rhc_event-empty-taxonomy')
						;
						if(ev.terms && ev.terms.length>0){
							$.each(ev.terms,function(i,t){		
								if( item.find('.taxonomy-'+t.taxonomy).parent().find('a').length>0 ){
									item.find('.taxonomy-'+t.taxonomy).parent().append( '<span class="rhc-event-list tax-term-divider"></span>' );
								}
														
								if( t.name && ''!=t.name && item.find('.taxonomy-'+t.taxonomy).length>0 ){
									if( t.url=='' ){
										$('<span>'+ t.name +'</span>')
											.appendTo( item.find('.taxonomy-'+t.taxonomy).show().parent().removeClass('rhc_event-empty-taxonomy').end() )
										;	
									}else{
										$('<a>'+ t.name +'</a>')
											.attr('href',t.url)
											.appendTo( item.find('.taxonomy-'+t.taxonomy).show().parent().removeClass('rhc_event-empty-taxonomy').end() )
										;								
									}
			
								}
								
								if( item.find('.taxonomy-'+t.taxonomy+'-gaddress').length>0 && t.gaddress && t.gaddress!=''){
									if( item.find('.taxonomy-'+t.taxonomy+'-gaddress' ).parent().find('a').length>0 ){
										item.find('.taxonomy-'+t.taxonomy+'-gaddress' ).parent().append( '<span class="rhc-event-list tax-term-divider"></span>' );
									}							
									
									var _url = 'http://www.google.com/maps?f=q&hl=en&source=embed&q=' + escape(t.gaddress);
									$('<a>'+ t.gaddress +'</a>')
										.attr('href', _url)
										.attr('target','_blank')
										.appendTo( item.find('.taxonomy-'+t.taxonomy+'-gaddress' ).show().parent().removeClass('rhc_event-empty-taxonomy').end() )
									;	
								}
							});
						}
						
						if( ev.meta && ev.meta.length > 0 ){
							$.each( ev.meta, function(i,m){
								sel = '.fc-event-meta-' + m[0];
								val = m[1];
								item
									.find(sel).html(val).end()
								;	
															
							});
						}

						//-----------------------------------------------------------------						
					}
					
					triggerRes = trigger('eventRender', ev, ev, item);
					if(false===triggerRes){
					
					}else{
						if( calendar.options.eventList.ShowHeader && parseInt(calendar.options.eventList.ShowHeader)==1){
							var header_date = ev.start;
							if($.fullCalendar.formatDate(header_date,'yyyyMMdd')!=$.fullCalendar.formatDate(last_date,'yyyyMMdd')){
								last_date = header_date;
								var date_str = date_template.clone();
								date_str.find('.fc-event-list-date-header').html( $.fullCalendar.formatDate(ev.start, calendar.options.eventList.DateFormat||'dddd MMMM d, yyyy',calendar.options) );
								view_template.find('.fc-event-list-holder').append(date_str);
							}				
						}
						
						view_template.find('.fc-event-list-holder').append(item);
					}
				});	
				
				if( extended_details_ids.length>0 ){
					if( 'undefined'==typeof calendar.extended_detail_cache ){
						calendar.extended_detail_cache = {};
					}
				
					var pending_extended_details_ids = [];
					$.each(extended_details_ids,function(i,id){
						if( 'undefined' == typeof calendar.extended_detail_cache[id] ){
							pending_extended_details_ids.push(id);
						}
					});		

					if( pending_extended_details_ids.length == 0 ){
						//nothing missing, just render from cache.
						cb_render_extended_details( $, extended_details_ids, view_template, calendar );
					}else{
						url = RHC.ajaxurl;
						url = url + '?rhc_action=extended_details';
						
						if(extended_details_ids.length>0){
							$.each(extended_details_ids,function(i,id){
								url = url + '&ids[]=' + id;
							});
						}								

						ver = RHC.last_modified && ''!=RHC.last_modified ? RHC.last_modified : now.getTime() ;
						url = url + '&ver=' + ver; 
						
						queryString = url.substring( url.indexOf('?') + 1 );	

						hash = CryptoJS.MD5( queryString )
						u = hash.toString(CryptoJS.enc.Hex);	

						url = url + '&_=' + u ;						

						//some details are missing, complete with ajax.
						var ajax_args = {
							url: url,
							type:'GET',
							dataType:'html',
							not_used_data: {
								rhc_action:'extended_details',
								ids:extended_details_ids
							},
							success: function(data){									
								$.each(extended_details_ids,function(i,id){
									if( $(data).find('.'+id).length > 0 ){
										calendar.extended_detail_cache[id] = $(data).find('.'+id).clone();	
									}else{
										$(element).find('.skip-render.ext_det_'+id)
											.removeClass('skip-render')
											.removeClass('ext_det_'+id)
											.fadeIn('fast')
											.parent().find('.ext-list-loading').fadeOut('fast')
										;	
									}
								});
								
								cb_render_extended_details( $, extended_details_ids, view_template, calendar );
							},
							error: function(){
								$(element).find('.skip-render').show();
								$(element).parent().find('.ext-list-loading').fadeOut('fast');
								cb_render_extended_details( $, extended_details_ids, view_template, calendar );//render those in cache.
							}
						}					
						$.ajax(ajax_args);
					}
				}	
				
			}	
		}else{
			t.have_events = false;
			view_template.find('.fc-event-list-holder').append(no_events_template);	
			view_template.find('.fc-no-list-events-message').show();
		}
		trigger('loading', null, false);
	}
	
	function cb_render_extended_details( $, extended_details_ids, view_template, calendar ){
		$.each(extended_details_ids,function(i,id){
			if( 'undefined'==typeof calendar.extended_detail_cache[id] ){
				return
			};
			
			view_template.find('.ext_det_'+id).each(function(j,el){
				var replacement = calendar.extended_detail_cache[id].clone();
				var ev = $(el).data('ev');
				//-------------------------------------
				//fc_start
				replacement.find('.postmeta-fc_start .fe-extrainfo-value').html( 
					$.fullCalendar.formatDate(ev.start, calendar.options.eventList.extDateFormat||'MMMM d, yyyy',calendar.options)
				);
				//fc_start_time
				replacement.find('.postmeta-fc_start_time .fe-extrainfo-value').html( 
					$.fullCalendar.formatDate(ev.start, calendar.options.eventList.extTimeFormat||'h:mm tt',calendar.options)
				);
				//fc_start_datetime
				replacement.find('.postmeta-fc_start_datetime .fe-extrainfo-value').html( 
					$.fullCalendar.formatDate(ev.start, calendar.options.eventList.extDateTimeFormat||'MMMM d, yyyy. h:mm tt',calendar.options)
				);
				//fc_end
				replacement.find('.postmeta-fc_end .fe-extrainfo-value').html( 
					$.fullCalendar.formatDate(ev.end, calendar.options.eventList.extDateFormat||'MMMM d, yyyy',calendar.options)
				);
				//fc_end_time
				replacement.find('.postmeta-fc_end_time .fe-extrainfo-value').html( 
					$.fullCalendar.formatDate(ev.end, calendar.options.eventList.extTimeFormat||'h:mm tt',calendar.options)
				);
				//fc_end_datetime
				replacement.find('.postmeta-fc_end_datetime .fe-extrainfo-value').html( 
					$.fullCalendar.formatDate(ev.end, calendar.options.eventList.extDateTimeFormat||'MMMM d, yyyy. h:mm tt',calendar.options)
				);
				//--rhp share button
				if( replacement.find('.fc-button-social-panels').length > 0 ){
					var share = replacement.find('.fc-button-social-panels');
					new_rhp_vars = share.data('rhp_vars');
					new_rhp_vars.shareLink = ev.url;
					new_rhp_vars.shareRedirectURI = ev.url;
					share.data('rhp_vars',new_rhp_vars);
				}
				//-------------------------------------
				replacement.find('.fe-image-holder').RHCLink( ev, $(el).closest('.fullCalendar').fullCalendar('getView') );
				
				original = 	$(el).replaceWith(replacement);
				replacement.parent().find('.ext-list-loading').fadeOut('fast');
			});
		});		
		$('BODY').trigger('dbox.loaded');			
	}
	
	function trigger(name, thisObj) {
		return calendar.trigger.apply(
			calendar,
			[name, thisObj || t].concat(Array.prototype.slice.call(arguments, 2), [t])
		);
	}
	
	function loading( isLoading, view, fc_options ){
		if(isLoading){
			t.scroll_lockdown = true;
			$(view.element).parents('.rhc_holder').addClass('stacking-loading');
		}else{
			t.scroll_lockdown = false;
			$(view.element).parents('.rhc_holder').removeClass('stacking-loading');
		}
	}
	
	function _sort_events(o,p){
		if(o.start>p.start){
			return 1;
		}else if(o.start<p.start){
			return -1;
		}else{
			return 0;
		}
	}
	function _rsort_events(o,p){
		if(o.start<p.start){
			return 1;
		}else if(o.start>p.start){
			return -1;
		}else{
			return 0;
		}
	}
}	

$.fullCalendar.views.rhc_detail = DetailView;	
function DetailView(element, calendar) {
	var t = this;
	var body;
	t.name = 'rhc_detail';
	t.render = render;
	t.unselect = unselect;
	t.setHeight = setHeight;
	t.setWidth = setWidth;
	t.clearEvents = clearEvents;
	t.renderEvents = renderEvents;
	t.trigger = trigger;
	t.viewChanged = viewChanged;
	t.beforeAnimation = beforeAnimation;
	
	t.element = element;
	
	function viewChanged(){
	
	}
	
	function beforeAnimation(oldView){
	
	}	
	function render(date,delta){
		t.start = date;//if not defined, hidden views do not update size on window resize.
		var firstTime = !body;
		if(firstTime){
			$('<div class="fc-detail-view-holder"><div class="fc-detail-view-content">TODO: a single event details. The button will be removed on the top right controls, and this view will be triggered when selecting an event.</div><div class="fc-detail-view-wp_footer" style="display:none;"></div></div>').appendTo(element);
			body = true;
		}else{
			 
		}
	}
	function unselect(){/*console.log('unselect');*/}
	function setHeight(h){
		//element.css('height',h);
		
		element.css('min-height','200px');
		element.css('height','auto');		
	}
	function setWidth(){/*console.log('setWidth');*/}
	function clearEvents(){
		/*console.log('clearEvents');*/
		$('.fc-detail-view-content').html( '' );
	}
	function renderEvents(){
		//console.log( calendar.last_clicked_event );
		//console.log('renderEvents');
		
		var args = {
			'id' : calendar.last_clicked_event.id
		};
		
		
		$.post(calendar.options.singleSource,args,function(data){
			if(data.R=='OK'){
				
				if( $('body .fc-single-item-holder').length==0 ){
					$('body').append('<div class="fc-single-item-holder"></div>');
				}
				
				$('body .fc-single-item-holder').empty();
				$(data.DATA.footer).each(function(i,inp){
					if( inp.nodeName && inp.nodeName=='SCRIPT'){
						var script   = document.createElement("script");
						if( $(inp).attr('type') ){
							script.type  = ($(inp).attr('type')||'');
						}
						if($(inp).attr('src')){
							script.src   = ($(inp).attr('src')||'');    // use this for linked script
						
						}else{
							script.text  = ($(inp).html()||'');
						}
						
						
						document.body.appendChild(script);
						
						//$('body .fc-single-item-holder').append( script );
						
					}else{
						$('body .fc-single-item-holder').append( inp );					
					}
				});
				
				$('.fc-detail-view-content').html( data.DATA.body );
			}
		},'json');
		
	}
	function trigger(){/*console.log('trigger');*/}
}	

})(jQuery);

function _rhc_widget_link_click(calEvent,el){
	var event = jQuery(el).data('rhc_event')||false;
	if(event && event.fc_click_target){
		var target = event.fc_click_target;
	}else{
		var target = '_self';
	}
	if(calEvent.event_rdate || calEvent.gotodate){
		jQuery('form#calendarizeit_repeat_instance').remove();
		var form = '<form id="calendarizeit_repeat_instance" method="post"></form>';
		jQuery(form)
			.attr('action',calEvent.url)
			.attr('target',target)
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

		jQuery('form#calendarizeit_repeat_instance')
			.submit(function(e){
				e.stopPropagation();
				var url = calEvent.url;				
				if( url == null || url.indexOf("javascript:void(0);") > 0 ){
					return false;
				}
				return true;
			})
			.submit()
		;	
	}else{
		var url = calEvent.url;
		if (url != null && url.indexOf("javascript:void(0);") == 0){
			return false;
		}	
		if(target=='_blank'){
			window.open(url);
		}else{
			location.href = url;
		}
	}
	return false;
}

function _rhc_sort_events(o,p){
	if(o.start>p.start){
		return 1;
	}else if(o.start<p.start){
		return -1;
	}else{
		return 0;
	}
}