<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
?>

<?php 
	if ($atts['type'] == 'user_list') {
		$shortcode = '[ld_profile]';
	}
	elseif ($atts['type'] == 'course_content') {
		$shortcode = '[course_content course_id=".123."]';
	}
	else {
		if ($atts['type'] == 'courses_list') {
			$prefix = "ld_course_list";
		} 
		elseif ($atts['type'] == 'lessons_list'){
			$prefix = "ld_lesson_list";
		}
		else {
			$prefix = "ld_quiz_list";
		}
		
		$num = ' num="'.$atts['num'].'"';
		$only_current_user = ($atts['only_current_user'] == true) ? ' mycourses="true"' : '';
		$order = ' order="'.$atts['order'].'"';
		$tag = (!empty($atts['tag'])) ? ' tag="'.$atts['tag'].'"' : '';
		$category = (!empty($atts['catgeory'])) ? ' category_name="'.$atts['catgeory'].'"' : '';
		
		$shortcode = '['.$prefix.$num.$only_current_user.$order.$tag.$category.']';
	}
	
	echo do_shortcode($shortcode); 
		
?>