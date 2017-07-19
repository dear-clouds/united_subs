<?php
/**
 */
global $rhc_plugin;
ob_start();
$cat = $wp_query->get_queried_object();
$taxonomy = $cat->taxonomy;
$term_id = $cat->term_id;
$term = get_term($term_id,$cat->taxonomy);
include $rhc_plugin->get_template_path('content-taxonomy-venue.php');
$output = ob_get_contents();
$output = apply_filters('the_content',$output);
ob_end_clean();
//------
get_header(); ?>
<?php do_action('rhc_before_content'); ?>
<div class="rhc-taxonomy-venue-v1">
<?php echo $output; ?> 
</div>
<?php do_action('rhc_after_content') ?>
<?php get_footer(); ?>