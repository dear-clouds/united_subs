<?php
/**
 * Show messages
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! $messages ) return;
?>

<?php foreach ( $messages as $message ) : ?>
	<div class="alert alert_success">
		<div class="alert_icon"><i class="icon-check"></i></div>
		<div class="alert_wrapper"><?php echo wp_kses_post( str_replace( 'button wc-forward', 'wc-forward', $message ) ); ?></div>
		<a class="close" href="#"><i class="icon-cancel"></i></a>
	</div>
<?php endforeach; ?>