<?php
/**
 * The Template for displaying portfolio single items
 *
 * @package WordPress
 * @subpackage Kleo
 * @since Kleo 1.6.4
 */

get_header(); ?>

<?php
if (! get_cfield('post_layout') || get_cfield('post_layout') == 'default') {
    kleo_switch_layout( 'no', 14 );
} ?>

<?php get_template_part( 'page-parts/general-title-section' ); ?>

<?php get_template_part( 'page-parts/general-before-wrap' );?>

<?php /* Start the Loop */ ?>
<?php while ( have_posts() ) : the_post(); ?>

    <?php
    global $kleo_config;
    $kleo_post_format = get_cfield( 'media_type' ) ? get_cfield( 'media_type' ) : 'thumb';

    $media_status = sq_option('portfolio_media_status', 1);
    $single_status = get_cfield('portfolio_media_status');

    if( $single_status != '' ) {
        $media_status = $single_status;
    }

    if ( $media_status ) {

        switch ($kleo_post_format) {

            case 'hosted_video':
                // video bg self hosted
                $bg_video_args = array();
                $k_video = '';

                if (get_cfield( 'video_mp4' ) ) {
                    $bg_video_args['mp4'] = get_cfield( 'video_mp4' );
                }
                if (get_cfield( 'video_ogv' ) ) {
                    $bg_video_args['ogv'] = get_cfield( 'video_ogv' );
                }
                if (get_cfield( 'video_webm' ) ) {
                    $bg_video_args['webm'] = get_cfield( 'video_webm' );
                }

                if ( !empty( $bg_video_args ) ) {
                    $attr_strings = array(
                        'preload="0"'
                    );

                    if (get_cfield( 'video_poster' ) ) {
                        $attr_strings[] = 'poster="' . get_cfield( 'video_poster' ) . '"';
                    }

                    $k_video .= '<div class="kleo-video-wrap"><video ' . join( ' ', $attr_strings ) . ' controls="controls" class="kleo-video" style="height: 100%; width: 100%;">';

                    $source = '<source type="%s" src="%s" />';
                    foreach ( $bg_video_args as $video_type => $video_src ) {
                        $video_type = wp_check_filetype( $video_src, wp_get_mime_types() );
                        $k_video .= sprintf( $source, $video_type['type'], esc_url( $video_src ) );
                    }

                    $k_video .= '</video></div>';

                    echo $k_video;
                }
                break;

            case 'video':

                //oEmbed video
                $video = get_cfield( 'embed' );

                if ( !empty( $video ) ) {
                    global $wp_embed;
                    echo '<div class="kleo-video-embed">';
                    echo apply_filters( 'kleo_oembed_video', $video );
                    echo '</div>';
                }

                break;

            case 'slider':

                $slides = get_cfield('slider');
                echo '<div class="kleo-banner-slider">'
                    .'<div class="kleo-banner-items" >';
                if ( $slides ) {
                    foreach( $slides as $slide ) {
                        if ( $slide ) {

                            $image = aq_resize( $slide, $kleo_config['post_single_img_width'], null, true, true, true );
                            //small hack for non-hosted images
                            if (! $image ) {
                                $image = $slide;
                            }
                            echo '<article>'
                                . '<a href="'. $slide .'" data-rel="modalPhoto[inner-gallery]">'
                                    . ' <img src="'.$image.'" alt="">'
                                    . kleo_get_img_overlay()
                                . '</a>
                                </article>';
                        }
                    }
                }

                echo '</div>'
                    . '<a href="#" class="kleo-banner-prev"><i class="icon-angle-left"></i></a>'
                    . '<a href="#" class="kleo-banner-next"><i class="icon-angle-right"></i></a>'
                    . '<div class="kleo-banner-features-pager carousel-pager"></div>'
                    .'</div>';

                break;

            default:
                if ( kleo_get_post_thumbnail_url() != '' ) {
                    echo '<div class="portfolio-image">';

                    $img_url = kleo_get_post_thumbnail_url();
                    $image = aq_resize( $img_url, $kleo_config['post_single_img_width'], null, true, true, true );
                    if( ! $image ) {
                        $image = $img_url;
                    }
                    echo '<img src="' . $image . '">';

                    echo '</div><!--end post-image-->';
                }

                break;
        }
    }
    ?>

    <?php the_content();?>

    <?php get_template_part( 'page-parts/posts-social-share' ); ?>

    <?php
    if ( sq_option( 'portfolio_navigation', 1 ) == 1 ) :
        // Previous/next post navigation.
        kleo_post_nav();
    endif;
    ?>

    <?php if ( sq_option( 'portfolio_comments', 0 ) == 1 ) : ?>

        <!-- Begin Comments -->
        <?php comments_template( '', true ); ?>
        <!-- End Comments -->

    <?php endif; ?>


<?php endwhile; ?>

<?php get_template_part('page-parts/general-after-wrap');?>

<?php if ( sq_option( 'portfolio_back_to', 1) == 1 ) : ?>

    <section class="footer-color text-center portfolio-back"><a title="<?php printf( __("Back to %s", "kleo_framework" ), sq_option( 'portfolio_name', 'Portfolio' ) );?>" href="<?php echo get_archive_link( 'portfolio' );?>"><i class="icon-th icon-2x"></i></a></section>

<?php endif; ?>

<?php get_footer(); ?>