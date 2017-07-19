<?php

// Bootstrap file for getting the ABSPATH constant to wp-load.php
require_once('config.php');

// check for rights
if (!is_user_logged_in() || !current_user_can('edit_posts')) 
	wp_die(__('You are not allowed to be here', 'gp_lang'));
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $themename .__(' Shortcodes', 'gp_lang'); ?></title>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_option('blog_charset'); ?>" />
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_template_directory_uri() ?>/lib/admin/inc/tinymce/tinymce.js"></script>
	<base target="_self" />
</head>
<body id="link" onload="tinyMCEPopup.executeOnLoad('init();');document.body.style.display='';document.getElementById('style_shortcode').focus();" style="display: none">

	<form name="gp_style" action="#">
	<div class="tabs">
		<ul>
			<li id="style_tab" class="current"><span><a href="javascript:mcTabs.displayTab('style_tab','style_panel');" onmousedown="return false;"><?php _e('Shortcodes', 'gp_lang'); ?></a></span></li>
		</ul>
	</div>
	
	<div class="panel_wrapper" style="height:142px;">

		<div id="style_panel" class="style_panel">
		<br />
		<fieldset>
			<legend><?php _e('Insert a shortcode from the drop down menu.', 'gp_lang'); ?></legend>
		<table border="0" cellpadding="4" cellspacing="0">
         <tr>
            <td><select id="style_shortcode" name="style_shortcode" style="width: 200px">
                <option value="0"><?php _e('Select A Shortcode', 'gp_lang'); ?></option>
				<?php if(is_array($shortcode_tags)) {
				
					foreach ($shortcode_tags as $gp_sc_key => $gp_sc_value) {
					
						if(preg_match('/gp/', $gp_sc_value)) {
						
							// Shortcode Name
							$gp_sc_name = str_replace('gp_', '', $gp_sc_value);
							$gp_sc_name = str_replace('_', ' ', $gp_sc_name);
							$gp_sc_name = ucwords($gp_sc_name);
							
							// Column Shortcodes
							$gp_sc_cols = str_replace('_', ' ', $gp_sc_key);
							$gp_sc_cols = ucwords($gp_sc_cols);
							if(preg_match('/columns/', $gp_sc_value)) {
								$gp_sc_cols = $gp_sc_cols.' ';
								if(preg_match('/one/', $gp_sc_key) OR preg_match('/twothirds/', $gp_sc_key) OR preg_match('/threefourths/', $gp_sc_key)) {
									$gp_sc_name = str_replace('gp_columns', 'Column', $gp_sc_value);
								}
							} else {
								$gp_sc_cols = "";
							}
							
							// Accordion Panel Shortcode
							if(preg_match('/panel/', $gp_sc_key)) {
								$gp_sc_name = "Accordion Panel";
							}
							
							// List Item
							if(preg_match('/\b(li)\b/', $gp_sc_key)) {
								$gp_sc_name = "List Item";
							}
							
							if(preg_match('/_last/', $gp_sc_key) OR preg_match('/_middle/', $gp_sc_key)) {} else {
							
								echo '<option value="'.$gp_sc_key.'" >'.$gp_sc_cols.$gp_sc_name.'</option>' . "\n";
							
							}
						}
					}
				} ?>
            </select></td>
          </tr>
        </table>
		</fieldset>
		</div>

	</div>

	<div class="mceActionPanel">
		<div style="float: left;">
			<input type="button" id="cancel" name="cancel" value="<?php _e('Cancel', 'gp_lang'); ?>" onclick="tinyMCEPopup.close();" />
		</div>

		<div style="float: right;">
			<input type="submit" id="insert" name="insert" value="<?php _e('Insert', 'gp_lang'); ?>" onclick="insertgpLink();" />
		</div>
	</div>
</form>
</body>
</html>
