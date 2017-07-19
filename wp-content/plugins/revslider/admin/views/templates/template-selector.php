<?php
if( !defined( 'ABSPATH') ) exit();

$tmpl = new RevSliderTemplate();

$templates = $tmpl->getTemplateSlides();
$tp_templates = $tmpl->getThemePunchTemplateSlides();
$tp_template_slider = $tmpl->getThemePunchTemplateSliders();

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
				<span class="template_filter_button selected" data-type="temp_all"><?php _e('All Slides', 'revslider'); ?></span>
				<span class="template_filter_button" data-type="temp_slider"><?php _e('Slider', 'revslider'); ?></span>
				<span class="template_filter_button" data-type="temp_carousel"><?php _e('Carousel', 'revslider'); ?></span>			
				<span class="template_filter_button" data-type="temp_hero"><?php _e('Hero', 'revslider'); ?></span>
				<span class="template_filter_button" data-type="template_free"><?php _e('Revolution Defaults', 'revslider'); ?></span>
				<span class="template_filter_button" data-type="template_premium"><?php _e('Premium Slider', 'revslider'); ?></span>	
				<span class="template_filter_button template_local_filter" data-type="temp_existing"><?php _e('Local Slides', 'revslider'); ?></span>			
				<span class="template_filter_button template_local_filter" data-type="temp_custom"><?php _e('User Templates', 'revslider'); ?></span>			
			</span>
			<span style="display:table-cell;vertical-align:top;text-align:right">
				<span class="rs-reload-shop"><i class="eg-icon-arrows-ccw"></i><?php _e('Update Library', 'revslider'); ?></span>
			</span>
			
		</div>
		<div class="revolution-template-subtitle"><?php _e('Add Single Slide', 'revslider'); ?></div>
	</div>
	
	<!-- THE REVOLUTION BASE TEMPLATES -->
	<div class="revolution-basic-templates revolution-template-groups" style="padding-top:20px">
		<div id="template_bigoverlay"></div>
		<?php
		/*if(!empty($tp_templates)){
			foreach($tp_templates as $template){
				$tmpl->write_template_markup($template);
			}
		}*/
		
		if(!empty($tp_template_slider)){
			foreach($tp_template_slider as $m_slider){
				
				if($m_slider['cat'] != 'Revolution Base' && $m_slider['cat'] != 'Premium') continue;
				
				if(!empty($m_slider['filter']) && is_array($m_slider['filter'])){
					foreach($m_slider['filter'] as $f => $v){
						$m_slider['filter'][$f] = 'temp_'.$v;
					}
				}

				$slidercat = $m_slider['cat'] == 'Revolution Base' ? " template_free " : " template_premium ";				
				$etikett_a = $m_slider['cat'] == 'Revolution Base' ? "Free" : "Premium";
				$isnew = (isset($m_slider['new_slider'])) ? true : false;
				
				$slidercat_new = $isnew ? " temp_newupdate " : "";
				
				if(!isset($m_slider['installed']) && !isset($m_slider['is_new'])){
					
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
					
					if(!empty($c_slides)){
						?>
						<div style="margin-bottom:30px" class="template_group_wrappers  <?php echo $slidercat.$slidercat_new; if(isset($m_slider['filter'])){ echo implode(' ', $m_slider['filter']); } ?>">							
							<?php
							echo '<div class="template_slider_title">';
							if(isset($m_slider['preview']) && $m_slider['preview'] !== ''){
								echo '<a class="template_slide_preview" href="'.esc_attr($m_slider['preview']).'" target="_blank"><i class="eg-icon-search"></i></a>';
							}
							
							echo $c_title.'</div>';
							?>
							<div class="temp_slides_in_slider_wrapper">
							<?php
							foreach($c_slides as $key => $c_slide){
								?>
								<div class="temp_slide_single_wrapper">
									<?php
									if(isset($m_slider['filter'])){
										$c_slide['filter'] = $m_slider['filter']; //add filters 
									}

									$title = str_replace("'", "", RevSliderBase::getVar($c_slide['params'], 'title', 'Slide'));
									
									$c_slide['settings']['width'] = $width;
									$c_slide['settings']['height'] = $height;
									
									$c_slide['uid'] = $m_slider['uid'];
									$c_slide['number'] = $key;
									$c_slide['zip'] = $m_slider['zip'];
									$c_slide['current_version'] = ($version_installed !== '') ? $version_installed : __('N/A', 'revslider');
									$c_slide['version'] = $m_slider['version'];
									$c_slide['required'] = $m_slider['required'];
									$c_slide['title'] = $c_title;
									$c_slide['plugin_require'] = $m_slider['plugin_require'];
									$c_slide['description'] = (isset($m_slider['description'])) ? $m_slider['description'] : '';
									$c_slide['setup_notes'] = (isset($m_slider['setup_notes'])) ? $m_slider['setup_notes'] : '';
									
									$tmpl->write_template_markup($c_slide);
									?>
									<div class="template_meta_line">
										<?php if ($isnew) { ?>
										<span class="template_new"><?php _e("New", "revslider"); ?></span>
										<?php } ?>
										<?php if ($isupdate) { ?>
										<span class="template_new"><?php _e("Update", "revslider"); ?></span>
										<?php } ?>
										<span class="<?php echo $slidercat;?>"><?php _e($etikett_a, "revslider");?></span>
										<span class="template_installed"><?php _e("Installed", "revslider"); ?><i class="eg-icon-check"></i></span>
									</div>	
									<div class="template_thumb_title"><?php echo $title; ?></div>	
								</div>
							<?php 
							}
							?>
							</div>
						</div><?php
					}
				}else{ //not yet imported
					
					$c_slides = $tmpl->getThemePunchTemplateDefaultSlides($m_slider['alias']);
					
					if(!empty($c_slides)){
						?>
						<div style="margin-bottom:30px"  class="template_group_wrappers not-imported-wrapper <?php echo $slidercat.$slidercat_new; if(isset($m_slider['filter'])){ echo implode(' ', $m_slider['filter']); } ?>">
							
							<?php
							echo '<div class="template_slider_title">';
							if(isset($m_slider['preview']) && $m_slider['preview'] !== ''){
								echo '<a class="template_slide_preview" href="'.esc_attr($m_slider['preview']).'" target="_blank"><i class="eg-icon-search"></i></a>';
							}
							echo $m_slider['title'].'</div>';
							
							foreach($c_slides as $key => $c_slide){
								?>
								<div class="temp_slide_single_wrapper">
								<?php
									if(isset($m_slider['filter'])){
										$c_slide['filter'] = $m_slider['filter']; //add filters 
									}
									$c_slide['width'] = $m_slider['width'];
									$c_slide['height'] = $m_slider['height'];
									$c_slide['uid'] = $m_slider['uid'];
									$c_slide['number'] = $key;
									$c_slide['zip'] = $m_slider['zip'];	
									$c_slide['current_version'] = isset($m_slider['current_version']) ? $m_slider['current_version'] : 'N/A';
									$c_slide['required'] = $m_slider['required'];
									$c_slide['title'] = $m_slider['title'];
									$c_slide['plugin_require'] = $m_slider['plugin_require'];
									$c_slide['description'] = (isset($m_slider['description'])) ? $m_slider['description'] : '';
									$c_slide['setup_notes'] = (isset($m_slider['setup_notes'])) ? $m_slider['setup_notes'] : '';
									$c_slide['version'] = isset($m_slider['version']) ? $m_slider['version'] : "N/A";		
									

									$tmpl->write_import_template_markup_slide($c_slide);
									?>
									<div class="template_meta_line">
										<?php if ($isnew) { ?>
										<span class="template_new"><?php _e("New", "revslider"); ?></span>
										<?php } ?>
										<?php /*if ($isupdate) { ?>
										<span class="template_new"><?php _e("Update", "revslider"); ?></span>
										<?php }*/ ?>
										<span class="<?php echo $slidercat;?>"><?php _e($etikett_a, "revslider");?></span>
										<span class="template_notinstalled"><?php _e("Not Installed", "revslider"); ?></span>
									</div>	
									<div class="template_thumb_title"><?php echo (isset($c_slide['title'])) ? $c_slide['title'] : ''; ?></div>
								</div>
							<?php 
							}
							?>							
						</div><?php
					}
					
				}
			}			
		}
		
		if(!empty($all_slider)){
			foreach($all_slider as $c_slider){
				$c_slides = $c_slider->getSlides(false);
				//$c_slides = $c_slider->getArrSlideNames();
				$c_title = $c_slider->getTitle();
				$width = $c_slider->getParam("width",1240);
				$height = $c_slider->getParam("height",868);
				
				/*if(!empty($c_slider['filter']) && is_array($c_slider['filter'])){
					foreach($c_slider['filter'] as $f => $v){
						$c_slider['filter'][$f] = 'temp_'.$v;
					}
				}*/
				
				if(!empty($c_slides)){
					?>
					<div class="template_group_wrappers temp_existing <?php //if(isset($c_slider['filter'])){ echo implode(' ', $c_slider['filter']); } ?>">
						<?php
						echo '<div class="template_slider_title">'.$c_title.'</div>';
						foreach($c_slides as $c_slide){
							?>
							<div class="temp_slide_single_wrapper">
							<?php
								$mod_slide = array();
								$mod_slide['id'] = $c_slide->getID();
								$mod_slide['params'] = $c_slide->getParams();
								//$mod_slide['layers'] = $c_slide->getLayers();
								$mod_slide['settings'] = $c_slide->getSettings();
								$mod_slide['settings']['width'] = $width;
								$mod_slide['settings']['height'] = $height;
								$mod_slide["user_template"]=true;
								
								$title = str_replace("'", "", RevSliderBase::getVar($mod_slide['params'], 'title', 'Slide'));
								$tmpl->write_template_markup($mod_slide);
								?>
								<div class="template_meta_line">									
									<span class="template_local"><?php _e("Local Slide", "revslider");?></span>									
								</div>	
								<div class="template_thumb_title"><?php echo $title; ?></div>
							</div>
							<?php
						}	
						?>						
					</div><?php
				}
				echo '<div style="margin-bottom:30px" class="tp-clearfix"></div>';
			}
		}
		?>		
		<div class="template_group_wrappers temp_custom">
			<?php
			if(!empty($templates)){
				?>		
				<div class="template_slider_title"><?php _e('User Templates', 'revslider'); ?></div>
				<div class="temp_slides_in_slider_wrapper">					
				<?php
				foreach($templates as $template){
					?>
					<div class="temp_slide_single_wrapper">
						<?php	
						$template["user_template"]=true;
						$tmpl->write_template_markup($template);
						?>
						<div class="template_meta_line">									
							<span class="template_local"><?php _e("User Template", "revslider");?></span>									
						</div>	
						<div class="template_thumb_title">Some  Title</div>						
					</div>
					<?php
				}
				?>
				</div>
				<?php
			}
			?>				
		</div>		
	</div>
	
	
	<!-- THE REVOLUTION CUSTOMER TEMPLATES -->
	<div class="revolution-customer-templates revolution-template-groups">
		
	</div>


	<!-- THE ALL SLIDES GROUP -->
	<div class="revolution-all-slides-templates revolution-template-groups">
		
	</div>
</div>
<?php
if(!isset($rs_disable_template_script)){
?>
<script>
	jQuery("document").ready(function() {		
		templateSelectorHandling();
	});

	function isElementInViewport(element,sctop,wh,rtgt) {		
		var etp = parseInt(element.offset().top,0)-rtgt,
			etpp = parseInt(element.position().top,0),
			inviewport = false;						
		if ((etp>-50) && (etp<wh+50))
			inviewport =  true;						
		return inviewport;
	}
	
	function scrollTA() {
		var ta = jQuery('.revolution-template-groups'),
			st = ta.scrollTop(),			
			wh = jQuery(window).height();

		ta.find('.template_item:visible, .template_slide_item_img:visible').each(function() {

			var el = jQuery(this),
				rtgt = parseInt(el.closest('.revolution-template-groups').offset().top,0);
			if (el.data('src')!=undefined && el.data('bgadded')!=1) {
				if (jQuery('#template_area').hasClass("show"))
					if (isElementInViewport(el,st,wh,rtgt)){																			
						el.css({backgroundImage:'url("'+el.data('src')+'")'});														
						el.data('bgadded',1);					
					}
			}
		});
	}


	function templateSelectorHandling() {
		// TEMPLATE ELEMENTS
		

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

		
		jQuery('.template_item, .template_slide_item_img').each(function() {
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

		function templateButtonClicked(btn) {			
			jQuery('.revolution-template-groups').each(function() { jQuery(this).hide();});			
			jQuery("."+btn.data("showgroup")).show();
			jQuery('.revolution-templatebutton').removeClass("selected");
			btn.addClass("selected");
			scrollTA();			
			jQuery('#template_area').perfectScrollbar();
			
			if(btn.data("showgroup") == 'revolution-basic-templates' || btn.data("showgroup") == 'revolution-premium-templates'){
				jQuery('.revolution-filters').show();
			}else{
				jQuery('.revolution-filters').hide();
			}
		};

		jQuery('body').on('click','.show_more_template_slider',function() {
			if (jQuery(this).hasClass("add_user_template_slide_item")) return true;
			jQuery('.temp_slide_single_wrapper').css({zIndex:2});
			var item = jQuery(this).closest('.temp_slide_single_wrapper');
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


		// TEMPLATE TAB CHANGE 
		jQuery('body').on("click",'.revolution-templatebutton',function() {			
			templateButtonClicked(jQuery(this));
		});

		scrollTA();		

		function setTWHeight() {
			var w = jQuery(window).height(),
				wh = jQuery('#template_header_part').height();
			jQuery('.revolution-template-groups').css({height:(w-wh)+"px"});
			jQuery('.revolution-template-groups').perfectScrollbar("update");
		};

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
		
	};

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
					scrollTA();
					jQuery('#template_area').addClass("show");
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
<div id="dialog_import_template_slide" title="<?php _e("Import Template Slide",'revslider'); ?>" class="dialog_import_template_slide" style="display:none">
	<form action="<?php echo RevSliderBase::$url_ajax; ?>" enctype="multipart/form-data" method="post">
		<input type="hidden" name="action" value="revslider_ajax_action">
		<input type="hidden" name="client_action" value="import_slide_template_slidersview">
		<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("revslider_actions"); ?>">
		<input type="hidden" name="uid" class="rs-uid" value="">
		<input type="hidden" name="slidenum" class="rs-slide-number" value="">
		<input type="hidden" name="slider_id" class="rs-slider-id" value="">
		<input type="hidden" name="redirect_id" class="rs-slide-id" value="">
		
		<p><?php _e('Please select the corresponding zip file from the download packages import folder called', 'revslider'); ?>:</p>
		<p class="filetoimport"><b><span class="rs-zip-name"></span></b></p>
		<p class="import-file-wrapper"><input type="file" size="60" name="import_file" class="input_import_slider"></p>
		<span style="margin-top:45px;display:block"><input type="submit" class="rs-import-slider-button button-primary revblue tp-be-button" value="<?php _e("Import Template Slide",'revslider'); ?>"></span>
		<span class="tp-clearfix"></span>
		<span style="font-weight: 700;"><?php _e("Note: style templates will be updated if they exist!",'revslider'); ?></span><br><br>
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


<div id="dialog_import_template_slide_from" title="<?php _e("Import Template Slide",'revslider'); ?>" class="dialog_import_template_slide_from" style="display:none">
	<?php _e('Import Slide from local or from ThemePunch online server?', 'revslider'); ?>
	<form action="<?php echo RevSliderBase::$url_ajax; ?>" enctype="multipart/form-data" method="post" name="rs-import-slide-template-from-server" id="rs-import-slide-template-from-server">
		<input type="hidden" name="action" value="revslider_ajax_action">
		<input type="hidden" name="client_action" value="import_slide_online_template_slidersview">
		<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("revslider_actions"); ?>">
		<input type="hidden" name="uid" class="rs-uid" value="">
		<input type="hidden" name="slidenum" class="rs-slide-number" value="">
		<input type="hidden" name="slider_id" class="rs-slider-id" value="">
		<input type="hidden" name="redirect_id" class="rs-slide-id" value="">
	</form>
</div>
<?php
}
?>