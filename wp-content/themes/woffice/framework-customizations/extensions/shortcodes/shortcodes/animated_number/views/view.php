<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
?>
	
	
<div class="animated-number">
	<h1 data-from="0" data-to="<?php echo $atts['number']; ?>"></h1>
	<?php if( !empty($atts['title']) ) : ?>
		<h3><?php echo $atts['title']; ?></h3>
	<?php endif; ?>
</div>