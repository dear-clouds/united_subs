<?php
/**
 * Page template view
 */


// Prevent direct call
if ( !defined( 'WPINC' ) ) die;
if ( !class_exists( 'GW_GoPricing' ) ) die; 
 
?>

<div id="go-pricing-admin-wrap" class="wrap gwa-wrap<?php echo $wrapper_class; ?>"<?php echo ( !empty( $settings ) ? ' data-settings="' . $settings . '"' : '' ) ?> data-ajaxerror="<?php echo esc_attr( sprintf( __( 'Oops, AJAX error! Keep getting this message? Please disable AJAX request <a href="%s" target="_blank">here</a> and try again.', 'go_pricing_textdomain' ), admin_url( 'admin.php?page=go-pricing-settings' ) ) ); ?>">
	<div class="gwa-site-loader"><div><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="26" height="26" fill="#464646"><path opacity=".25" d="M16 0 A16 16 0 0 0 16 32 A16 16 0 0 0 16 0 M16 4 A12 12 0 0 1 16 28 A12 12 0 0 1 16 4"></path><path d="M16 0 A16 16 0 0 1 32 16 L28 16 A12 12 0 0 0 16 4z"></path></svg><?php _e('Hey, just a sec!', 'go_pricing_textdomain'); ?></div></div>
	<h2 class="gwa-pheader">
		<div class="gwa-pheader-icon"></div>
		<div class="gwa-pheader-title"><?php echo $title; ?></div>
	</h2>
	<?php echo $content; ?>
</div>