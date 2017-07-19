(function($) {

    tinymce.PluginManager.add('pushortcodes', function( ed )
    {

        ed.addButton('pushortcodes', {
            text: 'Shortcodes',
            onclick: function(e) {
                
                $('body').prepend('<div class="mask"></div>');

                //Get the screen height and width
                var maskHeight = $(document).height();
                var maskWidth = $(window).width();

                //Set height and width to mask to fill up the whole screen
                $('.mask').css({'width':maskWidth,'height':maskHeight});

                //transition effect    
                $('.mask').fadeTo("slow",0.8);  
                
                var dialog = $('.shortcodes_dialog').clone().dialog({
                    title: "Shortcodes",
                    dialogClass: "shortcodes-dialog",
                    resizable: false,
                    modal: true,
                    width:'auto',
                    close: function( event, ui ) {
                        $('.mask').detach();
                        dialog.dialog( "destroy" );
                    }
                
                });
                
                function getSelectValues(select) {
					  var result = '';
					  var options = select && select.options;
					  var opt;

					  for (var i=0, iLen=options.length; i<iLen; i++) {
						opt = options[i];

						if (opt.selected) {
							result +=(opt.value || opt.text);
						}
						
						if(i<iLen-1){
							result += ', ';
						}
					  }
					  return result;
					}
						
				    if(ed.selection.getContent({format : 'text'})!='') {
                        dialog.find('#dropdown-ul').val( ed.selection.getContent({format : 'text'}));
                        dialog.find('#tooltip-content').val( ed.selection.getContent({format : 'text'}));
                    }
					
					// Setup the array of shortcode options
					$.shortcode_select = {
						'0' : $([]),
						'shortcode-accordion' : $('div#shortcode-accordion'),
						'shortcode-tabs' : $('div#shortcode-tabs'),
						'shortcode-button' : $('div#shortcode-button'),
						'shortcode-buttons-group' : $('div#shortcode-buttons-group'),
						'shortcode-progress-bar' : $('div#shortcode-progress-bar'),
						'shortcode-dropdown' : $('div#shortcode-dropdown'),
						'shortcode-tooltip' : $('div#shortcode-tooltip')
					};

					// Hide each option section
					$.each($.shortcode_select, function() {
						this.css({ display: 'none' });
					});
                
                    var $insert_btn = dialog.find('#insert-short');
					
					// Show the selected option section
					dialog.find('#shortcode-select').change(function() {
						$.each($.shortcode_select, function() {
							this.css({ display: 'none' });
						});
						$.shortcode_select[$(this).val()].css({
							display: 'block'
						});
                        
                        if($(this).val() === '0' ) {
                            $insert_btn.attr('disabled','disabled');
                            $insert_btn.addClass('inactive');
                        } else {
                            $insert_btn.removeAttr("disabled");
                            $insert_btn.removeClass('inactive');
                        }
					});
                
                    $insert_btn.click( function(){
						
                        
						if($(this).hasClass('inactive')){
							return false;
						}
						
						var shortcodeHTML,
                            shortcode_panel = dialog.find('#shortcode_panel'),
                            shortcode_select = shortcode_panel.find('#shortcode-select').val();


                        /////////////////////////////////////////
                        ////	ACCORDION SHORTCODE OUTPUT
                        /////////////////////////////////////////

                        if (shortcode_select == 'shortcode-accordion') {

                            var accordion_size = shortcode_panel.find('#accordion-size').val();	
                            var accordion_open = shortcode_panel.find('#accordion-open').val();

                            shortcodeHTML = '[accordion';
                            if(accordion_open) {
                                 shortcodeHTML += ' open="'+accordion_open+'"';
                            }
                            shortcodeHTML += ']';
                                for ( var i = 0; i < accordion_size; i++ ) {
                                    shortcodeHTML += '[accordion_element title="TITLE'+i+'"]';
                                        shortcodeHTML += 'CONTENT'+i;
                                    shortcodeHTML += '[/accordion_element]';
                                }
                            shortcodeHTML += '[/accordion]';
                        }

                        /////////////////////////////////////////
                        ////	TABS SHORTCODE OUTPUT
                        /////////////////////////////////////////

                        if (shortcode_select == 'shortcode-tabs') {

                            var tabs_size = shortcode_panel.find('#tabs-size').val();	
                            var tabs_style = shortcode_panel.find('#tabs-style').val();	

                            shortcodeHTML = '[tabs style="'+tabs_style+'"]';
                                for ( var i = 0; i < tabs_size; i++ ) {
                                    shortcodeHTML += '[tab title="TITLE'+i+'"]';
                                        shortcodeHTML += 'CONTENT'+i;
                                    shortcodeHTML += '[/tab]';
                                }
                            shortcodeHTML += '[/tabs]';
                        }
 
                        /////////////////////////////////////////
                        ////	PROGRES BAR SHORTCODE OUTPUT
                        /////////////////////////////////////////

                        if (shortcode_select == 'shortcode-progress-bar') {

                            var progress_bar_size = shortcode_panel.find('#progress-bar-size').val();	
                            var progress_bar_style = shortcode_panel.find('#progress-bar-style').val();	
                            var progress_bar_title = shortcode_panel.find('#progress-bar-title').val();	
                            var progress_bar_percent = shortcode_panel.find('#progress-bar-percent').val();	
                            var progress_bar_color = shortcode_panel.find('#progress-bar-color').val();	

                            shortcodeHTML = '[progress_bar size="'+progress_bar_size+'" style="'+progress_bar_style+'" title="'+progress_bar_title+'" percent="'+progress_bar_percent+'" color="'+progress_bar_color+'"]';
                        }	

                        /////////////////////////////////////////
                        ////	BUTTON SHORTCODE OUTPUT
                        /////////////////////////////////////////

                        if (shortcode_select == 'shortcode-button') {
                            var button_size = shortcode_panel.find('#button-size').val();	
                            var button_url = shortcode_panel.find('#button-url').val();	
                            var button_target = shortcode_panel.find('#button-target').val();	
                            var button_text = shortcode_panel.find('#button-text').val();	
                            var button_icon = shortcode_panel.find('#button-icon').val();	
                            var button_type = shortcode_panel.find('#button-type').val();	
                            var button_bottom_margin = shortcode_panel.find('#button-bottom-margin').val();	
//                                [button size="long" url="#" open_new_tab="false" text="Button Text" icon="fa-arrows" type="inverse" bottom_margin="15"]
                            shortcodeHTML = '[button size="'+button_size+'" url="'+button_url+'" open_new_tab="'+button_target+'" text="'+button_text+'" icon="'+button_icon+'" type="'+button_type+'" bottom_margin="'+button_bottom_margin+'"]';
                        }

                        /////////////////////////////////////////
                        ////	BUTTONS GROUP SHORTCODE OUTPUT
                        /////////////////////////////////////////

                        if (shortcode_select == 'shortcode-buttons-group') {
                            var buttons_group_size = shortcode_panel.find('#buttons-group-size').val();	
                            var buttons_group_type = shortcode_panel.find('#buttons-group-type').val();	
                            var buttons_group_margin = shortcode_panel.find('#buttons-group-margin').val();	
                            shortcodeHTML = '[button_group type="'+buttons_group_type+'" bottom_margin="'+buttons_group_margin+'"]<br>'
                                for ( var i = 0; i < buttons_group_size; i++ ) {
                                    shortcodeHTML += '[button url="#" open_new_tab="false" text="Day"]<br>';
                                }
                            shortcodeHTML += '[/button_group]<br>';
                        }

                        /////////////////////////////////////////
                        ////	DROPDOWN SHORTCODE OUTPUT
                        /////////////////////////////////////////

                        if (shortcode_select == 'shortcode-dropdown') {

                            var dropdown_style = shortcode_panel.find('#dropdown-style').val();	
                            var dropdown_ul = shortcode_panel.find('#dropdown-ul').val();

                            shortcodeHTML = '[dropdown style="'+dropdown_style+'"]'+dropdown_ul+'[/dropdown]';
                        }

                        /////////////////////////////////////////
                        ////	TOOLTIP SHORTCODE OUTPUT
                        /////////////////////////////////////////

                        if (shortcode_select == 'shortcode-tooltip') {

                            var tooltip_content = shortcode_panel.find('#tooltip-content').val();

                            shortcodeHTML = '[tooltip]'+tooltip_content+'[/tooltip]';
                        }
                
				        var sc = shortcodeHTML;
						//alert(sc);
						
						ed.selection.setContent(sc);
						var sc = '';
                        
						// Close the modal and remove it from DOM
                        $('.mask').detach();
                        dialog.dialog( "destroy" );		
						
						return false;
					});

            }
        });

    
    });
})(jQuery);