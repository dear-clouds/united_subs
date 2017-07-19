<?php
/**
 * NEWS Focus Shortcode
 * [kleo_news_focus name="Section name"]
 * 
 * @package WordPress
 * @subpackage K Elements
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since K Elements 3.0
 */

if ( ! function_exists( 'vc_build_loop_query' )) {
    $output = 'Visual composer must be installed';
}

$output = $args = $my_query = $output_inside = $tabs_data = '';
extract( shortcode_atts( array(
    'name' => '',
    'featured' => 1,
    'posts_query' => '',
    'query_offset' => '0',
    'el_class' => '',
), $atts ) );

if ( $featured < 1 ) {
    $featured = 1;
}

$el_class = ( $el_class != '' ) ? 'news-focus ' . esc_attr( $el_class ) : 'news-focus';

list( $args, $my_query ) = vc_build_loop_query( $posts_query );

if ( (int)$query_offset > 0 ) {
    $args['offset'] = $query_offset;
}

$main_args = $args;

$tabs_data = '[vc_tabs type="tabs" style="line" style_pills="square"]';

if ( isset( $main_args['cat'] ) ) {
    $cats = explode(',', $main_args['cat']);
    //add the section name to generate the first tab
    array_unshift( $cats, $name );
} else {
    //add the section name to generate the first tab
    $cats = array( $name );
}

    $cat_count = 0;

    foreach( $cats as $cat ) {

        $cat_count++;

        if ( $cat_count == 1 ) {
            $cat_name = $cat;
        } else {
            $args['cat'] = $cat;
            $cat_name = get_cat_name( $cat );
        }

        query_posts( $args );

        if ( have_posts() ) :

            global $wp_query;
            if ( isset( $wp_query->post_count ) && $wp_query->post_count > 0 && $featured > $wp_query->post_count ) {
                $featured = $wp_query->post_count;
            }

            $count = 0;
            $tabs_data .= '[vc_tab title="' . $cat_name . '"]';

            $tabs_data .= '<div class="row">';
            $tabs_data .= '<div class="col-sm-6">';
            $tabs_data .= '<div class="posts-listing standard-listing with-meta inline-meta">';

            while ( have_posts() ) : the_post();

                $count++;

                $kleo_post_format = get_post_format();

                //Left side thumb
                if ( $count <= $featured ) {

                    ob_start();
                    ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <div class="post-content animated animate-when-almost-visible el-appear">

                            <div class="article-media clearfix">
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
                    </div> <!-- .col-sm-6 -->

                    <div class="col-sm-6">
                        <div class="posts-listing left-thumb-listing">

                    <?php endif; ?>

                    <?php
                    $tabs_data .= ob_get_clean();

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
                    $tabs_data .= ob_get_clean();
                }

            endwhile;

            $tabs_data .= '</div>';
            $tabs_data .= '</div>';
            $tabs_data .= '</div>';

            $tabs_data .= '[/vc_tab]';

        endif;

        // Reset Query
        wp_reset_query();

    }


$tabs_data .= '[/vc_tabs]';

$output_inside .= do_shortcode( $tabs_data );

$output .= "\n\t"."<div class=\"{$el_class}\">{$output_inside}</div>";