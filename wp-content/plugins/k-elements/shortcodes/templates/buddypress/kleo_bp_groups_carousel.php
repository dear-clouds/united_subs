<?php
/**
 * Buddypress Groups carousel.
 * 
 * 
 * @package WordPress
 * @subpackage K Elements
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since K Elements 1.0
 */


$output = '';

extract(
	shortcode_atts( array(
		'type' => 'newest',
		'number' => 10,
		'min_items' => 1,
		'max_items' => 6,
		'item_width' => 150,
		'image_size' => 'full',
		'class' => '',
		'rounded' => "rounded",
		'autoplay' => ''
	), $atts )
);

$params = array(
	'type' => $type,
	'per_page' => $number
);
if ($rounded == 'rounded') {
	$rounded = 'kleo-rounded';
}

$data_attr = '';
if ($autoplay != '') {
    $data_attr .= ' data-autoplay="' . $autoplay . '"';
}

if ( function_exists('bp_is_active') && bp_is_active('groups') ) {

	if ( bp_has_groups( $params ) ){
			$output = '<div class="wpb_wrapper">';
			$output .='<div class="kleo-carousel-container bp-groups-carousel '.$class.'">';
			$output .='<div class="kleo-carousel-items kleo-groups-carousel" data-min-items="'.$min_items.'" data-max-items="'.$max_items.'"' . $data_attr . '>';
			$output .= '<ul class="kleo-carousel">';
				while( bp_groups() ){
					$output .= '<li><article>';
					$output .='<div class="loop-image">';
						bp_the_group();
						$output .='<div class="item-avatar '.$rounded.'">';
							$output .= '<a href="'. bp_get_group_permalink() .'" title="'. esc_attr( bp_get_group_name()) .'">';
								$output .= bp_get_group_avatar( array(	'type' => $image_size, 'width' => $item_width, 'height' => $item_width ));
								$output .= kleo_get_img_overlay();
							$output .= '</a>';	
						$output .= '</div>';
						$output .= '</div>';
					$output .= '</article></li>';
				}
			$output .= '</ul>';	
			$output .= '</div>';
			$output .= '<div class="carousel-arrow">'
						.'<a class="carousel-prev" href="#"><i class="icon-angle-left"></i></a>'
						.'<a class="carousel-next" href="#"><i class="icon-angle-right"></i></a></div>';
			$output .='</div>';
			$output .='</div>';
	}
	else
	{
		$output .= '<div class="alert alert-info">' . __( 'There are no groups to display. Please try again soon.', 'k-elements' ) . '</div>';
	}

}
else
{
	$output = __("This shortcode must have Buddypress installed to work.","k-elements");
}

