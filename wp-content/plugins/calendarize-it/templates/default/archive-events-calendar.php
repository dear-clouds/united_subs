<?php
/**
 */

get_header(); ?>
<?php do_action('rhc_before_content'); ?>
	<div class="archive-calendar-container">
	<?php 
		//echo generate_calendarize_shortcode();
		echo do_shortcode(generate_calendarize_shortcode());
		//echo do_shortcode(generate_calendarize_shortcode(array('theme'=>'default')));
		//echo do_shortcode(generate_calendarize_shortcode(array('theme'=>'sunny')));
	?>
	</div>
<?php do_action('rhc_after_content'); ?>
<?php get_footer(); ?>