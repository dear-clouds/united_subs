<?php
/**
 * Testimonials Shortcode
 * [kleo_testimonials number=3 offset=0 type="simple"]
 * 
 * @package WordPress
 * @subpackage K Elements
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since K Elements 1.2
 */


$output = '';
extract(shortcode_atts(array(
	'type' => 'simple',
	'specific_id' => 'no',
	'ids' => '',
	'number' => '3',
	'offset' => '',
	'tags' => '',
	'el_class' => '',
	'min_items' => '1',
	'max_items' => '1',
	'speed' => '5000',
	'height' => ''
), $atts));


$class = ' kleo-testimonials';
$class .= $el_class != '' ? ' ' . $el_class : '';

$args = array(
	'post_type' => 'kleo-testimonials'
);

if ( $specific_id == 'yes' ) {
	$args['post__in'] = explode(',',$ids);
} else {
	$args['posts_per_page'] = $number;
	if ($offset != '') {
		$args['offset'] = (int)$offset;
	}
	if ( $tags != '' && $tags != 'all' ) {
		$terms = explode( ',', $tags );
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'testimonials-tag',
				'terms'    => $terms,
			),
		);
	}
}

query_posts( $args );

if ( have_posts() ) {

    $output .= '<div class="wpb_wrapper">';
	
	switch ( $type ) {
	
		//Carousel Testimonials display
		case 'carousel':
			
			ob_start();
			
			$data_attr = '';
			$data_attr .= ' data-min-items="' . $min_items . '"';
			$data_attr .= ' data-max-items="' . $max_items . '"';
			$data_attr .= ' data-speed="' . $speed . '"';
      
            if ( $height != '' ) {
                $data_attr .= ' data-items-height="' . $height . '"';
            } else {
                $data_attr .= ' data-items-height="variable"';
            }

			$output .= '<div class="kleo-carousel-container' . $class . '">';
			$output .= '<div class="kleo-carousel-items kleo-carousel-testimonials" data-scroll-fx="crossfade" data-autoplay="true"' . $data_attr . '>';
			$output .= '<ul class="kleo-carousel">';
			
			while (have_posts()) : the_post(); ?>	

				<li class="">
					<div class="testimonial-image">
						<?php 
						if ( $thumb = get_post_thumbnail_id() ) {
							$img_url = wp_get_attachment_url( $thumb, 'full' );
							$image = aq_resize( $img_url, 65, 65, true, true, true );
							if( $image ) {
								echo '<img src="'.$image.'" alt="">';
							}
						}
						?>
					</div>
					<div class="testimonial-content">
						<?php the_content();?>
					</div>
					<div class="testimonial-meta">
						<strong class="testimonial-name"><?php the_title();?></strong>
						<span class="testimonial-subtitle"><?php the_cfield('author_description');?></span>
					</div>
				</li>
		
			<?php
			endwhile; 
			$output .= ob_get_clean();

			$output .= '</ul><!-- end kleo-carousel -->';
			$output .= '</div><!-- end kleo-carousel-items -->';
			$output .= '<div class="kleo-carousel-pager carousel-pager"></div>';
			$output .= '</div><!-- end kleo-testimonials carousel-container -->';


			break;

		//Regular Testimonials display
		default:
			
			ob_start();
			$output .= '<div class="'.$class.'">';
			while (have_posts()) :  the_post(); ?>

				<figure class="callout-blockquote light">
					<blockquote>
						<?php the_content();?>
					</blockquote>
					<figcaption> <span class="title-name"><?php the_title();?></span><br>
						<span><?php the_cfield('author_description');?></span><br>
					</figcaption>
				</figure>

		<?php 
			endwhile; 
			$output .= ob_get_clean();

			$output .= '</div><!-- end kleo-testimonials -->';
			
			break;
	}

    $output .= '</div>';
}
wp_reset_query();