<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $full_width
 * @var $full_height
 * @var $equal_height
 * @var $columns_placement
 * @var $content_placement
 * @var $parallax
 * @var $parallax_image
 * @var $css
 * @var $el_id
 * @var $video_bg
 * @var $video_bg_url
 * @var $video_bg_parallax
 * @var $parallax_speed_bg
 * @var $parallax_speed_video
 * @var $content - shortcode content
 *
 * KLEO ADDED
 * @var $front_status
 * @var $inner_container
 * @var $text_align
 * @var $section_type
 * @var $type
 * @var $text_color
 * @var $bg_image
 * @var $bg_position
 * @var $bg_position_horizontal
 * @var $bg_repeat
 * @var $bg_cover
 * @var $bg_attachment
 * @var $bg_video_src_mp4
 * @var $bg_video_src_ogv
 * @var $bg_video_src_webm
 * @var $bg_video_cover
 * @var $column_gap
 * @var $vertical_align
 * @var $padding_top
 * @var $padding_bottom
 * @var $padding_left
 * @var $padding_right
 * @var $margin_top
 * @var $margin_bottom
 * @var $border
 * @var $min_height
 * @var $fixed_height
 * @var $animation
 * @var $css_animation
 * @var $enable_parallax
 * @var $parallax_speed
 * @var $video_mute
 * @var $video_autoplay
 * @var $inline_style
 * @var $visibility
 * @var $overflow
 * END KLEO ADDED
 *
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Row
 */
$el_class = $full_height = $parallax_speed_bg = $parallax_speed_video = $full_width = $equal_height = $flex_row = $columns_placement = $content_placement = $parallax = $parallax_image = $css = $el_id = $video_bg = $video_bg_url = $video_bg_parallax = '';
$output = $after_output = '';

/* KLEO ADDED */
$front_status = $inner_container = $text_align = $section_type = $type = $text_color = $bg_image = $bg_gradient = $bg_color = $bg_position =
$bg_position_horizontal = $bg_repeat = $bg_cover = $bg_attachment = $bg_video_src_mp4 = $bg_video_src_ogv =
$bg_video_src_webm = $bg_video_cover = $column_gap = $vertical_align = $padding_top = $padding_bottom = $padding_left =
$padding_right = $margin_top = $margin_bottom = $border = $min_height = $fixed_height = $animation = $css_animation = $enable_parallax =
$parallax_speed = $video_mute = $video_autoplay = $inline_style = $visibility = $overflow = '';
/* END KLEO ADDED */

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wp_enqueue_script( 'wpb_composer_front_js' );

$el_class = $this->getExtraClass( $el_class );

$css_classes = array(
	'vc_row',
	//'wpb_row', //deprecated
	'vc_row-fluid',
	//$el_class,
	vc_shortcode_custom_css_class( $css ),
);

if (vc_shortcode_custom_css_has_property( $css, array('border', 'background') ) || $video_bg || $parallax) {
	$css_classes[]='vc_row-has-fill';
}

if (!empty($atts['gap'])) {
	$css_classes[] = 'vc_column-gap-'.$atts['gap'];
}

/* KLEO ADDED */
if ( $front_status == 'draft' ) {
  return false;
}

$bg_video = $video_output = '';
$my_style = $section_classes = array();

if ( $section_type == '' ) {
	$section_type = 'main';
}
$css_classes[] = 'row';

$section_classes[] = 'container-wrap';
$section_classes[] = $el_class;

if ($this->settings( 'base' ) !== 'vc_row_inner' ) {
	$section_classes[] =  $section_type . '-color';
}
$container_attributes = array();
/* END KLEO ADDED */

$wrapper_attributes = array();
// build attributes for wrapper
if ( ! empty( $el_id ) ) {
    $wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}
if ( ! empty( $full_width ) ) {
	$wrapper_attributes[] = 'data-vc-full-width="true"';
	$wrapper_attributes[] = 'data-vc-full-width-init="false"';
	if ( 'stretch_row_content' === $full_width ) {
		$wrapper_attributes[] = 'data-vc-stretch-content="true"';
	} elseif ( 'stretch_row_content_no_spaces' === $full_width ) {
		$wrapper_attributes[] = 'data-vc-stretch-content="true"';
		$css_classes[] = 'vc_row-no-padding';
	}
	$after_output .= '<div class="vc_row-full-width vc_clearfix"></div>';
}

if ( ! empty( $full_height ) ) {
	$css_classes[] = ' vc_row-o-full-height';
	if ( ! empty( $columns_placement ) ) {
		$flex_row = true;
		$css_classes[] = ' vc_row-o-columns-' . $columns_placement;
		if ( 'stretch' === $columns_placement ) {
			$css_classes[] = 'vc_row-o-equal-height';
		}
	}
}

if ( ! empty( $equal_height ) ) {
	$flex_row = true;
	$css_classes[] = ' vc_row-o-equal-height';
}

if ( ! empty( $content_placement ) ) {
	$flex_row = true;
	$css_classes[] = ' vc_row-o-content-' . $content_placement;
}

if ( ! empty( $flex_row ) ) {
	$css_classes[] = ' vc_row-flex';
}

$has_video_bg = ( ! empty( $video_bg ) && ! empty( $video_bg_url ) && vc_extract_youtube_id( $video_bg_url ) );

$vc_parallax_speed = $parallax_speed_bg;
if ( $has_video_bg ) {
	$parallax = $video_bg_parallax;
	$vc_parallax_speed = $parallax_speed_video;
	$parallax_image = $video_bg_url;
	$css_classes[] = ' vc_video-bg-container';
	wp_enqueue_script( 'vc_youtube_iframe_api_js' );
}

if ( ! empty( $parallax ) ) {
	wp_enqueue_script( 'vc_jquery_skrollr_js' );
	$wrapper_attributes[] = 'data-vc-parallax="' . esc_attr( $vc_parallax_speed ) . '"'; // parallax speed
	$css_classes[] = 'vc_general vc_parallax vc_parallax-' . $parallax;
	if ( false !== strpos( $parallax, 'fade' ) ) {
		$css_classes[] = 'js-vc_parallax-o-fade';
		$wrapper_attributes[] = 'data-vc-parallax-o-fade="on"';
	} elseif ( false !== strpos( $parallax, 'fixed' ) ) {
		$css_classes[] = 'js-vc_parallax-o-fixed';
	}
}

if ( ! empty ( $parallax_image ) ) {
    if ( $has_video_bg ) {
        $parallax_image_src = $parallax_image;
    } else {
        $parallax_image_id = preg_replace( '/[^\d]/', '', $parallax_image );
        $parallax_image_src = wp_get_attachment_image_src( $parallax_image_id, 'full' );
        if ( ! empty( $parallax_image_src[0] ) ) {
            $parallax_image_src = $parallax_image_src[0];
        }
    }
    $wrapper_attributes[] = 'data-vc-parallax-image="' . esc_attr( $parallax_image_src ) . '"';
}
if ( ! $parallax && $has_video_bg ) {
    $wrapper_attributes[] = 'data-vc-video-bg="' . esc_attr( $video_bg_url ) . '"';
}

/* KLEO ADDED */
switch ( $inner_container ) {
  case 'yes' :
    $container_start = '<div class="section-container container">';
    $container_end   = '</div>';
    break;
  default :
    $container_start = '<div class="section-container container-full">';
    $container_end   = '</div>';
}


if ( $text_color != '' ) {
	$my_style[] = 'color: '.$text_color;
	$section_classes[] = 'custom-color';
}


switch ( $type ) {
	case 'color':

		if ( $bg_color ) {
			$my_style[] = 'background-color: ' . $bg_color;

			$css_classes[]='vc_row-has-fill';
		}
		break;
		
	case 'image':

		$bg_cover = apply_filters( 'kleo_sanitize_flag', $bg_cover );
		$bg_attachment = in_array( $bg_attachment, array( 'false', 'fixed', 'true' ) ) ? $bg_attachment : 'false';

        if ( $bg_image && !in_array( $bg_image, array('none') ) ) {
            $bg_image_path = wp_get_attachment_image_src($bg_image, 'full');
            if ( $bg_image_path == NULL )  {
                $bg_image_path[0] = get_template_directory_uri() . "/assets/img/row_bg.jpg";
            } //' <small>'.__('This is image placeholder, edit your page to replace it.', 'js_composer').'</small>';

            $my_style[] = 'background-image: url(' . esc_url($bg_image_path[0]) . ')';
        }
		if ( $bg_color ) {
			$my_style[] = 'background-color: ' . $bg_color;
		}

		$position = array();
        if ( $bg_position != 'top' || $bg_position_horizontal != 'left' ) {
            $position[] = $bg_position_horizontal;
			$position[] = $bg_position;
		}

		if ( ! empty( $position ) ) {
			$my_style[] = 'background-position: ' . join(' ', $position);
		}

        if ($bg_repeat == '' ) {
            $bg_repeat = 'no-repeat';
        }
        $my_style[] = 'background-repeat: ' . $bg_repeat;

		if ( $enable_parallax != '' && $parallax_speed != '' ) {
			$parallax_speed = floatval( $parallax_speed );
			if ( false == $parallax_speed ) {
				$parallax_speed = 0.05;
			}

			$section_classes[] = 'bg-parallax';
			$container_attributes[] = 'data-prlx-speed="' . $parallax_speed . '"';

            $my_style[] = 'background-attachment: fixed';
            $my_style[] = 'background-size: cover';
		} else {

            if ( 'false' != $bg_attachment ) {
                $my_style[] = 'background-attachment: fixed';
            } else {
                $my_style[] = 'background-attachment: scroll';
            }

            if ( 'false' != $bg_cover ) {
                $my_style[] = 'background-size: cover';
            } else {
                $my_style[] = 'background-size: auto';
            }

        }

		$css_classes[]='vc_row-has-fill';
	
		break;
		
	case 'video':

		// video bg
		$bg_video_args = array();

		if ( $bg_video_src_mp4 ) {
			$bg_video_args['mp4'] = $bg_video_src_mp4;
		}

		if ( $bg_video_src_ogv ) {
			$bg_video_args['ogv'] = $bg_video_src_ogv;
		}

		if ( $bg_video_src_webm ) {
			$bg_video_args['webm'] = $bg_video_src_webm;
		}

		if ( !empty($bg_video_args) ) {
			$attr_strings = array(
				'loop',
				'preload="1"',
				'autoplay=""',
				'muted="muted"'
			);
			if ($video_mute) {
				//$attr_strings[] = 'muted="muted"';
			}
			if ($video_autoplay) {
				//$attr_strings[] = 'autoplay=""';
			}
			
			if ( $bg_video_cover && !in_array( $bg_video_cover, array('none') ) ) {
				$bg_video_path = wp_get_attachment_image_src($bg_video_cover, 'kleo-full-width');
				$attr_strings[] = 'poster="' . esc_url($bg_video_path[0]) . '"';
			}

			$bg_video .= sprintf( '<div class="video-wrap"><video %s class="full-video" webkit-playsinline>', join( ' ', $attr_strings ) );

			$source = '<source type="%s" src="%s" />';
			foreach ( $bg_video_args as $video_type=>$video_src ) {

				$video_type = wp_check_filetype( $video_src, wp_get_mime_types() );
				$bg_video .= sprintf( $source, $video_type['type'], esc_url( $video_src ) );

			}

			$bg_video .= '</video></div>';

			$section_classes[] = 'bg-full-video no-video-controls';

			$css_classes[]='vc_row-has-fill';
		}
		break;

	default:
		break;
}

if ( $column_gap == 'no' ) {
	$section_classes[] = 'no-col-gap';
}
if ( $vertical_align == 'yes' ) {
	$section_classes[] = 'vertical-col';
}

$style_elements = array( 'padding_top', 'padding_bottom', 'padding_left', 'padding_right', 'margin_top', 'margin_bottom' );

foreach ( $style_elements as $style_element ) {
	if ( $$style_element != '' ) {
		$my_style[] = str_replace( '_', '-', $style_element ) . ':' . kleo_set_default_unit( $$style_element );
	}
}

if ( $fixed_height != '' && $fixed_height != 0 ) {
	$my_style[] = 'height: ' . kleo_set_default_unit( $fixed_height );
}
if ( $min_height != '' && $min_height != 0 ) {
	$my_style[] = 'min-height: ' . kleo_set_default_unit( $min_height );
}

switch ( $border ) {
	case 'top' :
		$border = ' border-top';
		break;
	case 'left' :
		$border = ' border-left';
		break;
	case 'right' :
		$border = ' border-right';
		break;
	case 'bottom' :
		$border = ' border-bottom';
		break;
	case 'horizontal' :
		$border = ' border-top border-bottom';
		break;
	case 'vertical' :
		$border = ' border-left border-right';
		break;
	case 'all' :
		$border = ' border-top border-left border-right border-bottom';
		break;
	default :
		$border = '';
}
$section_classes[] = $border;

if ( $overflow ) {
	$section_classes[] = 'ov-hidden';
}

$video_output .= $bg_video;

if ( $animation != '' ) {
	wp_enqueue_script( 'waypoints' );
	$section_classes[] = "animated {$animation} {$css_animation}";
}

if( $text_align != '' ) {
	$section_classes[] = 'text-'.$text_align;
}

if ( $visibility != '' ) {
	$section_classes[] = str_replace(',', ' ', $visibility);
}

if ( $inline_style ) {
	$my_style[] = $inline_style;
}
if ( ! empty( $my_style ) ) {
	$my_style = implode( ';', $my_style );
	$my_style = wp_kses( $my_style, array() );
	$my_style = ' style="' . esc_attr( $my_style ) . '"';
	//$wrapper_attributes[] = $my_style;
} else {
	$my_style = '';
}
/* END KLEO ADDED */

$css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $css_classes ) ), $this->settings['base'], $atts ) );
$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

$output .= '<section class="' . implode( ' ', $section_classes )  . '" ' . $my_style . ' ' . implode( ' ', $container_attributes ) . '>';

$output .= $container_start;
$output .= '<div ' . implode( ' ', $wrapper_attributes ) . '>';
$output .= wpb_js_remove_wpautop( $content );
$output .= '</div>';
$output .= $container_end;
$output .= $video_output;
$output .= '</section><!-- end section -->';
$output .= $after_output;

echo $output;