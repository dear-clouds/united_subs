<?php
add_action( 'wp_enqueue_scripts', 'mom_review_scripts');
function mom_review_scripts() {
	wp_register_script('knob', get_template_directory_uri() . '/framework/review/js/jquery.knob.js', 'jquery','1.0',true);
	wp_register_script('momizat-review', get_template_directory_uri() . '/framework/review/js/review.js', 'jquery','1.0',true);
	//wp_register_style( 'momizat-review-css', get_template_directory_uri() . '/framework/review/css/review.css');
}

function mom_review_system($atts, $content = null) {
	extract(shortcode_atts(array(
	'id' => '',
	), $atts));
ob_start();
wp_enqueue_script('knob');
wp_enqueue_script('momizat-review');
//wp_enqueue_style('momizat-review-css');
global $post;
if ($id == '') {
	$id = $post->ID;
}
$styles = get_post_meta($id,'_mom_review_styles',false);
$nostyle = array_filter($styles);
if (empty($nostyle)) {
	$styles = array( array('style-bars'));
}
$units = get_post_meta($id,'_mom_review_box_units',true);
$title = get_post_meta($id,'_mom_review_box_title',true);
$desc = get_post_meta($id,'_mom_review_description',true);
$summary = get_post_meta($id,'_mom_review_summary',true);
$score_title = get_post_meta($id,'_mom_review_score_title',true);
$user_rate = get_post_meta($id,'_mom_review_user_rate',true);

$criterias = get_post_meta($id,'_mom_review-criterias',false);
$voters_count = get_post_meta( $id, "mom_rate_count", true );
if (!$voters_count) {
	$voters_count = 0;
}
$all_scores = 0;
$the_score = 0;
$score = 0;
if (is_array($criterias)) {
foreach($criterias[0] as $criteria) {
	$all_scores += 100;
	$score += $criteria['cr_score'];
}
}
$the_score = $score/$all_scores*100;
$int_score = round($the_score);
$stars = $int_score/20;
$points = $int_score/10;
$the_score = $int_score;
$rs_suffix = '';
$print_score = $the_score;
if ($units == 'points') {
	$print_score = $points;
} 
if ($units == 'percent') {
	$rs_suffix = '%';
}
?>
<?php if ($the_score != '') { ?>
<div style="display:none;">
  <div>
    <span itemprop="itemreviewed"><?php the_title(); ?></span>
    <?php _e('Reviewed by', 'framework'); ?><span itemprop="author"><?php echo get_the_author_meta( 'display_name' ); ?></span> <?php _e('on', 'framework'); ?>
    <time itemprop="datePublished" content="<?php the_time('Y-m-d'); ?>"><?php the_time('F d'); ?></time>.
    <span itemprop="description"><?php if($desc){ echo $desc; } ?></span>
<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
        <span itemprop="ratingValue"><?php echo $stars; ?></span> 
      <meta itemprop="bestRating" content="5"/>
      <meta itemprop="worstRating" content="1"/>    
  </div>
  </div>
</div>


<div class="mom-reveiw-system">
    <header class="review-header">
        <h2><?php if ($title) { echo $title; } else { _e('Review Overview', 'framework'); } ?></h2>
        <ul class="mr-types">
		<?php
		foreach ($styles[0] as $rs) {
			if ($rs == 'style-bars') {
				echo '<li class="bars"><i class="brankic-icon-chart5"></i></li>';
			} elseif ($rs == 'style-stars') {
				echo '<li class="stars"><i class="fa-icon-star-half-full"></i></li>';
			} else {
				echo '<li class="circles"><i class="brankic-icon-chart2"></i></li>';
			} 
		?>
	    <?php } ?>
        </ul>
    </header>
 <?php
	foreach ($styles[0] as $rs) {
		if ($rs == 'style-bars') {
?>
<div class="review-tab bars-tab">
    <div class="review-content">
	<?php if($desc) { ?>
        <div class="review-desc">
		<?php echo do_shortcode($desc); ?>
        </div>
	<?php } ?>
    
    <div class="review-area">

            <div class="review-bars">
		<?php foreach($criterias[0] as $criteria) {
			$cr_score = $criteria['cr_score'];
			if ($units == 'points') {
				$cr_score = $cr_score/10;
			}
		?>
            <div class="mom-bar">
                <div class="mb-inner" style="width:<?php echo $criteria['cr_score']; ?>%; background: <?php echo $criteria['cr_bg']; ?>;">
			<span class="cr" style="color:<?php if (isset($criteria['cr_txt'])) { echo $criteria['cr_txt'];} ?>;"><?php echo $criteria['cr_name']; ?></span>
			<span class="mb-score" style="color: <?php echo $criteria['cr_bg']; ?>;"><?php echo $cr_score; ?><?php echo $rs_suffix; ?></span>
                </div>
            </div>
	    <?php } ?>
        
        
        </div>
    </div>
    
    <div class="review-summary">
        <div class="review-score">
            <div class="score-wrap bars-score">
                <span class="score"><?php echo $print_score; ?><?php echo $rs_suffix; ?></span>
                <span class="score-title"><?php if ($score_title) { echo $score_title; } ?></span>
            </div>
        </div>
	<?php if($summary) { ?>
		<?php echo do_shortcode($summary); ?>
	<?php } ?>

    </div>
    </div> <!-- review-content -->
    <?php if (isset($user_rate) && $user_rate == 'on') { ?>
    <footer class="review-footer">
        <div class="user-rate bars">
            <h3  class="mom_user_rate_title"><strong class="your_rate" style="display:none;"><?php _e('Your Rating:', 'framework'); ?></strong><strong class="user_rate"><?php _e('User Rating:', 'framework'); ?></strong></h3>
	    <div class="user-rate-bar">
            	<?php echo momizat_getPostRate($id, 'bars'); ?>
	    </div>
            <span class="total-votes">(<span class="tv-count"><?php echo $voters_count; ?></span> <?php _e('votes', 'framework'); ?>)</span>
        </div>
    </footer> <!-- footer -->
    <?php } ?>
    </div> <!-- bars tab -->
<?php } elseif($rs == 'style-stars') { ?>
    <!-- Stars Tab -->
    <div class="review-tab stars-tab">
    <div class="review-content">
	<?php if($desc) { ?>
        <div class="review-desc">
		<?php echo do_shortcode($desc); ?>
        </div>
	<?php } ?>
    
    <div class="review-area">
        <div class="mom-stars">
		<?php foreach($criterias[0] as $criteria) {
			$cr_score = $criteria['cr_score'];
		?>
            <div class="stars-cr">
		<?php
			$txt_color = isset($criteria['cr_txt']) ? $criteria['cr_txt'] : '' ;
			if ($txt_color == '') {
				$txt_color = isset($criteria['cr_bg']) ? $criteria['cr_bg'] : '';
			}
		?>
                <span class="cr" style="color:<?php echo $txt_color; ?>;"><?php echo $criteria['cr_name']; ?></span>
                <div class="star-rating mom_review_score" style="color:<?php echo $criteria['cr_bg']; ?>;"><span style="width:<?php echo $criteria['cr_score']; ?>%; color: <?php echo $criteria['cr_bg']; ?>;"></span></div>
	    </div>
	    <?php } ?>
        </div>
    </div> <!-- review area -->
    
    <div class="review-summary">
        <div class="review-score">
            <div class="score-wrap stars-score">
                <div class="star-rating mom_review_score"><span style="width:<?php echo $int_score; ?>%"></span></div>                    
                <span class="score-title"><?php if ($score_title) { echo $score_title; } ?></span>
            </div>
        </div>
	<?php if($summary) { ?>
		<?php echo do_shortcode($summary); ?>
	<?php } ?>
    </div>
    </div> <!-- review-content -->
    <?php if (isset($user_rate) && $user_rate == 'on') { ?>
    <footer class="review-footer">
        <div class="user-rate bars user-star-rate">
            <h3  class="mom_user_rate_title"><strong class="your_rate" style="display:none;"><?php _e('Your Rating:', 'framework'); ?></strong><strong class="user_rate"><?php _e('User Rating:', 'framework'); ?></strong></h3>
            <div class="user-rate-bar">
		<?php echo momizat_getPostRate($id); ?>
	    </div>
            <span class="total-votes">(<span class="tv-count"><?php echo $voters_count; ?></span> <?php _e('votes', 'framework'); ?>)</span>
        </div>
    </footer> <!-- footer -->
    <?php } ?>
    </div> <!-- stars tab -->    
    <?php } else { ?>
    <!-- Circles Bar  -->
        <div class="review-tab circles-tab">
    <div class="review-content">
	<?php if($desc) { ?>
        <div class="review-desc">
		<?php echo do_shortcode($desc); ?>
        </div>
	<?php } ?>
    
    <div class="review-area">
        <div class="review-circles">
		<?php foreach($criterias[0] as $criteria) {
			$cr_score = $criteria['cr_score'];
			if ($units == 'points') {
				$cr_score = $cr_score/10;
			}
			$td_color = '#eee';
			if (mom_option('mom_color_skin') == 'black') {
				$td_color = '#2D2F2F';
			}
			
			$fd_color = '#4A525D';
			if (mom_option('mom_color_skin') == 'black') {
				$fd_color = '#111';
			}
		?>
            <div class="review-circle">
		<div class="circle">
 <input type="text" class="rc-value" data-width="147" data-height="90" data-angleArc="200" data-angleOffset="-100" data-readOnly="true" value="<?php echo $criteria['cr_score']; ?>" data-thickness=".25" data-fgColor="<?php echo isset($criteria['cr_bg'])? $criteria['cr_bg']: '#78bce7'; ?>" data-bgColor="<?php echo $td_color; ?>">
                    <span class="val" style="color:<?php echo $criteria['cr_bg']; ?>;"><?php echo $cr_score; ?><?php echo $rs_suffix; ?></span>
                </div>
		<?php
			$txt_color = isset($criteria['cr_txt']) ? $criteria['cr_txt'] : '' ;
			if ($txt_color == '') {
				$txt_color = isset($criteria['cr_bg']) ? $criteria['cr_bg'] : '';
			}
		?>		
                <span class="cr" style="color:<?php echo $txt_color; ?>;"><?php echo $criteria['cr_name']; ?></span>
            </div> <!-- circle -->
		<?php } ?>
        </div><!-- circles -->
    </div>
    
    <div class="review-summary">
        <div class="review-score">
            <div class="score-wrap circles-score">

            <div class="review-circle">
                <div class="circle">
                    <input type="text" class="rc-value" data-width="122" data-height="76" data-angleArc="200" data-angleOffset="-100" data-readOnly="true" value="<?php echo $the_score; ?>" data-thickness=".25" data-fgcolor="<?php echo $fd_color; ?>" data-bgColor="<?php echo $td_color; ?>">
		    
		    <span class="val"><?php echo $print_score; ?><?php echo $rs_suffix; ?></span>
                </div>
                <span class="cr"><?php if ($score_title) { echo $score_title; } ?></span>
            </div> <!-- circle -->
	    
            </div>
        </div>
	<?php if($summary) { ?>
		<?php echo do_shortcode($summary); ?>
	<?php } ?>

    </div>
    </div> <!-- review-content -->
    <?php if (isset($user_rate) && $user_rate == 'on') { ?>
    <footer class="review-footer">
        <div class="user-rate">
            <h3  class="mom_user_rate_title"><strong class="your_rate" style="display:none;"><?php _e('Your Rating:', 'framework'); ?></strong><strong class="user_rate"><?php _e('User Rating:', 'framework'); ?></strong></h3>
            <div class="user-rate-circle">
		<?php echo momizat_getPostRate($id, 'circles'); ?>
            </div>
            <span class="total-votes">(<span class="tv-count"><?php echo $voters_count; ?></span> <?php _e('votes', 'framework'); ?>)</span>
        </div>
    </footer> <!-- footer -->
    <?php } ?>
    </div> <!-- Circles tab -->
    <?php } 
        } // end foreach
    ?>
</div> <!-- mom Review -->
<?php } ?>
<?php
$content = ob_get_contents();
ob_end_clean();
return $content;


}
add_shortcode("review", "mom_review_system");
?>