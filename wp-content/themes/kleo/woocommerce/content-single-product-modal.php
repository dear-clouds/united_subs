 <?php
global $post, $product, $woocommerce;
$attachment_ids = $product->get_gallery_attachment_ids();
?> 

<div class="row">

	<div class="col-lg-7">
			<div class="kleo-product-images">

				<div class="kleo-carousel-container">
					<div class="kleo-carousel-items kleo-carousel-products" data-min-items="1" data-max-items="1">
						<ul class="kleo-carousel">

							<?php if ( has_post_thumbnail() ) : ?>
							
								<?php
									//Get the Thumbnail URL
									$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), false, '' );
								?>

								<li>
									<div class="kleo-product-image" itemprop="image">
									<?php echo woocommerce_get_product_thumbnail( 'shop_single' ) ?>
									</div>
								</li>

							<?php endif; ?>	

							<?php
							if ( $attachment_ids ) {		

								foreach ( $attachment_ids as $attachment_id ) {

									$image_link = wp_get_attachment_url( $attachment_id );

									if ( ! $image_link )
										continue;

									$image = wp_get_attachment_image( $attachment_id, 'shop_single' );
									?>

									<li>
										<div class="kleo-product-image" itemprop="image">
										<?php echo $image; ?>
										</div>
									</li>

									<?php
								}

							}
							?>

						</ul>
					</div>
					<div class="carousel-arrow">
						<a class="carousel-prev" href="#"><i class="icon-angle-left"></i></a>
						<a class="carousel-next" href="#"><i class="icon-angle-right"></i></a>
					</div> 
					<div class="kleo-carousel-post-pager carousel-pager"></div>
				</div>

		</div><!-- .product-image -->

	</div><!-- large-7 -->

	<div class="col-lg-5">
		<div class="product-lightbox-inner product-info">
		<h1 itemprop="name" class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>

		<?php do_action( 'woocommerce_single_product_modal_summary' ); ?>
		</div>
	</div>

</div>

