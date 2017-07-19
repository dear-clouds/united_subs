

<a href="<?php echo esc_url($atts['link']); ?>" target="<?php echo esc_attr($atts['target']); ?>" class="btn btn-default <?php echo esc_attr($atts['size']); ?>" style="background-color: <?php echo $atts['color']; ?> !important;">
	<?php if(!empty($atts['icon'])) : ?>
		<i class="<?php echo esc_attr( $atts['icon'] ); ?>"></i>
	<?php endif; ?>
	<?php echo esc_html($atts['label']); ?>
</a>