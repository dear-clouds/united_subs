<?php
/**
 */
$use_dynamic_gmap = true;
 
$cat = $wp_query->get_queried_object();
$term_id = $cat->term_id;
$term = get_term($term_id,$cat->taxonomy);

$content = get_term_meta($term_id,'content',true);
$content = trim($content)==''?$term->description:$content;

$website = get_term_meta($term_id,'website',true);
$href = false===strpos($website,'://')?'http://'.$website:$website;

//-------
get_header(); ?>
<?php do_action('rhc_before_content'); ?>
<div class="venue-container custom-content-area">
	
	<div class="venue-top-info">
		<div class="venue-name"><?php echo $term->name?></div>
		<div class="venue-details-holder">
			<div class="venue-image-holder"><?php echo get_term_image($term_id)?></div>
			<div class="venue-defails">
         
				<div class="venue-phone"><label class="tax-telephone"><?php _e('Telephone','rhc')?></label><?php echo get_term_meta($term_id,'phone',true)?></div>
				<div class="venue-email"><label class="tax-email"><?php _e('Email','rhc')?></label><?php echo get_term_meta($term_id,'email',true)?></div>
				<div class="venue-website"><label class="tax-website"><?php _e('Website','rhc')?></label><a target="_blank" class="venue-website" href="<?php echo $href?>"><?php echo $website?></a></div>
            	
				<div class="venue-description"><?php global $post;unset($post);echo apply_filters("the_content", $content);?></div>
			</div>
           
		</div>
		<div class="clear"></div>
	</div>
<?php 
	$settings = array(
		//'theme'=>'default',
		//'theme'=>'sunny',
		//'monthnames'=>'Enero,Febrero,Marzo,Abril,Mayo,Junio,Julio,Agosto,Septiembre,Noviembre,Diciembre',
		'defaultview'=>'rhc_event'
	);
	echo do_shortcode(generate_calendarize_shortcode($settings));
?>
</div>
<?php do_action('rhc_after_content') ?>
<?php get_footer(); ?>