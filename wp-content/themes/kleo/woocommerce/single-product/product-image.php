<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.14
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $woocommerce, $product;

?>
<div class="images col-sm-6">
	<div class="kleo-images-wrapper">
	<?php
		if ( has_post_thumbnail() ) {

			$image_title 		= esc_attr( get_the_title( get_post_thumbnail_id() ) );
			$image_link  		= wp_get_attachment_url( get_post_thumbnail_id() );

			add_filter( 'wp_get_attachment_image_attributes', 'sq_remove_img_srcset');

			$image       		= get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
				'title' => $image_title
				) );

			remove_filter( 'wp_get_attachment_image_attributes', 'sq_remove_img_srcset');

			$attachment_count   = count( $product->get_gallery_attachment_ids() );

			if ( $attachment_count > 0 ) {
				$gallery = '[product-gallery]';
			} else {
				$gallery = '';
			}

			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s">%s</a>', $image_link, $image_title, $image ), $post->ID );

		} else {

			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="Placeholder" />', wc_placeholder_img_src() ), $post->ID );

		}
		echo 	'<div class="woo-main-image-nav"><a class="kleo-woo-prev" href="#"><i class="icon-angle-left"></i></a>'
						. '<a class="kleo-woo-next" href="#"><i class="icon-angle-right"></i></a></div>';
	?>
	
	<?php do_action( 'woocommerce_product_thumbnails' ); ?>
	</div>
</div>