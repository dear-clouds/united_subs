<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<?php
	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked wc_print_notices - 10
	 */
	do_action( 'woocommerce_before_single_product' );
	
	if ( post_password_required() ) {
		echo get_the_password_form();
		return;
	}
	
	// prev & next post -------------------
	$post_prev = get_adjacent_post( false, '', true );
	$post_next = get_adjacent_post( false, '', false );
	$shop_page_id = woocommerce_get_page_id( 'shop' );
	 
	// post classes -----------------------
	$classes = array();
	if( mfn_opts_get( 'share' ) == 'hide-mobile' ){
		$classes[] = 'no-share-mobile';
	} elseif( ! mfn_opts_get( 'share' ) ) {
		$classes[] = 'no-share';
	}
	 
	$translate['all'] = mfn_opts_get('translate') ? mfn_opts_get('translate-all','Show all') : __('Show all','betheme');
?>

<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
	
	<?php if( mfn_opts_get('prev-next-nav') ): ?>
	<div class="post-nav">
				
		<?php 
			// prev & next post navigation
			echo mfn_post_navigation( $post_prev, 'prev', 'icon-left-open-big' ); 
			echo mfn_post_navigation( $post_next, 'next', 'icon-right-open-big' ); 
		?>
		
		<ul class="next-prev-nav">
			<?php if( $post_prev ): ?>
				<li class="prev"><a class="button button_js" href="<?php echo get_permalink( $post_prev ); ?>"><span class="button_icon"><i class="icon-left-open"></i></span></a></li>
			<?php endif; ?>
			<?php if( $post_next ): ?>
				<li class="next"><a class="button button_js" href="<?php echo get_permalink( $post_next ); ?>"><span class="button_icon"><i class="icon-right-open"></i></span></a></li>
			<?php endif; ?>
		</ul>
		
		<?php if( $shop_page_id ): ?>
			<a class="list-nav" href="<?php echo get_permalink( $shop_page_id ); ?>"><i class="icon-layout"></i><?php echo $translate['all']; ?></a>
		<?php endif; ?>
		
	</div>
	<?php endif; ?>

	<div class="product_wrapper clearfix">

		<?php if( mfn_opts_get( 'share' ) ): ?>
			<div class="share_wrapper">
				<span class='st_facebook_vcount' displayText='Facebook'></span>
				<span class='st_twitter_vcount' displayText='Tweet'></span>
				<span class='st_pinterest_vcount' displayText='Pinterest'></span>
				
				<script src="http<?php mfn_ssl(1); ?>://w<?php mfn_ssl(1); ?>.sharethis.com/button/buttons.js"></script>
				<script>stLight.options({publisher: "1390eb48-c3c3-409a-903a-ca202d50de91", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
			</div>
		<?php endif; ?>
	
		<div class="column one-second product_image_wrapper">
			<?php
				/**
				 * woocommerce_before_single_product_summary hook
				 *
				 * @hooked woocommerce_show_product_sale_flash - 10
				 * @hooked woocommerce_show_product_images - 20
				 */
				do_action( 'woocommerce_before_single_product_summary' );	
			?>
		</div>
	
		<div class="column one-second summary entry-summary">
	
			<?php
				/**
				 * woocommerce_single_product_summary hook
				 *
				 * @hooked woocommerce_template_single_title - 5
				 * @hooked woocommerce_template_single_rating - 10
				 * @hooked woocommerce_template_single_price - 10
				 * @hooked woocommerce_template_single_excerpt - 20
				 * @hooked woocommerce_template_single_add_to_cart - 30
				 * @hooked woocommerce_template_single_meta - 40
				 * @hooked woocommerce_template_single_sharing - 50
				 */
				do_action( 'woocommerce_single_product_summary' );
			?>
			
			<?php 
				// Description | Default - right column
				if( in_array( mfn_opts_get( 'shop-product-style' ), array( 'wide', 'wide tabs') ) ) {
					remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
				}
				
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
			?>
			
			<?php
				/**
				 * woocommerce_after_single_product_summary hook
				 *
				 * @hooked woocommerce_output_product_data_tabs - 10
				 * @hooked woocommerce_upsell_display - 15
				 * @hooked woocommerce_output_related_products - 20
				 */
				do_action( 'woocommerce_after_single_product_summary' );
			?>
	
		</div>
		
	</div>
	
	<?php 
		// Description | Default - wide below image
		if( in_array( mfn_opts_get( 'shop-product-style' ), array( 'wide', 'wide tabs') ) ) {
			woocommerce_output_product_data_tabs(); 
		}
	?>
	
	<?php 
		woocommerce_upsell_display();
		if( mfn_opts_get( 'shop-related' ) ) woocommerce_output_related_products(); 
	?>

	<meta itemprop="url" content="<?php the_permalink(); ?>" />

</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>
