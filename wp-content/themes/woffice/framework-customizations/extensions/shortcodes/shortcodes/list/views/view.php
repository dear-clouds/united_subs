<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
?>
<ul class="list-styled <?php echo esc_attr($atts['style']); ?>">
	<?php if (!empty($atts['content'])) { ?>
		<?php foreach ( $atts['content'] as $list ) : ?>
			<li><?php echo esc_html($list); ?></li>
		<?php endforeach; ?>
	<?php } ?>
</ul>