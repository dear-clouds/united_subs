jQuery(document).ready(function() {
	
	// You can override the icon names here, in case you prefer your own or have URL issues:
	// E.g. "http://mysite.com/cross.png/images/cross.png" would have "cross.png" replaced twice...
	// Styling should be done in your custom CSS
	var cookie_bar_on_icon = "tick.png";
	var cookie_bar_off_icon = "cross.png";
	
	// jQuery only CSS:
	jQuery('HTML').addClass('JS');
	
	/*
		Work in progress... open same tab position between saves
		If you are a web developer and fancy beating me to this, please get in touch... :)
		
		DONE:
		if 'cliopentab' GET param is set:
			find out value of 'cliopentab'
			call accordion with 'cliopentab' value
		
		TO DO:
		on accordion changing the active div:
			update form action with &cliopentab= <div number>:
				parse form action
				if 'cliopentab' GET param is set:
					update 'cliopentab' value with <div number>
				else:
					add &cliopentab= <div number>
	*/
	function getURLParameter(name) {
		return decodeURI(
			(RegExp(name + '=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]
		);
	}
	switch ( getURLParameter("cliopentab") ) {
		case "0":
			jQuery("#cookielawinfo-accordion").accordion( { autoHeight: false, active: 0 } );
			break;
		case "2":
			jQuery("#cookielawinfo-accordion").accordion( { autoHeight: false, active: 2 } );
			break;
		case "3":
			jQuery("#cookielawinfo-accordion").accordion( { autoHeight: false, active: 3 } );
			break;
		case "1":
		default:
			jQuery("#cookielawinfo-accordion").accordion( { autoHeight: false, active: 1 } );
	}
	
	
	// Cookie bar is on/off message handling:
	var f = jQuery("#header_on_off_alert");
	var t = jQuery("#header_on_off_field_warning");
	var icon = jQuery("#cli-plugin-status-icon");
	
	jQuery('#is_on_field_yes').click(function(){
		// Cookie bar is on
		f.text("Your Cookie Law Info bar is switched on");
		t.text("Your Cookie Law Info bar is switched on");
		t.removeClass('warning');
		swap_icon( cookie_bar_on_icon );
	});
	jQuery('#is_on_field_no').click(function(){
		// Cookie bar is off
		f.text("Your Cookie Law Info bar is switched off");
		t.text("Your Cookie Law Info bar is switched off");
		t.addClass('warning');
		swap_icon( cookie_bar_off_icon );
	});
	function swap_icon(new_icon) {
		old_icon = ( new_icon == cookie_bar_off_icon ) ? cookie_bar_on_icon : cookie_bar_off_icon;
		var original_src = icon.attr('src');
		var new_src = original_src.replace(old_icon, new_icon);
		icon.attr('src', new_src);
	}
	
	
	// Toggle admin display to show/hide action/URL fields
	var rows = jQuery('.cli-plugin-row');
	var combobox = jQuery('#cli-plugin-button-1-action');
	
	toggle_combobox();
	
	combobox.change(function() {
		toggle_combobox();
	});
	
	function toggle_combobox() {
		var selected = jQuery("#cli-plugin-button-1-action option:selected").val();
		if ( selected == "CONSTANT_OPEN_URL" ) {
			rows.show();
		}
		else {
			rows.hide();
		}
	} 
	
});