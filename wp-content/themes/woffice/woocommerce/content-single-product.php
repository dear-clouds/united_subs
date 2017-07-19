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
		 * CHANGED FOR WOFFICE
		 */
		woocommerce_template_single_title(); ?>

	
	<!-- START THE CONTENT CONTAINER -->
	<div id="content-container">

		<!-- START CONTENT -->
		<div id="content">
		
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
			?>		
					
			<?php 
				$post_classes = array('box','content', 'single-project');
			?>

			<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class($post_classes); ?>>
			
				<div class="intern-padding clearfix">
				
					<div class="row">
					<div class="col-md-4">
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
				
					<div class="col-md-8">
						<div class="summary entry-summary">
					
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
					
						</div><!-- .summary -->
					</div>
					</div>
					
						<?php
							/**
							 * woocommerce_after_single_product_summary hook
							 *
							 * @hooked woocommerce_output_product_data_tabs - 10
							 * @hooked woocommerce_output_related_products - 20
							 */
							do_action( 'woocommerce_after_single_product_summary' );
						?>
					
						<meta itemprop="url" content="<?php the_permalink(); ?>" />
						
				</div>
			
			</div><!-- #product-<?php the_ID(); ?> -->
			
			<?php do_action( 'woocommerce_after_single_product' ); ?>
			
			
				
		</div>
			
	</div><!-- END #content-container -->
		
	<?php woffice_scroll_top(); ?>
