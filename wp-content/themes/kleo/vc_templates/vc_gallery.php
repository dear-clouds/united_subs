<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $source
 * @var $type
 * @var $onclick
 * @var $custom_links
 * @var $custom_links_target
 * @var $img_size
 * @var $external_img_size
 * @var $images
 * @var $custom_srcs
 * @var $el_class
 * @var $interval
 * @var $css
 *
 * KLEO ADDED
 * @var $grid_number
 * @var $gap
 *
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_gallery
 */

$attributes = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $attributes );

$default_src = vc_asset_url( 'vc/no_image.png' );

/* backward compatibility */
if ( empty( $source ) ) {
    $source = 'media_library';
}
if ( empty( $css ) ) {
    $css = '';
}

$gal_images = $gal_images_thumb = '';
$el_start = '';
$el_end = '';
$slides_wrap_start = '';
$slides_wrap_end = '';

$el_class = $this->getExtraClass($el_class);
if ( $type == 'thumbs' ) {
    $slides_wrap_start = '<div class="kleo-gallery-image">';
    $slides_wrap_end = '</div>';
} else if ( $type == 'grid' ) {
    wp_enqueue_script( 'isotope' );
    $slides_wrap_start = '<ul class="responsive-cols per-row-'. $grid_number .' kleo-masonry animate-when-almost-visible one-by-one-general">';
    $slides_wrap_end = '</ul>';
}

//get images
if ( $images == '' ) $images = '-1,-2,-3';

$pretty_rel_random = ' rel="prettyPhoto[rel-'.rand().']"'; //rel-'.rand();

if ( $onclick == 'custom_link' ) {
    $custom_links = explode( ',', $custom_links);
}

switch ( $source ) {
    case 'media_library':
        $images = explode( ',', $images );
        break;

    case 'external_link':
        $images = explode( ',', $custom_srcs );
        break;
}

if ( $type == 'thumbs' ) {
    $gal_images_thumb .= '<div class="kleo-gallery kleo-carousel-container animate-when-almost-visible">'
        . '<div class="kleo-thumbs-carousel kleo-thumbs-animated th-fade" data-min-items=6 data-max-items=6>';
}

$elem_id = kleo_vc_elem_increment();
$i = -1;
foreach ( $images as $attach_id ) {
    $i++;

    switch ( $source ) {
        case 'media_library':
            $post_thumbnail = array();
            $post_thumbnail['thumbnail'] = '<img src="' . vc_asset_url( 'vc/no_image.png' ) . '" />';
            $post_thumbnail['p_img_large'][0] = vc_asset_url( 'vc/no_image.png' );

            if ( $attach_id > 0 ) {
                $img_path = wp_get_attachment_image_src($attach_id, 'full');
                if ( $img_path != NULL ) {
                    $post_thumbnail = wpb_getImageBySize(array('attach_id' => $attach_id, 'thumb_size' => $img_size));
                }
            }
            $thumbnail = $post_thumbnail['thumbnail'];
            $p_img_large = $post_thumbnail['p_img_large'][0];

            break;

        case 'external_link':
            $attach_id = esc_attr( $attach_id );
            $dimensions = vcExtractDimensions( $external_img_size );
            $hwstring = $dimensions ? image_hwstring( $dimensions[0], $dimensions[1] ) : '';
            $thumbnail = '<img ' . $hwstring . ' src="' . $attach_id . '" />';
            $p_img_large = $attach_id;
            break;
    }

    $link_start = $link_end = '';

    if ( $type == 'thumbs' ) {
        $link_start .= '<div id="gall_' . $elem_id . '_' . $i . '">';
    } elseif ( $type == 'grid' ) {
        $link_start .= '<li class="el-zero-fade"><div class="kleo-gallery-inner">';
    }

    switch ( $onclick ) {
        case 'img_link_large':
            $link_start .= '<a href="' . $p_img_large . '" target="' . $custom_links_target . '">';
            if ( $type == 'grid' ) {
                $link_start .= kleo_get_img_overlay();
            }
            $link_end .= '</a>';
            break;

        case 'link_image':
            $link_start .= '<a class="prettyphoto" href="' . $p_img_large . '"' . $pretty_rel_random . '>';
            $link_end .= '</a>';
            break;

        case 'custom_link':
            if ( ! empty( $custom_links[ $i ] ) ) {
                $link_start .= '<a href="' . $custom_links[ $i ] . '"' . ( ! empty( $custom_links_target ) ? ' target="' . $custom_links_target . '"' : '' ) . '>';
                if ( $type == 'grid' ) {
                    $link_start .= kleo_get_img_overlay();
                }
                $link_end .= '</a>';
            }
            break;
    }

    if ( $type == 'thumbs' ) {
        $link_end .= '</div>';

        $gal_images .= $link_start . '<img src="' . $p_img_large . '">' . $link_end;
        $gal_images_thumb .= '<a href="#gall_' . $elem_id . '_' . $i . '">' . $thumbnail . kleo_get_img_overlay() . '</a>';
    } elseif ( $type == 'grid' ) {
        $link_end .= '</div></li>';

        $gal_images .= $link_start . $thumbnail . $link_end;
    }

}

if ( $type == 'thumbs' ) {
    $gal_images_thumb .= '</div>
        <a class="kleo-thumbs-prev" href="#"><i class="icon-angle-left"></i></a>
        <a class="kleo-thumbs-next" href="#"><i class="icon-angle-right"></i></a>
    </div>';
}

$class_to_filter = 'wpb_gallery wpb_content_element vc_clearfix';
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

$output .= "\n\t".'<div class="' . $css_class . '">';
$output .= "\n\t\t".'<div class="wpb_wrapper">';
$output .= wpb_widget_title(array('title' => $title, 'extraclass' => 'wpb_gallery_heading'));

$gap = $gap != '' ? ' kleo-' . $gap . '-gap' : '';

$output .= '<div class="kleo-gallery-container kleo-gallery-' . $type . $gap . '">' . $slides_wrap_start . $gal_images . $slides_wrap_end . $gal_images_thumb . '</div>';
$output .= "\n\t\t".'</div> ';
$output .= "\n\t".'</div> ';

echo $output;