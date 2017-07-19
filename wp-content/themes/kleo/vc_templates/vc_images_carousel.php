<?php
$output = $title =  $onclick = $custom_links = $img_size = $custom_links_target = $images = $el_class = $partial_view = '';
$mode = $slides_per_view = $wrap = $autoplay = $hide_pagination_control = $hide_prev_next_buttons = $speed ='';
extract(shortcode_atts(array(
    'onclick' => 'link_image',
    'custom_links' => '',
    'custom_links_target' => '',
    'img_size' => 'thumbnail',
    'images' => '',
    'el_class' => '',
    'min_items' => '1',
    'max_items' => '1',
	'items_width' => '',
    'autoplay' => '',
    'hide_pagination_control' => '',
    'hide_prev_next_buttons' => '',
    'animation' => '',
    'css_animation' => 'right-to-left',
    'speed' => '5000',
    'scroll_fx' => 'scroll',
	'css' => ''
), $atts));

$data_attr = '';

$el_class = $this->getExtraClass($el_class);

if ( $images == '' ) $images = '-1,-2,-3';

if ( 'custom_link' === $onclick ) {
	$custom_links = vc_value_from_safe( $custom_links );
	$custom_links = explode( ',', $custom_links );
}

$images = explode( ',', $images);
$i = -1;

$class_to_filter = 'kleo-gallery kleo-carousel-container dot-carousel';
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

$el_animation = '';
if ( $animation != '' ) {
	wp_enqueue_script( 'waypoints' );
	$css_class .= " {$animation}";
	$el_animation = " kleo-thumbs-animated th-{$css_animation}";
}

if ($max_items == '1') {
	$css_class .= " kleo-single-image";
}

if($hide_pagination_control != 'yes') {
	$data_attr .= ' data-pager=".kleo-carousel-features-pager"';
}
$data_attr .= ' data-min-items="' . $min_items . '"';
$data_attr .= ' data-max-items="' . $max_items . '"';
$data_attr .= ' data-autoplay="' . $autoplay . '"';
$data_attr .= ' data-speed="' . $speed . '"';
$data_attr .= ' data-scroll-fx="' . $scroll_fx . '"';
$data_attr .= ' data-items-height="variable"';
if ( $items_width != '' ) {
	$data_attr .= ' data-items-width="' . (int)$items_width . '"';
}

?>

<div class="<?php echo $css_class; ?>">
	<div class="kleo-carousel-items<?php echo $el_animation;?>" <?php echo trim($data_attr);?>>
		<div class="kleo-carousel">
				<?php 
				if(is_array($images)) :
					foreach($images as $attach_id):
					    $i++;
                        $img_path = wp_get_attachment_image_src($attach_id, 'full');
                        if ( $attach_id > 0 && $img_path != NULL ) {
                            $post_thumbnail = wpb_getImageBySize( array( 'attach_id' => $attach_id, 'thumb_size' => $img_size ) );
                            if ( $post_thumbnail == NULL || (isset( $post_thumbnail['p_img_large'] ) && $post_thumbnail['p_img_large'] == FALSE  ) ) {
                                $post_thumbnail = array();
                                $post_thumbnail['thumbnail'] = '<img src="' . vc_asset_url( 'vc/no_image.png' ) . '" />';
                                $post_thumbnail['p_img_large'][0] = vc_asset_url( 'vc/no_image.png' );
                            }
                        } else {
                            $post_thumbnail = array();
                            $post_thumbnail['thumbnail'] = '<img src="' . vc_asset_url( 'vc/no_image.png' ) . '" />';
                            $post_thumbnail['p_img_large'][0] = vc_asset_url( 'vc/no_image.png' );
                        }
						$thumbnail = $post_thumbnail['thumbnail'];
						$p_img_large = $post_thumbnail['p_img_large'];
						?>

						<?php if ($onclick == 'link_image'): ?>
								<a href="<?php echo $p_img_large[0] ?>" <?php echo ' rel="modalPhoto[rel-'.rand().']"' ?>>
										<?php echo $thumbnail; if ($max_items != '1') { echo kleo_get_img_overlay(); } ?>
								</a>
						<?php elseif($onclick == 'custom_link' && isset( $custom_links[$i] ) && $custom_links[$i] != ''): ?>
								<a href="<?php echo $custom_links[$i] ?>"<?php echo (!empty($custom_links_target) ? ' target="'.$custom_links_target.'"' : '') ?>>
										<?php echo $thumbnail; if ($max_items != '1') { echo kleo_get_img_overlay(); } ?>
								</a>
						<?php else:
								echo '<a class="kleo-gallery-img">' . $thumbnail . '</a>';
						endif; ?>

					<?php
					endforeach;
				endif;
				?>
		</div>
	</div>
	<?php if($hide_prev_next_buttons !== 'yes'): ?>
		<div class="carousel-arrow">
			<a class="carousel-prev" href="#"><i class="icon-angle-left"></i></a>
			<a class="carousel-next" href="#"><i class="icon-angle-right"></i></a>
		</div> 
	<?php endif; ?>
	
	<?php if($hide_pagination_control != 'yes') : ?>
	<div class="kleo-carousel-features-pager carousel-pager"></div>
	<?php endif; ?>
</div><!--end carousel-container-->