<?php
/**
 * Show error messages
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! $messages ) return;
?>

<?php foreach ( $messages as $message ) : ?>
	<div class="alert alert_error">
		<div class="alert_icon"><i class="icon-alert"></i></div>
		<div class="alert_wrapper"><?php echo wp_kses_post( $message ); ?></div>
		<a class="close" href="#"><i class="icon-cancel"></i></a>
	</div>
<?php endforeach; ?>