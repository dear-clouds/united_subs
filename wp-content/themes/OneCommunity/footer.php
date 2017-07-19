<div class="clear"></div>
</div> <!-- #container -->

		<?php do_action( 'bp_after_container' ); ?>

</div><!-- main -->

		<?php do_action( 'bp_before_footer'   ); ?>


<footer>
<div class="footer-left">

<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style addthis_32x32_style">
<a class="addthis_button_compact"><span class="icon-share"> </span></a>
<a class="addthis_counter addthis_bubble_style"></a>
</div>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-50d5ccc825461c61"></script>
<!-- AddThis Button END -->

</div>


<div class="footer-right"><?php _e('All rights reserved by', 'OneCommunity'); ?> <?php bloginfo( 'name' ); ?></div>

</footer>

<?php if ( is_user_logged_in() ) {
   if ( function_exists( 'bp_is_active' ) ) {
	if ( $notifications = bp_notifications_get_notifications_for_user( bp_loggedin_user_id(), $format = 'string' ) ) { ?>
	<div class="notif-container">
	<?php
	}

	if ( $notifications ) {
		$counter = 0;
		for ( $i = 0, $count = count( $notifications ); $i < $count; ++$i ) {
			$alt = ( 0 == $counter % 2 ) ? ' alt' : ''; ?>
			<div class="my-notification<?php echo $alt ?>"><?php echo $notifications[$i] ?></div>

			<?php
			 $counter++;
			} ?>
	</div><!-- notif-container -->
	<?php
	} else {}
   }
}
?>

<?php wp_footer(); ?>

</body>

</html>