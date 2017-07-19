<?php
/**
 * Display for Event Custom Post Types
 */
global $post;
global $wp;
global $ecwd_options;

$post_id = $post->ID;
$meta    = get_post_meta( $post_id );

$date_format  = 'Y-m-d';
$time_format  = 'H:i';
$ecwd_social_icons = false;
if ( isset( $ecwd_options['date_format'] ) && $ecwd_options['date_format'] != '' ) {
	$date_format = $ecwd_options['date_format'];
}
if ( isset( $ecwd_options['time_format'] ) && $ecwd_options['time_format'] != '' ) {
	$time_format = $ecwd_options['time_format'];
}
$time_format .= (isset( $ecwd_options['time_type'])?' '.$ecwd_options['time_type']: '');
if(isset($ecwd_options['time_type']) && $ecwd_options['time_type'] !=''){
	$time_format = str_replace('H', 'g', $time_format);
	$time_format = str_replace('h', 'g', $time_format);
}
if ( isset( $ecwd_options['social_icons'] ) && $ecwd_options['social_icons'] != '' ) {
	$ecwd_social_icons = $ecwd_options['social_icons'];
}
// Load up all post meta data
$ecwd_event_location = get_post_meta( $post->ID, ECWD_PLUGIN_PREFIX . '_event_location', true );
$ecwd_event_latlong  = get_post_meta( $post->ID, ECWD_PLUGIN_PREFIX . '_lat_long', true );
$ecwd_event_zoom     = get_post_meta( $post->ID, ECWD_PLUGIN_PREFIX . '_map_zoom', true );
if ( ! $ecwd_event_zoom ) {
	$ecwd_event_zoom = 17;
}

$ecwd_event_organizers = get_post_meta( $post->ID, ECWD_PLUGIN_PREFIX . '_event_organizers', true );
$ecwd_event_date_from  = get_post_meta( $post->ID, ECWD_PLUGIN_PREFIX . '_event_date_from', true );
$ecwd_event_date_to    = get_post_meta( $post->ID, ECWD_PLUGIN_PREFIX . '_event_date_to', true );
$ecwd_event_url        = get_post_meta( $post->ID, ECWD_PLUGIN_PREFIX . '_event_url', true );
$ecwd_event_video      = get_post_meta( $post->ID, ECWD_PLUGIN_PREFIX . '_event_video', true );
$ecwd_all_day_event    = get_post_meta( $post->ID, ECWD_PLUGIN_PREFIX . '_all_day_event', true );
$venue                 = '';
$venue_permalink       = '';
$venue_post_id         = get_post_meta( $post->ID, ECWD_PLUGIN_PREFIX . '_event_venue', true );
if ( $venue_post_id ) {
	$venue_post = get_post( $venue_post_id );
	if ( $venue_post ) {
		$venue           = $venue_post->post_title;
		$venue_permalink = get_permalink( $venue_post->ID );
	}
}

$this_event_url = get_permalink( $post->ID );
$organizers     = array();
if ( is_array( $ecwd_event_organizers ) || is_object( $ecwd_event_organizers ) ) {
	foreach ( $ecwd_event_organizers as $ecwd_event_organizer ) {
		$organizers[] = get_post( $ecwd_event_organizer, ARRAY_A );
	}
}
?>

<div class="ecwd-event" itemscope itemtype="http://schema.org/Event">
	<div class="event-detalis">
		<?php if ( $feat_image && $feat_image !== '' ) { ?>
			<div class="event-featured-image">
				<img src="<?php echo $feat_image; ?>"/>
			</div>
		<?php } ?>
		<div class="event-detalis-date">
			<label class="ecwd-event-date-info" title="<?php _e( 'Date', 'ecwd' ); ?>"></label>
			 <span class="ecwd-event-date" itemprop="startDate"
			       content="<?php echo date( 'Y-m-d', strtotime( $ecwd_event_date_from ) ) . 'T' . date( 'H:i', strtotime( $ecwd_event_date_from ) ) ?>">
                 <?php if ( $ecwd_all_day_event == 1 ) {
	                 echo date( $date_format, strtotime( $ecwd_event_date_from ) );
	                 if ( $ecwd_all_day_event == 1 ) {
		                 if ( $ecwd_event_date_to && date( $date_format, strtotime( $ecwd_event_date_from ) ) !== date( $date_format, strtotime( $ecwd_event_date_to ) ) ) {
			                 echo ' - ' . date( $date_format, strtotime( $ecwd_event_date_to ) );
		                 }
		                 echo ' ' . __( 'All day', 'ecwd' );
	                 }
                 } else {
	                 echo date( $date_format, strtotime( $ecwd_event_date_from ) ) . ' ' . date( $time_format, strtotime( $ecwd_event_date_from ) );

	                 if ( $ecwd_event_date_to ) {
		                 echo ' - ' . date( $date_format, strtotime( $ecwd_event_date_to ) ) . ' ' . date( $time_format, strtotime( $ecwd_event_date_to ) );
	                 }
                 } ?>
			 </span>
		</div>
		<?php if ( $ecwd_event_url ) { ?>
			<div class="ecwd-url">

				<a href="<?php echo $ecwd_event_url; ?>" target="_blank"><label class="ecwd-event-url-info"
				                                                                title="<?php _e( 'Url', 'ecwd' ); ?>"></label>    <?php echo $ecwd_event_url; ?>
				</a>
			</div>
		<?php } ?>
		<?php if ( count( $organizers ) > 0 ) { ?>
			<div class="event-detalis-org">
				<label class="ecwd-event-org-info" title="<?php _e( 'Organizers', 'ecwd' ); ?>"></label>
				<?php if ( $organizers ) {
					foreach ( $organizers as $organizer ) { ?>
						<span itemprop="organizer">
						<a href="<?php echo get_permalink( $organizer['ID'] ) ?>"><?php echo $organizer['post_title'] ?></a>
					</span>
					<?php }
				} ?>
			</div>
		<?php } ?>
		<div class="event-venue" itemprop="location" itemscope itemtype="http://schema.org/Place">
			<?php if ( $venue_post_id ) { ?>
				<span itemprop="name"><a href="<?php echo $venue_permalink ?>"><?php echo $venue; ?></a></span>
				<div class="address" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
					<?php echo $ecwd_event_location; ?>
					<?php
					if ( $ecwd_event_latlong ) {
						?>
					<?php } ?>
				</div>

			<?php } elseif ( $ecwd_event_location ) { ?>
                            <span class="ecwd_hidden" itemprop="name"><?php echo $ecwd_event_location; ?></span>
				<div class="address" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
					<?php echo $ecwd_event_location; ?>
				</div>
			<?php } ?>
		</div>
	</div>
	<?php if ( $ecwd_social_icons ) {
		?>
		<div class="ecwd-social">
        <span class="share-links">
			<a href="http://twitter.com/home?status=<?php echo get_permalink( $post_id ) ?>" class="ecwd-twitter"
			   target="_blank" data-original-title="Tweet It">
				<span class="visuallyhidden">Twitter</span></a>
			<a href="http://www.facebook.com/sharer.php?u=<?php echo get_permalink( $post_id ) ?>" class="ecwd-facebook"
			   target="_blank" data-original-title="Share on Facebook">
				<span class="visuallyhidden">Facebook</span></a>
			<a href="http://plus.google.com/share?url=<?php echo get_permalink( $post_id ) ?>" class="ecwd-google-plus"
			   target="_blank" data-original-title="Share on Google+">
				<span class="visuallyhidden">Google+</span></a>
		</span>
		</div>
	<?php } ?>
	<?php
	if ( $ecwd_event_latlong ) {
		$map_events               = array();
		$map_events[0]['latlong'] = explode( ',', $ecwd_event_latlong );
		if ( $ecwd_event_location != '' ) {
			$map_events[0]['location'] = $ecwd_event_location;
		}
		$map_events[0]['zoom']  = $ecwd_event_zoom;
		$map_events[0]['infow'] = '<div class="ecwd_map_event">';
		$map_events[0]['infow'] .= '<span class="location">' . $ecwd_event_location . '</span>';
		$map_events[0]['infow'] .= '</div>';
		$map_events[0]['infow'] .= '<div class="event-detalis-date">
			 <label class="ecwd-event-date-info" title="' . __( 'Date', 'ecwd' ) . '"></label>
			 <span class="ecwd-event-date" itemprop="startDate" content="' . date( 'Y-m-d', strtotime( $ecwd_event_date_from ) ) . 'T' . date( 'H:i', strtotime( $ecwd_event_date_from ) ) . '">';
		if ( $ecwd_all_day_event == 1 ) {
			$map_events[0]['infow'] .= date( $date_format, strtotime( $ecwd_event_date_from ) );
			if ( $ecwd_event_date_to ) {
				$map_events[0]['infow'] .= ' - ' . date( $date_format, strtotime( $ecwd_event_date_to ) ) . '  ' . __( 'All day', 'ecwd' );
			}
		} else {
			$map_events[0]['infow'] .= date( $date_format, strtotime( $ecwd_event_date_from ) ) . ' ' . date( $time_format, strtotime( $ecwd_event_date_from ) );

			if ( $ecwd_event_date_to ) {
				$map_events[0]['infow'] .= date( $date_format, strtotime( $ecwd_event_date_to ) ) . ' ' . date( $time_format, strtotime( $ecwd_event_date_to ) );
			}
		}
		$map_events[0]['infow'] .= ' </span>
		 </div>';

		$markers = json_encode( $map_events );
		?>
		<div class="ecwd-show-map">
			<div class="ecwd_map_div">
			</div>
			<textarea class="hidden ecwd_markers" style="display: none;"><?php echo $markers; ?></textarea>
		</div>
	<?php } ?>
	<div class="clear"></div>
</div>


<div class="ecwd-event-video">
	<?php
	if ( strpos( $ecwd_event_video, 'youtube' ) > 0 ) {
		parse_str( parse_url( $ecwd_event_video, PHP_URL_QUERY ), $video_array_of_vars );
		if ( isset( $video_array_of_vars['v'] ) && $video_array_of_vars['v'] ) {
			?>
			<object data="http://www.youtube.com/v/<?php echo $video_array_of_vars['v'] ?>"
			        type="application/x-shockwave-flash" width="400" height="300">
				<param name="src" value="http://www.youtube.com/v/<?php echo $video_array_of_vars['v'] ?>"/>
			</object>
		<?php }
	} elseif ( strpos( $ecwd_event_video, 'vimeo' ) > 0 ) {
		$videoID = explode( '/', $ecwd_event_video );
		$videoID = $videoID[ count( $videoID ) - 1 ];
		if ( $videoID ) {

			?>
			<iframe
				src="http://player.vimeo.com/video/<?php echo $videoID; ?>?title=0&amp;byline=0&amp;portrait=0&amp;badge=0&amp;color=ffffff"
				width="" height="" frameborder="0" webkitAllowFullScreen mozallowfullscreen
				allowFullScreen></iframe>
		<?php }


	}

	?>
</div>
