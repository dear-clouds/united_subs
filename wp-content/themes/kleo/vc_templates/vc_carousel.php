<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $posts_query
 * @var $mode
 * @var $speed
 * @var $slides_per_view
 * @var $wrap
 * @var $autoplay
 * @var $hide_pagination_control
 * @var $hide_prev_next_buttons
 * @var $layout
 * @var $link_target
 * @var $thumb_size
 * @var $partial_view
 * @var $title
 * Shortcode class
 * @var $this WPBakeryShortCode_Vc_Carousel
 */
$el_class = $posts_query = $mode = $speed = $slides_per_view =
$wrap = $autoplay = $hide_pagination_control = $hide_prev_next_buttons =
$layout = $link_target = $thumb_size = $partial_view = $title = '';

/* KLEO Added */
$query_offset = $layout = $min_items = $max_items = $height = '';
/* END Kleo Added */

global $vc_teaser_box;

$args = $my_query = '';
$posts = array();
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

/* KLEO Added */
if ( $min_items == '') {
	$min_items = '3';
}
if ( $max_items == '') {
	$max_items = '6';
}
/* END Kleo Added */

global $vc_posts_grid_exclude_id;
$vc_posts_grid_exclude_id[] = get_the_ID(); // fix recursive nesting
if ( is_array( $posts_query ) ) {
	$posts_query['post_status'] = 'publish';
} else {
	$posts_query .= '|post_status:publish';
}
list( $args, $my_query ) = vc_build_loop_query( $posts_query, get_the_ID() );
if ( (int)$query_offset > 0 ) {
	$args['offset'] = $query_offset;
}


$extra_data = '';

if ( $autoplay == 'yes' ) {
  $extra_data .= ' data-autoplay="true"';
}

if ( $speed ) {
  $extra_data .= ' data-speed="' . $speed . '"';
}

if ( $height != '' ) {
	$extra_data .= ' data-items-height="' . $height . '"';
}

if ( $layout != 'default' ) {
    $el_class .= ' kleo-carousel-style-' . $layout;
}

query_posts($args);

if ( have_posts() ) : ?>

	<div class="kleo-carousel-container <?php echo $el_class;?>">
		<div class="kleo-carousel-items kleo-carousel-post" data-min-items="<?php echo $min_items; ?>" data-max-items="<?php echo $max_items;?>"<?php echo $extra_data;?>>
			<ul class="kleo-carousel">

				<?php
				while ( have_posts() ) : the_post();

					get_template_part('page-parts/post-content-carousel');

				endwhile;
				?>

			</ul>
		</div>
		<div class="carousel-arrow">
			<a class="carousel-prev" href="#"><i class="icon-angle-left"></i></a>
			<a class="carousel-next" href="#"><i class="icon-angle-right"></i></a>
		</div> 
		<div class="kleo-carousel-post-pager carousel-pager"></div>
	</div><!--end carousel-container-->

<?php
endif;

// Reset Query
wp_reset_query();