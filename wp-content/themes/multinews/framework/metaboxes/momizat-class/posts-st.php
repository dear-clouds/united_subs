<?php global $wpalchemy_media_access; ?>

<div class="my_meta_control">
    <p class="posts_extra_item posts_extra_empty"><?php _e('This boxes show only if you select post format need extra options', 'theme'); ?></p>
<div id="pt_slider_meta" class="posts_extra_item pt_slider_meta hide">
    <div id="slider_meta_control" style="margin-top: 15px;">
    <?php while($mb->have_fields_and_multi('slides')): ?>
    <?php $mb->the_group_open(); ?>
 <div class="slides_meta_wrap">
        <a href="#" class="dodelete button"><?php _e('Remove <img src="'. MOM_URI.'/framework/metaboxes/img/trash.png" alt="x">', 'framework') ?></a>
	<span class="shandle"><img src="<?php  echo MOM_URI; ?>/framework/metaboxes/img/move.png" alt="move"></span>
        <?php $mb->the_field('imgid'); ?>
        <label for="<?php $mb->the_name(); ?>"><?php _e('upload Image', 'framework') ?></label>
        <?php $wpalchemy_media_access->setGroupName('img-n'. $mb->get_the_index())->setInsertButtonLabel('Insert'); ?>
        <p>
            <?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(), 'value' => $mb->get_the_value(), 'class' => 'mom_mb_image_imgID', 'type' => 'hidden')); ?>
            <?php echo $wpalchemy_media_access->getButton(); ?>
 	<span class="mom_preview_meta_img"><img alt="" /></span>
        <?php $mb->the_field('preview'); ?>
	<input type="hidden" id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>" class="mom_preview_meta_input" style="visibility: hidden; position: absolute;">
	</p>
 
        <?php $mb->the_field('caption'); ?>
        <label for="<?php $mb->the_name(); ?>"><?php _e('Caption', 'framework') ?></label>
        <p><textarea id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>"><?php $mb->the_value(); ?></textarea></p>
	        <?php $mb->the_field('link'); ?>
        <label for="<?php $mb->the_name(); ?>"><?php _e('Link', 'framework') ?></label>
        <p><input type="text" id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
		<br><br><small><?php _e('leave blank and the image will open in lightbox', 'theme'); ?></small>
	</p>
        <?php $mb->the_field('target'); ?>
        <label for="<?php $mb->the_name(); ?>"><?php _e('Link Target', 'framework') ?></label>
			<p>
			<select name="<?php $mb->the_name(); ?>">
			<option value=""<?php $mb->the_select_state(''); ?>><?php _e('Open link in the same window', 'framework'); ?></option>
			<option value="_blank"<?php $mb->the_select_state('_blank'); ?>><?php _e('Open link in new window', 'framework'); ?></option>
		</select>
			</p>
 </div>
    <?php $mb->the_group_close(); ?>
    <?php endwhile; ?>
    </div>
    <p style="margin-bottom:15px;"><a href="#" class="docopy-slides copy_bt button"><?php _e('Add Slide <img src="'. MOM_URI.'/framework/metaboxes/img/add.png" alt="+">', 'framework') ?></a></p>
</div>

<div class="posts_extra_item pt_video_url hide">
<p>
    <?php $mb->the_field('video_type'); ?>
<label for="<?php $mb->the_name(); ?>"><?php _e('Type', 'framework') ?></label>
<select name="<?php $mb->the_name(); ?>">
<option value="youtube" <?php $mb->the_select_state('youtube'); ?>><?php _e('Youtube', 'framework'); ?></option>
<option value="vimeo" <?php $mb->the_select_state('vimeo'); ?>><?php _e('Vimeo', 'framework'); ?></option>
<option value="daily" <?php $mb->the_select_state('daily'); ?>><?php _e('Dailymotion', 'framework'); ?></option>
<option value="facebook" <?php $mb->the_select_state('facebook'); ?>><?php _e('Facebook', 'framework'); ?></option>
<option value="html5" <?php $mb->the_select_state('html5'); ?>><?php _e('Self Hosted Video', 'framework'); ?></option>
</select>
<span class="description html5_video hide"><?php _e('you can upload only one video but the unsupported Browsers/Devices will play video in flash', 'framework'); ?></span>
</p>
<p class="external_video">
<?php $mb->the_field('video_id'); ?>
<label for="<?php $mb->the_name(); ?>"><?php _e('Video ID', 'framework') ?></label>
<input type="text" id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
<span class="description"><?php _e('the id is the bold text  eg. http://vimeo.com/<strong>27299211</strong>, https://www.youtube.com/watch?v=<strong>1LzRIhUAilk</strong>', 'framework'); ?></span>
</p>
<p class="external_video">
<?php $mb->the_field('video_height'); ?>
<label for="<?php $mb->the_name(); ?>"><?php _e('Video Height', 'framework') ?></label>
<input type="text" id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
</p>
<div class="html5_video hide">
<div>
<?php $mb->the_field('html5_poster_img'); ?>
<!-- 	<span class="html5_poster"><img alt="" /></span>
--><label for="<?php $mb->the_name(); ?>"><?php _e('Poster Image', 'framework') ?></label>
        <?php $wpalchemy_media_access->setGroupName('img-n'. $mb->get_the_index())->setInsertButtonLabel('Insert'); ?>
        <p>
            <?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(), 'class' => 'mom_full_meta_input', 'value' => $mb->get_the_value())); ?>
            <?php echo $wpalchemy_media_access->getButton(); ?>
        <?php $mb->the_field('preview'); ?>
	<input type="hidden" id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>" class="html5_poster_prev mom_preview_meta_input">
<span class="description"><?php _e('the image of the video, you see it before playing the video', 'framework'); ?></span>
        </p>
</div>
<div>
<?php $mb->the_field('html5_mp4'); ?>
<label for="<?php $mb->the_name(); ?>"><?php _e('Mp4 video', 'framework') ?></label>
        <?php $wpalchemy_media_access->setGroupName('vid-n'. $mb->get_the_index())->setInsertButtonLabel('Insert'); ?>
        <p>
            <?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(), 'class' => 'mom_full_meta_input', 'value' => $mb->get_the_value())); ?>
            <?php echo $wpalchemy_media_access->getButton(); ?>
        </p>
</div>
<div>
<?php $mb->the_field('html5_m4v'); ?>
<label for="<?php $mb->the_name(); ?>"><?php _e('M4V video', 'framework') ?></label>
        <?php $wpalchemy_media_access->setGroupName('vid-n'. $mb->get_the_index())->setInsertButtonLabel('Insert'); ?>
        <p>
            <?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(), 'class' => 'mom_full_meta_input', 'value' => $mb->get_the_value())); ?>
            <?php echo $wpalchemy_media_access->getButton(); ?>
        </p>
</div>

<div>
<?php $mb->the_field('html5_webm'); ?>
<label for="<?php $mb->the_name(); ?>"><?php _e('WEBM video', 'framework') ?></label>
        <?php $wpalchemy_media_access->setGroupName('vid-n'. $mb->get_the_index())->setInsertButtonLabel('Insert'); ?>
        <p>
            <?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(),'class' => 'mom_full_meta_input', 'value' => $mb->get_the_value())); ?>
            <?php echo $wpalchemy_media_access->getButton(); ?>
        </p>
</div>

<div>
<?php $mb->the_field('html5_ogv'); ?>
<label for="<?php $mb->the_name(); ?>"><?php _e('OGV video', 'framework') ?></label>
        <?php $wpalchemy_media_access->setGroupName('vid-n'. $mb->get_the_index())->setInsertButtonLabel('Insert'); ?>
        <p>
            <?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(), 'class' => 'mom_full_meta_input', 'value' => $mb->get_the_value())); ?>
            <?php echo $wpalchemy_media_access->getButton(); ?>
        </p>
</div>

<div>
<?php $mb->the_field('html5_wmv'); ?>
<label for="<?php $mb->the_name(); ?>"><?php _e('WMV video', 'framework') ?></label>
        <?php $wpalchemy_media_access->setGroupName('vid-n'. $mb->get_the_index())->setInsertButtonLabel('Insert'); ?>
        <p>
            <?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(), 'class' => 'mom_full_meta_input', 'value' => $mb->get_the_value())); ?>
            <?php echo $wpalchemy_media_access->getButton(); ?>
        </p>
</div>

<div>
<?php $mb->the_field('html5_flv'); ?>
<label for="<?php $mb->the_name(); ?>"><?php _e('FLV video', 'framework') ?></label>
        <?php $wpalchemy_media_access->setGroupName('vid-n'. $mb->get_the_index())->setInsertButtonLabel('Insert'); ?>
        <p>
            <?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(), 'class' => 'mom_full_meta_input', 'value' => $mb->get_the_value())); ?>
            <?php echo $wpalchemy_media_access->getButton(); ?>
        </p>
</div>
</div>
<div>
<?php $mb->the_field('html5_duration'); ?>
<label for="<?php $mb->the_name(); ?>"><?php _e('Video Duration', 'framework') ?></label>
        <p>
<input type="text" id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
<span class="description"><?php _e('if you want see the duration of video in the image thumbnail', 'framework'); ?></span>
        </p>
</div>

</div>
<div class="posts_extra_item pt_audio_st hide">
<p>
<?php $mb->the_field('audio_type'); ?>
<label for="<?php $mb->the_name(); ?>"><?php _e('Type', 'framework') ?></label>
<select name="<?php $mb->the_name(); ?>">
<option value="soundcloud" <?php $mb->the_select_state('soundcloud'); ?>><?php _e('SoundCloud', 'framework'); ?></option>
<option value="html5" <?php $mb->the_select_state('html5'); ?>><?php _e('Self Hosted Audio', 'framework'); ?></option>
</select>
<span class="description html5_audio hide"><?php _e('you can upload only one audio but the unsupported Browsers/Devices will play audio in flash', 'framework'); ?></span>
</p>
<div class="external_audio">
<p>
<?php $mb->the_field('audio_sc'); ?>
<label for="<?php $mb->the_name(); ?>"><?php _e('SoundCloud', 'framework') ?></label>
<input type="text" id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
<span class="description"><?php _e('Soundcolud Track link', 'framework'); ?></span>
</p>
</div> <!--html_5audio-->

<div class="html5_audio hide">
<p>
<?php $mb->the_field('audio_mp3'); ?>
<label for="<?php $mb->the_name(); ?>"><?php _e('MP3', 'framework') ?></label>
        <?php $wpalchemy_media_access->setGroupName('aud-n'. $mb->get_the_index())->setInsertButtonLabel('Insert'); ?>
            <?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(), 'class' => 'mom_full_meta_input', 'value' => $mb->get_the_value())); ?>
            <?php echo $wpalchemy_media_access->getButton(); ?>
</p>
<p>
<?php $mb->the_field('audio_ogg'); ?>
<label for="<?php $mb->the_name(); ?>"><?php _e('OGG', 'framework') ?></label>
        <?php $wpalchemy_media_access->setGroupName('aud-n'. $mb->get_the_index())->setInsertButtonLabel('Insert'); ?>
            <?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(), 'class' => 'mom_full_meta_input', 'value' => $mb->get_the_value())); ?>
            <?php echo $wpalchemy_media_access->getButton(); ?>
</p>
<p>
<?php $mb->the_field('audio_m4a'); ?>
<label for="<?php $mb->the_name(); ?>"><?php _e('M4A', 'framework') ?></label>
        <?php $wpalchemy_media_access->setGroupName('aud-n'. $mb->get_the_index())->setInsertButtonLabel('Insert'); ?>
            <?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(), 'class' => 'mom_full_meta_input', 'value' => $mb->get_the_value())); ?>
            <?php echo $wpalchemy_media_access->getButton(); ?>
</p>
<p>
<?php $mb->the_field('audio_wav'); ?>
<label for="<?php $mb->the_name(); ?>"><?php _e('WAV', 'framework') ?></label>
        <?php $wpalchemy_media_access->setGroupName('aud-n'. $mb->get_the_index())->setInsertButtonLabel('Insert'); ?>
            <?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(), 'class' => 'mom_full_meta_input', 'value' => $mb->get_the_value())); ?>
            <?php echo $wpalchemy_media_access->getButton(); ?>
</p>
<p>
<?php $mb->the_field('audio_wma'); ?>
<label for="<?php $mb->the_name(); ?>"><?php _e('WMA', 'framework') ?></label>
        <?php $wpalchemy_media_access->setGroupName('aud-n'. $mb->get_the_index())->setInsertButtonLabel('Insert'); ?>
            <?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(), 'class' => 'mom_full_meta_input', 'value' => $mb->get_the_value())); ?>
            <?php echo $wpalchemy_media_access->getButton(); ?>
</p>
</div> <!--html_5audio-->
<div>
<?php $mb->the_field('html5_duration'); ?>
<label for="<?php $mb->the_name(); ?>"><?php _e('Audio Duration', 'framework') ?></label>
        <p>
<input type="text" id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
<span class="description"><?php _e('if you want see the duration of Audio in the image thumbnail', 'framework'); ?></span>
        </p>
</div>

</div>

<div class="posts_extra_item pt_aside_st hide">
<?php $mb->the_field('aside_embed'); ?>
<p>
<label for="<?php $mb->the_name(); ?>"><?php _e('Aside embed', 'framework') ?></label>
<textarea id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>" rows="4"><?php $mb->the_value(); ?></textarea>
<span class="description"><?php _e('for example it can be facebook post or anything you want', 'framework'); ?></span>

</p>
</div>
<div class="posts_extra_item pt_status_st hide">
<?php $mb->the_field('status_embed'); ?>
<p>
<label for="<?php $mb->the_name(); ?>"><?php _e('status embed', 'framework') ?></label>
<textarea id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>" rows="4"><?php $mb->the_value(); ?></textarea>
<span class="description"><?php _e('for example it can be twitter tweet or anything you want', 'framework'); ?></span>

</p>
</div>

<div class="posts_extra_item pt_link_st hide">
<?php $mb->the_field('link_url'); ?>
<p>
<label for="<?php $mb->the_name(); ?>"><?php _e('Link URL', 'framework') ?></label>
<input type="text" id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
</p>
</div>

<div class="posts_extra_item pt_chat_st hide">
        <div class="mom_tiny_form_element">
   <?php $mb->the_field('chat_post_top_content'); ?>
        <div class="mom_tiny_desc">
            <div class="mom_td_bubble">
                <label for="<?php $mb->the_name(); ?>"><?php _e('Top content ', 'framework'); ?></label>
                <span><?php _e('add any content above the chat', 'framework'); ?></span>
            </div> <!--bubble-->
        </div> <!--desc-->
        <div class="mom_tiny_input">
            <?php wp_editor(html_entity_decode($mb->get_the_value()), 'top_cont', array('textarea_name' =>$mb->get_the_name(), 'media_buttons'=> false)); ?>
        </div> <!--input-->
        <div class="clear"></div>
    </div> <!--mom_meta_item-->

            <div class="mom_tiny_form_element">
   <?php $mb->the_field('chat_post_bottom_content'); ?>
        <div class="mom_tiny_desc">
            <div class="mom_td_bubble">
                <label for="<?php $mb->the_name(); ?>"><?php _e('Bottom content ', 'framework'); ?></label>
                <span><?php _e('add any content under the chat', 'framework'); ?></span>
            </div> <!--bubble-->
        </div> <!--desc-->
        <div class="mom_tiny_input">
            <?php wp_editor(html_entity_decode($mb->get_the_value()), 'bottom_cont', array('textarea_name' =>$mb->get_the_name(), 'media_buttons'=> false)); ?>
        </div> <!--input-->
        <div class="clear"></div>
    </div> <!--mom_meta_item-->


</div>
</div>
<script type="text/javascript">
//<![CDATA[
 jQuery(function($) {
 $('#wpa_loop-slides').sortable({
 placeholder: "port-state-highlight",
 handle: ".shandle"
 });
$('.wpa_group-slides').each( function() {
			var $this = $(this);
			var $img = $this.find('input.mom_preview_meta_input').val();
			$this.find('.image-preview img').attr('src', $img);
			
});
$('.speaker1 img').attr('src',$('input.chat_speaker1_avatar').val())
$('.speaker2 img').attr('src',$('input.chat_speaker2_avatar').val())

$('.html5_poster img').attr('src',$('input.html5_poster_prev').val())

 });

//]]>
</script>