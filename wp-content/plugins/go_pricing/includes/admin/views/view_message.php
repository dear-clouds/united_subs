<?php
/**
 * Message template view
 */


// Prevent direct call
if ( !defined( 'WPINC' ) ) die;
if ( !class_exists( 'GW_GoPricing' ) ) die;
 
?>

<div id="result" class="<?php echo $class; ?>">
	<?php echo $content; ?>
</div>