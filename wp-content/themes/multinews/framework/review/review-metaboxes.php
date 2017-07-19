<?php
global $wpalchemy_media_access;
wp_enqueue_script( 'momizat-mb-review', get_template_directory_uri() . '/framework/review/js/review-meta.js', array('jquery'), '1.0', true );

?>
<div class="mom_meta_control">
    <div class="mom_meta_note"><p><?php _e('To add the <strong>review</strong> inside the post just type <code>[review]</code> in any where or use the editor review button, or use the page builder','framework'); ?></p></div>
    <div class="mom_tiny_form_element">
        <div class="mom_tiny_desc">
            <div class="mom_td_bubble">
                <label for="<?php $mb->the_name(); ?>"><?php _e('Review Style', 'framework'); ?></label>
                <span><?php _e('Select one style or multi if you dont select anything the default style is bars', 'framework'); ?></span>
            </div> <!--bubble-->
        </div> <!--desc-->
        <div class="mom_tiny_input">
            <?php $mb->the_field('review_styles_order'); ?>
            <input type="hidden" id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>" class="review_style_order">

	<?php
        if ($mb->get_the_value() != '') {
            $styles = explode(',', $mb->get_the_value());   
        } else {
            $styles = array('style-bars', 'style-stars', 'style-circles');
        }
        
        ?>
            <div class="review_styles_checkboxes">
	<?php foreach ($styles as $i => $val): 
                if ($val == 'style-bars') {
                    $icon = 'brankic-icon-chart5';
                    $text = __('bars', 'framework');
                } elseif ($val == 'style-circles') {
                    $icon = 'brankic-icon-chart2';
                    $text = __('circles', 'framework');
                } else {
                    $icon = 'fa-icon-star-half-full';
                    $text = __('Stars', 'framework');
                }
                ?>
		<?php $mb->the_field('review_styles', MOMIZATMB_FIELD_HINT_CHECKBOX_MULTI); ?>
		<div id="<?php echo $val; ?>" class="rs-wrap"><span class="rs-handle"><i class="enotype-icon-arrow-left4"></i><i class="enotype-icon-arrow-right4"></i></span><span class="rs-icon"><i class="<?php echo $icon; ?>"></i></span><span class="rs-text"><?php echo $text; ?></span><label class="mom-checkbox-label"><input type="checkbox" name="<?php $mb->the_name(); ?>" value="<?php echo $val; ?>"<?php $mb->the_checkbox_state($val); ?>/><i class="dashicons dashicons-yes"></i></label></div>
	<?php endforeach; ?>
        </div>
        </div> <!--input-->
        <div class="clear"></div>
    </div> <!--mom_meta_item-->

    <div class="mom_tiny_form_element">
   <?php $mb->the_field('review_box_units'); ?>
        <div class="mom_tiny_desc">
            <div class="mom_td_bubble">
                <label for="<?php $mb->the_name(); ?>"><?php _e('Review Units', 'framework'); ?></label>
                <span><?php _e('precent or points, this not work on stars style', 'framework'); ?></span>
            </div> <!--bubble-->
        </div> <!--desc-->
        <div class="mom_tiny_input">
            <select name="<?php $mb->the_name(); ?>">
                <option value="percent" <?php $mb->the_select_state('percent'); ?>><?php _e('Percent', 'framework'); ?></option>
                <option value="points" <?php $mb->the_select_state('points'); ?>><?php _e('Points', 'framework'); ?></option>
            </select>
        </div> <!--input-->
        <div class="clear"></div>
    </div> <!--mom_meta_item-->


    <div class="mom_tiny_form_element">
   <?php $mb->the_field('review_box_title'); ?>
        <div class="mom_tiny_desc">
            <div class="mom_td_bubble">
                <label for="<?php $mb->the_name(); ?>"><?php _e('Review Box Title', 'framework'); ?></label>
                <span><?php _e('', 'framework'); ?></span>
            </div> <!--bubble-->
        </div> <!--desc-->
        <div class="mom_tiny_input">
            <input type="text" id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>" placeholder="<?php _e('Review Overview', 'framework'); ?>">
        </div> <!--input-->
        <div class="clear"></div>
    </div> <!--mom_meta_item-->

    <div class="mom_tiny_form_element">
   <?php $mb->the_field('review_description'); ?>
        <div class="mom_tiny_desc">
            <div class="mom_td_bubble">
                <label for="<?php $mb->the_name(); ?>"><?php _e('Description', 'framework'); ?></label>
                <span><?php _e('review description at the top of the review box', 'framework'); ?></span>
            </div> <!--bubble-->
        </div> <!--desc-->
        <div class="mom_tiny_input">
            <?php wp_editor(html_entity_decode($mb->get_the_value()), 'review_desc', array('textarea_name' =>$mb->get_the_name(), 'textarea_rows' => 10, 'media_buttons'=> false)); ?>
        </div> <!--input-->
        <div class="clear"></div>
    </div> <!--mom_meta_item-->

    <div class="mom_tiny_form_element">
   <?php $mb->the_field('review_summary'); ?>
        <div class="mom_tiny_desc">
            <div class="mom_td_bubble">
                <label for="<?php $mb->the_name(); ?>"><?php _e('Summary', 'framework'); ?></label>
                <span><?php _e('review summary at the bottom of the review box', 'framework'); ?></span>
            </div> <!--bubble-->
        </div> <!--desc-->
        <div class="mom_tiny_input">
            <?php wp_editor(html_entity_decode($mb->get_the_value()), 'review_summary', array('textarea_name' =>$mb->get_the_name(), 'media_buttons'=> false)); ?>
        </div> <!--input-->
        <div class="clear"></div>
    </div> <!--mom_meta_item-->
        <div class="mom_tiny_form_element">
   <?php $mb->the_field('review_score_title'); ?>
        <div class="mom_tiny_desc">
            <div class="mom_td_bubble">
                <label for="<?php $mb->the_name(); ?>"><?php _e('Score title', 'framework'); ?></label>
                <span><?php _e('the title under the score e.g. Amazing, Awesome, Bad, Awful', 'framework'); ?></span>
            </div> <!--bubble-->
        </div> <!--desc-->
        <div class="mom_tiny_input">
            <input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>">
        </div> <!--input-->
        <div class="clear"></div>
    </div> <!--mom_meta_item-->
        <div class="mom_tiny_form_element">
	<?php $mb->the_field('review_user_rate'); ?>
        <div class="mom_tiny_desc">
            <div class="mom_td_bubble">
                <label for="<?php $mb->the_name(); ?>"><?php _e('Enable user rate', 'framework'); ?></label>
                <span><?php _e('give your visitors abillity to rate your post', 'framework'); ?></span>
            </div> <!--bubble-->
        </div> <!--desc-->
        <div class="mom_tiny_input">
            <div class="mom_switch"><input type="checkbox" name="<?php $mb->the_name(); ?>" value="on"<?php $mb->the_checkbox_state('on'); ?>/><label><i></i></label></div>
        </div> <!--input-->
        <div class="clear"></div>
    </div> <!--mom_meta_item-->
    <h2 class="mom_meta_subtitle"><?php _e('Review Review Criterias', 'framework'); ?></h2>
    <div class="mom-review-criterias">
    <div class="rs-criterias">
    <?php
	$all_scores = 0;
	$score = 0;
    ?>
    <?php while($mb->have_fields_and_multi('review-criterias')): ?>
    <?php $mb->the_group_open(); ?>
        <div class="rs-criteria">
            <span class="rsc-sort-handle"><i class="enotype-icon-arrow-up"></i><i class="enotype-icon-arrow-down"></i></span>
            <?php $mb->the_field('cr_name'); ?>
            <div class="cr-input cr-name"><label><?php _e('Name', 'framework'); ?></label><input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"></div>
            <?php $mb->the_field('cr_score'); ?>
            <div class="cr-input cr-score">
                <label><?php _e('Score', 'framework'); ?></label>
                <div class="mom_meta_slider_wrap" data-id="<?php $mb->the_index(); ?>" data-name="<?php $mb->the_name(); ?>">
                <div id="mom_meta_slider-<?php $mb->the_index(); ?>" class="mom_meta_slider"></div>
            <input type="text" class="mom_cr_single_score" id="mom_slider_input-<?php $mb->the_index(); ?>" name="<?php $mb->the_name(); ?>" id="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"><span class="crs-suffix">%</span>
	    <?php 
		$all_scores += 100;
		$score += $mb->get_the_value();
	    ?>
        </div>
    </div>
            <div class="cr-input cr-colors">
                <?php $mb->the_field('cr_bg'); ?>
                <div class="crc-input"><label><?php _e('Background', 'framework'); ?></label><div class="mom_color_meta_wrap"  data-id="<?php $mb->the_index(); ?>" data-name="<?php $mb->the_name(); ?>"><input class="mom_meta_color" type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"></div></div>
                <?php $mb->the_field('cr_txt'); ?>
                <div class="crc-input"><label><?php _e('Text', 'framework'); ?></label><div class="mom_color_meta_wrap"  data-id="<?php $mb->the_index(); ?>" data-name="<?php $mb->the_name(); ?>"><input class="mom_meta_color" type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"></div></div>
            </div> 

            	    <a href="#" class="dodelete delete-cr momizat-icon-close"></a>
<div class="clear"></div>
        </div>
    <?php $mb->the_group_close(); ?>
    <?php endwhile; ?>
    <a href="#" class="docopy-review-criterias add-new-group-item button button-primary"><?php _e('Add new criteria', 'framework') ?></a>
    </div>
		   <?php $all_scores = $all_scores-100; $the_score = $score/$all_scores*100; $the_score = round($the_score); ?>
                   <?php $mb->the_field('review-all-score'); ?>
		    <input class="reveiw-all-score" type="hidden" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>" data-all_scores="<?php echo $all_scores; ?>" data-score="<?php echo $score; ?>">

                   <?php $mb->the_field('review-final-score'); ?>
		    <input class="reveiw-final-score" type="hidden" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>">

    </div><!--inpurt -->
    <div class="clear"></div>
</div> <!--mom meta wrap-->