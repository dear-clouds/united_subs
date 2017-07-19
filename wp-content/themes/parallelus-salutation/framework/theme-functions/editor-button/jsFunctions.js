function init() {
	tinyMCEPopup.resizeToInnerSize();
}

function getCheckedValue(radioObj) {
	if(!radioObj)
		return "";
	var radioLength = radioObj.length;
	if(radioLength == undefined)
		if(radioObj.checked)
			return radioObj.value;
		else
			return "";
	for(var i = 0; i < radioLength; i++) {
		if(radioObj[i].checked) {
			return radioObj[i].value;
		}
	}
	return "";
}

function insertThemeLink() {
	
	var tagtext;
	
	var style = document.getElementById("style_panel");
	var contact = document.getElementById("contact_panel");
	
	// select current shortcode for output
	if (style.className.indexOf("current") != -1) {
		var styleid = document.getElementById("style_shortcode").value;
		if (styleid != 0 ){
			tagtext = '['+ styleid + ']Your content here...[/' + styleid + ']';
		}
		
		if (styleid != 0 && styleid == "styled_image" ){
			tagtext = '['+ styleid + ' image="" w="400" h="300" link="" lightbox="yes" alt="Image Description" rel=""]';	
		}
		
		if (styleid != 0 && styleid == "plain_image" ){
			tagtext = '['+ styleid + ' image="" w="400" h="300" alt="Image Description"]';	
		}
		
		if (styleid != 0 && styleid == "resized_image_path" ){
			tagtext = '['+ styleid + ' image="" w="400" h="300"]';	
		}
		
		if (styleid != 0 && styleid == "button" ){
			tagtext = '['+ styleid + ' style="" title="" class="" id="" name="" value="" onclick=""]Button Text[/' + styleid + ']';
		}
		
		if (styleid != 0 && styleid == "button_link" ){
			tagtext = '['+ styleid + ' url="" target="" style="" title="" class="" id="" onclick=""]Button Text[/' + styleid + ']';
		}
		
		if (styleid != 0 && styleid == "icon" ){
			tagtext = '['+ styleid + ' size="large" icon="star" style="" link="" target="" title=""]';	
		}
		
		if (styleid != 0 && styleid == "icon_list" ){
			tagtext = '['+ styleid + ' size="large" icon="digg, twitter, skype" link="http://digg.com, http://twitter.com, http://skype.com" target="blank" style=""]';
		}
		
		if (styleid != 0 && styleid == "bullet_list" ){
			tagtext = '['+ styleid + ' icon="check" indent="10px" style=""]<ul>\r<li>Your Text</li>\r<li>Your Text</li>\r<li>Your Text</li>\r</ul>[/' + styleid + ']';
		}
		
		if (styleid != 0 && styleid == "tabs" ){
			tagtext = '['+ styleid + ']\r[tab title="First Tab"]Tab content...[/tab]\r[tab title="Second Tab"]Tab content...[/tab]\r[/' + styleid + ']';
		}
		
		if (styleid != 0 && styleid == "toggle" ){
			tagtext = '['+ styleid + ' title="The Question or Title"]The is the answer or content to show...[/' + styleid + ']';	
		}
		
		if (styleid != 0 && styleid == "pricing_table" ){
			tagtext = '['+ styleid + ' columns="3"]\r[pricing_column title="Column 1"]\r<ul>\r<li>[price_info cost="$14.99"]1 month[/price_info]</li>\r<li>Item description and details...</li>\r<li>Some more info...</li>\r<li>[button_link url=""]Button Text[/button_link]</li>\r</ul>[/pricing_column]\r[pricing_column title="Column 2" highlight="true"]\r<ul>\r<li>[price_info cost="$24.99"]3 months[/price_info]</li>\r<li>Item description and details...</li>\r<li>Some more info...</li>\r<li>[button_link url="" style="impactBtn"]Button Text[/button_link]</li>\r</ul>[/pricing_column]\r[pricing_column title="Column 3"]\r<ul>\r<li>[price_info cost="$59.99"]6 months[/price_info]</li>\r<li>Item description and details...</li>\r<li>Some more info...</li>\r<li>[button_link url=""]Button Text[/button_link]</li>\r</ul>[/pricing_column][/' + styleid + ']';
		}
		
		if (styleid != 0 && styleid == "breadcrumbs" ){
			tagtext = '['+ styleid + ' home="Home" blog="Blog" sep="&raquo;" blogpageid="" catinpostpath="1"  prefix=""  archiveprefix="Archives:"  searchprefix="Search for:"  boldlast="1"  nofollowhome="" ]';
		}
		
		if (styleid != 0 && styleid == "page_title" ){
			tagtext = '['+ styleid + ']';	
		}

		if (styleid != 0 && styleid == "quote" ){
			tagtext = '['+ styleid + ' author="Author Name" image="" w="" h="" image_align=""]The quote to be displayed...[/' + styleid + ']';	
		}

		if (styleid != 0 && styleid == "pull_quote" ){
			tagtext = '['+ styleid + ' align="left"]The quote to be displayed...[/' + styleid + ']';	
		}
		
		if (styleid != 0 && styleid == "message_box" ){
			tagtext = '['+ styleid + ' type="note" icon="yes" close="Close"]The text to display in the message box.[/' + styleid + ']';
		}
		
		if (styleid != 0 && styleid == "text_box" ){
			tagtext = '['+ styleid + ' title="A Simple Text Box" icon=""]Your message text.[/' + styleid + ']';	
		}
		
		if (styleid != 0 && styleid == "call_to_action" ){
			tagtext = '['+ styleid + ' title="My Call to Action" tag_line="The tagline of this call to action." button="Click here!" link="" ]';
		}
		
		if (styleid != 0 && styleid == "hr" || styleid == "hr_small" || styleid == "clear" ){
			tagtext = '['+ styleid + ']';	
		}

		if (styleid != 0 && styleid == "sidebar" || styleid == "slideshow" ){
			tagtext = '['+ styleid + ' alias=""]';	
		}
		
		if (styleid != 0 && styleid == "static_content" ){
			tagtext = '['+ styleid + ' id=""]';	
		}

		if (styleid != 0 && styleid == "portfolio" ){
			tagtext = '['+ styleid + ' category="" columns="3" content_width="990" image_ratio="4:3" title="yes" excerpt="yes" excerpt_length="30" posts_per_page="6" paging="true"]';	
		}
		
		if (styleid != 0 && styleid == "blog" ){
			tagtext = '['+ styleid + ' category="" images="true" image_width="150" image_height="150" post_content="excerpt" excerpt_length="50" show_date="true" author_link="true" comments_link="true" show_category_list="false" show_tag_list="false" posts_per_page="10" paging="true"]';	
		}
		
		if (styleid != 0 && styleid == "contact_form" ){
			tagtext = '['+ styleid + ' to="your@email.com" subject="Message from Contact Form" thankyou="Thank\'s your message has been sent." button="Send"]';	
		}
		
		
		// Layout Sets
		if (styleid != 0 && styleid == "one_half_layout"){
			tagtext = "[one_half]Your content here...[/one_half]\r[one_half_last]Your content here...[/one_half_last]\r";	
		}
		
		if (styleid != 0 && styleid == "one_third_layout"){
			tagtext = "[one_third]Your content here...[/one_third]\r[one_third]Your content here...[/one_third]\r[one_third_last]Your content here...[/one_third_last]\r";	
		}
		
		if (styleid != 0 && styleid == "one_fourth_layout"){
			tagtext = "[one_fourth]Your content here...[/one_fourth]\r[one_fourth]Your content here...[/one_fourth]\r[one_fourth]Your content here...[/one_fourth]\r[one_fourth_last]Your content here...[/one_fourth_last]\r";	
		}
		
		if (styleid != 0 && styleid == "one_fifth_layout"){
			tagtext = "[one_fifth]Your content here...[/one_fifth]\r[one_fifth]Your content here...[/one_fifth]\r[one_fifth]Your content here...[/one_fifth]\r[one_fifth]Your content here...[/one_fifth]\r[one_fifth_last]Your content here...[/one_fifth_last]\r";	
		}
		
		if (styleid != 0 && styleid == "one_third_two_third"){
			tagtext = "[one_third]Your content here...[/one_third]\r[two_third_last]Your content here...[/two_third_last]\r";	
		}
		
		if (styleid != 0 && styleid == "two_third_one_third"){
			tagtext = "[two_third]Your content here...[/two_third]\r[one_third_last]Your content here...[/one_third_last]\r";	
		}
		
		if (styleid != 0 && styleid == "one_fourth_three_fourth"){
			tagtext = "[one_fourth]Your content here...[/one_fourth]\r[three_fourth_last]Your content here...[/three_fourth_last]\r";	
		}
		
		if (styleid != 0 && styleid == "three_fourth_one_fourth"){
			tagtext = "[three_fourth]Your content here...[/three_fourth]\r[one_fourth_last]Your content here...[/one_fourth_last]\r";
		}
			
		if (styleid != 0 && styleid == "one_fourth_three_fourth"){
			tagtext = "[one_fourth]Your content here...[/one_fourth]\r[three_fourth_last]Your content here...[/three_fourth_last]\r";	
		}
		
		if (styleid != 0 && styleid == "one_fourth_one_fourth_one_half"){
			tagtext = "[one_fourth]Your content here...[/one_fourth]\r[one_fourth]Your content here...[/one_fourth]\r[one_half_last]Your content here...[/one_half_last]\r";	
		}
		
		if (styleid != 0 && styleid == "one_fourth_one_half_one_fourth"){
			tagtext = "[one_fourth]Your content here...[/one_fourth]\r[one_half]Your content here...[/one_half]\r[one_fourth_last]Your content here...[/one_fourth_last]\r";	
		}
		
		if (styleid != 0 && styleid == "one_half_one_fourth_one_fourth"){
			tagtext = "[one_half]Your content here...[/one_half]\r[one_fourth]Your content here...[/one_fourth]\r[one_fourth_last]Your content here...[/one_fourth_last]\r";	
		}		

		if ( styleid == 0 ){
			tinyMCEPopup.close();
		}
	}

	if (contact.className.indexOf("current") != -1) {
		var to = document.getElementById("contact_email").value;
		var subject = document.getElementById("contact_subject").value;
		var thankYou = document.getElementById("contact_thankyou").value;
		if (to != 0 ) {
			tagtext = '[contact_form to="'+ to +'" subject="'+ subject +'" thankyou="'+ thankYou +'"]';	
		}else {
			tinyMCEPopup.close();
		}
	}
	
	if(window.tinyMCE) {
	    var tmce_ver = window.tinyMCE.majorVersion;

	    if (tmce_ver >= "4")
	        window.tinyMCE.execCommand('mceInsertContent', false, tagtext);
	    else 
	        window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, tagtext);

		tinyMCEPopup.editor.execCommand("mceRepaint");
		tinyMCEPopup.close();
	}
	return;
}
