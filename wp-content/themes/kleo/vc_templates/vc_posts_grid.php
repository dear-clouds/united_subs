<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $grid_columns_count
 * @var $grid_teasers_count
 * @var $grid_layout
 * @var $grid_link_target
 * @var $filter
 * @var $grid_thumb_size
 * @var $grid_layout_mode
 * @var $el_class
 * @var $loop
 * @var $content - shortcode content
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Posts_Grid
 */
$title = $grid_columns_count = $grid_teasers_count = $grid_layout =
$grid_link_target = $filter = $grid_thumb_size = $grid_layout_mode = $el_class = $loop = '';


/* KLEO Added */
global $kleo_config;
$post_layout = $query_offset = $show_thumb = $inline_meta = $show_footer = '';
/* END KLEO Added */


global $vc_teaser_box;
$grid_link = '';
$posts = array();
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

if( empty( $loop ) ) return;
$this->getLoop( $loop );
$my_query = $this->query;
$args = $this->loop_args;

if ( (int)$query_offset > 0 ) {
    $args['offset'] = $query_offset;
}

$el_class = $el_class != "" ? " ".$el_class : "";

// Alias for Grid to Masonry
if ( $post_layout == 'grid' ) {
    $post_layout = 'masonry';
}
$post_layout = apply_filters( 'kleo_blog_type', $post_layout, get_the_ID() );

if ( $post_layout == 'standard' && 0 === strpos( $show_thumb, 'just_' ) ) {
    global $conditional_thumb;
    $conditional_thumb = substr( $show_thumb, -1 );
    $el_class .= ' just-thumb-' . $conditional_thumb;
} elseif ( $show_thumb == 'no' ) {
    global $conditional_thumb;
    $conditional_thumb = 0;
}

if ( $show_meta == 'yes' ) {
    $el_class .= ' with-meta';
} else {
    $el_class .= ' no-meta';
}

if ( $show_footer == 'no' ) {
    $el_class .= ' no-footer';  
}

if ( $show_excerpt == 'no' ) {
    $el_class .= ' no-excerpt';
}

if ( $inline_meta == 'yes' ) {
    $el_class .= ' inline-meta';
}

$el_class .= " " . $post_layout . '-listing';

	query_posts( $args );

	if ( have_posts() ) : ?>

        <?php if ( $show_switcher  == 'yes' && ! empty( $switcher_layouts ) ) : ?>

            <?php
            if( ! is_array( $switcher_layouts ) ) {
                $switcher_layouts = explode( ',' , $switcher_layouts );
            }
            kleo_view_switch( $switcher_layouts, $post_layout, get_the_ID() );
            ?>

        <?php endif; ?>

        <?php if ( $post_layout == 'masonry' ) : ?>

            <div class="posts-listing responsive-cols kleo-masonry per-row-<?php echo $columns;?><?php echo $el_class;?>">

        <?php else: ?>

            <div class="posts-listing <?php echo $el_class;?>">

        <?php endif; ?>


        <?php
        while ( have_posts() ) : the_post();

            if ( $post_layout != 'standard' ) {
                get_template_part( 'page-parts/post-content-' . $post_layout );
            } else {
                get_template_part( 'content', get_post_format() );
            }

        endwhile;
        ?>

        </div> <!-- END post listing -->

<?php
endif;
// Reset Query
wp_reset_query();