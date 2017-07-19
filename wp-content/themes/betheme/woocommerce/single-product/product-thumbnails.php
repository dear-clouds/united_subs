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

if ( $attachment_ids ) {
	$loop 		= 0;
	$columns 	= apply_filters( 'woocommerce_product_thumbnails_columns', 3 );
	?>
	<div class="thumbnails <?php echo 'columns-' . $columns; ?>"><?php

		foreach ( $attachment_ids as $attachment_id ) {

			$classes = array( 'zoom' );

			if ( $loop == 0 || $loop % $columns == 0 )
				$classes[] = 'first';

			if ( ( $loop + 1 ) % $columns == 0 )
				$classes[] = 'last';

			$image_link = wp_get_attachment_url( $attachment_id );

			if ( ! $image_link )
				continue;

			$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );
			$image_class = esc_attr( implode( ' ', $classes ) );
			$image_title = esc_attr( get_the_title( $attachment_id ) );
			
			// Disable Image Frames if use external plugin for Featured Images
			if( mfn_opts_get( 'shop-product-images' ) == 'plugin' ){
				
				echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<a href="%s" class="%s" title="%s" data-rel="prettyPhoto[product-gallery]">%s</a>', $image_link, $image_class, $image_title, $image ), $attachment_id, $post->ID, $image_class );
				
			} else { 
				
				echo '<div class="image_frame scale-with-grid" ontouchstart="this.classList.toggle(\'hover\');">';
					echo '<div class="image_wrapper">';
					
						echo '<a href="'. $image_link .'" itemprop="image" class="woocommerce-main-image zoom" title="'. $image_title .'" data-rel="prettyPhoto[product-gallery]">';
							echo '<div class="mask"></div>';
							echo $image;
						echo '</a>';
						
					echo '</div>';
				echo '</div>';
				
			}

			$loop++;
		}

	?></div>
	<?php
}