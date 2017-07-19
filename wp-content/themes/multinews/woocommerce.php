<?php if ( class_exists( 'woocommerce' ) ) { ?>
<?php get_header(); ?>
<?php
if (is_product()) {
get_template_part( 'woocommerce', 'single' );
} else {
get_template_part( 'woocommerce', 'page' );
}
?>
<?php get_footer(); ?>
<?php } ?>