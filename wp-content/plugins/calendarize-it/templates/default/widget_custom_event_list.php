<?php
/*
Template Name: Event list like (Custom sample)
Template Type: widget_upcoming_events
*/
?><div class="rhc-widget-upcoming-item hide-repeat-date rhc-widget-a">
	<div class="fc-event-list-content">
		<h4>
			<a class='rhc-title-link fc-event-list-title' href="#">[TITLE]</a>
		</h4>
		<div class="fc-event-featured-image" style="display:none;"></div>
		[post_info post_id="<?php echo $post->ID?>"]	
	</div>

	<div class="rhc-clear"></div>
</div>