<?php if (!defined('FW')) die('Forbidden');

$class = fw_ext_builder_get_item_width('page-builder', $atts['width'] . '/frontend_class');
?>
<?php if (!empty($atts['extraclasses'])) : 
	$extraclass = $atts['extraclasses'];
else :
	$extraclass = "";
endif; ?>
<div class="<?php echo esc_attr($class); ?> <?php echo esc_attr($extraclass); ?>">
	<?php echo do_shortcode($content); ?>
</div>
