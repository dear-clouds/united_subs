<?php
/**
 * Single Product Thumbnails
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

global $post, $product, $woocommerce;

$attachment_ids = $product->get_gallery_attachment_ids();

if ( $attachment_ids  ) {
	
	if ( count($attachment_ids) > 2 ) {
		$wrap_start = '<div class="kleo-gallery kleo-woo-gallery animate-when-almost-visible">'
						. '<div class="kleo-thumbs-carousel kleo-thumbs-animated th-fade" data-min-items="3" data-max-items="4" data-circular="true">';
		$wrap_end = '</div>'
						. '<a class="kleo-thumbs-prev" href="#"><i class="icon-angle-left"></i></a>'
						. '<a class="kleo-thumbs-next" href="#"><i class="icon-angle-right"></i></a>'
						. '</div><!--end carousel-container-->';
	}
	else {
		$wrap_start = '<div class="kleo-woo-gallery thumbnails">';
		$wrap_end = '</div>';
	}

	$loop = 1;
	$columns = apply_filters( 'woocommerce_product_thumbnails_columns', 3 );
	
	echo $wrap_start;
	?>
	
	<?php if ( has_post_thumbnail() ) : ?>
		<?php
		$main_image_src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'shop_single' );
		$image_link = $main_image_src[0];
		$main_full_img = wp_get_attachment_url( get_post_thumbnail_id() );

		?>
		<a data-big-img="<?php echo $main_full_img; ?>" id="product-thumb-0" href="<?php echo $image_link; ?>" class="zoom first selected"><?php echo get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) ) ?></a>
	<?php endif; ?>	
	
	<?php
	foreach ( $attachment_ids as $attachment_id ) {

		$classes = array( 'zoom' );

		$big_image = wp_get_attachment_url( $attachment_id );
        $image_src = wp_get_attachment_image_src( $attachment_id, 'shop_single' );
       	$image_link = $image_src[0];

		if ( ! $image_link )
			continue;

		$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );
		$image_class = esc_attr( implode( ' ', $classes ) );
		$image_title = esc_attr( get_the_title( $attachment_id ) );

		echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<a id="product-thumb-%s" href="%s" class="%s" title="%s" data-big-img="%s">%s</a>', $loop, $image_link, $image_class, $image_title, $big_image, $image ), $attachment_id, $post->ID, $image_class );

		$loop++;
	}
	echo $wrap_end;
}