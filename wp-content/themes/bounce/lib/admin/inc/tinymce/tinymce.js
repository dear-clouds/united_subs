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

function insertgpLink() {
	
	var tagtext;

	var style = document.getElementById('style_panel');
	
		var styleid = document.getElementById('style_shortcode').value;
		
		if (styleid != 0) {
			tagtext = '['+ styleid + ']Insert your text here[/' + styleid + ']';
		}

		// Accordion Panels
		if (styleid != 0 && styleid == 'accordion') {
			tagtext = '['+ styleid + ']<br/>[panel title="Panel Title 1"]Insert your text here[/panel]<br/>[panel title="Panel Title 2"]Insert your text here[/panel]<br/>[panel title="Panel Title 3"]Insert your text here[/panel]<br/>[/' + styleid + ']';	
		}	
		if (styleid != 0 && styleid == 'panel') {
			tagtext = '['+ styleid + ']Insert your text here[/' + styleid + ']';	
		}

		// Activity Streams
		if (styleid != 0 && styleid == 'activity') {
			tagtext = '['+ styleid + ' per_page="5" comments="threaded" order="desc" pagination="true"]';	
		}
				
		// Author Info
		if (styleid != 0 && styleid == 'author') {
			tagtext = '['+ styleid + ']';	
		}
		
		// Blockquotes
		if (styleid != 0 && styleid == 'bq_left') {
			tagtext = '['+ styleid + ']Insert your text here[/' + styleid + ']';	
		}		
		if (styleid != 0 && styleid == 'bq_right') {
			tagtext = '['+ styleid + ']Insert your text here[/' + styleid + ']';	
		}
		
		// Buttons
		if (styleid != 0 && styleid == 'button') {
			tagtext = '['+ styleid + ' link="" color="yellow" size="medium" target=""]Read More[/' + styleid + ']';	
		}

		// Contact Form
		if (styleid != 0 && styleid == 'contact') {
			tagtext = '['+ styleid + ' email=""]';	
		}
		
		// Dividers
		if (styleid != 0 && styleid == 'divider') {
			tagtext = '['+ styleid + ']';
		}
		if (styleid != 0 && styleid == 'top_divider') {
			tagtext = '['+ styleid + ']';
		}
		if (styleid != 0 && styleid == 'small_divider') {
			tagtext = '['+ styleid + ']';
		}		
		if (styleid != 0 && styleid == 'clear') {
			tagtext = '['+ styleid + ']';
		}	
		if (styleid != 0 && styleid == 'small_clear') {
			tagtext = '['+ styleid + ']';
		}	
		
		// Dropcaps
		if (styleid != 0 && styleid == 'dropcap_1') {
			tagtext = '['+ styleid + ' color=""] [/' + styleid + ']';	
		}	
		if (styleid != 0 && styleid == 'dropcap_2') {
			tagtext = '['+ styleid + ' color=""] [/' + styleid + ']';	
		}	
		if (styleid != 0 && styleid == 'dropcap_3') {
			tagtext = '['+ styleid + ' color=""] [/' + styleid + ']';	
		}	
		if (styleid != 0 && styleid == 'dropcap_4') {
			tagtext = '['+ styleid + ' color=""] [/' + styleid + ']';	
		}	
		if (styleid != 0 && styleid == 'dropcap_5') {
			tagtext = '['+ styleid + ' color=""] [/' + styleid + ']';	
		}
		
		// Images
		if (styleid != 0 && styleid == 'image') {
			tagtext = '['+ styleid + ' url="" width="" height="" link="" target="" border="false" align="alignleft" margins="" alt="" title="" lightbox="none" preload="false" class=""]';	
		}
		
		// Lists
		if (styleid != 0 && styleid == 'list') {
			tagtext = '['+ styleid + ' type="arrow"]<br/>[li]List 1[/li]<br/>[li]List 2[/li]<br/>[li]List 3[/li]<br/>[/' + styleid + ']';
		}

		// Login Form
		if (styleid != 0 && styleid == 'login') {
			tagtext = '['+ styleid + ' username="" password="" redirect=""]';	
		}
				
		// Notifications
		if (styleid != 0 && styleid == 'notification') {
			tagtext = '['+ styleid + ' type="default"]Insert your text here[/' + styleid + ']';	
		}
		
		// Posts
		if (styleid != 0 && styleid == 'posts') {
			tagtext = '['+ styleid + ' cats="" images="true" image_width="560" image_height="250" image_wrap="false" hard_crop="false" cols="1" per_page="10" link="both" orderby="date" order="desc" offset="" content_display="excerpt" excerpt_length="400" title="true" title_size="" title_font="" meta="true" read_more="true" pagination="true" preload="false"]';	
		}

		// Price Boxes
		if (styleid != 0 && styleid == 'price_box') {
			tagtext = '['+ styleid + ' title="" width="340" price="" unit="" button_text="" button_url="" align="aligncenter"]Insert your text here[/' + styleid + ']';	
		}

		// Pricing Tables
		if (styleid != 0 && styleid == 'pricing_table') {
			tagtext = '';
			tagtext = tagtext +  '['+ styleid + ']<table>';
			tagtext = tagtext +  '<thead>';
			tagtext = tagtext + '<tr>';
			tagtext = tagtext + '<th></th>';
			tagtext = tagtext + '<th class="first">Beginner<br/><span class="price">$10 per month</span></th>';
			tagtext = tagtext + '<th>Advanced<br/><span class="price">$25 per month</span></th>';
			tagtext = tagtext + '<th class="last">Premium<br/><span class="price">$40 per month</span></th>';
			tagtext = tagtext + '</tr>';
			tagtext = tagtext + '</thead>';
			tagtext = tagtext + '<tbody>';
			tagtext = tagtext + '<tr>';
			tagtext = tagtext + '<td>Disk Space</td>';
			tagtext = tagtext + '<td>500MB</td>';
			tagtext = tagtext + '<td>1000MB</td>';
			tagtext = tagtext + '<td>Unlimited</td>';
			tagtext = tagtext + '</tr>';
			tagtext = tagtext + '<tr>';
			tagtext = tagtext + '<td>Bandwidth</td>';
			tagtext = tagtext + '<td>1GB</td>';
			tagtext = tagtext + '<td>5GB</td>';
			tagtext = tagtext + '<td>500GB</td>';
			tagtext = tagtext + '</tr>';
			tagtext = tagtext + '<tr>';
			tagtext = tagtext + '<td>RAM</td>';
			tagtext = tagtext + '<td>200MB</td>';
			tagtext = tagtext + '<td>1000MB</td>';
			tagtext = tagtext + '<td>Unlimited</td>';
			tagtext = tagtext + '</tr>';
			tagtext = tagtext + '<tr>';
			tagtext = tagtext + '<td>Support</td>';
			tagtext = tagtext + '<td><span class="no"> </span></td>';
			tagtext = tagtext + '<td><span class="yes"> </span></td>';
			tagtext = tagtext + '<td><span class="yes"> </span></td>';
			tagtext = tagtext + '</tr>';
			tagtext = tagtext + '</tbody>';
			tagtext = tagtext + '<tfoot>';
			tagtext = tagtext + '<tr>';
			tagtext = tagtext + '<th></th>';
			tagtext = tagtext + '<th>[button size="medium"]Choose This Plan[/button]</th>';
			tagtext = tagtext + '<th>[button size="medium"]Choose This Plan[/button]</th>';
			tagtext = tagtext + '<th>[button size="medium"]Choose This Plan[/button]</th>';
			tagtext = tagtext + '</tr>';
			tagtext = tagtext + '</tfoot>';
			tagtext = tagtext + '</table>[/' + styleid + ']';
			document.write (tagtext);
		}

		// Register Form
		if (styleid != 0 && styleid == 'register') {
			tagtext = '['+ styleid + ' username="" email="" redirect=""]';	
		}

		// Related Posts
		if (styleid != 0 && styleid == 'related_posts') {
			tagtext = '['+ styleid + ' id="" cats="" images="true" image_width="165" image_height="146" image_wrap="false" hard_crop="false" cols="3" per_page="3" link="both" orderby="rand" order="desc" offset="" content_display="excerpt" excerpt_length="0" title="true" title_size="" title_font="" meta="false" read_more="false" pagination="false" preload="false"]';	
		}
		
		// Sidebar
		if (styleid != 0 && styleid == 'sidebar') {
			tagtext = '['+ styleid + ' name="default" width="" align="alignnone"]';	
		}

		// Slider
		if (styleid != 0 && styleid == 'slider') {
			tagtext = '['+ styleid + ' content="slide" cats="" ids="" width="900" height="400" hard_crop="false" slides="-1" timeout="6" orderby="menu_order" order="asc" arrows="true" buttons="true" shadow="true" content_display="excerpt" excerpt_length="500" title="true" title_length="40" margins="" align="alignleft" preload="false"]';	
		}
		
		// Tabs
		if (styleid != 0 && styleid == 'tabs') {
			tagtext = '['+ styleid + ']<br/>[tab title="Tab Title 1"]Insert your text here[/tab]<br/>[tab title="Tab Title 2"]Insert your text here[/tab]<br/>[tab title="Tab Title 3"]Insert your text here[/tab]<br/>[/' + styleid + ']';
			document.write (tagtext);
		}
		
		// Text
		if (styleid != 0 && styleid == 'text') {
			tagtext = '['+ styleid + ' size="" width="" height="" line_height="" color="" font="" margins="" text_align="" align="alignnone" other="" name="" company=""]Insert your text here[/' + styleid + ']';	
		}
		
		// Toggle
		if (styleid != 0 && styleid == 'toggle') {
			tagtext = '['+ styleid + ' title=""]Insert your text here[/' + styleid + ']';	
		}
		
		// Video
		/*if (styleid != 0 && styleid == 'video') {
			tagtext = '['+ styleid + ' url="" html5_1="" html5_2="" priority="flash" image="" width="560" height="315" align="alignnone" controlbar="bottom" autostart="false" stretching="fill" icons="true"]';	
		}*/
		
		// Columns
		if (styleid != 0 && styleid == 'two') {
			tagtext = '['+ styleid + ']Insert your text here[/' + styleid + '] ['+ styleid + '_last]Insert your text here[/' + styleid + '_last]';	
		}
		if (styleid != 0 && styleid == 'three') {
			tagtext = '['+ styleid + ']Insert your text here[/' + styleid + '] ['+ styleid + ']Insert your text here[/' + styleid + '] ['+ styleid + '_last]Insert your text here[/' + styleid + '_last]';	
		}	
		if (styleid != 0 && styleid == 'four') {
			tagtext = '['+ styleid + ']Insert your text here[/' + styleid + '] ['+ styleid + '_middle]Insert your text here[/' + styleid + '_middle] ['+ styleid + '_middle]Insert your text here[/' + styleid + '_middle] ['+ styleid + '_last]Insert your text here[/' + styleid + '_last]';	
		}
		if (styleid != 0 && styleid == 'five') {
			tagtext = '['+ styleid + ']Insert your text here[/' + styleid + '] ['+ styleid + '_middle]Insert your text here[/' + styleid + '_middle] ['+ styleid + '_middle]Insert your text here[/' + styleid + '_middle] ['+ styleid + '_middle]Insert your text here[/' + styleid + '_middle] ['+ styleid + '_last]Insert your text here[/' + styleid + '_last]';	
		}		
		if (styleid != 0 && styleid == 'onethird') {
			tagtext = '['+ styleid + ']Insert your text here[/' + styleid + '] [twothirds_last]Insert your text here[/twothirds_last]';	
		}	
		if (styleid != 0 && styleid == 'twothirds') {
			tagtext = '['+ styleid + ']Insert your text here[/' + styleid + '] [onethird_last]Insert your text here[/onethird_last]';	
		}
		if (styleid != 0 && styleid == 'onefourth') {
			tagtext = '['+ styleid + ']Insert your text here[/' + styleid + '] [threefourths_last]Insert your text here[/threefourths_last]';	
		}
		if (styleid != 0 && styleid == 'threefourths') {
			tagtext = '['+ styleid + ']Insert your text here[/' + styleid + '] [onefourth_last]Insert your text here[/onefourth_last]';	
		}	
		
		if ( styleid == 0) {
			tinyMCEPopup.close();
		}
	
		if(window.tinyMCE) {
			if (typeof window.tinyMCE.execInstanceCommand != 'undefined') {
				window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, tagtext);
				tinyMCEPopup.editor.execCommand('mceRepaint');
				tinyMCEPopup.close();
			} else {
				parent.tinyMCE.execCommand('mceInsertContent', false, tagtext);
				parent.tinyMCE.activeEditor.windowManager.close();		
			}
		}
		
	return;
}
