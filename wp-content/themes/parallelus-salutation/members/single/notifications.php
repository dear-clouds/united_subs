<div class="item-list-tabs no-ajax" id="subnav">
	<ul class="sub-tabs">
		<?php if ( bp_is_my_profile() ) : ?>
			<?php bp_get_options_nav() ?>
		<?php endif; ?>

		<li id="members-order-select" class="last filter">
			<?php bp_notifications_sort_order_form(); ?>
		</li>
	</ul>
</div>

<?php
  	switch ( bp_current_action() ) :
	    // Unread
	    case 'unread' :
	        bp_get_template_part( 'members/single/notifications/unread' );
	        break;
	  
	    // Read
	    case 'read' :
	        bp_get_template_part( 'members/single/notifications/read' );
	        break;
	  
	    // Any other
	    default :
	        bp_get_template_part( 'members/single/plugins' );
	        break;
  	endswitch;
?>