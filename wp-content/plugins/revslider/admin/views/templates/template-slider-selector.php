<?php
if( !defined( 'ABSPATH') ) exit();

$tmpl = new RevSliderTemplate();

$tp_template_slider = $tmpl->getThemePunchTemplateSliders();
$author_template_slider = $tmpl->getDefaultTemplateSliders();

$tmp_slider = new RevSlider();
$all_slider = $tmp_slider->getArrSliders();

?>
<!-- THE TEMPLATE AREA -->
<div id="template_area">
	<div id="template_header_part">
		<h2><span class="revlogo-mini" style="margin-right:15px;"></span><?php _e('Slider Template Library', 'revslider'); ?></h2>
		
		<div id="close-template"></div>
		
		<div class="revolution-template-switcher">		
			<span style="display:table-cell;vertical-align:top">	
				<?php
				if(!empty($author_template_slider) && is_array($author_template_slider)){
					foreach($author_template_slider as $name => $v){
						?>
						<span data-type="temp_<?php echo sanitize_title($name); ?>" class="template_filter_button"><?php echo esc_attr($name); ?></span>
						<?php
					}
				}
				?>
				<span class="template_filter_button selected" data-type="temp_all"><?php _e('All Templates', 'revslider'); ?></span>
				<span class="template_filter_button" data-type="template_free"><?php _e('Free Templates', 'revslider'); ?></span>
				<span class="template_filter_button" data-type="template_premium"><?php _e('Premium Templates', 'revslider'); ?></span>
				<span class="template_filter_button" data-type="template_package"><?php _e('Packages', 'revslider'); ?></span>
				<span class="template_filter_button" data-type="temp_slider"><?php _e('Slider', 'revslider'); ?></span>
				<span class="template_filter_button" data-type="temp_carousel"><?php _e('Carousel', 'revslider'); ?></span>			
				<span class="template_filter_button" data-type="temp_hero"><?php _e('Hero', 'revslider'); ?></span>
				<span class="template_filter_button" data-type="temp_notinstalled"><?php _e('Not Installed', 'revslider'); ?></span>
				<span class="template_filter_button" data-type="temp_socialmedia"><?php _e('Social Media', 'revslider'); ?></span>
				<span class="template_filter_button" data-type="temp_postbased"><?php _e('Post-Based', 'revslider'); ?></span>
				<span class="template_filter_button temp_new_udpated" data-type="temp_newupdate"><?php _e('New / Updated', 'revslider'); ?></span>			
			</span>
			<span style="display:table-cell;vertical-align:top;text-align:right">
				<span class="rs-reload-shop"><i class="eg-icon-arrows-ccw"></i><?php _e('Update Library', 'revslider'); ?></span>
			</span>			
		</div>
	</div>

	<!-- THE REVOLUTION BASE TEMPLATES -->
	<div class="revolution-template-groups">
		<div id="template_bigoverlay"></div>
		<?php
		$plugin_list = array();
		
		if(!empty($tp_template_slider)){
			foreach($tp_template_slider as $m_slider){
				if($m_slider['cat'] != 'Revolution Base' && $m_slider['cat'] != 'Premium') continue;
				
				if(!empty($m_slider['filter']) && is_array($m_slider['filter'])){
					foreach($m_slider['filter'] as $f => $v){
						$m_slider['filter'][$f] = 'temp_'.$v;
					}
				}
				
				$slidercat = $m_slider['cat'] == 'Revolution Base' ? " template_free " : " template_premium ";				
				$etikett_a = $m_slider['cat'] == 'Revolution Base' ? __("Free", 'revslider') : __("Premium", 'revslider');
				$is_package = (isset($m_slider['package']) && $m_slider['package'] !== '') ? true : false;
				$isnew = (isset($m_slider['new_slider'])) ? true : false;
				$package = ($is_package) ? ' template_package' : '';
				
				$m_slider['package_full_installded'] = $tmpl->check_package_all_installed($m_slider['uid'], $tp_template_slider);
				
				$slidercat_new = $isnew ? " temp_newupdate " : "";
				
				$m_slider['plugin_require'] = (isset($m_slider['plugin_require'])) ? json_decode($m_slider['plugin_require'], true) : array();
				if(is_array($m_slider['plugin_require']) && !empty($m_slider['plugin_require'])){
					foreach($m_slider['plugin_require'] as $k => $pr){
						if(!isset($plugin_list[$pr['path']])){
							if(is_plugin_active(esc_attr($pr['path']))){
								$plugin_list[$pr['path']] = true;
							}else{
								$plugin_list[$pr['path']] = false;
							}
						}
						if($plugin_list[$pr['path']] === true){
							$m_slider['plugin_require'][$k]['installed'] = true;
						}else{
							$m_slider['plugin_require'][$k]['installed'] = false;
						}
					}
				}else{
					$m_slider['plugin_require'] = array();
				}


				if(!isset($m_slider['installed'])){
					$c_slider = new RevSlider();
					$c_slider->initByDBData($m_slider);
					$c_slides = $tmpl->getThemePunchTemplateSlides(array($m_slider));
					$c_title = $c_slider->getTitle();
					$width = $c_slider->getParam("width",1240);
					$height = $c_slider->getParam("height",868);
					$version_installed = $c_slider->getParam("version",'1.0.0');
					if ($version_installed==='') $version_installed='1.0.0';
					$isupdate = false;
					
					
					if(version_compare($version_installed, $m_slider['version'], '<')){
						$isupdate = true;
						$slidercat_new = ' temp_newupdate ';
					}
					
					
					if(!empty($c_slides)){
						?>
						<div class="template_group_wrappers <?php echo $slidercat.$package.$slidercat_new; if(isset($m_slider['filter'])){ echo implode(' ', $m_slider['filter']); } ?>">
							<?php
							foreach($c_slides as $key => $c_slide){
								
								$c_slide = array_merge($m_slider, $c_slide);
								$c_slide['img'] = $m_slider['img']; //set slide image
								
								if(isset($m_slider['preview'])){
									$c_slide['preview'] = $m_slider['preview']; //set preview URL
								}
								if(isset($m_slider['filter'])){
									$c_slide['filter'] = $m_slider['filter']; //add filters 
								}
								
								if($c_slide['img'] == ''){
									//set default image
								}
								
								$c_slide['settings']['width'] = $width;
								$c_slide['settings']['height'] = $height;
								
								$c_slide['number'] = $key;
								$c_slide['current_version'] = ($version_installed !== '') ? $version_installed : __('N/A', 'revslider');
								$c_slide['title'] = $c_title;
							
								$c_slide['package'] = ($is_package) ? $m_slider['package'] : '';
								$c_slide['package_full_installded'] = $m_slider['package_full_installded'];
								
								$tmpl->write_template_markup($c_slide, $c_slider->getID()); //add the Slider ID as we want to add a Slider and no Slide
								break; //only write the first, as we want to add a Slider and not a Slide
							}
							?>
							<div class="template_meta_line">
								<?php if ($isnew) { ?>
								<span class="template_new"><?php _e("New", "revslider"); ?></span>
								<?php } ?>
								<?php if ($isupdate) { ?>
								<span class="template_new"><?php _e("Update", "revslider"); ?></span>
								<?php } ?>
								<span class="<?php echo $slidercat; ?>"><?php echo $etikett_a; ?></span>
								<span class="template_installed"><?php _e("Installed", "revslider"); ?><i class="eg-icon-check"></i></span>
							</div>							
							<div class="template_thumb_title"><?php echo $c_title; ?></div>							
						</div><?php
					}
				}else{
					?>
					<div class="template_group_wrappers <?php echo $slidercat_new.$slidercat.$package; ?> temp_notinstalled not-imported-wrapper <?php if(isset($m_slider['filter'])){ echo implode(' ', $m_slider['filter']); } ?>">
						<?php
						$tmpl->write_import_template_markup($m_slider); //add the Slider ID as we want to add a Slider and no Slide
						?>
						<div class="template_meta_line">
							<?php if ($isnew) { ?>
								<span class="template_new"><?php _e("New", "revslider"); ?></span>
								<?php } ?>
								<?php /*if ($isupdate) { ?>
								<span class="template_new"><?php _e("Update", "revslider"); ?></span>
								<?php }*/ ?>
							<span class="<?php echo $slidercat;?>"><?php echo $etikett_a; ?></span>
							<span class="template_notinstalled"><?php _e("Not Installed", "revslider"); ?></span>
						</div>
						<div class="template_thumb_title"><?php echo $m_slider['title']; ?></div>	
					</div>
					<?php
				}
			}
		}else{
			echo '<span style="color: #F00; font-size: 20px">';
			_e('No data could be retrieved from the servers. Please make sure that your website can connect to the themepunch servers.', 'revslider');
			echo '</span>';
		}
		?>

		<div style="clear:both;width:100%"></div>		
	</div>
	
	
</div>

<script>
	function isElementInViewport(element,sctop,wh,rtgt) {		
			var etp = parseInt(element.offset().top,0)-rtgt,
				etpp = parseInt(element.position().top,0),
				inviewport = false;		
			//element.closest('.template_group_wrappers').find('.template_thumb_title').html("Offset:"+etp+"   Scroll:"+sctop+" POffset:"+rtgt);
			if ((etp>-50) && (etp<wh+50))
				inviewport =  true;						
			return inviewport;
	}
	
	function scrollTA() {
		var ta = jQuery('.revolution-template-groups'),
			st = ta.scrollTop(),
			rtgt = parseInt(jQuery('.revolution-template-groups').offset().top,0),
			wh = jQuery(window).height();

		ta.find('.template_slider_item:visible, .template_slider_item_import:visible, .template_slider_item_img:visible').each(function() {
			var el = jQuery(this);				
			if (el.data('src')!=undefined && el.data('bgadded')!=1) {
				if (jQuery('#template_area').hasClass("show"))
					if (isElementInViewport(el,st,wh,rtgt)){																			
						el.css({backgroundImage:'url("'+el.data('src')+'")'});														
						el.data('bgadded',1);						
					}
			}
		});
	}
	function setTWHeight() {
			var w = jQuery(window).height(),
				wh = jQuery('#template_header_part').height();
			jQuery('.revolution-template-groups').css({height:(w-wh)+"px"});
			jQuery('.revolution-template-groups').perfectScrollbar("update");
			scrollTA();
		};


	jQuery("document").ready(function() {		
		
		

		

		jQuery('#template_area').on('showitnow',scrollTA);


		jQuery('body').on('click','.show_more_template_slider',function() {
			jQuery('.template_group_wrappers').css({zIndex:2});
			var item = jQuery(this).closest('.template_group_wrappers');
			if (item.length>0) {				
				if (jQuery(window).width() - item.offset().left < item.width()*2.1)
					item.addClass("show_more_to_left")
				else 
					item.removeClass("show_more_to_left");

				item.find('.template_thumb_more').fadeIn(100);
				jQuery('#template_bigoverlay').fadeIn(100);
				item.css({zIndex:15});
			}
		});

		jQuery('#template_bigoverlay').on('click',function() {
			jQuery('#template_bigoverlay').fadeOut(100);
			jQuery('.template_thumb_more:visible').fadeOut(100);
		});

		// TEMPLATE ELEMENTS
		jQuery('.template_filter_button').on("click",function() {
			jQuery('#template_bigoverlay').fadeOut(100);
			jQuery('.template_thumb_more:visible').fadeOut(100);
			var btn = jQuery(this),
				sch = btn.data('type');
			jQuery('.template_filter_button').removeClass("selected");
			btn.addClass("selected");
			jQuery('.template_group_wrappers').hide();						
			if (sch=="temp_all") 
				jQuery('.template_group_wrappers').show();
			else 
				jQuery('.'+sch).show();		
			jQuery('.revolution-template-groups').scrollTop(0);		
			scrollTA();	
			
		});

		
		jQuery('.template_slider_item, .template_slider_item_import').each(function() {
			var item = jQuery(this),
				gw = item.data('gridwidth'),
				gh = item.data('gridheight'),
				id = item.data('slideid'),
				w = 180;
				
			if (gw==undefined || gw<=0) gw = w;
			if (gh==undefined || gh<=0) gh = w;
			
			var	h = Math.round((w/gw)*gh);
			//item.css({height:h+"px"});
			
			var factor = w/gw;
			
			var htitle = item.closest('.template_group_wrappers').find('h3');
			if (!htitle.hasClass("modificated")) {
				htitle.html(htitle.html()+" ("+gw+"x"+gh+")").addClass("modificated");
			}			
		});
		
		// CLOSE SLIDE TEMPLATE
		jQuery('#close-template').click(function() {
			jQuery('#template_area').removeClass("show");
		});		

		// TEMPLATE TAB CHANGE 
		jQuery('body').on("click",'.revolution-templatebutton',function() {			
			var btn = jQuery(this);
			jQuery('.revolution-template-groups').each(function() { jQuery(this).hide();});			
			jQuery("."+btn.data("showgroup")).show();
			jQuery('.revolution-templatebutton').removeClass("selected");
			btn.addClass("selected");
			scrollTA();
			jQuery('.revolution-template-groups').perfectScrollbar("update");
		});
		
		setTWHeight();
		jQuery(window).on("resize",setTWHeight);
		jQuery('.revolution-template-groups').perfectScrollbar();

		document.addEventListener('ps-scroll-y', function (e) {
			if (jQuery(e.target).closest('.revolution-template-groups').length>0) {
				scrollTA();
				jQuery('#template_bigoverlay').css({top:jQuery('.revolution-template-groups').scrollTop()});												
			}
	    });
		
		jQuery(".input_import_slider").change(function(){
			if(jQuery(this).val() !== ''){
				jQuery('.rs-import-slider-button').show();
			}else{
				jQuery('.rs-import-slider-button').hide();
			}
		});
	});
	
	<?php
	if(isset($_REQUEST['update_shop'])){
		?>
		var recalls_amount = 0;
		function callTemplateSlider() {			
			recalls_amount++;
			if (recalls_amount>5000) {				
				jQuery('#waitaminute').hide();
			} else {
				if (jQuery('#template_area').length>0) { 																	
					jQuery('#template_area').addClass("show");
					scrollTA();
					setTWHeight();
					jQuery('.revolution-template-groups').perfectScrollbar("update");					
					jQuery('#waitaminute').hide();						
				} else {
					callTemplateSlider();
				}
			}			
		}
		callTemplateSlider();		
		<?php
	}
	?>
</script>


<!-- Import template slider dialog -->
<div id="dialog_import_template_slider" title="<?php _e("Import Template Slider",'revslider'); ?>" class="dialog_import_template_slider" style="display:none">
	<form action="<?php echo RevSliderBase::$url_ajax; ?>" enctype="multipart/form-data" method="post">
		<input type="hidden" name="action" value="revslider_ajax_action">
		<input type="hidden" name="client_action" value="import_slider_template_slidersview">
		<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("revslider_actions"); ?>">
		<input type="hidden" name="uid" class="rs-uid" value="">
		
		<p><?php _e('Please select the corresponding zip file from the download packages import folder called', 'revslider'); ?>:</p> 
		<p class="filetoimport"><b><span class="rs-zip-name"></span></b></p>
		<p class="import-file-wrapper"><input type="file" size="60" name="import_file" class="input_import_slider "></p>
		<span style="margin-top:45px;display:block"><input type="submit" class="rs-import-slider-button button-primary revblue tp-be-button" value="<?php _e("Import Template Slider",'revslider'); ?>"></span>
		<span class="tp-clearfix"></span>
		<span style="font-weight: 700;"><?php _e("Note: style templates will be updated if they exist!",'revslider'); ?></span>
		<table style="display: none;">
			<tr>
				<td><?php _e("Custom Animations:",'revslider'); ?></td>
				<td><input type="radio" name="update_animations" value="true" checked="checked"> <?php _e("overwrite",'revslider'); ?></td>
				<td><input type="radio" name="update_animations" value="false"> <?php _e("append",'revslider'); ?></td>
			</tr>
			<tr>
				<td><?php _e("Static Styles:",'revslider'); ?></td>
				<td><input type="radio" name="update_static_captions" value="true"> <?php _e("overwrite",'revslider'); ?></td>
				<td><input type="radio" name="update_static_captions" value="false"> <?php _e("append",'revslider'); ?></td>
				<td><input type="radio" name="update_static_captions" value="none" checked="checked"> <?php _e("ignore",'revslider'); ?></td>
			</tr>
		</table>
	</form>
</div>


<div id="dialog_import_template_slider_from" title="<?php _e("Import Template Slider",'revslider'); ?>" class="dialog_import_template_slider_from" style="display:none">
	<?php _e('Import Slider from local or from ThemePunch server?', 'revslider'); ?>
	<form action="<?php echo RevSliderBase::$url_ajax; ?>" enctype="multipart/form-data" method="post" name="rs-import-template-from-server" id="rs-import-template-from-server">
		<input type="hidden" name="action" value="revslider_ajax_action">
		<input type="hidden" name="client_action" value="import_slider_online_template_slidersview">
		<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("revslider_actions"); ?>">
		<input type="hidden" name="uid" class="rs-uid" value="">
		<input type="hidden" name="package" class="rs-package" value="false">
	</form>
</div>