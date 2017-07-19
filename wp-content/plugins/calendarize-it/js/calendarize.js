(function($){
	var methods = {
		init : function( options ){
			var settings = $.extend( {
				'editable':	false,
				'mode': 'view'
			}, options);		
			
			$('.fc-dialog').CalendarizeDialog();
			
			function fbd_move_cell(cell,destination){	
				if( !cell.hasClass('fbd-cell') ){
					cell = cell.parents('.fbd-cell');
				}				

				if( destination.hasClass('fbd-checked') ){
					var animation = {opacity:0,left:-30};
				}else{
					var animation = {opacity:0,left:30};
				}
				var _easing = 'linear';
				var _duration = 'fast';				
				if( destination.find('.fbd-cell').length==0 ){
					$(cell).animate(animation,_duration,_easing,function(){
						$(this).appendTo(destination).css('left',animation.left*-1).animate({opacity:1,left:0});
					});
				}else{
					var cells = destination.find('.fbd-cell');
					if( parseInt($(cell).data('tab-index')) > parseInt($(cells[cells.length-1]).data('tab-index')) ){
						//$(cell).appendTo(destination);
						$(cell).animate(animation,_duration,_easing,function(){
							$(this).appendTo(destination).css('left',animation.left*-1).animate({opacity:1,left:0});
						});
					}else if(parseInt($(cell).data('tab-index')) < parseInt($(cells[0]).data('tab-index'))){
						//$(cells[0]).before(cell);
						$(cell).animate(animation,_duration,_easing,function(){
							$(cells[0]).before(cell).prev()
								.css('left',animation.left*-1).animate({opacity:1,left:0});
						});								
					}else{
						for(a=0;a<cells.length;a++){
							var _destination = cells[a];
							if( (parseInt($(cell).data('tab-index')) > parseInt($(cells[a]).data('tab-index'))) && (parseInt($(cell).data('tab-index')) < parseInt($(cells[a+1]).data('tab-index'))) ){
								$(cell).animate(animation,_duration,_easing,function(){									
									$(_destination).after( 
										$(this).css('left',animation.left*-1).animate({opacity:1,left:0})
									);
								});		
								break;
							}
						}							
					}
				}
			}
	
			return this.each(function(){
				var data = $(this).data('Calendarize');
				if(!data){
					$(this)
						.data('Calendarize',settings)
						.Calendarize('mode',settings.mode)
					;
										
					//-- add a placeholder for lateral event list
					if($(this).find('.rhc-sidelist').length==0){
						$('<div class="rhc-sidelist-holder"><div class="rhc-sidelist-tab"><div class="rhc-sidelist-tab-label"></div></div><div class="rhc-sidelist-head"></div><div class="rhc-sidelist"></div></div>').appendTo(this);
						$(this).find('.rhc-sidelist-tab').click(function(e){					
							$(this).parents('.rhc-sidelist-holder').toggleClass('sidelist-open');
						});
					}
	
					//-- add a placeholder for a horizontal control bar
					if($(this).find('fullCalendar > .fc-head-control').length==0){
						//.fc-view-rhc_gmap
						//.fc-header
						var tax_filter_selector = '.fc-header';
						if( $(this).find(tax_filter_selector).length>0 ){
							$(this).find(tax_filter_selector).after('<div class="fc-head-control rh-flat-ui"><div class="tax_filter_nav"><a href="#" class="tax_filter_previous btn btn-small btn-taxfilter fui-arrow-left"></a></div><div class="tax_filter_holder_viewport"><div class="tax_filter_holder"></div></div></div>');						
							$(this).find('.tax_filter_previous').click(function(e){
								var holder = $(this).parents('.fc-head-control').find('.tax_filter_holder');
								holder.stop(false,true);
								if( holder.find('.tax_filter_item_holder').length>0 ){					
									var slide = holder.find('.tax_filter_item_holder').first();
									slide.stop(false,true);
									var width = -1*slide.outerWidth(true);
									var opacity = slide.css('opacity');			
									slide.animate({opacity:0},400,'swing');
									holder.animate({'margin-left':width},500,'swing',function(){								
										slide
											.stop(false,true)
											.appendTo(holder)
											.css('opacity',opacity)
										;
										$(this).css('margin-left',0);
									});
								}						
							});
						}
					}	
					//-- add dialog with appropiate taxonomies
					if($(this).find('.fc-lower-head-tools').length==0){
						$(this).find('.fc-header').after('<div class="fc-lower-head-tools"></div>');
						if( $(this).find('.fc-lower-head-tools .fc-filters-dialog').length==0 ){
							$(this).find('.fc-filters-dialog-holder .fc-filters-dialog').clone().appendTo( $(this).find('.fc-lower-head-tools') );
						}
					}	
					//-- limit height of filters-dialog
					var _h = parseInt($(this).find('.fc-content').innerHeight()) * 0.6;			
					_h = _h<300?300:_h;
					$(this).find('.fc-lower-head-tools .fc-filters-dialog').find('.fbd-unchecked').css('max-height',_h+'px');
					
					
					//-- tabs click				
					$(this).find('.fc-filters-dialog .fbd-tabs').on('click',function(e){
						$(this).parent().parent()
							.find('.fbd-tabs').removeClass('fbd-active-tab').end()
							.find('.fbd-tabs-panel').hide().end()
							.find( $(this).find('a').data('tab-target') ).show()
							;
						$(this).addClass('fbd-active-tab');
					}).first().trigger('click');
					//-- all unchecked unload
					$(this).find('.fbd-cell input[type="checkbox"]').attr('checked',false);
					//-- move checked items
					$(this).find('.fbd-cell input[type="checkbox"]').on('click',function(e){
						if( $(this).is(':checked') ){
							var destination = $(this).parent().parent().parent().parent().find('.fbd-checked');
						}else{
							var destination = $(this).parent().parent().parent().parent().find('.fbd-unchecked');
						}
						fbd_move_cell($(this).parent().parent(),destination);
					});
					//-- easier access
					$(this).find('.fullCalendar .fbd-dg-apply,.fullCalendar .fbd-dg-remove').attr('rel',$(this).attr('id'));
					//-- apply filter click
					$(this).find('.fullCalendar .fbd-dg-apply').on('click',function(e){
						return methods.apply_filter.apply( $(this),[]);
					});
					//-- close filter dialog
					$(this).find('.fbd-close-tooltip a').unbind('click').click(function(e){
						$(this).parents('.fullCalendar').find('.fc-button-rhc_search').trigger('click');
					});					
					//-- remove filter click
					$(this).find('.fullCalendar .fbd-dg-remove').on('click',function(e){
						//clear search forms:
						$(this).parents('.rhc_holder').find('input[name=s]').val('').trigger('change');
						
						$('#'+$(this).attr('rel'))
							.find('input[type=checkbox].fbd-filter').each(function(i,inp){
								if( typeof $(inp).attr('checked') == 'undefined' ) return;//no need to go throught the unchecked ones.													
								$(inp).attr('checked',false);
								var destination = $(this).parent().parent().parent().parent().find('.fbd-unchecked');
								fbd_move_cell($(this).parents('.fbd-cell'),destination);
							})/*.attr('checked',false)*/.end()
							.find('.fbd-dg-apply').trigger('click');
							$(this).closest('.fullCalendar').fullCalendar('gotoDate', $(this).closest('.fullCalendar').data('starting_date') );
							$(this).parents('.fullCalendar').find('.fc-button-rhc_search').trigger('click');
					});
					//--
					$(this).find('.fullCalendar .fc-header').on('click',function(e){
						$('.fct-tooltip').trigger('close-tooltip');
					});
					//--
					$(document).keyup(function(e) {
						if (e.keyCode == 27) { 
							$('.fct-tooltip').trigger('close-tooltip'); 	
							$('.fc-filters-dialog:visible').stop()
								.find('.fbd-unchecked').css('overflow-y','hidden').end()
								.animate({opacity:0,top:-10},'fast','linear',function(){$(this).hide();});							
						}
					});		
					//-- add a bottom arrow
					if( $(this).find('fc-view-loading-bottom').length==0 ){
						$(this).find('.fullCalendar .fc-footer')										
							.before(
								$('<div class="fc-view-loading-bottom"></div>')
									.append( 
										$('<div class="fc-view-loading-bottom-1"><div class="fc-view-loading-bottom-2 fc-next-arrow"></div></div>') 
											.click(function(e){
												$(this).parents('.rhc_holder').find('.fullCalendar').fullCalendar('next');
											})								
									)
							)						
						;					
					}

					//--
					$(this).trigger('rhc_loaded');								
				}
			});
		},
		mode : function ( mode ){
			var _this = this;
			var data = $(this).data('Calendarize');
			if( !data || !data.modes ) return;
			var fc_options = $.extend( data.common, data.modes[mode].options);	
			var regColorcode = /^(#)?([0-9a-fA-F]{3})([0-9a-fA-F]{3})?$/;
			//--
			preload_events( this, fc_options );	
					
			if(fc_options.for_widget){
				fc_options.eventRender = function (event,element,view){					
					return cb_event_render(calendar,true,event,element,view,fc_options);
				};
				
				fc_options.eventAfterAllRender = function ( view ){
					hide_widget_event_list( calendar, false, null, null, view, fc_options);
					return cb_event_render_all( calendar, true, null, null, view, fc_options);
				};
				
				fc_options.dayClick = function (date,allDay,jsEvent,view){
					return cb_dayclick(date,allDay,jsEvent,view,fc_options,_this);
				}			
			}else{
				fc_options.eventRender = function (event,element,view){	
					if( 'rhc_grid'!=view.name ){
						$('.fc-event-title', element).html(event.title);
					}			
					return cb_event_render(calendar,false,event,element,view,fc_options);
				}
				fc_options.eventAfterAllRender = function ( view ){
					return cb_event_render_all( calendar, false, null, null, view, fc_options);
				};								
			}

			fc_options.loading = function( isLoading, view ){							
				return cb_events_loading(_this, this, isLoading, view, calendar, fc_options);
			}	
			
			fc_options.eventDataTransform = function(data){
				if( data.start && data.start.getFullYear ){
					if(!data.terms){
						data.terms=[]
					}
					//-- month
					var new_term = {
						filter_type: 'AND',
						term_priority: parseInt(data.start.getMonth()),
						description: $.fullCalendar.formatDate( data.start, 'MMMM', fc_options ),
						taxonomy: 'core_month',
						taxonomy_label: (fc_options.tax_filter_label && fc_options.tax_filter_label.month) ? fc_options.tax_filter_label.month : 'month',
						slug: $.fullCalendar.formatDate( data.start, 'M', fc_options )
					};
					data.terms.unshift(new_term);
					
					//-- year
					var year = data.start.getFullYear();
					var new_term = {
						filter_type: 'AND',
						term_priority: parseInt(year),
						description: year,
						taxonomy: 'core_year',
						taxonomy_label: (fc_options.tax_filter_label && fc_options.tax_filter_label.year) ? fc_options.tax_filter_label.year : 'year',
						slug: parseInt(year)
					};				
					data.terms.unshift(new_term);
				}
				
				return data;
			}
			
			/*
			fc_options.events = function(start, end, callback) {
		        $.fn.Calendarize.events_source(start, end, callback, fc_options);
		    };
			*/
			var rhc_event_src = function(start, end, callback) {
		        $.fn.Calendarize.events_source(start, end, callback, fc_options);
		    };
			
			fc_options.eventSources = [];
			if(fc_options.json_only!='1'){
				fc_options.eventSources.push(rhc_event_src);
			}		
			if( fc_options.json_feed && fc_options.json_feed.length>0 ){
				if(fc_options.json_only=='1'){
					fc_options.events = null;
					fc_options.singleSource = null;				
				}
				
				if( fc_options.json_feed && fc_options.json_feed.length>0 ){
					$.each(fc_options.json_feed,function(i,f){
						if(f.rhc_feed && f.rhc_feed=='1'){
							var rhc_feed_src = function(start,end,callback){
								$.fn.Calendarize.rhc_feed_src(start, end, callback, f, fc_options);
							}
							fc_options.eventSources[fc_options.eventSources.length] = rhc_feed_src;
						}else{			
							//fc_options.eventSources = fc_options.eventSources.concat(f);
							var rhc_ext_event_src = function(start, end, callback) {
						        $.fn.Calendarize.ext_events_source(start, end, callback, f, fc_options);
						    };							
							fc_options.eventSources[fc_options.eventSources.length] = rhc_ext_event_src;
						}						
					});
				}			
			}	
  					
			/* deprecated fc 1.64
			fc_options.viewDisplay = function(view,element){ //this will change to viewRender
				cb_view_display( fc_options.for_widget,calendar,view,element );
			};	
			*/
			fc_options.viewRender = function(view,element){ 
				cb_view_display( fc_options.for_widget,calendar,view,element );
			};
			
			fc_options.eventMouseover = function(event, jsEvent, view){
				cb_event_mouseover( event, jsEvent, view );			
				if( fc_options.tooltip_on_hover && '1'==fc_options.tooltip_on_hover ){
					$(jsEvent.target).closest('a').click();
				}
				
				$(jsEvent.target).closest('a').addClass('event-hovered');
			}	
				
			fc_options.eventMouseout = function(event, jsEvent, view){
				$(jsEvent.target).closest('a').removeClass('event-hovered');
			}	
					
			fc_options.calendar_id = $(this).attr('id');									
//sources ----------
			f = $(this).find('.fullCalendar').fullCalendar( fc_options );
			if(data.editable && f.find('.fc-edit-tools').length==0 ){
				f.prepend('<div class="fc-edit-tools"></div>');
			}	
			
			if( f.find('.fc-footer').length==0 ){
				f.append('<div class="fc-footer"></div>');
				if(fc_options.icalendar_align){
					$('.fc-footer')
						.css('text-align',fc_options.icalendar_align)
						.addClass('dlg-align-'+fc_options.icalendar_align)
					;
				}
			}
			
			//--some cleanup of the header--
			if( fc_options.header && (fc_options.header.center+fc_options.header.left+fc_options.header.right).length==0 ){
				$(this).find('.fc-header').css('display','none');
				$(this).find('.fc-edit-tools').css('display','none');
				$(this).find('.fc-head-control').css('display','none');
				$(this).find('.fc-lower-head-tools').css('display','none');
				$(this).find('.fc-header').attr('hello',1);
			}
						
			if(true){
//-----------------------------------
				var e = f.find('.fc-footer');
				var calendar = f;
				var tm = fc_options.theme ? 'ui' : 'fc';
				if( $( ".ical-tooltip-template" ).length>0 ){
						var text = $( ".ical-tooltip-template" ).first().data('button_text');
						add_footer_button({
							calendar: f,
							calendarize:_this,
							e:e,
							tm:tm,
							label:text,
							buttonName:'icalendar',
							buttonClick:ical_footer_button_click
						});														
				}	
//-----------------------------------			
			}
			
			if(fc_options.gotodate && fc_options.gotodate!=''){
				 $(this).find('.fullCalendar').fullCalendar('gotoDate', $.fullCalendar.parseDate(fc_options.gotodate) );
			}
			
			$(this).find('.fullCalendar').data('starting_date', $(this).find('.fullCalendar').fullCalendar( 'getDate' ) );
			
			//--
			render_tax_filters.apply(this, [fc_options] );
		},
		destroy : function(){
			return this.each(function(){
				var $this = $(this),
				    data = $this.data('Calendarize');
				$(window).unbind('.Calendarize');
				data.Calendarize.remove();
				$this.removeData('Calendarize');
			});
		},
		apply_filter: function( trigger_rhc_search ){
			trigger_rhc_search = 'undefined'==typeof trigger_rhc_search ? true : trigger_rhc_search;
			//trigger_rhc_search = false===trigger_rhc_search?false:||true;
			return this.each(function(){			
				var cal_id = '#'+$(this).attr('rel');
				//--- clear bg color
				$(cal_id+' .fullCalendar').find('.bg_matched').each(function(i,el){
					$(el)
						.css('background-color', ($(el).data('original_bg')||'') )
					;			
				});	
				//-----
				var taxonomies = [];
				$(cal_id+' .fullCalendar').find('.fbd-filter-group').each(function(i,element){		
					var terms=[];
					$(element).find('input[type=checkbox].fbd-filter:checked').each(function(j,inp){
						terms[terms.length]=$(inp).val();
					});
					if(terms.length>0){
						taxonomies[taxonomies.length]={
							'taxonomy':$(this).data('taxonomy'),
							'terms':terms.join(','),
							'terms_array':terms
						};
					}
				});
				
				var data = $(cal_id).data('Calendarize');
				var fc_options = data.modes[data.mode].options;
			
				fc_options.calendar_id = $(cal_id).attr('id');	
				var fc = $(cal_id + ' .fullCalendar');	
			
				var current_view = fc.fullCalendar('getView');
				current_view.clear_events = true;			
				
				var filter = '';
				if(taxonomies){
					$.each(taxonomies,function(i,t){
						if(fc_options.replace_square_brackets){
							filter += '&tax%5B'+t.taxonomy+'%5D=' + t.terms ;
						}else{
							filter += '&tax['+t.taxonomy+']=' + t.terms ;								
						}
					});
				}
				//-- handle search string
				if( $(cal_id).find('.fc-lower-head-tools  input[name=s]').length ){
					var s = $(cal_id).find('.fc-lower-head-tools  input[name=s]').val();
					if(''!=s){
						filter += '&s=' + escape( s )
					}
				}
									
				fc_options.events_source_query_original = fc_options.events_source_query_original?fc_options.events_source_query_original:fc_options.events_source_query;
				if(''!=filter){
					fc.fullCalendar('removeEventSources');
					fc_options.events_source_query = fc_options.events_source_query_original + filter;
				}else{
					fc.fullCalendar('removeEventSources');
					fc_options.events_source_query = fc_options.events_source_query_original;
				}
	
				var new_source = function(start, end, callback) {
					$.fn.Calendarize.events_source(start, end, callback, fc_options);
				};
				fc.fullCalendar('addEventSource',new_source);
				
				if(taxonomies.length==0){				
					if(fc_options.json_feed && fc_options.json_feed.length > 0){
			//			fc.fullCalendar('removeEventSources');
						$.each(fc_options.json_feed,function(i,f){
							//fc.fullCalendar('addEventSource',f);
							if(f.rhc_feed && f.rhc_feed=='1'){
								var rhc_feed_src = function(start,end,callback){
									$.fn.Calendarize.rhc_feed_src(start, end, callback, f, fc_options);
								}
								fc.fullCalendar('addEventSource',rhc_feed_src);
							}else{
								//fc.fullCalendar('addEventSource',f);
								var rhc_ext_event_src = function(start, end, callback) {
							        $.fn.Calendarize.ext_events_source(start, end, callback, f, fc_options);
							    };							
								fc.fullCalendar('addEventSource',rhc_ext_event_src);
							}							
						});			
					}	
				}else{
					var filtered_sources = [];
					$.each(taxonomies,function(i,tax){
						$.each(tax.terms_array,function(j,tax_term){	
							if( fc_options.json_feed && fc_options.json_feed.length>0 ){
								$.each(fc_options.json_feed,function(i,f){
									if( $.inArray(f,filtered_sources) > -1 ) return;
									if(f.terms && f.terms.length>0){
										for(var i=0;i<f.terms.length;i++){					
											if( f.terms[i].taxonomy == tax.taxonomy && f.terms[i].slug == tax_term ){					
												if( -1 == $.inArray(f,filtered_sources) ){
													filtered_sources.push(f);
												}	
												return;				
											}
										}
									}
								});								
							}						
						});				
					});
					$.each(filtered_sources,function(i,f){
						if(f.rhc_feed && f.rhc_feed=='1'){
							var rhc_feed_src = function(start,end,callback){
								$.fn.Calendarize.rhc_feed_src(start, end, callback, f, fc_options);
							}
							fc.fullCalendar('addEventSource',rhc_feed_src);
						}else{
							//fc.fullCalendar('addEventSource',f);
							var rhc_ext_event_src = function(start, end, callback) {
						        $.fn.Calendarize.ext_events_source(start, end, callback, f, fc_options);
						    };							
							fc.fullCalendar('addEventSource',rhc_ext_event_src);
						}
					});					
				}

				if( 'rhc_gmap' == current_view.name || 'rhc_grid' == current_view.name ){
					//note: this behavior only makes sense in map view and grid view because these change the date automatically, so a change
					//in the dropdown needs to reset the pagination.
					$(this).closest('.fullCalendar').fullCalendar('gotoDate', $(this).closest('.fullCalendar').data('starting_date') );
				}
								
				if( trigger_rhc_search ){
					$(this).parents('.fullCalendar').find('.fc-button-rhc_search').trigger('click');
				}
				//Removed because gotoDate already calls render, and the extra line was causing a race condition where the first set of events are skipped
				//effectively showing events in the future, and not the inmediate events
				//$(this).closest('.fullCalendar').fullCalendar('render');
				$(this).closest('.fullCalendar').find('.fc-no-list-events-message').hide();
			});
		}
	};
	
	$.fn.Calendarize = function( method ) {
		if ( methods[method] ) {
			return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
		} else if ( typeof method === 'object' || ! method ) {
			return methods.init.apply( this, arguments );
		} else {
			$.error( 'Method ' +  method + ' does not exist on jQuery.Calendarize' );
		}    
	};
	
	var rhc_events_cache = [];
	  
	$.fn.Calendarize.rhc_feed_src = function( start, end, callback, f, fc_options){
		jQuery(document).ready(function($){
			var use_cache = true;
			var data = [];
			var now = new Date();
			var _fingerprint = RHC.last_modified && ''!=RHC.last_modified ? RHC.last_modified : now.getTime() ;
			var args = {
				start:		Math.round(start.getTime() / 1000),
				end:		Math.round(end.getTime() / 1000),
				'_': _fingerprint,
				'data[]': 	data
			};
			
			for(var a=0;a<rhc_events_cache.length;a++){		
				if(
					use_cache &&
					rhc_events_cache[a].start <= args.start &&
					rhc_events_cache[a].end	>= args.end &&
					rhc_events_cache[a].url == f.url
				){		
					if(parseInt(fc_options.debugjs))rhc_console('rhc_feed_src.  Loading from rhc_events_cache.');																				
					callback(rhc_events_cache[a].events);
					return;
				}
			}		  		

			var cache = args;
			cache.url = f.url;	
			
			$.post(f.url,args,function(data){
				if(data.R=='OK'){
					var events = [];
					events = rhc_events_to_fc_events(start,end,data,false);
					//-----	
					cache.events = events;
					
					if( !in_rhc_events_cache( cache.start, cache.end, cache.url ) ){									
						rhc_events_cache[rhc_events_cache.length]=cache;
					}else{
		
					}
								
					callback(events);
				}else if(data.R=='ERR'){
					//alert(data.MSG);
				}else{
					//alert('Unexpected error');
				}
			},'json');				
		});
	}
	
	$.fn.Calendarize.ext_events_source = function( start, end, callback, f, fc_options ){
		jQuery(document).ready(function($){
			var use_cache = true;
			var data = [];
			var now = new Date();
			var _fingerprint = RHC.last_modified && ''!=RHC.last_modified ? RHC.last_modified : now.getTime() ;
			var args = {
				start:		Math.round(start.getTime() / 1000),
				end:		Math.round(end.getTime() / 1000),
				'_': _fingerprint,
				'data[]': 	data
			};
			
			for(var a=0;a<rhc_events_cache.length;a++){		
				if(
					use_cache &&
					rhc_events_cache[a].start <= args.start &&
					rhc_events_cache[a].end	>= args.end &&
					rhc_events_cache[a].url == f.url
				){		
					if(parseInt(fc_options.debugjs))rhc_console('rhc_feed_src.  Loading from rhc_events_cache.');																					
					callback(rhc_events_cache[a].events);
					return;
				}
			}		  		

			var cache = args;
			cache.url = f.url;	
			
			$.post(f.url,args,function(data){		
				cache.events = data;
				if( !in_rhc_events_cache( cache.start, cache.end, cache.url ) ){									
					rhc_events_cache[rhc_events_cache.length]=cache;
				}else{
	
				}
				callback( cache.events );
			},'json');				
		});
	}
	
	$.fn.Calendarize.events_source = function( start, end, callback, fc_options ){			
		jQuery(document).ready(function($){
			var data = [];
			$('.calendarize_meta_data').each(function(i,inp){
				if(inp.type=='checkbox'){
					data[data.length] = [inp.name,($(inp).is(':checked')?1:0)];
				}else{
					data[data.length] = [inp.name,($(inp).val())];
				}
			});
	
			var url = fc_options.events_source + fc_options.events_source_query;
			//wpml
			if(typeof icl_lang!='undefined'){
				url += '&lang=' + icl_lang;
			}else if( typeof icl_vars!='undefined' && icl_vars.current_language ){
				url += '&lang=' + icl_vars.current_language;
			}
			//end wpml	


			if( fc_options.calendar_id && ''!=fc_options.calendar_id ){
				vo = $('#'+fc_options.calendar_id).find('.fullCalendar').fullCalendar('getView');
				view_name = vo.name;
			}else{
				view_name = '';
			}
			
			var use_cache = true;
			var now = new Date();
			var _fingerprint = RHC.last_modified && ''!=RHC.last_modified ? RHC.last_modified : now.getTime() ;
			var args = {
				start:		Math.round(start.getTime() / 1000),
				end:		Math.round(end.getTime() / 1000),
				rhc_shrink: (fc_options.shrink?parseInt(fc_options.shrink):''),
				view: view_name,
				'ver': _fingerprint,
				'_': '',
				'data[]': 	data
			};

			for(var a=0;a<rhc_events_cache.length;a++){

				if(
					use_cache &&
					rhc_events_cache[a].start <= args.start &&
					rhc_events_cache[a].end	>= args.end &&
					rhc_events_cache[a].url == url
				){		
					if(parseInt(fc_options.debugjs))rhc_console('Loading from rhc_events_cache.');																
					callback(rhc_events_cache[a].events);
					return;
				}
			}		
			
			var cache = args;
			cache.url = url;				
			/*
			$.post(url,args,function(data){
				if(data.R=='OK'){
					var events = [];
					events = rhc_events_to_fc_events(start,end,data,true);
					//-----	
					cache.events = events;
					rhc_events_cache[rhc_events_cache.length]=cache;				
					callback(events);
				}else if(data.R=='ERR'){
					//alert(data.MSG);
				}else{
					//alert('Unexpected error');
				}
			},'json');		
			*/
			url = url + '&start=' + args.start + '&end=' + args.end + '&rhc_shrink=' + args.rhc_shrink + '&view=' + args.view + '&ver=' + args.ver;
			if(data.length>0){
				$.each(data,function(i,d){
					url = url + '&data[' + i + '][0]=' + d[0];
					url = url + '&data[' + i + '][1]=' + d[1];
				});
			}			
			
			//ver is a hash representing the latest update
			//_ is a hash representing a query with the exact query string
						
			queryString = url.substring( url.indexOf('?') + 1 );	
			hash = CryptoJS.MD5( queryString )
			args._ = hash.toString(CryptoJS.enc.Hex);	
	
			url = url + '&_=' + args._ ;
			
			function _handle_event_source_ajax_response( data ){
				if(data.R=='OK'){
					var events = [];
					events = rhc_events_to_fc_events(start,end,data,true);
					events = handle_local_tz( events, fc_options, data );
					events = allday_group( events, fc_options );
					//-----	
					cache.events = events;
					
					if( !in_rhc_events_cache( cache.start, cache.end, cache.url ) ){					
						rhc_events_cache[rhc_events_cache.length]=cache;
					}else{
			
					}
									
					callback(events);
				}else if(data.R=='ERR'){
					//alert(data.MSG);
				}else{
					//alert('Unexpected error');
				}
			}
			
			$.ajax({
	       		url: url,
				type: 'GET',
				contentType:"application/json; charset=utf-8",
				dataType: 'json',
				cache: true,
	       		success: function(data){ 
					_handle_event_source_ajax_response( data );
	       		},
				error: function( jqXHR, textStatus, err ){		
					if( 'parsererror'==textStatus ){
						try {
							response = jqXHR.responseText.replace( /<!--[\s\S]*?-->/g, "");
							data = $.parseJSON( response );
							
							_handle_event_source_ajax_response( data )
						}catch(e){
						
						}			
					}	
				}     
	    	});//$.ajax				
			
		});
	}
	
	$.fn.RHCLink = function ( ev, view ){
		var t= view;
		var calendar = view.calendar
		var options = calendar.options;
		
        var settings = $.extend({
        	eventClick: 'fc_click'    
        }, options );	
		
		var target = ev.fc_click_target || '_self';
		
		if(ev.gcal || ev.url==''){
			return $(this);
		}else if(ev.direct_link){
			return $(this).wrap( $('<a></a>').attr('href', ev.url).attr('target',target) ).parent();
		}else{
			return $(this).wrap( 
				$('<a></a>')
					.attr('target',target)
					.attr('href', ev.url ) 	
					.unbind('click')
					.bind('click',function(e){
						var click_method = calendar.options.eventClick?calendar.options.eventClick:fc_click;
						return click_method(ev,e,t);
					})							
			).parent();
		}
	}
	
	function allday_group( events, fc_options ){
		_allday_group = 'undefined' != typeof fc_options.allday_group && 0<parseInt(fc_options.allday_group) ? parseInt(fc_options.allday_group) : 0 ;
		if( 0 < _allday_group ){
			$.each(events,function(i,e){
				if( 'undefined' != typeof e.color && e.color!='' ){
					if( 1==_allday_group ){
						//group by event color
						e.title = '<span style="display:none;">' + e.color + '</span>' + e.title;
					}else if( 2==_allday_group ){
						//group by menu_order
						if( 'undefined'!=typeof e.menu_order ){
							e.title = '<span style="display:none;">' + parseInt(e.menu_order) + '</span>' + e.title;
						}
					}
				}	
			});			
		}

		return events;
	}
	
	function preload_events( o, fc_options ){
		if( fc_options.preload && $(o).find('.rhc-preload').length ){
			$(o).find('.rhc-preload').each(function(i,el){
				if( !$(el).data('preloaded') ){
					$(el).data('preloaded', true);
					try {
						cache = $(el).data('request');
						cache = eval(cache);
						if( cache ){
							if( $(el).data('events') ){
								tmp_events = $(el).data('events');
								data = eval( tmp_events );
							}else{
								data = $.parseJSON( $(el).html() );
							}
							
							external_source = $(el).data('external_source') || false;
							
							if(data.R=='OK'){
								cache.url = $(el).data('url');
								if( !in_rhc_events_cache( cache.start, cache.end, cache.url ) ){
									//---
									cache.events = data.EVENTS;					
									var events = [];
									start = new Date( cache.start * 1000 );
									end = new Date( cache.end * 1000 );
									events = rhc_events_to_fc_events( start, end, data, true );
									events = handle_local_tz( events, fc_options, data );
									//-----	
									cache.events = events;
									rhc_events_cache[rhc_events_cache.length]=cache;									
								}	
							}else if( external_source && 'object' == typeof data ){
								cache.url = $(el).data('url');
								if( !in_rhc_events_cache( cache.start, cache.end, cache.url ) ){
									cache.events = data.EVENTS;					
									var events = data;
									start = new Date( cache.start * 1000 );
									end = new Date( cache.end * 1000 );
									
									events = handle_local_tz( events, fc_options, data );
									//-----	
									cache.events = events;
									rhc_events_cache[rhc_events_cache.length]=cache;									
								}	
							}				
						}						
					}catch(e){
					
					}					
				}
			});
		}
	}
	
	function in_rhc_events_cache( start, end, url ){
		for(var a=0;a<rhc_events_cache.length;a++){
			if(
				rhc_events_cache[a].start <= start &&
				rhc_events_cache[a].end	>= end &&
				rhc_events_cache[a].url == url
			){		
				return true;
			}
		}		
		return false;
	}
	
	function handle_local_tz( events, fc_options, data ){
		local_tz = ('local_tz' in fc_options) ? parseInt(fc_options.local_tz) : 0 ;

		if( 0==local_tz ) return events;
		
		if( 'GMT_OFFSET' in data ){
			var source_offset = data.GMT_OFFSET * -1 * 60;
			var destination_offset = new Date().getTimezoneOffset();
			if( source_offset==destination_offset ) return events;
			for (var i = 0; i < events.length; i++) {
				if( !events[i].allDay ){				
					if( 'object' == typeof events[i].start )
						events[i].start = date_change_offset( events[i].start, source_offset );
					if( 'object' == typeof events[i]._start )
						events[i]._start = date_change_offset( events[i]._start, source_offset );	
					if( 'object' == typeof events[i].end )
						events[i].end = date_change_offset( events[i].end, source_offset );	
					if( 'object' == typeof events[i]._end )
						events[i]._end = date_change_offset( events[i]._end, source_offset );	
					//---
					var period = jQuery.fullCalendar.formatDate(  events[i].start, "yyyyMMddHHmmss" );
					var end = jQuery.fullCalendar.formatDate(  events[i].end, "yyyyMMddHHmmss" );
					if( period && ''!=period ){
						if(end && ''!=end){
							period = period + ',' + end;
						}
						events[i].event_rdate = period;
						events[i].url = '' == events[i].url ? '' : _add_param_to_url( events[i].url, 'event_rdate', events[i].event_rdate );
					}								
				}
			}
		}

		return events;
	}
	
	function date_change_offset( _date, source_offset ){
		return new Date( _date.getTime() - (60000*(_date.getTimezoneOffset() - source_offset)));
	}
					
	function handle_field_map(data){
		if( data.MAP && data.MAP.length > 0 && data.EVENTS && data.EVENTS.length > 0 ){
			new_events = [];
			jQuery.each( data.EVENTS, function(i,ev){
	
				new_ev = {};
				jQuery.each( data.MAP, function(j,m){
					if( ev[m[0]] ){
						new_ev[m[1]] = ev[m[0]];
					}
				});
				/* bug fix, when empty allday is not correctly defined.*/
				if(typeof new_ev['allDay']=='undefined'){
					new_ev['allDay']=false;
				}
				
				if( new_ev.terms && new_ev.terms.length>0 ){
					//-- replace object
					new_terms = [];
					jQuery.each( new_ev.terms, function(k,term){
						if( typeof term=='object' ){
							new_terms[ k ] = term;
						}else{
							new_terms[ k ] = data.TERMS[term];					
						}
					});		
					new_ev.terms = new_terms;
								
					//-- replace field names
					new_terms = [];
					jQuery.each( new_ev.terms, function(k,term){
						new_term = {};
						jQuery.each( data.MAP, function(j,m){
							if( term[m[0]] ){
								new_term[m[1]] = term[m[0]];
							}
						});
						new_terms[ new_terms.length ] = new_term;			
					});
					new_ev.terms = new_terms;
				}

				new_events[new_events.length]=new_ev;
			});		
			data.EVENTS = new_events;
		}
	
		return data;
	}
	
	function rhc_events_to_fc_events(start,end,data,local_feed){
		var events = [];
		data = handle_field_map(data);
		if(data.EVENTS.length>0){
			$(data.EVENTS).each(function(i,e){	
				e.premiere = true;
				e.description = typeof e.description=='undefined' ? '' : e.description ;
				e.local_feed = typeof e.local_feed=='undefined' ? local_feed : e.local_feed; 	
				if( !e.color || e.color=='' || e.color=='#' ){
					if(e.terms && e.terms.length>0){
						for(var a=0;a<e.terms.length;a++){
							var color = e.terms[a].background_color && e.terms[a].background_color.length>1 ? e.terms[a].background_color : false ;
							var textColor = e.terms[a].color && e.terms[a].color.length>1 ? e.terms[a].color : false ; 
							
							textColor = color && false===textColor ? '#fff' : textColor;
							color = textColor && false===color ? '#fff' : color;
							
							if(color && textColor){
								e.color = color;
								e.textColor = textColor;
								break;
							}
						}
					}						
				}

				if('undefined'==typeof(e.start) || null==e.start)return;
				e.src_start = e.start;
				e.fc_rrule = e.fc_rrule?e.fc_rrule:'';
				if(''==e.fc_rrule && ''==e.fc_rdate){
					events[events.length]=e;
				}else{						
					var duration = false;
					var e_start = new Date( $.fullCalendar.parseDate( e.start ) );
					if(e.end){
						var e_end = new Date( $.fullCalendar.parseDate( e.end ) );
						duration = e_end.getTime() - e_start.getTime();
					}	
//								var fc_start = new Date(e.fc_start+' '+e.fc_start_time);
//								var fc_start = new Date(e.start);
					var fc_start = $.fullCalendar.parseDate( e.start );
					e.fc_rrule = ''==e.fc_rrule?'FREQ=DAILY;INTERVAL=1;COUNT=1':e.fc_rrule;
					
					
					try {
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
																			
						occurrences = scheduler.occurrences_between(start, end);
						if(occurrences.length>0){
							$(occurrences).each(function(i,o){
								var new_start = new Date(o);
								var p = $.extend(true, {}, e);
								p.premiere = new_start.getTime()==e_start.getTime() ;
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
								p.repeat_instance = true;
								p = _add_repeat_instance_data_to_event(p);
								events[events.length]=p;
							});
						}else{

						}
						//handle a situation, where there is no recurring instance in the date range (start / end) but the event was set
						//with long diference between start and end so the event doesnt actually starts or ends in the given time window.
						//this applies both with occurence.length=0 or >0.
						if( e_start <= start && e_end > start ){
							e.start = e_start;
							e.end = e_end;
							events[events.length]=e;							
						}							
					}catch(err){
						console.log( err.message, e );
					}							
				}
			});
		}	

		if( events.length > 0 ){
			if( ! events[0].local_feed ){
				events.sort( _rhc_sort_events );

				var new_events = [];
				$(events).each(function(i,ev){
					if( !ev.local_feed ){
						//remove duplicate id and date
						if( new_events.length > 0 ){
							for( var a=0; a < new_events.length; a++ ){
								cev = new_events[a];							
								if( ev.id == cev.id && ev.start.getTime() == cev.start.getTime() && ev.network == cev.network ){
									return true;
								}
							}
						}
						
						new_events.push( ev );
					}
				});		
				events = new_events;		
			}
		}

		return events;
	}
	var sidelist_events = [];
	function cb_event_render(calendar,for_widget,event,element,view,fc_options){
		if(!calendar){
			calendar = $(view.element).parents('.fullCalendar');
		}
		/* the following code prevents all views from rendering any events between dec 16 till dec 31 2013.
		var holiday_start 	= new Date(2013,11,16,0,0,0);
		var holiday_end 	= new Date(2014,0,1,0,0,0);
		if( event.start > holiday_start && event.start < holiday_end ){
			return false;
		}
		*/
	
		showothermonth = fc_options && fc_options.showothermonth ? parseInt(fc_options.showothermonth) : 1;//active by default.
		showothermonth = view && view.name && 'month'==view.name ? showothermonth : 1;//this option is only valid for month view.
		if( 'month'==view.name && $(element).parents('.rhcalendar.not-widget').hasClass('fc-small') ){
			showothermonth=0;
		}
		if( 0==showothermonth && event.start && event.end && view.start && view.end ){
			/* Events that ended before visualization start are removed */
			if( event.end.getTime() < view.start.getTime() ){
				return false;
			}
			/* Events that start past the visualization end are removed */
			if( event.start.getTime() >= view.end.getTime() ){
				return false;
			}
		}
		//external sources still showing, when end is not set on source
		if( 0==showothermonth && event.start && null==event.end && view.start && view.end ){
			/* Events that ended before visualization start are removed */
			if( event.start.getTime() < view.start.getTime() ){
				return false;
			}
			/* Events that start past the visualization end are removed */
			if( event.start.getTime() >= view.end.getTime() ){
				return false;
			}
		}
		
		//skip events
		event_skip = fc_options && fc_options.event_skip ? parseInt(fc_options.event_skip) : 0;	
		if( event_skip ){
			if( 'undefined' == typeof view.event_skip ){
				view.event_skip = event_skip;
			} 
			
			if( view.event_skip > 0 ){
				view.event_skip--;
				return false;
			}
		}

		//-- all views upcoming only	
		if( 1==parseInt(fc_options.upcoming) ){
			var now = new Date();
			if( event.allDay ){
				now.setHours(0,0,0,0);
			}

			if( event.start.getTime() < now.getTime() ){			
				return false;
			}
		}
		
		norepeat = view.get_norepeat ? view.get_norepeat( ( fc_options.norepeat || false ) ) : ( fc_options.norepeat || false );
		norepeat = parseInt(norepeat);
		if( norepeat && view && event && event.id ){	
			view.rendered = view.rendered ? view.rendered : [] ;
			if( -1 == $.inArray( event.id, view.rendered ) ){
				view.rendered.push( event.id );			
			}else{
				return false;
			}			
		}

		if( fc_options.taxonomycolor && '1'==fc_options.taxonomycolor ){
			if( event.terms ){
				var classes = [];
				$.each( event.terms, function(i,term){
					str = 'tax_' + term.taxonomy + '_' + term.slug;
					str = str.replace(/ /g,"_");
					classes.push( str );
				});
				if( classes.length > 0 ){
					$(element).addClass( classes.join(' ') );
				}			
			}		
		}
		

		
		if(event.venue_directory && view.name!='rhc_gmap'){
			return false;
		}
		
		if( view.name=='rhc_gmap' && event.start ){		
			if( 1==parseInt( fc_options.gmap_view.upcoming ) ){
				if( event.start.getTime() < view.visStart.getTime() ){
					return false;
				}			
			}else if( event.end && 2==parseInt( fc_options.gmap_view.upcoming ) ){
				if( event.end.getTime() < view.visStart.getTime() ){
					return false;
				}	
			} 
		}
			
		var tax_filters = $(calendar).data('rhc_tax_filters');
		if(tax_filters && tax_filters.length>0){	
			var filter_out = true;
			var matched_taxonomies = [];
			var filter_taxonomies = [];
			$.each( event.terms, function(j,term){
				$.each(tax_filters,function(i,filter){
//----					
					if( -1 ==$.inArray(filter.taxonomy,filter_taxonomies) ){
						filter_taxonomies.push(filter.taxonomy);
					}
					
					if( filter.taxonomy==term.taxonomy ){
						if( term.gaddress && term.gaddress==filter.term ){
							filter_out=false;
							matched_taxonomies.push(term.taxonomy);
						}else if( term.description && term.description==filter.term ){
							filter_out=false;
							matched_taxonomies.push(term.taxonomy);
						}else if( term.name && term.name==filter.term ){
							filter_out=false;
							matched_taxonomies.push(term.taxonomy);
						}	
					}
				});
			});
			if(!filter_out && filter_taxonomies.length>0){
				$.each(filter_taxonomies,function(i,tax){
					if( -1 == $.inArray(tax,matched_taxonomies) ){
						filter_out=true;
					}
				});
			}
			
			if(filter_out){					
				return false;
			}	
		}	

		//max events
		max_events = fc_options && fc_options.max_events ? parseInt(fc_options.max_events) : 0;	
		if( max_events ){
			if( 'undefined' == typeof view.max_events ){
				view.max_events = max_events;
				view.rendered_events_count = 0;
			} 
			
			if( view.rendered_events_count >= view.max_events ){
				return false;
			}else{
				view.rendered_events_count++;
			}
		}
			
		if(for_widget){
			var pattern=/fc-day([0-9]{1,2})/i;	
			var day_diff = 0;
			if(event.start&&event.end){
				var s = new Date(event.start);
				var e = new Date(event.end);
				s.setHours(0,0,0,0);
				e.setHours(0,0,0,0);
				day_diff = Math.floor((e.getTime()-s.getTime())/(86400000));
			}
	
			var day_number = event._start.getDate();
			if( day_diff==0 ){
				$(view.element).find('.fc-day-number').each(function(i,inp){						
					if( day_number==$(inp).html() ){
						if(  event.start.getMonth() == view.start.getMonth() ){				
							if( !$(inp).parent().parent().hasClass('fc-other-month') ){
								$(inp).parent().parent()
									.addClass('fc-state-highlight')
									.addClass('fc-have-event')
									.css('background-image','none')
								;									
							}
						}else{
							if( $(inp).parent().parent().hasClass('fc-other-month') ){
								$(inp).parent().parent()
									.addClass('fc-state-highlight')
									.addClass('fc-have-event')
									.css('background-image','none')
								;										
							}
						}	
					}
				});	
			}else{			
				var s = new Date(event.start);
				var e = new Date(event.start);		
				
				s.setHours(0,0,0);
				e.setHours(23,59,59);
					
				$(view.element).find('.fc-day-number').each(function(i,inp){
					current_date_str = $(inp).closest('.fc-day').data('date');
					current_date = new Date( current_date_str + 'T00:00:00Z' );

					//convert timezone
					current_date.setTime( current_date.getTime() + s.getTimezoneOffset()*60*1000 );			
					if( current_date.getTime() <= e.getTime() && current_date.getTime() >= s.getTime() ){
						$(inp).parent().parent()
							.addClass('fc-state-highlight')
							.addClass('fc-have-event')
							.css('background-image','none')
						;	
					}
				});			
			}

			
								
			return false;		
		}else{
			/*
			var skip_sidelist = event.skip_sidelist || false;
			//--- render on event list		
			if(!skip_sidelist && view.name=='rhc_gmap' && $(calendar).parent().find('.rhc-sidelist').length>0){
				if(fc_options.sidelist && fc_options.sidelist.template && $(fc_options.sidelist.template).length>0){
					cb_event_render_sidelist( calendar, for_widget, event,element, view, fc_options );
				}
			}
			*/
			//moved to a callback after all events are rendered.
			sidelist_events.push(event);
		}
		
		/**/
		if(fc_options.matchBackground && '1'==fc_options.matchBackground){
			loop_date = new Date( event['_start']  );
			compare_date = event['_end'] || event['_start'];
			var a=0;
			while(loop_date<=compare_date){
				sel = ".fc-day[data-date='" + $.fullCalendar.formatDate(loop_date,'yyyy-MM-dd') + "']";
				original_bg = $(view.element).find(sel).css('background-color');

				$(view.element).find(sel)
					.data('original_bg', original_bg)
					.addClass('bg_matched')
					.css('background-color', ( $(element).length && $(element).get(0).tagName ? $(element).css('background-color') || '' : '' ) )
				;
				
				loop_date.setDate( loop_date.getDate() + 1 );
				if(a++>5000){
					break;
				}
			}	
		}
		

		render_something = false;
		/**/
		if(fc_options.month_event_image && '1'==fc_options.month_event_image && view.name=='month'){
			if( event.month_image && event.month_image[0] ){
				loop_date = new Date( event['_start']  );
				sel = ".fc-day[data-date='" + $.fullCalendar.formatDate(loop_date,'yyyy-MM-dd') + "']";
				ratio = event.month_image[2]/event.month_image[1];
				
				container_w = view.element.find(sel).outerWidth();
				_w = container_w;
				_h = _w * ratio; 
				
				$(element)
					.addClass('has-fc-image')
					.find('.fc-event-inner').prepend(
					$('<div></div>')
						.addClass('fc-image-cont')
						.append(
							$('<img />')
								.attr('src', event.month_image[0])
								.attr('height', parseInt(_h) )
								.css('height', parseInt(_h) )
								.addClass('fc-image')
								
						)			
				);
				
				render_something = true;
			}
		}
		
		if( 'month'==view.name ){
			fc_options.render_events = 'undefined' == typeof fc_options.render_events ? 1 : fc_options.render_events ;
			if( 0==parseInt( fc_options.render_events ) ){
				if( render_something ){
					$(element).find('.fc-event-title').hide();
					$(element).find('.fc-event-time').hide();
					$(element).css('background-color', 'transparent');
				}else{
					return false;
				}
				
			}		
			
			if( 'undefined' == typeof fc_options.fixed_title || fc_options.fixed_title.length == 0 ){
			
			}else{
				$(element).find('.fc-event-time').html('&nbsp;');
				$(element).find('.fc-event-title').html( fc_options.fixed_title );
			}
		}		
		
		/*individual early loading dynamic tooltip*/
		if( false || (fc_options.early_dynamic_tooltip && '1'==fc_options.early_dynamic_tooltip) ){
			cb_event_mouseover( event, null, view );
		}
		
		if( fc_options.tooltip_close_on_title_leave && parseInt(fc_options.tooltip_close_on_title_leave) ){
			//when leaving event title, trigger close tooltip if not hovered
			$(element).mouseleave(function(e){
				handle = setTimeout( function(){				
					if( 0==$('.fc-event.event-hovered').length ){
						if( $('.fct-tooltip').is(':visible') ){
							if( !$('.fct-tooltip:visible').first().is(':hover') ){
								$('.fct-tooltip:visible').trigger('close-tooltip'); 
							}
						}		
					}		
				}, 200 );				
			});				
		}
	}

	function hide_widget_event_list(calendar,for_widget,event,element,view,fc_options){	
		var holder = jQuery( calendar ).parents('.rhc_holder').find('.rhc_calendar_widget_day_click_holder');
		if( holder.children().length > 0 ){
			holder.children().fadeOut('fast',function(){
				
			});
		}
	}
	
	function cb_event_render_all(calendar,for_widget,event,element,view,fc_options){			
		if('undefined' ==typeof calendar)
			calendar = $(view.element).parents('.rhcalendar.rhc_holder');	

		norepeat = view.get_norepeat ? view.get_norepeat( ( fc_options.norepeat || false ) ) : ( fc_options.norepeat || false );
		norepeat = parseInt(norepeat);
		if( norepeat && view  ){
			view.rendered = view.handle_rendered ? view.handle_rendered() : [] ;		
		}
			
		has_sidelist_holder = $(calendar).parent().find('.rhc-sidelist').length>0 ? true : false;
		events = sidelist_events || [];
		if( events.length > 0 ){	
			//sidelist tab label
			var tab = $(calendar).parent().find('.rhc-sidelist-holder .rhc-sidelist-tab-label');
			if(tab.length>0 && fc_options.sidelist && fc_options.sidelist.labels && fc_options.sidelist.labels.tab){
				tab.html(fc_options.sidelist.labels.tab);
			}					
	
			render_sidelist(calendar, events, view.name, fc_options);	
		}	
		sidelist_events=[];
		//--
		
		if( -1 == $.inArray( view.name, ['rhc_event','rhc_gmap'] ) ){
			//TODO:load all tooltip details at once.		
		}
		
		$('body').trigger('cb_view_display', [for_widget, calendar, view, element] );
	}
	
	function render_tax_filters( fc_options ){
		var settings = fc_options && fc_options.taxfilter ? fc_options.taxfilter : {
			holder_class: 'rh-flat-ui fc-head-control',
			selectpicker: true,
			size: 10,
			menu_class: 'tax_filter_menu_medium',
			multiple: ( ( fc_options.tax_filter_multiple && parseInt(fc_options.tax_filter_multiple) ) ? true : false )
		};	
		var holder = $(this);
		if( $(this).find("[class*='fc-button-btn_tax_']").length > 0 ){
			holder.addClass('rhc-has-tax-filter');		
		}
		$(this).find("[class*='fc-button-btn_tax_']").each(function(i,el){
			var taxonomy = (el.className.match(/(^|\s)(fc\-button\-btn_tax_([^\s]*))/) || [,,''])[3];
			
			var dropdown = $('<select class="selectpicker"></select>');
			if(settings.multiple){
				dropdown.attr('multiple',true);
			}
			//console.log(taxonomy,el);	
			dropdown
				.attr('data-taxonomy', taxonomy)
				.append($('<option value="">' + $(this).html() + '</option>'))
			;
			
			holder.find(".fbd-filter[data-taxonomy='" + taxonomy + "']").each(function(e,c){
				var bgcolor = $(c).data('bgcolor')||'transparent';
				dropdown.append(
					$('<option data-bgcolor="' + bgcolor + '" value="' + $(c).val() + '">' + $(c).closest('label').find('.fbd-term-label').html() + '</option>')
				);
			});			
		
			if(dropdown.find('option').length>1){
				$(el).replaceWith( dropdown );
				dropdown.wrap(
					$('<div class="tax_filter_holder fc-button fc-state-default"></div>')
						.addClass(settings.holder_class)
						.addClass(settings.menu_class)
				);
			}else{
				$(el).remove();
				console.log('Taxonomy filter added to calendar, but disabled in options.  Also turning off the hierarchical filter can help.');
			}
			
			if( settings.selectpicker ){
				dropdown.selectpicker({
					style: 'btn-small btn-taxfilter btn_tax',
					size: settings.size
				});	
				var have_color = false;
				var dropdown_menu = dropdown.parent().find('.dropdown-menu');	
				dropdown.find('option').each(function(i,option){
					bgcolor = $(option).attr('data-bgcolor')||'transparent';
					if('transparent'!=bgcolor)have_color=true;
					dropdown_menu.find('li[rel="' + i + '"] a')
						.prepend( $('<span class="rhc-term-color"></span>').css('background-color',bgcolor).addClass(('transparent'==bgcolor?'rhc-no-color':'')) )
					;
				});	
				if(have_color){
					dropdown_menu.addClass('rhc-with-tax-color');
				}
			}
			
			dropdown.unbind('change', tax_filter_change).bind('change', {taxonomy:taxonomy,holder:holder}, tax_filter_change);
		});
	}
	
	function tax_filter_change(e){
		$(this).attr('rel', $(e.data.holder).attr('id') );
		var value = $(this).val();
		value = null==value ? '' : value;
		var values = [];
		
		if( 'string'==typeof value ){
			values.push(value);
		}else{
			$.each( value, function(i,v){
				if( ''==v )return true;
				values.push(v);	
			});		
		}

		e.data.holder.find(".fbd-filter[data-taxonomy='" + e.data.taxonomy + "']").each(function(e,c){
			if( -1 == $.inArray( $(c).val(), values ) ){
				$(c).attr('checked', false);
			}else{
				$(c).attr('checked', true);
			}
		});			
		methods.apply_filter.apply( $(this),[false]);
		return true;
	}
	
	function render_sidelist(calendar, events, view_name, fc_options){
		//render events
		$.each(events,function(i,event){
			var skip_sidelist = event.skip_sidelist || false;
			//--- render on event list		
			if(!skip_sidelist && view_name=='rhc_gmap' && has_sidelist_holder ){
				if(fc_options.sidelist && fc_options.sidelist.template && $(fc_options.sidelist.template).length>0){
					$(calendar).parent().find('.rhc-sidelist-holder').addClass('has-events');
					sidelist = $(calendar).parent().find('.rhc-sidelist');
					render_sidelist_event( sidelist, event, fc_options );
				}
			}
		});
		$('.rhc-sidelist-event-item').show();	
	}
	
	function render_sidelist_event( sidelist, event, fc_options ){	
		jQuery(document).ready(function($){
					//---- filter out expired events
					var s = new Date(event.start);
					var now = new Date();
					now.setHours(0,0,0,0);
					if( s.getTime() < now.getTime() ){
						return false;
					} 
					//-----
					var item = $(fc_options.sidelist.template).clone();
					item.attr('id','').addClass('rhc-sidelist-event-item');
					//title
				
					if( event.url && ''!=event.url && event.url!='javascript:void(0);'){					
						var target = fc_options.sidelist.link_target || '_BLANK';
						target = ''==target?'_BLANK':target;
						var title = $('<a href="' + event.url + '">' + event.title + '</a>')
						 	.attr('target',target)
						 	.attr('href','javascript:void(0);')	
						 	.bind('click',function(e){
						 		var click_method = fc_options.eventClick?fc_options.eventClick:fc_click;
						 		event.fc_click_link = 'page';
								event.fc_click_target = target;
								click_method(event,e,null);
						 	})							
						;
					}else{
						var title = $('<span></span').html(event.title);
					}
					item
						.find('.rhc-sidelist-title').empty()
						.append(title)
					;
					//date
					var date_format = item.find('.rhc-sidelist-date').html();
					item.find('.rhc-sidelist-date').html(
						$.fullCalendar.formatDate(event.start,date_format,fc_options)
					);
					//image
					if( event.image && event.image[0] && event.image[0]!='' ){
						var image = $('<img></img>').attr('src',event.image[0]);
					}	
					//handle venue directory
					if( event.venue_directory ){
						item
							.addClass('venue-directory-item')
							.find('.rhc-sidelist-date').hide()
						;
					}
						
					item.find('.rhc-sidelist-image').append(image);			
			
					sidelist
						.append(item.show())
					;
		});
	}
	
	function cb_events_loading(main_holder, fc_holder, isLoading, view, calendar, fc_options){
	 	if( fc_options.for_widget ){
			if(view.loading)view.loading( isLoading, view, fc_options );
			handle_loading_overlay( main_holder, fc_holder, isLoading, view, calendar, fc_options );
			if(isLoading){
				$( main_holder ).find('.fc-have-event').each(function(i,inp){
					$(this)
						.removeClass('fc-state-highlight')
						.removeClass('fc-have-event')
						.css('background-image','')
					;
				});
			}else{
				cb_events_loaded( fc_holder, calendar, view, fc_options);
			}		
		}else{
			if(view.loading)view.loading( isLoading, view, fc_options );
			if(!isLoading){			
				cb_events_loaded( fc_holder, calendar, view, fc_options );
			}
			
			handle_loading_overlay( main_holder, fc_holder, isLoading, view, calendar, fc_options );
		}
	}
	
	function handle_loading_overlay( main_holder, fc_holder_notused, isLoading, view, calendar, fc_options ){
		if( 'undefined'==typeof(fc_options.loadingOverlay)||'1'!=fc_options.loadingOverlay)return;
		if( isLoading ){
			//--placeholder for a loading overlay
			if( 0==$( main_holder ).find('.fc-content .fc-view-loading').length  ){
				$( main_holder ).find('.fullCalendar .fc-content')
					.prepend(
						$('<div class="fc-view-loading"></div>')
							.hide()
							.append('<div class="fc-view-loading-1 ajax-loader"><div class="fc-view-loading-2x xspinner icon-xspinner-3"></div></div>')
					)	
				;								
			}
		
			$( main_holder )
				.addClass('is-loading')
				.find('.fc-view-loading')
				.addClass('loading-events')
				.find('.ajax-loader').addClass('loading-events').end()
				.stop()
				.fadeIn()
			;				
		}else{					
			$( main_holder )
				.removeClass('is-loading')
				.find('.fc-view-loading').stop().fadeOut('fast',function(){
				$( main_holder ).find().remove('.fc-view-loading');
				if(view.name=='rhc_event'){
					$( main_holder ).find('.fc-view-rhc_event').css('min-height','');
				}						
			});
		}
	}
	
	function cb_events_loaded(el,_calendar,view,fc_options){	
		calendar = el;	
				
		if( fc_options.tax_filter && fc_options.tax_filter!='1')return;
		if( $(calendar).find('.fc-head-control').length==0 )return;

		var events = $(calendar).fullCalendar('clientEvents');
		var taxonomies = [];
		$.each(events,function(i,ev){	
			if( ev.terms && ev.terms.length>0 ){
				$.each(ev.terms,function(j,term){
				
					if( fc_options.tax_filter_include && fc_options.tax_filter_include.length > 0 ){
						if( -1 == $.inArray(term.taxonomy,fc_options.tax_filter_include) ){
							return;
						}
					}else if( fc_options.tax_filter_skip && -1!=$.inArray(term.taxonomy,fc_options.tax_filter_skip) ){
						return;
					}
				
					var existing_index = -1;
					for(var a=0;a<taxonomies.length;a++){
						if(taxonomies[a].taxonomy==term.taxonomy){
							existing_index = a;
							break;
						}
					}
					
					//				
					var value = '';
					if(term.gaddress){
						value = term.gaddress;
					}else if(term.description){
						value = term.description;
					}else if(term.name){
						value = term.name;
					}else{
						value = 'unknown';
					}
	
					var val = {
						value:value,
						order: term.term_priority?parseInt(term.term_priority):0,
						local_feed: ev.local_feed,
						term: term
					};
			
					if(existing_index==-1){
						taxonomies[taxonomies.length]={
							taxonomy: term.taxonomy,
							label: term.taxonomy_label,
							terms: [value],
							uterms: [val],//unsorted terms
							print_priority: term.print_priority?parseInt(term.print_priority):0,
							filter_type: term.filter_type?term.filter_type:'',
							color: term.color||'',
							background_color: term.background_color||''
						};					
					}else{
						if(-1==$.inArray(value, taxonomies[existing_index].terms ) ){
							taxonomies[existing_index].terms.push(value);
							taxonomies[existing_index].uterms.push(val);
						}
					}
				});
			}
		});
		
		if( fc_options.tax_filter_include && fc_options.tax_filter_include.length > 0 && taxonomies.length > 0 ){
			new_taxonomies = [];
			$.each( fc_options.tax_filter_include, function(i,filter_taxonomy){
				$.each( taxonomies, function(j,tax){
					if( filter_taxonomy==tax.taxonomy ){
						new_taxonomies[new_taxonomies.length]=tax;
					}
				});
			});
			taxonomies = new_taxonomies;
		} 

		//render form for fc-head-control
		if(taxonomies.length>0){
			var cont = $(calendar).find('.fc-head-control .tax_filter_holder');
			cont.empty();
			cont.parents('.fc-head-control').removeClass('has-filters');

			$.each(taxonomies,function(i,tax){
				if(tax.terms.lengt==0)return;
				
				//sort terms
				tax.uterms.sort(cb_sort_tax_filter);
				tax.terms = [];

				var last_order = false;
				var is_sorted = false;
				$.each(tax.uterms,function(i,t){
					if( last_order && last_order!=t.order ){
						is_sorted=true;
					}
					last_order = t.order;
					tax.terms.push(t.value);
				});
				
				if( !is_sorted ){
					tax.terms.sort();
					tax.uterms.sort(cb_sort_alphanum);
				}
		
				var sel = $('<select></select>')
					.attr('title',tax.label)
					.attr('multiple','multiple')
					.addClass('tax_filter_field')
					.addClass('selectpicker')
					.data('taxonomy',tax.taxonomy)
					.data('taxonomy_filter_type',tax.filter_type)
					.append('<option value="">' + tax.label + '</option>')
				;
			
				$.each(tax.uterms,function(j,t){
					bgcolor = t.term.background_color || 'transparent';		
					option_label = t.term && t.term.name ? t.term.name : t.value ;
					_option = $('<option value="'+t.value+'">'+ option_label +'</option>').data('term',t) ;
					_option.attr('data-bgcolor', bgcolor );
					sel
						.append( _option )
					;
				});
				
				sel
					.appendTo(cont)
					.wrap('<div class="tax_filter_item_holder"></div>')
					.selectpicker({
						style: 'btn-small btn-taxfilter'
					})
				;
				//----
				var have_color = false;
				var dropdown_menu = sel.parent().find('.dropdown-menu');	
				sel.find('option').each(function(i,option){
					bgcolor = $(option).attr('data-bgcolor')||'transparent';
					if('transparent'!=bgcolor)have_color=true;
					dropdown_menu.find('li[rel="' + i + '"] a')
						.prepend( $('<span class="rhc-term-color"></span>').css('background-color',bgcolor).addClass(('transparent'==bgcolor?'rhc-no-color':'')) )
					;
				});	
				if(have_color){
					dropdown_menu.addClass('rhc-with-tax-color');
				}
				//----				
				cont.parents('.fc-head-control').addClass('has-filters');
				
			});		
			//--
			cont.find('.tax_filter_field')
				.change(function(e){			
					var calendar = $(this).parents('.fullCalendar');
					var tax_filters = [];
					$(calendar).find('.tax_filter_field').each(function(i,el){
						$(el).find('option:selected').each(function(j,option){
							var value = $(option).attr('value');
							if(value=='')return;
							var filter_type = $(el).data('taxonomy_filter_type');
							var o = $(option).data('term');
				
							tax_filters.push({
								taxonomy: $(el).data('taxonomy'),
								term: value,
								filter_type: filter_type,
								slug: o.term && o.term.slug?o.term.slug:null ,
								term_id: o.term && o.term.term_id ? o.term.term_id : null,
								local_feed: o.local_feed 
							});							
						});
					});
	
					if($(calendar).parent().find('.rhc-sidelist').length>0){//there could be a better place to locate this, a callback maybe.
						$(calendar).parent().find('.rhc-sidelist-holder').removeClass('has-events');
						$(calendar).parent().find('.rhc-sidelist').empty();//clear list of events (floating sidelist);
					}
					
					args = {tax_filters:tax_filters};
					if( fc_options.show_ad ){
						args.show_ad = fc_options.show_ad;
					}
					
					$(calendar)
						.data('rhc_tax_filters',tax_filters)
						.fullCalendar('rerenderEvents')
					;
			
					$('BODY').trigger( 'rhc_filter', args );
				})
			;					
		}	
	
		return;	
	}
	
	function cb_view_display( for_widget, calendar, view, element ){
		if(!calendar){
			calendar = $(view.element).parents('.fullCalendar');
		}
		
		set_fc_small(calendar);
		
		var _view = $(calendar).fullCalendar('getView');		
		if(_view.name=='rhc_gmap'){//hardcoded. for now only map view needs this filtering.
			$(calendar).find('.fc-head-control').addClass('show-control');
		}else{
			$(calendar).find('.fc-head-control').removeClass('show-control');
		}
		
		//--
		if(_view.name=='rhc_event'){
			$(element).parents('.rhc_holder').addClass('view-rhc_event');
		}else{
			$(element).parents('.rhc_holder').removeClass('view-rhc_event');
		}
		
		$(calendar).data('rhc_tax_filters',[]);
		$(calendar).find('.tax_filter_field').each(function(i,el){
			$(el).val('');
		});		
		
		var now = new Date();
		if( view.visStart <= now && view.visEnd >= now ){
			$(element).parents('.rhc_holder')
				.addClass('has-current-date')
				.removeClass('not-current-date')
			;
		}else{
			$(element).parents('.rhc_holder')
				.removeClass('has-current-date')
				.addClass('not-current-date')
			;		
		}

		if( view.name == 'month' ){
			//why dont we just test this in the first place? posibly because has-current-date is used by addon and other kind of view.
			if( $(element).parents('.rhc_holder').find('.fc-today').length>0 && $(element).parents('.rhc_holder').find('.fc-today').is('.fc-other-month') ){
				$(element).parents('.rhc_holder')
					.removeClass('has-current-date')
					.addClass('not-current-date')
				;	
			}
		}
		
		if( $(element).parents('.rhc_holder').is('.flat-ui-cal') ){			
			var data = $(calendar).parents('.rhc_holder').data('Calendarize');
			var fc_options = data.modes[data.mode].options;
			if( $(element).parents('.rhc_holder').is('.has-current-date') ){
				try {
					var hformat = $("<div/>").html(fc_options.widget_hformat).text();
				}catch(e){
					var hformat = null;
				}
				//fc_options.flatui_header_format = "'<span class=''fuiw-month''>'d. MMM yyyy'</span>'";
				var _format = hformat || "'<span class=''fuiw-dayname''>'dddd'</span><span class=''fuiw-month''>'MMMM'</span><span class=''fuiw-year''>'yyyy'</span><span class=''fuiw-day''>'d'</span>'";
				$(calendar).find('.fc-header-title h2').html( $.fullCalendar.formatDate(now, _format, fc_options) );
			}else{
				str = $(calendar).find('.fc-header-title h2').html();
				str = str.trim();
				var res = str.split(" ");	
				if(res.length==2){
					if( isNaN(res[1]) ){
						_format = "<span class='fuiw-month'>" + res[1] + "</span><span class='fuiw-year'>" + res[0] + "</span>";
					}else{
						_format = "<span class='fuiw-month'>" + res[0] + "</span><span class='fuiw-year'>" + res[1] + "</span>";
					}
					$(calendar).find('.fc-header-title h2').html(_format);
				}
			}
			
			_skip = fc_options.widget_onechardaylabel && 1==parseInt( fc_options.widget_onechardaylabel ) ? true : false ;
			if( !_skip ){
				$(calendar).find('.fc-day-header').each(function(i,el){
					$(el).html( $(el).html().substring(0,1) );
				});			
			}

		}
	}
	
	function cb_sort_tax_filter( o, p ){
		if(o.order>p.order){
			return 1;
		}else if(o.order<p.order){
			return -1;
		}else{
			return 0;
		}
	}
	
	function cb_sort_alphanum( o, p ) {
	    a = o.value.toString();
		b = p.value.toString();
		var reA = /[^a-zA-Z]/g;
		var reN = /[^0-9]/g;		
		var aA = a.replace(reA, "");
	    var bA = b.replace(reA, "");
	    if(aA === bA) {
	        var aN = parseInt(a.replace(reN, ""), 10);
	        var bN = parseInt(b.replace(reN, ""), 10);
	        return aN === bN ? 0 : aN > bN ? 1 : -1;
	    } else {
	        return aA > bA ? 1 : -1;
	    }
	}	
	
	function add_footer_button( options ){
		var settings = $.extend( {
			'calendarize': null, //Calendarize element
			'calendar': null, //fullCalendar instance
			'e':null,
			'tm':'fc',
			'buttonName':'undefined',
			'label':'',
			'buttonClick':function(f,btn,e) {}
		}, options);			
		
		tm = settings.tm;
		
		var button = $(
			"<span class='fc-button fc-button-" + settings.buttonName + " " + tm + "-state-default '>" +
				"<span class='fc-button-inner'>" +
					"<span class='fc-button-content'>" + 
					settings.label +
					"</span>" +
					"<span class='fc-button-effect'><span></span></span>" +
				"</span>" +
			"</span>" 
		);		
		if (button) {
			button
				.click(function(e) {
					if (!button.hasClass(tm + '-state-disabled')) {
						settings.buttonClick( this, e, settings);
					}
				})
				.mousedown(function() {
					button
						.not('.' + tm + '-state-active')
						.not('.' + tm + '-state-disabled')
						.addClass(tm + '-state-down');
				})
				.mouseup(function() {
					button.removeClass(tm + '-state-down');
				})
				.hover(
					function() {
						button
							.not('.' + tm + '-state-active')
							.not('.' + tm + '-state-disabled')
							.addClass(tm + '-state-hover');
					},
					function() {
						button
							.removeClass(tm + '-state-hover')
							.removeClass(tm + '-state-down');
					}
				)
				.appendTo( settings.e );
			
			button.addClass(tm + '-corner-left');
			button.addClass(tm + '-corner-right');
		}	
	}
	
	function ical_footer_button_click( btn, e, settings){
		var calendarize = settings.calendarize; f
		if( $(btn).parent().find('.ical-tooltip').length>0 ){
			$(btn).parent().find('.ical-tooltip').remove();
		}else{
			var data = $(calendarize).data('Calendarize');
			var options = data.modes[data.mode].options;
			var url = options.events_source + options.events_source_query;
			url = url.replace('get_calendar_events','get_icalendar_events');
			var url2 = url + '&ics=1';

			var feed = options.feed && ''!=options.feed ? '&feed=' + options.feed : '';
			url = url + feed;
			url2 = url2 + feed;
			
			var tooltip = $('.ical-tooltip-template').first().clone();
			tooltip
				.removeClass('ical-tooltip-template')
				.addClass('ical-tooltip')
				.find('.ical-url').html(url).end()
				.find('.ical-clip')
					.attr('href',url)
					.on('click',function(e){
			            $(this).focus();
			            $(this).select();
						return false;

					})
					.end()
				.find('.ical-close')
					.on('click',function(e){
						$(this).parents('.fc-footer').find('.fc-button-icalendar').trigger('click');
					})
				.end()
				.find('.ical-ics').attr('href',url2).end()
			;						
			$(btn).after( tooltip );
			
			tooltip.fadeIn('fast',function(e){
				tooltip
					.find('textarea.ical-url')
					.focus()
					.select()
				;
			});
		}					
	}
	
	function cb_dayclick(date,allDay,jsEvent,view,fc_options,_this){
		if( fc_options.dayclick ){
			var fn = fc_options.dayclick && ''!=fc_options.dayclick && window[fc_options.dayclick] ? window[fc_options.dayclick] : false; 
			if( fn ){
				return fn( date,allDay,jsEvent,view,fc_options,_this );
			}
		}else{
			var fn = fc_options.widget_dayclick && ''!=fc_options.widget_dayclick && window[fc_options.widget_dayclick] ? window[fc_options.widget_dayclick] : false; 
			if( fn ){		
				calendar_widget_day_click( date,allDay,jsEvent,view, rhc_events_cache, fc_options, _this );
			}else if(fc_options.widget_link){
				if(fc_options.widget_link_view){
					var _view = fc_options.widget_link_view;
				}else{
					var _view = 'agendaDay';
				}
				$('<form method="post" />')
					.attr('action',fc_options.widget_link)
					.append('<input type="hidden" name="gotodate" value="'+ $.fullCalendar.formatDate( date, 'yyyy-MM-dd' ) +'" />')
					.append('<input type="hidden" name="defaultview" value="'+ _view +'" />')
					.append('<input type="hidden" name="fcalendar" value="'+ (fc_options.ev_calendar?fc_options.ev_calendar:'') +'" />')
					.append('<input type="hidden" name="fvenue" value="'+ (fc_options.ev_venue?fc_options.ev_venue:'') +'" />')
					.append('<input type="hidden" name="forganizer" value="'+ (fc_options.ev_organizer?fc_options.ev_organizer:'') +'" />')
					
					.appendTo(_this)
					.submit()
				;
			}		
		}
	}	
})(jQuery);


(function($){
	var methods = {
		init : function( options ){
			var settings = $.extend( {
				'draggable':true
			}, options);		

			return this.each(function(){
				var data = $(this).data('CalendarizeDialog');
				if(!data){
					$(this).data('CalendarizeDialog',settings);
					if(settings.draggable){$(this).draggable({handle:'.ui-widget-header'});}
					$(this).find('.ui-dialog-titlebar-close').on('click',function(e){$(this).parent().parent().parent().CalendarizeDialog('close');});	j	
				}
				$(this).hide();
			});
		},
		open : function ( o ){
			$(this)
				.show()
				.css('margin-left',0)
				.offset( o.offset )
				.css('margin-left', o.margin_left )
			;
		},
		close : function (){
			$(this).hide();
		}
	};
	$.fn.CalendarizeDialog = function( method ) {
		if ( methods[method] ) {
			return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
		} else if ( typeof method === 'object' || ! method ) {
			return methods.init.apply( this, arguments );
		} else {
			$.error( 'Method ' +  method + ' does not exist on jQuery.CalendarizeDialog' );
		}    
	};
})(jQuery);

(function($){
	var methods = {
		init : function( options ){
			var settings = $.extend( {
				'todo':	false
			}, options);			
			
			return this.each(function(){
				var gmap = $(this);
				//--init map
				var data = gmap.data('rhc_gmap');
				if( !data ){
					gmap.data('rhc_gmap',true);
				
					init_gmap( gmap, get_markers( gmap ), 0 );
					return true;
				}
			});
		}
	};
	
	function get_markers( gmap ){
		var markers = [];
		gmap.children().each(function(i,el){		
			markers.push({
				name: $(el).html(),
				lon: $(el).data('glon'),
				lat: $(el).data('glat'),
				info: $(el).data('ginfo'),				
				address: $(el).data('gaddress'),
				marker_active: $(el).data('marker_active'),
				marker_inactive: $(el).data('marker_active'),
				marker_size: $(el).data('marker_size')
			});
		});
		return markers;
	}
	
	function init_gmap( gmap, markers, depth ){
		depth++;
		if( depth > 10 ) return false;		
		if( 'interactive' != gmap.data('type') ) return false;
		if( markers.length==0 ) return false;
		//-- markers
		function make_geocode_callback( markers, a ){
			var geocodeCallBack = function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					latlng = results[0].geometry.location;
					
					markers[a].lat = latlng.lat();
					markers[a].lon = latlng.lng();
				}
				return init_gmap( gmap, markers, depth);
			}
			return geocodeCallBack;
		}
		
		for( var a=0; a < markers.length ; a++ ){
			if( !markers[a].lat && !markers[a].lon && markers[a].address ){				
				var geocoder_map = new google.maps.Geocoder();
				geocoder_map.geocode( { 'address': markers[a].address}, make_geocode_callback( markers, a ) );	
				return;			
			}	
		}

		/*
		size = gmap.data('size');
		size_arr = size.split('x');
		*/
		gmap.uniqueId();
		
		ratio = gmap.data('ratio');
		ratio = ''==ratio?'4:3':ratio;
		ratio_arr = ratio.split(':');
		
		h = gmap.width() * ratio_arr[1] / ratio_arr[0] ;
		gmap.height( h );
   		//--
   		maptype = gmap.data('maptype') || 'ROADMAP' ;
   		//--
   		settings = {
   			mapTypeId: google.maps.MapTypeId[maptype],
   			center: new google.maps.LatLng( markers[0].lat, markers[0].lon )
   		};
   		if( gmap.data('zoom') ){
   			settings.zoom = gmap.data('zoom');
   		}
   		
		var map = new google.maps.Map( gmap.get(0) , settings);

		var bounds = new google.maps.LatLngBounds();
		var infowindow = new google.maps.InfoWindow();
		
		//-- add markers to map
		$.each( markers, function(i,data){			

			marker = new google.maps.Marker({
				position: new google.maps.LatLng( data.lat, data.lon ),
				map: map
			});
	
			bounds.extend(marker.position);			
			google.maps.event.addListener(marker, 'click', (function(marker, i) {
				return function() {
					infowindow.setContent((data.info||data.name||data.address));
					infowindow.open(map, marker);
				}
			})(marker, i));			
		});
		
				
		if( markers.length > 1 ){
			map.fitBounds(bounds); 
			/* resets to original zoom
			var listener = google.maps.event.addListener(map, "idle", function () {
				map.setZoom( gmap.data('zoom')||3 );
				google.maps.event.removeListener(listener);
			});	
			*/
		}
	}
		
	$.fn.rhcGmap = function( method ) {
		if ( methods[method] ) {
			return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
		} else if ( typeof method === 'object' || ! method ) {
			return methods.init.apply( this, arguments );
		} else {
			$.error( 'Method ' +  method + ' does not exist on jQuery.rhcGmap' );
		}    
	};
})(jQuery);

function fc_mouseover(calEvent, jsEvent, view){

}

function fc_event_details(calEvent, jsEvent, view){
	calEvent.id = calEvent.id.replace('@','_');//google cal.
	calEvent.id = calEvent.id.replace('.','_');//google cal.	
	if(calEvent.gcal && calEvent.description){
		calEvent.description = calEvent.description.replace(/\n/g, '<br />');
	}
	jQuery(document).ready(function($){
		var tooltip_target = view.calendar.options.tooltip.target||'_self';
		if(calEvent.fc_click_target){
			tooltip_target = calEvent.fc_click_target
		}
	
		view.calendar.rhc_search(view.calendar,jsEvent,true);	
		var id = 'fct-'+calEvent.id;
		if( $('BODY').find('#'+id).length>0 ){
			$('BODY').find('#'+id).remove();
		}
	
		if( $('BODY').find('#'+id).length==0 ){
			$('BODY').find('#fct-item-template').clone()
				.attr('id',id)
				.addClass('fct-tooltip')
				.bind('close-tooltip',function(e){
					$(this).animate({opacity:0},'fast','swing',function(e){$(this).remove();});
				})
				.find('.fc-close-tooltip a').on('click',function(e){
					$('.fct-tooltip').trigger('close-tooltip');
				}).end()
				.appendTo('BODY');
		}
	
		if( $('BODY').find('#'+id).length>0 ){
			var pos = $(jsEvent.target).offset();
			var view_pos= view.element.offset();
			
			var tip_left = pos.left<(view_pos.left + view.element.width()/2)?true:false;
			var tip_pos = tip_left?'fc-tip-left':'fc-tip-right';
			
			$('.fct-tooltip:not(#'+id+')').trigger('close-tooltip');
		
			var tooltip = $('BODY').find('#'+id);		
			
			$('BODY').trigger('rhc_tooltip_before_show', [calEvent, tooltip, view] );	
			
			tooltip
				.stop()
				.addClass(tip_pos)
				.find('.fc-description').html(calEvent.description).end()
				.css('opacity',0)
				.show()
			;
			if(calEvent.color){
				tooltip.css('border-left-color', calEvent.color);
			}

			if( calEvent.source && calEvent.source.fc_click_target && '_nolink' == calEvent.source.fc_click_target ){
				calEvent.url = false;			
			}

			if( ! parseInt(view.calendar.options.tooltip.image) ){
				calEvent.image = false;
			}
			
			if(calEvent.url){
				var url = calEvent.url;
				if(calEvent.fc_rrule && ''!=calEvent.fc_rrule){			
					/*
					var start = new Date(calEvent.start);			
					var start_seconds = parseInt(start.getTime() / 1000);	
					url = _add_param_to_url(url,'event_start',start_seconds);
					*/
				}
				
				tooltip_click = function(e){
					jQuery('form#calendarizeit_repeat_instance').remove();
					var form = '<form id="calendarizeit_repeat_instance" method="post"></form>';
					jQuery(form)
						.attr('target',tooltip_target)
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
					jQuery('form#calendarizeit_repeat_instance')
						.submit(function(e){
							e.stopPropagation();
							return true;
						})
						.submit()
					;	
					return false;
				}
				
				var title_is_link = !(view.calendar.options.tooltip&&view.calendar.options.tooltip.disableTitleLink&&view.calendar.options.tooltip.disableTitleLink=='1');			
				if( !title_is_link || calEvent.gcal || calEvent.url=='javascript:void(0);'){
					tooltip.find('.fc-title').html( calEvent.title );
				}else{
					if(calEvent.direct_link){
						//fb doesnt likes that you post
						$('<a></a>')
							.attr('href', url )					
							.html( calEvent.title )
							.attr('target',tooltip_target)
							.appendTo( tooltip.find('.fc-title') )
						;	
					}else{
						$('<a></a>')
							.attr('href', url )
							//.attr('href','javascript:void(0);')	
							.bind('click',tooltip_click)			
							.html( calEvent.title )
							.attr('target',tooltip_target)
							.appendTo( tooltip.find('.fc-title') )
						;						
					}		
				
				}

				if(calEvent.image && calEvent.image[0]){
					if(calEvent.direct_link){
						$('<a></a>')
							.attr('href', url )
							.attr('target',tooltip_target)
							.append(
								$('<img />').attr('src', calEvent.image[0])
							)
							.appendTo( tooltip.find('.fc-image') )
						;					
					}else{
						$('<a></a>')
							.attr('href', url )
							//.attr('href', 'javascript:void(0);' )
							.bind('click',tooltip_click)
							.attr('target',tooltip_target)
							.append(
								$('<img />').attr('src', calEvent.image[0])
							)
							.appendTo( tooltip.find('.fc-image') )
						;
					}

				}	
			}else{
				tooltip.find('.fc-title').html(calEvent.title);
				
				if(calEvent.image && calEvent.image[0]){
					$('<img />')
						.attr('src', calEvent.image[0])
						.appendTo( tooltip.find('.fc-image') )
					;
				}				
			}
			
			tooltip.find('.fc-start,.fc-end,.fc-hide').hide();
	
			if(calEvent.allDay){
				if(calEvent.start){
					tooltip.find('.fc-start').append(
						$('<span></span>').html( $.fullCalendar.formatDate( calEvent.start, view.calendar.options.tooltip.startDateAllDay, view.calendar.options ) )
					 ).show();
				}
				if(calEvent.end){
					tooltip.find('.fc-end').append(
						$('<span></span>').html( $.fullCalendar.formatDate( calEvent.end, view.calendar.options.tooltip.endDateAllDay||view.calendar.options.tooltip.startDateAllDay, view.calendar.options ) )
					 ).show();
				}					
			}else{
				if(calEvent.start){
					tooltip.find('.fc-start').append(
						$('<span></span>').html( $.fullCalendar.formatDate( calEvent.start, view.calendar.options.tooltip.startDate, view.calendar.options ) )
					 ).show();
				}
				if(calEvent.end){
					tooltip.find('.fc-end').append(
						$('<span></span>').html( $.fullCalendar.formatDate( calEvent.end, view.calendar.options.tooltip.endDate||view.calendar.options.tooltip.startDate, view.calendar.options ) )
					 ).show();
				}			
			}
			
			if(calEvent.terms && calEvent.terms.length>0){
				$.each(calEvent.terms,function(i,term){
					if(term.gaddress && calEvent.local_feed ){
						var sel = '.fc-term-' + term.taxonomy + '-gaddress';
						if( tooltip.find(sel).find('a').length>0 ){
							tooltip.find(sel).append( '<span class="rhc-tooltip tax-term-divider"></span>' );
						}
						$('<a></a>')
							.attr('href', 'http://www.google.com/maps?f=q&hl=en&source=embed&q='+escape(term.gaddress) )
							.html( term.gaddress )
							.attr('target','_blank')
							.appendTo( tooltip.find(sel).show() )
						;			
					}
					
					if( tooltip.find('.fc-tax-' + term.taxonomy).length>0 ){
						if(term.name==''){			
							tooltip.find('.fc-tax-' + term.taxonomy).hide();
						}else{
							if( tooltip.find('.fc-tax-' + term.taxonomy).find('a').length>0 ){
								tooltip.find('.fc-tax-' + term.taxonomy).append( '<span class="rhc-tooltip tax-term-divider"></span>' );
							}

							if(term.gaddress && false==calEvent.local_feed ){								
								$('<a></a>')
									.attr('href', 'http://www.google.com/maps?f=q&hl=en&source=embed&q='+escape(term.gaddress) )
									.html( term.name )
									.attr('target',tooltip_target)
									.appendTo( tooltip.find('.fc-tax-' + term.taxonomy) )
								;										
							}else if(term.url && term.url!='' && (view.calendar.options.tooltip.taxonomy_links) ){
								$('<a></a>')
									.attr('href', term.url )
									.html( term.name )
									.attr('target',tooltip_target)
									.appendTo( tooltip.find('.fc-tax-' + term.taxonomy) )
								;							
							}else{
								$('<span></span>')
									.html( term.name )
									.appendTo( tooltip.find('.fc-tax-' + term.taxonomy) )
								;	
							}
							
							
							tooltip.find('.fc-tax-' + term.taxonomy)
								.find('.tax-label').html( term.taxonomy_label ).end()
								.show()
							;							
						}
						
					}
				});
			}

			pos.top = pos.top - tooltip.height()/2 + ($(jsEvent.srcElement).height()/2);
			//---adjust tooltip top
			var cal_offset = view.element.offset();		
			var diff = cal_offset.top-pos.top - 5;
			if(diff>0){
				pos.top = pos.top+diff;		
				tooltip.find('.fct-arrow-holder').css('margin-top', diff*-1);			
			}
		
			if( tip_left ){
				pos.left = pos.left + $(jsEvent.target).width();
			}else{
				pos.left = pos.left + tooltip.width()*(-1);
			}
			
			if(view.name=='agendaDay'){
				pos.left = pos.left - tooltip.width() + 50;
			}

			//$('BODY').trigger('rhc_tooltip_before_show', [calEvent, tooltip, view] );	
			tooltip
				//.css('min-height', tooltip.height())
				.css('min-height', '')
				.css('height','auto')
				.offset(pos)
			;		
			
			var client_width = document.documentElement.clientWidth || window.innerWidth;		
			client_right = $(document).scrollLeft() + client_width;
			var tooltip_right = pos.left + tooltip.width(); 
			if( tooltip_right > client_right ){
				pos.left = pos.left - (tooltip_right-client_right) - 12;	
				tooltip
					.offset(pos)
				;					
			}

			tooltip
				.animate({opacity:1},'fast','swing')
			;
			
			tooltip.unbind('mouseleave').bind('mouseleave',function(e){
				var _this = this;
				setTimeout( function(){
					if( $(_this).is(':hover') ) return false;
					if( view.calendar.options.tooltip_on_hover && '1' == view.calendar.options.tooltip_on_hover ){
						$(_this).trigger('close-tooltip');
					}				
				}, 200 );
			

				return true;				
			});
			
			$('BODY').trigger('rhc_tooltip_after_show', [calEvent, tooltip, view] ) ;
		}
	});
}

function no_link(calEvent, jsEvent, view){
	jsEvent.stopPropagation();
	return false;
}

function fc_click_no_action(calEvent, jsEvent, view){
	jsEvent.stopPropagation();
	return false;
}

function fc_click(calEvent, jsEvent, view){		
	var click_link = !calEvent.fc_click_link?'view':calEvent.fc_click_link;
	if(view&&view.name=='rhc_event'&&click_link=='view')click_link='page';//event list with tooltip is redundant.
	if(click_link=='none'){
		return false;
	}
	if('undefined'==typeof calEvent.fc_click_target){
		calEvent.fc_click_target = '_self';
	}	

	if(calEvent.url && click_link=='page' ){
		if(calEvent.fc_click_target && calEvent.fc_click_target!=''){
			fc_event_links_to_page(calEvent, jsEvent, view);
			return false;
		}else{
			return true;
		}
	}else{
		fc_event_details(calEvent, jsEvent, view);
		return false;
	}
}

function fc_event_links_to_page(calEvent, jsEvent, view){
	if(true){
		jQuery('form#calendarizeit_repeat_instance').remove();
		var form = '<form id="calendarizeit_repeat_instance" method="post" target="' + calEvent.fc_click_target + '"></form>';
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
		
		jQuery('form#calendarizeit_repeat_instance')
			.submit(function(e){
				e.stopPropagation();
				return true;
			})
			.submit()
		;	
	}
}

function fc_select(startDate, endDate, allDay, jsEvent, view){
	jQuery(document).ready(function($){
		var offset = $(jsEvent.target).offset();
		var margin_left = $(jsEvent.target).width();
		$('.fc-dialog')
			.CalendarizeDialog('open',{offset:offset,margin_left:margin_left});
		
	});
}

function _add_param_to_url(url, param, paramVal){
	if( url=='javascript:void(0);' ) return url;
    var newAdditionalURL = "";
    var tempArray = url.split("?");
    var baseURL = tempArray[0];
    var aditionalURL = tempArray[1]; 
    var temp = "";
    if(aditionalURL){
        var tempArray = aditionalURL.split("&");
        for ( i=0; i<tempArray.length; i++ ){
            if( tempArray[i].split('=')[0] != param ){
                newAdditionalURL += temp+tempArray[i];
                temp = "&";
            }
        }
    }
    var rows_txt = temp+""+param+"="+paramVal;
    return baseURL+"?"+newAdditionalURL+rows_txt;
}

function _add_repeat_instance_data_to_url(e){
	if(e.repeat_instance){
		if( (e.fc_rrule && ''!=e.fc_rrule)||(e.fc_rdate && ''!=e.fc_rdate) ){
			if(e.using_calendar_url){
				var period = jQuery.fullCalendar.formatDate(  e.start, "yyyy-MM-dd" );
				if( period && ''!=period ){
					e.url = _add_param_to_url(e.url,'gotodate',period);
				}			
			}else{
			
				if(e.src_start && e.fc_date_time && e.src_start==e.fc_date_time){
					
				}else{
					var period = jQuery.fullCalendar.formatDate(  e.start, "yyyyMMddHHmmss" );
					var end = jQuery.fullCalendar.formatDate(  e.end, "yyyyMMddHHmmss" );
					if( period && ''!=period ){
						if(end && ''!=end){
							period = period + ',' + end;
						}
						e.url = '' == e.url ? '' :  _add_param_to_url(e.url,'event_rdate',period);
					}					
				}			
			}
		}	
	}
	return e;
}

function _add_repeat_instance_data_to_event(e){
	if(e.repeat_instance){
		if( (e.fc_rrule && ''!=e.fc_rrule)||(e.fc_rdate && ''!=e.fc_rdate) ){
			if(e.using_calendar_url){
				var period = jQuery.fullCalendar.formatDate(  e.start, "yyyy-MM-dd" );
				if( period && ''!=period ){
					e.gotodate = period;
				}			
			}else{
			
				if(e.src_start && e.fc_date_time && e.src_start==e.fc_date_time){
					
				}else{
					var period = jQuery.fullCalendar.formatDate(  e.start, "yyyyMMddHHmmss" );
					var end = jQuery.fullCalendar.formatDate(  e.end, "yyyyMMddHHmmss" );
					if( period && ''!=period ){
						if(end && ''!=end){
							period = period + ',' + end;
						}
						e.event_rdate = period;
						e.url = '' == e.url ? '' : _add_param_to_url( e.url, 'event_rdate', e.event_rdate );
					}					
				}			
			}
		}	
	}
	return e;
}

function exdate_to_array_of_dates(fc_exdate){
	var fc_exdate_arr = fc_exdate==''?[]:fc_exdate.split(',');
	if( fc_exdate_arr.length>0 ){
		var array_of_dates = [];
		for(a=0;a<fc_exdate_arr.length;a++){
			var _exdate = fc_exdate_arr[a]; 
			array_of_dates[array_of_dates.length] = new Date( _exdate.substring(0,4), _exdate.substring(4,6)-1, _exdate.substring(6,8), _exdate.substring(9,11), _exdate.substring(11,13), _exdate.substring(13,15) );
		}
		return array_of_dates;
	}else{
		return [];
	}		
}

jQuery(document).ready(function($){
	init_rhc();
});

function init_rhc(){
	jQuery(document).ready(function($){
		init_sc_ical_feed();
		$('BODY').bind('dbox.loaded',function(){
			init_sc_ical_feed();
		});
		
		//---- initialize any calendars
		$('.rhc_holder').each(function(i,el){
			var ui_theme = $(el).data('rhc_ui_theme');
			if(''!=ui_theme){
				$("#fullcalendar-theme-css").attr("href",ui_theme);
			}
			var rhc_options = $(el).data('rhc_options');
			eval( '$(el).Calendarize('+rhc_options+')' ); 
		});		
		
		$('.fc-button-custom').hover(function(){
			$(this).addClass('fc-state-hover');
		},function(){
			$(this).removeClass('fc-state-hover');
		});
		
	
		$( window ).resize(function() {
			$('.rhcalendar.not-widget .fullCalendar ').each(function(i,calendar){
				set_fc_small(calendar);
			});
		});
		
		if( !$('BODY').data('rhc_tooltip_before_show') ){
			$('BODY')
				.data('rhc_tooltip_before_show',true)
				.bind('rhc_tooltip_before_show', rhc_tooltip_before_show )
			;
		}
		
		if( !$('BODY').data('rhc_tooltip_contend_loaded') ){
			$('BODY')
				.data('rhc_tooltip_contend_loaded',true)
				.bind('rhc_tooltip_contend_loaded', rhc_tooltip_contend_loaded )
			;
		}
		
		$('.rhc-next').on('click', function(e){
			
		});
	});
}

function init_sc_ical_feed(){
jQuery(document).ready(function($){
	if( $('.rhc-ical-feed-cont').length>0 ){
		$('.rhc-ical-feed-cont').each(function(i,o){
			if( '1'==$(o).data('sc_ical_feed_init') )return;//avoid double init.
			$(o).data('sc_ical_feed_init','1');
			var me = this;
			var e = $(this).parent();
			var text = $(this).data('icalendar_button');
			var tm = $(this).attr('data-theme');
			var buttonName = 'icalendar';
			var icalendar_title = $(this).attr('data-title');
			
			var buttonClick = function(me, jsEvent) {
				var url = 'javascript:alert(1);';
				$(me).width( $(me).data('width') );
				var title = icalendar_title ;
				var offset = $(jsEvent.target).offset();
				var margin_left = $(jsEvent.target).width();
				
				$( me )
					.removeClass('ical-tooltip-holder')
					.addClass('ical-tooltip')
					.CalendarizeDialog('open',{offset:offset,margin_left:margin_left})
				;

			};
			
			$( me ).find('.ical-close').unbind('click').click(function(e){
				$( me ).CalendarizeDialog('close');
			});
			
			if (buttonClick) {
				var button = $(
					"<span class='fc-button fc-button-" + buttonName + " " + tm + "-state-default '>" +
						"<span class='fc-button-inner'>" +
							"<span class='fc-button-content'>" + 
							text +
							"</span>" +
							"<span class='fc-button-effect'><span></span></span>" +
						"</span>" +
					"</span>"
				);
				if (button) {
					button
						.click(function(e) {
							if (!button.hasClass(tm + '-state-disabled')) {
								buttonClick(me, e);
							}
						})
						.mousedown(function() {
							button
								.not('.' + tm + '-state-active')
								.not('.' + tm + '-state-disabled')
								.addClass(tm + '-state-down');
						})
						.mouseup(function() {
							button.removeClass(tm + '-state-down');
						})
						.hover(
							function() {
								button
									.not('.' + tm + '-state-active')
									.not('.' + tm + '-state-disabled')
									.addClass(tm + '-state-hover');
							},
							function() {
								button
									.removeClass(tm + '-state-hover')
									.removeClass(tm + '-state-down');
							}
						)
						.appendTo(e);
					
					button.addClass(tm + '-corner-left');
					button.addClass(tm + '-corner-right');
				}
			}		
		});
	}	
});
}

function get_event_ocurrences(e){
	var fc_start = jQuery.fullCalendar.parseDate( e.start );
	e.fc_rrule = ''==e.fc_rrule?'FREQ=DAILY;INTERVAL=1;COUNT=1':e.fc_rrule;
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
															
	occurrences = scheduler.occurrences_between(start, end);
}

function set_fc_small(calendar){
	if( jQuery(calendar).parent().hasClass('not-widget') ){
		var cw = parseInt( jQuery(calendar).width() ) ;
		mobile_width = RHC.mobile_width || 480 ;
		if( cw > 0 && cw <= mobile_width ){		
			//--- switch view if agenda
			var _view = jQuery(calendar).fullCalendar('getView');	
			if( _view.name=='agendaWeek' ){
				jQuery(calendar).data('restore_agenda_week', true);
				jQuery(calendar).fullCalendar('changeView','basicWeek');	
			}
			if( _view.name=='agendaDay' ){
				jQuery(calendar).data('restore_agenda_day', true);
				jQuery(calendar).fullCalendar('changeView','basicDay');	
			}
			
			
			jQuery(calendar).parent().addClass('fc-small');
			//bug fix, in mobile view there is too much space in the first cell.
			jQuery(calendar).find('td:first-child').each(function(i,el){	
				jQuery(el).find('> div').css('min-height','');
			});			
		} else {
			jQuery(calendar).parent().removeClass('fc-small');
			//-- restore view
			var _view = jQuery(calendar).fullCalendar('getView');
			if( 'basicWeek' == _view.name && jQuery(calendar).data('restore_agenda_week') ){
				jQuery(calendar).data('restore_agenda_week', false);
				jQuery(calendar).fullCalendar('changeView','agendaWeek');	
			}
			if( 'basicDay' == _view.name && jQuery(calendar).data('restore_agenda_day') ){
				jQuery(calendar).data('restore_agenda_day', false);
				jQuery(calendar).fullCalendar('changeView','agendaDay');	
			}
		}		
	}	
}

function rhc_tooltip_before_show(e,calEvent, tooltip, view){
	jQuery(document).ready(function($){
		if( (view.calendar.options.tooltip.enableCustom||false) && calEvent.local_feed ){
			tooltip
				.find('.fct-dbox')
				.hide()
			;// do not show the default content.	
			if( RHC.tooltip_details[calEvent.id] && 'loading'==RHC.tooltip_details[calEvent.id] ){
				setTimeout( function(){ rhc_tooltip_before_show(e,calEvent, tooltip, view); } , 200 );				
			}else if( RHC.tooltip_details[calEvent.id] ){
				if( true===RHC.tooltip_details[calEvent.id] ){
					tooltip
						.find('.fct-dbox')
						.show()				
					;
					return true;
				}
				
				tooltip
					.find('.fct-dbox')
					.empty()
					.show()
					.append( RHC.tooltip_details[calEvent.id].clone() )
				;
				//-- refresh dates for reccurring.
				if(calEvent.allDay){
					if(calEvent.start){
						tooltip.find('.postmeta-fc_start .fe-extrainfo-value,.postmeta-fc_start_datetime .fe-extrainfo-value').html(
							$.fullCalendar.formatDate( calEvent.start, view.calendar.options.tooltip.startDateAllDay, view.calendar.options )
						 );
					}
					if(calEvent.end){
						tooltip.find('.postmeta-fc_end .fe-extrainfo-value,.postmeta-fc_end_datetime .fe-extrainfo-value').html(
							$.fullCalendar.formatDate( calEvent.end, view.calendar.options.tooltip.endDateAllDay||view.calendar.options.tooltip.startDateAllDay, view.calendar.options )
						 );
					}					
				}else{
					if(calEvent.start){
						tooltip.find('.postmeta-fc_start .fe-extrainfo-value,.postmeta-fc_start_datetime .fe-extrainfo-value').html(
							$.fullCalendar.formatDate( calEvent.start, view.calendar.options.tooltip.startDate, view.calendar.options )
						 );
					}
					if(calEvent.end){
						tooltip.find('.postmeta-fc_end .fe-extrainfo-value,.postmeta-fc_end_datetime .fe-extrainfo-value').html(
							$.fullCalendar.formatDate( calEvent.end, view.calendar.options.tooltip.endDate||view.calendar.options.tooltip.startDate, view.calendar.options )
						 );
					}			
				}		
				
				$('BODY').trigger('rhc_tooltip_contend_loaded', [e, calEvent, tooltip, view] );		
			}else{
				$.post(RHC.ajaxurl,{
		        		'rhc_action' : 'rhc_tooltip_detail',
						'id': calEvent.id,
						'event_rdate':calEvent.event_rdate
				},function(data){
						if( $(data).find('.fe-extrainfo-holder').length>0 ){
							RHC.tooltip_details[calEvent.id] = $(data).clone();
							rhc_tooltip_before_show(e,calEvent, tooltip, view);
						}else{
							RHC.tooltip_details[calEvent.id] = true;
						}				
				},'html');
			}		
		}
	});
	return true;
}

function cb_event_mouseover( calEvent, e, view ){
	jQuery(document).ready(function($){
		if( (view.calendar.options.tooltip.enableCustom||false) && calEvent.local_feed ){
			if( RHC.tooltip_details[calEvent.id] ){
			}else{
				RHC.tooltip_details[calEvent.id] = 'loading';
				url = RHC.ajaxurl;
				url = url + '?rhc_action=rhc_tooltip_detail&id=' + calEvent.id + '&event_rdate=' + calEvent.event_rdate;  
				var now = new Date();
				ver = RHC.last_modified && ''!=RHC.last_modified ? RHC.last_modified : now.getTime() ;
				url = url + '&ver=' + ver;  

				queryString = url.substring( url.indexOf('?') + 1 );	

				hash = CryptoJS.MD5( queryString )
				u = hash.toString(CryptoJS.enc.Hex);	
		
				url = url + '&_=' + u ;
				
				$.get( url,{},function(data){			
						if( $(data).find('.fe-extrainfo-holder').length>0 ){
							RHC.tooltip_details[calEvent.id] = $(data).clone();
						}else{
							RHC.tooltip_details[calEvent.id] = true;
						}				
				},'html');
			}		
		}
	});
	return true;
}

function rhc_tooltip_contend_loaded( args ){
	init_sc_ical_feed();
}

function calendar_widget_day_click( date,allDay,jsEvent,view, rhc_events_cache_notused, fc_options, _this ){
	var holder = jQuery( _this ).find('.rhc_calendar_widget_day_click_holder');
	if( holder.children().length > 0 ){
		holder.children().fadeOut('fast',function(){
			_calendar_widget_day_click( date,allDay,jsEvent,view, rhc_events_cache_notused, fc_options, _this );
		});
	}else{
		_calendar_widget_day_click( date,allDay,jsEvent,view, rhc_events_cache_notused, fc_options, _this );
	}
	return true;
}

function _calendar_widget_day_click( date,allDay,jsEvent,view, rhc_events_cache_notused, fc_options, _this ){
	//render a list of events below the calendar widget.S
	//rhc_events_cache does not contain external sources.
	client_events = jQuery('#' + fc_options.calendar_id ).find('.fullCalendar').fullCalendar('clientEvents');

	if( client_events.length > 0 ){
		var done_ids = [];
		var filtered_events = [];
		var filter_date = jQuery.fullCalendar.cloneDate( date );
		filter_date.setHours(0,0,0);					
		//--
		jQuery.each( client_events, function(i,ev){
			ev_uid = ev.id + '-' + ev._start.getTime();
			if( -1 != jQuery.inArray(ev_uid, done_ids) ) return;
			var ev_date = jQuery.fullCalendar.cloneDate( ev._start );
			ev_date.setHours(0,0,0);
			if( ev_date.getTime() == filter_date.getTime() ){
				done_ids.push( ev_uid ); 
				filtered_events.push( ev );				
			}	
		});	
		
		filtered_events.sort( _rhc_sort_events );
		var holder = jQuery( _this ).find('.rhc_calendar_widget_day_click_holder');
		var template = jQuery( _this ).find('.rhc_calendar_widget_day_click_template').children(); 		
		holder.empty();
		jQuery.each( filtered_events, function(i,ev){
			ev.fc_click_link = 'page'; //force link to page. tooltip is redundant.
		
			var item = template.clone();
			//title
			item.find('.rhc_title').append(
				jQuery(jQuery('<span></span>').html(ev.title)).RHCLink( ev, view )
			);
			//image
			if(ev.image && ev.image[0]){	
				item.find('.rhc_featured_image').append(
					jQuery( jQuery('<img />').attr('src', ev.image[0]) ).RHCLink( ev, view )
				);				
			}
			//dates
			item.find('.rhc_date').each(function(i,el){
				field = jQuery(el).data('fc_field');
				date_format = jQuery(el).data('fc_date_format');	
				if( value = ev[field] ){
					jQuery(el).html(
						jQuery.fullCalendar.formatDate(value, date_format, fc_options)
					);				
				}
			});
			
			if(ev.allDay){
				item.find('.rhc-event-time').hide();
			}

			//description
			item.find('.rhc_description').html( ev.description );
	
			//taxnomies
			if(ev.terms && ev.terms.length>0){
				jQuery.each(ev.terms,function(i,t){		
					if( item.find('.taxonomy-'+t.taxonomy).parent().find('a').length>0 ){
						item.find('.taxonomy-'+t.taxonomy).parent().append( '<span class="rhc-event-list tax-term-divider"></span>' );
					}
									
					if( t.name && ''!=t.name && item.find('.taxonomy-'+t.taxonomy).length>0 ){
						if( t.url=='' ){
							jQuery('<span>'+ t.name +'</span>')
								.appendTo( item.find('.taxonomy-'+t.taxonomy).show().parent().removeClass('rhc_event-empty-taxonomy') )
							;	
						}else{
							jQuery('<a>'+ t.name +'</a>')
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
						jQuery('<a>'+ t.gaddress +'</a>')
							.attr('href', _url)
							.attr('target','_blank')
							.appendTo( item.find('.taxonomy-'+t.taxonomy+'-gaddress' ).show().parent().removeClass('rhc_event-empty-taxonomy').end() )
						;	
					}
				});
			}			
			
			//-- apply event color
			var color = ev.color || ev.source.color || '';
			var textColor = ev.textColor || ev.source.textColor || '';
			textColor = textColor.length<=1?'#ffffff':textColor;
			if( color.length>1 && textColor.length>1 ){
				item.find('.rhc-widget-event-list-date')
					.css('background-color', color)
					.css('color', textColor)
				;
			}
		
			if( fc_options.widget_autoclick && 1==parseInt(fc_options.widget_autoclick) ){
				item.find('.rhc-widget-event-list-head').parents('.rhc-widget-event-list')
					.addClass('open')
					.find('.rhc-widget-event-list-body').show()
				;
			}else{
				//--head click open body
				item.find('.rhc-widget-event-list-head')
					.unbind('click')
					.bind( 'click',  function(e){
						var holder = jQuery(this).parents('.rhc-widget-event-list')
						holder.toggleClass('open');
						if( holder.is('.open') ){
							holder.find('.rhc-widget-event-list-body').slideDown('fast');						
						}else{
							holder.find('.rhc-widget-event-list-body').slideUp('fast');					
						}
					})
				;				
			}


			if( fc_options.widget_autohover && 1==parseInt(fc_options.widget_autohover) ){
				item.find('.rhc-widget-event-list-head')
					.addClass('hover')
				;
			}else{
				//-- head hover animation
				item.find('.rhc-widget-event-list-head')
					.mouseenter( function(){
						jQuery(this).addClass('hover');
					})
					.mouseleave( function(){
						jQuery(this).removeClass('hover');
					})
				;					
			}		

			
			//-- ics download link
			var local_id = ev.local_id || 0;
			if( local_id > 0 ){
				var url = fc_options.events_source + fc_options.events_source_query;
				url = url.replace('get_calendar_events','get_icalendar_events');
				var url2 = url + '&ics=1';						
				url2 = url2 + '&ID=' + local_id;
				item.find('.rhc-icon-ical').click(function(e){
					window.open( url2, '_self');
				});
			}

			//-- google map
			if(ev.terms && ev.terms.length>0){
				jQuery.each(ev.terms,function(i,t){	
					var glon= t.glon || false;
					var glat= t.glat || false;
					var gaddress = t.gaddress || false;				
					var url = '';
					
					var map_holder = item.find('.rhc-map-view');
					var size = map_holder.data('size');
					var zoom = map_holder.data('zoom');
					var maptype= map_holder.data('maptype');
	
					var color = ev.color || ev.source.color || '';				
					if( color.length > 1 ){
						color = color.toUpperCase(color).replace('#','0x');
					}else{
						color = 'blue';
					}
	
					if( false!==glon && false!==glat ){
						url = 	'http://maps.googleapis.com/maps/api/staticmap?center=' + glat + ',' + glon +
								'&zoom=' + zoom + '&size=' + size + '&maptype=' + maptype +
								'&markers=color:' + color + '%7C' + glat + ',' + glon +
								''
						;
					}else if( false!==gaddress && ''!=gaddress ){
						url = 	'http://maps.googleapis.com/maps/api/staticmap?center=' + escape(gaddress) +
								'&zoom=' + zoom + '&size=' + size + '&maptype=' + maptype +
								'&markers=color:' + color + '%7C' + escape(gaddress) +
								''
						;					
					}

					if( ''!=url && 'none' != fc_options.widget_google_map ){
						item.find('.rhc-icon-map').unbind('click').bind('click',function(e){			
							//init interactive map
							var gmap = item.find('.rhc-map-view .sws-gmap3-cont');
							if( gmap.data('gmap_inited') ){
								
							}else{
								
								if( item.find('.rhc-map-view .sws-gmap3-cont').length > 0 ){
									gmap.data('gmap_inited', true);
												
									ratio = item.find('.rhc-map-view').data('ratio');
									arr = ratio.split(':');
									ratio = arr[1] / arr[0]; 
									
									w = item.find('.rhc-map-view').width();
									h = w * ratio;
									
									gmap.height(h);
							
									var maptype= gmap.data('maptype');
									var uid = gmap.data('uid');
									var gaddress = gmap.data('address');
									rhc_gmap3_init({
										glat: gmap.data('glat'),
										glon: gmap.data('glon'),
										zoom: gmap.data('zoom'),
										disableDefaultUI:false,
										map_type:google.maps.MapTypeId[ maptype ],
										uid: uid,
										name:"",
										info_windows:"sws-gmap3-info-" + uid,
										markers:"#sws-gmap3-marker-" + uid,
										address:gaddress,
										scrollwheel:1,
										traffic:false
									});										
									
									return; //map is shown. not returning here makes the map hide
									
								}								
															
							} 
							//show map
							jQuery(this).parents('.rhc-widget-event-list').find('.rhc-map-view').slideToggle( 'fast' );
						}).show();	
	
						if( 'static' == fc_options.widget_google_map ){
							if( ''!=url ){
								item.find('.rhc-map-view').empty().hide().append(
									jQuery('<img />').attr('src', url )
								);
							}					
						}else if( 'interactive' == fc_options.widget_google_map ){
							var map_tpl = '<div class="sws-gmap3-frame"><div id="map_canvas{uid}" class="sws-gmap3-cont"></div></div><div id="sws-gmap3-marker-{uid}" class="sws-gmap3-marker">|||::</div><div class="sws-gmap3-marker"><div id="sws-gmap3-info-{uid}" >{info_windows}</div></div>';
							var uid = ev.id + '-' + ev.start.getTime();
							map_tpl = map_tpl.replace(/\{uid\}/g, uid);
							map_tpl = map_tpl.replace(/\{info_windows\}/g, t.name );
	
							item.find('.rhc-map-view')
								.empty()
								.append( map_tpl )
							;
							
							item.find('.rhc-map-view .sws-gmap3-cont')
								.data('glat', glat)
								.data('glon', glon)
								.data('zoom', zoom)
								.data('maptype', maptype)
								.data('uid', uid)
								.data('address', gaddress)						
							;
						}											
					}
					//			
				});
			}	
		
			//--setup sharing buttons from social panels
			if( 'undefined' != typeof rhp_vars ){			
				if( item.find('.rhc-icon-facebook').length > 0 ){
					item.find('.rhc-icon-facebook').show().unbind('click').bind('click',function(e){
						e.preventDefault();
						
						FB.init({appId: rhp_vars.fb_appID, status: true, cookie: true});
						
						// calling the API ...
						var obj = {
						  method: 'share',
						  href: ev.url,
						  link: ev.url,
						  name: ev.title,
						  caption: ev.title,
						  description: ev.description
						};
						
						function callback(response) {
						  //console.log(response);
						}
						
						FB.ui(obj, callback);
					});
				}
				
				if( item.find('.rhc-icon-twitter').length > 0 ){
					item.find('.rhc-icon-twitter').show().unbind('click').bind('click',function(e){
						var articleUrl = encodeURIComponent( ev.url );
						var articleSummary = encodeURIComponent( ev.description );
						var goto = 'https://twitter.com/share?' +
						    '&url=' + ev.url +
						    '&text=' + ev.title + 
						    '&counturl=' + ev.url;
						window.open(goto, 'Twitter', "width=660,height=400,scrollbars=no;resizable=no");
					});
				}
				
				if( item.find('.rhc-icon-linkedin').length > 0 ){
					item.find('.rhc-icon-linkedin').show().unbind('click').bind('click',function(e){
						var articleUrl = encodeURIComponent( ev.url );
						var articleTitle = encodeURIComponent( ev.title );
						var articleSummary = encodeURIComponent( ev.description );
						var articleSource = encodeURIComponent( ev.url );
						var goto = 'http://www.linkedin.com/shareArticle?mini=true'+
							 '&url='+articleUrl+
							 '&title='+articleTitle+
							 '&summary='+articleSummary+ articleUrl +
							 '&source='+articleSource;

						window.open(goto, 'LinkedIn', "width=660,height=400,scrollbars=no;resizable=no");
					});
				}	
				
				if( item.find('.rhc-icon-googleplus').length > 0 ){
					item.find('.rhc-icon-googleplus').show().unbind('click').bind('click',function(e){
					    var articleUrl = encodeURIComponent( ev.url );
					    var goto = 'https://plus.google.com/share?url=' + articleUrl;
			
						window.open(goto, 'Google+', "width=660,height=400,scrollbars=no;resizable=no");
					});
				}
				
			}
						
			item.hide();
			holder.append( item.fadeIn( 'fast' ) );
		});
		
		jQuery('BODY').trigger('dbox.loaded');	
	}
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

function btn_tax_dropdown(calendar,header){
	//this function is needed for tax filter not to generate a js error. however the click action is defined somewher else.
}

function dayclick_tooltip_evenlits( date,allDay,jsEvent,view,fc_options,_this ){
	console.log( 'day click', date, _this );
}

function rhc_console(){
    if(console){
        console.log.apply(console, arguments);
    }
}