<?php
/**
 * NEWS Highlight Shortcode
 * [kleo_news_highlight]
 * 
 * @package WordPress
 * @subpackage K Elements
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since K Elements 3.0
 */

if ( ! function_exists( 'vc_build_loop_query' )) {
    $output = 'Visual composer must be installed';
}

$output = $args = $my_query = $output_inside = '';
extract( shortcode_atts( array(
    'featured' => 1,
    'posts_query' => '',
    'query_offset' => '0',
    'el_class' => '',
), $atts ) );


if ( $featured < 1 ) {
    $featured = 1;
}

$el_class = ( $el_class != '' ) ? 'news-highlight ' . esc_attr( $el_class ) : 'news-highlight';

list( $args, $my_query ) = vc_build_loop_query( $posts_query );

if ( (int)$query_offset > 0 ) {
    $args['offset'] = $query_offset;
}

if ( isset( $args['cat'] ) ) {
    $cats = explode(',', $args['cat']);
    $category = '<span class="label">' . get_cat_name( $cats[0] ) . '</span>';
} else {
    $category = '';
}

query_posts( $args );
if ( have_posts() ) :
    $count = 0;

    global $wp_query;
    if ( isset( $wp_query->post_count ) && $wp_query->post_count > 0 && $featured > $wp_query->post_count ) {
        $featured = $wp_query->post_count;
    }

    $output_inside .= '<div class="posts-listing standard-listing with-meta inline-meta">';

    while ( have_posts() ) : the_post();

        $count++;

        $kleo_post_format = get_post_format();

        //Featured post
        if ( $count <= $featured ) {

            ob_start();
            ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <div class="post-content animated animate-when-almost-visible el-appear">

                    <div class="article-media clearfix">
                        <?php if ( ( $kleo_post_format == 'image' || $kleo_post_format == 'gallery' || ( $kleo_post_format === false && has_post_thumbnail() ) ) && $count == 1 ) {
                            echo $category;
                        } ?>
                        <?php echo kleo_get_post_media( $kleo_post_format ); ?>
                    </div>

                    <h3 class="post-title entry-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>

                    <div class="article-meta">
                        <span class="post-meta">
                            <?php kleo_entry_meta();?>
                        </span>
                    </div>

                    <div class="entry-summary">
                        <?php if ( ! in_array( $kleo_post_format, array('status', 'quote', 'link') ) ): ?>
                            <?php echo kleo_excerpt(); ?>
                        <?php else : ?>
                            <?php the_content();?>
                        <?php endif;?>
                    </div><!-- .entry-summary -->

                </div>
            </article>

            <?php if ( $count == $featured ) : ?>

            </div> <!-- .posts-listing -->
            <div class="posts-listing left-thumb-listing">

            <?php endif; ?>

            <?php
            $output_inside .= ob_get_clean();

        } else {
            ob_start();
            ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <div class="post-content animated animate-when-almost-visible el-appear">

                    <div class="article-media">
                        <?php echo kleo_get_post_media( $kleo_post_format, array( 'media_width' => 220, 'media_height' => 192 ) ); ?>
                    </div>

                    <div class="post-date"><?php the_date();?></div>

                    <h3 class="post-title entry-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>

                </div>
            </article>

            <?php
            $output_inside .= ob_get_clean();
        }

    endwhile;

    $output_inside .= '</div><!-- .posts-listing -->';


endif;

// Reset Query
wp_reset_query();

$output .= "\n\t"."<div class=\"{$el_class}\">{$output_inside}</div>";