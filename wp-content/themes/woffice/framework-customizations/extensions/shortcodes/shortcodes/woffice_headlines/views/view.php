<?php if (!defined('FW')) die( 'Forbidden' );
/**
 * @var $atts
 */
?>
<div class="heading">
<<?php echo esc_attr($atts['heading']);?> >
	<?php echo esc_html($atts['title']); ?>
</<?php echo esc_attr($atts['heading']);?>>
</div>