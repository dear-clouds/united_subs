<?php
/**
 * External product add to cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

<p class="cart">
	<a class="button button_theme button_js" href="<?php echo esc_url( $product_url ); ?>" rel="nofollow"><span class="button_icon"><i class="icon-forward"></i></span><span class="button_label"><?php echo $button_text; ?></span></a>
</p>

<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>