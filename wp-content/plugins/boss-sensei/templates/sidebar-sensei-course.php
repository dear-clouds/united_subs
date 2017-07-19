<?php
/**
 * The sidebar containing the widget area for WordPress blog posts and pages.
 *
 * @package WordPress
 * @subpackage Boss
 * @since Boss 1.0.0
 */
?>
	
<!-- default WordPress sidebar -->
<div id="secondary" class="widget-area" role="complementary">
    <?php the_widget( 'Boss_Edu_Course_Teacher_Widget', 'title=' ); ?>
    <?php dynamic_sidebar( 'sensei-course' ); ?>
</div><!-- #secondary -->
