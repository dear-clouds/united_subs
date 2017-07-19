<?php
/**
 * Empty cart page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

wc_print_notices();

?>

<div class="alert alert alert_warning">
	<div class="alert_icon"><i class="icon-lamp"></i></div>
	<div class="alert_wrapper"><?php _e( 'Your cart is currently empty.', 'woocommerce' ) ?></div>
	<a class="close" href="#"><i class="icon-cancel"></i></a>
</div>

<?php do_action( 'woocommerce_cart_is_empty' ); ?>

<a href="<?php echo apply_filters( 'woocommerce_return_to_shop_redirect', get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="button button_theme button_js">
	<span class="button_icon"><i class="icon-basket"></i></span>
	<span class="button_label"><?php _e( 'Return To Shop', 'woocommerce' ) ?></span>
</a>